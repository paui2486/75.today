<?php //include('session_check.php'); 
session_start();
include('func/func.php');
?>
<?php
include_once 'securimage/securimage.php';
$securimage = new Securimage();
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
  $updateSQL = sprintf("UPDATE member SET m_passwd_md5='%s', last_modify='%s' WHERE m_id='%s'",
                       htmlspecialchars(GetSQLValueString(md5($_POST['m_passwd']), "text")),
					   htmlspecialchars(GetSQLValueString($_today, "date")),
                       htmlspecialchars(GetSQLValueString($_POST['m_id'], "int")));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('密碼修改成功！請重新登入～謝謝！');
  go_to('logout2.php');
}

$colname_member = "-1";
if (isset($_SESSION['MEM_ID2'])) {
  $colname_member = $_SESSION['MEM_ID2'];
}
mysql_select_db($database_iwine, $iwine);
$query_member = sprintf("SELECT * FROM member WHERE m_id = '%s'", GetSQLValueString($colname_member, "int"));
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
    <title> iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
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
            
              <div>
                <form name="form1" action="<?php echo $editFormAction; ?>" method="POST" class="form-horizontal" id="form1" >
                	<legend class="title">修改會員密碼</legend>
  					<div class="control-group">
   					  <label class="control-label" for="m_account">帳 號</label>
    					<div class="controls"><?php echo $row_member['m_account']; ?>
                          
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
                        <span class="help-inline"><img src="securimage/securimage_show.php" alt="CAPTCHA Image" align="absmiddle" id="captcha" /><a href="#" onClick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false" class="btn-small btn-info">更換</a></span>
    					</div>
  					</div>
  					
                    <div class="control-group">
    					<div class="controls">
                        <input name="m_id" type="hidden" value="<?php echo $_SESSION['MEM_ID2']; ?>">
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
        
        <div class="row">
        <div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門排行</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
        
     </div>
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
