<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

   $mail = new PHPMailer(true);
    $mail->setLanguage('fr', '/PHPMailer/language/');
    $mail->IsSMTP(); 
    $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
    );
    $mail->SMTPDebug  = 4;  
    $mail->SMTPAuth   = true;  
    $mail->SMTPSecure = 'tls'; 
    $mail->Host       = gethostbyname('smtp.gmail.com');
    //$mail->Host       = gethostbyname('evm1295.sgvps.net');
    //$mail->Port       = 465; 
    $mail->Port       = 587;
    $mail->Username   = 'sanifer.informatique@gmail.com';
    //$mail->Username   = 'informatique@fripesenligne.fr';
    $mail->Password   = '7dJbW5h8';
    //$mail->Password   = '~336Rq}4@|uk';
    $mail->SetFrom('informatique@fripesenligne.fr', 'KIBO');
    $mail->Subject    = "oooooo";
    $mail->CharSet    = 'UTF-8';
    $mail->Body       = "11111111111111";
    $mail->AddAddress('winny.devinfo@talys.mg');
    //$mail->AddCC('informatique@sanifer.mg');
    //$mail->AddCC('fabien.tozzo@talys.mg');
    //$mail->AddBCC('winny.info@talys.mg');
    $mail->addReplyTo('informatique@sanifer.mg');
    $mail->isHTML(true);
    if(!$mail->Send()) {
      echo "Erreur d'envoi de mail: ".$mail->ErrorInfo;
    } else {
      echo 'Mail envoyé avec succès!';
    }
?>