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
									Production List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Production List
								<a href="<?php echo base_url('order_sheet'); ?>" style="float:right;" type="button" class="btn btn-info">
								Order List
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
									Production List
							 	</div>
								 <div class="panel-body">
									<div class="col-md-8">
										<label class="col-md-2 control-label "><strong class="pull-right"> Select Date</strong></label>
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
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
													 
													<th>SrNo</th>
													<th>Production Date</th>
													<th>Production Time</th>
													<th>Product Name</th>
													<th>Size</th>
													<th>Design </th>
													<th>Finish</th>
												 	<th>Boxes</th>
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
<script type="text/javascript">
$(".select2").select2({
	width:'100%'
});
 
$(document).ready(function (){
	 
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
			"aaSorting": [[0]],         
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
               
                { "bSortable": false }
            ],   
			"bProcessing": true,
			"searchDelay": 350,
			"bServerSide" : true,
			"bDestroy": true,
			<!--"dom": '<"wrapper"flipt>',
			-->
			"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "NO DATA ADDED YET !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root+'producation_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "invoice_status" , "value" :  $("input[name='invoice_status']:checked").val()},{ "name" : "date" , "value" :  $("#daterange"). val()} ,{ "name" : "cust_id" , "value" :  $("#cust_id"). val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});

		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}
function delete_record(producation_id)
{
	main_delete(producation_id,'producation_list/deleterecord','Producation_list')
}
</script>