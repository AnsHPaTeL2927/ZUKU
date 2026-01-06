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
							<a href="<?=base_url().'add_supplier_product/index/'.$all_record[0]->supplier_id?>">Supplier Product List</a>
						</li>
						 
					</ol>
					<div class="page-header">
					<h3>
						 Quotation Factory Name : <?=$all_record[0]->company_name?>  
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
												Person Name
										</label>
										<div class="col-sm-4">
											<input type="text" id="person_name" name="person_name" placeholder="Person Name" class="form-control"  value=""  required title="Enter Person Name" />
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Quotation Terms & Condition
										</label>
										<div class="col-sm-4">
											<textarea id="quotation_terms" name="quotation_terms"   class="form-control" placeholder="Quotation Terms & Condition:-"><?=strip_tags(@$company_detail[0]->quotation_terms)?></textarea>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Terms of Delivery
										</label>
									<div class="col-sm-2">
														<select name="terms_id" id="terms_id" class="form-control">
															<?php 
															foreach($termsdata as $terms)
															{
																$sel ='';
																
																if($terms->terms_id == $terms_id)
																{
																	$sel = 'selected="selected"';
																}
																echo "<option ".$sel."  value='".$terms->terms_id."'>".$terms->terms_name."</option>";
															} ?>
														</select>
														
									</div>
									<div class="col-sm-2">
										<input type="text" placeholder="Terms of Delivery " style="font-weight:bold;" id="terms_of_delivery"  class="form-control" name="terms_of_delivery" value="<?=($company_detail[0]->terms_of_delivery)?>" >
									</div>
									</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
										Pallet Packing Name
								</label>
								<div class="col-sm-2">
									<input type="text" id="packing_name" name="packing_name" placeholder="Pallet Packing Name" class="form-control"    value=""   required title="Enter Pallet Packing name" />
								</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
										Select Currecy 
								</label>
								<div class="col-sm-2">
									<select class="select2" name="invoice_currency_id" id="invoice_currency_id" required title="Select Currency" onchange="get_exchange_rate(this.value)">
												<option value="">Select Currency</option>	
													<?php
													$currency_code = '';
													for($currency=0;$currency<count($currencydata);$currency++)
													{
														$select = '';
														if($currencydata[$currency]->currency_id==@$invoicedata->invoice_currency_id)
														{
															$select = 'selected="selected"'; 
														}
														else if($currencydata[$currency]->currency_status == 1)
														{
															$select = 'selected="selected"'; 
															$currency_code = $currencydata[$currency]->currency_code;
														}
													?>
														<option <?=$select?> value="<?=$currencydata[$currency]->currency_code?>"><?=$currencydata[$currency]->currency_name?></option>	
													<?php
													}
													?>
											</select>
								</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
										Exchange rate
								</label>
								<div class="col-sm-2">
									<input type="text" id="exchange_rate" name="exchange_rate" placeholder="Exchange Rate" class="form-control" onkeypress="return isNumber(event)"  onkeyup="all_product_calculation()" onblur="all_product_calculation()" value=""   required title="Enter Exchange rate" />
								</div>
						</div>
               		<div role="tabpanel">
						<ul class="nav nav-tabs" role="tablist">
							<?php
							$no=0;							
							foreach($all_record as $packing_row)
							{
							?>
							<li role="presentation" class="<?=($no==0)?"active":""?>" id="maintab<?=$packing_row->product_size_id?>" >
										<a href="#maintable-<?=$packing_row->product_size_id?>" aria-controls="maintable-<?=$packing_row->product_size_id?>" role="tab" data-toggle="tab">
											<label class="checkbox-inline">
												<strong><?=$packing_row->series_name?> 
												<br>
												<br>
												(<?=$packing_row->product_packing_name?>)</strong>
											</label>
										</a>
							</li>
							<?php
							$no++;	
							}
							?>
						</ul>
						<div class="tab-content">
						<?php 
						$no=0;
							foreach($all_record as $packing_row)
							{
								$fob_expenenses = ($packing_row->fob_expenenses > 0)?:$maindetail->fob_charges;
								$big_pallet_charges = ($packing_row->big_pallet_charges > 0)?:$maindetail->big_pallet_charge;
								$small_pallet_charges = ($packing_row->small_pallet_charges > 0)?:$maindetail->small_pallet_charges;
								$pallet_charges = ($packing_row->pallet_charges > 0)?:$maindetail->pallet_charges;
							?>
							<div role="tabpanel" class="tab-pane <?=($no==0)?"active":""?>" id="maintable-<?=$packing_row->product_size_id?>">
							<input type="hidden" id="product_size_id<?=$packing_row->product_size_id?>" name="product_size_id[]" value="<?=$packing_row->product_size_id?>"/>				
							<input type="hidden" id="product_id<?=$packing_row->product_size_id?>" name="product_id[]" value="<?=$packing_row->product_id?>"/>				
						<input type="hidden" id="size_width_mm<?=$packing_row->product_size_id?>" name="size_width_mm" value="<?=$packing_row->size_width_mm?>"/>
						<input type="hidden" id="size_height_mm<?=$packing_row->product_size_id?>" name="size_height_mm" value="<?=$packing_row->size_height_mm?>"/>				
							 	
							 
						<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Product Size
						</label>
						<div class="col-sm-6">
					 		<strong><?=$packing_row->size_type_mm.$thickness?></strong>
						</div>
						</div>
						 
						<div class="form-group">
						 	<label class="col-sm-3 control-label" for="form-field-1">
						 		Pcs Per Box
						 	</label>
						 	<div class="col-sm-2">
						 	<input type="text" id="pcs_per_box<?=$packing_row->product_size_id?>" name="pcs_per_box[]" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" value="<?=$packing_row->pcs_per_box?>"   required title="Enter Pcs Per Box" />
						 	</div>    
						 </div> 
						 <div class="form-group">
						 	<label class="col-sm-3 control-label" for="form-field-1">
						 		Approx Weight Per Box 
						 	</label>
						 	<div class="col-sm-2">
						 		<input type="text" id="weight_per_box<?=$packing_row->product_size_id?>" name="weight_per_box[]" placeholder="" class="form-control"  onkeypress="return isNumber(event)"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" value="<?=$packing_row->weight_per_box?>"  required title="Enter Approx Weight Per Box" /> 
						 	</div>  
						 	<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
						 </div> 
						 <div class="form-group">
							  <label class="col-sm-3 control-label" for="form-field-1">
							 			Approx SQM Per Box
							 </label>
							  <div class="col-sm-2">
							 	<input type="text" id="sqm_per_box<?=$packing_row->product_size_id?>" name="sqm_per_box[]" placeholder="" class="form-control" value="<?=$packing_row->sqm_per_box?>" readonly />
							  </div>    
						</div>
						<div class="form-group">
							  <label class="col-sm-3 control-label" for="form-field-1">
							 			Approx Feet Per Box
							 </label>
							  <div class="col-sm-2">
							 	<input type="text" id="feet_per_box<?=$packing_row->product_size_id?>" name="feet_per_box[]" placeholder="" class="form-control" value="<?=$packing_row->feet_per_box?>"  />
							  </div>    
						</div>
					   <div class="form-group col-md-12">
								<div role="tabpanel">
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation" class="<?=($packing_row->boxes_per_pallet>0)?"active":""?>" id="tab1<?=$packing_row->product_size_id?>" >
											<a href="#table-1" aria-controls="table-1" role="tab" data-toggle="tab">
												<label class="checkbox-inline">
													With Pallet 
												</label>
											</a>
										</li>
										<li role="presentation" id="tab2<?=$packing_row->product_size_id?>" class="<?=($packing_row->total_boxes>0)?"active":""?>" >
											<a href="#table-2" aria-controls="table-2" role="tab" data-toggle="tab">
												<label class="checkbox-inline">
													Without Pallet
												</label>
											</a>
										</li>
										<li role="presentation"  id="tab3<?=$packing_row->product_size_id?>"  class="<?=($packing_row->box_per_big_plt>0)?"active":""?>">
											<a href="#table-3" aria-controls="table-3" role="tab" data-toggle="tab">
												<label class="checkbox-inline">
													Multi Pallet
												</label>
											</a>
										</li>
									</ul>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane <?=($packing_row->boxes_per_pallet>0)?"active":""?>" id="table-1">
								<div class="form-group">
										<label class="col-sm-3 control-label" for="form-field-1">
												Boxes Per Pallet 
										</label>
										<div class="col-sm-2">
											<input type="text" id="boxes_per_pallet<?=$packing_row->product_size_id?>" name="boxes_per_pallet[]" placeholder="" class="form-control"  value="<?=$packing_row->boxes_per_pallet?>"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" onkeypress="return isNumber(event)" required title="Enter Boxes Per Pallet " />
										</div>    
									</div> 
								<div class="form-group">
										<label class="col-sm-3 control-label" for="form-field-1">
												Total Pallet In Container
										</label>
										<div class="col-sm-2">
											<input type="text" id="total_pallent_container<?=$packing_row->product_size_id?>" name="total_pallent_container[]" placeholder="" class="form-control"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)"  value="<?=$packing_row->total_pallent_container?>" onkeypress="return isNumber(event)"  required title="Enter Total Pallet In Container"  />
										</div>    
									</div> 
								<div class="form-group">
										<label class="col-sm-3 control-label" for="form-field-1">
												Empty Pallet Weight
										</label>
										<div class="col-sm-2">
											<input type="text" id="pallet_weight<?=$packing_row->product_size_id?>" name="pallet_weight[]" placeholder="" class="form-control" value="<?=$packing_row->pallet_weight?>"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" onkeypress="return isNumber(event)" required title="Enter Pallet Weight" />
										</div>  
										<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
									</div> 
								 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Boxes Per Container
										</label>
									<div class="col-sm-2">
										<input type="text" id="box_per_container<?=$packing_row->product_size_id?>" name="box_per_container[]" class="form-control" readonly value="<?=$packing_row->box_per_container?>"  />
									</div>    
								</div> 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Gross Weight Per Container
										</label>
									<div class="col-sm-2">
									<input type="text" id="pallet_gross_weight_per_container<?=$packing_row->product_size_id?>" name="pallet_gross_weight_per_container[]" placeholder=" " class="form-control" readonly value="<?=$packing_row->pallet_gross_weight_per_container?>"/>
									</div>   
										<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
									</div> 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												Net Weight Per Container 
										</label>
									<div class="col-sm-2">
									<input type="text" id="pallet_net_weight_per_container<?=$packing_row->product_size_id?>" name="pallet_net_weight_per_container[]" placeholder="" class="form-control" readonly value="<?=$packing_row->pallet_net_weight_per_container?>" />
									</div>    
										<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
								</div> 
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
												SQM Per Container
										</label>
									<div class="col-sm-2">
									<input type="text" id="sqm_per_container<?=$packing_row->product_size_id?>" name="sqm_per_container[]"  class="form-control" readonly value="<?=$packing_row->sqm_per_container?>"  />
									 
									</div>    
								</div> 
							 
										  <div class="form-group">
											<label class="col-sm-3 control-label" for="form-field-1">
												 Palate charge
											</label>
											<div class="col-sm-2">
												<input type="text" name="pallet_charges[]" id="pallet_charges<?=$packing_row->product_size_id?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="price_calaculation(<?=$packing_row->product_size_id?>)" value="<?=$pallet_charges?>" />
											</div>    
										</div>  
							</div>
							 
							 <div role="tabpanel" class="tab-pane <?=($packing_row->total_boxes>0)?"active":""?>" id="table-2">
							 	<div class="boxes_calculation" >
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 					Total Boxes Per Container
							 			</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="total_boxes<?=$packing_row->product_size_id?>" name="total_boxes[]" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" value="<?=$packing_row->total_boxes?>"  required title="Enter Total Boxes Per Container" />
							 			</div>    
							 		</div> 
							 	</div>
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 						Gross Weight Per Container
							 				</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="withoutgross_weight_per_container<?=$packing_row->product_size_id?>" name="withoutgross_weight_per_container[]" placeholder=" " class="form-control" readonly value="<?=$packing_row->withoutgross_weight_per_container?>"/>
							 			</div>   
							 				<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 			</div> 
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 						Net Weight Per Container 
							 				</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="withoutnet_weight_per_container<?=$packing_row->product_size_id?>" name="withoutnet_weight_per_container[]" placeholder="" class="form-control" readonly value="<?=$packing_row->withoutnet_weight_per_container?>" />
							 			</div>    
							 				<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 		</div> 
							 		<div class="form-group">
							 			<label class="col-sm-3 control-label" for="form-field-1">
							 						SQM Per Container
							 				</label>
							 			<div class="col-sm-2">
							 				<input type="text" id="withoutpallet_sqm_per_container<?=$packing_row->product_size_id?>" name="withoutpallet_sqm_per_container[]"  class="form-control" readonly value="<?=$packing_row->withoutpallet_sqm_per_container?>"  />
							 			</div>    
							 		</div> 
									 
				             
							 </div>
							 
							 <div role="tabpanel" class="tab-pane <?=($packing_row->box_per_big_plt>0)?"active":""?>"  id="table-3">
							 		    <div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Boxes Per Big Pallet
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="box_per_big_pallet<?=$packing_row->product_size_id?>" name="box_per_big_pallet[]" placeholder="" class="form-control"  value="<?=$packing_row->box_per_big_plt?>"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" onkeypress="return isNumber(event)" required title="Enter Boxes Per Big Pallet" />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Boxes Per Small Pallet
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="box_per_small_pallet<?=$packing_row->product_size_id?>" name="box_per_small_pallet[]" placeholder="" class="form-control"  value="<?=$packing_row->box_per_small_plt_new?>"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" onkeypress="return isNumber(event)" required title="Enter Boxes Per Small Pallet" />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Total Big Pallet In Container
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="big_pallet_container<?=$packing_row->product_size_id?>" name="big_pallet_container[]" placeholder="" class="form-control"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)"  value="<?=$packing_row->no_big_plt_container_new?>" onkeypress="return isNumber(event)"  required title="Enter Total Big Pallet In Container"/>
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Total Small Pallet In Container
							 				</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="small_pallet_container<?=$packing_row->product_size_id?>" name="small_pallet_container[]" placeholder="" class="form-control"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)"  value="<?=$packing_row->no_small_plt_container_new?>" onkeypress="return isNumber(event)" required title="Enter Total Small Pallet In Container" />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							Empty Big Pallet Weight
							 					</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="big_pallet_weight<?=$packing_row->product_size_id?>" name="big_pallet_weight[]" placeholder="" class="form-control" value="<?=$packing_row->big_plat_weight?>"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" onkeypress="return isNumber(event)"   title="Enter Big Pallet Weight"  />
							 				</div> 
							 					<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
							 						<strong>KG</strong>
							 					</div>
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 						Empty Small Pallet Weight
							 				</label>
							 			<div class="col-sm-2">
							 					<input type="text" id="small_pallent_weight<?=$packing_row->product_size_id?>" name="small_pallent_weight[]" placeholder="" class="form-control" value="<?=$packing_row->small_plat_weight?>"  onkeyup="allcalculation(<?=$packing_row->product_size_id?>)" onkeypress="return isNumber(event)"   title="Enter Small Pallet Weight"  />
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
							 					<input type="text" id="multi_box_per_container<?=$packing_row->product_size_id?>" name="multi_box_per_container[]" class="form-control" readonly value="<?=$packing_row->multi_box_per_container?>"  />
							 				</div>    
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							Gross Weight Per Container
							 					</label>
							 				<div class="col-sm-2">
							 					<input type="text" id="multi_gross_weight_container<?=$packing_row->product_size_id?>" name="multi_gross_weight_container[]" placeholder=" " class="form-control" readonly value="<?=$packing_row->multi_gross_weight_container?>"/>
							 				</div>   
							 					<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 				</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							Net Weight Per Container 
							 					</label>
							 				<div class="col-sm-2">
							 				<input type="text" id="multi_net_weight_container<?=$packing_row->product_size_id?>" name="multi_net_weight_container[]" placeholder="" class="form-control" readonly value="<?=$packing_row->multi_net_weight_container?>" />
							 				</div>    
							 					<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
							 			</div> 
							 			<div class="form-group">
							 				<label class="col-sm-3 control-label" for="form-field-1">
							 							SQM Per Container
							 					</label>
							 				<div class="col-sm-2">
							 				<input type="text" id="multi_sqm_per_container<?=$packing_row->product_size_id?>" name="multi_sqm_per_container[]"  class="form-control" readonly value="<?=$packing_row->multi_sqm_per_container?>"  />
							 				 
							 				</div>    
							 			</div> 
										 
										 
				  <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
							Big Palate charge
						</label>
				        <div class="col-sm-2">
							<input type="text" name="big_pallet_charges[]" id="big_pallet_charges<?=$packing_row->product_size_id?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="price_calaculation(<?=$packing_row->product_size_id?>)" value="<?=$big_pallet_charges?>" />
				        </div>    
				    </div>  
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Small Palate charge
						</label>
				        <div class="col-sm-2">
							<input type="text" name="small_pallet_charges[]" id="small_pallet_charges<?=$packing_row->product_size_id?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="price_calaculation(<?=$packing_row->product_size_id?>)" value="<?=$small_pallet_charges?>" />
				        </div>    
				    </div>  
				 </div>
							 	
							 	
							 	</div>
							 </div>
						</div> 
						<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Factory Price 
						</label>
				        <div class="col-sm-2">
							<input type="text" name="facory_rate[]" id="facory_rate<?=$packing_row->product_size_id?>" class="form-control" onkeypress="return isNumber(event)" value="<?=!empty($packing_row->rate)?$packing_row->rate:$packing_row->design_rate?>" onkeyup="price_calaculation(<?=$packing_row->product_size_id?>)" />
				        </div>    
				    </div>  
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Factory Price per 
						</label>
				        <div class="col-sm-2">
							<select class="form-control" name="price_type[]" id="price_type<?=$packing_row->product_size_id?>" onchange="price_calaculation(<?=$packing_row->product_size_id?>)" required title="Select Price Per">
								<option value="">Select Price per</option>
								<?php
								$select ='';
								$select1 ='';
								$select2 ='';
								$select3 ='';
								if(!empty($packing_row->price_type))
								{
									if($packing_row->price_type=="Feet")
									{
										$select = 'selected="selected"';
									}
									else if($packing_row->price_type=="Box")
									{
										$select1 = 'selected="selected"';
									}
									else if($packing_row->price_type=="SQM")
									{
										$select2 = 'selected="selected"';
									}
									else if($packing_row->price_type=="PCS")
									{
										$select3 = 'selected="selected"';
									}
								}
								else
								{
									if($packing_row->product_rate_per=="Feet")
									{
										$select = 'selected="selected"';
									}
									else if($packing_row->product_rate_per=="Box")
									{
										$select1 = 'selected="selected"';
									}
									else if($packing_row->product_rate_per=="SQM")
									{
										$select2 = 'selected="selected"';
									}
									else if($packing_row->product_rate_per=="PCS")
									{
										$select3 = 'selected="selected"';
									}
								}
								?>
								<option <?=$select?> value="Feet">Feet</option>
								<option <?=$select1?> value="Box">Box</option>
								<option <?=$select2?> value="SQM">SQM</option>
								<option <?=$select3?> value="PCS">PCS</option>
								</select>
				        </div>    
				    </div>
				  						
						<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								FOB Exp
						</label>
				        <div class="col-sm-2">
							<input type="text" name="fob_expenenses[]" id="fob_expenenses<?=$packing_row->product_size_id?>" class="form-control" onkeypress="return isNumber(event)"  onkeyup="price_calaculation(<?=$packing_row->product_size_id?>)" value="<?=$fob_expenenses?>" />
				        </div>    
				    </div>						
				 	 <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Total Price 
						</label>
				        <div class="col-sm-2">
						<span id="total_price_html<?=$packing_row->product_size_id?>"><?=$packing_row->total_price?></span>
							<input type="hidden" name="total_price[]" id="total_price<?=$packing_row->product_size_id?>"  value="<?=$packing_row->total_price?>" />
				        </div>    
				    </div> 
						<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Calculate Price Per In <span class="currency_code"></span>
						</label>
				        <div class="col-sm-2">
								<select class="form-control" name="our_price_type[]" id="our_price_type<?=$packing_row->product_size_id?>" onchange="our_price_calaculation(<?=$packing_row->product_size_id?>)" required title="Select Price Per">
							 	<?php
								$select ='';
								$select1 ='';
								$select2 ='';
								$select3 ='';
								if($packing_row->our_price_type=="Feet")
								{
									$select = 'selected="selected"';
								}
								else if($packing_row->our_price_type=="Box")
								{
									$select1 = 'selected="selected"';
								}
								else if($packing_row->our_price_type=="SQM")
								{
									$select2 = 'selected="selected"';
								}
								else if($packing_row->our_price_type=="PCS")
								{
									$select3 = 'selected="selected"';
								}
								?>
								<option <?=$select2?> value="SQM">SQM</option>
								<option <?=$select?> value="Feet">Feet</option>
								<option <?=$select1?> value="Box">Box</option>
								<option <?=$select3?> value="PCS">PCS</option>
								</select>
				        </div>    
				    </div>
				 
				   <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								In <span class="currency_code"></span> Per Box  
						</label>
				        <div class="col-sm-2">
						<span id="usd_per_box_html<?=$packing_row->product_size_id?>"><?=$packing_row->usd_per_box?></span>
							<input type="hidden" name="per_box_price[]" id="per_box_price<?=$packing_row->product_size_id?>"  value="<?=$packing_row->usd_per_box?>" />
				        </div>    
				    </div> 
				  <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Our Price In <span class="currency_code"></span>
						</label>
				        <div class="col-sm-2">
							<input type="text" name="our_selling_price[]" id="our_selling_price<?=$packing_row->product_size_id?>" class="form-control" onkeypress="return isNumber(event)" onkeyup="our_price_calaculation(<?=$packing_row->product_size_id?>)" value="<?=$packing_row->our_selling_price?>" />
				        </div>    
				    </div>  
					  
				   <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Profit Price
						</label>
				        <div class="col-sm-2">
							<span id="profit_price_html<?=$packing_row->product_size_id?>"><?=$packing_row->profit_price?></span>
							<input type="hidden" name="profit_price[]" id="profit_price<?=$packing_row->product_size_id?>"  value="<?=$packing_row->profit_price?>" />
				        </div>    
				    </div>  					
						</div>
					<?php 
					$no++;
							}
							?>
					
					</div>
				  </div>
					<div class="col-md-offset-4" style="margin-top:20px;">
				    <div class="form-group">
						<input name="Submit" type="submit" value="Download Quotation" class="btn btn-info" /> 
							<a href="<?=base_url().'add_supplier_product/index/'.$all_record[0]->supplier_id?>" class="btn btn-danger">
								Cancel
							</a>	
					</div>
					
				</div> 	
					
					 
						
					<input type="hidden" id="supplier_id" name="supplier_id" value="<?=$all_record[0]->supplier_id?>"  />				
					<input type="hidden" id="supplier_product_id" name="supplier_product_id" value="<?=$all_record[0]->supplier_product_id?>"  />				
					<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />				
				</form>
					
							 	</div>
							</div>
						</div>
			</div>
	</div>
	 
	</div>
