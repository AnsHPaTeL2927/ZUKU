<?php 
 $this->view('lib/header'); 
  
 $export_date 				= date('d.m.Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no 			= $invoicedata->export_invoice_no;
 $export 					= ($invoicedata->exporter_detail);
 $export_ref_no 			= ($invoicedata->export_ref_no);
 $performa_date 			= date('d.m.Y',strtotime($invoicedata->performa_date));
 $buy_order_no 				= strip_tags($invoicedata->export_buy_order_no);
 $exporter_email 			= $invoicedata->e_email;
 $exporter_mobile 			= $invoicedata->e_mobile;
 $exporter_gstin 			= $invoicedata->e_gstin;
 $exporter_pan 				= $invoicedata->exporter_pan;
 $exporter_iec 				= $invoicedata->exporter_iec;
 $exporter_state_code		= $company_detail[0]->state_code;
   $exporter_aeono				= $company_detail[0]->aeo_no;

   $cin_no		= $company_detail[0]->s_cin;
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
  $indian_ruppe_val 		= $invoicedata->indian_ruppe_val;
   $Exchange_Rate_val	 	= $invoicedata->Exchange_Rate_val;
  $grand_total_usd			= $invoicedata->grand_total;
   
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
$currency_symbol = ($invoicedata->currency_code=="INR")?"<img src='".base_url()."adminast/assets/images/ruppe_sysbol.jpg' />":$currency_symbol;
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
										<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									</div>
								</h3>
								
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
						<?php
							if(!empty($invoice_html_data || $packing_html_data || $annexure_html_data))
								{
									echo '<div class="pull-right">
											<a class="btn btn-danger tooltips" data-title="Delete" href="javascript:;"  onclick="delete_editable('.$invoicedata->export_invoice_id.')"   ><i class="fa fa-trash"></i> Delete (Edited version)</a>
										</div>	
										';
								}
		?>
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
											$stringcolor=array();
											$product_desc_array = array();
										 	$series_name_array = array();
											$seriesname_array = array();
										 	$water_array = array();
											$no_of_row = 15;
											$totalnetweight =0;
											$totalgrossweight =0;
										$rowspan = 0;
											for($i=0; $i<count($productdata);$i++)
											{	
												 
												
												$totalnetweight 	+= 	$productdata[$i]->updated_net_weight;
												$totalgrossweight 	+= 	$productdata[$i]->updated_gross_weight; 
												
												if(!in_array(trim($productdata[$i]->series_name),$seriesname_array))
												{
													if(!empty($productdata[$i]->series_name))
													{
														array_push($seriesname_array,$productdata[$i]->series_name);
													}
													//array_push($water_array,$product_data[$i]->water_text);
												}
												
											 	if(!in_array(trim($productdata[$i]->series_name.'<br> HSN Code - '.$productdata[$i]->hsnc_code),$series_name_array))
												{
													if(!empty($productdata[$i]->series_name))
													{
														 $rowspan++;
														 
														array_push($series_name_array,$productdata[$i]->series_name.'<br> HSN Code - '.$productdata[$i]->hsnc_code);
													}
													//array_push($water_array,$product_data[$i]->water_text);
												}
											  	 $n = 1;
													$Total_ammount	 += (($productdata[$i]->origanal_boxes * $productdata[$i]->sqm_per_box) * $productdata[$i]->product_rate);
													//$Total_ammount	 += $productdata[$i]->product_amt;
													//$Total_amt 	 	 += $productdata[$i]->product_amt;
													$Total_amt 	 	 += (($productdata[$i]->origanal_boxes * $productdata[$i]->sqm_per_box) * $productdata[$i]->product_rate);
													
													$description_goods =  $productdata[$i]->size_type_cm.$productdata[$i]->pcs_per_box.$productdata[$i]->product_rate.$productdata[$i]->model_name;
												   
												 	if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 $rowspan++;
				 
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $productdata[$i]->description_goods;
														$product_desc_array[trim($description_goods)]['product_name'] = $productdata[$i]->series_name.', HSN Code - '.$productdata[$i]->hsnc_code;
														$product_desc_array[trim($description_goods)]['size_type_cm'] = $productdata[$i]->size_type_mm;
														$product_desc_array[trim($description_goods)]['size_type_mm'] = $productdata[$i]->size_type_mm;
														$product_desc_array[trim($description_goods)]['product_id'] = $productdata[$i]->product_id;
														$product_desc_array[trim($description_goods)]['model_name'] = $productdata[$i]->model_name;
														$product_desc_array[trim($description_goods)]['client_name'] = $productdata[$i]->client_name;
														
														$product_desc_array[trim($description_goods)]['epcg_no'] =  $productdata[$i]->epcg_no;
														 
														 $product_desc_array[trim($description_goods)]['epcg_date'] = date('d.m.Y',strtotime($productdata[$i]->epcg_date));
														
														
														$product_desc_array[trim($description_goods)]['water_text'] = $productdata[$i]->water_text;
														 $product_desc_array[trim($description_goods)]['pcs_per_box'] = $productdata[$i]->pcs_per_box;
														 $product_desc_array[trim($description_goods)]['sqm_per_box'] = $productdata[$i]->sqm_per_box;
														$product_desc_array[trim($description_goods)]['title_type'] = $productdata[$i]->tiles_type;
														  
														
														$product_desc_array[trim($description_goods)]['no_of_pallet'] = $productdata[$i]->origanal_pallet + $productdata[$i]->make_pallet_no;
														 
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] = $productdata[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] = $productdata[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] = $productdata[$i]->origanal_boxes;
														 
														 $product_desc_array[trim($description_goods)]['sqm'] = ($productdata[$i]->origanal_boxes * $productdata[$i]->sqm_per_box);
														 $product_desc_array[trim($description_goods)]['net_weight'] = $productdata[$i]->packing_net_weight;
														 $product_desc_array[trim($description_goods)]['product_rate'] =$productdata[$i]->product_rate;
														 $product_desc_array[trim($description_goods)]['per'] = $productdata[$i]->per;
														
														 $product_desc_array[trim($description_goods)]['amount'] = $productdata[$i]->product_amt;
														  
													}
													else
													{
														$product_desc_array[trim($description_goods)]['no_of_pallet'] += $productdata[$i]->origanal_pallet + $productdata[$i]->make_pallet_no;
														 
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] += $productdata[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] += $productdata[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] += $productdata[$i]->origanal_boxes;
														$product_desc_array[trim($description_goods)]['sqm'] += ($productdata[$i]->origanal_boxes * $productdata[$i]->sqm_per_box);
														$product_desc_array[trim($description_goods)]['amount'] += $productdata[$i]->product_amt;
														 $product_desc_array[trim($description_goods)]['net_weight'] = $productdata[$i]->packing_net_weight;
													}
													$Total_sqm 			+= ($productdata[$i]->origanal_boxes * $productdata[$i]->sqm_per_box);;
													$Total_box 			+= $productdata[$i]->origanal_boxes;
													$Total_pallet 		+= $productdata[$i]->origanal_pallet + $productdata[$i]->orginal_no_of_big_pallet + $productdata[$i]->orginal_no_of_small_pallet +  $productdata[$i]->make_pallet_no; 
												
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
							    <div class="profile-pic" style="margin-top:80px;">
								  <div class="edit pull-right"> 
									<a href="javascript:;" style="color:#fff" class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i class="fa fa-pencil fa-lg"></i> Edit</a> 
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
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												 
										 	</tr>  
											<tr>
												<td colspan="4"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;">
												    EXPORT INVOICE
											  </td>
											</tr>
											<tr>
												<td colspan="4"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;">
												<?php
													if($invoicedata->igst_status==1)
													{
													?>
													SUPPLY MEANT FOR EXPORT UNDER TACKING BOND WITHOUT PAYMENT OF INTERGRATED TAX (IGST)
													<?php }
													else{?>
														
														SUPPLY MEANT FOR EXPORT UNDER TACKING BOND WITH PAYMENT OF INTERGRATED TAX (IGST)
													<?php }?>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold;border-bottom:none">Exporter :</td>
												<td><span style="font-weight:bold">Exporter Invoice No. &amp; Date :</span> 
														 
												</td>
												
												<td>IEC NUMBER
												
												</td>
											</tr>
											<tr>
												<td rowspan="5" colspan="2" style="vertical-align:top;border-right:none;border-top:none"> 
												 <?=$export?></td>
												 <td><?=$exportinvoice_no?></td>
												 <td><?=$exporter_iec?></td>
											</tr>
											<tr>
												 
												 <td><strong> DT. <?=$export_date?></strong></td>
												 <td> <strong>STATE CODE :<?=$exporter_state_code?></strong></td>
											</tr>
											<tr>
												 
												 <td> <strong>GST No :  
												     <?=$exporter_gstin?></strong></td>
												 <td> <strong>MASTER NO : <?=$consign_name?></strong></td>
												 
											</tr>
											<tr>
												 
												 <td colspan="2"> PI No. &amp; Date : 
												    <strong> <?=$export_ref_no?>
