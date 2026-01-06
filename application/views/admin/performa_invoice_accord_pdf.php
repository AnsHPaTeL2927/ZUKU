<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
$export =  ($invoicedata->exporter_detail);
$performapacking_date = date('d/m/Y',strtotime($invoicedata->performa_date));
$consig_add =  ($invoicedata->consign_detail);
$buyother = ($invoicedata->buyer_other_consign);
$payment_terms =  ($invoicedata->payment_terms);
$time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";
$locale='en-US'; //browser or user locale
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

$certification_charge = ($invoicedata->certification_charge>0)? $currency_symbol.' '.$invoicedata->certification_charge:'';
$courier_charge = ($invoicedata->courier_charge>0)? $currency_symbol.' '.$invoicedata->courier_charge:'';
$bank_charge = ($invoicedata->bank_charge>0)? $currency_symbol.' '.$invoicedata->bank_charge:'';
$certification_charge = ($invoicedata->certification_charge>0)? $currency_symbol.' '.$invoicedata->certification_charge:'';
$insurance_charge = ($invoicedata->insurance_charge>0)?$currency_symbol.' '.$invoicedata->insurance_charge:'';
$seafright_charge = ($invoicedata->seafright_charge>0)?$currency_symbol.' '.$invoicedata->seafright_charge:'';
$final_total = $invoicedata->grand_total;
$discount = ($invoicedata->discount>0)?$currency_symbol.' '.$invoicedata->discount:'';
  if($invoicedata->grand_total != '')
  { 
    $amountword = convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name);
  }
 
  else{
    $amountword = 'Zero';
  }
  $invoicevalue_say = $invoicedata->terms_name;
  
?>
<style>
table {
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	page-break-inside:avoid;
}
table.packing{
	
}
td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
th {
 	border: 0.5px solid #333;
	padding: 3px; 
}
 .profile-pic {
	position: relative;
	 
	padding: 2px;
}

.profile-pic:hover .edit {
	display: block;
	
}
.profile-pic:hover
{
	border: 1px solid #036df0;
}
.edit {
	padding-top: 7px;	
	padding-right: 7px;
	position: fixed;
	right: 13px;
	 
	display: none;
}

.edit a {
	color: blue;
}

