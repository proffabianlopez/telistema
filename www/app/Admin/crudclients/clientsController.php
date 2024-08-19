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

    if ($_GET['action'] === 'edit_client') {
        // Checking for Empty Fields
        if (empty($_REQUEST['client_name'])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_REQUEST["client_lastname"])) {
            $response['message'] = 'El campo Apellido es obligatorio.';
        } elseif (empty($_REQUEST["phone"])) {
            $response['message'] = 'El campo Teléfono es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } elseif (empty($_REQUEST["height"])) {
            $response['message'] = 'El campo Altura es obligatorio.';
        } else {
            // Assigning User Values to Variable
            $id_client = $_REQUEST['id_client'];
            $name = capitalizeWords(trim($_REQUEST['client_name']));
            $lastname = capitalizeWords(trim($_REQUEST['client_lastname']));
            $phone = trim($_REQUEST['phone']);
            $address = capitalizeWords(trim($_REQUEST['address']));
            $height = trim($_REQUEST['height']);
            $floor = trim($_REQUEST['floor']);
            $departament = trim($_REQUEST['departament']);

            $sql = SQL_UPDATE_CLIENT;
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $name, $lastname, $phone, $address, $height, $floor, $departament, $id_client);

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
    } elseif ($_GET['action'] === 'add_client') {
        if (empty($_REQUEST['client_name'])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_REQUEST["client_lastname"])) {
            $response['message'] = 'El campo Apellido es obligatorio.';
        } elseif (empty($_REQUEST["phone"])) {
            $response['message'] = 'El campo Teléfono es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } elseif (empty($_REQUEST["height"])) {
            $response['message'] = 'El campo Altura es obligatorio.';
        } else {
            // Assigning User Values to Variable
            $id_client = $_REQUEST['id_client'];
            $name = capitalizeWords(trim($_REQUEST['client_name']));
            $lastname = capitalizeWords(trim($_REQUEST['client_lastname']));
            $phone = trim($_REQUEST['phone']);
            $mail = trim($_REQUEST['mail']);
            $address = capitalizeWords(trim($_REQUEST['address']));
            $height = trim($_REQUEST['height']);
            $floor = trim($_REQUEST['floor']);
            $departament = trim($_REQUEST['departament']);


            //     // Prepara la consulta
            //     $stmt = $conn->prepare(SQL_INSERT_CLIENT);

            //     // Asocia parámetros y ejecuta la consulta
            //     $stmt->bind_param("ssssssssi", $name, $lastname, $phone, $mail, $address, $height, $floor, $departament, $id_state);

            //     if ($stmt->execute()) {
            //         $response['status'] = 'success';
            //         $response['message'] = 'Agregado con éxito';
            //     } else {
            //         $response['message'] = 'No se pudo agregar: ' . $stmt->error;
            //     }
            // }
            // echo json_encode($response);
            // exit;


            // Verifica si el correo ya existe en la base de datos
            $stmt = $conn->prepare(SQL_SELECT_CLIENT_BY_EMAIL);
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
                        $update_stmt = $conn->prepare(SQL_UPDATE_CLIENT_BY_EMAIL);
                        $update_stmt->bind_param("sssssiss", $name, $lastname, $phone, $address, $height, $floor, $departament, $mail);

                        if ($update_stmt->execute()) {
                            $response['status'] = 'success';
                            $response['message'] = 'Agregado con éxito';
                            echo json_encode($response);
                            exit;
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
                $stmt = $conn->prepare(SQL_INSERT_CLIENT);

                // Asocia parámetros y ejecuta la consulta
                $stmt->bind_param("sssssiss", $name, $lastname, $phone, $mail, $address, $height, $floor, $departament);

                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Agregado con éxito';
                    echo json_encode($response);
                    exit;
                } else {
                    $response['message'] = 'No se pudo agregar: ' . $stmt->error;
                    echo json_encode($response);
                    exit;
                }
            }
        }
        echo json_encode($response);
        exit;

    } elseif ($_POST['action'] === 'delete_client') {
        $id_client = $_POST['id'];
        $stmt1 = $conn->prepare(SQL_VERIFIC_ORDER_CLIENT);
        $stmt1->bind_param("i", $id_client);
        $stmt1->execute();

        $stmt1->store_result();

        if ($stmt1->num_rows == 0) {
            $stmt = $conn->prepare(SQL_DELETE_CLIENT);
            $stmt->bind_param("i", $id_client);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Eliminado';
                echo json_encode($response);
                exit;
            } else {
                $response['message'] = 'Error al eliminar: ' . $stmt->error;
                echo json_encode($response);
                exit;
            }
        } else {
            $response['message'] = "No podes elimanar ";
            $response['message1'] = "El Cliente tiene Reclamos Pendientes o en Andamiento";
            echo json_encode($response);
            exit;
        }
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