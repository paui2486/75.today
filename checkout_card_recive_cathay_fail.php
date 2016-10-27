<?php
include('func/func.php');

$storeid="010230290";
$cubkey="1eb97854f05429672656c18cd0fc8fc1";

$response_xml = stripslashes(trim($_POST['strOrderInfo']));  //銀行回傳授權結果
$xml = simplexml_load_string($response_xml);
$td = (string)$xml->ORDERINFO->ORDERNUMER;

msg_box('刷卡失敗!請檢查是否輸入錯誤或洽詢發卡銀行。\n本訂單將失效，請重新下訂單，謝謝');

// $_fail_url = "myorder.php";
$_fail_url = "order_mail.php?ord_code=".$td;
go_to($_fail_url);
exit;
?>