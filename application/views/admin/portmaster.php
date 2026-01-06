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
<?php 
$this->view('lib/sidebar');
 ?>	
		 
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
									  &nbsp;Port Master
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Port Master</h3>
						</div>
						<div class="form-group pull-right col-sm-2" >
							<button type="button"  class="btn btn-primary" onclick="import_excel()"> <i class="fa fa-upload"></i> Import Port Data</button>	
						</div>
				</div>
			</div>
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Port Master
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="port_form" name="port_form">
																				
										<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Port Name:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Port Name" id="port_name" class="form-control" name="port_name" value="<?php echo $row->port_name; ?>" autocomplete="off" autofocus="autofocus">
												</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-sm-12" for="form-field-1">
												Port Code:
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Port Code" id="port_code" class="form-control" name="port_code" 
												value="<?php echo $row->port_code; ?>" autocomplete="off" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Country 
											</label>
											<div class="col-sm-10">
												<select class="select2"  name="country[]" id="country" title="Select Country"  required data-placeholder="Select Country" multiple >
													 
													<?php
													for($p=0;$p<count($countrydata);$p++)
													{
													 	echo "<option value='".$countrydata[$p]->id."'>".$countrydata[$p]->c_name." </option>";
													}
													?>
													
												</select>
												<label id="country-error" class="error" for="country"></label>
												
											</div>
											<div style="margin-top: 4px;">
												<button type="button" class="btn btn-primary tooltips" data-title="Add Country" data-toggle="modal" data-target="#countryadd" data-keyboard="false" data-backdrop="static">+</button>
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
									Port Master
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
									<strong class=""> Select Country</strong>
								</label>
								<div class="col-sm-4">
									<select class="select2" name="countryid" id="countryid" required title="Select Country" onchange="load_data_table()" >
										<option value="">All Country</option>
										<?php
										for($p=0;$p<count($countrydata);$p++)
										{
												$sel = '';
												if($countrydata[$p]->id == $_SESSION['modal_filter_finish_id'])
												{
													$sel = 'selected="selected"';
												}
										 	echo "<option ".$sel." value='".$countrydata[$p]->id."'>".$countrydata[$p]->c_name." </option>";
										}
										?> 
									</select>
								</div>

								 	 <div class="table-responsive" >
									
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<th>No</th>  
												<th>Port Name</th> 
												<th>Port Code</th> 												
												<th class="country">Country</th> 												
												<th>Status</th>  
												
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
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Port </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				
					<div class="form-group">
							<label class="control-label col-sm-12 " for="form-field-1">
							Port Name:
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Port Name" id="edit_port_name" class="form-control" name="edit_port_name" value="<?php echo $row->port_name; ?>" autocomplete="off" >
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Port Code:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Port Code" id="edit_port_code" class="form-control" name="edit_port_code" 
							value="" autocomplete="off" 
							
							/>
						</div>
					</div>
						
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Select Country 
						</label>
						<div class="col-sm-12">
							<select class="select2" name="edit_country[]" id="edit_country" title="Select Country"  required data-placeholder="Select Country" multiple >
								 
								<?php
								for($p=0;$p<count($countrydata);$p++)
								{
								 	echo "<option value='".$countrydata[$p]->id."'>".$countrydata[$p]->c_name." </option>";
								}
								?>
								
							</select>
							<label id="edit_country-error" class="error" for="edit_country"></label>
						</div>
					</div>
					
					<div class="form-group">
							<label class="control-label col-sm-12 " for="form-field-1">
							Remarks:
							</label>
							<div class="col-sm-12">
								<textarea type="text" placeholder="Remarks" id="edit_remarks" class="form-control" name="edit_remarks" value="" autocomplete="off" ></textarea>
							</div>
					</div>
					
					<div class="form-group">
							<label class="control-label col-sm-12" for="form-field-1">
								Is Active:
							</label>
							<div class="col-sm-12">													
								<label class="radio-inline">
									<input type="radio" name="edit_isactive" id="edit_yes" value="yes" checked>Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="edit_isactive" id="edit_no" value="no">No			
								</label>
								<!--To Show Error  -->	
								<label id="isactive-error" class="error" for="isactive"></label>	
								<!--To Show Error  -->
							</div>
					</div>
						
									
				
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="editportname" id="editportname" />
			 </form>
        </div>
    </div>
</div>
</div>

<div id="excelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"   class="close" onclick="close_opoup()" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Order  </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="import_form" id="import_form">
			 
            <div class="modal-body">
                <div class="row">
					  
					<div class="col-md-12 product_html">					
					   <div class="field-group" >
								<div class="tab"> 
										<h4>Select File For Upload Data</h4>
										<input type="file" name="import_file" id="import_file" accept=" ">
								</div>	
								
						</div> 
						 <div class="field-group" >
							<div class="tab"> 
										 <a href="<?=base_url().'upload/csv/sample_port.csv'?>"  class="btn btn-primary"  target="_blank">Sample File Download</a>
								</div>	
						</div> 
					</div> 
				 	 <div class="col-md-12 error_html" >					
					    
					</div> 
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Import" id="import_submit_btn" class="btn btn-success"  /> 
                <button type="button"  class="btn btn-default" data-dismiss="modal" onClick="refreshPage()">Close</button>
            </div>
							
			</form>
       
    </div>
