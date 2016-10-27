<?php
session_start(); 
include('func/func.php');
?>
<?php require_once('Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
      if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }

      $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

      switch ($theType) {
        case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
        case "long":
        case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
        case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
        case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
        case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
      }
      return $theValue;
    }
}

mysql_select_db($database_iwine, $iwine);
$query_newest_article = "SELECT * FROM article WHERE n_status = 'Y' ORDER BY n_id DESC LIMIT 6";
$newest_article = mysql_query($query_newest_article, $iwine) or die(mysql_error());
$row_newest_article = mysql_fetch_assoc($newest_article);
$totalRows_newest_article = mysql_num_rows($newest_article);

mysql_select_db($database_iwine, $iwine);
$query_newest_expert = "SELECT * FROM expert_article WHERE n_id > 130 and n_status = 'Y' ORDER BY n_id DESC LIMIT 3";
$newest_expert = mysql_query($query_newest_expert, $iwine) or die(mysql_error());
$row_newest_expert = mysql_fetch_assoc($newest_expert);
$totalRows_newest_expert = mysql_num_rows($newest_expert);

mysql_select_db($database_iwine, $iwine);
$query_hotest_article = "SELECT * FROM article WHERE n_status = 'Y' AND n_hot ='Y' ORDER BY RAND() LIMIT 6";
$hotest_article = mysql_query($query_hotest_article, $iwine) or die(mysql_error());
$row_hotest_article = mysql_fetch_assoc($hotest_article);
$totalRows_hotest_article = mysql_num_rows($hotest_article);


mysql_select_db($database_iwine, $iwine);
$query_hotest_expert = "SELECT * FROM expert_article WHERE n_id > 130 and n_status = 'Y' AND n_hot ='Y' ORDER BY RAND() LIMIT 3";
$hotest_expert = mysql_query($query_hotest_expert, $iwine) or die(mysql_error());
$row_hotest_expert = mysql_fetch_assoc($hotest_expert);
$totalRows_hotest_expert = mysql_num_rows($hotest_expert);

