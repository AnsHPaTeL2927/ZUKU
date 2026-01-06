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
									Company Details
								</li>
							 
							</ol>
							<div class="page-header">
								<h3>Company Profile  
									<div class="pull-right">
											<a href="<?php echo base_url('company_detail/document'); ?>"  type="button" class="btn btn-info">
												Company Document
											</a>
										</div>
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
							$this->load->library('encrypt');
							$img_name = $this->encrypt->encode($fdv->s_id); 
							$inc_img_name=str_replace(array('+', '/', '='), array('-', '_', '~'), $img_name);
						}
						 
					?>
					 
					<div class="row">
						<div class="col-sm-12">
							 
							<div class="panel panel-default">
								<form role="form" class="form-horizontal" action="<?php echo base_url('company_detail/'.$fd.'/'.$fdv->s_id); ?>" method="post" enctype="multipart/form-data" name="company_detail_form" id="company_detail_form" >
									<div class="panel-heading">
										<i class="fa fa-pencil"></i> Company Profile
										
									</div>
								<div class="panel-body">
										
									 	<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Company Name 
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="Name" id="name" class="form-control" name="name" value="<?php echo @$fdv->s_name; ?>" />
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Contact Person Name
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="Contact Person Name" id="contact_person_name" class="form-control" name="contact_person_name" value="<?php echo @$fdv->contact_person_name; ?>" required title="Enter Contact Person Name">
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												OTP Mobile No
											</label>
											<div class="col-md-5">
												<input type="text" placeholder="OTP Mobile No" id="otp_mobile_no" class="form-control" name="otp_mobile_no" value="<?=$fdv->otp_mobile_no; ?>"  readonly>
											</div>
											<a href="javascript:;" class="btn btn-primary tooltips" onclick="update_mobile_no();" data-title="Update OTP Mobile No" data-original-title="" title="">
												<i class="fa fa-pencil fa-lg"></i>
											</a>
										</div>
										 <div class="col-md-12"></div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Mobile
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="Mobile" id="Mobile" class="form-control" name="Mobile" value="<?php echo @$fdv->s_mobile; ?>" >
											</div>
										</div>
											 
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Email
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="Email" id="Email" class="form-control" name="Email" value="<?php echo @$fdv->s_email; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Phone No
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="Phone No" id="phone" class="form-control" name="phone" value="<?php echo @$fdv->phone; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Fax No
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="Fax No" id="fax_no" class="form-control" name="fax_no" value="<?php echo @$fdv->fax_no; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Website
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="Website" id="website" class="form-control" name="website" value="<?php echo @$fdv->website; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-sm-5 control-label" for="form-field-1">
												Company Register
											</label>
											<div class="col-sm-7">
												<Select name="c_register" class="form-control">
													<option>Company Register</option>
													<option value="Partnership" <?php if(@$fdv->s_c_register == 'Partnership'){ echo "selected"; } ?>>Partnership</option>
													<option value="Pvt Ltd" <?php if(@$fdv->s_c_register == 'Pvt Ltd'){ echo "selected"; } ?>>Pvt Ltd</option>
													<option value="LLP" <?php if(@$fdv->s_c_register == 'LLP'){ echo "selected"; } ?>>LLP</option>
												</Select>
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Company Type
											</label>
											<div class="col-md-7">
												<Select name="c_type" class="form-control">
													<option>Company Type</option>
													<option value="Merchant" <?php if(@$fdv->s_c_type == 'Merchant'){ echo "selected"; } ?>>Merchant/Manufacturer</option>
													 
												</Select>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="col-md-3 control-label" for="form-field-1" >
												Address
											</label>
											<div class="col-md-8">
												<textarea id="s_address1" name="s_address1" placeholder="Address" class="form-control" style="height:75px" ><?=strip_tags(@$fdv->s_address); ?></textarea>
										 	</div>
										</div>
										<div class="form-group col-md-6">
											<label class="col-md-3 control-label" for="form-field-1" >
												Postal Address
											</label>
											<div class="col-md-8">
												<textarea id="postal_address" name="postal_address" placeholder="Postal Address" class="form-control" style="height:75px" ><?=strip_tags(@$fdv->postal_address); ?></textarea>
										 	</div>
										</div>
								</div>
									
									<div class="panel-heading">
										<i class="fa fa-pencil"></i> Company Registration details
									</div>								
									<div class="panel-body">	
									 
										<div class="form-group col-md-4">
											<label class="col-sm-5 control-label" for="form-field-1">
												GST NO
											</label>
											<div class="col-sm-7">
												<input type="text" placeholder="GST NO" id="GST" class="form-control" name="GST" value="<?php echo @$fdv->s_gst; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4"  >
											<label class="col-md-5 control-label" for="form-field-1">
												PAN NO  
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="PAN NO" id="PAN" class="form-control" name="PAN" value="<?php echo @$fdv->s_pan; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												IEC NO
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="IEC NO" id="IEC" class="form-control" name="IEC" value="<?php echo @$fdv->s_iec; ?>">
											</div>
										</div>
										<div class="form-group  col-md-4">
											<label class="col-sm-5 control-label" for="form-field-1">
												LUT NO
											</label>
											<div class="col-sm-7">
												<input type="text" placeholder="LUT NO" id="LUT_NO" class="form-control" name="LUT_NO" value="<?php echo @$fdv->s_lutno; ?>" >
											</div>
										</div>
										<div class="form-group  col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												LUT EXPIRY
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="LUT EXPIRY" id="LUT_EXPIRY" class="form-control" name="LUT_EXPIRY" value="<?php echo @$fdv->s_lut_expiry; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												BIN NO
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="BIN NO" id="BIN" class="form-control" name="BIN" value="<?php echo @$fdv->s_bin; ?>" >
											</div>
										</div>
										<div class="form-group  col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												CIN NO
											</label>
											<div class="col-md-7">
												<input type="text" placeholder="CIN NO" id="CIN" class="form-control" name="CIN" value="<?php echo @$fdv->s_cin; ?>" >
											</div>
										</div>
										
										 <div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												RCMC NO
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="rcmc_no" id="rcmc_no" placeholder="RCMC NO" value="<?php echo @$fdv->rcmc_no; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												RCMC EXPIRY
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="rcmc_expiery" id="rcmc_expiery" placeholder="RCMC EXPIRY" value="<?php echo @$fdv->rcmc_expiery; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												GST CIRCULAR NO
											</label>
											<div class="col-md-7">
												 <input type="text" name="gst_circular_no" id="gst_circular_no" class="form-control"  placeholder="GST Circular No" value="<?=@$fdv->gst_circular_no?>">
											</div>
									 	</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												DATE OF FILING
											</label>
											<div class="col-md-7">
												 <input type="text" name="date_of_filing" id="date_of_filing" class="form-control"  placeholder="Date Of Filing" value="<?=@$fdv->date_of_filing?>">
											</div>
									 	</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												CIRCULAR NO
											</label>
											<div class="col-md-7">
												 <input type="text" name="circular_no" id="circular_no" class="form-control"  placeholder="Circular No"  value="<?=@$fdv->circular_no?>">
											</div>
									 	</div>
										 <div class="col-md-12"></div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												STATE CODE
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="state_code" id="state_code" placeholder="State Code" value="<?php echo @$fdv->state_code; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												REX NUMBER
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="rex_no" id="rex_no" placeholder="REX NUMBER" value="<?php echo @$fdv->rex_no; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												AEO NO
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="aeo_no" id="aeo_no" placeholder="AEO No" value="<?php echo @$fdv->aeo_no; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												LEI NO
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="lei_no" id="lei_no" placeholder="LEI NO" value="<?php echo @$fdv->lei_no; ?>"/> 
											</div>
										</div>
										 <div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Field 1
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="field1" id="field1" placeholder="Field 1" value="<?=$fdv->field1; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Field 2
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="field2" id="field2" placeholder="Field 2" value="<?=$fdv->field2; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Field 3
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="field3" id="field3" placeholder="Field 3" value="<?=$fdv->field3; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Field 4
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="field4" id="field4" placeholder="Field 4" value="<?=$fdv->field4; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Field 5
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="field5" id="field5" placeholder="Field 5" value="<?=$fdv->field5; ?>"/> 
											</div>
										</div>
										<!--
										<div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												Upload Permission Doc
											</label>
											<div class="col-md-6">
												 <input type="file" name="permission_doc" id="permission_doc" class="form-control" accept="application/msword,application/pdf">
											</div>
											<div class="col-md-2">
											<?php 
											if(!empty($fdv->permission_doc))
											{
												echo '<a class="btn btn-primary" href="'.base_url().'upload/'.$fdv->permission_doc.'" target="_blank">Download</a>';
											}	
											?>
											
											</div>
										</div>
										<div class="form-group col-md-2">
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Permission No 
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control" rows="2" name="permission_no" id="permission_no" placeholder="Permission No" value="<?php echo @$fdv->permission_no; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-12">
										</div>
										<div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												Permission Expiry Date
											</label>
											<div class="col-md-6">
												 <input type="text" class="form-control" rows="2" name="permission_expirydate" id="permission_expirydate" placeholder="Permission Expiry Date" value="<?php echo @$fdv->permission_expirydate; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-2">
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">
												Permission Date 
											</label>
											<div class="col-md-7">
												 <input type="text" class="form-control defualt-date-picker" rows="2" name="permission_date" id="permission_date" placeholder="Permission Date" value="<?=date('d-m-Y',strtotime($fdv->permission_date))?>"/> 
											</div>
										</div>
										<div class="form-group col-md-8">
											<label class="col-md-3 control-label" for="form-field-1" >
												Issue Authority Address
											</label>
											<div class="col-md-8">
												<textarea id="issue_authority_address" name="issue_authority_address"   class="form-control" placeholder="Issue Authority Address"><?=strip_tags(@$fdv->issue_authority_address)?></textarea>
												
											</div>
										</div>
										<div class="form-group col-md-12">
										</div>
										<div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												EPCG Detail
											</label>
											<div class="col-md-8">
												 <input type="text" class="form-control"   name="epcg_detail" id="epcg_detail" placeholder="EPCG Detail" value="<?=$fdv->epcg_detail?>"/> 
											</div>
										</div>-->
									</div>
									
									<div class="panel-heading">
										<i class="fa fa-pencil"></i>Company setting
									</div>								
									<div class="panel-body">	
										
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Pre Carriage By
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Pre Carriage By" id="pre_carriage_by" class="form-control" name="pre_carriage_by" value="<?php echo @$fdv->pre_carriage_by; ?>" >
											</div>
										</div>
										
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Place Of Receipt
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Place of Receipt by Pre-Carrier" id="receipt_by_precarrier" class="form-control" name="receipt_by_precarrier" value="<?php echo @$fdv->receipt_by_precarrier; ?>" >
											</div>
										</div>
										
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												District of Origin
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="District of Origin" id="district_of_origin" class="form-control" name="district_of_origin" value="<?php echo @$fdv->district_of_origin; ?>" >
											</div>
										</div>
										
										<div class="col-md-12"></div>
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												State of Origin 
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="State of Origin " id="state_of_origin" class="form-control" name="state_of_origin" value="<?php echo @$fdv->state_of_origin; ?>" >
											</div>
										</div>
										
										
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Port Of Loading 
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Port Of Loading" id="port_of_loading" class="form-control" name="port_of_loading" value="<?php echo @$fdv->port_of_loading; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Transshipment
											</label>
											<div class="col-sm-6">
												<input type="text" placeholder="Transshipment" id="transhipment" class="form-control" name="transhipment" value="<?php echo @$fdv->transhipment; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Delivery Period
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Delivery Period" id="delivery_period" class="form-control" name="delivery_period" value="<?php echo @$fdv->delivery_period; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Partial Shipment
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Partial Shipment" id="partial_shipment" class="form-control" name="partial_shipment" value="<?php echo @$fdv->partial_shipment; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Variation in Quantity  
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Variation in Quantity " id="variation_in_quantity" class="form-control" name="variation_in_quantity" value="<?php echo @$fdv->variation_in_quantity; ?>" >
											</div>
										</div>
										
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Terms of Delivery 
											</label>
											<div class="col-md-6">
												
											<input type="text" class="form-control" rows="2" name="terms_of_delivery" id="terms_of_delivery" value="<?php echo @$fdv->terms_of_delivery; ?>"/> 
											</div>
										</div>
										<div class="col-md-12"></div>
										<div class="form-group col-md-6">
											<label class="col-sm-4 control-label" for="form-field-2">
												Company Logo upload<br>
												Width:<input type="text" id="company_logo_width" name="company_logo_width" placeholder="Company Logo Width" required="" title="Enter Width" class="form-control"  value="<?php echo @$fdv->s_image_width; ?>" /><br>
												Height:<input type="text" id="company_logo_height" name="company_logo_height" placeholder="Company logo Height" required="" title="Enter Height" class="form-control"  value="<?php echo @$fdv->s_image_height; ?>" />
												<!--<small>Size :170px width <br> 130px height</small>-->
											</label>
											<div class="col-sm-8">
												
									
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">	
												<img src="<?php echo @base_url('upload/'.$fdv->s_image); ?>" alt=""/>
											</div>
											
											<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
													<div>
												<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span>
												<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
												<input type="file" name="image" id="image">
														</span>
														<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
															<i class="fa fa-times"></i> Remove
														</a>
													</div>
													
												</div>
									
									
									
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="col-sm-4 control-label" for="form-field-2">
												Sign upload<br>
												Width:<input type="text" id="s_c_sign_width" name="s_c_sign_width" placeholder="Sign Width" required="" title="Enter Width" class="form-control"  value="<?php echo @$fdv->s_c_sign_width; ?>" /><br>
												Height:<input type="text" id="s_c_sign_height" name="s_c_sign_height" placeholder="Sign Height" required="" title="Enter Height" class="form-control"  value="<?php echo @$fdv->s_c_sign_height; ?>" />
												<!--<small>Size :170px width <br> 130px height</small>-->
											</label>
											
											<div class="col-sm-8">
											
										<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo @base_url('upload/'.$fdv->s_c_sign); ?>" alt=""/>
													</div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
													
													<div>
													<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
												<input type="file" name="sign_image" id="sign_image" >
														</span>
														<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
															<i class="fa fa-times"></i> Remove
														</a>
													</div>
												</div>
									
									
									
											</div>
										</div>
										
										<div class="form-group col-md-6">
											<label class="col-sm-4 control-label" for="form-field-2">
												Header Upload
												<br>
												Width:<input type="text" id="header_width" name="header_width" placeholder="Header Width" required="" title="Enter Width" class="form-control"  value="<?php echo @$fdv->head_logo_width; ?>" /><br>
												Height:<input type="text" id="header_height" name="header_height" placeholder="Header Height" required="" title="Enter Height" class="form-control"  value="<?php echo @$fdv->head_logo_height; ?>" />
												<!--<small>Size :170px width <br> 130px height</small>-->
											</label>
											<div class="col-sm-8">
										<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
														<img src="<?php echo @base_url('upload/'.$fdv->head_logo); ?>" alt=""/>
													</div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
													<div>
												<span class="btn btn-light-grey btn-file">
												<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
													<input type="file" name="head_logo" id="head_logo" >
														</span>
														<a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
															<i class="fa fa-times"></i> Remove
														</a>
													</div>
												</div>
									
									
									
											</div>
										</div>
										<div class="form-group col-md-12"></div>
										<div class="form-group col-md-6">
											<label class="col-md-3 control-label" for="form-field-1">
												Payment Terms
											</label>
											<div class="col-md-9">
												 <textarea class="form-control" style="height:55px;" name="payment_terms" id="payment_terms"><?php echo @$fdv->payment_terms; ?></textarea>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												Authorised Signatory
											</label>
											<div class="col-md-8">
												 <textarea class="form-control" style="height:55px;" name="authorised_signatury" id="authorised_signatury"><?php echo @$fdv->authorised_signatury; ?></textarea>
											</div>
										</div>
									</div>
									<div class="panel-heading">
										<i class="fa fa-pencil"></i>Bank
									</div>								
									<div class="panel-body">	
										
										<div class="col-md-12">
											<label class="col-sm-2 control-label" for="form-field-1">
												Set Default Bank  
											</label>
											<div class="col-sm-3">
												<select name="bank_id" id="bank_id" class="form-control">
													<option>Select Bank</option>
													<?php 
													 for($i=0; $i<count($result);$i++)
													{
													?>
														<option value="<?php echo $result[$i]->id; ?>" <?php if($result[$i]->id==@$fdv->bank_name) echo 'selected="selected"'; ?>>
															<?php echo $result[$i]->bank_name; ?>
														</option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-sm-1 padding-0">
												<button type="button" class="btn btn-info tooltips"  data-title="Add Bank" data-toggle="modal" data-target="#myModal">+</button>
												
											</div>
											<div class="col-md-5">
												<a href="javascript:;" class="invoice_edit_btn btn btn-primary tooltips" onclick="update_bank(<?=$bank_detail->id?>);" data-title="Update Bank"><i class="fa fa-pencil fa-lg"></i></a>
												<br>
													Bank Name : <?=$bank_detail->bank_name?><br>
													Bank Address : <?=$bank_detail->bank_address?><br>
													Account Name: <?=$bank_detail->account_name?><br>
													Account No: <?=$bank_detail->account_no?><br>
													Ifcs Code : <?=$bank_detail->ifsc_code?><br>
													Swift Code : <?=$bank_detail->swift_code?><br>
													Bank Ad Code No   : <?=$bank_detail->bank_ad_code?><br>
													IBAN No   : <?=$bank_detail->iban_number?><br>
													<input type="hidden" id="old_bank_id" name="old_bank_id" value="<?=$bank_detail->id?>"/>
												</div>
										</div>										
										
									</div>
									<div class="panel-heading">
										<i class="fa fa-pencil"></i>Performa details
									</div>
									<div class="panel-body">	
									    <div class="form-group col-md-8">
											<label class="col-md-3 control-label" for="form-field-1" >
												Performa Invoice remark
											</label>
											<div class="col-md-8">
												<textarea id="performa_detail" name="performa_detail"   class="form-control" placeholder="Performa Last Detail"><?=strip_tags(@$fdv->performa_detail)?></textarea>
												
											</div>
										</div>
										 
										
									</div>
									<div class="panel-heading">
										<i class="fa fa-pencil"></i>Exporter Detail
									</div>								
									<div class="panel-body">
										<div class="form-group col-md-6">
											<label class="col-sm-5 control-label" for="form-field-1">
												Export Under Detail 1 
											</label>
											<div class="col-sm-7">
												<textarea placeholder="Export Under Detail 1" id="export_under_detail1" class="form-control" name="export_under_detail1"><?=strip_tags($fdv->export_under_detail1)?></textarea>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="col-sm-5 control-label" for="form-field-1">
												Export Under Detail 2
											</label>
											<div class="col-sm-7">
												<textarea placeholder="Export Under Detail 2" id="export_under_detail2" class="form-control" name="export_under_detail2"><?=strip_tags($fdv->export_under_detail2)?></textarea>
												 
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="col-sm-5 control-label" for="form-field-1">
												Export Remarks
											</label>
											<div class="col-sm-7">
													<textarea placeholder="Export Remarks" id="export_remarks" class="form-control" name="export_remarks"><?=strip_tags($fdv->export_remarks)?></textarea>
													 
											</div>
										</div>
									</div>
									
									<div class="panel-heading">
										<i class="fa fa-pencil"></i>ANNEXURE Detail
									</div>								
									<div class="panel-body">	
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Range
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Range" id="range" class="form-control" name="range" value="<?php echo @$fdv->com_range; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Division
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Division" id="division" class="form-control" name="division" value="<?php echo @$fdv->com_division; ?>" >
											</div>
										</div>
										 
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Commissionerate
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Commissionerate" id="commissionerate" class="form-control" name="commissionerate" value="<?php echo @$fdv->commissionerate; ?>" >
											</div>
										</div>
										<div class="form-group col-md-4">
											<label class="col-md-6 control-label" for="form-field-1">
												Location code
											</label>
											<div class="col-md-6">
												<input type="text" placeholder="Location code" id="location_code" class="form-control" name="location_code" value="<?php echo @$fdv->location_code; ?>" >
											</div>
										</div>
										<div class="form-group col-md-8">
											<label class="col-md-3 control-label" for="form-field-1">
												Annexure Remarks
											</label>
											<div class="col-md-9">
												<textarea placeholder="Annexure Remarks" id="annexure_remarks" class="form-control" name="annexure_remarks"><?=strip_tags($fdv->annexure_remarks)?></textarea>
											</div>
										</div>
									</div>
									
									<div class="panel-heading">
										<i class="fa fa-pencil"></i> VGM Detail
									</div>								
									<div class="panel-body">	
									 
										<div class="form-group col-md-6">
											<label class="col-sm-4 control-label" for="form-field-1">
												Shipper Name
											</label>
											<div class="col-sm-8">
												<input type="text" placeholder="Shipper Name" id="shipper_name" class="form-control" name="shipper_name" value="<?php echo @$fdv->shipper_name; ?>" >
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												Method used for VGM
											</label>
											<div class="col-md-8">
												 <input type="text" class="form-control" rows="2" name="method_vgm" id="method_vgm" placeholder="Method used for VGM" value="<?php echo @$fdv->method_vgm; ?>"/> 
											</div>
										</div>
										 <div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												Weighment Slip no.
											</label>
											<div class="col-md-8">
												 <input type="text" class="form-control" rows="2" name="weighbridge_slip_no" id="weighbridge_slip_no" placeholder="Method used for VGM" value="<?php echo @$fdv->weighbridge_slip_no; ?>"/> 
											</div>
										</div>
										<div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												Name & Designation of Officer
											</label>
											<div class="col-md-8">
												 <input type="text" class="form-control" rows="2" name="name_officer" id="name_officer" placeholder="Name Of Officer" value="<?php echo @$fdv->name_officer; ?>"/> 
											</div>
										</div>
										 
										 <div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1">
												Weighbridge Registration no
											</label>
											<div class="col-md-6">
												 <input type="text" class="form-control" rows="2" name="weighbridge_reg_no" id="weighbridge_reg_no" placeholder="Weighbridge Registration no" value="<?php echo @$fdv->weighbridge_reg_no; ?>"/> 
											</div>
										</div>
										  <div class="form-group col-md-12"></div>
									    <div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1" >
												Shipper Address
												<br>
												
											</label>
											<div class="col-md-8">
												<button type="button" class="btn btn-info" onclick="same_as_address()">Same As Company Address</button>
												<br>
												<br>
												 
												<textarea id="shipper_address" name="shipper_address"   class="form-control" placeholder="Shipper Address"><?=strip_tags(@$fdv->shipper_address)?></textarea>
												
											</div>
										</div>
										 <div class="form-group col-md-6">
											<label class="col-md-4 control-label" for="form-field-1" >
												 VGM Remarks
											</label>
											<div class="col-md-8">
												 
												<textarea id="vgm_remakrs" name="vgm_remakrs"   class="form-control" placeholder="VGM Remarks"><?=strip_tags(@$fdv->vgm_remakrs)?></textarea>
												
											</div>
										</div>
										
									</div>
									
									<div class="panel-heading">
										<i class="fa fa-pencil"></i>Quotation details
									</div>
									<div class="panel-body">	
									    <div class="form-group col-md-8">
											<label class="col-md-3 control-label" for="form-field-1" >
												Quotation Terms & Condition:-
											</label>
											<div class="col-md-8">
												<textarea id="quotation_terms" name="quotation_terms"   class="form-control" placeholder="Quotation Terms & Condition:-"><?=strip_tags(@$fdv->quotation_terms)?></textarea>
												
											</div>
										</div>
										 
										
									</div>
									 <div class="col-md-offset-2" >
										<button type="submit" class="btn btn-success">
											Save
										</button>
									</div>	
								 </div>
								 	<input type="hidden" name="bank_status" id="bank_status" value=""/>
			
								 </form>
							</div>
						 </div>
					</div>
				
					<?php }  ?>
				</div>
			</div>
			
		</div>
		
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Bank Detail</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="add_bank_detail" id="add_bank_detail">
               
            <div class="modal-body">
                
				    <div class="field-group">
				        <strong>Bank Name  </strong>
						<input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" required="" class="form-control" />
				    </div>                
				    
				    <div class="field-group">
				       <strong>  Bank Address  </strong>
					   <textarea id="bank_address" name="bank_address" placeholder="Bank Address" class="form-control"></textarea>
				    </div>                     
				    <div class="field-group">
						 <strong>Account Name </strong>
				        <input id="account_name" type="text" name="account_name" placeholder="Account Name" required="" class="form-control" required title="Enter Account Name"/>
				    </div>  
				    <div class="field-group">
						 <strong>Account No </strong>
				        <input id="account_no" type="text" name="account_no" placeholder="Account No" required="" class="form-control"/>
				    </div>                
				    <div class="field-group">
						 <strong>IFSC Code </strong>
				        <input type="text" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" class="form-control" />    
				    </div> 

				    <div class="field-group">
						 <strong>Swift Code </strong>
				        <input type="text" id="swift_code" name="swift_code" placeholder="Swift Code" class="form-control" />    
				    </div> 
				   
				     <div class="field-group">
						 <strong>Bank Ad Code No </strong>
				        <input type="text" id="bank_ad_code" name="bank_ad_code" placeholder="Bank Ad Code No" class="form-control" />    
				    </div>                   
					<div class="field-group">
						 <strong>IBAN NO. </strong>
				        <input type="text" id="iban_number" name="iban_number" placeholder="IBAN NO." class="form-control" />    
				    </div>                   
				
            </div>
            <div class="modal-footer">
				<input id="submit_btn" type="submit" value="Add" class="btn btn-info"   />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="eid" id="eid" />
			<input type="hidden" name="sent_msg" id="sent_msg" value="1"/>        
			</form>
        </div>
    </div>
