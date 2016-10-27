<?php require_once('Connections/iwine.php'); 
include('func/func.php');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
<body>


<p>詢問單處理中....請不要點選重新整理或回上一頁！</p>
<?php

//echo "洽詢單處理中....請不要點選重新整理或回上一頁....";
//<!--p align="center"><img src="images/in_progress.jpg" width="365" height="419" /></p-->
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

$colname_ORDER_LIST = "-1";
if (isset($_GET['ord_code'])) {
  $colname_ORDER_LIST = $_GET['ord_code'];
}
mysql_select_db($database_iwine, $iwine);
$query_ORDER_LIST = sprintf("SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE ord_code = '%s'", GetSQLValueString($colname_ORDER_LIST, "text"));
$ORDER_LIST = mysql_query($query_ORDER_LIST, $iwine) or die(mysql_error());
$row_ORDER_LIST = mysql_fetch_assoc($ORDER_LIST);
$totalRows_ORDER_LIST = mysql_num_rows($ORDER_LIST);

switch($row_ORDER_LIST['ord_pay']){
    case 'card':
        if ($row_ORDER_LIST['ord_status'] == 2){
            $payway = "信用卡 (付款失敗，請重新下單)";
        }else{
            $payway = "信用卡";
        }
    break;
    case 'webatm':
    $payway = "一般匯款或WebATM";
    break;
    case 'atm':
    $payway = "超商付款";
    break;
    case 'atm_cathy':
    $payway = "一般匯款/ATM轉帳";
    break;
    case 'paynow':
    $payway = "貨到付款";
    break;
}
						
$total_sale_num = $row_ORDER_LIST['ord_p_num']+$row_ORDER_LIST['ord_p_num2']+$row_ORDER_LIST['ord_p_num3']+$row_ORDER_LIST['ord_p_num4']+$row_ORDER_LIST['ord_p_num5'];

$updateSQL = "UPDATE Product SET p_sale_num = p_sale_num + ".$total_sale_num.", p_p1_limit_sale = p_p1_limit_sale + ".$row_ORDER_LIST['ord_p_num'].", p_p2_limit_sale = p_p2_limit_sale + ".$row_ORDER_LIST['ord_p_num2'].", p_p3_limit_sale = p_p3_limit_sale + ".$row_ORDER_LIST['ord_p_num3'].", p_p4_limit_sale = p_p4_limit_sale + ".$row_ORDER_LIST['ord_p_num4'].", p_p5_limit_sale = p_p5_limit_sale + ".$row_ORDER_LIST['ord_p_num5'].", p_pa1_limit_sale = p_pa1_limit_sale + ".$row_ORDER_LIST['ord_pa1_num'].", p_pa2_limit_sale = p_pa2_limit_sale + ".$row_ORDER_LIST['ord_pa2_num'].", p_pa3_limit_sale = p_pa3_limit_sale + ".$row_ORDER_LIST['ord_pa3_num'].", p_pa4_limit_sale = p_pa4_limit_sale + ".$row_ORDER_LIST['ord_pa4_num'].", p_pa5_limit_sale = p_pa5_limit_sale + ".$row_ORDER_LIST['ord_pa5_num'].", p_pa6_limit_sale = p_pa6_limit_sale + ".$row_ORDER_LIST['ord_pa6_num'].", p_pa7_limit_sale = p_pa7_limit_sale + ".$row_ORDER_LIST['ord_pa7_num'].", p_pa8_limit_sale = p_pa8_limit_sale + ".$row_ORDER_LIST['ord_pa8_num'].", p_pa9_limit_sale = p_pa9_limit_sale + ".$row_ORDER_LIST['ord_pa9_num'].", p_pa10_limit_sale = p_pa10_limit_sale + ".$row_ORDER_LIST['ord_pa10_num'].", p_pb1_limit_sale = p_pb1_limit_sale + ".$row_ORDER_LIST['ord_pb1_num'].", p_pb2_limit_sale = p_pb2_limit_sale + ".$row_ORDER_LIST['ord_pb2_num'].", p_pb3_limit_sale = p_pb3_limit_sale + ".$row_ORDER_LIST['ord_pb3_num'].", p_pb4_limit_sale = p_pb4_limit_sale + ".$row_ORDER_LIST['ord_pb4_num'].", p_pb5_limit_sale = p_pb5_limit_sale + ".$row_ORDER_LIST['ord_pb5_num'].", p_pb6_limit_sale = p_pb6_limit_sale + ".$row_ORDER_LIST['ord_pb6_num'].", p_pb7_limit_sale = p_pb7_limit_sale + ".$row_ORDER_LIST['ord_pb7_num'].", p_pb8_limit_sale = p_pb8_limit_sale + ".$row_ORDER_LIST['ord_pb8_num'].", p_pb9_limit_sale = p_pb9_limit_sale + ".$row_ORDER_LIST['ord_pb9_num'].", p_pb10_limit_sale = p_pb10_limit_sale + ".$row_ORDER_LIST['ord_pb10_num']." WHERE p_id=".$row_ORDER_LIST['ord_p_id'];
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

