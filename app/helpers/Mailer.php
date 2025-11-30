<?php
// File: app/helpers/Mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Nếu chưa cài PHPMailer, dùng Composer:
// composer require phpmailer/phpmailer

require_once __DIR__ . '/../../vendor/autoload.php';

function sendMail($to, $subject, $body, $from = 'no-reply@example.com', $fromName = 'My App') {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';   // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@example.com'; // SMTP username
        $mail->Password   = 'your-email-password';    // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom($from, $fromName);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error ({$to}): {$mail->ErrorInfo}");
        return false;
    }
}
