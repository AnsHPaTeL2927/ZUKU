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
									Currency List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Currency List 
								 
							</h3>
						</div>
					</div>
					</div>
				 	 
					<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add Currency
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="currency_add" id="currency_add">
										 
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Currency Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Currency" id="currency" class="form-control" name="currency" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Currency Code (Copy From google)
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Currency code" id="currency_code" class="form-control" name="currency_code" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label" for="form-field-1">
												Set As Defualt
											</label>
											<div class="col-sm-6" style="margin-top:7px;">
												<input type="checkbox"  id="currency_status"  name="currency_status" value="1" >
											</div>
										</div>
									<div class="form-group col-sm-12">
										<button type="submit" class="btn btn-success">
											Save
										</button>
									</div>	
										 
									</form>
								</div>
							</div>
							 
						</div>
					 
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								Currency List
								<a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
									<div id="myModal1" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">How To Manage Currency List</h4>
												</div>
												<div class="modal-body">
													<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/ckDe8Jge15o?rel=0&autoplay=0"" frameborder="0" allowfullscreen></iframe>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Currency</th>
													<th>Currency Code</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											<?php 
										$m=1;
											$defualt_currency = 0;
											for($i=0; $i<count($currencydata);$i++)
											{
												if($currencydata[$i]->currency_status ==1)
												{
												 $defualt_currency = 1;
												}
											?>
												<tr>
													<td><?=$m?></td>
													<td><?=$currencydata[$i]->currency_name?></td>
													<td><?=$currencydata[$i]->currency_code?></td>
													 <td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		
																		<?php 
																		if($currencydata[$i]->currency_status == 1)
																		{
																		?>
																		<li>
																			<a class="tooltips" data-title="Defualt Currency" href="javascript:;" onclick="edit_currency(<?=$currencydata[$i]->currency_id?>);"><i class="fa fa-check-square-o"></i>  Defualt Currency</a>
																		</li>
																		<?php 
																		}
																		else
																		{
																			?>
																			<li>
																				<a class="tooltips" data-title="Set as Defualt" href="javascript:;" onclick="defualt_currency(<?=$currencydata[$i]->currency_id?>,1);"><i class="fa fa-square-o"></i> Set as Defualt</a>
																			</li>
																			<?php
																		}
																		?>
																		<li>
																			<a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_currency(<?=$currencydata[$i]->currency_id?>);"><i class="fa fa-pencil"></i> Edit</a>
																		</li>
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$currencydata[$i]->currency_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
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
							<!-- end: RESPONSIVE TABLE PANEL -->
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
                <h4 class="modal-title">Edit Currency</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 
					<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Currency
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Currency" id="edit_currency" class="form-control" name="edit_currency" value="" >
					 	</div>
					</div>
				      <div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Currency Code
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Currency code" id="edit_currency_code" class="form-control" name="edit_currency_code" value="">
											</div>
										</div>
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
			 </form>
        </div>
    </div>
</div>

		 
<?php $this->view('lib/footer'); ?>
<script>
$(document).ready(function(){
		/* Get iframe src attribute value i.e. YouTube video url
		and store it in a variable */
    var url = $("#cartoonVideo").attr('src');
    
    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $("#myModal1").on('hide.bs.modal', function(){
        $("#cartoonVideo").attr('src', '');
    });
    
    /* Assign the initially stored url back to the iframe src
    attribute when modal is displayed again */
    $("#myModal1").on('show.bs.modal', function(){
        $("#cartoonVideo").attr('src', url);
    });
});

$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   "order": [[ 0, "asc" ]],
			    "lengthMenu": [ 50, 10, 25, 75, 100 ]
			});
		});
$(".select2").select2({
	width:'100%'
});
function delete_record(deleleid)
{
	main_delete(deleleid,'currency_list/deleterecord','currency_list')
}
$("#currency_add").validate({
		rules: {
			currency: {
				required: true
			}
		},
		messages: {
			currency: {
				required: "Enter Currency"
			}
		}
	});

	$("#edit_form").validate({
		rules: {
			edit_currency: {
				required: true
			}
		},
		messages: {
			edit_currency: {
				required: "Enter Currency"
			}
		}
	});

function defualt_currency(id,status)
{
	Swal.fire({
			title: 'Are You Sure To Change Defualt Currency?',
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, do it!'
		}).then((result) => {
		 if (result.value) {
				block_page();
					$.ajax({
							type: "post",
							url: 	root+'currency_list/defualt_currency',
							data: { 
									"id"	 : id,
									"status" : status
							},
							success: function(responseData) {
							console.log(responseData);
								var obj= JSON.parse(responseData);
								 
								if(obj.res==1)
								{
								  	unblock_page("success","Sucessfully Change.");
									setTimeout(function(){ window.location=root+'currency_list' },1500);
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
			}
		 
		 });
}
$("#currency_add").submit(function(event) {
	event.preventDefault();
	 
	if(!$("#currency_add").valid())
	{
		return false;
	}
	
	var postData= new FormData(this);
	postData.append("mode","add");
	if(<?=$defualt_currency?> == 1 && $("#currency_status").prop('checked') == true)
	{
		Swal.fire({
			title: 'Are You Sure To Change Defualt Currency?',
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, do it!'
		}).then((result) => {
		 if (result.value) {
				block_page();
					$.ajax({
							type: "post",
							url: 	root+'currency_list/manage',
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
								$("#currency_add").trigger('reset');
								$(".select2").select2('val','');
									unblock_page("success","Sucessfully Inserted.");
									setTimeout(function(){ window.location=root+'currency_list' },1500);
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
			}
		 
		 });
	}
	else
	{
		block_page();
					$.ajax({
							type: "post",
							url: 	root+'currency_list/manage',
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
								$("#currency_add").trigger('reset');
								$(".select2").select2('val','');
									unblock_page("success","Sucessfully Inserted.");
									setTimeout(function(){ window.location=root+'currency_list' },1500);
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
		
	}
	 
	
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
            url: 	root+'currency_list/edit_record',
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
					 setTimeout(function(){ window.location=root+'currency_list' },1500);
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

function edit_currency(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"currency_list/fetchmodeldata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(id);
					 $("#edit_currency").val(obj.currency_name);
					 $("#edit_currency_code").val(obj.currency_code);
					 
					unblock_page("",""); 
                  }
              
          }); 

}	

</script>