$product_num1 = "  (1) ".$row_ORDER_LIST['p_product1']."：".$row_ORDER_LIST['ord_p_num']."<br>";

if($row_ORDER_LIST['p_product2'] <> ""){
$product_num2 = "  (2) ".$row_ORDER_LIST['p_product2']."：".$row_ORDER_LIST['ord_p_num2']."<br>";
}
if($row_ORDER_LIST['p_product3'] <> ""){
$product_num3 = "  (3) ".$row_ORDER_LIST['p_product3']."：".$row_ORDER_LIST['ord_p_num3']."<br>";
}
if($row_ORDER_LIST['p_product4'] <> ""){
$product_num4 = "  (4) ".$row_ORDER_LIST['p_product4']."：".$row_ORDER_LIST['ord_p_num4']."<br>";
}
if($row_ORDER_LIST['p_product5'] <> ""){
$product_num5 = "  (5) ".$row_ORDER_LIST['p_product5']."：".$row_ORDER_LIST['ord_p_num5']."<br>";
}

$product_num = $product_num1.$product_num2.$product_num3.$product_num4.$product_num5 ;

//組合商品
if($row_ORDER_LIST['p_pa1'] <> ""){
$product_num1a = "組合商品：<br>  (1) ".$row_ORDER_LIST['p_pa1']."：".$row_ORDER_LIST['ord_pa1_num']."<br>";
}
if($row_ORDER_LIST['p_pa2'] <> ""){
$product_num2a = "  (2) ".$row_ORDER_LIST['p_pa2']."：".$row_ORDER_LIST['ord_pa2_num']."<br>";
}
if($row_ORDER_LIST['p_pa3'] <> ""){
$product_num3a = "  (3) ".$row_ORDER_LIST['p_pa3']."：".$row_ORDER_LIST['ord_pa3_num']."<br>";
}
if($row_ORDER_LIST['p_pa4'] <> ""){
$product_num4a = "  (4) ".$row_ORDER_LIST['p_pa4']."：".$row_ORDER_LIST['ord_pa4_num']."<br>";
}
if($row_ORDER_LIST['p_pa5'] <> ""){
$product_num5a = "  (5) ".$row_ORDER_LIST['p_pa5']."：".$row_ORDER_LIST['ord_pa5_num']."<br>";
}
if($row_ORDER_LIST['p_pa6'] <> ""){
$product_num6a = "  (6) ".$row_ORDER_LIST['p_pa6']."：".$row_ORDER_LIST['ord_pa6_num']."<br>";
}
if($row_ORDER_LIST['p_pa7'] <> ""){
$product_num7a = "  (7) ".$row_ORDER_LIST['p_pa7']."：".$row_ORDER_LIST['ord_pa7_num']."<br>";
}
if($row_ORDER_LIST['p_pa8'] <> ""){
$product_num8a = "  (8) ".$row_ORDER_LIST['p_pa8']."：".$row_ORDER_LIST['ord_pa8_num']."<br>";
}
if($row_ORDER_LIST['p_pa9'] <> ""){
$product_num9a = "  (9) ".$row_ORDER_LIST['p_pa9']."：".$row_ORDER_LIST['ord_pa9_num']."<br>";
}
if($row_ORDER_LIST['p_pa10'] <> ""){
$product_num10a = "  (10) ".$row_ORDER_LIST['p_pa10']."：".$row_ORDER_LIST['ord_pa10_num']."<br>";
}

