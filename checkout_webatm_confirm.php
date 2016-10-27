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



$PtrAcno = $_GET['PtrAcno'];
$amt = $_GET['amt'];

mysql_select_db($database_iwine, $iwine);
$query_ORDER_LIST = "SELECT * FROM order_list WHERE ord_atm_5code = '$PtrAcno' AND ord_total_price = '$amt'";
$ORDER_LIST = mysql_query($query_ORDER_LIST, $iwine) or die(mysql_error());
$row_ORDER_LIST = mysql_fetch_assoc($ORDER_LIST);
$totalRows_ORDER_LIST = mysql_num_rows($ORDER_LIST);

if($totalRows_ORDER_LIST == "0"){
	
	$rtnCode = "1111";

}else{

	$rtnCode = "0000";

 } ?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body onLoad="document.main.submit();">

<form name="main" action="https://www.mybank.com.tw/myatm/Acquiring/FISC2Confirm.asp" method="post" >
<input type="hidden" name="CompanyID"  Value ="010320001000">
<input type="hidden" name="OrderNoGenDate"  Value="<?php echo date('Y/m/d'); ?>"> 
<input type="hidden" name="PtrAcno" Value="<?php echo $PtrAcno; ?>">  
<input type="hidden" name="MerchantKey" Value="">
<input type="hidden" name="rtnCode" Value="<?php echo $rtnCode; ?>"> 
</form> 
</body>
</html>
<?php
mysql_free_result($ORDER_LIST);
?>