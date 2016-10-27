
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
    <meta name="description" content="跟著iWine我們一起去旅行！一起 體驗美酒 美食美女 美景 的生活吧！iwine提供葡萄酒、藝術、古典樂、Jazzy與品酒會、品酒達人情報，不論紅酒、白酒、香檳、粉紅酒、氣泡酒、白蘭地、波特酒、冰酒、甜酒、貴腐酒、跟著iwine我們出發吧！">
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
    #apDiv1 {
	position: absolute;
	width: 958px;
	height: 700px;
	z-index: 1000000;
	left: 364px;
	top: 157px;
}
    </style>
   
  <script src="SpryAssets/SpryEffects.js" type="text/javascript"></script>
  <script type="text/javascript">
function MM_effectBlind(targetElement, duration, from, to, toggle)
{
	Spry.Effect.DoBlind(targetElement, {duration: duration, from: from, to: to, toggle: toggle});
}
  </script>
  </head>
  <body onLoad="MM_effectBlind('apDiv1', 1000, '0%', '100%', false)">
  <div id="apDiv1"><a href="http://www.iwine.com.tw/article.php?n_id=150" target="_blank"><img src="images/main.png"></a><a href="#"><img src="images/btn_close.png" onClick="MM_effectBlind('apDiv1', 1000, '100%', '0%', false)"></a></div>
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
        <div class="span12" style="margin-top:10px">
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
          <div style="margin-bottom:5px; padding:5px;">
            <div style="height:160px; overflow:hidden"> <a href="article.php?n_id=<?php echo $row_newest['n_id']; ?>" > <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_newest['n_fig1']; ?>" alt="<?php echo $row_newest['n_title']; ?>"> </a> </div>
            <div style="height:50px; overflow:hidden">
              <h5><a href="article.php?n_id=<?php echo $row_newest['n_id']; ?>"><?php echo $row_newest['n_title']; ?></a><br>
                </h5>
            </div>
            <!-- fb share, view_counter-->
            <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; vertical-align:bottom;">
                瀏覽數：<?php echo $row_newest['view_counter']; ?>
                </div>
            </div>
            <!-- fb like, fb share, twitter, g+ -->
            <!--div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="">
                    <div class="fb-like" style="position: absolute; margin-top:-0px; margin-left:5px; overflow:hidden !important; z-index: 999; width:90px !important;" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id']; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" data-width="90"></div>
                    
                </div>
                <div style="float:left; padding-left:90px; z-index: 999;">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left; z-index: 9999; display: inline;">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id'];?>" data-via="draqula" data-lang="zh-tw" data-count="none">推文</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </div>
                <div style="float:left; padding-left:5px; z-index: 9999; display: inline;">
                <div class="g-plusone" data-annotation="none" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id'];?>"></div>

                </div>
                
            </div-->
            
            <!--div align="right" style="position: absolute; z-index: 9999; overflow:visible; margin-top:-20px; margin-left:100px"> <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a> </div>
            <div class="fb-like" style="position: absolute; z-index: 9999; overflow:visible; margin-top:-20px; margin-left:70px" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="false" data-width="50"></div>
            <!--div align="right" style="position: absolute; z-index: 99999; overflow:visible; margin-top:-20px; margin-left:135px;">
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id'];?>" data-via="draqula" data-lang="zh-tw" data-count="none">推文</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </div>
            <span class="g-plus" style="display:block !important; position: absolute !important; z-index: 199999; overflow:visible; margin-top:-20px !important; margin-right:0px !important;" data-height="15" data-action="share" data-annotation="none" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest['n_id'];?>"></span-->
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
        <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494;">
                瀏覽數：<?php echo $row_hotest['view_counter']; ?>
                </div>
        </div>
        <!--div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="">
                    <div class="fb-like" style="position: absolute; margin-top:-0px; margin-left:5px; overflow:hidden !important; z-index: 999; width:90px !important;" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id']; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" data-width="90"></div>
                    
                </div>
                <div style="float:left; padding-left:90px; z-index: 999;">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left; z-index: 9999; display: inline;">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id'];?>" data-via="draqula" data-lang="zh-tw" data-count="none">推文</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </div>
                <div style="float:left; padding-left:5px; z-index: 9999; display: inline;">
                <div class="g-plusone" data-annotation="none" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id'];?>"></div>

                </div>
                
            </div-->
        <!--div style="height:20px"></div>
          <div align="right" style="position: absolute; z-index: 99999; overflow:visible; margin-top:-20px">
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
          </div>
          <div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest['n_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="false" style="position: absolute; z-index: 9999; overflow:visible; margin-top:-20px; margin-left:60px"></div-->
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
             
<!-- ad-->

        <div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門排行</h4>
          <?php include('ad_1.php'); ?>
        </div>
        
        
         <div class="span3" align="center" style="margin-top:10px;"><a href="https://www.facebook.com/iwine" target="_blank"><img src="images/banner_addfb.png"></a> </div>
        
        
        <!--<div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
        </div>-->
        
       <!-- <?php include('ad_index_right.php'); ?>-->
        

 <!-- ad end-->             
             
             
             
          </div>                 
        </div>


 
     
     
       
  
       </div> 
       
       <div class="row">
       <div class="span9" align="center">
       <?php include('ad_index_bottom.php'); ?>
       </div>
       </div>
   
    
    </div>
    
   <div style="width:100%; background-color:#ba0050;" align="center">
    
   <div class="footer_b">
      <?php include('footer.php'); ?>
      </div>

    
  </div>
    
    
    
    <script type="text/javascript">
  window.___gcfg = {lang: 'zh-TW'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
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
        autostop:           false,     // true to end slideshow after X transitions (where X == slide count) 
        fx:             'fade,',// name of transition effect 
        pause:          false,     // true to enable pause on hover 
        randomizeEffects:   true,  // valid when multiple effects are used; true to make the effect sequence random 
        speed:          1000,  // speed of the transition (any valid fx speed value) 
        sync:           true,     // true if in/out transitions should occur simultaneously 
        timeout:        5000,  // milliseconds between slide transitions (0 to disable auto advance) 
        fit:            true,
        width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
    });
}); 
</script>
