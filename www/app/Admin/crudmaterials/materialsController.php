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

    if ($_GET['action'] === 'edit_product') {
        // Checking for Empty Fields
        if (empty($_POST["material_name"])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_POST["description"])) {
            $response['message'] = 'El campo Descripcion es obligatorio.';
        } elseif (empty($_POST["id_measure"])) {
            $response['message'] = 'El campo Medida es obligatorio.';
        } 
        
        else {

            // Assigning User Values to Variable
            $id = $_REQUEST['id_material'];
            $measure = $_REQUEST['id_measure'];
            $name = capitalizeWords(trim($_REQUEST['material_name']));
            $description = capitalizeWords(trim($_REQUEST['description']));
            
            
            $stmt = $conn->prepare(SQL_UPDATE_PRODUCT);
            $stmt->bind_param("ssii", $name, $description, $measure, $id);

            if ($stmt->execute()) {
                // below msg display on form submit success
                $response['status'] = 'success';
                $response['message'] = 'Actualizado con exito';
                echo json_encode($response);
                exit;

            } else {
                // below msg display on form submit failed
                $response['message'] = 'No se pudo actualizar: ';
                echo json_encode($response);
                exit;
            }
        }
        echo json_encode($response);
        exit;

    } elseif ($_GET['action'] === 'add_product') {
        // Checking for Empty Fields
        if (empty($_POST["material_name"])) {

            $response['message'] = 'El campo Nombre es obligatorio.';
        
        } elseif (empty($_POST["description"])) {
        
            $response['message'] = 'El campo Descripcion es obligatorio.';
        
        } elseif (empty($_POST["id_measure"])) {
        
            $response['message'] = 'El campo Medida es obligatorio.';
        
        }  else {
        
            // Assigning User Values to Variable
            $id = $_REQUEST['id_material'];
            $id_status = 1;
            $measure = $_REQUEST['id_measure'];
            $name = capitalizeWords(trim($_REQUEST['material_name']));
            $description = capitalizeWords(trim($_REQUEST['description']));
            
            
            $stmt = $conn->prepare(SQL_INSERT_PRODUCT);
            $stmt->bind_param("ssii", $name, $description, $measure, $id_status);

            if ($stmt->execute()) {
                // below msg display on form submit success
                $response['status'] = 'success';
                $response['message'] = 'Agregado con exito';
                echo json_encode($response);
                exit;

            } else {
                // below msg display on form submit failed
                $response['message'] = 'No se pudo agregar: ';
                echo json_encode($response);
                exit;
            }
        }
        echo json_encode($response);
        exit;
    } elseif ($_POST['action'] === 'delete_product') {

        $id_product = $_POST['id'];

        $stmt = $conn->prepare(SQL_DELETE_PRODUCT);

        // Asocia parámetros y ejecuta la consulta
        $stmt->bind_param("i", $id_product);

        if ($stmt->execute()) {

            $response['status'] = 'success';
            $response['message'] = 'Eliminado';
            echo json_encode($response);
            exit;
        } else {
            $response['message'] = "Error al eliminar";
            echo json_encode($response);
            exit;
        }
    }
    echo json_encode($response);
    exit;
} else {
    $response['message'] = 'Fallo la opeación';
    echo json_encode($response);
    exit;
}
?>