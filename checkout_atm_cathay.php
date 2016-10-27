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

$CompanyID = "020230082000";
$orderNoGenDate = date('Y/m/d');
$PtrAcno = $row_ORDER_LIST['ord_atm_5code'];
$ItemNo = "iWine商品";
$PurQuantity = 1 ;
$amount = $row_ORDER_LIST['ord_total_price'];

}
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body onLoad="document.main.submit();">
資料傳送中...


<form name="main" action="https://www.mybank.com.tw/myatm/Acquiring/AcqOrder_Initial.asp" method="post" >
<input type="hidden" name="CompanyID"  Value ="<?php echo $CompanyID; ?>">
<input type="hidden" name="orderNoGenDate"  Value="<?php echo $orderNoGenDate; ?>"> 
<input type="hidden" name="PtrAcno" Value="<?php echo $PtrAcno ?>">  
<input type="hidden" name="ItemNo" Value="<?php echo $ItemNo; ?>"> 
<input type="hidden" name="PurQuantity"Value="<?php echo $PurQuantity; ?>">  
<input type="hidden" name="amount" Value="<?php echo $amount; ?>"> 
<input type="hidden" name="MerchantKey" Value="">  
</form> 
</body>
</html>
<?php
mysql_free_result($ORDER_LIST);
?>