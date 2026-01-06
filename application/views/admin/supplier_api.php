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
									  &nbsp;Supplier API
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Supplier API</h3>
						</div>
						
				</div>
			</div>
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Supplier API
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="supplier_form" name="supplier_form">
																				
										<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
														Supplier Company Name
												</label>
												<div class="col-sm-12">
													<input type="text" id="supplier_companyname" name="supplier_companyname" placeholder="Supplier Company Name" required="" title="Enter Company Name" class="form-control"  value="<?php echo $row->supplier_companyname; ?>" autofocus="autofocus"/>
												</div>
											</div>
										<div class="form-group">
												<label class="col-sm-12 control-label" for="form-field-1">
														Supplier GST No
												</label>
												<div class="col-sm-12">
													<input type="text" id="supplier_gstno" name="supplier_gstno" placeholder="Supplier Gst No" required="" title="Enter Gst No" class="form-control"  value="" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-12 control-label" for="form-field-1">
														Supplier PAN No
												</label>
												<div class="col-sm-12">
													<input type="text" id="supplier_panno" name="supplier_panno" placeholder="Supplier Pan No"  title="Enter Pan No" class="form-control"  value="" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-12 control-label" for="form-field-1">
														Supplier IEC NO
												</label>
												<div class="col-sm-12">
													<input type="text" id="supplier_iecno" name="supplier_iecno" placeholder="Supplier IEC NO"  title="Enter Supplier IEC NO" class="form-control"  value="" />
												</div>
											</div>
											<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
														Supplier Address
												</label>
												<div class="col-sm-12">
													<textarea id="supplier_address" name="supplier_address" placeholder="Supplier Address" required="" class="form-control" required title="Enter Supplier Address"></textarea>
												</div>
												</div>
												
												<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
														Supplier Person Name
												</label>
												<div class="col-sm-12">
													<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Person Name" required="" class="form-control" value="" />
											</div>
										</div> 	
											
											<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
														Supplier Contact No
												</label>
												<div class="col-sm-12">
													<input type="text" id="supplier_contactno" name="supplier_contactno" placeholder="Supplier Contact No" required="" class="form-control" value="" />
											</div>
										</div> 
										
										<div class="form-group design_file_control one_by_one">
												<label class="col-sm-12 control-label" for="form-field-1">
													Upload Logo
												</label>
												<div class="col-sm-12">
													<input type="file" placeholder="Upload Logo" id="upload_logo" class="form-control" name="upload_logo" value="" accept="image/jpeg,image/png,image/jpg,application/pdf">
												</div>
										</div>
										
										<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
													Is Active:
												</label>
												<div class="col-sm-12">													
													<label class="radio-inline">
														<input type="radio" name="isactive" id="yes" value="Yes" checked>Yes
													</label>
													<label class="radio-inline">
														<input type="radio" name="isactive" id="no" value="No">No			
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
									Supplier API
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
												<th>Supplier Name</th> 
												<th>Supplier Company Name</th>
												<th>Supplier Logo</th>								
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
                <h4 class="modal-title">Edit Supplier </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
								Supplier Company Name
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_supplier_companyname" name="edit_supplier_companyname" placeholder="Supplier Company Name" required="" title="Enter Company Name" class="form-control"  value="<?php echo $row->supplier_companyname; ?>" autofocus="autofocus"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
								Supplier GST No
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_supplier_gstno" name="edit_supplier_gstno" placeholder="Supplier Gst No" required="" title="Enter Gst No" class="form-control"  value="" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
								Supplier PAN No
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_supplier_panno" name="edit_supplier_panno" placeholder="Supplier Pan No"  title="Enter Pan No" class="form-control"  value="" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
								Supplier IEC NO
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_supplier_iecno" name="edit_supplier_iecno" placeholder="Supplier IEC NO"  title="Enter Supplier IEC NO" class="form-control"  value="" />
						</div>
					</div>
					<div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
								Supplier Address
						</label>
						<div class="col-sm-12">
							<textarea id="edit_supplier_address" name="edit_supplier_address" placeholder="Supplier Address" required="" class="form-control" required title="Enter Supplier Address"></textarea>
						</div>
						</div>
						
						<div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
								Supplier Person Name
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_supplier_name" name="edit_supplier_name" placeholder="Supplier Person Name" required="" class="form-control" value="" />
					</div>
				</div> 	
					
					<div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
								Supplier Contact No
						</label>
						<div class="col-sm-12">
							<input type="text" id="edit_supplier_contactno" name="edit_supplier_contactno" placeholder="Supplier Contact No" required="" class="form-control" value="" />
					</div>
				</div> 
				
				<div class="form-group design_file_control one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
							Upload Logo
						</label>
						<div class="col-sm-8">
							<input type="file" placeholder="Upload Logo" id="edit_upload_logo" class="form-control" name="edit_upload_logo" value="" accept="application/pdf,image/jpeg,image/png">
						</div>
						<div class="col-md-2" style="">
							<a class="tooltips" name="supplier_file_view" id="supplier_file_view"  data-toggle="tooltip"  data-title="View" 
							href="" target="_blank"><i class="fa fa-eye"></i></a> 
							&nbsp;
							<a class="tooltips" name="supplier_file_download" id="supplier_file_download"  data-toggle="tooltip"  data-title="Download" 
							href="" target="_blank"><i class="fa fa-download"></i></a> 		
							&nbsp;
							
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
				<input type="hidden" name="editsupplier" id="editsupplier" />
			 </form>
        </div>
    </div>
