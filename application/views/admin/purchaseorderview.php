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
		window.open(root+"Purchaseorderview/view_pdf", '_blank');
	}
	else{
		window.location= root+"Purchaseorderview/view_pdf";
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
									<div id="testTable">
								<table cellspacing="0" cellpadding="0" border="1"   width="100%" class="main_table">
									<tr>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="8%"> </td>
											<td style="border:0px;padding:0px" width="9%"> </td>
											<td style="border:0px;padding:0px" width="9%"> </td>
											<td style="border:0px;padding:0px" width="9%"> </td>
											<td style="border:0px;padding:0px" width="9%"> </td>
									 	</tr>
										<tr>
												<td  colspan="3"  style="border-right:none;text-align:center">	
												 <img src="<?=base_url().'upload/'.$company_detail[0]->s_image?>" style="width:100px;height:80px"/>
											</td>
											<td colspan="9" style="text-align:center;background-color:#C7D9F1 ;color:#000000;border-left:none">
												<strong style="font-size: 20px;"> <u> PURCHASE ORDER </u></strong>
											</td>
									 	</tr>
										<tr>
											<td rowspan="3"  colspan="6"  style="border-right:none">
												<?=$export?>
												EMAIL:<?=$company_detail[0]->s_email?>
											</td>
										
											<td colspan="6" style="border-top:none;border-bottom: none;">
												Purchase Order No: <strong> <?=$purchase_order_no?> </strong>
											</td>
												 
									 	</tr>
										<tr>
											 	<td  colspan="6"  style="border-top:none;border-bottom: none;">
													DATE : <strong><?=$purchase_order_date?> </strong>
											 	</td>
												 
									 	</tr>
										<tr>
											 	<td colspan="6" style="border-top:none;border-bottom: none;">
												Seller Ref. No :<strong><?=$seller_ref_no?>	</strong>
											 	</td>
												 
									 	</tr>
										<tr>
										 	<td colspan="6"  style="background-color:#C7D9F1 ;color:#000000">
												 <strong>SELLER DETAILS</strong>										
											</td>
											<th   colspan="3" style="text-align:center;background-color:#C7D9F1 ;color:#000000" >NUMBER OF CONTAINER</th>
											<th  colspan="3"  style="text-align:center;background-color:#C7D9F1 ;color:#000000"  > PORT OF LOADING </th>
											
									 	</tr>
										<tr>
										 	<td colspan="6" rowspan="3" style="vertical-align:top;">
												<?=$supplier_name?><br>
													<?=$supplier_address?><br>
													PAN NO : <?=$supplier_panno?><br>
													GSTIN : <?=$supplier_gstin?>  
											</td>
											<td  colspan="3"  style="text-align:center;font-weight:bold">
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
												<td  colspan="3"  style="text-align:center;font-weight:bold"> <?=strtoupper($invoicedata->port_of_loading)?>  </td>
										</tr>
										 
										<tr>
											<th  colspan="3" style="text-align:center;background-color:#C7D9F1 ;color:#000000"  >DELIVERY TIME </th>
											<th  colspan="3" style="text-align:center;background-color:#C7D9F1 ;color:#000000"  > PAYMENT TERMS </th>
											
											
										</tr>
										<tr>
											<td  colspan="3" style="text-align:center;font-weight:bold">  <?=strtoupper($delivery_time)?>  </td>
												<td  colspan="3" style="text-align:center;font-weight:bold"> <?=strtoupper($payment_terms)?>	 </td>
									 
									 	</tr>
									 
									</table>
										<table cellspacing="0" border="1"  cellpadding="0" style="" width="100%">
										<tr>
										   <th width="11%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">SIZE & PACKING</th>
										   <th width="9%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">DESIGN NAME</th>
										   <th width="6%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">FINISH</th>
										   <th width="16%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">IMAGE	</th>
									
										   <th width="8%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">BOXES PER PALLET	</th>
										   	   <th width="8%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">Total Cont.		</th>
										   <th width="8%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">TOTAL PALLET	</th>
										   <th width="6%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">TOTAL BOXES</th>
										   <th width="8%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">QUANTITY IN SQM </th>
										   <th width="8%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">RATE (Sq.FEET)</th>
										   <th width="12%" style="text-align:center;background-color:#C7D9F1 ;color:#000000">AMOUNT </th>
								 	   </tr>
								<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$no_of_row = 4;
								 
								foreach ($product_data as $jsonalldata)
								{  
									 
								
									 $n = 1;
								
								   foreach($jsonalldata->packing  as $packing_row)
								  {
									  
								?>
									<tr>
										<td style="text-align:center"><?=$jsonalldata->size_type_mm?> <br> PCS/BOX : <?=$jsonalldata->pcs_per_box?>  <br> SQM/BOX : <?=$jsonalldata->sqm_per_box?>   </td>
									 	<td style="text-align:center;">
											<?=$packing_row->model_name?>
									 	</td>
										<td style="text-align:center;" ><?=$packing_row->finish_name?></td>
									
									    <td style="color:#000000;text-align:center">
											<p style="margin: 0 auto; width:90px;height:80px;overflow:hidden;text-align:center">
											  
											  <img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:110x"/> 
											 </p>
									 	</td>
										
											
											
									 	 <td style="text-align:center">
										<?php 
											$one_container = 0;

											if($packing_row->no_of_pallet > 0)
											{
												$product_plts = $jsonalldata->boxes_per_pallet;

												// Calculate one container for pallet type
												if (!empty($jsonalldata->box_per_container) && $jsonalldata->box_per_container > 0) {
													$one_container = $packing_row->no_of_boxes * 100 / $jsonalldata->box_per_container;
												}
											}
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet > 0)
											{
												$product_plts  =  $jsonalldata->box_per_big_pallet.'<br>'.$jsonalldata->box_per_small_pallet;

												// Calculate one container for big/small pallet mix
												if (!empty($jsonalldata->multi_box_per_container) && $jsonalldata->multi_box_per_container > 0) {
													$one_container = $packing_row->no_of_boxes * 100 / $jsonalldata->multi_box_per_container;
												}
											}
											else
											{
												$product_plts = '-';

												// Fallback for generic case
												if (!empty($jsonalldata->total_boxes) && $jsonalldata->total_boxes > 0) {
													$one_container = $packing_row->no_of_boxes * 100 / $jsonalldata->total_boxes;
												}
											}
											?>

											<?=$product_plts?> 
										</td>
										<td style="text-align:center;" ><?=number_format($one_container/100,2) ?></td>
										<td style="text-align:center">
										<?php 
											if($packing_row->no_of_pallet>0)
											{
											 	$no_of_pallet = $packing_row->no_of_pallet;
												  $Total_plts 	+= $packing_row->no_of_pallet;
											}
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
											{
												$no_of_pallet =  $packing_row->no_of_big_pallet.'<br>'.$packing_row->no_of_small_pallet;
												 $Total_plts 	+= $packing_row->no_of_big_pallet;
												 $Total_plts 	+= $packing_row->no_of_small_pallet;
										 	}
											else
											{
												 $no_of_pallet =  '-';
											}
										?>
										<?=$no_of_pallet?>
										</td>
										<td style="text-align:center"><?=$packing_row->no_of_boxes?>
										
											
										</td>
										 
										 <td style="text-align:center"><?=$packing_row->no_of_sqm?></td>
										<td style="text-align:center;color:#000000;font-size:11px;font-weight:bold"> <img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($packing_row->product_rate,2)?></td>
										<td style="text-align:center"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($packing_row->product_amt,2)?></td>
									</tr>
								<?php
								 	
									 $Total_box 	+= $packing_row->no_of_boxes;
									 $Total_sqm 	+= $packing_row->no_of_sqm;
									 $Total_ammount += $packing_row->product_amt;
									 if(!empty($jsonalldata->product_id))
									 {
										 $total_con += $one_container/100;
									 }
								 
								 
								 $no_of_row--;
								}
								}
								if(!empty($invoicedata->sample_remarks))
								{
									?>
								<tr>
									<th colspan="10" style="vertical-align:top;border-bottom:none;text-align:left" height="111px" > 
										<?=($invoicedata->sample_remarks)?>
									</th>
								    
								</tr>
								<?php
								$no_of_row--;
								}
								  ?>
								 
			 					 <tr>
										<td colspan="4" style="text-align:right;font-weight:bold;color:#000000;font-size:11px;">TOTAL</td>
										 <td style="text-align:center;font-weight:bold;color:#000000; "></td>
										<td style="text-align:center;font-weight:bold;color:#000000;font-size:11px; "><?=number_format($total_con,2,'.','')?></td>
										<td style="text-align:center;font-weight:bold;color:#000000;font-size:11px; "><?=$Total_plts?></td>
										<td style="text-align:center;font-weight:bold;color:#000000;font-size:11px; "><?=$Total_box?></td>
									 	<td style="text-align:center;font-weight:bold;color:#000000;font-size:11px; "><?=$Total_sqm?> </td>
										<td style="text-align:center;font-weight:bold;color:#000000; "> </td>
										<td style="text-align:center;font-weight:bold; "><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($Total_ammount,2)?> 
										</td>
								 </tr>
								 <tr>
										<td colspan="2" style="text-align:right;font-weight:bold">AMOUNT IN WORDS  </td>
										 
										<td colspan="6" style="font-weight:bold"> <?=strtoupper(converttorsword($invoicedata->grand_total))?> 
										</td>
										<td colspan="2" style="font-weight:bold;text-align:center"> SGST <?=$invoicedata->sgst_value?>% </td>
										<td style="font-weight:bold;text-align:center;"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />      <?=indian_number($invoicedata->sgst,2)?>
										</td>
								 </tr>	
								 <tr>
										 
										<td colspan="8" style="font-weight:bold">  
										</td>
										<td colspan="2" style="font-weight:bold;text-align:center"> CGST <?=$invoicedata->cgst_value?>%</td>
										<td style="font-weight:bold;text-align:center;"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($invoicedata->cgst,2)?>
										</td>
								 </tr>	
								  <tr>
										 
										<td colspan="8" style="font-weight:bold">  
										</td>
										<td colspan="2" style="font-weight:bold;text-align:center;font-size:11px"> Grand Total</td>
										<td style="font-weight:bold;text-align:center;color:#000000;font-size:11px"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($invoicedata->grand_total,2,'.',',')?>
										</td>
								 </tr>	
								 <tr>
										<td colspan="7" style="font-weight:bold;vertical-align:top;">
										    NOTE:
										    <br>
											<?=$invoicedata->remarks?>
										</td>
										 
										<td colspan="5" style="font-weight:bold;text-align:right;text-align:center"> 
											For, <?=$company_detail[0]->s_name?><br>
												<img src="<?=base_url().'upload/'.$company_detail[0]->s_c_sign?>" width="110px" height="100px">
												<br>
											<?=strtoupper($company_detail[0]->authorised_signatury)?>
									 	</td>
								 </tr>									 
						 </table>		
								</div>	
							 
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
<script>
function toExcel() {

    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#testTable').html()));
    e.preventDefault();
}
</script>