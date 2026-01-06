<?php
$html = '
<head>
<style>
table {
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	 
}
 
td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
th {
 	border: 0.5px solid #333;
	padding: 3px; 
}
 
</style>

</head>
<body>

	 '.$_SESSION['tax_content'].'
		</body>';
 // echo $html;exit;
 error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
$mpdf->WriteHTML($html);
$mpdf->SetTitle('Tax Invoice - '.$_SESSION['export_invoice_no']);
$mpdf->Output('Tax Invoice - '.$_SESSION['export_invoice_no'].".pdf","I");
 ?>