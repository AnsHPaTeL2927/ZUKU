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
									  &nbsp;Authority Address
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Authority Address</h3>
						</div>
						
				</div>
			</div>
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Authority Address
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="authority_address_form" name="authority_address_form">
																				
									
											<div class="form-group">
												<label class="col-sm-12 control-label" for="form-field-1">
														Authority Address
												</label>
												<div class="col-sm-12">
													<textarea id="authority_address" name="authority_address" placeholder="Authority Address" required="" class="form-control" required title="Enter Supplier Address"></textarea>
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
									Authority Address
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
												<th>Authority Address</th> 
																			
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
                <h4 class="modal-title">Edit Authority Address </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				
					
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
								Authority Address 
						</label>
						<div class="col-sm-12">
							<textarea id="edit_authority_address" name="edit_authority_address" placeholder="Authority Address" required="" class="form-control" required title="Enter Authority Address"></textarea>
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
			"sAjaxSource": root+'Authority_address/fetch_record/',
			
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "status", "value": $("#status").val() });
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			
			"createdRow": function(row, data, dataIndex ) {
			if(data[3].indexOf('Unarchive') != -1)
			{
				$('td', row).css('background-color', '#CDCDCD');
			}
             if (data[2] == "No" ) {        
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

$("#authority_address_form").validate({
	 rules: {
		authority_address: {
			required: true
		}
		
	 },
	 messages: {
		authority_address: {
			required: "Address Required"
		}
	 }
});


$("#edit_form").validate({
		rules: {
			edit_authority_address: {
				required: true
			}
		},
		messages: {
			edit_authority_address: {
				required: "Address Required"
			}
		}
	});

$("#authority_address_form").submit(function(event) {
	event.preventDefault();
	if(!$("#authority_address_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Authority_address/manage';
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
				   $("#authority_address_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Authority_address' },1000);
				   
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#authority_address_form").trigger('reset');
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
            url: 	root+'Authority_address/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_authority_address").val() == obj.editsupplier)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   //$(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Authority_address' },1000);
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
              url: root+"Authority_address/fetchmodeldata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 $("#edit_authority_address").val(obj.authority_address);
					 $("#editsupplier").val(obj.authority_address);
									 
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
              url: root+'Authority_address/archive_record',
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
						unblock_page('success',"Address successfully unarchived");
					}
					else
					{
						unblock_page('success',"Address successfully archived");
					}
					setTimeout(function(){ window.location=root+'Authority_address'; },1500);
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
	main_delete(deleleid,'Authority_address/deleterecord','authority_address')
}


</script>
