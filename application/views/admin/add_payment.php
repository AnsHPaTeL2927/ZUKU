<?php 
$this->view('lib/header');
 
if(end(explode("/",$_SERVER['HTTP_REFERER'])) != "dashboard_payment")
{
	$_SESSION['add_payment_consiger_id'] = "";
	$_SESSION['add_export_invoice_id'] 	 = "";
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
									<a href="<?=base_url().'payment_list'?>">Payment List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> Payment </h3>
							</div>
							 
						</div>
					</div>
						<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="payment_form" id="payment_form">
               		<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Received Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date" id="date" class="form-control defualt-date-picker" autocomplete="off" value="<?=date('d-m-Y')?>" placeholder="Select Date" required title="Select Date"/>
				        </div>
				    </div> 	
						<div class="form-group ">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Payment Mode
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="payment_mode_id" id="payment_mode_id" required title="Select Payment Mode"  >
								<option value="">Select Payment Mode</option>
								<?php 
									for($i=0; $i<count($payment_mode_list);$i++)
									{
										$sel = '';
										if($payment_mode_list[$i]->payment_mode_id == 1)
										{
											$sel = 'selected="selected"';
										}
									?>
										<option <?=$sel?>  value="<?=$payment_mode_list[$i]->payment_mode_id?>"><?=$payment_mode_list[$i]->payment_mode?></option>
									<?php
									}
									?>	 
							</select>
							<label id="payment_mode_id-error" class="error" for="payment_mode_id"></label>
				        </div>
				    </div>	
						
					 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Customer
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="customer_id" id="customer_id" required title="Select Customer" onchange="load_customer_bill(this.value,0)">
								<option value="">Select Customer</option>
									<?php 
									for($i=0; $i<count($customer_list);$i++)
									{
										$sel = '';
										if($_SESSION['add_payment_consiger_id'] == $customer_list[$i]->id)
										{
											$sel = 'selected="selected"';
										}
									?>
										<option <?=$sel?> value="<?=$customer_list[$i]->id?>"><?=$customer_list[$i]->c_companyname?></option>
									<?php
									}
									?>
							</select>
							<label id="customer_id-error" class="error" for="customer_id"></label>
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Payment Recieve
						</label>
						<div class="col-sm-4">
							 <select id="payment_recieve_type" name="payment_recieve_type" class="form-control" onchange="load_due_bill(this.value,0)" > 
								<option value="1">Bill To Bill</option>
								<option value="2">On Account</option>
							 </select>
				        </div>
				    </div> 	
					<div class="form-group export_bill_html">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Export Bill 
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="bill_id[]" id="bill_id" required title="Select Export Bill" onchange="load_exchange_rate();load_bill_detail()"  multiple data-placeholder="Select Export Bill">
								 
							</select>
							<label id="bill_id-error" class="error" for="bill_id"> </label>
				        </div>
						<div class="col-sm-6 export_bill_due_html">
				         
						</div> 
				    </div> 	
						
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Bank 
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="bank_id" id="bank_id" required title="Select Bank">
								<option value="">Select Bank</option>
									<?php 
									for($i=0; $i<count($bank_list);$i++)
									{
									?>
										<option value="<?=$bank_list[$i]->id?>"><?=$bank_list[$i]->bank_name?></option>
									<?php
									}
									?>
							</select>
							<label id="bank_id-error" class="error" for="bank_id"></label>
				        </div>
				    </div> 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								FIRC No
						</label>
						<div class="col-sm-4">
							 <input type="text" name="refernace_no" id="refernace_no" class="form-control" placeholder="FIRC No"   title="Enter Referance No"/>
				        </div>
				    </div>
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								FIRC Recieve Amount
						</label>
						<div class="col-sm-4">
							 <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="FIRC Recieve Amount" required title="Enter Paid Amount" onkeyup="calc_bank_charge()" onblur="calc_bank_charge()" onchange="calc_bank_charge()"/>
				        </div>
				    </div>
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Exchange Rate
						</label>
						<div class="col-sm-4">
							 <input type="text" name="exchange_rate" id="exchange_rate" class="form-control"  placeholder="Exchange Rate" onkeyup="calc_inr_value()" onblur="calc_inr_value()" onchange="calc_inr_value()" />
				        </div>
				    </div> 					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 INR Value of Payment Received 
						</label>
						<div class="col-sm-4">
							 <input type="text" name="inr_value" id="inr_value" class="form-control"  placeholder="INR Value of Payment Received" readonly />
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								FIRC Recieve File
						</label>
						<div class="col-sm-4">
							 <input type="file" name="payment_file" id="payment_file" class="form-control" title="Enter Referance No"/>
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Swift Payment Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="swift_date" id="swift_date" class="form-control defualt-date-picker" autocomplete="off" value="<?=date('d-m-Y')?>" placeholder="Select Swift Payment Date"   title="Select Date"/>
				        </div>
				    </div> 	
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Swift Amount
						</label>
						<div class="col-sm-4">
							 <input type="text" name="swift_amount" id="swift_amount" class="form-control" placeholder="Swift Amount" required title="Enter Paid Amount" onkeyup="calc_bank_charge()" onblur="calc_bank_charge()" onchange="calc_bank_charge()"/>
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Swift File
						</label>
						<div class="col-sm-4">
							 <input type="file" name="swift_file" id="swift_file" class="form-control" title="Enter Swift File"/>
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Bank Charge
						</label>
						<div class="col-sm-4">
							 <input type="text" name="bank_charge" id="bank_charge" class="form-control"  placeholder="Bank Charge" readonly />
				        </div>
				    </div>	
					 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Bank Charge INR
						</label>
						<div class="col-sm-4">
							 <input type="text" name="inr_bank_value" id="inr_bank_value" class="form-control"  placeholder="Bank Charge INR"   />
				        </div>
				    </div>					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 CGST  
						</label>
						<div class="col-sm-2">
							 <input type="text" name="cgst_per" id="cgst_per" class="form-control"  placeholder="CGST(%)" onkeyup="calc_gst_value()" onblur="calc_gst_value()" onchange="calc_gst_value()" />
				        </div>
						<div class="col-sm-2">
							 <input type="text" name="cgst_value" id="cgst_value" class="form-control"  placeholder="CGST(INR)" readonly />
				        </div>
				    </div> 	
						<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								SGST 
						</label>
						<div class="col-sm-2">
							 <input type="text" name="sgst_per" id="sgst_per" class="form-control"  placeholder="SGST(%)" onkeyup="calc_gst_value()" onblur="calc_gst_value()" onchange="calc_gst_value()"   />
				        </div>
						<div class="col-sm-2">
							 <input type="text" name="sgst_value" id="sgst_value" class="form-control"  placeholder="SGST(INR)" readonly />
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								IGST 
						</label>
						<div class="col-sm-2">
							 <input type="text" name="igst_per" id="igst_per" class="form-control"  placeholder="IGST(%)" onkeyup="calc_gst_value()" onblur="calc_gst_value()" onchange="calc_gst_value()"   />
				        </div>
						<div class="col-sm-2">
							 <input type="text" name="igst_value" id="igst_value" class="form-control"  placeholder="SGST(INR)" readonly />
				        </div>
				    </div> 	
				<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Total GST
						</label>
						<div class="col-sm-2">
							 <input type="text" name="total_gst" id="total_gst" class="form-control"  placeholder="Total GST" readonly />
				        </div>
						 
				    </div> 					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks" ></textarea>
				        </div>
				    </div> 
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success" />
								<a href="<?=base_url().'payment_list'?>" class="btn btn-danger">
												Cancel
											</a>						
						</div>    	
				</div> 	
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />				
				</form>
					</div>
		 	</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>
function calc_bank_charge()
{
	var paid_amount  = ($("#paid_amount").val() > 0)?$("#paid_amount").val():0;
	var swift_amount = ($("#swift_amount").val() > 0)?$("#swift_amount").val():0;
	if(paid_amount > 0 && swift_amount > 0)
	{
		var bank_charge = parseFloat(swift_amount) - parseFloat(paid_amount);
		$("#bank_charge").val(parseFloat(bank_charge).toFixed(2));
	}	
	calc_inr_value();
}
function calc_inr_value()
{
	var paid_amount  = ($("#paid_amount").val() > 0)?$("#paid_amount").val():0;
	var exchange_rate = ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
	if(paid_amount > 0 && exchange_rate > 0)
	{
		var inr_charge = parseFloat(exchange_rate) * parseFloat(paid_amount);
		$("#inr_value").val(parseFloat(inr_charge).toFixed(2));
	}
	 
}
function calc_gst_value()
{
	var inr_bank_value = ($("#inr_bank_value").val() > 0)?$("#inr_bank_value").val():0;
	var cgst_per = ($("#cgst_per").val() > 0)?$("#cgst_per").val():0;
	var sgst_per = ($("#sgst_per").val() > 0)?$("#sgst_per").val():0;
	var igst_per = ($("#igst_per").val() > 0)?$("#igst_per").val():0;
	var total_gst = 0;
	if(cgst_per > 0)
	{
		var cgst_value = parseFloat(inr_bank_value) * parseFloat(cgst_per)/ 100;
		$("#cgst_value").val(parseFloat(cgst_value).toFixed(2));
		total_gst +=  cgst_value;
	}
	if(sgst_per > 0)
	{
		var sgst_value = parseFloat(inr_bank_value) * parseFloat(sgst_per)/ 100;
		$("#sgst_value").val(parseFloat(sgst_value).toFixed(2));
		total_gst +=  sgst_value;
	}
	if(igst_per > 0)
	{
		var igst_value = parseFloat(inr_bank_value) * parseFloat(igst_per) / 100;
		$("#igst_value").val(parseFloat(igst_value).toFixed(2));
		total_gst +=  igst_value;
	}
	$("#total_gst").val(parseFloat(total_gst).toFixed(2));
}

 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
  
$(".select2").select2({
	width:'100%' 
})
$("#payment_form").validate({
		rules: {
			customer_id: {
				required: true
			},
			paid_amount:{
				required: true
			}
		},
		messages: {
			customer_id: {
				required: "Select Customer"
			},
			paid_amount:{
				required: "Enter Paid Amount",
				max:"Please check due amount"
			} 
		}
	});
$("#payment_form").submit(function(event) {
	event.preventDefault();
	if(!$("#payment_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'add_payment/manage',
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
				    $("#payment_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'payment_list'; },1500);
			   }
			   else if(obj.res==2)
			   {
				    unblock_page("error","Amount is more than Selected Bill Amount.") 
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
 
function load_due_bill(val)
{
	if(val == 1)
	{
		$(".export_bill_html").show()
	}
	else{
		$(".export_bill_html").hide()
	}
}
function load_customer_bill(value,bill_id)
{
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"add_payment/fetchdata",
           data: {
					"id": value,
					"payment_recieve_type" : $("#payment_recieve_type").val()
				 }, 
           success: function (response) { 
				var obj= JSON.parse(response);
			 	if(obj.payment_recieve_type == "1")
				{
				  $(".export_bill_html").show()
				  $("#bill_id").html(obj.str);
				if(bill_id > 0)
				  {
					$("#bill_id").val(bill_id).trigger('change');
				  }
			 	}
				else
				{
					$(".export_bill_html").hide();
					 
				}
				 	unblock_page("",""); 
		}
     }); 
}
function load_exchange_rate()
{
	block_page();
  $.ajax({ 
           type: "POST", 
           url: root+"add_payment/fetchexchnage_rate",
           data: { "bill_id": $("#bill_id").val()   }, 
           success: function (response) { 
				var obj= JSON.parse(response);
			 	if(obj.Exchange_Rate_val > 0)
				{
				  $("#exchange_rate").val(obj.Exchange_Rate_val)
			 	}
				else
				{
					$("#exchange_rate").val(0)
				}
				 
				 	unblock_page("",""); 
		}
     }); 
}
function load_bill_detail()
{
	block_page();
  $.ajax({ 
           type: "POST", 
           url: root+"add_payment/load_bill_detail",
           data: { 
					"bill_id"		: $("#bill_id").val(),  
					"customer_id"	: $("#customer_id").val()  
				}, 
           success: function (response) { 
					$(".export_bill_due_html").html(response)
				 	unblock_page("",""); 
		}
     }); 
}
function load_bill(value)
{
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"add_payment/getdueamount",
           data: {"id": value}, 
           success: function (response) { 
				//console.log(response)
                
                $("#paid_amount").attr("max",response)
			 	 	unblock_page("",""); 
		}
     }); 
}
</script>
<?php 
if(!empty($_SESSION['add_export_invoice_id']))
{
	echo "<script>load_customer_bill(".$_SESSION['add_payment_consiger_id'].",".$_SESSION['add_export_invoice_id'].")</script>";
}
?>

  