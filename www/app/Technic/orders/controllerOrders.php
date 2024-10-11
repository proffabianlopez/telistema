<?php
session_start();

// Verificar sesión y token
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    header("Location:../../includes/404/404.php");
    exit();
}

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => ''
];

// Verificar si el usuario está activo y tiene el rol adecuado
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

// Incluir conexiones y configuraciones
include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../Admin/configsmtp/generate_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    if (empty($_POST['id_state_order'])) {
        $response['message'] = 'El campo Estado es obligatorio.';
    } elseif (empty($_POST['report_technic'])) {
        $response['message'] = 'El campo Reporte es obligatorio.';
    } else {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $order_date = date('Y-m-d H:i:s');
        $id_state_order = trim($_POST['id_state_order']);
        $report_technic = $_POST['report_technic'];
        $id_order = $_POST['id_order'];

        // Verificar que solo se permiten los estados 3 y 4
        if ($id_state_order != 3 && $id_state_order != 4) {
            $response['message'] = 'Estado no válido. Solo se permiten "Pendiente" o "Realizada".';
            echo json_encode($response);
            exit;
        }
            // Validar si se enviaron materiales y cantidades
            if (isset($_POST['materials']) && isset($_POST['quantities'])) {
                $materials = $_POST['materials'];
                $quantities = $_POST['quantities'];

                foreach ($materials as $index => $material_id) {
                    $stock = $quantities[$index];

                    // Verificar si el material y la cantidad no están vacíos
                    if (!empty($material_id) && !empty($stock) && is_numeric($stock)) {
                        // Actualizar stock en una sola operación
                        $stmt_update = $conn->prepare(SQL_UPDATE_STOCK);
                        if ($stmt_update === false) {
                            $response['message'] = 'Error al preparar la consulta de actualización de materiales: ' . $conn->error;
                            echo json_encode($response);
                            exit;
                        }

                        // El tercer parámetro es la cantidad que se requiere restar
                        $stmt_update->bind_param("iii", $stock, $material_id, $stock);
                        if (!$stmt_update->execute()) {
                            $response['message'] = "Error al actualizar la cantidad del material ID: $material_id o no hay suficiente stock.";
                            echo json_encode($response);
                            exit;
                        }

                        // Verificar si realmente se actualizó el stock
                        if ($stmt_update->affected_rows === 0) {
                            $response['message'] = "No se puede restar más de la cantidad disponible para el material ID: $material_id.";
                            echo json_encode($response);
                            exit;
                        }
                        $stmt_update->close();
                    }
                }
            }

            // Validar si hay múltiples imágenes
            if (isset($_FILES['name_image']) && !empty($_FILES['name_image']['name'][0])) {
                $directorio_destino = '../../img/reports/';

                // Crear directorio si no existe
                if (!file_exists($directorio_destino)) {
                    if (!mkdir($directorio_destino, 0777, true)) {
                        $response['message'] = 'Error al crear el directorio de destino.';
                        echo json_encode($response);
                        exit;
                    }
                }

                // Tipos de archivos permitidos
                $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif'];

                // Procesar cada imagen
                foreach ($_FILES['name_image']['tmp_name'] as $key => $archivo_temporal) {
                    if ($_FILES['name_image']['error'][$key] === UPLOAD_ERR_OK) {
                        $nombre_archivo = basename($_FILES['name_image']['name'][$key]);
                        $ruta_imagen = $directorio_destino . $nombre_archivo;

                        // Validar el tipo de archivo
                        $tipo_archivo = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
                        if (!in_array($tipo_archivo, $tipos_permitidos)) {
                            $response['message'] = 'El tipo de archivo no es permitido: ' . $nombre_archivo;
                            echo json_encode($response);
                            exit;
                        }

                        // Comprobar si el archivo ya existe
                        if (file_exists($ruta_imagen)) {
                            $response['message'] = 'El archivo ' . $nombre_archivo . ' ya existe.';
                            echo json_encode($response);
                            exit;
                        }

                        // Mover archivo al directorio de destino
                        if (move_uploaded_file($archivo_temporal, $ruta_imagen)) {
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
                    } else {
                        $response['message'] = 'Error en el archivo: ' . $_FILES['name_image']['name'][$key] . ' - Código de error: ' . $_FILES['name_image']['error'][$key];
                        echo json_encode($response);
                        exit;
                    }
                }

                // Mensaje de éxito después de procesar todas las imágenes
                $response['message'] = 'Imágenes subidas correctamente.';
            } else {
                $response['message'] = 'No se han seleccionado imágenes.';
            }

            // Verificar el estado de la orden antes de actualizar
            if ($id_state_order == 2) {
                $response['message'] = 'No puedes modificar una orden que está cancelada.';
                echo json_encode($response);
                exit;
            }

            // Actualizar la orden
            $sql = SQL_UPDATE_ORDER_TECHNIC;
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $response['message'] = 'Error en la preparación de la consulta de actualización: ' . $conn->error;
                echo json_encode($response);
                exit;
            }

        $stmt->bind_param("sisi", $order_date, $id_state_order, $report_technic, $id_order);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Actualizado con éxito';
            } else {
                $response['message'] = 'No se pudo actualizar: ' . $stmt->error;
            }
            $stmt->close();
        }
    }
// Enviar la respuesta JSON
echo json_encode($response);