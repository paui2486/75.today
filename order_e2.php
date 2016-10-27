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

mysql_select_db($database_iwine, $iwine);
$query_ord_list = "SELECT * FROM order_list ORDER BY ord_id ASC";
$ord_list = mysql_query($query_ord_list, $iwine) or die(mysql_error());
$row_ord_list = mysql_fetch_assoc($ord_list);
$totalRows_ord_list = mysql_num_rows($ord_list);

require_once("func/csv.php");

$tmp = excel_start(true).excel_header(array("訂單編號","商品總價","訂單狀態"),true);

do { 

switch($row_ord_list['ord_status']){
							case '1':
							$_status =  "未處理";
							break;
							case '2':
							$_status =  "付款失敗";
							break;
							case '3':
							$_status =  "已付款，準備出貨中";
							break;
							case '4':
							$_status =  "已出貨";
							break;
							case '5':
							$_status =  "尚未匯款";
							break;
							case '6':
							$_status =  "對帳中";
							break;
							case '7':
							$_status =  "對帳失敗，請重填匯款帳號後5碼";
							break;
							case '8':
							$_status =  "已簽收";
							break;
							case '9':
							$_status =  "未簽收退回";
							break;
							case '10':
							$_status =  "缺貨中";
							break;
							case '11':
							$_status =  "貨到付款尚未出貨";
							break;
							case '21':
							$_status =  "查無帳款，請與我們聯繫";
							break;
							case '22':
							$_status =  "金額不符，請與我們聯繫";
							break;
							case '91':
							$_status =  "退貨申請中";
							break;
							case '92':
							$_status =  "退貨中";
							break;
							case '93':
							$_status =  "退貨完成";
							break;
							case '94':
							$_status =  "取消訂單中";
							break;
							case '95':
							$_status =  "未轉帳，已取消訂單";
							break;
							case '99':
							$_status =  "無效訂單";
							break;
						}
  
$tmp .= excel_row(array($row_ord_list['ord_code'],$row_ord_list['ord_buy_price'],$_status),true);   
  
  
} while ($row_ord_list = mysql_fetch_assoc($ord_list)); 

$tmp .=excel_end(true);

$saveasname=date('YmdHis').'_ord_list.xls';

header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; Filename="'.$saveasname.'"');
		header('Pragma: no-cache');
		header('Content-length:'.strlen($tmp));
		
		echo $tmp;

mysql_free_result($ord_list);
?>
