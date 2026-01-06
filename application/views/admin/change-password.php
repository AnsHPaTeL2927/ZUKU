<?php 
$this->view('lib/header'); 
$label = '';
 
if($status==1)
{
	$label = 'Password Change Successfully';
}
else if($status==3)
{
	$label = 'New Password & Confirm Password Not Match.';
}
else if($status==2)
{
	$label = 'You are enter wrong old password.';
}
?>	
	<div class="main-container">
			<?php $this->view('lib/sidebar'); ?>
			 <div class="main-content">
				<div class="container">
				 	<div class="col-sm-12">
						 <ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
									<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								<li class="active">
									Change Password
								</li>
								 
							</ol>
							<div class="page-header">
								<h3> Change Password  </h3>
							</div>
						  <div class="row">
						<div class="col-sm-12">
							<!-- start: TEXT FIELDS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="<?=base_url().'changepassword/manage'?>" method="post" name="change_password_form" id="change_password_form" name="change_password_form">
									
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Old Password 
											</label>
											<div class="col-sm-3">
												<input type="password"   placeholder="Old Password " id="old_password" class="form-control" name="old_password" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												New Password 
											</label>
											<div class="col-sm-3">
												<input type="password" placeholder="New Password" id="new_password" class="form-control" name="new_password">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Confirm Password 
											</label>
											<div class="col-sm-3">
												<input type="password" placeholder="Confirm Password" id="confirm_new_password" class="form-control" name="confirm_new_password">
											</div>
										</div>
										 
										
										<div class="form-group"  >
										<button type="submit" class="btn btn-default col-md-offset-2">
											Save
										</button>
										<?=$label?>
									</div>	
									  </form>
								</div>
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
$("#change_password_form").validate({
		rules: {
			old_password: {
				required: true
			},
			new_password:{
				required:true,
				 minlength: 6
			},
			confirm_new_password:{
				required:true,
				minlength: 6,
				equalTo:"#new_password"
			}
		},
		messages: {
			old_password: {
				required: "Enter Old Password"
			},
			new_password:{
				required:"Enter New Password",
				minlength: "Maximum 6 characters required"
			},
			confirm_new_password:{
				required:"Enter Confirm Password",
				 minlength: 6,
				 equalTo:"Password Not Match"
			}
		}
	});
</script>
