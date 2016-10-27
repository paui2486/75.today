<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
form {
	margin: 0px;
}
.formword {
	font-family: "Georgia", "Times New Roman", "Times", "serif";
	font-size: 8pt;
}
.box {
	border: 1px dotted #333333;
}
-->
</style>
</head>
<body bgcolor="#EEEEEE" text="#333333" leftmargin="2" topmargin="2" marginwidth="2" marginheight="2">
<form ACTION="fupaction.php" METHOD="POST" name="form1" enctype="multipart/form-data">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0">
    <tr> 
      <td height="20"><table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#999999">
          <tr valign="baseline" class="formword"> 
            <td width="40" align="right"><font color="#FFFFFF">注意：</font></td>
            <td><font color="#FFFFFF"> 允許類型為GIF、JPG、JPEG、PNG , 大小不可超過1MB。</font></td>
          </tr>
        </table>
        
      </td>
    </tr>
    <tr> 
      <td height="20" align="center"> 
        <table border="0" cellpadding="4" cellspacing="0">
          <tr> 
            <td><input name="file" type="file" class="formword" id="file" size="40"></td>
          </tr>
        </table>
        <input name="Submit" type="submit" class="formword" value="開始上傳"> <input name="close" type="button" class="formword" onClick="window.close();" value="關閉視窗">
        <input name="useForm" type="hidden" id="useForm" value="<?php echo $_GET['useForm']; ?>">
        <input name="upUrl" type="hidden" id="upUrl" value="<?php echo $_GET['upUrl']; ?>"> 
        <input name="prevImg" type="hidden" id="prevImg" value="<?php echo $_GET['prevImg']; ?>">
        <input name="reItem" type="hidden" id="reItem" value="<?php echo $_GET['reItem']; ?>">
      </td>
    </tr>
    <tr> 
      <td height="20" align="center"> 
        <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" class="box">
          <tr valign="baseline" class="formword"> 
            <td align="center">&nbsp;</td>
          </tr>
      </table> </td>
    </tr>
  </table>
</form>
</body>
</html>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38686742-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
