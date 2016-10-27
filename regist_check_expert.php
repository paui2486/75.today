<?php
session_start();
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
  $_err_url = "regist_expert.php";
  go_to($_err_url);
  exit;
}

$colname_member_check = "-1";
if (isset($_POST['account'])) {
  $colname_member_check = trim($_POST['account']);
}
mysql_select_db($database_iwine, $iwine);
$query_member_check = sprintf("SELECT * FROM expert WHERE account = '%s'", GetSQLValueString($colname_member_check, "text"));
// echo "query_member_check = <font color=red>".$query_member_check."</font><br>";
$member_check = mysql_query($query_member_check, $iwine) or die(mysql_error());
$row_member_check = mysql_fetch_assoc($member_check);
$totalRows_member_check = mysql_num_rows($member_check);
// echo "totalRows_member_check = ".$totalRows_member_check."<br>";
if($totalRows_member_check > 0){
    msg_box('此E-mail帳號已被註冊過，請使用其他E-mail重新註冊！');
    go_to('regist_expert.php');
    exit;
}
    


$_today = date('Y-m-d H:i:s'); 

if($_POST['check_form'] == "Y"){ 

 $insertSQL = sprintf("INSERT INTO expert (account, password_md5, last_login ) 
                    VALUES ('%s', '%s', '%s')",
                       GetSQLValueString(trim($_POST['account']), "text"),
                       GetSQLValueString(md5($_POST['password']), "text"),
                       GetSQLValueString($_today, "date"));
  //echo "insertSQL = <br><b><font color=pink>".$insertSQL."</font></b><br>";
  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  $_new_m_id = mysql_insert_id();
  // echo "_new_m_id = <b><font color=pink>".$_new_m_id."</font></b><br>";
//設定成已登入狀態

mysql_select_db($database_iwine, $iwine);
$query_member = "SELECT * FROM expert WHERE id = '".$_new_m_id."'";
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);
// echo "totalRows_member = ".$totalRows_member."<br>";

     $_SESSION['MEM_TYPE'] = 'expert';
     $_SESSION['BMEM_ID'] = $row_member['id'];
     $_SESSION['BMEM_ACCOUNT'] = $row_member['account'];
     $_SESSION['BMEM_NAME'] = $row_member['name'];
     //$_SESSION['MEM_PHONE'] = $row_member['m_phone'];
     //$_SESSION['MEM_PHONE_CODE'] = $row_member['m_phone_code'];
     //$_SESSION['MEM_PHONE_EXT'] = $row_member['m_phone_ext'];
     //$_SESSION['MEM_ZIP'] = $row_member['m_zip'];
     //$_SESSION['MEM_ADDRESS'] = $row_member['county_name'].$row_member['c_name'].$row_member['m_address'];
     $_SESSION['BMEM_EMAIL'] = $row_member['account'];
     // $_SESSION['BMEM_TEL'] = $row_member['telphone'];
     //$_SESSION['MEM_BUY'] = $row_member['ever_buy'];
     $sess_id = session_id();

     msg_box('您的資料已經送出，\n歡迎您的加入!'); 
  
//寄送會員加入信  

require_once('PHPMailer/class.phpmailer.php');
$mail = new PHPMailer(); // defaults to using php "mail()"

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
        <td><p>親愛的 達人會員您好：</p>
          <p> 感謝您加入成為本網站合作夥伴，請妥善保管本信，內含個人會員資訊！</p>
          <p>您申請的身分別是： 達人會員，登入時請選擇酒吧身分別。</p>
          <p>您的帳號是： ".$_POST['account']."（您的E-mail）</p>
          <p>您的密碼是：".$_POST['password']."</p></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
";

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


//$mail->AddReplyTo("iwine.tw@gmail.com","命運好好玩");

$address = $row_member['account'];
$mail->AddAddress($address, $_POST['name']);

$mail->Subject    = "iWine加入會員通知信";

$mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->CharSet="utf-8";

$mail->Encoding = "base64";
//設置郵件格式為HTML
$mail->IsHTML(true);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

    if($mail->Send()) {
        go_to('index.php');
    }
    //信件寄送結束
      
}

mysql_free_result($member);
mysql_free_result($member_check);
?>