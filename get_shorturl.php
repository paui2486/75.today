<?php
include_once('bitly/bitly.php');

if(isset($_POST['flag']) && $_POST['flag'] == 1){

$results = bitly_v3_shorten($_POST['url'], 'j.mp');
echo $results['url'];

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <label for="url"></label>
  <input name="url" type="text" id="url" size="80" />
  <input type="submit" name="button" id="button" value="提交" />
  <input name="flag" type="hidden" id="flag" value="1" />
</form>
</body>
</html>