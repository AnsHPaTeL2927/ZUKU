<?php 
 $export_date 				= date('d-m-Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no 			= $invoicedata->export_invoice_no;
 $export 					= ($invoicedata->exporter_detail);
 $export_ref_no 			= ($invoicedata->export_ref_no);
 $performa_date 			= date('d-m-Y',strtotime($invoicedata->performa_date));
 $buy_order_no 				= strip_tags($invoicedata->export_buy_order_no);
 $exporter_email 			= $invoicedata->e_email;
 $exporter_mobile 			= $invoicedata->e_mobile;
 $exporter_gstin 			= $invoicedata->e_gstin;
 $exporter_pan 				= $invoicedata->exporter_pan;
 $exporter_iec 				= $invoicedata->exporter_iec;
 $consign_name 				= $invoicedata->c_name;
 $consign_address 			= ($invoicedata->consign_address);
 $buyer_other_consign 		= ($invoicedata->buyer_other_consign);	
 $pre_carriage_by			= $invoicedata->pre_carriage_by;
 $place_of_receipt			= $invoicedata->place_of_receipt;
 $country_origin_goods 		= $invoicedata->country_origin_goods;
 $country_final_destination = $invoicedata->country_final_destination;
 $bank_detail 				= $invoicedata->bank_detail;    
 $flight_name_no			= $invoicedata->flight_name_no;   				 
 $export_port_loading 		= $invoicedata->port_of_loading;
 $port_of_discharge 		=  $invoicedata->port_of_discharge;
 $final_destination 		=  $invoicedata->final_destination;
 $export_payment_terms 		= $invoicedata->payment_terms;
 $no_of_container 			= $invoicedata->container_details;
 $export_terms_of_delivery 	= $invoicedata->terms_of_delivery;
 
 if($invoicedata->Exchange_Rate_val==0)
 {
	 $exchangerate = 0;
	 
	 if($invoicedata->currency_code=="USD")
	 {
		  $exchangerate = $userdata->usd;
	 }
	 else if($invoicedata->currency_code=="EUR")
	 {
		 $exchangerate = $userdata->euro;
	 }
	 else if($invoicedata->currency_code=="GBP")
	 {
		 $exchangerate = $userdata->gbp;
	 }
	 
 }
 else
 {
	 $exchangerate = $invoicedata->Exchange_Rate_val;
 }
 if(!empty($invoicedata->notification_text))
 {
	 $notification_text = $invoicedata->notification_text;
 }
 else{
	 $notification_text = $userdata->notification_text;
 }
 $locale='en-US'; //browser or user locale
$currency			= $invoicedata->currency_code; 
$fmt 				= new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol 	= $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
 
 $export_under = strip_tags($company_detail[0]->export_under_detail1);
 if(!empty($invoicedata->export_under))
 {
	  $export_under = $invoicedata->export_under;
 }
  $export_under1 =  strip_tags($company_detail[0]->export_under_detail2); 
 if(!empty($invoicedata->export_under1))
 {
	  $export_under1 = $invoicedata->export_under1;
 }
 $remarks =   strip_tags($company_detail[0]->export_remarks);
 if(!empty($invoicedata->remarks))
 {
	 $remarks = $invoicedata->remarks;
 }
 if(!empty($invoicedata->supplier_invoice_date))
 {
 $supplier_invoice_date = date('d-m-Y',strtotime($invoicedata->supplier_invoice_date));
  
 if($invoicedata->supplier_invoice_date == '1970-01-01')
 {
	 $supplier_invoice_date = '';
 }
 if($invoicedata->supplier_invoice_date == '0000-00-00')
 {
	 $supplier_invoice_date = '';
 }
 }
 $company_rules = $invoicedata->companyrules;
  
 if(!empty($invoicedata->company_rules))
 {
	  $company_rules = $invoicedata->company_rules;
 }
 $rex_no_detail = ($invoicedata->rex_detail_status == 1)?$invoicedata->rexnodetail:"";
 if(!empty($invoicedata->rex_no_detail))
 {
	  $rex_no_detail = $invoicedata->rex_no_detail;
 }
 $lut_no =  ($company_detail[0]->s_lutno); 
 if(!empty($invoicedata->lut_no))
 {
	  $lut_no = $invoicedata->lut_no;
 }
 $lut_expiry =  ($company_detail[0]->s_lut_expiry == "" || $company_detail[0]->s_lut_expiry == "0000-00-00" || $company_detail[0]->s_lut_expiry == "1970-01-01")?"":$company_detail[0]->s_lut_expiry; 
 if(!empty($invoicedata->lut_expiry))
 {
	  $lut_expiry = $invoicedata->lut_expiry;
 }
  $invoicevalue_say = $invoicedata->terms_name;
 $aeo_no =  ($company_detail[0]->aeo_no); 
 if(!empty($invoicedata->aeo_no))
 {
	  $aeo_no = $invoicedata->aeo_no;
 }
 $lei_no =  ($company_detail[0]->lei_no); 
 if(!empty($invoicedata->lei_no))
 {
	  $lei_no = $invoicedata->lei_no;
 }
 
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
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
							<h3>Export Invoice Product Entry</h3>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							 <div id="accordion">
							 <h3>
								 Export Invoice Detail
							  </h3>   
								<div class="" style="padding:10px;" >
										<table cellspacing="0" cellpadding="0"    width="100%">
											<tr>
												<td colspan="12"  style="font-weight:bold;vertical-align: bottom;text-align: center;">
													<span class="withouthtml">
													SUPPLY MEANT FOR EXPORT UNDER LUT WITHOUT PAYMENT OF IGST (LUT: <?=$company_detail[0]->s_lutno?>)
												</span>
													<span class="withhtml" style="display:none">
														SUPPLY MEANT FOR EXPORT WITH PAYMENT OF IGST 
													</span>
												</td>
											</tr>
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
												<td width="15%">Export Invoice No</td>
												<td width="15%" colspan="2" style="font-weight:bold">
													<?=$exportinvoice_no?>
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
												<td> PI-DATE</td>
												<td style="font-weight:bold"> 
													<?=$performa_date?>
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
								<div class="">
									<div class="panel-body">
										<div class="pull-left form-group">
										  <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">Add Product </button>-->
										</div>
										<div class="pull-right form-group">
											 
										</div>
											<div class="table-responsive">
												<table class="table table-bordered table-hover"  style="width:100%;">
													<thead>
														<tr>
															<th width="9%" style="text-align:center">Container</th>
															<th width="9%" style="text-align:center">Line Seal</th>
															<th width="9%" style="text-align:center">Self Seal</th>
															<th width="8%" style="text-align:center">Product Detail</th>
															<th width="8%" style="text-align:center">No Of Pallet</th>
															<th width="8%" style="text-align:center">No Of Boxes</th>
															<th width="8%" style="text-align:center">No Of Sqm</th>
															<th width="8%" style="text-align:center">Quantity</th>
															<th width="8%" style="text-align:center">Product Rate</th>
															<th width="8%" style="text-align:center">Unit</th>
															<th width="8%" style="text-align:center">Amount</th>
															<th width="9%" style="text-align:center">Action</th>
													 	</tr>
													</thead>
											<tbody>
											 <?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_qty = 0;
											$Total_ammount = 0;
											$setcontainer = 0;
											$packingtrn_array = array();
											$con_entry = 1;
										 	$con_array = array();
											$conarray = array();
											
											if(!empty($product_data))
											{		
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												for($i=0; $i<count($product_data);$i++)
												{
												
												 
											  	?>
												<tr>
													<?php
												 
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$sample_str = '';	  
														$rowcon_no = ($product_data[$i]->rowcon_no > 1)?$product_data[$i]->rowcon_no:'';
														
															if(empty($sample_str))
															{
															 $rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
															 $sample_container = 1; 
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																		$sample_str .= '<tr>
																						 <td style="text-align:center">
																						 	'.$sample_des.'
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->no_of_pallet.'
																						 </td>
																					 	 <td style="text-align:center">
																						 	'.$sample_row->no_of_boxes.'
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->sqm.'
																						 </td>
																						 <td style="text-align:center">
																						 	 -
																						 </td>
																						 <td style="text-align:center">
																						 	'.$currency_symbol.' '.$sample_row->sample_rate.'
																						 </td>
																						  <td style="text-align:center">
																						 	 '.$sample_row->sample_per.'
																						 </td>
																						 <td style="text-align:right">
																						 	'.$currency_symbol.' '.$sample_row->sample_amout.'
																						 </td>
																						</tr> ';
																		$Total_plts		+= $sample_row->no_of_pallet;
																		$Total_sqm 		+= $sample_row->sqm;
																		$Total_box 		+= $sample_row->no_of_boxes;
																		$Total_ammount 	+= $sample_row->sample_amout;
																 }
																 
															}
														
												 	?>
													 
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->container_no?>
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->seal_no?> 
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														<?=$product_data[$i]->self_seal_no?>
													</td>
													<?php 
														array_push($con_array,$product_data[$i]->con_entry);
														
													}
													else
													{
														$sample_container++;
													}
													if($product_data[$i]->product_id == 0)
													{
														$qty =0;
															if($product_data[$i]->per == "SQM")
															{
																$qty = $product_data[$i]->origanal_sqm;
															}
															else if($product_data[$i]->per == "BOX")
															{
																$qty = $product_data[$i]->origanal_boxes;
																
															}
															else if($product_data[$i]->per == "SQF")
															{
																$qty = $product_data[$i]->origanal_boxes;
															}
															else if($product_data[$i]->per == "PCS")
															{
																$qty = $product_data[$i]->origanal_boxes;
															}
													?>
														<td class="text-center" colspan="4">
															<?=$product_data[$i]->description_goods?>
														</td>  
														<td class="text-center" >
															<?=$qty?>
														</td>
													<?php
													$Total_qty += $qty;
													}
													else
													{
														?>
														<td class="text-center">
													 
														<?=$product_data[$i]->size_type_mm?>
														<br>
														<?=$product_data[$i]->model_name?>
														<br>
														<?=$product_data[$i]->finish_name?>
														</td> 
														<?php
														$no_of_boxes = 0;
													 	if(!empty($product_data[$i]->make_pallet_no))
														{
															if(!empty($product_data[$i]->pallet_ids))
															{
																$pallet_ids = explode(",",$product_data[$i]->pallet_row);
															 
															echo  '<td class="text-center" rowspan="'.count($pallet_ids).'">
																'.$product_data[$i]->make_pallet_no.'     
															</td>';
																$Total_plts += $product_data[$i]->make_pallet_no;
															}
													 	}
														else if(!empty($product_data[$i]->production_mst_id) || empty($product_data[$i]->pallet_row))
														{
																 
													?>
														<td style="text-align:center">
															<?php 
														if($product_data[$i]->origanal_pallet>0)
														{
															$no_of_pallet = $product_data[$i]->origanal_pallet;
														 	echo $no_of_pallet;
															$Total_plts += $no_of_pallet;
									
														}
														else if($product_data[$i]->orginal_no_of_big_pallet>0 || $product_data[$i]->orginal_no_of_small_pallet>0)
														{
															echo $product_data[$i]->orginal_no_of_big_pallet.'<br>';
															echo $product_data[$i]->orginal_no_of_small_pallet;
															$Total_plts += $product_data[$i]->orginal_no_of_big_pallet;
															$Total_plts += $product_data[$i]->orginal_no_of_small_pallet;
														}
														
														?>
															 </td>
															  
													 	
															<?php 
															 
													}
													$no_of_sqm 	= ($packing->product_id == 0)?$product_data[$i]->origanal_sqm:$product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box;
						
													?>
														<td style="text-align:center"><?=$product_data[$i]->origanal_boxes?> </td>
															<td style="text-align:center"><?=number_format($no_of_sqm,2,'.','')?></td>
														<td class="text-center"> - </td>
														<?php
													}
													?>
													
												 
													  
												 	<td style="text-align:center">
														<?=$currency_symbol?> <?=number_format($product_data[$i]->product_rate,2,'.',',')?>
													</td>
													<td style="text-align:center">
														 <?=$product_data[$i]->per?>
													</td>
													<td style="text-align:right">
														<?=$currency_symbol?> <?=number_format($product_data[$i]->product_amt,2,'.',',')?> 
													</td>													 
												 <?php
												 
													if(!in_array($product_data[$i]->con_entry,$conarray))
													{
												 		//$rowcon_no = ($product_data[$i]->rowcon_no > 1)?$product_data[$i]->rowcon_no:'';
													?>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>">
														<a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit Product Detail"  onclick="edit_loading(<?=$product_data[$i]->con_entry?>,<?=$product_data[$i]->export_invoice_id?>)" href="javascript:;" ><i class="fa fa-pencil"></i></a>
														<?php 
														if(empty($sample_str))
														{
														?>
															<a class="btn btn-info tooltips" data-title="Add Sample"  onclick="add_sample_product(<?=$product_data[$i]->export_invoice_id?>,<?=$product_data[$i]->export_loading_trn_id?>,'<?=$product_data[$i]->container_no?>')" href="javascript:;" ><i class="fa fa-plus"></i></a>
														<?php 
														}
														else
														{
															?>
															<a class="btn btn-warning tooltips" data-title="Edit Sample"  onclick="editsample_product(<?=$product_data[$i]->export_loading_trn_id?>)" href="javascript:;" ><i class="fa fa-plus"></i></a>	
															<a class="btn btn-danger tooltips" data-title="Delete Sample"  onclick="deletesample_product(<?=$product_data[$i]->export_loading_trn_id?>)" href="javascript:;" ><i class="fa fa-minus"></i></a>
															<?php
														}
														?>
													  </td>
													   <input type="hidden" name="pi_loading_plan_id[]" id="pi_loading_plan_id<?=$product_data[$i]->pi_loading_plan_id?>" value="<?=$product_data[$i]->pi_loading_plan_id?>" />   
												 	<?php 
														array_push($conarray,$product_data[$i]->con_entry);
													}
													?>
													 <input type="hidden" name="performainvoice_id[]" id="performainvoice_id<?=$product_data[$i]->pi_loading_plan_id?>" value="<?=$invoicedata->performa_invoice_id?>" />   
													 <input type="hidden" name="con_entry[]" id="con_entry<?=$product_data[$i]->pi_loading_plan_id?>" value="<?=$product_data[$i]->con_entry?>" />   
											 	</tr>
										 		<?php
												  
												 
												if($product_data[$i]->rowcon_no == $sample_container) 
												{
													echo $sample_str;
											    }
												$Total_sqm 		+= $product_data[$i]->no_of_sqm;
											    $Total_box 		+= $product_data[$i]->origanal_boxes;
												$Total_ammount 	+= $product_data[$i]->product_amt;
											}
											}
											else
											{
												echo "<tr>
															<td  class='text-center' colspan='14'>Container Not set</td>
													</tr>";
											}
												
												?>
											   <tr>
													<th colspan="4" style="text-align:right">TOTAL</th>
													<th style="text-align:center"><?=$Total_plts; ?></th>
													<th style="text-align:center"><?=$Total_box; ?></th>
													<th style="text-align:center"><?=$Total_sqm; ?></th>
													<th style="text-align:center"><?=$Total_qty; ?></th>
													<th colspan="2" style="text-align:right">
														<span id="terms_first_name">FOB</span> Value 
														<select name="calculation_operator" id="calculation_operator" onchange="invoice_cal()">
																<option value="1" <?=($invoicedata->calculation_operator == 1)?"Selected='selected'":''?>>+</option>
																<option value="2" <?=($invoicedata->calculation_operator == 2)?"Selected='selected'":''?>>-</option>
														</select>
													</th>
													 <th style="text-align:right">
														<?=$currency_symbol?> <?=number_format($Total_ammount,2,'.',','); ?>
													</th>
													 <th> 
														<input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
													 </th>
													</tr>
														<?php
													 $total = $Total_ammount;
														if($invoicedata->terms_id == 1)		
														{
														?>	
														<tr>
															<th colspan="8"  style="vertical-align:top">
																 Export Under
																 <textarea  style="height:50px" class="form-control" name="export_under" tabindex="6" id="export_under"><?=$export_under?></textarea><br>
																 <textarea  style="height:50px" class="form-control" name="export_under1" tabindex="6" id="export_under1"><?=$export_under1?></textarea>
															</th> 
															
															<th colspan="2">Certification Charges</th>
															<th>
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															 <th></th> 
														</tr>
														 
														 
														<?php 
														($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->certification_charge: $Total_ammount += $invoicedata->certification_charge;
														}
														else if($invoicedata->terms_id == 2)
														{
														?>
															<tr>
															<th colspan="8" rowspan="2" style="vertical-align:top">
																 Export Under
																 <textarea  style="height:50px" class="form-control" name="export_under" tabindex="6" id="export_under"><?=$export_under?></textarea><br>
																 <textarea  style="height:50px" class="form-control" name="export_under1" tabindex="6" id="export_under1"><?=$export_under1?></textarea>
															</th> 
															
															<th colspan="2">Certification Charges</th>
															<th>
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															<th></th> 
															 
															<?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->certification_charge: $Total_ammount += $invoicedata->certification_charge; ?> 
														</tr>
													 
														<tr>
														 
															<th colspan="2">Seafreight Charges</th>
															<th>
																<input id="seafright_charge" type="text" step="any" name="seafright_charge" tabindex="3" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
															</th>
															<th></th> 
															 
															<?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->seafright_charge: $Total_ammount += $invoicedata->seafright_charge; ?> 
														</tr>
													
														<?php 
														}
														else if($invoicedata->terms_id == 3)
														{
														?> 
															<tr>
															<th colspan="8" rowspan="3" style="vertical-align:top">
																 Export Under
																 <textarea  style="height:50px" class="form-control" name="export_under" tabindex="6" id="export_under"><?=$export_under?></textarea><br>
																 <textarea  style="height:50px" class="form-control" name="export_under1" tabindex="6" id="export_under1"><?=$export_under1?></textarea>
															</th> 
															
															<th colspan="2">Certification Charges</th>
															<th>
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															<th></th> 
															 
															<?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->certification_charge: $Total_ammount += $invoicedata->certification_charge;?> 
														</tr>
														<tr>
														 	<th colspan="2">Insurance Charges</th>
															<th>
																<input id="insurance_charge" type="text" step="any" name="insurance_charge" tabindex="2" placeholder="INSURANCE CHARGES" value="<?=$invoicedata->insurance_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
															</th>
															<th></th> 
															 
															 <?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->insurance_charge: $Total_ammount += $invoicedata->insurance_charge; ?> 
														</tr>
														<tr>
														 
															<th colspan="2">Seafreight Charges</th>
															<th >
																<input id="seafright_charge" type="text" step="any" name="seafright_charge" tabindex="3" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
																<?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->seafright_charge: $Total_ammount += $invoicedata->seafright_charge; ?> 
															</th>
															<th></th> 
															  
														</tr>
													
														<?php 
														}
														?>
														<tr>
															<td colspan="8" rowspan="4"  style="vertical-align:top">
																PO Agreement
																<textarea  style="height:50px" class="form-control" name="company_rules" tabindex="6" id="company_rules"><?=$company_rules?></textarea><br>
																REX No Detail
																
																 <textarea  style="height:50px" class="form-control" name="rex_no_detail" tabindex="6" id="rex_no_detail"><?=$rex_no_detail?></textarea> 
															 
															</td> 
														 
															<th colspan="2">Courier Charges</th>
															<th>
																<input id="courier_charge" tabindex="4" type="text" step="any" name="cou" placeholder="Courier Charges" class="form-control" value="<?=$invoicedata->courier_charge?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																 
															</th>
															<th></th> 
														 
														</tr>
														<tr>
															<th colspan="2">Bank Charges</th>
															<th>
																<input id="bank_charge" tabindex="4" type="text" step="any" name="bank_charge" placeholder="Bank Charges" class="form-control" value="<?=$invoicedata->bank_charge?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																 
															</th> 
															<th></th> 
															 
														</tr>
														<tr>
															<th >
																<input id="extra_calc_name" tabindex="4" type="text" step="any" name="extra_calc_name" placeholder="Extra Calc. fields" class="form-control" value="<?=$invoicedata->extra_calc_name?>"  />
																  
															</th>
															<th>
																 
																  <select name="extra_calc_opt" tabindex="4" id="extra_calc_opt" onchange="invoice_cal()">
																	<option value="1" <?=($invoicedata->extra_calc_opt == 1)?"Selected='selected'":''?>>+</option>
																	<option value="2" <?=($invoicedata->extra_calc_opt == 2)?"Selected='selected'":''?>>-</option>
															</select>
															</th>
															<th >
																<input id="extra_calc_amt" tabindex="4" type="text" step="any" name="extra_calc_amt" placeholder="Amount" class="form-control" value="<?=$invoicedata->extra_calc_amt?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Extra Calc"   />
																 
															</th>
															<th></th> 
														 
															  <?php  	
															  $Total_ammount =($invoicedata->extra_calc_opt == 2)?$Total_ammount + $invoicedata->extra_calc_amt:$Total_ammount + $invoicedata->extra_calc_amt; 
											  	  
															  ?> 
														</tr> 
														<tr>
															<th colspan="2">Discount</th>
															<th >
																<input id="discount" tabindex="4" type="text" step="any" name="discount" placeholder="DISCOUNT" class="form-control" value="<?=$invoicedata->discount?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Discount"  max="<?=$Total_ammount?>"/>
																<span id="discount_error"></span>
															</th>
															 
															<th></th> 
															  <?php  $Total_ammount -= $invoicedata->discount; ?> 
														</tr>
														<?php  $pi_diffrence = ($invoicedata->pigrandtotal - $invoicedata->piagentgrandtotal)?> 
														<tr>
														<td colspan="8"></td>
															<th colspan="2">Diffrence</th>
															<th >
																<input id="diffrence" tabindex="4" type="text" step="any" name="diffrence" placeholder="Diffrence" class="form-control" value="<?=$pi_diffrence?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Diffrence" max="<?=$Total_ammount?>" />
																
															</th>
															 
															<th></th> 
															 <?php  $Total_ammount -= ($invoicedata->pigrandtotal - $invoicedata->piagentgrandtotal) ?> 
														</tr>
														<tr>
															<td colspan="8" rowspan="2" style="vertical-align:top">
																LUT No
																	<input id="lut_no" type="text" name="lut_no"  value="<?=$lut_no?>" class="form-control" />
																	<br>
																LUT Expiry
																
																 <input id="lut_expiry" type="text" name="lut_expiry"  value="<?=$lut_expiry?>" class="form-control" />
															  
															</td>
															<th colspan="2"> 
																Commision Amount
															</th>
															<th>
																<input id="commision_rate" tabindex="4" type="text" step="any" name="commision_rate" placeholder="Commision Amount" class="form-control" value="<?=$invoicedata->commision_amt?>" onkeypress="return isNumber(event)" title="Enter Commision Amount" />
															</th>
															 <th></th> 
														</tr>
														<tr>
															 
															<th colspan="2"> 
																<span id="terms_last_name"><?=$invoicedata->terms_name?></span>
															</th>
															<th>
																<?=$currency_symbol?>  <span id="final_total"> <?=number_format($Total_ammount,2,'.','')?></span>
																<input id="final_total_val" type="hidden" name="final_total_val"  value="<?=number_format($Total_ammount,2,'.','')?>" />
															</th>
															 <th></th> 
														</tr>
														
														<tr>
														
															<th colspan="8" style="vertical-align:top">
															 AEO No : <input type="text" class="form-control" rows="2"   name="aeo_no" id="aeo_no" placeholder="AEO No" value="<?=$aeo_no?>"/> 
															 
															 LEI NO :  <input type="text" class="form-control" rows="2" name="lei_no" id="lei_no" placeholder="LEI NO" value="<?=$lei_no?>"/> 
															
															</th>  
															<th colspan="2"> Exchange Rate  </th>
															<th>
															 <div style="width:10%;float: left;"> &#x20b9;   </div> 
															 <input  id="Exchange_Rate_val" type="text" name="Exchange_Rate_val" tabindex="5" onkeyup="invoice_cal()" value="<?=$exchangerate?>" style="width:90%" class="form-control"/>  
															</th>
															 <th>
																
																<input  id="notification_text" type="text" name="notification_text" tabindex="5" onkeyup="invoice_cal()" value="<?=$notification_text?>" style="width:90%" /> 
															 </th>  
														</tr>
														<tr>
															
														<th colspan="8" rowspan="2" style="vertical-align:top">
															 	  Remarks
																 <textarea tabindex="8" style="height:50px" class="form-control" name="remarks" id="remarks"><?=$remarks?></textarea>
															</th>
															 															
															<th colspan="2"> Invoice Value INR  </th>
															<th >
															<span style="width:10%;float: left;">  &#x20b9; </span> 
																 
																<input id="indian_ruppe_val" type="text" name="indian_ruppe_val"  value="<?=number_format($total*$exchangerate, 2, '.', '');?>" style="width:90%" />
															</th>
															  <th></th> 
														</tr>
														<tr>
														
															
															<?php
															$indian_ruppe_val = $total*$exchangerate;
															
															$aftergstrate = ($indian_ruppe_val)*18/100;
															 
															?> 															
															<?php
															if($invoicedata->igst_status != 1)		
															{
															?>
															<th colspan="3">GST 18 % </th>
															<th colspan="2">
															<span style="width:10%;float: left;"> &#x20b9; </span> 
																 
																 
																<input id="aftergst_indian_ruppe_val" type="text" name="aftergst_indian_ruppe_val"  value="<?=number_format($aftergstrate, 2, '.', '');?>" style="width:90%" />
															</th>
															<?php
															}
															?>
															 <th></th> 
														</tr>
														 
					 								</tbody>
												</table>										
											
											 
											</div>
											
										</div>
					
								</div>
								</div>
								<div style="padding: 14px;padding-left:0px;">
									<button  tabindex="12" class="btn btn-success" onclick="check_product(<?=$invoicedata->step?>);">Save & Next</button>
									<a href="<?=base_url().'exportinvoice/export_edit/'.$invoicedata->export_invoice_id?>" class="btn btn-danger">
											Back
									</a>
									<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
									<input type="hidden" id="make_container_array" name="make_container_array" value="0"> 
									<input type="hidden" id="gross_weight_array" name="gross_weight_array" value="0"> 
									<input type="hidden" id="net_weight_array" name="net_weight_array" value="0"> 
							
									<input type="hidden" id="no_of_row" name="no_of_row" value=""> 
									<input type="hidden" id="currency_name" name="currency_name" value="<?=$invoicedata->currency_name?>"> 
									<input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"> 
									<div class="errormsg" style="color:red"></div>
								</div>
							 
							</div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
		 
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1100px;">
        <!-- Modal content-->
        <div class="modal-content" style="max-height: 600px;overflow-y: auto;">
		
            <div class="modal-header">
                <button type="button" onclick="close_modal()" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Product  </h4>
			</div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="product_form" id="product_form">
            <div class="modal-body">
                <div class="row">
						<input type="hidden" id="exportinvoice_id" name="exportinvoice_id" value="<?=$invoicedata->export_invoice_id?>"> 
					<div class="col-md-12">					
					   <div class="field-group" >
							<select class="select2" id="product_details" name="product_details" onchange="load_data(this.value,'Add','')">
								<option value="">Select Product Name</option>
								<?php
								for($p=0;$p<count($allproduct);$p++)
								{
									$thickness = (!empty($allproduct[$p]->thickness))?" - ".$allproduct[$p]->thickness." MM":"";
								 ?>
									<option value="<?=$allproduct[$p]->product_id?>"><?=$allproduct[$p]->size_type_mm.' ('.$allproduct[$p]->series_name.')'.$thickness?></option>
								<?php
								}
								?>
							</select>
						</div> 
					</div> 
				    
					<div id="responsecontainer"></div>        
				 </div>  			
				
				</div>
			 
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Add" id="product_submit_btn" class="btn btn-info"  /> 
                <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="exportproduct_trn_id" id="exportproduct_trn_id"/>
			</form>
       
    </div>
</div>
</div>

<div id="proformaproduct_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
	
        
        <div class="modal-content" style="max-height: 600px;overflow-y: auto;">
		
            <div class="modal-header">
                <!--<button type="button" onclick="close_modal()" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title">Copy Container <br> Select Container : <?=$no_of_container?></h4>
				
            </div>
			 <div class="modal-body">
                <div class="row">
						 
				<?php
				 if(empty($product_data[0]->export_invoice_id))
				 {
					 
					?> 
					<center>
						<table class="table table-bordered table-hover" id="sample-table-1" style="width: 95%;"  >
											<thead>
												<tr>
													<th width="5%"> </th>
													<th width="55%">Description od Goods</th>
													<th width="10%">Container</th>
													<th width="10%">Plts</th>
													<th width="10%">Boxes</th>
													<th width="10%">SQM</th>
												</tr>
											</thead>
											<tbody>
											 <?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_ammount = 0;
											$Total_weight = 0;
											$total_container =0;
											$stringcolor=array();	
											$container_order_by=0;
											 $deletestatus = 0;
											 $button_check_array = array();
											$no =1;
											 
											for($i=0; $i<count($product_data);$i++)
											{
												 
												 $Total_plts 	+= $product_data[$i]->total_no_of_pallet;
												 $Total_box 	+= $product_data[$i]->total_no_of_boxes;
												 $Total_sqm 	+= $product_data[$i]->total_no_of_sqm;
												 $Total_ammount += $product_data[$i]->total_product_amt;
												 $Total_weight  += $product_data[$i]->total_gross_weight;
												 $n = 1;
												 
											  foreach($product_data[$i]->packing  as $packing_row)
											  {
												    $description_goods =  $product_data[$i]->description_goods;
													if(!empty($packing_row->model_name))
													{
														$description_goods .=  ' - '.$packing_row->model_name;
													}
													if(!empty($packing_row->client_name))
													{
														$description_goods .= '('.$packing_row->client_name.')';
													}
													if(!empty($packing_row->finish_name))
													{
														$description_goods .= ' - '.$packing_row->finish_name;
													}
												 $deletestatus = 0;
												 if($product_data[$i]->product_container == 0)
														{
															$checkedcontainer='';
															$explodeproduct=array();
															$string='';
															$disabled = '';
														 	for($a=0;$a<count($container_data);$a++)
															{
																if(!in_array($container_data[$a]->allproduct_id,$explodeproduct))
																{
																	$string .= $container_data[$a]->allproduct_id.',';
																	array_push($explodeproduct,$container_data[$a]->allproduct_id);
																	$no_of_product_array = explode(",",$container_data[$a]->allproduct_id);
																	
																	if(in_array($product_data[$i]->performa_trn_id,$no_of_product_array))
																	{		
																		$rowspan =  count(explode(",",$container_data[$a]->allproduct_id));
																		$button_check_array = explode(",",$container_data[$a]->allproduct_id);
																	}
																}
														 	}
														  	 
															 
														}
											?>
												<tr>
													<?php 
													if($n == 1)
													{
													  	if(!in_array($product_data[$i]->container_order_by,array_filter($stringcolor)) && $rowspan>0 && $product_data[$i]->container_order_by!=0)
														{
															 $ser_rowspan1 = ($product_data[$i]->rowspan_no>0)?$product_data[$i]->rowspan_no:'';
													?>
															<td rowspan="<?=$ser_rowspan1?>">
																<input type="checkbox" name="copy_make_container[]" id="copy_make_container<?=$i?>" value="<?=implode(",",$button_check_array)?>" class="form-control"  />
																<input type="hidden" name="total_product_container" id="total_product_container<?=$product_data[$i]->performa_trn_id?>" value="1"/>
														<?php 
														}
														else if($product_data[$i]->product_container!=0)
														{?>
															<td rowspan="<?=count($product_data[$i]->packing)?>">
																<input type="checkbox" name="copy_make_container[]" id="copy_make_container<?=$i?>" value="<?=$product_data[$i]->performa_trn_id?>" class="form-control" <?=$checkedcontainer?> />
																<input type="hidden" name="total_product_container" id="total_product_container<?=$product_data[$i]->performa_trn_id?>" value="<?=$product_data[$i]->product_container?>"/>
															</td>	 
													<?php }
													 
													}
													?>
												 	<td>
														<?=$description_goods?>
													</td>
													<?php 
													if($n == 1)
													{
													  	if(!in_array($product_data[$i]->container_order_by,array_filter($stringcolor)) && $rowspan>0 && $product_data[$i]->container_order_by!=0)
														{
														 	$container_order_by += $product_data[$i]->container_order_by;
															 $ser_rowspan1 = ($product_data[$i]->rowspan_no>0)?$product_data[$i]->rowspan_no:'';
														 	 echo '<td rowspan="'.$ser_rowspan1.'" class="text-center" > 1  </td>';
															array_push($stringcolor,$product_data[$i]->container_order_by);
															$total_container += 1;
														}
														else if($product_data[$i]->product_container>0)
														{
													 		?>
															<td rowspan="<?=count($product_data[$i]->packing)?>" class="text-center">
																<?=$product_data[$i]->product_container?>
															</td>
														<?php	
														$total_container += $product_data[$i]->product_container;
														}
														else if($product_data[$i]->container_order_by==0)
														{
													 		?>
															<td rowspan="<?=count($product_data[$i]->packing)?>">
																<?=$product_data[$i]->product_container?>
															</td>
														<?php	
														 
														}
													}
													?>
													<td>
														<?php
														if($packing_row->no_of_pallet>0)
														{
																echo $packing_row->no_of_pallet;
														}
														else if($packing_row->no_of_big_pallet>0 || $packing_row->no_of_small_pallet>0)
														{
															echo 'Big : '.$packing_row->no_of_big_pallet.'<br> Small : '.$packing_row->no_of_small_pallet;
														}
														?>
													</td>
													<td>
														<?=$packing_row->no_of_boxes; ?>
													</td>
													<td>
														<?=$packing_row->no_of_sqm; ?>
													</td>
											 	</tr>
												<?php
													$Total_weight += $product_data[$i]->defualt_grossweight;
													
												 $n++;
												
											  }
											   $no++;
											}
												
												?>
											 </tbody>
										</table>										
						</center>
							<input type="hidden" name="total_no_of_container" id="total_no_of_container" value="<?=$no_of_container?>"/>
				<?php }    
				 
				?>	 
			 </div>  			
		 </div>
		 <div class="modal-footer">
			<button  type="button" id="button" class="btn btn-info" onclick="copy_containter(<?=$invoicedata->performa_invoice_id?>,<?=$invoicedata->export_invoice_id?>)"> Copy </button>
              <!--  <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>-->
            </div>
			 
			 
    </div>
</div>
</div>
</div>
<div id="suppliermodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Supplier</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="supplier_form" id="supplier_form">
				<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="field-group">
							<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Name" required="" class="form-control" />
						</div>   
					</div>
					<div class="col-md-6">					
						<div class="field-group">
								<input type="text" id="company_name" name="company_name" placeholder="Supplier Company Name" required="" title="Enter Company Name" class="form-control"   />
						</div>                
				    </div>                
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" id="supplier_gstno" name="supplier_gstno" placeholder="Supplier Gst No" required="" title="Enter Gst No" class="form-control"  />
						</div>                
				    </div>
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" id="supplier_panno" name="supplier_panno" placeholder="Supplier Pan No"  title="Enter Pan No" class="form-control"  />
						</div>                
				    </div>
					<div class="col-md-12">	</div>
					 <div class="col-md-6">					
						<div class="field-group">
							<input type="text" id="permission_no" name="permission_no" placeholder="Permission No"   class="form-control"/>
						</div>                
				    </div> 
								
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" id="permission_date" name="permission_date" placeholder="Permission Date"   class="form-control defualt-date-picker"  />
						</div>                
				    </div>  
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" id="expiry_date" name="expiry_date" placeholder="Expiry Date"   class="form-control"/>
						</div>                
				    </div>   
					 <div class="col-md-6">	
						<label class="col-sm-6  control-label" for="form-field-1">
									Upload Permission Doc
							</label>					
						<div class="field-group col-sm-6">
							<input type="file" name="permission_doc" id="permission_doc" class="form-control" accept="application/msword,application/pdf">
						</div>                
				    </div>
					<div class="col-md-6">					
						<div class="field-group">
							<textarea id="supplier_address" name="supplier_address" placeholder="Supplier Address"  class="form-control" required title="Enter Supplier Address"></textarea>
						</div>                
				    </div> 	
					<div class="col-md-6">					
						<div class="field-group">
							<textarea id="issue_authority_address" name="issue_authority_address" placeholder="Issue uthority Address" class="form-control"></textarea>
						</div>                
				    </div> 
					  					
			 	</div>
			 </div>
				<div class="modal-footer">
					<button name="Submit" type="submit" class="btn btn-info"> Save <img src="<?=base_url()?>adminast/assets/images/loader.gif" style="display:none;width:14px;" class="loader" /></button>   
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
        </div>
    </div>
</div>
<div id="myModal_epcg" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add EPCG </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="epcg_add" id="epcg_add">
				<div class="modal-body">
				 	<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Detail
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Detail" id="epcg_no" class="form-control" name="epcg_no" value="" >
					 	</div>
					</div>
				       <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Date
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Date" id="epcg_date" class="form-control defualt-date-picker" name="epcg_date" value="" required title="Select Date">
					 	</div>
					</div>
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="supplierid" id="supplierid" value="" />
			 </form>
        </div>
    </div>
</div>
<div id="excelModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1122px">
        <!-- Modal content-->
        <div class="modal-content"  >
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Container Price </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="wallproduct_form" id="wallproduct_form">
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
                <div class="row">
						<div class="col-md-12">
							<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productmodal" data-keyboard="false" data-backdrop="static">+ Product </button>-->
						</div> 
					 <input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"> 
					 
				 	 
				  	<div class="col-md-12" id="set_container_detail" style="margin-top:10px;"> </div>        
				       
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Save" id="submit_btn" class="btn btn-success"  /> 
                <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 				
			</form>
       
    </div>
</div>
</div>

<div id="Addsamplemodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg"  style="width:1200px">
        <!-- Modal content-->
        <div class="modal-content" style="max-height: 580px;overflow-y: auto;">
		
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Sample Product <span class="containter_html"></span>  </h4>
				
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="sample_product_form" id="sample_product_form">
            <div class="modal-body">
                <div class="row">
						<input type="hidden" id="exportinvoiceid" name="exportinvoiceid" value="<?=$invoicedata->export_invoice_id?>"> 
						<input type="hidden" id="export_loading_trn_id" name="export_loading_trn_id" value=""> 
						 <input type="hidden" id="direct_invoice" name="direct_invoice" value="1"> 
						
						
						<input type="hidden" id="no_of_sample" name="no_of_sample" value=""> 
						<div class="col-md-12"style="height:20px;">	</div>	
							<div id="editresponsesamplecontainer">
							</div>
						</div>  			
				</div>
			 
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Add" id="sample_submit_btn" class="btn btn-info"  /> 
                <button type="button"   class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 
			<input type="hidden" name="sample_mode" id="sample_mode"/>
			<input type="hidden" name="edit_total_sample_data" id="edit_total_sample_data"/>
			</form>
       
    </div>
</div>
</div>

<div id="productmodal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Product</h4>
            </div>
			 <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="product_add" id="product_add">
				<input type="hidden" id="pinvoice_id" name="pinvoice_id" value="<?=$invoicedata->performa_invoice_id?>"> 
				 <input type="hidden" id="con_entry" name="con_entry" value=""> 
					<div class="modal-body">
				<div class="row">	
					<div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		  Select Product
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="product_id" name="product_id" onchange="load_packing(this.value)">
								<option value="">Select Product Name</option>
								<?php
								for($p=0;$p<count($allproduct);$p++)
								{
									$thickness = (!empty($allproduct[$p]->thickness))?" - ".$allproduct[$p]->thickness." MM":"";
								 ?>
									<option value="<?=$allproduct[$p]->product_id?>"><?=$allproduct[$p]->size_type_mm.' ('.$allproduct[$p]->series_name.')'.$thickness?></option>
								<?php
								}
								?>
							</select>
				 	</div>
				 </div>
				 <div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Select Packing
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="packing_id" name="packing_id" onchange="load_design(this.value)">
								<option value="">Select Packing Name</option>
						 </select>
				 	</div>
				 </div>
				  <div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Select Design
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="design_id" name="design_id" onchange="load_finish(this.value)">
								<option value="">Select Design Name</option>
						 </select>
				 	</div>
				 </div>
				  <div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Select Finish
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="finish_id" name="finish_id" onchange="load_finish(this.value)">
								<option value="">Select Finish</option>
						 </select>
				 	</div>
				 </div>
				 <div class="col-md-6 form-group single_con">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Pallet
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Pallet" id="no_of_pallet" class="form-control" name="no_of_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)">
				 	</div>
				 </div>   
				  <div class="col-md-6 form-group multi_con" style="display:none">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		Big Pallet
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Big Pallet" id="no_of_big_pallet" class="form-control" name="no_of_big_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)">
				 	</div>
				 </div>  
				  <div class="col-md-6 form-group multi_con" style="display:none">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		Small Pallet
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Small File" id="no_of_small_pallet" class="form-control" name="no_of_small_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)" >
				 	</div>
				 </div>
				<div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Boxes
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Boxes" id="boxes" class="form-control" name="boxes" value="" onkeyup="cal_sqm(1);" onblur="cal_sqm(1)" >
				 	</div>
				 </div>  
				<div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Batch
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Batch No" id="batch_no" class="form-control" name="batch_no" value=""  >
				 	</div>
				 </div>  	
				 <div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Shade No
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Shade No" id="shade_no" class="form-control" name="shade_no" value=""  >
				 	</div>
				 </div>  
					</div> 					
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="total_no_of_sqm" id="total_no_of_sqm" value="" />
			<input type="hidden" name="net_weight" id="net_weight" value="" />
			<input type="hidden" name="gross_weight" id="gross_weight" value="" />
			<input type="hidden" name="pallet_status" id="pallet_status" value="" />
			<input type="hidden" name="sqm_per_box" id="sqm_per_box" value="" />
			<input type="hidden" name="pcs_per_box" id="pcs_per_box" value="" />
			<input type="hidden" name="weight_per_box" id="weight_per_box" value="" />
			<input type="hidden" name="pallet_weight" id="pallet_weight" value="" />
			<input type="hidden" name="big_pallet_weight" id="big_pallet_weight" value="" />
			<input type="hidden" name="small_pallet_weight" id="small_pallet_weight" value="" />
			<input type="hidden" name="boxes_per_pallet" id="boxes_per_pallet" value="" />
			<input type="hidden" name="big_boxes_per_pallet" id="big_boxes_per_pallet" value="" />
			<input type="hidden" name="small_boxes_per_pallet" id="small_boxes_per_pallet" value="" />
			<input type="hidden" name="container_no" id="container_no" value="" />
			
			<input type="hidden" name="seal_no" id="seal_no" value="" />
			<input type="hidden" name="rfidseal_no" id="rfidseal_no" value="" />
			<input type="hidden" name="production_mst_id" id="production_mst_id" value="" />
			<input type="hidden" name="booking_no" id="booking_no" value="" />
			<input type="hidden" name="lr_no" id="lr_no" value="" />
			<input type="hidden" name="truck_no" id="truck_no" value="" />
			<input type="hidden" name="remark" id="remark" value="" />
			<input type="hidden" name="tare_weight" id="tare_weight" value="" />
			 <input type="hidden" name="supplier_id" id="supplier_id" />	
			<input type="hidden" name="container_size" id="container_size" value="" />			 
			<input type="hidden" name="container" id="container" value="" />			 
			 
			</form>
        </div>
    </div>
