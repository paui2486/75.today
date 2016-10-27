<?php session_start(); ?>
<?php
include('../func/func.php');
?>
<?php
include_once '../securimage/securimage.php';
$securimage = new Securimage();
?>
<?php require_once('../Connections/iwine.php'); ?>
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
$query_member = sprintf("SELECT * FROM alliance_member WHERE am_account = '%s' AND am_passwd = '%s'", htmlspecialchars(GetSQLValueString($colname_member, "text")),htmlspecialchars(GetSQLValueString($colname2_member, "text")));
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);

if($totalRows_member == 0){

msg_box('帳號或密碼錯誤，請重新輸入!');
$_err_url = "login.php";
go_to($_err_url);
exit;
}else{

$_mem_id = $row_member['am_id'];	
$now_date = date('Y-m-d H:i:s');
$client_ip = get_client_ip();

if($row_member['am_last_modify'] == ""){
	$latest_modify_stamp = strtotime('2000-02-01 00:00:00');
}else{
	$latest_modify_stamp = strtotime($row_member['am_last_modify']);
}

$dist_time = "+3 month";
$d = strtotime($dist_time,$latest_modify_stamp);
$_next_modify = date('Y-m-d H:i:s',$d);	



  
$updateSQL = sprintf("UPDATE alliance_member SET am_last_login_datetime = '%s', am_last_login_ip = '$client_ip', am_last_login_times = am_last_login_times + 1 WHERE am_id = '%s'",
                       GetSQLValueString($now_date, "date"),
					   GetSQLValueString($_mem_id, "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result2 = mysql_query($updateSQL, $iwine) or die(mysql_error());
	
	if($row_member['am_last_modify'] == "" || $now_date >= $_next_modify){
	msg_box('您的密碼已有一段時間沒有更新了，為了維護您資料的安全性，建議您即刻更新密碼，否則將無法使用會員相關功能喔，謝謝！');
	$_SESSION['ALLIANCE_ID2'] = $row_member['am_id'];
	go_to('member_pwchange.php');
	exit;
}	 
	
	
	 $_SESSION['ALLIANCE_ID'] = $row_member['am_id'];
	 $_SESSION['ALLIANCE_ACCOUNT'] = $row_member['am_account'];
	 $_SESSION['ALLIANCE_NAME'] = $row_member['am_name'];
	 $_SESSION['ALLIANCE_CODE'] = $row_member['am_code'];
	 //$_SESSION['ALLIANCE_PHONE_CODE'] = $row_member['m_phone_code'];
	 //$_SESSION['ALLIANCE_PHONE_EXT'] = $row_member['m_phone_ext'];
	 //$_SESSION['ALLIANCE_ZIP'] = $row_member['m_zip'];
	 //$_SESSION['ALLIANCE_ADDRESS'] = $row_member['county_name'].$row_member['c_name'].$row_member['m_address'];
	 $_SESSION['ALLIANCE_EMAIL'] = $row_member['am_email'];
	 $_SESSION['ALLIANCE_MOBILE'] = $row_member['am_mobile'];
	 $_SESSION['ALLIANCE_RATIO'] = $row_member['am_ratio'];
	 $_SESSION['ALLIANCE_LAST_SUM_DATE'] = $row_member['am_last_sum_date'];

	 
	//msg_box('登入成功');
	
	//if($_POST['page']<>""){
	//    $_url = $_POST['page'];
	//}else{
		$_url = "myorder.php";
	//}
	
	go_to($_url);
	exit;
}

mysql_free_result($member);
?>
