<?php
date_default_timezone_set('Asia/Seoul');

$ip_address = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

// SK office
//$my_ip = "203.236.3.225";

// jj house
// $my_ip = "223.62.203.82";

// my home
//$my_ip = "36.38.92.84";

$arr_ips = array();

// SK office
$arr_ips[] = "203.236.3.225";

// jj house
$arr_ips[] = "223.62.203.82";

// my home
$arr_ips[] = "36.38.92.84";


if(!in_array($ip_address, $arr_ips)){
    echo "access failed.";
    exit;
}

if($_SERVER["SERVER_NAME"] == "codex.neosave.me"){
	// service url
	$_SERVER_URL = "http://codex.neosave.me/chordccm";
	
	$_DB_HOST = "neosaveme.czmmencaqh3d.ap-northeast-2.rds.amazonaws.com";
	$_DB_NAME = "codex";
	$_DB_USER = "cserock";
	$_DB_PASSWORD = "master310";
	$_DB_PORT = "3306";
	
} else {
	// service url
	$_SERVER_URL = "http://localhost/chordccm";
	
	$_DB_HOST = "neosaveme.czmmencaqh3d.ap-northeast-2.rds.amazonaws.com";
	$_DB_NAME = "codex";
	$_DB_USER = "cserock";
	$_DB_PASSWORD = "master310";
	$_DB_PORT = "3306";
}

$_RESULT = array();
$_RESULT['error'] = false;
$_RESULT['data'] = false;
?>