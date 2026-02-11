<?php 
$this->view('lib/header');
 
 if(!empty($export_supplier_data))
 {
	 $epcg_detail = $export_supplier_data[0]->epcg_licence_no;
 }
 else
 {
	 $epcg_detail = $company_detail[0]->epcg_detail;
 }
 
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
							<div class="page-header title1">
									<h3>Export Invoice Supplier Detail</h3>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Supplier Detail
								</div>
								 
                              	<div class="form-body">
								<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="invoice_form" id="invoice_form">
									 <!--		<div class="panel-body">
											<div class="col-md-6">	
												<label class="control-label">Company Type </label> : <?=$company_detail[0]->s_c_type?>
											</div>
											<div class="col-md-12" style="height:20px">	</div>
										 	<div class="col-md-4">		
													<label class="control-label col-md-6">Select Supplier Name</label>  
													<div class="field-group col-md-6" >
														<select class="select2" id="suppiler_id" name="suppiler_id" onchange="load_supplier(this.value,'')">
															<option value="">Select Supplier Name</option>
															<option value="0">Add New Supplier</option>
															<?php
															foreach($supplier_data as $sup_row)
															{
																 $sel ='';
																 $suppiler_id = explode(",",$invoicedata->supplier_id);
																 
																 if($sup_row->supplier_id==$suppiler_id[0])
																 {
																	 $sel = "selected='selected'";
																 }
															?>
																<option <?=$sel?> value="<?=$sup_row->supplier_id?>">
																	<?=$sup_row->name.' - '.$sup_row->company_name?>
																</option>
															<?php
															}
															?>
														</select>
												</div> 
											</div> 
											<div class="col-md-4">		
													<label class="control-label col-md-4">Select EPCG Detail</label>  
													<div class="field-group col-md-6" >
														<select class="select2" id="epcg_licence_no" name="epcg_licence_no" onchange="new_epcg_detail(this.value)">
															<option value="">Select EPCG Detail</option>
														 	 
														</select>
												</div> 
											</div> 
											<div class="col-md-4">		
													<label class="control-label col-md-6">Suppier Invoice No</label>  
													<div class="field-group col-md-6" >
														 <input type="text" name="suppiler_invoice_no" id="suppiler_invoice_no" class="form-control" placeholder="Suppier Invoice No"  autocomplete="off" />
												</div> 
											</div> 
											<div class="col-md-12" style="height:20px"></div>
											
											<div class="col-md-5">		
													<label class="control-label col-md-4">Suppiler Invoice Date</label>  
													<div class="field-group col-md-6" >
														 <input type="text" name="suppiler_invoice_date" id="suppiler_invoice_date" class="form-control defualt-date-picker" placeholder="Suppiler Invoice Date"  autocomplete="off"  />
												</div> 
											</div> 
											
											<div class="col-md-5">		
												<label class="control-label col-md-4">Suppiler Product</label>  
													<div class="field-group col-md-6" >
														 <select class="select2" id="suppiler_product_id" name="suppiler_product_id[]" multiple data-placeholder="Select Product" >
															 
															 <?php
														 	foreach($product_data as $sup_row)
															{
																	$description_goods = $sup_row->description_goods;
																 
																	if(!empty($sup_row->model_name))
																	{
																		$description_goods .=  ' - '.$sup_row->model_name;
																	}
																	if(!empty($sup_row->finish_name))
																	{
																		$description_goods .= ' - '.$sup_row->finish_name;
																	}
																	 
															?>
																<option value="<?=$sup_row->export_packing_id?>"><?=$description_goods?></option>
															<?php
																 
															}
															?>
														</select>
												</div> 
											</div>
												<div class="col-md-2">	
													<button  tabindex="12" class="btn btn-info btn_change" onclick="add_suppiler();">Add</button>
												</div>
									 	</div>
										<input type="hidden" name="export_supplier_id" id="export_supplier_id" value=""/>	
								
								-->
								 <h4 class="text-center">Supplier Invoice No & EPCG Detail</h4>
									<?php 
									 
									if($invoicedata->direct_invoice == 2)
									{
									?>
									<table class="table"  width="100%">
									<thead>
										<tr>
											<th class="text-center"  width="5%">Sr No</th>
											<th class="text-center"  width="10%">Product Detail</th>
											<th class="text-center"  width="10%">Size Detail</th>
											<th class="text-center"  width="7%">Pallet</th>
											<th class="text-center"  width="7%">Boxes</th>
											<th class="text-center"  width="12%">Supplier</th>
											<th class="text-center"  width="20%">EPCG Detail</th>
											<th class="text-center"  width="12%">Supplier Invoice No</th>
											<th class="text-center"  width="13%">Supplier Invoice Date</th>
								 		</tr>
									</thead>
									<tbody>
										<?php 
										$no=1;
										 	$no_of_record = 0;
											foreach($product_data as $sup_row)
											{
												 $suppiler_date = '';
												  
												if($sup_row->suppiler_invoice_date != '0000-00-00' && $sup_row->suppiler_invoice_date != '1970-01-01' && !empty($sup_row->suppiler_invoice_date))
												{
													$suppiler_date = date('d-m-Y',strtotime($sup_row->suppiler_invoice_date));
												}
												 
											?>
												<tr>
													<td class="text-center"><?=$no?></td>
														<?php 
														if(!empty($sup_row->product_id))
														{
														?>
														<td class="text-center">
															<?=$sup_row->series_name?> <br> <?=$sup_row->hsnc_code?>
														</td>
														<td class="text-center">
															<?=$sup_row->size_type_mm?>
															<br>
															<?=$sup_row->model_name?>
															<br>
															<?=$sup_row->finish_name?>
														</td>
														<?php 
														}
														else
														{ 
															echo '<td style="text-align:center" colspan="2">
																						 	'.$sup_row->description_goods.'  </td>';
														}
														?>
														<td style="text-align:center"><?=$sup_row->origanal_pallet?> </td> 							
														<td style="text-align:center"><?=$sup_row->origanal_boxes?> </td> 	
																				
													<td>
														<select class="select2 suppiler_cls" id="suppiler_id<?=$sup_row->export_loading_trn_id?><?=$no?>" name="suppiler_id[]" style="width:200px" onchange="load_supplier(this.value,<?=!empty($sup_row->epcg_licence_no)?$sup_row->epcg_licence_no:0?>,<?=$sup_row->export_loading_trn_id?>,<?=$no?>);do_same_in_all(<?=$sup_row->export_loading_trn_id?><?=$no?>)">
															<option value="">Select Supplier Name</option>
															<option value="0">Add New Supplier</option>
															<?php
															foreach($supplier_data as $suprow)
															{
																 $sel ='';
																  
																 if($suprow->supplier_id==$sup_row->supplier_id)
																 {
																	 $sel = "selected='selected'";
																 }
															?>
																<option <?=$sel?> value="<?=$suprow->supplier_id?>">
																	<?=$suprow->supplier_name.' - '.$suprow->company_name?>
																</option>
															<?php
															}
															?>
														</select>
														 <br>
														 <a href="javascript:;" class="same_cls<?=$sup_row->export_loading_trn_id?><?=$no?>" style="display:none" onclick="change_suppiler(<?=$sup_row->export_loading_trn_id?><?=$no?>)" >Same As all </a>
													</td>
													<td>
												 		<select class="select2 epcg_cls" id="epcg_licence_no<?=$sup_row->export_loading_trn_id?><?=$no?>" style="width:150px" name="epcg_licence_no[]" onchange="new_epcg_detail(this.value,<?=$sup_row->export_loading_trn_id?><?=$no?>);do_same_epcg_in_all(<?=$sup_row->export_loading_trn_id?><?=$no?>)">
															<option value="">Select EPCG Detail</option>
														 	 
															</select>
															<br>
														 <a href="javascript:;" class="epcg_same_cls<?=$sup_row->export_loading_trn_id?><?=$no?>" style="display:none" onclick="change_epcg(<?=$sup_row->export_loading_trn_id?><?=$no?>)" >Same As all </a>
													</td>
													<td class="text-center">
														<input type="text" name="suppiler_invoice_no[]" id="suppiler_invoice_no<?=$sup_row->export_loading_trn_id?><?=$no?>" class="form-control allinvoice_cls" placeholder="Suppier Invoice No"  autocomplete="off" value="<?=$sup_row->suppiler_invoice_no?>" onblur="do_same_invoice_in_all(<?=$sup_row->export_loading_trn_id?><?=$no?>)" />
														<br>
														 <a href="javascript:;" class="invoice_same_cls<?=$sup_row->export_loading_trn_id?><?=$no?>" style="display:none" onclick="change_invoice(<?=$sup_row->export_loading_trn_id?><?=$no?>)" >Same As all </a>
													</td>
													<td class="text-center">
													 <input type="text" name="suppiler_invoice_date[]" id="suppiler_invoice_date<?=$sup_row->export_loading_trn_id?><?=$no?>" class="form-control defualt-date-picker allinvoicedate_cls" placeholder="Suppiler Invoice Date"  autocomplete="off" value="<?=$suppiler_date?>"  onblur="do_same_invoicedate_in_all(<?=$sup_row->export_loading_trn_id?><?=$no?>)" />
														
														<br>
														 <a href="javascript:;" class="invoicedate_same_cls<?=$sup_row->export_loading_trn_id?><?=$no?>" style="display:none" onclick="change_invoicedate(<?=$sup_row->export_loading_trn_id?><?=$no?>)" >Same As all </a>
													</td>
													<input type="hidden" name="export_loading_trn_id[]" id="export_loading_trn_id<?=$sup_row->export_loading_trn_id?>" value="<?=$sup_row->export_loading_trn_id?>"/>			
													<input type="hidden" name="size_type_mm[]" id="size_type_mm<?=$sup_row->export_loading_trn_id?><?=$no?>" value="<?=$sup_row->size_type_mm?>"/>			
													<input type="hidden" name="epcg_licence_id[]" id="epcg_licence_id<?=$sup_row->export_loading_trn_id?><?=$no?>" value="<?=$sup_row->epcg_licence_no?>"/>			
							 			
												</tr>
								
											<?php
												$no++;
											}
											?>
											</tbody>
								</table>
											<?php
										}
										else
										{
											?>
												<div class="form-body">
									 	 
										<div class="panel-body">
											 
											<div class="col-md-12" style="height:20px">	</div>
										 	<div class="col-md-4">		
													<label class="control-label col-md-6">Select Supplier Name</label>  
													<div class="field-group col-md-6" >
														<select class="select2" id="suppiler_id" name="suppiler_id" onchange="loadsupplier(this.value,'')"  style="width:180px">
															<option value="">Select Supplier Name</option>
															 
															<?php
															foreach($supplier_data as $sup_row)
															{
																 $sel ='';
																 $suppiler_id = explode(",",$invoicedata->supplier_id);
																 
																 if($sup_row->supplier_id==$suppiler_id[0])
																 {
																	 $sel = "selected='selected'";
																 }
															?>
																<option <?=$sel?> value="<?=$sup_row->supplier_id?>">
																	<?=$sup_row->supplier_name.' - '.$sup_row->company_name?>
																</option>
															<?php
															}
															?>
														</select>
												</div> 
											</div> 
											<div class="col-md-4">		
													<label class="control-label col-md-4">Select EPCG Detail</label>  
													<div class="field-group col-md-6" >
														<select class="select2" id="epcg_licence_no" name="epcg_licence_no" onchange="new_epcg_detail(this.value,'')"  style="width:250px">
															<option value="">Select EPCG Detail</option>
														 	 
														</select>
												</div> 
											</div> 
											<div class="col-md-4">		
													<label class="control-label col-md-6">Suppier Invoice No</label>  
													<div class="field-group col-md-6" >
														 <input type="text" name="suppiler_invoice_no" id="suppiler_invoice_no" class="form-control" placeholder="Suppier Invoice No"  autocomplete="off" />
												</div> 
											</div> 
											<div class="col-md-12" style="height:20px"></div>
											
											<div class="col-md-5">		
													<label class="control-label col-md-4">Suppiler Invoice Date</label>  
													<div class="field-group col-md-6" >
														 <input type="text" name="suppiler_invoice_date" id="suppiler_invoice_date" class="form-control defualt-date-picker" placeholder="Suppiler Invoice Date"  autocomplete="off"  />
												</div> 
											</div> 
											
											<div class="col-md-5">		
												<label class="control-label col-md-4">Suppiler Product</label>  
													<div class="field-group col-md-6" >
														 <select class="select2" id="suppiler_product_id" name="suppiler_product_id[]" multiple data-placeholder="Select Product" style="width:250px">
															 
															 <?php
														 	foreach($productdata as $sup_row)
															{
																	$description_goods = $sup_row->description_goods;
																 
																	if(!empty($sup_row->model_name))
																	{
																		$description_goods .=  ' - '.$sup_row->model_name;
																	}
																	if(!empty($sup_row->finish_name))
																	{
																		$description_goods .= ' - '.$sup_row->finish_name;
																	}
																	 
															?>
																<option value="<?=$sup_row->export_packing_id?>"><?=$description_goods?></option>
															<?php
																 
															}
															?>
														</select>
												</div> 
											</div>
												<div class="col-md-2">	
													<button type="button" tabindex="12" class="btn btn-info btn_change" onclick="add_suppiler();">Add</button>
												</div>
									 	</div>
										<input type="hidden" name="export_supplier_id" id="export_supplier_id" value=""/>	
								 
								
								</div>
								
								 <h4 class="text-center"> No Of Suppiler</h4>
									<table class="table">
									<thead>
										<tr>
											<th class="text-center">Sr No</th>
											<th class="text-center">Supplier</th>
											<th class="text-center">EPCG Detail</th>
											<th class="text-center">Supplier Invoice No</th>
											<th class="text-center">Supplier Invoice Date</th>
											<th class="text-center">Product Size</th>
										 	<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$no=1;$no_of_record = 0;
										if(!empty($export_supplier_data))
										{
											$no_of_record = 1;
											foreach($export_supplier_data as $sup_row)
											{
												$suppiler_date = date('d/m/Y',strtotime($sup_row->suppiler_invoice_date));
												if($sup_row->suppiler_invoice_date == '0000-00-00' || $sup_row->suppiler_invoice_date == '1970-01-01')
												{
													$suppiler_date = '';
												}
												$epcg_no = (empty($sup_row->epcg_no))?"":"EPCG NO :".$sup_row->epcg_no;
												$epcg_date = (empty($sup_row->epcg_date) || $sup_row->epcg_date == '1970-01-01')?"":"& DATE :".date('d/m/Y',strtotime($sup_row->epcg_date));
											?>
												<tr>
													<td class="text-center"><?=$no?></td>
													<td class="text-center"><?=$sup_row->supplier_name.' - '.$sup_row->company_name?></td>
													<td class="text-center"><?=$epcg_no.' '.$epcg_date?></td>
													<td class="text-center"><?=$sup_row->suppiler_invoice_no?></td>
													<td class="text-center"><?=$suppiler_date?></td>
													<td class="text-center"><?=$sup_row->suppiler_size_name?></td>
													<td class="text-center">
														<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Detele"  onclick="delete_record(<?=$sup_row->export_supplier_id?>)" href="javascript:;" ><i class="fa fa-trash"></i>  </a>
														<a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit"  onclick="edit_record(<?=$sup_row->export_supplier_id?>)" href="javascript:;" ><i class="fa fa-pencil"></i></a>
													</td>
												</tr>
											<?php
												$no++;
											}
										}
										else
										{
											?>
												<tr> 
													<td class="text-center" colspan="7">No Suppiler Added</td> 
												</tr>
											<?php
										}
										?>
									</tbody>
								</table>
								
											<?php
										}
										?>
									
									 
									 
						 
						
						
						<input type="hidden" name="export_invoice_id" id="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"/>			
							 			
								
						<button type="Submit" name="submit"  class="btn btn-success">
							NEXT
						</button>
						 <?php 
					if($invoicedata->direct_invoice == 1)
					{
						?>
						<a href="<?=base_url().'exportinvoiceproduct/direct/'.$invoicedata->export_invoice_id?>" class="btn btn-danger">
							Back
						</a>
						<?php 
					}
					else{
						?>
						<a href="<?=base_url().'exportinvoiceproduct/index/'.$invoicedata->export_invoice_id?>" class="btn btn-danger">
							Back
						</a>
						<?php 
					}
					?>
					 	</form>
								
								</div>
								</div>
					</div>
				 
				</div>
			</div>
		</div>
