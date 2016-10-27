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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_article = 12;
$pageNum_article = 0;
if (isset($_GET['pageNum_article'])) {
  $pageNum_article = $_GET['pageNum_article'];
}
$startRow_article = $pageNum_article * $maxRows_article;

$colname_article = "-1";
if (isset($_GET['pc_id'])) {
  $colname_article = $_GET['pc_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_article = sprintf("SELECT * FROM article WHERE n_class = %s AND n_status= 'Y' ORDER BY n_order ASC, n_date DESC", GetSQLValueString($colname_article, "int"));
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

$colname_article_Class = "-1";
if (isset($_GET['pc_id'])) {
  $colname_article_Class = $_GET['pc_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_article_Class = sprintf("SELECT * FROM article_class WHERE pc_id = %s", GetSQLValueString($colname_article_Class, "int"));
$article_Class = mysql_query($query_article_Class, $iwine) or die(mysql_error());
$row_article_Class = mysql_fetch_assoc($article_Class);
$totalRows_article_Class = mysql_num_rows($article_Class);

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
    <title><?php echo $row_article_Class['pc_name']; ?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $row_article_Class['pc_description'];?>">
    <meta name="keyword" content="<?php echo $row_article_Class['pc_keyword'];?>">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $row_article_Class['pc_name']; ?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
	<meta property="og:site_name" content="iWine">
	<meta property="og:image" content="http://www.iwine.com.tw/images/logo.jpg">
	<meta property="og:type" content="website">
	<meta property="og:description" content="<?php echo $row_article_Class['pc_description'];?>">
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
                    <li class="active" class="expert_h2"><?php echo $row_article_Class['pc_name']; ?></li>
				</ul>
                
                
                <div class="row">
           			<div class="span9">
               		  <h3><img src="images/wine_icon1.png" width="35" height="35"> <span class="title"><?php echo $row_article_Class['pc_name']; ?></span></h3>
           			 <img src="images/line03.png" width="1200">
                    </div>
                </div>
                <?php if ($totalRows_article > 0) { // Show if recordset not empty ?>    
      <?php $i = 1; ?>
	  <?php do { ?>
      <?php if(($i%3) == 1){ ?>
      <div class="row">
      <?php } ?>
        <div class="span3">
        <?php //if($_GET['pc_id'] == 2){ ?> <!-- <div id="people_01"> --><?php //} ?>
        <div style="border:solid 0px #000000; margin-bottom:15px; padding:10px">
        <div style="<?php if($colname_article==14) echo "height:250px"; else echo "height:199px;"; ?> overflow:hidden">
		<a href="article.php?n_id=<?php echo $row_article['n_id']; ?>" >
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>" alt="<?php echo $row_article['n_title']; ?>" >
        </a>
        </div>
        <?php //if($_GET['pc_id'] == 2){ ?> <!-- </div> --><?php //} ?>
       
          <h4><div style="height:30px">
            <h7><a href="article.php?n_id=<?php echo $row_article['n_id']; ?>"><?php echo $row_article['n_title']; ?></a>
   <div style="background-image:url(images/article_line.png); height:8px;">

  </div>
            
            </h7>
          </div></h4>
          
          <div style="padding-right:5px; height:60px; line-height:20px;"><?php echo substr_utf8(strip_tags($row_article['n_cont']),35) ;?>...</div>
          <div style="color: #949494; height:20px" align="right"><?php echo $row_article['n_date']; ?></div>
          <div style="z-index: 9999; overflow:hidden; height:20px; margin-top:-20px !important;">
                <div style="float:left; z-index: 999;">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494;">
                    <?php echo number_format($row_article['view_counter']); ?> 人次點閱
                </div>
          </div>
          <!--div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
            <div style="">
                <div class="fb-like" style="position: absolute; margin-top:-0px; margin-left:5px; overflow:hidden !important; z-index: 999; width:90px !important;" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" data-width="90"></div>
                
            </div>
            <div style="float:left; padding-left:90px; z-index: 999;">
                <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
            </div>
            <div style="float:left; z-index: 9999; display: inline;">
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id'];?>" data-via="draqula" data-lang="zh-tw" data-count="none">推文</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </div>
            <div style="float:left; padding-left:5px; z-index: 9999; display: inline;">
            <div class="g-plusone" data-annotation="none" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id'];?>">
            
            
            </div>



            </div>

        </div-->
          
         <div style="background-image:url(images/article_line.png); height:8px;">

  </div>
        
        
            <!--div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="true"></div>
            
            
            <!--div align="right">
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;">
       
<div align="left">        
<img src="images/article_line.png"></div>
        </a><a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"></a><a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;">
        </a>
            </div-->
        
        
        <!--
          <div align="right" style="height:20px"><i class="icon-tag"></i> 
            <a href="article_search.php?keyword=<?php echo urlencode($row_article['n_tag']); ?>" style="font-size:12px; color:#998675; padding-right:3px"><?php echo $row_article['n_tag']; ?></a>
            </div>
            -->
            
            
            
          </div>

          <p>
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
                		<h5>目前本區尚無文章。</h5>
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
           <h4 align="left"><img src="images/wine_icon4.png" width="30" height="30"> 品牌專區 </h4>
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
     
     
      
      
      <div class="row">
      
      </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
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
mysql_free_result($article);

mysql_free_result($article_Class);
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
