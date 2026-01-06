<?php 
$this->view('lib/header'); 
$purchase_order_date = date('d-m-Y',strtotime($invoicedata->purchase_order_date));
$purchase_order_no =$invoicedata->purchase_order_no;
$export =  ($invoicedata->exporter_detail);
$seller_ref_no =  ($invoicedata->seller_ref_no);
$exporter_pan = $invoicedata->exporter_pan;
$rcmc_no = $invoicedata->rcmc_no;
$rcmc_expiery = $invoicedata->rcmc_expiery;
$supplier_name = $invoicedata->name;
$supplier_address = ($invoicedata->supplier_address);
$port_of_loading=$invoicedata->port_of_loading;
$port_of_discharge=$invoicedata->port_of_discharge;
$delivery_time=$invoicedata->delivery_time;
$no_of_container = $invoicedata->container_details;
$payment_terms = $invoicedata->payment_terms;
$supplier_panno = $invoicedata->supplier_panno;
$supplier_gstin = $invoicedata->supplier_gstin;
$remarks = $invoicedata->remarks;
$currency_symbol = ($invoicedata->currency_name=="Euro")?"&euro;":"$";
$sgst_value = '0.05';
if(!empty($invoicedata->sgst_value))
{
	$sgst_value = $invoicedata->sgst_value;
}
$cgst_value = '0.05';
if(!empty($invoicedata->cgst_value))
{
	$cgst_value = $invoicedata->cgst_value;
}
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
									<a href="<?=base_url().'purchaseorder_listing'?>">Purchase Order List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
							<h1>Purchase Order Product Entry</h1>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							 <div id="accordion">
							 <h3>
								Purchase Order Detail
							  </h3>   
								<div class="" style="padding:10px;" >
									<table cellspacing="0" cellpadding="0"  width="100%">
											<tr>
												<td rowspan="6" width="2%">
													<span>B</span><br>	
													<span>U</span><br>		
													<span>Y</span><br>	
													<span>E</span><br>		
													<span>R</span> 	
												</td>
												<td rowspan="3" colspan="2" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
													 <?=$export?>
												</td>
												<td width="15%">Purchase Order No 	</td>
												<td width="15%" colspan="2" style="font-weight:bold">
													<?=$purchase_order_no?>
													 
												</td>
												<td width="5%">DATE</td>
												<td width="15%" style="font-weight:bold">
													<?=$purchase_order_date?>
												</td>
											</tr>
											<tr>
												<td>Seller Ref. No </td>
												<td colspan="4" >
													<?=$seller_ref_no?>
												</td>
										 	</tr>
											<tr>
												<td>Port of Loading  </td>
												<td colspan="4" >
													<?=$port_of_loading?>
												</td>
										 	</tr>
											<tr>
												<td width="24%">PAN NO</td>
												<td width="24%" style="font-weight:bold" >
													<?=$exporter_pan?>
												</td>
												<td rowspan="2">Container Details </td>
												<td rowspan="2">
													<?=$no_of_container?>
												</td>
												<td rowspan="2" width="5%">X</td>
												<td rowspan="2" colspan="2">20FT FCL</td>
												 
										 	</tr>
											<tr>
												<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">
													RCMC NO
												</td>
											 	<td style="font-weight:bold"> 
													<?=$rcmc_no?>
												</td>
										 	</tr>
											<tr>
												<td>RCMC EXPIERY</td>
												<td style="font-weight:bold" >
													<?=$rcmc_expiery?>
												</td>
												<td>Delivery Time</td>
												<td colspan="4" >
													<?=$delivery_time?>
												</td>
												 
											</tr>
										 	<tr>
												<td rowspan="2" style="font-size: 11px;">
													<span>S</span><br>	
													<span>E</span><br>		
													<span>L</span><br>	
													<span>L</span><br>		
													<span>E</span><br>		
													<span>R</span> 
												</td>
												<td>Seller Name :</td>
												 <td>
													  <?=$supplier_name?>
												 </td>
												 <td colspan="5">
													<?=$payment_terms?>
												 </td>
											</tr>
											<tr>
												<td colspan="2" style="vertical-align:top;">
													<?=$supplier_address?><br>
													PAN NO : <?=$supplier_panno?><br>
													GSTIN : <?=$supplier_gstin?> 
												 </td>
												<td>Remarks</td>
												<td colspan="4">
													<?=$remarks?>
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
										<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">Add Product </button>
										</div>
									 
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="sample-table-1" width="100%">
													<thead>
														<tr>
															<th class="text-center" width="5%">Sr No.</th>
															<th class="text-center" width="34%">Description Of Goods</th>
														<!--<th width="5%">Container</th>-->
															<th class="text-center" width="8%">Plts</th>
															<th class="text-center" width="5%">Boxes</th>
															<th class="text-center" width="5%">SQM</th>
															<th class="text-center" width="5%">Quantity</th>
															<th class="text-center" width="5%">PI Unit</th>
															<th class="text-center" width="10%">Rate In Rs (&#x20b9;)</th>
															<th class="text-center" width="10%">Per</th>
															<th class="text-center" width="10%">Total Amount</th>
															<th class="text-center" width="8%">Action</th>
														</tr>
													</thead>
													<tbody>
													<?php
											$Total_plts = 0;
											$Total_qty = 0;
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
											 
												 $Total_weight  += $product_data[$i]->total_gross_weight;
												 $n = 1;
											  foreach($product_data[$i]->packing  as $packing_row)
											  {
												  $description_goods = $product_data[$i]->description_goods;
												  if(!empty($packing_row->model_name))
												  {
													  $description_goods .= ' - '.$packing_row->model_name;
												  }
												  if(!empty($packing_row->client_name))
												  {
													  $description_goods .= ' ('.$packing_row->client_name.')';
												  }
												  if(!empty($packing_row->finish_name))
												  {
													  $description_goods .= ' - '.$packing_row->finish_name;
												  }
												  
												  $deletestatus = 0;
													?>
														<tr>
															<?php 
													if($n == 1)
													{
													?>
													<td class="text-center" rowspan="<?=count($product_data[$i]->packing)?>">
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
																	
																	if(in_array($product_data[$i]->purchaseordertrn_id,$no_of_product_array))
																	{		
																		$rowspan =  count(explode(",",$container_data[$a]->allproduct_id));
																		
																	}
																}
														 	}
														  	$string = array_filter(explode(",",$string));
														 	if(in_array($product_data[$i]->purchaseordertrn_id,$string))
															{
																 $checkedcontainer ='checked="checked"';
																 $disabled ='disabled';
																 $deletestatus=1;
															}
															
															?>
														<!--<input type="checkbox" name="make_container" id="make_container<?=$i?>" value="<?=$product_data[$i]->purchaseordertrn_id?>" class="form-control" <?=$checkedcontainer?> onclick="add_value(this.checked,this.value,<?=count($product_data[$i]->packing)?>,<?=$packing_row->packing_gross_weight?>,<?=$packing_row->packing_net_weight?>)" <?=$disabled?> />-->
														<?php
														array_push($button_check_array,$product_data[$i]->purchaseordertrn_id);
														}
													
													?>
													</td>
													<?php 
													}
													?> 
													<td>
														<?=$description_goods?>
													</td>
													<!--	<?php 
													if($n == 1)
													{
														 
													 	if(!in_array($product_data[$i]->container_order_by,array_filter($stringcolor)) && $rowspan>0 && $product_data[$i]->container_order_by!=0)
														{
														 	$container_order_by += $product_data[$i]->container_order_by;
															 $ser_rowspan1 = ($product_data[$i]->rowspan_no>0)?$product_data[$i]->rowspan_no:'';
														 	 echo '<td rowspan="'.$ser_rowspan1.'" > 1 <a class="tooltips" data-title="Delete Container"  style="color:blue" href="javascript:;"  onclick="delete_combaine_con('.$product_data[$i]->container_order_by.')">Delete</a></td>';
															array_push($stringcolor,$product_data[$i]->container_order_by);
															$total_container += 1;
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
													?>-->
													<?php 
													$qty = 0;
													 
														if($product_data[$i]->extra_product == 1)
														{
															 
															if($packing_row->performa_per == "SQM")
															{
																$qty = $packing_row->no_of_sqm;
															 	$Total_qty += $qty;
															}
															else if($packing_row->performa_per == "BOX")
															{
																
																$qty = $packing_row->no_of_boxes;
																$Total_qty += $qty;
															}
															else if($packing_row->performa_per == "SQF")
															{
																
																$qty = ($packing_row->no_of_boxes);
																$Total_qty += $qty;
															}
															else if($packing_row->performa_per == "PCS")
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
															$no_of_boxes = $packing_row->no_of_boxes;
															$no_of_sqm = $packing_row->no_of_sqm;
															$qty = '-';
														}
													
													?>
														<td class="text-center">
															<?php
															if($packing_row->no_of_pallet>0)
															{
																	echo $packing_row->no_of_pallet;
															}
															else if($packing_row->no_of_big_pallet>0 || $packing_row->no_of_small_pallet>0)
															{
																echo 'Big : '.$packing_row->no_of_big_pallet.'<br> Small : '.$packing_row->no_of_small_pallet;
															}
															$product_rate = ($packing_row->product_rate > 0)?$packing_row->product_rate:$packing_row->mst_design_rate;
															
															
															?>
														</td>
														<td class="text-center">
															<?=$no_of_boxes; ?>
														</td>
														<td class="text-center">
															<?=$no_of_sqm; ?>
														</td>
														<td class="text-center">
															<?=$qty; ?>
														</td>
														<td class="text-center">
															<?=$packing_row->performa_per; ?>
														</td>
													 
													<td class="text-center">
														<input type="text" onkeypress="return isNumber(event)" id="product_rate_rs<?=$n.$no.$i?>" name="product_rate_rs[]" value="<?=$product_rate?>"  onkeyup="cal_amount(<?=$n.$no.$i?>,<?=$product_data[$i]->purchaseordertrn_id?>,<?=$product_data[$i]->extra_product?>)"  onblur="cal_amount(<?=$n.$no.$i?>,<?=$product_data[$i]->purchaseordertrn_id?>,<?=$product_data[$i]->extra_product?>)"  onchange="cal_amount(<?=$n.$no.$i?>,<?=$product_data[$i]->purchaseordertrn_id?>,<?=$product_data[$i]->extra_product?>)"  style="width: 100%;"/>
													</td>
													<td class="text-center">
														<select class="form-control" name="price_type[]" id="price_type<?=$n.$no.$i?>" onchange="cal_amount(<?=$n.$no.$i?>,<?=$product_data[$i]->purchaseordertrn_id?>,<?=$product_data[$i]->extra_product?>)" required title="Select Price Per">
															 <option value="">Select Price per</option>
																	<?php
																	$select ='';
																	$select1 ='';
																	$select2 ='';
																	$select3 ='';
																	if($packing_row->per=="SQF")
																	{
																		$select = 'selected="selected"';
																	}
																	else if($packing_row->per=="BOX")
																	{
																		$select1 = 'selected="selected"';
																	}
																	else if($packing_row->per=="SQM")
																	{
																		$select2 = 'selected="selected"';
																	}
																	else if($packing_row->per=="PCS")
																	{
																		$select3 = 'selected="selected"';
																	}
																	
																	if($packing_row->product_rate_per=="SQF")
																	{
																		$select = 'selected="selected"';
																		$total_feet = ($product_data[$i]->feet_per_box * $packing_row->no_of_boxes);
																		 
																		$productamt = $packing_row->mst_design_rate * $total_feet;
																	}
																	else if($packing_row->product_rate_per=="BOX")
																	{
																		$select1 = 'selected="selected"';
																	 	$productamt = $packing_row->mst_design_rate * $packing_row->no_of_boxes;
																	}
																	else if($packing_row->product_rate_per=="SQM")
																	{
																		$select2 = 'selected="selected"';
																		$productamt = $packing_row->mst_design_rate * $packing_row->no_of_sqm;
																	}
																	else if($packing_row->product_rate_per=="PCS")
																	{
																		$select3 = 'selected="selected"';
																		$total_pcs = ($product_data[$i]->pcs_per_box * $packing_row->no_of_boxes);
																		$productamt = $packing_row->mst_design_rate * $total_pcs;
																	}
																	
																	$productamt = ($packing_row->product_amt > 0)?$packing_row->product_amt:$productamt;
																	
																	$Total_ammount += $productamt;
																	?>
																<option <?=$select?>  value="SQF">SQF</option>
																<option <?=$select1?> value="BOX">BOX</option>
																<option <?=$select2?> value="SQM">SQM</option>
																<option <?=$select3?> value="PCS">PCS</option>
															</select>
														</td>
														<td class="text-center">
															 &#x20b9; <span id="productamt<?=$n.$no.$i?>"> <?=$productamt;?> </span>
															 <input type="hidden" id="product_amt<?=$n.$no.$i?>" name="product_amt[]" value="<?=$productamt?>"/>
															 <input type="hidden" id="sqm_per_box<?=$n.$no.$i?>" name="sqm_per_box[]" value="<?=$product_data[$i]->sqm_per_box?>"/>
															 
															 <input type="hidden" id="feet_per_box<?=$n.$no.$i?>" name="feet_per_box[]" value="<?=$product_data[$i]->feet_per_box?>"/>
															 
															 <input type="hidden" id="pcs_per_box<?=$n.$no.$i?>" name="pcs_per_box[]" value="<?=$product_data[$i]->pcs_per_box?>"/>
															 
															 <input type="hidden" id="product_sqm<?=$n.$no.$i?>" name="product_sqm[]" value="<?=$packing_row->no_of_sqm?>"/>
															 
															 <input type="hidden" id="product_boxes<?=$n.$no.$i?>" name="product_boxes[]" value="<?=$packing_row->no_of_boxes?>"/>
															 <input type="hidden" id="product_qty<?=$n.$no.$i?>" name="product_qty[]" value="<?=$qty?>"/>
															 <input type="hidden" id="purchaseordertrn_id<?=$n.$no.$i?>" name="purchaseordertrn_id[]" value="<?=$packing_row->purchaseordertrn_id?>"/>
															 <input type="hidden" id="popacking_id<?=$n.$no.$i?>" name="popacking_id[]" value="<?=$packing_row->popacking_id?>"/>
															 
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
															  <?php 
															  if($product_data[$i]->extra_product == 0)
																{
															  ?>
																<li>
																	<a class="tooltips" data-title="Edit"  onclick="edit_product(<?=$product_data[$i]->purchaseordertrn_id?>,<?=$deletestatus?>)" href="javascript:;" ><i class="fa fa-pencil"></i> Edit</a>
																</li>
																<?php
																}
																if($deletestatus != 1)
																{
																?>
																	<li>
																		<a class="tooltips" data-title="Delete"  onclick="delete_product(<?=$product_data[$i]->purchaseordertrn_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Delete</a>
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
										 		 $n++;
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
													<!--	<a class="btn btn-primary tooltips" data-title="Make Container"  onclick="make_container_fun(<?=$container_order_by+1?>)" href="javascript:;">Make Container</a>-->
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
															<th class="text-center"><?=$Total_plts; ?></th>
															<th class="text-center"><?=$Total_box; ?></th>
															<th class="text-center"><?=$Total_sqm; ?></th>
															<th class="text-center"><?=$Total_qty; ?></th>
															<th class="text-center"> </th>
															<th style="text-align:right" colspan="2">FOB Value</th>
															<th colspan="2">&#x20b9;  <span id="total_amount_html"><?=indian_number($Total_ammount,2); ?></span></th>
															 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
														</tr>
														<tr>
															
															<th colspan="7" rowspan="5" style="vertical-align:top">
															 </th> 
															 <th colspan="2">IGST (0.00%)</th>
															<th colspan="3">
																<input tabindex="1" id="igst" type="text" step="any" name="igst" placeholder="IGST" class="form-control" min = "1" max = "10"   onkeypress="return isNumber(event)"   readonly  value="0.00"/>
															</th>
															<?php
															$Total_ammount +=$invoicedata->igst; 
														 	$sgst = $Total_ammount*$sgst_value/100;
															$cgst = $Total_ammount*$cgst_value/100;
															?> 
														</tr>
														<tr>
															<th colspan="1">SGST </th>
															<th  > 
																<input id="sgst_value" type="text" step="any" name="sgst_value" tabindex="2" placeholder="SGST %" value="<?=indian_number($sgst_value,2)?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_final_total()" onblur="cal_final_total()" style="width:50%;float:left;"/>
																<span style="width:50%;float:left;font-size: 20px;"> %</span>
															</th>
															<th colspan="2">
																<input id="sgst" type="text" step="any" name="sgst" tabindex="2" placeholder="SGST" value="<?=$sgst?>" class="form-control" onkeypress="return isNumber(event)"   readonly />
															</th>
															 <?php $Total_ammount += $sgst; ?> 
														</tr>
														<tr>
															 <th >CGST 
																
															</th>
															<th  >
																<input id="cgst_value" type="text" step="any" name="cgst_value" tabindex="2" placeholder="CGST %" value="<?=indian_number($cgst_value,2)?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_final_total()" onblur="cal_final_total()" style="width:50%;float:left;"/>
																<span style="width:50%;float:left;font-size: 20px;"> %</span>
															</th>
															<th colspan="2">
																<input id="cgst" type="text" step="any" name="cgst" tabindex="3" placeholder="CGST" value="<?=$cgst?>" class="form-control" onkeypress="return isNumber(event)"   readonly />
															</th>
															  <?php $Total_ammount += $cgst;

																$round_value = round($Total_ammount);
																
																$roundoff = $round_value - $Total_ammount;
															  ?> 
														</tr>
														<tr>
															<th colspan="2">ROUND OFF</th>
															<th colspan="2">
																 <span id="roundoff_html"><?=indian_number($roundoff,2)?></span>
															</th>
															<input id="roundoff" type="hidden" name="roundoff"  value="<?=indian_number($roundoff,2)?>" />
															  <?php  $Total_ammount += $roundoff; ?> 
														</tr>
														<tr>
															<th colspan="2">ORDER VALUE</th>
															<th colspan="2">
																<div id="final_total">&#x20b9;   <?=indian_number($Total_ammount,2)?></div>
																<input id="final_total_val" type="hidden" name="final_total_val"  value="<?=number_format($Total_ammount,2,'.','')?>" />
															</th>
															 
														</tr>
													</tbody>
												</table>										
											
											 
											</div>
											
										</div>
									</div>
								</div>
								<div style="padding: 14px;padding-left:0px;">
									<button  tabindex="12" class="btn btn-success" onclick="check_product(<?=($invoicedata->step==1)?2:$invoicedata->step?>);">Save & Next</button>
									<a href="<?=base_url().'createpo/edit/'.$invoicedata->purchase_order_id?>" class="btn btn-danger">
											Back
									</a>
									<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
									<input type="hidden" id="make_container_array" name="make_container_array" value="0"> 
									<input type="hidden" id="gross_weight_array" name="gross_weight_array" value="0"> 
									<input type="hidden" id="net_weight_array" name="net_weight_array" value="0"> 
									<input type="hidden" id="purchase_order_id" name="purchase_order_id" value="<?=$invoicedata->purchase_order_id?>"> 
									<input type="hidden" id="no_of_row" name="no_of_row" value="0"> 
									<div class="errormsg" style="color:red"></div>
								</div>
							 
							</div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
		 
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg"  style="width:1100px;">
        <!-- Modal content-->
        <div class="modal-content" style="max-height: 600px;overflow-y: auto;">
		
            <div class="modal-header">
                <button type="button" onclick="close_modal()" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Product  </h4>
				
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="product_form" id="product_form">
            <div class="modal-body">
                <div class="row">
						<input type="hidden" id="purchaseorder_id" name="purchaseorder_id" value="<?=$invoicedata->purchase_order_id?>"> 
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
				 	<div id="productdetail"></div>        
				 </div>  			
				
				</div>
			 
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Add" id="product_submit_btn" class="btn btn-info"  /> 
                <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="purchaseordertrn_id" id="purchaseordertrn_id"/>
			<input type="hidden" name="form_check" id="form_check" value="1" />
			<input type="hidden" name="mode" id="mode" value="Add" />
		 	</form>
       
    </div>
</div>
</div>

<div id="proformaproduct_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        
        <div class="modal-content">
		
            <div class="modal-header">
                <!--<button type="button" onclick="close_modal()" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title">Copy Container <br> Select Container : <?=$no_of_container?></h4>
				
            </div>
			 <div class="modal-body">
                <div class="row">
						 
				<?php
				 
				 if(empty($product_data[0]->purchase_order_id))
				 {
					 
					?> 
					<center>
							<table class="table table-bordered table-hover" id="sample-table-1" style="width: 95%;"  >
											<thead>
												<tr>
													<th width="5%"> </th>
													<th width="55%">Description of Goods</th>
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
															</td>
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
			<button  type="button" id="button" class="btn btn-info" onclick="copy_containter(<?=$invoicedata->performa_invoice_id?>,<?=$invoicedata->purchase_order_id?>)"> Copy </button>
              <!--  <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>-->
            </div>
			 
			 
    </div>
</div>
</div>

<script>
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
<?php $this->view('lib/footer'); 
 
 echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>";
  
?>
<script>
var used_container = <?=$total_container?>;
var pending_container = parseFloat($("#no_of_container").val()) - parseFloat(used_container);
$("#html_setcontainer").html("Set Container : "+used_container);
$("#html_container").html("Pending Of Container : "+pending_container);
 $( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
});
function cal_amount(i,producttrn_id,extra_product)
{
	var rate 			= $("#product_rate_rs"+i).val();
	var price_type 		= $("#price_type"+i).val();
	var sqm_per_box 	= $("#sqm_per_box"+i).val();
	var pcs_per_box 	= $("#pcs_per_box"+i).val();
	var per_box_price 	= 0; 
	var totalamt		= 0.00;
	 
	if(extra_product == 1)
	{
		if(rate>0)
		{
			 totalamt = parseFloat(rate) * parseFloat($("#product_qty"+i).val());
			 
		}
	}
	else
	{
		if(rate>0)
		{
			
			if(price_type=="SQF")
			{
				var feet_per_box = parseFloat($("#feet_per_box"+i).val());
				per_box_price  = parseFloat(feet_per_box) * parseFloat(rate);
				per_box_price = per_box_price  / parseFloat(sqm_per_box);
				totalamt = parseFloat(per_box_price) * parseFloat($("#product_sqm"+i).val());
			}
			else if(price_type=="BOX")
			{
				var totalamt = parseFloat(rate) * parseFloat($("#product_boxes"+i).val());
			}
			else if(price_type=="SQM")
			{
				var totalamt = parseFloat(rate) * parseFloat($("#product_sqm"+i).val());
			}
			else if(price_type=="PCS")
			{
				var totalamt = parseFloat(rate) * parseFloat($("#product_boxes"+i).val()) * parseFloat(pcs_per_box);
			}
		}
	}
	$("#productamt"+i).html(totalamt.toFixed(2));
	$("#product_amt"+i).val(totalamt.toFixed(2));
	 cal_total_amount(producttrn_id);
}  
function cal_total_amount(producttrn_id)
{
	var productamt = document.getElementsByName('product_amt[]');
	var total=0;
	for (var i = 0; i <productamt.length; i++) 
	{
		var productobj=productamt[i];
		 
		if(productobj.value>0)
		{
			total += parseFloat(productobj.value);	 
		}	 
	}
	var purchaseordertrnid = document.getElementsByName("purchaseordertrnid[]");
	for(var p = 0; p < purchaseordertrnid.length; p++)
	{
		 
		var purchaseordertrnid1 =  purchaseordertrnid[p];
		var productgrouprate1 = document.getElementsByName('group_product_amt'+purchaseordertrnid1.value+'[]'); 
		 for (var g = 0; g < productgrouprate1.length; g++) 
		 {
			  
			 total += parseFloat($("#group_product_amt"+purchaseordertrnid1.value+g).val());
	 	  }
		 
	}
 	$("#total_amount").val(total.toFixed(2));
	$("#total_amount_html").html(total.toFixed(2));
	cal_final_total()
}
function cal_final_total()
{
	var total = $("#total_amount").val();
	var sgst_per = ($("#sgst_value").val()>0)?$("#sgst_value").val():0;
	var cgst_per = ($("#cgst_value").val()>0)?$("#cgst_value").val():0;
	var sgst = parseFloat(total) * parseFloat(sgst_per) / 100;
	var cgst = parseFloat(total) * parseFloat(cgst_per) / 100;
	$("#sgst").val(sgst.toFixed(2));
	$("#cgst").val(cgst.toFixed(2));
	var final_total = parseFloat(total) + parseFloat(sgst) + parseFloat(cgst);
	var round_value = Math.round(final_total);
	var roundoff = round_value - final_total;
	
	$("#roundoff_html").html(roundoff.toFixed(2));
	$("#roundoff").val(roundoff.toFixed(2));
	 final_total += parseFloat(roundoff);
	$("#final_total").html(final_total.toFixed(2));
	$("#final_total_val").val(final_total.toFixed(2));
}
function invoice_cal() 
{
	var total_amount = $('#total_amount').val();
    var certification_charge = ($('#certification_charge').val()=="")?0:$('#certification_charge').val();
    var insurance_charge =($('#insurance_charge').val()=="")?0:$('#insurance_charge').val();
    var seafright_charge = ($('#seafright_charge').val()=="")?0:$('#seafright_charge').val();
    var discount = ($('#discount').val()=="")?0:$('#discount').val();
	
	var final_total = parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge) + parseFloat(seafright_charge) - parseFloat(discount);
	 
	if(parseFloat(discount)>(parseFloat(total_amount) + parseFloat(certification_charge) + parseFloat(insurance_charge) + parseFloat(seafright_charge)))
	{
		$('#discount').focus();
		$('#discount_error').html('Not Vaild');
		$('#final_total').html('$ '+0);
		return false;
	}
	$('#discount_error').html('');
	$('#final_total').html('$ '+final_total.toFixed(2));
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
<script>
function check_product(step)
{
	var used_container = <?=$total_container?>;
	var pending_container = parseFloat($("#no_of_container").val()) - parseFloat(used_container);	 
	if(parseFloat($("#final_total").html().replace ( '$', '' ).trim())<=0)
	{
		$(".errormsg").html('Price Can`t be Zero');
		toastr["error"]("Price Can`t be Zero");
	}
	else
	{
		var productrateinput = document.getElementsByName('product_rate_rs[]');
		var total=0;
		for (var i = 0; i < productrateinput.length; i++)
		{
			var productrateobj=productrateinput[i];
			if(parseFloat(productrateobj.value) <= 0)
			{
				productrateobj.focus();
				return false;
				break;
			}
		}
		  update_calc(step,1);
		 	
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
              url: root+'poproduct/deleterecord',
              data: {
                "id": productid
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					updateinvoice(<?=$invoicedata->purchase_order_id?>);
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'poproduct/index/<?=$invoicedata->purchase_order_id?>'; },1500);
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
              url:  root+"poproduct/updateinvoice",
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
function edit_product(purchaseordertrn_id,deletestatus)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"poproduct/fetchproductdata",
              data: {
					"purchaseordertrn_id" : purchaseordertrn_id
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$('#product_details').select2('destroy');
					$('#product_details').val(obj.product_id).select2({ width:"100%"});
					$("#purchaseordertrn_id").val(obj.purchaseordertrn_id);
					var used_container = <?=$total_container?>;
					var pending_container = parseFloat($("#no_of_container").val()) - parseFloat(used_container);
					var passcontainer = parseFloat(pending_container)+parseFloat(obj.product_container);
					load_data(obj.product_id,'Edit',deletestatus);
					unblock_page("",""); 
                  }
              
          }); 

}
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
			$("#total_container").show();
			$("#total_container").val(1);
		}
			var total_container = $("#total_container").val();
			var total_boxes = $("#total_boxes").val();
			var Plts = $('#boxes_per_pallet').val();
			total_pallet = $('#pallet_in_container').val() * total_container;
			var total_big_pallet = $('#big_pallet_in_container').val() * total_container;
			var total_small_pallet = $('#small_pallet_in_container').val() * total_container;
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
		 	total_pallet = 0;
			total_boxes = 0;
		 	$("#total_pallet").val(total_pallet);
			 
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
		 var feet_per_box = $('#feet_per_box').val();
		 var pcs_per_box = $('#pcs_per_box').val();
		 
		 
		var total_no_of_pallet 	= 0;
		var total_no_of_boxes 	= 0;
		var total_no_of_sqm 	= 0;
		var total_product_amt 	= 0;
		var no =1;
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			if($('#no_of_pallet'+d).val() != undefined && $('#no_of_pallet'+d).val() != "" )
			{
				var rate_usd_val 	= $('#product_rate'+d).val();
				var no_of_pallet 	= $('#no_of_pallet'+d).val();
				var total_pallet 	= ($("#no_of_pallet"+d).val()>0)?$("#no_of_pallet"+d).val():0;
				var no_of_boxes 	= total_pallet * boxes_per_pallet;
				$('#no_of_boxes'+d).val(no_of_boxes.toFixed(2));
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				var price_type = $('#price_type'+d).val();
				 
				var  totalamt = 0;
				if(price_type=="SQF")
				{
					 
					per_box_price  = parseFloat(feet_per_box) * parseFloat(rate_usd_val);
					per_box_price = per_box_price  / parseFloat(sqm_per_box);
					totalamt = parseFloat(per_box_price) * parseFloat(no_of_sqm);
				}
				else if(price_type=="BOX")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_boxes);
				}
				else if(price_type=="SQM")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_sqm);
				}
				else if(price_type=="PCS")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_boxes) * parseFloat(pcs_per_box);
				}
				var product_total_amount = totalamt;
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
		 var feet_per_box = $('#feet_per_box').val();
		 var pcs_per_box = $('#pcs_per_box').val();
		 var total_no_of_boxes 	= 0;
		var total_no_of_sqm 	= 0;
		var total_product_amt 	= 0;
		var no =1;
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			if($('#no_of_boxes'+d).val() != undefined && $('#no_of_boxes'+d).val() != "" )
			{
				var rate_usd_val 	= $('#product_rate'+d).val();
				 
				var no_of_boxes 	= $('#no_of_boxes'+d).val();
				 
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				var price_type = $('#price_type'+d).val();
				 
				var  totalamt = 0;
				if(price_type=="SQF")
				{
 
					per_box_price  = parseFloat(feet_per_box) * parseFloat(rate_usd_val);
					per_box_price = per_box_price.toFixed(2) / parseFloat(sqm_per_box);
					totalamt = parseFloat(per_box_price) * parseFloat(no_of_sqm);
				}
				else if(price_type=="BOX")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_boxes);
				}
				else if(price_type=="SQM")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_sqm);
				}
				else if(price_type=="PCS")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_boxes) * parseFloat(pcs_per_box);
				}
				var product_total_amount = totalamt;
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	=  parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
				 
				total_no_of_boxes	 += parseFloat(no_of_boxes);
				total_no_of_sqm 	 += parseFloat(no_of_sqm);
				total_product_amt 	 += parseFloat(product_total_amount);
			}
			no++;
		}
		 
		 
		$('#total_no_of_boxes').val(total_no_of_boxes.toFixed(2));
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 
		 
		var total_net_weight 	= weight_per_box * total_no_of_boxes;
		var total_gross_weight 	= parseFloat(total_net_weight);
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
		  var feet_per_box = $('#feet_per_box').val();
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
				
				var price_type = $('#price_type'+d).val();
				var totalamt = 0;
				if(price_type=="SQF")
				{
					per_box_price  = parseFloat(feet_per_box) * parseFloat(rate_usd_val);
					per_box_price = per_box_price.toFixed(2) / parseFloat(sqm_per_box);
					totalamt = parseFloat(per_box_price) * parseFloat(no_of_sqm);
				}
				else if(price_type=="BOX")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_boxes);
				}
				else if(price_type=="SQM")
				{
					totalamt = parseFloat(rate_usd_val) * parseFloat(no_of_sqm);
				}
				var product_total_amount = totalamt;
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
	 var vals 			= $("#make_container_array").val().split(",");
	 var gross_weight 	= $("#gross_weight_array").val().split(",");
	 var net_weight 	= $("#net_weight_array").val().split(",");
     var filtered 		= vals.filter(function(value, index, arr){
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
				  url: root+"poproduct/make_container_fun",
				  data: { 	
							"allvalues[]"		 : filtered.toString(),
							"grossweight"		 : grossweight.toString(),
							"netweight"		 	 : netweight.toString(),
							"purchase_order_id"  : $("#purchase_order_id").val(),
							"cnt"				 : cnt,
							"no_of_row"			 : $("#no_of_row").val()
					}, 
				  success: function (response) { 
					   $("#make_container_array").val(0)
						unblock_page("success","Sucessfully Done."); 
						setTimeout(function(){ window.location=root+'poproduct/index/'+<?=$invoicedata->purchase_order_id?> },1000);
					  }
				  
			  }); 
 
}
function add_row()
{
	 $.ajax({ 
       type: "POST", 
       url: root+"poproduct/add_design_row",
       data: {
  		"design_id"		: $("#design_id"+$("#row_cont").val()).val(),
  		"finish_id"		: $("#finish_id"+$("#row_cont").val()).val(),
  		"product_id"	: $("#product_details").val(),
  		"no"			: $("#row_cont").val() 
  	  }, 
       success: function (response) {
		 	 $(".appendtr"+$("#row_cont").val()).after(response);
				var next_row = parseInt($("#row_cont").val()) + parseInt(1);
				
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
$("#product_form").submit(function(event) {
	event.preventDefault();
	if(!$("#product_form").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	$.ajax({
       type: "post",
       url: 	root+'poproduct/manage',
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
				setTimeout(function(){ window.location=root+'poproduct/index/'+<?=$invoicedata->purchase_order_id?> },1000);
			}
			else if(obj.res==2)
		   {
			   $("#product_form").trigger('reset');
			    unblock_page("success","Sucessfully Updated.");
				setTimeout(function(){ window.location=root+'poproduct/index/'+<?=$invoicedata->purchase_order_id?> },1000);
			}
		   else
		   {
			    unblock_page("error","Something Wrong.") 
		   }
		   
		  // update_calc(<?=$invoicedata->step?>,0);
       },
       error: function(jqXHR, textStatus, errorThrown) {
           console.log(errorThrown);
       }
	});
});

function set_model_rate(sqm_per_box)
{
	
	var group_id = $("#model_serice").val();
 	var exitedgroup = $("#group_id").val().split(',');
 	 
	if(group_id==null)
	{
		$("#group_id").val('')
		$(".multiplerate").html('');
		 cal_product_invoice()	
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
				cal_product_group(el)	
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
		cal_product_invoice()		
	 return false;
	 }
	  block_page();
       $.ajax({ 
         type: "POST", 
         url: root+"poproduct/displaymodelrate",
         data: {"group_id": foo ,"sqm_per_box":sqm_per_box  }, 
         success: function (response) { 
				 
			   if(response != 0)
               {
					$("#product_submit_btn").val('Submit')
					$("#rate_table").append(response);
					check_pallet_status($("input[name='pallet_status']:checked"). val())
					 
					$("#form_check").val(2);
					unblock_page("",""); 
					$("#group_id").val(group_id);
					cal_product_invoice()	
			   }
             }
         
     });
	}	
}
function cal_product_group(val)
{
	 var Plts = $('#Plts').val();
	 var box_per_big_pallet = $('#box_per_big_pallet').val();
	 var box_per_small_pallet = $('#box_per_small_pallet').val();
	 var total_big_pallet = ($("#group_total_big_pallet"+val).val()>0)?$("#group_total_big_pallet"+val).val():0;
	 var total_small_pallet = ($("#group_total_small_pallet"+val).val()>0)?$("#group_total_small_pallet"+val).val():0;
	 
     var Boxes = ($('#Boxes'+val).val()>0)?$('#Boxes'+val).val():0;
	 var appsqmperboxesval = $('#sqm_per_box'+val).val();
	 var total_boxes = $("#total_boxes"+val).val();
	 var pallet_weight = $('#pallet_weight').val();
	 var big_pallet_weight = $('#big_pallet_weight').val();
	 var small_pallet_weight = $('#small_pallet_weight').val();
     var total_sqm_val = $('#SQM'+val).val();
	 var radioValue = $("input[name='pallet_status']:checked"). val();
	 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	 if(radioValue==1)
	 { 
		 	
	   var total_weight_val = Boxes*$("#apwigtperbox").val();
	   var pallet_in_container = $("#group_pallet_in_container"+val).val()
	   $("#total_pallet"+val).val(total_container * $("#group_pallet_in_container"+val).val());
	    var sqmdataval = Boxes * appsqmperboxesval;
	   var total_pallet = ($("#total_pallet"+val).val()>0)?$("#total_pallet"+val).val():0;
	    
		$('#total_box'+val).val(total_pallet*Plts);
	   $('#Boxes'+val).val(total_pallet*total_pallet);
       $('#sqm_html'+val).html(sqmdataval.toFixed(2));
       $('#SQM'+val).val(sqmdataval.toFixed(2));
		cal_from_multiple(radioValue)
	 }
	 else if(radioValue==2)
	 {
		var sqmdataval = total_boxes * appsqmperboxesval;
		$('#Boxes'+val).val(total_boxes);
		$('#sqm_html'+val).html(sqmdataval.toFixed(2));
        $('#SQM'+val).val(sqmdataval.toFixed(2));
        cal_from_multiple(radioValue)
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
		$('#multi_total_box'+val).val(Boxes);
		$('#sqm_html'+val).html(sqmdataval.toFixed(2));
		$('#SQM'+val).val(sqmdataval.toFixed(2));
		 
		cal_from_multiple(radioValue)
	 }
}

function cal_from_multiple(radioValue)
{ 
 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	if(radioValue==1)
	 {
		var inps = $("#group_id").val().split(',');
			var no=0;
			var total_pallet = 0;
			var Plts = $("#Plts").val();
			var rate_in_rs = 0;
			var sqmdataval = 0;
			var total_sqm = 0;
			var totalpallet = 0;
			var product_total_amount = 0;
			var pallet_weight = $('#pallet_weight').val();
			var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
			
			for (var i = 0; i < inps.length; i++) {
				var appsqmperboxesval = $('#sqm_per_box'+inps[no]).val();
				var pallet_in_container = $("#group_pallet_in_container"+inps[no]).val()
				$("#total_pallet"+inps[no]).val(total_container * pallet_in_container);
			 
			
				var multi_pallet = (parseFloat($("#total_pallet"+inps[no]).val())>0)?parseFloat($("#total_pallet"+inps[no]).val()):0;
				total_pallet += multi_pallet
				rate_in_rs	 = (parseFloat($("#modalgroup_rate_in_rs"+inps[no]).val())>0)?parseFloat($("#modalgroup_rate_in_rs"+inps[no]).val()):0;
				 
				sqmdataval = parseFloat($("#total_pallet"+inps[no]).val() * Plts) * parseFloat(appsqmperboxesval);
				var total_boxes = multi_pallet * parseFloat(Plts);
				
					if(rate_in_rs>0)
					{
						if($("#modalgroup_price_type"+inps[no]).val() == "SQF")
						{
							var feet_per_box = appsqmperboxesval * 10.7639;
							per_box_price  = parseFloat(feet_per_box) * parseFloat(rate_in_rs); 
							per_box_price = per_box_price.toFixed(2) / parseFloat(appsqmperboxesval);
							product_total_amount += parseFloat(per_box_price) * parseFloat(sqmdataval);
							$("#modalgroup_productrate"+inps[no]).val(parseFloat(per_box_price) * parseFloat(sqmdataval));
							 
						}
						else if($("#modalgroup_price_type"+inps[no]).val() == "Box")
						{
							product_total_amount += parseFloat(rate_in_rs) * parseFloat(total_boxes);
							$("#modalgroup_productrate"+inps[no]).val(parseFloat(rate_in_rs) * parseFloat(total_boxes));
						
					 	}
						else if($("#modalgroup_price_type"+inps[no]).val() == "SQM")
						{
							
							product_total_amount += rate_in_rs * sqmdataval;  
							$("#modalgroup_productrate"+inps[no]).val(rate_in_rs * sqmdataval);
						}
						else
						{
							product_total_amount += 0; 
						}
					}
					else{
						product_total_amount += 0;   
					}
						
							
				$("#Boxes"+inps[no]).val(total_boxes.toFixed(2));
				$('#total_box'+inps[no]).val(total_boxes.toFixed(2));
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
				 totalpallet += parseFloat($("#total_pallet").val());
				product_total_amount += parseFloat($("#default_total").val());
			}
			
			$('#Boxes').val(parseFloat(total_pallet)*parseFloat(Plts));
			$('#boxes_html').html(parseFloat(total_pallet)*parseFloat(Plts));
			var total_weight_val = parseFloat($('#Boxes').val())*$("#apwigtperbox").val();
			var gross_weight_val = parseFloat($('#Boxes').val()*$("#apwigtperbox").val())+parseFloat(pallet_weight*total_pallet);
			var total_pallet_weight_val = parseFloat(pallet_weight)*parseFloat(total_pallet);
			
			$('#Total_weight').val(total_weight_val.toFixed(2));
			$('#totalweight_html').html(total_weight_val.toFixed(2));
			$('#grossweight_html').html(gross_weight_val.toFixed(2));
			$('#grossweight').val(gross_weight_val.toFixed(2));
			$('#total_pallet_weight').val(total_pallet_weight_val.toFixed(2));
			$('#Pallet_Weight_html').html(total_pallet_weight_val.toFixed(2)); 
			$("#total_sqm").html(total_sqm.toFixed(2));
			$("#pallet_html").html(totalpallet);
		
	 }
	 else if(radioValue == 2)
	 {
		var inps = $("#group_id").val().split(',');
		if(inps[0]!="") 
		{
			var no=0;
			var total_boxes = 0;
			var rate_in_rs = 0;
			var Rate_in_euro = 0; 
			var sqmdataval = 0;
			var product_total_amount =0;
			var total_sqm = 0;
		 for (var i = 0; i <inps.length; i++) {
			 var appsqmperboxesval = $('#sqm_per_box'+inps[no]).val();

			 var totalboxes = (parseFloat($("#total_boxes"+inps[no]).val())>0)?parseFloat($("#total_boxes"+inps[no]).val()):0;
			 total_boxes += totalboxes;
			 rate_in_rs	 = (parseFloat($("#modalgroup_rate_in_rs"+inps[no]).val())>0)?parseFloat($("#modalgroup_rate_in_rs"+inps[no]).val()):0;
			 sqmdataval =  parseFloat(totalboxes)  * parseFloat(appsqmperboxesval);
			 	 
			 if(rate_in_rs>0)
			 {
			 	if($("#modalgroup_price_type"+inps[no]).val() == "SQF")
			 	{
			 		var feet_per_box = appsqmperboxesval * 10.7639;
			 		per_box_price  = parseFloat(feet_per_box) * parseFloat(rate_in_rs); 
			 		per_box_price = per_box_price.toFixed(2) / parseFloat(appsqmperboxesval);
			 		product_total_amount += parseFloat(per_box_price) * parseFloat(sqmdataval);
			 		$("#modalgroup_productrate"+inps[no]).val(parseFloat(per_box_price) * parseFloat(sqmdataval));
			 	}
			 	else if($("#modalgroup_price_type"+inps[no]).val() == "Box")
			 	{
			 		product_total_amount += parseFloat(rate_in_rs) * parseFloat(total_boxes);
			 		$("#modalgroup_productrate"+inps[no]).val(parseFloat(rate_in_rs) * parseFloat(total_boxes));
			 	
			  	}
			 	else if($("#modalgroup_price_type"+inps[no]).val() == "SQM")
			 	{
			 		product_total_amount += rate_in_rs * sqmdataval;  
					 
			 		$("#modalgroup_productrate"+inps[no]).val(rate_in_rs * sqmdataval);
			 	}
			 	else
			 	{
			 		product_total_amount += 0; 
			 	}
			 }
			  else{
				product_total_amount += 0;   
			 }
					
			 $("#Boxes"+inps[no]).val(parseFloat(totalboxes));
			  
			 var total_weight_val1 = parseFloat($("#Boxes"+inps[no]).val())*$("#apwigtperbox").val();
		     var gross_weight_val1 = parseFloat($("#Boxes"+inps[no]).val())*$("#apwigtperbox").val();
			 
			 $("#group_weight"+inps[no]).val(total_weight_val1.toFixed(2));
			 $("#group_grossweight"+inps[no]).val(gross_weight_val1.toFixed(2));
			 $('#sqm_html'+inps[no]).html(sqmdataval.toFixed(2));
			 $('#SQM'+inps[no]).val(sqmdataval.toFixed(2));
			 
			  var sqm = (parseFloat($("#SQM"+inps[no]).val())>0)?$("#SQM"+inps[no]).val():0;
			 total_sqm += parseFloat(sqm);
		 	no++;
		}
		if($('#defualt_tr').css('display') != 'none')
		{
			 rate_in_rs = parseFloat($("#Rate_in_rs").val());
			 sqmdataval = parseFloat($("#total_boxes").val()) * parseFloat(appsqmperboxesval);
			 total_sqm += parseFloat($("#SQM").val());
			 product_total_amount += parseFloat(rate_in_rs * sqmdataval);
		}
		  $('#boxes_html').html(total_boxes);
		  $('#Boxes').val(total_boxes);
		  var total_weight_val = parseFloat($('#Boxes').val())*$("#apwigtperbox").val();
		  var gross_weight_val = parseFloat($('#Boxes').val()*$("#apwigtperbox").val());
		  $('#Total_weight').val(total_weight_val.toFixed(2));
          $('#totalweight_html').html(total_weight_val.toFixed(2));
          $('#grossweight_html').html(gross_weight_val.toFixed(2));
          $('#grossweight').val(gross_weight_val.toFixed(2));
		    
		  $("#total_sqm").html(total_sqm.toFixed(2));
		}
	}
	else if(radioValue == 3)
	{
		var inps = $("#group_id").val().split(',');
		if(inps[0]!="") 
		{
			var no=0;
		var total_pallet = 0;
		var totalboxes= 0;
		var totalweight= 0;
		var totalgrossweight= 0;
		var Plts = $("#Plts").val();
		var box_per_big_pallet = $('#box_per_big_pallet').val();
		var box_per_small_pallet = $('#box_per_small_pallet').val();
		var rate_in_rs = 0;
		var sqmdataval   = 0;
		var total_sqm    = 0;
		var totalbig_pallet    = 0;
		var totalsmall_pallet  = 0;
		var product_total_amount = 0;
		var pallet_weight = $('#pallet_weight').val();
		var big_pallet_weight = $('#big_pallet_weight').val();
		var small_pallet_weight = $('#small_pallet_weight').val();
		var total_pallet_weight_val = 0;
		var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
		for (var i = 0; i <inps.length; i++)
		{
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
			rate_in_rs	 = (parseFloat($("#modalgroup_rate_in_rs"+inps[no]).val())>0)?parseFloat($("#modalgroup_rate_in_rs"+inps[no]).val()):0;
			 sqmdataval =  total_boxes * parseFloat(appsqmperboxesval);
			  
			 if(rate_in_rs>0)
			 {
			 	if($("#modalgroup_price_type"+inps[no]).val() == "SQF")
			 	{
			 		var feet_per_box = appsqmperboxesval * 10.7639;
			 		per_box_price  = parseFloat(feet_per_box) * parseFloat(rate_in_rs); 
			 		per_box_price = per_box_price.toFixed(2) / parseFloat(appsqmperboxesval);
			 		product_total_amount += parseFloat(per_box_price) * parseFloat(sqmdataval);
			 		$("#modalgroup_productrate"+inps[no]).val(parseFloat(per_box_price) * parseFloat(sqmdataval));
			 	}
			 	else if($("#modalgroup_price_type"+inps[no]).val() == "Box")
			 	{
			 		product_total_amount += parseFloat(rate_in_rs) * parseFloat(total_boxes);
			 		$("#modalgroup_productrate"+inps[no]).val(parseFloat(rate_in_rs) * parseFloat(total_boxes));
			 	
			  	}
			 	else if($("#modalgroup_price_type"+inps[no]).val() == "SQM")
			 	{
			 		product_total_amount += rate_in_rs * sqmdataval;  
					 
			 		$("#modalgroup_productrate"+inps[no]).val(rate_in_rs * sqmdataval);
			 	}
			 	else
			 	{
			 		product_total_amount += 0; 
			 	}
			 }
			  else{
				product_total_amount += 0;   
			 }
			 var total_big_pallet_weight = parseFloat(multi_big_pallet) * parseFloat(big_pallet_weight);
			 var total_small_pallet_weight = parseFloat(multi_small_pallet) * parseFloat(small_pallet_weight);
			 total_pallet_weight_val += parseFloat(total_big_pallet_weight);
			 total_pallet_weight_val += parseFloat(total_small_pallet_weight);
			 totalbig_pallet 	+= multi_big_pallet;
			 totalsmall_pallet  += multi_small_pallet; 
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
			  totalbig_pallet += parseFloat($("#total_big_pallet").val());
			 totalsmall_pallet += parseFloat($("#total_small_pallet").val());
			 product_total_amount += parseFloat($("#default_total").val());
		}
		 
		 
		$('#boxes_html').html(totalboxes);
		$('#Total_weight').val(totalweight.toFixed(2));
        $('#totalweight_html').html(totalweight.toFixed(2));
	    $('#grossweight_html').html(totalgrossweight.toFixed(2));
        $('#grossweight').val(totalgrossweight.toFixed(2));
        $('#total_pallet_weight').val(total_pallet_weight_val.toFixed(2));
        $('#Pallet_Weight_html').html(total_pallet_weight_val.toFixed(2)); 
		$("#total_sqm").html(total_sqm.toFixed(2));
		$("#big_pallet_html").html(totalbig_pallet.toFixed(2));
		$("#small_pallet_html").html(totalsmall_pallet.toFixed(2));
		}
	}
	
	 $('#totalprice_html').html(product_total_amount);
	 $('#Total_Amount').val(product_total_amount);
}      

function remove_defualt()
{
	$("#defualt_tr").hide();
	$(".add_btn").show();
	$("#defualt_status").val(0);
	cal_product_invoice()	
}
function add_defualt()
{
	$("#defualt_tr").show();
	$(".add_btn").hide();
	$("#defualt_status").val(1);
	cal_product_invoice()	
}


function close_modal()
{
	$("#product_form").trigger('reset');
	$("#productdetail").html('');
	$(".select2").select2({
		width:'100%'
	});
}
	
function load_data(product_id,mode,deletestatus)
{
	
         $("#responsecontainer").empty();
			block_page();
            $.ajax({ 
              type: "POST", 
              url: root+"poproduct/load_design_data",
              data: {
					 "id"					: product_id,
					 "mode"					: mode,
					 "purchaseordertrn_id"	: $("#purchaseordertrn_id").val(),
					 "deletestatus"			: deletestatus
				}, 
				success: function (response) { 
							$("#productdetail").html(response);
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
function load_packing(product_size_id,mode,deletestatus)
{  
if(product_size_id != "")
{
  	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"poproduct/load_packing",
       data: {
  		"product_size_id"		: product_size_id,
		"mode" 					: mode,
		"purchaseordertrn_id" 	: $("#purchaseordertrn_id").val(),
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
function cal_product_trn(no)
{
	 cal_product_invoice()
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
			"id": design_id 
		}, 
		success: function (response) {
				var obj = JSON.parse(response);
				$("#finish_id"+val).html(obj.html);
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
		url: root+"poproduct/designrate",
		data:
		{
			"seller_id"	 		: <?=$invoicedata->seller_id?>,
			"product_id"		: $("#product_details").val(),
			"packing_model_id"	: $("#design_id"+val).val(),
			"product_rate_per"	: $("#product_rate_per"+val).val(),
			"finish_id"			: $("#finish_id"+val).val(),
		}, 
		success: function (response) {
				 
			var obj = JSON.parse(response);
				 
				if(obj.rate_data != null && obj.rate_data != 0)
				{
				 	$("#price_type"+val).val((obj.rate_data.product_rate_per != null)?obj.rate_data.product_rate_per:"SQM");
					$("#product_rate"+val).val(obj.rate_data.design_rate);
				}
				else
				{
					$("#price_type"+val).val('SQM');
					$("#product_rate"+val).val(0);
				}
				 
				 
				cal_product_trn(val)
				 
				unblock_page("",""); 
			}
		
	}); 
}   
function update_calc(step,test)
{
	var product_rate_rs 		= $("input[name='product_rate_rs[]']").map(function(){return $(this).val();}).get();
	var product_amount 			= $("input[name='product_amt[]']").map(function(){return $(this).val();}).get();
	var purchaseordertrn_id 	= $("input[name='purchaseordertrn_id[]']").map(function(){return $(this).val();}).get();
	var popacking_id 			= $("input[name='popacking_id[]']").map(function(){return $(this).val();}).get();
	var feet_per_box 			= $("input[name='feet_per_box[]']").map(function(){return $(this).val();}).get();
	 
	if(test!=0)
	{
		var price_type = $("[name='price_type[]']").map(function(){return $(this).val();}).get();
	}
	 
	 block_page();
	$.ajax({ 
             type: "POST", 
             url: root+"poproduct/update_po",
			 data: {
				"purchase_order_id"		: $("#purchase_order_id").val(),
				"igst"					: $("#igst").val(),
				"sgst_value"			: $("#sgst_value").val(),
				"cgst_value"			: $("#cgst_value").val(),
				"sgst"					: $("#sgst").val(),
				"cgst"					: $("#cgst").val(),
				"roundoff"				: $("#roundoff").val(),
				"grand_total"			: $("#final_total_val").val(),
				"step"					: step,
				"product_rate_rs"		: product_rate_rs,
				"product_amount" 		: product_amount,
				"feet_per_box" 			: feet_per_box,
				"purchaseordertrn_id" 	: purchaseordertrn_id, 
				"price_type" 			: price_type, 
				"popacking_id" 			: popacking_id 
			}, 
			success: function (response) { 
				console.log(response)
				 unblock_page("success","Sucessfully Updated.");
				  setTimeout(function(){ window.location='<?=base_url()?>purchaseorderview/index/<?=$invoicedata->purchase_order_id?>'; },1000);
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
              url: root+'poproduct/make_container_delete',
              data: {
                "id": id,
				"invoice_id" : <?=$invoicedata->purchase_order_id?>
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'poproduct/index/<?=$invoicedata->purchase_order_id?>'; },1500);
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
	add_productsdetail();
}
 
</script>
<script>
function copy_containter(performa_invoice_id,purchase_order_id)
{
	var producttrn_id = [];
	var total_container = 0;
	 $('input[name="copy_make_container[]"]').each(function() {
        if ($(this).is(":checked")) {
             producttrn_id. push($(this). val());
			 total_container += parseInt($("#total_product_container"+$(this). val()).val())
        }
    });
	 
	if(parseInt(total_container)>=parseInt($("#total_no_of_container").val()))
	{
		block_page();
		$.ajax({ 
              type: "POST", 
              url: root+'poproduct/copy_containter',
              data: {
                "producttrn_id": producttrn_id,
                "performa_invoice_id": performa_invoice_id,
                "purchase_order_id": purchase_order_id
              }, 
              cache: false, 
              success: function (data) { 
			      location.reload();
              }
			});
	}
	else{
		toastr["error"]("You Must have to select "+parseInt($("#total_no_of_container").val())+" Container.")
	} 
}
</script>
  