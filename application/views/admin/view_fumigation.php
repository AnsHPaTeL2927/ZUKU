	<?php 
	$this->view('lib/header'); 
	$no_of_container 	= $invoicedata->no_of_container;
	$container_size 	= $invoicedata->container_size;
	$exportinvoice_no 	= $invoicedata->exportinvoice_no;
	$export_date = date('d/m/Y',strtotime($invoicedata->export_date));
	$export_ref_no =  ($invoicedata->export_ref_no);
	$_SESSION['fumigation_content'] = '';
	$_SESSION['fumigation_no'] = '';
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
										<h3>View Fumigation</h3>
										<div class="pull-right form-group">
												<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export PDF</a>
											</div>
								</div>
							</div>
						</div>
					
						<div class="row">
							<div class="col-sm-12">
								<div class="panel-default">
									<div class="panel-heading">
										<i class="fa fa-external-link-square"></i>
											View Fumigation
									</div>
									
									<div class="panel-body">
									<div class="form-body">
										<?php ob_start();?> 	
											<table width="100%" style="margin-top:10px" cellspacing="0" cellpadding="0" class="main_table">
												<tr>
													<td style="padding:0px" width="5%"> </td>
													<td style="padding:0px" width="45%"></td>
													<td style="padding:0px" width="50%"></td>
													
												</tr>
												<tr>
																<td style="text-align:center;font-weight:bold" colspan="3">
														<h2>FUMIGATION CERTIFICATE</h2>
													</td>
												</tr> 
												
		
											
												<tr>
													<td style="font-weight:bold" colspan="3">

													<p>DPPQS Registration No.: <?=$invoicedata['dppqs_number']?><strong></strong></p>
													<p><strong>Treatment Certificate Number: <?=$invoicedata['treatment_certificate_number']?></strong></p>
													<p><strong>Date Of Issue: <?=date('d/m/Y',strtotime($invoicedata['date_of_issue']));?></strong></p>
		
													</td>
												</tr>
												
												<tr>
													<td style="text-align:center;font-weight:bold" colspan="3">

													This is to certify that the following regulated articles have been fumigated according to the appropriate procedures to confirm
													Phytosanitary requirements of the importing country:
		
													</td>
												</tr>
												<tr>
													<th  style="font-weight:bold">
														SR. NO.
													</th>
													<th>
														DETAILS OF INFORMATION
	
													</th>
													<th>
														PARTICULARS	
													</th>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														1
													</td>
													<td>
														Name & Address of  Consigner / Exporter
													</td>
													<td>
														<?=$invoicedata['consigner_exporter']?></td>	
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														2
													</td>
													<td>
														Declared Name & Address of  Consignee /     Importer
													</td>
													<td>
														<?=$invoicedata['consignee_importer']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														3
													</td>
													<td>
														Description of Goods

													</td>
													<td>
														<?=$invoicedata['description_of_goods']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														4
													</td>
													<td>
														Quantity Declared
													</td>
													<td>
														<?=$invoicedata['quantity_declared']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														5
													</td>
													<td>
														Distinguishing Marks
													</td>
													<td>
														<?=$invoicedata['distinguishing_marks']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														6
													</td>
													<td>
														Consignment Link / Container No.
													</td>
													<td>
														<?=$invoicedata['consignment_link_container_no']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														7
													</td>
													<td>
														RFID – E – SEAL
													</td>
													<td>
														<?=$invoicedata['rfid_e_seal']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														8
													</td>
													<td>
														Port & Country of  Loading
													</td>
													<td>
														<?=$invoicedata['port_country_of_loading']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													9
													</td>
													<td>
														Declared Point of Entry
													</td>
													<td>
														<?=$invoicedata['declared_point_of_entry']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													10
													</td>
													<td>
														Country of Destination
													</td>
													<td>
														<?=$invoicedata['country_of_destination']?>
													</td>
												</tr>
												<tr>
													<td colspan="3">
														<table border="1" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="3" style="font-weight:bold;text-align:center">DETAILS OF TREATMENT</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th style="font-weight:bold;text-align:center">Name Of Fumigant</th>
																	<th style="font-weight:bold;text-align:center">Date Of Treatment</th>
																	<th style="font-weight:bold;text-align:center">Place Of Fumigation</th>
																</tr>
																<tr>
																	<td style="text-align:center"><?=$invoicedata['fumigant_name']?></td>
															
																	<td style="text-align:center"><?=date('d/m/Y',strtotime($invoicedata['date_of_treatment']));?></td>
																	<td style="text-align:center"><?=$invoicedata['place_of_fumigation']?></td>
																</tr>
																<tr>
																	<th style="font-weight:bold;text-align:center">Dosage Rate Of Fumigant</th>
																	<th style="font-weight:bold;text-align:center">Duration Of Fumigation</th>
																	<th style="font-weight:bold;text-align:center">Minimum Air Temperature</th>
																</tr>
																<tr>
																	<td style="text-align:center"><?=$invoicedata['dosage_rate_of_fumigant']?> GMS / CU. M.</td>
																	<td style="text-align:center"><?=$invoicedata['duration_of_fumigation']?> HOURS</td>
																	<td style="text-align:center"><?=$invoicedata['minimum_air_temperature']?> DEG.C</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="3">
														<table border="1" style="width: 100%;">
															<tbody>
																<tr>
																	<td style="text-align:left">Fumigation has been performed in under gas tight sheet</td>
																	<td><?=$invoicedata['fumigation_under_gas_tight_sheet']?></td>
																	
																</tr>
																<tr>
																	<td style="text-align:left">Container Pressure Test Conducted</td>
																	<td><?=$invoicedata['container_pressure_test_conducted']?></td>
																	
																</tr>
																<tr>
																	<td style="text-align:left">Container has 200mm free air space at top of container</td>
																	<td><?=$invoicedata['container_free_air_space']?></td>
																	
																</tr>
																<tr>
																	<td style="text-align:left">In Transit Fumigation – Needs Ventilation at Port of Discharge</td>
																	<td><?=$invoicedata['in_transit_fumigation_ventilation']?></td>
																	
																</tr>
																<tr>
																	<td style="text-align:left">Container/Enclosure has been ventilated to below 5ppm v/v Methyl Bromide</td>
																	<td><?=$invoicedata['container_ventilation_below_5ppm']?></td>
																	
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan="3">
														<table border="1" style="width: 100%;">
															<thead>
																<tr>
																	<th colspan="3" style="font-weight:bold;text-align:center">WRAPPING AND TIMBER</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td style="text-align:left">Has the commodity been fumigated prior to lacquering, varnishing, painting, or wrapping?</td>
																	<td><?=$invoicedata['fumigation_prior_to_finishing']?></td>
																	
																</tr>
																<tr>
																	<td style="text-align:left">Has plastic wrapping been used in the consignment?</td>
																	<td><?=$invoicedata['plastic_wrapping_used']?></td>
																
																</tr>
																<tr>
																	<td style="text-align:left">If Yes, has the consignment been fumigated prior to wrapping?</td>
																	<td><?=$invoicedata['fumigated_prior_to_wrapping']?></td>
																	
																</tr>
																<tr>
																	<td style="text-align:left">Or has the plastic wrapping been slashed, opened or perforated in the timber in accordance with the Wrapping and Perforation standard?</td>
																	<td><?=$invoicedata['plastic_wrapping_slashed']?></td>
																	
																</tr>
																<tr>
																	<td style="text-align:left">Is the timber in this consignment less than 200mm thick in one dimension and correctly spaced every 200mm in height?</td>
																	<td><?=$invoicedata['timber_thickness_and_spacing']?></td>
																	
																</tr>
						
												
												</table>
												<br>
												<p><strong>ADDITIONAL DECLARATION: THIS CERTIFICATE IS VALID ONLY IF THE GOODS DESCRIBED ABOVE ARE SHIPPED WITHIN 21 DAYS FROM THE DATE OF FUMIGATION. AS PER ISPM-15</strong></p><hr>
												<p>I declare that these details are true & correct and the fumigation has been carried out in accordance with the ISPM-12</p><br>
												<p><strong>Name Of Accredited Fumigation Operator: <?=$invoicedata['nameof_accreditedfumigation']?></strong></p><br>
												<p><strong>DPPQS Accreditation card no: <?=$invoicedata['dppqs_accreditation_cardno']?> Dated: <?=date('d/m/Y',strtotime($invoicedata['dppqs_date']));?></strong></p><br>
												<p>•No liability attaches to certify company, Its proprietor or its representative with respect to this certificate</p><br>
												<p>•Consignment details declared by the shipper</p><br>
											</table>											
										
										
										<?php
										$output = ob_get_contents(); 
										$_SESSION['fumigation_no'] = $invoicedata->export_invoice_no;
										$_SESSION['fumigation_content'] = $output;
										
										
									?>
							
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
	function view_pdf(no)
	{
		if(no==1)
		{
			window.open(root+"fumigationpdf/view_pdf", '_blank');
		}
		else
		{
			window.location= root+"fumigationpdf/view_pdf";
		}
	//	if(no==1)
	//	{
	//		
	//	//	$(".main_table").table2excel({
	//    //     filename:  "VGM FOR <?=$invoicedata->export_invoice_no?>.xls",
	//	//	  sheetName: "VGM DATA",
	//    // });
	//	}
	//	else
	//	{
	//	//	 $(".main_table").table2excel({
	//    //     filename:  "VGM FOR <?=$invoicedata->export_invoice_no?>.xls",
	//	//	  sheetName: "VGM DATA",
	//    // });
	//	}
		
	}
	</script>
	<?php 
	if($mode=="1")
	{
		echo "<script>view_pdf(0)</script>";
	}
	?>
	