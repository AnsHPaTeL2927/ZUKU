<?php 
$this->view('lib/header'); 
if(!empty($expense_data))
{
	$expense_date = date('d-m-Y',strtotime($expense_data->expense_date));
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
									<a href="<?=base_url().'expense_list'?>">Expense List</a>
								</li>
							 </ol>
							<div class="page-header">
							<h3><?=$mode?> Expense </h3>
							</div>
							 
						</div>
					</div>
						<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="expense_form" id="expense_form">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
										 Expense Date
								</label>
								<div class="col-sm-4">
									<input type="text" name="expense_date" id="expense_date" class="form-control defualt-date-picker" autocomplete="off" value="<?=$expense_date?>" placeholder="Select Date" required title="Select Expense Date"  />
								</div>
							</div> 
							 	
							<div class="form-group export_bill_html" >
								<label class="col-sm-2 control-label" for="form-field-1">
										 Export Invoice
								</label>
								<div class="col-sm-4">
									<select class="select2" name="export_invoice_id" id="export_invoice_id" required title="Select Export Invoice" >
										<option value="">Select Export Invoice</option>
											<?php 
											for($i=0; $i<count($export_data);$i++)
											{
												$sel = '';
												if($export_data[$i]->export_invoice_id == $expense_data->export_invoice_id)
												{
													$sel = 'selected = "selected"';
												}
											?>
												<option <?=$sel?> value="<?=$export_data[$i]->export_invoice_id?>"><?=$export_data[$i]->export_invoice_no?></option>
											<?php
											}
											?>
									</select>
									<label id="export_invoice_id-error" class="error" for="export_invoice_id"></label>
						 	</div>
						</div> 					
					<!--	<div class="form-group ">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Payment Mode
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="payment_mode_id" id="payment_mode_id" required title="Select Payment Mode"  >
								<option value="">Select Payment Mode</option>
								<?php 
									for($i=0; $i<count($payment_mode_list);$i++)
									{
										$sel = '';
												if($payment_mode_list[$i]->payment_mode_id == $expense_data->payment_mode_id)
												{
													$sel = 'selected = "selected"';
												}
									?>
										<option <?=$sel?>  value="<?=$payment_mode_list[$i]->payment_mode_id?>"><?=$payment_mode_list[$i]->payment_mode?></option>
									<?php
									}
									?>	 
							</select>
							<label id="payment_mode_id-error" class="error" for="payment_mode_id"></label>
				        </div>
				    </div>	-->
						
					 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Expense Category
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="expense_category_id" id="expense_category_id" required title="Select Expense Category" onchange="load_expense_party(this.value,'')">
								<option value="">Select Expense Category</option>
									<?php 
									for($i=0; $i<count($expense_category);$i++)
									{
										$sel = '';
												if($expense_category[$i]->expense_category_id == $expense_data->expense_category_id)
												{
													$sel = 'selected = "selected"';
												}
									?>
										<option <?=$sel?> value="<?=$expense_category[$i]->expense_category_id?>"><?=$expense_category[$i]->expense_category_name?></option>
									<?php
									}
									?>
							</select>
							<label id="expense_category_id-error" class="error" for="expense_category_id"></label> 
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Expense Party
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="expense_party_id" id="expense_party_id" required title="Select Expense Party" >
								<option value="">Select Expense Party</option>
						 	</select>
							<label id="expense_party_id-error" class="error" for="expense_party_id"></label> 
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Referance No
						</label>
						<div class="col-sm-4">
							 <input type="text" name="refernace_no" id="refernace_no" class="form-control" placeholder="Referance No"   title="Enter Referance No" value="<?=$expense_data->reference_no?>" required />
				        </div>
				    </div>	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select File
						</label>
						<div class="col-sm-4">
							 <input type="file" name="expense_payment_file" id="expense_payment_file" class="form-control" title="Enter File"/>
				        </div>
						<?php 
						if(!empty($expense_data->expense_payment_file))
						{
							echo  ' <a class="btn btn-info"  href="'.base_url().'upload/payment/'.$expense_data->expense_payment_file.'" target="_blank"><i class="fa fa-eye"></i></a> ';
						}
						?>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Expense Amount
						</label>
						<div class="col-sm-4">
							 <input type="text" name="expense_amount" id="expense_amount" class="form-control" placeholder="Expense Amount" required title="Enter Expense Amount" value="<?=$expense_data->amount?>" onkeyup="calc_gst_value()" onblur="calc_gst_value()" onchange="calc_gst_value()"/>
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 CGST  
						</label>
						<div class="col-sm-2">
							 <input type="text" name="cgst_per" id="cgst_per" class="form-control"  placeholder="CGST(%)" onkeyup="calc_gst_value()" onblur="calc_gst_value()" onchange="calc_gst_value()" value="<?=$expense_data->cgst_per?>" />
				        </div>
						<div class="col-sm-2">
							 <input type="text" name="cgst_value" id="cgst_value" class="form-control"  placeholder="CGST(INR)"  onkeyup="calcgst_value()" onblur="calcgst_value()" onchange="calcgst_value()"   value="<?=$expense_data->cgst_value?>"/>
				        </div>
				    </div> 	
						<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								SGST 
						</label>
						<div class="col-sm-2">
							 <input type="text" name="sgst_per" id="sgst_per" class="form-control"  placeholder="SGST(%)" onkeyup="calc_gst_value()" onblur="calc_gst_value()" onchange="calc_gst_value()"  value="<?=$expense_data->sgst_per?>" />
				        </div>
						<div class="col-sm-2">
							 <input type="text" name="sgst_value" id="sgst_value" class="form-control"  placeholder="SGST(INR)" onkeyup="calcgst_value()" onblur="calcgst_value()" onchange="calcgst_value()"   value="<?=$expense_data->sgst_value?>" />
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								IGST 
						</label>
						<div class="col-sm-2">
							 <input type="text" name="igst_per" id="igst_per" class="form-control"  placeholder="IGST(%)" onkeyup="calc_gst_value()" onblur="calc_gst_value()" onchange="calc_gst_value()" value="<?=$expense_data->igst_per?>"  />
				        </div>
						<div class="col-sm-2">
							 <input type="text" name="igst_value" id="igst_value" class="form-control"  placeholder="IGST(INR)"  onkeyup="calcgst_value()" onblur="calcgst_value()" onchange="calcgst_value()"   value="<?=$expense_data->igst_value?>" />
				        </div>
				    </div> 	
			  		<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Total GST
						</label>
						<div class="col-sm-2">
							 <input type="text" name="total_gst" id="total_gst" class="form-control"  placeholder="Total GST" readonly value="<?=$expense_data->total_gst?>" />
				        </div>
						 
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Total Amount
						</label>
						<div class="col-sm-2">
							 <input type="text" name="total_amt" id="total_amt" class="form-control"  placeholder="Total Amount" readonly value="<?=$expense_data->total_amt?>" />
				        </div>
						 
				    </div> 						
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks"><?=strip_tags($expense_data->remarks)?></textarea>
				        </div>
				    </div> 
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success" />
								<a href="<?=base_url().'expense_list'?>" class="btn btn-danger">
												Cancel
											</a>						
						</div>    	
				</div> 	
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />				
				 	<input type="hidden" id="expense_id" name="expense_id" value="<?=$expense_data->expense_id?>"  />				
				</form>
					</div>
		 	</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>

function load_due_bill(val)
{
	if(val == 1)
	{
		$(".export_bill_html").show()
	}
	else{
		$(".export_bill_html").hide();
		$("#export_invoice_id").val('').trigger('change')
	}
}
function calc_gst_value()
{
	var expense_amount = ($("#expense_amount").val() > 0)?$("#expense_amount").val():0;
	var cgst_per = ($("#cgst_per").val() > 0)?$("#cgst_per").val():0;
	var sgst_per = ($("#sgst_per").val() > 0)?$("#sgst_per").val():0;
	var igst_per = ($("#igst_per").val() > 0)?$("#igst_per").val():0;
	var total_gst = 0;
	if(cgst_per > 0)
	{
		var cgst_value = parseFloat(expense_amount) * parseFloat(cgst_per)/ 100;
		$("#cgst_value").val(parseFloat(cgst_value).toFixed(2));
		total_gst +=  cgst_value;
	}
	if(sgst_per > 0)
	{
		var sgst_value = parseFloat(expense_amount) * parseFloat(sgst_per)/ 100;
		$("#sgst_value").val(parseFloat(sgst_value).toFixed(2));
		total_gst +=  sgst_value;
	}
	if(igst_per > 0)
	{
		var igst_value = parseFloat(expense_amount) * parseFloat(igst_per) / 100;
		$("#igst_value").val(parseFloat(igst_value).toFixed(2));
		total_gst +=  igst_value;
	}
	$("#total_gst").val(parseFloat(total_gst).toFixed(2));
	var total_amt = parseFloat(total_gst) + parseFloat(expense_amount);
	$("#total_amt").val(total_amt.toFixed(2));
}
function calcgst_value()
{
	var total_gst = 0;
	var expense_amount = ($("#expense_amount").val() > 0)?$("#expense_amount").val():0;
	
	var cgst_value = ($("#cgst_value").val() > 0)?$("#cgst_value").val():0;
	var sgst_value = ($("#sgst_value").val() > 0)?$("#sgst_value").val():0;
	var igst_value = ($("#igst_value").val() > 0)?$("#igst_value").val():0;
	total_gst = parseFloat(cgst_value) + parseFloat(sgst_value) + parseFloat(igst_value) 
	$("#total_gst").val(parseFloat(total_gst).toFixed(2));
	var total_amt = parseFloat(total_gst) + parseFloat(expense_amount);
	$("#total_amt").val(total_amt.toFixed(2));
}
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
  
$(".select2").select2({
	width:'100%' 
})
$("#expense_form").validate({
		rules: {
			payment_mode_id: {
				required: true
			},
			expense_amount:{
				required: true
			}
		},
		messages: {
			payment_mode_id: {
				required: "Select Payment Mode"
			},
			expense_amount:{
				required: "Enter Expense Amount" 
			} 
		}
	});
$("#expense_form").submit(function(event) {
	event.preventDefault();
	if(!$("#expense_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'add_expense/manage',
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
				    $("#expense_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'expense_list'; },1500);
			   }
			   else if(obj.res==2)
			   {
				 
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'expense_list'; },1500);
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
 function load_expense_party(category_id,value)
 {
	 
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"add_expense/expense_party",
           data: {"id": category_id}, 
           success: function (response) { 
				//console.log(response)
                
                $("#expense_party_id").html(response);
                $("#expense_party_id").val(value).trigger('change');
			 	 	unblock_page("",""); 
		}
     });
 }
</script>
<?php 
if(!empty($expense_data))
{
	echo "<script>load_expense_party(".$expense_data->expense_category_id.",".$expense_data->expense_party_id.")</script>";
}
?>
  