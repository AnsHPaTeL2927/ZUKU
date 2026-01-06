<?php 
$this->view('lib/header'); 
 if($mode=="Add")
 {
	$invoice_no="";
		$invoice_series = str_pad($invoicetype->invoice_series,strlen($invoicetype->invoice_series), '0', STR_PAD_LEFT);
	if($invoicetype->invoice_format==0)
	{
		$invoice_no = $invoice_series;
    }
	else if($invoicetype->invoice_format==1)
	{
		$invoice_no = $invoicetype->formate_value;
		$datevalue = explode(",",$invoicetype->with_date);
		if(in_array(3,$datevalue))
		{
			 $invoice_no .= date('Y');
		}
		if(in_array(2,$datevalue))
		{
			$invoice_no .= date('m');
		}
		if(in_array(1,$datevalue))
		{
			$invoice_no .= date('d');
		}
		$invoice_no =  $invoice_no.''.$invoice_series;						
	}
	else if($invoicetype->invoice_format==2)
	{
		$invoice_no .= $invoice_series;
		$datevalue = explode(",",$invoicetype->with_date);
		if(in_array(3,$datevalue))
		{
			$invoice_no .= date('Y');
		}
		if(in_array(2,$datevalue))
		{
			$invoice_no .= date('m');
		}
		
		if(in_array(1,$datevalue))
		{
			$invoice_no .= date('d');
		}															
		$invoice_no .= $invoicetype->formate_value;
	}
	 
	$export	=  ($invoicedata->exporter_detail);
	$Today_Date		= date('d-m-Y',strtotime($invoicedata->invoice_date));
	$performa_date  = date('d-m-Y',strtotime($invoicedata->performa_date));
	$performa_invoice_no =($invoicedata->export_ref_no);
	$exporter_email = $invoicedata->e_email;
	$exporter_mobile = $invoicedata->e_mobile;
	$exporter_gstin = $invoicedata->e_gstin;
	$exporter_pan = $invoicedata->exporter_pan;
	$exporter_iec = $invoicedata->exporter_iec;
	$buy_order_no =  ($invoicedata->export_buy_order_no);
	$buyer_other_consign =  ($invoicedata->buyer_other_consign);
	$consiger_id = $invoicedata->consiger_id;
	$consign_address =  ($invoicedata->consign_address);
	$pre_carriage_by=$invoicedata->pre_carriage_by;
	$place_of_receipt=$invoicedata->place_of_receipt;
	$country_origin_goods = $invoicedata->country_origin_goods;
	$country_final_destination = $invoicedata->country_final_destination;
	$bank_detail= ($invoicedata->bank_detail);
	$flight_name_no=$invoicedata->flight_name_no;
	$export_port_loading  = $invoicedata->port_of_loading;
	$port_of_discharge =$invoicedata->port_of_discharge;
	$final_destination =$invoicedata->final_destination;
	$export_payment_terms = $invoicedata->payment_terms;
	$no_of_container=$invoicedata->container_details;;
	$container_forty=$invoicedata->container_forty;;
	$container_twenty=$invoicedata->container_twenty;;
	$export_terms_of_delivery = $invoicedata->terms_of_delivery;
	$exchangerate = $invoicedata->Exchange_Rate_val;
	$consign_name = $invoicedata->c_name;
	$certification_charge = $invoicedata->certification_charge;
	$seafright_charge = $invoicedata->seafright_charge;
	$discount = $invoicedata->discount;
	$invoice_total =  $invoicedata->grand_total;
	$aftertaxvalue = $invoicedata->indian_ruppe_after_gst;
	$invoice_currency_id = $invoicedata->invoice_currency_id;
	$currency_symbol = ($invoicedata->invoice_currency_id=="2")?"&euro;":"$";
	$export_under = $invoicedata->export_under;
	$epcg_licence_no = $invoicedata->epcg_licence_no;
	$remarks = $invoicedata->remarks;
	$supplier_gstib = $invoicedata->supplier_gstib;
	$supplier_invoice_no = $invoicedata->supplier_invoice_no;
	$export_invoice_no = $invoicedata->export_invoice_no;
	$performa_date  			= $invoicedata->performa_date;
	$export_invoice_no_ref 		= $invoicedata->export_ref_no;
 }
 else{
	 
	 
	$export=  ($invoicedata->exporter_detail);
	$Today_Date		= date('d-m-Y',strtotime($invoicedata->invoice_date));
	$export_invoice_no =($invoicedata->taxinvoice_no);
	 
	$exporter_email = $invoicedata->e_email;
	$exporter_mobile = $invoicedata->e_mobile;
	$exporter_gstin = $invoicedata->e_gstin;
	$exporter_pan = $invoicedata->exporter_pan;
	$exporter_iec = $invoicedata->exporter_iec;
	$buy_order_no =  ($invoicedata->export_buy_order_no);
	$buyer_other_consign =  ($invoicedata->buyer_other_consign);
	$consiger_id = $invoicedata->consiger_id;
	$consign_address =  ($invoicedata->consign_address);
	$pre_carriage_by=$invoicedata->pre_carriage_by;
	$place_of_receipt=$invoicedata->place_of_receipt;
	$country_origin_goods = $invoicedata->country_origin_goods;
	$country_final_destination = $invoicedata->country_final_destination;
	$bank_detail= ($invoicedata->bank_detail);
	$flight_name_no=$invoicedata->flight_name_no;
	$export_port_loading  = $invoicedata->port_of_loading;
	$port_of_discharge =$invoicedata->port_of_discharge;
	$final_destination =$invoicedata->final_destination;
	$export_payment_terms = $invoicedata->payment_terms;
	$no_of_container=$invoicedata->container_details;;
	$container_twenty=$invoicedata->container_twenty;;
	$container_forty=$invoicedata->container_forty;;
	$export_terms_of_delivery = $invoicedata->terms_of_delivery;
	$exchangerate = $invoicedata->Exchange_Rate_val;
	$consign_name = $invoicedata->c_name;
	$certification_charge = indian_number($invoicedata->certification_charge,2);
	$seafright_charge = indian_number($invoicedata->seafright_charge,2);
	$discount = $invoicedata->discount;
	$invoice_total =  $invoicedata->grand_total;
	$aftertaxvalue = $invoicedata->indian_ruppe_after_gst;
	$invoice_currency_id = $invoicedata->invoice_currency_id;
	$currency_symbol = ($invoicedata->invoice_currency_id=="2")?"&euro;":"$";
	$export_under = $invoicedata->export_under;
	$epcg_licence_no = $invoicedata->epcg_licence_no;
	$remarks = $invoicedata->remarks;
	$supplier_gstib = $invoicedata->supplier_gstib;
	$supplier_invoice_no = $invoicedata->supplier_invoice_no;
	$export_invoice_no_ref  			= $invoicedata->export_ref_no;
	$performa_date  			= $invoicedata->performa_date;
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
									<a href="<?=base_url().'taxinvoice_listing'?>">Tax Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
									<h3>Tax Invoice</h3>
							</div>
						</div>
					</div>
				 
					<div class="row">
						<div class="col-sm-12">
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> Tax Invoice	
								</div>
                                
								<div class="form-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="invoice_form" id="invoice_form">
									
									<div id="accordion" style="padding:10px;" >
										  <h3>
											Tax Invoice Detail
										</h3>
										 
								    
							 <div class="" style="padding:10px;">
								 <table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="12"  style="font-weight:bold;vertical-align: bottom;text-align: center;">
											SUPPLY MEANT FOR EXPORT UNDER LUT WITHOUT PAYMENT OF IGST (LUT: <?=$company_detail[0]->s_lutno?>)
										</td>
									</tr>
									<tr>
										<td rowspan="6" width="1%">
											<span>C</span><br>	
											<span>O</span><br>		
											<span>N</span><br>	
											<span>S</span><br>		
											<span>I</span><br>		
											<span>G</span><br>		
											<span>N</span><br>	
											<span>E</span><br>	
											<span>R</span>
										</td>
										<td colspan="6" rowspan="3" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
											 <?=$export?>
												<input type="hidden" name="exporter_detail" value="<?=$export?>" id="exporter_detail" />
										</td>
										<td width="15%">Invoice No</td>
										<td width="15%" colspan="2" style="font-weight:bold">
											<?=$export_invoice_no?>
											 <input type="hidden" name="export_invoice_no" value="<?=$export_invoice_no?>" id="export_invoice_no" />
											 <!-- <input type="hidden" id="invoice_series" required=""  name="invoice_series" value="<?=(str_pad($invoice_series + 1,strlen($invoicetype->invoice_series), '0', STR_PAD_LEFT))?>" >-->
										</td>
										<td  width="11%" >DATE</td>
										<td  width="12%" style="font-weight:bold">
											<?=$Today_Date?>
											<input type="hidden" name="invoice_date" value="<?=$Today_Date?>" id="invoice_date" />
										</td>
									</tr>
									<tr>
										<td>Export Ref. No</td>
										<td colspan="2" style="font-weight:bold">
											<?=$export_invoice_no_ref?>
											<input type="hidden" name="export_ref_no" value="<?=$export_invoice_no_ref?>" id="export_ref_no" />
										</td>
										<td>DATE</td>
										<td style="font-weight:bold"> 
											<?=$performa_date?>
											<input type="hidden" name="performa_date" value="<?=$performa_date?>" id="performa_date" />	
										</td>
									</tr>
									<tr>
										<td rowspan="4" style="vertical-align:top" >Buyer Order No &amp; Date</td>
										<td rowspan="4" style="vertical-align:top;font-weight:bold" colspan="4">
												<?=$buy_order_no?>
												<input type="hidden" name="export_buy_order_no" value="<?=$buy_order_no?>" id="export_buy_order_no" />	
										</td>
									 </tr>
									<tr>
										<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">Email</td>
										<td width="3%">:</td>
										<td width="15%" colspan="2" style="font-weight:bold"> 
											<?=$exporter_email?>
											<input type="hidden" name="e_email" value="<?=$exporter_email?>" id="e_email" />	
										</td>
										<td width="5%">MOBILE</td>
										<td width="15%" style="font-weight:bold" >
											<?=$exporter_mobile?>
											<input type="hidden" name="e_mobile" value="<?=$exporter_mobile?>" id="e_mobile" />	
										</td>
										
									</tr>
									<tr>
										<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">GSTIN</td>
										<td width="3%">:</td>
										<td width="15%" colspan="2" style="font-weight:bold"> 
												<?=$exporter_gstin?>
												<input type="hidden" name="e_gstin" value="<?=$exporter_gstin?>" id="e_gstin" />	
										</td>
										<td width="5%">PAN NO</td>
										<td width="15%" style="font-weight:bold" >
											<?=$exporter_pan?>
											<input type="hidden" name="exporter_pan" value="<?=$exporter_pan?>" id="exporter_pan" />
										</td>
										
									</tr>
									<tr>
										<td width="8%" style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">IEC</td>
										<td width="3%">:</td>
										<td width="15%" colspan="4" style="font-weight:bold"> 
											<?=$exporter_iec?>
											<input type="hidden" name="exporter_iec" value="<?=$exporter_iec?>" id="exporter_iec" />
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
											 <input type="hidden" name="consiger_id" value="<?=$consiger_id?>" id="consiger_id" />
										</td>
										 <td colspan="5">
										  
										 </td>
									</tr>
									<tr>
										<td colspan="6" style="font-weight:bold">
												<?=$consign_address?>
												<input type="hidden" name="consign_address" value="<?=$consign_address?>" id="consign_address" />
										</td>
										<td >Buyer If Other Then Consignee [Notify]</td>
										<td colspan="4" style="font-weight:bold">
											<?=$buyer_other_consign?>
											<input type="hidden" name="buyer_other_consign" value="<?=$buyer_other_consign?>" id="buyer_other_consign" />
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
											<input type="hidden" name="pre_carriage_by" value="<?=$pre_carriage_by?>" id="pre_carriage_by" />
										</td>
										<td colspan="3" style="font-weight:bold">
											<?=$place_of_receipt?>
											<input type="hidden" name="place_of_receipt" value="<?=$place_of_receipt?>" id="place_of_receipt" />
										</td>
										<td colspan="2" style="font-weight:bold">
											<?=$country_origin_goods?>
											<input type="hidden" name="country_origin_goods" value="<?=$country_origin_goods?>" id="country_origin_goods" />
										</td>
										<td colspan="3" style="font-weight:bold">
												<?=$country_final_destination?>
												<input type="hidden" name="country_final_destination" value="<?=$country_final_destination?>" id="country_final_destination" />
												<div id="customer_rules" style="display:none"><i class="fa fa-question-circle" id="popoverData" style="padding: 5px;" data-content="" rel="popover" data-placement="top"   data-trigger="hover"></i></div>
										</td>
									</tr>
									<tr>
										<td colspan="4">Vessel / Flight Name & No </td>
										<td colspan="3">Port Of Loading	 </td>
										<td colspan="2" rowspan="4" style="vertical-align:top" >Bank Details  </td>
										<td colspan="3" rowspan="4" style="vertical-align:top;font-weight:bold" >
											<?=$bank_detail?>
											<input type="hidden" name="bank_detail" value="<?=$bank_detail?>" id="bank_detail" />
										</td>
									  </tr>
									<tr>
										<td colspan="4" style="font-weight:bold">
											<?=$flight_name_no?>
											<input type="hidden" name="flight_name_no" value="<?=$flight_name_no?>" id="flight_name_no" />
										</td>
										<td colspan="3" style="font-weight:bold">
												<?=$export_port_loading?>
												<input type="hidden" name="port_of_loading" value="<?=$export_port_loading?>" id="port_of_loading" />
										</td>
									</tr> 
									<tr>
										<td colspan="4">Port Of Discharge</td>
										<td colspan="3">Final Destination </td>
									</tr>
									<tr>
										<td colspan="4" style="font-weight:bold;text-align:center">
												<?=$port_of_discharge?>
												<input type="hidden" name="port_of_discharge" value="<?=$port_of_discharge?>" id="port_of_discharge" />
										</td>
										<td colspan="3" style="font-weight:bold">
											<?=$final_destination?>
											<input type="hidden" name="final_destination" value="<?=$final_destination?>" id="final_destination" />
										</td>
										</tr>
									<tr>
										<td colspan="5">Container Details</td>
										<td colspan="2">Nature Of Contract</td>
										<td rowspan="2">Payment Terms</td>
										<td colspan="4" rowspan="2" style="font-weight:bold">
											<?=$export_payment_terms?>
											<input type="hidden" name="payment_terms" value="<?=$export_payment_terms?>" id="payment_terms" />
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="5">
											<?php 
																if(!empty($container_twenty))
																{
																	echo $container_twenty.' X 20  FCL(s)';
															 	}
																if(!empty($container_twenty) && !empty($container_forty))
																{
																	echo ',';
																}
																if(!empty($container_forty))
																{
																	echo $container_forty.' X 40   FCL(s)';
																}
											?>
											</td>
										 
											<input type="hidden" name="container_details" value="<?=$no_of_container?>" id="container_details" />
											<input type="hidden" name="container_twenty" value="<?=$container_twenty?>" id="container_twenty" />
											<input type="hidden" name="container_forty" value="<?=$container_forty?>" id="container_forty" />
										 
										<td colspan="2" style="font-weight:bold">
											<?=$export_terms_of_delivery?>
											<input type="hidden" name="terms_of_delivery" value="<?=$export_terms_of_delivery?>" id="terms_of_delivery" />
										</td>
									 </tr>
								</table>
							 </div>
							 
							 <h3>
							 		Product Detail
							  </h3>
							  <div class="" style="padding:5px;" >
								 <table  width="100%" cellspacing="0" cellpadding="0" >
									 <tr>
									 	<td rowspan="2"  colspan="2" style="text-align:center">Exchange Rate </td>
									 	<td  rowspan="2" width="10%" style="text-align:center"> 
									 	 &#x20b9;	<input type="text" name="exchangerate" id="exchangerate" value="<?=$exchangerate?>" onkeyup="cal_invoice('<?=$mode?>')" onchange="cal_invoice('<?=$mode?>')" onblur="cal_invoice('<?=$mode?>')" style="width:80%"/>
									 	</td>
									 	<td rowspan="2" width="42%" style="text-align:center">Description of Goods</td>	
									 	<td colspan="3" style="text-align:center">Quantity Details</td>
									 	<td rowspan="2" width="8%" style="text-align:center">Rate In INR </td>
									 	<td rowspan="2" width="8%" style="text-align:center">Per </td>
									 	<td rowspan="2" width="10%" style="text-align:center">Total Amount  </td>
									  </tr>
									 <tr>
									 	 
									  	<td width="6%" style="text-align:center">Boxes </td>
									 	<td width="6%" style="text-align:center">SQM</td>
									 	<td width="6%" style="text-align:center">QTY</td>
								 	 </tr>
									<tbody>
									<?php 
										 
										 
											 if($mode=="Add")
											{ 
											$Total_sqm = 0;
											$Total_box = 0;
											$Total_ammount = 0;
											$Total_amt = 0;
											$total_container =0;
											$button_check_array = array();
											$stringcolor=array();
											$totalnetweight=0;
											$totalgrossweight=0;
										 	$product_desc_array = array();
											$no_of_row = 11;
										 
											for($i=0; $i<count($product_data);$i++)
											{
											  	 $n = 1;
												 $totalnetweight += $product_data[$i]->updated_netweight;
												 $totalgrossweight += $product_data[$i]->updated_grossweight;
												  
												foreach($product_data[$i]->packing  as $packing_row)
												{ 
													$description_goods =  $product_data[$i]->description_goods.$packing_row->product_rate;
													 
													
													if(!in_array(trim($description_goods),$product_desc_array))
													{
														array_push($product_desc_array,trim($description_goods));
														 
														 $product_desc_array[trim($description_goods)] = array();
													 	 
														 $product_desc_array[trim($description_goods)]['description_goods'] = $product_data[$i]->description_goods;
														 
														 $product_desc_array[trim($description_goods)]['boxes'] = $packing_row->no_of_boxes;
														 $product_desc_array[trim($description_goods)]['pallet'] = $packing_row->no_of_pallet;
														 $product_desc_array[trim($description_goods)]['big_pallet'] = $packing_row->no_of_big_pallet;
														 $product_desc_array[trim($description_goods)]['small_pallet'] = $packing_row->no_of_small_pallet;
														 
														 $product_desc_array[trim($description_goods)]['sqm'] = $packing_row->no_of_sqm;
														 $product_desc_array[trim($description_goods)]['product_rate'] =$packing_row->product_rate;
														 $product_desc_array[trim($description_goods)]['per'] = $packing_row->per;
														 $product_desc_array[trim($description_goods)]['exportproduct_trn_id'] = $product_data[$i]->exportproduct_trn_id;
														 
														 $product_desc_array[trim($description_goods)]['amount'] =$packing_row->product_amt;
														 $product_desc_array[trim($description_goods)]['product_id'] =$product_data[$i]->product_id;
														  
													}
													else
													{
														$product_desc_array[trim($description_goods)]['boxes'] +=$packing_row->no_of_boxes;
														$product_desc_array[trim($description_goods)]['sqm'] +=$packing_row->no_of_sqm;
														$product_desc_array[trim($description_goods)]['amount'] += $packing_row->product_amt;
														$product_desc_array[trim($description_goods)]['pallet'] += $packing_row->no_of_pallet;
														$product_desc_array[trim($description_goods)]['big_pallet'] += $packing_row->no_of_big_pallet;
														$product_desc_array[trim($description_goods)]['small_pallet'] += $packing_row->no_of_small_pallet;
												 	}
												}
											}
											$no=1;
											 
												for($p=0;$p<count($product_desc_array);$p++)
												{
													if(!empty($product_desc_array[$p]))
													{
													
									 ?>
												<tr>
													<td colspan="2"></td>
													<td></td>
													<td>
														<?=$product_desc_array[$product_desc_array[$p]]['description_goods']?>
													</td>
											<?php 
											if(!empty($product_desc_array[$product_desc_array[$p]]['product_id']))
											{
											?>		  
											<td class="text-center">
												<?=$product_desc_array[$product_desc_array[$p]]['boxes']?>	
											</td>
											<td class="text-center">
												<?=$product_desc_array[$product_desc_array[$p]]['sqm']?>
												</td>
											<td class="text-center">	- </td>
											<?php 
												$Total_box += $product_desc_array[$product_desc_array[$p]]['boxes'];
													$Total_sqm += $product_desc_array[$product_desc_array[$p]]['sqm'];
								
											}
											else
											{
													$qty = 0;
															$per 	= $product_desc_array[$product_desc_array[$p]]['per'];
															if($per == "SQF")
															{
																$qty =  $product_desc_array[$product_desc_array[$p]]['boxes'];
																
															}
															else if($per == "BOX")
															{
																$qty =  $product_desc_array[$product_desc_array[$p]]['boxes'];
															}
															else if($per == "SQM")
															{
																$qty =  $product_desc_array[$product_desc_array[$p]]['sqm'];
														 	}
															else if($per == "PCS")
															{
																$qty =  $product_desc_array[$product_desc_array[$p]]['boxes'];
														 	}
															 $Total_qty += $qty;
											?>	
											<td class="text-center">	- </td>
											<td class="text-center"> -  </td>
											<td class="text-center">	<?=$qty?> </td>
											<?php 
											}
											?>
											
											<td id="product_rate_html<?=$product_desc_array[$product_desc_array[$p]]['exportproduct_trn_id'].$p?>">
												&#x20b9; <?=$product_desc_array[$product_desc_array[$p]]['product_rate'] * $exchangerate?>
											</td>
											<td><?=$product_desc_array[$product_desc_array[$p]]['per']?></td>
											<td id="product_amt_html<?=$product_desc_array[$product_desc_array[$p]]['exportproduct_trn_id'].$p?>">
												&#x20b9; <?=indian_number($product_desc_array[$product_desc_array[$p]]['amount']  * $exchangerate,2)?>
											</td>
										<input type="hidden" name="exportproducttrn_id[]" id="exportproducttrn_id<?=$no?>" value="<?=$product_desc_array[$product_desc_array[$p]]['exportproduct_trn_id']?>" />
									 
										<input type="hidden" name="product_rate[]" id="product_rate<?=$product_desc_array[$product_desc_array[$p]]['exportproduct_trn_id'].$p?>" value="<?=$product_desc_array[$product_desc_array[$p]]['product_rate']?>" />
										
										<input type="hidden" name="product_amount[]" id="product_amount<?=$product_desc_array[$product_desc_array[$p]]['exportproduct_trn_id'].$p?>" value="<?=$product_desc_array[$product_desc_array[$p]]['amount']?>" />
									 
										<input type="hidden" name="description_goods[]" id="description_goods<?=$no?>" value="<?=$product_desc_array[$product_desc_array[$p]]['description_goods']?>" />
										  
									 
										<input type="hidden" name="boxes[]" id="boxes<?=$no?>" value="<?=$product_desc_array[$product_desc_array[$p]]['boxes']?>" />
										
										<input type="hidden" name="sqm[]" id="sqm<?=$no?>" value="<?=$product_desc_array[$product_desc_array[$p]]['sqm']?>" />
										
										<input type="hidden" name="per[]" id="per<?=$no?>" value="<?=$product_desc_array[$product_desc_array[$p]]['per']?>" />
										
										 
									</tr>
									<?php
								
									$total_amt = $product_desc_array[$product_desc_array[$p]]['amount']  * $exchangerate;
									
									$Total_ammount += $total_amt;
									}
												}
									
								 
									if(count($sample_data)!=0)
									{
											?>
											<tr>
														 	<td colspan="4" style="font-weight:bold">Sample</td>
													 	 	<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
														</tr>
											<?php
											 $no_of_row -= 1;
											 $hsnc_array = array();
											 $size_array = array();
											 $sample=1;
											 $sample_desc_array = array();
											 
											foreach ($sample_data as $jsondata)
											{
												 $totalnetweight 	+= $jsondata->netweight;
												 $totalgrossweight 	+= $jsondata->grossweight;
												 if(!in_array(trim($jsondata->size_type_mm),$sample_desc_array))
												{
													array_push($sample_desc_array,trim($jsondata->size_type_mm));
													$sample_desc_array[trim($jsondata->size_type_mm)] = array();
													
													 $sample_desc_array[trim($jsondata->size_type_mm)]['size_type_mm'] = $jsondata->size_type_mm;
													 $sample_desc_array[trim($jsondata->size_type_mm)]['size_type_mm'] = $jsondata->size_type_mm;
													 $sample_desc_array[trim($jsondata->size_type_mm)]['no_of_boxes'] = $jsondata->no_of_boxes;
													 $sample_desc_array[trim($jsondata->size_type_mm)]['sqm'] = $jsondata->sqm;
													 $sample_desc_array[trim($jsondata->size_type_mm)]['sample_rate'] = $jsondata->sample_rate;
													 $sample_desc_array[trim($jsondata->size_type_mm)]['per'] = $jsondata->per;
													 $sample_desc_array[trim($jsondata->size_type_mm)]['sample_amout'] = $jsondata->sample_amout;
													 $sample_desc_array[trim($jsondata->size_type_mm)]['export_sampletrn_id'] = $jsondata->export_sampletrn_id;
															 
												}
												else
												{
													$sample_desc_array[trim($jsondata->size_type_mm)]['no_of_boxes'] += $jsondata->no_of_boxes;
													$sample_desc_array[trim($jsondata->size_type_mm)]['sqm'] += $jsondata->sqm;
													$sample_desc_array[trim($jsondata->size_type_mm)]['sample_amout'] += $jsondata->sample_amout;
												}
											}
											for($s=0;$s<count($sample_desc_array);$s++)
											{
													if(!empty($sample_desc_array[$s]))
													{
														 
													?>
													<tr>
														<td colspan="2"> </td>
														<td> </td>
													 	<td><?=$sample_desc_array[$s]?></td>
														 
													 	<td  style="text-align:center"><?=$sample_desc_array[$sample_desc_array[$s]]['no_of_boxes']?></td>
														<td  style="text-align:center"><?=$sample_desc_array[$sample_desc_array[$s]]['sqm']?></td>
														<td  style="text-align:center" id="samplerate<?=$sample_desc_array[$sample_desc_array[$s]]['export_sampletrn_id'].$s?>"><?=$currency_symbol?> <?=$sample_desc_array[$sample_desc_array[$s]]['sample_rate']  * $exchangerate?></td>
														<td  style="text-align:center"><?=$sample_desc_array[$sample_desc_array[$s]]['per']?></td>
														<td  style="text-align:right" id="sampleamt<?=$sample_desc_array[$sample_desc_array[$s]]['export_sampletrn_id'].$s?>"><?=$currency_symbol?> <?=$sample_desc_array[$sample_desc_array[$s]]['sample_amout']  * $exchangerate?></td>
													</tr>
													<input type="hidden" name="export_sampletrn_id[]" id="export_sampletrn_id<?=$s?>" value="<?=$sample_desc_array[$sample_desc_array[$s]]['export_sampletrn_id']?>" />
													<input type="hidden" name="sample_desc_array[]" id="sample_desc_array<?=$s?>" value="<?=$sample_desc_array[$s]?>" />
													<input type="hidden" name="sample_no_of_boxes[]" id="sample_no_of_boxes<?=$s?>" value="<?=$sample_desc_array[$sample_desc_array[$s]]['no_of_boxes']?>" />
													<input type="hidden" name="sample_sqm[]" id="sample_sqm<?=$s?>" value="<?=$sample_desc_array[$sample_desc_array[$s]]['sqm']?>" />
													<input type="hidden" name="sample_rate[]" id="sample_rate<?=$sample_desc_array[$sample_desc_array[$s]]['export_sampletrn_id'].$s?>" value="<?=$sample_desc_array[$sample_desc_array[$s]]['sample_rate']?>" />
													<input type="hidden" name="sample_amount[]" id="sample_amount<?=$sample_desc_array[$sample_desc_array[$s]]['export_sampletrn_id'].$s?>" value="<?=$sample_desc_array[$sample_desc_array[$s]]['sample_amout']?>" />
													<input type="hidden" name="sample_per[]" id="sample_per<?=$s?>" value="<?=$sample_desc_array[$sample_desc_array[$s]]['per']?>" />
									
												<?php
													 $no_of_row -= 1;	
													$Total_plts += 1;
													$Total_box += $sample_desc_array[$sample_desc_array[$s]]['no_of_boxes'];
													$Total_sqm += $sample_desc_array[$sample_desc_array[$s]]['sqm'];
													$Total_ammount 	+= $sample_desc_array[$sample_desc_array[$s]]['sample_amout'];
													$Total_amt 		+= $sample_desc_array[$sample_desc_array[$s]]['sample_amout'];
													}
												}
											}
											}
											else
											{
												$no=0;
								for($p=0;$p<count($product_data);$p++)
								{
								 				 
									 ?>
												<tr>
													<td colspan="2"></td>
													<td></td>
													<td><?=$product_data[$p]->description_goods?></td>
											<?php 
											if(!empty($product_data[$p]->product_id))
											{
											?>			 
											<td  class="text-center"><?=$product_data[$p]->origanal_boxes?></td>
											<td  class="text-center"><?=$product_data[$p]->origanal_sqm?></td>
											<td  class="text-center">-</td>
											<?php 
											$Total_box += $product_data[$p]->origanal_boxes;
											$Total_sqm += $product_data[$p]->origanal_sqm;
											}
											else
											{	
													$qty = 0;
															$per 	= $product_data[$p]->per;
															if($per == "SQF")
															{
																$qty =  $product_data[$p]->origanal_boxes;
																
															}
															else if($per == "BOX")
															{
																$qty =  $product_data[$p]->origanal_boxes;
															}
															else if($per == "SQM")
															{
																$qty =  $product_data[$p]->origanal_sqm;
														 	}
															else if($per == "PCS")
															{
																$qty = $product_data[$p]->origanal_boxes;
														 	}
															 $Total_qty += $qty;
															 ?>
															 <td  class="text-center">-</td>
											<td  class="text-center"> - </td>
											<td  class="text-center"><?=$qty?></td>
															 <?php
											}
											?>
											<td id="product_rate_html<?=$product_data[$p]->exportproduct_trn_id.$p?>">
												&#x20b9; <?=$product_data[$p]->product_rate * $exchangerate?>
											</td>
											<td><?=$product_data[$p]->per?></td>
											<td id="product_amt_html<?=$product_data[$p]->exportproduct_trn_id.$p?>">
												&#x20b9; <?=indian_number($product_data[$p]->product_amt  * $exchangerate,2)?>
											</td>
										<input type="hidden" name="exportproducttrn_id[]" id="exportproducttrn_id<?=$no?>" value="<?=$product_data[$p]->exportproduct_trn_id?>" />
									 
										<input type="hidden" name="product_rate[]" id="product_rate<?=$product_data[$p]->exportproduct_trn_id.$p?>" value="<?=$product_data[$p]->product_rate?>" />
										
										<input type="hidden" name="product_amount[]" id="product_amount<?=$product_data[$p]->exportproduct_trn_id.$p?>" value="<?=$product_data[$p]->product_amt?>" />
									 
										<input type="hidden" name="description_goods[]" id="description_goods<?=$no?>" value="<?=$product_data[$p]->description_goods?>" />
										  
									 
										<input type="hidden" name="boxes[]" id="boxes<?=$no?>" value="<?=$product_data[$p]->origanal_boxes?>" />
										
										<input type="hidden" name="sqm[]" id="sqm<?=$no?>" value="<?=$product_data[$p]->no_of_sqm?>" />
										
										<input type="hidden" name="per[]" id="per<?=$no?>" value="<?=$product_data[$p]->per?>" />
										
										 
									</tr>
									<?php
									
									$total_amt = $product_data[$p]->product_amt * $exchangerate;
									$no++;
									$Total_ammount += $total_amt;
									}
								 
							 
							 	  if(count($sample_data)!=0)
									{
											?>
											<tr>
														 	<td colspan="4" style="font-weight:bold">Sample</td>
													 	 	<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
															<td style="text-align:center"></td>
														</tr>
											<?php
											  
											 
											for($s=0;$s<count($sample_data);$s++)
											{
												 	 
													?>
													<tr>
														<td colspan="2"> </td>
														<td> </td>
													 	<td><?=$sample_data[$s]->sample_desc?></td>
														 
													 	<td  style="text-align:center">
															<?=$sample_data[$s]->no_of_boxes?>
														</td>
														<td  style="text-align:center"><?=$sample_data[$s]->sample_sqm?></td>
														<td  style="text-align:center" id="samplerate<?=$sample_data[$s]->export_sampletrn_id.$s?>"><?=$currency_symbol?> <?=$sample_data[$s]->sample_rate * $exchangerate?></td>
														<td  style="text-align:center"><?=$sample_data[$s]->per?></td>
														<td  style="text-align:right" id="sampleamt<?=$sample_data[$s]->export_sampletrn_id.$s?>"><?=$currency_symbol?> <?=$sample_data[$s]->sample_amout  * $exchangerate?></td>
													</tr>
													<input type="hidden" name="export_sampletrn_id[]" id="export_sampletrn_id<?=$s?>" value="<?=$sample_data[$s]->export_sampletrn_id?>" />
													<input type="hidden" name="sample_desc_array[]" id="sample_desc_array<?=$sample_data[$s]->sample_desc?>" />
													<input type="hidden" name="sample_no_of_boxes[]" id="sample_no_of_boxes<?=$s?>" value="<?=$sample_data[$s]->no_of_boxes?>" />
													<input type="hidden" name="sample_sqm[]" id="sample_sqm<?=$s?>" value="<?=$sample_data[$s]->sample_sqm?>" />
													<input type="hidden" name="sample_rate[]" id="sample_rate<?=$sample_data[$s]->export_sampletrn_id.$s?>" value="<?=$sample_data[$s]->sample_rate ?>" />
													<input type="hidden" name="sample_amount[]" id="sample_amount<?=$sample_data[$s]->export_sampletrn_id.$s?>" value="<?=$sample_data[$s]->sample_amout?>" />
													<input type="hidden" name="sample_per[]" id="sample_per<?=$s?>" value="<?=$sample_data[$s]->per?>" />
									
												<?php
													 $no_of_row -= 1;	
													$Total_plts += 1;
													$Total_box += $sample_desc_array[$sample_desc_array[$s]]['no_of_boxes'];
													$Total_sqm += $sample_desc_array[$sample_desc_array[$s]]['sqm'];
													$Total_ammount 	+= $sample_desc_array[$sample_desc_array[$s]]['sample_amout'];
													$Total_amt 		+= $sample_desc_array[$sample_desc_array[$s]]['sample_amout'];
													 
												}
									}
					
							 }
										 
										 
									 ?>	
						  
									 
									<tr>
										<th colspan="4" style="text-align:right">TOTAL</th>
									 	<th class="text-center"><?=$Total_box; ?></th>
										<th class="text-center"><?=$Total_sqm; ?></th>
										<th class="text-center"><?=$Total_qty; ?></th>
										 <th style="text-align:right" colspan="2">FOB Value</th>
										<th> &#x20b9;	<span id="fob_value_html"> <?=indian_number($Total_ammount,2); ?></span> </th>
										 <input id="total_amount" type="hidden" name="total_amount" value="<?=$Total_ammount?>" class="form-control"/>
									</tr>
									<tr>
										
										<th colspan="5" rowspan="2" style="vertical-align:top">
											<input type="hidden" name="export_under" id="export_under" value="<?=$export_under?>" /> 
										</th> 
										<th rowspan="2" style=""> </th> 
										<th rowspan="2" style=""> </th> 
									 
										<th colspan="2">Certification Charges</th>
										<th>
											 <span id="certification_charge_html">
											&#x20b9;		<?=$invoicedata->certification_charge * $exchangerate ?> 
											</span>
											<input id="certification_charge" type="hidden" name="certification_charge" tabindex="2"   value="<?=$invoicedata->certification_charge?>"   />
										</th>
										<?php $Total_ammount +=$invoicedata->certification_charge * $exchangerate; ?> 
									</tr>
									<tr>
									
										 
										<th colspan="2">Insurance Charges</th>
										<th>
											<span id="insurance_charge_html">
											&#x20b9; <?=$invoicedata->insurance_charge * $exchangerate ?> 
											</span>
											<input id="insurance_charge" type="hidden"  name="insurance_charge" tabindex="2"  value="<?=$invoicedata->insurance_charge?>"  />
										</th>
										 <?php $Total_ammount +=$invoicedata->insurance_charge * $exchangerate; ?> 
									</tr>
									<tr>
										<th colspan="5" rowspan="5" style="vertical-align:top">
											 <input type="hidden" name="epcg_licence_no" id="epcg_licence_no" value="<?=$epcg_licence_no?>" /> 
										</th> 
									 
										<th rowspan="5"  colspan="2"  style="">
											 
										</th> 
										<th colspan="2">Seafreight Charges</th>
										<th>
											<span id="seafright_charge_html">
											 &#x20b9;	<?=$invoicedata->seafright_charge * $exchangerate ?> 
											</span>
											<input id="seafright_charge" type="hidden"  name="seafright_charge"   value="<?=$invoicedata->seafright_charge ?>"  />
										</th>
										  <?php $Total_ammount += $invoicedata->seafright_charge * $exchangerate; ?> 
									</tr>
									<tr>
										<th colspan="2">Bank Charges</th>
										<th>
										<span id="bank_charge_html">
												 &#x20b9; <?=$invoicedata->bank_charge * $exchangerate ?> 
											</span>
											<input id="bank_charge" type="hidden"  name="bank_charge"  value="<?=$invoicedata->bank_charge?>" />
											<span id="discount_error"></span>
										</th>
										  <?php  $Total_ammount += $invoicedata->bank_charge * $exchangerate; ?> 
									</tr>
									<tr>
										<th colspan="2">Courier Charges</th>
										<th>
										<span id="courier_html">
												 &#x20b9; <?=$invoicedata->courier_charge * $exchangerate ?> 
											</span>
											<input id="courier_charge" type="hidden"  name="courier_charge"  value="<?=$invoicedata->courier_charge?>" />
											<span id="discount_error"></span>
										</th>
										  <?php  $Total_ammount += $invoicedata->courier_charge * $exchangerate; ?> 
									</tr>
									<tr>
										<th colspan="2">
											<?=$invoicedata->extra_calc_name?> <?=($invoicedata->extra_calc_opt == 1)?"+":'-'?>
										</th>
										<th>
											 <span id="extra_calc_amt_html">
											&#x20b9;		<?=$invoicedata->extra_calc_amt * $exchangerate ?> 
											</span>
											<input id="extra_calc_amt" type="hidden" name="extra_calc_amt" tabindex="2"   value="<?=$invoicedata->extra_calc_amt?>"   />
											<input id="extra_calc_name" type="hidden" name="extra_calc_name" tabindex="2"   value="<?=$invoicedata->extra_calc_name?>"   />
											<input id="extra_calc_opt" type="hidden" name="extra_calc_opt" tabindex="2"   value="<?=$invoicedata->extra_calc_opt?>"   />
										</th>
										<?php 
										$Total_ammount = ($invoicedata->extra_calc_opt == 1)?$Total_ammount + $invoicedata->extra_calc_amt * $exchangerate:$Total_ammount - $invoicedata->extra_calc_amt * $exchangerate; ?> 
									</tr>
									<tr>
										<th colspan="2">Discount</th>
										<th>
										<span id="discount_html">
												 &#x20b9; <?=$invoicedata->discount * $exchangerate ?> 
											</span>
											<input id="discount" type="hidden"  name="discount"  value="<?=$invoicedata->discount?>" />
											<span id="discount_error"></span>
										</th>
										  <?php  $Total_ammount -= $invoicedata->discount * $exchangerate; ?> 
									</tr>
									<tr>
									 	<th colspan="5"  style="vertical-align:top">
											  <input type="hidden" name="remarks" id="remarks" value="<?=$remarks?>" /> 
										</th>  
										<th colspan="2"  style="vertical-align:top">
											 
										</th>  
										<th colspan="2">  Invoice Value</th>
										<th>
											 &#x20b9;	 <span id="grand_total_html"> <?=indian_number($Total_ammount,2)?></span>
											<input id="final_total_val" type="hidden" name="final_total_val"  value="<?=number_format($Total_ammount,2,'.','')?>" />
										</th>
										 
									</tr>
									<tr>
									
										<th colspan="5"  style="vertical-align:top">
											 
										</th>  
										<th colspan="2"  style="vertical-align:top">
											 
										</th>  
										<th colspan="2"> GST Value(18%)</th>
										<th>
											 &#x20b9;	 <span id="after_gst_html"> <?=indian_number($invoicedata->indian_ruppe_after_gst,2)?></span>
											
												<input id="gst_per" type="hidden" name="gst_per"  value="<?=number_format($invoicedata->gst_per,2,'.','')?>" />
												
												<input id="indian_ruppe_val" type="hidden" name="indian_ruppe_val"  value="<?=number_format($invoicedata->indian_ruppe_val,2,'.','')?>" />
												
												<input id="indian_ruppe_after_gst" type="hidden" name="indian_ruppe_after_gst"  value="<?=number_format($invoicedata->indian_ruppe_after_gst,2,'.','')?>" />
										</th>
										 
									</tr>
								</tbody>
							 </table>										
							</div>
						</div>
							 <div class="col-md-6">	
							 		<div class="form-group" style="text-align:center;" >
							 			<button type="submit" name="submit" class="btn btn-success">
							 				Save
							 			</button>
							 		<a href="<?=base_url().'taxinvoice_listing'?>" class="btn btn-danger">
							 			Cancel
							 		</a>
							 </div>	
						  </div>	
									
									<input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>			
									<input type="hidden" name="taxinvoice_id" id="taxinvoice_id" value="<?=$invoicedata->taxinvoice_id?>"/>			
									<input type="hidden" name="invoice_currency_id" id="invoice_currency_id" value="<?=$invoicedata->invoice_currency_id?>"/>			
									<input type="hidden" name="export_invoice_id" id="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"/>			
									<input type="hidden" name="supplier_id" id="supplier_id" value="<?=$invoicedata->supplier_id?>"/>			
									<input type="hidden" name="direct_invoice" id="direct_invoice" value="<?=$direct_invoice?>"/>			
									<input type="hidden" name="supplier_invoice_no" id="supplier_invoice_no" value="<?=$invoicedata->supplier_invoice_no?>"/>			
								</form>
					    
								</div>
						 
                            </div>
							 
						</div>
					</div>
				 
				</div>
		</div>
</div>
	 
<?php $this->view('lib/footer');
$this->view('lib/addcountry');
?>
<script>
$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );

