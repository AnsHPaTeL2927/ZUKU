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
			<?php $this->view('lib/sidebar');
				 
			?>
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
									PDF
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>Proforma Invoice
									 <div class="pull-right">
										<?=($invoicedata->confirm_status == 1)?'<a class="btn btn-defualt"  href="'.base_url().'create_producation/index/'.$invoicedata->performa_invoice_id.'"><i class="fa fa-eye"></i> Producation Sheet</a>':''?>
										
									<div class="dropdown" style="float:left;">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu" >
												<li>
										 
													<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="<?=base_url('performa_invoice_pdf/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>	
												 
													<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('performa_invoice_pdf/index_withoutfinish/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
													
													<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="<?=base_url('performa_invoice_pdf/index_withthickness/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
													
													<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="<?=base_url('performa_invoice_pdf2/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 4 (With Image,Without Barcode)</a>
												
													<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="<?=base_url('performa_invoice_pdf3/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 5</a>
													
													<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf4/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 6</a>
												
													<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 7 (Zuku Format)</a>
													
													<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (With Other Product)</a>
													
													<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_accord/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9</a>
													
													<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_olwin/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10</a>	

													<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf11/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 11 (Without Pallet)</a>
												</li>												
											</ul>
										</div>&nbsp;
									
										<button type="button" class="btn btn-primary" onclick="print_doc('print_content')"> <i class="fa fa-print"></i> Print </button>
										 <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
										
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
										<a href="<?=($invoicedata->confirm_status == 1)?base_url().'confirm_pi':base_url().'invoice_listing'?> ">Proforma Invoice List</a>
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
									<div id="print_content" style="margin-top:80px;" >
									<div class="profile-pic">
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
									<table cellspacing="0" border="1" cellpadding="0"  width="100%" class="main_table invoice_edit_cls">
									 	 <tr>
										  <td  width="60%" rowspan="2" style="border-left: 0.1px solid;border-right:none;">
										     <img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" width="<?=$company->head_logo_width?>" height="<?=$company->head_logo_height?>"   />
									        <br>
											</td>
											<td width="40%" style="text-align:right;border-bottom:none;border-left:none;">
												<div style="font-size:30px"><strong>Proforma Invoice </strong></div>
 
											</td>
											
									    </tr>
										<tr>
											 <td style="text-align:right;border-top:none;border-bottom:none;border-left:none;font-size:13;vertical-align:top;">
												 
												<span><strong>PI No : <?=$invoicedata->invoice_no?></strong> <br>  
												<strong>Date : <?=$performapacking_date?>  </strong> <br> 
												<strong> <?=!empty($invoicedata->buy_order_no)?'Buyer Order No & Date : '.$invoicedata->buy_order_no:''?>  </strong> <br> 
												</span>
											</td>
										</tr>
								</table>
									<table cellspacing="0" cellpadding="0"  width="100%" class="main_table invoice_edit_cls" border="1">
									 	<tr>
											<td colspan="3" style="border-right:none;border-bottom: none;">
												<strong>Exporter Detail</strong>				
											</td>
											<td colspan="3" style="border-bottom: none;">
												 <strong>Consignee/Importer</strong>										
											</td>
									 	</tr>
										<tr>
											<td colspan="3" style="vertical-align:top;border-bottom:none">
												 <?=$export?>
											</td>
											<td colspan="3" style="vertical-align:top;border-bottom:none">
												 <?=$consig_add?>
												 <br>
											 <?php 
											 if(!empty($buyother))
											 {
												 echo "<strong>Notify Party</strong><br>
												 
														".$buyother;
											 }
											 ?>
											</td>
									 	</tr>
										 <tr>
											<td colspan="3"  style="border-right:none;border-bottom: none;">
												<strong>Bank Detail</strong>				
											</td>
											<td colspan="3" style="border-bottom: none;">
												 <strong>Payment Detail </strong>										
											</td>
									 	</tr>
										 <tr>
											<td colspan="3"   style="vertical-align:top;border-right: none;border-bottom:none"> 
											 Account No. :  <?=$invoicedata->account_no?><br />
											 Account Name :  <?=$invoicedata->account_name?> <br />
											 Bank Name :  <?=$invoicedata->bank_name?><br />
											 Address :  <?=strip_tags($invoicedata->bank_address)?> <br />
											 Swift Code :  <?=$invoicedata->swift_code?><br />
											 Branch Code: <?=$invoicedata->ifsc_code?><br />
											</td>
											
											<td colspan="3" style="border-bottom: none;vertical-align:top">
												 <?=$payment_terms?> <br>
												 Rate : <?=$invoicevalue_say?> (IN <?=strtoupper($invoicedata->currency_name)?>)<br>
												Terms of Delivery : <?=$invoicevalue_say?> - <?=$invoicedata->terms_of_delivery?>
											</td>
									 	</tr>
										<tr>
											<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;" width="15%">Number Of Container  </td>
											<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;" width="15%"> Port Of Loading </td>
											<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;" width="15%"> Port Of Discharge </td>
											<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;" width="15%"> Final Destination</td>
											<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;" width="20%">  Country of Origin Of Goods </td>
											<td style="text-align:center;font-weight:bold;border-bottom: none;" width="20%"> Approx Weight of Container (KG) </td>
									 	</tr>
										<tr>
											<td style="text-align:center;border-bottom: none;border-right: none;"> 
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
												 ?>
											</td>
											<td style="text-align:center;border-bottom: none;border-right: none;"> <?=$invoicedata->port_of_loading?>   </td>
											<td style="text-align:center;border-bottom: none;border-right: none;"> <?=$invoicedata->port_of_discharge?>   </td>
											<td style="text-align:center;border-bottom: none;border-right: none;"> <?=$invoicedata->final_destination?>   </td>
											<td style="text-align:center;border-bottom: none;border-right: none;"> 
											<?=$invoicedata->country_origin_goods?>
											</td>
											<td style="text-align:center;border-bottom: none;"> <?=$invoicedata->limit_container?>	 </td>
									 	</tr>
									</table>
								 	<table cellspacing="0" cellpadding="0" style="" width="100%" border="1" class="invoice_edit_cls">
									 <?php
								$hsn_array=array();
	  							for($j=0; $j<count($product_data);$j++)
								{ 
									 
									
											if(!in_array($product_data[$j]->series_name.' - HSN CODE '.$product_data[$j]->hsnc_code,$hsn_array))
											{												
												array_push($hsn_array,$product_data[$j]->series_name.' - HSN CODE '.$product_data[$j]->hsnc_code);
											}
								}
								 
	  ?>
										<tr>
											<td style="text-align:center;font-weight:bold" colspan="12"> <?=implode(",",$hsn_array)?></td>
										</tr>
										<tr>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Size</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Name</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Image</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Finish</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Boxes/Pallet	</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Pallets	</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Boxes</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Container</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Rate  (<?=strtoupper($invoicedata->currency_name)?>)</td>
										    <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> Quantity </td>
											<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> Unit </td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;">Amount (<?=strtoupper($invoicedata->currency_name)?>)</td>
								 	   </tr>
									   
								<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$no_of_row = 1;
								$Total_con=0;
								$size_array = array();
								$hsn_array=array();
								for($i=0; $i<count($product_data);$i++)
								{ 
										if(!in_array($product_data[$i]->series_name,$hsn_array))
											{												
												array_push($hsn_array,$product_data[$i]->series_name);
											}
									 $Total_plts 	+= $product_data[$i]->total_no_of_pallet;
									 $Total_box 	+= $product_data[$i]->total_no_of_boxes;
									
									 $Total_ammount += $product_data[$i]->total_product_amt;
									 $Total_weight  += $product_data[$i]->total_gross_weight;
									 $n = 1;
							 	  foreach($product_data[$i]->packing  as $packing_row)
								  {
												if(!in_array($product_data[$i]->size_type_mm.$packing_row->box_design_name,$size_array))
												 {
													  array_push($size_array,$product_data[$i]->size_type_mm.$packing_row->box_design_name);
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['size_type_mm'] = $product_data[$i]->size_type_cm;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['box_design_name'] = $packing_row->box_design_name;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['pallet_type_name'] = $packing_row->pallet_type_name;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
													    
												}
									 
								?>
									<tr>
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$product_data[$i]->size_type_cm?><br>
										PCS/BOX : <?=$product_data[$i]->pcs_per_box?></td>
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$packing_row->model_name?></td>
										 <td style="text-align:center;border-bottom: none;border-right: none;"><p style="margin: 0 auto;width:50px;height:50px;overflow:hidden;position: relative;">
												<img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:60px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;"/> 
											 </p></td>
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$packing_row->finish_name?></td>
										
									 
										<td style="text-align:center;border-bottom: none;border-right: none;">
										<?php 
										  
											 if($packing_row->no_of_pallet>0)
											 {
											 	$product_plts = $product_data[$i]->boxes_per_pallet;
											 	
											 }
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet >0)
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
										<td style="text-align:center;border-bottom: none;border-right: none;">
										<?php 
											if($packing_row->no_of_pallet>0)
											{
											 	$no_of_pallet = $packing_row->no_of_pallet;
												$plts_per_container = $product_data[$i]->total_pallent_container;
											 	$one_container = $packing_row->no_of_boxes * 100 / $product_data[$i]->box_per_container;  
											}
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet >0)
											{
												$no_of_pallet =  $packing_row->no_of_big_pallet.'<br>'.$packing_row->no_of_small_pallet;
												
												$plts_per_container = $product_data[$i]->no_big_plt_container_new.'<br>'.$product_data[$i]->no_small_plt_container_new;
											
												$one_container = $packing_row->no_of_boxes * 100 / $product_data[$i]->multi_box_per_container; 
										 	}
											else
											{
												 $no_of_pallet =  '-';
												 $Total_plts ='-';
												 $plts_per_container = '-';
												$one_container = $packing_row->no_of_boxes * 100 / $product_data[$i]->total_boxes; 
											}
											$one_container = ($one_container == INF)?" - ":number_format($one_container/100,2);
										?>
										<?=$no_of_pallet?>
										</td>
										
										
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$packing_row->no_of_boxes?></td>
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$one_container?></td>
									 
										 <td style="text-align:center;border-bottom: none;border-right: none;"><?=$currency_symbol?><?=number_format($packing_row->product_rate,2,'.','')?></td>
										 
										 <td style="text-align:center;border-bottom: none;border-right: none;">
										
											<?php 
										
											if($packing_row->per == "SQM")
											{
											 	echo number_format($packing_row->no_of_sqm,2,'.','');
												 $total_product_sqmlm += $packing_row->no_of_sqm;
								
											}
											else if($packing_row->per == "BOX")
											{
												echo number_format($packing_row->no_of_boxes,2,'.','');
												 $total_product_sqmlm += $packing_row->no_of_boxes;
										 	}
											else if($packing_row->per == "SQF")
											{
												 echo number_format(($packing_row->no_of_boxes * $product_data[$i]->feet_per_box),2,'.','');
												  $total_product_sqmlm += ($packing_row->no_of_boxes * $product_data[$i]->feet_per_box);
											}
											else if($packing_row->per == "PCS")
											{
												 echo number_format(($packing_row->no_of_boxes * $product_data[$i]->pcs_per_box),2,'.','');
												 $total_product_sqmlm += ($packing_row->no_of_boxes * $product_data[$i]->pcs_per_box);
											}
										?>
										
										</td>
										<td style="text-align:center;border-bottom: none;border-right: none;">
										
											<?=$packing_row->per?>
										
										</td>
										 
										<td style="text-align:center;border-bottom: none;"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2,'.','')?></td>
									</tr>
								<?php
								$Total_con += $one_container;
								$Total_box += $category->packing_boxes;
								  
								 $no_of_row--;
								}
								}
								?>
								 
			 					 <tr>
										<td colspan="5" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Total</td>
										 
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=$Total_plts?> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=$Total_box?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=($Total_con == 0.00)?"-":number_format($Total_con,2)?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=number_format($total_product_sqmlm,2,'.','')?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
									if($invoicedata->certification_charge > 0)
									{
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Certification Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->certification_charge,2,'.','')?> 
										</td>
								 </tr>
								 
								 <?php 
								 } 
								 if($invoicedata->insurance_charge > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Insurance Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->insurance_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->seafright_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Seafright Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->seafright_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->courier_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Courier Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->courier_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if(!empty($invoicedata->extra_calc_name))
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"><?=$invoicedata->extra_calc_name?> (<?=($invoicedata->extra_calc_opt == 1)?'+':'-'?>)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?> <?=number_format($invoicedata->extra_calc_amt,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 if($invoicedata->bank_charge > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Bank Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->bank_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								  if($invoicedata->discount > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Discount</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->discount,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 if($invoicedata->igst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">IGST (<?=number_format($invoicedata->igst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?> <?=number_format($invoicedata->igst_value,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  if($invoicedata->sgst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">SGST (<?=number_format($invoicedata->sgst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->sgst_value,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  if($invoicedata->cgst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="3" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">CGST (<?=number_format($invoicedata->cgst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->cgst_value,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 ?>
								 <tr>
										<td colspan="2" style="text-align:right;border-bottom: none;border-right: none;font-weight:bold">Total Amount In Words  </td>
										<td colspan="7" style="border-bottom: none;font-weight:bold;    border-right: none;"> <?=($invoicedata->currency_name == "INR")?strtoupper(converttorsword($invoicedata->grand_total,$invoicedata->currency_name)):strtoupper(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?> ONLY
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Total <?=$invoicedata->terms_name?> Value</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->grand_total,2,'.','')?> 
										</td>
								 </tr>
								  
								 <tr>
										<td rowspan="2"  colspan="6" style="border-right:1px soild;vertical-align:top;">
											<strong> Additional Detail :</strong>
											<br>
											  Back side of Tiles LOGO: <?=$invoicedata->made_in_india_status?><br>
											AirBag: <?=$invoicedata->air_bag_status?> 	<br>
										 	Pallet Cap: <?=$invoicedata->pallet_cap_name?> <br>
											Fumigation: <?=$invoicedata->fumigation_name?> 	<br>
											Moisture Bag:  <?=$invoicedata->mosqure_bag_status?> <br>
											<p style="float:left;width:100%">
											
											<?php 
												if(!empty($invoicedata->remarks))
												{
											?>
											<br><strong> Note :</strong><br>
											<?=$invoicedata->remarks?>
											   <?php
												}
		  
		  if(!empty($invoicedata->special_requirment))
		  {
		 
		?>
											<br><br><strong> Special Requirement  :</strong><br>
											<?=$invoicedata->special_requirment?>
											   <?php
		  }
		  
		  if(!empty($invoicedata->note))
		  {
		 
		?>
											<br><br><strong> Sample Requirement :</strong><br>
											<?=$invoicedata->note?>
											   <?php
		  }
		  ?>
								</p>
								</td>
										<td colspan="6" style="border-right:1px soild;vertical-align:top;">
											
											<strong> Pallet type/Box design Summary:</strong>
											<table cellspacing="0" cellpadding="0" style="margin:0px;width:100%"  border="1" >
											<tr>
												<th width="20%" style="text-align:center" >Size</th>
												<th width="20%" style="text-align:center" >Pcs per box</th>
												<th width="20%" style="text-align:center" >Approx Sqm per box</th>
												<th width="20%" style="text-align:center" >Pallet Type</th>
												<th width="20%" style="text-align:center" >Box Design Type</th>
											</tr>
											
							<?php
									$pallet_type_name = '';
									$box_design_name = '';
										for($p=0;$p<count($size_array);$p++)
										{
											if(!empty($size_array[$p]))
											{
												?>
												<tr>
													<td style="text-align:center"><?=$size_array[$size_array[$p]]['size_type_mm']?></td>
													<td style="text-align:center"><?=$size_array[$size_array[$p]]['pcs_per_box']?></td>
													<td style="text-align:center"><?=$size_array[$size_array[$p]]['sqm_per_box']?></td>
													<td style="text-align:center"><?=$size_array[$size_array[$p]]['pallet_type_name']?></td>
													<td style="text-align:center"><?=$size_array[$size_array[$p]]['box_design_name']?></td>
													 
												</tr>
												<?php 
												 
											}
										}
										?>
						 </table>
										
										
										</td>
								 </tr>
								 <?php 
								 if(!empty($invoicedata->sign_pi_status))
								 {
								 ?>
								 <tr>
									 	<td colspan="6" style="font-weight:bold;vertical-align:bottom;text-align:right"> 
											For,
											<?=$invoicedata->for_signature_name?><br><br>
											<img src="<?=base_url().'upload/user/'.$invoicedata->sign_image?>"  width="180px">
											<br>
											 
											<?=strtoupper($invoicedata->authorised_signatury)?>
															 
										</td>
								 </tr>	
								<?php
								}
								else
								{
								?>	
								 <tr>
									 	<td colspan="6" style="font-weight:bold;vertical-align:bottom;text-align:right"> 
											For,
											<?=$company->s_name?><br><br>
											<img src="<?=base_url().'upload/'.$company->s_c_sign?>"  width="<?=$company->s_c_sign_width?>" height="<?=$company->s_c_sign_height?>">
											<br>
											<br>
											<?=strtoupper($company->authorised_signatury)?>
															 
										</td>
								 </tr>
								<?php 
								 }
								 
								?>								 
						 </table>
 				 <?php
								}
								?>
											</div>		 
										</div>
									</div>
									<?php
								 
									 $output = ob_get_contents(); 
									 $_SESSION['performa_invoice_no'] = 'PI '.$invoicedata->invoice_no.' - '.$invoicedata->c_name.' '.$invoicedata->country_final_destination.' V'.$invoicedata->version.' '.date('d-m-Y',strtotime($invoicedata->performa_date));
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
			"performa_invoice_pdf"	: 'performa_invoice_pdf1'
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
			"invoice_table_name"	: 'performa_invoice_pdf1'  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}
function print_doc(html)
{
  var disp_setting="toolbar=yes,location=no,";
  disp_setting+="directories=yes,menubar=yes,";
  disp_setting+="scrollbars=yes,width=800, height=600, left=100, top=25";
  var content_vlue = document.getElementById(html).innerHTML;
  var docprint=window.open("","",disp_setting);
  docprint.document.open();
  docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
  docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
  docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
  docprint.document.write('<head><title><?='PI '.$invoicedata->invoice_no.' - '.$invoicedata->c_name.' '.$invoicedata->country_final_destination.' V'.$invoicedata->version.' '.date('d-m-Y',strtotime($invoicedata->performa_date))?></title>');
  docprint.document.write('<style type="text/css">');
  docprint.document.write(' @media print{ @page { size:A4; margin: 0.2in 0.2in 0.2in 0.2in; } }');	 
  docprint.document.write('body { font-family:Tahoma;color:#000;');
  docprint.document.write('font-family:Tahoma,Verdana; font-size:10px;} .dataTables_length, .dataTables_filter , .dataTables_paginate { display:none; }');
  docprint.document.write('table tr td{border:0.2px solid gray;padding:5px;text-align: left;} table tr th{border:0.2px solid;padding:5px;text-align: left;}.main_tbl{page-break-after  : always}</style>');
  docprint.document.write('</head><body onLoad="self.print()">');
  docprint.document.write(content_vlue);
  docprint.document.write('</body></html>');
  docprint.document.close();
  docprint.focus();
  $('#table_head').show();
  location.reload();
}
 
 
function toExcel() {

    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#print_content').html()));
    e.preventDefault();
}
 
</script>