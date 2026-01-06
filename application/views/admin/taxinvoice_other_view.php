<?php 
$this->view('lib/header'); 
 
	$invoice_no	= $invoicedata->taxinvoice_no;  
	$export=  ($invoicedata->exporter_detail);
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
	$export_terms_of_delivery = $invoicedata->terms_of_delivery;
	$exchangerate = $invoicedata->Exchange_Rate_val;
	$consign_name = $invoicedata->c_name;
	$_SESSION['tax_content'] = '';
	$_SESSION['export_invoice_no'] = '';
	$locale='en-US'; //browser or user locale
	 
	$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
	$currency_symbol ='INR';
  
 
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
	window.open(root+"taxinvoicepdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"taxinvoicepdf/view_pdf";
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
									<a href="<?=base_url().'taxinvoice_listing'?>">Tax Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
									<h3>Tax Invoice 
										<div class="pull-right form-group">
											 <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
										 </div>
									</h3>
									
							</div>
						</div>
					</div>
				 
					<div class="row">
						<div class="col-sm-12">
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 View Tax Invoice
																		 
								</div>
                                
								<div class="form-body panel-body">
							 <?php ob_start();?>
									<h3 style="font-weight:bold;text-align: center;">TAX INVOICE  </h3>
								 <table cellspacing="0" cellpadding="0"    width="100%">
									<tr>
										<td colspan="9"  style="font-weight:bold;vertical-align: bottom;text-align: center;">
											<?php
										 
											if($invoicedata->igst_status==1)
											{
											?>
											"SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING (LUT) WITHOUT PAYMENT OF INTEGRATED TAX (IGST)"
											<?php }
											else{?>
												"SUPPLY MEANT FOR EXPORT UNDER BOND OR LETTER OF UNDERTAKING ( LUT) WITH PAYMENT OF INTEGRATED TAX (IGST)"
											<?php }?>
										</td>
									</tr>
									<tr>
										 
										<td colspan="5" rowspan="2" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
											 <?=$export?>
									 	</td>
										<td width="15%">Invoice No</td>
										<td width="15%" style="font-weight:bold">
											<?=$invoice_no?>
											 
										</td>
										<td  width="11%" >DATE</td>
										<td  width="12%" style="font-weight:bold">
											<?=$Today_Date?>
											 
										</td>
									</tr>
									<tr>
										<td>Export Ref. No</td>
										<td style="font-weight:bold">
											<?=$performa_invoice_no?>
											 
										</td>
										<td>DATE</td>
										<td style="font-weight:bold"> 
											<?=$performa_date?>
											 
										</td>
									</tr>
									 
									 
									<tr>
										<td   style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">Email</td>
										<td>:</td>
										<td style="font-weight:bold"> 
											<?=$exporter_email?>
											 	
										</td>
										<td >MOBILE</td>
										<td style="font-weight:bold" >
											<?=$exporter_mobile?>
											 
										</td>
										<td rowspan="3" style="vertical-align:top" >Buyer Order No &amp; Date</td>
										<td colspan="3" rowspan="3" style="vertical-align:top;font-weight:bold" >
												<?=$buy_order_no?>
												 	
										</td>
									</tr>
									<tr>
										<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">GSTIN</td>
										<td>:</td>
										<td style="font-weight:bold"> 
												<?=$exporter_gstin?>
												 
										</td>
										<td>PAN NO</td>
										<td style="font-weight:bold" >
											<?=$exporter_pan?>
											 
										</td>
										
									</tr>
									<tr>
										<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">IEC</td>
										<td>:</td>
										<td colspan="3" style="font-weight:bold"> 
											<?=$exporter_iec?>
											 
										</td>
									</tr>
									<tr>
										 
									 	<td colspan="5" style="font-weight:bold;vertical-align:top;">
												<?=$consign_address?>
												 
										</td>
										<td >Buyer If Other Then Consignee [Notify]</td>
										<td colspan="3" style="font-weight:bold">
											<?=$buyer_other_consign?>
									 	</td>
									</tr>
									<tr>
										<td colspan="3">Pre Carriage By</td>
										<td colspan="2">Place of Receipt </td>
										<td colspan="2">Country of Origin</td>
										<td colspan="2">Country of Destination </td>
									 </tr>
									<tr>
										<td colspan="3" style="font-weight:bold">
											<?=$pre_carriage_by?>
											 
										</td>
										<td colspan="2" style="font-weight:bold">
											<?=$place_of_receipt?>
											 
										</td>
										<td colspan="2" style="font-weight:bold">
											<?=$country_origin_goods?>
											 
										</td>
										<td colspan="2" style="font-weight:bold">
												<?=$country_final_destination?>
										 </td>
									</tr>
									<tr>
										<td colspan="3">Vessel / Flight Name & No </td>
										<td colspan="2">Port Of Loading	 </td>
										<td  rowspan="4" style="vertical-align:top" >Bank Details  </td>
										<td colspan="3" rowspan="4" style="vertical-align:top;font-weight:bold" >
											<?=$bank_detail?>
											 
										</td>
									  </tr>
									<tr>
										<td colspan="3" style="font-weight:bold">
											<?=$flight_name_no?>  &nbsp; 
											 
										</td>
										<td colspan="2" style="font-weight:bold">
												<?=$export_port_loading?> 
										</td>
									</tr> 
									<tr>
										<td colspan="3">Port Of Discharge</td>
										<td colspan="2">Final Destination </td>
									</tr>
									<tr>
										<td colspan="3" style="font-weight:bold;text-align:center">
												<?=$port_of_discharge?>
											 
										</td>
										<td colspan="2" style="font-weight:bold">
											<?=$final_destination?>
											 
										</td>
										</tr>
									<tr>
										<td colspan="3">Container Details</td>
										<td colspan="2">Nature Of Contract</td>
										<td rowspan="2">Payment Terms</td>
										<td colspan="3" rowspan="2" style="font-weight:bold">
											<?=$export_payment_terms?>
										 </td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="3">
											<?php 
																if(!empty($invoicedata->container_twenty))
																{
																	echo $invoicedata->container_twenty.' X 20  FCL(s)';
															 	}
																if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
																{
																	echo ',';
																}
																if(!empty($invoicedata->container_forty))
																{
																	echo $invoicedata->container_forty.' X 40  FCL(s)';
																}
											?>
											</td>
										<td colspan="2" style="font-weight:bold">
											<?=$export_terms_of_delivery?>
											 
										</td>
									 </tr>
								</table>
							  
								 <table  width="100%" cellspacing="0" cellpadding="0" >
									<tr>
										<td width="2%" style="padding:0px"></td>
										<td width="8%" style="padding:0px"></td>
										<td width="10%" style="padding:0px"></td>
										<td width="30%" style="padding:0px"></td>
										<td width="10%" style="padding:0px"></td>
										<td width="10%" style="padding:0px"></td>
										<td width="10%" style="padding:0px"></td>
										<td width="10%" style="padding:0px"></td>
										<td width="10%" style="padding:0px"></td>
										 
									</tr>
									 <tr>
									 	<td rowspan="2"  colspan="2" style="text-align:center;font-weight:bold">Exchange Rate </td>
									 	<td  rowspan="2" style="text-align:center;font-weight:bold"> 
									 	 <?=$currency_symbol?> <?=$exchangerate?>
									 	</td>
									 	<td rowspan="2" colspan="2"   style="text-align:center">Description Of Goods</td>	
									 	<td  style="text-align:center">Quantity Details</td>
									 	<td rowspan="2" style="text-align:center">Rate In INR </td>
									 	<td rowspan="2" style="text-align:center">Per </td>
									 	<td rowspan="2" style="text-align:center">Total Amount  </td>
									  </tr>
									 <tr>
									 	 
									  	<td  style="text-align:center">Qty </td>
									 	 
									 </tr>
									<?php
									$Total_box =0;
									$Total_box =0;
									$Total_ammount =0;
									for($p=0;$p<count($product_data);$p++)
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
									<tr>
										<tr>
													<td colspan="2"></td>
													<td></td>
													<td  colspan="2"><?=$product_data[$p]->description_goods?> </td>
													 <td style="text-align:center"><?=$qty?></td>
											 
											<td style="text-align:center">
												 <?=$currency_symbol?> <?=$product_data[$p]->product_rate * $exchangerate?>
											</td>
											<td style="text-align:center"><?=$product_data[$p]->per?></td>
											<td style="text-align:right" id="product_amt_html<?=$product_data[$p]->exportproduct_trn_id.$p?>">
												<?=$currency_symbol?> <?=indian_number($product_data[$p]->product_amt  * $exchangerate,2)?>
											</td>
											 
											
									</tr>
									<?php
									$Total_box 		+= $product_data[$p]->origanal_boxes;
									$Total_sqm 		+= $product_data[$p]->no_of_sqm;
									$Total_ammount += $product_data[$p]->product_amt * $exchangerate;
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
														<td > </td>
													 	<td  ><?=$sample_data[$s]->sample_desc?></td>
														 
													 	<td  style="text-align:center">
															<?=$sample_data[$s]->no_of_boxes?>
														</td>
														<td  style="text-align:center"><?=$sample_data[$s]->sample_sqm?></td>
														<td  style="text-align:center" > <?=$currency_symbol?> <?=$sample_data[$s]->sample_rate * $exchangerate?></td>
														<td  style="text-align:center"><?=$sample_data[$s]->per?></td>
														<td  style="text-align:right" >
														<?=$currency_symbol?>
														<?=$sample_data[$s]->sample_amout  * $exchangerate?></td>
													</tr>
										
									<?php
									$Total_box += $product_data[$i]->sub[$s]->no_of_boxes;
									$Total_sqm += $product_data[$i]->sub[$s]->sqm;
									$Total_ammount += $sample_data[$s]->sample_amout  * $exchangerate;
									 	}
									 
									 
								}
								 
												$total_container +=count($container_data);
													$rowspan = 4;
									if($invoicedata->insurance_charge > 0)
									{
										$rowspan++;
									}										
									if($invoicedata->seafright_charge > 0)
									{
										$rowspan++;
									}
									if(!empty($invoicedata->extra_calc_name))
									{
										$rowspan++;
									}	
									 
									if(!empty($invoicedata->courier_charge))
									{
										$rowspan++;
										
									}	
									if(!empty($invoicedata->bank_charge))
									{
										$rowspan++;
									}	
									if($invoicedata->igst_status != 1)
									{
										$rowspan++;
										$rowspan++;
									}
									?>
										
									<tr>
										<td rowspan="<?=$rowspan?>"  style="font-size:10px;width:10px"> 
												<span>E</span><br>	
												<span>X</span><br>		
												<span>P</span><br>	
												<span>O</span><br>		
												<span>R</span><br>		
												<span>T</span><br>		
												<span>U</span><br>	
												<span>N</span><br>
												<span>D</span><br>
												<span>E</span><br>
												<span>R</span>
										</td>		
										<td colspan="4" rowspan="2" style="vertical-align:top;font-weight:bold">
												 <?=$invoicedata->export_under?>
										</td> 
									 	<td style="font-weight:bold;text-align:center"><?=$Total_box; ?></td>
										 <td style="text-align:right;font-weight:bold" colspan="2">FOB Value</td>
										<td style="font-weight:bold;text-align:right">
											<?=$currency_symbol?> <?=indian_number($Total_ammount,2)?>
										</td>
									</tr>
									<tr>
									 	<td style="text-align:center">Quantity</td>
										 
										<td colspan="2" style=" text-align:right;">
											<?=($invoicedata->certification_charge > 0)?"Certification Charges":""?>
									 	</td>
										<td style="font-weight:bold;text-align:right">
											<?=($invoicedata->certification_charge > 0)?$currency_symbol." ".indian_number($invoicedata->certification_charge * $exchangerate,2):""?>
								 		</td>
								 	</tr>
									<?php 
									if($invoicedata->insurance_charge > 0)
									{
									?>
									<tr>
										
										<th colspan="4" rowspan="2" style="vertical-align:top">
											 
										</th> 
									 	<td rowspan="2"  style="font-weight:bold">
											 
										</td> 
										<td colspan="2" style="text-align:right">Insurance Charges</td>
										<th style="text-align:right">
											<?=$currency_symbol?>
											<?=indian_number($invoicedata->insurance_charge * $exchangerate,2)?>
											 
										</th>	 
									</tr>
									<?php 
									}
									if($invoicedata->seafright_charge > 0)
									{
									?>
									<tr>
										<td colspan="2" style="text-align:right">Seafreight Charges</td>
										<th style="text-align:right">
											<?=$currency_symbol?>
												<?=indian_number($invoicedata->seafright_charge * $exchangerate,2)?>
												 
										</th>
										  
									</tr>
									<?php 
									}
									  if(!empty($invoicedata->courier_charge))
									{
									?>
									<tr>
										<th colspan="4">
											 
										</th> 
										<td>  </td> 
										 
										<td colspan="2" style="text-align:right"> Courier Charges </td>
										<th style="text-align:right">
											<?=$currency_symbol?>
												<?=indian_number($invoicedata->courier_charge * $exchangerate,2)?>
												 
										</th>
										  
									</tr>
									<?php 
									}
									 if(!empty($invoicedata->bank_charge))
									{
									?>
									<tr>
										<th colspan="4">
											 
										</th> 
										<td>  </td> 
										 
										<td colspan="2" style="text-align:right">
											Bank Charges
										</td>
										<th style="text-align:right">
											<?=$currency_symbol?>
												<?=indian_number($invoicedata->bank_charge * $exchangerate,2)?>
												 
										</th>
										  
									</tr>
									<?php 
									}
									if(!empty($invoicedata->extra_calc_name))
									{
									?>
									<tr>
										<th colspan="4">
											 
										</th> 
										<td>  </td> 
										 
										<td colspan="2" style="text-align:right"><?=$invoicedata->extra_calc_name?> <?=($invoicedata->extra_calc_opt == 1)?"+":"-"?></td>
										<th style="text-align:right">
											<?=$currency_symbol?>
												<?=indian_number($invoicedata->extra_calc_amt * $exchangerate,2)?>
												 
										</th>
										  
									</tr>
									<?php 
									}
									 
									?>
									 
									<tr>
										<th colspan="4" rowspan="<?=($invoicedata->igst_status == 1)?"2":"4"?>" style="vertical-align:top;background:#ffc000;">
											THE GOODS EXPORT UNDER LETTER OF UNDERTAKING(LUT)  :  <?=$company_detail[0]->s_lutno?>  <?php if($invoicedata->igst_status==1)
													{
													?>
											<?php }
											else{?>
											-  WITH PAYMENT OF INTEGRATED TAX (IGST) 
											<?php }?>
                          
										</th> 
									 	<td rowspan="2"  style="font-weight:bold"><?=$totalgrossweight?></td>
										<td colspan="2" style="text-align:right">
											<?=($invoicedata->discount > 0)?"Discount":"&nbsp;"?>
										</td>
										<th  style="text-align:right">
											<?=($invoicedata->discount > 0)?$currency_symbol." ".indian_number($invoicedata->discount * $exchangerate,2):""?>	 
											  
										</th>
										 
									</tr>
									<tr>
									
										
										<th colspan="2" style="text-align:right">  INVOICE VALUE</th>
										<th style="text-align:right">
											<?=$currency_symbol?> <?=indian_number($invoicedata->grand_total,2)?> 
											  
										</th>
										 
									</tr>
									<?php
											if($invoicedata->igst_status==1)
											{
												?>
												<tr>
									 
										<th colspan="3" style="font-weight:bold">Invoice Value In Word</th>
										<td colspan="6">
											 <?=$invoicedata->terms_name?> VALUE SAYS <?=strtoupper(converttorsword($invoicedata->grand_total))?>    
										 
										 </td>
									</tr>
												<?php
											}
											else
											{
												$total = $invoicedata->indian_ruppe_after_gst +$invoicedata->grand_total;
											?>
									<tr>
									
										<th colspan="2" style="text-align:right"></th>
										<th colspan="2" style="text-align:right">
										 IGST 18%
											</th>
										<th style="text-align:right">
											 
											<?=$currency_symbol?> <?=indian_number($invoicedata->indian_ruppe_after_gst,2)?>
											 
										</th>
										 
									</tr>
									<tr>
									
										<th colspan="2" style="text-align:right"></th>
										<th colspan="2" style="text-align:right">
										Total Invoice Value
											</th>
										<th style="text-align:right">
											 
											<?=$currency_symbol?> <?=indian_number($total,2)?>
											 
										</th>
										 
									</tr>
									<tr>
									 
										<th colspan="3" style="font-weight:bold">Total Invoice Value In Word</th>
										<td colspan="7">
											 <?=$invoicedata->terms_name?> VALUE SAYS <?=strtoupper(converttorsword($total))?>    
										 
										 </td>
									</tr>
									<?php } ?>
									 
									<tr>
									 
										<th colspan="2" style="font-weight:bold">Remarks</th>
										<td colspan="7">
											 <?=$invoicedata->remarks?>    
										  </td>
									</tr>
									  
									<tr>
												 <td colspan="2"> Self Sealing Declaration	 </td>
											     <td colspan="4" style="font-weight:bold"> 
													(1) Certified That The Description & Value Of Goods Covered By This Invoice Have Been Checked By Me & That Goods Have Been Packed & Sealed With One Time Seal (OTS) Under My Direct Supervision 
													(2) We Have Follow The Procedure Laid Down In CBEC's Circular No. 426/59/98 CX Dt.12/10/1998 As Amemded Against This Shipment" 
												</td> 
												 <td colspan="3" rowspan="2" style="vertical-align:top;text-align:right;font-weight:bold">
													For <?=$company_detail[0]->s_name?>
													<br>
													<br>
													<br>
													<br>
													<br>
													 
													 <?=nl2br($company_detail[0]->authorised_signatury)?>
													</td>
												  
										 </tr>	
										<tr>
											<td colspan="4">
												Declaration: We Declare That This Invoice Shows The Actual Price Of The Goods Described & That All Particulars Are True And Correct 
											</td>
											<td colspan="2" style="text-align:center"> 
												CERTIFY THAT GOODS ARE OF <br>
												"INDIAN ORIGIN"										
											</td>
										</tr>
											
									</table>										
								<?php
									 $output = ob_get_contents(); 
									
									 $_SESSION['export_invoice_no'] = $invoicedata->export_ref_no;
									 $_SESSION['tax_content'] = $output;
									 if($mode=="1")
									 {
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
 
 	 
<?php $this->view('lib/footer'); ?>

 

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

function add_new_consigner()
{
	$(".modal").css('z-index','10000');
	 $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
    $("#myModal").css('z-index','1050');            
}
 

function  load_consigner(cidval){
		if(cidval==0)
		{
			add_new_consigner();
			return false;
		}
		else{
			 
			block_page();
        $("#consign_list").empty();
		$('#buyer_other_consign').text('');
        $('#country_final_destination').val('');
		$('#port_of_discharge').val('');
        $('#final_destination').val('');
        $.ajax({
          type :'POST',
          url  :root+'invoice/selectcompnay',
          data :{
            'e_id' : cidval,
            'type' : 'consigner'
          },
          success : function(msg){
            
			var obj=JSON.parse(msg);
            var data = obj.data1  
            var cdata = obj.data2  
            var cname= data['c_companyname'];
            var c_name= data['c_name'];
            var c_address = data['address'];
            var c_country = data['country_name'];
            var port_of_discharge = data['port_of_discharge'];
            var c_registration_detail = data['c_registration_detail'];
            var result = ""+cname+"\n"+c_address+"\n"+c_country+"\n"+c_registration_detail;
            var cname = cdata['consiger_name'];
            var i,content,j;
            $('#consign_detail').text(result);
			if(data.company_rules!='')
			{
				$('#customer_rules').show();
				$('#popoverData').popover();
				$('#customer_rules i').attr("data-content",data.company_rules);
				
			}
            $('#country_final_destination').val(c_country);
            $('#port_of_discharge').val(port_of_discharge);
            $('#final_destination').val(port_of_discharge);
            $("#consign_list").empty();
            $('#consigne_name').val(c_name);
            
             for (i=0;i<cdata.length;i++) {
               
                    content = "<div class='btn btn-default' onclick='selectotherconsigner("+cdata[i][1]+")' id="+cdata[i][1]+">"+cdata[i][0]+"</div>&nbsp;&nbsp;";
                    $("#consign_list").append(content);
				}
			  unblock_page('','');
          }
        })

      
	   }

}
function selectotherconsigner(id)
{
	 
      $.ajax({
      type :'POST',
      url  :root+'invoice/selectcompnay',
      data :{
        'e_id' : id,
        'type' : 'consignerid'
      },
      success : function(msg1){
         var obj1=JSON.parse(msg1);
		 var result = ""+obj1['address']+"\n"+obj1['city']+"\n"+obj1['state'];
		 
        $('#buyer_other_consign').text(result);
        $('#country_final_destination').val(obj1['country']);
        $('#port_of_discharge').val(obj1['port_name']);
        $('#final_destination').val(obj1['port_name']);
 
         }
      })
 
}
  
</script>
 
 