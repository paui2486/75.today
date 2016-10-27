<?php include('session_check.php'); ?>
<?php
include_once 'securimage/securimage.php';
$securimage = new Securimage();
?>
<?php require_once('Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
  if ($securimage->check($_POST['capacha_code']) == false) {
  msg_box('驗證碼錯誤,請重新輸入!');
  $_err_url = "modify.php";
  go_to($_err_url);
  exit;
}		
  $_today = date('Y-m-d H:i:s');
  $updateSQL = sprintf("UPDATE member SET m_passwd_md5='%s', m_name='%s', m_year='%s', m_month='%s', m_day='%s', m_mobile='%s', m_county='%s', m_city='%s', m_address='%s', m_zip='%s', last_modify='%s' WHERE m_id='%s'",
                       htmlspecialchars(GetSQLValueString(md5($_POST['m_passwd']), "text")),
                       htmlspecialchars(GetSQLValueString($_POST['m_name'], "text")),
					   GetSQLValueString($_POST['m_year'], "int"),
					   GetSQLValueString($_POST['m_month'], "int"),
					   GetSQLValueString($_POST['m_day'], "int"),
                       htmlspecialchars(GetSQLValueString($_POST['m_mobile'], "text")),				   
					   htmlspecialchars(GetSQLValueString($_POST['county'], "text")),
					   htmlspecialchars(GetSQLValueString($_POST['district'], "text")),
					   htmlspecialchars(GetSQLValueString($_POST['m_address'], "text")),
					   htmlspecialchars(GetSQLValueString($_POST['zipcode'], "text")),
					   htmlspecialchars(GetSQLValueString($_today, "date")),
                       htmlspecialchars(GetSQLValueString($_POST['m_id'], "int")));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('資料修改成功！請重新登入～謝謝！');
  go_to('logout2.php');
}

