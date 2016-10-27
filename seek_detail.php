<?php
session_start(); 
include('func/func.php');
?>
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
 
$colname_article = "-1";
if (isset($_GET['ap_id'])) {
  $colname_article = $_GET['ap_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_article = sprintf("SELECT * FROM seek_detail WHERE ap_id = %s", GetSQLValueString($colname_article, "int"));
$article = mysql_query($query_article, $iwine) or die(mysql_error());
$row_article = mysql_fetch_assoc($article);
$totalRows_article = mysql_num_rows($article);

switch($row_article['ap_class']){ 
	case '1':
		$pet_class = "協尋毛寶貝";
		break;
	case '2':
		$pet_class = "協尋毛主人";
		break;
	default:
		$pet_class = "協尋毛寶貝";
		break;
	}	
	

switch($row_article['ap_status']){ 
	case '1':
		$pet_status = "等待主人中";
		break;
	case '2':
		$pet_status = "新待毛寶貝中";
		break;
	case '3':
		$pet_status = "已回到溫暖的家";
		break;
}
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title><?php echo $pet_class; ?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo strip_tags($row_article['ap_memo']) ;?>">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $pet_class; ?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
	<meta property="og:site_name" content="iWine">
	<meta property="og:image" content="http://admin.iwine.com.tw/webimages/seek/<?php echo $row_article['ap_photo']; ?>">
	<meta property="og:type" content="website">
    <meta property="fb:admins" content="1685560618"/>
	<meta property="fb:app_id" content="540353706035158">
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
          <div class="row">
            <div class="span9">
              
                <ul class="breadcrumb">
  					<li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li><a href="seek_list.php?ap_class=<?php echo $row_article['ap_class']; ?>"><?php echo $pet_class; ?></a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $row_article['ap_breed']; ?> <?php echo $row_article['ap_name']; ?></li>
				</ul>
                <div class="row" style="border:#000000 solid 1px; margin-left:0px; margin-bottom:10px">
           			<div class="span8">
                		<h3><img src="images/wine_icon1.png" width="50" height="50"> <?php echo $row_article['ap_breed']; ?> <?php echo $row_article['ap_name']; ?></h3><hr>
                    </div>
                    
                    <div class="span2">               		
                    </div>
                    <div class="span6" align="right">
					<div class="fb-like" data-href="http://www.iwine.com.tw/seek_detail.php?ap_id=<?php echo $row_article['ap_id']; ?>" data-width="400" data-show-faces="false" data-send="true"></div>		
                    </div>
                    
                    <div class="span8" align="center">
                    <img src="http://admin.iwine.com.tw/webimages/adopt/<?php echo $row_article['ap_photo']; ?>" class="img-polaroid">
                    </div>
                    
                    <div class="span8" style="padding-left:20px; padding-top:10px">
                    <h4><img src="images/wine_icon1.png" width="20" height="20"> 幸福認養資訊：</h4><hr>
                    </div>
                    <?php if($row_article['ap_class'] == 1){ ?>
                    <div class="span4">
                    	<div style="padding-right:5px; padding-left:30px">協尋編號：<?php echo $row_article['ap_code']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">走失日期：<?php echo $row_article['ap_date2']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">走失地區：<?php echo $row_article['ap_county']; ?><?php echo $row_article['ap_city']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">名字：<?php echo $row_article['ap_name']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">品種：<?php echo $row_article['ap_breed']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">性別：<?php echo $row_article['ap_sex']; ?></div>
          				<div style="padding-right:5px; padding-left:30px">年齡：<?php echo $row_article['ap_age']; ?></div>                        
                        <div style="padding-right:5px; padding-left:30px">目前狀態：<?php echo $pet_status; ?></div>                        		
                    </div>
                    <div class="span4">
						<div style="padding-right:5px; padding-left:30px">刊登日期：<?php echo $row_article['ap_date']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">體重：<?php echo $row_article['ap_weight']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">健康：<?php echo $row_article['ap_health']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">是否植入晶片：<?php echo $row_article['ap_chip']; ?></div>
          				<div style="padding-right:5px; padding-left:30px">是否結紮：<?php echo $row_article['ap_close']; ?></div>
          				<div id="contact_info" style="color:#F00;">
                        <div style="padding-right:5px; padding-left:30px">聯絡人：<?php echo $row_article['ap_m_name']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">聯絡電話：<?php echo $row_article['ap_m_tel']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">聯絡E-mail：<?php echo $row_article['ap_m_email']; ?></div>
                        </div>
                    <?php }elseif($row_article['ap_class'] == 2){ ?>
                    <div class="span4">
                    	<div style="padding-right:5px; padding-left:30px">協尋編號：<?php echo $row_article['ap_code']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">尋獲日期：<?php echo $row_article['ap_date2']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">尋獲地區：<?php echo $row_article['ap_county']; ?><?php echo $row_article['ap_city']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">品種：<?php echo $row_article['ap_breed']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">性別：<?php echo $row_article['ap_sex']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">體重：<?php echo $row_article['ap_weight']; ?></div>
          				<div style="padding-right:5px; padding-left:30px">目前狀態：<?php echo $pet_status; ?></div>                        		
                    </div>
                    <div class="span4">
						<div style="padding-right:5px; padding-left:30px">刊登日期：<?php echo $row_article['ap_date']; ?></div>                       
                        <div style="padding-right:5px; padding-left:30px">健康：<?php echo $row_article['ap_health']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">是否植入晶片：<?php echo $row_article['ap_chip']; ?></div>
          				<div style="padding-right:5px; padding-left:30px">是否結紮：<?php echo $row_article['ap_close']; ?></div>
          				<div id="contact_info" style="color:#F00;">
                        <div style="padding-right:5px; padding-left:30px">聯絡人：<?php echo $row_article['ap_m_name']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">聯絡電話：<?php echo $row_article['ap_m_tel']; ?></div>
                        <div style="padding-right:5px; padding-left:30px">聯絡E-mail：<?php echo $row_article['ap_m_email']; ?></div>
                        </div>
                    <?php } ?>    
                    </div>
                    
                    <div class="span8" style="padding-left:20px">
                    <h4><img src="images/wine_icon1.png" width="20" height="20"> 說明：</h4><hr>
                    <?php echo $row_article['ap_memo']; ?>
                    <hr>
                    </div>
                    
                    
                    <div class="span2" style="padding-left:20px">
                		
                    </div>
                    <div class="span6" align="right">
					<div class="fb-like" data-href="http://www.iwine.com.tw/seek_detail.php?ap_id=<?php echo $row_article['ap_id']; ?>" data-width="400" data-show-faces="false" data-send="true"></div>					
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span9">
                    <div align="center" style="padding:10px">
                    <a class="btn btn-warning" href="seek_list.php?ap_class=<?php echo $row_article['ap_class']; ?>"><i class="icon-arrow-left icon-white"></i> 回<?php echo $pet_class; ?></a>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span9" style="border:solid 1px #000000; margin-bottom:10px">
                    <div style="padding:10px; background-image:url(images/bg2.png)">
                    <img src="images/guest.png">
                    </div>
                    <div align="center" style="padding:10px">
                    <div class="fb-comments" data-href="http://www.iwine.com.tw/seek_detail.php?ap_id=<?php echo $row_article['ap_id']; ?>"></div>
                    </div>
                    </div>
                    </div>
                    
                

              
            </div>          
          </div>
          
          
        </div>
        <div class="row">
        <div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine嚴選</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
        
     </div>
      </div>
      
      <!-- Modal -->
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php
mysql_free_result($article);
?>
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
