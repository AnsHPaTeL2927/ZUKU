<?php 
$this->view('lib/header'); 
    
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
 if($invoicedata->Exchange_Rate_val==0)
 {
	 $exchangerate = $userdata->usd;
 }
 else{
	 $exchangerate = $invoicedata->Exchange_Rate_val;
 }
?>	
<script>
function calc_from_popup(val)
 {
	  var radioValue = $("#pallet_status"+val).val();
	  
	 if(radioValue==1)
	 {
		
		var sqm_per_box 		= $('#sqm_per_box'+val).val();
		var product_rate 		= $('#product_rate'+val).val();
		var boxes_per_pallet	= $('#boxes_per_pallet'+val).val();
		var weight_per_box 		= $('#weight_per_box'+val).val();
		var pallet_weight 		= $('#pallet_weight'+val).val();
		var product_rate_per 	= $('#product_rate_per'+val).val();
		var feet_per_box 		= $('#feet_per_box'+val).val();
		var pcs_per_box 		= $('#pcs_per_box'+val).val();
			if($('#no_of_pallet'+val).val() != undefined && $('#no_of_pallet'+val).val() != "" )
			{
			 	var no_of_pallet 			= $('#no_of_pallet'+val).val();
			 	var no_of_boxes 			= $('#no_of_pallet'+val).val() * boxes_per_pallet;
				$('#no_of_boxes'+val).val(no_of_boxes.toFixed(2));
				 
				var no_of_sqm 	= no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				$('#sqm_html'+val).html(no_of_sqm.toFixed(2));
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
					var net_weight = (parseFloat(no_of_boxes) * parseFloat(weight_per_box))
					 $('#packing_net_weight_html'+val).html((net_weight).toFixed(2));
					 $('#packing_net_weight'+val).val((net_weight).toFixed(2));
					 var pallet_weight = parseFloat(no_of_pallet) * parseFloat(pallet_weight);
					var product_total_amount = 0;
					if(product_rate_per == "SQM")
					{
						var product_total_amount = parseFloat(product_rate) * parseFloat(no_of_sqm);
						 
					}
					else if(product_rate_per == "BOX")
					{
						var product_total_amount = parseFloat(product_rate) * no_of_boxes;
				 	}
					else if(product_rate_per == "SQF")
					{
						var product_total_amount = parseFloat(product_rate) * no_of_boxes * feet_per_box;
					} 
					else if(product_rate_per == "PCS")
					{
						var product_total_amount = parseFloat(product_rate) * no_of_boxes * pcs_per_box;
					} 
				 	$('#packing_gross_weight_html'+val).html((parseFloat(pallet_weight)+parseFloat(net_weight)).toFixed(2));
					$('#packing_gross_weight'+val).val((parseFloat(pallet_weight)+parseFloat(net_weight)).toFixed(2));
					 
					$('#product_amt_html'+val).html((product_total_amount).toFixed(2));
					$('#product_amt'+val).val((product_total_amount).toFixed(2));
					
					$('#total_pallet_weight'+val).val(parseFloat(pallet_weight).toFixed(2));
		  	}
	 }
	 else if(radioValue==2)
	 {
		 var weight_per_box = $('#weight_per_box'+val).val();
		 var sqm_per_box 	= $('#sqm_per_box'+val).val();
		 var feet_per_box 	 = $('#feet_per_box'+val).val(); 
		 var pcs_per_box 		= $('#pcs_per_box'+val).val();
			if($('#only_no_of_boxes'+val).val() != undefined && $('#only_no_of_boxes'+val).val() != "")
			{
				var no_of_boxes = $("#only_no_of_boxes"+val).val();
				var rate_usd_val = $('#product_rate'+val).val();
				var product_rate_per = $('#product_rate_per'+val).val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				  
					if(product_rate_per == "SQM")
					{
						var product_total_amount = parseFloat(rate_usd_val) * parseFloat(no_of_sqm);
					}
					else if(product_rate_per == "BOX")
					{
						var product_total_amount = parseFloat(rate_usd_val) * parseFloat(no_of_boxes);
						
					}
					else if(product_rate_per == "SQF")
					{
						var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
					} 
					else if(product_rate_per == "PCS")
					{
						var product_total_amount = parseFloat(product_rate) * no_of_boxes * pcs_per_box;
					}   
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
			 	$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
	 	 	}
	 } 
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box'+val).val();
		 var product_rate 			= $('#product_rate'+val).val();
		 var feet_per_box 	 		= $('#feet_per_box'+val).val();
		 var box_per_big_pallet 	= $('#box_per_big_pallet'+val).val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet'+val).val();
		 var big_pallet_weight 		= $('#big_pallet_weight'+val).val();
		 var small_pallet_weight 	= $('#small_pallet_weight'+val).val();
		 var sqm_per_box 			= $('#sqm_per_box'+val).val();
	 	 var pcs_per_box 			= $('#pcs_per_box'+val).val();
		 	if($('#no_of_big_pallet'+val).val() != undefined && $('#no_of_big_pallet'+val).val() != "" )
			{
				var rate_usd_val 			= $('#product_rate'+val).val();
				var no_of_big_pallet 		= $('#no_of_big_pallet'+val).val();
				var no_of_small_pallet 		= $('#no_of_small_pallet'+val).val();
				var product_rate_per 		= $('#product_rate_per'+val).val();
		
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+val).val(no_of_boxes.toFixed(2));
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				 
				 	if(product_rate_per == "SQM")
					{
						var product_total_amount = parseFloat(product_rate) * parseFloat(no_of_sqm);
					}
					else if(product_rate_per == "BOX")
					{
						var product_total_amount = parseFloat(product_rate) * parseFloat(no_of_boxes);
						
					}
					else if(product_rate_per == "SQF")
					{
						var product_total_amount = parseFloat(product_rate) * no_of_boxes * feet_per_box;
					} 
					else if(product_rate_per == "PCS")
					{
						var product_total_amount = parseFloat(product_rate) * no_of_boxes * pcs_per_box;
					}   
				
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
			 	var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
		 	}
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
							<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
						</li>
						 
				</ol>
				<div class="page-header title1">
				<h3>Export Invoice Packing Detail</h3>
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class=" panel-default">
				<form name="exportinvoice_packing_form" id="exportinvoice_packing_form" action="javascript:;">
				 
				 <div id="accordion">
				 <h3>
					 Export Invoice Detail
				  </h3>   
					<div class="" style="padding:10px;" >
						<table cellspacing="0" cellpadding="0"    width="100%">
										<tr>
											<td colspan="12"  style="font-weight:bold;vertical-align: bottom;text-align: center;">
												SUPPLY MEANT FOR EXPORT UNDER LUT WITHOUT PAYMENT OF IGST (LUT: <?=$company_detail[0]->s_lutno?>)
											</td>
										</tr>
										<tr>
											<td rowspan="6" width="1%">
												<span>E</span><br>	
												<span>X</span><br>		
												<span>P</span><br>	
												<span>O</span><br>		
												<span>R</span><br>		
												<span>T</span><br>		
												<span>E</span><br>	
												<span>R</span>
											</td>
											<td colspan="6" rowspan="3" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
												<?=$export?>
											</td>
											<td width="15%">Export Invoice No</td>
											<td width="15%" colspan="2" style="font-weight:bold">
												<?=$exportinvoice_no?>
											</td>
											<td  width="11%" >DATE</td>
											<td  width="12%" style="font-weight:bold">
												<?=$export_date?>
											</td>
										</tr>
										<tr>
										 	<td>Export Ref. No</td>
										 	<td colspan="2" style="font-weight:bold" >
										 		<?=$export_ref_no?>
										 	</td>
										 	<td> PI-DATE</td>
										 	<td style="font-weight:bold"> 
										 		<?=$performa_date?>
										 	</td>
										 </tr>
										 <tr>
										 	<td rowspan="4">Buyer Order No &amp; Date</td>
										 	<td rowspan="4" colspan="4" style="font-weight:bold">
										 			<?=$buy_order_no?>
										 		</td>
										  </tr>
										 <tr>
										 	<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px;">
												Email
											</td>
											<td width="3%">:</td>
											<td width="15%" colspan="2" style="font-weight:bold"> 
												<?=$exporter_email?>
											</td>
											<td width="5%">MOBILE</td>
											<td width="15%" style="font-weight:bold" >
												<?=$exporter_mobile?>
											</td>
												
											</tr>
											<tr>
												<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">GSTIN</td>
												<td width="3%">:</td>
												<td width="15%" colspan="2" style="font-weight:bold"> 
														<?=$exporter_gstin?>
												</td>
												<td width="5%">PAN NO</td>
												<td width="15%" style="font-weight:bold" >
													<?=$exporter_pan?>
												</td>
												
											</tr>
											<tr>
												<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">IEC</td>
												<td width="3%">:</td>
												<td width="15%" colspan="4" style="font-weight:bold"> 
													<?=$exporter_iec?>
												</td>
											</tr>
											<tr>
												<td rowspan="2" style="font-size: 11px;">
													<span>C</span><br>	
													<span>O</span><br>		
													<span>N</span><br>	
													<span>S</span><br>		
													<span>I</span><br>		
													<span>G</span><br>		
													<span>N</span><br>	
													<span>E</span><br>
													<span>E</span>
												</td>
												<td colspan="3">CONSIGNEE NAME :</td>
												 <td colspan="3" style="font-weight:bold">
													 <?=$consign_name?>
												</td>
												 <td colspan="5">
												  
												 </td>
											</tr>
											<tr>
												<td colspan="6" style="font-weight:bold">
														<?=$consign_address?>
												</td>
												<td >Buyer If Other Then Consignee [Notify]</td>
												<td colspan="4" style="font-weight:bold">
													<?=$buyer_other_consign?>
												</td>
											</tr>
											<tr>
												<td colspan="4">Pre Carriage By</td>
												<td colspan="3">Place of Receipt </td>
												<td colspan="2">Country of Origin</td>
												<td colspan="3">Country of Destination </td>
											 </tr>
											 <tr>
												<td colspan="4" style="font-weight:bold">
													<?=$pre_carriage_by?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$place_of_receipt?>
												</td>
												<td colspan="2" style="font-weight:bold">
													<?=$country_origin_goods?>
												</td>
												<td colspan="3" style="font-weight:bold">
														<?=$country_final_destination?>
												</td>
											</tr>
											  <tr>
												<td colspan="4">Vessel / Flight Name & No </td>
												<td colspan="3">Port Of Loading	 </td>
												<td   rowspan="4">Bank Details  </td>
												<td colspan="4" rowspan="4" style="font-weight:bold">
													<?=($bank_detail)?>
												</td>
											  </tr>
											  <tr>
												<td colspan="4" style="font-weight:bold">
													<?=$flight_name_no?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$export_port_loading?>
												</td>
											</tr> 
											  <tr>
												<td colspan="4">Port Of Discharge</td>
												<td colspan="3">Final Destination </td>
												 
											  </tr>
											<tr>
												<td colspan="4" style="font-weight:bold;text-align:center">
														<?=$port_of_discharge?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$final_destination?>
												</td>
												</tr>
												<tr>
															<td colspan="5">Container Details</td>
															<td colspan="2">Nature Of Contract</td>
															<td rowspan="2">Payment Terms</td>
															<td colspan="4" rowspan="2" style="font-weight:bold">
																<?=$export_payment_terms?>
															</td>
													</tr>
												<tr>
													<td colspan="2" style="font-weight:bold">
														<?=$no_of_container?>
													</td>
													<td style="font-weight:bold">X</td>
													<td colspan="2" style="font-weight:bold"><?=$container_size?> FT FCL</td>
													<td colspan="2" style="font-weight:bold">
														<?=$export_terms_of_delivery?>
													</td>
												</tr>
				 
								</table>
								</div>
							  <h3>
								Product Packing Detail
							  </h3>  
								<div class="">
									<div class="panel-body">
										 
										<div class="pull-left form-group">
											<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">Import From excel (Container Detail) </button>-->
									 	</div>
										 <div class="table-responsive">
												<table  class="table table-bordered table-hover" width="100%" cellspacing="0" cellpadding="0" style="">
												 	<tr>
													  	<td style="font-weight:bold;text-align:center">Container No.</td>
													    <td style="font-weight:bold;text-align:center">Line Seal</td>
														<td style="font-weight:bold;text-align:center">Self Seal	</td>
														<td style="font-weight:bold;text-align:center">Container Type	</td>
														<td style="font-weight:bold;text-align:center">Pallet No	</td>
														<td style="font-weight:bold;text-align:center">Trunk No	</td>
														<td style="font-weight:bold;text-align:center">Size (in mm)</td>
														<td style="font-weight:bold;text-align:center">Design Name</td>
														<td style="font-weight:bold;text-align:center">Shade No </td>
														<td style="font-weight:bold;text-align:center">Pallet.</td>
														<td style="font-weight:bold;text-align:center">Sqm.</td>
														<td style="font-weight:bold;text-align:center">Boxes.</td>
														<td style="font-weight:bold;text-align:center">Quantity </td>
														<td style="font-weight:bold;text-align:center">Unit </td>
														<td style="font-weight:bold;text-align:center">Net Weight in Kg</td>
														<td style="font-weight:bold;text-align:center">Gross Weight in Kg</td>
														<td style="font-weight:bold;text-align:center">Action</td>
														 
												 	</tr>
											<?php
													$no_of_container		 		= $invoicedata->container_details;
													$no=0;
													$fill_container_status 			= array();
													$export_loading_trn_id_array 	= array();
													$con_entry_array 	= array();
													$performa_packing_array 		= array();
													$packingtrn_array 				= array();
													$container_array 				= array();
													$Total_plts  					= 0;
													$Total_box   					= 0;
													$Total_sqm   					= 0;
													$total_net_weight 				= 0;
													$total_gross_weight 			= 0;
													$Total_ammount 					= 0;
												
												  foreach($loadingtrn_data as $row)
												  {
													   
													  $no_of_container--;
														 $sample_str = '';
														 array_push($performa_packing_array,$row->export_packing_id);
														 
														 if(!in_array($row->export_packing_id,$packingtrn_array))
														 {
															 array_push($packingtrn_array,$row->export_packing_id);
															 
															 $packingtrnarray[$row->export_packing_id] = array();
															 $packingtrnarray[$row->export_packing_id]['no_of_boxes']  = $row->origanal_boxes;
															 $packingtrnarray[$row->export_packing_id]['no_of_pallet']  = $row->origanal_pallet;
															 $packingtrnarray[$row->export_packing_id]['no_of_big_pallet']  = $row->orginal_no_of_big_pallet;
															 $packingtrnarray[$row->export_packing_id]['no_of_small_pallet']  = $row->orginal_no_of_small_pallet;
															 
														 }
														 else
														 {
															 $packingtrnarray[$row->export_packing_id]['no_of_boxes'] += $row->origanal_boxes;
															 $packingtrnarray[$row->export_packing_id]['no_of_pallet'] += $row->origanal_pallet;
															 $packingtrnarray[$row->export_packing_id]['no_of_big_pallet'] += $row->orginal_no_of_big_pallet;
															 $packingtrnarray[$row->export_packing_id]['no_of_small_pallet'] += $row->orginal_no_of_small_pallet;
															  
														 }
														  $netweight   = $row->updated_net_weight;
														  $grossweight = $row->updated_gross_weight;
												
														 
												 if(!empty($row->export_packing_id))
												  {		 
														?>
													  <tr>
													  <?php 
														if(!in_array($row->con_entry,$export_loading_trn_id_array))
														{ 
													 
														$rowcon_no  = ($row->rowspan_no > 1)?$row->rowspan_no:'1';
														$rowcon_no1 = ($row->rowspan_no > 1)?$row->rowspan_no:'1';
														 
												if(!empty($row->sample))
												{
													$sample_str = '';
													 
												  foreach($row->sample  as $sample_row)
												  {
													  if($sample_row->container_name == $row->container_no)
													  {
														  $rowcon_no++;
														  $sample_des = $sample_row->sample_remarks;
														  
															$sample_str .= '<tr>
																				<td style="text-align:center">
																					'.$sample_row->product_size_id.'
																				</td>
																			<td style="text-align:center" colspan="2">
																				'.$sample_des.'
																			</td>
																			<td style="text-align:center">
																				'.$sample_row->no_of_pallet.'
																			</td>
																			 
																			<td style="text-align:center">
																				'.$sample_row->sqm.'
																			</td>
																			<td style="text-align:center">
																				'.$sample_row->no_of_boxes.'
																			</td>
																			 
																			 
														 	</tr>
															<input type="hidden" name="container_no'.$sample_row->exportinvoicetrnid.'[]" id="container_no'.$container_no.$sample_row->export_sampletrn_id.'" value="'.$sample_row->container_name.'" />';
															
															 array_push($sample_data_array,$sample_row->container_name);
																 
																$netweight   += $sample_row->netweight;
																$grossweight += $sample_row->grossweight;
																 
													 
													  }
											 	  }
												   
												}
														?>
															 
															<td style="text-align:center" rowspan="<?=$rowcon_no?>">
																<?=$row->container_no?>
															</td>
															 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
																<?=$row->seal_no?>
															</td>
															 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
																<?=$row->self_seal_no?>
															</td>
															 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
																<?=$row->container_size?>
															</td>
															<td style="text-align:center" rowspan="<?=$rowcon_no?>">
																<?=$row->remark?>
															</td>
															<td style="text-align:center" rowspan="<?=$rowcon_no?>">
																<?=$row->truck_no?>
															</td>
														<?php 
														array_push($export_loading_trn_id_array,$row->con_entry);
														}
													 	 
										 
									 	 if(empty($row->product_id))
										 {
														$qty=0;
													 
															if($row->per == "SQM")
															{
														 		$qty = $row->origanal_sqm;
														 		 
														 	}
															else if($row->per == "BOX")
															{
													 			$qty = $row->origanal_boxes;
													 			 
													 		}
															else if($row->per == "SQF")
															{
													 			$qty = ($row->origanal_boxes);
													 			 
													 		}
															else if($row->per == "PCS")
															{
													 			$qty = ($row->origanal_boxes);
													 			 
													 		}
											?>
											<td colspan="2" style="text-align:center" >
															<?=$row->description_goods?>
													 	</td>
											<td style="text-align:center">
															<?=$row->shade_no?>
														</td>
														<td style="text-align:center">
															-	 
														</td>
														<td style="text-align:center">
															-
																	 
														</td>
														<td style="text-align:center">
														-
														</td>
														<td style="text-align:center">
														  	<?=$qty?>
														</td>
														<td style="text-align:center">
														  	<?=$row->per?>
														</td>			 
										 <?php  
										 }
										 else
										 {
											 
											 ?>
														<td style="text-align:center" >
															<?=$row->size_type_mm?>
													 	</td>
														<td style="text-align:center">
															<?=!empty($row->client_name)?$row->client_name:$row->model_name?>
														</td>
														<td style="text-align:center">
															<?=$row->shade_no?>
														</td>
														<td style="text-align:center">
															<?php 
															$no_of_pallet = '';
															if($row->origanal_pallet > 0)
															{
																$no_of_pallet = $row->origanal_pallet;
																$Total_plts   += $no_of_pallet;
															}
															else if($row->orginal_no_of_big_pallet > 0 || $row->orginal_no_of_small_pallet > 0)
															{
																$no_of_pallet = 'Big : '.$row->orginal_no_of_big_pallet.'<br> Small : '.$row->orginal_no_of_small_pallet;
																$Total_plts   += $row->orginal_no_of_big_pallet;
																$Total_plts   += $row->orginal_no_of_small_pallet;
															}
															?>
															<?=$no_of_pallet?>
																	 
														</td>
														<td style="text-align:center">
															<?=$row->origanal_sqm?>
																	 
														</td>
														<td style="text-align:center">
														  	<?=$row->origanal_boxes?>
														</td>
														<td style="text-align:center">
														  	-
														</td>
														<td style="text-align:center">
														  	-
														</td>
										 <?php  
										 }
										  
											 ?>				
														
														<?php 
														 
														if(!in_array($row->con_entry,$con_entry_array))
														{ 
														?>
														<td style="text-align:center" rowspan="<?=$rowcon_no?>">
														  	<?=$netweight?>
														</td>
														<td style="text-align:center" rowspan="<?=$rowcon_no?>">
														  	<?=$grossweight?>
														</td>
														<td style="text-align:center" rowspan="<?=$rowcon_no?>">
														  	<li>
																 <a class="tooltips btn btn-danger" data-title="Delete"  onclick="delete_product(<?=$row->export_invoice_id?>,'<?=$row->container_no?>')" href="javascript:;" ><i class="fa fa-trash"></i></a>
																</li>
														 </td>
												 	 	 <?php 
															array_push($con_entry_array,$row->con_entry);
														}
													 	?>
														<input type="hidden" name="export_packing_id[]" id="export_packing_id<?=$row->export_packing_id?>" value="<?=$row->export_packing_id?>" />
													</tr>
													  <?php
													  echo $sample_str;
													  $Total_box += $row->no_of_boxes;
													  $Total_sqm += $row->no_of_sqm;
													  $total_net_weight += $row->packing_net_weight;
													  $total_gross_weight += $row->packing_gross_weight;
													  $Total_ammount += $row->product_amt;
													 
												  }
												 
											}
												 
										 		?>
											 
											 </table>
										 </div>
								 </div>
									</div>
								</div>
								<div style="padding: 14px;padding-left:0px;">
									<button class="btn btn-success" >Save & Next</button>
									<a href="<?=base_url().'exportinvoicesupplier/index/'.$invoicedata->export_invoice_id?>" class="btn btn-danger">
											Back
									</a>
									<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
									<input type="hidden" id="make_container_array" name="make_container_array" value="0"> 
									<input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"> 
									<input type="hidden" id="export_step" name="export_step" value="<?=$invoicedata->step?>"> 
									<div class="errormsg" style="color:red"></div>
								</div>
							 </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
 
