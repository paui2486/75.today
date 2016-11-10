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

mysql_select_db($database_iwine, $iwine);//最新文章
$query_newest_article = "SELECT * FROM article WHERE n_status = 'Y' ORDER BY n_id DESC LIMIT 12";
$newest_article = mysql_query($query_newest_article, $iwine) or die(mysql_error());
$row_newest_article = mysql_fetch_assoc($newest_article);
$totalRows_newest_article = mysql_num_rows($newest_article);



mysql_select_db($database_iwine, $iwine);//最熱文章
$query_hotest_article = "SELECT * FROM article WHERE n_status = 'Y' AND n_hot ='Y' ORDER BY RAND() LIMIT 12";
$hotest_article = mysql_query($query_hotest_article, $iwine) or die(mysql_error());
$row_hotest_article = mysql_fetch_assoc($hotest_article);
$totalRows_hotest_article = mysql_num_rows($hotest_article);


////
mysql_select_db($database_iwine, $iwine);//最熱專家
$query_hotest_expert = "SELECT * FROM expert_article WHERE n_id > 130 and n_status = 'Y' AND n_hot ='Y' ORDER BY RAND() LIMIT 0";
$hotest_expert = mysql_query($query_hotest_expert, $iwine) or die(mysql_error());
$row_hotest_expert = mysql_fetch_assoc($hotest_expert);
$totalRows_hotest_expert = mysql_num_rows($hotest_expert);
////

mysql_select_db($database_iwine, $iwine);//banner 所需要的前置資料
$query_index_fig = "SELECT * FROM index_fig WHERE b_status = 'Y' ORDER BY b_order ASC";
$index_fig = mysql_query($query_index_fig, $iwine) or die(mysql_error());
$row_index_fig = mysql_fetch_assoc($index_fig);
$totalRows_index_fig = mysql_num_rows($index_fig);

mysql_select_db($database_iwine, $iwine);//從DB選擇顯示狀態為顯示且為最新文章10則
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);
//品酒活動 所需要的前置資料 開始
$_today = date('Y-m-d H:i:s'); 
$maxRows_symposium = 10;//首頁顯示 品酒活動 最大數量
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
    <title>˙75今日奇聞 </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="ldciUWlDvibIj3ny2qU9ioxmEedndTTM-rsVUpx2K1I" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="description" content="75.today 奇文共賞 神奇的事情發生在這裡 跟著75.today我們出發吧！">
    <meta name="author" content="">
    <meta property="og:title" content="首頁 - 75.today 奇文共賞 神奇的事情發生在這裡">
    <meta property="og:site_name" content="75.today">
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
    
    <link rel="shortcut icon" href="assets/ico/j5.svg">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <style>
#Z1 {
position:relative;top:-1px;
z-index:1;
}
#Z2 {
position:absolute;top:15px;right:17px;
z-index:2;	
}
    </style>
   
  </head>
  <body>
  <?php include_once("analyticstracking.php") ?>
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=540353706035158";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php 


function emjoi($x){
	if($x == "1"){
		$x = "靠.svg";
		return $x;
	}elseif($x == "2"){
		$x = "瞎.svg";
		return $x;
	}elseif($x == "3"){
		$x = "扯.svg";
		return $x;
	}elseif($x == "4"){
		$x = "萌.svg";
		return $x;
	}elseif($x == "5"){
		$x = "幹.svg";
		return $x;
	}else{}
				}
				


