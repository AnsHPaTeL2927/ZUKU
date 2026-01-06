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
									Export Payment List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								Export Payment List
								 <a href="<?php echo base_url('add_payment'); ?>" style="float:right;" type="button" class="btn btn-info">
								+ Payment  
								</a>
							 </h3>
							
						</div>
					</div>
					</div>
					<div class="row">
						 <div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Export Payment List
								 </div>
								<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-4">
										<label class="col-md-4 control-label "><strong class="pull-right"> Payment Date</strong></label>
										 <div class="col-md-8">
										 <?php 
										 
										 $year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
										 
										 $invoicedate = explode(" - ",$year);
										 
										 ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
										 </div> 
										</div>
										 
									<div class="col-md-4">
										 <label class="col-md-6 control-label" style="margin-top: 5px;">
											<strong class=""> Select Consignee Name</strong>
										</label>
										<div class="col-sm-6">
											<select class="select2" name="customer_id" id="customer_id" required title="Select Consignee Name" onchange="load_data_table()" >
												<option value="">All Consignee</option>
												<?php
												for($p=0;$p<count($customer_data);$p++)
												{
														$sel = '';
														if($customer_data[$p]->customer_id == $_SESSION['get_customerdata'])
														{
															$sel = 'selected="selected"';
														}
													echo "<option ".$sel." value='".$customer_data[$p]->customer_id."'>".$customer_data[$p]->c_companyname." </option>";
												}
												?>
												
											</select>
										</div>
									</div>
									
									<div class="col-md-4">
										 <label class="col-md-6 control-label" style="margin-top: 5px;">
											<strong class=""> Select Bill No</strong>
										</label>
										<div class="col-sm-6">
											<select class="select2" name="billdata" id="billdata" required title="Select Consignee Name" onchange="load_data_table()" >
												<option value="">All Bill No</option>
												<?php
												for($p=0;$p<count($bill_data);$p++)
												{
														$sel = '';
														if($bill_data[$p]->payment_id == $_SESSION['get_billdata'])
														{
															$sel = 'selected="selected"';
														}
													echo "<option ".$sel." value='".$bill_data[$p]->payment_id."'>".$bill_data[$p]->export_invoice_no." </option>";
												}
												?>
												
											</select>
										</div>
									</div>
											
									</div>
									<div class="table-responsive" style="margin-top:100px;">
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Date</th>
													<th>Consign Name</th>
													<th>Description</th>
													<th>Swift Amount</th>
													<th>FIRC Amount</th>
													<th>Bank Charge</th>
													<th>INR Value</th>
													<th>Bank & Reference </th>
													<th>Remarks</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
										 	</tbody>
											 <tfoot>
												<tr>
													<th colspan="4" class="text-right">Total</th>
													<th></th>
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
<script>
$(".select2").select2({
	width:'100%'
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
			dom: 'Blfrtip',
			 buttons :
			 [
				  
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i>',
                titleAttr: 'PRINT'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
				 orientation: 'landscape',
                pageSize: 'A4',
                titleAttr: 'PDF'
            }
				 			
			],
			"sAjaxSource": root+'payment_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "date" , "value" :  $("#daterange"). val()},{ "name" : "customer_id" , "value" :  $("#customer_id"). val()},{ "name" : "billdata" , "value" :  $("#billdata"). val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			 "footerCallback": function ( row, data, start, end, display ) {
				  var api = this.api(), data;
					total = api
				 // Total over this page
					pageTotal = api
						.column( 4, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(/(<([^>]+)>)/gi, "").replace(new RegExp(',', 'g'),""));
                }, 0 );
				
				pageTotal1 = api
						.column( 5, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(/(<([^>]+)>)/gi, "").replace(new RegExp(',', 'g'),""));
                }, 0 );
				
				pageTotal2 = api
						.column( 6, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'),""));
                }, 0 );
				pageTotal3 = api
						.column( 7, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'),""));
                }, 0 );
				 
            // Update footer
            
			 $( api.column( 4 ).footer() ).html(
                 numberWithCommas(pageTotal.toFixed(2))
            );
			 $( api.column( 5).footer() ).html(
                numberWithCommas( pageTotal1.toFixed(2))
            );
			$( api.column( 6).footer() ).html(
                 numberWithCommas(pageTotal2.toFixed(2)) 
            );
			$( api.column( 7).footer() ).html(
                 numberWithCommas(pageTotal3.toFixed(2)) 
            );
		 
			  
			 }
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}


 
function delete_record(deleleid)
{
	main_delete(deleleid,'payment_list/deleterecord','payment_list')
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

function edit_product(packing_model_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"model_list/fetchmodeldata",
              data: {"id": packing_model_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(packing_model_id);
					$("#edit_product_size_id").select2("val",obj.product_size_id);
					$("#edit_model_name").val(obj.model_name);
					 
					unblock_page("",""); 
                  }
              
          }); 

}	

</script>