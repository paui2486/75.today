<?php
session_start(); 
include('func/func.php');
$cur_url = curPageURL();

?>
<?php require_once('Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
      if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }

      $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

      switch ($theType) {
        case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";  break;    
        case "long":
        case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
        case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
        case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
        case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
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
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title><?php echo $row_article['n_title']; ?> - iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo substr_utf8(strip_tags($row_article['n_description']),200) ;?>...">
    <meta name="keyword" content="<?php echo substr_utf8(strip_tags($row_article['n_keyword']),200) ;?>...">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $row_article['n_title']; ?>">
    <meta property="og:site_name" content="iWine">
    <meta property="og:image" content="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>">
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
    
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
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
      
  <div id="fixed_right_ad">
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
  </div>
      

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
                    
                    
                    
<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden;">


    <!-- FB fanpage like-start -->
    <div style="float:left; width:0px;">
        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
      <!-- FB fanpage like-end -->
    
    <!-- G+ share button-start -->
    <div style="float:left; padding-left:0px;">
        <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
    </div>
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
    

    <!-- current page fb like-start -->
    <div style="float:left; padding-left:10px; width:60px;">
        <div class="fb-like" data-href="http://www.iwine.com.tw<?php echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-action="recommend" data-show-faces="true" data-share="false"></div>
    </div>
    
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
                <a href="http://line.naver.jp/R/msg/text/?<? echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/symposium.php?id=<?php echo $row_article['id']; ?>"><img src="images/linebutton_20x20.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->
    
    
    <!-- plurk share -->
    <div style="float:left; padding-left:10px; height:70px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>
       <!-- plurk share-end -->
    
    
    <!-- weibo-start -->
    <div style="float:left; padding-left:10px; padding-right:10px; height:70px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $row_article['title']; ?>&url=<?php echo $cur_url;?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>
        <!-- weibo-end -->
    
    
    <!-- Twitter-start -->
    <div style="float:left;">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="zh-tw" data-size="large" data-count="true" data-dnt="true" title="推到我的 Twitter">推文</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
        <!-- Twitter-end -->
    
    
    </div>
    
<!-- share-end--> 

<div style="clear:both;"></div>








                    <div class="span8" style="padding:0px">
                    <?php if($row_article['n_fig1'] <> ""){ ?>
                    <div align="center" style="margin-top:20px"></div>
                    <?php } ?>
                    
                    <div class="article_txt" style="margin-top:20px; margin-bottom:50px">
                    <?php echo $row_article['n_cont']; ?>
                    </div>
                    <div style="font-size:130% !important; margin-bottom:20px;">未滿十八歲者，禁止飲酒</div>
                    <div style="font-size:130% !important; margin-bottom:20px;">iWine 貼心提醒您：禁止酒駕，安全有保障！</div>
                    </div>
                    
                    <!--div class="span1" style="float:left">
                        <a href="#" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
                    </div>
                    <div class="span7" style=" float:left">
                    <div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-width="320" data-show-faces="true" data-send="true" data-layout="standard" data-share="false"></div>                 
                    </div-->
                    
                    
                    
<!-- share-start -->                    
<div class="span8" style="display: block; overflow:hidden;">


    <!-- FB fanpage like-start -->
    <div style="float:left; width:0px;">
        <div class="fb-like" data-href="https://www.facebook.com/iwine" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
      <!-- FB fanpage like-end -->
    
    <!-- G+ share button-start -->
    <div style="float:left; padding-left:0px;">
        <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
    </div>
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
    

    <!-- current page fb like-start -->
    <div style="float:left; padding-left:10px; width:60px;">
        <div class="fb-like" data-href="http://www.iwine.com.tw<?php echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-action="recommend" data-show-faces="true" data-share="false"></div>
    </div>
    
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
                <a href="http://line.naver.jp/R/msg/text/?<? echo $row_article['title']; ?>：<?php echo $row_article['title'] ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.tw/symposium.php?id=<?php echo $row_article['id']; ?>"><img src="images/linebutton_20x20.png"></a>
                </div>
    <?php } ?> 
        <!-- current page fb like-end -->
    
    
    <!-- plurk share -->
    <div style="float:left; padding-left:10px; height:70px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>
       <!-- plurk share-end -->
    
    
    <!-- weibo-start -->
    <div style="float:left; padding-left:10px; padding-right:10px; height:70px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $row_article['title']; ?>&url=http%3a%2f%2fwww.iwine.com.tw%2fsymposium.php%3fn_id%3d<?php echo $row_article['id'];?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>
        <!-- weibo-end -->
    
    
    <!-- Twitter-start -->
    <div style="float:left;">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="zh-tw" data-size="large" data-count="true" data-dnt="true" title="推到我的 Twitter">推文</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
        <!-- Twitter-end -->
    
    
    </div>
    
<!-- share-end--> 



<div style="clear:both;"></div>
                    
                    
                    
                    
                    
                    
                    </div>
                    
              
            </div>        
            
            <div class="row">
          <div class="span9">
                    <!--div align="center" style="padding:10px">
                    <a class="btn btn-warning" href="article_class.php?pc_id=<?php echo $row_article['pc_id']; ?>"><i class="icon-arrow-left icon-white"></i> 更多 <?php echo $row_article['pc_name']; ?> </a>
                    </div-->
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span12">
                      <h4><br>
                      <img src="images/wine_icon1.png" width="35" height="35"> <span class="title">其他人也看了這些文章：</span><br>
                      </h4>
                      <?php do { ?>
                      <div class="span3">
                        <div style="border:solid 0px #000000; margin-bottom:20px;">
                          <div style="height:199px; overflow:hidden"> <a href="article.php?n_id=<?php echo $row_other['n_id']; ?>" > <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_other['n_fig1']; ?>" alt="<?php echo $row_other['n_title']; ?>" > </a> </div>
                          <div style="height:30px">
                            <h5><a href="article.php?n_id=<?php echo $row_other['n_id']; ?>"><?php echo $row_other['n_title']; ?></a></h5>
                            <img src="images/article_line.png"> </div>
                        </div>
                      </div>
                      <?php } while ($row_other = mysql_fetch_assoc($other)); ?>

                     
<p>&nbsp;</p>

<div class="span8" style="padding:0px">
      <h4>&nbsp;</h4>
<?php include('ad_content_bottom.php'); ?> 
      <h4>&nbsp;</h4>
</div>
         

                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span9" style="border:solid 0px #000000; margin-bottom:10px">
                    <div style="padding:10px; background-image:url(images/bg2.png)">
                    <img src="images/guest.png" width="140" height="30">
                    </div>
                    <div align="center" style="padding:10px">
                    <div class="fb-comments" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>"></div>
                    </div>
                    
                    <div  style="margin-left:30px;"class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
                    </div>
                    </div>
              
          </div>
          
          
        </div>
        <div class="row">
        <div class="span3" align="center"  id="hot_position">
           <h4 align="left"><img src="images/wine_icon4.png" width="30" height="30"> iWine 排行榜 </h4>
            <?php include('ad_1.php'); ?>
        </div>
        
                
        <div class="span3">
           <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 熱門文章 </h4>
           <div class="span3 hot_article" id="hot_article">
           <?php do{ ?>
            <div class="span3 each_hot_article" >
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>">
                <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                </a>
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>" style="margin-top:10px;">
                <?php echo $row_hot['n_title']; ?>
                </a>
            </div>
           <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
            </div>
        </div>
        
        <!--div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
        
        <?php include('ad_content_right.php'); ?>
        
        
        
     </div>
      </div>
      
      
      
      <div class="row">
      
      </div>
    </div>
    <?php include('footer.php'); ?>
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