</div>
<?php $this->view('lib/footer'); ?>
<div id="suppliermodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Supplier</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="supplier_form" id="supplier_form">
				<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<div class="field-group">
							<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Name" required="" class="form-control" />
						</div>   
					</div>
					<div class="col-md-4">					
						<div class="field-group">
								<input type="text" id="company_name" name="company_name" placeholder="Supplier Company Name" required="" title="Enter Company Name" class="form-control"   />
						</div>                
				    </div>                
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="supplier_gstno" name="supplier_gstno" placeholder="Supplier Gst No" required="" title="Enter Gst No" class="form-control"  />
						</div>                
				    </div>
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="supplier_panno" name="supplier_panno" placeholder="Supplier Pan No"  title="Enter Pan No" class="form-control"  />
						</div>                
				    </div>
				 	 <div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="permission_no" name="permission_no" placeholder="Permission No"   class="form-control"/>
						</div>                
				    </div> 
								
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="permission_date" name="permission_date" placeholder="Permission Date"   class="form-control defualt-date-picker"  />
						</div>                
				    </div>  
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="expiry_date" name="expiry_date" placeholder="Expiry Date"   class="form-control"/>
						</div>                
				    </div>   
					 <div class="col-md-4">	
						<label class="col-sm-6  control-label" for="form-field-1">
									Upload Permission Doc
							</label>					
						<div class="field-group col-sm-6">
							<input type="file" name="permission_doc" id="permission_doc" class="form-control" accept="application/msword,application/pdf">
						</div>                
				    </div>
					<div class="col-md-6">					
						<div class="field-group">
							<textarea id="supplier_address" name="supplier_address" placeholder="Supplier Address"  class="form-control" required title="Enter Supplier Address"></textarea>
						</div>                
				    </div> 	
					<div class="col-md-6">					
						<div class="field-group">
							<textarea id="issue_authority_address" name="issue_authority_address" placeholder="Issue uthority Address" class="form-control"></textarea>
						</div>                
				    </div> 
					<div class="col-md-12"></div>	
					  <div class="col-md-6">					
						<div class="field-group">
							<textarea id="supplier_payment_terms" name="supplier_payment_terms" placeholder="Supplier Payment Terms"  class="form-control"   title="Enter Payment Terms" style="height:50px;"></textarea>
						</div>                
				    </div> 		
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="supplier_division" name="supplier_division" placeholder="Division"   class="form-control"  />
						</div>                
				    </div>  
					<div class="col-md-12"></div>	
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="sup_range" name="sup_range" placeholder="Supplier Range"   class="form-control"  />
						</div>                
				    </div>  
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="sup_location_code" name="sup_location_code" placeholder="Supplier Location code"   class="form-control"  />
						</div>                
				    </div>  
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="sup_circular_no" name="sup_circular_no" placeholder="Circular No"   class="form-control"  />
						</div>                
				    </div>  
			 	</div>
			 </div>
				<div class="modal-footer">
					<button name="Submit" type="submit" class="btn btn-info"> Save <img src="<?=base_url()?>adminast/assets/images/loader.gif" style="display:none;width:14px;" class="loader" /></button>   
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<input type="hidden" name="supplierid" id="supplierid" value="" />
				<input type="hidden" name="suppiler_export_loading_trn_id" id="suppiler_export_loading_trn_id" value="" />
			</form>
        </div>
    </div>
