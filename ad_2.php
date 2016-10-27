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
        <table width="252"  cellpadding="1" style="border:#000000">
 			 <tr>
    			<td height="252" align="center">
                 <div id="slideshow">
    <?php do { ?>
        <a href="hit_ad.php?b_id=<?php echo $row_AD01['b_id']; ?>" target="_blank"><img src="http://admin.iwine.com.tw/webimages/ad/<?php echo $row_AD01['b_file']; ?>" width="220" height="220" /></a>
      <?php } while ($row_AD01 = mysql_fetch_assoc($AD01)); ?>
  </div>
  </td>
  			</tr>
		</table>
        <?php
mysql_free_result($AD01);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
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
		height:		   '250px',
		width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
	});
}); 
</script>