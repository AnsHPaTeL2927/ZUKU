<?php $this->view('lib/header');  ?>
 <link href="<?=base_url().'adminast/assets/css/fileuploaddragdrop.css'?> " rel="stylesheet" type="text/css">
       	
	 <div class="main-container">
			<?php $this->view('lib/sidebar'); ?>
			<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
								 Show Excel File error
								</li>
								 <li>
									<i class="fa fa-external-link-square"></i>
										<a href="<?=base_url()?>product/index/<?=$performa_invoice_id?>">Proforma Product</a>
								</li>
								 
							</ol>
							<div class="page-header">
								<h3> Excel File error
									<a href="<?php echo base_url('product/index/'.$performa_invoice_id); ?>"   type="button" class="btn btn-danger pull-right">
									Back
								</a>
								</h3>
							</div>
						</div>
					 <div class="col-md-12" style="height:10px"></div>
						<div class="col-sm-12">
							 <table class="table table-bordered">
								<tr>
									<th>Excel Line No</th>
									<th>Error</th>
								</tr>
								<?php 
								 
								foreach($tempdata as $row)
								{
									?>
									<tr>
										<td><?=$row->line_no?></td>
										<td><?=$row->remarks?></td>
								 	</tr>
									<?php
								}
								?>
							 </table>
						</div>
					</div>
				</div>
			</div>
			 
		</div>
		 
<?php $this->view('lib/footer'); ?>
<script src="<?=base_url().'adminast/assets/js/filedragdrop.js'?>" type="text/javascript"></script>
<script>
$(".select2").select2({
		width:'100%'
	})
</script>