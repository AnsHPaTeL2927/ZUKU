<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
$export =  ($invoicedata->exporter_detail);
$performapacking_date = date('d/m/Y',strtotime($invoicedata->performa_date));
$consig_add =  ($invoicedata->consign_detail);
$buyother = ($invoicedata->buyer_other_consign);
$payment_terms =   nl2br($invoicedata->payment_terms);
$time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";

$locale='en-US'; //browser or user locale
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
$currency_symbol = ($invoicedata->currency_code=="INR")?"<img src='".base_url()."adminast/assets/images/ruppe_sysbol.jpg' />":$currency_symbol;


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
	top: 208px;
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
										<?=($invoicedata->confirm_status == 1)?'<a class="btn btn-defualt"  href="'.base_url().'create_producation/index/'.$invoicedata->performa_invoice_id.'"><i class="fa fa-eye"></i> Producation Sheet</a>':''?>
									
								<!--	<div class="dropdown" style="float:left;">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
											 
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI  (With Other Product)</a>
											
																						 </li>											 
											</ul>
										</div>&nbsp;-->
								
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
								<?php 
								if(!empty($invoice_html_data))
								{
									echo '<div class="pull-right">
											<a class="btn btn-danger tooltips" data-title="Delete" href="javascript:;"  onclick="delete_editable('.$invoicedata->performa_invoice_id.')"   ><i class="fa fa-trash"></i> Delete (Edited version)</a>
										</div>	
										';
								}
								?>
								<div class="panel-body form-body">
								
								
								 <?php ob_start();?>
									<div id="print_content">
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
										  <td  width="100%" style="border-left: 0.1px solid;border-right:none;">
									        <img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" width="<?=$company->head_logo_width?>" height="<?=$company->head_logo_height?>"/>
									        </td>
									    </tr>
										<tr>
											<td  style="text-align:center;border-bottom:none;border-left:none;">
											  <div><strong style="font-size:22px">Pending Proforma Loading Data </strong></div>
											</td>
										</tr>
								</table>
									<table cellspacing="0" cellpadding="0"  width="100%" class="main_table invoice_edit_cls" border="1" style="font-size:12px;">
									 	<tr>
									 	  <td width="48%" colspan="2"  style="border-right:none;border-bottom: none;"><strong>Exporter</strong></td>
									 	  <td width="48%" colspan="2"  style="border-right:none;border-bottom: none;"><strong>Proforma Invoice No. :  <?=$invoicedata->invoice_no?>
                                           </strong></td> 
										   <!--<td width="14%" colspan="2"  style="border-right:none;border-bottom: none;"><strong>Master No
                                           </strong></td>-->
									 	 <!-- <td colspan="2" rowspan="2" style="border-bottom: none;" valign="top">
											</td>-->
											
										
								 	  </tr>
									 <tr>
									 	  <td colspan="2" style="border-right:none;border-bottom: none;" valign="top"><?=$export?>
										<hr style="height:1px; margin-top:-1px;"/>
										  <strong>Consignee</strong>
										  <br>
										  <?=$consig_add?>										  
										  </td>
										
										 <td colspan="2"  style="border-right:none;border-bottom: none;" valign="top">
											Date : <?=$performapacking_date?>
											<br />
											Buyer Order No &amp; Date :
											<?=$invoicedata->buy_order_no?>
											<br />
											Exporter IEC code :
											<span class="font-12 dark-bg dbg-text-color pad10">
											<?=$company->s_iec?>
											</span><br />
											Exporter GSTIN  :
											<span class="font-12 dark-bg dbg-text-color pad10">
											<?=$company->s_gst?>
											</span>	<br>										
											<b>MASTER NO  :
											<span class="font-12 dark-bg dbg-text-color pad10">
											<?=$invoicedata->c_name?>
											</span></b>
											<!--Bank Detail Starts here-->
											<hr style="height:1px; margin-top:-1px;"/>
											<strong>Bank Detail:</strong>
											<br>
											 Name of company  :
											<?=$invoicedata->account_name?>
											<br />
											Account No. :
											<?=$invoicedata->account_no?>
										   <br />
																				 
											Name of Bank :
											<?=$invoicedata->bank_name?>
											<br />
											Address of Bank :
											<?=strip_tags($invoicedata->bank_address)?>
											<br />
											Swift Code :
											<?=$invoicedata->swift_code?>
											<br />
											Branch Code:
											<?=$invoicedata->ifsc_code?><br />
											IBAN NO  : <?=$invoicedata->iban_no?>
										</td> 
									<!--	<td colspan="2"  style="border-right:none;border-bottom: none;" valign="top">
											 <?=$invoicedata->c_name?>
										</td>-->
									</tr>		
										
								
									 	<tr>
										
										  <td colspan="2"  rowspan="6" style="vertical-align:top;border-right: none;border-bottom:none">										
											 <?php 
											  if(!empty($invoicedata->buyer_other_consign))
											  {
											 
											?>
										    <strong>Buyer If Other Then Consignee </strong>[Notify]
											<br />	
											<?=$invoicedata->buyer_other_consign?>
                                            <?php } ?>
											
											<hr/>
											<strong>Payment Terms </strong>
											<br>
											 <?=$payment_terms?> 
											 <br>
											Rate : <?=$invoicevalue_say?> (IN <?=strtoupper($invoicedata->currency_name)?>) <?=$invoicedata->terms_of_delivery?>
										</td>
											
											<td style="border-bottom: none;">Country of origin of Goods</td>
											<td style="border-bottom: none;"><?=$invoicedata->country_origin_goods?></td>
											
										
									 	</tr>
										<tr>
										  	<td width="26%" style="vertical-align:top;border-bottom:none">Country of Final Destination</td>
											<td width="26%" style="vertical-align:top;border-bottom:none"><?=$invoicedata->final_destination?>
										    &nbsp;</td>
									  </tr>
									  <tr>
										  <td style="vertical-align:top;border-bottom:none">Port of Loading</td>
										  <td style="vertical-align:top;border-bottom:none"><?=$invoicedata->port_of_loading?></td>
									  </tr>
										<tr>
										  <td style="vertical-align:top;border-bottom:none">Port of Discharge</td>
										  <td style="vertical-align:top;border-bottom:none"><?=$invoicedata->port_of_discharge?></td>
									  </tr>
										<tr>
										  <td style="vertical-align:top;border-bottom:none">Terms of Delivery </td>
										  <td style="vertical-align:top;border-bottom:none"><?=$invoicedata->terms_of_delivery?></td>
									  </tr>
									  <tr>
										  <td style="vertical-align:top;border-bottom:none">Latest Date of Shipment</td>
										  <td style="vertical-align:top;border-bottom:none"><?=$invoicedata->delivery_period?></td>
									  </tr>
									<!--	<tr>
										  <td style="vertical-align:top;border-bottom:none"><strong>Payment Terms </strong></td>
										  <td style="vertical-align:top;border-bottom:none">&nbsp;</td>
									  </tr>
										 <tr>
											<td colspan="2" style="border-bottom: none;">
												 <?=$payment_terms?> <br>
												 Rate : <?=$invoicevalue_say?> (IN <?=strtoupper($invoicedata->currency_name)?>) <?=$invoicedata->terms_of_delivery?>											</td>
									 	</tr>-->
									  </table>
								 	<table cellspacing="0" cellpadding="0" style="" width="100%" border="1" style="font-size:10px;" class="invoice_edit_cls">
										<tr>
										  <td colspan="2" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"></td>
										  <td colspan="5" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">
										  Description of Product   <br>
										  
										  <?php
							// $hsn_array=array();
							// $water_array=array();
							// $size_array=array();
							// $seriesname_array=array();
	  							// for($j=0; $j<count($product_data);$j++)
								// { 
									 
												// if(!in_array($product_data[$j]->size_type_mm,$size_array))
												 // {
													  // array_push($size_array,$product_data[$j]->size_type_mm);
													   // $size_array[$product_data[$j]->size_type_mm]['size_type_mm'] = $product_data[$j]->size_type_cm;
													   // $size_array[$product_data[$j]->size_type_mm]['box_design_name'] = $product_data[$j]->box_design_name;
													   // $size_array[$product_data[$j]->size_type_mm]['weight_per_box'] = $product_data[$j]->weight_per_box;
													   // $size_array[$product_data[$j]->size_type_mm]['total_net_weight'] = $product_data[$j]->total_net_weight;
													   // $size_array[$product_data[$j]->size_type_mm]['total_gross_weight'] = $product_data[$j]->total_gross_weight;
													   // $size_array[$product_data[$j]->size_type_mm]['thickness'] = $product_data[$j]->thickness;
													   // $size_array[$product_data[$j]->size_type_mm]['box_design_img'] = $product_data[$j]->box_design_img;
													   // $size_array[$product_data[$j]->size_type_mm]['pallet_type_name'] = $product_data[$j]->pallet_type_name;
													   // $size_array[$product_data[$j]->size_type_mm]['pcs_per_box'] = $product_data[$j]->pcs_per_box;
													   // $size_array[$product_data[$j]->size_type_mm]['sqm_per_box'] = $product_data[$j]->sqm_per_box;
												// }
									// if(!in_array(trim($product_data[$j]->series_name.' - '.$product_data[$j]->water_text),$seriesname_array))
									// {
										// if(!empty($product_data[$j]->series_name))
										// {
										// array_push($seriesname_array,$product_data[$j]->series_name.' - '.$product_data[$j]->water_text);
										// }
									// }									
								 	
									// if(!in_array($product_data[$j]->series_name.$product_data[$j]->hsnc_code,$hsn_array))
									// {		
										// if(!empty($product_data[$j]->hsnc_code))
										// {								
											// array_push($hsn_array,$product_data[$j]->series_name.$product_data[$j]->hsnc_code);
										// }
									// }
								// }
								//echo implode(" & ",$seriesname_array).implode(" & ",$hsn_array);
								?>&nbsp;
								
								</td>
										  <td colspan="7" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Packing Details</td>
										 
									  </tr>
										<tr>
										  <td width="3%" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Sr No</td>
										  <td  width="14%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Image</td>
										   <td width="9%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Size (mm)</td>
										   <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Name/ Code</td>
										   <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Client Name/ Code</td>
										 
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Finish/ Surface</td>
										   <td  width="7%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Category</td>
										     <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Cont.</td>
											 <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Boxes/ Pallet	</td>
											  
											
										   <td width="6%" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Pallets	</td>
										  
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Boxes</td>
										  
									      <td width="7%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Sq.mtrs</td>
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Rate per <?=strtoupper($invoicedata->per_value)?> (<?=strtoupper($invoicedata->currency_name)?>)</td>
										   
										   <td width="10%"  style="text-align:center;font-weight:bold;border-bottom: none;">Total Amount (<?=strtoupper($invoicedata->currency_name)?>)</td>-->
							 	      </tr>
								<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$finalamount = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$total_con=0;
								$no_of_row = 1;
								 $no=1;
								 $hsnc_code1 ='';
								$size_array = array();
								$hsn_array=array();
								
								// echo '<pre>';
