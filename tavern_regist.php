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
    <div class="container">
      <?php include('header.php'); ?>
      <ul class="nav nav-pills">
        <div id="nav_menu" class="navbar">
        
         
          <div class="navbar-inner">
            <div class="container-fluid">
              <?php include('mainmenu.php'); ?>
            </div>
          </div>
        </div>
      </ul>
      
      <div class="row">
        <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
            
              <div>
                <form action="regist_check.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="form1" >
                	<img src="images/wine_icon1.png" width="35" height="35"><span class="title">酒館註冊會員</span><img src="images/line03.png" width="1000">
                    <span class="span8"></span>

                    <div class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"> <span class="massage">馬上加入iWine <span class="title">酒館會員</span>!
                    </span> <span class="hero-unit02" style="border: solid 0px #000000; margin-bottom: 5px; padding: 5px; background-image: url(images/bg2.png); color: #FF0000;">(*號為必填欄位)</span><br>
                    </div>
                    </p>
                  <div class="control-group">
				    <label class="control-label" for="m_account"><span class="memo">*</span>帳 號</label>
    					<div class="controls">
      					<input type="text" id="m_account" name="m_account" placeholder="請輸入e-mail" onBlur="checkAccount();">
                        <span class="help-inline">*請輸入您的e-mail，這將會成為您登入的帳號</span>
                        <span class="help-stock"><div id="account_check" style="color:#F00"></div></span>
   					</div>
				  </div>
  					<div class="control-group">
    					<label class="control-label" for="m_passwd"><span class="memo">*</span>密 碼</label>
    					<div class="controls">
      					<input type="password" id="m_passwd" name="m_passwd" placeholder="請輸入密碼">
                        <span class="help-inline">*請輸入6碼以上的英文或數字</span>
   					  </div>
				  </div>
                    <div class="control-group">
   					  <label class="control-label" for="m_passwd_confirm"><span class="memo">*</span>電話 </label>
    					<div class="controls">
      					<input type="password" id="m_passwd_confirm" name="m_passwd_confirm" placeholder="請再次輸入密碼">
      					<span class="help-inline">*輸入格式如：0988123789</span></div>
				  </div>
                    <div class="control-group">
						<label class="control-label" for="m_name"><span class="memo">*</span>e-mail</label>
						<div class="controls">
						<input id="m_name" name="m_name" type="text" placeholder="請輸入姓名">
						</div>
                    </div>
                    <div class="control-group">
						<label class="control-label" for="m_year"><span class="memo">*</span>名稱</label>
						<div class="controls">
						<input id="m_mobile9" name="m_mobile9" type="text" placeholder="請輸入手機號碼">
					  </div>   
					</div>
                    <div class="control-group">
						<label class="control-label" for="m_mobile">負責人</label>
						<div class="controls">
						<input id="m_mobile" name="m_mobile" type="text" placeholder="請輸入手機號碼">
						</div>   
					</div>
                    

                    
                    
                  <div class="control-group">
    					<label class="control-label" for="capacha_code">酒吧分類</label>
   					  <div class="controls">
   					    <div id="twzip"></div>
   					    <select name="select" id="select">
   					      <option>酒吧分類</option>
				        </select>
   					  </div>
                  </div>
                    
<div class="control-group">
  <div class="control-group">
    <label class="control-label" for="m_mobile2">聯絡人</label>
    <div class="controls">
      <input id="m_mobile2" name="m_mobile2" type="text" placeholder="請輸入手機號碼">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile3">地址</label>
    <div class="controls">
      <input id="m_mobile3" name="m_mobile3" type="text" placeholder="請輸入手機號碼">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile4">傳真</label>
    <div class="controls">
      <input id="m_mobile4" name="m_mobile4" type="text" placeholder="請輸入手機號碼">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile5">統一編號</label>
    <div class="controls">
      <input id="m_mobile5" name="m_mobile5" type="text" placeholder="請輸入手機號碼">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile6">營業時間</label>
    <div class="controls">
      <input id="m_mobile6" name="m_mobile6" type="text" placeholder="請輸入手機號碼">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile7">消費方式</label>
    <div class="controls">
      <input id="m_mobile7" name="m_mobile7" type="text" placeholder="請輸入手機號碼">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile8">主力產品</label>
    <div class="controls">
      <input id="m_mobile8" name="m_mobile8" type="text" placeholder="請輸入手機號碼">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile9"><span class="memo">*</span>上傳照片一</label>
    <div class="controls">
      <input type="file" name="fileField" id="fileField">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile10">上傳照片二</label>
    <div class="controls">
      <input type="file" name="fileField2" id="fileField2">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile11">上傳照片三</label>
    <div class="controls">
      <input type="file" name="fileField3" id="fileField3">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile12">上傳照片四</label>
    <div class="controls">
      <input type="file" name="fileField4" id="fileField4">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="m_mobile13">上傳照片五</label>
    <div class="controls">
      <input type="file" name="fileField5" id="fileField5">
    </div>
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
                
              </div>
            </div>
            
          </div>
          
        </div>
        
        <div class="row">
        <div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30">熱門排行</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
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
  
  if( $("#m_account").val() =="" || !$("#m_account").val().match(myReg)){alert('請輸入正確格式之E-mail做為帳號!'); return; }
  if( $("#m_passwd").val() == ""){alert('請輸入密碼!'); return; }
  if( $("#m_passwd").val().length < 6 ){alert('請輸入6字元以上的密碼'); return;  }
  if( $("#m_passwd_confirm").val() == ""){alert('請再次確認密碼!'); return; }
  if( $("#m_passwd_confirm").val() != $("#m_passwd").val() ){alert('密碼確認不一致，請重新輸入!'); return; }
  if( $("#m_name").val() == ""){alert('請輸入姓名!'); return; }  
  if( $("#m_mobile").val() =="" || !$("#m_mobile").val().match(mobileReg)){alert('請輸入正確之手機號碼！'); return; }
  if( $("input[name='m_agree']:checked").val() !="Y"){alert('您必須閱讀並勾選同意iWine所聲明之使用者條款才能完成註冊!'); return; }
  if( $("input[name='m_a18']:checked").val() !="Y"){alert('您必須年滿18歲才能完成註冊!'); return; }
  
  if(window.confirm('是否確定送出資料並完成註冊？')){
  $("#form1").submit();
  }else{ return; }
}

	
	function checkAccount(){
	
		var num = $.trim($("#m_account").val());
		
		myReg = /^.+@.+\..{2,3}$/
		
		if( !$("#m_account").val().match(myReg) ){
			$("#account_check").html("格式錯誤，請輸入e-mail做為帳號!");
			$("#m_account").val('');
		}else{
		//alert(num);
		$.ajax({
    		url: 'check_account.php',
    		data: {m_account: num},
    		error: function(xhr) {  },
    		success: function(response) { 
			if(response == 'success'){
			$("#account_check").html("此帳號可註冊!");
			}else{
			$("#account_check").html("此帳號已被註冊，請重新輸入!");
			$("#m_account").val('');
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
