<?php session_start(); 
include('func/func.php');
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

if($_SESSION['MEM_TYPE'] == "expert"){
    $db_name = "expert";
}else if ($_SESSION['MEM_TYPE'] == "bar"){
    $db_name = "bar";
}else if($_SESSION['MEM_TYPE'] == "wine_supplier"){
    $db_name = "wine_supplier";
}else{
    go_to("login_b.php");
}
$_today = date('Y-m-d H:i:s');
if($_POST['act'] == 'modify'){
    if($_SESSION['MEM_TYPE'] == "expert"){
        $query_update = sprintf("UPDATE %s SET name='%s', mod_time='%s' WHERE id=%s",
                       GetSQLValueString($db_name, "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_SESSION['BMEM_ID'] , "int"));
    }else if ($_SESSION['MEM_TYPE'] == "bar"){
        $query_update = sprintf("UPDATE %s SET company_name='%s', owner='%s', contact='%s', address='%s', telphone='%s', fax='%s', email='%s', vat_num='%s', category='%s', open_time='%s', cons_pattems='%s', products='%s', pic1='%s', pic2='%s', pic3='%s', pic4='%s', pic5='%s',corkage_fee='%s', glass_type='%s', mod_time='%s' WHERE id=%s",
                       GetSQLValueString($db_name, "text"),
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['telphone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['vat_num'], "text"),
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['open_time'], "text"),
                       GetSQLValueString($_POST['cons_pattems'], "text"),
                       GetSQLValueString($_POST['products'], "text"),
                       GetSQLValueString($_POST['pic1'], "text"),
                       GetSQLValueString($_POST['pic2'], "text"),
                       GetSQLValueString($_POST['pic3'], "text"),
                       GetSQLValueString($_POST['pic4'], "text"),
                       GetSQLValueString($_POST['pic5'], "text"),
                       GetSQLValueString($_POST['corkage_fee'], "int"),
                       GetSQLValueString($_POST['glass_type'], "text"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_SESSION['BMEM_ID'] , "int"));
    }else if($_SESSION['MEM_TYPE'] == "wine_supplier"){
        $query_update = sprintf("UPDATE %s SET company_name='%s', owner='%s', contact='%s', address='%s', telphone='%s', fax='%s', email='%s', vat_num='%s', mod_time='%s' WHERE id=%s",
                       GetSQLValueString($db_name, "text"),
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['telphone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['vat_num'], "text"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_SESSION['BMEM_ID'] , "int"));
    }
    $Result1 = mysql_query($query_update, $iwine) or die(mysql_error());
    msg_box('資料修改成功');
    $index_url = "index.php";
      go_to($index_url);
      exit;
}

mysql_select_db($database_iwine, $iwine);
$query_member_check = sprintf("SELECT * FROM %s WHERE account = '%s'", GetSQLValueString($db_name, "text"),GetSQLValueString($_SESSION['BMEM_ACCOUNT'], "text"));

$member_check = mysql_query($query_member_check, $iwine) or die(mysql_error());
$row_member_check = mysql_fetch_assoc($member_check);
$totalRows_member_check = mysql_num_rows($member_check);

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
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link href='js/datetimepick/lib/jquery-ui-timepicker-addon.css' rel='stylesheet'>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-timepicker-addon.js'></script>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-sliderAccess.js'></script>
    <script type='text/javascript' src='js/datetimepick/jquery-ui-timepicker-zh-TW.js'></script>
    <style>
    .memo {
    color: #FF0000;
    }
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
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <?php include('mainmenu_20140903.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
        <div id="MainContent" class="span9">
            
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" id="form1" >
            <img src="images/wine_icon1.png" width="49" height="49"><span class="title">修改會員資料</span><img src="images/line03.png" width="1000">

            <div class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"> 
            <span class="massage">修改會員資料</span> 
            <span class="hero-unit02" style="border: solid 0px #000000; margin-bottom: 5px; padding: 5px; background-image: url(images/bg2.png); color: #FF0000;"></span>
            <br>
            </div>
            </p>
            
<?php if($_SESSION['MEM_TYPE'] == "expert"){ ?>
        <div id="modify_expert">
            <div class="control-group" >
                <label class="control-label" for="account">帳 號</label>
                <div class="controls">
                <?php echo $_SESSION['BMEM_ACCOUNT']; ?>
                <input type="hidden" name="account" value=<?php echo $_SESSION['BMEM_ACCOUNT']?> >
                </div>
            </div>
            <div class="control-group" >
                <label class="control-label" for="name">姓 名</label>
                <div class="controls">
                     <input type="text" name="name" value=<?php echo $row_member_check['name']?> >
                </div>
            </div>
        </div>
<?php  }else if($_SESSION['MEM_TYPE'] == "bar"){ ?>
        <div id="modify_bar">
            <div class="control-group" >
                <label class="control-label" for="account">帳 號</label>
                <div class="controls">
                <?php echo $_SESSION['BMEM_ACCOUNT']; ?>
                <input type="hidden" name="account" value=<?php echo $_SESSION['BMEM_ACCOUNT']?> >
                </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="telphone">電話 </label>
                <div class="controls">
                <input type="text" id="telphone" name="telphone" value="<?php echo $row_member_check['telphone']; ?>">
                <span class="help-inline">*輸入格式如：(02)1234-5678</span></div>
          </div>
            <div class="control-group">
                <label class="control-label" for="email">聯絡e-mail</label>
                <div class="controls">
                <input id="email" name="email" type="text" value="<?php echo $row_member_check['email']; ?>">
                <span class="help-inline">*請輸入可聯絡的e-mail，可與帳號相同</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="company_name">酒吧名稱</label>
                <div class="controls">
                <input id="company_name" name="company_name" type="text" value="<?php echo $row_member_check['company_name']; ?>" >
                <span class="help-inline">*請輸入貴酒吧名稱</span>
              </div>   
            </div>
            <div class="control-group">
                <label class="control-label" for="owner">負責人</label>
                <div class="controls">
                <input id="owner" name="owner" type="text" value="<?php echo $row_member_check['owner']; ?>">
                </div>   
            </div>
 
          <div class="control-group">
                <label class="control-label" for="capacha_code">酒吧分類</label>
              <div class="controls">
                <select name="category" id="category" >
                <?php if ($row_member_check['category'] <> "") {?>
                  <option value="<?php echo $row_member_check['category']; ?>"><?php echo $row_member_check['category']; ?></option>
                <?php }else{ ?>
                    <option value="">請選擇</option>
                <?php } ?>
                  <option value="Lounge Bar">1. Lounge Bar</option>
                  <option value="餐廳酒吧">2. 餐廳酒吧</option>
                  <option value="日式酒吧">3. 日式酒吧</option>
                  <option value="夜店酒吧">4. 夜店酒吧</option>
                  <option value="音樂酒吧">5. 音樂酒吧</option>
                  <option value="運動酒吧">6. 運動酒吧</option>                                            
                  <option value="啤酒酒吧">7. 啤酒酒吧</option>
                  <option value="其他">8. 其他</option>                                                
                </select>
              </div>
          </div>
                    
          <div class="control-group">
            <label class="control-label" for="contact">聯絡人</label>
            <div class="controls">
              <input id="contact" name="contact" type="text" value="<?php echo $row_member_check['contact']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="address">地址</label>
            <div class="controls">
              <input id="address" name="address" type="text" value="<?php echo $row_member_check['address']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="fax">傳真</label>
            <div class="controls">
              <input id="fax" name="fax" type="text" value="<?php echo $row_member_check['fax']; ?>">
              <span class="help-inline">*輸入格式如：(02)1234-5678</span>
            </div>
            
          </div>
          <div class="control-group">
            <label class="control-label" for="vat_num">統一編號</label>
            <div class="controls">
              <input id="vat_num" name="vat_num" type="text" value="<?php echo $row_member_check['vat_num']; ?>">
            </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="capacha_code">葡萄酒杯種類</label>
              <div class="controls">
                <select name="glass_type" id="glass_type" >
                <?php if ($row_member_check['glass_type'] <> "") {?>
                  <option value="<?php echo $row_member_check['glass_type']; ?>"><?php echo $row_member_check['glass_type']; ?></option>
                <?php }else{ ?>
                    <option value="">請選擇</option>
                <?php } ?>
                  <option value="5種以下">1. 5種以下</option>
                  <option value="6-10種">2. 6-10種</option>
                  <option value="11種以上">3. 11種以上</option>                               
                </select>
              </div>
          </div>
            
          <div class="control-group">
            <label class="control-label" for="open_time">營業時間</label>
            <div class="controls">
                <textarea name="open_time" id="open_time" cols="60" rows="5" <?php if($row_member_check['open_time']==""){ ?>placeholder="請輸入營業時間，例：週一至週四18:00~24:00；週五至週日18:00~02:00"<?php }; ?>><?php echo $row_member_check['open_time']; ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="cons_pattems">消費方式</label>
            <div class="controls">
                <textarea name="cons_pattems" id="cons_pattems" cols="80" rows="2" placeholder="請輸入貴酒吧接受的消費方式，例：現金、刷卡"><?php echo $row_member_check['cons_pattems']; ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="products">主力產品</label>
            <div class="controls">
              <textarea name="products" id="products" cols="80" rows="2" placeholder="請輸入貴酒吧的主力產品"><?php echo $row_member_check['products']; ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="products">開瓶費</label>
            <div class="controls">
              <input type="number" min="0" name="corkage_fee" id="corkage_fee" placeholder="" value="<?php echo $row_member_check['corkage_fee']; ?>"> 0 代表無開瓶費
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="pic1">上傳照片</label>
            <div class="controls">
              <?php if ($row_member_check['pic1']<> "" ) {?>
                <img class="upload_preview" src="http://www.iwine.com.tw/webimages/bar/<?php echo $row_member_check['pic1']; ?>" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
              <?php }else{?>
                <img class="upload_preview" src="temp_upload_icon.jpg" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
              <?php } ?>
              <input name="Submit_pic1" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=/webimages/bar&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1','fileUpload','width=500,height=300')" value="準備上傳">
              <input name="pic1" type="hidden" id="pic1" size="4" value="<?php echo $row_member_check['pic1']; ?>">
            </div>
          </div>
          <?php for ($i=2 ; $i<=5; $i++) {?>
                    <?php $c_pic = 'pic'.$i; ?>
                <div class="control-group">
                    <label class="control-label" for="<?php echo $c_pic; ?>">上傳附加照片<?php echo $i-1; ?></label>
                    <div class="controls">
                      <?php if ($row_member_check[$c_pic] <> "") { ?>
                        <img class="upload_preview" src="http://www.iwine.com.tw/webimages/bar/<?php echo $row_member_check[$c_pic]; ?>"" alt="圖片預覽" name="showImg<?php echo $i; ?>" id="showImg<?php echo $i; ?>" onClick='javascript:alert("圖片預覽");'>
                      <?php }else{ ?>
                        <img class="upload_preview" src="temp_upload_icon.jpg" alt="圖片預覽" name="showImg<?php echo $i; ?>" id="showImg<?php echo $i; ?>" onClick='javascript:alert("圖片預覽");'>
                      <?php } ?>
                      <input name="Submit_pic<?php echo $i; ?>" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg<?php echo $i; ?>&amp;upUrl=/webimages/bar&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=<?php echo $c_pic; ?>','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="<?php echo $c_pic; ?>" type="hidden" id="<?php echo $c_pic; ?>" size="4" value="<?php echo $row_member_check['pic1']; ?>">
                    </div>
                </div>
          <?php } ?>
                    
        </div>
<?php }else if($_SESSION['MEM_TYPE'] == "wine_supplier"){ ?>
        <div id="modify_wine_supplier">
            <div class="control-group" >
                <label class="control-label" for="account">帳 號</label>
                <div class="controls">
                <?php echo $_SESSION['BMEM_ACCOUNT']; ?>
                <input type="hidden" name="account" value=<?php echo $_SESSION['BMEM_ACCOUNT']?> >
                </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="telphone">電話 </label>
                <div class="controls">
                <input type="text" id="telphone" name="telphone" value="<?php echo $row_member_check['telphone']; ?>">
                <span class="help-inline">*輸入格式如：(02)1234-5678</span></div>
          </div>
            <div class="control-group">
                <label class="control-label" for="email">聯絡e-mail</label>
                <div class="controls">
                <input id="email" name="email" type="text" value="<?php echo $row_member_check['email']; ?>">
                <span class="help-inline">*請輸入可聯絡的e-mail，可與帳號相同</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="company_name">公司名稱</label>
                <div class="controls">
                <input id="company_name" name="company_name" type="text" value="<?php echo $row_member_check['company_name']; ?>" >
                <span class="help-inline">*請輸入貴公司名稱</span>
              </div>   
            </div>
            <div class="control-group">
                <label class="control-label" for="owner">負責人</label>
                <div class="controls">
                <input id="owner" name="owner" type="text" value="<?php echo $row_member_check['owner']; ?>">
                </div>   
            </div>
            <div class="control-group">
            <label class="control-label" for="contact">聯絡人</label>
            <div class="controls">
              <input id="contact" name="contact" type="text" value="<?php echo $row_member_check['contact']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="address">地址</label>
            <div class="controls">
              <input id="address" name="address" type="text" value="<?php echo $row_member_check['address']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="fax">傳真</label>
            <div class="controls">
              <input id="fax" name="fax" type="text" value="<?php echo $row_member_check['fax']; ?>">
              <span class="help-inline">*輸入格式如：(02)1234-5678</span>
            </div>
            
          </div>
          <div class="control-group">
            <label class="control-label" for="vat_num">統一編號</label>
            <div class="controls">
              <input id="vat_num" name="vat_num" type="text" value="<?php echo $row_member_check['vat_num']; ?>">
            </div>
            </div>
        </div>
<?php }?>
                    <div class="control-group">
                        <div class="controls">
                          <input name="act" type="hidden" value="modify">
                        <button type="submin" class="btn btn-danger">確定修改</button>
                        <button type="reset" class="btn btn-success">重設</button>
                        </div>
             </div>
        </form>
            
            
          
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
    <script src="assets/js/bootstrap.js">
    </script>
    <script src="js/twzipcode-1.4.1.js"></script>
   
    
    
  </body>
</html>
<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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
}); 
</script>
