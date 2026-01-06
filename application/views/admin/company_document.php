<?php 
$this->view('lib/header'); 
$form = "Document Of ".$company_detail[0]->s_name;
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
									<a href="<?=base_url().'company_detail'?>">Company Profile</a>
									
								</li>
								 
							</ol>
							<div class="page-header">
								<h3>
									<?=$form?>
										<div class="pull-right">
											<a href="<?php echo base_url('company_detail'); ?>"  type="button" class="btn btn-info">
												Company Profile
											</a>
										</div>
								</h3>
							</div>
							 <div class="panel-body form-body">
								<div class="col-md-8 col-md-offset-1">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="company_doc_form" id="company_doc_form">
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												GST Cerificate
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="gst_certificate" id="gst_certificate" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="gst_certificate_download" class="form-control"  value="<?=$company_doc->gst_certificate?>"> 
												    <input type="hidden" name="gst_certificate_name" id="gst_certificate_name"  value="<?=$company_doc->gst_certificate?>"> 
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->gst_certificate?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												IEC Cerificate
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="iec_certificate" id="iec_certificate" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="iec_certificate_download" class="form-control" value="<?=$company_doc->iec_certificate?>"> 
													<input type="hidden" name="iec_certificate_name" id="iec_certificate_name" class="form-control" value="<?=$company_doc->iec_certificate?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->iec_certificate?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												LUT Cerificate
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="lut_certificate" id="lut_certificate" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="lut_certificate_download" class="form-control" value="<?=$company_doc->lut_certificate?>"> 
													<input type="hidden" name="lut_certificate_name" id="lut_certificate_name"  value="<?=$company_doc->lut_certificate?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->lut_certificate?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Light Bill
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="light_bill" id="light_bill" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="light_bill_download" class="form-control" value="<?=$company_doc->light_bill?>"> 
													<input type="hidden" name="light_bill_name" id="light_bill_name"  value="<?=$company_doc->light_bill?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->light_bill?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Telephone Bill
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="telephone_bill" id="telephone_bill" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="telephone_bill_download" class="form-control" value="<?=$company_doc->telephone_bill?>"> 
													<input type="hidden" name="telephone_bill_name" id="telephone_bill_name"  value="<?=$company_doc->telephone_bill?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->telephone_bill?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Pan Card(Company)
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="pan_card" id="pan_card" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="pan_card_download" class="form-control" value="<?=$company_doc->pan_card?>"> 
													<input type="hidden" name="pan_card_name" id="pan_card_name" value="<?=$company_doc->pan_card?>" >
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->pan_card?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Bank AD Code
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="bank_ad_code" id="bank_ad_code" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="bank_ad_code_download" class="form-control" value="<?=$company_doc->bank_ad_code?>"> 
													<input type="hidden" name="bank_ad_code_name" id="bank_ad_code_name" value="<?=$company_doc->bank_ad_code?>" >
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->bank_ad_code?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												CE Cerificate
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="ce_certificate" id="ce_certificate" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="ce_certificate_download" class="form-control" value="<?=$company_doc->ce_certificate?>"> 
													<input type="hidden" name="ce_certificate_name" id="ce_certificate_name"  value="<?=$company_doc->ce_certificate?>" >
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->ce_certificate?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												ISO Cerificate
											</label>
										 	<div class="col-sm-4">
												    <input type="file" name="iso_certificate" id="iso_certificate" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="iso_certificate_download" class="form-control" value="<?=$company_doc->iso_certificate?>" >
													<input type="hidden" name="iso_certificate_name" id="iso_certificate_name"  value="<?=$company_doc->iso_certificate?>">													
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->iso_certificate?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Stuffing Permission
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="stuffing_permission" id="stuffing_permission" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="stuffing_permission_download" class="form-control" value="<?=$company_doc->stuffing_permission?>" >
													<input type="hidden" name="stuffing_permission_name" id="stuffing_permission_name"  value="<?=$company_doc->stuffing_permission?>" >													
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->stuffing_permission?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Lab report 1
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="lab_report1" id="lab_report1" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="lab_report1_download" class="form-control" value="<?=$company_doc->lab_report1?>"> 
													<input type="hidden" name="lab_report1_name" id="lab_report1_name" value="<?=$company_doc->lab_report1?>" >		
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->lab_report1?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Lab report 2
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="lab_report2" id="lab_report2" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="lab_report2_download" class="form-control" value="<?=$company_doc->lab_report2?>"> 
													<input type="hidden" name="lab_report2_name" id="lab_report2_name" value="<?=$company_doc->lab_report2?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->lab_report2?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Lab report 3
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="lab_report3" id="lab_report3" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="lab_report3_download" class="form-control" value="<?=$company_doc->lab_report3?>"> 
													<input type="hidden" name="lab_report3_name" id="lab_report3_name" value="<?=$company_doc->lab_report3?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->lab_report3?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Director 1 Pan card
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="director1_pancard" id="director1_pancard" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="director1_pancard_download" class="form-control" value="<?=$company_doc->director1_pancard?>"> 
													<input type="hidden" name="director1_pancard_name" id="director1_pancard_name" value="<?=$company_doc->director1_pancard?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->director1_pancard?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Director 1 Aadhar card
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="director1_aadharcard" id="director1_aadharcard" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="director1_aadharcard_download" class="form-control" value="<?=$company_doc->director1_aadharcard?>"> 
												
													<input type="hidden" name="director1_aadharcard_name" id="director1_aadharcard_name" value="<?=$company_doc->director1_aadharcard?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->director1_aadharcard?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Director 2 Pan card
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="director2_pancard" id="director2_pancard" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="director2_pancard_download" class="form-control"  value="<?=$company_doc->director2_pancard?>"> 
													<input type="hidden" name="director2_pancard_name" id="director2_pancard_name" value="<?=$company_doc->director2_pancard?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->director2_pancard?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Director 2 Aadhar card
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="director2_aadharcard" id="director2_aadharcard" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="director2_aadharcard_download" class="form-control"  value="<?=$company_doc->director2_aadharcard?>"> 
													<input type="hidden" name="director2_aadharcard_name" id="director2_aadharcard_name" value="<?=$company_doc->director2_aadharcard?>">
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->director2_aadharcard?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Factory Photos 1
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="factory_photos1" id="factory_photos1" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="factory_photos1_download" class="form-control" value="<?=$company_doc->factory_photos1?>"> 
													<input type="hidden" name="factory_photos1_name" id="factory_photos1_name"  value="<?=$company_doc->factory_photos1?>" >
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->factory_photos1?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Factory Photos 2
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="factory_photos2" id="factory_photos2" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="factory_photos2_download" class="form-control" value="<?=$company_doc->factory_photos2?>"> 
													<input type="hidden" name="factory_photos2_name" id="factory_photos2_name" value="<?=$company_doc->factory_photos2?>" >
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->factory_photos2?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Factory Photos 3
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="file_download[]" id="factory_photos3" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="factory_photos3_download" id="factory_photos3_download" class="form-control" value="<?=$company_doc->factory_photos3?>"> 
													<input type="hidden" name="factory_photos3_name" id="factory_photos3_name" value="<?=$company_doc->factory_photos3?>" >
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->factory_photos3?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Factory Photos 4
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="factory_photos4" id="factory_photos4" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="factory_photos4_download" class="form-control" value="<?=$company_doc->factory_photos4?>"> 
													<input type="hidden" name="factory_photos4_name" id="factory_photos4_name" value="<?=$company_doc->factory_photos4?>" >
											 </div>
											   <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->factory_photos4?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Factory Photos 5
											</label>
											 
											<div class="col-sm-4">
												    <input type="file" name="factory_photos5" id="factory_photos5" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												    <input type="checkbox" name="file_download[]" id="factory_photos5_download" class="form-control" value="<?=$company_doc->factory_photos5?>"> 
													<input type="hidden" name="factory_photos5_name" id="factory_photos5_name" value="<?=$company_doc->factory_photos5?>">
											 </div>
											  <div class="col-sm-2">
												   <a href="<?=base_url().'upload/company_doc/'.$company_doc->factory_photos5?>" class="btn btn-primary" target="_blank">
														<i class="fa fa-eye"></i>
													</a>
										 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												File Name 1
											</label>
											 
											<div class="col-sm-4">
												    <input type="text" name="file_name1" id="file_name1" class="form-control" value="<?=$company_doc->file_name1?>"> 
											 </div>
											 <div class="col-sm-2">
												   <input type="text" name="file_name1" id="file_name1" class="form-control" placeholder="Order"  value="<?=$company_doc->file_name1?>"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												File Name 2
											</label>
											 
											<div class="col-sm-4">
												    <input type="text" name="file_name2" id="file_name2"  value="<?=$company_doc->file_name2?>" class="form-control"> 
											 </div>
											 <div class="col-sm-2">
												   <input type="text" name="file_name2_order" id="file_name2_order" class="form-control" placeholder="Order"  value="<?=$company_doc->file_name2_order?>"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												File Name 3
											</label>
											 
											<div class="col-sm-4">
												    <input type="text" name="file_name3" id="file_name3" class="form-control"  value="<?=$company_doc->file_name3?>"> 
											 </div>
											 <div class="col-sm-2">
												   <input type="text" name="file_name3_order" id="file_name3_order" class="form-control" placeholder="Order"  value="<?=$company_doc->file_name3_order?>"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												File Name 4
											</label>
											 
											<div class="col-sm-4">
												    <input type="text" name="file_name4" id="file_name4" class="form-control"  value="<?=$company_doc->file_name4?>"> 
											 </div>
											 <div class="col-sm-2">
												   <input type="text" name="file_name4_order" id="file_name4_order" class="form-control" placeholder="Order"  value="<?=$company_doc->file_name4_order?>"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												File Name 5
											</label>
											 
											<div class="col-sm-4">
												    <input type="text" name="file_name5" id="file_name5" class="form-control"  value="<?=$company_doc->file_name5?>"> 
											 </div>
											 <div class="col-sm-2">
												   <input type="text" name="file_name5_order" id="file_name5_order" class="form-control" placeholder="Order"  value="<?=$company_doc->file_name5_order?>"> 
											 </div>
										</div>										
									<div class="form-group text-center">
										<div class="col-sm-8">
											<button type="submit" class="btn btn-success">
												Save
											</button>
											<a href="<?=base_url().'customer_detail/index'?>" class="btn btn-danger">
												Cancel
											</a>
										 
										</div>
										<div class="col-sm-2">
												<button type="button" class="btn btn-primary" onclick="download_all()">
													Download All
												</button>
											 </div>
									</div>
								 	</form>
					 	</div>
					</div>
						 
				 </div>
			</div>
		 </div>
	 </div>
 </div>
