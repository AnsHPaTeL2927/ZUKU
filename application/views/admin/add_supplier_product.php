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
									<a href="<?=base_url().'supplier_list'?>">Supplier List</a>
									
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								<?=$supplier_detail->company_name?> - <?=$supplier_detail->supplier_name?>  
								<?php 
								if(count($alreadyadded)!=0)
								{
								?>
									<a href="javascript:;" onclick="open_section()" style="float:right;" type="button" class="btn btn-info btn-squared">
									+ Product  
								</a>
								<?php }?>
							</h3>
							
							</div>
							 
						</div>
					</div>
					<div class="product_section">
					<?php 
								if(count($alreadyadded)!=0)
								{
								?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="sample-table-1">
								<thead>
									<tr>
										<th>
											<button class="btn btn-info tooltips" data-toggle="tooltip" data-title="Get Estimate" onclick="create_quotation()"> Get Estimate</button>
										</th>
										<th >Product Name</th>
										<th >Size</th>
										<th >Packing Name</th>
										<th >Pcs Per Box </th>
										<th >Weight Per Box </th>
										<th >SQM Per Box </th>
										<th >Feet Per Box </th>
										<th >Total Box</th>
										<th >Total SQM</th>
									 	<th >Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$alreadyadded_array = array();
								for($i=0; $i<count($alreadyadded);$i++)
								{
									array_push($alreadyadded_array,$alreadyadded[$i]->product_id);
									 $thickness = (!empty($alreadyadded[$i]->thickness))?" - ".$alreadyadded[$i]->thickness."MM":"";
								 ?>
									<tr>
										<td>
											<input type="checkbox" name="productsize_id[]" id="productsize_id<?=$alreadyadded[$i]->product_size_id?>" value="<?=$alreadyadded[$i]->product_size_id?>" style="width: 30px;" class="form-control"/>
										</td>
										<td>
											<?=$alreadyadded[$i]->series_name?>
										</td>
									 	<td><?=$alreadyadded[$i]->size_type_mm.$thickness?></td>
									 	<td><?=$alreadyadded[$i]->product_packing_name?></td>
									 	<td><?=$alreadyadded[$i]->pcs_per_box?></td>
										<td><?=$alreadyadded[$i]->weight_per_box?></td>
										<td><?=$alreadyadded[$i]->sqm_per_box?></td>
										<td><?=$alreadyadded[$i]->feet_per_box?></td>
										<td>
										<?php
											if($alreadyadded[$i]->box_per_container>0)
											{
												echo $alreadyadded[$i]->box_per_container;
											}
											else if($alreadyadded[$i]->total_boxes>0)
											{
												echo $alreadyadded[$i]->total_boxes;
											}
											else if($alreadyadded[$i]->multi_box_per_container>0)
											{
												echo $alreadyadded[$i]->multi_box_per_container;
											}
											?>
										</td>
										<td>
										 
											<?php
											if($alreadyadded[$i]->sqm_per_container>0)
											{
												echo $alreadyadded[$i]->sqm_per_container;
											}
											else if($alreadyadded[$i]->withoutpallet_sqm_per_container>0)
											{
												echo $alreadyadded[$i]->withoutpallet_sqm_per_container;
											}
											else if($alreadyadded[$i]->multi_sqm_per_container>0)
											{
												echo $alreadyadded[$i]->multi_sqm_per_container;
											}
											?>
										 </td>
										<td>
											<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
													<span class="caret"></span></button>
														  <ul class="dropdown-menu">
															 
															<li>
																<a class="tooltips" data-title="Get Estimate" href="<?=base_url().'add_supplier_product/getsupilerestimate/'.$alreadyadded[$i]->product_size_id?>" ><i class="fa fa-money"></i> Get Estimate</a>
															</li>
															 <li>
																<a class="tooltips" data-title="Send In WhatsUp" href="javascript:;" onclick="send_msg_modal(<?=$alreadyadded[$i]->product_size_id?>)"><i class="fa fa-whatsapp"></i> Send In Whats Up</a>
															</li> 
															 
														   </ul>
														</div>
										 
										</td>
										
									</tr>
							<?php
								$m++;
								} 
							?>
										</tbody>
									</table>
								</div>
						
								<?php 
								}
								?>						
					</div>
					
					<div class="selectproduct_section" style="<?=(count($alreadyadded)==0)?"":"display:none"?>">
					<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="supplierproduct_form" id="supplierproduct_form">
						<label id="product_id[]-error" class="error" for="product_id[]"></label>
               		<?php 
					
					 
					for($p=0;$p<count($allproduct);$p++)
					{
						$checked = '';
						 if(in_array($allproduct[$p]->product_id,$alreadyadded_array))
						 {
							 $checked = 'checked';
						 }
						 $thickness = (!empty($allproduct[$p]->thickness))?" - ".$allproduct[$p]->thickness." MM":"";
					?>
					<div class="form-group col-md-6">
				        <label class="col-sm-2 control-label" for="form-field-1">
								<input <?=$checked?> type="checkbox" id="product_id<?=$p?>" name="product_id[]"  value="<?=$allproduct[$p]->product_id?>" class="form-control" required title="Select Product Size"/>
								<input type="hidden" name="product_size_id[]" id="product_size_id<?=$p?>" value="<?=$allproduct[$p]->product_id?>" />
						</label>
						<div class="col-sm-10" style="margin-top:7px;">
							<?=$allproduct[$p]->series_name.'<br> ('.$allproduct[$p]->size_type_mm.$thickness.')'?>
				        </div>
				    </div> 
						 		
						<?php
							 
							}?>
				 <div class="col-md-12" style="height:50px;"></div>
				   	<div class="col-md-offset-2">
				    <div class="form-group col-md-12">
						<input name="Submit" type="submit" value="Save" class="btn btn-success" />
							<a href="<?=base_url().'supplier_list'?>" class="btn btn-danger">
											Cancel
										</a>						
					</div>    	
				</div> 	
					<input type="hidden" id="supplier_id" name="supplier_id" value="<?=$supplier_detail->supplier_id?>"/>				
					<input type="hidden" id="mode" name="mode"  value="<?=$mode?>"  />				
				</form>
					
					</div>
					</div>
			</div>
		 </div>
	 </div>
 </div>
