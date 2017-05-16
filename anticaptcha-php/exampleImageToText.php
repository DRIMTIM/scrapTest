<?php

include("anticaptcha.php");
include("imagetotext.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        $fp = fopen($saveto,'x');
        fwrite($fp, $raw);
        fclose($fp);
    } catch (Exception $e) {
        var_dump($e);
    }
}
$urlDGI = "https://";
$homePath = "capcha.jpg";

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
