<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
date_default_timezone_set("Asia/Taipei");
$targetFolder = '/webimages/album_photo/1/'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','JPG','GIF','PNG','JPEG'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	$newfile = date('YmdHis').".".$fileParts['extension'];
	$newtarget = rtrim($targetPath,'/') . '/' . $newfile;
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$newtarget);
		echo $newfile;
	} else {
		echo 'icon_prev.gif';
	}
}
?>