</div>
<script>

function edit_loading(con_entry,export_invoice_id)
{
	block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/editloading',
              data: {
                "con_entry"			: con_entry,
                "export_invoice_id"	: export_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
					$("#excelModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$(".edit_html").show();
					$("#container_no").attr("readonly",false);
					$("#company_name").val(obj.company_name);
					$("#container_no").val(obj.container_no);
					$("#seal_no").val(obj.seal_no);
					$("#rfidseal_no").val(obj.rfidseal_no);
					$("#booking_no").val(obj.booking_no);
					$("#lr_no").val(obj.lr_no);
					$("#truck_no").val(obj.truck_no);
					$("#mobile_no").val(obj.mobile_no);
					$("#remark").val(obj.remark);
					$("#con_entry").val(con_entry);
					$("#tare_weight").val(obj.tare_weight);
					$("#set_container_detail").html(obj.html);
						unblock_page('',"")
              }
			});
		 
}
function cal_rate(export_loading_trn_id,no_of_sqm)
{
	var product_rate = ($("#product_rate"+export_loading_trn_id).val() > 0)?$("#product_rate"+export_loading_trn_id).val():0;
	var amt = parseFloat(product_rate) * parseFloat(no_of_sqm);
	$("#product_amt"+export_loading_trn_id).val(amt.toFixed(2));
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
function  load_supplier(cidval,epcg_licence_no)
{
	
	if(cidval==0)
	{
		add_new_suppiler();
		return false;
	}
	else
	{
		block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"exportinvoiceproduct/getepcg_detail",
              data: {"supplier_id": cidval}, 
              success: function (response) { 
                    $("#epcg_licence_no").html(response);
                    $("#epcg_licence_no").select2("val",epcg_licence_no);
					
					unblock_page("",""); 
                  }
              
          });
	}
}
function new_epcg_detail(val,s_c_type)
{
	if(s_c_type == "Manufacturer")
	{
		if(val==0)
		{
			$("#myModal_epcg").modal("show");
			$("#supplierid").val($("#supplier_id").val());
		}
	}
	else
	{
		if($("#supplier_id").val() != 0 && val==0)
		{
			$("#myModal_epcg").modal("show");
			$("#supplierid").val($("#supplier_id").val());
		}
		else if(val==0)
		{
			toastr['error']('Please select supplier');
		}
	}
}
function add_new_suppiler()
{
	$('#suppliermodal').modal({
						backdrop: 'static',
						keyboard: false
					});
     
}

