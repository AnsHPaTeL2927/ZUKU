<?php 
$this->view('lib/header'); 
 
?>	

<script>
function onlyNumberKey(evt) 
    {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

</script>

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
									&nbsp;Document Master
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Document Master</h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								Document Master
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="document_form" name="document_form">
										<input type="hidden" placeholder="id" id="document_id" class="form-control" name="document_id" value="<?php echo $row->id; ?>" autocomplete="off" >
										
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Label Name:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Label Name" id="label_name" class="form-control" name="label_name" value="<?php echo $row->label_name; ?>" autocomplete="off" autofocus="autofocus" 
													>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
												File Upload Option:
												</label>
												<div class="col-sm-12">
													<label class="radio-inline">
														<input type="radio" name="radiofiles" id="singlef" value="1" >Single File
													</label>
													<label class="radio-inline">
														<input type="radio" name="radiofiles" id="multiplef" value="2" > Multiple File 			
													</label><br>
													
													<!--To Show Error  -->											
													<label id="radiofiles-error" class="error" for="radiofiles"></label>	<!--To Show Error  -->											
												</div>
											</div>
										
											<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
												Choose Option:
												</label>
												<div class="col-sm-12">
													<label class="radio-inline">
														<input type="radio" name="radiofiles1" id="image" value="1" >Image
													</label>
													<label class="radio-inline">
														<input type="radio" name="radiofiles1" id="video" value="2" >Video 			
													</label>
													<label class="radio-inline">
														<input type="radio" name="radiofiles1" id="document" value="3" > Document	
													</label><br>
													
													<!--To Show Error  -->											
													<label id="radiofiles-error" class="error" for="radiofiles"></label>	<!--To Show Error  -->											
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Remarks:
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Remarks" id="remarks" class="form-control" name="remarks" value="" autocomplete="off" ></textarea>
												</div>
											</div>
																						
											<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
													Is Active:
												</label>
												<div class="col-sm-12">													
													<label class="radio-inline">
														<input type="radio" name="isactive" id="yes" value="yes" checked>Yes
													</label>
													<label class="radio-inline">
														<input type="radio" name="isactive" id="no" value="no">No			
													</label>
													<!--To Show Error  -->	
													<label id="isactive-error" class="error" for="isactive"></label>	
													<!--To Show Error  -->
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
													Order No:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Order No" id="ornumber" class="form-control" name="ornumber" 
													value="<?php echo $no->order_no+1 ?>" autocomplete="off" onkeypress="return onlyNumberKey(event)"
													
													/>
												</div>
											</div>
											
											
										<div class="form-group" style="margin-left:130px;" >
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
									Document Master
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
												<th>Label Name</th> 
												<th>File Upload</th> 
												<th>Document Type</th>  
												<th>Is Active</th>
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
                <h4 class="modal-title">  Document Master </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Label Name:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Shipping Name" id="edit_label_name" class="form-control" name="edit_label_name" value="<?php echo $row->label_name; ?>" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
						File Upload Option:
						</label>
						
						<div class="col-sm-12">
							<label class="radio-inline">
								<input type="radio" name="edit_radiofiles" id="edit_singlef" value="1" >Single File
							</label>
							<label class="radio-inline">
								<input type="radio" name="edit_radiofiles" id="edit_multiplef" value="2" > Multiple File 			
							</label><br>
							
							<!--To Show Error  -->											
							<label id="radiofiles-error" class="error" for="radiofiles"></label>	<!--To Show Error  -->											
						</div>
					</div>			
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
						Choose Option:
						</label>
						<div class="col-sm-12">
							<label class="radio-inline">
								<input type="radio" name="edit_radiofiles1" id="edit_image" value="1" >Image
							</label>
							<label class="radio-inline">
								<input type="radio" name="edit_radiofiles1" id="edit_video" value="2" >Video 			
							</label>
							<label class="radio-inline">
								<input type="radio" name="edit_radiofiles1" id="edit_document" value="3" > Document	
							</label><br>
							
							<!--To Show Error  -->											
							<label id="radiofiles-error" class="error" for="radiofiles"></label>	<!--To Show Error  -->											
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Remarks:
						</label>
						<div class="col-sm-12">
							<textarea type="text" placeholder="Remarks" id="edit_remarks" class="form-control" name="edit_remarks" value="" autocomplete="off" >
							</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Is Active:
						</label>
						<div class="col-sm-12">													
							<label class="radio-inline">
								<input type="radio" name="edit_isactive" id="edit_yes" value="yes">Yes
							</label>
							<label class="radio-inline">
								<input type="radio" name="edit_isactive" id="edit_no" value="no">No			
							</label>
							<!--To Show Error  -->	
							<label id="isactive-error" class="error" for="isactive"></label>	
							<!--To Show Error  -->
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Order No:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Order No" id="edit_ornumber" class="form-control" name="edit_ornumber" 
							value="" autocomplete="off" onkeypress="return onlyNumberKey(event)"/>
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
		
$(document).ready(function () {
	load_data_table();
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
			"createdRow": function(row, data, dataIndex ) {
			if(data[5].indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             if (data[4] == "No" ) 
			{        
				$('td', row).css('background-color', '#CDCDCD');
			}
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'Document_master/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "status", "value": $("#status").val() });
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}

$("#document_form").validate({
	 rules: {
		label_name: {
			required: true
		}
		
	 },
	 messages: {
		label_name: {
			required: "Label Name Required"
		}
	 }
});


$("#edit_form").validate({
		rules: {
			edit_label_name: {
				required: true
			}
		},
		messages: {
			edit_label_name: {
				required: "Label Name Required"
			}
		}
	});

$(".select2").select2({
	width:'100%'
});
	
$("#document_form").submit(function(event) {
	event.preventDefault();
	if(!$("#document_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Document_master/manage';
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
				   $("#document_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Document_master' },1000);
				   
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#document_form").trigger('reset');
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
            url: 	root+'Document_master/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_label_name").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				  
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Document_master' },1500);
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
              url: root+"Document_master/fetchshippingdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_label_name").val(obj.label_name);
					 					 					 			
					if(obj.file_type == 1)
					 {
						 $("#edit_singlef").prop("checked",true)
					 }
					 else if(obj.file_type == 2)
					 {
						 $("#edit_multiplef").prop("checked",true)
					 }
					 			
								
					if(obj.upload_option == 1)
					 {
						 $("#edit_image").prop("checked",true)
					 }
					 else if(obj.upload_option == 2)
					 {
						 $("#edit_video").prop("checked",true)
					 }	
					 else if(obj.upload_option == 3)
					 {
						 $("#edit_document").prop("checked",true)
					 }	
										
					 
					 $("#edit_remarks").val(obj.remarks);
					 
									 					 																				 
					 // For Is_Active Radio Button fetch
					 if(obj.is_active == 'Yes')
					 {
						 $("#edit_yes").prop("checked",true)
					 }
					 else if(obj.is_active == 'No')
					 {
						 $("#edit_no").prop("checked",true)
					 }
					 
					 $("#edit_ornumber").val(obj.order_no);
					 
					 $("#editdocumentmode").val(obj.label_name);
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
              url: root+'Document_master/archive_record',
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
						unblock_page('success',"Shipping successfully unarchived");
					}
					else
					{
						unblock_page('success',"Shipping successfully archived");
					}
					setTimeout(function(){ window.location=root+'Document_master'; },1500);
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
	main_delete(deleleid,'Document_master/deleterecord','document_master')
}


</script>