</div>
<div id="myModal_epcg" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add EPCG </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="epcg_add" id="epcg_add">
				<div class="modal-body">
				 	<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Detail
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Detail" id="epcg_no" class="form-control" name="epcg_no" value="" >
					 	</div>
					</div>
				       <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Date
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Date" id="epcg_date" class="form-control defualt-date-picker" name="epcg_date" value="" autocomplete="off" required title="Select Date">
					 	</div>
					</div>
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="supplierid" id="supplierid" value="" />
				<input type="hidden" name="epcgseleceted_id" id="epcgseleceted_id" value="" />
			 </form>
        </div>
    </div>
</div>

<script>
// Ensure block_page/unblock_page exist (fallback if footer not loaded or script order issue)
if (typeof block_page !== 'function') {
	window.block_page = function() {
		if (typeof $.blockUI === 'function') {
			$.blockUI({ css: { border: 'none', padding: '0px', width: '17%', left: '43%', backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff', zIndex: '10000' }, message: '<h3> Please wait...</h3>' });
		}
	};
}
if (typeof unblock_page !== 'function') {
	window.unblock_page = function(type, msg) {
		if (type !== '' && msg !== '' && typeof toastr !== 'undefined') { toastr[type](msg); }
		if (typeof $.unblockUI === 'function') { setTimeout($.unblockUI, 500); }
	};
}
function do_same_in_all(val)
{
	$(".same_cls"+val).show();
	$(".same_cls"+val).fadeOut(6000);
}
function change_suppiler(val)
{
	var value= $("#suppiler_id"+val).val();
	 
	$(".suppiler_cls").val(value).trigger('change')
}
function do_same_epcg_in_all(val)
{
	$(".epcg_same_cls"+val).show();
	$(".epcg_same_cls"+val).fadeOut(6000);
}
function change_epcg(val)
{
	var value= $("#epcg_licence_no"+val).val();
	var suppiler_id = $("#suppiler_id"+val).val();
	if(suppiler_id == "")
	{
		 $(".epcg_cls").val(value)
	}
	else
	{
	 var inputs = $(".suppiler_cls");
	 for(var i = 0; i < inputs.length; i++)
	 {
		 
		if($(inputs[i]).val() == suppiler_id)
		{
			var number = $(inputs[i]).attr('id').replace(/[^0-9]/gi, '');
		 	$("#epcg_licence_no"+number).val(value).trigger('change')
		}
	}
	}
	
}
function do_same_invoice_in_all(val)
{
	$(".invoice_same_cls"+val).show();
	$(".invoice_same_cls"+val).fadeOut(6000);
	
}
function change_invoice(val)
{
	var value= $("#suppiler_invoice_no"+val).val();
 	var suppiler_id = $("#suppiler_id"+val).val();
	if(suppiler_id == "")
	{
		$(".allinvoice_cls").val(value).trigger('change');
	}
	else
	{
	 var inputs = $(".suppiler_cls");
		for(var i = 0; i < inputs.length; i++)
		{
		 	if($(inputs[i]).val() == suppiler_id)
			{
				var number = $(inputs[i]).attr('id').replace(/[^0-9]/gi, '');
				$("#suppiler_invoice_no"+number).val(value).trigger('change')
			}
		}
	}
	
	
}
function do_same_invoicedate_in_all(val)
{
	$(".invoicedate_same_cls"+val).show();
	$(".invoicedate_same_cls"+val).fadeOut(6000);
}
function change_invoicedate(val)
{
	var value= $("#suppiler_invoice_date"+val).val();
	var suppiler_id = $("#suppiler_id"+val).val();
	 if(suppiler_id == "")
	{
		$(".allinvoicedate_cls").val(value).trigger('change');
	}
	else
	{
	 var inputs = $(".suppiler_cls");
		for(var i = 0; i < inputs.length; i++)
		{
		 	if($(inputs[i]).val() == suppiler_id)
			{
				var number = $(inputs[i]).attr('id').replace(/[^0-9]/gi, '');
				$("#suppiler_invoice_date"+number).val(value).trigger('change')
			}
		}
	}
	
}
$("#invoice_form").submit(function(event) {
 
	event.preventDefault();
	 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'exportinvoicesupplier/check_supplier',
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
				   $("#invoice_form").trigger('reset');
				    unblock_page("success","EPCG Detail Sucessfully Done."); 
					<?php 
					if($invoicedata->direct_invoice == 1)
					{
					?>
						setTimeout(function(){ window.location=root+'exportinvoicepacking/index/'+$("#export_invoice_id").val(); ; },1500);
					<?php 
					}
					else
					{
					?>
						setTimeout(function(){  window.location=root+'exportinvoiceannexure/index/'+$("#export_invoice_id").val(); },1500);
					<?php 
					}
					?>
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

$(".select2").select2({
	width:'element'
});
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
$('.timepicker').datetimepicker({
  format: 'HH:ii P',
  autoclose: false,
  showMeridian: true,
  startView: 1,
  maxView: 1,
  sideBySide: true,
	 
});
	 
$('.datetimepicker-hours thead').attr('style', 'display:none;');
$('.datetimepicker-hours table').attr('style', 'width:100%');
$('.datetimepicker-minutes thead').attr('style', 'display:none;');
$('.datetimepicker-minutes table').attr('style', 'width:100%');
 
function edit_record(export_supplier_id)
{
	
	 block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"exportinvoicesupplier/getsuppier_detail",
              data: {"export_supplier_id": export_supplier_id}, 
              success: function (response)
				  { 
				var obj = JSON.parse(response);
				 
					$("#suppiler_id").select2('destroy');
					$("#suppiler_id").val(obj.suppiler_id).select2({width:"100%"});
					loadsupplier(obj.suppiler_id,obj.epcg_licence_no)
				    $("#export_supplier_id").val(obj.export_supplier_id);
				    $("#suppiler_invoice_no").val(obj.suppiler_invoice_no);
				    $("#suppiler_invoice_date").val(obj.suppiler_invoice_date);
				   
				    $(".btn_change").html('Edit');
					
					 var text2 = obj.suppiler_size_name.split(",");
					 var value_array = [];
					$("#suppiler_product_id option").filter(function() {
					 	if($.inArray($(this).text(), text2) != -1)
						{
							value_array.push($(this).val());         
						}    
					})
					$("#suppiler_product_id").val(value_array).trigger('change');   
					
				    
               	 	unblock_page("",""); 
                  }
              
          });
	 
}
function delete_record(export_supplier_id)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
					type: "POST", 
					url: root+'exportinvoicesupplier/deleterecord',
					data: {
						"export_supplier_id" : export_supplier_id 
					}, 
					 success: function (data) { 
							var obj = JSON.parse(data);
							if(obj.res==1)
							{
								
								unblock_page('success',"Record Successfully Deleted");
								setTimeout(function(){ location.reload(); },1500);
							}
							else{
								unblock_page('error',"Somthing Wrong.")
							}
					}
			});
		 }
		});	
}

