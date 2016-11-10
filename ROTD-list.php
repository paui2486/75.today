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

//品酒活動 所需要的前置資料 開始
$_today = date('Y-m-d H:i:s'); 
$maxRows_symposium = 10;
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

//品酒活動 所需要的前置資料 結束

?>

<?php
	$sql ='SELECT * FROM `ROTD` ORDER BY timestamp DESC limit 9';//搜尋語句
    $result = mysql_query($sql, $iwine) or die(mysql_error());// 連線是否成功
	$result_total = mysql_num_rows($result); //可以知道有幾筆資料    
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>˙75今日奇聞 讀者上稿 </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="讀者上稿-75.today 今日奇聞">
    <meta name="author" content="">
    <meta property="og:title" content="讀者上稿-75.today 今日奇聞">
    <meta property="og:site_name" content="75.today 今日奇聞">
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
    
    <!--<link rel="shortcut icon" href="assets/ico/favicon.ico">-->
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
  <?php include_once("analyticstracking.php") ?>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=540353706035158";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <?php include('mainmenu.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
        
        <div class="row container-area">
            <div id="MainContent" class="span9">
            <div class="row">
                <div class="span9">
                    <div>
                        <ul class="breadcrumb">
                            <li><a href="index.php">首頁</a></li>
                            
                        </ul>
                        <div class="row">
                        <div class="span9">
                             <div class="title_uploadimg">
                                <div style="float:left;"><h3><img src="images/wine_icon1.png" width="35" height="35">讀者上稿</h3></div>
                                <div style="float:right; right:0px; top:0px; padding-top:20px;"><a href="ROTD-upload.php" onclick="alert('請先登入會員，謝謝！');"><input type="button" value="讀者上傳" onclick="location.href='http://75.media/web/ROTD-upload.php'"></a></div>
                            </div>
                      
                            <img src="images/line03.png" width="1200">
         
               
        <!--文章列表-->                         
        <div class="each_list">
        <!--未來插入內容區塊-->	
		<?php
		while($row = mysql_fetch_assoc($result))
		{
		//echo($row["id"]);
		
		//echo($row["creat_time"]);?>
		<div class="ad_list" >
			<div class="number">
				<div class="pic">
				<!--tag-->
				<a href="ROTD.php?id= <?php echo $row['id']; ?>"><img src="<?php if($row['pic1']<>""){
						echo "http://www.75.today/web/webimages/".$row['pic1'];
					}else{ echo "icon_prev.gif";} ?>" width="250" height="193" border="0" title="" ></a>
				</div>
				<div class="title">
				<a href="ROTD.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a>
				
				</div>
				   <div style="background-image:url(images/article_line.png); height:8px;"></div><!--分隔線-->
				   
				   <div style="padding-right:5px; height:40px; line-height:20px;">
				   <?php// echo substr_utf8(strip_tags($row['n_Variety']),35) ;?>

				   </div>
				   
				   <div style="z-index: 9999; overflow:hidden; height:20px; margin-top:-30px !important;">
						<div style="float:left; z-index: 999;">
						<a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.75.media/web/wine-section.php?id=<?php echo $row['id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
						</div>
						<!--<div style="color: #949494; height:20px" align="right"><?php echo $row['timestamp']; ?></div>-->
				   </div>
			</div>
		</div>
		<?php
		//echo($row["Article"]);
		//echo("<br>");
		}
		?>
                            </div>              
        <!---文章列表結束-->         
                            
                        </div>
                        </div>
                        <p>&nbsp;</p>
                   
                    </div>

                    
<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden;">


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
                <a href="http://line.naver.jp/R/msg/text/?<?php echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/wine-section.php?id=<?php echo $row_article['id']; ?>"><img src="images/linebutton_20x20.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->

    
    
    </div>
    
<!-- share-end--> 
   
                    <div class="row">
                       <div class="span9" align="center">
                       <?php //include('ad_content_bottom.php'); ?>
                       </div>
                    <!--<div  style="margin-left:30px;"class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>-->
                    </div>
                </div>
            </div>          
            </div>
              
              
            
            	

    
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