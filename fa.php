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
$query_fa_list = "SELECT *, SUM(f_sum) as f_total_price FROM fa_temp GROUP BY f_ord_code, f_mail_code ORDER BY f_ord_code ASC";
$fa_list = mysql_query($query_fa_list, $iwine) or die(mysql_error());
$row_fa_list = mysql_fetch_assoc($fa_list);
$totalRows_fa_list = mysql_num_rows($fa_list);

require_once("func/csv.php");

$tmp = excel_start(true).excel_header(array("訂單編號","掛號編號","總價","發票日期","發票號碼"),true);

do { 
 
$tmp .= excel_row(array($row_fa_list['f_ord_code'],$row_fa_list['f_mail_code'],$row_fa_list['f_total_price'],$row_fa_list['f_fa_date'],$row_fa_list['f_fa_code']),true); 
  
  
   } while ($row_fa_list = mysql_fetch_assoc($fa_list));

$tmp .=excel_end(true);

$saveasname=date('YmdHis').'_fa.xls';

header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; Filename="'.$saveasname.'"');
		header('Pragma: no-cache');
		header('Content-length:'.strlen($tmp));
		
		echo $tmp;

mysql_free_result($fa_list);
?>
