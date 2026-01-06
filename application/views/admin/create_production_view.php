<?php 
 $this->view('lib/header'); 
  
 $purchase_order_date = date('d.m.Y',strtotime($producation_mst->producation_date));
 $purchase_order_no =$producation_mst->producation_no;
 $export =  ($invoicedata->exporter_detail);
  
 $supplier_name = $invoicedata->party_name;
 $supplier_address = ($invoicedata->supplier_detail);
 $factory_name = ($invoicedata->factory);
 $factory_address = strip_tags($invoicedata->factory_address);
 $exporter_Address				= $company_detail->s_name."&#13;&#10;".strip_tags($company_detail->s_address)."&#13;&#10;";
 $pallet_type = ($invoicedata->pallet_type_name);
  
  $_SESSION['pallent_order_no'] = '';
  $_SESSION['pallent_order_content'] = '';
?>	
<style>
td {
    border: 0.5px solid #333;
    padding: 5px;
}
th{
	border: 0.5px solid #333;
    padding: 5px;
}
</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"pallent_order/viewpdf", '_blank');
	}
	else{
		window.location= root+"pallent_order/viewpdf";
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
									<a href="<?=base_url().'producation_detail'?>">Production Sheet</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
							<h1>View Pallet Packing Planning</h1>
				
							 <div class="pull-right form-group">
											<h4>
											<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productmodal1" data-keyboard="false" data-backdrop="static">+ Add Product </button>-->
												<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
												 
												</h4> 
										</div>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
								<div class="" style="padding:10px;" >
    						
                                    <?php ob_start(); ?>
                                    <h2 style="font-weight:bold;text-align: center;">Pallet Packing Planning</h2>
                                
  <table border="1" cellspacing="0" cellpadding="5" width="100%"
       style="border-collapse: collapse; text-align:center; font-size:16px;">

    <!-- PO HEADER -->
    <tr>
        <td colspan="3"><strong>PO NO</strong></td>
        <td colspan="2"><strong><?= $purchase_order_no ?></strong></td>
        <td colspan="2"><strong>PO DATE</strong></td>
        <td colspan="3"><strong><?= $purchase_order_date ?></strong></td>
    </tr>

    <!-- TABLE HEAD -->
    <tr>
    <th style="text-align:center;background-color:#DAEEF3;">Sr No</th>
    <th style="text-align:center;background-color:#DAEEF3;">Size</th>
    <th style="text-align:center;background-color:#DAEEF3;">Design</th>
    <th style="text-align:center;background-color:#DAEEF3;">Finish</th>
    <th style="text-align:center;background-color:#DAEEF3;">Box/Pallets</th>
    <th style="text-align:center;background-color:#DAEEF3;">Pallets</th>
    <th style="text-align:center;background-color:#DAEEF3;">Box</th>
    <th style="text-align:center;background-color:#DAEEF3;">SQM</th>
    <th style="text-align:center;background-color:#DAEEF3;">Batch No</th>
    <th style="text-align:center;background-color:#DAEEF3;">Location</th>
    </tr>

<?php
$srno = 1;
$total_pallets = 0;
$total_boxes   = 0;
$total_sqm   = 0;
?>

<?php foreach ($product_data as $r): ?>

<?php
// Pallet calculation for totals
$pallet_count = (!empty($r->no_of_pallet) && $r->no_of_pallet > 0)
    ? (int)$r->no_of_pallet
    : ((int)$r->no_of_big_pallet + (int)$r->no_of_small_pallet);

$total_pallets += $pallet_count;
$total_boxes   += (int)$r->no_of_boxes;
$total_sqm   += (int)$r->no_of_sqm;
?>

<tr style="text-align:center; <?= !empty($r->parent_trn_id) ? 'background-color:#FFF7CC;' : '' ?>">

    <td><?= $srno++; ?></td>

    <td><?= $r->size_type_mm ?></td>

    <td><?= $r->model_name ?></td>

    <td><?= $r->finish_name ?></td>

    <!-- BOX / PALLET -->
 <td>
<?php if (!empty($r->no_of_pallet) && $r->no_of_pallet > 0) {

    $boxes_val = (!empty($r->trnboxes_per_pallet) && $r->trnboxes_per_pallet != 0)
        ? $r->trnboxes_per_pallet
        : $r->boxes_per_pallet;
?>
    <?= $boxes_val ?>

<?php } else {

    $big_val = ($r->trnbox_per_big_pallet !== null && $r->trnbox_per_big_pallet !== '')
        ? (int)$r->trnbox_per_big_pallet
        : (int)$r->box_per_big_pallet;

    $small_val = ($r->trnbox_per_small_pallet !== null && $r->trnbox_per_small_pallet !== '')
        ? (int)$r->trnbox_per_small_pallet
        : (int)$r->box_per_small_pallet;

    // ✅ SPECIAL CASE: small is explicitly 0
    if ($r->trnbox_per_small_pallet !== null && (int)$r->trnbox_per_small_pallet === 0) {
        echo ($big_val + $small_val); // effectively only big
    } else {
        echo $big_val . '<br>' . $small_val;
    }

} ?>
</td>



    <!-- PALLETS -->
   <td>
		<?php
		if (!empty($r->no_of_pallet) && $r->no_of_pallet > 0) { ?>

			<?= (int)$r->no_of_pallet ?>

		<?php } else {

			$big   = (int)$r->no_of_big_pallet;
			$small = (int)$r->no_of_small_pallet;

			// If any one is 0 → show sum
			if ($big == 0 || $small == 0) {
				echo ($big + $small);
			} else {
				echo $big . '<br>' . $small;
			}

		} ?>
		</td>


    <!-- TOTAL BOX -->
    <td><?= $r->no_of_boxes ?></td>

    <!-- SQM -->
    <td><?= $r->no_of_sqm ?></td>

    <td><?= $r->pro_batch ?></td>

    <td><?= $r->pro_shade ?></td>

</tr>

<?php endforeach; ?>

<!-- TOTAL ROW -->
<tr style="font-weight:bold;text-align:center;background-color:#DAEEF3;" >
    <td colspan="5" style="text-align:right;">TOTAL</td>
    <td><?= $total_pallets ?></td>
    <td><?= $total_boxes ?></td>
    <td><?= $total_sqm ?></td>
    <td colspan="2"></td>
</tr>

</table>



                                
                                    <?php
                                    $output = ob_get_contents();
                                    $_SESSION['pallent_order_no'] = $invoicedata->purchase_order_no;
                                    $_SESSION['pallent_order_content'] = $output;
                                    if ($mode == "1") {
                                        echo "<script>view_pdf(0)</script>";
                                    }
                                    ?>
                                </div>

							 
						</div>
					 									
							 	
								</div>
							 </div>
				</div>
			</div>
		</div>
			
  <div id="productmodal1" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Product</h4>
            </div>
			 <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="sample_add" id="sample_add">
				
				 <input type="hidden" name="performa_invoice_id" value="<?= $invoicedata->performa_invoice_id ?>">
                  <input type="hidden" name="production_mst_id" value="<?= $invoicedata->production_mst_id ?>">
				 
					<div class="modal-body">
				<div class="row">	
				<div class="form-group col-md-6">
    <label class="col-sm-12 control-label" for="form-field-1">Select Product</label>
    <div class="col-sm-12">
        <select class="select2" id="product_id" name="product_id" onchange="load_packing(this.value)">
            <option value="">Select Product Name</option>
            <?php
            for ($p = 0; $p < count($allproduct); $p++) {
                $thickness = (!empty($allproduct[$p]->thickness)) ? " - " . $allproduct[$p]->thickness . " MM" : "";
            ?>
                <option value="<?= $allproduct[$p]->product_id ?>"
                        data-size="<?= $allproduct[$p]->size_type_mm ?>">
                    <?= $allproduct[$p]->size_type_mm . ' (' . $allproduct[$p]->series_name . ')' . $thickness ?>
                </option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

				 <div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Select Packing
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="packing_id" name="packing_id" onchange="load_design(this.value)">
								<option value="">Select Packing Name</option>
						 </select>
				 	</div>
				 </div>
				  <div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Select Design
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="design_id" name="design_id" onchange="load_finish(this.value)">
								<option value="">Select Design Name</option>
						 </select>
				 	</div>
				 </div>
				  <div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Select Finish
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="finish_id" name="finish_id" onchange="load_finish(this.value)">
								<option value="">Select Finish</option>
						 </select>
				 	</div>
				 </div>
				 <div class="col-md-6 form-group single_con">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Pallet
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Pallet" id="no_of_pallet" class="form-control" name="no_of_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)">
				 	</div>
				 </div>   
				  <div class="col-md-6 form-group multi_con" style="display:none">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		Big Pallet
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Big Pallet" id="no_of_big_pallet" class="form-control" name="no_of_big_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)">
				 	</div>
				 </div>  
				  <div class="col-md-6 form-group multi_con" style="display:none">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		Small Pallet
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Small Pallet" id="no_of_small_pallet" class="form-control" name="no_of_small_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)" >
				 	</div>
				 </div>
				<div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Boxes
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Boxes" id="boxes" class="form-control" name="boxes" value=""  >
				 	</div>
				 </div>  
				<!--<div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Weight Per Box
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder=" Weight Per Box" id="weightperbox" class="form-control" name="weightperbox" value=""  >
				 	</div>
				 </div> 
				  <div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Client Name
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder=" Client Name" id="clientname" class="form-control" name="clientname" value=""  >
				 	</div>
				 </div> --> 	
				<div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Batch
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Batch No" id="batch_no" class="form-control" name="batch_no" value=""  >
				 	</div>
				 </div> 
				<div class="col-md-6 form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		Shade
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Shade No" id="shade_no" class="form-control" name="shade_no" value=""  >
				 	</div>
				 </div>
				 <!--<div class="col-md-6 form-group">
				  <label class="col-sm-12 control-label" for="remark">
					Remark
				  </label>
				  <div class="col-sm-12">
					<textarea placeholder="Enter Remark" id="remark" class="form-control" name="sampleremark" rows="3"></textarea>
				  </div>
				</div>-->
 
					</div> 					
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="total_no_of_sqm" id="total_no_of_sqm" value="" />
			<input type="hidden" name="net_weight" id="net_weight" value="" />
			<input type="hidden" name="gross_weight" id="gross_weight" value="" />
			<input type="hidden" name="pallet_status" id="pallet_status" value="" />
			<input type="hidden" name="sqm_per_box" id="sqm_per_box" value="" />
			<input type="hidden" name="pcs_per_box" id="pcs_per_box" value="" />
			<input type="hidden" name="weight_per_box" id="weight_per_box" value="" />
			<input type="hidden" name="pallet_weight" id="pallet_weight" value="" />
			<input type="hidden" name="big_pallet_weight" id="big_pallet_weight" value="" />
			<input type="hidden" name="small_pallet_weight" id="small_pallet_weight" value="" />
			<input type="hidden" name="boxes_per_pallet" id="boxes_per_pallet" value="" />
			<input type="hidden" name="big_boxes_per_pallet" id="big_boxes_per_pallet" value="" />
			<input type="hidden" name="small_boxes_per_pallet" id="small_boxes_per_pallet" value="" />
			
			<input type="hidden" name="new_container_no" id="new_container_no" value="" />
		 	<input type="hidden" name="new_seal_no" id="new_seal_no" value="" />
			<input type="hidden" name="rfidseal_no" id="rfidseal_no" value="" />
			
			<input type="hidden" name="new_booking_no" id="new_booking_no" value="" />
			<input type="hidden" name="new_lr_no" id="new_lr_no" value="" />
			<input type="hidden" name="new_truck_no" id="new_truck_no" value="" />
			<input type="hidden" name="new_remark" id="new_remark" value="" />
			<input type="hidden" name="new_tare_weight" id="new_tare_weight" value="" />
			 
			<input type="hidden" name="new_container_size" id="new_container_size" value="" />			 
			<input type="hidden" name="new_container" id="new_container" value="" />			 
			<input type="hidden" name="new_con_entry" id="new_con_entry" value="" />			 
			 
			</form>
        </div>
    </div>
