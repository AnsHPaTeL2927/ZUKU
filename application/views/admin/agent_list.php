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
							Agent 
						</li>
						
					</ol>
					<div class="page-header">
						<h3>
							Agent 
							<a href="<?php echo base_url('agentmaster'); ?>" style="float:right;" type="button" class="btn btn-info">
							+ Add New Agent  
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
						Agent 
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
											<th>Agent Name</th>
											<th>City</th>
											<th>Bank Account No</th>
											<th>Bank Details</th>
											<th>Status</th>
											
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
													<td><?=$result[$i]->agent_name?></td>
													<td><?=$result[$i]->city?></td>
													<td><?=$result[$i]->bank_ac_no?></td>
													<td><?=$result[$i]->bank_details?></td>
													<td><?php
													  	if($result[$i]->status==0)
																{
																?>
                                                                      Active
                                                                      <?php 
																}
																else
																{
																?>
                                                                      Deactived
                                                                      <?php 
																
																
																}
																
																?>
													   </td>
												
													
													<td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																	  
																					<li>
																						<a class="tooltips" data-title="Edit" href="<?=base_url().'Agentmaster/form_edit/'.$result[$i]->id?>" ><i class="fa fa-pencil"></i>Edit</a>
																					</li>
																			<?php 
																			
																			if($result[$i]->status==0)
																			{
																				echo '<li>
																							<a class="tooltips" data-title="Detele" onclick="delete_record('.$result[$i]->id.')" href="javascript:;"><i class="fa fa-trash"></i> Detele</a>
																						</li>';
																						
																			
																				echo '<li>
																					<a class="tooltips" data-title="Edit" href="javascript:;" onclick="change_status('.$result[$i]->id.',1);"><i class="fa fa-check-square"></i> Click to Deactive</a>
																					</li>';
																							
																				if($result[$i]->agreement_logo != "No file")
																				{
																					echo '<li><a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
																					href="'.base_url().'/upload/agreement_doc/'.$result[$i]->agreement_logo.'" target="_blank"><i class="fa fa-eye"></i>View Agreement</a></li>';
																					
																					echo '<li><a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
																					href="'.base_url().'Agent_list/download/'.$result[$i]->agreement_logo.'" target="_blank"><i class="fa fa-download"></i>Download Agreement</a></li>';
																																									
																				}
																		
																				else{
																					$result[$i]->agreement_logo = " ";
																				}
																				
																				if($result[$i]->agreement_logo1 != "No file")
																				{
																					echo '<li><a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
																					href="'.base_url().'/upload/agreement_doc/'.$result[$i]->agreement_logo1.'" target="_blank"><i class="fa fa-eye"></i>View Agreement 1</a></li>';
																					
																					echo '<li><a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
																					href="'.base_url().'Agent_list/download1/'.$result[$i]->agreement_logo1.'" target="_blank"><i class="fa fa-download"></i>Download Agreement 1</a></li>';
																				}
																		
																				else{
																					$result[$i]->agreement_logo1 = " ";
																				}
																				
																				if($result[$i]->agreement_logo2 != "No file")
																				{
																					echo '<li><a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
																					href="'.base_url().'/upload/agreement_doc/'.$result[$i]->agreement_logo2.'" target="_blank"><i class="fa fa-eye"></i>View Agreement 2</a></li>';
																					
																					echo '<li><a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
																					href="'.base_url().'Agent_list/download2/'.$result[$i]->agreement_logo2.'" target="_blank"><i class="fa fa-download"></i>Download Agreement 2</a></li>';
																				}
																		
																				else{
																					$result[$i]->agreement_logo2 = " ";
																				}
																			
																
																			}	
																			else
																			{
																				// echo '<li>
																									// <a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$result[$i]->id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
																								// </li>';
																								
																						echo		'<li>
																									<a class="tooltips" data-title="Edit" href="javascript:;" onclick="change_status('.$result[$i]->id.',0);"><i class="fa fa-square"></i> Click to Active</a>
																								</li>';
																			}
																			
																			?>
																			
																				
																	
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
	
	   "order": [[ 5, "asc" ]],
	   "lengthMenu": [ 50, 10, 25, 75, 100 ],
	   "createdRow": function(row, data, dataIndex ) {
			if(data[6].indexOf('Click to Active') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             if (data[5] == "No" ) {        
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
              url: root+'Agent_list/archive_record',
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
					setTimeout(function(){ window.location=root+'agent_list'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
	 
}

function change_status(id,status)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  
}).then((result) => {
 
  if (result.value) {
	 block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"Agent_list/changestatus",
              data: {
                "id": id,
				"status":status
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					unblock_page('success',"Status Successfully Changed");
					setTimeout(function(){ window.location=root+"agent_list"; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
  }
});
	
}

	
function delete_record(deleleid)
{
	 main_delete(deleleid,'Agent_list/deleterecord','agent_list')
}

function delete_image(deleleid)
{
	main_delete(deleleid,'Agent_list/delete_image','agent_list')
	
}
</script>