</div>
<div id="myModal_otp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">OTP Verify</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="otp_verify" id="otp_verify">
               
            <div class="modal-body">
                    <div class="field-group">
				        <strong>Enter OTP</strong>
						<input type="text" id="otp" name="otp" placeholder="OTP" required="" class="form-control" autocomplete="off" />
				    </div>                
		     </div>
            <div class="modal-footer">
				<input   type="button" value="Resend OTP" class="btn btn-info resend_otp_btn"   />
				<input   type="button" value="Verify" class="btn btn-success"  onclick="check_otp_fun()" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="check_otp" id="check_otp" />
			<input type="hidden" name="verify_for" id="verify_for" />
			     
			</form>
        </div>
    </div>
</div>
 <div id="myModal_mobileno" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter New Mobile no</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="update_mobile" id="update_mobile">
               
            <div class="modal-body">
                    <div class="field-group">
				        <strong>Enter New Mobile No</strong>
						<input type="text" id="mobileno" name="mobileno" placeholder="Mobile No" required="" class="form-control" autocomplete="off"  onkeypress="return isNumber(event)"/>
				    </div>                
		     </div>
            <div class="modal-footer">
				 
				<input   type="button" value="Save" class="btn btn-success"  onclick="update_mobileno()" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 
			</form>
        </div>
    </div>
