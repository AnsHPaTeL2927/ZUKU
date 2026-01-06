<?php 
 $this->view('lib/header'); 
  
 $export_date 				= date('d/m/Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no 			= $invoicedata->export_invoice_no;
 $export 					= ($invoicedata->exporter_detail);
 $export_ref_no 			= ($invoicedata->export_ref_no);
 $performa_date 			= date('d/m/Y',strtotime($invoicedata->performa_date));
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
 if($invoicedata->Exchange_Rate_val==0)
 {
	 $exchangerate = $userdata->usd;
 }
 else{
	 $exchangerate = $invoicedata->Exchange_Rate_val;
 }
 $_SESSION['export_content'] = '';
 $_SESSION['export_invoice_no'] = '';
 $currency_symbol = ($invoicedata->currency_name=="Euro")?"&euro;":"$";
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
							<div class=" panel-default">
							  <?php ob_start();?>
												 <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" colspan="6">
														 
												</td>
										 	</tr>  
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="24%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="21%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												 
											</tr>  
											<tr>
												<td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;">
											      CUSTOMS INVOICE
												</td>
												</tr>
											<tr>
												<td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;">
												<?php
													if($invoicedata->igst_status==1)
													{
													?>
													"SUPPLY MEANT FOR EXPORT UNDER BOND & LUT-LETTER OF UNDERTAKING WITHOUT PAYMENT OF INTEGRATED TAX"
													<?php }
													else{?>
														"SUPPLY MEANT FOR EXPORT UNDER BOND & LUT-LETTER OF UNDERTAKING WITH PAYMENT OF INTEGRATED TAX"
													<?php }?>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold"> Exporter:</td>
												<td colspan="4"> 
														 
												</td>
											</tr>
											<tr>
												<td colspan="2" rowspan="3" style="vertical-align:top;border-right:none"> 
														<?=$export?><br>
														<strong>GSTIN NO : </strong><?=$exporter_gstin?> <strong> PAN NO :</strong> <?=$exporter_pan?><br>
												 <strong>IEC NO : </strong><?=$exporter_iec?> <strong> STATE CODE :</strong>  <?=$company_detail[0]->state_code?> <br />
                                                 <strong>ARN : </strong>  <?=$company_detail[0]->s_lutno?>  </td>
											    <td   style="font-weight:bold">   Exporter Invoice No. & Date :</td>
												<td>
														<font color="#FF0000"><?=$exportinvoice_no?></font>
												</td>
												<td colspan="2"> 
														<font color="#FF0000"><?=$export_date?></font>
												</td>
											</tr>
											 
											<tr>
												<td  style="font-weight:bold">
													Profoma Invoice No. & Date :
												</td>
												<td colspan="3"> 
														<font color="#FF0000"><?=$export_ref_no?> &amp; <?=$performa_date?> </font>
												 
											  </td>
											</tr>
											<tr>
												<td  style="font-weight:bold">
													  Buyer's order No. & Date:
												</td>
												<td colspan="3"> 
														<font color="#FF0000"><?=$buy_order_no?>  </font>
											  </td>
											</tr>
											<tr>
												<td height="85" colspan="2" valign="top">  <strong>Consignee : </strong><br>
												TO THE ORDER
												</td>
												 
												<td  style="font-weight:bold;vertical-align:top;">
													Notify Party Address : ( Delivery Address)	

											  </td>
												<td colspan="3"   style="vertical-align:top"> 
														 
													 <?=$buyer_other_consign?>
												</td>
												 
												 
											</tr>
											  <tr>
												<td style="font-weight:bold">  Pre Carriage By</td>
												<td style="font-weight:bold"> Place of Receipt by Pre-Carrier </td>
												<td style="font-weight:bold"> Country of Origin of Goods :</td>
												<td style="font-weight:bold" colspan="3"> Country of Final Destination of Goods :
												</td>
											 </tr>
											 
											 <tr>
												<td>
													<?=$pre_carriage_by?>
												</td>
												<td>
													<?=$place_of_receipt?>
												</td>
												<td >
													<?=$country_origin_goods?>
												</td>
												<td colspan="3">
														<?=$country_final_destination?>
												</td>
											</tr>
											  <tr>
												<td style="font-weight:bold">  Vessel / Flight Name & No </td>
												<td style="font-weight:bold">  Port Of Loading	 </td>
												 <td colspan=""  style="font-weight:bold">Marks & Nos </td>
												 <td style="font-weight:bold" colspan="3">Terms Of Delivery</td>
												
											  </tr>
											  <tr>
													
												<td>
													<?=$flight_name_no?>
												</td>
												<td>
													<?=$export_port_loading?>
												</td>
												<td><font color="#FF0000">
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
									?> </font>
												</td>
													 <td colspan="3"> 
														<?=$invoicedata->terms_name?> - <?=$export_terms_of_delivery?>
													</td>
											</tr> 
											<tr>
												<td style="font-weight:bold">  Port Of Discharge</td>
												<td style="font-weight:bold" >  Place of Delivery</td>
												 <td style="font-weight:bold">  Terms of  Payment:</td>
												 <td colspan="3" >
												 	<?=$export_payment_terms?>
												 </td>
											 </tr>
											 <tr>
											   <td style="vertical-align:top"><font color="#FF0000"><?=$port_of_discharge?></font></td>
											   <td style="vertical-align:top"><font color="#FF0000"><?=$final_destination?></font></td>
											   <td style="font-weight:bold" valign="top">Bank Details</td>
											   <td colspan="3" rowspan="2" align="left" valign="top" ><?=$bank_detail?>											     &nbsp;</td>
											   </tr>
											
								</table>
										
										<?php 
										 
										if($direct_invoice==1)
										{
										?>
											<table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class">
												<tr>
													<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
													<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												</tr>                          
												<tr>
													<td rowspan="3" style="text-align:center;font-weight:bold">
														Sr No
													</td>
													<td style="text-align:center;font-weight:bold">
														Marks & NOS
													</td>
													<td  style="text-align:center;font-weight:bold" colspan="2">
														DESCRIPTION OF GOODS
													</td>
													<td colspan="4" style="text-align:center;font-weight:bold"> 
														QUANTITY
													</td>
													<td colspan="2" style="text-align:center;font-weight:bold">
														AMOUNT
													</td>
												</tr>
											<?php 
											$Total_sqm 			= 0;
											$Total_box 			= 0;
											$Total_pallet 		= 0;
											$Total_ammount 		= 0;
											$Total_amt 		 	= 0;
											$total_container 	= 0;
											$button_check_array = array();
											$stringcolor		= array();
											$totalnetweight=0;
											$totalgrossweight=0;
										 	$product_desc_array = array();
										 	$series_name_array 	= array();
										 	$water_array 		= array();
											$no_of_row = 15;
											 
											for($i=0; $i<count($product_data);$i++)
											{	
												$Total_sqm 			+= $product_data[$i]->total_no_of_sqm;
												$Total_box 			+= $product_data[$i]->total_no_of_boxes;
												$Total_pallet 		+= $product_data[$i]->total_no_of_pallet;
												$netweight_array = explode(",",$product_data[$i]->updated_netweight);
												$grossweight_array = explode(",",$product_data[$i]->updated_grossweight);
												for($n=0;$n<count($netweight_array);$n++)
												{
													$totalnetweight += $netweight_array[$n];
												}
												for($g=0;$g<count($grossweight_array);$g++)
												{
													$totalgrossweight += $grossweight_array[$g];
												}
												if(!in_array(trim($product_data[$i]->series_name),$series_name_array))
												{
													array_push($series_name_array,$product_data[$i]->series_name);
													array_push($water_array,$product_data[$i]->water_text);
												}
												foreach($product_data[$i]->packing  as $packing_row)
												{
													
													$Total_ammount	 += $packing_row->product_amt;
													$Total_amt 	 	 += $packing_row->product_amt;
													
													$description_goods =  $product_data[$i]->description_goods.$product_data[$i]->pcs_per_box;
												 	if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->description_goods;
														$product_desc_array[trim($description_goods)]['product_name'] = ($product_data[$i]->series_name);
														$product_desc_array[trim($description_goods)]['size_type_cm'] = $product_data[$i]->size_type_cm;
														 $product_desc_array[trim($description_goods)]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
														 $product_desc_array[trim($description_goods)]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
														$product_desc_array[trim($description_goods)]['title_type'] = $product_data[$i]->tiles_type;
														  
														$product_desc_array[trim($description_goods)]['no_of_pallet'] = $packing_row->no_of_pallet;
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] = $packing_row->no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] = $packing_row->no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] = $packing_row->no_of_boxes;
														 
														 $product_desc_array[trim($description_goods)]['sqm'] = $packing_row->no_of_sqm;
														 $product_desc_array[trim($description_goods)]['net_weight'] = $packing_row->packing_net_weight;
														 $product_desc_array[trim($description_goods)]['product_rate'] = $packing_row->product_rate;
														 $product_desc_array[trim($description_goods)]['per'] = $packing_row->per;
														
														 $product_desc_array[trim($description_goods)]['amount'] =$packing_row->product_amt;
														  
													}
													else
													{
														$product_desc_array[trim($description_goods)]['no_of_pallet'] += $packing_row->no_of_pallet;
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] += $packing_row->no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] += $packing_row->no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] +=$packing_row->no_of_boxes;
														$product_desc_array[trim($description_goods)]['sqm'] +=$packing_row->no_of_sqm;
														$product_desc_array[trim($description_goods)]['amount'] += $packing_row->product_amt;
														 $product_desc_array[trim($description_goods)]['net_weight'] = $packing_row->packing_net_weight;
													}
												}
											  	 $n = 1;
											}
											foreach ($sample_data as $jsondata)
											{
												$Total_sqm 			+= $jsondata->sqm;
												$Total_box 			+= $jsondata->no_of_boxes;
												$Total_pallet 		+= $jsondata->no_of_pallet;
												$totalnetweight 	+= $jsondata->netweight;
												$totalgrossweight 	+= $jsondata->grossweight;
											}
											?>
											 <tr>
												<td style="text-align:center;font-weight:bold" rowspan="2">
													 THERE ARE <?=$Total_box?> BOXES PACKED IN <?=$Total_pallet?> PALLETS
												</td> 
												<td   style="text-align:center;font-weight:bold" colspan="2">
													<?php
													 
													$no=1;
													for($ser=0;$ser<count($series_name_array);$ser++)
													{
														if(!empty($series_name_array[$ser]))
														{
															echo $series_name_array[$ser].'<br>';
														}
													}
											 	 ?>
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold"> 
													PALLETS
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													BOXES
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													SQM
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													WEIGHT IN KGS
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													RATE PER SQM
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													AMOUNT IN <?=$invoicedata->currency_name?>
												</td>
										 	</tr>
										 	<tr>
												 
												
												 
												<td style="text-align:center;font-weight:bold">
													 DESIGN NAME
												</td>
												<td style="text-align:center;font-weight:bold">
													 GRADE 
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
															<td style="text-align:center"> <?=$no?></td>
															<td style="text-align:center" colspan="2">
																<?=$product_desc_array[$product_desc_array[$p]]['product_name']?>
															</td>
														 
															<td style="text-align:center">
															PRE - 1
															</td>
															<td style="text-align:center">
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
																?>
															</td>
															<td style="text-align:center">
																   <?=$product_desc_array[$product_desc_array[$p]]['boxes']?>
															</td>
															<td style="text-align:center">
																 <?=number_format($product_desc_array[$product_desc_array[$p]]['sqm'],2,'.','')?>
															</td>
															<td style="text-align:center">
																<?=$product_desc_array[$product_desc_array[$p]]['net_weight']?>
															</td>
															<td style="text-align:center">
															<?php
																$rateperkg=$product_desc_array[$product_desc_array[$p]]['product_rate'];
																?>
																<?=$currency_symbol?> <?=number_format($rateperkg,5,'.','')?>
															</td>
															<td style="text-align:right">
															<?php
																
																$totalamountperkgs= $product_desc_array[$product_desc_array[$p]]['amount'];
                                                                ?>
																<?=$currency_symbol?> <?=number_format($totalamountperkgs,2,'.','')?>
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
															<td style="text-align:center"><?=$no?></td>
															 
															<td style="font-weight:bold;text-align:center" colspan="3">Sample</td>
													 		<td style="text-align:center"></td>
													 		<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center;font-weight:bold"></td>
															<td style="text-align:center"></td>
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
														<td style="text-align:center"><?=$no?></td>
														 
														<td style="text-align:center" colspan="3"><?=$jsondata->product_size_id?></td>
													 	<td  style="text-align:center" ><?=$jsondata->no_of_pallet?></td>
													 	<td  style="text-align:center"><?=$jsondata->no_of_boxes?></td>
													 	<td  style="text-align:center"><?=$jsondata->sqm?></td>
													 	<td  style="text-align:center"><?=$jsondata->netweight?></td>
													 	<td  style="text-align:center"><?=$currency_symbol?> <?=$jsondata->sample_rate?></td>
													 	<td  style="text-align:right"><?=$currency_symbol?> <?=$jsondata->sample_amout?></td>
														
													</tr>
													
												<?php
												$no++;
													 $no_of_row -= 1;	 
												 
													$Total_ammount 	+= $jsondata->sample_amout;
													$Total_amt 		+= $jsondata->sample_amout;
											}											
										 	for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														 
														<td colspan="3" style="border:none;border-right:0.5px solid #333;height: 31px;" > </td>
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
											<td colspan="4" style="font-weight:bold;vertical-align:top;">&nbsp;</td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_pallet; ?></td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_box; ?></td>
											<td  style="font-weight:bold;text-align:center"><?=number_format($Total_sqm,2,'.',''); ?></td>
											<td style="font-weight:bold;text-align:center" colspan="2"> <?=($invoicedata->calculation_operator == 2)? $invoicedata->terms_name: 'FOB';?> Value </td>
										  	<td style="font-weight:bold;text-align:right"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.',''); ?></td>
										 </tr>
									  	 <tr>
												<td  style="vertical-align:top;" colspan="4">
													 
												</td>
											 	<td style="text-align:center">PLTS</td>
											 	<td style="text-align:center">BOXES</td>
												<td style="text-align:center">SQM</td>
												<td colspan="2" style="text-align:center"><?=($invoicedata->certification_charge > 0)?"CERTIFICATION":"" ?></td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol?>  <?=($invoicedata->certification_charge > 0)?number_format($invoicedata->certification_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										 <?php $Total_amt +=$invoicedata->certification_charge;  ?>
										  <tr>
												<td  style="font-weight:bold;vertical-align:top;" colspan="4" rowspan="2"> 
													<?=$invoicedata->export_under1?>
												</td>
												<td  style="font-weight:bold;text-align:center;" colspan="2" rowspan="2">
													Net Weight
												</td>
												<td  rowspan="2" style="font-weight:bold;text-align:center;">
													<?=$totalnetweight?>KG
												</td>
											 	<td colspan="2" style="text-align:center;">INSURANCE</td>
											 	<td style="font-weight:bold;text-align:right">
													<?=$currency_symbol?> <?=($invoicedata->insurance_charge > 0)?number_format($invoicedata->insurance_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										 <?php $Total_amt +=$invoicedata->insurance_charge;  ?>
										  <tr>
												 <td style="text-align:center;" colspan="2">FREIGHT</td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol?> <?=($invoicedata->seafright_charge > 0)?number_format($invoicedata->seafright_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										 <?php $Total_amt +=$invoicedata->seafright_charge;  ?>
										  <tr>
												<td  style="font-weight:bold;vertical-align:top;" colspan="4"> 
												<?=$invoicedata->remarks?>
												---<?php 
										 	if($company_detail[0]->s_c_type == "Merchant")
											{
													foreach($export_supplier_data as $sup_data)
													{
														if(!empty($sup_data->epcg_no))
														{
															echo 'EPCG NO:'.$sup_data->epcg_no.' DATE:'.date('d.m.Y',strtotime($sup_data->epcg_date));
														}
													}
											}
											else
											{
												foreach($export_supplier_data as $sup_data)
													{
														echo $sup_data->epcg_licence_no;
													}	
											}
											 
												?>
													<br>
													
											   <?=implode(",",$water_array)?>
											</td>
											 	 <td colspan="2" style="text-align:center;font-weight:bold"> Gross Weight</td>
												 <td style="text-align:center;font-weight:bold"> <?=$totalgrossweight?>KG </td>
												<td colspan="2" style="text-align:center">Discount</td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol?> <?=($invoicedata->discount > 0)?number_format($invoicedata->discount,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										
										  <?php $Total_amt -= $invoicedata->discount; ?>
										  <tr>
												<td  style="font-weight:bold;vertical-align:top;" colspan="2"> AMOUNT IN WORDS</td>
											 	<td style="" colspan="5"><?=strtoupper(convertamonttousd($Total_amt,$invoicedata->currency_name))?> ONLY </td>
											 	 
												<td colspan="2" style="text-align:center"><?=$invoicedata->terms_name?> in <?=$invoicedata->currency_name?> </td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($Total_amt,2,'.','')?>
												</td>
										 </tr>
										 
										  
										 <tr>
										   <td colspan="10"><strong><?=$invoicedata->rex_no_detail?><br>
										   <?=$invoicedata->company_rules?>
										   </strong>
&nbsp;</td>
									      </tr>
										 <tr>
										   <td colspan="10"> <?=$invoicedata->export_under?></td>
									      </tr>
										<tr>
										   <td colspan="2">DISTRICT OF ORIGIN : MORBI  </td>
										   <td colspan="8">STATE OF ORIGIN  : GUJARAT - INDIA </td>
									      </tr>	
										 <tr>
												 <td colspan="2"> Self Sealing Declaration	 </td>
											     <td colspan="5" style="font-weight:bold"> 
													(1) Certified That The Description & Value Of Goods Covered By This Invoice Have Been Checked By Me & That Goods Have Been Packed & Sealed With One Time Seal (OTS) Under My Direct Supervision 
													(2) We Have Follow The Procedure Laid Down In CBEC's Circular No. 426/59/98 CX Dt.12/10/1998 As Amemded Against This Shipment" 
												</td> 
												<td colspan="3"  style="vertical-align:top;text-align:right;font-weight:bold;border-bottom: none;">
													For <?=$company_detail[0]->s_name?>
													<br>
													<br>
													<br>
													<br>
													 
									  	  </td>

										  </tr>	
										<tr>
											<td colspan="4">
												Declaration: We Declare That This Invoice Shows The Actual Price Of The Goods Described & That All Particulars Are True And Correct 
											</td>
											<td colspan="3" style="text-align:center"> 
												CERTIFY THAT GOODS ARE OF <br>
												"INDIAN ORIGIN"										
											</td>
											<td colspan="3"  style="vertical-align:bottom;text-align:right;font-weight:bold;border-top: none;">
												 
													  <?=nl2br($company_detail[0]->authorised_signatury)?>  <br>
										  </td>
										</tr>
							  </table>
								
										<?php 
										}
										else
										{
										 ?>
										<table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
											 	<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
											 	<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
											 	<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
											 	<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
											 	<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
											</tr>                          
											<tr>
												<td rowspan="3" style="text-align:center;font-weight:bold">
													Sr No
												</td>
												 <td style="text-align:center;font-weight:bold">
														Marks & NOS
											  </td>
												<td  style="text-align:center;font-weight:bold" colspan="2">
													DESCRIPTION OF GOODS
												</td>
												<td colspan="4" style="text-align:center;font-weight:bold"> 
													QUANTITY
												</td>
												<td colspan="2" style="text-align:center;font-weight:bold">
													AMOUNT
												</td>
										 	</tr>
											<?php 
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
										 	$water_array = array();
											$no_of_row = 15;
											$totalnetweight =0;
											$totalgrossweight =0;
											
											for($i=0; $i<count($product_data);$i++)
											{	
												$Total_sqm 			+= $product_data[$i]->total_no_of_sqm;
												$Total_box 			+= $product_data[$i]->total_no_of_boxes;
												$Total_pallet 		+= $product_data[$i]->total_no_of_pallet;
												$totalnetweight 	+= 	$product_data[$i]->updated_net_weight;
												$totalgrossweight 	+= 	$product_data[$i]->updated_gross_weight; 
											 	if(!in_array(trim($product_data[$i]->series_name),$series_name_array))
												{
													array_push($series_name_array,$product_data[$i]->series_name);
													array_push($water_array,$product_data[$i]->water_text);
												}
											  	 $n = 1;
													$Total_ammount	 += $product_data[$i]->product_amt;
													$Total_amt 	 	 += $product_data[$i]->product_amt;
													
													$description_goods =  $product_data[$i]->description_goods.$product_data[$i]->pcs_per_box;
												 	if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->description_goods;
														$product_desc_array[trim($description_goods)]['product_name'] = ($product_data[$i]->series_name);
														$product_desc_array[trim($description_goods)]['size_type_cm'] = $product_data[$i]->size_type_cm;
														 $product_desc_array[trim($description_goods)]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
														 $product_desc_array[trim($description_goods)]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
														$product_desc_array[trim($description_goods)]['title_type'] = $product_data[$i]->tiles_type;
														  
														$product_desc_array[trim($description_goods)]['no_of_pallet'] = $product_data[$i]->no_of_pallet;
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] = $product_data[$i]->no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] = $product_data[$i]->no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] = $product_data[$i]->no_of_boxes;
														 
														 $product_desc_array[trim($description_goods)]['sqm'] = $product_data[$i]->no_of_sqm;
														 $product_desc_array[trim($description_goods)]['net_weight'] = $product_data[$i]->packing_net_weight;
														 $product_desc_array[trim($description_goods)]['product_rate'] =$product_data[$i]->product_rate;
														 $product_desc_array[trim($description_goods)]['per'] = $product_data[$i]->per;
														
														 $product_desc_array[trim($description_goods)]['amount'] = $product_data[$i]->product_amt;
														  
													}
													else
													{
														$product_desc_array[trim($description_goods)]['no_of_pallet'] += $product_data[$i]->no_of_pallet;
														$product_desc_array[trim($description_goods)]['no_of_big_pallet'] += $product_data[$i]->no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['no_of_small_pallet'] += $product_data[$i]->no_of_small_pallet;
														$product_desc_array[trim($description_goods)]['boxes'] += $product_data[$i]->no_of_boxes;
														$product_desc_array[trim($description_goods)]['sqm'] += $product_data[$i]->no_of_sqm;
														$product_desc_array[trim($description_goods)]['amount'] += $product_data[$i]->product_amt;
														 $product_desc_array[trim($description_goods)]['net_weight'] = $product_data[$i]->packing_net_weight;
													}
											}
											foreach ($sample_data as $jsondata)
											{
												$Total_sqm 			+= $jsondata->sqm;
												$Total_box 			+= $jsondata->no_of_boxes;
												$Total_pallet 		+= $jsondata->no_of_pallet;
											}
											?>
											 <tr>
												<td style="text-align:center;font-weight:bold" rowspan="2">
													 THERE ARE <?=$Total_box?> BOXES PACKED IN <?=$Total_pallet?> PALLETS
												</td> 
												<td   style="text-align:center;font-weight:bold" colspan="2">
													<?php
													 
													$no=1;
													for($ser=0;$ser<count($series_name_array);$ser++)
													{
														if(!empty($series_name_array[$ser]))
														{
															echo $series_name_array[$ser].'<br>';
														}
													}
											 	 ?>
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold"> 
													PALLETS
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													BOXES
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													SQM
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													 WEIGHT IN KGS
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													RATE PER SQM
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													AMOUNT IN <?=$invoicedata->currency_name?>
												</td>
										 	</tr>
										 	<tr>
												 
												 
													<td colspan="2" style="text-align:center;font-weight:bold">
													 DESIGN NAME
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
															<td style="text-align:center"> <?=$no?></td>
															<td style="text-align:center" colspan="3">
																<?=$product_desc_array[$product_desc_array[$p]]['product_name']?>
															</td>
														 
															<td style="text-align:center">
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
																?>
															</td>
															<td style="text-align:center">
																   <?=$product_desc_array[$product_desc_array[$p]]['boxes']?>
															</td>
															<td style="text-align:center">
																 <?=number_format($product_desc_array[$product_desc_array[$p]]['sqm'],2,'.','')?>
															</td>
															<td style="text-align:center">
																<?=$product_desc_array[$product_desc_array[$p]]['net_weight']?>
															</td>
															<td style="text-align:center">
															<?php
																$rateperkg=$product_desc_array[$product_desc_array[$p]]['amount']/$product_desc_array[$product_desc_array[$p]]['net_weight'];
																?>
																<?=$currency_symbol?> <?=number_format($rateperkg,5,'.','')?>
															</td>
															<td style="text-align:right">
															<?php
																
																$totalamountperkgs=$rateperkg*$product_desc_array[$product_desc_array[$p]]['net_weight'];
                                                                ?>
																<?=$currency_symbol?> <?=number_format($totalamountperkgs,2,'.','')?>
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
															<td style="text-align:center"><?=$no?></td>
															 
															<td style="font-weight:bold;text-align:center" colspan="3">Sample</td>
													 		<td style="text-align:center"></td>
													 		<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center;font-weight:bold"></td>
															<td style="text-align:center"></td>
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
														<td style="text-align:center"><?=$no?></td>
														 
														<td style="text-align:center" colspan="3"><?=$jsondata->product_size_id?></td>
													 	<td  style="text-align:center" ><?=$jsondata->no_of_pallet?></td>
													 	<td  style="text-align:center"><?=$jsondata->no_of_boxes?></td>
													 	<td  style="text-align:center"><?=$jsondata->sqm?></td>
													 	<td  style="text-align:center"><?=$jsondata->netweight?></td>
													 	<td  style="text-align:center"><?=$currency_symbol?> <?=$jsondata->sample_rate?></td>
													 	<td  style="text-align:right"><?=$currency_symbol?> <?=$jsondata->sample_amout?></td>
														
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
														 
														<td colspan="3" style="border:none;border-right:0.5px solid #333;height: 31px;" > </td>
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
										 	if(count($sample_data)!=0)
											{	
											
											?>
											<tr>
															<td style="text-align:center"><?=$no?></td>
															 
															<td style="font-weight:bold;text-align:center" colspan="3">Sample</td>
													 		<td style="text-align:center"></td>
													 		<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center;font-weight:bold"></td>
															<td style="text-align:center"></td>
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
														<td style="text-align:center"><?=$no?></td>
														 
														<td style="text-align:center" colspan="3"><?=$jsondata->product_size_id?></td>
													 	<td  style="text-align:center" ><?=$jsondata->no_of_pallet?></td>
													 	<td  style="text-align:center"><?=$jsondata->no_of_boxes?></td>
													 	<td  style="text-align:center"><?=$jsondata->sqm?></td>
													 	<td  style="text-align:center"><?=$jsondata->netweight?></td>
													 	<td  style="text-align:center"><?=$jsondata->sample_rate?></td>
													 	<td  style="text-align:center"><?=$jsondata->sample_amout?></td>
														
													</tr>
													
												<?php
												$no++;
													 $no_of_row -= 1;	 
												 	$Total_ammount 	+= $jsondata->sample_amout;
													$Total_amt 		+= $jsondata->sample_amout;
											}											
										 	for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														 
														<td colspan="3" style="border:none;border-right:0.5px solid #333;height: 31px;" > </td>
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
											<td colspan="4" style="font-weight:bold;vertical-align:top;">
												 <?=$invoicedata->remarks?>
											</td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_pallet; ?></td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_box; ?></td>
											<td  style="font-weight:bold;text-align:center"><?=number_format($Total_sqm,2,'.',''); ?></td>
											<td style="font-weight:bold;text-align:center" colspan="2"> <?=($invoicedata->calculation_operator == 2)? $invoicedata->terms_name: 'FOB';?> Value </td>
										  	<td style="font-weight:bold;text-align:right"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.',''); ?></td>
										 </tr>
									  	 <tr>
												<td  style="vertical-align:top;" colspan="4"><span style="font-weight:bold;vertical-align:top;">
												  <?php 
										 	if($company_detail[0]->s_c_type == "Merchant")
											{
													foreach($export_supplier_data as $sup_data)
													{
														if(!empty($sup_data->epcg_no))
														{
															echo 'EPCG LIC NO:'.$sup_data->epcg_no.' DATED:'.date('d.m.Y',strtotime($sup_data->epcg_date));
														}
													}
											}
											else
											{
												foreach($export_supplier_data as $sup_data)
													{
														echo $sup_data->epcg_licence_no;
													}	
											}
											 
												?>
												</span>
													 
												</td>
											 	<td style="text-align:center">PLTS</td>
											 	<td style="text-align:center">BOXES</td>
												<td style="text-align:center">SQM</td>
												<td colspan="2" style="text-align:center"><?=($invoicedata->certification_charge > 0)?"CERTIFICATION":"" ?></td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol?>  <?=($invoicedata->certification_charge > 0)?number_format($invoicedata->certification_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										 <?php $Total_amt +=$invoicedata->certification_charge;  ?>
										  <tr>
												<td  style="vertical-align:top;" colspan="4" rowspan="2"> 
													<?=$invoicedata->export_under1?> <br />
												EXPORT UNDER GST CIRUCULAR NO.  
												<?=$company_detail[0]->gst_circular_no?>
Customs Dt.
<?=$company_detail[0]->date_of_filing?>
&nbsp;<br />
LATTER OF UNDERTACKING Application Referance Number ( ARN ) :
<?=$company_detail[0]->s_lutno?></td>
												<td  style="font-weight:bold;text-align:center;" colspan="2" rowspan="2">
													Net Weight
												</td>
												<td  rowspan="2" style="font-weight:bold;text-align:center;">
													<?=$totalnetweight?> KG
												</td>
											 	<td colspan="2" style="text-align:center;">INSURANCE</td>
											 	<td style="font-weight:bold;text-align:right">
													<?=$currency_symbol?> <?=($invoicedata->insurance_charge > 0)?number_format($invoicedata->insurance_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										 <?php $Total_amt +=$invoicedata->insurance_charge;  ?>
										  <tr>
												 <td style="text-align:center;" colspan="2">FREIGHT</td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol?> <?=($invoicedata->seafright_charge > 0)?number_format($invoicedata->seafright_charge,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										 <?php $Total_amt +=$invoicedata->seafright_charge;  ?>
										  <tr>
												<td  style="font-weight:bold;vertical-align:top;" colspan="4"><br></td>
											 	 <td colspan="2" style="text-align:center;font-weight:bold"> Gross Weight</td>
												 <td style="text-align:center;font-weight:bold"> <?=$totalgrossweight?> KG </td>
												<td colspan="2" style="text-align:center">Discount</td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol?> <?=($invoicedata->discount > 0)?number_format($invoicedata->discount,2,'.',''):"0.00" ?>
												</td>
										 </tr>
										
										  <?php $Total_amt -= $invoicedata->discount; ?>
										  <tr>
												<td  style="font-weight:bold;vertical-align:top;" colspan="2">Total <span style="font-weight:bold;text-align:center">
												  <?=($invoicedata->calculation_operator == 2)? $invoicedata->terms_name: 'FOB';?>
												</span> USD in Words:</td>
											 	<td style="" colspan="5"><?=strtoupper(convertamonttousd($Total_amt,$invoicedata->currency_name))?> ONLY </td>
											 	 
												<td colspan="2" style="text-align:center"><?=$invoicedata->terms_name?> in <?=$invoicedata->currency_name?> </td>
											 	<td  style="font-weight:bold;text-align:right">
													<?=$currency_symbol.number_format($Total_amt,2,'.','')?>
												</td>
										 </tr>
										 <?php
														if($company_detail[0]->s_c_type == "Merchant")
														{
														$no =1;
															foreach($export_supplier_data as $sup_row)
															{ 
																 ?>
										 <tr>
										 
										   <td colspan="2"><strong>LEGAL NAME :</strong></td>
												 <td><span style="vertical-align:top;text-align:left;border-bottom: none;">
												   <?=$sup_row->company_name?>
												 </span></td>
												 <td colspan="2"><strong>TAX INVOICE NO. :</strong></td>
												 <td colspan="2"><span style="border-bottom:none;border-left:none;border-top:none;">
										   <?=$sup_row->suppiler_invoice_no?></span></td>
											    <td colspan="3" rowspan="3"  style="vertical-align:top;text-align:right;font-weight:bold;border-bottom: none;">
													For <?=$company_detail[0]->s_name?>
													<br>
													<br>
													<br>
													<br>
													 
									  	  </td>

										  </tr>
                                         
										 <tr>
										   <td colspan="2"><strong>GSTIN NO. :</strong></td>
										   <td><?=$sup_row->supplier_gstno?></td>
										   <td colspan="2"><strong>TAX INVOICE :</strong></td>
										   <td colspan="2"><span style="border-bottom:none;border-left:none;border-top:none;">
										     <?=date('d/m/Y',strtotime($sup_row->suppiler_invoice_date))?>
										   </span></td>
									      </tr>
										 <tr>
										   <td colspan="2"><strong>CENTER JURISDICTION:</strong></td>
										   <td>&nbsp;(Rajkot)(Morbi-I Division)</td>
										   <td colspan="2"><strong>STATE JURISDICTION :&nbsp;</strong></td>
										   <td colspan="2">&nbsp;Ghatak 91 (Morbi)</td>
									      </tr>	
										<tr>
                                        
                                         <?php 
																 $no++;
																	}
																}
																?>
											<td colspan="4">
												Declaration: We Declare That This Invoice Shows The Actual Price Of The Goods Described & That All Particulars Are True And Correct 
											</td>
											<td colspan="3" style="text-align:center"> 
												CERTIFY THAT GOODS ARE OF <br>
												"INDIAN ORIGIN"										
											</td>
											<td colspan="3"  style="vertical-align:bottom;text-align:right;font-weight:bold;border-top: none;">
												 
													  <?=nl2br($company_detail[0]->authorised_signatury)?>  <br>
										  </td>
										</tr>
							  </table>
										<?php 
										
										}
										?>
							<pagebreak />									 
												 <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class">
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" colspan="6">
														 
												</td>
										 	</tr>  
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="24%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="21%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												 
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
													"SUPPLY MEANT FOR EXPORT UNDER BOND & LUT-LETTER OF UNDERTAKING WITHOUT PAYMENT OF INTEGRATED TAX"
													<?php }
													else{?>
														"SUPPLY MEANT FOR EXPORT UNDER BOND & LUT-LETTER OF UNDERTAKING WITH PAYMENT OF INTEGRATED TAX"
													<?php }?>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold"> Exporter :</td>
												<td colspan="4"> 
														 
												</td>
											</tr>
											<tr>
												<td colspan="2" rowspan="3" style="vertical-align:top;border-right:none"> 
														<?=$export?><br />
														<strong>GSTIN NO : </strong>
														<?=$exporter_gstin?>
                                                        <strong> PAN NO :</strong>
                                                        <?=$exporter_pan?>
                                                        <br />
                                                        <strong>IEC NO : </strong>
                                                        <?=$exporter_iec?>
                                                        <strong> STATE CODE :</strong>
                                                        <?=$company_detail[0]->state_code?>
                                                        <br />
                                                        <strong>ARN : </strong>
                                                        <?=$company_detail[0]->s_lutno?></td>
											    <td   style="font-weight:bold">   Exporter Invoice No. & Date :</td>
												<td>
														<?=$exportinvoice_no?>
												</td>
												<td colspan="2"> 
														<?=$export_date?>
												</td>
											</tr>
											 
											<tr>
												<td  style="font-weight:bold">
													Profoma Invoice No. & Date :
												</td>
												<td colspan="3"> 
														<?=$export_ref_no?> &amp; <?=$performa_date?> 
												 
											  </td>
											</tr>
											<tr>
												<td  style="font-weight:bold">
													  Buyer's order No. & Date:
												</td>
												<td colspan="3"> 
														<?=$buy_order_no?>  
											  </td>
											</tr>
											<tr>
												<td height="80" colspan="2" valign="top">  <strong>Consignee : </strong><br>
												TO THE ORDER
												</td>
												 
												<td  style="font-weight:bold;vertical-align:top;">Notify Party Address : ( Delivery Address)</td>
												<td colspan="3"   style="vertical-align:top"> 
														 
													 <?=$buyer_other_consign?>
												</td>
												 
												 
											</tr>
											  <tr>
												<td style="font-weight:bold">  Pre Carriage By</td>
												<td style="font-weight:bold"> Place of Receipt by Pre-Carrier </td>
												<td style="font-weight:bold"> Country of Origin of Goods :</td>
												<td style="font-weight:bold" colspan="3"> Country of Final Destination of Goods :
												</td>
											 </tr>
											 
											 <tr>
												<td>
													<?=$pre_carriage_by?>
												</td>
												<td>
													<?=$place_of_receipt?>
												</td>
												<td >
													<?=$country_origin_goods?>
												</td>
												<td colspan="3">
														<?=$country_final_destination?>
												</td>
											</tr>
											  <tr>
												<td style="font-weight:bold">  Vessel / Flight Name & No </td>
												<td style="font-weight:bold">  Port of Loading	 </td>
												 <td colspan=""  style="font-weight:bold">No Of Container</td>
												 <td style="font-weight:bold" colspan="3">Terms Of Delivery</td>
												
											  </tr>
											  <tr>
													
												<td>
													<?=$flight_name_no?>
												</td>
												<td>
													<?=$export_port_loading?>
												</td>
												<td>
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
													 <td colspan="3"> 
														<?=$invoicedata->terms_name?> - <?=$export_terms_of_delivery?>
													</td>
											</tr> 
											<tr>
												<td style="font-weight:bold">  Port Of Discharge</td>
												<td style="font-weight:bold" >  Place of Delivery</td>
												 <td style="font-weight:bold">  Terms of  Payment:</td>
												 <td colspan="3" >
												 	<?=$export_payment_terms?>
												 </td>
											 </tr>
											 <tr>
											   <td style="vertical-align:top"><?=$port_of_discharge?></td>
											   <td style="vertical-align:top"><?=$final_destination?></td>
											   <td style="font-weight:bold" valign="top">Bank Details</td>
											   <td colspan="3" rowspan="2" align="left" valign="top" ><?=$bank_detail?>											     &nbsp;</td>
											   </tr>
											
								</table>
									<?php 
										 
										if($direct_invoice==1)
										{
										?>
											<table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class">
										<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
											</tr>                          
											<tr>
												<td colspan="4" style="text-align:center;font-weight:bold">
												Marks & NOS		
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
												 ?>
												</td>
												 
												<td colspan="4" style="text-align:center;font-weight:bold">
													DESCRIPTION OF GOODS
												</td>
												<td colspan="3" style="text-align:center;font-weight:bold"> 
													QUANTITY
												</td>
												<td colspan="2" style="text-align:center;font-weight:bold">
													APPROX
												</td>
										 	</tr>
										 	 <tr>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													CONTAINER NO.</td> 
												<td rowspan="2" style="text-align:center;font-weight:bold">
													LINE SEAL NO.
												</td>
												 <td rowspan="2" style="text-align:center;font-weight:bold">
													E SEAL NO.
											   </td>
												 <td rowspan="2" style="text-align:center;font-weight:bold">
													PALLET NO.</td>  
												<td  colspan="4" style="text-align:center;font-weight:bold">
													<?php
													 
													$no=1;
													for($ser=0;$ser<count($series_name_array);$ser++)
													{
														if(!empty($series_name_array[$ser]))
														{
															echo $series_name_array[$ser].'<br>';
														}
													}
											 	 ?>
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold"> 
													PALLETS
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													BOXES
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													SQM
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													NET WEIGHT
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													GROSS WEIGHT
												</td>
										 	</tr>
											<tr>
												  <td style="text-align:center;font-weight:bold">
													DESIGN/ITEM NAME
												</td>
												  
												 <td style="text-align:center;font-weight:bold">
													SIZE
												</td>
												<td style="text-align:center;font-weight:bold">BATCH NO.</td>
												<td style="text-align:center;font-weight:bold">
													SHADE NO.
												</td>
										 	</tr>
											 
											 <?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_ammount = 0;
											$setcontainer = 0;
											$packingtrn_array = array();
											$con_entry = 1;
										 	$con_array = array();
											$conarray = array();
											$no_of_row = 15;
											$sample_data_array  = array(); 
											$sample_net_array  = array(); 
											$sample_gross_array  = array(); 
											$stringcolor =array();
											for($i=0; $i<count($product_data);$i++)
											{
												$n = 1;
													
													if($product_data[$i]->product_container == 0)
													{
															$checkedcontainer='';
															$explodeproduct=array();
															$string='';
															$disabled = '';$sample_str = '';
														 	for($a=0;$a<count($container_data);$a++)
															{
																
																if(!in_array($container_data[$a]->allproduct_id,$explodeproduct))
																{
																	$string .= $container_data[$a]->allproduct_id.',';
																	array_push($explodeproduct,$container_data[$a]->allproduct_id);
																	$no_of_product_array = explode(",",$container_data[$a]->allproduct_id);
																	 
																	if(in_array($product_data[$i]->exportproduct_trn_id,$no_of_product_array))
																	{		
																		$rowspan =  count(explode(",",$container_data[$a]->allproduct_id));
																		$netweight 	 = $container_data[$a]->mix_net_weight;
																		$grossweight = $container_data[$a]->mix_gross_weight;
																	}
															 	}
																
														 	}
															$row_no='';
															$sample_rowspan = '';
															 
															$sample_net_array[$sample_row->container_name] = 0;
															$sample_gross_array[$sample_row->container_name] = 0;
															 
															if(!in_array($product_data[$i]->container_order_by,array_filter($stringcolor)) && $rowspan>0 && $product_data[$i]->container_order_by!=0)
															{
																 $container_no++;
																 $conname = $product_data[$i]->directcontainer_no;
																 $sample_data =  $product_data[$i]->sample;
															
															if(empty($sample_str))
															{
																$sample_str = '';
																
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	
																	 if($sample_row->container_name == $conname)
																	  {
																		 
																		$sample_str .= '<tr>
																						<td style="" colspan="4">
																							'.$sample_row->sample_remarks.'
																						</td>
																						 <td style="text-align:center"  >
																							'.$sample_row->no_of_pallet.'
																						</td>
																					 	<td style="text-align:center">
																							'.$sample_row->no_of_boxes.'
																						</td>
																						<td style="text-align:center">
																							'.number_format($sample_row->sqm,2,'.','').'
																						</td>
																						</tr>
																			<input type="hidden" name="container_no'.$sample_row->exportinvoicetrnid.'[]" id="container_no'.$container_no.$sample_row->export_sampletrn_id.'" value="'.$sample_row->container_name.'" />';
																			
																			array_push($sample_data_array,$sample_row->container_name);
																			 
																		 	$sample_net_array[$sample_row->container_name]  += $sample_row->netweight;
																			$sample_gross_array[$sample_row->container_name] += $sample_row->grossweight;
																			$Total_box  +=$sample_row->no_of_boxes;
																			$Total_sqm  +=$sample_row->sqm;
																			$no_of_row--;
																		}
																		 
																}
															}
														   
																if(in_array($conname,$sample_data_array))
																{
																	$counts 		 = array_count_values($sample_data_array);
																	$sample_rowspan  = $counts[$conname] + 1;
																	$netweight 		+= $sample_net_array[$conname]; 
																	$grossweight 	+= $sample_net_array[$conname]; 
																	$container_name  = $conname;
															 	}
																if($product_data[$i]->updated_grossweight > 0)
																{
																	$grossweight = $product_data[$i]->updated_grossweight;
																}
																if($product_data[$i]->updated_netweight > 0)
																{
																	$netweight = $product_data[$i]->updated_netweight;
																}
																
																if($sample_rowspan > 0)
																{
																		$rowspan += $sample_rowspan;
																		 $rowspan -= 1; 
																}
																$rowspan =  $rowspan + count($product_data[$i]->packing);
																$rowspan--;

																?>
															<tr>
																<td   style="text-align:center" rowspan="<?=$rowspan?>">
																	 <?=$product_data[$i]->directcontainer_no?>
																</td>
																<td style="text-align:center" rowspan="<?=$rowspan?>">
																	<?=$product_data[$i]->directseal_no?>
																</td>
																<td style="text-align:center" rowspan="<?=$rowspan?>">
																	 <?=$product_data[$i]->directrfidseal_no?>
																</td>
																<td style="text-align:center" rowspan="<?=$rowspan?>">
																	 <?=$product_data[$i]->directpallet_no?>
																</td>
															<?php 
														 	$row_no='rowspan';
															array_push($stringcolor,$product_data[$i]->container_order_by);
															} 
															else
															{
																echo "<tr>";
															}
															$n = 1;
															foreach($product_data[$i]->packing as $packing_row)
															{
																if($n > 1)
																{
																	echo "<tr>";
																}
															?>
															
																<td style="text-align:center">
																	<?=$packing_row->model_name?>
																</td>
																<td style="text-align:center">
																	<?=$product_data[$i]->size_type_cm?>[<?=$product_data[$i]->pcs_per_box?>PCS=<?=$product_data[$i]->sqm_per_box?>SQM]
																</td>
																<td style="text-align:center">&nbsp;</td>
																<td style="text-align:center">
																	 
																</td>
																<td style="text-align:center;">
																	 <?php 
																	 if($packing_row->no_of_pallet > 0)
																	{
																		echo $packing_row->no_of_pallet;
																	}
																	else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet > 0)
																	{
																		echo $packing_row->no_of_big_pallet."<br>".$packing_row->no_of_small_pallet;
																	}
																	else 
																	{
																		echo "-";
																	}
																	 ?>
																</td>
																<td style="text-align:center">
																	<?=$packing_row->no_of_boxes?>
																</td>
															 	<td style="text-align:center">
																	<?=number_format($packing_row->no_of_sqm,2,'.','')?>
																</td>
																<?php 
																if(!empty($row_no) && $n==1) 
																{
																?>
																	<td style="text-align:center" rowspan="<?=$rowspan?>">
																		<?=number_format($netweight,2,'.','')?>
																	</td>
																	<td style="text-align:center" rowspan="<?=$rowspan?>">
																		<?=number_format($grossweight,2,'.','')?>
																	</td>
											  </tr>
															<?php
																	$no_of_row--;
																}
																if($n>1)
																{
																	echo "</tr>";
																	echo $sample_str;
																}
																$n++;
															}
																
																$Total_box 	+= $product_data[$i]->total_no_of_boxes;
																$Total_sqm 	+= $product_data[$i]->total_no_of_sqm;
													}
													else
													{
													
													$no_of_container = $product_data[$i]->product_container;
													$con_name = explode(",",$product_data[$i]->directcontainer_no);
													$seal_no = explode(",",$product_data[$i]->directseal_no);
													$rfidseal_no = explode(",",$product_data[$i]->directrfidseal_no);
													$pallet_no = explode(",",$product_data[$i]->directpallet_no);
													$update_grossweight = explode(",",$product_data[$i]->updated_grossweight);
													$update_netweight = explode(",",$product_data[$i]->updated_netweight);
														
													for($c=0;$c<$no_of_container;$c++)
													{
														$netweight = $packing_row->packing_net_weight/$no_of_container;
														$grossweight = $packing_row->packing_gross_weight/$no_of_container;
														$container_no++;
														$rowspan = '';
														$container_name = '';
														$conname = $con_name[$c];
														$sample_data =  $product_data[$i]->sample;
														
														$sample_net_array[$sample_row->container_name] = 0;
														$sample_gross_array[$sample_row->container_name] = 0;
												$sample_str = '';
												if(empty($sample_str))
												{
													$sample_str = '';
												  foreach($product_data[$i]->sample  as $sample_row)
												  {
													  if($sample_row->container_name == $conname)
													  {
													   $sample_str .= '
													   <tr>
															<td style="" colspan="4">
																'.$sample_row->sample_remarks.'
															</td>
															<td style="text-align:center">
																'.$sample_row->no_of_pallet.'
															</td> 
															<td style="text-align:center">
																'.$sample_row->no_of_boxes.'
															</td>
															<td style="text-align:center">
																'.number_format($sample_row->sqm,2,'.','').'
															</td>
															
														 	</tr>
															<input type="hidden" name="container_no'.$sample_row->exportinvoicetrnid.'[]" id="container_no'.$container_no.$sample_row->export_sampletrn_id.'" value="'.$sample_row->container_name.'" />';
															$no_of_row--;
															 array_push($sample_data_array,$sample_row->container_name);
															  $Total_box  +=$sample_row->no_of_boxes;
																			$Total_sqm  +=$sample_row->sqm;
															 $sample_net_array[$sample_row->container_name]  += $sample_row->netweight;
															 $sample_gross_array[$sample_row->container_name] += $sample_row->grossweight;
													  }
											 	  }
												  
												}
												  
														if(in_array($conname,$sample_data_array))
														{
															$counts = array_count_values($sample_data_array);
														 	$rowspan = $counts[$conname] + 1;
															$netweight += $sample_net_array[$conname]; 
															$grossweight += $sample_net_array[$conname]; 
															$container_name = $conname;
															$rowspan--;
														}
														 
														if($update_grossweight[$c] > 0)
														{
															$grossweight = $update_grossweight[$c];
														}
														if($update_netweight[$c] > 0)
														{
															$netweight = $update_netweight[$c];
														}
															$rowspan =  $rowspan + count($product_data[$i]->packing);
															
										 		?>
												 <tr>
												   	<td style="text-align:center"  rowspan="<?=$rowspan?>"><?=$con_name[$c]?></td>
												 	<td style="text-align:center"  rowspan="<?=$rowspan?>"><?=$seal_no[$c]?></td>
												 	<td style="text-align:center"  rowspan="<?=$rowspan?>"><?=$rfidseal_no[$c]?>	</td>
													<td style="text-align:center"  rowspan="<?=$rowspan?>"><?=$pallet_no[$c]?>	
													</td>
													<?php
													$n = 1;
													foreach($product_data[$i]->packing as $packing_row)
													{
														 
															if($n>1)
															{
																echo "<tr>";
															}
													?>
													<td style="text-align:center">
														<?=$packing_row->model_name?>
													</td>
												 	<td style="text-align:center">
														<?=$product_data[$i]->size_type_cm?>[<?=$product_data[$i]->pcs_per_box?>PCS=<?=$product_data[$i]->sqm_per_box?>SQM]
													</td>
														<td style="text-align:center;">&nbsp;</td>
														<td style="text-align:center;">
															  
														</td>

														<td style="text-align:center;">
															<?php 
																	 if($packing_row->no_of_pallet > 0)
																	{
																		echo $packing_row->no_of_pallet/$no_of_container;
																	}
																	else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet > 0)
																	{
																		echo $packing_row->no_of_big_pallet/$no_of_container."<br>".$packing_row->no_of_small_pallet/$no_of_container;
																	}
																	else 
																	{
																		echo "-";
																	}
																	 ?> 
														</td>
														<td style="text-align:center">
															<?=$packing_row->no_of_boxes/$no_of_container; ?>
														</td>
												 	<td style="text-align:center">
															<?=number_format($packing_row->no_of_sqm/$no_of_container,2,'.',''); ?>
												   </td>
													<?php
															if($n==1)
															{
																echo "
																		<td style='text-align:center' rowspan='".$rowspan."'>
																			".number_format($netweight,2,'.','')."
																		</td>
																		<td style='text-align:center' rowspan='".$rowspan."'>
																			".number_format($grossweight,2,'.','')."
																		</td>";
															}
															if($n>1)
															{
																echo "</tr>";
																echo $sample_str;
															}													
													$n++;
													}
													?>
												 </tr>
											<?php
													
												 	$Total_box 				+= $product_data[$i]->total_no_of_boxes/$no_of_container;
													$Total_sqm 				+= $product_data[$i]->total_no_of_sqm/$no_of_container;
													$no_of_row--;													
													}
													 
													}
											 
											$no++;
													
											}
										
											 
											 for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td colspan="4" style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														<td style="border:none;border-right:0.5px solid #333;height: 31px;" > </td>
													 	 <td  style="border:none;border-right:0.5px solid #333;" ></td>
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
											<td colspan="8" rowspan="2" style="font-weight:bold;vertical-align:top;">&nbsp;</td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_pallet; ?></td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_box; ?></td>
											<td  style="font-weight:bold;text-align:center"><?=number_format($Total_sqm,2,'.',''); ?></td>
											<td style="font-weight:bold;text-align:center"> <?=$totalnetweight?> </td>
										  	<td style="font-weight:bold;text-align:center"> <?=$totalgrossweight?> </td>
										 </tr>
									  	 <tr>
												 
											 	<td style="text-align:center">PALLETS</td>
											 	<td style="text-align:center">BOXES</td>
												<td style="text-align:center">SQM</td>
												<td  style="text-align:center"> NET WEIGHT</td>
											 	<td  style="text-align:center">
													 GROSS WEIGHT
												</td>
										 </tr>
										 			  
										 <tr>
										   <td colspan="13">&nbsp;</td>
									      </tr>
										 <tr>
										   <td colspan="13">&nbsp;</td>
									      </tr>
										 <tr>
										   <td colspan="4">&nbsp;</td>
										   <td colspan="9">&nbsp;</td>
									      </tr>	 
										 
										<tr>
												 <td colspan="10" valign="top"> Declaration: We Declare That This Invoice Shows The Actual Price Of The Goods Described &amp; That All Particulars Are True And Correct </td>
										        <td colspan="3"  style="vertical-align:top;text-align:right;font-weight:bold;border-bottom: none;">
													For <?=$company_detail[0]->s_name?>
													<br>
													<br>
													<br>
													<br>
													<br>
													 
									  	  </td>

										  </tr>	
										<tr>
											<td colspan="7">&nbsp;</td>
											<td colspan="3" style="text-align:center"> 
												CERTIFY THAT GOODS ARE OF <br>
												"INDIAN ORIGIN"										
											</td>
											<td colspan="3"  style="vertical-align:bottom;text-align:right;font-weight:bold;border-top: none;">
												 
													  <?=nl2br($company_detail[0]->authorised_signatury)?>  <br>
										  </td>
										</tr>
							  </table>
										
										<?php 
										}
										else
										{
										 ?>
											<table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class">
										<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
											</tr>                          
											<tr>
												<td colspan="4" style="text-align:center;font-weight:bold">
												Marks & NOS		
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
												 ?>
												</td>
												 
												<td colspan="4" style="text-align:center;font-weight:bold">
													DESCRIPTION OF GOODS
												</td>
												<td colspan="3" style="text-align:center;font-weight:bold"> 
													QUANTITY
												</td>
												<td colspan="2" style="text-align:center;font-weight:bold">
													APPROX
												</td>
										 	</tr>
										 	 <tr>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													CONTAINER NO
												</td> 
												<td rowspan="2" style="text-align:center;font-weight:bold">
													LINE SEAL NO.
												</td>
												 <td rowspan="2" style="text-align:center;font-weight:bold">
													RFID SEAL NO.
												</td>
												 <td rowspan="2" style="text-align:center;font-weight:bold">
													PALLET NO
												</td>  
												<td  colspan="4" style="text-align:center;font-weight:bold">
													<?php
													 
													$no=1;
													for($ser=0;$ser<count($series_name_array);$ser++)
													{
														if(!empty($series_name_array[$ser]))
														{
															echo $series_name_array[$ser].'<br>';
														}
													}
											 	 ?>
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold"> 
													PALLETS
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													BOXES
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													SQM
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													NET WEIGHT
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													GROSS WEIGHT
												</td>
										 	</tr>
											<tr>
												  <td style="text-align:center;font-weight:bold">
													DESIGN/ITEM NAME
												</td>
												  
												 <td style="text-align:center;font-weight:bold">
													SIZE
												</td>
												<td style="text-align:center;font-weight:bold">
													BATCH
												</td>
												<td style="text-align:center;font-weight:bold">
													SHADE NO.
												</td>
										 	</tr>
											<?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_ammount = 0;
											$setcontainer = 0;
											$packingtrn_array = array();
											$con_entry = 1;
										 	$con_array = array();
											$conarray = array();
											 $no_of_row = 15;
											 		
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												for($i=0; $i<count($product_data);$i++)
												{
												$sample_str = '';	  
											  	?>
												<tr>
													<?php
												 
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowcon_no > 1)?$product_data[$i]->rowcon_no:'';
														
															if(empty($sample_str))
															{
																$rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																		$sample_str .= '<tr>
																						 <td colspan="3"  style="text-align:center">
																						 	'.$sample_des.'
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
																						 <td style="text-align:center">
																						 	 '.$sample_row->netweight.'
																						 </td>
																						 <td style="text-align:center">
																						 	 '.$sample_row->grossweight	.'
																						 </td>
																						</tr> ';
																		$Total_plts		+= $sample_row->no_of_pallet;
																		$Total_sqm 		+= $sample_row->sqm;
																		$Total_box 		+= $sample_row->no_of_boxes;
																		$Total_ammount 	+= $sample_row->sample_amout;
																		 $no_of_row--;
																 }
																 
															}
														 
												 	?>
													
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->container_no?>
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->seal_no?> 
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														<?=$product_data[$i]->self_seal_no?>
													</td>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->remark?>
													</td>
													<?php 
														array_push($con_array,$product_data[$i]->con_entry);
													}
													?>
													<td style="text-align:center">
													 <?=$product_data[$i]->model_name?>
													</td>
													<td style="text-align:center">
														<?=$product_data[$i]->size_type_mm?> <br>[<?=$product_data[$i]->pcs_per_box?> PCS = <?=$product_data[$i]->sqm_per_box?> SQM]
														 
													</td> 
													<td style="text-align:center">
													 <?=$product_data[$i]->batch_no?>
													</td>
													<td style="text-align:center">
													 <?=$product_data[$i]->shade_no?>
													</td>
												 <?php 
													if($product_data[$i]->no_of_pallet>0)
													{
														echo '<td style="text-align:center"> '.$product_data[$i]->no_of_pallet.'</td>';
														$Total_plts += $product_data[$i]->no_of_pallet;
											 
													}
													else if($product_data[$i]->no_of_big_pallet>0 || $product_data[$i]->no_of_small_pallet>0)
													{
														echo '<td style="text-align:center"> '.$product_data[$i]->no_of_big_pallet.'
																	<br>
																	'.$product_data[$i]->no_of_small_pallet.'
																	</td>';
														$Total_plts += $product_data[$i]->no_of_big_pallet;
														$Total_plts += $product_data[$i]->no_of_small_pallet;
											 $no_of_row--;
													}
												 ?>
													<td style="text-align:center"> 
														<?=$product_data[$i]->no_of_boxes?>
												  </td> 
													 <td style="text-align:center">
														<?=$product_data[$i]->no_of_sqm?>
													 </td>
													<td style="text-align:center">
														 <?=$product_data[$i]->updated_net_weight?>
													</td>
													<td style="text-align:center">
														  <?=$product_data[$i]->updated_gross_weight?>
													</td>													 
											  	</tr>
										 		<?php
												echo $sample_str;
											    $Total_sqm 		+= $product_data[$i]->no_of_sqm;
											    $Total_box 		+= $product_data[$i]->no_of_boxes;
												$Total_ammount 	+= $product_data[$i]->product_amt;
											}
											 
											 for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
												<tr>
														<td colspan="4" style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;  </td>
														<td style="border:none;border-right:0.5px solid #333;height: 31px;" > </td>
													 	 <td  style="border:none;border-right:0.5px solid #333;" ></td>
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
											<td colspan="8" rowspan="2" style="font-weight:bold;vertical-align:top;">&nbsp;</td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_pallet; ?></td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_box; ?></td>
											<td  style="font-weight:bold;text-align:center"><?=number_format($Total_sqm,2,'.',''); ?></td>
											<td style="font-weight:bold;text-align:center"> <?=$totalnetweight?> </td>
										  	<td style="font-weight:bold;text-align:center"> <?=$totalgrossweight?> </td>
										 </tr>
									  	 <tr>
												 
											 	<td style="text-align:center">PALLETS</td>
											 	<td style="text-align:center">BOXES</td>
												<td style="text-align:center">SQM</td>
												<td  style="text-align:center"> NET WEIGHT</td>
											 	<td  style="text-align:center">
													 GROSS WEIGHT
												</td>
										 </tr>
										 			 
										 <tr>
												 <td colspan="10" valign="top"> Declaration: We Declare That This Invoice Shows The Actual Price Of The Goods Described &amp; That All Particulars Are True And Correct </td>
										        <td colspan="3"  style="vertical-align:top;text-align:right;font-weight:bold;border-bottom: none;">
													For <?=$company_detail[0]->s_name?>
													<br>
													<br>
													<br>
													<br>
													 
									  	  </td>

										  </tr>	
										<tr>
											<td colspan="10" align="center"> 
												CERTIFY THAT GOODS ARE OF 
												"INDIAN ORIGIN"											</td>
											<td colspan="3"  style="vertical-align:bottom;text-align:right;font-weight:bold;border-top: none;">
												 
													  <?=nl2br($company_detail[0]->authorised_signatury)?>  <br>
										  </td>
										</tr>
							  </table>
										
										<?php 
										
										}
										?>										 
