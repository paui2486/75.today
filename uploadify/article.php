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
if (isset($_GET['n_id'])) {
  $colname_article = $_GET['n_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_article = sprintf("SELECT * FROM article LEFT JOIN article_class ON article.n_class = article_class.pc_id WHERE n_id = %s", GetSQLValueString($colname_article, "int"));
$article = mysql_query($query_article, $iwine) or die(mysql_error());
$row_article = mysql_fetch_assoc($article);
$totalRows_article = mysql_num_rows($article);
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title><?php echo $row_article['n_title']; ?> - iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo substr_utf8(strip_tags($row_article['n_cont']),200) ;?>...">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $row_article['n_title']; ?>">
	<meta property="og:site_name" content="iWine">
	<meta property="og:image" content="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>">
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
    <div class="container">
      <?php include('header.php'); ?>
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
        <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
              
                <ul class="breadcrumb">
  					<li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li><a href="article_class.php?pc_id=<?php echo $row_article['pc_id']; ?>"><?php echo $row_article['pc_name']; ?></a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $row_article['n_title']; ?></li>
				</ul>
                <div class="row" style="border:#000000 solid 0px; margin-left:0px; margin-bottom:10px">
           			<div class="span8">
                		<h2><img src="images/wine_icon1.png" width="50" height="50"> <?php echo $row_article['n_title']; ?></h2>
                        <img src="images/line03.png"><br>
</div>
                    
                    <div class="span1" style="float:left">
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
          </div>
                    <div class="span7" style="float:left">
					<div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-width="320" data-show-faces="false" data-send="true"></div>					
                    </div>
                    
                    <div class="span8" style="padding:0px">
                    <?php if($row_article['n_fig1'] <> ""){ ?>
                    <div align="center" style="margin-top:20px">
                      <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>"> 
                    </div>
                    <?php } ?>
                    <div style="margin-top:20px; margin-bottom:50px">
                    <?php echo $row_article['n_cont']; ?>
                    </div>
                    </div>
                    
                    <div class="span1" style="float:left">
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
          </div>
                    <div class="span7" style=" float:left">
					<div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-width="320" data-show-faces="false" data-send="true"></div>					
                    </div>
                    
                    </div>
                    
                    <div class="row">
                    <div class="span9">
                    <div align="center" style="padding:10px">
                    <a class="btn btn-warning" href="article_class.php?pc_id=<?php echo $row_article['pc_id']; ?>"><i class="icon-arrow-left icon-white"></i> 更多 <?php echo $row_article['pc_name']; ?> </a>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span9" style="border:solid 0px #000000; margin-bottom:10px">
                    <div style="padding:10px; background-image:url(images/bg2.png)">
                    <img src="images/guest.png">
                    </div>
                    <div align="center" style="padding:10px">
                    <div class="fb-comments" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>"></div>
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
           <div class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="270" data-show-faces="true" data-stream="true" data-header="true"></div>
        </div>
        
     </div>
      </div>
      
      <div class="row">
      <?php include('footer.php'); ?>
      </div>
    </div>
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
		height:		   '250px',
		width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
	});
}); 
</script>
