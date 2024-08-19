<?php
session_start();

if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    header("Location:../../includes/404/404.php");
    exit();
}

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => ''
];

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 2) {
        $response['message'] = 'Acceso denegado.';
        echo json_encode($response);
        exit;
    }
} else {
    $response['message'] = 'Por favor, inicie sesión para continuar.';
    echo json_encode($response);
    exit;
}

include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../Admin/configsmtp/generate_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_GET['action'] === 'edit_order_technic') {
        if (empty($_POST['order_description'])) {
            $response['message'] = 'El campo Descripción es obligatorio.';
        } elseif (empty($_POST['address'])) {
            $response['message'] = 'El campo Dirección es obligatorio.';
        } else {
            $order_description = $_POST['order_description'];
            $address = capitalizeWords($_POST['address']);
            $height = $_POST['height'];
            $floor = trim($_POST['floor']);
            $departament = trim($_POST['departament']);
            $id_client = $_POST['id_client'];
            $id_priority = trim($_POST['id_priority']);
            $id_state_order = trim($_POST['id_state_order']);
            $technic_id = trim($_POST['technic_id']);
            $id_order = $_POST['id_order'];

            $ruta_imagen = '';

            if (isset($_FILES['name_image']) && $_FILES['name_image']['error'] === UPLOAD_ERR_OK) {
                $archivo_temporal = $_FILES['name_image']['tmp_name'];
                $nombre_archivo = basename($_FILES['name_image']['name']);
                $directorio_destino = '../../img/';

                if (!file_exists($directorio_destino)) {
                    if (!mkdir($directorio_destino, 0777, true)) {
                        $response['message'] = 'Error al crear el directorio de destino.';
                        echo json_encode($response);
                        exit;
                    }
                }

                if (move_uploaded_file($archivo_temporal, $directorio_destino . $nombre_archivo)) {
                    $ruta_imagen = $directorio_destino . $nombre_archivo;
                } else {
                    $response['message'] = 'Error al subir el archivo.';
                    echo json_encode($response);
                    exit;
                }
            } elseif (empty($ruta_imagen)) {
                $response['message'] = 'La imagen es obligatoria.';
                echo json_encode($response);
                exit;
            }
            if (empty($ruta_imagen) || !is_numeric($id_order)) {
                $response['message'] = 'Datos inválidos.';
                echo json_encode($response);
                exit;
            }

            $stmt = $conn->prepare(SQL_INSERT_IMG_ORDER);
            if ($stmt === false) {
                $response['message'] = 'Error en la preparación de la consulta: ' . $conn->error;
                echo json_encode($response);
                exit;
            }

            $stmt->bind_param("si", $ruta_imagen, $id_order);
            if (!$stmt->execute()) {
                $response['message'] = 'No se pudo agregar la imagen: ' . $stmt->error;
                $stmt->close();
                echo json_encode($response);
                exit;
            }
            $stmt->close();

            $sql = SQL_UPDATE_ORDER_TECHNIC; 
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $response['message'] = 'Error en la preparación de la consulta de actualización: ' . $conn->error;
                echo json_encode($response);
                exit;
            }

            $stmt->bind_param(
                "ssissiiiii",
                $order_description,
                $address,
                $height,
                $floor,
                $departament,
                $id_client,
                $id_priority,
                $id_state_order,
                $technic_id,
                $id_order
            );

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Actualizado con éxito';
            } else {
                $response['message'] = 'No se pudo actualizar: ' . $stmt->error;
            }
            $stmt->close();

            echo json_encode($response);
            exit;
        }
    }
} else {
    $response['message'] = 'Fallo la operación';
    echo json_encode($response);
    exit;
}

