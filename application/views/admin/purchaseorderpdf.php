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
'.$_SESSION['purchaseorder_content'].'
</head>
</body>';
		$footer = '<div style="text-align:right;">
								CREATED BY : Zuku Export Software
							 </div>';
 // echo $html;exit;
 error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
$mpdf->SetFooter($footer);
$mpdf->WriteHTML($html);

$mpdf->SetTitle($_SESSION['purchase_order_no']);
$mpdf->Output($_SESSION['purchase_order_no'].".pdf","I");
 exit;