<?php 
$this->view('lib/footer');
$this->view('lib/addseries');
?>
<div id="sms_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send SMS <span id="size_html"></span></h4>
            </div>
            <div class="modal-body" style="">
			<div class="row ">
							<div class="form-group col-md-6">
									<label class="col-sm-3 control-label" for="form-field-1">
												Terms of Delivery
										</label>
									<div class="col-sm-4">
														<select name="terms_id" id="terms_id" class="form-control">
															<?php 
															foreach($termsdata as $terms)
															{ 
															
																echo "<option   value='".$terms->terms_name."'>".$terms->terms_name."</option>";
															} ?>
														</select>
														
									</div>
									<div class="col-sm-4">
										<input type="text" placeholder="Terms of Delivery " style="font-weight:bold;" id="terms_of_delivery"  class="form-control" name="terms_of_delivery" value="<?=($company_detail[0]->terms_of_delivery)?>" >
									</div>
									</div>
				<div class="getsmshtml"> </div>
				</div>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="Send_sms()">Send</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="hidden" id="currentserices" name="currentserices"/> 
            </div>
        </div>
    </div>
</div>

<script>
 function get_exchange_rate(code)
 { 
  block_page();
	$.getJSON("https://api.exchangerate-api.com/v4/latest/"+code, function(e) {
		$(".currency_code").html(code);
		$("#exchange_rate").val(e.rates.INR);
		allcalculation();
		price_calaculation();
		unblock_page("","");
	});
 }
$(document).ready(function () {
	$('#sample-table-1').DataTable({
		 "ordering": false,
	   "lengthMenu": [ 50, 10, 25, 75, 100 ]
	});
});
function create_quotation()
{
	var product_size_id = [];
	$. each($("input[name='productsize_id[]']:checked"), function(){
		 product_size_id.push($(this).val());
	});
	
	 window.location=root+'add_supplier_product/getsupilerestimate/'+product_size_id.join('-');
 	 
}
 
