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

function showdata(value)
{	 
	if(value != "")
	{
	 block_page();
	   $.ajax({ 
              type: "POST", 
              url: root+"Companydocumentupload/getdata",
              data: {"id": value}, 
              success: function (response) 
			  { 
			   
					var obj = JSON.parse(response);
					
					if(obj.renew_reminder == "yes")
					{
						$(".dateshow").show()
						$(".editdateshow").show()
					}
					else
					{
						$(".dateshow").val("0");
						$(".dateshow").hide()	
						$(".editdateshow").hide()
					}
					
					if(obj.file_type == "2")
					{
						$("#model_name").show()
						$("#model_name1").show()
				
					}
					else
					{
						$("#model_name").show()
					}
				   unblock_page("","");
			  }
	 });
	}
	 
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
									  &nbsp;Company Document Upload
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Document Upload</h3>
						</div>
					</div>
					</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Document Upload
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="company_tag_form" name="company_tag_form">
									
																						
											<div class="form-group">
												<label class="col-sm-12 control-label" for="form-field-1">
													Select Document 
												</label>
												<div class="col-sm-12">
													<select class="select2" name="document_id" id="document_id" onchange="showdata(this.value)">
														<option value="" >Select Document</option>
														<?php
														for($p=0;$p<count($documentdata);$p++)
														{ 
															echo "<option value='".$documentdata[$p]->cmp_doc_setup_id."'> ".$documentdata[$p]->document_name." </option>";
														}
														?>
													</select>
													<!--To Show Error  -->											
													<label id="document_id-error" class="error" for="document_id"></label>
													<!--To Show Error  -->	
												</div>
											</div>
											
											
										
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Tag <a href="<?=base_url().'Tagmaster'?>" target="_blank">New Tag</a> 
											</label>
											<div class="col-sm-12">
												<select class="select2"  name="tag_id[]" id="tag_id" title="Select Tag"  required data-placeholder="Select Tag" multiple >
													 
													<?php
													for($p=0;$p<count($tagdata);$p++)
													{
													 	echo "<option value='".$tagdata[$p]->tag_id."'>".$tagdata[$p]->tag_name." </option>";
													}
													?> 
												</select>
												<label id="tag_id-error" class="error" for="tag_id"></label>
											</div>
										</div>
										
										<?php
										 $rp = '';
																 
										 if($filedata->file_type == '2')
											{
												$rp = 'multiple';
											}
										?>
										<div class="single">
												<div class="form-group design_file_control one_by_one">
													<label class="col-sm-12 control-label" for="form-field-1">
														Upload Document
													</label>
													<div class="col-sm-12">
														<input type="file" placeholder="Design File" id="model_name<?=$filedata->cmp_doc_setup_id?>" class="form-control" name="model_name<?=$filedata->cmp_doc_setup_id?>" value="" accept="image/jpeg,image/png,application/pdf,image/jfif"  <?=$rp?>>
													</div>
												</div>
										</div>
										
																					
											<div class="dateshow">								
											<div class="form-group" style="">
															
												<label class="control-label col-sm-12" for="form-field-1"   >
													Date:
												</label>
												<div class="col-sm-12">
													<input type="text" id="date"  placeholder="Select Date" class="form-control defualt-date-picker" name="date" autocomplete="off"  />
												</div>
															
											</div>	
											
											<div class="form-group" style="" >
												<label class="control-label col-sm-12">
												No of Day Ago reminder:
												</label>
												<div class="col-sm-12">
													<input type="text" id="dayreminder" placeholder="Enter Number Of Days" class="form-control" onkeypress="return onlyNumberKey(event)" name="dayreminder" autocomplete="off" min="0" max="30" />
																								
												</div>
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
									Uploaded Document
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
								
								<label class="col-md-2 control-label" style="margin-top: 5px;">
									<strong class=""> Select Tag</strong>
								</label>
								<div class="col-sm-4">
									<select class="select2" name="tagid" id="tagid" required title="Select Finish" onchange="load_data_table()" >
										<option value="">All Tags</option>
										<?php
										for($p=0;$p<count($tagdata);$p++)
										{
												$sel = '';
												if($tagdata[$p]->tag_id == $_SESSION['modal_filter_finish_id'])
												{
													$sel = 'selected="selected"';
												}
										 	echo "<option ".$sel." value='".$tagdata[$p]->tag_id."'>".$tagdata[$p]->tag_name." </option>";
										}
										?> 
									</select>
								</div>
								
								 	 <div class="table-responsive" >
									
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<th>No</th>  
												<th>Document</th>  
												<th>Tags</th> 												
												<th>Date</th>  
												<th>No Of Days</th>  
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
		
<div id="myModal" name="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  onclick="reload()" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Document </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form" enctype='multipart/form-data'>
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Select Document 
						</label>
						<div class="col-sm-12">
							<select class="select2" name="edit_document_id" id="edit_document_id" onchange="showdata(this.value)">
								<option value="">Select Document</option>
								<?php
								for($p=0;$p<count($documentdata);$p++)
								{
									 	echo "<option value='".$documentdata[$p]->cmp_doc_setup_id."'> ".$documentdata[$p]->document_name."</option>";
								}
								?>
							</select>
							<!--To Show Error  -->											
							<label id="edit_document_id-error" class="error" for="edit_document_id"></label>
							<!--To Show Error  -->	
						</div>
					</div>
				
				<div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
						Select Tag <a href="<?=base_url().'Tagmaster'?>" target="_blank">New Tag</a> 
					</label>
					<div class="col-sm-12">
						<select class="select2"  name="edit_tag_id[]" required id="edit_tag_id" title="Select Tag"   data-placeholder="Select Tag" multiple >
							 
							<?php
							for($p=0;$p<count($tagdata);$p++)
							{
							 	echo "<option value='".$tagdata[$p]->tag_id."'>".$tagdata[$p]->tag_name." </option>";
							}
							?> 
						</select>
						<label id="edit_tag_id-error" class="error" for="edit_tag_id"></label>
					</div>
				</div>
				
				<div class="editsingle">
					<div class="form-group design_file_control one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
						 		Uploaded Document
						</label>
						<div class="col-sm-8">
						 	<input type="file" placeholder="Design File" id="edit_model_name" class="form-control" name="edit_model_name" multiple="" value="" accept="application/pdf,image/jpeg,image/png">
						</div>
						<div class="col-md-2" style="">
							
							<a class="tooltips" name="design_file_view" id="design_file_view"  data-toggle="tooltip"  data-title="View" 
							href="" target="_blank"><i class="fa fa-eye"></i></a> 
							&nbsp;
							<a class="tooltips" name="design_file_download" id="design_file_download"  data-toggle="tooltip"  data-title="Download" 
							href="" target="_blank"><i class="fa fa-download"></i></a> 
						</div>
					</div>
				</div>
					
					
					<div class="editdateshow">						
					<div class="form-group" >
									
						<label class="control-label col-sm-12" for="form-field-1"   >
							Date:
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_date"  placeholder="Select Date" class="form-control defualt-date-picker" name="edit_date" autocomplete="off" onclick="" 
							
							
							/>
						</div>
									
					</div>	
					
					<div class="form-group"id="reminder" >
						<label class="control-label col-sm-12">
						No of Day Ago reminder:
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_dayreminder" placeholder="Enter Number Of Days" class="form-control" onkeypress="return onlyNumberKey(event)" name="edit_dayreminder" autocomplete="off" min="0" max="30" />
																		
						</div>
					</div>
					</div>
				
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reload()">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="editdocumentmode" id="editdocumentmode" />
			 </form>
        </div>
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
		
function reload()
{
	location.reload();
}
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
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
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'Companydocumentupload/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "status", "value": $("#status").val() },{"name" : "tagid","value" : $("#tagid").val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}

$("#company_tag_form").validate({
	 rules: {
		document_id: {
			required: true
		},
		tag_id: {
			required: true
		},
		model_name:{
			required: true
		},
		date:{
			required: true
		},
		dayreminder:{
			required: true
		}
	 },
	 messages: {
		document_id: {
			required: "Select One Document"
		},
		tag_id: {
			required: "Select One Tag"
		},
		model_name:{
			required: "Select File"
		},
		date:{
			required: "Select Date"
		},
		dayreminder:{
			required: "Choose Days For Reminding"
		}
	 }
});
$("#edit_form").validate({
	 rules: {
		edit_document_id: {
			required: true
		},
		edit_tag_id: {
			required: true
		},
		// edit_model_name:{
			// required: true
		// },
		edit_date:{
			required: true
		},
		edit_dayreminder:{
			required: true
		}
	 },
	 messages: {
		edit_document_id: {
			required: "Select One Document"
		},
		edit_tag_id: {
			required: "Select One Tag"
		},
		// edit_model_name:{
			// required: "Select File"
		// },
		edit_date:{
			required: "Select Date"
		},
		edit_dayreminder:{
			required: "Choose Days For Reminding"
		}
	 }
});

$(".select2").select2({
	width:'100%'
});

$("#company_tag_form").submit(function(event) {
	event.preventDefault();
	if(!$("#company_tag_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Companydocumentupload/manage';
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
				   setTimeout(function(){ window.location=root+'Companydocumentupload' },500);
				   $("#document_id").val('').trigger('change');
				   $("#tag_id").val('').trigger('change');
				   $("#company_tag_form").trigger('reset');
					 datatable.DataTable().ajax.reload();	
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#company_tag_form").trigger('reset');
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
            url: 	root+'Companydocumentupload/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_document_id").val() == obj.editdocumentmode)
			    {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   $(".edit_document_id").val('').trigger('change');
				    unblock_page("success","Sucessfully Updated.");
					datatable.DataTable().ajax.reload();
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					
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

function edit_product(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"Companydocumentupload/fetchmodeldata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				   				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					$("#eid").val(id);
					
					$("#edit_document_id").append("<option value='"+obj.cmp_doc_setup_id+"'>"+obj.document_name+"</option>") 
					$("#edit_document_id").val(obj.cmp_doc_setup_id).trigger('change') 
					 $("#editdocumentmode").val(obj.cmp_doc_setup_id);
					
					if(obj.tag_id != "" && obj.tag_id != null)
					{
						$("#edit_tag_id").val(obj.tag_id.split(',')).trigger('change');
					}
					 
					if(obj.date == '0000-00-00')
					{
						$("#edit_date").val("-");
					}
					else if(obj.date == '1970-01-01')
					{
						$("#edit_date").val("-") ;
					}
					else if(obj.date == '01/01/1970')
					{
						$("#edit_date").val("-") ;
					}
					else if(obj.date != '')
					{
						//$("#edit_date").val(obj.date);
					 	$("#edit_date").datepicker("update",obj.date); 
					}
					
					$("#edit_dayreminder").val(obj.no_reminder_days);
				
					
					if(obj.document_file === "No file")
					{
						$("#design_file_view").hide();
						$("#design_file_download").hide();
					}
					
					else if(obj.document_file === "")
					{
						$("#design_file_view").hide();
						$("#design_file_download").hide();	
					}
					
					else
					{
						$("#design_file_view").show();
						$("#design_file_download").show();
						
						$("#design_file_view").attr("href",root+'upload/company_doc/'+obj.document_file);
						$("#design_file_download").attr("href",root+'Companydocumentupload/download/'+obj.document_file);
												
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
              url: root+'Companydocumentupload/archive_record',
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
					setTimeout(function(){ window.location=root+'Companydocumentupload'; },1500);
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
	main_delete(deleleid,'Companydocumentupload/deleterecord','companydocumentupload')
}

function delete_image(deleleid)
{
	main_delete(deleleid,'Companydocumentupload/delete_image','companydocumentupload')
	
}


</script>
