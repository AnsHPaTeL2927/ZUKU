<?php 
$this->view('lib/header'); 
if(end(explode("/",$_SERVER['HTTP_REFERER'])) != "dashboard_payment")
{
	$_SESSION['add_expense_party_id'] = ""; 
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
									<a href="<?=base_url().'expense_payment_list'?>">Expense Payment List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> Expense Payment </h3>
							</div>
							 
						</div>
					</div>
				<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="payment_form" id="payment_form">
               		<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date" id="date" class="form-control defualt-date-picker" autocomplete="off"   placeholder="Select Date" required title="Select Date" value="<?=!empty($expense_data)?date('d-m-Y',strtotime($expense_data->date)):""?>" />
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Expense Party
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="expense_party_id" id="expense_party_id" required title="Select Expense Party" onchange="load_bill(0)">
								<option value="">Select Expense Party</option>
								<?php 
								 
									foreach($expense_party as $party)
									{
										$sel ='';
										if($expense_data->expense_party_id == $party->expense_party_id)
										{
											$sel ='selected="selected"';
										}
										else if($party->expense_party_id == $_SESSION['add_expense_party_id'])
										{
												$sel ='selected="selected"';
										}
										echo '<option '.$sel.' value="'.$party->expense_party_id.'">'.$party->party_name.'</option>';
									}
								?>
						 	</select>
							<label id="expense_party_id-error" class="error" for="expense_party_id"></label> 
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Give Payment 
						</label>
						<div class="col-sm-4">
							 <select id="payment_type" name="payment_type" class="form-control" onchange="load_due_bill(this.value,0)"> 
								<option value="1" <?=($expense_data->payment_recieve_type == 1)?"selected='selected'":""?>>Bill To Bill</option>
								<option value="2" <?=($expense_data->payment_recieve_type == 2)?"selected='selected'":""?>>On Account</option>
							 </select>
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Payment Mode
						</label>
						<div class="col-sm-4">
							 <select class="select2" name="payment_mode_id" id="payment_mode_id" required title="Select Payment Mode">
								<option value="">Select Payment Mode</option>
								<?php 
									for($i=0; $i<count($payment_mode_list);$i++)
									{
										$sel = '';
										if($payment_mode_list[$i]->payment_mode_id == $expense_data->payment_mode_id)
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
						
					 
					<div class="form-group export_bill_html" style="display:none">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Expense Bill
						</label>
						<div class="col-sm-9 show_bills" style="overflow-x: scroll;">
							 
				        </div>
				    </div> 	
				
				
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Total Paid Amount
						</label>
						<div class="col-sm-4">
							 <input type="text" name="total_paid_amount" id="total_paid_amount" class="form-control" placeholder="Paid Amount" required readonly title="Enter Paid Amount" value="<?=$expense_data->total_paid_amount?>"/>
				        </div>
				    </div>
					 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Referance No
						</label>
						<div class="col-sm-4">
							 <input type="text" name="refernace_no" id="refernace_no" class="form-control" placeholder="Referance No"   title="Enter Referance No" value="<?=$expense_data->refernace_no?>"/>
				        </div>
				    </div>	
					 <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Select File
						</label>
						<div class="col-sm-4">
							 <input type="file" name="expensepayment_file" id="expensepayment_file" class="form-control" title="Enter File"/>
				        </div>
						<?php 
						if(!empty($expense_data->expensepayment_file))
						{
							echo  ' <a class="btn btn-info"  href="'.base_url().'upload/payment/'.$expense_data->expensepayment_file.'" target="_blank"><i class="fa fa-eye"></i></a> ';
						}
						?>
				    </div>						
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks" ><?=strip_tags($expense_data->remarks)?></textarea>
				        </div>
				    </div> 
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success save_btn" />
								<a href="<?=base_url().'expense_payment_list'?>" class="btn btn-danger">
												Cancel
											</a>						
						</div>    	
				</div> 	
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />				
					<input type="hidden" name="total_kasar_amt" id="total_kasar_amt"  value="<?=$expense_data->total_kasar_amt?>"/>		
					<input type="hidden" name="total_tds_amt" id="total_tds_amt"  value="<?=$expense_data->total_tds_amt?>"/>		
					<input type="hidden" name="expense_payment_id" id="expense_payment_id"  value="<?=$expense_data->expense_payment_id?>"/>		
				</form>
					</div>
		 	</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>
function calc_pending(no)
{
	 
	var due_amt 	 = parseFloat($("#due_amt"+no).val());
	var without_amt  = ($("#without_amt"+no).val() > 0)?parseFloat($("#without_amt"+no).val()):0;
 	var paid_amount  = ($("#paid_amount"+no).val() > 0)?parseFloat($("#paid_amount"+no).val()):0;
	var kasar_amount = ($("#kasar_amount"+no).val() > 0)?parseFloat($("#kasar_amount"+no).val()):0;
	var tds_per		 = ($("#tds_per"+no).val() > 0)?parseFloat($("#tds_per"+no).val()):0;
 	var tds_amt 	 = parseFloat(without_amt) * parseFloat(tds_per) / 100;
	
	var pending_html = due_amt - paid_amount - kasar_amount - tds_amt;
	
	
	if(parseFloat(pending_html) < 0)
	{
		$(".save_btn").hide();
	}
	else
	{
		$(".save_btn").show();
	}
	$("#tds_amount"+no).val(tds_amt)
	$("#pending_html"+no).html(pending_html)
}
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
	$("#total_kasar_amt").val(total_kasar);
}
function cal_tds_total()
{
	var inps = document.getElementsByName('tds_amount[]');
	var total_tds_amt = 0;
	for (var i = 0; i <inps.length; i++) 
	{
		total_tds_amt += (parseFloat(inps[i].value) > 0)?parseFloat(inps[i].value):0;
	}
	$("#total_tds_amt").val(total_tds_amt);
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
			date: {
				required: true
			},
			expense_party_id:{
				required: true
			}
		},
		messages: {
			date: {
				required: "Select Date"
			},
			expense_party_id:{
				required: "Select Party" 
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
            url: 	root+'add_expensepayment/manage',
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
					setTimeout(function(){ window.location=root+'expense_payment_list'; },1500);
			   }
			   else if(obj.res==2)
			   {
				    
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'expense_payment_list'; },1500);
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
 
function load_due_bill(val,expense_payment_id)
{
	if(val == 1)
	{
		$(".export_bill_html").show();
		$("#total_paid_amount").attr('readonly',true);
		
		load_bill(expense_payment_id);
		
	}
	else
	{
		$(".export_bill_html").hide();
		$("#total_paid_amount").attr('readonly',false);
	}
}
 
function load_bill(expense_payment_id)
{
 
	if($("#payment_type").val() == 1)
	{
		$(".export_bill_html").show();
		block_page();
		$.ajax({ 
           type: "POST", 
           url: root+"add_expensepayment/get_expenses_bill",
           data: 
		   {
				"expense_party_id": $("#expense_party_id").val(),
				"expense_payment_id": expense_payment_id
		   }, 
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
		$(".export_bill_html").hide();
	}
}
</script>
<?php 
if(!empty($expense_data))
{
	echo "<script> load_due_bill(".$expense_data->payment_type.",".$expense_data->expense_payment_id.")</script>";
	echo "<script> load_bill(".$expense_data->expense_payment_id.")</script>";
}
else if(!empty($_SESSION['add_expense_party_id']))
{
	echo "<script> load_bill(0)</script>";
}
?>
 