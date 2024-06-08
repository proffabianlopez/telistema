<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../php/vendor/autoload.php';

function enviarCorreoYRegistrar($name, $email, $pass, $phone = '') {
    include ('../dbConnection.php');
    include ('../Querys/configEmailFrm.php');
    $mail = new PHPMailer(true);
    $response = array();

    $sql = SQLSELECT_FRM_EMAIL;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $smtp_host = $row['mail_host'];
        $smtp_port = $row['mail_port'];
        $smtp_user = $row['mail_username'];
        $smtp_pass = $row['mail_password'];
        $smtp_setfrom = $row['mail_setfrom'];
        $smtp_addaddress = $row['mail_addaddress'];
    }else{
        $response['status'] = 'error';
        $response['message'] = 'no se obtuvieron datos del servidor';
        return $response;
    }

    $webpage = "https://telistema.duckdns.org/app/login.php";

    try {
        // Configura el objeto PHPMailer
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_user;
        $mail->Password   = $smtp_pass;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $smtp_port;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($smtp_setfrom, "Telistema Team");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Telistema: Login";
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
                <h2>Telistema: DATOS DE LOGIN</h2>
                <p><strong>Nombre:</strong> " . htmlspecialchars($name) . "</p>
                <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                <p><strong>Contraseña:</strong> " . htmlspecialchars($pass) . "</p>
            </div>
            <footer>
                Inicia Sesión aqui: <a href='" . htmlspecialchars($webpage) . "'>Iniciar Sessión</a>
            </footer>
        </body>
        </html>
        ";
        $mail->AltBody = "";

        // Envía el correo electrónico
        $mail->send();

        // Registra los datos en la base de datos
        // Aquí deberías tener la lógica para insertar los datos en tu base de datos

        $response['status'] = 'success';
        $response['message'] = 'Correo enviado y datos registrados exitosamente';
        return $response;
        
    } catch (Exception $e) {
        // Si ocurre un error al enviar el correo electrónico, devuelve un mensaje de error
        $response['status'] = 'error';
        $response['message'] = 'No se puede enviar el correo: ' . $mail->ErrorInfo;
        return $response;
    }
}
?>
