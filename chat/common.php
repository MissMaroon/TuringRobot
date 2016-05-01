<?php
$value = $_POST['value'];
$key = '7c175334ce858d6b72deed71c3fd1705';
$url = 'http://www.tuling123.com/openapi/api?key=' . $key . '&info='.$value;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$text = curl_exec($ch);
curl_close($ch);
echo $text;


