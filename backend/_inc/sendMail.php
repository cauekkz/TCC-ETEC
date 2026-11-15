<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($to, $subject, $body) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = getenv('SMTP_USER') ?: '';
        $mail->Password = getenv('SMTP_PASS') ?: '';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // ✅ Fixes accented characters
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom(getenv('SMTP_USER') ?: 'no-reply@etecconnect.local', 'ETEConnect');
        $mail->addAddress($to);

        $mail->isHTML(true);

        // ✅ Fixes accented characters in the subject too
        $mail->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        // ✅ Makes sure the body is UTF-8
        $mail->Body = "<meta charset='UTF-8'>{$body}";

        return $mail->send();

    } catch (Exception $e) {
        return false;
    }
}
