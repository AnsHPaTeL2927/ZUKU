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
									  &nbsp;Create Task
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Create Task</h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Create Task
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="create_task_form" name="create_task_form">
										
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Title:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Task Title" id="title" class="form-control" name="title" value="<?php echo $row->title; ?>" autocomplete="off" >
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Details:
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Details" id="details" class="form-control" name="details" value="" autocomplete="off" ></textarea>
												</div>
											</div>
											
											<div class="form-group" >
															
												<label class="control-label col-sm-12" for="form-field-1"   >
													Date:
												</label>
												<div class="col-sm-12">
													<input type="text" id="date"  placeholder="Select Date" class="form-control defualt-date-picker" name="date" autocomplete="off"  />
												</div>
															
											</div>
											
											<div class="form-group" >
															
												<label class="control-label col-sm-12" for="form-field-1"   >
													Time:
												</label>
												<div class="col-sm-12">
													<input type="text" id="time"  placeholder="Select Time"  class="form-control timepicker" name="time" autocomplete="off"  />
												</div>
															
											</div>
																					
											<div class="form-group">
									
												<label class="col-sm-3 control-label" for="form-field-1">
													Repeat
												</label>
												<div class="col-sm-12">
													<select class="select2" name="repeatdata" id="repeatdata" required="">
														<option value="" >Select Duration</option>
														<?php
														for($p=0;$p<count($documentdata);$p++)
														{ 
															echo "<option value='".$documentdata[$p]->id."'> ".$documentdata[$p]->data." </option>";
														}
														?>
													</select>
													<!--To Show Error  -->											
													<label id="repeatdata-error" class="error" for="repeatdata"></label>
													<!--To Show Error  -->	
												</div>
											</div>
											
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select User <a href="<?=base_url().'User_list'?>" target="_blank">New User</a> 
											</label>
											<div class="col-sm-12">
												<select class="select2"  name="user_id[]" id="user_id" title="Select Tag"  required data-placeholder="Select User" multiple >
													 
													<?php
													for($u=0;$u<count($userdata);$u++)
													{
													 	echo "<option value='".$userdata[$u]->user_id."'>".$userdata[$u]->user_name." </option>";
													}
													?> 
												</select>
												<label id="user_id-error" class="error" for="user_id"></label>
											</div>
										</div>
											
										<div class="form-group" style="margin-left:90px;" >
											<button type="submit" class="btn btn-success" name="save" value="Save Data">
												Save
											</button>
										</div>	
											 
								</form>
							</div>
					</div>
				</div>	
				<div class="col-md-8">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Create Task
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
							
								
								 	 <div class="table-responsive" >
									
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<th>No</th>  
												<th>Title</th>  
												<th>Details</th>  	
												<th>Date</th>  
												<th>Repeat</th>  
												<th>Action</th>  
											</thead>  
											<tbody>  
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
						
<div id="myModal" name="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
			
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Create Task </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 
					 <div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Title:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Company Tag Name" id="edit_title" class="form-control" name="edit_title" value="<?php echo $row->title; ?>" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Details:
						</label>
						<div class="col-sm-12">
							<textarea type="text" placeholder="Details" id="edit_details" class="form-control" name="edit_details" value="" autocomplete="off" ></textarea>
						</div>
					</div>
					
					<div class="form-group" >
									
						<label class="control-label col-sm-12" for="form-field-1"   >
							Date:
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_date"  placeholder="Select Date" class="form-control defualt-date-picker" name="edit_date" autocomplete="off"  />
						</div>
									
					</div>
					
					<div class="form-group clockpicker" >
									
						<label class="control-label col-sm-12 " for="form-field-1"  >
							Time:
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_time"  placeholder="Select Time"  class="form-control timepicker" name="edit_time" autocomplete="off"  />
						</div>
									
					</div>
															
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
						Repeat
						</label>
						
						<div class="col-sm-12">
							<select class="select2" name="edit_repeatdata" id="edit_repeatdata" required="" title="Select Duration">
								<option value="" >Select Duration</option>
								<?php
								for($p=0;$p<count($documentdata);$p++)
								{ 
									echo "<option value='".$documentdata[$p]->id."'> ".$documentdata[$p]->data." </option>";
								}
								?>
							</select>
							<!--To Show Error  -->											
							<label id="edit_repeatdata-error" class="error" for="edit_repeatdata"></label>
							<!--To Show Error  -->	
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Select User <a href="<?=base_url().'User_list'?>" target="_blank">New User</a> 
						</label>
						<div class="col-sm-12">
							<select class="select2"  name="edit_user_id[]" id="edit_user_id" title="Select User"  required data-placeholder="Select User" multiple >
								 
								<?php
								for($u=0;$u<count($userdata);$u++)
								{
								 	echo "<option value='".$userdata[$u]->user_id."'>".$userdata[$u]->user_name." </option>";
								}
								?> 
							</select>
							<label id="edit_user_id-error" class="error" for="edit_user_id"></label>
						</div>
					</div>
					
			   </div>
			   
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="editdocumentmode" id="editdocumentmode" />
			 </form>
        </div>
    </div>
