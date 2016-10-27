<?php 
session_start(); 
include('func/func.php');
?>
<?php require_once('Connections/iwine.php'); ?>
<?php
	$sql ='SELECT * FROM `Press_release` ORDER BY creat_time DESC limit 9';//搜尋語句
    $result = mysql_query($sql, $iwine) or die(mysql_error());// 連線是否成功
	$result_total = mysql_num_rows($result); //可以知道有幾筆資料    
?>
<?php
//品酒活動 所需要的前置資料 開始
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

//品酒活動 所需要的前置資料 結束
?>

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
                <a href="http://line.naver.jp/R/msg/text/?<?php echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/symposium.php?id=<?php echo $row_article['id']; ?>"><img src="images/linebutton_20x20.png"></a>
                </div>
    <?php } ?>

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
                    <li class="active" class="expert_h2"><?php echo "品牌情報"; ?></li>
				</ul>
                <div class="row">
           			<div class="span9">
	<!--上傳-->		<div style="float:right; right:0px; top:0px; padding-top:20px;"><a href="Press-release.php" onclick="alert('請先登入會員，謝謝！');"><img src="images/btn_Press_upload.png" width="117" height="33"></a></div>
               		  <h3><img src="images/wine_icon1.png" width="35" height="35"> <span class="title"><?php echo "品牌情報"; ?></span></h3>
           			 <img src="images/line03.png" width="1200">
                    
					</div>
	
                </div>

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
				<a href="latest-news.php?id= <?php echo $row['id']; ?>"><img src="http://www.iwine.com.tw/webimages/symposium/<?php echo $row['pic_1']; ?>" width="250" height="193" border="0" title="更多新聞情報" ></a>
				</div>
				<div class="title">
				<?php echo($row["title"]); ?>
				</div>
			</div>
		</div>
		<?php
		//echo($row["Article"]);
		//echo("<br>");
		}
		?>
		
		
		</div>
		</div>          
        </div>
		</div>
		<div class="row">
                       <div class="span9" align="center">
                       <?php include('ad_content_bottom.php'); ?>
                       </div>
                    <!--<div  style="margin-left:30px;"class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>-->
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
<h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> <a href ="http://iwine.com.tw/symposium_list.php">品酒活動 </a></h4>
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
												
												<td ><a href="symposium.php?id=<?php echo  $symposium['id']; ?>" ><?php echo $display_date." ".$display_week; ?></a></td>
                                                 
												<td><a href="symposium.php?id=<?php echo  $symposium['id']; ?>" ><?php echo $symposium['title']; ?></a></td>
												
                                               </tr>
                                           <?php }; ?>
                                       <?php }; ?>
</table>						<!-- -->
                    </div>
                   <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
                    </div>
		</div>
        <!--div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
        
        <?php include('ad_content_right.php'); //這邊是友好連結?>
        
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