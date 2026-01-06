<?php 
 $this->view('lib/header'); 
 
  $export_date 				= date('d/m/Y',strtotime($invoicedata->invoice_date));

 $invoice_date = date('d-m-Y',strtotime($invoicedata->invoice_date));
 $export_ref_date = date('d-m-Y',strtotime($invoicedata->export_date));
 $customer_invoice_no =$invoicedata->customer_invoice_no;
 $export =  ($invoicedata->exporter_detail);
 $export_ref_no =  ($invoicedata->export_ref_no);
 $performa_date 			= date('d/m/Y',strtotime($invoicedata->performa_date));
 
 $buy_order_no = strip_tags($invoicedata->customer_buy_order_no);
 $exporter_email = $invoicedata->e_email;
 $exporter_mobile = $invoicedata->e_mobile;
 $exporter_gstin = $company_detail[0]->s_gst;
 $exporter_state_code = $company_detail[0]->state_code;
 $exporter_pan = $company_detail[0]->s_pan;
 $exporter_iec = $invoicedata->exporter_iec;
 $exporter_aeono				= $company_detail[0]->aeo_no;
 $cin_no		= $company_detail[0]->s_cin;
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
 $indian_ruppe_val 			= $invoicedata->indian_ruppe_val;
 $Exchange_Rate_val	 		= $invoicedata->Exchange_Rate_val;
 $exportinvoice_no 			= $invoicedata->export_invoice_no; 
 $grand_total_usd			= $invoicedata->grand_total;
 $_SESSION['customer_content'] = '';
 $_SESSION['customer_invoice_no'] = '';
 
 // if($invoicedata->Exchange_Rate_val==0)
 // {
	  // if($invoicedata->currency_name=="Euro")
	 // {
	 	// $exchangerate = $userdata->euro;
	 // }
	 // else if($invoicedata->currency_name=="RS")
	 // {
	 	// $exchangerate = "1";
	 // }
	 // else{
	 	// $exchangerate = $userdata->usd; 
	 // }
  
 // }
 // else
 // {
	 // $exchangerate = $invoicedata->Exchange_Rate_val;
 // }
  if($invoicedata->Exchange_Rate_val==0)
 {
	 $exchangerate = $userdata->usd;
 }
 else{
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
									<a href="javascript:void(0)">
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
									 
										<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);" target="_blank" ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									</div>
								</h3>
								
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							  <?php ob_start();
							  
							  							  
$container_net_weight = [];

foreach ($product_data as $row) {
    $key = $row->con_entry;

    if (!isset($container_net_weight[$key])) {
        $container_net_weight[$key] = 0;
    }

    $container_net_weight[$key] +=
        ($row->origanal_boxes * $row->master_weight_per_box);

    if (!empty($row->sample)) {
        foreach ($row->sample as $s) {
            $container_net_weight[$key] += $s->netweight;
        }
    }
}

/* ================= TOTAL NET WEIGHT ================= */
$totalnet_weight = 0;

