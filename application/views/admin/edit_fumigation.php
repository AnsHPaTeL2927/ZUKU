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
									<h3>Fumigation Detail</h3>
							</div>
						</div>
					</div>
			 		<div class="row">
						<div class="col-sm-12">
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> Fumigation  	
										
								</div>
                              	<div class="panel-body">
								<div class="pull-left form-group">
										 
									 	</div>
								<div class="form-body">
                                    
									<!-- <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="createloading_form" id="createloading_form"> -->
                                    <!-- <form role="form" class="form-horizontal" action="<?= base_url('create_fumigation/update') ?>" method="post" enctype="multipart/form-data" name="createloading_form" id="createloading_form"> -->
                                    <form action="<?php echo base_url('create_fumigation/update'); ?>" method="post">
									<tr>
                                                    <td colspan="6">DPPQS Registration No :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="dppqs_number" id="dppqs_number" class="form-control" placeholder="DPPQS Registration No" value="<?= set_value('dppqs_number', $fumigation_data['dppqs_number']) ?>"/>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">Treatment Certificate Number :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="treatment_certificate_number" id="treatment_certificate_number" class="form-control" placeholder="Treatment Certificate Number" value="<?= set_value('treatment_certificate_number', $fumigation_data['treatment_certificate_number']) ?>"/>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">Date Of Issue : </td>
                                                    <td colspan="6">
                                                        <input type="text" name="date_of_issue" id="date_of_issue" class="form-control defualt-date-picker" placeholder="Date Of Issue" value="<?= set_value('date_of_issue', $fumigation_data['date_of_issue']) ?>" />
                                                    </td>
                                                </tr>
                                    
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td style="padding:0px" width="4%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                    <td style="padding:0px" width="8%"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center" colspan="12"><strong>Details Of Goods</strong></td>
                                                </tr>
                                                <input type="hidden" name="export_invoice" id="export_invoice" class="form-control" placeholder="Exporter ID" value="<?= $export_invoice_id ?>"/>
                                                <tr>
                                                    <td colspan="6">Name & Address of Consigner / Exporter</td>
                                                    <td colspan="6">
                                                        <input type="text" name="consigner_exporter" id="consigner_exporter" class="form-control" placeholder="Consigner / Exporter" value="<?= set_value('consigner_exporter', $fumigation_data['consigner_exporter']) ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Declared Name & Address of Consignee / Importer</td>
                                                    <td colspan="6">
                                                        <input type="text" name="consignee_importer" id="consignee_importer" class="form-control" placeholder="Consignee / Importer" value="<?=set_value('consignee_importer', $fumigation_data['consignee_importer']) ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Description of Goods</td>
                                                    <td colspan="6">
                                                        <input  type="text" name="description_of_goods" id="description_of_goods" class="form-control" placeholder="Description of Goods"value="<?=set_value('description_of_goods', $fumigation_data['description_of_goods']) ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Quantity Declared</td>
                                                    <td colspan="6">
                                                        <input type="text" name="quantity_declared" id="quantity_declared" class="form-control" placeholder="Quantity Declared" value="<?=set_value('quantity_declared', $fumigation_data['quantity_declared']) ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Distinguishing Marks</td>
                                                    <td colspan="6">
                                                        <input type="text" name="distinguishing_marks" id="distinguishing_marks" class="form-control" placeholder="Distinguishing Marks" value="<?=set_value('distinguishing_marks', $fumigation_data['distinguishing_marks']) ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Consignment Link / Container No.</td>
                                                    <td colspan="6">
                                                        <input type="text" name="consignment_link_container_no" id="consignment_link_container_no" class="form-control" placeholder="Consignment Link / Container No." value="<?=set_value('consignment_link_container_no', $fumigation_data['consignment_link_container_no']) ?>"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">RFID – E – SEAL</td>
                                                    <td colspan="6">
                                                        <input type="text" name="rfid_e_seal" id="rfid_e_seal" class="form-control" placeholder="RFID – E – SEAL" value="<?=set_value('rfid_e_seal', $fumigation_data['rfid_e_seal']) ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Port & Country of Loading</td>
                                                    <td colspan="6">
                                                        <input type="text" name="port_country_of_loading" id="port_country_of_loading" class="form-control" placeholder="Port & Country of Loading" value="<?=set_value('port_country_of_loading', $fumigation_data['port_country_of_loading']) ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Declared Point of Entry</td>
                                                    <td colspan="6">
                                                        <input type="text" name="declared_point_of_entry" id="declared_point_of_entry" class="form-control" placeholder="Declared Point of Entry"  value="<?=set_value('declared_point_of_entry', $fumigation_data['declared_point_of_entry']) ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Country of Destination</td>
                                                    <td colspan="6">
                                                        <input type="text" name="country_of_destination" id="country_of_destination" class="form-control" placeholder="Country of Destination" value="<?=set_value('country_of_destination', $fumigation_data['country_of_destination']) ?>"/>
                                                    </td>
                                                </tr>
                                                </table>

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
                                                            <td style="text-align:center">
                                                                <input type="text" name="fumigant_name" id="fumigant_name" class="form-control" placeholder="Fumigant Name" value="<?=set_value('fumigant_name', $fumigation_data['fumigant_name']) ?>" />
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="date" name="date_of_treatment" id="date_of_treatment" class="form-control" placeholder="Date Of Fumigation" value="<?=set_value('date_of_treatment', $fumigation_data['date_of_treatment']) ?>" />
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="text" name="place_of_fumigation" id="place_of_fumigation" class="form-control" placeholder="Place Of Fumigation" value="<?=set_value('place_of_fumigation', $fumigation_data['place_of_fumigation']) ?>"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight:bold;text-align:center">Dosage Rate Of Fumigant</th>
                                                            <th style="font-weight:bold;text-align:center">Duration Of Fumigation</th>
                                                            <th style="font-weight:bold;text-align:center">Minimum Air Temperature</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center">
                                                                <input type="text" name="dosage_rate_of_fumigant" id="dosage_rate_of_fumigant" class="form-control" placeholder="Dosage Rate" value="<?=set_value('dosage_rate_of_fumigant', $fumigation_data['dosage_rate_of_fumigant']) ?>"/>
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="text" name="duration_of_fumigation" id="duration_of_fumigation" class="form-control" placeholder="Duration Of Fumigation" value="<?=set_value('duration_of_fumigation', $fumigation_data['duration_of_fumigation']) ?>"/>
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="text" name="minimum_air_temperature" id="minimum_air_temperature" class="form-control" placeholder="Minimum Air Temperature" value="<?=set_value('minimum_air_temperature', $fumigation_data['minimum_air_temperature']) ?>"/>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table border="1" style="width: 100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:left">Fumigation has been performed in under gas tight sheet</td>
                                                            <td>
                                                                <input type="text" name="fumigation_under_gas_tight_sheet" id="fumigation_under_gas_tight_sheet" class="form-control" placeholder="Yes/No" value="<?=set_value('fumigation_under_gas_tight_sheet', $fumigation_data['fumigation_under_gas_tight_sheet']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Container Pressure Test Conducted</td>
                                                            <td>
                                                                <input type="text" name="container_pressure_test_conducted" id="container_pressure_test_conducted" class="form-control" placeholder="Yes/No" value="<?=set_value('container_pressure_test_conducted', $fumigation_data['container_pressure_test_conducted']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Container has 200mm free air space at top of container</td>
                                                            <td>
                                                                <input type="text" name="container_free_air_space" id="container_free_air_space" class="form-control" placeholder="Yes/No" value="<?=set_value('container_free_air_space', $fumigation_data['container_free_air_space']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">In Transit Fumigation – Needs Ventilation at Port of Discharge</td>
                                                            <td>
                                                                <input type="text" name="in_transit_fumigation_ventilation" id="in_transit_fumigation_ventilation" class="form-control" placeholder="Yes/No" value="<?=set_value('in_transit_fumigation_ventilation', $fumigation_data['in_transit_fumigation_ventilation']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Container/Enclosure has been ventilated to below 5ppm v/v Methyl Bromide</td>
                                                            <td>
                                                                <input type="text" name="container_ventilation_below_5ppm" id="container_ventilation_below_5ppm" class="form-control" placeholder="Yes/No" value="<?=set_value('container_ventilation_below_5ppm', $fumigation_data['container_ventilation_below_5ppm']) ?>">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table border="1" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="font-weight:bold;text-align:center">WRAPPING AND TIMBER</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:left">Has the commodity been fumigated prior to lacquering, varnishing, painting, or wrapping?</td>
                                                            <td>
                                                                <input type="text" name="fumigation_prior_to_finishing" id="fumigation_prior_to_finishing" class="form-control" placeholder="Yes/No" value="<?=set_value('fumigation_prior_to_finishing', $fumigation_data['fumigation_prior_to_finishing']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Has plastic wrapping been used in the consignment?</td>
                                                            <td>
                                                                <input type="text" name="plastic_wrapping_used" id="plastic_wrapping_used" class="form-control" placeholder="Yes/No" value="<?=set_value('plastic_wrapping_used', $fumigation_data['plastic_wrapping_used']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">If Yes, has the consignment been fumigated prior to wrapping?</td>
                                                            <td>
                                                                <input type="text" name="fumigated_prior_to_wrapping" id="fumigated_prior_to_wrapping" class="form-control" placeholder="Yes/No" value="<?=set_value('fumigated_prior_to_wrapping', $fumigation_data['fumigated_prior_to_wrapping']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Or has the plastic wrapping been slashed, opened or perforated in the timber in accordance with the Wrapping and Perforation standard?</td>
                                                            <td>
                                                                <input type="text" name="plastic_wrapping_slashed" id="plastic_wrapping_slashed" class="form-control" placeholder="Yes/No" value="<?=set_value('plastic_wrapping_slashed', $fumigation_data['plastic_wrapping_slashed']) ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Is the timber in this consignment less than 200mm thick in one dimension and correctly spaced every 200mm in height?</td>
                                                            <td>
                                                                <input type="text" name="timber_thickness_and_spacing" id="timber_thickness_and_spacing" class="form-control" placeholder="Yes/No" value="<?=set_value('timber_thickness_and_spacing', $fumigation_data['timber_thickness_and_spacing']) ?>">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
												<tr>
                                                    <td colspan="6">Name Of Accredited Fumigation Operator :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="nameof_accreditedfumigation" id="nameof_accreditedfumigation" class="form-control" placeholder="Name Of Accredited Fumigation Operator" value="<?=set_value('nameof_accreditedfumigation', $fumigation_data['nameof_accreditedfumigation']) ?> "/>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">DPPQS Accreditation card no :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="dppqs_accreditation_cardno" id="dppqs_accreditation_cardno" class="form-control" placeholder="DPPQS Accreditation card no" value="<?=set_value('dppqs_accreditation_cardno', $fumigation_data['dppqs_accreditation_cardno']) ?>" />
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">DPPQS Date : </td>
                                                    <td colspan="6">
                                                        <input type="text" name="dppqs_date" id="dppqs_date" class="form-control defualt-date-picker" placeholder="DPPQS Date" value="<?=set_value('dppqs_date', $fumigation_data['dppqs_date']) ?>"/>
                                                    </td>
                                                </tr>
                                        </table>

                                                <!-- <?php
										 	$total_con = $invoicedata->container_details;
											 $no =1;
											$con_array=array();
												for($i=0; $i<count($product_data);$i++)
												{
													if(!in_array($product_data[$i]->con_entry,$con_array))
													{	
													$container_no = $no;
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
																	<input type='text' name='gross_mass1[]' id='gross_mass1<?=$container_no?>' value="<?=$product_data[$i]->updated_gross_weight?>" class="form-control" onkeyup="cal_sum(<?=$container_no?>)" />
																</td>
																<td style="text-align:center" class="tdcls">
																	<input type='text' name='gross_mass3[]' id='gross_mass3<?=$container_no?>' value="<?=$product_data[$i]->tare_weight + $product_data[$i]->updated_gross_weight?>" readonly class="form-control"/>
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
											 
									 	?> -->
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
                                        <a href="<?= base_url('exportinvoice_listing') ?>" class="btn btn-danger">
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
//  $("#createloading_form").submit(function(event) {
//     event.preventDefault();
    
//     block_page();
//     var postData = new FormData(this);
//     $.ajax({
//         type: "post",
//         url: root + 'create_fumigation/manage',
//         data: postData,
//         processData: false,
//         contentType: false,
//         cache: false,
//         success: function(responseData) {
//             //console.log(responseData);
//             try {
//                 var obj = JSON.parse(responseData);
//                 $(".loader").hide();
//                 if (obj.res == 1) {
//                     $("#product_form").trigger('reset');
//                     unblock_page("success", "Fumigation Successfully Added.");
//                     setTimeout(function() { window.location = root + 'viewfumigation/index/' + obj.id }, 1000);
//                 } else {
//                     unblock_page("error", "Something Wrong.")
//                 }
//             } catch (e) {
//                 console.log("Error parsing response: ", e);
//                 unblock_page("error", "Invalid response from server.");
//             }
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//             console.log("AJAX error: ", textStatus, errorThrown);
//             unblock_page("error", "Internal Server Error. Please try again later.");
//         }
//     });
// });

</script>
 
 