<?php 

session_start(); 
include('func/func.php');
//若非合作廠商登入

if($_SESSION['MEM_TYPE']==""){
    $_goto = "login_b.php";
    go_to($_goto);
    exit;
}
$editFormAction = $_SERVER['PHP_SELF'];
require_once('Connections/iwine.php');
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
$_today = date('Y-m-d H:i:s');
if (isset($_POST["check_form"])) {
  $insertSQL = sprintf("INSERT INTO symposium (title, category, start_date, end_date, location, address, area, fee, host, speaker, wine_list, description, enrollment, creator,creator_type, pic1, pic2, pic3, pic4, pic5, create_time, seats, order_deadline, speaker_info)
                                               VALUES ('%s', '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['start_date'], "date"),
                       GetSQLValueString($_POST['end_date'], "date"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['fee'], "int"),
                       GetSQLValueString($_POST['host'], "text"),
                       GetSQLValueString($_POST['speaker'], "text"),
                       GetSQLValueString($_POST['wine_list'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['enrollment'], "text"),
                       GetSQLValueString($_SESSION['BMEM_ID'], "int"),
                       GetSQLValueString($_SESSION['MEM_TYPE'], "text"),
                       GetSQLValueString($_POST['pic1'], "text"),
                       GetSQLValueString($_POST['pic2'], "text"),
                       GetSQLValueString($_POST['pic3'], "text"),
                       GetSQLValueString($_POST['pic4'], "text"),
                       GetSQLValueString($_POST['pic5'], "text"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_POST['seats'], "int"),
                       GetSQLValueString($_POST['order_deadline'], "date"),
                       GetSQLValueString($_POST['speaker_info'], "text"));
                       // echo "insertSQL = <font color=red>".$insertSQL."</font><br>";
  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());

  msg_box('新增成功！感謝您提供的品酒會情報，請稍後一段時間便會在品酒會情報中揭示囉！');
  go_to('symposium_list.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
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
    </style>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link href='js/datetimepick/lib/jquery-ui-timepicker-addon.css' rel='stylesheet'>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-timepicker-addon.js'></script>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-sliderAccess.js'></script>
    <script type='text/javascript' src='js/datetimepick/jquery-ui-timepicker-zh-TW.js'></script>
    <script src="js/twzipcode-1.4.1.js"></script>
    
    <script type='text/javascript'>
     $(document).ready(function(){
        $("select[name='district']").hide();
        $("input[name='zipcode']").hide();
        $("#send_out").click(function(){
            var err = 0;
            if($('#title').val()==""){ $("#title_help").html(" * 請填標題"); err=1; $('#title').focus(); }
            if($('#category').find(":selected").val()==""){ $("#category_help").html(" * 請選品酒會類型"); err=2;  }
            if($('#start_date').val()=="" || $('#end_date').val()==""){ $("#date_help").html(" * 請選擇起訖時間"); err=3; $('#date_help').focus(); }
            if($('#order_deadline').val()==""){ $("#order_deadline_help").html(" * 請填報名期限"); err=4; $('#order_deadline_help').focus(); }
            if($('#county').find(":selected").val()==""){ $("#area_help").html(" * 請選擇區域"); err=5; $('#county').focus(); }
            if($('#location').val()==""){ $("#location_help").html(" * 請填區域"); err=6; $('#location').focus(); }
            if($('#address').val()==""){ $("#address_help").html(" * 請填地址"); err=7; $('#address').focus(); }
            if($('#seats').val()==""){ $("#seats_help").html(" * 請填名額"); err=8; $('#seats').focus(); }
            if($('#fee').val()==""){ $("#fee_help").html(" * 請填費用"); err=8; $('#fee').focus(); }
            if($('#host').val()==""){ $("#host_help").html(" * 請填主辦單位"); err=9; $('#host').focus(); }
            if($('#speaker').val()==""){ $("#speaker_help").html(" * 請填主講人"); err=10; $('#speaker').focus(); }
            if($('#speaker_info').val()==""){ $("#speaker_info_help").html(" * 請填主講人介紹"); err=11; $('#speaker_info').focus(); }
            if($('#wine_list').val()==""){ $("#wine_list_help").html(" * 請填活動當中的酒單"); err=12; $('#wine_list').focus(); }
            if($('#description').val()==""){ $("#description_help").html(" * 請填活動介紹"); err=13; $('#description').focus(); }
            if($('#enrollment').val()==""){ $("#enrollment_help").html(" * 請填寫報名方式"); err=14; $('#enrollment').focus(); }
            if($('#pic1').val()==""){ $("#pic1_help").html(" * 請至少上傳一張圖片"); err=15; $('#pic1').focus(); }
            if(err > 0){ alert("請提供完整資料，謝謝！"); return false; }
        });
        $('#title').change(function(){ if($('#title').val()!=""){$("#title_help").html("");} });
        $('#category').change(function(){ if($('#category').find(":selected").val()!=""){$("#category_help").html("");} });
        $('#county').change(function(){ if($('#county').find(":selected").val()!=""){$("#area_help").html("");} });
        $('#order_deadline').change(function(){ if($('#order_deadline').val()!=""){$("#order_deadline_help").html("");} });
        $('#location').change(function(){ if($('#location').val()!=""){$("#location_help").html("");} });
        $('#address').change(function(){ if($('#address').val()!=""){$("#address_help").html("");} });
        $('#seats').change(function(){ if($('#seats').val()!=""){$("#seats_help").html("");} });
        $('#fee').change(function(){ if($('#fee').val()!=""){$("#fee_help").html("");} });
        $('#host').change(function(){ if($('#host').val()!=""){$("#host_help").html("");} });
        $('#speaker').change(function(){ if($('#speaker').val()!=""){$("#speaker_help").html("");} });
        $('#speaker_info').change(function(){ if($('#speaker_info').val()!=""){$("#speaker_info_help").html("");} });
        $('#wine_list').change(function(){ if($('#wine_list').val()!=""){$("#wine_list_help").html("");} });
        $('#description').change(function(){ if($('#description').val()!=""){$("#description_help").html("");} });
        $('#enrollment').change(function(){ if($('#enrollment').val()!=""){$("#enrollment_help").html("");} });
        // $('#showImg1').change(function(){ if($('#pic1').val()!=""){$("#pic1_help").html("");} });
        $('#start_date').change(function(){ if($('#start_date').val()!="" && $('#end_date').val()!=""){ $("#date_help").html("");} });
        $('#end_date').change(function(){ if($('#start_date').val()!="" && $('#end_date').val()!=""){ $("#date_help").html("");} });
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
                    <img src="images/wine_icon1.png" width="35" height="35"><span class="title">上傳品酒會資料</span><img src="images/line03.png" width="1000">
                    <span class="span8"></span>

                    <div class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"><span class="hero-unit02" style="border: solid 0px #000000; margin-bottom: 5px; padding: 5px; background-image: url(images/bg2.png); color: #FF0000;">(*號為必填欄位)</span><br>
                    </div>
                    </p>
                  <div class="control-group">
                    <label class="control-label" for="title"><span class="memo">*</span>標 題</label>
                        <div class="controls">
                          <input name="title" type="text" id="title"><span class="memo" id="title_help"></span>
                    </div>
                  </div>
                    <div class="control-group">
                        <label class="control-label" for="category"><span class="memo">*</span>分 類</label>
                        <div class="controls">
                          <select name="category" id="category" >
                          <option value="">請選擇</option>
                          <option value="品酒會">1. 品酒會</option>
                          <option value="餐酒會">2. 餐酒會</option>
                          <option value="品酒課程">3. 品酒課程</option>
                          <option value="酒展">4. 酒展</option>
                          <option value="派對">5. 派對</option>
                          <option value="發表會">6. 發表會</option>
                          <option value="其他">7. 其他</option>
                        </select><span class="memo" id="category_help"></span>
                        </div>
                  </div>
                    <div class="control-group">
                      <label class="control-label" for="m_passwd_confirm"><span class="memo">*</span>活動日期 </label>
                        <div class="controls">
                          <input name="start_date" type="text" id="start_date" placeholder="選擇開始時間"> 至
                        <input name="end_date" type="text" id="end_date" placeholder="選擇結束時間">
                        <div class="memo" id="date_help"></div>
                        </div>
                  </div>
                    <div class="control-group">
                        <label class="control-label" for="m_name"><span class="memo">*</span>報名期限</label>
                        <div class="controls">
                          <input name="order_deadline" type="text" id="order_deadline" placeholder="點選報名截止日期日期"><span class="memo" id="order_deadline_help"></span>
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
                        <label class="control-label" for="area"><span class="memo">*</span>區域</label>
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
                        <label class="control-label" for="location"><span class="memo">*</span>活動地點</label>
                        <div class="controls">
                          <input id="location" name="location" type="text" placeholder="ex: 某某飯店"><span class="memo" id="location_help"></span>
                        </div>   
                    </div>
                    <div class="control-group">
    <label class="control-label" for="address"><span class="memo">*</span>活動地址</label>
    <div class="controls">
      <input name="address" type="text" id="address" size="50" ><span class="memo" id="address_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="fee"><span class="memo">*</span>費用</label>
    <div class="controls">
      <input name="fee" type="number" id="fee" min="0"><span class="memo" id="fee_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="seats"><span class="memo">*</span>名額</label>
    <div class="controls">
      <input name="seats" type="number" id="seats" min="0"><span class="memo" id="seats_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="host"><span class="memo">*</span>主辦單位</label>
    <div class="controls">
      <input name="host" type="text" id="host"><span class="memo" id="host_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="speaker"><span class="memo">*</span>主講人</label>
    <div class="controls">
<input name="speaker" type="text" id="speaker"><span class="memo" id="speaker_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="speaker_info">講師介紹</label>
    <div class="controls">
      <textarea name="speaker_info" id="speaker_info" cols="60" rows="5" class="ckeditor"></textarea><span class="memo" id="speaker_info_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="wine_list"><span class="memo">*</span>酒單</label>
    <div class="controls">
      <textarea name="wine_list" id="wine_list" cols="60" rows="10" class="ckeditor"></textarea><span class="memo" id="wine_list_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile8">活動介紹</label>
    <div class="controls">
      <textarea name="description" id="description" cols="60" rows="10" class="ckeditor"></textarea><span class="memo" id="description_help"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="enrollment"><span class="memo">*</span>報名方式</label>
    <div class="controls">
      <textarea name="enrollment" id="enrollment" cols="60" rows="5" class="ckeditor"></textarea><span class="memo" id="enrollment_help"></span>
    </div>
  </div>
        <div class="control-group">
            <label class="control-label" for="pic1"><span class="memo">*</span>上傳封面照片</label>
            <div class="controls">
              <img class="upload_preview" src="temp_upload_icon.jpg" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
              <input name="Submit_pic1" type="button" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1','fileUpload','width=500,height=300')" value="準備上傳">
              <input name="pic1" type="hidden" id="pic1" size="4"><span class="memo" id="pic1_help"></span>
            </div>
          </div>
          <?php for ($i=2 ; $i<=5; $i++) {?>
                    <?php $c_pic = 'pic'.$i; ?>
                <div class="control-group">
                    <label class="control-label" for="<?php echo $c_pic; ?>">上傳附加照片<?php echo $i-1; ?></label>
                    <div class="controls">
                      <img class="upload_preview" src="temp_upload_icon.jpg" alt="圖片預覽" name="showImg<?php echo $i; ?>" id="showImg<?php echo $i; ?>" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit_pic<?php echo $i; ?>" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg<?php echo $i; ?>&amp;upUrl=/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=<?php echo $c_pic; ?>','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="<?php echo $c_pic; ?>" type="hidden" id="<?php echo $c_pic; ?>" size="4">
                    </div>
                </div>
          <?php } ?>
                    
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
        <div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine 排行榜 </h4>
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
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門文章 </h4>
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
