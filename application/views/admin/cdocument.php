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
									&nbsp;Company Documents
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Company Document</h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Company Document
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="company_document_form" name="company_document_form">
										<input type="hidden" placeholder="id" id="cmp_doc_setup_id" class="form-control" name="cmp_doc_setup_id" value="<?php echo $row->cmp_doc_setup_id; ?>" autocomplete="off" >
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Document Name:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Document Name" id="dname" class="form-control" name="dname" value="<?php echo $row->document_name; ?>" autocomplete="off" >
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
											
											<div class="form-group one_by_one">
												<label class="control-label col-sm-12" for="form-field-1">
													Document Details
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Document Details" id="details" class="form-control" name="details" autocomplete="off"></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
														Important Documents
												</label>
												<div class="col-sm-12">
														<label class="radio-inline">
															<input type="radio" onclick="ShowHideDiv()" id="chkyes" name="impdocument" value="yes" checked>Yes
														</label>
														<label class="radio-inline">
															<input type="radio" onclick="ShowHideDiv()" id="chkno" name="impdocument" value="no">No		
														</label>
														<!--To Show Error  -->	
														<label id="impdocument-error" class="error" for="impdocument"></label>	
														<!--To Show Error  -->	
												</div>
											</div>
											<div id="ERdate" class="form-group" >
											
															<label class="control-label col-sm-12" for="form-field-1" >
																Reminder Of Expire/Renew Date:
															</label>
															
															<div class="col-sm-12"  >
																<label class="radio-inline">
																	<input type="radio"  id="renewyes" name="renewbutton" value="yes"  >Yes
																</label>
																
																<label class="radio-inline">
																	<input type="radio"  id="renewno" name="renewbutton" value="no" > No
																</label>
																<!--To Show Error  -->	
																<label id="renewbutton-error" class="error" for="renewbutton"></label>	
																<!--To Show Error  -->
															</div>
											</div>
											
													
													
											
											<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
													Order No:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Order No" id="ornumber" class="form-control" name="ornumber" 
													value="<?php echo $no->order_no+1 ?>" autocomplete="off" onkeypress="return isNumber(event)"
													
													/>
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
													<br><label id="isactive-error" class="error" for="isactive"></label>	
													<!--To Show Error  -->
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
									Company Documents
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
												<th>Document Name</th>  
												<th>File Upload</th>  
												<th>Document Details</th>  
													
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
                <h4 class="modal-title">Edit Company Document </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 
					 <div class="form-group">
							<label class="control-label col-sm-12 " for="form-field-1">
							Document Name:
							</label>
							
							<div class="col-sm-12">
								<input type="text" placeholder="Document Name" id="edit_dname" class="form-control" name="edit_dname" value="<?php echo $row->document_name; ?>" autocomplete="off" >
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
											
					<div class="form-group one_by_one">
								<label class="control-label col-sm-12" for="form-field-1">
									Document Details
								</label>
								<div class="col-sm-12">
									<textarea type="text" placeholder="Document Details" id="edit_details" class="form-control" name="edit_details" autocomplete="off"></textarea>
								</div>
					</div>
					
					<div class="form-group">
								<label class="control-label col-sm-12" for="form-field-1">
										Important Documents
								</label>
								<div class="col-sm-12">
										<label class="radio-inline">
											<input type="radio" onclick="ShowHideDiv()" id="edit_chkyes" name="edit_impdocument" value="yes">Yes
										</label>
										<label class="radio-inline">
											<input type="radio" onclick="ShowHideDiv()" id="edit_chkno" name="edit_impdocument" value="no">No		
										</label>
										<!--To Show Error  -->	
										<label id="impdocument-error" class="error" for="impdocument"></label>	
										<!--To Show Error  -->	
								</div>
					</div>
							
							<div id="ERdate" class="form-group" >
							
									<label class="control-label col-sm-12" for="form-field-1" >
										Reminder Of Expire/Renew Date:
									</label>
									
									<div class="col-sm-12"  >
										<label class="radio-inline">
											<input type="radio" onclick="javascript:yesnoCheck();" id="edit_renewyes" name="edit_renewbutton" value="yes"  >Yes
										</label>
										
										<label class="radio-inline">
											<input type="radio" onclick="javascript:yesnoCheck();" id="edit_renewno" name="edit_renewbutton" value="no" > No
										</label>
										<!--To Show Error  -->	
										<label id="renewbutton-error" class="error" for="renewbutton"></label>	
										<!--To Show Error  -->
									</div>
							</div>
							
							
							<div class="form-group" id="space">
								<label class="control-label col-sm-12" for="form-field-1">
									Order No:
								</label>
								<div class="col-sm-12">
									<input type="text" placeholder="Order No" id="edit_ornumber" class="form-control" name="edit_ornumber" value="" autocomplete="off" onkeypress="return isNumber(event)">
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
									<br><label id="isactive-error" class="error" for="isactive"></label>	
									<!--To Show Error  -->
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
	 format:'dd-mm-yyyy',
	 
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
			if(data[4].indexOf('Unarchive') != -1)
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
			"sAjaxSource": root+'Companydocument/fetch_record/',
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

