<?php
$html = '<body>
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
'.$_SESSION['coo_content'].'
</head>
	 
		</body>';
 // echo $html;exit;
 error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
$mpdf->WriteHTML($html);
$mpdf->SetTitle('COO - '.$_SESSION['coo_invoice_no']);
$mpdf->Output('COO - '.$_SESSION['coo_invoice_no'].".pdf","I");
 