$product_numa = $product_num1a.$product_num2a.$product_num3a.$product_num4a.$product_num5a.$product_num6a.$product_num7a.$product_num8a.$product_num9a.$product_num10a ;

//
if($row_ORDER_LIST['p_pb1'] <> ""){
$product_num1b = "加購商品：<br>  (1) ".$row_ORDER_LIST['p_pb1']."：".$row_ORDER_LIST['ord_pb1_num']."<br>";
}
if($row_ORDER_LIST['p_pb2'] <> ""){
$product_num2b = "  (2) ".$row_ORDER_LIST['p_pb2']."：".$row_ORDER_LIST['ord_pb2_num']."<br>";
}
if($row_ORDER_LIST['p_pb3'] <> ""){
$product_num3b = "  (3) ".$row_ORDER_LIST['p_pb3']."：".$row_ORDER_LIST['ord_pb3_num']."<br>";
}
if($row_ORDER_LIST['p_pb4'] <> ""){
$product_num4b = "  (4) ".$row_ORDER_LIST['p_pb4']."：".$row_ORDER_LIST['ord_pb4_num']."<br>";
}
if($row_ORDER_LIST['p_pb5'] <> ""){
$product_num5b = "  (5) ".$row_ORDER_LIST['p_pb5']."：".$row_ORDER_LIST['ord_pb5_num']."<br>";
}
if($row_ORDER_LIST['p_pb6'] <> ""){
$product_num6b = "  (6) ".$row_ORDER_LIST['p_pb6']."：".$row_ORDER_LIST['ord_pb6_num']."<br>";
}
if($row_ORDER_LIST['p_pb7'] <> ""){
$product_num7b = "  (7) ".$row_ORDER_LIST['p_pb7']."：".$row_ORDER_LIST['ord_pb7_num']."<br>";
}
if($row_ORDER_LIST['p_pb8'] <> ""){
$product_num8b = "  (8) ".$row_ORDER_LIST['p_pb8']."：".$row_ORDER_LIST['ord_pb8_num']."<br>";
}
if($row_ORDER_LIST['p_pb9'] <> ""){
$product_num9b = "  (9) ".$row_ORDER_LIST['p_pb9']."：".$row_ORDER_LIST['ord_pb9_num']."<br>";
}
if($row_ORDER_LIST['p_pb10'] <> ""){
$product_num10b = "  (10) ".$row_ORDER_LIST['p_pb10']."：".$row_ORDER_LIST['ord_pb10_num']."<br>";
}

$product_numb = $product_num1b.$product_num2b.$product_num3b.$product_num4b.$product_num5b.$product_num6b.$product_num7b.$product_num8b.$product_num9b.$product_num10b ;


if($row_ORDER_LIST['ord_pay'] == "atm_cathy"){
	$messages_atm = "<tr>
              <td bgcolor=\"#F75FA4\"><div align=\"right\"><strong>匯款銀行：</strong></div></td>
              <td valign=\"middle\"><div align=\"left\">013 國泰世華商業銀行 松山分行</div></td>
              <td valign=\"middle\" bgcolor=\"#F75FA4\"><div align=\"right\"><strong>專屬匯款帳號：</strong></div></td>
              <td valign=\"middle\"><div align=\"left\">戶名：共鳴議題股份有限公司<br>帳號：".$row_ORDER_LIST['ord_atm_5code']."</div></td>
            </tr>";
}else{
	$messages_atm = "";
}

