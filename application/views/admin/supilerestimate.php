<?php
 $locale='en-US'; //browser or user locale
$currency=$q_data->invoice_currency_id; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
$currency_symbol = ($invoicedata->invoice_currency_id=="INR")?"INR":$currency_symbol;
 
$html = '<body>
<head>
<style>
body {
	font-family: calibri;
	font-size: 12px;
}
table {
 
	border: 0.5px solid #333;
	border-collapse: collapse;
	 
}
 
td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
th {
 	border: 0.5px solid #333;
	padding:2px; 
}
 
</style>
 
</head>
<div style="border: 1px solid #333;padding:10px">
		<div style="text-align:right">
			<img src="'.base_url().'upload/'.$company_detail[0]->s_image.'" alt="" width="" height="100">
			<br>
		</div>
		<div style="font-weight:bold">
			Dear '.$q_data->quotation_for.',<br><br>
			Subject : Quotation for '.$q_data->series_name.'
		</div>
		<div>
		<br>
			I hope you are doing well. We thank you for your enquiry for '.$q_data->series_name.' price; we enclose our
quotation for '.$q_data->series_name.' for '.$q_data->terms_name.' '.$q_data->terms_of_delivery.' port with '.$q_data->packing_name.' Pallet packing.
<br>
<br>
		</div>
		<div>
			<table class="table">
				<tr>
					<td style="text-align:center">Type Of Tile</td>
					<td style="text-align:center">Size</td>
					<td style="text-align:center">Pcs/Box</td>
					<td style="text-align:center">SQM/Box</td>
					<td style="text-align:center">Weight Per Box</td>
					<td style="text-align:center">Total Boxes</td>
					<td style="text-align:center">Total Pallets</td>
					<td style="text-align:center">Total SQM</td>
					<td style="text-align:center"><strong>'.$q_data->terms_name.' Price</strong></td>
					<td style="text-align:center">Unit</td>
					<td style="text-align:center"> Total '.$q_data->terms_name.' Price Per Container </td>
					 
				</tr>';
				foreach($q_data->trn as $row)
				{
					$total_box = 0;
					$total_pallet = 0;
					$total_sqm = 0;
					if($row->boxes_per_pallet > 0)
					{
						$total_box 		= $row->box_per_container;
						$total_pallet 	= $row->total_pallent_container;
						$total_sqm 		= $row->sqm_per_container;
					}
					else if($row->total_boxes > 0)
					{
						$total_box = $row->total_boxes;
						$total_sqm = $row->withoutpallet_sqm_per_container;
					}
					else if($row->box_per_big_pallet > 0 || $row->box_per_small_pallet > 0)
					{
						$total_box = $row->multi_box_per_container;
						$total_pallet 	= 'Big :'.$row->big_pallet_container.' <br> Small :'.$row->small_pallet_container;
						$total_sqm 	=  $row->multi_sqm_per_container;
					}
					$total_price = 0;
					if($row->our_price_type == "Feet")
					{
						$feet 			= $row->feet_per_box * $total_box;
						$total_price	= $feet * $row->our_selling_price;
					}
					else if($row->our_price_type == "Box")
					{
						$box = $total_box;
				 		$total_price	= $box * $row->our_selling_price;
					}
					else if($row->our_price_type == "SQM")
					{
						$sqm = $total_sqm;
				 		$total_price	= $sqm * $row->our_selling_price;
					}
					else if($row->our_price_type == "SQM")
					{
						$pcs = $total_box * $row->pcs_per_box;
				 		$total_price	= $pcs * $row->our_selling_price;
					}
					$html .= '<tr>
								<td style="text-align:center">'.$row->series_name.'</td>
								<td style="text-align:center">'.$row->size_type_mm.'</td>
								<td style="text-align:center">'.$row->pcs_per_box.'</td>
								<td style="text-align:center">'.$row->sqm_per_box.'</td>
								<td style="text-align:center">'.$row->weight_per_box.'</td>
								<td style="text-align:center">'.$total_box.'</td>
								<td style="text-align:center">'.$total_pallet.'</td>
								<td style="text-align:center">'.$total_sqm.'</td>
								<td style="text-align:center"><strong>'.$currency_symbol.' '.number_format($row->our_selling_price,2).'</strong></td>
								<td style="text-align:center">'.$row->our_price_type.'</td>
							 	<td style="text-align:center">'.$currency_symbol.' '.number_format($total_price,2).'</td>
							</tr>
							<tr>
								<td style="text-align:center" colspan="11"> &nbsp;</td>
								 
							</tr>
							';
				}
			$html .= '</table>
		</div>
		<div style="line-height:25px;font-size:10px;">
		<br>
			<strong>Terms & Condition:-</strong> <br>
					'.$q_data->quotation_terms.'
		</div>
		<div >
		<br>
		Regards, <br>
			<img src="'.base_url().'upload/'.$company_detail[0]->s_c_sign.'" alt="" width="" height="100"><br>
			'.$company_detail[0]->s_name.'
		</div>
</div>

</body>';
 // echo $html; exit;
  
$this->view('mpdf/mpdf.php');
$mpdf=new mPDF('utf-8','A4','10','calibri',5,5,5,5,0,0); 
 
 
$mpdf->WriteHTML($html);

$mpdf->SetTitle('Quotation - '.$q_data->quotation_for.$q_data->quotation_id);
$filename = $mpdf->Output('upload/quotation/Quotation - '.$q_data->quotation_for.$q_data->quotation_id.'.pdf',"F");
 echo 'Quotation - '.$q_data->quotation_for.$q_data->quotation_id.'.pdf';
 