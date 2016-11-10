<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>合理定義上傳文件的名稱</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="830" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><img src="images/bg_01.jpg" width="830" height="133" /></td>
  </tr>
   <form action="" method="post" enctype="multipart/form-data">
  <tr>
    <td width="193" rowspan="4">&nbsp;</td>
    <td width="423" height="50">選擇上傳文件：
 	  <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" /> 
      <input type="file" name="up_picture"/> 
    </td>
    <td width="214" rowspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="center"><span class="STYLE1">上傳圖片大小為（2M）</span></td>
  </tr>
  <tr>
    <td height="50" align="center"><input type="image" name="imageField2" src="images/bg_09.jpg" />      &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="image" name="imageField3" src="images/bg_11.jpg" /></td></tr>
    </form>
  <tr>
    <td height="70">
<?php
if(!empty($_FILES[up_picture][name])){		//判斷上傳內容是否為空
	if($_FILES['up_picture']['error']>0){		//判斷文件是否可以上傳到服務器
		echo "上传错误:";
		switch($_FILES['up_picture']['error']){
			case 1:
				echo "上傳文件大小超出配置文件規定值";
			break;
			case 2:
				echo "上傳文件大小超出表單中約定值";
			break;
			case 3:
				echo "上傳文件不全";
			break;
			case 4:
				echo "沒有上傳文件";
			break;	
		}
	}else{
		if(!is_dir("./upfile/")){				//判斷指定目錄是否存在
			mkdir("./upfile/");					//創建目錄
		}
		$path='./upfile/'.rand().time().strstr($_FILES['up_picture']['name'],".");		//定義上傳文件名稱和存儲位置
		if(is_uploaded_file($_FILES['up_picture']['tmp_name'])){	//判斷文件是否是HTTP POST上傳
			if(!move_uploaded_file($_FILES['up_picture']['tmp_name'],$path)){	//執行上傳操作
				echo "上傳失敗";
			}else{
				echo "文件".$_FILES['up_picture']['name']."上傳成功，大小為：".$_FILES['up_picture']['size'];	
			}
		}else{
			echo "上傳文件".$_FILES['up_pictute']['name']."不合法！";
		}
	}
}
?></td>
  </tr>
  <tr>
    <td colspan="3"><img src="images/bg_14.jpg" width="830" height="30" /></td>
  </tr>
</table>
</body>
</html>



