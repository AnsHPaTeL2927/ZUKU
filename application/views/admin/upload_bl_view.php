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
									BL MASTER
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								<!-- CHA MASTER
								 <a href="<?php echo base_url('add_cha'); ?>" style="float:right;" type="button" class="btn btn-info">
								+ CHA  
								</a> -->
							 </h3>
							
						</div>
					</div>
					</div>
					<div class="row">
						 <div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								BL MASTER
								 </div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													
													<th>BL Number</th>
													<th>BL Type</th>
													<th>Date</th>
													<th>Remark</th>
													<th>Uploaded BL</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											<?php 
										$m=1;
											 
											?>
												<tr>
													<td><?=$m?></td>
													
													<td><?=$result->bl_number?></td>
													<td><?=$result->bl_type?></td>
													<td><?=date('d/m/Y',strtotime($result->date))?></td>
													<td><?=$result->remark?></td>
													<td><a href="<?=base_url()?>upload/<?=$result->bl_upload?>" target="_blank">View Upload</a></td>
													<td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="<?=base_url().'upload_bl/form_edit/'.$result->id?>" ><i class="fa fa-pencil"></i>Edit</a>
																		</li>
																		
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$result->id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
																	 	</li>
																		
																		
																	   </ul>
																	</div>
													 
													</td>
													
												</tr>
										<?php
											$m++;
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
 
		 
<?php $this->view('lib/footer'); ?>
<script>
$(document).ready(function () {
	$('#sample-table-1').DataTable({
	   "order": [[ 0, "asc" ]],
	   "lengthMenu": [ 50, 10, 25, 75, 100 ],
	   'columnDefs': [
		{
			"targets": 0, // your case first column
			"className": "text-center",
			"width": "4%"
		}]
	});
});
 
function delete_record(deleleid)
{
	main_delete(deleleid,'upload_bl/deleterecord','exportinvoice_listing')
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