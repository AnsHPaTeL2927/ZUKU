<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
 
?>
<style>
table
{
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	page-break-inside:avoid;
}
table.packing{
	
}
td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
th {
 	border: 0.5px solid #333;
	padding: 3px; 
}
 
</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"producation_pdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"Producation_pdf/view_pdf";
	}
	
}
</script>
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
									<a href="<?=base_url()?>confirm_pi">Cofirm Proforma Invoice List</a>
								</li>
								<li class="active">
									Create Production
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>All Production
									 <div class="pull-right form-group">
									  
									 </div>
								</h3>
								
							 </div>
						 </div>
					</div>
				 <div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-list"></i>
											Production List
									</div>
									<div class="">
										<div class="panel-body form-body">
											<table class="table table-bordered table-hover display" width="100%">
											<thead>
												<tr>
													<th>SR No</th>
													<th>Company Name</th>
													<th>PO No</th>
													<th>Po Date</th>
													<th>Approx Date</th>
													<th>No Of Container</th>
												 	<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php
											$packing_array 			= array();
											$packing_mst_array 		= array();
											$packingtrn_array 		= array();
											$packingtrnarray 		= array();
											$sr 					= 1;
											$total_con				= 0;
											$setcontainer 			= 0;
											$setcontainer_tewety 	= 0;
											$setcontainer_fountry 	= 0;
											 
											 if(!empty($producationdata))
											{
												
												foreach($producationdata as $row)
												{
														
													foreach($row->production_trn as $trn)
													{
														if(!in_array($trn->performa_trn_id,$packing_mst_array))
														{
															array_push($packing_mst_array,$trn->performa_trn_id);
															$packing_array[$trn->performa_trn_id] = array();
															$packing_array[$trn->performa_trn_id]['container'] = $trn->container;
													 	}
														else
														{
															$packing_array[$trn->performa_trn_id]['container'] += $trn->container;
															
														}
													 	 
													  	if(!in_array($trn->performa_packing_id,$packingtrn_array))
														{
															
															array_push($packingtrn_array,$trn->performa_packing_id);
															
															 $packingtrnarray[$trn->performa_packing_id] = array();
															 
															$packingtrnarray[$trn->performa_packing_id]['container'] = $trn->container;
														  
															$packingtrnarray[$trn->performa_packing_id]['no_of_pallet'] = $trn->no_of_pallet;
															$packingtrnarray[$trn->performa_packing_id]['no_of_big_pallet'] = $trn->no_of_big_pallet;
															$packingtrnarray[$trn->performa_packing_id]['no_of_small_pallet'] = $trn->no_of_small_pallet;
															$packingtrnarray[$trn->performa_packing_id]['no_of_boxes'] = $trn->no_of_boxes;
															$packingtrnarray[$trn->performa_packing_id]['no_of_sqm'] = $trn->no_of_sqm;
														}
														else
														{
															 
															$packingtrnarray[$trn->performa_packing_id]['container'] += $trn->container;
															 $packingtrnarray[$trn->performa_packing_id]['no_of_pallet'] += $trn->no_of_pallet;
															 $packingtrnarray[$trn->performa_packing_id]['no_of_big_pallet'] += $trn->no_of_big_pallet;
															 $packingtrnarray[$trn->performa_packing_id]['no_of_small_pallet'] += $trn->no_of_small_pallet;
															 $packingtrnarray[$trn->performa_packing_id]['no_of_boxes'] += $trn->no_of_boxes;
															 $packingtrnarray[$trn->performa_packing_id]['no_of_sqm'] += $trn->no_of_sqm;
															 
														}
												 	} 
												
												if(!empty($row->company_name))
												{													
												?>
													<tr>
														<td><?=$sr?></td>
														<td><?=$row->company_name?></td>
														<td><?=$row->producation_no?></td>
														<td><?=date("d/m/Y",strtotime($row->producation_date))?></td>
														<td><?=date("d/m/Y",strtotime($row->readiness_date))?></td>
														<td><?=number_format($row->no_of_countainer,2)?></td>
														<td> 
															<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Producation Pdf" href="<?=base_url('view_producation/index/'.$row->production_mst_id)?>"><i class="fa fa-eye"></i>
																PDF
															</a>
															<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Producation Pdf" href="<?=base_url('view_producation/index1/'.$row->production_mst_id)?>"><i class="fa fa-eye"></i>
																PDF (Other Product)
															</a>
															<?php
 														
															if(empty($trn->already_loading) && empty($row->po_status))
															{
																?>
																<a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit" href="<?=base_url('create_producation/edit/'.$row->production_mst_id)?>"><i class="fa fa-pencil"></i> Edit</a>
																<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Detele"  onclick="delete_record(<?=$row->production_mst_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
															<?php 
															}
																?>
														</td>
													</tr>
												<?php 
												$total_con 			+= $row->no_of_countainer;
												$setcontainer  		+= $row->no_of_countainer;
												$setcontainer_tewety 	+= $row->con_twentry;
												$setcontainer_fountry 	+= $row->con_fourty;
												$sr++;
												}
												}
											}
											else{
												?>
												<tr>
													<td colspan="6" class="text-center">No Data Found</td>
												 </tr>
												<?php
											}
											  	 			
											?>
											 </tbody>
										</table>
										</div>
									</div>
							</div>
							<?php 
						  
							if(strcmp($invoicedata->container_details,strval($total_con)))
							{
							?>
						<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-pencil"></i>
										Producation Entry
								</div>
									
                                <div class="">
								<div class="panel-body form-body">
										<div class="col-md-4">
											<h4>
												PI NO : <?=$invoicedata->invoice_no?><br><br>
												Order Container : <?=$invoicedata->container_details?><br><br>
												<span id="html_setcontainer"></span> <br><br>
												<span id="html_container"></span>
												
												</h4> 
										</div>
									<div class="row col-md-11 col-md-offset-1">
								 	<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="addition_details_form" id="addition_details_form">
										 
										 <div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												Select Factory
											</label>
											<div class="col-sm-3">
												<select class="select2" name="supplier_id" id="supplier_id" title="Select Company" required >
													<option value="">Select Factory</option>
													<?php
													foreach($all_supplier as $supplier_row)
													{
														$sel = '';
														if($supplier_row->supplier_id == $invoicedata->mgf_company_name)
														{
															$sel ='selected="selected"';
														}
														echo "<option ".$sel."  value='".$supplier_row->supplier_id."'>".$supplier_row->supplier_name." - ".$supplier_row->company_name."</option>";
													}
													?>
												</select>
												<label id="supplier_id-error" class="error" for="supplier_id"></label>
											</div>
										</div>
									<div class="form-group col-md-offset-3">
													<label class="col-sm-3 control-label">Container Of 20 Size</label>
													<div class="col-sm-3">
														<input type="text" name="container_twenty" id="container_twenty" 
															   class="form-control" placeholder="Container Of 20 Size"
															   onkeyup="cal_total()" onblur="cal_total()" title="Enter Container">
													</div>
												</div>

												<div class="form-group col-md-offset-3">
													<label class="col-sm-3 control-label">Container Of 40 Size</label>
													<div class="col-sm-3">
														<input type="text" name="container_fourty" id="container_fourty" 
															   class="form-control" placeholder="Container Of 40 Size"
															   onkeyup="cal_total()" onblur="cal_total()" title="Enter Container">
													</div>
												</div>

												<input type="hidden" name="container" id="container" title="Enter Container">

										  
									 	<div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												Producation Date
											</label>
											<div class="col-sm-3">
												 <input type="text" name="producation_date" id="producation_date" value="<?=date('d-m-Y')?>" class="defualt-date-picker form-control"   />
											</div>
										</div>
										<div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												Producation No
											</label>
											<div class="col-sm-3">
												 <input type="text" name="producation_no" id="producation_no" value="<?=$invoicedata->invoice_no?>" class="form-control"   />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Expected Cargo Readiness Date
											</label>
											<div class="col-sm-3">
												<input type="text" placeholder="Date" id="readiness_date" required class="form-control defualt-date-picker" name="readiness_date" value="<?=date('d-m-Y',strtotime($invoicedata->readiness_date))?>" title="Expected Cargo Readiness Date" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Select Fumigation
											</label>
											<div class="col-sm-3">
												<select class="select2" name="fumigation_id" id="fumigation_id" >
													<option value="">Select Fumigation</option>
												<?php 
													foreach($fumigation_data as $fumigation_row)
													{
														$sel = '';
														if($fumigation_row->fumigation_id == $invoicedata->fumigation_id)
														{
															$sel ='selected="selected"';
														}
														echo "<option ".$sel." value='".$fumigation_row->fumigation_id."'>".$fumigation_row->fumigation_name."</option>";
													}
												?>
												</select>
											</div>
											<div class="col-sm-2">
													<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myFumigation" data-title="Add Fumigation" data-keyboard="false" data-backdrop="static">+ </button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Select Pallet Cap
											</label>
											<div class="col-sm-3">
												<select class="select2" name="pallet_cap_id" id="pallet_cap_id" >
													<option value="">Select Pallet Cap</option>
												<?php 
													foreach($pallet_cap_data as $pallet_cap_row)
													{
														$sel = '';
														if($pallet_cap_row->pallet_cap_id == $invoicedata->pallet_cap_id)
														{
															$sel ='selected="selected"';
														}
														echo "<option ".$sel." value='".$pallet_cap_row->pallet_cap_id."'>".$pallet_cap_row->pallet_cap_name."</option>";
													}
												?>
												</select>
											</div>
											<div class="col-sm-2">
													<button type="button" class="btn btn-info" data-toggle="modal" data-target="#mypallet" data-title="Add Pallet Cap" data-keyboard="false" data-backdrop="static">+ </button>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Back Side Of The Tiles
											</label>
											<div class="col-sm-3">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$invoicedata->made_in_india_status?>" class="form-control" placeholder="Back Side Of The Tiles"> 
											 </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Loading and Shifting By 
											</label>
											<div class="col-sm-3">
												  <input type="text" name="loading_by" id="loading_by" value="<?=$invoicedata->loading_by?>" class="form-control" placeholder="Loading and Shifting By"> 
											 </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Pallet Packing By
											</label>
											<div class="col-sm-3">
												  <input type="text" name="pallet_by" id="pallet_by" value="<?=$invoicedata->pallet_by?>" class="form-control" placeholder="Pallet Packing By"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												QC By
											</label>
											<div class="col-sm-3">
												  <input type="text" name="qc_by" id="qc_by" value="<?=$invoicedata->qc_by?>" class="form-control" placeholder="QC By"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Airbag 
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status1" value="YES"  <?=($invoicedata->air_bag_status == "YES")?"checked":""?> checked> 
												  		<strong for ="air_bag_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status2" value="NO"  <?=($invoicedata->air_bag_status == "NO")?"checked":""?> > 
												  		<strong for ="air_bag_status2">No</strong>
													</label>
											</div>
										</div>	
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Moisture Bag 
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="mosqure_bag_status" id="mosqure_bag_status1" value="YES"  <?=($invoicedata->mosqure_bag_status == "YES")?"checked":""?>> 
												  		<strong for ="mosqure_bag_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="mosqure_bag_status" id="mosqure_bag_status2" value="NO"  <?=($invoicedata->mosqure_bag_status == "NO")?"checked":""?> > 
												  		<strong for ="mosqure_bag_status2">No</strong>
													</label>
											</div>
										</div>
										
										
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												  Corner Protector 
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="corner_protector" id="corner_protector1" value="YES"  <?=($invoicedata->corner_protector == "YES")?"checked":""?> checked> 
												  		<strong for ="corner_protector1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="corner_protector" id="corner_protector2" value="NO"  <?=($invoicedata->corner_protector == "NO")?"checked":""?> > 
												  		<strong for ="corner_protector2">No</strong>
													</label>
											</div>
										</div>
										<!--<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Paper Between The Tiles
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles1" value="YES"  <?=($invoicedata->separation_tiles == "YES")?"checked":""?> checked> 
												  		<strong for ="separation_tiles1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles2" value="NO"  <?=($invoicedata->separation_tiles == "NO")?"checked":""?> > 
												  		<strong for ="separation_tiles2">No</strong>
													</label>
											</div>
										</div>-->
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Separator Between The Tiles
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles1" value="Brown Paper"  <?=($invoicedata->separation_tiles == "Brown Paper")?"checked":""?>  > 
												  		<strong for ="separation_tiles1">Brown Paper</strong>                                    
													</label>                                                                                     
													  <label>                                                                                    
													 <input type="radio" name="separation_tiles" id="separation_tiles2" value="While Paper"  <?=($invoicedata->separation_tiles == "While Paper")?"checked":""?> > 
												  		<strong for ="separation_tiles2">While Paper</strong>                                    
													</label>                                                                                     
													<label>                                                                                      
													 <input type="radio" name="separation_tiles" id="separation_tiles3" value="Foam Sheet"  <?=($invoicedata->separation_tiles== "Foam Sheet")?"checked":""?> > 
												  		<strong for ="separation_tiles3">Foam Sheet</strong>                                     
													</label>                                                                                     
													<label>                                                                                      
													 <input type="radio" name="separation_tiles" id="separation_tiles4" value="Lamination"  <?=($invoicedata->separation_tiles== "Lamination")?"checked":""?> > 
												  		<strong for ="separation_tiles4">Lamination</strong>
													</label>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Safety Belt
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="safety_belt" id="safety_belt1" value="YES"  <?=($invoicedata->safety_belt == "YES")?"checked":""?> > 
												  		<strong for ="safety_belt1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="safety_belt" id="safety_belt2" value="NO"  <?=($invoicedata->safety_belt == "NO")?"checked":""?> > 
												  		<strong for ="safety_belt2">No</strong>
													</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Variation in quantity
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status1" value="Allowed"  <?=($invoicedata->quonitiy_status == "Allowed")?"checked":""?> checked> 
												  		<strong for ="quonitiy_status1">Allowed</strong>
													</label>
													  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status2" value="Not Allowed"  <?=($invoicedata->quonitiy_status == "Not Allowed")?"checked":""?> > 
												  		<strong for ="quonitiy_status2">Not Allowed</strong>
													</label>
											</div>
										</div>
										 
										<div class="form-group barcode_sticker_file_html">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Box Sticker File
											</label>
											<div class="col-sm-3">
										 		 <input type="file" name="barcode_sticker_file[]" id="barcode_sticker_file" class="form-control" multiple> 
										 	</div>
											<?php
											if(!empty($invoicedata->barcode_sticker_file) && $invoicedata->barcode_sticker_file != "none")
											{
												$images_name = explode(",",$invoicedata->barcode_sticker_file);
												foreach($images_name as $img)
												echo "<span><img src='".base_url()."upload/".$img."' width='110px' height='50px' /> </span>";
											}
											?>
										</div>
										<div class="form-group barcode_sticker_file_html">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Box Sticker Remarks
											</label>
											<div class="col-sm-3">
										 		 <textarea name="box_sticker_remarks" id="box_sticker_remarks" class="form-control" placeholder="Box Sticker Remarks"><?=$invoicedata->box_sticker_remarks?></textarea> 
										 	</div>
										</div>
																				
										<div class="form-group box_sticker_file_html">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Pallet Sticker File
											</label>
											<div class="col-sm-3">
										 		 <input type="file" name="box_sticker_file" id="box_sticker_file" class="form-control"> 
										 	</div>
											<div class="col-sm-2">
											<?php
											if(!empty($invoicedata->box_sticker_file) && $invoicedata->box_sticker_file != "none")
											{
												echo "<img src='".base_url()."upload/".$invoicedata->box_sticker_file."'  width='110px' height='50px'/>";
											}
											 
											?>
											</div>
										</div>
										
										<div class="form-group box_sticker_file_html">
											<label class="col-sm-3 control-label" for="form-field-1">
												Special Sticker File
											</label>
											<div class="col-sm-3">
										 		 <input type="file" name="special_sticker_file" id="special_sticker_file" class="form-control"> 
										 	</div>
											<div class="col-sm-2">
											<?php
											if(!empty($invoicedata->special_sticker_file) && $invoicedata->special_sticker_file != "none")
											{
												echo "<img src='".base_url()."upload/".$invoicedata->special_sticker_file."'  width='110px' height='50px'/>";
											}
											 
											?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 <input type="text" name="extra_field_1" id="extra_field_1" value="<?=$invoicedata->extra_field_1?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												  <input type="text" name="extra_field_value_1" id="extra_field_value_1" value="<?=$invoicedata->extra_field_value_1?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_2" id="extra_field_2" value="<?=$invoicedata->extra_field_2?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_2" id="extra_field_value_2" value="<?=$invoicedata->extra_field_value_2?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_3" id="extra_field_3" value="<?=$invoicedata->extra_field_3?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_3" id="extra_field_value_3" value="<?=$invoicedata->extra_field_value_3?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>	 
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_4" id="extra_field_4" value="<?=$invoicedata->extra_field_4?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_4" id="extra_field_value_4" value="<?=$invoicedata->extra_field_value_4?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_5" id="extra_field_5" value="<?=$invoicedata->extra_field_4?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_5" id="extra_field_value_5" value="<?=$invoicedata->extra_field_value_5?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>
								 		 <hr>
										<!--<div class="col-md-12">
											<div class="col-sm-3">
												<strong>Product Size</strong>
											</div>
											 
											<div class="col-sm-3">
												<strong>Thickness</strong>
											</div>
										</div>
									
										<div class="col-md-12" style="height:12px;"></div>
										<?php 
									 	for($i=0; $i<count($all_size);$i++)
										{
										?>
									 	<div class="col-sm-3">
											 <?=$all_size[$i]->size_type_mm?>
											 <input type="hidden" name="size_type_mm[]" id="size_type_mm<?=$i?>" value="<?=$all_size[$i]->size_type_mm?>"/>
										</div>
										 
										 
										<div class="col-sm-3">
												<input type="text" name="thickness[]" id="thickness<?=$i?>" value="<?=$all_size[$i]->thickness?>"/> 
										</div>
										<div class="col-md-12" style="height:12px;"></div>
										<?php 
										}
										?>
										 
										<hr>
										-->
												
										<div class="col-md-12" style="height:12px;"></div>
										<div class="col-md-12">
												<table class="table table-bordered table-hover" id="sample-table-1" style="width: 100%;"  >
											<thead>
												<tr>
													<th width="5%"> 
														<input type="checkbox" name="checkboxall[]" id="checkboxall" value="1" class="form-control" onclick="select_all(this.checked)" />
														Select All
													</th>
													<th width="9%" class="text-center">Design Name</th>
													<th width="9%" class="text-center">Finish</th>
													<th width="10%" class="text-center">Size In CM	</th>
													<th width="6%" class="text-center">Thickness	</th>
													<th width="10%" class="text-center">Images	</th>
													<th width="5%" class="text-center">Container	</th>
													<th width="6%" class="text-center">Plts</th>
													<th width="7%" class="text-center">Pallet Type</th>
													<th width="7%" class="text-center">Boxes</th>
													<th width="7%" class="text-center">Box Design</th>
													<th width="7%" class="text-center">SQM</th>
													<th width="7%" class="text-center">Extra Pallet</th>
													<th width="10%" class="text-center">Location</th>
												 
												</tr>
											</thead>
											<tbody>
											 <?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_ammount = 0;
											$Total_weight = 0;
											$total_container =0;
											$stringcolor=array();	
											$container_order_by=0;
											 $deletestatus = 0;
											 $button_check_array = array();
											$no =1;
											 $no_of_container = 0;
											
											for($i=0; $i<count($product_data);$i++)
											{
												 
												 $Total_plts 	+= $product_data[$i]->total_no_of_pallet;
												 $Total_box 	+= $product_data[$i]->total_no_of_boxes;
												 $Total_sqm 	+= $product_data[$i]->total_no_of_sqm;
												 $Total_ammount += $product_data[$i]->total_product_amt;
												 $Total_weight  += $product_data[$i]->total_gross_weight;
												 $n = 1;
												 $container_box = $product_data[$i]->total_net_weight;
											 
											  foreach($product_data[$i]->packing  as $packing_row)
											  {
												  $qty = 0;  
												    $description_goods =  $product_data[$i]->description_goods;
												
												if(!empty($product_data[$i]->product_id))
												{
													if(!empty($packing_row->model_name))
													{
														$description_goods .=  ' - '.$packing_row->model_name;
													}
													if(!empty($packing_row->client_name))
													{
														$description_goods .= '('.$packing_row->client_name.')';
													}
													if(!empty($packing_row->finish_name))
													{
														$description_goods .= ' - '.$packing_row->finish_name;
													}
													
												 $deletestatus = 0;
												 $no_of_boxes 	= $packing_row->no_of_boxes;
												 $no_of_sqf		= ($product_data[$i]->feet_per_box * $packing_row->no_of_boxes);
												
													$per_value = $packing_row->per;		
												 
												   
													 $minus_pallet = is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_pallet']:0;
													 $no_of_pallet = $packing_row->no_of_pallet - $minus_pallet;
															
													 $minus_bigpallet = is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_big_pallet']:0; 
													 $no_of_big_pallet = $packing_row->no_of_big_pallet - $minus_bigpallet;
													 
													 $minus_smallpallet = is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_small_pallet']:0;
													 $no_of_small_pallet = $packing_row->no_of_small_pallet - $minus_smallpallet;
												
													 $minus_box= is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_boxes']:0;
													 
													 $minus_sqm= is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_sqm']:0;
													
													 $no_of_sqm = $packing_row->no_of_sqm - $minus_sqm; 
													 
													 
													 $no_of_boxes = $no_of_boxes - $minus_box;
													 
												  
												  
													 if($no_of_pallet > 0 || $no_of_big_pallet > 0 || $no_of_small_pallet > 0 || $no_of_boxes > 0 || $no_of_sqm>0)
													 {
											?>
												<tr>
													 
															<td class="text-center">
															<?php
															$no_of_boxes = $packing_row->no_of_boxes - $packingtrnarray[$packing_row->performa_packing_id]['no_of_boxes'];
															
															if($no_of_boxes > 0 || $no_of_sqm>0)
															{
															?>
																<input type="checkbox" name="copy_make_container[]" id="copy_make_container<?=$no.$n?>" value="<?=$packing_row->performa_packing_id?>" class="form-control" <?=$checkedcontainer?> />
															<?php
															}
															?>
															<input type="hidden" name="total_product_container" id="total_product_container<?=$packing_row->performa_packing_id?>" value="<?=$product_data[$i]->product_container?>"/>
															</td>
														  
													 	<td style="text-align:center"><?=$packing_row->model_name?></td>
														<td style="text-align:center"><?=$packing_row->finish_name?></td>
													  	<td style="text-align:center"><?=$product_data[$i]->size_type_cm?></td>
													  	<td style="text-align:center">
															<input type="text" name="thickness<?=$packing_row->performa_packing_id?>" id="thickness<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$product_data[$i]->thickness?>"  />
														</td>
														<td style="text-align:center">
															<p style="margin: 0 auto; width:98px;height:95px;overflow:hidden">
																<img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
															</p>
														</td>
											<td class="text-center">
    <?php 
    $one_container1 = 0;
	$minus_box1= is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_boxes']:0;
														
	$no_of_boxes1 = $packing_row->no_of_boxes - $minus_box;

    if ($packing_row->no_of_pallet > 0) {
        // Case: Normal pallets
        if (!empty($product_data[$i]->box_per_container) && $product_data[$i]->box_per_container > 0) {
            $one_container1 = $no_of_boxes1 / $product_data[$i]->box_per_container;
        }
    } 
    else if ($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet > 0) {
        // Case: Mixed pallets (big/small)
        if (!empty($product_data[$i]->multi_box_per_container) && $product_data[$i]->multi_box_per_container > 0) {
            $one_container1 = $no_of_boxes1 / $product_data[$i]->multi_box_per_container;
        }
    } 
    else {
        // Case: direct box count
        if (!empty($product_data[$i]->total_boxes) && $product_data[$i]->total_boxes > 0) {
            $one_container1 = $no_of_boxes1 / $product_data[$i]->total_boxes;
        }
    }

    // Format output
    $one_container = ($one_container1 > 0) ? number_format($one_container1, 2) : " - ";
	
	
	
    ?>
	
	
    <?=$one_container?>
    <input type="hidden" name="product_container" id="product_container<?=$packing_row->performa_packing_id?>" value="<?=$one_container?>"/>
		<input type="hidden" name="d_container<?=$packing_row->performa_packing_id?>" id="d_container<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$one_container?>"  />
</td>

														<td class="text-center">
														<?php
														if($packing_row->no_of_pallet>0)
														{
														 	echo ' <input type="text" name="no_of_pallet'.$packing_row->performa_packing_id.'" id="no_of_pallet'.$packing_row->performa_packing_id.'" class="form-control" value="'.$no_of_pallet.'" onblur="cal_sqm('.$packing_row->performa_packing_id.')" onkeyup="cal_sqm('.$packing_row->performa_packing_id.')"/>
															
															<input type="hidden" name="no_of_big_pallet'.$packing_row->performa_packing_id.'" id="no_of_big_pallet'.$packing_row->performa_packing_id.'" value="0"/>
															<input type="hidden" name="no_of_small_pallet'.$packing_row->performa_packing_id.'" id="no_of_small_pallet'.$packing_row->performa_packing_id.'" value="0"/>
															';
															
														}
														else if($packing_row->no_of_big_pallet>0 || $packing_row->no_of_small_pallet>0)
														{
														 	echo 'Big : <input type="text" name="no_of_big_pallet'.$packing_row->performa_packing_id.'" id="no_of_big_pallet'.$packing_row->performa_packing_id.'" class="form-control" value="'.$no_of_big_pallet.'" onblur="cal_sqm('.$packing_row->performa_packing_id.')" onkeyup="cal_sqm('.$packing_row->performa_packing_id.')"/>
															
															<br> Small : <input type="text" name="no_of_small_pallet'.$packing_row->performa_packing_id.'" id="no_of_small_pallet'.$packing_row->performa_packing_id.'" class="form-control" value="'.$no_of_small_pallet.'" onblur="cal_sqm('.$packing_row->performa_packing_id.')" onkeyup="cal_sqm('.$packing_row->performa_packing_id.')"/>
															
															<input type="hidden" name="no_of_pallet'.$packing_row->performa_packing_id.'" id="no_of_pallet'.$packing_row->performa_packing_id.'" class="form-control" value="0"/>
															';
														}
														?>
													</td>
													<td class="text-center">
														<select  id="pallet_type_id<?=$packing_row->performa_packing_id?>" name="pallet_type_id<?=$packing_row->performa_packing_id?>" class="select1 pallet_type_cls" style="width:100px" onchange="do_same_in_all(<?=$packing_row->performa_packing_id?>)"> 
															<option value="">Select Pallet Type</option> 
															<?php 
																foreach($pallet_type_data as $pallet_type_row)
																{
																	$sel ='';
																	if($packing_row->pallet_type_id == $pallet_type_row->pallet_type_id)
																	{
																		$sel = 'selected="selected"';
																	}
																	echo  '<option '.$sel.' value="'.$pallet_type_row->pallet_type_id.'">'.$pallet_type_row->pallet_type_name.'</option>';
																}
																?>
														 </select>
														 <br>
														 <a href="javascript:;" class="same_cls<?=$packing_row->performa_packing_id?>" style="display:none" onclick="change_pallet_type(<?=$packing_row->performa_packing_id?>)" >Same As all </a>
													</td>
													<td class="text-center">
													<?php 
													
													if($packing_row->no_of_big_pallet==0 && $packing_row->no_of_small_pallet==0 && $packing_row->no_of_pallet == 0)
													{
														 $minus_box= is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_boxes']:0;
														
														$no_of_boxes = $packing_row->no_of_boxes - $minus_box;
														if($no_of_boxes > 0)
														{
													?>
													
														<input type="text" name="no_of_boxes<?=$packing_row->performa_packing_id?>" id="no_of_boxes<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$no_of_boxes?>" onblur="cal_sqm(<?=$no.$n?>)" onkeyup="cal_sqm(<?=$packing_row->performa_packing_id?>)" />
													<?php 
														}
													}
													else
													{
														 $minus_box= is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_boxes']:0;
														 
														$no_of_boxes = $packing_row->no_of_boxes - $minus_box;
														
														echo '<span id="all_boxes'.$packing_row->performa_packing_id.'">'.$no_of_boxes.'</span><input type="hidden" name="no_of_boxes'.$packing_row->performa_packing_id.'" id="no_of_boxes'.$packing_row->performa_packing_id.'" class="form-control" value="'.$no_of_boxes.'" />';
													}
														if($packing_row->per == "SQM")
														{
															$qty = $packing_row->no_of_sqm;
											
														}
														else if($packing_row->per == "BOX")
														{
															$qty = $packing_row->no_of_boxes;
														}
														else if($packing_row->per == "SQF")
														{ 
															$qty = ($packing_row->no_of_boxes * $product_data[$i]->feet_per_box);
														}
														else if($packing_row->per == "PCS")
														{
															
															$qty = ($packing_row->no_of_boxes * $product_data[$i]->pcs_per_box);
														}
													 
													 
													?>
													</td>
													<td class="text-center">
														 <select  id="box_design_id<?=$packing_row->performa_packing_id?>" name="box_design_id<?=$packing_row->performa_packing_id?>" class="select1 box_design_cls" style="width:100px"  onchange="do_same_box_all(<?=$packing_row->performa_packing_id?>)">';
															<option value="">Select Box Design</option> 
															<?php 
																foreach($box_design_data as $box_design_row)
																{
																	$sel ='';
																	if($packing_row->box_design_id == $box_design_row->box_design_id)
																	{
																		$sel = 'selected="selected"';
																	}
																	echo  '<option '.$sel.' value="'.$box_design_row->box_design_id.'">'.$box_design_row->box_design_name.'</option>';
																}
																?>
														 </select>
														  <br>
														 <a href="javascript:;" class="same_box_cls<?=$packing_row->performa_packing_id?>" style="display:none" onclick="change_box_design(<?=$packing_row->performa_packing_id?>)" >Same As all </a>
														 
													</td>
													<td class="text-center">
														<span id="all_sqm<?=$packing_row->performa_packing_id?>"> <?=$no_of_sqm;?></span>
														 <input type="hidden" name="no_of_sqm<?=$packing_row->performa_packing_id?>" id="no_of_sqm<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$no_of_sqm?>" />
													</td>
													<td class="text-center">
														 <input type="text" name="extra_pallet<?=$packing_row->performa_packing_id?>" id="extra_pallet<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$product_data[$i]->extra_pallet?>"  />
													</td> 
													
													<td class="text-center">
														 <input type="text" name="location<?=$packing_row->performa_packing_id?>" id="location<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$product_data[$i]->location?>"  />
													</td> 
											 	</tr>
												
											<?php
												}											
											}
											else
											{
												$checktext = 0;
												$minus_box= is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_boxes']:0;
												$minus_sqm= is_array($packingtrnarray[$packing_row->performa_packing_id])?$packingtrnarray[$packing_row->performa_packing_id]['no_of_sqm']:0;
													
												if($packing_row->per == "SQM")
												{
												  	$qty = $packing_row->no_of_sqm - $minus_sqm;
													$checktext = 1;
											 	}
												else if($packing_row->per == "BOX")
												{
													$qty = $packing_row->no_of_boxes;
													$checktext = 2;
													 
													$qty = $qty - $minus_box;
													 
												}
												else if($packing_row->per == "SQF")
												{
											 		$qty = ($packing_row->no_of_boxes);
													$checktext = 2;
													$qty = $qty - $minus_box;
												}
												else if($packing_row->per == "PCS")
												{
											 		$qty = ($packing_row->no_of_boxes);
													$checktext = 2;
													$qty = $qty - $minus_box;
												}
													if($qty)
													 {
												?>
												<tr>
													<td  style="text-align:center;border-right:none;">
														<input type="checkbox" name="copy_make_container[]" id="copy_make_container<?=$no.$n?>" value="<?=$packing_row->performa_packing_id?>" class="form-control" <?=$checkedcontainer?> />
													</td>
													<td colspan="3" style="text-align:center;border-right:none;">
														<?=$product_data[$i]->description_goods?>
														
													</td>
													<td  style="text-align:center;border-right:none;">
														<img src="<?=(!empty($packing_row->other_image))?DESIGN_PATH.$packing_row->other_image:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
													</td>
													<td  style="text-align:center;border-right:none;">
														 -
													</td>
													<td  style="text-align:center;border-right:none;">
														 -
													</td>
													<td  style="text-align:center;border-right:none;">
														 -
													</td>
													<td  style="text-align:center;border-right:none;">
														 -
													</td>
														<td  style="text-align:center;border-right:none;">
														 -
													</td>
													<td  style="text-align:center;border-right:none;">
														 -
													</td>
													<td  style="text-align:center;border-right:none;">
														 -
													</td>
													<td  style="text-align:center;border-right:none;">
														<?php 
														 
														if($checktext == 1)
														{
														?>
															<input type="text" name="no_of_sqm<?=$packing_row->performa_packing_id?>" id="no_of_sqm<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$qty?>" />
															<input type="hidden" name="no_of_boxes<?=$packing_row->performa_packing_id?>" id="no_of_boxes<?=$packing_row->performa_packing_id?>" class="form-control" value="0"  />
														<?php 
														}
														else
														{
														?>
															<input type="text" name="no_of_boxes<?=$packing_row->performa_packing_id?>" id="no_of_boxes<?=$packing_row->performa_packing_id?>" class="form-control" value="<?=$qty?>"  />
															<input type="hidden" name="no_of_sqm<?=$packing_row->performa_packing_id?>" id="no_of_sqm<?=$packing_row->performa_packing_id?>" class="form-control" value="0" />
														<?php 
														}
														 
														?>
													</td>
												</tr>
												<?php
													 }
											}
											?>
												<input type="hidden" name="net_weight[]" id="net_weight<?=$packing_row->performa_packing_id?>" value="<?=$container_box?>" />
												<input type="hidden" name="packing_net_weight[]" id="packing_net_weight<?=$packing_row->performa_packing_id?>" value="<?=$packing_row->packing_net_weight?>" />
												
												<input type="hidden" name="weight_per_box[]" id="weight_per_box<?=$packing_row->performa_packing_id?>" value="<?=$product_data[$i]->weight_per_box?>" />
												
												<input type="hidden" name="sqm_per_box[]" id="sqm_per_box<?=$packing_row->performa_packing_id?>" value="<?=$product_data[$i]->sqm_per_box?>" />
												
												<input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet<?=$packing_row->performa_packing_id?>" value="<?=$product_data[$i]->boxes_per_pallet?>" />
												<input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet<?=$packing_row->performa_packing_id?>" value="<?=$product_data[$i]->box_per_big_pallet?>" />
												<input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet<?=$packing_row->performa_packing_id?>" value="<?=$product_data[$i]->box_per_small_pallet?>" />
												<input type="hidden" name="performa_trn_id[]" id="performa_trn_id<?=$packing_row->performa_packing_id?>" value="<?=$product_data[$i]->performa_trn_id?>" />
												<input type="hidden" name="performa_packing_id[]" id="performa_packing_id<?=$packing_row->performa_packing_id?>" value="<?=$packing_row->performa_packing_id?>" />
												<?php
													 
													
												 $n++;
													 }
													 $no++;
											  }
											   
											   
											 
												
												?>
											 </tbody>
										</table>			
								 					</div>							
										<div class="form-group">
											<label class="col-sm-1 control-label" for="form-field-1">
												Note
											</label>
												<div class="col-sm-8">
													<textarea name="note" id="note" class="form-control"><?=$invoicedata->remarks_sheet?></textarea>
												</div>
										</div>
										<div style="padding: 14px;padding-left:0px;">
											<button  type="submit"  tabindex="12" class="btn btn-success"  >Save</button>
											<a href="<?=base_url().'confirm_pi'?>" class="btn btn-danger">
											Back
											</a>
										</div>
											<input type="hidden" name="performa_invoice_id" id="performa_invoice_id" value="<?=$invoicedata->performa_invoice_id?>"/>
											<input type="hidden" name="barcode_sticker_file_name" id="barcode_sticker_file_name" value="<?=$invoicedata->barcode_sticker_file?>"/>
											<input type="hidden" name="box_sticker_file_name" id="box_sticker_file_name" value="<?=$invoicedata->box_sticker_file?>"/>
											<input type="hidden" name="special_sticker_file_name" id="special_sticker_file_name" value="<?=$invoicedata->special_sticker_file?>"/>
										</form>
									</div>
								</div>
							 	</div>
							 
						</div>
							<?php 
							}
						?>
					</div>
 
				</div>
			</div>
				
		</div>
 
<?php $this->view('lib/footer'); ?>
<div id="excelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"   class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Container</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="import_form" id="import_form">
			 
            <div class="modal-body">
                <div class="row">
					  
					<div class="col-md-12 product_html">					
					   <div class="field-group" >
								<div class="tab"> 
										<h4>No Of Container</h4>
										<input type="text" name="producation_container" id="producation_container" class="form-control">
								</div>	
								
						</div> 
						  
					</div> 
				 	 
				 </div>  			
				</div>
            <div class="modal-footer">
			<button  tabindex="12" class="btn btn-success" onclick="copy_containter(<?=$invoicedata->performa_invoice_id?>)">Add </button>
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
							
			</form>
       
    </div>
</div>
</div>
<div id="myFumigation" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Fumigation</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="fumigation_add" id="fumigation_add">
				<div class="modal-body">
                
				    <div class="field-group">
 						<input type="text" placeholder="Fumigation Name" id="fumigation_name" class="form-control" name="fumigation_name" title="Enter Fumigation "/>
				    </div>                
				     
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>
<div id="mypallet" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Pallet Cap</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="pallet_cap_add" id="pallet_cap_add">
				<div class="modal-body">
                
				    <div class="field-group">
 						<input type="text" placeholder="Pallet Cap" id="pallet_cap" class="form-control" name="pallet_cap" title="Enter Pallet Cap "/>
				    </div>                
				     
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>

<!-- Container Limit Modal -->
<div class="modal fade" id="containerLimitModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">⚠ Container Limit Check</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="containerLimitMsg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" id="continueYes" class="btn btn-success">Yes, Continue</button>
        <button type="button" id="continueNo" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
 
	$("#addition_details_form").validate({
		rules: {
			readiness_date: {
				 required:true
			} 
		},
		messages: {
			readiness_date: {
				 required:"Select Date" 
			} 
		}
	});
	 
	 
	 $(document).ready(function() {
    var pending_twety  = parseFloat("<?=$invoicedata->container_twenty?>") - <?=$setcontainer_tewety?>;
    var pending_fountry = parseFloat("<?=$invoicedata->container_forty?>") - <?=$setcontainer_fountry?>;

    // Block typing more than pending_twety
    $("#container_twenty").on("input", function() {
        var val = parseFloat($(this).val()) || 0;
        if (val > pending_twety) {
            $(this).val(pending_twety.toFixed(2));
            toastr["warning"]("Maximum allowed is " + pending_twety.toFixed(2));
        }
        cal_total();
    });

    // Block typing more than pending_fountry
    $("#container_fourty").on("input", function() {
        var val = parseFloat($(this).val()) || 0;
        if (val > pending_fountry) {
            $(this).val(pending_fountry.toFixed(2));
            toastr["warning"]("Maximum allowed is " + pending_fountry.toFixed(2));
        }
        cal_total();
    });

 
});



});
 
