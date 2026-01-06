<?php 
$this->view('lib/header'); 
if($mode=="Add")
{
	$invoice_no="";
	 
	$invoice_series = str_pad($invoicetype->invoice_series,strlen($invoicetype->invoice_series), '0', STR_PAD_LEFT);
	if($invoicetype->invoice_format==0)
	{
		$invoice_no = $invoice_series;
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
		$invoice_no =  $invoice_no.''.$invoice_series;						
	}
	else if($invoicetype->invoice_format==2)
	{
		$invoice_no .= $invoice_series;
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
	$Today_Date					= date('d-m-Y');
	$performa_date 				= !empty($invoicedata)?date('d-m-Y',strtotime($invoicedata->performa_date)):date('d-m-Y');
	$eta_date 				= !empty($invoicedata)?date('d-m-Y',strtotime($invoicedata->eta_date)):date('d-m-Y');
	
	$export 					=  !empty($invoicedata)?strip_tags($invoicedata->exporter_detail):$exporter_detail->s_name."&#13;&#10;".strip_tags($exporter_detail->s_address)."&#13;&#10;";
	$buy_order_no 				= strip_tags($invoicedata->buy_order_no);
	$buyer_other_consign 		= strip_tags($invoicedata->consign_detail);
	$containee_other_famigation = strip_tags($invoicedata->consign_detail);
	$exporter_email 			= explode(",",$exporter_detail->s_email);
	$exporter_mobile 			= explode(",",$exporter_detail->s_mobile);
	$exporteremail 				= !empty($invoicedata)?$invoicedata->e_email:$exporter_detail->s_email;
	$exportermobile 	 		= !empty($invoicedata)?$invoicedata->e_mobile:$exporter_detail->s_mobile;
	$exporter_gstin 			= $exporter_detail->s_gst;
	$exporter_pan 				= $exporter_detail->s_pan;
	$exporter_iec 				= $exporter_detail->s_iec;
	$consign_address 			= 'TO THE ORDER';
	//$consign_address 			= strip_tags($invoicedata->consign_detail);
	$consignee_for_famigation  	= 'TO THE ORDER';
	$pre_carriage_by			= $exporter_detail->pre_carriage_by;
	$place_of_receipt			= $exporter_detail->receipt_by_precarrier;
	$country_origin_goods 		= !empty($invoicedata)?$invoicedata->country_origin_goods:"INDIA";
	$country_final_destination 	= $invoicedata->country_final_destination;
	$bank_detail 				=  !empty($invoicedata)?strip_tags('BANK NAME : '.$invoicedata->bank_name.'&#013;'.$invoicedata->bank_address.'&#013; ACCOUNT NO :'.$invoicedata->account_no.'&#013; ACCOUNT NAME :'.$invoicedata->account_name.'&#013; IFSC CODE :'.$invoicedata->ifsc_code.'||  SWIFT CODE :'.$invoicedata->swift_code.' &#013; BANK AD CODE :'.$invoicedata->bank_ad_code):strip_tags('BANK NAME : '.$bank->bank_name.'&#013;'.$bank->bank_address.'&#013; ACCOUNT NO :'.$bank->account_no.'&#013; ACCOUNT NAME :'.$bank->account_name.'&#013; IFSC CODE :'.$bank->ifsc_code.'&#013; SWIFT CODE :'.$bank->swift_code.' &#013; BANK AD CODE :'.$bank->bank_ad_code);
	$flight_name_no				= '';				 
    $export_port_loading 		= !empty($invoicedata->port_of_loading)?$invoicedata->port_of_loading:$exporter_detail->port_of_loading;;          
	$port_of_discharge 			= $invoicedata->port_of_discharge;
	$other_reference 			= $invoicedata->other_reference;
	$lc_no 						= $invoicedata->lc_no;
	$idf_no 					= $invoicedata->idf_no;
	$export_house 				= $invoicedata->export_house;
	$contract 					= $invoicedata->contract;
	$final_destination 			= $invoicedata->final_destination;
	$district_of_origin         = $exporter_detail->district_of_origin;
	$state_of_origin			= $exporter_detail->state_of_origin;
	$supplier_other_company			= $supplier_detail->supplier_other_company;
	$export_payment_terms 		= strip_tags($invoicedata->payment_terms);
	$export_terms_of_delivery 	= !empty($invoicedata)?$invoicedata->terms_of_delivery:'Mundra (India)';
	$consiger_id 				= $invoicedata->consigne_id;
	$checked					= 'checked';	
	$invoice_currency_id 		= $invoicedata->invoice_currency_id;
	$bank_id			 		= !empty($invoicedata)?$invoicedata->bank_id:$bank->id;
	$container_size 			= $invoicedata->container_size;
	$container_twenty 			= $containerdetail->container_twenty;
	$container_forty 			= $containerdetail->container_fourty;
	$terms_id 					= $invoicedata->terms_id;
	$supplier_id 				= $supplier_id;
	$notify_id 					= $invoicedata->notify_id;
	if($mutiple_status == 1)
	{
		$performa_invoice_id  = $invoicedata->performa_invoice_id;
		$certification_charge = $invoicedata->certification_charge;
		$performa_invoice_no  = $invoicedata->invoice_no;
		$performa_invoice_date  = $invoicedata->invoice_date;
		$insurance_charge 	  = $invoicedata->insurance_charge;
		$seafright_charge 	  = $invoicedata->seafright_charge;
		$extra_calc_name 	  = $invoicedata->extra_calc_name;
		$extra_calc_opt 	  = $invoicedata->extra_calc_opt;
		$extra_calc_amt 	  = $invoicedata->extra_calc_amt;
		$discount 	  		  = $invoicedata->discount;
		$grand_total 	  	  = $invoicedata->grand_total;
		$courier_charge 	  = $invoicedata->courier_charge;
		$bank_charge 	  	  = $invoicedata->bank_charge;
		
	}
	else
	{
		$performa_invoice_id 	= $performa_invoice_id;
		$performa_invoice_no	= $invoicedata->performa_invoice_no;
		$performa_invoice_date  = $invoicedata->performa_invoice_date;
		$certification_charge	= 0;
		$insurance_charge		= 0;
		$seafright_charge		= 0;
		$extra_calc_name 	 	= $invoicedata->extra_calc_name;
		$extra_calc_opt 	 	= $invoicedata->extra_calc_opt;
		$extra_calc_amt 	 	= $invoicedata->extra_calc_amt;
		$discount				= 0;
		$grand_total		 	= 0;
		$courier_charge 	    = 0;
		$bank_charge 	  	    = 0;
	}
	$no_of_container 	  		= ($containerdetail->container_twenty + $containerdetail->container_fourty);
		
 }
else 
{
	$Today_Date					= date('d-m-Y',strtotime($invoicedata->invoice_date));
	$invoice_no					= $invoicedata->export_invoice_no;
	$performa_date  			= $invoicedata->performa_date;
	$eta_date  					= date('d-m-Y',strtotime($invoicedata->eta_date));
	$lc_no 						= $invoicedata->lc_no;
	$idf_no 					= $invoicedata->idf_no;
	$export_house 				= $invoicedata->export_house;
	$contract 					= $invoicedata->contract;
	$performa_invoice_no 		= ($invoicedata->export_ref_no);
	$export						= strip_tags($invoicedata->exporter_detail);
	$buy_order_no 				= strip_tags($invoicedata->export_buy_order_no);
	$buyer_other_consign 		= strip_tags($invoicedata->buyer_other_consign);
	$exporter_email 			= explode(",",$exporter_detail->s_email);
	$exporter_mobile 			= explode(",",$exporter_detail->s_mobile);
	$exporteremail 				= $invoicedata->e_email;
	$exportermobile 			= $invoicedata->e_mobile;
	$exporter_gstin 			= $invoicedata->e_gstin;
	$exporter_pan 				= $invoicedata->exporter_pan;
	$exporter_iec 				= $invoicedata->exporter_iec;
	$consiger_id 				= $invoicedata->consiger_id;
	$consign_address	 		= strip_tags($invoicedata->consign_address);
	$pre_carriage_by			= $invoicedata->pre_carriage_by;
	$place_of_receipt			= $invoicedata->place_of_receipt;
	$country_origin_goods 		= $invoicedata->country_origin_goods;
	$country_final_destination 	= $invoicedata->country_final_destination;
	$bank_id			 		= $invoicedata->bank_id;
	$bank_detail				= strip_tags($invoicedata->bank_detail);
	$flight_name_no				= $invoicedata->flight_name_no;
	$export_port_loading  		= $invoicedata->port_of_loading;
	$port_of_discharge 			= $invoicedata->port_of_discharge;
	$final_destination 			= $invoicedata->final_destination;
	$district_of_origin         = $invoicedata->district_of_origin;
	$state_of_origin			= $invoicedata->state_of_origin;
	$$supplier_other_company	= $invoicedata->supplier_other_company;
	$export_payment_terms 		= strip_tags($invoicedata->payment_terms);
	$no_of_container			= $invoicedata->container_details;;
	$export_terms_of_delivery 	= $invoicedata->terms_of_delivery;
	$checked					= ($invoicedata->igst_status==1)?'checked':'';
	$checked1					= ($invoicedata->igst_status==2)?'checked':'';
	$invoice_currency_id 		= $invoicedata->invoice_currency_id;
	$container_size 			= $invoicedata->container_size;
	$terms_id 					= $invoicedata->terms_id;
	$performa_invoice_id  		= $invoicedata->performa_invoice_id;
	$certification_charge 		= $invoicedata->certification_charge;
	$insurance_charge 	  		= $invoicedata->insurance_charge;
	$seafright_charge 	  		= $invoicedata->seafright_charge;
	$discount 	  		  		= $invoicedata->discount;
	$courier_charge  	  		= $invoicedata->courier_charge;
	$bank_charge 	  	  		= $invoicedata->bank_charge;
	$grand_total 	  	  		= $invoicedata->grand_total;
	$mutiple_status 	  		= $invoicedata->mutiple_status;
	$container_twenty 			= $invoicedata->container_twenty;
	$container_forty  			= $invoicedata->container_forty;
	$notify_id 					= $invoicedata->notify_id;
	$other_reference 			= $invoicedata->other_reference;
	$consignee_for_famigation 	= strip_tags($invoicedata->consignee_for_famigation);
	$containee_other_famigation = strip_tags($invoicedata->containee_other_famigation);
}
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
									<h3>Export Invoice</h3>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> Export Invoice	
								</div>
                              	<div class="form-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="invoice_form" id="invoice_form">
										<div class="panel-body">
										  <div class="col-md-12">
											 <div class="col-md-offset-4 col-md-6" style="font-size: 18px;">
												 <div class="col-md-10">
													<label class="radio-inline">
														<input type="radio" name="igst_status" id="igst_status1" value="1"   <?=$checked?> onclick="filterbystatus(this.value)" />WITHOUT IGST 
													</label>
													<label class="radio-inline">
														<input type="radio" name="igst_status" id="igst_status2" value="2" <?=$checked1?> onclick="filterbystatus(this.value)" >WITH PAYMENT OF IGST												
													</label>
												  </div>     
												</div>
											</div>
										</div>
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
												<td colspan="12"  style="font-weight:bold;vertical-align: bottom;text-align: center;">
												<span class="withouthtml">
													SUPPLY MEANT FOR EXPORT UNDER LUT WITHOUT PAYMENT OF IGST (LUT: <?=$company_detail[0]->s_lutno?>)
												</span>
													<span class="withhtml" style="display:none">
														SUPPLY MEANT FOR EXPORT WITH PAYMENT OF IGST 
													</span>
												</td>
											</tr>
											<tr>
												<td rowspan="5">
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
												<td>Export Invoice No</td>
												<td colspan="2" style="font-weight:bold">
													<input type="text" placeholder="Invoice No" style="font-weight:bold;" id="export_invoice_no" required="" class="form-control" name="export_invoice_no" value="<?=$invoice_no?>" title="Enter Invoice No">
													 <input type="hidden" id="invoice_series" required=""  name="invoice_series" value="<?=(str_pad($invoice_series + 1,strlen($invoicetype->invoice_series), '0', STR_PAD_LEFT))?>" >
												</td>
												<td>DATE</td>
												<td style="font-weight:bold">
													<input type="text" placeholder="Date" id="invoice_date" required="" style="font-weight:bold;" class="form-control defualt-date-picker" name="invoice_date" value="<?=$Today_Date?>" title="Enter Invoice Date" /> 
												</td>
											</tr>
											<tr>
												<td>Export Ref. No</td>
												<td colspan="2" >
												<?php	
													if(!empty($performa_invoice_no))
													{
												?>
														<input type="text" placeholder="Export Ref. No" id="export_ref_no" style="font-weight:bold;" class="form-control" name="export_ref_no" value="<?=$performa_invoice_no?>"/> 
													<?php	
													}
													else
													{
													?>
														<input type="text" placeholder="Export Ref. No" id="export_ref_no" style="font-weight:bold;" class="form-control" name="export_ref_no" value="<?=$performa_invoice_no?>"/> 
															 
													<?php														
													}
													?>
												</td>
												<td>DATE</td>
												<td style="font-weight:bold"> 
													<input type="text" placeholder="Date" id="date" required="" style="font-weight:bold;" class="form-control" name="date" value="<?=$performa_date?>"  >
												</td>
											</tr>
										 	<tr>
												<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">Email</td>
												<td>:</td>
												<td colspan="2" style="font-weight:bold"> 
												<select name="e_email" id="e_email" class="form-control">
											<?php 
											foreach($exporter_email as $emailid)
											{
												$sel = '';
												if($exporteremail == $emailid)
												{
													$sel ='selected="selected"';
												}
												echo "<option ".$sel." value='".$emailid."'>".$emailid."</option>";
											}
											?>
											
									</select>
									 
													 
												</td>
												<td>MOBILE</td>
												<td style="font-weight:bold" >
												<select name="e_mobile" id="e_mobile" class="form-control">
											<?php 
											foreach($exporter_mobile as $mobileno)
											{
												$sel = '';
												if($exportermobile == $mobileno)
												{
													$sel ='selected="selected"';
												}
												echo "<option ".$sel."  value='".$mobileno."'>".$mobileno."</option>";
											}
											?>
											
									</select>
												 
												</td>
												<td rowspan="2">Buyer Order No &amp; Date</td>
												<td rowspan="2" colspan="2">
														<textarea style="height: 50px;" placeholder="Export Buyer Order No &amp; Date" id="export_buy_order_no"  class="form-control" name="export_buy_order_no"><?=$buy_order_no?></textarea>
													</td>
													
													<td rowspan="2">ETA Date</td>
												<td rowspan="2" >
														<input type="text" placeholder="Date" id="eta_date" required="" style="font-weight:bold;" class="form-control defualt-date-picker" name="eta_date" value="<?=$eta_date?>" title="Enter ETA Date" /> 
													</td>
											</tr>
											
											<tr>
												<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">GSTIN</td>
												<td>:</td>
												<td colspan="2" style="font-weight:bold"> 
														<input type="text" placeholder="Exporter GSTIN" style="font-weight:bold;" id="e_gstin" required="" class="form-control" name="e_gstin" value="<?=$exporter_gstin?>" title="Enter GST">
												</td>
												<td>PAN NO</td>
												<td  style="font-weight:bold" >
													<input type="text" placeholder="Exporter PAN NO" style="font-weight:bold;" id="exporter_pan" required="" class="form-control" name="exporter_pan" value="<?=$exporter_pan?>"title="Enter Pan No" >
												</td>
												
											</tr>
											<tr>
												<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">IEC</td>
												<td >:</td>
												<td colspan="4" style="font-weight:bold"> 
														<input type="text" placeholder="Exporter IEC" style="font-weight:bold;" id="exporter_iec" required="" class="form-control" name="exporter_iec" value="<?=$exporter_iec?>" title="Enter IEC"/>
												</td>
												 
												<td>Other Reference</td>
												<td colspan="4">
														<textarea style="height: 50px;" placeholder="Other Reference" id="other_reference"  class="form-control" name="other_reference"><?=$other_reference?></textarea>
													</td>
											 
											</tr>
									 		<tr>
												<td rowspan="3" style="font-size: 11px;">
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
													 <select class="" name="consiger_id" id="consiger_id" required onchange="load_consigner(this.value,'Add',0)" title="Select Consigner">
														<option value="">Please Select Consigner</option>
														<option value="0" style="color:blue">Add New Consigner</option>
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
													<textarea class="form-control"  rows="4"  name="buyer_other_consign" id="buyer_other_consign"><?=$buyer_other_consign?></textarea>
													<input class="hidden"  name="notify_id" id="notify_id"  value="<?=$notify_id?>"/>
												</td>
											</tr>
											<tr>
												
												<td colspan="6">
												CONSIGNEE Detail (Famigation)
														<textarea class="form-control" rows="4" name="consignee_for_famigation" id="consignee_for_famigation"    title="Enter Consign Detail" placeholder="Consign Detail"><?=$consignee_for_famigation?></textarea>
												</td>
												<td >Buyer If Other Then Consignee [Notify] (Famigation)</td>
												<td colspan="4">
													<textarea class="form-control" rows="4"  name="containee_other_famigation" id="containee_other_famigation"><?=$containee_other_famigation?></textarea>
												</td>
											</tr>
											<tr>
												<td colspan="4">LC NO</td>
												<td colspan="3">IDF NO </td>
												<td colspan="2">CONTRACT</td>
												<td colspan="3">2** EXPORT HOUSE </td>
											 </tr>
											<tr>
												<td colspan="4" style="font-weight:bold">
													<input type="text" placeholder="LC NO" style="font-weight:bold;" id="lc_no"   class="form-control" name="lc_no" value="<?=$lc_no?>" >
												</td>
												<td colspan="3" style="font-weight:bold">
													<input type="text" placeholder="IDF NO " style="font-weight:bold;" id="idf_no" class="form-control" name="idf_no" value="<?=$idf_no?>" >
												</td>
												<td colspan="2" style="font-weight:bold">
													<input type="text" placeholder="CONTRACT" style="font-weight:bold;" id="contract"  class="form-control" name="contract" value="<?=$contract?>" >
												</td>
												<td colspan="3" style="font-weight:bold">
														<input type="text" placeholder="2** EXPORT HOUSE" style="font-weight:bold;width:90%;float: left;" id="export_house"  class="form-control" name="export_house" value="<?=$export_house?>"   >
														<div id="customer_rules" style="display:none"><i class="fa fa-question-circle" id="popoverData" style="padding: 5px;" data-content="" rel="popover" data-placement="top"   data-trigger="hover"></i></div>
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
													<?php 
													if($direct_invoice == 1)
													{
													?>
													<select name="bank_id" id="bank_id" class="form-control" onchange="load_bank_detail(this.value)">
													<option value="">Select Bank</option>
													<?php 
													 for($i=0; $i<count($all_bank);$i++)
													{
														$sel ='';
														 if($all_bank[$i]->id==$bank_id)
														 {
															 $sel = 'selected="selected"';
														 }
														 
													?>
														<option <?=$sel?> value="<?php echo $all_bank[$i]->id; ?>" ><?php echo $all_bank[$i]->bank_name; ?></option>
													<?php
													}
													?>
													</select>
													<br>
													<?php
													}
													else
													{
														?>
														<input type="hidden" name="bank_id" id="bank_id" value="<?=$bank_id?>"/>
														<?php
													}
													?>
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
												<td colspan="4">District of Origin</td>
												<td colspan="3">State Of Origin</td>
												<td rowspan="2" colspan="2" style="tet-align:center;">Supplier Other Company</td>
												 
											 </tr>
											<tr>
												<td colspan="4" style="font-weight:bold;text-align:center">
														<input type="text" placeholder="District of Origin" style="font-weight:bold;" id="district_of_origin" required="" class="form-control" name="district_of_origin" value="<?=$district_of_origin?>" title="Enter District Of Origin">
												</td>
												<td colspan="3" style="font-weight:bold">
													<input type="text" placeholder="State Of Origin" style="font-weight:bold;" id="state_of_origin" required="" class="form-control" name="state_of_origin" value="<?=$state_of_origin?>" title="Enter State Of Origin">
												</td>
												
												<td  colspan="3" style="font-weight:bold">
												
													<select class="select2"  name="supplier_other_company" id="supplier_other_company"   title="Select Supplier Other Company">
														<option value="">Please Select Other Company</option>
														<!--	<option value="0" style="color:blue">Add New Consigner</option>-->
														<?php 
														for($i=0; $i<count($supplier_detail);$i++)
														{
															$selected='';
															if($supplier_other_company==$supplier_detail[$i]->supplier_id)
															{
																$selected = 'selected="selected"';
															}
														?>
															<option <?=$selected?> value="<?=$supplier_detail[$i]->supplier_other_company?>"><?=$supplier_detail[$i]->supplier_other_company?></option>
														<?php
														}
														?>
													</select>
														 
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
										<input type="text"  id="container_twenty"  name="container_twenty"  class="form-control"  value="<?=$container_twenty?>"  onkeyup="cal_total()" onblur="cal_total()" <?=($direct_invoice == 1)?"":"readonly"?>>
									</td>				
									<td colspan="2">
										<input type="text"  id="container_forty" name="container_forty"  class="form-control"  value="<?=$container_forty?>" onkeyup="cal_total()" onblur="cal_total()" <?=($direct_invoice == 1)?"":"readonly"?>>
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
														<?php
															if(!empty($pastinvoicedata))
															{
														?>
														<table width="100%" > 
															<tr>
																<td colspan="2" class="text-center">Past Export Invoice No</td>
															</tr>
															<tr>
																<td>Export Invoice No</td>
																<td>No Of Container</td>
															</tr>
															<?php
															
															foreach($pastinvoicedata as $exportinvoice)
															{
																echo "<tr>
																		<td>
																			<a href='".base_url()."exportinvoice/export_edit/".$exportinvoice->export_invoice_id."' >".$exportinvoice->export_invoice_no."</a>
																		</td>
																		<td>".$exportinvoice->container_details."</td>
																	</tr>";
															}
															 ?>
														</table>
															<?php } ?>
													</td>
													<td colspan="2"> 
											<button type="submit" name="submit" class="btn btn-success">
												NEXT
											</button>
											
											<a href="<?=base_url().'exportinvoice_listing'?>" class="btn btn-danger">
												Cancel
											</a>
													</td>
													<td>
														Advance Payment
													</td>
													<td colspan="4">
														<select name="payment_id" id="payment_id" class="form-control">
															<option value="">Select Advance Payment</option>
														</select>
													</td>
												</tr>
				 
								</table>
								 	</div>
								
									
							 </div>
							 
							 
							 <input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>			
							 <input type="hidden" name="performa_invoice_id" id="performa_invoice_id" value="<?=$performa_invoice_id?>"/>			
							 <input type="hidden" name="supplier_id" id="supplier_id" value="<?=$supplier_id?>"/>			
							 <input type="hidden" name="container_status" id="container_status" value="<?=$container_status?>"/>			
							 <input type="hidden" name="no_of_export" id="no_of_export" value="<?=$invoicedata->no_of_export?>"/>			
							<input type="hidden" name="certification_charge" id="certification_charge" value="<?=$certification_charge?>"/>			
							 <input type="hidden" name="insurance_charge" id="insurance_charge" value="<?=$insurance_charge?>"/>			
							 <input type="hidden" name="seafright_charge" id="seafright_charge" value="<?=$seafright_charge?>"/>			
							 <input type="hidden" name="seafright_action" id="seafright_action" value="<?=$invoicedata->seafright_action?>"/>			
							 <input type="hidden" name="extra_calc_name" id="extra_calc_name" value="<?=$invoicedata->extra_calc_name?>"/>			
							 <input type="hidden" name="extra_calc_opt" id="extra_calc_opt" value="<?=$invoicedata->extra_calc_opt?>"/>			
							 <input type="hidden" name="extra_calc_amt" id="extra_calc_amt" value="<?=$invoicedata->extra_calc_amt?>"/>			
							 		
							 <input type="hidden" name="calculation_operator" id="calculation_operator" value="<?=$invoicedata->calculation_operator?>"/>			
							 <input type="hidden" name="discount" id="discount" value="<?=$discount?>"/>			
							 <input type="hidden" name="bank_charge" id="bank_charge" value="<?=$bank_charge?>"/>			
							 <input type="hidden" name="courier_charge" id="courier_charge" value="<?=$courier_charge?>"/>			
							 <input type="hidden" name="grand_total" id="grand_total" value="<?=$grand_total?>"/>			
							 <input type="hidden" name="mutiple_status" id="mutiple_status" value="<?=$mutiple_status?>"/>			
							 <input type="hidden" name="export_invoice_id" id="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"/>			
							 <input type="hidden" name="direct_invoice" id="direct_invoice" value="<?=$direct_invoice?>"/>	</form>
					    
								</div>
						 
                            </div>
							 
						</div>
					</div>
				 
				</div>
		</div>
</div>
<script>
function cal_total()
{
	var container_forty = ($("#container_forty").val() > 0)?$("#container_forty").val():0;
	var container_twenty = ($("#container_twenty").val() > 0)?$("#container_twenty").val():0;
	$("#container_details").val(parseInt(container_forty) + parseInt(container_twenty))
}
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
$this->view('lib/addcountry');
$this->view('lib/addconsigner');
?>

 
<script>
$(document).ready(function() {
	 
    $( "#payment_terms" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Exportinvoice/search",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.payment_terms;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 })
 
 $(document).ready(function() {
	 
    $( "#port_of_discharge" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Exportinvoice/search1",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.port_name;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 })
 
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
	else if(parseInt($("#container_details").val()) == 0 || $("#container_details").val() =="")
	{
		toastr['error']('Please add container')
		return false;
	}
	
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'exportinvoice/manage',
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
					<?php 
					
					if($direct_invoice == 1)
					{
					?>
						setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+obj.invoiceid; },1500);
					<?php 
					}
					else
					{
					?>
						setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/'+obj.invoiceid; },1500);
					<?php 
					}
					?>
				}
				else if(obj.res==3)
			   {
				   $("#invoice_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
				<?php 
					if($direct_invoice == 1)
					{
					?>
						setTimeout(function(){ window.location=root+'exportinvoiceproduct/direct/'+obj.invoiceid; },1500);
					<?php 
					}
					else
					{
					?>
						setTimeout(function(){ window.location=root+'exportinvoiceproduct/index/'+obj.invoiceid; },1500);
					<?php 
					}
					?>
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

function  load_consigner(cidval,mode,payment_id)
{
		if(cidval==0)
		{
			add_new_consigner();
			return false;
		}
		else{
			 
			block_page();
			if(mode == "Add")
			{
        $("#consign_list").empty();
		$('#buyer_other_consign').text('');
        $('#country_final_destination').val('');
		$('#port_of_discharge').val('');
        $('#final_destination').val('');
			}
        $.ajax({
          type :'POST',
          url  :root+'invoice/selectcompnay',
          data :{
            'e_id' : cidval,
			 'mode' : mode,
            'type' : 'consigner'
          },
          success : function(msg){
            
			if(mode == "Edit")
			{
				var obj=JSON.parse(msg);
				var data = obj.data1  
				var cdata = obj.data2  
			
				$("#payment_id").html(obj.payment_data);
				$("#payment_id").val(payment_id);
			}
			else
			{
				var obj=JSON.parse(msg);
				var data = obj.data1  
				var cdata = obj.data2  
				var cname= data['c_companyname'];
				var c_name= data['c_name'];
				
				var c_address = data['address'];
				var c_city= data['c_city'];
				var c_country = data['country_name'];
				var port_of_discharge = data['port_of_discharge'];
				var c_registration_detail = data['c_registration_detail'];
				var result = ""+cname+"\n"+c_address+"\n"+c_city+"\n"+c_country+"\n"+c_registration_detail;
				var cname = cdata['consiger_name'];
				var i,content,j;
				$("#payment_id").html(obj.payment_data);
            $('#consign_address').val('TO THE ORDER');
            $('#consignee_for_famigation').val('TO THE ORDER');
            $('#buyer_other_consign').val(result.replace(/^\s*[\r\n]/gm, ''));
            $('#containee_other_famigation').val(result.replace(/^\s*[\r\n]/gm, ''));
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
			if(data['payment_terms'] != "")
			{
				$('#payment_terms').val(data['payment_terms']);
			}
            $('#invoice_currency_id').select2("val",data['currency_id']);
            	if(data['bank_id'] != "" && data['bank_id'] != undefined)
				{
					$('#bank_id').val(data['bank_id']);
					
						var bankdetail = 'BANK NAME : '+data['bank_name']+' \n '+data['bank_address']+'\n ACCOUNT NO :'+data['account_no']+'\n ACCOUNT NAME :'+data['account_name']+'\n IFSC CODE :'+data['ifsc_code']+' || SWIFT CODE :'+data['swift_code']+' \n BANK AD CODE :'+data['bank_ad_code'];
					$('#bank_detail').val(bankdetail);
				}
				for (i=0;i<cdata.length;i++) {
               
                    content = "<div class='btn btn-default' onclick='selectotherconsigner("+cdata[i][1]+")' id="+cdata[i][1]+">"+cdata[i][0]+"</div>&nbsp;&nbsp;";
                    //$("#consign_list").append(content);
				}
			}
			  unblock_page('','');
          }
        })

      
	   }

}

function load_bank_detail(bankid)
{
	 $.ajax({
      type :'POST',
      url  :root+'invoice/bank_detail',
      data :{
        'bankid' : bankid 
      },
      success : function(msg1)
	  {
         var obj1=JSON.parse(msg1);
			var bankdetail = 'BANK NAME : '+obj1.bank_name+' \n '+obj1.bank_address+'\n ACCOUNT NO :'+obj1.account_no+'\n ACCOUNT NAME :'+obj1.account_name+'\n IFSC CODE :'+obj1.ifsc_code+' || SWIFT CODE :'+obj1.swift_code+' \n BANK AD CODE :'+obj1.bank_ad_code;
			$('#bank_detail').val(bankdetail);
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
 
<?php 
if($mode=="Edit")
{
	echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>";
	echo "<script>load_consigner(".$invoicedata->consiger_id.",'Edit',".$invoicedata->advance_payment_id.")</script>";
}
?>