function send_msg_modal(product_size_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_supplier_product/fetchseriesdata",
              data: {
						"product_size_id": product_size_id
					}, 
              success: function (response) 
			  { 
				   var obj = JSON.parse(response);
				  
				   $("#sms_modal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#size_html").html(obj.size);
					$(".getsmshtml").html(obj.html);
					$("#invoice_currency_id").select2({
						width			: '100%',
					 })
					check_pallet_status(obj.pallet_status)
				 	unblock_page("",""); 
               }
              
          }); 
	
}
function check_pallet_status(val)
 {
	 if(val==1)
	 {
	 	$(".multi_pallet_calcution").hide();
		$(".boxes_calculation").hide();
	 	$(".pallet_calcution").show();
	 	 
	 }
	 else if(val==2)
	 {
	 	$(".pallet_calcution").hide();
	 	$(".multi_pallet_calcution").hide();
	 	$(".boxes_calculation").show();
	  
	}
	else if(val == 3)
	{
		$(".pallet_calcution").hide();
	 	$(".boxes_calculation").hide();
	 	$(".multi_pallet_calcution").show();
 
	}
	 
 }
function open_section()
{
	$(".selectproduct_section").toggle();
	$(".product_section").toggle();
}
$("#supplierproduct_form").validate({
		rules: {
			supplier_id: {
				required: true
			} 
		},
		messages: {
			supplier_id: {
				required: "Enter Name"
			} 
		}
	});