<?php $this->view('lib/footer'); ?>
<div id="Addsamplemodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg"  style="width:1200px">
        <!-- Modal content-->
        <div class="modal-content" style="max-height: 580px;overflow-y: auto;">
		
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Sample Product  </h4>
				
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="sample_product_form" id="sample_product_form">
            <div class="modal-body">
                <div class="row">
						<input type="hidden" id="exportinvoiceid" name="exportinvoiceid" value="<?=$invoicedata->export_invoice_id?>"> 
						<input type="hidden" id="exportinvoicetrnid" name="exportinvoicetrnid" value=""> 
						 
						
						<input type="hidden" id="no_of_sample" name="no_of_sample" value=""> 
						<div class="col-md-12"style="height:20px;">	</div>	
							<div id="editresponsesamplecontainer">
							</div>
						</div>  			
				</div>
			 
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Add" id="sample_submit_btn" class="btn btn-info"  /> 
                <button type="button"   class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 
			<input type="hidden" name="sample_mode" id="sample_mode"/>
			<input type="hidden" name="edit_total_sample_data" id="edit_total_sample_data"/>
			</form>
       
    </div>
</div>
</div>

 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">From Excel</h4>
            </div>
			  
            <div class="modal-body">
                <div class="row">
						<div class="col-md-12">
					 		<textarea placeholder="Paste Here.........." id="excel_data" class="form-control" name="excel_data" style="height:250px"></textarea>
					 	</div>
				 </div>
			</div>
            <div class="modal-footer">
			 	<button id="button_btn" type="button" onclick="paste_data()" class="btn btn-info">Import</button>            
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			  
        </div>
    </div>