</div>

<?php $this->view('lib/footer'); ?>
<script>

$("#sample_add").submit(function (event) {
    event.preventDefault();

    if (!$("#sample_add").valid()) return false;

    block_page();

    var form = $(this)[0];
    var postData = new FormData(form);

    // Extract values to be sent
    var nameFields = {
        product_name: $('#product_id option:selected').data('size'), // size_type_mm
        packing_name: $('#packing_id option:selected').text(),
        design_name: $('#design_id option:selected').text(),
        finish_name: $('#finish_id option:selected').text()
    };

    // Append custom name fields to postData
    for (var key in nameFields) {
        if (nameFields[key]) {
            postData.append(key, nameFields[key]);
        }
    }

    $.ajax({
        type: "post",
        url: root + 'create_production_entry/manage1',
        data: postData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (responseData) {
            $("#sample_add").trigger("reset");
            $("#product_id, #packing_id, #design_id, #finish_id").val("").trigger("change");
            $("#productmodal").modal("hide");
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
});


function load_packing(product_id)
{
	block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/load_packing',
              data: {
                "product_id" : product_id 
              }, 
              cache: false, 
              success: function (data) { 
				   $("#packing_id").html(data);
						unblock_page('',"")
              }
			});
}

$("#wallproduct_form").submit(function(event) {
	event.preventDefault();
	if(!$("#wallproduct_form").valid())
	{
		return false;
	}
 	 	var inps = document.getElementsByName('product_rate[]');
	
	 
	for(var i = 0; i <inps.length; i++) 
	{
	 
	 	if(inps[i].value <=0 && inps[i].readOnly == false) 
		{
			toastr["error"]("Please enter rate.");
				inps[i].value = '';
				inps[i].focus();
			return false;
		}
	}
	 
	block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url:  root+'exportinvoice/container_manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				 
				 
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ location.reload(); },1000);
		    },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function load_design(product_size_id)
{
	block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/load_design',
              data: {
                "product_size_id" : product_size_id 
              }, 
              cache: false, 
              success: function (data) 
			  { 
					var obj = JSON.parse(data);
					if(obj.packing.boxes_per_pallet > 0)
					{
						$("#pallet_status").val(1);
						$(".single_con").show();
					}
					else if(obj.packing.box_per_big_plt > 0 || obj.packing.box_per_small_plt_new > 0)
					{
						$("#pallet_status").val(3);
						$(".single_con").hide();
						$(".multi_con").show();
					}
					else 
					{
						$("#pallet_status").val(2);
						$(".single_con").hide();
						$(".multi_con").hide();
					}
					$("#pallet_weight").val(obj.packing.pallet_weight)
			 		$("#sqm_per_box").val(obj.packing.sqm_per_box)
					$("#pcs_per_box").val(obj.packing.pcs_per_box)
					$("#weight_per_box").val(obj.packing.weight_per_box)
					$("#small_pallet_weight").val(obj.packing.small_plat_weight)
					$("#big_pallet_weight").val(obj.packing.big_plat_weight)
					$("#boxes_per_pallet").val(obj.packing.boxes_per_pallet)
					$("#big_boxes_per_pallet").val(obj.packing.box_per_big_plt)
					$("#small_boxes_per_pallet").val(obj.packing.box_per_small_plt_new)
				    $("#design_id").html(obj.design_html);
						unblock_page('',"")
              }
			});
}
function load_finish(design_id)
{
	block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/load_finish_data",
		data: {
			"id": design_id 
		}, 
		success: function (response)
		{
			var obj = JSON.parse(response);
				$("#finish_id").html(obj.html);
				 unblock_page("",""); 
		}
		
	}); 
}
function cal_sqm(no)
{
	
	
	 var radioValue = $("#pallet_status").val();
	  
	  if(radioValue==1)
	 {
		
		var sqm_per_box 			= $('#sqm_per_box').val();
		var boxes_per_pallet 		= $('#boxes_per_pallet').val();
		if(no == 2)
		{
			if($('#no_of_pallet').val() != undefined && $('#no_of_pallet').val() != "" )
			{
				var no_of_pallet 			= $('#no_of_pallet').val();
			 	var no_of_boxes 			= $('#no_of_pallet').val() * boxes_per_pallet;
			 	$('#boxes').val(no_of_boxes);
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#total_no_of_sqm').val(no_of_sqm.toFixed(2));
				var net_weight = parseFloat(no_of_boxes) * $('#weight_per_box').val();
				$('#net_weight').val(net_weight.toFixed(2));
				var pallet_weight = $('#pallet_weight').val();
				var total_pallet_weight = parseFloat(pallet_weight) * parseFloat(no_of_pallet);
				$('#gross_weight').val(parseFloat(net_weight) + parseFloat(total_pallet_weight))
		  	}
		}
		else if(no == 1)
		{
			var no_of_pallet 			= $('#no_of_pallet').val();
			var no_of_boxes  = $('#boxes').val();
			var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#total_no_of_sqm').val(no_of_sqm.toFixed(2));
			var net_weight = parseFloat(no_of_boxes) * $('#weight_per_box').val();
			$('#net_weight').val(net_weight.toFixed(2));
			var pallet_weight = $('#pallet_weight').val();
			var total_pallet_weight = parseFloat(pallet_weight) * parseFloat(no_of_pallet);
			$('#gross_weight').val(parseFloat(net_weight) + parseFloat(total_pallet_weight))
		}
	 }
	 else if(radioValue==2)
	 {
		 var weight_per_box = $('#weight_per_box').val();
		 var sqm_per_box 	= $('#sqm_per_box').val();
		  
		 
			if($('#only_no_of_boxes').val() != undefined && $('#only_no_of_boxes').val() != "")
			{
				var no_of_boxes = $("#only_no_of_boxes").val();
				var rate_usd_val = $('#product_rate').val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm').val(no_of_sqm.toFixed(2));
				
				var product_total_amount = rate_usd_val * no_of_sqm;
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
			 	$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
	 	 	}
	 } 
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box').val();
		 var box_per_big_pallet 	= $('#big_boxes_per_pallet').val();
		 var box_per_small_pallet 	= $('#small_boxes_per_pallet').val();
		 var big_pallet_weight 		= $('#big_pallet_weight').val();
		 var small_pallet_weight 	= $('#small_pallet_weight').val();
		 var sqm_per_box 			= $('#sqm_per_box').val();
	 	 var no_of_big_pallet 		= ($('#no_of_big_pallet').val() > 0)?$('#no_of_big_pallet').val():0;
		 var no_of_small_pallet 	= ($('#no_of_small_pallet').val() > 0)?$('#no_of_small_pallet').val():0;
		  
		 var total_pallet 			= parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
		 var no_of_big_boxes 		= no_of_big_pallet * box_per_big_pallet;
		 var no_of_small_boxes 		= no_of_small_pallet * box_per_small_pallet;
		 var no_of_boxes 			= parseFloat(no_of_big_boxes) + parseFloat(no_of_small_boxes);
		  
		 $('#boxes').val(no_of_boxes.toFixed(2));
		 var no_of_sqm 				= no_of_boxes * sqm_per_box;
		 $('#total_no_of_sqm').val(no_of_sqm.toFixed(2));
		 var big_palletweight 		= no_of_big_pallet * big_pallet_weight;
		 var small_palletweight 	= no_of_small_pallet * small_pallet_weight;
		 var palletweight 			= parseFloat(big_palletweight)+parseFloat(small_palletweight);
		 var packing_net_weight 	= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
		 
		 $('#net_weight').val(packing_net_weight.toFixed(2));
		 $('#gross_weight').val(packing_gross_weight.toFixed(2));
		 	 
	  }
}
closeNav();
$(".select2").select2({
	 width:"100%"
});
function close_modal()
{
	 location.reload();
}
function cal_product_invoice(val,no)
{
	
	 var radioValue = $("#pallet_status"+val).val();
    
	 if(radioValue==1)
	 {
		
		var sqm_per_box 		= $('#sqm_per_box'+val).val();
		var boxes_per_pallet 		= $('#boxes_per_pallet'+val).val();
		
			if($('#no_of_pallet'+val).val() != undefined && $('#no_of_pallet'+val).val() != "" )
			{
				 var no_of_pallet 			= $('#no_of_pallet'+val).val();
			 	 var no_of_boxes 			= $('#no_of_pallet'+val).val() * boxes_per_pallet;
			 	 $('#no_of_boxes'+val).val(no_of_boxes.toFixed(2));
				 var no_of_sqm = no_of_boxes * sqm_per_box;
				 $('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				 $('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
				  var product_rate = $('#product_rate'+val).val();
  		 
				 var product_amt = no_of_sqm * product_rate;
			 
				$('#product_amt'+val).val(product_amt.toFixed(2));
				$('#product_amt_html'+val).html(product_amt.toFixed(2));
		  	}
	 }
	 else if(radioValue==2)
	 {
		 var weight_per_box = $('#weight_per_box'+val).val();
		 var sqm_per_box 	= $('#sqm_per_box'+val).val();
		  
		 
			if($('#only_no_of_boxes'+val).val() != undefined && $('#only_no_of_boxes'+val).val() != "")
			{
				var no_of_boxes = $("#only_no_of_boxes"+val).val();
				var rate_usd_val = $('#product_rate'+val).val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				var product_total_amount = rate_usd_val * no_of_sqm;
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
			 	$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
	 	 	}
	 } 
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box'+val).val();
		 var box_per_big_pallet 	= $('#box_per_big_pallet'+val).val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet'+val).val();
		 var big_pallet_weight 		= $('#big_pallet_weight'+val).val();
		 var small_pallet_weight 	= $('#small_pallet_weight'+val).val();
		 var sqm_per_box = $('#sqm_per_box'+val).val();
		 
		 	if($('#no_of_big_pallet'+val).val() != undefined && $('#no_of_big_pallet'+val).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+val).val();
				var no_of_big_pallet = $('#no_of_big_pallet'+val).val();
				var no_of_small_pallet = $('#no_of_small_pallet'+val).val();
				
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+val).val(no_of_boxes.toFixed(2));
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				var product_total_amount = rate_usd_val * no_of_sqm;
				
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				
				var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
		 	}
	  }
}
function cal_box_invoice(val,no)
{
	
	var radioValue = $("#pallet_status"+val).val();
    var sqm_per_box = $('#sqm_per_box'+val).val();
    var product_rate = $('#product_rate'+val).val();
  		 
	 if(radioValue==1)
	 {
		 if(no == 2)
		 {
			 var no_of_pallet 	= $('#no_of_pallet'+val).val();
			 var boxes_per_pallet 	= $('#boxes_per_pallet'+val).val();
			 $('#no_of_boxes'+val).val(parseFloat(no_of_pallet * boxes_per_pallet));
		 }			 
			var no_of_boxes = $('#no_of_boxes'+val).val();
			var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
			$('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
			
			var product_amt = no_of_sqm * product_rate;
			 
			$('#product_amt'+val).val(product_amt.toFixed(2));
			$('#product_amt_html'+val).html(product_amt.toFixed(2));
				
	 }
	  if(radioValue==2)
	 {
		  
		var no_of_boxes = $('#no_of_boxes'+val).val();
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		$('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
		
			var product_amt = no_of_sqm * product_rate;
			$('#product_amt'+val).val(product_amt.toFixed(2));
			$('#product_amt_html'+val).html(product_amt.toFixed(2));
	 }
	 else if(radioValue==3)
	 {
		 if(no == 2)
		 {
			var big_pallet 	= $('#no_of_big_pallet'+val).val();
			var small_pallet 	= $('#no_of_small_pallet'+val).val();
			var box_per_big_pallet = $('#box_per_big_pallet'+val).val();
			var box_per_small_pallet = $('#box_per_small_pallet'+val).val();
 
			$('#no_of_boxes'+val).val(parseFloat(big_pallet * box_per_big_pallet) + parseFloat(small_pallet * box_per_small_pallet));
		 }
		var no_of_boxes = $('#no_of_boxes'+val).val();
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		$('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
			
			var product_amt = no_of_sqm * product_rate;
			$('#product_amt'+val).val(product_amt.toFixed(2));
			$('#product_amt_html'+val).html(product_amt.toFixed(2));
		 
	 }
}

$(document).ready(function() {
    $("#production_form").validate();

    $("input[name='available_box[]']").on('input', function() {
        var index = $("input[name='available_box[]']").index(this);

        var available = parseFloat($(this).val()) || 0;
        var noofboxes = parseFloat($("input[name='no_of_boxes[]']").eq(index).val()) || 0;
        var boxesPerPallet = parseFloat($("input[name='boxes_per_pallet[]']").eq(index).val()) || 0;
        var bigPerPallet = parseFloat($("input[name='box_per_big_pallet[]']").eq(index).val()) || 0;
        var smallPerPallet = parseFloat($("input[name='box_per_small_pallet[]']").eq(index).val()) || 0;

        var totalBoxesPerPallet = bigPerPallet + smallPerPallet;
        var boxesToCompare = boxesPerPallet > 0 ? boxesPerPallet : totalBoxesPerPallet;

        var difference = noofboxes - available;
        $("input[name='difference[]']").eq(index).val(difference);
    });
});

document.getElementById('designSelect').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    document.getElementById('designBoxes').value = selected.getAttribute('data-boxes');
    document.getElementById('designPallets').value = selected.getAttribute('data-pallets');
});

document.getElementById('addDesignBtn').addEventListener('click', function () {
    const designId = document.getElementById('designSelect').value;
    const designName = document.getElementById('designSelect').options[document.getElementById('designSelect').selectedIndex].text;
    const totalBoxes = document.getElementById('designBoxes').value;
    const totalPallets = document.getElementById('designPallets').value;

    // Example logic to add row (you'll adapt this to your table)
    const tableBody = document.querySelector('table tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${designName}</td>
        <td>${totalBoxes}</td>
        <td>${totalPallets}</td>
    `;
    tableBody.appendChild(row);

    $('#addDesignModal').modal('hide');
});
</script>