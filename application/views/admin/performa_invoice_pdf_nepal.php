<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
$export =  ($invoicedata->exporter_detail);
$performapacking_date = date('d/m/Y',strtotime($invoicedata->performa_date));
$consig_add =  ($invoicedata->consign_detail);
$buyother = ($invoicedata->buyer_other_consign);
$payment_terms =  ($invoicedata->payment_terms);
$time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";
$locale='en-US'; //browser or user locale
// $currency=$invoicedata->currency_code; 
// $fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
// $currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
$currency_symbol = ($invoicedata->currency_code=="INR")?"<img src='".base_url()."adminast/assets/images/ruppe_sysbol.jpg' width=6 height=6 />":$currency_symbol;  
$currency_symbol_inr =  "<img src='".base_url()."adminast/assets/images/ruppe_sysbol.jpg' width=7 height=7 />";  

$certification_charge = ($invoicedata->certification_charge>0)? $currency_symbol.' '.$invoicedata->certification_charge:'';
$courier_charge = ($invoicedata->courier_charge>0)? $currency_symbol.' '.$invoicedata->courier_charge:'';
$bank_charge = ($invoicedata->bank_charge>0)? $currency_symbol.' '.$invoicedata->bank_charge:'';
$certification_charge = ($invoicedata->certification_charge>0)? $currency_symbol.' '.$invoicedata->certification_charge:'';
$insurance_charge = ($invoicedata->insurance_charge>0)?$currency_symbol.' '.$invoicedata->insurance_charge:'';
$seafright_charge = ($invoicedata->seafright_charge>0)?$currency_symbol.' '.$invoicedata->seafright_charge:'';
$final_total = $invoicedata->grand_total;
$discount = ($invoicedata->discount>0)?$currency_symbol.' '.$invoicedata->discount:'';
  if($invoicedata->grand_total != '')
  { 
    $amountword = convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name);
  }
 
  else{
    $amountword = 'Zero';
  }
  $invoicevalue_say = $invoicedata->terms_name;
  
?>
<style>
table {
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	page-break-inside:avoid;
}
table.packing{
	
}
td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
th {
 	border: 0.5px solid #333;
	padding: 3px; 
}
 .profile-pic {
	position: relative;
	 
	padding: 2px;
}

.profile-pic:hover .edit {
	display: block;
	
}
.profile-pic:hover
{
	border: 1px solid #036df0;
}
.edit {
	padding-top: 7px;	
	padding-right: 7px;
	position: fixed;
	right: 13px;
	 
	display: none;
}

.edit a {
color: blue;
}

