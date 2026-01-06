<?php 
 
 $export_date = date('d-m-Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no =$invoicedata->export_invoice_no;
 $export =  ($invoicedata->exporter_detail);
 $export_ref_no =  ($invoicedata->export_ref_no);
 $performa_date =  date('d-m-Y',strtotime($invoicedata->performa_date));
 $buy_order_no = strip_tags($invoicedata->export_buy_order_no);
 $exporter_email = $invoicedata->e_email;
 $exporter_mobile = $invoicedata->e_mobile;
 $exporter_gstin = $invoicedata->e_gstin;
 $exporter_pan = $invoicedata->exporter_pan;
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
 $advance_payment_id = $invoicedata->advance_payment_id;
 $branch_code = '';
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
  
 $commissionerate = $company_detail[0]->commissionerate;
 if(!empty($annexuredata))
 {
	 $commissionerate = $annexuredata->commissionrate;
	 $branch_code =  $annexuredata->company_branch_id;
 }
  $examination_date =  date('d-m-Y',strtotime($invoicedata->invoice_date));
 if(!empty($annexuredata->examination_date))
 {
	 $examination_date = date('d-m-Y',strtotime($annexuredata->examination_date));
 }
 $annexure_remarks = $company_detail[0]->annexure_remarks;
 
 if(!empty($annexuredata))
 {
	 $annexure_remarks = $annexuredata->annexure_remarks;
 }
   
 $this->view('lib/header'); 
  
   
?>	
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
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
						 	</ol>
							<div class="page-header title1">
							<h3>Export Invoice Annexure Detail</h3>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							<form name="exportinvoice_exporter_form" id="exportinvoice_exporter_form" action="javascript:;">
							 <div id="accordion">
							 <h3> Export Invoice Detail  </h3>   
								<div class="" style="padding:10px;" >
									 <table cellspacing="0" cellpadding="0" width="100%" class="pdf_class">
									<tr>
												<td style="padding:0;border-top:none;border-bottom:none" width="20%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="24%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="21%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												<td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
												 
											</tr>  
											<tr>
												<td colspan="5"  style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:16px;">
													EXPORT INVOICE
												</td>
												<td style="font-weight:bold;vertical-align: bottom;text-align: center;font-size:10;">
														<u>ORIGINAL</u>
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
												<td colspan="2" style="font-weight:bold"> 1. Exporter :</td>
												<td colspan="4"> 
														 
												</td>
											</tr>
											<tr>
												<td colspan="2" rowspan="2" style="vertical-align:top"> 
														<?=$export?>
												</td>
												<td   style="font-weight:bold"> 9. Invoice No. & Date :</td>
												<td>
														<?=$exportinvoice_no?>
												</td>
												<td colspan="2"> 
														<?=$export_date?>
												</td>
											</tr>
											 
											<tr>
												<td  style="font-weight:bold">
													10. Proforma Invoice no. & Date :
												</td>
												<td> 
														<?=$export_ref_no?>
												</td>
												 
												<td  colspan="2">
														<?=$performa_date?>
												</td>
											</tr>
											
											<tr>
												<td><strong>GST No : </strong><?=$exporter_gstin?></td>
												<td><strong>PAN : </strong><?=$exporter_pan?></td>
										 
												<td  rowspan="2"  style="font-weight:bold;vertical-align:top;">
													11. Manufacturer Name & Address :
												</td>
												<td colspan="3" rowspan="2" style="vertical-align:top"> 
														<?=$annexuredata->name_address_manufacturer?>
												</td>
												 
												 
											</tr>
											<tr>
												<td><strong>IEC :		</strong> <?=$exporter_iec?> </td>
												<td><strong>State Code :</strong>   <?=$company_detail[0]->state_code?> </td>
											</tr>
											
											  <tr>
												<td colspan="2"><strong>Email :</strong>  <?=$exporter_email?></td>
												<td style="font-weight:bold">GST NO. </td>
												<td>
													<?=$invoicedata->supplier_gstno?>
												</td>
												<td style="font-weight:bold">Pan No. </td>
												<td><?=$invoicedata->supplier_panno?></td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight:bold">
													2. Consignee :
												</td>
												<td  style="font-weight:bold">12. Factory Invoice No. & Date: </td>
												<td colspan="3">
													<?=$invoicedata->supplier_invoice_no?><?=$supplier_invoice_date?> 
												</td>
											 </tr>
											  <tr>
												<td colspan="2"   style="vertical-align:top;">
													TO THE ORDER
												</td>
												<td  style="vertical-align:top;font-weight:bold">13. Notify Party :</td>
												<td colspan="3">
													<?=$buyer_other_consign?>
												</td>
												 
											</tr> 
											 <tr>
												<td style="font-weight:bold"> 3. Pre Carriage By</td>
												<td style="font-weight:bold">4. Place of Receipt by Pre-Carrier </td>
												<td style="font-weight:bold">14. Country of Origin of Goods :</td>
												<td style="font-weight:bold" colspan="3">15. Country of Final Destination of Goods :
												</td>
											 </tr>
											 
											 <tr>
												<td>
													<?=$pre_carriage_by?>
												</td>
												<td>
													<?=$place_of_receipt?>
												</td>
												<td>
													<?=$country_origin_goods?>
												</td>
												<td colspan="3">
														<?=$country_final_destination?>
												</td>
											</tr>
											  <tr>
												<td style="font-weight:bold">5. Vessel / Flight Name & No </td>
												<td style="font-weight:bold">6. Port Of Loading	 </td>
												 <td colspan=""  style="font-weight:bold">Container Details</td>
												 <td style="font-weight:bold" colspan="3">Delivery</td>
												
											  </tr>
											  <tr>
													
												<td>
													<?=$flight_name_no?>
												</td>
												<td>
													<?=$export_port_loading?>
												</td>
												<td>
														<?=$no_of_container?> X <?=$container_size?> FT FCL
													</td>
													 <td colspan="3"> 
														<?=$export_terms_of_delivery?>
													</td>
											</tr> 
											<tr>
												<td style="font-weight:bold"> 7. Port Of Discharge</td>
												<td style="font-weight:bold" > 8. Place of Delivery</td>
												 <td rowspan="2" style="font-weight:bold">16. Terms of  Payment:</td>
												 <td colspan="3" rowspan="2" >
												 	<?=$export_payment_terms?>
												 </td>
											 </tr>
											 <tr>
													<td> <?=$port_of_discharge?></td>
												<td  > <?=$final_destination?></td>
												</tr>
								</table>
										 </div>
								 
								
								<h3>ANNEXURE - CI</h3>
									<div class="" style="padding:10px;" >	 
											<div class="panel-body">
												<div class="table-responsive">
												<table cellspacing="0" cellpadding="0" width="100%" class="table">
															<tr>
																<td style="padding:0px" width="5%"> </td>
																<td style="padding:0px" width="25%"> </td>
																<td style="padding:0px" width="20%"> </td>
																<td style="padding:0px" width="20%"> </td>
																<td style="padding:0px" width="30%"> </td>
														 	 </tr>
															<tr>
																<td style="text-align:center" colspan="5"> <strong>ANNEXURE - CI</strong></td>
															 </tr>
															 <tr>
																<td style="text-align:center" colspan="2"> 
																	RANGE
																</td>
																<td style="text-align:center" colspan="2"> 
																	DIVISION
																</td>
																<td style="text-align:center"> 
																	Commissionerate
																</td>
															 </tr>
															 <?php
																	 $range = '';
																	 $division = '';
																	if($company_detail[0]->s_c_type == "Merchant")
																	{
																 
																		$export_range=array();
																		$export_division=array();
																		foreach($export_supplier_data as $sup_row){ 
																			array_push($export_range,$sup_row->sup_range); 
																			array_push($export_division,$sup_row->division); 
																		}
																		$range 	  = implode(",",array_unique($export_range));
																		$division = implode(",",array_unique($export_division));
																	}
																	else
																	{
																		$range =  $company_detail[0]->com_range;
																		$division =  $company_detail[0]->com_division;
																	}
																	
															 ?>
															 <tr>
																<td style="text-align:center" colspan="2"> 
																	<?php
																	if(!empty($range))
																	{
																		?>
																		<input type="hidden"  id="range" class="form-control" name="range" value="<?=$range?>" >
																		<?=$range?>
																		<?php 
																	}
																	else
																	{
																		$range = $annexuredata->ex_range;
																		?>
																		<input type="text" id="range" placeholder="Range" class="form-control" name="range" value="<?=$range?>" >
																		<?php
																	}
																	?>
																</td>
																<td style="text-align:center" colspan="2"> 
																	 
																	<?php
																	if(!empty($division))
																	{
																		?>
																		<input type="hidden"   id="division" class="form-control" name="division" value="<?=$division?>" >
																		<?=$division?>
																		<?php 
																	}
																	else
																	{
																		$division = $annexuredata->division;
																		?>
																		<input type="text" placeholder="Division" id="division" class="form-control" name="division" value="<?=$division?>" >
																		<?php
																	}
																	?>
																</td>
																<td style="text-align:center"> 
																	<input type="text" placeholder="Commissionerate" id="commissionerate" class="form-control" name="commissionerate" value="<?=$commissionerate?>" >
																</td>
															 </tr>
															  <tr>
														 	   <td align="left" colspan="2">Sr No. : <input type="text" placeholder="Sr. NO." id="c_no" class="form-control" name="c_no" value="<?=$annexuredata->c_no?>" ></td>
														 	   <td align="left">Date :  <input type="text" placeholder="Date" id="c_date" class="form-control defualt-date-picker" name="c_date" value="<?=(!empty($annexuredata)  && $annexuredata->c_date != "1970-01-01")?date('d-m-Y',strtotime($annexuredata->c_date)):""?>" ></td>
														 	   <td align="left">Shipping Line :  <input type="text" placeholder="Shipping Line" id="Shipping_bill_no" class="form-control" name="Shipping_bill_no" value="<?=$annexuredata->Shipping_bill_no?>" ></td>
														 	   <td align="left">Date :  <input type="text" placeholder="Shipping Date" id="Shipping_date" class="form-control defualt-date-picker" name="Shipping_date" value="<?=(!empty($annexuredata) && $annexuredata->Shipping_date != "1970-01-01")?date('d-m-Y',strtotime($annexuredata->Shipping_date)):""?>" ></td>
                                </tr>
															  <tr>
																<td style="text-align:center" colspan="5"> 
																	&nbsp;
																</td>
																 
															 </tr>
															 <tr>
																<td style="text-align:center" colspan="5"> 
																	<strong>Examinationa Report for Factory Sealed Pakages / Container</strong>
																</td>
															  </tr>
															  <tr>
																<td style="vertical-align:top;"> 
																	1) 
																</td>
																<td style="vertical-align:top;"> 
																	 Name of Exporter and Address
																</td>
																<td colspan="3"> 
																	<?=$export?>
																</td>
															  </tr>
															  <tr>
																<td style="vertical-align:top;"> 
																	2) 
																</td>
																<td style="vertical-align:top;"> 
																	a) IEC No
																</td>
																<td colspan="3"> 
																	<?=$exporter_iec?>		
																</td>
															  </tr>
															  <tr>
																<td style="vertical-align:top;"> 
																	  
																</td>
																<td style="vertical-align:top;"> 
																	b) GSTIN No
																</td>
																<td colspan="3"> 
																	<?=$exporter_gstin?>		
																</td>
															  </tr>
															   <tr>
																<td style="vertical-align:top;"> 
																	  
																</td>
																<td style="vertical-align:top;"> 
																		C) BRANCH CODE NO
																</td>
																<td colspan="3">
																	<?php 
																	if($userdata->branch_code == 1)
																	{
																		?>
										<select class="form-control" name="company_branch_id" id="company_branch_id"    >
										 <option value="">Select Branch Code</option>
										<?php 
										for($i=0; $i<count($get_company_branch);$i++)
										{
											$selected='';
											if($get_company_branch[$i]->company_branch_id==$branch_code)
											{
												$selected = 'selected="selected"';
											}
											 
										?>
											<option <?=$selected?> value="<?=$get_company_branch[$i]->company_branch_id?>">
												<?=$get_company_branch[$i]->company_branch_code?> - <?=$get_company_branch[$i]->company_branch_name?>
											</option>
										<?php
										}
										?>
									 
										</select>
																		<?php
																	}
																	else
																	{
																	?>
																	<input type="text" placeholder="Branch Code" id="company_branch_id" class="form-control" name="company_branch_id" value="<?=$branch_code?>" >
																	
																		<?php	
																	}
																	?>
																	 
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
																	<td style="vertical-align:top;"> 
																		<?=($no==1)?"3)":""?>	
																	</td>
																	<td style="vertical-align:top;"> 
																		<?=($no==1)?"Name of Manufacture":""?>	
																	</td>
																	<td colspan="3"> 
																		<?=$sup_row->company_name?>		
																	</td>
																</tr>
																<tr>
																	<td style="vertical-align:top;"> 
																		<?=($no==1)?"4)":""?>	
																	</td>
																	<td style="vertical-align:top;"> 
																		<?=($no==1)?"Manufacturer's Address":""?>	
																	</td>
																	<td colspan="3"> 
																		<?=$sup_row->address?>		
																	</td>
																</tr>
																<tr>
																	<td style="vertical-align:top;"> 
																		<?=($no==1)?"5)":""?>	
																	</td>
																	<td style="vertical-align:top;"> 
																		<?=($no==1)?"Manufacturer's GSTIN No.":""?>	
																	</td>
																	<td colspan="3"> 
																		<?=$sup_row->supplier_gstno?>		
																	</td>
																</tr>
																<?php 
																}
															}
															?>
															<tr>
																	<td style="vertical-align:top;"> 
																		 6)	
																	</td>
																	<td style="vertical-align:top;"> 
																		Date of Examination
																	</td>
																	<td colspan="3"> 
																		<input type="text" placeholder="Date" id="examination_date" style="font-weight:bold;" class="form-control defualt-date-picker" name="examination_date" value="<?=$examination_date?>" title="Enter Date of Examinantion" /> 
																	</td>
																</tr>
																<tr>
																	<td style="vertical-align:top;"> 
																		 7)	
																	</td>
																	<td style="vertical-align:top;" colspan="4"> 
																		 Certificate that the descrition and value of the goods covered by this invoice have been checked by me and that goods have been packed and sealed <br>
																		 with one time seal No.
																		 <?php 
																		 $rfidseal_no_array =array();
																		 $con_array=array();	
																		for($i=0; $i<count($product_data);$i++)
																		{
																			if(!in_array($product_data[$i]->con_entry,$con_array))
																			{
																			 	array_push($rfidseal_no_array,$product_data[$i]->self_seal_no);
																				array_push($con_array,$product_data[$i]->con_entry);
																			}
																		}
																			echo "&nbsp;&nbsp;&nbsp;&nbsp;".implode(", ",array_filter($rfidseal_no_array));
																		 ?>
																	</td>
																</tr>
																<tr>
																	<td style="vertical-align:top;"> 
																		 8)	
																	</td>
																	<td style="vertical-align:top;"> 
																		Name and designation of the superwison officer
																	</td>
																	<td colspan="3"> 
																		<input type="text" placeholder="Name Of Superintendent" id="name_of_superintendent" style="font-weight:bold;" class="form-control" name="name_of_superintendent" value="<?=!empty($annexuredata->name_of_superintendent)?$annexuredata->name_of_superintendent:"Self"?>" title="Enter name_of_superintendent" />
																	</td>
																</tr>
																<tr>
																	<td style="vertical-align:top;"> 
																		9)
																	</td>
																	<td style="vertical-align:top;"> 
																		a) Name of Comm, Division & Range
																	</td>
																	<td> 
																		 <?php
																	 $range='';
																	 $division='';
																	if($company_detail[0]->s_c_type == "Merchant")
																	{
																 
																	$export_range=array();
																	$export_division=array();
																	foreach($export_supplier_data as $sup_row){ 
																	array_push($export_range,$sup_row->sup_range); 
																	array_push($export_division,$sup_row->division); 
																	}
																		$range = implode(",",$export_range);
																		$division = implode(",",$export_division);
																	}
																	else
																	{
																		$range =  $company_detail[0]->com_range;
																		$division =  $company_detail[0]->com_division; 
																	}
																	echo $range;
																	?>
																	</td>
																	<td colspan="2">
																		<?=$division?>
																	</td> 
																		
																</tr>
																<tr>
																	<td style="vertical-align:top;"> 
																		 
																	</td>
																	<td style="vertical-align:top;"> 
																		b) Location Code
																	</td>
																	<td colspan="3"> 
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
																	<td style="vertical-align:top;"> 
																		 10)
																	</td>
																	<td   colspan="4" style="vertical-align:top;"> 
																		Particulars of Export Invoice 
																	</td>
																 </tr>
																 <tr>
																	<td style="vertical-align:top;"> 
																		 
																	</td>
																	<td  style="vertical-align:top;"> 
																		Invoice No.
																	</td>
																	<td  style="vertical-align:top;"> 
																		<?=$invoicedata->export_invoice_no?>
																	</td>
																	<td colspan="2" style="vertical-align:top;"> 
																		Date: <?=date('d/m/Y',strtotime($invoicedata->invoice_date))?>
																	</td>
																 </tr>
																 <tr>
																	<td style="vertical-align:top;"> 
																		 
																	</td>
																	<td  style="vertical-align:top;"> 
																		Total No. of Packages 
																	</td>
																	<td  style="vertical-align:top;" colspan="3" id="total_pakage"> 
																	 </td>
																 </tr>
																  <tr>
																	<td style="vertical-align:top;"> 
																		 
																	</td>
																	<td  style="vertical-align:top;"> 
																		Name & address of Consignee
																	</td>
																	<td  style="vertical-align:top;" colspan="3"> 
																		To The Order
																	 </td>
																 </tr>
																 <tr>
																	<td style="vertical-align:top;"> 
																		 11
																	</td>
																	<td colspan="3" style="vertical-align:top;"> 
																		a) The description or the Goods/ Quantity & Value as per particular's of furnished as per Export Invoice
																	</td>
																	<td  style="vertical-align:top;"> 
																		<input type="checkbox"  id="description_goods_status"  class="form-control" name="description_goods_status" value="1" <?=($annexuredata->description_goods_status==1)?"checked":""?> checked />
																	 </td>
																 </tr>
																 <tr>
																	<td style="vertical-align:top;"> 
																		 
																	</td>
																	<td colspan="3" style="vertical-align:top;"> 
																		b) Whether Sample is drawn for being forwarded to Port of Export
																	</td>
																	<td  style="vertical-align:top;"> 
																		<input type="checkbox"  id="drawn_port_export"  class="form-control" name="drawn_port_export" value="1" <?=($annexuredata->drawn_port_export==1)?"checked":""?> />
																	 </td>
																 </tr>
																 <tr>
																	<td style="vertical-align:top;"> 
																		 
																	</td>
																	<td colspan="3" style="vertical-align:top;"> 
																		c) The No's of the Seal of the paksges containing the semple
																	</td>
																	<td  style="vertical-align:top;"> 
																		<input type="checkbox"  id="seal_yesno"  class="form-control" name="seal_yesno" value="1" <?=($annexuredata->seal_yesno==1)?"checked":""?> />
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
																	<td style="vertical-align:top;"> 
																		12)
																	</td>
																	<td  style="vertical-align:top;"> 
																		Permission No
																	</td>
																	<td  colspan="3" style="vertical-align:top;"> 
																		<?=$sup_row->permission_no?>
																	 </td>
																 </tr>
																 <tr>
																	<td style="vertical-align:top;"> 
																		13)
																	</td>
																	<td  style="vertical-align:top;"> 
																		Self - Sealing Permission No.
																	</td>
																	<td  colspan="3" style="vertical-align:top;"> 
																		<?=$sup_row->issue_authority_address?>  
																	 </td>
																 </tr>
																 <?php $no++;
																	}
																}
																else
																{
																?>
																 <tr>
																	<td style="vertical-align:top;"> 
																		12) 
																	</td>
																	<td  style="vertical-align:top;"> 
																		Permission No
																	</td>
																	<td  colspan="3" style="vertical-align:top;"> 
																		<?=$company_detail[0]->permission_no?>
																	 </td>
																 </tr>
																 <tr>
																	<td style="vertical-align:top;"> 
																		13)
																	</td>
																	<td  style="vertical-align:top;"> 
																		Self - Sealing Permission No.
																	</td>
																	<td  colspan="3" style="vertical-align:top;"> 
																		<?=$company_detail[0]->issue_authority_address?>    
																	 </td>
																 </tr>
																<?php
																}
																?>
																 <tr>
																	<td style="vertical-align:top;"> 
																		 
																	</td>
																	<td  style="vertical-align:top;"> 
																		b) Containerised Cargo Details
																	</td>
																	<td  colspan="3" style="vertical-align:top;"> 
																		<input type="text" placeholder="Containerized Cargo" style="font-weight:bold;width:50%;float:left" id="containerized_cargo" class="form-control" name="containerized_cargo"   title="Enter Containerized Cargo" value="<?=$annexuredata->containerized_cargo?>">	   
																	 </td>
																 </tr>
												</table>
										 	  <table cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #333;padding: 5px;" class="pdf_class">
													<tr>
														<td style="padding:0px;" width="25%"></td>
														<td style="padding:0px;" width="25%"></td>
														<td style="padding:0px;" width="25%"></td>
														<td style="padding:0px;" width="25%"></td>
												 	</tr>
													 
													<tr>
													  	<td style="font-weight:bold;text-align:center">Container No.</td>
													    <td style="font-weight:bold;text-align:center">Shipping Line Seal No.</td>
														<td style="font-weight:bold;text-align:center">Shipper Seal	</td>
														<td style="font-weight:bold;text-align:center">No. of Stuffed Packages</td>
													 	</tr>
												<?php
									 
											$Total_plts = 0;
											 	$Total_box = 0;
												$Total_net_weight = 0;
												$Total_gross_weight = 0;
												$total_container =0;
												$con_array=array();	
												
											if(!empty($product_data))
											{		
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												for($i=0; $i<count($product_data);$i++)
												{
												$sample_str = '';	  
											  	?>
												
													<?php
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowcon_no > 1)?$product_data[$i]->rowcon_no:'';
														$total_package = $product_data[$i]->total_ann_package;
														
															if(empty($sample_str))
															{
															 
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																	 $total_package += $sample_row->no_of_boxes;
																 }
																 
															}
															
												 	?>
												<tr>	 
													 <td style="text-align:center">
														 <?=$product_data[$i]->container_no?>
													</td>
													 <td style="text-align:center">
														 <?=$product_data[$i]->seal_no?> 
													</td>
													 <td style="text-align:center">
														<?=$product_data[$i]->self_seal_no?>
													</td>
													<td style="text-align:center"> 
														<?=$total_package?>
													 </td> 
													 </tr>
													<?php 
													 $Total_box 		+= $total_package;
														array_push($con_array,$product_data[$i]->con_entry);
													}
													?>
											 	 
											 	
										 		<?php
												
												}
											}
											else
											{
												echo "<tr>
														<td  class='text-center' colspan='14'>Container Not set</td>
														</tr>";
											}
										 
									 for($row=$no_rows;$row>0;$row--)
									 {
										 ?>
													<tr>
															<td style="text-align:center;border-top:none;border-bottom:none"> &nbsp;</td>                        
															<td style="text-align:center;border-top:none;border-bottom:none"> </td>                        
															<td style="text-align:center;border-top:none;border-bottom:none"> </td>                        
															<td style="text-align:center;border-top:none;border-bottom:none"> </td>
														 	 
														 </tr>
										 <?php 
									 }
									 ?>
									 
									 
								</table>
								<br>
								Annexure Remarks
								<textarea  id="annexure_remarks" class="form-control" name="annexure_remarks" placeholder="Annexure Remarks"><?=strip_tags($annexure_remarks)?></textarea>
							 	
												</div>
												
											</div>
									 
								</div>
								</div>
								<div style="padding: 14px;padding-left:0px;">
									<button class="btn btn-success" type="submit">Save & Next</button>
									 
									<a href="<?=($invoicedata->direct_invoice == 1)?base_url().'exportinvoicesample/index/'.$invoicedata->export_invoice_id:base_url().'exportinvoicesupplier/index/'.$invoicedata->export_invoice_id?>" class="btn btn-danger">
											Back
									</a>
								 
								 	<input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"> 
								 	<input type="hidden" id="advance_payment_id" name="advance_payment_id" value="<?=$invoicedata->advance_payment_id?>"> 
								 	<input type="hidden" id="grand_total" name="grand_total" value="<?=$invoicedata->grand_total?>"> 
									<input type="hidden" id="export_annexure_id" name="export_annexure_id" value="<?=$annexuredata->export_annexure_id?>"> 
									<div class="errormsg" style="color:red"></div>
									<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
								</div>
							 </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
 <script>
 
