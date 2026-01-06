<?php 
$this->view('lib/header'); 
 $export_date = date('d-m-Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no =$invoicedata->export_invoice_no;
 $export =  ($invoicedata->exporter_detail);
 $export_ref_no =  ($invoicedata->export_ref_no);
 $performa_date =  date('d-m-Y',strtotime($invoicedata->performa_date));
 $buy_order_no = strip_tags($invoicedata->export_buy_order_no);
 $exporter_email = $invoicedata->e_email;
 $exporter_mobile = $invoicedata->e_mobile;
 $exporter_gstin = $invoicedata->e_gstin;
 $exporter_pan = $invoicedata->exporter_pan;
 $exporter_iec = $invoicedata->exporter_iec;
 $consign_name = $invoicedata->c_name;
 $consign_address = ($invoicedata->consign_address);
 $buyer_other_consign = ($invoicedata->buyer_other_consign);
 $pre_carriage_by=$invoicedata->pre_carriage_by;
 $place_of_receipt=$invoicedata->place_of_receipt;
 $country_origin_goods = $invoicedata->country_origin_goods;
 $country_final_destination = $invoicedata->country_final_destination;
 $bank_detail = $invoicedata->bank_detail;    
 $flight_name_no=$invoicedata->flight_name_no;   				 
 $export_port_loading = $invoicedata->port_of_loading;
 $port_of_discharge =  $invoicedata->port_of_discharge;
 $final_destination =  $invoicedata->final_destination;
 $export_payment_terms = $invoicedata->payment_terms;
 $no_of_container = $invoicedata->container_details;
 $export_terms_of_delivery = $invoicedata->terms_of_delivery;
 $container_size = $invoicedata->container_size;
 if($invoicedata->Exchange_Rate_val==0)
 {
	 $exchangerate = $userdata->usd;
 }
 else
 {
	 $exchangerate = $invoicedata->Exchange_Rate_val;
 }
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
							<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
						</li>
						 
				</ol>
				<div class="page-header title1">
				<h3>Export Invoice Packing Detail</h3>
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class=" panel-default">
				<form name="exportinvoice_packing_form" id="exportinvoice_packing_form" action="javascript:;">
				 
				 <div id="accordion">
				 <h3>
					 Export Invoice Detail
				  </h3>   
					<div class="" style="padding:10px;" >
						<table cellspacing="0" cellpadding="0"    width="100%">
										<tr>
											<td colspan="12"  style="font-weight:bold;vertical-align: bottom;text-align: center;">
												SUPPLY MEANT FOR EXPORT UNDER LUT WITHOUT PAYMENT OF IGST (LUT: <?=$company_detail[0]->s_lutno?>)
											</td>
										</tr>
										<tr>
											<td rowspan="6" width="1%">
												<span>E</span><br>	
												<span>X</span><br>		
												<span>P</span><br>	
												<span>O</span><br>		
												<span>R</span><br>		
												<span>T</span><br>		
												<span>E</span><br>	
												<span>R</span>
											</td>
											<td colspan="6" rowspan="3" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
												<?=$export?>
											</td>
											<td width="15%">Export Invoice No</td>
											<td width="15%" colspan="2" style="font-weight:bold">
												<?=$exportinvoice_no?>
											</td>
											<td  width="11%" >DATE</td>
											<td  width="12%" style="font-weight:bold">
												<?=$export_date?>
											</td>
										</tr>
										<tr>
										 	<td>Export Ref. No</td>
										 	<td colspan="2" style="font-weight:bold" >
										 		<?=$export_ref_no?>
										 	</td>
										 	<td> PI-DATE</td>
										 	<td style="font-weight:bold"> 
										 		<?=$performa_date?>
										 	</td>
										 </tr>
										 <tr>
										 	<td rowspan="4">Buyer Order No &amp; Date</td>
										 	<td rowspan="4" colspan="4" style="font-weight:bold">
										 			<?=$buy_order_no?>
										 		</td>
										  </tr>
										 <tr>
										 	<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px;">
												Email
											</td>
											<td width="3%">:</td>
											<td width="15%" colspan="2" style="font-weight:bold"> 
												<?=$exporter_email?>
											</td>
											<td width="5%">MOBILE</td>
											<td width="15%" style="font-weight:bold" >
												<?=$exporter_mobile?>
											</td>
												
											</tr>
											<tr>
												<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">GSTIN</td>
												<td width="3%">:</td>
												<td width="15%" colspan="2" style="font-weight:bold"> 
														<?=$exporter_gstin?>
												</td>
												<td width="5%">PAN NO</td>
												<td width="15%" style="font-weight:bold" >
													<?=$exporter_pan?>
												</td>
												
											</tr>
											<tr>
												<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">IEC</td>
												<td width="3%">:</td>
												<td width="15%" colspan="4" style="font-weight:bold"> 
													<?=$exporter_iec?>
												</td>
											</tr>
											<tr>
												<td rowspan="2" style="font-size: 11px;">
													<span>C</span><br>	
													<span>O</span><br>		
													<span>N</span><br>	
													<span>S</span><br>		
													<span>I</span><br>		
													<span>G</span><br>		
													<span>N</span><br>	
													<span>E</span><br>
													<span>E</span>
												</td>
												<td colspan="3">CONSIGNEE NAME :</td>
												 <td colspan="3" style="font-weight:bold">
													 <?=$consign_name?>
												</td>
												 <td colspan="5">
												  
												 </td>
											</tr>
											<tr>
												<td colspan="6" style="font-weight:bold">
														<?=$consign_address?>
												</td>
												<td >Buyer If Other Then Consignee [Notify]</td>
												<td colspan="4" style="font-weight:bold">
													<?=$buyer_other_consign?>
												</td>
											</tr>
											<tr>
												<td colspan="4">Pre Carriage By</td>
												<td colspan="3">Place of Receipt </td>
												<td colspan="2">Country of Origin</td>
												<td colspan="3">Country of Destination </td>
											 </tr>
											 <tr>
												<td colspan="4" style="font-weight:bold">
													<?=$pre_carriage_by?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$place_of_receipt?>
												</td>
												<td colspan="2" style="font-weight:bold">
													<?=$country_origin_goods?>
												</td>
												<td colspan="3" style="font-weight:bold">
														<?=$country_final_destination?>
												</td>
											</tr>
											  <tr>
												<td colspan="4">Vessel / Flight Name & No </td>
												<td colspan="3">Port Of Loading	 </td>
												<td   rowspan="4">Bank Details  </td>
												<td colspan="4" rowspan="4" style="font-weight:bold">
													<?=($bank_detail)?>
												</td>
											  </tr>
											  <tr>
												<td colspan="4" style="font-weight:bold">
													<?=$flight_name_no?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$export_port_loading?>
												</td>
											</tr> 
											  <tr>
												<td colspan="4">Port Of Discharge</td>
												<td colspan="3">Final Destination </td>
												 
											  </tr>
											<tr>
												<td colspan="4" style="font-weight:bold;text-align:center">
														<?=$port_of_discharge?>
												</td>
												<td colspan="3" style="font-weight:bold">
													<?=$final_destination?>
												</td>
												</tr>
												<tr>
															<td colspan="5">Container Details</td>
															<td colspan="2">Nature Of Contract</td>
															<td rowspan="2">Payment Terms</td>
															<td colspan="4" rowspan="2" style="font-weight:bold">
																<?=$export_payment_terms?>
															</td>
													</tr>
												<tr>
													<td colspan="2" style="font-weight:bold">
														<?=$no_of_container?>
													</td>
													<td style="font-weight:bold">X</td>
													<td colspan="2" style="font-weight:bold"><?=$container_size?> FT FCL</td>
													<td colspan="2" style="font-weight:bold">
														<?=$export_terms_of_delivery?>
													</td>
												</tr>
				 
								</table>
								</div>
							  <h3>
								Product Packing Detail
							  </h3>  
								<div class="">
									<div class="panel-body">
									   <div class="table-responsive">
											<table class="table table-bordered table-hover"  style="width:100%;">
													<thead>
														<tr>
															<th width="9%" style="text-align:center">Container</th>
															<th width="9%" style="text-align:center">Line Seal</th>
															<th width="9%" style="text-align:center">Self Seal</th>
															<th width="8%" style="text-align:center">Product Detail</th>
															<th width="8%" style="text-align:center">No Of Pallet</th>
															<th width="8%" style="text-align:center">No Of Boxes</th>
															<th width="8%" style="text-align:center">No Of Sqm</th>
															<th width="8%" style="text-align:center">Qty</th>
															<th width="8%" style="text-align:center">Unit</th>
															<th width="8%" style="text-align:center">Net Weight</th>
															<th width="8%" style="text-align:center">Gross Weight</th>
															 
															<th width="9%" style="text-align:center">Action</th>
													 	</tr>
													</thead>
											<tbody>
											 <?php
										 	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_qty = 0;
											$Total_ammount = 0;
											$setcontainer = 0;
											$packingtrn_array = array();
									 		$con_entry = 1;
										 	$con_array = array();
											$conarray = array();
											
											if(!empty($product_data))
											{		
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												
												for($i=0; $i<count($product_data);$i++)
												{
												$sample_str = '';	  
											  	?>
												<tr>
													<?php
												 $netweight   = $product_data[$i]->updated_net_weight;
												 $grossweight = $product_data[$i]->updated_gross_weight;
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														$rowcon_no1 = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														
															if(empty($sample_str))
															{
															 $rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
															 $rowcon_no1 = (!empty($rowcon_no))?$rowcon_no:1;
															 
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																		$sample_str .= '<tr>
																						 <td style="text-align:center">
																						 	'.$sample_des.'
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->no_of_pallet.'
																						 </td>
																					 	 <td style="text-align:center">
																						 	'.$sample_row->no_of_boxes.'
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->sqm.'
																						 </td>
																						  <td style="text-align:center">
																						 	'.$sample_row->netweight.'
																						 </td>
																						  <td style="text-align:center">
																						 	'.$sample_row->grossweight.'
																						 </td>
																						</tr> ';
																		 
																 }
																 
															}
														
												 	?>
													 
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->container_no?>
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->seal_no?> 
													</td>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														<?=$product_data[$i]->self_seal_no?>
													</td>
													<?php 
														array_push($con_array,$product_data[$i]->con_entry);
													}
													  if(empty($product_data[$i]->product_id))
													{
														$qty=0;
													 
															if($product_data[$i]->per == "SQM")
															{
														 		$qty = $product_data[$i]->origanal_sqm;
														 		 
														 	}
															else if($product_data[$i]->per == "BOX")
															{
													 			$qty = $product_data[$i]->origanal_boxes;
													 			 
													 		}
															else if($product_data[$i]->per == "SQF")
															{
													 			$qty = ($product_data[$i]->origanal_boxes);
													 			 
													 		}
															else if($product_data[$i]->per == "PCS")
															{
													 			$qty = ($product_data[$i]->origanal_boxes);
													 			 
													 		}
											?>
													<td colspan="2" style="text-align:center" >
															<?=$product_data[$i]->description_goods?>
													 	</td>
											 
														<td style="text-align:center">
															-	 
														</td>
														<td style="text-align:center">
															-
																	 
														</td>
														<td style="text-align:center">
														-
														</td>
														<td style="text-align:center">
														  	<?=$qty?>
														</td>
														<td style="text-align:center">
														  	<?=$product_data[$i]->per?>
														</td>			 
										 <?php  
										 }
										 else
										 {
											 ?>
														 
														<td class="text-center">
													 
														<?=$product_data[$i]->size_type_mm?>
														<br>
														<?=$product_data[$i]->model_name?>
														<br>
														<?=$product_data[$i]->finish_name?>
														</td> 
														 
														<td style="text-align:center">
															<?php 
														if($product_data[$i]->origanal_pallet>0)
														{
															$no_of_pallet = $product_data[$i]->origanal_pallet;
														 	echo $no_of_pallet;
															$Total_plts += $no_of_pallet;
									
														}
														else if($product_data[$i]->orginal_no_of_big_pallet>0 || $product_data[$i]->orginal_no_of_small_pallet>0)
														{
															echo $product_data[$i]->orginal_no_of_big_pallet.'<br>';
															echo $product_data[$i]->orginal_no_of_small_pallet;
															$Total_plts += $product_data[$i]->orginal_no_of_big_pallet;
															$Total_plts += $product_data[$i]->orginal_no_of_small_pallet;
														}
														
														?>
															 </td>
															  
													 	
															<?php 
															 
													 
													$no_of_sqm 	= ($packing->product_id == 0)?$product_data[$i]->origanal_sqm:$product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box;
						
													?>
														<td style="text-align:center"><?=$product_data[$i]->origanal_boxes?> </td>
														<td style="text-align:center"><?=number_format($no_of_sqm,2,'.','')?></td>
														  
													<td style="text-align:center">-</td>
													<td style="text-align:center">-</td>													
												 	 												 
												 <?php
										 }
												 	if(!in_array($product_data[$i]->con_entry,$conarray))
													{
												 		//$rowcon_no = ($product_data[$i]->rowcon_no > 1)?$product_data[$i]->rowcon_no:'';
													?>
													<td style="text-align:center" rowspan="<?=$rowcon_no1?>">
														 
														<input type="text" name="net_weight[]" id="net_weight<?=$product_data[$i]->export_loading_trn_id?>" value="<?=$netweight?>" class="form-control" />  
													</td>
													<td style="text-align:center" rowspan="<?=$rowcon_no1?>">
														 
														<input type="text" name="gross_weight[]" id="gross_weight<?=$product_data[$i]->export_loading_trn_id?>" value="<?=$grossweight?>" class="form-control" />   
													</td>
														
													<td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 
														<?php 
														if(empty($sample_str))
														{
														?>
															<a class="btn btn-info tooltips" data-title="Add Sample"  onclick="add_sample_product(<?=$product_data[$i]->export_invoice_id?>,<?=$product_data[$i]->export_loading_trn_id?>,'<?=$product_data[$i]->container_no?>')" href="javascript:;" ><i class="fa fa-plus"></i></a>
														<?php 
														}
														else
														{
															?>
															<a class="btn btn-warning tooltips" data-title="Edit Sample"  onclick="editsample_product(<?=$product_data[$i]->export_loading_trn_id?>)" href="javascript:;" ><i class="fa fa-plus"></i></a>	
															<a class="btn btn-danger tooltips" data-title="Delete Sample"  onclick="deletesample_product(<?=$product_data[$i]->export_loading_trn_id?>)" href="javascript:;" ><i class="fa fa-minus"></i></a>
															<?php
														}
														?>
													  </td>
													    <input type="hidden" name="export_loading_trn_id[]" id="export_loading_trn_id<?=$product_data[$i]->export_loading_trn_id?>" value="<?=$product_data[$i]->export_loading_trn_id?>" />   
												 	<?php 
														array_push($conarray,$product_data[$i]->con_entry);
													}
													?>
													 
													 
											 	</tr>
										 		<?php
												echo $sample_str;
											     
											}
											}
											else
											{
												echo "<tr>
															<td  class='text-center' colspan='14'>Container Not set</td>
													</tr>";
											}
												
												?>
											    
														 
					 								</tbody>
												</table>										
											
										 </div>
								 </div>
									</div>
								</div>
								<div style="padding: 14px;padding-left:0px;">
									<button class="btn btn-success" >Save & Next</button>
									<a href="<?=base_url().'exportinvoicepacking/index/'.$invoicedata->export_invoice_id?>" class="btn btn-danger">
											Back
									</a>
									<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
									<input type="hidden" id="make_container_array" name="make_container_array" value="0"> 
									<input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"> 
									<input type="hidden" id="export_step" name="export_step" value="<?=$invoicedata->step?>"> 
									<div class="errormsg" style="color:red"></div>
								</div>
							 </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
 
