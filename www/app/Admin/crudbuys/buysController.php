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

    if ($_GET['action'] === 'edit_buy') {
        // Checking for Empty Fields
        if (empty($_REQUEST["material_name"])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_REQUEST["description"])) {
            $response['message'] = 'El campo Descripcion es obligatorio.';
        } elseif (empty($_REQUEST["id_measure"])) {
            $response['message'] = 'El campo Medida es obligatorio.';
        } else {
            // Assigning User Values to Variable
            $id = $_REQUEST['id_material'];
            $id_measure = $_REQUEST['id_measure'];
            $name = capitalizeWords(trim($_REQUEST['material_name']));
            $description = capitalizeWords(trim($_REQUEST['description']));
            
            $stmt = $conn->prepare(SQL_UPDATE_PRODUCT);
            $stmt->bind_param("ssii", $name, $description, $id_measure, $id);

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
    } elseif ($_GET['action'] === 'add_buy') {
        // Checking for Empty Fields
        if (empty($_REQUEST["id_material"])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_REQUEST["id_measure"])) {
            $response['message'] = 'El campo Medida es obligatorio.';
        } elseif (empty($_REQUEST["id_supplier"])) {
            $response['message'] = 'El campo Proveedor es obligatorio.';
        } elseif (empty($_REQUEST["cost"])) {
            $response['message'] = 'El campo Costo es obligatorio.';
        } elseif (empty($_REQUEST["ammount"])) {
            $response['message'] = 'El campo Cantidad es obligatorio.';
        } else {
            
            $date_buy = new DateTime();
            $formatted_date_buy = $date_buy->format('Y-m-d H:i:s');
            $ammount = $_REQUEST['ammount'];
            $cost = $_REQUEST['cost'];
            $id_supplier = $_REQUEST['id_supplier'];
            $id_material = $_REQUEST['id_material'];
            $id_measure = $_REQUEST['id_measure'];
            $id_user = $_SESSION['user_id'];
            $id_state_order = 3; // Asigna el estado predeterminado
            
            $stmt = $conn->prepare(SQL_INSERT_BUY);
            $stmt->bind_param("sidiiiii", $formatted_date_buy, $ammount, $cost, $id_supplier, $id_material, $id_measure, $id_user, $id_state_order);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Agregado con éxito';
            } else {
                $response['message'] = 'No se pudo agregar: ' . $stmt->error;
            }
        }
        echo json_encode($response);
        exit;

    } elseif ($_POST['action'] === 'delete_buy') {
        $id_product = $_POST['id'];

        $stmt = $conn->prepare(SQL_DESACTIVE_PRODUCT);
        $stmt->bind_param("i", $id_product);

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