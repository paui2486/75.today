<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�����x�ς��ļ������Q</title>
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
    <td width="423" height="50">�x���ς��ļ���
 	  <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" /> 
      <input type="file" name="up_picture"/> 
    </td>
    <td width="214" rowspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="center"><span class="STYLE1">�ς��DƬ��С�飨2M��</span></td>
  </tr>
  <tr>
    <td height="50" align="center"><input type="image" name="imageField2" src="images/bg_09.jpg" />      &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="image" name="imageField3" src="images/bg_11.jpg" /></td></tr>
    </form>
  <tr>
    <td height="70">
<?php
if(!empty($_FILES[up_picture][name])){		//�Д��ς������Ƿ���
	if($_FILES['up_picture']['error']>0){		//�Д��ļ��Ƿ�����ς���������
		echo "�ϴ�����:";
		switch($_FILES['up_picture']['error']){
			case 1:
				echo "�ς��ļ���С���������ļ�Ҏ��ֵ";
			break;
			case 2:
				echo "�ς��ļ���С��������мs��ֵ";
			break;
			case 3:
				echo "�ς��ļ���ȫ";
			break;
			case 4:
				echo "�]���ς��ļ�";
			break;	
		}
	}else{
		if(!is_dir("./upfile/")){				//�Д�ָ��Ŀ��Ƿ����
			mkdir("./upfile/");					//����Ŀ�
		}
		$path='./upfile/'.rand().time().strstr($_FILES['up_picture']['name'],".");		//���x�ς��ļ����Q�ʹ惦λ��
		if(is_uploaded_file($_FILES['up_picture']['tmp_name'])){	//�Д��ļ��Ƿ���HTTP POST�ς�
			if(!move_uploaded_file($_FILES['up_picture']['tmp_name'],$path)){	//�����ς�����
				echo "�ς�ʧ��";
			}else{
				echo "�ļ�".$_FILES['up_picture']['name']."�ς��ɹ�����С�飺".$_FILES['up_picture']['size'];	
			}
		}else{
			echo "�ς��ļ�".$_FILES['up_pictute']['name']."���Ϸ���";
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



