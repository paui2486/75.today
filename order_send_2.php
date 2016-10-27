<?php 
include('session_check.php');

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
<body>


<p>詢問單處理中....請不要點選重新整理或回上一頁！</p>
<?php 
//<!--p align="center"><img src="images/in_progress.jpg" width="365" height="419" /></p-->
include('ga.php'); 
$_from = "http://www.iwine.com.tw/cart_1.php?p_id=".$_POST['ord_p_id'];
//echo $_SERVER['HTTP_REFERER'];
if($_SERVER['HTTP_REFERER'] <> $_from ){ msg_box('系統存取錯誤!'); go_to('index.php'); exit;} 
//echo "詢問單處理中....請不要點選重新整理或回上一頁....";
require_once('Connections/iwine.php');
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
        switch ($theType) {
            case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
            case "long":
            case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
            case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
            case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
            case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
        }
        return $theValue;
    }
}

if($_POST['ord_total_price'] == 0){ msg_box('詢問單資料有誤，請重送詢問單!'); go_to('index.php'); exit;}

$colname_ORDER = date('Y-m-d');
  
mysql_select_db($database_iwine, $iwine);
$query_ORDER = sprintf("SELECT * FROM order_list WHERE ord_date = '%s' ORDER BY ord_code2 DESC limit 1", GetSQLValueString($colname_ORDER, "date"));
$ORDER = mysql_query($query_ORDER, $iwine) or die(mysql_error());
$row_ORDER = mysql_fetch_assoc($ORDER);
$totalRows_ORDER = mysql_num_rows($ORDER);

//$taiwan_year = date('Y')-1911;
//if($taiwan_year < 100){$taiwan_year = "0".$taiwan_year;}
$code1 = date('Ymd');

if($totalRows_ORDER ==0){$code2 = 1 ; }
else{ $code2 = $row_ORDER['ord_code2'] + 1 ; }

$code3 = $code2 + 6000 ;

if($code2 < 10){$code2x="5000".$code2;}
elseif($code2 < 100 && $code2 >=10){$code2x="500".$code2;}
elseif($code2 < 1000 && $code2 >=100){$code2x="50".$code2;}
elseif($code2 < 10000 && $code2 >=1000){$code2x="5".$code2;}
else{$code2x = $code2; }

$code = "IW".$code1.$code2x ; 