$message01 = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title></title>
</head>

<body>
<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td height=\"150\" align=\"center\" valign=\"middle\">
	親愛的iWine會員您好，以下是您的訂單內容：<br>
	<table width=\"95%\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\" class=\"table\">
            <tr>
              <td width=\"20%\" bgcolor=\"#F75FA4\"><div align=\"right\"><strong>訂單編號：</strong></div></td>
              <td width=\"30%\" valign=\"middle\" bgcolor=\"#FDCBE0\"><div align=\"left\">".$row_ORDER_LIST['ord_code']."</div></td>
              <td width=\"20%\" valign=\"middle\" bgcolor=\"#F75FA4\"><div align=\"right\"><strong>訂單成立日期：</strong></div></td>
              <td width=\"30%\" valign=\"middle\" bgcolor=\"#FDCBE0\"><div align=\"left\">".$row_ORDER_LIST['ord_date']."</div></td>
            </tr>
            <tr>
              <td bgcolor=\"#F75FA4\"><div align=\"right\"><strong>收件人姓名：</strong></div></td>
              <td valign=\"middle\"><div align=\"left\">".$row_ORDER_LIST['m_name']."</div></td>
              <td valign=\"middle\" bgcolor=\"#F75FA4\"><div align=\"right\"><strong>付款方式：</strong></div></td>
              <td valign=\"middle\"><div align=\"left\">".$payway."</div></td>
            </tr>".$messages_atm."
            <tr>
              <td bgcolor=\"#F75FA4\"><div align=\"right\"><strong>收件人e-mail：</strong></div></td>
              <td valign=\"middle\" bgcolor=\"#FDCBE0\"><div align=\"left\">".$row_ORDER_LIST['m_email']."</div></td>
              <td valign=\"middle\" bgcolor=\"#F75FA4\"><div align=\"right\"><strong>收件人手機：</strong></div></td>
              <td valign=\"middle\" bgcolor=\"#FDCBE0\"><div align=\"left\">".$row_ORDER_LIST['m_mobile']."</div></td>
            </tr>
            <tr>
              <td bgcolor=\"#F75FA4\"><div align=\"right\"><strong>收件人地址：</strong></div></td>
              <td colspan=\"3\" valign=\"middle\"><div align=\"left\">".$row_ORDER_LIST['ord_ship_zip'].$row_ORDER_LIST['ord_ship_county'].$row_ORDER_LIST['ord_ship_city'].$row_ORDER_LIST['ord_ship_address']."</div></td>
            </tr>
            <tr>
              <td bgcolor=\"#F75FA4\"><div align=\"right\"><strong>公司抬頭：</strong></div></td>
              <td colspan=\"3\" valign=\"middle\" bgcolor=\"#FDCBE0\"><div align=\"left\">".$row_ORDER_LIST['ord_ship_fa_name']."</div></td>
            </tr>
			<tr>
              <td bgcolor=\"#F75FA4\"><div align=\"right\"><strong>公司統編：</strong></div></td>
              <td colspan=\"3\" valign=\"middle\"><div align=\"left\">".$row_ORDER_LIST['ord_ship_fa_id']."</div></td>
            </tr>
            <tr>
              <td bgcolor=\"#F75FA4\"><div align=\"right\"><strong>備註：</strong></div></td>
              <td colspan=\"3\" valign=\"middle\" bgcolor=\"#FDCBE0\"><div align=\"left\">".$row_ORDER_LIST['ord_memo']."</div></td>
            </tr>
            </table><br>