</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"performa_invoice_pdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"performa_invoice_pdf/view_pdf";
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
									<a href="javascript:void(0)">
										Dashboard
									</a>
								</li>
								<li class="active">
									PDF
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>Proforma Invoice
									 <div class="pull-right">
										
										<div class="dropdown" style="float:left;">
										<button class="btn btn-primary dropdown-toggle" style="width:75px;" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="<?=base_url('performa_invoice_pdf/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>	
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('performa_invoice_pdf/index_withoutfinish/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="<?=base_url('performa_invoice_pdf/index_withthickness/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="<?=base_url('performa_invoice_pdf1/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="<?=base_url('performa_invoice_pdf2/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="<?=base_url('performa_invoice_pdf3/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf4/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_olwin/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10</a>	
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf11/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 11 (Without Pallet)</a>
												
											 </li>											 
											</ul>
										</div>&nbsp;
									
										 <a class="btn btn-info tooltips"  data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
										
								</div>
								</h3>
								
							 </div>
						 </div>
					</div>
				 <div class="row">
						<div class="col-sm-12">
						<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
										<a href="<?=base_url()?>invoice/form_edit/<?=$invoicedata->performa_invoice_id?>">Edit Proforma Invoice</a>
								</div>
                                <div class="">
								<div class="panel-body form-body">
								<?php 
								if(!empty($invoice_html_data))
								{
									echo '<div class="pull-right">
											<a class="btn btn-danger tooltips" data-title="Delete" href="javascript:;"  onclick="delete_editable('.$invoicedata->performa_invoice_id.')"   ><i class="fa fa-trash"></i> Delete (Edited version)</a>
										</div>	
										';
								}
								?>
								 <?php ob_start();?>
								 <div id="tableHolder">
								 <div class="profile-pic" style="margin-top:80px;">
										<div class="edit pull-right">
											<a href="javascript:;" style="color:#fff;font-size:12px" class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i class="fa fa-pencil fa-lg"></i>  Edit</a>
											<a href="javascript:;" class="invoice_update_btn btn btn-success" style="display:none;color:#fff" onclick="edit_invoice();">Save</a>
										</div>
									<div class="save_invoice_html">
									<?php 
								
								if(!empty($invoice_html_data))
								{
									echo $invoice_html_data->invoice_html;
								}
								else
								{
									?>
									<table cellspacing="0"  border="1" cellpadding="0"  width="100%" class="main_table excel_cls invoice_edit_cls">
										<tr>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "9%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
											<td width = "8%" style="border:0px;padding:0px"></td>
										</tr>
										<tr>
											
											<td colspan="12" style="text-align:center;">
												<strong style="font-size: 20px;"> PROFORMA INVOICE</strong>
											</td>
									 	</tr>
										<tr>
											<td colspan="6"  style="">
												 <strong>EXPORTER/MANUFACTURER</strong>										
											</td>
											
											<td colspan="6" style="border-top:none;border-bottom: none;">
												<strong>PI NO : </strong><span style=""> <?=strtoupper($invoicedata->invoice_no)?></span>
											</td>
												 
									 	</tr>
										<tr>
											<td rowspan="4" colspan="3"  style="border-right:none">
												<?=$export?>
												EMAIL:<?=$company_detail[0]->s_email?>
											</td>
											<td rowspan="4" colspan="3"  style="border-left:none">	
												 <!--<img src="<?=base_url().'upload/'.$company_detail[0]->s_image?>" style="width:150px;height:70px" />-->
											</td>
											 	<td  colspan="6"  style="border-top:none;border-bottom: none;">
													<strong>DATE : </strong><?=strtoupper($performapacking_date)?>
											 	</td>
												 
									 	</tr>
										<tr>
											 	<td colspan="6" style="border-top:none;border-bottom: none;">
								
													<strong> <?=!empty($invoicedata->buy_order_no)?'Buyer Order No & Date : '.$invoicedata->buy_order_no:''?>  </strong>  
											 	</td>
												
												
									 	</tr>
										<tr>
										 	<td colspan="6" style="">
												 <strong> PAYMENT TERMS </strong>
												</td> 
									 	</tr>
										<tr>
										 	<td colspan="6" style="vertical-align:top;">
												 <?=strtoupper($payment_terms)?> <br>
												 RATE : <?=$invoicevalue_say?> (IN <?=$invoicedata->currency_name?>)
											</td>
									 	</tr>
										 <tr>
										 	<td colspan="6"  style="">
												 <strong>CONSIGNEE DETAILS</strong>										
											</td>
											<td colspan="6" style="">
												 <strong>EXPORTER BANK DETAILS </strong>				
											</td>
									 	</tr>
										<tr>
											 <td colspan="6" style="vertical-align:top;">
												 <?=strtoupper($buyother)?> 
											</td>
											<td colspan="6">
												<strong>BANK NAME : </strong><?=strtoupper($bank->bank_name)?><br />
													 
												<strong>A/C. NAME : </strong><?=strtoupper($bank->account_name)?> <br />
												<strong>ADDRESS : </strong><?=strtoupper($bank->bank_address)?><br /> 
												<strong>A/C. NO. : </strong><?=strtoupper($bank->account_no)?><br />
												<strong>SWIFT CODE : </strong><?=strtoupper($bank->swift_code)?><br />
												<strong>BRANCH CODE: </strong><?=strtoupper($bank->ifsc_code)?><br />
											</td>
									 	</tr>
										 
										<tr>
											<th colspan="3" style="text-align:center">NUMBER OF CONTAINER</th>
											<th colspan="3"  style="text-align:center"> PORT OF LOADING </th>
											<th colspan="3"  style="text-align:center">PORT OF DISCHARGE </th>
											<th colspan="3"  style="text-align:center">COUNTRY OF FINAL DESTINATION </th>
									 	</tr>
										<tr>
											<td colspan="3"  style="text-align:center">
											<?php
												if(!empty($invoicedata->container_twenty))
												{
													echo $invoicedata->container_twenty.' X 20';
												}
												if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
												{
														echo ",";
												}
												if(!empty($invoicedata->container_forty))
												{
													echo  $invoicedata->container_forty.' X 40';
												}
												 ?> FEET </td>
											<td colspan="3"  style="text-align:center"> <?=strtoupper($invoicedata->port_of_loading)?>  </td>
											<td colspan="3"  style="text-align:center">  <?=strtoupper($invoicedata->port_of_discharge)?>  </td>
											
											<td colspan="3" style="text-align:center"> <?=strtoupper($invoicedata->country_final_destination)?>	 </td>
									 	</tr>
									</table>
				 <table  width="100%" cellspacing="0" cellpadding="0" style="padding:5px" class="pdf_class invoice_edit_cls" contenteditable="false">
				 <?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_ammount=0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$no_of_row = 5;
								 	$hsn_array = array();
								$performa_trn_array = array();
								
	  							for($j=0; $j<count($product_data);$j++)
								{ 
									 
									
											if(!in_array($product_data[$j]->series_name.' - HSN CODE '.$product_data[$j]->hsnc_code,$hsn_array))
											{												
												array_push($hsn_array,$product_data[$j]->series_name.' - HSN CODE '.$product_data[$j]->hsnc_code);
											}
								}										
									?>
                  <tr>
                    <td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="15%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="10%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="8%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                    <td style="padding:0;border-top:none;border-bottom:none" width="9%"></td>
                  </tr>
				
                  <tr>
                    <td  style="text-align:center;font-weight:bold">SHIPPING MARKS &amp; NOS.</td>
                    <td colspan="9"  style="text-align:center;font-weight:bold">DESCRIPTION OF GOODS</td>
                    
                  </tr>
                  <tr>
                    <td style="text-align:center;font-weight:bold"> 
					<!--<?=$Total_box?>--></td>
                    <td colspan="5" style="text-align:center;font-weight:bold">
					 
										 		
						<?=implode(",",$hsn_array)?>
																	
					
					</td>
            
                 
                    <td rowspan="2" style="text-align:center;font-weight:bold">TOTAL BOXES</td>
                    <td rowspan="2"style="text-align:center;font-weight:bold"> TOTAL SQUARE METER </td>
					<td rowspan="2"style="text-align:center;font-weight:bold">PRICE PER BOX INR</td>
					<td rowspan="2"style="text-align:center;font-weight:bold">TOTAL (INR)</td>
                  
                  </tr>
				  
				  <tr>
                    <td style="text-align:center;font-weight:bold"> </td>
                    <td colspan="2" style="text-align:center;font-weight:bold">SIZE</td>
                    <td style="text-align:center;font-weight:bold">PCS PER BOX</td>
                    <td colspan="2" style="text-align:center;font-weight:bold">SQM PER BOX</td>
                  
                  </tr>
				    <?php
								$no=1;
								for($i=0; $i<count($product_data);$i++)
								{ 
									$Total_box 	+= $product_data[$i]->total_no_of_boxes;
									
									 $Total_ammount += $product_data[$i]->total_product_amt;
									 
									 $Total_weight  += $product_data[$i]->total_gross_weight;
									 $Total_nweight  += $product_data[$i]->total_net_weight;
													?>
                  <?php
								foreach($product_data[$i]->packing  as $packing_row)
								  {
									  ?>
										 		
                 <tr>
					<td style="text-align:center" ></td>
                    <td colspan="2" style="text-align:center" ><?php
															if(!empty($product_data[$i]->size_type_mm))
															{
															?>
                      
                      <?=$product_data[$i]->size_type_mm?>
                      
                      <?php
																}
								  
								
																
																
																	?></td>
								  
                    <td style="text-align:center"><?=$product_data[$i]->pcs_per_box?></td>
                   
					
					<?php 
										if($invoicedata->per_value == "SQF")
										{
											?>
											<td colspan="2" style="text-align:center;border-bottom: none;border-right: none;">
											
											<?=number_format(($packing_row->no_of_boxes * $product_data[$i]->feet_per_box),2,'.','')?>
											
											</td>
										<?php 
										 $Total_sqm 	+= $packing_row->no_of_boxes * $product_data[$i]->feet_per_box;
										}
										else if($invoicedata->per_value == "BOX")
										{
											?>
										<td colspan="2" style="text-align:center;border-bottom: none;border-right: none;">
										 	<?=number_format($packing_row->no_of_boxes,2,'.','')?>
									 	</td>
											<?php
											$Total_sqm 	+= $packing_row->no_of_boxes;
										}
										else 
										{
										?>
										<td colspan="2" style="text-align:center;border-bottom: none;border-right: none;">
										
										<?=number_format($packing_row->no_of_sqm,2,'.','')?>
										
										</td>
										<?php 
										$Total_sqm 	+= $packing_row->no_of_sqm;										
										}
										?>
					
                    <?php 
															$product_rate_1 	= $product_desc_array[$product_desc_array[$p]]['product_rate_1'];
															$product_rate 	= $product_desc_array[$product_desc_array[$p]]['product_rate'];
															$product_amt 	= $product_desc_array[$product_desc_array[$p]]['amount'];
															$product_amt_inr 	= $product_desc_array[$product_desc_array[$p]]['amount_inr'];
															$performa_per 	= $product_desc_array[$product_desc_array[$p]]['performa_per'];
															//if($performa_per == "SQF")
															//{
															//	$feet =  $product_desc_array[$product_desc_array[$p]]['boxes'] * $product_desc_array[$product_desc_array[$p]]['feet_per_box'];
															//	
															//	$product_rate = $product_amt/$feet;
															//}
															//else if($performa_per == "BOX")
															//{
															//	$box =  $product_desc_array[$product_desc_array[$p]]['boxes'];
															//	$product_rate = $product_amt/$box;
															//}
															//else if($performa_per == "SQM")
															//{
															//	$sqm =  $product_desc_array[$product_desc_array[$p]]['sqm'];
															//	$product_rate = $product_amt/$sqm;
															//}
															//else if($performa_per == "PCS")
															//{
															//	$pcs =  $product_desc_array[$product_desc_array[$p]]['boxes'] * $product_desc_array[$product_desc_array[$p]]['pcs_per_box'];
															//	$product_rate = $product_amt/$pcs;
															//}
																?></td>
                    <td style="text-align:center"><?=$packing_row->no_of_boxes?></td>
                    <td style="text-align:center"><?=number_format($packing_row->no_of_sqm,2,'.','')?></td>
                    <td style="text-align:center"><?=$currency_symbol?><?=number_format($packing_row->product_rate,2,'.','')?></td>
                    <td style="text-align:center"><span style="text-align:center">
                     <?=$currency_symbol?><?=number_format($packing_row->product_amt,2,'.','')?></td>
                  </tr>
                  <?php
											$no_of_row -=1;
									 	$no++;
										$Total_box += $category->packing_boxes;
													}
												}
								
											if(count($sample_data)!=0)
											{	
												?>
                  <tr>
                    <td style="text-align:center;border-bottom:hidden">&nbsp;</td>
                    <td style="font-weight:bold;text-align:center;border-bottom:hidden" colspan="2"> Sample </td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                   
                    <td style="text-align:center;font-weight:bold;border-bottom:hidden"></td>
                    <td style="text-align:center;border-bottom:hidden"></td>
                  </tr>
                  <?php
											}	
											 $no_of_row -= 1;
											 $sample=1;
											 $no++;
											foreach ($sample_data as $jsondata)
											{
											?>
                  <tr>
                    <td style="border-right:0.5px solid #333;text-align:center;">&nbsp;</td>
                    <td style="border-right:0.5px solid #333;text-align:center" colspan="2"><?=$jsondata->product_size_id?>
                      -
                      <?=$jsondata->sample_remarks?></td>
                    <td  style="border-right:0.5px solid #333;text-align:center" > - </td>
                    <td  colspan="2" style="border-right:0.5px solid #333;text-align:center" > - </td>
                    
                    <td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->no_of_boxes?></td>
                    <td  style="border-right:0.5px solid #333;text-align:center"><?=$jsondata->sqm?></td>
                    <td  style="border-right:0.5px solid #333;text-align:center"><?=!empty($jsondata->sample_rate)?$currency_symbol.$jsondata->sample_rate:"FOC"?></td>
                    <td style="border-right:0.5px solid #333;text-align:center"><?=!empty($jsondata->sample_amout)?$currency_symbol.$jsondata->sample_amout:"FOC"?></td>
                  </tr>
                  <?php
												$no++;
													 $no_of_row -= 1;	 
													$totalnetweight 	+= 	$jsondata->netweight;
													$totalgrossweight 	+= 	$jsondata->grossweight; 
													$Total_ammount 	+= $jsondata->sample_amout;
													$Total_ammount_inr 	+= $jsondata->sample_amout;
													//$Total_ammount_inr 	+= $jsondata->sample_amout;
													$Total_amt 		+= $jsondata->sample_amout;
											}
										 	for($row=$no_of_row;$row>0;$row--)
											{ 
											 ?>
                <!--  <tr>
                    <td style="border:none;border-right:0.5px solid #333;border-left:0.5px solid #333;">&nbsp;</td>
                    <td colspan="2" style="border:none;border-right:0.5px solid #333;height: 31px;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td>
                    <td  style="border:none;border-right:0.5px solid #333;"></td> 
				    </tr>-->
                  <?php
											$no_of_row--;
											}
										?>
                  <tr>
                    <td colspan="6" style="font-weight:bold;vertical-align:middle; text-align:center;border-top:0.5px solid #333;border-right:0.5px solid #333;">
					 <!-- GROSS WEIGHT: <?=number_format($Total_weight,2)?><br>
					  NET WEIGHT: <?=number_format($Total_nweight,2)?>-->
                      </td>
					  <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						
					</td>
					 <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						
					</td>
               
                   
                   
                  </tr>
                  <tr>
                   
                    
                  </tr>
                  <?php
										$Total_amt =($invoicedata->calculation_operator == 2)?$Total_amt - $invoicedata->certification_charge:$Total_amt + $invoicedata->certification_charge;  ?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center" colspan="2"> 
						NO. & KIND OF PKGS
					</td>
                  <td  colspan="4" rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" ><span style="font-weight:bold;vertical-align:top;text-align:center">TOTAL<strong> </strong></span></td>
				   <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;">
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                     <?=$Total_box; ?>
                      </span>
					</td>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="font-weight:bold;text-align:center">
                      <?=number_format($Total_sqm,2,'.',''); ?>
                      </span></td>
                    <td  rowspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;"><span style="text-align:center"> TOTAL VALUE </span></td>
                    <td rowspan="2" style="border-top:0.5px solid #333;font-weight:bold;text-align:right">
                     <?=$currency_symbol?><?=number_format($Total_ammount,2,'.',',')?> </td>
                  </tr>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center">
					<?=$Total_box; ?>
					</td>
					<td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;text-align:center">
					BOXES
					</td>
                   
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:center;" >
					<span style="font-weight:bold;vertical-align:top;text-align:center">
                     BOXES
                      </span>
					</td>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;font-weight:bold;">SQ. MTR</td>
                 
                   
                  </tr>
                
                  <?php  $Total_ammount_inr =($invoicedata->calculation_operator == 2)?$Total_ammount_inr - $invoicedata->seafright_charge:$Total_ammount_inr + $invoicedata->seafright_charge; 
										  $Total_ammount_inr += $invoicedata->courier_charge; 
										  $Total_ammount_inr += $invoicedata->bank_charge; 
									if(!empty($invoicedata->extra_calc_name))
									{
									 	 ?>
										 <tr>
										  <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"> </td>
                    <td style="border-right:0.5px solid #333;border-top:0.5px solid #333;text-align:center;" colspan="2"><?=$invoicedata->extra_calc_name?> <?=($invoicedata->extra_calc_opt == 1)?"+":"-"?></td>
                    <td  style="border-bottom:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?>
                      <?=number_format($invoicedata->extra_calc_amt,2,'.','')?></td>
                  </tr>
									<?php
									 $Total_ammount_inr =($invoicedata->extra_calc_opt == 1)?$Total_ammount_inr + $invoicedata->extra_calc_amt:$Total_ammount_inr - $invoicedata->extra_calc_amt; 
									}
									?>
				 
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;text-decoration:underline;vertical-align:top;" colspan="7">TOTAL AMOUNT INR: <span style="text-align:center">
                    
                      </span></td>
                    <td colspan="2" style="border-right:0.5px solid #333;border-top:0.5px solid #333;border-bottom:0.5px solid #333;text-align:center"></td>
                    <td  style="font-weight:bold;text-align:right"></td>
					
                  </tr>
                  <?php 
					//$Total_ammount_inr =($invoicedata->extra_calc_opt == 1)?$Total_ammount_inr + $insurance_charge_final:$Total_ammount_inr - $insurance_charge_final; 
					?>
                  <tr>
                    <td  style="border-right:0.5px solid #333;border-top:0.5px solid #333;font-weight:bold;vertical-align:top;" colspan="7"><?=strtoupper(convertamonttousd($Total_ammount,$currency_symbol_inr))?>
                      ONLY </td>
                    <td colspan="2" style="border-right:0.5px solid #333;text-align:center">
                      TOTAL AMOUNT
                      </td>
                      <td  style="border-top:0.5px solid #333;font-weight:bold;text-align:right"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.',',')?> </td>
                  </tr>
                  
                  <tr>
                    <td rowspan="2" valign="top" style="border-right:0.5px solid #333;border-top:0.5px solid #333;" colspan="4"> Declaration <br />
                     We declared that this invoice shows the actual price of the goods described & that all particulars are true and correct. </td>
                    <td height="50" colspan="6" valign="top" style="border-top:0.5px solid #333;border-bottom:none;text-align:right">FOR, 
					<?=$company_detail[0]->s_name?>
						<br>
						<img src="<?=base_url()?>upload/<?=$company_detail[0]->s_c_sign?>"  width="150px" height="80px"/>
                      <br />
                      <br /></td>
                  </tr>
                  <tr>
             
                    <td colspan="6" style="text-align:right;border-top:none" valign="bottom"><?=nl2br($company_detail[0]->authorised_signatury)?>
                      <br></td>
                  </tr>
                </table>	
								<?php
								}
								?>
											</div>		 
										</div>
								</div>
									<?php
								  $output = ob_get_contents(); 
									 $_SESSION['performa_invoice_no'] = $invoicedata->invoice_no.' - '.$consig_add.' - '.$invoicedata->country_final_destination.' - '.date('d-m',strtotime($invoicedata->performa_date));
									 $_SESSION['performa_content'] = $output;
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
<script src="<?=base_url()?>adminast/assets/js/jquery.table2excel.js"></script>
<script>
 function delete_editable(performa_invoice_id)
{
	Swal.fire({
  title: 'Delete Editable Version?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
		 if (result.value) {
	block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"performa_invoice_pdf/delete_editable",
       data:
	   {
			"performa_invoice_id"	: performa_invoice_id,
			"performa_invoice_pdf"	: 'performa_invoice_accord_pdf'
	   }, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
  }
		});
}
function editable_table()
{
	$(".invoice_edit_cls").attr("contenteditable",true)
	$(".invoice_edit_btn").hide();
	$(".invoice_update_btn").show();
}
function edit_invoice()
{
	 block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"customerinvoiceview/performa_html_update",
       data:
	   {
			"performa_invoice_id"	: <?=$invoicedata->performa_invoice_id?>, 
			"invoice_html"			: $(".save_invoice_html").html(),  
			"invoice_table_name"	: 'performa_invoice_accord_pdf'  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}
 
function toExcel() {

    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#tableHolder').html()));
    e.preventDefault();
}
</script>