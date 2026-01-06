<?php 
 
  $this->view('lib/header'); 
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
									<h3>VGM Detail</h3>
							</div>
						</div>
					</div>
				 
					<div class="row">
						<div class="col-sm-12">
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> VGM Detail	
								</div>
                                
								<div class="panel-body">
								<div class="form-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="createloading_form" id="createloading_form">
										 	 
											<table width="100%"  cellspacing="0" cellpadding="0">
											<tr>
												<td style="padding:0px" width="4%"> </td>
												<td style="padding:0px" width="8%"> </td>
												<td style="padding:0px" width="8%"></td>
												<td style="padding:0px" width="8%"></td>
												<td style="padding:0px" width="8%"></td>
												<td style="padding:0px" width="8%"></td>
												<td style="padding:0px" width="8%"></td>
												<td style="padding:0px" width="8%"></td>
												<td style="padding:0px" width="8%"></td>
												 
										 	</tr>
											<tr>
												<td style="text-align:center" colspan="10">
													<strong>DECLARATION OF VERIFIED GROSS MASS OF CONTAINER</strong>
												</td>
											 </tr>
											<!-- <tr>
												<td style="text-align:left" colspan="3">
													Booking No
												</td>
												<td colspan="7">
													<input type='text' name='booking_no' id='booking_no' class="form-control" placeholder="Booking No" required title="Enter Booking No" />
												</td>
											 </tr>-->
											 <tr>
												<td  colspan="4">
													Shipper Name
												</td>
												<td   colspan="6">
													<input type='text' name='shipper_name' id='shipper_name' class="form-control" placeholder="Shipper Name" value="<?=$invoicedata->shipper_name?>" />
												</td>
											 </tr>
											 <tr>
												<td  colspan="4">
													Shipper Address 
												</td>
												<td colspan="6">
													<textarea name='shipper_address' id='shipper_address' class="form-control" placeholder="Shipper Address"><?=$invoicedata->shipper_address?></textarea>
												</td>
											 </tr>
											  <tr>
												<td colspan="4">
													IEC No.  
												</td>
												<td  colspan="6">
													<input type='text' name='iec_no' id='iec_no' class="form-control" placeholder="IEC No." value="<?=$invoicedata->iec_no?>"  />
												</td>
											 </tr>
											 <tr>
												<td colspan="4">
													 GST No. 
												</td>
												<td  colspan="6">
													<input type='text' name='gst_no' id='gst_no' class="form-control" placeholder="CIN No." value="<?=$invoicedata->gst_no?>"  />
												</td>
											 </tr>
											 <tr>
												<td colspan="4">
													 PAN No
												</td>
												<td  colspan="6">
													<input type='text' name='pan_no' id='pan_no' class="form-control" placeholder="Pan no" value="<?=$invoicedata->s_pan?>"  />
												</td>
											 </tr>
											  <tr>
												<td     colspan="4">
													Name & Designation of the Official of the Shipper authorized to Sign document

												</td>
												<td style="text-align:center;"  colspan="6">
													<input type='text' name='name_officer' id='name_officer' class="form-control" placeholder="Name & Designation" value="<?=$invoicedata->name_officer?>"  />
												</td>
											 </tr>
											 <tr>
												<td     colspan="4">
													24 x 7 Contact details of Authorized official of Shipper
 
												</td>
												<td style="text-align:center;"  colspan="6">
													<input type='text' name='contact_no' id='contact_no' class="form-control" placeholder="Contact No" value="<?=$invoicedata->contact_no?>"  />
												</td>
											 </tr>
												
											 <tr>
												<td  colspan="4">
													Method used for VGM
												</td>
												<td   colspan="6">
													<input type='text' name='method_vgm' id='method_vgm' class="form-control" placeholder="Method used for VGM" value="<?=$invoicedata->method_vgm?>" />
												</td>
											 </tr>
											   <tr>
												<td style="text-align:left" colspan="4">
													Weighment Slip no.
												</td>
												<td colspan="6">
													<input type='text' name='weighbridge_slip_no' id='weighbridge_slip_no' class="form-control" placeholder="Weighment Slip no." value="<?=$invoicedata->weighment_slipno?>"  />
												</td>
											 </tr>
											  <tr>
												<td style="text-align:left" colspan="4">
													Weighbridge Registration no. & Address
												</td>
												<td colspan="6">
													<input type='text' name='weighbridge_reg_no' id='weighbridge_reg_no' class="form-control" placeholder="Weighbridge Registration no. & Address"  value="<?=$invoicedata->weighbridge_reg_no?>" />
												</td>
											 </tr>
											 <tr>
												<td style="text-align:left" colspan="4">
													Date and Time of weighment
												</td>
												<td colspan="6">
													<input type='text' name='datetime_weighment' id='datetime_weighment' class="form-control" placeholder="Date and Time of weighment"  value="<?=$invoicedata->datetime_weighment?>"/>
												</td>
											 </tr> 
											  <tr>
												<td style="text-align:left" colspan="4">
													Container No
												</td>
												<td colspan="6">
													<input type='text' name='container_no' id='container_no' class="form-control" placeholder="Container No"  value="<?=$invoicedata->container_no?>"/>
												</td>
											 </tr> 
											 <tr>
												<td style="text-align:left" colspan="4">
													Container Size (TEU/FUE/Others)
												</td>
												<td colspan="6">
													<input type='text' name='container_size' id='container_size' class="form-control" placeholder="Container Size (TEU/FUE/Others)"  value="<?=$invoicedata->container_size?>"/>
												</td>
											 </tr> 
											 <tr>
												<td style="text-align:left" colspan="4">
													Maximum permissible weight of container as per the CSC Plate
												</td>
												<td colspan="6">
													<input type='text' name='permissible_weight' id='permissible_weight' class="form-control" placeholder="Maximum permissible weight of container as per the CSC Plate"  value="<?=$invoicedata->permissible_weight?>"/>
												</td>
											 </tr> 
											  <tr>
												<td style="text-align:left" colspan="4">
													Verified Gross Mass of the Container
												</td>
												<td colspan="6">
													<input type='text' name='verified_container' id='verified_container' class="form-control" placeholder="Verified Gross Mass of the Container"  value="<?=$invoicedata->verified_container?>"/>
												</td>
											 </tr>
											<tr>
												<td style="text-align:left" colspan="4">
													Unit of Measure (KG / MT / LBS)
												</td>
												<td colspan="6">
													<input type='text' name='unit_measure' id='unit_measure' class="form-control" placeholder="Unit of Measure (KG / MT / LBS)"  value="<?=$invoicedata->unit_measure?>"/>
												</td>
											 </tr>
											 <tr>
												<td style="text-align:left" colspan="4">
													Type (Normal / Reefer / Hazardous / Others)
												</td>
												<td colspan="6">
													<input type='text' name='type' id='type' class="form-control" placeholder="Type (Normal / Reefer / Hazardous / Others)"  value="<?=$invoicedata->type?>"/>
												</td>
											 </tr>
											<tr>
												<td style="text-align:left" colspan="4">
													If Hazardous, UN No. IMDG Class
												</td>
												<td colspan="6">
													<input type='text' name='imdg_class' id='imdg_class' class="form-control" placeholder="If Hazardous, UN No. IMDG Class"  value="<?=$invoicedata->imdg_class?>"/>
												</td>
											 </tr>
											 <tr>
												<td style="height:30px" colspan="10"  >
													Remarks :
														<textarea class="form-control" name="vgm_remakrs" id="vgm_remakrs"><?=strip_tags($invoicedata->vgm_remakrs)?></textarea>
												</td>
											  </tr>
											  
											<tr>
												<td style="font-weight:bold;text-align:center">Sr No </td>
												<td style="font-weight:bold;text-align:center">Booking No </td>
											 	<td style="font-weight:bold;text-align:center">Container No</td>
												<td style="font-weight:bold;text-align:center">Truck No</td>
												<td style="font-weight:bold;text-align:center">Tare weight</td>
												<td style="font-weight:bold;text-align:center">Cargo Weight</td>
												<td style="font-weight:bold;text-align:center">Total weight (Kgs)</td>
												<td style="font-weight:bold;text-align:center" >  Maximum Weight (KGS) </td>
												<td style="font-weight:bold;text-align:center" colspan="2"> Date & Time of Weighment </td>
											 
												<td style="font-weight:bold;text-align:center" >  Weighment Slip No. (RST No.) </td>
										 	</tr>
											 
											<?php
										 	$total_con = $invoicedata->container_details;
											 $no =1;
											$con_array=array();
												for($i=0; $i<count($vgmdata);$i++)
												{
												 $container_no = $vgmdata[$i]->container_no;
											 ?>
															<tr>
																<td style="text-align:center">
																	<?=$no?>
																</td>
																 <td style="text-align:center">
																	<input type='text' name='booking_no[]' id='booking_no<?=$container_no?>' value="<?=$vgmdata[$i]->booking_no?>" class="form-control" />
																</td>
																<td style="text-align:center" >
																<?=$vgmdata[$i]->container_no?>
														 
																	<input type='hidden' name='container_detail[]' id='container_detail<?=$container_no?>'  value="<?=$vgmdata[$i]->container_no?>"   />
														
																</td>
																
																<td style="text-align:center" >
																<?=$vgmdata[$i]->truck_no?>
														 
																	<input type='hidden' name='truck_no[]' id='truck_no<?=$container_no?>'  value="<?=$vgmdata[$i]->truck_no?>"   />
														
																</td>
																<td style="text-align:center" >
																	<input type='text' name='gross_mass2[]' id='gross_mass2<?=$container_no?>' value="<?=$vgmdata[$i]->gross_mass2?>" class="form-control" onkeyup="cal_sum('<?=$container_no?>')"/>
																	
																</td>
																<td class="innertd" style="text-align:center" >
																	<input type='text' name='gross_mass1[]' id='gross_mass1<?=$container_no?>' value="<?=$vgmdata[$i]->gross_mass1?>" class="form-control" onkeyup="cal_sum('<?=$container_no?>')" />
																</td>
																<td style="text-align:center" class="tdcls">
																	<input type='text' name='gross_mass3[]' id='gross_mass3<?=$container_no?>' value="<?=$vgmdata[$i]->gross_mass3?>" readonly class="form-control"/>
																</td>
																<td class="innertd" style="text-align:center" >
																	<input type='text' name='max_permissible[]' id='max_permissible<?=$container_no?>' value="<?=$vgmdata[$i]->max_permissible?>" class="form-control"/>
																</td>
																
																<td style="text-align:center"  >
																	<input type='text' name='date_weighment[]' id='date_weighment<?=$container_no?>' value="<?=$vgmdata[$i]->date_weighment?>" class="form-control" />
																</td>
																<td class="innertd" style="text-align:center"  >
																	<input type='text' name='time_weighment[]' id='time_weighment<?=$container_no?>' value="<?=$vgmdata[$i]->time_weighment?>" class="form-control"/>
																</td>
															 	<td class="innertd" style="text-align:center" >
																	<input type='text' name='shilp_no[]' id='shilp_no<?=$container_no?>' value="<?=$vgmdata[$i]->shilp_no?>" class="form-control"   />
																</td>
																</tr>
															<?php 
															$row_no='rowspan';
															$no++;
															$container_no++;
													 										
												}
											 
									 	?>
											 <tr>
												<td style="text-align:center;height:30px" colspan="10"  >
													 
												</td>
											  </tr>
										
										
									</table>
																	
								 
								<div style="padding: 14px;" >	
							 		<div class="form-group"  >
							 			<button type="submit" name="submit" class="btn btn-success">
							 				Save
							 			</button>
										<a href="<?=base_url().'exportinvoice_listing'?>" class="btn btn-danger">
											Cancel
										</a>
									</div>	
								</div>	
									 		
									<input type="hidden" name="vgm_id" id="vgm_id" value="<?=$invoicedata->vgm_id?>"/>			
									<input type="hidden" name="export_invoice_id" id="export_invoice_id" value="<?=$invoicedata->export_invoice_id?>"/>			
									<input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>			
								 
							
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
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 }); 
function cal_sum(val)
{
	var value1 = $("#gross_mass1"+val).val();
	var value2 = $("#gross_mass2"+val).val();
	var sum = parseFloat(value1) + parseFloat(value2);
	if(sum>0)
	{
		$("#gross_mass3"+val).val(sum);
	}
} 

$("#createloading_form").submit(function(event) {
	event.preventDefault();
	 
	 block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'create_vgm/manage',
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
				    unblock_page("success","VGM Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'viewvgm/index/'+obj.id },1000);
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


 </script>
 
 