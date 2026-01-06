<?php 

 $invoice_date = date('d-m-Y',strtotime($invoicedata->invoice_date));
 $customer_invoice_no =$invoicedata->customer_invoice_no;
 $export =  ($invoicedata->exporter_detail);
 $export_ref_no =  ($invoicedata->export_ref_no);
 $export_date =  date('d-m-Y',strtotime($invoicedata->export_date));
 $buy_order_no = strip_tags($invoicedata->customer_buy_order_no);
 $exporter_email = $invoicedata->e_email;
 $exporter_mobile = $invoicedata->e_mobile;
 $exporter_gstin = $invoicedata->e_gstin;
 $exporter_pan = $invoicedata->exporter_pan;
 $exporter_iec = $invoicedata->exporter_iec;
 $consign_name = $invoicedata->c_name;
 $consign_address = ($invoicedata->consign_address);
 $buyer_other_consign = ($invoicedata->buyer_other_consign);	
 $pre_carriage_by=$invoicedata->pre_carriage_by;
 $place_of_receipt=$invoicedata->place_of_receipt;
 $country_origin_goods = $invoicedata->country_origin_goods;
 $country_final_destination = $invoicedata->country_final_destination;
 $bank_detail = $invoicedata->bank_detail;    
 $flight_name_no=$invoicedata->flight_name_no;   				 
 $export_port_loading = $invoicedata->port_of_loading;
 $port_of_discharge =  $invoicedata->port_of_discharge;
 $final_destination =  $invoicedata->final_destination;
 $export_payment_terms = $invoicedata->payment_terms;
 $no_of_container = $invoicedata->container_details;
 $export_terms_of_delivery = $invoicedata->terms_of_delivery;
 $remarks = $invoicedata->remarks;
 if($invoicedata->Exchange_Rate_val==0)
 {
	  if($invoicedata->currency_name=="Euro")
	 {
	 	$exchangerate = $userdata->euro;
	 }
	 else if($invoicedata->currency_name=="RS")
	 {
	 	$exchangerate = "1";
	 }
	 else{
	 	$exchangerate = $userdata->usd; 
	 }
  
 }
 else
 {
	 $exchangerate = $invoicedata->Exchange_Rate_val;
 }
 if($invoicedata->currency_name=="Euro")
 {
	 $currency_symbol = "&euro;";
 }
 else if($invoicedata->currency_name=="RS")
 {
	 $currency_symbol = "₹";
 }
 else{
	 $currency_symbol = "$"; 
 }
 
 $invoicevalue_say 	= $invoicedata->terms_name;
 $rex_no 			= $invoicedata->rex_no;
 $rex_no_detail 	= ($invoicedata->rexdetail_status == 1)?$invoicedata->rexnodetail:$invoicedata->export_rex_no_detail;
 $rex_no_detail 	= ($invoicedata->rex_detail_status == 1)?$invoicedata->rex_no_detail:$rex_no_detail;
 $rex_status = ($invoicedata->rexdetail_status == 1)?'checked':'';
 $rex_status = ($invoicedata->rex_detail_status == 1)?'checked':$rex_status;
 if(empty($rex_no))
 {
	 $rex_no = $company_detail[0]->rex_no;
 }
 if(empty($rex_no_detail))
 {
	 $rex_no_detail = $invoicedata->rex_no_detail;
 }
 if(empty($remarks))
 {
	 //$remarks = 'We Cerify That: &#13;&#10; 1) The Goods are INDIA Origin. &#13;&#10; 2) We declare that this invoices shows the actual price of goods described and that all particulars are ture and correct.  &#13;&#10; 3) B/L No:- '.$invoicedata->$exporter_pan.' &#13;&#10; 4) The exporter '.$company_detail[0]->s_name.' INREX: INREXAAUFG6907EEC006 Dt:- 23/12/2018. (1) of the products covered by the this document declares that, except where otherwsie cleary indicated, these products are of India. (2) Preferential origin according to rules of origin of the Generalised System of Preferences of the European Union and that the origin criterion met is "W" 6907.';
 }
 $locale='en-US'; //browser or user locale
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
$this->view('lib/header'); 
  
