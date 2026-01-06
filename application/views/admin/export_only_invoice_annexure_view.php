	<?php 
 $this->view('lib/header'); 
  
 $export_date 				= date('d/m/Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no 			= $invoicedata->export_invoice_no;
 $export 					= ($invoicedata->exporter_detail);
 $export_ref_no 			= ($invoicedata->export_ref_no);
 $performa_date 			= $invoicedata->performa_date;
 $buy_order_no 				= strip_tags($invoicedata->export_buy_order_no);
 $exporter_email 			= $invoicedata->e_email;
 $exporter_mobile 			= $invoicedata->e_mobile;
 $exporter_gstin 			= $invoicedata->e_gstin;
 $exporter_pan 				= $invoicedata->exporter_pan;
 $exporter_iec 				= $invoicedata->exporter_iec;
 $consign_name 				= $invoicedata->c_name;
 $consign_address 			= ($invoicedata->consign_address);
 $buyer_other_consign 		= ($invoicedata->buyer_other_consign);
 $pre_carriage_by			= $invoicedata->pre_carriage_by;
 $place_of_receipt			= $invoicedata->place_of_receipt;
 $country_origin_goods 		= $invoicedata->country_origin_goods;
 $country_final_destination = $invoicedata->country_final_destination;
 $bank_detail 				= $invoicedata->bank_detail;    
 $flight_name_no			= $invoicedata->flight_name_no;   				 
 $export_port_loading 		= $invoicedata->port_of_loading;
 $port_of_discharge 		= $invoicedata->port_of_discharge;
 $final_destination 		= $invoicedata->final_destination;
 $export_payment_terms 		= $invoicedata->payment_terms;
 $no_of_container 			= $invoicedata->container_details;
 $export_terms_of_delivery 	= $invoicedata->terms_of_delivery;
 $container_size 			= $invoicedata->container_size;
	$other_reference 			= $invoicedata->other_reference;
 if($invoicedata->Exchange_Rate_val==0)
 {
	 $exchangerate = $userdata->usd;
 }
 else{
	 $exchangerate = $invoicedata->Exchange_Rate_val;
 }
 $_SESSION['export_content'] = '';
 $_SESSION['export_invoice_no'] = '';
 $locale='en-US'; //browser or user locale
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
$currency_symbol = ($currency == "INR")?"INR":$currency_symbol;
   
	$supplier_invoice_date ='';
 if($annexuredata->c_date == "1970-01-01" || $annexuredata->c_date == "0000-00-00" || empty($annexuredata->c_date))
 {
	 $annexuredata_cdate = '';
 }
 else{
	 $annexuredata_cdate = date('d-m-Y',strtotime($annexuredata->c_date));
 }
 if($annexuredata->Shipping_date == "1970-01-01" || $annexuredata->Shipping_date == "0000-00-00" || empty($annexuredata->Shipping_date))
 {
	 $annexuredata_Shipping_date = '';
 }
 else
 {
	 $annexuredata_Shipping_date = date('d-m-Y',strtotime($annexuredata->Shipping_date));
 }
 if($annexuredata->examination_date == "1970-01-01" || $annexuredata->examination_date == "0000-00-00" || empty($annexuredata->examination_date))
 {
	 $annexuredata_examination_date = '';
 }
 else
 {
	 $annexuredata_examination_date = date('d-m-Y',strtotime($annexuredata->examination_date));
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
.profile-pic {
	position: relative;
	/*display: inline-block;*/
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
	top: 168px;
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
	window.open(root+"exportinvoicepdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"exportinvoicepdf/view_pdf";
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
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>View Export Invoice
									<div class="pull-right form-group">
										<div class="col-sm-5">
											<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
												<span class="caret"></span></button>
													<ul class="dropdown-menu">
														 <li>
															<a class="tooltips" data-toggle="tooltip" data-title="Only Invoice" href="<?=base_url('exportinvoiceview/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  View Invoice</a>
														 </li> 
														 <li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="<?=base_url('exportinvoiceview1/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (With Sign)</a>
														</li>
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (KG)" href="<?=base_url('exportinvoiceview/index_kg/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (KG)</a>
														</li>
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="<?=base_url('exportinvoiceview/other_product/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Other Product)</a>
														</li>
														
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="<?=base_url('exportinvoiceview/without_design/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Without Design)</a>
														</li>
														
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="Only Invoice" href="<?=base_url('exportinvoiceview/onlyinvoice/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  Only Invoice</a>
														</li> 
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="Only Invoice Packing" href="<?=base_url('exportinvoiceview/onlyinvoicepacking/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  Only Invoice Packing</a>
														</li> 
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Packing List" href="<?=base_url('exportinvoicepackingview/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-pdf-o"></i> View Packing List (FAMIGATION)</a>
														</li>
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Loading Pdf" href="<?=base_url('loadingpdf/index/'.$invoicedata->export_invoice_id)?>" target="_blank" ><i class="fa fa-eye"></i> Loading Pdf</a>
														</li>
													</ul>
										</div>	
										</div>
										<div class="col-sm-4">
											<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
										</div>
									</div>
								</h3>
								
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							  <?php ob_start();
											$Total_sqm 			= 0;
											$Total_box 			= 0;
											$Total_pallet 		= 0;
											$Total_ammount 		= 0;
											$Total_amt 		 	= 0;
											$total_container 	= 0;
											$button_check_array = array();
											$stringcolor=array();
											$product_desc_array = array();
										 	$series_name_array = array();
											$seriesname_array = array();
										 	$water_array = array();
											$no_of_row = 15;
											$totalnetweight =0;
											$totalgrossweight =0;
											$rowspan = 0;
											for($i=0; $i<count($product_data);$i++)
											{	
													
												$totalnetweight 	+= 	$product_data[$i]->updated_net_weight;
												$totalgrossweight 	+= 	$product_data[$i]->updated_gross_weight; 
												
												if(!in_array(trim($product_data[$i]->series_name),$seriesname_array))
												{
													array_push($seriesname_array,$product_data[$i]->series_name);
													//array_push($water_array,$product_data[$i]->water_text);
												}
												
											 	if(!in_array(trim($product_data[$i]->series_name.'<br> HSN Code - '.$product_data[$i]->hsnc_code),$series_name_array))
												{
													array_push($series_name_array,$product_data[$i]->series_name.'<br> HSN Code - '.$product_data[$i]->hsnc_code);
													//array_push($water_array,$product_data[$i]->water_text);
												}
											  	 $n = 1;
													$Total_ammount	 += $product_data[$i]->product_amt;
													$Total_amt 	 	 += $product_data[$i]->product_amt;
													
													$description_goods =  $product_data[$i]->description_goods.$product_data[$i]->pcs_per_box.$product_data[$i]->product_rate.$product_data[$i]->export_half_pallet.$product_data[$i]->export_make_pallet_no;
												 
												 	if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 $rowspan++;
 
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->description_goods;
														$product_desc_array[trim($description_goods)]['product_name'] = $product_data[$i]->series_name.', HSN Code - '.$product_data[$i]->hsnc_code;
														$product_desc_array[trim($description_goods)]['size_type_mm'] = $product_data[$i]->size_type_mm;
														
														$product_desc_array[trim($description_goods)]['epcg_no'] =  $product_data[$i]->epcg_no;
														 
														 $product_desc_array[trim($description_goods)]['epcg_date'] = date('d.m.Y',strtotime($product_data[$i]->epcg_date));
														
														
														$product_desc_array[trim($description_goods)]['water_text'] = $product_data[$i]->water_text;
														 $product_desc_array[trim($description_goods)]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
														 $product_desc_array[trim($description_goods)]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
														 $product_desc_array[trim($description_goods)]['feet_per_box'] = $product_data[$i]->feet_per_box;
														$product_desc_array[trim($description_goods)]['title_type'] = $product_data[$i]->tiles_type;
														  
														$export_half_pallet = (!empty($product_data[$i]->export_make_pallet_no))?$product_data[$i]->export_half_pallet:0;
														
														$product_desc_array[trim($description_goods)]['export_rowspan'] = count(array_filter(explode(",",$product_data[$i]->export_make_pallet_no)));
														
														$product_desc_array[trim($description_goods)]['export_make_pallet_no'] = $export_half_pallet;
														$product_desc_array[trim($description_goods)]['export_half_pallet'] =$product_data[$i]->export_half_pallet;
														 
														$product_desc_array[trim($description_goods)]['no_of_pallet'] = $product_data[$i]->origanal_pallet + $product_data[$i]->make_pallet_no + $export_half_pallet;
														
														 
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] = $product_data[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] = $product_data[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] = $product_data[$i]->origanal_boxes;
														 
														 $product_desc_array[trim($description_goods)]['sqm'] = ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
														 $product_desc_array[trim($description_goods)]['net_weight'] = $product_data[$i]->packing_net_weight;
														 $product_desc_array[trim($description_goods)]['product_rate'] =$product_data[$i]->product_rate;
														 $product_desc_array[trim($description_goods)]['per'] = $product_data[$i]->per;
														 $product_desc_array[trim($description_goods)]['performa_per'] = $product_data[$i]->performa_per;
														
														 $product_desc_array[trim($description_goods)]['amount'] = $product_data[$i]->product_amt;
														  
													}
													else
													{
														$export_half_pallet = (!empty($product_data[$i]->export_make_pallet_no))?$product_data[$i]->export_half_pallet:0;
														 
														
														 
														$product_desc_array[trim($description_goods)]['no_of_pallet'] += $product_data[$i]->origanal_pallet + $product_data[$i]->make_pallet_no + $export_half_pallet;
														 
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] += $product_data[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] += $product_data[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] += $product_data[$i]->origanal_boxes;
														$product_desc_array[trim($description_goods)]['sqm'] += ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
														$product_desc_array[trim($description_goods)]['amount'] += $product_data[$i]->product_amt;
														 $product_desc_array[trim($description_goods)]['net_weight'] = $product_data[$i]->packing_net_weight;
													}
													$Total_sqm 			+= ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);;
													$Total_box 			+= $product_data[$i]->origanal_boxes;
													$export_half_pallet = (!empty($product_data[$i]->export_make_pallet_no))?$product_data[$i]->export_half_pallet:0;
													$Total_pallet 		+= $product_data[$i]->origanal_pallet + $product_data[$i]->orginal_no_of_big_pallet + $product_data[$i]->orginal_no_of_small_pallet +  $product_data[$i]->make_pallet_no + $export_half_pallet; 
												
											}
											foreach ($sample_data as $jsondata)
											{
												$Total_sqm 			+= $jsondata->sqm;
												$Total_box 			+= $jsondata->no_of_boxes;
												$Total_pallet 		+= $jsondata->no_of_pallet;
											}		 
								 ?>
				 		 
									 <div class="profile-pic">
								<div class="edit pull-right">
									<a href="javascript:;" style="color:#fff" class="invoice_edit_btn2 btn btn-primary" onclick="editable_annexure();"><i class="fa fa-pencil fa-lg"></i></a>
									<a href="javascript:;" class="invoice_update_btn2 btn btn-success" style="display:none;color:#fff" onclick="edit_annexure();">Update</a>
								</div>
								<div class="save_invoice_html2">		
                            		<?php 
								
								if(!empty($annexure_html_data))
								{
									echo $annexure_html_data->invoice_html;
								}
								else
								{
									?> 
							   <h4 style="text-align:center;"><strong style="font-size:20px;">ANNEXURE</strong></h4>
												 
							  <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls2" style="padding:7px;" contenteditable="false">
														 	 <tr>
														 	   <td colspan="4" align="center">OFFICE OF THE SUPERITENTNDENT OF CENTRAL GST / CUSTOM DEPARTMENT</td>
						 	    </tr>
														 	 <tr>
				<td colspan="4" align="center">GST OFFICE,  CGST - <?=$company_detail[0]->com_range?> , DIVISION CODE - <?=$company_detail[0]->com_division?>,  COMMISSIONERATE - <?=$company_detail[0]->commissionerate?>.</td>
						 	    </tr>
														 	 <tr>
														 	   <td align="left" >Sr No. :</td>
														 	   <td align="left">Date : </td>
														 	   <td align="left">Shipping Line : </td>
														 	   <td align="left">Date : </td>
                                </tr>
														 	 <tr>
														 	   <td colspan="4" align="center">SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING WITHOUT PAYMENT OF INTEGRATED TAX(IGST)</td>
						 	    </tr>
							  </table>
							  <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls2" contenteditable="false">
														<tr>
															<td style="padding:0px;" width="5%"></td>
															<td style="padding:0px;" width="42%"></td>
															<td style="padding:0px;" width="5%"></td>
															<td style="padding:0px;" width="6%"></td>
															<td width="42%" colspan="3" style="padding:0px;"></td>
												 	  </tr>
														<tr>
																<td style="border-right:none;text-align:center;vertical-align:top"> 
																	1
																</td>
																<td style="vertical-align:top;border-right:none;border-left:none"> 
																	<strong>Name of Exporters &amp; Address</strong>					
																</td>
																<td style="border-left:none;vertical-align:top;"> 
																	 			
																</td>
																<td colspan="4" style="border-left:none;"> 
																	<?=$export?>						
																</td>
														</tr>
														<tr>
															<td style="border-bottom:none;border-right:none;border-top:none;text-align:center"> 
																	2				
															</td>
															<td style="border:none;"> <strong>a) I.E.Code No.</strong></td>
															<td style="border-left:none;border-bottom:none;"> 
														 
															</td>
															<td style="border-bottom:none;border-top:none;border-left:none;" colspan="4"> 
																 <?=$exporter_iec?>					
															</td>
														</tr>
														<tr>
															<td  style="border-right:none;border-top:none;border-bottom:none;"> </td>
															<td style="border-right:none;border-left:none;border-top:none;border-bottom:none;"> 
																<strong>b) GSTIN</strong>				
															</td>
															<td style="border-left:none;border-top:none;border-bottom:none;">  
															</td>
															<td colspan="4" style="border-top:none;border-left:none;border-bottom:none"><span style="vertical-align:top;border-right:none">
															  <?=$exporter_gstin?>
															</span></td>
														</tr>
														<tr>
														  <td  style="border-right:none;border-top:none;border-bottom:none;"></td>
														  <td style="border-right:none;border-left:none;border-top:none;border-bottom:none;"><strong>c) PAN NO </strong></td>
														  <td style="border-left:none;border-top:none;border-bottom:none;"></td>
														  <td colspan="4" style="border-top:none;border-left:none;border-bottom:none"><span style="vertical-align:top;border-right:none">
														    <?=$exporter_pan?>
														  </span></td>
														</tr>
                                                        <tr>
																	  <td  style="border-right:none;border-top:none;border-bottom:none;"></td>
																	  <td style="border-right:none;border-left:none;border-top:none;border-bottom:none;"><strong>d) BRANCH CODE NO.</strong></td>
																	  <td style="border-left:none;border-top:none;border-bottom:none;"></td>
																	  <td colspan="4" style="border-top:none;border-left:none;border-bottom:none"><?=$annexuredata->branch_code?></td>
													  </tr>
                                                      <tr>
																	  <td  style="border-right:none;border-top:none;border-bottom:none;"></td>
																	  <td style="border-right:none;border-left:none;border-top:none;border-bottom:none;"><strong>e) BIN No.</strong></td>
																	  <td style="border-left:none;border-top:none;border-bottom:none;"></td>
																	  <td colspan="4" style="border-top:none;border-left:none;border-bottom:none"><span style="border-top:none;border-left:none;">
																	    <?=$company_detail[0]->s_bin?>
																	  </span></td>
													  </tr>
														<?php
														if($company_detail[0]->s_c_type == "Merchant")
														{
														$no =1;
															foreach($export_supplier_data as $sup_row)
															{ 
																 ?>
															<tr>
																<td style="border-right:none;text-align:center;<?php if($no>1) { echo "border-top:hidden;"; } ?>" valign="top"> 
																		<?=($no==1)?"3":""?>				
																</td>
																<td style="border-right:none;border-left:none;<?php if($no>1) { echo "border-top:hidden;"; } ?>" valign="top"> 
																	<?=($no==1)?"<strong>Name of Manufacturer & Factory Address -</strong>":""?>	
															      <span style="vertical-align:top;border-right:none;border-left:none">
																    
															      </span></td>
																<td style="border-left:none;<?php if($no>1) { echo "border-top:hidden;"; } ?>"> 
																	 
																</td>
																<td colspan="4" style="border-left:none;"> 
																	 <?=$sup_row->company_name?>
														          <br />
														          <?=$sup_row->address?>
                                                                     <br />
GST NO :
<?=$sup_row->supplier_gstno?>
<br />
 Inv No &amp; Date : 
 <?=$sup_row->suppiler_invoice_no?>
&amp;
<?=date('d/m/Y',strtotime($sup_row->suppiler_invoice_date))?></td>
															 </tr>
											            <?php 
																 $no++;
																	}
																}
															else
															{
																?>
																 
														 
															 <?php
															}
															 ?> 
														 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center"> 
																	4
																</td>
																<td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"><span style="border-right:none;border-top:none;border-left:none"> <strong>Date of Examination </strong> </span></td>
																 <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"><span style="border-top:none;border-left:none;">
																   <?=$annexuredata_examination_date?>
																 </span> 
																	 
															    </td>
													  </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">5</td>
																
																<td style="border:none"><strong>Name & Designation of the Examining officer Inspection / EO/PO</strong></td>
																<td style="border-bottom:none;border-left:none;border-top:none;">
																	 
																</td>
																<td colspan="4" style="border-bottom:none;border-top:none;border-left:none;"> 
																	SELF SEALING

															   </td>
																 
															 </tr>
														    <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">6</td>
																<td style="border:none"><strong>Name &amp; Designation of the Supervising officer Appraiser / Superintendent</strong></td>
																<td style="border-bottom:none;border-left:none;border-top:none;">  </td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;">  
																	 SELF SEALING

																</td>
												 	  </tr>
														    <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">7</td>
																<td style="border:none;" ><strong>a) Name of the Commissinorate Division / Range</strong></td>
																<td  style="border-bottom:none;border-left:none;border-top:none;"> 
																	 
																</td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> 
																	<?php
																	$export_range=array();
																	$export_division=array();
																	foreach($export_supplier_data as $sup_row){ 
																	array_push($export_range,$sup_row->sup_range); 
																	array_push($export_division,$sup_row->division); 
																	}
																	echo implode(",",$export_division);
																	echo " / ";
																	echo implode(",",$export_range);
																	
																	
																	?>  
																</td>
												 	  </tr>
															 <tr>
																<td style="border-right:none;border-top:none;"></td>
																<td style=" border-top:none;border-left:none"  colspan="2"> <strong>b) Location Code </strong></td>
																 
																<td colspan="4" style="border-left:none;border-top:none;"> 
																 <?php
																if($company_detail[0]->s_c_type == "Merchant")
																{
																	$export_location_code=array();
																	$export_division=array();
																	foreach($export_supplier_data as $sup_row){ 
																	array_push($export_location_code,$sup_row->location_code); 
																	 
																	}
																	echo implode(",",$export_location_code);
																}
																else
																{
																	echo $company_detail[0]->location_code;
																}	
																?> 
															</td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">8</td>
																<td style="border:none" colspan="2"> <strong>Particulars of Export Invoice </strong></td>
																<td style="border-bottom:none;border-right:none;border-top:none;" >  </td>
																<td colspan="3" style="border-bottom:none;border-left:none;border-top:none;">  </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"> </td>
																<td style="border:none"  colspan="2"><strong>a) Export Invoice No.</strong></td>
																<td colspan="4" style="border-bottom:none; border-top:none;" >    <?=$invoicedata->export_invoice_no?>, <?=date('d/m/Y',strtotime($invoicedata->invoice_date))?> </td>
															 </tr>
															  <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border:none" colspan="2">
																	<strong>b) Total No. of Pallets </strong>
																</td>
																<td colspan="4" style="border-bottom:none; border-top:none;" >
																	<?=$Total_pallet?> Pallets (<?=$Total_box?> BOXES)
																</td>
														     </tr>
															  <tr>
															    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
															    <td style="border:none" colspan="2"><strong>c) Name and address of the consignee </strong></td>
															    <td colspan="4" style="border-bottom:none; border-top:none;" ><span style=" border-top:none;">
														        <?=$consign_address?>
														        </span></td>
												      </tr>
														     <tr>
																<td style="border-right:none;border-top:none;vertical-align:top"></td>
																<td style="border-right:none;border-top:none;border-left:none;vertical-align:top"colspan="2"  > <strong>d) </strong> <strong>Abroad</strong></td>
																<td colspan="4" style=" border-top:none;" ><span style="vertical-align:top">
																  <?=$country_final_destination?>
																</span></td>
															 </tr>
															  <tr>
																<td style="border-bottom:none;border-right:hidden; border-top:none;text-align:center">9</td>
																<td colspan="2" style="border:none" > <strong>(a) Is the description of the goods the Quantity and their value as per particulars furnished in the export Invoice? </strong></td>
																<td colspan="4" style="border-bottom:none; border-top:none;text-align:left" >  <?=($annexuredata->description_goods_status==1)?"YES":"NO"?>  </td>
															 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border:none"  colspan="2"> <strong> (b) Whether sample is drawn for being forwarded to port of Export </strong></td>
																<td colspan="4" style="border-bottom:none; border-top:none;text-align:left">   <?=($annexuredata->drawn_port_export==1)?"YES":"NO"?>  </td>
															 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"> <strong> (c) If yes, the number of the seal of the package containing the sample </strong> </td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"><span style="border-top:none;text-align:left">
																  <?=($annexuredata->seal_yesno==1)?"YES":"NO"?>
																</span></td>
															 </tr>
															 <tr>
																<td style="border-right:none;border-top:none;"></td>
																<td style="border-right:none;border-top:none;border-left:none"  colspan="2">&nbsp;</td>
																<td colspan="4" style="border-top:none;text-align:left">&nbsp;</td>
															 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">10</td>
															 	<td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"> <strong>Central GST / Customs Seal No. </strong></td>
																 <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> SELF SEALING </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td colspan="2" style="border-bottom:none;border-left:none;border-top:none;" > <strong>a) For Non containerized Cargo  no. of Packages. </strong></td>
															 	<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> <?=$annexuredata->seal_no?> </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border-bottom:none;border-left:none;border-top:none;" colspan="2"><strong>b) For containerized Cargo</strong></td>
																 
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> <?=$annexuredata->containerized_cargo?></td>
														 	 </tr>
															  <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;">
																
																</td>
																<td colspan="2" style="border-bottom:none;border-left:none;border-top:none;">
																	<strong>c) Container Details</strong>
																</td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;">  </td>
															 </tr>
									 							 
							  </table>
							  <table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class invoice_edit_cls2" contenteditable="false">
													  <tr>
													    <td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="11%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="11%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="11%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="11%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="11%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="11%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="11%"></td>
													     
												      </tr>
													  <tr>
													    <td style="text-align:center;font-weight:bold"> CONTAINER NO </td>
													    <td style="text-align:center;font-weight:bold"> CONTAINER TYPE </td>
													    <td style="text-align:center;font-weight:bold"> RFID SEAL </td>
													    <td style="text-align:center;font-weight:bold">LINE SEAL </td>
													    <td style="text-align:center;font-weight:bold"> PALLETS NO </td>
														<td style="text-align:center;font-weight:bold">SIZE (MM)</td>
														<td style="text-align:center;font-weight:bold">PALLETS</td>
													     <td style="text-align:center;font-weight:bold">BOXES</td>
												       </tr>
												  <?php
										 	$Grand_Total_pallet = 0;
											$Total_pallets = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$cntnet_weight=0;
											$Total_ammount = 0;
											$setcontainer = 0;
											$packingtrn_array = array();
											$con_entry = 1;
										 	$con_array = array();
											$conarray = array();
											$sizearray = array();
											 $no_of_row = 15;
											 	$totalnetweight 	= 0 ;	
												$totalgrossweight   = 0; 
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												for($i=0; $i<count($product_data);$i++)
												{
													$total_package = $product_data[$i]->total_package;
													$totalpackage = $product_data[$i]->total_package;
													$Total_pallets  = $product_data[$i]->total_ori_pallet;
													$Totalpallets  = $product_data[$i]->total_ori_pallet;
													$sample_str = '';	  
													 
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowcon_no > 1)?$product_data[$i]->rowcon_no:'';
														 
														$total_package = $product_data[$i]->total_package;
														
														//$Total_pallets  = $product_data[$i]->total_ori_pallet;
														$net_weight 	= $product_data[$i]->total_ori_net_weight;
														$gross_weight 	= $product_data[$i]->total_ori_gross_weight;
													$totalnetweight 	+= $product_data[$i]->total_ori_net_weight;
													$totalgrossweight 	+= $product_data[$i]->total_ori_gross_weight;
															if(empty($sample_str))
															{
																$rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																		$sample_str .= '<tr>
																						 <td style="text-align:center">
																						 	'.$sample_row->product_size_id.' -   '.$sample_row->sample_remarks.'
																						 	
																						 </td>
																						 
																					 	
																						 <td style="text-align:center">
																						 	'.$sample_row->no_of_pallet.'
																						 </td>
																						  <td style="text-align:center">
																						 	'.$sample_row->no_of_boxes.'
																						 </td>
																						  
																 						</tr> ';
																		 
																		$Total_pallets +=$sample_row->no_of_pallet;
																		$Total_sqm 		+= $sample_row->sqm;
																		$Total_box 		+= $sample_row->no_of_boxes;
																		$total_package += $sample_row->no_of_boxes;
																		$Total_ammount 	+= $sample_row->sample_amout;
																		$totalnetweight 	+= $sample_row->netweight;
																		$totalgrossweight 	+= $sample_row->grossweight;
																		$net_weight 	+= $sample_row->netweight;
																		$gross_weight 	+= $sample_row->grossweight;
																		$cntnet_weight =$sample_row->netweight;
																		 $no_of_row--;
																 }
																 
															}
														 
												 	?>
												<tr>   
													<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->container_no?></td>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->container_size?></td>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->self_seal_no?></td>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->seal_no?></td>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->remark?></td>
												<?php 
													$no=1;
													array_push($con_array,$product_data[$i]->con_entry);
											  	}
												 
												if(!in_array($product_data[$i]->size_type_mm.$product_data[$i]->container_no.$product_data[$i]->product_id,$sizearray))
												{	
												
													 
													if($no>1)
													{
														echo "<tr>";
													}
													
												?>
													<td style="text-align:center" ><?=$product_data[$i]->size_type_mm?></td>
													
												 	<td style="text-align:center" > <?=$product_data[$i]->total_ori_pallet?></td>
													<td style="text-align:center" ><?=$totalpackage?></td>
													 
													 
												<?php
											$Grand_Total_pallet  += $product_data[$i]->total_ori_pallet;						
											$Total_box	+= 	$totalpackage;				
													if($no>1)
													{
														echo "</tr>";
													}
													array_push($sizearray,$product_data[$i]->size_type_mm.$product_data[$i]->container_no.$product_data[$i]->product_id);
												}
												if(!in_array($product_data[$i]->con_entry,$conarray))
												{
												?>
												 
													 
						        </tr>
												<?php 
												echo $sample_str;
													array_push($conarray,$product_data[$i]->con_entry);
											  	}
										
												 
												 
											    $Total_sqm 		+= $product_data[$i]->no_of_sqm;
											   
											    
												$Total_ammount 	+= $product_data[$i]->product_amt;
												$no++;
											}
											 
											 for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
                                       <?php
											$no_of_row--;
											}
												
												?>
                                        	  <tr>
													    <td colspan="6" style="text-align:right"><strong>TOTAL</strong></td>
													     
													    <td style="text-align:center;font-weight:bold"><?=($Grand_Total_pallet == 0)?"-":$Grand_Total_pallet; ?></td>
													    <td style="text-align:center;font-weight:bold">													      <?=$Total_box; ?></td>
														 
													    
													   
						        </tr>
							  </table>
							  <table width="100%"  cellspacing="0" cellpadding="0" class="pdf_class invoice_edit_cls2" contenteditable="false">		 
									 		<?php
												if($company_detail[0]->s_c_type == "Merchant")
												{
													$no =1;
													foreach($export_supplier_data as $sup_row)
													{ 
																 ?>
										 <tr>
										<td width="5%" style="border-bottom:none;border-right:none;border-top:none;text-align:center"><?php if($no==1)
																	{
																		?>
										  11
										  <?php
																	}
																	?></td>
										<td width="20%" style="border:none;"><strong>
										  <?php if($no==1)
																	{
																		?>
										  Self-Sealing Permission No. & Date
										  <?php
																	}
																	?>
										  </strong></td>
										
										  <td width="40%" style="border-bottom:none;border-left:none;border-top:none;"><strong>
											<?php if($sup_row->permission_file_no !=' ' || $sup_row->permission_no !=' ' || $sup_row->permission_date != '1970-01-01')
											 {
											 ?>
												  
												  <?=$sup_row->company_name?>
												  <?php
												  if(!empty($sup_row->permission_file_no))
												  {
												  ?>
												  </strong> Permission File No :
												  <?=$sup_row->permission_file_no?>
												  <?php
												  }
												  ?>
												  
												  <?php
												  if(!empty($sup_row->permission_no))
												  {
												  ?>
												  <strong> Permission No.</strong> :
												  <?=$sup_row->permission_no?>
												  <?php
												  }
												  ?>
												  
												  <?php
												  if($sup_row->permission_date != "0000-00-00" && $sup_row->permission_date != "1970-01-01")
												  {
												  ?>
													<strong>Date</strong> :
													
													<?=date('d-m-Y',strtotime($sup_row->permission_date))?>
												  <?php
												  }
												  ?>
											  
									  <?php } ?>
										  </td>
									  </tr>
									  <?php 
																		$no++;
																		}
																	}
																		else
																		{
																			?>
									  
									  
									  <?php
																		}
																		?>
								   <tr>
									   <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">12</td>
									   <td style="border-bottom:none;border-left:none;border-top:none;" colspan="2">
									    EXPORT UNDER GST CIRCULAR No.: <?=$company_detail[0]->gst_circular_no?>, CUSTOM DATED : <?=$company_detail[0]->date_of_filing?> </td>
												 
												 
								  </tr>
											<tr>
												<td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
												<td style="border:none;"><strong>Net Weight</strong> : <?=number_format($totalnetweight,2)?> KGS</td>
												<td style="border-bottom:none;border-left:none;border-top:none;">
													<strong>Gross Weight</strong> : <?=number_format($totalgrossweight,2)?> KGS 
												</td>
												 
								  </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
											  <td colspan="2" bgcolor="#000000" style="border-bottom:none;border-left:hidden; border-top:none;color: #000;"><span style="color: #FFF;">THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT)  :<span style="vertical-align:top; border-right:none; color: #CCC;">
                                              <?=$company_detail[0]->s_lutno?>
                                              </span></span></td>
										  </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
											  <td colspan="2"    style="border-bottom:none;border-left:hidden; border-top:none;">  
											    <?php if($invoicedata->remarks!='')
												   {
													?>
                                                <?=nl2br($invoicedata->remarks)?>
                                                <br />
                                                <br />
                                                <?php
												   }
												   ?>
                                                <?php if($invoicedata->export_under1!='')
												   {
													?>
                                                <?=$invoicedata->export_under1?>
                                                <br />
                                                <?php
												   }
												   ?>
                                                <?php if($invoicedata->company_rules!='')
												   {
													?>
                                                <?=$invoicedata->company_rules?>
                                                <br />
                                                <?php
												   }
												   ?>
                                                <?php if($invoicedata->rex_no_detail!='')
												   {
													?>
                                                <?=$invoicedata->rex_no_detail?>
                                                <?php
												   }
												    if($annexuredata->annexure_remarks!='')
												   {
													?>
                                                <?='<br>'.$annexuredata->annexure_remarks?>
                                                <?php
												   }
												   ?>
											   </td>
							    </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
											  <td colspan="2" style="border-bottom:none;border-left:hidden; border-top:none;"> </td>
										  </tr>
											<tr>
												<td colspan="3" style="padding-left:20px"> 
												 
												FOR, <?=$company_detail[0]->s_name?>
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
												 
													<br>
													<?=nl2br($company_detail[0]->authorised_signatury)?> </td>
												 
											</tr>
						 	  </table>
								<?php
								}
								?>
							</div>
						</div>	
							<?php
									 $output = ob_get_contents(); 
									 
									 $_SESSION['export_invoice_no'] = $invoicedata->export_invoice_no;
									 $_SESSION['export_content'] = $output;
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
 
<?php 
$this->view('lib/footer'); 
 
?>

<script>
function editable_annexure()
{
	$(".invoice_edit_cls2").attr("contenteditable",true)
	$(".invoice_edit_btn2").hide();
	$(".invoice_update_btn2").show();
}
function edit_annexure()
{
	 block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoice/annexure_html_update",
       data:
	   {
			"export_invoice_id"	: <?=$invoicedata->export_invoice_id?>, 
			"annexure_html"		: $(".save_invoice_html2").html()  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}
</script>