</div>
<?php $this->view('lib/footer'); ?>
<script>
<?php 
if(!empty($sent_otp))
{
	?>
					toastr["success"]("OTP is sucessfully sent to "+$("#otp_mobile_no").val()+".");
		 
					  $("#check_otp").val(<?=$sent_otp?>);
					  $("#sent_msg").val(3);
					  $(".resend_otp_btn").attr("onclick","resend_otp()");
					  $("#myModal_otp").modal({
						backdrop: 'static',
						keyboard: false
					});  
					  $("#verify_for").val(3);
	<?php
}
?>
</script>
<script>
function same_as_address()
{
	$("#shipper_address").val($("#s_address1").val());
}
function update_bank(bank_id)
{
	 
	 block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"bank_detail/form_edit",
              data: {
					"id": bank_id
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				    $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
						$("#eid").val(bank_id);
						$("#submit_btn").val("Update with OTP");
						$("#bank_name").val(obj.bank_name);
						$("#bank_address").val(obj.bank_address);
						$("#account_name").val(obj.account_name);
						$("#account_no").val(obj.account_no);
						$("#ifsc_code").val(obj.ifsc_code);
						$("#swift_code").val(obj.swift_code);
						$("#bank_ad_code").val(obj.bank_ad_code);
						$("#iban_number").val(obj.iban_number);
						$("#sent_msg").val(1);
						unblock_page("",""); 
                  }
              
          }); 
}
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 $("#add_bank_detail").validate({
		rules: {
			bank_name: {
				required: true
			}
		},
		messages: {
			bank_name: {
				required: "Enter Bank Name"
			}
		}
	});
