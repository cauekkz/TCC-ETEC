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
        $mail->Password = getenv('SMTP_PASS') ?: ''; // configure SMTP_USER/SMTP_PASS no docker-compose ou no ambiente

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // ✅ AQUI ESTÁ A CORREÇÃO DOS ACENTOS
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom(getenv('SMTP_USER') ?: 'no-reply@etecconnect.local', 'ETEConnect');
        $mail->addAddress($to);

        $mail->isHTML(true);

        // ✅ CORRIGE ACENTOS NO ASSUNTO TAMBÉM
        $mail->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        // ✅ Garante UTF-8 NO CORPO
        $mail->Body = "<meta charset='UTF-8'>{$body}";

        return $mail->send();

    } catch (Exception $e) {
        return false;
    }
}
