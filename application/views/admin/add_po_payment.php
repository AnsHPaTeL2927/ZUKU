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
									<a href="<?=base_url().'po_payment_list'?>">PO Payment List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> PO Payment </h3>
							</div>
							 
						</div>
					</div>
				<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="payment_form" id="payment_form">
               		<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date" id="date" class="form-control defualt-date-picker" autocomplete="off" value="<?=date('d-m-Y')?>" placeholder="Select Date" required title="Select Date"/>
				        </div>
				    </div> 	
						<div class="form-group ">
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
										if($payment_mode_list[$i]->payment_mode_id == $payment_detail->payment_mode_id)
										{
											$sel = 'selected="selected"';
										}
									?>
										<option <?=$sel?> value="<?=$payment_mode_list[$i]->payment_mode_id?>"><?=$payment_mode_list[$i]->payment_mode?></option>
									<?php
									}
									?>	 
							</select>
							<label id="payment_mode_id-error" class="error" for="payment_mode_id"></label>
				        </div>
				    </div>	
						
					 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Supplier 
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="supplier_id" id="supplier_id" required title="Select Supplier" onchange="load_bill(this.value)">
								<option value="">Select Supplier</option>
									<?php 
									for($i=0; $i<count($suppiler_list);$i++)
									{
											$sel = '';
										if($suppiler_list[$i]->supplier_id == $payment_detail->seller_id)
										{
											$sel = 'selected="selected"';
										}
									?>
										<option <?=$sel?> value="<?=$suppiler_list[$i]->supplier_id?>"><?=$suppiler_list[$i]->company_name?></option>
									<?php
									}
									?>
							</select>
							<label id="supplier_id-error" class="error" for="supplier_id"></label>
				        </div>
				    </div> 	
					 
					<div class="form-group export_bill_html">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Purchase Order Detail 
						</label>
						<div class="col-sm-9 show_bills" style="overflow-x: scroll;">
							<table class="table table-bordered"  style="<?=(empty($payment_detail))?"display:none":""?>;width:100%">
								<tr>
									<td>Sr no</td>
									<td>PO NO</td>
									<td>Total Amount</td>
									<td>Due Amount</td>
									<td>Paid Amount</td>
									<?php
									foreach($receive_payment_part_list as $receive_row)
									{
										echo "<td>".$receive_row->receive_payment_part_name."</td>";
									}
									?>
									<td>Pending Amount</td>
								</tr>
							<?php
										$no =1;							
							foreach($payment_detail->trn_data as $trn)
							{
								 $due_amt = $trn->grand_total - $trn->total_paid_amount - $trn->extra_amount;
								?>
									<tr>
										<td><?=$no?></td>
										<td><?=$trn->purchase_order_no?></td>
										<td><?=$trn->grand_total?></td>
										<td><?=$due_amt?></td>
										<td>
											<input type="text" name="paid_amount[]" id="paid_amount<?=$no?>" class="form-control" placeholder="Paid Amount"   title="Enter Paid Amount" onchange="cal_total();calc_pending(<?=$no?>)" onkeyup="cal_total();calc_pending(<?=$no?>)" autocomplete="off" value="<?=$trn->bill_paid_amount?>" />
										</td>
										<?php 
										foreach($trn->receive_trn as $receive_row)
										{
										?>
										<td>
											<input type="text" name="receive_amount<?=$no?>[]" id="receive_amount<?=$receive_row->receive_payment_part_id.$no?>" class="form-control" placeholder="<?=$receive_row->receive_payment_part_name?>"    onchange="calc_pending(<?=$no?>)" onkeyup="calc_pending(<?=$no?>)" autocomplete="off" value="<?=$receive_row->amount?>" />
										</td>
											<input type="hidden" name="receive_payment_part_id<?=$no?>[]" id="receive_payment_part_id<?=$receive_row->receive_payment_part_id.$no?>" value="<?=$receive_row->receive_payment_part_id?>"/>
										<?php
									 
										}
										?>
										<td id="pending_html<?=$no?>">
											<?=$due_amt?>
										</td>
							 <input type="hidden" name="grand_total[]" id="grand_total<?=$no?>" value="<?=($due_amt+$trn->bill_paid_amount +$trn->extra_amount)?>"/>
							 <input type="hidden" name="purchase_order_id[]" id="purchase_order_id<?=$no?>" value="<?=$trn->purchase_order_id?>"/>
					</tr>
								<?php
								$no++;
							}
							?>
								</tr>
							</table>
				        </div>
				    </div> 	
				
				
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Total Paid Amount
						</label>
						<div class="col-sm-4">
							 <input type="text" name="total_paid_amount" id="total_paid_amount" class="form-control" placeholder="Paid Amount" required readonly title="Enter Paid Amount" value="<?=$payment_detail->paid_amount?>"/>
				        </div>
				    </div>
					 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Referance No
						</label>
						<div class="col-sm-4">
							 <input type="text" name="refernace_no" id="refernace_no" class="form-control" placeholder="Referance No"   title="Enter Referance No" value="<?=$payment_detail->refernace_no?>"/>
				        </div>
				    </div>	
					 						
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks" ><?=$payment_detail->remarks?></textarea>
				        </div>
				    </div> 
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success" />
								<a href="<?=base_url().'po_payment_list'?>" class="btn btn-danger">
												Cancel
											</a>						
						</div>    	
				</div> 	
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />				
				 	<input type="hidden" id="po_payment_id" name="po_payment_id" value="<?=$payment_detail->po_payment_id?>"  />				
				</form>
					</div>
		 	</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>
