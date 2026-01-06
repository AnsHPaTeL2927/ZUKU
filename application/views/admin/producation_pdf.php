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
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
  
  
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
    $amountword = convertamonttousd($invoicedata->grand_total);
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
 
</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"producation_pdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"Producation_pdf/view_pdf";
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
									Producation PDF
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>Producation
									 <div class="pull-right form-group">
									 
										 <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
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
										<a href="<?=base_url()?>invoice_listing">Proforma Invoice List</a>
								</div>
                                <div class="">
								<div class="panel-body form-body">
								 <?php ob_start();?>
									<table border="1" width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="5" style="text-align:center;font-size: 25px;font-weight: BOLD;">Proforma Invoice</td>
										</tr>
										<tr>
											<td  colspan="5"  style="text-align:center;padding: 0;">
												<img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" width="100%">
											</td>
										</tr>
										<tr>
											<td rowspan="6" style="vertical-align:top"  width="40%">
												<strong><u>CONSIGNEE</u></strong><br>
												<?=$consig_add?> 
											 </td>
											<td style="text-align:center;" >PROFORMA INVOICE NO</td>
											<td style="text-align:center;" colspan="2">DATE</td>
											<td style="text-align:center;">I.E. CODE NO</td>
										</tr>
										<tr>
											<td style="text-align:center;"> 
												<strong><?=$invoicedata->invoice_no?> </strong></td>
											<td style="text-align:center;" colspan="2"> <strong><?=$performapacking_date?></strong></td>
											<td style="text-align:center;"><strong> <?=$company_detail[0]->s_iec?></strong></td>
										</tr>
										<tr>
											<td style="text-align:center;" colspan="2">COUNTRY OF ORIGINE OF GOODS
												<br/><strong><?=$invoicedata->country_origin_goods?></strong>
											</td>
											<td style="text-align:center;" colspan="2">COUNTRY OF FINAL DESTINATION
												<br/><strong><?=$invoicedata->country_final_destination?></strong>
											</td>
										</tr>
										<tr>
											<td style="text-align:center;" colspan="2">PORT OF LOADING
												<br/><strong><?=$invoicedata->port_of_loading?></strong>
											</td>
											<td style="text-align:center;" colspan="2">PORT OF DISCHARGE
												<br/><strong><?=$invoicedata->port_of_discharge?></strong>
											</td>
										</tr>
										<tr>
											<td style="text-align:center;" colspan="2">FINAL DESTINATION
												<br/><strong><?=$invoicedata->final_destination?></strong>
											</td>
											<td style="text-align:center;" colspan="2">TERMS OF DELIVERY AND PAYMENT 
												<br/><strong><?=$invoicedata->payment_terms?></strong>
											</td>
										</tr>
									</table>
										<table  border="1" width="100%" cellspacing="0" cellpadding="0">
											<tr>
												<th  style="text-align:center;" width="2%">SL</th>
												<th  style="text-align:center;" width="9%">SAMPLE NO</th>
												<th  style="text-align:center;" width="9%">Producation NO</th>
												<th  style="text-align:center;" width="7%">FINISHING</th>
												<th  style="text-align:center;" width="7%">Punch No</th>
												<th  style="text-align:center;" width="9%">SIZE IN CM</th>
												<th  style="text-align:center;" width="15%">IMAGES</th>
												<th  style="text-align:center;" width="6%">PALLETS</th>
												 <th  style="text-align:center;" width="6%">BOX PER PALLETS</th>
												<th  style="text-align:center;" width="6%">TOTAL BOX</th>
												<th  style="text-align:center;" width="6%">TOTAL SQ. MTR.</th>
												<th  style="text-align:center;" width="9%"><?=$invoicedata->terms_name?> RATE PER SQ MT(<?=$invoicedata->currency_name?>)</th>
												<th  style="text-align:center;" width="9%">TOTAL <?=$invoicedata->terms_name?> AMOUNT (IN <?=$invoicedata->currency_name?>)</th>
											</tr>
										<?php 
										$Total_plts = 0;
										$Total_box = 0;
										$Total_pallet_weight =0;
										$total_product_sqmlm=0;
										$total_amount=0;
										$no_of_row = 4;
										$hsnc_array = array();
										$no = 1;
										for($i=0; $i<count($product_data);$i++)
										{ 
				 
											$n = 1;
			 
											foreach($product_data[$i]->packing  as $packing_row)
											{
												if(!in_array($product_data[$i]->hsnc_code,$hsnc_array))
												{
										?>
												<tr>
												 	<th colspan="5" style="text-align:center;"> <?=$product_data[$i]->p_name?> </th>
													<th style="text-align:center;"> </th>
													<th style="text-align:center;"> </th>
													<th style="text-align:center;"> </th>
													<th style="text-align:center;"> </th>
													<th style="text-align:center;"> </th>
													<th style="text-align:center;"> </th>
													<th style="text-align:center;"> </th>
													<th style="text-align:center;"> </th>
												</tr>
												<?php
														array_push($hsnc_array,$product_data[$i]->hsnc_code);
												}	
												if(!in_array($product_data[$i]->exportproduct_trn_id,$size_array) && $product_data[$i]->exportproduct_trn_id == $jsondata->exportproduct_trn_id)
												{	
 										
												?>
												<tr>
														<td style="text-align:center"><?=$no?></td>
														<td style="text-align:center"><?=$packing_row->model_name?></td>
														<td style="text-align:center"><?=$packing_row->client_name?></td>
														<td style="text-align:center"><?=$packing_row->finish_name?></td>
														<td style="text-align:center"><?=$packing_row->barcode_no?></td>
														<td style="text-align:center"><?=$product_data[$i]->size_type_cm?>
															<br>
															PCS/Box : <?=$product_data[$i]->pcs_per_box?> <br>
															SQM/BOX : <?=$product_data[$i]->sqm_per_box?>
														</td>
														<td style="text-align:center">
															<p style="margin: 0 auto;width:50px;height:50px;overflow:hidden;position: relative;">
																<img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:60px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;"/> 
														</p>
															
														</td>
														<td style="text-align:center">
															<?php 
																if($packing_row->no_of_pallet>0)
																{
																	$no_of_pallet = $packing_row->no_of_pallet;
																	$Total_plts 	+= $no_of_pallet;
											
																}
																else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
																{
																	$big= ($packing_row->no_of_big_pallet > 0)? $packing_row->no_of_big_pallet:'';
																	$small= ($packing_row->no_of_small_pallet > 0)? $packing_row->no_of_small_pallet:'';
																	$no_of_pallet =  $big.'<br>'.$small;
																	$Total_plts 	+= $big;
																	$Total_plts 	+= $small;
											
																}
																else
																{
																	$no_of_pallet =  '-';
																}
															?>
															<?=$no_of_pallet?>
															</td>
							
														<td style="text-align:center">
															<?php 
																if($packing_row->no_of_pallet>0)
																{
																	$boxes_per_pallet =  $product_data[$i]->boxes_per_pallet;
																	
																}
																else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
																{
																	$big= ( $product_data[$i]->box_per_big_pallet > 0)? $product_data[$i]->box_per_big_pallet:'';
																	$small= ( $product_data[$i]->box_per_small_pallet > 0)? $product_data[$i]->box_per_small_pallet:'';
																	$boxes_per_pallet =  $big.'<br>'.$small;
																}
																else
																{
																	$boxes_per_pallet =  '-';
																}
															?>
															<?=$boxes_per_pallet?>
														</td>
													 	<td style="text-align:center"><?=$packing_row->no_of_boxes?> </td>
													 	<td style="text-align:center"><?=$packing_row->no_of_sqm?></td>
														<td style="text-align:center"><?=$currency_symbol?><?=$packing_row->product_rate?></td>
														<td style="text-align:center"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2)?></td>
													</tr>
								<?php
								$Total_box 		+= $packing_row->no_of_boxes;
								$Total_sqm 		+= $packing_row->no_of_sqm;
								$Total_ammount 	+= $packing_row->product_amt;
								 
											
					$no_of_row--;	
					$no++;
			}
			  }
		 }
			for($row=0;$row<=$no_of_row;$row++)
			{	 
			?>
			 <tr>
				<td style="border-bottom:none;border-top:none" height="91px">&nbsp;</td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
				<td style="border-bottom:none;border-top:none"></td>
			</tr>
			<?php }  ?>
			<tr>
									<td colspan="7" style="text-align:right"><strong>Total >>>>>>>>>>>>>>></strong></td>
									<td style="text-align:center"><?=$Total_plts?></td>
									 <td style="text-align:right"></td>
									<td style="text-align:center"><?=$Total_box?></td>
								 	<td style="text-align:center"><?=$Total_sqm?></td>
									<td style="text-align:right"></td>
									<td style="text-align:right"><?=$currency_symbol?><?=$Total_ammount?> </td>
								</tr>
								<tr>
									<td colspan="8" style="text-align:center;"> <strong>WORDS IN <?=$invoicedata->currency_name?>:- </strong><?=convertamonttousd($Total_ammount)?>  ONLY</td>
									<td colspan="4"  style="text-align:center;"><strong>TOTAL AMOUNT IN <?=$invoicedata->currency_name?>.</strong></td>
									<td style="text-align:right"><?=$currency_symbol?><?=$Total_ammount?></td>
								</tr>
			 
								<tr>
								<td  colspan="8">
									<strong>BANK NAME : </strong><?=$bank->bank_name?><br />
								 	<strong>A/C. NAME : </strong><?=$bank->account_name?> <br />
									<strong>ADDRESS : </strong><?=$bank->bank_address?><br /> 
									<strong>A/C. NO. : </strong><?=$bank->account_no?><br />
									<strong>SWIFT CODE : </strong><?=$bank->swift_code?><br />
									<strong>BRANCH CODE: </strong><?=$bank->ifsc_code?><br />
								</td>
								<td  colspan="5"><b>Terms of delivery and Packing:</b><br/>
									1, Total <?=$invoicedata->container_details?> container Value <?=$invoicedata->terms_name?> <?=$invoicedata->terms_of_delivery?><br/>
									2, Packing should be in <?=$invoicedata->pallet_type_name?><br/>
									3, Loading in <?=$invoicedata->delivery_period?><br/>
									4, Price are valid till 10 days from the date of proforma invoice<br/>
									5, Maximum loading capacity is <?=$invoicedata->limit_container?>
								</td>
								<tr>
							<tr>
								<td colspan="8">
									<b>Correspondent Bank Details:-</b><br/>
									Bank Name : JPMorgan Chase Bank, New York.<br/>
									A/c No. - 001-1-406717, Swift Code - CHASUS33<br/>
									Fed Wire Code - FEDWIRE ABA: 021000021, CHIPS ABA: 0002, CHIPS UID#354459
								</td>
								<td rowspan="2" colspan="5">FOR, <?=$company->s_name?><br/>
										<img src="<?=base_url().'upload/'.$company->s_c_sign?>" height="70px" width="180px">
															 <br/>
										<?=$company->authorised_signatury?></td>
							</tr>
								<tr>
									<td style="text-align:center;" colspan="8"><b>Declaration:</b><br/>
 AND THAT ALL PARTICULARS ARE TRUE AND CORRECT.<br/>
WE DECLARE THAT THIS INVOICE SHOWS THE ACTUAL PRICE OF THE GOODS DESCRIBED </td>
			</tr>
			<tr>
				<td colspan="14"  style="text-align:center;">ALL GOODS ARE INDIAN ORIGIN</td>
			</tr>
			<tr>
				<td colspan="14"  style="text-align:center;padding:0">
					<img src="<?=base_url()?>/adminast/footer.png"   width="100%">
				</td>
			</tr>
		</table>					 	<?php
								 
									 $output = ob_get_contents(); 
									 $_SESSION['performainvoice_no'] = $invoicedata->invoice_no.' - '.$invoicedata->country_final_destination.' - '.date('d-m',strtotime($invoicedata->performa_date));
									 $_SESSION['producation_content'] = $output;
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
 function Export() {
      $(".main_table").table2excel({
          filename:  "<?=$invoicedata->invoice_no?>.xls",
		  sheetName: "PI",
      });
  }
</script>