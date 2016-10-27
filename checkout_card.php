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

$Webcode=urlencode('S1302210024');
$Price=urlencode($row_ORDER_LIST['ord_total_price']);
$Content=urlencode($row_ORDER_LIST['p_name']);
$OrderID = $row_ORDER_LIST['ord_code'];	
$MemberName=urlencode($row_ORDER_LIST['m_name']);
$MemberPhone=urlencode($row_ORDER_LIST['m_mobile']);
$MemberEmail=urlencode($row_ORDER_LIST['m_email']);
$CheckCode0="S1302210024"."shop2013".$row_ORDER_LIST['ord_total_price'];
$CheckCode1=sha1(urlencode($CheckCode0));

}
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body onLoad="document.form1.submit();">
資料傳送中...


<form name="form1" action=" https://www.esafe.com.tw/Service/Etopm.aspx" method="POST"> 
<input type="hidden" name="web"  Value ="<?php echo $Webcode; ?>">
<input type="hidden" name="MN"  Value="<?php echo $Price; ?>"> 
<input type="hidden" name="OrderInfo" Value="<?php echo $Content; ?>">  
<input type="hidden" name="Td" Value="<?php echo $OrderID ?>"> 
<input type="hidden" name="sna"Value="<?php echo $MemberName; ?>">  
<input type="hidden" name="sdt" Value="<?php echo $MemberPhone; ?>"> 
<input type="hidden" name="email" Value="<?php echo $MemberEmail; ?>">  
<<input type="hidden" name="note1" Value=""> 
<input type="hidden" name="note2" Value=""> 
<input type="hidden" name=" ChkValue" Value="<?php echo $CheckCode1; ?>"> 
</form> 
</body>
</html>
<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#slideshow').cycle({
		autostop:			false,     // true to end slideshow after X transitions (where X == slide count) 
		fx:				'fade,',// name of transition effect 
		pause:			false,     // true to enable pause on hover 
		randomizeEffects:	true,  // valid when multiple effects are used; true to make the effect sequence random 
		speed:			1000,  // speed of the transition (any valid fx speed value) 
		sync:			true,     // true if in/out transitions should occur simultaneously 
		timeout:		5000,  // milliseconds between slide transitions (0 to disable auto advance) 
		fit:			true,
		width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
	});
}); 
</script>
<?php
mysql_free_result($ORDER_LIST);
?>