</script>
<?php $this->view('lib/footer'); 
 echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>";
 
   
if($mode != "Add")
{
	echo "<script>load_supplier(".$invoicedata->supplier_id.",'".$invoicedata->epcg_licence_no."')</script>";
} 
?>
<script>
function deletesample_product(exportproduct_trn_id)
{
	Swal.fire({
		title: 'Are you sure?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
			 if (result.value) {
					block_page()
			$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/delete_sampleentry',
              data: {
                "exportproduct_trn_id"	: exportproduct_trn_id, 
                "export_invoice_id"	: <?=$invoicedata->export_invoice_id?> 
              }, 
              cache: false, 
              success: function (data) { 
			  		unblock_page("","");
					 unblock_page("success","Sample Sucessfully Deleted.");
					 setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/'+<?=$invoicedata->export_invoice_id?> },1000);
			}
			});
			}	
		});
}
function add_sample_product(export_invoice_id,export_loading_trn_id,container_no)
{
	
	block_page()
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/add_sample',
              data: {
                "export_invoice_id" 	: export_invoice_id, 
                "export_loading_trn_id" : export_loading_trn_id, 
                "container_no" 			: container_no 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
					 $("#export_loading_trn_id").val(export_loading_trn_id);
					 $("#export_invoice_id").val(export_invoice_id);
					 $("#sample_mode").val('add');
					  $("#editresponsesamplecontainer").html(obj.str);
					 
					 $("#no_of_container_sample").val(no_of_container);
					 $("#Addsamplemodal").modal({
						 backdrop: 'static',
						 keyboard: false
					 });
					 $(".selectajax1").select2({
						width:'100%'
					 });
					 $(".containter_html").html(container_no)
					$(".tooltips").tooltip();
					unblock_page("","");
              }
			});
	 
}
function editsample_product(export_loading_trn_id)
{
	block_page()
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/edit_sampleentry',
              data: {
                "export_loading_trn_id"	: export_loading_trn_id,
				"direct_invoice"		: 2	
              }, 
              cache: false, 
              success: function (data) { 
			  var obj = JSON.parse(data);
					 $("#Addsamplemodal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#export_loading_trn_id").val(export_loading_trn_id)
				 	$("#sample_submit_btn").val("Edit");
				  	$("#sample_mode").val('edit');
				   $("#editresponsesamplecontainer").html(obj.str);
				   $(".editselectajax1").select2({
						width:'100%'
					});
					$(".containter_html").html(obj.container_name)
					  $(".selectajax1").select2({
						width:'100%'
					});
					//add_sample_product(exportproduct_trn_id,no_of_container,obj.container_name)
					unblock_page("","");
              }
			});
}


