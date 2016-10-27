<?php //include('session_check.php'); 
session_start();
include('func/func.php');

include_once 'securimage/securimage.php';
$securimage = new Securimage();
require_once('Connections/iwine.php'); 

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6){
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
if(isset($_POST['password'])){
    // if ($securimage->check($_POST['capacha_code']) == false) {
        // msg_box('驗證碼錯誤,請重新輸入!');
        // $_err_url = "modpass_b.php";
        // go_to($_err_url);
        // exit;
    // }
    if((!isset($_SESSION['MEM_TYPE'])) || $_SESSION['MEM_TYPE']=='member' ){
        msg_box('請登入合作夥伴會員');
        $_err_url = "login_b.php";
        go_to($_err_url);
        exit;
    }
      $_today = date('Y-m-d H:i:s');
      if($_SESSION['MEM_TYPE']=='expert'){
        $updateSQL = sprintf("UPDATE expert SET password_md5='%s' WHERE account='%s'",
                           htmlspecialchars(GetSQLValueString(md5($_POST['new_password']), "text")),
                           htmlspecialchars(GetSQLValueString($_SESSION['BMEM_ACCOUNT'], 'text')));
      }else if($_SESSION['MEM_TYPE']=='bar'){
            $updateSQL = sprintf("UPDATE bar SET password_md5='%s', mod_time='%s' WHERE account='%s'",
                           htmlspecialchars(GetSQLValueString(md5($_POST['new_password']), "text")),
                           htmlspecialchars(GetSQLValueString($_today, "date")),
                           htmlspecialchars(GetSQLValueString($_SESSION['BMEM_ACCOUNT'], 'text')));
        }else if($_SESSION['MEM_TYPE']=='wine_supplier'){
            $updateSQL = sprintf("UPDATE wine_supplier SET password_md5='%s', mod_time='%s' WHERE account='%s'",
                           htmlspecialchars(GetSQLValueString(md5($_POST['new_password']), "text")),
                           htmlspecialchars(GetSQLValueString($_today, "date")),
                           htmlspecialchars(GetSQLValueString($_SESSION['BMEM_ACCOUNT'], 'text')));
        }
      mysql_select_db($database_iwine, $iwine);
      $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
      
      msg_box('密碼修改成功！請重新登入～謝謝！');
      $_SESSION['login']=false;
      session_destroy();
      go_to('login_b.php');
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
    .memo { color: #FF0000;
}
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
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" id="form1">
                    <legend class="title"><img src="images/wine_icon1.png" width="49" height="49">合作夥伴修改密碼<span class="hero-unit02" style="border: solid 0px #000000; margin-bottom: 5px; padding: 5px; background-image: url(images/bg2.png); color: #FF0000;">(*號為必填欄位)</span></legend>
                    <!--div class="control-group">
                      <label class="control-label" for="type"><span class="memo">*</span>廠商類別</label>
                      <div class="controls">
                      <input type="radio" name="type" id="bar" value="bar">
                      酒館
                      <input type="radio" name="type" id="supplier" value="supplier">
                      酒商<br>
                    </div>
                  </div-->
                    <div class="control-group">
                      <label class="control-label" for="password"><span class="memo">*</span>舊密碼</label>
                        <div class="controls">
                        <input name="password" type="password" id="password">
                        </div>
                  </div>
                    <div class="control-group">
                      <label class="control-label" for="new_pwd"><span class="memo">*</span>新密碼</label>
                      <div class="controls">
                        <input name="new_password" type="password" id="new_password" />
                        <br>
                      </div>
                    </div>
                  <div class="control-group">
                      <label class="control-label" for="new_pwd_confirm"><span class="memo">*</span>新密碼確認</label>
                      <div class="controls">
                        <input name="new_password2" type="password" id="new_password2" />
                        <br>
                      </div>
                    </div>
                   <div class="control-group">
                        <div class="controls">
                          <input name="check_form" type="hidden" value="Y">
                        <button type="button" class="btn btn-danger" onClick="chkform();">確定修改</button>
                        <button type="reset" class="btn btn-success">重設</button>
                        </div>
                  </div>
                </form>
                
              </div>
            </div>
            
          </div>
          
        </div>
        <div class="span3" id="LeftContent" align="center">
        <?php include('ad_1.php'); ?>
        </div>
      </div>
      
      
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
    <script language="javascript">
    function chkform(){

 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  if( $("input[name='type']:checked").val() ==""){alert('請選擇廠商類別'); return; }
  if( $("#password").val() == ""){alert('請輸入密碼!'); return; }
  if( $("#new_password").val().length < 6 ){alert('請輸入6字元以上的密碼'); return;  }
  if( $("#new_password2").val() == ""){alert('請輸入新密碼確認!'); return; }
  if( $("#new_password").val() != $("#new_password2").val() ){alert('新密碼與新密碼確認不一致，請重新輸入!'); return; }
  
  
  if(window.confirm('是否確定修改密碼?')){
  $("#form1").submit();
  }else{ return; }
}
    </script>
  </body>
</html>
<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#slideshow').cycle({
        autostop:           false,     // true to end slideshow after X transitions (where X == slide count) 
        fx:             'fade,',// name of transition effect 
        pause:          false,     // true to enable pause on hover 
        randomizeEffects:   true,  // valid when multiple effects are used; true to make the effect sequence random 
        speed:          1000,  // speed of the transition (any valid fx speed value) 
        sync:           true,     // true if in/out transitions should occur simultaneously 
        timeout:        5000,  // milliseconds between slide transitions (0 to disable auto advance) 
        fit:            true,
        width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
    });
}); 
</script>
