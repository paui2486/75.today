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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_article = 9;
$pageNum_article = 0;
if (isset($_GET['pageNum_article'])) {
  $pageNum_article = $_GET['pageNum_article'];
}
$startRow_article = $pageNum_article * $maxRows_article;

$colname_article = "-1";
if (isset($_GET['keyword'])) {
  $colname_article = $_GET['keyword'];
}
mysql_select_db($database_iwine, $iwine);
$query_article = "SELECT * FROM article WHERE (n_title LIKE '%%".$colname_article."%%' OR n_cont LIKE '%%".$colname_article."%%' OR n_tag LIKE '%%".$colname_article."%%') AND n_status = 'Y' ORDER BY n_date DESC";
$query_limit_article = sprintf("%s LIMIT %d, %d", $query_article, $startRow_article, $maxRows_article);
$article = mysql_query($query_limit_article, $iwine) or die(mysql_error());
$row_article = mysql_fetch_assoc($article);

if (isset($_GET['totalRows_article'])) {
  $totalRows_article = $_GET['totalRows_article'];
} else {
  $all_article = mysql_query($query_article);
  $totalRows_article = mysql_num_rows($all_article);
}
$totalPages_article = ceil($totalRows_article/$maxRows_article)-1;

$queryString_article = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_article") == false && 
        stristr($param, "totalRows_article") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_article = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_article = sprintf("&totalRows_article=%d%s", $totalRows_article, $queryString_article);


?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>搜尋結果 - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="搜尋結果 - iWine -- 禁止酒駕．未滿18歲禁止飲酒">
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
              <div style="margin:20px;">
                <ul class="breadcrumb">
  					<li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li class="active">搜尋結果</li>
				</ul>
                <div class="row">
           			<div class="span9">
                		<h3><img src="images/wine_icon1.png" width="35" height="25"> <span class="title">搜尋結果</span></h3>
