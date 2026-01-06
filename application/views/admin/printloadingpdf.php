<?php
$html = '<body>
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
'.$_SESSION['producation_content'].'
</head>
	 
		</body>';
 // echo $html;exit;
 error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4-L','7','calibri',5,5,5,5,0,0); 
 
$mpdf->WriteHTML($html);

$mpdf->SetTitle('Production - '.$_SESSION['performainvoice_no']);
$mpdf->Output('Production - '.$_SESSION['performainvoice_no'].".pdf","I");
 