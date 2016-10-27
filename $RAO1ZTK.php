<?php 
session_start(); 
include('func/func.php');
$cur_url = curPageURL();
require_once('Connections/iwine.php');
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_article = 12;
$pageNum_article = 0;
if (isset($_GET['pageNum_article'])) {
  $pageNum_article = $_GET['pageNum_article'];
}
$startRow_article = $pageNum_article * $maxRows_article;

$colname_article = "-1";
if (isset($_GET['e_id'])) {
  $colname_article = $_GET['e_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_article = sprintf("SELECT * FROM expert_article WHERE expert = %s AND n_status= 'Y' ORDER BY n_order ASC, n_date DESC", GetSQLValueString($colname_article, "int"));
$query_limit_article = sprintf("%s LIMIT %d, %d", $query_article, $startRow_article, $maxRows_article);
$article = mysql_query($query_limit_article, $iwine) or die(mysql_error());
$row_article = mysql_fetch_assoc($article);

if (isset($_GET['totalRows_article'])) {
  $totalRows_article = $_GET['totalRows_article'];
} else {
  $all_article = mysql_query($query_article);
  $totalRows_article = mysql_num_rows($all_article);
}
$totalPages_article = ceil($totalRows_article/$maxRows_article)-1;

$colname_expert = "-1";
if (isset($_GET['e_id'])) {
  $colname_expert = $_GET['e_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_expert = sprintf("SELECT * FROM expert WHERE id = %s AND active = 1", GetSQLValueString($colname_expert, "int"));
$expert = mysql_query($query_expert, $iwine) or die(mysql_error());
$row_expert = mysql_fetch_assoc($expert);
$totalRows_expert = mysql_num_rows($expert);
// echo "row_expert['view_counter'] = ".$row_expert['view_counter']."<br>";
$page_count = $row_expert['view_count'] + 1;
// echo "page_count = ".$page_count."<br>";
$updateSQL = sprintf("UPDATE expert SET view_count = %s WHERE id = %s", $page_count, GetSQLValueString($row_expert['id'], "int"));
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
// echo "page_count = ".$page_count."<br>";
// echo "updateSQL = ".$updateSQL."<br>";
// if($totalRows_expert==0){
    
// }

$queryString_article = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_article") == false && 
        stristr($param, "totalRows_article") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_article = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_article = sprintf("&totalRows_article=%d%s", $totalRows_article, $queryString_article);


?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title><?php echo $row_expert['title']; ?>/<?php echo $row_expert['name']; ?> - 達人系列 - iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $row_expert['description']; ?>">
    <meta name="keyword" content="<?php echo $row_expert['keyword']; ?>">
    <meta name="author" content="<?php echo $row_expert['name']; ?>">
    <meta property="og:title" content="<?php echo $row_expert['title']; ?>/<?php echo $row_expert['name']; ?> - 達人系列 - iWine">
    <meta property="og:site_name" content="iWine">
    <meta property="og:image" content="http://www.iwine.com.tw/images/logo.jpg">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?php echo $row_expert['description']; ?>">
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
              <div>
                <ul class="breadcrumb">
                    <li><a href="index.php" class="home">首頁</a> <span class="divider">/</span></li>
                    <li class="active" class="expert_h2">達人 - <?php echo $row_expert['name']; ?></li>
                </ul>
                
                <div class="row">
                    <div class="span9">
                      <h3><img src="images/wine_icon2.png" width="32" height="32"> <span class="title"><?php echo $row_expert['title']." ".$row_expert['name']; ?></span></h3>
                     <span class="view_counter"> <?php echo number_format($row_expert['view_count']); ?> 人次點閱</span>
                     <img src="images/line03.png" width="1200">
                     
                     
<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden; margin-left:0px;">


    <!-- FB fanpage like-start -->
    <div style="float:left; width:0px;">
        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
      <!-- FB fanpage like-end -->
    
    <!-- G+ share button-start -->
    <div style="float:left; padding-left:0px;">
        <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
    </div>
      <!-- G+ share button-end -->
    
    
    <!-- G+ share js-start -->
    <script type="text/javascript">
          window.___gcfg = {lang: 'zh-TW'};

          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/platform.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
    </script>
        <!-- G+ share js-end -->
    

    <!-- current page fb like-start -->
    <div style="float:left; padding-left:0px; width:60px;">
        <div class="fb-like" data-href="http://www.iwine.com.tw<?php echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-action="recommend" data-show-faces="true" data-share="false"></div>
    </div>
    
    <?php
    //Detect special conditions devices
    $iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
    if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
            $Android = true;
    }else if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")){
            $Android = false;
            $AndroidTablet = true;
    }else{
            $Android = false;
            $AndroidTablet = false;
    }

    $webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $RimTablet= stripos($_SERVER['HTTP_USER_AGENT'],"RIM Tablet");
 
//do something with this information
    if( $iPhone || $Android){ ?>
                <div style="float:left; padding-left:10px;">
                <a href="http://line.naver.jp/R/msg/text/?<? echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/symposium.php?id=<?php echo $row_article['id']; ?>"><img src="images/linebutton_20x20.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->
    
    
    <!-- plurk share -->
    <div style="float:left; padding-left:10px; height:70px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>
       <!-- plurk share-end -->
    
    
    <!-- weibo-start -->
    <div style="float:left; padding-left:10px; padding-right:10px; height:70px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $row_article['title']; ?>&url=<?php echo $cur_url; ?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>
        <!-- weibo-end -->
    
    
    <!-- Twitter-start -->
    <div style="float:left;">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="zh-tw" data-size="large" data-count="true" data-dnt="true" title="推到我的 Twitter">推文</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
        <!-- Twitter-end -->
    
    
    </div>
    
<!-- share-end--> 
                     
                     
                     
                     
<!-- 達人簡介 -->
                     <div class="expert">
                        <?php if ($row_expert['icon']<>"") { ?>
                        <div class="expert_icon">
                            <img src="http://admin.iwine.com.tw/webimages/expert/<?php echo $row_expert['icon']?>">
                        </div>
                        <?php } ?>
                        <div class="expert_introduction">
                            <?php echo $row_expert['introduction']; ?>
                        </div>
                     
                     
                     </div>
                     
                    </div>
                    
                </div>
                <div class="row">
                    <div class="span9">
                    <h3 style="margin-top:30px;"><img src="images/wine_icon3.png" width="33" height="39"> <span class="title"><?php echo $row_expert['name']."專欄" ?></span></h3>
                    <img src="images/line03.png" width="1200" >
                    </div>
                </div>
                <?php if ($totalRows_article > 0) { // Show if recordset not empty ?>    
      <?php $i = 1; ?>
      <?php do { ?>
      <?php if(($i%3) == 1){ ?>
      <div class="row">
      <?php } ?>
        <div class="span3">
        <?php //if($_GET['e_id'] == 2){ ?> <!-- <div id="people_01"> --><?php //} ?>
        <div style="border:solid 0px #000000; margin-bottom:10px; padding:5px">
        <div style="height:199px; overflow:hidden">
        <a href="expert_article.php?n_id=<?php echo $row_article['n_id']; ?>" >
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>" alt="<?php echo $row_article['n_title']; ?>" >
        </a>
        </div>
        <?php //if($_GET['e_id'] == 2){ ?> <!-- </div> --><?php //} ?>
          <h5><div style="height:30px">
            <h5><a href="expert_article.php?n_id=<?php echo $row_article['n_id']; ?>"><?php echo $row_article['n_title']; ?></a><img src="images/article_line.png"></h5>
          </div></h5>
          <div style="padding-right:5px; height:40px"><?php echo substr_utf8(strip_tags($row_article['n_cont']),35) ;?>...</div>
          <div style="color: #CCC; height:20px" align="right"><?php echo $row_article['n_date']; ?></div>
          
          
            <div style="z-index: 9999; overflow:hidden; height:20px; margin-top:-20px !important;">
                <div style="float:left; z-index: 999;">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/expert_article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
               
          </div>
            <span style="color: #CCC; height:20px"><span style="height:30px"><img src="images/article_line.png"></span></span>
          </div>
          </div>
          <?php if(($i%3) == 0){ ?>
      </div>
      <?php } ?>
      <?php $i++; ?>
        <?php } while ($row_article = mysql_fetch_assoc($article)); ?>
      <?php if(($i%3) != 1){ ?>
      </div>
      <?php } ?>       
  <?php }else{ // Show if recordset not empty ?>
            <div class="row">
                    <div class="span9">
                        <h5>享受生活與美酒吧！</h5>
                    </div>
                </div>
  <?php } ?>
  <?php if($totalPages_article > 0){ ?>
<div class="pagination pagination-centered">
                    <ul>
                        <li><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, max(0, $pageNum_article - 1), $queryString_article); ?>">上一頁</a></li>
                        <?php  $tp = $totalPages_article+1;for($i=1;$i<=$tp;$i++){ ?>
                        <li <?php if($i == $pageNum_article + 1 ){ echo "class=\"active\""; } ?>><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, max(0, $i - 1), $queryString_article); ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <li><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, min($totalPages_article, $pageNum_article + 1), $queryString_article); ?>">下一頁</a></li>
                    </ul>
                </div>
                <?php } ?>
                
                
<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden; margin-left:0px;">


    <!-- FB fanpage like-start -->
    <div style="float:left; width:0px;">
        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
      <!-- FB fanpage like-end -->
    
    <!-- G+ share button-start -->
    <div style="float:left; padding-left:0px;">
        <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
    </div>
      <!-- G+ share button-end -->
    
    
    <!-- G+ share js-start -->
    <script type="text/javascript">
          window.___gcfg = {lang: 'zh-TW'};

          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/platform.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
    </script>
        <!-- G+ share js-end -->
    

    <!-- current page fb like-start -->
    <div style="float:left; padding-left:0px; width:60px;">
        <div class="fb-like" data-href="http://www.iwine.com.tw<?php echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-action="recommend" data-show-faces="true" data-share="false"></div>
    </div>
    
    <?php
    //Detect special conditions devices
    $iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
    if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
            $Android = true;
    }else if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")){
            $Android = false;
            $AndroidTablet = true;
    }else{
            $Android = false;
            $AndroidTablet = false;
    }

    $webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $RimTablet= stripos($_SERVER['HTTP_USER_AGENT'],"RIM Tablet");
 
