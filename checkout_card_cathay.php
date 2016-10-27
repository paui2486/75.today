<?php require_once('Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_ORDER_LIST = "-1";
if (isset($_GET['ord_code'])) {
  $colname_ORDER_LIST = $_GET['ord_code'];
}
mysql_select_db($database_iwine, $iwine);
$query_ORDER_LIST = sprintf("SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE ord_code = %s", GetSQLValueString($colname_ORDER_LIST, "text"));
$ORDER_LIST = mysql_query($query_ORDER_LIST, $iwine) or die(mysql_error());
$row_ORDER_LIST = mysql_fetch_assoc($ORDER_LIST);
$totalRows_ORDER_LIST = mysql_num_rows($ORDER_LIST);

if($totalRows_ORDER_LIST == "0"){
	//msg_box('存取錯誤!');
	go_to(-1);
}else{

$storeid="010230290";
$cubkey="1eb97854f05429672656c18cd0fc8fc1";
$amount=$row_ORDER_LIST['ord_total_price'];
$orderinfo="iWine訂單";
$ordernumber = $row_ORDER_LIST['ord_code'];	

$cavalue=$storeid.$ordernumber.$amount.$cubkey;
$cavalue_md5=md5($cavalue);

$order_xml="<?xml version='1.0' encoding='UTF-8'?>
<MERCHANTXML>
<CAVALUE>".$cavalue_md5."</CAVALUE>
<ORDERINFO>
<STOREID>".$storeid."</STOREID>
<ORDERNUMBER>".$ordernumber."</ORDERNUMBER>
<AMOUNT>".$amount."</AMOUNT>
</ORDERINFO>
</MERCHANTXML>
";
 
}
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body onLoad="document.form1.submit();">
資料傳送中...


<form action="https://sslpayment.uwccb.com.tw/EPOSService/Payment/OrderInitial.aspx" method="post" name="form1">
<input name="strRqXML" value="<?php echo $order_xml; ?>">
</form>
</body>
</html>
<?php
mysql_free_result($ORDER_LIST);
?>