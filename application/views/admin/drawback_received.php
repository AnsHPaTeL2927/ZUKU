<?php 
$this->view('lib/header'); 
 
?>	 <div class="main-container">
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
								 Shipping Bill List (Drawback recieved Entry)
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Shipping Bill List
								 
							</h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Shipping Bill List
									
								</div>
								<div class="panel-body" >
									   <div class="col-md-4">
										<label class="col-md-4 control-label "><strong class="pull-right"> Date</strong></label>
										 <div class="col-md-7">
										<?php 
											$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
											
											$invoicedate = explode(" - ",$year);
										?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
										 </div>     
									</div>
									
									<div class="col-md-4">
										 <label class="col-md-5 control-label" style="margin-top: 5px;">
											<strong class=""> Export Invoice No</strong>
										</label>
										<div class="col-sm-7">
											<select class="select2" name="invoicedata" id="invoicedata" required title="Select Consignee Name" onchange="load_data_table()" >
												<option value="">All Export Invoice No</option>
												<?php
												for($p=0;$p<count($invoice_data);$p++)
												{
														$sel = '';
														if($invoice_data[$p]->id == $_SESSION['get_invoicedata'])
														{
															$sel = 'selected="selected"';
														}
													echo "<option ".$sel." value='".$invoice_data[$p]->id."'>".$invoice_data[$p]->export_invoice_no." </option>";
												}
												?>
												
											</select>
										</div>
									</div>
									
										
									<label class="col-md-2 control-label" style="margin-top: 5px;">
									<strong class=""> Shipping Bill No</strong>
									</label>
									<div class="col-sm-2">
										<select class="select2" name="shippingdata" id="shippingdata" required title="Select Consignee Name" onchange="load_data_table()" >
											<option value="">All Shipping Bill No</option>
											<?php
											for($p=0;$p<count($shipping_bill);$p++)
											{
													$sel = '';
													if($shipping_bill[$p]->id == $_SESSION['get_shippingdata'])
													{
														$sel = 'selected="selected"';
													}
												echo "<option ".$sel." value='".$shipping_bill[$p]->id."'>".$shipping_bill[$p]->shipping_bill_no." </option>";
											}
											?>
											
										</select>
									</div>
								
								</div>
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
												 	<th>Sr No</th>
												 	<th>Export Invoice No</th>
													<th>Date</th>
													<th>Shipping Bill No</th>
													<th>Shipping Bill Date</th>
													<th>Drawback Amount</th>
													<th>RODTEP Amount</th>
													<th>Paid Date</th>
												 	<th>Exchange Rate</th>
												 	<th>Status</th>
												 	<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											 </tbody>
											 <tfoot>
												<tr>
													<th colspan="5" class="text-right">Total</th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													 
											 	 </tr>
												</tfoot>
										</table>
									</div>
								</div>
							</div>
						 
						</div>
					</div>
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

<script type="text/javascript">
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
						setTimeout(function(){ window.location=root+'drawback_received'; },1500);
					 
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
	
$(".select2").select2({
	width:'100%'
});
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
function cb(start, end) {
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    cb(moment().subtract(29, 'days'), moment());
	 
    $('#daterange').daterangepicker({       
 			locale: {
				format: 'DD-MM-YYYY'
			},
		"autoApply": true,	
		"startDate": $('#s_date').val(),
		"endDate": $('#e_date').val(),	
	    ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		   'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb); 
 
$(document).ready(function () {
	 	load_data_table();
		
});
function filterbystatus()
{
	load_data_table()
}
function load_data_table()
{
	 
	datatable = $("#datatable").dataTable({
			"bAutoWidth" : false,
			"bFilter" 	: true,
			"bSort" 	: true,
			"bProcessing": true,
			"searchDelay": 350,
			"bServerSide" : true,
			"bDestroy": true,
			"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "NO DATA ADDED YET !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root+'drawback_received/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name" : "date" , "value" :  $("#daterange"). val()},{ "name" : "invoicedata" , "value" :  $("#invoicedata"). val()},{ "name" : "shippingdata" , "value" :  $("#shippingdata"). val()} );
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			 "footerCallback": function ( row, data, start, end, display ) {
				  var api = this.api(), data;
					total = api
				 // Total over this page
					pageTotal = api
						.column( 5, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'),""));
                }, 0 );
				 
				 // Total over this page
					pageTotal1 = api
						.column( 6, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'),""));
                }, 0 );
            // Update footer
            
			 $( api.column( 5 ).footer() ).html(
                 numberWithCommas(pageTotal.toFixed(2))
            );
			 
			  $( api.column( 6 ).footer() ).html(
                 numberWithCommas(pageTotal1.toFixed(2))
            );
			 }
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}
function delete_record(id)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'drawback_received/deleterecord',
              data: {
                "id"			: id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'drawback_received'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}

function add_payment(id)
{
	 $("#upload_shipping_bill_id").val(id);
	 $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});

}
</script>