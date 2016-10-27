<?php
include('func/func.php');

 $errcode = $_POST['errcode'];  //回覆代碼
 $authCode = $_POST['ApproveCod'];	//交易授權碼
 $td = $_POST['Td'];	//訂單編號
 $Last4digitPAN = $_POST['Card_NO'];	//卡號後四碼
 $errmsg = urldecode($_POST['errmsg']);	//回覆代碼解釋


if($errcode == "00"){

require_once('Connections/iwine.php');

$updateSQL = "UPDATE order_list SET ord_status = '3', ord_card_pan = '$Last4digitPAN', ord_card_code = '$authCode', ord_card_response = '$errcode', ord_card_msg = '$errmsg' WHERE ord_code='$td'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

	$why_success = "刷卡成功! 您可至查詢訂單選項中查詢訂單進度，謝謝";
	msg_box($why_success);
	
	$_success_url = "order_mail.php?ord_code=".$td;
	//$_success_url = "myorder.php";
	go_to($_success_url);
	exit;
	
}else{
	
require_once('Connections/iwine.php');

$updateSQL = "UPDATE order_list SET ord_status = '2', ord_card_pan = '$Last4digitPAN', ord_card_code = '$authCode', ord_card_response = '$errcode', ord_card_msg = '$errmsg' WHERE ord_code='$td'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
	
	
	$why_fail = "刷卡失敗! 原因為：".$errmsg." ，本訂單將失效，請重新下訂單，謝謝";
	msg_box($why_fail);
	$_fail_url = "myorder.php";
	go_to($_fail_url);
	exit;
	
}
?>