function remove_inner_sample_product(no)
{
	$(".inner_row"+no).remove();
}
function load_data_sample(val,no)
{
	 
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/getproduct_data',
              data: {
                "product_id": val
              }, 
              cache: false, 
              success: function (data) 
			  { 
					var obj = JSON.parse(data)
					 $("#product_size_id"+no).html(obj.str) 
					 
					 $("#design_id"+no).html(obj.str_design) 
					
              }
			});
}

function load_data_sample_packing(val,no)
{
	
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/getproduct_size_data',
              data: {
                "product_size_id": val
              }, 
              cache: false, 
              success: function (data) { 
					var obj = JSON.parse(data)
					$("#sqm_per_box"+no).val(obj.sqm_per_box);
					$("#weight_per_box"+no).val(obj.weight_per_box);
					//$("#palletweight"+no).val(obj.pallet_weight);
					//cal_sampledata(no,1)
              }
			});
	
}
function load_sample_finish(design_id,val)
{  
  	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoiceproduct/load_finish_data",
       data: 
	   {
			"id": design_id 
	   }, 
       success: function (response) {
			$("#finish_id"+val).html(response);
		 	unblock_page("",""); 
           }
       
  }); 
} 
function add_inner_sample_product(no,n,container_name)
{
	
	//block_page()
	 
	
	var next_no = $("#inner_row_value"+no).val() + parseInt(1);
	 
	if($("#product_details"+$("#inner_row_value"+no).val()+n).val() === "")
	{
		toastr["error"]("Please Select Product");
		$("#product_details"+$("#inner_row_value"+no).val()+n).select2('open');
		return false;
	}
	if($("#no_of_boxes"+$("#inner_row_value"+no).val()+n).val() === "")
	{
		toastr["error"]("Enter Box");
		$("#no_of_boxes"+$("#inner_row_value"+no).val()+n).focus();
		return false;
	}
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/add_inner_sample',
              data: {
                "container_name"	: container_name,
                "no"	: next_no,
				"con"	: n
              }, 
              cache: false, 
              success: function (data) {
					 
					$(".row"+no).append(data);
					$(".select"+next_no+n).select2({
						width:'100%'
					});
					$(".selectajax"+next_no+n).select2({
						width:'100%'
					});
					
					$("#inner_row_value"+no).val(next_no)
					$(".tooltips").tooltip();
					unblock_page("","");
              }
			});
	 
}
$("#sample_product_form").submit(function(event) {
	event.preventDefault();
	if(!$("#sample_product_form").valid())
	{
		return false;
	}
 
	if($("#product_details10").val() == "")
	{
		toastr["error"]("Please Add At list one Sample");
		return false;
	}
	
	 block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url: 	root+'exportinvoiceproduct/sampleentry',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sample Sucessfully Added.");
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/'+<?=$invoicedata->export_invoice_id?> },1000);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
			   }
			     
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	}); 
});