foreach ($container_net_weight as $wt) {
    $totalnet_weight += $wt;
}


							  	
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
											//$totalnetweight =0;
											$totalgrossweight =0;
										$rowspan = 0;
											for($i=0; $i<count($product_data);$i++)
											{	
												 
												
												if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														
														 // ================= NET WEIGHT =================
													 $net_weight = (
														isset($product_data[$i]->final_updated_net_weight) &&
														$product_data[$i]->final_updated_net_weight !== ''
													)
														? (float) $product_data[$i]->final_updated_net_weight
														: (float) $container_net_weight[$product_data[$i]->con_entry];

													 $totalnetweight += $net_weight;
														 //$totalnetweight 	+= 	$net_weight;
														
														// ================= GROSS WEIGHT =================
													if (
														isset($product_data[$i]->final_updated_gross_weight) &&
														$product_data[$i]->final_updated_gross_weight !== '' &&
														$product_data[$i]->final_updated_gross_weight !== null
													) {

														// ✅ MANUAL OVERRIDE
														$gross_weight = (float) $product_data[$i]->final_updated_gross_weight;

													} else {

														// ✅ AUTO CALCULATION
														if ($product_data[$i]->origanal_pallet > 0) {

															$masterpalletweight = (float) $product_data[$i]->masterpalletweight;
															$total_pallets      = (float) $product_data[$i]->total_ori_pallet;

															$gross_weight = ($total_pallets * $masterpalletweight) + $net_weight;

														}
														else if (
															$product_data[$i]->orginal_no_of_big_pallet > 0 ||
															$product_data[$i]->orginal_no_of_small_pallet > 0
														) {

															$pallet_weight_big =
																$product_data[$i]->orginal_no_of_big_pallet * $product_data[$i]->big_plat_weight;

															$pallet_weight_small =
																$product_data[$i]->orginal_no_of_small_pallet * $product_data[$i]->small_plat_weight;

															$gross_weight = $pallet_weight_big + $pallet_weight_small + $net_weight;

														} else {

															// fallback
															$gross_weight = $net_weight;
														}
													}

													// ✅ ADD TO TOTAL ONCE
													$totalgrossweight += $gross_weight;

															array_push($con_array,$product_data[$i]->con_entry);
													}
												
												
												if(!in_array(trim($product_data[$i]->series_name),$seriesname_array))
												{
													if(!empty($product_data[$i]->series_name))
													{
														array_push($seriesname_array,$product_data[$i]->series_name);
													}
													//array_push($water_array,$product_data[$i]->water_text);
												}
												
											 	if(!in_array(trim($product_data[$i]->series_name.'<br> HSN Code - '.$product_data[$i]->hsnc_code),$series_name_array))
												{
													if(!empty($product_data[$i]->series_name))
													{
														 $rowspan++;
														 
														array_push($series_name_array,$product_data[$i]->series_name.'<br> HSN Code - '.$product_data[$i]->hsnc_code);
													}
													//array_push($water_array,$product_data[$i]->water_text);
												}
											  	 $n = 1;
													$Total_ammount	 += $product_data[$i]->product_amt;
													$Total_amt 	 	 += $product_data[$i]->product_amt;
													
													//$description_goods =  $product_data[$i]->size_type_cm.$product_data[$i]->pcs_per_box.$product_data[$i]->product_rate.$product_data[$i]->model_name;
												   $description_goods =  $product_data[$i]->size_type_cm.$product_data[$i]->pcs_per_box.$product_data[$i]->product_rate.$product_data[$i]->model_name;
												   
												 	if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 $rowspan++;
				 
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->description_goods;
														$product_desc_array[trim($description_goods)]['product_name'] = $product_data[$i]->series_name.', HSN Code - '.$product_data[$i]->hsnc_code;
														$product_desc_array[trim($description_goods)]['size_type_cm'] = $product_data[$i]->size_type_mm;
														$product_desc_array[trim($description_goods)]['product_id'] = $product_data[$i]->product_id;
														$product_desc_array[trim($description_goods)]['model_name'] = $product_data[$i]->client_name;
														
														$product_desc_array[trim($description_goods)]['epcg_no'] =  $product_data[$i]->epcg_no;
														 
														 $product_desc_array[trim($description_goods)]['epcg_date'] = date('d.m.Y',strtotime($product_data[$i]->epcg_date));
														
														
														$product_desc_array[trim($description_goods)]['water_text'] = $product_data[$i]->water_text;
														 $product_desc_array[trim($description_goods)]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
														 $product_desc_array[trim($description_goods)]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
														$product_desc_array[trim($description_goods)]['title_type'] = $product_data[$i]->tiles_type;
														  
														
														$product_desc_array[trim($description_goods)]['no_of_pallet'] = $product_data[$i]->origanal_pallet + $product_data[$i]->make_pallet_no;
														 
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] = $product_data[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] = $product_data[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] = $product_data[$i]->origanal_boxes;
														 
														 $product_desc_array[trim($description_goods)]['sqm'] = ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
														 $product_desc_array[trim($description_goods)]['net_weight'] = $product_data[$i]->packing_net_weight;
														 $product_desc_array[trim($description_goods)]['product_rate'] =$product_data[$i]->product_rate;
														 $product_desc_array[trim($description_goods)]['per'] = $product_data[$i]->per;
														
														 $product_desc_array[trim($description_goods)]['amount'] = $product_data[$i]->product_amt;
														  
													}
													else
													{
														$product_desc_array[trim($description_goods)]['no_of_pallet'] += $product_data[$i]->origanal_pallet + $product_data[$i]->make_pallet_no;
														 
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] += $product_data[$i]->orginal_no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] += $product_data[$i]->orginal_no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] += $product_data[$i]->origanal_boxes;
														$product_desc_array[trim($description_goods)]['sqm'] += ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
														$product_desc_array[trim($description_goods)]['amount'] += $product_data[$i]->product_amt;
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
								
							  
							
								
									
									  		<table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls" contenteditable="false">
											<tr>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												 
										 	</tr>  
											<tr>
												<td colspan="4"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;background-color:#D9D9D9 ; color:#000000;">
												     COMMERCIAL INVOICE
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
												<td colspan="2" style="font-weight:bold;border-bottom:none;background-color:#D9D9D9 ; color:#000000;">Exporter :</td>
												<td style="background-color:#D9D9D9 ; color:#000000;"><span style="font-weight:bold;">Exporter Invoice No. &amp; Date :</span> 
														 
												</td>
												
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Exporter Reference 
												
												</td>
											</tr>
											<tr>
												<td rowspan="6" colspan="2" style="vertical-align:top;border-right:none;border-top:none"> 
												 <?=$export?></td>
												 <td><?=$exportinvoice_no?></td>
												 <td><strong>IEC Code : </strong><?=$exporter_iec?></td>
											</tr>
											<tr>
												 
												 <td ><strong> DT. <?=$export_date?></strong></td>
												 <td> <strong>STATE CODE : </strong><?=$exporter_state_code?></td>
											</tr>
											<tr>
												 
												 <td><strong> PI No. &amp; Date : <?=$export_ref_no?>&amp;
												<?=$performa_date?></strong></td>
												 <td> <strong>GST No : </strong><?=$exporter_gstin?></td>
											</tr>
											
											<tr>
											<td rowspan="2"><strong>Buyer Order No & Date : </strong><?=$buy_order_no?></td>
											<td><strong>PAN No : </strong><?=$exporter_pan?></td>
										</tr>
										<tr>
											<td><strong>AEO No : </strong><?=$exporter_aeono?></td>
										</tr>
										<tr>
											
											<td><strong>LUT (ARN) AD2403250537156 DT:-24/03/2025</strong></td>
											<td><strong>CIN No : </strong><?=$cin_no?></td>
										</tr>

											
												
												  
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
											  <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">  Pre Carriage By</td>
											  <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;"> Place of Receipt by Pre-Carrier </td>
											  <td colspan="2" rowspan="4"  style="vertical-align:top;">
											  <P style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;"> BANK DETAILS </P>
											
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
											    <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Vessel /Flight No. </td>
													
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Port Of Loading : - </td>
												
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
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">
													Port Of Discharge
												</td>
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;"> Final Destination </td>
												<td style="text-align:center;border-bottom:none;background-color:#D9D9D9 ; color:#000000;font-weight:bold;" colspan="2">Terms of Delivery & Payment </td>
											</tr>
											<tr>
												<td >
													 <?=$port_of_discharge?>
												</td>
												<td > 
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
											    <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Country of Origin of Goods  </td>
												
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Country of Final Destination</td>
												
											  </tr>
											  <tr>
											    <td ><?=!empty($country_origin_goods)?$country_origin_goods:'&nbsp;'?> </td>
													
												<td ><?=!empty($country_final_destination)?$country_final_destination:'&nbsp;'?></td>
												
											  </tr>
											  
											 
						      </table>
									<table  width="100%" cellspacing="0" cellpadding="0" style="padding:5px" class="pdf_class invoice_edit_cls" contenteditable="false">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="45%"></td>
										
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
											 	  
										  </tr>                          
											<tr>
												<td rowspan="2" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;">Marks & Nos</td>
												 <td  rowspan="2" colspan="2" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;">DESCRIPTION OF GOODS</td>
												
												<td colspan="2" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;"> 
													QUANTITY
												</td>
												<td colspan="3" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;">
													AMOUNT
												</td>
										 	</tr>
											
											 <tr>
											 	
											 	<td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;">TOTAL BOXES</td>
												<td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;"> TOTAL SQM </td>
												<td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;"> Rate <?=$invoicedata->currency_name?>/SQM 
                                                </td>
												<td colspan="2" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;"> Amount
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
											<!--<td style="text-align:center;font-weight:bold">
											<!--<?=implode(",",$series_name_array)?>
											 </td>
												<td style="text-align:center;font-weight:bold">  </td>
												<td style="text-align:center;font-weight:bold"> 
                                                </td>
												<td style="text-align:center;font-weight:bold"> </td> 
												<td style="text-align:center;font-weight:bold"> </td> 
												<td style="text-align:center;font-weight:bold"> </td> 
												<td style="text-align:center;font-weight:bold">  
												</td>
										 	</tr>-->
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
															<td rowspan="<?=($rowspan > 0)?"1":$rowspan?>" style="text-align:center;border-bottom:hidden">
																 
															 
                                                              <span style="text-align:center;font-weight:bold;"> Total Pallets : <?=($Total_pallet == 0)?"-":$Total_pallet ?><br />
															  Total Boxes : <?=($Total_box == 0)?"-":$Total_box ?>
                                                           
															</span>			
															</td>
                                                        <?php
													  }
													  else if($p > 0)
													  {
														  echo '<td  style="text-align:center;"></td>';
													  }
													  ?>														
															<td style="text-align:center" colspan="2">
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
														 
															 
														 
															
															<!--<td style="text-align:center">
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
																
															</td>-->
															<td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['boxes']?></td>
															<td style="text-align:center"><?=number_format($product_desc_array[$product_desc_array[$p]]['sqm'],2,'.','')?></td>
															<td style="text-align:center"><?=$currency_symbol?>
                                                            <?=number_format($product_desc_array[$product_desc_array[$p]]['product_rate'],2)?></td>
															<td style="text-align:center" colspan="2"><span style="text-align:center" >
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
														 	<td colspan="2" style="font-weight:bold;text-align:center;border-bottom:hidden"  >Sample</td>
													 		
													 		<!--<td style="text-align:center;border-bottom:hidden"></td>-->
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
														 
														<td colspan="2" style="border-right:0.5px solid #333;text-align:center" ><?=$jsondata->product_size_id?> - <?=$jsondata->sample_remarks?> </td>
													 	 
													 	
													 	<!--<td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->no_of_pallet?></td>-->
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
														 
														<td   style="border:none;border-right:0.5px solid #333;height: 31px;" colspan="2"></td>
											
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														
														<td  style="border:none;border-right:0.5px solid #333;" colspan="2" ></td>
														 
														 
										  </tr>
											<?php
											$no_of_row--;
											}
										 	 											
										 	for($row=1;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														 
														<td  style="border:none;border-right:0.5px solid #333;height: 31px;" colspan="2"></td>
													 
													 	<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
														<td  style="border:none;border-right:0.5px solid #333;" ></td>
													
														<td  style="border:none;border-right:0.5px solid #333;" colspan="2"></td>
													  
										  </tr>
											<?php
											$no_of_row--;
											}
											  
										 
										?>										
										 
										 
										 <tr>
											 <td colspan="3" rowspan="2" bgcolor="#D9D9D9" style="font-weight:bold;vertical-align:middle; text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><span style="color:black;"> TOTAL   >>>>>>>>>>>>>>
                    
                      </span></td>
											 
									 	   
									 	   <td  style="font-weight:bold;text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=$Total_box; ?></td>
											<td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center; color: #000;border-top:0.5px solid #333;border-right:0.5px solid #333;"><span style="font-weight:bold;text-align:center">
											  <?=number_format($Total_sqm,2,'.',''); ?>
											</span></td>
											<td rowspan="2" style="font-weight:bold; text-align:center; color:#000;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=($invoicedata->calculation_operator == 2)? $invoicedata->terms_name: 'FOB';?>
