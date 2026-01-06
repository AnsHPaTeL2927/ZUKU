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
									Expense Payment List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Expense Payment List
								<div class="pull-right">
								  <a href="<?php echo base_url('add_expensepayment'); ?>"  type="button" class="btn btn-info">
								+ Expense Payment
								</a>
								</div>
							</h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Expense Payment List
									
								</div>
								<div class="panel-body" >
									   <div class="col-md-4">
										<label class="col-md-3 control-label "><strong class="pull-right"> Expense Date</strong></label>
										 <div class="col-md-9">
										<?php 
											$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
											
											$invoicedate = explode(" - ",$year);
										?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
										 </div>     
									</div>
									
									<label class="col-md-2 control-label" style="margin-top: 5px;">
									<strong class=""> Select Payment Party</strong>
									</label>
									<div class="col-sm-2">
										<select class="select2" name="paymentdata" id="paymentdata" required title="Select Payment Party" onchange="load_data_table()" >
											<option value="">All Payment Party</option>
											<?php
											for($p=0;$p<count($payment_data);$p++)
											{
													$sel = '';
													if($payment_data[$p]->expense_payment_id == $_SESSION['get_paymentdata'])
													{
														$sel = 'selected="selected"';
													}
												echo "<option ".$sel." value='".$payment_data[$p]->expense_party_id."'>".$payment_data[$p]->party_name." </option>";
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
												 	<th>Payment Date</th>
													<th>Payment Party</th>
													<th>Payment Mode</th>
													<th>Reference No</th>
													<th>Amount</th>
													<th>Kasar Amount</th>
													<th>TDS Amount</th>
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
<script type="text/javascript">
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
			"sAjaxSource": root+'expense_payment_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name" : "date" , "value" :  $("#daterange"). val()},{ "name" : "paymentdata" , "value" :  $("#paymentdata"). val()} );
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
					  
                    return  parseFloat(a) + parseFloat(b.replace(/(<([^>]+)>)/gi, "").replace(new RegExp(',', 'g'),""));
                }, 0 );
				 
				 // Total over this page
					pageTotal1 = api
						.column( 6, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'),""));
                }, 0 );
				// Total over this page
					pageTotal2 = api
						.column( 7, { page: 'current'} )
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
			$( api.column( 7 ).footer() ).html(
                 numberWithCommas(pageTotal2.toFixed(2))
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
              url: root+'expense_payment_list/deleterecord',
              data: {
                "id"			: id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'expense_payment_list'; },1500);
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