$("#supplierproduct_form").submit(function(event) {
	event.preventDefault();
	if(!$("#supplierproduct_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'Add_supplier_product/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    
				$(".loader").hide();
			   if(responseData==1)
			   {
				    $("#supplierproduct_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'add_supplier_product/index/<?=$supplier_detail->supplier_id?>'; },1500);
				}
				 
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'add_supplier_product/index/<?=$supplier_detail->supplier_id?>'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 

 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
function delete_record(deleleid)
{
	main_delete(deleleid,'Add_supplier_product/deleterecord','add_supplier_product/index/<?=$supplier_detail->supplier_id?>')
}
function allcalculation()
{
	var size_width_mmval = $('#size_width_mm').val();
    var size_height_mmval = $('#size_height_mm').val();
 
    var pcs_per_box 	= $('#pcs_per_box').val();
    var weight_per_box 	= $('#weight_per_box').val();
	var sqm_per_box 	= size_width_mmval * size_height_mmval * pcs_per_box/1000000;
	$("#sqm_per_box").val(sqm_per_box);
    var feet_per_box 	= sqm_per_box * 10.7639;
    $('#feet_per_box').val(parseFloat(feet_per_box).toFixed(2));
	
	var radioValue = $("input[name='pallet_status']:checked"). val();
	if(radioValue==1)
	{
		var boxes_per_pallet = $('#boxes_per_pallet').val();
		var total_pallent_container = $('#total_pallent_container').val();
		var pallet_weight = $('#pallet_weight').val();
		var box_per_container = parseFloat(boxes_per_pallet) * parseFloat(total_pallent_container);
		$('#box_per_container').val(box_per_container);
		var sqm_per_container = box_per_container * sqm_per_box; 
		
		var pallet_net_weight_per_container = parseFloat(weight_per_box) * parseFloat(box_per_container); 
		var total_pallet_weight  = parseFloat(pallet_weight) * parseFloat(total_pallent_container); 
		var pallet_gross_weight_per_container = parseFloat(pallet_net_weight_per_container) + parseFloat(total_pallet_weight); 
	
	    $('#sqm_per_container').val(sqm_per_container.toFixed(2));
		$("#pallet_net_weight_per_container").val(pallet_net_weight_per_container.toFixed(2));
		$("#pallet_gross_weight_per_container").val(pallet_gross_weight_per_container.toFixed(2));
    }
	else if(radioValue==2)
	{
		 
		var total_box_container = $("#total_boxes").val();
	 	var sqm_per_container = total_box_container * sqm_per_box; 
	    $('#sqm_per_container').val(sqm_per_container.toFixed(2));
		 
    }
	else if(radioValue==3)
	{
			var box_per_big_pallet = ($("#box_per_big_pallet").val()>0)?$("#box_per_big_pallet").val():0;
			var box_per_small_pallet = ($("#box_per_small_pallet").val()>0)?$("#box_per_small_pallet").val():0;
			
			var big_pallent_container = ($("#big_pallent_container").val()>0)?$("#big_pallent_container").val():0;
			var small_pallent_container = ($("#small_pallent_container").val()>0)?$("#small_pallent_container").val():0;
			var big_pallet_weight = ($("#big_pallet_weight").val()>0)?$("#big_pallet_weight").val():0;
			var small_pallet_weight = ($("#small_pallet_weight").val()>0)?$("#small_pallet_weight").val():0;
			var big_box 	= box_per_big_pallet * big_pallent_container;
			var small_box = box_per_small_pallet * small_pallent_container;
			
			
			var total_big_pallet_contaier_weight = parseFloat(big_box) * parseFloat(weight_per_box);
			var total_small_pallet_contaier_weight = parseFloat(small_box) * parseFloat(weight_per_box);
			var multi_net_weight_container =  parseFloat(total_big_pallet_contaier_weight) + parseFloat(total_small_pallet_contaier_weight);
			
		 	
			var multi_gross_weight_container = parseFloat(multi_net_weight_container) + parseFloat(total_big_pallet_contaier_weight) + parseFloat(total_small_pallet_contaier_weight);
			var multi_box_per_container = parseFloat(big_box) + parseFloat(small_box);
			var multi_sqm_per_container = multi_box_per_container * sqm_per_box;
	
			$("#multi_box_per_container").val(multi_box_per_container.toFixed(2));
			$("#multi_gross_weight_container").val(multi_gross_weight_container.toFixed(2));
			$("#multi_net_weight_container").val(multi_net_weight_container.toFixed(2));
			$("#multi_sqm_per_container").val(multi_sqm_per_container.toFixed(2));
	}
}
function price_calaculation()
{
	
	var factory_price = $("#facory_rate").val();
	
	if(factory_price>0)
	{
		var radioValue = $("input[name='pallet_status']:checked"). val();
		var pallet_charges  = 0;
		var total_sqm  = 0;
		if(radioValue==1)
		{
			pallet_charges 	= ($("#pallet_charges").val() > 0)?$("#pallet_charges").val():0;
		 	total_sqm 		= $("#sqm_per_container").val();
		}
		else if(radioValue==2)
		{
			total_sqm	 	= $("#sqm_per_container").val();
		}
		else if(radioValue==3)
		{
			var big_pallet_charges 	 = ($("#big_pallet_charges").val() > 0)?$("#big_pallet_charges").val():0
			var small_pallet_charges = ($("#small_pallet_charges").val() > 0)?$("#small_pallet_charges").val():0
			
			pallet_charges  = parseFloat(big_pallet_charges) + parseFloat(small_pallet_charges);
			total_sqm	 	= $("#multi_sqm_per_container").val();
		}
		 
		var fob_expenenses = ($("#fob_expenenses").val() > 0)?$("#fob_expenenses").val():0;
		 
		var price_type 			= $("#price_type").val();
		var feet_per_box 		= $("#feet_per_box").val();
		var sqm_per_box 		= $("#sqm_per_box").val();
		var pcs_per_box 		= $("#pcs_per_box").val();
		
		var usd_price 			= ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
		var  per_box_price 		= 0; 
		var  total_price_inr 	= 0; 
		var  usd_per_box 		= 0; 
		
		if(price_type=="Feet")
		{
			per_box_price  = parseFloat(feet_per_box) * parseFloat(factory_price) 
			per_box_price = per_box_price / parseFloat(sqm_per_box);
			total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
			total_price_inr += parseFloat(pallet_charges);
			total_price_inr += parseFloat(fob_expenenses);
			
			usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		 
			usd_per_box = parseFloat(usd_per_box) / parseFloat(total_sqm);
			
			$("#total_price").val(total_price_inr.toFixed(3));
			
		}
		else if(price_type=="Box")
		{
			per_box_price = factory_price;
			per_box_price = per_box_price / parseFloat(sqm_per_box);
			total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
			total_price_inr += parseFloat(pallet_charges);
			total_price_inr += parseFloat(fob_expenenses);
		
			usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
			usd_per_box = parseFloat(usd_per_box) / parseFloat(total_sqm);
			$("#total_price").val(total_price_inr.toFixed(3));
		}
		else if(price_type=="SQM")
		{
			per_box_price = factory_price;
			total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
			total_price_inr += parseFloat(pallet_charges);
			total_price_inr += parseFloat(fob_expenenses);
			usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
			usd_per_box = parseFloat(usd_per_box) / parseFloat(total_sqm);
			$("#total_price").val(total_price_inr.toFixed(3));
		}
		else if(price_type=="PCS")
		{
			per_box_price = factory_price * parseFloat(pcs_per_box);
			total_price_inr = parseFloat(per_box_price) * parseFloat(total_sqm);
			total_price_inr += parseFloat(pallet_charges);
			total_price_inr += parseFloat(fob_expenenses);
			usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
			usd_per_box = parseFloat(usd_per_box) / parseFloat(total_sqm);
			$("#total_price").val(total_price_inr.toFixed(3));
		}
		 
		$("#usd_per_box_html").html(usd_per_box.toFixed(3));
		our_price_calaculation();
	}
}
function our_price_calaculation()
{
	var usd_price = ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
	
	var our_selling_price = $("#our_selling_price").val();
	var our_price_type 	  = $("#our_price_type").val();
	var total_price_inr   = ($("#total_price").val() > 0)?$("#total_price").val():0;
	 
	var radioValue = $("input[name='pallet_status']:checked"). val();
 	var total_feet = 0
 	var total_box = 0
 	var total_box = 0
 	var total_sqm = 0
 	var total_pcs = 0
	if(radioValue==1)
	{  
		 total_feet = parseFloat($("#feet_per_box").val()) * parseFloat($("#box_per_container").val());
		 total_box  =  parseFloat($("#box_per_container").val());
		 total_sqm  = parseFloat($("#sqm_per_container").val());
		 total_pcs  =  $("#pcs_per_box").val() * parseFloat($("#box_per_container").val());
		
	}
	else if(radioValue==2)
	{
		total_feet = parseFloat($("#feet_per_box").val()) * parseFloat($("#total_boxes").val());
		 total_box  =  parseFloat($("#total_boxes").val());
		 total_sqm  = parseFloat($("#sqm_per_container").val());
		 total_pcs  =  $("#pcs_per_box").val() * parseFloat($("#total_boxes").val());
	}
	else if(radioValue==3)
	{
		 total_feet = parseFloat($("#feet_per_box").val()) * parseFloat($("#multi_box_per_container").val());
		 total_box  =  parseFloat($("#multi_box_per_container").val());
		 total_sqm  = parseFloat($("#multi_sqm_per_container").val());
		 total_pcs  =  $("#pcs_per_box").val() * parseFloat($("#multi_box_per_container").val());
	}		
	if(our_price_type=="Feet")
	{
		
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_feet);
		$("#usd_per_box_html").html(usd_per_box.toFixed(3));
		
	 	if(our_selling_price>0)
		{
			
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_feet)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price);
			
			
			$("#profit_price").val(profilt.toFixed(3));
		}
		else
		{
			$("#profit_price").val(0);
		}
	}
	else if(our_price_type=="Box")
	{
		
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_box);
		$("#usd_per_box_html").html(usd_per_box.toFixed(3));
		 
		
		if(our_selling_price>0)
		{
			var selling_price 		 = $("#per_box_price").val();
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_box)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price);
			
			
			$("#profit_price").val(profilt.toFixed(3));
		}
		else
		{
			$("#profit_price_html").html(0);
			$("#profit_price").val(0);
		}
		 
	}
	else if(our_price_type=="SQM")
	{
		 
		
		
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_sqm);
		 
		$("#usd_per_box_html").html(usd_per_box.toFixed(3));
		 
		if(our_selling_price>0)
		{
			 
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_sqm)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			 
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price)
			 
			$("#profit_price_html").html(profilt.toFixed(3));
			$("#profit_price").val(profilt.toFixed(3));
		}
		else
		{
			$("#profit_price_html").html(0);
			$("#profit_price").val(0);
		}
		 
	}
	else if(our_price_type=="PCS")
	{
		
		usd_per_box = parseFloat(total_price_inr) / parseFloat(usd_price);
		usd_per_box = parseFloat(usd_per_box) / parseFloat(total_pcs);
		$("#usd_per_box_html").html(usd_per_box.toFixed(3));
		$("#per_box_price").val(usd_per_box.toFixed(3));
		 
		if(our_selling_price>0)
		{
			var selling_price 		 = $("#per_box_price").val();
			var our_sqm_price 		 = parseFloat(our_selling_price) * parseFloat(total_pcs)  * parseFloat(usd_price);
			var accual_selling_price = parseFloat(total_price_inr);
			var profilt 			 = parseFloat(our_sqm_price) - parseFloat(accual_selling_price)
			$("#profit_price_html").html(profilt.toFixed(3));
			$("#profit_price").val(profilt.toFixed(3));
		}
		else
		{
			 
			$("#profit_price").val(0);
		}
	}
	 
}