<?php 
 $this->view('lib/footer');
 $this->view('lib/addseries'); 
?>
<script>
function download_all()
{
	var file_download = [];
	$. each($("input[name='file_download[]']:checked"), function(){
		file_download.push($(this). val());
 	});
	if(file_download.length == 0)
	{
		toastr["error"]("Please select atleast 1 Document.");
		return false;
	}
	else
	{
		block_page();
		$.ajax({ 
			type: "POST", 
			url: root+'company_detail/download_doc',
			data: {
				"file_download"	: file_download
			}, 
			cache: false, 
			success: function (file)
			{ 
				
				window.open(root+'upload/company_doc/'+file,'Download');  
				delete_zip(file);
				
			
					unblock_page('',"")
			}
		});
	}
}
function delete_zip(file)
{
	block_page();
		$.ajax({ 
			type: "POST", 
			url: root+'company_detail/delete_zip',
			data: {
				"filename"	: file
			}, 
			cache: false, 
			success: function (file)
			{ 
				 location.reload();
		 	}
		});
}
$("#company_doc_form").validate({
		rules: {
			pallet_cap: {
				required: true
			}
		},
		messages: {
			pallet_cap: {
				required: "Enter Pallet cap"
			}
		}
	});
$("#company_doc_form").submit(function(event) {
	event.preventDefault();
	if(!$("#company_doc_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'company_detail/doc_manage';
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
				   unblock_page("success","Company Document Sucessfully Updated.");
					setTimeout(function(){ location.reload() },1500);	 
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

  