</div>
 
 <div id="proformaproduct_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1100px;">
	
        
        <div class="modal-content" style="max-height: 600px;overflow-y: auto;">
			<form class="form-horizontal askform" name="set_container_form" id="set_container_form" action="javascript:;">
				
            <div class="modal-header">
                <!--<button type="button" onclick="close_modal()" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title">Copy Container <br> Select Container : <?=$no_of_container?></h4>
				
            </div>
			 <div class="modal-body">
                <div class="row">
				
				<div class="col-sm-4">
					<div class="form-group">
					 	<label class="col-sm-5 control-label" for="form-field-1">
					 		Container No
					 	</label>
					 	<div class="col-sm-7">
					 		<input type="text" placeholder="Container No" id="container_no" class="form-control" name="container_no" value="" >
					 	</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
					 	<label class="col-sm-5 control-label" for="form-field-1">
					 		Line Seal No
					 	</label>
					 	<div class="col-sm-7">
					 		<input type="text" placeholder="Line Seal No" id="line_seal_no" class="form-control" name="line_seal_no" value="" >
					 	</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
					 	<label class="col-sm-5 control-label" for="form-field-1">
					 		Self Seal No
					 	</label>
					 	<div class="col-sm-7">
					 		<input type="text" placeholder="Self Seal No" id="self_seal_no" class="form-control" name="self_seal_no" value="" >
					 	</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
					 	<label class="col-sm-5 control-label" for="form-field-1">
					 		Container Size
					 	</label>
					 	<div class="col-sm-7">
					 		 
							<label>
								<input type="radio" name="container_type" id="container_type1" value="20" checked=""> 
								<strong for="container_type1"> 20</strong>
							</label>
							<label>
							<input type="radio" name="container_type" id="container_type2" value="40"> 
								<strong for="container_type2"> 40</strong>
							</label>
							 	 
					 	</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
					 	<label class="col-sm-5 control-label" for="form-field-1">
					 		Trunk No
					 	</label>
					 	<div class="col-sm-7">
					 		<input type="text" placeholder="Trunk No" id="truck_no" class="form-control" name="truck_no" value="" >
					 	</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
					 	<label class="col-sm-5 control-label" for="form-field-1">
					 		Pallet No
					 	</label>
					 	<div class="col-sm-7">
					 		<input type="text" placeholder="Pallet No" id="pallet_no" class="form-control" name="pallet_no" value="">
					 	</div>
					</div>
				</div>
					<div class="col-sm-12">
					 	<div class="col-md-6" style="margin-bottom:25px;">	
							<table class="table table-bordered" width="100%">
								<tr>
									<th class="text-center" colspan="2">Already Set Container</th>
								</tr>
								<tr>
									<th class="text-center">Container No</th>
									<th class="text-center">Description</th>
									<th class="text-center">Action</th>
								</tr>
								<?php 
								$export_loading_array = array();
								$export_loading_array1 = array();
								$con = 1;
							 
								 foreach($loadingtrn_data as $row)
								{
									 
									 if(!in_array($row->con_entry,$export_loading_array))
									 { 
											if(!empty($row->export_packing_id))
											{
												$con += $row->con_entry;
								?>
									<tr>
										<td class="text-center"><?=$row->container_no?></td>
										<?php 
										
											}
									 array_push($export_loading_array,$row->con_entry);
									}
									?>
									<td class="text-center">
										<?php 
										 
									 	 if(empty($row->product_id))
										 {
											?>
											<?=$row->description_goods?>
										<?php 
										}
										else
										{
											?>
											Size : <?=$row->size_type_mm?> <br>
											Model Name : <?=!empty($packing_row->client_name)?$packing_row->client_name:$packing_row->model_name?> <br>
											Finish : <?=$row->size_type_mm?>  
											<?php
										}
										?>
									</td>
									<?php 
										 
									if(!in_array($row->con_entry,$export_loading_array1))
									 {
										 ?>
								 		<td class="text-center">
											<a class="tooltips btn btn-danger" data-title="Delete"  onclick="delete_product(<?=$row->export_invoice_id?>,'<?=$row->container_no?>')" href="javascript:;" ><i class="fa fa-trash"></i></a>
										</td>
									</tr>
							 	<?php
									 array_push($export_loading_array1,$row->con_entry);
									}	
								}
								?>
							</table>
						</div>
					<div class="col-md-12">					 
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th width="3%"> </th>
									<th width="30%" class="text-center">Description</th>
									<th width="7%" class="text-center">Design Name</th>
									<th width="7%" class="text-center">Finish Name</th>
									<th width="7%" class="text-center">Shade No</th>
									<th width="7%" class="text-center">Pallets</th>
									<th width="7%" class="text-center">Boxes</th>
									<th width="7%" class="text-center">SQM</th>
									<th width="7%" class="text-center">Quantity</th>
									<th width="7%" class="text-center">UNIT</th>
									<th width="7%" class="text-center">Net Weight</th>
									<th width="7%" class="text-center">Gross Weight</th>
									<th width="7%" class="text-center">Rate</th>
									<th width="7%" class="text-center">Amount</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							  
						 	 $no=0;
							for($i=0; $i<count($product_data);$i++)
							{
						 	 
							  foreach($product_data[$i]->packing  as $packing_row)
							  {
								  
								   $no_of_boxes = $packing_row->no_of_boxes - $packingtrnarray[$packing_row->export_packing_id]["no_of_boxes"];
									 
									  $no_of_pallet = $packing_row->no_of_pallet - $packingtrnarray[$packing_row->export_packing_id]["no_of_pallet"];
									 
									 $no_of_big_pallet = $packing_row->no_of_big_pallet - $packingtrnarray[$packing_row->export_packing_id]["no_of_big_pallet"];
									 
									 $no_of_small_pallet = $packing_row->no_of_small_pallet - $packingtrnarray[$packing_row->export_packing_id]["no_of_small_pallet"];
								   
								  if($no_of_boxes>0) 
								 {
									
									  
						 	?>
								<tr>
									 <td> 
										 <input type="checkbox" name="export_packing_id[]" id="export_packing_id<?=$no?>" value="<?=$packing_row->export_packing_id?>" class="form-control"  />
										 <input type="hidden" name="exportproduct_trn_id[]" id="exportproduct_trn_id<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->exportproduct_trn_id?>" class="form-control"  />
										 <input type="hidden" name="export_invoice_id[]" id="export_invoice_id<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->export_invoice_id?>" class="form-control"  />
										 
									</td>
											<?php 
											 if(empty($product_data[$i]->product_id))
											{
														$qty=0;
														$box=0;
														$sqm=0;
															if($packing_row->per == "SQM")
															{
														 		$qty = $packing_row->no_of_sqm;
														 		$sqm = $packing_row->no_of_sqm;
														 	}
															else if($packing_row->per == "BOX")
															{
													 			$qty = $packing_row->no_of_boxes;
													 			$box = $packing_row->no_of_boxes;
													 		}
															else if($packing_row->per == "SQF")
															{
													 			$qty = ($packing_row->no_of_boxes);
													 			$box = ($packing_row->no_of_boxes);
													 		}
															else if($packing_row->per == "PCS")
															{
													 			$qty = ($packing_row->no_of_boxes);
													 			$box = ($packing_row->no_of_boxes);
													 		}
											?>
									<td colspan="3">
										<?=$product_data[$i]->description_goods?>
									</td>
								 	 <td class="text-center">
										<input type="text" name="shadeno[]" id="shadeno<?=$packing_row->export_packing_id?>" value="" class="form-control"  /> 
									</td>
								 	<td class="text-center">
									-
									</td>
									<td class="text-center">
										 -
										
									 
									</td>
									<td class="text-center" id="sqm_html<?=$packing_row->export_packing_id?>">
										-
									</td>
									<td class="text-center">
									<?php
									if($box > 0)
									{
									?>
									<?=$box?>
										
									<?php
									}
									else
									{
									?>	
										<?=$sqm?>
									<?php
									}
									?>	
									</td>
									<td class="text-center">
										<?=$packing_row->per?>
									</td>
									 <input type="hidden" name="no_of_boxes[]" id="no_of_boxes<?=$packing_row->export_packing_id?>"   value="<?=$box?>" class="form-control" onkeypress="return isNumber(event)" /> 
									
										<input type="hidden" name="no_of_sqm[]" id="no_of_sqm<?=$packing_row->export_packing_id?>"   value="<?=$sqm?>" class="form-control" onkeypress="return isNumber(event)" />  
											<?php
											}
											else
											{
												?>
								  	<td>
										<?=$product_data[$i]->series_name.'<br>Size : '.$product_data[$i]->size_type_mm;?>
									</td>
								 	<td class="text-center">
										<?=!empty($packing_row->client_name)?$packing_row->client_name:$packing_row->model_name?>
									</td>
									<td class="text-center">
										<?=$packing_row->finish_name?>
									</td>
									<td class="text-center">
										<input type="text" name="shadeno[]" id="shadeno<?=$packing_row->export_packing_id?>" value="" class="form-control"  /> 
									</td>
								 	<td class="text-center">
									<?php
									if($no_of_pallet > 0)
									{
									?>
											<input type="text" name="no_of_pallet[]" id="no_of_pallet<?=$packing_row->export_packing_id?>" value="<?=$no_of_pallet?>" class="form-control" onkeyup="calc_from_popup(<?=$packing_row->export_packing_id?>);" onblur="calc_from_popup(<?=$packing_row->export_packing_id?>);" onkeypress="return isNumber(event)"  /> 
												 
									<?php
									}
									else if($no_of_big_pallet > 0 || $no_of_small_pallet > 0)
									{
									?>
										 <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet<?=$packing_row->export_packing_id?>" value="<?=$no_of_big_pallet?>" class="form-control" onkeyup="calc_from_popup(<?=$packing_row->export_packing_id?>);" onblur="calc_from_popup(<?=$packing_row->export_packing_id?>);" onkeypress="return isNumber(event)"  /> 
										 
										 <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet<?=$packing_row->export_packing_id?>" value="<?=$no_of_small_pallet?>" class="form-control" onkeyup="calc_from_popup(<?=$packing_row->export_packing_id?>);" onblur="calc_from_popup(<?=$packing_row->export_packing_id?>);" onkeypress="return isNumber(event)"  /> 
										  
									<?php
									}
									else 
									{
										echo "-";														
									}	
									 
									?>
									</td>
									<td class="text-center">
										 
										 <input type="text" name="no_of_boxes[]" id="no_of_boxes<?=$packing_row->export_packing_id?>" onkeyup="calc_from_popup(<?=$packing_row->export_packing_id?>);" onblur="calc_from_popup(<?=$packing_row->export_packing_id?>);"  value="<?=$no_of_boxes?>" class="form-control" onkeypress="return isNumber(event)" /> 
										 
									 
									</td>
									<td class="text-center" id="sqm_html<?=$packing_row->export_packing_id?>">
										<?=$packing_row->no_of_sqm; ?>
										
									</td>
									<td class="text-center" >
										-
										 
									</td>
									<td class="text-center" >
										-
									</td>	 
									<?php
											}
												?>
									
									
									<td class="text-center" id="packing_net_weight_html<?=$packing_row->export_packing_id?>">
										<?=$packing_row->packing_net_weight; ?>
										 
									</td>
									<td class="text-center" id="packing_gross_weight_html<?=$packing_row->export_packing_id?>">
										<?=$packing_row->packing_gross_weight; ?>
										
									</td>
									<td class="text-center">
										<?=$packing_row->product_rate; ?>
									</td>
									<td class="text-center" id="product_amt_html<?=$packing_row->export_packing_id?>">
										<?=$packing_row->product_amt; ?>
										 
									</td>
									
							 	</tr>
								 <input type="hidden" name="product_rate_per[]" id="product_rate_per<?=$packing_row->export_packing_id?>" value="<?=$packing_row->per?>" />
								 
								 <input type="hidden" name="product_id[]" id="product_id<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->product_id?>" />
								 <input type="hidden" name="product_amt[]" id="product_amt<?=$packing_row->export_packing_id?>" value="<?=$packing_row->product_amt?>" />
								 <input type="hidden" name="no_of_sqm[]" id="no_of_sqm<?=$packing_row->export_packing_id?>" value="<?=$packing_row->no_of_sqm?>" />
								 
								 <input type="hidden" name="packing_net_weight[]" id="packing_net_weight<?=$packing_row->export_packing_id?>" value="<?=$packing_row->packing_net_weight?>" />
								 
								  <input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight<?=$packing_row->export_packing_id?>" value="<?=$packing_row->packing_gross_weight?>" />
								  
								  
								  
								 <input type="hidden" name="pallet_status[]" id="pallet_status<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->pallet_status?>" />
						 
								<input type="hidden" name="sqm_per_box[]" id="sqm_per_box<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->sqm_per_box?>" />
							
								<input type="hidden" name="feet_per_box[]" id="feet_per_box<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->feet_per_box?>" />
								
								<input type="hidden" name="pcs_per_box[]" id="pcs_per_box<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->pcs_per_box?>" />
								
								<input type="hidden" name="weight_per_box[]" id="weight_per_box<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->weight_per_box?>" />
								
								<input type="hidden" name="pallet_weight[]" id="pallet_weight<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->pallet_weight?>" />
								<input type="hidden" name="big_pallet_weight[]" id="big_pallet_weight<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->big_pallet_weight?>" />
								<input type="hidden" name="small_pallet_weight[]" id="small_pallet_weight<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->small_pallet_weight?>" />
								
								<input type="hidden" name="total_pallet_weight[]" id="total_pallet_weight<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->total_pallet_weight?>" />
								
								<input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->boxes_per_pallet?>" />
						 
								<input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->box_per_big_pallet?>" />
						
								<input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->box_per_small_pallet?>" />
								
								<input type="hidden" name="product_rate[]" id="product_rate<?=$packing_row->export_packing_id?>" value="<?=$packing_row->product_rate?>" />
							
								<input type="hidden" name="buy_order_no[]" id="buy_order_no<?=$packing_row->export_packing_id?>" value="<?=$product_data[$i]->buy_order_no?>" />
						   
								<?php
									echo "<script>calc_from_popup(".$packing_row->export_packing_id.")</script>"; 
								 
								 $no++;
								  }
							  }
							  
							}
							?>
							 </tbody>
						</table>										
						 <input type="hidden" name="con" id="con" value="<?=$con?>"/>	 
				 
			 </div>  			
					
						 
					</div>  	
				
			 </div>  			
		 </div>
		 <div class="modal-footer">
			<button  type="button" id="button" class="btn btn-info" onclick="copy_containter(<?=$invoicedata->export_invoice_id?>)"> Set Container </button>
              <!--  <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>-->
            </div>
			 </form>
			 
    </div>
