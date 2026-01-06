<?php  $this->view('lib/header');  ?>

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
									&nbsp;Vessel Data
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Vessel Data</h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Vessel Data
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="vessel_data_form" name="vessel_data_form">
										<input type="hidden" placeholder="id" id="cmp_doc_setup_id" class="form-control" name="cmp_doc_setup_id" value="<?php echo $row->id; ?>" autocomplete="off" >
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												 Name:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Document Name" id="dname" class="form-control" name="dname" value="<?php echo $row->name; ?>" autocomplete="off" >
												</div>
											</div>
										
											
											<div class="form-group one_by_one">
												<label class="control-label col-sm-12" for="form-field-1">
													Details
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Document Details" id="details" class="form-control" name="details" autocomplete="off" value="<?php echo $row->details; ?>"></textarea>
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
									Vessel Data
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
												<th>Name</th>  
												<th>Details</th>  
													
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
                <h4 class="modal-title">Edit Vessel Data </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 
					 <div class="form-group">
							<label class="control-label col-sm-12 " for="form-field-1">
							Name:
							</label>
							
							<div class="col-sm-12">
								<input type="text" placeholder="Document Name" id="edit_dname" class="form-control" name="edit_dname" value="<?php echo $row->name; ?>" autocomplete="off" >
							</div>
					</div>
					
					
											
					<div class="form-group one_by_one">
								<label class="control-label col-sm-12" for="form-field-1">
								Details
								</label>
								<div class="col-sm-12">
									<textarea type="text" placeholder="Document Details" id="edit_details" class="form-control" name="edit_details" autocomplete="off" value="<?php echo $row->details; ?>"></textarea>
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
			if(data[3].indexOf('Unarchive') != -1)
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
			"sAjaxSource": root+'Vessel_data/fetch_record/',
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
 
			
$("#vessel_data_form").validate({
	 rules: {
		dname: {
			required: true
		},
		
		details:{
			required: true
		}
	 },
	 messages: {
		dname: {
			required: "Document Name Required"
		},
		
		details:{
			required: "Document details required"
		}
	 }
});

$("#edit_form").validate({
		rules: {
			edit_dname: {
				required: true
			},
			
			edit_details:{
				required: true
			}
		},
		messages: {
			edit_dname: {
				required: "Document Name Required"
			},
		
			edit_details:{
				required: "Document details required"
			}
		}
	});
	


	
$("#vessel_data_form").submit(function(event) {
	event.preventDefault();
	if(!$("#vessel_data_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Vessel_data/manage';
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
				   $("#vessel_data_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Vessel_data' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#vessel_data_form").trigger('reset');
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
            url: 	root+'Vessel_data/manage',
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
					 setTimeout(function(){ window.location=root+'Vessel_data' },1500);
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
              url: root+"Vessel_data/fetchdocumentdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_dname").val(obj.name);
							
					 $("#edit_details").val(obj.details);
					 
					
					 $("#editdocumentmode").val(obj.name);
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
              url: root+'Vessel_data/archive_record',
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
						unblock_page('success',"Data successfully unarchived");
					}
					else
					{
						unblock_page('success',"Data successfully archived");
					}
					setTimeout(function(){ window.location=root+'Vessel_data'; },1500);
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
	main_delete(deleleid,'Vessel_data/deleterecord','Vessel_data')
}
</script>