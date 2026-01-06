<?php 
$form = 'Product Size';
if($mode == "packing")
{
	$form = 'Add Packing Of '.$product_data->series_name.' - '.$product_data->size_type_cm.$thickness;
} 
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
						<li>
							<a href="<?=base_url().'product_list'?>">
								Product List
							</a>
						</li>
						<?php 
						if($mode == "packing")
						{
							echo '<li>
									<a href="'.base_url().'product_packing_list/index/'.$product_data->product_id.'">
								Packing List
							</a>
						</li>';
						}
						?>
						<li class="active">
							<?=($mode == "packing")?"":$mode?> <?=$form?> 
						</li>
					 
					</ol>
					<div class="page-header">
						<h3>
							<?=($mode == "packing")?"":$mode?> <?=$form?>   
						</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class=" ">
						<div class="panel-body">
							<form class="form-horizontal askform" action="javascript:;"  method="post" name="product_form" id="product_form">
							<?php 
							if($mode != "packing")
							{
							?>
        					<div class="col-md-6">
							<h4><u>Size Detail</u></h4>							
								<div class="form-group">
									<label class="col-sm-4 control-label" for="form-field-1">
										Select Product
									</label>
									<div class="col-sm-6">
										<select class="select2" name="series_id" id="series_id" onchange="add_new_serices(this.value)">
										<option value="">Select Product</option>
										<option value="0">Add Product</option>
										<?php
										for($s=0;$s<count($seriesdata);$s++)
										{
											 
											$sel= '';
											if($seriesdata[$s]->series_id==$edit_record->series_id)
											{
												$sel = 'selected="selected"';
											}											
										?>
											<option <?=$sel?> value="<?=$seriesdata[$s]->series_id ?>" ><?=$seriesdata[$s]->series_name?> </option>
											
										<?php 
										}?>
										</select>
									</div>
								</div> 	
								<div class="form-group">
									<label class="col-sm-4 control-label" for="form-field-1">
											Size Width IN MM
									</label>
									<div class="col-sm-6">
										<input type="text" id="size_width_mm" name="size_width_mm" placeholder="" required="" class="form-control" onkeypress="return isNumber(event)" onkeyup="allcalculation()" value="<?=$edit_record->size_width_mm?>" title="Enter Size Width In MM" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="form-field-1">
										Size Width IN CM
									</label>
									<div class="col-sm-6">
										<input type="text" id="size_width_cm" readonly name="size_width_cm" placeholder="" required="" class="form-control" title="Enter Size Width IN CM" value="<?=$edit_record->size_width_cm?>" />
									</div>
								</div>                
								<div class="form-group">
										<label class="col-sm-4  control-label" for="form-field-1">
											Size Height IN MM
									</label>
									<div class="col-sm-6">
										<input type="text" id="size_height_mm" name="size_height_mm" placeholder="" required="" class="form-control" title="Enter Size Height IN MM" onkeyup="allcalculation()" onkeypress="return isNumber(event)" value="<?=$edit_record->size_height_mm?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="form-field-1">
											Size Height IN CM
									</label>	
									<div class="col-sm-6">
										<input type="text" id="size_height_cm" readonly name="size_height_cm" placeholder="" required="" class="form-control" title="Enter Size Height IN CM" value="<?=$edit_record->size_height_cm?>"  />
									</div>
								</div> 
								<div class="form-group">
									<label class="col-sm-4 control-label" for="form-field-1">
											Thickness 
									</label>
									<div class="col-sm-4">
										<input type="text" id="thickness" name="thickness" placeholder=""   class="form-control"  value="<?=$edit_record->thickness?>" title="Enter Size Width In MM" />
									</div>
									<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
										<strong> MM</strong> 
									</div>
								</div>								
								<!--<div class="form-group">
									<label class="col-sm-4 control-label" for="form-field-1">
											Defualt Rate
									</label>
									<div class="col-sm-4">
										<input type="text" id="defualt_rate" name="defualt_rate" placeholder="" required="" class="form-control" onkeypress="return isNumber(event)" value="<?=$edit_record->defualt_rate?>" title="Enter Defualt Rate" /> 
									</div>
										<div class="col-sm-4" style="margin-top: 5px;padding-left: 0px;"><strong>USD/SQM</strong></div>
								</div>	-->							
								<input type="hidden" name="size_type_mm" id="size_type_mm" value="<?=$edit_record->size_type_mm?>">
								<input type="hidden" name="size_type_cm" id="size_type_cm" value="<?=$edit_record->size_type_cm?>">
						</div>
						<?php 
							}
							else
							{
								
							  	echo '<input type="hidden" id="size_width_mm" name="size_width_mm"  value="'.$product_data->size_width_mm.'"/>';
								echo '<input type="hidden" id="size_height_mm" name="size_height_mm"  value="'.$product_data->size_height_mm.'"/>';
								echo '<input type="hidden" id="size_width_cm" name="size_width_cm"  value="'.$product_data->size_width_cm.'"/>';
								echo '<input type="hidden" id="size_type_cm" name="size_type_cm"  value="'.$product_data->size_type_cm.'"/>';
							}
							?>
				<div class="col-md-6">
					<h4><u>Packing Detail</u></h4>
						<div class="form-group">
						 	<label class="col-sm-5 control-label" for="form-field-1">
						 		 Packing Name
						 	</label>
						 	<div class="col-sm-6">
						 	<input type="text" id="product_packing_name" name="product_packing_name" placeholder="" class="form-control"   value="<?=!empty($productsize_record->product_packing_name || $mode == "packing")?$productsize_record->product_packing_name:'Default'?>"   required title="Enter Packing Name" />
						 	</div>    
						 </div> 
						<div class="form-group">
						 	<label class="col-sm-5 control-label" for="form-field-1">
						 		Pcs Per Box
						 	</label>
						 	<div class="col-sm-6">
						 	<input type="text" id="pcs_per_box" name="pcs_per_box" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$productsize_record->pcs_per_box?>"   required title="Enter Pcs Per Box" />
						 	</div>    
						 </div> 
						 <div class="form-group">
						 	<label class="col-sm-5 control-label" for="form-field-1">
						 		Approx Weight Per Box 
						 	</label>
						 	<div class="col-sm-4">
						 		<input type="text" id="weight_per_box" name="weight_per_box" placeholder="" class="form-control"  onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$productsize_record->weight_per_box?>"  required title="Enter Approx Weight Per Box" /> 
						 
						 	</div>  
						 	<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
						 </div> 
						<div class="form-group">
							 	<label class="col-sm-5 control-label" for="form-field-1">
											Approx SQM Per Box
									</label>
								<div class="col-sm-6">
									<!--<input type="text" id="sqm_per_box" name="sqm_per_box" placeholder="" class="form-control" value="<?=$productsize_record->sqm_per_box?>" readonly />-->
									<input type="text" id="sqm_per_box" name="sqm_per_box" placeholder="" class="form-control" value="<?=number_format($productsize_record->sqm_per_box,2)?>"  readonly />
								 </div>    
						</div>	
					
						<div class="form-group">
							 	<label class="col-sm-5 control-label" for="form-field-1">
											Approx Feet Per Box
									</label>
								<div class="col-sm-6">
									<input type="text" id="feet_per_box" name="feet_per_box" placeholder="" class="form-control" value="<?=$productsize_record->feet_per_box?>" />
								 </div>    
						</div>						
								<div role="tabpanel">
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="<?=($mode=="Add")?"active":($productsize_record->boxes_per_pallet > 0)?"active":""?>" id="tab1" >
												<a href="#table-1" aria-controls="table-1" role="tab" data-toggle="tab">
													<label class="checkbox-inline">
														 With Pallet 
													</label>
												</a>
											</li>
											<li role="presentation" id="tab2" class="<?=($productsize_record->total_boxes>0)?"active":""?>" >
												<a href="#table-2" aria-controls="table-2" role="tab" data-toggle="tab">
													<label class="checkbox-inline">
														 Without Pallet
													</label>
												</a>
											</li>
											<li role="presentation"  id="tab1"  class="<?=($productsize_record->box_per_big_plt>0)?"active":""?>">
												<a href="#table-3" aria-controls="table-3" role="tab" data-toggle="tab">
													<label class="checkbox-inline">
														  Multi Pallet
													</label>
												</a>
											</li>
										</ul>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane <?=($mode=="Add")?"active":($productsize_record->boxes_per_pallet > 0)?"active":""?>" id="table-1">
												<div class="form-group">
														<label class="col-sm-5 control-label" for="form-field-1">
																Boxes Per Pallet 
														</label>
														<div class="col-sm-6">
															<input type="text" id="boxes_per_pallet" name="boxes_per_pallet" placeholder="" class="form-control"  value="<?=$productsize_record->boxes_per_pallet?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Pallet " />
														</div>    
													</div> 
												<div class="form-group">
														<label class="col-sm-5 control-label" for="form-field-1">
																Total Pallet In Container
														</label>
														<div class="col-sm-6">
															<input type="text" id="total_pallent_container" name="total_pallent_container" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$productsize_record->total_pallent_container?>" onkeypress="return isNumber(event)"  required title="Enter Total Pallet In Container"  />
														</div>    
													</div> 
												<div class="form-group">
														<label class="col-sm-5 control-label" for="form-field-1">
																Empty Pallet Weight
														</label>
														<div class="col-sm-4">
															<input type="text" id="pallet_weight" name="pallet_weight" placeholder="" class="form-control" value="<?=$productsize_record->pallet_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Pallet Weight" />
														</div>  
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Boxes Per Container
														</label>
													<div class="col-sm-6">
														<input type="text" id="box_per_container" name="box_per_container" class="form-control" readonly value="<?=$productsize_record->box_per_container?>"  />
													</div>    
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Gross Weight Per Container
														</label>
													<div class="col-sm-4">
													<input type="text" id="pallet_gross_weight_per_container" name="pallet_gross_weight_per_container" placeholder=" " class="form-control" readonly value="<?=$productsize_record->pallet_gross_weight_per_container?>"/>
													</div>   
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Net Weight Per Container 
														</label>
													<div class="col-sm-4">
													<input type="text" id="pallet_net_weight_per_container" name="pallet_net_weight_per_container" placeholder="" class="form-control" readonly value="<?=$productsize_record->pallet_net_weight_per_container?>" />
													</div>    
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																SQM Per Container
														</label>
													<div class="col-sm-6">
													<input type="text" id="sqm_per_container" name="sqm_per_container"  class="form-control" readonly value="<?=$productsize_record->sqm_per_container?>"  />
													 
													</div>    
												</div> 
				
											</div>
									  
										<div role="tabpanel" class="tab-pane <?=($productsize_record->total_boxes>0)?"active":""?>" id="table-2">
											<div class="boxes_calculation" >
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
															Total Boxes Per Container
													</label>
													<div class="col-sm-6">
														<input type="text" id="total_boxes" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$productsize_record->total_boxes?>"  required title="Enter Total Boxes Per Container" />
													</div>    
												</div> 
											</div>
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Gross Weight Per Container
														</label>
													<div class="col-sm-4">
														<input type="text" id="withoutgross_weight_per_container" name="withoutgross_weight_per_container" placeholder=" " class="form-control" readonly value="<?=$productsize_record->withoutgross_weight_per_container?>"/>
													</div>   
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Net Weight Per Container 
														</label>
													<div class="col-sm-4">
														<input type="text" id="withoutnet_weight_per_container" name="withoutnet_weight_per_container" placeholder="" class="form-control" readonly value="<?=$productsize_record->withoutnet_weight_per_container?>" />
													</div>    
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																SQM Per Container
														</label>
													<div class="col-sm-6">
														<input type="text" id="withoutpallet_sqm_per_container" name="withoutpallet_sqm_per_container"  class="form-control" readonly value="<?=$productsize_record->withoutpallet_sqm_per_container?>"  />
													</div>    
												</div> 
				
										</div>
										
											<div role="tabpanel" class="tab-pane <?=($productsize_record->box_per_big_plt>0)?"active":""?>"  id="table-3">
											    <div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
															Boxes Per Big Pallet
													</label>
													<div class="col-sm-6">
														<input type="text" id="box_per_big_plt" name="box_per_big_plt" placeholder="" class="form-control"  value="<?=$productsize_record->box_per_big_plt?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Big Pallet" />
													</div>    
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
															Boxes Per Small Pallet
													</label>
													<div class="col-sm-6">
														<input type="text" id="box_per_small_plt_new" name="box_per_small_plt_new" placeholder="" class="form-control"  value="<?=$productsize_record->box_per_small_plt_new?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Small Pallet" />
													</div>    
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
															Total Big Pallet In Container
													</label>
													<div class="col-sm-6">
														<input type="text" id="no_big_plt_container_new" name="no_big_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$productsize_record->no_big_plt_container_new?>" onkeypress="return isNumber(event)"  required title="Enter Total Big Pallet In Container"/>
													</div>    
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
															Total Small Pallet In Container
													</label>
													<div class="col-sm-6">
														<input type="text" id="no_small_plt_container_new" name="no_small_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$productsize_record->no_small_plt_container_new?>" onkeypress="return isNumber(event)" required title="Enter Total Small Pallet In Container" />
													</div>    
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
															Empty Big Pallet Weight
														</label>
													<div class="col-sm-4">
														<input type="text" id="big_plat_weight" name="big_plat_weight" placeholder="" class="form-control" value="<?=$productsize_record->big_plat_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"   title="Enter Big Pallet Weight"  />
													</div> 
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
															<strong>KG</strong>
														</div>
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
															Empty Small Pallet Weight
													</label>
												<div class="col-sm-4">
														<input type="text" id="small_plat_weight" name="small_plat_weight" placeholder="" class="form-control" value="<?=$productsize_record->small_plat_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"   title="Enter Small Pallet Weight"  />
												</div>    
													<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
														<strong>KG</strong>
													</div>
											</div> 
											<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Boxes Per Container
														</label>
													<div class="col-sm-6">
														<input type="text" id="multi_box_per_container" name="multi_box_per_container" class="form-control" readonly value="<?=$productsize_record->multi_box_per_container?>"  />
													</div>    
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Gross Weight Per Container
														</label>
													<div class="col-sm-4">
														<input type="text" id="multi_gross_weight_container" name="multi_gross_weight_container" placeholder=" " class="form-control" readonly value="<?=$productsize_record->multi_gross_weight_container?>"/>
													</div>   
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																Net Weight Per Container 
														</label>
													<div class="col-sm-4">
													<input type="text" id="multi_net_weight_container" name="multi_net_weight_container" placeholder="" class="form-control" readonly value="<?=$productsize_record->multi_net_weight_container?>" />
													</div>    
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
												</div> 
												<div class="form-group">
													<label class="col-sm-5 control-label" for="form-field-1">
																SQM Per Container
														</label>
													<div class="col-sm-6">
													<input type="text" id="multi_sqm_per_container" name="multi_sqm_per_container"  class="form-control" readonly value="<?=$productsize_record->multi_sqm_per_container?>"  />
													 
													</div>    
												</div> 
				
											</div>
										
										
										</div>
									</div>
				 </div>
								<div class="col-md-12"></div>
								<div class="col-md-12">
									<div class="col-md-offset-4">
										<input name="Submit" type="submit" value="Save" class="btn btn-success" /> 
										<a class="btn btn-danger" href="<?=($mode == "packing")?base_url().'product_packing_list/index/'.$product_data->product_id:base_url().'product_list'?>">Cancel</a> 
									</div>    
								</div> 	
								<input type="hidden" id="product_id" name="product_id" value="<?=($mode == "packing")?$product_data->product_id:$edit_record->product_id?>"/>				
								<input type="hidden" id="product_size_id" name="product_size_id" value="<?=$productsize_record->product_size_id?>"/>				
								<input type="hidden" id="mode" name="mode"  value="<?=$mode?>"  />				
							</form>
					
								</div>
							</div>
						</div>
			</div>
	</div>
	 
	</div>