$("#wallproduct_form").submit(function(event)
{
	event.preventDefault();
	if(!$("#wallproduct_form").valid())
	{
		return false;
	}
 	 
	block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url:  root+'exportinvoiceproduct/manage_price',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				 
				 
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ location.reload(); },1000);
		    },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

closeNav();
  
$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
function load_data(product_id,mode,deletestatus)
{
if(product_id != "")
{	
   block_page();
      $.ajax({ 
        type: "POST", 
        url: root+"exportinvoiceproduct/load_design_data",
        data: {
				"id"				 	: product_id,
				"mode" 					: mode,
				"exportproduct_trn_id"	: $("#exportproduct_trn_id").val(),
				"deletestatus" 			: deletestatus
			}, 
			success: function (response) 
			{ 
              	$("#responsecontainer").html(response);
				$(".select2").select2({
					width:'100%'
				});
				if(mode	== "Edit")
				{
					load_packing($("#product_size_id").val(),mode,deletestatus)
				}
				unblock_page("",""); 
            }
        
    }); 
	}
else{
	$("#responsecontainer").html('');
}
}
function load_packing(product_size_id,mode,deletestatus)
{  
if(product_size_id != "")
{
  	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoiceproduct/load_packing",
       data: {
  		"product_size_id"		: product_size_id,
		"mode" 					: mode,
		"exportproduct_trn_id"  : $("#exportproduct_trn_id").val(),
		"deletestatus" 			: deletestatus,
  	  }, 
       success: function (response) {
		 	$(".packing_detail").html(response);
			$(".select2").select2({
				width:'100%'
			});
			check_pallet_status($("input[name='pallet_status']:checked").val())
			$(".tooltips").tooltip();
			$('#container_check').bootstrapToggle();
			 
		 	unblock_page("",""); 
           }
       
  }); 
}
else{
	$(".packing_detail").html('');
}
}  
function load_finish(design_id,val)
{  
	if(design_id == 0)
	{
		$("#row_no").val(val)
		$("#productid").val($("#product_details").val())
		$("#modeltype").modal('show');
	}
	else{
		block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/load_finish_data",
		data: {
			"id": design_id,
			"product_id": $("#product_details").val(),
			"customer_id": <?=$invoicedata->consiger_id?>
		}, 
		success: function (response) 
			{
				var obj = JSON.parse(response);
				$("#finish_id"+val).html(obj.html);
				if(obj.design_detail != null)
				{
					$("#client_name"+val).val(obj.design_detail.cust_design_name);
					$("#barcode_no"+val).val(obj.design_detail.barcode_no);
				}
				else
				{
					$("#client_name"+val).val('');
					$("#barcode_no"+val).val('');
				}
				load_rate(val);
				unblock_page("",""); 
			}
		
	}); 
	}
}  
function load_rate(val)
{
	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoiceproduct/load_rate",
       data: {
  		"consigne_id"	: <?=$invoicedata->consiger_id?>, 
  		"design_id"		: $("#design_id"+val).val() ,
  		"finish_id"		: $("#finish_id"+val).val(),
  		"product_id"	: $("#product_details").val() 
  	  }, 
       success: function (response) {
			 var obj = JSON.parse(response);
			  console.log(obj)
			 $("#client_name"+val).val((response == "null")?'':obj.cust_design_name)
			 $("#barcode_no"+val).val((response == "null")?'':obj.barcode_no)
			 $("#product_rate"+val).val((response == "null")?0:obj.design_rate)
			 cal_product_invoice()
			unblock_page("",""); 
           }
       
  }); 
}
function add_row()
{
	 $.ajax({ 
       type: "POST", 
       url: root+"exportinvoiceproduct/add_design_row",
       data: {
  		"design_id"		: $("#design_id"+$("#row_cont").val()).val(),
  		"finish_id"		: $("#finish_id"+$("#row_cont").val()).val(),
  		"product_id"	: $("#product_details").val(),
  		"no"			: $("#row_cont").val() 
  	  }, 
       success: function (response) {
		 	 $(".appendtr"+$("#row_cont").val()).after(response);
			 var next_row = parseInt($("#row_cont").val()) + parseInt(1);
			  $("#no_of_pallet"+next_row).val( $("#no_of_pallet"+$("#row_cont").val()).val() )
			  $("#no_of_big_pallet"+next_row).val( $("#no_of_big_pallet"+$("#row_cont").val()).val() )
			  $("#no_of_small_pallet"+next_row).val( $("#no_of_small_pallet"+$("#row_cont").val()).val() )
			  
				$(".select2").select2({
					width:'100%'
				});
				$("#row_cont").val(next_row);
			check_pallet_status($("input[name='pallet_status']:checked").val())
			unblock_page("",""); 
           }
       
  }); 
}
function remove_row(no)
 {
	 $(".appendtr"+no).remove();
	 
	 	$("#row_cont").val(($('.rate_table tr:last').prev().attr("class").replace( /[^\d.]/g, '')))
	cal_product_invoice();
 }
  invoice_cal();
function invoice_cal() 
{
	var total_amount 		 = $('#total_amount').val();
    var certification_charge = ($('#certification_charge').val()=="" || $('#certification_charge').val()== undefined)?0:$('#certification_charge').val();
    var insurance_charge 	 = ($('#insurance_charge').val()=="" || $('#insurance_charge').val()== undefined)?0:$('#insurance_charge').val();
    var seafright_charge 	 = ($('#seafright_charge').val()=="" || $('#seafright_charge').val()== undefined)?0:$('#seafright_charge').val();
    var discount 			 = ($('#discount').val()=="" || $('#discount').val()== undefined)?0:$('#discount').val();
	var calculation_operator = $("#calculation_operator").val()
	var extra_calc_amt = ($('#extra_calc_amt').val()=="" || $('#extra_calc_amt').val()== undefined)?0:$('#extra_calc_amt').val();
	var diffrence =   $("#diffrence").val()
	var extra_calc_opt =   $("#extra_calc_opt").val()
	
	
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
		var final_total = parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge)  - parseFloat(discount) - parseFloat(diffrence);
	 	final_total += parseFloat(seafright_charge); 
		$("#terms_first_name").html('FOB');
		$("#terms_last_name").html('<?=$invoicedata->terms_name?> Values');
	}
	else{ 
		var final_total = parseFloat(total_amount) - parseFloat(certification_charge) - parseFloat(insurance_charge)  - parseFloat(discount) - parseFloat(diffrence);
		$("#terms_first_name").html('<?=$invoicedata->terms_name?>');
		$("#terms_last_name").html('FOB Values');
		final_total -= parseFloat(seafright_charge); 
	}
	if(parseFloat(discount)>(parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge) + parseFloat(seafright_charge)))
	{
		$('#discount').focus();
		$('#discount_error').html('Not Vaild');
		$('#final_total').html(0);
		return false;
	}
	$('#discount_error').html('');
	var courier_charge = ($("#courier_charge").val() > 0)?$("#courier_charge").val():0;
	var bank_charge = ($("#bank_charge").val() > 0)?$("#bank_charge").val():0;
	final_total += parseFloat(courier_charge);
	final_total += parseFloat(bank_charge);
	$('#final_total').html(parseFloat(final_total).toFixed(2));
	$('#final_total_val').val(parseFloat(final_total).toFixed(2));
	var exchangerate = 0;
	if($("#Exchange_Rate_val").val()>0)
	{
		exchangerate = $("#Exchange_Rate_val").val();
	}
	 
	var india_ruppe = parseFloat(exchangerate) * parseFloat(final_total).toFixed(2);
	
	$("#indian_ruppe_html").html(india_ruppe.toFixed(2));
	$("#indian_ruppe_val").val(india_ruppe.toFixed(2))
	var gst = india_ruppe*18/100;
	//$("#aftergst_indian_ruppe_val").html(gst.toFixed(2))
	$("#aftergst_indian_ruppe_val").val(parseFloat(gst).toFixed(2))
}         
  
