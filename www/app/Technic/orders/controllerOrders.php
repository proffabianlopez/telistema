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
        if (empty($_POST['id_state_order'])) {
            $response['message'] = 'El campo Estado es obligatorio.';
        } elseif (empty($_POST['report_technic'])) {
            $response['message'] = 'El campo Reporte es obligatorio.';
        } else {
            $id_state_order = trim($_POST['id_state_order']);
            $report_technic = $_POST['report_technic'];
            $id_order = $_POST['id_order'];

            // Validar si hay múltiples imágenes
            if (isset($_FILES['name_image']) && count($_FILES['name_image']['name']) > 0) {
                $directorio_destino = '../../img/';

                if (!file_exists($directorio_destino)) {
                    if (!mkdir($directorio_destino, 0777, true)) {
                        $response['message'] = 'Error al crear el directorio de destino.';
                        echo json_encode($response);
                        exit;
                    }
                }

                // Procesar cada imagen
                foreach ($_FILES['name_image']['tmp_name'] as $key => $archivo_temporal) {
                    if ($_FILES['name_image']['error'][$key] === UPLOAD_ERR_OK) {
                        $nombre_archivo = basename($_FILES['name_image']['name'][$key]);

                        // Mover archivo al directorio de destino
                        if (move_uploaded_file($archivo_temporal, $directorio_destino . $nombre_archivo)) {
                            $ruta_imagen = $directorio_destino . $nombre_archivo;

                            // Insertar ruta de imagen en la base de datos
                            $stmt = $conn->prepare(SQL_INSERT_IMG_ORDER);
                            if ($stmt === false) {
                                $response['message'] = 'Error en la preparación de la consulta: ' . $conn->error;
                                echo json_encode($response);
                                exit;
                            }
                            $stmt->bind_param("si", $ruta_imagen, $id_order);
                            if (!$stmt->execute()) {
                                $response['message'] = 'No se pudo agregar la imagen: ' . $stmt->error;
                                echo json_encode($response);
                                exit;
                            }
                        } else {
                            $response['message'] = 'Error al subir el archivo: ' . $nombre_archivo;
                            echo json_encode($response);
                            exit;
                        }
                    }
                }
            }
            // Validar si se enviaron materiales y cantidades
            if (isset($_POST['materials']) && isset($_POST['quantities'])) {
                $materials = $_POST['materials'];
                $quantities = $_POST['quantities'];

                foreach ($materials as $index => $material_id) {
                    $quantity = $quantities[$index];

                    // Verificar si el material y la cantidad no están vacíos
                    if (!empty($material_id) && !empty($quantity) && is_numeric($quantity)) {

                        // Actualizar el stock en una sola consulta
                        $sql_update_stock = SQL_UPDATE_STOCK;
                        $stmt_update = $conn->prepare($sql_update_stock);
                        if ($stmt_update === false) {
                            $response['message'] = 'Error al preparar la consulta de actualización de materiales: ' . $conn->error;
                            echo json_encode($response);
                            exit;
                        }

                        // Bind de parámetros: restamos "quantity" y verificamos que "stock" sea mayor o igual a "quantity"
                        $stmt_update->bind_param("iii", $quantity, $material_id, $quantity);

                        // Ejecutar la consulta y verificar si realmente se actualizó el stock
                        if (!$stmt_update->execute()) {
                            $response['message'] = "Error al actualizar la cantidad del material ID: $material_id.";
                            echo json_encode($response);
                            exit;
                        }

                        if ($stmt_update->affected_rows === 0) {
                            $response['message'] = "No se pudo restar del material ID: $material_id, la cantidad solicitada excede el stock disponible.";
                            echo json_encode($response);
                            exit;
                        }

                        $stmt_update->close();
                    }
                }
            }

            // Actualizar la orden
            $sql = SQL_UPDATE_ORDER_TECHNIC;
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $response['message'] = 'Error en la preparación de la consulta de actualización: ' . $conn->error;
                echo json_encode($response);
                exit;
            }

            $stmt->bind_param("isi", $id_state_order, $report_technic, $id_order);

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
}