$("#add_bank_detail").submit(function(event) {
	event.preventDefault();
	
	if(!$("#add_bank_detail").valid())
	{
		return false;
	}
	
	block_page();
	var postData= new FormData(this);
	postData.append("phone_no",$("#otp_mobile_no").val());
	 $.ajax({
            type: "post",
            url: 	root+'bank_detail/manage',
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
				    $("#add_bank_detail").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					 $("#bank_id").append('<option value="'+obj.bank_id+'">'+obj.bankname+'</option>');
					 $("#bank_id").val(obj.bank_id)
					 $("#myModal").modal("hide")
					 $("#myModal_otp").modal("hide")
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ location.reload(); },1500);
				}
				else  if(obj.res==4)
			   {
				     unblock_page("success","OTP is sucessfully sent to "+$("#otp_mobile_no").val()+".");
					  $("#myModal").modal('hide');
					  $("#check_otp").val(obj.otp);
					  $("#sent_msg").val(2);
					  $("#verify_for").val(1);
					  $(".resend_otp_btn").attr("onclick","resend_otp()");
					  $("#myModal_otp").modal({
						backdrop: 'static',
						keyboard: false
					});  
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
function resend_otp()
{
	$("#sent_msg").val(1);
	$("#add_bank_detail").submit();
}
function resend_mobile_otp()
{
	  block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"company_detail/mobile_update",
              data: {
					"s_id"			: <?=$fdv->s_id?>,
					"otp_mobile_no"	: $("#otp_mobile_no").val() 
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				    if(obj.res == 4)
					{
						
						$("#check_otp").val(obj.otp);
						$(".resend_otp_btn").attr("onclick","resend_mobile_otp()");
						  $("#verify_for").val(2);
						$("#myModal_otp").modal({
							backdrop: 'static',
							keyboard: false
						});  
						unblock_page("success","OTP Sent Sucessfully");
					}
					else if(obj.res == 2)
					{
						unblock_page("error","Please check Mobile No.");
					}
                  }
              
          }); 
	 
}
  