function next_step()
{
	var suppiler_id 			= $("#suppiler_id").val();
	var epcg_licence_no 		= $("#epcg_licence_no").val();
	var epcg_detail 			= $("#epcg_detail").val();
	var export_invoice_id 		= $("#export_invoice_id").val();
	var suppiler_date	 		= $("#suppiler_invoice_date").val();
	var suppiler_invoice_no 	= $("#suppiler_invoice_no").val();
	var suppiler_product_id 	= $("#suppiler_product_id").val();
	var suppiler_size_name  	= $("#suppiler_product_id option:selected").map(function () {
        return $(this).text();
    }).get().join(',');
	if(suppiler_id == "" && <?=$no_of_record?> == 0)
	{
		toastr['error']("Select Supplier");
		return false;
	} 
	block_page();
     $.ajax({ 
            type: "POST", 
            url: root+"exportinvoicesupplier/check_supplier",
            data: {
					"suppiler_id"			: suppiler_id,
					"epcg_licence_no" 		: epcg_licence_no,
					"export_invoice_id" 	: export_invoice_id,
					"epcg_detail" 			: epcg_detail,
					"suppiler_date" 		: suppiler_date,
					"suppiler_invoice_no" 	: suppiler_invoice_no,
					"suppiler_size_name" 	: suppiler_size_name,
					"suppiler_product_id" 	: suppiler_product_id,
					"step" 					: '<?=$invoicedata->step?>',
					"company_type" 			: '<?=$company_detail[0]->s_c_type?>'
			}, 
            success: function (response) 
			{ 
				unblock_page("success","EPCG Detail Sucessfully Done."); 
					<?php 
					if($invoicedata->direct_invoice == 1)
					{
					?>
						setTimeout(function(){ window.location=root+'exportinvoicepacking/index/'+$("#export_invoice_id").val(); ; },1500);
					<?php 
					}
					else
					{
					?>
						setTimeout(function(){  window.location=root+'exportinvoiceannexure/index/'+$("#export_invoice_id").val(); },1500);
					<?php 
					}
					?>
				
            }
              
    });

}
function add_suppiler()
{
	var export_supplier_id 			= $("#export_supplier_id").val();
	var suppiler_id 			= $("#suppiler_id").val();
	var epcg_licence_no 		= $("#epcg_licence_no").val();
	var export_invoice_id 		= $("#export_invoice_id").val();
	var suppiler_date	 		= $("#suppiler_invoice_date").val();
	var suppiler_invoice_no 	= $("#suppiler_invoice_no").val();
	var suppiler_product_id 	= $("#suppiler_product_id").val();
	var suppiler_size_name  	= $("#suppiler_product_id option:selected").map(function () {
        return $(this).text();
    }).get().join(',');
	 
	if(suppiler_id == "")
	{
		toastr['error']("Select Supplier");
		return false;
	}
	 
	block_page();
     $.ajax({ 
            type: "POST", 
            url: root+"exportinvoicesupplier/addsuppiler",
            data: {
					"export_supplier_id"	: export_supplier_id,
					"suppiler_id"			: suppiler_id,
					"epcg_licence_no" 		: epcg_licence_no,
					"export_invoice_id" 	: export_invoice_id,
					"suppiler_date" 		: suppiler_date,
					"suppiler_size_name" 	: suppiler_size_name,
					"suppiler_product_id" 	: suppiler_product_id,
					"suppiler_invoice_no" 	: suppiler_invoice_no
			}, 
            success: function (response) 
			{ 
				unblock_page("success","Supplier Added Sucessfully"); 
				setTimeout(function(){  location.reload(); },1500);
            }
              
    });
}
function load_supplier(cidval,val,export_loading_trn_id,no)
{
	
	if(cidval==0)
	{
		add_new_suppiler();
		return false;
	}
	else
	{
		block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"exportinvoiceproduct/getepcg_detail",
              data: {"supplier_id": cidval}, 
              success: function (response) { 
			  
                    $("#epcg_licence_no"+export_loading_trn_id+no).html(response);
					$("#epcg_licence_no"+export_loading_trn_id+no).select2('destroy');
					$("#epcg_licence_no"+export_loading_trn_id+no).val(val).select2({width:"100%"});
                  
               	 	unblock_page("",""); 
                  }
              
          });
	}
}
function loadsupplier(cidval,val)
{
	if(cidval==0)
	{
		add_new_suppiler();
		return false;
	}
	else
	{
		block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"exportinvoiceproduct/getepcg_detail",
              data: {"supplier_id": cidval}, 
              success: function (response) { 
                    $("#epcg_licence_no").html(response);
					$("#epcg_licence_no").select2('destroy');
					$("#epcg_licence_no").val(val).select2({width:"100%"});
                  
               	 	unblock_page("",""); 
                  }
              
          });
	}
}

