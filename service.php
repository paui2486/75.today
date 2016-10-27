<?php session_start();  ?>
<?php include('func/func.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  if ($securimage->check($_POST['capacha_code']) == false) {
  msg_box('驗證碼錯誤,請重新輸入!');
  $_err_url = "service.php";
  go_to($_err_url);
  exit;
}	
	
  $insertSQL = sprintf("INSERT INTO contact (c_name, c_tel, c_email, c_class, c_cont, c_datetime) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
                       GetSQLValueString($_POST['c_name'], "text"),
                       GetSQLValueString($_POST['c_tel'], "text"),
                       GetSQLValueString($_POST['c_email'], "text"),
                       GetSQLValueString($_POST['c_class'], "text"),
                       GetSQLValueString($_POST['c_cont'], "text"),
                       GetSQLValueString($_POST['c_datetime'], "date"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  $last_id = mysql_insert_id();
  require_once('PHPMailer/class.phpmailer.php');
$mail             = new PHPMailer(); // defaults to using php "mail()"

$body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title></title>
<style>
body {
    font: normal normal 12px 'Meiryo', 'メイリオ', 'Hiragino Kaku Gothic Pro', 'ヒラギノ角ゴ Pro W3', 'ＭＳ Ｐゴシック', 'ＭＳ ゴシック', Osaka, Osaka-等幅, '微軟正黑體', sans-serif ,Georgia, Utopia, 'Palatino Linotype', Palatino, serif;
    color: #999;font-size: 12px;}
.mail_text, .mail_text p{ max-width: 600px; }
.content{
    margin: 5px;
    padding: 5px;
    max-width: 400px;
    color: #ff3366;
}
</style>
</head>

<body>
<div class=\"mail_text\">
<p>Hi iWine 管理員:</p>
<p>".$_POST['c_datetime']."收到來自".$_POST['c_name']."的客服訊息</p>
<p>詳細資料如下，請至<a href=\"http://admin.iwine.com.tw/qpzm105/contact_s.php?c_id=".$last_id."\">iWine 客服後台處理</a>，謝謝！</p>
姓名：<span class=\"content\">".$_POST['c_name']."</span><br>
電話：<span class=\"content\">".$_POST['c_tel']."</span><br>
email：<span class=\"content\">".$_POST['c_email']."</span><br>
主題：<span class=\"content\">".$_POST['c_class']."</span><br>
內容：<span class=\"content\">".$_POST['c_cont']."</span></p>
<p>此為系統通知，請勿直接回覆。</p>
</div>
</body>
</html>
";

$mail->IsSMTP(); // telling the class to use SMTP
// $mail->Host       = "iwine.com.tw"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
//$mail->SMTPSecure = "ssl";
// $mail->Host       = "iwine.com.tw"; // sets the SMTP server
// $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
// $mail->Username   = "service"; // SMTP account username
// $mail->Password   = "coevo27460111";        // SMTP account password
$mail->SMTPSecure = "ssl";
$mail->Host       = "smtp.gmail.com"; // sets the SMTP server
$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
$mail->Username   = "admin@iwine.com.tw"; // SMTP account username
$mail->Password   = "coevo53118909";        // SMTP account password

    $mail->AddReplyTo("service@iwine.com.tw","iWine");
    $mail->SetFrom('service@iwine.com.tw',"iWine");
    
    $mail->AddAddress("all@iwine.com.tw");
    $mail->AddBCC("service@iwine.com.tw");
    $mail->Subject    = "[iWine 客服通知]：".$_POST['c_class']." from ".$_POST['c_name'];
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
	msg_box('您的訊息已經送出，我們會儘快回覆您，謝謝！');
    go_to('index.php');
	exit;
}  
  
}
 
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>客服中心 - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="客服中心">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
      </script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <style>
    </style>
  </head>
  <body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=540353706035158";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php include('mainmenu_20140903.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
        <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
            <h3><img src="images/wine_icon1.png" width="35" height="35"> <span class="title">客服中心 - 聯絡我們</span></h3>
            <span class="span8"><img src="images/line03.png"><br>
            <br>
            </span>
            <form name="form1" action="<?php echo $editFormAction; ?>" method="POST" class="form-horizontal" id="form1" >              	
  					<div class="control-group">
    					<label class="control-label" for="c_name">您的姓名</label>
    					<div class="controls">
      					<input name="c_name" type="text" id="c_name" placeholder="請輸入您的姓名" value="<?php echo $_SESSION['MEM_NAME']; ?>">
                        <span class="help-inline">*必填</span>
                        <span class="help-stock">
                        <div id="account_check" style="color:#F00"></div></span>
   					  </div>
			  </div>
  					<div class="control-group">
    					<label class="control-label" for="c_tel">您的手機號碼</label>
    					<div class="controls">
      					<input type="text" id="c_tel" name="c_tel" placeholder="請輸入您的手機號碼">
    					</div>
  					</div>
                    <div class="control-group">
    					<label class="control-label" for="c_email">您的E-mail</label>
    					<div class="controls">
      					<input name="c_email" type="text" id="c_email" placeholder="請輸入您的email" value="<?php echo $_SESSION['MEM_ACCOUNT']; ?>">
                        <span class="help-inline">*必填</span>
    					</div>
  					</div>
                    <div class="control-group">
					  <label class="control-label" for="m_name">聯絡主題</label>
						<div class="controls">
						  <select name="c_class" id="c_class">
						    <option>洽詢團體商品資訊</option>
						    <option selected>給我們的建議</option>
						    <option>其他</option>
					      </select>
						</div>
                    </div>
                    <div class="control-group">
					  <label class="control-label" for="c_cont">聯絡內容</label>
						<div class="controls">
						  <textarea name="c_cont" rows="5" id="c_cont"></textarea>
						  <span class="help-inline">*必填</span>
						</div>   
					</div>
                    <div class="control-group">
    					<label class="control-label" for="capacha_code">驗證碼</label>
   					  <div class="controls">
      					<input name="capacha_code" type="text" id="capacha_code" />
                        <span class="help-inline"><img src="securimage/securimage_show.php" alt="CAPTCHA Image" align="absmiddle" id="captcha" /><a href="#" onClick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false" class="btn-small btn-info">更換</a></span>
   					  </div>
  					</div>
                    <div class="control-group">
					  <label class="control-label" for="c_cont"></label>
						<div class="controls">
						  客服時間：週一至週五 09:30~17:30
						</div>   
					</div>
  					
                    <div class="control-group">
    					<div class="controls">
                        <input name="c_datetime" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>">
      					<button type="button" class="btn btn-danger" onClick="chkcontact();">確定送出</button>
                        <button type="reset" class="btn btn-success">重設</button>
    					</div>
			  </div>
                    <input type="hidden" name="MM_insert" value="form1">
			  </form>
                
              
            </div>
            
          </div>
          
        </div>
        
        <div class="row">
        <div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon4.png" width="30" height="30"> iWine 排行榜 </h4>
            <?php include('ad_1.php'); ?>
        </div>
        <?php
        mysql_select_db($database_iwine, $iwine);
        $query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
        $hot = mysql_query($query_hot, $iwine) or die(mysql_error());
        $row_hot = mysql_fetch_assoc($hot);
        $totalRows_hot = mysql_num_rows($hot);
        ?>
        <div class="span3">
           <h4 align="left"><img src="images/wine_icon5.png" width="30" height="30"> 熱門文章 </h4>
           <div class="span3 hot_article" id="hot_article">
           <?php do{ ?>
            <div class="span3 each_hot_article" >
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>">
                <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                </a>
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>" style="margin-top:10px;">
                <?php echo $row_hot['n_title']; ?>
                </a>
            </div>
           <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
            </div>
        </div>
        
        <div style="float:right">
        <?php include('ad_content_right.php'); ?>
        </div>
     </div>
      </div>
      
 
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
    <script language="javascript">
	function chkcontact(){

 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  
  if( $("#c_name").val() ==""){alert('請輸入您的姓名!'); return; }
  if( $("#c_email").val() == "" || !$("#c_email").val().match(myReg)){alert('請輸入您的email!'); return; }
  if( $("#c_cont").val() == ""){alert('請輸入聯絡內容!'); return; }
    
  $("#form1").submit();
}

	function chkmail(){
	
	myReg = /^.+@.+\..{2,3}$/
	if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
	form0.submit();	
		
	}
    </script>
    <script src="js/chkform.js"></script>
  </body>
</html>
<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#slideshow').cycle({
		autostop:			false,     // true to end slideshow after X transitions (where X == slide count) 
		fx:				'fade,',// name of transition effect 
		pause:			false,     // true to enable pause on hover 
		randomizeEffects:	true,  // valid when multiple effects are used; true to make the effect sequence random 
		speed:			1000,  // speed of the transition (any valid fx speed value) 
		sync:			true,     // true if in/out transitions should occur simultaneously 
		timeout:		5000,  // milliseconds between slide transitions (0 to disable auto advance) 
		fit:			true,
		width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
	});
}); 
</script>
