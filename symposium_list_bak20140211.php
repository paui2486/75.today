<?php 
session_start(); 
include('func/func.php');
require_once('Connections/iwine.php'); 

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

$_today = date('Y-m-d H:i:s'); 
$maxRows_symposium = 30;
$pageNum_symposium = 0;

if (isset($_GET['pageNum_symposium'])) {
  $pageNum_symposium = $_GET['pageNum_symposium'];
}
$startRow_symposium = $pageNum_symposium * $maxRows_symposium;

mysql_select_db($database_iwine, $iwine);
//搜尋區域選單
$query_area = "SELECT area FROM (SELECT area FROM symposium WHERE active = 1 ORDER BY id DESC) AS temp GROUP BY area";
$area_querySet = mysql_query($query_area, $iwine) or die(mysql_error());
$area_total = mysql_num_rows($area_querySet);

//判斷搜尋條件,組合條件
if($_POST['act']=='searchform1'){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $append_query = sprintf("AND start_date >= '%s' AND start_date <= '%s'",
                       GetSQLValueString($start_date, "date"),
                       GetSQLValueString($end_date, "date"));
    $page_type = 'search';
}else if($_POST['act']=='searchform2'){
    $append_query = sprintf("AND area = '%s'", GetSQLValueString($_POST['area'], "text"));
    $page_type = 'search';
}else{
    $append_query = '';
    $page_type = 'default';
}

$query_symposium = sprintf("SELECT * FROM symposium WHERE active = 1 %s ORDER BY start_date DESC", $append_query);
if($page_type == 'default'){
    $query_limit_symposium = sprintf("%s LIMIT %d, %d", $query_symposium, $startRow_symposium, $maxRows_symposium);
}else{
    $query_limit_symposium = $query_symposium;
}

$symposium_query = mysql_query($query_limit_symposium, $iwine) or die(mysql_error());
$total_symposium = mysql_num_rows($symposium_query);
//品酒會廣告三則
$query_hotSymposium = "SELECT * FROM symposium WHERE active = 1 AND ishot = 1 ORDER BY RAND() LIMIT 3";
$hotSymposium_query = mysql_query($query_hotSymposium, $iwine) or die(mysql_error());

$total_hotSymposium = mysql_num_rows($hotSymposium_query);
if($page_type == 'default'){
    if (isset($_GET['totalRows_symposium'])) {
      $totalRows_symposium = $_GET['totalRows_symposium'];
    } else {
      $all_symposium = mysql_query($query_symposium);
      $totalRows_symposium = mysql_num_rows($all_symposium);
    }
    $totalPages_symposium = ceil($totalRows_symposium/$maxRows_symposium)-1;
}


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

mysql_select_db($database_iwine, $iwine);
$query_hot = "SELECT * FROM article WHERE n_hot = 'Y' AND n_status= 'Y' AND n_title <> '' ORDER BY RAND() LIMIT 7";
$hot = mysql_query($query_hot, $iwine) or die(mysql_error());
$row_hot = mysql_fetch_assoc($hot);
$totalRows_hot = mysql_num_rows($hot);

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
    <?php include('mainmenu_20140903.php'); ?>
          
    <div class="container">
	<?php include('header_20140903.php'); ?>
      <div class="row container-area">
        <div id="MainContent" class="span9">
          <div class="row">
            <div class="span9">
              <div>
                <ul class="breadcrumb">
                    <li><a href="index.php">首頁</a> <span class="divider">/</span></li>
                    <li class="active">品酒會情報</li>
                </ul>
                <div class="row">
                    <div class="span9" style="display:inline;">
                     <div>
      <div style="float:left;">
                      <h3><img src="images/wine_icon1.png" width="50" height="50">品酒會情報</h3>
      </div>
                      
                      
             <div style="float:right; right:0px; top:0px; padding-top:20px;">
                      <a href="symposium_upload_simple.php">
                      <img src="images/btn_symposium_upload.jpg" width="117" height="33">
                      </a>
            </div>
                      
                                           
                      
                      </div>
              
  <img src="images/line03.png" width="1200">




<!--search區塊-->

<div class="winetast_search" style="height: 60px !important;">
                      
<div class="left">     

 <!--form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="searchform1">
 <input type="hidden" name="act" value="searchform1">
    <!--div id="winetast_row">‧依時間搜尋：  
       <input name="start_date" type="text" id="start_date" placeholder="選擇開始時間" value="<?php if($_POST['start_date']!=""){ echo $_POST['start_date']; }else{ echo $_today;} ?>">至
       <input name="end_date" type="text" id="end_date" placeholder="選擇結束時間" value="<?php echo $_POST['end_date']; ?>">
       <input type="image" id="search1" src="images/icon_search.png" alt="Submit Form"  width="40" height="13" border="0"/>
    </div>
