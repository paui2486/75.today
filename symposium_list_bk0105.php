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
    $append_query = sprintf("AND area = '%s'", GetSQLValueString($_POST['area'], "text"));
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





    
<!--日曆顯示-->

<!--    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#datepicker01" ).datepicker();
  });
  </script>
  
<!--日曆顯示結束-->
    

    <script type='text/javascript'>
    $(document).ready(function(){
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
      <?php include('header.php'); ?>
      <ul class="nav nav-pills">
        <div id="nav_menu" class="navbar">
        
          <div class="navbar-inner">
            <div class="container-fluid">
              <?php include('mainmenu.php'); ?>
            </div>
          </div>
        </div>
      </ul>
      
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
    <div id="winetast_row">‧依時間搜尋：  
       <input name="start_date" type="text" id="start_date" placeholder="選擇開始時間" value="<?php echo $_POST['start_date']; ?>">至
       <input name="end_date" type="text" id="end_date" placeholder="選擇結束時間" value="<?php echo $_POST['end_date']; ?>">
       <input type="image" id="search1" src="images/icon_search.png" alt="Submit Form"  width="40" height="13" border="0"/>
    </div>
</form>
    
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
    <p>&nbsp;</p>
    
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="searchform2">
<input type="hidden" name="act" value="searchform2">
    <div id="winetast_row">
      ‧依區域搜尋：
        <select name="area" id="area" >
              <option value="">請選擇</option>
              <option value="北">1. 北區</option>
              <option value="中">2. 中區</option>
              <option value="南">3. 南區</option>
              <option value="東">4. 東區</option>
        </select>
        <input type="image" id="search2" src="images/icon_search.png" alt="Submit Form"  width="40" height="13" border="0"/>
    </div>
</form>
</div>

<!--search區塊結束-->


<!--日期區塊-->
<div class="right">
‧請選擇日期: 

  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="7" align="center" class="title">2014年1月</td>
      </tr>
    <tr class="txt">
      <td>日</td>
      <td>一</td>
      <td>二</td>
      <td>三</td>
      <td>四</td>
      <td>五</td>
      <td>六</td>
    </tr>
    <tr class="date02">
      <td></td>
      <td></td>
      <td></td>
      <td>1</td>
      <td>2</td>
      <td>3</td>
      <td>4</td>
    </tr>
    <tr class="date">
      <td>5</td>
      <td>6</td>
      <td>7</td>
      <td>8</td>
      <td>9</td>
      <td>10</td>
      <td>11</td>
    </tr>
    <tr class="date">
      <td>12</td>
      <td>13</td>
      <td>14</td>
      <td>15</td>
      <td>16</td>
      <td>17</td>
      <td>18</td>
    </tr>
    <tr class="date">
      <td>19</td>
      <td>20</td>
      <td>21</td>
      <td>22</td>
      <td>23</td>
      <td>24</td>
      <td>25</td>
    </tr>
     <tr class="date">
      <td>26</td>
      <td>27</td>
      <td>28</td>
      <td>29</td>
      <td>30</td>
      <td>31</td>
      <td></td>
    </tr>
  </table>
  
<!--日期區塊結束-->


  <!--search區塊結束-->

<img src="images/line03.png" width="1200"></div>
</div>
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
 
<table width="100%" height="200" border="0">
           <tr>
             <td width="356" background="images/bg2.png">活動主題 </td>
             <td width="144" background="images/bg2.png">日期</td>
             <td width="173" background="images/bg2.png">地點</td>
             <td width="79" background="images/bg2.png"> 費用</td>
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
   <p>&nbsp;</p>
               
      

</div>


  
  <?php if($totalPages_symposium > 0){ ?>
                <div class="pagination pagination-centered">
                    <ul>
                        <li><a href="<?php printf("%s?pageNum_symposium=%d%s", $currentPage, max(0, $pageNum_symposium - 1), $queryString_article); ?>">上一頁</a></li>
                        <?php  $tp = $totalPages_symposium+1;for($i=1;$i<=$tp;$i++){ ?>
                        <li <?php if($i == $pageNum_symposium + 1 ){ echo "class=\"active\""; } ?>><a href="<?php printf("%s?pageNum_symposium=%d%s", $currentPage, max(0, $i - 1), $queryString_article); ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <li><a href="<?php printf("%s?pageNum_symposium=%d%s", $currentPage, min($totalPages_symposium, $pageNum_symposium + 1), $queryString_article); ?>">下一頁</a></li>
                    </ul>
                </div>
                <?php } ?>
                
                <div class="row">
                   <div class="span9" align="center">
                   <?php include('ad_content_bottom.php'); ?>
                   </div>
                </div>
            </div>
            </div>          
          </div>
          
          
        
        <div class="row">
        <div class="span3" align="center">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 熱門排行</h4>
            <?php include('ad_1.php'); ?>
        </div>
        <div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div>
        
        <?php include('ad_content_right.php'); ?>
        
     </div>
        
        
     </div>
     
     
      
      
      <div class="row">
      <?php include('footer.php'); ?>
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
