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

$editFormAction = $_SERVER['PHP_SELF'];
$currentPage = $_SERVER["PHP_SELF"];

$_today = date('Y-m-d H:i:s'); 
$maxRows_symposium = 30;
$pageNum_symposium = 0;

if (isset($_GET['pageNum_symposium'])) {
  $pageNum_symposium = $_GET['pageNum_symposium'];
}
$startRow_symposium = $pageNum_symposium * $maxRows_symposium;

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

$symposium_query = mysql_query($query_limit_symposium, $iwine) or die(mysql_error());
$total_symposium = mysql_num_rows($symposium_query);
//品酒會廣告三則
// $query_hotSymposium = "SELECT * FROM symposium WHERE active = 1 AND ishot = 1 AND start_date > '".$_today."'ORDER BY RAND() LIMIT 3";
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

mysql_select_db($database_iwine, $iwine);
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 7";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);

//品酒情報 sql command

mysql_select_db($database_iwine, $iwine);
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_article = sprintf("SELECT * FROM symposium WHERE id = %s AND active = 1 ", GetSQLValueString($id, "int"));
    // $query_article = sprintf("SELECT * FROM symposium WHERE id = %s", GetSQLValueString($id, "int"));
}else{
    $query_article = "SELECT * FROM symposium WHERE active = 1 ORDER BY id DESC limit 1";
    // $query_article = "SELECT * FROM symposium ORDER BY id DESC limit 1";
}

$article = mysql_query($query_article, $iwine) or die(mysql_error());
$row_article = mysql_fetch_assoc($article);
$totalRows_article = mysql_num_rows($article);

if($totalRows_article == 0){
    go_to('symposium_list.php');
    exit;
}
$a_id = $row_article['id'];

$page_count = $row_article['view_counter'] + 1;
$updateSQL = sprintf("UPDATE symposium SET view_counter = %s WHERE id = %s", $page_count, GetSQLValueString($a_id, "int"));
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());


mysql_select_db($database_iwine, $iwine);
$query_other = "SELECT * FROM symposium WHERE id <> '$a_id' AND active = 1 ORDER BY RAND() LIMIT 3";
// $query_other = "SELECT * FROM symposium WHERE id <> '$a_id' ORDER BY RAND() LIMIT 3";
$other = mysql_query($query_other, $iwine) or die(mysql_error());
$row_other = mysql_fetch_assoc($other);
$totalRows_other = mysql_num_rows($other);

mysql_select_db($database_iwine, $iwine);
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);

//

?>
<html lang="zh_tw">

  <head>
    <meta charset="utf-8">
    <title>品酒情報 - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="酒食搭 跟著iWine我們一起去旅行！一起 體驗美酒 美食美女 美景 的生活吧！iwine提供葡萄酒、藝術、古典樂、Jazz與品酒會、品酒達人情報，不論紅酒、白酒、香檳、粉紅酒、氣泡酒、白蘭地、波特酒、冰酒、甜酒、貴腐酒、跟著iwine我們出發吧！">
    <meta name="author" content="">
    <meta property="og:title" content="品酒情報 - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
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
    
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link href='js/datetimepick/lib/jquery-ui-timepicker-addon.css' rel='stylesheet'>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-timepicker-addon.js'></script>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-sliderAccess.js'></script>
    <script type='text/javascript' src='js/datetimepick/jquery-ui-timepicker-zh-TW.js'></script>

  </head>

				<div class="span3">
                   <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 品酒活動 </h4>
                   <div class="span3 hot_article" id="hot_article">
                   <?php do{ ?>
                    <div class="span3 each_hot_article" >
                        <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>">
                        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                        </a>
						<!--<a href="symposium.php?id=<?php// echo $symposium['id']; ?>"><?php// echo $symposium['title']; ?></a>-->
                        <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>" style="margin-top:10px;">
                        <?php echo $row_hot['n_title']; ?>
                        </a>
                    </div>
                   <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
                    </div>
                </div>
				
				</html>