&nbsp;Value </td>
										  	<td rowspan="2" colspan="2" style="font-weight:bold;text-align:right;color:black;border-top:0.5px solid #333;"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.',''); ?></td>
										 </tr>
									  	 <tr>
											 
											
												<td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center">BOXES</td>
												<td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center">SQM</td>
										  </tr>
										 <?php
										$Total_ammount =($invoicedata->calculation_operator == 2)?$Total_ammount - $invoicedata->certification_charge:$Total_ammount + $invoicedata->certification_charge;  ?>
										  <tr>
										    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" ><span style="font-weight:bold;vertical-align:top;text-align:center;color:red;">
					 
					  <?php
													if($invoicedata->igst_status==1)

													{

													?>
													<?php

													}

													else 

													{

													?>
                     
												 IGST AMOUNT 
												  <?php }  ?>
												  
												  </span></td>
							<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" > 
						<?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      &nbsp;in INR 
					</td>
                    <td   style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" ><span style="font-weight:bold;vertical-align:top;text-align:center">Exchange Rate <strong> </strong></span></td>
                  
                   
				   <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" colspan="2">
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                      <?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      &nbsp;in
                      <?=$invoicedata->currency_name?>
                      </span>
					</td>
					
												 
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="text-align:center">
											 	  CERTIFICATION
											 	</span></td>
											 	<td colspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                                                <?=($invoicedata->certification_charge > 0)?number_format($invoicedata->certification_charge,2,'.',''):"0.00" ?></td>
										 </tr>
										  <tr>
										  <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" >
													<span style="font-weight:bold;vertical-align:top;text-align:center;color:red;">
													
													
													<?php
													if($invoicedata->igst_status==1)

													{

													?>
													<?php

													}

													else 

													{

													?>
                     
                     <?=number_format($invoicedata->indian_ruppe_after_gst,2,'.','')?>
                      <?php }  ?>
					  
													  </span>
													</td>
											   <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center">
													<?=number_format($invoicedata->indian_ruppe_val,2,'.','')?>
													</td>
													<td    style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center"> 
														<span style="font-weight:bold;vertical-align:top;text-align:center">
													  <?=number_format($invoicedata->Exchange_Rate_val,2)?>
													  </span>
													</td>
													<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" colspan="2">
													<span style="font-weight:bold;vertical-align:top;text-align:center">
													  <?=number_format($invoicedata->grand_total,2,'.','')?>
													  </span>
													</td>
													
													
												 
											 
										    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;">INSURANCE</td>
										    <td colspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                                            <?=($invoicedata->insurance_charge > 0)?number_format($invoicedata->insurance_charge,2,'.',''):"0.00" ?></td>
									      </tr>
										 <?php $Total_ammount =($invoicedata->calculation_operator == 2)?$Total_ammount - $invoicedata->insurance_charge:$Total_ammount + $invoicedata->insurance_charge;  ?>
										 <tr>
											<td   style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center"><span style="font-weight:bold;text-align:center;"><span style="text-align:center;font-weight:bold"> Gross Weight</span></span></td>
											<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center"><span style="text-align:center;font-weight:bold">
											  <?=number_format($totalgrossweight,2)?>
											  KGS</span></td>
											<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" colspan="2"><span style="text-align:center;font-weight:bold"> Net Weight </span></td>
											<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;"><?=number_format($totalnetweight,2)?>
											  KGS</td>
											<td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" >FREIGHT</td>
											<td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
											  <?=($invoicedata->seafright_charge > 0)?number_format($invoicedata->seafright_charge,2,'.',''):"0.00" ?></td>
										  </tr>
										  
										 <?php  $Total_ammount =($invoicedata->calculation_operator == 1)?$Total_ammount + $invoicedata->seafright_charge:$Total_ammount - $invoicedata->seafright_charge; 
										  $Total_ammount += $invoicedata->courier_charge; 
										  $Total_ammount += $invoicedata->bank_charge; 
										 
									 	 ?>
										  <tr>
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5">
													<!--BOND NO. ARN : <?=$invoicedata->aeo_no?>-->
												</td>
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;">DISCOUNT</td>
										    <td colspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                                            <?=($invoicedata->discount > 0)?number_format($invoicedata->discount,2,'.',''):"0.00" ?></td>
										 	     
										 </tr>
										  <?php $Total_ammount = $Total_ammount - $invoicedata->discount; ?>
										  <?php 
										 if(!empty($invoicedata->extra_calc_name))
										 {
										 ?>
										 <tr>
										    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5"> 
												
											</td>
										   <td  style="border-right:0.5px solid #333;text-align:center"> 
												<?=$invoicedata->extra_calc_name?>	(<?=($invoicedata->extra_calc_opt == 1)? 	'+': '-';?>) 
												</td>
											 	<td colspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($invoicedata->extra_calc_amt,2,'.','')?>
												</td>
									      </tr>
										  <?php 
											$Total_ammount =($invoicedata->extra_calc_opt == 2)?$Total_ammount + $invoicedata->extra_calc_amt:$Total_ammount + $invoicedata->extra_calc_amt; 
											 
										  }
										  ?>
										  <tr>
										    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5">AMOUNT IN WORDS <span style="text-align:center">
											<?php
											if($invoicedata->terms_id == 1)
											{
												echo 'FOB';
											}
											else if($invoicedata->terms_id == 3)
											{
												echo 'CIF';
											}
											?>
										      
										    </span></td>
										   <td rowspan="2"  style="border-right:0.5px solid #333;text-align:center;background-color:#D9D9D9 ; color:#000000;"> 
													<?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?> in <?=$invoicedata->currency_name?> 
												</td>
											 	<td rowspan="2" colspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right;background-color:#D9D9D9 ; color:#000000;">
													<?=$currency_symbol.number_format($Total_ammount,2,'.','')?>
												</td>
									      </tr>
										
										  <?php 
										  //$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->discount:$Total_amt - $invoicedata->discount; 
											 
										  ?>
										  <tr>
												<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="5">
												<?php
												if($invoicedata->terms_id == 3)
												{
												?>
													<?=strtoupper(convertamonttousd($invoicedata->before_grand_total,$invoicedata->currency_name))?> ONLY 
												<?php
												}
												else
												{
												?>
													<?=strtoupper(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?> ONLY 
												<?php
												}
												?>
												
												
												</td>
											 	
										 </tr>
										 
									 
										 <tr>
										   <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="5"> 
													<?php if($invoicedata->expremarks!='')
													   {
														?>
													<div  style="font-weight:bold;"><?=nl2br($invoicedata->expremarks)?></div>
													
													<br />
												
													  <?php }?>
												<?php if($invoicedata->rex_no_detail!='')
																							   {
																								?>
																			  <?=$invoicedata->rex_no_detail?>
																			  <?php
																							   }
																							   ?>										   </td>
										   <td height="50" colspan="3" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:right">For
                                             <?=$company_detail[0]->s_name?>
                                           <br />
                                           <br />
                                           <br />
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
							<pagebreak />	
							
								 <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls1" contenteditable="false">
								<tr>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												<td width="25%" style="padding:0px;border:none;"></td>
												 
										 	</tr>  
											<tr>
												<td colspan="4"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;background-color:#D9D9D9 ; color:#000000;">
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
												<td colspan="2" style="font-weight:bold;border-bottom:none;background-color:#D9D9D9 ; color:#000000;">Exporter :</td>
												<td style="background-color:#D9D9D9 ; color:#000000;"><span style="font-weight:bold;">Exporter Invoice No. &amp; Date :</span> 
														 
												</td>
												
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Exporter Reference 
												
												</td>
											</tr>
											<tr>
												<td rowspan="6" colspan="2" style="vertical-align:top;border-right:none;border-top:none"> 
												 <?=$export?></td>
												 <td><?=$exportinvoice_no?></td>
												 <td><strong>IEC Code : </strong><?=$exporter_iec?></td>
											</tr>
											<tr>
												 
												 <td ><strong> DT. <?=$export_date?></strong></td>
												 <td> <strong>STATE CODE : </strong><?=$exporter_state_code?></td>
											</tr>
											<tr>
												 
												 <td><strong> PI No. &amp; Date : <?=$export_ref_no?>&amp;
												<?=$performa_date?></strong></td>
												 <td> <strong>GST No : </strong><?=$exporter_gstin?></td>
											</tr>
											
												<tr>
											<td rowspan="2"><strong>Buyer Order No & Date : </strong><?=$buy_order_no?></td>
											<td><strong>PAN No : </strong><?=$exporter_pan?></td>
										</tr>
										<tr>
											<td><strong>AEO No : </strong><?=$exporter_aeono?></td>
										</tr>
										<tr>
											
											<td><strong>LUT (ARN) AD2403250537156 DT:-24/03/2025</strong></td>
											<td><strong>CIN No : </strong><?=$cin_no?></td>
										</tr>

												
												  
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
											  <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">  Pre Carriage By</td>
											  <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;"> Place of Receipt by Pre-Carrier </td>
											  <td colspan="2" rowspan="4"  style="vertical-align:top;">
											  <P style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;"> BANK DETAILS </P>
											
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
											    <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Vessel /Flight No. </td>
													
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Port Of Loading : - </td>
												
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
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">
													Port Of Discharge
												</td>
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;"> Final Destination </td>
												<td style="text-align:center;border-bottom:none;background-color:#D9D9D9 ; color:#000000;font-weight:bold;" colspan="2">Terms of Delivery & Payment </td>
											</tr>
											<tr>
												<td >
													 <?=$port_of_discharge?>
												</td>
												<td > 
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
											    <td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Country of Origin of Goods  </td>
												
												<td style="background-color:#D9D9D9 ; color:#000000;font-weight:bold;">Country of Final Destination</td>
												
											  </tr>
											  <tr>
											    <td ><?=!empty($country_origin_goods)?$country_origin_goods:'&nbsp;'?> </td>
													
												<td ><?=!empty($country_final_destination)?$country_final_destination:'&nbsp;'?></td>
												
											  </tr>
											  
							  
							   </table>
							<!--<table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class invoice_edit_cls1" contenteditable="false">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="17%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
											 	<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
											 	<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
											</tr>                          
											 
											 <tr>
											   <td style="text-align:center;font-weight:bold">SHIPPING MARKS &amp; NOS.</td>
											   <td colspan="2" style="text-align:center;font-weight:bold">DESCRIPTION OF GOODS</td>
												<td style="text-align:center;font-weight:bold">PCS PER BOX</td>
												<td style="text-align:center;font-weight:bold">SQM PER BOX</td>
												<td style="text-align:center;font-weight:bold">PALLETS</td>
												<td style="text-align:center;font-weight:bold">BOXES</td>
												<td style="text-align:center;font-weight:bold"> TOTAL SQUARE METER </td>
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
															 
															  <?php
																if(!empty($invoicedata->container_twenty))
																{
																	echo $invoicedata->container_twenty.' X 20 <br>FCL(s)';
															 	}
																if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
																{
																	echo ',';
																}
																if(!empty($invoicedata->container_forty))
																{
																	echo $invoicedata->container_forty.' X 40 <br> FCL(s)';
																}
																
																						
																?>
                                                               <br />
																-----------<br />
																	TOTAL<br />
																<?=($Total_pallet == 0)?" ":$Total_pallet.'<span style="text-align:center;font-weight:bold"> PALLETS</span>' ?>
 
                                                          
														<br />
														<span style="text-align:center;"><?=$Total_box?></span>
 
                                                            <strong> BOXES 	</strong>				
															</td>
                                                        <?php
													  }
													  ?>														
															<td style="text-align:center" colspan="2">
																<?php
														 
																if(!empty($product_desc_array[$product_desc_array[$p]]['size_type_mm']))
																{
																?>															
																<?=$product_desc_array[$product_desc_array[$p]]['product_name']?>
                                                              <br />
																Tiles Size :
																	<?=$product_desc_array[$product_desc_array[$p]]['size_type_mm']?>

																 <?=!empty($product_desc_array[$product_desc_array[$p]]['water_text'])?'<br>'.$product_desc_array[$product_desc_array[$p]]['water_text']:""?>
															<?php
																}
																else
																{
																	echo $product_desc_array[$product_desc_array[$p]]['description_goods'];
																}
															 	if(!empty($product_desc_array[$product_desc_array[$p]]['epcg_no']))
																{
																	echo '<br />    EPCG NO:'.$product_desc_array[$product_desc_array[$p]]['epcg_no'].' DATE:'.date('d.m.Y',strtotime($product_desc_array[$product_desc_array[$p]]['epcg_date']));
																}
																	?>
																</td>
														 
															<td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['pcs_per_box']?></td>
															<td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['sqm_per_box']?></td>
															<?php 
															if(!empty($product_desc_array[$product_desc_array[$p]]['export_make_pallet_no']))
															{
															?>
															<td style="text-align:center" rowspan="<?=!empty($product_desc_array[$product_desc_array[$p]]['export_rowspan'])?$product_desc_array[$product_desc_array[$p]]['export_rowspan']:""?>">
															<?php
																if($product_desc_array[$product_desc_array[$p]]['no_of_pallet'] > 0)
																{
																	echo $product_desc_array[$product_desc_array[$p]]['no_of_pallet'];
																}
																else if($product_desc_array[$product_desc_array[$p]]['no_of_big_pallet'] > 0 || $product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'] > 0)
																{
																	echo $product_desc_array[$product_desc_array[$p]]['no_of_big_pallet']."<br>".$product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'];
																}
																else 
																{
																	echo "-";
																}
															}
															else if(empty($product_desc_array[$product_desc_array[$p]]['export_half_pallet']))
														 	{
																 
																?>
																<td style="text-align:center" rowspan="<?=!empty($product_desc_array[$product_desc_array[$p]]['export_rowspan'])?$product_desc_array[$product_desc_array[$p]]['export_rowspan']:""?>">
																<?php
																if($product_desc_array[$product_desc_array[$p]]['no_of_pallet'] > 0)
																{
																	echo $product_desc_array[$product_desc_array[$p]]['no_of_pallet'];
																}
																else if($product_desc_array[$product_desc_array[$p]]['no_of_big_pallet'] > 0 || $product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'] > 0)
																{
																	echo $product_desc_array[$product_desc_array[$p]]['no_of_big_pallet']."<br>".$product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'];
																}
																else 
																{
																	echo "-";
																}
															}
															?>
															</td>
															<td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['boxes']?></td>
															<td style="text-align:center"><?=number_format($product_desc_array[$product_desc_array[$p]]['sqm'],2,'.','')?></td>
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
															 
															<td style="font-weight:bold;text-align:center;border-bottom:hidden" colspan="2">Sample</td>
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
														<td style="text-align:center">&nbsp;</td>
														 
														<td style="text-align:center" colspan="2"><?=$jsondata->product_size_id?> - <?=$jsondata->sample_remarks?> </td>
													 	<td  style="text-align:center" > - </td>
													 	<td  style="text-align:center" > - </td>
												 	  <td  style="text-align:center"><?=$jsondata->no_of_pallet?></td>
													 	<td  style="text-align:center"><?=$jsondata->no_of_boxes?></td>
													 		<td  style="text-align:center"><?=$jsondata->sqm?></td>
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
												 
											<?php
											$no_of_row--;
											}
										 	 											
										 	for($row=0;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														 
														<td colspan="2" style="border:none;border-right:0.5px solid #333;height: 31px;" ></td>
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
											<td colspan="5" style="font-weight:bold;vertical-align:top;">&nbsp;</td>
											<td  style="font-weight:bold;text-align:center"><?=($Total_pallet == 0)?"-":$Total_pallet; ?></td>
									 	   <td  style="font-weight:bold;text-align:center"><?=$Total_box; ?></td>
											<td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center; color: #000;"><span style="font-weight:bold;text-align:center">
											  <?=number_format($Total_sqm,2,'.',''); ?>
											</span></td>
										 </tr>
									  	 <tr>
												<td colspan="5" bgcolor="#000000"  style="vertical-align:top; color: #FFF;"> THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT)  :
                                                    <?=$company_detail[0]->s_lutno?>
                                                </td>
												<td style="text-align:center">
													<span style="text-align:center;font-weight:bold">PALLETS</span>&nbsp;
												</td>
											 	<td style="text-align:center;font-weight:bold">BOXES</td>
												<td style="text-align:center;font-weight:bold">SQM</td>
										 </tr>
										 <?php
											$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->certification_charge:$Total_amt + $invoicedata->certification_charge;
											
											$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->insurance_charge:$Total_amt + $invoicedata->insurance_charge;
											 
											$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->seafright_charge:$Total_amt + $invoicedata->seafright_charge; 
										 
											$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->discount:$Total_amt - $invoicedata->discount; 
										  ?>
						      </table>  -->
							<table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class invoice_edit_cls1" contenteditable="false">
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
									 
									<td colspan="8" style="text-align:center;font-weight:bold"> Description Of Goods
									<br>
									 <?=implode(",",$series_name_array)?>
									</td>
									
									
									 
						      </tr>
							<tr>
    <td width="4%" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">SR NO.</td>
    <td width="10%" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">CONTAINER NO.</td>
    <td width="10%" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">RFID SEAL NO.</td>
    <td  width="10%" style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">LINE SEAL NO.</td>
    <td  style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">SIZE (CM)</td>
	<td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">PALLETS</td>
    <td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">BOXES</td>
    <td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">SQM</td>
    
    <td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">NET WEIGHT (Kgs)</td>
    <td style="text-align:center;font-weight:bold;background-color:#D9D9D9 ; color:#000000;font-weight:bold;">GROSS WEIGHT (Kgs)</td>
</tr>

<?php

$container_net_weight = [];

foreach ($product_data as $row) {
    $key = $row->con_entry;

    if (!isset($container_net_weight[$key])) {
        $container_net_weight[$key] = 0;
    }

    $container_net_weight[$key] +=
        ($row->origanal_boxes * $row->master_weight_per_box);

    if (!empty($row->sample)) {
        foreach ($row->sample as $s) {
            $container_net_weight[$key] += $s->netweight;
        }
    }
}

/* ================= TOTAL NET WEIGHT ================= */
$totalnet_weight = 0;

foreach ($container_net_weight as $wt) {
    $totalnet_weight += $wt;
}



$Grand_Total_pallet = 0;
$Total_pallets = 0;
$Total_sqm = 0;
$Total_box = 0;
$cntnet_weight = 0;
$Total_ammount = 0;
$setcontainer = 0;
$packingtrn_array = array();
$con_entry = 1;
$con_array = array();
$conarray = array();
$sizearray = array();
$no_of_row = 15;
$totalnetweight = 0;
$totalgrossweight = 0;
$container_twenty = intval($invoicedata->container_twenty);
$container_forty = $container_twenty + intval($invoicedata->container_forty);
$no = 1;
$sr_no = 1; // ✅ sequence number counter added

for ($i = 0; $i < count($product_data); $i++) {

    $total_pallets = floatval($product_data[$i]->total_ori_pallet);
    $Total_pallets = floatval($product_data[$i]->total_ori_pallet);
    $sample_str = '';

    if (!in_array($product_data[$i]->con_entry, $con_array)) {
        $rowcon_no = ($product_data[$i]->rowspan_no > 1) ? $product_data[$i]->rowspan_no : '';
        $total_package = $product_data[$i]->total_package;
        $totalpackage = $product_data[$i]->total_package;

     // ================= NET WEIGHT =================
     $net_weight = (
		isset($product_data[$i]->final_updated_net_weight) &&
		$product_data[$i]->final_updated_net_weight !== ''
	)
		? (float) $product_data[$i]->final_updated_net_weight
		: (float) $container_net_weight[$product_data[$i]->con_entry];

     
		$totalnetweight += $net_weight;
		
		// ================= GROSS WEIGHT =================
	if (
		isset($product_data[$i]->final_updated_gross_weight) &&
		$product_data[$i]->final_updated_gross_weight !== '' &&
		$product_data[$i]->final_updated_gross_weight !== null
	) {

		// ✅ MANUAL OVERRIDE
		$gross_weight = (float) $product_data[$i]->final_updated_gross_weight;

	} else {

		// ✅ AUTO CALCULATION
		if ($product_data[$i]->origanal_pallet > 0) {

			$masterpalletweight = (float) $product_data[$i]->masterpalletweight;
			$total_pallets      = (float) $product_data[$i]->total_ori_pallet;

			$gross_weight = ($total_pallets * $masterpalletweight) + $net_weight;

		}
		else if (
			$product_data[$i]->orginal_no_of_big_pallet > 0 ||
			$product_data[$i]->orginal_no_of_small_pallet > 0
		) {

			$pallet_weight_big =
				$product_data[$i]->orginal_no_of_big_pallet * $product_data[$i]->big_plat_weight;

			$pallet_weight_small =
				$product_data[$i]->orginal_no_of_small_pallet * $product_data[$i]->small_plat_weight;

			$gross_weight = $pallet_weight_big + $pallet_weight_small + $net_weight;

		} else {

			// fallback
			$gross_weight = $net_weight;
		}
	}

	// ✅ ADD TO TOTAL ONCE
	$totalgrossweight += $gross_weight;


        if (empty($sample_str)) {
            $rowcon_no = (!empty($rowcon_no)) ? $rowcon_no : 1;
            foreach ($product_data[$i]->sample as $sample_row) {
                $rowcon_no++;
                $sample_des = !empty($sample_row->sample_remarks) ? $sample_row->sample_remarks : $sample_row->size_type_mm;
                $sample_str .= '<tr>
                                    <td  style="text-align:center">
                                        ' . $sample_row->product_size_id . ' - ' . $sample_row->sample_remarks . '
                                    </td>
                                    <td style="text-align:center">' . $sample_row->no_of_boxes . '</td>
                                    <td style="text-align:center">' . $sample_row->no_of_pallet . '</td>
                                    <td style="text-align:center">' . $sample_row->sqm . '</td>
                                </tr>';

                $Grand_Total_pallet += floatval($sample_row->no_of_pallet);
                $Total_sqm += $sample_row->sqm;
                $Total_box += $sample_row->no_of_boxes;
                $total_package += $sample_row->no_of_boxes;
                $Total_ammount += $sample_row->sample_amout;
                $totalnetweight += $sample_row->netweight;
                $totalgrossweight += $sample_row->grossweight;
                $net_weight += $sample_row->netweight;
                $gross_weight += $sample_row->grossweight;
                $cntnet_weight = $sample_row->netweight;
                $no_of_row--;
            }
        }

        ?>
        <tr>
            <!-- ✅ Added SR NO -->
            <td style="text-align:center" rowspan="<?= $rowcon_no ?>"><?= $sr_no ?></td>

            <td style="text-align:center" rowspan="<?= $rowcon_no ?>"><?= $product_data[$i]->container_no ?></td>
            <td style="text-align:center" rowspan="<?= $rowcon_no ?>"><?= $product_data[$i]->self_seal_no ?></td>
            <td style="text-align:center" rowspan="<?= $rowcon_no ?>"><?= $product_data[$i]->seal_no ?></td>
         <?php
        $sr_no++;
        $no = 1;
        $con_array[] = $product_data[$i]->con_entry;
    }

    if ($no > 1) {
        echo "<tr>";
    }

    if (!empty($product_data[$i]->product_id)) {
        echo '<td  style="text-align:center">' . $product_data[$i]->size_type_mm . '</td>';
    } else {
        echo "<td style='text-align:center'>" . $product_data[$i]->description_goods . "</td>";
    }
    ?>

   
    <?php
   

    if (!empty($product_data[$i]->pallet_ids) || $product_data[$i]->make_pallet_no == 1) {
        if (!empty($product_data[$i]->pallet_ids)) {
            $pallet_ids = explode(",", $product_data[$i]->pallet_row);
            echo '<td style="text-align:center" class="text-center" rowspan="' . count($pallet_ids) . '">' . $product_data[$i]->make_pallet_no . '</td>';
            $Grand_Total_pallet += $product_data[$i]->make_pallet_no;
        }
    }
    if (!empty($product_data[$i]->export_make_pallet_no)) {
        $export_rowspan = explode(",", $product_data[$i]->export_make_pallet_no);
        echo '<td style="text-align:center" class="text-center" rowspan="' . count($export_rowspan) . '">' . $product_data[$i]->export_half_pallet . '</td>';
        $Grand_Total_pallet += $product_data[$i]->export_half_pallet;
    } else if (empty($product_data[$i]->pallet_row) && empty($product_data[$i]->export_half_pallet)) {
        echo '<td style="text-align:center">';
        if ($product_data[$i]->origanal_pallet > 0) {
            echo $product_data[$i]->origanal_pallet;
            $Grand_Total_pallet += $product_data[$i]->origanal_pallet;
        } else if ($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0) {
            echo $product_data[$i]->orginal_no_of_big_pallet . "<br>" . $product_data[$i]->orginal_no_of_small_pallet;
            $Grand_Total_pallet += $product_data[$i]->no_of_big_pallet;
            $Grand_Total_pallet += $product_data[$i]->orginal_no_of_small_pallet;
        } else {
            echo "-";
        }
        echo "</td>";
    }
	 ?>
		 <td style="text-align:center" ><?=$product_data[$i]->origanal_boxes?>
		<!-- <br>
		
		 <?=$product_data[$i]->master_weight_per_box?> <br>
		
		 <?=$product_data[$i]->masterpalletweight?>
		 <br>
		thickness
		
		 <?=$product_data[$i]->thickness?> 
		 <br>
		packing
		
		 <?=$product_data[$i]->product_packing_name?>-->
		 </td>
		 <td style="text-align:center" ><?=number_format((($packing->product_id == 0)?$product_data[$i]->origanal_sqm:$product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box),2,'.','')?></td>
  
		 <?php
		 $Total_box += $product_data[$i]->origanal_boxes;
		 
    if ($no > 1) {
        echo "</tr>";
    }

    if (!in_array($product_data[$i]->con_entry, $conarray)) {
        ?>
        <td style="text-align:center" rowspan="<?= $rowcon_no ?>"><?= number_format($net_weight, 2, '.', '') ?></td>
        <td style="text-align:center" rowspan="<?= $rowcon_no ?>"><?= number_format($gross_weight, 2, '.', '') ?></td>
        </tr>
        <?php
        echo $sample_str;
		$conarray[] = $product_data[$i]->con_entry;
    }

    $Total_sqm += ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
    $Total_ammount += $product_data[$i]->product_amt;
    $no++;
}

$no_of_row = 1;
for ($row = $no_of_row; $row > 0; $row--) {
    ?>
    <tr>
        <td style="text-align:center;border-right:none;border-bottom:none;border-top:none">&nbsp;</td>
        <td style="text-align:center;border:none">&nbsp;</td>
        <td style="text-align:center;border:none">&nbsp;</td>
        <td colspan="2" style="text-align:center;border:none">&nbsp;</td>
        <td style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
        <td style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
        <td style="text-align:center;border:none">&nbsp;</td>
        <td style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
        <td style="text-align:center;border-left:none;border-bottom:none;border-top:none">&nbsp;</td>
    </tr>
    <?php
    $no_of_row--;
}
?>

							  <tr>
							    <td colspan="5" style="text-align:right"><strong>TOTAL</strong></td>
							    
							   
							    <td style="text-align:center"><span style="font-weight:bold;text-align:center"><?=($Grand_Total_pallet == 0)?"-":$Grand_Total_pallet; ?> </span> </td>
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
							    <td colspan="10" valign="top" style="text-align:left"> <span style="vertical-align:top;">
							      <?php if($invoicedata->expremarks!='')
												   {
													?>
							    <div style="font-weight:bold;">  <?=nl2br($invoicedata->expremarks)?></div>
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
							      </span></td>
						      </tr>
							  <tr>
							    <td colspan="5" rowspan="2" valign="top" style="text-align:left"><strong><u>Declaration</u></strong>: <br />
							      We declared that this packing list shows the actual quantity of the goods described &amp; that all particulars are true and correct or stuffed in the container(s).					
							      </td>
							    <td height="80" colspan="5" style="text-align:left;border-bottom:hidden" valign="top"><span style="border-bottom:hidden">For
							      <?=$company_detail[0]->s_name?>
							      </span></td>
						      </tr>
							  <tr>
							    <td colspan="5" style="text-align:left" valign="top"><?=nl2br($company_detail[0]->authorised_signatury)?></td>
						      </tr>
							  </table>
							
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
 function Export() {
     if ("ActiveXObject" in window) {
        alert("This is Internet Explorer!");
    } else {
		
        var cache = {};
        this.tmpl = function tmpl(str, data) {
            var fn = !/\W/.test(str) ? cache[str] = cache[str] || tmpl(document.getElementById(str).innerHTML) :
            new Function("obj",
                         "var p=[],print=function(){p.push.apply(p,arguments);};" +
                         "with(obj){p.push('" +
                         str.replace(/[\r\t\n]/g, " ")
                         .split("{{").join("\t")
                         .replace(/((^|}})[^\t]*)'/g, "$1\r")
                         .replace(/\t=(.*?)}}/g, "',$1,'")
                         .split("\t").join("');")
                         .split("}}").join("p.push('")
                         .split("\r").join("\\'") + "');}return p.join('');");
            return data ? fn(data) : fn;
        };
        var tableToExcel = (function () {
            var uri = 'data:application/vnd.ms-excel;base64,',
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{{=worksheet}}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>{{for(var i=0; i<tables.length;i++){ }}<table>{{=tables[i]}}</table>{{ } }}</body></html>',
                base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)));
                },
                format = function (s, c) {
                    return s.replace(/{(\w+)}/g, function (m, p) {
                        return c[p];
                    });
                };
            return function (tableList, name) {
                if (!tableList.length > 0 && !tableList[0].nodeType) table = document.getElementById(table);
                var tables = [];
                for (var i = 0; i < tableList.length; i++) {
                    tables.push(tableList[i].innerHTML);
                }
                var ctx = {
                    worksheet: name || 'Worksheet',
                    tables: tables
                };
                window.location.href = uri + base64(tmpl(template, ctx));
            };
        })();
        tableToExcel(document.getElementsByClassName("main_table"), "Performa Invoice");
    }
  }
</script>

