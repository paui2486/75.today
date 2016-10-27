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

mysql_select_db($database_iwine, $iwine);
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 7";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);

?>
<!DOCTYPE html>
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
<!--日曆顯示-->
<!--日曆顯示結束-->
    <script type='text/javascript'>
    $(document).ready(function(){
        $("#search2").click(function(){
            if($("#area").find(":selected").val()==""){
                alert("請輸入查詢區域~");
                return false;
            }
        });
     });
    </script>
    <style>
    
    </style>
  </head>
  
<body>
    <?php include('mainmenu_20140903.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>

        

                
<!-- -->   
    
<div class="span3">
<h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 品酒活動 </h4>
<div class="span3 hot_article" id="hot_article">
<?php do{ ?>
<div  > <!-- 小心class 的影響 -->
					
<table>						
						<?php while($symposium = mysql_fetch_assoc($symposium_query)) {
                                            $week=Array("日","一","二","三","四","五","六");
                                            $date_time=$symposium['start_date'];
                                            list($date)=explode(" ", $date_time); //取出日期部份
                                            list($Y,$M,$D)=explode("-",$date); //分離出年月日以便製作時戳
                                            $display_date = $M."/".$D;
                                            $display_week = "(".$week[date("w", mktime(0,0,0,$M,$D,$Y))].")";
                                            $now = date( "Y-m-d H:i:s", mktime());
                                            
                                            if( strtotime($now) > strtotime($date_time) ){ ?>
                                               <tr class="symposium_table" valign="top">
                                               <!--<td class="passed_item"><img src="images/icon_note_expired.png" style="max-width:100%"></td>-->
                                               
                                                 <td class="passed_item"><?php echo $symposium['title']; ?> <!--a href="symposium.php?id=<?php //echo $symposium['id']; ?>">詳情</a--></td>
                                                 <td class="passed_item">
                                                    <?php  echo $display_date." ".$display_week; ?>
                                                 </td>
                                                 <td class="passed_item"><?php echo $symposium['area']; ?></td>
                                                 <!--td align="left" class="passed_item"><?php //echo $symposium['address']; ?></td-->
                                                 <td class="passed_item">已截止</td>
                                               </tr>
                                           <?php }else{ ?><!-- 上面是活動時間已截止 以下這邊是活動列表 $symposium['id']活動ID $symposium['title']活動名稱-->
                                                <tr class="symposium_table"  valign="top">
												
												<td ><?php echo $display_date." ".$display_week; ?></td>
                                                 
												<td><a href="symposium.php?id=<?php echo  $symposium['id']; ?>" ><?php echo $symposium['title']; ?></a></td>
												
                                               </tr>
                                           <?php }; ?>
                                       <?php }; ?>
</table>						<!-- -->
                    </div>
                   <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
                    </div>
					</div>




                    
                    

              
              
            

            
            
        </div>
 
    </div>
    <?php include('footer.php'); ?>
    <script src="assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php  
mysql_free_result($area_querySet);
mysql_free_result($symposium_query);
mysql_free_result($all_symposium);
mysql_free_result($hotSymposium_query);
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
