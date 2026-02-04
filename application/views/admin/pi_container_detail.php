<?php 
$this->view('lib/header'); 
?>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"pdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"pdf/view_pdf";
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
          <li> <i class="clip-pencil"></i> <a href="<?=base_url()?>dashboard"> Dashboard </a> </li>
          <li class="active"> <a href="<?=base_url()?>assign_producation">Loading plan</a> </li>
          <li class="active"> Container Detail </li>
        </ol>
        <div class="page-header title1">
          <h3>Container Detail </h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-external-link-square"></i> <a href="<?=base_url()?>assign_producation">Assign Producation</a> </div>
          <div class="">
            <div class="panel-body form-body">
              <div class="col-md-12">
                <form name="container_detail_form" id="container_detail_form" action="javascript:;">
                  <div class="col-md-12"> </div>
                  <div class="pull-left form-group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">Import From CSV </button>
                    <?php echo $csverror; ?>
					<button type="button" class="btn btn-danger mb-2" onclick="clearAllInputs()">Clear All Fields</button>
                  </div>
                  <table class="table table-bordered table-hover"  style="width:100%;" name='tt' id = 'tt'>
                    <thead>
                      <tr>
                        <th class="text-center" width="10%">Company Name</th>
                        <th class="text-center" width="8%">Container/Size</th>
                        <th class="text-center" width="8%">Line Seal</th>
                        <th class="text-center" width="8%">Self Seal</th>
                        <th class="text-center" width="8%">Booking No</th>
                        <th class="text-center" width="8%">LR NO</th>
                        <th class="text-center" width="8%">Truck No</th>
                        <th class="text-center" width="8%">Mobile No</th>
                        <th class="text-center" width="7%">Product Detail</th>
                        <th class="text-center" width="7%">Net Weight</th>
                        <th class="text-center" width="7%">Gross Weight</th>
                        <th class="text-center" width="7%">Tare Weight</th>
                        <th class="text-center" width="9%">Pallet No</th>
                        <th class="text-center" width="9%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $Total_plts     = 0;
                      $Total_sqm      = 0;
                      $Total_box      = 0;
                      $setcontainer     = 0;
                      $packingtrn_array   = array();
                      $con_entry      = 1;
                      $container_details  = 0;
                      $con_array      = array();
                      $conarray       = array();
                      $coarray      = array();
                      if(!empty($set_container))
                      {   
			// print_r($set_container);
			// print_r($importdata);	
                        $container_twenty = intval($invoicedata->container_twenty);
                        $container_forty  = $container_twenty + intval($invoicedata->container_forty);
                        $no = 1;

                        for($i=0; $i<count($set_container);$i++)
                      {
                        $rowcon_no = ($set_container[$i]->rowcon_no > 1)?$set_container[$i]->rowcon_no:''; 
                          ?>
                      <tr class="<?=$i?>">
                        <td class="text-center">
						  <?=$set_container[$i]->company_name?>
						</td>

                        <?php
                                                    
                          if(!in_array($set_container[$i]->con_entry,$con_array))
                          {
                            $con_entry = $set_container[$i]->max_no + 1;
                            $setcontainer += 1;
							
                            
                             
                             $container_details++;
                           $checked  = ($set_container[$i]->container_size == 20)?'checked':'';
                           $checked1 = ($set_container[$i]->container_size == 40)?'checked':'';
                           $checked2 = ($set_container[$i]->container == 1)?'checked':'';
                           $checked3 = ($set_container[$i]->container == 0.5)?'checked':'';
                          ?>
                        <td rowspan="<?=$rowcon_no?>">
						<div style="font-weight:bold; text-align:center; margin-bottom:5px;">
							<?= $setcontainer ?>
						 </div>
						  <input type="text" name="container_no[]" id="container_no<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][0] : $set_container[$i]->container_no?>" class="form-control" />
                          <br> 
                          <label class="radio-inline">
                            <input type="radio" <?=$checked?> name="container_size<?=$set_container[$i]->pi_loading_plan_id?>" id="container_size<?=$set_container[$i]->pi_loading_plan_id?>1" value="20" />
                            20 </label>
                          <label class="radio-inline">
                            <input type="radio" <?=$checked1?> name="container_size<?=$set_container[$i]->pi_loading_plan_id?>" id="container_size<?=$set_container[$i]->pi_loading_plan_id?>2" value="40" />
                            40 </label>
                          <br>
                          <hr>
                          <label class="radio-inline">
                            <input type="radio" <?=$checked2?> name="full_container<?=$set_container[$i]->pi_loading_plan_id?>" id="full_container<?=$set_container[$i]->pi_loading_plan_id?>1" value="1" />
                            Full </label>
                          <label class="radio-inline">
                            <input type="radio" <?=$checked3?> name="full_container<?=$set_container[$i]->pi_loading_plan_id?>" id="full_container<?=$set_container[$i]->pi_loading_plan_id?>2" value="0.5" />
                            Half </label></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="seal_no[]" id="seal_no<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][1] : $set_container[$i]->seal_no?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="rfidseal_no[]" id="rfidseal_no<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][2] : $set_container[$i]->rfidseal_no?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="booking_no[]" id="booking_no<?=  $set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][3] : $set_container[$i]->booking_no?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="lr_no[]" id="lr_no<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][4] : $set_container[$i]->lr_no?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="truck_no[]" id="truck_no<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][5] : $set_container[$i]->truck_no?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="mobile_no[]" id="mobile_no<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][6] : $set_container[$i]->mobile_no?>" class="form-control" /></td>
                        <?php 
                            array_push($con_array,$set_container[$i]->con_entry);
                          }
                           
                            if($set_container[$i]->product_id == 0)
                            {
                              echo '<td>'.$set_container[$i]->description_goods.'</td>';
                            }
                            else
                            {
                          ?>
                        <td><?=$set_container[$i]->size_type_mm?>
                          <br>
                          <?=$set_container[$i]->model_name?>
                          <br>
                          <?=$set_container[$i]->finish_name?></td>
                        <?php
                            }
                            
                          if(!in_array($set_container[$i]->con_entry,$conarray))
                          {
                            $orignal_net_weight = !empty($set_container[$i]->orignal_net_weight)?$set_container[$i]->orignal_net_weight:0;
                            
                            $orignal_pallet_weight = !empty($set_container[$i]->orignal_pallet_weight)?$set_container[$i]->orignal_pallet_weight:0;
                            $orignal_big_pallet_weight = !empty($set_container[$i]->orignal_big_pallet_weight)?$set_container[$i]->orignal_big_pallet_weight:0;
                            $orignal_small_pallet_weight = !empty($set_container[$i]->orignal_small_pallet_weight)?$set_container[$i]->orignal_small_pallet_weight:0;
                            
                            $gross_weight   = ($orignal_net_weight + $orignal_pallet_weight + $orignal_big_pallet_weight + $orignal_small_pallet_weight);
                            $net_weight   = $orignal_net_weight;
                            
                            if($set_container[$i]->origanal_pallet>0)
                            {
                              $gross_weight += $orignal_pallet_weight;
                            }
                            else if($set_container[$i]->orginal_no_of_big_pallet>0 || $set_container[$i]->orginal_no_of_small_pallet>0)
                            {
                              $gross_weight += $orignal_big_pallet_weight;
                              $gross_weight += $orignal_small_pallet_weight;
                            }
                             
                            if($set_container[$i]->updated_gross_weight > 0)
                            {
                              $gross_weight = $set_container[$i]->updated_gross_weight;
                            }
                            if($set_container[$i]->updated_net_weight > 0)
                            {
                              $net_weight = $set_container[$i]->updated_net_weight;
                            }
                            $rowcon_no = ($set_container[$i]->rowcon_no > 1)?$set_container[$i]->rowcon_no:'';
                            if($set_container[$i]->product_id == 0)
                            {
                              $net_weight   = $set_container[$i]->other_orignal_net_weight;
                              $gross_weight   = $set_container[$i]->other_orignal_gross_weight;
                            }                             
                          ?>
                        <td rowspan="<?=$rowcon_no?>"> <input type="text" name="net_weight[]" id="net_weight<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][7] : $net_weight?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="gross_weight[]" id="gross_weight<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][8] : $gross_weight?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="tare_weight[]" id="tare_weight<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][9] : $set_container[$i]->tare_weight?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><input type="text" name="remarks[]" id="remarks<?=$set_container[$i]->pi_loading_plan_id?>" value="<?= isset($importdata[$i]) ? $importdata[$i][10] : $set_container[$i]->remark?>" class="form-control" /></td>
                        <td rowspan="<?=$rowcon_no?>"><?php
                            if($set_container[$i]->export_done_status == 0)
                            {
                              ?>
                          <a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit Product Detail"  onclick="edit_loading(<?=$set_container[$i]->con_entry?>,<?=$set_container[$i]->performa_invoice_id?>,<?=$set_container[$i]->supplier_id?>)" href="javascript:;" ><i class="fa fa-pencil"></i></a> <br>
                          &nbsp;
                          <?php
                              if(!empty($set_container[$i]->container_no))
                              {
                              ?>
                          <a class="tooltips btn btn-primary" data-toggle="tooltip" data-title="Upload Container Photo"  href="<?=base_url().'container_loading/index/'.$set_container[$i]->pi_loading_plan_id?>/<?=$set_container[$i]->container_no?>"><i class="fa fa-upload"></i></a>
                          <?php
                              }
                              ?>
                          <?php 
                            }
                             
                            ?></td>
                        <input type="hidden" name="pi_loading_plan_id[]" id="pi_loading_plan_id<?=$set_container[$i]->pi_loading_plan_id?>" value="<?=$set_container[$i]->pi_loading_plan_id?>" />
                        <input type="hidden" name="export_done_status[]" id="export_done_status<?=$set_container[$i]->pi_loading_plan_id?>" value="<?=$set_container[$i]->export_done_status?>" />
                        <input type="hidden" name="con_entry[]" id="con_entry<?=$set_container[$i]->pi_loading_plan_id?>" value="<?=$set_container[$i]->con_entry?>" />
                        <?php 
                            array_push($conarray,$set_container[$i]->con_entry);
                          }
                          ?>
                        <input type="hidden" name="performainvoice_id[]" id="performainvoice_id<?=$set_container[$i]->pi_loading_plan_id?>" value="<?=$invoicedata->performa_invoice_id?>" />
                      </tr>
                      <?php
                          
                      } // end foreach
                      }
                      else
                      {
                        echo "<tr>
                            <td  class='text-center' colspan='13'>Container Not set</td>
                            </tr>";
                      }
                        
                        ?>
                    </tbody>
                  </table>
                  <div style="padding: 14px;padding-left:0px;">
                    <button class="btn btn-success" >Save</button>
                    <a href="<?=base_url().'assign_producation'?>" class="btn btn-danger"> Back </a>
                    <input type="hidden" id="performa_invoice_id" name="performa_invoice_id" value="<?=$invoicedata->performa_invoice_id?>">
                    <div class="errormsg" style="color:red"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->view('lib/footer'); ?>