mysql_select_db($database_iwine, $iwine);
$query_index_fig = "SELECT * FROM index_fig WHERE b_status = 'Y' ORDER BY b_order ASC";
$index_fig = mysql_query($query_index_fig, $iwine) or die(mysql_error());
$row_index_fig = mysql_fetch_assoc($index_fig);
$totalRows_index_fig = mysql_num_rows($index_fig);

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
    <title>iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="ldciUWlDvibIj3ny2qU9ioxmEedndTTM-rsVUpx2K1I" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="description" content="跟著iWine我們一起去旅行！一起 體驗美酒 美食美女 美景 的生活吧！iwine提供葡萄酒、藝術、古典樂、Jazz與品酒會、品酒達人情報，不論紅酒、白酒、香檳、粉紅酒、氣泡酒、白蘭地、波特酒、冰酒、甜酒、貴腐酒、跟著iwine我們出發吧！">
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
    <?php include('mainmenu_20140903.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
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
                    <li class="active"><a href="#tab1" data-toggle="tab">熱門文章</a></li>
                    <li><a href="#tab2" data-toggle="tab">最新文章</a></li>
                    <img src="images/menu_line.png">
                </ul>
                
                <div class="tab-content" style="padding-top:5px; margin-bottom:10px;">
                    <div class="tab-pane active" id="tab1">
                     <div class="row">
                        <div class="span9">
                        <div class="row">
                        
<?php if ($totalRows_hotest_expert > 0) { // Show if recordset not empty ?>    
      <?php do { ?>
        <div class="span3">
          <div style="margin-bottom:5px; padding:5px;">
            <div style="height:160px; overflow:hidden"> <a href="expert_article.php?n_id=<?php echo $row_hotest_expert['n_id']; ?>" > <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hotest_expert['n_fig1']; ?>" alt="<?php echo $row_hotest_expert['n_title']; ?>"> </a> </div>
            <div style="height:50px; overflow:hidden">
              <h5><a href="expert_article.php?n_id=<?php echo $row_hotest_expert['n_id']; ?>"><?php echo $row_hotest_expert['n_title']; ?></a><br>
                </h5>
            </div>
            <!-- fb share, view_counter-->
            <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/expert_article.php?n_id=<?php echo $row_hotest_expert['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; vertical-align:bottom; margin-top:5px;">
                <?php echo number_format($row_hotest_expert['view_counter']); ?> 人次點閱
                </div>
            </div>
        
            <img src="images/article_line.png">
            </div>
          </div>
        <?php } while ($row_hotest_expert = mysql_fetch_assoc($hotest_expert)); ?>
  <?php } ?>                        
                        
                    <?php if ($totalRows_hotest_article > 0) { // Show if recordset not empty ?>    
      <?php do { ?>
        <div class="span3">
          <div style="margin-bottom:5px; padding:5px;">
            <div style="height:160px; overflow:hidden"> <a href="article.php?n_id=<?php echo $row_hotest_article['n_id']; ?>" > <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hotest_article['n_fig1']; ?>" alt="<?php echo $row_hotest_article['n_title']; ?>"> </a> </div>
            <div style="height:50px; overflow:hidden">
              <h5><a href="article.php?n_id=<?php echo $row_hotest_article['n_id']; ?>"><?php echo $row_hotest_article['n_title']; ?></a><br>
                </h5>
            </div>
            <!-- fb share, view_counter-->
            <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_hotest_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; vertical-align:bottom;margin-top:5px;">
                <?php echo number_format($row_hotest_article['view_counter']); ?> 人次點閱
                </div>
            </div>
            
            <img src="images/article_line.png">
            </div>
          </div>
        <?php } while ($row_hotest_article = mysql_fetch_assoc($hotest_article)); ?>
  <?php } ?>
                    </div>
                    </div>
                    </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="row">
                        <div class="span9">
                        <div class="row">
                    
                    
                    
                    <?php if ($totalRows_newest_expert > 0) { // Show if recordset not empty ?>    
      <?php do { ?>
        <div class="span3">
          <div style="margin-bottom:5px; padding:5px;">
            <div style="height:160px; overflow:hidden"> <a href="expert_article.php?n_id=<?php echo $row_newest_expert['n_id']; ?>" > <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_newest_expert['n_fig1']; ?>" alt="<?php echo $row_newest_expert['n_title']; ?>"> </a> </div>
            <div style="height:50px; overflow:hidden">
              <h5><a href="expert_article.php?n_id=<?php echo $row_newest_expert['n_id']; ?>"><?php echo $row_newest_expert['n_title']; ?></a><br>
                </h5>
            </div>
            <!-- fb share, view_counter-->
            <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/expert_article.php?n_id=<?php echo $row_newest_expert['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; vertical-align:bottom; margin-top:5px;">
                <?php echo number_format($row_newest_expert['view_counter']); ?> 人次點閱
                </div>
            </div>
            <img src="images/article_line.png">
            </div>
          </div>
        <?php } while ($row_newest_expert = mysql_fetch_assoc($newest_expert)); ?>
  <?php } ?>  
                    
                    
                    
                    
                    
                    
                    
                    <?php if ($totalRows_newest_article > 0) { // Show if recordset not empty ?>    
      <?php do { ?>    
        <div class="span3">
        <div style="border:solid 0px #000000; margin-bottom:5px; padding:5px">
        <div style="height:160px; overflow:hidden">
        <a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>" >
        
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_newest_article['n_fig1']; ?>" alt="<?php echo $row_newest_article['n_title']; ?>">
        </a>
        </div>
        <div style="height:50px; overflow:hidden">
          <h5><a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>"><?php echo $row_newest_article['n_title']; ?></a></br>
         
          </h5>
        </div>
        <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_newest_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; margin-top:5px;">
                <?php echo number_format($row_newest_article['view_counter']); ?> 人次點閱
                </div>
        </div>
       
           <img src="images/article_line.png">
          </div>
          </div>              
        <?php } while ($row_newest_article = mysql_fetch_assoc($newest_article)); ?>
  <?php } ?>
                    </div>
                    </div>
                    </div>
                    </div>
                                
                </div>
             </div>
             </div>       

<div class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>

             
        </div>
        
     <div class="row">
        <div class="span3" align="center">
           <h4 align="left"> <img src="images/wine_icon4.png" width="30" height="30"> iWine 排行榜 </h4>
            <?php include('ad_1.php'); ?>
        </div>
        
        <div class="span3">
           <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30">熱門文章</h4>
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
        <?php include('ad_index_right.php'); ?>
        
     </div>
       
  
       </div> 
       
       <div class="row">
       <div class="span9" align="center">
       <?php include('ad_index_bottom.php'); ?>
       </div>
       </div>
    </div>
    <?php include('footer.php'); ?>
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
mysql_free_result($newest_article);
mysql_free_result($hotest_article);
mysql_free_result($newest_expert);
mysql_free_result($hotest_expert);
mysql_free_result($index_fig);
mysql_free_result($hot);
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
