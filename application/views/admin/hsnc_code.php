<?php 
$this->view('lib/header'); 
 $back_url = $_SERVER['HTTP_REFERER'];
  $form = 'Packing Detail'
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
									<a href="<?=base_url().'calculation'?>">Tiles Calculator</a>
								</li>
								 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> <?=$form?> </h3>
							</div>
							 
						</div>
					</div>
					<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="hsnc_code_form" id="hsnc_code_form">
               		
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
							Select Product
						</label>
						<div class="col-sm-4">
							<select name="product_id" id="product_id" class="select2" onchange="load_product_data(this.value)">
								<option value="">Select Product</option>
							<?php 
								for($product=0;$product<count($productdata);$product++)
								{
									$sel ='';
									if($productdata[$product]->product_id == $edit_record->product_id)
									{
										$sel = "selected='selected'";
									}
								?>
									<option <?=$sel?> value="<?=$productdata[$product]->product_id?>"><?=$productdata[$product]->size_type_mm.' ( '.$productdata[$product]->series_name.' )'?></option>
							<?php	}
							?>
							</select>
				        </div>
				    </div>  
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								With/Without Pallet 
						</label>
				        <div class="col-sm-4">
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status1" value="1" <?=($edit_record->pallet_status==1)?'checked':''?> onclick="check_pallet(this.value)" <?=($mode=="Add")?'checked':''?> >With Pallet 
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet(this.value)" <?=($edit_record->pallet_status==2)?'checked':''?>>Without Pallet
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status2" value="3" onclick="check_pallet(this.value)" <?=($edit_record->pallet_status==3)?'checked':''?>> Multi Pallet
							</label>
						 </div>    
				    </div> 
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								PCS PER BOX
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="pcsperbox_new" name="pcsperbox_new" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$edit_record->pcsperbox?>"   />
				        </div>    
				    </div> 
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX WEIGHT PER BOX
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="apwigtperbox_new" name="apwigtperbox_new" placeholder="" class="form-control"  onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$edit_record->apwigtperbox?>"  /> 

				        </div>   
				    </div> 
				    <div class="pallet_calcution">
					   <div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									BOXES PER PALLET
							</label>
							<div class="col-sm-3">
							<input type="text" id="boxperplt_new" name="boxperplt_new" placeholder="" class="form-control"  value="<?=$edit_record->boxperplt?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
							</div>    
						</div> 
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									NO OF PALLET IN CONTAINER
							</label>
							<div class="col-sm-3">
							<input type="text" id="nopltcontainer_new" name="nopltcontainer_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$edit_record->nopltcontainer?>" onkeypress="return isNumber(event)"  />
							</div>    
						</div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								PALLET Weight
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="plat_weight" name="plat_weight" placeholder="" class="form-control" value="<?=$edit_record->plat_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div> 
				   </div> 
				   <div class="multipallet_calcution" style="display:none">
					   <div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									BOXES PER BIG PALLET
							</label>
							<div class="col-sm-3">
									<input type="text" id="box_per_big_plt" name="box_per_big_plt" placeholder="" class="form-control"  value="<?=$edit_record->box_per_big_plt?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
							</div>    
						</div> 
						 <div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									BOXES PER SMALL PALLET
							</label>
							<div class="col-sm-3">
								<input type="text" id="box_per_small_plt_new" name="box_per_small_plt_new" placeholder="" class="form-control"  value="<?=$edit_record->box_per_small_plt_new?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
							</div>    
						</div> 
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									NO OF BIG PALLET IN CONTAINER
							</label>
							<div class="col-sm-3">
								<input type="text" id="no_big_plt_container_new" name="no_big_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$edit_record->no_big_plt_container_new?>" onkeypress="return isNumber(event)"  />
							</div>    
						</div> 
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									NO OF SMALL PALLET IN CONTAINER
							</label>
							<div class="col-sm-3">
								<input type="text" id="no_small_plt_container_new" name="no_small_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="<?=$edit_record->no_small_plt_container_new?>" onkeypress="return isNumber(event)"  />
							</div>    
						</div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								BIG PALLET Weight
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="big_plat_weight" name="big_plat_weight" placeholder="" class="form-control" value="<?=$edit_record->big_plat_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div> 
					 <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								SMALL PALLET Weight
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="small_plat_weight" name="small_plat_weight" placeholder="" class="form-control" value="<?=$edit_record->small_plat_weight?>"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div> 
				   </div> 
					<div class="boxes_calculation" style="display:none">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									Total Boxes Per Container
							</label>
							<div class="col-sm-3">
								<input type="text" id="total_boxes" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="<?=$edit_record->total_boxes?>"   />
							</div>    
				    </div> 
					</div>
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX SQM PER BOX
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="appsqmperbox_new" name="appsqmperbox_new" placeholder="" class="form-control" value="<?=$edit_record->appsqmperbox?>" readonly />
				        <input type="hidden" id="appsqmperbox_new_cm" name="appsqmperbox_new_cm" value="<?=$edit_record->appsqmperbox?>"/>
				        </div>    
				    </div> 
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								BOXES PER CONTAINER
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="boxpercontain_new" name="boxpercontain_new" class="form-control" readonly value="<?=$edit_record->boxpercontain?>"  />
				        </div>    
				    </div> 
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX GROSS WEIGHT PER CONTIANER
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="appgrswetpercon_new" name="appgrswetpercon_new" placeholder=" " class="form-control" readonly value="<?=$edit_record->appgrswetpercon?>"/>
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX NET WEIGHT PER CONTIANER 
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="appwegtpercon_new" name="appwegtpercon_new" placeholder="" class="form-control" readonly value="<?=$edit_record->appwegtpercon?>" />
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								SQM PER CONTAINER
						</label>
				        <div class="col-sm-3">
				        <input type="text" id="sqmpercontain_new" name="sqmpercontain_new"  class="form-control" readonly value="<?=$edit_record->sqmpercontain?>"  />
				        <input type="hidden" id="sqmpercontain_new_cm" name="sqmpercontain_new_cm"  class="form-control" readonly value="<?=$edit_record->sqmpercontain_new_cm?>"  />
				        </div>    
				    </div> 
				   
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success" /> 
							<a class="btn btn-danger" href="<?=$back_url?>">Cancel</a> 
						</div>  
					</div> 	
							<input type="hidden" id="product_size_id" name="product_size_id" value="<?=$edit_record->product_size_id?>"/>				
							<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />				
							<input type="hidden" id="size_width_mm"  name="size_width_mm" value="<?=$edit_record->size_width_mm?>"   />				
							<input type="hidden" id="size_width_cm"  name="size_width_cm" value="<?=$edit_record->size_width_cm?>"/>				
							<input type="hidden" id="size_height_mm" name="size_height_mm"value="<?=$edit_record->size_height_mm?>" />				
							<input type="hidden" id="size_height_cm" name="size_height_cm"value="<?=$edit_record->size_height_cm?>" />				
				</form>
					</div>
			</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer');

 ?>
