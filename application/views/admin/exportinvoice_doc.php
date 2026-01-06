<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".$_SESSION['export_invoice_no'].".doc");
$html = '<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<head>
<style>
table {
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	font-size:10px;
}
 
.pdf_class td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
.pdf_class th {
 	border: 0.5px solid #333;
	padding:5px; 
}
 
</style>

</head>
<body>
	'.$_SESSION['export_content'].' 
		</body>
		</html>';
echo $html;
 
?>