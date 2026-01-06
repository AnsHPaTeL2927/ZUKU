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
									HSNC Code  
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>HSNC Code  
								<a href="<?php echo base_url('add_hsnc'); ?>"   type="button" class="btn btn-info pull-right">
									Add HSNC  
								</a>
							</h3>
								
							 </div>
							 
						</div>
					</div>
					 
	                <div class="row">
						<div class="col-md-12">
						 	<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									HSNC Code
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
												
													<th>Sr No</th>
													<th>HSNC Code</th>
													<th>Product Name</th>
													<th>Size Type</th>
													<th>Order By</th>
													<th>Status</th>
											 		<th>Action</th>
													
												</tr>
											</thead>
											<tbody>
											
											<?php 
									$no=1;
											for($i=0; $i<count($result);$i++)
											{
											?>
												<tr>
												
													<td><?=$no?></td>
													<td><?=$result[$i]->hsnc_code; ?></td>
													<td><?=$result[$i]->p_name; ?></td>
													<td><?=$result[$i]->size_type; ?></td>
													<td><?=$result[$i]->orderby; ?></td>
													<td><?=$result[$i]->status; ?></td>
													
											
													<td>
													<p>
														<a class="btn btn-warning tooltips"  data-title="Edit"  href="<?php echo base_url('product_code/form_edit/'.$result[$i]->id); ?>"><i class="fa fa-pencil"></i></a>
										
							 
									       </p>
													
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
</script>