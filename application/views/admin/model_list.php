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
									<a href="#">Product&nbsp;&nbsp; </a>   /  &nbsp;&nbsp;Design
								</li>
							</ol>
							<div class="page-header form-group">
									<h3>Design</h3>
									<div class="pull-right form-group" style="margin-top:-40px;">

										<div class="pull-right">
											 <a href="<?php echo base_url('Product_list/index/'); ?>"  type="button" class="btn btn-primary" >
												Size
											</a>
											<a href="<?php echo base_url('Finish_list/index/'); ?>"  type="button" class="btn btn-primary">
												Finish
											</a>
											 <a href="<?php echo base_url('Series_list/index/'); ?>"  type="button" class="btn btn-primary" >
												Product
											</a>
											
											<a href="<?php echo base_url('Calculation/index/'); ?>"  type="button" class="btn btn-primary">
												Calculator
											</a>
										</div>
								</div>
							</div>
				 
					 
					<div class="row" style="margin-top:30px;">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 New Design
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="model_add" id="model_add">
										<div class="form-group">
											<div class="col-md-12">
													<label class="radio-inline">
														<input type="radio" name="folder_option" id="folder_option1" value="1" checked="" onclick="filterbystatus(this.value)">One By One
													</label>
													<label class="radio-inline">
														<input type="radio" name="folder_option" id="folder_option2" value="2" onclick="filterbystatus(this.value)"> Folder 			
													</label>
												  </div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Product 
											</label>
											<div class="col-sm-12">
												<select class="select2" name="product_id" id="product_id" required title="Select Product"  >
													<option value="">Select Product</option>
													<?php
													for($p=0;$p<count($productdata);$p++)
													{
														$thickness = (!empty($productdata[$p]->thickness))?" - ".$productdata[$p]->thickness." MM":"";
														echo "<option value='".$productdata[$p]->product_id."'>".$productdata[$p]->size_type_mm." (".$productdata[$p]->series_name.")".$thickness."</option>";
													}
													?>
												</select>
											</div>
										</div>
									 	<div class="form-group one_by_one">
											<label class="col-sm-12 control-label" for="form-field-1">
												Design Name
											</label>
											<div class="col-sm-12">
												<textarea type="text" placeholder="Design Name" id="model_name" class="form-control" name="model_name" onkeyup="change_string()"></textarea>
											</div>
										</div>
										 <div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Factory  
											</label>
											<div class="col-sm-12">
												<select class="select2" name="factory_id" id="factory_id" title="Select Factory">
													 <option value=''>Select Factory </option>
													<?php
													for($p=0;$p<count($supdata);$p++)
													{
													 	echo "<option value='".$supdata[$p]->supplier_id."'>".$supdata[$p]->company_name." </option>";
													}
													?> 
												</select>
											</div>
										</div> 
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Finish <a href="<?=base_url().'finish_list'?>" target="_blank">New Finish</a>
											</label>
											<div class="col-sm-12">
												<select class="select2" name="finish_id[]" id="finish_id" title="Select Finish" multiple data-placeholder="Select Finish">
													 
													<?php
													for($p=0;$p<count($finishdata);$p++)
													{
													 	echo "<option value='".$finishdata[$p]->finish_id."'>".$finishdata[$p]->finish_name." </option>";
													}
													?> 
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												No of randome
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="No of randome" id="no_of_randome" class="form-control" name="no_of_randome" value="" >
											</div>
										</div>
										
										<!-- <div class="form-group design_file_control one_by_one">
											<label class="col-sm-12 control-label" for="form-field-1">
												Design Image
											</label>
											<div class="col-sm-12">
												<input type="file" placeholder="Design File" id="design_file" class="form-control" name="design_file" value="" accept="image/*">
											</div>
										</div> -->
										<div class="form-group design_file_control one_by_one">
											<label class="col-sm-12 control-label" for="form-field-1">Design Image</label>
											<div class="col-sm-12">
												<input type="file" id="design_file" name="design_file" class="form-control" accept="image/jpeg">
												<p id="alert-message" style="color: red;"></p> <!-- Alert message below file input -->
												<p id="file-size" style="font-weight: bold;"></p> <!-- Display image size in bold -->
											</div>
										</div>
										<div class="form-group folderoption" style="display:none">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Design Folder
											</label>
											<div class="col-sm-12">
												<input type="file" placeholder="Design Folder" id="design_folder" class="form-control" name="design_folder[]" value="" directory="" webkitdirectory=""multiple>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 1
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 1 " id="field1" class="form-control" name="field1" value="" autocomplete="off" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Punch
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Punch " id="field2" class="form-control" name="field2" value="" autocomplete="off" >
											</div>
										</div> 
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 3
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 3" id="field3" class="form-control" name="field3" value="" autocomplete="off" >
											</div>
										</div> 
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 4
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 4" id="field4" class="form-control" name="field4" value="" autocomplete="off" >
											</div>
										</div> 
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Field 5
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Field 5" id="field5" class="form-control" name="field5" value="" autocomplete="off" >
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
								Design
									
								</div>
										
								<div class="panel-body">
										<div class="form-group">
											<label class="col-md-2 control-label" style="margin-top: 5px;">
												<strong class=""> Select Product</strong>
											</label>
											 <div class="col-md-4">
												<select class="select2" name="filter_product_id" id="filter_product_id" required title="Select Product" onchange="load_data_table()" >
													<option value="">All Product</option>
														<?php
														for($p=0;$p<count($productdata);$p++)
														{
															$sel = '';
															if($productdata[$p]->product_id == $_SESSION['modal_filter_product_id'])
															{
																$sel = 'selected="selected"';
															}
															echo "<option ".$sel." value='".$productdata[$p]->product_id."'>".$productdata[$p]->size_type_mm." (".$productdata[$p]->series_name.") - ".$productdata[$p]->thickness." MM</option>";
														}
														?>
												</select>
											</div>	
											<label class="col-md-2 control-label" style="margin-top: 5px;">
												<strong class=""> Select Finish</strong>
											</label>
											<div class="col-sm-4">
												<select class="select2" name="finishid" id="finishid" required title="Select Finish" onchange="load_data_table()" >
													<option value="">All Finish</option>
													<?php
													for($p=0;$p<count($finishdata);$p++)
													{
															$sel = '';
															if($finishdata[$p]->finish_id == $_SESSION['modal_filter_finish_id'])
															{
																$sel = 'selected="selected"';
															}
													 	echo "<option ".$sel." value='".$finishdata[$p]->finish_id."'>".$finishdata[$p]->finish_name." </option>";
													}
													?> 
												</select>
											</div>
										</div>
									<div style="height: 70px;"></div>										
									<div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Product Size</th>
													<th>Design Name</th>
													<th>Finish Name</th>
													<th>Design Image</th>
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
                <h4 class="modal-title">Edit Design </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					<div class="form-group">
						 <label class="col-sm-12 control-label" for="form-field-1">
							 Select Product 
						 </label>
					 <div class="col-sm-12">
						 <select class="select2" name="edit_product_id" id="edit_product_id" required title="Select Product"   >
							<option value="">Select Product</option>
								<?php
								for($p=0;$p<count($productdata);$p++)
								{
									$thickness = (!empty($productdata[$p]->thickness))?" - ".$productdata[$p]->thickness." MM":"";
									echo "<option value='".$productdata[$p]->product_id."'>".$productdata[$p]->size_type_mm." (".$productdata[$p]->series_name.")".$thickness."</option>";
								}
								?>
						 </select>
					 </div>
				  </div>
					 
					<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Design Name
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Model Name" id="edit_model_name" class="form-control" name="edit_model_name" value="" >
					 	</div>
					</div>
				      <div class="form-group">
						 	<label class="col-sm-12 control-label" for="form-field-1">
						 		Design Image
						 	</label>
						 	<div class="col-sm-8">
						 		<input type="file" placeholder="Design File" id="edit_design_file" class="form-control" name="edit_design_file" value="">
						 	</div>
							<div class="col-md-2" style="">
								<p style="margin: 0 auto;width:80px;height:80px;overflow:hidden;position: relative;border: 1px solid;">
									<a href="" data-fancybox="gallery" class="gallery" data-caption="">
										<img src="" style="width:70px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;" name="design_file_view" id="design_file_view"/> 
									</a>
								 </p>
											 
							</div>
						 </div>
						 <div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Select Factory  
							</label>
							<div class="col-sm-12">
								<select class="select2" name="edit_factory_id" id="edit_factory_id" title="Select Factory"    >
									 <option value=''>Select Factory </option>
									<?php
									for($p=0;$p<count($supdata);$p++)
									{
									 	echo "<option value='".$supdata[$p]->supplier_id."'>".$supdata[$p]->company_name." </option>";
									}
									?> 
								</select>
							</div>
						 </div> 
						 <div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Select Finish <a href="<?=base_url().'finish_list'?>">New Finish</a>
							</label>
							<div class="col-sm-12">
								<select class="select2" name="edit_finish_id[]" id="edit_finish_id" title="Select Finish" multiple  data-placeholder="Select Finish">
									
									<?php
									for($p=0;$p<count($finishdata);$p++)
									{
										echo "<option value='".$finishdata[$p]->finish_id."'>".$finishdata[$p]->finish_name." </option>";
									}
									?> 
								
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								No of randome
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="No of randome" id="edit_no_of_randome" class="form-control" name="edit_no_of_randome" value="" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 1 
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Filed 1 " id="edit_field1" class="form-control" name="edit_field1" value="" autocomplete="off" >
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
						<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 3
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Field 3" id="edit_field3" class="form-control" name="edit_field3" value="" autocomplete="off" >
							</div>
						</div> 
						<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 4
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Field 4" id="edit_field4" class="form-control" name="edit_field4" value="" autocomplete="off" >
							</div>
						</div> 
						<div class="form-group">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 5
							</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Field 5" id="edit_field5" class="form-control" name="edit_field5" value="" autocomplete="off" >
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
document.getElementById('design_file').addEventListener('change', function(event) {
	const file = event.target.files[0];
	const alertMessage = document.getElementById('alert-message');
	alertMessage.textContent = ''; 

	if (file && file.type === 'image/jpeg') {
		// Display original size
		let fileSizeInKB = (file.size / 1024).toFixed(2);
		document.getElementById('file-size').textContent = `Original Size: ${fileSizeInKB} KB`;

		if (file.size > 200 * 1024) {
			compressTo200KB(file); 
		}
	} else {
		alertMessage.textContent = 'Please upload a JPG image.';
		event.target.value = ''; 
	}
});

