<?php
session_set_cookie_params(86400);
session_start();

$sess_id = session_id();

include('../func/func.php');

if($_SESSION['ALLIANCE_ID']==""){
	//$_page = $_SERVER['REQUEST_URI'];
	$_goto = "login.php";
	msg_box('請先登入聯盟行銷會員！');
	go_to($_goto);
	exit;
}
?>