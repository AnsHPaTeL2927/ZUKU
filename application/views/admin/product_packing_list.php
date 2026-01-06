<?php 
$this->view('lib/header'); 
$_SESSION['beenhere'] = 1;
$thickness = (!empty($product_data->thickness))?' - '.$product_data->thickness.' MM':"";
$form = 'Packing Of '.$product_data->series_name.' - '.$product_data->size_type_cm.$thickness;
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
								<li>
									<a href="<?=base_url()?>product_list">
										Product List
									</a>
								</li>
								<li class="active">
								  <?=$form?>  
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								 <?=$form?>   
								<a href="<?php echo base_url('add_product/add_packing_detail/'.$product_data->product_id); ?>"   type="button" class="btn btn-info pull-right">
									+ Packing  
								</a>
							</h3>
						  </div>
						</div>
					</div>
					  <div class="row">
					 	<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
													<th>SR No</th>
													<th>Size</th>
													<th>Packing Name</th>
													<th>Box Per Pallet</th>
													<th>No Of Pallet</th>
													<th>Boxes Per Container</th>
													<th>SQM Per Container</th>
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
			"sAjaxSource": root+'product_packing_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{"name" : "product_id","value" : <?=$product_data->product_id?>});
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
              url: root+'product_packing_list/deleterecord',
              data: {
                "id": id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'product_packing_list/index/<?=$product_data->product_id?>'; },1500);
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