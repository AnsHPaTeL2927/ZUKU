<?php 
$this->view('lib/header'); 
?>	
	<div class="main-container">
			<?php $this->view('lib/sidebar'); ?>
			 <div class="main-content">
				<div class="container">
				 	<div class="col-sm-12">
						 <ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
									<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								<li class="active">
									Setting
								</li>
								 
							</ol>
							<div class="page-header">
								<h3> Setting  
								<?php 
							 	if($this->session->usertype_id == "1")
								{
								?>
									<div class="pull-right">
										<a href="javascript:;" type="button" class="btn btn-danger" onclick="remove_all(1);">
											<i class="fa fa-trash"></i> All Data
										</a>
										<a href="javascript:;" type="button" class="btn btn-danger" onclick="remove_all(2);">
											<i class="fa fa-trash"></i> Transaction Data
										</a>
										<a href="javascript:;" type="button" class="btn btn-danger" onclick="remove_all(3);">
											<i class="fa fa-trash"></i> Transaction with Customer & Supplier Data
										</a>
										<a href="javascript:;" type="button" class="btn btn-danger" onclick="drop_all();">
											<i class="icon-remove"></i> Drop All images & docments 
										</a>
										
									</div>
									<?php 
								}
								?>
								</h3>
								
							</div>
						  <div class="row">
						<div class="col-sm-12">
							<div class=" ">
								<div class="panel-body">
									<div role="tabpanel">
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="<?=($_SESSION['updatedinsetting']==0)?"active":""?>" id="tab1" >
												<a href="#table-1" aria-controls="table-1" role="tab" data-toggle="tab">Invoice Type</a>
											</li>
											<li role="presentation" id="tab2" class="<?=($_SESSION['updatedinsetting']==1)?"active":""?>">
												<a href="#table-2" aria-controls="table-2" role="tab" data-toggle="tab">Custom Exchange Rate</a>
											</li>
											<li role="presentation" id="tab3" class="<?=($_SESSION['updatedinsetting'] == 2)?"active":""?>">
												<a href="#table-3" aria-controls="table-3" role="tab" data-toggle="tab">Charges</a>
											</li>
											 <li role="presentation" id="tab4" class="<?=($_SESSION['updatedinsetting'] == 3)?"active":""?>">
												<a href="#table-4" aria-controls="table-4" role="tab" data-toggle="tab"> Warner API Detail</a>
											</li> 
											<li role="presentation" id="tab5" class="<?=($_SESSION['updatedinsetting'] == 4)?"active":""?>">
												<a href="#table-5" aria-controls="table-4" role="tab" data-toggle="tab">On/Off Setting</a>
											</li> 
											<li role="presentation" id="tab6" class="<?=($_SESSION['updatedinsetting'] == 5)?"active":""?>">
												<a href="#table-6" aria-controls="table-5" role="tab" data-toggle="tab">PI Format On/Off Setting</a>
											</li> 
										</ul>
										<div class="tab-content">
										<div role="tabpanel" class="tab-pane <?=($_SESSION['updatedinsetting']==0)?"active":""?>" id="table-1">
												<div class="col-md-6" style="display:none"  id="invoicetype_form">
											<form role="form" class="form-horizontal" action="javascript:;" method="post" name="setting_page" id="setting_page">
											
												<div class="form-group">
													<label class="col-sm-3 control-label" for="form-field-1">
														Invoice Type
													</label>
													<div class="col-sm-6">
														<input type="text"   placeholder="Invoice Type" id="invoice_type" class="form-control" name="invoice_type" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label" for="form-field-1">
														Invoice Series
													</label>
													<div class="col-sm-6">
														<input type="text" placeholder="Invoice Series" id="invoice_series" class="form-control" name="invoice_series" onkeyup="add_formate()">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label" for="form-field-1">
														Invoice Text Format 
													</label>
													<div class="col-sm-6">
														 <select class="form-control valid" id="invoice_format" name="invoice_format" onchange="format_valuechange(this.value);" required title="Select Invoice Format">
																<option value="0">None</option>
																<option value="1">Prefix</option>
															 	<option value="2">Postfix</option>
														</select>
													</div>
													 
												</div>
												
												<div style="display:none" id="format_html">
													 
													<div class="form-group" >
														<label class="col-sm-3 control-label" for="form-field-1">
															Invoice Format Value 
														</label>
														<div class="col-sm-6">
															 <input type="text" placeholder="Invoice Format Value" id="formate_value" class="form-control" name="formate_value" onkeyup="add_formate()">
														 <label style="display:none">Formate Example : <span id="formate_etc"></span></label>
														</div>
														
													</div>
												</div>
												<div class="form-group" >
												 
														<label class="col-sm-3 control-label" for="form-field-1">
															With Date
														</label>
														<div class="col-sm-8">
														 
															<div class="checkbox" style="float: left;width:20%">
																  <label>
																	 <input type="checkbox"  id="with_date1" name="with_date[]" value="1" style="margin-left:-14px" onclick="add_final_format()">Day
																	</label> 
															 </div>
															 
																<div class="checkbox" style="float: left;width:20%"> 
																   <label>
																		<input type="checkbox"  id="with_date2" name="with_date[]" value="2"  style="margin-left:-14px" onclick="add_final_format()">Month
																	</label> 
																</div>
															 
																<div class="checkbox" style="float: left;width:20%">
																	<label>
																		<input type="checkbox"  id="with_date3" name= "with_date[]" value="3"  style="margin-left:-14px" onclick="add_final_format()">Year
																	</label> 
															 </div>
															 <div class="checkbox" style="float: left;width:20%">
																	<label>
																		<input type="checkbox"  id="with_date4" name="with_date[]" value="4"  style="margin-left:-14px" onclick="add_final_format()">Financial Year
																	</label> 
															 </div>
															</div>
															   
														</div>
													<div class="form-group" >
														<label class="col-sm-3 control-label" for="form-field-1">
															Date Value Separate by
														</label>
														<div class="col-sm-6">
															 <input type="text" placeholder="Date Value Separate by" id="separate_by" class="form-control" name="separate_by" onkeyup="add_final_format()">
													 	</div>
														
													</div>	
													<div class="form-group">
													<label class="col-sm-3 control-label" for="form-field-1">
														Date Place
													</label>
													<div class="col-sm-6">
														 <select class="form-control valid" id="date_palce" name="date_palce" onchange="add_final_format();" required title="Select Date Place">
																 <option value="0">None</option>
																 <option value="1">Prefix</option>
															 	<option value="2">Postfix</option>
															 	<option value="3">Infix</option>
														</select>
													</div>
													 
												</div>
												<strong>Final Formate Example : <span id="final_formate_etc"></span></strong>
												<input type="hidden" name="final_formate" id="final_formate" />
												<div class="form-group"  >
												<button type="submit" class="btn btn-success col-md-offset-2">
													Save
												</button>
												 
												</div>	
														<input type="hidden" id="mode" name="mode" value="add" />
													<input type="hidden" id="checkboxvalue" name="checkboxvalue" value="1,2,3" />
													<input type="hidden" id="invoice_type_id" name="invoice_type_id" value="" />
											</form>
										
										</div>
													<div class="table-responsive">
												<table class="table table-bordered table-hover display" id="datatable" width="100%">
													<thead>
														<tr>
															<th>Sr No</th>
															<th>Invoice Type	</th>
															<th>Invoice Series</th>
															<th>Invoice Format</th>
															<th>Formate Value	</th>
															<th>With date	</th>
															<th>Date Separate by	</th>
															<th>Date Palce	</th>
															<th>Example	</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
													<?php
													$no=1;
													for($i=0;$i<count($invoicetypedata);$i++)
													{
														$now = new \DateTime('now');
														$month = $now->format('m');
														$year = $now->format('Y');
														$date = $now->format('d');
														 $lastdata = $lastid +1;
														$Today_Date=$date.'-'.$month.'-'.$year;
														$invoice_no = '';
														
														if($invoicetypedata[$i]->invoice_format==0)
														{ 
															$invoice_no .= $invoicetypedata[$i]->invoice_series;
														}
														else if($invoicetypedata[$i]->invoice_format==1)
														{ 	
															$invoice_no = $invoicetypedata[$i]->formate_value;
															$datevalue = explode(",",$invoicetypedata[$i]->with_date);
															if(in_array(3,$datevalue))
															{
																$invoice_no .= date('Y');
															}
															if(in_array(2,$datevalue))
															{
																$invoice_no .= date('m');
															}
															
															if(in_array(1,$datevalue))
															{
																$invoice_no .= date('d');
															}															
															$invoice_no =  $invoice_no.''.$invoicetypedata[$i]->invoice_series;
														}
														else if($invoicetypedata[$i]->invoice_format==2)
														{ 	
															$invoice_no .= $invoicetypedata[$i]->invoice_series;
															
															$datevalue = explode(",",$invoicetypedata[$i]->with_date);
															if(in_array(3,$datevalue))
															{
																$invoice_no .= date('Y');
															}
															if(in_array(2,$datevalue))
															{
																$invoice_no .= date('m');
															}
															
															if(in_array(1,$datevalue))
															{
																$invoice_no .= date('d');
															}															
															$invoice_no .= $invoicetypedata[$i]->formate_value;
													 	} 
														$explode_array = explode(",",$invoicetypedata[$i]->with_date);
														$value=array();
																if(in_array(1,$explode_array))
																{
																	array_push($value,date('d'));
																}
																if(in_array(2,$explode_array))
																{
																	array_push($value,date('m'));
																}
																if(in_array(3,$explode_array))
																{
																	array_push($value,date('Y'));
																}
																if(in_array(4,$explode_array))
																{
																	$year = date('n') >= 4 ? date('Y').'-'.(date('Y') + 1) : (date('Y') - 1).'-'.date('Y');
																	 
																	array_push($value,$year);
																}
														$implode_array = implode($invoicetypedata[$i]->separate_by,$value);	 
															 
																if($invoicetypedata[$i]->date_palce==1)
																{ 
																	$invoice_no = $implode_array.$invoicetypedata[$i]->separate_by.$invoice_no ;
																}
																else if($invoicetypedata[$i]->date_palce==2)
																{ 	
																	$invoice_no = $invoice_no.$invoicetypedata[$i]->separate_by.$implode_array;
																}
																 
														 ?>
														<tr>
															<td><?=$no?></td>
															<td><?=$invoicetypedata[$i]->invoice_type?></td>
															<td><?=$invoicetypedata[$i]->invoice_series?></td>
															<td><?php
																if($invoicetypedata[$i]->invoice_format==0)
																{ 
																	echo "None";
																}
																else if($invoicetypedata[$i]->invoice_format==1)
																{ 	
																	echo "Prefix";
																}
																else if($invoicetypedata[$i]->invoice_format==2)
																{ 	
																	echo "Postfix";
																}
															?></td>
															 
															<td><?=$invoicetypedata[$i]->formate_value?>	</td>
															<td>
															<?php
																$explode_array = explode(",",$invoicetypedata[$i]->with_date);
																if(in_array(1,$explode_array))
																{
																	echo " Day";
																}
																if(in_array(2,$explode_array))
																{
																	echo " Month";
																}
																if(in_array(3,$explode_array))
																{
																	echo " Year";
																}
																if(in_array(4,$explode_array))
																{
																	echo "Financial Year";
																}
																
																?>	
																</td>
															<td><?=$invoicetypedata[$i]->separate_by?>	</td>
															<td>
															<?php
																if($invoicetypedata[$i]->date_palce==1)
																{ 
																	echo "Prefix";
																}
																else if($invoicetypedata[$i]->date_palce==2)
																{ 	
																	echo "Postfix";
																}
																 
															?>	</td>
														 
															<td>
																<?=$invoice_no?>
															</td>
															<td>	
																<button class="btn btn-primary" onclick="edit_invoicetype(<?=$invoicetypedata[$i]->invoicetype_id?>)" ><i class="glyphicon glyphicon-edit"></i></button>
												
															</td>
														</tr>
													<?php
													$no++; }
													?>
													</tbody>
												</table>
											</div>
										</div>
										<div role="tabpanel" class="tab-pane <?=($_SESSION['updatedinsetting']==1)?"active":""?>" id="table-2">
												<div class="col-md-12">
									<form role="form" class="form-horizontal" action="<?=base_url().'setting/updatedefaultprice'?>" method="post" name="updatesize_recordform" id="updatesize_recordform">
									 
								<?php $size = $setting_data->size_type; ?>
									<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Product Size Type
											</label>
											<div class="col-sm-6">
												<input type="radio" name="psize" id="psize1" value="mm" <?php if($size == 'mm'){ echo 'checked'; } ?>> MM
												<input type="radio" name="psize" id="psize2" value="cm" <?php if($size == 'cm'){ echo 'checked'; } ?>> CM	
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Exchange Rate Notifications 
											</label>
											<div class="col-sm-6">
												<input type="text" name="notification_text" value="<?php echo $setting_data->notification_text; ?>" id="notification_text">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												 USD to INR
											</label>
											<div class="col-sm-6">
												<input type="text" name="usd" value="<?php echo $setting_data->usd; ?>" id="usd">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												EURO to INR
											</label>
											<div class="col-sm-6">
												<input type="text" name="euro" value="<?php echo $setting_data->euro; ?>" id="euro" required title="Enter Euro">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												GBP to INR
											</label>
											<div class="col-sm-6">
												<input type="text" name="gbp" value="<?php echo $setting_data->gbp; ?>" id="gbp" required title="Enter GBP">
											</div>
										</div>
					  
									<small id="succecssmsg"></small>
					
								</div>
										<button type="submit" name="exchange_rate_btn" value="1" class="btn btn-default col-md-offset-2">
											Update Data
										</button>
										</form>
											</div>
										<div role="tabpanel" class="tab-pane <?=($_SESSION['updatedinsetting']==2)?"active":""?>" id="table-3">
										<div class="col-md-12">
											<form role="form" class="form-horizontal" action="<?=base_url().'setting/updatedefaultprice'?>" method="post" name="update_form" id="update_form">
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Fob Charges
													</label>
													<div class="col-sm-6">
														<input type="text" name="fob_charges" value="<?php echo $setting_data->fob_charges; ?>" id="fob_charges" placeholder="Fob Charges">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Pallet Charges
													</label>
													<div class="col-sm-6">
														<input type="text" name="pallet_charges" value="<?php echo $setting_data->pallet_charges; ?>" id="pallet_charges" placeholder="Pallet Charges">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Big Pallet Charges
													</label>
													<div class="col-sm-6">
														<input type="text" name="big_pallet_charge" value="<?php echo $setting_data->big_pallet_charge; ?>" id="big_pallet_charge" placeholder="Big Pallet Charges">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Small Pallet Charges
													</label>
													<div class="col-sm-6">
														<input type="text" name="small_pallet_charges" value="<?php echo $setting_data->small_pallet_charges; ?>" id="small_pallet_charges" placeholder="Small Pallet Charges">
													</div>
												</div>
								 
								</div>
										<button type="submit" class="btn btn-default col-md-offset-2">
											Update Data
										</button>
										</form>
											</div>
										<div role="tabpanel" class="tab-pane <?=($_SESSION['updatedinsetting']==3)?"active":""?>" id="table-4">
										<div class="col-md-12">
											<form role="form" class="form-horizontal" action="<?=base_url().'setting/warner_api'?>" method="post">
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														API KEY
													</label>
													<div class="col-sm-6">
														<input type="text" name="api_key" value="<?php echo $warner_data->api_key; ?>" id="api_key" placeholder="API KEY">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Latitude
													</label>
													<div class="col-sm-6">
														<input type="text" name="latitude" value="<?php echo $warner_data->latitude; ?>" id="latitude" placeholder="Latitude">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Longitude
													</label>
													<div class="col-sm-6">
														<input type="text" name="longitude" value="<?php echo $warner_data->longitude; ?>" id="longitude" placeholder="Longitude">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Company ID
													</label>
													<div class="col-sm-6">
														<input type="text" name="company_id" value="<?php echo $warner_data->warner_company_id; ?>" id="company_id" placeholder="Company ID">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Customer ID
													</label>
													<div class="col-sm-6">
														<input type="text" name="customer_id" value="<?php echo $warner_data->customer_id; ?>" id="customer_id" placeholder="Customer ID">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Enter By
													</label>
													<div class="col-sm-6">
														<input type="text" name="enter_by" value="<?php echo $warner_data->enter_by; ?>" id="enter_by" placeholder="Enter By">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														EBN Enter Type
													</label>
													<div class="col-sm-6">
														<input type="text" name="ebn_enter_type" value="<?php echo $warner_data->ebn_enter_type; ?>" id="ebn_enter_type" placeholder="EBN Enter Type">
													</div>
												</div>
								</div>
										<button type="submit" class="btn btn-default col-md-offset-2">
											Update Data
										</button>
										</form>
											</div>
										
										<div role="tabpanel" class="tab-pane <?=($_SESSION['updatedinsetting']==4)?"active":""?>" id="table-5">
										 
											<form role="form" class="form-horizontal" action="<?=base_url().'setting/warner_api'?>" method="post">
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Selection In Annexure On/Off
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data->branch_code == 1)?"checked":""?> name="company_branch_status" value="1" id="company_branch_status" onclick="change_setting(this.checked,'company_branch_status')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														QC Checkbox in Production Sheet
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data->qc_checked == 1)?"checked":""?> name="qc_checked" value="1" id="qc_checked" onclick="change_setting(this.checked,'qc_checked')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														Palletization Checkbox in Production Sheet
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data->palletization_checked == 1)?"checked":""?> name="palletization_checked" value="1" id="palletization_checked" onclick="change_setting(this.checked,'palletization_checked')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												
									 
										 
										</form>
											</div>
											
											<div role="tabpanel" class="tab-pane <?=($_SESSION['updatedinsetting']==5)?"active":""?>" id="table-6">
										 
											<form role="form" class="form-horizontal" action="<?=base_url().'setting/warner_api'?>" method="post">
																								
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-1 Without Finish in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->without_finish_format == 1)?"checked":""?> name="without_finish_format" value="1" id="without_finish_format" onclick="change_setting_pi(this.checked,'without_finish_format')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-2 With Thickness in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->with_thickness == 1)?"checked":""?> name="with_thickness" value="1" id="with_thickness" onclick="change_setting_pi(this.checked,'with_thickness')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-3 With Unit in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->with_unit == 1)?"checked":""?> name="with_unit" value="1" id="with_unit" onclick="change_setting_pi(this.checked,'with_unit')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-4 With Image Without Barcode in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->with_image_no_barcode == 1)?"checked":""?> name="with_image_no_barcode" value="1" id="with_image_no_barcode" onclick="change_setting_pi(this.checked,'with_image_no_barcode')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-5 in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->pi_five == 1)?"checked":""?> name="pi_five" value="1" id="pi_five" onclick="change_setting_pi(this.checked,'pi_five')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-6 in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->pi_six == 1)?"checked":""?> name="pi_six" value="1" id="pi_six" onclick="change_setting_pi(this.checked,'pi_six')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-7 Zuku Format in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->zuku_format == 1)?"checked":""?> name="zuku_format" value="1" id="zuku_format" onclick="change_setting_pi(this.checked,'zuku_format')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-8 With Other Product in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->other_format == 1)?"checked":""?> name="other_format" value="1" id="other_format" onclick="change_setting_pi(this.checked,'other_format')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-9  in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->pi_nine == 1)?"checked":""?> name="pi_nine" value="1" id="pi_nine" onclick="change_setting_pi(this.checked,'pi_nine')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-10 in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->pi_ten == 1)?"checked":""?> name="pi_ten" value="1" id="pi_ten" onclick="change_setting_pi(this.checked,'pi_ten')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-11 Without Pallet in PI Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->without_pallet == 1)?"checked":""?> name="without_pallet" value="1" id="without_pallet" onclick="change_setting_pi(this.checked,'without_pallet')">
															<span class="slider round"></span>
														</label>
													</div>
												</div>
												
												
												<div class="form-group">
													<label class="col-sm-2 control-label" for="form-field-1">
														PI-12 Mechant Format
													</label>
													<div class="col-sm-6">
														<label class="switch">
															<input type="checkbox" <?=($setting_data_pi->merchant_format == 1)?"checked":""?> name="merchant_format" value="1" id="merchant_format" onclick="change_setting_pi(this.checked,'merchant_format')">
															<span class="slider round"></span>
														</label>
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
						</div>
					</div>
				</div>
			</div>
