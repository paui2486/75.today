<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>iWine 聯盟行銷</title>
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
                <form action="" method="post" class="form-horizontal" id="form1" >
                	<legend>註冊新會員</legend>
  					<div class="control-group">
    					<label class="control-label" for="m_account">帳 號</label>
    					<div class="controls">
      					<input type="text" id="m_account" name="m_account" placeholder="請輸入e-mail" onblur="checkAccount();">
                        <span class="help-inline">*請輸入您的e-mail，這將會成為您登入的帳號</span>
                        <span class="help-stock"><div id="account_check" style="color:#F00"></div></span>
    					</div>
  					</div>
  					<div class="control-group">
    					<label class="control-label" for="m_passwd">密 碼</label>
    					<div class="controls">
      					<input type="password" id="m_passwd" name="m_passwd" placeholder="請輸入密碼">
                        <span class="help-inline">*請輸入8碼以上的英文或數字</span>
    					</div>
  					</div>
                    <div class="control-group">
    					<label class="control-label" for="m_passwd_confirm">確認密碼</label>
    					<div class="controls">
      					<input type="password" id="m_passwd_confirm" name="m_passwd_confirm" placeholder="請再次輸入密碼">
                        <span class="help-inline">*請再次輸入您的密碼</span>
    					</div>
  					</div>
                    <div class="control-group">
						<label class="control-label" for="m_name">姓 名</label>
						<div class="controls">
						<input id="m_name" name="m_name" type="text" placeholder="請輸入姓名">
                        <span class="help-inline">*請輸入您的中文或英文姓名</span>
						</div>
                    </div>
                    <div class="control-group">
						<label class="control-label" for="m_mobile">手 機</label>
						<div class="controls">
						<input id="m_mobile" name="m_mobile" type="text" placeholder="請輸入手機號碼">
                        <span class="help-inline">*輸入格式如：0988123789</span>
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
                        <label class="checkbox">
        					<input type="checkbox" id="m_permission" name="m_permission"> 我已閱讀並同意 iWine聯盟行銷之<a href="law.php">相關條款</a> </label>
                        <input name="check_form" type="hidden" value="Y">
      					<button type="button" class="btn btn-danger" onClick="chkform();">確定註冊</button>
                        <button type="reset" class="btn btn-success">重設</button>
    					</div>
  						</div>
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
    <script src="../js/chkform_alliance.js"></script>
    <script language="javascript">
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