<span class="span9"><img src="images/line03.png"></span></div>
                </div>
                <?php if ($totalRows_article > 0) { // Show if recordset not empty ?> 
                <div class="row">
       			  <div class="span9" align="left">
                		<h5>您搜尋『<?php echo trim($_GET['keyword']); ?>』共有 <?php echo $totalRows_article; ?> 筆搜尋結果，目前顯示第 <?php echo ($startRow_article + 1) ?> 筆至第 <?php echo min($startRow_article + $maxRows_article, $totalRows_article) ?> 筆文章。</h5>
                    </div>
                </div>   
      <?php $i = 1; ?>
	  <?php do { ?>
      <?php if(($i%3) == 1){ ?>
      <div class="row span9" style="margin-left:0px;">
      <?php } ?>
        <div class="span3" style="margin-left:0px;">
        <div style="border:solid 0px #000000; margin-bottom:35px; padding:5px">
        <div style="height:199px; overflow:hidden">
		<a href="article.php?n_id=<?php echo $row_article['n_id']; ?>" >
        <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_article['n_fig1']; ?>" alt="<?php echo $row_article['n_title']; ?>">
        </a>
        </div>
          <h5><div style="height:26px"><a href="article.php?n_id=<?php echo $row_article['n_id']; ?>"><?php echo $row_article['n_title']; ?></a><img src="images/article_line.png"></div></h5>
          <div style="padding-left:5px; padding-right:5px; height:40px"><?php echo substr_utf8(strip_tags($row_article['n_cont']),35) ;?>...</div>
        
          <!--
          <div align="right" style="height:20px"><i class="icon-tag"></i> 
            <a href="article_search.php?keyword=<?php echo urlencode($row_article['n_tag']); ?>" style="font-size:12px; color:#998675; padding-right:3px"><?php echo $row_article['n_tag']; ?></a>
            </div>
            -->
            <div class="fb-like" data-href="http://www.iwine.com.tw/article.php?n_id=<?php echo $row_article['n_id']; ?>" data-layout="button_count" data-show-faces="false" data-send="true"></div>
          </div>
          </div>
          <?php if(($i%3) == 0){ ?>
      </div>
      <?php } ?>
      <?php $i++; ?>
        <?php } while ($row_article = mysql_fetch_assoc($article)); ?>
      <?php if(($i%3) != 1){ ?>
      </div>
      <?php } ?>       
  <?php }else{ // Show if recordset not empty ?>
  			<div class="row">
           			<div class="span9">
                		<h5>搜尋不到文章！請用其他關鍵字重新搜尋～</h5>
                    </div>
                </div>
  <?php } ?>
  <?php if($totalPages_article > 0){ ?>
<div class="pagination pagination-centered">
  					<ul>
    					<li><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, max(0, $pageNum_article - 1), $queryString_article); ?>">上一頁</a></li>
    					<?php  $tp = $totalPages_article+1;for($i=1;$i<=10;$i++){ //前面的10原本 $tp 是總搜尋數的意思 如果忘記了就把10重tp?>
                        <li <?php if($i == $pageNum_article + 1 ){ echo "class=\"active\""; } ?>><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, max(0, $i - 1), $queryString_article); ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <li><a href="<?php printf("%s?pageNum_article=%d%s", $currentPage, min($totalPages_article, $pageNum_article + 1), $queryString_article); ?>">下一頁</a></li>
  					</ul>
				</div>
                <?php } ?>
              </div>
            </div>          
          </div>
          
          
        </div>
         <div class="row">
        <!--div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30">熱門排行</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
        <div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine 排行榜 </h4>
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
     </div>
      </div>
      
      
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
    <script src="js/twzipcode-1.4.1.js"></script>
    <script language="javascript">
	//twzip
	$('#twzip').twzipcode({
		css: ['addr-county', 'addr-area', 'addr-zip']	
	});
	</script>
    <script language="javascript">
	function chkmail(){
	
	myReg = /^.+@.+\..{2,3}$/
	if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
	form0.submit();	
		
	}
    </script>
    <script language="javascript">
	function chkform(){

 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  
  if( $("#m_account").val() =="" || !$("#m_account").val().match(myReg)){alert('請輸入正確格式之E-mail做為帳號!'); return; }
  if( $("#m_passwd").val() == ""){alert('請輸入密碼!'); return; }
  if( $("#m_passwd").val().length < 6 ){alert('請輸入6字元以上的密碼'); return;  }
  if( $("#m_passwd_confirm").val() == ""){alert('請再次確認密碼!'); return; }
  if( $("#m_passwd_confirm").val() != $("#m_passwd").val() ){alert('密碼確認不一致，請重新輸入!'); return; }
  if( $("#m_name").val() == ""){alert('請輸入姓名!'); return; }  
  if( $("#m_mobile").val() =="" || !$("#m_mobile").val().match(mobileReg)){alert('請輸入正確之手機號碼！'); return; }
  if( $("input[name='m_agree']:checked").val() !="Y"){alert('您必須閱讀並勾選同意iWine所聲明之使用者條款才能完成註冊!'); return; }
  if( $("input[name='m_a18']:checked").val() !="Y"){alert('您必須年滿18歲才能完成註冊!'); return; }
  
  if(window.confirm('是否確定送出資料並完成註冊？')){
  $("#form1").submit();
  }else{ return; }
}

	
	function checkAccount(){
	
		var num = $.trim($("#m_account").val());
		
		myReg = /^.+@.+\..{2,3}$/
		
		if( !$("#m_account").val().match(myReg) ){
			$("#account_check").html("格式錯誤，請輸入e-mail做為帳號!");
			$("#m_account").val('');
		}else{
		//alert(num);
		$.ajax({
    		url: 'check_account.php',
    		data: {m_account: num},
    		error: function(xhr) {  },
    		success: function(response) { 
			if(response == 'success'){
			$("#account_check").html("此帳號可註冊!");
			}else{
			$("#account_check").html("此帳號已被註冊，請重新輸入!");
			$("#m_account").val('');
			}
			}
				});
				
}

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
