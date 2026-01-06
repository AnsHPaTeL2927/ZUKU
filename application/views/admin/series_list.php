<?php 
$this->view('lib/header'); 
 $form = "Product"; 
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
									<a href="#">Product&nbsp;&nbsp; </a>   /  <?=$form?> 
								</li>
								
							</ol>
							<div class="page-header title1">
									<h3> <?=$form?></h3>
									<div class="pull-right form-group" style="margin-top:-40px;">

										<div class="pull-right">
										
											<a href="<?php echo base_url('Model_list/index/'); ?>"  type="button" class="btn btn-primary">
												Design
											</a>
											 <a href="<?php echo base_url('Product_list/index/'); ?>"  type="button" class="btn btn-primary">
												Size
											</a>
											
											<a href="<?php echo base_url('Finish_list/index/'); ?>"  type="button" class="btn btn-primary">
												Finish
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
									  <?=$form?>
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="series_add" id="series_add">
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												HSN Code
											</label>
											<div class="col-sm-12">
											<select class="form-control" name="hsnc_code" id="hsnc_code">
											<?php
												for($h=0;$h<count($hsnc_data);$h++)
												{
													$sel= '';
													if($hsnc_data[$h]->hsnc_code==$edit_record->hsnc_code)
													{
														$sel = 'selected="selected"';
													}											
												?>
													<option <?=$sel?> value="<?=$hsnc_data[$h]->hsnc_code ?>" ><?=$hsnc_data[$h]->hsnc_code?> </option>
													
												<?php 
												}?>
											</select>
											</div>
										</div> 	
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Product Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Product Name" id="series_name" class="form-control" name="series_name" value="" autocomplete="off" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Water Absorption
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Water Absorption" id="water_absorption" class="form-control" name="water_absorption" value="" autocomplete="off" >
											</div>
										</div>
									<div class="form-group">
									
										<label class="col-sm-12 control-label" for="form-field-1">
												Sale (Unit)
										</label>
										<div class="col-sm-12">
											<select  name="sale_unit" id="sale_unit" class="form-control" >
												<option value="">Choose Sale Unit</option>
												<option value="SQM">SQM</option>
												<option value="BOX">BOX</option>
												<option value="SQF">SQF</option>
												<option value="PCS">PCS</option>
											</select>
									
										</div>
									</div>
									
									<div class="form-group">
									
										<label class="col-sm-12 control-label" for="form-field-1">
												Purchase (Unit)
										</label>
										<div class="col-sm-12">
											<select  name="purchase_unit" id="purchase_unit" class="form-control" >
											<option value="">Choose Purchase Unit</option>
												<option value="SQM">SQM</option>
												<option value="BOX">BOX</option>
												<option value="SQF">SQF</option>
												<option value="PCS">PCS</option>
											</select>
									
										</div>
									</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 1
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 1" id="field1" class="form-control" name="field1" value="" autocomplete="off" >
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
										
									
										
										<div class="form-group col-md-12" >
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
								Product 
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>HSN Code</th>
													<th>Product Name</th>
													<th>Sale (Unit)</th>
													<th>Purchase (Unit)</th>
												 	<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											<?php 
										$m=1;
											for($i=0; $i<count($seriesdata);$i++)
											{
												 
											?>
												<tr>
													<td><?=$m?></td>
													<td><?=$seriesdata[$i]->hsnc_code?></td>
													<td><?=$seriesdata[$i]->series_name?></td>
													<td><?=$seriesdata[$i]->sale_unit?></td>
													<td><?=$seriesdata[$i]->purchase_unit?></td>
													 <td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_product(<?=$seriesdata[$i]->series_id?>);"><i class="fa fa-pencil"></i> Edit</a>
																		</li>
																		<?php 
																		if($seriesdata[$i]->total_cnt==0)
																		{
																		?>
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$seriesdata[$i]->series_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
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
										} ?>
											
												
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
                <h4 class="modal-title">Edit Product </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 <div class="form-group">
						 	<label class="col-sm-12 control-label" for="form-field-1">
						 		HSN Code
						 	</label>
						 	<div class="col-sm-12">
						 	<select class="form-control" name="edit_hsnc_code" id="edit_hsnc_code">
						 	<?php
						 		for($h=0;$h<count($hsnc_data);$h++)
						 		{
						 		?>
						 			<option <?=$sel?> value="<?=$hsnc_data[$h]->hsnc_code ?>" ><?=$hsnc_data[$h]->hsnc_code?> </option>
						 			
						 		<?php 
						 		}?>
						 	</select>
					 	</div>
					</div> 
					<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Product Name
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Product Name" id="edit_series_name" class="form-control" name="edit_series_name" value="" >
					 	</div>
					</div>
				     <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Water Absorption
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Water Absorption" id="edit_water_absorption" class="form-control" name="edit_water_absorption" value="" >
					 	</div>
					</div> 
					<div class="form-group">
									
						<label class="col-sm-12 control-label" for="form-field-1">
								Sale (Unit)
						</label>
						<div class="col-sm-12">
							<select  name="edit_sale_unit" id="edit_sale_unit" class="form-control" >
							<option value="">Choose Sale Unit</option>
								<option value="SQM">SQM</option>
								<option value="BOX">BOX</option>
								<option value="SQF">SQF</option>
								<option value="PCS">PCS</option>
							</select>
					
						</div>
					</div>
					
					<div class="form-group">
					
						<label class="col-sm-12 control-label" for="form-field-1">
								Purchase (Unit)
						</label>
						<div class="col-sm-12">
							<select  name="edit_purchase_unit" id="edit_purchase_unit" class="form-control" >
							<option value="">Choose Purchase Unit</option>
								<option value="SQM">SQM</option>
								<option value="BOX">BOX</option>
								<option value="SQF">SQF</option>
								<option value="PCS">PCS</option>
							</select>
					
						</div>
					</div>
					
					<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 1
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Field 1" id="edit_field1" class="form-control" name="edit_field1" value="" autocomplete="off" >
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
			$('#sample-table-1').DataTable({
			   "order": [[ 0, "asc" ]],
			    "lengthMenu": [ 50, 10, 25, 75, 100 ],
				'columnDefs': [
				{
					"targets": 0, // your case first column
					"className": "text-center",
					"width": "4%"
				}]
			});
		});
 
