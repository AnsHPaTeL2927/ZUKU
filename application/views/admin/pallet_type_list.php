<?php 
$this->view('lib/header'); 
 
?>


<style>
    .bs-example{
        margin: 20px;
    }
    .modal-content1 iframe{
        margin: 0 auto;
        display: block;
    }
</style>

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
									<a href="#"> Master&nbsp;&nbsp; </a>   /  &nbsp;&nbsp;Pallet Type 
								</li>
							</ol>
							<div class="page-header">
							<h3>Pallet Type  <p align="right">
                             
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
                            </p>
                             </h3>
						</div>
					</div>
					</div>
				 	<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								     Pallet Type
							  </div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="pallet_type_add" id="pallet_type_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Pallet Type
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Pallet Type" id="pallet_type" class="form-control" name="pallet_type" />
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
									
									Pallet Type 
									
									<a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
									<div id="myModal1" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">How To Manage Pallet Type</h4>
												</div>
												<div class="modal-body">
													<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/iNfEZdN7_Go?rel=0&autoplay=1"" frameborder="0" allowfullscreen></iframe>
												</div>
											</div>
										</div>
									</div>
					 		    </div>
 																								
								<div class="panel-body">
								 	 <div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Pallet Type</th>
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
                <h4 class="modal-title">Edit Pallet Type</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_pallet_type" id="edit_pallet_type">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Pallet Type
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Pallet Type" id="edit_pallettype" class="form-control" name="edit_pallettype" value="" >
					 	</div>
					</div>
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="editpallettype" id="editpallettype" />
			 </form>
        </div>
    </div>
</div>

		 
<?php $this->view('lib/footer'); ?>
<script>

function refreshPage(){
    window.location.reload();
} 

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
			"sAjaxSource": root+'pallet_type_list/fetch_record/',
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
	main_delete(deleleid,'pallet_type_list/deleterecord','pallet_type_list')
}
$("#pallet_type_add").validate({
		rules: {
			pallet_type: {
				required: true
			}
		},
		messages: {
			pallet_type: {
				required: "Enter Pallet Type"
			}
		}
	});
$("#edit_pallet_type").validate({
		rules: {
			edit_pallettype: {
				required: true
			}
		},
		messages: {
			edit_pallettype: {
				required: "Enter Pallet Type"
			}
		}
	});

$("#pallet_type_add").submit(function(event) {
	event.preventDefault();
	if(!$("#pallet_type_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'pallet_type_list/manage';
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
				  $("#pallet_type_add").trigger('reset');
					datatable.DataTable().ajax.reload();
				//	setTimeout(function(){ window.location=root+'model_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Pallet Type already exist.");
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

$("#edit_pallet_type").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_pallet_type").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'pallet_type_list/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_pallettype").val() == obj.pallettype)
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
					unblock_page("info","Pallet Type already exist.");
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

function editpallet_type(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"pallet_type_list/fetchdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(id);
					 $("#edit_pallettype").val(obj.pallet_type_name);
					 $("#editpallettype").val(obj.pallet_type_name);
			 	 	unblock_page("",""); 
                  }
              
          }); 

}	
 </script>