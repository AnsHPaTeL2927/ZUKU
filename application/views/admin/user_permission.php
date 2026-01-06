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
							<h3><?=$mode?> User Permission</h3>
							</div>
							 
						</div>
					</div>
								<form action="javascript:;" method="POST"  class="col-md-offset-1 form-horizontal" name="user_permission_form" id="user_permission_form">
									<div class="form-group">
										<label class="col-md-2 control-label">Select Usertype </label>
											<div class="col-md-3">
												<select class="select2" name="user_type_id" id="user_type_id" required title="Select Usertype" onchange="load_menu(this.value)">
													<option value="">Select Usertype</option>
													<?php 
													foreach($usertype as $row)
													{
														echo "<option value='".$row->usertype_id."'>".$row->user_type."</option>";
													}
													?>
												</select>
											</div>
									</div>
										<div id="userpermission_html"></div>
									<div class="col-md-12">	 
										<div class="col-md-offset-2">
										<button type="submit" id="submit_btn" class="btn btn-success">Save</button>
										</div> 
									</div> 
								 			
							</form>
	 
			</div>
	 		</div>
		 </div>
	 </div>
 </div>
 <?php $this->view('lib/footer'); ?>
 <script>
 $(".select2").select2({
	 width : "100%"
 });
 function load_menu(value)
{
	$.ajax({ 
       type: "POST", 
       url: root+'user_permission/load_menu',
       data: {
			"user_type_id" : value 
       }, 
       cache: false, 
       success: function (data) { 
			// console.log(data);
			  $("#userpermission_html").html(data)
       }
	 }); 
}
function check_submenu(main_menu_id,checked)
{
	if(checked==true)
	{
		$("input[name='menu_name"+main_menu_id+"[]']:checkbox").prop("checked",true);
	}
	else
	{
		$("input[name='menu_name"+main_menu_id+"[]']:checkbox").prop("checked",false);
	}
}
$("#user_permission_form").submit(function(event) {
	event.preventDefault();
	 var all_menu = [];
	$. each($("input[name='menu_name[]']:checked"), function(){
			all_menu. push($(this). val());
	});
	if(all_menu == "")
	{
		toastr["error"]("Select atleast one menu");
		return false;
	}
	 block_page()
	var postData= new FormData(this);
 	$.ajax({
            type: "post",
            url: 	root+'user_permission/manage',
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
				   $("#user_permission_form").trigger('reset');
				 	toastr["success"]("Successfully Uploaded");
					setTimeout(function(){  location.reload(); },1500);
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
 
 </script>
</body>
</html>
