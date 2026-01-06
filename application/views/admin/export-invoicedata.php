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
										<div class="col-sm-4">
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
										</div>&nbsp;
										<div class="col-sm-2">
											<!--<a class="btn btn-warning tooltips" data-title="View in Excel" href="javascript:;"  onclick="toExcel();"   ><i class="fa fa-file"></i> Export Excel</a>-->
										</div>
										
									</div>
								</h3>
								
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							  <div class=" panel-default" id="print_content">
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
                    <td colspan="7"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;">INVOICE</td>
                </tr>
                <tr>
                	<td colspan="3" rowspan="2" valign="top">
                	<p>Exporter</p>
                	<p>
                		<?=$export?>
                	</p>
                    </td>
                	<td colspan="2" valign="top">
                	<p>Invoice No & Date</p>
                	<p>
                		<?=$exportinvoice_no?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    	<?=$export_date?>                    	
                    </p>
                    </td>
                	<td colspan="2" valign="top">
                	<p>Exporter's Ref</p>
                	<p style="text-align: center;">IEC NO. <?=$exporter_iec?></p>
                    </td>
                </tr>
                <tr>
                	<td colspan="4" valign="top">
                		<P>Buyer's Order No. & Date</P>
                		<P>PO NO.</P>
                		<!--<p><?=$invoicedata->export_buy_order_no?></P>-->
                		<p><?=$buy_order_no?></P>
                	</td>                	
                </tr>
                <tr>
                	<td colspan="3" rowspan="2" valign="top">
                		<p>Consignee</p>
                		<p><?=$consign_address?></p>
                	</td>
                	<td colspan="4" valign="top" style="height: 100px;">Buyer (if other than consignee)</td>
                </tr>
                <tr>
                	<td colspan="2" valign="top">
                		<p style="text-align: center;">Country of Orgin of Good</p>
                		<p style="text-align: center;"><?=$country_origin_goods?></p>
                	</td>
                	<td colspan="2" valign="top">
                		<p style="text-align: center;">Country of Final Destination</p>
                		<p style="text-align: center;"><?=$country_final_destination?></p>
                	</td>
                </tr>
                <tr>
                	<td colspan="2" valign="top">
                		<p>Pre - Carriage by</p>
                		<p><?=$pre_carriage_by?></p>
                	</td>
                	<td valign="top">
                		<p>Place of Receipt by Pre-carrier</p>
                		<p><?=$place_of_receipt?></p>
                	</td>
                	<td colspan="4" rowspan="3" valign="top">
                		<p>Terms of Delivery And Payment</p>
                		<p><?=$invoicedata->terms_name?>
                      -
                      <?=$export_terms_of_delivery?>
                      <br />
                      Payment Terms :
                      <?=$export_payment_terms?></td></p>
                	</td>                	               	
                </tr>
                <tr>
                	<td colspan="2" valign="top">Vessel/Flight No</td>
                	<td valign="top">
                		<p>Port of Loading</p>
                		<p><?=$export_port_loading?></p>
                	</td>
                </tr>
                 <tr>
                	<td colspan="2" valign="top">
                		<p>Port of Discharge</p>
                		<p><?=$port_of_discharge?></p>
                	</td>
                	<td valign="top">
                		<p>Final Destination</p>
                		<p><?=$country_final_destination?></p>
                	</td>
                </tr>
                </table>
                <table  width="100%" cellspacing="0" cellpadding="0" style="padding:5px" class="pdf_class invoice_edit_cls" contenteditable="false">
                   <tr>
                	<td valign="top" style="border: none;text-align: center;font-weight:bold;"> Marks & Nos/</td>
                	<td valign="top" style="border: none;text-align: center;font-weight:bold;"> No. &</td>
                	<td valign="top" style="border: none;text-align: center;font-weight:bold;">Kind of Pkgs. </td>
                	<td valign="top" style="border: none;text-align: center;font-weight:bold;">Description of Goods</td>
                	<td valign="top" style="border-bottom: none;text-align: center;font-weight:bold;">Quantity</td>
                	<td valign="top" style="border-bottom: none;text-align: center;font-weight:bold;">Rate</td>
                	<td valign="top" style="border-bottom: none;text-align: center;font-weight:bold;">Amount</td>
                </tr>

                <tr>
                	<td style="border:none; padding-top: 20px;font-weight:bold;" colspan="4" valign="top">Item Description<br>
					<?php
										 		$no=1;
											
												for($p=0;$p<count($product_desc_array);$p++)
												{
													?>
													
													 <?=($no>1)?"<br />":""?>
													 <?php
													if(!empty($product_desc_array[$p]))
													{
											 	 ?>
												   
														
														
														  <?=$product_desc_array[$product_desc_array[$p]]['product_name']?>
														 
														
													  
												<?php
												
											$no++;
													}
												}
												?>
					
					</td>
					
                	<td style="border-top: none; border-bottom: none; padding-top: 20px;text-align:center;font-weight:bold;" valign="top">NUM&nbsp;OF&nbsp;PCS/CONT<br>
					<?php
										 		$no=1;
											
												for($p=0;$p<count($product_desc_array);$p++)
												{
													?>
													
													 <?=($no>1)?"<br />":""?>
													 <?php
													if(!empty($product_desc_array[$p]))
													{
											 	 ?>
												   
														
														
														<?=($Total_pallet * $product_desc_array[$product_desc_array[$p]]['pcs_per_box'])?>
														 
														
													  
												<?php
												
											$no++;
													}
												}
												?>
					
					
					</td>
                	<td style="border-top: none; border-bottom: none; padding-top: 20px;text-align:center;font-weight:bold;" valign="top">PRICE<br>
					<?php
										 		$no=1;
											
												for($p=0;$p<count($product_desc_array);$p++)
												{
													?>
													
													 <?=($no>1)?"<br />":""?>
													 <?php
													if(!empty($product_desc_array[$p]))
													{
											 	 ?>
												   
														
														
														<?=$currency_symbol?>  <?=number_format($product_desc_array[$product_desc_array[$p]]['product_rate'],3,'.',''); ?>
														 
														
													  
												<?php
												
											$no++;
													}
												}
												?>
					
					</td>
                	<td style="border-top: none; border-bottom: none; padding-top: 20px;text-align:center;font-weight:bold;" valign="top"><?=$invoicedata->currency_name?><br>
					<?php
										 		$no=1;
											
												for($p=0;$p<count($product_desc_array);$p++)
												{
													?>
													
													 <?=($no>1)?"<br />":""?>
													 <?php
													if(!empty($product_desc_array[$p]))
													{
											 	 ?>
												   
														
														
														  <?=$currency_symbol?>
														<?=number_format($product_desc_array[$product_desc_array[$p]]['amount'],2,'.','')?>
														 
														
													  
												<?php
												
											$no++;
													}
												}
												?>
					
					</td>
                </tr>
                
             
                 <tr>
                	<td style="border:none;" colspan="4" valign="top">
                		<br><br><br><br><br><br>
                		<!--<p><u>SIZE OF TILE # 12X24 CM</u></p>-->
                		<br><br><br>
                		<p><u>CONTAINER NUMBER     <!--HTS # 6907.21.9051--></u></p>
                		<br>
                		<!--<?php
										 		$no=1;
											
												for($p=0;$p<count($product_desc_array);$p++)
												{
													?>
													
													 <?=($no>1)?"<br />":""?>
													 <?php
													if(!empty($product_desc_array[$p]))
													{
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
											 	 ?>
												   
														
														
													<p style="text-align:center" rowspan="<?=$rowcon_no?>"> <?=$product_desc_array[$product_desc_array[$p]]['container_no']?></p>
														 
														
													  
												<?php
												
											$no++;
													}
												}
												?>-->
												
												
									<?php
										 	$Grand_Total_pallet = 0;
											$Total_pallets = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$cntnet_weight=0;
											//$Total_ammount = 0;
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
													$total_pallets  = floatval($product_data[$i]->total_ori_pallet);
													$Total_pallets  = floatval($product_data[$i]->total_ori_pallet);
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$sample_str = '';	
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
																 $sample_container = 1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																			// $sample_str .= '<tr>
																						 // <td style="text-align:center">
																						 	// '.$sample_row->product_size_id.'
																						 // </td>
																						 // <td style="text-align:center">
																						 	// Sample
																						 // </td>
																					 	 // <td style="text-align:center">
																						 	// '.$sample_row->no_of_boxes.'
																						 // </td>
																						 // <td style="text-align:center">
																						 	// '.$sample_row->no_of_pallet.'
																						 // </td>
																 						// </tr> ';
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
                
                    <p rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->container_no?></p>
                   
                    <?php 
													$no=1;
													array_push($con_array,$product_data[$i]->con_entry);
											  	}
												else
												{
													$sample_container++;
												}
													if($no>1)
													{
														
													}
												if(!empty($product_data[$i]->product_id))
												{
												?>
                  
                    <?php
												}
												else
												{
													
												}
												?>
                   
                   
													 <?php
													if($no>1)
													{
														
													}
										
												if(!in_array($product_data[$i]->con_entry,$conarray))
												{
												?>
                   <!-- <td style="text-align:center;" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->remark?></td>
                    <td style="text-align:center;" rowspan="<?=$rowcon_no?>" ><?=number_format($net_weight,2,'.','')?></td>
                    <td style="text-align:center;" rowspan="<?=$rowcon_no?>" ><?=number_format($gross_weight,2,'.','')?></td>-->
                 
                  <?php 
													array_push($conarray,$product_data[$i]->con_entry);
											  	}
												if($product_data[$i]->rowspan_no == $sample_container) 
												{
													echo $sample_str;
											    }
											    $Total_sqm 		+= $product_data[$i]->no_of_sqm;
												//$Total_ammount 	+= $product_data[$i]->product_amt;
												$no++;
											}
											$no_of_row =1; 
											?>
                		<br>
                		<br>
                		<br>
                		<br>
                		<br>
                		<br>
                		<p>--------------------------------------------------</p>
                		<p>--------------------------------------------------</p>
                    </td>
                	<td style="border-top: none; border-bottom: none;" valign="top"></td>
                	<td style="border-top: none; border-bottom: none;" valign="top"></td>
                	<td style="border-top: none; border-bottom: none;" valign="top"></td>
                </tr>
                <tr>
                	<td style="border:none;" colspan="4" rowspan="2" valign="top"></td>
                	<td style="border-top: none; border-bottom: none;" valign="top"></td>
                	<td style="border-top: none; border-bottom: none;" valign="top"></td>
                	<td style="border-top: none; border-bottom: none;" valign="top"></td>
                </tr>
                <tr>                	
                	<td colspan="2" style="text-align: center;" valign="top">VIP REBATE DISCOUNT <?=$currency_symbol?></td>
                	<td  valign="top"></td>                	
                </tr>
                
                <tr>                	
                	<td colspan="4" style="border-bottom: none; border-right: none;" valign="top">Amount Charges</td>
                	<td colspan="2" style="border-bottom: none;  border-left: none;text-align: center;" valign="top">Total</td>
                	<td  valign="top" style="text-align: center;"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.',''); ?></td>                	
                </tr>

                <tr>                	
                	<td colspan="7" style="border: none;" valign="top"><b><?=strtoupper(convertamonttousd($Total_ammount,$invoicedata->currency_name))?>
 						<br>( U.S. Dollars only)
				</b></td>
                	               	
                </tr>

                <tr>                	
                	<td colspan="3" style="border:none;" valign="top">
                		<p>Declaration:</p>
                		<p>We declare that this Invoice shows the actual price of the goods described and that all particulars are true and correct</p>
                	</td>
                	<td colspan="4" valign="top">Signature & Date</td>
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

function toExcel() {

    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#print_content').html()));
    e.preventDefault();
}
</script>