?>	
		<div class="main-container">
			<?php $this->view('lib/sidebar'); ?>
			<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
									<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								<li class="active">
									<a href="<?=base_url().'customerinvoice_listing'?>">Customer Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
							<h3>Customer Invoice Product Entry</h3>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							 <div id="accordion">
							 <h3>
								 Customer Invoice Detail
							  </h3>   
								<div class="" style="padding:10px;" >
										<table cellspacing="0" cellpadding="0"    width="100%">
										 	<tr>
												<td rowspan="6" width="1%">
													<span>E</span><br>	
													<span>X</span><br>		
													<span>P</span><br>	
													<span>O</span><br>		
													<span>R</span><br>		
													<span>T</span><br>		
													<span>E</span><br>	
													<span>R</span>
												</td>
												<td colspan="6" rowspan="3" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
													 <?=$export?>
												</td>
												<td width="15%">Customer Invoice No</td>
												<td width="15%" colspan="2" style="font-weight:bold">
													<?=$customer_invoice_no?>
												</td>
												<td  width="11%" >DATE</td>
												<td  width="12%" style="font-weight:bold">
													<?=$export_date?>
												</td>
											</tr>
											<tr>
												<td>Export Ref. No</td>
												<td colspan="2" style="font-weight:bold" >
													<?=$export_ref_no?>
												</td>
												<td>DATE</td>
												<td style="font-weight:bold"> 
													<?=$export_date?>
												</td>
											</tr>
											<tr>
												<td rowspan="4">Buyer Order No &amp; Date</td>
												<td rowspan="4" colspan="4" style="font-weight:bold">
														<?=$buy_order_no?>
													</td>
											 </tr>
											<tr>
												<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">Email</td>
												<td width="3%">:</td>
												<td width="15%" colspan="2" style="font-weight:bold"> 
													<?=$exporter_email?>
												</td>
												<td width="5%">MOBILE</td>
												<td width="15%" style="font-weight:bold" >
													<?=$exporter_mobile?>
												</td>
												
											</tr>
											<tr>
												<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">GSTIN</td>
												<td width="3%">:</td>
												<td width="15%" colspan="2" style="font-weight:bold"> 
														<?=$exporter_gstin?>
												</td>
												<td width="5%">PAN NO</td>
												<td width="15%" style="font-weight:bold" >
													<?=$exporter_pan?>
												</td>
												
											</tr>
											<tr>
												<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">IEC</td>
												<td width="3%">:</td>
												<td width="15%" colspan="4" style="font-weight:bold"> 
													<?=$exporter_iec?>
												</td>
											</tr>
											<tr>
												<td rowspan="2" style="font-size: 11px;">
													<span>C</span><br>	
													<span>O</span><br>		
													<span>N</span><br>	
													<span>S</span><br>		
													<span>I</span><br>		
													<span>G</span><br>		
													<span>N</span><br>	
													<span>E</span><br>
													<span>E</span>
												</td>
												<td colspan="3">CONSIGNEE NAME :</td>
												 <td colspan="3" style="font-weight:bold">
													 <?=$consign_name?>
												</td>
												 <td colspan="5">
												  
												 </td>
											</tr>
											<tr>
												<td colspan="6" style="font-weight:bold">
														<?=$consign_address?>
												</td>
												<td >Buyer If Other Then Consignee [Notify]</td>
												<td colspan="4" style="font-weight:bold">
													<?=$buyer_other_consign?>
												</td>
											</tr>
											<tr>
												<td colspan="4">Pre Carriage By</td>
												<td colspan="3">Place of Receipt </td>
												<td colspan="2">Country of Origin</td>
												<td colspan="3">Country of Destination </td>
											 </tr>
											 <tr>
												<td colspan="4" style="font-weight:bold">
													<?=$pre_carriage_by?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$place_of_receipt?>
												</td>
												<td colspan="2" style="font-weight:bold">
													<?=$country_origin_goods?>
												</td>
												<td colspan="3" style="font-weight:bold">
														<?=$country_final_destination?>
												</td>
											</tr>
											  <tr>
												<td colspan="4">Vessel / Flight Name & No </td>
												<td colspan="3">Port Of Loading	 </td>
												<td   rowspan="4">Bank Details  </td>
												<td colspan="4" rowspan="4" style="font-weight:bold">
													<?=($bank_detail)?>
												</td>
											  </tr>
											  <tr>
												<td colspan="4" style="font-weight:bold">
													<?=$flight_name_no?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$export_port_loading?>
												</td>
											</tr> 
											  <tr>
												<td colspan="4">Port Of Discharge</td>
												<td colspan="3">Final Destination </td>
												 
											  </tr>
											<tr>
												<td colspan="4" style="font-weight:bold;text-align:center">
														<?=$port_of_discharge?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$final_destination?>
												</td>
												</tr>
												<tr>
															<td colspan="5">Container Details</td>
															<td colspan="2">Nature Of Contract</td>
															<td rowspan="2">Payment Terms</td>
															<td colspan="4" rowspan="2" style="font-weight:bold">
																<?=$export_payment_terms?>
															</td>
													</tr>
												<tr>
													<td colspan="2" style="font-weight:bold">
														<?=$no_of_container?>
													</td>
													<td style="font-weight:bold">X</td>
													<td colspan="2" style="font-weight:bold">20FT FCL</td>
													<td colspan="2" style="font-weight:bold">
														<?=$export_terms_of_delivery?>
													</td>
												</tr>
				 
								</table>
							 </div>
							  <h3>
								Product Detail
							  </h3>  
							  <form action="javascript:;" name="customer_product_form" id="customer_product_form" >
								<div class="">
								
									<div class="panel-body">
										 
										 
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="sample-table-1" width="100%">
													<thead>
														<tr>
															<th style="text-align:center" rowspan="2" width="10%">Sr No.</th>
															<th style="text-align:center" rowspan="2" width="10%">Size</th>
															<th style="text-align:center" rowspan="2" width="20%">Description of Goods</th>
															<th style="text-align:center" rowspan="2" width="10%">Client Design Name</th>
															 
															<th style="text-align:center" rowspan="2" width="10%">HSN Code</th>
															<th style="text-align:center" colspan="3">Quantity </th>
															<th style="text-align:center" rowspan="2" width="5%">Unit</th>
															<th style="text-align:center" rowspan="2" width="10%">
																Rate In <?=$invoicedata->currency_name?>
															</th>
															<th style="text-align:center" rowspan="2" width="10%">Total Amount</th>
													 	</tr> 
														<tr>
															<th width="5%" style="text-align:center">
																SQM
															</th>
															<th width="5%" style="text-align:center" >
																Boxes
															</th>
															<th width="5%" style="text-align:center" >
																Quantity
															</th>
														</tr>
													</thead>
													<tbody>
													 	<?php
											$no = 1;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_amount= 0;
											$Total_qty= 0;
											for($n=0;$n<count($loading_trn);$n++)
											{
												$product_rate 	= $loading_trn[$n]->product_rate;
												$product_amt 	= $row->product_amt;
												 
												// if($loading_trn[$n]->performa_per == "SQF")
												// {
													// $feet =  $loading_trn[$n]->origanal_boxes * $loading_trn[$n]->feet_per_box;
													
													// $product_rate = $loading_trn[$n]->product_amt/$feet;
												// }
												// else if($loading_trn[$n]->performa_per == "BOX")
												// {
													// $box =  $loading_trn[$n]->origanal_boxes;
													// $product_rate = $loading_trn[$n]->product_amt/$box;
												// }
												// else if($loading_trn[$n]->performa_per == "SQM")
												// {
													// $sqm =  $loading_trn[$n]->no_of_sqm;
													// $product_rate = $loading_trn[$n]->product_amt/$sqm;
												// }
												// else if($loading_trn[$n]->performa_per == "PCS")
												// {
													 
													// $pcs =  $loading_trn[$n]->origanal_boxes * $loading_trn[$n]->pcs_per_box;
													// $product_rate = $loading_trn[$n]->product_amt/$pcs;
												// }
												// else if($loading_trn[$n]->per == "SQF")
												// {
													// $feet =  $loading_trn[$n]->origanal_boxes * $loading_trn[$n]->feet_per_box;
													
													// $product_rate = $loading_trn[$n]->product_amt/$feet;
												// }
												// else if($loading_trn[$n]->per == "BOX")
												// {
													// $box =  $loading_trn[$n]->origanal_boxes;
													// $product_rate = $loading_trn[$n]->product_amt/$box;
												// }
												// else if($loading_trn[$n]->per == "SQM")
												// {
													// $sqm =  $loading_trn[$n]->no_of_sqm;
													// $product_rate = $loading_trn[$n]->product_amt/$sqm;
												// }
												// else if($loading_trn[$n]->per == "PCS")
												// {
													 
													// $pcs =  $loading_trn[$n]->origanal_boxes * $loading_trn[$n]->pcs_per_box;
													// $product_rate = $loading_trn[$n]->product_amt/$pcs;
												// }
												
												  
												$qty = '-';
												$no_of_boxes = $loading_trn[$n]->origanal_boxes;
												$no_of_sqm 	= number_format($loading_trn[$n]->origanal_sqm,2,'.','');
												if(empty($loading_trn[$n]->product_id))
												{
															if($loading_trn[$n]->per == "SQF")
															{
																$qty =  $loading_trn[$n]->origanal_boxes;
															}
															else if($loading_trn[$n]->per == "BOX")
															{
																$qty =  $loading_trn[$n]->origanal_boxes;
															}
															else if($loading_trn[$n]->per == "SQM")
															{
																$qty =  $loading_trn[$n]->origanal_sqm;
														 	}
															else if($loading_trn[$n]->per == "PCS")
															{
																$qty =  $loading_trn[$n]->origanal_boxes;
																 
															} 	
															$Total_qty += $qty;
															$product_rate =  $loading_trn[$n]->product_rate;
													$no_of_boxes = '-';
													$no_of_sqm = '-';
												}  
												//$product_rate = !empty($loading_trn[$n]->custproductrate)?$loading_trn[$n]->custproductrate:$product_rate; 												$product_rate = $loading_trn[$n]->product_rate;
												
												 $description_goods = '';
												 $hsnc_code = '';
												if($loading_trn[$n]->show_cust == 1)
												{
													$description_goods = $loading_trn[$n]->cust_product_name;
												}
												else
												{
													$description_goods = $loading_trn[$n]->series_name;
												}
												if($loading_trn[$n]->show_cust == 1)
												{
													$hsnc_code = $loading_trn[$n]->cust_hsncode;
												}
												else
												{
													$hsnc_code = $loading_trn[$n]->hsnc_code;
												}
												
												$description_goods = !empty($loading_trn[$n]->custdescriptiongoods)?$loading_trn[$n]->custdescriptiongoods:$description_goods;
												
												$hsnc_code = !empty($loading_trn[$n]->custhsnccode)?$loading_trn[$n]->custhsnccode:$hsnc_code;
											 
												$product_amt = !empty($loading_trn[$n]->custproductamt)?$loading_trn[$n]->custproductamt:$loading_trn[$n]->product_amt; 
												
											?>
												<tr>
													<td style="text-align:center"><?=$no?></td>
												<?php 
												if(empty($loading_trn[$n]->product_id))
												{
												?>
													<td colspan="3" style="text-align:center">
														 
														<input id="cust_description_goods<?=$loading_trn[$n]->export_loading_trn_id?>" type="text" step="any" name="cust_description_goods[]" placeholder="Description Goods" class="form-control" value="<?=$loading_trn[$n]->description_goods?>" /> 
													</td>
													 
												<?php
												}
												else
												{
												?>
													<td style="text-align:center">
														<?=$loading_trn[$n]->size_type_mm?> 
													</td>
													<td style="text-align:center">
														<input id="cust_description_goods<?=$loading_trn[$n]->export_loading_trn_id?>" type="text" step="any" name="cust_description_goods[]" placeholder="Description Goods" class="form-control" value="<?=$description_goods?>" /> 
														
													</td>
													<td style="text-align:center">
														  <?=!empty($loading_trn[$n]->client_name)?$loading_trn[$n]->client_name:$loading_trn[$n]->model_name?> 
													</td>
												<?php
												}
												 
												?>	 
													<td style="text-align:center">
														

														<input id="hsnc_code<?=$loading_trn[$n]->export_loading_trn_id?>" type="text" step="any" name="hsnc_code[]" placeholder="Hsnc Code" class="form-control" value="<?=$hsnc_code?>" /> 
														
														<input id="exportproduct_trn_id<?=$loading_trn[$n]->export_loading_trn_id?>" type="hidden" name="exportproduct_trn_id[]"  value="<?=$loading_trn[$n]->exportproduct_trn_id?>" /> 
														
														<input id="export_loading_trn_id" type="hidden" name="export_loading_trn_id[]"  value="<?=$loading_trn[$n]->export_loading_trn_id?>" /> 
														
														<input id="no_of_sqm<?=$loading_trn[$n]->export_loading_trn_id?>" type="hidden" name="no_of_sqm[]"  value="<?=$no_of_sqm?>" /> 
														
														<input id="no_of_boxes<?=$loading_trn[$n]->export_loading_trn_id?>" type="hidden" name="no_of_boxes[]"  value="<?=$no_of_boxes?>" /> 
														<input id="qty<?=$loading_trn[$n]->export_loading_trn_id?>" type="hidden" name="qty[]"  value="<?=$qty?>" /> 
														
														<input id="feet_per_box<?=$loading_trn[$n]->export_loading_trn_id?>" type="hidden" name="feet_per_box[]"  value="<?=$loading_trn[$n]->feet_per_box?>" /> 
														
														<input id="pcs_per_box<?=$loading_trn[$n]->export_loading_trn_id?>" type="hidden" name="pcs_per_box[]"  value="<?=$loading_trn[$n]->pcs_per_box?>" /> 
														
													</td>
													
													<td style="text-align:center">
														<?=$no_of_sqm?>
														
													</td>
													<td style="text-align:center">
														<?=$no_of_boxes?> 
												 	</td>
													<td style="text-align:center">
														<?=$qty?>
													</td>
													<td style="text-align:center">
														<?=$loading_trn[$n]->performa_per?>
													</td>
													 
													<td style="text-align:center">
														<span style="width:15%;float:left">
															<?=$currency_symbol?>
														</span>
														<span  style="width:85%;float:left">
															<input id="cust_product_rate<?=$loading_trn[$n]->export_loading_trn_id?>" type="text" step="any" name="cust_product_rate[]" placeholder="Product Rate" class="form-control" value="<?=number_format($product_rate,2)?>" onchange="calc_amt(<?=$loading_trn[$n]->export_loading_trn_id?>,'<?=!empty($loading_trn[$n]->performa_per)?$loading_trn[$n]->performa_per:$loading_trn[$n]->per?>')"  onkeyup="calc_amt(<?=$loading_trn[$n]->export_loading_trn_id?>,'<?=!empty($loading_trn[$n]->performa_per)?$loading_trn[$n]->performa_per:$loading_trn[$n]->per?>')" onblur="calc_amt(<?=$loading_trn[$n]->export_loading_trn_id?>,'<?=!empty($loading_trn[$n]->performa_per)?$loading_trn[$n]->performa_per:$loading_trn[$n]->per?>')"/> 
														 </span>
													</td>
												 
													<td style="text-align:right">
													<span style="width:15%;float:left">
															<?=$currency_symbol?>
														</span>
														<span  style="width:85%;float:left">
															<input id="cust_product_amt<?=$loading_trn[$n]->export_loading_trn_id?>" type="text" step="any" name="cust_product_amt[]" placeholder="Product Amt" class="form-control" value="<?=number_format($product_amt,2,'.','')?>"  readonly /> 
														 </span>
														  
													</td>
												</tr>
										 	<?php 
												$Total_sqm 		+= $no_of_sqm;
												$Total_box 		+= $no_of_boxes;
												$Total_amount	+= $loading_trn[$n]->product_amt;
											$no++;
											}
											if(count($sample_data)!=0)
											{	
											
											?>
											<tr>
															<td style="text-align:center;">&nbsp;</td>
															<td style="font-weight:bold;text-align:center;" colspan="2">Sample</td>
													 		<td style="text-align:center;"></td>
													 		<td style="text-align:center;"></td>
													 		<td style="text-align:center;"></td>
															<td style="text-align:center;"></td>
														 	<td style="text-align:center;"></td>
														 	<td style="text-align:center;"></td>
															<td style="text-align:center;"></td>
															<td style="text-align:center;"></td>
										  </tr>
											<?php
											}	
											 $no_of_row -= 1;
											 $sample=1;
											  
											 
											foreach ($sample_data as $jsondata)
											{
											?>
													<tr>
														<td style="text-align:center;">
															<?=$no?>
															<?php 
															if($jsondata->commercial_status == 0)
															{
															?>
														<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Remove From Customer Invoice"  onclick="delete_record(<?=$jsondata->export_sampletrn_id?>,1)" href="javascript:;" ><i class="fa fa-trash"></i></a>
														<?php 
															}
															else
															{
																?>
																	<a class="tooltips btn btn-defualt" data-toggle="tooltip" data-title="Add From Customer Invoice"  onclick="delete_record(<?=$jsondata->export_sampletrn_id?>,0)" href="javascript:;" ><i class="fa fa-trash"></i></a>
																<?php
															}
															?>
														</td>
														 
														<td style="text-align:center;">
															<?=$jsondata->product_size_id?> </td>
														<td colspan="2" style="text-align:center;">
															<?=$jsondata->sample_remarks?>
														</td>
													 	<td  style="text-align:center;" > - </td>
													 	<td  style="text-align:center;" > <?=$jsondata->sqm?> </td>
													 	<td  style="text-align:center;"><?=$jsondata->no_of_boxes?></td>
													 	<td  style="text-align:center;"></td>
													 	<td  style="text-align:center;"></td>
													 	<td  style="text-align:center;">
															<?=!empty($jsondata->sample_rate)?$currency_symbol.$jsondata->sample_rate:"FOC"?>
														</td>
														<td  style="text-align:center;">
															<?=!empty($jsondata->sample_amout)?$currency_symbol.$jsondata->sample_amout:"FOC"?>
														</td>
														
													</tr>
													
												<?php
												$no++;
												$no_of_row -= 1;	 
												 $Total_sqm 	+= $jsondata->sqm;
												 $Total_box 	+= $jsondata->no_of_boxes;
												 $Total_amount	+= $jsondata->sample_amout;
											}	
											?>
											 
														<tr>
															<th colspan="3" style="text-align:right"></th>
															<th></th>
															<th style="text-align:right">Total </th>
															<th style="text-align:center"><?=$Total_sqm; ?></th>
															<th style="text-align:center"><?=$Total_box; ?></th>
															<th style="text-align:center"><?=$Total_qty; ?></th>
															<th style="text-align:right" colspan="2">
															<?=($invoicedata->calculation_operator == 2)?"FOB":$invoicedata->terms_name?>
															  Value
															
																<?=($invoicedata->calculation_operator == 2)?"-":'+'?>
															</th>
															<th colspan="2" style="text-align:right" ><?=$currency_symbol?>
																<span class="total_html"> 
																<?=number_format($Total_amount,2); ?>
																</span>
																</th>
															 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_amount?>" class="form-control"/>															 
															 
														</tr>
														<?php
														if($invoicedata->terms_id == 1)		
														{
														?>	
														<tr>
															<th colspan="6"  style="vertical-align:top">
																Rex Detail <input type="checkbox" name="rex_detail_status" id="rex_detail_status" value="1" onclick="show_rex(this.checked)" <?=$rex_status?> />
																 <br>
																 <span class="rex_html" style="display:none">
																 <input type="text" name="rex_no" id="rex_no" value="<?=$rex_no?>" class="form-control" />
																 <br>
																 <textarea tabindex="8" style="height:50px" class="form-control" name="rex_no_detail" id="rex_no_detail" Placeholder="Rex Detail"><?=$rex_no_detail?></textarea>
																</span>
															</th> 
															
															<th colspan="3">Certification Charges</th>
															<th colspan="2">
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															 
															<?php ($invoicedata->calculation_operator == 2)? $Total_amount -= $invoicedata->certification_charge: $Total_amount += $invoicedata->certification_charge; ?> 
														</tr>
														 
														 
														<?php 
														}
														else if($invoicedata->terms_id == 2)
														{
														?>
															<tr>
															<th colspan="6" rowspan="2" style="vertical-align:top">
																    Rex Detail <input type="checkbox" name="rex_detail_status" id="rex_detail_status" value="1" onclick="show_rex(this.checked)" <?=($invoicedata->rex_detail_status == 1)?"checked":""?>  />
																 <br>
																 <span class="rex_html" style="display:none">
																 <input type="text" name="rex_no" id="rex_no" value="<?=$rex_no?>" class="form-control" />
																 <br>
																 <textarea tabindex="8" style="height:50px" class="form-control" name="rex_no_detail" id="rex_no_detail" Placeholder="Rex Detail"><?=$rex_no_detail?></textarea>
																</span>
															</th> 
															
															<th colspan="3">Certification Charges</th>
															<th colspan="2">
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															 
															<?php ($invoicedata->calculation_operator == 2)? $Total_amount -= $invoicedata->certification_charge: $Total_amount += $invoicedata->certification_charge; ?> 
														</tr>
													 
														<tr>
														 
															<th colspan="3">Seafreight Charges</th>
															<th colspan="2">
																<input id="seafright_charge" type="text" step="any" name="seafright_charge" tabindex="3" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
															</th>
															 
														</tr>
													
														<?php 
														($invoicedata->calculation_operator == 2)? $Total_amount -= $invoicedata->seafright_charge: $Total_amount += $invoicedata->seafright_charge; 
														}
														else if($invoicedata->terms_id == 3)
														{
														?> 
															<tr>
															<th colspan="6" rowspan="3" style="vertical-align:top">
																 Rex Detail <input type="checkbox" name="rex_detail_status" id="rex_detail_status" value="1" onclick="show_rex(this.checked)"  <?=($invoicedata->rex_detail_status == 1)?"checked":""?> />
																 <br>
																 <span class="rex_html" style="display:none">
																 <input type="text" name="rex_no" id="rex_no" value="<?=$rex_no?>" class="form-control" />
																 <br>
																 <textarea tabindex="8" style="height:50px" class="form-control" name="rex_no_detail" id="rex_no_detail" Placeholder="Rex Detail"><?=$rex_no_detail?></textarea>
																</span>
																 
															</th> 
															
															<th colspan="3">Certification Charges</th>
															<th colspan="2">
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															 
															<?php ($invoicedata->calculation_operator == 2)? $Total_amount -= $invoicedata->certification_charge: $Total_amount += $invoicedata->certification_charge; ?> 
															
															
														</tr>
														<tr>
														 	<th colspan="3">Insurance Charges</th>
															<th colspan="2">
																<input id="insurance_charge" type="text" step="any" name="insurance_charge" tabindex="2" placeholder="INSURANCE CHARGES" value="<?=$invoicedata->insurance_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
															</th>
															  
															 <?php ($invoicedata->calculation_operator == 2)? $Total_amount -= $invoicedata->insurance_charge: $Total_amount += $invoicedata->insurance_charge; ?> 
														</tr>
														<tr>
														 
															<th colspan="3">Seafreight Charges</th>
															<th colspan="2">
																<input id="seafright_charge" type="text" step="any" name="seafright_charge" tabindex="3" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
															</th>
															 
														</tr>
													
														<?php 
														($invoicedata->calculation_operator == 2)? $Total_amount -= $invoicedata->seafright_charge: $Total_amount += $invoicedata->seafright_charge;
														}
														?>
														<tr>
														<td colspan="6"  style="vertical-align:top">
														 </td> 
														 	<th colspan="2">
																<input id="extra_calc_name" tabindex="4" type="text" step="any" name="extra_calc_name" placeholder="Extra Calc. fields" class="form-control" value="<?=$invoicedata->extra_calc_name?>"  />
																  
															</th>
															<th>
																 
																  <select name="extra_calc_opt" tabindex="4" id="extra_calc_opt" onchange="invoice_cal()">
																	<option value="1" <?=($invoicedata->extra_calc_opt == 1)?"Selected='selected'":''?>>+</option>
																	<option value="2" <?=($invoicedata->extra_calc_opt == 2)?"Selected='selected'":''?>>-</option>
															</select>
															</th>
															<th colspan="2">
																<input id="extra_calc_amt" tabindex="4" type="text" step="any" name="extra_calc_amt" placeholder="Amount" class="form-control" value="<?=$invoicedata->extra_calc_amt?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Discount"   />
															</th>
															  
															  <?php   $Total_amount =($invoicedata->extra_calc_opt == 2)?$Total_amount + $invoicedata->extra_calc_amt:$Total_amount + $invoicedata->extra_calc_amt; 
											  ?> 
														</tr>
														<tr>
														<td colspan="6"  style="vertical-align:top">
														 </td> 
														 	<th colspan="3">BANK CHARGES</th>
															<th colspan="2">
																<input id="bank_charge" tabindex="4" type="text" step="any" name="bank_charge" placeholder="BANK CHARGES" class="form-control" value="<?=$invoicedata->bank_charge?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter BANK CHARGES"   />
																 
															</th>
															  
															  <?php  $Total_amount -= $invoicedata->discount; ?> 
														</tr>
														<tr>
														<td colspan="6"  style="vertical-align:top">
														 </td> 
														 	<th colspan="3">COURIER CHARGES</th>
															<th colspan="2">
																<input id="courier_charge" tabindex="4" type="text" step="any" name="courier_charge" placeholder="COURIER CHARGES" class="form-control" value="<?=$invoicedata->courier_charge?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter COURIER CHARGES"   />
																 
															</th>
															  
															  <?php  $Total_amount -= $invoicedata->discount; ?> 
														</tr>
														<tr>
														<td colspan="6"  style="vertical-align:top">
														 </td> 
														 	<th colspan="3">Discount</th>
															<th colspan="2">
																<input id="discount" tabindex="4" type="text" step="any" name="discount" placeholder="DISCOUNT" class="form-control" value="<?=$invoicedata->discount?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Discount"  max="<?=$Total_amount?>"/>
																<span id="discount_error"></span>
															</th>
															  
															  <?php  $Total_amount -= $invoicedata->discount; ?> 
														</tr>
														<tr>
															<td colspan="6"  style="vertical-align:top">
																 
															</td>
															<th colspan="3"> Total Invoice Value</th>
															<th colspan="2">
																<?=$currency_symbol?>  <span id="final_total"> <?=number_format($Total_amount,2,'.','')?></span>
																<input id="final_total_val" type="hidden" name="final_total_val"  value="<?=number_format($Total_amount,2,'.','')?>" />
															</th>
															   
														</tr>
													 	<tr>
															
														<th colspan="11"  style="vertical-align:top">
																 
																  Remarks
																 <textarea tabindex="8" style="height:50px" class="form-control" name="remarks" id="remarks" Placeholder="Remarks"><?=$remarks?></textarea>
															</th>
															   	 
														</tr>
											 		
													</tbody>
												</table>										
											
											 
											</div>
											
										</div>
					
								</div>
								</div>
								<div style="padding: 14px;padding-left:0px;">
									<button  tabindex="12" class="btn btn-success" onclick="check_product(<?=$invoicedata->step?>);">Save & Next</button>
									<a href="<?=base_url().'create_customer_invoice/invoice_edit/'.$invoicedata->customer_invoice_id?>" class="btn btn-danger">
											Back
									</a>
									<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
									<input type="hidden" id="make_container_array" name="make_container_array" value="0"> 
									<input type="hidden" id="no_of_row" name="no_of_row" value=""> 
									<input type="hidden" id="customer_invoice_id" name="customer_invoice_id" value="<?=$invoicedata->customer_invoice_id?>"> 
									<input type="hidden" id="calculation_operator" name="calculation_operator" value="<?=$invoicedata->calculation_operator?>"> 
									<div class="errormsg" style="color:red"></div>
								</div>
							 </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
		 
 <?php $this->view('lib/footer');   ?>