</div>
</div>
</div>

 <script>
 function delete_product(export_invoice_id,container_no)
{
	 
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/delete_container',
              data: {
                "export_invoice_id"		: export_invoice_id,
                "container_no"			: container_no 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ location.reload(); },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		} 
		});
}

$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
  function open_modal()
{ 

	$("#proformaproduct_modal").modal({
		backdrop: 'static',
		keyboard: false
	});
}

function copy_containter(export_invoice_id)
{
	
	if($("#export_loading_trn_id").val() == "")
	{
		toastr["error"]("Select Container");
		$("#export_loading_trn_id").focus()
		return false;
	}
	var export_packing_id 		= [];
	var exportproduct_trn_id 	= [];
	var product_id 				= [];
	var no_of_pallet 			= [];
	var no_of_big_pallet 		= [];
	var no_of_small_pallet 		= [];
	var no_of_boxes 			= [];
	var no_of_sqm 				= [];
	var product_amt 			= [];
	var packing_net_weight 		= [];
	var total_pallet_weight 	= [];
	var packing_gross_weight 	= [];
	var buy_order_no 			= [];
	var shadeno 				= [];
	 
	 $('input[name="export_packing_id[]"]').each(function() {
		 
        if ($(this).is(":checked")) {
			
             export_packing_id.push($(this).val());
		     exportproduct_trn_id.push($("#exportproduct_trn_id"+$(this).val()).val());
		     product_id.push($("#product_id"+$(this).val()).val());
		     no_of_pallet.push($("#no_of_pallet"+$(this).val()).val());
             no_of_big_pallet.push($("#no_of_big_pallet"+$(this).val()).val());
		     no_of_small_pallet.push($("#no_of_small_pallet"+$(this).val()).val());
             no_of_boxes.push($("#no_of_boxes"+$(this).val()).val());
             no_of_sqm.push($("#no_of_sqm"+$(this).val()).val());
             product_amt.push($("#product_amt"+$(this).val()).val());
             packing_net_weight.push($("#packing_net_weight"+$(this).val()).val());
             packing_gross_weight.push($("#packing_gross_weight"+$(this).val()).val());
             total_pallet_weight.push($("#total_pallet_weight"+$(this).val()).val());
             buy_order_no.push($("#buy_order_no"+$(this).val()).val());
             shadeno.push($("#shadeno"+$(this).val()).val());
			   
        }
    });
	
	 if($("#container_no").val() == "")
	 {
		 toastr["error"]("Container No Can't Blank.");
		 $("#container_no").focus();
		 return false;
	 }
	 else if(export_packing_id.length == 0)
	 {
		toastr["error"]("Please Select Product");
		  
		 return false; 
	 }
		block_page();
		
		$.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/copy_containter',
              data: {
                "container_no"			: $("#container_no").val(),
                "line_seal_no"			: $("#line_seal_no").val(),
                "self_seal_no"			: $("#self_seal_no").val(),
                "truck_no"				: $("#truck_no").val(),
                "pallet_no"				: $("#pallet_no").val(),
                "container_type"	 	: $('input[name="container_type"]:checked').val(),
                "export_packing_id"		: export_packing_id,
                "exportproduct_trn_id"	: exportproduct_trn_id,
                "export_loading_trn_id"	: $("#export_loading_trn_id").val(),
                "product_id"			: product_id,
                "no_of_pallet"			: no_of_pallet,
                "no_of_big_pallet"		: no_of_big_pallet,
                "no_of_small_pallet"	: no_of_small_pallet,
                "no_of_boxes"			: no_of_boxes,
                "no_of_sqm"				: no_of_sqm,
                "product_amt"			: product_amt,
                "packing_net_weight"	: packing_net_weight,
                "packing_gross_weight"	: packing_gross_weight,
                "total_pallet_weight"	: total_pallet_weight,
                "export_invoice_id"		: export_invoice_id,
                "buy_order_no"			: buy_order_no,
                "con"					: $("#con").val(),
                "shadeno"				: shadeno
              }, 
              cache: false, 
              success: function (data) { 
					location.reload();
              }
			});
	 
	 
}
 
