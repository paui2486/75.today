<?php session_start(); 
include('func/func.php');
if(isset($_SESSION['MEM_TYPE'])){
    go_to('symposium_upload_simple.php');
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
              <h3><img src="images/wine_icon1.png" width="35" height="35"> <span class="title">合作夥伴登入專區</span></h3><img src="images/line03.png" width="1000"><br>
              <form action="login_check_b.php" method="post" class="form-horizontal" name="form1" id="form1">
                
                <div class="control-group">
                        <label class="control-label" for="mem_type">請選擇您的身分別</label>
                        <div class="controls">
                        <input type="radio" id="type_expert" name="type" value="expert"> 達人
                        <input type="radio" id="type_bar" name="type" value="bar"> 酒吧
                        <input type="radio" id="type_supplier" name="type" value="supplier"> 酒商
                        <span class="help-inline">登入前請您先選擇身分別喔。</span>
                        </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" for="account">帳 號</label>
                        <div class="controls">
                        <input type="text" id="account" name="account" placeholder="請輸入e-mail" onBlur="checkAccount();">
                        <span class="help-inline">首次參加合作夥伴<span class="point">請先註冊</span></span>
                        <div class="register_type">
                            <a href="regist_expert.php" class="btn btn-success">達人註冊</a>
                            <a href="regist_bar_simple.php" class="btn btn-success">酒吧註冊</a>
                            <a href="regist_supplier_simple.php" class="btn btn-success">酒商註冊</a>
                          </div>
                        </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" for="password">密 碼</label>
                      <div class="controls">
                        <input type="password" id="password" name="password" placeholder="請輸入密碼">
                        <span class="help-inline">忘記密碼？<a href="forget_passwd_b.php">請點我</a></span>
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
                        <button type="submit" class="btn btn-primary" id="submit">登 入</button>
                        
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
		height:		   '250px',
		width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
	});
}); 
</script>
