<?php session_start(); ?>
<?php
include('func/func.php');
?>
<?php
include_once 'securimage/securimage.php';
$securimage = new Securimage();
?>
<?php require_once('Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ($securimage->check($_POST['capacha_code']) == false) {
  msg_box('驗證碼錯誤,請重新輸入!');
  $_err_url = "login_b.php";
  go_to($_err_url);
  exit;
}
if($_POST['type']==""){
  msg_box('請選擇都入身分別!');
  $_err_url = "login_b.php";
  go_to($_err_url);
  exit;
}
if($_POST['capacha_code'])
$colname_member = "-1";
if ($_POST['account'] <> "") {
  $colname_member = $_POST['account'];
}
$colname2_member = "-1";
if (isset($_POST['password'])) {
  $colname2_member = md5($_POST['password']);
}
mysql_select_db($database_iwine, $iwine);
if ($_POST['type']=="expert"){
    $query_member = sprintf("SELECT * FROM expert WHERE account = '%s' AND password_md5 = '%s'", htmlspecialchars(GetSQLValueString($colname_member, "text")),htmlspecialchars(GetSQLValueString($colname2_member, "text")));
}else if ($_POST['type']=="bar"){
    $query_member = sprintf("SELECT * FROM bar WHERE account = '%s' AND password_md5 = '%s'", htmlspecialchars(GetSQLValueString($colname_member, "text")),htmlspecialchars(GetSQLValueString($colname2_member, "text")));
}else if($_POST['type']=="supplier"){
    $query_member = sprintf("SELECT * FROM wine_supplier WHERE account = '%s' AND password_md5 = '%s'", htmlspecialchars(GetSQLValueString($colname_member, "text")),htmlspecialchars(GetSQLValueString($colname2_member, "text")));
}
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);

if($totalRows_member == 0){

    msg_box('帳號或密碼錯誤，請重新輸入!');
    $_err_url = "login_b.php";
    go_to($_err_url);
    exit;
}else{
    $_mem_id = $row_member['id'];	
    $now_date = date('Y-m-d H:i:s');
    $client_ip = get_client_ip();

    if($row_member['last_modify'] == ""){
        $latest_modify_stamp = strtotime('2000-02-01 00:00:00');
    }else{
        $latest_modify_stamp = strtotime($row_member['last_modify']);
    }

    $dist_time = "+3 month";
    $d = strtotime($dist_time,$latest_modify_stamp);
    $_next_modify = date('Y-m-d H:i:s',$d);	


if ($_POST['type']=="expert"){
    $updateSQL = sprintf("UPDATE expert SET last_login = '%s' WHERE id = '%s'",GetSQLValueString($now_date, "date"),GetSQLValueString($_mem_id, "int"));
}else if ($_POST['type']=="bar"){
    $updateSQL = sprintf("UPDATE bar SET last_login = '%s' WHERE id = '%s'",GetSQLValueString($now_date, "date"),GetSQLValueString($_mem_id, "int"));
}else if($_POST['type']=="supplier"){
    $updateSQL = sprintf("UPDATE wine_supplier SET last_login = '%s' WHERE id = '%s'",GetSQLValueString($now_date, "date"),GetSQLValueString($_mem_id, "int"));
}
  mysql_select_db($database_iwine, $iwine);
  $Result2 = mysql_query($updateSQL, $iwine) or die(mysql_error());
	
	// if($row_member['last_modify'] == "" || $now_date >= $_next_modify){
	// msg_box('您的密碼已有一段時間沒有更新了，為了維護您資料的安全性，建議您即刻更新密碼，否則將無法使用會員相關功能喔，謝謝！');
	// $_SESSION['MEM_ID2'] = $row_member['m_id'];
	// go_to('member_pwchange.php');
	// exit;
// }	 
	if ($_POST['type']=="expert"){
        $_SESSION['MEM_TYPE'] = "expert";
    }else if ($_POST['type']=="bar"){
        $_SESSION['MEM_TYPE'] = "bar";
    }else if($_POST['type']=="supplier"){
        $_SESSION['MEM_TYPE'] = 'wine_supplier';
    }
	 
	 $_SESSION['BMEM_ID'] = $row_member['id'];
	 $_SESSION['BMEM_ACCOUNT'] = $row_member['account'];

	 $_SESSION['BMEM_NAME'] = $row_member['company_name'];
	 //$_SESSION['MEM_PHONE'] = $row_member['m_phone'];
	 //$_SESSION['MEM_PHONE_CODE'] = $row_member['m_phone_code'];
	 //$_SESSION['MEM_PHONE_EXT'] = $row_member['m_phone_ext'];
	 //$_SESSION['MEM_ZIP'] = $row_member['m_zip'];
	 //$_SESSION['MEM_ADDRESS'] = $row_member['county_name'].$row_member['c_name'].$row_member['m_address'];
	 $_SESSION['BMEM_EMAIL'] = $row_member['email'];
	 $_SESSION['BMEM_TEL'] = $row_member['telphone'];
	 

	$_message_login = "登入成功！親愛的 ".$row_member['company_name']." 歡迎你～～";
	msg_box($_message_login);
	
	if($_SESSION['page']<>""){
	    $_url = $_SESSION['page'];
	}else{
		$_url = "index.php";
	}
	
	go_to($_url);
	exit;
}

mysql_free_result($member);
?>