</div>
<?php $this->view('lib/footer'); ?>
<script>
function change_setting(checked,control)
{
	block_page();
	var value = (checked == true)?1:0;
	
     $.ajax({ 
              type: "POST", 
              url: root+"setting/use_onoff",
              data: {
						"value" 	: value,
						"control" 	: control
					}, 
              success: function (response) 
			  { 
                   var obj = JSON.parse(response);
				   	unblock_page("",""); 
			  }
              
          }); 
} 

function change_setting_pi(checked,control)
{
	block_page();
	var value = (checked == true)?1:0;
	
     $.ajax({ 
              type: "POST", 
              url: root+"setting/use_onoff_pi",
              data: {
						"value" 	: value,
						"control" 	: control
					}, 
              success: function (response) 
			  { 
                   var obj = JSON.parse(response);
				   	unblock_page("",""); 
			  }
              
          }); 
}  
function add_final_format()
{
	var formate_value = $("#formate_value").val();
	var invoice_series = $("#invoice_series").val();
	var format = $("#invoice_format").val();
	 
	var final_formate = '';
		if(format==1)
		{
			 final_formate = formate_value+invoice_series;
		}
		else if(format==2)
		{
			 final_formate = invoice_series+formate_value;
		}
		 
	var date = [];
		$. each($("input[name='with_date[]']:checked"), function(){
			var value = '';
			if($(this). val() == 1)
			{
				value = 'day';
			}
			else if($(this). val() == 2)
			{
				value = 'Month';
			}
			else if($(this). val() == 3)
			{
				value = 'Year';
			}
			else if($(this). val() == 4)
			{
				value = 'Financial Year';
			}
				date.push(value);
		});
	var separate_by = $("#separate_by").val();
	str = date.join(separate_by);

	var date_palce = $("#date_palce").val();
	

	if(date_palce == 1)
	{
		if(format==1)
		{
			 final_formate =  str+separate_by+formate_value+invoice_series;
		}
		else if(format==2)
		{
			 final_formate = invoice_series+formatvalue+separate_by+str;
		}
	}
	else if(date_palce == 2)
	{
		if(format==1)
		{
			 final_formate =   formate_value+invoice_series+separate_by+str;
		}
		else if(format==2)
		{
			 final_formate = invoice_series+formate_value+separate_by+str;
		}
	 
	}
	else if(date_palce == 3)
	{
		if(format==1)
		{
			 final_formate = formate_value+separate_by+str+separate_by+invoice_series;
		}
		else if(format==2)
		{
			 final_formate = invoice_series+separate_by+str+separate_by+formate_value;
		}
		 
	}
	$("#final_formate_etc").html(final_formate)
	$("#final_formate").val(final_formate)
}
$("#setting_page").validate({
		rules: {
			invoice_type: {
				required: true
			},
			invoice_series:{
				required:true 
			} 
		},
		messages: {
			invoice_type: {
				required: "Enter Invoice Type"
			},
			invoice_series:{
				required:"Enter Invoice Series" 
			} 
		}
	});
	$("#updatesize_recordform").validate({
		rules: {
			usd: {
				required: true
			} 
		},
		messages: {
			usd: {
				required: "Enter Usd"
			} 
		}
	});
	function format_valuechange(val)
	{
		if(val=="0")
		{
			$("#format_html").hide();
		}
		else 
		{
			$("#format_html").show();
			add_formate()
		}
		 
	}
	function add_formate()
	{
		var series = $("#invoice_series").val();
		var format = $("#invoice_format").val();
		var formatvalue = $("#formate_value").val();
		if(series=="")
		{
			$("#invoice_series").focus();
			return false;
		}
		if(format==1)
		{
			$("#formate_etc").html(formatvalue+series);
		}
		else if(format==2)
		{
			$("#formate_etc").html(series+formatvalue);
		}
		 add_final_format()
		
		
	}
	function edit_invoicetype(eid)
	{
		 $.ajax({ 
              type: "POST", 
              url: root+"setting/selectinvoicetype",
              data: {
                "eid": eid 
              }, 
              cache: false, 
              success: function (data) {  
				 
                 var response = JSON.parse(data);
				$("#invoicetype_form").show();
				$("#invoice_type").val(response.invoice_type)
				$("#invoice_series").val(response.invoice_series)
			 	$("#invoice_format").val(response.invoice_format)
				$("#formate_value").val(response.formate_value);
				$("#separate_by").val(response.separate_by);
				$("#date_palce").val(response.date_palce);
				$("#final_formate").val(response.final_formate);
			 	$("#final_formate_etc").html(response.final_formate);
				 
				var array = response.with_date.split(",");
				var array1 = response.with_date_sq.split(",");
				for(var a=0;a<array.length;a++)
				{
					 
					if(array[a] == 1)
					{
						$("#with_date1").prop("checked",true)
						$("#with_date_sq1").val(array1[a])
					}
					else if(array[a] == 2)
					{
						$("#with_date2").prop("checked",true)
						$("#with_date_sq2").val(array1[a])
					}
					else if(array[a] == 3)
					{
						
						$("#with_date3").prop("checked",true)
						$("#with_date_sq3").val(array1[a])
					}
					else if(array[a] == 4)
					{
						
						$("#with_date4").prop("checked",true)
						$("#with_date_sq3").val(array1[a])
					}
				}					
				
				//$("#with_date[]").val(response.formate_value)
				$("#mode").val('edit');
				$("#invoice_type_id").val(eid);
				 format_valuechange(response.invoice_format)
                }

            });  
	}

$("#setting_page").submit(function(event) {
	event.preventDefault();
	if(!$("#setting_page").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'setting/manage',
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
				    $("#setting_page").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'setting'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'setting'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 
function remove_all(action)
{
	Swal.fire({
		title: 'Are you sure?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, remove it!'
	}).then((result) => {
		 if (result.value) {
			 block_page();
	$.ajax({ 
              type: "POST", 
              url: root+"setting/remove_data",
              data: {
                "which": action 
              }, 
              cache: false, 
              success: function (data) {  
				 
                	 unblock_page("success","Data Truncate Sucessfully"); 
					//	setTimeout(function(){ location.reload(); },1000);			
				 
                }

            }); 
		 }
		 	});	
}
function drop_all()
{
	Swal.fire({
		title: 'Are you sure?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, Drop it!'
	}).then((result) => {
		 if (result.value) {
			 block_page();
	$.ajax({ 
              type: "POST", 
              url: root+"setting/drop_all",
               cache: false, 
              success: function (data) {  
					console.log(data);
                	 unblock_page("success","Drop all images & doc. sucessfully"); 
					//	setTimeout(function(){ location.reload(); },1000);			
				 
                }

            }); 
		 }
		 	});	
}
 	</script>
