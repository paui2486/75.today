<?php
/*
$curr_page = ($_POST['nowpage']!='')?$_POST['nowpage']:$_GET['nowpage'];
$curr_page = ($curr_page!='')?$curr_page:1;

function backend_page_function($rs,$PHPSELF,$last_page,$arr){
	if(!empty($arr)){
		while(list($kk,$vv)=each($arr)){
			$tmp1 .= "$kk=$vv&";
		}
	}
	$tmp1 = substr ($tmp1, 0,strlen($tmp1)-1);
	if (strlen($tmp1)>0) $tmp1= '&'.$tmp1;
	$tmp2 = 'i&nbsp;&nbsp;<a href="'.$PHPSELF.'?next_page=1' . $tmp1 . '">第一頁</a>&nbsp;|&nbsp;<a href="'.$PHPSELF.'?next_page='.($rs->AbsolutePage()-1). $tmp1 .'">上一頁</a>&nbsp;|&nbsp;&nbsp;<a href="'.$PHPSELF.'?next_page='.($rs->AbsolutePage()+1). $tmp1 .'">下一頁</a>|&nbsp;&nbsp;<a href="'.$PHPSELF.'?next_page='. $last_page . $tmp1 . '">最後頁</a>&nbsp;j';
	return $tmp2;
}
*/
function filter_sql($str)
        {
            if(empty($str)) return;
            if($str=="") return $str;
            $str=str_replace("&"," ",$str);
            $str=str_replace(">"," ",$str);
            $str=str_replace("<"," ",$str);
            $str=str_replace("chr(32)"," ",$str);
            $str=str_replace("chr(9)"," ",$str);
            $str=str_replace("chr(34)"," ",$str);
            $str=str_replace("\""," ",$str);
            $str=str_replace("chr(39)"," ",$str);
            $str=str_replace(""," ",$str);
            $str=str_replace("'"," ",$str);
            $str=str_replace("select"," ",$str);
            $str=str_replace("join"," ",$str);
            $str=str_replace("union"," ",$str);
            $str=str_replace("where"," ",$str);
            $str=str_replace("insert"," ",$str);
            $str=str_replace("delete"," ",$str);
            $str=str_replace("update"," ",$str);
            $str=str_replace("like"," ",$str);
            $str=str_replace("drop"," ",$str);
            $str=str_replace("create"," ",$str);
            $str=str_replace("modify"," ",$str);
            $str=str_replace("rename"," ",$str);
            $str=str_replace("alter"," ",$str);
            $str=str_replace("cas"," ",$str);
            $str=str_replace("replace"," ",$str);
            $str=str_replace("%"," ",$str);
            $str=str_replace("or"," ",$str);
            $str=str_replace("and"," ",$str);
            $str=str_replace("!"," ",$str);
            $str=str_replace("xor"," ",$str);
            $str=str_replace("not"," ",$str);
            $str=str_replace("user"," ",$str);
            $str=str_replace("||"," ",$str);
            $str=str_replace("<"," ",$str);
            $str=str_replace(">"," ",$str);
            $str=str_replace("="," ",$str);
            return str_replace(array("\t"," ","\n","\r\n","'"),'',$str);
        }

function msg_box($msg){
	if ($msg != ""){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		echo '<script language="javascript">alert("'.$msg.'");</script>';
	}
	return "";
}

function go_to($go){
	if($go==1 || $go == -1)
		echo '<script language="javascript">history.go('.$go.')</script>';
	elseif($go == -2)
		echo '<script language="javascript">history.back()</script>';
	else
		echo '<script language="javascript">window.location=("'.$go.'")</script>';		
}


function get_client_ip() {
	global $_SERVER;
	if (isset($_SERVER['HTTP_VIA']) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			list($IP,$USE_DNS)=split(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
			$PROXY=$_SERVER['REMOTE_ADDR'];
			
	} else {
			$IP = $_SERVER['REMOTE_ADDR'];
	}
	return $IP;
}

function GetSQLValueString($theValue){
	//$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	if(get_magic_quotes_gpc()) {
		if($theValue!=''){
			$theValue = stripslashes($theValue);
		}
	}
	
	$theValue = function_exists("mysql_real_escape_string") ?mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	return $theValue;
}
function ImageResize($from_filename, $save_filename='', $in_width=400, $in_height=300, $quality=100)
{
    $allow_format = array('jpeg', 'png', 'gif');
    $sub_name = $t = '';

    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }

    // 取得縮在此範圍內的比例
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);

    // $function_name: set function name
    //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
    /*
    // $sub_name = jpeg, png, gif
    $function_name = 'imagecreatefrom'.$sub_name;
    $image = $function_name($filename); //$image = imagecreatefromjpeg($filename);
    */
	switch($sub_name){
		case 'jpeg':
			$image = imagecreatefromjpeg($from_filename);
			break;
		case 'png':
			$image = imagecreatefrompng($from_filename);
			break;
		case 'gif':
			$image = imagecreatefromgif($from_filename);
			break;
	}
   

    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    //return imagejpeg($image_new, $save_filename, $quality);
	//header('Content-type: image/jpeg');
	imagejpeg($image_new, $save_filename, $quality);
	imagedestroy($image_new);
}

/**
 * 抓取要縮圖的比例
 * $source_w : 來源圖片寬度
 * $source_h : 來源圖片高度
 * $inside_w : 縮圖預定寬度
 * $inside_h : 縮圖預定高度
 *
 * Test:
 *   $v = (getResizePercent(1024, 768, 400, 300));
 *   echo 1024 * $v . "\n";
 *   echo  768 * $v . "\n";
 */
