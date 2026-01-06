<?php
$html = $_SESSION['export_content'];
 $file_name =$_SESSION['export_invoice_no'].".xls";
$excel_file=$html;
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=$file_name");
echo $excel_file;