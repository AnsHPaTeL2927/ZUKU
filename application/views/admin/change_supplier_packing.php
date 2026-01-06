<?php 
$this->view('lib/header'); 
 $thickness = (!empty($edit_record->thickness))?" - ".$edit_record->thickness." MM":"";
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
							<a href="<?=base_url().'add_supplier_product/index/'.$edit_record->supplier_id?>">Supplier Product List</a>
						</li>
						 
					</ol>
					<div class="page-header">
					<h3>
						<?=$edit_record->name?> Supplier Packing Detail
						 
					</h3>
					  
					</div>
				 
				</div>
			</div>
			<div class="row">
						<div class="col-sm-12">
							<div class="panel">
								 
							<div class="panel-body">
							<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="supplier_product_form" id="supplier_product_form">
               		
					 <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Product Detail
						</label>
						<div class="col-sm-4">
					 		<?=$edit_record->size_width_mm.'X'.$edit_record->size_height_mm.'mm ('.$edit_record->series.')'.$thickness?>
						</div>
						</div>
						<div class="form-group">
						 	<label class="col-sm-3 control-label" for="form-field-1">
						 		Pcs Per Box
						 	</label>
						 	<div class="col-sm-2">
						 	<input type="text" id="pcs_per_box" name="pcs_per_box" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$edit_record->pcs_per_box?>"   required title="Enter Pcs Per Box" />
						 	</div>    
						 </div> 
						 <div class="form-group">
						 	<label class="col-sm-3 control-label" for="form-field-1">
						 		Approx Weight Per Box 
						 	</label>
						 	<div class="col-sm-2">
						 		<input type="text" id="weight_per_box" name="weight_per_box" placeholder="" class="form-control"  onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$edit_record->weight_per_box?>"  required title="Enter Approx Weight Per Box" /> 
						 	</div>  
						 	<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
						 </div> 
						 <div class="form-group">
							  <label class="col-sm-3 control-label" for="form-field-1">
							 			Approx SQM Per Box
							 </label>
							  <div class="col-sm-2">
							 	<input type="text" id="sqm_per_box" name="sqm_per_box" placeholder="" class="form-control" value="<?=$edit_record->sqm_per_box?>" readonly />
							  </div>    
						</div>
						
						<div class="form-group">
								<div role="tabpanel">
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation" class="<?=($edit_record->boxes_per_pallet>0)?"active":""?>" id="tab1" >
											<a href="#table-1" aria-controls="table-1" role="tab" data-toggle="tab">
												<label class="checkbox-inline">
													With Pallet 
												</label>
											</a>
										</li>
										<li role="presentation" id="tab2" class="<?=($edit_record->total_boxes>0)?"active":""?>" >
											<a href="#table-2" aria-controls="table-2" role="tab" data-toggle="tab">
												<label class="checkbox-inline">
													Without Pallet
												</label>
											</a>
										</li>
										<li role="presentation"  id="tab1"  class="<?=($edit_record->box_per_big_plt>0)?"active":""?>">
											<a href="#table-3" aria-controls="table-3" role="tab" data-toggle="tab">
												<label class="checkbox-inline">
													Multi Pallet
												</label>
											</a>
										</li>
									</ul>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane <?=($edit_record->boxes_per_pallet>0)?"active":""?>" id="table-1">
								<div class="form-group">
										<label class="col-sm-3 control-label" for="form-field-1">
												Boxes Per Pallet 
										</label>
										<div class="col-sm-2">
											<input type="text" id="boxes_per_pallet" name="boxes_per_pallet" placeholder="" class="form-control"  value="<?=$edit_record->boxes_per_pallet?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Pallet " />
										</div>    
									</div> 
								<div class="form-group">
										<label class="col-sm-3 control-label" for="form-field-1">
												Total Pallet In Container
										</label>
										<div class="col-sm-2">
											<input type="text" id="total_pallent_container" name="total_pallent_container" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$edit_record->total_pallent_container?>" onkeypress="return isNumber(event)"  required title="Enter Total Pallet In Container"  />
										</div>    
									</div> 
								<div class="form-group">
										<label class="col-sm-3 control-label" for="form-field-1">
												Empty Pallet Weight
										</label>
										<div class="col-sm-2">
											<input type="text" id="pallet_weight" name="pallet_weight" placeholder="" class="form-control" value="<?=$edit_record->pallet_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Pallet Weight" />
										</div>  
										<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
									</div> 
								 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Boxes Per Container
										</label>
									<div class="col-sm-2">
										<input type="text" id="box_per_container" name="box_per_container" class="form-control" readonly value="<?=$edit_record->box_per_container?>"  />
									</div>    
								</div> 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Gross Weight Per Container
										</label>
									<div class="col-sm-2">
									<input type="text" id="pallet_gross_weight_per_container" name="pallet_gross_weight_per_container" placeholder=" " class="form-control" readonly value="<?=$edit_record->pallet_gross_weight_per_container?>"/>
									</div>   
										<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
									</div> 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Net Weight Per Container 
										</label>
									<div class="col-sm-2">
									<input type="text" id="pallet_net_weight_per_container" name="pallet_net_weight_per_container" placeholder="" class="form-control" readonly value="<?=$edit_record->pallet_net_weight_per_container?>" />
									</div>    
										<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
								</div> 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												SQM Per Container
										</label>
									<div class="col-sm-2">
									<input type="text" id="sqm_per_container" name="sqm_per_container"  class="form-control" readonly value="<?=$edit_record->sqm_per_container?>"  />
									 
									</div>    
								</div> 
							<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Feet Per Box
											</label>
											<div class="col-sm-2">
												<input type="text" id="feet_per_box" name="feet_per_box" placeholder="" class="form-control" value="<?=$edit_record->feet_per_box?>" readonly />
											
											</div>    
										</div>
							</div>
							 
							 <div role="tabpanel" class="tab-pane <?=($edit_record->total_boxes>0)?"active":""?>" id="table-2">
							 	<div class="boxes_calculation" >
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 					Total Boxes Per Container
							 			</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="total_boxes" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$edit_record->total_boxes?>"  required title="Enter Total Boxes Per Container" />
							 			</div>    
							 		</div> 
							 	</div>
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 						Gross Weight Per Container
							 				</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="withoutgross_weight_per_container" name="withoutgross_weight_per_container" placeholder=" " class="form-control" readonly value="<?=$edit_record->withoutgross_weight_per_container?>"/>
							 			</div>   
							 				<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 			</div> 
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 						Net Weight Per Container 
							 				</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="withoutnet_weight_per_container" name="withoutnet_weight_per_container" placeholder="" class="form-control" readonly value="<?=$edit_record->withoutnet_weight_per_container?>" />
							 			</div>    
							 				<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 		</div> 
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 						SQM Per Container
							 				</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="withoutpallet_sqm_per_container" name="withoutpallet_sqm_per_container"  class="form-control" readonly value="<?=$edit_record->withoutpallet_sqm_per_container?>"  />
							 			</div>    
							 		</div> 
									 <div class="form-group">
									 	<label class="col-sm-3 control-label" for="form-field-1">
									 		Feet Per Box
									 	</label>
									 	<div class="col-sm-2">
									 		<input type="text" id="without_feet_per_box" name="without_feet_per_box" placeholder="" class="form-control" value="<?=$edit_record->without_feet_per_box?>" readonly />
									 	
									 	</div>    
									 </div>
				             
							 </div>
							 
							 <div role="tabpanel" class="tab-pane <?=($edit_record->box_per_big_plt>0)?"active":""?>"  id="table-3">
							 		    <div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Boxes Per Big Pallet
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="box_per_big_plt" name="box_per_big_plt" placeholder="" class="form-control"  value="<?=$edit_record->box_per_big_plt?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Big Pallet" />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Boxes Per Small Pallet
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="box_per_small_plt_new" name="box_per_small_plt_new" placeholder="" class="form-control"  value="<?=$edit_record->box_per_small_plt_new?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Small Pallet" />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Total Big Pallet In Container
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="no_big_plt_container_new" name="no_big_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$edit_record->no_big_plt_container_new?>" onkeypress="return isNumber(event)"  required title="Enter Total Big Pallet In Container"/>
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Total Small Pallet In Container
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="no_small_plt_container_new" name="no_small_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$edit_record->no_small_plt_container_new?>" onkeypress="return isNumber(event)" required title="Enter Total Small Pallet In Container" />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							Big Pallet Weight
							 					</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="big_plat_weight" name="big_plat_weight" placeholder="" class="form-control" value="<?=$edit_record->big_plat_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"   title="Enter Big Pallet Weight"  />
							 				</div> 
							 					<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
							 						<strong>KG</strong>
							 					</div>
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Small Pallet Weight
							 				</label>
							 			<div class="col-sm-2">
							 					<input type="text" id="small_plat_weight" name="small_plat_weight" placeholder="" class="form-control" value="<?=$edit_record->small_plat_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"   title="Enter Small Pallet Weight"  />
							 			</div>    
							 				<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
							 					<strong>KG</strong>
							 				</div>
							 		</div> 
							 		<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							Boxes Per Container
							 					</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="multi_box_per_container" name="multi_box_per_container" class="form-control" readonly value="<?=$edit_record->multi_box_per_container?>"  />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							Gross Weight Per Container
							 					</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="multi_gross_weight_container" name="multi_gross_weight_container" placeholder=" " class="form-control" readonly value="<?=$edit_record->multi_gross_weight_container?>"/>
							 				</div>   
							 					<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 				</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							Net Weight Per Container 
							 					</label>
							 				<div class="col-sm-2">
							 				<input type="text" id="multi_net_weight_container" name="multi_net_weight_container" placeholder="" class="form-control" readonly value="<?=$edit_record->multi_net_weight_container?>" />
							 				</div>    
							 					<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							SQM Per Container
							 					</label>
							 				<div class="col-sm-2">
							 				<input type="text" id="multi_sqm_per_container" name="multi_sqm_per_container"  class="form-control" readonly value="<?=$edit_record->multi_sqm_per_container?>"  />
							 				 
							 				</div>    
							 			</div> 
										<div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												Feet Per Box
											</label>
											<div class="col-sm-2">
												<input type="text" id="multi_feet_per_box" name="multi_feet_per_box" placeholder="" class="form-control" value="<?=$edit_record->multi_feet_per_box?>" readonly />
											
											</div>    
										</div> 
							 		</div>
							 	
							 	
							 	</div>
							 </div>
						</div>    
				 	
				 	  <div class="form-group">
						<input name="Submit" type="submit" value="Submit" class="btn btn-success" /> 
							<a href="<?=base_url().'add_supplier_product/index/'.$edit_record->supplier_id?>" class="btn btn-danger">
											Cancel
										</a>	
					</div>    
				 	
					<input type="hidden" id="product_size_id" name="product_size_id" value="<?=$edit_record->product_size_id?>"/>				
					<input type="hidden" id="size_width_mm" name="size_width_mm" value="<?=$edit_record->size_width_mm?>"/><input type="hidden" id="size_height_mm" name="size_height_mm" value="<?=$edit_record->size_height_mm?>"/>				
					<input type="hidden" id="size_width_cmval" name="size_width_cmval" value="<?=$edit_record->size_width_cm?>"/><input type="hidden" id="size_height_cmval" name="size_height_cmval" value="<?=$edit_record->size_height_cm?>"/>				
					<input type="hidden" id="supplier_product_id" name="supplier_product_id" value="<?=$edit_record->supplier_product_id?>"/>				
					<input type="hidden" id="appsqmperbox_new_cm" name="appsqmperbox_new_cm" value="<?=$edit_record->appsqmperbox_new_cm?>"/>				
					<input type="hidden" id="series_id" name="series_id" value="<?=$edit_record->series_id?>"/>				
					<input type="hidden" id="rate" name="rate" value="<?=$edit_record->rate?>"/>				
					<input type="hidden" id="price_type" name="price_type" value="<?=$edit_record->price_type?>"/>				
					<input type="hidden" id="total_price" name="total_price" value="<?=$edit_record->total_price?>"/>				
					<input type="hidden" id="usd_per_box" name="usd_per_box" value="<?=$edit_record->usd_per_box?>"/>				
					<input type="hidden" id="pallet_charges" name="pallet_charges" value="<?=$edit_record->pallet_charges?>"/>				
					<input type="hidden" id="fob_expenenses" name="fob_expenenses" value="<?=$edit_record->fob_expenenses?>"/>				
					<input type="hidden" id="our_selling_price" name="our_selling_price" value="<?=$edit_record->our_selling_price?>"/>				
					<input type="hidden" id="profit_price" name="profit_price" value="<?=$edit_record->profit_price?>"/>				
					<input type="hidden" id="mode" name="mode"    value="<?=$mode?>"  />				
				</form>
					
							 	</div>
							</div>
						</div>
			</div>
	</div>
	 
	</div>
</div> 
<?php $this->view('lib/footer'); ?>
 <script>
$("#supplier_product_form").validate({
		rules: {
			size_width_mm: {
				required: true
			} 
		},
		messages: {
			size_width_mm: {
				required: "Enter Size Width IN MM"
			} 
		}
	});
$("#supplier_product_form").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_product_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'add_supplier_product/editproduct',
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
				    $("#supplier_product_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'add_supplier_product/change_packing/'+$("#supplier_product_id").val(); },1500);
			   }
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){  window.location=root+'add_supplier_product/change_packing/'+$("#supplier_product_id").val();  },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

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
	$("#sqm_per_box").val(sqm_per_box);
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
	var feet_per_box = sqm_per_box * 10.7639;
    $("#multi_feet_per_box").val(feet_per_box.toFixed(3));
   $("#feet_per_box").val(feet_per_box.toFixed(3));
  $("#without_feet_per_box").val(feet_per_box.toFixed(3));
}

</script>
