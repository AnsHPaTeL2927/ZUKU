<?php 
$this->view('lib/header'); 
$_SESSION['beenhere'] = 1;
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
									BRC Master
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>BRC Master  
								 
							</h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									BRC Master
									
								</div>
								<div class="panel-body" >
									 
											<label class="radio-inline" style="display:none">
												<input type="radio" name="invoice_status" id="invoice_status2" value="1"  onclick="filterbystatus(this.value)" checked>Completed 
											</label>
										   
											
											<?php
								//	print_r('<pre>');
									//print_r($invoice);
									//print_r($customer);
									//print_r($payment);

									?>	
								
								</div>
								
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="sample-table-1" width="100%">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Invoice Date</th>
													<th>Export Invoice no</th>
													<th>Customer Name</th>
													<th>Invoice Amount</th>
													<th>Received Payment</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
										$m=1;
										 
											for($i=0; $i<count($invoice);$i++)
											{

												// if (empty($invoice[$i]->total_paid) || $invoice[$i]->total_paid == '') {
												// 	print_r('<pre>');
												// 	print_r($invoice[$i]->total_paid);
												// 	unset($arr[2]); 
												//  }

												
												 
											?>
												<tr>
													<td><?=$m?></td>
													<td><?=date('d/m/Y',strtotime($invoice[$i]->invoice_date))?></td>
													<td><?=$invoice[$i]->export_invoice_no?></td>
													<td><?=$invoice[$i]->c_companyname?></td>
													<td>
														<?php if($invoice_record[0]->currency_name == 'Euro') {echo '€'; } else { echo '$'; } ?> <?=$invoice[$i]->grand_total?>
													</td>
													 <td>
														<?php if($invoice_record[0]->currency_name == 'Euro') {echo '€'; } else { echo '$'; } ?> <?=$invoice[$i]->total_paid?>
													</td>
													 <td>
													 <div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
														<span class="caret"></span></button>
														<ul class="dropdown-menu">
														<li> <a class="tooltips" data-toggle="tooltip" data-title="View Details" href="<?=base_url().'brc_master/details/'.$invoice[$i]->export_invoice_id?>" > View Details</a></li>
														
														<li> <a class="tooltips" data-toggle="tooltip" data-title="Create FIRC" href="<?=base_url().'brc_master/firc/'.$invoice[$i]->export_invoice_id?>" > Create FIRC</a></li>
														</td>
													
													 
													
												</tr>
										<?php
											$m++;
										}
										 
										?>	
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
			 
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Detail</h4>
            </div>
            <div class="modal-body">
				<div class="productdetailhtml"></div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $this->view('lib/footer'); ?>
<script type="text/javascript">
$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   
			});
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
			"iDisplayLength": 50,
			"sAjaxSource": root+'brc_master/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "invoice_status" , "value" :  $("input[name='invoice_status']:checked"). val()},{ "name" : "date" , "value" :  $("#daterange"). val()} );
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}
function delete_record(id,proforma_id,no_of_export)
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
              url: root+'exportinvoice_listing/deleterecord',
              data: {
                "id"			: id,
                "proforma_id"	: proforma_id,
                "no_of_export"	: no_of_export
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'exportinvoice_listing'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function view_detail(id,currency_id)
{
	 
	$.ajax({ 
        type: "POST", 
        url: root+"exportinvoice_listing/viewproductdetail",
              data: {
                "id": id,
				"currency_id":currency_id
              }, 
              cache: false, 
              success: function (data) { 
               $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
                
                 $(".productdetailhtml").html(data);  
			}

		});  

}
</script>