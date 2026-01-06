<?php
$html = '<body>
<head>
<style>
// table {
//         font-family: calibri;
//         border: 0.5px solid #333;
//         border-collapse: collapse;
//         font-size: 8px;
//     }
//     table tr td {
//         font-family: calibri;
//         border: 0.5px solid #333;
//         border-collapse: collapse;
//         font-size: 8px;
//     }
body {
	font-family: Calibri, sans-serif;
	margin: 0;
	padding: 0;
}
.container {
	width: 100%;
	padding: 20px;
}
h1 {
	text-align: center;
	color: #00FFFF;
	font-family: Calibri, sans-serif;
}
table {
	width: 100%;
	border: 0.5px solid #333;
	border-collapse: collapse;
	font-size: 8px;
}
table tr th, table tr td {
	border: 0.5px solid #333;
	padding: 5px;
	text-align: left;
}
</style>
'.$_SESSION['viewunderproduction'].'
</head>
	 
</body>';
 // echo $html;exit;
 error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
$mpdf->WriteHTML($html);
$mpdf->SetTitle('Under Production');
$mpdf->Output('Under Production.pdf','I');
 