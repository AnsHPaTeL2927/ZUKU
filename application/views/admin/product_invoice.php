<?php 

$export =  ($invoicedata->exporter_detail);
$performapacking_date = date('d/m/Y',strtotime($invoicedata->performa_date));
$consig_add =  ($invoicedata->consign_detail);
$buyother =  ($invoicedata->buyer_other_consign);
$payment_terms = ($invoicedata->payment_terms);
$time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";

$locale='en-US'; //browser or user locale
$currency=$invoicedata->currency_code; 
//$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
//$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
  
$invoicevalue_say = $invoicedata->terms_name; 
$pallet_status = array();
 
$igst_per = (!empty($invoicedata->grand_total))?$invoicedata->igst_per_value:$customer_detail->igst_per; 
$cgst_per = (!empty($invoicedata->grand_total))?$invoicedata->cgst_per_value:$customer_detail->cgst_per; 
$sgst_per = (!empty($invoicedata->grand_total))?$invoicedata->sgst_per_value:$customer_detail->sgst_per; 
 
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
					 	<a href="<?=base_url().'invoice_listing'?>">Proforma Invoice List</a>
					 </li>
				 	</ol>
					<div class="page-header title1">
						<h3>Proforma Invoice</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class=" panel-default">
						<div id="accordion">
						<h3>
							Proforma Invoice Detail
						</h3>   
						<div class="">
							<div class="panel-body form-body" style="padding: 10px;">
					  			<table cellspacing="0" cellpadding="0"   width="100%">
									<tr>
										<td colspan="12"  style="font-weight:bold;vertical-align: bottom;text-align: center;">
											PROFORMA INVOICE
										</td>
									</tr>
									<tr>
										<td rowspan="4" width="1%">
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
										<td width="15%">PI No</td>
										<td width="15%" colspan="2" style="font-weight:bold"> <?=$invoicedata->invoice_no?></td>
										<td  width="11%" >DATE</td>
										<td  width="12%" style="font-weight:bold"> <?=$performapacking_date?> </td>
									</tr>
									<tr>
										<td>Export Ref. No</td>
										<td colspan="2" >
											<?=$invoicedata->export_ref_no?>
										</td>
										<td>Time</td>
										<td style="font-weight:bold"> <?=$time?></td>
									</tr>
									
									<tr>
										
										<td  >Buyer Order No &amp; Date</td>
										<td colspan="4">
											<?=$invoicedata->buy_order_no?>  
											</td>
									</tr>
										<tr>
											<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">Email</td>
											<td width="3%">:</td>
											<td  width="15%" colspan="2" style="font-weight:bold"> <?=$invoicedata->e_email?> </td>
											<td width="5%">MOBILE</td>
											<td width="15%" style="font-weight:bold" ><?=$invoicedata->e_mobile?>  </td>
											<td >Other Reference(s)</td>
											<td  colspan="4">
												<?=$invoicedata->other_reference?>
											</td>
										</tr>
										
										<tr>
											<td style="font-size: 11px;">
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
											<td colspan="6" style=" vertical-align: top;font-weight:bold">
													<?=$consig_add?> 
											</td>
											<td  style=" vertical-align: top;">Buyer If Other Then Consignee [Notify]</td>
											<td colspan="4"  style=" vertical-align: top;font-weight:bold">   <?=$buyother?>  </td>
									</tr>
										<tr>
											<td colspan="4">Country of Origin Of Goods</td>
											<td colspan="3">Country of Final Destination</td>
											<td colspan="2">Port Of Loading</td>
											<td colspan="3">Transhipment </td>
										</tr>
										<tr>
												<td colspan="4" style="font-weight:bold"><?=$invoicedata->country_origin_goods?></td>
												<td colspan="3" style="font-weight:bold"><?=$invoicedata->country_final_destination?> </td>
												<td colspan="2" style="font-weight:bold"><?=$invoicedata->port_of_loading?>   </td>
												<td colspan="3" style="font-weight:bold">  <?=$invoicedata->transhipment?></td>
										</tr>
										<tr>
											<td colspan="4">Partial Shipment</td>
											<td colspan="3">Port Of Discharge</td>
											<td colspan="2">Final Destination</td>
											<td colspan="3">Variation in Qantity</td>
										</tr>
										<tr>
											<td colspan="4" style="font-weight:bold"><?=$invoicedata->partial_shipment?> </td>
											<td colspan="3" style="font-weight:bold"><?=$invoicedata->port_of_discharge?></td>
											<td colspan="2" style="font-weight:bold"><?=$invoicedata->final_destination?></td>
											<td colspan="3" style="font-weight:bold"><?=$invoicedata->variation_in_quantity?></td>
										</tr> 
											
											
											<tr>
												<td colspan="4">No of Container</td>
												<td colspan="3">Terms of Delivery</td>
												
												<td colspan="3" >  Delivery Period</td>
												<td colspan="2" > Payment Terms</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold;text-align:center"> <?=$invoicedata->container_details?> </td>
												<td rowspan="2" >X</td>
												<td style="font-weight:bold;"><?=$invoicedata->container_size?> FT FCL</td>
												<td colspan="3" style="font-weight:bold"><?=$invoicedata->terms_of_delivery?> </td>
												<td colspan="3" style="font-weight:bold"><?=$invoicedata->delivery_period?> </td>
												<td colspan="2" style="font-weight:bold"><?=$payment_terms?> </td>
											</tr>
									</table>
							</div>
						</div>
						<h3>
							Product Detail
						</h3>  
						<div class="">
							<div class="panel-body" id="product_addsection"> 
								
								<div class="pull-left form-group">
									<?php 
								  
									if($check_production_sheet == 0)
									{
									?>
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">+ Product (With Packing Detail)</button>
										<button type="button" class="btn btn-primary" onclick="open_product()">+ Product(Without Packing Detail)</button>
										<button type="button" class="btn btn-primary" onclick="import_excel()"> Import Order Excel </button>
										<button type="button" class="btn btn-primary" onclick="add_other_product()">+ Other Product </button>
									<?php 
									}
									else
									{
										echo "<span>Please Delete Production Sheet for Qty Updation</span>";
									}
									?>
								</div>
								 
								<div class="table-responsive">
									<table class="table table-bordered table-hover" id="sample-table-1" width="100%">
										 <tr>
											<th class="text-center" width="3%">Sr No.</th>
											<th class="text-center" width="28%">Description of Goods</th>
										 	<th class="text-center" width="5%">Container</th>
										 	<th class="text-center" width="5%">Plts</th>
											<th class="text-center" width="5%">Boxes</th>
											<th class="text-center" width="5%">SQM</th>
											<th class="text-center" width="5%">SQF</th>
											<th class="text-center" width="5%">Quantity</th>
											<th class="text-center" width="8%">Rate In <?=$invoicedata->currency_name?></th>
											<th class="text-center" width="5%">Per</th>
											<th class="text-center" width="8%">Total Amount</th>
											<th class="text-center" width="8%">Gross Weight</th>
											<th class="text-center" width="10%">Action</th>
										 </tr>
										<?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_qty = 0;
											$Total_box = 0;
											$Total_sqf = 0;
											$Total_ammount = 0;
											$Total_weight = 0;
											$total_container =0;
											$stringcolor=array();	
											$container_order_by=0;
											$deletestatus = 0;
											$button_check_array = array();
											$no =1;
											//var_dump($product_data);
											for($i=0; $i<count($product_data);$i++)
											{
												 
												 $Total_plts 	+= $product_data[$i]->total_no_of_pallet;
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
												  if(!empty($packing_row->finish_name))
												  {
													   $description_goods .=  ' - '.$packing_row->finish_name; 
												  }
												  $per_value = $packing_row->per;
												 $deletestatus = 0;
												 $no_of_boxes 	= $packing_row->no_of_boxes;
												 $no_of_sqm 	= $packing_row->no_of_sqm;
												 $no_of_sqf		= ($product_data[$i]->feet_per_box * $packing_row->no_of_boxes);
											 	 $per_value = $packing_row->per;		
												 
												   $Total_sqf		+= $no_of_sqf;
												   $Total_box		+= $no_of_boxes;
											?>
												<tr>
													<?php 
													if($n == 1)
													{
													?>
													<td rowspan="<?=count($product_data[$i]->packing)?>">
														<?=$no?>
													</td>
													<?php 
													$no++;
													}
													if($packing_row->no_of_pallet>0)
													{
														$product_plts = $product_data[$i]->boxes_per_pallet;
														$plts_per_container = $product_data[$i]->total_pallent_container;
														$one_container		= $packing_row->no_of_boxes * 100 / $product_data[$i]->box_per_container; 
														
													}
													else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
													{
														$product_plts  =  $product_data[$i]->box_per_big_pallet.'<br>'.$product_data[$i]->box_per_small_pallet;
														$plts_per_container = $product_data[$i]->no_big_plt_container_new.'<br>'.$product_data[$i]->no_small_plt_container_new;
														$one_container = $packing_row->no_of_boxes * 100 / $product_data[$i]->multi_box_per_container; 
														
													}
													else
													{
														$product_plts = '-';
														$plts_per_container = '-';
														$one_container = $packing_row->no_of_boxes * 100 / $product_data[$i]->total_boxes; 
													}
													
													 $one_container = ($one_container == INF)?" - ":number_format($one_container/100,2);
													 
													?>
												 	<td>
														<?=$description_goods?>
													</td>
													<td>
														<?=($product_data[$i]->product_id == 0)?"-":$one_container?>
													</td>
													<td>
														<?php
														$total_container += ($product_data[$i]->product_id == 0)?0:$one_container;
														 
														if($packing_row->no_of_pallet>0)
														{
																echo $packing_row->no_of_pallet;
																array_push($pallet_status,1);
														}
														else if($packing_row->no_of_big_pallet>0 || $packing_row->no_of_small_pallet>0)
														{
															echo 'Big : '.$packing_row->no_of_big_pallet.'<br> Small : '.$packing_row->no_of_small_pallet;
															array_push($pallet_status,1);
														}
														else
														{
															echo "-";
														}
														$qty = 0;
														if($product_data[$i]->extra_product == 1)
														{
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
															$no_of_boxes = '-';
															$no_of_sqm = '-';
															$no_of_sqf = '-';
														}
														else
														{
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
																
																$qty = ($packing_row->no_of_boxes * $product_data[$i]->feet_per_box);
																$Total_qty += $qty;
															}
															else if($packing_row->per == "PCS")
															{
																
																$qty = ($packing_row->no_of_boxes * $product_data[$i]->pcs_per_box);
																$Total_qty += $qty;
															}
														}
																?>
													</td>
													<td>
														<?=$no_of_boxes;?>
													</td>
													<td>
														<?=$no_of_sqm; ?>
													</td>
													<td>
														<?=$no_of_sqf?>
													</td>
													<td>
														<?=$qty;?>
													</td>
													<td>
														<?=$currency_symbol?>  <?=number_format($packing_row->product_rate,2,'.',''); ?>
													</td>
													
													<td>
														<?=$packing_row->per; ?>
														<input type="hidden" name="rate_in_per[]" id="rate_in_per<?=$product_data[$i]->performa_trn_id?>" value="<?=$packing_row->per?>" />
													</td>
													<td>
														<?=$currency_symbol?> <?=number_format($packing_row->product_amt,2,'.','');?>
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
																	<a class="tooltips" data-title="Edit"  onclick="edit_product(<?=$product_data[$i]->performa_trn_id?>,<?=$deletestatus?>,<?=$check_production_sheet?>,<?=$product_data[$i]->extra_product?>,<?=$packing_row->performa_packing_id?>)" href="javascript:;" ><i class="fa fa-pencil"></i> Edit</a>
																</li>
																<?php
																if($deletestatus != 1)
																{
																?>
																	<li>
																		<a class="tooltips" data-title="Delete"  onclick="delete_product(<?=$product_data[$i]->performa_trn_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Delete</a>
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
													}
													?>
													 
												</tr>
												<?php
													$Total_weight += $product_data[$i]->defualt_grossweight;
													$agent_total_amount += $packing_row->agent_product_amt;
													
												 $n++;
												
											  }
											   
											}
												
												?>
										 <tr>
											 <?php
												if(!empty($button_check_array))
												{
											 ?>
													<th colspan="3">
														 
													</th>
													<th colspan="9">&nbsp;</th>
											 <?php 
												}
												else
												{
											 	?>
													<th colspan="13">&nbsp;</th>
												<?php
											 	}
												 ?>
										 </tr>
												<tr>
													<th colspan="2" style="text-align:right">TOTAL</th>
													<th class="text-center"><?=number_format($total_container,2); ?></th>
													<th class="text-center"><?=$Total_plts; ?></th>
													<th class="text-center"><?=$Total_box; ?></th>
													<th class="text-center"><?=number_format($Total_sqm,2,'.',''); ?></th>
													<th class="text-center"><?=number_format($Total_sqf,2,'.',''); ?></th>
												 	<th class="text-center"><?=$Total_qty; ?></th>
													<th class="text-center">Values</th>
													<th class="text-center">
														<select name="calculation_operator" id="calculation_operator" onchange="invoice_cal()">
															<option value="1" <?=($invoicedata->calculation_operator == 1)?"Selected='selected'":''?>>+</option>
															<option value="2" <?=($invoicedata->calculation_operator == 2)?"Selected='selected'":''?>>-</option>
														</select>
													</th>
													<th class="text-center"><?=$currency_symbol?> <?=number_format($Total_ammount,2,'.',''); ?></th>
													<th class="text-center"><?=$Total_weight?></th>
													<th class="text-center"></th>
												</tr>
												<?php  
												if($invoicedata->terms_id == 1)
												{
												?>
												<tr>
													<th colspan="7">
														 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
													</th>
													<th colspan="3">CERTIFICATION  CHARGES</th>
													<th  >
														<input id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
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
													
													<th colspan="7">
														 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
													</th>
													<th colspan="3">CERTIFICATION  CHARGES</th>
													<th>
														<input id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
													</th>
													<th></th>
													<th></th>
													<?php 
													 ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->certification_charge: $Total_ammount += $invoicedata->certification_charge;
													  ?> 
												</tr>
											 	<tr>
												 	<th colspan="7"></th>
													<th colspan="3">
														SEAFREIGHT CHARGES
													</th>
													<th>
														<input id="seafright_charge" type="text" step="any" name="seafright_charge" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"/>
														
														<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
													</th>
													<th></th>
													<th></th>
													  <?php 
													  ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->seafright_charge: $Total_ammount += $invoicedata->seafright_charge;
													   ?> 
												</tr>
											
												<?php 
												}
												else if($invoicedata->terms_id == 3)
												{
												?>
												<tr>
													
													<th colspan="7">
														 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
													</th>
													<th colspan="3">CERTIFICATION  CHARGES</th>
													<th>
														<input id="certification_charge" type="text" step="any" name="certification_charge" placeholder="CERTIFICATION  CHARGES" class="form-control" min = "1" max = "10" value="<?=$invoicedata->certification_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
													</th>
													<th></th>
													<th></th>
													<?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->certification_charge: $Total_ammount += $invoicedata->certification_charge; ?> 
												</tr>
												<tr>
												
													<th colspan="7"></th>
													<th colspan="3">INSURANCE CHARGES</th>
													<th><input id="insurance_charge" type="text" step="any" name="insurance_charge" placeholder="INSURANCE CHARGES" value="<?=$invoicedata->insurance_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"  />
													</th>
													<th></th>
													<th></th>
													 <?php ($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->insurance_charge: $Total_ammount += $invoicedata->insurance_charge;   ?> 
												</tr>
												 
												<tr>
												
													<th colspan="7"></th>
													<th colspan="3">SEAFREIGHT CHARGES</th>
													<th>
														<input id="seafright_charge" type="text" step="any" name="seafright_charge" placeholder="SEAFREIGHT CHARGES" value="<?=$invoicedata->seafright_charge?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="invoice_cal()"/>
														<input type="hidden" name="seafright_action" id="seafright_action" value="1" />
													</th>
													 <th></th>
													<th></th>  
												</tr>
											
												<?php 
												($invoicedata->calculation_operator == 2)? $Total_ammount -= $invoicedata->seafright_charge: $Total_ammount += $invoicedata->seafright_charge;
												}
												 else
												 {
													 ?>
													 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
													 <?php
												 }
											 	?>
												<tr>
													<th colspan="7">
													
													</th>
													<th colspan="3">COURIER CHARGE</th>
													<th>
														<input id="courier_charge" type="text" step="any" name="courier_charge" placeholder="COURIER CHARGE" class="form-control" min = "1" max = "10" value="<?=$invoicedata->courier_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
													</th>
													<th></th>
												 <th></th>
												</tr>
												<tr>
													<th colspan="7" rowspan="2">
														Special Requirement    <textarea class="form-control" rows="2" name="special_requirment" id="special_requirment" style="height:83px"  ><?=strip_tags($invoicedata->special_requirment)?></textarea>
													</th>
													<th colspan="2">
														<input id="extra_calc_name" tabindex="4" type="text" step="any" name="extra_calc_name" placeholder="Extra Calc. fields" class="form-control" value="<?=$invoicedata->extra_calc_name?>"  />
													</th>
													<th>
															 
														<select name="extra_calc_opt" tabindex="4" id="extra_calc_opt" onchange="invoice_cal()">
															<option value="1" <?=($invoicedata->extra_calc_opt == 1)?"Selected='selected'":''?>>+</option>
															<option value="2" <?=($invoicedata->extra_calc_opt == 2)?"Selected='selected'":''?>>-</option>
														</select>
															</th>
													<th>
														<input id="extra_calc_amt" tabindex="4" type="text" step="any" name="extra_calc_amt" placeholder="Amount" class="form-control" value="<?=$invoicedata->extra_calc_amt?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Discount"   />
													</th>
													<th></th>
													<th></th>
												</tr>
												<tr>
													 
													<th colspan="3">OTHER CHARGE</th>
													<th>
														<input id="bank_charge" type="text" step="any" name="bank_charge" placeholder="BANK CHARGE" class="form-control" min = "1" max = "10" value="<?=$invoicedata->bank_charge ?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" />
													</th>
													<th></th>
													<th></th>
												</tr>
												<tr>
												 	<th colspan="7"> 
														  
													</th>
													<th colspan="3">DISCOUNT</th>
													<th>
														<input id="discount" type="text" step="any" name="discount" placeholder="DISCOUNT" class="form-control" value="<?=$invoicedata->discount?>" onkeypress="return isNumber(event)" onkeyup="invoice_cal()" title="Enter Vaild Discount"  max="<?=$Total_ammount?>"/>
														<span id="discount_error"></span>
													</th>
													<th></th>
													<th></th>
													  <?php  $Total_ammount -=$invoicedata->discount; ?> 
												</tr>
												<tr>
												
													<th colspan="7">
													
													</th>
													<th colspan="3">IGST VALUE
														<input id="igst_per_value" type="text" name="igst_per_value"  onkeypress="return isNumber(event)" style="width: 50%;" value="<?=$igst_per?>" placeholder="5%" onkeyup="invoice_cal()" onblur="invoice_cal()"/>
													</th>
													<th>
														<?=$currency_symbol?> <span id="igst_value_html"> <?=number_format($invoicedata->igst_value,2,'.','')?></span>
														<input id="igst_value" type="hidden" name="igst_value"  value="<?=$invoicedata->igst_value?>" />
													</th>
													 <th></th>
													<th></th>
												</tr>
												 <?php  $Total_ammount +=$invoicedata->igst_value; ?> 
												<tr>
												
													<th colspan="7"></th>
													<th colspan="3">SGST VALUE
														<input id="sgst_per_value" type="text" name="sgst_per_value"  onkeypress="return isNumber(event)" style="width: 50%;"  value="<?=$sgst_per?>" placeholder="2.5%" onkeyup="invoice_cal()" onblur="invoice_cal()"/>
													</th>
													<th>
														<?=$currency_symbol?> <span id="sgst_value_html"> <?=number_format($invoicedata->sgst_value,2,'.','')?></span>
														<input id="sgst_value" type="hidden" name="sgst_value"  value="<?=$invoicedata->sgst_value?>" />
													</th>
													 <th></th>
													<th></th>
												</tr>
												 <?php  $Total_ammount +=$invoicedata->sgst_value; ?> 
												<tr>
												
													<th colspan="7"></th>
													<th colspan="3">
														CGST VALUE
														<input id="cgst_per_value" type="text" name="cgst_per_value"  onkeypress="return isNumber(event)" style="width: 50%;" value="<?=$cgst_per?>" placeholder="2.5%" onkeyup="invoice_cal()" onblur="invoice_cal()"/>
													</th>
													<th>
														<?=$currency_symbol?> <span id="cgst_value_html"> <?=number_format($invoicedata->cgst_value,2,'.','')?></span>
														<input id="cgst_value" type="hidden" name="cgst_value"  value="<?=$invoicedata->cgst_value?>" />
													</th>
													 <th></th>
													<th></th>
												</tr>
												 <?php  $Total_ammount +=$invoicedata->cgst_value; ?> 
												<tr>
												
													<th colspan="7">
													Sample Requirement :-  : <textarea class="form-control" rows="2" name="note" id="note" style="height:83px"  ><?=strip_tags($invoicedata->note)?></textarea>
													</th>
													<th colspan="3"><?=$invoicevalue_say?> VALUE</th>
													<th>
														<?=$currency_symbol?> <span id="final_total"> <?=number_format($Total_ammount,2,'.','')?></span>
														<input id="final_total_val" type="hidden" name="final_total_val"  value="<?=$Total_ammount?>" />
														<input id="agent_final_total_val" type="hidden" name="agent_final_total_val"  value="<?=$agent_total_amount?>" />
													</th>
													 <th></th>
													<th></th>
												</tr>
			 								 
										</table>										
								</div>
									
								</div>
			
						</div>
						</div>
						<div style="padding: 14px;padding-left:0px;">
							<button class="btn btn-success" onclick="check_product(<?=($invoicedata->step==1)?2:$invoicedata->step?>);">Save & Next</button>
							<a href="<?=base_url().'invoice/form_edit/'.$invoicedata->performa_invoice_id?>" class="btn btn-danger">
									Back
							</a>
							<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
							<input type="hidden" id="per_value" name="per_value" value="<?=$per_value?>"> 
							<input type="hidden" id="make_container_array" name="make_container_array" value="0"> 
							<input type="hidden" id="gross_weight_array" name="gross_weight_array" value="0"> 
							<input type="hidden" id="net_weight_array" name="net_weight_array" value="0"> 
							
							<input type="hidden" id="no_of_row" name="no_of_row" value="0"> 
							<input type="hidden" id="pallet_status" name="pallet_status" value="<?=implode(",",$pallet_status)?>"> 
							<input type="hidden" id="performainvoiceid" name="performainvoiceid" value="<?=$invoicedata->performa_invoice_id?>"> 
							<div class="errormsg" style="color:red"></div>
						</div>
					 
					</div>
				</div>
			</div>
		</div>
	</div>
 
</div>
		 
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 1266px;overflow-x: scroll;">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button" onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Product   </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="product_form" id="product_form">
            <div class="modal-body">
                <div class="row">
					 <input type="hidden" id="performainvoice_id" name="performainvoice_id" value="<?=$invoicedata->performa_invoice_id?>"> 
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
				 	 
					<div id="productdetail"> </div>        
					<div id="responsecontainer"></div>        
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Save" id="product_submit_btn" class="btn btn-success"  /> 
                <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="performa_trn_id" id="performa_trn_id"/>
			<input type="hidden" name="form_check" id="form_check" value="1" />
			<input type="hidden" name="mode" id="mode" value="Add" />
											<input type="hidden" name="customer_id" id="customer_id" value="<?=$invoicedata->consigne_id?>" />

			</form>
       
    </div>
</div>
</div>

<div id="wallproduct" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1400px">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Product  </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="wallproduct_form" id="wallproduct_form">
            <div class="modal-body" style="overflow-x:scroll;">
                <div class="row">
					 <input type="hidden" id="wallperformainvoice_id" name="wallperformainvoice_id" value="<?=$invoicedata->performa_invoice_id?>"> 
					<div class="col-md-12 product_html " >					
					   <div class="field-group" >
							<table class="table table-bordered table-hover walltable">
								<tr>
									<td style="text-align:center" width="15%">Product</td>
									<td style="text-align:center" width="5%">Pallet</td>
									<td style="text-align:center" width="8%">Design</td>
									<td style="text-align:center" width="8%">Finish</td>
									<td style="text-align:center" width="8%">Client Name</td>
									<td style="text-align:center" width="8%">Barcode</td>
									<td style="text-align:center" width="8%">Rate </td>
									<td style="text-align:center" width="8%">Rate In </td>
									<td style="text-align:center" width="7%" class="">Pallet / <br>Pallet Type </td>
									<td style="text-align:center" width="7%">BOXES /<br> Box Design</td>
									<td style="text-align:center" width="7%">SQM</td>
									<td style="text-align:center" width="8%">Amount</td>
									<td style="text-align:center" width="5%">Action</td>
								</tr>
								<tr class="last_row1">
									<td style="text-align:center"  >
										<select id="product_id1" name="product_id[]" onchange="wallload_data(this.value,1)" style="width:200px">
											<option value="">Select Product Name</option>
												<?php
												for($p=0;$p<count($allsizeproduct);$p++)
												{
													$thickness = (!empty($allsizeproduct[$p]->thickness))?" - ".$allsizeproduct[$p]->thickness." MM":"";
												?>
													<option value="<?=$allsizeproduct[$p]->product_id.' - '.$allsizeproduct[$p]->product_size_id?>"><?=$allsizeproduct[$p]->size_type_mm.' ('.$allsizeproduct[$p]->series_name.')'.$thickness.' - '.$allsizeproduct[$p]->product_packing_name?></option>
												<?php
												}
												?>
										</select>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="pallet_status1" id="pallet_status11" value="1" onclick="wallcheck_pallet_status(this.value,1)" checked />With   
										</label>
										<label class="radio-inline">
											<input type="radio" name="pallet_status1" id="pallet_status12" value="2" onclick="wallcheck_pallet_status(this.value,1)"  />Without  
										</label> 
										<label class="radio-inline">
											<input type="radio" name="pallet_status1" id="pallet_status13" value="3" onclick="wallcheck_pallet_status(this.value,1)"   />Multi 
									</label>
									</td>
									<td style="text-align:center">
										<select class="select2" id="walldesign_id1" name="walldesign_id[]" class="select2" onchange="wallload_finish(this.value,1)" style="width:100%">
											 <option value="">Select Design  </option>
									 	</select>
									</td>
									<td style="text-align:center">
										<select class="select2" id="wallfinish_id1" name="wallfinish_id[]" class="select2" onchange="wallload_rate(1)" style="width:100%"> 
											<option value="">Select Finish</option> 
										</select>
									</td>
										<td style="text-align:center">
												<input type="text" name="client_name[]" id="client_name1" class="form-control"  />
										</td>
										
										<td style="text-align:center">
												<input type="text" name="barcode_no[]" id="barcode_no1" class="form-control"  />
										</td>
								 	<td style="text-align:center">
											<input type="text" name="product_rate[]" id="product_rate1" class="form-control" onkeypress="return isNumber(event)" onblur="cal_wallproduct_invoice(1)"   onkeyup="cal_wallproduct_invoice(1)" value="" />
									</td>
									<td class="">
											<select  name="product_rate_per[]" id="product_rate_per1" class="form-control" onchange="cal_wallproduct_invoice(1)">
													<option  value="SQM" >SQM</option>
													<option  value="BOX" >BOX</option>
													<option  value="SQF" >SQF</option>
													<option  value="PCS" >PCS</option>
											</select>
										</td>
									<td style="text-align:center" class="">
											<input type="text" name="no_of_pallet[]" id="no_of_pallet1" class="form-control pallet_calcution1"  onkeypress="return isNumber(event)" onblur="cal_wallproduct_invoice(1)"   onkeyup="cal_wallproduct_invoice(1)" value=""/>
											<span class="multi_pallet_calcution1" style="display:none"> 
												Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet1" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_wallproduct_invoice(1)"   onkeyup="cal_wallproduct_invoice(1)" value="" placeholder ="Big Pallet"/>
												Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet1" class="form-control"  onkeyup="return isNumber(event)" onblur="cal_wallproduct_invoice(1)"   onblur="cal_wallproduct_invoice(1)" value=""  placeholder ="Small Pallet"/>
												</span>
												<br>
											<span class="multi_pallet_calcution1 pallet_calcution1"> 
												<select  id="pallet_type1" name="pallet_type[]" class="select1"  style="width:100px">
															<option value="">Pallet Type</option>
															<?php 
															 
																foreach($pallet_type as $pallet_type_row)
																{
																	  
																	echo '<option   value="'.$pallet_type_row->pallet_type_id.'">'.$pallet_type_row->pallet_type_name.'</option>';
																}
																?>
												</select>
												</span>
									</td>
									<td style="text-align:center" >
										<input type="text" name="no_of_boxes[]" id="no_of_boxes1" class="form-control pallet_calcution1 multi_pallet_calcution1" onchange="cal_wallbox_invoice(1)" onkeyup="cal_wallbox_invoice(1)"  value="" />
										<input type="text" name="only_no_of_boxes[]" id="only_no_of_boxes1" class="form-control boxes_calculation1" value="" onkeyup="cal_wallproduct_invoice(1)"  onblur="cal_wallproduct_invoice(1)" style="display:none"/>
										<br>
												<select   id="box_design1" name="box_design[]" class="select1"  style="width:100px">
																<option value="">Box Design</option>
															<?php 
															 
																foreach($box_design as $box_design_row)
																{
																	  
																	echo '<option   value="'.$box_design_row->box_design_id.'">'.$box_design_row->box_design_name.'</option>';
																}
																?>
												</select>
									</td>
									 
									<td style="text-align:center">
										<input type="text" name="no_of_sqm[]" id="no_of_sqm1" class="form-control" readonly  value=""/>
									</td>
									<td style="text-align:center">
										<input type="text" name="product_amt[]" id="product_amt1" class="form-control" readonly   value=""/>
									</td>
									<td style="text-align:center">
										
										<input type="hidden" name="weight_per_box[]" id="weight_per_box1" />
										<input type="hidden" name="pallet_weight[]" id="pallet_weight1" />
										<input type="hidden" name="big_pallet_weight[]" id="big_pallet_weight1" />
										<input type="hidden" name="small_pallet_weight[]" id="small_pallet_weight1" />
										<input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet1" />
										<input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet1" />
										<input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet1" />
										<input type="hidden" name="sqm_per_box[]" id="sqm_per_box1" />
										<input type="hidden" name="feet_per_box[]" id="feet_per_box1" />
										<input type="hidden" name="pcs_per_box[]" id="pcs_per_box1" />
										<input type="hidden" name="packing_net_weight[]" id="packing_net_weight1" />
										<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight1" />
										<input type="hidden" name="no[]" id="no1" value="1" />
										 
									</td>
								</tr>
							</table>
							<input type="hidden" name="row_count" id="row_count" value="1" />
							<button type="button" onclick="add_wall_row()" class="btn btn-info">+</button>			
						</div> 
					</div> 
				 	 
					<div id="wallproductdetail"> </div>        
					<div id="wallresponsecontainer"></div>        
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Save" id="submit_btn" class="btn btn-success"  /> 
                <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
								<input type="hidden" name="wallcustomer_id" id="wallcustomer_id" value="<?=$invoicedata->consigne_id?>" />

			</form>
       
    </div>
</div>
</div>


<div id="excelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"   class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Order  </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="import_form" id="import_form">
			 	 <input type="hidden" name="exportcustomer_id" id="exportcustomer_id" value="<?=$invoicedata->consigne_id?>" />
			
			 <input type="hidden" id="performa_id" name="performa_id" value="<?=$invoicedata->performa_invoice_id?>"> 
            <div class="modal-body">
                <div class="row">
					  
					<div class="col-md-12 product_html">					
					   <div class="field-group" >
								<div class="tab"> 
										<h4>Select File For Upload Data</h4>
										<input type="file" name="import_file" id="import_file" accept=".csv">
								</div>	
								
						</div> 
						 <div class="field-group" >
							<div class="tab"> 
										 <a href="<?=base_url().'upload/csv/order.csv'?>"  class="btn btn-primary"  target="_blank">Sample File Download</a>
								</div>	
						</div> 
					</div> 
				 	 
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Import" id="import_submit_btn" class="btn btn-success"  /> 
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="import_customer_id" id="import_customer_id" value="<?=$invoicedata->consigne_id?>" />			
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
                <h4 class="modal-title">Manage Product  </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="other_product_form" id="other_product_form">
            <div class="modal-body">
                <div class="row">
					 <input type="hidden" id="otherperformainvoice_id" name="otherperformainvoice_id" value="<?=$invoicedata->performa_invoice_id?>"> 
					 <input type="hidden" id="otherperforma_packing_id" name="otherperforma_packing_id" value=""> 
					 <input type="hidden" id="otherperforma_trn_id" name="otherperforma_trn_id" value=""> 
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

<?php 
$this->view('lib/footer'); 
$this->view('lib/addmodeltype'); 
?>
<script>

// Global helper function to safely unblock page - works even if unblock_page is not defined
function safeUnblock(type, msg) {
	if(typeof unblock_page === 'function') {
		safeUnblock(type, msg);
	} else if(typeof $.unblockUI === 'function') {
		// Fallback to direct jQuery unblockUI
		if(type !== "" && msg !== "") {
			if(typeof toastr !== 'undefined') {
				toastr[type](msg);
			}
		}
		setTimeout(function(){ $.unblockUI(); }, 500);
	} else {
		// Last resort: just show message if toastr is available
		if(typeof toastr !== 'undefined' && type !== "" && msg !== "") {
			toastr[type](msg);
		}
	}
}

// function do_same_in_all(val)
// {
	// $(".same_cls"+val).show();
	// $(".same_cls"+val).fadeOut(6000);
// }
// function change_suppiler(val)
// {
	// var value= $("#suppiler_id"+val).val();
	 
	// $(".suppiler_cls").val(value).trigger('change')
// }
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
            url:  root+'product/othermanage',
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
				    safeUnblock("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
				 
			   }
			   else if(obj.res==2)
			   {
				   $("#wallproduct_form").trigger('reset');
				   safeUnblock("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
					 
				}
				else if(obj.res==3)
				{
					setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
				}
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
			   }
			  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function calc_other_amount(val)
{
	var other_qty = ($("#other_qty"+val).val()>0)?$("#other_qty"+val).val():0;
	var other_rate = ($("#other_rate"+val).val()>0)?$("#other_rate"+val).val():0;
	
	var other_amt = parseFloat(other_qty) * parseFloat(other_rate);
	
	$("#other_amt"+val).val(parseFloat(other_amt).toFixed(2))
}
function add_other_product()
{
	$("#otherproduct").modal({
		backdrop: 'static',
		keyboard: false
	});
}
function add_other_row()
{
	 $.ajax({ 
       type: "POST", 
       url: root+"product/add_other_row",
       data: {
   		"row_count" : $("#other_row_count").val()
  	  }, 
       success: function (response) {
		 	 $(".other_last_row"+$("#other_row_count").val()).after(response);
			 var next_row = parseInt($("#other_row_count").val()) + parseInt(1);
			   
				$("#other_row_count").val(next_row);
				safeUnblock("",""); 
           }
       
  }); 
}
function remove_other_row(no)
{
	$(".other_last_row"+no).remove();
	$("#other_row_count").val(($('.otherproducttable tr:last').attr("class").replace ( /[^\d.]/g, '' )))
}


$("#import_form").validate({
		rules: {
			import_file: {
				required: true
			}
		},
		messages: {
			import_file: {
				required: "Select CSV File"
			} 
		}
	});
$("#import_form").submit(function(event) {
	event.preventDefault();
	if(!$("#import_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	var url = root+'product/import_order';
	 
	$.ajax({
            type: "post",
            url: url,
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
				   safeUnblock("success","Sucessfully Imported.");
				   setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
				  
			 	}
				else if(obj.res==2)
				{
					safeUnblock("error","Worng File. Coloum Doesn't Match");
		 		}
				else if(obj.res==3)
				{
					safeUnblock("error","Worng File. Coloum Name Doesn't Match");
		 		}
				else if(obj.res==4)
				{
					safeUnblock("info","Some records having issue please check excel file");
					setTimeout(function(){ window.location=root+'excel_error/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
		 		}
				else if(obj.res==0)
				{
					safeUnblock("error","File Not Upload.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function import_excel()
{
	$("#excelModal").modal({
		backdrop: 'static',
		keyboard: false
	});

}
$("#wallproduct_form").validate({
		rules: {
			hsnc_code_val: 
			{
				required: true
			},
			product_details:
			{
				required:true
			},
			total_container:
			{
				required :true
		 	}
		},
		messages:{
			hsnc_code_val:
			{
				required: "Select Product Code"
			},
			product_details:
			{
				required:"Select Product Name"
			},
			total_container:
			{
				required :"Enter Container",
				max: "Check Your Container"
			}
		}
	});

$("#wallproduct_form").submit(function(event) {
	event.preventDefault();
	if(!$("#wallproduct_form").valid())
	{
		return false;
	}
	else if($("#Total_Amount").val()<=0)
	{
		toastr['error']('Please Enter Amount');
		return false;
	}
	block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url:  root+'product/wallmanage',
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
				    safeUnblock("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
				  
			   }
			   else if(obj.res==2)
			   {
				   $("#wallproduct_form").trigger('reset');
				   safeUnblock("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
					 
				}
				else if(obj.res==3)
				{
					setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
				}
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
			   }
			  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

 
function remove_wall_row(no)
{
	$(".last_row"+no).remove();
	$("#row_count").val(($('.walltable tr:last').attr("class").replace ( /[^\d.]/g, '' )))
}
 function add_wall_row()
{
	 $.ajax({ 
       type: "POST", 
       url: root+"product/add_wall_design_row",
       data: {
   		"row_count" : $("#row_count").val()
  	  }, 
       success: function (response) {
		 	 $(".last_row"+$("#row_count").val()).after(response);
			 var next_row = parseInt($("#row_count").val()) + parseInt(1);
			 $("#product_id"+next_row).val($("#product_id"+$("#row_count").val()).val()).trigger('change')
			 $("#box_design"+next_row).val($("#box_design"+$("#row_count").val()).val()).trigger('change')
			 $("#pallet_type"+next_row).val($("#pallet_type"+$("#row_count").val()).val()).trigger('change')
 				 $("#product_id"+next_row).select2({
					width:'element',
					dropdownAutoWidth  : true
				});
				 $("#walldesign_id"+next_row).select2({
					width:'element',
					dropdownAutoWidth  : true
				});
				 $("#wallfinish_id"+next_row).select2({
					width:'element',
					dropdownAutoWidth  : true
				});
				 $("#box_design"+next_row).select2({
					width:'element',
					dropdownAutoWidth  : true
				});
				 $("#pallet_type"+next_row).select2({
					width:'element',
					dropdownAutoWidth  : true
				});
				$("#row_count").val(next_row);
				safeUnblock("",""); 
           }
       
  }); 
}

function wallload_finish(design_id,val)
{  
	block_page();
	$("#finish_id"+val).html('<option value="">Select Finish</option>');
	var product_id =  $("#product_id"+val).val().split(' - ');
		$.ajax({ 
		type: "POST", 
		url: root+"product/load_finish_data",
		data: {
			"id"		 : design_id,
			"product_id" : product_id[0],
			"customer_id": <?=$invoicedata->consigne_id?> 
		}, 
		success: function (response) 
		{
			var obj = JSON.parse(response);
				$("#wallfinish_id"+val).html(obj.html);
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
				wallload_rate(val);
				safeUnblock("",""); 
			}
		
		}); 
	 
} 
function wallload_rate(val)
{
	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"product/load_rate",
       data:
	   {
			"consigne_id"	: <?=$invoicedata->consigne_id?>, 
			"design_id"		: $("#walldesign_id"+val).val() ,
			"finish_id"		: $("#wallfinish_id"+val).val(),
			"product_id"	: $("#product_id"+val).val() 
		}, 
       success: function (response) 
	   {
			 var obj = JSON.parse(response);
			   $("#product_rate"+val).val((obj.design_rate == null)?0:parseFloat(obj.design_rate).toFixed(2))
			    
				$("#product_rate_per"+val).val((obj.product_rate_per == null)?"SQM":obj.product_rate_per)
				cal_wallproduct_invoice(val)
			safeUnblock("",""); 
           }
       
  }); 
}  
function cal_wallproduct_invoice(val)
{
	
	 var radioValue = $("input[name='pallet_status"+val+"']:checked").val();
   	 if(radioValue==1)
	 {
	 	var boxes_per_pallet 	= $('#boxes_per_pallet'+val).val();
		var pallet_weight 		= $('#pallet_weight'+val).val();
		var weight_per_box 		= $('#weight_per_box'+val).val();
		var sqm_per_box 		= $('#sqm_per_box'+val).val();
		var feet_per_box 		= $('#feet_per_box'+val).val();
		var pcs_per_box 		= $('#pcs_per_box'+val).val();
		
			if($('#no_of_pallet'+val).val() != undefined && $('#no_of_pallet'+val).val() != "" )
			{
				var rate_usd_val 			= $('#product_rate'+val).val();
				var product_rate_per 	 	= $('#product_rate_per'+val).val();
				var no_of_pallet 			= $('#no_of_pallet'+val).val();
				var total_pallet 			= ($("#no_of_pallet"+val).val()>0)?$("#no_of_pallet"+val).val():0;
			 	var no_of_boxes 			= total_pallet * boxes_per_pallet;
				$('#no_of_boxes'+val).val(no_of_boxes);
				var no_of_sqm 				= no_of_boxes * sqm_per_box;
				 
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				} 
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var palletweight 			= total_pallet * pallet_weight;
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
		 	}
	 }
	 else if(radioValue==2)
	 {
		 var weight_per_box = $('#weight_per_box'+val).val();
		 var sqm_per_box 	= $('#sqm_per_box'+val).val();
		  var feet_per_box 		= $('#feet_per_box'+val).val();
		  var pcs_per_box 		= $('#pcs_per_box'+val).val();
			if($('#only_no_of_boxes'+val).val() != undefined && $('#only_no_of_boxes'+val).val() != "")
			{
				var no_of_boxes = $("#only_no_of_boxes"+val).val();
				var rate_usd_val = $('#product_rate'+val).val();
				var product_rate_per 	 	= $('#product_rate_per'+val).val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				if(product_rate_per == "SQM")
				{
					var product_total_amount = rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
				
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
			 	$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
			}
	 } 
	 else if(radioValue==3)
	 {
		 var weight_per_box = $('#weight_per_box'+val).val();
		 var box_per_big_pallet = $('#box_per_big_pallet'+val).val();
		 var box_per_small_pallet = $('#box_per_small_pallet'+val).val();
		 var big_pallet_weight = $('#big_pallet_weight'+val).val();
		 var small_pallet_weight = $('#small_pallet_weight'+val).val();
		 var sqm_per_box = $('#sqm_per_box'+val).val();
		  var feet_per_box 		= $('#feet_per_box'+val).val();
		  var pcs_per_box 		= $('#pcs_per_box'+val).val();
		  	var product_rate_per 	 	= $('#product_rate_per'+val).val();
		  var rate_usd_val 		= $('#product_rate'+val).val();
				var no_of_big_pallet 	= $('#no_of_big_pallet'+val).val();
				var no_of_small_pallet 	= $('#no_of_small_pallet'+val).val();
				
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				  
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+val).val(no_of_boxes);
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				if(product_rate_per == "SQM")
				{
					var product_total_amount = rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
				
				 
				
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				
				var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
	}
	 
}
function wallload_data(product_id,no)
{  
	if(product_id != "")
	{
		block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/wall_design_data",
		data: 
		{
			"id" 			: product_id, 
			"customer_id" 	: <?=$invoicedata->consigne_id?>
		}, 
		success: function (response)
		{
				var obj= JSON.parse(response);
				$("input[name=pallet_status"+no+"][value=" + obj.pallet_status + "]").prop('checked', true);
				$("#walldesign_id"+no).html(obj.design_data);
				$("#sqm_per_box"+no).val(obj.sqm_per_box);
				$("#pcs_per_box"+no).val(obj.pcs_per_box);
				$("#feet_per_box"+no).val(obj.feet_per_box);
				$("#pallet_weight"+no).val(obj.pallet_weight);
				$("#weight_per_box"+no).val(obj.weight_per_box);
				$("#boxes_per_pallet"+no).val(obj.boxes_per_pallet);
				$("#box_per_big_pallet"+no).val(obj.box_per_big_pallet);
				$("#box_per_small_pallet"+no).val(obj.box_per_small_pallet);
				$("#no_of_pallet"+no).val(obj.no_of_pallet);
				$("#no_of_big_pallet"+no).val(obj.no_of_big_pallet);
				$("#no_of_small_pallet"+no).val(obj.no_of_small_pallet);
				$("#no_of_boxes"+no).val(obj.total_box_per_container);
				$("#only_no_of_boxes"+no).val(obj.total_box_per_container);
				$("#no_of_sqm"+no).val(obj.sqm_per_container);
				$("#pallet_type"+no).val(obj.pallet_type_id).trigger('change');
				$("#box_design"+no).val(obj.box_design_id).trigger('change');
			 	wallcheck_pallet_status(obj.pallet_status,no)
				safeUnblock("",""); 
			}
		}); 
	}
	else
	{
		$("#productdetail").html('');
	}
}   
function wallcheck_pallet_status(pallet_status,no)
{
	if(pallet_status==1)
	 {
	 	$(".multi_pallet_calcution"+no).hide();
		$(".boxes_calculation"+no).hide();
	 	$(".pallet_calcution"+no).show();
	 	 
	 }
	 else if(pallet_status==2)
	 {
	 	$(".pallet_calcution"+no).hide();
	 	$(".multi_pallet_calcution"+no).hide();
	 	$(".boxes_calculation"+no).show();
	  
	}
	else if(pallet_status == 3)
	{
		$(".pallet_calcution"+no).hide();
	 	$(".boxes_calculation"+no).hide();
	 	$(".multi_pallet_calcution"+no).show();
  	}
}
function cal_wallbox_invoice(val)
{
	 var radioValue = $("input[name='pallet_status"+val+"']:checked").val();
   
	 if(radioValue==1)
	 {
	 	var boxes_per_pallet 		= $('#boxes_per_pallet'+val).val();
		var pallet_weight 			= $('#pallet_weight'+val).val();
		var weight_per_box 			= $('#weight_per_box'+val).val();
		var sqm_per_box 			= $('#sqm_per_box'+val).val();
		var feet_per_box 			= $('#feet_per_box'+val).val();
		var pcs_per_box 			= $('#pcs_per_box'+val).val();
		var product_rate_per 	 	= $('#product_rate_per'+val).val();
		var no_of_boxes 			= $('#no_of_boxes'+val).val();
		var no_of_sqm 				= no_of_boxes * sqm_per_box;
		var rate_usd_val 			= $('#product_rate'+val).val();
		var total_pallet 	 		= $('#no_of_pallet'+val).val()		
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		
		if(product_rate_per == "SQM")
		{
			var product_total_amount 	= rate_usd_val * no_of_sqm;
		}
		else if(product_rate_per == "BOX")
		{
			var product_total_amount 	= rate_usd_val * no_of_boxes;
		}
		else if(product_rate_per == "SQF")
		{
			var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
		}
		else if(product_rate_per == "PCS")
		{
			var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
		}
		$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		var palletweight 			= total_pallet * pallet_weight;
		var packing_net_weight 		= weight_per_box * no_of_boxes;
		var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
		
		$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
		$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
	 }
	 else if(radioValue==2)
	 {
		 var weight_per_box 	= $('#weight_per_box'+val).val();
		 var sqm_per_box 		= $('#sqm_per_box'+val).val();
		 var feet_per_box 		= $('#feet_per_box'+val).val();
		var pcs_per_box 		= $('#pcs_per_box'+val).val(); 
		 
			if($('#only_no_of_boxes'+val).val() != undefined && $('#only_no_of_boxes'+val).val() != "")
			{
				var no_of_boxes 	= $("#only_no_of_boxes"+val).val();
				var rate_usd_val 	= $('#product_rate'+val).val();
				var no_of_sqm 		= no_of_boxes * sqm_per_box;
				var product_rate_per 	 	= $('#product_rate_per'+val).val();
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
				 
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
			 	$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
			}
		 
		 
	 } 
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box'+val).val();
		 var box_per_big_pallet 	= $('#box_per_big_pallet'+val).val();
		 var box_per_small_pallet	= $('#box_per_small_pallet'+val).val();
		 var big_pallet_weight 		= $('#big_pallet_weight'+val).val();
		 var small_pallet_weight 	= $('#small_pallet_weight'+val).val();
		 var sqm_per_box 			= $('#sqm_per_box'+val).val();
		 var feet_per_box 			= $('#feet_per_box'+val).val();
		 var pcs_per_box 			= $('#pcs_per_box'+val).val();
		 
		 	if($('#no_of_big_pallet'+val).val() != undefined && $('#no_of_big_pallet'+val).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+val).val();
				var no_of_big_pallet = $('#no_of_big_pallet'+val).val();
				var no_of_small_pallet = $('#no_of_small_pallet'+val).val();
				
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+val).val(no_of_boxes);
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
		
			 
				
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				
				var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
		 	}
		 
		 
	 }
}
function open_product()
{
	$("#wallproduct").modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#product_id1").select2({
		width:'element',
		dropdownAutoWidth  : true
	});
}
function close_modal()
{

	$("#product_form").trigger('reset');
	$("#product_details").val('').trigger('change')
	$("#performa_trn_id").val('')
	location.reload();
}
  
$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
function load_data(product_id,mode,deletestatus,check_production_sheet)
{  
	if(product_id != "")
	{
		block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/load_design_data",
		data: {
				"id"				: product_id,
				"mode" 				: mode,
				"performa_trn_id" 	: $("#performa_trn_id").val(),
				"customer_id" 		: <?=$invoicedata->consigne_id?>,
				"deletestatus" 		: deletestatus,
				"check_production_sheet" 		: check_production_sheet,
		}, 
		success: function (response) {
				$("#productdetail").html(response);
				$('#product_size_id').select2({ width:"element"});
					if(check_production_sheet == 1)
					{
						$('.select2').prepend('<div class="disabled-select"></div>');
					}
					 
				if($("#product_size_id").val()	!= "")
				{
					load_packing($("#product_size_id").val(),mode,deletestatus,check_production_sheet)
				}				
				safeUnblock("",""); 
			}
		
	}); 
	}
	else
	{
		$("#productdetail").html('');
	}
}  
function load_packing(product_size_id,mode,deletestatus,check_production_sheet)
{  
if(product_size_id != "")
{
  	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"product/load_packing",
       data: {
  		"product_size_id"	: product_size_id,
		"mode" 				: mode,
		"performa_trn_id" 	: $("#performa_trn_id").val(),
		"customer_id" 		: <?=$invoicedata->consigne_id?>,
		"deletestatus" 		: deletestatus,
		"no" 				: <?=$no?>,
		"check_production_sheet" 		: check_production_sheet
  	  }, 
       success: function (response) {
		 	$(".packing_detail").html(response);
			 
			check_pallet_status($("input[name='pallet_status']:checked").val())
			$(".tooltips").tooltip();
			$('#container_check').bootstrapToggle();
			 $('.select1').select2({ width:"element"});
			 if(check_production_sheet == 1)
					{
						$('.select2').prepend('<div class="disabled-select"></div>');
					}
					 
		 	safeUnblock("",""); 
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
			"customer_id": <?=$invoicedata->consigne_id?>
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
				safeUnblock("",""); 
			}
		
	}); 
	}
} 
function load_rate(val)
{
	block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/designrate",
		data:
		{
			"consigne_id"	 	: <?=$invoicedata->consigne_id?>,
			"product_id"		: $("#product_details").val(),
			"packing_model_id"	: $("#design_id"+val).val(),
			"product_rate_per"	: $("#product_rate_per"+val).val(),
			"finish_id"			: $("#finish_id"+val).val(),
		}, 
		success: function (response) {
				 
			var obj = JSON.parse(response);
				 
				if(obj.rate_data != null && obj.rate_data != 0)
				{
				 	$("#product_rate_per"+val).val((obj.rate_data.product_rate_per != null)?obj.rate_data.product_rate_per:"SQM");
					$("#product_rate"+val).val(parseFloat(obj.rate_data.design_rate).toFixed(2));
				}
				else
				{
					$("#product_rate_per"+val).val('SQM');
					$("#product_rate"+val).val(0);
				}
				 
				if(obj.designe_data != null && obj.designe_data != 0)
				{
				 	$("#client_name"+val).val(obj.designe_data.cust_design_name);
					$("#barcode_no"+val).val(obj.designe_data.barcode_no);
				}
				else
				{
					$("#client_name"+val).val('');
					$("#barcode_no"+val).val('');
				}
				cal_product_trn(val)
				cal_all_total(0)
				safeUnblock("",""); 
			}
		
	}); 
}  
$("#model_add").validate({
		rules: {
			model_name: {
				required: true
			}
		},
		messages: {
			model_name: {
				required: "Enter Design Name"
			} 
		}
	});
