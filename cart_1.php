<?php include('session_check.php'); 
require_once('Connections/iwine.php'); 

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

$colname_Product = "-1";
if (isset($_GET['p_id'])) {
  $colname_Product = $_GET['p_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Product = sprintf("SELECT * FROM Product WHERE p_id = '%s'", GetSQLValueString($colname_Product, "int"));
$Product = mysql_query($query_Product, $iwine) or die(mysql_error());
$row_Product = mysql_fetch_assoc($Product);
$totalRows_Product = mysql_num_rows($Product);

if($totalRows_Product == 0){
	go_to('index.php');
	exit;
	}

$today = date('Y-m-d');
/*
if($row_Product['p_start_time'] > $today){
	msg_box('尚未開團~~');
	go_to('index.php');
	exit;
}elseif($row_Product['p_end_time'] < $today){
	msg_box('本團已收團~~');
	go_to('index.php');
	exit;
}
*/
if($row_Product['p_p1_soldout'] == "Y" || ($row_Product['p_p1_limit_num'] > 0 && $row_Product['p_p1_limit_sale'] >= $row_Product['p_p1_limit_num'])){
	$_soldout1 = "Y";}else{ $_soldout1 = "N"; }
if($row_Product['p_p2_soldout'] == "Y" || ($row_Product['p_p2_limit_num'] > 0 && $row_Product['p_p2_limit_sale'] >= $row_Product['p_p2_limit_num'])){
	$_soldout2 = "Y";}else{ $_soldout2 = "N"; }
if($row_Product['p_p3_soldout'] == "Y" || ($row_Product['p_p3_limit_num'] > 0 && $row_Product['p_p3_limit_sale'] >= $row_Product['p_p3_limit_num'])){
	$_soldout3 = "Y";}else{ $_soldout3 = "N"; }
if($row_Product['p_p4_soldout'] == "Y" || ($row_Product['p_p4_limit_num'] > 0 && $row_Product['p_p4_limit_sale'] >= $row_Product['p_p4_limit_num'])){
	$_soldout4 = "Y";}else{ $_soldout4 = "N"; }
if($row_Product['p_p5_soldout'] == "Y" || ($row_Product['p_p5_limit_num'] > 0 && $row_Product['p_p5_limit_sale'] >= $row_Product['p_p5_limit_num'])){
	$_soldout5 = "Y";}else{ $_soldout5 = "N"; }
	
if($row_Product['p_pa1_soldout'] == "Y" || ($row_Product['p_pa1_limit_num'] > 0 && $row_Product['p_pa1_limit_sale'] >= $row_Product['p_pa1_limit_num'])){
	$pa_soldout1 = "Y";}else{ $pa_soldout1 = "N"; }
if($row_Product['p_pa2_soldout'] == "Y" || ($row_Product['p_pa2_limit_num'] > 0 && $row_Product['p_pa2_limit_sale'] >= $row_Product['p_pa2_limit_num'])){
	$pa_soldout2 = "Y";}else{ $pa_soldout2 = "N"; }
if($row_Product['p_pa3_soldout'] == "Y" || ($row_Product['p_pa3_limit_num'] > 0 && $row_Product['p_pa3_limit_sale'] >= $row_Product['p_pa3_limit_num'])){
	$pa_soldout3 = "Y";}else{ $pa_soldout3 = "N"; }
if($row_Product['p_pa4_soldout'] == "Y" || ($row_Product['p_pa4_limit_num'] > 0 && $row_Product['p_pa4_limit_sale'] >= $row_Product['p_pa4_limit_num'])){
	$pa_soldout4 = "Y";}else{ $pa_soldout4 = "N"; }
if($row_Product['p_pa5_soldout'] == "Y" || ($row_Product['p_pa5_limit_num'] > 0 && $row_Product['p_pa5_limit_sale'] >= $row_Product['p_pa5_limit_num'])){
	$pa_soldout5 = "Y";}else{ $pa_soldout5 = "N"; }
if($row_Product['p_pa6_soldout'] == "Y" || ($row_Product['p_pa6_limit_num'] > 0 && $row_Product['p_pa6_limit_sale'] >= $row_Product['p_pa6_limit_num'])){
	$pa_soldout6 = "Y";}else{ $pa_soldout6 = "N"; }
if($row_Product['p_pa7_soldout'] == "Y" || ($row_Product['p_pa7_limit_num'] > 0 && $row_Product['p_pa7_limit_sale'] >= $row_Product['p_pa7_limit_num'])){
	$pa_soldout7 = "Y";}else{ $pa_soldout7 = "N"; }
if($row_Product['p_pa8_soldout'] == "Y" || ($row_Product['p_pa8_limit_num'] > 0 && $row_Product['p_pa8_limit_sale'] >= $row_Product['p_pa8_limit_num'])){
	$pa_soldout8 = "Y";}else{ $pa_soldout8 = "N"; }
if($row_Product['p_pa9_soldout'] == "Y" || ($row_Product['p_pa9_limit_num'] > 0 && $row_Product['p_pa9_limit_sale'] >= $row_Product['p_pa9_limit_num'])){
	$pa_soldout9 = "Y";}else{ $pa_soldout9 = "N"; }
if($row_Product['p_pa10_soldout'] == "Y" || ($row_Product['p_pa10_limit_num'] > 0 && $row_Product['p_pa10_limit_sale'] >= $row_Product['p_pa10_limit_num'])){
	$pa_soldout10 = "Y";}else{ $pa_soldout10 = "N"; }
	
if($row_Product['p_pb1_soldout'] == "Y" || ($row_Product['p_pb1_limit_num'] > 0 && $row_Product['p_pb1_limit_sale'] >= $row_Product['p_pb1_limit_num'])){
	$pb_soldout1 = "Y";}else{ $pb_soldout1 = "N"; }
if($row_Product['p_pb2_soldout'] == "Y" || ($row_Product['p_pb2_limit_num'] > 0 && $row_Product['p_pb2_limit_sale'] >= $row_Product['p_pb2_limit_num'])){
	$pb_soldout2 = "Y";}else{ $pb_soldout2 = "N"; }
if($row_Product['p_pb3_soldout'] == "Y" || ($row_Product['p_pb3_limit_num'] > 0 && $row_Product['p_pb3_limit_sale'] >= $row_Product['p_pb3_limit_num'])){
	$pb_soldout3 = "Y";}else{ $pb_soldout3 = "N"; }
if($row_Product['p_pb4_soldout'] == "Y" || ($row_Product['p_pb4_limit_num'] > 0 && $row_Product['p_pb4_limit_sale'] >= $row_Product['p_pb4_limit_num'])){
	$pb_soldout4 = "Y";}else{ $pb_soldout4 = "N"; }
if($row_Product['p_pb5_soldout'] == "Y" || ($row_Product['p_pb5_limit_num'] > 0 && $row_Product['p_pb5_limit_sale'] >= $row_Product['p_pb5_limit_num'])){
	$pb_soldout5 = "Y";}else{ $pb_soldout5 = "N"; }
if($row_Product['p_pb6_soldout'] == "Y" || ($row_Product['p_pb6_limit_num'] > 0 && $row_Product['p_pb6_limit_sale'] >= $row_Product['p_pb6_limit_num'])){
	$pb_soldout6 = "Y";}else{ $pb_soldout6 = "N"; }
if($row_Product['p_pb7_soldout'] == "Y" || ($row_Product['p_pb7_limit_num'] > 0 && $row_Product['p_pb7_limit_sale'] >= $row_Product['p_pb7_limit_num'])){
	$pb_soldout7 = "Y";}else{ $pb_soldout7 = "N"; }
if($row_Product['p_pb8_soldout'] == "Y" || ($row_Product['p_pb8_limit_num'] > 0 && $row_Product['p_pb8_limit_sale'] >= $row_Product['p_pb8_limit_num'])){
	$pb_soldout8 = "Y";}else{ $pb_soldout8 = "N"; }
if($row_Product['p_pb9_soldout'] == "Y" || ($row_Product['p_pb9_limit_num'] > 0 && $row_Product['p_pb9_limit_sale'] >= $row_Product['p_pb9_limit_num'])){
	$pb_soldout9 = "Y";}else{ $pb_soldout9 = "N"; }
if($row_Product['p_pb10_soldout'] == "Y" || ($row_Product['p_pb10_limit_num'] > 0 && $row_Product['p_pb10_limit_sale'] >= $row_Product['p_pb10_limit_num'])){
	$pb_soldout10 = "Y";}else{ $pb_soldout10 = "N"; }

?>
<!DOCTYPE html>
<html lang="zh_tw">
    <head>
    <meta charset="utf-8">
    <title>iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
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
.redfone {
	color: #FF0000;
}
.main_title {
	font-size: 20px;
	color: #FF0066;
	font-weight: bold;
	line-height: 30px
}
.red_btn {
	background-color: #CC0000;
	color: #FFFFFF;
	font-weight: bolder;
	padding: 5px 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}
.red_btn:hover, .red_btn.hover, .red_btn:focus, .red_btn.focus, .red_btn:active, .red_btn.active {
	background-color: #CC4444;
	font-weight: bolder;
	color: #FFFFFF;
	padding: 5px 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}
.green_btn {
	background-color: #399539;
	color: #FFFFFF;
	font-weight: bolder;
	padding: 5px 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}
.green_btn:hover, .red_btn.hover, .red_btn:focus, .red_btn.focus, .red_btn:active, .red_btn.active {
	background-color: #5bb75b;
	font-weight: bolder;
	color: #FFFFFF;
	padding: 5px 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}
.blue_btn {
	background-color: #278dab;
	color: #FFFFFF;
	font-weight: bolder;
	padding: 5px 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}
.blue_btn:hover, .red_btn.hover, .red_btn:focus, .red_btn.focus, .red_btn:active, .red_btn.active {
	background-color: #49afcd;
	font-weight: bolder;
	color: #FFFFFF;
	padding: 5px 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}
</style>
    </head>
    <body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=540353706035158";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> 
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<?php include('mainmenu_20140903.php'); ?>
<div class="container">
      <?php include('header_20140903.php'); ?>
      <div class="row">
    <div id="MainContent" class="span9">
          <div class="row">
        <div class="span9">
              <div class="main_title"><?php echo $row_Product['p_name']; ?></div>
              <div>
            <form action="order_send_2.php" method="post" class="form-horizontal" id="form1">
                  <legend> </legend>
                  <div class="control-group">
                <label class="control-label">主商品團購價</label>
                <div class="controls"> <span class="input-small uneditable-input"><?php echo $row_Product['p_price2']; ?></span> 元/<?php echo $row_Product['p_unit']; ?> </div>
              </div>
                  <legend>團購主商品數量</legend>
                  <div class="control-group">
                <label class="control-label"><font color="#993366"><?php echo $row_Product['p_product1']; ?></font></label>
                <div class="controls">
                      <input class="input-small <?php if($_soldout1 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_p_num" name="ord_p_num" value="0" onBlur="chksum();" <?php if($_soldout1 == "Y"){echo "disabled";}?> >
                      <?php ?>
                      <span class="help-inline"><font color="#993366"><?php echo $row_Product['p_unit']; ?></font>
                  <?php if($_soldout1 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php /*start db_input script*/ if ($row_Product['p_product2'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_product2']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($_soldout2 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_p_num2" name="ord_p_num2" value="0" onBlur="chksum();" <?php if($_soldout2 == "Y"){echo "disabled";}?>>
                      <span class="help-inline"><?php echo $row_Product['p_unit']; ?>
                  <?php if($_soldout2 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span></div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_product3'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_product3']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($_soldout3 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_p_num3" name="ord_p_num3" value="0" onBlur="chksum();" <?php if($_soldout3 == "Y"){echo "disabled";}?>>
                      <span class="help-inline"><?php echo $row_Product['p_unit']; ?>
                  <?php if($_soldout3 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span></div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_product4'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_product4']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($_soldout4 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_p_num4" name="ord_p_num4" value="0" onBlur="chksum();" <?php if($_soldout4 == "Y"){echo "disabled";}?>>
                      <span class="help-inline"><?php echo $row_Product['p_unit']; ?>
                  <?php if($_soldout4 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_product5'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label" for="inputPassword"><?php echo $row_Product['p_product5']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($_soldout5 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_p_num5" name="ord_p_num5" value="0" onBlur="chksum();" <?php if($_soldout5 == "Y"){echo "disabled";}?>>
                      <span class="help-inline"><?php echo $row_Product['p_unit']; ?>
                  <?php if($_soldout5 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <div class="control-group">
                <label class="control-label">團購主商品總數量</label>
                <div class="controls"> <span class="input-small uneditable-input" id="ord_total_num1">0</span>
                      <input id="ord_total_num" name="ord_total_num" type="hidden" value="0">
                      <span class="help-inline"><?php echo $row_Product['p_unit']; ?></span> </div>
              </div>
                  <?php if($row_Product['p_package'] == 'Y'){ ?>
                  <legend>搭贈商品選擇</legend>
                  <p><span id="pa_choice_num">請先輸入團購主商品數量。</span></p>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa1']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout1 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa1_num" name="ord_pa1_num" value="0" onBlur="chksum();" <?php if($pa_soldout1 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout1 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php /*start db_input script*/ if ($row_Product['p_pa2'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa2']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout2 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa2_num" name="ord_pa2_num" value="0" onBlur="chksum();" <?php if($pa_soldout2 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout2 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa3'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa3']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout3 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa3_num" name="ord_pa3_num" value="0" onBlur="chksum();" <?php if($pa_soldout3 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout3 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa4'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa4']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout4 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa4_num" name="ord_pa4_num" value="0" onBlur="chksum();" <?php if($pa_soldout4 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout4 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa5'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa5']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout5 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa5_num" name="ord_pa5_num" value="0" onBlur="chksum();" <?php if($pa_soldout5 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout5 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa6'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa6']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout6 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa6_num" name="ord_pa6_num" value="0" onBlur="chksum();" <?php if($pa_soldout6 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout6 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa7'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa7']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout7 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa7_num" name="ord_pa7_num" value="0" onBlur="chksum();" <?php if($pa_soldout7 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout7 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa8'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa8']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout8 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa8_num" name="ord_pa8_num" value="0" onBlur="chksum();" <?php if($pa_soldout8 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout8 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa9'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa9']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout9 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa9_num" name="ord_pa9_num" value="0" onBlur="chksum();" <?php if($pa_soldout9 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout9 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pa10'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pa10']; ?></label>
                <div class="controls">
                      <input class="input-small <?php if($pa_soldout10 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pa10_num" name="ord_pa10_num" value="0" onBlur="chksum();" <?php if($pa_soldout10 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">
                  <?php if($pa_soldout10 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php } ?>
                  <?php if($row_Product['p_pb1'] <> ''){ ?>
                  <legend>其他加購商品數量</legend>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb1']; ?> <?php echo $row_Product['p_pb1_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout1 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb1_num" name="ord_pb1_num" value="0" onBlur="chksum();" <?php if($pb_soldout1 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout1 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb1_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb1_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php /*start db_input script*/ if ($row_Product['p_pb2'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb2']; ?> <?php echo $row_Product['p_pb2_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout2 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb2_num" name="ord_pb2_num" value="0" onBlur="chksum();" <?php if($pb_soldout2 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout2 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb2_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb2_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb3'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb3']; ?> <?php echo $row_Product['p_pb3_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout3 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb3_num" name="ord_pb3_num" value="0" onBlur="chksum();" <?php if($pb_soldout3 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout3 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb3_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb3_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb4'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb4']; ?> <?php echo $row_Product['p_pb4_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout4 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb4_num" name="ord_pb4_num" value="0" onBlur="chksum();" <?php if($pb_soldout4 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout4 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb4_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb4_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb5'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb5']; ?> <?php echo $row_Product['p_pb5_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout5 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb5_num" name="ord_pb5_num" value="0" onBlur="chksum();" <?php if($pb_soldout5 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout5 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb5_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb5_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb6'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb6']; ?> <?php echo $row_Product['p_pb6_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout6 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb6_num" name="ord_pb6_num" value="0" onBlur="chksum();" <?php if($pb_soldout6 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout6 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb6_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb6_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb7'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb7']; ?> <?php echo $row_Product['p_pb7_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout7 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb7_num" name="ord_pb7_num" value="0" onBlur="chksum();" <?php if($pb_soldout7 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout7 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb7_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb7_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb8'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb8']; ?> <?php echo $row_Product['p_pb8_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout8 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb8_num" name="ord_pb8_num" value="0" onBlur="chksum();" <?php if($pb_soldout8 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout8 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb8_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb8_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb9'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb9']; ?> <?php echo $row_Product['p_pb9_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout9 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb9_num" name="ord_pb9_num" value="0" onBlur="chksum();" <?php if($pb_soldout9 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout9 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb9_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb9_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php /*start db_input script*/ if ($row_Product['p_pb10'] != ""){ ?>
                  <div class="control-group">
                <label class="control-label"><?php echo $row_Product['p_pb10']; ?> <?php echo $row_Product['p_pb10_price']; ?>元/份</label>
                <div class="controls">
                      <input class="input-small <?php if($pb_soldout10 == "Y"){echo "uneditable-input";}else{ echo "focused";}?>" type="text" id="ord_pb10_num" name="ord_pb10_num" value="0" onBlur="chksum();" <?php if($pb_soldout10 == "Y"){echo "disabled";}?>>
                      <span class="help-inline">份
                  <?php if($pb_soldout10 == "Y"){echo "已缺貨或額滿，勿選此項唷！";} ?>
                  <?php if($row_Product['p_pb10_url'] <> ''){ ?>
                  <a href="javascript:MM_openBrWindow('<?php echo $row_Product['p_pb10_url']; ?>','item','scrollbars=yes,width=800,height=600')">
                      <商品介紹>
                      </a>
                  <?php } ?>
                  </span> </div>
              </div>
                  <?php } /*end db_input script*/ ?>
                  <?php } ?>
                  <legend>本次團購金額總計</legend>
                  <div class="control-group">
                <label class="control-label">小計</label>
                <div class="controls"> <span class="input-small uneditable-input" id="ord_buy_price1">0</span> 元
                      <input name="ord_buy_price" type="hidden" id="ord_buy_price" value="0">
                    </div>
              </div>
                  <div class="control-group">
                <label class="control-label" >運費</label>
                <div class="controls"> <span class="input-small uneditable-input" id="ord_ship_price1"><?php echo $row_Product['p_ship_price']; ?></span> 元
                      <input name="ord_ship_price" type="hidden" id="ord_ship_price" value="<?php echo $row_Product['p_ship_price']; ?>">
                      <span class="help-block">
                  <?php if($row_Product['p_noship_way'] == 2){ ?>
                  **本團購【主要商品】(不含加購商品) 合計 <?php echo $row_Product['p_noship_num']; ?> <?php echo $row_Product['p_unit']; ?>(含)以上免運費。
                  <?php }else{ ?>
                  *本團購各項商品合計 <?php echo $row_Product['p_noship_price']; ?> 元(含)以上免運費。
                  <?php } ?>
                  </span> </div>
              </div>
                  <div class="control-group">
                <label class="control-label" >手續費</label>
                <div class="controls"> <span class="input-small uneditable-input" id="ord_hand_price1">0</span> 元
                      <input name="ord_hand_price" type="hidden" id="ord_hand_price" value="0">
                      <span class="help-block">*本專案選擇貨到付款需加收NT$<?php echo $row_Product['p_hang_price']; ?>元手續費。</span> </div>
              </div>
                  <div class="control-group">
                <label class="control-label" >合計</label>
                <div class="controls"> <span class="input-small uneditable-input" id="ord_total_price1">0</span> 元
                      <input name="ord_total_price" type="hidden" id="ord_total_price" value="0">
                    </div>
              </div>
                  <legend>收貨人資訊</legend>
                  <div class="control-group">
                <label class="control-label">收貨人姓名</label>
                <div class="controls">
                      <input class="input-small focused" id="ord_ship_name" name="ord_ship_name" type="text" value="<?php echo $_SESSION['MEM_NAME']; ?>">
                      <span class="help-inline">*請輸入完整<strong>中文</strong>姓名，否則宅配人員可能會找不到人喔~</span> </div>
              </div>
                  <div class="control-group">
                <label class="control-label">收貨地址</label>
                <div class="controls">
                      <div id="twzip"></div>
                      <input class="input-xlarge focused" id="ord_ship_address" name="ord_ship_address" type="text" value="">
                    </div>
              </div>
                  <div class="control-group">
                <label class="control-label">收貨人手機</label>
                <div class="controls">
                      <input class="input-small focused" id="ord_ship_mobile" name="ord_ship_mobile" type="text" value="<?php echo $_SESSION['MEM_MOBILE']; ?>">
                    </div>
              </div>
                  <div class="control-group">
                <label class="control-label">收貨人e-mail</label>
                <div class="controls">
                      <input class="input-large focused" id="ord_ship_email" name="ord_ship_email" type="text" value="<?php echo $_SESSION['MEM_ACCOUNT']; ?>">
                    </div>
              </div>
                  <div class="control-group">
                <label class="control-label">公司抬頭</label>
                <div class="controls">
                      <input class="input-large focused" id="ord_ship_fa_name" name="ord_ship_fa_name" type="text" placeholder="若發票需要公司抬頭，請在此填寫">
                    </div>
              </div>
                  <div class="control-group">
                <label class="control-label">公司統編</label>
                <div class="controls">
                      <input class="input-large focused" id="ord_ship_fa_id" name="ord_ship_fa_id" type="text" placeholder="若發票需要公司統編，請在此填寫">
                    </div>
              </div>
                  <?php if($row_Product['p_memo_online'] == "Y"){ ?>
                  <div class="control-group">
                <label class="control-label">備註</label>
                <div class="controls"> 
                      <!-- [mod] fit iwine description by Shelly -->
                      <textarea name="ord_memo" rows="3" placeholder="可輸入您想備註的文字，例如商品到貨時間（早、中、晚）、發票種類等。"></textarea>
                    </div>
              </div>
                  <?php } ?>
                  <div class="control-group">
                <label class="control-label">付款方式</label>
                <div class="controls">
                      <?php if($row_Product['p_card'] == "Y"){ ?>
                      <label class="radio">
                    <input type="radio" name="ord_pay" id="ord_pay" value="card" checked="checked">
                    信用卡付款：<font color="red">推薦使用</font>系統採用加密連線直接線上刷卡，入帳速度快，更快收到商品喔！(尚未提供分期功能唷~)</label>
                      <div style="clear:both"></div>
                      <?php } ?>
                      <?php if($row_Product['p_webatm'] == "Y"){ ?>
                      <label class="radio">
                    <input type="radio" name="ord_pay" id="ord_pay" value="webatm">
                    WebATM：直接線上ATM轉帳，安全又迅速，<span class="redfone">所有銀行與郵局金融卡皆可使用</span>喔！（需安裝讀卡機）</label>
                      <div style="clear:both"></div>
                      <?php } ?>
                      <?php if($row_Product['p_atm_cathy'] == "Y"){ ?>
                      <label class="radio">
                    <input type="radio" name="ord_pay" id="ord_pay" value="atm_cathy">
                    <!-- [mod] fit iwine payment 20131210 by Draq--> 
                    一般匯款／ATM轉帳：
                    訂單送出後，可於系統寄出的<font color="red">訂單通知信</font>看到「專屬匯款帳號」，也可至「會員中心」<font color="red">查詢訂單</font>狀態，請於三日內至金融機構、郵局或一般ATM轉帳付款；如果超過三日，該匯款帳號將會自動失效無法接受匯款，請重新訂購。(因金融機構作業時間，付款後約需<font color="red">一至三個工作天</font>才會入帳。) </label>
                      <div style="clear:both"></div>
                      <?php } ?>
                      <?php if($row_Product['p_atm'] == "Y"){ ?>
                      <!--
                                  <label class="radio">
									<input type="radio" name="ord_pay" id="ord_pay" value="atm">
									超商付款：詢問單送出後請<span class="redfone">列印付款單</span>，於<span class="redfone">三日內</span>至超商櫃檯，讓店員刷條碼後付款。（因金融機構作業時間，付款後約需<span class="redfone">一至三個工作天才會入帳</span>。）<a href="faq.php#atm" target="new" style="color:#F60">
								  <＊點我看付款說明＊></a> 
                                  </label>
                                  <div style="clear:both"></div>
                                  -->
                      <?php } ?>
                      <?php if($row_Product['p_paynow'] == "Y"){ ?>
                      <label class="radio">
                    <input type="radio" name="ord_pay" id="ord_pay" value="paynow">
                    貨到付款：本團購專案採用黑貓宅急便貨到付款，須外加<span style="color:#F00">手續費NT$<?php echo $row_Product['p_hang_price']; ?>元</span> 。<strong>（提醒您，貨到付款拒收達兩次，我們將無法再提供您此項服務。）</strong></label>
                      <?php } ?>
                    </div>
                <div class="control-group">
                      <label class="control-label"><span style="color:#F00"><strong>提醒事項</strong></span></label>
                      <div class="controls"> <span style="color:#F00"><strong>1. iWine無提供分期付款功能！不會以電話通知您修改付款方式或重新付款，或是要求您提供卡片後方的客服電話，再用此電話號碼告知ATM修改設定，以上皆為詐騙集團惡劣騙術，請您小心防範勿受騙！</strong></span> </div>
                      <div class="control-group">
                    <div class="controls"> <br>
                          <!-- [mod] fit iwine description 20131210 by Draq -->
                          <label>2. 運送方式一律採用黑貓宅急便快遞寄送，請至備註欄填寫早、中、晚的配送時段，如無填寫則配合快遞的配送時間，謝謝！</label>
                        </div>
                  </div>
                    </div>
              </div>
                  <div class="control-group">
                <div class="controls">
                      <input name="ord_acc_id" type="hidden" value="<?php echo $_SESSION['MEM_ID']; ?>">
                      <input name="ord_acc" type="hidden" value="<?php echo $_SESSION['MEM_ACCOUNT']; ?>">
                      <input name="ord_p_id" type="hidden" value="<?php echo $row_Product['p_id']; ?>">
                      <input name="am_code" type="hidden" value="<?php echo $_SESSION['am_code']; ?>">
                      <button type="button" class="red_btn" onClick="chkorder();">送出訂單</button>
                      <button type="button" class="green_btn" id="reset_data">重設</button>
                      <button type="button" class="blue_btn" onClick="window.location='content.php?p_id=<?php echo $row_Product['p_id']; ?>'">回上一頁</button>
                    </div>
              </div>
                </form>
          </div>
            </div>
      </div>
        </div>
    <div class="row">
          <div class="span3" align="center">
        <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine嚴選</h4>
        <?php include('ad_1.php'); ?>
      </div>
          <?php
                mysql_select_db($database_iwine, $iwine);
                $query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
                $hot = mysql_query($query_hot, $iwine) or die(mysql_error());
                $row_hot = mysql_fetch_assoc($hot);
                $totalRows_hot = mysql_num_rows($hot);
            ?>
          <div class="span3">
        <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門文章 </h4>
        <div class="span3 hot_article" id="hot_article">
              <?php do{ ?>
                <div class="span3 each_hot_article" > <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>"> <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;"> </a> <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>" style="margin-top:10px;"> <?php echo $row_hot['n_title']; ?> </a> </div>
                <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
            </div>
      </div>
          <?php include('ad_content_right.php'); ?>
        </div>
  </div>
      <div class="row"> </div>
    </div>
<?php include('footer.php'); ?>

<script src="assets/js/bootstrap.js"></script> 
<script language="javascript">
	
	$("input[name='ord_pay']").click(function(){
   
     if($(this).val() == "paynow"){
		
		var buy_price = parseInt($("#ord_buy_price").val(),10);
		var ship_price = parseInt($("#ord_ship_price").val(),10);
		var total_price = buy_price + ship_price + <?php echo $row_Product['p_hang_price']; ?>;
		var hand_price = parseInt(<?php echo $row_Product['p_hang_price']; ?>,10);
		
		$("#ord_hand_price").val(hand_price);
		$("#ord_total_price").val(total_price);
		
		$("#ord_hand_price1").html(hand_price);
		$("#ord_total_price1").html(total_price);
		 
	 }else{
		var buy_price = parseInt($("#ord_buy_price").val(),10);
		var ship_price = parseInt($("#ord_ship_price").val(),10);
		var total_price = buy_price + ship_price + 0;
		var hand_price = parseInt(0,10);
		$("#ord_hand_price").val(hand_price);
		$("#ord_total_price").val(total_price);
		
		$("#ord_hand_price1").html(hand_price);
		$("#ord_total_price1").html(total_price); 
	 }
});
	
	
	function chkmail(){
	
	myReg = /^.+@.+\..{2,3}$/
	if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
	form0.submit();	
		
	}
    </script> 
<script src="js/twzipcode-1.4.1.js"></script> 
<script language="javascript">
	//twzip
	$('#twzip').twzipcode({
		css: ['addr-county', 'addr-area', 'addr-zip']	
	});
	</script> 
<script language="javascript">
	function chksum(){
	
	num_no = /^[0-9]/
	num1 = $("#ord_p_num").val();
	
	<?php if($row_Product['p_product2'] == "" && $row_Product['p_product3'] == "" && $row_Product['p_product4'] == "" && $row_Product['p_product5'] == ""){ ?>	
	if(!num1.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_num = parseInt(num1,10) ;
	<?php } ?>
	<?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] == "" && $row_Product['p_product4'] == "" && $row_Product['p_product5'] == ""){  ?>
	var num2 = $("#ord_p_num2").val();
	if(!num1.match(num_no) || !num2.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_num = parseInt(num1,10) + parseInt(num2,10);	
	<?php } ?>
	<?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] <> "" && $row_Product['p_product4'] == "" && $row_Product['p_product5'] == ""){  ?>
	var num2 = $("#ord_p_num2").val();
	var num3 = $("#ord_p_num3").val();
	if(!num1.match(num_no) || !num2.match(num_no) || !num3.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_num = parseInt(num1,10) + parseInt(num2,10) + parseInt(num3,10) ;
	<?php } ?>
	<?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] <> "" && $row_Product['p_product4'] <> "" && $row_Product['p_product5'] == ""){  ?>
	var num2 = $("#ord_p_num2").val();
	var num3 = $("#ord_p_num3").val();
	var num4 = $("#ord_p_num4").val();
	if(!num1.match(num_no) || !num2.match(num_no) || !num3.match(num_no) || !num4.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_num = parseInt(num1,10) + parseInt(num2,10) + parseInt(num3,10) + parseInt(num4,10) ;
	<?php } ?>
	<?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] <> "" && $row_Product['p_product4'] <> "" && $row_Product['p_product5'] <> ""){  ?>
	var num2 = $("#ord_p_num2").val();
	var num3 = $("#ord_p_num3").val();
	var num4 = $("#ord_p_num4").val();
	var num5 = $("#ord_p_num5").val();
	if(!num1.match(num_no) || !num2.match(num_no) || !num3.match(num_no) || !num4.match(num_no) || !num5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_num = parseInt(num1,10) + parseInt(num2,10) + parseInt(num3,10) + parseInt(num4,10) + parseInt(num5,10) ;
	<?php } ?>
	
	//加購商品數量統計與金額統計
	<?php if($row_Product['p_pb1'] <> ''){ ?>
	
	pbnum1 = $("#ord_pb1_num").val();
	
	<?php if($row_Product['p_pb2'] == "" && $row_Product['p_pb3'] == "" && $row_Product['p_pb4'] == "" && $row_Product['p_pb5'] == ""){ ?>	
	if(!pbnum1.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?>;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] == "" && $row_Product['p_pb4'] == "" && $row_Product['p_pb5'] == ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?>;	
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] == "" && $row_Product['p_pb5'] == ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> ;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] <> "" && $row_Product['p_pb5'] == ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	var pbnum4 = $("#ord_pb4_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no) || !pbnum4.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> + parseInt(pbnum4,10)*<?php echo $row_Product['p_pb4_price']; ?> ;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] <> "" && $row_Product['p_pb5'] <> ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	var pbnum4 = $("#ord_pb4_num").val();
	var pbnum5 = $("#ord_pb5_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no) || !pbnum4.match(num_no) || !pbnum5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> + parseInt(pbnum4,10)*<?php echo $row_Product['p_pb4_price']; ?> + parseInt(pbnum5,10)*<?php echo $row_Product['p_pb5_price']; ?> ;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] <> "" && $row_Product['p_pb5'] <> "" && $row_Product['p_pb6'] <> ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	var pbnum4 = $("#ord_pb4_num").val();
	var pbnum5 = $("#ord_pb5_num").val();
	var pbnum6 = $("#ord_pb6_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no) || !pbnum4.match(num_no) || !pbnum5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> + parseInt(pbnum4,10)*<?php echo $row_Product['p_pb4_price']; ?> + parseInt(pbnum5,10)*<?php echo $row_Product['p_pb5_price']; ?> + parseInt(pbnum6,10)*<?php echo $row_Product['p_pb6_price']; ?> ;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] <> "" && $row_Product['p_pb5'] <> "" && $row_Product['p_pb6'] <> "" && $row_Product['p_pb7'] <> ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	var pbnum4 = $("#ord_pb4_num").val();
	var pbnum5 = $("#ord_pb5_num").val();
	var pbnum6 = $("#ord_pb6_num").val();
	var pbnum7 = $("#ord_pb7_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no) || !pbnum4.match(num_no) || !pbnum5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> + parseInt(pbnum4,10)*<?php echo $row_Product['p_pb4_price']; ?> + parseInt(pbnum5,10)*<?php echo $row_Product['p_pb5_price']; ?> + parseInt(pbnum6,10)*<?php echo $row_Product['p_pb6_price']; ?> + parseInt(pbnum7,10)*<?php echo $row_Product['p_pb7_price']; ?> ;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] <> "" && $row_Product['p_pb5'] <> "" && $row_Product['p_pb6'] <> "" && $row_Product['p_pb7'] <> "" && $row_Product['p_pb8'] <> ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	var pbnum4 = $("#ord_pb4_num").val();
	var pbnum5 = $("#ord_pb5_num").val();
	var pbnum6 = $("#ord_pb6_num").val();
	var pbnum7 = $("#ord_pb7_num").val();
	var pbnum8 = $("#ord_pb8_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no) || !pbnum4.match(num_no) || !pbnum5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> + parseInt(pbnum4,10)*<?php echo $row_Product['p_pb4_price']; ?> + parseInt(pbnum5,10)*<?php echo $row_Product['p_pb5_price']; ?> + parseInt(pbnum6,10)*<?php echo $row_Product['p_pb6_price']; ?> + parseInt(pbnum7,10)*<?php echo $row_Product['p_pb7_price']; ?> + parseInt(pbnum8,10)*<?php echo $row_Product['p_pb8_price']; ?> ;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] <> "" && $row_Product['p_pb5'] <> "" && $row_Product['p_pb6'] <> "" && $row_Product['p_pb7'] <> "" && $row_Product['p_pb8'] <> "" && $row_Product['p_pb9'] <> ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	var pbnum4 = $("#ord_pb4_num").val();
	var pbnum5 = $("#ord_pb5_num").val();
	var pbnum6 = $("#ord_pb6_num").val();
	var pbnum7 = $("#ord_pb7_num").val();
	var pbnum8 = $("#ord_pb8_num").val();
	var pbnum9 = $("#ord_pb9_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no) || !pbnum4.match(num_no) || !pbnum5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> + parseInt(pbnum4,10)*<?php echo $row_Product['p_pb4_price']; ?> + parseInt(pbnum5,10)*<?php echo $row_Product['p_pb5_price']; ?> + parseInt(pbnum6,10)*<?php echo $row_Product['p_pb6_price']; ?> + parseInt(pbnum7,10)*<?php echo $row_Product['p_pb7_price']; ?> + parseInt(pbnum8,10)*<?php echo $row_Product['p_pb8_price']; ?> + parseInt(pbnum9,10)*<?php echo $row_Product['p_pb9_price']; ?> ;
	<?php } ?>
	<?php if($row_Product['p_pb2'] <> "" && $row_Product['p_pb3'] <> "" && $row_Product['p_pb4'] <> "" && $row_Product['p_pb5'] <> "" && $row_Product['p_pb6'] <> "" && $row_Product['p_pb7'] <> "" && $row_Product['p_pb8'] <> "" && $row_Product['p_pb9'] <> "" && $row_Product['p_pb10'] <> ""){  ?>
	var pbnum2 = $("#ord_pb2_num").val();
	var pbnum3 = $("#ord_pb3_num").val();
	var pbnum4 = $("#ord_pb4_num").val();
	var pbnum5 = $("#ord_pb5_num").val();
	var pbnum6 = $("#ord_pb6_num").val();
	var pbnum7 = $("#ord_pb7_num").val();
	var pbnum8 = $("#ord_pb8_num").val();
	var pbnum9 = $("#ord_pb9_num").val();
	var pbnum10 = $("#ord_pb10_num").val();
	if(!pbnum1.match(num_no) || !pbnum2.match(num_no) || !pbnum3.match(num_no) || !pbnum4.match(num_no) || !pbnum5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pb_price = parseInt(pbnum1,10)*<?php echo $row_Product['p_pb1_price']; ?> + parseInt(pbnum2,10)*<?php echo $row_Product['p_pb2_price']; ?> + parseInt(pbnum3,10)*<?php echo $row_Product['p_pb3_price']; ?> + parseInt(pbnum4,10)*<?php echo $row_Product['p_pb4_price']; ?> + parseInt(pbnum5,10)*<?php echo $row_Product['p_pb5_price']; ?> + parseInt(pbnum6,10)*<?php echo $row_Product['p_pb6_price']; ?> + parseInt(pbnum7,10)*<?php echo $row_Product['p_pb7_price']; ?> + parseInt(pbnum8,10)*<?php echo $row_Product['p_pb8_price']; ?> + parseInt(pbnum9,10)*<?php echo $row_Product['p_pb9_price']; ?> + parseInt(pbnum10,10)*<?php echo $row_Product['p_pb10_price']; ?> ;
	<?php } ?>
	
	<?php }else{ ?>
	var total_pb_price = 0;
	<?php } ?>
	
	
	
		
	var price = parseInt(<?php echo $row_Product['p_price2']; ?>,10);
	var sum_buy = total_num*price+total_pb_price;
	
	<?php if($row_Product['p_noship_way'] == 2){ ?>
	if( total_num >= <?php echo $row_Product['p_noship_num']; ?> ){ var ship_price = 0 ; }else{ var ship_price = <?php echo $row_Product['p_ship_price']; ?> ; }
	<?php }else{ ?>
	if( sum_buy >= <?php echo $row_Product['p_noship_price']; ?> ){ var ship_price = 0 ; }else{ var ship_price = <?php echo $row_Product['p_ship_price']; ?> ; }
	<?php } ?>
	var hand_price = parseInt($("#ord_hand_price").val(),10);
	
	$("#ord_total_num").val(total_num); 
	$("#ord_buy_price").val(sum_buy); 
	$("#ord_ship_price").val(ship_price);
	$("#ord_total_price").val(sum_buy + ship_price + hand_price);
	
	$("#ord_total_num1").html(total_num); 
	$("#ord_buy_price1").html(sum_buy); 
	$("#ord_ship_price1").html(ship_price);
	$("#ord_total_price1").html(sum_buy + ship_price + hand_price);
	
	
	//}
	
	
	
	//function chkpksum(){
	
	<?php if($row_Product['p_package'] == 'Y'){ ?>
	panum1 = $("#ord_pa1_num").val();
	
	<?php if($row_Product['p_pa2'] == "" && $row_Product['p_pa3'] == "" && $row_Product['p_pa4'] == "" && $row_Product['p_pa5'] == ""){ ?>	
	if(!panum1.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] == "" && $row_Product['p_pa4'] == "" && $row_Product['p_pa5'] == ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10);	
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] == "" && $row_Product['p_pa5'] == ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] <> "" && $row_Product['p_pa5'] == ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	var panum4 = $("#ord_pa4_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no) || !panum4.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) + parseInt(panum4,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] <> "" && $row_Product['p_pa5'] <> ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	var panum4 = $("#ord_pa4_num").val();
	var panum5 = $("#ord_pa5_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no) || !panum4.match(num_no) || !panum5.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) + parseInt(panum4,10) + parseInt(panum5,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] <> "" && $row_Product['p_pa5'] <> ""  && $row_Product['p_pa6'] <> ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	var panum4 = $("#ord_pa4_num").val();
	var panum5 = $("#ord_pa5_num").val();
	var panum6 = $("#ord_pa6_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no) || !panum4.match(num_no) || !panum5.match(num_no)  || !panum6.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) + parseInt(panum4,10) + parseInt(panum5,10) + parseInt(panum6,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] <> "" && $row_Product['p_pa5'] <> ""  && $row_Product['p_pa6'] <> "" && $row_Product['p_pa7'] <> ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	var panum4 = $("#ord_pa4_num").val();
	var panum5 = $("#ord_pa5_num").val();
	var panum6 = $("#ord_pa6_num").val();
	var panum7 = $("#ord_pa7_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no) || !panum4.match(num_no) || !panum5.match(num_no) || !panum6.match(num_no) || !panum7.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) + parseInt(panum4,10) + parseInt(panum5,10) + parseInt(panum6,10) + parseInt(panum7,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] <> "" && $row_Product['p_pa5'] <> ""  && $row_Product['p_pa6'] <> "" && $row_Product['p_pa7'] <> "" && $row_Product['p_pa8'] <> ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	var panum4 = $("#ord_pa4_num").val();
	var panum5 = $("#ord_pa5_num").val();
	var panum6 = $("#ord_pa6_num").val();
	var panum7 = $("#ord_pa7_num").val();
	var panum8 = $("#ord_pa8_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no) || !panum4.match(num_no) || !panum5.match(num_no) || !panum6.match(num_no) || !panum7.match(num_no) || !panum8.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) + parseInt(panum4,10) + parseInt(panum5,10) + parseInt(panum6,10) + parseInt(panum7,10) + parseInt(panum8,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] <> "" && $row_Product['p_pa5'] <> ""  && $row_Product['p_pa6'] <> "" && $row_Product['p_pa7'] <> "" && $row_Product['p_pa8'] <> "" && $row_Product['p_pa9'] <> ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	var panum4 = $("#ord_pa4_num").val();
	var panum5 = $("#ord_pa5_num").val();
	var panum6 = $("#ord_pa6_num").val();
	var panum7 = $("#ord_pa7_num").val();
	var panum8 = $("#ord_pa8_num").val();
	var panum9 = $("#ord_pa9_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no) || !panum4.match(num_no) || !panum5.match(num_no) || !panum6.match(num_no) || !panum7.match(num_no) || !panum8.match(num_no) || !panum9.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) + parseInt(panum4,10) + parseInt(panum5,10) + parseInt(panum6,10) + parseInt(panum7,10) + parseInt(panum8,10) + parseInt(panum9,10) ;
	<?php } ?>
	<?php if($row_Product['p_pa2'] <> "" && $row_Product['p_pa3'] <> "" && $row_Product['p_pa4'] <> "" && $row_Product['p_pa5'] <> ""  && $row_Product['p_pa6'] <> "" && $row_Product['p_pa7'] <> "" && $row_Product['p_pa8'] <> "" && $row_Product['p_pa9'] <> "" && $row_Product['p_pa10'] <> ""){  ?>
	var panum2 = $("#ord_pa2_num").val();
	var panum3 = $("#ord_pa3_num").val();
	var panum4 = $("#ord_pa4_num").val();
	var panum5 = $("#ord_pa5_num").val();
	var panum6 = $("#ord_pa6_num").val();
	var panum7 = $("#ord_pa7_num").val();
	var panum8 = $("#ord_pa8_num").val();
	var panum9 = $("#ord_pa9_num").val();
	var panum10 = $("#ord_pa10_num").val();
	if(!panum1.match(num_no) || !panum2.match(num_no) || !panum3.match(num_no) || !panum4.match(num_no) || !panum5.match(num_no) || !panum6.match(num_no) || !panum7.match(num_no) || !panum8.match(num_no) || !panum9.match(num_no) || !panum10.match(num_no)){alert('數量請輸入半形數字!'); return; }
	var total_pa_num = parseInt(panum1,10) + parseInt(panum2,10) + parseInt(panum3,10) + parseInt(panum4,10) + parseInt(panum5,10) + parseInt(panum6,10) + parseInt(panum7,10) + parseInt(panum8,10) + parseInt(panum9,10) + parseInt(panum10,10);
	<?php } ?>
			
	var pa_buy_num = $("#ord_total_num").val();
	var pa_unit_num = <?php echo $row_Product['p_package_num']; ?>;
	var pa_unit_per = <?php echo $row_Product['p_package_per']; ?>;
	var pa_get_num = Math.floor(pa_buy_num/pa_unit_per);
	var pa_total_num = pa_get_num*pa_unit_num;	
	
	if( total_pa_num < pa_total_num && pa_total_num != 0){ num_minus = pa_total_num - total_pa_num;  num_notice = '您尚可選擇' + num_minus + '項搭贈商品。'; $("#pa_choice_num").html(num_notice); }
	if( total_pa_num > pa_total_num && pa_total_num != 0){ num_minus = total_pa_num - pa_total_num;  num_notice = '您多選擇了' + num_minus + '項搭贈商品。'; $("#pa_choice_num").html(num_notice);}
	if( total_pa_num == pa_total_num && pa_total_num != 0){ num_notice = '您已經選擇了正確的搭配商品數目！'; $("#pa_choice_num").html(num_notice);}
	if( pa_total_num == 0){ 
		num_notice = '團購主商品數量未達<?php echo $row_Product['p_package_per']; ?>份，不須選填此區。'; 
		$("#pa_choice_num").html(num_notice);
		$("#ord_pa1_num").val('0');
		$("#ord_pa2_num").val('0');
		$("#ord_pa3_num").val('0');
		$("#ord_pa4_num").val('0');
		$("#ord_pa5_num").val('0');
		$("#ord_pa6_num").val('0');
		$("#ord_pa7_num").val('0');
		$("#ord_pa8_num").val('0');
		$("#ord_pa9_num").val('0');
		$("#ord_pa10_num").val('0');
		
		}
	<?php } ?>
	
	
	
	
	}
	
	
	function chkorder(){

  chksum();
 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  
  <?php if($row_Product['p_product2'] == "" && $row_Product['p_product3'] == "" && $row_Product['p_product4'] == "" && $row_Product['p_product5'] == ""){ ?>
  if( $("#ord_p_num").val() == "" || $("#ord_p_num").val() == 0){alert('請至少輸入一項主要商品的數量，沒有購買的品項請填入0，不要留白!'); return; }
  <?php } ?>
  
  <?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] == "" && $row_Product['p_product4'] == "" && $row_Product['p_product5'] == ""){ ?>
  if( ($("#ord_p_num").val() == "" || $("#ord_p_num").val() == 0) && ($("#ord_p_num2").val() == "" || $("#ord_p_num2").val() == 0)){alert('請至少輸入一項主要商品的數量，沒有購買的品項請填入0，不要留白!'); return; }
  <?php } ?>
  
  <?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] <> "" && $row_Product['p_product4'] == "" && $row_Product['p_product5'] == ""){ ?>
  if( ($("#ord_p_num").val() == "" || $("#ord_p_num").val() == 0) && ($("#ord_p_num2").val() == "" || $("#ord_p_num2").val() == 0) && ($("#ord_p_num3").val() == "" || $("#ord_p_num3").val() == 0)){alert('請至少輸入一項主要商品的數量，沒有購買的品項請填入0，不要留白!'); return; }
  <?php } ?>
  
  <?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] <> "" && $row_Product['p_product4'] <> "" && $row_Product['p_product5'] == ""){ ?>
  if( ($("#ord_p_num").val() == "" || $("#ord_p_num").val() == 0) && ($("#ord_p_num2").val() == "" || $("#ord_p_num2").val() == 0) && ($("#ord_p_num3").val() == "" || $("#ord_p_num3").val() == 0) && ($("#ord_p_num4").val() == "" || $("#ord_p_num4").val() == 0)){alert('請至少輸入一項主要商品的數量，沒有購買的品項請填入0，不要留白!'); return; }
  <?php } ?>
  
  <?php if($row_Product['p_product2'] <> "" && $row_Product['p_product3'] <> "" && $row_Product['p_product4'] <> "" && $row_Product['p_product5'] <> ""){ ?>
  if( ($("#ord_p_num").val() == "" || $("#ord_p_num").val() == 0) && ($("#ord_p_num2").val() == "" || $("#ord_p_num2").val() == 0) && ($("#ord_p_num3").val() == "" || $("#ord_p_num3").val() == 0) && ($("#ord_p_num4").val() == "" || $("#ord_p_num4").val() == 0) && ($("#ord_p_num5").val() == "" || $("#ord_p_num5").val() == 0)){alert('請至少輸入一項主要商品的數量，沒有購買的品項請填入0，不要留白!'); return; }
  <?php } ?>
  
  <?php if($row_Product['p_package'] == 'Y'){ ?>
  var ord_gp_buy_num = $("#ord_total_num").val();
  var ord_gp_per_num = <?php echo $row_Product['p_package_per']; ?>;
  var ord_gp_get_num = Math.floor(ord_gp_buy_num/ord_gp_per_num);
  var ord_pa_num = ord_gp_get_num*<?php echo $row_Product['p_package_num']; ?>;
  
  <?php if($row_Product['p_pa1'] != ""){ ?>
  var papa1 = parseInt($("#ord_pa1_num").val(),10); 
  <?php } else {?>
  var papa1 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa2'] != ""){ ?>
  var papa2 = parseInt($("#ord_pa2_num").val(),10); 
  <?php } else {?>
  var papa2 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa3'] != ""){ ?>
  var papa3 = parseInt($("#ord_pa3_num").val(),10); 
  <?php } else {?>
  var papa3 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa4'] != ""){ ?>
  var papa4 = parseInt($("#ord_pa4_num").val(),10); 
  <?php } else {?>
  var papa4 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa5'] != ""){ ?>
  var papa5 = parseInt($("#ord_pa5_num").val(),10); 
  <?php } else {?>
  var papa5 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa6'] != ""){ ?>
  var papa6 = parseInt($("#ord_pa6_num").val(),10); 
  <?php } else {?>
  var papa6 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa7'] != ""){ ?>
  var papa7 = parseInt($("#ord_pa7_num").val(),10); 
  <?php } else {?>
  var papa7 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa8'] != ""){ ?>
  var papa8 = parseInt($("#ord_pa8_num").val(),10); 
  <?php } else {?>
  var papa8 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa9'] != ""){ ?>
  var papa9 = parseInt($("#ord_pa9_num").val(),10); 
  <?php } else {?>
  var papa9 = 0;
  <?php } ?>
  
  <?php if($row_Product['p_pa10'] != ""){ ?>
  var papa10 = parseInt($("#ord_pa10_num").val(),10); 
  <?php } else {?>
  var papa10 = 0;
  <?php } ?>
  
  var ord_pa_choice_num = papa1 + papa2 + papa3 + papa4 + papa5 + papa6 + papa7 + papa8 + papa9 + papa10 ;
  
  if(ord_pa_choice_num != ord_pa_num && ord_pa_num > 0){alert('搭贈商品數量有誤，請重新檢查！'); return; }
  
  <?php } ?>
  
  telno = /^[0-9]{8}/
  
  if( $("#ord_ship_name").val() == ""){alert('請輸入收貨人姓名!'); return; } 
  if( $("#ord_ship_address").val() == "" || $("select[name='county']").val() == "" || $("select[name='district']").val() == "" || $("input[name='zipcode']").val() == ""){alert('請輸入完整收貨地址!'); return; }  
  if( $("#ord_ship_mobile").val() =="" || !$("#ord_ship_mobile").val().match(mobileReg)){alert('請輸入收貨人人正確之手機號碼！'); return; }
  
  if( $("#ord_ship_fa_id").val() != "" ){
	  if( !$("#ord_ship_fa_id").val().match(telno) ){ alert('公司統編請輸入8碼半形數字！'); return; }
  }
  
  if(window.confirm('是否確定送出訂單?\n訂單送出後，將無法再修改商品種類與數量。\n若有修改需求，請重新送出詢問單，原未付款訂單將失效。\n按「確認」送出訂單，「取消」將重新檢視訂單。')){
  $("#form1").submit();
  }
}
	$("#reset_data").click(function(){
    
        $("#ord_p_num").val("0");
        chksum();
        $("#ord_ship_fa_name").val("");
        $("#ord_ship_fa_id").val("");
        $('html, body').scrollTop(0);

    });
    </script>
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
mysql_free_result($Product);
mysql_free_result($hot);
?>