function compressTo200KB(file) {
	const reader = new FileReader();
	reader.onload = function(event) {
		const img = new Image();
		img.src = event.target.result;

		img.onload = function() {
			const canvas = document.createElement('canvas');
			const ctx = canvas.getContext('2d');
			canvas.width = img.width;
			canvas.height = img.height;
			ctx.drawImage(img, 0, 0);

			let quality = 0.9; 
			canvas.toBlob(function processBlob(blob) {
				if (blob.size > 200 * 1024 && quality > 0.1) {
					quality -= 0.05;
					canvas.toBlob(processBlob, 'image/jpeg', quality);
				} else {
					let compressedSizeInKB = (blob.size / 1024).toFixed(2);
					document.getElementById('file-size').textContent = `Compressed Size: ${compressedSizeInKB} KB`;
				}
			}, 'image/jpeg', quality);
		};
	};
	reader.readAsDataURL(file);
}
$(document).ready(function () {
	load_data_table();
});
function filterbystatus(val)
{
	if(val == 1)
	{
		$(".one_by_one").show();
		$(".folderoption").hide();
	}
	else if(val == 2)
	{
		$(".one_by_one").hide();
		$(".folderoption").show();
	}
}
function change_string()
{
	var string = $("#model_name").val();
	 
	if(string.indexOf(",") != -1)
	{
		$(".design_file_control").hide();
		$(".folderoption").hide();
	}
	else
	{
		$(".design_file_control").show();
		$(".folderoption").show();
		filterbystatus($('input[name="folder_option"]:checked').val())
	}
	
}
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
			"sAjaxSource": root+'Model_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{"name" : "filter_product_id","value" : $("#filter_product_id").val()},{"name" : "finishid","value" : $("#finishid").val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
		$(".gallery").fancybox({
			'hideOnContentClick': true
		});
}

