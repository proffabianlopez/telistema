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
    if ($_SESSION['user_idRol'] != 1 ) {
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

    if ($_GET['action'] === 'edit_order') {
        // Checking for Empty Fields
        if (empty($_REQUEST['order_description'])) {
            $response['message'] = 'El campo Descripcion es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } else {
            // Assigning User Values to Variable
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $order_date = date('Y-m-d H:i:s');
            $order_description = $_POST['order_description'];
            $address = capitalizeWords($_POST['address']);
            $height = $_POST['height'];
            $floor = trim($_POST['floor']);
            $departament = trim($_POST['departament']);
            $cuicuit_number = $_POST['circuit_number'];
            $id_type_work = $_POST['id_type_work'];
            $id_client = $_POST['id_client'];
            $id_priority = trim($_POST['id_priority']);
            $id_state_order = trim($_POST['id_state_order']);
            $technic_id = trim($_POST['technic_id']);
            $id_order = $_POST['id_order'];

            $sql = SQL_UPDATE_ORDER;
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssissiiiiiii", $order_date, $order_description, $address, $height, $floor, $departament, $cuicuit_number, $id_type_work, $id_client, $id_priority, $id_state_order, $technic_id, $id_order
            );
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
    } elseif ($_GET['action'] === 'add_order') {
        if (empty($_REQUEST['order_description'])) {
            $response['message'] = 'El campo Descripcion es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } else {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $order_date = date('Y-m-d H:i:s');
            $order_description = $_POST['order_description'];
            $address = capitalizeWords($_POST['address']);
            $height = $_POST['height'];
            $floor = trim($_POST['floor']);
            $departament = trim($_POST['departament']);
            $cuicuit_number = $_POST['cuicuit_number'];
            $id_type_work = $_POST['id_type_work'];
            $id_client = $_POST['id_client'];
            $id_priority = $_POST['id_priority'];
            $id_state_order = 3;
            $admin_id = $_POST['admin_id'];
            $technic_id = $_POST['technic_id'];

            // Obtener la fecha actual
            $current_date = date('Y-m-d');

            // Verificar si el número de circuito ya existe en la fecha actual
            $stmt = $conn->prepare(SQL_SELECT_NCUICUIT);
            $stmt->bind_param("isi", $cuicuit_number, $current_date, $technic_id);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            // Si existe, mostrar un mensaje de error
            if ($count > 0) {
                $response['message'] = 'El número de circuito ya existe para el día de hoy.';
            }else{
                $stmt = $conn->prepare(SQL_INSERT_ORDER);
            $stmt->bind_param("sssissiiiiiii", $order_date, $order_description, $address, $height, $floor, $departament, $cuicuit_number, $id_type_work, $id_client, $id_priority, $id_state_order, $admin_id, $technic_id);
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

    } elseif ($_POST['action'] === 'delete_order') {
        $id = explode('*', $_POST['id']);
        $id_order = $id[0];
        $stmt = $conn->prepare(SQL_DELETE_ORDER);
        $stmt->bind_param("i", $id_order);

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
