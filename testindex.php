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
//品酒活動 所需要的前置資料 開始
$_today = date('Y-m-d H:i:s'); 
$maxRows_symposium = 5;//品酒活動 最大數量
$pageNum_symposium = 0;

if (isset($_GET['pageNum_symposium'])) {
  $pageNum_symposium = $_GET['pageNum_symposium'];
}
$startRow_symposium = $pageNum_symposium * $maxRows_symposium;//傻眼的方式

mysql_select_db($database_iwine, $iwine);
//搜尋區域選單
$query_area = "SELECT area FROM (SELECT area FROM symposium WHERE active = 1 ORDER BY id DESC) AS temp GROUP BY area";
$area_querySet = mysql_query($query_area, $iwine) or die(mysql_error());
$area_total = mysql_num_rows($area_querySet);

//判斷搜尋條件,組合條件

$_today2 = date('Y-m-d');

if($_POST['act']=='searchform1'){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $append_query = sprintf("AND start_date >= '%s' AND start_date <= '%s'",
                       GetSQLValueString($start_date, "date"),
                       GetSQLValueString($end_date, "date"));
    $page_type = 'search';
}else if($_POST['act']=='searchform2'){
    $append_query = sprintf("AND area = '%s' AND start_date > '$_today2'", GetSQLValueString($_POST['area'], "text"));
    $page_type = 'search';
}else{
    $append_query = "AND start_date > '$_today2'";
    $page_type = 'default';
}


$query_symposium = sprintf("SELECT * FROM symposium WHERE active = 1 %s ORDER BY start_date ASC", $append_query);

if($page_type == 'default'){
    $query_limit_symposium = sprintf("%s LIMIT %d, %d", $query_symposium, $startRow_symposium, $maxRows_symposium);
}else{
    $query_limit_symposium = $query_symposium;
}

$symposium_query = mysql_query($query_limit_symposium, $iwine) or die(mysql_error());//star
$total_symposium = mysql_num_rows($symposium_query);//star
//品酒會廣告三則

$query_hotSymposium = "SELECT * FROM symposium WHERE active = 1 AND start_date > '".$_today."'ORDER BY RAND() LIMIT 3";
$hotSymposium_query = mysql_query($query_hotSymposium, $iwine) or die(mysql_error());

$total_hotSymposium = mysql_num_rows($hotSymposium_query);
if($page_type == 'default'){
    if (isset($_GET['totalRows_symposium'])) {
      $totalRows_symposium = $_GET['totalRows_symposium'];
    } else {
      $all_symposium = mysql_query($query_symposium);
      $totalRows_symposium = mysql_num_rows($all_symposium);
    }
    $totalPages_symposium = ceil($totalRows_symposium/$maxRows_symposium)-1;
}


$queryString_symposium = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_symposium") == false && 
        stristr($param, "totalRows_symposium") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_symposium = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_symposium = sprintf("&totalRows_symposium=%d%s", $totalRows_symposium, $queryString_symposium);

//品酒活動 所需要的前置資料 結束
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="ldciUWlDvibIj3ny2qU9ioxmEedndTTM-rsVUpx2K1I" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="description" content="跟著iWine我們一起去旅行！一起 體驗美酒 美食美女 美景 的生活吧！iwine提供葡萄酒、藝術、古典樂、Jazz與品酒會、品酒達人情報，不論紅酒、白酒、香檳、粉紅酒、氣泡酒、白蘭地、波特酒、冰酒、甜酒、貴腐酒、跟著iwine我們出發吧！">
    <meta name="author" content="">
    <meta property="og:title" content="首頁 - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
    <meta property="og:site_name" content="iWine">
    <!--<meta property="og:image" content="http://www.iwine.com.tw/images/logo.jpg">-->
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
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
        <div class="span9" style="margin-top:10px"><!-- 上邊緣留白 預設值 -->
          
        
            <div class="row">
            <div class="span9">
                <ul class="nav nav-tabs" style="margin:0 0 0 0px">
                    <li><a href="#tab1" data-toggle="tab">熱門文章</a></li>
                    <li class="active"><a href="#tab2" data-toggle="tab">最新文章</a></li><!--將 預設位置熱門文章轉成最新文章-->
                    <img src="images/menu_line.png">
                </ul>
                
                <div class="tab-content" style="padding-top:5px; margin-bottom:10px;">

                    <div class="tab-pane active" id="tab2">
                        <div class="row">
                        <div class="span9">
                        <div class="row">
                    

                    <?php if ($totalRows_newest_article > 0) { // Show if recordset not empty ?>    
      
		
        <div class="span3" >
            <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 最新文章 </h4>       
                   <div class="span3 hot_article" id="hot_article">
                   <?php do{ ?>
                    <div class="span3 each_hot_article" >
						<!-- -->
        <a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>" >       
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_newest_article['n_fig1']; ?>" alt="<?php echo $row_newest_article['n_title']; ?>">
        </a>
						<!-- -->
						<!-- -->
                        
		<a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>" style="margin-top:10px;">
		<?php echo $row_newest_article['n_title']; ?></a></br>
          
						<!-- -->
                    </div>
                   <?php } while ($row_newest_article = mysql_fetch_assoc($newest_article)); ?>
                    </div>
         </div>              
        
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
<!--

-->
                <div class="span3" >
                   <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 熱門文章 </h4>
                   <div class="span3 hot_article" id="hot_article">
                   <?php do{ ?>
                    <div class="span3 each_hot_article" >
						<!-- -->
                        <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>">
                        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                        </a>
						<!-- -->
						<!-- -->
                        <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>" style="margin-top:10px;">
                        <?php echo $row_hot['n_title']; ?>
                        </a>
						<!-- -->
                    </div>
                   <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
                    </div>
                </div>
				
		<?php if ($totalRows_newest_article > 0) { // Show if recordset not empty ?>    
      
		
        <div class="span3" >
            <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 最新文章 </h4>       
                   <div class="span3 hot_article" id="hot_article">
                   <?php do{ ?>
                    <div class="span3 each_hot_article" >
						<!-- -->
        <a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>" >       
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_newest_article['n_fig1']; ?>" alt="<?php echo $row_newest_article['n_title']; ?>">
        </a>
						<!-- -->
						<!-- -->
                        
		<a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>" style="margin-top:10px;">
		<?php echo $row_newest_article['n_title']; ?></a></br>
          
						<!-- -->
                    </div>
                   <?php } while ($row_newest_article = mysql_fetch_assoc($newest_article)); ?>
                    </div>
         </div>              
        
  <?php } ?>
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
