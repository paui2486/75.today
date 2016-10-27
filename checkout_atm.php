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

$Webcode=urlencode('S1302210099');
$Price=urlencode($row_ORDER_LIST['ord_buy_price']);
$ShipPrice = urlencode($row_ORDER_LIST['ord_ship_price']);
$Price_total=urlencode($row_ORDER_LIST['ord_total_price']);
$Content=urlencode($row_ORDER_LIST['p_name']);
$OrderID = urlencode($row_ORDER_LIST['ord_code']);	
$MemberName=urlencode($row_ORDER_LIST['m_name']);
$MemberPhone=urlencode($row_ORDER_LIST['m_mobile']);
$MemberEmail=urlencode($row_ORDER_LIST['m_email']);
$CheckCode0="S1302210099"."shop2013".$row_ORDER_LIST['ord_total_price'];
$CheckCode1=sha1(urlencode($CheckCode0));

$d = strtotime('+3 days');
 
$date_limit = date('Ymd',$d);	
}
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body onLoad="document.form1.submit();">
資料傳送中...


<form name="form1" action=" https://www.esafe.com.tw/Service/Etopm.aspx" method="POST"> 
<input type="hidden" name="web"  Value ="<?php echo $Webcode; ?>">
<input type="hidden" name="MN"  Value="<?php echo $Price_total; ?>"> 
<input type="hidden" name="OrderInfo" Value="<?php echo $Content; ?>">  
<input type="hidden" name="Td" Value="<?php echo $OrderID ?>"> 
<input type="hidden" name="sna"Value="<?php echo $MemberName; ?>">  
<input type="hidden" name="sdt" Value="<?php echo $MemberPhone; ?>"> 
<input type="hidden" name="email" Value="<?php echo $MemberEmail; ?>">  
<input type="hidden" name="note1" Value=""> 
<input type="hidden" name="note2" Value="">
<input type="hidden" name="DueDate" Value="<?php echo $date_limit; ?>">
<input type="hidden" name="UserNo" Value="">
<input type="hidden" name="BillDate" Value="">
<input type="hidden" name="ProductName1" Value="iTainan團體專案（合併顯示）">
<input type="hidden" name="ProductPrice1" Value="<?php echo $Price; ?>">
<input type="hidden" name="ProductQuantity1" Value="1">
<?php if($row_ORDER_LIST['ord_ship_price'] > 0){ ?>
<input type="hidden" name="ProductName2" Value="運費">
<input type="hidden" name="ProductPrice2" Value="<?php echo $ShipPrice; ?>">
<input type="hidden" name="ProductQuantity2" Value="1">
<?php } ?>


<input type="hidden" name=" ChkValue" Value="<?php echo $CheckCode1; ?>"> 
</form> 
</body>
</html>
<?php
mysql_free_result($ORDER_LIST);
?>
<?php include('ga.php'); ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38686742-1']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_set', 'currencyCode', 'TWD']);
  _gaq.push(['_addTrans',
    '<?php echo $row_ORDER_LIST['ord_id']; ?>',           // transaction ID - required
    'iWine',  // affiliation or store name
    '<?php echo $row_ORDER_LIST['ord_total_price']; ?>',          // total - required
    '0',           // tax
    '<?php echo $row_ORDER_LIST['ord_ship_price']; ?>',              // shipping
    '<?php echo $row_ORDER_LIST['ord_ship_city']; ?>',       // city
    '<?php echo $row_ORDER_LIST['ord_ship_county']; ?>',     // state or province
    'Taiwan'             // country
  ]);

   // add item might be called for every item in the shopping cart
   // where your ecommerce engine loops through each item in the cart and
   // prints out _addItem for each
  _gaq.push(['_addItem',
    '<?php echo $row_ORDER_LIST['ord_id']; ?>',           // transaction ID - required
    '<?php echo $row_ORDER_LIST['p_id']; ?>',           // SKU/code - required
    '<?php echo $row_ORDER_LIST['p_name']; ?>',        // product name
    '<?php echo $row_ORDER_LIST['p_code']; ?>',   // category or variation
    '<?php echo $row_ORDER_LIST['p_price2']; ?>',          // unit price - required
    '<?php echo $row_ORDER_LIST['ord_p_num']+$row_ORDER_LIST['ord_p_num2']+$row_ORDER_LIST['ord_p_num3']+$row_ORDER_LIST['ord_p_num4']+$row_ORDER_LIST['ord_p_num5']; ?>'               // quantity - required
  ]);
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers


  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>