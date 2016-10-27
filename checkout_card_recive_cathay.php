<?php
/*
$response_xml = trim("
<?xml version='1.0' encoding='UTF-8'?>
<CUBXML>
<CAVALUE>驗證值</CAVALUE>
<ORDERINFO>
<STOREID>特店代號</STOREID>
<ORDERNUMBER>訂單編號</ORDERNUMBER>
<AMOUNT>金額</AMOUNT>
<PERIODNUMBER></PERIODNUMBER>
</ORDERINFO>
<AUTHINFO>
	<AUTHSTATUS>0000</AUTHSTATUS>
	<AUTHCODE>授權碼</AUTHCODE>
	<AUTHTIME>授權時間</AUTHTIME>	
	<AUTHMSG>授權訊息</AUTHMSG>
</AUTHINFO>
</CUBXML>
");    
*/
 $response_xml = stripslashes(trim($_POST['strRsXML']));  //銀行回傳授權結果
/*
 $today = date('Ymdhis');
 $_xml_file = "http://admin.iwine.com.tw/webimages/".$today.".txt";

$fp = fopen($_xml_file, 'w');
$st0=fputs($fp, $response_xml);
fclose($fp);
*/
 $xml = simplexml_load_string($response_xml);
 
 //print_r($xml);
 
$errcode = (string)$xml->AUTHINFO->AUTHSTATUS;

$storeid="010230290";
$cubkey="1eb97854f05429672656c18cd0fc8fc1";
$order_code = (string)$xml->ORDERINFO->ORDERNUMBER;
$authCode = (string)$xml->AUTHINFO->AUTHCODE;
$errmsg =(string)$xml->AUTHINFO->AUTHMSG;
 
if($errcode == "0000"){
	
require_once('Connections/iwine.php');

$updateSQL = "UPDATE order_list SET ord_status = '3', ord_card_code = '$authCode', ord_card_response = '$errcode', ord_card_msg = '$errmsg' WHERE ord_code = '$order_code'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

$_success_url = "http://www.iwine.com.tw/checkout_card_recive_cathay_success.php";
$cavalue_success = "www.iwine.com.tw1eb97854f05429672656c18cd0fc8fc1";
$cavalue_success_md5 = md5($cavalue_success);
$re_xml_success = "<?xml version='1.0' encoding='UTF-8'?><MERCHANTXML><CAVALUE>$cavalue_success_md5</CAVALUE><RETURL>$_success_url</RETURL></MERCHANTXML>";

echo $re_xml_success;

exit;
	
}else{
	
require_once('Connections/iwine.php');

$updateSQL = "UPDATE order_list SET ord_status = '2', ord_card_code = '$authCode', ord_card_response = '$errcode', ord_card_msg = '$errmsg' WHERE ord_code='$ordernumber'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

$_fail_url = "http://www.iwine.com.tw/checkout_card_recive_cathay_fail.php";
$cavalue_fail = "www.iwine.com.tw1eb97854f05429672656c18cd0fc8fc1";
$cavalue_fail_md5 = md5($cavalue_fail);
$re_xml_fail = "<?xml version='1.0' encoding='UTF-8'?><MERCHANTXML><CAVALUE>$cavalue_fail_md5</CAVALUE><RETURL>$_fail_url</RETURL></MERCHANTXML>";
		
echo $re_xml_fail;	
	
exit;
	
}

?>