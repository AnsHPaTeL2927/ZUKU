<?php 
$this->view('lib/header'); 
?>	
<script>
function view_pdf(no)
{
	window.open(root+"Pi_designdetails/view_pdf", '_blank');
}
</script>
<div class="main-container">
	<?php $this->view('lib/sidebar'); ?>
	<div class="main-content">
		<div class="container">
			 <div class="row">
			 	<div class="col-sm-12">
			 		<ol class="breadcrumb">
			 			<li>
			 				<i class="clip-pencil"></i>
			 				<a href="<?=base_url()?>dashboard">Dashboard</a>
			 			</li>
			 			<li class="active">
			 				<a href="javascript:void(0)">PI Design Details List</a>
			 			</li>
			 	 	</ol>			 		
			 	</div>
			 </div>

			 <div class="row">
				<br>
					 <div class="pull-right form-group">
									<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									<a class="btn btn-warning tooltips" href="<?= base_url('pi_designdetails/create_order_sheet_excel') ?>" target="_blank"><i class="fa fa-file-excel-o"></i> Export Excel</a>
					 </div>
				 	</div>
			 	<div class="col-sm-12">
			 		<div class="panel panel-default">
			 			<div class="panel-heading">
			 				<i class="fa fa-external-link-square"></i>
			 			</div>
                         <div class="">
			 			   <div class="panel-body form-body">
								<div class="col-md-4">
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Customer</strong></label>
										<div class="col-md-6">
											<select class="select2" name="cust_id" id="cust_id" onchange="load_order_sheet()">
												<option value="">All Customer</option>
												<?php
													foreach($documentdata as $cust_data)
													{
														echo '<option value="'.$cust_data->id.'">'.$cust_data->c_companyname.'</option>';

													}
												?>
											</select>
										</div>     
								</div>
								 <div class="col-md-4">
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Size</strong></label>
										<div class="col-md-6">
											<select class="select2" name="size_id" id="size_id" onchange="load_order_sheet()">
												<option value="">All Size</option>
												<?php
													foreach($pi_sizes as $keys => $sizedata)
													{
														echo '<option value="'.$sizedata['size_type_cm'].'">'.$sizedata['size_type_cm'].'</option>';														
													}
												?>
											</select>
										</div>     
								</div>
							<div class="col-md-4">
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Finish</strong></label>
										<div class="col-md-6">
											<select class="select2" name="finish_id" id="finish_id" onchange="load_order_sheet()">
												<option value="">All Finish</option>
												<?php
													foreach($all_finish_data as $finish_row)
													{
														echo '<option value="'.$finish_row->finish_id.'">'.$finish_row->finish_name.'</option>';
													}
												?>
											</select>
										</div>     
								</div>

								<div class="col-md-4">
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select PI No.</strong></label>
										<div class="col-md-6">
												<!-- onchange="load_order_sheet()" -->
											<select class="select2" name="pi_no" id="pi_no" onchange="load_order_sheet()">
												<option value="">All PI No.</option>
												<?php													
													foreach($pi_numbers as $key =>$pi_no_data)
													{
														echo '<option value="'.$pi_no_data['pi_no'].'">'.$pi_no_data['pi_no'].'</option>';
													}
												?>
											</select>
										</div>     
								</div>
								
								<!--<div class="col-md-4">
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Product Name</strong></label>
										<div class="col-md-6">
												
											<select class="select2" name="series_id" id="series_id" onchange="load_order_sheet()">
												<option value="">All Product</option>
												<?php													
													
													foreach($series_name as $series_name_data)
													{
														echo '<option value="'.$series_name_data->series_id.'">'.$series_name_data->series_name.'</option>';

													}
												?>
											</select>
										</div>     
								</div>-->

								<div class="col-md-4">
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Design</strong></label>
										<div class="col-md-6">
												<!-- onchange="load_order_sheet()" -->
											<select class="select2" name="model_design_id" id="model_design_id" onchange="load_order_sheet()">
												<option value="">All Design</option>
												<?php													
													foreach($pi_designs as $dkey =>$pi_design_data)
													{
														echo '<option value="'.$pi_design_data['model_design_id'].'">'.$pi_design_data['model_name'].'</option>';
													}
												?>
											</select>
										</div>     
								</div>
								<div class="panel-body">
									<div class="order_sheet" style="margin-top: 70px;"></div>
								</div>								
						   </div>
						 </div>
                     </div>
				 </div>
			 </div>
		</div>
	</div>
