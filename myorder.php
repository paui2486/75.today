<?php include('session_check.php'); ?>
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

$colname_Recordset1 = "-1";
if (isset($_SESSION['MEM_ID'])) {
  $colname_Recordset1 = $_SESSION['MEM_ID'];
}
mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = sprintf("SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id WHERE ord_acc_id = '%s' ORDER BY ord_id DESC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
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
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=540353706035158";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php include('mainmenu_20140903.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
        <div id="MainContent" class="span9">
        <h3><img src="images/wine_icon1.png" width="50" height="50"> <span class="title">我的訂單查詢</span></h3><hr>  
            <table class="table table-striped table-bordered">
						  <thead>
							  <tr>
							    <th>訂單成立日期</th>
							    <th>訂單編號</th>
								  <th>團購商品名稱</th>
								  <th>商品金額(每份)</th>
								  <th>小計</th>
								  <th>運費</th>
								  <th>手續費</th>
								  <th>合計</th>
								  <th>狀態</th>
								  <th style="min-width: 45px;" >檢視</th>
							  </tr>
						  </thead>   
						  <tbody>
                            <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
                              <?php do { ?>
                                <tr>
                                  <td class="center"><?php echo $row_Recordset1['ord_date']; ?></td>
                                  <td><?php echo $row_Recordset1['ord_code']; ?></td>
                                  <td><?php echo $row_Recordset1['p_name']; ?></td>
                                  <td class="center"><?php echo $row_Recordset1['p_price2']; ?></td>
                                  <td class="center"><?php echo $row_Recordset1['ord_buy_price']; ?></td>
                                  <td class="center"><?php echo $row_Recordset1['ord_ship_price']; ?></td>
                                  <td class="center"><?php echo $row_Recordset1['ord_hand_price']; ?></td>
                                  <td class="center"><?php echo $row_Recordset1['ord_total_price']; ?></td>
                                  <td class="center">
                                  <?php 
						switch($row_Recordset1['ord_status']){
							case '1':
							echo "未處理";
							break;
							case '2':
							echo "付款失敗";
							break;
							case '3':
							echo "已付款，準備出貨中";
							break;
							case '4':
							echo "已出貨";
							break;
							case '5':
							echo "尚未匯款";
							break;
							case '6':
							echo "對帳中";
							break;
							case '7':
							echo "對帳失敗，請重填匯款帳號後5碼";
							break;
							case '8':
							echo "已簽收";
							break;
							case '9':
							echo "未簽收退回";
							break;
							case '10':
							echo "缺貨中";
							break;
							case '11':
							echo "貨到付款尚未出貨";
							break;
							case '21':
							echo "查無帳款，請與我們聯繫";
							break;
							case '22':
							echo "金額不符，請與我們聯繫";
							break;
							case '91':
							echo "退貨申請中";
							break;
							case '92':
							echo "退貨中";
							break;
							case '93':
							echo "退貨完成";
							break;
							case '94':
							echo "取消訂單中";
							break;
							case '95':
							echo "未轉帳，已取消訂單";
							break;
							case '99':
							echo "無效訂單";
							break;
						}
						
						?>
                                  </td>
                                  <td class="center"><a class="btn btn-mini btn-warning" href="myorder_s.php?ord_id=<?php echo $row_Recordset1['ord_id']; ?>">詳細</a></td>
                                </tr>
                                <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                              <?php } // Show if recordset not empty ?>
                            <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="10" class="center">目前訂單資料</td>
  </tr>
  <?php } // Show if recordset empty ?>
                          </tbody>
					  </table>
          
        </div>
        <h4 align="left">
        <div class="span3" id="LeftContent" align="center">
         <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門排行</h4>
        <?php include('ad_1.php'); ?>
        <!--h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        <!--
        <table width="252" border="0">
  <tr>
    <td><div class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="252" data-show-faces="true" data-stream="true" data-header="true"></div></td>
  </tr>
</table>
        -->
        <p></p>
        
        </div>
      </div>
      
      
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
    <script language="javascript">
	function chkmail(){
	
	myReg = /^.+@.+\..{2,3}$/
	if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
	form0.submit();	
		
	}
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
mysql_free_result($Recordset1);
?>
