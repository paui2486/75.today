<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
 <meta charset="utf-8">
 <title>iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
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

<div class="container">
    <!--menu-->

<div class="row container-area"><a href="www.iwine.com.tw"><img src="images/logo_small.png"></a></div>

     <!--  menu-end-->     
      
    <!--  付款條件KV-->
 <div class="row container-area">
<div id="MainContent" class="span12">
          <div class="row">
 <div class="span12">
<img src="images/terms_of_payment.png"></div>
            
          </div>
          
    </div>
  </div>
      <!--  付款條件-KV-END-->
  
 
 
    
  <!-- footer-end-->
</div> 
<?php include('footer.php'); ?>
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
