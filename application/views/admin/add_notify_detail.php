<?php 
$this->view('lib/header'); 
 
$form = " Add Notify Detail for ".$cust_detail->c_companyname;
 
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
								<li>
									<a href="<?=base_url()?>customer_detail">
										Customer List
									</a>
								</li>
								<li class="active">
									<?=$form?> 
								</li>
							</ol>
							<div class="page-header">
							<h3><?=$form?> </h3>
						</div>
					</div>
					</div>
				 	<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add Notify Detail
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="notify_add" id="notify_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Notify Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Notify Name" id="notify_name" class="form-control" name="notify_name" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Notify Address
											</label>
											<div class="col-sm-12">
												<textarea name="notify_address" id="notify_address" class="form-control" required title="Enter Notify Address" placeholder="Notify Address"></textarea>
											</div>
										</div>
										<div class="form-group" style="" >
											<div class="col-sm-12">
												<button type="submit" class="btn btn-success">
													Save
												</button>
												<a href="<?=base_url().'customer_detail'?>" class="btn btn-danger">
													Cancel
												</a>
											</div>	
										</div>	
									<input type="hidden" name="customer_id"	 id="customer_id" value="<?=$cust_detail->id?>" /> 
									</form>
								</div>
							</div>
						 </div>
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Notify Detail
						 		</div>
										
								<div class="panel-body">
								 	 <div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Notify Name</th>
													<th>Notify Address</th>
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
                <h4 class="modal-title">Edit Notify Detail</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_notify_add" id="edit_notify_add">
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Notify Name
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Notify Name" id="edit_notify_name" class="form-control" name="edit_notify_name" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Notify Address
						</label>
						<div class="col-sm-12">
							<textarea name="edit_notify_address" id="edit_notify_address" class="form-control"></textarea>
						</div>
					</div>
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
					<input type="hidden" name="edit_customer_id" id="edit_customer_id" value="<?=$cust_detail->id?>" /> 
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
			"sAjaxSource": root+'add_notify_detail/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "customer_id", "value": <?=$cust_detail->id?> });
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
	main_delete(deleleid,'Add_notify_detail/deleterecord','customer_detail')
	
}
$("#notify_add").validate({
		rules: {
			notify_name: {
				required: true
			}
		},
		messages: {
			notify_name: {
				required: "Enter Notify Name"
			}
		}
	});
$("#edit_notify_add").validate({
		rules: {
			edit_notify_name: {
				required: true
			}
		},
		messages: {
			edit_notify_name: {
				required: "Enter Notify Name"
			}
		}
	});

$("#notify_add").submit(function(event) {
	event.preventDefault();
	if(!$("#notify_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'add_notify_detail/manage';
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
				 
				   unblock_page("success","Sucessfully Inserted.");
				  $("#notify_add").trigger('reset');
					datatable.DataTable().ajax.reload();
				//	setTimeout(function(){ window.location=root+'model_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Already Added.");
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

$("#edit_notify_add").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_notify_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'add_notify_detail/manage',
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
				   $("#edit_notify_add").trigger('reset');
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

function edit_data(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_notify_detail/fetchdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(id);
					 $("#edit_notify_name").val(obj.notify_name);
					 $("#edit_notify_address").val(obj.notify_address);
			 	 	unblock_page("",""); 
                  }
              
          }); 

}	
 </script>