$(".select2").select2({
	width:'100%'
});
function delete_record(deleleid)
{
	main_delete(deleleid,'Model_list/deleterecord','model_list')
}
function delete_image(deleleid)
{
	main_delete(deleleid,'Model_list/delete_image','model_list')
}
$("#model_add").validate({
		rules: {
			model_name: {
				required: true
			}
		},
		messages: {
			model_name: {
				required: "Enter Model Name"
			}
		}
	});
$("#edit_form").validate({
		rules: {
			edit_model_name: {
				required: true
			}
		},
		messages: {
			edit_model_name: {
				required: "Enter Model Name"
			}
		}
	});

$("#model_add").submit(function(event) {
	event.preventDefault();
	if(!$("#model_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	var string = $("#model_name").val();
	if(string.indexOf(",") != -1)
	{
		var url = root+'model_list/multiple_manage';
	}
	else{
		var url = root+'model_list/manage';
	}
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
				     
				     $("#model_name").val('');
				     $("#no_of_randome").val('');
				     $("#design_file").val('');
				     //$("#design_file").val('');
				     $("#field1").val('');
				     $("#field2").val('');
				     $("#design_folder").val('');
				     
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
            url: 	root+'Model_list/edit_record',
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
				   $(".edit_product_id").val('').trigger('change');
				    unblock_page("success","Sucessfully Updated.");
					datatable.DataTable().ajax.reload();
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

function edit_product(packing_model_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"model_list/fetchmodeldata",
              data: {"id": packing_model_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(packing_model_id);
					$("#edit_product_id").val(obj.product_id).trigger('change');
					$("#edit_model_name").val(obj.model_name);
					$("#edit_no_of_randome").val(obj.no_of_randome);
					$("#edit_factory_id").val(obj.factory_id).trigger('change');
					$("#edit_field1").val(obj.field1);
					$("#edit_field2").val(obj.field2);
					$("#edit_field3").val(obj.field3);
					$("#edit_field4").val(obj.field4);
					$("#edit_field5").val(obj.field5);
					
					if(obj.design_file === "")
					{
						$("#design_file_view").hide();
					}
					else
					{
						$("#design_file_view").show();
						$("#design_file_view").attr("src",'<?=DESIGN_PATH?>'+obj.design_file);
						$(".gallery").attr("href","<?=DESIGN_PATH?>"+obj.design_file);
						$(".gallery").attr("data-caption",obj.model_name);
							$(".gallery").fancybox({
								'hideOnContentClick': true
							});
						
					}
					if(obj.finish_id != "" && obj.finish_id != null)
					{
						$("#edit_finish_id").val(obj.finish_id.split(',')).trigger('change');
					}
					 
				 	unblock_page("",""); 
                  }
              
          }); 

}	

 
</script>