function delete_record(deleleid)
{
	main_delete(deleleid,'series_list/deleterecord','series_list')
}
$("#series_add").validate({
		rules: {
			series_name: {
				required: true
			}
		},
		messages: {
			series_name: {
				required: "Enter Product Name"
			}
		}
	});

$("#edit_form").validate({
	rules: {
		edit_series_name: {
			required: true
		}
	},
	messages: {
		edit_series_name: {
			required: "Enter Product Name"
		}
	}
});
$("#series_add").submit(function(event) {
	event.preventDefault();
	if(!$("#series_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url : root+'series_list/manage',
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
				   unblock_page("success","Sucessfully saved.");
				   setTimeout(function(){ window.location=root+'series_list' },1500);
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
            url: 	root+'series_list/edit_record',
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
					 setTimeout(function(){ window.location=root+'series_list' },1500);
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

function edit_product(series_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"series_list/fetchseriesdata",
              data: {"id": series_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(series_id);
				 	$("#edit_series_name").val(obj.series_name);
				 	$("#edit_hsnc_code").val(obj.hsnc_code);
				 	$("#edit_water_absorption").val(obj.water_text);
					$("#edit_sale_unit").val(obj.sale_unit);
					$("#edit_purchase_unit").val(obj.purchase_unit);
				 	$("#edit_field1").val(obj.field1);
				 	$("#edit_field2").val(obj.field2);
					 
					unblock_page("",""); 
                  }
              
          }); 

}	

</script>