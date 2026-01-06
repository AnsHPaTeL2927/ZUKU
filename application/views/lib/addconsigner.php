<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="form-group" >New Consigner/Customer</h4>
				
				<a href="<?php echo base_url('customer_detail/form'); ?>"  type="button" class="btn btn-info pull-right" style="margin-top:-15px;">
											New Customer With Details  
				</a>
				
			</div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="consigner_form" id="consigner_form">
				<div class="modal-body">
				<div class="row">
					 <div class="col-md-6">
						<div class="field-group">
							 
												<select class="form-control" name="customer_type" id="customer_type">
												<option value="1" >Export</option>
												<option value="2" >Merchant</option>
												</select>
											 
						</div>   
					</div> 
					 <div class="col-md-6">
						<div class="field-group">
							<input type="text" placeholder="Contact Person Name" id="cust_name"   class="form-control" name="cust_name" title="Enter Contact Person Name">
						</div>   
					</div> 
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Company Name" id="c_companyname"   class="form-control" name="c_companyname"  title="Enter Company Name" required >
						</div>                
				    </div> 
					<div class="col-md-6">
						<div class="field-group">
							<input type="text" placeholder="Customer Nick Name" id="c_nick_name"   class="form-control" name="c_nick_name" title="Enter Customer Name">
						</div>   
					</div>					
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Contact No"  id="c_contact" class="form-control" name="c_contact"   />
						</div>                
				    </div> 
						<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Email Address"  id="c_email_address" class="form-control" name="c_email_address" />
						</div>                
				    </div> 
					<!--<div class="col-md-6">					
						<div class="field-group">
							<select id="payment_recieve_type" name="payment_recieve_type" class="form-control" onchange="load_balance(this.value)"> 
								<option value="1">Bill To Bill</option>
								<option value="2">On Account</option>
							 </select>
						</div>                
				    </div>    
					<div class="col-md-3  opening_balance_html" style="display:none">					
						<div class="field-group">
							 <select id="payment_type" name="payment_type" class="form-control"> 
								<option value="1">Debit</option>
								<option value="2">Credit</option>
							 </select>
						</div>                
				    </div> 
					<div class="col-md-3  opening_balance_html" style="display:none">					
						<div class="field-group">
							<input type="number" placeholder="Opening Balance" id="opening_balance"   class="form-control" name="opening_balance"  >
						</div>                
				    </div>-->
					<div class="col-md-12"></div>	
					<div class="col-md-6">					
						<div class="field-group">
							<textarea placeholder="Address" id="c_address" class="form-control" name="c_address" title="Enter Address"></textarea>
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
								 	?>
									<option  value="<?=$countrydata[$c]->id?>"><?=$countrydata[$c]->c_name?></option>	
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
						 		<label id="currency_id-error" class="error" for="currency_id"></label>				 
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
							<input type="text" placeholder="Port Of Discharge"   id="custport_of_discharge" class="form-control" name="custport_of_discharge" title="Enter Post Of Discharge">
						</div>                
				    </div>   
					<div class="col-md-6">					
						<div class="field-group">
							<input type="text" placeholder="Web Address"  id="c_web_address" class="form-control" name="c_web_address" >
						</div>                
				    </div> 
					<div class="col-md-6">					
						<div class="field-group">
							<textarea placeholder="Payment terms" id="cust_payment_terms" class="form-control" name="cust_payment_terms" title="Enter Payment terms" style="height:50px;"></textarea>
						</div>                
				    </div>
				</div>
			 </div>
				<div class="modal-footer">
					<button name="Submit" type="submit" class="btn btn-success"> Save <img src="<?=base_url()?>adminast/assets/images/loader.gif" style="display:none;width:14px;" class="loader" /></button>   
					
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
        </div>
    </div>
</div>
<script>
 
 $(document).ready(function() {
	 
    $( "#cust_payment_terms" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Customer_detail/searchforconsigner",
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
            url: root + "Customer_detail/portsearchforconsigner",
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
</script>