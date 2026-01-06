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
							Container Loading
						</li>
						
					</ol>
					<div class="page-header">
						<h3>
							Container Loading
							<a href="<?php echo base_url('container_loading'); ?>" style="float:right;" type="button" class="btn btn-info">
							+ Add Container 
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
						Container Loading
						</div>
						<div class="panel-body">
						<div class="col-md-6">
									<label class="col-md-5 form-group" style="">
										<strong class=""> Select Status</strong>
									</label>
									<div class="col-md-6">
									<select class="select2" name="status" id="status"   title="Select Consignee"  onchange="load_data_table();" >
										<option value="">All</option>
										<option value="1">Archive</option>
										<option value="2">Unarchive</option>
										</select>
									</div>     
								</div>
							<div class="table-responsive">
								<table class="table table-bordered table-hover" id="datatable">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>PI NO</th>
											<th>Export Invoice</th>
											<th>Container No</th>
																						
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$m=1;
											for($i=0; $i<count($result);$i++)
											{
												 
											?>
												<tr>
													<td><?=$m?></td>
													<td><?=$result[$i]->pi_no?></td>
													<td><?=$result[$i]->export_invoice?></td>
													<td><?=$result[$i]->container_no?></td>
													
													<td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																	  
																	  
																			<li>
																				<a class="tooltips" data-title="Edit" href="<?=base_url().'Container_loading/form_edit/'.$result[$i]->container_loading_id?>"><i class="fa fa-pencil"></i>Edit</a>
																			</li>
																		
																			
																			
																			<?php 
																			
																			if($result[$i]->status==0)
																			{
																				echo '<li>
																								<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$result[$i]->container_loading_id.',2)" ><i class="fa fa-archive"></i> Archive</a>
																							</li>';
																				
																
																			}	
																			else
																			{
																				echo '<li>
																									<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$result[$i]->container_loading_id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
																								</li>';
																			}
																			
																				// if($result[$i]->upload_logo != "No file")
																				// {
																					// echo '<li><a class="tooltips" name="upload_logo" id="upload_logo"  data-toggle="tooltip"  data-title="View" 
																					// href="'.base_url().'/upload/agreement_doc/'.$result[$i]->upload_logo.'" target="_blank"><i class="fa fa-eye"></i>View Agreement</a></li>';
																					
																					// echo '<li><a class="tooltips" name="upload_logo" id="upload_logo"  data-toggle="tooltip"  data-title="View" 
																					// href="'.base_url().'Agent_list/download/'.$result[$i]->upload_logo.'" target="_blank"><i class="fa fa-download"></i>Download Agreement</a></li>';
																																									
																				// }
																		
																				// else{
																					// $result[$i]->upload_logo = " ";
																				// }				
																				
																				?>
																				
																			<li>
																				<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$result[$i]->container_loading_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
																			</li>
																				
																	
																	 </ul>
														</div>
													 
													</td>
													
												</tr>
										<?php
											$m++;
										} ?>
												
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

load_data_table();
 
function load_data_table()
{
datatable = $("#datatable").dataTable({
	
	   "order": [[ 0, "asc" ]],
	   "lengthMenu": [ 50, 10, 25, 75, 100 ],
	   "createdRow": function(row, data, dataIndex ) {
			if(data[4].indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             

			},
	   'columnDefs': [
		{
			"targets": 0, // your case first column
			"className": "text-center",
			"width": "4%"
		}]
	});

}

function archive_record(id,status)
{
	Swal.fire({
  title: 'Are You Sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'Container_list/archive_record',
              data: {
                "id"	 : id,
				"status" : status
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					if(status == 0)
					{
						unblock_page('success',"Agent successfully unarchived");
					}
					else
					{
						unblock_page('success',"Agent successfully archived");
					}
					setTimeout(function(){ window.location=root+'container_list'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
	 
}



// for update
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
            url: 	root+'Conatiner_loading/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_label_id").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				  
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Container_loading' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#company_document_form").trigger('reset');
					$(".select2").select2('val','');
				    
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

// edit form hover
function edit_product(id)
{
	block_page();
	
     $.ajax({ 
              type: "POST", 
              url: root+"Container_loading/fetchcdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_pi_no").val(obj.pi_no);
					 					 					 			
					 $("#edit_export_invoice").val(obj.export_invoice);
					 
					 $("#edit_container_no").val(obj.container_no);
					 
								
					if(obj.upload_logo === "No file")
					{
						$("#shipping_file_view").hide();
						$("#shipping_file_download").hide();
						
						
					}
				
					else if(obj.upload_logo === "")
					{
						$("#shipping_file_view").hide();
						$("#shipping_file_download").hide();	
					}
					
					else
					{
						$("#shipping_file_view").show();
						$("#shipping_file_download").show();
						
						$("#shipping_file_view").attr("href",root+'upload/shipping_logo/'+obj.shipping_logo);
						$("#shipping_file_download").attr("href",root+'Shippingmaster/download/'+obj.shipping_logo);
						
												
					}
					
					 
					 $("#editdocumentmode").val(obj.shipping_line_name);
				 	unblock_page("",""); 
                  }
              
          }); 

}
	
function delete_record(deleleid)
{
	 main_delete(deleleid,'Container_list/deleterecord','container_list')
}

function delete_image(deleleid)
{
	main_delete(deleleid,'Container_list/delete_image','container_list')
	
}
</script>