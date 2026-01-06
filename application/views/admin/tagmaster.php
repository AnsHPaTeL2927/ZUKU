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
									  &nbsp;Company Tag
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Company Tag</h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Company Tag
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="company_tag_form" name="company_tag_form">
										<input type="hidden" placeholder="id" id="tag_id" class="form-control" name="tag_id" value="<?php echo $row->tag_id; ?>" autocomplete="off" >
											<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Tag Name:
												</label>
												<div class="col-sm-12">
													<input type="text" placeholder="Company Tag Name" id="tagname" class="form-control" name="tagname" value="<?php echo $row->document_name; ?>" autocomplete="off" >
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
													<input type="text" placeholder="Order No" id="ornumber" class="form-control" name="ornumber" value="<?php echo $no->order_no+1 ?>" autocomplete="off" onkeypress="return onlyNumberKey(event)">
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
									Company Tag
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
												<th>Tag Name</th>  
												<th>Is Active</th>  	
												<th>Order No</th>  
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
                <h4 class="modal-title">Edit Company Tag </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 
					 <div class="form-group">
							<label class="control-label col-sm-12 " for="form-field-1">
							Tag Name:
							</label>
							
							<div class="col-sm-12">
								<input type="text" placeholder="Tag Name" id="edit_tagname" class="form-control" name="edit_tagname" value="<?php echo $row->document_name; ?>" autocomplete="off" >
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
							
							
							<div class="form-group" id="space">
								<label class="control-label col-sm-12" for="form-field-1">
									Order No:
								</label>
								<div class="col-sm-12">
									<input type="text" placeholder="Order No" id="edit_ornumber" class="form-control" name="edit_ornumber" value="" autocomplete="off" onkeypress="return onlyNumberKey(event)">
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
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'Tagmaster/fetch_record/',
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

$(".select2").select2({
	width:'100%'
});


//validate fields
$("#company_tag_form").validate({
	 rules: {
		tagname: {
			required: true
		},
		ornumber: {
			required: true
		},
		isactive:{
			required: true
		}
	 },
	 messages: {
		tagname: {
			required: "Tag Name Required"
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
			edit_tagname: {
				required: true
			},
			edit_ornumber: {
				required: true
			},
			edit_isactive:{
				required: true
			}
		},
		messages: {
			edit_tagname: {
			required: "Tag Name Required"
			},
			edit_ornumber:{
				required: "Order Number is Required"
			},
			edit_isactive:{
				required: "Active Status is Required"
			}
		}
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
	 
	 var url = root+'Tagmaster/manage';
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
				  $("#company_tag_form").trigger('reset');
					 datatable.DataTable().ajax.reload();
					setTimeout(function(){ window.location=root+'Tagmaster' },1500);
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

//for update
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
            url: 	root+'Tagmaster/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_tagname").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   //$(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Tagmaster' },1500);
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
              url: root+"Tagmaster/fetchtagdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				   // var edit_renewyes = document.getElementById("edit_renewyes");
				   // var edit_reminder = document.getElementById("edit_reminder");
				   // var edit_erdate = document.getElementById("edit_erdate");
				   
				
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_tagname").val(obj.tag_name);
					
					
					 $("#edit_ornumber").val(obj.order_no);
					 
					 // For Is_Active Radio Button fetch
					 if(obj.is_active == 'Yes')
					 {
						 $("#edit_yes").prop("checked",true)
					 }
					 else if(obj.is_active == 'No')
					 {
						 $("#edit_no").prop("checked",true)
					 }
					
					 
					 $("#editdocumentmode").val(obj.tag_name);
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
              url: root+'Tagmaster/archive_record',
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
					setTimeout(function(){ window.location=root+'Tagmaster'; },1500);
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
	main_delete(deleleid,'Tagmaster/deleterecord','Tagmaster')
}

</script>
 