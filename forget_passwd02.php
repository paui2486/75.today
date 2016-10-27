<?php session_start(); ?>
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
    <div class="container">
      <?php include('header.php'); ?>
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
                <form action="member_pwd_check.php" method="post" class="form-horizontal" id="form1">
                	<legend class="title"><img src="images/wine_icon1.png" width="49" height="49">忘記密碼</legend>
  					<div class="control-group">
  					  <label class="control-label" for="inputEmail">廠商類別</label>
  					  <div class="controls">
				      <input type="radio" name="radio" id="radio" value="radio">
				      酒商 
				      <input type="radio" name="radio" id="radio2" value="radio">
				      酒館<br>
  					</div>
				  </div>
  					<div class="control-group">
   					  <label class="control-label" for="inputEmail">帳 號</label>
    					<div class="controls">
      					<input name="m_account" type="text" id="m_account" placeholder="請輸入e-mail">
                        <span class="help-inline">*請輸入註冊時所填寫的e-mail帳號</span>
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
      					<button type="submit" class="btn btn-primary">取得密碼</button>
                        <button type="button" class="btn btn-success"><a href="login.php" style="color:#FFF">重新登入</a></button>
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
		width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
	});
}); 
</script>