</div> 
<?php $this->view('lib/footer');

$this->view('lib/addseries'); 
 ?>
 <script>

 function get_exchange_rate(code)
 { 
  block_page();
	$.getJSON("https://api.exchangerate-api.com/v4/latest/"+code, function(e) {
		$(".currency_code").html(code);
		$("#exchange_rate").val(e.rates.INR);
		all_product_calculation();
		unblock_page("","");
	});
 }
 function all_product_calculation()
 {
	 	 $('input[name="product_size_id[]"]').each(function() {
			 allcalculation($(this).val());
		 });
 }
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
	if(parseFloat($("#profit_price").val())<0)
	{
		$("#our_selling_price").focus();
		toastr["error"]("Profit Price Not Allowed");
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
                
			    var obj= responseData.split('"')
				$(".loader").hide();
			  
				    $("#supplier_product_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					window.open(root+"upload/quotation/"+obj.pop(), '_blank');
					setTimeout(function(){ location.reload(); },1500);
			   
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
$(".select2").select2({
	width:'100%',
	 formatNoMatches: function(term) {
		return "<a href='javascript:;' onclick='add_new_serices(0)'>Add New Consigner</a>";
	}
})
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
function allcalculation(product_size_id)
{
	var size_width_mmval = jQuery('#size_width_mm'+product_size_id).val();
    var size_height_mmval = jQuery('#size_height_mm'+product_size_id).val();
    var size_width_cmval = size_width_mmval / 10;
    var size_height_cmval = size_height_mmval / 10;
    var cross = "X";
    var mmval = "mm";
    var cmval = "cm";
    var bracket_start = " (";
    var bracket_end = ")";
    var size_type_mmval= size_width_mmval+cross+size_height_mmval+mmval; 
    var size_type_cmval= size_width_cmval+cross+size_height_cmval+cmval; 
	 
	var pcs_per_box = ($('#pcs_per_box'+product_size_id).val()>0)?$('#pcs_per_box'+product_size_id).val():0;
	var weight_per_box = ($('#weight_per_box'+product_size_id).val()>0)?$('#weight_per_box'+product_size_id).val():0;
	 
	//SQM
	var sqm_per_box = size_width_mmval * size_height_mmval * pcs_per_box/1000000;
	$("#sqm_per_box"+product_size_id).val(sqm_per_box);
    //With Pallet
	var boxes_per_pallet = ($("#boxes_per_pallet"+product_size_id).val()>0)?$("#boxes_per_pallet"+product_size_id).val():0;
	var total_pallent_container = ($("#total_pallent_container"+product_size_id).val()>0)?$("#total_pallent_container"+product_size_id).val():0;
	var pallet_weight = ($("#pallet_weight"+product_size_id).val()>0)?$("#pallet_weight"+product_size_id).val():0;
	 
	var box_per_container = parseFloat(boxes_per_pallet) * parseFloat(total_pallent_container); 
	var pallet_net_weight_per_container = parseFloat(weight_per_box) * parseFloat(box_per_container); 
	var total_pallet_weight  = parseFloat(pallet_weight) * parseFloat(total_pallent_container); 
	var pallet_gross_weight_per_container = parseFloat(pallet_net_weight_per_container) + parseFloat(total_pallet_weight); 
	var sqm_per_container = parseFloat(sqm_per_box) *  parseFloat(box_per_container); 
	
	$("#box_per_container"+product_size_id).val(box_per_container);
	$("#pallet_net_weight_per_container"+product_size_id).val(pallet_net_weight_per_container.toFixed(2));
	$("#pallet_gross_weight_per_container"+product_size_id).val(pallet_gross_weight_per_container.toFixed(2));
	$("#sqm_per_container"+product_size_id).val(sqm_per_container.toFixed(2));
	
	//Without Pallet
	var total_boxes = ($("#total_boxes"+product_size_id).val()>0)?$("#total_boxes"+product_size_id).val():0;
	
	var withoutgross_weight_per_container = parseFloat(weight_per_box) * parseFloat(total_boxes);
	var withoutnet_weight_per_container = withoutgross_weight_per_container
	var withoutpallet_sqm_per_container = parseFloat(sqm_per_box) * parseFloat(total_boxes);
     
	$("#withoutnet_weight_per_container"+product_size_id).val(withoutnet_weight_per_container.toFixed(2));
	$("#withoutgross_weight_per_container"+product_size_id).val(withoutgross_weight_per_container.toFixed(2));
	$("#withoutpallet_sqm_per_container"+product_size_id).val(withoutpallet_sqm_per_container.toFixed(2));
	
	// Mutiple Pallet 
	
	var box_per_big_plt = ($("#box_per_big_pallet"+product_size_id).val()>0)?$("#box_per_big_pallet"+product_size_id).val():0;
	var box_per_small_plt_new = ($("#box_per_small_pallet"+product_size_id).val()>0)?$("#box_per_small_pallet"+product_size_id).val():0;
	var no_big_plt_container_new = ($("#big_pallet_container"+product_size_id).val()>0)?$("#big_pallet_container"+product_size_id).val():0;
	var no_small_plt_container_new = ($("#small_pallet_container"+product_size_id).val()>0)?$("#small_pallet_container"+product_size_id).val():0;
	var big_plat_weight = ($("#big_pallet_weight"+product_size_id).val()>0)?$("#big_pallet_weight"+product_size_id).val():0;
	var small_plat_weight = ($("#small_pallent_weight"+product_size_id).val()>0)?$("#small_pallent_weight"+product_size_id).val():0;
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
	
	$("#multi_box_per_container"+product_size_id).val(multi_box_per_container.toFixed(2));
	$("#multi_gross_weight_container"+product_size_id).val(multi_gross_weight_container.toFixed(2));
	$("#multi_net_weight_container"+product_size_id).val(multi_net_weight_container.toFixed(2));
	$("#multi_sqm_per_container"+product_size_id).val(multi_sqm_per_container.toFixed(2));
	var feet_per_box = sqm_per_box * 10.7639;
    $("#multi_feet_per_box"+product_size_id).val(feet_per_box.toFixed(3));
    $("#feet_per_box"+product_size_id).val(feet_per_box.toFixed(3));
    
  
	price_calaculation(product_size_id);
}
function price_calaculation(product_size_id)
{
	var factory_price = $("#facory_rate"+product_size_id).val();
	var sqm_per_box = $("#sqm_per_box"+product_size_id).val();
	var pcs_per_box = $("#pcs_per_box"+product_size_id).val();
	var price_type = $("#price_type"+product_size_id).val();
	var usd_price = ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
	var fob_expenenses = 0;
	if($("#fob_expenenses"+product_size_id).val()>0)
	{
		var fob_expenenses = $("#fob_expenenses"+product_size_id).val();
	}
	 
	if($("#tab1"+product_size_id).hasClass("active"))
	{
		var pallet_charges  = 0;
	
		if($("#pallet_charges"+product_size_id).val()>0)
		{
			pallet_charges = $("#pallet_charges"+product_size_id).val();
		}
		 
			var feet_per_box = $("#feet_per_box"+product_size_id).val();
			var total_sqm = $("#sqm_per_container"+product_size_id).val();
			var box_per_container = $("#box_per_container"+product_size_id).val();
			var per_box_price = 0; 
			var total_price_inr = 0; 
			var usd_per_box = 0; 
	
			if(price_type=="Feet")
			{
				per_box_price  = parseFloat(feet_per_box) * parseFloat(factory_price);
 				per_box_price = per_box_price.toFixed(2) / parseFloat(sqm_per_box);
			 	total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				total_price_inr += parseFloat(pallet_charges);
			 	total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				
				
			}
			else if(price_type=="Box")
			{
				per_box_price = factory_price;
				per_box_price = per_box_price / parseFloat(sqm_per_box);
				total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				total_price_inr += parseFloat(pallet_charges);
				total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
			else if(price_type=="SQM")
			{
				per_box_price = factory_price;
				total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				total_price_inr += parseFloat(pallet_charges);
				total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
			else if(price_type=="PCS")
			{
				per_box_price = factory_price;
			  	total_price_inr = parseFloat(per_box_price) * parseFloat(pcs_per_box) * parseFloat(box_per_container);
				total_price_inr += parseFloat(pallet_charges);
			 	total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
	}
	else if($("#tab2"+product_size_id).hasClass("active"))
	{
		 
			var feet_per_box = $("#feet_per_box"+product_size_id).val();
			var total_sqm = $("#withoutpallet_sqm_per_container"+product_size_id).val();
			var total_boxes = $("#total_boxes"+product_size_id).val();
			var per_box_price = 0; 
			var total_price_inr = 0; 
			var usd_per_box = 0; 
			 
			if(price_type=="Feet")
			{
				per_box_price  = parseFloat(feet_per_box) * parseFloat(factory_price);
 				per_box_price = per_box_price.toFixed(2) / parseFloat(sqm_per_box);
			 	total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				 total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
				
			}
			else if(price_type=="Box")
			{
				per_box_price = factory_price;
				per_box_price = per_box_price / parseFloat(sqm_per_box);
				total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				 total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
			else if(price_type=="SQM")
			{
				per_box_price = factory_price;
				total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
			 	total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
			else if(price_type=="PCS")
			{
				per_box_price = factory_price;
			  	total_price_inr = parseFloat(per_box_price) * parseFloat(pcs_per_box) * parseFloat(total_boxes);
			 	total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
	}
	else if($("#tab3"+product_size_id).hasClass("active"))
	{
		var big_pallet_charges  = 0;
	
		if($("#big_pallet_charges"+product_size_id).val()>0)
		{
			big_pallet_charges = $("#big_pallet_charges"+product_size_id).val();
		}
		var small_pallet_charges  = 0;
		
		if($("#small_pallet_charges"+product_size_id).val()>0)
		{
			var small_pallet_charges = $("#small_pallet_charges"+product_size_id).val();
		}
			var feet_per_box = $("#feet_per_box"+product_size_id).val();
			var total_sqm = $("#multi_sqm_per_container"+product_size_id).val();
			var multi_box_per_container = $("#multi_box_per_container"+product_size_id).val();
			var per_box_price = 0; 
			var total_price_inr = 0; 
			var usd_per_box = 0; 
			
			if(price_type=="Feet")
			{
				per_box_price  = parseFloat(feet_per_box) * parseFloat(factory_price);
 				per_box_price = per_box_price.toFixed(2) / parseFloat(sqm_per_box);
			 	total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				
				total_price_inr += parseFloat(big_pallet_charges);
				total_price_inr += parseFloat(small_pallet_charges);
				total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
				
			}
			else if(price_type=="Box")
			{
				per_box_price = factory_price;
				per_box_price = per_box_price / parseFloat(sqm_per_box);
				total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				total_price_inr += parseFloat(big_pallet_charges);
				total_price_inr += parseFloat(small_pallet_charges);
			 	total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
			else if(price_type=="SQM")
			{
				per_box_price = factory_price;
				total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
				total_price_inr += parseFloat(big_pallet_charges);
				total_price_inr += parseFloat(small_pallet_charges);
				total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
			else if(price_type=="PCS")
			{
				per_box_price = factory_price;
				total_price_inr = parseFloat(per_box_price) * parseFloat(pcs_per_box) * parseFloat(multi_box_per_container);
				total_price_inr += parseFloat(big_pallet_charges);
				total_price_inr += parseFloat(small_pallet_charges);
				total_price_inr += parseFloat(fob_expenenses);
				$("#total_price_html"+product_size_id).html(total_price_inr.toFixed(3));
				$("#total_price"+product_size_id).val(total_price_inr.toFixed(3));
				 
			}
			
	}
 	 our_price_calaculation(product_size_id);
	
}
function our_price_calaculation(product_size_id)
{
	var usd_price = ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
	var our_selling_price = ($("#our_selling_price"+product_size_id).val() > 0)?$("#our_selling_price"+product_size_id).val():0;
	
	var total_sqm = 0;
	var total_feet = 0;
	var total_box = 0;
	var total_pcs = 0;
	if($("#tab1"+product_size_id).hasClass("active"))
	{
		total_sqm = $("#sqm_per_container"+product_size_id).val();
		total_box = $("#box_per_container"+product_size_id).val();
		total_feet = parseFloat($("#feet_per_box"+product_size_id).val()) * parseFloat($("#box_per_container"+product_size_id).val());
		total_pcs = parseFloat($("#pcs_per_box"+product_size_id).val()) * parseFloat($("#box_per_container"+product_size_id).val());
	}
	else if($("#tab2"+product_size_id).hasClass("active"))
	{
		total_sqm = $("#withoutpallet_sqm_per_container"+product_size_id).val();
		total_box = $("#total_boxes"+product_size_id).val();
		total_feet = parseFloat($("#feet_per_box"+product_size_id).val()) * parseFloat($("#total_boxes"+product_size_id).val());
		total_pcs = parseFloat($("#pcs_per_box"+product_size_id).val()) * parseFloat($("#total_boxes"+product_size_id).val());
	}
	else if($("#tab3"+product_size_id).hasClass("active"))
	{
		total_sqm = $("#multi_sqm_per_container"+product_size_id).val();
		total_box = $("#multi_box_per_container"+product_size_id).val();
		total_feet = parseFloat($("#feet_per_box"+product_size_id).val()) * parseFloat($("#multi_box_per_container"+product_size_id).val());
		total_pcs = parseFloat($("#pcs_per_box"+product_size_id).val()) * parseFloat($("#multi_box_per_container"+product_size_id).val());
	}
	var our_price_type = $("#our_price_type"+product_size_id).val();
	var total_price_inr = $("#total_price"+product_size_id).val();
	 
	
	if(our_price_type=="Feet")
	{
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_feet);
		$("#usd_per_box_html"+product_size_id).html(usd_per_box.toFixed(3));
		$("#per_box_price"+product_size_id).val(usd_per_box.toFixed(3));
		
		if(our_selling_price>0)
		{
			var selling_price 		 = $("#per_box_price"+product_size_id).val();
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_feet)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price);
			
			$("#profit_price_html"+product_size_id).html(profilt.toFixed(3));
			$("#profit_price"+product_size_id).val(profilt.toFixed(3));
		}
		else
		{
			$("#profit_price_html"+product_size_id).html(0);
			$("#profit_price"+product_size_id).val(0);
		}
	}
	else if(our_price_type=="Box")
	{
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_box);
		$("#usd_per_box_html"+product_size_id).html(usd_per_box.toFixed(3));
		$("#per_box_price"+product_size_id).val(usd_per_box.toFixed(3));
		
		if(our_selling_price>0)
		{
			var selling_price 		 = $("#per_box_price"+product_size_id).val();
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_box)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price);
			
			$("#profit_price_html"+product_size_id).html(profilt.toFixed(3));
			$("#profit_price"+product_size_id).val(profilt.toFixed(3));
		}
		else
		{
			$("#profit_price_html"+product_size_id).html(0);
			$("#profit_price"+product_size_id).val(0);
		}
		 
	}
	else if(our_price_type=="SQM")
	{
		 
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_sqm);
		$("#usd_per_box_html"+product_size_id).html(usd_per_box.toFixed(3));
		$("#per_box_price"+product_size_id).val(usd_per_box.toFixed(3));
		 
		if(our_selling_price>0)
		{
			var selling_price 		 = $("#per_box_price"+product_size_id).val();
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_sqm)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price)
			$("#profit_price_html"+product_size_id).html(profilt.toFixed(3));
			$("#profit_price"+product_size_id).val(profilt.toFixed(3));
		}
		else
		{
			$("#profit_price_html"+product_size_id).html(0);
			$("#profit_price"+product_size_id).val(0);
		}
		 
	}
	else if(our_price_type=="PCS")
	{
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_pcs);
		$("#usd_per_box_html"+product_size_id).html(usd_per_box.toFixed(3));
		$("#per_box_price"+product_size_id).val(usd_per_box.toFixed(3));
		 
		if(our_selling_price>0)
		{
			var selling_price 		 = $("#per_box_price"+product_size_id).val();
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_pcs)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price)
			$("#profit_price_html"+product_size_id).html(profilt.toFixed(3));
			$("#profit_price"+product_size_id).val(profilt.toFixed(3));
		}
		else
		{
			$("#profit_price_html"+product_size_id).html(0);
			$("#profit_price"+product_size_id).val(0);
		}
	}
				
	
	
}
$("#series_add").validate({
		rules: {
			series_name: {
				required: true
			}
		},
		messages: {
			series_name: {
				required: "Enter series Name"
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
					$("#series_id").select2("val",obj.id);
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
<?php 
if(!empty($currency_code))
{
	echo "<script> get_exchange_rate('".$currency_code."')</script>";
}
?>
