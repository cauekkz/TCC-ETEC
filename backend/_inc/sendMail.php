<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($to, $subject, $body) {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'seu-email@gmail.com';
        $mail->Password = 'REMOVIDO'; // TROQUE ESSA SENHA AGORA NO GMAIL

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // ✅ AQUI ESTÁ A CORREÇÃO DOS ACENTOS
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom('seu-email@gmail.com', 'Sistema');
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