// $("#addition_details_form").submit(function(event) {
	// event.preventDefault();
	// if(!$("#addition_details_form").valid())
	// {
		// return false;
	// }
	// var producttrn_id 			= [];
	// var container 	  			= $("#producation_container").val();
 
	// var total_container 		= 0;
	 // $('input[name="copy_make_container[]"]').each(function() {
        // if ($(this).is(":checked")) {
             // producttrn_id.push($(this).val());
		// }
    // });
	 // if(producttrn_id == "" || producttrn_id == null)
	 // {
		 // toastr['error']("Please Select atleast 1 design");
		 // return false;
	 // }
	 // var pending_container = parseFloat(<?=$invoicedata->container_details?>) - <?=$setcontainer?>;
	 // if(pending_container < $("#container").val())
	 // {
		 // toastr['error']("You are enter wrong container. Please check it.");
		 // $("#container").focus()
		 // return false;
	 // }
	 
	  
	 // block_page();
	// var postData= new FormData(this);
	  
	// $.ajax({
            // type: "post",
            // url: 	root+'create_producation/copy_containter',
            // data: postData,
			// processData: false,
			// contentType: false,
			// cache: false,
            // success: function(responseData) {
               // console.log(responseData);
			    // var obj= JSON.parse(responseData);
				// $(".loader").hide();
				// if(obj.res==1)
			   // {
				   
					// unblock_page("success","Sucessfully Inserted.");
					// setTimeout(function(){ window.location=root+"view_producation/index/"+obj.production_mst_id; },100);
			   // }
			   
			   // else
			   // {
				    // unblock_page("error","Something Wrong.") 
				   
			   // }
            // },
            // error: function(jqXHR, textStatus, errorThrown) {
                // console.log(errorThrown);
            // }
	// });
