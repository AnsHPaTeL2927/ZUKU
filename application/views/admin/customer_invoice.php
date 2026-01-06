<?php 

if($mode=="Add")
{
	$invoice_no="";
	if($invoicetype->invoice_format==0)
	{
		$invoice_no = $invoicetype->invoice_series;
    }
	else if($invoicetype->invoice_format==1)
	{
		$invoice_no = $invoicetype->formate_value;
		$datevalue = explode(",",$invoicetype->with_date);
		if(in_array(3,$datevalue))
		{
			 $invoice_no .= date('Y');
		}
		if(in_array(2,$datevalue))
		{
			$invoice_no .= date('m');
		}
		if(in_array(1,$datevalue))
		{
			$invoice_no .= date('d');
		}
		$invoice_no =  $invoice_no.''.$invoicetype->invoice_series;						
	}
	else if($invoicetype->invoice_format==2)
	{
		$invoice_no .= $invoicetype->invoice_series;
		$datevalue = explode(",",$invoicetype->with_date);
		if(in_array(3,$datevalue))
		{
			$invoice_no .= date('Y');
		}
		if(in_array(2,$datevalue))
		{
			$invoice_no .= date('m');
		}
		
		if(in_array(1,$datevalue))
		{
			$invoice_no .= date('d');
		}															
		$invoice_no .= $invoicetype->formate_value;
	}
	
		$explode_array = explode(",",$invoicetype->with_date);
		
		$value=array();
				if(in_array(1,$explode_array))
				{
					array_push($value,date('d'));
				}
				if(in_array(2,$explode_array))
				{
					array_push($value,date('m'));
				}
				if(in_array(3,$explode_array))
				{
					array_push($value,date('Y'));
				}
				if(in_array(4,$explode_array))
				{
					$year = date('n') > 4 ? date('Y').'-'.(date('Y') + 1) : (date('Y') - 1).'-'.date('Y');
					array_push($value,$year);
				}
				
		$implode_array = implode($invoicetype->separate_by,$value);	 
				if($invoicetype->date_palce==1)
				{ 
					$invoice_no = $implode_array.$invoicetype->separate_by.$invoice_no;
				}
				else if($invoicetype->date_palce==2)
				{ 	
					$invoice_no = $invoice_no.$invoicetype->separate_by.$implode_array;
				}
	$export_date 				= date('d-m-Y',strtotime($invoicedata->current_invoice_date));
//	$export_date				= date('d-m-Y');
	$export_ref_date			= date('d-m-Y',strtotime($invoicedata->performa_date));
	$eta_date					= date('d-m-Y',strtotime($invoicedata->eta_date));
	
	$export_invoice_no 			= $invoicedata->export_invoice_no;
	$export_ref_no 				= $invoicedata->performa_invoice;
	$export 					=  strip_tags($invoicedata->exporter_detail);
	$buy_order_no 				= strip_tags($invoicedata->export_buy_order_no);
	$buyer_other_consign 		= strip_tags($invoicedata->buyer_other_consign);
	$exporter_email 			= $invoicedata->e_email;
	$exporter_mobile 			= $invoicedata->e_mobile;
 	$exporter_pan 				= $invoicedata->exporter_pan;
	$exporter_iec 				= $invoicedata->exporter_iec;
	$consign_address 			= $invoicedata->c_companyname."&#13;&#10;".strip_tags($invoicedata->c_address)."&#13;&#10;".$invoicedata->c_city."&#13;&#10;".$invoicedata->country_name; 
	$pre_carriage_by			= $invoicedata->pre_carriage_by;
	$place_of_receipt			= $invoicedata->place_of_receipt;
	$country_origin_goods 		= $invoicedata->country_origin_goods;
	$country_final_destination 	= $invoicedata->country_final_destination;
	$bank_detail 				= strip_tags($invoicedata->bank_detail);
	$flight_name_no				= $invoicedata->flight_name_no;				 
    $export_port_loading 		= $invoicedata->port_of_loading;          
	$port_of_discharge 			= $invoicedata->port_of_discharge;
	$final_destination 			= $invoicedata->final_destination;
	$export_payment_terms 		= strip_tags($invoicedata->payment_terms);
	$export_terms_of_delivery 	= $invoicedata->terms_of_delivery;
	$consiger_id 				= $invoicedata->consiger_id;
	$checked					= 'checked';
	$invoice_currency_id 		= $invoicedata->invoice_currency_id;
	$container_size 			= $invoicedata->container_size;
	$terms_id 					= $invoicedata->terms_id;
	$container_twenty 			= $invoicedata->container_twenty;
	$container_forty 			= $invoicedata->container_forty;
	if($mutiple_status == 1)
	{
		$export_invoice_id    = $invoicedata->export_invoice_id;
		$certification_charge = $invoicedata->certification_charge;
		$insurance_charge 	  = $invoicedata->insurance_charge;
		$seafright_charge 	  = $invoicedata->seafright_charge;
		$discount 	  		  = $invoicedata->discount;
		$grand_total 	  	  = $invoicedata->grand_total;
		$no_of_container	  = $invoicedata->container_details;
		
	}
	else
	{
		$export_invoice_id 		= $export_invoice_id;
	 	$container_twenty 		= $invoicedata->container_twenty;
		$container_forty 		= $invoicedata->container_forty;
		$certification_charge	= 0;
		$insurance_charge		= 0;
		$seafright_charge		= 0;
		$discount				= 0;
		$grand_total		 	= 0;
		$no_of_container 	    = $invoicedata->no_of_container;
		$export_invoice_no	    = $invoicedata->export_invoice_no;
		$export_ref_no 			= $invoicedata->export_ref_no;
		$export_date 			= date('d-m-Y',strtotime($invoicedata->current_invoice_date));
		$export_ref_date 			= date('d-m-Y',strtotime($invoicedata->performa_date));
	}
	
	$s_bill_no 	= $invoicedata->Shipping_Bill_no;
	$s_date 	= ($invoicedata->Shipping_date != "" && $invoicedata->Shipping_date != "1970-01-01" && $invoicedata->Shipping_date != "0000-00-00")?date("d.m.Y",strtotime($invoicedata->Shipping_date)):"";
	$bl_no	 	= '';
 	$bl_date 	= '';
	
 }