$("#model_add").submit(function(event) {
	event.preventDefault();
	if(!$("#model_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	postData.append("product_id",$("#productid").val());
	var string = $("#model_name").val();
	 
		var url = root+'model_list/manage';
	 
	$.ajax({
            type: "post",
            url: url,
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
				   safeUnblock("success","Sucessfully Inserted.");
				   $("#design_id"+$("#row_no").val()).append('<option value="'+obj.packing_model_id+'">'+obj.model_name+'</option>');
				   $("#design_id"+$("#row_no").val()).val(obj.packing_model_id).trigger('çhange');
				    $("#finish_id").val('').trigger('change');
				    $("#modeltype").modal('hide');
					 $("#model_add").trigger('reset')
					load_finish(obj.packing_model_id,$("#row_no").val())
				}
				else if(obj.res==2)
				{
					safeUnblock("info","Already Added.");
					 
				 	$("#design_id"+$("#row_no").val()).val(obj.packing_model_id).trigger('çhange');
				      $("#modeltype").modal('hide');
					 $("#model_add").trigger('reset');
					  load_finish(obj.packing_model_id,$("#row_no").val())
				}
				else
				{
					safeUnblock("error","Something Wrong.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 
function add_row()
{
	 $.ajax({ 
       type: "POST", 
       url: root+"product/add_design_row",
       data: {
  		"design_id"		: $("#design_id"+$("#row_cont").val()).val(),
  		"finish_id"		: $("#finish_id"+$("#row_cont").val()).val(),
  		"product_id"	: $("#product_details").val(),
		"consigne_id"	: <?=$invoicedata->consigne_id?>,
  		"no"			: $("#row_cont").val() 
  	  }, 
       success: function (response) {
		   	 $(".appendtr"+$("#row_cont").val()).after(response);
			 var next_row = parseInt($("#row_cont").val()) + parseInt(1);
			  $("#no_of_pallet"+next_row).val( $("#no_of_pallet"+$("#row_cont").val()).val() )
			  $("#no_of_big_pallet"+next_row).val( $("#no_of_big_pallet"+$("#row_cont").val()).val() )
			  $("#no_of_small_pallet"+next_row).val( $("#no_of_small_pallet"+$("#row_cont").val()).val() )
			  $("#pallet_type_id"+next_row).val( $("#pallet_type_id"+$("#row_cont").val()).val() )
			  $("#box_design_id"+next_row).val( $("#box_design_id"+$("#row_cont").val()).val() )
			  
				$(".select1").select2({
					width:'element'
				});
			$("#row_cont").val(next_row);
			check_pallet_status($("input[name='pallet_status']:checked").val())
			safeUnblock("",""); 
           }
       
  }); 
}
function remove_row(no)
 {
		if($('.rate_table tr').length > 3)
		{
			$(".appendtr"+no).remove();
			$("#row_cont").val(($('.rate_table tr:last').prev().attr("class").replace( /[^\d.]/g, '')))
			cal_product_invoice();
		}
		else
		{
			toastr["error"]("Last design can not delete.");
			return false;
		}
	 
 }
invoice_cal() 
function invoice_cal() 
{
	var total_amount = $('#total_amount').val();
    var certification_charge = ($('#certification_charge').val()=="" || $('#certification_charge').val()==undefined)?0:$('#certification_charge').val();
    var insurance_charge =($('#insurance_charge').val()=="" || $('#insurance_charge').val()==undefined)?0:$('#insurance_charge').val();
    var seafright_charge = ($('#seafright_charge').val()=="" || $('#seafright_charge').val()==undefined)?0:$('#seafright_charge').val();
    var discount = ($('#discount').val()=="")?0:$('#discount').val();
	
	 
	var calculation_operator = $("#calculation_operator").val();
	var extra_calc_amt = ($('#extra_calc_amt').val()=="" || $('#extra_calc_amt').val()== undefined)?0:$('#extra_calc_amt').val();
	var extra_calc_opt =  $("#extra_calc_opt").val();
	var final_total = 0;
	if(calculation_operator == 1)
	{
		 final_total = parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge)  - parseFloat(discount);
	 	final_total += parseFloat(seafright_charge); 
	 
	}
	else
	{ 
		 final_total = parseFloat(total_amount) - parseFloat(certification_charge) - parseFloat(insurance_charge)  - parseFloat(discount);
	 
		final_total -= parseFloat(seafright_charge); 
	}
	 
	if(extra_calc_opt == 1)
	{
		final_total = parseFloat(final_total) + parseFloat(extra_calc_amt);
	}
	else
	{
		final_total = parseFloat(final_total) -  parseFloat(extra_calc_amt);		
	}
	 	 
	if(parseFloat(discount)>(parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge) + parseFloat(seafright_charge)))
	{
		$('#discount').focus();
		$('#discount_error').html('Not Vaild');
		$('#final_total').html(0);
		return false;
	}
	var courier_charge 	= ($("#courier_charge").val() > 0)?$("#courier_charge").val():0;
	var bank_charge 	= ($("#bank_charge").val() > 0)?$("#bank_charge").val():0;
	
	final_total += parseFloat(courier_charge);
	final_total += parseFloat(bank_charge);
	
	var igst_per_value 	= ($("#igst_per_value").val() > 0)?$("#igst_per_value").val():0;
	var sgst_per_value 	= ($("#sgst_per_value").val() > 0)?$("#sgst_per_value").val():0;
	var cgst_per_value 	= ($("#cgst_per_value").val() > 0)?$("#cgst_per_value").val():0;
	 
	var igst_value = parseFloat(final_total) * parseFloat(igst_per_value) / 100;
	$('#igst_value_html').html(parseFloat(igst_value).toFixed(2));
	$('#igst_value').val(parseFloat(igst_value).toFixed(2));
	
	var cgst_value = parseFloat(final_total) * parseFloat(cgst_per_value) / 100;
	$('#cgst_value_html').html(parseFloat(cgst_value).toFixed(2));
	$('#cgst_value').val(parseFloat(cgst_value).toFixed(2));
	
	var sgst_value = parseFloat(final_total) * parseFloat(sgst_per_value) / 100;
	$('#sgst_value_html').html(parseFloat(sgst_value).toFixed(2));
	$('#sgst_value').val(parseFloat(sgst_value).toFixed(2));
	
	final_total += parseFloat(igst_value);
	final_total += parseFloat(cgst_value);
	final_total += parseFloat(sgst_value);
	
	$('#discount_error').html('');
	$('#final_total').html(parseFloat(final_total).toFixed(2));
	$('#final_total_val').val(parseFloat(final_total).toFixed(2));
}         
  
</script>
<script>

// Global helper function to safely unblock page - works even if unblock_page is not defined
function safeUnblock(type, msg) {
	if(typeof unblock_page === 'function') {
		unblock_page(type, msg);
	} else if(typeof $.unblockUI === 'function') {
		// Fallback to direct jQuery unblockUI
		if(type !== "" && msg !== "") {
			if(typeof toastr !== 'undefined') {
				toastr[type](msg);
			}
		}
		setTimeout(function(){ $.unblockUI(); }, 500);
	} else {
		// Last resort: just show message if toastr is available
		if(typeof toastr !== 'undefined' && type !== "" && msg !== "") {
			toastr[type](msg);
		}
	}
}

function check_product(step)
{
	 if(<?=count($product_data)?> == 0)
	{
		$(".errormsg").html('Please enter aleast one product.');
		toastr["error"]("Please enter aleast one product.");
	}
	else{
		//var inps = document.getElementsByName('rate_in_per[]');
		//var per_name1 = new Array();
		//for (var i = 0; i <inps.length; i++) 
		//{
		//	per_name1.push(inps[i].value);
		//}
		//var array = new Set(per_name1).size === 1;
		//if(array == false)
		//{
		//	toastr['error']('Please Check Rate Unit. It Must be same.');
		//	return false;
		//}
		update_calc(step,0);
		safeUnblock("success","Sucessfully Updated.");
		 if(<?=$check_production_sheet?> == 1)
		{
			 setTimeout(function(){ window.location='<?php echo base_url();?>performa_invoice_pdf/index/<?=$invoicedata->performa_invoice_id ?>'; },1000);
		}
		else
		{
		 setTimeout(function(){ window.location='<?php echo base_url();?>addition_details/index/<?=$invoicedata->performa_invoice_id ?>'; },1000);
		}
	}
}
function delete_product(performa_trn_id)
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
			// Safe block_page wrapper
			if(typeof block_page === 'function') {
				block_page();
			} else if(typeof $.blockUI === 'function') {
				$.blockUI({ css: { 
					border: 'none', 
					padding: '0px', 
					width: '17%',
					left:'43%',
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff', 
					zIndex: '10000'
				},
				message	:  '<h3> Please wait...</h3>'	});
			}
			  $.ajax({ 
              type: "POST", 
              url: root+'product/deleterecord',
              data: {
                "id": performa_trn_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					updateinvoice(<?=$invoicedata->performa_invoice_id?>);
					safeUnblock('success',"Record Successfully Deleted");
					 setTimeout(function(){ window.location=root+'product/index/<?=$invoicedata->performa_invoice_id?>'; },1500);
				}
                else{
					safeUnblock('error',"Somthing Wrong.")
				}
              }
			});
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
              url: root+'product/make_container_delete',
              data: {
                "id": id,
				"invoice_id" : <?=$invoicedata->performa_invoice_id?>
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					updateinvoice(<?=$invoicedata->performa_invoice_id?>);
					safeUnblock('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'product/index/<?=$invoicedata->performa_invoice_id?>'; },1500);
				}
                else{
					safeUnblock('error',"Somthing Wrong.")
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
              url:  root+"product/updateinvoice",
              data: {
                "invoice_id": invoice_id
				}, 
              cache: false, 
              success: function (data) { 
				 safeUnblock("","");
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
	 cal_all_total(1)
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
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 var no_of_pallet 		= $('#no_of_pallet'+d).val();
		 var per_value	 		= $('#per'+d).val();
	 	 var total_pallet 		= ($("#no_of_pallet"+d).val()>0)?$("#no_of_pallet"+d).val():0;
		 var no_of_boxes 		= $('#no_of_boxes'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();  
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		 
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
		  $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
		  
		 var palletweight = total_pallet * pallet_weight;
		 var packing_net_weight 		= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
	 }
	 else if(radioValue==3)
	 {
			var weight_per_box = $('#weight_per_box').val();
			var per_value	 		= $('#per'+d).val();
			var box_per_big_pallet = $('#box_per_big_pallet').val();
			var box_per_small_pallet = $('#box_per_small_pallet').val();
			var big_pallet_weight = $('#big_pallet_weight').val();
			var small_pallet_weight = $('#small_pallet_weight').val();
			var sqm_per_box = $('#sqm_per_box').val();
			var rate_usd_val = $('#product_rate'+d).val();
			var no_of_big_pallet = $('#no_of_big_pallet'+d).val();
			var no_of_small_pallet = $('#no_of_small_pallet'+d).val();
			 var feet_per_box 		= $('#feet_per_box').val();
			 var pcs_per_box 		= $('#pcs_per_box').val();
			var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
			 var product_rate_per 	= $('#product_rate_per'+d).val();  
			 
			var no_of_boxes = $('#no_of_boxes'+d).val();
			
			 
			var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
			
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
				
			 
			$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
			var big_palletweight = no_of_big_pallet * big_pallet_weight;
			var small_palletweight = no_of_small_pallet * small_pallet_weight;
			
			var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
			var packing_net_weight 		= weight_per_box * no_of_boxes;
			var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
			
			$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
			$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
	 }
	 else if(radioValue==2)
	 {
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var no_of_boxes 		= $('#no_of_boxes'+d).val();
		 var rate_usd_val		= $('#product_rate'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();  
			
		 var weight_per_box 	= $('#weight_per_box').val();
		 var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
			 
			
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
			   $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	=  parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
			
	 }
		cal_all_total(1)
}
function change_container()
{
	if($('#container_check').prop("checked") == true)
	{
		$("#total_container").attr("readonly",false);
		 
		  
		 $("#total_container").show();
		 
			var total_container = $("#total_container").val();
			var total_boxes = $("#Boxes").val();
			var Plts = $('#boxes_per_pallet').val();
			total_pallet = $('#pallet_in_container').val() * total_container;
			var total_big_pallet = $('#big_pallet_in_container').val() * total_container;
			var total_small_pallet = $('#small_pallet_in_container').val() * total_container;
			total_boxes = total_boxes * total_container;
			
			$("#Plts").val(Plts);
			$("#total_pallet").val(total_pallet);
			$("#total_big_pallet").val(total_big_pallet);
			$("#total_small_pallet").val(total_small_pallet);
			 
		 	//cal_product_invoice('<?=$invoicedata->currency?>');
			
	}
	else	
	{
		$("#total_container").attr("readonly",true);
		 
		$("#total_container").hide();
			var total_container = 0;
			var total_boxes = 0;
			total_pallet = 0;
			total_boxes = 0;
			$("#total_pallet").val($("#pallet_in_container").val());
			 
			//cal_product_invoice('<?=$invoicedata->currency?>');
	} 
	 
}
function cal_product_invoice(d)
{
	 
	 var radioValue 	 = $("input[name='pallet_status']:checked"). val();
	 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	 
	 if(radioValue==1)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var pallet_weight 		= $('#pallet_weight').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 var agent_rate_usd_val 		= $('#agent_product_rate'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();
		 var no_of_pallet 		= $('#no_of_pallet'+d).val();
	 	 var total_pallet 		= ($("#no_of_pallet"+d).val()>0)?$("#no_of_pallet"+d).val():0;
		  
		 
		 var no_of_boxes = total_pallet * boxes_per_pallet;
		 $('#no_of_boxes'+d).val(no_of_boxes);
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		
		 var palletweight = total_pallet * pallet_weight;
		
		 var packing_net_weight 		= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
		
		 if(product_rate_per == "SQM")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 }
		 else if(product_rate_per == "BOX")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(product_rate_per == "SQF")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(product_rate_per == "PCS")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
		 } 
		 
		 // for agent 
		 if(product_rate_per == "SQM")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_sqm;
		 }
		 else if(product_rate_per == "BOX")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(product_rate_per == "SQF")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(product_rate_per == "PCS")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_boxes * pcs_per_box;
		 }
		
		$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		$('#agent_product_amt'+d).val((agent_product_total_amount>0)?(agent_product_total_amount.toFixed(2)):0);
		  
	 }
	 else if(radioValue==2)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 var agent_rate_usd_val 		= $('#agent_product_rate'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();
		   
		 
		 var no_of_boxes =  $('#no_of_boxes'+d).val();
		 
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		
		  var packing_net_weight 		= weight_per_box * no_of_boxes;
		  var packing_gross_weight 		=  parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
		
		 if(product_rate_per == "SQM")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 }
		 else if(product_rate_per == "BOX")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(product_rate_per == "SQF")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(product_rate_per == "PCS")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
		 } 
		 
		 //agent 
		 if(product_rate_per == "SQM")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_sqm;
		 }
		 else if(product_rate_per == "BOX")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(product_rate_per == "SQF")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(product_rate_per == "PCS")
		 {
			 var agent_product_total_amount = parseFloat(agent_rate_usd_val) * no_of_boxes * pcs_per_box;
		 }
		
		$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		$('#agent_product_amt'+d).val((agent_product_total_amount)?(product_total_amountagent_product_total_amounttoFixed(2)):0);
		  
	 }
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box').val();
		  var per_value	 			= $('#per'+d).val(); 
		 var box_per_big_pallet 	= $('#box_per_big_pallet').val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet').val();
		 var big_pallet_weight 		= $('#big_pallet_weight').val();
		 var small_pallet_weight 	= $('#small_pallet_weight').val();
		 var sqm_per_box 			= $('#sqm_per_box').val();
		 var feet_per_box 			= $('#feet_per_box').val();
		 var pcs_per_box 			= $('#pcs_per_box').val();
		 
		var total_no_of_pallet = 0;
		var total_no_of_boxes = 0;
		var total_no_of_sqm = 0;
		var total_product_amt = 0;
		var total_gross_weight = 0;
		var total_net_weight = 0;
		var total_pallet_weight = 0;
		var no =1;
		 
				var rate_usd_val 		= $('#product_rate'+d).val();
				var no_of_big_pallet 	= $('#no_of_big_pallet'+d).val();
				var no_of_small_pallet 	= $('#no_of_small_pallet'+d).val();
				var product_rate_per 	= $('#product_rate_per'+d).val();
		 
		 
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+d).val(no_of_boxes);
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				
				 if(product_rate_per == "SQM")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
					
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
				}
					

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
function cal_product_trn(no)
{
	cal_product_invoice(no)
}
function add_value(check,val,no_of_row,grossweight,netweight)
{
	if(check==true)
	{
		$("#make_container_array").val($("#make_container_array").val()+","+val)
		$("#gross_weight_array").val($("#gross_weight_array").val()+","+grossweight)
		$("#net_weight_array").val($("#net_weight_array").val()+","+netweight)
		var already = (parseInt($("#no_of_row").val())>0)?parseInt($("#no_of_row").val()):0;
		$("#no_of_row").val(parseInt(already)+parseInt(no_of_row))
	}
	else
	{
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
				  url: root+"product/make_container_fun",
				  data: { 
							"allvalues[]"		: filtered.toString(),
							"grossweight"		 : grossweight.toString(),
							"netweight"		 	 : netweight.toString(),
							"performainvoice_id":$("#performainvoice_id").val(),
							"cnt":cnt,
							"no_of_row":$("#no_of_row").val()
					}, 
				  success: function (response) { 
					   $("#make_container_array").val(0)
						safeUnblock("success","Sucessfully Done.");
						update_calc(<?=$invoicedata->step?>,0)						
						setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
						
					  }
				  
			  }); 
 
}
function cal_all_total(val)
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
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			  
			 var product_rate_per 	= $('#product_rate_per'+d).val();
					
			if($('#no_of_pallet'+d).val() != undefined && $('#no_of_pallet'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				if(val == 1)
				{
					var no_of_boxes = $('#no_of_boxes'+d).val();
				}
				else
				{
					var no_of_boxes = $('#no_of_pallet'+d).val() * boxes_per_pallet;
					$('#no_of_boxes'+d).val(no_of_boxes);
				}
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				if(product_rate_per == "SQM")
				{
						var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
					
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
				}
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
				total_no_of_pallet	 += parseFloat($("#no_of_pallet"+d).val());
				total_no_of_boxes	 += (no_of_boxes>0)?parseFloat(no_of_boxes):0;
				 
				total_no_of_sqm 	 += parseFloat(no_of_sqm);
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;
			}
		}
		$('#total_no_of_pallet').val(total_no_of_pallet);
		$('#total_no_of_boxes').val(total_no_of_boxes);
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 var pallet_weight 		= $('#pallet_weight').val(); 
		 var total_pallet_weight = total_no_of_pallet * pallet_weight;
		 var total_net_weight 	= weight_per_box * total_no_of_boxes;
		 var total_gross_weight 	= parseFloat(total_net_weight) + parseFloat(total_pallet_weight);
		$('#Pallet_Weight_html').html(total_pallet_weight);
		$('#total_pallet_weight').val(total_pallet_weight);
		
	 	$('#total_net_weight').val(total_net_weight.toFixed(2));
	 	$('#total_gross_weight').val(total_gross_weight.toFixed(2));
	 }
	 else if(radioValue==2)
	 {
		 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
	 	 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			  
			 var product_rate_per 	= $('#product_rate_per'+d).val();
					
			if($('#no_of_boxes'+d).val() != undefined && $('#no_of_boxes'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				var no_of_boxes = $('#no_of_boxes'+d).val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				if(product_rate_per == "SQM")
				{
						var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
					
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
				}
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
			 	total_no_of_boxes	 += parseFloat($('#no_of_boxes'+d).val());
				total_no_of_sqm 	 += parseFloat($('#no_of_sqm'+d).val());
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;
			}
		}
		$('#total_no_of_pallet').val(0);
		$('#total_no_of_boxes').val(total_no_of_boxes);
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 
		  
		 var total_net_weight 	= weight_per_box * total_no_of_boxes;
		 var total_gross_weight 	= parseFloat(total_net_weight);
		$('#Pallet_Weight_html').html(0);
		$('#total_pallet_weight').val(0);
		
	 	$('#total_net_weight').val(total_net_weight.toFixed(2));
	 	$('#total_gross_weight').val(total_gross_weight.toFixed(2));
	 }
	 else if(radioValue==3)
	 {
		  
		 var box_per_big_pallet 	= $('#box_per_big_pallet').val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet').val();
		 var big_pallet_weight 		= $('#big_pallet_weight').val();
		 var small_pallet_weight 	= $('#small_pallet_weight').val();
		 var sqm_per_box 			= $('#sqm_per_box').val();
	 	var total_no_of_pallet 		= 0;
		var total_no_of_boxes 		= 0;
		var total_no_of_sqm 		= 0;
		var total_product_amt		= 0;
		var total_gross_weight 		= 0;
		var total_net_weight 		= 0;
		var total_pallet_weight 	= 0;
		var no =1;
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			if(($('#no_of_big_pallet'+d).val() != undefined && $('#no_of_big_pallet'+d).val() != "") || ($('#no_of_small_pallet'+d).val() != undefined && $('#no_of_small_pallet'+d).val() != ""))
			{
				
				var rate_usd_val = $('#product_rate'+d).val();
				var no_of_big_pallet 	= ($('#no_of_big_pallet'+d).val()>0)?$('#no_of_big_pallet'+d).val():0;
				var no_of_small_pallet 	= ($('#no_of_small_pallet'+d).val()>0)?$('#no_of_small_pallet'+d).val():0;
				 
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
		 
		$('#total_no_of_pallet').val(total_no_of_pallet);
		$('#total_no_of_boxes').val(total_no_of_boxes);
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
	 	$('#Pallet_Weight_html').html(total_pallet_weight);
		$('#total_pallet_weight').val(total_pallet_weight);
	 	$('#total_net_weight').val(total_net_weight.toFixed(2));
	 	$('#total_gross_weight').val(total_gross_weight.toFixed(2));
	 }
}  
 