</div>		

<?php $this->view('lib/footer'); ?>

<script>
 $(function () {
            $('input').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });

 $(function () {
            $('textarea').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });	
		
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'yyyy-mm-dd',
	 
 });
 
 $(".select2").select2({
	width:'100%'
});

$('.timepicker').datetimepicker({
    format: 'HH:ii P',
	autoclose: true,
    showMeridian: true,
    startView: 1,
    maxView: 1,
	sideBySide: true,	 
});
	 
$('.datetimepicker-hours thead').attr('style', 'display:none;');
$('.datetimepicker-hours table').attr('style', 'width:100%');
$('.datetimepicker-minutes thead').attr('style', 'display:none;');
$('.datetimepicker-minutes table').attr('style', 'width:100%');

$("#create_task_form").submit(function(event) {
	event.preventDefault();
	if(!$("#create_task_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Createtask/manage';
	$.ajax({
            type: "post",
            url: url,
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
				   unblock_page("success","Sucessfully saved.");
				   setTimeout(function(){ window.location=root+'Createtask' },500);
				   $("#id").val('').trigger('change');
				   
				   $("#create_task_form").trigger('reset');
					 datatable.DataTable().ajax.reload();	
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#create_task_form").trigger('reset');
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

load_data_table();
function load_data_table()
{
	datatable = $("#datatable").dataTable({
				"bAutoWidth" : false,
				"bFilter" : true,
				"bSort" : true,
				"bProcessing": true,
				"searchDelay": 350,
				"bServerSide" : true,
				"bDestroy": true,
				"oLanguage": {
					"sLengthMenu": "_MENU_",
					// "sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "NO DATA ADDED YET !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'Createtask/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "status", "value": $("#status").val() });
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			
			"createdRow": function(row, data, dataIndex ) {
			if(data[5].indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             
			}
			
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
		$(".gallery").fancybox({
			'hideOnContentClick': true
		});
}

//validation

$("#create_task_form").validate({
	 rules: {
		title: {
			required: true
		},
		details: {
			required: true
		},
		date: {
			required: true
		},
		time: {
			required: true
		},
		data: {
			required: true
		},
		user_id: {
			required: true
		}
		
	 },
	 messages: {
		title: {
			required: "Title Required"
		},
		details: {
			required: "Enter Details"
		},
		date: {
			required: "Select Date"
		},
		time: {
			required: "Choose Time"
		},
		data: {
			required: "Choose Duration for Alert"
		},
		user_id: {
			required: "Select User Name"
		}
	 }
});

$("#edit_form").validate({
		rules: {
		edit_title: {
			required: true
		},
		edit_details: {
			required: true
		},
		edit_date: {
			required: true
		},
		edit_time: {
			required: true
		},
		edit_data: {
			required: true
		},
		edit_user_id: {
			required: true
		}
	},
		
		messages: {
		edit_title: {
			required: "Title Required"
		},
		edit_details: {
			required: "Enter Details"
		},
		edit_date: {
			required: "Select Date"
		},
		edit_time: {
			required: "Choose Time"
		},
		edit_data: {
			required: "Choose Duration for Alert"
		},
		edit_user_id: {
			required: "Select User Name"
		}
	}
});


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
            url: 	root+'Createtask/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_title").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   //$(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Createtask' },1000);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#company_document_form").trigger('reset');
					//$(".select2").select2('val','');
				    
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
              url: root+"Createtask/fetchuserdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_title").val(obj.title);
					 $("#editdocumentmode").val(obj.title);
					 
					 $("#edit_details").val(obj.details);
					 
					
					if(obj.date == '0000-00-00')
					{
						$("#edit_date").val("0");
					}
					else if(obj.date == '1970-01-01')
					{
						$("#edit_date").val("0") ;
					}
					else if(obj.date == '01/01/1970')
					{
						$("#edit_date").val("0") ;
					}
					else
					{
						//$("#edit_date").val(obj.date);
					 	$("#edit_date").datepicker("update",(obj.date)); 
							
					}
					
					// for time	
					if(obj.time == '00:00:00')
					{
						$("#edit_time").val("0");
					}
					
					else
					{
						$("#edit_time").val(obj.time);
					}
					 					 					 			
					$("#edit_repeatdata").append("<option value='"+obj.id+"'></option>") 
					$("#edit_repeatdata").val(obj.data).trigger('change') 	
					
					
										 															 
					 if(obj.user_name != "" && obj.user_name != null)
					{
						$("#edit_user_id").val(obj.user_name.split(',')).trigger('change');
					}
					  
				 	unblock_page("",""); 
                  }
              
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
              url: root+'Createtask/archive_record',
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
						unblock_page('success',"Document successfully unarchived");
					}
					else
					{
						unblock_page('success',"Document successfully archived");
					}
					setTimeout(function(){ window.location=root+'Createtask'; },1500);
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
	main_delete(deleleid,'Createtask/deleterecord','Createtask')
}

</script>