<table width=\"95%\" border=\"1\" cellpadding=\"4\" cellspacing=\"0\" bordercolor=\"#000000\" class=\"table\">
        <tr bgcolor=\"#F75FA4\">
          <td width=\"20%\"><div align=\"center\"><strong>團購代號</strong></div></td>
          <td width=\"20%\"><div align=\"center\"><strong>團購商品名稱</strong></div></td>
          
          <td width=\"40%\" colspan=\"2\"><div align=\"center\"><strong>商品數量</strong></div></td>
          <td width=\"20%\"><div align=\"center\"><strong>小計</strong></div></td>
        </tr>
		<tr>
            <td><div align=\"center\">".$row_ORDER_LIST['p_code']."</div></td>
            <td><div align=\"center\">".$row_ORDER_LIST['p_name']."</div></td>
            
            <td colspan=\"2\"><div align=\"center\">".$product_num.$product_numa.$product_numb."</div></td>
            <td><div align=\"center\">".$row_ORDER_LIST['ord_buy_price']."</div></td>
          </tr>
		  <tr>
                  <td colspan=\"4\" align=\"right\" bgcolor=\"#FFFFFF\" >運費</td>
                  <td align=\"center\" bgcolor=\"#FFFFFF\" >".$row_ORDER_LIST['ord_ship_price']."</td>
                </tr>
				<tr>
                  <td colspan=\"4\" align=\"right\" bgcolor=\"#FFFFFF\" >手續費</td>
                  <td align=\"center\" bgcolor=\"#FFFFFF\" >".$row_ORDER_LIST['ord_hand_price']."</td>
                </tr>
                <tr>
                  <td colspan=\"4\" bgcolor=\"#FFFFFF\" ><div align=\"right\" class=\"text_cap\">總金額</div></td>
                  <td bgcolor=\"#FFFFFF\" ><div align=\"center\">".$row_ORDER_LIST['ord_total_price']."</div></td>
                </tr>
				<tr>
				  <td colspan=\"5\" bgcolor=\"#FDCBE0\" ><div align=\"center\">注意事項</div></td>
				</tr>
				<tr>
				  <td colspan=\"5\" bgcolor=\"#ffffff\" ><div align=\"left\">
                  <p>1. iWine已經收到您的訂單，感謝您訂購iWine商品！</p>
                  <p>2. 本郵件僅紀錄您的訂單內容，並供您再次自行核對之用，不代表交易已經完成！</p>
                  <p>3. iWine無提供分期付款功能！不會以電話通知您修改付款方式或重新付款，或是要求您提供卡片後方的客服電話，再用此電話號碼告知ATM修改設定，以上皆為詐騙集團惡劣騙術，請您小心防範勿受騙！</p>
                  <p>4. 若您選擇信用卡付款服務，iWine確認入帳後立刻安排出貨。</p>
                  <p>5. 若您選擇一般匯款/ATM轉帳服務，請於三日內至金融機構、郵局或一般ATM轉帳付款，超過三日，專屬匯款帳號將自動失效無法接受匯款，請重新訂購。因金融機構作業時間，付款後約需一至三個工作天才會入帳。iWine確認入帳後立刻安排出貨。</p>
                  <p>6. 若您選擇貨到付款服務，iWine將會在最短時間內安排出貨。</p>
                  <p>7. 如果您仍有問題請mail至<a href=\"mailto:service@iwine.com.tw\">service@iwine.com.tw</a>客服信箱，將有專人與您聯絡，謝謝！</p>
                  <p>8. iWine保留接受訂單與否的權利。</p><p></p>

				  <p>祝 您有個美好的一天 ^_^</p>
				  <p>----------------------------------------------------------</p>
				  <p>iWine Website: <a href=\"http://www.iwine.com.tw\">http://www.iwine.com.tw</a><br />
iWine Facebook: <a href=\"https://www.facebook.com/iwine\">https://www.facebook.com/iwine</a></p>
				</div></td>
				</tr>
    </table>
	</td>
  </tr>
</table>
</html>
";

require_once('PHPMailer/class.phpmailer.php');
$mail             = new PHPMailer(); // defaults to using php "mail()"

$body             = $message01;

