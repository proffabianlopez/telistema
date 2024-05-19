<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include ('../app/dbConnection.php');
include ('../app/Querys/configEmailFrm.php');

$mail = new PHPMailer(true);

$response = array();

$sql = SQL_FRM_EMAIL;
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $smtp_host = $row['mail_host'];
    $smtp_user = $row['mail_username'];
    $smtp_pass = $row['mail_password'];
    $smtp_setfrom = $row['mail_sef_form'];
    $smtp_addaddress = $row['mail_addadress'];
    $webpage = $row['webpage'];
}else{
    $response['status'] = 'error';
    $response['message'] = 'no se obtuvieron datos del servidor';
}

try {
    // Verifica si el método de solicitud es POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validación del campo Nombre
        if (empty($_POST["name"])) {
            $response['status'] = 'error';
            $response['message'] = 'El campo Nombre es obligatorio.';
        // Validación del campo Correo Electrónico
        } elseif (empty($_POST["email"])) {
            $response['status'] = 'error';
            $response['message'] = 'El campo Correo Electrónico es obligatorio.';
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 'error';
            $response['message'] = 'Por favor, introduce una dirección de correo electrónico válida.';
        // Validación del campo Asunto
        } elseif (empty($_POST["subject"])) {
            $response['status'] = 'error';
            $response['message'] = 'El campo Asunto es obligatorio.';
        // Validación del campo Mensaje
        } elseif (empty($_POST["message"])) {
            $response['status'] = 'error';
            $response['message'] = 'El campo Mensaje es obligatorio.';
        } else {
            // Recupera los valores de los campos del formulario
            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $phone = isset($_POST['phone']) ? $_POST['phone'] : ''; // Verifica si el campo de teléfono está establecido

            // Configura el objeto PHPMailer
            $mail->isSMTP();
            $mail->Host       = $smtp_host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtp_user;
            $mail->Password   = $smtp_pass;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($smtp_setfrom, $name);
            $mail->addAddress($smtp_addaddress);
            $mail->addReplyTo($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    =  "
            <html>
            <head>
                <title>Correo de Contacto</title>
                <style>
                    /* Estilos CSS */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 40px;
                        border-radius: 10px;
                        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #333;
                    }
                    p {
                        color: #666;
                    }
                    footer {
                        margin-top: 20px;
                        text-align: center;
                        color: #999;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Telistema Contacto</h2>
                    <p><strong>Nombre:</strong> " . htmlspecialchars($name) . "</p>
                    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                    <p><strong>Teléfono:</strong> " . htmlspecialchars($phone) . "</p>
                    <p><strong>Asunto:</strong> " . htmlspecialchars($subject) . "</p>
                    <p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
                </div>
                <footer>
                    Visita nuestra página web: <a href='" . htmlspecialchars($webpage) . "'>" . htmlspecialchars($webpage) . "</a>
                </footer>
            </body>
            </html>
            ";
            $mail->AltBody = $message;

            // Envía el correo electrónico
            $mail->send();
            
            // Envía una respuesta de éxito
            $response['status'] = 'success';
            $response['message'] = 'Email enviado correctamente.';
        }
    } else {
        // Si la solicitud no es de tipo POST, devuelve un mensaje de error
        $response['status'] = 'error';
        $response['message'] = 'El formulario solo puede ser enviado mediante el método POST.';
    }
} catch (Exception $e) {
    // Si ocurre un error al enviar el correo electrónico, devuelve un mensaje de error
    $response['status'] = 'error';
    $response['message'] = 'No se pudo enviar el correo: ' . $mail->ErrorInfo;
}

header('Content-Type: application/json'); // Asegura que la respuesta sea en formato JSON
echo json_encode($response);
?>
