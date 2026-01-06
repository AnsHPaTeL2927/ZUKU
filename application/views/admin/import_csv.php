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
								 Data Import
								</li>
								 
							</ol>
							<div class="page-header">
								<h3> Data Import</h3>
							</div>
						</div>
					 <div class="col-md-12" style="height:10px"></div>
						<div class="col-sm-12">
							 <input type="file" name="file" id="file" accept=".csv">

								<!-- Drag and Drop container-->
								<div class="upload-area"  id="uploadfile">
									<img src="<?=base_url().'adminast/assets/images/dragdrop.jpg'?>" />
								</div>
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