<script>
$(".select2").select2({
	width:'100%'
});
$("#hsnc_code_form").validate({
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
$("#hsnc_code_form").submit(function(event) {
	event.preventDefault();
	if(!$("#hsnc_code_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'hsnc_code/manage',
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
				    $("#hsnc_code_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'hsnc_code'; },1500);
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'calculation'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'hsnc_code'; },1500);
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
	var size_width_cmval = jQuery('input[name="size_width_cm"]').val();
    var size_height_cmval = jQuery('input[name="size_height_cm"]').val();
	var pcsperbox_newval = jQuery('input[name="pcsperbox_new"]').val();
    var apwigtperbox_newval = jQuery('input[name="apwigtperbox_new"]').val();
	var appsqmperbox_newval = size_width_mmval * size_height_mmval * pcsperbox_newval/1000000;
    var appsqmperbox_new_cmval = size_width_cmval * size_height_cmval * pcsperbox_newval/1000000;
 
	var radioValue = $("input[name='pallet_status']:checked"). val();
	if(radioValue==1)
	{
		var boxperplt_newval = jQuery('input[name="boxperplt_new"]').val();
		var nopltcontainer_newval = jQuery('input[name="nopltcontainer_new"]').val();
		var plat_weight_val = jQuery('input[name="plat_weight"]').val();
		var boxpercontain_newval = (nopltcontainer_newval * boxperplt_newval).toFixed(2);
		var sqmpercontain_newval = boxpercontain_newval * appsqmperbox_newval; 
		var sqmpercontain_newcmval = boxpercontain_newval * appsqmperbox_new_cmval; 
		var appwegtpercon_newval = boxpercontain_newval * apwigtperbox_newval;  
		var appgrswetpercon_newval = appwegtpercon_newval + (nopltcontainer_newval * plat_weight_val) ;   
    }
	else if(radioValue==2){
		var boxperplt_newval = 0.00;
		var nopltcontainer_newval = 0.00;
		var plat_weight_val = 0.00;
		jQuery('input[name="boxperplt_new"]').val(0);
		jQuery('input[name="nopltcontainer_new"]').val(0);
		var boxpercontain_newval = jQuery("#total_boxes").val();
		jQuery('input[name="plat_weight"]').val(0);
		var sqmpercontain_newval = boxpercontain_newval * appsqmperbox_newval; 
		var sqmpercontain_newcmval = boxpercontain_newval * appsqmperbox_new_cmval; 
		var appwegtpercon_newval = boxpercontain_newval * apwigtperbox_newval;  
		var appgrswetpercon_newval = appwegtpercon_newval;  
	}
	else if(radioValue==3){
		 var box_small_pallet = $("#box_per_small_plt_new").val();
		 var box_big_pallet = $("#box_per_big_plt").val();
		 var big_pallet_in_container = $("#no_big_plt_container_new").val();
		 var small_pallet_in_container = $("#no_small_plt_container_new").val();
		 var big_plat_weight = $("#big_plat_weight").val();
		 var small_plat_weight = $("#small_plat_weight").val();
		 
		 var totalboxes_per_container = parseFloat(box_small_pallet * small_pallet_in_container) + parseFloat(big_pallet_in_container * box_big_pallet)
		 var total_pallent_weight = parseFloat(small_plat_weight * small_pallet_in_container) + parseFloat(big_plat_weight * box_big_pallet)
		 
		var boxpercontain_newval = totalboxes_per_container;
		 
		var sqmpercontain_newval = boxpercontain_newval * appsqmperbox_newval; 
		var sqmpercontain_newcmval = boxpercontain_newval * appsqmperbox_new_cmval; 
		var appwegtpercon_newval = boxpercontain_newval * apwigtperbox_newval;  
		var appgrswetpercon_newval = parseFloat(appwegtpercon_newval) + parseFloat(total_pallent_weight);  
	}
     
    jQuery('input[name="appsqmperbox_new"]').val(appsqmperbox_newval.toFixed(2));
    jQuery('input[name="appsqmperbox_new_cm"]').val(appsqmperbox_new_cmval.toFixed(2));
    jQuery('input[name="boxpercontain_new"]').val(boxpercontain_newval);
    jQuery('input[name="sqmpercontain_new"]').val(sqmpercontain_newval.toFixed(2));
    jQuery('input[name="sqmpercontain_new_cm"]').val(sqmpercontain_newcmval.toFixed(2));
    jQuery('input[name="appwegtpercon_new"]').val(appwegtpercon_newval.toFixed(2));
    jQuery('input[name="appgrswetpercon_new"]').val(appgrswetpercon_newval.toFixed(2));
}

function load_product_data(productid)
{
	 $.ajax({
          type :'POST',
          url  :root+'add_product/getproductdata',
          data :{
            'productid' : productid 
          },
          success : function(msg){
             var obj=JSON.parse(msg);
			 $("#size_width_cm").val(obj.size_width_cm)
			 $("#size_width_mm").val(obj.size_width_mm)
			 $("#size_height_mm").val(obj.size_height_mm)
			 $("#size_height_cm").val(obj.size_height_cm)
             unblock_page('','');
          }
        })
}
</script>
<?php
if($mode=="Edit")
{
	echo "<script>load_product_data(".$edit_record->product_id.")</script>";
		echo "<script>check_pallet(".$edit_record->pallet_status.")</script>";

}
?>