<div id="excelModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:1122px"> 
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
        <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Container Product detail </h4>
      </div>
      <form class="form-horizontal askform" action="javascript:;"  method="post" name="wallproduct_form" id="wallproduct_form">
        <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productmodal" data-keyboard="false" data-backdrop="static">+ Product </button>
            </div>
            <input type="hidden" id="performainvoice_id" name="performainvoice_id" value="<?=$invoicedata->performa_invoice_id?>">
            <div class="col-md-12" id="set_container_detail" style="margin-top:10px;"> </div>
          </div>
        </div>
        <div class="modal-footer">
          <input name="Submit" type="submit" value="save" id="submit_btn" class="btn btn-success"  />
          <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <input type="hidden" name="supplier_mst_id" id="supplier_mst_id" />
      </form>
    </div>
  </div>
</div>
<div id="productmodal" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Product</h4>
      </div>
      <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="product_add" id="product_add">
        <input type="hidden" id="pinvoice_id" name="pinvoice_id" value="<?=$invoicedata->performa_invoice_id?>">
		
        <input type="hidden" id="con_entry" name="con_entry" value="">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 control-label" for="form-field-1"> Select Product </label>
              <div class="col-sm-12">
                <select class="select2" id="product_id" name="product_id" onchange="load_packing(this.value)">
                  <option value="">Select Product Name</option>
                  <?php
								for($p=0;$p<count($allproduct);$p++)
								{
									$thickness = (!empty($allproduct[$p]->thickness))?" - ".$allproduct[$p]->thickness." MM":"";
								 ?>
                  <option value="<?=$allproduct[$p]->product_id?>">
                  <?=$allproduct[$p]->size_type_mm.' ('.$allproduct[$p]->series_name.')'.$thickness?>
                  </option>
                  <?php
								}
								?>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label class="col-sm-12 control-label" for="form-field-1"> Select Packing </label>
              <div class="col-sm-12">
                <select class="select2" id="packing_id" name="packing_id" onchange="load_design(this.value)">
                  <option value="">Select Packing Name</option>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label class="col-sm-12 control-label" for="form-field-1"> Select Design </label>
              <div class="col-sm-12">
                <select class="select2" id="design_id" name="design_id" onchange="load_finish(this.value)">
                  <option value="">Select Design Name</option>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label class="col-sm-12 control-label" for="form-field-1"> Select Finish </label>
              <div class="col-sm-12">
                <select class="select2" id="finish_id" name="finish_id">
                  <option value="">Select Finish</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="form-field-1"> Client Design Name </label>
              <div class="col-sm-12">
                <input type="text" placeholder="Client Design Name" id="client_design_name" class="form-control" name="client_design_name" value="">
              </div>
            </div>
            <div class="col-md-6 form-group single_con">
              <label class="col-sm-12 control-label" for="form-field-1"> Pallet </label>
              <div class="col-sm-12">
                <input type="text" placeholder="Pallet" id="no_of_pallet" class="form-control" name="no_of_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)">
              </div>
            </div>
            <div class="col-md-6 form-group multi_con" style="display:none">
              <label class="col-sm-12 control-label" for="form-field-1"> Big Pallet </label>
              <div class="col-sm-12">
                <input type="text" placeholder="Big Pallet" id="no_of_big_pallet" class="form-control" name="no_of_big_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)">
              </div>
            </div>
            <div class="col-md-6 form-group multi_con" style="display:none">
              <label class="col-sm-12 control-label" for="form-field-1"> Small Pallet </label>
              <div class="col-sm-12">
                <input type="text" placeholder="Small Pallet" id="no_of_small_pallet" class="form-control" name="no_of_small_pallet" value="" onkeyup="cal_sqm(2);" onblur="cal_sqm(2)" >
              </div>
            </div>
            <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="form-field-1"> Boxes </label>
              <div class="col-sm-12">
                <input type="text" placeholder="Boxes" id="boxes" class="form-control" name="boxes" value="" onkeyup="cal_sqm(1);" onblur="cal_sqm(1)" >
              </div>
            </div>
            <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="form-field-1"> Batch </label>
              <div class="col-sm-12">
                <input type="text" placeholder="Batch No" id="batch_no" class="form-control" name="batch_no" value=""  >
              </div>
            </div>
            <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="form-field-1"> Shade No </label>
              <div class="col-sm-12">
                <input type="text" placeholder="Shade No" id="shade_no" class="form-control" name="shade_no" value=""  >
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input name="Submit" type="submit" value="Add" class="btn btn-info"  />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <input type="hidden" name="total_no_of_sqm" id="total_no_of_sqm" value="" />
        <input type="hidden" name="net_weight" id="net_weight" value="" />
        <input type="hidden" name="gross_weight" id="gross_weight" value="" />
        <input type="hidden" name="pallet_status" id="pallet_status" value="" />
        <input type="hidden" name="sqm_per_box" id="sqm_per_box" value="" />
        <input type="hidden" name="pcs_per_box" id="pcs_per_box" value="" />
        <input type="hidden" name="weight_per_box" id="weight_per_box" value="" />
        <input type="hidden" name="pallet_weight" id="pallet_weight" value="" />
        <input type="hidden" name="big_pallet_weight" id="big_pallet_weight" value="" />
        <input type="hidden" name="small_pallet_weight" id="small_pallet_weight" value="" />
        <input type="hidden" name="boxes_per_pallet" id="boxes_per_pallet" value="" />
        <input type="hidden" name="big_boxes_per_pallet" id="big_boxes_per_pallet" value="" />
        <input type="hidden" name="small_boxes_per_pallet" id="small_boxes_per_pallet" value="" />
        <input type="hidden" name="new_container_no" id="new_container_no" value="" />
        <input type="hidden" name="new_seal_no" id="new_seal_no" value="" />
        <input type="hidden" name="new_rfidseal_no" id="new_rfidseal_no" value="" />
        <input type="hidden" name="production_mst_id" id="production_mst_id" value="" />
        <input type="hidden" name="new_booking_no" id="new_booking_no" value="" />
        <input type="hidden" name="new_lr_no" id="new_lr_no" value="" />
        <input type="hidden" name="new_truck_no" id="new_truck_no" value="" />
        <input type="hidden" name="new_remark" id="new_remark" value="" />
        <input type="hidden" name="new_tare_weight" id="new_tare_weight" value="" />
        <input type="hidden" name="new_supplierid" id="new_supplierid" value="" />
        <input type="hidden" name="new_container_size" id="new_container_size" value="" />
        <input type="hidden" name="new_container" id="new_container" value="" />
        <input type="hidden" name="new_conentry" id="new_conentry" value="" />
      </form>
    </div>
  </div>
