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
            $id_state = $_REQUEST['id_state_user'];
        
            $stmt = $conn->prepare(SQL_UPDATE_SUPPLIER);
            $stmt->bind_param("ssssii", $name, $phone, $mail, $address, $id_state, $id);
        
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
            $id_state = $_REQUEST['id_state_user'];
            $id_state = 1; // ¿Este valor siempre será 1?

            // Prepara la consulta
            $stmt = $conn->prepare(SQL_INSERT_SUPPLIER);
        
            // Asocia parámetros y ejecuta la consulta
            $stmt->bind_param("ssssi", $name, $phone, $mail, $address, $id_state);
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Agregado con éxito';
            } else {
                $response['message'] = 'No se pudo agregar: ' . $stmt->error;
            }
        }
        echo json_encode($response);
        exit;

    } elseif ($_POST['action'] === 'delete_supplier') {
        $id_supplier = $_REQUEST['id_supplier'];

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