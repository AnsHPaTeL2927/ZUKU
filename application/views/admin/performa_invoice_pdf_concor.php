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
$currency_symbol = ($invoicedata->currency_code == "INR")?'<img src="'.base_url().'adminast/assets/images/ruppe_sysbol.jpg"/>':$currency_symbol;

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
	font-size: 10px;
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
	/*top: 208px;*/
	display: none;
}

.edit a {
	color: blue;
}

hr {
	background-color: black; 
	height: 1px; 
	border: 0; 
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
											<ul class="dropdown-menu">
											 <li>
											 
												<?php
												if($setting_data->without_finish_format == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('performa_invoice_pdf/index_withoutfinish/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 1 (Without Finish)</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->with_thickness == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="<?=base_url('performa_invoice_pdf/index_withthickness/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 2 (With Thickness)</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->with_unit == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="<?=base_url('performa_invoice_pdf1/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 3 (With Unit)</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->with_image_no_barcode == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="<?=base_url('performa_invoice_pdf2/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 4 (With Image,Without Barcode)</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->pi_five == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 5" href="<?=base_url('performa_invoice_pdf3/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 5</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->pi_six == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf4/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 6</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->zuku_format == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 7 (Zuku Format)</a>
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index1/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Merchant Format</a>
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index2/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Merchant SQF Format</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->other_format == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (With Other Product)</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->pi_nine == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_accord/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9</a>
												<?php
												}
												?>
												
												<?php
												if($setting_data->pi_ten == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_olwin/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10</a>	
												<?php
												}
												?>
												
												<?php
												if($setting_data->without_pallet == 1)
												{
												?>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf11/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 11 (Without Pallet)</a>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index1/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 12 (Asia Pacific Ceramic)</a>
												<?php
												}
												?>
											 </li>											 
											</ul>
										</div>&nbsp;
									
										<button type="button" class="btn btn-primary" onclick="print_doc('print_content')"> <i class="fa fa-print"></i> Print </button>
										 <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
										<a class="btn btn-warning tooltips" data-title="View in Excel" href="javascript:;"  onclick="toExcel();"   ><i class="fa fa-file"></i> Export Excel</a>
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
									<table cellspacing="0" border="1" cellpadding="0"  width="100%"  class="main_table invoice_edit_cls">
									 	
										 <tr>
											<td style="text-align: left;padding: 10px 0;" width="66.5%"> <img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" width="<?=$company->head_logo_width?>" height="<?=$company->head_logo_height?>"  /></td>
											<td  width="33.5%" style="padding: 10px 0;text-align: center;background-color:#a6a6a6;" > 
												<h2><b>PROFORMA INVOICE</b></h2>
											</td>
										</tr>
									
								</table>
								
									<table cellspacing="0" cellpadding="0"  width="100%" class="main_table invoice_edit_cls" border="1">
										<tr>
											<td  width="35%" style="background-color:#a6a6a6;font-size:12px;"><strong>EXPORTER</strong></td>
											<td  width="35%" style="background-color:#a6a6a6;font-size:12px;"><strong>BUYER</strong></td>
											<td width="10%" style="border-bottom: none;text-align:center;background-color:#a6a6a6;font-size:14px;">
												 <h4><b>PI NO.</b></h4>								
											</td>
											<td width="20%"  style="border-bottom: none;text-align:center;color:#65cb6e;font-size:14px;">
												 <h4><b><?=$invoicedata->invoice_no?></b></h4>										
											</td>
											<!--<td colspan="3" style="border-left: 1px solid;border-bottom: 1px solid;"><strong>DATE:</strong> <?=date('d.F.Y',strtotime($invoicedata->performa_date))?> </td>-->
										</tr>
										<tr>
											<td width="35%" rowspan="3" style="font-size:12px;" >
												<?=$export?>
											</td>
											<td width="35%" rowspan="3" style="font-size:12px;" >
												<?=$consig_add?>
											</td>
											<td style="border-bottom: none;text-align:center;background-color:#a6a6a6;font-size:14px;" width="10%">
												  <h4><b>DATE</b></h4>		
											</td>	
											<td  style="border-bottom: none;text-align:center;color:#65cb6e;font-size:14px;" width="20%">					
												  <h4><b><?=$performapacking_date?></b></h4>	
											</td>
										</tr>
										
										<tr>
											
											<td style="border-bottom: none;text-align:center;background-color:#a6a6a6;font-size:12px;" width="20%">
												  <strong>Country Of Origin</strong>	
											</td>	
											<td style="border-bottom: none;text-align:center;font-size:12px;" width="10%">
												  <?=$performapacking_date?>
											</td>
										
																						
									 	</tr>	
										
										<tr>
											
											<td style="border-bottom: none;text-align:center;background-color:#a6a6a6;font-size:12px;" width="20%">
												  <strong>Country Of Destination</strong>	
											</td>	
											<td style="border-bottom: none;text-align:center;font-size:12px;" width="10%">
												  <?=$performapacking_date?>
											</td>
										
																						
									 	</tr>
										
										 <tr>
										 
											<td  width="40%" style="border-right:none;border-bottom: none;background-color:#a6a6a6;font-size:12px;">
												<strong>TERMS OF DELIEVERY</strong>				
											</td>
											<td  width="40%" style="border-bottom: none;background-color:#a6a6a6;font-size:12px;">
												 <strong>TERMS OF PAYMENT </strong>										
											</td>
											<td style="border-bottom: none;text-align:center;background-color:#a6a6a6;font-size:12px;" width="20%">
												  <strong>PORT OF LOADING</strong>	
											</td>	
											<td style="border-bottom: none;text-align:center;font-size:12px;" width="10%">
												  <?=$invoicedata->port_of_loading?> 
											</td>
									 	</tr>
										
										<tr>
											<td  width="40%" style="vertical-align:top;border-bottom:none;font-size:12px;">
												 <?=$invoicevalue_say?> - <?=$invoicedata->terms_of_delivery?>
											</td>
											<td  width="40%" style="vertical-align:top;border-bottom:none;font-size:12px;">
												  <?=$payment_terms?>
											</td>
											<td style="border-bottom: none;text-align:center;background-color:#a6a6a6;font-size:12px;" width="20%">
												  <strong>PORT OF DISCHARGE</strong>	
											</td>	
											<td style="border-bottom: none;text-align:center;font-size:12px;" width="10%">
												  <?=$invoicedata->port_of_discharge?> 
											</td>
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
										<!--<tr>
											<td style="text-align:center;font-weight:bold" colspan="12"> <?=implode(",",$hsn_array)?></td>
										</tr>-->
										<tr>
										   <td width="4%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">NO.</td>
										  <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">PRODUCT</td>
										   <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">SIZE</td>
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">SURFACE FINISH</td>
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">FACTORY DESIGN NAME</td>
										   <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">DESIGN NAME ON BOXES</td>
							
										   <td width="15%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">DESIGN IMAGE</td>
										   <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">PCs/BOX</td>
										 
										   <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">Boxes / Pallet	</td>
										   <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">TOTAL PALLETS
										   </td>
										   <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">TOTAL BOXES</td>
										   <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">No. of Container</td>
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">TOTAL SQM (<?=$invoicedata->per_value?>) </td>
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">UNIT RATE / <?=$invoicedata->per_value?> (<?=strtoupper($invoicedata->currency_name)?>)</td>
										   <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;background-color:#a6a6a6;">TOTAL AMOUNT (<?=strtoupper($invoicedata->currency_name)?>)</td>
								 	   </tr>
									   
								<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$Total_ammount=0;
								$no_of_row = 1;
								$Total_con=0;
								$size_array = array();
								$hsn_array=array();
								$n = 1;
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
									 //$n = 1;
												
												
												
								  foreach($product_data[$i]->packing  as $packing_row)
								  {
									  
												if(!in_array($product_data[$i]->size_type_mm.$packing_row->box_design_name,$size_array))
												 {
													  array_push($size_array,$product_data[$i]->size_type_mm.$packing_row->box_design_name);
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['size_type_cm'] = $product_data[$i]->size_type_cm;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['size_type_mm'] = $product_data[$i]->size_type_mm;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['box_design_name'] = $packing_row->box_design_name;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['pallet_type_name'] = $packing_row->pallet_type_name;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
													    
												}
									 
								?>
									<tr>
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$n?></td>
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$product_data[$i]->series_name?>
										<br>
										<?php
										if(!empty($product_data[$i]->hsnc_code))
										{
										?>
										<b>HS CODE :</b> <?=$product_data[$i]->hsnc_code?>
										<?php
										}
										?>
										</td>
										<td style="text-align:center;border-bottom: none;border-right: none;">
										<?=$product_data[$i]->size_type_mm?>
										<?php
										if(!empty($product_data[$i]->thickness))
										{
										?>
										X<?=$product_data[$i]->thickness?>MM
										<?php
										}
										?>
										</td>
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$packing_row->finish_name?></td>
										
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$packing_row->model_name?></td>
										
										<td style="text-align:center;border-bottom: none;border-right: none;">
										<?=$packing_row->model_name?><br>
										
										<?php
										if(!empty($packing_row->barcode_no))
										{
										?>
										<p style="color:red;"><?=$packing_row->barcode_no?></p>
										<?php
										}
										?>
										
										</td>
										
										 <td style="text-align:center;border-bottom: none;border-right: none;">
										 <p style="margin: 0 auto;width:50px;height:50px;overflow:hidden;position: relative;">
												<img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:80px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;"/> 
											 </p>
										 </td>
										 
										<td style="text-align:center;border-bottom: none;border-right: none;"><?=$product_data[$i]->pcs_per_box?></td> 
										
									 
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
									
										<?php 
										if($invoicedata->per_value == "SQF")
										{
											?>
											<td style="text-align:center;border-bottom: none;border-right: none;">
											
											<?=number_format(($packing_row->no_of_boxes * $product_data[$i]->feet_per_box),2,'.','')?>
											
											</td>
										<?php 
										 $Total_sqm 	+= $packing_row->no_of_boxes * $product_data[$i]->feet_per_box;
										}
										else if($invoicedata->per_value == "BOX")
										{
											?>
										<td style="text-align:center;border-bottom: none;border-right: none;">
										 	<?=number_format($packing_row->no_of_boxes,2,'.','')?>
									 	</td>
											<?php
											$Total_sqm 	+= $packing_row->no_of_boxes;
										}
										else 
										{
										?>
										<td style="text-align:center;border-bottom: none;border-right: none;">
										
										<?=number_format($packing_row->no_of_sqm,2,'.','')?>
										
										</td>
										<?php 
$Total_sqm 	+= $packing_row->no_of_sqm;										
										}
										?>
											<td style="text-align:center;border-bottom: none;border-right: none;"><?=$currency_symbol?><?=number_format($packing_row->product_rate,2,'.','')?></td>
										<td style="text-align:center;border-bottom: none;"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2,'.','')?></td>
									</tr>
								<?php
								$n++;
								$Total_con += $one_container;
								$Total_box += $category->packing_boxes;
								$total_product_sqmlm += $category->packing_sqmlm;
								 
								 $no_of_row--;
								}
								}
							 
								?>
					 			 <tr>
										<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;">Total</td>
										 
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;"> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;"> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;"> <?=$Total_plts?> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;"> <?=$Total_box?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;"> <?=($Total_con == 0.00)?"-":number_format($Total_con,2)?></td>
										
										
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;"> <?=number_format($Total_sqm,2,'.','')?></td>
										<td  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;background-color:#a6a6a6;"> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;background-color:#a6a6a6;"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
									if($invoicedata->certification_charge > 0)
									{
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Certification Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->certification_charge,2,'.',',')?> 
										</td>
								 </tr>
								 
								 <?php 
								 } 
								 if($invoicedata->insurance_charge > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Insurance Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->insurance_charge,2,'.',',')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->seafright_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Sea Freight Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->seafright_charge,2,'.',',')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->courier_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Courier Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->courier_charge,2,'.',',')?> 
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
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->bank_charge,2,'.',',')?> 
										</td>
								 </tr>
								 <?php
								 }  
								 if(!empty($invoicedata->extra_calc_name))
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
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
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Discount</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->discount,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 if($invoicedata->igst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">IGST (<?=number_format($invoicedata->igst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?> <?=number_format($invoicedata->igst_value,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  if($invoicedata->sgst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">SGST (<?=number_format($invoicedata->sgst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->sgst_value,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								  if($invoicedata->cgst_value > 0)
								 {
								 ?>
									 <tr>
										<td colspan="8" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">CGST (<?=number_format($invoicedata->cgst_per_value,2,'.','')?>%)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->cgst_value,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 ?>
								 <tr>
										<td colspan="2" style="text-align:right;border-bottom: none;border-right: none;font-weight:bold">AMOUNT IN WORDS</td>
										<td colspan="13" style="border-bottom: none;font-weight:bold;    border-right: none;"> <?=($invoicedata->currency_name == "INR")?strtoupper(converttorsword($invoicedata->grand_total,$invoicedata->currency_name)):strtoupper(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?> ONLY
										</td>
										<!--<td  colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Total <?=$invoicedata->terms_name?> Value</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->grand_total,2,'.',',')?> 
										</td>-->
								 </tr>
								 
							 	 <tr>
										<!--<td rowspan="2"  colspan="7" style="border-right:1px soild;vertical-align:top;">-->
										<td colspan="7" style="text-align:left;border-bottom: none;border-right: none;font-weight:bold">NOTES:</td>
										<td colspan="4" style="text-align:center;border-bottom: none;border-right: none;font-weight:bold">BUYER</td>
										<td colspan="4" style="text-align:center;border-bottom: none;border-right: none;font-weight:bold">CONCOR INTERNATIONAL</td>
								
								 </tr>
								
								<tr>
									<td colspan="7" style="border-right:1px soild;vertical-align:top;">
												
										<?php 
												if(!empty($invoicedata->remarks))
												{
												
												?>
													
													<?=$invoicedata->remarks?>
												   <?php
												}
												
												?>
											
											
									</td>
									
									<td colspan="4" style="border-right:1px soild;vertical-align:top;text-align:center;">
												
										
											<br>
											<br>
											<br>
											<br>
											<br>
											<hr size="20" noshade sty>
										AUTHORIZED PERSON
										<br>		
											
											
									</td>
									
									<td colspan="4" style="border-right:1px soild;vertical-align:top;text-align:center;">
												
										<?php 
												if(!empty($invoicedata->sign_detail_id))
												{
												
												?>
													
												<img src="<?=base_url().'upload/user/'.$invoicedata->sign_image?>"  width="130px" height="54px">
												<?php
												}
												else
												{
												?>
												<img src="<?=base_url().'upload/'.$company->s_c_sign?>"  width="130px" height="54px">
												<?php
												}
								
												?>
											<br>
											<hr size="20" noshade>
											PARTNER
											<br>
											
									</td>
								 </tr>
																 
									</table>
									
									<table cellspacing="0" cellpadding="0" width="100%">
									    <tr>
											<td  rowspan="2" style="border-right:1px soild;vertical-align:top; width:50%;">
													<strong> Additional Detail :</strong>
													<br>
													  Back side of Tiles : 
													  <?=$invoicedata->made_in_india_status?><br>
													
												
													AirBag: <?=$invoicedata->air_bag_status?>
													<br>
													 
													Pallet Cap: <?=$invoicedata->pallet_cap_name?>

														<br>
													Fumigation: <?=$invoicedata->fumigation_name?>
													<br>
													Moisture Bag:  <?=$invoicedata->mosqure_bag_status?>
		 
											<br>
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
										<td style="vertical-align:top;" colspan="5">
											<strong> BOX STICKER:</strong><br>
												<?php
											$images_name = explode(",",$invoicedata->barcode_sticker_file);
											if(!empty($images_name[0]) && $images_name[0] != "none")
											{
												?>
												 
												 <?php 
												foreach($images_name as $img)
												echo "<div style='margin-bottom:5px'>
														<img src='".base_url()."upload/".$img."'  width='150px' height='80px'/> 
													  </div>"; 
												 
												?>
												 
												 <?php
											}
											 
											?>
										</td>
										</tr>
										<tr>
										<td style="vertical-align:top;" colspan="5">
											<strong> PALLET STICKER:</strong>.
											<br>
											<?php 
										if(!empty($invoicedata->box_sticker_file) && $invoicedata->box_sticker_file != "none")
										{
											?>
											 
													<img src='<?=base_url()."upload/".$invoicedata->box_sticker_file?>' width='150px' height='80px'/>
												 
											<?php
										}
										?>
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
  docprint.document.write('   <!  DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
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