$(document).ready(function() {
	
	$("#invoice_form").validate({
		rules: {
			invoice_no: {
				required: true
			} 
		},
		messages: {
			invoice_no: {
				required: "Enter Invoice Number"
			} 
		}
	});

	$("#consigner_form").validate({
		rules: {
			c_email_address: {
				 email:true
			},
			c_contact:{
				required:true 
			}
		},
		messages: {
			c_email_address: {
				 email:"Email Id Not Vaild" 
			},
			c_contact:{
				required:"Enter Contact No" 
			} 
		}
	});
	$("#country_add").validate({
		rules: {
			country_name: {
				required: true
			}
		},
		messages: {
			country_name: {
				required: "Enter Country Name"
			}
		}
	});
});

$("#invoice_form").submit(function(event) {
	event.preventDefault();
	if(!$("#invoice_form").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'taxinvoice/manage',
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
				   $("#invoice_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					 setTimeout(function(){ window.location=root+'taxinvoice_listing'; },1500);
				}
				else if(obj.res==3)
			   {
				   $("#invoice_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'taxinvoice_listing'; },1500);
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

 
function cal_invoice(mode)
{
	var exchangerate = ($("#exchangerate").val() > 0)?$("#exchangerate").val():0;
	if(exchangerate>0)
	{
		  
			 var inps = document.getElementsByName('exportproducttrn_id[]');
			 
		 	var total = 0;
			for (var i = 0; i <inps.length; i++)
			{
				var inp=inps[i];
				
				if($("#product_rate"+inp.value+i).val()>0)
				{
					var product_rate = parseFloat($("#product_rate"+inp.value+i).val()) * parseFloat(exchangerate); 
					 
				 	var product_amount = parseFloat($("#product_amount"+inp.value+i).val()) * parseFloat(exchangerate); 
					$("#product_rate_html"+inp.value+i).html(product_rate.toFixed(2));
					$("#product_amt_html"+inp.value+i).html(product_amount.toFixed(2));
					total += product_amount;
					
				}
			 
			}
			var inps = document.getElementsByName('export_sampletrn_id[]');
			 
		  	for (var i = 0; i <inps.length; i++)
			{
				var inp=inps[i];
				
				if($("#sample_rate"+inp.value+i).val()>0)
				{
					var sample_rate = parseFloat($("#sample_rate"+inp.value+i).val()) * parseFloat(exchangerate); 
				 	var sample_amount = parseFloat($("#sample_amount"+inp.value+i).val()) * parseFloat(exchangerate); 
					$("#samplerate"+inp.value+i).html(sample_rate.toFixed(2));
					$("#sampleamt"+inp.value+i).html(sample_amount.toFixed(2));
					total += sample_amount;
					
				}
			 
			}
	 
 	$("#total_amount").val(total.toFixed(2));
	$("#fob_value_html").html(total.toFixed(2));
	
	var certification_charge = $("#certification_charge").val() * exchangerate;
	$("#certification_charge_html").html(certification_charge.toFixed(2));
	
	var insurance_charge = $("#insurance_charge").val() * exchangerate;
	$("#insurance_charge_html").html(insurance_charge.toFixed(2));
	
	var seafright_charge = $("#seafright_charge").val() * exchangerate;
	$("#seafright_charge_html").html(seafright_charge.toFixed(2));
	
	var extra_calc_amt = $("#extra_calc_amt").val() * exchangerate;
	$("#extra_calc_amt_html").html(extra_calc_amt.toFixed(2));
	
	
	var discount = $("#discount").val() * exchangerate;
	$("#discount_html").html(discount.toFixed(2));
	
	var bank_charge = $("#bank_charge").val() * exchangerate;
	$("#bank_charge_html").html(bank_charge.toFixed(2));
	
	
	var courier_charge = $("#courier_charge").val() * exchangerate;
	$("#courier_html").html(courier_charge.toFixed(2));
	
	
	grand_total = parseFloat(total) + parseFloat(certification_charge) + parseFloat(insurance_charge) + parseFloat(seafright_charge) + parseFloat(bank_charge) + parseFloat(courier_charge) - parseFloat(discount);
	var extra_calc_opt = $("#extra_calc_opt").val();
	if(extra_calc_opt == 1)
	{
		grand_total += extra_calc_amt;
	}
	else
	{
		grand_total -= extra_calc_amt;
	}
	
	var grand_total = grand_total;
	$("#grand_total_html").html(grand_total.toFixed(2));
	$("#final_total_val").val(grand_total.toFixed(2));
	$("#indian_ruppe_val").val(grand_total.toFixed(2));
	
	
	var gst_val = grand_total * 18 / 100;
	$("#after_gst_html").html(gst_val.toFixed(2));
	$("#indian_ruppe_after_gst").val(gst_val.toFixed(2));
	}
}  
</script>
 
 