<?php 
$this->view('lib/header'); 
 $form = "Forwarer Contact"; 
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
									<a href="<?=base_url()?>forwarer_master"> Forwarer MASTER </a>
								</li>
								<li class="active">
									<?=$form?> List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3><?=$form?> List  </h3>
						</div>
					</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add <?=$form?>
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="epcg_add" id="epcg_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Contact Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Contact Name" id="Contact_Name" class="form-control" name="Contact_Name" value="" required title="Contact Name" autocomplete="off" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Department
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Department" id="Department" class="form-control" name="Department" value="" autocomplete="off" required title="Department" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Contact Number
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Contact Number" id="Contact_Number" class="form-control" name="Contact_Number" value="" autocomplete="off" required title="Contact Number" >
											</div>
										</div>
										<div class="form-group col-md-12" >
											<button type="submit" class="btn btn-success">
												Save
											</button>
											<a href="<?=base_url()?>forwarer_master" class="btn btn-danger">
												Cancel
											</a>
										</div>
										<input type="hidden" name="supplier_id" id="supplier_id"  value="<?=$supplier_id?>"  />
									 </form>
								</div>
							</div>
							 
						</div>
					 
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								<?=$form?> List
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Contact Name</th>
													<th>Department</th>
													<th>Contact Number</th>
												 	<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											<?php 
										$m=1;
										 
											for($i=0; $i<count($epcgdata);$i++)
											{
												 
											?>
												<tr>
													<td><?=$m?></td>
													 <td><?=$epcgdata[$i]->Contact_Name?></td>
													 <td><?=$epcgdata[$i]->Department?></td>
													 <td><?=$epcgdata[$i]->Contact_Number?></td>
													 <td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_product(<?=$epcgdata[$i]->contact_id?>);"><i class="fa fa-pencil"></i> Edit</a>
																		</li>
																		<?php 
																		if($epcgdata[$i]->total_cnt==0)
																		{
																		?>
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$epcgdata[$i]->contact_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
																	 	</li>
																		<?php 
																		}
																		?> 
																	  </ul>
																	</div>
													 
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
				
				 
				 
				</div>
			</div>
			 
		</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Contact </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
						Contact Name
					</label>
					<div class="col-sm-12">
						<input type="text" placeholder="Contact Name" id="Contact_Name_details" class="form-control" name="Contact_Name" value="" required title="Contact Name" autocomplete="off" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
						Department
					</label>
					<div class="col-sm-12">
						<input type="text" placeholder="Department" id="Department_details" class="form-control" name="Department" value="" autocomplete="off" required title="Department" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
						Contact Number
					</label>
					<div class="col-sm-12">
						<input type="text" placeholder="Contact Number" id="Contact_Number_details" class="form-control" name="Contact_Number" value="" autocomplete="off" required title="Contact Number" >
					</div>
				</div>
			
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="edit_supplier_id" id="edit_supplier_id" value="<?=$supplier_id?>" />
			 </form>
        </div>
    </div>
</div>

		 
<?php $this->view('lib/footer'); ?>
<script>
$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   
			});
		});
 
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 $("#epcg_add").validate({
		rules: {
			epcg_no: {
				required: true
			}
		},
		messages: {
			epcg_no: {
				required: "Enter EPCG Detail"
			}
		}
	});
function delete_record(deleleid)
{
	main_delete(deleleid,'forwarer_contact_list/deleterecord','forwarer_contact_list/index/'+<?=$supplier_id?>)
}
$("#epcg_add").validate({
		rules: {
			epcg_no: {
				required: true
			}
		},
		messages: {
			epcg_no: {
				required: "Enter EPCG Detail"
			}
		}
	});

$("#edit_form").validate({
	rules: {
		edit_epcg_detail: {
			required: true
		}
	},
	messages: {
		edit_epcg_detail: {
			required: "Enter EPCG Detail"
		}
	}
});
$("#epcg_add").submit(function(event) {
	event.preventDefault();
	if(!$("#epcg_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url : root+'forwarer_contact_list/manage',
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
				   $("#series_add").trigger('reset');
				   unblock_page("success","Sucessfully Inserted.");
				   setTimeout(function(){ window.location=root+'forwarer_contact_list/index/'+<?=$supplier_id?> },1500);
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","Contact Name Already Exits.");
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
            url: 	root+'forwarer_contact_list/edit_record',
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
				     unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'forwarer_contact_list/index/<?=$supplier_id?>' },1500);
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


function edit_product(supplie_epcg_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"forwarer_contact_list/fetchdata",
              data: {"id": supplie_epcg_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(supplie_epcg_id);
				 	$("#Contact_Name_details").val(obj.Contact_Name);
				 	$("#Department_details").val(obj.Department);
					 $("#Contact_Number_details").val(obj.Contact_Number);
				   
					unblock_page("",""); 
                  }
              
          }); 

}		

</script>