<pagebreak />					 
										<h4 style="text-align:center;"><strong style="font-size:20px;">ANNEXURE</strong></h4>
												 
													<table cellspacing="0" cellpadding="0" width="100%" class="pdf_class" style="padding:7px;">
														 	 <tr>
														 	   <td align="center">OFFICE OF THE SUPERITENTNDENT OF GST- MORBI	<br />									
AR-IV, MORBI. DIVISION-I MORBI. COMMISSIONERATE-RAJKOT.&nbsp;</td>
											 	      </tr>
													</table>
													<table cellspacing="0" cellpadding="0" width="100%" class="pdf_class" >
														<tr>
															<td style="padding:0px;" width="5%"></td>
															<td style="padding:0px;" width="42%"></td>
															<td style="padding:0px;" width="5%"></td>
															<td style="padding:0px;" width="6%"></td>
															<td style="padding:0px;" width="42%"></td>
													 	</tr>
														<tr>
															<td colspan="6" style="text-align:center">&nbsp;</td>
														</tr>
														 
														<tr>
																<td style="border-right:none;text-align:center;vertical-align:top"> 
																	1
																</td>
																<td style="vertical-align:top;border-right:none;border-left:none"> 
																	<strong>Name of Exporters</strong>					
																</td>
																<td style="border-right:none;border-left:none;vertical-align:top;"> 
																	:				
																</td>
																<td colspan="2" style="border-left:none;"><?=$export?>						
																</td>
														</tr>
														<tr>
															<td style="border-bottom:none;border-right:none;border-top:none;text-align:center" valign="top"> 
																	2				
															</td>
															<td style="border:none;" valign="top"> <strong>a) L.E. Code No.</strong></td>
															<td valign="top" style="border:none"> 
															:
															</td>
															<td style="border-bottom:none;border-top:none;border-left:none;" colspan="2"><span style="vertical-align:top;border-right:none"><strong><strong>IEC Code : </strong>
                                                                  <?=$exporter_iec?>
															</strong><br />
															<strong> PAN NO :</strong>
                                                                <?=$exporter_pan?>
                                                                <br />
                                                                <strong>GSTIN NO : </strong>
                                                                <?=$exporter_gstin?>
                                                                <br />
                                                                <strong> STATE CODE :</strong>
                                                                <?=$company_detail[0]->state_code?>
                                                                <br />
                                                                <strong>ARN : </strong>
                                                                <?=$company_detail[0]->s_lutno?>
															</span></td>
														</tr>
														<tr>
															<td  style="border-right:none;border-top:none;"> </td>
															<td style="border-right:none;border-left:none;border-top:none"> 
																<strong>b) Branch Code	</strong>				
															</td>
															<td style="border-right:none;border-left:none;border-top:none">  : </td>
															<td colspan="2" style="border-top:none;border-left:none;"> 
																	<?=$annexuredata->branch_code?>
															</td>
														</tr>
														<tr>
														  <td  style="border-right:none;border-top:none;"></td>
														  <td style="border-right:none;border-left:none;border-top:none"><strong>c) Bin No.</strong></td>
														  <td style="border-right:none;border-left:none;border-top:none"><span style="border-right:none;border-top:none;border-left:none">: </span></td>
														  <td colspan="2" style="border-top:none;border-left:none;"><span style="vertical-align:top;border-right:none">
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
															<td style="border-right:none;border-top:none;text-align:center"> 
																	<?=($no==1)?"3":""?>				
															</td>
																<td style="border-right:none;border-top:none;border-left:none"> 
																	<?=($no==1)?"<strong>Name & Address of Manufacturer</strong>":""?>	
																</td>
																<td style="border-right:none;border-top:none;border-left:none"> 
																	:	
																</td>
																<td colspan="2" style="border-top:none;border-left:none;"> 
																	 <?=$sup_row->company_name?>
																</td>
															 </tr>
														<tr>
																<td style="border-right:none;border-top:none;text-align:center;vertical-align:top;">
																<?=($no==1)?"":""?>	
																</td>
																<td style="vertical-align:top;border-right:none;border-top:none;border-left:none"> 
																	<?=($no==1)?" ":""?>	
																</td>
																<td style="vertical-align:top;border-right:none;border-top:none;border-left:none"> 
																	:	
																</td>
																<td colspan="2" style="border-top:none;border-left:none;"> 
																	 <?=$sup_row->address?>
																	 <br>
																	 GSTIN NO : <?=$sup_row->supplier_gstno?>  <?=$sup_row->supplier_circular_no?>
																</td>
													  </tr>
															<tr>
																<td style="border-right:none;border-top:none;">
																</td>
																<td style="border-right:none;border-top:none;border-left:none"> 
																	<?=($no==1)?"<strong>Invoice No & Date</strong>":""?>	
																</td>
																<td style="border-right:none;border-top:none;border-left:none">
																	:	
																</td>
																<td colspan="2" style="border-top:none;border-left:none;"> 
																	 <?=$sup_row->suppiler_invoice_no?> & <?=date('d/m/Y',strtotime($sup_row->suppiler_invoice_date))?>
																</td>
													  </tr>
															<tr>
															  <td style="border-right:none;border-top:none;"></td>
															  <td style="border-right:none;border-top:none;border-left:none">&nbsp;</td>
															  <td style="border-right:none;border-top:none;border-left:none">&nbsp;</td>
															  <td colspan="2" style="border-top:none;border-left:none;">&nbsp;</td>
													  </tr>
														 
																 <?php 
																 $no++;
																	}
																}
															else
															{
																?>
																<tr>
															<td style="border-right:none;border-top:none;text-align:center"> 
																	<strong>	3		</strong>			
															</td>
																<td style="border-right:none;border-top:none;border-left:none"> 
																	<strong>Name &amp; Address of Manufacture</strong></td>
																<td style="border-right:none;border-top:none;border-left:none"> 
																	:	
																</td>
																<td colspan="2" style="border-top:none;border-left:none;"> 
																	<?=$company_detail[0]->s_name?>
																</td>
															 </tr>
															 	<tr>
																<td style="border-right:none;border-top:none;vertical-align:top;">&nbsp;</td>
																<td style="vertical-align:top;border-right:none;border-top:none;border-left:none"> 
																	<strong>Factory Address</strong>
																</td>
																<td style="vertical-align:top;border-right:none;border-top:none;border-left:none"> 
																	:	
																</td>
																<td colspan="2" style="border-top:none;border-left:none;"> 
																	 <?=$company_detail[0]->s_address?>
																</td>
															 </tr>
														 
															 <?php
															}
															 ?> 
														 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center"> 
																	4
																</td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> 
																	<strong>Central Excise Reg. No. of Supporting</strong>
																</td>
																 
													  </tr>
															 <tr>
																<td style="border-right:none;border-top:none;"> </td>
																
																<td style="border-right:none;border-top:none;border-left:none">
																	<strong>Date of Examination </strong>
																</td>
																<td style="border-right:none;border-top:none;border-left:none">
																	 :
																</td>
																<td colspan="2" style="border-top:none;border-left:none;"> 
																	<?=$annexuredata_examination_date?>
																</td>
																 
															 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center"> 5</td>
																
																<td style="border:none">
																	<strong>Name & Desgination </strong>
																</td>
																<td style="border:none">
																	 :
																</td>
																<td colspan="2" style="border-bottom:none;border-top:none;border-left:none;"> 
																	<?=$annexuredata->name_of_inspector?>
															   </td>
																 
															 </tr>
															  <tr>
																<td style="border-right:none;border-top:none;">  </td>
																
																<td colspan="4" style="border-left:none;border-top:none;">
																	<strong>of the Examining Officer -Inspector/EO/PO</strong>
 
																</td>
															</tr>
															<tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">6</td>
																<td style="border:none"> <strong>Name & Desgination </strong> </td>
																<td style="border:none"> : </td>
																<td colspan="2" style="border-bottom:none;border-left:none;border-top:none;">  
																	 <?=$annexuredata->name_of_superintendent?>
																</td>
												 	  </tr>
															  <tr>
																<td style="border-right:none;border-top:none;">  </td>
																
																<td colspan="4" style="border-left:none;border-top:none;">
																	<strong>of the Supervising officer – Appraiser/Superintendent</strong>
																</td>
															</tr>
															<tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">7</td>
																<td style="border:none" colspan="2"> <strong>a)Name of Commissonerate / Division / Range</strong></td>
																<td style="border:none"> : </td>
																<td style="border-bottom:none;border-left:none;border-top:none;"> 
																	<?=implode(",",$export_range); ?> 																	</td>
												 	  </tr>
															 <tr>
																<td style="border-right:none;border-top:none;"></td>
																<td style="border-right:none;border-top:none;border-left:none"  colspan="2"> <strong>b) Location Code </strong></td>
																<td style="border-right:none;border-top:none;border-left:none" > : </td>
																<td style="border-left:none;border-top:none;"> 
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
																<td style="border:none" > : </td>
																<td style="border-bottom:none;border-left:none;border-top:none;">  </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"> </td>
																<td style="border:none"  colspan="2"><strong>a) Export Invoice No.</strong></td>
																<td style="border:none" > : </td>
																<td style="border-bottom:none;border-left:none;border-top:none;">  <?=$invoicedata->export_invoice_no?>, <?=date('d/m/Y',strtotime($invoicedata->invoice_date))?> </td>
														 	 </tr>
															  <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border:none" colspan="2">
																	<strong>b) Total No. of Packages </strong>
																</td>
																<td style="border:none"> : </td>
																<td style="border-bottom:none;border-left:none;border-top:none;">  <?=$Total_box?> BOXES, <?=$Total_pallet?> Pallets</td>
														 	 </tr>
															 <tr>
																<td style="border-right:none;border-top:none;vertical-align:top"></td>
																<td style="border-right:none;border-top:none;border-left:none;vertical-align:top"colspan="2"  > <strong>c) Name and address of the consignee</strong> </td>
																<td style="border-right:none;border-top:none;border-left:none;vertical-align:top" > : </td>
																<td style="border-left:none;border-top:none;"> <?=$consign_address?> </td>
														 	 </tr>
															  <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">9</td>
																<td colspan="3" style="border:none" > <strong>(a) Is the description of the goods the Quantity and their value as per particulars furnished in the export Invoice? </strong></td>
																 
																<td style="border-bottom:none;border-left:none;border-top:none;">  <?=($annexuredata->description_goods_status==1)?"YES":"N/A"?>  </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border:none"  colspan="3"> <strong> (b) Whether sample is drawn for being forwarded to port of Export </strong></td>
																 
																<td style="border-bottom:none;border-left:none;border-top:none;">   <?=($annexuredata->drawn_port_export==1)?"YES":"N/A"?>  </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> <strong> (c) If yes, the number of the seal of the package containing the sample </strong> </td>
																 
																 
														 	 </tr>
															 <tr>
																<td style="border-right:none;border-top:none;"></td>
																<td style="border-right:none;border-top:none;border-left:none"  colspan="3"> <strong> (d) Whether Cenvat Availed or Not 9. Central Excise / Custom Seal Nos </strong></td>
																 
																<td style="border-left:none;border-top:none;">  <?=($annexuredata->seal_yesno==1)?"YES":"N/A"?> </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">10</td>
																<td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> <strong>Central Excise / Custom Seal Nos.</strong></td>
																 
																 
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border:none" colspan="2"> <strong>a) For Non containerized Cargo  no. of Packages. </strong></td>
																 
																<td style="border:none"> : </td>
																<td style="border-bottom:none;border-left:none;border-top:none;"> <?=$annexuredata->seal_no?> </td>
														 	 </tr>
															 <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border:none" colspan="2"><strong>b) For containerized Cargo</strong></td>
																 <td style="border:none"> : </td>
																<td style="border-bottom:none;border-left:none;border-top:none;"> <?=$annexuredata->containerized_cargo?></td>
														 	 </tr>
															  <tr>
																<td style="border-bottom:none;border-right:none;border-top:none;"></td>
																<td style="border-bottom:none;border-left:none;border-top:none;" colspan="5"><strong>c) Containor Details</strong></td>
															 </tr>
									 							 
										</table>
							  <table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class">
										<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="12%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="5%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="7%"></td>
								</tr>                          
											<tr>
												<td colspan="4" style="text-align:center;font-weight:bold">
												Marks & NOS		
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
												 ?>
												</td>
												 
												<td colspan="4" style="text-align:center;font-weight:bold">
													DESCRIPTION OF GOODS
												</td>
												<td colspan="3" style="text-align:center;font-weight:bold"> 
													QUANTITY
												</td>
												<td colspan="2" style="text-align:center;font-weight:bold">
													APPROX
												</td>
										 	</tr>
										 	 <tr>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													CONTAINER NO.</td> 
												<td rowspan="2" style="text-align:center;font-weight:bold">
													LINE SEAL NO.
												</td>
												 <td rowspan="2" style="text-align:center;font-weight:bold">
													RFID SEAL NO.
												</td>
												 <td rowspan="2" style="text-align:center;font-weight:bold">
													PALLET NO.
												</td>  
												<td  colspan="4" style="text-align:center;font-weight:bold">
													<?php
													 
													$no=1;
													for($ser=0;$ser<count($series_name_array);$ser++)
													{
														if(!empty($series_name_array[$ser]))
														{
															echo $series_name_array[$ser].'<br>';
														}
													}
											 	 ?>
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold"> 
													PALLETS
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													BOXES
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													SQM
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													NET WEIGHT
												</td>
												<td rowspan="2" style="text-align:center;font-weight:bold">
													GROSS WEIGHT
												</td>
										 	</tr>
											<tr>
												  <td style="text-align:center;font-weight:bold">
													DESIGN/ITEM NAME
												</td>
												  
												 <td style="text-align:center;font-weight:bold">
													SIZE
												</td>
												<td style="text-align:center;font-weight:bold">
													BATCH NO.</td>
												<td style="text-align:center;font-weight:bold">
													SHADE NO.
												</td>
										 	</tr>
											<?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_ammount = 0;
											$setcontainer = 0;
											$packingtrn_array = array();
											$con_entry = 1;
										 	$con_array = array();
											$conarray = array();
											 $no_of_row = 15;
											 		
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												for($i=0; $i<count($product_data);$i++)
												{
												$sample_str = '';	  
											  	?>
												<tr>
													<?php
												 
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowcon_no > 1)?$product_data[$i]->rowcon_no:'';
														
															if(empty($sample_str))
															{
																$rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																		$sample_str .= '<tr>
																						 <td colspan="3"  style="text-align:center">
																						 	'.$sample_des.'
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
																						 <td style="text-align:center">
																						 	 '.$sample_row->netweight.'
																						 </td>
																						 <td style="text-align:center">
																						 	 '.$sample_row->grossweight	.'
																						 </td>
																						</tr> ';
																		$Total_plts		+= $sample_row->no_of_pallet;
																		$Total_sqm 		+= $sample_row->sqm;
																		$Total_box 		+= $sample_row->no_of_boxes;
																		$Total_ammount 	+= $sample_row->sample_amout;
																		 $no_of_row--;
																 }
																 
															}
														 
												 	?>
													
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->container_no?>
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->seal_no?> 
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														<?=$product_data[$i]->self_seal_no?>
													</td>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->remark?>
													</td>
													<?php 
														array_push($con_array,$product_data[$i]->con_entry);
													}
													?>
													<td style="text-align:center">
													 <?=$product_data[$i]->model_name?>
													</td>
													<td style="text-align:center">
														<?=$product_data[$i]->size_type_mm?> <br>[<?=$product_data[$i]->pcs_per_box?> PCS = <?=$product_data[$i]->sqm_per_box?> SQM]
														 
													</td> 
													<td style="text-align:center">
													 <?=$product_data[$i]->batch_no?>
													</td>
													<td style="text-align:center">
													 <?=$product_data[$i]->shade_no?>
													</td>
												 <?php 
													if($product_data[$i]->no_of_pallet>0)
													{
														echo '<td style="text-align:center"> '.$product_data[$i]->no_of_pallet.'</td>';
														$Total_plts += $product_data[$i]->no_of_pallet;
											 
													}
													else if($product_data[$i]->no_of_big_pallet>0 || $product_data[$i]->no_of_small_pallet>0)
													{
														echo '<td style="text-align:center"> '.$product_data[$i]->no_of_big_pallet.'
																	<br>
																	'.$product_data[$i]->no_of_small_pallet.'
																	</td>';
														$Total_plts += $product_data[$i]->no_of_big_pallet;
														$Total_plts += $product_data[$i]->no_of_small_pallet;
											 $no_of_row--;
													}
												 ?>
													<td style="text-align:center"> 
														<?=$product_data[$i]->no_of_boxes?>
												  </td> 
													 <td style="text-align:center">
														<?=$product_data[$i]->no_of_sqm?>
													 </td>
													<td style="text-align:center">
														 <?=$product_data[$i]->updated_net_weight?>
													</td>
													<td style="text-align:center">
														  <?=$product_data[$i]->updated_gross_weight?>
													</td>													 
											  	</tr>
										 		<?php
												echo $sample_str;
											    $Total_sqm 		+= $product_data[$i]->no_of_sqm;
											    $Total_box 		+= $product_data[$i]->no_of_boxes;
												$Total_ammount 	+= $product_data[$i]->product_amt;
											}
											 
											 ?>		
										 <tr>
											<td colspan="8" rowspan="2" style="font-weight:bold;vertical-align:top;">&nbsp;</td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_pallet; ?></td>
										 	<td  style="font-weight:bold;text-align:center"><?=$Total_box; ?></td>
											<td  style="font-weight:bold;text-align:center"><?=number_format($Total_sqm,2,'.',''); ?></td>
											<td style="font-weight:bold;text-align:center"> <?=$totalnetweight?> </td>
										  	<td style="font-weight:bold;text-align:center"> <?=$totalgrossweight?> </td>
										 </tr>
									  	 <tr>
												 
											 	<td style="text-align:center">PALLETS</td>
											 	<td style="text-align:center">BOXES</td>
												<td style="text-align:center">SQM</td>
												<td  style="text-align:center"> NET WEIGHT</td>
											 	<td  style="text-align:center">
													 GROSS WEIGHT
												</td>
										 </tr>
						      </table>
								<table width="100%"  cellspacing="0" cellpadding="0" class="pdf_class">		 
									 		<?php
												if($company_detail[0]->s_c_type == "Merchant")
												{
													$no =1;
													foreach($export_supplier_data as $sup_row)
													{ 
																 ?>
										<tr>
												<td width="5%" style="border-bottom:none;border-right:none;border-top:none;text-align:center">11</td>
												<td width="20%" style="border:none;"><strong>Costom Permission No.</strong></td>
												<td width="40%" style="border-bottom:none;border-left:none;border-top:none;">
														 <?=$sup_row->permission_no?>, Date : <?=date('d/m/Y',strtotime($sup_row->permission_date))?>
												</td>
												 
								  </tr>
											<tr>
												<td style="border-bottom:none;border-right:none;border-top:none;"> </td>
												<td style="border:none;vertical-align:top"><strong>Issuing Authority & Address	</strong> </td>
												<td  style="border-bottom:none;border-left:none;border-top:none;">
														<?=$sup_row->issue_authority_address?>  
												</td>
												 
											</tr>
											 <?php 
													$no++;
													}
												}
													else
													{
														?>
													<tr>
														<td width="5%" style="border-bottom:none;border-right:none;border-top:none;text-align:center">11</td>
														<td width="20%" style="border:none;">Costom Permission No.</td>
														<td width="40%" style="border-bottom:none;border-left:none;border-top:none;">
														 <?=$company_detail[0]->permission_no?>, Date : <?=date('d/m/Y',strtotime($company_detail[0]->permission_date))?>
												</td>
												 
											</tr>
											<tr>
												<td style="border-bottom:none;border-right:none;border-top:none;"> </td>
												<td style="border:none;vertical-align:top"><strong>Issuing Authority & Address	</strong> </td>
												<td  style="border-bottom:none;border-left:none;border-top:none;">
														<?=$company_detail[0]->issue_authority_address?>  
												</td>
												 
											</tr>	
														
														<?php
														
													}
													?>
										
								   <tr>
												<td colspan="3" style="text-align:center;font-weight:bold"> I / WE HAVE OPENED & EXAMINED THE PACKAGES AS PRESCRIBED & VERIFIED THE CONTAINER TO BE EMPTY BEFORE STUFFING &THEN AFTER GRANT PERMISSION FOR STUFFING THE CONTAINER THEN SEALING DONE UNDER OUR DIRECT SUPERVISION.</td>
												 
												 
											</tr>
											<tr>
												<td style="border-bottom:none;border-right:none;border-top:none;text-align:center">12</td>
												<td style="border-bottom:none;border-left:none;border-top:none;" colspan="2">
												 EXPORT UNDER GST CIRCULAR No.: <?=$company_detail[0]->gst_circular_no?>, CUSTOM DATED : <?=$company_detail[0]->date_of_filing?> </td>
												 
												 
								  </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">13</td>
											  <td colspan="2" style="border:none;">LETTER OF UNDERTACKING Application reference Number (ARN) : <span style="vertical-align:top;">
											    <?=$company_detail[0]->s_lutno?>
											  </span></td>
								  </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
											  <td colspan="2" style="border:none;">Examined the export goods covered under this invoice description of the goods with reference to DBK & MEIS SCHME Value cap P/kg.Net Weight of CERAMIC TILES are as under.												
&nbsp;</td>
								  </tr>
											<tr>
												<td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
												<td style="border:none;"><strong>Net Weight</strong> : <?=$totalnetweight?> KGS</td>
												<td style="border-bottom:none;border-left:none;border-top:none;">
													<strong>Gross Weight</strong> : <?=$totalgrossweight?> KGS 
												</td>
												 
								  </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
											  <td colspan="2" style="border:none;">EXPORT UNDER SELF SEALING UNDER Circular No.</td>
								  </tr>
											<tr>
											  <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
											  <td colspan="2" style="border:none;"> Certified that the description and value of the goods coverd by this invoice have been checked by me and the goods have been packed and seales with lead seal / One     Time RFID Lock Seal.</td>
								  </tr>
											<tr>
												<td colspan="3" style="padding-left:20px"> 
												 
												FOR, <?=$company_detail[0]->s_name?>
													<br>
													<br>
													<br>
													<br>
												 
													<br>
													<?=nl2br($company_detail[0]->authorised_signatury)?> </td>
												 
											</tr>
						 	  </table>
								
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


