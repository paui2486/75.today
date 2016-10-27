<?php require_once('Connections/iwine.php'); ?>
<?php include('func/func.php'); ?>
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

$CompanyID = $_GET['CompanyID'];
$TrsCode = $_GET['TrsCode'];  //回覆代碼
$OrderNumber = $_GET['OrderNumber'];	//虛擬帳號
$amt = $_GET['amt'];	//交易金額

if(($CompanyID == "010320001000" && $TrsCode == "0000") || ($CompanyID == "010320001000" && $TrsCode == "9999")){

$updateSQL = "UPDATE order_list SET ord_status = '3', ord_card_response = '$TrsCode' WHERE ord_atm_5code = '$OrderNumber'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

mysql_select_db($database_iwine, $iwine);
$query_ORDER_LIST = "SELECT * FROM order_list WHERE ord_atm_5code = '$OrderNumber' AND ord_total_price = '$amt'";
$ORDER_LIST = mysql_query($query_ORDER_LIST, $iwine) or die(mysql_error());
$row_ORDER_LIST = mysql_fetch_assoc($ORDER_LIST);
$totalRows_ORDER_LIST = mysql_num_rows($ORDER_LIST);

$td = $row_ORDER_LIST['ord_code'];

//echo "ok";	
$_success_url = "order_mail.php?ord_code=".$td;
go_to($_success_url);
	
exit;
	
}else{
	
$updateSQL = "UPDATE order_list SET ord_status = '2', ord_card_response = '$TrsCode' WHERE ord_atm_5code = '$OrderNumber'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

mysql_select_db($database_iwine, $iwine);
$query_ORDER_LIST = "SELECT * FROM order_list WHERE ord_atm_5code = '$OrderNumber' AND ord_total_price = '$amt'";
$ORDER_LIST = mysql_query($query_ORDER_LIST, $iwine) or die(mysql_error());
$row_ORDER_LIST = mysql_fetch_assoc($ORDER_LIST);
$totalRows_ORDER_LIST = mysql_num_rows($ORDER_LIST);

//echo "fail";		
$why_fail = "付款失敗! 請重新付款或重新下單，謝謝";
msg_box($why_fail);
$_fail_url = "myorder_s2.php?ord_id=".$row_ORDER_LIST['ord_id'];;
go_to($_fail_url);
exit;
	
}
?>