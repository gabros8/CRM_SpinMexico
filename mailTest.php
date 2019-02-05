<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require  '../../vendor/autoload.php';
//require '../swiftmailer-master/lib/swift_required.php';
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
  ->setUsername('reservaciones@spinmexico.com.mx')
  ->setPassword('IloveSophie75#');
$mailer = new Swift_Mailer($transport);
$message = (new Swift_Message('Prueba'))->setFrom(array('reservaciones@spinmexico.com.mx' => 'SPIN Mexico'))->setTo("payantellez1g@hotmail.com")->setBody("HOLA",'text/html');
$mailer->send($message);
?>