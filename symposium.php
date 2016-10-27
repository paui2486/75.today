<?php
session_start(); 
include('func/func.php');
$cur_url = curPageURL();
?>
<?php require_once('Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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
 
$id = "-1";



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

mysql_select_db($database_iwine, $iwine);//從DB選擇顯示狀態為顯示且為最新文章10則
$query_newest_article = "SELECT * FROM article WHERE n_status = 'Y' AND n_title <> '' ORDER BY n_id DESC LIMIT 10";
$newest_article = mysql_query($query_newest_article, $iwine) or die(mysql_error());
$row_newest_article = mysql_fetch_assoc($newest_article);
$totalRows_newest_article = mysql_num_rows($newest_article);

//品酒活動 所需要的前置資料 開始
$_today = date('Y-m-d H:i:s'); 
$maxRows_symposium = 5;//首頁顯示 品酒活動 最大數量
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
    <title><?php echo $row_article['title']; ?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo substr_utf8(strip_tags($row_article['cont']),200) ;?>...">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $row_article['title']; ?> -- 禁止酒駕．未滿18歲禁止飲酒">
    <meta property="og:site_name" content="iWine">
    <meta property="og:image" content="http://www.iwine.com.tw/webimages/symposium/<?php echo $row_article['pic1']; ?>">
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
        <div id="MainContent" class="span9">
          <!--div class="row">
            <div class="span9"-->
            <!-- 麵包屑 -->
            <ul class="breadcrumb">
                <li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                <li><a href="symposium_list.php">品酒會情報</a> <span class="divider">/</span></li>
                <li class="active"><?php echo $row_article['title']; ?></li>
            </ul>
                
                
            <div class="row" style="border:#000000 solid 0px; margin-left:0px; margin-bottom:10px">
            
                <div class="span8">
                    <h2><img src="images/wine_icon1.png" width="35" height="35">品酒會情報</h2>
                    <span class="view_counter"><?php echo number_format($row_article['view_counter']); ?>人次點閱</span>
                    <img src="images/line03.png"><br>
                </div>
                
                
<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden;">


    <!-- FB fanpage like-start -->
    <div style="float:left; width:0px;">
        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
      <!-- FB fanpage like-end -->
    
    <!-- G+ share button-start 
    <div style="float:left; padding-left:0px;">
        <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
    </div>-->
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
    
	<!--fb SHARE START -->
	<div style="float:left; z-index: 999;"><!--fb分享--><!--注意分享網址 資料庫欄位-->
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/symposium.php?id=<?php echo $row_article['id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.png"></a>
    </div>
	<!--fb SHARE END -->
    <!-- current page fb like-start 
    <div style="float:left; padding-left:10px; width:60px;">
        <div class="fb-like" data-href="http://www.iwine.com.tw<?php echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-action="recommend" data-show-faces="true" data-share="false"></div>
    </div>-->
    
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
                <a href="http://line.naver.jp/R/msg/text/?<?php echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/symposium.php?id=<?php echo $row_article['id']; ?>"><img src="images/line.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->
    
    
    <!-- plurk share 
    <div style="float:left; padding-left:10px; height:70px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>-->
       <!-- plurk share-end -->
    
    
    <!-- weibo-start 
    <div style="float:left; padding-left:10px; padding-right:10px; height:70px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $row_article['title']; ?>&url=<?php echo $cur_url; ?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>-->
        <!-- weibo-end -->
    
    
    <!-- Twitter-start 
    <div style="float:left;">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="zh-tw" data-size="large" data-count="true" data-dnt="true" title="推到我的 Twitter">推文</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>-->
        <!-- Twitter-end -->
    
    
    </div>
    
<!-- share-end-->    
    
    
    
    

<div style="clear:both;"></div>
                    
                <div class="span8" style="padding:0px">
                    <h2 class="winetast_title"><?php echo $row_article['title']; ?></h2>

                        <div class="article_txt" style="margin-top:20px; margin-bottom:50px">
                            <img src="http://www.iwine.com.tw/webimages/symposium/<?php echo $row_article['pic1']?>" width="694" height="442">
                            <br>
                            <br>
                            <div class="symposium_contain">
                            <?php 
                                if ($row_article['contain_html'] <> "") {
                                    echo $row_article['contain_html'];
                                }else{
                                    echo nl2br(puretext_add_htmllinktag($row_article['description']));
                                }  
                            ?>
                            </div>
                            <?php 
                            //附加圖片
                            for($i=2; $i<=5; $i++){
                                $current_file_name= 'pic'.$i; 
                                $current_file_path = "../web/webimages/symposium/".$row_article[$current_file_name];
                                if (is_file($current_file_path)){
                                    echo "<span class=\"article_txt\" style=\"margin-top:20px; margin-bottom:50px\"><img src=\"http://www.iwine.com.tw/webimages/symposium/".$row_article[$current_file_name]."\" width=\"191\" height=\"191\"></span>";
                                }
                            } ?>
                            
                        </div>

                    
                    <?php if($row_article['speaker']<> "") {?>
                        <div style="margin-top:10px; margin-bottom:10px">
                        <h2 class="winetast_subtitle" ><img src="images/icon.png" width="16" height="22"> 講師</h2>
                        </div>
                        <div class="winetast_txt01" style="margin-top:10px; margin-bottom:10px">
                           <?php echo $row_article['speaker']; ?>
                        </div>
                        
                         <div class="article_txt" style="margin-top:20px; margin-bottom:20px">
                            <?php echo nl2br(puretext_add_htmllinktag($row_article['speaker_info'])); ?>
                         </div>
                     <?php } ?>
                     
                    <div id=""><!--winetast_03 粉紅斜線底 風格-->
                       <p>&nbsp;</p>
                       <?php if($row_article['start_date'] != ""){?>
                           <div id="winetast_01" align="center" ><img src="images/icon.png" width="16" height="22">&nbsp;活動時間</div>
                           <div id="winetast_02" class="article_txt">
                                <?php 
                                    if($row_article['start_date'] != ""){ 
                                        echo $row_article['start_date'];
                                        if($row_article['end_date'] != ""){
                                            echo "~".$row_article['end_date'];
                                        }
                                    } 
                                ?>
                            </div>
                            <p>&nbsp;</p>
                        <?php } ?>
                        <?php if($row_article['location'] != ""){?>
                        <div id="winetast_01" align="center" ><img src="images/icon.png" width="16" height="22">&nbsp;活動地點</div><!--class="winetast_subtitle"-->
                        <div id="winetast_02" class="article_txt"><?php echo $row_article['location']; ?></div>
                        <p>&nbsp;</p>
                        <?php } ?>
                        <?php if($row_article['address'] != ""){?>
                        <div id="winetast_01" align="center" ><img src="images/icon.png" width="16" height="22">&nbsp;活動地址</div>
                        <div id="winetast_02" class="article_txt"><?php echo $row_article['address']; ?></div>
                        <p>&nbsp;</p>
                        <?php } ?>
                        <?php if($row_article['area'] != ""){?>
                        <div id="winetast_01" align="center" ><img src="images/icon.png" width="16" height="22">&nbsp;活動區域</div>
                        <div id="winetast_02" class="article_txt"><?php echo $row_article['area']; ?></div>
                        <p>&nbsp;</p>
                        <?php } ?>
                        <?php if($row_article['fee'] != ""){?>
                        <div id="winetast_01" align="center" ><img src="images/icon.png" width="16" height="22">&nbsp;活動費用</div>
                        <div id="winetast_02" class="article_txt"><?php echo $row_article['fee']; ?> 元</div>
                        <p>&nbsp;</p>
                        <?php } ?>
                        <?php if($row_article['host'] != ""){?>
                        <div id="winetast_01" align="center" ><img src="images/icon.png" width="16" height="22">&nbsp;主辦單位</div>
                        <div id="winetast_02" class="article_txt"><?php echo $row_article['host']; ?></div>
                        <p>&nbsp;</p>
                        <?php } ?>
                        <?php if($row_article['order_deadline'] != ""){?>
                        <!--div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22">繳費期限</div>
                        <div id="winetast_02" class="article_txt">至<?php echo $row_article['order_deadline']; ?></div>
                        <p>&nbsp;</p-->
                        <?php } ?>
                        <?php if($row_article['enrollment'] != ""){?>
                        <div id="winetast_01" align="center" ><img src="images/icon.png" width="16" height="22">&nbsp;報名方式</div>
                        <div id="winetast_02" class="article_txt"><?php echo nl2br(puretext_add_htmllinktag($row_article['enrollment'])); ?></div>
                        <?php } ?>
                    </div>
                    <?php if($row_article['wine_list'] != ""){?>
                    <div class="winetast_txt01">
                          <p>&nbsp;</p>
                          <img src="images/icon.png" width="16" height="22">酒單
                    </div>

                    <div class="article_txt" style="margin-top:20px; margin-bottom:20px">
                        
                      <?php echo nl2br($row_article['wine_list']); ?>
                    </div>
                    <?php } ?>
                    <div class="row escape_clause02 span9" style="font-size:130% !important; padding-top:20px; margin-bottom">未滿十八歲者，禁止飲酒</div>
                    <div class="row escape_clause02 span9" style="font-size:130% !important; padding-top:20px; margin-bottom">iWine 貼心提醒您：禁止酒駕，安全有保障！</div>
                    <div class="row escape_clause02 span9" style="padding-top:40px; padding-bottom:20px;">＊品酒會情報由會員自行提供，活動內容與相關事宜請洽主辦單位，iWine 僅提供資訊情報平台</div>
                </div>
      
                
<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden;">


    <!-- FB fanpage like-start -->
    <div style="float:left; width:0px;">
        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
      <!-- FB fanpage like-end -->
    
    <!-- G+ share button-start 
    <div style="float:left; padding-left:0px;">
        <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
    </div>-->
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
    
	<!--fb SHARE START -->
	<div style="float:left; z-index: 999;"><!--fb分享--><!--注意分享網址 資料庫欄位-->
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/symposium.php?id=<?php echo $row_article['id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.png"></a>
    </div>
	<!--fb SHARE END -->
    <!-- current page fb like-start 
    <div style="float:left; padding-left:10px; width:60px;">
        <div class="fb-like" data-href="http://www.iwine.com.tw<?php echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-action="recommend" data-show-faces="true" data-share="false"></div>
    </div>-->
    
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
                <a href="http://line.naver.jp/R/msg/text/?<?php echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/symposium.php?id=<?php echo $row_article['id']; ?>"><img src="images/line.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->
    
    
    <!-- plurk share 
    <div style="float:left; padding-left:10px; height:70px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>-->
       <!-- plurk share-end -->
    
    
    <!-- weibo-start 
    <div style="float:left; padding-left:10px; padding-right:10px; height:70px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $row_article['title']; ?>&url=<?php echo $cur_url; ?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>-->
        <!-- weibo-end -->
    
    
    <!-- Twitter-start 
    <div style="float:left;">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="zh-tw" data-size="large" data-count="true" data-dnt="true" title="推到我的 Twitter">推文</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>-->
        <!-- Twitter-end -->
    
    
    </div>
    
<!-- share-end-->    
    


<div style="clear:both;"></div>
                
                <div align="center" style="padding:10px">
                    <!--input name="check_form" type="hidden" value="Y"-->
                    <!--button type="button" class="btn btn-danger" onClick="chkform();">馬上參加</button-->
                </div>

                    
                    <div class="row">
                    
                        <div class="span9">
						<h4><br>
                        <img src="images/wine_icon1.png" width="35" height="35"> <span class="title">更多品酒會：</span><br>
                        </h4>
                        <!-- 品酒活動區塊開始 -->
			<div class="each_list">
			<table  border="0" align="center">
			<!--<td align="center" width="1022" ><h3>品酒活動</h3></td>background="images/bg2.png"-->
			</table>
			<img src="images/menu_line.png">
                                <?php if($total_symposium > 0) {?>
                                    <table width="100%" height="145"  border="0" >
									<!--background="images/bg2.png"-->
									   <tr align="left">
                                         <th width="55" >&nbsp;</th><!--background="images/bg2.png"-->
                                         <th width="232" >活動主題 </th><!--background="images/bg2.png"-->
                                         <th width="93" >日期</th><!--background="images/bg2.png"-->
                                         <th width="78" >區域</th><!--background="images/bg2.png"-->
                                         <!--th width="236" background="images/bg2.png">地址</th-->
                                         <th width="53"  > 報名狀態</th><!--background="images/bg2.png"-->
                                       </tr>
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
                                               <td class="passed_item"><img src="images/icon_note_expired.png" style="max-width:100%"></td>
                                               
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
                                  
                                  <td><span class="passed_item"><a href="symposium.php?id=<?php echo $symposium['id']; ?>"><img src="images/icon_note.jpg" style="max-width:100%"></a></span></td>
                                                     <td><a href="symposium.php?id=<?php echo $symposium['id']; ?>"><?php echo $symposium['title']; ?></a></td>
                                                     <td>
                                                        <?php echo $display_date." ".$display_week; ?>
                                                     </td>
                                                     <td><?php echo $symposium['area']; ?></td><!--活動地點-->
                                                     <!--td align="left" ><?php //echo $symposium['address']; ?></td-->
                                                     <td ><?php if($symposium['available']==0) {echo "<font color=#D0085B>已額滿</font>";} else {echo "歡迎報名";} ?></td><!--是否可以報名-->
                                               </tr>
                                           <?php }; ?>
                                       
                                       <?php }; ?>
									   
                                     </table>
									 <!--<table align="center">
									 <th background="images/article_people.png"><a href="http://iwine.com.tw/symposium_list.php">更多活動</a></th>
									 </table>-->
									 <div> <?php echo ('<BR>')?></div>
									 <div align="center"><input type="button" value="更多活動" onclick="location.href='http://iwine.com.tw/symposium_list.php'"></div>
                                <?php }else{ echo " <TABLE><TR><TD STYLE='HEIGHT:100PX;'>暫無資訊，敬請期待！ </TD></TR></TABLE>"; } ?>
                            </div>
			<!-- 品酒活動區塊結束 -->  

                         
    <p>&nbsp;</p>

    <div class="span8" style="padding:0px">
          <h4>&nbsp;</h4>
    <?php include('ad_content_bottom.php'); ?> 
          <h4>&nbsp;</h4>
    </div>
             

                        </div>
                    </div>
                    
                    <!--<<div class="row">
                        <div class="span9" style="border:solid 0px #000000; margin-bottom:10px">
                            <div style="padding:10px; background-image:url(images/bg2.png)">
                                <img src="images/guest.png" width="140" height="30">
                            </div>
                            <div align="center" style="padding:10px">
                                <div class="fb-comments" data-href="http://www.iwine.com.tw/symposium.php?id=<?php echo $row_article['id']; ?>"></div>
                            </div>-->
                        <!--<div  style="margin-left:30px;"class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>-->
                        <!--</div>
                    </div>-->
              
          </div>
          
          
        </div>
        <!--<div class="row">
            <div class="span3" align="center"  id="hot_position">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine 排行榜 </h4>
            <?php //include('ad_1.php'); ?>
        </div>-->
        <div> <?php echo ('<BR><BR><BR><BR><BR>')?></div>
        
        <div class="span3" >
                   <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 最新文章 </h4>
                   <div class="span3 hot_article" id="hot_article">
                   <?php do{ ?>
                    <div class="span3 each_hot_article" >
                        <a href="/article.php?n_id=<?php echo $row_newest_article['n_id']; ?>">
                        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_newest_article['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                        </a>
                        <a href="/article.php?n_id=<?php echo $row_newest_article['n_id']; ?>" style="margin-top:10px;">
                        <?php echo $row_newest_article['n_title']; ?>
                        </a>
                    </div>
                   <?php } while ($row_newest_article = mysql_fetch_assoc($newest_article));?>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
<?php
mysql_free_result($article);
mysql_free_result($hot);
mysql_free_result($Result1);
include('ga.php'); 
?>
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