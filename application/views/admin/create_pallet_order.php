<?php 
 $this->view('lib/header'); 
  
 $purchase_order_date = date('d.m.Y',strtotime($invoicedata->producation_date));
 $purchase_order_no =$invoicedata->producation_no;
 $export =  ($invoicedata->export_detail);
 $gstno =  ($invoicedata->party_gst_no);
 $supplier_name = $invoicedata->company_name;
 
 $supplier_id = ($invoicedata->pallet_party_id);
 
 if($mode == "Add")
 {
	 $factory_address = strip_tags($invoicedata->address);
 }
 else
 {
	 $factory_address = strip_tags($invoicedata->factory_address);
 }
  
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
									<a href="<?=base_url().'producation_detail'?>">Purchase Order List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
							<h1>View PALLET ORDER</h1>
							 
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
								<div class="" style="padding:10px;" >
								<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="pallet_order_form" id="pallet_order_form">
									
									<h3 style="font-weight:bold;text-align: center;">PALLET ORDER	</h3>
										<table cellspacing="0" cellpadding="0"    width="100%">
											<tr>
												<td width="50%" style="vertical-align:top;font-weight:bold">PO No :<?=$purchase_order_no?></td>
												<td width="10%"> </td>
												<td width="40%" style="vertical-align:top;font-weight:bold"> DATE : <?=$purchase_order_date?></td>
											</tr>
											 
											<tr>
												<td rowspan="2" style="vertical-align:top;font-weight:bold" >
													<?=$export?>
													<?=$gstno?>
													<input type="hidden" name="export_detail" id="export_detail" value="<?=$export?> "/>		
												</td>
												<td colspan="2" style="vertical-align:top;font-weight:bold"> 
													<select class="" name="pallet_party_id" id="pallet_party_id" required onchange="load_pallet_pary(this.value)" title="Select Party">
														<option value="">Please Select Party</option>
														<option value="0" style="color:blue">Add New Party</option>
														<?php 
												 		for($i=0; $i<count($palletpary_detail);$i++)
														{
															$selected='';
															if($supplier_id==$palletpary_detail[$i]->pallet_party_id )
															{
																$selected = 'selected="selected"';
															}
														?>
															<option <?=$selected?> value="<?=$palletpary_detail[$i]->pallet_party_id ?>"><?=$palletpary_detail[$i]->party_name?></option>
														<?php
														}
														?>
													</select>
													<label id="pallet_party_id-error" class="error" for="pallet_party_id"> </label>
											 	</td>
											</tr>	
											<tr>
												 <td colspan="2">
													<textarea class="form-control" rows="4" name="supplier_detail" id="supplier_detail"  required title="Enter Pallet Party Detail" placeholder="Party Detail" style="height:80px;"><?=strip_tags($invoicedata->supplier_detail)?></textarea> 
												</td>
											</tr>
											<tr>
												<td style="vertical-align: top">
													 
												<label id="pallet_type-error" class="error" for="pallet_type"> </label>
												</td>
												 <td colspan="2">
													<textarea class="form-control" rows="4" name="factory_address" id="factory_address"  required title="Enter Factory Detail" placeholder="Factory Address" style="height:80px;"><?=$factory_address?></textarea> 
												</td>
											</tr>
								 	</table>
										<?php 
										if($mode == "Add")
										{
										?>
										<table cellspacing="0" cellpadding="0" width="100%">
									  <tr style="font-size: 16px;text-align: center;"> 
												<td> <strong>SR NO </strong></td>
										  
												<td style="text-align:center" > 
													<strong>Description Of Goods </strong>
												</td>
												<td style="text-align:center" > 
													<strong>BOX PER PALLET </strong>
												</td>
												<td style="text-align:center" > 
													<strong>PALLET </strong>
												</td>
												<td style="text-align:center" > 
													<strong>PALLET TYPE</strong>
												</td>
												
												<td style="text-align:center" > 
													<strong>RATE/PALLET </strong>
												</td>
													<td style="text-align:center" > 
													<strong>TOTAL AMOUNT </strong>
												</td>
											 
												<td style="text-align:center" > 
													<strong>FACTORY </strong>
												</td>
									   </tr>
									  <?php
										$srno = 1;
										$extrarow = 2;
										$total_product_plts=0;
										$total_fcl = 0;
										$size_array = array();
										 foreach($packing_data as $categoryll) 
										 {
											 
										 	// if(!in_array($categoryll->size_type_mm,$size_array))
											// {
												// array_push($size_array,$categoryll->size_type_mm);
												// $size_array[$categoryll->size_type_mm] = array();
												// $size_array[$categoryll->size_type_mm]['no_of_pallet']   = $categoryll->no_of_pallet;
												// $size_array[$categoryll->size_type_mm]['boxes_per_pallet']   = $categoryll->boxes_per_pallet;
												// // $size_array[$categoryll->size_type_mm]['box_per_big_pallet']   = $categoryll->box_per_big_pallet;
												// // $size_array[$categoryll->size_type_mm]['box_per_small_pallet']   = $categoryll->box_per_small_pallet;
												 
												// $size_array[$categoryll->size_type_mm]['big_pallet']	 = $categoryll->no_of_big_pallet;
												// $size_array[$categoryll->size_type_mm]['small_pallet']	 = $categoryll->no_of_small_pallet;	
												// $size_array[$categoryll->size_type_mm]['box_per_big_pallet']	 = $categoryll->box_per_big_pallet;
												// $size_array[$categoryll->size_type_mm]['box_per_small_pallet']	 = $categoryll->box_per_small_pallet;
												// $size_array[$categoryll->size_type_mm]['supplier_name']	= $supplier_name;
												// $size_array[$categoryll->size_type_mm]['product_id']	= $categoryll->product_id;
												// $size_array[$categoryll->size_type_mm]['pallet_type_name'] = $categoryll->pallet_type_name;
												// $size_array[$categoryll->size_type_mm]['pallet_type_id'] = $categoryll->pallet_type_id;
									 		// }
											// else
											// {    
												// $size_array[$categoryll->size_type_mm]['no_of_pallet']	+= $categoryll->no_of_pallet;
												// $size_array[$categoryll->size_type_mm]['big_pallet'] += $categoryll->no_of_big_pallet;
												// $size_array[$categoryll->size_type_mm]['small_pallet'] += $categoryll->no_of_small_pallet;
												// $size_array[$categoryll->size_type_mm]['boxes_per_pallet']   += $categoryll->boxes_per_pallet;
												// $size_array[$categoryll->size_type_mm]['box_per_big_pallet']  += $categoryll->box_per_big_pallet;
												// $size_array[$categoryll->size_type_mm]['box_per_small_pallet']   += $categoryll->box_per_small_pallet;
											// }
											if(!in_array($categoryll->size_type_mm,$size_array))
											{
												array_push($size_array,$categoryll->size_type_mm);
												$size_array[$categoryll->size_type_mm] = array();
												$size_array[$categoryll->size_type_mm]['no_of_pallet']   = $categoryll->no_of_pallet;
												$size_array[$categoryll->size_type_mm]['boxes_per_pallet']   = $categoryll->boxes_per_pallet;
											    //$size_array[$categoryll->size_type_mm]['box_per_big_pallet']   = $categoryll->box_per_big_pallet;
												//$size_array[$categoryll->size_type_mm]['box_per_small_pallet']   = $categoryll->box_per_small_pallet;
												 
												$size_array[$categoryll->size_type_mm]['big_pallet']	 = $categoryll->no_of_big_pallet;
												$size_array[$categoryll->size_type_mm]['small_pallet']	 = $categoryll->no_of_small_pallet;	
												$size_array[$categoryll->size_type_mm]['box_per_big_pallet']	 = $categoryll->box_per_big_pallet;
												$size_array[$categoryll->size_type_mm]['box_per_small_pallet']	 = $categoryll->box_per_small_pallet;
												$size_array[$categoryll->size_type_mm]['supplier_name']	= $supplier_name;
												$size_array[$categoryll->size_type_mm]['product_id']	= $categoryll->product_id;
												$size_array[$categoryll->size_type_mm]['pallet_type_name'] = $categoryll->pallet_type_name;
												$size_array[$categoryll->size_type_mm]['pallet_type_id'] = $categoryll->pallet_type_id;
									 		}
											else
											{    
												$size_array[$categoryll->size_type_mm]['no_of_pallet']	+= $categoryll->no_of_pallet;
												$size_array[$categoryll->size_type_mm]['big_pallet'] += $categoryll->no_of_big_pallet;
												$size_array[$categoryll->size_type_mm]['small_pallet'] += $categoryll->no_of_small_pallet;
												// $size_array[$categoryll->size_type_mm]['boxes_per_pallet']   += $categoryll->boxes_per_pallet;
												// $size_array[$categoryll->size_type_mm]['box_per_big_pallet']  += $categoryll->box_per_big_pallet;
												// $size_array[$categoryll->size_type_mm]['box_per_small_pallet']   += $categoryll->box_per_small_pallet;
											}
											 	 
										 }
										 
										 $no = 1; 
										for($p=0;$p<count($size_array);$p++)
										{	
											if(!empty($size_array[$p]))
											{
												$pallet = 0;
												$box_per_pallet = 0;
												if($size_array[$size_array[$p]]['no_of_pallet'] > 0)
												{
													$pallet = $size_array[$size_array[$p]]['no_of_pallet'];
													$total_product_plts += $size_array[$size_array[$p]]['no_of_pallet'];
													$box_per_pallet = $size_array[$size_array[$p]]['boxes_per_pallet'];
												}
												else if($size_array[$size_array[$p]]['big_pallet'] > 0 || $size_array[$size_array[$p]]['small_pallet'] > 0)
												{
													$pallet = 'Big: '.$size_array[$size_array[$p]]['big_pallet'].' <br>  Small: '.$size_array[$size_array[$p]]['small_pallet'];
													$total_product_plts += $size_array[$size_array[$p]]['big_pallet'];
													$total_product_plts += $size_array[$size_array[$p]]['small_pallet'];
													
													$box_per_pallet = 'Big: '.$size_array[$size_array[$p]]['box_per_big_pallet'].' <br> Small: '.$size_array[$size_array[$p]]['box_per_small_pallet'];
												}
												
										
												?>
												<tr> 
													<input type="hidden" name="size_type_mm[]" id="size_type_mm<?=$no?>" value="<?=$size_array[$p]?>" />
													<input type="hidden" name="product_id[]" id="product_id<?=$no?>" value="<?=$size_array[$size_array[$p]]['product_id']?>" />
													 <input type="hidden" name="no_of_pallet[]" id="no_of_pallet<?=$no?>" value="<?=$size_array[$size_array[$p]]['no_of_pallet']?>" />
													<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet<?=$no?>" value="<?=$size_array[$size_array[$p]]['big_pallet']?>" />
													<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet<?=$no?>" value="<?=$size_array[$size_array[$p]]['small_pallet']?>" />
													<input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet<?=$no?>" value="<?=$size_array[$size_array[$p]]['boxes_per_pallet']?>" />
													<input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet<?=$no?>" value="<?=$size_array[$size_array[$p]]['box_per_big_pallet']?>" />
													<input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet<?=$no?>" value="<?=$size_array[$size_array[$p]]['box_per_small_pallet']?>" />
													<input type="hidden" name="pallet_type[]" id="pallet_type<?=$no?>" value="<?=$size_array[$size_array[$p]]['pallet_type_id']?>" />
												
												 
													<td style="text-align:center;"><?=$no?></td>
													<td style="text-align:center;"><?=$size_array[$p]?></td>
													<td style="text-align:center;"><?=$box_per_pallet?></td>
													<td style="text-align:center;"><?=$pallet?></td>
													<td style="text-align:center;"><?=$size_array[$size_array[$p]]['pallet_type_name']?></td>
													<!--<td style="text-align:center;">-->
													<!--<input type="text" name="rate_per_pallet[]" id="rate_per_pallet<?=$no?>" class="form-control rate-per-pallet" value="<?=$size_array[$size_array[$p]]['rate_per_pallet']?>" onchange="calculateTotalAmount(<?=$no?>)" /> -->
													<!--</td>-->
													<td style="text-align:center;">
    <?php if ($size_array[$size_array[$p]]['no_of_pallet'] > 0): ?>
        <!-- Regular Pallet (Single Rate) -->
        <input type="text" name="rate_per_pallet[]" id="rate_per_pallet<?=$no?>" class="form-control rate-per-pallet" value="<?=$size_array[$size_array[$p]]['rate_per_pallet']?>" onchange="calculateTotalAmount(<?=$no?>)" />
    <?php else: ?>
        <!-- Big & Small Pallets (Dual Rates) -->
        <strong>Big:</strong> <input type="text" name="rate_per_big_pallet[]" id="rate_per_big_pallet<?=$no?>" class="form-control rate-per-pallet" value="<?=$size_array[$size_array[$p]]['rate_per_big_pallet']?>" onchange="calculateTotalAmount(<?=$no?>)" />
        <br>
         <strong>Small:</strong>
         <input type="text" name="rate_per_small_pallet[]" id="rate_per_small_pallet<?=$no?>" class="form-control rate-per-pallet" value="<?=$size_array[$size_array[$p]]['rate_per_small_pallet']?>" onchange="calculateTotalAmount(<?=$no?>)" />
    <?php endif; ?>
</td>
													<td style="text-align:center;">
													<input type="text" name="total_amount[]" id="total_amount<?=$no?>" class="form-control" value="<?=$size_array[$size_array[$p]]['total_amount']?>" readonly /> 
													</td>
													<td style="text-align:center;">
													<input type="text" name="factory_name[]" id="factory_name<?=$no?>" class="form-control" value="<?=$size_array[$size_array[$p]]['supplier_name']?>" /> 
													
													</td>
													 
												 </tr>
												 
										<?php
											$total_fcl += $size_array[$size_array[$p]]['fcl'];
												 $no++;
											}
										}			
										
									 	?>
											 <tr>
													<td colspan="8">
														<strong> Remarks : </strong>
														<input type="text" name="remarks[]" id="remarks<?=$srno?>" class="form-control" value="<?=$categoryll->remarks?>" /> 
													</td>
												</tr>
									 
										 
									   <tr> 
											<td style="text-align:center;" colspan="8">
												<button type="submit" name="submit" class="btn btn-success">
													Save
												</button>
												<a href="<?=base_url().'producation_detail'?>" class="btn btn-danger">
													Cancel
												</a>
											</td>
										</tr>
										</table>
										<?php 
										}
										else if($mode == "Edit")
										{
										?>
										<table cellspacing="0" cellpadding="0" width="100%">
											 <tr style="font-size: 16px;text-align: center;"> 
												<td> <strong>SR NO </strong></td>
										  
												<td style="text-align:center" > 
													<strong>Description Of Goods </strong>
												</td>
												
												<td style="text-align:center" > 
												<strong>Box Per Pallet </strong>
												</td>
												
												<td style="text-align:center" > 
												<strong>PALLET </strong>
												</td>
												<td style="text-align:center" > 
													<strong>PALLET TYPE</strong>
												</td>
												
												<td style="text-align:center" > 
													<strong>RATE/PALLET </strong>
												</td>
													<td style="text-align:center" > 
													<strong>TOTAL AMOUNT </strong>
												</td>
											 
												<td style="text-align:center" > 
													<strong>FACTORY </strong>
												</td>
									   </tr>
									  <?php
										$srno = 1;
										$extrarow = 2;
										$total_product_plts=0;
										$total_box_product_plts=0;
										$total_fcl = 0;
										foreach ($packing_data as $categoryll) 
										 {
									 	 
										?>
											<tr> 
												<td width="10%" style="text-align: center;"><?=$srno?></td>
												<td width="20%"  style="text-align: center;">
													<?=$categoryll->description?> 
													<input type="hidden" name="size_type_mm[]" id="size_type_mm<?=$srno?>" value="<?=$categoryll->description?>" />
													<input type="hidden" name="product_id[]" id="product_id<?=$srno?>" value="<?=$categoryll->product_id?>" />
													<input type="hidden" name="pallet_type[]" id="pallet_type<?=$srno?>" value="<?=$categoryll->pallet_type?>" />
												</td>
													
												<?php 
													
													if($categoryll->boxes_per_pallet>0)
													{
													 	$boxes_per_pallet = $categoryll->boxes_per_pallet;
														$total_box_product_plts += $categoryll->boxes_per_pallet;
													}
													else if($categoryll->box_per_big_pallet > 0)
													{
														$boxes_per_pallet =  $categoryll->box_per_big_pallet.'<br>'.$categoryll->box_per_small_pallet;
														$total_box_product_plts += $categoryll->box_per_big_pallet;
														$total_box_product_plts += $categoryll->box_per_small_pallet;
													}
													else
													{
														 $boxes_per_pallet =  '-';
													}
													
													if($categoryll->no_of_pallet>0)
													{
													 	$no_of_pallet = $categoryll->no_of_pallet;
														$total_product_plts += $categoryll->no_of_pallet;
													}
													else if($categoryll->no_of_big_pallet > 0)
													{
														$no_of_pallet =  $categoryll->no_of_big_pallet.'<br>'.$categoryll->no_of_small_pallet;
														$total_product_plts += $categoryll->no_of_big_pallet;
														$total_product_plts += $categoryll->no_of_small_pallet;
													}
													else
													{
														 $no_of_pallet =  '-';
													}
													
													
													
												?>
												
												
													<td width="10%" style="text-align: center;">
														 <?=$boxes_per_pallet?> 
														 <input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet<?=$srno?>" value="<?=$categoryll->boxes_per_pallet?>" />
														 <input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet<?=$srno?>" value="<?=$categoryll->box_per_big_pallet?>" />
														 <input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet<?=$srno?>" value="<?=$categoryll->box_per_small_pallet?>" />
													</td>
													
													
													<td width="10%" style="text-align: center;">
														 <?=$no_of_pallet?> 
														 <input type="hidden" name="no_of_pallet[]" id="no_of_pallet<?=$srno?>" value="<?=$categoryll->no_of_pallet?>" />
														 <input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet<?=$srno?>" value="<?=$categoryll->no_of_big_pallet?>" />
														 <input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet<?=$srno?>" value="<?=$categoryll->no_of_small_pallet?>" />
													</td>	
													
													
													<td width="20%"  style="text-align:center" > 
														<?=$categoryll->pallet_type_name?>
													</td>
													
														<td style="text-align:center;" width="10%" >
														<?php if ($categoryll->no_of_pallet > 0): ?>
														
															<input type="text" name="rate_per_pallet[]" id="rate_per_pallet<?=$srno?>" class="form-control rate-per-pallet" value="<?=$categoryll->rate_per_pallet?>" onchange="calculateTotalAmount(<?=$srno?>)" />
														<?php else: ?>
															
															<strong>Big:</strong> <input type="text" name="rate_per_big_pallet[]" id="rate_per_big_pallet<?=$srno?>" class="form-control rate-per-pallet" value="<?=$categoryll->rate_per_big_pallet?>" onchange="calculateTotalAmount(<?=$srno?>)" />
															<br>
															 <strong>Small:</strong>
															 <input type="text" name="rate_per_small_pallet[]" id="rate_per_small_pallet<?=$srno?>" class="form-control rate-per-pallet" value="<?=$categoryll->rate_per_small_pallet?>" onchange="calculateTotalAmount(<?=$srno?>)" />
														<?php endif; ?>
													</td>
														<td width="10%"  style="text-align:center" > 
													 <input type="text" name="total_amount[]" id="total_amount<?=$srno?>" class="form-control total-amount" value="<?=$categoryll->total_amount?>" readonly /> 
													</td>
													<td width="20%"  style="text-align:center" > 
														 <input type="text" name="factory_name[]" id="factory_name<?=$srno?>" class="form-control" value="<?=$categoryll->factory?>" /> 
													</td>
												  
											 
									 	 
										  </tr>
										  	<table cellspacing="0" cellpadding="0" width="100%">
												<tr style="font-size: 16px;"> 
													<td> <strong>Remarks  </strong>
														<input type="text" name="remarks[]" id="remarks<?=$srno?>" class="form-control" value="<?=$categoryll->remarks?>" /> 
													</td>
													</tr>
											</table>
									<?php
											 
											$srno++;
										 
										}
									   ?>
										 
									   <tr> 
											<td style="text-align:center;" colspan="5">
												<button type="submit" name="submit" class="btn btn-success">
													Save
												</button>
												<a href="<?=base_url().'producation_detail'?>" class="btn btn-danger">
													Cancel
												</a>
											</td>
										</tr>
										</table>
										
										<?php 
										}
										?>
										<input type="hidden" name="production_mst_id" id="production_mst_id" value="<?=$invoicedata->production_mst_id?>"/>		
										<input type="hidden" name="pallet_order_id" id="pallet_order_id" value="<?=$invoicedata->pallet_order_id?>"/>		
										<input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>		
									
									</form>	 
						 	 	</div>
							 
						</div>
					 									
							 	
								</div>
							 </div>
				</div>
			</div>
		</div>
			
  
