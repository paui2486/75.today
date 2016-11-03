
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
    
    <link rel="shortcut icon" href="assets/ico/123.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<style>
div {
    background-image:url(<?php echo("webimages/xz3.jpg")?>);width:300px;height:200px;
	}
h1 {
    background-image:url(<?php echo("webimages/xz4.jpg")?>);width:300px;height:200px;
	}
h2 {
    background-image:url(<?php echo("webimages/xz2.jpg")?>);width:300px;height:200px;
	}
h3 {
    background-image:url(<?php echo("webimages/xz5.jpg")?>);width:300px;height:200px;
	}
h4 {
    background-image:url(<?php echo("webimages/xz6.jpg")?>);width:300px;height:200px;
	}	
</style>
</head>
<body>
<?php
$i = "2";
if ($i == "1"){
	echo("<div><img src='webimages/靠.svg' alt='靠' align='right'></div>");
	
}else if($i == "2"){
	echo("<h1><img src='webimages/瞎.svg' alt='瞎' align='right'></h1>");
	
}else if($i == "3"){
	echo("<h2><img src='webimages/萌.svg' alt='萌' align='right'></h2>");
	
}else if($i == "4"){
	echo("<h3><img src='webimages/扯.svg' alt='扯' align='right'></h3>");
}
else{echo("幹");}
?>
<!--
<h1><img src="webimages/瞎.svg" alt='瞎' align="right"></h1>
<h2><img src="webimages/萌.svg" alt='萌' align="right"></h2>
<h3><img src="webimages/扯.svg" alt='扯' align="right"></h3>
-->

</body>



