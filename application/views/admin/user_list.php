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
									User List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								User List
								<?php 
																		if($this->session->id == 1)
																		{
																			?>
								 <a href="<?php echo base_url('add_user'); ?>" style="float:right;" type="button" class="btn btn-info">
								+ User  
								</a>
								<?php
																		}
																		?>
							 </h3>
							
						</div>
					</div>
					</div>
					<div class="row">
						 <div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								User List
								 </div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>User Name</th>
													<th>Address</th>
													<th>Mobile No</th>
													<th>Email ID</th>
											 		<th>User Type</th>
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
													<td><?=$result[$i]->user_name?></td>
													<td><?=$result[$i]->address?></td>
													<td><?=$result[$i]->mobile_no?></td>
													<td><?=$result[$i]->email?></td>
												 	<td><?=$result[$i]->user_type?></td>
														<?php 
																		if($this->session->id == 1)
																		{
																			?>
													<td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="<?=base_url().'add_user/edit/'.$result[$i]->user_id?>" ><i class="fa fa-pencil"></i> Edit</a>
																		</li>
																		
																		
																	
																			<li>
																				<a class="tooltips" onclick="assign_customer(<?=$result[$i]->user_id?>)" data-title="Assign Customer" href="javascript:;" ><i class="fa fa-user-plus"></i> Assign Customer</a>
																			</li>
																			<li>
																				<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$result[$i]->user_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
																			</li>
																			
																		
																		
																    </ul>
																	</div>
													 
													</td>
													<?php
													}
																		?>
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
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Customer</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="assign_customer_form" id="assign_customer_form">
				<div class="modal-body">
				 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
						Assigned Customer 
					 	</label>
					 	<div class="col-sm-12">
					 		<div class="assign_customer_list"></div> 
					 	</div>
					</div>
					 <div class="form-group">
					 	<label class="col-sm-8 control-label" for="form-field-1">
							Select Customer
					 	</label>
						<label class="col-sm-4 pull-right" for="form-field-1">
								<input type="checkbox" name="all_cust_id" id="all_cust_id" onclick="select_all(this.checked)" value="1"/> <label for="all_cust_id">Select All </label>
					 	</label>
					 	<div class="col-sm-12">
					 		<select multiple name="customer_id[]" id="customer_id" class="select2">
								 
							</select>
					 	</div>
					</div>
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="user_id" id="user_id" />
			 </form>
        </div>
    </div>
</div>
<script>
function select_all(value)
{
	 
	if(value== true)
	{
		$("#customer_id").find('option').prop("selected",true);
        $("#customer_id").trigger('change');
		 
	}
	else
	{
		 $("#customer_id").find('option').prop("selected",false);
        $("#customer_id").trigger('change');
	}
}
$("#assign_customer_form").validate({
		rules: {
			supplier_name: {
				required: true
			} 
		},
		messages: {
			supplier_name: {
				required: "Enter Name"
			} 
		}
	});
$("#assign_customer_form").submit(function(event) {
	event.preventDefault();
	if(!$("#assign_customer_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'user_list/assignmanage',
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
				    $("#assign_customer_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					assign_customer(obj.user_id)
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'cha_master'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'cha_master'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 

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
function assign_customer(user_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"user_list/fetchcustmer_data",
              data: {"user_id": user_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				     $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$(".select2").select2({
						width: '100%',
						placeholder:'Select Customer'
					});
				  $("#customer_id").html(obj.cust_data);
				  $("#user_id").val(user_id);
				  $(".assign_customer_list").html(obj.assigncust);
				     
					unblock_page("",""); 
                  }
              
          });
}
function delete_record(deleleid)
{
	main_delete(deleleid,'user_list/deleterecord','user_list')
}
 function reamove_assign_customer(deleleid,user_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"user_list/remove_cust_record",
              data: {"id": deleleid}, 
              success: function (response) { 
                   
					var obj= JSON.parse(response);
						$(".loader").hide();
						if(obj.res==1)
						{
							$("#assign_customer_form").trigger('reset');
							unblock_page("success","Sucessfully Removed.");
							assign_customer(user_id)
						}
					 	else
						{
							unblock_page("error","Something Wrong.") 
						}
					unblock_page("",""); 
                  }
              
          });
	 
} 
</script>