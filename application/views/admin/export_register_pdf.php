<?php
$html = '<body>
<head>
<style>
table {
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	font-size:8px;
}
table tr td{
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	font-size:8px;
}  
</style>
'.$_SESSION['export_register'].'

</head>
	 
		</body>';
 // echo $html;exit;
 error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
$mpdf->WriteHTML($html);
$mpdf->SetTitle('Export Register');
$mpdf->Output('Export Register.pdf','I');
 