</script>
<script>
function check_product(step)
{
	 
	if(parseFloat($("#final_total").html().replace ( '$', '' ).trim())<=0)
	{
		$(".errormsg").html('You must add product.');
		toastr["error"]("You must add product.");
	}
	else
	{
		update_calc(step);
		unblock_page("success","Sucessfully Updated.");
		setTimeout(function(){ window.location='<?=base_url()?>exportinvoicesupplier/index/<?=$invoicedata->export_invoice_id?>'; },1000);
	}
}
function delete_product(productid)
{
	 
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/deleterecord',
              data: {
                "id": productid
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					updateinvoice(<?=$invoicedata->export_invoice_id?>);
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/<?=$invoicedata->export_invoice_id?>'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
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
function check_pallet_status(val)
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
	  cal_product_invoice()
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
function cal_product_invoice()
{
	
	 var radioValue = $("input[name='pallet_status']:checked"). val();
	 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	 
	 if(radioValue==1)
	 {
	 	 var boxes_per_pallet = $('#boxes_per_pallet').val();
		 var pallet_weight = $('#pallet_weight').val();
		 var weight_per_box = $('#weight_per_box').val();
		 var sqm_per_box = $('#sqm_per_box').val();
		 
		var inpschild 		= document.getElementsByName('product_rate[]');
		var no_of_pallet 	= document.getElementsByName('no_of_pallet[]');
		var no_of_boxes 	= document.getElementsByName('no_of_boxes[]');
		var no_of_sqm 		= document.getElementsByName('no_of_sqm[]');
		var product_amt 	= document.getElementsByName('product_amt[]');
		var total_no_of_pallet = 0;
		var total_no_of_boxes = 0;
		var total_no_of_sqm = 0;
		var total_product_amt = 0;
		var no =1;
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			 
			if($('#no_of_pallet'+d).val() != undefined && $('#no_of_pallet'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				var no_of_pallet = $('#no_of_pallet'+d).val();
		
				var total_pallet = ($("#no_of_pallet"+d).val()>0)?$("#no_of_pallet"+d).val():0;
				var no_of_boxes = total_pallet * boxes_per_pallet;
				$('#no_of_boxes'+d).val(no_of_boxes.toFixed(2));
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				var product_total_amount = rate_usd_val * no_of_sqm;
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var palletweight = total_pallet * pallet_weight;
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
				total_no_of_pallet	 += parseFloat(total_pallet);
				total_no_of_boxes	 += parseFloat(no_of_boxes);
				total_no_of_sqm 	 += parseFloat(no_of_sqm);
				total_product_amt 	 += parseFloat(product_total_amount);
			}
			no++;
		}
		 
		$('#total_no_of_pallet').val(total_no_of_pallet.toFixed(2));
		$('#total_no_of_boxes').val(total_no_of_boxes.toFixed(2));
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 
		var total_pallet_weight = total_no_of_pallet * pallet_weight;
		var total_net_weight 	= weight_per_box * total_no_of_boxes;
		var total_gross_weight 	= parseFloat(total_net_weight) + parseFloat(total_pallet_weight);
		$('#Pallet_Weight_html').html(total_pallet_weight);
		$('#total_pallet_weight').val(total_pallet_weight);
	 	$('#total_net_weight').val(total_net_weight);
	 	$('#total_gross_weight').val(total_gross_weight);
		 
	  }
	/* else if(radioValue==2)
	 {
		 var total_weight_val = total_boxes*weight_per_box;
		 var sqmdataval = total_boxes * appsqmperboxesval;
		 var product_total_amount = rate_usd_val * sqmdataval;
		 var gross_weight_val = parseFloat(total_boxes * weight_per_box);
		  $('#boxes_html').html(total_boxes);
		  $('#defualt_Boxes').val(total_boxes);
          $('#Total_weight').val(total_weight_val.toFixed(2));
          $('#sqm_html').html(sqmdataval.toFixed(2));
          $('#SQM').val(sqmdataval.toFixed(2));
		  $('#total_sqm').html(sqmdataval.toFixed(2));
		  	
			$('#totalweight_html').val(total_weight_val.toFixed(2));
          	$('#grossweight_html').val(gross_weight_val.toFixed(2));
		  
          $('#grossweight').val(gross_weight_val.toFixed(2));
	 }*/
	 else if(radioValue==3)
	 {
		  var weight_per_box = $('#weight_per_box').val();
		  
		 var box_per_big_pallet = $('#box_per_big_pallet').val();
		 var box_per_small_pallet = $('#box_per_small_pallet').val();
		 var big_pallet_weight = $('#big_pallet_weight').val();
		 var small_pallet_weight = $('#small_pallet_weight').val();
		 var sqm_per_box = $('#sqm_per_box').val();
		 
		var total_no_of_pallet = 0;
		var total_no_of_boxes = 0;
		var total_no_of_sqm = 0;
		var total_product_amt = 0;
		var total_gross_weight = 0;
		var total_net_weight = 0;
		var total_pallet_weight = 0;
		var no =1;
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			if($('#no_of_big_pallet'+d).val() != undefined && $('#no_of_big_pallet'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				var no_of_big_pallet = $('#no_of_big_pallet'+d).val();
				var no_of_small_pallet = $('#no_of_small_pallet'+d).val();
				
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+d).val(no_of_boxes.toFixed(2));
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				
				var product_total_amount = rate_usd_val * no_of_sqm;
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				
				var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
				total_no_of_pallet	 += parseFloat(total_pallet);
				total_no_of_boxes	 += parseFloat(no_of_boxes);
				total_no_of_sqm 	 += parseFloat(no_of_sqm);
				total_product_amt 	 += parseFloat(product_total_amount);
				total_gross_weight  += parseFloat(packing_gross_weight);
				total_net_weight 	+= parseFloat(packing_net_weight);
				total_pallet_weight 	+= parseFloat(palletweight);
			}
			no++;
		}
		 
		$('#total_no_of_pallet').val(total_no_of_pallet.toFixed(2));
		$('#total_no_of_boxes').val(total_no_of_boxes.toFixed(2));
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
	 	$('#Pallet_Weight_html').html(total_pallet_weight);
		$('#total_pallet_weight').val(total_pallet_weight);
	 	$('#total_net_weight').val(total_net_weight);
	 	$('#total_gross_weight').val(total_gross_weight);
	 }
	 
}

function cal_product_trn(no)
{
	 
	 cal_product_invoice()
}
function cal_product_group(currency,val)
{
	 var Plts = $('#Plts').val();
	 var box_per_big_pallet = $('#box_per_big_pallet').val();
	 var box_per_small_pallet = $('#box_per_small_pallet').val();
	 var total_big_pallet = ($("#group_total_big_pallet"+val).val()>0)?$("#group_total_big_pallet"+val).val():0;
	 var total_small_pallet = ($("#group_total_small_pallet"+val).val()>0)?$("#group_total_small_pallet"+val).val():0;
	 var Boxes = ($('#Boxes'+val).val()>0)?$('#Boxes'+val).val():0;
	 var appsqmperboxesval = $('#appsqmperboxes').val();
	 var total_boxes = $("#total_boxes"+val).val();
	 var pallet_weight = $('#pallet_weight').val();
	 var big_pallet_weight = $('#big_pallet_weight').val();
	 var small_pallet_weight = $('#small_pallet_weight').val();
     var total_sqm_val = $('#SQM'+val).val();
	 var radioValue = $("input[name='pallet_status']:checked"). val();
	 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	  if(radioValue==1)
	 {
	   var sqmdataval = Boxes * appsqmperboxesval;
	   
	     var pallet_in_container = $("#group_pallet_in_container"+val).val()
	   $("#total_pallet"+val).val(total_container * pallet_in_container);
	   var total_pallet = ($("#total_pallet"+val).val()>0)?$("#total_pallet"+val).val():0;
		 
	   $('#Boxes'+val).val(total_pallet*Plts);
       $('#sqm_html'+val).html(sqmdataval.toFixed(2));
       $('#SQM'+val).val(sqmdataval.toFixed(2));
		cal_from_multiple(radioValue,currency)
	 }
	 else if(radioValue==2)
	 {
		var sqmdataval = total_boxes * appsqmperboxesval;
		$('#Boxes'+val).val(total_boxes);
		$('#sqm_html'+val).html(sqmdataval.toFixed(2));
        $('#SQM'+val).val(sqmdataval.toFixed(2));
        cal_from_multiple(radioValue,currency)
	 }
	 else if(radioValue==3)
	 {
		$("#group_total_big_pallet"+val).val(total_container * $("#group_big_pallet_in_container"+val).val());
		 
		 $("#group_total_small_pallet"+val).val(total_container * $("#group_small_pallet_in_container"+val).val());
		 
		var total_big_pallet = ($("#group_total_big_pallet"+val).val()>0)?$("#group_total_big_pallet"+val).val():0;
		var total_small_pallet = ($("#group_total_small_pallet"+val).val()>0)?$("#group_total_small_pallet"+val).val():0;
		
		var Boxes = parseFloat(box_per_big_pallet * total_big_pallet) + parseFloat(box_per_small_pallet * total_small_pallet)
		var sqmdataval = Boxes * appsqmperboxesval;
		$('#Boxes'+val).val(Boxes);
		$('#sqm_html'+val).html(sqmdataval.toFixed(2));
		$('#SQM'+val).val(sqmdataval.toFixed(2));
		cal_from_multiple(radioValue,currency)
	 }
}

 
function cal_from_multiple(radioValue,currency)
{ 
 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
     if(radioValue==1)
	 {
		var inps = $("#group_id").val().split(',');
		var no=0;
		var total_pallet = 0;
		var Plts = $("#Plts").val();
		var rate_usd_val = 0;
		var Rate_in_euro = 0;
		var sqmdataval = 0;
		var total_sqm = 0;
		var totalpallet = 0;
		var product_total_amount = 0;
		var pallet_weight = $('#pallet_weight').val();
		 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	 
		 for (var i = 0; i <inps.length; i++)
		 {
			var appsqmperboxesval = $('#sqm_per_box'+inps[no]).val();

			var pallet_in_container = $("#group_pallet_in_container"+inps[no]).val()
			$("#total_pallet"+inps[no]).val(total_container * pallet_in_container);
			 
			 
			 var multi_pallet = (parseFloat($("#total_pallet"+inps[no]).val())>0)?parseFloat($("#total_pallet"+inps[no]).val()):0;
			 total_pallet += multi_pallet
			 rate_usd_val = (parseFloat($("#Rate_In_USD"+inps[no]).val())>0)?parseFloat($("#Rate_In_USD"+inps[no]).val()):0;
			 sqmdataval = parseFloat($("#total_pallet"+inps[no]).val() * Plts) * parseFloat(appsqmperboxesval);
			 product_total_amount += parseFloat(rate_usd_val * sqmdataval);
			 
			 var total_boxes = multi_pallet * parseFloat(Plts);
			  
			 $("#Boxes"+inps[no]).val(total_boxes.toFixed(2));
			  $("#total_box"+inps[no]).val(total_boxes.toFixed(2));
			 $("#group_productrate"+inps[no]).val(parseFloat(rate_usd_val * sqmdataval).toFixed(2));
			 
			 var total_weight_val1 = parseFloat($("#Boxes"+inps[no]).val())*$("#apwigtperbox").val();
		     var gross_weight_val1 = parseFloat($("#Boxes"+inps[no]).val())*$("#apwigtperbox").val();
			
			 var total_pallet_weight_val = parseFloat(pallet_weight)*parseFloat($("#total_pallet"+inps[no]).val());
			 gross_weight_val1 = parseFloat(gross_weight_val1) + parseFloat(total_pallet_weight_val);
			 
			 $("#group_weight"+inps[no]).val(parseFloat(total_weight_val1).toFixed(2));
			 $("#group_grossweight"+inps[no]).val(parseFloat(gross_weight_val1).toFixed(2));
			 $('#SQM'+inps[no]).val(sqmdataval.toFixed(2));
			 $('#sqm_html'+inps[no]).html(sqmdataval.toFixed(2));
			 total_sqm += (parseFloat($("#SQM"+inps[no]).val())>0)?parseFloat($("#SQM"+inps[no]).val()):0;
			 totalpallet+=parseFloat($("#total_pallet"+inps[no]).val());
			   
			no++;
		}
	  		
		if($('#defualt_tr').css('display') != 'none')
		{
			 total_pallet += parseFloat($("#total_pallet").val());
			 rate_usd_val = parseFloat($("#Rate_In_USD").val());
			 sqmdataval = parseFloat($("#total_pallet").val() * Plts) * parseFloat(appsqmperboxesval);
			 total_sqm += parseFloat($("#SQM").val());
			 product_total_amount += parseFloat(rate_usd_val * sqmdataval);
		}
		
		$('#Boxes').val(parseFloat(total_pallet)*parseFloat(Plts));
		$('#boxes_html').html(parseFloat(total_pallet)*parseFloat(Plts));
		var total_weight_val = parseFloat($('#Boxes').val())*$("#apwigtperbox").val();
		var gross_weight_val = parseFloat($('#Boxes').val()*$("#apwigtperbox").val())+parseFloat(pallet_weight*total_pallet);
		var total_pallet_weight_val = parseFloat(pallet_weight)*parseFloat(total_pallet);
		
		$('#Total_weight').val(total_weight_val.toFixed(2));
         if($("#mode").val() != 'Edit')
		{
			 $('#totalweight_html').val(total_weight_val.toFixed(2));
			 $('#grossweight_html').val(gross_weight_val.toFixed(2));
		}
        $('#grossweight').val(gross_weight_val.toFixed(2));
        $('#total_pallet_weight').val(total_pallet_weight_val.toFixed(2));
        $('#Pallet_Weight_html').html(total_pallet_weight_val.toFixed(2)); 
		$("#total_sqm").html(total_sqm.toFixed(2));
		$("#pallet_html").html(totalpallet);
	 }
	else if(radioValue == 2)
	{
		var inps = $("#group_id").val().split(',');
		var no=0;
		var total_boxes = 0;
		var rate_usd_val = 0;
		var Rate_in_euro = 0; 
		var sqmdataval = 0;
		var product_total_amount =0;
		var total_sqm = 0;
		 for (var i = 0; i <inps.length; i++) 
		 {
			 var appsqmperboxesval = $('#sqm_per_box'+inps[no]).val();
			 var totalboxes = (parseFloat($("#total_boxes"+inps[no]).val())>0)?parseFloat($("#total_boxes"+inps[no]).val()):0;
			 total_boxes += totalboxes;
		
			 rate_usd_val = (parseFloat($("#Rate_In_USD"+inps[no]).val())>0)?parseFloat($("#Rate_In_USD"+inps[no]).val()):0;
			 sqmdataval   =  totalboxes * parseFloat(appsqmperboxesval);
			 product_total_amount += parseFloat(rate_usd_val * sqmdataval);
			 
			 $("#Boxes"+inps[no]).val(parseFloat($("#total_boxes"+inps[no]).val()));
			 $("#total_box"+inps[no]).val(parseFloat($("#total_boxes"+inps[no]).val()));
			 $("#group_productrate"+inps[no]).val(parseFloat(rate_usd_val * sqmdataval).toFixed(2));
			 
			 var total_weight_val1 = parseFloat($("#Boxes"+inps[no]).val())*$("#apwigtperbox").val();
		     var gross_weight_val1 = parseFloat($("#Boxes"+inps[no]).val())*$("#apwigtperbox").val();
		  
			 $("#group_weight"+inps[no]).val(total_weight_val1.toFixed(2));
			 $("#group_grossweight"+inps[no]).val(gross_weight_val1.toFixed(2));
			 var sqm = (parseFloat($("#SQM"+inps[no]).val())>0)?$("#SQM"+inps[no]).val():0;
			 total_sqm += parseFloat(sqm);
		 	no++;
		}
		if($('#defualt_tr').css('display') != 'none')
		{
			 rate_usd_val = parseFloat($("#Rate_In_USD").val());
			 sqmdataval = parseFloat($("#total_boxes").val()) * parseFloat(appsqmperboxesval);
			 total_sqm += parseFloat($("#SQM").val());
			 product_total_amount += parseFloat(rate_usd_val * sqmdataval);
		}
		  $('#boxes_html').html(total_boxes);
		  $('#defualt_Boxes').val(total_boxes);
		  var total_weight_val = parseFloat($('#Boxes').val())*$("#apwigtperbox").val();
		  var gross_weight_val = parseFloat($('#Boxes').val()*$("#apwigtperbox").val());
		  $('#Total_weight').val(total_weight_val.toFixed(2));
           if($("#mode").val() != 'Edit')
		  {
			  $('#totalweight_html').val(total_weight_val.toFixed(2));
			 $('#grossweight_html').val(gross_weight_val.toFixed(2));
		  }
          $('#grossweight').val(gross_weight_val.toFixed(2));
		    
		  $("#total_sqm").html(total_sqm.toFixed(2));
	}
	else if(radioValue == 3)
	{
		var inps = $("#group_id").val().split(',');
		var no=0;
		var total_pallet = 0;
		var totalboxes= 0;
		var totalweight= 0;
		var totalgrossweight= 0;
		var Plts = $("#Plts").val();
		var box_per_big_pallet = $('#box_per_big_pallet').val();
		var box_per_small_pallet = $('#box_per_small_pallet').val();
		
		var rate_usd_val = 0;
		var Rate_in_euro = 0;
		var sqmdataval   = 0;
		var total_sqm    = 0;
		var product_total_amount = 0;
		var pallet_weight = $('#pallet_weight').val();
		var big_pallet_weight = $('#big_pallet_weight').val();
		var small_pallet_weight = $('#small_pallet_weight').val();
		var total_pallet_weight_val = 0;
		var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
		var totalbig_pallet   = 0;
		var totalsmall_pallet = 0;
		 for (var i = 0; i <inps.length; i++) {
			var appsqmperboxesval = $('#sqm_per_box'+inps[no]).val();

			 if($("#big_pallet_in_container"+inps[no]).val()>1)
			{
			  $("#group_total_big_pallet"+inps[no]).val(total_container * $("#big_pallet_in_container"+inps[no]).val());
			}
			 if($("#small_pallet_in_container"+inps[no]).val()>1)
			{
			$("#group_total_small_pallet"+inps[no]).val(total_container * $("#small_pallet_in_container"+inps[no]).val());
			}
			
			var multi_big_pallet = (parseFloat($("#group_total_big_pallet"+inps[no]).val())>0)?parseFloat($("#group_total_big_pallet"+inps[no]).val()):0;
			var multi_small_pallet = (parseFloat($("#group_total_small_pallet"+inps[no]).val())>0)?parseFloat($("#group_total_small_pallet"+inps[no]).val()):0;
			
			var small_pallet_boxes = parseFloat(multi_small_pallet) * parseFloat(box_per_small_pallet);
			var big_pallet_boxes = parseFloat(multi_big_pallet) * parseFloat(box_per_big_pallet);
			var total_boxes = parseFloat(small_pallet_boxes) + parseFloat(big_pallet_boxes);
			
			$("#Boxes"+inps[no]).val(total_boxes.toFixed(2));
			rate_usd_val = (parseFloat($("#Rate_In_USD"+inps[no]).val())>0)?parseFloat($("#Rate_In_USD"+inps[no]).val()):0;
			sqmdataval = parseFloat(total_boxes) * parseFloat(appsqmperboxesval);
			$("#group_productrate"+inps[no]).val(parseFloat(rate_usd_val * sqmdataval).toFixed(2));
			 
			 var total_big_pallet_weight = parseFloat(multi_big_pallet) * parseFloat(big_pallet_weight);
			 var total_small_pallet_weight = parseFloat(multi_small_pallet) * parseFloat(small_pallet_weight);
			total_pallet_weight_val += parseFloat(total_big_pallet_weight);
			total_pallet_weight_val += parseFloat(total_small_pallet_weight);
			  
			 var total_weight_val1 = parseFloat(total_boxes)*$("#apwigtperbox").val();
			 
			  
		     var gross_weight_val1 = parseFloat(total_weight_val1)+ parseFloat(total_big_pallet_weight)+ parseFloat(total_small_pallet_weight);
			 
			 $("#group_weight"+inps[no]).val(parseFloat(total_weight_val1).toFixed(2));
			 $("#group_grossweight"+inps[no]).val(parseFloat(gross_weight_val1).toFixed(2));
				$('#sqm_html'+inps[no]).html(sqmdataval.toFixed(2));
				$('#SQM'+inps[no]).val(sqmdataval.toFixed(2));
			 total_sqm += (parseFloat($("#SQM"+inps[no]).val())>0)?parseFloat($("#SQM"+inps[no]).val()):0;
			 totalboxes += total_boxes;
			 totalweight += total_weight_val1;
			 totalgrossweight += gross_weight_val1;
			 product_total_amount += parseFloat(rate_usd_val * sqmdataval);
			
			no++;
		}
	  		
		if($('#defualt_tr').css('display') != 'none')
		{
			var defualt_pallet_weight = parseFloat($("#total_big_pallet").val() * big_pallet_weight) + parseFloat($("#total_small_pallet").val() * small_pallet_weight) 
			 
			 totalboxes += parseFloat($("#defualt_Boxes").val());
			 totalweight += parseFloat($("#defualt_netweight").val()); 
			 totalgrossweight += parseFloat($("#defualt_grossweight").val()); 
			 total_pallet_weight_val += parseFloat(defualt_pallet_weight); 
			 total_sqm += parseFloat($("#SQM").val());
			 totalbig_pallet 	+= parseFloat($("#total_big_pallet").val());
			 totalsmall_pallet  += parseFloat($("#total_small_pallet").val());
			 product_total_amount += parseFloat($("#default_total").val());
		}
	 	$('#boxes_html').html(totalboxes);
		$('#Total_weight').val(totalweight.toFixed(2));
       if($("#mode").val() != 'Edit')
		{
			$('#totalweight_html').val(totalweight.toFixed(2));
			$('#grossweight_html').val(totalgrossweight.toFixed(2));
		}
        $('#grossweight').val(totalgrossweight.toFixed(2));
        $('#total_pallet_weight').val(total_pallet_weight_val.toFixed(2));
        $('#Pallet_Weight_html').html(total_pallet_weight_val.toFixed(2)); 
		$("#total_sqm").html(total_sqm.toFixed(2));
	}
	 $('#totalprice_html').html(product_total_amount.toFixed(2));
	 $('#Total_Amount').val(product_total_amount.toFixed(2));
}      
function set_model_rate(currency,sqm_per_box)
{
	
	var group_id = $("#model_serice").val();
 	var exitedgroup = $("#group_id").val().split(',');
 	 
	if(group_id==null)
	{
		$("#group_id").val('')
		$(".multiplerate").html('');
		 cal_product_invoice(currency)	
	}
	else{
	 var i = 0;
	 var foo = [];
	 
	 if(group_id.length>=exitedgroup.length)
	 {
	  	jQuery.grep(group_id, function(el) {
			if (jQuery.inArray(el, exitedgroup) == -1) foo.push(el);
			i++;
		});
	 }
	 else{
		 jQuery.grep(exitedgroup, function(el) {
			if (jQuery.inArray(el, group_id) == -1)
			{
				$("#tr"+el).remove();
				cal_product_group(currency,el)	
				jQuery.fn.extend({
				removeFromArray: function(value) {
						return this.filter(":input").val(function(i, v) {
						return $.grep(v.split(','), function(val) {  
							return val != value;
						}).join(',');
					}).end();
				}
				});
				$("#group_id").removeFromArray(el);
			}
			i++;
		});
		 
		cal_product_invoice(currency)		
	 return false;
	 }
	  block_page();
       $.ajax({ 
         type: "POST", 
         url: root+"exportinvoiceproduct/displaymodelrate",
         data: {"group_id": foo,"sqm_per_box":sqm_per_box  }, 
         success: function (response) { 
				 
			   if(response != 0)
               {
					$("#product_submit_btn").val('Submit')
					$("#rate_table").append(response);
					check_pallet_status($("input[name='pallet_status']:checked"). val(),currency)
					 
					$("#form_check").val(2);
					unblock_page("",""); 
					$("#group_id").val(group_id);
					cal_product_invoice(currency)	
			   }
             }
         
     });
	}	
	
}
 
function add_value(check,val,no_of_row,grossweight,netweight)
{
	if(check==true)
	{
		$("#make_container_array").val($("#make_container_array").val()+","+val);
		$("#gross_weight_array").val($("#gross_weight_array").val()+","+grossweight)
		$("#net_weight_array").val($("#net_weight_array").val()+","+netweight)
		var already = (parseInt($("#no_of_row").val())>0)?parseInt($("#no_of_row").val()):0;
		$("#no_of_row").val(parseInt(already)+parseInt(no_of_row))
	}
	else{
		$("#make_container_array").val($("#make_container_array").val().replace(val, ''));
		$("#gross_weight_array").val($("#gross_weight_array").val().replace(grossweight, ''))
		$("#net_weight_array").val($("#net_weight_array").val().replace(netweight, ''))
		var already = (parseInt($("#no_of_row").val())>0)?parseInt($("#no_of_row").val()):0;
		$("#no_of_row").val(parseInt(already)-parseInt(no_of_row))
 
	}
}
function make_container_fun(cnt)
{
	 var vals = $("#make_container_array").val().split(",");
	  var gross_weight = $("#gross_weight_array").val().split(",");
	 var net_weight = $("#net_weight_array").val().split(",");
     var filtered = vals.filter(function(value, index, arr){
	 return (value>0)
	});
	 var grossweight = gross_weight.filter(function(value, index, arr){
		  return (value>0)
	 });
	 var netweight = net_weight.filter(function(value, index, arr){
		  return (value>0)
	 });
	if (filtered.length<2){
        toastr["error"]("You must select 2 product.");
	   return false;
        }
		block_page();
		 $.ajax({ 
				  type: "POST", 
				  url: root+"exportinvoiceproduct/make_container_fun",
				  data: { 	
							"allvalues[]"		: filtered.toString(),
							"grossweight"		: grossweight.toString(),
							"netweight"		 	: netweight.toString(),
							"export_invoice_id"	: $("#export_invoice_id").val(),
							"cnt"				: cnt,
							"no_of_row"  		: $("#no_of_row").val()
							
					}, 
				  success: function (response) { 
					   $("#make_container_array").val(0)
						unblock_page("success","Sucessfully Done."); 
						setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/'+<?=$invoicedata->export_invoice_id?> },1000);
					  }
				  
			  }); 
 
}
  
  </script>
<script>
$(".select2").select2({
	width:'100%'
});
$("#product_form").validate({
		rules: {
			hsnc_code_val: {
				required: true
			},
			product_details:{
				required:true
			},
			total_container:{
				required :true
				
			}
		},
		messages: {
			hsnc_code_val: {
				required: "Select Product Code"
			},
			product_details:{
				required:"Select Product Name"
			},
			total_container:{
				required :"Enter Container",
				max: "Check Your Container"
			}
		}
	});

  $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
$("#product_form").submit(function(event) {
	event.preventDefault();
	if(!$("#product_form").valid())
	{
		return false;
	}
	else if(parseFloat($("#Total_Amount").val())<=0)
	{
		toastr["error"]("Please check rate.");
		return false;
	}
	block_page();
	var postData= new FormData(this);
	
	$.ajax({
            type: "post",
            url: 	root+'exportinvoiceproduct/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/'+<?=$invoicedata->export_invoice_id?> },1000);
				}
				else if(obj.res==2)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/'+<?=$invoicedata->export_invoice_id?> },1000);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
			   }
			    update_calc(<?=$invoicedata->step?>);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
	
function close_modal()
{

	$("#responsecontainer").html(' ')
	$("#product_form").trigger('reset');
	$("#product_details").val('').trigger('change') 
	$("#exportproduct_trn_id").val('')
}
function edit_product(product_id,deletestatus)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"exportinvoiceproduct/fetchproductdata",
              data: {"id": product_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$('#product_details').select2('destroy');
					$('#product_details').val(obj.product_id).select2({width:"100%"});
					//$("#product_details").select2("val",obj.product_id);
					 
					$("#product_details").select2("val",obj.product_id);
					$("#exportproduct_trn_id").val(obj.exportproduct_trn_id);
					 
					load_data(obj.product_id,'Edit',deletestatus);
					unblock_page("",""); 
                  }
              
          }); 

}	
   
