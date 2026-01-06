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
									Receive payment part List 
								</li>
							</ol>
							<div class="page-header">
							<h3>Receive payment part</h3>
						</div>
					</div>
					</div>
				 	<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add Receive payment part
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="receive_payment_part_add" id="receive_payment_part_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Receive payment part Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Receive payment part Name" id="receive_payment_part_name" class="form-control" name="receive_payment_part_name"/>
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
									Receive payment part List
						 		</div>
										
								<div class="panel-body">
								 	 <div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Receive payment part Name</th>
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
                <h4 class="modal-title">Edit Receive payment part</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_receive_payment_part" id="edit_receive_payment_part">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Receive payment part Name
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Receive payment part Name" id="edit_receive_payment_part_name" class="form-control" name="edit_receive_payment_part_name" value="" >
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
			"sAjaxSource": root+'receive_payment_part/fetch_record/',
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
	main_delete(deleleid,'receive_payment_part/deleterecord','receive_payment_part')
}
$("#receive_payment_part_add").validate({
		rules: {
			receive_payment_part_name: {
				required: true
			}
		},
		messages: {
			receive_payment_part_name: {
				required: "Enter Receive payment part Name"
			}
		}
	});
$("#edit_receive_payment_part").validate({
		rules: {
			edit_receive_payment_part_name: {
				required: true
			}
		},
		messages: {
			edit_receive_payment_part_name: {
				required: "Enter Receive payment part Name"
			}
		}
	});

$("#receive_payment_part_add").submit(function(event) {
	event.preventDefault();
	if(!$("#receive_payment_part_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'receive_payment_part/manage';
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
					$("#receive_payment_part_add").trigger('reset');
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

$("#edit_receive_payment_part").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_receive_payment_part").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'receive_payment_part/manage',
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
				   $("#edit_receive_payment_part").trigger('reset');
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

function edit_part(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"receive_payment_part/fetchdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(id);
					 $("#edit_receive_payment_part_name").val(obj.receive_payment_part_name);
			 	 	unblock_page("",""); 
                  }
              
          }); 

}	
 </script>