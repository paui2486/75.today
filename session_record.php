<?php 
session_set_cookie_params(86400);
session_start();

if(isset($_GET['am_code']) && $_GET['am_code'] <>""){
$_SESSION['am_code'] = $_GET['am_code'];
}
?>