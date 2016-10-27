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

	switch($_GET['ap_class']){ 
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


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_article = 12;
$pageNum_article = 0;
if (isset($_GET['pageNum_article'])) {
  $pageNum_article = $_GET['pageNum_article'];
}
$startRow_article = $pageNum_article * $maxRows_article;

$colname_article = "1";
if (isset($_GET['ap_class'])) {
  $colname_article = $_GET['ap_class'];
}
mysql_select_db($database_iwine, $iwine);
$query_article = sprintf("SELECT * FROM seek_detail WHERE ap_class = %s AND ap_show= 'Y' ORDER BY ap_date DESC", GetSQLValueString($colname_article, "int"));
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
    <title><?php echo $pet_class ;?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $pet_class ;?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
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
  					<li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li><?php echo $pet_class ;?></li>
				</ul>
                <div class="row">
           			<div class="span9">
                		<h3><img src="images/wine_icon1.png" width="50" height="50"> <?php echo $pet_class ;?></h3><hr>
                    </div>
                </div>
                 <div class="row">
           			<div class="span9">
                		<p>＊如果您有需要協尋毛寶貝，或是有尋獲走失的毛寶貝，歡迎您到<a href="https://www.facebook.com/5iPet" target="new">iPet粉絲團</a>上發文或私訊告訴我們，我們會儘快資料整理後公告在粉絲團與網站上。</p><hr>
                    </div>
                </div>
                <?php if ($totalRows_article > 0) { // Show if recordset not empty ?>    
      <?php $i = 1; ?>
	  <?php do { ?>
      <?php if(($i%3) == 1){ ?>
      <div class="row">
      <?php } ?>
        <div class="span3">
        <div style="border:solid 1px #000000; margin-bottom:10px; padding:5px;background-image:url(images/bg.png)">
        <div style="height:199px; overflow:hidden">
		<a href="seek_detail.php?ap_id=<?php echo $row_article['ap_id']; ?>" >
        <img src="http://admin.iwine.com.tw/webimages/adopt/<?php echo $row_article['ap_photo']; ?>" alt="<?php echo $row_article['ap_breed']; ?>">
        </a>
        </div>
          <h4><div style="height:20px"><a href="seek_detail.php?ap_id=<?php echo $row_article['ap_id']; ?>"><?php echo $row_article['ap_breed']; ?></a></div></h4>
          <?php if($row_article['ap_class'] == 1){ ?>
          <div style="padding-right:5px; height:20px">走失日期：<?php echo $row_article['ap_date2']; ?></div>
          <div style="padding-right:5px; height:20px">走失地區：<?php echo $row_article['ap_county']; ?></div>
          <div style="padding-right:5px; height:20px">名字：<?php echo $row_article['ap_name']; ?></div>
          <div style="padding-right:5px; height:20px">性別：<?php echo $row_article['ap_sex']; ?></div>
          <div style="padding-right:5px; height:20px">年齡：<?php echo $row_article['ap_age']; ?></div>
          <div style="padding-right:5px; height:20px">體重：<?php echo $row_article['ap_weight']; ?></div>         
          <?php }elseif($row_article['ap_class'] == 2){ ?>
          <div style="padding-right:5px; height:20px">尋獲日期：<?php echo $row_article['ap_date2']; ?></div>
          <div style="padding-right:5px; height:20px">尋獲地區：<?php echo $row_article['ap_county']; ?></div>
          <div style="padding-right:5px; height:20px">性別：<?php echo $row_article['ap_sex']; ?></div>
          <div style="padding-right:5px; height:20px">體重：<?php echo $row_article['ap_weight']; ?></div>         
          <?php } ?>
          <div style="padding-right:5px; height:20px">狀態：<?php 
	switch($row_article['ap_status']){ 
	case '1':
		echo "等待主人中";
		break;
	case '2':
		echo "新待毛寶貝中";
		break;
	case '3':
		echo "已回到溫暖的家";
		break;
	}		
	?></div>
          <div style="color: #CCC; height:20px" align="right"><?php echo $row_article['ap_date']; ?></div>
          <div align="center" style=" margin-bottom:10px"><a href="seek_detail.php?ap_id=<?php echo $row_article['ap_id']; ?>" class="btn btn-small btn-primary"><i class="icon-search icon-white"></i>詳細資訊</a></div>
            <div class="fb-like" data-href="http://www.iwine.com.tw/seek_detail.php?ap_id=<?php echo $row_article['ap_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="true"></div>
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
                		<h5>目前尚無<?php echo $pet_class ;?>的資訊。</h5>
                    </div>
                </div>
  <?php } ?>
  <?php if($totalPages_article > 0){ ?>
<div class="pagination pagination-centered">
  					<ul>
    					<li><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, max(0, $pageNum_article - 1), $queryString_article); ?>">上一頁</a></li>
    					<?php  $tp = $totalPages_article+1;for($i=1;$i<=$tp;$i++){ ?>
                        <li <?php if($i == $pageNum_news + 1 ){ echo "class=\"active\""; } ?>><a href="<?php printf("%s?pageNum_news=%d%s", $currentPage, max(0, $i - 1), $queryString_news); ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <li><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, min($totalPages_article, $pageNum_article + 1), $queryString_article); ?>">下一頁</a></li>
  					</ul>
				</div>
                <?php } ?>
              </div>
            </div>          
          </div>
          
          
        </div>
        <div class="row">
        <div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine嚴選</h4>
        	<?php include('ad_1.php'); ?>
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
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
