<?php
require 'vendor/autoload.php';
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$to = $_GET['to'] ?? SMTP_USERNAME;
$subject = $_GET['subject'] ?? 'Test email from Ayurveda Clinic';
$body = $_GET['body'] ?? '<p>This is a test email sent from the Ayurveda Clinic app.</p>';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = SMTP_PORT;

    $mail->setFrom(SMTP_FROM, 'Ayurveda Clinic');
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->send();
    echo "Email sent to $to";
} catch (Exception $e) {
    echo "Email send failed: " . $e->getMessage();
}
?>