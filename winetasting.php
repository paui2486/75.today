<?php
session_start(); 
include('func/func.php');
?>
<?php require_once('Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title><?php echo $row_article['n_title']; ?> - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo substr_utf8(strip_tags($row_article['n_cont']),200) ;?>...">
    <meta name="author" content="">
    <meta property="og:title" content="<?php echo $row_article['n_title']; ?> -- 禁止酒駕．未滿18歲禁止飲酒">
	<meta property="og:site_name" content="iWine">
	<meta property="og:image" content="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>">
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
      <?php include('header.php'); ?>
      <ul class="nav nav-pills">
        <div id="nav_menu" class="navbar">
        
          <div class="navbar-inner">
            <div class="container-fluid">
              <?php include('mainmenu.php'); ?>
            </div>
          </div>
        </div>
      </ul>
      
      <div class="row">
        <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
              
                <ul class="breadcrumb">
  					<li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li><a href="article_class.php?pc_id=<?php echo $row_article['pc_id']; ?>"><?php echo $row_article['pc_name']; ?></a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $row_article['n_title']; ?></li>
				</ul>
              <div class="row" style="border:#000000 solid 0px; margin-left:0px; margin-bottom:10px">
           			<div class="span8">
                		<h2><img src="images/wine_icon1.png" width="35" height="35">品酒會活動</h2>
                        <img src="images/line03.png"><br>
</div>
                    
                    <div class="span1" style="float:left">
        <a href="#" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
          </div>
                    <div class="span7" style="float:left">
					<div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-width="320" data-show-faces="true" data-send="true" data-share="false"></div>					
                    </div>
                    
                  <div class="span8" style="padding:0px">
                    <?php if($row_article['n_fig1'] <> ""){ ?>
                    <div align="center" style="margin-top:20px"></div>
                    <p>
                      <?php } ?>
                    </p>
                   
<div>
 <h2 class="winetast_title">大衛潘的加州酒釀酒密技解剖【台北】
</h2>
</div>
<div class="article_txt" style="margin-top:20px; margin-bottom:50px">
 <img src="images/winetastepic.png" width="694" height="442">
<br>
<br>
你看過村上春樹的新書了嗎？<br>
&lt;沒有色彩的多崎作和他的巡禮之年&gt;村上的這本新書不但打破版權費的歷史紀錄，目前也持續蟬聯各大書店的排行榜。這次村上的新書是講述一個36歲痴迷於鐵路的工程師重新掌握自己人生的故事。作品描繪了主人公多崎作努力克服內心深處幽暗部分中的失落感與孤獨絕望，展現並歌頌了主人公的堅強。</p>
主人公多崎作在高中時代有幾個親密的好友，他們的姓氏中分別帶有「赤」(赤松慶)、「青」(青海悅夫)、「白」(白根柚木)、「黑」(黒埜恵里)，而「多崎」這個沒有色彩的名字令他感到一種「無法言喻的距離感」和不安，透過李斯特的作品&lt;巡禮之年&gt;，他踏上一場追尋過往的旅程。
<br><br>

<img src="images/pic03.png" width="191" height="191"><span class="article_txt" style="margin-top:20px; margin-bottom:50px"><span class="article_txt" style="margin-top:20px; margin-bottom:50px"><img src="images/pic02.png" width="191" height="191"></span></span><span class="article_txt" style="margin-top:20px; margin-bottom:50px"><img src="images/pic01.png" width="191" height="191"></span><span class="article_txt" style="margin-top:20px; margin-bottom:50px"><img src="images/pic03.png" width="191" height="191"></span></div>

<div style="margin-top:10px; margin-bottom:10px">
<h2 class="winetast_subtitle" ><img src="images/icon.png" width="16" height="22"> 講師</h2>
</div>
<div class="winetast_txt01" style="margin-top:10px; margin-bottom:10px">
   台灣之光釀酒師David
 </div>
 <div class="article_txt" style="margin-top:20px; margin-bottom:20px">
1999年Eric開始創立小酒館1999年Eric開始創立小酒館, 1999年Eric開始創立小酒館ic開始創立小酒館1999年Eric開始創立小酒館, 1999年Eric開始創立小酒館ic開始創立小酒館1999年Eric開始創立小酒館, 1999年Eric開始創立小酒館ic開始創立小酒館1999年Eric開始創立小酒館, 1999年Eric
 </div>
 
<div id="winetast_03">
   <p>&nbsp;</p>
   <div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22"> 活動時間</div>
   
<div id="winetast_02" class="article_txt">
  2013/12/15
</div>
<p>&nbsp;</p>

<div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22"> 活動地點</div>

<div id="winetast_02" class="article_txt">維納斯小酒館維納斯小酒館維納斯小酒館維納斯小酒館維納斯小酒館
</div>
   <p>&nbsp;</p>
   
<div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22"> 活動地址</div>

<div id="winetast_02" class="article_txt">台北市忠孝東路四段555號東路四段555號東路四段555號</div>
<p>&nbsp;</p>

<div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22">活動區域</div>

<div id="winetast_02" class="article_txt">台北市信義區</div>

<p>&nbsp;</p>
<div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22">活動費用</div>

<div id="winetast_02" class="article_txt">1500元</div>
<p>&nbsp;</p>

<div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22">主辦單位</div>

<div id="winetast_02" class="article_txt">iWine</div>
<p>&nbsp;</p>
<div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22">繳費期限</div>
  
<div id="winetast_02" class="article_txt">2013/10/01-2013/11/15</div>
<p>&nbsp;</p>

<div id="winetast_01" align="center" class="winetast_subtitle"><img src="images/icon.png" width="16" height="22">報名方式</div>

<div id="winetast_02" class="article_txt">請e-mail至test@yahoo.com.tw</div>

</div>

<div class="winetast_txt01">
  <p>&nbsp;</p>
  <img src="images/icon.png" width="16" height="22">酒單
</div>

<div class="article_txt" style="margin-top:20px; margin-bottom:20px">

  • Les Belles Collines 2009<br>
  • Les Belles Collines 2009旗艦款<br>
  • Les Belles Collines 2007 (醒酒12小時後)<br>
  • Les Belles Collines 2009 (醒酒12小時後)<br>
  • Les Belles Collines 2009旗艦款 (醒酒12小時後)</p>
</p>
</div>

</div>
</div> 
</div>
              
       
            
<div class="row">
<div class="span9">
<div align="center" style="padding:10px">
<input name="check_form" type="hidden" value="Y">
<button type="button" class="btn btn-danger" onClick="chkform();">馬上參加</button>
</div>
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="span12">
                      <h4><br>
                      <img src="images/wine_icon1.png" width="35" height="35"> <span class="title">更多品酒會：</span><br>
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
                    </div>
                    </div>
              
          </div>
          
          
        </div>
        <div class="row">
        <div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門排行</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門文章</h4>
           <div style="border:solid 1px #CCC; padding:10px; margin-bottom:10px">
        	<ul>
            	<?php do { ?>
           	    <li><a href="article.php?n_id=<?php echo $row_hot['n_id']; ?>"><?php echo $row_hot['n_title']; ?></a></li>
            	  <?php } while ($row_hot = mysql_fetch_assoc($hot)); ?>
            </ul>
            </div>
        </div>
        
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
        
        <?php include('ad_content_right.php'); ?>
        
     </div>
      </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php
mysql_free_result($article);

mysql_free_result($hot);
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
