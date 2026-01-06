<?php 
 $export_date = date('d-m-Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no =$invoicedata->export_invoice_no;
 $export =  ($invoicedata->exporter_detail);
 $export_ref_no =  ($invoicedata->export_ref_no);
 $performa_date =  date('d-m-Y',strtotime($invoicedata->performa_date));
 $buy_order_no = strip_tags($invoicedata->export_buy_order_no);
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
 if($invoicedata->Exchange_Rate_val==0)
 {
	 $exchangerate = ($invoicedata->currency_name=="Euro")?$userdata->euro:$userdata->usd;
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
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
 $export_under = strip_tags($company_detail[0]->export_under_detail1);
 if(!empty($invoicedata->export_under))
 {
	  $export_under = $invoicedata->export_under;
 }
  $export_under1 = strip_tags($company_detail[0]->export_under_detail2); 
 if(!empty($invoicedata->export_under1))
 {
	  $export_under1 = $invoicedata->export_under1;
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
 $remarks =  strip_tags($company_detail[0]->export_remarks);
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
 $rex_no_detail = $invoicedata->rexnodetail;
 if(!empty($invoicedata->rex_no_detail))
 {
	  $rex_no_detail = $invoicedata->rex_no_detail;
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
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static" >Add Product </button>
										<button type="button" class="btn btn-primary" onclick="add_other_product()">+ Other Product </button>
										</div>
										<div class="pull-right form-group">
											<h4>
												Total Container : <?=$invoicedata->container_details?><br><br>
												<span id="html_setcontainer"></span> <br><br>
												<span id="html_container"></span></h4> 
										</div>
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="sample-table-1" width="100%">
													<thead>
														<tr>
															<th width="3%">Sr No.</th>
															<th width="30%">Description of Goods</th>
															<th width="5%">Container</th>
															<th width="5%">Plts</th>
															<th width="5%">Boxes</th>
															<th width="5%">SQM</th>
															<th width="5%">Quantity</th>
															<th width="8%">Rate In <?=$invoicedata->currency_name?></th>
															<th width="5%">Per</th>
															<th width="8%">Total Amount</th>
															<th width="8%">Gross Weight</th>
															<th width="13%">Action</th>
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
											 $Total_qty =0;
											 $qty=0;
											for($i=0; $i<count($product_data);$i++)
											{
										  		 $n = 1;
												   
											  foreach($product_data[$i]->packing  as $packing_row)
											  {
												
												 if(empty($product_data[$i]->product_id))
												 {
													 $description_goods = $product_data[$i]->description_goods;
														$qty=0;
															if($packing_row->per == "SQM")
															{
																
																$qty = $packing_row->no_of_sqm;
																$Total_qty += $qty;
															}
															else if($packing_row->per == "BOX")
															{
																
																$qty = $packing_row->no_of_boxes;
																$Total_qty += $qty;
															}
															else if($packing_row->per == "SQF")
															{
																
																$qty = ($packing_row->no_of_boxes);
																$Total_qty += $qty;
															}
															else if($packing_row->per == "PCS")
															{
																
																$qty = ($packing_row->no_of_boxes);
																$Total_qty += $qty;
															}
												    ?>
														<tr>
															<td>
																<?=$no?>
															</td>
															<td>
																<?=$description_goods?>
															</td>
															<td>
																-
															</td>
															<td>
																-
															</td>
																<td>
																-
															</td>
															<td>
																-
															</td>
															<td>
																<?=$qty?>
															</td>
															<td>
																<?=$currency_symbol?>  <?=$packing_row->product_rate; ?>
															</td>
															<td>
																<?=$packing_row->per; ?>
															</td>
															<td>
																<?=$currency_symbol?> <?=$packing_row->product_amt;?>
															</td>
															<td>
																<?=$packing_row->packing_gross_weight;?>
															</td>
													 
													<td rowspan="<?=count($product_data[$i]->packing)?>">
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
															<span class="caret"></span></button>
															  <ul class="dropdown-menu">
																<li>
																	<a class="tooltips" data-title="Edit"  onclick="edit_product(<?=$product_data[$i]->exportproduct_trn_id?>,<?=$deletestatus?>)" href="javascript:;" ><i class="fa fa-pencil"></i> Edit</a>
																</li>
																 
																	<li>
																		<a class="tooltips" data-title="Delete"  onclick="delete_product(<?=$product_data[$i]->exportproduct_trn_id?>,<?=$product_data[$i]->export_invoice_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Delete</a>
																	</li>
																 
															  </ul>
															  
															</div>
													</td>
											 	</tr>
											
												 	<?php
													$Total_ammount += $packing_row->product_amt;
													$Total_weight += $packing_row->packing_gross_weight;
												 }													 
												 else
												  {
												  $description_goods = $product_data[$i]->description_goods;
												   
												  if(!empty($packing_row->model_name))
												  {
													 $description_goods .=  ' - '.$packing_row->model_name; 
												  }
												  if(!empty($packing_row->finish_name))
												  {
													   $description_goods .=  ' - '.$packing_row->finish_name; 
												  }
												  $deletestatus = 0;
												  $samplebtn=''
											?>
												<tr>
													<?php 
													if($n == 1)
													{
													?>
													<td rowspan="<?=count($product_data[$i]->packing)?>">
														<?=$no?>
														<?php 
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
																	 
																	if(in_array($product_data[$i]->exportproduct_trn_id,$no_of_product_array))
																	{		
																		$rowspan =  count(explode(",",$container_data[$a]->allproduct_id));
																		
																	}
																}
														 	}
															
														  	$string = array_filter(explode(",",$string));
														 	if(in_array($product_data[$i]->exportproduct_trn_id,$string))
															{
																 $checkedcontainer ='checked="checked"';
																 $disabled ='disabled';
																 $deletestatus=1;
																 
															}
															
															?>
														<input type="checkbox" name="make_container" id="make_container<?=$i?>" value="<?=$product_data[$i]->exportproduct_trn_id?>" class="form-control" <?=$checkedcontainer?> onclick="add_value(this.checked,this.value,<?=count($product_data[$i]->packing)?>,<?=$product_data[$i]->total_gross_weight?>,<?=$product_data[$i]->total_net_weight?>)" <?=$disabled?> />
														<?php
														array_push($button_check_array,$product_data[$i]->exportproduct_trn_id);
														}
													
													?>
													</td>
													<?php 
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
														 	 echo '<td rowspan="'.$ser_rowspan1.'" > 1 <a class="tooltips" data-title="Delete Container"  style="color:blue" href="javascript:;"  onclick="delete_combaine_con('.$product_data[$i]->container_order_by.')">Delete</a></td>';
															array_push($stringcolor,$product_data[$i]->container_order_by);
															$total_container += 1;
															$samplebtn ='show';
															
														}
														else if($product_data[$i]->product_container>0)
														{
													 		?>
															<td rowspan="<?=count($product_data[$i]->packing)?>">
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
																$Total_plts 	+= $packing_row->no_of_pallet;
														}
														else if($packing_row->no_of_big_pallet>0 || $packing_row->no_of_small_pallet>0)
														{
															echo 'Big : '.$packing_row->no_of_big_pallet.'<br> Small : '.$packing_row->no_of_small_pallet;
															$Total_plts 	+= $packing_row->no_of_big_pallet;
															$Total_plts 	+= $packing_row->no_of_small_pallet;
														}
														 $Total_box 	+= $packing_row->no_of_boxes;
														$Total_sqm 		+= $packing_row->no_of_sqm;
														$Total_ammount += $packing_row->product_amt;
														$Total_weight  += $packing_row->packing_gross_weight;
														?>
													</td>
													<td>
														<?=$packing_row->no_of_boxes; ?>
													</td>
													<td>
														<?=$packing_row->no_of_sqm; ?>
													</td>
													<td>
														-
													</td>
													<td>
														<?=$currency_symbol?>  <?=$packing_row->product_rate; ?>
													</td>
													<td>
														<?=$packing_row->per; ?>
													</td>
													<td>
														<?=$currency_symbol?> <?=$packing_row->product_amt;?>
													</td>
													<td>
														 <?=$packing_row->packing_gross_weight;?>
													</td>
													<?php 
													if($n == 1)
													{
													?>
													<td rowspan="<?=count($product_data[$i]->packing)?>">
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
															<span class="caret"></span></button>
															  <ul class="dropdown-menu">
																<li>
																	<a class="tooltips" data-title="Edit"  onclick="edit_product(<?=$product_data[$i]->exportproduct_trn_id?>,<?=$deletestatus?>)" href="javascript:;" ><i class="fa fa-pencil"></i> Edit</a>
																</li>
																<?php
																if($deletestatus != 1)
																{
																?>
																	<li>
																		<a class="tooltips" data-title="Delete"  onclick="delete_product(<?=$product_data[$i]->exportproduct_trn_id?>,<?=$product_data[$i]->export_invoice_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Delete</a>
																	</li>
																 <?php 
																 }
																 else{?>
																	<li>
																		<a class="tooltips"  href="javascript:;" > 1st delete Container</a>
																	</li>
																 <?php }?>
															  </ul>
															  
															</div>
													</td>
													<?php 
													$Total_weight += $product_data[$i]->packing_gross_weight;
													}
													?>
													 
												</tr>
											
												<?php
													
													
													$n++;
													}
											  }
											   $no++;
											}
												
												?>
										 <tr>
											 <?php
												if(!empty($button_check_array))
												{
											 ?>
													<th colspan="2">
														<a class="btn btn-primary tooltips" data-title="Make Container"  onclick="make_container_fun(<?=$container_order_by+1?>)" href="javascript:;">Make Container</a>
													</th>
													<th colspan="9">&nbsp;</th>
											 <?php 
												}
												else
												{
											 	?>
													<th colspan="11">&nbsp;</th>
												<?php
											 	}
												 ?>
										 </tr> 


													 <tr>
															<th colspan="2" style="text-align:right">TOTAL</th>
															<th><?=$total_container ?></th>
															<th><?=$Total_plts; ?></th>
															<th><?=$Total_box; ?></th>
															<th><?=$Total_sqm; ?></th>
															<th><?=$Total_qty; ?></th>
															 <th style="text-align:right">
																<span id="terms_first_name">FOB</span> Value 
															 
															 </th>
															<th style="text-align:right"> 
															 <select name="calculation_operator" id="calculation_operator" onchange="invoice_cal()">
																	<option value="1" <?=($invoicedata->calculation_operator == 1)?"Selected='selected'":''?>>+</option>
																	<option value="2" <?=($invoicedata->calculation_operator == 2)?"Selected='selected'":''?>>-</option>
															</select>
															 </th>
															<th><?=$currency_symbol?> <?=$Total_ammount; ?></th>
															<th> <?=$Total_weight; ?></th>
															<th> </th>
															 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
														</tr>
														<?php
													 $total = $Total_ammount;
														if($invoicedata->terms_id == 1)		
														{
														?>	
														<tr>
															<th colspan="6"  style="vertical-align:top">
																 Export Under
																 <textarea  style="height:50px" class="form-control" name="export_under" tabindex="6" id="export_under"><?=$export_under?></textarea><br>
																 <textarea  style="height:50px" class="form-control" name="export_under1" tabindex="6" id="export_under1"><?=$export_under1?></textarea>
															</th> 
															
															<th colspan="3">Certification Charges</th>
															<th>
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															<th></th> 
															<th></th> 
														</tr>
														 
														 
														<?php 
														($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->certification_charge: $Total_ammount += $invoicedata->certification_charge;
														}
														else if($invoicedata->terms_id == 2)
														{
														?>
															<tr>
															<th colspan="5" rowspan="2" style="vertical-align:top">
																 Export Under
																 <textarea  style="height:50px" class="form-control" name="export_under" tabindex="6" id="export_under"><?=$export_under?></textarea><br>
																 <textarea  style="height:50px" class="form-control" name="export_under1" tabindex="6" id="export_under1"><?=$export_under1?></textarea>
															</th> 
															
															<th colspan="3">Certification Charges</th>
															<th>
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															<th></th> 
															<th></th> 
															
														</tr>
													 
														<tr>
														 
															<th colspan="3">Seagreight Charges</th>
															<th>
																<input id="seafright_charge" type="text" step="any" name="seafright_charge" tabindex="3" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
															</th>
															<th></th> 
															<th></th> 
															
														</tr>
													
														<?php 
														}
														else if($invoicedata->terms_id == 3)
														{
														?> 
															<tr>
															<th colspan="5" rowspan="3" style="vertical-align:top">
																 Export Under
																 <textarea  style="height:50px" class="form-control" name="export_under" tabindex="6" id="export_under"><?=$export_under?></textarea><br>
																 <textarea  style="height:50px" class="form-control" name="export_under1" tabindex="6" id="export_under1"><?=$export_under1?></textarea>
															</th> 
															
															<th colspan="3">Certification Charges</th>
															<th>
																<input tabindex="1" id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
															</th>
															<th></th> 
															<th></th> 
															<?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->certification_charge: $Total_ammount += $invoicedata->certification_charge;?> 
														</tr>
														<tr>
														 	<th colspan="3">Insurance Charges</th>
															<th>
																<input id="insurance_charge" type="text" step="any" name="insurance_charge" tabindex="2" placeholder="INSURANCE CHARGES" value="<?=$invoicedata->insurance_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
															</th>
															<th></th> 
															<th></th> 
															 <?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->insurance_charge: $Total_ammount += $invoicedata->insurance_charge; ?> 
														</tr>
														<tr>
														 
															<th colspan="3">Seagreight Charges</th>
															<th >
																<input id="seafright_charge" type="text" step="any" name="seafright_charge" tabindex="3" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
																<?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->seafright_charge: $Total_ammount += $invoicedata->seafright_charge; ?> 
															</th>
															<th></th> 
															<th></th> 
														</tr>
													
														<?php 
														}
														?>
														<tr>
															<td colspan="6" rowspan="4"  style="vertical-align:top">
															PO Agreement
																 <textarea  style="height:50px" class="form-control" name="company_rules" tabindex="6" id="company_rules"><?=$company_rules?></textarea><br> 
																 REX No Detail
																
																 <textarea  style="height:50px" class="form-control" name="rex_no_detail" tabindex="6" id="rex_no_detail"><?=$rex_no_detail?></textarea> 
															 
															</td> 
														 
															<th colspan="3">Courier Charges</th>
															<th>
																<input id="courier_charge" tabindex="4" type="text" step="any" name="cou" placeholder="Courier Charges" class="form-control" value="<?=$invoicedata->courier_charge?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																 
															</th>
															<th></th> 
															<th></th> 
														</tr>
														<tr>
															<th colspan="3">Bank Charges</th>
															<th>
																<input id="bank_charge" tabindex="4" type="text" step="any" name="bank_charge" placeholder="Bank Charges" class="form-control" value="<?=$invoicedata->bank_charge?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
																 
															</th> 
															<th></th> 
															<th></th> 
														</tr>
														<tr>
															<th colspan="2">
																<input id="extra_calc_name" tabindex="4" type="text" step="any" name="extra_calc_name" placeholder="Extra Calc. fields" class="form-control" value="<?=$invoicedata->extra_calc_name?>"  />
																  
															</th>
															<th>
																 
																  <select name="extra_calc_opt" tabindex="4" id="extra_calc_opt" onchange="invoice_cal()">
																	<option value="1" <?=($invoicedata->extra_calc_opt == 1)?"Selected='selected'":''?>>+</option>
																	<option value="2" <?=($invoicedata->extra_calc_opt == 2)?"Selected='selected'":''?>>-</option>
															</select>
															</th>
															<th >
																<input id="extra_calc_amt" tabindex="4" type="text" step="any" name="extra_calc_amt" placeholder="Amount" class="form-control" value="<?=$invoicedata->extra_calc_amt?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Discount"   />
																 
															</th>
															<th></th> 
															<th></th> 
															  <?php  	
															  $Total_ammount =($invoicedata->extra_calc_opt == 2)?$Total_ammount + $invoicedata->extra_calc_amt:$Total_ammount + $invoicedata->extra_calc_amt; 
											 
															  
															  ?> 
														</tr>
														<tr>
															<th colspan="3">Discount</th>
															<th >
																<input id="discount" tabindex="4" type="text" step="any" name="discount" placeholder="DISCOUNT" class="form-control" value="<?=$invoicedata->discount?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Discount"  max="<?=$Total_ammount?>"/>
																<span id="discount_error"></span>
															</th>
															<th></th> 
															<th></th> 
															  <?php  $Total_ammount -= $invoicedata->discount; ?> 
														</tr>
														<tr>
															<td colspan="6" rowspan="2"  style="vertical-align:top">
																LUT No
																	<input id="lut_no" type="text" name="lut_no"  value="<?=$lut_no?>" class="form-control" />
																	<br>
																LUT Expiry
																
																 <input id="lut_expiry" type="text" name="lut_expiry"  value="<?=$lut_expiry?>" class="form-control" />  
															</td>
															<th colspan="3"> 
																Commision Amount
															</th>
															<th>
																<input id="commision_rate" tabindex="4" type="text" step="any" name="commision_rate" placeholder="Commision Amount" class="form-control" value="<?=$invoicedata->commision_amt?>" onkeypress="return isNumber(event)" title="Enter Commision Amount" />
															</th>
															 <th></th>
															  <th></th> 
														</tr>
														<tr>
															 
															<th colspan="3"> 
																<span id="terms_last_name"><?=$invoicedata->terms_name?></span>
															
															</th>
															<th colspan="2">
																<?=$currency_symbol?>  <span id="final_total"> <?=number_format($Total_ammount,2,'.','')?></span>
																<input id="final_total_val" type="hidden" name="final_total_val"  value="<?=number_format($Total_ammount,2,'.','')?>" />
															</th>
															 <th></th> 
														</tr>
														<tr>
														
															<th colspan="6" style="vertical-align:top">
																 AEO No : <input type="text" class="form-control" rows="2"   name="aeo_no" id="aeo_no" placeholder="AEO No" value="<?=$aeo_no?>"/> 
															 
															 LEI NO :  <input type="text" class="form-control" rows="2" name="lei_no" id="lei_no" placeholder="LEI NO" value="<?=$lei_no?>"/> 
															 
															</th>  
															<th colspan="3"> Exchange Rate  </th>
															<th colspan="2">
															 <span style="width:10%"> &#x20b9;   </span>  <input  id="Exchange_Rate_val" type="text" name="Exchange_Rate_val" tabindex="5" onkeyup="invoice_cal()" value="<?=$exchangerate?>" style="width:90%" />  
															</th>
															 <th><input  id="notification_text" type="text" name="notification_text" tabindex="5" onkeyup="invoice_cal()" value="<?=$notification_text?>" style="width:90%" /> </th> 
														</tr>
														<tr>
															
														<th colspan="6" rowspan="2" style="vertical-align:top">
																 
																  Remarks
																 <textarea tabindex="8" style="height:50px" class="form-control" name="remarks" id="remarks"><?=$remarks?></textarea>
															</th>
															 															
															<th colspan="3"> Invoice Value INR  </th>
															<th colspan="2">
															<span style="width:10%">  &#x20b9; </span> 
																 
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


<div id="otherproduct" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1400px">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Other Product  </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="other_product_form" id="other_product_form">
            <div class="modal-body">
                <div class="row">
					 <input type="hidden" id="otherexport_invoice_id" name="otherexport_invoice_id" value="<?=$invoicedata->export_invoice_id?>"> 
					 <input type="hidden" id="otherexport_packing_id" name="otherexport_packing_id" value=""> 
					 <input type="hidden" id="otherexportproduct_trn_id" name="otherexportproduct_trn_id" value=""> 
					<div class="col-md-12 product_html">					
					   <div class="field-group" >
							<table class="table table-bordered table-hover otherproducttable">
								<tr>
									<td style="text-align:center" width="20%">Product Description</td>
									<td style="text-align:center" width="10%">Qty</td>
									<td style="text-align:center" width="10%">Unit</td>
									<td style="text-align:center" width="10%">Rate</td>
									<td style="text-align:center" width="10%">Amount</td>
									<td style="text-align:center" width="10%">Gross Weight </td>
									<td style="text-align:center" width="10%">Net Weight </td>
									<td style="text-align:center" width="10%">Image</td>
									<td style="text-align:center" width="10%">Action</td>
							 	</tr>
								<tr class="other_last_row1">
									<td style="text-align:center">
										 <textarea required title="Enter Product Detail" name="other_product_description[]" id="other_product_description1" class="form-control" placeholder="Product Description"></textarea>
								 	</td>
									<td style="text-align:center">
											<input type="text" onblur="calc_other_amount(1)" onchange="calc_other_amount(1)" name="other_qty[]" onkeyup="calc_other_amount(1)" id="other_qty1" class="form-control"  placeholder="Qty" required title="Enter Qty"/>
									</td>
								 	<td style="text-align:center">
											<select  name="other_unit_per[]" id="other_unit_per1" class="form-control">
													<option value="SQM">SQM</option>
													<option value="BOX">BOX</option>
													<option value="SQF">SQF</option>
													<option value="PCS">PCS</option>
											 </select>
											 
									</td>
									<td style="text-align:center">
											<input type="text" onblur="calc_other_amount(1)" onchange="calc_other_amount(1)"  onkeyup="calc_other_amount(1)" placeholder="Rate" name="other_rate[]" id="other_rate1" class="form-control" required title="Enter Rate" />
									</td>
								 	<td style="text-align:center">
										<input type="text" placeholder="Amount"  name="other_amt[]" id="other_amt1" class="form-control" readonly required title="Enter Amount" />
									</td>
									<td style="text-align:center">
										<input type="text" name="other_gross_weight[]" placeholder="Gross Weight" id="other_gross_weight1" class="form-control" required title="Enter Gross Weight"  />
									</td>
									<td style="text-align:center">
										<input type="text" name="other_net_weight[]" placeholder="Net Weight" id="other_net_weight1" class="form-control" required title="Enter Net Weight"/>
									</td>
									<td style="text-align:center">
										<input type="file" name="other_image[]"  id="other_image1" class="form-control" accept="image/*" />
										<input type="hidden" name="other_image_name[]"  id="other_image_name1"  />
										<img src="" id="show_other_img" height="100px" width="100px" style="display:none" />
									 </td>
									 <td style="text-align:center">
										 
									 </td>
								</tr>
							</table>
							<input type="hidden" name="other_row_count" id="other_row_count" value="1" />
							<button type="button" onclick="add_other_row()" class="btn btn-info other_plus">+</button>			
						</div> 
					</div> 
				 	 
					<div id="otherproductdetail"> </div>        
					  
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Save" id="other_submit_btn" class="btn btn-success"  /> 
                <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 
			</form>
       
    </div>
</div>
</div>

<script>
function add_other_product()
{
	$("#otherproduct").modal({
		backdrop: 'static',
		keyboard: false
	});
}

function calc_other_amount(val)
{
	var other_qty = ($("#other_qty"+val).val()>0)?$("#other_qty"+val).val():0;
	var other_rate = ($("#other_rate"+val).val()>0)?$("#other_rate"+val).val():0;
	
	var other_amt = parseFloat(other_qty) * parseFloat(other_rate);
	
	$("#other_amt"+val).val(parseFloat(other_amt).toFixed(2))
}
function add_other_row()
{
	 $.ajax({ 
       type: "POST", 
       url: root+"exportinvoiceproduct/add_other_row",
       data: {
   		"row_count" : $("#other_row_count").val()
  	  }, 
       success: function (response)
	   {
			$(".other_last_row"+$("#other_row_count").val()).after(response);
			var next_row = parseInt($("#other_row_count").val()) + parseInt(1);
			$("#other_row_count").val(next_row);
			unblock_page("",""); 
	   }
       
  }); 
}
function remove_other_row(no)
{
	$(".other_last_row"+no).remove();
	$("#other_row_count").val(($('.otherproducttable tr:last').attr("class").replace ( /[^\d.]/g, '' )))
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
$this->view('lib/addmodeltype'); 
 echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>";
   
if($mode != "Add")
{
	echo "<script>load_supplier(".$invoicedata->supplier_id.",'".$invoicedata->epcg_licence_no."')</script>";
} 
?>
<script>
<?php 
 
if(empty($qty))
{
?>
var used_container = <?=$total_container?>;
var pending_container = parseFloat($("#no_of_container").val()) - parseFloat(used_container);
$("#html_setcontainer").html("Set Container : "+used_container);
$("#html_container").html("Pending Of Container : "+pending_container);
<?php 
}
else{
	
	?>
	 
$("#html_setcontainer").hide();
$("#html_container").hide();
  
	<?php
}
?>
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
				"customer_id" 			: <?=$invoicedata->consiger_id?>,
				"deletestatus" 			: deletestatus
			}, 
			success: function (response) 
			{ 
              	$("#responsecontainer").html(response);
				$(".select2").select2({
					width:'100%'
				});
				if($("#product_size_id").val()	!= "")
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
	var total_amount1		 = $('#total_amount').val();
	var total_amount 		 = $('#total_amount').val();
    var certification_charge = ($('#certification_charge').val()=="" || $('#certification_charge').val()== undefined)?0:$('#certification_charge').val();
    var insurance_charge 	 = ($('#insurance_charge').val()=="" || $('#insurance_charge').val()== undefined)?0:$('#insurance_charge').val();
    var seafright_charge 	 = ($('#seafright_charge').val()=="" || $('#seafright_charge').val()== undefined)?0:$('#seafright_charge').val();
    var discount 			 = ($('#discount').val()=="" || $('#discount').val()== undefined)?0:$('#discount').val();
	var calculation_operator = $("#calculation_operator").val()
	var extra_calc_amt = ($('#extra_calc_amt').val()=="" || $('#extra_calc_amt').val()== undefined)?0:$('#extra_calc_amt').val();
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
		var final_total = parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge)  - parseFloat(discount);
	 	final_total += parseFloat(seafright_charge); 
		$("#terms_first_name").html('FOB');
		$("#terms_last_name").html('<?=$invoicedata->terms_name?> Values');
	}
	else
	{ 
		var final_total = parseFloat(total_amount) - parseFloat(certification_charge) - parseFloat(insurance_charge)  - parseFloat(discount);
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
	 
	var india_ruppe  = parseFloat(exchangerate) * parseFloat(final_total).toFixed(2);
	
	var india_ruppe1 = parseFloat(exchangerate) * parseFloat(total_amount1).toFixed(2);
	
	$("#indian_ruppe_html").html(india_ruppe.toFixed(2));
	$("#indian_ruppe_val").val(india_ruppe.toFixed(2))
	
	var gst = india_ruppe*18/100;
	
	var gst1 = india_ruppe1*18/100;
	 
	//$("#aftergst_indian_ruppe_html").html(gst.toFixed(2))
	$("#aftergst_indian_ruppe_val").val(parseFloat(gst1.toFixed(2)))
}         
  
</script>
<script>
$("#other_product_form").validate({
		rules: {
			other_product_description1: 
			{
				required: true
			}  
		},
		messages:{
			other_product_description1:
			{
				required: "Enter Product"
			} 
		}
	});

$("#other_product_form").submit(function(event) {
	event.preventDefault();
 
	if(!$("#other_product_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url:  root+'exportinvoiceproduct/othermanage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			  if(obj.res==1)
			   {
				   $("#wallproduct_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+<?=$invoicedata->export_invoice_id?> },1000);
		 	   }
			   else if(obj.res==2)
			   {
				   $("#wallproduct_form").trigger('reset');
				   unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+<?=$invoicedata->export_invoice_id?> },1000);
			 	}
				else if(obj.res==3)
				{
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+<?=$invoicedata->export_invoice_id?> },1000);
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


function check_product(step)
{
<?php 
if(empty($qty))
{
?>
	var used_container = <?=$total_container?>;
	
	var pending_container = parseFloat($("#no_of_container").val()) - parseFloat(used_container);
	 
	if(parseFloat($("#final_total").html().replace ( '$', '' ).trim())<=0)
	{
		$(".errormsg").html('You must add product.');
		toastr["error"]("You must add product.");
	}
	else if(pending_container>0)
	{
		$(".errormsg").html('No Of Container Not Match.');
		toastr["error"]("No Of Container Not Match.");
	}
	else{
		update_calc(step,2);
		unblock_page("success","Sucessfully Updated.");
		setTimeout(function(){ window.location='<?=base_url()?>exportinvoicesupplier/index/<?=$invoicedata->export_invoice_id?>'; },1000);
	}
<?php 
}
else
{
	?>
	if(parseFloat($("#final_total").html().replace ( '$', '' ).trim())<=0)
	{
		$(".errormsg").html('You must add product.');
		toastr["error"]("You must add product.");
	}
	 else
	 {
		update_calc(step,2);
		unblock_page("success","Sucessfully Updated.");
		setTimeout(function(){ window.location='<?=base_url()?>exportinvoicesupplier/index/<?=$invoicedata->export_invoice_id?>'; },1000);
	}
<?php
}
?>
}
function cal_box_trn(d)
{
	 var radioValue = $("input[name='pallet_status']:checked"). val();
	 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
				
	 if(radioValue==1)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var pallet_weight 		= $('#pallet_weight').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 var no_of_pallet 		= $('#no_of_pallet'+d).val();
		 var per_value	 		= $('#per'+d).val();
	 	 var total_pallet 		= ($("#no_of_pallet"+d).val()>0)?$("#no_of_pallet"+d).val():0;
		 var no_of_boxes 		= $('#no_of_boxes'+d).val();
		var no_of_sqm 			= no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		  
		 var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
		  
		 var palletweight = total_pallet * pallet_weight;
		 var packing_net_weight 		= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
	 }
	 else if(radioValue==2)
	 {
	 	 
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 
		 var per_value	 		= $('#per'+d).val();
	  
		 var no_of_boxes 		= $('#no_of_boxes'+d).val();
			var no_of_sqm 			= no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		  
		 var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
		  
		 
		 var packing_net_weight 		= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	=   parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
	 }
	 else if(radioValue==3)
	 {
			var weight_per_box 			= $('#weight_per_box').val();
			var per_value	 			= $('#per'+d).val();
			var box_per_big_pallet 		= $('#box_per_big_pallet').val();
			var box_per_small_pallet 	= $('#box_per_small_pallet').val();
			var big_pallet_weight 		= $('#big_pallet_weight').val();
			var small_pallet_weight 	= $('#small_pallet_weight').val();
			var sqm_per_box 			= $('#sqm_per_box').val();
			var rate_usd_val 			= $('#product_rate'+d).val();
			var no_of_big_pallet 		= $('#no_of_big_pallet'+d).val();
			var no_of_small_pallet 		= $('#no_of_small_pallet'+d).val();
			var total_pallet 			= parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
			var no_of_boxes 			= $('#no_of_boxes'+d).val();
			
			 
			var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
			var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
			$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
			var big_palletweight = no_of_big_pallet * big_pallet_weight;
			var small_palletweight = no_of_small_pallet * small_pallet_weight;
			
			var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
			var packing_net_weight 		= weight_per_box * no_of_boxes;
			var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
			
			$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
			$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
	 }
	 
	 cal_all_total(1)
}
function cal_all_total(cno)
{
 
		var total_no_of_pallet = 0;
		var total_no_of_boxes = 0;
		var total_no_of_sqm = 0;
		var total_product_amt = 0;
		var no =1;
		 var radioValue = $("input[name='pallet_status']:checked"). val();
		var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	   var weight_per_box = $('#weight_per_box').val();
		
	 if(radioValue==1)
	 {
		 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var pallet_weight 		= $('#pallet_weight').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			  
			if($('#no_of_pallet'+d).val() != undefined && $('#no_of_pallet'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				 var no_of_boxes = $('#no_of_pallet'+d).val() * boxes_per_pallet;
				 if(cno == 2)
				 {
					$('#no_of_boxes'+d).val(no_of_boxes.toFixed(2));
				 }
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				 $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
				total_no_of_pallet	 += parseFloat($("#no_of_pallet"+d).val());
				total_no_of_boxes	 += parseFloat($('#no_of_boxes'+d).val());
				total_no_of_sqm 	 += parseFloat($('#no_of_sqm'+d).val());
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;
			}
		}
		$('#total_no_of_pallet').val(total_no_of_pallet.toFixed(2));
		$('#total_no_of_boxes').val(total_no_of_boxes.toFixed(2));
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 var pallet_weight 		= $('#pallet_weight').val(); 
		 var total_pallet_weight = total_no_of_pallet * pallet_weight;
		 var total_net_weight 	= weight_per_box * total_no_of_boxes;
		 var total_gross_weight 	= parseFloat(total_net_weight) + parseFloat(total_pallet_weight);
		$('#Pallet_Weight_html').html(total_pallet_weight);
		$('#total_pallet_weight').val(total_pallet_weight);
		
	 	$('#total_net_weight').val(total_net_weight);
	 	$('#total_gross_weight').val(total_gross_weight);
	 }
	 else if(radioValue==2)
	 {
		 
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			  
			if($('#no_of_boxes'+d).val() != undefined && $('#no_of_boxes'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				 var no_of_boxes = $('#no_of_boxes'+d).val();
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				 $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
			 
				total_no_of_boxes	 += parseFloat($('#no_of_boxes'+d).val());
				total_no_of_sqm 	 += parseFloat($('#no_of_sqm'+d).val());
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;
			}
		}
		 
		$('#total_no_of_boxes').val(total_no_of_boxes.toFixed(2));
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 
		 
		 var total_net_weight 	= weight_per_box * total_no_of_boxes;
		 var total_gross_weight 	= parseFloat(total_net_weight);
		$('#Pallet_Weight_html').html(0);
		$('#total_pallet_weight').val(0);
		
	 	$('#total_net_weight').val(total_net_weight);
	 	$('#total_gross_weight').val(total_gross_weight);
	 }
	 else if(radioValue==3)
	 {
		  
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
			 	var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
			 	var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				 total_no_of_pallet	 += parseFloat(total_pallet);
				total_no_of_boxes	 += parseFloat($('#no_of_boxes'+d).val());
				total_no_of_sqm 	 += parseFloat($('#no_of_sqm'+d).val());
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;;
				total_gross_weight  += parseFloat($('#packing_gross_weight'+d).val());
				total_net_weight 	+= parseFloat($('#packing_net_weight'+d).val());
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
function delete_product(productid,export_invoice_id)
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
                "id": productid,
				"id1" : export_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					updateinvoice(<?=$invoicedata->export_invoice_id?>);
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/<?=$invoicedata->export_invoice_id?>'; },1500);
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
			cal_product_invoice();
		
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
			cal_product_invoice();
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
	 else if(radioValue==2)
	 {
		var weight_per_box = $('#weight_per_box').val();
		var sqm_per_box = $('#sqm_per_box').val();
		var total_no_of_boxes = 0;
		var total_no_of_sqm = 0;
		var total_product_amt = 0;
		 for (var d = 1; d <= $("#row_cont").val(); d++) 
		 {
			var no_of_boxes = $('#no_of_boxes'+d).val();
			var no_of_sqm = no_of_boxes * sqm_per_box;
			var rate_usd_val = $('#product_rate'+d).val();
			$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
			
				var product_total_amount = rate_usd_val * no_of_sqm;
				
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
				 
				total_no_of_boxes	 += parseFloat(no_of_boxes);
				 
				total_no_of_sqm 	 += parseFloat(no_of_sqm);
				total_product_amt 	 += parseFloat(product_total_amount);
		 }
		$('#total_no_of_pallet').val(0);
		$('#total_no_of_boxes').val(total_no_of_boxes.toFixed(2));
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 
		 
		var total_net_weight 	= weight_per_box * total_no_of_boxes;
		var total_gross_weight 	= parseFloat(total_net_weight);
		$('#Pallet_Weight_html').html(0);
		$('#total_pallet_weight').val(0);
	 	$('#total_net_weight').val(total_net_weight);
	 	$('#total_gross_weight').val(total_gross_weight);
	 } 
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
						setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+<?=$invoicedata->export_invoice_id?> },1000);
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
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+<?=$invoicedata->export_invoice_id?> },1000);
				}
				else if(obj.res==2)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+<?=$invoicedata->export_invoice_id?> },1000);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
			   }
			    update_calc(<?=$invoicedata->step?>,1);
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
					$('#product_details').val(obj.product_id).select2({width:"100%"});//$("#product_details").select2("val",obj.product_id);
					$("#exportproduct_trn_id").val(obj.exportproduct_trn_id);
					var used_container = <?=$total_container?>;
					var pending_container = parseFloat($("#no_of_container").val()) - parseFloat(used_container);
					var passcontainer = parseFloat(pending_container)+parseFloat(obj.product_container);
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
function update_calc(step,direct_invoice)
{
	 block_page();
    $.ajax({ 
             type: "POST", 
             url: root+"exportinvoiceproduct/update_export",
             data: 
			 {
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
				"direct_invoice" 			: direct_invoice,
				"company_rules" 			: $("#company_rules").val(),
				"rex_no_detail" 			: $("#rex_no_detail").val(),
				"supplier_id" 				: $("#supplier_id").val(),
				"lut_no" 					: $("#lut_no").val(),
				"notification_text" 	 	: $("#notification_text").val(),
				"lei_no" 	 				: $("#lei_no").val(),
				"aeo_no" 	 				: $("#aeo_no").val(),
				"commision_rate" 		 	: $("#commision_rate").val(),
				"lut_expiry" 				: $("#lut_expiry").val(),
				"extra_calc_name" 				: $("#extra_calc_name").val(),
				"extra_calc_amt" 				: $("#extra_calc_amt").val(),
				"extra_calc_opt" 				: $("#extra_calc_opt").val(),
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
							setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/<?=$invoicedata->export_invoice_id?>'; },1500);
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
  