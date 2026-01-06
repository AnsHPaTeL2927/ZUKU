<?php

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($_SESSION['ordersheetnew']);
libxml_clear_errors();

$rows = $dom->getElementsByTagName('tr');

foreach ($rows as $row) {
    $cells = $row->getElementsByTagName('td');
    if ($cells->length > 0) {
        $row->removeChild($cells->item($cells->length - 1));
    }
    $headers = $row->getElementsByTagName('th');
    if ($headers->length > 0) {
        $row->removeChild($headers->item($headers->length - 1));
    }
}
$modifiedOrderSheet = $dom->saveHTML();

// Adding a black and bold h2 heading to the HTML content
$html = '<body>
<head>
<style>
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
    h2 {
        color: black;
        font-weight: bold;
    }
    table {
        width: 100%;
        border: 1px solid #333; 
        border-collapse: collapse;
        font-size: 10px; 
    }
    table th, table td {
        border: 1px solid #333; 
        padding: 8px; 
        text-align: left;
    }
    table th {
        background-color: #2E5CAC; 
        color: white; 
    }
</style>
</head>
<body>
<h2>Order Sheet</h2>
'.$modifiedOrderSheet.'
</body>';

// Generate PDF using mPDF library
error_reporting(0);
$this->view('mpdf/mpdf.php');
$mpdf = new mPDF('utf-8', 'A4', '7', 'calibri', 5, 5, 5, 5, 0, 0); 
$mpdf->WriteHTML($html);
$mpdf->SetTitle('Order Sheet');
$mpdf->Output('Order Sheet.pdf', 'I');
