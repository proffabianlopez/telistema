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
        exit();
    }
} else {
    $response['message'] = 'Por favor, inicie sesión para continuar.';
    echo json_encode($response);
    exit();
}

include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../configsmtp/generate_config.php');

// Editar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'edit_buy') {
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
            $id_buy = $_REQUEST['id_buy'];
            $date_buy = new DateTime();
            $formatted_date_buy = $date_buy->format('Y-m-d H:i:s');
            $ammount = $_REQUEST['ammount'];
            $cost = $_REQUEST['cost'];
            $id_supplier = $_REQUEST['id_supplier'];
            $id_material = $_REQUEST['id_material'];
            $id_measure = $_REQUEST['id_measure'];
            $id_user = $_SESSION['user_id'];

            $stmt = $conn->prepare(SQL_UPDATE_BUY);
            $stmt->bind_param("sidiiiii", $formatted_date_buy, $ammount, $cost, $id_supplier, $id_material, $id_measure, $id_user, $id_buy);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Actualizado con éxito';
            } else {
                $response['message'] = 'No se pudo actualizar: ' . $stmt->error;
            }
            echo json_encode($response);
            exit();
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'add_buy') {
        // Checking for Empty Fields
        if (empty($_POST["id_material"])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_POST["id_supplier"])) {
            $response['message'] = 'El campo Proveedor es obligatorio.';
        } elseif (empty($_POST["cost"])) {
            $response['message'] = 'El campo Costo es obligatorio.';
        } elseif (empty($_POST["ammount"])) {
            $response['message'] = 'El campo Cantidad es obligatorio.';
        } else {
            // Getting the values from POST
            $date_buy = new DateTime();
            $formatted_date_buy = $date_buy->format('Y-m-d H:i:s');
            $ammount = $_POST['ammount'];
            $cost = $_POST['cost'];
            $id_supplier = $_POST['id_supplier'];
            $id_material = $_POST['id_material'];
            $id_user = $_SESSION['user_id'];
            $id_state_order = 3; // Asigna el estado predeterminado
    
            // Obtener el id_measure basado en el id_material
            $id_measure = getIdMeasureBasedOnMaterial($id_material, $conn);
    
            if ($id_measure === null) {
                $response['message'] = 'El material seleccionado no tiene una unidad de medida válida.';
            } else {
                // Preparar la consulta con el campo id_measure añadido
                $stmt = $conn->prepare(SQL_INSERT_BUY);
                $stmt->bind_param("sidiiiii", $formatted_date_buy, $ammount, $cost, $id_supplier, $id_material, $id_measure, $id_user, $id_state_order);
    
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Agregado con éxito';
                } else {
                    $response['message'] = 'No se pudo agregar: ' . $stmt->error;
                }
            }
        }
        echo json_encode($response);
        exit();
    }elseif (isset($_POST['action']) && $_POST['action'] === 'complete_buy') {
        $id_buy = $_POST['id'];

        $stmt = $conn->prepare(SQL_MODIFY_STATUS_BUY);
        $stmt->bind_param("i", $id_buy);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Completado';
        } else {
            $response['message'] = 'Error al completar: ' . $stmt->error;
        }
        echo json_encode($response);
        exit();
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_buy') {
        $id_buy = $_POST['id'];

        $stmt = $conn->prepare(SQL_MODIFY_CANCEL_BUY);
        $stmt->bind_param("i", $id_buy);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Eliminado';
        } else {
            $response['message'] = 'Error al eliminar: ' . $stmt->error;
        }
        echo json_encode($response);
        exit();
    } else {
        $response['message'] = 'Acción no válida';
        echo json_encode($response);
        exit();
    }
} else {
    $response['message'] = 'Fallo la operación';
    echo json_encode($response);
    exit();
}


function getIdMeasureBasedOnMaterial($id_material, $conn) {
    $sql = SQL_SELECT_MEASURE;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_material);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? $row['id_measure'] : null;
}