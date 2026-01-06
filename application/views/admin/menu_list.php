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
									Menu List
								</li>
							</ol>
							<div class="page-header">
							<h3>Menu List</h3>
						</div>
					</div>
					</div>
				 	<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add Menu
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enccap="multipart/form-data" name="menu_add" id="menu_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Menu Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Menu Name" id="menu_name" class="form-control" name="menu_name" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Url Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Url Name" id="url_name" class="form-control" name="url_name" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Fa Icon
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Fa Icon" id="fa_icon" class="form-control" name="fa_icon" />
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
										<div class="form-group" style="" >
											<div class="col-sm-12">
												<button type="submit" class="btn btn-success">
													Save
												</button>
											</div>	
										</div>	
										 <input type="hidden" name="pid" id="pid" />
									</form>
								</div>
							</div>
						 </div>
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Menu List
						 		</div>
										
								<div class="panel-body">
									<button  type="button" class="btn btn-info pull-right return_btn" onclick="return_main();" style="display:none">
										Return
									</button>
								 	 <div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Menu Name</th>
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
                <h4 class="modal-title">Edit Menu</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_menu" id="edit_menu">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Menu Name
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Menu Name" id="edit_menu_name" class="form-control" name="edit_menu_name" value="">
					 	</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Url Name
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Url Name" id="edit_url_name" class="form-control" name="edit_url_name" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Fa Icon
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Fa Icon" id="edit_fa_icon" class="form-control" name="edit_fa_icon" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Order By
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Order By" id="edit_order_by" class="form-control" name="edit_order_by" />
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
			"sAjaxSource": root+'menu_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "pid", "value": $("#pid").val() });
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
	main_delete(deleleid,'menu_list/deleterecord','menu_list')
}
$("#menu_add").validate({
		rules: {
			menu_name: {
				required: true
			}
		},
		messages: {
			menu_name: {
				required: "Enter Menu Name"
			}
		}
	});
$("#edit_menu").validate({
		rules: {
			edit_menu_name: {
				required: true
			}
		},
		messages: {
			edit_menu_name: {
				required: "Enter User type"
			}
		}
	});

$("#menu_add").submit(function(event) {
	event.preventDefault();
	if(!$("#menu_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'menu_list/manage';
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
				  $("#menu_add").trigger('reset');
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

$("#edit_menu").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_menu").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'menu_list/update_record',
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
				    $("#edit_menu").trigger('reset');
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

function editmenu(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"menu_list/fetchdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(id);
					 $("#edit_menu_name").val(obj.menu_name);
					 $("#edit_url_name").val(obj.url_name);
					 $("#edit_fa_icon").val(obj.fa_icon);
					 $("#edit_order_by").val(obj.order_by);
			 	 	unblock_page("",""); 
                  }
              
          }); 

}
function add_submenu(id)
{
	$("#pid").val(id);
	$(".return_btn").show();
	datatable.DataTable().ajax.reload();
}
function return_main()
{
	$("#pid").val(0);
	$(".return_btn").hide();
	datatable.DataTable().ajax.reload();
}	
 </script>