</div> 
<?php $this->view('lib/footer');
$this->view('lib/addseries');  ?>

<script>
$(document).ready(function () {
	$('#sample-table-1').DataTable({
			"order": [[ 0, "asc" ]],
				"lengthMenu": [50, 10, 25, 75, 100]
	});
});
$(".select2").select2({
	width:'100%'
});
 function add_new_serices(value)
{
	 
	if(value==0) 
	{
		 $("#seriesmodal").modal({
						backdrop: 'static',
						keyboard: false
					});
	}
}
function allcalculation()
{
	var size_width_mmval = jQuery('input[name="size_width_mm"]').val();
    var size_height_mmval = jQuery('input[name="size_height_mm"]').val();
    var size_width_cmval = size_width_mmval / 10;
    var size_height_cmval = size_height_mmval / 10;
    var cross = "X";
    var mmval = "mm";
    var cmval = "cm";
    var bracket_start = " (";
    var bracket_end = ")";
    var size_type_mmval= size_width_mmval+cross+size_height_mmval+mmval; 
    var size_type_cmval= size_width_cmval+cross+size_height_cmval+cmval; 
	jQuery('input[name="size_width_cm"]').val(size_width_cmval);
    jQuery('input[name="size_height_cm"]').val(size_height_cmval);
    jQuery('input[name="size_type_mm"]').val(size_type_mmval);
    jQuery('input[name="size_type_cm"]').val(size_type_cmval);
	var pcs_per_box = ($('#pcs_per_box').val()>0)?$('#pcs_per_box').val():0;
	var weight_per_box = ($('#weight_per_box').val()>0)?$('#weight_per_box').val():0;
	//SQM
	var sqm_per_box = size_width_mmval * size_height_mmval * pcs_per_box/1000000;
    //$("#sqm_per_box").val(sqm_per_box);
	$("#sqm_per_box").val(sqm_per_box.toFixed(2));
   
	//Feet pr boxes
		var feet_per_box = sqm_per_box * 10.7639;
		$("#feet_per_box").val(feet_per_box.toFixed(4));

    //With Pallet
	var boxes_per_pallet = ($("#boxes_per_pallet").val()>0)?$("#boxes_per_pallet").val():0;
	var total_pallent_container = ($("#total_pallent_container").val()>0)?$("#total_pallent_container").val():0;
	var pallet_weight = ($("#pallet_weight").val()>0)?$("#pallet_weight").val():0;
	 
	var box_per_container = parseFloat(boxes_per_pallet) * parseFloat(total_pallent_container); 
	var pallet_net_weight_per_container = parseFloat(weight_per_box) * parseFloat(box_per_container); 
	var total_pallet_weight  = parseFloat(pallet_weight) * parseFloat(total_pallent_container); 
	var pallet_gross_weight_per_container = parseFloat(pallet_net_weight_per_container) + parseFloat(total_pallet_weight); 
	var sqm_per_container = parseFloat(sqm_per_box) *  parseFloat(box_per_container); 
	
	$("#box_per_container").val(box_per_container);
	$("#pallet_net_weight_per_container").val(pallet_net_weight_per_container.toFixed(2));
	$("#pallet_gross_weight_per_container").val(pallet_gross_weight_per_container.toFixed(2));
	$("#sqm_per_container").val(sqm_per_container.toFixed(2));
	
	//Without Pallet
	var total_boxes = ($("#total_boxes").val()>0)?$("#total_boxes").val():0;
	
	var withoutgross_weight_per_container = parseFloat(weight_per_box) * parseFloat(total_boxes);
	var withoutnet_weight_per_container = withoutgross_weight_per_container
	var withoutpallet_sqm_per_container = parseFloat(sqm_per_box) * parseFloat(total_boxes);
     
	$("#withoutnet_weight_per_container").val(withoutnet_weight_per_container.toFixed(2));
	$("#withoutgross_weight_per_container").val(withoutgross_weight_per_container.toFixed(2));
	$("#withoutpallet_sqm_per_container").val(withoutpallet_sqm_per_container.toFixed(2));
	
	// Mutiple Pallet 
	
	var box_per_big_plt = ($("#box_per_big_plt").val()>0)?$("#box_per_big_plt").val():0;
	var box_per_small_plt_new = ($("#box_per_small_plt_new").val()>0)?$("#box_per_small_plt_new").val():0;
	var no_big_plt_container_new = ($("#no_big_plt_container_new").val()>0)?$("#no_big_plt_container_new").val():0;
	var no_small_plt_container_new = ($("#no_small_plt_container_new").val()>0)?$("#no_small_plt_container_new").val():0;
	var big_plat_weight = ($("#big_plat_weight").val()>0)?$("#big_plat_weight").val():0;
	var small_plat_weight = ($("#small_plat_weight").val()>0)?$("#small_plat_weight").val():0;
	var big_box = box_per_big_plt * no_big_plt_container_new;
	var small_box = box_per_small_plt_new * no_small_plt_container_new;
	
	
	var total_big_pallet_contaier_weight = parseFloat(big_box) * parseFloat(weight_per_box);
	var total_small_pallet_contaier_weight = parseFloat(small_box) * parseFloat(weight_per_box);
	var multi_net_weight_container =  parseFloat(total_big_pallet_contaier_weight) + parseFloat(total_small_pallet_contaier_weight);
	
	var big_pallent_weight = parseFloat(big_plat_weight) * parseFloat(no_big_plt_container_new);
	var small_pallent_weight = parseFloat(small_plat_weight) * parseFloat(no_small_plt_container_new);
	 
	var multi_gross_weight_container = parseFloat(multi_net_weight_container) + parseFloat(big_pallent_weight) + parseFloat(small_pallent_weight);
	var multi_box_per_container = parseFloat(big_box) + parseFloat(small_box);
	var multi_sqm_per_container = multi_box_per_container * sqm_per_box;
	
	$("#multi_box_per_container").val(multi_box_per_container.toFixed(2));
	$("#multi_gross_weight_container").val(multi_gross_weight_container.toFixed(2));
	$("#multi_net_weight_container").val(multi_net_weight_container.toFixed(2));
	$("#multi_sqm_per_container").val(multi_sqm_per_container.toFixed(2));
	
	
}
$("#series_add").validate({
		rules: {
			series_name: {
				required: true
			}
		},
		messages: {
			series_name: {
				required: "Enter Product Name"
			}
		}
});
$("#series_add").submit(function(event) {
	event.preventDefault();
	if(!$("#series_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'series_list/manage',
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
				   $("#series_add").trigger('reset');
				   $("#seriesmodal").modal('hide');
				    unblock_page("success","Sucessfully Inserted.");
					$("#series_id").append("<option value='"+obj.id+"' selected>"+obj.series_name+"</option>");
					$("#series_id").val(obj.id).trigger("change");
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

$("#product_form").validate({
	 rules: {
	 	series_id: {
	 		required: true
	 	}
	 },
	 messages: {
	 	series_id: {
	 		required: "Select Product Name"
	 	}
	 }
});
$("#product_form").submit(function(event) {
	event.preventDefault();
	if(!$("#product_form").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url:  root+'product_list/manage',
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
				   $("#product_form").trigger('reset');
				   unblock_page("success","Sucessfully Inserted.");
					location.reload();
				}
				else if(obj.res==2)
			    {
				   $("#product_form").trigger('reset');
				   unblock_page("success","Sucessfully Updated.");
				   window.location = root+"product_list";
				}
				else if(obj.res==3)
			    {
				    
				   unblock_page("info","Already Added.");
				}
				else if(obj.res==4)
			    {
				   $("#product_form").trigger('reset');
				   unblock_page("success","Sucessfully Updated.");
					window.location = root+"product_packing_list/index/<?=$product_data->product_id?>";
				}
				else 
			    {
				   unblock_page("error","Something is wrong.");
				}
				 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});


 
</script>