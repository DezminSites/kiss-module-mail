<?php

$app->map('/##url##',function(){
    global $m, $path, $local;
    ob_start();
    include('./modules/app_mail/rest/index.php');
    $context = ob_get_contents(); 
    ob_get_clean();
    $context = json_decode($context,true);
    $tpl = file_get_contents('./modules/app_mail/views/mail.html');
    $context = (array_merge($local,$context,array("title" => "##title## - " . $local["name"])));
    echo $m->render($tpl,$context); 
})->via('GET', 'POST');