&amp;
<?=$performa_date?></strong></td>
												 
											</tr>																						<tr>												 													<td colspan="2">Buyer Order No & Date :												     <strong> <?=$buy_order_no?></strong></td>												 											</tr>
												  
										 	<tr>
												<td colspan="2" valign="top">  <strong>Consignee : </strong><br>
												<?=$consign_address?>
												</td>
												<td colspan="2" valign="top"><strong>Buyer's if other than Consignee (Notify Party):</strong> <br />
												  <span style="vertical-align:top">
											      <?=$buyer_other_consign?>
										        </span></td>
										 	</tr>
											<tr>
											  <td>  Pre Carriage By</td>
											  <td> Place of Receipt by Pre-Carrier </td>
											  <td colspan="2" rowspan="4"  style="vertical-align:top">
											   Bank Details 
												<br />
                                                    <?=$bank_detail?>
											 	</td>
										</tr>
											 
											 <tr>
											 
												<td>
													<?=!empty($pre_carriage_by)?$pre_carriage_by:'&nbsp;'?>
												</td>
												<td>
													<?=$place_of_receipt?>
												</td>
											</tr>
											<tr>
											    <td>Vessel /Flight No. </td>
													
												<td>Port Of Loading : - </td>
												
											  </tr>
											   <tr>
											 
												<td>
												<?=!empty($flight_name_no)?$flight_name_no:'&nbsp;'?> 
												</td>
												<td>
													<?=$export_port_loading?>
												</td>
											</tr>
											<tr>
												<td>
													Port Of Discharge
												</td>
												<td> Final Destination </td>
												<td style="text-align:center;border-bottom:none" colspan="2">Terms of Delivery & Payment </td>
											</tr>
											<tr>
												<td style="font-weight:bold">
													 <?=$port_of_discharge?>
												</td>
												<td style="font-weight:bold"> 
													<?=$final_destination?>
												</td>
												<td style="font-weight:bold;vertical-align:top;text-align:center;border-top:none" colspan="2" rowspan="3">
													<?=$invoicedata->terms_name?>
													-
												<?=$export_terms_of_delivery?>
												<br>
												PAYMENT : <?=$export_payment_terms?> 
												
												
												</td>
											</tr>
											<tr>
											    <td>Country of Origin of Goods  </td>
												
												<td>Country of Final Destination</td>
												
											  </tr>
											  <tr>
											    <td style="font-weight:bold"><?=!empty($country_origin_goods)?$country_origin_goods:'&nbsp;'?> </td>
													
												<td style="font-weight:bold"><?=!empty($country_final_destination)?$country_final_destination:'&nbsp;'?></td>
												
											  </tr>
											  
											   
						      </table>
										
										 
										<table  width="100%" cellspacing="0" cellpadding="0" style="padding:5px" class="pdf_class invoice_edit_cls" contenteditable="false">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="30%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
											 	  
										  </tr>                          
											<tr>
												<td rowspan="2" style="text-align:center;font-weight:bold">Marks & Nos</td>
												 <td  rowspan="2" style="text-align:center;font-weight:bold">DESCRIPTION OF GOODS</td>
												 <td  rowspan="2" style="text-align:center;font-weight:bold">Design Name</td>
												<td colspan="3" style="text-align:center;font-weight:bold"> 
													QUANTITY
												</td>
												<td colspan="2" style="text-align:center;font-weight:bold">
													AMOUNT
												</td>
										 	</tr>
											
											 <tr>
											 	<td style="text-align:center;font-weight:bold">TOTAL PALLETS</td>
											 	<td style="text-align:center;font-weight:bold">TOTAL BOXES</td>
												<td style="text-align:center;font-weight:bold"> TOTAL SQM </td>
												<td style="text-align:center;font-weight:bold"> Rate <?=$invoicedata->currency_name?>/SQM 
                                                </td>
												<td style="text-align:center;font-weight:bold"> Amount
                                                (<?=$invoicedata->currency_name?>)
												</td>
										 	</tr>
											<tr>
											 	<td style="text-align:center;font-weight:bold">
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
											
										 	<?php
											  	 
												$hsn1 = '';
										 		$no=1;
												for($p=0;$p<count($product_desc_array);$p++)
												{
													if(!empty($product_desc_array[$p]))
													{
														
														 
														$hsn = $product_desc_array[$product_desc_array[$p]]['product_name'];
														 
														if($hsn != $hsn1)
														{
															
															?>
																<?=($p==0)?"":"<tr>"?>
																	 
																	<td colspan="7" style="text-align:center;font-weight:bold">
																		<?=$hsn?>
																	</td>
																<?=($p==0)?"</tr>":""?>
															<?php 
														}
													$hsn1 = $product_desc_array[$product_desc_array[$p]]['product_name'];
													?>	
											 	 
														<tr>
                                                      <?php 
													  if($p == 0)
													  {
														  
															// $rowspan = $rowspan - 1;
														 
														   
													  ?>
															<td rowspan="<?=($rowspan > 55)?"56":$rowspan?>" style="text-align:center;border-bottom:hidden">
																 
															 
                                                              <span style="text-align:center;"> Total Pallets : <?=($Total_pallet == 0)?"-":$Total_pallet ?><br />
                                                              Total G. Weight (Kgs) : <?=($totalgrossweight == 0)?"-":number_format($totalgrossweight,2,'.','') ?><br />
                                                              Total N. Weight(Kgs.) : <?=($totalnetweight == 0)?"-":number_format($totalnetweight,2,'.','') ?><br />
  </span>			
															</td>
                                                        <?php
													  }
													  else if($p > 55)
													  {
														  echo '<td  style="text-align:center;"></td>';
													  }
													  ?>														
															<td style="text-align:center" >
														<?php 
														if(!empty($product_desc_array[$product_desc_array[$p]]['product_id']))
														{
															echo "Size :".$product_desc_array[$product_desc_array[$p]]['size_type_cm'].",(1 BOX = ".number_format($product_desc_array[$product_desc_array[$p]]['sqm_per_box'],2,'.','')." SQ.MTR)";
														}
														else
														{
															echo $product_desc_array[$product_desc_array[$p]]['description_goods'];
														}
														?>		 
 
														</td>
														 
															 
														 
															<td style="text-align:center">
																<?=$product_desc_array[$product_desc_array[$p]]['model_name']?>
															</td>
															<td style="text-align:center">
																<?php 
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
																echo $product_plts;
																?>
																
															</td>
															<td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['boxes']?></td>
															<td style="text-align:center"><?=number_format($product_desc_array[$product_desc_array[$p]]['sqm'],2,'.','')?></td>
															<td style="text-align:center"><?=$currency_symbol?>
                                                            <?=number_format($product_desc_array[$product_desc_array[$p]]['product_rate'],2)?></td>
															<td style="text-align:center"><span style="text-align:center">
															  <?=$currency_symbol?>
                                                              <?=number_format(($product_desc_array[$product_desc_array[$p]]['sqm'] * $product_desc_array[$product_desc_array[$p]]['product_rate']),2,'.','')?>
															</span></td>
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
													 		<td style="text-align:center;border-bottom:hidden"></td>
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
													 	 
													 	<td  style="border-right:0.5px solid #333;text-align:center"> </td>
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
											
										 	for($row=$no_of_row-5;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														 
														<td   style="border:none;border-right:0.5px solid #333;height: 31px;" ></td>
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
										 	 											
										 	for($row=1;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														 
														<td  style="border:none;border-right:0.5px solid #333;height: 31px;" ></td>
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
											<td colspan="3" rowspan="2"   style="font-weight:bold;vertical-align:middle; text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;">
											<?php
											if ($invoicedata->igst_status == 1) {
												echo 'THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT): ' . htmlspecialchars($invoicedata->lut_no);
												// Code for when igst_status is 1 (can be left empty or add something if needed)
											} else {
												// Display the message when igst_status is not 1
												
											}
											?>

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
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5"> 
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
											<td colspan="5" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;"> 
											
												<?php
														if($company_detail[0]->s_c_type == "Merchant")
														{
														$no =1;
															foreach($export_supplier_data as $sup_row)
															{ 
																 
														if(!empty($sup_row->epcg_no))
														{
															echo '  EPCG NO:'.$sup_row->epcg_no.' DATE:'.date('d.m.Y',strtotime($sup_row->epcg_date));
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
												<td  colspan="5" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;">
												<?php if($invoicedata->export_under1!='')
												   {
													?>
											       <?=$invoicedata->export_under1?>
										         <br />
                                                  <?php
												   }
												   else
												   {
													   echo "&nbsp;";
												   }
												   ?>
                                                   
												</td>
												 
												 
												<td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2">FREIGHT</td>
											 	<td   style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol?><?=($invoicedata->seafright_charge > 0)?number_format($invoicedata->seafright_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										  
										 <?php  $Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->seafright_charge:$Total_amt + $invoicedata->seafright_charge; 
										  $Total_amt += $invoicedata->courier_charge; 
										  $Total_amt += $invoicedata->bank_charge; 
										 
									 	 ?>
										  <tr>
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5">
													BOND NO. ARN : <?=$invoicedata->aeo_no?>
												</td>
												<td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;">DISCOUNT</td>
										    <td style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                                            <?=($invoicedata->discount > 0)?number_format($invoicedata->discount,2,'.',''):"0.00" ?></td>
										 	     
										 </tr>
										  <?php $Total_amt = $Total_amt - $invoicedata->discount;  ?>
										  <?php 
										 if(!empty($invoicedata->extra_calc_name))
										 {
										 ?>
										 <tr>
										    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5"> 
												
											</td>
										   <td colspan="2" style="border-right:0.5px solid #333;text-align:center"> 
												<?=$invoicedata->extra_calc_name?>	(<?=($invoicedata->extra_calc_opt == 1)? 	'+': '-';?>) 
												</td>
											 	<td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($invoicedata->extra_calc_amt,2,'.','')?>
												</td>
									      </tr>
										  <?php 
											$Total_amt =($invoicedata->extra_calc_opt == 2)?$Total_amt + $invoicedata->extra_calc_amt:$Total_amt + $invoicedata->extra_calc_amt; 
											 
										  }
										  ?>
										  <tr>
										    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5">AMOUNT CHARGEABLE IN WORDS <span style="text-align:center">
										      <?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
										    </span></td>
										   <td rowspan="2"  colspan="2" style="border-right:0.5px solid #333;text-align:center"> 
													<?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?> in <?=$invoicedata->currency_name?> 
												</td>
											 	<td rowspan="2"  style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($Total_amt,2,'.','')?>
												</td>
									      </tr>
										
										  <?php 
										//  $Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->discount:$Total_amt - $invoicedata->discount; 
											 
										  ?>
										  <tr>
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5"><?=strtoupper(convertamonttousd($Total_amt,$invoicedata->currency_name))?> ONLY </td>
											 	
										 </tr>
										 
									 
										 <tr>
										   <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="5"> Self Sealing Declaration <br />
(1) Certified That The Description &amp; Value Of Goods Covered By This Invoice Have Been Checked By Me &amp; That Goods Have Been Packed &amp; Sealed With One Time Seal (OTS) Under My Direct Supervision 
										   (2) We Have Follow The Procedure Laid Down In CBEC's Circular No. 426/59/98 CX Dt.12/10/1998 As Amemded Against This Shipment&quot; </td>
										   <td height="50" colspan="3" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:right">For
                                             <?=$company_detail[0]->s_name?>
                                           <br />
                                      									
											<img 
												src="<?= base_url('upload/' . $company_detail[0]->s_c_sign) ?>" 
												width="120px" 
												alt="Company Signature" 
												onerror="this.onerror=null;this.src='<?= base_url('upload/default_signature.png') ?>';"
											>
									
										   </td>
									      </tr>	
										<tr>
											<td style="border-right:0.5px solid #333;border:0.5px solid #333;" colspan="5">
													
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
				<a href="javascript:;" style="color:#fff" class="invoice_edit_btn1 btn btn-primary" onclick="editable_packing();"><i class="fa fa-pencil fa-lg"></i> Edit</a> <a href="javascript:;" class="invoice_update_btn1 btn btn-success" style="display:none;color:#fff" onclick="edit_packing();">Save</a> 
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
									
								  <table cellspacing="0" cellpadding="0" width="100%"  class="pdf_class invoice_edit_cls1" contenteditable="false">
											<tr>
												<td style="padding:0;border:none" colspan="4">
														 
												</td>
										 	</tr>  
											<tr>
												<td width="25%" style="padding:0;border:none;"></td>
												<td width="25%" style="padding:0;border:none;"></td>
												<td width="25%" style="padding:0;border:none;"></td>
												<td width="25%" style="padding:0;border:none;"></td>
												 
										 	</tr>  
											<tr>
												<td colspan="4"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;">
												    PACKING LIST
											  </td>
											</tr>
											<tr>
												<td colspan="4"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;">
												<?php
													if($invoicedata->igst_status==1)
													{
													?>
													SUPPLY MEANT FOR EXPORT UNDER TACKING BOND WITHOUT PAYMENT OF INTERGRATED TAX (IGST)
													<?php }
													else{?>
														
														SUPPLY MEANT FOR EXPORT UNDER TACKING BOND WITH PAYMENT OF INTERGRATED TAX (IGST)
													<?php }?>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold;border-bottom:none">Exporter :</td>
												<td><span style="font-weight:bold">Exporter Invoice No. &amp; Date :</span> 
														 
												</td>
												
												<td>IEC NUMBER
												
												</td>
											</tr>
											<tr>
												<td rowspan="5" colspan="2" style="vertical-align:top;border-right:none;border-top:none"> 
												 <?=$export?></td>
												 <td><?=$exportinvoice_no?></td>
												 <td><?=$exporter_iec?></td>
											</tr>
											<tr>
												 
												 <td><strong> DT. <?=$export_date?></strong></td>
												 <td> <strong>STATE CODE :<?=$exporter_state_code?></strong></td>
											</tr>
										<tr>
												 
												 <td> <strong>GST No :  
												     <?=$exporter_gstin?></strong></td>
												 <td> <strong>MASTER NO : <?=$consign_name?></strong></td>
												 
											</tr>
											<tr>
												 
												 <td colspan="2"> PI No. &amp; Date : 
												    <strong> <?=$export_ref_no?>
&amp;
<?=$performa_date?></strong></td>
												 
											</tr>											<tr>												 													<td colspan="2">Buyer Order No & Date :												     <strong> <?=$buy_order_no?></strong></td>												 											</tr>
												  
										 	<tr>
												<td colspan="2" valign="top">  <strong>Consignee : </strong><br>
												<?=$consign_address?>
												</td>
												<td colspan="2" valign="top"><strong>Buyer's if other than Consignee (Notify Party):</strong> <br />
												  <span style="vertical-align:top">
											      <?=$buyer_other_consign?>
										        </span></td>
										 	</tr>
											<tr>
											  <td>  Pre Carriage By</td>
											  <td> Place of Receipt by Pre-Carrier </td>
											  <td colspan="2" rowspan="4"  style="vertical-align:top">
											   Bank Details 
												<br />
                                                    <?=$bank_detail?>
											 	</td>
										</tr>
											 
											 <tr>
											 
												<td>
													<?=!empty($pre_carriage_by)?$pre_carriage_by:'&nbsp;'?>
												</td>
												<td>
													<?=$place_of_receipt?>
												</td>
											</tr>
											<tr>
											    <td>Vessel /Flight No. </td>
													
												<td>Port Of Loading : - </td>
												
											  </tr>
											   <tr>
											 
												<td>
												<?=!empty($flight_name_no)?$flight_name_no:'&nbsp;'?> 
												</td>
												<td>
													<?=$export_port_loading?>
												</td>
											</tr>
											<tr>
												<td>
													Port Of Discharge
												</td>
												<td> Final Destination </td>
												<td style="text-align:center;border-bottom:none" colspan="2">Terms of Delivery & Payment </td>
											</tr>
											<tr>
												<td style="font-weight:bold">
													 <?=$port_of_discharge?>
												</td>
												<td style="font-weight:bold"> 
													<?=$final_destination?>
												</td>
												<td style="font-weight:bold;vertical-align:top;text-align:center;border-top:none" colspan="2" rowspan="3">
													<?=$invoicedata->terms_name?>
													-
												<?=$export_terms_of_delivery?>
												<br>
												PAYMENT : <?=$export_payment_terms?> 
												
												
												</td>
											</tr>
											<tr>
											    <td>Country of Origin of Goods  </td>
												
												<td>Country of Final Destination</td>
												
											  </tr>
											  <tr>
											    <td style="font-weight:bold"><?=!empty($country_origin_goods)?$country_origin_goods:'&nbsp;'?> </td>
													
												<td style="font-weight:bold"><?=!empty($country_final_destination)?$country_final_destination:'&nbsp;'?></td>
												
											  </tr>
											  
											   
						      </table>
							 
							<table  width="100%" cellspacing="0" cellpadding="0" class="pdf_class invoice_edit_cls1" contenteditable="false">
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
									 
									<td colspan="5" style="text-align:center;font-weight:bold"> Description Of Goods
									<br>
									 <?=implode(",",$series_name_array)?>
									</td>
									<td colspan="3" style="text-align:center;font-weight:bold">QUANTITY</td>
									<td colspan="2" style="text-align:center;font-weight:bold">APPROX</td>
									 
						      </tr>
							   
							  <tr>
							    <td width="3%" style="text-align:center;font-weight:bold"> SR NO.</td>
							    <td width="10%" style="text-align:center;font-weight:bold"> CONTAINER NO.</td>
							    <td width="10%" style="text-align:center;font-weight:bold"> RFID SEAL NO.</td>
							    <td width="10%" style="text-align:center;font-weight:bold">LINE SEAL NO.</td>
								<td width="8%"  style="text-align:center;font-weight:bold"> PALLETS NO.</td>
							    <td width="10%" style="text-align:center;font-weight:bold">SIZE (MM)</td>
							    <td width="14%" style="text-align:center;font-weight:bold">DESIGN</td>
								<td width="7%" style="text-align:center;font-weight:bold">PALLETS</td>
							    <td width="6%" style="text-align:center;font-weight:bold">BOXES</td>
							    <td width="6%" style="text-align:center;font-weight:bold">SQM</td>
						 	    <td width="8%" style="text-align:center;font-weight:bold"> NET WEIGHT (Kgs)</td>
							    <td width="8%" style="text-align:center;font-weight:bold"> GROSS WEIGHT (Kgs)</td>
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
											$no_of_row = 20;
											 	$totalnetweight 	= 0;	
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
																						 	 '.$sample_row->no_of_pallet.'
																						 </td>
																					 	 <td style="text-align:center">
																						 	'.$sample_row->no_of_boxes.'
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->sqm.'
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
												$desc = $product_data[$i]->size_type_cm.$product_data[$i]->container_no.$product_data[$i]->model_name.$product_data[$i]->no_of_boxes;
												// if(!in_array($desc,$sizearray))
												// {	
													 
													if($no>1)
													{
														echo "<tr>";
													}
													if(!empty($product_data[$i]->product_id))
													{
														?>
														<td style="text-align:center" ><?=$product_data[$i]->size_type_mm?></td>
														<td style="text-align:center" ><?=$product_data[$i]->model_name?></td>
														<?php
													}
													else
													{
														?>
														<td style="text-align:center" colspan="2" >
															<?=$product_data[$i]->description_goods?>
														</td>
														 
														<?php
													}
												 
														
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
														else if(!empty($product_data[$i]->production_mst_id) || empty($product_data[$i]->pallet_row))
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
																 
													 ?>
													 <td style="text-align:center" ><?=$product_data[$i]->origanal_boxes?></td>
													 <td style="text-align:center" ><?=number_format((($packing->product_id == 0)?$product_data[$i]->origanal_sqm:$product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box),2,'.','')?></td>
							  	
													 <?php
													 $Total_box += $product_data[$i]->origanal_boxes;
													
													if($no>1)
													{
														echo "</tr>";
														$no_of_row--;
													}
													// array_push($sizearray,$desc);
												// }
												 //$Total_sqm += ($productdata[$i]->origanal_boxes * $productdata[$i]->sqm_per_box);
												if(!in_array($product_data[$i]->con_entry,$conarray))
												{
												?>
												 
							   
							    <td style="text-align:center" rowspan="<?=$rowcon_no?>" ><?=number_format($net_weight,2,'.','')?></td>
							    <td style="text-align:center" rowspan="<?=$rowcon_no?>" ><?=number_format($gross_weight,2,'.','')?></td>
						      </tr>
							  <?php 
							  $no_of_row--;
												echo $sample_str;
												$no_of_row--;
													array_push($conarray,$product_data[$i]->con_entry);
											  	}
										
												 
												 
											      
												$Total_ammount 	+= $product_data[$i]->product_amt;
												 $Total_sqm += ($productdata[$i]->origanal_boxes * $productdata[$i]->sqm_per_box);
												$no++;
											}
											// foreach ($sample_data as $jsondata)
											// {
												// $Total_sqm 			+= $jsondata->sqm;
												// $Total_box 			+= $jsondata->no_of_boxes;
												// $Total_pallet 		+= $jsondata->no_of_pallet;
												// $totalgrossweight 		+= $jsondata->grossweight;
												// $totalnetweight 		+= $jsondata->netweight;
											// }
											 for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
							  <tr>
							    <td style="text-align:center;border-right:none;border-bottom:none;border-top:none">&nbsp;</td>
							    <td style="text-align:center;border:none">&nbsp;</td>
							    <td style="text-align:center;border:none">&nbsp;</td>
							    <td style="text-align:center;border:none" >&nbsp;</td>
							    <td style="text-align:center;border:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
							    <td style="text-align:center;border:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none" >&nbsp;</td>
							    <td style="text-align:center;border-left:none;border-bottom:none;border-top:none" >&nbsp;</td>
						      </tr>
							  <?php
											 
											}
												
												?>
							  <tr>
							    <td colspan="7" style="text-align:right"><strong>TOTAL</strong></td>
							    
							   
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center"><?=($Grand_Total_pallet == 0)?"-":$Grand_Total_pallet; ?> </span></td>
								 <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=$Total_box; ?>
							      </span></td>
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=number_format($Total_sqm,2,'.',''); ?>
							      </span></td>
								
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=number_format($totalnetweight,2,'.','')?>
							      </span></td>
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
							      <?=number_format($totalgrossweight,2,'.','')?>
							      </span></td>
						      </tr>
							  <tr>
							    <td height="100" colspan="12" valign="top" style="text-align:left"><strong> <span style="font-weight:bold;vertical-align:top;">
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
							  <tr>
							    <td colspan="7" rowspan="2" valign="top" style="text-align:left"><strong><u>Declaration</u></strong>: <br />
							      We declared that this packing list shows the actual quantity of the goods described &amp; that all particulars are true and correct or stuffed in the container(s).					
							      
							      
							      &nbsp;</td>
							    <td height="100" colspan="5" style="text-align:left;border-bottom:hidden" valign="top"><span style="border-bottom:hidden"><span style="border-bottom:hidden">For
							      <?=$company_detail[0]->s_name?>
							      </span>
								  <br>
								 
											<img 
												src="<?= base_url('upload/' . $company_detail[0]->s_c_sign) ?>" 
												width="120px" 
												alt="Company Signature" 
												onerror="this.onerror=null;this.src='<?= base_url('upload/default_signature.png') ?>';"
											>
								

						      </tr>
							  <tr>
							    <td colspan="5" style="text-align:left" valign="top"><?=nl2br($company_detail[0]->authorised_signatury)?></td>
						      </tr>
							  </table>
							   <?php
								}
								?>
              </div>
            </div>
							<pagebreak />		
							 <div class="profile-pic">
              <div class="edit pull-right"> <a href="javascript:;" style="color:#fff" class="invoice_edit_btn2 btn btn-primary" onclick="editable_annexure();"><i class="fa fa-pencil fa-lg"></i> Edit</a> <a href="javascript:;" class="invoice_update_btn2 btn btn-success" style="display:none;color:#fff" onclick="edit_annexure();">Save</a> </div>
              <div class="save_invoice_html2">
                <?php 
								if(!empty($annexure_html_data))
								{
									echo $annexure_html_data->invoice_html;
								}
								else
								{
									?>
									
                            		 
							  <h4 style="text-align:center;"><strong style="font-size:18px;">ANNEXURE</strong></h4>
												 
							  <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls2" style="padding:7px;" contenteditable="false">
														 	 <tr>
														 	   <td colspan="4" align="center">OFFICE OF THE SUPERITENTNDENT OF CENTRAL GST / CUSTOM DEPARTMENT</td>
						 	    </tr>
														 	 <tr>
				<td colspan="4" align="center">GST OFFICE,  CGST - <?=$company_detail[0]->com_range?> , DIVISION CODE - <?=$company_detail[0]->com_division?>,  COMMISSIONERATE - <?=$company_detail[0]->commissionerate?>.</td>
						 	    </tr>
														 	 
														 	 <tr>
														 	   <td colspan="4" align="center"><?php
													if($invoicedata->igst_status==1)
													{
													?>
													SUPPLY MEANT FOR EXPORT UNDER TACKING BOND WITHOUT PAYMENT OF INTERGRATED TAX (IGST)
													<?php }
													else{?>
														
														SUPPLY MEANT FOR EXPORT UNDER TACKING BOND WITH PAYMENT OF INTERGRATED TAX (IGST)
													<?php }?></td>
						 	    </tr>
							  </table>
													<table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls2" contenteditable="false" >
														<tr>
															<td style="padding:0px;border:none" width="5%"></td>
															<td style="padding:0px;border:none" width="42%"></td>
															<td style="padding:0px;border:none" width="5%"></td>
															<td style="padding:0px;border:none" width="6%"></td>
															<td width="42%" colspan="3" style="padding:0px;border:none"></td>
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
if ($company_detail[0]->s_c_type == "Merchant") {
    $no = 1;
    $previous_company_name = "";

    foreach ($export_supplier_data as $sup_row) {
        $company_name = trim($sup_row->company_name);

        // Skip if company name is empty or already displayed
        if (empty($company_name) || $company_name === $previous_company_name) {
            continue;
        }
?>
<tr>
    <td style="border-right:none;text-align:center;<?php if ($no > 1) { echo "border-top:hidden;"; } ?>" valign="top">
        <?= ($no == 1) ? "3" : "" ?>
    </td>
    <td style="border-right:none;border-left:none;<?php if ($no > 1) { echo "border-top:hidden;"; } ?>" valign="top">
        <?= ($no == 1) ? "<strong>Name of Manufacturer & Factory Address -</strong>" : "" ?>
    </td>
    <td style="border-left:none;<?php if ($no > 1) { echo "border-top:hidden;"; } ?>"></td>
    <td colspan="4" style="border-left:none;">
        <?= $company_name ?> <br />
        <?= $sup_row->address ?> <br />
        GST NO : <?= $sup_row->supplier_gstno ?> <br />
        Inv No &amp; Date : <?= $sup_row->suppiler_invoice_no ?> &amp;
        <?php 
        if (!empty($sup_row->suppiler_invoice_date) && $sup_row->suppiler_invoice_date != "1970-01-01" && $sup_row->suppiler_invoice_date != "0000-00-00") {
            echo date('d/m/Y', strtotime($sup_row->suppiler_invoice_date));
        } 
        ?>
        <br/>
        <?= (empty($sup_row->epcg_no)) ? "" : "EPCG NO :" . $sup_row->epcg_no ?>
        <?= (empty($sup_row->epcg_date) || $sup_row->epcg_date == '1970-01-01') ? "" : "& DATE :" . date('d/m/Y', strtotime($sup_row->epcg_date)) ?>
    </td>
</tr>
<?php
        $previous_company_name = $company_name;
        $no++;
    }
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
																
																<td style="border:none"><strong>Name & Designation of the Examining officer Inspection/EO/PO</strong></td>
																<td style="border-bottom:none;border-left:none;border-top:none;">
																	 
																</td>
																<td colspan="4" style="border-bottom:none;border-top:none;border-left:none;"> 
																	SELF SEALING

															   </td>
																 
															 </tr>
														    <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">6</td>
																<td style="border:none"><strong>Name &amp; Designation of the Supervising officer Appraiser/Superintendent</strong></td>
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
																	<strong>b) Total No. of Packages </strong>
																</td>
																<td colspan="4" style="border-bottom:none; border-top:none;" ><?=$Total_pallet?> Packages (<?=$Total_box?>
BOXES)															 </td>
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
																<td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"> <strong>(c)If yes, the number of the seal of the package containing the sample </strong> </td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"><span style="border-top:none;text-align:left">
																  <?=($annexuredata->seal_yesno==1)?"YES":"NO"?>
																</span></td>
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
													    <td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
													    <td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
													    
												      </tr>
													  <tr>
													    <td style="text-align:center;font-weight:bold"> CONTAINER NO </td>
													     
													    <td style="text-align:center;font-weight:bold"> RFID SEAL </td>
													    <td style="text-align:center;font-weight:bold">LINE SEAL </td>
													     <td style="text-align:center;font-weight:bold"> PALLETS NO </td>
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
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														$total_package = $product_data[$i]->total_package;
														
														//$Total_pallets  = $product_data[$i]->total_ori_pallet;
														$net_weight 	= $product_data[$i]->total_ori_net_weight;
														$gross_weight 	= $product_data[$i]->total_ori_gross_weight;
													   $totalnetweight 	+= $product_data[$i]->total_ori_net_weight;
													   $totalgrossweight 	+= $product_data[$i]->total_ori_gross_weight;
													   $total_ann_package = $product_data[$i]->total_ann_package;
															if(empty($sample_str))
															{
																$rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
																$rowcon_no = 1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																		$sample_str .= '<tr>
																						 <td style="text-align:center">
																						 	'.$sample_row->product_size_id.'
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
																		$total_ann_package 		+= $sample_row->no_of_boxes;
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
													<td style="text-align:center" ><?=$product_data[$i]->container_no?></td>
												 
													<td style="text-align:center"  ><?=$product_data[$i]->self_seal_no?></td>
													<td style="text-align:center"  ><?=$product_data[$i]->seal_no?></td>
													<td style="text-align:center" ><?=$product_data[$i]->remark?></td>
													 <td style="text-align:center" ><?=$total_ann_package?></td>
													
												<?php 
													$no=1;
													$Total_box += $product_data[$i]->total_ann_package;
													array_push($con_array,$product_data[$i]->con_entry);
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
													    <td colspan="4" style="text-align:right"><strong>TOTAL</strong></td>
													     
													    
													    <td style="text-align:center;font-weight:bold"> <?=$Total_box; ?></td>
														 
													    
													   
						        </tr>
							  </table>
							   <table width="100%"  cellspacing="0" cellpadding="0" class="pdf_class invoice_edit_cls2" contenteditable="false">		 
									 		                  <?php
if ($company_detail[0]->s_c_type == "Merchant") {
    $no = 1;
    $previous_company_name = "";

    foreach ($export_supplier_data as $sup_row) {
        $company_name = trim($sup_row->company_name);

        // Skip if company name is empty or null
        if (empty($company_name) || $company_name === $previous_company_name) {
            continue;
        }
?>
<tr>
    <td width="5%" style="text-align:center">
        <?php if ($no == 1) { echo '11'; } ?>
    </td>
    <td width="20%"><strong>
        <?php if ($no == 1) { echo 'Self-Sealing Permission No. & Date'; } ?>
    </strong></td>

    <td width="40%">
        <strong><?= $company_name ?></strong>
        <?php if (!empty(trim($sup_row->permission_file_no))) { ?>
            <br><strong>Permission File No:</strong> <?= $sup_row->permission_file_no ?>
        <?php } ?>

        <?php if (!empty(trim($sup_row->permission_no))) { ?>
            <br><strong>Permission No:</strong> <?= $sup_row->permission_no ?>
        <?php } ?>

        <?php
        $valid_date = $sup_row->permission_date;
        if (!empty($valid_date) && $valid_date != "0000-00-00" && $valid_date != "1970-01-01" && strtotime($valid_date)) {
        ?>
            <br><strong>Date:</strong> <?= date('d-m-Y', strtotime($valid_date)) ?>
        <?php } ?>
    </td>
</tr>
<?php
        $previous_company_name = $company_name;
        $no++;
    }
}
?>
										
								   <tr>
									   <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">12</td>
									   <td style="border-bottom:none;border-left:none;border-top:none;" colspan="2">
									    EXPORT UNDER GST CIRCULAR No.: <?=$company_detail[0]->gst_circular_no?>, CUSTOM DATED : <?=$company_detail[0]->date_of_filing?> </td>
								   </tr>
											<tr>
												<td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
												<td style="border:none;"><strong>Net Weight</strong> : <?=number_format($totalnetweight,2,'.','')?> KGS</td>
												<td style="border-bottom:none;border-left:none;border-top:none;">
													<strong>Gross Weight</strong> : <?=number_format($totalgrossweight,2,'.','')?> KGS 
												</td>
												 
								  </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
											  <td colspan="2"  style="border-left:hidden; border-top:none;"> 
											<?php
											if ($invoicedata->igst_status == 1) {
												echo 'THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT): ' . htmlspecialchars($invoicedata->lut_no);
												// Code for when igst_status is 1 (can be left empty or add something if needed)
											} else {
												// Display the message when igst_status is not 1
												
											}
											?>
											  
											  
											  <?php if($invoicedata->remarks!='')
												   {
													?>
                                                <?=nl2br($invoicedata->remarks)?>
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
												<td colspan="3" style="padding-left:20px"> 
												 
												FOR, <?=$company_detail[0]->s_name?>
													<br>
												
														<img 
															src="<?= base_url('upload/' . $company_detail[0]->s_c_sign) ?>" 
															width="120px" 
															alt="Company Signature" 
															onerror="this.onerror=null;this.src='<?= base_url('upload/default_signature.png') ?>';"
														>
												

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
									
									 $_SESSION['export_invoice_no'] = 'CUS DOC'.$invoicedata->export_invoice_no.' '.date('Y',strtotime($invoicedata->invoice_date));
									 $_SESSION['export_content'] 	= $output;
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
function delete_editable(export_invoice_id)
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
			"performa_invoice_id"	: export_invoice_id,
			"performa_invoice_pdf"	: 'export_invoice',
			"invoiceview"	        : 'export_invoice'
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
function editable_packing()
{
	$(".invoice_edit_cls1").attr("contenteditable",true)
	$(".invoice_edit_btn1").hide();
	$(".invoice_update_btn1").show();
}
function editable_annexure()
{
	$(".invoice_edit_cls2").attr("contenteditable",true)
	$(".invoice_edit_btn2").hide();
	$(".invoice_update_btn2").show();
}
function edit_invoice()
{
	 block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoice/invoice_html_update",
       data:
	   {
			"export_invoice_id"	: <?=$invoicedata->export_invoice_id?>, 
			"invoice_html"		: $(".save_invoice_html").html()  
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
       url: root+"exportinvoice/packing_html_update",
       data:
	   {
			"export_invoice_id"	: <?=$invoicedata->export_invoice_id?>, 
			"packing_html"		: $(".save_invoice_html1").html()  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
  }); 
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