?>

 <?php include('mainmenu.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area"><!-- 這邊area拿掉 iwine排行跟友好 會被移到下方-->
	  <div class="span12" style="margin-top:10px" align="center"><!-- 上邊緣留白 預設值 這邊可以設定banner致中-->
	  <div class="row-fluid"><!--  -->
            <!--<div class="span12"> <!--  -->
                <!--<div id="myCarousel" class="carousel slide"><!--banner star-->
                    <!--<ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li><!--預設的-->
                        <!--<li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
            <!-- Carousel items -->
                    <!--<div class="carousel-inner">
                        <?php $i=1; ?>
                        <?php do { ?>
                        <div class="<?php if($i==1){ ?>active <?php } ?>item"><a href="<?php echo $row_index_fig['b_url']; ?>"><img src="http://75.today/admin/webimages/index/<?php echo $row_index_fig['b_file']; ?>"></a>
                            <?php if($row_index_fig['b_name'] <>""){ ?>
                            <div class="carousel-caption">                            
                              <h4><?php echo $row_index_fig['b_name']; ?></h4>
                            <?php } ?>
                            <?php if($row_index_fig['b_subname'] <> ""){ ?>
                           <?php echo $row_index_fig['b_subname']; ?>            
                              </div>
                              <?php } ?>
                          </div>
                          <?php $i++; ?>
                          <?php } while ($row_index_fig = mysql_fetch_assoc($index_fig)); ?>
                    </div>
            <!-- Carousel nav -->
                    <!--<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>-->
                    <!--<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>-->
					
                <!--</div><!--banner end-->
            <!--</div>-->
            </div>
	  </div>
        <div class="span9" >
          
			<!-- 品酒活動區塊開始 -->
			<!--<div class="each_list">
			<table  border="0" align="center">
			<td align="center" width="1022"><h1><a href ="http://iwine.com.tw/symposium_list.php">品酒活動</a></h1></td><!--background="images/bg2.png"-->
			<!--</table>
			<img src="images/menu_line.png">
                                <?php if($total_symposium > 0) {?>
                                    <table width="100%" height="145"  border="0" >
									<!--background="images/bg2.png"-->
									   <!--<tr align="left">
                                         <th width="55" >&nbsp;</th><!--background="images/bg2.png"-->
                                         <!--<th width="232" >活動主題 </th><!--background="images/bg2.png"-->
                                         <!--<th width="93" >日期</th><!--background="images/bg2.png"-->
                                         <!--<th width="78" >區域</th><!--background="images/bg2.png"-->
                                         <!--th width="236" background="images/bg2.png">地址</th-->
                                         <!--<th width="53"  > 報名狀態</th><!--background="images/bg2.png"-->
                                       <!--</tr>
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
                                               <!--<td class="passed_item"><img src="../web/webimages/symposium/<?php //echo $symposium['pic1']?>" style="max-width:100%"></td>-->
                                                 <!--<td class="passed_item"><?php echo $symposium['title']; ?> <!--a href="symposium.php?id=<?php //echo $symposium['id']; ?>">詳情</a--></td>
                                                 <!--<td class="passed_item">
                                                    <?php  echo $display_date." ".$display_week; ?>
                                                 </td>
                                                 <td class="passed_item"><?php echo $symposium['area']; ?></td>
                                                 <!--td align="left" class="passed_item"><?php //echo $symposium['address']; ?></td-->
                                                 <!--<td class="passed_item">已截止</td>
                                               </tr>
                                           <?php }else{ ?><!-- 上面是活動時間已截止 以下這邊是活動列表 $symposium['id']活動ID $symposium['title']活動名稱-->
                                                <!--<tr class="symposium_table"  valign="top">
                                  
                                  <td><span class="passed_item"><a href="symposium.php?id=<?php echo $symposium['id']; ?>"><img src="images/icon_note.jpg" style="max-width:100%"></a></span></td>
                                                     <td><a href="symposium.php?id=<?php echo $symposium['id']; ?>"><?php echo $symposium['title']; ?></a></td>
                                                     <td>
                                                        <?php echo $display_date." ".$display_week; ?>
                                                     </td>
                                                     <td><?php echo $symposium['area']; ?></td><!--活動地點-->
                                                     <!--td align="left" ><?php //echo $symposium['address']; ?></td-->
                                                     <!--<td ><?php if($symposium['available']==0) {echo "<font color=#D0085B>已額滿</font>";} else {echo "歡迎報名";} ?></td><!--是否可以報名-->
                                               <!--</tr>
                                           <?php }; ?>
                                       
                                       <?php }; ?>
									   
                                     </table>
									 
									 <div> <?php echo ('<BR>')?></div><td align="center" width="1022"><h1>
									 <div align="center"><input type="button" value="更多活動" onclick="location.href='http://iwine.com.tw/symposium_list.php'">&nbsp;&nbsp;&nbsp;&nbsp;<a href="symposium_upload_simple.php">品酒活動上傳</a></div>
									 <div class="title_uploadimg">
										
									</div>
                                <?php }else{ echo " <TABLE><TR><TD STYLE='HEIGHT:100PX;'>暫無資訊，敬請期待！ </TD></TR></TABLE>"; } ?>
                            </div>
			<!-- 品酒活動區塊結束 -->
            <div class="row"><!-- 文章區塊 -->
            <div class="span9">
                <ul class="nav nav-tabs" style="margin:0 0 0 0px">
                    <li><a href="#tab1" data-toggle="tab">熱門奇聞</a></li>
                    <li class="active"><a href="#tab2" data-toggle="tab">最新奇聞</a></li><!--將 預設位置熱門奇聞轉成最新奇聞-->
                    <img src="images/menu_line.png">
                </ul>
                
                <div class="tab-content" style="padding-top:5px; margin-bottom:10px;">
                    <div class="tab-pane" id="tab1">
						<div class="row">
                        <div class="span9">
                        <div class="row">
                        