</form-->
    
    <script language="JavaScript">
          // var myDate = new Date();
          // var displayDate = myDate.getFullYear()+'-'+(myDate.getMonth()+1) + '-'+ myDate.getDate() + ' 23:59:59';
          // var opt1={dateFormat: 'yy-mm-dd',
                    // showSecond: false,
                    // timeFormat: 'HH:mm:ss',
                    // addSliderAccess:true,
                    // sliderAccessArgs:{touchonly:false},
                    // showButtonPanel: true
                    // ,defaultValue: displayDate 
                    // };
            // $('#start_date').datetimepicker(opt1);
            // $('#end_date').datetimepicker(opt1);
    </script>
    <!--p>&nbsp;</p-->
    
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="searchform2">
<input type="hidden" name="act" value="searchform2">
    <div id="winetast_row">
      ‧依區域搜尋：
      <?php if($area_total > 0) {?>
        <select name="area" id="area" >
              <option value="">請選擇</option>
              <?php 
                $i=0;
                while ($row_area = mysql_fetch_assoc($area_querySet)){
                    if($row_area['area']<>""){
                        $i++;
                        echo "<option value=\"".$row_area['area']."\">".$i.".".$row_area['area']."</option>";
                    }
                };
              ?>
        </select>
        
        <input type="image" id="search2" src="images/icon_search.png" alt="Submit Form"  width="40" height="13" border="0"/>
        <?php }else{
            echo "目前無資料";
        } ?>
    </div>
</form>
</div>

<!--search區塊結束-->


<!--日期區塊-->
<div class="right">
<!--
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
    <tr class="date">
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
  </table-->
  
<!--日期區塊結束-->


  <!--search區塊結束-->

    <img src="images/line03.png" width="1200"></div>
</div>


<div class="ad_list">
  <?php 
  if($total_hotSymposium==3){ 
    while($hotSymposium = mysql_fetch_assoc($hotSymposium_query)){ ?>
        <div class="number">
        <div class="pic">
            <a href="symposium.php?id=<?php echo $hotSymposium['id']; ?>">
            <img src="http://www.iwine.com.tw/webimages/symposium/<?php echo $hotSymposium['pic1']; ?>" width="250" height="193" border="0" title="更多品酒會情報" >
            </a>
        </div>
        <div class="title">
            <a href="symposium.php?id=<?php echo $hotSymposium['id']; ?>" title="更多品酒會情報" >
                <?php echo $hotSymposium['title']; ?>
            </a>
        </div>
    </div>

    <?php    
    };
  } ?>

</div>
       <!--div class="span8" style="height:20px;"> </div-->
<!--品酒會廣告區塊結束-->         
          
          
          
<!--品酒會列表-->         
         
<div class="each_list">
    <?php if($total_symposium > 0) {?>
        <table width="100%" height="145"  border="0" >
           <tr align="left">
             <th width="55" background="images/bg2.png">&nbsp;</th>
             <th width="232" background="images/bg2.png">活動主題 </th>
             <th width="93" background="images/bg2.png">日期</th>
             <th width="78" background="images/bg2.png">區域</th>
             <!--th width="236" background="images/bg2.png">地址</th-->
             <th width="53"  background="images/bg2.png"> 費用</th>
           </tr>
           <?php while($symposium = mysql_fetch_assoc($symposium_query)) {
                
                $week=Array("日","一","二","三","四","五","六");
                $date_time=$symposium['start_date'];
                list($date)=explode(" ", $date_time); //取出日期部份
                list($Y,$M,$D)=explode("-",$date); //分離出年月日以便製作時戳
                $display_date = $M."/".$D;
                $display_week = "(".$week[date("w", mktime(0,0,0,$M,$D,$Y))].")";
                $now = date( "Y-m-d H:i:s", mktime());
                
                if( strtotime($now) > strtotime($date_time) ){ ?>
                   <tr class="symposium_table" valign="top">
                   <td class="passed_item"><img src="images/icon_note.jpg" style="max-width:100%"></td>
                   
                     <td class="passed_item"><a href="symposium.php?id=<?php echo $symposium['id']; ?>"><?php echo $symposium['title']; ?></a></td>
                     <td class="passed_item">
                        <?php  echo $display_date." ".$display_week; ?>
                     </td>
                     <td class="passed_item"><?php echo $symposium['area']; ?></td>
                     <!--td align="left" class="passed_item"><?php //echo $symposium['address']; ?></td-->
                     <td class="passed_item"><?php echo $symposium['fee']; ?></td>
                   </tr>
               <?php }else{ ?>
                    <tr class="symposium_table"  valign="top">
      
      <td><span class="passed_item"><img src="images/icon_note.jpg" style="max-width:100%"></span></td>
                         <td><a href="symposium.php?id=<?php echo $symposium['id']; ?>"><?php echo $symposium['title']; ?></a></td>
                         <td>
                            <?php echo $display_date." ".$display_week; ?>
                         </td>
                         <td><?php echo $symposium['area']; ?></td>
                         <!--td align="left" ><?php //echo $symposium['address']; ?></td-->
                         <td ><?php echo $symposium['fee']; ?></td>
                   </tr>
               <?php }; ?>
           
           <?php }; ?>
         </table>
    <?php }else{ echo " <TABLE><TR><TD STYLE='HEIGHT:100PX;'>暫無資訊，敬請期待！ </TD></TR></TABLE>"; } ?>
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
        
        <!--div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30"> 粉絲團最新動態</h4>
           <div class="fb-like-box" data-href="http://www.facebook.com/iwine" data-width="The pixel width of the plugin" data-height="350" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
        </div-->
        <div class="span3">
           <h4 align="left"><img src="images/wine_icon1.png" width="30" height="30">熱門文章</h4>
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
mysql_free_result($area_querySet);
mysql_free_result($symposium_query);
mysql_free_result($all_symposium);
mysql_free_result($hotSymposium_query);
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
