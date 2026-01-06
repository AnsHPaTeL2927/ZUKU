<?php 
 $this->view('lib/header'); 
  
 $invoice_date = date('d-m-Y',strtotime($invoicedata->invoice_date));
 
 $export_ref_date = date('d-m-Y',strtotime($invoicedata->export_ref_date));
 $performa_date = date('d-m-Y',strtotime($invoicedata->performa_date));
 $customer_invoice_no =$invoicedata->customer_invoice_no;
 $export =  ($invoicedata->exporter_detail);
 $export_ref_no =  ($invoicedata->export_ref_no);
 $export_date =  date('d-m-Y',strtotime($invoicedata->export_date));
 $buy_order_no = strip_tags($invoicedata->customer_buy_order_no);
 $exporter_email = $invoicedata->e_email;
 $exporter_mobile = $invoicedata->e_mobile;
 $exporter_gstin = $company_detail[0]->s_gst;
 $exporter_state_code = $company_detail[0]->state_code;
 $exporter_pan = $company_detail[0]->s_pan;
 $exporter_iec = $invoicedata->exporter_iec;
 $consign_name = $invoicedata->c_name;
 $consign_address = ($invoicedata->consign_address);
 $buyer_other_consign = ($invoicedata->buyer_other_consign);	
 $pre_carriage_by=$invoicedata->pre_carriage_by;
 $place_of_receipt=$invoicedata->place_of_receipt;
 $country_origin_goods = $invoicedata->country_origin_goods;
 $country_final_destination = $invoicedata->country_final_destination;
 $bank_detail = $invoicedata->bank_detail;    
 $flight_name_no=$invoicedata->flight_name_no;   				 
 $export_port_loading = $invoicedata->port_of_loading;
 $port_of_discharge =  $invoicedata->port_of_discharge;
 $final_destination =  $invoicedata->final_destination;
 $export_payment_terms = $invoicedata->payment_terms;
 $no_of_container = $invoicedata->container_details;
 $export_terms_of_delivery = $invoicedata->terms_of_delivery;
$container_size = $invoicedata->container_size;
 $exportinvoice_no 			= $invoicedata->export_invoice_no; 
 $_SESSION['customer_content'] = '';
 $_SESSION['customer_invoice_no'] = '';
 
 if($invoicedata->Exchange_Rate_val==0)
 {
	  if($invoicedata->currency_name=="Euro")
	 {
	 	$exchangerate = $userdata->euro;
	 }
	 else if($invoicedata->currency_name=="RS")
	 {
	 	$exchangerate = "1";
	 }
	 else{
	 	$exchangerate = $userdata->usd; 
	 }
  
 }
 else
 {
	 $exchangerate = $invoicedata->Exchange_Rate_val;
 }
