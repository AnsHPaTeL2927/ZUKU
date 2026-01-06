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
                                   <!-- <p>Export Invoice No: <?php echo htmlspecialchars($export_invoice_id); ?></p>-->
                                    <form role="form" class="form-horizontal" action="<?= base_url('create_fumigation/insert') ?>" method="post" enctype="multipart/form-data" name="createloading_form" id="createloading_form">
                                        <!-- <input type="hidden" name="export_invoice_id" value="<?= $export_invoice_id ?>"> -->
												<tr>
                                                    <td colspan="6">DPPQS Registration No :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="dppqs_number" id="dppqs_number" class="form-control" placeholder="DPPQS Registration No" />
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">Treatment Certificate Number :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="treatment_certificate_number" id="treatment_certificate_number" class="form-control" placeholder="Treatment Certificate Number" />
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">Date Of Issue : </td>
                                                    <td colspan="6">
                                                        <input type="text" name="date_of_issue" id="date_of_issue" class="form-control defualt-date-picker" placeholder="Date Of Issue" />
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
                                                        <input type="text" name="consigner_exporter" id="consigner_exporter" class="form-control" placeholder="Consigner / Exporter"  value="<?=$company_detail[0]->shipper_name?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Declared Name & Address of Consignee / Importer</td>
                                                    <td colspan="6">
                                                        <textarea type="text" name="consignee_importer" id="consignee_importer" class="form-control" placeholder="Consignee / Importer" ><?=$company_detail[0]->shipper_address?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Description of Goods</td>
                                                    <td colspan="6">
                                                        <input  type="text" name="description_of_goods" id="description_of_goods" class="form-control" placeholder="Description of Goods" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Quantity Declared</td>
                                                    <td colspan="6">
                                                        <input type="text" name="quantity_declared" id="quantity_declared" class="form-control" placeholder="Quantity Declared" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Distinguishing Marks</td>
                                                    <td colspan="6">
                                                        <input type="text" name="distinguishing_marks" id="distinguishing_marks" class="form-control" placeholder="Distinguishing Marks" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Consignment Link / Container No.</td>
                                                    <td colspan="6">
                                                        <input type="text" name="consignment_link_container_no" id="consignment_link_container_no" class="form-control" placeholder="Consignment Link / Container No."  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">RFID – E – SEAL</td>
                                                    <td colspan="6">
                                                        <input type="text" name="rfid_e_seal" id="rfid_e_seal" class="form-control" placeholder="RFID – E – SEAL"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Port & Country of Loading</td>
                                                    <td colspan="6">
                                                        <input type="text" name="port_country_of_loading" id="port_country_of_loading" class="form-control" placeholder="Port & Country of Loading"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Declared Point of Entry</td>
                                                    <td colspan="6">
                                                        <input type="text" name="declared_point_of_entry" id="declared_point_of_entry" class="form-control" placeholder="Declared Point of Entry"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Country of Destination</td>
                                                    <td colspan="6">
                                                        <input type="text" name="country_of_destination" id="country_of_destination" class="form-control" placeholder="Country of Destination" />
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
                                                                <input type="text" name="fumigant_name" id="fumigant_name" class="form-control" placeholder="Fumigant Name" />
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="date" name="date_of_treatment" id="date_of_treatment" class="form-control" placeholder="Date Of Fumigation" />
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="text" name="place_of_fumigation" id="place_of_fumigation" class="form-control" placeholder="Place Of Fumigation" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="font-weight:bold;text-align:center">Dosage Rate Of Fumigant</th>
                                                            <th style="font-weight:bold;text-align:center">Duration Of Fumigation</th>
                                                            <th style="font-weight:bold;text-align:center">Minimum Air Temperature</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center">
                                                                <input type="text" name="dosage_rate_of_fumigant" id="dosage_rate_of_fumigant" class="form-control" placeholder="Dosage Rate" />
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="text" name="duration_of_fumigation" id="duration_of_fumigation" class="form-control" placeholder="Duration Of Fumigation" />
                                                            </td>
                                                            <td style="text-align:center">
                                                                <input type="text" name="minimum_air_temperature" id="minimum_air_temperature" class="form-control" placeholder="Minimum Air Temperature" />
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table border="1" style="width: 100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:left">Fumigation has been performed in under gas tight sheet</td>
                                                            <td>
                                                                <input type="text" name="fumigation_under_gas_tight_sheet" id="fumigation_under_gas_tight_sheet" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Container Pressure Test Conducted</td>
                                                            <td>
                                                                <input type="text" name="container_pressure_test_conducted" id="container_pressure_test_conducted" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Container has 200mm free air space at top of container</td>
                                                            <td>
                                                                <input type="text" name="container_free_air_space" id="container_free_air_space" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">In Transit Fumigation – Needs Ventilation at Port of Discharge</td>
                                                            <td>
                                                                <input type="text" name="in_transit_fumigation_ventilation" id="in_transit_fumigation_ventilation" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Container/Enclosure has been ventilated to below 5ppm v/v Methyl Bromide</td>
                                                            <td>
                                                                <input type="text" name="container_ventilation_below_5ppm" id="container_ventilation_below_5ppm" class="form-control" placeholder="Yes/No">
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
                                                                <input type="text" name="fumigation_prior_to_finishing" id="fumigation_prior_to_finishing" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Has plastic wrapping been used in the consignment?</td>
                                                            <td>
                                                                <input type="text" name="plastic_wrapping_used" id="plastic_wrapping_used" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">If Yes, has the consignment been fumigated prior to wrapping?</td>
                                                            <td>
                                                                <input type="text" name="fumigated_prior_to_wrapping" id="fumigated_prior_to_wrapping" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Or has the plastic wrapping been slashed, opened or perforated in the timber in accordance with the Wrapping and Perforation standard?</td>
                                                            <td>
                                                                <input type="text" name="plastic_wrapping_slashed" id="plastic_wrapping_slashed" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:left">Is the timber in this consignment less than 200mm thick in one dimension and correctly spaced every 200mm in height?</td>
                                                            <td>
                                                                <input type="text" name="timber_thickness_and_spacing" id="timber_thickness_and_spacing" class="form-control" placeholder="Yes/No">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
												
												
												<br>
												<tr>
                                                    <td colspan="6">Name Of Accredited Fumigation Operator :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="nameof_accreditedfumigation" id="nameof_accreditedfumigation" class="form-control" placeholder="Name Of Accredited Fumigation Operator" />
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">DPPQS Accreditation card no :</td>
                                                    <td colspan="6">
                                                        <input type="text" name="dppqs_accreditation_cardno" id="dppqs_accreditation_cardno" class="form-control" placeholder="DPPQS Accreditation card no" />
                                                    </td>
                                                </tr>
												<tr>
                                                    <td colspan="6">DPPQS Date : </td>
                                                    <td colspan="6">
                                                        <input type="text" name="dppqs_date" id="dppqs_date" class="form-control defualt-date-picker" placeholder="DPPQS Date" />
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
     console.log("Export Invoice ID: <?= isset($invoicedata['export_invoice_id']) ? $invoicedata['export_invoice_id'] : 'Not Set'; ?>");
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
 
 