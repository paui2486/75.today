<?php
session_start();
include('func/func.php');
include('ga.php');
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
  $_err_url = "regist.php";
  go_to($_err_url);
  exit;
}

$colname_member_check = "-1";
if (isset($_POST['m_account'])) {
  $colname_member_check = trim($_POST['m_account']);
}
mysql_select_db($database_iwine, $iwine);
$query_member_check = sprintf("SELECT * FROM member WHERE m_account = '%s'", GetSQLValueString($colname_member_check, "text"));
$member_check = mysql_query($query_member_check, $iwine) or die(mysql_error());
$row_member_check = mysql_fetch_assoc($member_check);
$totalRows_member_check = mysql_num_rows($member_check);

if($totalRows_member_check > 0){
	msg_box('此E-mail帳號已被註冊過，請使用其他E-mail重新註冊！');
	go_to('regist.php');
	exit;
}
	


$_today = date('Y-m-d H:i:s'); 

if($_POST['check_form'] == "Y"){ 

 $insertSQL = sprintf("INSERT INTO member (m_account, m_passwd_md5, m_name, m_year, m_month, m_day, m_mobile, m_zip, m_county, m_city, m_address, m_email, m_edm, regist_date, last_login, last_modify) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       GetSQLValueString(trim($_POST['m_account']), "text"),
                       GetSQLValueString(md5($_POST['m_passwd']), "text"),
                       GetSQLValueString($_POST['m_name'], "text"),
					   GetSQLValueString($_POST['m_year'], "int"),
					   GetSQLValueString($_POST['m_month'], "int"),
					   GetSQLValueString($_POST['m_day'], "int"),
					   GetSQLValueString($_POST['m_mobile'], "text"),
					   GetSQLValueString($_POST['zipcode'], "text"),
					   GetSQLValueString($_POST['county'], "text"),
					   GetSQLValueString($_POST['district'], "text"),
					   GetSQLValueString($_POST['m_address'], "text"),
                       GetSQLValueString($_POST['m_account'], "text"),
                       GetSQLValueString(isset($_POST['m_edm']) ? "Y" : "N", "defined","'Y'","'N'"),
                       GetSQLValueString($_today, "date"),
					   GetSQLValueString($_today, "date"),
					   GetSQLValueString($_today, "date"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  $_new_m_id = mysql_insert_id();
  
//設定成已登入狀態
mysql_select_db($database_iwine, $iwine);
$query_member = "SELECT * FROM member WHERE m_id = '".$_new_m_id."'";
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);

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
	 //$_SESSION['MEM_BUY'] = $row_member['ever_buy'];
	 $sess_id = session_id();
	 
	 msg_box('您的資料已經送出，\n歡迎您的加入!'); 
  
//寄送會員加入信  

require_once('PHPMailer/class.phpmailer.php');
$mail             = new PHPMailer(); // defaults to using php "mail()"

$body             = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title></title>
</head>

<body>
<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td height=\"150\" align=\"center\" valign=\"middle\" background=\"http://www.iwine.com.tw/images/mail_bg.gif\"><table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
      <tr>
        <td><p>親愛的 ".$_POST['m_name']." 您好：</p>
          <p> 感謝您加入成為本網站會員，請妥善保管本信，內含個人會員資訊！</p>
          <p>您的帳號是： ".$_POST['m_account']."（您的E-mail）</p>
          <p>您的密碼是：".$_POST['m_passwd']."</p></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
";

/*
$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "ms.mailcloud.com.tw"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
//$mail->SMTPSecure = "ssl";
$mail->Host       = "ms.mailcloud.com.tw"; // sets the SMTP server
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = "admin@hudong.tv"; // SMTP account username
$mail->Password   = "@#mjn0405";        // SMTP account password


$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "210.242.250.119"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
//$mail->SMTPSecure = "ssl";
$mail->Host       = "210.242.250.119"; // sets the SMTP server
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = "service"; // SMTP account username
$mail->Password   = "coevo27460111";        // SMTP account password
*/
$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host       = "200.200.200.50"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";
$mail->Host       = "smtp.gmail.com"; // sets the SMTP server
$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
// $mail->Username   = "service@iwine.today"; // SMTP account username
// $mail->Password   = "iwine2014";        // SMTP account password

$mail->Username   = "service@iwine.com.tw"; // SMTP account username
$mail->Password   = "service53118909";        // SMTP account password
$mail->AddReplyTo("service@iwine.com.tw","iWine");
$mail->SetFrom('service@iwine.com.tw',"iWine");

$address = $row_member['m_email'];
$mail->AddAddress($address, $_POST['m_name']);

$mail->Subject    = "iWine加入會員通知信";

$mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->CharSet="utf-8";

$mail->Encoding = "base64";
//設置郵件格式為HTML
$mail->IsHTML(true);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	//echo "加入會員通知信寄送中~~";
	//if($_POST['page']==""){
	go_to('newgroup.php');
	//}else{
	//go_to($_POST['page']);
	//}
}
//信件寄送結束
  
}

mysql_free_result($member);

mysql_free_result($member_check);
?>