$locale='en-US'; //browser or user locale
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
  
  
	 
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
	display: inline-block;
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
	window.open(root+"customerinvoicepdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"customerinvoicepdf/view_pdf";
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
									<a href="<?=base_url().'customer_listing'?>">Customer Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>View Customer Invoice
									<div class="pull-right form-group">
									 
										<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"  ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									</div>
								</h3>
								
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							  <?php 
							  ob_start();
											$Total_sqm 			= 0;
											$Total_box 			= 0;
											$Total_pallet 		= 0;
											$Total_ammount 		= 0;
											$Total_amt 		 	= 0;
											$total_container 	= 0;
											$button_check_array = array();
											$stringcolor		= array();
											$product_desc_array = array();
										 	$series_name_array 	= array();
											$seriesname_array 	= array();
										 	$water_array 		= array();
											$no_of_row 			= 15;
											$totalnetweight 	= 0;
											$totalgrossweight 	= 0;
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
											
												$series_detail =  $product_data[$i]->custdescriptiongoods.' HSN CODE - '.$product_data[$i]->custhsnccode;
												
											 	if(!in_array(trim($series_detail),$series_name_array))
												{
													
													array_push($series_name_array,$series_detail);
													//array_push($water_array,$product_data[$i]->water_text);
												}
											  	 $n = 1;
													$Total_ammount	 += $product_data[$i]->custproductamt;
													$Total_amt 	 	 += $product_data[$i]->custproductamt;
													
													$description_goods =  $product_data[$i]->size_type_cm.$product_data[$i]->pcs_per_box.$product_data[$i]->custproductrate.$product_data[$i]->model_name;
												 
												 	if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 $rowspan++;
 
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->custdescriptiongoods;
														$product_desc_array[trim($description_goods)]['product_name'] = $product_data[$i]->custdescriptiongoods;
														$product_desc_array[trim($description_goods)]['size_type_cm'] = $product_data[$i]->size_type_mm;
														$product_desc_array[trim($description_goods)]['hsnc_code'] = $product_data[$i]->custhsnccode;
														$product_desc_array[trim($description_goods)]['model_name'] = $product_data[$i]->model_name;
														$product_desc_array[trim($description_goods)]['client_name'] = $product_data[$i]->client_name;
														//$product_desc_array[trim($description_goods)]['epcg_no'] =  $product_data[$i]->epcg_no;
														 
														 //$product_desc_array[trim($description_goods)]['epcg_date'] = date('d.m.Y',strtotime($product_data[$i]->epcg_date));
														
														
														$product_desc_array[trim($description_goods)]['water_text'] = $product_data[$i]->water_text;
														 $product_desc_array[trim($description_goods)]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
														 $product_desc_array[trim($description_goods)]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
														$product_desc_array[trim($description_goods)]['title_type'] = $product_data[$i]->tiles_type;
														  
														
														$product_desc_array[trim($description_goods)]['no_of_pallet'] = $product_data[$i]->origanal_pallet + $product_data[$i]->make_pallet_no;
														 if(!empty($product_data[$i]->export_half_pallet))
														{
															$product_desc_array[trim($description_goods)]['export_half_pallet'] = $product_data[$i]->export_half_pallet;
															$product_desc_array[trim($description_goods)]['export_make_pallet_no'] = $product_data[$i]->export_make_pallet_no;
															$count = explode(",",$product_data[$i]->export_make_pallet_no);
															$export_rowspan = count($count);
															$product_desc_array[trim($description_goods)]['export_rowspan'] = $export_rowspan;
															if(!empty($product_data[$i]->export_make_pallet_no))
															{
																$Total_pallet += $product_data[$i]->export_half_pallet;
															} 
														}
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] = $product_data[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] = $product_data[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] = $product_data[$i]->origanal_boxes;
														 
														 $product_desc_array[trim($description_goods)]['sqm'] = ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
														 $product_desc_array[trim($description_goods)]['net_weight'] = $product_data[$i]->packing_net_weight;
														 $product_desc_array[trim($description_goods)]['product_rate'] =$product_data[$i]->custproductrate;
														 $product_desc_array[trim($description_goods)]['per'] = $product_data[$i]->per;
														
														 $product_desc_array[trim($description_goods)]['amount'] = $product_data[$i]->custproductamt;
														  
													}
													else
													{
														$product_desc_array[trim($description_goods)]['no_of_pallet'] += $product_data[$i]->origanal_pallet + $product_data[$i]->make_pallet_no;
														 
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] += $product_data[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] += $product_data[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] += $product_data[$i]->origanal_boxes;
														$product_desc_array[trim($description_goods)]['sqm'] += ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
														$product_desc_array[trim($description_goods)]['amount'] += $product_data[$i]->custproductamt;
														 $product_desc_array[trim($description_goods)]['net_weight'] = $product_data[$i]->packing_net_weight;
													}
													$Total_sqm 			+= ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);;
													$Total_box 			+= $product_data[$i]->origanal_boxes;
													$Total_pallet 		+= $product_data[$i]->origanal_pallet + $product_data[$i]->orginal_no_of_big_pallet + $product_data[$i]->orginal_no_of_small_pallet +  $product_data[$i]->make_pallet_no; 
												
											}
											foreach ($sample_data as $jsondata)
											{
												$Total_sqm 			+= $jsondata->sqm;
												$Total_box 			+= $jsondata->no_of_boxes;
												$Total_pallet 		+= $jsondata->no_of_pallet;
												$totalgrossweight 		+= $jsondata->grossweight;
												$totalnetweight 		+= $jsondata->netweight;
											}
											
							  
							  ?> 
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
									<table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls" contenteditable="false">
											<tr>
												<td width="20%" style="padding:0px"></td>
												<td width="20%" style="padding:0px"></td>
												<td width="18%" style="padding:0px"></td>
												<td width="12%" style="padding:0px"></td>
												<td width="15%" style="padding:0px"></td>
												<td width="15%" style="padding:0px"></td>
												 
										 	</tr>  
											<tr>
												<td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;">
												    COMMERCIAL INVOICE
											  </td>
											</tr>
											<tr>
												<td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;">
												<?php
													if($invoicedata->igst_status==1)
													{
													?>
													"SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING (LUT) WITHOUT PAYMENT OF INTEGRATED TAX (IGST)"
													<?php }
													else{?>
														"SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING ( LUT) WITH PAYMENT OF INTEGRATED TAX (IGST)"
													<?php }?>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold"> Consignor/Exporter/Manufacturer:</td>
												<td>
													<span style="font-weight:bold">Exporter Invoice No. &amp; Date :</span> 
												</td>
												<td><?=$exportinvoice_no?></td>
												<td colspan="2"><?=$invoice_date?></td>
											</tr>
											<tr>
												<td colspan="2" rowspan="4" style="vertical-align:top;border-right:none"><span >
												  <?php
														if($company_detail[0]->s_c_type == "Merchant")
														{
														$no =1;
															foreach($export_supplier_data as $sup_row)
															{ 
															if(!empty($sup_row->supplier_gstno))
															{
																$suppiler_date = '& '.date('d/m/Y',strtotime($sup_row->suppiler_invoice_date));
																	if($sup_row->suppiler_invoice_date == '0000-00-00' || $sup_row->suppiler_invoice_date == '1970-01-01')
																	{
																		$suppiler_date = '';
																	}
																		
																 ?>
                                                  <?=($no>1)?"<br /><hr>":""?>
Manufacturer   :&nbsp;
<strong>
<?=$sup_row->company_name?> &nbsp;
</strong> 
<br />
 <span style="border-left:none;">
<?=$sup_row->address?>
</span><br /> 
GST NO : <?=$sup_row->supplier_gstno?>
<br />
Invoice No  &amp; Date:&nbsp;
<?=$sup_row->suppiler_invoice_no?>
<?=$suppiler_date?> <br /><!--
<?=(empty($sup_row->epcg_no))?"":"EPCG NO :".$sup_row->epcg_no?>
<?=(empty($sup_row->epcg_date) || $sup_row->epcg_date == '1970-01-01')?"":"& DATE :".date('d/m/Y',strtotime($sup_row->epcg_date))?>-->
<?php 
														     
 
																 $no++;
																	}
															}
																}
																
																?>
                                              </span></td>
												<td   style="font-weight:bold" valign="top"> 
													Other Ref PI No. &amp; Date :
												</td>
												<td  colspan="3" valign="top">
														<?=$export_ref_no?> &amp;
													<?=$performa_date?>
												</td>
												</tr>
											<tr>
												<td   style="font-weight:bold" valign="top">Buyer's order No. / Date: </td>
												<td  colspan="3"   valign="top"><?=$buy_order_no?></td>
											</tr>
											<tr>
											  <td   style="font-weight:bold" valign="top"><span style="vertical-align:top;border-left:none"><span style="vertical-align:top;border-right:none"><strong>Exporter IEC No : </strong></span> <span style="vertical-align:top;border-right:none"> <strong><br />
                                              </strong></span></span></td>
											  <td colspan="3" valign="top" ><span style="vertical-align:top;border-right:none">
											    <?=$exporter_iec?>
											  </span></td>
										    </tr>
											<tr>
											  <td valign="top"   style="font-weight:bold"><strong>Exporter GST No :</strong></td>
											  <td colspan="3" valign="top" ><span style="vertical-align:top;border-right:none">
											    <?=$exporter_gstin?>
										      </span></td>
										  </tr>
                                            
											<tr>
											  <td colspan="2" valign="top"><span style="vertical-align:top;border-right:none">
											    <strong>Exporter On A/C OF SHIPPER<br />
											    </strong>
