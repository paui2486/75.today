<div id="header">

<div style="width:50%; float:left;">
<a href="http://www.iwine.com.tw/index.php"><img src="images/iWine_logo.png" width="430" height="125" /></a>
</div>

<div style="width:40%; float:right;">
<form class="form-inline" role="form" id="order_email" action="" name="order_email">
  <input type="email" class="form-control input02-large" id="inputEmail" placeholder="輸入 email 訂閱 iWine">
        <a class="btn btn-default" value="訂閱" id="update" onclick="orderEmail();">訂閱</a>
  </form>
</div>


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


