<?php 
$this->view('lib/header'); 
    
 $invoice_date = date('d-m-Y',strtotime($invoicedata->invoice_date));
 $customer_invoice_no =$invoicedata->customer_invoice_no;
 $export =  ($invoicedata->exporter_detail);
 $export_ref_no =  ($invoicedata->export_ref_no);
 $export_date =  date('d-m-Y',strtotime($invoicedata->export_date));
 $buy_order_no = strip_tags($invoicedata->customer_buy_order_no);
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
 else{
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
							<a href="<?=base_url().'customer_listing'?>">Customer Invoice List</a>
						</li>
						 
				</ol>
				<div class="page-header title1">
				<h3>Customer Invoice Packing Detail</h3>
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class=" panel-default">
				<form name="exportinvoice_packing_form" id="exportinvoice_packing_form" action="javascript:;">
				 
				 <div id="accordion">
				 <h3>
					 Customer Invoice Detail
				  </h3>   
					<div class="" style="padding:10px;" >
						<table cellspacing="0" cellpadding="0"    width="100%">
										 
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
												<td width="15%">Customer Invoice No</td>
												<td width="15%" colspan="2" style="font-weight:bold">
													<?=$customer_invoice_no?>
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
												<td>DATE</td>
												<td style="font-weight:bold"> 
													<?=$export_date?>
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
												<table  class="table table-bordered table-hover" width="100%" cellspacing="0" cellpadding="0" style="">
													 
													<tr>
															<th style="text-align:center" width="5%">Sr No.</th>
															<th style="text-align:center" width="10%">Container No</th>
															<th style="text-align:center" width="10%">Size</th>
															<th style="text-align:center" width="25%">Description Of Goods</th>
															<th style="text-align:center" width="5%">HSN Code</th>
															<th style="text-align:center" width="5%">Unit</th>
															<th style="text-align:center" width="10%"> No Of Pallet</th>
															<th style="text-align:center" width="10%">No Of Boxes </th>
															<th style="text-align:center" width="10%">SQM</th>
															<th style="text-align:center" width="10%">Quantity</th>
															 
														</tr> 
												<?php
											$no = 1;
											$n = 1;
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_amount= 0;
											$con_array = array();
											$conarray = array();
												for($i=0; $i<count($product_data);$i++)
												{
													$sample_str = '';	  
													 $check_container = $product_data[$i]->con_entry.$product_data[$i]->einvoice_id;
													  
												 	if(!in_array($check_container,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														 	if(empty($sample_str))
															{
																$rowcon_no = (empty($rowcon_no))?$rowcon_no:1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																			$sample_str .= '<tr>
																						 <td colspan="3" style="text-align:center">
																						 	'.$sample_row->product_size_id.' - 
																						 	Sample
																						 </td>
																						 
																						 <td style="text-align:center">
																						 	 
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
																						 	 -
																						 </td>
																 						</tr> ';
																		 
														 		 }
																 
															}
														
												 	?>
												<tr>   
													<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$n?></td>
													<td style="text-align:center" rowspan="<?=$rowcon_no?>"><?=$product_data[$i]->container_no?></td>
													 
												<?php 
													$no=1;
													$n++;
													array_push($con_array,$check_container);
											  	}
												$desc = $product_data[$i]->size_type_cm.$product_data[$i]->container_no.$product_data[$i]->client_name;
												if(!in_array($desc,$sizearray))
												{	
													 
													if($no>1)
													{
														echo "<tr>";
													}
												?>
													
													<?php 
											 
												if(empty($product_data[$i]->product_id))
												{
												?>
													<td colspan="2" style="text-align:center" ><?=$product_data[$i]->custdescriptiongoods?></td>
												<?php
												}
												else
												{
												?>
													<td style="text-align:center" ><?=$product_data[$i]->size_type_mm?></td>
													<td style="text-align:center" ><?=$product_data[$i]->custdescriptiongoods?></td>
													<?php
												}
												 
												?>
													<td style="text-align:center" ><?=$product_data[$i]->custhsnccode?></td>
												 	<td style="text-align:center" ><?=$product_data[$i]->per?></td>
													<td style="text-align:center" >
													<?php
														if($product_data[$i]->no_of_pallet > 0)
														{
															echo $product_data[$i]->no_of_pallet;
														}
														else if($product_data[$i]->no_of_big_pallet > 0 || $product_data[$i]->no_of_small_pallet > 0)
														{
															echo "Big:".$product_data[$i]->no_of_big_pallet.'<br> Small:'.$product_data[$i]->no_of_small_pallet;
														}
														else
														{
															echo "-";
														}
														$qty = '-';
														$no_of_boxes    = $product_data[$i]->origanal_boxes;
														$no_of_sqm 		= $product_data[$i]->origanal_sqm;
														 
														if(empty($product_data[$i]->product_id))
														{
															 
																	if($product_data[$i]->per == "SQF")
																	{
																		$qty =  $product_data[$i]->origanal_boxes;
																	}
																	else if($product_data[$i]->per == "BOX")
																	{
																		$qty =  $product_data[$i]->origanal_boxes;
																	}
																	else if($product_data[$i]->per == "SQM")
																	{
																		$qty =  $product_data[$i]->origanal_sqm;
																	}
																	else if($product_data[$i]->per == "PCS")
																	{
																		$qty =  $product_data[$i]->origanal_boxes;
																		
																	} 	
																	$Total_qty += $qty;
																	$product_rate = $product_data[$i]->product_rate;
															$no_of_boxes = '-';
															$no_of_sqm = '-';
														}   
														?>
													</td>
													<td style="text-align:center" ><?=$no_of_boxes?></td>
													<td style="text-align:center" ><?=$no_of_sqm?></td>
													<td style="text-align:center" ><?=$qty?></td>
													 
												<?php 
													 
													if($no>1)
													{
														echo "</tr>";
													}
													array_push($sizearray,$desc);
												}
												if(!in_array($check_container,$conarray))
												{
												?>
									   </tr>
												<?php 
												echo $sample_str;
													array_push($conarray,$check_container);
											  	}
												$Total_sqm 		+= $product_data[$i]->no_of_sqm;
											    $Total_box 		+= $product_data[$i]->origanal_boxes;
											    
												$Total_ammount 	+= $product_data[$i]->product_amt;
												$no++;
											}
											 
										 
											?>
										</table>
											
											
											
										 	</div>
										 </div>
									</div>
								</div>
								<div style="padding: 14px;padding-left:0px;">
									<button class="btn btn-success" >Save & Next</button>
									<a href="<?=base_url().'cutomerinvoiceproduct/index/'.$invoicedata->customer_invoice_id?>" class="btn btn-danger">
											Back
									</a>
									<input type="hidden" id="no_of_container" name="no_of_container" value="<?=$invoicedata->container_details?>"> 
									<input type="hidden" id="make_container_array" name="make_container_array" value="0"> 
									<input type="hidden" id="customer_invoice_id" name="customer_invoice_id" value="<?=$invoicedata->customer_invoice_id?>"> 
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
 
$(".select2").select2({
	 width:'element'
});  
 
$("#exportinvoice_packing_form").submit(function(event) {
	event.preventDefault();
	 block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'customerinvoicepacking/manage',
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
					setTimeout(function(){ window.location=root+'customerinvoiceview/index/'+<?=$invoicedata->customer_invoice_id?> },1000);
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
		for (var c = 0; c <inps.length; c++) {
			var inp=inps[c];
			var inpschild = document.getElementsByName('container_detail'+inp.value+'[]');
			 
			for (var d = 0; d <inpschild.length; d++) {
				
				if(value_array[no].length == 3)
				{
					$("#container_detail"+inp.value+d).val(value_array[no][0])
					$("#container_detail"+inp.value+d).attr("readonly",true)
					$("#seal_no"+inp.value+d).val(value_array[no][1])
					$("#seal_no"+inp.value+d).attr("readonly",true)
					$("#rfidseal_no"+inp.value+d).val(value_array[no][2])
					$("#rfidseal_no"+inp.value+d).attr("readonly",true)
				  	no++;
				}
				else{
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

  