// });
 
$("#addition_details_form").submit(function(event) {
    event.preventDefault();

    if (!$("#addition_details_form").valid()) {
        return false;
    }

    var producttrn_id = [];
    var total_container = (parseFloat($("#container_twenty").val()) || 0) +
                          (parseFloat($("#container_fourty").val()) || 0);

    // collect selected designs + calculate allowed container sum
    var allowed_container = 0;
    $('input[name="copy_make_container[]"]').each(function() {
        if ($(this).is(":checked")) {
            var pid = $(this).val();
            producttrn_id.push(pid);

            // pick its container value
            var designContainer = parseFloat($("#product_container" + pid).val()) || 0;
            allowed_container += designContainer;
        }
    });

    if (producttrn_id.length === 0) {
        toastr['error']("Please select at least 1 design");
        return false;
    }

if (total_container !== allowed_container) {
    var msg = "";

    if (total_container > allowed_container) {
        // ⚠ Greater than allowed → Ask for confirmation
        msg = "⚠ Entered container (" + total_container +
              ") exceeds allowed (" + allowed_container +
              ") for " + producttrn_id.length +
              " selected designs. Do you want to continue?";
    } else {
        // ⚠ Less than allowed → Still ask for confirmation
        msg = "⚠ Entered container (" + total_container +
              ") is less than required (" + allowed_container +
              ") for " + producttrn_id.length +
              " selected designs. Do you want to continue anyway?";
    }

    $("#containerLimitMsg").html(msg);

    // Show both buttons in both cases
    $("#continueYes").show().off("click").on("click", function() {
        $("#containerLimitModal").modal("hide");
        proceedSubmit(); // ✅ continue process
    });

    $("#continueNo").text("Cancel").show().off("click").on("click", function() {
        $("#containerLimitModal").modal("hide");
        location.reload(); // 🔄 refresh page on Cancel
    });

    $("#containerLimitModal").modal("show");

    return false; // wait for user decision
}



    // ✅ check pending_container
    var pending_container = parseFloat("<?=$invoicedata->container_details?>") - <?=$setcontainer?>;
    if (pending_container < total_container) {
        toastr['error']("You entered wrong container. Please check it.");
        $("#container_twenty").focus();
        return false;
    }

    // All good — submit
    proceedSubmit();
});


