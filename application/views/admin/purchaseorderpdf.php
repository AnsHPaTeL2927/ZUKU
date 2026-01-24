<?php
if (empty($_SESSION['purchaseorder_content']) || empty($_SESSION['purchase_order_no'])) {
	header('Location: ' . base_url() . 'purchaseorder_listing');
	exit;
}
try {
	$html = '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
.po-print-area td, .po-print-area th { border: 1px solid #333; padding: 8px; }
.po-print-area table { border-collapse: collapse; width: 100%; margin: 0; }
.po-print-area { padding: 0; margin: 0; }
.po-print-area > * { margin-left: 0 !important; padding-left: 0 !important; }
.po-print-area .po-section { margin-bottom: 32px; }
.po-print-area .po-section h4 { margin: 0 0 14px 0; font-size: 16px; }
.po-print-area .po-section .table { margin-bottom: 0; }
.po-print-area .po-note-box { background: #e8f4fc; border-left: 4px solid #1e88e5; padding: 12px 16px; margin: 24px 0; text-align: center; }
.po-print-area .po-signature-row { margin-top: 48px; margin-bottom: 24px; padding-top: 24px; border-top: 1px solid #e0e0e0; }
.po-print-area .po-signature-row .po-sig-table { width: 100%; border: 0; border-collapse: collapse; table-layout: fixed; }
.po-print-area .po-signature-row .po-sig-table td { border: 0; padding: 0 24px; vertical-align: top; width: 50%; text-align: center; }
.po-print-area .po-signature-box { display: block; text-align: center; width: 100%; max-width: 240px; margin: 0 auto; }
.po-print-area .po-signature-box .po-sig-label { font-weight: bold; font-size: 15px; margin-bottom: 0; display: block; color: #222; }
.po-print-area .po-signature-box .po-sig-gap { height: 40px; min-height: 40px; }
.po-print-area .po-signature-box .po-sig-line { width: 180px; height: 0; border-bottom: 1px solid #333; margin: 0 auto; display: block; }
.po-print-area .po-signature-box .po-sig-details { font-size: 12px; font-weight: normal; line-height: 1.4; color: #444; text-transform: uppercase; margin-top: 6px; }
.po-print-area .po-signature-box .po-sig-details .po-sig-for { margin-bottom: 2px; }
.po-print-area .po-signature-box .po-sig-img { max-width: 120px; max-height: 48px; margin: 8px auto 0; display: block; }
table { font-family: calibri; border-collapse: collapse; }
td { border: 1px solid #333; padding: 8px; }
th { border: 1px solid #333; padding: 8px; font-weight: bold; }
</style>
</head>
<body>
'.$_SESSION['purchaseorder_content'].'
</body>
</html>';
	$footer = '<div style="text-align:right;">CREATED BY : Zuku Export Software</div>';
	error_reporting(0);
	$this->view('mpdf/mpdf.php');
	$mpdf = new mPDF('utf-8', 'A4', '7', 'calibri', 5, 5, 5, 5, 0, 0); 
	$mpdf->SetFooter($footer);
	$mpdf->WriteHTML($html);
	$mpdf->SetTitle($_SESSION['purchase_order_no']);
	$mpdf->Output($_SESSION['purchase_order_no'].".pdf","I");
	exit;
} catch (Exception $e) {
	log_message('error', 'PDF generation error: ' . $e->getMessage());
	header('Location: ' . base_url() . 'purchaseorder_listing');
	exit;
}
