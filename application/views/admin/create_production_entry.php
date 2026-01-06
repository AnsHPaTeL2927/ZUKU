<?php 
$this->view('lib/header'); 

// Initialize variables
$purchase_order_date = date('d.m.Y', strtotime($invoicedata->producation_date));
$purchase_order_no = $invoicedata->producation_no;
$export = $invoicedata->export_detail;
$gstno = $invoicedata->party_gst_no;
$supplier_name = $invoicedata->company_name;
$supplier_id = $invoicedata->pallet_party_id;

// Determine factory address based on mode
$factory_address = strip_tags($mode == "Add" ? $invoicedata->address : $invoicedata->factory_address);

// Reset session variables
$_SESSION['pallent_order_no'] = '';
$_SESSION['pallent_order_content'] = '';
?>  

<style>
td, th {
    border: 0.5px solid #333;
    padding: 5px;
}
.design-name {
    font-weight: bold;
    color: #000000;
    font-size: 11px;
}
</style>

<div class="main-container">
    <?php $this->view('lib/sidebar'); ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="clip-pencil"></i>
                            <a href="<?= base_url() ?>dashboard">Dashboard</a>
                        </li>
                        <li class="active">Production Entry</li>
                    </ol>
                    <div class="page-header title1">
                        <h1>View Production Entry</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding:10px;">
                        <form role="form" class="form-horizontal" action="<?= base_url('/production_entry_pdf/index/' . $invoicedata->production_mst_id) ?>" method="post" enctype="multipart/form-data" id="production_form" name="production_form">
                                <h3 style="font-weight:bold;text-align: center;">Production Entry</h3>
                                
                                <?php if ($mode == "Add") { ?>
								
							
								
<table cellspacing="0" cellpadding="0" width="100%">
    <tr style="font-size: 16px;text-align: center;"> 
        <th>SR NO</th>
        <th>DESIGN NAME</th>
        <th>SIZE</th>
        <th>PALLET</th>
        <th>BOX PER PALLET</th>
        <th>TOTAL BOX</th>
        <th>PRODUCED BOX</th>
      <!--  <th>BOX DIFFERENCE</th>-->
     <!--   <th>BATCH NO</th>
        <th>SHADE NO</th>-->
        <!--<th>ACTION</th>-->
    </tr>

    <?php 
    $design_array = [];
    foreach ($packing_data as $categoryll) {
        // Store each row separately (no grouping overwrite)
        $design_array[] = [
            'production_trn_id'   => $categoryll->production_trn_id,
            'model_name'          => $categoryll->model_name,
            'finish_name'         => $categoryll->finish_name,
            'size_type_cm'        => $categoryll->size_type_cm,
            'size_type_mm'        => $categoryll->size_type_mm,
            'no_of_pallet'        => $categoryll->no_of_pallet,
            'boxes_per_pallet'    => $categoryll->boxes_per_pallet,
            'no_of_boxes'         => $categoryll->no_of_boxes,
            'big_pallet'          => $categoryll->no_of_big_pallet,
            'small_pallet'        => $categoryll->no_of_small_pallet,
            'box_per_big_pallet'  => $categoryll->box_per_big_pallet,
            'box_per_small_pallet'=> $categoryll->box_per_small_pallet,
            'product_id'          => $categoryll->product_id,
            'pallet_type_id'      => $categoryll->pallet_type_id
        ];
    }

    $no = 1;
    foreach ($design_array as $data) { ?>
        <tr>
            <!-- Hidden Fields -->
            <input type="hidden" name="entry_id" value="<?= $invoicedata->create_production_id ?>">
            <input type="hidden" name="performa_invoice_id" value="<?= $invoicedata->performa_invoice_id ?>">
            <input type="hidden" name="production_mst_id" value="<?= $invoicedata->production_mst_id ?>">
            <input type="hidden" name="product_size_id" value="<?= $invoicedata->product_size_id ?>">

            <input type="hidden" name="production_trn_id[]" value="<?= $data['production_trn_id'] ?>">
            <input type="hidden" name="product_name[]" value="<?= $data['size_type_mm'] ?>">
            <input type="hidden" name="design_name[]" value="<?= $data['model_name'] ?>">
            <input type="hidden" name="finish_name[]" value="<?= $data['finish_name'] ?>">
            <input type="hidden" name="size_type_mm[]" value="<?= $data['size_type_mm'] ?>">
            <input type="hidden" name="size_type_cm[]" value="<?= $data['size_type_cm'] ?>">
            <input type="hidden" name="product_id[]" value="<?= $data['product_id'] ?>">
            <input type="hidden" name="boxes_per_pallet[]" value="<?= $data['boxes_per_pallet'] ?>">
            <input type="hidden" name="no_of_big_pallet[]" value="<?= $data['big_pallet'] ?>">
            <input type="hidden" name="no_of_small_pallet[]" value="<?= $data['small_pallet'] ?>">
            <input type="hidden" name="box_per_big_pallet[]" value="<?= $data['box_per_big_pallet'] ?>">
            <input type="hidden" name="box_per_small_pallet[]" value="<?= $data['box_per_small_pallet'] ?>">
            <input type="hidden" name="pallet_type[]" value="<?= $data['pallet_type_id'] ?>">

            <!-- Display Data -->
            <td style="text-align:center;"><?= $no ?></td>
            <td style="text-align:center;" class="design-name"><?= $data['model_name'] ?></td>
            <td style="text-align:center;"><?= $data['size_type_cm'] ?></td>

            <!-- Editable PALLET Column -->
            <td style="text-align:center;">
                <input type="number" step="any" min="0" name="manual_pallet[]" class="form-control"
                       value="<?= $data['no_of_pallet'] > 0 ? $data['no_of_pallet'] : ($data['big_pallet'] + $data['small_pallet']) ?>" readonly >
                <input type="hidden" name="default_pallet[]" value="<?= $data['no_of_pallet'] ?>">
            </td>

            <!-- BOX PER PALLET (Display only) -->
            <td style="text-align:center;">
                <?= $data['no_of_pallet'] > 0
                    ? $data['boxes_per_pallet']
                    : 'Big: ' . $data['box_per_big_pallet'] . '<br>Small: ' . $data['box_per_small_pallet'] . '<br>Total: ' . ($data['box_per_big_pallet'] + $data['box_per_small_pallet']) ?>
            </td>

            <!-- Editable TOTAL BOX Column -->
            <td style="text-align:center;">
                <input type="number" step="any" min="0" name="manual_total_box[]" class="form-control"
                       value="<?= $data['no_of_boxes'] ?>" readonly>
                <input type="hidden" name="default_total_box[]" value="<?= $data['no_of_boxes'] ?>">
            </td>

            <!-- Remaining Columns -->
            <td style="text-align:center;">
                <input type="text" name="available_box[]" class="form-control" value="<?= $data['no_of_boxes'] ?>">
            </td>
          <!--  <td style="text-align:center;">
                <input type="text" name="difference[]" class="form-control" value="" readonly>
            </td>-->
           <!-- <td style="text-align:center;">
                <input type="text" name="batchnproduction[]" class="form-control" value="">
            </td>
            <td style="text-align:center;">
                <input type="text" name="shadenproduction[]" class="form-control" value="">
            </td>-->
          <!--  <td style="text-align:center;">
                <button type="button" class="btn btn-sm btn-primary add-extra-row">+</button>
            </td>-->
        </tr>
    <?php $no++; } ?>

    <tr> 
        <td style="text-align:center;" colspan="11">
            <button type="submit" name="submit" class="btn btn-success">Save</button>
            <a href="<?= base_url('production_detail') ?>" class="btn btn-danger">Cancel</a>
        </td>
    </tr>
</table>

								
								  <!-- Modal -->
                            <div class="modal fade" id="addDesignModal" tabindex="-1" role="dialog" aria-labelledby="addDesignModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addDesignModalLabel">Add Design Row</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="designForm">
                                                <div class="form-group">
                                                    <label for="designSelect">Select Design</label>
                                                    <select id="designSelect" name="design_id" class="form-control">
                                                        <?php foreach ($designs as $design): ?>
                                                            <option value="<?= $design->id ?>" data-boxes="<?= $design->total_boxes ?>" data-pallets="<?= $design->total_pallets ?>">
                                                                <?= $design->name ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="designBoxes">Total Boxes</label>
                                                    <input type="number" class="form-control" id="designBoxes" name="total_boxes" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="designPallets">Total Pallets</label>
                                                    <input type="number" class="form-control" id="designPallets" name="total_pallets" readonly>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="addDesignBtn">Add Design</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
							
                                <?php }
								else if($mode == "Edit")
										{
										?>
									<table cellspacing="0" cellpadding="0" width="100%">
    <tr style="font-size: 16px;text-align: center;"> 
        <th>SR NO</th>  <?=var_dump($packing_data)?> 
        <th>Design Name</th>
        <th>Size</th>
        <th>PALLET</th>
        <th>TOTAL BOX</th>
        <th>PRODUCED BOX</th>
        <th>BOX DIFFRENCE</th>
     <!--   <th>BATCH NO</th>
        <th>SHADE NO</th>-->
    </tr>
 
    <?php $no = 1; foreach ($packing_data as $categoryll): ?>
    <tr>
        <!-- Hidden Fields -->
		<input type="hidden" name="entry_id[]" value="<?= $categoryll->create_production_id?>" />

        <input type="hidden" name="production_trn_id" value="<?= $categoryll->production_trn_id?>">
        <input type="hidden" name="performa_invoice_id" value="<?= $invoicedata->performa_invoice_id ?>">
        <input type="hidden" name="production_mst_id" value="<?= $invoicedata->production_mst_id ?>">
        <input type="hidden" name="product_size_id" value="<?= $invoicedata->product_size_id ?>">

        <input type="hidden" name="product_name[]" value="<?= $categoryll->product_name ?>">
        <input type="hidden" name="design_name[]" value="<?= $categoryll->design_name ?>">
        <input type="hidden" name="finish_name[]" value="<?= $categoryll->finish_name ?>">
        <input type="hidden" name="size_type_mm[]" value="<?= $categoryll->size_type_mm ?>">
        <input type="hidden" name="size_type_cm[]" value="<?= $categoryll->size_type_cm ?>">
        <input type="hidden" name="product_id[]" value="<?= $categoryll->product_id ?>">
        <input type="hidden" name="no_of_pallet[]" value="<?= $categoryll->no_of_pallet ?>">
        <input type="hidden" name="no_of_boxes[]" value="<?= $categoryll->no_of_boxes ?>">
        <input type="hidden" name="no_of_big_pallet[]" value="<?= $categoryll->no_of_big_pallet ?>">
        <input type="hidden" name="no_of_small_pallet[]" value="<?= $categoryll->no_of_small_pallet ?>">
        <input type="hidden" name="boxes_per_pallet[]" value="<?= $categoryll->boxes_per_pallet ?>">
        <input type="hidden" name="box_per_big_pallet[]" value="<?= $categoryll->box_per_big_pallet ?>">
        <input type="hidden" name="box_per_small_pallet[]" value="<?= $categoryll->box_per_small_pallet ?>">
        <input type="hidden" name="pallet_type[]" value="<?= $categoryll->pallet_type_id ?>">

        <!-- Display Fields -->
        <td style="text-align:center;"><?= $no ?></td>
        <td style="text-align:center;"><?= $categoryll->design_name ?></td>
        <td style="text-align:center;"><?= $categoryll->product_name ?></td>
		
	  <!-- Editable PALLET Column -->
            <td style="text-align:center;">
                <input type="number" step="any" min="0" name="manual_pallet[]" class="form-control"
                       value="<?= $categoryll->no_of_pallet > 0 ? $categoryll->no_of_pallet : ($categoryll->no_of_big_pallet + $categoryll->no_of_small_pallet) ?>">
                <input type="hidden" name="default_pallet[]" value="<?=$categoryll->no_of_pallet?>">
            </td>

            <!-- Editable TOTAL BOX Column -->
            <td style="text-align:center;">
                <input type="number" step="any" min="0" name="manual_total_box[]" class="form-control"
                       value="<?= $categoryll->no_of_boxes ?>">
                <input type="hidden" name="default_total_box[]" value="<?= $categoryll->no_of_boxes ?>">
            </td>

      
        <td style="text-align:center;"><input type="text" name="available_box[]" class="form-control" value="<?= $categoryll->available_box ?>"></td>
        <td style="text-align:center;"><input type="text" name="difference[]" class="form-control" value="<?= $categoryll->difference ?>" readonly></td>
       <!-- <td style="text-align:center;"><input type="text" name="batchnproduction[]" class="form-control" value="<?= $categoryll->batchnproduction ?>"></td>
        <td style="text-align:center;"><input type="text" name="shadenproduction[]" class="form-control" value="<?= $categoryll->shadenproduction ?>"></td>-->
    </tr>

    <!-- Show Extra Inputs Conditionally -->
    <?php if (!empty($categoryll->extra_batch1) || !empty($categoryll->extra_shade1)): ?>
    <tr>
        <td colspan="3" style="text-align:right;"><strong>Extra Pallet and Box (a)</strong></td>
        <td style="text-align:center;"><input type="text" name="extra_pallet1[]" class="form-control" value="<?= $categoryll->extra_pallet1 ?>"></td>
        <td style="text-align:center;"><input type="text" name="extra_total_box1[]" class="form-control" value="<?= $categoryll->extra_total_box1 ?>"></td>
        <td></td>
         <td style="text-align:right;"><strong>Extra Batch and Shade (a)</strong></td>
        <td style="text-align:center;" ><input type="text" name="extra_batch1[]" class="form-control" value="<?= $categoryll->extra_batch1 ?>"></td>
        <td style="text-align:center;" ><input type="text" name="extra_shade1[]" class="form-control" value="<?= $categoryll->extra_shade1 ?>"></td>
    </tr>
    <?php endif; ?>

    <?php if (!empty($categoryll->extra_batch2) || !empty($categoryll->extra_shade2)): ?>
    <tr>
        <td colspan="3" style="text-align:right;"><strong>Extra Pallet and Box (b)</strong></td>
        <td style="text-align:center;"><input type="text" name="extra_pallet2[]" class="form-control" value="<?= $categoryll->extra_pallet2 ?>"></td>
        <td style="text-align:center;"><input type="text" name="extra_total_box2[]" class="form-control" value="<?= $categoryll->extra_total_box2 ?>"></td>
        <td></td>
        <td style="text-align:right;"><strong>Extra Batch and Shade (b)</strong></td>
        <td style="text-align:center;"><input type="text" name="extra_batch2[]" class="form-control" value="<?= $categoryll->extra_batch2 ?>"></td>
        <td style="text-align:center;"><input type="text" name="extra_shade2[]" class="form-control" value="<?= $categoryll->extra_shade2 ?>"></td>
    </tr>
    <?php endif; ?>

    <?php $no++; endforeach; ?>

    <tr> 
        <td style="text-align:center;" colspan="9">
            <button type="submit" name="submit" class="btn btn-success">Save</button>
            <a href="<?= base_url('production_detail') ?>" class="btn btn-danger">Cancel</a>
        </td>
    </tr>
</table>
										
										<?php 
										}
										?>
                                
                                <input type="hidden" name="production_mst_id" value="<?= $invoicedata->production_mst_id ?>">
                                <input type="hidden" name="mode" value="<?= $mode ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('lib/footer'); ?>