</div>

 <div id="myModal" name="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">  Order Sheet Edit </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-4 " for="form-field-1">
						Production Complete No:
						</label>
						<div class="col-sm-4">
							<input type="number" placeholder="00" class="form-control" name="production_complete" id="edit_production_complete" value="0" autocomplete="off" step="1">
						</div>
						<input type="hidden" name="pi_detail_id" id="edit_pi_id" value="" />
					</div>
			   </div>
            <div class="modal-footer">
				<button name="Submit" type="button" onclick="edit_product()"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>					
			 </form>
        </div>
    </div>
</div>

<?php 
$this->view('lib/footer');
?>

<script>
$(".select2").select2({
	width:"100%"
});

function reload()
{
	location.reload();
}

 $('.timepicker').datetimepicker({
      format: 'HH:ii P',
	  autoclose: false,
      showMeridian: true,
      startView: 1,
      maxView: 1,
	  sideBySide: true,
    });

$('.datetimepicker-hours thead').attr('style', 'display:none;');
$('.datetimepicker-hours table').attr('style', 'width:100%');
$('.datetimepicker-minutes thead').attr('style', 'display:none;');
$('.datetimepicker-minutes table').attr('style', 'width:100%');	

$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
 }); 

load_order_sheet();
// function load_order_sheet()
// {
// 			block_page(); 	
// 			$(".order_sheet").html('')
// 			  $.ajax({ 
//               type: "POST", 
//               url: root+'Pi_designdetails/get_order_sheet',
//               data: {
//                 "size"		: $("#size_id").val(),
//                 "finish_id"	: $("#finish_id").val(),
// 				"cust_id"	: $("#cust_id").val(),
// 				"pi_no"     : $("#pi_no").val(),
// 				"model_design_id" : $('#model_design_id').val()

//               }, 
//               cache: false, 
//               success: function (data) { 
// 					$(".order_sheet").html(data);
// 					$(".tooltips").tooltip()
// 				 	unblock_page('',"");
//               }
// 			});
// }
function load_order_sheet()
{
	 
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'pi_designdetails/get_order_sheet',
              data: {
                "size"		: $("#size_id").val(),
                "finish_id"	: $("#finish_id").val(),
				"cust_id"	: $("#cust_id").val(),
				"pi_no"     : $("#pi_no").val(),
				"model_design_id" : $('#model_design_id').val()
              }, 
              cache: false, 
              success: function (data) { 
				 
					$(".order_sheet").html(data);
					$(".tooltips").tooltip()
				 	unblock_page('',"");
					 
              }
			});
		 
}

function customer_report()
{
 	block_page(); 	
	$(".view_report").html('')	
	$.ajax({          
		type: "POST",          
		url: root+'view_confirm_order/view_report',         
		data: {          
			"customer_id" 	: $("#customer_id").val(), 
			"finish_id" 	: $("#finish_id").val(), 
			"pallet_type" 	: $("#pallet_type").val(), 
			"daterange" 	: $("#daterange").val(), 
			"size_id" 		: $("#size_id").val() 
		}, 		
		cache: false, 		
		success: function (data) { 			
			$(".view_report").html(data)			
			unblock_page("","")		
		}	
	});
}

function show_modal(id,production_complete) {
	$('#edit_pi_id').val(id);
	$('#edit_production_complete').val(production_complete);
	$('#myModal').modal('show');
}


function delete_row(id)
{
	Swal.fire({
	  title: 'You want to Delete?',
	  type: 'info',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, confirm it!'
	}).then((result) => {
		if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'Pi_designdetails/delete_row',
              data: {
                "id": id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Row Sucessfully deleted.");
					load_order_sheet()
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		}
	});
}

function change_qc_status(id) {
	change_row_status(id,'qc_status');
}

function change_pallatazation_status(id) {
	change_row_status(id,'pallatazation_status');
}

function change_row_status(id,field)
{
	Swal.fire({
	  title: 'You want to Change?',
	  type: 'info',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, confirm it!'
	}).then((result) => {
		if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'Pi_designdetails/change_row_status',
              data: {
                "id": id,
                "field":field
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Status changed sucessfully.");
					load_order_sheet()
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		}else{
			if(field == 'qc_status')
			{
				$('#q'+id).prop('checked', false);
			}

			if(field == 'pallatazation_status')
			{
				$('#p'+id).prop('checked', false);
			}
			 
		}
	});
}


// edit form hover
function edit_product()
{
	var id = $('#edit_pi_id').val();
	var production_complete = $('#edit_production_complete').val();
	block_page();
     $.ajax({ 
          type: "POST", 
          url: root+"Pi_designdetails/edit_production_complete",
          data: {"id": id, "production_complete":production_complete}, 
          success: function (response) { 
               var obj = JSON.parse(response);
			   $("#myModal").modal('hide');
			 	unblock_page("","");
			 	load_order_sheet(); 
              }
      }); 
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;

    return true;

}
</script>