<?php
session_start();
// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location: ../login.php");
    exit();
}

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => ''
];

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_role'] != 'technic') {
        $response['message'] = 'Acceso denegado.';
        echo json_encode($response);
        exit;
    }

    $mail = $_SESSION['mail'];
    $name = $_SESSION['user_name'];
    $rolUser = $_SESSION['user_role'];
    $idUser = $_SESSION['user_id'];
    $phone = '';

} else {
    $response['message'] = 'Por favor, inicie sesión para continuar.';
    echo json_encode($response);
    exit;
}

include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../../Admin/generate_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST["current_pass"])) {
        $response['message'] = 'El campo Contraseña Actual es obligatorio.';
    } elseif (empty($_POST["new_pass"])) {
        $response['message'] = 'El campo Nueva Contraseña es obligatorio.';
    } elseif (empty($_POST["repeat_pass"])) {
        $response['message'] = 'El campo Repetir Contraseña es obligatorio.';
    } elseif ($_POST['new_pass'] != $_POST['repeat_pass']) {
        $response['message'] = 'Las contraseñas no coinciden.';
    } else {
        $currentPass = $_POST['current_pass'];
        $newPass = $_POST['new_pass'];

        $stmt = $conn->prepare(SQL_SELECT_TECHNIC_BY_ID);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($currentPass, $row['user_password'])) {
                $validationResult = validatePassword($newPass);
                $passwordLevel = getPasswordLevel($newPass);
                if ($validationResult["valid"]) {
                    if ($passwordLevel !== null || $passwordLevel !== 'Bajo') {
                        if ($row['id_state_user'] == 2) {
                            $response['message'] = 'Cuenta Inactiva.';
                        } else if ($row['id_state_user'] == 1) {
                            include ('../Admin/endEmail.php');
                           // $result2 = enviarCorreoYRegistrar($name, $mail, $newPass, $phone);
                            //if ($result2['status'] == 'success') {
                                $pass = password_hash($newPass, PASSWORD_DEFAULT);

                                $stmt2 = $conn->prepare(SQL_UPDATE_TECHNIC_PASS);
                                $stmt2->bind_param("si", $pass, $idUser);

                                if ($stmt2->execute()) {
                                        $response['status'] = 'success';
                                        $response['message'] = 'Contraseña Cambiada exitosamente<br>';
                                } else {
                                    $response['message'] = 'Error al cambiar contraseña';
                                }
                            // } else {
                            //     $response['message'] = "ERROR AQUI " . $result2['message'];
                            // }
                        }
                    } else {
                        $response['message'] = "Contraseña muy débil. No se puede actualizar.";
                    }
                } else {
                    // La contraseña no cumple con los criterios
                    foreach ($validationResult["errors"] as $error) {
                        $response['message'] .= $error . "<br>";
                    }
                }
            } else {
                $response['message'] = 'Contraseña Incorrecta';
            }
        } else {
            $response['message'] = 'Usuario no encontrado';
        }
    }

    echo json_encode($response);
    exit;
}

function hasUppercase($str)
{
    return preg_match('/[A-Z]/', $str);
}

function hasDigit($str)
{
    return preg_match('/\d/', $str);
}

function hasSpecialChar($str)
{
    return preg_match('/[\W]/', $str); // \W busca cualquier carácter que no sea una letra, dígito o guion bajo
}

function validatePassword($password)
{
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres.";
    }
    if (!hasUppercase($password)) {
        $errors[] = "La contraseña debe incluir al menos una letra mayúscula.";
    }
    if (!hasDigit($password)) {
        $errors[] = "La contraseña debe incluir al menos un número.";
    }

    if (!empty($errors)) {
        return ["valid" => false, "errors" => $errors];
    }

    return ["valid" => true];
}

function getPasswordLevel($password)
{
    include ('../dbConnection.php');
    include ('../Querys/querys.php');
    $sql = SQL_PASSWORD_LEVEL;
    $result = $conn->query($sql);

    $levels = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $levels[] = $row;
        }
    } else {
        echo "No hay niveles de contraseña definidos en la base de datos.";
        exit();
    }

    foreach ($levels as $level) {
        if (
            strlen($password) >= $level['min_length'] &&
            (!$level['requires_uppercase'] || hasUppercase($password)) &&
            (!$level['requires_digit'] || hasDigit($password)) &&
            (!$level['requires_special_char'] || hasSpecialChar($password))
        ) {
            return $level['level_name'];
        }
    }
    return null;
}

?>