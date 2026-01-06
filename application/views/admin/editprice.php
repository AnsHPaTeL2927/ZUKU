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
									<a href="<?=base_url().'price_calculation'?>">Price Calculator</a>
								</li>
								 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> Price </h3>
							</div>
							 
						</div>
					</div>
					<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="productprice_form" id="productprice_form">
               		
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								HSNC Code
						</label>
						<div class="col-sm-3">
							<?=$edit_record->hsnc_code?>
							<input type="hidden" id="hsnc_code" name="hsnc_code"  value="<?=$edit_record->hsnc_code?>" />
				        </div>
				    </div> 	

				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Size IN MM (Series)
						</label>
						<div class="col-sm-3">
							 	<?=$edit_record->size_type_mm?>
							<input type="hidden" id="size_width_mm" name="size_width_mm" value="<?=$edit_record->size_width_mm?>" />
							<input type="hidden" id="size_width_cm" name="size_width_cm" value="<?=$edit_record->size_width_cm?>" />
							<input type="hidden" id="size_height_mm" name="size_height_mm" value="<?=$edit_record->size_height_mm?>" />
							<input type="hidden" id="size_height_cm" readonly name="size_height_cm" value="<?=$edit_record->size_height_cm?>"  />
							<input type="hidden" name="size_type_mm" id="size_type_mm" value="<?=$edit_record->size_type_mm?>">
							<input type="hidden" name="size_type_cm" id="size_type_cm" value="<?=$edit_record->size_type_cm?>">
							<input id="seriesnew" type="hidden" name="seriesnew"  value="<?=$edit_record->series?>"  />
						</div>
						</div>
				  <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								PCS PER BOX
						</label>
				        <div class="col-sm-3">
							<?=$edit_record->pcsperbox?>
							<input type="hidden" id="pcsperbox" name="pcsperbox"  value="<?=$edit_record->pcsperbox?>"   />
				        </div>    
				    </div> 
					 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX WEIGHT PER BOX
						</label>
				        <div class="col-sm-3">
						<?=$edit_record->apwigtperbox?>
							<input type="hidden" id="apwigtperbox_new" name="apwigtperbox_new" value="<?=$edit_record->apwigtperbox?>"  /> 

				        </div>   
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								BOXES PER PALLET
								
						</label>
				        <div class="col-sm-3">
							<?=$edit_record->boxperplt?>
							<input type="hidden" id="boxperplt_new" name="boxperplt_new"  value="<?=$edit_record->boxperplt?>"  />
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								NO OF PALLET IN CONTAINER
						</label>
				        <div class="col-sm-3">
							<?=$edit_record->nopltcontainer?>
								<input type="hidden" id="nopltcontainer_new" name="nopltcontainer_new"  value="<?=$edit_record->nopltcontainer?>" />
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Empty  PALLET WEIGHT
						</label>
				        <div class="col-sm-3">
							<?=$edit_record->plat_weight?>
								<input type="hidden" id="plat_weight" name="plat_weight"  value="<?=$edit_record->plat_weight?>"  />
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX SQM PER BOX
						</label>
				        <div class="col-sm-3">
						<?=$edit_record->appsqmperbox?>
				        <input type="hidden" id="appsqmperbox_new" name="appsqmperbox_new"  value="<?=$edit_record->appsqmperbox?>" />
				        <input type="hidden" id="appsqmperbox_new_cm" name="appsqmperbox_new_cm" value="<?=$edit_record->appsqmperbox_new_cm?>"/>
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX GROSS WEIGHT PER CONTIANER
						</label>
				        <div class="col-sm-3">
							<?=$edit_record->appgrswetpercon?>
				        <input type="hidden" id="appgrswetpercon_new" name="appgrswetpercon_new"  value="<?=$edit_record->appgrswetpercon?>"/>
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								APPROX NET WEIGHT PER CONTIANER 
						</label>
				        <div class="col-sm-3">
							<?=$edit_record->appwegtpercon?>
							<input type="hidden" id="appwegtpercon_new" name="appwegtpercon_new" placeholder="" class="form-control" readonly value="<?=$edit_record->appwegtpercon?>" />
							
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								SQM PER CONTAINER
						</label>
				        <div class="col-sm-3">
						<?=$edit_record->sqmpercontain?>
				        <input type="hidden" id="sqmpercontain_new" name="sqmpercontain_new"  class="form-control" readonly value="<?=$edit_record->sqmpercontain?>"  />
				        <input type="hidden" id="sqmpercontain_new_cm" name="sqmpercontain_new_cm"  class="form-control" readonly value="<?=$edit_record->sqmpercontain_new_cm?>"  />
				        </div>    
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								BOXES PER CONTAINER
						</label>
				        <div class="col-sm-3">
						<?=$edit_record->boxpercontain?>
				        <input type="hidden" id="boxpercontain_new" name="boxpercontain_new" class="form-control" readonly value="<?=$edit_record->boxpercontain?>"  />
				        </div>    
				    </div> 
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Price 
						</label>
				        <div class="col-sm-3">
							<input type="text" name="priceperbox" id="priceperbox" class="form-control" onkeypress="return isNumber(event)" value="<?=$edit_record->priceperbox?>" />
				        </div>    
				    </div> 
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Price per 
						</label>
				        <div class="col-sm-3">
							<select class="form-control" name="price_type" id="price_type" onchange="price_cal(this.value)" required title="Select Price Per">
								<option value="">Select Price per</option>
								<?php
								$select ='';
								$select1 ='';
								$select2 ='';
								if($edit_record->pricetype=="Feet")
								{
									$select = 'selected="selected"';
								}
								else if($edit_record->pricetype=="Box")
								{
									$select1 = 'selected="selected"';
								}
								else if($edit_record->pricetype=="SQM")
								{
									$select2 = 'selected="selected"';
								}
								?>
								<option <?=$select?> value="Feet">Feet</option>
								<option <?=$select1?> value="Box">Box</option>
								<option <?=$select2?> value="SQM">SQM</option>
								</select>
				        </div>    
				    </div>
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Sqm Price In Rs 
						</label>
				        <div class="col-sm-3">
							<input type="text" value="<?=$edit_record->sqmprice?>" name="sqmprice" id="sqmprice" class="form-control"  readonly />
				        </div>    
				    </div>
						<?php 
						$usdprice=0;$europrice = 0;
						
						if($edit_record->pricetype=="Feet")
						{
							$usdprice = ($edit_record->priceperbox*10.76)/$maindetail->usd;
							$europrice = ($edit_record->priceperbox*10.76)/$maindetail->euro;
						}
						else if($edit_record->pricetype=="Box")
						{
							$usdprice = ($edit_record->priceperbox/$edit_record->appsqmperbox);
							 
							$usdprice = $usdprice/$maindetail->usd;
							$europrice = $edit_record->priceperbox/$edit_record->appsqmperbox;
							 $europrice = $europrice/$maindetail->euro;
						}
						else if($edit_record->pricetype=="SQM")
						{
							 $sqmpriceval = $edit_record->priceperbox*1;
							$usdprice = $sqmpriceval/$maindetail->usd;
							  $europrice = $sqmpriceval/$maindetail->euro;
						}
						
						
						?>
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Sqm Price In Usd
						</label>
				        <div class="col-sm-3">
							<input type="text" value="<?=number_format($usdprice, 2, '.', ' ')?>" name="sqmprice_usd" id="sqmprice_usd" class="form-control"  readonly />
				        </div>    
				    </div>
					<div class="form-group">
				        <label class="col-sm-3 control-label" for="form-field-1">
								Sqm Price In Euro
						</label>
				        <div class="col-sm-3">
							<input type="text" value="<?=number_format($europrice, 2, '.', ' ')?>" name="sqmprice_euro" id="sqmprice_euro" class="form-control"  readonly />
				        </div>    
				    </div>
				   <div class="col-md-offset-2">
				    <div class="form-group">
				    <input name="Submit" type="submit" value="Save" class="btn btn-info" /> </div>    .
				</div> 	
					<input type="hidden" id="product_size_id" name="product_size_id" value="<?=$edit_record->product_size_id?>"/>				
					<input type="hidden" id="mode" name="mode"    value="<?=$mode?>"  />				
					<input type="hidden" id="euro_price" name="euro_price" value="<?=$maindetail->euro?>"  />
					<input type="hidden" id="usd_price" name="usd_price" value="<?=$maindetail->usd?>"  />	
					<input  type="hidden" value="<?=$edit_record->appsqmperbox?>" name="appsqmperbox" id="appsqmperbox" readonly="">					
				</form>
					</div>
			</div>
		 </div>
	 </div>
 </div>
 
		 
<?php $this->view('lib/footer'); ?>
<script>
$("#productprice_form").validate({
		rules: {
			priceperbox: {
				required: true
			} 
		},
		messages: {
			priceperbox: {
				required: "Enter Price"
			} 
		}
	});
$("#productprice_form").submit(function(event) {
	event.preventDefault();
	if(!$("#productprice_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url:  root+'calculation/insertdatanew',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			    if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'price_calculation'; },1500);
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
	
</script>

  