$colname_member = "-1";
if (isset($_SESSION['MEM_ID'])) {
  $colname_member = $_SESSION['MEM_ID'];
}
mysql_select_db($database_iwine, $iwine);
$query_member = sprintf("SELECT * FROM member WHERE m_id = '%s'", GetSQLValueString($colname_member, "int"));
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);
 session_start(); ?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title> iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
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
    <style>
    </style>
  </head>
  <body>
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=540353706035158";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php include('mainmenu_20140903.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
        <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
            
              <div>
              <h3><img src="images/wine_icon1.png" width="49" height="49"> <span class="title">修改會員資料</span></h3><hr>
                <form name="form1" action="<?php echo $editFormAction; ?>" method="POST" class="form-horizontal" id="form1" >
                	
  					<div class="control-group">
    					<label class="control-label" for="m_account">帳 號</label>
    					<div class="controls"><?php echo $row_member['m_account']; ?>
                          <input name="m_id" type="hidden" id="m_id" value="<?php echo $row_member['m_id']; ?>">
                          <span class="help-stock"><div id="account_check" style="color:#F00"></div></span>
   					  </div>
  					</div>
  					<div class="control-group">
    					<label class="control-label" for="m_passwd">密 碼</label>
    					<div class="controls">
      					<input name="m_passwd" type="password" id="m_passwd" placeholder="請輸入密碼">
                        <span class="help-inline">*請輸入8碼以上的英文或數字(大小寫視為不同)</span>
    					</div>
  					</div>
                    <div class="control-group">
    					<label class="control-label" for="m_passwd_confirm">確認密碼</label>
    					<div class="controls">
      					<input name="m_passwd_confirm" type="password" id="m_passwd_confirm" placeholder="請再次輸入密碼">
                        <span class="help-inline">*請再次輸入您的密碼</span>
    					</div>
  					</div>
                    <div class="control-group">
						<label class="control-label" for="m_name">姓 名</label>
						<div class="controls">
						<input name="m_name" type="text" id="m_name" placeholder="請輸入姓名" value="<?php echo $row_member['m_name']; ?>">
                        <span class="help-inline">*請輸入您的中文或英文姓名</span>
						</div>
                    </div>
                    <div class="control-group">
						<label class="control-label" for="m_year">生 日</label>
					  <div class="controls">
						<select name="m_year" class="input-small">
						  <option>1900</option>
                        <?php 
						$a18_year = date('Y')-18;
						for($i=1901;$i<= $a18_year ;$i++){ 
						?>
                        <option <?php if($i == $row_member['m_year']){ ?>selected="selected"<?php } ?>><?php echo $i ; ?></option>
                        <?php } ?>
						</select>年<select name="m_month" class="input-mini">
						  <option value="1" <?php if (!(strcmp(1, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>1</option>
						  <option value="2" <?php if (!(strcmp(2, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>2</option>
						  <option value="3" <?php if (!(strcmp(3, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>3</option>
						  <option value="4" <?php if (!(strcmp(4, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>4</option>
						  <option value="5" <?php if (!(strcmp(5, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>5</option>
						  <option value="6" <?php if (!(strcmp(6, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>6</option>
						  <option value="7" <?php if (!(strcmp(7, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>7</option>
						  <option value="8" <?php if (!(strcmp(8, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>8</option>
						  <option value="9" <?php if (!(strcmp(9, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>9</option>
						  <option value="10" <?php if (!(strcmp(10, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>10</option>
						  <option value="11" <?php if (!(strcmp(11, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>11</option>
						  <option value="12" <?php if (!(strcmp(12, $row_member['m_month']))) {echo "selected=\"selected\"";} ?>>12</option>
						</select>
						月<select name="m_day" class="input-mini">
						  <option value="1" <?php if (!(strcmp(1, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>1</option>
						  <option value="2" <?php if (!(strcmp(2, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>2</option>
						  <option value="3" <?php if (!(strcmp(3, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>3</option>
						  <option value="4" <?php if (!(strcmp(4, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>4</option>
						  <option value="5" <?php if (!(strcmp(5, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>5</option>
						  <option value="6" <?php if (!(strcmp(6, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>6</option>
						  <option value="7" <?php if (!(strcmp(7, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>7</option>
						  <option value="8" <?php if (!(strcmp(8, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>8</option>
						  <option value="9" <?php if (!(strcmp(9, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>9</option>
						  <option value="10" <?php if (!(strcmp(10, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>10</option>
						  <option value="11" <?php if (!(strcmp(11, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>11</option>
						  <option value="12" <?php if (!(strcmp(12, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>12</option>
						  <option value="13" <?php if (!(strcmp(13, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>13</option>
						  <option value="14" <?php if (!(strcmp(14, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>14</option>
						  <option value="15" <?php if (!(strcmp(15, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>15</option>
						  <option value="16" <?php if (!(strcmp(16, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>16</option>
						  <option value="17" <?php if (!(strcmp(17, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>17</option>
						  <option value="18" <?php if (!(strcmp(18, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>18</option>
						  <option value="19" <?php if (!(strcmp(19, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>19</option>
						  <option value="20" <?php if (!(strcmp(20, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>20</option>
						  <option value="21" <?php if (!(strcmp(21, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>21</option>
<option value="22" <?php if (!(strcmp(22, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>22</option>
						  <option value="23" <?php if (!(strcmp(23, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>23</option>
						  <option value="24" <?php if (!(strcmp(24, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>24</option>
						  <option value="25" <?php if (!(strcmp(25, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>25</option>
						  <option value="26" <?php if (!(strcmp(26, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>26</option>
						  <option value="27" <?php if (!(strcmp(27, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>27</option>
						  <option value="28" <?php if (!(strcmp(28, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>28</option>
						  <option value="29" <?php if (!(strcmp(29, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>29</option>
						  <option value="30" <?php if (!(strcmp(30, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>30</option>
<option value="31" <?php if (!(strcmp(31, $row_member['m_day']))) {echo "selected=\"selected\"";} ?>>31</option>
						</select>日
                        <span class="help-inline">*請輸入您的生日</span>
						</div>   
					</div>
                    <div class="control-group">
						<label class="control-label" for="m_mobile">手 機</label>
						<div class="controls">
						<input name="m_mobile" type="text" id="m_mobile" placeholder="請輸入手機號碼" value="<?php echo $row_member['m_mobile']; ?>">
                        <span class="help-inline">*輸入格式如：0988123789</span>
						</div>   
					</div>
                    <div class="control-group">
    					<label class="control-label" for="capacha_code">地址</label>
   					  <div class="controls">
   					    <div id="twzip"></div>
                                <input class="input-xlarge focused" id="m_address" name="m_address" type="text" value="<?php echo $row_member['m_address']; ?>">
				    </div>
                  </div>
                    <div class="control-group">
    					<label class="control-label" for="capacha_code">驗證碼</label>
   					  <div class="controls">
      					<input name="capacha_code" type="text" id="capacha_code" />
                        <span class="help-inline"><img src="securimage/securimage_show.php" alt="CAPTCHA Image" align="absmiddle" id="captcha" /><a href="#" onClick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false" class="btn-small btn-info">更換</a></span>
    					</div>
  					</div>
  					
                    <div class="control-group">
    					<div class="controls">
      					<button type="button" class="btn btn-danger" onClick="chkform();">確定修改</button>
                        <button type="reset" class="btn btn-success">重設</button>
    					</div>
  						</div>
                    <input type="hidden" name="MM_update" value="form1">
				</form>
                
              </div>
            </div>
            
          </div>
          
        </div>
        
        <div class="row">
        <div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> iWine 排行榜 </h4>
            <?php include('ad_1.php'); ?>
        </div>
        <?php
        mysql_select_db($database_iwine, $iwine);
        $query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 10";
        $hot = mysql_query($query_hot, $iwine) or die(mysql_error());
        $row_hot = mysql_fetch_assoc($hot);
        $totalRows_hot = mysql_num_rows($hot);
        ?>
        <div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門文章 </h4>
           <div class="span3 hot_article" id="hot_article">
           <?php do{ ?>
            <div class="span3 each_hot_article" >
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>">
                <img src="http://admin.iwine.com.tw/webimages/article/<?php echo $row_hot['n_fig1']; ?>" class="span1" style="margin: 0 10px 0 10px;">
                </a>
                <a href="/article.php?n_id=<?php echo $row_hot['n_id']; ?>" style="margin-top:10px;">
                <?php echo $row_hot['n_title']; ?>
                </a>
            </div>
           <?php } while ($row_hot = mysql_fetch_assoc($hot));?>
            </div>
        </div>
        
     </div>
      </div>
      
    </div>
    <?php include('footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="assets/js/bootstrap.js">
    </script>
    <script src="js/twzipcode-1.4.1.js"></script>
    <script language="javascript">
	//twzip
	$('#twzip').twzipcode({
		css: ['addr-county', 'addr-area', 'addr-zip'],
		zipcodeSel: '<?php echo $row_member['m_zip']; ?>',
		countySel: '<?php echo $row_member['m_county']; ?>', //縣市預設值
        districtSel: '<?php echo $row_member['m_city']; ?>' //鄉鎮市區預設值	
	});
	</script>
    <script language="javascript">
	function chkmail(){
	
	myReg = /^.+@.+\..{2,3}$/
	if( $("#mail_list").val() =="" || !$("#mail_list").val().match(myReg)){alert('請輸入正確格式之E-mail!'); return; }
	form0.submit();	
		
	}
    </script>
    <script src="js/chkform2.js"></script>
  </body>
</html>
<?php
mysql_free_result($member);
?>
<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#slideshow').cycle({
		autostop:			false,     // true to end slideshow after X transitions (where X == slide count) 
		fx:				'fade,',// name of transition effect 
		pause:			false,     // true to enable pause on hover 
		randomizeEffects:	true,  // valid when multiple effects are used; true to make the effect sequence random 
		speed:			1000,  // speed of the transition (any valid fx speed value) 
		sync:			true,     // true if in/out transitions should occur simultaneously 
		timeout:		5000,  // milliseconds between slide transitions (0 to disable auto advance) 
		fit:			true,
		width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
	});
}); 
</script>
