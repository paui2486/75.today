<?php require_once('Connections/iwine.php'); ?>
<?php
include('func/func.php');
?>
<?php
include_once 'securimage/securimage.php';
$securimage = new Securimage();
?>
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
  $_err_url = "forget_passwd.php";
  go_to($_err_url);
  exit;
}

$colname_Account = "-1";
if (isset($_POST['m_account'])) {
  $colname_Account = trim($_POST['m_account']);
}
mysql_select_db($database_iwine, $iwine);
$query_Account = sprintf("SELECT * FROM member WHERE m_account = '%s'", htmlspecialchars(GetSQLValueString($colname_Account, "text")));
$Account = mysql_query($query_Account, $iwine) or die(mysql_error());
$row_Account = mysql_fetch_assoc($Account);
$totalRows_Account = mysql_num_rows($Account);

if($totalRows_Account == 0){
	msg_box('查無資料，請重新輸入!');
	go_to(-1);
	exit;
}

//$random預設為10，更改此數值可以改變亂數的位數
$random=12;
//FOR回圈以$random為判斷執行次數
for ($i=1;$i<=$random;$i=$i+1)
{
//亂數$c設定三種亂數資料格式大寫、小寫、數字，隨機產生
$c=rand(1,3);
//在$c==1的情況下，設定$a亂數取值為97-122之間，並用chr()將數值轉變為對應英文，儲存在$b
if($c==1){$a=rand(97,122);$b=chr($a);}
//在$c==2的情況下，設定$a亂數取值為65-90之間，並用chr()將數值轉變為對應英文，儲存在$b
if($c==2){$a=rand(65,90);$b=chr($a);}
//在$c==3的情況下，設定$b亂數取值為0-9之間的數字
if($c==3){$b=rand(0,9);}
//使用$randoma連接$b
$randoma=$randoma.$b;
}
//輸出$randoma每次更新網頁你會發現，亂數重新產生了
//echo $randoma;


//設定新密碼
$_passwd_md5 = md5($randoma);
$_passwd_id = $row_Account['m_id'];

$insertSQL = sprintf("UPDATE member SET m_passwd_md5 = '%s' WHERE m_id = '%s'",
                       GetSQLValueString($_passwd_md5, "text"),
					   GetSQLValueString($_passwd_id, "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());

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
    <td height=\"150\" align=\"center\" valign=\"middle\"><table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
      <tr>
        <td><p>親愛的 ".$row_Account['m_name']." 會員 您好：</p>
          <p> 以下是系統為您重新設定的密碼資料（大小寫視為不同），請先以此密碼登入後，再進入『資料修改』重新設定您自己熟悉的密碼，謝謝！</p>
          <p>您的新密碼是：<span color=\"red\">".$randoma."</span>(大小寫視為不同）</p></td>
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

$address = $row_Account['m_email'];
$mail->AddAddress($address, $row_Account['m_name']);

$mail->Subject    = "iWine 密碼通知信";

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
	//echo "密碼信寄送中~~";
	msg_box('已為您寄上新密碼，請至當初註冊會員時所使用的信箱收取密碼信，謝謝！');
	go_to('login.php');
	exit;
}




mysql_free_result($Account);
?>
