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
?>
<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
</a>
<div class="nav-collapse collapse">
    <ul class="nav">
        <?php do { ?>
            <li>
              <a href="article_class.php?pc_id=<?php echo $row_article_class['pc_id']; ?>"><?php echo $row_article_class['pc_name']; ?> </a>
            </li>
            <li class="divider-vertical"></li>
        <?php } while ($row_article_class = mysql_fetch_assoc($article_class)); ?>
        <!--
        <li class="dropdown">
          <a href="#" data-toggle="dropdown">iWine嚴選 <b class="caret"></b></a>
            <ul class="dropdown-menu">
                
            </ul>
        <li class="divider-vertical"></li>
        -->
        <li>
          <a href="newgroup.php">iWine嚴選</a>
        </li>
        <li class="divider-vertical"></li>
        <li>
          <a href="cute_video_w.php">精采影片 </a>
        </li>
        <li class="divider-vertical"></li>
        <li>
          <a href="symposium_list.php">品酒會情報</a>
        </li>
        <li class="divider-vertical"></li>
        <!--
        <li>
          <a href="album_list.php">精采寫真 </a>
        </li>
        <li class="divider-vertical"></li>
        -->
        <li class="dropdown">
            <?php if($_SESSION['MEM_TYPE'] == 'wine_supplier' || $_SESSION['MEM_TYPE'] == 'bar' || $_SESSION['MEM_TYPE'] == 'expert' ){ ?>
                <a href="#" data-toggle="dropdown">合作夥伴中心 <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="symposium_upload_simple.php">上傳品酒會情報</a></li>
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
                    <li><a href="myorder.php">我的洽詢單</a></li>
                    <li><a href="logout.php">登出</a></li>
                    <?php } ?>
                    
                    <li><a href="faq.php">常見問題</a></li>
                    <li><a href="service.php">聯絡我們</a></li>
                </ul>
            <?php } ?>
        </li>
     </ul>
</div>
<?php
mysql_free_result($article_class);
?>
