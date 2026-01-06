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
									<a href="#"> Master&nbsp;&nbsp; </a>   /  &nbsp;&nbsp; Box Design 
								</li>
							</ol>
							<div class="page-header">
							<h3>Box Design <p align="right">
                             
                            <a href="<?php echo base_url('pallet_type_list'); ?>"   type="button" class="btn btn-info">
								Pallet Type
							</a>    
                             <a href="<?php echo base_url('pallet_cap_list'); ?>"   type="button" class="btn btn-info">
								Pallet Cap
							</a>  
                             <a href="<?php echo base_url('fumigation_list'); ?>" type="button" class="btn btn-info">
								Fumigation
							</a> 
                            <a href="<?php echo base_url('box_design'); ?>"   type="button" class="btn btn-info">
								Box Design
							</a> 
                             <a href="<?php echo base_url('model_list'); ?>"  type="button" class="btn btn-info">
								Design
							</a>
                            </p>  </h3>
						</div>
					</div>
					</div>
				 
					 
					<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								     Box Design
							  </div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="box_design_form" id="box_design_form">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Box Design Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Box Design Name" id="box_design_name" class="form-control" name="box_design_name" /> 
											</div>
										</div>
										<div class="form-group design_file_control">
											<label class="col-sm-12 control-label" for="form-field-1">
												Box  Photo (jpg / PNG - NO PDF)
											</label>
											<div class="col-sm-12">
												<input type="file" placeholder="Design File" id="box_design_img" class="form-control" name="box_design_img" value="" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Remark Of Box Design 
											</label>
											<div class="col-sm-12">
												<textarea type="text" placeholder="Remark Of Box Design" id="box_design_remarks" class="form-control" name="box_design_remarks" ></textarea>
											</div>
										</div>
									<div class="form-group" style="text-align:center;" >
										<button type="submit" class="btn btn-success">
											Save
										</button>
									</div>	
										 
									</form>
								</div>
							</div>
						 </div>
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								Box Design 
								<a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
									<div id="myModal1" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">How To Manage Box Design</h4>
												</div>
												<div class="modal-body">
													<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/cply0fBpSxs?rel=0&autoplay=0"" frameborder="0" allowfullscreen></iframe>
												</div>
											</div>
										</div>
									</div>
									
							  </div>
										
								<div class="panel-body">
										 
									<div style="height: 70px;"></div>										
									<div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Box Design Name</th>
													<th>Box Photo</th>
													<th>Remark</th>
												 	<th>Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- end: RESPONSIVE TABLE PANEL -->
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
                <h4 class="modal-title">Edit Box Design </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Box Design Name
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Box Design Name" id="edit_box_design_name" class="form-control" name="edit_box_design_name" /> 
						</div>
					</div>
					<div class="form-group design_file_control">
						<label class="col-sm-12 control-label" for="form-field-1">
							Design Image
						</label>
						<div class="col-sm-10">
							<input type="file" placeholder="Design File" id="edit_box_design_img" class="form-control" name="edit_box_design_img" value="" >
						</div>
						<div class="col-sm-2">
							<img src="" id="design_file_view" height="50px" width="50px"/>
							 
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Remark Of Box Design 
								</label>
								<div class="col-sm-12">
									<textarea type="text" placeholder="Remark Of Box Design" id="edit_box_design_remarks" class="form-control" name="edit_box_design_remarks" ></textarea>
								</div>
					</div>
								  
			   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="design_file" id="design_file" />
				<input type="hidden" name="editbox_design_name" id="editbox_design_name" />
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
		
$(document).ready(function(){
		/* Get iframe src attribute value i.e. YouTube video url
		and store it in a variable */
    var url = $("#cartoonVideo").attr('src');
    
    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $("#myModal1").on('hide.bs.modal', function(){
        $("#cartoonVideo").attr('src', '');
    });
    
    /* Assign the initially stored url back to the iframe src
    attribute when modal is displayed again */
    $("#myModal1").on('show.bs.modal', function(){
        $("#cartoonVideo").attr('src', url);
    });
});

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
			"sAjaxSource": root+'box_design/fetch_record/',
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

 
function delete_record(deleleid)
{
	main_delete(deleleid,'box_design/deleterecord','box_design')
}
$("#box_design_form").validate({
		rules: {
			box_design_name: {
				required: true
			}
		},
		messages: {
			box_design_name: {
				required: "Enter Box Design Name"
			}
		}
	});
$("#edit_form").validate({
		rules: {
			edit_box_design_name: {
				required: true
			}
		},
		messages: {
			edit_box_design_name: {
				required: "Enter Box Design Name"
			}
		}
	});

$("#box_design_form").submit(function(event) {
	event.preventDefault();
	if(!$("#box_design_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	var string = $("#model_name").val();
	var url = root+'box_design/manage';
	 
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
					 $("#box_design_form").trigger('reset');
				     $("#model_name").val('');
				    $("#design_file").val('');
					datatable.DataTable().ajax.reload();
				//	setTimeout(function(){ window.location=root+'model_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist in database");
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
            url: 	root+'box_design/edit_record',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_box_design_name").val() == obj.box_design_name)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   $(".select2").val('').trigger('change');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'box_design' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist in database");
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

function edit_box_design(box_design_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"box_design/fetchdata",
              data: {"id": box_design_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(box_design_id);
					$("#edit_box_design_name").val(obj.box_design_name);
					$("#editbox_design_name").val(obj.box_design_name);
				 	$("#edit_box_design_remarks").val(obj.box_design_remarks);
				 	$("#design_file").val(obj.box_design_img);
					 
					if(obj.box_design_img === "")
					{
						$("#design_file_view").hide();
					}
					else{
						$("#design_file_view").show();
						$("#design_file_view").attr("src",root+"upload/box_design/"+obj.box_design_img)
					}
					 unblock_page("",""); 
                  }
              
          }); 

}	
 
</script>