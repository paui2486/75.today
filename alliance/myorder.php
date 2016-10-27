<?php include('session_check.php'); ?>
<?php include_once('../bitly/bitly.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
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

$_date1 = $_SESSION['ALLIANCE_LAST_SUM_DATE'];
$_date2 = date('Y-m-d');
$_am_code = $_SESSION['ALLIANCE_CODE'];
$_am_ratio = $_SESSION['ALLIANCE_RATIO']/100;

mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = "SELECT *, SUM(ord_buy_price) AS t_price, COUNT(*) AS t_num FROM order_list WHERE ord_date >= '$_date1' AND ord_date <= '$_date2' AND am_code = '$_am_code' AND ord_status = '4' GROUP BY ord_date ORDER BY ord_id ASC";
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Project_list = "-1";
if (isset($_SESSION['ALLIANCE_ID'])) {
  $colname_Project_list = $_SESSION['ALLIANCE_ID'];
}
mysql_select_db($database_iwine, $iwine);
$query_Project_list = sprintf("SELECT * FROM alliance_project LEFT JOIN alliance_case ON alliance_project.ap_ac_id = alliance_case.ac_id WHERE ap_am_id = '%s' ORDER BY ap_modify_datetime DESC", GetSQLValueString($colname_Project_list, "int"));
$Project_list = mysql_query($query_Project_list, $iwine) or die(mysql_error());
$row_Project_list = mysql_fetch_assoc($Project_list);
$totalRows_Project_list = mysql_num_rows($Project_list);

$colname_Pay_list = "-1";
if (isset($_SESSION['ALLIANCE_ID'])) {
  $colname_Pay_list = $_SESSION['ALLIANCE_ID'];
}
mysql_select_db($database_iwine, $iwine);
$query_Pay_list = sprintf("SELECT * FROM alliance_pay WHERE ay_am_id = '%s' ORDER BY ay_record DESC", GetSQLValueString($colname_Pay_list, "int"));
$Pay_list = mysql_query($query_Pay_list, $iwine) or die(mysql_error());
$row_Pay_list = mysql_fetch_assoc($Pay_list);
$totalRows_Pay_list = mysql_num_rows($Pay_list);
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> iWine 聯盟行銷</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
      </script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
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
    <div class="container">
      <div id="header">
      	<div>
        <p><a href="index.php"><img src="../images/logo.png" alt="iWine"></a>聯盟行銷</p>
        	
        	
        </div>
        
      </div>
      <ul class="nav nav-pills">
        <div id="nav_menu" class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
              <?php include('mainmenu.php'); ?>
            </div>
          </div>
        </div>
      </ul>
      
      <div class="row">
      	<div id="MainContent" class="span6">
        <h4>參與專案</h4>  
            <table class="table table-striped table-bordered">
						  <thead>
							  <tr>
							    <th>專案名稱</th>
							    <th>專屬網址</th>
							    <th>累積點擊次數</th>
							  </tr>
						  </thead>   
						  <tbody>
                            <?php if ($totalRows_Project_list > 0) { // Show if recordset not empty ?>
                              <?php do { ?>
                                <tr>
                                  <td class="center"><?php echo $row_Project_list['ac_title']; ?></td>
                                  <td><a href="<?php echo $row_Project_list['ap_url_short']; ?>" target="new"><?php echo $row_Project_list['ap_url_short']; ?></a></td>
                                  <td class="center"><?php $_clicks = bitly_v3_clicks($row_Project_list['ap_url_short']); echo $_clicks[0]['global_clicks']; ?></td>
                                </tr>
								<?php } while ($row_Project_list = mysql_fetch_assoc($Project_list)); ?>
                                
                              <?php } // Show if recordset not empty ?>
                            <?php if ($totalRows_Project_list == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="3" class="center">目前尚未參與專案</td>
  </tr>
  <?php } // Show if recordset empty ?>
                          </tbody>
		  </table>
                      <div align="center">
                      <a class="btn btn-success" href="javascript:window.location.reload();">
										<i class="icon-repeat icon-white"></i>  
										更新                                            
						</a>
                      </div>
        <p></p>
        
        <h4>結算記錄</h4>  
            <table class="table table-striped table-bordered">
						  <thead>
							  <tr>
							    <th>起算日</th>
							    <th>結算日</th>
							    <th>申請日</th>
							    <th>金額</th>
							    <th>狀態</th>
							    <th>備註</th>
							  </tr>
						  </thead>   
						  <tbody>
                            <?php if ($totalRows_Pay_list > 0) { // Show if recordset not empty ?>
                              <?php do { ?>
                                <tr>
                                  <td class="center"><?php echo $row_Pay_list['ay_start']; ?></td>
                                  <td><?php echo $row_Pay_list['ay_end']; ?></td>
                                  <td class="center"><?php echo $row_Pay_list['ay_record']; ?></td>
                                  <td class="center"><?php echo $row_Pay_list['ay_money']; ?></td>
                                  <td class="center"><?php echo $row_Pay_list['ay_status']; ?></td>
                                  <td class="center"><?php echo $row_Pay_list['ay_memo']; ?></td>
                                </tr>
								<?php } while ($row_Pay_list = mysql_fetch_assoc($Pay_list)); ?>
                                
                              <?php } // Show if recordset not empty ?>
                            <?php if ($totalRows_Pay_list == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="6" class="center">目前尚無結算記錄</td>
  </tr>
  <?php } // Show if recordset empty ?>
                          </tbody>
		  </table>
        <p></p>  
        </div>
        
        
        
        <div id="MainContent" class="span6">
        <h4>交易成效記錄<?php if($_date1 <> ""){ ?>（前次結算日：<?php echo $_date1; ?>）<?php } ?></h4>  
            <table class="table table-striped table-bordered">
						  <thead>
							  <tr>
							    <th>訂單日期</th>
							    <th>已完成交易訂單數</th>
								  <th>已完成交易訂單總金額</th>
								  <th>可分潤金額</th>
							  </tr>
						  </thead>   
						  <tbody>
                            <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
                              <?php do { ?>
                                <tr>
                                  <td class="center"><?php echo $row_Recordset1['ord_date']; ?></td>
                                  <td><?php echo $row_Recordset1['t_num']; ; $tt_num = $tt_num + $row_Recordset1['t_num']; ?></td>
                                  <td><?php echo $row_Recordset1['t_price']; $tt_price = $tt_price + $row_Recordset1['t_price']; ?></td>
                                  <td class="center"><?php echo $_pay = round($row_Recordset1['t_price']*$_am_ratio,0); $tt_num2 = $tt_num2 + $_pay; ?></td>
                                </tr>
								<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                                <tr>
                                  <td bgcolor="#FFCC99" class="center"><strong>合計</strong></td>
                                  <td bgcolor="#FFCC99"><strong><?php echo $tt_num; ?></strong></td>
                                  <td bgcolor="#FFCC99"><strong><?php echo $tt_price; ?></td>
                                  <td bgcolor="#FFCC99" class="center"><strong><?php echo $tt_num2; ?></strong></td>
                              </tr>
                                
                              <?php } // Show if recordset not empty ?>
                            <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="4" class="center">目前無交易資料</td>
  </tr>
  <?php } // Show if recordset empty ?>
                          </tbody>
					  </table>
                      <div align="center">
                      <?php if($tt_num2 >= 1000){ ?>
                      <a class="btn btn-primary" href="javascript:alert('本功能尚未開放！');">
										<i class="icon-shopping-cart icon-white"></i>  
										我要結算                                            
									</a>
                      <?php } ?>
                      </div>
        <p></p>  
        </div>
        <div class="span3" id="LeftContent" align="center">
        </div>
      </div>
      
      <div class="row">
      <div id="footer" class="span12" align="center" style="border-color:#000000; border-width: 1px; border-style:solid;"> 
           <table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr>
    <td align="center" valign="middle"><p style="font-size:12px">本站採用HTML5建置，為達到最佳瀏覽效果，建議使用Chrome，Safari，FireFox等瀏覽器</p>
      <p style="font-size:12px"><img src="../images/logo2_small.jpg" alt="iWine" style="border-color:#000000; border-width: 1px; border-style:solid">&nbsp;&nbsp;&nbsp;&nbsp;© 2013 iWine 聯盟行銷. All Rights Reserved</p><p style="font-size:12px">法律顧問：圓方法律事務所</p>
<p style="font-size:12px"><a href="law.php" style="color:#000">《使用者條款》</a></p></td>
    <td width="18%"><img src="../images/qrcode.png" style="border-color:#000000; border-width: 1px; border-style:solid"></td>
  </tr>
</table></div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="../assets/js/bootstrap.js">
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

mysql_free_result($Project_list);

mysql_free_result($Pay_list);
?>
