<?php //include('session_check.php'); ?>
<?php
define("WEB_DIR", '/var/www/clients/client1/web2/web');
define("DESTINATION_FOLDER", $_POST['upUrl']);
//target file with now time stamp
$now_timestamp = date_timestamp_get(date_create());
//get source file type name
$filetype = end(explode('.', $_FILES['file']['name']));
$newfile_custom = "pic".$now_timestamp.".".$filetype;
$target = WEB_DIR.DESTINATION_FOLDER."/".$newfile_custom;
if(move_uploaded_file($_FILES['file']['tmp_name'], $target )){
	echo "ok";
} else {
	echo "no";
}
$url = '.'.$_POST['upUrl'].'/'.$newfile_custom;

 ?>
 <script language = "JavaScript">
window.opener.<?php echo $_POST['useForm']; ?>.<?php echo $_POST['prevImg']; ?>.src = '<?php echo $url; ?>';
window.opener.<?php echo $_POST['useForm']; ?>.<?php echo $_POST['reItem']; ?>.value = '<?php echo $newfile_custom; ?>';
window.close();
</Script>