<?php $this->view('lib/footer'); ?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pallet Party </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="party_add" id="party_add">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Party Name
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Party Name" id="party_name" class="form-control" name="party_name" value="" >
					 	</div>
					</div>
					 <div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Party Address
						</label>
						<div class="col-sm-12">
							<textarea placeholder="Party Name" id="party_address" class="form-control" name="party_address"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Party GST No
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Party GST No" id="party_gst_no" class="form-control" name="party_gst_no" />
						</div>
					</div>
			   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
			 </form>
        </div>
    </div>
</div>
<script>
 $(".select2").select2({
	width:'element' 
})
$("#pallet_party_id").select2({
		width:'100%',
	  "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_new_suppiler()'>Add New Pallet Party</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	}   
	 
});
$("#party_add").validate({
		rules: {
			party_name: {
				required: true
			} 
		},
		messages: {
			party_name: {
				required: "Enter Name"
			} 
		}
	});
	$("#pallet_order_form").validate({
		rules: {
			pallet_party_id: {
				required: true
			} 
		},
		messages: {
			pallet_party_id: {
				required: "Select Pallet Party"
			} 
		}
	});
 $("#pallet_order_form").submit(function(event) {
	event.preventDefault();
	if(!$("#pallet_order_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'create_pallet_order/manage',
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
				   $("#pallet_order_form").trigger('reset');
				   
					unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'pallent_order/index/'+obj.pallet_order_id ; },1500);
			 
			   }
			   else if(obj.res==2)
			   {
				   $("#pallet_order_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'pallent_order/index/'+obj.pallet_order_id ; },1500);
			 
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

$("#party_add").submit(function(event) {
	event.preventDefault();
	if(!$("#party_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'pallet_order_party/manage',
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
				   $("#party_add").trigger('reset');
				    $('#modal').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#pallet_party_id").append("<option value='"+obj.pallet_party_id +"' selected>"+obj.party_name+"</option>");
					$("#pallet_party_id").val(obj.pallet_party_id);
					$("#pallet_party_id").trigger("change")
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

function add_new_suppiler()
{
	$(".modal").css('z-index','10000');
	 $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
    $("#myModal").css('z-index','1050');            
}
function load_pallet_pary(cidval)
{
	 
		if(cidval==0)
		{
			add_new_suppiler();
			return false;
		}
		else{
			 
			block_page();
			 $('#supplier_detail').val('');
			$.ajax({
			  type :'POST',
			  url  :root+'pallet_order_party/fetchpalletorderdata',
			  data :{
				'id' : cidval,
				'type' : 'consigner'
			  },
			  success : function(msg){
				var obj=JSON.parse(msg);
				$('#supplier_detail').val(obj.party_address);
				 unblock_page("","");
				}
			});
	}
} 
// function calculateTotalAmount(rowId) {
//     // Get the number of pallets
//     var noOfPallets = parseFloat($("#no_of_pallet" + rowId).val()) || 0;
    
//     // Get the rate per pallet
//     var ratePerPallet = parseFloat($("#rate_per_pallet" + rowId).val()) || 0;
    
//     // Calculate the total amount
//     var totalAmount = noOfPallets * ratePerPallet;
    
//     // Update the total amount field
//     $("#total_amount" + rowId).val(totalAmount.toFixed(2));
// }

// // Attach the change event to all rate-per-pallet fields
// $(document).ready(function() {
//     $(".rate-per-pallet").on('input', function() {
//         var rowId = $(this).attr('id').replace('rate_per_pallet', '');
//         calculateTotalAmount(rowId);
//     });
// });

$(document).ready(function() {
    
    $(document).on('input', '[id^="no_of_pallet"], [id^="no_of_big_pallet"], [id^="no_of_small_pallet"], [id^="rate_per_pallet"], [id^="rate_per_big_pallet"], [id^="rate_per_small_pallet"]', function() {
       
        var rowId = $(this).attr('id').match(/\d+/)[0]; 
        calculateTotalAmount(rowId);
    });
});

function calculateTotalAmount(rowId) {
    // Get pallet counts
    var noOfPallets = parseFloat($("#no_of_pallet" + rowId).val()) || 0;
    var noOfBigPallets = parseFloat($("#no_of_big_pallet" + rowId).val()) || 0;
    var noOfSmallPallets = parseFloat($("#no_of_small_pallet" + rowId).val()) || 0;

    // Get rates
    var ratePerPallet = parseFloat($("#rate_per_pallet" + rowId).val()) || 0;
    var ratePerBigPallet = parseFloat($("#rate_per_big_pallet" + rowId).val()) || 0;
    var ratePerSmallPallet = parseFloat($("#rate_per_small_pallet" + rowId).val()) || 0;

    // Calculate total amount
    var totalAmount = (noOfPallets * ratePerPallet) + 
                      (noOfBigPallets * ratePerBigPallet) + 
                      (noOfSmallPallets * ratePerSmallPallet);

    // Update the total amount field
    $("#total_amount" + rowId).val(totalAmount.toFixed(2));
}



</script>