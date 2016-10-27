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
            <h4>最新訊息</h4>
              <div>
              <table width="100%" border="1" cellspacing="1" cellpadding="5" style="border:#000000">
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
              </table>
              <p>&nbsp;</p>               
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
