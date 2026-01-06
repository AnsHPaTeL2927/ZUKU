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
									<a href="#">Product&nbsp;&nbsp; </a>   /  &nbsp;&nbsp;Finish 
								</li>
							</ol>
							<div class="page-header title1">
									<h3>Finish</h3>
									<div class="pull-right form-group" style="margin-top:-40px;">

										<div class="pull-right">
										
											<a href="<?php echo base_url('Model_list/index/'); ?>"  type="button" class="btn btn-primary">
												Design
											</a>
											 <a href="<?php echo base_url('Product_list/index/'); ?>"  type="button" class="btn btn-primary">
												Size
											</a>
											
											 <a href="<?php echo base_url('Series_list/index/'); ?>"  type="button" class="btn btn-primary">
												Product
											</a>
											
											<a href="<?php echo base_url('Calculation/index/'); ?>"  type="button" class="btn btn-primary">
												Calculator
											</a>
										</div>
								</div>
							</div>
					</div>
					</div>
				 	<div class="row" style="margin-top:30px;">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									  Finish
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="fumigation_add" id="fumigation_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Finish Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Finish Name" id="finish_name" class="form-control" name="finish_name" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Collection
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Collection" id="field1" class="form-control" name="field1" value="" autocomplete="off" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 2
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 2" id="field2" class="form-control" name="field2" value="" autocomplete="off" >
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
									Finish
						 		</div>
										
								<div class="panel-body">
								 	 <div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Finish Name</th>
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
                <h4 class="modal-title">Edit Finish</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_fumigation" id="edit_fumigation">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Finish Name
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Finish Name" id="edit_finish_name" class="form-control" name="edit_finish_name" value="" >
					 	</div>
					</div>
					<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Collection
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Collection" id="edit_field1" class="form-control" name="edit_field1" value="" autocomplete="off" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 2
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Field 2" id="edit_field2" class="form-control" name="edit_field2" value="" autocomplete="off" >
							</div>
						</div> 
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
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
			"sAjaxSource": root+'finish_list/fetch_record/',
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
	main_delete(deleleid,'finish_list/deleterecord','finish_list')
}
$("#fumigation_add").validate({
		rules: {
			finish_name: {
				required: true
			}
		},
		messages: {
			finish_name: {
				required: "Enter Finish Name"
			}
		}
	});
$("#edit_fumigation").validate({
		rules: {
			edit_finish_name: {
				required: true
			}
		},
		messages: {
			edit_finish_name: {
				required: "Enter Finish Name"
			}
		}
	});

$("#fumigation_add").submit(function(event) {
	event.preventDefault();
	if(!$("#fumigation_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'finish_list/manage';
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
				  $("#fumigation_add").trigger('reset');
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

$("#edit_fumigation").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_fumigation").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'finish_list/manage',
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
				    $("#myModal").modal('hide');
				   $("#edit_fumigation").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					datatable.DataTable().ajax.reload();
					// setTimeout(function(){ window.location=root+'payment_mode' },1500);
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

function editfumigation(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"finish_list/fetchdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(id);
					 $("#edit_finish_name").val(obj.finish_name);
					 $("#edit_field1").val(obj.field1);
					 $("#edit_field2").val(obj.field2);
			 	 	unblock_page("",""); 
                  }
              
          }); 

}	
 </script>