<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine -- 禁止酒駕．未滿18歲禁止飲酒</title>
<style>
body {
    font: normal normal 12px 'Meiryo', 'メイリオ', 'Hiragino Kaku Gothic Pro', 'ヒラギノ角ゴ Pro W3', 'ＭＳ Ｐゴシック', 'ＭＳ ゴシック', Osaka, Osaka-等幅, '微軟正黑體', sans-serif ,Georgia, Utopia, 'Palatino Linotype', Palatino, serif;
    color: #999;
    font-size: 12px;
}
.mail_text, .mail_text p{
    max-width: 600px;
}
.content{
    margin: 5px;
    padding: 5px;
    max-width: 400px;
    color: #ff3366;
}
</style>
</head>

<body>
<div class="mail_text">
<p>Hi iWine 管理員:</p>
<p><?php echo $_POST['c_datetime']; ?> 收到來自 <?php echo $_POST['c_name']; ?> 的客服訊息</p>
<p>詳細資料如下，請至<a href="http://admin.iwine.com.tw/qpzm105/contact_s.php?c_id=<?php echo $last_id; ?>">iWine 客服後台處理</a>，謝謝！</p>
姓名：<span class="content"><?php echo $_POST['c_name']; ?>AAA</span><br>
電話：<span class="content"><?php echo $_POST['c_tel']; ?>BBB</span><br>
email：<span class="content"><?php echo $_POST['c_email']; ?>CCC</span><br>
主題：<span class="content"><?php echo $_POST['c_class']; ?>DDD</span><br>
內容：<span class="content">adfafasfafasfsfdsdfsdfdsfdsdfsd<?php echo $_POST['c_cont']; ?></span></p>
<p>此為系統通知，請勿直接回覆。</p>
</div>
</body>
</html>