<?=$export?>
											  </span><span style="vertical-align:top;border-left:none"><span style="vertical-align:top;border-right:none"><br />
                                              </span></span></td>
											  <td valign="top"><strong>Exporter PAN No :</strong></td>
											  <td colspan="3" valign="top"><span style="vertical-align:top"><span style="vertical-align:top;border-right:none">
											    <?=$exporter_pan?>
											  </span></span></td>
										  </tr>
											<tr>
												<td colspan="2" valign="top">  <strong>Consignee : </strong><br>
												<?=$consign_address?>
												</td>
												<td colspan="2" valign="top"><strong>Buyer's if other than Consignee (Notify Party):</strong> <br />
												  <span style="vertical-align:top">
													<?=$buyer_other_consign?><br>
													<?php 
													if(!empty($invoicedata->c_contact))
													{
														?>
													Mobile No : <?=$invoicedata->c_contact?><br>
													<?php 
													}
													if(!empty($invoicedata->c_email_address))
													{
														?>
														Email : <?=$invoicedata->c_email_address?>
														<?php 
													}
														?>
													</span>
												</td>
												<td colspan="2"   style="vertical-align:top">
													<span style="vertical-align:top;">
														<span style="font-weight:bold">
															<strong>Bank Details</strong><br />
														</span>
														<?=$bank_detail?>
													</span>
												</td>
											 </tr>
											<tr>
											  <td style="font-weight:bold">  Pre Carriage By</td>
											  <td style="font-weight:bold"> Place of Receipt by Pre-Carrier </td>
											  <td style="font-weight:bold">Country of Origin of Goods </td>
											  <td style="font-weight:bold" colspan="3"><span style="vertical-align:top"> Country of Final Destination  </span></td>
							    </tr>
											 
											 <tr>
												<td>
													<?=$pre_carriage_by?>
												</td>
												<td>
													<?=$place_of_receipt?>
												</td>
												<td>
													<span style="vertical-align:top">
														<?=$country_origin_goods?>
													</span>
												</td>
												<td colspan="3"><span style="vertical-align:top">
												  <?=$country_final_destination?>
												</span></td>
											</tr>
											  <tr>
												<td style="font-weight:bold">Vessel / Flight Name &amp; No </td>
												<td style="font-weight:bold">Port of Loading </td>
												<td colspan=""  style="font-weight:bold">Port of Discharge</td>
												<td style="font-weight:bold" colspan="3"> Final Place of Delivery</td>
											  </tr>
											  <tr>
													
												<td>
													<span style="vertical-align:top">
													<?=$flight_name_no?>
													</span>
												</td>
												<td><span style="vertical-align:top">
												  <?=$export_port_loading?>
												</span></td>
												<td><span style="vertical-align:top">
												  <?=$port_of_discharge?>
												</span></td>
													 <td colspan="3"><span style="vertical-align:top">
													   <?=$final_destination?>
                                                     </span></td>
											</tr> 
											<tr>
											  <td><span style="vertical-align:top"><strong>District of Origin</strong> : MORBI</span> </td>
											  <td> <strong>State of Origin :</strong> GUJARAT</td>
											  <td valign="top"><span style="font-weight:bold">Terms of Delivery &amp;     Payment:</span></td>
												<td colspan="3" valign="top">Delivery  Terms:  <strong><?=$invoicedata->terms_name?>
												  -
											  <?=$export_terms_of_delivery?></strong>
											  <br />											  
											   Payment Terms :  <?=$export_payment_terms?></td>
								  </tr>
											 
						      </table>
										
									<table  width="100%" cellspacing="0" cellpadding="0" style="padding:5px" class="pdf_class invoice_edit_cls">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
											 	  
										  </tr>                          
											<tr>
												<td  style="text-align:center;font-weight:bold">Marks & Nos
												
												</td>
												 <td  rowspan="2" style="text-align:center;font-weight:bold">PRODUCT NAME</td>
												 <td  rowspan="2" style="text-align:center;font-weight:bold">HSN CODE</td>
												 <td  rowspan="2" style="text-align:center;font-weight:bold">SIZE</td>
												 <td  rowspan="2" style="text-align:center;font-weight:bold">DESIGN NAME</td>
												 <td  rowspan="2" style="text-align:center;font-weight:bold">CUSTOMER DESIGN NAME</td>
												<td colspan="3" style="text-align:center;font-weight:bold"> 
													QUANTITY
												</td>
												<td colspan="2" style="text-align:center;font-weight:bold">
													AMOUNT
												</td>
										 	</tr>
										 
											 <tr>
											 	<td  style="text-align:center;font-weight:bold"> 
												
											 <?php
								 	if(!empty($invoicedata->container_twenty))
									{
											echo $invoicedata->container_twenty.' X 20 FCL';
										
									}
									if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
									{
										echo ',';
									}
									if(!empty($invoicedata->container_forty))
									{
										echo $invoicedata->container_forty.' X 40 FCL';
									}
									
															 
									?>
									</td>
											 	<td style="text-align:center;font-weight:bold">TOTAL PALLETS</td>
											 	<td style="text-align:center;font-weight:bold">TOTAL BOXES</td>
												<td style="text-align:center;font-weight:bold"> TOTAL SQM </td>
												<td style="text-align:center;font-weight:bold"> RATE <?=$invoicedata->currency_name?>/SQM 
                                                </td>
												<td style="text-align:center;font-weight:bold"> AMOUNT
                                                (<?=$invoicedata->currency_name?>)
												</td>
										 	</tr>
											 
										 	<?php
											 $no=1;
												for($p=0;$p<count($product_desc_array);$p++)
												{
													if(!empty($product_desc_array[$p]))
													{
											 	 ?>
														<tr>
                                                      <?php 
													  if($p == 0)
													  {
													  ?>
															<td rowspan="<?=$rowspan?>" style="text-align:center;">
																 
															 
                                                              <span style="text-align:center;"> Total Pallets : <?=($Total_pallet == 0)?"-":$Total_pallet ?><br />
                                                              Total G. Weight (Kgs) : <?=($totalgrossweight == 0)?"-":number_format($totalgrossweight,2,'.','') ?><br />
                                                              Total N. Weight(Kgs.) : <?=($totalnetweight == 0)?"-":number_format($totalnetweight,2,'.','') ?><br />
  </span>			
															</td>
                                                        <?php
														}
														if(!empty($product_desc_array[$product_desc_array[$p]]['size_type_cm']))
															{
													  ?>	
																<td style="text-align:center">
																<?=$product_desc_array[$product_desc_array[$p]]['product_name']?>
															</td>
															<td style="text-align:center">
																<?=$product_desc_array[$product_desc_array[$p]]['hsnc_code']?>
															</td>													  
															<td style="text-align:center" >
															 	<?=$product_desc_array[$product_desc_array[$p]]['size_type_cm']?>
																 
															</td>
															
														  	<td style="text-align:center">
																<?=$product_desc_array[$product_desc_array[$p]]['model_name']?>
															</td>
														  	  	<td style="text-align:center"><?=!empty($product_desc_array[$product_desc_array[$p]]['client_name'])?$product_desc_array[$product_desc_array[$p]]['client_name']:"-"?></td>
															
																<?php 
															}
															else
															{
																echo "<td style='text-align:center' colspan='2'>".$product_desc_array[$product_desc_array[$p]]['description_goods']."</td>";
															}
																if($product_desc_array[$product_desc_array[$p]]['export_half_pallet'] > 0 && !empty($product_desc_array[$product_desc_array[$p]]['export_make_pallet_no']))
															{
																?>
																<td rowspan="<?=$product_desc_array[$product_desc_array[$p]]['export_rowspan']?>" style="text-align:center">
																	<?=$product_desc_array[$product_desc_array[$p]]['export_half_pallet']?>
																</td>
																<?php
															}
															else if(empty($product_desc_array[$product_desc_array[$p]]['export_half_pallet']))
															{
																$product_plts  = '';
																 if($product_desc_array[$product_desc_array[$p]]['no_of_pallet'] >0)
																{
																	$product_plts  = $product_desc_array[$product_desc_array[$p]]['no_of_pallet'];
																}
																else if($product_desc_array[$product_desc_array[$p]]['no_of_big_pallet'] > 0 || $product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'] >0)
																{
																	$product_plts  =  $product_desc_array[$product_desc_array[$p]]['no_of_big_pallet'].'<br>'.$product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'];
																}
																else
																{
																	$product_plts = '-';
																}
																echo '<td style="text-align:center">'.$product_plts.'</td>';
															}
																?>
																
															
															<td style="text-align:center">
																<?=$product_desc_array[$product_desc_array[$p]]['boxes']?>
															</td>
															<td style="text-align:center">
																<?=number_format($product_desc_array[$product_desc_array[$p]]['sqm'],2,'.','')?>
															</td>
															<td style="text-align:center">
																<?=$currency_symbol?>
																<?=number_format($product_desc_array[$product_desc_array[$p]]['product_rate'],2)?>
															</td>
															<td style="text-align:center">
																<span style="text-align:center">
																<?=$currency_symbol?>
                                                              <?=number_format($product_desc_array[$product_desc_array[$p]]['amount'],2,'.','')?>
															</span>
															</td>
														</tr>
											
											<?php
											$no_of_row -=1;
											 
											 
									 	$no++;
													}
												}
											
											if(count($sample_data)!=0)
											{	
											
											?>
											<tr>
															<td style="text-align:center;border-bottom:hidden">&nbsp;</td>
														 	<td style="font-weight:bold;text-align:center;border-bottom:hidden"  >Sample</td>
													 		<td colspan="2" style="text-align:center;border-bottom:hidden"></td>
													 		<td style="text-align:center;border-bottom:hidden"></td>
													 		<td style="text-align:center;border-bottom:hidden"></td>
													 		<td style="text-align:center;border-bottom:hidden"></td>
													 		<td style="text-align:center;border-bottom:hidden"></td>
															<td style="text-align:center;border-bottom:hidden"></td>
															 
										  </tr>
											<?php
											}	
											 $no_of_row -= 1;
											 $sample=1;
											 $no++;
											foreach ($sample_data as $jsondata)
											{
											?>
													<tr>
														<td style="border-right:0.5px solid #333;text-align:center;">&nbsp;</td>
														 
														<td style="border-right:0.5px solid #333;text-align:center" ><?=$jsondata->product_size_id?> - <?=$jsondata->sample_remarks?> </td>
													 	 
													 	<td colspan="2"  style="border-right:0.5px solid #333;text-align:center"> </td>
													 	<td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->no_of_pallet?></td>
													 	<td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->no_of_boxes?></td>
													 		<td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->sqm?></td>
													 	<td  style="border-right:0.5px solid #333;text-align:center">
														<?=!empty($jsondata->sample_rate)?$currency_symbol.$jsondata->sample_rate:"FOC"?></td>
														 
													 	<td  style="border-right:0.5px solid #333;text-align:center">  <?=!empty($jsondata->sample_amout)?$currency_symbol.$jsondata->sample_amout:"FOC"?></td>
														
													</tr>
													
												<?php
												$no++;
													 $no_of_row -= 1;	 
												 $totalnetweight 	+= 	$jsondata->netweight;
												$totalgrossweight 	+= 	$jsondata->grossweight; 
													$Total_ammount 	+= $jsondata->sample_amout;
													$Total_amt 		+= $jsondata->sample_amout;
											}
											
										 	for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														 
														<td   style="border:none;border-right:0.5px solid #333;height: 31px;" ></td>
													 	<td colspan="2"  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
										   </tr>
											<?php
											$no_of_row--;
											}
										 	 											
									 	?>										
										 
										 
										 <tr>
											<td colspan="6" rowspan="2"   style="font-weight:bold;vertical-align:middle; text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;">
												
												 THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT)  :  <?=$invoicedata->lut_no?>
                                            
											</td>
											 
									 	   <td  style="font-weight:bold;text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=$Total_pallet; ?></td>
									 	   <td  style="font-weight:bold;text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=$Total_box; ?></td>
											<td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center; color: #000;border-top:0.5px solid #333;border-right:0.5px solid #333;"><span style="font-weight:bold;text-align:center">
											  <?=number_format($Total_sqm,2,'.',''); ?>
											</span></td>
											<td rowspan="2" style="font-weight:bold; text-align:center; color:#000;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=($invoicedata->calculation_operator == 2)? $invoicedata->terms_name: 'FOB';?>