function add_new_serices(value,no)
{
	if(value==0) 
	{
		 $("#seriesmodal").modal({
						backdrop: 'static',
						keyboard: false
					});
		$("#currentserices").val(no)			
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
					$("#series_id"+$("#currentserices").val()).append("<option value='"+obj.id+"' selected>"+obj.series_name+"</option>");
					$("#series_id"+$("#currentserices").val()).select2("val",obj.id);
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
function Send_sms()
{
	if($("input[name='pallet_status']:checked"). val()==1)
	{
		var total_pallet = ($("#box_per_container").val() * $("#total_pallent_container").val())
		var sms_string = "*Packing Details* \n Size : "+$("#size_html").text()+" \n Pcs/Box: "+$("#pcs_per_box").val()+"  Pcs \n SQM/BOX : "+$("#sqm_per_box").val()+" \n Weight per Box :"+$("#weight_per_box").val()+"  Kg \n Box/Pallate: "+$("#box_per_container").val()+" \n Total Palate: "+total_pallet+"  \n Total Box : "+$("#box_per_container").val()+"  \n Total Sq Mtr :"+$("#sqm_per_container").val()+" \n\n\n";
		
		sms_string += " *Price*  - "+$("#terms_id").val()+" "+$("#terms_of_delivery").val()+" \n Price *"+$("#our_selling_price").val()+" USD* per "+$("#our_price_type").val()+"  - With Palate \n\n\n";
		 
		 
		 
	}
	else if($("input[name='pallet_status']:checked"). val()==2)
	{
		 
		 var sms_string = "*Packing Details* \n Size : "+$("#size_html").text()+" \n Pcs/Box: "+$("#pcs_per_box").val()+"  Pcs \n SQM/BOX : "+$("#sqm_per_box").val()+" \n Weight per Box :"+$("#weight_per_box").val()+"  Kg \n  Total Box : "+$("#total_boxes").val()+"  \n Total Sq Mtr :"+$("#sqm_per_container").val()+" \n\n\n";
		
		sms_string += " *Price*  - "+$("#terms_id").val()+" "+$("#terms_of_delivery").val()+" \n Price *"+$("#our_selling_price").val()+" USD* per "+$("#our_price_type").val()+"  - Without Palate \n\n\n";
		 
	}
	else if($("input[name='pallet_status']:checked"). val()==3)
	{
		 
		var big_pallent_container = ($("#big_pallent_container").val()>0)?$("#big_pallent_container").val():0;
		var small_pallent_container = ($("#small_pallent_container").val()>0)?$("#small_pallent_container").val():0;
			
		var sms_string = "*Packing Details* \n Size : "+$("#size_html").text()+" \n Pcs/Box: "+$("#pcs_per_box").val()+"  Pcs \n SQM/BOX : "+$("#sqm_per_box").val()+" \n Weight per Box :"+$("#weight_per_box").val()+"  Kg \n Box/ Big Pallate: "+$("#box_per_big_pallet").val()+" \n Box/Small Pallate: "+$("#box_per_small_pallet").val()+"  \n Total Big Palate: "+big_pallent_container+"  \n Total Small Palate: "+small_pallent_container+" \n Total Box : "+$("#multi_box_per_container").val()+"  \n Total Sq Mtr :"+$("#multi_sqm_per_container").val()+" \n\n\n";
		
		sms_string += " *Price*  - "+$("#terms_id").val()+" "+$("#terms_of_delivery").val()+" \n Price *"+$("#our_selling_price").val()+" USD* per "+$("#our_price_type").val()+"  - With Multi Palate \n\n\n";
		 
	}
		window.open('https://api.whatsapp.com/send?text='+encodeURIComponent(sms_string),'_blank');
	
}
function add_row(no)
{
	block_page();
	$.ajax({
            type: "post",
            url: 	root+'add_supplier_product/addrow',
            data: {"no": $("#rowcont").val()}, 
            success: function(responseData) {
              // console.log(responseData);
			   unblock_page("","") 
			   $("#smstabel").append(responseData);
			   $("#rowcont").val(parseInt($("#rowcont").val())+1);
			   $("#series_id"+$("#rowcont").val()).select2({
						width:'element',
						 formatNoMatches: function(term) {
							return "<a href='javascript:;' onclick='add_new_serices(0,1)'>Add New Consigner</a>";
						}
					})
				  
            } 
	});
}

function remove_row(no)
{
	$("#rowtr"+no).remove();
}

</script>

  