else 
{
	$export_ref_date	 		=  $invoicedata->export_date;
	$invoice_no					= $invoicedata->customer_invoice_no;
	$export_date  				= date('d-m-Y',strtotime($invoicedata->invoice_date));
	$eta_date  				= date('d-m-Y',strtotime($invoicedata->eta_date));
	 
	$export_invoice_no 			= $invoicedata->customer_invoice_no;
	$export_ref_no 				= $invoicedata->export_ref_no;
	$export						= strip_tags($invoicedata->exporter_detail);
	$buy_order_no 				= strip_tags($invoicedata->customer_buy_order_no);
	$buyer_other_consign 		= strip_tags($invoicedata->buyer_other_consign);
	$exporter_email 			= $invoicedata->e_email;
	$exporter_mobile 			= $invoicedata->e_mobile;
	$exporter_gstin 			= $invoicedata->e_gstin;
	$exporter_pan 				= $invoicedata->exporter_pan;
	$exporter_iec 				= $invoicedata->exporter_iec;
	$consiger_id 				= $invoicedata->consiger_id;
	$consign_address 			= strip_tags($invoicedata->consign_address);
	$pre_carriage_by			= $invoicedata->pre_carriage_by;
	$place_of_receipt			= $invoicedata->place_of_receipt;
	$country_origin_goods 		= $invoicedata->country_origin_goods;
	$country_final_destination 	= $invoicedata->country_final_destination;
	$bank_detail				= strip_tags($invoicedata->bank_detail);
	$flight_name_no				= $invoicedata->flight_name_no;
	$export_port_loading  		= $invoicedata->port_of_loading;
	$port_of_discharge			= $invoicedata->port_of_discharge;
	$final_destination			= $invoicedata->final_destination;
	$export_payment_terms 		= strip_tags($invoicedata->payment_terms);
	$no_of_container			= $invoicedata->container_details;;
	$export_terms_of_delivery 	= $invoicedata->terms_of_delivery;
 	$checked					= ($invoicedata->igst_status==1)?'checked':'';
	$checked1					= ($invoicedata->igst_status==2)?'checked':'';
	$invoice_currency_id 		= $invoicedata->invoice_currency_id;
	$container_size 			= $invoicedata->container_size;
	$terms_id 					= $invoicedata->terms_id;
	$export_invoice_id 	 		= $invoicedata->export_invoice_id;
	$certification_charge 		= $invoicedata->certification_charge;
	$insurance_charge 	  		= $invoicedata->insurance_charge;
	$seafright_charge 	  		= $invoicedata->seafright_charge;
	$discount 	  		  		= $invoicedata->discount;
	$grand_total 	  	  		= $invoicedata->grand_total;
	$mutiple_status 	  		= $invoicedata->mutiple_status;
	$container_twenty 			= $invoicedata->container_twenty;
	$container_forty 			= $invoicedata->container_forty;
	$s_bill_no 					= $invoicedata->s_bill_no;
	$bl_no	 					= $invoicedata->bl_no;
	$s_date 					= ($invoicedata->s_date != "" && $invoicedata->s_date != "1970-01-01" && $invoicedata->s_date != "0000-00-00")?date("d.m.Y",strtotime($invoicedata->s_date)):"";
	$bl_date 					= ($invoicedata->bl_date != "" && $invoicedata->bl_date != "1970-01-01" && $invoicedata->bl_date != "0000-00-00")?date("d.m.Y",strtotime($invoicedata->bl_date)):"";
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
									<h3>Customer Invoice</h3>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> Customer Invoice	
								</div>
                              	<div class="form-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="invoice_form" id="invoice_form">
									 	<div class="panel-body">
								    
								 	<div class="" style="padding:10px;" >
									
										<table cellspacing="0" cellpadding="0"    width="100%">
											<tr>
												<td style="padding:0px;" width="2%"></td>
												<td style="padding:0px;" width="6%"></td>
												<td style="padding:0px;" width="2%"></td>
												<td style="padding:0px;" width="10%"></td>
												<td style="padding:0px;" width="7%"></td>
												<td style="padding:0px;" width="10%"></td>
												<td style="padding:0px;" width="13%"></td>
												<td style="padding:0px;" width="12%"></td>
												<td style="padding:0px;" width="3%"></td>
												<td style="padding:0px;" width="11%"></td>
												<td style="padding:0px;" width="9%"></td>
												<td style="padding:0px;" width="15%"></td>
											</tr>
										 	<tr>
												<td rowspan="4">
													<span>E</span><br>	
													<span>X</span><br>		
													<span>P</span><br>	
													<span>O</span><br>		
													<span>R</span><br>		
													<span>T</span><br>		
													<span>E</span><br>	
													<span>R</span>
												</td>
												<td colspan="6" rowspan="2" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
													 <textarea type="text" name="exporter_detail" rows="6" class="form-control" id="exporter_detail" readonly="readonly"><?=$export?></textarea>
												</td>
												<td>Invoice No</td>
												<td colspan="2" style="font-weight:bold">
													<input type="text" placeholder="Export Ref. No" id="customer_invoice_no" style="font-weight:bold;" class="form-control" name="customer_invoice_no" value="<?=$export_invoice_no?>"/> 
												</td>
												<td>DATE</td>
												<td style="font-weight:bold">
													<input type="text" placeholder="Date" id="invoice_date" required="" style="font-weight:bold;" class="form-control" name="invoice_date" value="<?=$export_date?>" title="Enter Invoice Date" /> 
												</td>
											</tr>
											<tr>
												<td>Export Ref. No</td>
												<td colspan="2" >
												 
														<input type="text" placeholder="Export Ref. No" id="export_ref_no" style="font-weight:bold;" class="form-control" name="export_ref_no" 
														value="<?=$export_ref_no?>"/> 
											 	</td>
												<td>DATE</td>
												<td style="font-weight:bold"> 
													<input type="text" placeholder="Date" id="date" required="" style="font-weight:bold;" class="form-control" name="date" value="<?=$export_ref_date?>"  >
												</td>
											</tr>
										 	<tr>
												<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">S/BILL NO</td>
												<td>:</td>
												<td colspan="2" style="font-weight:bold"> 
													<input type="text" placeholder="S/BILL NO" style="font-weight:bold;" id="s_bill_no"   class="form-control" name="s_bill_no" value="<?=$s_bill_no?>" >
												</td>
												<td>Date</td>
												<td style="font-weight:bold" >
													<input type="text" placeholder="Date" id="s_date" style="font-weight:bold;"  class="form-control defualt-date-picker" name="s_date" value="<?=$s_date?>" title="Enter Date" autocomplete="off">
												</td>
												<td rowspan="2">Buyer Order No &amp; Date</td>
												<td rowspan="2" colspan="2">
														<textarea style="height: 50px;" placeholder="Customer Buyer Order No &amp; Date" id="customer_buy_order_no"  class="form-control" name="customer_buy_order_no"><?=$buy_order_no?></textarea>
													</td>
												
												<td rowspan="2">ETA Date</td>
												<td rowspan="2" >
														<input type="text" placeholder="Date" id="eta_date" required="" style="font-weight:bold;" class="form-control defualt-date-picker" name="eta_date" value="<?=$eta_date?>" title="Enter ETA Date" /> 
													</td>
											</tr>
											<tr>
												
												<td>B/L NO</td>
												<td>:</td>
												<td  style="font-weight:bold" colspan="2">
													<input type="text" placeholder="B/L NO" style="font-weight:bold;" id="bl_no"  class="form-control" name="bl_no" value="<?=$bl_no?>"title="Enter B/L NO" >
												</td>
												<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; "> B/L Date</td>
												 
												<td  style="font-weight:bold"> 
														<input type="text" placeholder=" B/L Date" style="font-weight:bold;" id="bl_date"  class="form-control defualt-date-picker" name="bl_date" value="<?=$bl_date?>" title="Enter bl_date" autocomplete="off"/> 
														
														<input type="hidden"   id="exporter_gstin"  name="exporter_gstin" value="<?=$exporter_gstin?>"  /> 
														<input type="hidden"   id="exporter_iec"  name="exporter_iec" value="<?=$exporter_iec?>"  /> 
														<input type="hidden"   id="exporter_email"  name="exporter_email" value="<?=$exporter_email?>"  /> 
														<input type="hidden"   id="exporter_mobile"  name="exporter_mobile" value="<?=$exporter_mobile?>"  /> 
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
												 <td colspan="3" id="con_id_select">
													 <select class="" name="consiger_id" id="consiger_id" required onchange="load_consigner(this.value)" title="Select Consigner">
														<option value="">Please Select Consigner</option>
														<?php 
														for($i=0; $i<count($consign_detail);$i++)
														{
															$selected='';
															if($consiger_id==$consign_detail[$i]->id)
															{
																$selected = 'selected="selected"';
															}
														?>
															<option <?=$selected?> value="<?=$consign_detail[$i]->id?>"><?=$consign_detail[$i]->c_companyname?></option>
														<?php
														}
														?>
													</select>
														 
																</td>
												 <td>
													Currency : 
												 </td>
												 <td colspan="4">
													<select class="select2" name="invoice_currency_id" id="invoice_currency_id" required title="Select Currency">
												<option value="">Select Currency</option>	
													<?php
													for($currency=0;$currency<count($currencydata);$currency++)
													{
														$select = '';
														if($currencydata[$currency]->currency_id==$invoice_currency_id)
														{
															$select = 'selected="selected"'; 
														}
														else if($currencydata[$currency]->currency_status == 1)
														{
															$select = 'selected="selected"'; 
														}
													?>
												<option <?=$select?> value="<?=$currencydata[$currency]->currency_id?>"><?=$currencydata[$currency]->currency_name?></option>	
													<?php
													}
													?>
											</select>
												 </td>
											</tr>
											<tr>
												<td colspan="6">
														<textarea class="form-control" rows="4" name="consign_address" id="consign_address"  required title="Enter Consign Detail" placeholder="Consign Detail"><?=$consign_address?></textarea>
												</td>
												<td >Buyer If Other Then Consignee [Notify]</td>
												<td colspan="4">
													<textarea class="form-control" rows="4"  name="buyer_other_consign" id="buyer_other_consign"><?=$buyer_other_consign?></textarea>
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
													<input type="text" placeholder="Pre Carriage By" style="font-weight:bold;" id="pre_carriage_by"   class="form-control" name="pre_carriage_by" value="<?=$pre_carriage_by?>" >
												</td>
												<td colspan="3" style="font-weight:bold">
													<input type="text" placeholder="Place of Receipt" style="font-weight:bold;" id="place_of_receipt" class="form-control" name="place_of_receipt" value="<?=$place_of_receipt?>" >
												</td>
												<td colspan="2" style="font-weight:bold">
													<input type="text" placeholder="Country of Origin Of Goods" style="font-weight:bold;" id="country_origin_goods" required="" class="form-control" name="country_origin_goods" value="<?=$country_origin_goods?>" >
												</td>
												<td colspan="3" style="font-weight:bold">
														<input type="text" placeholder="Country of Final Destination" style="font-weight:bold;width:90%;float: left;" id="country_final_destination" required="" class="form-control" name="country_final_destination" value="<?=$country_final_destination?>" title="Enter Country of Final Destination"  >
														<div id="customer_rules" style="display:none"><i class="fa fa-question-circle" id="popoverData" style="padding: 5px;" data-content="" rel="popover" data-placement="top"   data-trigger="hover"></i></div>
												</td>
											</tr>
											<tr>
												<td colspan="4">Vessel / Flight Name & No </td>
												<td colspan="3">Port Of Loading	 </td>
												<td colspan="2" rowspan="4">Bank Details  </td>
												<td colspan="3" rowspan="4">
													<textarea class="form-control" name="bank_detail" id="bank_detail"><?=$bank_detail?></textarea>
												</td>
											  </tr>
											<tr>
												<td colspan="4" style="font-weight:bold">
													<input type="text" placeholder="Vessel / Flight Name & No " style="font-weight:bold;" id="flight_name_no"  class="form-control" name="flight_name_no" value="<?=$flight_name_no?>" >
												</td>
												<td colspan="3" style="font-weight:bold">
														<input type="text" placeholder="Port Of Loading	" style="font-weight:bold;" id="port_of_loading"  class="form-control" name="port_of_loading" value="<?=$export_port_loading?>" >
												</td>
											</tr> 
											<tr>
												<td colspan="4">Port Of Discharge</td>
												<td colspan="3">Final Destination </td>
												 
											  </tr>
											<tr>
												<td colspan="4" style="font-weight:bold;text-align:center">
														<input type="text" placeholder="Port Of Discharge" style="font-weight:bold;" id="port_of_discharge" required="" class="form-control" name="port_of_discharge" value="<?=$port_of_discharge?>" title="Enter Port Of Discharge">
												</td>
												<td colspan="3" style="font-weight:bold">
													<input type="text" placeholder="Final Destination" style="font-weight:bold;" id="final_destination" required="" class="form-control" name="final_destination" value="<?=$final_destination?>" title="Enter Final Destination">
												</td>
												</tr>
											<tr>
															<td colspan="3">20 FT FCL</td>
															<td colspan="2">40 FT FCL</td>
															<td colspan="2">Nature Of Contract</td>
															<td rowspan="2">Payment Terms</td>
															<td colspan="4" rowspan="2">
																<textarea class="form-control" rows="2" name="payment_terms" id="payment_terms" style="font-weight:bold;height:auto;"  ><?=$export_payment_terms?></textarea>
															</td>
													</tr>
											<tr>
													<td colspan="3"> 
										<input type="text"  id="container_twenty"  name="container_twenty"  class="form-control"  value="<?=$container_twenty?>"  onkeyup="cal_total()" onblur="cal_total()" readonly>
										
									</td>				
								 	
									<td colspan="2">
										<input type="text"  id="container_forty" name="container_forty"  class="form-control"  value="<?=$container_forty?>" onkeyup="cal_total()" onblur="cal_total()" readonly>
										<input type="hidden"  id="container_details"   name="container_details"  class="form-control"  value="<?=$no_of_container?>"  >
									</td>
													<td>
													<select name="terms_id" id="terms_id" class="form-control">
														<?php 
														foreach($termsdata as $terms)
														{
															$sel ='';
															if($terms->terms_id == $terms_id)
															{
																$sel = 'selected="selected"';
															}
															echo "<option ".$sel." value='".$terms->terms_id."'>".$terms->terms_name."</option>";
														} ?>
													</select>
												</td>
												<td>	
														<input type="text" placeholder="Terms of Delivery " style="font-weight:bold;" id="terms_of_delivery"  class="form-control" name="terms_of_delivery" value="<?=$export_terms_of_delivery?>" >
													</td>
												</tr>
												<tr>
													<td colspan="5">
														 
													</td>
													<td colspan="7"> 
											<button type="submit" name="submit" class="btn btn-success">
												NEXT
											</button>
											
											<a href="<?=base_url().'customer_listing'?>" class="btn btn-danger">
												Cancel
											</a>
													</td>
												</tr>
				 
								</table>
								 	</div>
								
									
							 </div>
							 
							 
							 <input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>			
							 <input type="hidden" name="export_invoice_id" id="export_invoice_id" value="<?=$export_invoice_id?>"/>			
							 <input type="hidden" name="no_of_export" id="no_of_export" value="<?=$invoicedata->no_of_export?>"/>			
							<input type="hidden" name="certification_charge" id="certification_charge" value="<?=$certification_charge?>"/>			
							 <input type="hidden" name="insurance_charge" id="insurance_charge" value="<?=$insurance_charge?>"/>			
							 <input type="hidden" name="seafright_charge" id="seafright_charge" value="<?=$seafright_charge?>"/>			
							 <input type="hidden" name="seafright_action" id="seafright_action" value="<?=$invoicedata->seafright_action?>"/>			
							 		
							 <input type="hidden" name="calculation_operator" id="calculation_operator" value="<?=$invoicedata->calculation_operator?>"/>	
							 
							 <input type="hidden" name="bank_charge" id="bank_charge" value="<?=$invoicedata->bank_charge?>"/>	
							 <input type="hidden" name="courier_charge" id="courier_charge" value="<?=$invoicedata->courier_charge?>"/>	
							 
							 <input type="hidden" name="extra_calc_name" id="extra_calc_name" value="<?=$invoicedata->extra_calc_name?>"/>			
							 <input type="hidden" name="extra_calc_amt" id="extra_calc_amt" value="<?=$invoicedata->extra_calc_amt?>"/>			
							 <input type="hidden" name="extra_calc_opt" id="extra_calc_opt" value="<?=$invoicedata->extra_calc_opt?>"/>			
							 <input type="hidden" name="discount" id="discount" value="<?=$discount?>"/>			
							 
							 <input type="hidden" name="grand_total" id="grand_total" value="<?=$grand_total?>"/>			
							 <input type="hidden" name="mutiple_status" id="mutiple_status" value="<?=$mutiple_status?>"/>			
							 <input type="hidden" name="customer_invoice_id" id="customer_invoice_id" value="<?=$invoicedata->customer_invoice_id?>"/>			
							 			
								</form>
					    
								</div>
						 
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
<?php 
$this->view('lib/footer');
if($mode=="Edit")
{
	echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>";
}
$this->view('lib/addcountry');
?>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Consigner</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="consigner_form" id="consigner_form">
				<div class="modal-body">
			<div class="row">
					<div class="col-md-6">
						<div class="field-group">
							<input type="text" placeholder="Customer Name" id="cust_name" required class="form-control" name="cust_name" title="Enter Customer Name">
						</div>   
					</div>
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Company Name" id="c_companyname"   class="form-control" name="c_companyname"  title="Enter Company Name">
						</div>                
				    </div>                
					<div class="col-md-6">					
						<div class="field-group">
							<textarea placeholder="Address" id="c_address"    class="form-control" name="c_address" title="Enter Address"></textarea>
						</div>                
				    </div>
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Postcode/Zipcode" id="c_postcode"  class="form-control" name="c_postcode" title="Enter Postcode/Zipcode">
						</div>                
				    </div> 		
									
				    <div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="City" id="c_city"    class="form-control" name="c_city" title="Enter City">
						</div>                
				    </div>   
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="State" id="c_state"  class="form-control" name="c_state" title="Enter State">
						</div>                
				    </div>  
					<div class="col-md-12"></div>	
					<div class="col-md-6">					
						<div class="field-group">
							<select class="" name="country_id" id="country_id"   title="Select Country" onchange="add_country_modal(this.value)">
								<option value="">Select Country</option>	
								<option value="0">Add New Country</option>	
									<?php
									for($c=0;$c<count($countrydata);$c++)
									{
										$select = '';
										if($countrydata[$c]->id==@$fdv->country_id)
										{
											$select = 'selected="selected"'; 
										}
									?>
									<option <?=$select?> value="<?=$countrydata[$c]->id?>"><?=$countrydata[$c]->c_name?></option>	
									<?php
									}
									?>
							</select>
							<button type="button" class="btn btn-primary tooltips" data-title="Add Country" data-toggle="modal" data-target="#countryadd" data-keyboard="false" data-backdrop="static">+</button>
							<label id="country_id-error" class="error" for="country_id"></label>
						</div>                
				    </div> 
					<div class="col-md-6">					
						<div class="field-group">
						<select class="select2" name="currency_id" id="currency_id" required title="Select Currency">
							<option value="">Select Currency</option>	
								<?php
								for($currency=0;$currency<count($currencydata);$currency++)
								{
									$select = '';
							
									if($currencydata[$currency]->currency_id==@$fdv->currency_id)
									{
										$select = 'selected="selected"'; 
									}
									else if($currencydata[$currency]->currency_status == 1)
									{
										$select = 'selected="selected"'; 
									}
								?>
									<option <?=$select?> value="<?=$currencydata[$currency]->currency_id?>"><?=$currencydata[$currency]->currency_name?></option>	
								<?php
								}
								?>
						</select>
						 						 
						</div>                
				    </div> 
					<div class="col-md-12"></div>
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Company Regestration Details"   id="c_registration_detail" class="form-control" name="c_registration_detail" title="Enter Company Registration">
						</div>                
				    </div>   
					
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Contact No"  id="c_contact" class="form-control" name="c_contact" required />
						</div>                
				    </div>   
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Email Address"  id="c_email_address" class="form-control" name="c_email_address" />
						</div>                
				    </div> 
						 
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Port Of Discharge"   id="custport_of_discharge" class="form-control" name="custport_of_discharge" title="Enter Post Of Discharge">
						</div>                
				    </div>   
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Web Address"  id="c_web_address" class="form-control" name="c_web_address" >
						</div>                
				    </div> 
				</div>
				 </div>
				<div class="modal-footer">
					<button name="Submit" type="submit" class="btn btn-info"> Save <img src="<?=base_url()?>adminast/assets/images/loader.gif" style="display:none;width:14px;" class="loader" /></button>   
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
        </div>
    </div>
</div>


<script>
$( function() {
    $( "#accordion" ).accordion({
		active: 0,
		collapsible: true,
		heightStyle: "content"
	});
  } );


   
$(".select2").select2({
	width:'100%'
});
$("#consiger_id").select2({
	 width: '265px',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_new_consigner()'>Add New Consignee</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 
});
$("#country_id").select2({
	width:'85%',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_country_modal(0)'>Add New Country</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 	
});
function add_country_modal(val)
{
	if(val==0)
	{
		$("#countryadd").modal('show');
	}
	
}
function add_new_consigner()
{
	$(".modal").css('z-index','10000');
	 $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
    $("#myModal").css('z-index','1050');            
}
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
  $('.timepicker').datetimepicker({
      format: 'HH:ii P',
	  autoclose: false,
      showMeridian: true,
      startView: 1,
      maxView: 1,
	  sideBySide: true,
		 
    });
	 
$('.datetimepicker-hours thead').attr('style', 'display:none;');
$('.datetimepicker-hours table').attr('style', 'width:100%');
$('.datetimepicker-minutes thead').attr('style', 'display:none;');
$('.datetimepicker-minutes table').attr('style', 'width:100%');
 
$(document).ready(function() {
	
	$("#invoice_form").validate({
		rules: {
			exchangerate: {
				required: true
			} 
		},
		messages: {
			exchangerate: {
				required: "Enter Exchange Rate"
			} 
		}
	});
		$("#consigner_form").validate({
		rules: {
			c_email_address: {
				 email:true
			},
			c_contact:{
				required:true 
			}
		},
		messages: {
			c_email_address: {
				 email:"Email Id Not Vaild" 
			},
			c_contact:{
				required:"Enter Contact No" 
			} 
		}
	});
	$("#country_add").validate({
		rules: {
			country_name: {
				required: true
			}
		},
		messages: {
			country_name: {
				required: "Enter Country Name"
			}
		}
	});

 });

$("#invoice_form").submit(function(event) {
	event.preventDefault();
	if(!$("#invoice_form").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'create_customer_invoice/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
				   $("#invoice_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'cutomerinvoiceproduct/index/'+obj.invoiceid; },1500);
					}
				else if(obj.res==3)
			   {
				   $("#invoice_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'cutomerinvoiceproduct/index/'+obj.invoiceid; },1500);
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

function  load_consigner(cidval){
	 
			 
			block_page();
        $("#consign_list").empty();
		$('#buyer_other_consign').text('');
        $('#country_final_destination').val('');
		$('#port_of_discharge').val('');
        $('#final_destination').val('');
        $.ajax({
          type :'POST',
          url  :root+'invoice/selectcompnay',
          data :{
            'e_id' : cidval,
            'type' : 'consigner'
          },
          success : function(msg){
            
			var obj=JSON.parse(msg);
            var data = obj.data1  
            var cdata = obj.data2  
            var cname= data['c_companyname'];
            var c_name= data['c_name'];
            var c_address = data['address'];
			var c_city = data['c_city'];
            var c_country = data['country_name'];
            var port_of_discharge = data['port_of_discharge'];
            var c_registration_detail = data['c_registration_detail'];
            var result = ""+cname+"\n"+c_address+"\n"+c_city+"\n"+c_country+"\n"+c_registration_detail;
            var cname = cdata['consiger_name'];
            var i,content,j;
            $('#consign_address').val(result);
            //$('#buyer_other_consign').val();
			if(data.company_rules!='')
			{
				$('#customer_rules').show();
				$('#popoverData').popover();
				$('#customer_rules i').attr("data-content",data.company_rules);
				
			}
            $('#country_final_destination').val(c_country);
            $('#port_of_discharge').val(port_of_discharge);
            $('#final_destination').val(port_of_discharge);
            $("#consign_list").empty();
            $('#consigne_name').val(c_name);
            $('#invoice_currency_id').select2("val",data['currency_id']);
            
             for (i=0;i<cdata.length;i++) {
               
                    content = "<div class='btn btn-default' onclick='selectotherconsigner("+cdata[i][1]+")' id="+cdata[i][1]+">"+cdata[i][0]+"</div>&nbsp;&nbsp;";
                    //$("#consign_list").append(content);
				}
			  unblock_page('','');
          }
        })

      
	   

}
function selectotherconsigner(id)
{
	 
      $.ajax({
      type :'POST',
      url  :root+'invoice/selectcompnay',
      data :{
        'e_id' : id,
        'type' : 'consignerid'
      },
      success : function(msg1){
         var obj1=JSON.parse(msg1);
		 var result = ""+obj1['address']+"\n"+obj1['c_city']+"\n"+obj1['state'];
		 
        $('#buyer_other_consign').text(result);
        $('#country_final_destination').val(obj1['country_name']);
        $('#port_of_discharge').val(obj1['port_name']);
        $('#final_destination').val(obj1['port_name']);
 
         }
      })
 
}
	$("#consigner_form").submit(function(event) {
		event.preventDefault();
		if(!$("#consigner_form").valid())
		{
			return false;
		}
		 
		block_page();
		var postData= new FormData(this);
		postData.append("mode","1");
		postData.append("c_name",$("#cust_name").val());
		$.ajax({
				type: "post",
				url: 	root+'customer_detail/manage',
				data: postData,
				processData: false,
				contentType: false,
				cache: false,
				success: function(responseData) {
				   console.log(responseData);
					var obj= JSON.parse(responseData);
					$(".loader").hide();
					if(obj.res==1)
				   {
					   $("#consigner_form").trigger('reset');
						$('#myModal').modal("hide")
						unblock_page("success","Sucessfully Inserted.");
						$("#consiger_id").append("<option value='"+obj.id+"' selected>"+obj.cname+" - "+obj.c_companyname+"</option>");
							$("#consiger_id").val(obj.id);
							$("#consiger_id").trigger("change")
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

  $("#country_add").submit(function(event) {
	event.preventDefault();
	if(!$("#country_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","1");
 
	$.ajax({
            type: "post",
            url: 	root+'Country_detail/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
				   $("#consigner_form").trigger('reset');
				    $('#countryadd').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#country_id").append("<option value='"+obj.id+"' selected>"+obj.cname+"</option>");
					$("#country_id").val(obj.id);
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
 
 