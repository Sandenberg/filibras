<?php

try {

	$url = 'http://filibra.ddns.net/getMac.php';

	$json = file_get_contents($url);
	$obj = json_decode($json);
	echo $obj->mac;
	// echo $content;
} catch (Exception $e) {
	echo $e;	
}