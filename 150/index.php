<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/inc.css" />
<title></title>
</head>
<body>
<table align="center" width="500px" height="407" border="0" background="pic/bg.jpg">
  <tr>
  	 <td height="126">&nbsp;</td>
  </tr>
  <tr>
    <td>
		<div>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="file" name="upfile" size="20" />
			<input class="two"type="submit" name="sub" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" />
		</form>
		</div>
	</td>
  </tr>
</table>
<?php
	if($_POST[sub]){
		if($_FILES['upfile']['name'] == ''){
			echo "<script>alert('上传内容为空');</script>";
		}else{
			$info = $_FILES['upfile'];
			if($info['size'] > 0 && $info['size'] < 1024 * 8000){
				$dir = 'upfiles/';
				$name = $info['name'];
				$rand = rand(0,10000000);
				$name = $rand.date('YmdHis').$name;
				$path = 'upfiles/'.$name;
				if(!is_dir($dir)){
					mkdir($dir);
				}
				$move = move_uploaded_file($info['tmp_name'],$path);
				if($move == true){
					echo "<script>alert('上传文件成功');</script>";
				}
			}else{
				echo "<script>alert('上传文件过大');</script>";	
			}
		}
	}
?>
</body>
</html>
