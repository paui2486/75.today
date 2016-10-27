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

$a_id = $row_article['n_id'];
$a_class = $row_article['n_class'];

mysql_select_db($database_iwine, $iwine);
$query_other = "SELECT * FROM article WHERE n_class = '$a_class' AND n_id <> '$a_id' AND n_status= 'Y' ORDER BY RAND() LIMIT 3";
$other = mysql_query($query_other, $iwine) or die(mysql_error());
$row_other = mysql_fetch_assoc($other);
$totalRows_other = mysql_num_rows($other);

mysql_select_db($database_iwine, $iwine);
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);
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
    <link href="style_article.css" rel="stylesheet">
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
                		<h2><img src="images/wine_icon1.png" width="35" height="35"> <span class="title"><?php echo $row_article['n_title']; ?></span></h2>
                        <img src="images/line03.png"><br>
                </div>
                <div class="span8">
                    <div style="float:left">
                        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
                    </div>
                    <div style="float:left; padding-left:20px;">
					<div class="fb-like" data-href="http://www.iwine.com.tw<?php echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
                    </div>
                </div> 
                    
<!--div class="span1" style="float:left">
<a href="#" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php //echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
</div>
<div class="span7" style="float:left">
<div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php //echo $row_article['n_id']; ?>" data-width="320" data-show-faces="true" data-send="true" data-share="false"></div>					
</div-->
                    
                    <div class="span8" style="padding:0px">
                    <?php if($row_article['n_fig1'] <> ""){ ?>
                    <div align="center" style="margin-top:20px"></div>
                    <?php } ?>
                    <div class="article_txt" style="margin-top:20px; margin-bottom:50px">
                    <?php echo $row_article['n_cont']; ?>
                    </div>
					
                    </div>
                    
                    <div class="span1" style="float:left">
        <a href="#" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
          </div>
                    <div class="span7" style=" float:left">
					<div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-width="320" data-show-faces="true" data-send="true" data-layout="standard" data-share="false"></div>					
                    </div>
                    
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
                    <div class="span12">
                      <h4><br>
                      <img src="images/wine_icon1.png" width="35" height="35"> <span class="title">其他人也看了這些文章：</span><br>
                      </h4>
                      <?php do { ?>
                      <div class="span3">
                        <div style="border:solid 0px #000000; margin-bottom:20px;">
                          <div style="height:199px; overflow:hidden"> <a href="article.php?n_id=<?php echo $row_other['n_id']; ?>" > <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_other['n_fig1']; ?>" alt="<?php echo $row_other['n_title']; ?>" > </a> </div>
                          <div style="height:30px">
                            <h5><a href="article.php?n_id=<?php echo $row_other['n_id']; ?>"><?php echo $row_other['n_title']; ?></a></h5>
                            <img src="images/article_line.png"> </div>
                        </div>
                      </div>
                      <?php } while ($row_other = mysql_fetch_assoc($other)); ?>

                     
<p>&nbsp;</p>

<div class="span8" style="padding:0px">
      <h4>&nbsp;</h4>
<?php include('ad_content_bottom.php'); ?> 
      <h4>&nbsp;</h4>
</div>
         

                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span9" style="border:solid 0px #000000; margin-bottom:10px">
                    <div style="padding:10px; background-image:url(images/bg2.png)">
                    <img src="images/guest.png" width="140" height="30">
                    </div>
                    <div align="center" style="padding:10px">
                    <div class="fb-comments" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>"></div>
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
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門文章</h4>
           <div style="border:solid 1px #CCC; padding:10px; margin-bottom:10px">
        	<ul>
            	<?php do { ?>
           	    <li><a href="article.php?n_id=<?php echo $row_hot['n_id']; ?>"><?php echo $row_hot['n_title']; ?></a></li>
            	  <?php } while ($row_hot = mysql_fetch_assoc($hot)); ?>
            </ul>
            </div>
        </div>
        
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
        
        <?php include('ad_content_right.php'); ?>
        
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
mysql_free_result($article);

mysql_free_result($hot);
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
