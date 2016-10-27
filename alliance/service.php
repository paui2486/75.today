<?php 
include('session_check.php');
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  if ($securimage->check($_POST['capacha_code']) == false) {
  msg_box('驗證碼錯誤,請重新輸入!');
  $_err_url = "service.php";
  go_to($_err_url);
  exit;
}	
	
  $insertSQL = sprintf("INSERT INTO alliance_contact (c_name, c_tel, c_email, c_class, c_cont, c_datetime) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
                       GetSQLValueString($_POST['c_name'], "text"),
                       GetSQLValueString($_POST['c_tel'], "text"),
                       GetSQLValueString($_POST['c_email'], "text"),
                       GetSQLValueString($_POST['c_class'], "text"),
                       GetSQLValueString($_POST['c_cont'], "text"),
                       GetSQLValueString($_POST['c_datetime'], "date"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  msg_box('您的訊息已經送出，我們會儘快回覆您，謝謝！');
  go_to('login.php');
}
 
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>客服中心 - iWine 聯盟行銷</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="客服中心">
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
        <p><a href="index.php"><img src="../images/logo.png" alt="iWine"></a> 聯盟行銷</p>
        	
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
                	<legend>聯絡我們</legend>
  					<div class="control-group">
    					<label class="control-label" for="c_name">您的姓名</label>
    					<div class="controls">
      					<input name="c_name" type="text" id="c_name" placeholder="請輸入您的姓名" value="<?php echo $_SESSION['ALLIANCE_NAME']; ?>">
                        <span class="help-inline">*必填</span>
                        <span class="help-stock">
                        <div id="account_check" style="color:#F00"></div></span>
   					  </div>
				  </div>
  					<div class="control-group">
    					<label class="control-label" for="c_tel">您的手機號碼</label>
    					<div class="controls">
      					<input type="text" id="c_tel" name="c_tel" placeholder="請輸入您的手機號碼" value="<?php echo $_SESSION['ALLIANCE_MOBILE']; ?>">
    					</div>
  					</div>
                    <div class="control-group">
    					<label class="control-label" for="c_email">您的E-mail</label>
    					<div class="controls">
      					<input name="c_email" type="text" id="c_email" placeholder="請輸入您的email" value="<?php echo $_SESSION['ALLIANCE_ACCOUNT']; ?>">
                        <span class="help-inline">*必填</span>
    					</div>
  					</div>
                    <div class="control-group">
					  <label class="control-label" for="m_name">聯絡主題</label>
						<div class="controls">
						  <select name="c_class" id="c_class">
						    <option selected="selected">洽詢聯盟行銷資訊</option>
						    <option>洽詢行銷專案資訊</option>
						    <option>洽詢行銷成果資訊</option>
						    <option>給我們的建議</option>
						    <option>其他</option>
					      </select>
						</div>
                    </div>
                    <div class="control-group">
					  <label class="control-label" for="c_cont">聯絡內容</label>
						<div class="controls">
						  <textarea name="c_cont" rows="5" id="c_cont"></textarea>
						  <span class="help-inline">*必填。</span>
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
					  <label class="control-label" for="c_cont"></label>
						<div class="controls">
						  客服時間：週一至週五 09:30~17:30
						</div>   
					</div>
  					
                    <div class="control-group">
    					<div class="controls">
                        <input name="c_datetime" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
      					<button type="button" class="btn btn-danger" onClick="chkcontact();">確定送出</button>
                        <button type="reset" class="btn btn-success">重設</button>
    					</div>
  						</div>
                    <input type="hidden" name="MM_insert" value="form1">
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
      <p style="font-size:12px"><img src="../images/logo2_small.jpg" alt="iWine" style="border-color:#000000; border-width: 1px; border-style:solid">&nbsp;&nbsp;&nbsp;&nbsp;© 2013 iWine . All Rights Reserved</p><p style="font-size:12px">法律顧問：圓方法律事務所</p>
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
    <script language="javascript">
	function chkcontact(){

 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  
  if( $("#c_name").val() ==""){alert('請輸入您的姓名!'); return; }
  if( $("#c_email").val() == "" || !$("#c_email").val().match(myReg)){alert('請輸入您的email!'); return; }
  if( $("#c_cont").val() == ""){alert('請輸入聯絡內容!'); return; }
    
  $("#form1").submit();
}

	function chkmail(){
	
	myReg = /^.+@.+\..{2,3}$/
	if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
	form0.submit();	
		
	}
    </script>
    <script src="../js/chkform.js"></script>
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
