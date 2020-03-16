<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Server settings
$mail->SMTPDebug = 0;                                       // Enable verbose debug output (0 deactivates it)
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = 'freedmetrics@gmail.com';               // SMTP username
$mail->Password   = 'KillerDolphin';                        // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above