</script>

<?php 
   
 if(count(array_filter($export_loading_array)) != intval($invoicedata->container_details))
 {
	 
	 echo "<script>open_modal();</script>";
 }
?>
<script>
closeNav();
$("#exportinvoice_packing_form").submit(function(event) {
	event.preventDefault();
	var inps = document.getElementsByName('exportproducttrn_id[]');
	
	var no=1;
	var container_detail = new Array();
	var seal_no 		 = new Array();
	var rfidseal_no 	 = new Array();
	
	for (var i = 0; i <inps.length; i++) 
	{
			var inp=inps[i];
			var inpschild = document.getElementsByName('container_detail'+inp.value+'[]');
				
			for (var j = 0; j <inpschild.length; j++)
			{
				if($("#container_detail"+inp.value+j).val() != undefined && $("#container_detail"+inp.value+j).attr('type') == "text")
				{
					console.log();
					if($("#container_detail"+inp.value+j).val()=="" && $("#container_detail"+inp.value+j).val()!= undefined)
					{
						$("#container_detail"+inp.value+j).focus();
						return false;
					}
				}
			}
		 
	}
	
 	 
	 var results = [];  
        for (var i = 0; i < container_detail.length - 1; i++) {  
            if (container_detail[i + 1] == container_detail[i]) {  
                results.push(container_detail[i]);  
            }  
        }  
		var results1 = [];  
        for (var i = 0; i < seal_no.length - 1; i++) {  
            if (seal_no[i + 1] == seal_no[i]) {  
                results1.push(seal_no[i]);  
            }  
        }  
		var results2 = [];  
        for (var i = 0; i < rfidseal_no.length - 1; i++) {  
            if (rfidseal_no[i + 1] == rfidseal_no[i]) {  
                results2.push(rfidseal_no[i]);  
            }  
        }  
	if(results.length > 0)
	{
		toastr["error"]("Duplicate Container Number");
		return false;	
	}
	if(results1.length > 0)
	{
		toastr["error"]("Duplicate Line Seal Number");
		return false;	
	}
	if(results2.length > 0)
	{
		toastr["error"]("Duplicate Self Seal Number");
		return false;	
	} 
 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'exportinvoicepacking/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Packing Detail Sucessfully Added.");
					setTimeout(function(){ window.location=root+'exportinvoicesample/index/'+<?=$invoicedata->export_invoice_id?> },1000);
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

function add_sample_product(exportproduct_trn_id,container,container_name)
{
	
	block_page()
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/add_sample',
              data: {
                "container" 	 : container, 
                "container_name" : container_name 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
					 $("#exportinvoicetrnid").val(exportproduct_trn_id);
					 $("#sample_mode").val('add');
					  $("#editresponsesamplecontainer").html(obj.str);
					 
					 $("#no_of_container_sample").val(no_of_container);
					 $("#Addsamplemodal").modal({
						 backdrop: 'static',
						 keyboard: false
					 });
					 $(".selectajax1").select2({
						width:'100%'
					 });
					 
					$(".tooltips").tooltip();
					unblock_page("","");
              }
			});
	 
}
function load_data_sample(val,no)
{
	 
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/getproduct_data',
              data: {
                "product_id": val
              }, 
              cache: false, 
              success: function (data) 
			  { 
					var obj = JSON.parse(data)
					 $("#product_size_id"+no).html(obj.str) 
					 
					 $("#design_id"+no).html(obj.str_design) 
					
              }
			});
}
function load_data_sample_packing(val,no)
{
	
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/getproduct_size_data',
              data: {
                "product_size_id": val
              }, 
              cache: false, 
              success: function (data) { 
					var obj = JSON.parse(data)
					$("#sqm_per_box"+no).val(obj.sqm_per_box);
					$("#weight_per_box"+no).val(obj.weight_per_box);
					$("#palletweight"+no).val(obj.pallet_weight);
					cal_sampledata(no,1)
              }
			});
	
}
function load_sample_finish(design_id,val)
{  
  	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoiceproduct/load_finish_data",
       data: 
	   {
			"id": design_id 
	   }, 
       success: function (response) {
			$("#finish_id"+val).html(response);
		 	unblock_page("",""); 
           }
       
  }); 
} 
function cal_sampledata(no,fromwhere)
{
	
	var boxes = $("#no_of_boxes"+no).val()
	 
	var appsqmperboxesval = $("#sqm_per_box"+no).val();
	var apwigtperbox = $("#weight_per_box"+no).val();
	var productrate = $("#productrate"+no).val();
	var sqmdataval = boxes * appsqmperboxesval;
	  
	var netweight = boxes * apwigtperbox;
	var grossweight = parseFloat(netweight);
	$("#sample_sqm"+no).val(sqmdataval.toFixed(2));
	$("#netweight"+no).val(netweight.toFixed(2));
	$("#grossweight"+no).val(grossweight.toFixed(2));
	var sqmdataval = boxes * appsqmperboxesval;
	var sampleproductamount = productrate * boxes;
	$("#sampleproductamount"+no).val(sampleproductamount.toFixed(2));
	 
}
function add_inner_sample_product(no,n,container_name)
{
	
	//block_page()
	var next_no = $("#inner_row_value"+no).val() + parseInt(1);
	 
	if($("#product_details"+$("#inner_row_value"+no).val()+n).val() === "")
	{
		toastr["error"]("Please Select Product");
		$("#product_details"+$("#inner_row_value"+no).val()+n).select2('open');
		return false;
	}
	if($("#no_of_boxes"+$("#inner_row_value"+no).val()+n).val() === "")
	{
		toastr["error"]("Enter Box");
		$("#no_of_boxes"+$("#inner_row_value"+no).val()+n).focus();
		return false;
	}
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/add_inner_sample',
              data: {
                "container_name"	: container_name,
                "no"	: next_no,
				"con"	: n
              }, 
              cache: false, 
              success: function (data) {
					 
					$(".row"+no).append(data);
					$(".select"+next_no+n).select2({
						width:'100%'
					});
					$(".selectajax"+next_no+n).select2({
						width:'100%'
					});
					
					$("#inner_row_value"+no).val(next_no)
					$(".tooltips").tooltip();
					unblock_page("","");
              }
			});
	 
}