&nbsp;Value </td>
										  	<td rowspan="2" style="font-weight:bold;text-align:right;color:black;border-top:0.5px solid #333;"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.',''); ?></td>
										 </tr>
									  	 <tr>
											 
												<td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center">PALLETS</td>
												<td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center">BOXES</td>
												<td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center">SQM</td>
										  </tr>
										 <?php
										$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->certification_charge:$Total_amt + $invoicedata->certification_charge;  ?>
										  <tr>
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="8"> 
													 <?php if($invoicedata->remarks!='')
												   {
													?>
                                                       
												   <?=nl2br($invoicedata->remarks)?>
											       <br />
                                                   <?php
												   }
												   ?>
												   
												</td>
												 
												<td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="text-align:center">
											 	  CERTIFICATION
											 	</span></td>
											 	<td style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                                                <?=($invoicedata->certification_charge > 0)?number_format($invoicedata->certification_charge,2,'.',''):"0.00" ?></td>
										 </tr>
										  <tr>
											<td colspan="8" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;"> 
											
												<?php
														if($company_detail[0]->s_c_type == "Merchant")
														{
														$no =1;
															foreach($export_supplier_data as $sup_row)
															{ 
																 
														if(!empty($sup_row->epcg_no))
														{
															//echo '  EPCG NO:'.$sup_row->epcg_no.' DATE:'.date('d.m.Y',strtotime($sup_row->epcg_date));
														}
																 $no++;
																	}
																}
																
																?>
											</td>
												 
											 
										    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;">INSURANCE</td>
										    <td style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                                            <?=($invoicedata->insurance_charge > 0)?number_format($invoicedata->insurance_charge,2,'.',''):"0.00" ?></td>
									      </tr>
										 <?php $Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->insurance_charge:$Total_amt + $invoicedata->insurance_charge;  ?>
										  <tr>
												<td   colspan="8" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;">
												<?php if($invoicedata->export_under1!='')
												   {
													?>
											       <?=$invoicedata->export_under1?>
										         <br />
                                                  <?php
												   }
												   ?>
                                                   
												</td>
												 
												 
												<td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2">FREIGHT</td>
											 	<td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol?> <?=($invoicedata->seafright_charge > 0)?number_format($invoicedata->seafright_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										  <?php 
										 if(!empty($invoicedata->extra_calc_name))
										 {
										 ?>
										  <tr>
												<td   colspan="8" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;">
												 
												</td>
												 <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2"><?=$invoicedata->extra_calc_name?>	(<?=($invoicedata->extra_calc_opt == 1)? 	'+': '-';?>)</td>
											 	<td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($invoicedata->extra_calc_amt,2,'.','')?>
												</td>
										 </tr>
										 <?php 
											$Total_amt =($invoicedata->extra_calc_opt == 2)?$Total_amt + $invoicedata->extra_calc_amt:$Total_amt + $invoicedata->extra_calc_amt; 
											 
										  }
										   
										   if(!empty($invoicedata->bank_charge))
										 {
										 ?>
										  <tr>
												<td   colspan="8" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;">
												 
												</td>
												 <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2">
												 Bank Charge
												 </td>
											 	<td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($invoicedata->bank_charge,2,'.','')?>
												</td>
										 </tr>
										 <?php 
											$Total_amt +=    $invoicedata->bank_charge; 
											 
										  }
										  if(!empty($invoicedata->courier_charge))
										 {
										 ?>
										  <tr>
												<td   colspan="8" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;">
												 
												</td>
												 <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2">
												 Courier Charge
												 </td>
											 	<td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($invoicedata->courier_charge,2,'.','')?>
												</td>
										 </tr>
										 <?php 
											$Total_amt +=    $invoicedata->courier_charge; 
											 
										  }
										if(!empty($invoicedata->discount))
										 {
										 ?>
										  <tr>
												<td   colspan="8" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;">
												 
												</td>
												 <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2">
												Discount
												 </td>
											 	<td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($invoicedata->discount,2,'.','')?>
												</td>
										 </tr>
										 <?php 
											$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->discount:$Total_amt - $invoicedata->discount; 
										  }
									  ?>
										   
										  <tr>
										    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="8">AMOUNT CHARGEABLE IN WORDS <span style="text-align:center">
										      <?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
										    </span></td>
										    <td rowspan="2" colspan="2" style="border-right:0.5px solid #333;text-align:center"> 
													<?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?> in <?=$invoicedata->currency_name?> 
												</td>
											 	<td rowspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($invoicedata->grand_total,2,'.','')?>
												</td>
									      </tr>
										
										  <?php 
										   $Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->discount:$Total_amt - $invoicedata->discount; 
										  ?>
										  <tr>
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="8" >
													<?=strtoupper(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?> ONLY 
												</td>
											 	
										 </tr>
										  <?php 
										  
										if($invoicedata->rex_detail_status == 1)
											{
										 ?>
										  <tr>
												  
											 <td  colspan="15" style="border-top:none;font-weight:bold;vertical-align:top;">
												 <center>REX COD DETAILS : <?=$invoicedata->rex_no?></center>
												 <br>
												 <?=$invoicedata->rex_no_detail;?>
											</td>
												 
										  </tr>
										   <?php 
											}
										 ?>
									 
										 <tr>
										   <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="8"> Self Sealing Declaration <br />
(1) Certified That The Description &amp; Value Of Goods Covered By This Invoice Have Been Checked By Me &amp; That Goods Have Been Packed &amp; Sealed With One Time Seal (OTS) Under My Direct Supervision 
										   (2) We Have Follow The Procedure Laid Down In CBEC's Circular No. 426/59/98 CX Dt.12/10/1998 As Amemded Against This Shipment&quot; </td>
										   <td height="50" colspan="3" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:right">For
                                             <?=$company_detail[0]->s_name?>
                                           <br />
                                           <br />
                                           <br />
										   </td>
									      </tr>	
										<tr>
											<td style="border-right:0.5px solid #333;border:0.5px solid #333;" colspan="8">
													
											<strong><u>Declaration</u></strong>: <br />
										  We declared that this invoice shows the actual price of the goods described & that all particulars are true and correct. <br></td>
											<td colspan="3" style="text-align:right;border-top:none" valign="bottom">
											  
										    <?=nl2br($company_detail[0]->authorised_signatury)?>  <br>										    </td>
										  </tr>
							  </table>		 	
								
								<?php
								}
								?>
								</div>		 
							  </div>
							<pagebreak />
						<div class="profile-pic">
								<div class="edit pull-right">
									<a href="javascript:;" style="color:#fff;font-size:12px" class="invoice_edit_btn1 btn btn-primary" onclick="editable_packing();"><i class="fa fa-pencil fa-lg"></i>  Edit</a>
									<a href="javascript:;" class="invoice_update_btn1 btn btn-success" style="display:none;color:#fff" onclick="edit_packing();">Save</a>
								</div>
								<div class="save_invoice_html1">
								<?php 
								
								if(!empty($packing_html_data))
								{
									echo $packing_html_data->invoice_html;
								}
								else
								{
									?>								
							<table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls" contenteditable="false">
											<tr>
												<td width="20%" style="padding:0px"></td>
												<td width="20%" style="padding:0px"></td>
												<td width="18%" style="padding:0px"></td>
												<td width="12%" style="padding:0px"></td>
												<td width="15%" style="padding:0px"></td>
												<td width="15%" style="padding:0px"></td>
												 
										 	</tr>  
											<tr>
												<td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;">
												    PACKING LIST
											  </td>
											</tr>
											<tr>
												<td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;">
												<?php
													if($invoicedata->igst_status==1)
													{
													?>
													"SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING (LUT) WITHOUT PAYMENT OF INTEGRATED TAX (IGST)"
													<?php }
													else{?>
														"SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING ( LUT) WITH PAYMENT OF INTEGRATED TAX (IGST)"
													<?php }?>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold"> Consignor/Exporter/Manufacturer:</td>
												<td>
													<span style="font-weight:bold">Exporter Invoice No. &amp; Date :</span> 
												</td>
												<td><?=$exportinvoice_no?></td>
												<td colspan="2"><?=$invoice_date?></td>
											</tr>
											<tr>
												<td colspan="2" rowspan="4" style="vertical-align:top;border-right:none"><span >
												  <?php
														if($company_detail[0]->s_c_type == "Merchant")
														{
														$no =1;
															foreach($export_supplier_data as $sup_row)
															{ 
															if(!empty($sup_row->supplier_gstno))
															{
																$suppiler_date = '& '.date('d/m/Y',strtotime($sup_row->suppiler_invoice_date));
																	if($sup_row->suppiler_invoice_date == '0000-00-00' || $sup_row->suppiler_invoice_date == '1970-01-01')
																	{
																		$suppiler_date = '';
																	}
																		
																 ?>
                                                  <?=($no>1)?"<br /><hr>":""?>
Manufacturer   :&nbsp;
<strong>
<?=$sup_row->company_name?> &nbsp;
</strong> 
<br />
 <span style="border-left:none;">
<?=$sup_row->address?>
</span><br /> 
GST NO : <?=$sup_row->supplier_gstno?>
<br />
Invoice No  &amp; Date:&nbsp;
<?=$sup_row->suppiler_invoice_no?>
<?=$suppiler_date?> <br /><!--
<?=(empty($sup_row->epcg_no))?"":"EPCG NO :".$sup_row->epcg_no?>
<?=(empty($sup_row->epcg_date) || $sup_row->epcg_date == '1970-01-01')?"":"& DATE :".date('d/m/Y',strtotime($sup_row->epcg_date))?>-->
<?php 
														     
 
																 $no++;
																	}
															}
																}
																
																?>
                                              </span></td>
												<td   style="font-weight:bold" valign="top"> 
													Other Ref PI No. &amp; Date :
												</td>
												<td  colspan="3" valign="top">
														<?=$export_ref_no?> &amp;
													<?=$performa_date?>
												</td>
												</tr>
											<tr>
												<td   style="font-weight:bold" valign="top">Buyer's order No. / Date: </td>
												<td  colspan="3"   valign="top"><?=$buy_order_no?></td>
											</tr>
											<tr>
											  <td   style="font-weight:bold" valign="top"><span style="vertical-align:top;border-left:none"><span style="vertical-align:top;border-right:none"><strong>Exporter IEC No : </strong></span> <span style="vertical-align:top;border-right:none"> <strong><br />
                                              </strong></span></span></td>
											  <td colspan="3" valign="top" ><span style="vertical-align:top;border-right:none">
											    <?=$exporter_iec?>
											  </span></td>
										    </tr>
											<tr>
											  <td valign="top"   style="font-weight:bold"><strong>Exporter GST No :</strong></td>
											  <td colspan="3" valign="top" ><span style="vertical-align:top;border-right:none">
											    <?=$exporter_gstin?>
										      </span></td>
										  </tr>
                                            
											<tr>
											  <td colspan="2" valign="top"><span style="vertical-align:top;border-right:none">
											    <strong>Exporter On A/C OF SHIPPER<br />
											    </strong>
<?=$export?>
											  </span><span style="vertical-align:top;border-left:none"><span style="vertical-align:top;border-right:none"><br />
                                              </span></span></td>
											  <td valign="top"><strong>Exporter PAN No :</strong></td>
											  <td colspan="3" valign="top"><span style="vertical-align:top"><span style="vertical-align:top;border-right:none">
											    <?=$exporter_pan?>
											  </span></span></td>
										  </tr>
											<tr>
												<td colspan="2" valign="top">  <strong>Consignee : </strong><br>
												<?=$consign_address?>
												</td>
												<td colspan="2" valign="top"><strong>Buyer's if other than Consignee (Notify Party):</strong> <br />
												  <span style="vertical-align:top">
													<?=$buyer_other_consign?><br>
													<?php 
													if(!empty($invoicedata->c_contact))
													{
														?>
													Mobile No : <?=$invoicedata->c_contact?><br>
													<?php 
													}
													if(!empty($invoicedata->c_email_address))
													{
														?>
														Email : <?=$invoicedata->c_email_address?>
														<?php 
													}
														?>
													</span>
												</td>
												<td colspan="2"   style="vertical-align:top">
													<span style="vertical-align:top;">
														<span style="font-weight:bold">
															<strong>Bank Details</strong><br />
														</span>
														<?=$bank_detail?>
													</span>
												</td>
											 </tr>
											<tr>
											  <td style="font-weight:bold">  Pre Carriage By</td>
											  <td style="font-weight:bold"> Place of Receipt by Pre-Carrier </td>
											  <td style="font-weight:bold">Country of Origin of Goods </td>
											  <td style="font-weight:bold" colspan="3"><span style="vertical-align:top"> Country of Final Destination  </span></td>
							    </tr>
											 
											 <tr>
												<td>
													<?=$pre_carriage_by?>
												</td>
												<td>
													<?=$place_of_receipt?>
												</td>
												<td>
													<span style="vertical-align:top">
														<?=$country_origin_goods?>
													</span>
												</td>
												<td colspan="3"><span style="vertical-align:top">
												  <?=$country_final_destination?>
												</span></td>
											</tr>
											  <tr>
												<td style="font-weight:bold">Vessel / Flight Name &amp; No </td>
												<td style="font-weight:bold">Port of Loading </td>
												<td colspan=""  style="font-weight:bold">Port of Discharge</td>
												<td style="font-weight:bold" colspan="3"> Final Place of Delivery</td>
											  </tr>
											  <tr>
													
												<td>
													<span style="vertical-align:top">
													<?=$flight_name_no?>
													</span>
												</td>
												<td><span style="vertical-align:top">
												  <?=$export_port_loading?>
												</span></td>
												<td><span style="vertical-align:top">
												  <?=$port_of_discharge?>
												</span></td>
													 <td colspan="3"><span style="vertical-align:top">
													   <?=$final_destination?>
                                                     </span></td>
											</tr> 
											<tr>
											  <td><span style="vertical-align:top"><strong>District of Origin</strong> : MORBI</span> </td>
											  <td> <strong>State of Origin :</strong> GUJARAT</td>
											  <td valign="top"><span style="font-weight:bold">Terms of Delivery &amp;     Payment:</span></td>
												<td colspan="3" valign="top">Delivery  Terms:  <strong><?=$invoicedata->terms_name?>
												  -
											  <?=$export_terms_of_delivery?></strong>
											  <br />											  
											   Payment Terms :  <?=$export_payment_terms?></td>
								  </tr>
											 
						      </table>
										
							<table  width="100%" cellspacing="0" cellpadding="0"  class="pdf_class invoice_edit_cls1">
							    <tr>
									<td colspan="2" style="text-align:center;font-weight:bold"> Marks & NOS
									<br>
									<?php
								 	if(!empty($invoicedata->container_twenty))
									{
											echo $invoicedata->container_twenty.' X 20` FCL';
										
									}
									if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
									{
										echo ',';
									}
									if(!empty($invoicedata->container_forty))
									{
										echo $invoicedata->container_forty.' X 40` FCL';
									}
									
															 
									?>
									</td>
									 
									<td colspan="7" style="text-align:center;font-weight:bold"> Description Of Goods
									<br>
									 <?=str_ireplace(",","<br>",implode(",",$series_name_array))?>
									</td>
									<td colspan="3" style="text-align:center;font-weight:bold">QUANTITY</td>
									<td colspan="2" style="text-align:center;font-weight:bold">APPROX</td>
									 
						      </tr>
							   
							  <tr>
							    <td width="3%" style="text-align:center;font-weight:bold"> SR NO.</td>
							    <td width="8%" style="text-align:center;font-weight:bold"> CONTAINER NO.</td>
							    <td width="8%" style="text-align:center;font-weight:bold"> RFID SEAL NO.</td>
							    <td width="8%" style="text-align:center;font-weight:bold">LINE SEAL NO.</td>
								<td width="8%" style="text-align:center;font-weight:bold"> PALLETS NO.</td>
							    <td width="8%" style="text-align:center;font-weight:bold">SIZE (MM)</td>
							    <td width="8%" style="text-align:center;font-weight:bold">DESIGN</td>
							    <td width="8%" style="text-align:center;font-weight:bold">CUSTOMER DESIGN</td>
							    <td width="8%" style="text-align:center;font-weight:bold">BATCH NO</td>
								<td width="7%" style="text-align:center;font-weight:bold">PALLETS</td>
							    <td width="7%" style="text-align:center;font-weight:bold">BOXES</td>
							    <td width="7%" style="text-align:center;font-weight:bold">SQM</td>
						 	    <td width="7%" style="text-align:center;font-weight:bold"> NET WEIGHT (Kgs)</td>
							    <td width="7%" style="text-align:center;font-weight:bold"> GROSS WEIGHT (Kgs)</td>
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
											$conarray1 = array();
											$sizearray = array();
											$sizearray1 = array();
											$no_of_row = 15;
											 	$totalnetweight 	= 0 ;	
												$totalgrossweight   = 0; 
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												$n = 1;
												
												for($i=0; $i<count($product_data);$i++)
												{
													 
													$total_pallets  = floatval($product_data[$i]->total_ori_pallet);
													$Total_pallets  = floatval($product_data[$i]->total_ori_pallet);
													$sample_str = '';	  
													 
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														$total_package = $product_data[$i]->total_package;
														$totalpackage = $product_data[$i]->total_package;
														
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
																						 	'.$sample_row->product_size_id.'
																						 </td>
																						 <td style="text-align:center">
																						 	Sample
																						 </td>
																						  <td style="text-align:center">
																						 	 
																						 </td>
																						   <td style="text-align:center">
																						 	'.$sample_row->no_of_pallet.' 
																						 </td>
																					 	 <td style="text-align:center">
																						 	'.$sample_row->no_of_boxes.'
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->no_of_sqm.'
																						 </td>
																 						</tr> ';
																		 
																		$Grand_Total_pallet  +=    floatval($sample_row->no_of_pallet);
																	 
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
									<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$n?></td>
									<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->container_no?></td>
									<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->self_seal_no?></td>
									<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->seal_no?></td>
									<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->remark?></td>
							    <?php 
								$n++;
													$no=1;
													array_push($con_array,$product_data[$i]->con_entry);
											  	}
												$desc = $product_data[$i]->size_type_cm.$product_data[$i]->container_no.$product_data[$i]->model_name.$product_data[$i]->no_of_boxes.$product_data[$i]->export_make_pallet_no;
												if(!in_array($desc,$sizearray))
												{	
													 
													if($no>1)
													{
														echo "<tr>";
													}
													if(!empty($product_data[$i]->size_type_mm))
													{
												?>
													<td style="text-align:center" ><?=$product_data[$i]->size_type_mm?></td>
													<td style="text-align:center" ><?=$product_data[$i]->model_name?></td>
													<td style="text-align:center" ><?=!empty($product_data[$i]->client_name)?$product_data[$i]->client_name:"-"?></td>
													<td style="text-align:center" ><?=!empty($product_data[$i]->batch_no)?$product_data[$i]->batch_no:"-"?></td>
							   
													<?php
													}
													else
													{
														echo '<td style="text-align:center"  colspan="2"> 							 
																	'.$product_data[$i]->custdescriptiongoods.'
																</td>';
													}
														$count = explode(",",$product_data[$i]->export_make_pallet_no);
														$export_rowspan = count($count);
														 
														if(!empty($product_data[$i]->pallet_ids) || $product_data[$i]->make_pallet_no == 1)
														{
															if(!empty($product_data[$i]->pallet_ids))
															{
																$pallet_ids = explode(",",$product_data[$i]->pallet_row);
															echo  '<td  style="text-align:center" class="text-center" rowspan="'.count($pallet_ids).'">
																'.$product_data[$i]->make_pallet_no.'     
															</td>';
															$Grand_Total_pallet += $product_data[$i]->make_pallet_no;
															}
														}
														else if(!empty($product_data[$i]->export_make_pallet_no))
														{
															
															echo '<td style="text-align:center" rowspan="'.$export_rowspan.'">
																			'.$product_data[$i]->export_half_pallet.'  
																	</td>';	
														}
														else if(!empty($product_data[$i]->production_mst_id) || empty($product_data[$i]->pallet_row))
														{
															if(empty($product_data[$i]->export_half_pallet))
															{
															echo '  <td style="text-align:center" > ';
																if($product_data[$i]->origanal_pallet > 0)
																{
																	echo $product_data[$i]->origanal_pallet;
																	$Grand_Total_pallet  += $product_data[$i]->origanal_pallet;
																}
																else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
																{
																	echo $product_data[$i]->orginal_no_of_big_pallet."<br>".$product_data[$i]->orginal_no_of_small_pallet;
																	$Grand_Total_pallet  += $product_data[$i]->orginal_no_of_big_pallet;
																	$Grand_Total_pallet  += $product_data[$i]->orginal_no_of_small_pallet;
																}
																else 
																{
																	echo "-";
																}
																echo "</td>";
															}
														}
																 
													 ?>
													 <td style="text-align:center" ><?=$product_data[$i]->origanal_boxes?></td>
													 <td style="text-align:center" ><?=number_format($product_data[$i]->origanal_sqm,2,'.','')?></td>
							  	
													 <?php
													 $Total_box += $product_data[$i]->origanal_boxes;
													if($no>1)
													{
														echo "</tr>";
													}
													array_push($sizearray,$desc);
												}
											 
												if(!in_array($product_data[$i]->con_entry,$conarray))
												{
												?>
												 
							   
							    <td style="text-align:center" rowspan="<?=$rowcon_no?>" ><?=number_format($net_weight,2,'.','')?></td>
							    <td style="text-align:center" rowspan="<?=$rowcon_no?>" ><?=number_format($gross_weight,2,'.','')?></td>
						      </tr>
							  <?php 
												echo $sample_str;
													array_push($conarray,$product_data[$i]->con_entry);
											  	}
										
												 
												 
											    $Total_sqm 		+= $product_data[$i]->no_of_sqm;
											     
												$Total_ammount 	+= $product_data[$i]->product_amt;
												$no++;
											}
											$no_of_row =1; 
											 for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
							  <tr>
							    <td style="text-align:center;border-right:none;border-bottom:none;border-top:none">&nbsp;</td>
							    <td style="text-align:center;border:none">&nbsp;</td>
							    <td style="text-align:center;border:none">&nbsp;</td>
							    <td style="text-align:center;border:none" >&nbsp;</td>
							    <td style="text-align:center;border:none" >&nbsp;</td>
							    <td style="text-align:center;border:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none" >&nbsp;</td>
							    <td colspan="2" style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
							    <td style="text-align:center;border:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none" >&nbsp;</td>
							    <td style="text-align:center;border-left:none;border-bottom:none;border-top:none" >&nbsp;</td>
						      </tr>
							  <?php
											$no_of_row--;
											}
												
												?>
							  <tr>
							    <td colspan="9" style="text-align:right"><strong>TOTAL</strong></td>
							    
							   
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center"><?=($Grand_Total_pallet == 0)?"-":$Grand_Total_pallet; ?> </span></td>
								 <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=$Total_box; ?>
							      </span></td>
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=$Total_sqm; ?>
							      </span></td>
								
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=number_format($totalnetweight,2,'.','')?>
							      </span></td>
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=number_format($totalgrossweight,2,'.','')?>
							      </span></td>
						      </tr>
							  <tr>
							    <td height="100" colspan="14" valign="top" style="text-align:left"><strong> <span style="font-weight:bold;vertical-align:top;">
							      <?php if($invoicedata->remarks!='')
												   {
													?>
							      <?=nl2br($invoicedata->remarks)?>
							      <br />
							      <?php
												   }
												   ?>
							      <?php if($invoicedata->export_under!='')
												   {
													?>
							      <?=$invoicedata->export_under?>
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
												   ?>
							      <br />
							      </span></strong></td>
						      </tr>
							   <?php 
										if($invoicedata->rex_detail_status == 1)
											{
										 ?>
										  <tr>
												  
											 <td  colspan="14" style="border-top:none;font-weight:bold;vertical-align:top;">
												 <center>REX COD DETAILS : <?=$invoicedata->rex_no?></center>
												 <br>
												 <?=$invoicedata->rex_no_detail;?>
											</td>
												 
										  </tr>
										   <?php 
											}
										 ?>
							  <tr>
							    <td colspan="8" rowspan="2" valign="top" style="text-align:left"><strong><u>Declaration</u></strong>: <br />
							      We declared that this packing list shows the actual quantity of the goods described &amp; that all particulars are true and correct or stuffed in the container(s).					
							      
							      
							      &nbsp;</td>
							    <td height="100" colspan="6" style="text-align:right;border-bottom:hidden" valign="top"><span style="border-bottom:hidden">For
							      <?=$company_detail[0]->s_name?>
							      </span></td>
						      </tr>
							  <tr>
							    <td colspan="6" style="text-align:right" valign="top"><?=nl2br($company_detail[0]->authorised_signatury)?></td>
						      </tr>
							  </table>
							<?php
								}
								?>
							</div>		 
							  </div>
 			<?php
									 $output = ob_get_contents(); 
									
									 $_SESSION['customer_invoice_no'] = $invoicedata->customer_invoice_no;
									 $_SESSION['customer_content'] = $output;
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
$this->view('lib/footer'); ?>
<script>
 
function editable_table()
{
	$(".invoice_edit_cls").attr("contenteditable",true)
	$(".invoice_edit_btn").hide();
	$(".invoice_update_btn").show();
}
 function editable_packing()
{
	$(".invoice_edit_cls1").attr("contenteditable",true)
	$(".invoice_edit_btn1").hide();
	$(".invoice_update_btn1").show();
}
function edit_invoice()
{
	 block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"customerinvoiceview/invoice_html_update",
       data:
	   {
			"customer_invoice_id"	: <?=$invoicedata->customer_invoice_id?>, 
			"invoice_html"			: $(".save_invoice_html").html()  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}

function edit_packing()
{
	 block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"customerinvoiceview/packing_html_update",
       data:
	   {
			"customer_invoice_id"	: <?=$invoicedata->customer_invoice_id?>, 
			"packing_html"			: $(".save_invoice_html1").html()  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}

</script>

