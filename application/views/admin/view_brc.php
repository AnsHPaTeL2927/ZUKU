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
									View BRC
								</li>
								 
							</ol>
							<div class="page-header">
							
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									View Details
									
								</div>
								<div class="panel-body" >
									 
									<?php
									//  print_r('<pre>');
									//  print_r($invoice_record[0]);

									?>
										   
									
										   <div class="table-responsive">
										<table class="table table-bordered table-hover display"  width="100%">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Invoice Date</th>
													<th>Export Invoice no</th>
													<th>Customer Name</th>
													<th>Invoice Amount</th>
													<th>Received Payment</th>
													<th>Bank Charges</th>
												</tr>
											</thead>
											<tbody>
										<?php
											$grand_total = $invoice_record[0]->grand_total;
											$grand_total += $invoice_record[0]->certification_charge;
											$grand_total += $invoice_record[0]->insurance_charge;
											$grand_total += $invoice_record[0]->seafright_charge;

										?>
												<tr>
													<td>1</td>
													<td><?=date('d/m/Y',strtotime($invoice_record[0]->invoice_date))?></td>
													 <td><?=$invoice_record[0]->export_invoice_no?></td>
													 <td><?=$invoice_record[0]->c_companyname?></td>
													 <td><?php if($invoice_record[0]->currency_name == 'Euro') {echo '€'; } else { echo '$'; } ?> <?=$grand_total?></td>
													 <td><?php if($invoice_record[0]->currency_name == 'Euro') {echo '€'; } else { echo '$'; } ?> <?=$invoice_record[0]->total_paid?></td>
													 <td><?php if($invoice_record[0]->currency_name == 'Euro') {echo '€'; } else { echo '$'; } ?> <?=$invoice_record[0]->total_bank_charges?></td>
													 
													
												</tr>
										
											 </tbody>
										</table>
									</div>		
								
								</div>
								
								
							</div>
						 
						</div>
					</div>
					<div class="row">
					   
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Payment Received
									
								</div>
								
								
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="sample-table-2" width="100%">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Amount</th>
													<th>Bank Charges</th>
													<th>Referance ID</th>
													<th>Files View</th>
												</tr>
											</thead>
											<tbody>
											<?php 
										$m=1;
										 
											for($i=0; $i<count($payment_record);$i++)
											{
												 
											?>
												<tr>
													<td><?=$m?></td>
													<td><?php if($invoice_record[0]->currency_name == 'Euro') {echo '€'; } else { echo '$'; } ?> <?=$payment_record[$i]->paid_amount?></td>
													 <td><?php if($invoice_record[0]->currency_name == 'Euro') {echo '€'; } else { echo '$'; } ?> <?=$payment_record[$i]->bank_charge?></td>
													 <td><?=$payment_record[$i]->refernace_no?></td>
													 <td>
														
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
					<div class="row">
					   
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Shipping Details
								</div>
								
								
								<div class="panel-body">
								<?php
								
								if(!empty($result1->date)){
									$Shipping_bill_date =  date('d/m/Y',strtotime($result1->date));
								}
								else{
									$Shipping_bill_date = '';
								}

								?>
									<br>
									<h4>Shipping Bill No : <?=$result1->Shipping_Bill_no?> | Shipping Bill Date : <?=$Shipping_bill_date?></h4>
									<br>
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="" width="100%">
											<thead>
												<tr>
													<th>Doc</th>
													<th>BL</th>
													<th>Shipping Bill</th>
													<th>Export Invoice</th>
													<th>TT Copy 1</th>
													<th>TT Copy 2</th>
												</tr>
											</thead>
											<tbody>
											<?php
											if(empty($invoice_record[0]->upload_bl)){
												$upload_bltn = '
											<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'upload_bl/index/'.$invoice_record[0]->export_invoice_id.'"><i class="fa fa-pencil"></i> Upload BL</a>
											';
											}
											else{
												$upload_bltn = '
											<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'upload/'.$result->bl_upload.'" target="_blank"><i class="fa fa-file-text-o"></i> View BL</a>
											';
											}
											
											if(empty($invoice_record[0]->upload_shiping_bill)){
												$upload_shiping_bill = '
											<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'upload_shiping_bill/index/'.$invoice_record[0]->export_invoice_id.'"><i class="fa fa-pencil"></i> Upload Shipping Bill</a>
											';
											}
											else{
												$upload_shiping_bill = '
											<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'upload_shiping_bill/form_edit/'.$invoice_record[0]->export_invoice_id.'/'.$invoice_record[0]->upload_shiping_bill.'"><i class="fa fa-file-text-o"></i> Edit Upload Shipping Bill</a>
											';
											}

											?>
												<tr>
													<td></td>
													<td><?=$upload_bltn?></td>
													 <td><?=$upload_shiping_bill?></td>
													 <td><a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="<?=base_url().'exportinvoiceview/index/'.$invoice_record[0]->export_invoice_id?>" ><i class="fa fa-file-text-o"></i> View Invoice</a></td>
													 <td></td>
													 <td></td>
													
												</tr>
										
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
$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   
			});
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