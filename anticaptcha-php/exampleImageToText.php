<?php

include("anticaptcha.php");
include("imagetotext.php");

function grab_image($url,$saveto){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($saveto)){
        unlink($saveto);
    }
    try {
        $fp = fopen($saveto,'r+');
        fwrite($fp, $raw);
        fclose($fp);
    } catch (Exception $e) {
        var_dump($e);
    }
}
$urlDGI = "https://servicios.dgi.gub.uy/Captcha/GetImage?resource=urlJpgCaptcha&parms=challengeId=81e0d27c-265f-4b8e-afb1-9832c0f9e1f7";
$homePath = "/var/www/html/scrapTest/anticaptcha-php/captcha2.txt";

grab_image($urlDGI, $homePath);

echo "{LOG} - Termino descarga imagen...<br/>";
echo "{LOG} - Inicio script...<br/>";

$api = new ImageToText();
$api->setVerboseMode(true);

//your anti-captcha.com account key
$api->setKey("ca91d77220d69b8e155e5a84b0e71bc1");

//setting file
$api->setFile("capcha.jpg");

if (!$api->createTask()) {
    $api->debout("API v2 send failed - ".$api->getErrorMessage(), "red");
    return false;
}

$taskId = $api->getTaskId();


if (!$api->waitForResult()) {
    $api->debout("could not solve captcha", "red");
    $api->debout($api->getErrorMessage());
} else {
    echo "\nhash result: ".$api->getTaskSolution()."\n\n";
}
