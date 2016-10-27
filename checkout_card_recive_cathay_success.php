<?php
include('func/func.php');

$storeid="010230290";
$cubkey="1eb97854f05429672656c18cd0fc8fc1";

$response_xml = stripslashes(trim($_POST['strOrderInfo']));  //銀行回傳授權結果
$xml = simplexml_load_string($response_xml);
 
$td = (string)$xml->ORDERINFO->ORDERNUMBER;


msg_box('刷卡成功! 您可至查詢訂單選項中查詢訂單進度，謝謝');

$_success_url = "order_mail.php?ord_code=".$td;
go_to($_success_url);
exit;
?>