$insertSQL = sprintf("INSERT INTO order_list (ord_code, ord_code1, ord_code2, ord_acc_id, ord_acc, ord_p_id, ord_p_num, ord_p_num2, ord_p_num3, ord_p_num4, ord_p_num5, ord_pa1_num, ord_pa2_num, ord_pa3_num, ord_pa4_num, ord_pa5_num, ord_pa6_num, ord_pa7_num, ord_pa8_num, ord_pa9_num, ord_pa10_num, ord_pb1_num, ord_pb2_num, ord_pb3_num, ord_pb4_num, ord_pb5_num, ord_pb6_num, ord_pb7_num, ord_pb8_num, ord_pb9_num, ord_pb10_num, ord_ship_name, ord_ship_mobile, ord_ship_zip, ord_ship_county, ord_ship_city, ord_ship_address, ord_ship_email, ord_ship_fa_id,ord_ship_fa_name, ord_pay, ord_memo, ord_date, ord_buy_price, ord_ship_price, ord_hand_price, ord_total_price, sess_id, am_code) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s', '%s', '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
					   GetSQLValueString($code, "text"),
                       GetSQLValueString($code1, "text"),
                       GetSQLValueString($code2, "text"),
                       GetSQLValueString($_POST['ord_acc_id'], "int"),
                       GetSQLValueString($_POST['ord_acc'], "text"),
                       GetSQLValueString($_POST['ord_p_id'], "text"),
                       GetSQLValueString($_POST['ord_p_num'], "text"),
					   GetSQLValueString($_POST['ord_p_num2'], "text"),
					   GetSQLValueString($_POST['ord_p_num3'], "text"),
					   GetSQLValueString($_POST['ord_p_num4'], "text"),
					   GetSQLValueString($_POST['ord_p_num5'], "text"),
					   GetSQLValueString($_POST['ord_pa1_num'], "text"),
					   GetSQLValueString($_POST['ord_pa2_num'], "text"),
					   GetSQLValueString($_POST['ord_pa3_num'], "text"),
					   GetSQLValueString($_POST['ord_pa4_num'], "text"),
					   GetSQLValueString($_POST['ord_pa5_num'], "text"),
					   GetSQLValueString($_POST['ord_pa6_num'], "text"),
					   GetSQLValueString($_POST['ord_pa7_num'], "text"),
					   GetSQLValueString($_POST['ord_pa8_num'], "text"),
					   GetSQLValueString($_POST['ord_pa9_num'], "text"),
					   GetSQLValueString($_POST['ord_pa10_num'], "text"),
					   GetSQLValueString($_POST['ord_pb1_num'], "text"),
					   GetSQLValueString($_POST['ord_pb2_num'], "text"),
					   GetSQLValueString($_POST['ord_pb3_num'], "text"),
					   GetSQLValueString($_POST['ord_pb4_num'], "text"),
					   GetSQLValueString($_POST['ord_pb5_num'], "text"),
					   GetSQLValueString($_POST['ord_pb6_num'], "text"),
					   GetSQLValueString($_POST['ord_pb7_num'], "text"),
					   GetSQLValueString($_POST['ord_pb8_num'], "text"),
					   GetSQLValueString($_POST['ord_pb9_num'], "text"),
					   GetSQLValueString($_POST['ord_pb10_num'], "text"),
                       GetSQLValueString($_POST['ord_ship_name'], "text"),
					   GetSQLValueString($_POST['ord_ship_mobile'], "text"),
					   GetSQLValueString($_POST['zipcode'], "text"),
					   GetSQLValueString($_POST['county'], "text"),
					   GetSQLValueString($_POST['district'], "text"),
                       GetSQLValueString($_POST['ord_ship_address'], "text"),
                       GetSQLValueString($_POST['ord_ship_email'], "text"),
					   GetSQLValueString($_POST['ord_ship_fa_id'], "text"),
					   GetSQLValueString($_POST['ord_ship_fa_name'], "text"),
                       GetSQLValueString($_POST['ord_pay'], "text"),
					   GetSQLValueString($_POST['ord_memo'], "text"),
                       GetSQLValueString($colname_ORDER, "date"),
                       GetSQLValueString($_POST['ord_buy_price'], "int"),
                       GetSQLValueString($_POST['ord_ship_price'], "int"),
					   GetSQLValueString($_POST['ord_hand_price'], "int"),
                       GetSQLValueString($_POST['ord_total_price'], "int"),
                       GetSQLValueString($_POST['sess_id'], "text"),
					   GetSQLValueString($_SESSION['am_code'], "text"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
 

if($_POST['ord_pay'] == "atm_cathy"){
    //ATM付款
    $d = strtotime('+3 days');
    $_atm00 = date('md',$d);	
    $_atm01 = "6340".$_atm00.$code2x;	
    $money = $_POST['ord_total_price'];
    $money_lenth = strlen($money);

    $sum_account = substr(substr($_atm01,-1,1)*7,-1,1) + substr(substr($_atm01,-2,1)*6,-1,1) + substr(substr($_atm01,-3,1)*5,-1,1) + substr(substr($_atm01,-4,1)*4,-1,1) + substr(substr($_atm01,-5,1)*3,-1,1) + substr(substr($_atm01,-6,1)*2,-1,1) + substr(substr($_atm01,-7,1)*1,-1,1) + substr(substr($_atm01,-8,1)*9,-1,1) + substr(substr($_atm01,-9,1)*8,-1,1) + substr(substr($_atm01,-10,1)*7,-1,1) + substr(substr($_atm01,-11,1)*6,-1,1) + substr(substr($_atm01,-12,1)*5,-1,1) + substr(substr($_atm01,-13,1)*4,-1,1) ;

    $sum1 = substr($sum_account,-1,1);

    $sum_money = 0;

    for($i=1;$i<=$money_lenth;$i++){
        $sum_money = $sum_money + substr($money, -$i, 1)*$i;
    }

    $sum2 = substr($sum_money,-1,1);

    $sum0 = $sum1 + $sum2;
    $sum00 = substr(10 - substr($sum0,-1,1),-1,1);
    $atm_code = $_atm01.$sum00;


    $updateSQL = sprintf("UPDATE order_list SET ord_status='5', ord_atm_5code = '$atm_code' WHERE ord_code='%s'",
                           GetSQLValueString($code, "text"));

    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());	
/*
    if($_POST['ord_p_num'] == ""){$_POST['ord_p_num'] = 0;}
    if($_POST['ord_p_num2'] == ""){$_POST['ord_p_num2'] = 0;}
    if($_POST['ord_p_num3'] == ""){$_POST['ord_p_num3'] = 0;}
    if($_POST['ord_p_num4'] == ""){$_POST['ord_p_num4'] = 0;}
    if($_POST['ord_p_num5'] == ""){$_POST['ord_p_num5'] = 0;}


    $total_sale_num = $_POST['ord_p_num']+$_POST['ord_p_num2']+$_POST['ord_p_num3']+$_POST['ord_p_num4']+$_POST['ord_p_num5'];

    $updateSQL = "UPDATE Product SET p_sale_num = p_sale_num + ".$total_sale_num.", p_p1_limit_sale = p_p1_limit_sale + ".$_POST['ord_p_num'].", p_p2_limit_sale = p_p2_limit_sale + ".$_POST['ord_p_num2'].", p_p3_limit_sale = p_p3_limit_sale + ".$_POST['ord_p_num3'].", p_p4_limit_sale = p_p4_limit_sale + ".$_POST['ord_p_num4'].", p_p5_limit_sale = p_p5_limit_sale + ".$_POST['ord_p_num5']." WHERE p_id=".$_POST['ord_p_id'];
    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());	
*/
    // msg_box('成功送出訂單～～\n客服人員將會與您聯繫，謝謝！');
    msg_box('訂單已建立，系統將自動產生「專屬匯款帳號」，\n請至您的註冊信箱收信或至「會員中心」查詢訂單，\n請於三日內至金融機構、郵局或一般ATM轉帳付款，\n稍後將會再次顯示您的訂單；\n由於網路速度有差異，顯示時間長短不一，\n請耐心等候不要執行其他操作，謝謝！\n\n請注意：iWine無提供分期付款功能！不會以電話通知您修改付款方式或重新付款，或是要求您提供卡片後方的客服電話，再用此電話號碼告知ATM修改設定，以上皆為詐騙集團惡劣騙術，請您小心防範勿受騙！');
    $_atm_url = "order_mail.php?ord_code=".$code;
    go_to($_atm_url);

}elseif($_POST['ord_pay'] == "atm"){

    $updateSQL = sprintf("UPDATE order_list SET ord_status='5' WHERE ord_code='%s'",
                           GetSQLValueString($code, "text"));

    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());	

    /*
    if($_POST['ord_p_num'] == ""){$_POST['ord_p_num'] = 0;}
    if($_POST['ord_p_num2'] == ""){$_POST['ord_p_num2'] = 0;}
    if($_POST['ord_p_num3'] == ""){$_POST['ord_p_num3'] = 0;}
    if($_POST['ord_p_num4'] == ""){$_POST['ord_p_num4'] = 0;}
    if($_POST['ord_p_num5'] == ""){$_POST['ord_p_num5'] = 0;}

    if($_POST['ord_pa1_num'] == ""){$_POST['ord_pa1_num'] = 0;}
    if($_POST['ord_pa2_num'] == ""){$_POST['ord_pa2_num'] = 0;}
    if($_POST['ord_pa3_num'] == ""){$_POST['ord_pa3_num'] = 0;}
    if($_POST['ord_pa4_num'] == ""){$_POST['ord_pa4_num'] = 0;}
    if($_POST['ord_pa5_num'] == ""){$_POST['ord_pa5_num'] = 0;}

    $total_sale_num = $_POST['ord_p_num']+$_POST['ord_p_num2']+$_POST['ord_p_num3']+$_POST['ord_p_num4']+$_POST['ord_p_num5'];

    $total_pa_sale_num = $_POST['ord_pa1_num']+$_POST['ord_pa2_num']+$_POST['ord_pa3_num']+$_POST['ord_pa4_num']+$_POST['ord_pa5_num'];

    $updateSQL = "UPDATE Product SET p_sale_num = p_sale_num + ".$total_sale_num.", p_p1_limit_sale = p_p1_limit_sale + ".$_POST['ord_p_num'].", p_p2_limit_sale = p_p2_limit_sale + ".$_POST['ord_p_num2'].", p_p3_limit_sale = p_p3_limit_sale + ".$_POST['ord_p_num3'].", p_p4_limit_sale = p_p4_limit_sale + ".$_POST['ord_p_num4'].", p_p5_limit_sale = p_p5_limit_sale + ".$_POST['ord_p_num5'].", p_pa1_limit_sale = p_pa1_limit_sale + ".$_POST['ord_pa1_num'].", p_pa2_limit_sale = p_pa2_limit_sale + ".$_POST['ord_pa2_num'].", p_pa3_limit_sale = p_pa3_limit_sale + ".$_POST['ord_pa3_num'].", p_pa4_limit_sale = p_pa4_limit_sale + ".$_POST['ord_pa4_num'].", p_pa5_limit_sale = p_pa5_limit_sale + ".$_POST['ord_pa5_num']." WHERE p_id=".$_POST['ord_p_id'];
    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());	
    */

    msg_box('訂單已建立，系統將自動產生「專屬匯款帳號」，\n請至您的註冊信箱收信或至「會員中心」查詢訂單，\n請於三日內至金融機構、郵局或一般ATM轉帳付款，\n稍後將會再次顯示您的訂單；\n由於網路速度有差異，顯示時間長短不一，\n請耐心等候不要執行其他操作，謝謝！\n\n請注意：iWine無提供分期付款功能！不會以電話通知您修改付款方式或重新付款，或是要求您提供卡片後方的客服電話，再用此電話號碼告知ATM修改設定，以上皆為詐騙集團惡劣騙術，請您小心防範勿受騙！');
    $_atm_url = "checkout_atm.php?ord_code=".$code;
    go_to($_atm_url);

}elseif($_POST['ord_pay'] == "card"){
    //信用卡
    $updateSQL = sprintf("UPDATE order_list SET ord_status='2' WHERE ord_code='%s'",
                           GetSQLValueString($code, "text"));

    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());	
        
    $_card_url = "checkout_card_cathay.php?ord_code=".$code; 
    msg_box('訂單已建立，系統將自動導引至銀行專屬刷卡介面，\n本網站不會紀錄您的信用卡資料，請安心完成刷卡程序，\n刷卡完成後會再次顯示您的訂單；\n由於網路速度有差異，顯示時間長短不一，\n請耐心等候不要執行其他操作，謝謝！\n\n請注意：iWine無提供分期付款功能！不會以電話通知您修改付款方式或重新付款，或是要求您提供卡片後方的客服電話，再用此電話號碼告知ATM修改設定，以上皆為詐騙集團惡劣騙術，請您小心防範勿受騙！');
    go_to($_card_url);
    //go_to('myorder.php');
}elseif($_POST['ord_pay'] == "webatm"){
    //產生虛擬帳號

    $d = strtotime('+3 days');
    $_atm00 = date('md',$d);	
    $_atm01 = "6340".$_atm00.$code2x;	
    $money = $_POST['ord_total_price'];
    $money_lenth = strlen($money);

    $sum_account = substr(substr($_atm01,-1,1)*7,-1,1) + substr(substr($_atm01,-2,1)*6,-1,1) + substr(substr($_atm01,-3,1)*5,-1,1) + substr(substr($_atm01,-4,1)*4,-1,1) + substr(substr($_atm01,-5,1)*3,-1,1) + substr(substr($_atm01,-6,1)*2,-1,1) + substr(substr($_atm01,-7,1)*1,-1,1) + substr(substr($_atm01,-8,1)*9,-1,1) + substr(substr($_atm01,-9,1)*8,-1,1) + substr(substr($_atm01,-10,1)*7,-1,1) + substr(substr($_atm01,-11,1)*6,-1,1) + substr(substr($_atm01,-12,1)*5,-1,1) + substr(substr($_atm01,-13,1)*4,-1,1) ;

    $sum1 = substr($sum_account,-1,1);

    $sum_money = 0;

    for($i=1;$i<=$money_lenth;$i++){
        $sum_money = $sum_money + substr($money, -$i, 1)*$i;
    }

    $sum2 = substr($sum_money,-1,1);

    $sum0 = $sum1 + $sum2;
    $sum00 = substr(10 - substr($sum0,-1,1),-1,1);
    $atm_code = $_atm01.$sum00;
        
    $updateSQL = sprintf("UPDATE order_list SET ord_status='5', ord_atm_5code='$atm_code' WHERE ord_code='%s'",
                           GetSQLValueString($code, "text"));

    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());	
        
    $_card_url = "checkout_webatm.php?ord_code=".$code; 
    msg_box('訂單已建立，系統將自動導引至專屬Web ATM刷卡介面，\n請將讀卡機連接至電腦上，並將您的金融卡插入讀卡機，\n付款完成後會再次顯示您的訂單；\n由於網路速度有差異，顯示時間長短不一，\n請耐心等候不要執行其他操作，謝謝！\n\n請注意：iWine無提供分期付款功能！不會以電話通知您修改付款方式或重新付款，或是要求您提供卡片後方的客服電話，再用此電話號碼告知ATM修改設定，以上皆為詐騙集團惡劣騙術，請您小心防範勿受騙！');
    go_to($_card_url);
    //go_to('myorder.php');
}elseif($_POST['ord_pay'] == "paynow"){

    $updateSQL = sprintf("UPDATE order_list SET ord_status='11' WHERE ord_code='%s'",
                           GetSQLValueString($code, "text"));

    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());		

    msg_box('訂單已建立，稍後將會再次顯示您的訂單，\n您可至註冊信箱收信或至「會員中心」查詢訂單，\n我們將迅速安排出貨。\n由於網路速度有差異，顯示時間長短不一，\n請耐心等候不要執行其他操作，謝謝！\n\n請注意：iWine無提供分期付款功能！不會以電話通知您修改付款方式或重新付款，或是要求您提供卡片後方的客服電話，再用此電話號碼告知ATM修改設定，以上皆為詐騙集團惡劣騙術，請您小心防範勿受騙！');
    $_atm_url = "order_mail.php?ord_code=".$code;
    go_to($_atm_url);

}


mysql_free_result($ORDER);
mysql_free_result($Cash_temp);
?>
</body>
</html>