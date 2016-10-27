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

$colname_menu_hit = "-1";
if (isset($_GET['b_id'])) {
  $colname_menu_hit = $_GET['b_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_menu_hit = sprintf("SELECT * FROM ad_fig WHERE b_id = '%s'", GetSQLValueString($colname_menu_hit, "int"));
$menu_hit = mysql_query($query_menu_hit, $iwine) or die(mysql_error());
$row_menu_hit = mysql_fetch_assoc($menu_hit);
$totalRows_menu_hit = mysql_num_rows($menu_hit);

if($totalRows_menu_hit == 0){
	go_to('index.php');
	exit;
	}

$_b_id = $row_menu_hit['b_id'];
if($row_menu_hit['b_url'] <> ""){
$_b_url = $row_menu_hit['b_url'];
}else{
$_b_url = "index.php";
}

$strSQL = "UPDATE ad_fig SET b_times = b_times + 1 where b_id='$_b_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	// msg_box('修改成功!');
	go_to($_b_url);
	exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($menu_hit);
?>