$mail->IsSMTP(); // telling the class to use SMTP
// $mail->Host       = "ms.mailcloud.com.tw"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";
$mail->Host       = "smtp.gmail.com"; // sets the SMTP server
$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
$mail->Username   = "admin@iwine.com.tw"; // SMTP account username
$mail->Password   = "coevo53118909";        // SMTP account password
//$mail->SMTPSecure = "ssl";
// $mail->Host       = "ms.mailcloud.com.tw"; // sets the SMTP server
// $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
// $mail->Username   = "admin@hudong.tv"; // SMTP account username
// $mail->Password   = "@#mjn0405";        // SMTP account password

/*

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
$mail->AddReplyTo("service@iwine.com.tw","iWine");
$mail->SetFrom('service@iwine.com.tw',"iWine");

$address = $row_ORDER_LIST['m_email'];
$mail->AddAddress($address, $row_ORDER_LIST['m_name']);

$mail->Subject    = "iWine商品訂單成立通知信 [團購代碼：".$row_ORDER_LIST['ord_code']."]";

$mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->CharSet="utf-8";

$mail->Encoding = "base64";
//設置郵件格式為HTML
$mail->IsHTML(true);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

$mail2             = new PHPMailer(); // defaults to using php "mail()"
$mail_body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n
    <html xmlns=\"http://www.w3.org/1999/xhtml\">
    <head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title></title>
    <style>
        table { border: 0; } 
        td { padding : 5px;border: 0px; } 
    </style>
    </head>
    <body>Hi <br>iWine 團購新增了一筆訂單。
    <br>後台檢視點選聯結：<a href=\"http://admin.iwine.com.tw/qpzm105/order_s.php?ord_id=".$row_ORDER_LIST['ord_id']."&page=0\" >http://admin.iwine.com.tw/qpzm105/order_s.php?ord_id=".$row_ORDER_LIST['ord_id']."&page=0</a>
    <br>摘要如下：<br>
    <table >
    <tr><td>訂單編號：</td><td>".$row_ORDER_LIST['ord_code']."</td></tr>
    <tr><td>收件人姓名：</td><td>".$row_ORDER_LIST['m_name']."</td></tr>
    <tr><td>付款方式：</td><td>".$payway."</td></tr>
    <tr><td>團購代號：</td><td>".$row_ORDER_LIST['p_code']."</td></tr>
    <tr><td>團購商品名稱：</td><td>".$row_ORDER_LIST['p_name']."</td></tr>
    <tr><td>總金額：</td><td>".$row_ORDER_LIST['ord_total_price']."</td></tr>
    </table></body></html>";
    
$mail2->IsSMTP(); // telling the class to use SMTP
$mail2->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail2->SMTPAuth   = true;                  // enable SMTP authentication
$mail2->SMTPSecure = "ssl";
$mail2->Host       = "smtp.gmail.com"; // sets the SMTP server
$mail2->Port       = 465;                    // set the SMTP port for the GMAIL server
// $mail2->Username   = "service@iwine.today"; // SMTP account username
// $mail2->Password   = "iwine2014";        // SMTP account password

$mail2->Username   = "service@iwine.com.tw"; // SMTP account username
$mail2->Password   = "service53118909";        // SMTP account password
$mail2->AddReplyTo("service@iwine.today","iWine");
$mail2->SetFrom('service@iwine.today',"iWine");

$mail2->AddAddress("ben@iwine.com.tw");
$mail2->AddAddress("service@iwine.com.tw");
$mail2->AddBCC("order@iwine.today");
$mail2->Subject    = "[iWine團購訂單新增通知信] 團購代碼：".$row_ORDER_LIST['ord_code'];
$mail2->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test
$mail2->MsgHTML($mail_body);
$mail2->CharSet="utf-8";
$mail2->Encoding = "base64";
$mail2->IsHTML(true);
$mail2->Send();





if(!$mail->Send()) {
  //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	//echo "密碼信寄送中~~";
	$_success_url = "myorder_s2.php?ord_id=".$row_ORDER_LIST['ord_id'];
	go_to($_success_url);
	exit;
}

mysql_free_result($ORDER_LIST);
?>
</body>
</html>