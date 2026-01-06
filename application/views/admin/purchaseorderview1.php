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
											
											<td colspan="12" style="text-align:center;">
												<strong style="font-size: 20px;"> PURCHASE ORDER</strong>
											</td>
									 	</tr>
										<tr>
											<td rowspan="3"  colspan="3"  style="border-right:none">
												<?=$export?>
												EMAIL:<?=$company_detail[0]->s_email?>
											</td>
											<td rowspan="3" colspan="3"  style="border-left:none">	
												 <img src="<?=base_url().'upload/'.$company_detail[0]->s_image?>" style="width:150px;height:60px"/>
											</td>
											<td colspan="6" style="border-top:none;border-bottom: none;">
												<strong>Purchase Order No: </strong> <?=$purchase_order_no?> 
											</td>
												 
									 	</tr>
										<tr>
											 	<td  colspan="6"  style="border-top:none;border-bottom: none;">
													<strong>DATE : </strong><?=$purchase_order_date?>
											 	</td>
												 
									 	</tr>
										<tr>
											 	<td colspan="6" style="border-top:none;border-bottom: none;">
													<strong>Seller Ref. No :</strong><?=$seller_ref_no?>
											 	</td>
												 
									 	</tr>
										<tr>
										 	<td colspan="6"  style="color:#0073ff">
												 <strong>SELLER DETAILS</strong>										
											</td>
											<th   colspan="3" style="text-align:center" >NUMBER OF CONTAINER</th>
											<td  colspan="3"  style="text-align:center">
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
									 	</tr>
										<tr>
										 	<td colspan="6" rowspan="3" style="vertical-align:top;">
												<?=$supplier_name?><br>
													<?=$supplier_address?><br>
													PAN NO : <?=$supplier_panno?><br>
													GSTIN : <?=$supplier_gstin?>  
											</td>
											<th  colspan="3"  style="text-align:center"  > PORT OF LOADING </th>
												<td  colspan="3"  style="text-align:center"> <?=strtoupper($invoicedata->port_of_loading)?>  </td>
										</tr>
										 
										<tr>
											<th  colspan="3" style="text-align:center"  >DELIVERY TIME </th>
											<td  colspan="3" style="text-align:center">  <?=strtoupper($delivery_time)?>  </td>
											
										</tr>
										<tr>
											<th  colspan="3" style="text-align:center"  > PAYMENT TERMS </th>
												<td  colspan="3" style="text-align:center"> <?=strtoupper($payment_terms)?>	 </td>
									 
									 	</tr>
									 
									</table>
										<table cellspacing="0" border="1"  cellpadding="0" style="" width="100%">
										<tr>
										   <th width="12%" style="text-align:center;">SIZE & PACKING</th>
										   <th width="10%" style="text-align:center;">DESIGN NAME</th>
										   <th width="6%" style="text-align:center;">FINISH</th>
										   <th width="16%" style="text-align:center;">IMAGE	</th>
										   <th width="10%" style="text-align:center;">BOXES PER PALLET	</th>
										   <th width="8%" style="text-align:center;">TOTAL PALLET	</th>
										   <th width="8%" style="text-align:center;">TOTAL BOXES</th>
										   <th width="10%" style="text-align:center;">QUANTITY IN SQM </th>
										   <th width="10%" style="text-align:center;">RATE (Sq.FEET)</th>
										   <th width="10%" style="text-align:center;">AMOUNT </th>
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
									    <td style="text-align:center">
											<p style="margin: 0 auto; width:130px;height:107px;overflow:hidden">
											  
											  <img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:119px"/> 
											 </p>
									 	</td>
									 	 <td style="text-align:center">
										<?php 
											 if($packing_row->no_of_pallet>0)
											 {
											 	$product_plts = $jsonalldata->boxes_per_pallet;
											 	
											 }
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
											{
											  	$product_plts  =  $jsonalldata->box_per_big_pallet.'<br>'.$jsonalldata->box_per_small_pallet;
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
										<td style="text-align:center"><?=$packing_row->no_of_boxes?></td>
										 
										 <td style="text-align:center"><?=$packing_row->no_of_sqm?></td>
										<td style="text-align:center"> <img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($packing_row->product_rate,2)?></td>
										<td style="text-align:center"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($packing_row->product_amt,2)?></td>
									</tr>
								<?php
								 	
									 $Total_box 	+= $packing_row->no_of_boxes;
									 $Total_sqm 	+= $packing_row->no_of_sqm;
									 $Total_ammount += $packing_row->product_amt;
								 
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
										<td colspan="4" style="text-align:right;font-weight:bold;">TOTAL</td>
										 <td style="text-align:center;font-weight:bold;"></td>
										<td style="text-align:center;font-weight:bold;"><?=$Total_plts?></td>
										<td style="text-align:center;font-weight:bold;"><?=$Total_box?></td>
									 	<td style="text-align:center;font-weight:bold;"><?=$Total_sqm?> </td>
										<td style="text-align:center;font-weight:bold;"> </td>
										<td style="text-align:center;font-weight:bold;"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($Total_ammount,2)?> 
										</td>
								 </tr>
								 <tr>
										<td colspan="2" style="text-align:right;font-weight:bold">AMOUNT IN WORDS  </td>
										 
										<td colspan="5" style="font-weight:bold"> <?=strtoupper(converttorsword($invoicedata->grand_total))?> 
										</td>
										<td colspan="2" style="font-weight:bold"> SGST <?=$invoicedata->sgst_value?>% </td>
										<td style="font-weight:bold;text-align:center;"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />      <?=indian_number($invoicedata->sgst,2)?>
										</td>
								 </tr>	
								 <tr>
										 
										<td colspan="7" style="font-weight:bold">  
										</td>
										<td colspan="2" style="font-weight:bold"> CGST <?=$invoicedata->cgst_value?>%</td>
										<td style="font-weight:bold;text-align:center;"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($invoicedata->cgst,2)?>
										</td>
								 </tr>	
								  <tr>
										 
										<td colspan="7" style="font-weight:bold">  
										</td>
										<td colspan="2" style="font-weight:bold"> Grand Total</td>
										<td style="font-weight:bold;text-align:center;"><img src="<?=base_url().'adminast/assets/images/ruppe_sysbol.jpg'?>" />   <?=indian_number($invoicedata->grand_total,2,'.',',')?>
										</td>
								 </tr>	
								 <tr>
										<td colspan="7" style="font-weight:bold;vertical-align:top;">
											<?=$invoicedata->remarks?>
										</td>
										 
										<td colspan="5" style="font-weight:bold;text-align:right"> 
											For, <?=$company_detail[0]->s_name?><br>
												<img src="<?=base_url().'upload/'.$company_detail[0]->s_c_sign?>" width="100px" height="100px">
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