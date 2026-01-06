<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
?>
<style>
table {
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
									Edit Producation
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>All Producation
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
									<i class="fa fa-pencil"></i>
										Producation Edit
								</div>
									
                                <div class="">
								<div class="panel-body form-body">
										 
									<div class="row col-md-10 col-md-offset-1">
								 	<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="addition_details_form" id="addition_details_form">
										 
										 <div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												Select Company
											</label>
											<div class="col-sm-3">
												<select class="select2" name="supplier_id" id="supplier_id" title="Select Company">
													<option value="">Select Factory</option>
													<?php
													foreach($all_supplier as $supplier_row)
													{
														$sel = '';
														if($supplier_row->supplier_id == $producation_data->supplier_id)
														{
															$sel ='selected="selected"';
														}
														echo "<option ".$sel."  value='".$supplier_row->supplier_id."'>".$supplier_row->supplier_name." - ".$supplier_row->company_name."</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												Producation Date
											</label>
											<div class="col-sm-3">
												 <input type="text" name="producation_date" id="producation_date" value="<?=date('d-m-Y',strtotime($producation_data->producation_date))?>" class="defualt-date-picker form-control"   />
											</div>
										</div>
										<div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												Producation No
											</label>
											<div class="col-sm-3">
												 <input type="text" name="producation_no" id="producation_no" value="<?=$producation_data->producation_no?>" class="form-control"   />
											</div>
										</div>
										 <div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Container Of 20 Size
											</label>
											<div class="col-sm-3">
												<input type="text" name="container_twenty" id="container_twenty" class="form-control" placeholder="Container Of 20 Size" value="<?=number_format($producation_data->con_twentry,2)?>" onkeyup="cal_total()" onblur="cal_total()"   title="Enter Container">
										 	</div>
										</div>
										<div class="form-group  col-md-offset-3">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Container Of 40 Size
											</label>
											<div class="col-sm-3">
												<input type="text" name="container_fourty" id="container_fourty" class="form-control" placeholder="Container Of 40 Size" value="<?=number_format($producation_data->con_fourty)?>" onkeyup="cal_total()" onblur="cal_total()"  title="Enter Container">
										 	</div>
										</div>
										<input type="hidden" name="container" value="<?=$producation_data->no_of_countainer?>" id="container"  title="Enter Container">
										  
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Expected Cargo Readiness Date
											</label>
											<div class="col-sm-3">
												<input type="text" placeholder="Date" id="readiness_date" required class="form-control defualt-date-picker" name="readiness_date" value="<?=date('d-m-Y',strtotime($producation_data->readiness_date))?>" title="Expected Cargo Readiness Date" >
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
														if($fumigation_row->fumigation_id == $producation_data->fumigation_id)
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
														if($pallet_cap_row->pallet_cap_id == $producation_data->pallet_cap_id)
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
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$producation_data->made_in_india_status?>" class="form-control" placeholder="Back Side Of The Tiles"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Loading and Shifting By 
											</label>
											<div class="col-sm-3">
												  <input type="text" name="loading_by" id="loading_by" value="<?=$producation_data->loading_by?>" class="form-control" placeholder="Loading and Shifting By"> 
											 </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Pallet By
											</label>
											<div class="col-sm-3">
												  <input type="text" name="pallet_by" id="pallet_by" value="<?=$producation_data->pallet_by?>" class="form-control" placeholder="Pallet Packing By"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												QC By
											</label>
											<div class="col-sm-3">
												  <input type="text" name="qc_by" id="qc_by" value="<?=$producation_data->qc_by?>" class="form-control" placeholder="QC By"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Airbag
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status1" value="YES"  <?=($producation_data->air_bag_status == "YES")?"checked":""?> checked> 
												  		<strong for ="air_bag_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status2" value="NO"  <?=($producation_data->air_bag_status == "NO")?"checked":""?> > 
												  		<strong for ="air_bag_status2">No</strong>
													</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Corner Protector 
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="corner_protector" id="corner_protector1" value="YES"  <?=($producation_data->corner_protector == "YES")?"checked":""?> checked> 
												  		<strong for ="corner_protector1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="corner_protector" id="corner_protector2" value="NO"  <?=($producation_data->corner_protector == "NO")?"checked":""?> > 
												  		<strong for ="corner_protector2">No</strong>
													</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Paper Between The Tiles
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles1" value="YES"  <?=($producation_data->separation_tiles == "YES")?"checked":""?> checked> 
												  		<strong for ="separation_tiles1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles2" value="NO"  <?=($producation_data->separation_tiles == "NO")?"checked":""?> > 
												  		<strong for ="separation_tiles2">No</strong>
													</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Variation in quantity
											</label>
											<div class="col-sm-3">
												  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status1" value="Allowed"  <?=($producation_data->quonitiy_status == "Allowed")?"checked":""?> checked> 
												  		<strong for ="quonitiy_status1">Allowed</strong>
													</label>
													  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status2" value="Not Allowed"  <?=($producation_data->quonitiy_status == "Not Allowed")?"checked":""?> > 
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
											if(!empty($producation_data->barcode_sticker_file))
											{
												$images_name = explode(",",$producation_data->barcode_sticker_file);
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
										 		 <textarea name="box_sticker_remarks" id="box_sticker_remarks" class="form-control" placeholder="Box Sticker Remarks"><?=$producation_data->box_sticker_remarks?></textarea> 
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
											if(!empty($producation_data->box_sticker_file))
											{
												echo "<img src='".base_url()."upload/".$producation_data->box_sticker_file."'  width='110px' height='50px'/>";
											}
											 
											?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 <input type="text" name="extra_field_1" id="extra_field_1" value="<?=$producation_data->extra_field_1?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												  <input type="text" name="extra_field_value_1" id="extra_field_value_1" value="<?=$producation_data->extra_field_value_1?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_2" id="extra_field_2" value="<?=$producation_data->extra_field_2?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_2" id="extra_field_value_2" value="<?=$producation_data->extra_field_value_2?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_3" id="extra_field_3" value="<?=$producation_data->extra_field_3?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_3" id="extra_field_value_3" value="<?=$producation_data->extra_field_value_3?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>	 
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_4" id="extra_field_4" value="<?=$producation_data->extra_field_4?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_4" id="extra_field_value_4" value="<?=$producation_data->extra_field_value_4?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												<input type="text" name="extra_field_5" id="extra_field_5" value="<?=$producation_data->extra_field_5?>" class="form-control" placeholder="Field label"> 
											</label>
											<div class="col-sm-3">
												   <input type="text" name="extra_field_value_5" id="extra_field_value_5" value="<?=$producation_data->extra_field_value_5?>" class="form-control" placeholder="Field value"> 
											 </div>
										</div>
								 		 <hr>
									<!--	<div class="col-md-12">
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
								 		<br>										
										<br>										
											<table class="table table-bordered table-hover" id="sample-table-1" style="width: 100%;"  >
											<thead>
												<tr>
													<th width="5%"  class="text-center"> </th>
													<th width="10%" class="text-center">Design Name</th>
													<th width="10%" class="text-center">Finish</th>
													<th width="10%" class="text-center">Size In CM	</th>
													<th width="8%" class="text-center">Thickness	</th>
													<th width="10%" class="text-center">Images	</th>
													<th width="8%" class="text-center">Plts</th>
													<th width="8%" class="text-center">Pallet Type</th>
													<th width="8%" class="text-center">Boxes</th>
													<th width="8%" class="text-center">Box Design</th>
													<th width="8%" class="text-center">SQM</th>
													<th width="8%" class="text-center">Quantity</th>
												 
												</tr>
											</thead>
											<tbody>
											<?php
													foreach($producation_trn as $trn)
													{
														if(!empty($trn->product_id))
														{
											 	?>
													<tr>
														<td>
															<input type="checkbox" name="copy_make_container[]" id="copy_make_container<?=$trn->performa_packing_id?>" value="<?=$trn->performa_packing_id?>" class="form-control" checked />
														</td>
														 	<td style="text-align:center"><?=$trn->model_name?></td>
															<td style="text-align:center"><?=$trn->finish_name?></td>
															<td style="text-align:center"><?=$trn->size_type_cm?>
															<td style="text-align:center">
															<input type="text" name="thickness<?=$trn->performa_packing_id?>" id="thickness<?=$trn->performa_packing_id?>" class="form-control" value="<?=$trn->thickness?>"  />
														</td>
															<td style="text-align:center">
																<p style="margin: 0 auto; width:98px;height:95px;overflow:hidden">
																<img src="<?=(!empty($trn->design_file))?DESIGN_PATH.$trn->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
															</p>
															
														</td>
														 	
														<td>
														<?php
														if($trn->no_of_pallet>0)
														{ 
															$no_of_pallet = $trn->no_of_pallet;
															echo ' <input type="text" name="no_of_pallet'.$trn->performa_packing_id.'" id="no_of_pallet'.$trn->production_trn_id.'" class="form-control" value="'.$no_of_pallet.'" onblur="cal_sqm('.$trn->production_trn_id.')" onkeyup="cal_sqm('.$trn->production_trn_id.')"/>
															<input type="hidden" name="no_of_big_pallet'.$trn->performa_packing_id.'" id="no_of_big_pallet'.$trn->production_trn_id.'" class="form-control" value="0" />
															<input type="hidden" name="no_of_small_pallet'.$trn->performa_packing_id.'" id="no_of_small_pallet'.$trn->production_trn_id.'" class="form-control" value="0" />
															
															';
															
														}
														else if($trn->no_of_big_pallet>0 || $trn->no_of_small_pallet>0)
														{
															$no_of_big_pallet = $trn->no_of_big_pallet;
															$no_of_small_pallet = $trn->no_of_small_pallet;
															
														 	echo 'Big : <input type="text" name="no_of_big_pallet'.$trn->performa_packing_id.'" id="no_of_big_pallet'.$trn->production_trn_id.'" class="form-control" value="'.$no_of_big_pallet.'" onblur="cal_sqm('.$trn->production_trn_id.')" onkeyup="cal_sqm('.$trn->production_trn_id.')"/>
															<br> Small : <input type="text" name="no_of_small_pallet'.$trn->performa_packing_id.'" id="no_of_small_pallet'.$trn->production_trn_id.'" class="form-control" value="'.$no_of_small_pallet.'" onblur="cal_sqm('.$trn->production_trn_id.')" onkeyup="cal_sqm('.$trn->production_trn_id.')"/>
															
															 <input type="hidden" name="no_of_pallet'.$trn->performa_packing_id.'" id="no_of_pallet'.$trn->production_trn_id.'" class="form-control" value="0"/>
															';
														}
														 
														?>
													</td>
													<td class="text-center">
														<select  id="pallet_type_id<?=$trn->performa_packing_id?>" name="pallet_type_id<?=$trn->performa_packing_id?>" class="select1 pallet_type_cls" style="width:100px" onchange="do_same_in_all(<?=$trn->performa_packing_id?>)">';
															<option value="">Select Pallet Type</option> 
															<?php 
																foreach($pallet_type_data as $pallet_type_row)
																{
																	$sel ='';
																	if($pallet_type_row->pallet_type_id == $trn->pallet_type_id)
																	{
																		$sel = 'selected="selected"';
																	}
																	echo  '<option '.$sel.' value="'.$pallet_type_row->pallet_type_id.'">'.$pallet_type_row->pallet_type_name.'</option>';
																}
																?>
														 </select>
														 <br>
														 <a href="javascript:;" class="same_cls<?=$trn->performa_packing_id?>" style="display:none" onclick="change_pallet_type(<?=$trn->performa_packing_id?>)" >Same As all </a>
													</td>
													 <td>
													<?php 
														if($trn->no_of_boxes > 0)
														{
													 
													?>
														<input type="text" name="no_of_boxes<?=$trn->performa_packing_id?>" id="no_of_boxes<?=$trn->production_trn_id?>" class="form-control" value="<?=$trn->no_of_boxes?>" onblur="cal_sqm(<?=$trn->production_trn_id?>)" onkeyup="cal_sqm(<?=$trn->production_trn_id?>)" />
														<?php 
														}
														
														?>
												 </td>
												 <td class="text-center">
														 <select  id="box_design_id<?=$trn->performa_packing_id?>" name="box_design_id<?=$trn->performa_packing_id?>" class="select1 box_design_cls" style="width:100px"  onchange="do_same_box_all(<?=$trn->performa_packing_id?>)">';
															<option value="">Select Box Design</option> 
															<?php 
																foreach($box_design_data as $box_design_row)
																{
																	$sel ='';
																	if($box_design_row->box_design_id == $trn->box_design_id)
																	{
																		$sel = 'selected="selected"';
																	}
																	echo  '<option '.$sel.' value="'.$box_design_row->box_design_id.'">'.$box_design_row->box_design_name.'</option>';
																}
																?>
														 </select>
														 <br>
														 <a href="javascript:;" class="same_box_cls<?=$trn->performa_packing_id?>" style="display:none" onclick="change_box_design(<?=$trn->performa_packing_id?>)" >Same As all </a>
													</td>
												<td>
														<span id="all_sqm<?=$trn->production_trn_id?>"> <?=$trn->no_of_sqm;?></span>
														 <input type="hidden" name="no_of_sqm<?=$trn->performa_packing_id?>" id="no_of_sqm<?=$trn->production_trn_id?>" value="<?=$trn->no_of_sqm?>" /> 
													</td>
													<td>
														-
													</td>
													</tr>
														<?php }
														else
														{
													 $checktext = 0;
													  
												if($trn->no_of_sqm > 0)
												{
												 	$qty = $trn->no_of_sqm;
													$checktext = 1;
											 	}
												else if($trn->no_of_boxes > 0)
												{
													$qty = $trn->no_of_boxes;
													$checktext = 2;
												}
												 
															?>
														 
												
												 
												<tr>
													<td  style="text-align:center;border-right: none;">
														<input type="checkbox" name="copy_make_container[]" id="copy_make_container<?=$no.$n?>" value="<?=$trn->performa_packing_id?>" class="form-control" checked />
													</td>
													<td colspan="3" style="text-align:center;border-right: none;">
														<?=$trn->description_goods?>
														
													</td>
													<td  style="text-align:center;border-right: none;">
														<img src="<?=(!empty($trn->other_image))?DESIGN_PATH.$trn->other_image:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 
													</td>
													<td  style="text-align:center;border-right: none;">
														 -
													</td>
													<td  style="text-align:center;border-right: none;">
														 -
													</td>
													<td  style="text-align:center;border-right: none;">
														 -
													</td>
													<td  style="text-align:center;border-right: none;">
														<?php 
														 
														if($checktext == 1)
														{
														?>
															<input type="text" name="no_of_sqm<?=$trn->performa_packing_id?>" id="no_of_sqm<?=$trn->performa_packing_id?>" class="form-control" value="<?=$qty?>" />
															<input type="hidden" name="no_of_boxes<?=$trn->performa_packing_id?>" id="no_of_boxes<?=$trn->performa_packing_id?>" class="form-control" value="0"  />
														<?php 
														}
														else
														{
														?>
															<input type="text" name="no_of_boxes<?=$trn->performa_packing_id?>" id="no_of_boxes<?=$trn->performa_packing_id?>" class="form-control" value="<?=$qty?>"  />
															<input type="hidden" name="no_of_sqm<?=$trn->performa_packing_id?>" id="no_of_sqm<?=$trn->performa_packing_id?>" class="form-control" value="0" />
														<?php 
														}
														 
														?>
													</td>
												</tr>	
															<?php
														}
														?>
													<input type="hidden" name="production_trn_id[]" id="production_trn_id<?=$trn->production_trn_id?>" value="<?=$trn->production_trn_id?>" />
													<input type="hidden" name="sqm_per_box[]" id="sqm_per_box<?=$trn->production_trn_id?>" value="<?=$trn->sqm_per_box?>" />
													<input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet<?=$trn->production_trn_id?>" value="<?=$trn->boxes_per_pallet?>" />
													<input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet<?=$trn->production_trn_id?>" value="<?=$trn->box_per_big_pallet?>" />
													<input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet<?=$trn->production_trn_id?>" value="<?=$trn->box_per_small_pallet?>" />
													<input type="hidden" name="weight_per_box[]" id="weight_per_box<?=$trn->production_trn_id?>" value="<?=$trn->weight_per_box?>" />
													<input type="hidden" name="performa_packing_id[]" id="performa_packing_id<?=$trn->performa_packing_id?>" value="<?=$trn->performa_packing_id?>" />
												<?php 
												 
												$sr++;
												
													}
												?>
										 </tbody>
										</table>			
								 									
										<strong>Notes:</strong>
											<textarea name="note" id="note" class="form-control"><?=strip_tags($producation_data->po_notes)?></textarea>
										<div style="padding: 14px;padding-left:0px;">
											<button type="button" tabindex="12" class="btn btn-success" onclick="copy_containter()">Save</button>
											<a href="<?=base_url().'confirm_pi'?>" class="btn btn-danger">
											Back
											</a>
										</div>
										<input type="hidden" name="production_mst_id" id="production_mst_id" value="<?=$producation_data->production_mst_id?>" />
										<input type="hidden" name="performa_additional_detail_id" id="performa_additional_detail_id" value="<?=$producation_data->performa_additional_detail_id?>" />
										<input type="hidden" name="performa_invoice_id" id="performa_invoice_id" value="<?=$producation_data->performa_invoice_id?>"/>
										<input type="hidden" name="barcode_sticker_file_name" id="barcode_sticker_file_name" value="<?=!empty($producation_data)?$producation_data->barcode_sticker_file:''?>"/>
										<input type="hidden" name="box_sticker_file_name" id="box_sticker_file_name" value="<?=!empty($producation_data)?$producation_data->box_sticker_file:''?>"/>
										</form>
									</div>
								</div>
							 	</div>
							 
						</div>
							 
					</div>
 
				</div>
			</div>
				
		</div>
 
<?php $this->view('lib/footer'); ?>
 
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

<script>
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
	var value= $("#pallet_type_id"+performa_packing_id).val()
	$(".pallet_type_cls").val(value).trigger('change')
}
function cal_total()
{
	var container_forty = ($("#container_twenty").val() > 0)?$("#container_twenty").val():0;
	var container_twenty = ($("#container_fourty").val() > 0)?$("#container_fourty").val():0;
	$("#container").val(parseFloat(container_forty) + parseFloat(container_twenty))
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
	 
	 

});
function copy_containter()
{
	$("#addition_details_form").submit();
}
$("#addition_details_form").submit(function(event) {
	event.preventDefault();
	if(!$("#addition_details_form").valid())
	{
		return false;
	}
	var producttrn_id 			= [];
	var container 	  			= $("#container").val();
 
	var total_container 		= 0;
	 $('input[name="copy_make_container[]"]').each(function() {
        if ($(this).is(":checked")) {
             producttrn_id.push($(this).val());
		}
    });
	 if(producttrn_id == "" || producttrn_id == null)
	 {
		 toastr['error']("Please Select atleast 1 design");
		 return false;
	 }
	 
	 
	 block_page();
	var postData= new FormData(this);
	 postData.append("container",container);
	 postData.append("performa_packing_id",producttrn_id);
	$.ajax({
            type		: "post",
            url			: root+'create_producation/copy_containter',
            data		: postData,
			processData	: false,
			contentType	: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
				   
					unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+"view_producation/index/"+obj.production_mst_id; },100);
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