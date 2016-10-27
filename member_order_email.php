<?php 
require_once('Connections/iwine.php');
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
        if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;    
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

$_today = date('Y-m-d H:i:s'); 
if (isset($_GET['email'])) {
  $email = trim($_GET['email']);
}
mysql_select_db($database_iwine, $iwine);

$query_check = sprintf("SELECT * FROM email_list WHERE e_email = %s", GetSQLValueString($email, "text"));
$check = mysql_query($query_check, $iwine) or die(mysql_error());
$row_check = mysql_fetch_assoc($check);
$totalRows_check = mysql_num_rows($check);

if ($totalRows_check==0){
    $query_insert = sprintf("INSERT INTO email_list (e_email, update_time) VALUES (%s, %s)" , GetSQLValueString($email, "text"),GetSQLValueString($_today, "text"));
    $Result1 = mysql_query($query_insert, $iwine) or die(mysql_error());

    $_new_m_id = mysql_insert_id();
    if($Result1==1){
         echo "感謝您的訂閱，iWine好康送到家！";
    }else{
        echo "訂閱失敗";
    }
}else{
    echo $email."已經訂閱過iWine 好康電子報了！";
}
    
      
    
  
  
?>