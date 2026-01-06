<?php 
$this->view('lib/header'); 
$no_of_container 	= $invoicedata->no_of_container;
$container_size 	= $invoicedata->container_size;
$exportinvoice_no 	= $invoicedata->exportinvoice_no;
 $export_date = date('d/m/Y',strtotime($invoicedata->export_date));
 $export_ref_no =  ($invoicedata->export_ref_no);
  $_SESSION['vgm_content'] = '';
 $_SESSION['vgm_no'] = '';
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
									<a href="javascript:void(0)">
										Dashboard
									</a>
								</li>
								<li class="active">
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
									<h3>View Loading Detail</h3>
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
										View VGM
								</div>
                                
								<div class="panel-body">
								<div class="form-body">
									<?php ob_start();?> 	
										<table width="100%" style="margin-top:10px" cellspacing="0" cellpadding="0" class="main_table">
											<tr>
												<td style="padding:0px" width="10%"> </td>
												<td style="padding:0px" width="10%"></td>
												<td style="padding:0px" width="10%"></td>
												<td style="padding:0px" width="10%"></td>
												<td style="padding:0px" width="10%"></td>
												<td style="padding:0px" width="10%"></td>
												<td style="padding:0px" width="10%"></td>
											 	<td style="padding:0px" width="10%"></td>
												 
										 	</tr>
											<tr>
												<td style="padding:0;border-top:none;border-bottom:none" colspan="8">
														<img src="<?=base_url().'upload/'.$company_detail[0]->head_logo?>" width="200px" height="100px"  />
												</td>
										 	</tr> 
											<tr>
												<td style="text-align:center;font-size:18px" colspan="8">
													<strong>
														<u>
															INFORMATION ABOUT VERIFIED GROSS MASS OF CONTAINER
														</u>
													</strong>
												</td>
											 </tr>
											<!-- <tr>
												<td style="text-align:left;font-weight:bold" colspan="3">
													Booking No
												</td>
												<td colspan="8" style="text-align:center;" >
													 <?=$invoicedata->booking_no?>
												</td>
											 </tr>-->
											 <tr>
												<td  style="font-weight:bold"  colspan="3">
													Shipper Name
												</td>
												<td colspan="5">
													 <?=$invoicedata->shipper_name?>
													 
												</td>
											 </tr>
											 <tr>
												<td  style="font-weight:bold"   colspan="3">
													Shipper Address 
												</td>
												<td    colspan="5">
													<?=$invoicedata->shipper_address?>
												</td>
											 </tr>
											 <tr>
												<td  style="font-weight:bold"   colspan="3">
													IEC No
												</td>
												<td   colspan="5">
													<?=$invoicedata->iec_no?>
												</td>
										 	 </tr>
											 <tr>
												<td  style="font-weight:bold"   colspan="3">
													GST No
												</td>
												<td   colspan="5">
													<?=$invoicedata->gst_no?>
												</td>
										 	 </tr>
											 <tr>
												<td  style="font-weight:bold"   colspan="3">
													PAN No
												</td>
												<td   colspan="5">
													<?=$invoicedata->pan_no?>
												</td>
										 	 </tr>
											  <tr>
												<td  style="font-weight:bold"   colspan="3">
													Name & Designation of the Official of the Shipper authorized to Sign document

												</td>
												<td    colspan="5">
													<?=$invoicedata->name_officer?>
												</td>
											 </tr>
											  <tr>
												<td  style="font-weight:bold"   colspan="3">
													24 x 7 Contact details of Authorized official of Shipper

												</td>
												<td colspan="5">
													<?=$invoicedata->contact_no?>
												</td>
											 </tr>
											  <tr>
												<td  style="font-weight:bold"   colspan="3">
													Container No

												</td>
												<td colspan="5">
													As per attached sheet
												</td>
											 </tr>
											  <tr>
												<td  style="font-weight:bold"   colspan="3">
													Container Size (TEU/FUE/Others)
												</td>
												<td colspan="5">
													TEU
												</td>
											 </tr>
											 <tr>
												<td  style="font-weight:bold"   colspan="3">
													Maximum permissible weight of container as per the CSC Plate
												</td>
												<td colspan="5">
													As per attached sheet
												</td>
											 </tr>
											 <tr>
												<td  style="font-weight:bold"   colspan="3">
													Method used for VGM
												</td>
												<td    colspan="5">
													<?=$invoicedata->method_vgm?>
												</td>
											 </tr>
											 
											  <tr>
												<td style="text-align:left;font-weight:bold" colspan="3">
													Weighment Slip no.
												</td>
												<td colspan="5">
													<?=$invoicedata->weighment_slipno?>
												</td>
											 </tr>
											  <tr>
												<td style="text-align:left;font-weight:bold"colspan="3">
													Weighbridge Registration no. & Address
												</td>
												<td colspan="5">
													<?=$invoicedata->weighbridge_reg_no?>
												</td>
											 </tr>
											 <tr>
												<td style="text-align:left;font-weight:bold" colspan="3">
													Date and Time of weighment
												</td>
												<td colspan="5">
													<?=$invoicedata->datetime_weighment?>
												</td>
											 </tr> 
											 <tr>
												<td style="text-align:left;font-weight:bold" colspan="3">
													Verified Gross Mass of the Container 
												</td>
												<td colspan="5">
													As per attached sheet
												</td>
											 </tr> 
											  <tr>
												<td style="text-align:left;font-weight:bold" colspan="3">
													Unit of Measure (KG / MT / LBS)
												</td>
												<td colspan="5">
													Kgs
												</td>
											 </tr> 
											  <tr>
												<td style="text-align:left;font-weight:bold" colspan="3">
													Type (Normal / Reefer / Hazardous / Others)

												</td>
												<td colspan="5">
													NORMAL
												</td>
											 </tr> 
											 <tr>
												<td style="text-align:center;height:30px" colspan="8"  >
													 
												</td>
											  </tr>
											<tr>
												<td rowspan="2" style="font-weight:bold;text-align:center">Sr No </td>
											 	<td rowspan="2" style="font-weight:bold;text-align:center">Booking No</td>
											 	<td rowspan="2" style="font-weight:bold;text-align:center">Container Nos</td>
												<td style="font-weight:bold;text-align:center" colspan="4">VGM (KGS) (cargo+Packing+Tare Weight) </td>
												<td rowspan="2" style="font-weight:bold;text-align:center">Weighment Slip No. (RST No.)</td>
										 	</tr>
											<tr>
												<td style="font-weight:bold;text-align:center">Tare weight </td>
											 	<td style="font-weight:bold;text-align:center">Cargo weight</td>
											 	<td style="font-weight:bold;text-align:center">Total weight (Kgs)</td>
												<td style="font-weight:bold;text-align:center" >Maximum Weight (KGS) </td>
												 
										 	</tr>
											<?php 
											$no=1;
											for($s=0; $s<(count($vgmdata));$s++)
											{
											?>
											<tr id="trhtml ">
													<td class="innertd" style="text-align:center"  rowspan="<?=$rowspan?>">
														<?=$no?>
													</td>
													<td class="innertd" style="text-align:center"  rowspan="<?=$rowspan?>">
														<?=$vgmdata[$s]->booking_no?> 
													 </td>
													<td class="innertd" style="text-align:center"  rowspan="<?=$rowspan?>">
														<?=$vgmdata[$s]->container_no?> 
													 </td>
													 <td style="text-align:center" >
														<?=$vgmdata[$s]->gross_mass2?>
													</td>
													<td class="innertd" style="text-align:center" >
														<?=$vgmdata[$s]->gross_mass1?>
													</td>
													<td style="text-align:center" class="tdcls">
														<?=$vgmdata[$s]->gross_mass3?>
													</td>
													 <td class="innertd" style="text-align:center" >
														<?=$vgmdata[$s]->max_permissible?>
													</td>
													<td class="innertd" style="text-align:center"  rowspan="<?=$rowspan?>">
														<?=$vgmdata[$s]->shilp_no?>
												 	</td>
											 	  </tr>
												  
										
										
												  <?php 
												  $no++;
											}
											?>
											  <tr>
												<td style="text-align:left;font-weight:bold" colspan="5">
												 
												</td>
												<td colspan="3" style="text-align:right;font-weight:bold" >
													  
												FOR, <?=$company_detail[0]->s_name?>
												<br>
												
											
														<img 
															src="<?= base_url('upload/' . $company_detail[0]->s_c_sign) ?>" 
															 height="70px"
															alt="Company Signature" 
															onerror="this.onerror=null;this.src='<?= base_url('upload/default_signature.png') ?>';"
														>
												
													
													 <br>
													<?=nl2br($company_detail[0]->authorised_signatury)?>
												</td>
											 </tr>
										</table>											
								 	
									
									<?php
									 $output = ob_get_contents(); 
									$_SESSION['vgm_no'] = $invoicedata->export_invoice_no;
									 $_SESSION['vgm_content'] = $output;
									  
									
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
		window.open(root+"vgmpdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"vgmpdf/view_pdf";
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
 