</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"performa_invoice_pdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"performa_invoice_pdf/view_pdf";
	}
	
}
</script>
		<div class="main-container">
			<?php $this->view('lib/sidebar'); ?>
			 <div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
									<a href="javascript:void(0)">
										Dashboard
									</a>
								</li>
								<li class="active">
									PDF
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>Proforma Invoice
									 <div class="pull-right">
										
										<div class="dropdown" style="float:left;">
										<button class="btn btn-primary dropdown-toggle" style="width:75px;" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="<?=base_url('performa_invoice_pdf/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>	
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('performa_invoice_pdf/index_withoutfinish/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="<?=base_url('performa_invoice_pdf/index_withthickness/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="<?=base_url('performa_invoice_pdf1/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="<?=base_url('performa_invoice_pdf2/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="<?=base_url('performa_invoice_pdf3/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf4/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_olwin/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10</a>	
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf11/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 11 (Without Pallet)</a>
												
											 </li>											 
											</ul>
										</div>&nbsp;
									
										 <a class="btn btn-info tooltips"  data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
										
								</div>
								</h3>
								
							 </div>
						 </div>
					</div>
				 <div class="row">
						<div class="col-sm-12">
						<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
										<a href="<?=base_url()?>invoice/form_edit/<?=$invoicedata->performa_invoice_id?>">Edit Proforma Invoice</a>
								</div>
                                <div class="">
								<div class="panel-body form-body">
								<?php 
								if(!empty($invoice_html_data))
								{
									echo '<div class="pull-right">
											<a class="btn btn-danger tooltips" data-title="Delete" href="javascript:;"  onclick="delete_editable('.$invoicedata->performa_invoice_id.')"   ><i class="fa fa-trash"></i> Delete (Edited version)</a>
										</div>	
										';
								}
								?>
								 <?php ob_start();?>
								 <div id="tableHolder">
								 <div class="profile-pic" style="margin-top:80px;">
										<div class="edit pull-right">
											<a href="javascript:;" style="color:#fff;font-size:12px" class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i class="fa fa-pencil fa-lg"></i>  Edit</a>
											<a href="javascript:;" class="invoice_update_btn btn btn-success" style="display:none;color:#fff" onclick="edit_invoice();">Save</a>
										</div>
									<div class="save_invoice_html">
									<?php 
								
								if(!empty($invoice_html_data))
								{
									echo $invoice_html_data->invoice_html;
								}
								else
								{
									?>
									<table cellspacing="0"  border="1" cellpadding="0"  width="100%" class="main_table excel_cls invoice_edit_cls">
										<tr>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
										</tr>
										<tr>
											
											<td colspan="12" style="text-align:center;background-color:#c5d9f1">
												<strong style="font-size: 20px;"> PROFORMA INVOICE</strong>
											</td>
									 	</tr>
										<tr>
											<td colspan="6"  style="color:#0073ff">
												 <strong>EXPORTER/MANUFACTURER</strong>										
											</td>
											
											<td colspan="6" style="border-top:none;border-bottom: none;">
												<strong>PI NO : </strong><span style="color:#0073ff"> <?=strtoupper($invoicedata->invoice_no)?></span>
											</td>
												 
									 	</tr>
										<tr>
											<td rowspan="4" colspan="3"  style="border-right:none">
												<?=$export?>
												EMAIL:<?=$company_detail[0]->s_email?>
											</td>
											<td rowspan="4" colspan="3"  style="border-left:none">	
												 <img src="<?=base_url().'upload/'.$company_detail[0]->s_image?>" style="width:150px;height:70px" />
											</td>
											 	<td  colspan="6"  style="border-top:none;border-bottom: none;">
													<strong>DATE : </strong><?=strtoupper($performapacking_date)?>
											 	</td>
												 
									 	</tr>
										<tr>
											 	<td colspan="6" style="border-top:none;border-bottom: none;">
													<strong>PURCHASE ORDER NUMBER :</strong><?=strtoupper($invoicedata->buy_order_no)?>
											 	</td>
												
												
									 	</tr>
										<tr>
										 	<td colspan="6" style="color:#0073ff">
												 <strong> PAYMENT TERMS </strong>
												</td> 
									 	</tr>
										<tr>
										 	<td colspan="6" style="vertical-align:top;">
												 <?=strtoupper($payment_terms)?> <br>
												 RATE : <?=$invoicevalue_say?> (IN <?=$invoicedata->currency_name?>)
											</td>
									 	</tr>
										 <tr>
										 	<td colspan="6"  style="color:#0073ff">
												 <strong>CONSIGNEE DETAILS</strong>										
											</td>
											<td colspan="6" style="color:#0073ff">
												 <strong>EXPORTER BANK DETAILS </strong>				
											</td>
									 	</tr>
										<tr>
											 <td colspan="6" style="vertical-align:top;">
												 <?=strtoupper($buyother)?> 
											</td>
											<td colspan="6">
												<strong>BANK NAME : </strong><?=strtoupper($bank->bank_name)?><br />
													 
												<strong>A/C. NAME : </strong><?=strtoupper($bank->account_name)?> <br />
												<strong>ADDRESS : </strong><?=strtoupper($bank->bank_address)?><br /> 
												<strong>A/C. NO. : </strong><?=strtoupper($bank->account_no)?><br />
												<strong>SWIFT CODE : </strong><?=strtoupper($bank->swift_code)?><br />
												<strong>BRANCH CODE: </strong><?=strtoupper($bank->ifsc_code)?><br />
											</td>
									 	</tr>
										 
										<tr>
											<th colspan="3" style="text-align:center">NUMBER OF CONTAINER</th>
											<th colspan="3"  style="text-align:center"> PORT OF LOADING </th>
											<th colspan="3"  style="text-align:center">PORT OF DISCHARGE </th>
											<th colspan="3"  style="text-align:center">COUNTRY OF FINAL DESTINATION </th>
									 	</tr>
										<tr>
											<td colspan="3"  style="text-align:center">
											<?php
												if(!empty($invoicedata->container_twenty))
												{
													echo $invoicedata->container_twenty.' X 20';
												}
												if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
												{
														echo ",";
												}
												if(!empty($invoicedata->container_forty))
												{
													echo  $invoicedata->container_forty.' X 40';
												}
												 ?> FEET </td>
											<td colspan="3"  style="text-align:center"> <?=strtoupper($invoicedata->port_of_loading)?>  </td>
											<td colspan="3"  style="text-align:center">  <?=strtoupper($invoicedata->port_of_discharge)?>  </td>
											
											<td colspan="3" style="text-align:center"> <?=strtoupper($invoicedata->country_final_destination)?>	 </td>
									 	</tr>
									</table>
								 	<table cellspacing="0"  border="1" cellpadding="0" style="" width="100%" class="excel_cls invoice_edit_cls">
										
								<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$no_of_row = 5;
								 	$hsn_array = array();
								$performa_trn_array = array();
								for($j=0; $j<count($product_data);$j++)
								{ 
								 
											if(!in_array($product_data[$j]->series_name,$hsn_array))
											{												
									?>
										<tr>
											<th colspan="12" style="text-align:center;background-color:#c5d9f1;font-size:14px"><?=$product_data[$j]->series_name?> - HSNC - <?=$product_data[$j]->hsnc_code?> </th>
										</tr>
										<tr>
										   <th width="13%" style="text-align:center;background-color:#c5d9f1">SIZE & PACKING</th>
										   <th width="8%" style="text-align:center;background-color:#c5d9f1">DESIGN NAME</th>
										   <th width="5%" style="text-align:center;background-color:#c5d9f1">FINISH</th>
										   <th width="7%" style="text-align:center;background-color:#c5d9f1">NO OF RANDOM</th>
										   <th width="18%" style="text-align:center;background-color:#c5d9f1">IMAGE	</th>
										    <th width="8%" style="text-align:center;background-color:#c5d9f1">PALLET TYPE</th>
										   <th width="6%" style="text-align:center;background-color:#c5d9f1">BOXES PER PALLET	</th>
										   <th width="6%" style="text-align:center;background-color:#c5d9f1">TOTAL PALLET	</th>
										   <th width="5%" style="text-align:center;background-color:#c5d9f1">TOTAL BOXES</th>
										    <th width="8%" style="text-align:center;background-color:#c5d9f1">QUANTITY IN <?=$invoicedata->per_value?> </th>
										   <th width="5%" style="text-align:center;background-color:#c5d9f1">RATE IN <?=$invoicedata->currency_name?> (<?=$invoicedata->per_value?>)</th>
										   <th width="11%" style="text-align:center;background-color:#c5d9f1">AMOUNT IN <?=$invoicedata->currency_name?> </th>
								 	   </tr>
											<?php 
												 array_push($hsn_array,$product_data[$j]->series_name);
											}
								for($i=0; $i<count($product_data);$i++)
								{ 
									 
								 $n = 1;
									if($product_data[$i]->series_name==$product_data[$j]->series_name && !in_array($product_data[$i]->performa_trn_id,$performa_trn_array))
										{
												 $Total_plts 	+= $product_data[$i]->total_no_of_pallet;
												$Total_ammount += $product_data[$i]->total_product_amt;
												$Total_weight  += $product_data[$i]->total_gross_weight;
									
								  foreach($product_data[$i]->packing  as $packing_row)
								  {
									  $per = $packing_row->per;
									  $sqm = '';
									  if($per == "Sq.Ft")
									  {
										  $sqm = $packing_row->no_of_sqm * 10.76;
										   $Total_sqm 	+= $sqm;
									  }
									  else
									  {
										  $sqm = $packing_row->no_of_sqm;
										   $Total_sqm 	+= $sqm;
									  }
								?>
									<tr>
										<td style="text-align:center"><?=$product_data[$i]->size_type_mm?> <br> PCS/BOX : <?=$product_data[$i]->pcs_per_box?>  <br> COVERAGE : <?=$product_data[$i]->sqm_per_box?> SQM <br> Box Brand : <?=$product_data[$i]->box_design_name?></td>
									 	<td style="text-align:center;color:#0073ff" ><?=$packing_row->design_name?>
										<?=!empty($packing_row->design_type_name)?"<br>(".$packing_row->design_type_name.")":""?>
										</td>
										<td style="text-align:center;color:#0073ff" ><?=$packing_row->finish_name?></td>
										<td style="text-align:center"><?=$packing_row->no_of_randome?></td>
										 <td style="text-align:center">
											<p style="margin: 0 auto; width:150px;height:107px;overflow:hidden">
											  <img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:140px"/> 
											 </p>
									 	</td>
										 <td style="text-align:center"> <?=$product_data[$i]->product_packing_name?></td>
										 <td style="text-align:center">
										<?php 
											 if($packing_row->no_of_pallet>0)
											 {
											 	$product_plts = $product_data[$i]->boxes_per_pallet;
											 	
											 }
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet > 0 )
											{
											  	$product_plts  =  $product_data[$i]->box_per_big_pallet.'<br>'.$product_data[$i]->box_per_small_pallet;
											}
											 else
											 {
											 	$product_plts = '-';
											 }
										?>
											<?=$product_plts?> 
										</td>
										<td style="text-align:center">
										<?php 
											if($packing_row->no_of_pallet>0)
											{
											 	$no_of_pallet = $packing_row->no_of_pallet;
												 
											}
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
											{
												$no_of_pallet =  $packing_row->no_of_big_pallet.'<br>'.$packing_row->no_of_small_pallet;
										 	}
											else
											{
												 $no_of_pallet =  '-';
											}
										?>
										<?=$no_of_pallet?>
										</td>
										<td style="text-align:center"><?=$packing_row->no_of_boxes?></td>
										 
										 <td style="text-align:center"><?=number_format($sqm,2,'.','')?></td>
										<td style="text-align:center"><?=$currency_symbol?><?=number_format($packing_row->product_rate,2)?></td>
										<td style="text-align:center"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2)?></td>
									</tr>
								<?php
								 	 $Total_box 	+=$packing_row->no_of_boxes;
								
								 $no_of_row--;
									}
									 array_push($performa_trn_array,$product_data[$i]->performa_trn_id);
									}
								}
								}
								if(!empty($invoicedata->sample_remarks))
								{
									?>
								<tr>
									<th colspan="12" style="vertical-align:top;border-bottom:none;text-align:left" height="111px" > 
										<?=($invoicedata->sample_remarks)?>
									</th>
								    
								</tr>
								<?php
								$no_of_row--;
								}
								   ?>
								 
			 					 <tr>
										<td colspan="6" style="text-align:right;font-weight:bold;background-color:#c5d9f1">TOTAL</td>
										 <td style="text-align:center;font-weight:bold;background-color:#c5d9f1"></td>
										<td style="text-align:center;font-weight:bold;background-color:#c5d9f1"><?=($Total_plts == 0)?'-':$Total_plts?></td>
										<td style="text-align:center;font-weight:bold;background-color:#c5d9f1"><?=$Total_box?></td>
									 	<td style="text-align:center;font-weight:bold;background-color:#c5d9f1"><?=number_format($Total_sqm,2,'.','')?> </td>
										<td style="text-align:center;font-weight:bold;background-color:#c5d9f1"> </td>
										<td style="text-align:center;font-weight:bold;background-color:#c5d9f1"><?=$currency_symbol?><?=number_format($Total_ammount,2)?> 
										</td>
								 </tr>
								  <?php 
									if($invoicedata->certification_charge > 0)
									{
								 ?>
								  <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											Certification Charge
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->certification_charge,2,'.','')?> 
										</td>
								 </tr>
								  <?php 
								 } 
								 if($invoicedata->insurance_charge > 0)
								 {
								 ?>
								 <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											Insurance Charge
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->insurance_charge,2,'.','')?> 
										</td>
								 </tr>
								  <?php
								 } 
								 if($invoicedata->seafright_charge > 0)
								 {
								 ?>
								 <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											Seafright Charge
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->seafright_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->courier_charge > 0)
								 {
								 ?>
								 <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											Courier Charge
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->courier_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								   if(!empty($invoicedata->extra_calc_name))
								 {
								 ?>
								 <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											<?=$invoicedata->extra_calc_name?> (<?=($invoicedata->extra_calc_opt == 1)?'+':'-'?>)
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->extra_calc_amt,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 if($invoicedata->bank_charge > 0)
								 {
								 ?>
								  <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											Bank Charge
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->bank_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								  if($invoicedata->discount > 0)
								 {
								 ?>
								 <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											Discount
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->discount,2,'.','')?> 
										</td>
								 </tr>
								  <?php
								 } 
								 if($invoicedata->igst_value > 0)
								 {
								 ?>
								  <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											IGST (<?=number_format($invoicedata->igst_per_value,2,'.','')?>%)
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->igst_value,2,'.','')?> 
										</td>
								 </tr>
								  <?php 
								 } 
								  if($invoicedata->sgst_value > 0)
								 {
								 ?>
								  <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											SGST (<?=number_format($invoicedata->sgst_per_value,2,'.','')?>%)
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->sgst_value,2,'.','')?> 
										</td>
								 </tr>
								  <?php 
								 } 
								  if($invoicedata->cgst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="9" style="text-align:right;font-weight:bold"> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											CGST (<?=number_format($invoicedata->cgst_per_value,2,'.','')?>%)
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->cgst_value,2,'.','')?> 
										</td>
								 </tr>
								  <?php 
								 } 
								  
								 ?>
								 
								 <tr>
										<td colspan="3" style="text-align:right;font-weight:bold">TOTAL AMOUNT CHARGABLE IN WORDS  </td>
										 
										<td colspan="6" style="font-weight:bold">
										<?php
											$word = convertamonttousd($Total_ammount,$invoicedata->currency_name);
											if($invoicedata->currency_name == "INR")
											{
												$word = converttorsword($Total_ammount);
											}
											echo strtoupper($word); 
										?> 
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">
											Total <?=$invoicedata->terms_name?> Value
										</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;">
											<?=$currency_symbol?> <?=number_format($invoicedata->grand_total,2,'.','')?> 
										</td>
								 </tr>	
								 <tr>
										<td colspan="7" style="font-weight:bold">
											<?=$invoicedata->remarks?>
										</td>
										 
										<td colspan="5" style="font-weight:bold;text-align:center"> 
											<?=$company->s_name?><br>
												<img src="<?=base_url().'upload/'.$company->s_c_sign?>" width="100px" height="100px">
												<br>
											<?=strtoupper($company->authorised_signatury)?>
									 	</td>
								 </tr>									 
						 </table>		
								<?php
								}
								?>
											</div>		 
										</div>
								</div>
									<?php
								  $output = ob_get_contents(); 
									 $_SESSION['performa_invoice_no'] = $invoicedata->invoice_no.' - '.$consig_add.' - '.$invoicedata->country_final_destination.' - '.date('d-m',strtotime($invoicedata->performa_date));
									 $_SESSION['performa_content'] = $output;
									  if($mode=="1")
									 {
										 echo "<script>view_pdf(0)</script>";
									 }
								?>
						 		
								</div>
							 	</div>
							 
						</div>
					 
					</div>
 
				</div>
			</div>
				
		</div>
 
<?php $this->view('lib/footer'); ?>
<script src="<?=base_url()?>adminast/assets/js/jquery.table2excel.js"></script>
<script>
 function delete_editable(performa_invoice_id)
{
	Swal.fire({
  title: 'Delete Editable Version?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
		 if (result.value) {
	block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"performa_invoice_pdf/delete_editable",
       data:
	   {
			"performa_invoice_id"	: performa_invoice_id,
			"performa_invoice_pdf"	: 'performa_invoice_accord_pdf'
	   }, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
  }
		});
}
function editable_table()
{
	$(".invoice_edit_cls").attr("contenteditable",true)
	$(".invoice_edit_btn").hide();
	$(".invoice_update_btn").show();
}
function edit_invoice()
{
	 block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"customerinvoiceview/performa_html_update",
       data:
	   {
			"performa_invoice_id"	: <?=$invoicedata->performa_invoice_id?>, 
			"invoice_html"			: $(".save_invoice_html").html(),  
			"invoice_table_name"	: 'performa_invoice_accord_pdf'  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}
 
function toExcel() {

    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#tableHolder').html()));
    e.preventDefault();
}
</script>