function add_new_model(val,productsize_id)
{
	if(val == 0)
	{
	  $("#modeltype").css("z-index","10000px");
	  $("#modeltype").modal("show");
	  $("#productid").val(productsize_id);
	  $("#series_id").val($("#seriesid").val());
	  $("#model_type_name").focus();
	}
}
function remove_defualt(currency)
{
	$("#defualt_tr").hide();
	$(".add_btn").show();
	$("#defualt_status").val(0);
	cal_product_invoice(currency)	
}
function add_defualt(currency)
{
	$("#defualt_tr").show();
	$(".add_btn").hide();
	$("#defualt_status").val(1);
	cal_product_invoice(currency)	
}
function update_calc(step)
{
	 block_page();
    $.ajax({ 
             type: "POST", 
             url: root+"exportinvoiceproduct/update_export",
             data: {
				"export_invoice_id"			: $("#export_invoice_id").val(),
				"calculation_operator"		: $("#calculation_operator").val(),
				"certification_charge"		: $("#certification_charge").val(),
				"insurance_charge"			: $("#insurance_charge").val(),
				"seafright_charge"			: $("#seafright_charge").val(),
				"seafright_action"			: $("#seafright_action").val(),
				"courier_charge"			: $("#courier_charge").val(),
				"bank_charge"				: $("#bank_charge").val(),
				"discount"					: $("#discount").val(),
				"grand_total"				: $("#final_total_val").val(),
				"before_grand_total"				: $("#total_amount").val(),
				"export_under"				: $("#export_under").val(),
				"export_under1"				: $("#export_under1").val(),
				"epcg_licence_no"			: $("#epcg_licence_no").val(),
				"Exchange_Rate_val"			: $("#Exchange_Rate_val").val(),
				"remarks" 					: $("#remarks").val(),
				"supplier_gstib" 			: $("#supplier_gstib").val(),
			 	"supplier_invoice_no" 		: $("#supplier_invoice_no").val(),
				"supplier_invoice_date" 	: $("#supplier_invoice_date").val(),
				"indian_ruppe_val" 			: $("#indian_ruppe_val").val(),
				"aftergst_indian_ruppe_val" : $("#aftergst_indian_ruppe_val").val(),
				"supplier_id" 				: $("#supplier_id").val(),
				"company_rules" 			: $("#company_rules").val(),
				"rex_no_detail" 			: $("#rex_no_detail").val(),
				"lut_no" 					: $("#lut_no").val(),
				"notification_text" 	 	: $("#notification_text").val(),
				"lei_no" 	 				: $("#lei_no").val(),
				"aeo_no" 	 				: $("#aeo_no").val(),
				"commision_rate" 		 	: $("#commision_rate").val(),
				"lut_expiry" 				: $("#lut_expiry").val(),
				"extra_calc_name" 			: $("#extra_calc_name").val(),
				"extra_calc_amt" 			: $("#extra_calc_amt").val(),
				"extra_calc_opt" 			: $("#extra_calc_opt").val(),
				"currency_name" 			: $("#currency_name").val(),
				"step"						: step
			}, 
			success: function (response) { 
				unblock_page("",""); 
			}
             
         }); 
}
function delete_combaine_con(id)
{
	Swal.fire({
		title: 'Are you sure?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
			 if (result.value) {
				block_page();
				$.ajax({ 
				type: "POST", 
				url: root+'exportinvoiceproduct/make_container_delete',
				data: {
					"id": id,
					"invoice_id" : <?=$invoicedata->export_invoice_id?>
				}, 
				cache: false, 
				success: function (data) { 
					var obj = JSON.parse(data);
						if(obj.res==1)
						{
							unblock_page('success',"Record Successfully Deleted");
							setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/<?=$invoicedata->export_invoice_id?>'; },1500);
						}
						else{
							unblock_page('error',"Somthing Wrong.")
						}
					}
				});
			}	
		});
	 
}
 

