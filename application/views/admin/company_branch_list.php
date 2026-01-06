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
									<a href="javascript:;">Company Branch </a>  
								</li>
							</ol>
							<div class="page-header">
							<h3>Company Branch  </h3>
							<div class="pull-right ">
									<label  for="form-field-1">
												 Selection In Annexure On/Off
									 </label>
									<label class="switch">
										<input type="checkbox" <?=($setting_data->branch_code == 1)?"checked":""?> name="company_branch_status" value="1" id="company_branch_status" onclick="branch_code(this.checked)">
										<span class="slider round"></span>
									</label>
								</div>
						</div>
					</div>
					</div>
				 	<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								     Company Branch
							  </div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enccap="multipart/form-data" name="pallet_cap_add" id="pallet_cap_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Company Branch Code
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Company Branch Code" id="company_branch_code" class="form-control" name="company_branch_code" required title="Enter Company Branch Code" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Company Branch Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Company Branch Name" id="company_branch_name" class="form-control" name="company_branch_name" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Company Branch Address
											</label>
											<div class="col-sm-12">
												<textarea placeholder="Company Branch Address" id="company_branch_address" class="form-control"  name="company_branch_address" title="Enter Company Brnach Name"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 1
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 1" id="field1" class="form-control" name="field1" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 2
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 2" id="field2" class="form-control" name="field2" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 3
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 3" id="field3" class="form-control" name="field3" />
											</div>
										</div>
										
										<div class="form-group" style="" >
											<div class="col-sm-12">
												<button type="submit" class="btn btn-success">
													Save
												</button>
											</div>	
										</div>	
										 
									</form>
								</div>
							</div>
						 </div>
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Company Branch
					 		  </div>
										
								<div class="panel-body">
								 	 <div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Company Branch Code</th>
													<th>Company Branch Name</th>
													<th>Company Address</th>
												 	<th>Action</th>
												</tr>
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
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Branch Code</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_pallet_cap" id="edit_pallet_cap">
				<div class="modal-body">
					 <div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Company Branch Code
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Company Branch Code" id="edit_company_branch_code" class="form-control" name="edit_company_branch_code" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Company Branch Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Company Branch Name" id="edit_company_branch_name" class="form-control" name="edit_company_branch_name" title="Enter Company Brnach Name" required title="Enter Company Branch Name" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Company Branch Address
											</label>
											<div class="col-sm-12">
												<textarea placeholder="Company Branch Address" id="edit_company_branch_address" class="form-control" name="edit_company_branch_address"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 1
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 1" id="edit_field1" class="form-control" name="edit_field1" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 2
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 2" id="edit_field2" class="form-control" name="edit_field2" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 3
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 3" id="edit_field3" class="form-control" name="edit_field3" />
											</div>
										</div>
										
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="editcompanybranchcode" id="editcompanybranchcode" />
			 </form>
        </div>
    </div>
</div>

		 
<?php $this->view('lib/footer'); ?>
<script>
$(document).ready(function () {
	load_data_table();
});
 
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
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "No Records found in Database - Please add new record using entry form !",
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
			"sAjaxSource": root+'company_branch/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" });
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
function delete_record(deleleid)
{
	main_delete(deleleid,'company_branch/deleterecord','company_branch')
}
$("#pallet_cap_add").validate({
		rules: {
			company_branch_name: {
				required: true
			}
		},
		messages: {
			company_branch_name: {
				required: "Enter Company Branch Name"
			}
		}
	});
$("#edit_pallet_cap").validate({
		rules: {
			edit_company_branch_code: {
				required: true
			}
		},
		messages: {
			edit_company_branch_code: {
				required: "Enter Company Branch Name"
			}
		}
	});

$("#pallet_cap_add").submit(function(event) {
	event.preventDefault();
	if(!$("#pallet_cap_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'company_branch/manage';
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
				 
				   unblock_page("success","Sucessfully Saved.");
				  $("#pallet_cap_add").trigger('reset');
					datatable.DataTable().ajax.reload();
				//	setTimeout(function(){ window.location=root+'model_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist in database.");
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

$("#edit_pallet_cap").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_pallet_cap").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'company_branch/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			  
				if(obj.res==1 || $("#editcompanybranchcode").val() == obj.company_branch_code)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_fumigation").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					datatable.DataTable().ajax.reload();
					// setTimeout(function(){ window.location=root+'payment_mode' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist in database.");
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

function editpallet_cap(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"company_branch/fetchdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(id);
					 $("#edit_company_branch_code").val(obj.company_branch_code);
					 $("#editcompanybranchcode").val(obj.company_branch_code);
					 $("#edit_company_branch_name").val(obj.company_branch_name);
					 $("#edit_company_branch_address").val(obj.company_branch_address);
					 $("#edit_field1").val(obj.field1);
					 $("#edit_field2").val(obj.field2);
					 $("#edit_field3").val(obj.field3);
			 	 	unblock_page("",""); 
                  }
              
          }); 

}	
function branch_code(checked)
{
	block_page();
	var value = (checked == true)?1:0;
     $.ajax({ 
              type: "POST", 
              url: root+"company_branch/use_onoff",
              data: {"value": value}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				   
			 	 	unblock_page("",""); 
                  }
              
          }); 
}
 </script>