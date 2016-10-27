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
if (isset($_GET['ord_id'])) {
  $colname_Recordset1 = $_GET['ord_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = sprintf("SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id WHERE ord_id = '%s'", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if($row_Recordset1['ord_acc_id'] <> $_SESSION['MEM_ID']){
	msg_box('存取錯誤！');
	go_to('index.php');
	exit;
}
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
    <SCRIPT language="JavaScript" type="text/javascript">
<!-- Yahoo! Taiwan Inc.
window.ysm_customData = new Object();
window.ysm_customData.conversion = "transId=,currency=,amount=";
var ysm_accountid  = "1E9G5I09QOHAUGVMHDL0GUDIQS0";
document.write("<SCR" + "IPT language='JavaScript' type='text/javascript' "
+ "SRC=//" + "srv1.wa.marketingsolutions.yahoo.com" + "/script/ScriptServlet" + "?aid=" + ysm_accountid
+ "></SCR" + "IPT>");
// -->
</SCRIPT>
  </head>
  <body>
  <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-VG6V2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-VG6V2');</script>
<!-- End Google Tag Manager -->
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
        <h3><img src="images/wine_icon1.png" width="50" height="50"> <span class="title">訂單詳細內容</span></h3><hr> 
        <form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="form1"> 
          <table class="table table-striped table-bordered">
						  <tbody>
							<tr>
							  <td class="center">訂單成立日期</td>
							  <td><?php echo $row_Recordset1['ord_date']; ?></td>
							</tr>
							<tr>
							  <td class="center">訂單編號</td>
							  <td><?php echo $row_Recordset1['ord_code']; ?></td>
						    </tr>
							<tr>
							  <td class="center">團購商品名稱</td>
							  <td><?php echo $row_Recordset1['p_name']; ?></td>
						    </tr>
							<tr>
							  <td class="center">商品金額</td>
							  <td>NT$ <?php echo $row_Recordset1['p_price2']; ?>元</td>
						    </tr>
							<tr>
							  <td class="center">數量</td>
							  <td>  主要商品：<br>
                  (1) <?php echo $row_Recordset1['p_product1']; ?>：<?php echo $row_Recordset1['ord_p_num']; ?><br>
                  <?php if($row_Recordset1['p_product2'] <> ""){ ?>
                  (2) <?php echo $row_Recordset1['p_product2']; ?>：<?php echo $row_Recordset1['ord_p_num2']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_product3'] <> ""){ ?>
                  (3) <?php echo $row_Recordset1['p_product3']; ?>：<?php echo $row_Recordset1['ord_p_num3']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_product4'] <> ""){ ?>
                  (4) <?php echo $row_Recordset1['p_product4']; ?>：<?php echo $row_Recordset1['ord_p_num4']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_product5'] <> ""){ ?>
                  (5) <?php echo $row_Recordset1['p_product5']; ?>：<?php echo $row_Recordset1['ord_p_num5']; ?><br>
                  <?php } ?>
                  
                  <?php if($row_Recordset1['p_pb1'] <> ""){ ?>
                  加購商品：<br>
                  (1) <?php echo $row_Recordset1['p_pb1']; ?>：<?php echo $row_Recordset1['ord_pb1_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb2'] <> ""){ ?>
                  (2) <?php echo $row_Recordset1['p_pb2']; ?>：<?php echo $row_Recordset1['ord_pb2_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb3'] <> ""){ ?>
                  (3) <?php echo $row_Recordset1['p_pb3']; ?>：<?php echo $row_Recordset1['ord_pb3_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb4'] <> ""){ ?>
                  (4) <?php echo $row_Recordset1['p_pb4']; ?>：<?php echo $row_Recordset1['ord_pb4_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb5'] <> ""){ ?>
                  (5) <?php echo $row_Recordset1['p_pb5']; ?>：<?php echo $row_Recordset1['ord_pb5_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb6'] <> ""){ ?>
                  (6) <?php echo $row_Recordset1['p_pb6']; ?>：<?php echo $row_Recordset1['ord_pb6_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb7'] <> ""){ ?>
                  (7) <?php echo $row_Recordset1['p_pb7']; ?>：<?php echo $row_Recordset1['ord_pb7_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb8'] <> ""){ ?>
                  (8) <?php echo $row_Recordset1['p_pb8']; ?>：<?php echo $row_Recordset1['ord_pb8_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb9'] <> ""){ ?>
                  (9) <?php echo $row_Recordset1['p_pb9']; ?>：<?php echo $row_Recordset1['ord_pb9_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pb10'] <> ""){ ?>
                  (10) <?php echo $row_Recordset1['p_pb10']; ?>：<?php echo $row_Recordset1['ord_pb10_num']; ?><br>
                  <?php } ?>
                  
                  <?php if($row_Recordset1['p_pa1'] <> ""){ ?>
                  搭配物件：<br>
                  (1) <?php echo $row_Recordset1['p_pa1']; ?>：<?php echo $row_Recordset1['ord_pa1_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa2'] <> ""){ ?>
                  (2) <?php echo $row_Recordset1['p_pa2']; ?>：<?php echo $row_Recordset1['ord_pa2_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa3'] <> ""){ ?>
                  (3) <?php echo $row_Recordset1['p_pa3']; ?>：<?php echo $row_Recordset1['ord_pa3_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa4'] <> ""){ ?>
                  (4) <?php echo $row_Recordset1['p_pa4']; ?>：<?php echo $row_Recordset1['ord_pa4_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa5'] <> ""){ ?>
                  (5). <?php echo $row_Recordset1['p_pa5']; ?>：<?php echo $row_Recordset1['ord_pa5_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa6'] <> ""){ ?>
                  (6). <?php echo $row_Recordset1['p_pa6']; ?>：<?php echo $row_Recordset1['ord_pa6_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa7'] <> ""){ ?>
                  (7). <?php echo $row_Recordset1['p_pa7']; ?>：<?php echo $row_Recordset1['ord_pa7_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa8'] <> ""){ ?>
                  (8). <?php echo $row_Recordset1['p_pa8']; ?>：<?php echo $row_Recordset1['ord_pa8_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa9'] <> ""){ ?>
                  (9). <?php echo $row_Recordset1['p_pa9']; ?>：<?php echo $row_Recordset1['ord_pa9_num']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_pa10'] <> ""){ ?>
                  (10). <?php echo $row_Recordset1['p_pa10']; ?>：<?php echo $row_Recordset1['ord_pa10_num']; ?><br>
                  <?php } ?>
                  
                             </td>
						    </tr>
							<tr>
							  <td class="center">小計</td>
							  <td>NT$ <?php echo $row_Recordset1['ord_buy_price']; ?>元</td>
						    </tr>
							<tr>
							  <td class="center">運費</td>
							  <td>NT$ <?php echo $row_Recordset1['ord_ship_price']; ?>元</td>
						    </tr>
							<tr>
							  <td class="center">手續費</td>
							  <td>NT$ <?php echo $row_Recordset1['ord_hand_price']; ?>元</td>
						    </tr>
							<tr>
							  <td class="center">合計</td>
							  <td>NT$ <?php echo $row_Recordset1['ord_total_price']; ?>元</td>
						    </tr>
							<tr>
							  <td class="center">收件人姓名</td>
							  <td><?php echo $row_Recordset1['ord_ship_name']; ?></td>
						    </tr>
							<tr>
							  <td class="center">收件人地址</td>
							  <td><?php echo $row_Recordset1['ord_ship_zip']; ?><?php echo $row_Recordset1['ord_ship_county']; ?><?php echo $row_Recordset1['ord_ship_city']; ?><?php echo $row_Recordset1['ord_ship_address']; ?></td>
						    </tr>
							<tr>
							  <td class="center">收件人手機</td>
							  <td><?php echo $row_Recordset1['ord_ship_mobile']; ?></td>
						    </tr>
							<tr>
							  <td class="center">收件人e-mail</td>
							  <td><?php echo $row_Recordset1['ord_ship_email']; ?></td>
						    </tr>
                            <tr>
							  <td class="center">公司抬頭</td>
							  <td><?php echo $row_Recordset1['ord_ship_fa_name']; ?></td>
						    </tr>
							<tr>
							  <td class="center">公司統編</td>
							  <td><?php echo $row_Recordset1['ord_ship_fa_id']; ?></td>
						    </tr>
							<tr>
							  <td class="center">備註</td>
							  <td><?php echo $row_Recordset1['ord_memo']; ?></td>
						    </tr>
                        <?php if($row_Recordset1['ord_pay'] == "atm_cathy"){ ?>
                        	<tr>
							  <td class="center">匯款資訊</td>
							  <td style="color:#F00">匯款銀行代號與名稱：013 國泰世華銀行 松山分行<br>
                              	  戶名：共鳴議題股份有限公司<br>
                                  專屬匯款帳號：<?php echo $row_Recordset1['ord_atm_5code']; ?>
                              </td>
						    </tr>
                        <?php } ?>
							<tr>
							  <td class="center">訂單狀態</td>
							  <td><?php 
						switch($row_Recordset1['ord_status']){
							case '1':
							echo "未處理";
							break;
							case '2':
							echo "付款失敗";
							//echo "<a href=\"checkout_webatm.php?ord_code=".$row_Recordset1['ord_code']."\">我要重新付款</a>";
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
							echo "取消洽詢單中";
							break;
							case '95':
							echo "未轉帳，已取消洽詢單";
							break;
							case '99':
							echo "無效洽詢單";
							break;
						}
						
						?></td>
						    </tr>
                            <?php if($row_Recordset1['ord_status'] == '4' && $row_Recordset1['ord_ship_code'] <> ''){ ?>
                            <?php } ?>
						  </tbody>
					  </table>
                      <div align="center">
                      <a class="btn btn-primary" href="myorder.php">
										<i class="icon-arrow-left icon-white"></i>  
										回訂單列表                                            
									</a>
                      </div>
                      <input type="hidden" name="MM_update" value="form1">
          </form>
          
        </div>
        <div class="span3" id="LeftContent" align="center">
        <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine嚴選</h4>
        <?php include('ad_1.php'); ?>
        <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
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
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-43241974-1']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_set', 'currencyCode', 'TWD']);
  _gaq.push(['_addTrans',
    '<?php echo $row_Recordset1['ord_id']; ?>',           // transaction ID - required
    'iWine',  // affiliation or store name
    '<?php echo $row_Recordset1['ord_total_price']; ?>',          // total - required
    '0',           // tax
    '<?php echo $row_Recordset1['ord_ship_price']; ?>',              // shipping
    '<?php echo $row_Recordset1['ord_ship_city']; ?>',       // city
    '<?php echo $row_Recordset1['ord_ship_county']; ?>',     // state or province
    'Taiwan'             // country
  ]);

   // add item might be called for every item in the shopping cart
   // where your ecommerce engine loops through each item in the cart and
   // prints out _addItem for each
  _gaq.push(['_addItem',
    '<?php echo $row_Recordset1['ord_id']; ?>',           // transaction ID - required
    '<?php echo $row_Recordset1['p_id']; ?>',           // SKU/code - required
    '<?php echo $row_Recordset1['p_name']; ?>',        // product name
    '<?php echo $row_Recordset1['p_code']; ?>',   // category or variation
    '<?php echo $row_Recordset1['p_price2']; ?>',          // unit price - required
    '<?php echo $row_Recordset1['ord_p_num']+$row_Recordset1['ord_p_num2']+$row_Recordset1['ord_p_num3']+$row_Recordset1['ord_p_num4']+$row_Recordset1['ord_p_num5']; ?>'               // quantity - required
  ]);
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers


  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
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