function remove_inner_sample_product(no)
{
	$(".inner_row"+no).remove();
}
function deletesample_product(exportproduct_trn_id,container_name)
{
	Swal.fire({
		title: 'Are you sure?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
			 if (result.value) {
					block_page()
			$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/delete_sampleentry',
              data: {
                "exportproduct_trn_id"	: exportproduct_trn_id,
                "container_name"		: container_name 
              }, 
              cache: false, 
              success: function (data) { 
			  		unblock_page("","");
					location.reload();
			}
			});
			}	
		});
}
function editsample_product(exportproduct_trn_id,export_invoice_id,container_name)
{
	block_page()
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/edit_sampleentry',
              data: {
                "exportproduct_trn_id"	: exportproduct_trn_id,
                "export_invoice_id"		: export_invoice_id,
				"container_name" 		: container_name
              }, 
              cache: false, 
              success: function (data) { 
			  var obj = JSON.parse(data);
					 $("#Addsamplemodal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#exportinvoicetrnid").val(exportproduct_trn_id)
				 	$("#sample_submit_btn").val("Edit");
				  	$("#sample_mode").val('edit');
				   $("#editresponsesamplecontainer").html(obj.str);
				   $(".editselectajax1").select2({
						width:'100%'
					});
					  $(".selectajax1").select2({
						width:'100%'
					});
					//add_sample_product(exportproduct_trn_id,no_of_container,obj.container_name)
					unblock_page("","");
              }
			});
}

	

