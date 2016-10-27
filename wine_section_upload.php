<?php
include('session_check.php');
//Press-release
// include('func/func.php');
//若非合作廠商登入

// if($_SESSION['MEM_TYPE']==""){
    // $_goto = "login_b.php";
    // go_to($_goto);
    // exit;
// }
$n_cuisine = $_POST ['n_cuisine'];//n_cuisine 陣列傳進來 先另存
$myallcuisine = implode (",", $n_cuisine);// 利用這個方法將陣列轉換成一筆一筆 幹注意"" ““
//print_r($n_cuisine);
$editFormAction = $_SERVER['PHP_SELF'];//PHP 取得目前網址技巧 http://www.wibibi.com/info.php?tid=85
require_once('Connections/iwine.php');//連線DB資料
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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
$_today = date('Y-m-d H:i:s');

if (isset($_POST["check_form"])) {//這邊上傳 所發布的資料
  $title = $_POST['n_ws'];
  $insertSQL = sprintf("INSERT INTO Wine_section (n_ws, n_ws_eng, n_type, n_poo, n_ac, n_capacity, n_winery, pic1, n_Variety, n_year, n_cuisine, Article)
                                               VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       
					   GetSQLValueString($title, "text"),//酒名
					   GetSQLValueString($_POST['n_ws_eng'], "text"),//酒名英文
					   GetSQLValueString($_POST['n_type'], "text"),//酒類型
                       //GetSQLValueString($_POST['start_date'], "date"),//編輯日期
                       GetSQLValueString($_POST['n_poo'], "text"),//原產地
					   GetSQLValueString($_POST['n_ac'], "text"),//酒精濃度
					   GetSQLValueString($_POST['n_capacity'], "text"),//容量
					   GetSQLValueString($_POST['n_winery'], "text"),//酒莊
					   GetSQLValueString($_POST['pic_1'], "text"),//圖片
					   GetSQLValueString($_POST['n_Variety'], "text"),//價格
					   GetSQLValueString($_POST['n_year'], "text"),//年分
					   GetSQLValueString($myallcuisine, "text"),//適合料理
					   GetSQLValueString($_POST['Article'], "text"));//文章
					   
					   
                       // echo "insertSQL = <font color=red>".$insertSQL."</font><br>";

  mysql_select_db($database_iwine, $iwine);//這邊是當使用者上傳成功後 抓mail資料通知USER 確實有成功寫入活動 
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  $_new_id = mysql_insert_id();
    //send_mail to iwantmywine
    require_once('PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer(); // defaults to using php "mail()"

    $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
    <html xmlns=\"http://www.w3.org/1999/xhtml\">
    <head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title></title></head>
    <body>Hi <br>會員".$_SESSION['MEM_NAME']."(".$_SESSION['MEM_ACCOUNT'].")已經新增酒款訊息 「<b> ".$title." </b>」。<br><br>
    前台顯示請見：<a href=\"http://www.iwine.com.tw//latest-news.php?id=$_new_id\">http://iwine.com.tw/latest-news.php?id=$_new_id</a><br>
    <br>後台修改：<a href=\"http://admin.iwine.com.tw/qpzm105/Press_release_s.php?id=$_new_id\">http://admin.iwine.com.tw/qpzm105/Press_release_s.php?id=$_new_id</a>
    。</body></html>";
	//前後台連結有空再改
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
$mail->Username   = "service@iwine.com.tw"; // SMTP account username
$mail->Password   = "service53118909";        // SMTP account password

    $mail->AddReplyTo("service@iwine.com.tw","iWine");
    $mail->SetFrom('service@iwine.com.tw',"iWine");
    // $address = "iwantmywine@gmail.com";
    // $address = "draqyang@coevo.com.tw";
    
    // $mail->AddAddress("draqyang@coevo.com.tw");
    $mail->AddAddress("all@iwine.com.tw");
    // $mail->AddAddress("draqyang@coevo.com.tw");
    $mail->Subject    = "[iWine新聞稿活動會員上稿通知]標題：".$title." ".$_today;
    $mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test
    $mail->MsgHTML($body);
    $mail->CharSet="utf-8";
    $mail->Encoding = "base64";
    //設置郵件格式為HTML
    $mail->IsHTML(true);
    $mail->Send();
  
  msg_box('新增成功！感謝您提供的酒款情報！');
  go_to('wine-section-list.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> 上傳酒款情報 - iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
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
    .memo {
    color: #FF0000;
    }
    textarea {
        visibility: hidden;
        display: none;
    }
    .cke_toolbar_break {
        display: none !important;
    clear: none !important; }
    .ui-datepicker {
        z-index: 1000000 !important;
    }
    .form-control{
        visibility: visible !important;
        width: 650px;
}
    </style>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
    <script type='text/javascript' src='ckeditor/ckeditor.js'></script><!-- html編輯器 ckeditor-->
	
	<script src="ckfinder/ckfinder.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link href='js/datetimepick/lib/jquery-ui-timepicker-addon.css' rel='stylesheet'>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-timepicker-addon.js'></script>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-sliderAccess.js'></script>
    <script type='text/javascript' src='js/datetimepick/jquery-ui-timepicker-zh-TW.js'></script>
   <script src="js/twzipcode-1.4.1.js"></script>
    <script src="js/twzipcode-1.4.1.js"></script>
    
    <script type='text/javascript'>
     $(document).ready(function(){
        $("select[name='district']").hide();
        $("input[name='zipcode']").hide();
        $("#send_out").click(function(){
            var err = 0;
            
            if($('#pic_1').val()==""){ $("#pic_1_help").html(" * 請至少上傳一張圖片"); err=15; $('#pic_1').focus(); }

        });
        $('#title').change(function(){ if($('#title').val()!=""){$("#title_help").html("");} });
        $('#fee').change(function(){ if($('#fee').val()!=""){$("#fee_help").html("");} });
     });
    </script>
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
            
              <div>
                <form action="<?php echo $editFormAction;?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="form1" >
                    <img src="images/wine_icon1.png" width="35" height="35"><span class="title">上傳酒款資料</span><img src="images/line03.png" width="1000">
                    <span class="span8"></span>

                    <div class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"><span class="hero-unit02" style="border: solid 0px #000000; margin-bottom: 5px; padding: 5px; background-image: url(images/bg2.png); color: #FF0000;">(*號為必填欄位)</span><br>
                    </div>
                    </p>
                  <div class="control-group">
                    <label class="control-label" for="n_ws"><span class="memo">*</span>酒 名(中文)</label>
                        <div class="controls">
                          <input name="n_ws" type="text" id="n_ws"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				  <div class="control-group">
                    <label class="control-label" for="n_ws_eng"><span class="memo">*</span>酒 名(英文)</label>
                        <div class="controls">
                          <input name="n_ws_eng" type="text" id="n_ws_eng"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				  <div class="control-group">
                    <label class="control-label" for="n_type"><span class="memo">*</span>類 型</label>
                        <div class="controls">
                          <input name="n_type" type="text" id="n_type"><span class="memo" id="title_help">(紅酒、白酒、氣泡...)</span>
                    </div>
                  </div>
				  
				  <div class="control-group">
                    <label class="control-label" for="n_poo"><span class="memo">*</span>原 產 地</label>
                        <div class="controls">
                          <input name="n_poo" type="text" id="n_poo"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				  
				  <div class="control-group">
                    <label class="control-label" for="n_ac"><span class="memo">*</span>酒 精 濃 度</label>
                        <div class="controls">
                          <input name="n_ac" type="text" id="n_ac"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				  <div class="control-group">
                    <label class="control-label" for="n_capacity"><span class="memo">*</span>容 量</label>
                        <div class="controls">
                          <input name="n_capacity" type="text" id="n_capacity"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				  <div class="control-group">
                    <label class="control-label" for="n_winery"><span class="memo">*</span>酒 莊</label>
                        <div class="controls">
                          <input name="n_winery" type="text" id="n_winery"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				<div class="control-group">
                    <label class="control-label" for="n_Variety"><span class="memo">*</span>價 格</label>
                        <div class="controls">
                          <input name="n_Variety" type="text" id="n_Variety"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				  
				  <div class="control-group">
                    <label class="control-label" for="n_year"><span class="memo">*</span>年 分</label>
                        <div class="controls">
                          <input name="n_year" type="text" id="n_year"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
				  <!--<div class="control-group">
                    <label class="control-label" for="n_cuisine"><span class="memo">*</span>適合料理</label>
                        <div class="controls">
							<select name="n_cuisine" type="text" id="n_cuisine"><span class="memo" id="title_help"></span>
　										<option value="日式料理">日式料理</option>
　 										<option value="義式料理">義式料理</option>
										<option value="法式料理">法式料理</option>
										<option value="美式料理">美式料理</option>
										<option value="泰式料理">泰式料理</option>
										<option value="西班牙料理">西班牙料理</option>
										<option value="台菜料理">台菜料理</option>
										<option value="西式料理">西式料理</option>
										<option value="港式料理">港式料理</option>
							</select>
                    </div>
                  </div>-->
				  <div class="control-group">
                    <label class="control-label" for="n_cuisine[]"><span class="memo">*</span>適合料理</label>
                    <div class="controls">
					<table>
					<tr>
					<td><input type="checkbox" name="n_cuisine[]" value="日式料理"><label>日式料理</label></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="checkbox" name="n_cuisine[]" value="義式料理"><label>義式料理</label></td>
					</tr>
					<tr>
					<td><input type="checkbox" name="n_cuisine[]" value="法式料理"><label>法式料理</label></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="checkbox" name="n_cuisine[]" value="美式料理"><label>美式料理</label></td>
					</tr>
					<tr>
					<td><input type="checkbox" name="n_cuisine[]" value="泰式料理"><label>泰式料理</label></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="checkbox" name="n_cuisine[]" value="西班牙料理"><label>西班牙料理</label></td>
					</tr>
					<tr>
					<td><input type="checkbox" name="n_cuisine[]" value="台菜料理"><label>台菜料理</label></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="checkbox" name="n_cuisine[]" value="西式料理"><label>西式料理</label></td>
					</tr>
					<tr>
					<td><input type="checkbox" name="n_cuisine[]" value="港式飲茶"><label>港式飲茶</label></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><!--<input type="checkbox" name="n_cuisine[]" value=""><label></label>--></td>
					</tr>
					</table>
							
							

                    </div>
                  </div>
                  <div class="control-group">
                        <label class="control-label" for="Article"><span class="memo">*</span>內容介紹</label>
                        <div class="controls memo" id="description_help"> 可將活動頁面<b>連結</b>一併貼入編輯
                        <textarea name="Article" id="Article" class="ckeditor"></textarea>
							<script>
							CKEDITOR.replace( 'Article', {
							filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
							filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
							filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
							filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
							filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
							filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
							allowedContent : true
							});
							</script>                       
                        </div>
                 </div>

                    
                 <!-- <div class="control-group">
                    <label class="control-label" for="contacter"><span class="memo">*</span>聯絡人</label>
                        <div class="controls">
                          <input name="contacter" type="text" id="contacter"><span class="memo" id="contacter_help"></span>
                    </div>
                  </div> -->
                  
					<div class="control-group">
                        <label class="control-label" for="pic_1"><span class="memo">*</span>上傳酒款封面照片</label>
                        <div class="controls">
                            <div class="memo" id="description_help"> 請上傳 2MB 以下之圖片 並且圖片大小在800X540以上或此比例</div>
                          <img class="upload_preview" src="temp_upload_icon.jpg" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
                          <input name="Submit_pic_1" type="button" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic_1','fileUpload','width=500,height=300')" value="準備上傳"><!--檔案上傳到 /webimages/symposium-->
                          <input name="pic_1" type="hidden" id="pic_1" size="4"><span class="memo" id="pic_1_help"></span>
                        </div>
                    </div>

                    
                    <div class="control-group">
                        <div class="controls">
                          <input name="check_form" type="hidden" value="Y">
                        <button type="submit" class="btn btn-danger" id="send_out">確定上傳</button>
                        <button type="reset" class="btn btn-success">重設</button>
                        </div>
                    </div>
                </form>
                
              </div>
            </div>
            
          </div>
          
        </div>
		</div>
		</div>
		<?php include('footerF.php'); ?>
    <script src="assets/js/bootstrap.js"></script>
		</body>
		</html>
		<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
//$(document).ready(function() {
    $('#slideshow').cycle({
        autostop:           false,     // true to end slideshow after X transitions (where X == slide count) 
        fx:             'fade,',// name of transition effect 
        pause:          false,     // true to enable pause on hover 
        randomizeEffects:   true,  // valid when multiple effects are used; true to make the effect sequence random 
        speed:          1000,  // speed of the transition (any valid fx speed value) 
        sync:           true,     // true if in/out transitions should occur simultaneously 
        timeout:        5000,  // milliseconds between slide transitions (0 to disable auto advance) 
        fit:            true,
        width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
    });
//}); 
</script>
