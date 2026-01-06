<?php 
 $date = date('d-m-Y');
 if(!empty($addtional_data))
 {
	 $date = date('d-m-Y',strtotime($addtional_data->readiness_date));
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
							<li class="active">
								<a href="<?=base_url()?>invoice_listing">Proforma Invoice List </a>
							</li>
							<li class="active">
								  Addition Details of <?=$invoicedata->invoice_no?>
							</li>
					 	</ol>
							<div class="page-header">
							<h3><?=$mode?> Addition Details of <?=$invoicedata->invoice_no?> </h3>
							</div>
						</div>
					</div>
				 	<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								</div>
								<div class="panel-body">
								<div class="col-md-8 col-md-offset-1">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="addition_details_form" id="addition_details_form">
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Select Factory 
											</label>
											<div class="col-sm-4">
												<select class="select2" name="supplier_id" id="supplier_id" title="Select Supplier">
													<option value="">Select Supplier</option>
													<?php
													foreach($all_supplier as $supplier_row)
													{
														$sel = '';
														if($supplier_row->supplier_id == $addtional_data->mgf_company_name)
														{
															$sel ='selected="selected"';
														}
														echo "<option ".$sel."  value='".$supplier_row->supplier_id."'>".$supplier_row->supplier_name." - ".$supplier_row->company_name."</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Expected Cargo Readiness Date
											</label>
											<div class="col-sm-4">
												<input type="text" placeholder="Date" id="readiness_date" required class="form-control defualt-date-picker" name="readiness_date" value="<?=$date?>" title="Expected Cargo Readiness Date" >
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
													foreach($fumigation_data as $fumigation_row)
													{
														$sel = '';
														if($fumigation_row->fumigation_id == $addtional_data->fumigation_id)
														{
															$sel ='selected="selected"';
														}
														else if($fumigation_row->fumigation_id == $customerdetail->fumigation_id)
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
													foreach($pallet_cap_data as $pallet_cap_row)
													{
														$sel = '';
														if($pallet_cap_row->pallet_cap_id == $addtional_data->pallet_cap_id)
														{
															$sel ='selected="selected"';
														}
														else if($pallet_cap_row->pallet_cap_id == $customerdetail->pallet_cap_id)
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
												 Back Side Of The Tiles
											</label>
											<?php 
											$made_in_india_status = $addtional_data->made_in_india_status;
											if(empty($made_in_india_status)) 
											{
												$made_in_india_status = $customerdetail->made_in_india_status;
											}
											?>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$made_in_india_status?>" class="form-control" placeholder=" Back Side Of The Tiles"> 
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Factory Logo On Back Side Of The Tiles
											</label>
											<?php 
											$factory_logo_status = 'YES';
											if(!empty($addtional_data->factory_logo_status))
											{
												$factory_logo_status = $addtional_data->factory_logo_status;
											}
											else if(!empty($customerdetail->factory_logo_status))
											{
												$factory_logo_status = $customerdetail->factory_logo_status;
											}
											?>
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="factory_logo_status" id="factory_logo_status1" value="YES"  <?=($factory_logo_status== "YES")?"checked":""?>> 
												  		<strong for ="factory_logo_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="factory_logo_status" id="factory_logo_status2" value="NO"  <?=($factory_logo_status == "NO")?"checked":""?> > 
												  		<strong for ="factory_logo_status2">No</strong>
													</label>
											 </div>
										</div>
										<?php 
											$air_bag_status = 'YES';
											if(!empty($addtional_data->air_bag_status))
											{
												$air_bag_status = $addtional_data->air_bag_status;
											}
											else if(!empty($customerdetail->air_bag_status))
											{
												$air_bag_status = $customerdetail->air_bag_status;
											}
											?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Airbag 
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status1" value="YES"  <?=($air_bag_status == "YES")?"checked":""?>> 
												  		<strong for ="air_bag_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="air_bag_status" id="air_bag_status2" value="NO"  <?=($air_bag_status == "NO")?"checked":""?> > 
												  		<strong for ="air_bag_status2">No</strong>
													</label>
											</div>
										</div>
										<?php 
											$mosqure_bag_status = 'YES';
											if(!empty($addtional_data->mosqure_bag_status))
											{
												$mosqure_bag_status = $addtional_data->mosqure_bag_status;
											}
											else if(!empty($customerdetail->mosqure_bag_status))
											{
												$mosqure_bag_status = $customerdetail->mosqure_bag_status;
											}
											?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Moisture Bag 
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="mosqure_bag_status" id="mosqure_bag_status1" value="YES"  <?=($mosqure_bag_status == "YES")?"checked":""?> checked> 
												  		<strong for ="mosqure_bag_status1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="mosqure_bag_status" id="mosqure_bag_status2" value="NO"  <?=($mosqure_bag_status == "NO")?"checked":""?> > 
												  		<strong for ="mosqure_bag_status2">No</strong>
													</label>
											</div>
										</div>
										<?php 
											$corner_protector = 'YES';
											if(!empty($addtional_data->corner_protector))
											{
												$corner_protector = $addtional_data->corner_protector;
											}
											else if(!empty($customerdetail->corner_protector))
											{
												$corner_protector = $customerdetail->corner_protector;
											}
											?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Corner Protector 
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="corner_protector" id="corner_protector1" value="YES"  <?=($corner_protector == "YES")?"checked":""?>  > 
												  		<strong for ="corner_protector1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="corner_protector" id="corner_protector2" value="NO"  <?=($corner_protector == "NO")?"checked":""?> > 
												  		<strong for ="corner_protector2">No</strong>
													</label>
											</div>
										</div>
										<?php 
											$safety_belt = 'YES';
											if(!empty($addtional_data->safety_belt))
											{
												$safety_belt = $addtional_data->safety_belt;
											}
											else if(!empty($customerdetail->safety_belt))
											{
												$safety_belt = $customerdetail->safety_belt;
											}
											?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Safety Belt
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="safety_belt" id="safety_belt1" value="YES"  <?=($safety_belt == "YES")?"checked":""?>  > 
												  		<strong for ="safety_belt1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="safety_belt" id="safety_belt2" value="NO"  <?=($safety_belt == "NO")?"checked":""?> > 
												  		<strong for ="safety_belt2">No</strong>
													</label>
											</div>
										</div>
										<?php 
											$separation_tiles = 'YES';
											if(!empty($addtional_data->separation_tiles))
											{
												$separation_tiles = $addtional_data->separation_tiles;
											}
											else if(!empty($customerdetail->separation_tiles))
											{
												$separation_tiles = $customerdetail->separation_tiles;
											}
											?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Separator Between The Tiles
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles1" value="Brown Paper"  <?=($separation_tiles == "Brown Paper")?"checked":""?>  > 
												  		<strong for ="separation_tiles1">Brown Paper</strong>
													</label>
													  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles2" value="While Paper"  <?=($separation_tiles == "While Paper")?"checked":""?> > 
												  		<strong for ="separation_tiles2">While Paper</strong>
													</label>  
													<label>
													 <input type="radio" name="separation_tiles" id="separation_tiles3" value="Foam Sheet"  <?=($separation_tiles == "Foam Sheet")?"checked":""?> > 
												  		<strong for ="separation_tiles3">Foam Sheet</strong>
													</label>  
													<label>
													 <input type="radio" name="separation_tiles" id="separation_tiles4" value="Lamination"  <?=($separation_tiles == "Lamination")?"checked":""?> > 
												  		<strong for ="separation_tiles4">Lamination</strong>
													</label>
											</div>
										</div>	
										<!--<?php 
											$separation_tiles = 'YES';
											if(!empty($addtional_data->separation_tiles))
											{
												$separation_tiles = $addtional_data->separation_tiles;
											}
											else if(!empty($customerdetail->separation_tiles))
											{
												$separation_tiles = $customerdetail->separation_tiles;
											}
											?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Separator Between The Tiles
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles1" value="YES"  <?=($separation_tiles == "YES")?"checked":""?>  > 
												  		<strong for ="separation_tiles1">Yes</strong>
													</label>
													  <label>
													 <input type="radio" name="separation_tiles" id="separation_tiles2" value="NO"  <?=($separation_tiles == "NO")?"checked":""?> > 
												  		<strong for ="separation_tiles2">No</strong>
													</label>
											</div>
										</div>-->
										<?php 
											$quonitiy_status = 'Allowed';
											if(!empty($addtional_data->quonitiy_status))
											{
												$quonitiy_status = $addtional_data->quonitiy_status;
											}
											else if(!empty($customerdetail->quonitiy_status))
											{
												$quonitiy_status = $customerdetail->quonitiy_status;
											}
											?>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Variation in quantity
											</label>
											<div class="col-sm-4">
												  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status1" value="Allowed"  <?=($quonitiy_status == "Allowed")?"checked":""?> checked> 
												  		<strong for ="quonitiy_status1">Allowed</strong>
													</label>
													  <label>
													 <input type="radio" name="quonitiy_status" id="quonitiy_status2" value="Not Allowed"  <?=($quonitiy_status == "Not Allowed")?"checked":""?> > 
												  		<strong for ="quonitiy_status2">Not Allowed</strong>
													</label>
											</div>
										</div>
										 <div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Select Signature & Profile
											</label>
											<div class="col-sm-4">
												<select class="select2" name="sign_detail_id" id="sign_detail_id" >
													<option value="">Admin</option>
												<?php 
													foreach($user_data as $user_row)
													{
														$sel = '';
														if($user_row->user_id == $invoicedata->sign_detail_id)
														{
															$sel ='selected="selected"';
														}
														 
														echo "<option ".$sel." value='".$user_row->user_id."'>".$user_row->user_name."</option>";
													}
												?>
												</select>
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
											if(!empty($addtional_data->barcode_sticker_file) && $addtional_data->barcode_sticker_file != "none")
											{
												$images_name = explode(",",$addtional_data->barcode_sticker_file);
												foreach($images_name as $img)
												echo "<span class='barcode_img'><img src='".base_url()."upload/".$img."' width='110px' height='50px' /> </span>
												<button class='btn' onclick='delete_barcode_image()' type='button'>Delete IMG</button>
												";
											}
											else if(!empty($customerdetail->barcode_sticker_file) && $addtional_data->barcode_sticker_file != "none")
											{
												$images_name = explode(",",$customerdetail->barcode_sticker_file);
												foreach($images_name as $img)
												echo "<span class='barcode_img'><img src='".base_url()."upload/".$img."' width='110px' height='50px' /> <button class='btn' onclick='delete_barcode_image()' type='button'>Delete IMG</button>
												</span>";
											}
											?>
										</div>
										<div class="form-group barcode_sticker_file_html">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Box Sticker Remarks
											</label>
											<div class="col-sm-4">
										 		 <textarea name="box_sticker_remarks" id="box_sticker_remarks" class="form-control" placeholder="Box Sticker Remarks"><?=$addtional_data->box_sticker_remarks?></textarea> 
										 	</div>
										</div>
										 
										<div class="form-group box_sticker_file_html">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Pallet Sticker File
											</label>
											<div class="col-sm-4">
										 		 <input type="file" name="box_sticker_file" id="box_sticker_file" class="form-control"> 
										 	</div>
											 
											<?php
											if(!empty($addtional_data->box_sticker_file) && $addtional_data->box_sticker_file != "none")
											{
												echo "<span class='box_img'><img src='".base_url()."upload/".$addtional_data->box_sticker_file."'  width='110px' height='50px'/></span>
												<button class='btn' onclick='delete_box_image()' type='button'>Delete IMG</button>";
											}
											else if(!empty($customerdetail->box_sticker_file) && $addtional_data->box_sticker_file != "none")
											{
												echo "<span class='box_img'><img src='".base_url()."upload/".$customerdetail->box_sticker_file."' width='110px' height='50px' /></span>
												<button class='btn' onclick='delete_box_image()' type='button'>Delete IMG</button>";
											}
											?>
											 
										</div>
										
										<div class="form-group box_sticker_file_html">
											<label class="col-sm-4 control-label" for="form-field-1">
												 Special Sticker File
											</label>
											<div class="col-sm-4">
										 		 <input type="file" name="special_sticker_file" id="special_sticker_file" class="form-control"> 
										 	</div>
											 
											<?php
											if(!empty($addtional_data->special_sticker_file) && $addtional_data->special_sticker_file != "none")
											{
												echo "<span class='special_sticker_img'><img src='".base_url()."upload/".$addtional_data->special_sticker_file."'  width='110px' height='50px'/></span>
												<button class='btn' onclick='delete_special_sticker()' type='button'>Delete IMG</button>";
											}
											else if(!empty($customerdetail->special_sticker_file) && $addtional_data->special_sticker_file != "none")
											{
												echo "<span class='special_sticker_img'><img src='".base_url()."upload/".$customerdetail->special_sticker_file."' width='110px' height='50px' /></span>
												<button class='btn' onclick='delete_special_sticker()' type='button'>Delete IMG</button>";
											}
											?>
											 
										</div>
										
										<!--<div class="form-group barcode_sticker_file_html">
											<label class="col-sm-4 control-label" for="form-field-1">
												Order Remarks
											</label>
											<div class="col-sm-4">
										 		 <textarea name="order_remarks" id="order_remarks" class="form-control" placeholder="Order Remarks"><?=$addtional_data->order_remarks?></textarea> 
										 	</div>
										</div>-->
										 
										 
									 	<div class="col-md-12 col-md-offset-3">
											<div class="form-group " style="" >
												<button type="submit" class="btn btn-success">
													Save
												</button>
												<a href="<?=base_url().'product/index/'.$invoicedata->performa_invoice_id?>" class="btn btn-danger">
													Back
												</a>
										 
											</div>
										</div>
									<input type="hidden" name="performa_invoice_id" id="performa_invoice_id" value="<?=$invoicedata->performa_invoice_id?>"/>
									<input type="hidden" name="performa_additional_detail_id" id="performa_additional_detail_id" value="<?=$addtional_data->performa_additional_detail_id?>"/>
									<input type="hidden" name="barcode_sticker_file_name" id="barcode_sticker_file_name" value="<?=!empty($addtional_data)?$addtional_data->barcode_sticker_file:$customerdetail->barcode_sticker_file?>"/>
									<input type="hidden" name="box_sticker_file_name" id="box_sticker_file_name" value="<?=!empty($addtional_data)?$addtional_data->box_sticker_file:$customerdetail->box_sticker_file?>"/>
										<input type="hidden" name="special_sticker_file_name" id="special_sticker_file_name" value="<?=!empty($addtional_data)?$addtional_data->special_sticker_file:$customerdetail->special_sticker_file?>"/>
							</form>
								</div>
							</div>
						</div>
							 
						</div>
					</div>
					 
				</div>
			</div>
		</div>

 
<?php 
	$this->view('lib/footer'); 
 ?>
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
function delete_barcode_image()
{
	$(".barcode_img").remove();
	$("#barcode_sticker_file_name").val('none');
}
function delete_box_image()
{
	$(".box_img").remove();
	$("#box_sticker_file_name").val('none');
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
function show_file(value,forwhome)
{
	if(forwhome == "barcode")
	{
		if(value=="YES")
		{
			$(".barcode_sticker_file_html").show()
		}
		else{
			$(".barcode_sticker_file_html").hide()
		}
	}
	else if(forwhome == "box")
	{
		if(value=="YES")
		{
			$(".box_sticker_file_html").show()
		}
		else
		{
			$(".box_sticker_file_html").hide()
		}
	}
}
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 $(".select2").select2({
	width:'100%' 
})
 
 
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
  
$("#addition_details_form").submit(function(event) {
	event.preventDefault();
	if(!$("#addition_details_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'addition_details/manage',
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
					setTimeout(function(){ window.location=root+"performa_invoice_pdf/index/<?=$invoicedata->performa_invoice_id?>"; },100);
			   }
			   else if(obj.res==2)
			   {
				   
					unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+"performa_invoice_pdf/index/<?=$invoicedata->performa_invoice_id?>"; },100);
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
if(!empty($addtional_data))
{
echo "<script>show_file('".$addtional_data->barcode_sticker."','barcode')</script>";
echo "<script>show_file('".$addtional_data->box_sticker."','box')</script>";
}
?>
 