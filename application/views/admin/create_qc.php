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
									<a href="<?=base_url().'producation_detail'?>">Production List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
									<h3>QC Detail</h3>
							</div>
						</div>
					</div>
			 		<div class="row">
						<div class="col-sm-12">
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> QC 	
										
								</div>
                              	<div class="panel-body">
								<div class="pull-left form-group">
										 
									 	</div>
								<div class="form-body">

                                    <form role="form" class="form-horizontal" action="<?= base_url('create_qc/insert') ?>" method="post" enctype="multipart/form-data" name="createloading_form" id="createloading_form">
                                      
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
                                                    <td style="text-align:center" colspan="12"><strong>Details Of QC</strong></td>
                                                </tr>
                                                       
                                                        <input type="hidden" name="production_mst_id" id="production_mst_id" class="form-control" placeholder="Production ID" value="<?= $production_mst_id ?>"/>

                                                <tr>
                                                    <td colspan="6">Qc No</td>
                                                    <td colspan="6">
                                                        <input type="text" name="qc_no" id="qc_no" class="form-control" placeholder="QC NO" />
                                                    </td>
                                                </tr> 
												
												<tr>
                                                    <td colspan="6">Plant Name & Address</td>
                                                    <td colspan="6">
                                                        <input type="text" name="plantname_address" id="plantname_address" class="form-control" placeholder="Plant Name & Address" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Plant Owner & Contact No</td>
                                                    <td colspan="6">
                                                        <textarea type="text" name="plantowner_contactno" id="plantowner_contactno" class="form-control" placeholder="Plant Owner & Contact No" ></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Plant Contact Person & No</td>
                                                    <td colspan="6">
                                                        <input  type="text" name="plantcontactperson_no" id="plantcontactperson_no" class="form-control" placeholder="Plant Contact Person & No" />
                                                    </td>
                                                </tr> 
												<tr>
                                                    <td colspan="6">QC Image</td>
                                                    <td colspan="6">
														<input type="file" name="qc_image" id="qc_image" class="form-control"> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">PO/PI Details</td>
                                                    <td colspan="6">
                                                        <input type="text" name="po_pi_details" id="po_pi_details" class="form-control" placeholder="PO/PI Details" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Product Type</td>
                                                    <td colspan="6">
                                                        <input type="text" name="product_type" id="product_type" class="form-control" placeholder="Product Type" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Design Name & Quantity</td>
                                                    <td colspan="6">
                                                        <input type="text" name="designname_qty" id="designname_qty" class="form-control" placeholder="Design Name & Quantity"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Size</td>
                                                    <td colspan="6">
                                                        <input type="text" name="size" id="size" class="form-control" placeholder="Size"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Batches/Shades</td>
                                                    <td colspan="6">
                                                        <input type="text" name="batches_shades" id="batches_shades" class="form-control" placeholder="Batches/Shades"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Packing Details:</td>
                                                    <td colspan="6">
                                                        <input type="text" name="packing_details" id="packing_details" class="form-control" placeholder="Packing Details:"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">a) Pcs.Per Box</td>
                                                    <td colspan="6">
                                                        <input type="text" name="pcs_per_box" id="pcs_per_box" class="form-control" placeholder="Pcs.Per Box" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">b) Corner Guard</td>
                                                    <td colspan="6">
                                                        <input type="text" name="corner_guard" id="corner_guard" class="form-control" placeholder="Corner Guard" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">c) Binder/Strap Qty Per Box</td>
                                                    <td colspan="6">
                                                        <input type="text" name="binder" id="binder" class="form-control" placeholder="Binder/Strap Qty Per Box" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">d) Carton Quality(3 Ply/ 5 Ply/ 7 Lamination/Plain)</td>
                                                    <td colspan="6">
                                                        <input type="text" name="carton_quality" id="carton_quality" class="form-control" placeholder="Carton Quality" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">e) Carton Box Design/Colour/Name/Details</td>
                                                    <td colspan="6">
                                                        <input type="text" name="carton_boxdesign" id="carton_boxdesign" class="form-control" placeholder="Carton Box Design" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">f) Label Content</td>
                                                    <td colspan="6">
                                                        <input type="text" name="label_content" id="label_content" class="form-control" placeholder="Label Content" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">g) Barcode Sticker Details</td>
                                                    <td colspan="6">
                                                        <input type="text" name="barcode_sticker_details" id="barcode_sticker_details" class="form-control" placeholder="Barcode Sticker Details" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">h) Separation Of Tiles</td>
                                                    <td colspan="6">
                                                        <input type="text" name="separation_between_tiles" id="separation_between_tiles" class="form-control" placeholder="Separation Of Tiles" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">i) Any Other Specific Details</td>
                                                    <td colspan="6">
                                                        <input type="text" name="any_other_details" id="any_other_details" class="form-control" placeholder="Any Other Specific Details" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Back Appearance(Logo/Without Logo/,Any Other Info)</td>
                                                    <td colspan="6">
                                                        <input type="text" name="back_appearance" id="back_appearance" class="form-control" placeholder="Back Appearance" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Which Standard To Follow(Your Inputs Or Inhouse STD)</td>
                                                    <td colspan="6">
                                                        <input type="text" name="standard_to_follow" id="standard_to_follow" class="form-control" placeholder="Which Standard To Follow" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Reference Sample Details</td>
                                                    <td colspan="6">
                                                        <input type="text" name="refrence_sample_design" id="refrence_sample_design" class="form-control" placeholder="Reference Sample Details" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">L/A/B Value Details</td>
                                                    <td colspan="6">
                                                        <input type="text" name="l_a_b_value_details" id="l_a_b_value_details" class="form-control" placeholder="L/A/B Value Details" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Any Other Instructions</td>
                                                    <td colspan="6">
                                                        <input type="text" name="any_other_instructions" id="any_other_instructions" class="form-control" placeholder="Any Other Instructions" />
                                                    </td>
                                                </tr>
												
												<tr>
                                                    <td colspan="3">Date</td>
                                                    <td colspan="3">
                                                        <input type="text" name="qc_date" id="qc_date" class="form-control defualt-date-picker" placeholder="Qc Date" />
                                                    </td>
													
													<td colspan="3">Sign</td>
                                                    <td colspan="3">
                                                        <input type="text" name="qc_sign" id="qc_sign" class="form-control" placeholder="Qc Sign" />
                                                    </td>
                                                </tr>
                                                </table>

                                        </table>

						
								<div style="padding: 14px;" >	
							 		<div class="form-group"  >
                                        <button type="submit" name="submit" class="btn btn-success">
                                            Save
                                        </button>
                                        <a href="<?= base_url('producation_detail') ?>" class="btn btn-danger">
                                            Cancel
                                        </a>
									</div>	
								</div>	
									 		<input type="hidden" name="qc_image_name" id="qc_image_name" value="<?=set_value('qc_image', $qc_data['qc_image']) ?>"/>
									
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
     console.log("Export Invoice ID: <?= isset($invoicedata['production_mst_id']) ? $invoicedata['production_mst_id'] : 'Not Set'; ?>");
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
 
 