<?php if ($totalRows_hotest_expert > 0) { // Show if recordset not empty ?>    
      <?php do { ?>
        <div class="span3">
          <div style="margin-bottom:5px; padding:5px;">
            <div id="Z1" style="height:145px; overflow:hidden"> <a href="expert_article.php?n_id=<?php echo $row_hotest_expert['n_id']; ?>" > <img src="http://75.today/admin/webimages/article/<?php echo $row_hotest_expert['n_fig1']; ?>" alt="<?php echo $row_hotest_expert['n_title']; ?>"> </a> 
			<?php if($x > 0){ echo('<div id="Z2"><img src="http://75.today/web/webimages/'.emjoi($x).'" alt="'.emjoi($x).'"></div>'); }else{ } ?>
			</div>
			<div style="height:50px; overflow:hidden">
              <h5><a href="expert_article.php?n_id=<?php echo $row_hotest_expert['n_id']; ?>"><?php echo $row_hotest_expert['n_title']; ?></a><br>
                </h5>
            </div>
            <!-- fb share, view_counter-->
            <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.75.today/web/expert_article.php?n_id=<?php echo $row_hotest_expert['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/FB.svg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; vertical-align:bottom; margin-top:1px;">
                <?php echo number_format($row_hotest_expert['view_counter']); ?> 人次點閱
                </div>
            </div>
        
            <img src="images/article_line.png">
            </div>
          </div>
        <?php } while ($row_hotest_expert = mysql_fetch_assoc($hotest_expert)); ?>
  <?php } ?>                        
                        
                    <?php if ($totalRows_hotest_article > 0) { // Show if recordset not empty ?>    
      <?php do { ?>
        <div class="span3">
          <div style="margin-bottom:5px; padding:5px;">
            <div id="Z1" style="height:145px; overflow:hidden"> <a href="article.php?n_id=<?php echo $row_hotest_article['n_id']; ?>" > <img src="http://75.today/admin/webimages/article/<?php echo $row_hotest_article['n_fig1']; ?>" alt="<?php echo $row_hotest_article['n_title']; ?>"> </a> 
			<?php $x = $row_hotest_article['n_switchX']; if($x > 0){ echo('<div id="Z2"><img src="http://75.today/web/webimages/'.emjoi($x).'" alt="'.emjoi($x).'"></div>'); }else{ } ?>
			</div>
			<div style="height:50px; overflow:hidden">
              <h5><a href="article.php?n_id=<?php echo $row_hotest_article['n_id']; ?>"><?php echo $row_hotest_article['n_title']; ?></a><br>
                </h5>
            </div>
            <!-- fb share, view_counter-->
            <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.75.today/web/article.php?n_id=<?php echo $row_hotest_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/FB.svg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; vertical-align:bottom;margin-top:1px;">
                <?php echo number_format($row_hotest_article['view_counter']); ?> 人次點閱
                </div>
            </div>
            
            <img src="images/article_line.png">
            </div>
          </div>
        <?php } while ($row_hotest_article = mysql_fetch_assoc($hotest_article)); ?>
  <?php } ?>
                    </div>
                    </div>
                    </div>
                    </div>
                    <div class="tab-pane active" id="tab2">
                        <div class="row">
                        <div class="span9">
                        <div class="row">
                    
                    
                    
                    <?php if ($totalRows_newest_expert > 0) { // Show if recordset not empty ?>    
      <?php do { ?>
        <div class="span3">
          <div style="margin-bottom:5px; padding:5px;">
            <div id="Z1" style="height:145px; overflow:hidden"> <a href="expert_article.php?n_id=<?php echo $row_newest_expert['n_id']; ?>" > <img src="http://75.today/admin/webimages/article/<?php echo $row_newest_expert['n_fig1']; ?>" alt="<?php echo $row_newest_expert['n_title']; ?>"> </a> 
            <?php if($x > 0){ echo('<div id="Z2"><img src="http://75.today/web/webimages/'.emjoi($x).'" alt="'.emjoi($x).'"></div>'); }else{ } ?>
			</div>
			<div style="height:50px; overflow:hidden">
              <h5><a href="expert_article.php?n_id=<?php echo $row_newest_expert['n_id']; ?>"><?php echo $row_newest_expert['n_title']; ?></a><br>
                </h5>
            </div>
            <!-- fb share, view_counter-->
            <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.75.today/web/expert_article.php?n_id=<?php echo $row_newest_expert['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/FB.svg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; vertical-align:bottom; margin-top:1px;">
                <?php echo number_format($row_newest_expert['view_counter']); ?> 人次點閱
                </div>
            </div>
            <img src="images/article_line.png">
			<!--<img src="images/menu_line.png">-->
            </div>
          </div>
        <?php } while ($row_newest_expert = mysql_fetch_assoc($newest_expert)); ?>
  <?php } ?>  
                    
                    
                    
                    
                    
                    
                    
                    <?php if ($totalRows_newest_article > 0) { // Show if recordset not empty ?>    
      <?php do { ?>    
        <div class="span3">
        <div style="border:solid 0px #000000; margin-bottom:5px; padding:5px">
        <div id="Z1" style="height:145px; overflow:hidden">
        <a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>" >
        <img src="http://75.today/admin/webimages/article/<?php echo $row_newest_article['n_fig1']; ?>" alt="<?php echo $row_newest_article['n_title']; ?>">
        </a>
		<?php $x = $row_newest_article['n_switchX']; if($x > 0){ echo('<div id="Z2"><img src="http://75.today/web/webimages/'.emjoi($x).'" alt="'.emjoi($x).'"></div>'); }else{ } ?>
        </div>
		
        <div style="height:50px; overflow:hidden">
          <h5><a href="article.php?n_id=<?php echo $row_newest_article['n_id']; ?>"><?php echo $row_newest_article['n_title']; ?></a></br>  
          </h5>
        </div>
        <div style="display:inline-block; z-index: 9999; overflow:hidden; height:20px;">
                <div style="float:left; ">
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.75.today/web/article.php?n_id=<?php echo $row_newest_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/FB.svg"></a>
                </div>
                <div style="float:left;padding-left:5px; z-index: 999; color:#949494; margin-top:1px;">
                <?php echo number_format($row_newest_article['view_counter']); ?> 人次點閱
                </div>
        </div><!---->
       
           <img src="images/article_line.png">
		   <!--<img width="600" src="images/menu_line.png">-->
          </div>
          </div>              
        <?php } while ($row_newest_article = mysql_fetch_assoc($newest_article)); ?>
  <?php } ?>
                    </div>
                    </div>
                    </div>
                    </div>
                                
                </div>
             </div>
             </div>       
			<div align="center"><input type="button" value="更多奇聞" onclick="location.href='http://75.today/web/article_class.php?pc_id=27'"></div>
			<br>
			<!--<div><img src="webimages/靠.svg"><img src="webimages/扯.svg"><img src="webimages/萌.svg"><img src="webimages/瞎.svg"></div>-->
<!--<div class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>-->

             
        </div>
        
     <div class="row">
				<?php// include('ad_content_right.php'); ?>
                <div class="span3">
					<br><br><br><br>
                   <!--<h4 align="left"><img src="images/wine_icon4.png" width="30" height="30"> iWine 排行榜 </h4>-->
                    <?php// include('ad_1.php'); //?>
                </div>
                
			</div>	
       
  
       </div> 
       
       <div class="row">
       <div class="span9" align="center">
       <?php// include('ad_index_bottom.php'); //底部圖?>
       </div>
       </div>
    </div>
    <?php// include('footer.php'); ?>
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
