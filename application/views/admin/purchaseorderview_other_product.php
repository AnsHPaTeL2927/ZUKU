<?php 
 $this->view('lib/header'); 
  
 $purchase_order_date = date('d-m-Y',strtotime($invoicedata->purchase_order_date));
 $purchase_order_no =$invoicedata->purchase_order_no;
 $export =  ($invoicedata->exporter_detail);
 $seller_ref_no =  ($invoicedata->seller_ref_no);
 $exporter_pan = $invoicedata->exporter_pan;
 $rcmc_no = $invoicedata->rcmc_no;
 $rcmc_expiery = $invoicedata->rcmc_expiery;
 $supplier_name = $invoicedata->company_name;
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
   
 $amountword = converttorsword($invoicedata->grand_total);
  $_SESSION['purchase_order_no'] = '';
  $_SESSION['purchaseorder_content'] = '';
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
<style>
td {
    border: 0.5px solid #333;
    padding: 5px;
}
th{
	border: 0.5px solid #333;
    padding: 5px;
}
</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"purchaseorderview/view_pdf", '_blank');
	}
	else{
		window.location= root+"purchaseorderview/view_pdf";
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
									<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								<li class="active">
									<a href="<?=base_url().'purchaseorder_listing'?>">Purchase Order List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
							<h1>View Purchase Order</h1>
							<div class="pull-right form-group">
											<h4>
												<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
												 
												</h4> 
										</div>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
								<div class="" style="padding:10px;" >
								<?php ob_start();?>
									<h3 style="font-weight:bold;text-align: center;">PURCHASE ORDER	</h3>
										<table cellspacing="0" cellpadding="0"    width="100%">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" colspan="8">
														<img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" width="100%" height="180px"  />
												</td>
										 	</tr> 
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
												<td width="5%" >DATE</td>
												<td width="15%" style="font-weight:bold">
													<?=$purchase_order_date?>
												</td>
											</tr>
											<tr>
												<td>Seller Ref. No </td>
												<td colspan="4" style="font-weight:bold" >
													<?=$seller_ref_no?>
												</td>
										 	</tr>
											<tr>
												<td>Port of Loading  </td>
												<td colspan="4" style="font-weight:bold" >
													<?=$port_of_loading?>
												</td>
										 	</tr>
											<tr>
												<td width="24%">PAN NO</td>
												<td width="24%" style="font-weight:bold" >
													<?=$exporter_pan?>
												</td>
												<td rowspan="2">Container Details </td>
												<td rowspan="2" colspan ="4" style="font-weight:bold">
													<?php
												if(!empty($invoicedata->container_twenty))
												{
													echo $invoicedata->container_twenty.' X 20 FCL';
												}
												if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
												{
														echo ",";
												}
												if(!empty($invoicedata->container_forty))
												{
													echo  $invoicedata->container_forty.' X 40 FCL';
												}
												 ?></td>
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
												<td colspan="4" style="font-weight:bold">
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
											 
												 <td rowspan="2" colspan="2" style="font-weight:bold">
													 <?=$supplier_name?><br>
													<?=$supplier_address?><br>
													PAN NO : <?=$supplier_panno?><br>
													GSTIN : <?=$supplier_gstin?>  
												 </td>
												<td>
													PAYEMNT TERMS
												</td>
												 <td colspan="4" style="font-weight:bold">
													<?=$payment_terms?>
												 </td>
											</tr>
											<tr>
												 
												<td>Remarks</td>
												<td colspan="4" style="font-weight:bold">
													<?=$remarks?>
												</td>
											</tr>
											 
				 
								</table>
								
								<table cellspacing="0" cellpadding="0" style="" width="100%">
										<tr>
										   <td  style="text-align:center">Sr No</td>
										   <td colspan="5" width="40%"  style="text-align:center">Description Of Goods</td>
										   <td colspan="1" style="text-align:center">Quantity  </td>
										   <td   width="10%"  style="text-align:center">Rate In Rs</td>
										   <td   width="10%"  style="text-align:center">Unit</td>
										   <td   width="13%"  style="text-align:center">Total Amount</td>
										</tr>
										 
										 
											<?php
												 $Total_plts = 0;
												$Total_sqm = 0;
												$Total_box = 0;
												$Total_qty = 0;
												$Total_ammount = 0;
												$product_desc_array = array();
												$no =1;
												$size_array =array();
												$no_of_row = 20;
												foreach ($product_data as $jsonalldata)
												{ 
													foreach($jsonalldata->packing  as $packing_row)
													{											
												 ?>
													<tr>
														<td  style="text-align: center;">
															<?=$no?> 
														</td>
														<td colspan="5"> 
														<?php 
															if($jsonalldata->extra_product == 1)
															{
																echo $jsonalldata->description_goods;
															}
															else
															{
																?>
															<?=$jsonalldata->size_type_mm?> (<?=$jsonalldata->series_name?> - <?=$jsonalldata->hsnc_code?>)
															<?php 
															}
															?>
														</td>
														<td style="text-align:center">
															 <?php 
															$qty = 0;
													 
														if($jsonalldata->extra_product == 1)
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
																$qty = ($packing_row->no_of_boxes * $jsonalldata->feet_per_box);
																$Total_qty += $qty;
															}
															else if($packing_row->per == "PCS")
															{
																$qty = ($packing_row->no_of_boxes * $jsonalldata->pcs_per_box);
																$Total_qty += $qty;
															}
														} 
															 
															 ?>
														 
															<?=$qty?>
														</td>
														 
														<td style="text-align:center">
															<img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" /> 
															<?=number_format($packing_row->product_rate,2)?>
														</td>
														<td style="text-align:center">
															 
															<?=$packing_row->per?>
														</td> 
														<td style="text-align:right">
															<img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" /> 
															<?=number_format($packing_row->product_amt,2)?>
														</td>
													</tr>
															<?php
															$Total_ammount += $packing_row->product_amt;
															$no++;
															$no_of_row--;
															 
															}
													}			 
												 
											for($row=0;$row<=$no_of_row;$row++)
											{	 
											?>
											 <tr>
												<td width="2%" style="border:none;border-left: 0.5px solid #333" >&nbsp;</td>
												<td width="3%"  style="border:none;border-left: 0.5px solid #333"  >&nbsp;</td>
												<td colspan="4" style="border:none;" ></td>
												<td style="border:none;border-left: 0.5px solid #333"></td>
												<td style="border:none;border-left: 0.5px solid #333"></td>
												<td style="border:none;border-left: 0.5px solid #333"></td>
												<td style="border:none;border-left: 0.5px solid #333;border-right: 0.5px solid #333"></td>
											</tr>
											<?php }  ?>
											<tr>
											  <td colspan="6" style="text-align:right;font-weight:bold">Total Quantity</td>
											  <td style="text-align:center;font-weight:bold"><?=$Total_qty?></td>
											   
											  <td colspan="2" style="font-weight:bold;text-align:right"> Total Amount</td>
											  
											  <td style="text-align:right;font-weight:bold"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />  <?=indian_number($Total_ammount,2)?></td>
											</tr>
											<tr>
												
												<th colspan="7" rowspan="5" style="vertical-align:top">
													  	ORDER VALUE SAY IN WORD : <?=strtoupper($amountword)?>
												</th> 
												
												<th colspan="2">IGST (0.00%)</th>
												<th style="text-align:right">
													<img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />  0.00
												</th>
												<?php $Total_ammount +=$invoicedata->igst; 
												
												$sgst = $Total_ammount*$sgst_value/100;
												$cgst = $Total_ammount*$cgst_value/100;
												 
												?> 
												</tr>
												<tr>
													<th colspan="2">SGST (<?=$sgst_value?>%)</th>
													<th style="text-align:right">
														<img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($sgst,2)?>
													</th>
													 <?php $Total_ammount +=  $sgst; ?> 
												</tr>
												<tr>
													 
													 
													<th  colspan="2">CGST (<?=$cgst_value?>%)</th>
													<th style="text-align:right">
														<img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />  <?=indian_number($cgst,2)?>
													</th>
													  <?php 
													 
															$Total_ammount +=  $cgst;
															
															$round_value = round($Total_ammount);
															$roundoff = $round_value - $Total_ammount;
													  ?> 
												</tr>
												<tr>
												    <th colspan="2" >ROUND OFF</th>
													<th style="text-align:right">
														<img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   	 <?=indian_number($roundoff,2)?>
													</th>
													 
													  <?php  $Total_ammount += $roundoff; ?> 
												</tr>
												<tr>
												 
													<th  colspan="2">ORDER VALUE</th>
													<th style="text-align:right">
														<div id="final_total"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />  <?=indian_number($Total_ammount,2)?></div>
														 
													</th>
													 
												</tr>
														
									</table>			
								 
								 <pagebreak />	
									<table cellspacing="0" cellpadding="0" width="100%">
										<tr>
										  <td  width="55%" rowspan="2" style="border-left: 0.1px solid;border-right:none;">
										     <img src="<?=base_url().'upload/'.$company_detail[0]->s_image?>" height="100px;" width="200px" />
									        <br>
											</td>
											 
											 <td  width="45%" style="text-align:right;border-bottom:none;border-left:none;">
												<div style="font-size:30px"><strong>Production Order</strong></div>
											 </td>
											
											 
									    </tr>
										<tr>
											 
											 <td style="border-top:none;border-left:none;;vertical-align:top;text-align:right;">
											 <strong style="font-size:15px" >
												PO NO.  : <?=$purchase_order_no?> | Date: <?=$purchase_order_date?></strong><br>
											<strong> MFG BY : <?=$supplier_name?></strong><br>
											<strong> NO OF CONTAINER : <?php
												if(!empty($invoicedata->container_twenty))
												{
													echo $invoicedata->container_twenty.' X 20 FCL';
												}
												if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
												{
														echo ",";
												}
												if(!empty($invoicedata->container_forty))
												{
													echo  $invoicedata->container_forty.' X 40 FCL';
												}
												 ?></strong> 
											
											</td>
										</tr>
										 
									  </table>
									<table cellspacing="0" cellpadding="0" width="100%">
									  <tr>
										   <td style="text-align:center"  width="13%">SIZE</td>
										   <td style="text-align:center"  width="13%">DESIGN NAME</td>
										   <td style="text-align:center"  width="13%">DESIGN NAME FOR BOX STICKER</td>
										   <td style="text-align:center"  width="13%">FINISH</td>
										   <td style="text-align:center"  width="20%">DESIGN PHOTO	</td>
										   <td style="text-align:center"  width="13%">UNIT</td>
										   <td style="text-align:center"  width="13%">QUANTITY</td>
										   
									   </tr>
									  <?php
										 
										$Total_qty= 0;
										 
										$srno = 1;
										
								foreach($product_data as $jsonalldata)
								{ 
									$n = 1;
								  foreach($jsonalldata->packing  as $packing_row)
								  {
										 
										?>
									  <tr> 
											<?php
											if($product_data[$i]->extra_product == 1)
											{
											?>
												<td style="text-align:center"><?=$jsonalldata->size_type_mm?></td>
												<td style="text-align:center"><?=$packing_row->model_name?></td>
												<td style="text-align:center"><?=$packing_row->client_name?></td>
												<td style="text-align:center"><?=$packing_row->finish_name?></td>
											<?php 
											}
											else
											{
												echo '<td style="text-align:center" colspan="4">'.$jsonalldata->description_goods.'</td>';
											}
											?>
											<td style="text-align:center">
												<p style="margin: 0 auto; width:98px;height:95px;overflow:hidden">
											<?php 
											if($jsonalldata->extra_product == 1)
											{
											?>
												<img src="<?=(!empty($packing_row->other_image))?DESIGN_PATH.$packing_row->other_image:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
											
											<?php											
											}
											else
											{
												 
											?>
												<img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
											<?php 
											}
														$qty = 0;
													 
														if($jsonalldata->extra_product == 1)
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
																$qty = ($packing_row->no_of_boxes * $jsonalldata->feet_per_box);
																$Total_qty += $qty;
															}
															else if($packing_row->per == "PCS")
															{
																$qty = ($packing_row->no_of_boxes * $jsonalldata->pcs_per_box);
																$Total_qty += $qty;
															}
														} 
														
											?>
											 </p>
											</td>
										 	 
											<td style="text-align:center"> <?=$packing_row->per?> </td>
											<td style="text-align:center"> <?=$qty?> </td>
											
											 
									  </tr>
									  <?php
								  $srno++;
								  }
								  
								}
										?>
								 <tr> 
										 
										<td style="text-align:right;" colspan="6"><strong>Total</strong></td>
									 
										 <td style="text-align:center;"><strong> <?=$Total_qty?> </strong></td>
									 	 
										 
									   </tr>
										</table>
										
									 <table cellspacing="0" cellpadding="0" width="100%">
									    <tr>
											<td rowspan="2" style="vertical-align:top;"> 
											<?php if(!empty($invoicedata->notes))
												{
													?>
												<strong>Notes : </strong>  
											
												<?=$invoicedata->notes?> 
												<br>
												<?php 
												}
												?>
												QC BY 	: <?=$invoicedata->qc_by?><br>
												LOADING AND SHIFTING BY : <?=$invoicedata->loading_by?><br> 
											<br>
												<strong> PRODUCTION DETAILS :</strong>
												<br>
											 	BACK SIDE OF THE TILES	: <?=$invoicedata->made_in_india_status?><br>
												CORNER PROTECTOR		: <?=$invoicedata->corner_protector	?><br>
												SEPARATOR BETWEEN THE TILES : <?=$invoicedata->separation_tiles?><br>
											 	FUMIGATION :<?=$invoicedata->fumigation_name?> 
							 		</td>
										<td style="vertical-align:top;">
											<strong> BOX STICKER:</strong><br>
												<?php
											$images_name = explode(",",$invoicedata->barcode_sticker_file);
											if(!empty($images_name[0]) && $images_name[0] != "none")
											{
												?>
												 
												 <?php 
												foreach($images_name as $img)
												echo "<div style='margin-bottom:5px'>
														<img src='".base_url()."upload/".$img."'  height='129px'/> 
													  </div>"; 
												 
												?>
												 
												 <?php
											}
											 
											?>
										</td>
										<tr>
										<td style="vertical-align:top;">
											<strong> PALLET STICKER:</strong>.
											<br>
											<?php 
										if(!empty($invoicedata->box_sticker_file) && $invoicedata->box_sticker_file != "none")
										{
											?>
											 
													<img src='<?=base_url()."upload/".$invoicedata->box_sticker_file?>' width='290px' height='175px'/>
												 
											<?php
										}
										?>
										</td>
									  </tr>
									   <?php 
									  if(!empty($invoicedata->packing_remarks))
									  {
									  ?>
									    <tr>
										<td colspan="2" > <strong>Remarks : </strong>  <?=$invoicedata->packing_remarks?> </td>
									  </tr>
									  <?php }
									  ?>
									 <tr>
														<td width="50%" style="vertical-align:top;    border-bottom: none;padding: 10px 10px;">  
															   ACCEPTED BY SUPPLIER 
														</td>
													   <td width="50%"  style="text-align:right;border-bottom: none;vertical-align:top">  
															  FOR  <?=$company_detail[0]->s_name?><br>
															<img src="<?=base_url().'upload/'.$company_detail[0]->s_c_sign?>" height="80px" >
															 
														</td>  
														</tr>
														<tr>
														<td  style="vertical-align:bottom;border-top: none;padding: 10px 10px;">  
															  SEAL &amp; SIGNATURE 
															   
														</td>
													   <td style="text-align:right;border-top: none">  
															 
															
																AUTHORISED SIGNATORY 
														</td>  
														</tr>
									</table>
							<h6>Created using Zuku Software</h6>
								 <?php
									 $output = ob_get_contents(); 
									 $_SESSION['purchase_order_no'] = $invoicedata->purchase_order_no.' - '.$invoicedata->container_details.' - '.date('d-m',strtotime($invoicedata->purchase_order_date));;
									 $_SESSION['purchaseorder_content'] = $output;
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
				</div>
			</div>
		 
		</div>
  
<?php $this->view('lib/footer'); ?>
