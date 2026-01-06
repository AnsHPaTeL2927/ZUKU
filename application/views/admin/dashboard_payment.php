<?php  
$this->view('lib/header'); 
 ?>	
<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/AdminLTE.min.css">
 	 <div class="main-container">
			<?php $this->view('lib/sidebar'); ?>
			<div class="main-content">
				<div class="container">
					 
							<ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
								 	<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								 
							</ol>
							<div class="page-header">
								<h3>Dashboard </h3>
							</div>
							 
						 
					<section class="content">
					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">
								 	Outstanding Payment
								</div>
								<div class="panel-body ">
									 <div class="table-responsive">
										 <table class="table table-bordered  ">
										 <div class="pull-right">
										 <div class="form-group">
												<label for="checkpack" class="col-sm-4 control-label" >
												
												 </label>
												 <div class="col-sm-4">
													<input type="checkbox" id="checkpack" name="checkpack" placeholder="CheckPack" onclick="ShowHideDiv(this.checked)" value="1" <?=($outstanding_report->checkpack == "1")?"checked":""?>/>
												</div>
											</div>
										 </div>
										
											<thead>
												<tr role="row">
													<th style="text-align:center;">Sr No</th>
													<th style="text-align:center;">Export Invoice No</th>
													<th style="text-align:center;">Consigner </th>
													<th style="text-align:center;">Amount</th>
													<th style="text-align:center;">Due Days</th>
													<th style="text-align:center;">Over Due Days</th>
												</tr>
											</thead>
										
													
											<tbody>
											<?php
											$no = 1;
											$total_due = 0;
											foreach($outstanding_report as $due_row)
											{
												$paid_amt = ($due_row->total_paid_amt > 0)?$due_row->total_paid_amt:0;
												$kasar_amt = ($due_row->kasar_amt > 0)?$due_row->kasar_amt:0;
												 
												$due_amt = indian_number(($due_row->grand_total - $paid_amt - $due_row->kasar_amt),2);
												$due_amt = str_ireplace(",","",$due_amt);
												if($due_amt > 0)
												{
													$locale='en-US'; //browser or user locale
													$currency=$due_row->currency_code; 
													$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
													$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
													$overdue_days = 0;
													if($due_row->credit_days > 0)
													{
														$overdue_days = $due_row->days - $due_row->credit_days;
													}
											?>
												<tr class="<?=($overdue_days > 0)?"showdata":"notshowdata"?>">
													<td style="text-align:center;"><?=$no?></td>
													<td style="text-align:center;"><?=$due_row->export_invoice_no?></td>
													<td style="text-align:center;"><?=$due_row->c_companyname?></td>
													<td style="text-align:right;">
														<a href="javascript:;" onclick="add_payment(<?=$due_row->consiger_id?>,<?=$due_row->export_invoice_id?>);">
														<?=$currency_symbol?><?=indian_number($due_amt,2)?>
														</a>
													</td>
													<td style="text-align:center;"><?=$due_row->days?></td>
													<td style="text-align:center;"><?=($overdue_days > 0)?$overdue_days:0?></td>
												</tr>
												<?php
												$total_due += $due_amt;
											$no++;
												}
											}
										 	?>
											<tr class="<?=($overdue_days > 0)?"showdata":"notshowdata"?>">
												 	<td colspan="3" style="text-align:right;"><strong>Total</strong></td>
													<td style="text-align:right;"><strong><?=number_format($total_due,2,'.',',')?></strong></td>
													<td> </td>
													 
												</tr>
											</tbody>
											
										</table> 
									</div>
								</div>
							</div>
						</div>
					 
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">
								 	Factory Payment Out
								</div>
								<div class="panel-body ">
									 
									<div class="table-responsive">
										 <table class="table table-bordered  ">
											<thead>
												<tr role="row">
													<th style="text-align:center;">Sr No</th>
												 	<th style="text-align:center;">Factory Name</th>
													<th style="text-align:center;">Amount</th>
													<th style="text-align:center;">Due Days</th>
													<th style="text-align:center;">Overdue Days</th>
												</tr>
											</thead>
											<tbody>
											<?php
											$no =1;
											$total_due = 0;
											foreach($factory_outstanding_report as $fdue_row)
											{
												$paid_amt = ($fdue_row->total_paid_amt > 0)?$fdue_row->total_paid_amt:0;
												$due_amt = $fdue_row->total_amt - $paid_amt;
												if($due_amt > 0)
												{
													$overdue_days = 0;
													if($fdue_row->credit_days > 0)
													{
														 
														$overdue_days = $fdue_row->days - $fdue_row->credit_days;
													}
											?>
												<tr>
													<td style="text-align:center;"><?=$no?></td>
												 	<td style="text-align:center;"><?=$fdue_row->party_name?></td>
													<td style="text-align:right;">
														<a onclick="add_factory_payment(<?=$fdue_row->expense_party_id?>);" href="javascript:;">	
															<?=indian_number($due_amt,2)?>
														</a>
													</td>
													<td style="text-align:center;"><?=$fdue_row->days?></td>
													<td style="text-align:center;"><?=($overdue_days > 0)?$overdue_days:0?></td>
												</tr>
												<?php
											$no++;
											$total_due += $due_amt;
												}
											}
											
											?>
											<tr>
												 	<td colspan="2" style="text-align:right;"><strong>Total</strong></td>
													<td style="text-align:right;"> <strong><?=indian_number($total_due,2)?></strong></td>
													<td> </td>
													 
												</tr>
											</tbody>
										</table> 
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">
								 	Drawback Pending
								</div>
								<div class="panel-body ">
									 
									<div class="table-responsive">
										 <table class="table table-bordered  ">
											<thead>
												<tr role="row">
													<th style="text-align:center;">Sr No</th>
													<th style="text-align:center;">Export Invoice No</th>
													<th style="text-align:center;">Amount</th>
											 	</tr>
											</thead>
											<tbody>
											<?php
											$no = 1;
											$total_drawback = 0;
											foreach($drawback_pending as $drawback_row)
											{
									  		?>
												<tr>
													<td style="text-align:center;"><?=$no?></td>
													<td style="text-align:center;"><?=$drawback_row->export_invoice_no?></td>
													<td style="text-align:right;">
														<a href="javascript:;" onclick="add_drawback_payment(<?=$drawback_row->id?>);">
															<?=indian_number($drawback_row->drawback_amount,0)?>
														</a>	
													</td>
											 	</tr>
												<?php
												$total_drawback += $drawback_row->drawback_amount;
												$no++;
										 	}
										 	?>
											<tr>
												 	<td colspan="2" style="text-align:right;">
														<strong>Total</strong>
													</td>
													<td style="text-align:right;">
														<strong><?=indian_number($total_drawback)?></strong>
													</td>
													  
												</tr>
											</tbody>
										</table> 
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">
								 	Expense Payment Pending
								</div>
								<div class="panel-body ">
									 
									<div class="table-responsive">
										 <table class="table table-bordered  ">
											<thead>
												<tr role="row">
													<th style="text-align:center;">Sr No</th>
												 	<th style="text-align:center;">Party Name</th>
													<th style="text-align:center;">Amount</th>
													<th style="text-align:center;">Due Days</th>
													<th style="text-align:center;">Overdue Days</th>
												</tr>
											</thead>
											<tbody>
											
											<?php
											
											$no =1;
											$total_due = 0;
											
											foreach($expense_outstanding_report as $fdue_row)
											{
												$paid_amt = ($fdue_row->total_paid_amt > 0)?$fdue_row->total_paid_amt:0;
												$due_amt = $fdue_row->total_amt - $paid_amt;
												if($due_amt > 0)
												{
													$overdue_days = 0;
													if($fdue_row->credit_days > 0)
													{
														 $overdue_days = $fdue_row->days - $fdue_row->credit_days;
													}
											?>
												<tr>
													<td style="text-align:center;"><?=$no?></td>
												 	<td style="text-align:center;"><?=$fdue_row->party_name?></td>
													<td style="text-align:right;">
														<a onclick="add_factory_payment(<?=$fdue_row->expense_party_id?>);" href="javascript:;">	
															<?=indian_number($due_amt,2)?>
														</a>
													</td>
													<td style="text-align:center;"><?=$fdue_row->days?></td>
													<td style="text-align:center;"><?=($overdue_days > 0)?$overdue_days:0?></td>
												</tr>
												<?php
											$no++;
											$total_due += $due_amt;
												}
											}
											
											?>
											<tr>
												 	<td colspan="2" style="text-align:right;"><strong>Total</strong></td>
													<td style="text-align:right;"> <strong><?=indian_number($total_due,2)?></strong></td>
													<td> </td>
													 
												</tr>
											</tbody>
										</table> 
									</div>
								</div>
							</div>
						</div>
						
					
					</div>
				</section>
				 
		
				</div>
			</div>
			 
		</div>
		 
