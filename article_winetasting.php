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
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $row_article_Class['pc_name']; ?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
	<meta property="og:site_name" content="iWine">
	<meta property="og:image" content="images/logo.jpg">
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
              <div>
                <ul class="breadcrumb">
  					<li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $row_article_Class['pc_name']; ?></li>
				</ul>
                <div class="row">
           			<div class="span9">
               		  <h3><img src="images/wine_icon1.png" width="50" height="50">品酒會活動</h3>
 <img src="images/line03.png" width="1200">
<div id="winetast_row">依時間搜尋:  
  <input name="textfield" type="text" id="textfield" value="2013/12/01">
  <img src="images/icon_time.png">至 
   <input name="textfield2" type="text" id="textfield2" value="2013/12/25">
   <img src="images/icon_time.png"><a href="#"><img src="images/icon_search.png" width="40" height="13"></a></div>

<p>&nbsp;</p>
<div id="winetast_row">
  依區域搜尋:
    <select name="select" id="select">
      <option>北部</option>
      <option>中部</option>
      <option>南部</option>
      <option>東部</option>
    </select>
    <a href="#"><img src="images/icon_search.png" width="40" height="13"></a>
</div>
<p>&nbsp;</p>
<p><img src="images/line03.png" width="1200"></p>

<div>
<div id="winetast_pic"><img src="images/pic04.png"></div>

<div>
<div class="article_txt"><a href="#">大衛潘的加州酒釀酒密技解剖【台北】大衛</a><br>
<img src="images/article_line02.png" width="450" height="7"></div>
 
<div>你看過村上春樹的新書了嗎？<br>
&lt;沒有色彩的多崎作和他的巡禮之年&gt;村上的這本新書不但打破版權費的歷史紀錄，目前也持續蟬聯各大書店的排行榜。這次村上的新書是講述一個36歲痴迷於鐵路的工程師重新掌握自己人生的故事。作品描繪了主人公多崎作努力克服內心深處幽暗部分中的失落感與孤獨絕望，展現並歌頌了主人公的堅強。</div>

<div class="article_txt"><img src="images/article_line02.png" width="450" height="7"><br>
讚 分享 <img src="images/btn_add.png"></div>
</div>
</p>
<div class="article_txt">
 <h5>目前本區尚無文章。</h5>
 </div>

</div>





 </div>
 </div>
   <p>&nbsp;</p>
                <p>&nbsp;</p>
              </div>
              <div class="row">
                <div class="span9" align="center"></div>
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
