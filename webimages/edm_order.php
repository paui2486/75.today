<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> iWine</title>
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
            
              <div>
            
                	<img src="images/wine_icon1.png" width="35" height="35"><span class="title">訂閱電子報</span><img src="images/line03.png" width="1000">
                    <span class="span8"></span>

                    <div class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"><span class="hero-unit02" style="border:solid 0px #000000; margin-bottom:5px; padding:5px; background-image:url(images/bg2.png)"><span class="massage">馬上訂閱電子報，跟著iWine一起去旅行吧! </span></span><br>
                    </div>
                    </p>
                  <p>&nbsp;</p>
                 
                  
 <div style="line-height:30px; margin-left:0px;">
  <p>  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td background="images/add.jpg" style="text-align:center;"><form class="form-inline" role="form" id="order_email" action="" name="order_email">
        <p>&nbsp;          </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>
          <input type="email" class="form-control" id="inputEmail" placeholder="輸入 email 訂閱 iWine">
          <a class="btn btn-default" value="訂閱" id="update" onclick="orderEmail();">訂閱</a> </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </form>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p></td>
    </tr>
  </table>
  <p><!--訂閱-start-->                
  <!--訂閱-end-->          
      </div>



<script type="text/javascript">
    function orderEmail(){
        myReg = /^.+@.+\..{2,3}$/
        var email_data = $("#inputEmail").val();
        if( !$("#inputEmail").val().match(myReg) ){
           alert("E-mail 格式錯誤，請檢查重填，謝謝！");
            $("#inputEmail").val('');
        }else{
            $.ajax({
                url: 'member_order_email.php',
                data: {email: email_data},
                error: function(xhr) {  },
                success: function(response) { alert(response); }
            });
        }
    };
</script>                  
                  
                  
                  

                
              </div>
            </div>
            <div class="span9">
            <div class="fb-like-box" data-href="https://www.facebook.com/iwine" data-width="800px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
            </div>
          </div>
          
        </div>
        
        <div class="row">
        <!--div class="span3" align="center">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30">熱門排行</h4>
        	<?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
     	   <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
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
      
      <div class="row">
      <?php include('footer.php'); ?>
      </div>
    </div>
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
