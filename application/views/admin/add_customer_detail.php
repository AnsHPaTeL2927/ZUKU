<?php 
$this->view('lib/header'); ?>	
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
									<a href="<?=base_url().'customer_detail'?>">Customer List</a>
									
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								Additional Detail Of <span><?=$cust_data->c_companyname?>  </span>
							 </h3>
							
							</div>
							 <div class="panel-body form-body">
							 <div class="col-md-8 col-md-offset-1">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="customer_additional_form" id="customer_additional_form">
										 
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Container weight limit (In KGS)
											</label>
											<div class="col-sm-6">
												<textarea class="form-control" name="container_weight" id="container_weight" placeholder="Container weight (Ex : 27000,28000)"><?=strip_tags($detail->container_weight)?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Note
											</label>
											<div class="col-sm-6">
												<textarea class="form-control" name="note" id="note" placeholder="Note"><?=strip_tags($detail->note)?></textarea>
											</div>
										</div>
											<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Select Fumigation
											</label>
											<div class="col-sm-4">
												<select class="select2" name="fumigation_id" id="fumigation_id" >
													<option value="">Select Fumigation</option>
												<?php 
													foreach($getfumigation as $fumigation_row)
													{
														$sel = '';
														if($fumigation_row->fumigation_id == $detail->fumigation_id)
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
											<label class="col-sm-4 control-label" for="form-field-1">
												Select Pallet Cap
											</label>
											<div class="col-sm-4">
												<select class="select2" name="pallet_cap_id" id="pallet_cap_id" >
													<option value="">Select Pallet Cap</option>
												<?php 
													foreach($getpallet_cap as $pallet_cap_row)
													{
														$sel = '';
														if($pallet_cap_row->pallet_cap_id == $detail->pallet_cap_id)
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
											<label class="col-sm-4 control-label" for="form-field-1">
												Set Default Bank  
											</label>
											<div class="col-sm-6">
												<Select name="bank_id" id="bank_id" class="form-control">
													<option>Select Bank</option>
													<?php 
													 for($i=0; $i<count($all_bank);$i++)
													{
														$sel = '';
														if($all_bank[$i]->id==$detail->bank_id )
														{
																$sel =  'selected="selected"';
														}	 
														else if($all_bank[$i]->id == $company_detail[0]->bank_name)
														{
															$sel =  'selected="selected"';
														}
													?>
														<option value="<?php echo $all_bank[$i]->id; ?>" <?=$sel?>><?php echo $all_bank[$i]->bank_name; ?></option>
													<?php
													}
													?>
												</Select>
												
											</div>
											<div class="col-sm-2 padding-0">
													<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">+ Bank</button>
												</div>
										</div>
									 	<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Back Side Of The Tiles
											</label>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$detail->made_in_india_status?>" class="form-control"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Factory Logo On Back Side Of The Tiles
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="factory_logo_status" id="factory_logo_status1" value="YES"  <?=($detail->factory_logo_status == "YES")?"checked":""?> checked> 
												  		<strong for ="factory_logo_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="factory_logo_status" id="factory_logo_status2" value="NO"  <?=($detail->factory_logo_status == "NO")?"checked":""?> > 
												  		<strong for ="factory_logo_status2">No</strong>
													</label>
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Airbag 
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status1" value="YES"  <?=($detail->air_bag_status == "YES")?"checked":""?> checked> 
												  		<strong for ="air_bag_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status2" value="NO"  <?=($detail->air_bag_status == "NO")?"checked":""?> > 
												  		<strong for ="air_bag_status2">No</strong>
													</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Moisture Bag 
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="mosqure_bag_status" id="mosqure_bag_status1" value="YES"  <?=($detail->mosqure_bag_status == "YES")?"checked":""?> checked> 
												  		<strong for ="mosqure_bag_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="mosqure_bag_status" id="mosqure_bag_status2" value="NO"  <?=($detail->mosqure_bag_status == "NO")?"checked":""?> > 
												  		<strong for ="mosqure_bag_status2">No</strong>
													</label>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Corner Protector 
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="corner_protector" id="corner_protector1" value="YES"  <?=($detail->corner_protector == "YES")?"checked":""?> checked> 
												  		<strong for ="corner_protector1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="corner_protector" id="corner_protector2" value="NO"  <?=($detail->corner_protector == "NO")?"checked":""?> > 
												  		<strong for ="corner_protector2">No</strong>
													</label>
											</div>
										</div>
										<!--<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Separator Between The Tiles
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles1" value="YES"  <?=($detail->separation_tiles == "YES")?"checked":""?> checked> 
												  		<strong for ="separation_tiles1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles2" value="NO"  <?=($detail->separation_tiles == "NO")?"checked":""?> > 
												  		<strong for ="separation_tiles2">No</strong>
													</label>
											</div>
										</div>-->
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Safety Belt
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="safety_belt" id="safety_belt1" value="YES"  <?=($detail == "YES")?"checked":""?>  checked> 
												  		<strong for ="safety_belt1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="safety_belt" id="safety_belt2" value="NO"  <?=($detail == "NO")?"checked":""?> > 
												  		<strong for ="safety_belt2">No</strong>
													</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Separator Between The Tiles
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles1" value="Brown Paper"  <?=($detail == "Brown Paper")?"checked":""?>  checked> 
												  		<strong for ="separation_tiles1">Brown Paper</strong>
													</label>
													  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles2" value="While Paper"  <?=($detail == "While Paper")?"checked":""?> > 
												  		<strong for ="separation_tiles2">While Paper</strong>
													</label>  
													<label>
													 <input type="radio" name="separation_tiles" id="separation_tiles3" value="Foam Sheet"  <?=($detail == "Foam Sheet")?"checked":""?> > 
												  		<strong for ="separation_tiles3">Foam Sheet</strong>
													</label>  
													<label>
													 <input type="radio" name="separation_tiles" id="separation_tiles4" value="Lamination"  <?=($detail == "Lamination")?"checked":""?> > 
												  		<strong for ="separation_tiles4">Lamination</strong>
													</label>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Variation in quantity
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status1" value="Allowed"  <?=($detail->quonitiy_status == "Allowed")?"checked":""?> checked> 
												  		<strong for ="quonitiy_status1">Allowed</strong>
													</label>
													  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status2" value="Not Allowed"  <?=($detail->quonitiy_status == "Not Allowed")?"checked":""?> > 
												  		<strong for ="quonitiy_status2">Not Allowed</strong>
													</label>
											</div>
										</div>
										
										<div class="form-group barcode_sticker_file_html">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Box Sticker File
											</label>
											<div class="col-sm-4">
										 		 <input type="file" name="barcode_sticker_file[]" id="barcode_sticker_file" class="form-control" multiple> 
										 	</div>
											<?php
											if(!empty($detail->barcode_sticker_file))
											{
												$images_name = explode(",",$detail->barcode_sticker_file);
												foreach($images_name as $img)
												echo "<span><img src='".base_url()."upload/".$img."' width='110px' height='50px' /> </span>"; 
											}
											?>
										</div>
										<div class="form-group box_sticker_file_html">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Pallet Sticker File
											</label>
											<div class="col-sm-4">
										 		 <input type="file" name="box_sticker_file" id="box_sticker_file" class="form-control"> 
										 	</div>
											<div class="col-sm-2">
											<?php
											if(!empty($detail->box_sticker_file))
											{
												echo "<img src='".base_url()."upload/".$detail->box_sticker_file."' width='110px' height='50px' />";
											}
											?>
											</div>
										</div>
											
										<div class="form-group box_sticker_file_html">
											<label class="col-sm-4 control-label" for="form-field-1">
												Special Sticker File
											</label>
											<div class="col-sm-4">
										 		 <input type="file" name="special_sticker_file" id="special_sticker_file" class="form-control"> 
										 	</div>
											<div class="col-sm-2">
											<?php
											if(!empty($detail->special_sticker_file))
											{
												echo "<img src='".base_url()."upload/".$detail->special_sticker_file."' width='110px' height='50px' />";
											}
											?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 File upload 1
											</label>
											<div class="col-sm-4">
										 		 <input type="file" name="file_upload1" id="file_upload1" class="form-control"> 
										 	</div>
											<div class="col-sm-2">
											<?php
											if(!empty($detail->file_upload1))
											{
												echo "<img src='".base_url()."upload/".$detail->file_upload1."' width='110px' height='50px' />";
											}
											?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 File upload 2
											</label>
											<div class="col-sm-4">
										 		 <input type="file" name="file_upload2" id="file_upload2" class="form-control"> 
										 	</div>
											<div class="col-sm-2">
											<?php
											if(!empty($detail->file_upload2))
											{
												echo "<img src='".base_url()."upload/".$detail->file_upload2."' width='110px' height='50px' />";
											}
											?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 IGST (%) 
											</label>
											 
											<div class="col-sm-4">
												  <input type="text" name="igst_per" id="igst_per" value="<?=$detail->igst_per?>" class="form-control" placeholder="IGST (%)"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 CGST (%) 
											</label>
											 
											<div class="col-sm-4">
												   <input type="text" name="cgst_per" id="cgst_per" value="<?=$detail->cgst_per?>" class="form-control" placeholder="CGST (%)"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												SGST (%)
											</label>
										 
											<div class="col-sm-4">
												  <input type="text" name="sgst_per" id="sgst_per" value="<?=$detail->sgst_per?>" class="form-control" placeholder="SGST (%)"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Field 1
											</label>
											<div class="col-sm-4">
												  <input type="text" name="field1" id="field1" value="<?=$detail->field1?>" class="form-control" placeholder="Field 1"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Field 2
											</label>
											<div class="col-sm-4">
												  <input type="text" name="field2" id="field2" value="<?=$detail->field2?>" class="form-control" placeholder="Field 2"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Field 3
											</label>
											<div class="col-sm-4">
												  <input type="text" name="field3" id="field3" value="<?=$detail->field3?>" class="form-control" placeholder="Field 3"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Field 4
											</label>
											<div class="col-sm-4">
												  <input type="text" name="field4" id="field4" value="<?=$detail->field4?>" class="form-control" placeholder="Field 4"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Field 5
											</label>
											<div class="col-sm-4">
												  <input type="text" name="field5" id="field5" value="<?=$detail->field5?>" class="form-control" placeholder="Field 5"> 
											</div>
										</div>
										
								<div class="col-md-offset-3">
								<div class="form-group " style="" >
										<button type="submit" class="btn btn-success">
											Save
										</button>
										<button type="button"  class="btn btn-success" onclick="save_and_next();">
											Save & Next
										</button>
										<a href="<?=base_url().'customer_detail/index'?>" class="btn btn-danger">
											Cancel
										</a>
										<?php
											if($fd == 'edit')
											{
											?>
												<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Consigner</button>-->
											<?php

											}
										?>
									</div>
									
									</div>
										<input type="hidden" name="customer_id" id="customer_id" value="<?=$cust_data->id?>"/>
										<input type="hidden" name="customer_add_detail_id" id="customer_add_detail_id" value="<?=$detail->customer_add_detail_id?>"/>
										<input type="hidden" name="box_sticker_filename" id="box_sticker_filename" value="<?=$detail->box_sticker_file?>"/>
										<input type="hidden" name="special_sticker_filename" id="special_sticker_filename" value="<?=$detail->special_sticker_file?>"/>
										<input type="hidden" name="barcode_sticker_filename" id="barcode_sticker_filename" value="<?=$detail->barcode_sticker_file?>"/>
										<input type="hidden" name="file_upload1_filename" id="file_upload1_filename" value="<?=$detail->file_upload1?>"/>
										<input type="hidden" name="file_upload2_filename" id="file_upload2_filename" value="<?=$detail->file_upload2?>"/>
										<input type="hidden" name="next" id="next" value="0"/>
									</form>
							</div>
					</div>
						
							 <div class="page-header">
							<h3>
							Set Product Wise Box Design Of	<span><?=$cust_data->c_companyname?>  </span>
							 </h3>
							
							</div>
							 <div class="panel-body form-body">
							 <div class="col-md-12">
									 <div class="form-group">
										<div class="col-sm-4">
											<strong>Product</strong>
										</div>
										<div class="col-sm-3">
											<strong>Select Box Design</strong>
										</div>
										<div class="col-sm-2">
											<strong>Select Pallet Type</strong>
										</div>
										<div class="col-sm-3">
											<strong>Select Pallet Packing</strong>
										</div>
										<div class="col-md-12" style="height:12px;"></div>
										<?php 
									 	for($i=0; $i<count($all_size);$i++)
										{
											 $size_name		= $all_size[$i]->sizetypemm;
											 $series_name	= $all_size[$i]->series_name;
											 $thickness  	= (!empty($all_size[$i]->thickness))?' - '.$all_size[$i]->thickness.' MM':"";
											 $description_goods = $size_name.' ('.$series_name.')'; 
										?>
									 	<div class="col-sm-4">
											 <?=$description_goods?> <?=$thickness?>
											 <input type="hidden" name="product_id[]" id="product_id<?=$i?>" value="<?=$all_size[$i]->productid?>"/>
										</div>
										<div class="col-sm-3">
												<select class="select2" name="box_design_id[]" id="box_design_id<?=$i?>" onchange="update_box_design(this.value,<?=$i?>)">
													<option value="">Select Box Design</option>
												<?php 
													foreach($box_design_data as $box_design_row)
													{
														$sel = '';
														if($box_design_row->box_design_id == $all_size[$i]->box_design_id)
														{
															$sel ='selected="selected"';
														}
														echo "<option ".$sel." value='".$box_design_row->box_design_id."'>".$box_design_row->box_design_name."</option>";
													}
												?>
												</select>
										</div>
										<div class="col-sm-2">
												<select class="select2" name="pallet_type_id[]" id="pallet_type_id<?=$i?>" onchange="update_pallet_type_design(this.value,<?=$i?>)">
													<option value="">Select Pallet Type</option>
												<?php 
													foreach($pallet_type_data as $pallet_type_row)
													{
														$sel = '';
														if($pallet_type_row->pallet_type_id == $all_size[$i]->pallet_type_id)
														{
															$sel ='selected="selected"';
														}
														echo "<option ".$sel." value='".$pallet_type_row->pallet_type_id."'>".$pallet_type_row->pallet_type_name."</option>";
													}
												?>
												</select>
										</div>
										<div class="col-sm-3">
												<select class="select2" name="product_size_id[]" id="product_size_id<?=$i?>" onchange="update_pallet_packing(this.value,<?=$i?>)">
													<option value="">Select Pallet Packing</option>
												<?php 
													foreach($all_size[$i]->packing as $packing_row)
													{
														$sel = '';
														if($packing_row->product_size_id == $all_size[$i]->product_size_id)
														{
															$sel ='selected="selected"';
														}
														$label = $packing_row->product_packing_name;
														 
														if($packing_row->boxes_per_pallet > 0)
														{
															$label .= ' - '.$packing_row->boxes_per_pallet.' Boxes - '.$packing_row->total_pallent_container.' Pallets';
														}
														else if($packing_row->box_per_big_plt > 0 || $packing_row->no_small_plt_container_new >0)
														{
															$label .= ' - '.$packing_row->box_per_big_plt.' * '.$packing_row->no_big_plt_container_new.','.$packing_row->box_per_small_plt_new.' * '.$packing_row->no_small_plt_container_new.' Pallets';
														}
														else
														{
															$label .= ' - '.$packing_row->total_boxes.' Boxes';
														}
														echo "<option ".$sel." value='".$packing_row->product_size_id."'>".$label."</option>";
													}
												?>
												</select>
										</div>
										<input type="hidden" name="customer_box_design_id[]" id="customer_box_design_id<?=$i?>" value="<?=$all_size[$i]->customer_box_design_id?>"/>
										<div class="col-md-12" style="height:12px;"></div>
										<?php 
										}
										?>
										</div>
										
						</div>
					</div>
					 
				 </div>
			</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer');
 $this->view('lib/addseries'); ?>
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
				        <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" required="" class="form-control" />
				    </div>                
				    
				    <div class="field-group">
				        <textarea id="bank_address" name="bank_address" placeholder="Bank Address" class="form-control"></textarea>
				    </div>                     
				    <div class="field-group">
				        <input id="account_name" type="text" name="account_name" placeholder="Account Name" required="" class="form-control" required title="Enter Account Name"/>
				    </div>  
				    <div class="field-group">
				        <input id="Email_ask" type="text" name="account_no" placeholder="Account No" required="" class="form-control"/>
				    </div>                
				    <div class="field-group">
				        <input type="text" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" class="form-control" />    
				    </div> 

				    <div class="field-group">
				        <input type="text" id="swift_code" name="swift_code" placeholder="Swift Code" class="form-control" />    
				    </div> 
				    <div class="field-group">
				        <input type="text" id="bank_ad_code" name="bank_ad_code" placeholder="Bank Ad Code No" class="form-control" />    
				    </div>                   
				
				                      
				
            </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info" onClick="return checkFields()" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

 
<script>
function save_and_next()
{
	$("#next").val(1);
	$("#customer_additional_form").submit();
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

$(".select2").select2({
	width:'100%' 
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
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'bank_detail'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'bank_detail'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 
$("#customer_additional_form").submit(function(event) {
	event.preventDefault();
	if(!$("#customer_additional_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'add_customer_detail/manage',
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
					if($("#next").val() == 1)
					{
						setTimeout(function(){ window.location = root+'add_design_detail/design_detail/<?=$cust_data->id?>'; },100);
					}
					else
					{
						setTimeout(function(){ location.reload(); },100);
					}
			   }
			   else if(obj.res==2)
			   {
				   
					unblock_page("success","Sucessfully Updated.");
					if($("#next").val() == 1)
					{
						
						setTimeout(function(){ window.location = root+'add_design_detail/design_detail/<?=$cust_data->id?>'; },100);
					 }
					else
					{
						setTimeout(function(){ location.reload(); },100);
					}
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
function update_box_design(value,no)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_customer_detail/manage_box_design",
              data: {
					"box_design_id"	: value,
					"customer_id"	: <?=$cust_data->id?>,
					"product_id" 	: $("#product_id"+no).val(),
					"customer_box_design_id" : $("#customer_box_design_id"+no).val()
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  	$(".loader").hide();
					if(obj.res==1)
					{
						
						 	$("#customer_additional_form").submit();
					}
					else if(obj.res==2)
					{
						
						 	$("#customer_additional_form").submit();
					}
					else
					{
							unblock_page("error","Something Wrong.") 
						
					}
					unblock_page("",""); 
                  }
              
          }); 

} 
function update_pallet_type_design(value,no)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_customer_detail/manage_pallet_design",
              data: {
					"pallet_type_id"	: value,
					"customer_id"	: <?=$cust_data->id?>,
					"product_id" 	: $("#product_id"+no).val(),
				 	"customer_box_design_id" : $("#customer_box_design_id"+no).val()
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  	$(".loader").hide();
					if(obj.res==1)
					{
						
								$("#customer_additional_form").submit();
					}
					else if(obj.res==2)
					{
						
								$("#customer_additional_form").submit();
					}
					else
					{
							unblock_page("error","Something Wrong.") 
						
					}
					unblock_page("",""); 
                  }
              
          }); 
}
function update_pallet_packing(value,no)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_customer_detail/manage_pallet_packing",
              data: {
					"product_size_id"		 : value,
					"customer_id"			 : <?=$cust_data->id?>,
					"product_id" 			 : $("#product_id"+no).val(),
				 	"customer_box_design_id" : $("#customer_box_design_id"+no).val()
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  	$(".loader").hide();
					if(obj.res==1)
					{
						
								$("#customer_additional_form").submit();
					}
					else if(obj.res==2)
					{
						
							$("#customer_additional_form").submit();
					}
					else
					{
							unblock_page("error","Something Wrong.") 
						
					}
					unblock_page("",""); 
                  }
              
          }); 
}
</script>

  