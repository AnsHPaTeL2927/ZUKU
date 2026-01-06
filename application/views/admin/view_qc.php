<?php 
	$this->view('lib/header'); 
	$no_of_container 	= $invoicedata->no_of_container;
	$container_size 	= $invoicedata->container_size;
	$exportinvoice_no 	= $invoicedata->exportinvoice_no;
	$export_date = date('d/m/Y',strtotime($invoicedata->export_date));
	$export_ref_no =  ($invoicedata->export_ref_no);
	$_SESSION['qc_content'] = '';
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
										<a href="<?=base_url().'producation_detail'?>">Production List</a>
									</li>
									
								</ol>
								<div class="page-header title1">
										<h3>View QC</h3>
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
											View QC
									</div>
									
									<div class="panel-body">
									<div class="form-body">
										<?php ob_start();?> 	
										<table width="100%" style="margin-top:10px" cellspacing="0" cellpadding="0" class="main_table">
												<tr>
													<td style="padding:0px" width="70%" > </td>
													<td style="padding:0px" width="30%"></td>
													
													
												</tr>
											
												<tr>
													<td style="text-align:center;font-weight:bold;background-color:#84b2d9;height:50px; font-size:13x;">

													INSPECTION INFORMATION FORM
		
													</td>
													<td style="text-align:center;font-weight:bold;background-color:#84b2d9; height:50px; font-size:13x;"  >

													QC NO: <?=$invoicedata['qc_no']?>
		
													</td>
												</tr>
												
												
												
												
												
										</table>
											<table width="100%" style="margin-top:10px" cellspacing="0" cellpadding="0" class="main_table">
												<tr>
													<td style="padding:0px" width="5%"> </td>
													<td style="padding:0px" width="45%"></td>
													<td style="padding:0px" width="50%"></td>
													
												</tr>
											<!--	<tr>
													<td style="padding:0;border-top:none;border-bottom:none" colspan="3">
															<img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" width="100%" height="120px"  />
													</td>
												</tr> 
											-->
												<!--<tr>
													<td style="text-align:center;font-weight:bold;background-color:#6887a1;" colspan="2" >

													INSPECTION INFORMATION FORM
		
													</td>
													<td style="text-align:center;font-weight:bold;background-color:#6887a1;" >

													QC NO: <?=$invoicedata['qc_no']?>
		
													</td>
												</tr>-->
												<!--<tr>
													<th  style="font-weight:bold">
														SR. NO.
													</th>
													<th>
														
	
													</th>
													<th>
														
													</th>
												</tr>-->
												<tr>
													<td  style="font-weight:bold">
														1
													</td>
													<td>
															Plant Name & Address
													</td>
													<td>
														<?=$invoicedata['plantname_address']?></td>	
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														2
													</td>
													<td>
															Plant Owner & Contact No
													</td>
													<td>
														<?=$invoicedata['plantowner_contactno']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														3
													</td>
													<td>
															Plant Contact Person & No

													</td>
													<td>
														<?=$invoicedata['plantcontactperson_no']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														3
													</td>
													<td>
															QC Image

													</td>
													<td>
													<img src="<?=base_url().'upload/QcImage/'.$invoicedata['qc_image']?>" width="50px" height="50px"  />
														
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														4
													</td>
													<td>
															PO/PI Details
													</td>
													<td>
														<?=$invoicedata['po_pi_details']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														5
													</td>
													<td>
															Product Type
													</td>
													<td>
														<?=$invoicedata['product_type']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														6
													</td>
													<td>
															Design Name & Quantity
													</td>
													<td>
														<?=$invoicedata['designname_qty']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														7
													</td>
													<td>
															Size
													</td>
													<td>
														<?=$invoicedata['size']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
														8
													</td>
													<td>
															Batches/Shades
													</td>
													<td>
														<?=$invoicedata['batches_shades']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													9
													</td>
													<td>
															Packing Details:
													</td>
													<td>
														<?=$invoicedata['packing_details']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															a) Pcs.Per Box
													</td>
													<td>
														<?=$invoicedata['pcs_per_box']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															b) Corner Guard
													</td>
													<td>
														<?=$invoicedata['binder']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															c) Binder/Strap Qty Per Box
													</td>
													<td>
														<?=$invoicedata['pcs_per_box']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															d) Carton Quality(3 Ply/ 5 Ply/ 7 Lamination/Plain)
													</td>
													<td>
														<?=$invoicedata['carton_quality']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															e) Carton Box Design/Colour/Name/Details
													</td>
													<td>
														<?=$invoicedata['carton_boxdesign']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															f) Label Content
													</td>
													<td>
														<?=$invoicedata['label_content']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															g) Barcode Sticker Details
													</td>
													<td>
														<?=$invoicedata['barcode_sticker_details']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															h) Separation Of Tiles
													</td>
													<td>
														<?=$invoicedata['separation_between_tiles']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													
													</td>
													<td>
															i) Any Other Specific Details
													</td>
													<td style="background-color:yellow;">
														<?=$invoicedata['any_other_details']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													10
													</td>
													<td>
															Back Appearance(Logo/Without Logo/,Any Other Info)
													</td>
													<td style="background-color:yellow;">
														<?=$invoicedata['back_appearance']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													11
													</td>
													<td>
															Which Standard To Follow(Your Inputs Or Inhouse STD)
													</td>
													<td>
														<?=$invoicedata['standard_to_follow']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													12
													</td>
													<td>
															Reference Sample Details
													</td>
													<td>
														<?=$invoicedata['refrence_sample_design']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													13
													</td>
													<td>
															L/A/B Value Details
													</td>
													<td>
														<?=$invoicedata['l_a_b_value_details']?>
													</td>
												</tr>
												<tr>
													<td  style="font-weight:bold">
													14
													</td>
													<td>
															Any Other Instructions
													</td>
													<td style="background-color:yellow;">
														<?=$invoicedata['any_other_instructions']?>
													</td>
												</tr>
												
												<tr>
													<td style="text-align:center;font-weight:bold" colspan="2">

													DATE: <?=date('d/m/Y',strtotime($invoicedata['qc_date']));?>
		
													</td>
													<td style="text-align:center;font-weight:bold" >

													QC Sign: <?=$invoicedata['qc_sign']?>
		
													</td>
												</tr>

												
												
												
												
												</table>
																				
										
										
										<?php
										$output = ob_get_contents(); 
										// $_SESSION['fumigation_no'] = $invoicedata->export_invoice_no;
										$_SESSION['qc_content'] = $output;
										
										
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
			window.open(root+"Qcpdf/view_pdf", '_blank');
		}
		else
		{
			window.location= root+"Qcpdf/view_pdf";
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
	