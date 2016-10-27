<?php 
session_start(); 
include('func/func.php');
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
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_symposium = 12;
$pageNum_symposium = 0;
if (isset($_GET['pageNum_symposium'])) {
  $pageNum_symposium = $_GET['pageNum_symposium'];
}
$startRow_symposium = $pageNum_symposium * $maxRows_symposium;

mysql_select_db($database_iwine, $iwine);
if($_POST['act']=='searchform1'){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $append_query = sprintf("AND start_date >= '%s' AND start_date <= '%s'",
                       GetSQLValueString($start_date, "date"),
                       GetSQLValueString($end_date, "date"));
    
}else if($_POST['act']=='searchform2'){
    $append_query = sprintf("AND area = '%s'", GetSQLValueString($_POST['county'], "text"));
}else{
    $append_query = '';
}
$query_symposium = sprintf("SELECT * FROM symposium WHERE active= 1 %s ORDER BY start_date DESC", $append_query);
 
$query_limit_symposium = sprintf("%s LIMIT %d, %d", $query_symposium, $startRow_symposium, $maxRows_symposium);

// echo "query_limit_symposium = <font color=red>".$query_limit_symposium."</font><br>";
$symposium_query = mysql_query($query_limit_symposium, $iwine) or die(mysql_error());
$symposium = mysql_fetch_assoc($symposium_query);
$result_total = mysql_num_rows($symposium_query);

if (isset($_GET['totalRows_symposium'])) {
  $totalRows_symposium = $_GET['totalRows_symposium'];
} else {
  $all_symposium = mysql_query($query_symposium);
  $totalRows_symposium = mysql_num_rows($all_symposium);
}
$totalPages_symposium = ceil($totalRows_symposium/$maxRows_symposium)-1;

$queryString_symposium = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_symposium") == false && 
        stristr($param, "totalRows_symposium") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_symposium = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_symposium = sprintf("&totalRows_symposium=%d%s", $totalRows_symposium, $queryString_symposium);


?>
<!DOCTYPE html>
<html lang="zh_tw">
  
  <head>
    <meta charset="utf-8">
    <title>品酒會活動 - iWine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="品酒會活動 - iWine">
    <meta property="og:site_name" content="iWine">
    <meta property="og:image" content="images/logo.jpg">
    <meta property="og:type" content="website">
    <meta property="fb:admins" content="1685560618"/>
    <meta property="fb:app_id" content="540353706035158">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">    
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
    
    
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
      </script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link href='js/datetimepick/lib/jquery-ui-timepicker-addon.css' rel='stylesheet'>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-timepicker-addon.js'></script>
    <script type='text/javascript' src='js/datetimepick/lib/jquery-ui-sliderAccess.js'></script>
    <script type='text/javascript' src='js/datetimepick/jquery-ui-timepicker-zh-TW.js'></script>
    <script src="js/twzipcode-1.4.1.js"></script>
    <script type='text/javascript'>
    $(document).ready(function(){
        //$("select[name='district']").hide();
        //$("input[name='zipcode']").hide();
        $("#search1").click(function(){
            if($("#start_date").val()=="" || $("#end_date").val()==""){
                alert("請輸入查詢起訖時間~");
                return false;
            }else($("#start_date").val() > $("#end_date").val()){
                alert("開始時間大於結束時間，請重新選擇。");
                return false;
            }
        });
        $("#search2").click(function(){
            if($("#area").find(":selected").val()==""){
                alert("請輸入查詢區域~");
                return false;
            }
        });
     });
    </script>
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
    <div class="container">
      <div class="row">
    <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
              <div>
                <ul class="breadcrumb">
                    <li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li class="active">品酒會活動</li>
                </ul>
                <div class="row">
                    <div class="span9">
                      <h3><img src="images/wine_icon1.png" width="50" height="50">品酒會活動</h3>
  <img src="images/line03.png" width="1200">



                     
  <script language="JavaScript">
        //$(document).ready(function(){
          var myDate = new Date();
          var displayDate = myDate.getFullYear()+'-'+(myDate.getMonth()+1) + '-01 00:00:00';
          var opt1={dateFormat: 'yy-mm-dd',
                    showSecond: false,
                    timeFormat: 'HH:mm:ss',
                    addSliderAccess:true,
                    sliderAccessArgs:{touchonly:false},
                    showButtonPanel: true,
                    defaultValue: displayDate
                    };
            $('#start_date').datetimepicker(opt1);
            $('#end_date').datetimepicker(opt1);
        //});
                      </script>
 
 