</div>
<!--<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 
  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">From CSV</h4>
      </div>
      <form method="post" action="" enctype="multipart/form-data">
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <h4>Copy & Paste Rules</h4>
            <br>
            -> Please remove space between words in colom.<br>
            -> Container Size not include from excel copy. </div>
          <div class="col-md-12">
            <input type="file" name="file" id="file" accept=".csv">
          </div>
		   <br>
                     
        </div>
      </div>      
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Import</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>-->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import CSV File</h4>
      </div>
      <div class="modal-body">
        <input type="file" id="csv_file" accept=".csv" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" onclick="import_csv()" class="btn btn-success">Import</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
// Global helper function to safely block page - works even if block_page is not defined (e.g. when footer not loaded)
function safeBlock() {
	if(typeof block_page === 'function') {
		block_page();
	} else if(typeof $.blockUI === 'function') {
		$.blockUI({ css: {
			border: 'none',
			padding: '0px',
			width: '17%',
			left:'43%',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff',
			zIndex: '10000'
		},
		message :  '<h3> Please wait...</h3>' });
	}
}

// Global helper function to safely unblock page - works even if unblock_page is not defined
function safeUnblock(type, msg) {
	if(typeof unblock_page === 'function') {
		unblock_page(type, msg);
	} else if(typeof $.unblockUI === 'function') {
		// Fallback to direct jQuery unblockUI
		if(type !== "" && msg !== "") {
			if(typeof toastr !== 'undefined') {
				toastr[type](msg);
			}
		}
		setTimeout($.unblockUI, 500);
	}
}

