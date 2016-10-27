<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_iwine = "localhost";
$database_iwine = "iwine";
$username_iwine = "root";
$password_iwine = "mysql2013";
$iwine = mysql_pconnect($hostname_iwine, $username_iwine, $password_iwine) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'UTF8'",$iwine);
date_default_timezone_set("Asia/Taipei");
?>
