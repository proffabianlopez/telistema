<?php
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location: ../../includes/404.php");
    exit();
}

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => ''
];

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_role'] != 'admin') {
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
        if (empty($_REQUEST['order_date'])) {
            $response['message'] = 'El campo Fecha es obligatorio.';
        } elseif (empty($_REQUEST["order_hour"])) {
            $response['message'] = 'El campo Hora es obligatorio.';
        } elseif (empty($_REQUEST["order_description"])) {
            $response['message'] = 'El campo Descripcion es obligatorio.';
        } elseif (empty($_REQUEST["order_server"])) {
            $response['message'] = 'El campo Servidor es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } else {
            // Assigning User Values to Variable
            $order_date = $_POST['order_date'];
            $order_hour = $_POST['order_hour'];
            $order_description = $_POST['order_description'];
            $order_server = $_POST['order_server'];
            $address = capitalizeWords($_POST['address']);
            $height = $_POST['height'];
            $floor = trim($_POST['floor']);
            $departament = trim($_POST['departament']);
            $id_client = $_POST['id_client'];
            $id_priority = trim($_POST['id_priority']);
            $id_material = trim($_POST['id_material']);
            $id_state_order = trim($_POST['id_state_order']);
            $technic_id = trim($_POST['technic_id']);
            $id_order = $_POST['id_order'];

            $sql = SQL_UPDATE_ORDER;
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssisissiiiiii",
                $order_date,
                $order_hour,
                $order_description,
                $order_server,
                $address,
                $height,
                $floor,
                $departament,
                $id_client,
                $id_priority,
                $id_material,
                $id_state_order,
                $technic_id,
                $id_order
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
        // Checking for Empty Fields
        $id_client = $_SESSION['id_client'];
        if (empty($_REQUEST['order_date'])) {
            $response['message'] = 'El campo Fecha es obligatorio.';
        } elseif (empty($_REQUEST["order_hour"])) {
            $response['message'] = 'El campo Hora es obligatorio.';
        } elseif (empty($_REQUEST["order_description"])) {
            $response['message'] = 'El campo Descripcion es obligatorio.';
        } elseif (empty($_REQUEST["order_server"])) {
            $response['message'] = 'El campo Servidor es obligatorio.';
        } elseif (empty($_REQUEST["address"])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } else {
            $order_date = $_POST['order_date'];
            $order_hour = $_POST['order_hour'];
            $order_description = $_POST['order_description'];
            $order_server = $_POST['order_server'];
            $address = capitalizeWords($_POST['address']);
            $height = $_POST['height'];
            $floor = trim($_POST['floor']);
            $departament = trim($_POST['departament']);
            $id_priority = $_POST['id_priority'];
            $id_material = $_POST['id_material'];
            $id_state_order = 3;
            $admin_id = $_POST['admin_id'];
            $technic_id = $_POST['technic_id'];

            $stmt = $conn->prepare(SQL_INSERT_ORDER);
            $stmt->bind_param("sssisissiiiiii", $order_date, $order_hour, $order_description, $order_server, $address, $height, $floor, $departament, $id_client, $id_priority, $id_material, $id_state_order, $admin_id, $technic_id);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Agregado con éxito';
            } else {
                $response['message'] = 'No se pudo agregar: ' . $stmt->error;
            }
        }
        echo json_encode($response);
        exit;

    } elseif ($_POST['action'] === 'delete_order') {
        $id = explode('*', $_POST['id']);
        $id_order = $id[0];
        $id_client = $id[1];
        $stmt = $conn->prepare(SQL_DELETE_ORDER);
        $stmt->bind_param("ii", $id_client, $id_order);

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