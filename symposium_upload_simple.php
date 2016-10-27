<?php
include('session_check.php');
// include('func/func.php');
//若非合作廠商登入

// if($_SESSION['MEM_TYPE']==""){
    // $_goto = "login_b.php";
    // go_to($_goto);
    // exit;
// }
$editFormAction = $_SERVER['PHP_SELF'];
require_once('Connections/iwine.php');
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


if (isset($_POST["check_form"])) {
  $title = $_POST['title'];
  $insertSQL = sprintf("INSERT INTO symposium (enrollment, area, title, start_date, pic1, contain_html, creator, create_time, contacter, contact_email, contact_phone,active )
                                               VALUES ('%s', '%s', '%s', '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       GetSQLValueString($_POST['enrollment'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($title, "text"),
                       GetSQLValueString($_POST['start_date'], "date"),
                       GetSQLValueString($_POST['pic1'], "text"),
                       GetSQLValueString($_POST['contain_html'], "text"),
                       GetSQLValueString($_SESSION['MEM_ID'], "int"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_POST['contacter'], "text"),
                       GetSQLValueString($_POST['contact_email'], "text"),
                       GetSQLValueString($_POST['contact_phone'], "text"),
                       GetSQLValueString(1, "int"));
                       // echo "insertSQL = <font color=red>".$insertSQL."</font><br>";

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  $_new_id = mysql_insert_id();
    //send_mail to iwantmywine
    require_once('PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer(); // defaults to using php "mail()"

    $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
    <html xmlns=\"http://www.w3.org/1999/xhtml\">
    <head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title></title></head>
    <body>Hi <br>會員".$_SESSION['MEM_NAME']."(".$_SESSION['MEM_ACCOUNT'].")已經新增奇聞 「<b> ".$title." </b>」。<br><br>
    前台顯示請見：<a href=\"http://www.iwine.com.tw/symposium.php?id=$_new_id\">http://www.iwine.com.tw/symposium.php?id=$_new_id</a><br>
    <br>後台修改：<a href=\"http://admin.iwine.com.tw/qpzm105/symposium_s.php?id=$_new_id\">http://admin.iwine.com.tw/qpzm105/symposium_s.php?id=$_new_id</a>
    。</body></html>";
	
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
    $mail->Subject    = "[75.today 奇聞會員上稿通知]標題：".$title." ".$_today;
    $mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test
    $mail->MsgHTML($body);
    $mail->CharSet="utf-8";
    $mail->Encoding = "base64";
    //設置郵件格式為HTML
    $mail->IsHTML(true);
    $mail->Send();
  
  msg_box('新增成功！感謝您提供的奇聞！');
  go_to('symposium_list.php');
  exit;
}

mysql_select_db($database_iwine, $iwine);
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);
?>

<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> 75.today 今日奇文 攔轎上稿</title>
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
    
    <link rel="shortcut icon" href="assets/ico/123.ico">
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
    <script type='text/javascript' src='ckeditor/ckeditor.js'></script>
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
            if($('#county').find(":selected").val()==""){ $("#area_help").html(" * 請選擇區域"); err=5; $('#county').focus(); }
            if($('#title').val()==""){ $("#title_help").html(" * 請填標題"); err=1; $('#title').focus(); }
            if($('#contacter').val()==""){ $("#contacter_help").html(" * 請填聯絡人"); err=1; $('#contacter').focus(); }
            if($('#contact_email').val()==""){ $("#contact_email_help").html(" * 請填聯絡信箱"); err=1; $('#contact_email').focus(); }
            if($('#contact_phone').val()==""){ $("#contact_phone_help").html(" * 請填連絡電話"); err=1; $('#contact_phone').focus(); }
            //if($('textarea#contain_html').val()==""){ err=1; }
            if($('#pic1').val()==""){ $("#pic1_help").html(" * 請至少上傳一張圖片"); err=15; $('#pic1').focus(); }
            if($('#enrollment').val()==""){ $("#enrollment_help").html(" * 請填寫報名資訊"); err=14; $('#enrollment').focus(); }
            if(err > 0){ alert("請提供完整資料，謝謝！"); return false; }
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
                    <img src="images/wine_icon1.png" width="35" height="35"><span class="title">攔轎上稿</span><img src="images/line03.png" width="1000">
                    <span class="span8"></span>

                    <div class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"><span class="hero-unit02" style="border: solid 0px #000000; margin-bottom: 5px; padding: 5px; background-image: url(images/bg2.png); color: #FF0000;">(*號為必填欄位)</span><br>
                    </div>
                    </p>
                  <div class="control-group">
                    <label class="control-label" for="title"><span class="memo">*</span>標 題</label>
                        <div class="controls">
                          <input name="title" type="text" id="title"><span class="memo" id="title_help">*前台輸出 最多顯示40個字元</span>
                    </div>
                  </div>
                    
                    <div class="control-group">
                      <label class="control-label" for="start_date">活動日期 </label>
                        <div class="controls">
                            <input name="start_date" type="text" id="start_date" placeholder="選擇開始時間">
                            <div class="memo" id="date_help"></div>
                        </div>
                    </div>
                     <script language="JavaScript">
        //$(document).ready(function(){
          var myDate = new Date();
          var displayDate = myDate.getFullYear()+'-'+(myDate.getMonth()+1) + '-01 00:00:00';
          var opt1={dateFormat: 'yy-mm-dd',
                    showSecond: false,
                    timeFormat: 'HH:mm:ss',
                    addSliderAccess:true,
                    sliderAccessArgs:{touchonly:false},
                    showButtonPanel: true,
                    defaultValue: displayDate
                    };
            $('#start_date').datetimepicker(opt1);
            $('#end_date').datetimepicker(opt1);
            $('#order_deadline').datetimepicker(opt1);
        //});
    </script>
                    <div class="control-group">
                        <label class="control-label" for="area"><span class="memo">*</span>地點</label>
                        <div class="controls">
                            <div id="twzip"></div>
                        <script language="javascript">
	//twzip
	$('#twzip').twzipcode({
		css: ['addr-county', ]	
	});
	</script>
                          
                        </select><span class="memo" id="area_help"></span>
                        </div>   
                    </div>
                    
                   <div class="control-group">
                    <label class="control-label" for="contacter"><span class="memo">*</span>聯絡人</label>
                        <div class="controls">
                          <input name="contacter" type="text" id="contacter"><span class="memo" id="contacter_help"></span>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="contact_email"><span class="memo">*</span>聯絡信箱</label>
                        <div class="controls">
                          <input name="contact_email" type="text" id="contact_email"><span class="memo" id="contact_email_help"></span>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="contact_phone"><span class="memo">*</span>連絡電話</label>
                        <div class="controls">
                          <input name="contact_phone" type="text" id="contact_phone"><span class="memo" id="contact_phone_help"></span>
                    </div>
                  </div>
  <!--<div class="control-group">
    <label class="control-label" for="enrollment"><span class="memo">*</span>報名資訊</label>
    <div class="controls">
      <textarea name="enrollment" id="enrollment" cols="60" rows="3" class="form-control"></textarea><span class="memo" id="enrollment_help"></span>
    </div>
  </div>-->
        <div class="control-group">
                        <label class="control-label" for="pic1"><span class="memo">*</span>上傳封面照片</label>
                        <div class="controls">
                            <div class="memo" id="description_help"> 請上傳 2MB 以下之圖片</div>
                          <img class="upload_preview" src="temp_upload_icon.jpg" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
                          <input name="Submit_pic1" type="button" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1','fileUpload','width=500,height=300')" value="準備上傳">
                          <input name="pic1" type="hidden" id="pic1" size="4"><span class="memo" id="pic1_help"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="contain_html"><span class="memo">*</span>內容介紹</label>
                        <div class="controls memo" id="description_help"> 可將活動頁面<b>連結</b>一併貼入編輯
                        <textarea name="contain_html" id="contain_html" class="ckeditor"></textarea>
                        <span class="memo" id="description_help">可使用html語法</span>
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
        
        <div class="row">
        <!--<div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30">iWine 排行榜</h4>
            <?php include('ad_1.php'); ?>
        </div>
        div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
        <div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門奇聞 </h4>
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
        
     </div>
      </div>

    </div>
    <?php include('footer.php'); ?>
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
