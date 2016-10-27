<div id="header">
      	<div>
        <table width="100%" border="0" cellpadding="0">
          <tr>
            <td width="38%"><a href="http://www.iwine.com.tw/index.php"><img src="images/iWine_logo.png" width="430" height="125" /></a></td>
            <td width="62%" align="right" valign="middle" style="background-image:url(images/banner.jpg);"><table width="90%" border="0" align="right">
              <tr>
                <td height="101" align="right" valign="bottom">  
               
<a href="login_b.php"><img src="images/btn_symposium_upload.jpg" title="品酒會資料上傳區" width="146" height="33" /></a>
<a href="login_b.php"></a>
<form action="article_search.php">
  
    <div class="header_fb_area" style="display:inline-block; ">
        <div class="fb-like" data-href="http://www.facebook.com/iwine" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
    </div>
    <div style="display:inline-block">
  <input name="keyword" type="text" class="input02-large search-query" id="keyword" placeholder="輸入關鍵字搜尋文章">
 
  <button type="submit" class="btn">搜尋</button>
  </div>
</form>



 <form class="form-inline" role="form" id="order_email" action="" name="order_email">
        <input type="email" class="form-control" id="inputEmail" placeholder="輸入 email 訂閱 iWine 電子報">
        <a class="btn btn-default" value="訂閱" id="update" onclick="orderEmail();">訂閱</a>
    </form>
    
    
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





 </td>
              </tr>
            </table>
          
		
            </td>
          </tr>
        </table>
        
               	
        </div>
</div>