// print_r($product_data);
// echo '</pre>';


								for($i=0; $i<count($product_data);$i++)
								{ 
									 
									 
									
									
									 $Total_ammount += $product_data[$i]->total_product_amt;
									 $Total_weight  += $product_data[$i]->total_gross_weight;
									 $n = 1;
								 
								  foreach($product_data[$i]->packing  as $packing_row)
								  {
											$key = $product_data[$i]->size_type_mm. $packing_row->box_design_name . $product_data[$i]->thickness. $product_data[$i]->pcs_per_box;

										if (!isset($size_array[$key])) {
											$size_array[$key] = [
												'series_name' => $product_data[$i]->series_name,
												'size_type_mm' => $product_data[$i]->size_type_mm,
												'size_type_cm' => $product_data[$i]->size_type_cm,
												'weight_per_box' => $product_data[$i]->weight_per_box,
												'total_net_weight' => $product_data[$i]->total_net_weight,
												'total_gross_weight' => $product_data[$i]->total_gross_weight,
												'thickness' => $product_data[$i]->thickness,
												'box_design_name' => $packing_row->box_design_name,
												'pallet_type_name' => $packing_row->pallet_type_name,
												'box_design_img' => $packing_row->box_design_img,
												'pcs_per_box' => $product_data[$i]->pcs_per_box,
												'sqm_per_box' => $product_data[$i]->sqm_per_box,
											];
										}
												
										$one_container = 0;
									
												if($packing_row->pending_big_pallets == 0 && $packing_row->pending_small_pallets == 0) {
													// Both big and small pallets are 0, use pending_pallets
													//$no_of_pallet = $packing_row->pending_pallets > 0 ? $packing_row->pending_pallets : '-';
													//$no_of_pallet1 = $packing_row->pending_pallets > 0 ? $packing_row->pending_pallets : '-';
													$one_container = $packing_row->pending_boxes * 100 / $product_data[$i]->box_per_container; 
												} else if($packing_row->pending_big_pallets > 0 || $packing_row->pending_small_pallets > 0) {
													// Show big and small pallets separately if any > 0
													//$no_of_pallet = $packing_row->pending_big_pallets.'<br><hr>'.$packing_row->pending_small_pallets;
													//$no_of_pallet1 = ($packing_row->pending_big_pallets + $packing_row->pending_small_pallets);
													$one_container = $packing_row->pending_boxes * 100 / $product_data[$i]->multi_box_per_container; 
												} else {
													// Fallback if everything is 0
													//$no_of_pallet = '-';
													//$no_of_pallet1 = '-';
													$one_container = $packing_row->pending_boxes * 100 / $product_data[$i]->total_boxes; 
												}
										
											 
											
									
											$hsnc_code = $product_data[$i]->series_name.' - HSN Code:'.$product_data[$i]->hsnc_code;
											 
								?>
										  <?php
										if ($product_data[$i]->extra_product == 1) {
											$hsnc_code = 'HSN Code: 69109000';
										} else {
											$hsnc_code = $product_data[$i]->series_name . ' - HSN Code:' . $product_data[$i]->hsnc_code;
										}

										if ($hsnc_code != $hsnc_code1) {
									?>
											<tr>
												<td colspan="14" style="text-align:center;font-weight:bold">
													<?=$hsnc_code?>
												</td>
											</tr>
									<?php 
										}

										// Update previous HSN code for next comparison
										$hsnc_code1 = $hsnc_code;
									?>

									<tr>
									  <td style="text-align:center;border-right: none;"><?=$no?></td>
									  <td style="text-align:center;border-right: none;">
										<p style="margin: 0 auto; width:98px;height:95px;overflow:hidden">
											<?php 
											if($product_data[$i]->extra_product == 1)
											{
											?>
													<img src="<?=(!empty($packing_row->other_image))?DESIGN_PATH.$packing_row->other_image:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
											 <?php											
											}
											else
											{
												 
											?>
												<img src="<?=(!empty($packing_row->design_file))?base_url().'upload/design/'.$packing_row->design_file:base_url().'upload/design/'.'No-image-found.jpg'?>" style="width:95px"/> 
											<?php 
											}
											?>
											 </p>
									  
									   </td>
										<?php 
											if(empty($product_data[$i]->product_id))
											{
											?>
												<td colspan="5" style="text-align:center;border-right: none;"><?=$product_data[$i]->description_goods?>
												<br>											
												<b>Net Weight : </b><?=$product_data[$i]->total_net_weight?><br>		
												<b>Gross Weight : </b><?=$product_data[$i]->total_gross_weight?>
												
												</td>
										 
											<?php 
											}
											else
											{
											?>
										<td style="text-align:center;border-right: none;"><?=$product_data[$i]->size_type_mm?></td>
										<td style="text-align:center;border-right: none;"><?=$packing_row->model_name?></td>
										<td style="text-align:center;border-right: none;"><?=$packing_row->client_name?></td>
										 
										<td style="text-align:center;border-right: none;"><?=$packing_row->finish_name?></td>
										
										<td style="text-align:center;border-right: none;"><?=$packing_row->no_of_randome?></td>
										 <?php 
											}
											?>
										<td style="text-align:center;border-right: none;">
										<?=(empty($product_data[$i]->product_id))?"-":number_format($one_container/100,2)?>
										 </td>
										<td style="text-align:center;border-right: none;">
										 
											<?=$product_plts?> 
										</td>
										 
										
										<td style="text-align:center;border-right: none;">
											<?php 
												if($packing_row->pending_big_pallets == 0 && $packing_row->pending_small_pallets == 0) {
													// Both big and small pallets are 0, use pending_pallets
													$no_of_pallet = $packing_row->pending_pallets > 0 ? $packing_row->pending_pallets : '-';
													$no_of_pallet1 = $packing_row->pending_pallets > 0 ? $packing_row->pending_pallets : '-';
													$one_container = $packing_row->pending_boxes * 100 / $product_data[$i]->box_per_container; 
												} else if($packing_row->pending_big_pallets > 0 || $packing_row->pending_small_pallets > 0) {
													// Show big and small pallets separately if any > 0
													$no_of_pallet = $packing_row->pending_big_pallets.'<br><hr>'.$packing_row->pending_small_pallets;
													$no_of_pallet1 = ($packing_row->pending_big_pallets + $packing_row->pending_small_pallets);
													$one_container = $packing_row->pending_boxes * 100 / $product_data[$i]->multi_box_per_container; 
												} else {
													// Fallback if everything is 0
													$no_of_pallet = '-';
													$no_of_pallet1 = '-';
													$one_container = $packing_row->pending_boxes * 100 / $product_data[$i]->total_boxes; 
												}
											?>
											<?=$no_of_pallet?>
											
											</td>

										
										
										<td style="text-align:center;border-right: none;">
											<?=$packing_row->pending_boxes?>
											
										
											
											
										</td>
										 
										<td style="text-align:center;border-right: none;"><?=number_format($packing_row->pending_sqm,2,'.','')?></td>
										<td style="text-align:center;border-right: none;"><?=$currency_symbol?>
									    <?=number_format($packing_row->product_rate,2,'.','')?></td>
										
										<td style="text-align:center;"><?=$currency_symbol?><?=number_format(($packing_row->pending_sqm * $packing_row->product_rate),2,'.','')?></td>
									</tr>
								<?php
								$no++;
								//$Total_box += $product_data[$i]->remaining_boxes;
								 $Total_box 	+= $packing_row->pending_boxes;
									 $Total_sqm 	+= $packing_row->pending_sqm;
								$Total_plts 	+= $no_of_pallet1;
								 $finalamount 	+= ($packing_row->pending_sqm * $packing_row->product_rate);
								$total_product_sqmlm += $category->packing_sqmlm;
								 if(!empty($product_data[$i]->product_id))
								 {
									 $total_con += $one_container/100;
								 }
								 $no_of_row--;
								}
								}
							?>
								 
			 					 <tr>
										<td colspan="7" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">TOTAL >>>>>>>>>></td>
									<!--<?php
									$rounded_total_con = (fmod($total_con, 1) <= 0.50) ? floor($total_con) : ceil($total_con);
									?>-->
									<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">
										<?= number_format($total_con, 2, '.', '') ?>
									</td>

										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">   </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=$Total_plts?> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=$Total_box?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"><?=number_format($Total_sqm,2,'.','')?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">&nbsp;</td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($finalamount,2,'.','')?> 
										</td>
								 </tr>
			 					  
								 <?php 
									if($invoicedata->certification_charge > 0)
									{
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Certification Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->certification_charge,2,'.','')?> 
										</td>
								 </tr>
								 
								 <?php 
								 } 
								 if($invoicedata->insurance_charge > 0)
								 {
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Insurance Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->insurance_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->seafright_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Seafright Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->seafright_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->courier_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Courier Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->courier_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->bank_charge > 0)
								 {
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Bank Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->bank_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								  if(!empty($invoicedata->extra_calc_name))
								 {
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"><?=$invoicedata->extra_calc_name?> (<?=($invoicedata->extra_calc_opt == 1)?'+':'-'?>)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?> <?=number_format($invoicedata->extra_calc_amt,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  if($invoicedata->discount > 0)
								 {
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Discount</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->discount,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->igst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">IGST (<?=number_format($invoicedata->igst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->igst_value,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  if($invoicedata->sgst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">SGST (<?=number_format($invoicedata->sgst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->sgst_value,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  if($invoicedata->cgst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="11" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">CGST (<?=number_format($invoicedata->cgst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->cgst_value,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  
								 ?>
								 <tr>
										<td colspan="3" style="text-align:right;border-bottom: none;border-right: none;font-weight:bold">TOTAL 
										  <?=$invoicedata->terms_name?>
                                          <?=strtoupper($invoicedata->currency_name)?>
(IN WORDS)</td>
										<td colspan="8" style="border-bottom: none;font-weight:bold;    border-right: none;"> <?=strtoupper(convertamonttousd($finalamount,$invoicedata->currency_name))?> ONLY
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Total <?=$invoicedata->terms_name?> Value</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($finalamount,2,'.','')?> 
										</td>
								 </tr>
								  
								<!-- <tr>
								   <td colspan="14" style="font-weight:bold;border-right:1px soild;font-size:12px"><strong>Bank Detail</strong></td>
								   </tr>-->
								 <tr>
								 <!--  <td colspan="4" style="border-right:1px soild;vertical-align:top;font-size:12px">
								    Name of company  :
                                       <?=$invoicedata->account_name?>
                                     <br />
                                     Account No. :
<?=$invoicedata->account_no?>
                                     <br />
                                     
Name of Bank :
<?=$invoicedata->bank_name?>
<br />
Address of Bank :
<?=strip_tags($invoicedata->bank_address)?>
<br />
Swift Code :
<?=$invoicedata->swift_code?>
<br />
Branch Code:
<?=$invoicedata->ifsc_code?><br />
IBAN NO  : <?=$invoicedata->iban_no?>
								   </td>-->
								    <td colspan="14" style="font-weight:bold;border-right:1px soild;text-align:center;vertical-align:top;">
								
								  <table cellspacing="0" cellpadding="0" style="margin:0px;width:100%" border="1">
									<tr>
										<th width="17%" style="text-align:center">Product Details</th>
										<th width="7%" style="text-align:center">Pcs per box</th>
										<th width="7%" style="text-align:center">Thickness</th>
										<th width="8%" style="text-align:center">Weight Per Box</th>
										<th width="8%" style="text-align:center">Net Weight</th>
										<th width="10%" style="text-align:center">Gross Weight</th>
										<th width="10%" style="text-align:center">Sqm per box</th>
										<th width="18%" style="text-align:center">Pallet Type</th>
										<th width="15%" style="text-align:center">Box Design Type</th>
										<th width="20%" style="text-align:center">Box Image</th>
									</tr>

								<?php

$processed_entries = [];

for ($j = 0; $j < count($product_data); $j++) {
    // Skip if extra_product is 1
    if ($product_data[$j]->extra_product == 1) {
        continue;
    }

    foreach ($size_array as $entry) {
        if ($entry['series_name'] == $product_data[$j]->series_name &&
            $entry['size_type_mm'] == $product_data[$j]->size_type_mm) {

            $series_size_key = $entry['series_name'] . '|' . $entry['size_type_mm'];
            $unique_key = $series_size_key . '|' . $entry['box_design_img'] . '|' . $entry['thickness'] . '|' . $entry['pcs_per_box'];

            if (!in_array($unique_key, $processed_entries)) {
                $processed_entries[] = $unique_key;
                ?>
                <tr>
                    <td style="text-align:center">
                        <?= $entry['series_name'] ?><br>
                        <?= $entry['size_type_mm'] ?>
                    </td>
                    <td style="text-align:center"><?= $entry['pcs_per_box'] ?></td>
                    <td style="text-align:center"><?= $entry['thickness'] ?></td>
                    <td style="text-align:center"><?= $entry['weight_per_box'] ?></td>
                    <td style="text-align:center"><?= $entry['total_net_weight'] ?></td>
                    <td style="text-align:center"><?= $entry['total_gross_weight'] ?></td>
                    <td style="text-align:center"><?= $entry['sqm_per_box'] ?></td>
                    <td style="text-align:center"><?= $entry['pallet_type_name'] ?></td>
                    <td style="text-align:center"><?= $entry['box_design_name'] ?></td>
                    <td style="text-align:center">
                        <img src="<?= base_url() . 'upload/box_design/' . $entry['box_design_img'] ?>" width="55px" />
                    </td>
                </tr>
                <?php
            }
        }
    }
}
?>


<!--	<?php foreach ($size_array as $entry): ?>
										<tr>
											<td style="text-align:center">
												<?= $entry['series_name'] ?><br>
												<?= $entry['size_type_mm'] ?>
											</td>
											<td style="text-align:center"><?= $entry['pcs_per_box'] ?></td>
											<td style="text-align:center"><?= $entry['thickness'] ?></td>
											<td style="text-align:center"><?= $entry['weight_per_box'] ?></td>
											<td style="text-align:center"><?= $entry['total_net_weight'] ?></td>
											<td style="text-align:center"><?= $entry['total_gross_weight'] ?></td>
											<td style="text-align:center"><?= $entry['sqm_per_box'] ?></td>
											<td style="text-align:center"><?= $entry['pallet_type_name'] ?></td>
											<td style="text-align:center"><?= $entry['box_design_name'] ?></td>
											<td style="text-align:center">
												<img src="<?= base_url() . 'upload/box_design/' . $entry['box_design_img'] ?>" width="55px" />
											</td>
										</tr>
									<?php endforeach; ?>-->
									

								</table>

								</td>
								 </tr>
								 <tr>
										<td colspan="5" style="border-right:1px soild" valign="top">
										MOQ is 1 model half container for 600x600mm and 600x1200mm, less then half container order for 01 model then +/- 15 boxes will be acceptable, we will add with new pallet.
	<?php if (!empty($invoicedata->cd_note)) : ?>
    <br>
    <br>
    NOTE: <?= $invoicedata->cd_note ?>
<?php endif; ?>

										</td>
										<td colspan="5" style="font-weight:bold;vertical-align:top;"> 
											Signature : For, <?=$invoicedata->c_companyname?><br>
											 
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											<br>
											 
											Authorised  Signatury				 
										</td>
													
								
									 	<?php 
								if(!empty($invoicedata->sign_detail_id))
								{
									 
								?>
										<td colspan="4" style="font-weight:bold;text-align:right;vertical-align:top"> 
											Signature : For, <?=$invoicedata->for_signature_name?><br>
											
											<img src="<?=base_url().'upload/user/'.$invoicedata->sign_image?>"  width="100px">
											<br>
											<?=strtoupper($invoicedata->authorised_signatury)?>
															 
										</td>
										<?php
								}
								else
								{
								?>
								<td colspan="4" style="font-weight:bold;text-align:right;vertical-align:top"> 
											Signature : For, <?=$company->s_name?><br>
											
											<img src="<?=base_url().'upload/'.$company->s_c_sign?>"  width="100px">
											<br>
											<?=strtoupper($company->authorised_signatury)?>
															 
										</td>
								<?php 
								 }
								 
								?>	
								 </tr>
								 <tr>
								   <td colspan="17" style="border-right:1px soild" valign="top"><strong>Declaration:</strong>  We declare that this Invoice shows the actual price of the goods described and that all particulars are true and correct. All legal matters are subject to Indian Juridiction
&nbsp;
<br>
<strong>CONTACT PERSON NAME: </strong>    : <?=!empty($invoicedata->sign_detail_id)?$invoicedata->contact_person_name:$company->s_name?>, <strong>CONTACT NUMBER: </strong><?=!empty($invoicedata->sign_detail_id)?$invoicedata->contact_no:$invoicedata->e_mobile?>, <strong>EMAIL: </strong><?=!empty($invoicedata->sign_detail_id)?$invoicedata->contact_email:$invoicedata->e_email?>
  
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
									 $_SESSION['performa_invoice_no'] = 'PI '.$invoicedata->invoice_no.' - '.$invoicedata->c_companyname.' '.$invoicedata->country_final_destination.' V'.$invoicedata->version.' '.date('d-m-Y',strtotime($invoicedata->performa_date));
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
			"invoice_table_name"	: 'performa_invoice_pdf'   
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}

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
			"performa_invoice_pdf"	: 'performa_invoice_pdf'
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
  docprint.document.write(' @media print{ @page { size:landscape; margin: 0.2in 0.2in 0.2in 0.2in; } }');	 
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