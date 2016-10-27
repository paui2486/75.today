<?php session_start(); ?>
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
            
        <form action="regist_check_barsimple.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="form1" >
            <img src="images/wine_icon1.png" width="35" height="35"><span class="title">酒吧註冊會員</span><img src="images/line03.png" width="1000">

            <div class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"> <span class="massage">馬上加入 iWine 酒吧會員！
            </span> <span class="hero-unit02" style="border: solid 0px #000000; margin-bottom: 5px; padding: 5px; background-image: url(images/bg2.png); color: #FF0000;">(*號為必填欄位)</span><br>
            </div>
            </p>
            <div class="control-group">
                <label class="control-label" for="account"><span class="memo">*</span>帳 號</label>
                <div class="controls">
                <input type="text" id="account" name="account" placeholder="請輸入e-mail" onBlur="checkAccount();">
                <span class="help-inline">*請輸入您的e-mail，這將會成為您登入的帳號</span>
                <span class="help-stock"><div id="account_check" style="color:#F00"></div></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password"><span class="memo">*</span>密 碼</label>
                <div class="controls">
                <input type="password" id="password" name="password" placeholder="請輸入密碼">
                <span class="help-inline">*請輸入6碼以上的英文或數字</span>
                </div>
          </div>
          <div class="control-group">
                <label class="control-label" for="password_confirm"><span class="memo">*</span>確認密碼</label>
                <div class="controls">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="請再次輸入密碼">
                <span class="help-inline">*請再次輸入您的密碼</span>
                </div>
            </div>
            <!--div class="control-group">
              <label class="control-label" for="telphone"><span class="memo">*</span>電話 </label>
                <div class="controls">
                <input type="text" id="telphone" name="telphone" placeholder="請輸入可聯絡的電話">
                <span class="help-inline">*輸入格式如：(02)1234-5678</span></div>
          </div>
            <div class="control-group">
                <label class="control-label" for="email"><span class="memo">*</span>聯絡e-mail</label>
                <div class="controls">
                <input id="email" name="email" type="text" placeholder="請輸入可聯絡的e-mail">
                <span class="help-inline">*請輸入可聯絡貴酒吧的e-mail，可與帳號相同</span>
                </div>
            </div-->
            <div class="control-group">
                <label class="control-label" for="company_name"><!--span class="memo">*</span-->酒吧名稱</label>
                <div class="controls">
                <input id="company_name" name="company_name" type="text" placeholder="請輸入酒吧名稱">
                <span class="help-inline">*請輸入貴酒吧名稱</span>
              </div>   
            </div>
            <!--div class="control-group">
                <label class="control-label" for="owner">負責人</label>
                <div class="controls">
                <input id="owner" name="owner" type="text" placeholder="請輸入負責人姓名">
                </div>   
            </div>
 
          <div class="control-group">
                <label class="control-label" for="capacha_code">酒吧分類</label>
              <div class="controls">
                <select name="category" id="category" >
                  <option value="">請選擇</option>
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
                      <input id="contact" name="contact" type="text" placeholder="請輸入聯絡人姓名">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="address">地址</label>
                    <div class="controls">
                      <input id="address" name="address" type="text" placeholder="請輸入公司地址">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="fax">傳真</label>
                    <div class="controls">
                      <input id="fax" name="fax" type="text" placeholder="請輸入傳真號碼">
                      <span class="help-inline">*輸入格式如：(02)1234-5678</span>
                    </div>
                    
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="vat_num">統一編號</label>
                    <div class="controls">
                      <input id="vat_num" name="vat_num" type="text" placeholder="請輸入公司統一編號">
                    </div>
                    </div>
                    
          <div class="control-group">
            <label class="control-label" for="open_time">營業時間</label>
            <div class="controls">
                <textarea name="open_time" id="open_time" cols="60" rows="5" placeholder="請輸入營業時間，例：週一至週四18:00~24:00；週五至週日18:00~02:00"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="cons_pattems">消費方式</label>
            <div class="controls">
                <textarea name="cons_pattems" id="cons_pattems" cols="80" rows="2" placeholder="請輸入貴酒吧接受的消費方式，例：現金、刷卡"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="products">主力產品</label>
            <div class="controls">
              <textarea name="products" id="products" cols="80" rows="2" placeholder="請輸入貴酒吧的主力產品"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="pic1"><span class="memo">*</span>上傳照片</label>
            <div class="controls">
              <img class="upload_preview" src="temp_upload_icon.jpg" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
              <input name="Submit_pic1" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=/webimages/bar&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1','fileUpload','width=500,height=300')" value="準備上傳">
              <input name="pic1" type="hidden" id="pic1" size="4">
            </div>
          </div-->
          
                    <div class="control-group">
                        <label class="control-label" for="capacha_code">驗證碼</label>
                      <div class="controls">
                        <input name="capacha_code" type="text" id="capacha_code" />
                        <span class="help-inline"><img src="securimage/securimage_show.php" alt="CAPTCHA Image" align="absmiddle" id="captcha" /><a href="#" onClick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false" class="btn-small btn-info">更換</a></span>
                      </div>
                    </div>     
                    <div class="control-group">
                        <div class="controls">
                        <label class="checkbox">
                            <input name="m_agree" type="checkbox" id="m_agree" value="Y" /> 我已經閱讀並同意iWine聲明的<a href="law.php" target="new">使用者條款（點我閱讀）</a>。
                        </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                          <input name="check_form" type="hidden" value="Y">
                        <button type="button" class="btn btn-danger" onClick="chkform();">確定註冊</button>
                        <button type="reset" class="btn btn-success">重設</button>
                        </div>
                  </div>
                </form>
                
            
            <div class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
    <script src="js/twzipcode-1.4.1.js"></script>
    <script language="javascript">
    //twzip
    $('#twzip').twzipcode({
        css: ['addr-county', 'addr-area', 'addr-zip']   
    });
    </script>
    <script language="javascript">
    function chkmail(){
    
    myReg = /^.+@.+\..{2,3}$/
    if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
    form0.submit(); 
        
    }
    </script>
    <script language="javascript">
    function chkform(){

 
          myReg = /^.+@.+\..{2,3}$/
          mobileReg = /^[0][9]\d{8}$/
          telcode = /^[0][2-9]{1}/
          telno = /^[1-9]{7}/
          zipno = /^\d{3}/
          
          if( $("#account").val() =="" || !$("#account").val().match(myReg)){alert('請輸入正確格式之E-mail做為帳號!'); return; }
          if( $("#password").val() == ""){alert('請輸入密碼!'); return; }
          if( $("#password").val().length < 6 ){alert('請輸入6字元以上的密碼'); return;  }
          if( $("#password_confirm").val() == ""){alert('請再次確認密碼!'); return; }
          if( $("#password_confirm").val() != $("#password").val() ){alert('密碼確認不一致，請重新輸入!'); return; }
          // if( $("#company_name").val() == ""){alert('請輸入公司名稱!'); return; }  
          if( $("input[name='m_agree']:checked").val() !="Y"){alert('您必須閱讀並勾選同意iWine所聲明之使用者條款才能完成註冊!'); return; }
          
          if(window.confirm('是否確定送出資料並完成註冊？')){
            $("#form1").submit();
          }else{ 
            return; 
          }
}
    
    function checkAccount(){
    
        var num = $.trim($("#account").val());
        
        myReg = /^.+@.+\..{2,3}$/
        
        if( !$("#account").val().match(myReg) ){
            $("#account_check").html("格式錯誤，請輸入e-mail做為帳號!");
            $("#account").val('');
        }else{
        //alert(num);
        $.ajax({
            url: 'check_account_bar.php',
            data: {account: num},
            error: function(xhr) {  },
            success: function(response) { 
            if(response == 'success'){
            $("#account_check").html("此帳號可註冊!");
            }else{
            $("#account_check").html("此帳號已被註冊，請重新輸入!");
            $("#account").val('');
            }
            }
                });
                
}

}
</script>
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