<?php $this->view('lib/footer'); ?>
<div id="Addsamplemodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg"  style="width:1200px">
        <!-- Modal content-->
        <div class="modal-content" style="max-height: 580px;overflow-y: auto;">
		
            <div class="modal-header">
                <button type="button"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Sample Product  </h4>
				
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="sample_product_form" id="sample_product_form">
            <div class="modal-body">
                <div class="row">
						<input type="hidden" id="exportinvoiceid" name="exportinvoiceid" value="<?=$invoicedata->export_invoice_id?>"> 
						<input type="hidden" id="export_loading_trn_id" name="export_loading_trn_id" value=""> 
						
						<input type="hidden" id="exportinvoicetrnid" name="exportinvoicetrnid" value=""> 
						<input type="hidden" id="direct_invoice" name="direct_invoice" value="2"> 
						 
						
						<input type="hidden" id="no_of_sample" name="no_of_sample" value=""> 
						<div class="col-md-12"style="height:20px;">	</div>	
							<div id="editresponsesamplecontainer">
							</div>
						</div>  			
				</div>
			 
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Add" id="sample_submit_btn" class="btn btn-info"  /> 
                <button type="button"   class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 
			<input type="hidden" name="sample_mode" id="sample_mode"/>
			<input type="hidden" name="edit_total_sample_data" id="edit_total_sample_data"/>
			</form>
       
    </div>
