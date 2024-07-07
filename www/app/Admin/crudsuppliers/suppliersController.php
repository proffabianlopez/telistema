<?php
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location:../../includes/404/404.php");
    exit();
}

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => ''
];

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1) {
        $response['message'] = 'Acceso denegado.';
        echo json_encode($response);
        exit;
    }

} else {
    $response['message'] = 'Por favor, inicie sesión para continuar.';
    echo json_encode($response);
    exit;
}

include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');




//editar product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_GET['action'] === 'edit_supplier') {
        // Checking for Empty Fields
        if (empty($_REQUEST['supplier_name'])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_REQUEST["phone"])) {
            $response['message'] = 'El campo Teléfono es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } else {
            $id = $_REQUEST['id_supplier'];
            $name = capitalizeWords(trim($_REQUEST['supplier_name']));
            $phone = trim($_REQUEST['phone']);
            $address = capitalizeWords(trim($_REQUEST['address']));
            $stmt = $conn->prepare(SQL_UPDATE_SUPPLIER);
            $stmt->bind_param("sssi", $name, $phone, $address, $id);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Actualizado con exito';
                echo json_encode($response);
                exit;
            } else {
                $response['message'] = 'No se pudo actualizar';
                echo json_encode($response);
                exit;
            }
        }
        echo json_encode($response);
        exit;
    } elseif ($_GET['action'] === 'add_supplier') {
        // Checking for Empty Fields
        if (empty($_REQUEST['supplier_name'])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_REQUEST["phone"])) {
            $response['message'] = 'El campo Teléfono es obligatorio.';
        } elseif (empty($_REQUEST["mail"])) {
            $response['message'] = 'El campo Email es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } else {
            $id = $_REQUEST['id_supplier'];
            $name = capitalizeWords(trim($_REQUEST['supplier_name']));
            $phone = trim($_REQUEST['phone']);
            $mail = trim($_REQUEST['mail']);
            $address = capitalizeWords(trim($_REQUEST['address']));

            // Prepara la consulta
            // $stmt = $conn->prepare(SQL_INSERT_SUPPLIER);

            // // Asocia parámetros y ejecuta la consulta
            // $stmt->bind_param("ssssi", $name, $phone, $mail, $address, $id_state);
            // if ($stmt->execute()) {
            //     $response['status'] = 'success';
            //     $response['message'] = 'Agregado con éxito';
            // } else {
            //     $response['message'] = 'No se pudo agregar: ' . $stmt->error;
            // }

            // Verifica si el correo ya existe en la base de datos
            $stmt = $conn->prepare(SQL_SELECT_SUPPLIER_BY_EMAIL);
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($existing_state);
                $stmt->fetch();

                if ($existing_state == 2) {
                    $response['status'] = 'user_in_deleted';
                    $response['message'] = 'Email esta en la lista de iliminados';
                    // Actualizar usuario si está marcado como eliminado
                    if ($_GET["isUpdate"]) {
                        $update_stmt = $conn->prepare(SQL_UPDATE_SUPPLIER_BY_EMAIL);
                        $update_stmt->bind_param("ssss", $name, $phone, $address, $mail);

                        if ($update_stmt->execute()) {
                            $response['status'] = 'success';
                            $response['message'] = 'Agregado con éxito';
                        } else {
                            $response['message'] = ' Error al agregar! ';
                            echo json_encode($response);
                            exit;
                        }
                    }

                } else {
                    $response['message'] = 'El correo ya existe en la base de datos';
                    echo json_encode($response);
                    exit;
                }
            } else {
                // Prepara la consulta
                $stmt = $conn->prepare(SQL_INSERT_SUPPLIER);

                // Asocia parámetros y ejecuta la consulta
                $stmt->bind_param("ssss", $name, $phone, $mail, $address);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Agregado con éxito';
                } else {
                    $response['message'] = 'No se pudo agregar: ' . $stmt->error;
                }

            }
        }
        echo json_encode($response);
        exit;
    } elseif ($_POST['action'] === 'delete_supplier') {
        $id_supplier = $_POST['id'];

        $stmt = $conn->prepare(SQL_DELETE_SUPPLIER);

        // Asocia parámetros y ejecuta la consulta
        $stmt->bind_param("i", $id_supplier);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Eliminado';
        } else {
            $response['message'] = 'Error al eliminar: ' . $stmt->error;
        }
        echo json_encode($response);
        exit;
    } else {
        $response['message'] = 'Acción no válida';
        echo json_encode($response);
        exit;
    }
} else {
    $response['message'] = 'Fallo la operación';
    echo json_encode($response);
    exit;
}
?>