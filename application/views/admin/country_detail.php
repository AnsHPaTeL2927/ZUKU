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
									<a href="#"> Master&nbsp;&nbsp; </a>   /  &nbsp;&nbsp;Country 
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Country   
								<a href="<?php echo base_url('country_detail/form'); ?>" style="float:right;" type="button" class="btn btn-info ">
									+ Country 
								</a>
							</h3>
						</div>
					</div>
					</div>
				 	<?php 
				
					if(isset($fd))
					{
						$inc_img_name="";
						if($fd == 'edit')
						{
						 $img_name = $this->encrypt->encode($fdv->id); 
					$inc_img_name=str_replace(array('+', '/', '='), array('-', '_', '~'), $img_name);

						}
					?>
					 
					<div class="row">
						<div class="col-sm-12">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									New Country
								
								</div>
								<div class="panel-body">
								
								
									<form role="form" class="form-horizontal" action="<?php echo base_url('country_detail/'.$fd.'/'.$inc_img_name); ?>" method="post" enctype="multipart/form-data" name="country_add" id="country_add">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Country Name 
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Country Name" id="country_name" class="form-control" name="country_name" value="<?php echo @$fdv->c_name; ?>" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Currency
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Currency" id="form-field-1" class="form-control" name="c_currency" value="<?php echo @$fdv->c_currency; ?>" required title="Enter Currency'" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Country Code
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Country Code" id="form-field-1" class="form-control" name="c_code" value="<?php echo @$fdv->c_code; ?>" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Longitude
											</label>
											<div class="col-sm-9">
											 <input type="text" placeholder="Longitude" id="form-field-1" class="form-control" name="c_longitude" value="<?php echo @$fdv->c_longitude; ?>" >	
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Latitude
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Latitude" id="form-field-1" class="form-control" name="c_latitude" value="<?php echo @$fdv->c_latitude; ?>" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												PO Agreement
											</label>
											<div class="col-sm-9">
												<textarea placeholder="PO Agreement" id="company_rules" class="form-control" name="company_rules"><?=@$fdv->company_rules;?></textarea>
											</div>
										</div>
										 <!--<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												REX No Detail
											</label>
											<div class="col-sm-9">
												<textarea placeholder="REX No Detail" id="rex_no_detail" class="form-control" name="rex_no_detail"><?=@$fdv->rex_no_detail;?></textarea>
											</div>
										</div>-->
	
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-2">
												Flag Upload
											</label>
											<div class="col-sm-9">
												
									
										<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo @base_url('upload/'.$fdv->c_image); ?>" alt=""/>
													</div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
													<div>
												<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
												<input type="file" name="image[]" >
														</span>
														<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
															<i class="fa fa-times"></i> Remove
														</a>
													</div>
												</div>
									
									
									
											</div>
										</div>
										
								<div class="form-group" style="text-align:center;" >
										<button type="submit" class="btn btn-success">
											Save
										</button>
										<a href="<?=base_url().'country_detail/index'?>" class="btn btn-danger">
											Cancel
										</a>
								</div>	
										
										<input type="hidden" name="mode" id="mode" value="0" />
										
									</form>
									
									
								</div>
							</div>
							 
						</div>
					</div>
				
					<?php } else{ ?>
	                <div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Country 
									
									<a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
									<div id="myModal1" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">How To Manage Country</h4>
												</div>
												<div class="modal-body">
													<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/UbZOk-Uqwn8?rel=0&autoplay=0"" frameborder="0" allowfullscreen></iframe>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Country Name</th>
													<th>Currency</th>
													<th>Country Code</th>
													<th>Sign Image</th>
													<th>Action</th>
													
												</tr>
											</thead>
											<tbody>
											
											<?php 
									$no=1;
											for($i=0; $i<count($m);$i++)
											{
												$images = '';
												if(!empty($m[$i]->c_image))
												{
														$images = '<img src="'.base_url('upload/'.$m[$i]->c_image).'" width="100" >';
												}
											?>
												<tr>
												
													<td><?=$no?></td>
													<td><?=$m[$i]->c_name; ?></td>
												 	<td><?=$m[$i]->c_currency; ?></td>
													<td><?=$m[$i]->c_code; ?></td>
													<td>
														<?=$images?>
													 </td>
													<td>
													<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="<?=base_url('country_detail/form_edit/'.$m[$i]->id); ?>" ><i class="fa fa-pencil"></i>Edit</a>
																		</li>
<?php
if($m[$i]->total_cnt==0)
{
 ?>
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$m[$i]->id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
																	 	</li>
<?php }?>
																	   </ul>
																	</div>
													 
													
													</td>
													
												</tr>
										<?php $no++;
										} ?>
											
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- end: RESPONSIVE TABLE PANEL -->
						</div>
					</div>
				
					<?php } ?>
				 
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
 
$("#country_add").validate({
		rules: {
			c_name: {
				required: true
			}
		},
		messages: {
			c_name: {
				required: "Enter Country Name"
			}
		}
	});
	
function delete_record(deleleid)
{
	main_delete(deleleid,'country_detail/del','country_detail/index')
}
</script>