</div>
</div>

<?php 
$this->view('lib/footer');
?>

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
			"sAjaxSource": root+'Supplier_api/fetch_record/',
			
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

$("#supplier_form").validate({
	 rules: {
		supplier_companyname: {
			required: true
		}
		
	 },
	 messages: {
		supplier_companyname: {
			required: "Company Name Required"
		}
	 }
});


$("#edit_form").validate({
		rules: {
			edit_supplier_companyname: {
				required: true
			}
		},
		messages: {
			edit_supplier_companyname: {
				required: "Company Name Required"
			}
		}
	});

$(".select2").select2({
	width:'100%'
});

$("#supplier_form").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Supplier_api/manage';
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
				   $("#supplier_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Supplier_api' },1000);
				   
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#supplier_form").trigger('reset');
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
            url: 	root+'Supplier_api/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_supplier_companyname").val() == obj.editsupplier)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   //$(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Supplier_api' },1000);
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
              url: root+"Supplier_api/fetchmodeldata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 $("#edit_supplier_companyname").val(obj.supplier_companyname);
					 $("#editsupplier").val(obj.supplier_companyname);
					 
					 $("#edit_supplier_gstno").val(obj.supplier_gstno);
					 $("#edit_supplier_panno").val(obj.supplier_panno);
					 $("#edit_supplier_iecno").val(obj.supplier_iecno);
					 $("#edit_supplier_address").val(obj.supplier_address);
					 $("#edit_supplier_name").val(obj.supplier_name);
					 $("#edit_supplier_contactno").val(obj.supplier_contactno);
					 
					 if(obj.upload_logo === "No file")
					{
						$("#supplier_file_view").hide();
						$("#supplier_file_download").hide();
						
						
					}
				
					else if(obj.upload_logo === "")
					{
						$("#supplier_file_view").hide();
						$("#supplier_file_download").hide();	
					}
					
					else
					{
						$("#supplier_file_view").show();
						$("#supplier_file_download").show();
						
						$("#supplier_file_view").attr("href",root+'upload/supplier_api/'+obj.upload_logo);
						$("#supplier_file_download").attr("href",root+'Supplier_api/download/'+obj.upload_logo);
						
												
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
              url: root+'Supplier_api/archive_record',
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
						unblock_page('success',"Supplier successfully unarchived");
					}
					else
					{
						unblock_page('success',"Supplier successfully archived");
					}
					setTimeout(function(){ window.location=root+'Supplier_api'; },1500);
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
	main_delete(deleleid,'Supplier_api/deleterecord','supplier_api')
}

function delete_image(deleleid)
{
	main_delete(deleleid,'Supplier_api/delete_image','supplier_api')
	
}

</script>