</div>
</div>

 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">From Excel</h4>
            </div>
			  
            <div class="modal-body">
                <div class="row">
						<div class="col-md-12">
					 		<textarea placeholder="Paste Here.........." id="excel_data" class="form-control" name="excel_data" style="height:250px"></textarea>
					 	</div>
				 </div>
			</div>
            <div class="modal-footer">
			 	<button id="button_btn" type="button" onclick="paste_data()" class="btn btn-info">Import</button>            
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			  
        </div>
    </div>
</div>
 <script>
 
$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
</script>
<script>
$("#exportinvoice_packing_form").submit(function(event) {
	event.preventDefault();
	var inps = document.getElementsByName('export_loading_trn_id[]');
	
	var no=1;
	for (var i = 0; i <inps.length; i++) {
			var inp=inps[i];
			var inpschild = document.getElementsByName('container_detail'+inp.value+'[]');
			 
		 	for (var j = 0; j <inpschild.length; j++) {
				  
				if($("#container_detail"+inp.value+j).val()=="")
				{
					$("#container_detail"+inp.value+j).focus();
					return false;
				}
				else if($("#seal_no"+inp.value+j).val()=="")
				{
					$("#seal_no"+inp.value+j).focus();
					return false;
				}
				else if($("#rfidseal_no"+inp.value+j).val()=="")
				{
					$("#rfidseal_no"+inp.value+j).focus();
					return false;
				}
				else if($("#updatednetweight"+inp.value+j).val()=="")
				{
					$("#updatednetweight"+inp.value+j).focus();
					return false;
				}
				else if($("#updatedgrossweight"+inp.value+j).val()=="")
				{
					$("#updatedgrossweight"+inp.value+j).focus();
					return false;
				}
				var stringlength = $("#container_detail"+inp.value+j).val().length;
				if(stringlength != 11)
				{
					$("#container_detail"+inp.value+j).focus();
					$("#container_detail"+inp.value+j).attr("readonly",false)
					toastr["error"]("Container Number Having 7 Digit & 4 Letter");
					return false;
				}
				var stringcharlength = $("#container_detail"+inp.value+j).val().replace(/[0-9]/g, '').length;
				if(stringcharlength != 4)
				{
					$("#container_detail"+inp.value+j).focus();
					$("#container_detail"+inp.value+j).attr("readonly",false)
					toastr["error"]("Container Number Having 7 Digit & 4 Letter");
					return false;
				}
				var stringnumlength = $("#container_detail"+inp.value+j).val().replace(/\D/g,'').length;
				if(stringnumlength != 7)
				{
					$("#container_detail"+inp.value+j).focus();
					$("#container_detail"+inp.value+j).attr("readonly",false)
					toastr["error"]("Container Number Having 7 Digit & 4 Letter");
					return false;
				}
			 }
		no++;	
	}
	  
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'exportinvoicesample/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Packing Detail Sucessfully Added.");
					setTimeout(function(){ window.location=root+'exportinvoiceannexure/index/'+<?=$invoicedata->export_invoice_id?> },1000);
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

function add_sample_product(export_invoice_id,export_loading_trn_id,container_no)
{
	 
	block_page()
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/add_sample',
              data: {
				 "export_invoice_id" 	: export_invoice_id, 
                "export_loading_trn_id" : export_loading_trn_id, 
                "container_no" 			: container_no 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
					 $("#exportinvoicetrnid").val(0);
					 $("#export_loading_trn_id").val(export_loading_trn_id);
					 $("#sample_mode").val('add');
					  $("#editresponsesamplecontainer").html(obj.str);
					 
					 $("#no_of_container_sample").val(no_of_container);
					 $("#Addsamplemodal").modal({
						 backdrop: 'static',
						 keyboard: false
					 });
					 $(".selectajax1").select2({
						width:'100%'
					 });
					 
					$(".tooltips").tooltip();
					unblock_page("","");
              }
			});
	 
}
function load_data_sample(val,no)
{
	 
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/getproduct_data',
              data: {
                "product_id": val
              }, 
              cache: false, 
              success: function (data) 
			  { 
					var obj = JSON.parse(data)
					 $("#product_size_id"+no).html(obj.str) 
					 
					 $("#design_id"+no).html(obj.str_design) 
					
              }
			});
}
function load_data_sample_packing(val,no)
{
	
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoicepacking/getproduct_size_data',
              data: {
                "product_size_id": val
              }, 
              cache: false, 
              success: function (data) { 
					var obj = JSON.parse(data)
					$("#sqm_per_box"+no).val(obj.sqm_per_box);
					$("#weight_per_box"+no).val(obj.weight_per_box);
					$("#palletweight"+no).val(obj.pallet_weight);
					//cal_sampledata(no,1)
              }
			});
	
}
function load_sample_finish(design_id,val)
{  
  	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoiceproduct/load_finish_data",
       data: 
	   {
			"id": design_id 
	   }, 
       success: function (response) {
			$("#finish_id"+val).html(response);
		 	unblock_page("",""); 
           }
       
  }); 
} 
function cal_sampledata(no,fromwhere)
{
	
	var boxes = $("#no_of_boxes"+no).val()
	 
	var appsqmperboxesval = $("#sqm_per_box"+no).val();
	var apwigtperbox = $("#weight_per_box"+no).val();
	var productrate = $("#productrate"+no).val();
	var sqmdataval = boxes * appsqmperboxesval;
	  
	var netweight = boxes * apwigtperbox;
	var grossweight = parseFloat(netweight);
	$("#sample_sqm"+no).val(sqmdataval.toFixed(2));
	$("#netweight"+no).val(netweight.toFixed(2));
	$("#grossweight"+no).val(grossweight.toFixed(2));
	var sqmdataval = boxes * appsqmperboxesval;
	var sampleproductamount = productrate * boxes;
	$("#sampleproductamount"+no).val(sampleproductamount.toFixed(2));
	 
}
function add_inner_sample_product(no,n,container_name)
{
	
	//block_page()
	 
	
	var next_no = $("#inner_row_value"+no).val() + parseInt(1);
	 
	if($("#product_details"+$("#inner_row_value"+no).val()+n).val() === "")
	{
		toastr["error"]("Please Select Product");
		$("#product_details"+$("#inner_row_value"+no).val()+n).select2('open');
		return false;
	}
	if($("#no_of_boxes"+$("#inner_row_value"+no).val()+n).val() === "")
	{
		toastr["error"]("Enter Box");
		$("#no_of_boxes"+$("#inner_row_value"+no).val()+n).focus();
		return false;
	}
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/add_inner_sample',
              data: {
                "container_name"	: container_name,
                "no"	: next_no,
				"con"	: n
              }, 
              cache: false, 
              success: function (data) {
					 
					$(".row"+no).append(data);
					$(".select"+next_no+n).select2({
						width:'100%'
					});
					$(".selectajax"+next_no+n).select2({
						width:'100%'
					});
					
					$("#inner_row_value"+no).val(next_no)
					$(".tooltips").tooltip();
					unblock_page("","");
              }
			});
	 
}