$(".select2").select2({
	width:'100%'
});
 
			
$("#company_document_form").validate({
	 rules: {
		dname: {
			required: true
		},
		radiofiles: {
			required: true
		},
		details:{
			required: true
		},
		impdocument:{
			required: true
		},
		erdate:{
			required: true
		},
		
		ornumber:{
			required: true
		},
		isactive:{
			required: true
		}
	 },
	 messages: {
		dname: {
			required: "Document Name Required"
		},
		radiofiles: {
			required: "Select One option"
		},
		details:{
			required: "Document details required"
		},
		impdocument:{
			required: "Select One option"
		},
		erdate:{
			required: "Date Field is Required"
		},
		
		ornumber:{
			required: "Order Number is Required"
		},
		isactive:{
			required: "Active Status is Required"
		}
	 }
});

$("#edit_form").validate({
		rules: {
			edit_dname: {
				required: true
			},
			edit_radiofiles: {
				required: true
			},
			edit_details:{
				required: true
			},
			edit_impdocument:{
				required: true
			},
			edit_erdate:{
				required: true
			},
			
			edit_ornumber:{
				required: true
			},
			edit_isactive:{
				required: true
			}
		},
		messages: {
			edit_dname: {
				required: "Document Name Required"
			},
			edit_radiofiles: {
				required: "Select One option"
			},
			edit_details:{
				required: "Document details required"
			},
			edit_impdocument:{
				required: "Select One option"
			},
			edit_erdate:{
				required: "Date Field is Required"
			},
			
			edit_ornumber:{
				required: "Order Number is Required"
			},
			edit_isactive:{
				required: "Active Status is Required"
			}
		}
	});
	


	
$("#company_document_form").submit(function(event) {
	event.preventDefault();
	if(!$("#company_document_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Companydocument/manage';
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
				   $("#company_document_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Companydocument' },1500);
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
            url: 	root+'Companydocument/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_dname").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   //$(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'companydocument' },1500);
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
              url: root+"companydocument/fetchdocumentdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				   var edit_renewyes = document.getElementById("edit_renewyes");
				   var edit_reminder = document.getElementById("edit_reminder");
				   var edit_erdate = document.getElementById("edit_erdate");
				   
				
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_dname").val(obj.document_name);
					 
					 //fetch radio button while on edit
					 if(obj.file_type == 1)
					 {
						 $("#edit_singlef").prop("checked",true)
					 }
					 else if(obj.file_type == 2)
					 {
						 $("#edit_multiplef").prop("checked",true)
					 }
					 			
					 $("#edit_details").val(obj.document_details);
					 
					 ////// for impdocument
					 if(obj.important_document == 'yes')
					 {
						 $("#edit_chkyes").prop("checked",true)
					 }
					 else if(obj.important_document == 'no')
					 {
						 $("#edit_chkno").prop("checked",true)
					 }
					 
					 // For Reminder  for Expire/Renew Date
					
					 if(obj.renew_reminder == 'yes')
					 {
						 $("#edit_renewyes").prop("checked",true)
						 //$("#ifYes").show();
						 // $("#edit_erdate").val(obj.renew_date);
						 // $("#edit_dayreminder").val(obj.reminder_days);
						
					 }
					 else if(obj.renew_reminder == 'no')
					 {
						 $("#edit_renewno").prop("checked",true)
						
						  // $("#ifYes").hide();
						  // $("#edit_erdate").val((obj.renew_date) = "");
						  // $("#edit_dayreminder").val((obj.reminder_days) = 0);
					
					
					 }
				 	 
					// if(obj.renew_date == '0000-00-00')
					// {
						// $("#edit_erdate").val(" ");
					// }
					// else if(obj.renew_date == '1970-01-01')
					// {
						// $("#edit_erdate").val(" ") ;
					// }
					// else{
					 	// $("#edit_erdate").datepicker("update", obj.renew_date); 
					// }
					
	 
					 //$("#edit_dayreminder").val(obj.reminder_days);
		 
					 
					 $("#edit_ornumber").val(obj.order_no);
					 
					 // For Is_Active Radio Button fetch
					 if(obj.is_active == 'yes')
					 {
						 $("#edit_yes").prop("checked",true)
					 }
					 else if(obj.is_active == 'no')
					 {
						 $("#edit_no").prop("checked",true)
					 }
					
					 
					 $("#editdocumentmode").val(obj.document_name);
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
              url: root+'Companydocument/archive_record',
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
					setTimeout(function(){ window.location=root+'Companydocument'; },1500);
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
	main_delete(deleleid,'Companydocument/deleterecord','Companydocument')
}
</script>
 