<?php $this->view('lib/footer'); ?>
<div id="myModal" name="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
			
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">  Recive Drawback Payment </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="recive_payment_form" id="recive_payment_form">
				<div class="modal-body">
				
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Payment Date
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Payment Date" id="payment_date" class="form-control defualt-date-picker" name="payment_date" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
						Select Bank 
						</label>
						 <div class="col-sm-12">
							<select name="bank_id" id="bank_id" class="select2">
									<option value="">Select Bank</option>
										<?php 
										 for($i=0; $i<count($all_bank);$i++)
										{
									 	?>
											<option  value="<?php echo $all_bank[$i]->id; ?>" ><?php echo $all_bank[$i]->bank_name.' - '.$all_bank[$i]->account_name; ?></option>
										<?php
										}
										?>
							</select>
							<label id="bank_id-error" class="error" for="bank_id"></label>
						</div>
					</div>			
			    </div>
			   
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			
				<input type="hidden" name="upload_shipping_bill_id" id="upload_shipping_bill_id" />
				 
			 </form>
        </div>
    </div>
</div>

<script>
$(".select2").select2({
	width:'100%'
});
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 
function ShowHideDiv(checkpack)
{
    $(".notshowdata").show();
	if(checkpack == true)
	{
		$(".notshowdata").hide();
	}
		
}