function clearAllInputs() {
    if(confirm("Are you sure you want to clear all fields?")) {
        const table = document.getElementById("tt");
        table.querySelectorAll("input[type='text'], input[type='number'], textarea").forEach(function(el) {
            el.value = "";
        });
        // table.querySelectorAll("input[type='radio']").forEach(function(el) {
            // el.checked = false;
        // });
    }
}
function edit_loading(con_entry,performa_invoice_id,supplier_id)
{
	 safeBlock();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/editloading',
              data: {
                "con_entry"				: con_entry,
                "performa_invoice_id"	: performa_invoice_id
              }, 
              cache: false, 
              success: function (data) 
			  { 
				var obj = JSON.parse(data);
					$("#excelModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$(".edit_html").show();
				 	$("#set_container_detail").html(obj.html);
				 	  $("#new_container_no").val(obj.container_no)
				 	  $("#new_seal_no").val(obj.seal_no)
				 	  $("#new_rfidseal_no").val(obj.rfidseal_no)
				 	  $("#new_booking_no").val(obj.booking_no)
				 	  $("#new_lr_no").val(obj.lr_no)
				 	  $("#new_truck_no").val(obj.truck_no)
				 	  $("#new_remark").val(obj.mobile_no)
				 	  $("#new_tare_weight").val(obj.remark)
				 	  $("#new_supplierid").val(obj.supplier_id)
				 	  $("#new_container_size").val(obj.container_size)
				 	  $("#new_container").val(obj.container)
				 	  $("#new_conentry").val(obj.con_entry);
					safeUnblock('',"")
              }
			});
		 
}
function make_pallet(con_entry,performa_invoice_id,supplier_id,piloading_plan_id)
{
	var pi_loading_plan_id = [];
	var already_pi_loading_plan_id = [];
	 
	 $('input[name="make_pallet[]"]').each(function() {
       
		if ($(this).is(":checked") &&  $("#already_pi_loading_plan_id"+$(this).val()).val() == 2) 
		{
		    pi_loading_plan_id.push($(this).val());
		}
	  });
	 
	 if(pi_loading_plan_id == "" || pi_loading_plan_id == null)
	 {
		 safeUnblock('error',"Please select atlest 1 design");
		 return false;
	 }
	 safeBlock();
	$.ajax({ 
             type: "POST", 
             url: root+'create_pi_loading/make_pallet',
             data: 
			 {
					"pi_loading_plan_id"	: pi_loading_plan_id, 
					"make_pallet_no"		: $("#make_pallet_no").val(), 
					"piloading_plan_id"		: piloading_plan_id 
             }, 
             cache: false, 
             success: function (data)
			 { 
					edit_loading(con_entry,performa_invoice_id,supplier_id);
					safeUnblock("","");
             }
			}); 
		  
}
function delete_pallet(con_entry,performa_invoice_id,supplier_id,piloading_plan_id)
{
	 	Swal.fire({
  title: 'You want to Delete?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, confirm it!'
}).then((result) => {
		 if (result.value) {
	 safeBlock();
	$.ajax({ 
             type: "POST", 
             url: root+'create_pi_loading/delete_pallet',
             data: 
			 {
					"pi_loading_plan_id"	: piloading_plan_id 
             }, 
             cache: false, 
             success: function (data)
			 { 
					edit_loading(con_entry,performa_invoice_id,supplier_id);
					safeUnblock("","");
             }
			}); 
		 }
		 });
		  
}
$("#container_detail_form").submit(function(event) {
	event.preventDefault();
	var inps = document.getElementsByName('pi_loading_plan_id[]');
	
	var no=1;
	var container_no = new Array();
	var seal_no 		 = new Array();
	var rfidseal_no 	 = new Array();
	for(var i = 0; i <inps.length; i++) 
	{
		
			var inp=inps[i];
			console.log($("#container_no"+inp.value).val())
			if($("#container_no"+inp.value).val() == "")
			{	
				$("#container_no"+inp.value).focus();
				 
			}
			else
			{
				container_no.push($("#container_no"+inp.value).val());
			}
			seal_no.push($("#seal_no"+inp.value).val());
			rfidseal_no.push($("#rfidseal_no"+inp.value).val());
	 	no++;	
	}
	 
	 
	var results = [];  
        for (var i = 0; i < container_no.length - 1; i++) {  
            if (container_no[i + 1] == container_no[i]) {  
                results.push(container_no[i]);  
            }  
        }  
		var results1 = [];  
        for (var i = 0; i < seal_no.length - 1; i++) {  
            if (seal_no[i + 1] == seal_no[i]) {  
                results1.push(seal_no[i]);  
            }  
        }  
		var results2 = [];  
        for (var i = 0; i < rfidseal_no.length - 1; i++) {  
            if (rfidseal_no[i + 1] == rfidseal_no[i]) {  
                results2.push(rfidseal_no[i]);  
            }  
        }  
	 	  
	safeBlock();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'create_pi_loading/container_detail_entry',
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
				    safeUnblock("success","Packing Detail Sucessfully Added.");
					//setTimeout(function(){ location.reload(); },1500);
				  	setTimeout(function(){ window.location=root+'ready_for_export' },1000);
				}
			   else
			   {
				    safeUnblock("error","Something Wrong.") 
			   }
			     
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
 
});
function import_csv() {
    var fileInput = document.getElementById('csv_file');
    if (!fileInput.files.length) {
        alert("Please select a CSV file.");
        return;
    }

    var file = fileInput.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        var contents = e.target.result.trim();
        var rows = contents.split(/\r?\n/);

        var containerIndex = 0;

        rows.forEach(function(line, idx) {
            if (idx === 0) return; // skip header row

            var cols = line.split(","); // change to "\t" if you copy-paste from Excel

            if (cols.length < 11) return; // must have all columns

            // Get all container_no[] inputs
            var containerInputs = $("input[name='container_no[]']");

            if (containerIndex < containerInputs.length) {
                var pid = $(containerInputs[containerIndex]).attr("id").replace("container_no", "");

                $("#container_no" + pid).val(cols[0]);
                $("#seal_no" + pid).val(cols[1]);
                $("#rfidseal_no" + pid).val(cols[2]);
                $("#booking_no" + pid).val(cols[3]);
                $("#lr_no" + pid).val(cols[4]);
                $("#truck_no" + pid).val(cols[5]);
                $("#mobile_no" + pid).val(cols[6]);
                $("#net_weight" + pid).val(cols[7]);
                $("#gross_weight" + pid).val(cols[8]);
                $("#tare_weight" + pid).val(cols[9]);
                $("#remarks" + pid).val(cols[10]); // here you can map PalletNo → remarks or add a new field
            }

            containerIndex++;
        });

        $("#myModal").modal("hide");
    };

    reader.readAsText(file);
}


