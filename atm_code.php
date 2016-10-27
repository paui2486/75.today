<?php 
//ATM付款

$d = strtotime('+3 days');
$_atm00 = date('md',$d);	
$_atm01 = "6106".$_atm00."00020"; //$code2x;	
$money = 100 ;//$_POST['ord_total_price'];
$money_lenth = strlen($money);

$sum_account = substr(substr($_atm01,-1,1)*7,-1,1) + substr(substr($_atm01,-2,1)*6,-1,1) + substr(substr($_atm01,-3,1)*5,-1,1) + substr(substr($_atm01,-4,1)*4,-1,1) + substr(substr($_atm01,-5,1)*3,-1,1) + substr(substr($_atm01,-6,1)*2,-1,1) + substr(substr($_atm01,-7,1)*1,-1,1) + substr(substr($_atm01,-8,1)*9,-1,1) + substr(substr($_atm01,-9,1)*8,-1,1) + substr(substr($_atm01,-10,1)*7,-1,1) + substr(substr($_atm01,-11,1)*6,-1,1) + substr(substr($_atm01,-12,1)*5,-1,1) + substr(substr($_atm01,-13,1)*4,-1,1) ;

$sum1 = substr($sum_account,-1,1);

$sum_money = 0;

for($i=1;$i<=$money_lenth;$i++){
	$sum_money = $sum_money + substr($money, -$i, 1)*$i;
}

$sum2 = substr($sum_money,-1,1);

echo $sum0 = $sum1 + $sum2; echo "<br>";
$sum00 = substr(10 - substr($sum0,-1,1),-1,1);
echo $atm_code = $_atm01.$sum00;

?>