$("#sample_product_form").submit(function(event) {
	event.preventDefault();
	if(!$("#sample_product_form").valid())
	{
		return false;
	}
 
	if($("#product_details10").val() == "")
	{
		toastr["error"]("Please Add At list one Sample");
		return false;
	}
	
	 block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url: 	root+'exportinvoiceproduct/sampleentry',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sample Sucessfully Added.");
					setTimeout(function(){ window.location=root+'exportinvoicepacking/index/'+<?=$invoicedata->export_invoice_id?> },1000);
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

$(".select2").select2({
	 width:'element'
});  
 

function paste_data()
{
	var excel_data = $("#excel_data").val();
	var excel_spit = excel_data.split("\n");  
	var total_line = parseInt(excel_spit.length)-parseInt(1);
	  var value_array = [];
	  var name_array = [];
	  
	if(parseInt(total_line) == parseInt($("#no_of_container").val()))
	{
		for(var i=0;i<total_line;i++)
		{
			var custom1 =  excel_spit[i].replace(/\t/g, ' ');
			var spit_from_colom = custom1.split(" ");
			  value_array.push(spit_from_colom)
			 
		}
		
		var inps = document.getElementsByName('exportproducttrn_id[]');
		var no=0;
		
		for (var c = 0; c <inps.length; c++) 
		{
			var inp=inps[c];
		 	var inpschild = document.getElementsByName('container_detail'+inp.value+'[]');
			console.log(inpschild)
		 	for (var d = 0; d < inpschild.length; d++) 
			{
			 	if(value_array[no] != undefined && value_array[no].length == 3)
				{
				 	$("#container_detail"+inp.value+d).val(value_array[no][0])
				 	$("#container_detail"+inp.value+d).attr("readonly",true)
					$("#seal_no"+inp.value+d).val(value_array[no][1])
					$("#seal_no"+inp.value+d).attr("readonly",true)
					$("#rfidseal_no"+inp.value+d).val(value_array[no][2])
					$("#rfidseal_no"+inp.value+d).attr("readonly",true)
				  	no++;
				}
				else if(value_array[no] != undefined)
				{
					toastr["error"]("Wrong Data");
					return false;
				}
			 }
			
		}
		$("#myModal").modal("hide"); 
		$("#excel_data").val(""); 
		
	}
	else
	{
		toastr["error"]("Wrong Data");
	}
}
 
</script>

  