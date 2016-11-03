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

mysql_select_db($database_iwine, $iwine);
$query_article_class = "SELECT * FROM article_class WHERE pc_online = 'Y' ORDER BY pc_order ASC";
$article_class = mysql_query($query_article_class, $iwine) or die(mysql_error());
$row_article_class = mysql_fetch_assoc($article_class);
$totalRows_article_class = mysql_num_rows($article_class);


mysql_select_db($database_iwine, $iwine);
$query_expert_menu = "SELECT * FROM expert WHERE active = 1 ORDER BY name ASC";
$expert_nemu = mysql_query($query_expert_menu, $iwine) or die(mysql_error());
$totalRows_expert_nemu = mysql_num_rows($expert_nemu);

mysql_select_db($database_iwine, $iwine);
$query_search_keyword = "SELECT * FROM search_keyword ORDER BY sk_id DESC LIMIT 1";
$search_keyword = mysql_query($query_search_keyword, $iwine) or die(mysql_error());
$the_search_keyword = mysql_fetch_assoc($search_keyword);

?>

<style>
div.cities {
    background-color: black;
    color: white;
    margin: 20px 0 20px 0;
    padding: 20px;
}
</style>

<div class="navbar navbar-fixed-top">
<div class="navbar-black">

<div class="container" style="padding-bottom:0px !important">
<a class="brand" href="index.php"><img src="webimages/c.svg"></a><!--原本  brand是title-->

<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
</a>
<div class="nav-collapse collapse">
    <ul class="nav">
        <!--<li class="dropdown">下拉式選單
            <a href="#" data-toggle="dropdown">達人系列 <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?php if($totalRows_expert_nemu > 0){ ?>
                <?php while($row_expert_menu = mysql_fetch_assoc($expert_nemu)) { ?>
                         <li><a href="expert.php?e_id=<?php echo $row_expert_menu['id']; ?>"><?php echo $row_expert_menu['name']; ?></a></li>
                    <?php } ; ?>
                <?php } ?>
            </ul>
       </li>-->
    
    <!--<li class="divider-vertical"></li>-->
    
	<!--<li>
          <a href="latest-news-list.php">品牌地圖</a>
    </li>-->
	<!--<li>
          <a href="wine-section-list.php">酒款地圖</a>
    </li>-->
	<!--<li>
          <a href="video_list.php">影片</a>
    </li>-->
        <!--<li class="divider-vertical"></li><!--|的白線-->
		<!--後台可控制頁面 開始-->
        <?php do { ?>
            <?php if($row_article_class['pc_id'] <> 10){?>
            <li>
              
              <a href="article_class.php?pc_id=<?php echo $row_article_class['pc_id']; ?>"><?php echo $row_article_class['pc_name']; ?> </a>
            </li>
            <!--<li class="divider-vertical"></li>-->
            <?php } ?>
            
        <?php } while ($row_article_class = mysql_fetch_assoc($article_class)); ?>
		<!--後台可控制頁面 結束-->
        
        <!--<li class="dropdown">
          <a href="#" data-toggle="dropdown">iWine嚴選 <b class="caret"></b></a>
            <ul class="dropdown-menu">
                
            </ul>
        <li class="divider-vertical"></li>-->
        
        <!--<li>
          <a href="newgroup.php">奇貨</a>
        </li>>-->
        <!--<li class="divider-vertical"></li>-->
        <!--li>
          <a href="cute_video_w.php">精采影片 </a>
        </li>
        <li class="divider-vertical"></li-->
        <li>
          <a href="symposium_list.php">攔轎上稿</a>
        </li>
        <!--<li class="divider-vertical"></li>-->
        <!--
        <li>
          <a href="album_list.php">精采寫真 </a>
        </li>
        <li class="divider-vertical"></li>
        -->
        <!--<li class="dropdown">
            <?php if($_SESSION['MEM_TYPE'] == 'wine_supplier' || $_SESSION['MEM_TYPE'] == 'bar' || $_SESSION['MEM_TYPE'] == 'expert' ){ ?>
                <a href="#" data-toggle="dropdown">合作夥伴中心 <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="symposium_upload_simple.php">上傳品酒情報</a></li>
                    <li><a href="modify_b.php">修改會員資料</a></li>
                    <li><a href="modpass_b.php">修改密碼</a></li>
                    <li><a href="logout.php">登出</a></li>
                </ul>
            
            <?php }else{ ?>
          
                <a href="#" data-toggle="dropdown">會員中心 <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(!isset($_SESSION['MEM_ID'])){ ?>
                    <li><a href="regist.php">註冊新會員</a></li>
                    <li><a href="login.php">登入會員</a></li>
                    <li><a href="login_b.php">登入合作夥伴</a></li>
                    <?php }else{ ?>
                    
                    <li><a href="modify.php">修改會員資料</a></li>
                    <li><a href="myorder.php">我的訂單</a></li>
                    <li><a href="logout.php">登出</a></li>
                    <?php } ?>
                    
                    <li><a href="faq.php">常見問題</a></li>
                    <li><a href="service.php">聯絡我們</a></li>
                </ul>
            <?php } ?>
        </li>-->
        <!--<li class="divider-vertical"></li>-->
     </ul>
     <!--<form class="navbar-form pull-left" action="article_search.php">
  		<input name="keyword" type="text" class="input02-large search-query" id="keyword" placeholder="<?php echo $the_search_keyword['sk_keyword']; ?>" maxlength="35">
		<button type="submit" class="btn"><i class="icon-search"></i> 搜尋</button> 
        <a href="http://www.iwine.com.tw/edm_order.php" class="btn">訂閱電子報</a>
</form>-->
</div>
</div>
</div>
</div>
<?php
mysql_free_result($article_class);
mysql_free_result($expert_nemu);
mysql_free_result($keyword);
?>
