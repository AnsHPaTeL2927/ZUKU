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
									Purchase Order
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Purchase Order </h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Purchase Order
									
								</div>
								<div class="panel-body" style="padding-left:0px;">
									<div class="col-md-8">
										<label class="col-md-2 control-label "><strong class="pull-right">Invoice Status</strong></label>
										 <div class="col-md-10">
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status1" value="0"  onclick="filterbystatus(this.value)" checked >All
											</label>
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status2" value="1"  onclick="filterbystatus(this.value)"  >Completed 
											</label>
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status3" value="2"  onclick="filterbystatus(this.value)" >Container/Packing Pending 
											</label>
										 
										 </div>     
									</div>
										<div class="col-md-8">
										<label class="col-md-2 control-label" style="    margin-top: 5px;"><strong class=""> Invoice Date</strong></label>
										 <div class="col-md-5">
											 <?php 
												$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
										 		$invoicedate = explode(" - ",$year);
												$start_date = $invoicedate[0];
												$end_date 	= $invoicedate[1];
												if(!empty($_SESSION['pur_s_date']))
												{
													$start_date = $_SESSION['pur_s_date'];
												}
												if(!empty($_SESSION['pur_e_date']))
												{
													$end_date = $_SESSION['pur_e_date'];
												}
										  ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$start_date?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$end_date?>">
											 </div>     
									</div>
								
								</div>
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
													<th>Status</th>
													<th>Proforma Invoice</th>
													<th>Purchase Order no</th>
													<th>Date</th>
													<th>Supplier Name</th>
													<th>Total Amount</th>
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
			'All': ['01-01-1970',$('#e_date').val()],
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
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
			"bAutoWidth" 	: false,
			"bFilter" 		: true,
			"bSort" 		: true,
			"aaSorting": [[0]],         
				"aoColumns": [
						{ "bSortable": false },
						{ "bSortable": true },
						{ "bSortable": true },
						{ "bSortable": true },
						{ "bSortable": true },
						{ "bSortable": true },
						{ "bSortable": false }
				], 
			"bProcessing"	: true,
			"searchDelay"	: 350,
			"bServerSide" 	: true,
			"bDestroy"		: true,
			"oLanguage"		: {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "NO DATA ADDED YET !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root+'purchaseorder_listing/fetch_record/',
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
function delete_record(purchase_order_id,production_mst_id)
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
              url: root+'purchaseorder_listing/deleterecord',
              data: {
                "purchase_order_id" : purchase_order_id,
                "production_mst_id"	: production_mst_id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'purchaseorder_listing'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function view_detail(id)
{
	 
	$.ajax({ 
        type: "POST", 
        url: root+"purchaseorder_listing/viewproductdetail",
              data: {
                "id": id
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