$("#wallproduct_form").submit(function(event) {
	event.preventDefault();
	if(!$("#wallproduct_form").valid())
	{
		return false;
	}
 	 
	safeBlock();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url:  root+'create_pi_loading/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				 
				 
				   $("#product_form").trigger('reset');
				  //  unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ location.reload(); },1000);
		    },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function load_design(product_size_id)
{
	safeBlock();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/load_design',
              data: {
                "product_size_id" : product_size_id 
              }, 
              cache: false, 
              success: function (data) 
			  { 
					var obj = JSON.parse(data);
					if(obj.packing.boxes_per_pallet > 0)
					{
						$("#pallet_status").val(1);
						$(".single_con").show();
					}
					else if(obj.packing.box_per_big_plt > 0 || obj.packing.box_per_small_plt_new > 0)
					{
						$("#pallet_status").val(3);
						$(".single_con").hide();
						$(".multi_con").show();
					}
					else 
					{
						$("#pallet_status").val(2);
						$(".single_con").hide();
						$(".multi_con").hide();
					}
					$("#pallet_weight").val(obj.packing.pallet_weight)
				 	$("#sqm_per_box").val(obj.packing.sqm_per_box)
					$("#pcs_per_box").val(obj.packing.pcs_per_box)
					$("#weight_per_box").val(obj.packing.weight_per_box)
					$("#small_pallet_weight").val(obj.packing.small_plat_weight)
					$("#big_pallet_weight").val(obj.packing.big_plat_weight)
					$("#boxes_per_pallet").val(obj.packing.boxes_per_pallet)
					$("#big_boxes_per_pallet").val(obj.packing.box_per_big_plt)
					$("#small_boxes_per_pallet").val(obj.packing.box_per_small_plt_new)
					
				   $("#design_id").html(obj.design_html);
						safeUnblock('',"")
              }
			});
}
function load_finish(design_id)
{
	safeBlock();
		$.ajax({ 
		type: "POST", 
		url: root+"product/load_finish_data",
		data: {
			"id": design_id 
		}, 
		success: function (response)
		{
			var obj = JSON.parse(response);
				$("#finish_id").html(obj.html);
				 safeUnblock("",""); 
		}
		
	}); 
}
function cal_sqm(no)
{
	
	 var radioValue = $("#pallet_status").val();
	  
	  if(radioValue==1)
	 {
		
		var sqm_per_box 			= $('#sqm_per_box').val();
		var boxes_per_pallet 		= $('#boxes_per_pallet').val();
		if(no == 2)
		{
			if($('#no_of_pallet').val() != undefined && $('#no_of_pallet').val() != "" )
			{
				var no_of_pallet 			= $('#no_of_pallet').val();
			 	var no_of_boxes 			= $('#no_of_pallet').val() * boxes_per_pallet;
			 	$('#boxes').val(no_of_boxes.toFixed(2));
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#total_no_of_sqm').val(no_of_sqm.toFixed(2));
				var net_weight = parseFloat(no_of_boxes) * $('#weight_per_box').val();
				$('#net_weight').val(net_weight.toFixed(2));
				var pallet_weight = $('#pallet_weight').val();
				var total_pallet_weight = parseFloat(pallet_weight) * parseFloat(no_of_pallet);
				$('#gross_weight').val(parseFloat(net_weight) + parseFloat(total_pallet_weight))
		  	}
		}
		else if(no == 1)
		{
			var no_of_pallet 			= $('#no_of_pallet').val();
			var no_of_boxes  = $('#boxes').val();
			var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#total_no_of_sqm').val(no_of_sqm.toFixed(2));
			var net_weight = parseFloat(no_of_boxes) * $('#weight_per_box').val();
			$('#net_weight').val(net_weight.toFixed(2));
			var pallet_weight = $('#pallet_weight').val();
			var total_pallet_weight = parseFloat(pallet_weight) * parseFloat(no_of_pallet);
			$('#gross_weight').val(parseFloat(net_weight) + parseFloat(total_pallet_weight))
		}
	 }
	 else if(radioValue==2)
	 {
		 var weight_per_box = $('#weight_per_box'+val).val();
		 var sqm_per_box 	= $('#sqm_per_box'+val).val();
		  
		 
			if($('#only_no_of_boxes'+val).val() != undefined && $('#only_no_of_boxes'+val).val() != "")
			{
				var no_of_boxes = $("#only_no_of_boxes"+val).val();
				var rate_usd_val = $('#product_rate'+val).val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				var product_total_amount = rate_usd_val * no_of_sqm;
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
			 	$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
	 	 	}
	 } 
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box').val();
		 var box_per_big_pallet 	= $('#big_boxes_per_pallet').val();
		 var box_per_small_pallet 	= $('#small_boxes_per_pallet').val();
		 var big_pallet_weight 		= $('#big_pallet_weight').val();
		 var small_pallet_weight 	= $('#small_pallet_weight').val();
		 var sqm_per_box 			= $('#sqm_per_box').val();
	 	 var no_of_big_pallet 		= ($('#no_of_big_pallet').val() > 0)?$('#no_of_big_pallet').val():0;
		 var no_of_small_pallet 	= ($('#no_of_small_pallet').val() > 0)?$('#no_of_small_pallet').val():0;
		  
		 var total_pallet 			= parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
		 var no_of_big_boxes 		= no_of_big_pallet * box_per_big_pallet;
		 var no_of_small_boxes 		= no_of_small_pallet * box_per_small_pallet;
		 var no_of_boxes 			= parseFloat(no_of_big_boxes) + parseFloat(no_of_small_boxes);
		  
		 $('#boxes').val(no_of_boxes.toFixed(2));
		 var no_of_sqm 				= no_of_boxes * sqm_per_box;
		 $('#total_no_of_sqm').val(no_of_sqm.toFixed(2));
		 var big_palletweight 		= no_of_big_pallet * big_pallet_weight;
		 var small_palletweight 	= no_of_small_pallet * small_pallet_weight;
		 var palletweight 			= parseFloat(big_palletweight)+parseFloat(small_palletweight);
		 var packing_net_weight 	= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
		 
		 $('#net_weight').val(packing_net_weight.toFixed(2));
		 $('#gross_weight').val(packing_gross_weight.toFixed(2));
		 	 
	  }
}
if(typeof closeNav === 'function') { closeNav(); }
$(".select2").select2({
	 width:"100%"
});
function close_modal()
{
	 location.reload();
}
function cal_product_invoice(val)
{
	
	 var radioValue = $("#pallet_status"+val).val();
    
	 if(radioValue==1)
	 {
		
		var sqm_per_box 		= $('#sqm_per_box'+val).val();
		var boxes_per_pallet 		= $('#boxes_per_pallet'+val).val();
	 	if($('#no_of_pallet'+val).val() != undefined && $('#no_of_pallet'+val).val() != "" )
		{
			var no_of_pallet 			= $('#no_of_pallet'+val).val();
		 	var no_of_boxes 			= $('#no_of_pallet'+val).val() * boxes_per_pallet;
		 	$('#no_of_boxes'+val).val(no_of_boxes.toFixed(2));
			var no_of_sqm 				= no_of_boxes * sqm_per_box;
			$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
			$('#sqm_html'+val).html(no_of_sqm.toFixed(2));
		}
	 }
	 else if(radioValue==2)
	 {
		 var weight_per_box = $('#weight_per_box'+val).val();
		 var sqm_per_box 	= $('#sqm_per_box'+val).val();
		  
		 
			if($('#only_no_of_boxes'+val).val() != undefined && $('#only_no_of_boxes'+val).val() != "")
			{
				var no_of_boxes = $("#only_no_of_boxes"+val).val();
				var rate_usd_val = $('#product_rate'+val).val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				var product_total_amount = rate_usd_val * no_of_sqm;
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(packing_net_weight);
			 	$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
	 	 	}
	 } 
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box'+val).val();
		 var box_per_big_pallet 	= $('#box_per_big_pallet'+val).val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet'+val).val();
		 var big_pallet_weight 		= $('#big_pallet_weight'+val).val();
		 var small_pallet_weight 	= $('#small_pallet_weight'+val).val();
		 var sqm_per_box = $('#sqm_per_box'+val).val();
		 
		 	if($('#no_of_big_pallet'+val).val() != undefined && $('#no_of_big_pallet'+val).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+val).val();
				var no_of_big_pallet = $('#no_of_big_pallet'+val).val();
				var no_of_small_pallet = $('#no_of_small_pallet'+val).val();
				
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+val).val(no_of_boxes.toFixed(2));
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
				
				var product_total_amount = rate_usd_val * no_of_sqm;
				
				$('#product_amt'+val).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				
				var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+val).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+val).val(packing_gross_weight.toFixed(2));
		 	}
	  }
}
function cal_box_invoice(val,no)
{
	
	var radioValue = $("#pallet_status"+val).val();
    var sqm_per_box = $('#sqm_per_box'+val).val();
  		
	 if(radioValue==1)
	 {
		 if(no == 2)
		 {
			 var no_of_pallet 	= $('#no_of_pallet'+val).val();
			 var boxes_per_pallet 	= $('#boxes_per_pallet'+val).val();
			 $('#no_of_boxes'+val).val(parseFloat(no_of_pallet * boxes_per_pallet));
		 }			 
		var no_of_boxes = $('#no_of_boxes'+val).val();
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		$('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
	 }
	  if(radioValue==2)
	 {
		  
		var no_of_boxes = $('#no_of_boxes'+val).val();
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		$('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
	 }
	 else if(radioValue==3)
	 {
		 if(no == 2)
		 {
			var big_pallet 	= $('#no_of_big_pallet'+val).val();
			var small_pallet 	= $('#no_of_small_pallet'+val).val();
			var box_per_big_pallet = $('#box_per_big_pallet'+val).val();
			var box_per_small_pallet = $('#box_per_small_pallet'+val).val();
 
			$('#no_of_boxes'+val).val(parseFloat(big_pallet * box_per_big_pallet) + parseFloat(small_pallet * box_per_small_pallet));
		 }
		var no_of_boxes = $('#no_of_boxes'+val).val();
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		$('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
		
		 
	 }
}
function delete_loading(con_entry,performa_invoice_id)
{
		Swal.fire({
  title: 'You want to Delete?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, confirm it!'
}).then((result) => {
		 if (result.value) {
			safeBlock();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/deleteloading',
              data: {
                "con_entry": con_entry,
                "performa_invoice_id": performa_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	safeUnblock('success',"Producation Sucessfully deleted.");
						setTimeout(function(){ location.reload(); },1000); 
				}
                else{
					safeUnblock('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
}

function copy_containter(performa_invoice_id)
{
	var performa_packing_id = [];
	var performa_trn_id 	= [];
	 
   $('input[name="copy_make_container[]"]').each(function() {
        if ($(this).is(":checked")) {
             performa_packing_id.push($(this).val());
			performa_trn_id.push($("#performa_trn_id"+$(this).val()).val());
	    }
    });
	 if(performa_packing_id == "" || performa_packing_id == null)
	 {
		 safeUnblock('error',"Please select atlest 1 design");
		 return false;
	 }
	safeBlock();
	$.ajax({ 
             type: "POST", 
             url: root+'create_producation/copy_containter',
             data: {
               "performa_packing_id"	: performa_packing_id,
               "performa_trn_id" 		: performa_trn_id, 
               "performa_invoice_id"	: performa_invoice_id 
             }, 
             cache: false, 
             success: function (data)
			 { 
					$("#excelModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#set_container_detail").html(data);
					safeUnblock('',"")
             }
			});
}
 
$("#product_add").validate({
		rules: {
			product_id: {
				required: true
			},
			design_id: {
				required: true
			}
		},
		messages: {
			product_id: {
				required: "Select Product"
			},
			design_id: {
				required: "Select Design"
			} 
		}
	});
$("#product_add").submit(function(event) {
	event.preventDefault();
	if(!$("#product_add").valid())
	{
		return false;
	}
	 
	safeBlock();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url:  root+'create_pi_loading/add_product',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    
				 $("#product_add").trigger('reset');
				 $("#product_id").val('').trigger('change');
				 $("#packing_id").val('').trigger('change');
				 $("#packing_id").val('').trigger('change');
		 		 $("#productmodal").modal('hide');
				 edit_loading($("#new_conentry").val(),$("#pinvoice_id").val(),$("#new_supplierid").val())  
				safeUnblock("success","Sucessfully Inserted.");
			   
		    },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function load_packing(product_id)
{
	safeBlock();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/load_packing',
              data: {
                "product_id" : product_id 
              }, 
              cache: false, 
              success: function (data) { 
				   $("#packing_id").html(data);
						safeUnblock('',"")
              }
			});
}

</script>