$(".select2").select2({
	width:'100%'
});
$(".select1").select2({
	width:'element'
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
function update_calc(step,val)
{
	 // Safe block_page wrapper
	 if(typeof block_page === 'function') {
		 block_page();
	 } else if(typeof $.blockUI === 'function') {
		 $.blockUI({ css: { 
			 border: 'none', 
			 padding: '0px', 
			 width: '17%',
			 left:'43%',
			 backgroundColor: '#000', 
			 '-webkit-border-radius': '10px', 
			 '-moz-border-radius': '10px', 
			 opacity: .5, 
			 color: '#fff', 
			 zIndex: '10000'
		 },
		 message	:  '<h3> Please wait...</h3>'	});
	 }
	   $.ajax({ 
             type: "POST",
			 async: false,			 
             url: root+"product/update_profoma",
             data: {
						"performainvoice_id"	: $("#performainvoiceid").val(),
						"certification_charge"	: $("#certification_charge").val(),
						"calculation_operator"	: $("#calculation_operator").val(),
						"insurance_charge"		: $("#insurance_charge").val(),
						"seafright_charge"		: $("#seafright_charge").val(),
						"seafright_action"		: $("#seafright_action").val(),
						"igst_per_value"		: $("#igst_per_value").val(),
						"sgst_per_value"		: $("#sgst_per_value").val(),
						"cgst_per_value"		: $("#cgst_per_value").val(),
						"igst_value"		  	: $("#igst_value").val(),
						"sgst_value"		  	: $("#sgst_value").val(),
						"cgst_value"		  	: $("#cgst_value").val(),
						"discount"		  		: $("#discount").val(),
						"courier_charge"  		: $("#courier_charge").val(),
						"bank_charge"	  		: $("#bank_charge").val(),
						"extra_calc_name"	  	: $("#extra_calc_name").val(),
						"extra_calc_opt"	  	: $("#extra_calc_opt").val(),
						"extra_calc_amt"	  	: $("#extra_calc_amt").val(),
						"grand_total"	  		: $("#final_total_val").val(),
						"agent_grand_total"	  		: $("#agent_final_total_val").val(),
						"pallet_status"	  		: $("#pallet_status").val(),
						"step"			  		: step,
						"per_value"			    : $("#per_value").val(),
						"special_requirment"	: $("#special_requirment").val(),
						"note"			  		: $("#note").val(),
						"invoicevalue_say"		: $("#invoicevalue_say").val()
						
					}, 
					success: function (response) { 
					if(val == 1)	 
					{
						setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
					}
					
					safeUnblock("","");
                 },
				 error: function(jqXHR, textStatus, errorThrown) {
					console.log('AJAX Error:', errorThrown);
					console.log('Response Text:', jqXHR.responseText);
					// Unblock page even on error
					safeUnblock("error","An error occurred. Please try again.");
				}
             
         }); 
}
$(window).bind("load", function() {
   update_calc(<?=$invoicedata->step?>,0)
});
$("#product_form").submit(function(event) {
	event.preventDefault();
	 
	 if(!$("#product_form").valid())
	{
		return false;
	}
	else if($("#total_product_amt").val()<=0)
	{
		toastr['error']('Please Enter Amount');
		return false;
	}
	var inps = document.getElementsByName('design_id[]');
	for (var i = 0; i <inps.length; i++) 
	{
		var inp=inps[i];
		if(inp.value == "")
		{
			 safeUnblock("error","Please select design.") 
			return false;
		}
	}
	 block_page();
		var postData= new FormData(this);
		 	$.ajax({
            type: "post",
            url:  root+'product/manage',
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
					//$("#product_form").trigger('reset');
				    safeUnblock("success","Sucessfully Inserted.");
					 setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
					 
			   }
			   else if(obj.res==2)
			   {
				   $("#product_form").trigger('reset');
				   safeUnblock("success","Sucessfully Updated.");
					update_calc(<?=$invoicedata->step?>,1)
				
				}
				else if(obj.res==3)
				{
					setTimeout(function(){ window.location=root+'product/index/'+<?=$invoicedata->performa_invoice_id?> },1000);
				}
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
			   }
			  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
		});
		
	 
	
});

 
function edit_product(performa_trn_id,deletestatus,check_production_sheet,other_status,performa_packing_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"product/fetchproductdata",
              data: {
					"id" 					: performa_trn_id,
					"performa_packing_id" 	: performa_packing_id,
					"other_status" 			: other_status					
					}, 
              success: function (response) 
			  { 
                   var obj = JSON.parse(response);
				   
				  if(other_status  == 1)
				  {
					  $("#otherproduct").modal({
						 backdrop: 'static',
						 keyboard: false
					 });
					 $(".other_plus").hide();
					 $("#other_product_description1").val(obj.description_goods)
					 $("#other_unit_per1").val(obj.packing.per)
					 $("#other_rate1").val(obj.packing.product_rate)
					 $("#other_amt1").val(obj.packing.product_amt)
					 $("#other_gross_weight1").val(obj.packing.packing_gross_weight)
					 $("#other_net_weight1").val(obj.packing.packing_net_weight)
					 $("#other_image_name1").val(obj.packing.other_image)
					 if(obj.packing.other_image != "" && obj.packing.other_image != null)
					 {
						$("#show_other_img").show()
						$("#show_other_img").attr("src",'<?=DESIGN_PATH?>'+obj.packing.other_image)
					 
					 }
					 $("#otherperforma_packing_id").val(obj.packing.performa_packing_id)
					 $("#otherperforma_trn_id").val(obj.performa_trn_id)
						var  other_qty = 0;
					   if(obj.packing.per == "BOX")
					   {
					  	  other_qty = obj.packing.no_of_boxes;
					   }
					   else if(obj.packing.per  == "SQF")
					   {
							other_qty = obj.packing.no_of_boxes;
					   }
					   else if(obj.packing.per  == "SQM")
					   {
							other_qty = obj.packing.no_of_sqm;
					   }
					   else if(obj.packing.per  == "PCS")
					   {
							other_qty = obj.packing.no_of_boxes;
					   }
					   $("#other_qty1").val(other_qty)
				  }
				  else
				  {
						$("#myModal").modal({
							backdrop: 'static',
							keyboard: false
						});
						$('#product_details').select2('destroy');
						$('#product_details').val(obj.product_id).select2({ width:"100%"});
						if(check_production_sheet == 1)
						{
							$('.select2').prepend('<div class="disabled-select"></div>');
						}
						
						//$("#product_details").select2("val",obj.product_id);
						$("#performa_trn_id").val(obj.performa_trn_id);
						//var used_container = <?=$total_container?>;
						//var pending_container = parseFloat($("#no_of_container").val()) - parseFloat(used_container);
						//var passcontainer = parseFloat(pending_container)+parseFloat(obj.product_container);
						
						load_data(obj.product_id,'Edit',deletestatus,check_production_sheet);
				  }
					safeUnblock("",""); 
               }
              
          }); 

}	


</script>

  