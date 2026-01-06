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
									PI Payment List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								PI Payment List
							</h3>
							
						</div>
					</div>
					</div>
					<div class="row">
						 <div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									PI Payment List
								 </div>
								<div class="panel-body">
								<div class="col-md-8">
										<label class="col-md-2 control-label ">
											<strong class="pull-right"> Payment Date</strong></label>
												<div class="col-md-4">
												<?php 
													$year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
													$invoicedate = explode(" - ",$year);
												?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
										 </div>     
									</div>
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Date</th>
													<th>Customer Name</th>
													<th>Description</th>
													<th>Amount</th>
												  	<th>Reference No</th>
												 	<th>Payment Mode No</th>
													<th>Remarks</th>
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
				
				 
				 
				</div>
			</div>
			 
		</div>	 
<?php $this->view('lib/footer'); ?>
<div id="next_modal" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
               
                <h4 class="modal-title"> Confirm Received Payment of <span id="pi_html"></span> <div class="pull-right amt_html">Amount :  </div></h4>
				
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="pi_payment_form" id="pi_payment_form">
            <div class="modal-body">
				 <div class="row">
					 <div class="form-group col-md-6">
					 	<label class="col-md-6 control-label">
					 		Orignal Payment Received Date
					 	</label>
					 	<div class="col-md-6">
					 		 <input type="text" placeholder="Received Payment Date" id="receive_payment_date" class="form-control defualt-date-picker" name="receive_payment_date" value="<?=date('d-m-Y');?>" >
					 	</div>
					</div>
					
				 
					<div class="form-group col-md-6">
					 	<label class="col-md-6 control-label">
					 		 Payment Mode
					 	</label>
					 	<div class="col-md-6">
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
					<div class="form-group col-md-6">
					 	<label class="col-md-6 control-label">
					 		 Payment Received
					 	</label>
					 	<div class="col-md-6">
					 		 <input type="text" placeholder="Payment Received" id="paymentreceived" class="form-control" name="paymentreceived" value="" required title="Enter Payment Received">
					 	</div>
					</div>
					<?php 
				 	foreach($receive_payment_part_list as $receive_row)
					{
					?>
						<div class="form-group col-md-6">
							<label class="col-md-6 control-label">
								<?=$receive_row->receive_payment_part_name?>
							</label>
							<div class="col-md-6">
								<input type="text" placeholder="<?=$receive_row->receive_payment_part_name?>" id="payment_received<?=$receive_row->receive_payment_part_id?>" class="form-control" name="payment_received[]" value="" >
							</div>
					</div>
						<input type="hidden" name="receive_payment_part_id[]" id="receive_payment_part_id<?=$receive_row->receive_payment_part_id?>" value="<?=$receive_row->receive_payment_part_id?>"/>
					<?php
					 }
					 ?>
					 <div class="form-group col-md-6">
					 	<label class="col-md-6 control-label">
					 		 Refernace No
					 	</label>
					 	<div class="col-md-6">
					 		 <input type="text" placeholder="Refernace No" id="refernace_no" class="form-control" name="refernace_no" value="" required title="Enter Reference No">
					 	</div>
					</div>
					<div class="form-group col-md-6">
					 	<label class="col-sm-6 control-label" for="form-field-1">
					 		Payment Receive document
					 	</label>
					 	<div class="col-sm-4">
					 		<input type="file" id="receive_payment_document" class="form-control" name="receive_payment_document" value=""  title="Enter Payment document">
					 	</div>
						 <div class="col-md-2">
							<a class="btn btn-info" target="blank" style="display:none" id="receive_payment_document_downaload_btn"><i class="fa fa-download"></i></a>
						</div>
					</div>
					<div class="form-group col-md-6">
					 	<label class="col-md-6 control-label">
					 		 Remarks
					 	</label>
					 	<div class="col-md-6">
					 		 <textarea placeholder="Remarks" id="remarks" class="form-control" name="remarks" value=""></textarea>
					 	</div>
					</div>
					
				</div>
             </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				 <input type="hidden" name="pi_advance_payment_id" id="pi_advance_payment_id" />
				 <input type="hidden" name="receive_payment_document_file" id="receive_payment_document_file" />
            </div>
			 </form>
        </div>
    </div>
</div>
<script>
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy'
});
$(".select2").select2({
	width:'100%' 
});
$(document).ready(function (){
	  

	$("#pi_payment_form").validate({
		rules: {
			receive_payment_date: {
				 required:true
			} 
		},
		messages: {
			receive_payment_date: {
				 required:"Select Date" 
			} 
		}
	});		
});

$("#pi_payment_form").submit(function(event) {
	event.preventDefault();
	if(!$("#pi_payment_form").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	  
	$.ajax({
            type: "post",
            url: 	root+'pi_payment_list/confirm_payment',
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
					unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ location.reload(); },100);
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
 

function recived_payment(pi_advance_payment_id,invoice_no)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"pi_payment_list/fetchpaymentdata",
              data: {
						"id" : pi_advance_payment_id
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#next_modal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#pi_advance_payment_id").val(pi_advance_payment_id);
					 $("#payment_mode_id").val(obj.payment_mode_id).trigger('change');
					 $("#paymentreceived").val(obj.payment_received);
					 $("#refernace_no").val(obj.refernace_no);
					 $("#remarks").val(obj.remarks);
					 $("#receive_payment_date").val(obj.receive_payment_date);
					 $("#receive_payment_document_file").val(obj.receive_payment_document);
					 $("#receive_payment_document_downaload_btn").show();
					 $("#receive_payment_document_downaload_btn").attr("src",root+"upload/"+obj.receive_payment_document);
					 $("#pi_html").html(invoice_no);
					 $(".amt_html").html("Amount : "+obj.amount);
					unblock_page("",""); 
                  }
              
          }); 

}
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
function load_data_table()
{
	datatable = $("#datatable").dataTable({
				"bAutoWidth" : false,
				"bFilter" : true,
				"bSort" : true,
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
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'pi_payment_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "date" , "value" :  $("#daterange"). val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}

 
function delete_record(deleleid)
{
	main_delete(deleleid,'po_payment_list/deleterecord','po_payment_list')
}
$("#model_add").validate({
		rules: {
			model_name: {
				required: true
			}
		},
		messages: {
			model_name: {
				required: "Enter Model Name"
			}
		}
	});

	$("#edit_form").validate({
		rules: {
			edit_model_name: {
				required: true
			}
		},
		messages: {
			edit_model_name: {
				required: "Enter Model Name"
			}
		}
	});

$("#model_add").submit(function(event) {
	event.preventDefault();
	if(!$("#model_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Model_list/manage',
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
				   $("#model_add").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Inserted.");
					 setTimeout(function(){ window.location=root+'model_list' },1500);
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

$("#edit_form").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Model_list/edit_record',
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
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'model_list' },1500);
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