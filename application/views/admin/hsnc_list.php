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
									<a href="#"> Master&nbsp;&nbsp; </a>   /  &nbsp;&nbsp;HSNC Code
								</li>
							</ol>
							<div class="page-header">
							<h3>HSN Code </h3>
						</div>
					</div>
					</div>
				 
					 
					<div class="row">
						<div class="col-sm-3">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								     HSN
							  </div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="hsnc_add" id="hsnc_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												HSN Code 
										  </label>
											<div class="col-sm-12">
												<input type="text" placeholder="HSN Name" id="hsnc_code" class="form-control" name="hsnc_code" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Order By
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Order By" id="order_by" class="form-control" name="order_by" />
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
							  HSN
							  <a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
									<div id="myModal1" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">How To Manage HSN Code</h4>
												</div>
												<div class="modal-body">
													<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/ctjady_kjck?rel=0&autoplay=0"" frameborder="0" allowfullscreen></iframe>
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
													<th>HSN Code</th>
													<th>Order By</th>
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
                <h4 class="modal-title">Edit HSN </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		HSN Code
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="HSN Code" id="edit_hsnc_code" class="form-control" name="edit_hsnc_code" value="" >
					 	</div>
					</div>
					<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Order By
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Order By" id="edit_order_by" class="form-control" name="edit_order_by" value="" >
					 	</div>
					</div>
			   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="edit_hsnccode" id="edit_hsnccode" />
			 </form>
        </div>
    </div>
</div>

		 
<?php $this->view('lib/footer'); ?>
<script>
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
			"sAjaxSource": root+'hsnc_list/fetch_record/',
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
	main_delete(deleleid,'hsnc_list/deleterecord','hsnc_list')
}
$("#hsnc_add").validate({
		rules: {
			hsnc_code: {
				required: true
			}
		},
		messages: {
			hsnc_code: {
				required: "Enter HSN Code"
			}
		}
	});
$("#edit_form").validate({
		rules: {
			edit_hsnc_code: {
				required: true
			}
		},
		messages: {
			edit_hsnc_code: {
				required: "Enter HSN Code"
			}
		}
	});

$("#hsnc_add").submit(function(event) {
	event.preventDefault();
	if(!$("#hsnc_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'hsnc_list/manage';
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
				     $("#model_name").val('');
				    $("#design_file").val('');
					datatable.DataTable().ajax.reload();
				//	setTimeout(function(){ window.location=root+'model_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist.");
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
            url: 	root+'hsnc_list/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_hsnc_code").val() == obj.edit_hsnccode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'hsnc_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
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
              url: root+"hsnc_list/fetchhsncdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(id);
					 $("#edit_hsnc_code").val(obj.hsnc_code);
					 $("#edit_hsnccode").val(obj.hsnc_code);
					 $("#edit_order_by").val(obj.orderby);
					 
				 	unblock_page("",""); 
                  }
              
          }); 

}	
 </script>