function add_new_suppiler()
{
	$('#suppliermodal').modal({
		backdrop: 'static',
		keyboard: false
	}); 
}

function new_epcg_detail(val,no)
{
	if(val==0)
	{
		$("#myModal_epcg").modal("show");
		$("#supplierid").val($("#suppiler_id"+no).val());
		$("#epcgseleceted_id").val('epcg_licence_no'+no);
	}
	 
}  
$(document).ready(function() {
	
	 
	$("#supplier_form").validate({
		rules: {
			supplier_name: {
				required: true
			} 
		},
		messages: {
			supplier_name: {
				required: "Enter Name"
			} 
		}
	});	 
	$("#epcg_add").validate({
		rules: {
			epcg_no: {
				required: true
			}
		},
		messages: {
			epcg_no: {
				required: "Enter EPCG Detail"
			}
		}
	});

});
$("#supplier_form").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Add_supplier/manage',
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
				   $("#supplier_form").trigger('reset');
				    $('#suppliermodal').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#suppiler_id"+$("#")).append("<option value='"+obj.supplier_id+"' selected>"+obj.name+" - "+obj.company_name+"</option>");
					$("#suppiler_id").val(obj.supplier_id);
					$("#suppiler_id").trigger("change")
					load_supplier(obj.supplier_id,'')
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
$("#epcg_add").submit(function(event) {
	event.preventDefault();
	if(!$("#epcg_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	postData.append("supplier_id",$("#supplierid").val());
	$.ajax({
            type: "post",
            url : root+'supplier_epcg_list/manage',
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
				    $("#epcg_add").trigger('reset');
				    $('#myModal_epcg').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#"+$("#epcgseleceted_id").val()).append("<option value='"+obj.id+"' selected>"+obj.epcg_no+" & Dated "+obj.epcg_date+"</option>");
					$("#"+$("#epcgseleceted_id").val()).val(obj.id);
					
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","EPCG Already Exits.");
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
 <script>
  <?php 
					if($invoicedata->direct_invoice != 1)
					{
					?>
		var inps = document.getElementsByName('export_loading_trn_id[]');
		 var no = 1;
		for (var i = 0; i <inps.length; i++) 
		{
			var supplier_id = ($("#suppiler_id"+inps[i].value+no).val() == "")?"-1":$("#suppiler_id"+inps[i].value+no).val();
			var epcg_licence_no = ($("#epcg_licence_id"+inps[i].value+no).val() == "")?"":$("#epcg_licence_id"+inps[i].value+no).val();
			   
		 	load_supplier(supplier_id,epcg_licence_no,inps[i].value,no); 
			no++;
		}
					<?php }
					?>
	
 </script>
  <?php 

	if($no_of_record == 0)
	{
		 echo "<script>load_supplier(".$suppiler_id[0].")</script>";
		 
	}
 
 ?>
 
 
 