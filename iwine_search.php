<?php
session_start(); 
include('func/func.php');
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
    <title> 站內搜尋 - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="站內搜尋 - iWine">
    <meta name="author" content="">
    <meta property="og:title" content="站內搜尋 - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
    <meta property="og:site_name" content="iWine">
    <meta property="og:image" content="">
    <meta property="og:type" content="website">
    <meta property="fb:admins" content="1685560618"/>
    <meta property="fb:app_id" content="540353706035158">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="style_article.css" rel="stylesheet">
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
    .gsc-input-box {
        height: 35px !important;
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
           
        });
        // function getUrlParam(name){
            // var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); 
            // var r = window.location.search.substr(1).match(reg);  
            // if (r!=null) return unescape(r[2]); return null; 
        // } 
        // var myquery = getUrlParam('query');
        // alert(myquery);
    });
        
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
                    <li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li class="active">站內搜尋</li>
                </ul>
                <div class="row" style="border:#000000 solid 0px; margin-left:0px; margin-bottom:10px">
                    <div class="span8">
                        <h2><img src="images/wine_icon1.png" width="35" height="35"> <span class="title">iWine 搜尋</span></h2>
                        
                        <img src="images/line03.png"><br>
                    </div>
                    <div class="span9" style="min-height:1200px;">
                    <div class="g_search">
                    <script>
                      (function() {
                        var cx = '004903521599375321366:gx4vjtvxvb4';
                        var gcse = document.createElement('script');
                        gcse.type = 'text/javascript';
                        gcse.async = true;
                        gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                            '//www.google.com/cse/cse.js?cx=' + cx;
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(gcse, s);
                      })();
                    </script>
                    <gcse:search></gcse:search>
                    </div>
                    </div>
                    
                </div>
            </div>        
          </div>
          
          
        </div>
        <div class="row">
            <div class="span3" align="center"  id="hot_position">
               <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine 排行榜 </h4>
                <?php include('ad_1.php'); ?>
            </div>
        
                
            <div class="span3">
               <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門文章 </h4>
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
            <?php include('ad_content_right.php'); ?>
        </div>
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
