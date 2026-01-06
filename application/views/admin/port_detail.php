<?php 
$this->view('lib/header'); 
//print_r($m);
//exit;
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
									Port Details
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Port Details  
								<a href="<?php echo base_url('port_detail/form'); ?>" style="float:right;" type="button" class="btn btn-info">
								+ New Port
								</a>
							</h3>
							 </div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
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
					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-sm-12">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									insert form
								 </div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="<?php echo base_url('port_detail/'.$fd.'/'.$inc_img_name); ?>" method="post" enctype="multipart/form-data" name="add_port_form" id="add_port_form">
									 	<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Port Name 
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Port Name" id="p_name" required="" class="form-control" name="p_name" value="<?php echo @$fdv->p_name; ?>" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												City
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="City" id="p_city" required="" class="form-control" name="p_city" value="<?php echo @$fdv->p_city; ?>" title="Enter City">
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Country
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Country" id="p_country" required="" class="form-control" name="p_country" value="<?php echo @$fdv->p_country; ?>" title="Enter Country" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												longitude

											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Longitude" required="" id="p_longitude" class="form-control" name="p_longitude" value="<?php echo @$fdv->p_longitude; ?>" title="Enter Logitude">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												latitude 
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Latitude" required="" id="p_latitude" class="form-control" name="p_latitude" value="<?php echo @$fdv->p_latitude; ?>" title="Enter Latitude">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Remark
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Remark" required="" id="p_remark" class="form-control" name="p_remark" value="<?php echo @$fdv->p_remark; ?>" title="Enter Remark">
											</div>
										</div>
							 <div class="form-group" style="text-align:center;" >
										<button type="submit" class="btn btn-default">
											Save
										</button>
									</div>	
								 </form>
								</div>
							</div>
						 
						</div>
					</div>
				
					<?php } else{ ?>
	 				
					
	                 <div class="row">
						<div class="col-md-12">
							
							<!-- start: RESPONSIVE TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Port Detail Table
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
												
													<th>Port Name</th>
													<th>City</th>
													<th>Country</th>
													<th>Longitude</th>
													<th>Latitude</th>
													<th>Remark</th>
													<th>Action</th>
													
												</tr>
											</thead>
											<tbody>
											
											<?php 
									
											for($i=0; $i<count($m);$i++)
											{
											?>
												<tr>
												
													<td><?php echo $m[$i]->p_name; ?></td>
													<td><?php echo $m[$i]->p_city; ?></td>
													<td><?php echo $m[$i]->p_country; ?></td>
													<td><?php echo $m[$i]->p_longitude; ?></td>
													<td><?php echo $m[$i]->p_latitude; ?></td>
													<td><?php echo $m[$i]->p_remark; ?></td>
											
													<td>
													<p>
							<a class="btn btn-primary" href="<?php echo base_url('port_detail/form_edit/'.$m[$i]->id); ?>"><i class="glyphicon glyphicon-log-in"></i></a>
										
							<a class="btn btn-bricky" onclick="return cnf()" href="<?php echo base_url('port_detail/del/'.$m[$i]->id); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
							
									       </p>
													
													</td>
													
												</tr>
										<?php } ?>
											
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- end: RESPONSIVE TABLE PANEL -->
						</div>
					</div>
				
					<?php } ?>
				
				
					
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal askform" action="<?php echo base_url('bank_detail/manage'); ?>"  method="post" name="form" id="form">
               
				    <div class="field-group">
				        <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" required="" class="form-control" />
				    </div>                
				    
				    <div class="field-group">
				        <textarea id="bank_address" name="bank_address" placeholder="Bank Address" class="form-control"></textarea>
				    </div>                     
				    
				    <div class="field-group">
				        <input id="Email_ask" type="text" name="account_no" placeholder="Account No" required="" class="form-control"/>
				    </div>                
				    <div class="field-group">
				        <input type="text" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" class="form-control" />    
				    </div> 

				    <div class="field-group">
				        <input type="text" id="swift_code" name="swift_code" placeholder="Swift Code" class="form-control" />    
				    </div> 
				   
				    <input name="Submit" type="submit" value="Add" class="btn btn-info" onClick="return checkFields()" />                    
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

		<script>
		function cnf()
		{
			
			return confirm('Are you sure you want to delete this item?');
		}
		
		</script>
		
		
		<!-- start: FOOTER -->
<?php $this->view('lib/footer'); ?>
<script>
$("#add_port_form").validate({
		rules: {
			p_name: {
				required: true
			}
		},
		messages: {
			p_name: {
				required: "Enter Port Name"
			}
		}
	});
</script>