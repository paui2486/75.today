<?php
include('func/func.php');

 $errcode = $_POST['errcode'];  //回覆代碼
 //$authCode = $_POST['ApproveCod'];	//交易授權碼
 $td = $_POST['Td'];	//訂單編號
 //$Last4digitPAN = $_POST['Card_NO'];	//卡號後四碼
 //$errmsg = urldecode($_POST['errmsg']);	//回覆代碼解釋
 $PayDate = $_POST['PayDate'];

if($errcode == "00"){

require_once('Connections/iwine.php');

$updateSQL = "UPDATE order_list SET ord_status = '3', ord_card_response = '$errcode' WHERE ord_code='$td'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

/*
mysql_select_db($database_iwine, $iwine);
$query_ORDER_LIST = sprintf("SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE ord_code = '%s'", GetSQLValueString($td, "text"));
$ORDER_LIST = mysql_query($query_ORDER_LIST, $iwine) or die(mysql_error());
$row_ORDER_LIST = mysql_fetch_assoc($ORDER_LIST);
$totalRows_ORDER_LIST = mysql_num_rows($ORDER_LIST);
						
$total_sale_num = $row_ORDER_LIST['ord_p_num']+$row_ORDER_LIST['ord_p_num2']+$row_ORDER_LIST['ord_p_num3']+$row_ORDER_LIST['ord_p_num4']+$row_ORDER_LIST['ord_p_num5'];

$updateSQL2 = "UPDATE Product SET p_sale_num=p_sale_num + ".$total_sale_num." WHERE p_id=".$row_ORDER_LIST['ord_p_id'];
mysql_select_db($database_iwine, $iwine);
$Result2 = mysql_query($updateSQL2, $iwine) or die(mysql_error());
*/
exit;
	
}else{
	
require_once('Connections/iwine.php');

$updateSQL = "UPDATE order_list SET ord_status = '2', ord_card_response = '$errcode' WHERE ord_code='$td'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
	
	
	//$why_fail = "付款失敗! 原因為：".$errmsg." ，本訂單將失效，請重新下訂單，謝謝";
	//msg_box($why_fail);
	//$_fail_url = "myorder.php";
	//go_to($_fail_url);
	exit;
	
}
?>