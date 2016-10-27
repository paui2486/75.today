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
$query_AD01 = "SELECT * FROM ad_fig WHERE b_position = '1' AND b_status = 'Y' ORDER BY b_order ASC";
$AD01 = mysql_query($query_AD01, $iwine) or die(mysql_error());
$row_AD01 = mysql_fetch_assoc($AD01);
$totalRows_AD01 = mysql_num_rows($AD01);
?>
        <div style="margin-bottom:10px;" align="center">
          <?php if ($totalRows_AD01 > 0) { // Show if recordset not empty ?>
  <div id="slideshow" style="height:310px; overflow:hidden;"><?php do { ?><a href="hit_ad.php?b_id=<?php echo $row_AD01['b_id']; ?>"><img src="http://admin.iwine.com.tw/webimages/ad/<?php echo $row_AD01['b_file']; ?>" width="245" /></a><?php } while ($row_AD01 = mysql_fetch_assoc($AD01)); ?>
  </div>
  <?php } // Show if recordset not empty ?>
        </div>
        <?php
mysql_free_result($AD01);
?>
