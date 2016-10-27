<?php
session_set_cookie_params(86400);
session_start();

$sess_id = session_id();

if(isset($_GET['am_code']) && $_GET['am_code'] <>""){
$_SESSION['am_code'] = $_GET['am_code'];
}

include('func/func.php');

if($_SESSION['MEM_ID']==""){
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
	$_goto = "login.php";
	go_to($_goto);
	exit;
}
?>