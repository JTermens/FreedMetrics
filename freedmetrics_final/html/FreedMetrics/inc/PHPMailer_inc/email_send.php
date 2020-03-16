<?php

function send_email($mail_object,$email,$name,$subject,$body){
	//Recipients
    $mail_object->setFrom('freedmetrics@gmail.com', 'Freed Metrics');
    $mail_object->addAddress($email, $name);                           // Add a recipient
    // Content
    $mail_object->isHTML(true);                                        // Set email format to HTML
    $mail_object->Subject = $subject;
    $mail_object->Body    = $body;
    $mail_object->send();
}