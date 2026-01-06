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
									&nbsp;Shipping Line Master
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Shipping Line</h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Shipping Line
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="shipping_line_form" name="shipping_line_form">
										<input type="hidden" placeholder="id" id="cmp_doc_setup_id" class="form-control" name="cmp_doc_setup_id" value="<?php echo $row->shipping_id; ?>" autocomplete="off" >
										
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Shipping Line Name:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Shipping Name" id="shipping_name" class="form-control" name="shipping_name" value="<?php echo $row->shipping_line_name; ?>" autocomplete="off" autofocus="autofocus" 
													>
												</div>
											</div>
											
											<div class="form-group one_by_one">
												<label class="col-sm-12 control-label" for="form-field-1">
													Shipping Line Details
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Shipping Details" id="shipping_detail" class="form-control" name="shipping_detail" ></textarea>
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
												<label class="control-label col-sm-12 " for="form-field-1">
												Remarks:
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Remarks" id="remarks" class="form-control" name="remarks" value="" autocomplete="off" ></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Free Field 1:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Free Field 1" id="ff1" class="form-control" name="ff1" value="" autocomplete="off" >
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Free Field 2:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Free Field 2" id="ff2" class="form-control" name="ff2" value="" autocomplete="off" >
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Free Field 3:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Free Field 3" id="ff3" class="form-control" name="ff3" value="" autocomplete="off" >
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
									Shipping Line
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
												<th>Shipping Name</th>  
												<th>Shipping Details</th>  
												<th>Shipping Logo</th>  
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
                <h4 class="modal-title">  Shipping Line </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Shipping Line Name:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Shipping Name" id="edit_shipping_name" class="form-control" name="edit_shipping_name" value="<?php echo $row->shipping_line_name; ?>" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
							Shipping Line Details
						</label>
						<div class="col-sm-12">
							<textarea type="text" placeholder="Shipping Details" id="edit_shipping_detail" class="form-control" name="edit_shipping_detail" ></textarea>
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
							<a class="tooltips" name="shipping_file_view" id="shipping_file_view"  data-toggle="tooltip"  data-title="View" 
							href="" target="_blank"><i class="fa fa-eye"></i></a> 
							&nbsp;
							<a class="tooltips" name="shipping_file_download" id="shipping_file_download"  data-toggle="tooltip"  data-title="Download" 
							href="" target="_blank"><i class="fa fa-download"></i></a> 		
							&nbsp;
							
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
						<label class="control-label col-sm-12 " for="form-field-1">
						Free Field 1:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Free Field 1" id="edit_ff1" class="form-control" name="edit_ff1" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Free Field 2:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Free Field 2" id="edit_ff2" class="form-control" name="edit_ff2" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Free Field 3:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Free Field 3" id="edit_ff3" class="form-control" name="edit_ff3" value="" autocomplete="off" >
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
			if(data[5].indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             if (data[4] == "No" ) {        
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
			"sAjaxSource": root+'Shippingmaster/fetch_record/',
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

$("#shipping_line_form").validate({
	 rules: {
		shipping_name: {
			required: true
		}
		
	 },
	 messages: {
		shipping_name: {
			required: "Shipping Name Required"
		}
	 }
});


$("#edit_form").validate({
		rules: {
			edit_shipping_name: {
				required: true
			}
		},
		messages: {
			edit_shipping_name: {
				required: "Shipping Name Required"
			}
		}
	});

$(".select2").select2({
	width:'100%'
});
	
$("#shipping_line_form").submit(function(event) {
	event.preventDefault();
	if(!$("#shipping_line_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Shippingmaster/manage';
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
				   $("#shipping_line_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Shippingmaster' },1000);
				   
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#shipping_line_form").trigger('reset');
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
            url: 	root+'Shippingmaster/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_shipping_name").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				  
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Shippingmaster' },1500);
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
              url: root+"Shippingmaster/fetchshippingdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_shipping_name").val(obj.shipping_line_name);
					 					 					 			
					 $("#edit_shipping_detail").val(obj.shipping_line_details);
					 
					 //$("#edit_upload_logo").val(obj.shipping_logo);
					 
								
					if(obj.shipping_logo === "No file")
					{
						$("#shipping_file_view").hide();
						$("#shipping_file_download").hide();
						
						
					}
				
					else if(obj.shipping_logo === "")
					{
						$("#shipping_file_view").hide();
						$("#shipping_file_download").hide();	
					}
					
					else
					{
						$("#shipping_file_view").show();
						$("#shipping_file_download").show();
						
						$("#shipping_file_view").attr("href",root+'upload/shipping_logo/'+obj.shipping_logo);
						$("#shipping_file_download").attr("href",root+'Shippingmaster/download/'+obj.shipping_logo);
						
												
					}
					
					 
					 $("#edit_remarks").val(obj.remarks);
					 
					 $("#edit_ff1").val(obj.free_field_1);
					 
					 $("#edit_ff2").val(obj.free_field_2);
					 
					 $("#edit_ff3").val(obj.free_field_3);
					 					 																				 
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
					 
					 $("#editdocumentmode").val(obj.shipping_line_name);
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
              url: root+'Shippingmaster/archive_record',
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
					setTimeout(function(){ window.location=root+'Shippingmaster'; },1500);
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
	main_delete(deleleid,'Shippingmaster/deleterecord','shippingmaster')
}

function delete_image(deleleid)
{
	main_delete(deleleid,'Shippingmaster/delete_image','shippingmaster')
	
}
</script>
