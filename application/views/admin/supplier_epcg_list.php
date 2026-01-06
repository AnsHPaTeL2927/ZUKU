<?php 
$this->view('lib/header'); 
 $form = "Supplier EPCG"; 
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
									<a href="<?=base_url()?>supplier_list"> Supplier List </a>
								</li>
								<li class="active">
									<?=$form?> List Of <span><?=$epcg_data->company_name?></span>
								</li>
								 
							</ol>
							<div class="page-header">
							<h3><?=$form?> List Of <span><?=$epcg_data->company_name?></span>
						</div>
					</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add <?=$form?>
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="epcg_add" id="epcg_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												EPCG No
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="EPCG No" id="epcg_no" class="form-control" name="epcg_no" value="" autocomplete="off" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												EPCG Date
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="EPCG Date" id="epcg_date" class="form-control defualt-date-picker" name="epcg_date" value="" autocomplete="off" required title="Select Date" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												EPCG Amount in INR
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="EPCG Amount in INR" id="epcg_amount" class="form-control" name="epcg_amount" value="" autocomplete="off"  title="Enter Amount in INR" >
											</div>
										</div>
										<div class="form-group col-md-12" >
											<button type="submit" class="btn btn-success">
												Save
											</button>
											<a href="<?=base_url()?>supplier_list" class="btn btn-danger">
												Cancel
											</a>
										</div>
										<input type="hidden" name="supplier_id" id="supplier_id"  value="<?=$supplier_id?>"  />
										
									 </form>
								</div>
							</div>
							 
						</div>
					 
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								<?=$form?> List
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>EPCG Detail</th>
													<th>EPCG Date</th>
													<th>EPCG Amount</th>
												 	<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											<?php 
										$m=1;
										 
											for($i=0; $i<count($epcgdata);$i++)
											{
												 
											?>
												<tr>
													<td><?=$m?></td>
													 <td><?=$epcgdata[$i]->epcg_no?></td> 
													 <td><?=date('d-m-Y',strtotime($epcgdata[$i]->epcg_date))?></td>
													 <td><?=$epcgdata[$i]->epcg_amount?></td>
													 <td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_product(<?=$epcgdata[$i]->supplie_epcg_id?>);"><i class="fa fa-pencil"></i> Edit</a>
																		</li>
																		<?php 
																		if($epcgdata[$i]->total_cnt==0)
																		{
																		?>
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$epcgdata[$i]->supplie_epcg_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
																	 	</li>
																		<?php 
																		}
																		?> 
																	  </ul>
																	</div>
													 
													</td>
													
												</tr>
										<?php
											$m++;
										}
										 
										?>	
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
                <h4 class="modal-title">Edit EPCG  List Of <span><?=$epcg_data->company_name?></span></h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				 	<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Detail
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Detail" id="edit_epcg_detail" class="form-control" name="edit_epcg_detail" value="" >
					 	</div>
					</div>
				       <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Date
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Date" id="edit_epcg_date" class="form-control defualt-date-picker" name="edit_epcg_date" value="" required title="Select Date">
					 	</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							EPCG Amount in INR
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="EPCG Amount in INR" id="edit_epcg_amount" class="form-control" name="edit_epcg_amount" value="" autocomplete="off" required title="Enter Amount in INR" >
						</div>
					</div>
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="edit_supplier_id" id="edit_supplier_id" value="<?=$supplier_id?>" />
			 </form>
        </div>
    </div>
</div>

		 
<?php $this->view('lib/footer'); ?>
<script>

$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   
			});
		});
 
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 $("#epcg_add").validate({
		rules: {
			epcg_no: {
				required: true
			}
		},
		messages: {
			epcg_no: {
				required: "Enter EPCG Detail"
			}
		}
	});
function delete_record(deleleid)
{
	main_delete(deleleid,'supplier_epcg_list/deleterecord','supplier_epcg_list/index/'+<?=$supplier_id?>)
}
$("#epcg_add").validate({
		rules: {
			epcg_no: {
				required: true
			}
		},
		messages: {
			epcg_no: {
				required: "Enter EPCG Detail"
			}
		}
	});

$("#edit_form").validate({
	rules: {
		edit_epcg_detail: {
			required: true
		}
	},
	messages: {
		edit_epcg_detail: {
			required: "Enter EPCG Detail"
		}
	}
});
$("#epcg_add").submit(function(event) {
	event.preventDefault();
	if(!$("#epcg_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url : root+'supplier_epcg_list/manage',
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
				   $("#series_add").trigger('reset');
				   unblock_page("success","Sucessfully Inserted.");
				   setTimeout(function(){ window.location=root+'supplier_epcg_list/index/'+<?=$supplier_id?> },1500);
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","EPCG Already Exits.");
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
            url: 	root+'supplier_epcg_list/edit_record',
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
					$("#edit_form").trigger('reset');
				     unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'supplier_epcg_list/index/<?=$supplier_id?>' },1500);
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

function edit_product(supplie_epcg_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"supplier_epcg_list/fetchdata",
              data: {"id": supplie_epcg_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(supplie_epcg_id);
				 	$("#edit_epcg_detail").val(obj.epcg_no);
					var date = obj.epcg_date.split("-");
					 
				 	newDate = date[2]+'-'+date[1]+'-'+date[0];
				 	$("#edit_epcg_date").val(newDate);
				    $('.defualt-date-picker').datepicker({
						autoclose:true,
						format:'dd-mm-yyyy',
						
					});
					
					$("#edit_epcg_amount").val(obj.epcg_amount);
					unblock_page("",""); 
                  }
              
          }); 

}	

</script>