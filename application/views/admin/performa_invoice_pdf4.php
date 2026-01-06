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
									 <div class="pull-right ">
										<?=($invoicedata->confirm_status == 1)?'<a class="btn btn-defualt"  href="'.base_url().'create_producation/index/'.$invoicedata->performa_invoice_id.'"><i class="fa fa-eye"></i> Producation Sheet</a>':''?>
										
									<div class="dropdown" style="float:left;">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="<?=base_url('performa_invoice_pdf/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>	
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('performa_invoice_pdf/index_withoutfinish/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="<?=base_url('performa_invoice_pdf/index_withthickness/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="<?=base_url('performa_invoice_pdf1/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="<?=base_url('performa_invoice_pdf2/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="<?=base_url('performa_invoice_pdf3/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 6</a>
											
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
									<div id="print_content"  style="margin-top:80px;">
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
									        <img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" style="width:475px"  width="<?=$company->head_logo_width?>" height="<?=$company->head_logo_height?>" />
									        </td>
									    </tr>
										<tr>
											<td  style="text-align:center;border-bottom:none;border-left:none;">
											  <div><strong style="font-size:22px">Proforma Invoice </strong></div>
											</td>
										</tr>
								</table>
									<table cellspacing="0" cellpadding="0"  width="100%" class="main_table invoice_edit_cls" border="1" style="font-size:12px;">
									 	<tr>
									 	  <td width="48%" colspan="2"  style="border-right:none;border-bottom: none;"><strong>Exporter</strong></td>
									 	  <td colspan="2" rowspan="2" style="border-bottom: none;" valign="top">
											<strong>Proforma Invoice No. :  <?=$invoicedata->invoice_no?>
                                           </strong><br />
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
											</span><br />
										</td>
								 	  </tr>
									 	<tr>
									 	  <td colspan="2"  style="border-right:none;border-bottom: none;" valign="top"><?=$export?></td>
								 	  </tr>
									 	<tr>
										  <td colspan="2"  style="border-right:none;border-bottom: none;"><strong>Consignee</strong></td>
											<td style="border-bottom: none;">Country of origin of Goods</td>
											<td style="border-bottom: none;"><?=$invoicedata->country_origin_goods?></td>
									 	</tr>
										<tr>
										  <td colspan="2"  rowspan="6" style="vertical-align:top;border-right: none;border-bottom:none"><?=$consig_add?>											  <br />
											  <?php 
		  if(!empty($invoicedata->buyer_other_consign))
		  {
		 
		?><hr />
										    <strong>Buyer If Other Then Consignee </strong>[Notify]<br />	<?=$invoicedata->buyer_other_consign?>
                                            <?php } ?>
											</td>
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
										  <td style="vertical-align:top;border-bottom:none"><strong>Payment Terms </strong></td>
										  <td style="vertical-align:top;border-bottom:none">&nbsp;</td>
									  </tr>
										 <tr>
											<td colspan="2" style="border-bottom: none;">
												 <?=$payment_terms?> <br>
												 Rate : <?=$invoicevalue_say?> (IN <?=strtoupper($invoicedata->currency_name)?>) <?=$invoicedata->terms_of_delivery?>											</td>
									 	</tr>
									  </table>
								 	<table cellspacing="0" cellpadding="0" style="" width="100%" border="1" style="font-size:10px;" class="invoice_edit_cls">
										<tr>
										  <td colspan="2" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Number of Containers :
										  <br>
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
										  <td colspan="5" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">
										  Description of Product <br>
										  
										  <?php
							$hsn_array=array();
							$water_array=array();
							$size_array=array();
							$seriesname_array=array();
	  							for($j=0; $j<count($product_data);$j++)
								{ 
									 
											 
									if(!in_array(trim($product_data[$j]->series_name.' - '.$product_data[$j]->water_text),$seriesname_array))
									{
										if(!empty($product_data[$j]->series_name))
										{
											array_push($seriesname_array,$product_data[$j]->series_name.' - '.$product_data[$j]->water_text);
										}	
									}									
								 	
									if(!in_array($product_data[$j]->hsnc_code,$hsn_array))
									{		
										if(!empty($product_data[$j]->hsnc_code))
										{
											array_push($hsn_array,$product_data[$j]->hsnc_code);
										}
									}
								}
								echo implode(" & ",$seriesname_array).implode(" & ",$hsn_array);
								?>&nbsp;
								
								</td>
										  <td colspan="5" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Packing Details</td>
										  <td colspan="2" style="text-align:center;font-weight:bold;border-bottom: none ;">Amount</td>
									  </tr>
										<tr>
										  <td width="3%" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Sr No</td>
										  <td  width="14%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Image</td>
										  <td width="9%"  style="text-align:center;font-weight:bold;border-bottom: one;border-right: none;">Product Size (mm)</td>
										  <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Name/ Code</td>
										  <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Client Name/ Code</td>
											<td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Finish/ Surface</td>
										   <td  width="7%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Category</td>
										     <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Cont.</td>
											 <td width="5%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Boxes/ Pallet	</td>
											  
											
										   <td width="6%" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Pallets	</td>
										  
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Boxes</td>
										  
									      <td width="7%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Sq.mtrs</td>
										   <td width="6%"  style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Rate per (<?=strtoupper($invoicedata->currency_name)?>)</td>
										   
										   <td width="8%"  style="text-align:center;font-weight:bold;border-bottom: none;">Total Amount (<?=strtoupper($invoicedata->currency_name)?>)</td>
							 	      </tr>
								<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$total_con=0;
								$no_of_row = 1;
								 $no=1;
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
												if(!in_array($product_data[$i]->size_type_mm.$packing_row->box_design_name,$size_array))
												 {
													  array_push($size_array,$product_data[$i]->size_type_mm.$packing_row->box_design_name);
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['size_type_mm'] = $product_data[$i]->size_type_cm;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['box_design_name'] = $packing_row->box_design_name;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['box_design_img'] = $packing_row->box_design_img;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['pallet_type_name'] = $packing_row->pallet_type_name;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
													   $size_array[$product_data[$i]->size_type_mm.$packing_row->box_design_name]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
													    
												}
									 $one_container = 0;
											 
											 if($packing_row->no_of_pallet>0)
											 {
											 	$product_plts = $product_data[$i]->boxes_per_pallet;
											 	$plts_per_container = $product_data[$i]->total_pallent_container;
											 	$one_container = $packing_row->no_of_boxes * 100 / $product_data[$i]->box_per_container; 
												
											 }
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
											{
											  	$product_plts  =  $product_data[$i]->box_per_big_pallet.'<br> <hr>'.$product_data[$i]->box_per_small_pallet;
												$plts_per_container = $product_data[$i]->no_big_plt_container_new.'<br> <hr>'.$product_data[$i]->no_small_plt_container_new;
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
												<img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
											<?php 
											}
											?>
											 </p>
									  
									   </td>
									   <?php 
											if($product_data[$i]->extra_product == 1)
											{
											?>
												<td colspan="5" style="text-align:center;border-right: none;"><?=$product_data[$i]->description_goods?></td>
										 
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
										<?=($product_data[$i]->extra_product == 1)?"-":$one_container?>
										 </td>
										<td style="text-align:center;border-right: none;">
										 
											<?=$product_plts?> 
										</td>
										 
										
										<td style="text-align:center;border-right: none;">
										<?php 
											
											if($packing_row->no_of_pallet>0)
											{
											 	$no_of_pallet  = $packing_row->no_of_pallet;
												
											}
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
											{
												$no_of_pallet =  $packing_row->no_of_big_pallet.'<br> <hr>'.$packing_row->no_of_small_pallet;
												
										 	}
											else
											{
												 $no_of_pallet =  '-';
												
											}
										?>
										<?=$no_of_pallet?>
										</td>
										
										
										<td style="text-align:center;border-right: none;">
											<?=$packing_row->no_of_boxes?>
										</td>
										 
										<td style="text-align:center;border-right: none;"><?=number_format($packing_row->no_of_sqm,2,'.','')?></td>
										<td style="text-align:center;border-right: none;"><?=$currency_symbol?>
									    <?=number_format($packing_row->product_rate,2,'.','')?>
										<br>
										<?=$packing_row->per?>
										</td>
										
										<td style="text-align:center;"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2,'.','')?></td>
									</tr>
								<?php
								$no++;
								$Total_box += $category->packing_boxes;
								$total_product_sqmlm += $category->packing_sqmlm;
								if($product_data[$i]->extra_product == 0)
											{
												$total_con += $one_container;
											}
								 $no_of_row--;
								}
								}
								for($row=$no_of_row;$row>0;$row--)
								{	 
								?>
								<tr>
								  <th style="text-align:center;border-top:none;border-bottom:none">&nbsp;</th>
								  <th style="text-align:center;border-top:none;border-bottom:none">&nbsp;</th>
									<th style="text-align:center;border-top:none;border-bottom:none" height="55">&nbsp;</th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									 <th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
								</tr>
								<?php }  ?>
								 
			 					 <tr>
										<td colspan="7" style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">TOTAL >>>>>>>>>></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=($total_con > 0)?number_format(($total_con),2):'-'?> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">   </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=($Total_plts == 0)?'-':$Total_plts?> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> <?=$Total_box?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"><?=number_format($Total_sqm,2,'.','')?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">&nbsp;</td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.','')?> 
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
										<td colspan="8" style="border-bottom: none;font-weight:bold;    border-right: none;"> <?=strtoupper(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?> ONLY
										</td>
										<td colspan="2" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Total <?=$invoicedata->terms_name?> Value</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->grand_total,2,'.','')?> 
										</td>
								 </tr>
								  
								 <tr>
								   <td colspan="14" style="font-weight:bold;border-right:1px soild;font-size:12px"><strong>Bank Detail</strong></td>
								   </tr>
								 <tr>
								   <td colspan="6" style="border-right:1px soild;vertical-align:top;font-size:12px">
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
								    <td colspan="8" style="font-weight:bold;border-right:1px soild;text-align:center;vertical-align:top;">
								   <?php 
								   if(!empty($size_array[$size_array[0]]['size_type_mm']))
								   {
								   ?>
								   <table cellspacing="0" cellpadding="0" style="margin:0px;width:100%"  border="1" >
											<tr>
												<th width="20%" style="text-align:center" >Size</th>
												<th width="20%" style="text-align:center" >Pcs per box</th>
												<th width="20%" style="text-align:center" >Sqm per box</th>
												<th width="20%" style="text-align:center" >Pallet Type</th>
												<th width="20%" style="text-align:center" >Box Design Type</th>
												<th width="20%" style="text-align:center" >Box Image</th>
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
													<td style="text-align:center">
													 <img src="<?=base_url().'upload/'.$size_array[$size_array[$p]]['box_design_img']?>"   height="" width="55px;" />
													</td>
													 
												</tr>
												<?php 
												 
											}
										}
										?>
										 </table>
										  <?php 
								   }
								   ?>
								   </td>
								 </tr>
								 <tr>
										<td colspan="5" style="border-right:1px soild" valign="top"><?php 
		  if(!empty($invoicedata->remarks))
		  {
		 
		?>
											<strong> Notes / Special Remarks :  :</strong><br>
											<?=$invoicedata->remarks?>
											   <?php
		  }
		  ?>
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
								 if(!empty($invoicedata->sign_pi_status))
								 {
								 ?>
									 	<td colspan="4" style="font-weight:bold;vertical-align:top;text-align:right"> 
											Signature : For, <?=$invoicedata->for_signature_name?><br>
											<img src="<?=base_url().'upload/user/'.$invoicedata->sign_image?>"  width="180px">
											<br>
											<?=strtoupper($invoicedata->authorised_signatury)?>
															 
										</td>
										 <?php
								}
								else
								{
								?>	
									<td colspan="4" style="font-weight:bold;vertical-align:top;text-align:right"> 
											Signature : For, <?=$company->s_name?><br>
											<img src="<?=base_url().'upload/'.$company->s_c_sign?>"  width="<?=$company->s_c_sign_width?>" height="<?=$company->s_c_sign_height?>">
											<br>
											<?=strtoupper($company->authorised_signatury)?>
															 
										</td>
								<?php 
								 }
								 
								?>
								 </tr>
								 <tr>
								   <td colspan="17" style="border-right:1px soild" valign="top"><strong>Declaration:</strong>  We declare that this Invoice shows the actual price of the goods described and that all particulars are true and correct. All legal matters are subject to Indian Juridiction &nbsp; <br>
									<strong>CONTACT PERSON NAME: </strong>  Mr. <?=!empty($invoicedata->sign_detail_id)?$invoicedata->contact_person_name:$invoicedata->contactperson_name?>, <strong>CONTACT NUMBER: </strong><?=!empty($invoicedata->sign_detail_id)?$invoicedata->contact_no:$invoicedata->e_mobile?>, <strong>EMAIL: </strong><?=!empty($invoicedata->sign_detail_id)?$invoicedata->contact_email:$invoicedata->e_email?>
  
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
			"performa_invoice_pdf"	: 'performa_invoice_pdf4'
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
			"invoice_table_name"	: 'performa_invoice_pdf4'  
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