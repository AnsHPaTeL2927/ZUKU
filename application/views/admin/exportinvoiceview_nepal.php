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
 $supplier_other_company			= $invoicedata->supplier_other_company;
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
 $grand_total_inr			= ($invoicedata->grand_total * $invoicedata->Exchange_Rate_val);
 $insurance_charge_final			= ($invoicedata->insurance_charge * $invoicedata->Exchange_Rate_val);
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
$currency_symbol_inr =  "<img src='".base_url()."adminast/assets/images/ruppe_sysbol.jpg' width=7 height=7 />";   
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
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="<?=base_url('exportinvoiceview/index_icolux/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Icolux)</a> </li>  
					  <li> <a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Supplier)" href="<?=base_url('exportinvoiceview/index_velsa/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> View Invoice (Velsa)</a> </li> 
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
                      <li> <a class="tooltips" data-toggle="tooltip" data-title="View Loading Pdf" href="<?=base_url('loadingpdf/index/'.$invoicedata->export_invoice_id)?>" target="_blank" ><i class="fa fa-eye"></i> Loading Pdf</a> </li>
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
								$Total_pallet 		= 0; 
								$Total_ammount 		= 0;
								$Total_ammount_inr 		= 0;
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
													$Total_ammount_inr	 += ($product_data[$i]->product_amt * $invoicedata->Exchange_Rate_val);
													$Total_amt 	 	 += $product_data[$i]->product_amt;
													$description_goods =  $product_data[$i]->description_goods.$product_data[$i]->pcs_per_box.$product_data[$i]->product_rate.$product_data[$i]->export_half_pallet.$product_data[$i]->export_make_pallet_no;
													if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 $rowspan++;
														$product_desc_array[trim($description_goods)] = array();
														$product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->description_goods;
														$product_desc_array[trim($description_goods)]['product_name'] = $product_data[$i]->series_name.'<br> HSN Code - '.$product_data[$i]->hsnc_code;
														$product_desc_array[trim($description_goods)]['size_type_mm'] = $product_data[$i]->size_type_mm;
														$product_desc_array[trim($description_goods)]['size_type_cm'] = $product_data[$i]->size_type_cm;
														$product_desc_array[trim($description_goods)]['thickness'] = $product_data[$i]->thickness;
														$product_desc_array[trim($description_goods)]['model_name'] = $product_data[$i]->model_name;
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
														  $product_desc_array[trim($description_goods)]['product_rate_1'] = ($product_data[$i]->product_rate * $invoicedata->Exchange_Rate_val);
														 $product_desc_array[trim($description_goods)]['per'] = $product_data[$i]->per;
														 $product_desc_array[trim($description_goods)]['performa_per'] = $product_data[$i]->performa_per;
														 $product_desc_array[trim($description_goods)]['amount'] = $product_data[$i]->product_amt;
														 $product_desc_array[trim($description_goods)]['amount_inr'] = ($product_data[$i]->product_amt * $invoicedata->Exchange_Rate_val);
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
														  $product_desc_array[trim($description_goods)]['amount_inr'] += ($product_data[$i]->product_amt * $invoicedata->Exchange_Rate_val);
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
												//$Total_ammount_inr 		+= $jsondata->sample_amout;
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
                    <td width="20%" style="padding:0px"></td>
                    <td width="20%" style="padding:0px"></td>
                    <td width="18%" style="padding:0px"></td>
                    <td width="12%" style="padding:0px"></td>
                    <td width="15%" style="padding:0px"></td>
                    <td width="15%" style="padding:0px"></td>
                  </tr>
                  <tr>
                    <td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;"> COMMERCIAL INVOICE </td>
                  </tr>
                 
                  <tr>
                    <td colspan="2" style="font-weight:bold"> Consignor/Exporter/Manufacturer:</td>
                    <td><span style="font-weight:bold">Exporter Invoice No. &amp; Date :</span></td>
                    <td><?=$exportinvoice_no?></td>
                    <td colspan="2"><?=$export_date?></td>
                  </tr>
                  <tr>
                    <td rowspan="3" style="vertical-align:top;border-right:none">
					<?php
					if(!empty($supplier_other_company))
					{
							echo $supplier_other_company;
							echo '<br>';
					}
					?>
					
					<?=$export?></td>
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
                    <td  style="text-align:center;font-weight:bold">SHIPPING MARKS &amp; NOS.</td>
                    <td colspan="9"  style="text-align:center;font-weight:bold">DESCRIPTION OF GOODS</td>
                    
                  </tr>
                  <tr>
                    <td style="text-align:center;font-weight:bold"> <?=$Total_box?></td>
                    <td colspan="5" style="text-align:center;font-weight:bold">
					  <?php
										 		$no=1;
												for($p=0;$p<count($product_desc_array);$p++)
												{
													if(!empty($product_desc_array[$p]))
													{
											 	 ?>
                  
                    <?php 
													  if($p == 0)
													  {
													  ?>
                   
                   
                      
                    <?php
													  }
													  ?>
                  <?php
															if(!empty($product_desc_array[$product_desc_array[$p]]['size_type_mm']))
															{
															?>
                      <?=$product_desc_array[$product_desc_array[$p]]['product_name']?>
                 
                      <?php
																}
																else
																{
																	echo $product_desc_array[$product_desc_array[$p]]['description_goods'];
																}
													}
												}
																
																	?>
																	
					
					</td>
            
                 
                    <td rowspan="2" style="text-align:center;font-weight:bold">TOTAL BOXES</td>
                    <td rowspan="2"style="text-align:center;font-weight:bold"> TOTAL SQUARE METER </td>
					<td rowspan="2"style="text-align:center;font-weight:bold">PRICE PER BOX INR</td>
					<td rowspan="2"style="text-align:center;font-weight:bold">TOTAL (INR)</td>
                  
                  </tr>
				  
				  <tr>
                    <td style="text-align:center;font-weight:bold"> </td>
                    <td colspan="2" style="text-align:center;font-weight:bold">SIZE</td>
                    <td style="text-align:center;font-weight:bold">PCS PER BOX</td>
                    <td colspan="2" style="text-align:center;font-weight:bold">SQM PER BOX</td>
                  
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
               
                    <?php
													  }
													  ?>
					<td style="text-align:center" ></td>
                    <td colspan="2" style="text-align:center" ><?php
															if(!empty($product_desc_array[$product_desc_array[$p]]['size_type_cm']))
															{
															?>
                      
                      <?=$product_desc_array[$product_desc_array[$p]]['size_type_cm']?> 
                      
                      <?php
																}
																else
																{
																	echo $product_desc_array[$product_desc_array[$p]]['description_goods'];
																}
																
																	?></td>
                    <td style="text-align:center"><?=$product_desc_array[$product_desc_array[$p]]['pcs_per_box']?></td>
                    <td colspan="2" style="text-align:center"><?=number_format($product_desc_array[$product_desc_array[$p]]['sqm_per_box'],2)?></td>
                    <?php 
															$product_rate_1 	= $product_desc_array[$product_desc_array[$p]]['product_rate_1'];
															$product_rate 	= $product_desc_array[$product_desc_array[$p]]['product_rate'];
															$product_amt 	= $product_desc_array[$product_desc_array[$p]]['amount'];
															$product_amt_inr 	= $product_desc_array[$product_desc_array[$p]]['amount_inr'];
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
                    <td style="text-align:center"><?=$currency_symbol_inr?>
                      <?=number_format($product_rate_1,2)?></td>
                    <td style="text-align:center"><span style="text-align:center">
                     <?=$currency_symbol_inr?>
                      <?=number_format($product_desc_array[$product_desc_array[$p]]['amount_inr'],2,'.','')?>
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
                    <td  colspan="2" style="border-right:0.5px solid #333;text-align:center" > - </td>
                    
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
													$Total_ammount_inr 	+= $jsondata->sample_amout;
													//$Total_ammount_inr 	+= $jsondata->sample_amout;
													$Total_amt 		+= $jsondata->sample_amout;
											}
										 	for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
                <!--  <tr>
                    <td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;</td>
                    <td colspan="2" style="border:none;border-right:0.5px solid #333;height: 31px;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td> 
				    </tr>-->
                  <?php
											$no_of_row--;
											}
										?>
                  <tr>
                    <td colspan="6" style="font-weight:bold;vertical-align:middle; text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;">
					  GROSS WEIGHT: <?=number_format($totalgrossweight,2)?><br>
					  NET WEIGHT: <?=number_format($totalnetweight,2)?>
                      </td>
					  <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						
					</td>
					 <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						
					</td>
               
                   
                   
                  </tr>
                  <tr>
                   
                    
                  </tr>
                  <?php
										$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->certification_charge:$Total_amt + $invoicedata->certification_charge;  ?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						NO. & KIND OF PKGS
					</td>
                  <td  colspan="4" rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" ><span style="font-weight:bold;vertical-align:top;text-align:center">TOTAL<strong> </strong></span></td>
				   <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;">
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                     <?=$Total_box; ?>
                      </span>
					</td>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="font-weight:bold;text-align:center">
                      <?=number_format($Total_sqm,2,'.',''); ?>
                      </span></td>
                    <td  rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="text-align:center"> TOTAL VALUE </span></td>
                    <td rowspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol_inr?>
                     <?=number_format($Total_ammount_inr,2,'.',''); ?></td>
                  </tr>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center">
					<?=$Total_box; ?>
					</td>
					<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center">
					BOXES
					</td>
                   
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" >
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                     BOXES
                      </span>
					</td>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;font-weight:bold;">SQ. MTR</td>
                 
                   
                  </tr>
                
                  <?php  $Total_ammount_inr =($invoicedata->calculation_operator == 2)?$Total_ammount_inr - $invoicedata->seafright_charge:$Total_ammount_inr + $invoicedata->seafright_charge; 
										  $Total_ammount_inr += $invoicedata->courier_charge; 
										  $Total_ammount_inr += $invoicedata->bank_charge; 
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
									 $Total_ammount_inr =($invoicedata->extra_calc_opt == 1)?$Total_ammount_inr + $invoicedata->extra_calc_amt:$Total_ammount_inr - $invoicedata->extra_calc_amt; 
									}
									?>
				 
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-decoration:underline;vertical-align:top;" colspan="7">TOTAL AMOUNT INR: <span style="text-align:center">
                    
                      </span></td>
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;border-bottom:0.5px solid #333;text-align:center">INSURANCE</td>
                    <td  style="font-weight:bold;text-align:right"><?=$currency_symbol_inr?><?=($insurance_charge_final > 0)?number_format($insurance_charge_final,2,'.',''):"0.00" ?></td>
					
                  </tr>
                  <?php 
					$Total_ammount_inr =($invoicedata->extra_calc_opt == 1)?$Total_ammount_inr + $insurance_charge_final:$Total_ammount_inr - $insurance_charge_final; 
					?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"><?=strtoupper(convertamonttousd($Total_ammount_inr,$currency_symbol_inr))?>
                      ONLY </td>
                    <td colspan="2" style="border-right:0.5px solid #333;text-align:center">
                      TOTAL AMOUNT
                      </td>
                      <td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol_inr.number_format($Total_ammount_inr,2,'.','')?></td>
                  </tr>
                  
                  <tr>
                    <td rowspan="2" valign="top" style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="4"> Declaration <br />
                     We declared that this invoice shows the actual price of the goods described & that all particulars are true and correct. </td>
                    <td height="50" colspan="6" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:right">FOR, 
					<?=$company_detail[0]->s_name?>
						<br>
						<img src="<?=base_url()?>upload/<?=$company_detail[0]->s_c_sign?>"  width="150px" height="80px"/>
                      <br />
                      <br /></td>
                  </tr>
                  <tr>
             
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