function filterbystatus(val)
{
	if(val==1)
	{
		$(".withouthtml").show();
		$(".withhtml").hide();
	}
	else
	{
		$(".withouthtml").hide();
		$(".withhtml").show();
	}
}
</script>
<?php $this->view('lib/footer');

echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>"; ?>
<script>
 $("#total_pakage").html(<?=$Total_box?> + ' Boxes')
$( function() {
    $( "#accordion" ).accordion({
		active:1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
 
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 }); 
</script>
 
 
<script>
$(".select2").select2({
	width:'100%'
});
 
$("#exportinvoice_exporter_form").submit(function(event) {
	event.preventDefault();
	
	
	var inps = document.getElementsByName('exportproducttrn_id[]');
	var no=1;
	for (var i = 0; i <inps.length; i++) {
			var inp=inps[i];
			var inpschild = document.getElementsByName('container_detail'+inp.value+'[]');
			 
			for (var j = 0; j <inpschild.length; j++) {
				 
				if($("#container_detail"+no+j).val()=="")
				{
					$("#container_detail"+no+j).focus();
					return false;
				}
				else if($("#seal_no"+no+j).val()=="")
				{
					$("#seal_no"+no+j).focus();
					return false;
				}
				else if($("#rfidseal_no"+no+j).val()=="")
				{
					$("#rfidseal_no"+no+j).focus();
					return false;
				}
			 }
		no++;	
	}
	 
	block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url: 	root+'exportinvoiceannexure/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				 
				if(obj.res==1)
			   {
				   $("#exportinvoice_exporter_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'exportinvoiceview/without_design/'+<?=$invoicedata->export_invoice_id?> },1000);
				}
				else if(obj.res==2)
			   {
				    
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'exportinvoiceview/without_design/'+<?=$invoicedata->export_invoice_id?> },1000);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
			   }
			    
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	}); 
});
 
	</script>

  