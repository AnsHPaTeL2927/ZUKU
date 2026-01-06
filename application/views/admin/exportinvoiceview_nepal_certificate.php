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
                    <td colspan="6"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;"> <h2>CERTIFICATE OF ORIGIN</h2> </td>
                  </tr>
                 
                  <tr>
                    <td colspan ="1"> <strong> APPLICANT PAN NO.:</strong></td>
                    <td colspan ="5"> <?=$exporter_pan?></td>
                  </tr>
				  
                  <tr>
				    <td><span colspan="1"  style="font-weight:bold">EXIM CODE: </span></td>
                    <td colspan ="5"> <?=$exporter_pan?></td>
                  </tr>
				  
                  <tr>
                    <td  colspan="1" style="font-weight:bold" valign="top">INVOICE NO.: </td>
                    <td  colspan="1"><?=$exportinvoice_no?></td>
					<td  colspan ="1" style="font-weight:bold" valign="top">DATE: </td>
					 <td colspan ="3"><?=date('d.m.Y',strtotime($invoicedata->performa_date))?> </td>
                  </tr>
				  
                  <tr>
                   <td  colspan="1" style="font-weight:bold" valign="top">NEPAL CUSTOM ENTRY POINT: </td>
                    <td  colspan="5"></td>
                  </tr>
				  
                  <tr>
                     <td  colspan="1" style="font-weight:bold" valign="top">TRANSPORT: </td>
                     <td  colspan="1"></td>
					 <td  colspan ="1" style="font-weight:bold" valign="top">LR NO.: </td>
					 <td colspan ="3"><?=date('d.m.Y',strtotime($invoicedata->performa_date))?> </td>
                  </tr>
				  
                  <tr>
                     <td  colspan="1" style="font-weight:bold" valign="top">HSN CODE: </td>
                     <td colspan="5" style="text-align:left;">
					  <?php
										 		$no=1;
												$A= count($product_desc_array)-1;
												for($p=0;$p<count($product_desc_array);$p++)
												{
													if($p == A)
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
												}
																
																	?>
																	
					
					</td>
					
                  </tr>
				  
                  <tr>
				  
                     <td  colspan="1" style="font-weight:bold" valign="top">SIZE: </td>
					 <td  colspan="1"> 
					 <?php
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
                     <td  colspan="1" style="font-weight:bold" valign="top"> BOXE: </td>
                     <td  colspan="3"> </td>
                  </tr>
				  
                  <tr>
                     <td  colspan="1" style="font-weight:bold" valign="top">TOTAL BOXES: </td>
                    <td  colspan="5"> <?=$Total_box?></td>
                  </tr>
				  
				   
                  <tr>
                    <td  colspan="1" style="font-weight:bold" valign="top">GROSS WEIGHT: </td>
                    <td  colspan="5"><?=number_format($totalgrossweight,2)?></td>
                  </tr>
				   
                  <tr>
                    <td  colspan="1" style="font-weight:bold" valign="top">NETT WEGHT: </td>
                    <td  colspan="5"> <?=number_format($totalnetweight,2)?></td>
                  </tr>
				
				  <tr>
				   
                    <td  colspan="6" style="font-weight:bold; text-align:center" valign="top";>THIS IS TO CRETIFY THAT GOODS EXPORTED ARE OF INDIAN ORIGIN</td>
					
                  </tr>
				  
				  <tr>
                    <td  colspan="2" style="font-weight:bold" valign="top">FOR.......................... </td>
					<td  colspan="4" style="font-weight:bold" valign="top">EXPORTER:</td>
                  </tr>
				  
				   <tr>
                    <td  colspan="2" style="font-weight:bold" valign="top"></td>
					<td  colspan="3" style="vertical-align:top;border-right:none">
					<?php
					if(!empty($supplier_other_company))
					{
							echo $supplier_other_company;
							echo '<br>';
					}
					?>
					
					<?=$export?></td>
					
                  </tr>
				  
				  
				  
				  <tr>
                   <td rowspan="2" valign="top" style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="4"></td>
                    <td  colspan="4" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:center">FOR, 
					<?=$company_detail[0]->s_name?>
						<br>
						<img src="<?=base_url()?>upload/<?=$company_detail[0]->s_c_sign?>"  width="150px" height="80px"/>
                      <br />
                      <br />
					 </td>
                  </tr>
				  
				    <tr>
             
                    <td colspan="6" style="text-align:center;border-top:none" valign="bottom"><?=nl2br($company_detail[0]->authorised_signatury)?>
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