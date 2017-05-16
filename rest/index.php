<?php

if (!isset($path)){
    //Path for module inclusion
    $path = dirname(__FILE__) . '/../../';

    //General config
    require $path . 'config/config.php';
}

//PHPMailer
require $path . 'phpmailer/PHPMailerAutoload.php';

$app = new \Slim\Slim(array(
    'debug' => true
));
$app->get('(/:name)/', function ($name = "a") {
    echo json_encode(array());
});

$app->post('(/:name)/', function ($name = "a") {
    extract($_POST);
    
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mail = new PHPMailer;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'quoted-printable';

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.dezmin.com.br';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'contato@dezmin.com.br';                 // SMTP username
        $mail->Password = 'athlonk7';                           // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom("mail@palpitepremiado.com", $name);

        $mail->addAddress("robyflc@gmail.com", "Robson");

        $mail->addReplyTo($email, $name);

        $mail->Subject = "[Palpite] " . $subject;
        $mail->Body = $message;

        if(!$mail->send()) {
            echo '{ "error" : true }';
        } else {
            echo '{ "success" : true }';
        }        
    } else {
        echo '{ "empty" : true }';
    }
    
});

$app->run();


