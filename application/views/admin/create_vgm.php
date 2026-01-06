<?php 
 
$this->view('lib/header'); 
$date = date('d-m-Y');

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
									<?=($mode=="Edit")?$mode:'Create'?> VGM  	
										
								</div>
                              	<div class="panel-body">
								<div class="pull-left form-group">
										 
									 	</div>
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
												<td style="text-align:center" colspan="12">
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
												<td  colspan="6">
													Shipper Name
												</td>
												<td   colspan="6">
													<input type='text' name='shipper_name' id='shipper_name' class="form-control" placeholder="Shipper Name" value="<?=$company_detail[0]->shipper_name?>" />
												</td>
											 </tr>
											 <tr>
												<td  colspan="6">
													Shipper Address 
												</td>
												<td colspan="6">
													<textarea name='shipper_address' id='shipper_address' class="form-control" placeholder="Shipper Address"><?=$company_detail[0]->shipper_address?></textarea>
												</td>
											 </tr>
											  <tr>
												<td colspan="6">
													IEC No.  
												</td>
												<td  colspan="6">
													<input type='text' name='iec_no' id='iec_no' class="form-control" placeholder="IEC No." value="<?=$company_detail[0]->s_iec?>"  />
												</td>
											 </tr>
											 <tr>
												<td colspan="6">
													 GST No. 
												</td>
												<td  colspan="6">
													<input type='text' name='gst_no' id='gst_no' class="form-control" placeholder="CIN No." value="<?=$company_detail[0]->s_gst?>"  />
												</td>
											 </tr>
											 <tr>
												<td colspan="6">
													 PAN No
												</td>
												<td  colspan="6">
													<input type='text' name='pan_no' id='pan_no' class="form-control" placeholder="Pan no" value="<?=$company_detail[0]->s_pan?>"  />
												</td>
											 </tr>
											  <tr>
												<td     colspan="6">
													Name & Designation of the Official of the Shipper authorized to Sign document

												</td>
												<td style="text-align:center;"  colspan="6">
													<input type='text' name='name_officer' id='name_officer' class="form-control" placeholder="Name & Designation" value="<?=$company_detail[0]->name_officer?>"  />
												</td>
											 </tr>
											 <tr>
												<td     colspan="6">
													24 x 7 Contact details of Authorized official of Shipper
 
												</td>
												<td style="text-align:center;"  colspan="6">
													<input type='text' name='contact_no' id='contact_no' class="form-control" placeholder="Contact No" value="<?=$invoicedata->e_mobile?>, <?=$invoicedata->e_email?>"  />
												</td>
											 </tr>
												
											 <tr>
												<td  colspan="6">
													Method used for VGM
												</td>
												<td   colspan="6">
													<input type='text' name='method_vgm' id='method_vgm' class="form-control" placeholder="Method used for VGM" value="<?=$company_detail[0]->method_vgm?>" />
												</td>
											 </tr>
											   <tr>
												<td style="text-align:left" colspan="6">
													Weighment Slip no.
												</td>
												<td colspan="6">
													<input type='text' name='weighbridge_slip_no' id='weighbridge_slip_no' class="form-control" placeholder="Weighment Slip no." value="<?=$company_detail[0]->weighbridge_slip_no?>"  />
												</td>
											 </tr>
											  <tr>
												<td style="text-align:left" colspan="6">
													Weighbridge Registration no. & Address
												</td>
												<td colspan="6">
													<input type='text' name='weighbridge_reg_no' id='weighbridge_reg_no' class="form-control" placeholder="Weighbridge Registration no. & Address"  value="<?=$company_detail[0]->weighbridge_reg_no?>" />
												</td>
											 </tr>
											 <tr>
												<td style="text-align:left" colspan="6">
													Date and Time of weighment
												</td>
												<td colspan="6">
													<input type='text' name='datetime_weighment' id='datetime_weighment' class="form-control" placeholder="Date and Time of weighment"  value="<?=date('d-m-Y')?>"/>
												</td>
											 </tr> 
											  <tr>
												<td style="text-align:left" colspan="6">
													Container No
												</td>
												<td colspan="6">
													<input type='text' name='container_no' id='container_no' class="form-control" placeholder="Container No"  value="As per attached sheet"/>
												</td>
											 </tr> 
											 <tr>
												<td style="text-align:left" colspan="6">
													Container Size (TEU/FUE/Others)
												</td>
												<td colspan="6">
													<input type='text' name='container_size' id='container_size' class="form-control" placeholder="Container Size (TEU/FUE/Others)"  value="TEU"/>
												</td>
											 </tr> 
											 <tr>
												<td style="text-align:left" colspan="6">
													Maximum permissible weight of container as per the CSC Plate
												</td>
												<td colspan="6">
													<input type='text' name='permissible_weight' id='permissible_weight' class="form-control" placeholder="Maximum permissible weight of container as per the CSC Plate"  value="30480 KGS"/>
												</td>
											 </tr> 
											  <tr>
												<td style="text-align:left" colspan="6">
													Verified Gross Mass of the Container
												</td>
												<td colspan="6">
													<input type='text' name='verified_container' id='verified_container' class="form-control" placeholder="Verified Gross Mass of the Container"  value="As per attached sheet"/>
												</td>
											 </tr>
											<tr>
												<td style="text-align:left" colspan="6">
													Unit of Measure (KG / MT / LBS)
												</td>
												<td colspan="6">
													<input type='text' name='unit_measure' id='unit_measure' class="form-control" placeholder="Unit of Measure (KG / MT / LBS)"  value="Kgs"/>
												</td>
											 </tr>
											 <tr>
												<td style="text-align:left" colspan="6">
													Type (Normal / Reefer / Hazardous / Others)
												</td>
												<td colspan="6">
													<input type='text' name='type' id='type' class="form-control" placeholder="Type (Normal / Reefer / Hazardous / Others)"  value="NORMAL"/>
												</td>
											 </tr>
											 <tr>
												<td style="text-align:left" colspan="6">
													If Hazardous, UN No. IMDG Class
												</td>
												<td colspan="6">
													<input type='text' name='imdg_class' id='imdg_class' class="form-control" placeholder="If Hazardous, UN No. IMDG Class"  value="N/A"/>
												</td>
											 </tr>
											 <tr>
												<td style="height:30px" colspan="12"  >
													Remarks :
														<textarea class="form-control" name="vgm_remakrs" id="vgm_remakrs"><?=strip_tags($company_detail[0]->vgm_remakrs)?></textarea>
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
												for($i=0; $i<count($product_data);$i++)
												{
													if(!in_array($product_data[$i]->con_entry,$con_array))
													{	
													$container_no = $no;
													  $net_weight = $product_data[$i]->total_ori_net_weight;
													  
														$totalnetweight += $product_data[$i]->total_ori_net_weight;
													  
															if($product_data[$i]->origanal_pallet > 0)
															{
																//echo (($product_data[$i]->origanal_pallet * $product_data[$i]->pallet_weight) + ($netforsum));
																
																//$Grand_Total_pallet  += $product_data[$i]->origanal_pallet;
																$pallet_weight = $product_data[$i]->pallet_weight;
																$total_pallets = floatval($product_data[$i]->total_ori_pallet);
																$gross_weight = ($total_pallets * $pallet_weight) + $net_weight;
																$totalgrossweight += $gross_weight;
															}
															else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
															{
																
																$pallet_weight_big = $product_data[$i]->orginal_no_of_big_pallet * $product_data[$i]->big_plat_weight;
																$pallet_weight_small = $product_data[$i]->orginal_no_of_small_pallet * $product_data[$i]->small_plat_weight;
																$total_pallets = ($pallet_weight_big + $pallet_weight_small);
																$gross_weight = ($total_pallets + $net_weight);
																$totalgrossweight += $gross_weight; 
																
															}
											 ?>
															<tr>
																<td style="text-align:center">
																	<?=$no?>
																</td>
																 <td style="text-align:center">
																	<input type='text' name='booking_no[]' id='booking_no<?=$container_no?>' value="<?=$product_data[$i]->booking_no?>" class="form-control" />
																</td>
																<td style="text-align:center" >
																<?=$product_data[$i]->container_no?>
														 
																	<input type='hidden' name='container_detail[]' id='container_detail<?=$container_no?>'  value="<?=$product_data[$i]->container_no?>"   />
														
																</td>
																
																<td style="text-align:center" >
																<?=$product_data[$i]->truck_no?>
														 
																	<input type='hidden' name='truck_no[]' id='truck_no<?=$container_no?>'  value="<?=$product_data[$i]->truck_no?>"   />
														
																</td>
																
																<td style="text-align:center" >
																	<input type='text' name='gross_mass2[]' id='gross_mass2<?=$container_no?>' value="<?=$product_data[$i]->tare_weight?>" class="form-control" onkeyup="cal_sum(<?=$container_no?>)"/>
																	
																</td>
																<td class="innertd" style="text-align:center" >
																	<input type='text' name='gross_mass1[]' id='gross_mass1<?=$container_no?>' value="<?=$gross_weight?>" class="form-control" onkeyup="cal_sum(<?=$container_no?>)" />
																</td>
																<td style="text-align:center" class="tdcls">
																	<input type='text' name='gross_mass3[]' id='gross_mass3<?=$container_no?>' value="<?=$product_data[$i]->tare_weight + $gross_weight?>" readonly class="form-control"/>
																</td>
																<td class="innertd" style="text-align:center" >
																	<input type='text' name='max_permissible[]' id='max_permissible<?=$container_no?>' value="30480" class="form-control"/>
																</td>
																
																<td style="text-align:center"  >
																	<input type='text' name='date_weighment[]' id='date_weighment<?=$container_no?>' value="<?=date('d-m-Y')?>" class="form-control" />
																</td>
																<td class="innertd" style="text-align:center"  >
																	<input type='text' name='time_weighment[]' id='time_weighment<?=$container_no?>' value="<?=date('H.i.s')?>" class="form-control"/>
																</td>
															 	<td class="innertd" style="text-align:center" >
																	<input type='text' name='shilp_no[]' id='shilp_no<?=$container_no?>' value="" class="form-control"   />
																</td>
																</tr>
															<?php 
															$row_no='rowspan';
															$no++;
															$container_no++;
														array_push($con_array,$product_data[$i]->con_entry);
													}
												   													
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
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
function paste_data()
{
	var excel_data = $("#excel_data").val();
	var excel_spit = excel_data.split("\n");  
	var total_line = parseInt(excel_spit.length)-parseInt(1);
	var value_array = [];
	var name_array = [];
	  
	if(parseInt(total_line) == <?=$total_con?>)
	{
		for(var i=0;i<total_line;i++)
		{
			var custom1 =  excel_spit[i].replace(/\t/g, ' ');
			var spit_from_colom = custom1.split(" ");
			  value_array.push(spit_from_colom)
			 
		}
		
		var inps = document.getElementsByName('booking_no[]');
		var no=0;
		for (var c = 0; c <inps.length; c++) 
		{
			
				if(value_array[no].length == 4)
				{ 
					console.log(value_array[no][0])
					$("#booking_no"+c).val(value_array[no][0])
					$("#gross_mass1"+c).val(value_array[no][1])
					$("#gross_mass2"+c).val(value_array[no][2])
					$("#gross_mass3"+c).val(value_array[no][3])
			 	}
				else
				{
					 toastr["error"]("Wrong Data");
					return false;
				}				
			no++;
		}
		$("#myModal").modal("hide"); 
		$("#excel_data").val(""); 
		
	}
	else
	{
		toastr["error"]("Wrong Data");
	}
} 
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
				    unblock_page("success","VGM Sucessfully Added.");
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
 
 