function remove_space()
{
	$("#mobileno").val().trim()
}
function check_otp_fun()
{
	 if($("#otp").val()  == "")
	 {
		 $("#otp").focus()
			toastr['error']("OTP can't blank.");
			return false;
	 }
	 
		block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"company_detail/checkotp",
              data: {
					 
					"check_otp"	: $("#otp").val() 
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				    if(obj.res == 1)
					{
						if($("#verify_for").val() == 1)
						{
							$("#sent_msg").val(0);
							$("#add_bank_detail").submit();
						}
						else if($("#verify_for").val() == 2)
						{
						 	$("#myModal_otp").modal('hide');
							$("#myModal_mobileno").modal({
								backdrop: 'static',
								keyboard: false
							});  
						}
						else if($("#verify_for").val() == 3)
						{
							$("#bank_status").val(1)
							$('#company_detail_form').attr('action', "<?=base_url('company_detail/'.$fd.'/'.$fdv->s_id); ?>").submit();
						}
						unblock_page("success","OTP Verify Sucessfully.");
					}
					else if(obj.res == 0)
					{
						unblock_page("error","Wrong OTP.");
					}
                  }
              
          }); 
}
function update_mobile_no()
{
	Swal.fire({
		title: 'Are you sure to sent OTP?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, send it!'
	}).then((result) => {
		 if (result.value) {
			 block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"company_detail/mobile_update",
              data: {
					"s_id"			: <?=$fdv->s_id?>,
					"otp_mobile_no"	: $("#otp_mobile_no").val() 
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				    if(obj.res == 4)
					{
						
						$("#check_otp").val(obj.otp);
						$(".resend_otp_btn").attr("onclick","resend_mobile_otp()");
						  $("#verify_for").val(2);
						$("#myModal_otp").modal({
							backdrop: 'static',
							keyboard: false
						});  
						unblock_page("success","OTP Sent Sucessfully");
					}
					else if(obj.res == 2)
					{
						unblock_page("error","Please check Mobile No.");
					}
                  }
              
          }); 
		 }
	});
}


function update_mobileno()
{
	 if($("#mobileno").val()  == "")
	 {
		toastr['error']("Mobile No can't Blank.");
		return false;
	 }
			 block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"company_detail/mobileupdate",
              data: {
					"s_id"			: <?=$fdv->s_id?>,
					"mobileno"	: $("#mobileno").val() 
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				    if(obj.res == 1)
					{
					 	unblock_page("success","Mobile No Update Sucessfully");
						setTimeout(function(){ location.reload(); },1500);
					}
					else  
					{
						unblock_page("error","Something Wrong");
					}
                  }
              
          }); 
 
}

</script>
