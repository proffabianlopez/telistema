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
// Check para ver si es el técnico editando su avatar
$technicAction = explode("=", $_SERVER['QUERY_STRING']);
$technicAction = end($technicAction);
$isEditTechnicAvatar = strcmp($technicAction, "edit_user_avatar");

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1 && $isEditTechnicAvatar !== 0) {
        $response['message'] = 'Acceso denegado.';
        echo json_encode($response);
        exit;
    }
} else {
    $response['message'] = 'Por favor, inicie sesión para continuar.';
    echo json_encode($response);
    exit;
}

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
include ('../configsmtp/endEmail.php');

//editar admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_GET['action'] === 'edit_user') {
        // Checking for Empty Fields
        if (empty($_POST["name_user"])) {
            $response['message'] = 'El campo Nombre es obligatorio.';
        } elseif (empty($_POST["surname_user"])) {
            $response['message'] = 'El campo Apellido es obligatorio.';
        } elseif (empty($_POST["phone_user"])) {
            $response['message'] = 'El campo Teléfono es obligatorio.';
        } else {

            // Obtener los datos del usuario a editar
            // Necesito el rol y el correo actual ya que no los voy a actualizar
            $user_id = $_REQUEST['id_user'];

            $stmt = $conn->prepare(SQL_SELECT_USER_BY_ID);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            // Obtener resultados de la consulta
            $result = $stmt->get_result();

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Obtener la fila como un array asociativo
                $row = $result->fetch_assoc();

            } else {
                
                exit;
            }

            // Assigning User Values to Variable
            $id = $_REQUEST['id_user'];
            $name = capitalizeWords(trim($_REQUEST['name_user']));
            $surname = capitalizeWords(trim($_REQUEST['surname_user']));
            $phone = trim($_REQUEST['phone_user']);
            $mail = trim($row['mail']); // No se edita, se trae de request
            $role = trim($row['id_rol']); // No se edita, se trae de request
            $pass_hash = null;
            $new_pass = null;
            if (isset($_POST["new_pass"])) {
                $new_pass = generatePassword();
                $pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            }
            error_log("var: " . $new_pass);
            $stmt = $conn->prepare(SQL_UPDATE_USER);
            $stmt->bind_param("sssisssi", $name, $surname, $phone, $role, $pass_hash, $pass_hash, $pass_hash, $id);

            if ($stmt->execute()) {
                if ($pass_hash != null) {
                    $result = enviarCorreoYRegistrar($name, $mail, $new_pass);
                    if ($result['status'] == 'success') {
                        $response['status'] = 'success';
                        $response['message'] = $result['message'] . '';
                        echo json_encode($response);
                        exit;
                    } else {
                        $response['message'] = ' Datos actualizados pero:' . $result['message'] . '';
                        echo json_encode($response);
                        exit;
                    }
                }
                
                $response['status'] = 'success';
                $response['message'] = 'Actualizado con exito';
                echo json_encode($response);
                exit;
            } else {
                
                $response['message'] = 'No se pudo actuazar: ';
                echo json_encode($response);
                exit;
            }
        }
        echo json_encode($response);
        exit;
    } elseif ($_GET['action'] === 'add_user') {
        if (empty($_POST["name_user"])) {
            $response['message'] = 'El campo Nombre es obligatorio ';
        } elseif (empty($_POST["surname_user"])) {
            $response['message'] = 'El campo Apellido es obligatorio ';
        } elseif (empty($_POST["user_password"])) {
            $response['message'] = 'Contraseña no generada ';
        } elseif (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Correo electrónico no válido ';
        } else {

            $name = capitalizeWords($_REQUEST['name_user']);
            $surname = capitalizeWords($_REQUEST['surname_user']);
            $phone = $_REQUEST['phone_user'];
            $mail = $_REQUEST['mail'];
            $pass = password_hash($_REQUEST['user_password'], PASSWORD_DEFAULT);
            $role = trim($_REQUEST['rol']);
            $state = 1;

            // Verifica si el correo ya existe en la base de datos
            $stmt = $conn->prepare(SQL_SELECT_USER_BY_EMAIL_STATE_ROL);
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($existing_role, $existing_state);
                $stmt->fetch();

                if ($existing_state == 2) {
                    $response['status'] = 'user_in_deleted';
                    $response['message'] = 'Email esta en la lista de iliminados';
                    // Actualizar usuario si está marcado como eliminado
                    if ($_GET["isUpdate"]){
                        $update_stmt = $conn->prepare(SQL_UPDATE_USER_BY_EMAIL);
                        $update_stmt->bind_param("ssssiis", $name, $surname, $phone, $pass, $state, $role, $mail);
    
                        if ($update_stmt->execute()) {
                            $result = enviarCorreoYRegistrar($name, $mail, $_POST["user_password"]);
                            if ($result['status'] == 'success') {
                                $response['status'] = 'success';
                                $response['message'] = $result['message'] . '';
                                echo json_encode($response);
                                exit;
                            } else {
                                $response['message'] = ' Datos registrados pero:' . $result['message'] . '';
                                echo json_encode($response);
                                exit;
                            }
                        } else {
                            $response['message'] = ' Error al agregar! ';
                            echo json_encode($response);
                            exit;
                        }
                    }
                   
                } else {
                    $response['message'] = 'El correo ya existe en la base de datos con el Rol: ' . $existing_role . '';
                    echo json_encode($response);
                    exit;
                }
            } else {
                // Prepara la consulta para insertar el nuevo usuario
                $stmt = $conn->prepare(SQL_INSERT_USER);
                $stmt->bind_param("sssssii", $name, $surname, $phone, $mail, $pass, $state, $role);

                if ($stmt->execute()) {
                    $result = enviarCorreoYRegistrar($name, $mail, $_POST["user_password"]);
                    if ($result['status'] == 'success') {
                        $response['status'] = 'success';
                        $response['message'] = $result['message'] . '';
                        echo json_encode($response);
                        exit;
                    } else {
                        $response['message'] = '' . $result['message'] . '';
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response['message'] = ' Error al agregar! ';
                    echo json_encode($response);
                    exit;
                }
            }
        }
        echo json_encode($response);
        exit;

    } elseif ($_GET['action'] === 'edit_User_Avatar') {
        
        $avatar = $_FILES['avatar'];

        // Para validacion
        $avatarMaxSize = 1024*1024; // 1MB
        $tmp = explode('.',$_FILES['avatar']['name']);
        $avatarType = strtolower(end($tmp)); // Formato de la imagen
        $allowedTypes = array("jpeg", "jpg", "png", "gif");

        // Valida si hay archivos vacios
        if($avatar['error'] === UPLOAD_ERR_NO_FILE) {
            $response['message'] = 'Por favor, ingrese una imagen.';
        } elseif (in_array($avatarType, $allowedTypes) === false) {
            $response['message'] = 'Solo se aceptan archivos JPEG, PNG y GIF.';
        } elseif ($avatar['size'] > $avatarMaxSize) {
            $response['message'] = 'El tamaño de la imagen supera el límite permitido (1MB).';
        } elseif ($avatar['error'] !== 0) {
            $response['message'] = 'Por favor, ingrese una imagen válida.';
        } else {
            $id_user = $_SESSION['user_id'];

            // Obtengo lo necesario para guardarlo
            $avatarFormat = explode(".", $avatar['name']); // jpg
            $avatarFolderRoute = "../../img/avatars/"; // Donde se guarda
            $avatarName = "avatar_" . time() . "." . end($avatarFormat); // avatar_1684391376

            // Genero lo que se va a guardar en la base de datos
            $avatarNewLocation =  $avatarFolderRoute . $avatarName;

            $stmt = $conn->prepare(SQL_UPDATE_USER_AVATAR);
            $stmt->bind_param('si', $avatarNewLocation, $id_user);

            if ($stmt->execute()) {
                // Muevo la imagen a su carpeta
                move_uploaded_file($avatar['tmp_name'], $avatarNewLocation);

                
                $response['status'] = 'success';
                $response['message'] = 'Actualizado con exito';
                echo json_encode($response);
                exit;
            } else {
                
                $response['message'] = 'No se pudo actualizar: ';
                echo json_encode($response);
                exit;
            }
        }
        echo json_encode($response);
        exit;


    } elseif ($_POST['action'] === 'delete_user') {

        $id_user = $_POST['id'];
        if ($id_user != $_SESSION['user_id']) {

            $stmt1 = $conn->prepare(SQL_VERIFIC_ORDER_USER);
            $stmt1->bind_param("i", $id_user);
            $stmt1->execute();

            $stmt1->store_result();

            if ($stmt1->num_rows == 0) {

                $stmt = $conn->prepare(SQL_DELETE_USER);

                // Asocia parámetros y ejecuta la consulta
                $stmt->bind_param("i", $id_user);

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

            } else {
                $response['message'] = "No podes eliminar ";
                $response['message1'] = "El Usuario tiene Ordenes Pendientes asignadas";
                echo json_encode($response);
                exit;
            }


        } else {
            $response['message'] = "No te podes eliminar a ti mismo";
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