</div>
</div>
<?php 
$this->view('lib/footer');
$this->view('lib/addcountry');
?>

<script>
function refreshPage(){
    window.location.reload();
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
		
function import_excel()
{
	$("#excelModal").modal({
		backdrop: 'static',
		keyboard: false
	});

}
$(".select2").select2({
	width:'100%'
});

	
$("#port_form").validate({
	 rules: {
		port_name: {
			required: true
		},
		country: {
			required: true
		}
		
	 },
	 messages: {
		port_name: {
			required: "Port Name Required"
		},
		country: {
			required: "Select At Least One Country"
		}
	 }
});

 $("#country").select2({
	width:'100%',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_country_modal(0)'>Add New Country</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 	
});
function add_country_modal(val)
{
	 
	if(val==0)
	{
		$("#countryadd").modal('show');
	}
	
}

$("#edit_form").validate({
	 rules: {
		edit_port_name: {
			required: true
		},
		edit_country: {
			required: true
		}
		
	 },
	 messages: {
		edit_port_name: {
			required: "Port Name Required"
		},
		edit_country: {
			required: "Select At Least One Country"
		}
	 }
});


load_data_table();
function load_data_table()
{
	datatable = $("#datatable").dataTable({
				"bAutoWidth" : false,
				"bFilter" : true,
				"bSort" : true,
				"bProcessing": true,
				"deferRender": true,
				"searchDelay": 50,
				"bServerSide" : true,
				"bDestroy": true,
				"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
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
			"sAjaxSource": root+'Portmaster/fetch_record/',
			
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "status", "value": $("#status").val() },{"name" : "countryid","value" : $("#countryid").val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			
			"createdRow": function(row, data, dataIndex ) {
			if(data[5].indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             if (data[4] == "No" ) {        
				$('td', row).css('background-color', '#CDCDCD');
			   }
			}
			
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		
		$('.dataTables_length select').addClass('form-control');
		
		$('.dataTables_filter select').addClass('select2').attr('placeholder','Search');
		$('.dataTables_length select').addClass('select2');
		$(".gallery").fancybox({
			'hideOnContentClick': true
		});
}


$("#country_add").submit(function(event) {
	event.preventDefault();
	if(!$("#country_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","1");
 
	$.ajax({
            type: "post",
            url: 	root+'Country_detail/manage',
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
				   $("#consigner_form").trigger('reset');
				    $('#countryadd').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#country_id").append("<option value='"+obj.id+"' selected>"+obj.cname+"</option>");
					$("#country_id").val(obj.id)
				 
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

$("#port_form").submit(function(event) {
	event.preventDefault();
	if(!$("#port_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Portmaster/manage';
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
				   $("#port_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Portmaster' },1000);
				   
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#port_form").trigger('reset');
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
            url: 	root+'Portmaster/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_port_name").val() == obj.editportname)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   //$(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Portmaster' },1000);
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
              url: root+"Portmaster/fetchportdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_port_name").val(obj.port_name);
					 $("#editportname").val(obj.port_name);
					 
					 $("#edit_port_code").val(obj.port_code);
					 					 					 			
					 if(obj.c_name != "" && obj.c_name != null)
					{
						$("#edit_country").val(obj.c_name.split(',')).trigger('change');
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
              url: root+'Portmaster/archive_record',
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
						unblock_page('success',"Port successfully unarchived");
					}
					else
					{
						unblock_page('success',"Port successfully archived");
					}
					setTimeout(function(){ window.location=root+'Portmaster'; },1500);
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
	main_delete(deleleid,'Portmaster/deleterecord','portmaster')
}


$("#import_form").submit(function(event) {
	event.preventDefault();
	
	 
	block_page();
	var postData= new FormData(this);
	var url = root+'Portmaster/import_port';
	 
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
				   unblock_page("success","Sucessfully Imported.");
				   setTimeout(function(){ window.location=root+'portmaster' },1000);
				 
			 	}
				else if(obj.res==2)
				{
					unblock_page("error","Worng File. Coloum Doesn't Match");
		 		}
				else if(obj.res==3)
				{
					unblock_page("error","Worng File. Coloum Name Doesn't Match");
		 		}
				else if(obj.res==4)
				{
					$(".product_html").hide();
					$(".error_html").show();
					$(".error_html").html(obj.error_html);
			 		unblock_page("error","Some Record having error.");
		 		}
			 	else if(obj.res==0)
				{
					unblock_page("error","File Not Upload.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

</script>
