<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

/**
	prerender page for serach engines and social media using http://service.prerender.io

	to test go to: http://theyesbrand.com/prerender.php?url=equipo

 */
$token = '1YSrBVYk0ihDGSb04Vyc';


$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['url'];

// log
file_put_contents('./log_prerender.txt', date("Y-m-d H:i")." - ".$url." - ".$_SERVER['HTTP_USER_AGENT']."\n", FILE_APPEND);
/*
$options = [
 	'http' => [
    	'header' => "X-Prerender-Token: ".$token."\r\n"
  	]
];
echo file_get_contents('http://service.prerender.io/'.$url, false, stream_context_create($options));
*/



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://service.prerender.io/".$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-Prerender-Token: '.$token
));
$response     = curl_exec($ch);
$responseInfo = curl_getinfo($ch);
$headerSize   = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
curl_close($ch);
$responseHeaders = substr($response, 0, $headerSize);
$responseBody    = substr($response, $headerSize);
$responseHeaderBlocks = array_filter(explode("\r\n\r\n", $responseHeaders));
$lastHeaderBlock      = end($responseHeaderBlocks);
$headerLines          = explode("\r\n", $lastHeaderBlock);
foreach ($headerLines as $header) {
    $header = trim($header);
    header($header);
}
header("Content-Length: ".strlen($responseBody));
echo $responseBody;