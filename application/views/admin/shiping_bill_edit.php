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
									<a href="<?=base_url().'shiping_bill'?>">Shipping bill</a>
								</li>
							 
							</ol>
							<?php
								//print_r($export_invoice_no);
							?>
							<div class="page-header">
							<h3>Shipping Bill | <?php echo $export_invoice_no[0]->export_invoice_no; ?> | <?php echo $customer[0]->c_companyname; ?></h3>
							</div>
							 
						</div>
					</div>
				<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="payment_form" id="payment_form">
               		<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Shipping Bill no
						</label>
						<div class="col-sm-4">
							 <input type="text" value="<?=$result->Shipping_Bill_no?>" name="Shipping_Bill_no" id="Shipping_Bill_no" class="form-control" placeholder="Shipping Bill no" required title="Shipping Bill no"/>
				        </div>
				    </div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Shipping Bill Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date" id="date" class="form-control defualt-date-picker" autocomplete="off" value="<?=date('d/m/Y',strtotime($result->date))?>" placeholder="Select Date" required title="Select Date"/>
				        </div>
				    </div> 	
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Exchange Rate
						</label>
						<div class="col-sm-4">
							 <input type="number" value="<?=$result->exchange_rate?>" step="0.01" name="exchange_rate" id="exchange_rate" class="form-control" placeholder="Exchange Rate" required title="Exchange Rate"/>
				        </div>
				    </div>

				    <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Drawback Amount
						</label>
						<div class="col-sm-4">
							 <input type="number" value="<?=$result->drawback_amount?>" step="0.01" name="drawback_amount" id="drawback_amount" class="form-control" placeholder="Drawback Amount" required title="Drawback Amount"/>
				        </div>
				    </div>

				    <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Total Invoice Value
						</label>
						<div class="col-sm-4">
							 <input type="number" value="<?=$result->total_invoice_value?>" step="0.01" name="total_invoice_value" id="total_invoice_value" class="form-control" placeholder="Total Invoice Value" />
				        </div>
				    </div>

				    <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Date of Shipment
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date_of_shipment" id="date_of_shipment" class="form-control defualt-date-picker" autocomplete="off" value="<?=date('d/m/Y',strtotime($result->date_of_shipment))?>" placeholder="Select Date" required title="Select Date"/>
				        </div>
				    </div> 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Discount 
						</label>
						<div class="col-sm-4">
							 <input type="number" step="0.01" value="<?=$result->Discount?>" name="Discount" id="Discount" class="form-control" autocomplete="off"  placeholder="Discount"  title="Discount"/>
				        </div>
				    </div> 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
						Commission  
						</label>
						<div class="col-sm-4">
							 <input type="number" step="0.01" value="<?=$result->commission?>" name="commission" id="commission" class="form-control " autocomplete="off"  placeholder="commission"  title="commission"/>
				        </div>
				    </div>
					<!-- <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
						Received Drawback Amount in bank 
						</label>
						<div class="col-sm-4">
							 <input type="text" name="Payment_of_drawback" value="<?=$result->Payment_of_drawback?>" id="Payment_of_drawback" class="form-control " autocomplete="off"  placeholder="Received Drawback Amount in bank"  title="Received Drawback Amount in bank"/>
				        </div>
				    </div> -->
					<!-- <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
						Payment Received Date 
						</label>
						<div class="col-sm-4">
						<input type="text" name="received_date" id="received_date" class="form-control defualt-date-picker" autocomplete="off" value="<?=date('d/m/Y',strtotime($result->received_date))?>" placeholder="Payment Received Date"  title="Payment Received Date"/>
				        </div>
				    </div>  -->

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Field1
						</label>
						<div class="col-sm-4">
							<input type="text" id="field1" value="<?=$result->field1?>" name="field1" placeholder="Field1"   class="form-control"  value="" />
						</div>
					</div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Field2
						</label>
						<div class="col-sm-4">
							<input type="text" id="field2" value="<?=$result->field2?>" name="field2" placeholder="Field2"   class="form-control"  value="" />
						</div>
					</div>	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remark" id="remark" class="form-control" placeholder="Remarks" ><?=$result->remark?></textarea>
				        </div>
				    </div> 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Upload Shipping Bill
						</label>
						<div class="col-sm-4">
							 <input type="file" name="bl_upload" id="bl_upload"  class="form-control" title="Please Upload Shipping Bill"/>
				        </div>
						<?php if($result->bl_upload != ''){ ?> 
						<div class="col-sm-2" style="border-color: black;border-width: 1px;border-style: double;">
						<a href="<?=base_url()?>upload/<?=$result->bl_upload?>" target="_blank">View Shipping Bill</a>
				        </div>
					<?php } ?>
				    </div>
					
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success" />
								<a href="<?=base_url().'shiping_bill'?>" class="btn btn-danger">
												Cancel
											</a>						
						</div>    	
				</div> 	
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />
					 <input type="hidden" id="shiping_id" name="shiping_id" value="<?=$shiping_id?>"  />
					 <input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?php echo $export_invoice_no[0]->export_invoice_id; ?>"  />
					 <input type="hidden" id="bill_image" name="bill_image" value="<?=$result->bl_upload?>"  />
					 				
				</form>
					</div>
		 	</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>
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
            url: 	root+'shiping_bill/manage_edit',
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
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'shiping_bill'; },1500);
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
function load_customer_bill(value)
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
				  $("#bill_id").html(obj.str)
			 	}
				else
				{
					$(".export_bill_html").hide();
					 
				}
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

  