function remove_inner_sample_product(no)
{
	$(".inner_row"+no).remove();
}
function deletesample_product(exportproduct_trn_id)
{
	Swal.fire({
		title: 'Are you sure?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
			 if (result.value) {
					block_page()
			$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/delete_sampleentry',
              data: {
                "exportproduct_trn_id"	: exportproduct_trn_id, 
                "export_invoice_id"	: <?=$invoicedata->export_invoice_id?> 
              }, 
              cache: false, 
              success: function (data) { 
			  		unblock_page("","");
					 unblock_page("success","Sample Sucessfully Deleted.");
					 setTimeout(function(){ window.location=root+'exportinvoicesample/index/'+<?=$invoicedata->export_invoice_id?> },1000);
			}
			});
			}	
		});
}
function editsample_product(export_loading_trn_id)
{
	block_page()
	$.ajax({ 
              type: "POST", 
              url: root+'exportinvoiceproduct/edit_sampleentry',
              data: {
                "export_loading_trn_id"	: export_loading_trn_id,
				"direct_invoice"		: 2	
              }, 
              cache: false, 
              success: function (data) { 
			  var obj = JSON.parse(data);
					 $("#Addsamplemodal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#export_loading_trn_id").val(export_loading_trn_id)
				 	$("#sample_submit_btn").val("Edit");
				  	$("#sample_mode").val('edit');
				   $("#editresponsesamplecontainer").html(obj.str);
				   $(".editselectajax1").select2({
						width:'100%'
					});
					$(".containter_html").html(obj.container_name)
					  $(".selectajax1").select2({
						width:'100%'
					});
					//add_sample_product(exportproduct_trn_id,no_of_container,obj.container_name)
					unblock_page("","");
              }
			});
}


	

