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

$colname_cutevideo = "-1";
if (isset($_GET['n_id'])) {
  $colname_cutevideo = $_GET['n_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_cutevideo = sprintf("SELECT * FROM cf_video WHERE n_id = %s", GetSQLValueString($colname_cutevideo, "int"));
$cutevideo = mysql_query($query_cutevideo, $iwine) or die(mysql_error());
$row_cutevideo = mysql_fetch_assoc($cutevideo);
$totalRows_cutevideo = mysql_num_rows($cutevideo);
?>
<?php
switch($row_article['ap_class']){ 
	case '1':
		$pet_class = "狗狗";
		break;
	case '2':
		$pet_class = "貓貓";
		break;
	case '3':
		$pet_class = "其他毛寶貝";
		break;
	}		
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>影片 - <?php echo $row_cutevideo['n_title']; ?> - iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php if($row_cutevideo['n_cont'] <> ""){echo strip_tags(substr_utf8($row_cutevideo['n_cont'],100));}else{ echo $row_cutevideo['n_title']; } ?>">
    <meta name="author" content="">
    <meta property="og:title" content="影片 - <?php echo $row_cutevideo['n_title']; ?> - iWine">
	<meta property="og:site_name" content="iWine">
	<meta property="og:image" content="http://admin.iwine.com.tw/webimages/video/<?php echo $row_cutevideo['n_fig1']; ?>">
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
                    <li><a href="cute_video_w.php">影片</a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $row_cutevideo['n_title']; ?></li>
				</ul>
                <div class="row" style="border:#000000 solid 0px; margin-left:0px; margin-bottom:10px">
           			<div class="span8">
                		<h3><img src="images/wine_icon1.png" width="35" height="35"> <span class="title"><?php echo $row_cutevideo['n_title']; ?></span></h3>
                		<img src="images/line03.png"></div>
                    
                    <div class="span9" align="right">
					<div class="fb-like" data-href="http://www.iwine.com.tw/cute_video_detail.php?n_id=<?php echo $row_cutevideo['n_id']; ?>" data-width="400" data-show-faces="false" data-send="true"></div>		
                    </div>
                    
                    <div class="span8" align="center" style="margin-top:20px">
                    <?php echo $row_cutevideo['n_video']; ?>
                    </div>
                    
                    <div class="span8" style="padding-left:20px"><br>
                      <?php echo $row_cutevideo['n_cont']; ?>
                    <hr>
                  </div>
                    
                    
                
                    <div class="span9" align="right">
					<div class="fb-like" data-href="http://www.iwine.com.tw/cute_video_detail.php?n_id=<?php echo $row_cutevideo['n_id']; ?>" data-width="400" data-show-faces="false" data-send="true"></div>					
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span9">
                    <div align="center" style="padding:10px">
                    <a class="btn btn-warning" href="cute_video_w.php"><i class="icon-arrow-left icon-white"></i> 回影片列表</a>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span9" style="border:solid 0px #000000; margin-bottom:10px">
                    <div style="padding:10px; background-image:url(images/bg2.png)">
                    <img src="images/guest.png">
                    </div>
                    <div align="center" style="padding:10px">
                    <div class="fb-comments" data-href="http://www.iwine.com.tw/cute_video_detail.php?n_id=<?php echo $row_cutevideo['n_id']; ?>"></div>
                    </div>
                    </div>
                    </div>
                    
                

              
            </div>          
          </div>
          
          
        </div>
        <div class="row">
        <div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門排行</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
        
     </div>
      </div>
      
      <div class="row">
      
      </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php
mysql_free_result($cutevideo);
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
