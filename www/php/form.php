<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require '.config.php';

$mail = new PHPMailer(true);

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$phone = $_POST['phone'];
$smtp_host = MAIL_HOST;
$smtp_user = MAIL_USERNAME;
$smtp_pass = MAIL_PASSWORD;
$smtp_setfrom = MAIL_SETFROM_EMAIL;
$smtp_addaddress = MAIL_ADDADDRESS_EMAIL;

$response = array();

try {
    $mail->isSMTP();
    $mail->Host       = $smtp_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtp_user;
    $mail->Password   = $smtp_pass;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($smtp_setfrom, $name);
    $mail->addAddress($smtp_addaddress);
    $mail->addReplyTo($email);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();
    
    $response['status'] = 'success';
    $response['message'] = 'Email enviado correctamente.';
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'No se pudo enviar el correo: ' . $mail->ErrorInfo;
}

header('Content-Type: application/json'); // Asegura que la respuesta sea en formato JSON
echo json_encode($response);
?>
