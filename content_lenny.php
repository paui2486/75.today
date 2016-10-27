<?php include('session_record.php'); ?>
<?php $_SESSION['page'] = $_SERVER['REQUEST_URI']; ?>
<?php require_once('Connections/iwine.php'); ?>
<?php include('func/func.php'); ?>
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

$colname_Content = "-1";
if (isset($_GET['p_id'])) {
  $colname_Content = $_GET['p_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Content = sprintf("SELECT * FROM Product WHERE p_id = '%s'", GetSQLValueString($colname_Content, "int"));
$Content = mysql_query($query_Content, $iwine) or die(mysql_error());
$row_Content = mysql_fetch_assoc($Content);
$totalRows_Content = mysql_num_rows($Content);

if($totalRows_Content == 0){
	go_to('index.php');
	exit;
	}
	
if($row_Content['p_trans_url'] <> ""){
	if($_SESSION['am_code'] <> ""){
		$new_url = "content.php?p_id=".$row_Content['p_trans_url']."&am_code=".$_SESSION['am_code'];
		go_to($new_url);
	}else{
		$new_url = "content.php?p_id=".$row_Content['p_trans_url'];
		go_to($new_url);
	}
}
$current_title = $row_Content['p_name'];
$cur_url = curPageURL();
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title><?php echo $row_Content['p_name']; ?> -  iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="<?php echo $row_Content['p_subtitle']; ?>" />
    <meta name="author" content="iWine"/>
    <meta property="og:title" content="<?php echo $row_Content['p_name']; ?>" />
	<meta property="og:site_name" content=" iWine" />
    <meta property="og:description" content="<?php echo $row_Content['p_subtitle']; ?>" />
	<meta property="og:image" content="http://admin.iwine.com.tw/webimages/products/<?php echo $row_Content['p_file2']; ?>" />
	<meta property="og:type" content="website" />
    <meta property="fb:admins" content="1685560618" />
	<meta property="fb:app_id" content="540353706035158" />
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
        .fb_iframe_widget form, .fb_like form,.fb_iframe_widget table, .fb_like table{
        visibility:hidden !important;
        display:none !important;
        }
    </style>
  </head>
  <body>
  <div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
        FB.init({
            appId  : '540353706035158',
            status : true, // check login status
            cookie : true, // enable cookies to allow the server to access the session
            xfbml  : true  // parse XFBML
        });
        FB.Event.subscribe('xfbml.render', function(response) {
        });
        FB.Event.subscribe('auth.sessionChange', function(response) {
            // 當 Facebook session 改變時通知
        });
        FB.Event.subscribe('edge.create', function(response) {
            // 當有人按讚時通知
        });
        FB.Event.subscribe('comments.create', function(response) {
            // 當有新留言時通知
        });

    };

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=540353706035158";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <a id="top_page"></a>
    <div class="container">
      <?php include('header_20140903.php'); ?>
      <ul class="nav nav-pills">
        <div id="nav_menu" class="navbar">
        
          <div class="navbar-inner">
            <div class="container-fluid">
              <?php include('mainmenu_20140903.php'); ?>
            </div>
          </div>
        </div>
      </ul>
      
      <div class="row">
        <div id="MainContent" class="span9">
        <div class="row">
            <div class="span9">
            <div class="fb-like" data-send="true" data-width="500" data-show-faces="false"></div>
            <div style="color:#65503c; font-size:32px; line-height: 35px; padding-top:10px"><?php echo $row_Content['p_name']; ?></div>
            <h4><span style="color:#998675; font-size:120%"><?php echo $row_Content['p_subtitle']; ?></span></h4>
            </div>
          </div>
          <div class="row">
            <div class="span3">
              <div align="center">
                <table width="100%" border="1" cellspacing="2" cellpadding="5" style="border:#000000; color:#65503c">
                  <tr>
                    <td width="40%" align="center" bgcolor="#FFFFFF">原 價</td>
                    <td align="center" bgcolor="#FFFFFF">NT$<?php echo number_format($row_Content['p_price1']); ?></td>
                  </tr>
                  <tr>
                  <?php if($row_Content['p_login_price']=="N"){ ?>
                    <td align="center" bgcolor="#FFFFFF"><h4><span style="color:#fc91a2">團體價</span></h4></td>
                    <td align="center" bgcolor="#FFFFFF"><h3><span style="color:#fc91a2">NT$<?php echo number_format($row_Content['p_price2']); ?></span></h3></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF">折 扣</td>
                    <td align="center" bgcolor="#FFFFFF"><?php echo $row_Content['p_discount_ratio']; ?>折</td>
                  </tr>
                  <?php }else{ ?>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF"><h4>團體價</h4></td>
                    <td align="center" bgcolor="#FFFFFF"><h3><span style="color:#fc91a2"><?php if($_SESSION['MEM_ID']<>""){echo "NT$".number_format($row_Content['p_price2']);}else{ ?><a href="login.php">請先登入會員</a><?php } ?></span></h3></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF">折 扣</td>
                    <td align="center" bgcolor="#FFFFFF"><?php if($_SESSION['MEM_ID']<>""){echo $row_Content['p_discount_ratio']."折"; }else{  ?><a href="login.php">請先登入會員</a><?php  } ?></td>
                  </tr>
                  <tr>
                  <?php } ?>
                    <td align="center" bgcolor="#FFFFFF">單 位</td>
                    <td align="center" bgcolor="#FFFFFF"><?php echo $row_Content['p_unit']; ?></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#FFFFFF">截止日期</td>
                    <td align="center" bgcolor="#FFFFFF"><?php echo $row_Content['p_end_time']; ?></td>
                  </tr>
                </table>
                <p></p>
                <?php 
				$today = date('Y-m-d');
				$_limit_total = $row_Content['p_p1_limit_num'] + $row_Content['p_p2_limit_num'] + $row_Content['p_p3_limit_num'] + $row_Content['p_p4_limit_num'] + $row_Content['p_p5_limit_num'];
				$_limit_sale_total = $row_Content['p_p1_limit_sale'] + $row_Content['p_p2_limit_sale'] + $row_Content['p_p3_limit_sale'] + $row_Content['p_p4_limit_sale'] + $row_Content['p_p5_limit_sale'];
				
				if($_limit_total > 0){$_limit_start = "Y";
					if($_limit_sale_total >= $_limit_total){$_limit_end = "Y";}else{$_limit_end = "N";}	
				}else{$_limit_start = "N";}
						
				
				if($row_Content['p_start_time'] <= $today && $row_Content['p_end_time'] >= $today && $row_Content['p_outside'] == "N"){ ?>
                <?php if($_limit_start == "Y" && $_limit_end == "N"){ ?>
                <p><a class="btn btn-large btn-danger" href="cart_1.php?p_id=<?php echo $row_Content['p_id']; ?>"><i class="icon-shopping-cart icon-white"></i> <strong>我 要 跟 團</strong></a></p>
                <p style="color:#65503c">限量<?php echo $_limit_total; ?>份，已登記 <?php echo $_limit_sale_total; ?> 份</p>
                <?php }elseif($_limit_start == "Y" && $_limit_end == "Y"){ ?>
				<p style="color:#65503c">限量<?php echo $_limit_total; ?>份，已登記 <?php echo $_limit_sale_total; ?> 份</p>
                <p><a class="btn btn-large btn-primary" href="#"><i class="icon-remove icon-white"></i> <strong>已 滿 團</strong></a></p>
				<?php }elseif($_limit_start == "N"){ ?>
                <p><a class="btn btn-large btn-danger" href="cart_1.php?p_id=<?php echo $row_Content['p_id']; ?>"><i class="icon-shopping-cart icon-white"></i> <strong>我 要 跟 團</strong></a></p>
                <p style="color:#65503c">目前已登記 <?php echo $row_Content['p_sale_num']; ?> 份</p>
                <?php } ?>
				<?PHP }elseif($row_Content['p_start_time'] <= $today && $row_Content['p_end_time'] >= $today && $row_Content['p_outside'] == "Y" ){ ?>
                <p><a href="<?php echo $row_Content['p_outside_url']; ?>" target="new" class="btn btn-large btn-danger"><i class="icon-shopping-cart icon-white"></i> <strong>我 要 跟 團</strong></a></p>
                <?php }elseif($row_Content['p_end_time'] < $today){ ?>
                <p><a class="btn btn-large btn-primary" href="#"><i class="icon-remove icon-white"></i> <strong>已 結 束</strong></a></p>
				<?php }else{ ?>
                <p><a class="btn btn-large btn-primary" href="#"><i class="icon-remove icon-white"></i> <strong>尚 未 開 團</strong></a></p>
                <?php } ?>
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
if( $iPhone || $Android){
				?>
                <p>
                <a href="http://line.naver.jp/R/msg/text/?【iWine%20愛我酒酒】推薦好物：<?php echo $row_Content['p_name']; ?>%0D%0Ahttp%3A%2F%2Fwww.iwine.com.tw/content.php?p_id=<?php echo $row_Content['p_id']; ?>"><img src="images/linebutton_20x20.png"></a>
                </p>
				<?php } ?> 
                <p>
<table width="300" border="0">
  <tr>
    <td ></td>
  </tr>
  <tr>
  <td>
  
  
  
    <!-- G+ share button -->
    <div style="float:left; margin-top:10px;">
        <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
    </div>
    <!-- G+ share js -->
    <script type="text/javascript">
          window.___gcfg = {lang: 'zh-TW'};

          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/platform.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
    </script>

    <!-- plurk share -->
    <div style="float:left; margin:10px 5px 5px 5px;">
        <a title="分享在我的 plurk" href="javascript:void(window.open('http://www.plurk.com/?qualifier=shares&status='.concat(encodeURIComponent(window.location.href)).concat('').concat(' (').concat(encodeURIComponent(document.title)).concat(')')));"><image src="http://www.iwine.com.tw/webimages/plurk.png" width="30px" height="30px" border="0"></a>
    </div>
    <!-- weibo -->
    <div style="float:left; margin:10px 5px 5px 5px;">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $current_title ?>&url=<?php echo $cur_url;?>" target="_blank" title="分享到新浪微博">
            <image src="http://www.iwine.com.tw/webimages/sinaweibo.gif" width="30px" height="30px" border="0" title="分享到我的 weibo">
        </a>
    </div>
    <!-- Twitter -->
    <div style="float:left; margin:10px 5px 5px 5px;">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="zh-tw" data-size="large" data-count="true" data-dnt="true" data-counturl="<?php echo $current_url; ?>" data-url="<?php echo $current_url; ?>" title="推到我的 Twitter">推文</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
    
</div>

  
  </td></tr>
</table>
                
                </p>
              </div>
            </div>
            <div id="ProductImg" class="span6">
            	<table width="100%" border="1" cellpadding="1" style="border:#000000">
  					<tr>
    					<td align="center"><a href="cart_1.php?p_id=<?php echo $row_Content['p_id']; ?>"><img src="http://admin.iwine.com.tw/webimages/products/<?php echo $row_Content['p_file2']; ?>" style=" width: 600px;" alt="<?php echo $row_Content['p_name']; ?>"></a></td>
  					</tr>
			  </table>
              <p></p>            
            </div>
          </div>
          <div class="row">
            <div class="span9">
              <ul class="nav nav-tabs" id="myTab">
  				<li class="active"><a href="#home" data-toggle="tab">＊團體商品介紹＊</a></li>
  				<li><a href="#profile" data-toggle="tab">＊團體注意事項＊</a></li>
                <li><a href="#post" data-toggle="tab">＊體驗分享＊</a></li>
                <li><a href="#comment" data-toggle="tab">＊留言回響＊</a></li>
              </ul>
 
			<div class="tab-content">
  				<div class="tab-pane active" id="home">
               	  <div><p><?php echo $row_Content['p_description']; ?></p>
                    </div>
                </div>
  				<div class="tab-pane" id="profile">
                	<div><p><?php echo $row_Content['p_memo']; ?></p>
                    </div>
              </div>
              <div class="tab-pane" id="post">
                	<div><p><?php echo $row_Content['p_other']; ?></p>
                    </div>
              </div>
                <div class="tab-pane" id="comment">
                <div class="fb-comments" data-href="http://www.iwine.com.tw/content.php?p_id=<?php echo $row_Content['p_id']; ?>" data-width="700" data-num-posts="10"></div>	
              </div>
              <div class="tab-pane" id="post">
                	<div><p></p>
                    </div>
              </div>
  			</div>
            
            <div id="FBComment" align="center"> 
      <?php
	  if($row_Content['p_start_time'] <= $today && $row_Content['p_end_time'] >= $today && $row_Content['p_outside'] == "N"){ ?>
                <?php if($_limit_start == "Y" && $_limit_end == "N"){ ?>
                <p><a class="btn btn-large btn-danger" href="cart_1.php?p_id=<?php echo $row_Content['p_id']; ?>"><i class="icon-shopping-cart icon-white"></i> <strong>我 要 跟 團</strong></a> <a class="btn btn-large btn-info" href="#top_page"><strong>回 頂 部</strong></a></p>
                <p>限量<?php echo $_limit_total; ?>份，已登記 <?php echo $_limit_sale_total; ?> 份</p>
                <?php }elseif($_limit_start == "Y" && $_limit_end == "Y"){ ?>
				<p>限量<?php echo $_limit_total; ?>份，已登記 <?php echo $_limit_sale_total; ?> 份</p>
                <p><a class="btn btn-large btn-primary" href="#"><i class="icon-remove icon-white"></i> <strong>已 滿 團</strong></a> <a class="btn btn-large btn-info" href="#top_page"><strong>回 頂 部</strong></a></p>
				<?php }elseif($_limit_start == "N"){ ?>
                <p><a class="btn btn-large btn-danger" href="cart_1.php?p_id=<?php echo $row_Content['p_id']; ?>"><i class="icon-shopping-cart icon-white"></i> <strong>我 要 跟 團</strong></a> <a class="btn btn-large btn-info" href="#top_page"><strong>回 頂 部</strong></a></p>
                <p>目前已登記 <?php echo $row_Content['p_sale_num']; ?> 份</p>
                <?php } ?>
				<?PHP }elseif($row_Content['p_start_time'] <= $today && $row_Content['p_end_time'] >= $today && $row_Content['p_outside'] == "Y" ){ ?>
                <p><a href="<?php echo $row_Content['p_outside_url']; ?>" target="new" class="btn btn-large btn-danger"><i class="icon-shopping-cart icon-white"></i> <strong>我 要 跟 團</strong></a> <a class="btn btn-large btn-info" href="#top_page"><strong>回 頂 部</strong></a></p>
                <?php }elseif($row_Content['p_end_time'] < $today){ ?>
                <p><a class="btn btn-large btn-primary" href="#"><i class="icon-remove icon-white"></i> <strong>已 結 束</strong></a> <a class="btn btn-large btn-info" href="#top_page"><strong>回 頂 部</strong></a></p>
				<?php }else{ ?>
                <p><a class="btn btn-large btn-primary" href="#"><i class="icon-remove icon-white"></i> <strong>尚 未 開 團</strong></a> <a class="btn btn-large btn-info" href="#top_page"><strong>回 頂 部</strong></a></p>
                <?php } ?>  
                
                  
          
      </div>
            
            </div>
          </div>
        </div>
        <div class="row">
        <div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine嚴選</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
        
     </div>
      </div>
      
      <div class="row">
      
      </div>
      <div class="row">
      </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
    <script language="javascript">
	function chkmail(){
	
	myReg = /^.+@.+\..{2,3}$/
	if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
	form0.submit();	
		
	}
    </script>
  </body>
</html>
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
<?php
mysql_free_result($Content);
?>
