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
															<a class="tooltips" data-toggle="tooltip" data-title="Only Invoice Packing" href="<?=base_url('exportinvoiceview/onlyinvoicepacking/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  Only Invoice Packing</a>
														</li> 
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="Only Invoice Annexure" href="<?=base_url('exportinvoiceview/onlyinvoiceannexure/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  Only Invoice Annexure</a>
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
									<a href="javascript:;" style="color:#fff" class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i class="fa fa-pencil fa-lg"></i></a>
									<a href="javascript:;" class="invoice_update_btn btn btn-success" style="display:none;color:#fff" onclick="edit_invoice();">Update</a>
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
                    <td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;"> EXPORT INVOICE </td>
                  </tr>
                  <tr>
                    <td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;"><?php

													if($invoicedata->igst_status==1)

													{

													?>
                      "SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING (LUT) WITHOUT PAYMENT OF INTEGRATED TAX (IGST)"
                      <?php }

													else{?>
                      "SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING ( LUT) WITH PAYMENT OF INTEGRATED TAX (IGST)"
                      <?php }?></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="font-weight:bold"> Consignor/Exporter/Manufacturer:</td>
                    <td><span style="font-weight:bold">Exporter Invoice No. &amp; Date :</span></td>
                    <td><?=$exportinvoice_no?></td>
                    <td colspan="2"><?=$export_date?></td>
                  </tr>
                  <tr>
                    <td rowspan="3" style="vertical-align:top;border-right:none"><?=$export?></td>
                    <td  rowspan="3" style="vertical-align:top;border-left:none"><span style="vertical-align:top;border-right:none"> <strong>GST No : </strong>
                      <?=$exporter_gstin?>
                      <br />
                      <strong>IEC No : </strong>
                      <?=$exporter_iec?>
                      </span> <span style="vertical-align:top;border-right:none"> <strong><br />
                      PAN No : </strong>
                      <?=$exporter_pan?>
                      <br />
                      <strong>STATE CODE  : </strong>
                      <?=$company_detail[0]->state_code?>
                      <strong><br />
                      Email :</strong>
                      <?=$exporter_email?>
                      <?php 

													if(!empty($invoicedata->aeo_no))

													{

													?>
                      <br />
                      <strong> AEO No :</strong>
                      <?=$invoicedata->aeo_no?>
                      <?php 

													}

													?>
                      <?php 

													if(!empty($invoicedata->lei_no))

													{

													?>
                      <br />
                      <strong> LEI No :</strong>
                      <?=$invoicedata->lei_no?>
                      <?php 

													}

													?>
                      </span></td>
                    <td   style="font-weight:bold" valign="top">  PI No. &amp; Date : </td>
                    <td valign="top"><?=$export_ref_no?></td>
                    <td  colspan="2" valign="top"><?=$performa_date?></td>
                  </tr>
                  <tr>
                    <td   style="font-weight:bold" valign="top">Buyer's order No. / Date : </td>
                    <td  colspan="3"   valign="top"><?=$buy_order_no?></td>
                  </tr>
                  <tr>
                    <td colspan="4"  valign="top"><?php

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
                      <strong>Manufacturer Name & GST No :&nbsp;</strong>
                      <?=$sup_row->company_name?>
                      &
                      <?=$sup_row->supplier_gstno?>
                      <br>
					  <?php 
					  if(!empty($sup_row->suppiler_invoice_no))
					  {
						  ?>
						<strong>Invoice No  & Date :&nbsp;</strong>
						<?=$sup_row->suppiler_invoice_no?>
						<?=$suppiler_date?>
					  <?php 
					  }
					  ?>
                      <?=(empty($sup_row->epcg_no))?"":"EPCG NO :".$sup_row->epcg_no?>
                      <?=(empty($sup_row->epcg_date) || $sup_row->epcg_date == '1970-01-01')?"":"& DATE :".date('d/m/Y',strtotime($sup_row->epcg_date))?>
                      <?php 

														     

 

																 $no++;

																	}

															}

																}

																

																?></td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><strong>Consignee : </strong><br>
                      <?=$consign_address?></td>
                    <td colspan="2" valign="top"><strong>Buyer's if other than Consignee (Notify Party) :</strong> <br />
                      <span style="vertical-align:top">
                      <?=$buyer_other_consign?>
                      </span></td>
                    <td colspan="2"   style="vertical-align:top"><span style="vertical-align:top;"> <span style="font-weight:bold"> <strong>Bank Details</strong><br />
                      </span>
                      <?=$bank_detail?>
                      </span></td>
                  </tr>
                  <tr>
                    <td style="font-weight:bold"> Pre Carriage By</td>
                    <td style="font-weight:bold"> Place of Receipt</td>
                    <td style="font-weight:bold">Country of Origin of Goods </td>
                    <td style="font-weight:bold" colspan="3"><span style="vertical-align:top"> Country of Final Destination </span></td>
                  </tr>
                  <tr>
                    <td><?=$pre_carriage_by?></td>
                    <td><?=$place_of_receipt?></td>
                    <td><span style="vertical-align:top">
                      <?=$country_origin_goods?>
                      </span></td>
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
                    <td><span style="vertical-align:top">
                      <?=$flight_name_no?>
                      </span></td>
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
                    <td><span style="vertical-align:top"><strong>District Of Origin : </strong>
                      <?=$district_of_origin?>
                      </span></td>
                    <td><strong>State of Origin : </strong>
                      <?=$state_of_origin?></td>
                    <td valign="top"><span style="font-weight:bold">Terms of Delivery &amp;     Payment :</span></td>
                    <td colspan="3" valign="top">Delivery  Terms :
                      <?=$invoicedata->terms_name?>
                      -
                      <?=$export_terms_of_delivery?>
                      <br />
                      Payment Terms :
                      <?=$export_payment_terms?></td>
                  </tr>
                </table>
                <table  width="100%" cellspacing="0" cellpadding="0" style="padding:5px" class="pdf_class invoice_edit_cls" contenteditable="false">
                  <tr>
                    <td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                  </tr>
                  <tr>
                    <td rowspan="2" style="text-align:center;font-weight:bold">SHIPPING MARKS &amp; NOS.</td>
                    <td colspan="2" rowspan="2" style="text-align:center;font-weight:bold">DESCRIPTION OF GOODS</td>
                    <td colspan="5" style="text-align:center;font-weight:bold"> QUANTITY </td>
                    <td colspan="2" style="text-align:center;font-weight:bold"> AMOUNT </td>
                  </tr>
                  <tr>
                    <td style="text-align:center;font-weight:bold">PCS PER BOX</td>
                    <td style="text-align:center;font-weight:bold">SQM PER BOX</td>
                    <td style="text-align:center;font-weight:bold">PALLETS</td>
                    <td style="text-align:center;font-weight:bold">TOTAL BOXES</td>
                    <td style="text-align:center;font-weight:bold"> TOTAL SQUARE METER </td>
                    <td style="text-align:center;font-weight:bold"> PRICE IN SQUARE METER -
                      <?=$invoicedata->currency_name?></td>
                    <td style="text-align:center;font-weight:bold"> TOTAL VALUE IN
                      <?=$invoicedata->currency_name?></td>
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
                    <td rowspan="<?=$rowspan?>" style="text-align:center;border-bottom:hidden"><?php

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
                      ----------- <br />
                      TOTAL<br />
                      <?=($Total_pallet == 0)?" ":$Total_pallet.'<span style="text-align:center;font-weight:bold"> PALLETS<br></span>' ?>
                      <?=$Total_box?>
                      <span style="text-align:center;font-weight:bold"> BOXES</span></td>
                    <?php

													  }

													  ?>
                    <td style="text-align:center" colspan="2"><?php

														 

															if(!empty($product_desc_array[$product_desc_array[$p]]['size_type_mm']))

															{

															?>
                      <?=$product_desc_array[$product_desc_array[$p]]['product_name']?>
                      <br />
                      Tiles Size :
                      <?=$product_desc_array[$product_desc_array[$p]]['size_type_mm']?> - <?=$product_desc_array[$product_desc_array[$p]]['thickness']?>mm
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

																	?></td>
                    <td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['pcs_per_box']?></td>
                    <td style="text-align:center"><?=number_format($product_desc_array[$product_desc_array[$p]]['sqm_per_box'],2)?></td>
                    <?php 

															if(!empty($product_desc_array[$product_desc_array[$p]]['export_make_pallet_no']))

															{

															?>
                    <td style="text-align:center" rowspan="<?=!empty($product_desc_array[$product_desc_array[$p]]['export_rowspan'])?$product_desc_array[$product_desc_array[$p]]['export_rowspan']:""?>"><?php

																if($product_desc_array[$product_desc_array[$p]]['no_of_pallet'] > 0)

																{

																	echo number_format($product_desc_array[$product_desc_array[$p]]['no_of_pallet'],1);

																}

																else if($product_desc_array[$product_desc_array[$p]]['no_of_big_pallet'] > 0 || $product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'] > 0)

																{

																	echo number_format($product_desc_array[$product_desc_array[$p]]['no_of_big_pallet'],1)."<br>".$product_desc_array[$product_desc_array[$p]]['no_of_small_pallet'];

																}

																else 

																{

																	echo "-";

																}

															}

															else if(empty($product_desc_array[$product_desc_array[$p]]['export_half_pallet']))

														 	{

																 

																?>
                    <td style="text-align:center" rowspan="<?=!empty($product_desc_array[$product_desc_array[$p]]['export_rowspan'])?$product_desc_array[$product_desc_array[$p]]['export_rowspan']:""?>"><?php

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

															$product_rate 	= $product_desc_array[$product_desc_array[$p]]['product_rate'];

															$product_amt 	= $product_desc_array[$product_desc_array[$p]]['amount'];

															$performa_per 	= $product_desc_array[$product_desc_array[$p]]['performa_per'];

															 

															//if($performa_per == "SQF")

															//{

															//	$feet =  $product_desc_array[$product_desc_array[$p]]['boxes'] * $product_desc_array[$product_desc_array[$p]]['feet_per_box'];

															//	

															//	$product_rate = $product_amt/$feet;

															//}

															//else if($performa_per == "BOX")

															//{

															//	$box =  $product_desc_array[$product_desc_array[$p]]['boxes'];

															//	$product_rate = $product_amt/$box;

															//}

															//else if($performa_per == "SQM")

															//{

															//	$sqm =  $product_desc_array[$product_desc_array[$p]]['sqm'];

															//	$product_rate = $product_amt/$sqm;

															//}

															//else if($performa_per == "PCS")

															//{

															//	$pcs =  $product_desc_array[$product_desc_array[$p]]['boxes'] * $product_desc_array[$product_desc_array[$p]]['pcs_per_box'];

															//	$product_rate = $product_amt/$pcs;

															//}

																?></td>
                    <td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['boxes']?></td>
                    <td style="text-align:center"><?=number_format($product_desc_array[$product_desc_array[$p]]['sqm'],2,'.','')?></td>
                    <td style="text-align:center"><?=$currency_symbol?>
                      <?=number_format($product_rate,2)?></td>
                    <td style="text-align:center"><span style="text-align:center">
                      <?=$currency_symbol?>
                      <?=number_format($product_desc_array[$product_desc_array[$p]]['amount'],2,'.','')?>
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
                    <td style="font-weight:bold;text-align:center;border-bottom:hidden" colspan="2"> Sample </td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;font-weight:bold;border-bottom:hidden"></td>
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
                    <td style="border-right:0.5px solid #333;text-align:center" colspan="2"><?=$jsondata->product_size_id?>
                      -
                      <?=$jsondata->sample_remarks?></td>
                    <td  style="border-right:0.5px solid #333;text-align:center" > - </td>
                    <td  style="border-right:0.5px solid #333;text-align:center" > - </td>
                    <td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->no_of_pallet?></td>
                    <td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->no_of_boxes?></td>
                    <td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->sqm?></td>
                    <td  style="border-right:0.5px solid #333;text-align:center"><?=!empty($jsondata->sample_rate)?$currency_symbol.$jsondata->sample_rate:"FOC"?></td>
                    <td style="border-right:0.5px solid #333;text-align:center"><?=!empty($jsondata->sample_amout)?$currency_symbol.$jsondata->sample_amout:"FOC"?></td>
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
                    <td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;</td>
                    <td colspan="2" style="border:none;border-right:0.5px solid #333;height: 31px;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td> 
					<td  style="border:none;border-right:0.5px solid #333;"></td>
                  </tr>
                  <?php

											$no_of_row--;

											}

										?>
                  <tr>
                    <td colspan="5" rowspan="2" bgcolor="#000000" style="font-weight:bold;vertical-align:middle; text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><span style="color: #FFF;"> THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT)  :
                      <?=$company_detail[0]->s_lutno?>
                      <?php

													if($invoicedata->igst_status==1)

													{

													?>
													<?php

													}

													else 

													{

													?>
                      <br />
                      WITH PAYMENT OF IGST - 18% GST AMOUNT :
                      <?=number_format($invoicedata->indian_ruppe_after_gst,2,'.','')?>
                      <?php }  ?>
                      </span></td>
                    <td  style="font-weight:bold;text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=($Total_pallet == 0)?"-":$Total_pallet; ?></td>
                    <td  style="font-weight:bold;text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=$Total_box; ?></td>
                    <td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center; color: #000;border-top:0.5px solid #333;border-right:0.5px solid #333;"><span style="font-weight:bold;text-align:center">
                      <?=number_format($Total_sqm,2,'.',''); ?>
                      </span></td>
                    <td rowspan="2" style="font-weight:bold; text-align:center; color:#000;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=($invoicedata->calculation_operator == 2)? $invoicedata->terms_name: 'FOB';?>
                      &nbsp;Value </td>
                    <td rowspan="2" style="font-weight:bold;text-align:right;color:black;border-top:0.5px solid #333;"><?=$currency_symbol?>
                     <?=number_format($Total_ammount,2,'.',''); ?></td>
                  </tr>
                  <tr>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center"><span style="text-align:center;font-weight:bold">PALLETS</span>&nbsp;</td>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;font-weight:bold;">BOXES</td>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;font-weight:bold;">SQM</td>
                  </tr>
                  <?php

										$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->certification_charge:$Total_amt + $invoicedata->certification_charge;  ?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						<?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      &nbsp;in INR 
					</td>
                    <td  colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" ><span style="font-weight:bold;vertical-align:top;text-align:center">Exchange Rate <strong> </strong></span></td>
                   
				   <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;">
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                      <?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      &nbsp;in
                      <?=$invoicedata->currency_name?>
                      </span>
					</td>
					 
					
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="text-align:center"> CERTIFICATION </span></td>
                    <td style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->certification_charge > 0)?number_format($invoicedata->certification_charge,2,'.',''):"0.00" ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center">
					<?=number_format($invoicedata->indian_ruppe_val,2,'.','')?>
					</td>
                    <td   colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center"> 
						<span style="font-weight:bold;vertical-align:top;text-align:center">
                      <?=number_format($invoicedata->Exchange_Rate_val,2)?>
                      </span>
					</td>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" colspan="3">
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                      <?=number_format($invoicedata->grand_total,2,'.','')?>
                      </span>
					</td>
                     
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;">INSURANCE</td>
                    <td style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->insurance_charge > 0)?number_format($invoicedata->insurance_charge,2,'.',''):"0.00" ?></td>
                  </tr>
                  <?php $Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->insurance_charge:$Total_amt + $invoicedata->insurance_charge;  ?>
                  <tr>
                    <td rowspan="2" colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center"><span style="font-weight:bold;text-align:center;"><span style="text-align:center;font-weight:bold"> Gross Weight</span></span></td>
                    <td rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center"><span style="text-align:center;font-weight:bold">
                      <?=number_format($totalgrossweight,2)?>
                      KGS</span></td>
                    <td rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" colspan="2"><span style="text-align:center;font-weight:bold"> Net Weight </span></td>
                    <td rowspan="2" colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;"><?=number_format($totalnetweight,2)?>
                      KGS</td>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2">FREIGHT</td>
                    <td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->seafright_charge > 0)?number_format($invoicedata->seafright_charge,2,'.',''):"0.00" ?></td>
                  </tr>
				  
                  <tr>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2">BANK CHARGES</td>
                    <td  style="border-bottom:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->bank_charge > 0)?number_format($invoicedata->bank_charge,2,'.',''):"0.00" ?></td>
                  </tr>
                  <?php  $Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->seafright_charge:$Total_amt + $invoicedata->seafright_charge; 

										  $Total_amt += $invoicedata->courier_charge; 

										  $Total_amt += $invoicedata->bank_charge; 

									if(!empty($invoicedata->extra_calc_name))
									{

									 	 ?>
										 <tr>
										  <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"> </td>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2"><?=$invoicedata->extra_calc_name?> <?=($invoicedata->extra_calc_opt == 1)?"+":"-"?></td>
                    <td  style="border-bottom:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=number_format($invoicedata->extra_calc_amt,2,'.','')?></td>
                  </tr>
									<?php
									 $Total_amt =($invoicedata->extra_calc_opt == 1)?$Total_amt + $invoicedata->extra_calc_amt:$Total_amt - $invoicedata->extra_calc_amt; 
									}
									?>
				 <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"></td>
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;border-bottom:0.5px solid #333;text-align:center">COURIER CHARGES</td>
                    <td  style="font-weight:bold;text-align:right"><?=$currency_symbol?>
                      &nbsp;
                      <?=($invoicedata->courier_charge > 0)?number_format($invoicedata->courier_charge,2,'.',''):"0.00" ?></td>
                  </tr>
				 <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"><?=!empty($invoicedata->notification_text)?"(".$invoicedata->notification_text.")":""?></td>
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center">DISCOUNT</td>
                    <td  style="font-weight:bold;text-align:right;border-bottom:0.5px solid #333;"><?=$currency_symbol?>
                      <?=($invoicedata->discount > 0)?number_format($invoicedata->discount,2,'.',''):"0.00" ?></td>
                  </tr>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7">AMOUNT CHARGEABLE IN WORDS <span style="text-align:center">
                      <?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      </span></td>
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;border-bottom:0.5px solid #333;text-align:center">COMMISSION</td>
                    <td  style="font-weight:bold;text-align:right"><?=$currency_symbol?>
                      &nbsp;
                      <?=($invoicedata->commision_amt > 0)?number_format($invoicedata->commision_amt,2,'.',''):"0.00" ?></td>
                  </tr>
				 
                  <?php 
					$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->discount:$Total_amt - $invoicedata->discount; 
					?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"><?=strtoupper(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?>
                      ONLY </td>
                    <td colspan="2" style="border-right:0.5px solid #333;text-align:center"><?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      in
                      <?=$invoicedata->currency_name?></td>
                    <td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol.number_format($invoicedata->grand_total,2,'.','')?></td>
                  </tr>
				  
                  <tr>
                    <td style="border-top:0.5px solid #333;"  colspan="10"><span style="font-weight:bold;vertical-align:top;">
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
                      </span></td>
                  </tr>
                  <tr>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="4"> Self Sealing Declaration <br />
                      (1) Certified That The Description &amp; Value Of Goods Covered By This Invoice Have Been Checked By Me &amp; That Goods Have Been Packed &amp; Sealed With One Time Seal (OTS) Under My Direct Supervision 
                      
                      (2) We Have Follow The Procedure Laid Down In CBEC's Circular No. 426/59/98 CX Dt.12/10/1998 As Amended Against This Shipment&quot; </td>
                    <td height="50" colspan="6" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:right">For
                      <?=$company_detail[0]->s_name?>
                      <br />
                      <br />
                      <br /></td>
                  </tr>
                  <tr>
                    <td style="border-right:0.5px solid #333;border:0.5px solid #333;" colspan="4"><strong><u>Declaration</u></strong>: <br />
                      We declared that this invoice shows the actual price of the goods described & that all particulars are true and correct. <br></td>
                    <td colspan="6" style="text-align:right;border-top:none" valign="bottom"><?=nl2br($company_detail[0]->authorised_signatury)?>
                      <br></td>
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
</script>