//do something with this information
    if( $iPhone || $Android){ ?>
                <div style="float:left; padding-left:10px;">
                <a href="http://line.naver.jp/R/msg/text/?<? echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/symposium.php?id=<?php echo $row_article['id']; ?>"><img src="images/linebutton_20x20.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->
    
    
    <!-- plurk share -->
    <div style="float:left; padding-left:10px; height:70px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>
       <!-- plurk share-end -->
    
    
    <!-- weibo-start -->
    <div style="float:left; padding-left:10px; padding-right:10px; height:70px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $row_article['title']; ?>&url=<?php echo $cur_url; ?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>
        <!-- weibo-end -->
    
    
    <!-- Twitter-start -->
    <div style="float:left;">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="zh-tw" data-size="large" data-count="true" data-dnt="true" title="推到我的 Twitter">推文</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
        <!-- Twitter-end -->
    
    
    </div>
    
<!-- share-end--> 
                
                
                
                
                <div class="row">
       <div class="span9" align="center">
       <?php include('ad_content_bottom.php'); ?>
       </div>
       <div  style="margin-left:30px;"class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
       </div>
              </div>
            </div>          
          </div>
          
          
        </div>
        
        <div class="row">
        <div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon4.png" width="30" height="30"> iWine 排行榜 </h4>
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
           <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 熱門文章 </h4>
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
        <!--div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
        
        <?php include('ad_content_right.php'); ?>
        
     </div>
        
        
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

mysql_free_result($expert);
?>
<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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