<!--search區塊-->

<div class="winetast_search">
                      
<div class="left">     

                 <form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="searchform1">
                        <input type="hidden" name="act" value="searchform1">
  ‧依時間搜尋：
                          <input name="start_date" type="text" id="start_date" placeholder="選擇開始時間" value="<?php echo $_POST['start_date']; ?>">
                          至
                          <input name="end_date" type="text" id="end_date" placeholder="選擇結束時間" value="<?php echo $_POST['end_date']; ?>">
                          <input type="image" id="search1" src="images/icon_search.png" alt="Submit Form"  width="40" height="13" border="0"/>


<p>  
  
‧依區域搜尋： <span id="twzip"></span>
                            <script language="javascript">
    //twzip
    $('#twzip').twzipcode({
        css: ['addr-county', ]  
    });
    $("select[name='district']").hide();
        $("input[name='zipcode']").hide();
                            </script>
                            <input type="image" id="search2" src="images/icon_search.png" alt="Submit Form"  width="40" height="13" border="0"/>
                
</form>
</div>

<div class="right">
‧請選擇日期: 
   <div id="datepicker">
   </div>
</div>

</div>


<!--search區塊結束-->


<p><img src="images/line03.png" width="1200"></p>


      
<!--品酒會廣告區塊-->
                      
<div class="ad_list">


<div class="number">
  
  <div class="pic"><img src="images/pic04.png" width="250" height="193">   </div>

 <div class="title">
  WSD台北葡萄酒生活節－花現綠生活
  </div>
  </div>


<div class="number">
  
  <div class="pic"><img src="images/pic04.png" width="250" height="193"></div>

 <div class="title">
  WSD台北葡萄酒生活節－花現綠生活
  </div>
  </div>



<div class="number">
  
  <div class="pic"><img src="images/pic04.png" width="250" height="193"></div>

 <div class="title">
  WSD台北葡萄酒生活節－花現綠生活
  </div>
  </div>


</div>

       
<!--品酒會廣告區塊結束-->         
          
          
          
<!--品酒會列表-->         
         
<div class="each_list">
 
<table width="100%" height="180" border="0">
           <tr>
             <td width="363" background="images/bg2.png">活動 </td>
             <td width="118" background="images/bg2.png">日期</td>
             <td width="176" background="images/bg2.png">地點</td>
             <td width="95" background="images/bg2.png"> 費用</td>
           </tr>
           <tr>
             <td>WSD台北葡萄酒生活節－花現綠生活節－花現綠生活</td>
             <td>12/28 (六)</td>
             <td>台北市花博爭豔館</td>
             <td>450</td>
           </tr>
           <tr>
             <td>WSD台北葡萄酒生活節－花現綠生活</td>
             <td>12/28 (六)</td>
             <td>台北市花博爭豔館</td>
             <td>450</td>
           </tr>
           <tr>
             <td>WSD台北葡萄酒生活節－花現綠生活現綠生活現綠生活</td>
             <td>12/28 (六)</td>
             <td>台北市花博爭豔館</td>
             <td>450</td>
           </tr>
           <tr>
             <td>WSD台北葡萄酒生活節－花現綠生活</td>
             <td>12/28 (六)</td>
             <td>台北市花博爭豔館</td>
             <td>450</td>
           </tr>
           <tr>
             <td>WSD台北葡萄酒生活節－花現綠生活</td>
             <td>12/28 (六)</td>
             <td>台北市花博爭豔館</td>
             <td>450</td>
           </tr>
         </table>
         
         </div>
         
         
              
<!---品酒會列表結束-->         
                    

        </div>
           </div>
 </div>
</div>
        </div>
        </div>
      </div>
    </div>
        
 
     
     
      
      

    
    <script src="assets/js/bootstrap.js">
    </script>
  </body>
</html>
<?php
mysql_free_result($article);

mysql_free_result($article_Class);
?>
<?php include('ga.php'); ?>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#slideshow').cycle({
        autostop:           false,     // true to end slideshow after X transitions (where X == slide count) 
        fx:             'fade,',// name of transition effect 
        pause:          false,     // true to enable pause on hover 
        randomizeEffects:   true,  // valid when multiple effects are used; true to make the effect sequence random 
        speed:          1000,  // speed of the transition (any valid fx speed value) 
        sync:           true,     // true if in/out transitions should occur simultaneously 
        timeout:        5000,  // milliseconds between slide transitions (0 to disable auto advance) 
        fit:            true,
        width:         '250px'   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
    });
}); 
</script>
