<?php 
include('../func/func.php');
$cur_url = curPageURL();
require_once('../Connections/iwine.php');
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
    if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
    switch ($theType) {
        case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
        case "long":
        case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
        case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
        case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
        case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
    }
    return $theValue;
    }
}

$iwine_url = "http://www.iwine.com.tw/";
$article_url = "http://www.iwine.com.tw/article_class.php?pc_id=5";
$web_description = "跟著iWine我們一起去旅行！一起 體驗美酒 美食美女 美景 的生活吧！iwine提供葡萄酒、藝術、古典樂、Jazz與品酒會、品酒達人情報，不論紅酒、白酒、香檳、粉紅酒、氣泡酒、白蘭地、波特酒、冰酒、甜酒、貴腐酒、跟著iwine我們出發吧！";

mysql_select_db($database_iwine, $iwine);
$query_article = "SELECT * FROM article WHERE n_status = 'Y' ORDER BY n_id DESC";
$articles = mysql_query($query_article, $iwine) or die(mysql_error());
// $row_articles = mysql_fetch_assoc($articles);
$totalRows_articles = mysql_num_rows($articles);
?>
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:content="<?php echo $iwine_url; ?>">
  <channel>
    <title>iWine 文章總匯</title>
    <link><?php echo $iwine_url; ?></link>
    <description>
      <?php echo $iwine_description; ?>
    </description>
    <language>zh-TW</language>
    <itemcounter><?php echo $totalRows_articles; ?></itemcounter>
    <?php 
        while($row_article = mysql_fetch_assoc($articles)){
            echo "<item>\n";
                echo "<title>".$row_article['n_title']."</title>\n";
                echo "<link>http://www.iwine.com.tw/article.php?n_id=".$row_article['n_id']."</link>\n";
                echo "<pubDate>".$row_article['n_date']."</pubDate>\n";
                if($row_article['n_description']) echo "<description><![CDATA[\n".$row_article['n_description']."\n]]></description>\n";
                if($row_article['n_cont']) echo "<content:encoded><![CDATA[\n".$row_article['n_cont']."\n]]></content:encoded>\n";
            echo "</item>\n";
        }
    ?>
  </channel>
</rss>

<?php
mysql_free_result($article);
?>