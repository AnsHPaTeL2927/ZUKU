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
									<a href="<?=base_url().'user_list'?>">User List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> User </h3>
							</div>
							 
						</div>
					</div>
						<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="supplier_form" id="supplier_form">
               		
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								User Name
						</label>
						<div class="col-sm-4">
							<input type="text" id="user_name" name="user_name" placeholder="User Name" required="" class="form-control" value="<?=$edit_record->user_name?>" />
				        </div>
				    </div> 	
					   <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								  Address
						</label>
						<div class="col-sm-4">
							<textarea id="address" name="address" placeholder="Address" required="" class="form-control" required title="Enter Address"><?=strip_tags($edit_record->address)?></textarea>
						</div>
						</div>
					 	<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Mobile No 
							</label>
							<div class="col-sm-4">
								<input type="text" required id="mobile_no" name="mobile_no" placeholder="Mobile No"  class="form-control"   title="Enter Mobile No" value="<?=strip_tags($edit_record->mobile_no)?>" />
							</div>
						</div>
							<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Email
							</label>
							<div class="col-sm-4">
								<input type="text" required id="email" name="email" placeholder="Email"  class="form-control"   title="Enter Email" value="<?=strip_tags($edit_record->email)?>" />
							</div>
						</div>
						<?php
						if(empty($edit_record))
						{
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Password
							</label>
							<div class="col-sm-4">
								<input type="password" required id="password" name="password" placeholder="Password"  class="form-control"   title="Enter password" value="<?=strip_tags($edit_record->password)?>" />
							</div>
						</div>
						<?php 
						}
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									User Type
							</label>
							<div class="col-sm-4">
								 <select class="form-control" name="usertype_id" id="usertype_id" required title="Enter User Type">
									<option value="">Select User Type</option>
										<?php 
										foreach($usertype as $row)
										{
											$sel = '';
											if($row->usertype_id == $edit_record->usertype_id)
											{
												$sel ='selected="selected"';
											}
											echo "<option ".$sel." value='".$row->usertype_id."'>".$row->user_type."</option>";
										}
										?>
								 </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									User Sign in PI
							</label>
							<div class="col-sm-4">
								<input type="checkbox"   id="sign_pi_status" name="sign_pi_status"  value="1" onclick="show_pi(this.checked)" <?=($edit_record->sign_pi_status == 1)?"checked":""?>/>
							</div>
						</div>
						<div class="pi_html" style="display:none">
						<u><strong>Show In PI</strong></u>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Contact Person Name
							</label>
							<div class="col-sm-4">
								<input type="text" required id="contact_person_name" name="contact_person_name" placeholder="Contact Person Name"  class="form-control"   title="Enter Contact Person Name" value="<?=strip_tags($edit_record->contact_person_name)?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Contact No
							</label>
							<div class="col-sm-4">
								<input type="text" required id="contact_no" name="contact_no" placeholder="Contact No"  class="form-control"   title="Enter Contact No" value="<?=strip_tags($edit_record->contact_no)?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Contact Email
							</label>
							<div class="col-sm-4">
								<input type="text" required id="contact_email" name="contact_email" placeholder="Contact Email"  class="form-control"   title="Enter Contact Email" value="<?=strip_tags($edit_record->contact_email)?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									For Signature Name
							</label>
							<div class="col-sm-4">
								<input type="text" required id="for_signature_name" name="for_signature_name" placeholder="For Signature Name"  class="form-control"   title="Enter For Signature Name" value="<?=strip_tags($edit_record->for_signature_name)?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Authorised Signatory
							</label>
							<div class="col-sm-4">
							 	<textarea class="form-control" style="height:55px;" name="authorised_signatury" id="authorised_signatury" placeholder="Authorised Signatory"><?=strip_tags($edit_record->authorised_signatury)?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Sign Upload
							</label>
							<div class="col-sm-4">
								<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo @base_url('upload/user/'.$edit_record->sign_image); ?>" alt=""/>
													</div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
													<div>
												<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
													<input type="file" name="sign_image" id="sign_image" >
														</span>
														<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
															<i class="fa fa-times"></i> Remove
														</a>
													</div>
												</div>
							</div>
						</div>
						
						<!--<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Export Invoice Sign 
							</label>
							<div class="col-sm-4">
								<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo @base_url('upload/user/'.$edit_record->export_sign_image); ?>" alt=""/>
													</div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
													<div>
												<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
													<input type="file" name="export_sign_image" id="export_sign_image" >
														</span>
														<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
															<i class="fa fa-times"></i> Remove
														</a>
													</div>
												</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Customer Invoice Sign 
							</label>
							<div class="col-sm-4">
								<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo @base_url('upload/user/'.$edit_record->cutsomer_sign_image); ?>" alt=""/>
													</div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
													<div>
												<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
													<input type="file" name="cutsomer_sign_image" id="cutsomer_sign_image" >
														</span>
														<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
															<i class="fa fa-times"></i> Remove
														</a>
													</div>
												</div>
							</div>
						</div>-->
						</div>   
					<div class="col-md-offset-2">
				    <div class="form-group">
						<input name="Submit" type="submit" value="Save" class="btn btn-success" />
							<a href="<?=base_url().'user_list'?>" class="btn btn-danger">
											Cancel
										</a>						
					</div>    	
				</div> 	
					<input type="hidden" id="user_id" name="user_id" value="<?=$edit_record->user_id?>"/>				
					<input type="hidden" id="mode" name="mode"    value="<?=$mode?>"  />				
				</form>
					</div>
	 		</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>
function show_pi(check_status)
{
	if(check_status == true)
	{
		$(".pi_html").show()
	}
	else
	{
		$(".pi_html").hide()
	}
}
$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   
			});
		});
$(".select2").select2({
		width:'100%'
	})
$("#supplier_form").validate({
		rules: {
			user_name: {
				required: true
			} 
		},
		messages: {
			user_name: {
				required: "Enter Name"
			} 
		}
	});
$("#supplier_form").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'user_list/manage',
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
				    $("#supplier_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'user_list'; },1500);
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'user_list'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'user_list'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 

 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 function delete_record(deleleid)
{
	main_delete(deleleid,'supplier_epcg_list/deleterecord','add_supplier/form_edit/<?=$edit_record->supplier_id?>')
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
            url : root+'supplier_epcg_list/manage',
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
				   setTimeout(function(){ window.location=root+'add_supplier/form_edit/<?=$edit_record->supplier_id?>'; },1500);
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","EPCG Already Exits.");
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
            url: 	root+'supplier_epcg_list/edit_record',
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
					 setTimeout(function(){ window.location=root+'add_supplier/form_edit/<?=$edit_record->supplier_id?>'; },1500);
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
              url: root+"supplier_epcg_list/fetchdata",
              data: {"id": supplie_epcg_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(supplie_epcg_id);
				 	$("#edit_epcg_detail").val(obj.epcg_no);
				 	$("#edit_epcg_date").val(obj.edit_epcg_date);
				   
					unblock_page("",""); 
                  }
              
          }); 

}	

</script>
<?php 
if($edit_record->sign_pi_status ==1)
{
	echo "<script>show_pi(true)</script>";
}
?>
  