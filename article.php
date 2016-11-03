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
 
$colname_article = "-1";
if (isset($_GET['n_id'])) {
  $colname_article = $_GET['n_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_article = sprintf("SELECT * FROM article LEFT JOIN article_class ON article.n_class = article_class.pc_id WHERE n_id = %s", GetSQLValueString($colname_article, "int"));
$article = mysql_query($query_article, $iwine) or die(mysql_error());
$row_article = mysql_fetch_assoc($article);
$totalRows_article = mysql_num_rows($article);

$a_id = $row_article['n_id'];
$a_class = $row_article['n_class'];
$a_address = $row_article['n_address'];;
$a_tel = $row_article['n_tel'];;

//
$page_count = $row_article['view_counter'] + 1;
$updateSQL = sprintf("UPDATE article SET view_counter = %s WHERE n_id = %s", $page_count, GetSQLValueString($a_id, "int"));
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

mysql_select_db($database_iwine, $iwine);
$query_other = "SELECT * FROM article WHERE n_class = '$a_class' AND n_id <> '$a_id' AND n_status= 'Y' ORDER BY RAND() LIMIT 3";
$other = mysql_query($query_other, $iwine) or die(mysql_error());
$row_other = mysql_fetch_assoc($other);
$totalRows_other = mysql_num_rows($other);

mysql_select_db($database_iwine, $iwine);
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);

mysql_select_db($database_iwine, $iwine);
$query_more_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 7";
$more_hot = mysql_query($query_more_hot, $iwine) or die(mysql_error());
$row_more_hot = mysql_fetch_assoc($more_hot);
$totalRows_more_hot = mysql_num_rows($more_hot);
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
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title><?php echo $row_article['n_title']; ?> 75.today 今日奇聞 奇文共賞</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo substr_utf8(strip_tags($row_article['n_description']),200) ;?>...">
    <meta name="keyword" content="<?php echo substr_utf8(strip_tags($row_article['n_keyword']),200) ;?>...">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $row_article['n_title']; ?> -- 75.today 今日奇聞 奇文共賞">
    <meta property="og:site_name" content="75.today">
    <meta property="og:image" content="http://75.today/admin/webimages/article/<?php echo $row_article['n_fig1']; ?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?php echo $row_article['n_description'];?>">
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
    
    <link rel="shortcut icon" href="assets/ico/123.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <style>
    .draqtest{
        color: #FF3366;
        position: fixed;
        left:0%;
        bottom:0%;
        width: 200px;
        background-color: #000;
        padding: 10px;
        visibility: hidden;
    }
    </style>
    <script>
    $(document).ready(function(){
        $(document).scroll(function(){
            // alert(2);   
            var mouse_position = $('body').scrollTop();
            var doc_height = $( document ).height();
            var right_position = $('#hot_position').offset().left;
            var display_position = right_position-30;
            var w_height = $( window ).height();
            var w_width = $( window ).width();
            if($( window ).width() < 1100){
                $("#fixed_right_ad").css("visibility", "hidden");
            }else{
                if (mouse_position > 1300){
                    $("#fixed_right_ad").css("visibility", "visible");
                }else{
                    $("#fixed_right_ad").css("visibility", "hidden");
                }
                if(doc_height - mouse_position < 1050){
                   $("#fixed_right_ad").css("bottom", "160px");
                }else{
                    $("#fixed_right_ad").css("bottom", "0px");
                }
            }
            $('#display_x').html(mouse_position);
            $('#hot_height').html(right_position);
            $('#display_position').html(display_position);
            $('#w_width').html(w_width);
            $('#w_height').html(w_height);
            $('#d_height').html(doc_height);
            $("#fixed_right_ad").css("left", display_position);
            // $('#fixed_right_ad').css({position: fixed; left:display_position px; bottom:20px;})
           
        })
    })
        
    </script>
  </head>
  <body>
  
  <div class="draqtest">
      draq 測試專區<br>
      x: <span id="display_x">display_x</span><br>
      right_position: <span id="hot_height">right_position</span><br>
      display_position: <span id="display_position">display_position</span><br>
      windows width: <span id="w_width">windows width</span><br>
      windows hight: <span id="w_height">windows hight</span><br>
      document hight: <span id="d_height">document hight</span><br>
  </div>
      
  <!--<div id="fixed_right_ad">
    <div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30">推薦文章</h4>
           <div class="span3 hot_article" id="hot_article">
           <?php do{ ?>
            <div class="span3 each_hot_article" >
                <a href="/article.php?n_id=<?php echo $row_more_hot['n_id']; ?>">
                <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_more_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                </a>
                <a href="/article.php?n_id=<?php echo $row_more_hot['n_id']; ?>" style="margin-top:10px;">
                <?php echo $row_more_hot['n_title']; ?>
                </a>
            </div>
           <?php } while ($row_more_hot = mysql_fetch_assoc($more_hot));?>
            </div>
        </div>
        <div>
    <?php include('ad_7.php'); ?>
    </div>
  </div>-->
      

  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&appId=486129248130860&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php include('mainmenu.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
        <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
              
                <ul class="breadcrumb">
                    <li><a href="index.php" class="home">首頁</a> <span class="divider">/</span></li>
                    <li><a href="article_class.php?pc_id=<?php echo $row_article['pc_id']; ?>" class="expert_h2"><?php echo $row_article['pc_name']; ?></a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $row_article['n_title']; ?></li>
                </ul>
                <div class="row" style="border:#000000 solid 0px; margin-left:0px; margin-bottom:10px">
                    <div class="span8">
                        <h2><img src="images/wine_icon1.png" width="35" height="35"> <span class="title"><?php echo $row_article['n_title']; ?></span></h2>
                        <span class="view_counter"><?php echo number_format($row_article['view_counter']); ?> 人次點閱</span>
                        <img src="images/line03.png"><br>
                    </div>
                    <?php if ($row_article['n_socialnum'] == 1 ){ include('sharewithnumbers.php'); } else{ include('sharewithoutnumbers.php');} ?>
                    
                    


<div style="clear:both;"></div>








                    <div class="span8" style="padding:0px">
                    <?php if($row_article['n_fig1'] <> ""){ ?>
                    <div align="center" style="margin-top:20px"></div>
                    <?php } ?>
                    
                    <div class="article_txt" style="margin-top:20px; margin-bottom:50px">
                    <?php echo $row_article['n_cont']; ?>
                    </div>
					
					<!--<div ><!--地圖>店名>電話 開始 風格保存class="article_txt" style="margin-top:20px; margin-bottom:50px"-->
					<??>
						<!--<a href="https://maps.google.com?daddr={{ <?php echo $row_article['n_address']; ?> }}" target="_blank"><!-- 偷吃步 -->
						<!--<div class="dashboard-block">
							<img src="../web/images/where05.jpg" width="125" height="125">
							<div class="dashboard-text">
							<p><?php echo $row_article['n_address']; ?></p>
							
							</div>
						</div>
						</a>
					</div><!--地圖>店名>電話 結束-->
					
					<div class="article_txt" style="margin-top:20px; margin-bottom:50px">
                    <p><?php echo $row_article['n_shop']; ?></p>
					<p><?php echo $row_article['n_tel']; ?></p>
                    </div>
					<!--
                    <div style="font-size:130% !important; margin-bottom:20px;">未滿十八歲者，禁止飲酒</div>
                    <div style="font-size:130% !important; margin-bottom:20px;">iWine 貼心提醒您：禁止酒駕，安全有保障！</div>-->
					<div style="font-size:130% !important; margin-bottom:20px;">
					
					<br>&nbsp;<br>
					若分享內容有侵害您的圖片版權，請來信留言告知，我們會及時加上版權信息，若是您反對使用，<br>
					本著對版權人尊重的原則，會儘速移除相關內容 。 聯絡信箱：<a href ="mailto:service@75.today">service@75.today</a><!--超連結自動開起信箱-->
					<br>&nbsp;<br>
					
					</div>
                    </div>
                    
                    <!--div class="span1" style="float:left">
                        <a href="#" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                    </div>
                    <div class="span7" style=" float:left">
                    <div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-width="320" data-show-faces="true" data-send="true" data-layout="standard" data-share="false"></div>                 
                    </div-->
                    
        <?php if ($row_article['n_socialnum'] == 1 ){ include('sharewithnumbers.php'); } else{ include('sharewithoutnumbers.php');} ?>
                    

<div style="clear:both;"></div>
 
                    </div>
                    
              
            </div>        
            
            <div class="row">
          <div class="span9">
                    <!--div align="center" style="padding:10px">
                    <a class="btn btn-warning" href="article_class.php?pc_id=<?php echo $row_article['pc_id']; ?>"><i class="icon-arrow-left icon-white"></i> 更多 <?php echo $row_article['pc_name']; ?> </a>
                    </div>-->
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span12">
                      <h4><br>
                      <img src="images/wine_icon1.png" width="35" height="35"> <span class="title">其他粉粉也看了這些奇文：</span><br>
                      </h4>
                      <?php do { ?>
                      <div class="span3">
                        <div style="border:solid 0px #000000; margin-bottom:20px;">
                          <div style="height:199px; overflow:hidden"> <a href="article.php?n_id=<?php echo $row_other['n_id']; ?>" > <img src="http://75.today/admin/webimages/article/<?php echo $row_other['n_fig1']; ?>" alt="<?php echo $row_other['n_title']; ?>" > </a> </div>
                          <div style="height:30px">
                            <h5><a href="article.php?n_id=<?php echo $row_other['n_id']; ?>"><?php echo $row_other['n_title']; ?></a></h5>
                            <img src="images/article_line.png"> </div>
                        </div>
                      </div>
                      <?php } while ($row_other = mysql_fetch_assoc($other)); ?>

                     
<p>&nbsp;</p>

<div class="span8" style="padding:0px">
      <h4>&nbsp;</h4>
<?php// include('ad_content_bottom.php'); ?> 
      <h4>&nbsp;</h4>
</div>
         

                    </div>
                    </div>
                    
                    <!--<div class="row">
                    <div class="span9" style="border:solid 0px #000000; margin-bottom:10px">
                    <div style="padding:10px; background-image:url(images/bg2.png)">
                    <img src="images/guest.png" width="140" height="30">
                    </div>
                    <div align="center" style="padding:10px">
                    <div class="fb-comments" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>"></div>
                    </div>
                    
                    <!--<div  style="margin-left:30px;"class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
                    </div>
                    </div>-->
              
          </div>
          
          
        </div>
        <div class="row">
        <!--<div class="span3" align="center"  id="hot_position">
           <h4 align="left"><img src="images/wine_icon4.png" width="30" height="30"> iWine 排行榜 </h4>
            <?php// include('ad_1.php'); ?>
        </div>-->
        
                
        <!--<div class="span3" >
<h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> <a href ="http://iwine.com.tw/symposium_list.php">攔轎上稿 </a></h4>
<div class="span3 hot_article" id="hot_article">
<?php do{ ?>
<div  > <!-- 小心class 的影響 -->
<!--					
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
                                               
                                                <!-- <td class="passed_item"><?php echo $symposium['title']; ?> <!--a href="symposium.php?id=<?php //echo $symposium['id']; ?>">詳情</a--></td>
                                                <!-- <td class="passed_item">
                                                    <?php  echo $display_date." ".$display_week; ?>
                                                 </td>
                                                 <td class="passed_item"><?php echo $symposium['area']; ?></td>
                                                 <!--td align="left" class="passed_item"><?php //echo $symposium['address']; ?></td-->
                                                <!-- <td class="passed_item">已截止</td>
                                               </tr>
                                           <?php }else{ ?><!-- 上面是活動時間已截止 以下這邊是活動列表 $symposium['id']活動ID $symposium['title']活動名稱-->
                                                <!--<tr class="symposium_table"  valign="top">
												
												<td ><?php echo $display_date." ".$display_week; ?></td>
                                                <td><a href="symposium.php?id=<?php echo  $symposium['id']; ?>" ><?php echo $symposium['area']; ?></a></td> 
												<td><a href="symposium.php?id=<?php echo  $symposium['id']; ?>" ><?php echo substr_utf8(strip_tags($symposium['title']),40); ?></a></td>
												
                                               </tr>
                                           <?php }; ?>
                                       <?php }; ?>
</table>						
                    </div>
                   <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
                    </div>
		</div> -->
        
        <!--div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
        
        <?php //include('ad_content_right.php'); ?>
        
        
        
     </div>
      </div>
      
      
      
      <div class="row">
      
      </div>
    </div>
    <?php //include('footer.php'); ?>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script-->
    <script src="assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php
mysql_free_result($article);
mysql_free_result($other);
mysql_free_result($Result1);
mysql_free_result($hot);
mysql_free_result($more_hot);
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