$("#sample_product_form").submit(function(event) {
	event.preventDefault();
	if(!$("#sample_product_form").valid())
	{
		return false;
	}
 
	if($("#product_details10").val() == "")
	{
		toastr["error"]("Please Add At list one Sample");
		return false;
	}
	
	 block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url: 	root+'exportinvoiceproduct/sampleentry',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               //console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sample Sucessfully Added.");
					setTimeout(function(){ window.location=root+'exportinvoicesample/index/'+<?=$invoicedata->export_invoice_id?> },1000);
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
	 width:'element'
});  
 

function paste_data()
{
	var excel_data = $("#excel_data").val();
	var excel_spit = excel_data.split("\n");  
	var total_line = parseInt(excel_spit.length)-parseInt(1);
	  var value_array = [];
	  var name_array = [];
	  
	if(parseInt(total_line) == parseInt($("#no_of_container").val()))
	{
		for(var i=0;i<total_line;i++)
		{
			var custom1 =  excel_spit[i].replace(/\t/g, ' ');
			var spit_from_colom = custom1.split(" ");
			  value_array.push(spit_from_colom)
			 
		}
		
		var inps = document.getElementsByName('exportproducttrn_id[]');
		var no=0;
		
		for (var c = 0; c <inps.length; c++) 
		{
			var inp=inps[c];
		 	var inpschild = document.getElementsByName('container_detail'+inp.value+'[]');
			console.log(inpschild)
		 	for (var d = 0; d < inpschild.length; d++) 
			{
			 	if(value_array[no] != undefined && value_array[no].length == 3)
				{
				 	$("#container_detail"+inp.value+d).val(value_array[no][0])
				 	$("#container_detail"+inp.value+d).attr("readonly",true)
					$("#seal_no"+inp.value+d).val(value_array[no][1])
					$("#seal_no"+inp.value+d).attr("readonly",true)
					$("#rfidseal_no"+inp.value+d).val(value_array[no][2])
					$("#rfidseal_no"+inp.value+d).attr("readonly",true)
				  	no++;
				}
				else if(value_array[no] != undefined)
				{
					toastr["error"]("Wrong Data");
					return false;
				}
			 }
			
		}
		$("#myModal").modal("hide"); 
		$("#excel_data").val(""); 
		
	}
	else
	{
		toastr["error"]("Wrong Data");
	}
}
 
</script>

  