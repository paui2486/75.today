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
<!--<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
</a>-->



<div class="header-new-frame" style="background-image:url(images/nav_bg.png)">


<div class="container"> 
<!-- header new--> 
<div class="header-new">

<!-- header--> 
<div id="header">
      	<div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="38%" height="105" bgcolor="#FFFFFF"><a href="http://www.iwine.com.tw/index.php"><img src="images/iWine_logo.png" width="430" height="76" /></a></td>
            <td width="62%" align="right" valign="middle" bgcolor="#FFFFFF" style="background-image:url(images/banner.jpg);"><table width="90%" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right" valign="bottom" bgcolor="#FFFFFF">  
               
<a href="login_b.php"><img src="images/btn_symposium_upload.jpg" title="品酒會資料上傳區" width="146" height="33" /></a>
<a href="login_b.php"></a>
<form class="form-inline" role="form" id="order_email" action="" name="order_email">
  <input type="email" class="form-control" id="inputEmail" placeholder="輸入 email 訂閱 iWine 電子報">
        <a class="btn btn-default" value="訂閱" id="update" onclick="orderEmail();">訂閱</a>
  </form>
    
    
<script type="text/javascript">
    function orderEmail(){
        myReg = /^.+@.+\..{2,3}$/
        var email_data = $("#inputEmail").val();
        if( !$("#inputEmail").val().match(myReg) ){
           alert("E-mail 格式錯誤，請檢查重填，謝謝！");
            $("#inputEmail").val('');
        }else{
            $.ajax({
                url: 'member_order_email.php',
                data: {email: email_data},
                error: function(xhr) {  },
                success: function(response) { alert(response); }
            });
        }
    };
</script>





 </td>
              </tr>
            </table>
          
		
            </td>
          </tr>
        </table>       	
        </div>
</div>
<!-- header end --> 



     <ul class="nav nav-pills">
        <div id="nav_menu" class="navbar">     
          <div class="navbar-inner">
            <div class="container-fluid">
<!-- nav --> 
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
                  <a href="#" data-toggle="dropdown">會員中心 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if(!isset($_SESSION['MEM_ID'])){ ?>
                        <li><a href="regist.php">註冊新會員</a></li>
                        <li><a href="login.php">登入會員</a></li>                
                        <?php }else{ ?>
                        <li><a href="logout.php">登出</a></li>
                        <li><a href="modify.php">修改會員資料</a></li>
                        <li><a href="myorder.php">我的洽詢單</a></li>
                        <?php } ?>
                        
                    <!--/ul>
                <li class="divider-vertical"></li>
                <li class="dropdown">
                  <a href="#" data-toggle="dropdown">客服中心 <b class="caret"></b></a>
                    <ul class="dropdown-menu"-->
                        <li><a href="faq.php">常見問題</a></li>
                        <li><a href="service.php">聯絡我們</a></li>
                    </ul>
      
              </ul>
</div>
<!-- nav end --> 
            </div>
          </div>
        </div>
      </ul>



</div>
<!-- header new end--> 
</div>

</div>
<?php
mysql_free_result($article_class);
?>
