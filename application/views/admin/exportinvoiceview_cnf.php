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
 $lc_no 					= $invoicedata->lc_no;
 $idf_no 					= $invoicedata->idf_no;
  $exporter_aeono				= $company_detail[0]->aeo_no;
 $exporter_state_code		= $company_detail[0]->state_code;
   $cin_no		= $company_detail[0]->s_cin;
 $export_house 				= $invoicedata->export_house;
 $contract 					= $invoicedata->contract;
 $bank_detail 				= $invoicedata->bank_detail;    
 $flight_name_no			= $invoicedata->flight_name_no;   				 
 $export_port_loading 		= $invoicedata->port_of_loading;
 $port_of_discharge 		= $invoicedata->port_of_discharge;
 $final_destination 		= $invoicedata->final_destination;
 $district_of_origin 		= $invoicedata->district_of_origin;
 $state_of_origin 			= $invoicedata->state_of_origin;
 $export_payment_terms 		= $invoicedata->payment_terms;
 $no_of_container 			= $invoicedata->container_details;
 $export_terms_of_delivery 	= $invoicedata->terms_of_delivery;
 $container_size 			= $invoicedata->container_size;
 $indian_ruppe_val 			= $invoicedata->indian_ruppe_val;
 $Exchange_Rate_val	 		= $invoicedata->Exchange_Rate_val;
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
th {
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
.profile-pic:hover {
	border: 1px solid #036df0;
}
.edit {
	padding-top: 7px;
	padding-right: 7px;
	position: fixed;
	right: 13px;
	top: 150px; 
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
	else
	{
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
            <li> <i class="clip-pencil"></i> <a href="javascript:void(0)"> Dashboard </a> </li>
            <li class="active"> <a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a> </li>
          </ol>
          <div class="page-header title1">
            <h3>View Export Invoice
              <div class="pull-right form-group">
                <div class="col-sm-5">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="<?=base_url('exportinvoiceview1/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (With Sign)</a> </li> 
                        <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="<?=base_url('exportinvoiceview/index_new/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice New</a> </li> 
					  <!--<li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="<?=base_url('exportinvoiceview/index_cnf/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (CNF)</a> </li>  
			 <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (Nepal)" href="<?=base_url('exportinvoiceview/index_nepal/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Nepal)</a> </li>  
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (Nepal Packing)" href="<?=base_url('exportinvoiceview/index_nepal_packing/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Nepal Packing)</a> </li>  

					  <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Supplier)" href="<?=base_url('exportinvoiceview/index1/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (With Supplier)</a> </li> 
					     <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Batch Shade)" href="<?=base_url('exportinvoiceview/index_batch_shade/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i>Invoice (Batch Shade Format)</a> </li>
					   <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="<?=base_url('exportinvoiceview/invoice_inr/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Inr)</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (KG)" href="<?=base_url('exportinvoiceview/index_kg/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (KG)</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="<?=base_url('exportinvoiceview/other_product/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Other Product)</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="<?=base_url('exportinvoiceview/without_design/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Without Design)</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="Only Invoice" href="<?=base_url('exportinvoiceview/onlyinvoice/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Only Invoice</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="Only Invoice Packing" href="<?=base_url('exportinvoiceview/onlyinvoicepacking/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Only Invoice Packing</a> </li>
					   <li> <a class="tooltips" data-toggle="tooltip" data-title="Only Invoice Packing" href="<?=base_url('exportinvoiceview/onlyinvoicepacking_nodesign/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Only Invoice Packing (No Design)</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="Only Invoice Annexure" href="<?=base_url('exportinvoiceview/onlyinvoiceannexure/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Only Invoice Annexure</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Packing List" href="<?=base_url('exportinvoicepackingview/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-pdf-o"></i> View Packing List (FAMIGATION)</a> </li>
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Loading Pdf" href="<?=base_url('loadingpdf/index/'.$invoicedata->export_invoice_id)?>" target="_blank" ><i class="fa fa-eye"></i> Loading Pdf</a> </li>-->
                    </ul>
                  </div>
                </div>
                <div class="col-sm-4"> <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"><i class="fa fa-file-pdf-o"></i> Export Pdf</a> </div>
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
								$Grand_Total_pallet 		= 0; 
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
								$rowspan 			= 0;
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
													
													
														$count = explode(",",$product_data[$i]->export_make_pallet_no);
														$export_rowspan = count($count);
														 
														if(!empty($product_data[$i]->pallet_ids) || $product_data[$i]->make_pallet_no == 1)
														{
															if(!empty($product_data[$i]->pallet_ids))
															{
																$pallet_ids = explode(",",$product_data[$i]->pallet_row);
															
															$Grand_Total_pallet += $product_data[$i]->make_pallet_no;
															}
														}
														else if(!empty($product_data[$i]->export_make_pallet_no))
														{
															
															
																	$Grand_Total_pallet += $product_data[$i]->export_half_pallet;
														}
														else if(!empty($product_data[$i]->production_mst_id) || empty($product_data[$i]->pallet_row))
														{
															if(empty($product_data[$i]->export_half_pallet))
															{
															
																if($product_data[$i]->origanal_pallet > 0)
																{
																	
																	$Grand_Total_pallet  += $product_data[$i]->origanal_pallet;
																}
																else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
																{
																	
																	$Grand_Total_pallet  += $product_data[$i]->orginal_no_of_big_pallet;
																	$Grand_Total_pallet  += $product_data[$i]->orginal_no_of_small_pallet;
																}
																
																
															}
														}
													if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 $rowspan++;
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->description_goods;
														$product_desc_array[trim($description_goods)]['product_name'] = $product_data[$i]->series_name.', HSN Code - '.$product_data[$i]->hsnc_code;
														$product_desc_array[trim($description_goods)]['series_name'] = $product_data[$i]->series_name;
														$product_desc_array[trim($description_goods)]['hsnc_code'] = $product_data[$i]->hsnc_code;
														$product_desc_array[trim($description_goods)]['size_type_mm'] = $product_data[$i]->size_type_mm;												$product_desc_array[trim($description_goods)]['company_name'] = $product_data[$i]->company_name;												$product_desc_array[trim($description_goods)]['suppiler_invoice_no'] = $product_data[$i]->suppiler_invoice_no;									$product_desc_array[trim($description_goods)]['suppiler_invoice_date'] = $product_data[$i]->suppiler_invoice_date;
														$product_desc_array[trim($description_goods)]['thickness'] = $product_data[$i]->thickness;
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
												$Grand_Total_pallet  +=    floatval($sample_row->no_of_pallet);
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
												<td colspan="4"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;background-color:#D9D9D9 ; color:#000000;">
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
									<td colspan="2" style="text-align:center;font-weight:bold;"> Marks & NOS
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
									 
									<td colspan="4" style="text-align:center;font-weight:bold;"> Description Of Goods
									<br>
									<?=str_ireplace(",","<br>",implode(",",$series_name_array))?>
									</td>
									<td colspan="3" style="text-align:center;font-weight:bold;">
									
                      <?=($Grand_Total_pallet == 0)?" ":$Grand_Total_pallet.'<span style="text-align:center;font-weight:bold"> PALLETS</span>' ?>
                     
                     
									</td>
									<td colspan="2" style="text-align:center;font-weight:bold;"> <span style="text-align:center;">
                      <?=$Total_box?>
                      </span> <strong> BOXES </strong></td>
									 
						      </tr>
							   
							  <tr>
							    <td width="4%" style="text-align:center;font-weight:bold"> SR NO.</td>
							    <td width="10%" style="text-align:center;font-weight:bold"> CONTAINER NO.</td>
							    <td width="10%" style="text-align:center;font-weight:bold"> RFID SEAL NO.</td>
							    <td width="10%" style="text-align:center;font-weight:bold">LINE SEAL NO.</td>
								  <td width="16%" style="text-align:center;font-weight:bold">SIZE (MM)</td>
							    <td width="10%" style="text-align:center;font-weight:bold">HSNC CODE</td>
							  
								<td width="8%" style="text-align:center;font-weight:bold">PALLETS</td>
							    <td width="8%" style="text-align:center;font-weight:bold">BOXES</td>
							    <td width="8%" style="text-align:center;font-weight:bold">SQM</td>
						 	    <td width="8%" style="text-align:center;font-weight:bold"> RATE <?=$invoicedata->currency_name?>/SQM </td>
							    <td width="8%" style="text-align:center;font-weight:bold">AMOUNT
                                                (<?=$invoicedata->currency_name?>)</td>
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
													  $check_container = $product_data[$i]->con_entry.$product_data[$i]->einvoice_id;
													 
													 
												 	if(!in_array($check_container,$con_array))
													{
														$sample_str = '';	
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														$total_package = $product_data[$i]->total_package;
														$totalpackage = $product_data[$i]->total_package;
														
														//$Total_pallets  = $product_data[$i]->total_ori_pallet;
														$net_weight 	= $product_data[$i]->total_ori_net_weight;
													//	$gross_weight 	= $product_data[$i]->total_ori_gross_weight;
													$totalnetweight 	+= $product_data[$i]->total_ori_net_weight;
													//$totalgrossweight 	+= $product_data[$i]->total_ori_gross_weight;
															if($product_data[$i]->origanal_pallet > 0)
															{
																//echo (($product_data[$i]->origanal_pallet * $product_data[$i]->pallet_weight) + ($netforsum));
																
																//$Grand_Total_pallet  += $product_data[$i]->origanal_pallet;
																$pallet_weight = $product_data[$i]->pallet_weight;
																$total_pallets = floatval($product_data[$i]->total_ori_pallet);
																$gross_weight = ($total_pallets * $pallet_weight) + $net_weight;
																$totalgrossweight += $gross_weight;
															}
															else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
															{
																
																$pallet_weight_big = $product_data[$i]->orginal_no_of_big_pallet * $product_data[$i]->big_plat_weight;
																$pallet_weight_small = $product_data[$i]->orginal_no_of_small_pallet * $product_data[$i]->small_plat_weight;
																$total_pallets = ($pallet_weight_big + $pallet_weight_small);
																$gross_weight = ($total_pallets + $net_weight);
																$totalgrossweight += $gross_weight; 
																
															}
															if(empty($sample_str))
															{
																$sample_container = 1;
																$rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																			$sample_str .= '<tr>
																						 
																						 <td style="text-align:center">
																						 	
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->product_size_id.'
																							<br>Sample
																					
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
																						 	  '.$currency_symbol.' '.$sample_row->sample_rate.'
																						 </td>
																						  <td style="text-align:center">
																						 '.$currency_symbol.' '.$sample_row->sample_amout.'
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
								
							    <?php 
								$n++;
													$no=1;
													array_push($con_array,$check_container);
											  	}
												else
												{
													$sample_container++;
													
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
													<td style="text-align:center" ><?=$product_data[$i]->hsnc_code?></td>
													
							   
													<?php
													}
													else
													{
														echo '<td style="text-align:center"  colspan="2"> 							 
																	'.$product_data[$i]->description_goods.'
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
																	$Grand_Total_pallet += $product_data[$i]->export_half_pallet;
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
													  <td style="text-align:center;" > <?=$currency_symbol?><?=number_format($product_data[$i]->product_rate,2,'.','')?></td>
													<td style="text-align:center;"  > <?=$currency_symbol?><?=number_format($product_data[$i]->product_amt,2,'.','')?></td>
							  	
													 <?php
													 $Total_box += $product_data[$i]->origanal_boxes;
													if($no>1)
													{
														echo "</tr>";
													}
													array_push($sizearray,$desc);
												}
											 
												if(!in_array($check_container,$conarray))
												{
												?>
												 
							   
							    
						      </tr>
							  <?php 
							    
												
													
													array_push($conarray,$check_container);
											  	}
												if($product_data[$i]->rowspan_no == $sample_container) 
												{
													echo $sample_str;
											    }
												 
												 
											    $Total_sqm 		+= $product_data[$i]->origanal_sqm;
											     
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
							    <td style="text-align:center;border-bottom:none;border-top:none" >&nbsp;</td>
							    <td style="text-align:center;border-bottom:none;border-top:none">&nbsp;</td>
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
                    <td colspan="6" rowspan="2" bgcolor="#000000" style="font-weight:bold;vertical-align:middle; text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><span style="color: #FFF;"> THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT)  :
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
					  <td  style="font-weight:bold;text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=($Grand_Total_pallet == 0)?"-":$Grand_Total_pallet; ?></td>
					           <td  style="font-weight:bold;text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;"><?=$Total_box; ?></td>
                    
           
                    <td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center; color: #000;border-top:0.5px solid #333;border-right:0.5px solid #333;"><span style="font-weight:bold;text-align:center">
                      <?=number_format($Total_sqm,2,'.',''); ?>
                      </span></td>
                    <td rowspan="2" style="font-weight:bold; text-align:center; color:#000;border-top:0.5px solid #333;border-right:0.5px solid #333;">CIF
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
										$Total_amt = $Total_amt - $invoicedata->certification_charge?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						<!--<?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      &nbsp;in INR -->
					</td>
                    <td  colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" ><span style="font-weight:bold;vertical-align:top;text-align:center">Exchange Rate <strong> </strong></span></td>
				   <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;">
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                      <?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      &nbsp;in
                      <?=$invoicedata->currency_name?>
                      </span>
					</td>
                    <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="text-align:center"> CERTIFICATION </span></td>
                    <td style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->certification_charge > 0)?number_format($invoicedata->certification_charge,2,'.',''):"0.00" ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center">
					<!--<?=number_format($invoicedata->indian_ruppe_val,2,'.','')?>-->
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
                    <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;">INSURANCE</td>
                    <td style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->insurance_charge > 0)?number_format($invoicedata->insurance_charge,2,'.',''):"0.00" ?></td>
                  </tr>
                  <?php $Total_amt = $Total_amt - $invoicedata->insurance_charge;  ?>
                  <tr>
                    <td rowspan="2" colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center"><span style="font-weight:bold;text-align:center;"><span style="text-align:center;font-weight:bold"> Gross Weight</span></span></td>
                    <td rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center"><span style="text-align:center;font-weight:bold">
                      <?=number_format($totalgrossweight,2)?>
                      KGS</span></td>
                    <td rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" colspan="2"><span style="text-align:center;font-weight:bold"> Net Weight </span></td>
                    <td rowspan="2" colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;"><?=number_format($totalnetweight,2)?>
                      KGS</td>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="3">FREIGHT</td>
                    <td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->seafright_charge > 0)?number_format($invoicedata->seafright_charge,2,'.',''):"0.00" ?></td>
                  </tr>
                  <tr>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="3">BANK CHARGES</td>
                    <td  style="border-bottom:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=($invoicedata->bank_charge > 0)?number_format($invoicedata->bank_charge,2,'.',''):"0.00" ?></td>
                  </tr>
                  <?php  $Total_amt = $Total_amt - $invoicedata->seafright_charge;
							//			  $Total_amt += $invoicedata->courier_charge; 
								//		  $Total_amt += $invoicedata->bank_charge; 
									if(!empty($invoicedata->extra_calc_name))
									{
									 	 ?>
										 <tr>
										  <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"> </td>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="3"><?=$invoicedata->extra_calc_name?> <?=($invoicedata->extra_calc_opt == 1)?"+":"-"?></td>
                    <td  style="border-bottom:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=number_format($invoicedata->extra_calc_amt,2,'.','')?></td>
                  </tr>
									<?php
									 $Total_amt =($invoicedata->extra_calc_opt == 1)?$Total_amt + $invoicedata->extra_calc_amt:$Total_amt - $invoicedata->extra_calc_amt; 
									}
									?>
				 <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"></td>
                    <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;border-bottom:0.5px solid #333;text-align:center">COURIER CHARGES</td>
                    <td  style="font-weight:bold;text-align:right"><?=$currency_symbol?>
                      &nbsp;
                      <?=($invoicedata->courier_charge > 0)?number_format($invoicedata->courier_charge,2,'.',''):"0.00" ?></td>
                  </tr>
				 <tr>
			
                 
                       <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7">
					
                      </td>
                  
              					
                  
                    <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center">DISCOUNT</td>
                    <td  style="font-weight:bold;text-align:right;border-bottom:0.5px solid #333;"><?=$currency_symbol?>
                      <?=($invoicedata->discount > 0)?number_format($invoicedata->discount,2,'.',''):"0.00" ?></td>
                  </tr>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7">AMOUNT CHARGEABLE IN WORDS <span style="text-align:center">
                      <?=($invoicedata->calculation_operator == 1)? $invoicedata->terms_name: 'FOB';?>
                      </span></td>
                    <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;border-bottom:0.5px solid #333;text-align:center">COMMISSION</td>
                    <td  style="font-weight:bold;text-align:right"><?=$currency_symbol?>
                      &nbsp;
                      <?=($invoicedata->commision_amt > 0)?number_format($invoicedata->commision_amt,2,'.',''):"0.00" ?></td>
                  </tr>
                  <?php 
					$Total_amt = $Total_amt - $invoicedata->discount; 
					?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"><?=strtoupper(convertamonttousd($Total_amt,$invoicedata->currency_name))?>
                      ONLY </td>
                    <td colspan="3" style="border-right:0.5px solid #333;text-align:center">FOB
                      in
                      <?=$invoicedata->currency_name?></td>
                    <td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol.number_format($Total_amt,2,'.','')?></td>
                  </tr>
				  <?php
												if($company_detail[0]->s_c_type == "Merchant")
												{
													$no =1;
													$previous_company_name = "";
													foreach($export_supplier_data as $sup_row)
													{ 
													if ($sup_row->company_name !== $previous_company_name) {
																 ?>
                  <tr>
                    <td colspan="3" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;">
					<?php if($no==1)
												{
													?>

                      <?php
												}
												?>
               <strong>
                      <?php if($no==1)
												{
													?>
                      Self-Sealing Permission No. & Date
                      <?php
												}
												?>
                      </strong></td>
                    
					  <td colspan="8" style="border-right:0.5px solid #333;text-align:center"><strong>
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
								$previous_company_name = $sup_row->company_name;
							$no++;
						}
					}
				} 
												?>
					 <tr>
                    <td colspan="11"  valign="top"><?php
														if($company_detail[0]->s_c_type == "Merchant")
														{
														$no =1;
														$previous_company_name = "";
															foreach($export_supplier_data as $sup_row)
															{ 
															if ($sup_row->company_name !== $previous_company_name) {
															if(!empty($sup_row->supplier_gstno))
															{
																
																 ?>
                      <?=($no>1)?"<br />":""?>
                    
                      <?=(empty($sup_row->epcg_no))?"":"EPCG NO :".$sup_row->epcg_no?>
                      <?=(empty($sup_row->epcg_date) || $sup_row->epcg_date == '1970-01-01')?"":"& DATE :".date('d/m/Y',strtotime($sup_row->epcg_date))?>
                      <?php 
																 $previous_company_name = $sup_row->company_name;
																$no++;
															}
															}
																}
														}
																?></td>
                  </tr>
                  <tr>
                    <td style="border-top:0.5px solid #333;"  colspan="11"><span style="font-weight:bold;vertical-align:top;">
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
												   ?>
                      </span></td>
                  </tr>
                  <tr>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="5"> Self Sealing Declaration <br />
                      (1) Certified That The Description &amp; Value Of Goods Covered By This Invoice Have Been Checked By Me &amp; That Goods Have Been Packed &amp; Sealed With One Time Seal (OTS) Under My Direct Supervision 
                      (2) We Have Follow The Procedure Laid Down In CBEC's Circular No. 426/59/98 CX Dt.12/10/1998 As Amended Against This Shipment&quot; </td>
                    <td height="50" colspan="7" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:right">For
                      <?=$company_detail[0]->s_name?>
                      <br />
                      <br />
                      <br /></td>
                  </tr>
                  <tr>
                    <td style="border-right:0.5px solid #333;border:0.5px solid #333;" colspan="5"><strong><u>Declaration</u></strong>: <br />
                       <?php if($invoicedata->export_under!='')
												   {
													?>
                      <?=$invoicedata->export_under?>
												   <?php
												   }
												   ?>
                    <td colspan="7" style="text-align:right;border-top:none" valign="bottom"><?=nl2br($company_detail[0]->authorised_signatury)?>
                      <br></td>
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
             
                <table  width="100%" cellspacing="0" cellpadding="0" style="border:none" class="pdf_class invoice_edit_cls1" contenteditable="false">
                 <tr>
    <td style="text-align:center;font-weight:bold">SR NO.</td>
    <td style="text-align:center;font-weight:bold">CONTAINER NO.</td>
    <td style="text-align:center;font-weight:bold">RFID SEAL NO.</td>
    <td style="text-align:center;font-weight:bold">LINE SEAL NO.</td>
    <td  style="text-align:center;font-weight:bold">SIZE (CM)</td>
	<td style="text-align:center;font-weight:bold">PALLETS</td>
    <td style="text-align:center;font-weight:bold">BOXES</td>
    <td style="text-align:center;font-weight:bold">SQM</td>
    
    <td style="text-align:center;font-weight:bold">NET WEIGHT (Kgs)</td>
    <td style="text-align:center;font-weight:bold">GROSS WEIGHT (Kgs)</td>
</tr>

<?php
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

        $net_weight = $product_data[$i]->total_ori_net_weight;
       // $gross_weight = $product_data[$i]->total_ori_gross_weight;
        $totalnetweight += $product_data[$i]->total_ori_net_weight;
       // $totalgrossweight += $product_data[$i]->total_ori_gross_weight;
		
		// $pallet_weight = $product_data[$i]->pallet_weight;
		// $total_pallets = floatval($product_data[$i]->total_ori_pallet);
		// $gross_weight = ($total_pallets * $pallet_weight) + $net_weight;
		//$totalgrossweight += $gross_weight;
		
		
			if($product_data[$i]->origanal_pallet > 0)
			{
				//echo (($product_data[$i]->origanal_pallet * $product_data[$i]->pallet_weight) + ($netforsum));
				
				//$Grand_Total_pallet  += $product_data[$i]->origanal_pallet;
				$pallet_weight = $product_data[$i]->pallet_weight;
				$total_pallets = floatval($product_data[$i]->total_ori_pallet);
				$gross_weight = ($total_pallets * $pallet_weight) + $net_weight;
				$totalgrossweight += $gross_weight;
			}
			else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
			{
				
				$pallet_weight_big = $product_data[$i]->orginal_no_of_big_pallet * $product_data[$i]->big_plat_weight;
				$pallet_weight_small = $product_data[$i]->orginal_no_of_small_pallet * $product_data[$i]->small_plat_weight;
				$total_pallets = ($pallet_weight_big + $pallet_weight_small);
				$gross_weight = ($total_pallets + $net_weight);
				$totalgrossweight += $gross_weight; 
				
			}

        if (empty($sample_str)) {
            $rowcon_no = (!empty($rowcon_no)) ? $rowcon_no : 1;
            foreach ($product_data[$i]->sample as $sample_row) {
                $rowcon_no++;
                $sample_des = !empty($sample_row->sample_remarks) ? $sample_row->sample_remarks : $sample_row->size_type_mm;
                $sample_str .= '<tr>
                                    <td colspan="2" style="text-align:center">
                                        ' . $sample_row->product_size_id . ' - ' . $sample_row->sample_remarks . '
                                    </td>
                                    <td style="text-align:center">' . $sample_row->no_of_boxes . '</td>
                                    <td style="text-align:center">' . $sample_row->no_of_pallet . '</td>
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
        $no = 1;
        array_push($con_array, $product_data[$i]->con_entry);
        $sr_no++; // ✅ increment SR NO only when new container starts
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
		 <td style="text-align:center" ><?=$product_data[$i]->origanal_boxes?></td>
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
        array_push($conarray, $product_data[$i]->con_entry);
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
					 <td style="text-align:center;font-weight:bold"><?=($Grand_Total_pallet == 0)?"-":$Grand_Total_pallet; ?></td>
                    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
                      <?=$Total_box; ?>
                      </span></td>
                   
                    <td style="text-align:center;font-weight:bold"> <?=$Total_sqm; ?></td>
                    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
                      <?=number_format($totalnetweight,2,'.','')?>
                      </span></td>
                    <td style="text-align:center"><span style="font-weight:bold;text-align:center">
                      <?=number_format($totalgrossweight,2,'.','')?>
                      </span></td>
                  </tr>
                  <tr>
                    <td colspan="10" valign="top" style="text-align:left"><strong> <span style="font-weight:bold;vertical-align:top;">
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
                    <td colspan="6" rowspan="2" valign="top" style="text-align:left"><strong><u>Declaration</u></strong>: <br />
                      We declared that this packing list shows the actual quantity of the goods described &amp; that all particulars are true and correct or stuffed in the container(s). </td>
                    <td height="80" colspan="5" style="text-align:left;border-bottom:hidden" valign="top"><span style="border-bottom:hidden">For
                      <?=$company_detail[0]->s_name?>
                      </span></td>
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
                <h4 style="text-align:center;"><strong style="font-size:20px;">ANNEXURE</strong></h4>
                <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class invoice_edit_cls2" style="padding:7px;" contenteditable="false">
                  <tr>
                    <td colspan="4" align="center">OFFICE OF THE SUPERITENTNDENT OF CENTRAL GST / CUSTOM DEPARTMENT</td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center">GST OFFICE,  CGST -
                      <?=$company_detail[0]->com_range?>
                      , DIVISION CODE -
                      <?=$company_detail[0]->com_division?>
                      ,  COMMISSIONERATE -
                      <?=$company_detail[0]->commissionerate?>
                      .</td>
                  </tr>
                  <tr>
                    <td align="left" >Sr No. : <?=$annexuredata->c_no?></td>
                    <td align="left">Date : <?=$annexuredata->c_date?></td>
                    <td align="left">Shipping Line : <?=$annexuredata->Shipping_bill_no?></td>
                    <td align="left">Date : <?=$annexuredata->Shipping_date?></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center"><span style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;">
                      <?php
													if($invoicedata->igst_status==1)
													{
													?>
                      &quot;SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING (LUT) WITHOUT PAYMENT OF INTEGRATED TAX (IGST)&quot;
                      <?php }
													else{?>
                      &quot;SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING ( LUT) WITH PAYMENT OF INTEGRATED TAX (IGST)&quot;
                      <?php }?>
                      </span></td>
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
                    <td style="border-right:none;text-align:center;vertical-align:top"> 1 </td>
                    <td style="vertical-align:top;border-right:none;border-left:none"><strong>Name of Exporters &amp; Address</strong></td>
                    <td style="border-left:none;vertical-align:top;"></td>
                    <td colspan="4" style="border-left:none;"><?=$export?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"> 2 </td>
                    <td style="border:none;"><strong>a) I.E.Code No.</strong></td>
                    <td style="border-left:none;border-bottom:none;"></td>
                    <td style="border-bottom:none;border-top:none;border-left:none;" colspan="4"><?=$exporter_iec?></td>
                  </tr>
                  <tr>
                    <td  style="border-right:none;border-top:none;border-bottom:none;"></td>
                    <td style="border-right:none;border-left:none;border-top:none;border-bottom:none;"><strong>b) GSTIN</strong></td>
                    <td style="border-left:none;border-top:none;border-bottom:none;"></td>
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
                    <td colspan="4" style="border-top:none;border-left:none;border-bottom:none"><?=!empty($annexuredata->company_branch_code)?$annexuredata->company_branch_code:$annexuredata->company_branch_id?></td>
                  </tr>
                  <tr>
                    <td  style="border-right:none;border-top:none;border-bottom:none;"></td>
                    <td style="border-right:none;border-left:none;border-top:none;border-bottom:none;"><strong>e) BIN No.</strong></td>
                    <td style="border-left:none;border-top:none;border-bottom:none;"></td>
                    <td colspan="4" style="border-top:none;border-left:none;border-bottom:none"><span style="border-top:none;border-left:none;">
                      <?=$company_detail[0]->s_bin?>
                      </span></td>
                  </tr>
				  <tr>
                    <td  style="border-right:none;border-top:none;border-bottom:none;"></td>
                    <td style="border-right:none;border-left:none;border-top:none;border-bottom:none;"><strong>f) STATE CODE</strong></td>
                    <td style="border-left:none;border-top:none;border-bottom:none;"></td>
                    <td colspan="4" style="border-top:none;border-left:none;border-bottom:none"><span style="border-top:none;border-left:none;">
                     24
                      </span></td>
                  </tr>
                 <?php
				if ($company_detail[0]->s_c_type == "Merchant") {
					$no = 1;
					$previous_company_name = "";
					
					foreach ($export_supplier_data as $sup_row) {
						if ($sup_row->company_name !== $previous_company_name) {
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
						<?= $sup_row->company_name ?> <br />
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
							$previous_company_name = $sup_row->company_name;
							$no++;
						}
					}
				} 
				?>

                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"> 4 </td>
                    <td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"><span style="border-right:none;border-top:none;border-left:none"> <strong>Date of Examination </strong> </span></td>
                    <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"><span style="border-top:none;border-left:none;">
                      <?=$annexuredata_examination_date?>
                      </span></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">5</td>
                    <td style="border:none"><strong>Name & Designation of the Examining officer Inspection / EO/PO</strong></td>
                    <td style="border-bottom:none;border-left:none;border-top:none;"></td>
                    <td colspan="4" style="border-bottom:none;border-top:none;border-left:none;"> SELF SEALING </td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">6</td>
                    <td style="border:none"><strong>Name &amp; Designation of the Supervising officer Appraiser / Superintendent</strong></td>
                    <td style="border-bottom:none;border-left:none;border-top:none;"></td>
                    <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> SELF SEALING </td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">7</td>
                    <td style="border:none;" ><strong>a) Name of the Commissinorate Division / Range</strong></td>
                    <td  style="border-bottom:none;border-left:none;border-top:none;"></td>
                    <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"><?php
																	$export_range=array();
																	$export_division=array();
																	foreach($export_supplier_data as $sup_row){ 
																	array_push($export_range,$sup_row->sup_range); 
																	array_push($export_division,$sup_row->division); 
																	}
																	echo implode(",",$export_division);
																	echo " / ";
																	echo implode(",",$export_range);
																	?></td>
                  </tr>
                  <tr>
                    <td style="border-right:none;border-top:none;"></td>
                    <td style=" border-top:none;border-left:none"  colspan="2"><strong>b) Location Code </strong></td>
                    <td colspan="4" style="border-left:none;border-top:none;"><?php
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
																?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">8</td>
                    <td style="border:none" colspan="2"><strong>Particulars of Export Invoice </strong></td>
                    <td style="border-bottom:none;border-right:none;border-top:none;" ></td>
                    <td colspan="3" style="border-bottom:none;border-left:none;border-top:none;"></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
                    <td style="border:none"  colspan="2"><strong>a) Export Invoice No.</strong></td>
                    <td colspan="4" style="border-bottom:none; border-top:none;" ><?=$invoicedata->export_invoice_no?>
                      ,
                      <?=date('d/m/Y',strtotime($invoicedata->invoice_date))?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
                    <td style="border:none" colspan="2"><strong>b) Total No. of Pallets </strong></td>
                    <td colspan="4" style="border-bottom:none; border-top:none;" ><?=$Total_pallet?>
                      Pallets (
                      <?=$Total_box?>
                      BOXES) </td>
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
                    <td style="border-right:none;border-top:none;border-left:none;vertical-align:top"colspan="2"  ><strong>d) </strong> <strong>Abroad</strong></td>
                    <td colspan="4" style=" border-top:none;" ><span style="vertical-align:top">
                      <?=$country_final_destination?>
                      </span></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:hidden; border-top:none;text-align:center">9</td>
                    <td colspan="2" style="border:none" ><strong>(a) Is the description of the goods the Quantity and their value as per particulars furnished in the export Invoice? </strong></td>
                    <td colspan="4" style="border-bottom:none; border-top:none;text-align:left" ><?=($annexuredata->description_goods_status==1)?"YES":"NO"?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
                    <td style="border:none"  colspan="2"><strong> (b) Whether sample is drawn for being forwarded to port of Export </strong></td>
                    <td colspan="4" style="border-bottom:none; border-top:none;text-align:left"><?=($annexuredata->drawn_port_export==1)?"YES":"NO"?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
                    <td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"><strong> (c) If yes, the number of the seal of the package containing the sample </strong></td>
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
                    <td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"><strong>Central GST / Customs Seal No. </strong></td>
                    <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"> SELF SEALING </td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
                    <td colspan="2" style="border-bottom:none;border-left:none;border-top:none;" ><strong>a) For Non containerized Cargo  no. of Packages. </strong></td>
                    <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"><?=$annexuredata->seal_no?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
                    <td style="border-bottom:none;border-left:none;border-top:none;" colspan="2"><strong>b) For containerized Cargo</strong></td>
                    <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"><?=$annexuredata->containerized_cargo?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;"></td>
                    <td colspan="2" style="border-bottom:none;border-left:none;border-top:none;"><strong>c) Container Details</strong></td>
                    <td colspan="4" style="border-bottom:none;border-left:none;border-top:none;"></td>
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
                    
                    <td style="text-align:center;font-weight:bold">SIZE (MM)</td>
                    <td style="text-align:center;font-weight:bold">PALLETS</td>
                    <td style="text-align:center;font-weight:bold">BOXES</td>
					<td style="text-align:center;font-weight:bold"> SQM</td>
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
														//$gross_weight 	= $product_data[$i]->total_ori_gross_weight;
													$totalnetweight 	+= $product_data[$i]->total_ori_net_weight;
													//$totalgrossweight 	+= $product_data[$i]->total_ori_gross_weight;
															if($product_data[$i]->origanal_pallet > 0)
															{
																//echo (($product_data[$i]->origanal_pallet * $product_data[$i]->pallet_weight) + ($netforsum));
																
																//$Grand_Total_pallet  += $product_data[$i]->origanal_pallet;
																$pallet_weight = $product_data[$i]->pallet_weight;
																$total_pallets = floatval($product_data[$i]->total_ori_pallet);
																$gross_weight = ($total_pallets * $pallet_weight) + $net_weight;
																$totalgrossweight += $gross_weight;
															}
															else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
															{
																
																$pallet_weight_big = $product_data[$i]->orginal_no_of_big_pallet * $product_data[$i]->big_plat_weight;
																$pallet_weight_small = $product_data[$i]->orginal_no_of_small_pallet * $product_data[$i]->small_plat_weight;
																$total_pallets = ($pallet_weight_big + $pallet_weight_small);
																$gross_weight = ($total_pallets + $net_weight);
																$totalgrossweight += $gross_weight; 
																
															}
														
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
																						 <td style="text-align:center">
																						 	'.$sample_row->sqm.'
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
                    
                    <td style="text-align:center" ><?=$product_data[$i]->size_type_mm?> (<?=$product_data[$i]->series_name?>)</td>
                    <td style="text-align:center" >
                    <?php 
					if($product_data[$i]->total_ori_pallet > 0)
					{
					?>	
                        <?=$product_data[$i]->total_ori_pallet?>														 
					<?php
					}
					 else 
					 {
					 echo "-";  
					 }?>
                    </td>
                    <td style="text-align:center" ><?=$totalpackage?></td>
					<td style="text-align:center" ><?=$product_data[$i]->origanal_sqm?> </td>
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
                    <td colspan="5" style="text-align:right"><strong>TOTAL</strong></td>
                    <td style="text-align:center;font-weight:bold"><?=($Grand_Total_pallet == 0)?"-":$Grand_Total_pallet; ?></td>
                    <td style="text-align:center;font-weight:bold"><?=$Total_box; ?></td>
                    <td style="text-align:center;font-weight:bold"><?=$Total_sqm; ?></td>
                  </tr>
                </table>
                <table width="100%"  cellspacing="0" cellpadding="0" class="pdf_class invoice_edit_cls2" contenteditable="false">
                  <?php
												if($company_detail[0]->s_c_type == "Merchant")
												{
													$no =1;
													$previous_company_name = "";
													foreach($export_supplier_data as $sup_row)
													{ 
													if ($sup_row->company_name !== $previous_company_name) {
																 ?>
                  <tr>
                    <td width="5%" style="text-align:center"><?php if($no==1)
												{
													?>
                      11
                      <?php
												}
												?></td>
                    <td width="20%"><strong>
                      <?php if($no==1)
												{
													?>
                      Self-Sealing Permission No. & Date
                      <?php
												}
												?>
                      </strong></td>
                    
					  <td width="40%" ><strong>
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
												$previous_company_name = $sup_row->company_name;
							$no++;
						}
					}
				} 
													?>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center">12</td>
                    <td style="border-bottom:none;border-left:none;border-top:none;" colspan="2"> EXPORT UNDER GST CIRCULAR No.:
                      <?=$company_detail[0]->gst_circular_no?>
                      , CUSTOM DATED :
                      <?=$company_detail[0]->date_of_filing?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
                    <td style="border:none;"><strong>Net Weight</strong> :
                      <?=number_format($totalnetweight,2)?>
                      KGS</td>
                    <td style="border-bottom:none;border-left:none;border-top:none;"><strong>Gross Weight</strong> :
                      <?=number_format($totalgrossweight,2)?>
                      KGS </td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
                    <td colspan="2" bgcolor="#000000" style="border-bottom:none;border-left:hidden; border-top:none;color: #000; text-align:center"><span style="color: #FFF;">THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT)  :
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
                      </span></span></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
                    <td colspan="2"    style="border-bottom:none;border-left:hidden; border-top:none;"><?php if($invoicedata->remarks!='')
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
												   ?></td>
                  </tr>
                  <tr>
                    <td style="border-bottom:none;border-right:none;border-top:none;text-align:center"></td>
                    <td colspan="2" style="border-bottom:none;border-left:hidden; border-top:none;"></td>
                  </tr>
                  <tr>
                    <td colspan="3" style="padding-left:20px"> FOR,
                      <?=$company_detail[0]->s_name?>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <?=nl2br($company_detail[0]->authorised_signatury)?></td>
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