function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}

function log_times($table_name,$index_id,$type){
	global $db;
	$log_time = date('Y-m-d');
	$log_time2 = mktime();
	$from_ip = get_client_ip();
	$strSQL ="insert into log_times(table_name, index_id, type, log_time, log_time2, from_ip) values('$table_name', '$index_id', '$type', '$log_time', '$log_time2', '$from_ip');";
	//echo $strSQL;
	//exit;
	$db->Execute($strSQL);

}

function cut_picture($from_filename, $save_filename='', $in_width=400, $in_height=300, $quality=100){
	$filename=$from_filename;   //要切割的大图
	$tempdir=$save_filename; //要存放的路径
	$picW=$in_width;//切割后图片宽
	$picH=$in_height;//切割后图片高
	list($width, $height, $type, $attr) = getimagesize($filename);//获取大图属性

	if($height<$picH){
		$picH = $height;
	}
	$image = imagecreatefromjpeg($filename); 
	$im = @imagecreatetruecolor($picW, $picH) or die("Cannot Initialize new GD image stream");
	//$im = imagecreatetruecolor($picW, $picH);
	//$colBG = imagecolorallocate($im, 255, 255, 255);
	imagefill( $im, 0, 0, $colBG );//创建背景为白色的图片
	imagecopy ( $im, $image, 0, 0, 0, 0, $picW, $height );
	imagejpeg($im, $save_filename, $quality);
	//echo ceil($height/$picH);
	//exit;
	/*$image = imagecreatefromjpeg($filename); 
	for ($i=0;$i<ceil($width/$picW);$i++){
		for ($j=0;$j<ceil($height/$picH);$j++){
			$im = @imagecreatetruecolor($picW, $picH) or die("Cannot Initialize new GD image stream");
			$colBG = imagecolorallocate($im, 255, 255, 255);
			imagefill( $im, 0, 0, $colBG );//创建背景为白色的图片
			$picX=($picW*($i+1))<$width?$picW:($picW+$width-$picW*($i+1));
			$picY=($picW*($j+1))<$height?$picW:($picW+$height-$picW*($j+1));   //为获取不完整图片坐标     
			imagecopy ( $im, $image, 0, 0, ($picW*$i), ($picH*$j), $picX, $picY );
			//imagejpeg($im,$tempdir.$j.",".$i.".jpg",100);//生成图片 定义命名规则
			imagejpeg($im, $save_filename, $quality);

		}
	}*/
	imagedestroy($im);
}

function FormValueEncode($form){
	if(is_array($form)){
		foreach($form as $kk=>$vv){
			$tmp .= urlencode($kk).'='.urlencode($vv).'&';
		}
		return $tmp;
	}
}

function gTranslate($text,$origLan,$transLan) {
    $url  = 'http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q='.urlencode($text) ;
    $url .= '&langpair='.$origLan.'|'.$transLan ;
 
    $response = file_get_contents($url);
    $decoded = json_decode( $response, true );
	print_r($decoded);
    return $decoded['responseData']['translatedText'] ;
}

//***** PHP中限制文字顯示自訂函式開始 *****
function substr_utf8($str, $lenth)
{
    $start = 0;
    $len = strlen($str);
    $r = array();
    $n = 0;
    $m = 0;
    for($i = 0; $i < $len; $i++) {
    $x = substr($str, $i, 1);
    $a = base_convert(ord($x), 10, 2);
    $a = substr('00000000'.$a, -8);
    if ($n < $start){
        if (substr($a, 0, 1) == 0) {
        }elseif (substr($a, 0, 3) == 110) {
           $i += 1;
       }elseif (substr($a, 0, 4) == 1110) {
           $i += 2;
   }
   $n++;
   }else{
         if (substr($a, 0, 1) == 0) {
             $r[] = substr($str, $i, 1);
         }elseif (substr($a, 0, 3) == 110) {
             $r[] = substr($str, $i, 2);
             $i += 1;
         }elseif (substr($a, 0, 4) == 1110) {
            $r[] = substr($str, $i, 3);
            $i += 2;
         }else{
              $r[] = '';
         }
   if (++$m >= $lenth){
        break;
   }
}
}
return implode("",$r);
} 

//***** PHP中限制文字顯示自訂函式結束 *****

function SendSMS($phone,$msg){
	
	        $_url = "http://124.9.1.101/SMSService/SMSSend.aspx?PhoneNo=".$phone."&Cont=".urlencode($msg);
			//$ch = curl_init();
		  	//curl_setopt($ch, CURLOPT_URL, $_url);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, FormValueEncode($f)); 
			//$Result = curl_exec($ch);
			//curl_close($ch);
			fopen($_url,'r');
			//return $Result;
			
}

function get_facebook_likes($url){
$base_url = "http://api.facebook.com/restserver.php?method=links.getStats&urls=";
$obj = simplexml_load_string(file_get_contents($base_url.$url));
return isset($obj->link_stat->total_count) ? $obj->link_stat->total_count : 0;
}

function puretext_add_htmllinktag($text){

        $text = html_entity_decode($text);
        $text = " ".$text;
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target=_blank>\\1</a>', $text);
        $text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target=_blank>\\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '\\1<a href="http://\\2" target=_blank>\\2</a>', $text);
        $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
        '<a href="mailto:\\1" target=_blank>\\1</a>', $text);
        return $text;
}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>