<div id="productmodal1" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Sample</h4>
            </div>
			 <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="sample_add" id="sample_add">
				
				 <input type="hidden" name="performa_invoice_id" value="<?= $invoicedata->performa_invoice_id ?>">
                  <input type="hidden" name="production_mst_id" value="<?= $invoicedata->production_mst_id ?>">
				 
					<div class="modal-body">
				<div class="row">	
					<div class="form-group col-md-6">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		  Select Product
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" id="product_id" name="product_id" onchange="load_packing(this.value)">
								<option value="">Select Product Name</option>
								<?php
								for($p=0;$p<count($allproduct);$p++)
								{
									$thickness = (!empty($allproduct[$p]->thickness))?" - ".$allproduct[$p]->thickness." MM":"";
								 ?>
									<option value="<?=$allproduct[$p]->product_id?>"><?=$allproduct[$p]->size_type_mm.' ('.$allproduct[$p]->series_name.')'.$thickness?></option>
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
				 <div class="col-md-6 form-group">
				  <label class="col-sm-12 control-label" for="remark">
					Remark
				  </label>
				  <div class="col-sm-12">
					<textarea placeholder="Enter Remark" id="remark" class="form-control" name="sampleremark" rows="3"></textarea>
				  </div>
				</div>
 
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-extra-row').forEach(function (button) {
        button.addEventListener('click', function () {
            const currentRow = this.closest('tr');
            const tbody = currentRow.parentElement;
            
            // Find the exact index by checking against all main rows that have the add-extra-row button
            const allMainRows = Array.from(tbody.querySelectorAll('tr')).filter(row => 
                row.querySelector('.add-extra-row') !== null
            );
            const currentRowIndex = allMainRows.indexOf(currentRow);
            
            const limit = 2;

            const existingExtraRows = Array.from(tbody.querySelectorAll('.extra-for-' + currentRowIndex));
            if (existingExtraRows.length >= limit) {
                alert('Maximum 2 extra rows allowed per design.');
                return;
            }

            const designName = currentRow.querySelector('.design-name')?.innerText?.trim() || '';
            const rowNumber = existingExtraRows.length + 1;

            const newRow = document.createElement('tr');
            newRow.classList.add('extra-batch-shade-row', 'extra-for-' + currentRowIndex);
            newRow.setAttribute('data-main-row-index', currentRowIndex);

            // SR NO (empty)
            newRow.appendChild(document.createElement('td'));

            // Design Name (empty)
            newRow.appendChild(document.createElement('td'));

            // Size (empty)
            newRow.appendChild(document.createElement('td'));

            // Extra Pallet
            const palletTd = document.createElement('td');
            const palletInput = document.createElement('input');
            palletInput.type = 'number';
            palletInput.name = `extra_pallet${rowNumber}[]`;
            palletInput.className = 'form-control';
            palletInput.placeholder = 'Extra Pallet';
            palletTd.appendChild(palletInput);
            newRow.appendChild(palletTd);

            // Box Per Pallet (empty)
            newRow.appendChild(document.createElement('td'));

            // Total Box (empty)
            newRow.appendChild(document.createElement('td'));

            // Produced Box (Extra Total Box moved here)
            const producedBoxTd = document.createElement('td');
            const producedBoxInput = document.createElement('input');
            producedBoxInput.type = 'number';
            producedBoxInput.name = `extra_total_box${rowNumber}[]`;
            producedBoxInput.className = 'form-control extra-produced-box';
            producedBoxInput.placeholder = 'Extra Produced Box';
            producedBoxInput.setAttribute('data-main-row-index', currentRowIndex);
            producedBoxTd.appendChild(producedBoxInput);
            newRow.appendChild(producedBoxTd);

            // Box Difference (empty)
            newRow.appendChild(document.createElement('td'));

            // Extra Batch No
            const batchTd = document.createElement('td');
            const batchInput = document.createElement('input');
            batchInput.type = 'text';
            batchInput.name = `extra_batch${rowNumber}[]`;
            batchInput.className = 'form-control';
            batchInput.placeholder = 'Extra Batch No';
            batchTd.appendChild(batchInput);
            newRow.appendChild(batchTd);

            // Extra Shade No
            const shadeTd = document.createElement('td');
            const shadeInput = document.createElement('input');
            shadeInput.type = 'text';
            shadeInput.name = `extra_shade${rowNumber}[]`;
            shadeInput.className = 'form-control';
            shadeInput.placeholder = 'Extra Shade No';
            shadeTd.appendChild(shadeInput);
            newRow.appendChild(shadeTd);

            // Action column (empty)
            newRow.appendChild(document.createElement('td'));

            // Hidden design name field
            const hiddenDesign = document.createElement('input');
            hiddenDesign.type = 'hidden';
            hiddenDesign.name = `extra_design${rowNumber}[]`;
            hiddenDesign.value = designName;
            newRow.appendChild(hiddenDesign);

            // Insert new row below last extra or current row
            let insertAfterRow = currentRow;
            if (existingExtraRows.length > 0) {
                insertAfterRow = existingExtraRows[existingExtraRows.length - 1];
            }
            insertAfterRow.insertAdjacentElement('afterend', newRow);

            // Add event listener for the new extra produced box input
            producedBoxInput.addEventListener('input', function() {
                const mainRowIndex = parseInt(this.getAttribute('data-main-row-index'));
                // Use jQuery to call the function since it's defined in the jQuery scope
                $(document).trigger('recalculateDifference', [mainRowIndex]);
            });
        });
    });
});

 $("#production_form").submit(function(event) {
	event.preventDefault();
	if(!$("#production_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'create_production_entry/manage',
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
				   $("#production_form").trigger('reset');
				   
					unblock_page("success","Sucessfully Inserted.");
					//location.reload();
					setTimeout(function(){ window.location=root+'manage_pallet/index/'+obj.production_mst_id ; },1500);
			 
			   }
			   else if(obj.res==2)
			   {
				   $("#production_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'manage_pallet/index/'+obj.production_mst_id ; },1500);
			 
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


$("#sample_add").submit(function (event) {
    event.preventDefault();

    if (!$("#sample_add").valid()) return false;

    block_page();

    var form = $(this)[0];
    var postData = new FormData(form);

    // Ensure names are updated
    var nameFields = {
        product_name: $('#product_id option:selected').text(),
        packing_name: $('#packing_id option:selected').text(),
        design_name: $('#design_id option:selected').text(),
        finish_name: $('#finish_id option:selected').text()
    };

    for (var key in nameFields) {
        postData.append(key, nameFields[key]);
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

$(document).ready(function () {
    $("#production_form").validate();
    
    function getExtraProducedBoxTotal(mainRowIndex) {
        let total = 0;
        $('.extra-produced-box[data-main-row-index="' + mainRowIndex + '"]').each(function() {
            const value = parseFloat($(this).val()) || 0;
            total += value;
        });
        return total;
    }
    
    function calculateDifference(index) {
        const available = parseFloat($("input[name='available_box[]']").eq(index).val()) || 0;
        const mainProducedBox = parseFloat($("input[name='manual_total_box[]']").eq(index).val()) || 0;
        const extraProducedTotal = getExtraProducedBoxTotal(index);
        const targetTotal = available + extraProducedTotal;
        const difference = mainProducedBox - targetTotal;
        $("input[name='difference[]']").eq(index).val(difference);
    }
    
    $(document).on('recalculateDifference', function(event, mainRowIndex) {
        calculateDifference(mainRowIndex);
    });
    
    function calculateTotalBoxes(index) {
        const palletCount = parseFloat($("input[name='manual_pallet[]']").eq(index).val()) || 0;
        const boxPerPallet = parseFloat($("input[name='boxes_per_pallet[]']").eq(index).val()) || 0;
        const bigBox = parseFloat($("input[name='box_per_big_pallet[]']").eq(index).val()) || 0;
        const smallBox = parseFloat($("input[name='box_per_small_pallet[]']").eq(index).val()) || 0;
        const totalBoxPerPallet = (boxPerPallet > 0) ? boxPerPallet : (bigBox + smallBox);
        const totalBoxes = palletCount * totalBoxPerPallet;
        $("input[name='manual_total_box[]']").eq(index).val(totalBoxes.toFixed(0));
        calculateDifference(index);
    }
    
    $("input[name='manual_pallet[]']").on('input', function () {
        const index = $("input[name='manual_pallet[]']").index(this);
        calculateTotalBoxes(index);
    });
    
    $("input[name='available_box[]']").on('input', function () {
        const index = $("input[name='available_box[]']").index(this);
        calculateDifference(index);
    });
    
    $("input[name='manual_total_box[]']").on('input', function () {
        const index = $("input[name='manual_total_box[]']").index(this);
        calculateDifference(index);
    });
    
    $(document).on('input', '.extra-produced-box', function() {
        const mainRowIndex = parseInt($(this).attr('data-main-row-index'));
        if (!isNaN(mainRowIndex)) {
            calculateDifference(mainRowIndex);
        }
    });
});


function deleteProductionEntry(id) {
    if (confirm("Are you sure you want to delete this production entry?")) {
        $.ajax({
            url: '<?= base_url("create_production_entry/delete_ajax") ?>',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload(); // or remove the row from the table dynamically
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function() {
                alert("Something went wrong.");
            }
        });
    }
}


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