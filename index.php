<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@unlink("cookie.txt");

$url = 'https://';
$nowtime = date("Y-m-d H:i:s");

echo "{LOG} - Inicio HEADER...<br/>";
$header = array();
$header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8,";
$header[] = "Origin: ".$url;
$header[] = "Cache-Control: max-age=0";
$header[] = "Connection: keep-alive";
//$header[] = "Keep-Alive: 300";
$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
//$header[] = "Accept-Language: es-ar,es;q=0.8,en-us;q=0.5,en;q=0.3";
$header[] = "Accept-Language: es-ES,es;q=0.8";
$header[] = "Content-Type: application/x-www-form-urlencoded";
$header[] = "Pragma: "; // browsers keep this blank.

echo "{LOG} - FIN HEADER...<br/>";
echo "----------------------------------------------------------------------------------------<br/>";
echo "{LOG} - Inicio cURL...<br/>";
$soap_do = curl_init();

/*
GET /ServiciosEnLinea/dgi--servicios-en-linea--consulta-de-certifcado-unico HTTP/1.1
Host: servicios.dgi.gub.uy
Connection: keep-alive
Pragma: no-cache
Cache-Control: no-cache
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,;q=0.8
Accept-Encoding: gzip, deflate, sdch, br
Accept-Language: es-UY,es;q=0.8,es-419;q=0.6,en;q=0.4
Cookie:
JSESSIONID=0000AwjncWErxbAFcBaTbBo69uw:-1;
GAMCooExtSes=S%3B2%3B12%3B889%3B0%3B1%3BLCF%2FtcSvPyr6OkhQCVjIYKdba1QA7ciOz1jEZRA%2By3E%3D;
gxplang=S;
GXPCom="";
_pk_id.6.5891=1dd3eef74499f233.1494964289.1.1494964726.1494964289.;
_pk_ses.6.5891=*
*/

curl_setopt($soap_do, CURLOPT_URL, $url);
curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 20);
curl_setopt($soap_do, CURLOPT_TIMEOUT,        25);
curl_setopt($soap_do, CURLOPT_COOKIEJAR, "./cookie.txt");
curl_setopt($soap_do, CURLOPT_COOKIEFILE, "./cookie.txt");
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($soap_do, CURLOPT_POST, true);
curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
curl_setopt($soap_do, CURLOPT_ENCODING, 'gzip,deflate');
//curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
//curl_setopt($soap_do, CURLOPT_REFERER, 'http://...?action=Recibidas');
curl_setopt($soap_do,CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');

$result = curl_exec($soap_do);
echo "ERROR: ";
$err = curl_error($soap_do);

var_dump($result);
var_dump($err);
//die();
echo "<br/>";
echo "{LOG} - FIN cURL...<br/>";
