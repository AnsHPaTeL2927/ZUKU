<?php
$html = '<body>
<head>
<style>
table {
	font-family: cambria;
	border: 0.5px solid #333;
	border-collapse: collapse;
	font-size:9px;
}
 
td {
 	border: 0.5px solid #333;
	padding: 2px; 
}
th {
 	border: 0.5px solid #333;
	padding:2px; 
}
 
</style>
'.$_SESSION['performa_content'].'
</head>
</body>';
 //echo $html;exit;
 error_reporting(E_all);
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
 
$mpdf->WriteHTML($html);

$mpdf->SetTitle($_SESSION['performa_invoice_no']);
$mpdf->Output($_SESSION['performa_invoice_no'].".pdf","I");
exit;
 