<script>
function delete_record(export_sampletrn_id,commercial_status)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, change it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'cutomerinvoiceproduct/delete_from_commercial',
              data: {
                "export_sampletrn_id" : export_sampletrn_id,
				"commercial_status"	  : commercial_status				
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Status Successfully Changed");
					setTimeout(function(){ location.reload(); },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function show_rex(val)
{
	 
	if(val == true)
	{
		$(".rex_html").show();
	}
	else
	{
		$(".rex_html").hide();
	}
}
function filterbystatus(val)
{
	if(val==1)
	{
		$(".withouthtml").show();
		$(".withhtml").hide();
	}
	else
	{
		$(".withouthtml").hide();
		$(".withhtml").show();
	}
}
function open_modal()
{
	$("#proformaproduct_modal").modal({
		backdrop: 'static',
		keyboard: false
	});
}
 

</script>

<script>

 
$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
 function calc_amt(val,unit)
 {
	
	 if(unit == "SQM")
	 {
		if($("#no_of_sqm"+val).val() > 0)
		{
			var product_amt = parseFloat($("#no_of_sqm"+val).val()) * parseFloat($("#cust_product_rate"+val).val());
			$("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
		else
		{
			var product_amt = parseFloat($("#qty"+val).val()) * parseFloat($("#cust_product_rate"+val).val());
			$("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
	 }
	 else  if(unit == "BOX")
	 {
		 if($("#no_of_boxes"+val).val() > 0)
		{
		 var product_amt = parseFloat($("#no_of_boxes"+val).val()) * parseFloat($("#cust_product_rate"+val).val());
		$("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
		else
		{
			var product_amt = parseFloat($("#qty"+val).val()) * parseFloat($("#cust_product_rate"+val).val());
			$("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
	 }
	  else  if(unit == "SQF")
	 {
		  if($("#no_of_boxes"+val).val() > 0)
		{
		 var feet_per_box  = parseFloat($("#no_of_boxes"+val).val()) * parseFloat($("#feet_per_box"+val).val())
		 var product_amt =  parseFloat(feet_per_box) * parseFloat($("#cust_product_rate"+val).val());
		$("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
		else
		{
			var product_amt = parseFloat($("#qty"+val).val()) * parseFloat($("#cust_product_rate"+val).val());
			$("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
	 }
	  else  if(unit == "PCS")
	 {
		  if($("#no_of_boxes"+val).val() > 0)
		{
		 var pcs_per_box  = parseFloat($("#no_of_boxes"+val).val()) * parseFloat($("#pcs_per_box"+val).val())
		 var product_amt =  parseFloat(pcs_per_box) * parseFloat($("#cust_product_rate"+val).val());
		 $("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
		else
		{
			var product_amt = parseFloat($("#qty"+val).val()) * parseFloat($("#cust_product_rate"+val).val());
			$("#cust_product_amt"+val).val(product_amt.toFixed(2));
		}
	 }
	 calc_total()
 }
// calc_total();
function calc_total() {
	var total = 0;

	// Safely loop through all product amount inputs
	$('input[name="cust_product_amt[]"]').each(function(index) {
		let val = parseFloat($(this).val());

		// Debug log to verify values (you can remove this in production)
		console.log(`Value ${index}:`, $(this).val(), 'Parsed:', val);

		if (!isNaN(val) && $(this).val().trim() !== '') {
			total += val;
		}
	});

	// Update the total value in the DOM
	$(".total_html").html(total.toFixed(2));
	$("#total_amount").val(total.toFixed(2));

	// Recalculate other fields
	invoice_cal();
}

function invoice_cal() 
{
	var total_amount 		 = $('#total_amount').val();
	var certification_charge = ($('#certification_charge').val()=="" || $('#certification_charge').val()== undefined)?0:$('#certification_charge').val();
    var insurance_charge 	 = ($('#insurance_charge').val()=="" || $('#insurance_charge').val()== undefined)?0:$('#insurance_charge').val();
    var seafright_charge 	 = ($('#seafright_charge').val()=="" || $('#seafright_charge').val()== undefined)?0:$('#seafright_charge').val();
    var discount 			 = ($('#discount').val()=="" || $('#discount').val()== undefined)?0:$('#discount').val();
	 var extra_calc_amt = ($('#extra_calc_amt').val()=="" || $('#extra_calc_amt').val()== undefined)?0:$('#extra_calc_amt').val();
	var extra_calc_opt =   $("#extra_calc_opt").val()
	var calculation_operator =   $("#calculation_operator").val()
	
	
	if(extra_calc_opt == 1)
	{
		total_amount = parseFloat(total_amount) + parseFloat(extra_calc_amt);
	}
	else
	{
		total_amount = parseFloat(total_amount) -  parseFloat(extra_calc_amt);		
	}
	if(calculation_operator == 1)
	{
		var final_total = parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge)  - parseFloat(discount);
	 	final_total += parseFloat(seafright_charge); 
		$("#terms_first_name").html('FOB');
		$("#terms_last_name").html('<?=$invoicedata->terms_name?> Values');
	}
	else{ 
		var final_total = parseFloat(total_amount) - parseFloat(certification_charge) - parseFloat(insurance_charge)  - parseFloat(discount);
		$("#terms_first_name").html('<?=$invoicedata->terms_name?>');
		$("#terms_last_name").html('FOB Values');
		final_total -= parseFloat(seafright_charge); 
	}
	$('#discount_error').html('');
	var courier_charge = ($("#courier_charge").val() > 0)?$("#courier_charge").val():0;
	var bank_charge = ($("#bank_charge").val() > 0)?$("#bank_charge").val():0;
	final_total += parseFloat(courier_charge);
	final_total += parseFloat(bank_charge);
	$('#final_total').html(final_total.toFixed(2));
	$('#final_total_val').val(final_total.toFixed(2));
	var exchangerate = 0;
	if($("#Exchange_Rate_val").val()>0)
	{
		exchangerate = $("#Exchange_Rate_val").val();
	}
	var india_ruppe = parseFloat(exchangerate) * parseFloat(final_total.toFixed(2));
	$("#indian_ruppe_html").html(india_ruppe.toFixed(2));
	$("#indian_ruppe_val").val(india_ruppe.toFixed(2))
	var gst = india_ruppe*18/100;
	 
	$("#aftergst_indian_ruppe_html").html(gst.toFixed(2))
	$("#aftergst_indian_ruppe").val(parseFloat(gst.toFixed(2)))
}         
  
</script>
<?php 

if($rex_status == "checked")
{
	echo "<script>show_rex(true)</script>";
}
?>
<script>
function check_product(step)
{
	update_calc(step);
 
}
function add_product(no)
{
	 block_page();
    $.ajax({ 
             type: "POST", 
             url: root+"cutomerinvoiceproduct/addproduct",
             data: 
			 {
				"size_type_mm"			: $("#size_type_mm"+no).val(),
				"description"			: $("#description_goods"+no).val(),
				"hsnc_code"				: $("#hsnc_code"+no).val(),
				"qty_sqm"				: $("#SQM"+no).val(),
				"qty_boxes"				: $("#Boxes"+no).val(),
				"batch_no"				: $("#batch_no"+no).val(),
				"unit"					: $("#Per"+no).val(),
			 	"rate" 					: $("#Rate_In_USD"+no).val(),
			 	"exportproduct_trn_id" 	: no,	 
			 	"customer_invoice_id" 	: $("#customer_invoice_id").val(),	 
			 	"amount" 				: $("#amount"+no).val()
			}, 
			success: function (response) { 
				unblock_page("success","Sucessfully Added"); 
				setTimeout(function(){ location.reload();},1000);
			}
             
         });
}
function update_product_record(customer_invoice_trn_id,no)
{
	 block_page();
    $.ajax({ 
             type: "POST", 
             url: root+"cutomerinvoiceproduct/addproduct",
             data: 
			 {
				"size_type_mm"				: $("#size_type_mm"+no).val(),
				"description"				: $("#description_goods"+no).val(),
				"hsnc_code"					: $("#hsnc_code"+no).val(),
				"qty_sqm"					: $("#SQM"+no).val(),
				"qty_boxes"					: $("#Boxes"+no).val(),
				"batch_no"					: $("#batch_no"+no).val(),
				"unit"						: $("#Per"+no).val(),
			 	"rate" 						: $("#Rate_In_USD"+no).val(),
			 	"exportproduct_trn_id" 		: no,	 
			 	"customer_invoice_id" 		: $("#customer_invoice_id").val(),	 
			 	"amount" 					: $("#amount"+no).val(),
				"customer_invoice_trn_id" 	:customer_invoice_trn_id
			}, 
			success: function (response) { 
				unblock_page("success","Sucessfully Updated"); 
				setTimeout(function(){ location.reload();},1000);
			}
             
         });
}

function updateinvoice(invoice_id)
{
	 block_page();
        $.ajax({ 
              type: "POST", 
              url:  root+"exportinvoiceproduct/updateinvoice",
              data: {
                "invoice_id": invoice_id
				}, 
              cache: false, 
              success: function (data) { 
				 unblock_page("","");
			 }
	});
}
</script>
<script>
function check_pallet_status(val,currency)
{
	 if(val==1)
	 {
	 	$(".multi_pallet_calcution").hide();
		$(".boxes_calculation").hide();
	 	$(".pallet_calcution").show();
	 	 
	 }
	 else if(val==2)
	 {
	 	$(".pallet_calcution").hide();
	 	$(".multi_pallet_calcution").hide();
	 	$(".boxes_calculation").show();
		 
	}
	else if(val == 3)
	{
		$(".pallet_calcution").hide();
	 	$(".boxes_calculation").hide();
	 	$(".multi_pallet_calcution").show();
		 
	}
	
	// cal_product_invoice(currency)
	  cal_product_boxes()
 }
function change_container()
{
	if($('#container_check').prop("checked") == true)
	{
		$("#total_container").attr("readonly",false);
		if($("#total_container").val()==0.5)
		{
			$("#total_container").val(1);
			$("#total_container").show();
		}
			var total_container = $("#total_container").val();
			var total_boxes = $("#total_boxes").val();
			var Plts = $('#boxes_per_pallet').val();
			total_pallet = $('#pallet_in_container').val() * total_container;
			total_big_pallet = $('#big_pallet_in_container').val() * total_container;
			total_small_pallet = $('#small_pallet_in_container').val() * total_container;
			total_boxes = total_boxes * total_container;
		 	$("#Plts").val(Plts);
			$("#total_pallet").val(total_pallet);
			$("#total_big_pallet").val(total_big_pallet);
			$("#total_small_pallet").val(total_small_pallet);
			cal_product_invoice('<?=$invoicedata->currency?>');
		
	}
	else	
	{
		$("#total_container").attr("readonly",true);
		$("#total_container").val(0.5);
		$("#total_container").hide();
			var total_container = 0;
			var total_boxes = 0;
		 	total_boxes = 0;
		 
			$("#total_boxes").val(total_boxes);
			$('#defualt_Boxes').val(total_boxes)
			cal_product_invoice('<?=$invoicedata->currency?>');
	} 
	 
}
 </script>
<script>
$(".select2").select2({
	width:'100%'
});
 
  $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 function update_calc(step)
{
	 block_page();
	 var exportproduct_trn_id 	= [];
	 var export_loading_trn_id 	= [];
	 var hsnc_code 				= [];
	 var cust_description_goods = [];
	 var cust_product_rate 		= [];
	 var cust_product_amt 		= [];
	 var art_no 				= [];
	 var type 					= [];
	 
	 $('input[name="export_loading_trn_id[]"]').each(function() {
             export_loading_trn_id.push($(this).val());
             exportproduct_trn_id.push($(this).val());
             hsnc_code.push($("#hsnc_code"+$(this).val()).val());
             cust_description_goods.push($("#cust_description_goods"+$(this).val()).val());
             cust_product_rate.push($("#cust_product_rate"+$(this).val()).val());
             cust_product_amt.push($("#cust_product_amt"+$(this).val()).val());
             art_no.push($("#art_no"+$(this).val()).val());
             type.push($("#type"+$(this).val()).val());
    });
	  console.log(hsnc_code)
    $.ajax({ 
             type: "POST", 
             url: root+"cutomerinvoiceproduct/update_customer_invoice",
             data: 
			 {
				"customer_invoice_id"	: $("#customer_invoice_id").val(),
				"certification_charge"	: $("#certification_charge").val(),
				"insurance_charge"		: $("#insurance_charge").val(),
				"seafright_charge"		: $("#seafright_charge").val(),
				"seafright_action"		: $("#seafright_action").val(),
				"discount"				: $("#discount").val(),
				"before_grand_total"			: $("#total_amount").val(),
				"grand_total"			: $("#final_total_val").val(),
			 	"remarks" 				: $("#remarks").val(),
			 	"rex_detail_status" 	: $('#rex_detail_status').is(":checked") ? 1 : 0,
			 	"rex_no_detail" 		: $("#rex_no_detail").val(),
			 	"rex_no" 				: $("#rex_no").val(),
			 	"hsnc_code"				: hsnc_code,
			 	"cust_description_goods": cust_description_goods,
			 	"cust_product_rate"		: cust_product_rate,
			 	"cust_product_amt"		: cust_product_amt,
			 	"art_no"				: art_no,
				"extra_calc_name" 		: $("#extra_calc_name").val(),
				"extra_calc_amt" 		: $("#extra_calc_amt").val(),
				"extra_calc_opt" 		: $("#extra_calc_opt").val(),
			 	"type"					: type,
			 	"export_loading_trn_id"	: export_loading_trn_id,
			 	"exportproduct_trn_id"	: exportproduct_trn_id,
			 	"step"					: step
			}, 
			success: function (response) { 
				unblock_page("success","Sucessfully Updated.");
				setTimeout(function(){ window.location='<?=base_url()?>customerinvoicepacking/index/<?=$invoicedata->customer_invoice_id?>'; },1500);
			}
             
         }); 
}
  
 
 
</script>