function check_pallent(checked)
{
	 if(checked==true)
	{
		$("#no_of_pallet").attr("readonly",true)
		$("#no_of_pallet").val(1)
	}
	else{
		$("#no_of_pallet").attr("readonly",false)
	}
	 
}
 


$("#supplier_form").validate({
		rules: {
			supplier_name: {
				required: true
			} 
		},
		messages: {
			supplier_name: {
				required: "Enter Name"
			} 
		}
	});
$("#supplier_form").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Add_supplier/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
				   $("#supplier_form").trigger('reset');
				    $('#suppliermodal').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#supplier_id").append("<option value='"+obj.supplier_id+"' selected>"+obj.name+" - "+obj.company_name+"</option>");
					$("#supplier_id").val(obj.supplier_id);
					$("#supplier_id").trigger("change")
					load_supplier(obj.supplier_id,'')
			   }
			   else
			   {
				    unblock_page("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

$("#epcg_add").validate({
		rules: {
			epcg_no: {
				required: true
			}
		},
		messages: {
			epcg_no: {
				required: "Enter EPCG Detail"
			}
		}
	});
$("#epcg_add").submit(function(event) {
	event.preventDefault();
	if(!$("#epcg_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	postData.append("supplier_id",$("#supplierid").val());
	$.ajax({
            type: "post",
            url : root+'supplier_epcg_list/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			    {
				    $("#epcg_add").trigger('reset');
				    $('#myModal_epcg').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#epcg_licence_no").append("<option value='"+obj.id+"' selected>"+obj.epcg_no+" & Dated "+obj.epcg_date+"</option>");
					$("#epcg_licence_no").val(obj.id);
					
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","EPCG Already Exits.");
			 	}
			    else
			    {
				    unblock_page("error","Something Wrong.") 
			    }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

</script>
<script>
function copy_containter(performa_invoice_id,export_invoice_id)
{
	var producttrn_id = [];
	var total_container = 0;
	 $('input[name="copy_make_container[]"]').each(function() {
        if ($(this).is(":checked")) {
             producttrn_id.push($(this).val());
			  total_container += parseInt($("#total_product_container"+$(this). val()).val())
        }
    });
	 
	if(parseInt(total_container)>=parseInt($("#total_no_of_container").val()))
	{
		block_page();
		$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/copy_containter',
              data: {
                "producttrn_id"			: producttrn_id,
                "performa_invoice_id"	: performa_invoice_id,
                "export_invoice_id"		: export_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
			      location.reload();
              }
			});
	}
	else{
		toastr["error"]("You Must have to select "+parseInt($("#total_no_of_container").val())+" Container or more than "+parseInt($("#total_no_of_container").val()))
	} 
}

$("#modeltype_add").validate({
		rules: {
			series_name: {
				required: true
			}
		},
		messages: {
			series_name: {
				required: "Enter Group Name"
			}
		}
	});

$("#modeltype_add").submit(function(event) {
	event.preventDefault();
	 
	 if(!$("#modeltype_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("product_id",$("#productid").val());
	$.ajax({
            type: "post",
            url:  root+'add_product/grouplist_manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			    {
				   $("#modeltype_add").trigger('reset');
				   $("#modeltype").modal('hide');
				    unblock_page("success","Sucessfully Inserted.");
					$("#model_serice").append("<option value='"+obj.seriesgroup_id+"'>"+obj.seriesgroup_name+" - "+obj.group_rate+" "+$("#currency_id").val()+"</option>");
					var series_array = $("#model_serice").val();
			 		if(series_array!=null)
					{
						series_array.push(obj.seriesgroup_id.toString());
					 	$("#model_serice").val(series_array)
					}
					else
					{
						series_array = obj.seriesgroup_id;
						$("#model_serice").val(obj.seriesgroup_id);
					}
				 	set_model_rate($("#currency_id").val(),$("#sqmperbox").val())
			    }
				else
			    {
				    unblock_page("error","Something Wrong.") 
			    }
			    
			   
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

</script>
  