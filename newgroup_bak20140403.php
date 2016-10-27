<?php include('session_record.php'); ?>
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

$_today = date('Y-m-d');

mysql_select_db($database_iwine, $iwine);
$query_newgroup = "SELECT * FROM Product WHERE p_online = 'Y' AND p_start_time <= '$_today' AND p_end_time >= '$_today' ORDER BY p_order ASC";
$newgroup = mysql_query($query_newgroup, $iwine) or die(mysql_error());
$row_newgroup = mysql_fetch_assoc($newgroup);
$totalRows_newgroup = mysql_num_rows($newgroup);
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>iWine嚴選 - iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="iPet團體網最新進行中的各項團體">
    <meta name="author" content="">
    <meta property="og:title" content="iPet團體網最新進行中的各項團體">
	<meta property="og:site_name" content="iWine嚴選 - iWine">
	<meta property="og:image" content="http://www.iwine.com.tw/webimages/products/<?php echo $row_newgroup['p_file2']; ?>">
	<meta property="og:type" content="website">
    <meta property="fb:admins" content="1685560618"/>
	<meta property="fb:app_id" content="540353706035158">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style>
      
    </style>
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
        <h3><img src="images/wine_icon1.png" width="50" height="50"><span class="title">iWine嚴選</span></h3>
        <span class="span8"><img src="images/line03.png"></span>
        <div class="row">
          <?php if ($totalRows_newgroup > 0) { // Show if recordset not empty ?>
              <?php do { ?>
                <div class="span3">
                  <table width="100%" border="1" cellspacing="1" cellpadding="5" style="border:#C7B299">
                    <tr>
                          <td height="80" align="center" class="tb1" style="color: #65503C; font-weight: bold;"><?php echo $row_newgroup['p_name']; ?></td>
                        </tr>
                    <tr>
                      <td><table width="100%" border="0" cellspacing="1" cellpadding="5">           
                        <tr>
                          <td height="165" align="center"><a href="content.php?p_id=<?php echo $row_newgroup['p_id']; ?>"><img src="http://admin.iwine.com.tw/webimages/products/<?php echo $row_newgroup['p_file1']; ?>" width="250" height="158"></a></td>
                        </tr>
                        <tr>
                          <td height="30" align="center"><strike>原價：NT$<?php echo $row_newgroup['p_price1']; ?></strike></td>
                        </tr>
                        <tr>
                          <td align="center"><h4><span style="color:#FC91A2">團體：<?php if($row_newgroup['p_login_price']=="Y"){if($_SESSION['MEM_ID']<>""){echo "NT$".$row_newgroup['p_price2'];}else{ echo "請先登入會員"; }}else{ echo "NT$".$row_newgroup['p_price2'];} ?></span></h4></td>
                        </tr>
                        <tr>
                          <td align="center">團體截止日：<?php echo $row_newgroup['p_end_time']; ?></td>
                        </tr>
                        <?php /*start db_input script*/ if ($row_newgroup['p_outside'] == "N"){ ?>
                            <?php if($row_newgroup['p_limit'] == "Y"){ ?>
                          <tr>
                            <td align="center">限量<?php echo $row_newgroup['p_limit_num']; ?>份，已登記 <?php echo $row_newgroup['p_sale_num']; ?> 份</td>
                          </tr>
                            <?php }else{ ?>
                          <tr>
                            <td align="center">目前已登記 <?php echo $row_newgroup['p_sale_num']; ?> 份</td>
                          </tr>
                          <?php } 
                          }else{ /*end db_input script*/ ?>
                          <tr>
                            <td align="center">&nbsp;</td>
                          </tr>
                            <?php } ?>
                        <tr>
                          <td align="center"><p></p><p><a class="btn btn-medium btn-danger" href="content.php?p_id=<?php echo $row_newgroup['p_id']; ?>"><i class="icon-shopping-cart icon-white"></i> <strong>去看看</strong></a></p></td>
                        </tr>
                      </table>
                      </td>
                    </tr>
                  </table>
                  <p></p>
                </div>
              <?php } while ($row_newgroup = mysql_fetch_assoc($newgroup)); ?>
          <?php }else{ // Show if recordset not empty ?>
            <div class="span9" style="height: 500px;">
            <p>敬請期待～</p>
            </div>
          <?php } ?>
        </div>
        <div class="row">
            <div class="span9" style="border:solid 0px #000000; margin-bottom:10px">
                <div  style="margin-left:30px;"class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
                </div>
            </div>
        </div>
        
        <div class="row">
        <div class="span3" align="center"  id="hot_position">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine 排行榜 </h4>
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
            <div class="span3 each_hot_article" >
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>">
                <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                </a>
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>" style="margin-top:10px;">
                <?php echo $row_hot['n_title']; ?>
                </a>
            </div>
           <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
            </div>
        </div>
      <?php //include('ad_content_right.php'); ?>
      </div>
      </div>
     <div class="row">
      <?php include('footer.php'); ?>
      </div>
    </div>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script-->
    <script src="assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php include('ga.php'); ?>
<script type='text/javascript'>
var tagtoo_advertiser_id=94;
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = 'http://ad.tagtoo.co/media/ad/track.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
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
mysql_free_result($newgroup);
?>
