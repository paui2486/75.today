<?php //include('session_check.php'); ?>
<html>
<head>
<meta charset="utf-8">
    <title> iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<script language="JavaScript">
<!--
//檢查上傳物件 checkFileUpload(表單名稱,檔案類型,是否需要上傳,檔案大小,圖片最小寬度,圖片最小高度,圖片最大寬度,圖片最大高度,儲存寬度的表單名稱,儲存高度的表單名稱)
function checkFileUpload(form,extensions,requireUpload,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight) {
  document.MM_returnValue = true;
  if (extensions != '') var re = new RegExp("\.(" + extensions.replace(/,/gi,"|") + ")$","i");
  for (var i = 0; i<form.elements.length; i++) {
    field = form.elements[i];
    if (field.type.toUpperCase() != 'FILE') continue;
    if (field.value == '') {
      if (requireUpload) {alert('請選取上傳的檔案！');document.MM_returnValue = false;field.focus();break;}
    } else {
      if(extensions != '' && !re.test(field.value)) {
        alert('這個檔案不符合上傳的類型！\n只有以下的類型才允許上傳： ' + extensions + '。\n請依規定選取新的檔案。');
        document.MM_returnValue = false;field.focus();break;
      }
    document.PU_uploadForm = form;
    re = new RegExp(".(gif|jpg|png|bmp|jpeg)$","i");
    if(re.test(field.value) && (sizeLimit != '' || minWidth != '' || minHeight != '' || maxWidth != '' || maxHeight != '' || saveWidth != '' || saveHeight != '')) {
      setTimeout('if (document.MM_returnValue) document.PU_uploadForm.submit()',500);
      checkImageDimensions(field.value,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight);
    } } }
}

function showImageDimensions() {
  if ((this.minWidth != '' && this.width > this.minWidth) || (this.minHeight != '' && this.height < this.minHeight)) {
    alert('您所上傳的圖片尺寸太小了！\n上傳的圖片大小至少要 ' + this.minWidth + ' x ' + this.minHeight); return;}
  if ((this.maxWidth != '' && this.width > this.maxWidth) || (this.maxHeight != '' && this.height > this.maxHeight)) {
    alert('您所上傳的圖片尺寸為 '+ this.width + ' x ' + this.height+' 太大了！\n上傳的圖片大小不可超過 ' + this.maxWidth + ' x ' + this.maxHeight); return;}
  if (this.sizeLimit != '' && this.fileSize/1000 > this.sizeLimit) {
    alert('您所上傳的檔案為 '+this.fileSize/1000+' KB太大了！\n最大不可超過 ' + this.sizeLimit + ' KB'); return;}
  if (this.saveWidth != '') document.PU_uploadForm[this.saveWidth].value = this.width;
  if (this.saveHeight != '') document.PU_uploadForm[this.saveHeight].value = this.height;
  document.MM_returnValue = true;
}

function checkImageDimensions(fileName,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight) { //v2.0
  document.MM_returnValue = false; var imgURL = 'file:///' + fileName, img = new Image();
  img.sizeLimit = sizeLimit; img.minWidth = minWidth; img.minHeight = minHeight; img.maxWidth = maxWidth; img.maxHeight = maxHeight;
  img.saveWidth = saveWidth; img.saveHeight = saveHeight;
  img.onload = showImageDimensions; img.src = imgURL;
}
//-->
</script>

    
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
</head>
<body bgcolor="#EEEEEE" text="#333333" leftmargin="2" topmargin="2" marginwidth="2" marginheight="2">
<script language="JavaScript" type="text/JavaScript">
var windowW = 500;
var windowH = 250;
windowX = Math.ceil( (window.screen.width  - windowW) / 2 );
windowY = Math.ceil( (window.screen.height - windowH) / 2 );
window.resizeTo( Math.ceil( windowW ) , Math.ceil( windowH ) );
window.moveTo( Math.ceil( windowX ) , Math.ceil( windowY ) );
</script>
<form ACTION="fupaction_custom.php" METHOD="POST" name="form1" enctype="multipart/form-data">

  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0">
    <tr> 
      <td height="20"><table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#999999">
          <tr valign="baseline" class="formword"> 
            <td width="40" align="center">注意：上傳類型為GIF、JPG、JPEG、PNG</td>
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
        <input name="Submit" type="submit" class="formword btn btn-info" value="開始上傳" > <input name="close" type="button" class="formword btn btn-info" onClick="window.close();" value="關閉視窗">
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

