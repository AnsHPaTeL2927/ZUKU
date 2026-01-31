<?php 
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
									<?=$mode?> Customer 
								</li>
								 
							</ol>
							<div class="page-header">
							<h3> <?=$mode?> Customer  
							
							<?php 
							 
							if(!isset($fd))
							{?>
								<div class="pull-right">
									<button type="button" class="btn btn-primary" onclick="import_excel()"> <i class="fa fa-upload"></i> Import Customer </button>
									<a href="<?php echo base_url('customer_detail/form'); ?>"  type="button" class="btn btn-info">
											+ Customer  
									</a>
								</div>
								
								<?php 
								}
								else if(!empty($fdv)){
									?>
									<div class="pull-right">
									
										 <a href="<?php echo base_url('add_design_detail/index/'.$fdv->id); ?>"  type="button" class="btn btn-info">
											Set Price
										</a>
										<a href="<?php echo base_url('add_customer_detail/index/'.$fdv->id); ?>"  type="button" class="btn btn-info">
											Additional Detail
										</a>
										 <a href="<?php echo base_url('add_design_detail/design_detail/'.$fdv->id); ?>"  type="button" class="btn btn-info">
											Set Design
										</a>
										
										<a href="<?php echo base_url('add_notify_detail/index/'.$fdv->id); ?>"  type="button" class="btn btn-info">
											Notify Party
										</a>
								</div>	
									<?php
								}?>
							</h3>
							</div>
						</div>
					</div>
					<?php 
					 
					if(isset($fd))
					{
						// If no customer data (New form or list), use defaults so form/modals don't error. Else show actual data.
						if (!isset($fdv) || !$fdv) {
							$fdv = new stdClass();
							$fdv->id = 0; $fdv->c_companyname = ''; $fdv->customer_type = 1; $fdv->payment_type = 'Credit';
							$fdv->auto_payment_remainder = 'Yes'; $fdv->rex_detail_status = '1'; $fdv->rex_no_detail = '';
							$fdv->c_address = $fdv->c_postcode = $fdv->c_city = $fdv->c_state = $fdv->c_country = '';
							$fdv->c_name = $fdv->c_nick_name = $fdv->shippment_days = $fdv->currency_id = '';
							$fdv->c_registration_detail = $fdv->c_contact = $fdv->c_email_address = $fdv->c_web_address = '';
							$fdv->port_of_discharge = $fdv->payment_terms = $fdv->credit_days = $fdv->credit_limit = '';
							$fdv->agent_id = $fdv->forwarer_id = '';
						}
						if (!isset($getcustdata) || !$getcustdata) {
							$getcustdata = new stdClass();
							$getcustdata->id = 0;
						}
						$inc_img_name="";
						$rex_no = !empty($company_detail[0]->rex_no)?$company_detail[0]->rex_no:"[Your REX No]";
						$rex_detail = "The exporter ".$rex_no." of the products Covered by this document declares that, except where otherwise clearly indicated, these products are of India preferential origin according to rules of origin of the Generalized System of Preferences of the European Union and that the origin criterion met is P.";
						if($fd == 'edit' && isset($fdv->id))
						{
						 $img_name = $this->encrypt->encode($fdv->id); 
						 $inc_img_name=str_replace(array('+', '/', '='), array('-', '_', '~'), $img_name);
						 $rex_detail = !empty($fdv->rex_no_detail)?$fdv->rex_no_detail:$rex_detail;
						} 
						 
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								</div>
								<div class="panel-body">
								<div class="col-md-8 col-md-offset-1">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="customer_form" id="customer_form">
									
										<input type="hidden" name="cust_id" id="cust_id" value="<?=$fdv->id?>"/>
										<input type="hidden" id="customer_invoice_id<?=$getcustdata->id?>"   name="customer_invoice_id" value="<?=$getcustdata->id?>">
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Customer Type 
											</label>
											<div class="col-sm-4">
												<select class="form-control" name="customer_type" id="customer_type">
												<option value="1" <?=($fdv->customer_type == 1)?"selected='selected'":""?>>Export</option>
												<option value="2" <?=($fdv->customer_type == 2)?"selected='selected'":""?>>Merchant</option>
												</select>
											</div>
										</div> 
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Company Name 
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Company Name" id="c_companyname"   class="form-control" name="c_companyname" value="<?php echo @$fdv->c_companyname; ?>"  title="Enter Company Name" required>
												
												<input type="hidden" id="edit_companyname" name="edit_companyname" value="<?=$fdv->c_companyname?>" >
											</div>
										</div>
									  
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Address
											</label>
											<div class="col-sm-4">
												<textarea id="c_address" name="c_address" placeholder="Address" class="form-control"   title="Enter Address"><?=strip_tags(@$fdv->c_address); ?></textarea>
												 
											</div>
										</div>
										  
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Postcode/Zipcode
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Postcode/Zipcode" id="c_postcode"   class="form-control" name="c_postcode" value="<?php echo @$fdv->c_postcode; ?>" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												City
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="City" id="c_city"    class="form-control" name="c_city" value="<?php echo @$fdv->c_city; ?>" title="Enter City">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												State
											</label>
											<div class="col-sm-4">
											 	<input type="text" placeholder="State" id="c_state"  class="form-control" name="c_state" value="<?php echo @$fdv->c_state; ?>" title="Enter State"  >	
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Country
											</label>
											<div class="col-sm-4">
											<select class="form-control" name="country_id" id="country_id"   title="Select Country" onchange="add_country_modal(this.value)">
												<option value="">Select Country</option>	
												<option value="0">Add New Country</option>	
												<?php
												for($c=0;$c<count($countrydata);$c++)
												{
													$select = '';
										
													if($countrydata[$c]->id==@$fdv->c_country)
													{
														$select = 'selected="selected"'; 
													}
													
												?>
												<option <?=$select?> value="<?=$countrydata[$c]->id?>"><?=$countrydata[$c]->c_name?></option>	
												<?php
												}
												?>
												</select>
												
											</div>
											<div style="margin-top: 4px;">
												<button type="button" class="btn btn-primary tooltips" data-title="Add Country" data-toggle="modal" data-target="#countryadd" data-keyboard="false" data-backdrop="static">+</button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Contact Person Name 
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Contact Person Name" id="c_name"   class="form-control" name="c_name" value="<?php echo @$fdv->c_name; ?>" title="Enter Customer Name">
											</div>
										</div> 
										
										 <div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Nick Name 
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Nick Name " id="c_nick_name"   class="form-control" name="c_nick_name" value="<?php echo @$fdv->c_nick_name; ?>" title="Enter Customer Nick Name">
											</div>
										</div> 
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Shippment Transit Days
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Shippment Transit Days"   id="shippment_days" class="form-control" name="shippment_days" value="<?php echo @$fdv->shippment_days; ?>" title="Enter Shippment Transit Days" onkeypress="return isNumber(event)">
												 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Currency 
											</label>
											<div class="col-sm-4">
											<select class="form-control" name="currency_id" id="currency_id" required title="Select Currency">
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
												<label id="currency_id-error" class="error" for="currency_id"> </label>
											</div>
											 
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Company Regestration No
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Company Regestration Details"  id="c_registration_detail" class="form-control" name="c_registration_detail" value="<?php echo @$fdv->c_registration_detail; ?>" title="Enter Company Registration">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Contact No 
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Contact No"  id="c_contact" class="form-control" name="c_contact" value="<?php echo @$fdv->c_contact; ?>" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Email Address
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Email Address"  id="c_email_address" class="form-control" name="c_email_address" value="<?php echo @$fdv->c_email_address; ?>" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Web Address
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Web Address"  id="c_web_address" class="form-control" name="c_web_address" value="<?php echo @$fdv->c_web_address; ?>" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Port Of Discharge
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Port Of Discharge"   id="custport_of_discharge" class="form-control" name="custport_of_discharge" value="<?php echo @$fdv->port_of_discharge; ?>" title="Enter Post Of Discharge">
												<div id="suggesstion-box"></div>
											</div>
										</div>
									
									<div class="form-group">
								
										 <label class="col-sm-3 control-label" for="form-field-1">
												Payment Terms
										</label>
										<div class="col-sm-4">
											<input type="text" id="payment_terms" name="payment_terms" class="form-control" placeholder="Payment Terms" value="<?php echo @$fdv->payment_terms; ?>" />
											<div id="suggesstion-box"></div>
											<!--To Show Error  -->											
											<label id="payment_terms-error" class="error" for="payment_terms"></label>
											<!--To Show Error  -->	
										</div>
									
									</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Payment
											</label>
											<div class="col-sm-4">
												 	<label>
														<input type="radio" name="payment_type" id="payment_type1" value="Credit"  <?=($fdv->payment_type == "Credit")?"checked":""?>  checked > 
												  		<strong for ="payment_type1"> Credit</strong>
											 		</label>
												   <label>
													 <input type="radio" name="payment_type" id="payment_type2" value="Advance"  <?=($fdv->payment_type == "Advance")?"checked":""?> > 
												  		<strong for ="payment_type2"> Advance</strong>
													</label>
													  <label>
														<input type="radio" name="payment_type" id="payment_type3" value="LC"  <?=($fdv->payment_type == "LC")?"checked":""?>  > 
												  		<strong for ="payment_type3"> LC</strong>
											 		</label>
													 <label>
														<input type="radio" name="payment_type" id="payment_type4" value="BL"  <?=($fdv->payment_type == "BL")?"checked":""?>  > 
												  		<strong for ="payment_type4"> BL</strong>
											 		</label>
											   
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Auto Payment Remainder 
											</label>
											<div class="col-sm-4">
												<label>
														<input type="radio" name="auto_payment_remainder" id="auto_payment_remainder1" value="Yes"  <?=($fdv->auto_payment_remainder == "Yes")?"checked":""?> checked onclick="hide_limit(this.value)" > 
												  		<strong for ="auto_payment_remainder1">Yes</strong>
											 		</label>
												   <label>
													 <input type="radio" name="auto_payment_remainder" id="auto_payment_remainder2" value="No"  <?=($fdv->auto_payment_remainder == "No")?"checked":""?> onclick="hide_limit(this.value)"> 
												  		<strong for ="auto_payment_remainder2">No</strong>
													</label>
												 
											</div>
										</div>
										<div class="limit_html">
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												  Days
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="  Days"   id="credit_days" class="form-control" name="credit_days" value="<?php echo @$fdv->credit_days; ?>" title="Enter Credit Days">
												 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												  Limit
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="  Limit"   id="credit_limit" class="form-control" name="credit_limit" value="<?php echo @$fdv->credit_limit; ?>" title="Enter Credit Limit">
												 
											</div>
										</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Rex Status
											</label>
											<div class="col-sm-4">
												 	<label>
														<input type="radio" name="rex_detail_status" id="rex_detail_status1" value="1"  <?=($fdv->rex_detail_status == "1")?"checked":""?>  checked onclick="show_detail(this.value)"> 
												  		<strong for ="rex_detail_status1"> Yes</strong>
											 		</label>
												   <label>
													 <input type="radio" name="rex_detail_status" id="rex_detail_status2" value="2"  <?=($fdv->rex_detail_status == "2")?"checked":""?> onclick="show_detail(this.value)" > 
												  		<strong for ="rex_detail_status2"> No</strong>
													</label>
													  
											   
											</div>
										</div>
										<div class="form-group rex-detail">
											<label class="col-sm-3 control-label" for="form-field-1">
												Rex Detail
											</label>
											<div class="col-sm-4">
												 	<textarea  style="hidden" class="form-control" name="rex_no_detail" id="rex_no_detail" Placeholder="Rex Detail"><?=$rex_detail?></textarea>
											   
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Agent Name
											</label>
											<div class="col-sm-4">
											<select class="form-control select2" name="agent_id" id="agent_id<?=$agentname->id?>"   title="Select Country" >
												<option value="">Select Agent</option>	
												<?php
												for($c=0;$c<count($agentname);$c++)
												{
													$select = '';
										
													if($agentname[$c]->id==@$fdv->agent_id)
													{
														$select = 'selected="selected"'; 
													}
													
												?>
												<option <?=$select?> value="<?=$agentname[$c]->id?>"><?=$agentname[$c]->agent_name?></option>	
												<?php
												}
												?>
												</select>
												
											</div>
											
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Select Forwarer 
											</label>
											<div class="col-sm-4">
												
												<select name="forwarer_id[]" multiple id="forwarer_id" class="select2" onchange="add_forwarer_modal(this.value)" data-placeholder="Select Forwarer">   
													 
													<?php 
													$forwarer_id_array = explode(",",$fdv->forwarer_id);
													foreach($forwarerdata as $category):?>                                              
														<?php $selected = in_array($category->id,$forwarer_id_array) ? " selected " : null;?>
														
															<option value="<?=$category->id?>"
																<?=$selected?> ><?=$category->c_name?>
															</option>                              
													<?php endforeach?>
												</select>    
												
												<label id="forwarer_id-error" class="error" for="forwarer_id"></label>
												
											</div>
											<div style="margin-top: 4px;">
												<button type="button" class="btn btn-primary tooltips" data-title="Add Forwarer" data-toggle="modal" data-target="#forwareradd" data-keyboard="false" data-backdrop="static">+</button>
											</div>
										</div>
										
										<div class="col-md-offset-3">
										<div class="form-group " style="" >
										<button type="submit" class="btn btn-success">
											Save
										</button>
										<button type="submit" class="btn btn-success" name="save_next_btn" value="1">
											Save & Next
										</button>
										 
										<a href="<?=base_url().'customer_detail/index'?>" class="btn btn-danger">
											Cancel
										</a>
										<?php
											if($fd == 'edit')
											{
											?>
												<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Consigner</button>-->
											<?php

											}
										?>
									</div>
									
									</div>
									
									<input type="hidden" name="mode" id="mode" value="2"/>
					</form>
								</div>
							</div>
						</div>
							<?php
							if($fd == 'edit')
								{
									 
								?>
						<!--	<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									List of Consigner
								</div>
								<div class="panel-body">
								<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Consigner Name</th>
													<th>Address</th>
													<th>City</th>
													<th>State</th>
													<th>Country</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											
											for($i=0; $i<count($consign_detail);$i++)
											{
												
											?>
												<tr>
													<td><?=$consign_detail[$i]->consiger_name; ?></td>
													<td><?=$consign_detail[$i]->address; ?></td>
													<td><?=$consign_detail[$i]->city; ?></td>
													<td><?=$consign_detail[$i]->state; ?></td>
													<td><?=$consign_detail[$i]->country_name; ?></td>
													<td>
													
														<p>
														<a class="btn btn-danger tooltips" data-title="Detele"  onclick="delete_record_consign(<?=$consign_detail[$i]->id?>)" href="javascript:;" ><i class="fa fa-trash"></i></a>
														 
														</p>
													</td>
												</tr>
										<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>-->
							<?php
								}
							?>
						</div>
					 
					<?php 
					} 
					else
					{
					?>
	                 <div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Customer List
								</div>
								<div class="panel-body">
									<div class="col-md-4">
										<label class="col-md-5 control-label" style="margin-top: 5px;">
											<strong class=""> Select Status</strong></label>
										 <div class="col-md-7">
										<select class="select2" name="status" id="status"   title="Select Consignee"  onchange="load_data_table();" >
											<option value="">All</option>
											<option value="1">Archive</option>
											<option value="2">Unarchive</option>
											</select>
										  </div>     
									</div>
									
								
									
									<div class="table-responsive" style="margin-top:100px;">
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
												 	<th>Customer Type</th>
												 	<th>Company</th>
												 	<th>Name</th>
												 	<th>Contact No</th>
													<th>Email</th>
													<th>Country</th>
													<th>Opening Balance</th>
													<th>Warehouse</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
<div id="myModal_opening_balance" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Opening Balance</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="opening_balance_form" id="opening_balance_form">
            <div class="modal-body">
               
               		<div class="field-group">
				        <input id="opening_balance" type="text" name="opening_balance" placeholder="Opening Balance" required="" class="form-control"/>
				    </div>   
				     <div class="field-group">
				       <select class="form-control" name="open_balance_status" id="open_balance_status" required title="Select Country">
							<option value="1">Credit</option>	
							<option value="2">Debit</option>	
						</select> 
				    </div> 

				    
				   <input type="hidden" id="customerid" name="customerid" class="form-control"  value=""/>
				                    
				
            </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Submit" class="btn btn-info"  />    
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>

<div id="create_warehouse_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 98%; max-width: 1400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Warehouse</h4>
            </div>
            <form action="javascript:;" method="post" name="create_warehouse_form" id="create_warehouse_form">
                <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
                    <input type="hidden" id="create_warehouse_customer_id" name="customer_id" value="" />
                    <div class="row" style="margin-bottom:6px;">
                        <div class="col-xs-3"><label class="control-label" style="font-size:12px;">Warehouse Number</label></div>
                        <div class="col-xs-3"><label class="control-label" style="font-size:12px;">Warehouse Country</label></div>
                        <div class="col-xs-3"><label class="control-label" style="font-size:12px;">Warehouse Name</label></div>
                        <div class="col-xs-2"><label class="control-label" style="font-size:12px;">Address</label></div>
                        <div class="col-xs-1"></div>
                    </div>
                    <div id="warehouse_rows">
                        <div class="warehouse-row panel panel-default" style="padding:6px 10px; margin-bottom:6px;">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <input type="text" name="warehouse_number[]" class="form-control input-sm" placeholder="Number" required />
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <select name="warehouse_country[]" class="form-control input-sm select2 warehouse_country" required title="Select Country">
                                            <option value="">Select Country</option>
                                            <?php
                                            $countrydata_list = (isset($countrydata) && is_array($countrydata)) ? $countrydata : array();
                                            foreach($countrydata_list as $c) {
                                                if(isset($c->id) && isset($c->c_name)) {
                                                    echo '<option value="'.(int)$c->id.'">'.htmlspecialchars($c->c_name).'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <input type="text" name="warehouse_name[]" class="form-control input-sm" placeholder="Name" required />
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <textarea name="warehouse_address[]" class="form-control input-sm warehouse-address" rows="2" placeholder="Address" required style="resize: vertical; min-height: 38px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-1 text-right">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-warehouse" onclick="remove_warehouse_row(this)" title="Remove warehouse" style="margin-top:0;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0; margin-top:4px;">
                        <button type="button" class="btn btn-default btn-sm" onclick="add_warehouse_row()" title="Add another warehouse">
                            <i class="fa fa-plus"></i> Add Warehouse
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Consigner</h4>
            </div>
			 <form class="form-horizontal askform" action="<?php echo base_url('consigner/manage'); ?>"  method="post" name="consigner_form" id="consigner_form">
            <div class="modal-body">
               
               		<div class="field-group">
				        <input id="port" type="text" name="port" placeholder="Port Name" required="" class="form-control"/>
				    </div>   
				    <div class="field-group">
 						<textarea id="address" name="address" placeholder="Address" class="form-control" required="" title="Enter Address"></textarea>
				    </div>                
				    <div class="field-group">
				       	
				        <input type="text" id="city" name="city" placeholder="City" required title="Enter City" class="form-control" required=""/>
				    </div>                     
				    <div class="field-group">
				        <input id="state" type="text" name="state" placeholder="Province / State" required="" class="form-control" title="Enter State"/>
				    </div>                
				    <div class="field-group">
				       <select class="select2" name="countryid" id="countryid" required title="Select Country">
							<option value="">Select Country</option>	
						 	<?php
								$countrydata_list = (isset($countrydata) && is_array($countrydata)) ? $countrydata : array();
								for($c=0;$c<count($countrydata_list);$c++)
								{
									$select = '';
									if(isset($countrydata_list[$c]->id) && $countrydata_list[$c]->id==@$fdv->c_country)
										$select = 'selected="selected"';
								?>
								<option <?=$select?> value="<?=$countrydata_list[$c]->id?>"><?=htmlspecialchars($countrydata_list[$c]->c_name)?></option>	
								<?php
								}
								?>
						</select> 
				    </div> 

				    <div class="field-group">
				        <input type="text" id="consiger_name" name="consiger_name" placeholder="Consigner Name" class="form-control" required title="Enter Consigner Name"/>    
				    </div> 
				   <input type="hidden" id="customer_id" name="customer_id" class="form-control"  value="<?php echo @$fdv->id; ?>"/>
				                    
				
            </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />    
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>

 <div id="excelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"   class="close" onclick="close_opoup()" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Order  </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="import_form" id="import_form">
			 
            <div class="modal-body">
                <div class="row">
					  
					<div class="col-md-12 product_html">					
					   <div class="field-group" >
								<div class="tab"> 
										<h4>Select File For Upload Data</h4>
										<input type="file" name="import_file" id="import_file" accept=".csv">
								</div>	
								
						</div> 
						 <div class="field-group" >
							<div class="tab"> 
										 <a href="<?=base_url().'upload/csv/sample_customer.csv'?>"  class="btn btn-primary"  target="_blank">Sample File Download</a>
								</div>	
						</div> 
					</div> 
				 	 <div class="col-md-12 error_html" >					
					    
					</div> 
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Import" id="import_submit_btn" class="btn btn-success"  /> 
                <button type="button"  class="btn btn-default" data-dismiss="modal" onClick="refreshPage()">Close</button>
            </div>
							
			</form>
       
    </div>
</div>
</div>

<div id="myModal2" class="modal fade myModal2" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cls_btn" data-dismiss="modal" onClick="refreshPage()">&times;</button>
                <h4 class="modal-title">  Bank Detail </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="add_bank_detail" id="add_bank_detail">
            <div class="modal-body">
               
               
				    <div class="field-group">
				        <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" required="" class="form-control" />
				    </div>                
				    
				    <div class="field-group">
				        <textarea id="bank_address" name="bank_address" placeholder="Bank Address" class="form-control"></textarea>
				    </div>                     
				     <div class="field-group">
				        <input id="account_name" type="text" name="account_name" placeholder="Account Name" required="" class="form-control" required title="Enter Account Name"/>
				    </div>   
				    <div class="field-group">
				        <input id="account_no" type="text" name="account_no" placeholder="Account No" required="" class="form-control" required title="Enter Account No"/>
				    </div>                
				    <div class="field-group">
				        <input type="text" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" class="form-control" />    
				    </div> 

				    <div class="field-group">
				        <input type="text" id="swift_code" name="swift_code" placeholder="Swift Code" class="form-control" />    
				    </div> 
				   <div class="field-group">
				        <input type="text" id="bank_ad_code" name="bank_ad_code" placeholder="Bank Ad Code No" class="form-control" />    
				    </div> 
					<div class="field-group">
				        <input type="text" id="iban_number" name="iban_number" placeholder="IBAN NO." class="form-control" />    
				    </div>
				
				
            </div>
			
            <div class="modal-footer">
			   <input name="Submit" type="submit" id="submit_btn" value="Add" class="btn btn-info"  />
                <button type="button" class="btn btn-default cls_btn" data-dismiss="modal" onclick="refreshPage()">Close</button>
            </div>
			
			<input type="hidden" name="eid2" id="eid2" />
			
			<input type="hidden" name="customerdetail" id="customerdetail" value="2"/>
			
			<input type="hidden" name="eid" id="eid" value="" />
			
			</form>
        </div>
    </div>
</div>


<div id="myModaluser" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign User <span><?= (isset($cust_data) && $cust_data && isset($cust_data->c_companyname) && $cust_data->c_companyname !== '') ? htmlspecialchars($cust_data->c_companyname) : 'No customer found' ?> </span> </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="assign_user_form" id="assign_user_form">
				<div class="modal-body">
				 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
						Assigned User 
					 	</label>
					 	<div class="col-sm-12">
					 		<div class="assign_customer_list"></div> 
					 	</div>
					</div>
					 <div class="form-group">
					 	<label class="col-sm-8 control-label" for="form-field-1">
							Select User
					 	</label>
						<label class="col-sm-4 pull-right" for="form-field-1">
								<input type="checkbox" name="all_cust_id" id="all_cust_id" onclick="select_all(this.checked)" value="1"/> <label for="all_cust_id">Select All </label>
					 	</label>
					 	<div class="col-sm-12">
					 		<select multiple name="user_id[]" id="user_id" class="select2">
								
							</select>
					 	</div>
					</div>
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="customer_id1" id="customer_id1" value="<?= (isset($cust_data) && $cust_data && isset($cust_data->id)) ? (int)$cust_data->id : 0 ?>" />
			 </form>
        </div>
    </div>
</div> 


<div id="myModaluser1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Designs <span><?= (isset($cust_data) && $cust_data && isset($cust_data->c_companyname) && $cust_data->c_companyname !== '') ? htmlspecialchars($cust_data->c_companyname) : 'No customer found' ?> </span> </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="assign_designs_form" id="assign_designs_form">
				<div class="modal-body">
				 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
						Assigned Designs 
					 	</label>
					 	<div class="col-sm-12">
					 		<div class="assign_designs_list"></div> 
					 	</div>
					</div>
					 <div class="form-group">
					 	<label class="col-sm-8 control-label" for="form-field-1">
							Select Designs
					 	</label>
						<label class="col-sm-4 pull-right" for="form-field-1">
								<input type="checkbox" name="all_design_id" id="all_design_id" onclick="select_all(this.checked)" value="1"/> <label for="all_design_id">Select All </label>
					 	</label>
					 	<div class="col-sm-12">
					 		<select multiple name="user_id1[]" id="user_id1" class="select2">
								
							</select>
					 	</div>
					</div>
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="designid1" id="designid1"  value="<?= (is_array($design_data) && isset($design_data[0]->packing_model_id)) ? (int)$design_data[0]->packing_model_id : (isset($design_data->packing_model_id) ? (int)$design_data->packing_model_id : 0) ?>" />
				<input type="hidden" name="customer_id1" id="customer_id1"  value="<?= (isset($cust_data) && $cust_data && isset($cust_data->id)) ? (int)$cust_data->id : 0 ?>" />

			 </form>
        </div>
    </div>
</div> 
<?php 
	$this->view('lib/footer'); 
	$this->view('lib/addcountry');
	$this->view('lib/addforwarer');
	$this->view('lib/addcurrency');
 ?>
<script>
// Safe block/unblock - use when block_page/unblock_page from footer may not be loaded (e.g. form page)
function safeBlock() {
	if(typeof block_page === 'function') { block_page(); }
	else if(typeof $.blockUI === 'function') {
		$.blockUI({ css: { border: 'none', padding: '0px', width: '17%', left:'43%', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff', zIndex: '10000' }, message: '<h3> Please wait...</h3>' });
	}
}
function safeUnblock(type, msg) {
	if(typeof unblock_page === 'function') { unblock_page(type, msg); }
	else {
		if(type !== "" && msg !== "" && typeof toastr !== 'undefined') { toastr[type](msg); }
		if(typeof $.unblockUI === 'function') { setTimeout(function(){ $.unblockUI(); }, 500); }
	}
}
function refreshPage(){
    window.location.reload();
} 
function select_all(value)
{
	 
	if(value== true)
	{
		$("#user_id").find('option').prop("selected",true);
        $("#user_id").trigger('change');
		$("#user_id1").find('option').prop("selected",true);
        $("#user_id1").trigger('change');
		 
	}
	else
	{
		 $("#user_id").find('option').prop("selected",false);
        $("#user_id").trigger('change');
		$("#user_id1").find('option').prop("selected",false);
        $("#user_id1").trigger('change');
	}
}

$("#add_bank_detail").submit(function(event) {
	event.preventDefault();
	if(!$("#add_bank_detail").valid())
	{
		return false;
	}
	 safeBlock();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'bank_detail/manage1',
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
				    $("#add_bank_detail").trigger('reset');
				    safeUnblock("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'customer_detail'; },1500);
				}
				else  if(obj.res==2)
			   {
				     safeUnblock("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'customer_detail'; },1500);
				}
				else  if(obj.res == 3)
				{
					safeUnblock("info","Record already exist");
				}
				
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
					 
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

 $(document).ready(function() {
	 
    $( "#payment_terms" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Customer_detail/search",
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
  
});

 $(document).ready(function() {
	 
    $( "#custport_of_discharge" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Customer_detail/search1",
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
  
});


function refreshPage(){
    window.location.reload();
} 

function show_detail(check)
{
	if(check == '1')
	{
		$(".rex-detail").show();
	}
	else
	{
		$(".rex-detail").hide();
	}
}
function hide_limit(value)
{
	  
	if(value == 'Yes' || $("#auto_payment_remainder1").prop('checked') == true)
	{
		$(".limit_html").show();
	}
	else
	{
		$(".limit_html").hide();
	}
}
function import_excel()
{
	$("#excelModal").modal({
		backdrop: 'static',
		keyboard: false
	});

}

$("#add_bank_detail").validate({
		rules: {
			bank_name: {
				required: true
			},
			account_name:{
				required: true
			},
			account_no:{
				required: true
			}
		},
		messages: {
			bank_name: {
				required: "Enter Bank Name"
			},
			account_name: {
				required: "Enter Account Name"
			},
			account_no: {
				required: "Enter Account No"
			}
		}
	});
	
$("#assign_user_form").validate({
		rules: {
			user_name: {
				required: true
			} 
		},
		messages: {
			user_name: {
				required: "Enter Name"
			} 
		}
	});
	
$("#assign_user_form").submit(function(event) {
	event.preventDefault();
	if(!$("#assign_user_form").valid())
	{
		return false;
	}
	 safeBlock();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'Customer_detail/assignmanage',
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
				    $("#assign_user_form").trigger('reset');
				    safeUnblock("success","Sucessfully Added.");
					assign_user(obj.customer_id)
				}
				else  if(obj.res==2)
			   {
				     safeUnblock("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'Customer_detail/index'; },1500);
				}
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'Customer_detail/index'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

$("#assign_designs_form").submit(function(event) {
	event.preventDefault();
	if(!$("#assign_designs_form").valid())
	{
		return false;
	}
	 safeBlock();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'Customer_detail/assignmanagedesign',
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
				    $("#assign_designs_form").trigger('reset');
				    safeUnblock("success","Sucessfully Added.");
					assign_designs(obj.customer_id)
				}
				else  if(obj.res==2)
			   {
				     safeUnblock("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'Customer_detail/index'; },1500);
				}
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'Customer_detail/index'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 

function assign_user(customer_id1)
{
	safeBlock();
     $.ajax({ 
              type: "POST", 
              url: root+"Customer_detail/fetchuser_data",
              data: {"customer_id1": customer_id1}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				     $("#myModaluser").modal({
						backdrop: 'static',
						keyboard: false
					});
					$(".select2").select2({
						width: '100%',
						placeholder:'Select User'
					});
				  $("#user_id").html(obj.cust_data);
				  $("#customer_id1").val(customer_id1);
				  $(".assign_customer_list").html(obj.assigncust);
				     
					safeUnblock("",""); 
                  }
              
          });
}


function assign_designs(designid1)
{
	safeBlock();
     $.ajax({ 
              type: "POST", 
              url: root+"Customer_detail/fetchudesign_data",
              data: {"designid1": designid1}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				     $("#myModaluser1").modal({
						backdrop: 'static',
						keyboard: false
					});
					$(".select2").select2({
						width: '100%',
						placeholder:'Select Designs'
					});
				  $("#user_id1").html(obj.design_data);
				  $("#designid1").val(designid1);
				  $(".assign_designs_list").html(obj.assigndesign);
				     
					safeUnblock("",""); 
                  }
              
          });
}

$("#import_form").validate({
		rules: {
			import_file: {
				required: true
			}
		},
		messages: {
			import_file: {
				required: "Select CSV File"
			} 
		}
	});
$("#import_form").submit(function(event) {
	event.preventDefault();
	if(!$("#import_form").valid())
	{
		return false;
	}
	 
	safeBlock();
	var postData= new FormData(this);
	var url = root+'customer_detail/import_customer';
	 
	$.ajax({
            type: "post",
            url: url,
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
				   safeUnblock("success","Sucessfully Imported.");
				   setTimeout(function(){ window.location=root+'customer_detail' },1000);
				 
			 	}
				else if(obj.res==2)
				{
					safeUnblock("error","Worng File. Coloum Doesn't Match");
		 		}
				else if(obj.res==3)
				{
					safeUnblock("error","Worng File. Coloum Name Doesn't Match");
		 		}
				else if(obj.res==4)
				{
					$(".product_html").hide();
					$(".error_html").show();
					$(".error_html").html(obj.error_html);
			 		safeUnblock("error","Some Record having error.");
		 		}
			 	else if(obj.res==0)
				{
					safeUnblock("error","File Not Upload.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function opening_balance_modal(val)
{
	$("#customerid").val(val)
	$("#myModal_opening_balance").modal('show')
}

function open_create_warehouse_modal(customer_id) {
	$("#create_warehouse_customer_id").val(customer_id);
	// Reset to single warehouse row (keep first, remove clones)
	$("#warehouse_rows .warehouse-row").not(":first").remove();
	$("#warehouse_rows .warehouse-row:first").find('input, textarea, select').val('');
	$("#create_warehouse_modal").modal('show');
	if ($(".select2").length) {
		$("#create_warehouse_modal .warehouse_country").select2({ width: '100%' });
	}
}

function add_warehouse_row() {
	var $first = $("#warehouse_rows .warehouse-row:first");
	var $clone = $first.clone();
	// Remove Select2-generated markup from clone so we don't get two country dropdowns
	$clone.find('.select2-container').remove();
	$clone.find('select.warehouse_country').removeClass('select2-hidden-accessible').removeAttr('aria-hidden tabindex').show().css({ width: '', visibility: '', position: '' });
	$clone.find('input, textarea').val('');
	$clone.find('select').val('');
	$clone.appendTo("#warehouse_rows");
	$clone.find('.warehouse_country').select2({ width: '100%' });
	update_warehouse_delete_buttons();
}
function remove_warehouse_row(btn) {
	var $row = $(btn).closest('.warehouse-row');
	if ($("#warehouse_rows .warehouse-row").length > 1) {
		$row.remove();
		update_warehouse_delete_buttons();
	}
}
function update_warehouse_delete_buttons() {
	var n = $("#warehouse_rows .warehouse-row").length;
	$("#warehouse_rows .btn-remove-warehouse").prop('disabled', n <= 1).css('opacity', n <= 1 ? 0.5 : 1);
}

function load_balance(val)
{
 	if(val == 2)
	{
		$(".opening_balance_html").show()
	}
	else
	{
		$(".opening_balance_html").hide()
	}
}


function archive_record(id,status)
{
	Swal.fire({
  title: 'Are You Sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
		 if (result.value) {
			safeBlock();
			  $.ajax({ 
              type: "POST", 
              url: root+'customer_detail/archive_record',
              data: {
                "id"	 : id,
				"status" : status
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					if(status == 0)
					{
						safeUnblock('success',"Customer successfully unarchived");
					}
					else
					{
						safeUnblock('success',"Customer successfully archived");
					}
					setTimeout(function(){ window.location=root+'customer_detail'; },1500);
				}
                else{
					safeUnblock('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
	 
}
function delete_record(id)
{
	 main_delete(id,'customer_detail/delete_record','customer_detail')
}
function delete_record_consign(id)
{
	 main_delete(id,'consigner/delete_record','customer_detail/form_edit/<?= isset($fdv) ? (int)$fdv->id : 0 ?>')
}
	load_data_table();
function load_data_table()
{ 	
	 
	datatable = $("#datatable").dataTable({
			"bAutoWidth" : false,
			"bFilter" : true,
			"bSort" : true,
			"aaSorting": [[0]],         
            "bProcessing": true,
			"searchDelay": 350,
			"bServerSide" : true,
			"bDestroy": true,
			"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "No customer created yet.",
					"sZeroRecords": "No customer created yet.",
					"sSearch": "",
					"sInfoFiltered":"",
					"sInfo":"",
			},
			"createdRow": function(row, data, dataIndex ) {
			var actionCol = data[9];
			if (typeof actionCol === 'string' && actionCol.indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
            
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root+'customer_detail/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "status", "value": $("#status").val() },{ "name": "companydata", "value": $("#companydata").val() } );
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});

		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}

$(".select2").select2({
		width:'100%'
	})
	
$(document).ready(function() {
	
	$("#customer_form").validate({
		rules: {
			c_email_address: {
				 email:true
			},
			c_name: {
				required: true
			}
		},
		messages: {
			c_email_address: {
				 email:"Email Id Not Vaild" 
			},
			c_name :{
				required: "Enter Person Name"
			}
		}
	});
		$("#consigner_form").validate({
		rules: {
			port: {
				required: true
			}
		},
		messages: {
			port: {
				required: "Enter Port"
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
	
	$("#supplier_name").validate({
		rules: {
			c_name: {
				required: true
			}
		},
		messages: {
			c_name: {
				required: "Enter Forwarer Name"
			}
		}
	});
$("#currency_add").validate({
		rules: {
			currency: {
				required: true
			}
		},
		messages: {
			currency: {
				required: "Enter Currency"
			}
		}
	});

});
 $("#country_id").select2({
	width:'100%',
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

$("#forwarer_id").select2({
	width:'100%',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_forwarer_modal(0)'>Add New Forwarer</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 	
});
function add_forwarer_modal(val)
{
	 
	if(val==0)
	{
		$("#forwareradd").modal('show');
	}
	
}

 $("#opening_balance_form").validate({
		rules: {
			opening_balance: {
				 required:true
			} 
		},
		messages: {
			opening_balance: {
				 required:"Enter Opening Balance" 
			} 
		}
	});

$("#customer_form").submit(function(event) {
	event.preventDefault();
	if(!$("#customer_form").valid())
	{
		return false;
	}
	 safeBlock();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'customer_detail/manage';
	$.ajax({
            type: "post",
            url: url,
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
				   safeUnblock("success","Sucessfully saved.");
				   var val = $(document.activeElement).val();
				   if(val == "1")
				   {
					  setTimeout(function(){ window.location=root+"add_design_detail/index/"+obj.id},1500);
				   }
				   else
				   {
						setTimeout(function(){ window.location = root+"customer_detail/form_edit/"+obj.id },1500);
				   }
				
				}
				else if(obj.res==2)
				{
				    safeUnblock("success","Sucessfully Updated.");
					var val = $(document.activeElement).val();
					if(val == "1")
					{
						setTimeout(function(){ window.location=root+"add_design_detail/index/"+obj.id},1500);
				 	}
					else
					{
						setTimeout(function(){ location.reload(); },1500);
					}
					
				}
				else if(obj.res==3)
				{
					safeUnblock("info","Record already exist");
									    
				}
				else
				{
					safeUnblock("error","Something Wrong.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});	
	
// $("#customer_form").submit(function(event) {
	// event.preventDefault();
	// if(!$("#customer_form").valid())
	// {
		// return false;
	// }
	 
	// safeBlock();
	// var postData= new FormData(this);
	 // postData.append("mode","add");
	// $.ajax({
            // type: "post",
            // url: 	root+'customer_detail/manage',
            // data: postData,
			// processData: false,
			// contentType: false,
			// cache: false,
            // success: function(responseData) {
               // console.log(responseData);
			    // var obj= JSON.parse(responseData);
				// $(".loader").hide();
				// if(obj.res==1)
				// {
					
						// safeUnblock("success","Sucessfully Added.");
						// setTimeout(function(){ window.location=root+'Customer_detail'; },1500);
					
				// }
				// else if(obj.res==2)
				// {
					// $("#c_companyname").focus();
					// safeUnblock("error","Company Name already exist");
					// //$("#help_form").trigger('reset');
					
				// }
				// else
				// {
					// safeUnblock("error","Something Wrong.") 
				// }
            // },
            // error: function(jqXHR, textStatus, errorThrown) {
                // console.log(errorThrown);
            // }
	// });
// });

$("#opening_balance_form").submit(function(event) {
	event.preventDefault();
	if(!$("#opening_balance_form").valid())
	{
		return false;
	}
	 
	safeBlock();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'customer_detail/opening_balance_manage',
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
				   
					safeUnblock("success","Sucessfully Updated.");
					 setTimeout(function(){ location.reload() },1500);
				 
			   }
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

$("#create_warehouse_form").submit(function(event) {
	event.preventDefault();
	if (!$("#create_warehouse_form")[0].checkValidity()) {
		$("#create_warehouse_form")[0].reportValidity();
		return false;
	}
	safeBlock();
	var postData = new FormData(this);
	$.ajax({
		type: "post",
		url: root + 'customer_detail/save_warehouses',
		data: postData,
		processData: false,
		contentType: false,
		cache: false,
		success: function(responseData) {
			try {
				var obj = typeof responseData === 'string' ? JSON.parse(responseData) : responseData;
				if (obj.res == 1) {
					safeUnblock("success", "Warehouse(s) saved successfully.");
					$("#create_warehouse_modal").modal('hide');
					setTimeout(function(){ location.reload(); }, 1500);
				} else {
					safeUnblock("error", obj.msg || "Something went wrong.");
				}
			} catch (e) {
				safeUnblock("error", "Invalid response.");
			}
		},
		error: function() {
			safeUnblock("error", "Request failed. Implement customer_detail/save_warehouses in controller.");
		}
	});
});

$("#country_add").submit(function(event) {
	event.preventDefault();
	if(!$("#country_add").valid())
	{
		return false;
	}
	 
	safeBlock();
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
					$('#forwareradd').modal("hide")
					safeUnblock("success","Sucessfully Inserted.");
				    $("#country_id").append("<option value='"+obj.id+"' selected>"+obj.cname+"</option>");
					$("#country_id").val(obj.id)
				 
			   }
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

$("#supplier_name").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_name").valid())
	{
		return false;
	}
	 
	safeBlock();
	var postData= new FormData(this);
	postData.append("mode","add");
 
	$.ajax({
            type: "post",
            url: 	root+'Add_forwarer/manage',
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
				   $("#supplier_name").trigger('reset');
				    $('#countryadd').modal("hide") 
					$('#forwareradd').modal("hide")
					safeUnblock("success","Sucessfully Inserted.");
				    $("#forwarer_id").append("<option value='"+obj.id+"' selected>"+obj.c_name+"</option>");
					//$("#forwarer_id").val(obj.id)
				 
			   }
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

$("#currency_add").submit(function(event) {
	event.preventDefault();
	if(!$("#currency_add").valid())
	{
		return false;
	}
	 
	safeBlock();
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
					safeUnblock("success","Sucessfully Inserted.");
				    $("#currency_id").append("<option value='"+obj.id+"' selected>"+obj.currency+"</option>");
					$("#currency_id").select2("val",obj.id);
				}
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function reamove_assign_user(deleleid,customer_id1)
{
	safeBlock();
     $.ajax({ 
              type: "POST", 
              url: root+"Customer_detail/remove_user_record",
              data: {"id": deleleid}, 
              success: function (response) { 
                   
					var obj= JSON.parse(response);
						$(".loader").hide();
						if(obj.res==1)
						{
							$("#assign_user_form").trigger('reset');
							safeUnblock("success","Sucessfully Removed.");
							assign_user(customer_id1)
						}
					 	else
						{
							safeUnblock("error","Something Wrong.") 
						}
					safeUnblock("",""); 
                  }
              
          });
	 
} 

function bank_data(id,bank_id)
{
	if(bank_id == 0)
	{
		$("#myModal2").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(bank_id);
					$("#eid2").val(id);
	}
	else
	{
		 
	 safeBlock();
     $.ajax({ 
              type: "POST", 
              url: root+"bank_detail/form_edit1",
              data: {"id": bank_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
					$("#myModal2").modal({
						backdrop: 'static',
						keyboard: false
					});
						$("#eid").val(bank_id);
						 
						$("#submit_btn").val("Update");
						$("#bank_name").val(obj.bank_name);
						$("#bank_address").val(obj.bank_address);
						$("#account_name").val(obj.account_name);
						$("#account_no").val(obj.account_no);
						$("#ifsc_code").val(obj.ifsc_code);
						$("#swift_code").val(obj.swift_code);
						$("#bank_ad_code").val(obj.bank_ad_code);
						$("#iban_number").val(obj.iban_number);
						$("#eid2").val(id);
					safeUnblock("",""); 
                  }
              
          }); 
	}
}

</script>
<?php
if($mode == "Edit" && isset($fdv) && $fdv)
{
	echo "<script>hide_limit('".(isset($fdv->auto_payment_remainder) ? $fdv->auto_payment_remainder : '')."')</script>";
	echo "<script>show_detail('".(isset($fdv->rex_detail_status) ? $fdv->rex_detail_status : '')."')</script>";
}
?>
