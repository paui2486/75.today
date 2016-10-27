<?php include('session_check.php'); ?>
<?php
include_once '../securimage/securimage.php';
$securimage = new Securimage();
?>
<?php require_once('../Connections/iwine.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
  if ($securimage->check($_POST['capacha_code']) == false) {
  msg_box('驗證碼錯誤,請重新輸入!');
  $_err_url = "member_pwchange.php";
  go_to($_err_url);
  exit;
}		
  $_today = date('Y-m-d H:i:s');
  $updateSQL = sprintf("UPDATE alliance_member SET am_passwd='%s', am_last_modify='%s' WHERE am_id='%s'",
                       htmlspecialchars(GetSQLValueString(md5($_POST['m_passwd']), "text")),
					   htmlspecialchars(GetSQLValueString($_today, "date")),
                       htmlspecialchars(GetSQLValueString($_POST['m_id'], "int")));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('密碼修改成功！請重新登入～謝謝！');
  session_destroy();
  go_to('login.php');
}

$colname_member = "-1";
if (isset($_SESSION['ALLIANCE_ID'])) {
  $colname_member = $_SESSION['ALLIANCE_ID'];
}
mysql_select_db($database_iwine, $iwine);
$query_member = sprintf("SELECT * FROM alliance_member WHERE am_id = '%s'", GetSQLValueString($colname_member, "int"));
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);

if($totalRows_member == 0){
	go_to('index.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> iWine 聯盟行銷</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
      </script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
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
      <div id="header">
      	<div>
        <p><a href="../index.php"><img src="../images/logo.png" alt="iWine"> </a>聯盟行銷</p>
        	
        </div>
        
      </div>
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
            
              <div>
                <form name="form1" action="<?php echo $editFormAction; ?>" method="POST" class="form-horizontal" id="form1" >
                	<legend>修改會員密碼</legend>
  					<div class="control-group">
    					<label class="control-label" for="m_account">帳 號</label>
    					<div class="controls"><?php echo $row_member['am_account']; ?>
                          
                          <span class="help-stock"><div id="account_check" style="color:#F00"></div></span>
   					  </div>
  					</div>
  					<div class="control-group">
    					<label class="control-label" for="m_passwd">密 碼</label>
    					<div class="controls">
      					<input name="m_passwd" type="password" id="m_passwd" placeholder="請輸入密碼">
                        <span class="help-inline">*請輸入8碼以上的英文或數字(大小寫視為不同)</span>
    					</div>
  					</div>
                    <div class="control-group">
    					<label class="control-label" for="m_passwd_confirm">確認密碼</label>
    					<div class="controls">
      					<input name="m_passwd_confirm" type="password" id="m_passwd_confirm" placeholder="請再次輸入密碼">
                        <span class="help-inline">*請再次輸入您的密碼</span>
    					</div>
  					</div>
                   
                    <div class="control-group">
    					<label class="control-label" for="capacha_code">驗證碼</label>
   					  <div class="controls">
      					<input name="capacha_code" type="text" id="capacha_code" />
                        <span class="help-inline"><img src="../securimage/securimage_show.php" alt="CAPTCHA Image" align="absmiddle" id="captcha" /><a href="#" onClick="document.getElementById('captcha').src = '../securimage/securimage_show.php?' + Math.random(); return false" class="btn-small btn-info">更換</a></span>
    					</div>
  					</div>
  					
                    <div class="control-group">
    					<div class="controls">
                        <input name="m_id" type="hidden" value="<?php echo $_SESSION['ALLIANCE_ID']; ?>">
      					<button type="button" class="btn btn-danger" onClick="chkform();">確定修改</button>
                        <button type="reset" class="btn btn-success">重設</button>
    					</div>
  						</div>
                    <input type="hidden" name="MM_update" value="form1">
				</form>
                
              </div>
            </div>
            
          </div>
          
        </div>
        
        <div class="span3" id="LeftContent" align="center">
        </div>
      </div>
      
      <div class="row">
      <div id="footer" class="span12" align="center" style="border-color:#000000; border-width: 1px; border-style:solid"> 
           <table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr>
    <td align="center" valign="middle"><p style="font-size:12px">本站採用HTML5建置，為達到最佳瀏覽效果，建議使用Chrome，Safari，FireFox等瀏覽器</p>
      <p style="font-size:12px"><img src="../images/logo2_small.jpg" alt="iWine" style="border-color:#000000; border-width: 1px; border-style:solid">&nbsp;&nbsp;&nbsp;&nbsp;© 2013 iWine 聯盟行銷. All Rights Reserved</p><p style="font-size:12px">法律顧問：圓方法律事務所</p>
<p style="font-size:12px"><a href="law.php" style="color:#000">《使用者條款》</a></p></td>
    <td width="18%"><img src="../images/qrcode.png" style="border-color:#000000; border-width: 1px; border-style:solid"></td>
  </tr>
</table></div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="../assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php
mysql_free_result($member);
?>
<script type="text/javascript">
function chkform(){

 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  
  if( $("#m_passwd").val() == ""){alert('請輸入密碼!'); return; }
  if( $("#m_passwd").val().length < 8 ){alert('請輸入8字元以上的密碼'); return;  }
  if( $("#m_passwd_confirm").val() == ""){alert('請再次確認密碼!'); return; }
  if( $("#m_passwd_confirm").val() != $("#m_passwd").val() ){alert('密碼確認不一致，請重新輸入!'); return; }
    
  $("#form1").submit();
}
</script>
<?php include('ga.php'); ?>
