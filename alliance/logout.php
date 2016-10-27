<?php 
session_start();
$_SESSION['login']=false;
session_destroy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Logout</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script type="text/javascript">
function addBookmarkForBrowser(sTitle, sUrl){

        if (window.sidebar && window.sidebar.addPanel) {
            addBookmarkForBrowser = function(sTitle, sUrl) {
                window.sidebar.addPanel(sTitle, sUrl, "");
            }
        } else if (window.external) {
            addBookmarkForBrowser = function(sTitle, sUrl) {
                window.external.AddFavorite(sUrl, sTitle);
            }
        } else {
            addBookmarkForBrowser = function() {
                alert("do it yourself");
            }
        }

        return addBookmarkForBrowser(sTitle, sUrl);
}
</script>
</head>

<body onLoad="MM_popupMsg('您已登出聯盟行銷會員！');MM_goToURL('parent','index.php');return document.MM_returnValue">
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