function proceedSubmit() {
    block_page();
    var postData = new FormData($("#addition_details_form")[0]);

    $.ajax({
        type: "post",
        url: root + 'create_producation/copy_containter',
        data: postData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(responseData) {
            var obj = JSON.parse(responseData);
            $(".loader").hide();
            if (obj.res == 1) {
                unblock_page("success","Successfully Inserted.");
                setTimeout(function(){ 
                    window.location = root + "view_producation/index_extrapallet/" + obj.production_mst_id; 
                }, 100);
            } else {
                unblock_page("error","Something Wrong.");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            unblock_page("error","Something Wrong.");
        }
    });
}


function do_same_box_all(val)
{
	$(".same_box_cls"+val).show();
	$(".same_box_cls"+val).fadeOut(6000);
}
function change_box_design(performa_packing_id)
{
	var value= $("#box_design_id"+performa_packing_id).val()
	$(".box_design_cls").val(value).trigger('change')
}
function do_same_in_all(val)
{
	$(".same_cls"+val).show();
	$(".same_cls"+val).fadeOut(6000);
}
function change_pallet_type(performa_packing_id)
{
	var value= $("#pallet_type_id"+performa_packing_id).val();
	 
	$(".pallet_type_cls").val(value).trigger('change')
}
// function cal_total() {
    // var twenty = parseFloat($("#container_twenty").val()) || 0;
    // var fourty = parseFloat($("#container_fourty").val()) || 0;

    // var total = twenty + fourty;

    // // update hidden input
    // $("#container").val(total);
// }
   function cal_total() {
        var val20 = parseFloat($("#container_twenty").val()) || 0;
        var val40 = parseFloat($("#container_fourty").val()) || 0;
        var total = val20 + val40;
        $("#container").val(total.toFixed(2));
    }

function select_all(val)
{
	if(val == true)
	{
		$("input[name='copy_make_container[]']:checkbox").prop("checked",true);
	}
	else
	{
		$("input[name='copy_make_container[]']:checkbox").prop("checked",false);
	}
}
$("#pallet_cap_add").validate({
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
$("#pallet_cap_add").submit(function(event) {
	event.preventDefault();
	if(!$("#pallet_cap_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'pallet_cap_list/manage';
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
				 
				   unblock_page("success","Sucessfully Inserted.");
					$("#pallet_cap_add").trigger('reset');
					$("#mypallet").modal('hide');
					$("#pallet_cap_id").append('<option value="'+obj.pallet_cap_id+'">'+obj.pallet_cap_name+'</option>');
					$("#pallet_cap_id").val(obj.pallet_cap_id).trigger('change') 
				}
				else if(obj.res==2)
				{
					unblock_page("info","Already Added.");
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

$("#fumigation_add").validate({
		rules: {
			fumigation_name: {
				required: true
			}
		},
		messages: {
			fumigation_name: {
				required: "Enter Fumigation"
			}
		}
	});
$("#fumigation_add").submit(function(event) {
	event.preventDefault();
	if(!$("#fumigation_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'fumigation_list/manage';
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
				   unblock_page("success","Sucessfully Inserted.");
				  $("#fumigation_add").trigger('reset');
				  $("#myFumigation").modal('hide');
				 $("#fumigation_id").append('<option value="'+obj.fumigation_id+'">'+obj.fumigation_name+'</option>');
				 $("#fumigation_id").val(obj.fumigation_id).trigger('change')
				}
				else if(obj.res==2)
				{
					unblock_page("info","Already Added.");
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

var used_container = <?=$setcontainer?>;
var pending_container = parseFloat(<?=$invoicedata->container_details?>) - <?=$setcontainer?>;
var pending_twety = parseFloat(<?=$invoicedata->container_twenty?>) - <?=$setcontainer_tewety?>;
var pending_fountry = parseFloat(<?=$invoicedata->container_forty?>) - <?=$setcontainer_fountry?>;
$("#html_setcontainer").html("Set Container : "+used_container.toFixed(2));
$("#html_container").html("Pending Of Container : "+pending_container.toFixed(2));
$("#container").val(pending_container);
$("#container_twenty").val((pending_twety > 0)?pending_twety.toFixed(2):0);
$("#container_fourty").val((pending_fountry > 0)?pending_fountry.toFixed(2):0);
function cal_sqm(no)
{
	var sqm_per_box 			= $("#sqm_per_box"+no).val();
	var boxes_per_pallet 		= $("#boxes_per_pallet"+no).val();
	var box_per_big_pallet 		= $("#box_per_big_pallet"+no).val();
	var box_per_small_pallet 	= $("#box_per_small_pallet"+no).val();
	
	
	var no_of_pallet 			= $("#no_of_pallet"+no).val();
	var no_of_big_pallet 		= $("#no_of_big_pallet"+no).val();
	var no_of_small_pallet 		= $("#no_of_small_pallet"+no).val();
	var total_net_weight 		= $("#net_weight"+no).val();
	var no_of_con		 		= $("#no_of_con"+no).val();
	var weight_per_box 			= $("#weight_per_box"+no).val();
	 
	 
	if(no_of_pallet > 0)
	{
		var no_of_boxes = parseFloat(no_of_pallet) * parseFloat(boxes_per_pallet);
		var total_sqm = parseFloat(no_of_boxes) * parseFloat(sqm_per_box);
		 
		$("#no_of_boxes"+no).val(no_of_boxes);
		$("#all_boxes"+no).html(no_of_boxes);
		var packing_net_weight = parseFloat(weight_per_box) * parseFloat(no_of_boxes);
		$("#packing_net_weight"+no).val(packing_net_weight);
		 
		var container = parseFloat(packing_net_weight) * parseFloat($("#avaible_container"+no).val()) / parseFloat(total_net_weight); 
		
		 
		
		$("#no_of_sqm"+no).val(total_sqm.toFixed(2));
		$("#all_sqm"+no).html(total_sqm.toFixed(2));
	}
	else if(no_of_big_pallet > 0 || no_of_small_pallet > 0)
	{
		var big_boxes = parseFloat(no_of_big_pallet) * parseFloat(box_per_big_pallet);
		var small_boxes = parseFloat(no_of_small_pallet) * parseFloat(box_per_small_pallet);
		var no_of_boxes = parseFloat(big_boxes) + parseFloat(small_boxes);
		var total_sqm = parseFloat(no_of_boxes) * parseFloat(sqm_per_box);
	 	$("#no_of_boxes"+no).val(no_of_boxes);
		$("#all_boxes"+no).html(no_of_boxes);
		$("#no_of_sqm"+no).val(total_sqm.toFixed(2));
		$("#all_sqm"+no).html(total_sqm.toFixed(2));
		var packing_net_weight = parseFloat(weight_per_box) * parseFloat(no_of_boxes);
		$("#packing_net_weight"+no).val(packing_net_weight);
		var container = parseFloat(packing_net_weight) * parseFloat($("#avaible_container"+no).val()) / parseFloat(total_net_weight); 
		
		 
	 
	}
	else if(parseInt(boxes_per_pallet) == 0 && parseInt(box_per_big_pallet)== 0 && parseInt(box_per_small_pallet) == 0)
	{
		var no_of_boxes = $("#no_of_boxes"+no).val();
		var total_sqm = parseFloat(no_of_boxes) * parseFloat(sqm_per_box);
		 
	 	 $("#no_of_sqm"+no).val(total_sqm.toFixed(2));
		$("#all_sqm"+no).html(total_sqm.toFixed(2));
		var packing_net_weight = parseFloat(weight_per_box) * parseFloat(no_of_boxes);
		$("#packing_net_weight"+no).val(packing_net_weight);
		var container = parseFloat(packing_net_weight) * parseFloat($("#avaible_container"+no).val()) / parseFloat(total_net_weight); 
		
		 
	}
	
}
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
$(".select2").select2({
	width:'100%'
});
$(".select1").select2({
	width:'element'
});

/* function copy_containter(performa_invoice_id)
{
	var producttrn_id 			= [];
	var container 	  			= $("#producation_container").val();
	var no_of_pallet 	  		= [];
	var no_of_big_pallet 	 	= [];
	var no_of_small_pallet 	 	= [];
	var no_of_boxes 	  		= [];
	var no_of_sqm 	 			= [];
	var no_of_con 	 			= [];
	var performa_trn_id 	  	= [];
	var total_container 		= 0;
	 $('input[name="copy_make_container[]"]').each(function() {
        if ($(this).is(":checked")) {
             producttrn_id.push($(this).val());
			 
			 no_of_pallet.push($("#no_of_pallet"+$(this).val()).val());
			 no_of_big_pallet.push($("#no_of_big_pallet"+$(this).val()).val());
			 no_of_small_pallet.push($("#no_of_small_pallet"+$(this).val()).val());
			 no_of_boxes.push($("#no_of_boxes"+$(this).val()).val());
			 no_of_sqm.push($("#no_of_sqm"+$(this).val()).val());
			 performa_trn_id.push($("#performa_trn_id"+$(this).val()).val());
			  
           	 total_container += parseFloat($("#no_of_con"+$(this). val()).val())
        }
    });
	 if(producttrn_id == "" || producttrn_id == null)
	 {
		 toastr['error']("Please Select atleast 1 design");
		 return false;
	 }
	 if(container == "" || container == 0)
	{
		$("#excelModal").modal('show');
		return false;
	}
	block_page();
	$.ajax({ 
             type: "POST", 
             url: root+'create_producation/copy_containter',
             data: {
               "producttrn_id"			: producttrn_id,
               "performa_trn_id" 		: performa_trn_id,
               "container"				: container,
               "no_of_pallet"			: no_of_pallet,
               "no_of_big_pallet"		: no_of_big_pallet,
               "no_of_small_pallet"		: no_of_small_pallet,
               "no_of_boxes"			: no_of_boxes,
               "no_of_sqm"				: no_of_sqm,
               "no_of_countainer"		: total_container,
               "producation_date"		: $("#producation_date").val(),
               "producation_no"			: $("#producation_no").val(),
               "note"					: $("#note").val(),
               "supplier_id"	 		: $("#supplier_id").val(),
               "box_design_id"			: $("#box_design_id").val(),
               "readiness_date"			: $("#readiness_date").val(),
               "fumigation_id"			: $("#fumigation_id").val(),
               "pallet_type_id"			: $("#pallet_type_id").val(),
               "mgf_company_name"		: $("#mgf_company_name").val(),
               "pallet_cap_id"			: $("#pallet_cap_id").val(),
               "air_bag_status"			: $("input[name='air_bag_status']:checked").val(),
               "made_in_india_status"	: $("input[name='made_in_india_status']:checked").val(),
               "corner_protector"		: $("input[name='corner_protector']:checked").val(),
               "separation_tiles"		: $("input[name='separation_tiles']:checked").val(),
               "barcode_sticker"		: $("input[name='barcode_sticker']:checked").val(),
               "box_sticker"			: $("input[name='box_sticker']:checked").val(),
               "performa_invoice_id"	: performa_invoice_id 
             }, 
             cache: false, 
             success: function (data) { 
		       unblock_page("success","Sucessfully Created.");
			setTimeout(function(){ window.location='<?=base_url()?>view_producation/index/'+data; },1000);
             }
			});
	 
}

*/
function delete_record(production_mst_id)
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
              url: root+'create_producation/deleterecord',
              data: {
                "production_mst_id" : production_mst_id 
              }, 
              cache: false, 
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
</script>