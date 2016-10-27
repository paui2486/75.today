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

if(isset($_GET['page'])){
$_start = ($_GET['page'] * 12) - 12;
$i = $_GET['page'] + 1;
}else{
$_start = 0;
$i = 1;
}

mysql_select_db($database_iwine, $iwine);
$query_article = "SELECT * FROM article ORDER BY n_id DESC LIMIT ".$_start.",12";
$article = mysql_query($query_article, $iwine) or die(mysql_error());
$row_article = mysql_fetch_assoc($article);
$totalRows_article = mysql_num_rows($article);
?>

<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>寵物寫真集 - iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="寵物寫真集 - iWine">
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/masonry.pkgd.min.js"></script>
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
        <div id="MainContent" class="span12">
          <div class="row">
            <div class="span12">
              <div>
                <ul class="breadcrumb">
  					<li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li>寵物寫真集 <span class="divider">/</span></li>
				</ul>
                <div class="row">
           			<div class="span12">
                		<h3><img src="images/wine_icon1.png" width="50" height="50"> 寵物寫真集</h3>
                    </div>
                </div>
                <?php if ($totalRows_article > 0) { // Show if recordset not empty ?>
    <div id="container_w"> 
	  <?php do { ?>
        <div class="item_w">
        <div style="border:solid 1px #000000; margin-bottom:5px; padding:5px">
		<a href="article.php?n_id=<?php echo $row_article['n_id']; ?>" >
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>" alt="<?php echo $row_article['n_title']; ?>" width="260">
        </a>
          <h5><a href="article.php?n_id=<?php echo $row_article['n_id']; ?>"><?php echo $row_article['n_title']; ?></a></h5>
          <div style="padding-left:5px; padding-right:5px"><?php echo substr_utf8(strip_tags($row_article['n_cont']),35) ;?>...</div>
          <div style="color: #CCC" align="right">2013-08-24</div>
          <div align="right"><i class="icon-tag"></i> 
            <a href="article_search.php?keyword=<?php echo urlencode($row_article['n_tag']); ?>" style="font-size:12px; color:#998675; padding-right:3px"><?php echo $row_article['n_tag']; ?></a>
            </div>
            <div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="true"></div>
            <div align="right">
        <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>'),'facebook-share-dialog','width=626,height=436');return false;"><img src="images/fb.jpg"></a>
          </div>
          </div>
          </div>
        <?php } while ($row_article = mysql_fetch_assoc($article)); ?>
       </div>
       <?php if($totalRows_article == 12){ ?>
       <div id="npage" style="display:none;"><a href="<?php printf("%s?page=%d", $currentPage, $i+1); ?>">下一页</a></div>
       <?php } ?>
  <?php }else{ // Show if recordset not empty ?>
  			<div class="row">
           			<div class="span12">
                		<h5>目前本區尚無文章。</h5>
                    </div>
                </div>
  <?php } ?>
              </div>
            </div>          
          </div>
          
          
        </div>
        
      </div>
      
      
    </div>   
    <?php include('footer.php'); ?>
 </body>
</html>
<?php
mysql_free_result($article);
?>
<?php include('ga.php'); ?>
<script type="text/javascript" src="assets/js/imagesload.js"></script>
<script type="text/javascript" src="assets/js/jquery.infinitescroll.min.js"></script>
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
	
	$(function(){
  	var $container = $('#container_w');
	$container.imagesLoaded( function() {
  		$container.masonry({
	  		itemSelector: '.item_w',
			isAnimated: true	  
	  	});
	});
  	$container.infinitescroll({
    navSelector  : "#npage",
    nextSelector : "#npage a",
    itemSelector : ".item_w" ,
    pixelsFromNavToBottom: 100,
	loading: {
                    msgText: "載入中...",
                    finishedMsg: '沒有新圖片了...'
                }
  },
  function( newElements ) {
    //首先隐藏
    var $newElems = $( newElements ).css({ opacity: 0 });
    $newElems.imagesLoaded(function(){
      //布局时显示
      $newElems.animate({ opacity: 1 });
      $container.masonry( 'appended', $newElems, true );
    });
  });			
				
				
				
				
				});

}); 
</script>
