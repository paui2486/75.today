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

$colname_item = "-1";
if (isset($_GET['p_id'])) {
  $colname_item = $_GET['p_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_item = sprintf("SELECT * FROM item WHERE p_id = %s", GetSQLValueString($colname_item, "int"));
$item = mysql_query($query_item, $iwine) or die(mysql_error());
$row_item = mysql_fetch_assoc($item);
$totalRows_item = mysql_num_rows($item);
?>
<!doctype html>
<html>
<meta charset="utf-8">
    <title>iWine <?php echo $row_item['p_name']; ?> -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="加購商品：<?php echo $row_item['p_name']; ?>">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
      </script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <style>
    </style>
  </head>

<body>
<div class="row">
  <div id="MainContent" class="span12">
<table border="0" cellpadding="10">
  <tr>
    <td align="center"><h4><?php echo $row_item['p_name']; ?></h4></td>
  </tr>
  <tr>
    <td><?php echo $row_item['p_description']; ?></td>
  </tr>
  <?php if($row_item['p_price1'] <> 0 || $row_item['p_price2'] <> 0){ ?>
  <tr>
    <td align="center">原價：<?php echo $row_item['p_price1']; ?><h4>加購價：<?php echo $row_item['p_price2']; ?></h4></td>
  </tr>
  <?php } ?>
  <tr>
    <td align="center"><input name="button" type="button" class="btn-primary" id="button" onClick="window.close()" value="關閉視窗"></td>
  </tr>
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($item);
?>
