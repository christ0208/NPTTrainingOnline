<?php
$url = $_GET['path'];
$filename = basename($url);
$ch = curl_init($url);
$fp = fopen("./$filename", "wb");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
fclose($fp);