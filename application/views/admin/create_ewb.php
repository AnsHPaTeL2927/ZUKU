<?php 

if(!empty($ewb_data))
{
	$shipping_bill_date = date('d-m-Y',strtotime($ewb_data->shipping_date));
	
}
else
{
	$shipping_bill_date = !empty($shipping_bill_data)?date('d-m-Y',strtotime($shipping_bill_data->date)):'';
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
									<a href="<?=base_url().'exportinvoice_listing'?>"> Self Sealing Upload</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3>  Self Sealing Upload </h3>
							 <div class="pull-right form-group">
									  	 <a class="btn btn-primary tooltips" data-title="Export Excel" href="javascript:;" onclick="exportF(this)"   ><i class="fa fa-file-excel-o"></i> Export Excel</a>
										 <a href="<?php echo base_url('exportinvoice_listing/download_excel/' + ); ?>"  type="button" class="btn btn-info">
									  	
							</div>
							</div>
							 
						</div>
					</div>
				<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="ewb_form" id="ewb_form">
               		<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Shipping Bill no
						</label>
						<div class="col-sm-4">
							 <input type="text" name="Shipping_Bill_no" id="Shipping_Bill_no" class="form-control" placeholder="Shipping Bill no" required title="Shipping Bill no" value="<?=!empty($ewb_data)?$ewb_data->shipping_bill_no:$shipping_bill_data->Shipping_Bill_no?>" />
				        </div>
				    </div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Shipping Bill Date 
						</label>
						<div class="col-sm-4">
							 <input type="text" name="shipping_date" id="shipping_date" class="form-control defualt-date-picker" autocomplete="off" value="<?=$shipping_bill_date?>" placeholder="Select Date" required title="Select Date"/>
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Eway Bill no
						</label>
						<div class="col-sm-4">
							 <input type="text" name="ewaybill_no" id="ewaybill_no" class="form-control" placeholder="Eway Bill no"   title="Eway Bill no" value="<?=!empty($ewb_data)?$ewb_data->ewaybill_no:$shipping_bill_data->ewaybill_no?>" />
				        </div>
				    </div>

					 <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							 Sealing Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="sealing_date" id="sealing_date" class="form-control defualt-date-picker" autocomplete="off"  placeholder="sealing_date" required title="Select Date" value="<?=!empty($ewb_data)?date('d-m-Y',strtotime($ewb_data->sealing_date)):date('d-m-Y')?>"/>
				        </div>
				    </div>
				    <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							 Sealing Time
						</label>
						<div class="col-sm-4">
							 <input type="text"   name="sealing_time" id="sealing_time" class="form-control timepicker"   placeholder="Sealing Time" value="<?=!empty($ewb_data)?date('h:i A',strtotime($ewb_data->sealing_time)):date("h:i A")?>"/>
				        </div>
						 
				    </div>
					 <div class="form-group">
				         <table class="table table-bordered">
							<tr>
								<th class="text-center">VEHICLE NUMBER</th>
								<th class="text-center">CONTAINER NUMBER</th>
								<th class="text-center">ESEAL NUMBER</th>
							</tr>
							<?php 
							$con_array 			= array();
							foreach($loading_data as $row)
							{
								if(!in_array($row->con_entry,$con_array))
								{
								echo '<tr>
										<td class="text-center">'.$row->truck_no.'</td>
										<td class="text-center">'.$row->container_no.'</td>
										<td class="text-center">'.$row->self_seal_no.'</td>
									</tr>';
									array_push($con_array,$row->con_entry);
								}
							}
							?>
						 </table>
						 
				    </div>
					  
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success"/>
								<a href="<?=base_url().'exportinvoice_listing'?>" class="btn btn-danger">
												Cancel
											</a>						
						</div>    	
				</div> 	
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />
					 <input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?=$export_data->export_invoice_id?>"  />
					 <input type="hidden" id="ewb_template_id" name="ewb_template_id" value="<?=$ewb_data->ewb_template_id?>"  />
					 
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
 
$(".select2").select2({
	width:'100%' 
})
$("#ewb_form").validate({
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
$("#ewb_form").submit(function(event) {
	event.preventDefault();
	if(!$("#ewb_form").valid())
	{
		return false;
	}
	 block_page();
	 
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'exportinvoice_listing/manage_ewb',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
					var obj = JSON.parse(responseData);
					if(obj.res == 1)
					{
						$("#ewb_form").trigger('reset');
						unblock_page("success","Sucessfully Added.");
						setTimeout(function(){ window.location=root+'exportinvoice_listing/download_excel/'+<?=$export_data->export_invoice_id?>; },1500);
					}
					else if(obj.res == 2)
					{
						$("#ewb_form").trigger('reset');
						unblock_page("success","Sucessfully Updated.");
						setTimeout(function(){ window.location=root+'exportinvoice_listing/download_excel/'+<?=$export_data->export_invoice_id?>; },1500);
					}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 
</script>

  