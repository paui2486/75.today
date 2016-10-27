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

mysql_select_db($database_iwine, $iwine);
$query_newest = "SELECT * FROM article WHERE n_status = 'Y' ORDER BY n_id DESC LIMIT 6";
$newest = mysql_query($query_newest, $iwine) or die(mysql_error());
$row_newest = mysql_fetch_assoc($newest);
$totalRows_newest = mysql_num_rows($newest);

mysql_select_db($database_iwine, $iwine);
$query_hotest = "SELECT * FROM article WHERE n_status = 'Y' AND n_hot ='Y' ORDER BY RAND() LIMIT 6";
$hotest = mysql_query($query_hotest, $iwine) or die(mysql_error());
$row_hotest = mysql_fetch_assoc($hotest);
$totalRows_hotest = mysql_num_rows($hotest);

mysql_select_db($database_iwine, $iwine);
$query_index_fig = "SELECT * FROM index_fig WHERE b_status = 'Y' ORDER BY b_order ASC";
$index_fig = mysql_query($query_index_fig, $iwine) or die(mysql_error());
$row_index_fig = mysql_fetch_assoc($index_fig);
$totalRows_index_fig = mysql_num_rows($index_fig);
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="description" content="葡萄酒 x 旅行 x 美食 跟著 iWine，我們出發吧！ ">
    <meta name="author" content="">
    <meta property="og:title" content="首頁 - iWine">
	<meta property="og:site_name" content="iWine">
	<meta property="og:image" content="http://www.iwine.com.tw/images/logo.jpg">
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
   
   
   
 <div class="header-new-frame">
    <!-- header -->
 <?php include('main_header.php'); ?>
  <!-- header end -->   
 
 </div>


<div class="container-frame">
  <!-- container -->  
     
  <div class="container"> 
      <div class="row">
   <div class="span9" style="margin-top:10px">
          <div class="row-fluid">
          	<div class="span12">
                <div id="myCarousel" class="carousel slide">
  					<ol class="carousel-indicators">
    					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    					<li data-target="#myCarousel" data-slide-to="1"></li>
    					<li data-target="#myCarousel" data-slide-to="2"></li>
  					</ol>
  			<!-- Carousel items -->
  					<div class="carousel-inner">
    					<?php $i=1; ?>
						<?php do { ?>
   					    <div class="<?php if($i==1){ ?>active <?php } ?>item"><a href="<?php echo $row_index_fig['b_url']; ?>"><img src="http://admin.iwine.com.tw/webimages/index/<?php echo $row_index_fig['b_file']; ?>"></a>
    					    <?php if($row_index_fig['b_name'] <>""){ ?>
                            <div class="carousel-caption">                            
    					      <h4><?php echo $row_index_fig['b_name']; ?></h4>
                            <?php } ?>
                            <?php if($row_index_fig['b_subname'] <> ""){ ?>
                           <?php echo $row_index_fig['b_subname']; ?>            
    					      </div>
							  <?php } ?>
   					      </div>
                          <?php $i++; ?>
    					  <?php } while ($row_index_fig = mysql_fetch_assoc($index_fig)); ?>
  					</div>
  			<!-- Carousel nav -->
  					<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  					<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
				</div>
        	</div>
            </div>
        
            <div class="row">
            <div class="span9">
  				<ul class="nav nav-tabs" style="margin:0 0 0 0px">
    				<li class="active"><a href="#tab1" data-toggle="tab">最新文章</a></li>
    				<li><a href="#tab2" data-toggle="tab">熱門文章</a></li>
                    <img src="images/menu_line.png">
  				</ul>
  				
  				<div class="tab-content" style="padding-top:5px; margin-bottom:10px;">
    				<div class="tab-pane active" id="tab1">
                     <div class="row">
                     	<div class="span9">
                        <div class="row">
      				<?php if ($totalRows_newest > 0) { // Show if recordset not empty ?>    
	  <?php do { ?>
	    <div class="span3">
	      <div style="margin-bottom:5px; padding:5px">
	        <div style="height:160px; overflow:hidden"> <a href="article.php?n_id=<?php echo $row_newest['n_id']; ?>" > <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_newest['n_fig1']; ?>" alt="<?php echo $row_newest['n_title']; ?>"> </a> </div>
	        <div style="height:50px; overflow:hidden">
	          <h5><a href="article.php?n_id=<?php echo $row_newest['n_id']; ?>"><?php echo $row_newest['n_title']; ?></a><br>
	            </h5>
	          </div>
	        <div style="height:20px"></div>
	        <div align="right" style="position: absolute; z-index: 99999; overflow:visible; margin-top:-20px"> <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a> </div>
            <div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="false" data-width="50" style="position: absolute; z-index: 9999; overflow:visible; margin-top:-20px; margin-left:60px"></div>
	        <img src="images/article_line.png">
	        </div>
	      </div>
	    <?php } while ($row_newest = mysql_fetch_assoc($newest)); ?>
  <?php } ?>
    				</div>
                    </div>
                    </div>
                    </div>
    				<div class="tab-pane" id="tab2">
      					<div class="row">
                     	<div class="span9">
                        <div class="row">
      				<?php if ($totalRows_hotest > 0) { // Show if recordset not empty ?>    
	  <?php do { ?>    
        <div class="span3">
        <div style="border:solid 0px #000000; margin-bottom:5px; padding:5px">
        <div style="height:160px; overflow:hidden">
		<a href="article.php?n_id=<?php echo $row_hotest['n_id']; ?>" >
        
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hotest['n_fig1']; ?>" alt="<?php echo $row_hotest['n_title']; ?>">
        </a>
        </div>
        <div style="height:50px; overflow:hidden">
          <h5><a href="article.php?n_id=<?php echo $row_hotest['n_id']; ?>"><?php echo $row_hotest['n_title']; ?></a></br>
         
          </h5>
        </div>
        <div style="height:20px"></div>
          <div align="right" style="position: absolute; z-index: 99999; overflow:visible; margin-top:-20px">
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
          </div>
          <div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="false" style="position: absolute; z-index: 9999; overflow:visible; margin-top:-20px; margin-left:60px"></div>
           <img src="images/article_line.png">
          </div>
          </div>              
        <?php } while ($row_hotest = mysql_fetch_assoc($hotest)); ?>
  <?php } ?>
    				</div>
                    </div>
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
        
        <?php include('ad_index_right.php'); ?>
        
     </div>
       
  
       </div> 
       
       <div class="row">
       <div class="span9" align="center">
       <?php include('ad_index_bottom.php'); ?>
       </div>
       </div>
    
    </div>
  
  <!-- container-end -->
</div>
  
  
  
  
  
 
<div class="footer-new-frame">
<?php include('footer.php'); ?>
      </div> 
  
  </body>
</html>
<?php
mysql_free_result($newest);
mysql_free_result($hotest);

mysql_free_result($index_fig);
?>
<?php include('ga.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.carousel').carousel({
  		interval: 8000,
  		pause: "hover" 
	})
	
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
