<?
function excel_embed($long_array, $bold, $bufd = false) {
	$buf = "";
	$buf .= "<tr>";
	foreach ($long_array as $e)	{
		$buf .= "<td>";
		if ($bold)
			$buf .= "<b>";

		$buf .= $e;

		if ($bold)
			$buf .= "</b>";
		$buf .= "</td>";
	}
	$buf .= "</tr>\n";
	if ($bufd)
		return $buf;
	else
		print $buf;
}

function excel_header($h, $bufd = false) {
	if ($bufd)
		return excel_embed($h, true, $bufd);
	else
		excel_embed($h, true, $bufd);
}

function excel_row($h, $bufd = false) {
	if ($bufd)
		return excel_embed($h, false, $bufd);
	else
		excel_embed($h, false, $bufd);
}

function excel_start($bufd = false) {
$buf = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style id="Classeur1_16681_Styles">
</style>

</head>
<body>

<div id="Classeur1_16681" align=center x:publishsource="Excel">

<table x:str border=0 cellpadding=0 cellspacing=0 width=100% style=\'border-collapse: collapse\'>
';
if ($bufd)
	return $buf;
else
	print $buf;
}

function excel_end($bufd = false) {
	$buf = '</table></div>
	</body>
	</html>';
	if ($bufd)
		return $buf;
	else
		print $buf;

}
?>