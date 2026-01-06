<?php 
$this->view('lib/header'); 
$form_name = 'Edit QC Doc. Of '.$invoicedata->export_invoice_no
 
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
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$form_name?></h3>
							<div class="pull-right">
								<a class="btn btn-info" href="<?=base_url().'upload_qc_doc/view/'.$qcdata->export_invoice_id?>">View QC Content</a></div>
							</div>
							 
						</div>
					</div>
								<form action="javascript:;" method="POST"  class="form-horizontal" name="qc_doc_form" id="qc_doc_form">
									<div class="form-group">
										<label class="col-md-2 control-label">QC Content </label>
											<div class="col-md-6">
												 <textarea name="qc_content" id="qc_content" placeholder="QC Content" class="form-control" style="height:500px"><?=strip_tags($qcdata->qc_text)?></textarea>
											</div>
									</div>
									 
									<div class="col-md-12">	 
										<div class="col-md-offset-2">
										<button type="submit" id="submit_btn" class="btn btn-success">Save</button>
										</div> 
									</div>  
									 
								 	 <input type="hidden" id="performa_invoice_id"   class="form-control" name="performa_invoice_id"  value="<?=$qcdata->performa_invoice_id?>"  >		
								 	 <input value="<?=$qcdata->export_invoice_id?>"  type="hidden" id="export_invoice_id"   class="form-control" name="export_invoice_id"  >		
								 	 <input value="<?=$qcdata->qc_table_id?>"  type="hidden" id="qc_table_id"   class="form-control" name="qc_table_id"  >		
							</form>
	 
			</div>
	 		</div>
		 </div>
	 </div>
 </div>
 <?php $this->view('lib/footer'); ?>
 <script>
 $('.fancybox').fancybox({
	 'showNavArrows': true,
	 
 });
 $(".select2").select2({
	 width : "100%"
 });
 $(document).ready(function() {
	
$("#qc_doc_form").validate({
		rules: {
			qc_content: {
				required: true
			} 
		},
		messages: {
			qc_content: {
				required: "Enter QC Content"
			} 
		}
});

});

 $("#qc_doc_form").submit(function(event) {
	event.preventDefault();
	 if(!$("#qc_doc_form").valid())
	{
		return false;
	} 
	 block_page()
	var postData= new FormData(this);
 	$.ajax({
            type: "post",
            url: 	root+'upload_qc_doc/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==2)
			   {
				   $("#qc_doc_form").trigger('reset');
				 	toastr["success"]("Successfully Updated");
					setTimeout(function(){ window.location=root+'upload_qc_doc/view/'+<?=$invoicedata->export_invoice_id?>; },1500);
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
 
 </script>
</body>
</html>
