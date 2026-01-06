<?php

$currentDate = date('d-m-Y'); 
$dppqs = $invoicedata->dppqs_number;

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
</head>


' . $_SESSION['fumigation_content'] . '


</body>';

// Uncomment the following lines if you need to include the mPDF library and generate the PDF
error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf = new mPDF('utf-8', 'A4', '7', 'calibri', 5, 5, 5, 5, 0, 0); 

$mpdf->WriteHTML($html);
$mpdf->autoPageBreak = false;

$mpdf->SetTitle('FUMIGATION - ' . $_SESSION['fumigation_no']);
$mpdf->Output('FUMIGATION - ' . $_SESSION['fumigation_no'] . ".pdf", "I");
?>
