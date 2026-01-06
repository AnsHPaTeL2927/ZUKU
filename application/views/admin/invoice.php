<?php 
if($mode=="Add")
{
	$Today_Date= date('d-m-Y');
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
			 $invoice_no .= date('y');
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
			$invoice_no .= date('y');
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
					array_push($value,date('y'));
				}
				if(in_array(4,$explode_array))
				{
					$year = date('n') >= 4 ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
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
	$Time=date("h:i A");
	$exporter_Address				= $exporter_detail->s_name."&#13;&#10;".strip_tags($exporter_detail->s_address)."&#13;&#10;";
	$country_origin_goods 			= 'INDIA';
	$country_final_destination 		= '';
	$exporter_email 				= explode(",",$exporter_detail->s_email);
	$exporter_mobile 				= explode(",",$exporter_detail->s_mobile);
	$contact_person_name 	 		= explode(",",$exporter_detail->contact_person_name);
	 
	$export_port_loading 			= $exporter_detail->port_of_loading;
	$export_transhipment 			= $exporter_detail->transhipment;
	$export_partial_shipment 		= '';
	$exporter_variation_in_quantity = $exporter_detail->variation_in_quantity;
	$export_delivery_period   		= $exporter_detail->delivery_period;
	$export_payment_terms 	  		= $exporter_detail->payment_terms;
	$export_terms_of_delivery 		= $exporter_detail->terms_of_delivery;
	$remarks 						= $exporter_detail->performa_detail;
	 
	$bank_id 						= $exporter_detail->bank_name;
	$bank_name 						= $bank_detail->bank_name;
	$bank_address 					= $bank_detail->bank_address;
	$bank_account_name				= $bank_detail->account_name;
	$bank_account_no				= $bank_detail->account_no;
	$bank_ifsc_code					= $bank_detail->ifsc_code;
	$bank_swift_code				= $bank_detail->swift_code;
	$bank_ad_code					= $bank_detail->bank_ad_code;
	$iban_number					= $bank_detail->iban_number;
	$terms_id = '';
	 
}
else 
{
	$Today_Date= date('d-m-Y',strtotime($invoicedata->performa_date));
	$invoice_no=$invoicedata->invoice_no;
	$Time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";
	$exporter_Address				= strip_tags($invoicedata->exporter_detail);
	 
	$export_port_loading  			= $invoicedata->port_of_loading;
	$export_transhipment 			= $invoicedata->transhipment;
	$export_partial_shipment 		= $invoicedata->partial_shipment;
	$exporter_variation_in_quantity = $invoicedata->variation_in_quantity;
	$export_delivery_period 		= $invoicedata->delivery_period;
	$export_payment_terms 			= $invoicedata->payment_terms;
	$export_terms_of_delivery 		= $invoicedata->terms_of_delivery;
	$country_origin_goods 			= $invoicedata->country_origin_goods;
	$country_final_destination 		= $invoicedata->country_final_destination;
	$terms_id 						= $invoicedata->terms_id;
	$remarks 						= $invoicedata->remarks;
	$bank_id 						= $invoicedata->bank_id;
	$bank_name 						= $invoicedata->bank_name;
	$bank_address 					= $invoicedata->bank_address;
	$bank_account_name				= $invoicedata->account_name;
	$bank_account_no				= $invoicedata->account_no;
	$bank_ifsc_code					= $invoicedata->ifsc_code;
	$bank_swift_code				= $invoicedata->swift_code;
	$bank_ad_code					= $invoicedata->bank_ad_code;
	$iban_number					= $invoicedata->iban_number;
	$exporter_email 				= explode(",",$exporter_detail->s_email);
	$exporter_mobile 				= explode(",",$exporter_detail->s_mobile);
  	$exporteremail 					= $invoicedata->e_email;
	$exportermobile 				= $invoicedata->e_mobile;
	$contact_person_name 	 		= explode(",",$exporter_detail->contact_person_name);
	$contactperson_name 			= $invoicedata->contactperson_name;

	
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
			 				<a href="<?=base_url().'invoice_listing'?>">Proforma Invoice List</a>
			 			</li>
			 			 
			 		</ol>
			 		<div class="page-header title1">
			 			<h3>Proforma Invoice</h3>
			 		</div>
			 	</div>
			 </div>
			 <div class="row">
			 	<div class="col-sm-12">
			 		<div class="panel panel-default">
			 			<div class="panel-heading">
			 				<i class="fa fa-external-link-square"></i>
			 				<?=($mode=="Edit")?$mode:'Create New'?> Proforma Invoice

							<a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
							<div id="myModal1" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title">How To Make Performa Invoice</h4>
										</div>
										<div class="modal-body">
											<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/3r-QzWpM1EQ?rel=0&autoplay=0&start=35"
											frameborder="0" allowfullscreen></iframe>
										</div>
									</div>
								</div>
							</div>
			 			</div>
                         <div class="">
			 			   <div class="panel-body form-body">
				<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="invoice_form" id="invoice_form"  style="padding:10px">
						 <table cellspacing="0" cellpadding="0" class="table table-bordered">
								<tr>
										<td width="5%"  style="padding:0"></td>
										<td width="5%"  style="padding:0"></td>
										<td width="2%"  style="padding:0"></td>
										<td width="10%"  style="padding:0"></td>
										<td width="5%" style="padding:0"></td>
										<td width="8%"  style="padding:0"></td>
										<td width="15%" style="padding:0"></td>
										<td width="15%" style="padding:0"></td>
										<td width="15%" style="padding:0"></td>
										<td width="8%"  style="padding:0"></td>
										<td width="12%" style="padding:0"></td>
										 
								</tr>
								<tr>
										<td colspan="12">PROFORMA INVOICE</td>
								</tr>
								<tr>
										
									 
								</tr>
								<tr>
								<td colspan="3">CONSIGNEE NAME :</td>
									<td colspan="4">
										
										<select class="" name="c_name" id="c_name" required onchange="load_consigner(this.value)"  style="width:100%">
										<option value="">Please Select Consigner</option>
										<option value="0" style="color:blue">Add New Consigner</option>
										<?php 
										for($i=0; $i<count($consign_detail);$i++)
										{
											$selected='';
											if($invoicedata->consigne_id==$consign_detail[$i]->id)
											{
												$selected = 'selected="selected"';
											}
											$cust_name = (!empty($consign_detail[$i]->c_nick_name))?$consign_detail[$i]->c_nick_name:$consign_detail[$i]->c_companyname;
										?>
											<option <?=$selected?> value="<?=$consign_detail[$i]->id?>"><?=$cust_name?></option>
										<?php
										}
										?>
									 
										</select>
										
									</td>
									<td style="font-weight:bold;">Currency : </td>
										<td colspan="3" style="font-weight:bold;">
											<select class="select2" name="invoice_currency_id" id="invoice_currency_id" required title="Select Currency">
												<option value="">Select Currency</option>	
													<?php
													for($currency=0;$currency<count($currencydata);$currency++)
													{
														$select = '';
														if($currencydata[$currency]->currency_id==@$invoicedata->invoice_currency_id)
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
									<td rowspan="5">EXPORTER</td>
									<td rowspan="3" colspan="6">
										<textarea type="text" name="exporter_detail" rows="6" class="validate[required] form-control" id="exporter_detail" readonly="readonly"><?=$exporter_Address?></textarea>
									</td>
									<td>Proforma Invoice No</td>
									<td>
										<input type="text" placeholder="Invoice No" style="font-weight:bold;" id="invoice_no" required="" class="form-control" name="invoice_no" value="<?=$invoice_no?>" <?=($invoicedata->confirm_status == 1)?"readonly":""?>>
										<input type="hidden" id="invoice_series" required=""  name="invoice_series" value="<?=(str_pad($invoice_series + 1,strlen($invoicetype->invoice_series), '0', STR_PAD_LEFT))?>" >
									</td>
									<td>DATE</td>
									<td>
										<input type="text" placeholder="Date" id="date" required="" style="font-weight:bold;" class="form-control defualt-date-picker" name="date" value="<?=$Today_Date?>"  >
									</td>
							  </tr>
								<tr>
								<td>Export Ref. No</td>
								<td>
									<input type="text" placeholder="Export Ref. No" id="export_ref_no"  class="form-control" name="export_ref_no" value="<?=$invoicedata->export_ref_no?>" >
								</td>
								<td>Time</td>
								<td>
									<input type="text" placeholder="Time" id="time"  style="font-weight:bold;" class="form-control timepicker" name="time" value="<?=$Time?>"  autocomplete="off"/>
								</td>
							  </tr>
								<tr>
								<td>Buyer Order No &amp; Date</td>
								<td colspan="3">
									<input type="text" placeholder="Buyer Order No & Date" id="buy_order_no"  class="form-control" name="buy_order_no" value="<?=strip_tags($invoicedata->buy_order_no)?>" >
								</td>
							  </tr>
								<tr>
								<td>Email </td>
								<td>:</td>
								<td colspan="2">
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
								<td>Mobile</td>
								<td>
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
								<td rowspan="2" >Other Reference(s)</td>
								<td colspan="3"  rowspan="2">
									<input type="text" placeholder="Other Reference(s)" id="other_reference"  class="form-control" name="other_reference" value="<?=$invoicedata->other_reference?>" >
								</td>
								 
							  </tr>
							  <tr>
								<td colspan="3">Contact Person Name</td>
								<td>:</td>
								<td colspan="2">
									<select name="contactperson_name" id="contactperson_name" class="form-control">
											<?php 
											foreach($contact_person_name as $name)
											{
												$sel = '';
												if($contactperson_name == $name)
												{
													$sel ='selected="selected"';
												}
												echo "<option ".$sel." value='".$name."'>".$name."</option>";
											}
											?>
											
									</select>
									 
								</td>
								 
							  </tr>
							  <tr>
									<td rowspan="2">CONSIGNEE</td>
									
									<td colspan="3">
										 Port Of Discharge
									</td>
									 <td colspan="3">
											<input type="text" placeholder="Port Of Discharge" style="font-weight:bold;" id="port_of_discharge" required="" class="form-control" name="port_of_discharge" value="<?=$invoicedata->port_of_discharge?>" title="Enter Port Of Discharge">
									</td>
								</tr>
								 <tr>
									<td colspan="6">
											<textarea class="form-control" rows="4" name="consign_detail" id="consign_detail"  required title="Enter Consign Detail" placeholder="Consign Detail"><?=strip_tags($invoicedata->consign_detail)?></textarea>
									</td>
								<td >Buyer If Other Then Consignee [Notify]</td>
								<td colspan="3">
									<div id="consign_list" style="<?=($mode=="Edit" && !empty($invoicedata->notify_id))?"":"display:none"?>">
											<select class="select2" name="notify_id" id="notify_id"   onchange="selectotherconsigner(this.value)"  style="width:100%">
											<option value="">Select Notify</option>
											<?php 
											foreach($notifydata as $resulrarray)
											{
												$sel = '';
												if($resulrarray->id = $invoicedata->notify_id)
												{
													$sel ='selected="selected"';
												}
												echo '<option '.$sel.' value="'.$resulrarray->id.'">'.$resulrarray->notify_name.'</option>';
											} 
											?>
										</select>
										</div>
									<textarea class="form-control" rows="4"  name="buyer_other_consign" id="buyer_other_consign"><?=strip_tags($invoicedata->buyer_other_consign)?></textarea>
								</td>
							  </tr>
							   <tr>
									<td colspan="4">Country of Origin Of Goods</td>
									<td colspan="3">Country of Final Destination</td>
									<td colspan="2">Port Of Loading</td>
									<td colspan="2">Transhipment </td>
							  </tr>
							  <tr>
									<td colspan="4">
											<input type="text" placeholder="Country of Origin Of Goods" style="font-weight:bold;" id="country_origin_goods" required="" class="form-control" name="country_origin_goods" value="<?=$country_origin_goods?>" >
									</td>
									<td colspan="3">
										<input type="text" placeholder="Country of Final Destination" style="font-weight:bold;width:90%;float: left;" id="country_final_destination" required="" class="form-control" name="country_final_destination" value="<?=$country_final_destination?>" title="Enter Country of Final Destination"  >
										<div id="customer_rules" style="display:none"><i class="fa fa-question-circle" id="popoverData" style="padding: 5px;" data-content="" rel="popover" data-placement="top"   data-trigger="hover"></i></div>
									</td>
									<td colspan="2"> 
										<input type="text" placeholder="Port Of Loading	" style="font-weight:bold;" id="port_of_loading"  class="form-control" name="port_of_loading" value="<?=$export_port_loading?>" >
									
									</td>
									<td colspan="2"> 
										<input type="text" placeholder="Transhipment" id="transhipment" style="font-weight:bold;"  class="form-control" name="transhipment" value="<?=$export_transhipment?>" >
									
									</td>
							  </tr>
							   <tr>
									<td colspan="4">Vessel/Flight No</td>
									<td colspan="3">Final Destination</td>
									<td colspan="">Variation in Quantity </td>
									<td colspan="3">Delivery Period </td>
							  </tr>
							   <tr>
									<td colspan="4">
											<input type="text" placeholder="Vessel/Flight No" style="font-weight:bold;" id="partial_shipment"  class="form-control" name="partial_shipment" value="<?=$export_partial_shipment?>" >
									</td>
									<td colspan="3">
											<input type="text" placeholder="Final Destination" style="font-weight:bold;" id="final_destination" required="" class="form-control" name="final_destination" value="<?=$invoicedata->final_destination?>" title="Enter Final Destination">
									</td>
									<td colspan=""> 
											<input type="text" placeholder="Variation in Qantity" style="font-weight:bold;" id="variation_in_quantity"  class="form-control" name="variation_in_quantity" value="<?=$exporter_variation_in_quantity?>" >
									</td>
									<td colspan="3">
											<input type="text" placeholder="Delivery Period" id="delivery_period" style="font-weight:bold;"  class="form-control" name="delivery_period" value="<?=$export_delivery_period?>" >
									</td>
							   </tr>
							   <tr>
									<td colspan="3">20 FT FCL</td>
									<td colspan="2">40 FT FCL</td>
									<td colspan="2">Terms of Delivery </td>
									<td rowspan="2">Payment Terms</td>
									<td colspan="3" rowspan="2">
										
										<textarea class="form-control" rows="2" name="payment_terms" id="payment_terms" style="font-weight:bold;height:auto;"  ><?=strip_tags($export_payment_terms)?></textarea>
									</td>
							</tr>
								<tr>
									<td colspan="3"> 
										<input type="text"  id="container_twenty"  name="container_twenty"  class="form-control"  value="<?=$invoicedata->container_twenty?>"  onkeyup="cal_total()" onblur="cal_total()" >
										
									</td>
									 
									<td colspan="2">
										<input type="text"  id="container_forty" name="container_forty"  class="form-control"  value="<?=$invoicedata->container_forty?>" onkeyup="cal_total()" onblur="cal_total()" >
										<input type="hidden"  id="container_details"   name="container_details"  class="form-control"  value="<?=$invoicedata->container_details?>"  >
									</td>
									 
									<td>
										<select name="terms_id" id="terms_id" class="form-control" onchange="remove_terms_of_delivery(this.options[this.selectedIndex].text)">
											 <?php 
											 foreach($termsdata as $terms)
											 {
												 $sel ='';
												 
												 if($terms->terms_id == $terms_id)
												 {
												 	$sel = 'selected="selected"';
												 }
												 echo "<option ".$sel."  value='".$terms->terms_id."'>".$terms->terms_name."</option>";
											 } ?>
										</select>
									</td>
									<td>
										<input type="text" placeholder="Terms of Delivery " style="font-weight:bold;" id="terms_of_delivery"  class="form-control" name="terms_of_delivery" value="<?=($export_terms_of_delivery)?>" >
									</td>
						  </tr>
						   <tr>
									<td colspan="5">Max. Weight Limit Of Container(KG)</td>
									 
										<td colspan="2">
										<input type="text" style="font-weight:bold;"  placeholder="Max. Weight Limit Of Container" id="limit_container"   class="form-control multiple_input" name="limit_container" value="<?=$invoicedata->limit_container?>"  title="Enter Max. Weight Limit Of Container">
										
										<select id="limit_container1" name="limit_container1" class="form-control multiple_select" style="font-weight:bold;display:none"  >
											<option value="">Select Limit</option>
											
										</select>
									 
									</td>
									<td rowspan="2">NOTES :</td>
									 <td colspan="3" rowspan="2">
										<textarea class="form-control" rows="2" name="remarks" id="remarks" style="font-weight:bold;height:auto;">
<?= str_replace(["<br>", "<br/>", "<br />"], "\n", $remarks) ?>
</textarea>

									</td>
							</tr>
							<tr>
									<td colspan="3">Select Bank</td>
									 <td colspan="2">
										<select name="bank_id" id="bank_id" class="form-control" onchange="load_bank_detail(this.value)" required title="Enter Bank">
													<option>Select Bank</option>
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
									 </td>
									<td rowspan="2"><input type="text" name="account_name" id="account_name" value="<?=$bank_account_name?>" readonly /> 			 </td>
									<td rowspan="2"> <input type="text" readonly name="account_no" id="account_no" value="<?=$bank_account_no?>"/></td>
									 
							</tr>
						 </table>
							 	
								<div class="" >
									<button type="submit" name="submit" value="next" class="btn btn-success">
											Next
									</button>
									<?php 
									if($invoicedata->step == 3)
									{
									?>
									<button type="submit" name="submit"  value="save" class="btn btn-success">
											Save & Exit 
									</button>
									<?php 
									 }
									?>
									<a href="<?=base_url().'invoice_listing'?>" class="btn btn-danger">
										Cancel
									</a>
								 </div>	
										
							 
							<input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>			
							<input type="hidden" name="bank_name" id="bank_name" value="<?=$bank_name?>"/>			
							<input type="hidden" name="bank_address" id="bank_address" value="<?=$bank_address?>"/>			
								
							<input type="hidden" name="ifsc_code" id="ifsc_code" value="<?=$bank_ifsc_code?>"/>			
							<input type="hidden" name="swift_code" id="swift_code" value="<?=$bank_swift_code?>"/>			
							<input type="hidden" name="bank_ad_code" id="bank_ad_code" value="<?=$bank_ad_code?>"/>			
							<input type="hidden" name="iban_number" id="iban_number" value="<?=$iban_number?>"/>			
							<input type="hidden" name="performa_invoice_id" id="performa_invoice_id" value="<?=$invoicedata->performa_invoice_id?>"/>			
							<input type="hidden" name="c_terms_of_delivery" id="c_terms_of_delivery" value="<?=$exporter_detail->terms_of_delivery?>"/>			
					 </form>
					    
						   </div>
						 </div>
                     </div>
				 </div>
			 </div>
		</div>
	</div>
</div>
<?php 
$this->view('lib/footer');
$this->view('lib/addcountry');
$this->view('lib/addcurrency');
$this->view('lib/addconsigner');
?>

<script>
 $(document).ready(function() {
	 
    $( "#payment_terms" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Invoice/search",
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
            url: root + "Invoice/search1",
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
 
 $(document).ready(function() {
	 
    $( "#port_of_loading" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Invoice/search1",
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
 
 $(document).ready(function() {
	 
    $( "#final_destination" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Invoice/search1",
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
 
$(document).ready(function(){
		/* Get iframe src attribute value i.e. YouTube video url
		and store it in a variable */
    var url = $("#cartoonVideo").attr('src');
    
    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $("#myModal1").on('hide.bs.modal', function(){
        $("#cartoonVideo").attr('src', '');
    });
    
    /* Assign the initially stored url back to the iframe src
    attribute when modal is displayed again */
    $("#myModal1").on('show.bs.modal', function(){
        $("#cartoonVideo").attr('src', url);
    });
});

function remove_terms_of_delivery(val)
{
	if(val == "FOB")
	{
		$("#terms_of_delivery").val($("#c_terms_of_delivery").val())
	}
	else if(val == "Ex factory")
	{
		$("#terms_of_delivery").val("Ex factory")
	}
	else
	{
		$("#terms_of_delivery").val($("#port_of_discharge").val())
	}
}
function cal_total()
{
	var container_forty = ($("#container_forty").val() > 0)?$("#container_forty").val():0;
	var container_twenty = ($("#container_twenty").val() > 0)?$("#container_twenty").val():0;
	$("#container_details").val(parseInt(container_forty) + parseInt(container_twenty))
}

function matchStart(params, data) 
{
    params = params || '';
	if (data.toUpperCase().indexOf(params.toUpperCase()) == 0) {
        return data;
    }
	return false;
}
$(".select2").select2({
	width:"100%"
});
$("#c_name").select2({
	 width:'element',
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

 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
  $('.timepicker').datetimepicker({
      format: 'HH:ii P',
	  autoclose: true,
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
			c_name: {
				required: true
			} 
		},
		messages: {
			c_name: {
				required: "Enter Customer Name"
			} 
		}
	});
	$("#consigner_form").validate({
		rules: {
			c_email_address: {
				 email:true
			}
		},
		messages: {
			c_email_address: {
				 email:"Email Id Not Vaild" 
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
	else if($("#container_details").val() == 0 || $("#container_details").val() =="")
	{
		toastr['error']('Please add container')
		return false;
	}
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'invoice/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
			   if(obj.res==1)
			   {
				   //$("#invoice_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'product/index/'+obj.invoiceid; },1500);
				}
				else if(obj.res==3)
			   {
				   $("#invoice_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					var val = $(document.activeElement).val();
					 
					if(val == "next")
					{
						setTimeout(function(){ window.location=root+'product/index/'+obj.invoiceid; },1500);
				 	}
					else
					{
						setTimeout(function(){ window.location=root+'performa_invoice_pdf/index/'+obj.invoiceid; },1500);
					}
					 
				}
				else if(obj.res==4)
			   {
				   $("#invoice_no").focus();
				     unblock_page("error","Performa Invoice Number Same.");
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

function add_new_consigner()
{
	$(".modal").css('z-index','10000');
	 $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
    $("#myModal").css('z-index','1050');     

		
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
				    $("#c_name").append("<option value='"+obj.id+"' selected>"+obj.c_companyname+"</option>");
					$("#c_name").val(obj.id);
					$("#c_name").trigger("change")
			   }
			   
			   else if(obj.res==2)
				{
					unblock_page("error","Company Name already exist");
				
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


function  load_consigner(cidval){
		if(cidval==0)
		{
			add_new_consigner();
			return false;
		}
		else{
			 
			block_page();
         
		$('#buyer_other_consign').text('');
        $('#country_final_destination').val('');
		$('#port_of_discharge').val('');
        $('#final_destination').val('');
        $('#consign_detail').val('');
        $('#buyer_other_consign').val('');
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
            var c_country = data['country_name'];
            var c_state = data['c_state'];
            var c_city = data['c_city'];
            var port_of_discharge = data['port_of_discharge'];
            var c_registration_detail = data['c_registration_detail'];
            var c_postcode = data['c_postcode'];
            var result = ""+cname+"\n"+c_address+"\n"+c_city+"\n"+c_state+"\n"+c_registration_detail+"\n"+c_postcode;
             
            var i,content,j;
            $('#consign_detail').val(result.replace(/^\s*[\r\n]/gm, ''));
             
			if(data.company_rules!='')
			{
				$('#customer_rules').show();
				$('#popoverData').popover();
				$('#customer_rules i').attr("data-content",data.company_rules);
				$('#customer_rules i').trigger('hover');
			}
            $('#country_final_destination').val(c_country);
            $('#payment_terms').val(data.payment_terms);
			 $('#remarks').val(data.note);
			if(data.container_weight == "" || data.container_weight == null)
			{
				$(".multiple_input").show();
				$(".multiple_select").hide();
			}
			else
			{
				$(".multiple_input").hide();
				$(".multiple_select").show();
				var containerweight = data.container_weight.split(",");
				var str = '<option value="">Select Limit</option>';
				for(var i=0;i<containerweight.length;i++)
				{
					str += '<option value="'+containerweight[i]+'">'+containerweight[i]+'</option>'
				}
				$('#limit_container1').html(str);
			}
            $('#port_of_discharge').val(port_of_discharge);
            $('#final_destination').val(port_of_discharge);
            
            $('#consigne_name').val(c_name);
			$('#invoice_currency_id').select2("val",data['currency_id']); 
			 if(data['bank_id'] != "" && data['bank_id'] != undefined)
			 {
				$('#bank_id').val(data['bank_id']);
				$('#bank_name').val(data['bank_name']);
				$('#bank_address').val(data['bank_address']);
				$('#account_name').val(data['account_name']);
				$('#account_no').val(data['account_no']);
				$('#ifsc_code').val(data['ifsc_code']);
				$('#swift_code').val(data['swift_code']);
				$('#bank_ad_code').val(data['bank_ad_code']);
				$('#iban_number').val(data['iban_number']);
				
             }
			 
			if(cdata != "" && cdata != undefined)
			 {
				 $("#consign_list").show();
                   $("#notify_id").html(cdata);
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
			$('#bank_name').val(obj1.bank_name);
            $('#bank_address').val(obj1.bank_address);
            $('#account_name').val(obj1.account_name);
            $('#account_no').val(obj1.account_no);
            $('#ifsc_code').val(obj1.ifsc_code);
            $('#swift_code').val(obj1.swift_code);
            $('#bank_ad_code').val(obj1.bank_ad_code);
 
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
		 
        $('#buyer_other_consign').val(obj1.notify_address);
        
 
         }
      })
 
}
$("#currency_add").submit(function(event) {
	event.preventDefault();
	if(!$("#currency_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'currency_list/manage',
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
				  $("#currency_add").trigger('reset');
				    $('#currencyadd').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#currency_id").append("<option value='"+obj.id+"' selected>"+obj.currency+"</option>");
					$("#currency_id").select2("val",obj.id);
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
 
if($mode=="Edit" && empty($invoicedata->consign_detail))
{
	echo "<script>load_consigner(".$invoicedata->consigne_id.")</script>";
	echo "<script>selectotherconsigner(".$invoicedata->notify_id.")</script>";
}
?>