
<head>
<style>

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
#Z1 {
position:absolute;
z-index:1;
}
#Z2 {
position:relative;top:15px;right:10px;
z-index:2;	
}
</style>
</head>
<body>
<?php 
$i = 1; 
$r = 0;
$x = 2;
function emjoi($x){
	if($x == "1"){
		$x = "靠.svg";
		return $x;
	}elseif($x == "2"){
		$x = "瞎.svg";
		return $x;
	}elseif($x == "3"){
		$x = "扯.svg";
		return $x;
	}elseif($x == "4"){
		$x = "萌.svg";
		return $x;
	}elseif($x == "5"){
		$x = "幹.svg";
		return $x;
	}else{}
	
	
				}
	echo emjoi($x);	
?>

<div id='Z1'><img src="http://75.today/web/webimages/xz5.jpg" alt="e04"></div>
<?php if($i == "1"){ echo('<div id="Z2"><img src="http://75.today/web/webimages/'.emjoi($x).'" alt="'.emjoi($x).'"></div>');
	}else{echo("NULL");}?>

</body>