function cal_total()
{
	var inps = document.getElementsByName('paid_amount[]');
	var total_paid = 0;
	for (var i = 0; i <inps.length; i++) 
	{
		total_paid += (parseFloat(inps[i].value) > 0)?parseFloat(inps[i].value):0;
		 
	}
	$("#total_paid_amount").val(total_paid);
}
function cal_kasar_total()
{
	var inps = document.getElementsByName('kasar_amount[]');
	var total_kasar = 0;
	for (var i = 0; i <inps.length; i++) 
	{
		total_kasar += (parseFloat(inps[i].value) > 0)?parseFloat(inps[i].value):0;
	}
	$("#total_kasar").val(total_kasar);
}
function calc_pending(no)
{
	var paid_amount  = parseFloat($("#paid_amount"+no).val())?parseFloat($("#paid_amount"+no).val()):0;
	var inps = document.getElementsByName('receive_amount'+no+'[]');
	var total_extra= 0;
	for (var i = 0; i <inps.length;i++) 
	{
		total_extra += (parseFloat(inps[i].value) > 0)?parseFloat(inps[i].value):0;
	}
	var grand_total = parseFloat($("#grand_total"+no).val())?parseFloat($("#grand_total"+no).val()):0;
	var pending_html = 	grand_total - parseFloat(paid_amount);
	pending_html -= 	parseFloat(total_extra);
	$("#pending_html"+no).html(pending_html);
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
			supplier_id: {
				required: true
			},
			total_paid_amount:{
				required: true
			}
		},
		messages: {
			supplier_id: {
				required: "Select Supplier"
			},
			total_paid_amount:{
				required: "Enter Paid Amount" 
			} 
		}
	});
$("#payment_form").submit(function(event) {
	event.preventDefault();
	if(!$("#payment_form").valid())
	{
		return false;
	}
	var inps = document.getElementsByName('purchase_order_id[]');
	 var no =1;
	for (var i = 0; i <inps.length; i++) 
	{
		var pending_html = parseFloat($("#pending_html"+no).text());
		if(pending_html < 0)
		{
			 toastr["error"]("Please check amount"); 
			return false;
		}
		no++;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'add_po_payment/manage',
            data: postData,
			processData	: false,
			contentType	: false,
			cache		: false,
            success		: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				    $("#payment_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'po_payment_list'; },1500);
			   }
			   else if(obj.res==2)
			   {
				    
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'po_payment_list'; },1500);
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
 
function load_bill(value)
{
	if(value != "")
	{
		
	
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"add_po_payment/get_bill",
           data: {"id": value}, 
           success: function (response) { 
				//console.log(response)
                
                $(".show_bills").html(response);
			 	 	unblock_page("",""); 
		}
     });
	}
	else
	{
		$(".show_bills").html('');
	}
}
</script>
 