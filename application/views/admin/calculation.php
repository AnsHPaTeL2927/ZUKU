<?php 
$this->view('lib/header'); 
?>	
<div class="main-container">
	<?php 
		$this->view('lib/sidebar'); 
	?>
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
							Company Details
						</li>
				 	</ol>
					
					<div class="page-header title1">
									<h3>Calculation Details  </h3>
									<strong id="succecssmsg" style="color:green"></strong>
									<div class="pull-right form-group" style="margin-top:-40px;">

										<div class="pull-right">
										
											<a href="<?php echo base_url('Model_list/index/'); ?>"  type="button" class="btn btn-primary">
												Design
											</a>
											 <a href="<?php echo base_url('Product_list/index/'); ?>"  type="button" class="btn btn-primary">
												Size
											</a>
											<a href="<?php echo base_url('Finish_list/index/'); ?>"  type="button" class="btn btn-primary">
												Finish
											</a>
											 <a href="<?php echo base_url('Series_list/index/'); ?>"  type="button" class="btn btn-primary">
												Product
											</a>
										</div>
									</div>
							</div>
				 
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								</div>
							<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>HSNC CODE</th>
													<th>SIZE IN MM (SERIES)</th>
													<th>PACKING NAME</th>
													<th>PCS PER BOX</th>
													<th>WEIGHT PER BOX</th>
													<th>SQM PER BOX</th>
													<th>NET WEIGHT PER CONTIANER</th>
													<th>GROSS WEIGHT PER CONTIANER</th>
												 	<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											for($i=0;$i<count($result);$i++)
											{
												$net_weight_container 		= 0;
												$gross_weight_container 		= 0;
												 
												if($result[$i]->boxes_per_pallet > 0)
												{
													$net_weight_container = $result[$i]->pallet_net_weight_per_container;
													$gross_weight_container = $result[$i]->pallet_gross_weight_per_container;
												}
												else if($result[$i]->total_boxes>0)
												{
													$net_weight_container = $result[$i]->withoutnet_weight_per_container;
													$gross_weight_container = $result[$i]->withoutgross_weight_per_container;
												}
												else if($result[$i]->box_per_big_plt>0 || result[$i]->box_per_small_plt_new > 0)
												{
													$net_weight_container = $result[$i]->multi_net_weight_container;
													$gross_weight_container = $result[$i]->multi_gross_weight_container;
												}
											?>
												<tr>
													<td><?=$result[$i]->hsnc_code?></td>
													<td><?=$result[$i]->size_type_mm.' ('.$result[$i]->series_name.')'?></td>
													<td><?=$result[$i]->product_packing_name?></td>
													<td><?=$result[$i]->pcs_per_box?></td>
													<td><?=$result[$i]->weight_per_box?></td>
													<td><?=$result[$i]->sqm_per_box?></td>
													<td><?=$net_weight_container	?></td>
													<td><?=$gross_weight_container?></td>
													 
													<td>
													 <a class="tooltips btn btn-info" href="javascript:;" data-title="Calculation"  onclick="do_calc(<?=$result[$i]->product_size_id?>,<?=$result[$i]->hsnc_code?>)" ><i class="fa fa-calculator" aria-hidden="true"></i> Calculation</a>
													</td>
												</tr>
										<?php } ?>
											</tbody>
										</table>
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
<div id="çalculation_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Calculation</h4>
            </div>
            <div class="modal-body">
				 
					<div id="responsehtml"></div>
				  
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
 function price_calaculation()
{
	
	var factory_price = $("#facory_rate").val();
	
	if(factory_price>0)
	{
		 
		var pallet_charges  = 0;
		var total_sqm  = 0;
		if($("#tab1").hasClass("active"))
		{
			pallet_charges 	= ($("#pallet_charges").val() > 0)?$("#pallet_charges").val():0;
		 	total_sqm 		= $("#sqm_per_container").val();
		}
		else if($("#tab2").hasClass("active"))
		{
			total_sqm	 	= $("#withoutpallet_sqm_per_container").val();
		}
		else if($("#tab3").hasClass("active"))
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
		
		var  usd_price 			= ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
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
	 
	 
 	var total_feet = 0
 	var total_box = 0
 	var total_box = 0
 	var total_sqm = 0
 	var total_pcs = 0
	if($("#tab1").hasClass("active"))
	{  
		 total_feet = parseFloat($("#feet_per_box").val()) * parseFloat($("#box_per_container").val());
		 total_box  =  parseFloat($("#box_per_container").val());
		 total_sqm  = parseFloat($("#sqm_per_container").val());
		 total_pcs  =  $("#pcs_per_box").val() * parseFloat($("#box_per_container").val());
		
	}
	else if($("#tab2").hasClass("active"))
	{ 
		 total_feet = parseFloat($("#feet_per_box").val()) * parseFloat($("#total_boxes").val());
		 total_box  =  parseFloat($("#total_boxes").val());
		 total_sqm  = parseFloat($("#withoutpallet_sqm_per_container").val());
		 total_pcs  =  $("#pcs_per_box").val() * parseFloat($("#total_boxes").val());
	}
	else if($("#tab3").hasClass("active"))
	{ 
		 total_feet = 	parseFloat($("#feet_per_box").val()) * parseFloat($("#multi_box_per_container").val());
		 total_box  =  	parseFloat($("#multi_box_per_container").val());
		 total_sqm  = 	parseFloat($("#multi_sqm_per_container").val());
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

$(document).ready(function () {
	 closeNav();
			$('#sample-table-1').DataTable({
			   "order": [[ 0, "asc" ]],
			    "lengthMenu": [ 50, 10, 25, 75, 100 ]
			});
		});
$(".select2").select2({
	width:'100%'
});
function delete_record(product_size_id)
{
	main_delete(product_size_id,'calculation/deleterecord','calculation')
}
function do_calc(id,hsnc_code)
{
	block_page();
	$.ajax({ 
              type: "POST", 
              url: root+'calculation/displaydatanew',
              data: {
                "id": id,
				"hsnc_code":hsnc_code
              }, 
              cache: false, 
              success: function (data) { 
				$("#çalculation_modal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
				 $("#responsehtml").html(data)
				 $("#invoice_currency_id").select2({
						width			: '100%',
					 });
					 get_exchange_rate($("#invoice_currency_id").val())
				 unblock_page("","")
              }
			});
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
    $("#sqm_per_box").val(sqm_per_box);
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
</script>