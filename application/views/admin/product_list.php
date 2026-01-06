<?php 
$this->view('lib/header'); 
$_SESSION['beenhere'] = 1;
$form = 'Product Size';
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
								<a href="#">Product&nbsp;&nbsp; </a>   /  &nbsp;&nbsp; <?=$form?>  
								</li>
								
							</ol>
							
							<div class="page-header title1">
									<h3>View <?=$form?> </h3>
									<div class="pull-right form-group" style="margin-top:-39px;">
									
										<div class="pull-right">
										
											<a href="<?php echo base_url('Model_list/index/'); ?>"  type="button" class="btn btn-primary">
												Design
											</a>
											<a href="<?php echo base_url('Finish_list/index/'); ?>"  type="button" class="btn btn-primary">
												Finish
											</a>
											 <a href="<?php echo base_url('Series_list/index/'); ?>"  type="button" class="btn btn-primary">
												Product
											</a>
											
											<a href="<?php echo base_url('Calculation/index/'); ?>"  type="button" class="btn btn-primary">
												Calculator
											</a>
											 <a href="<?php echo base_url('add_product'); ?>"   type="button" class="btn btn-info ">
												+ Product Size
											</a>
											
										</div>
								</div>
							</div>
							
						</div>
					</div>
					  <div class="row" style="margin-top:30px;">
							<div class="col-md-8" style="margin-bottom: 5px;">
						 		<label class="col-md-4 control-label" style="margin-top: 5px;">
										<strong class=""> Select Product</strong>
									</label>
						 		 <div class="col-md-4">
										 <select class="select2" id="series_id" name="series_id" onchange="load_data_table()" >
											<option value="">All Product</option>
												<?php
												for($p=0;$p<count($allproduct);$p++)
												{
												?>
													<option value="<?=$allproduct[$p]->series_id?>"><?=$allproduct[$p]->series_name?></option>
												<?php
												}
												?>
										</select>
						 		 </div>     
						 	</div>
							 
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
													<th>SR No</th>
													<th>Size In CM</th>
													<th>Size In MM</th>
													<th>Product Name</th>
													<th>HSN Code</th>
													<th>Thickness </th>
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
 <div id="çalculation_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Packing Detail <span id="product_detail"></span></h4>
            </div>
            <div class="modal-body">
				
					<div id="responsehtml"></div>
			 
				 
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
 
<script type="text/javascript">
 $(".select2").select2({
	width:'100%'
});
function do_calc(id,hsnc_code)
{
	block_page();
	$.ajax({ 
              type: "POST", 
              url: root+'calculation/displaydatanew',
              data: {
                "id": id,
				"hsnc_code":hsnc_code
              }, 
              cache: false, 
              success: function (data) { 
				$("#çalculation_modal").modal({
						backdrop: 'static',
						keyboard: false
					});
				 $("#responsehtml").html(data)
				 unblock_page("","")
              }
			});
}
$(document).ready(function () {
	 	load_data_table();	
});
function load_data_table()
{
	
	var datatable = $("#datatable").DataTable({
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
					"sEmptyTable": "No Records found in Database - Please add new record using entry form !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center plusbtn",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'product_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{"name" : "series_id","value" : $("#series_id").val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		 $('#datatable tbody').on('click', 'td.plusbtn', function () {
		  
		var tr = $(this).closest('tr');
		var tr1 = $(this).closest('tr').find('td.plusbtn .plusbtnhtml');
		var tr2 = $(this).closest('tr').find('td.plusbtn');
		 
        var row = datatable.row( tr );
		 var value = tr1.attr("value");
		 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr1.attr("data-original-title",'Show Packing');
            tr1.html('<i class="fa fa-plus"></i>');
        }
        else {
            // Open this row
			 tr1.attr("data-original-title",'Hide Packing');
             tr1.html('<i class="fa fa-minus"></i>');
			 var inner_table = '<table  id="detail'+value+'" class="table table-bordered table-hover display" width="100%">'+
						'<thead>'+
							'<tr>'+
								'<th>SR No</th>'+
								'<th>Size</th>'+
								'<th>Packing Name</th>'+
								'<th>Box Per Pallet</th>'+
								'<th>No Of Pallet</th>'+
								'<th>Boxes Per Container</th>'+
								'<th>SQM Per Container</th>'+
								'<th>Action</th>'+
							'</tr>'+
						'</thead>'+
						'<tbody>'+
						'</tbody>'+
					'</table>';
			 
			 row.child(inner_table).show();
			set_datatable(value);
			 
		 }
    } );
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
} 
function set_datatable(value)
{
	  
				datatable1 = $("#detail"+value).dataTable({
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
										"sAjaxSource": root+'product_packing_list/fetch_record/',
										"fnServerParams": function ( aoData ) {
											aoData.push( { "name": "mode", "value": "fetch" },{"name" : "product_id","value" : value});
										},
										"fnDrawCallback": function( oSettings ) {
											$('.ttip, [data-toggle="tooltip"]').tooltip();
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
              url: root+'product_list/deleterecord',
              data: {
                "id": id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'product_list'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function view_packing_detail(id,productname)
{
	block_page();
	$.ajax({ 
              type: "POST", 
              url: root+'product_list/displaydataprice',
              data: {
                "id": id 
              }, 
              cache: false, 
              success: function (data) { 
				$("#çalculation_modal").modal({
						backdrop: 'static',
						keyboard: false
					});
				 $("#product_detail").html(" ("+productname+")")
				 $("#responsehtml").html(data)
				 unblock_page("","")
              }
			});
}
 
</script>