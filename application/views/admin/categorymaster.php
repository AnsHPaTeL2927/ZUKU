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
									&nbsp;Category Master
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Category Master</h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Category Master
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="category_master_form" name="category_master_form">
										<input type="hidden" placeholder="id" id="cmp_doc_setup_id" class="form-control" name="cmp_doc_setup_id" value="<?php echo $row->shipping_id; ?>" autocomplete="off" >
										
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Category Name:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Category Name" id="category_name" class="form-control" name="category_name" value="<?php echo $row->category_name; ?>" autocomplete="off" autofocus="autofocus" 
													>
												</div>
											</div>
											
											<div class="form-group one_by_one">
												<label class="col-sm-12 control-label" for="form-field-1">
													Category Desc
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Category Details" id="category_desc" class="form-control" name="category_desc" ></textarea>
												</div>
											</div>
										
											<div class="form-group">
												<label class="col-sm-12 control-label" for="form-field-1">
													Select Finish <a href="<?=base_url().'finish_list'?>" target="_blank">New Finish</a>
												</label>
												<div class="col-sm-12">
													<select class="select2" name="finish_id[]" id="finish_id" title="Select Finish" multiple data-placeholder="Select Finish">
														 
														<?php
														for($p=0;$p<count($finishdata);$p++)
														{
															echo "<option value='".$finishdata[$p]->finish_id."'>".$finishdata[$p]->finish_name." </option>";
														}
														?> 
													</select>
												</div>
											</div>
										
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Color Code:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Color Code" id="color_code" class="form-control" name="color_code" value="<?php echo $row->color_code; ?>" autocomplete="off" autofocus="autofocus" 
													>
												</div>
											</div>
											
											<div class="form-group design_file_control one_by_one">
												<label class="col-sm-12 control-label" for="form-field-1">
													Front Page Upload
												</label>
												<div class="col-sm-12">
													<input type="file" placeholder="Front Page Upload" id="front_page" class="form-control" name="front_page" value="" accept="image/*">
												</div>
											</div>
											
											<div class="form-group design_file_control one_by_one">
												<label class="col-sm-12 control-label" for="form-field-1">
													Back Page Upload
												</label>
												<div class="col-sm-12">
													<input type="file" placeholder="Back Page Upload" id="back_page" class="form-control" name="back_page" value="" accept="image/*">
												</div>
											</div>
											
											
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Free Field 1:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Free Field 1" id="free_field_1" class="form-control" name="free_field_1" value="" autocomplete="off" >
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Free Field 2:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Free Field 2" id="free_field_2" class="form-control" name="free_field_2" value="" autocomplete="off" >
												</div>
											</div>
											
																						
											<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
													Set Default:
												</label>
												<div class="col-sm-12">													
													<label class="radio-inline">
														<input type="radio" name="setdefault" id="setyes" value="yes" checked>Yes
													</label>
													<label class="radio-inline">
														<input type="radio" name="setdefault" id="setno" value="no">No			
													</label>
													<!--To Show Error  -->	
													<label id="setdefault-error" class="error" for="setdefault"></label>	
													<!--To Show Error  -->
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
									Category Master
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
								
							<!--	<label class="col-md-2 control-label" style="margin-top: 5px;">
									<strong class=""> Select Finish</strong>
								</label>
								<div class="col-sm-4">
									<select class="select2" name="finishid" id="finishid" required title="Select Finish" onchange="load_data_table()" >
										<option value="">All Finish</option>
										<?php
										for($p=0;$p<count($finishdata);$p++)
										{
												$sel = '';
												if($finishdata[$p]->finish_id == $_SESSION['modal_filter_finish_id'])
												{
													$sel = 'selected="selected"';
												}
										 	echo "<option ".$sel." value='".$finishdata[$p]->finish_id."'>".$finishdata[$p]->finish_name." </option>";
										}
										?> 
									</select>
								</div>-->
								
								 	 <div class="table-responsive" >
									
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<th>No</th>  
												<th>Category Name</th>  
												<th>Category Details</th>  
												<th>Tags</th>  
												<th>Front Page</th>  
												<th>Back Page</th>  
												<th>Set Default</th>
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
                <h4 class="modal-title">  Category Master </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Category Name:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Category Name" id="edit_category_name" class="form-control" name="edit_category_name" value="<?php echo $row->category_name; ?>" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
							Category Details
						</label>
						<div class="col-sm-12">
							<textarea type="text" placeholder="Category Details" id="edit_category_desc" class="form-control" name="edit_category_desc" ></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Color Code:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Color Code" id="edit_color_code" class="form-control" name="edit_color_code" value="<?php echo $row->color_code; ?>" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Select Finish <a href="<?=base_url().'finish_list'?>">New Finish</a>
							</label>
							<div class="col-sm-12">
								<select class="select2" name="edit_finish_id[]" id="edit_finish_id" title="Select Finish" multiple  data-placeholder="Select Finish">
									
									<?php
									for($p=0;$p<count($finishdata);$p++)
									{
										echo "<option value='".$finishdata[$p]->finish_id."'>".$finishdata[$p]->finish_name." </option>";
									}
									?> 
								
								</select>
							</div>
					</div>
					
					<div class="form-group design_file_control one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
							Front Page Upload
						</label>
						<div class="col-sm-8">
							<input type="file" placeholder="Front Page Upload" id="edit_front_page" class="form-control" name="edit_front_page" value="" accept="image/*">
						</div>
						<div class="col-md-2" style="">
							<a class="tooltips" name="front_file_view" id="front_file_view"  data-toggle="tooltip"  data-title="View" 
							href="" target="_blank"><i class="fa fa-eye"></i></a> 
							&nbsp;
							<a class="tooltips" name="front_file_download" id="front_file_download"  data-toggle="tooltip"  data-title="Download" 
							href="" target="_blank"><i class="fa fa-download"></i></a> 		
							&nbsp;
							
						</div>
					</div>
					
					<div class="form-group design_file_control one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
						 Back Page Upload
						</label>
						<div class="col-sm-8">
							<input type="file" placeholder="Back Page Upload" id="edit_back_page" class="form-control" name="edit_back_page" value="" accept="image/*">
						</div>
						<div class="col-md-2" style="">
							<a class="tooltips" name="back_file_view" id="back_file_view"  data-toggle="tooltip"  data-title="View" 
							href="" target="_blank"><i class="fa fa-eye"></i></a> 
							&nbsp;
							<a class="tooltips" name="back_file_download" id="back_file_download"  data-toggle="tooltip"  data-title="Download" 
							href="" target="_blank"><i class="fa fa-download"></i></a> 		
							&nbsp;
							
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Free Field 1:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Free Field 1" id="edit_free_field_1" class="form-control" name="edit_free_field_1" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Free Field 2:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Free Field 2" id="edit_free_field_2" class="form-control" name="edit_free_field_2" value="" autocomplete="off" >
						</div>
					</div>
					
				
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Set Default:
						</label>
						<div class="col-sm-12">													
							<label class="radio-inline">
								<input type="radio" name="edit_setdefault" id="edit_setyes" value="yes">Yes
							</label>
							<label class="radio-inline">
								<input type="radio" name="edit_setdefault" id="edit_setno" value="no">No			
							</label>
							<!--To Show Error  -->	
							<label id="setdefault-error" class="error" for="setdefault"></label>	
							<!--To Show Error  -->
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
							value="<?php echo $no->order_no+1 ?>" autocomplete="off" onkeypress="return onlyNumberKey(event)"/>
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
function onlyNumberKey(evt) 
{
    // Only ASCII character in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}
	
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
			if(data[8].indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             if (data[7] == "No" ) {        
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
			"sAjaxSource": root+'Categorymaster/fetch_record/',
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

$("#category_master_form").validate({
	 rules: {
		category_name: {
			required: true
		}
		
	 },
	 messages: {
		category_name: {
			required: "Category Name Required"
		}
	 }
});


$("#edit_form").validate({
		rules: {
			edit_category_name: {
				required: true
			}
		},
		messages: {
			edit_category_name: {
				required: "Category Name Required"
			}
		}
	});

$(".select2").select2({
	width:'100%'
});
	
$("#category_master_form").submit(function(event) {
	event.preventDefault();
	if(!$("#category_master_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Categorymaster/manage';
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
				   $("#category_master_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Categorymaster' },1000);
				   
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#category_master_form").trigger('reset');
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
            url: 	root+'Categorymaster/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_category_name").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				  
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Categorymaster' },1500);
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
              url: root+"Categorymaster/fetchshippingdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_category_name").val(obj.category_name);
					 					 					 			
					 $("#edit_category_desc").val(obj.category_desc);
					 
					if(obj.finish_id != "" && obj.finish_id != null)
					{
						$("#edit_finish_id").val(obj.finish_id.split(',')).trigger('change');
					}
					 
					$("#edit_color_code").val(obj.color_code);
					 
								
					if(obj.front_page === "No file")
					{
						$("#front_file_view").hide();
						$("#front_file_download").hide();
						
						
					}
				
					else if(obj.front_page === "")
					{
						$("#front_file_view").hide();
						$("#front_file_download").hide();	
					}
					
					else
					{
						$("#front_file_view").show();
						$("#front_file_download").show();
						
						$("#front_file_view").attr("href",root+'upload/Category_image/front_page/'+obj.front_page);
						$("#front_file_download").attr("href",root+'Categorymaster/download/'+obj.front_page);
						
												
					}
					
					if(obj.back_page === "No file")
					{
						$("#back_file_view").hide();
						$("#back_file_download").hide();
						
						
					}
				
					else if(obj.back_page === "")
					{
						$("#back_file_view").hide();
						$("#back_file_download").hide();	
					}
					
					else
					{
						$("#back_file_view").show();
						$("#back_file_download").show();
						
						$("#back_file_view").attr("href",root+'upload/Category_image/back_page/'+obj.back_page);
						$("#back_file_download").attr("href",root+'Categorymaster/download1/'+obj.back_page);
						
												
					}
					
					
					 
					 $("#edit_free_field_1").val(obj.free_field_1);
					 
					 $("#edit_free_field_2").val(obj.free_field_2);
					 
					 
					 					 																				 
					 // For Set Default Radio Button fetch
					 if(obj.set_default == 'Yes')
					 {
						 $("#edit_setyes").prop("checked",true)
					 }
					 else if(obj.set_default == 'No')
					 {
						 $("#edit_setno").prop("checked",true)
					 } 
					 
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
					 
					 $("#editdocumentmode").val(obj.category_name);
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
              url: root+'Categorymaster/archive_record',
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
						unblock_page('success',"Category successfully unarchived");
					}
					else
					{
						unblock_page('success',"Category successfully archived");
					}
					setTimeout(function(){ window.location=root+'Categorymaster'; },1500);
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
	main_delete(deleleid,'Categorymaster/deleterecord','categorymaster')
}

function delete_image(deleleid)
{
	main_delete(deleleid,'Categorymaster/delete_image','categorymaster')
	
}

function delete_image1(deleleid)
{
	main_delete(deleleid,'Categorymaster/delete_image1','categorymaster')
	
}
</script>
