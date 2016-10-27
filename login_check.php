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
  $_err_url = "login.php";
  go_to($_err_url);
  exit;
}

$colname_member = "-1";
if ($_POST['mem_id'] <> "") {
  $colname_member = $_POST['mem_id'];
}
$colname2_member = "-1";
if (isset($_POST['mem_passwd'])) {
  $colname2_member = md5($_POST['mem_passwd']);
}
mysql_select_db($database_iwine, $iwine);
$query_member = sprintf("SELECT * FROM member WHERE m_account = '%s' AND m_passwd_md5 = '%s'", htmlspecialchars(GetSQLValueString($colname_member, "text")),htmlspecialchars(GetSQLValueString($colname2_member, "text")));
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);

if($totalRows_member == 0){

msg_box('帳號或密碼錯誤，請重新輸入!');
$_err_url = "login.php";
go_to($_err_url);
exit;
}else{

$_mem_id = $row_member['m_id'];	
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



  
$updateSQL = sprintf("UPDATE member SET last_login = '%s' WHERE m_id = '%s'",
                       GetSQLValueString($now_date, "date"),
					   GetSQLValueString($_mem_id, "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result2 = mysql_query($updateSQL, $iwine) or die(mysql_error());
	
// if($row_member['last_modify'] == "" || $now_date >= $_next_modify){
	// msg_box('您的密碼已有一段時間沒有更新了，為了維護您資料的安全性，建議您即刻更新密碼，否則將無法使用會員相關功能喔，謝謝！');
	// $_SESSION['MEM_ID2'] = $row_member['m_id'];
	// go_to('member_pwchange.php');
	// exit;
// }	 
	
	
	 $_SESSION['MEM_ID'] = $row_member['m_id'];
	 $_SESSION['MEM_ACCOUNT'] = $row_member['m_account'];
	 $_SESSION['MEM_NAME'] = $row_member['m_name'];
	 //$_SESSION['MEM_PHONE'] = $row_member['m_phone'];
	 //$_SESSION['MEM_PHONE_CODE'] = $row_member['m_phone_code'];
	 //$_SESSION['MEM_PHONE_EXT'] = $row_member['m_phone_ext'];
	 //$_SESSION['MEM_ZIP'] = $row_member['m_zip'];
	 //$_SESSION['MEM_ADDRESS'] = $row_member['county_name'].$row_member['c_name'].$row_member['m_address'];
	 $_SESSION['MEM_EMAIL'] = $row_member['m_email'];
	 $_SESSION['MEM_MOBILE'] = $row_member['m_mobile'];
	 

	$_message_login = "登入成功！親愛的 ".$row_member['m_name']." 歡迎你～～";
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