function add_payment(consiger_id,export_invoice_id)
{
	block_page();
	 $.ajax({ 
              type: "POST", 
              url: root+'dashboard_payment/set_session',
              data: {
                "consiger_id"			: consiger_id,
                "export_invoice_id"		: export_invoice_id 
              }, 
              cache: false, 
              success: function (data) 
			  { 
				
					window.location = root+'add_payment';
					unblock_page("","");
              }
			});
}
function add_factory_payment(expense_party_id)
{
	block_page();
	 $.ajax({ 
              type: "POST", 
              url: root+'dashboard_payment/add_factory_payment',
              data: {
                "expense_party_id"			: expense_party_id 
              }, 
              cache: false, 
              success: function (data) 
			  { 
				
					window.location = root+'add_expensepayment';
					unblock_page("","");
              }
			});
}
function add_drawback_payment(id)
{
	 $("#upload_shipping_bill_id").val(id);
	 $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});

}
$("#recive_payment_form").validate({
		rules: {
			payment_date: {
				required: true
			},
			bank_id:{
				required:true
			}
		},
		messages: {
			payment_date: {
				required: "Select Payment Date"
			},
			bank_id:{
				required:"Select Bank"
			} 
		}
});
$("#recive_payment_form").submit(function(event) {
	event.preventDefault();
	if(!$("#recive_payment_form").valid())
	{
		return false;
	}
 	block_page();
	var postData= new FormData(this);
 	$.ajax({
            type: "post",
            url: 	root+'drawback_received/manage',
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
						setTimeout(function(){ window.location=root+'dashboard_payment'; },1500);
					 
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
$checked  = ($outstanding_report->checkpack == "1")?"true":"false";
	echo "<script>ShowHideDiv(".$checked.")</script>";
	
?>