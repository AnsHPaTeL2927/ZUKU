<?php $this->view('lib/header');?>

<div class="main-container">
  <?php $this->view('lib/sidebar'); ?>
  <div class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li> <i class="clip-pencil"></i> <a href="<?=base_url()?>dashboard"> Dashboard </a> </li>
            <li class="active"> <a href="<?=base_url()?>assign_producation">Loading plan</a> </li>
            <li class="active"> Create loading plan </li>
          </ol>
          <div class="page-header title1">
            <h3>Create loading plan </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> <a href="<?=base_url()?>assign_producation">Assign Producation</a> </div>
            <div class="">
              <div class="col-md-4" style="padding:5px;"> <a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Print Company Wise" href="javascript:;" onclick="company_wise_print(<?=$invoicedata->performa_invoice_id?>);" data-original-title="" title=""> Print Company Wise </a> </div>
              <div class="pull-right set_container_btn" style="padding:5px;display:none"> <a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Add Container Detail " href="<?=base_url().'create_pi_loading/container_details/'.$invoicedata->performa_invoice_id.'/0'?>"  data-original-title="" title=""> Add Container Detail </a> </div>
              <div class="col-md-12" style="padding:5px;"> </div>
              <div class="pull-right" style="padding:5px;">
                <h4> Order Container 		:
                  <?=$invoicedata->container_details?>
                  <br>
                  <br>
                  Export Done Container 	:
                  <?=!empty($invoicedata->export_done_con)?$invoicedata->export_done_con:0?>
                  <br>
                  <br>
                  <span id="html_setcontainer"></span> <br>
                  <br>
                  <span id="html_container"></span></h4>
              </div>
              <div class="panel-body form-body">
                <div class="col-md-12">
                  <h4>Already Set Container</h4>
                  <table class="table table-bordered table-hover" id="sample-table-1" style="width:100%;">
                    <thead>
                      <tr>
                        <th class="text-center" width="10%">Company Name</th>
                        <th class="text-center" width="10%">Size In MM</th>
                        <th class="text-center" width="15%">Design Name</th>
                        <th class="text-center" width="10%">Finish Name</th>
                        <th class="text-center" width="10%">Pallet</th>
                        <th class="text-center" width="10%">Boxes</th>
                        <th class="text-center" width="10%">Unit</th>
                        <th class="text-center" width="10%">Quantity</th>
                        <th class="text-center" width="10%">Container</th>
                        <th class="text-center" width="5%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
										   	$Total_plts = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$setcontainer = !empty($invoicedata->export_done_con)?$invoicedata->export_done_con:0;
											$packingtrn_array = array();
											$packingtrn_array1 = array();
											$con_entry = 1;
											$con_no = 1;
											$co_array = array();
											$conarray = array();
											$doneconarray = array();
											$sup_con = array();
											$record_no_found = '';
											if(!empty($set_container))
											{		
											for($i=0; $i<count($set_container);$i++)
											{
												 
												$con_no = $set_container[$i]->con_entry + 1;
												if(!in_array($set_container[$i]->autometic_loading_plan_id,$packingtrn_array))
												{
													array_push($packingtrn_array,$set_container[$i]->autometic_loading_plan_id);
													$packingtrnarray[$set_container[$i]->autometic_loading_plan_id] = array();
													$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['autometic_loading_plan_id']  = $set_container[$i]->autometic_loading_plan_id;
													
													$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_boxes']  =$set_container[$i]->origanal_boxes;
												 
													$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_sqm']  =($set_container[$i]->origanal_sqm);
													
													 
													$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_pallet']  = $set_container[$i]->origanal_pallet;;
													$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;;
													$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_small_pallet']  = $set_container[$i]->orginal_no_of_small_pallet;;
												}
												else
												{
													 $packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
													
													 $packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_sqm']  +=($set_container[$i]->origanal_sqm);
													 
													 
													 $packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
													 $packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
													 $packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
												}
												if(!in_array($set_container[$i]->production_trn_id,$packingtrn_array1))
												{
													array_push($packingtrn_array1,$set_container[$i]->production_trn_id);
													$packingtrnarray1[$set_container[$i]->production_trn_id] = array();
													$packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_boxes']  =$set_container[$i]->origanal_boxes;
												 
													$packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_sqm']  =($set_container[$i]->origanal_sqm);
													
													 
													$packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_pallet']  = $set_container[$i]->origanal_pallet;;
													$packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;;
													$packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_small_pallet']  = $set_container[$i]->orginal_no_of_small_pallet;;
													
												}
												else
												{
													 $packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
													
													 $packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_sqm']  +=($set_container[$i]->origanal_sqm);
													 
													 
													 $packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
													 $packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
													 $packingtrnarray1[$set_container[$i]->production_trn_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
												}
												if($set_container[$i]->export_done_status == 0)
												{
													$record_no_found = '1';
											 	?>
                      <tr>
                        <td class="text-center"><?=$set_container[$i]->company_name?></td>
                        <?php 
													 	if($set_container[$i]->product_id == 0)
														{
															 $qty =0;
															if($set_container[$i]->per == "SQM")
															{
																$qty = $set_container[$i]->origanal_sqm;
															}
															else if($set_container[$i]->per == "BOX")
															{
																$qty = $set_container[$i]->origanal_boxes;
																
															}
															else if($set_container[$i]->per == "SQF")
															{
																$qty = $set_container[$i]->origanal_boxes;
															}
															else if($set_container[$i]->per == "PCS")
															{
																$qty = $set_container[$i]->origanal_boxes;
															}
															?>
                        <td style="text-align:center" colspan="5"><?=$set_container[$i]->description_goods?></td>
                        <td style="text-align:center"  ><?=$set_container[$i]->per?></td>
                        <td style="text-align:center"  ><?=$qty?></td>
                        <?php
														}
														else
														{
															?>
                        <td class="text-center"><?=$set_container[$i]->size_type_mm?></td>
                        <td class="text-center"><?=$set_container[$i]->model_name?></td>
                        <td class="text-center"><?=$set_container[$i]->finish_name?></td>
                        <?php 
													if(!empty($set_container[$i]->make_pallet_no))
													{
															$pallet_ids = explode(",",$set_container[$i]->pallet_row);
														echo  '<td class="text-center" rowspan="'.count($pallet_ids).'">
																	'.$set_container[$i]->make_pallet_no.'     
																</td>';	
													}
													else if(!empty($set_container[$i]->production_mst_id) || empty($set_container[$i]->pallet_row))
													{
													?>
                        <td class="text-center"><?php 
														if($set_container[$i]->origanal_pallet>0)
														{
															$no_of_pallet =$set_container[$i]->origanal_pallet;
														 	echo $no_of_pallet;
															
														}
														else if($set_container[$i]->orginal_no_of_big_pallet>0 || $set_container[$i]->orginal_no_of_small_pallet>0)
														{
															echo $set_container[$i]->orginal_no_of_big_pallet.'<br>';
															echo $set_container[$i]->orginal_no_of_small_pallet;
														}
														?></td>
                        <?php 
													}
													?>
                        <td class="text-center"><?=$set_container[$i]->origanal_boxes?></td>
                        <td class="text-center"> - </td>
                        <td class="text-center"> - </td>
                        <?php
														}						
													
													
													if(!in_array($set_container[$i]->con_entry,$conarray))
													{
														$setcontainer += $set_container[$i]->container;
														
														 
													 	if(!in_array($set_container[$i]->supplier_id.$set_container[$i]->production_mst_id,$sup_con))
														{
															array_push($sup_con,$set_container[$i]->supplier_id.$set_container[$i]->production_mst_id);
															$doneconarray[$set_container[$i]->supplier_id.$set_container[$i]->production_mst_id] = array();
															$doneconarray[$set_container[$i]->supplier_id.$set_container[$i]->production_mst_id]['con'] =  $set_container[$i]->container; 
														}
														else
														{
															$doneconarray[$set_container[$i]->supplier_id.$set_container[$i]->production_mst_id]['con'] +=  $set_container[$i]->container; 
														}
													?>
                        <td class="text-center" rowspan="<?=($set_container[$i]->rowcon_no > 0)?$set_container[$i]->rowcon_no:""?>"><?=$set_container[$i]->container?></td>
                        <td class="text-center" rowspan="<?=($set_container[$i]->rowcon_no > 0)?$set_container[$i]->rowcon_no:""?>"><?php
														if(empty($set_container[$i]->container_no))
														{
															?>
                          <a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit"  onclick="edit_loading(<?=$set_container[$i]->con_entry?>,<?=$set_container[$i]->performa_invoice_id?>,<?=$set_container[$i]->supplier_id?>)" href="javascript:;" ><i class="fa fa-pencil"></i></a> <a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Detele"  onclick="delete_loading(<?=$set_container[$i]->con_entry?>,<?=$set_container[$i]->performa_invoice_id?>)" href="javascript:;" ><i class="fa fa-trash"></i></a>
                          <?php
														}
														?></td>
                        <?php 
													 	array_push($conarray,$set_container[$i]->con_entry);
												 	}
													?>
                      </tr>
                      <?php
											    $no++;
												}
											}
											}
											 
											if(empty($record_no_found))
											{
												echo "<tr>
														<td  class='text-center' colspan='15'>Container Not set</td>
														</tr>";
											}
												
												?>
                    </tbody>
                  </table>
                  <?php 
		 $same_container_number = array();
		$same_container_number1 = array();
		$producation_id_array = array();
		
		if($setcontainer < intval($invoicedata->container_details))
		{
		if(!empty($auto_loading_plan))
		{
		?>
                  <div class="col-md-12">
                    <h4> Set Container
                      <div class="pull-right form-group"> <a class="tooltips btn btn-primary" href="javascript:;" onclick="set_all_containter(<?=$invoicedata->performa_invoice_id?>);" data-original-title="" title=""> Set All Container </a> </div>
                    </h4>
                    <div class="col-md-12"></div>
                    <?php 
		
			 $total_display = $invoicedata->container_details - $setcontainer;
			 $t = 0;
			
				foreach($auto_loading_plan as $detail)
				{
					
					
					
					if($packingtrnarray[$detail->autometic_loading_plan_id]['autometic_loading_plan_id'] != $detail->autometic_loading_plan_id)
					{
						 array_push($producation_id_array,$detail->production_trn_id);
						 // $finalpallets = $detail->boxcalpallet + $detail->boxcalbigpallet + $detail->boxcalsmallpallet;
						 // $finalboxes = $detail->boxcal * $finalpallets;
						
						 
						// $remaining_box = $detail->total_input_boxes - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_boxes'];

						// $remaining_pallet = $detail->total_input_pallets - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_pallet'];
						// $remaining_big_pallet = $detail->total_input_big_pallets - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_big_pallet'];
						// $remaining_small_pallet = $detail->total_input_small_pallets - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_small_pallet'];
						
						$remaining_box = $detail->no_of_boxes - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_boxes'];
						$remaining_pallet = $detail->no_of_pallet - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_pallet'];
						$remaining_big_pallet = $detail->no_of_big_pallet - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_big_pallet'];
						$remaining_small_pallet = $detail->no_of_small_pallet - $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_small_pallet'];
						
						 
						
						if(!in_array($detail->container_no,$same_container_number))
						{
							$show = 1;
						 
		  ?>
                    <div class="span4 col-md-4">
                      <div class="panel panel-default">
                        <div class="panel-heading"> <strong>Container
                          <?=$con_no?>
                          , Container Size :
                          <?=$detail->container_size?>
                          </strong> </div>
                        <div class="panel-body panel-height" style="min-height:345px;">
                          <?php
		 
						if($detail->total_con > 1)
						{
							$show = $show + $detail->total_con;
							
						}
						array_push($same_container_number,$detail->container_no);
					}
					else
					{
						$show--;
						echo  "<hr style='border:1px solid #eee'>";
					}						
					
						
					 
		
		?>
                          <div class="text-center">
                            <p style="margin: 0 auto;width:50px;height:50px;overflow:hidden;position: relative;"> <img src="<?=(!empty($detail->design_file))?DESIGN_PATH.$detail->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:60px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;"/> </p>
                          </div>
                          <br>
                          <div style="min-height:175px;">
                            <label class="col-sm-6 control-label "> <strong>Factory </strong> </label>
                            <label class="col-sm-6 control-label ">
                              <?=$detail->company_name?>
                            </label>
                            <label class="col-sm-6 control-label "> <strong>Size In MM </strong> </label>
                            <label class="col-sm-6 control-label">
                              <?=$detail->size_type_mm?>
                            </label>
                            <label class="col-sm-6 control-label"> <strong>Design Name </strong> </label>
                            <label class="col-sm-6 control-label">
                              <?=$detail->model_name?>
                            </label>
                            <label class="col-sm-6 control-label"> <strong> Finish </strong> </label>
                            <label class="col-sm-6 control-label">
                              <?=$detail->finish_name?>
                            </label>
                            <?php
			if($detail->no_of_pallet > 0)
			{
			?>
                            <label class="col-sm-6 control-label"> <strong>Pallet </strong> </label>
                            <label class="col-sm-6 control-label">
                              <input type="text" name="no_of_pallet<?=$detail->container_no?>[]" id="no_of_pallet<?=$detail->autometic_loading_plan_id?>" value="<?=$remaining_pallet?>"  onkeyup="cal_product_invoice(<?=$detail->autometic_loading_plan_id?>)"  onblur="cal_product_invoice(<?=$detail->autometic_loading_plan_id?>)" />
                            </label>
                            <?php 
			
			}
			 			
			if($detail->no_of_big_pallet > 0)
			{
			?>
                            <label class="col-sm-6 control-label"> <strong>Big Pallet </strong> </label>
                            <label class="col-sm-6 control-label">
                              <input type="text" name="no_of_big_pallet<?=$detail->container_no?>[]" id="no_of_big_pallet<?=$detail->autometic_loading_plan_id?>" value="<?=$remaining_big_pallet?>"  onkeyup="cal_product_invoice(<?=$detail->autometic_loading_plan_id?>)"  onblur="cal_product_invoice(<?=$detail->autometic_loading_plan_id?>)" />
                            </label>
                            <?php 
		 	}
		 	if($detail->no_of_small_pallet > 0)
			{
			?>
                            <label class="col-sm-6 control-label"> <strong>Small Pallet </strong> </label>
                            <label class="col-sm-6 control-label">
                              <input type="text" name="no_of_small_pallet<?=$detail->container_no?>[]" id="no_of_small_pallet<?=$detail->autometic_loading_plan_id?>" value="<?=$remaining_small_pallet?>"  onkeyup="cal_product_invoice(<?=$detail->autometic_loading_plan_id?>)"  onblur="cal_product_invoice(<?=$detail->autometic_loading_plan_id?>)" />
                            </label>
                            <?php 
			
			}
			?>
                            <label class="col-sm-6 control-label"> <strong>Boxes  </strong> </label>
                            <label class="col-sm-6 control-label">
                              <input type="text" name="no_of_boxes<?=$detail->container_no?>[]" id="no_of_boxes<?=$detail->autometic_loading_plan_id?>" value="<?=$remaining_box?>"   />
                            </label>
                            <label class="col-sm-6 control-label"> <strong>Batch No </strong> </label>
                            <label class="col-sm-6 control-label">
                              <input type="text" name="batch_no<?=$detail->container_no?>[]" id="batch_no<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->pro_batch?>" placeholder="Batch No" />
                            </label>
                            <label class="col-sm-6 control-label"> <strong>Shade No </strong> </label>
                            <label class="col-sm-6 control-label">
                              <input type="text" name="shade_no<?=$detail->container_no?>[]" id="shade_no<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->pro_shade?>" placeholder="Shade No" />
                            </label>
							<!--<label class="col-sm-6 control-label"> <strong>Location</strong> </label>
                            <label class="col-sm-6 control-label">
                              <input type="text" name="location_name<?=$detail->container_no?>[]" id="location_name<?=$detail->autometic_loading_plan_id?>" value="" placeholder="Location" />
                            </label>-->
                          </div>
                          <input type="hidden" name="performa_packing_id<?=$detail->container_no?>[]" id="performa_packing_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->performa_packing_id?>" />
                          <input type="hidden" name="product_id<?=$detail->container_no?>[]" id="product_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->product_id?>" />
                          <input type="hidden" name="con_no<?=$detail->container_no?>[]" id="con_no<?=$detail->autometic_loading_plan_id?>" value="<?=$con_no?>" />
                          <input type="hidden" name="container_size<?=$detail->container_no?>[]" id="container_size<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->container_size?>" />
                          <input type="hidden" name="supplier_id<?=$detail->container_no?>[]" id="supplier_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->supplier_id?>" />
                          <input type="hidden" name="performa_trn_id<?=$detail->container_no?>[]" id="performa_trn_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->performa_trn_id?>" />
                          <input type="hidden" name="production_trn_id<?=$detail->container_no?>[]" id="production_trn_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->production_trn_id?>" />
                          <input type="hidden" name="performainvoice_id<?=$detail->container_no?>[]" id="performainvoice_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->performa_invoice_id?>" />
                          <input type="hidden" name="production_mst_id<?=$detail->container_no?>[]" id="production_mst_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->production_mst_id?>" />
                          <input type="hidden" name="autometic_loading_plan_id<?=$detail->container_no?>[]" id="autometic_loading_plan_id<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->autometic_loading_plan_id?>" />
                          <input type="hidden" name="pallet_status<?=$detail->container_no?>[]" id="pallet_status<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->pallet_status?>" />
                          <input type="hidden" name="sqm_per_box<?=$detail->container_no?>[]" id="sqm_per_box<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->sqm_per_box?>" />
                          <input type="hidden" name="no_of_sqm<?=$detail->container_no?>[]" id="no_of_sqm<?=$detail->autometic_loading_plan_id?>" value="<?=($detail->sqm_per_box * $remaining_box)?>" />
                          <input type="hidden" name="boxes_per_pallet<?=$detail->container_no?>[]" id="boxes_per_pallet<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->boxes_per_pallet?>" />
                          <input type="hidden" name="box_per_big_pallet<?=$detail->container_no?>[]" id="box_per_big_pallet<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->box_per_big_pallet?>" />
                          <input type="hidden" name="box_per_small_pallet<?=$detail->container_no?>[]" id="box_per_small_pallet<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->box_per_small_pallet?>" />
                          <input type="hidden" name="big_pallet_weight<?=$detail->container_no?>[]" id="big_pallet_weight<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->big_pallet_weight?>" />
                          <input type="hidden" name="small_pallet_weight<?=$detail->container_no?>[]" id="small_pallet_weight<?=$detail->autometic_loading_plan_id?>" value="<?=$detail->small_pallet_weight?>" />
                          <?php 
					$con_no++;
					if($show == 1)
					{
				 ?>
                          <div class="text-center"> <br>
                            <a class="tooltips btn btn-primary"  href="javascript:;" onclick="set_one_by_one_container(<?=$detail->container_no?>);"  > Set This Container</a> <a class="tooltips btn btn-info"  href="javascript:;" onclick="change_full_status(<?=$detail->autometic_loading_plan_id?>);">Move For Half Container</a> </div>
                        </div>
                      </div>
                    </div>
                    <?php 
						}
						else
						{
							$show--;
						}
				
						$t++;	
					}				
			}
		 
		 
		
		?>
                    <input type="hidden" name="all_container" id="all_container" value="<?=implode(",",$same_container_number)?>"/>
                  </div>
                  <?php 
		}
	if(!empty($producationdata))
   {
	?>
                  <hr>
                  <div class="col-md-12 miss_match_html">
                    <h4> Please Make Container </h4>
                    <table class="table table-bordered table-hover display" width="100%">
                      <thead>
                        <tr>
                          <th style="text-align:center">SR No</th>
                          <th style="text-align:center" colspan="3">Company Name</th>
                          <th style="text-align:center" colspan="3">No Of Container</th>
                          <th style="text-align:center" colspan="4">Remaning Container</th>
                          <th style="text-align:center" colspan="2">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
									 		$sr =1;
											$total_con= 0;
											$half_con_button = '';
											$supplier_id_array = array();
										 	foreach($producationdata as $row)
											{
												if($row->no_of_countainer > 0)
												{	
													$remaining_container = ($row->no_of_countainer - $doneconarray[$row->supplier_id.$row->production_mst_id]['con']);
													 
													 if($remaining_container > 0 || $row->no_of_countainer < 1)
													 {
												 	?>
                        <tr class="sup<?=$row->supplier_id.$packing->autometic_loading_plan_id?>" >
                          <td style="text-align:center"><?=$sr?></td>
                          <td style="text-align:center" colspan="3"><?=$row->company_name?></td>
                          <td style="text-align:center"><?=number_format($row->no_of_countainer,2)?></td>
                          <td style="text-align:center" colspan="2"><?=($row->no_of_countainer < 1)?'':number_format($remaining_container,2)?></td>
                          <td style="text-align:center" colspan="2"><?php 
															if($remaining_container > 0)
															{		
															?>
                            <a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Set One By One Container" href="javascript:;" onclick="copy_containter(<?=$row->production_mst_id?>,'<?=$row->company_name?>',<?=$row->supplier_id?>,1);"> + Set One By One Container </a>
                            <?php
																if($remaining_container < 1)
																{
																	$half_con_button = 'show';
																}
															}
															else if($remaining_container < 1)
															{
																$half_con_button = 'show';
															}
														 	?></td>
                        </tr>
                        <tr class="sup<?=$row->supplier_id.$packing->autometic_loading_plan_id?>">
                          <th style="text-align:center;width:3%"> </th>
                          <th style="text-align:center;width:8%">Design Name</th>
                          <th style="text-align:center;width:8%">Finish</th>
                          <th style="text-align:center;width:8%">SIZE IN MM</th>
                          <th style="text-align:center;width:8%">Thickness</th>
                          <th style="text-align:center;width:12%">IMAGES </th>
                          <th style="text-align:center;width:5%">Plts</th>
                          <th style="text-align:center;width:5%">Boxes</th>
                          <th style="text-align:center;width:5%">SQM</th>
                          <th style="text-align:center;width:5%">Unit</th>
                          <th style="text-align:center;width:7%">Quantity</th>
                          <th style="text-align:center;width:7%">Remaning Plts</th>
                          <th style="text-align:center;width:7%">Remaning Boxes</th>
                          <th style="text-align:center;width:7%">Remaning Quantity</th>
                        </tr>
                        <?php
 										
													if(empty($row->production_trn))
													{
														echo "<script> document.getElementsByClassName('sup".$row->supplier_id.$packing->autometic_loading_plan_id."')[0].style.display = 'none';  </script>";
														echo "<script> document.getElementsByClassName('sup".$row->supplier_id.$packing->autometic_loading_plan_id."')[1].style.display = 'none';  </script>";
													}
													else
													{
													foreach($row->production_trn as $packing)
													{
														
														 if(!in_array($packing->production_trn_id,$producation_id_array))
														{
															$remaining_boxes = ($packing->no_of_boxes - $packingtrnarray1[$packing->production_trn_id]["no_of_boxes"]);
															 
															$remaining_sqm = ($packing->no_of_sqm - $packingtrnarray1[$packing->production_trn_id]["no_of_sqm"]);
														 
														 
														if($remaining_boxes > 0 && $packing->production_trn_id > 0 || $remaining_sqm > 0) 
														 {
															
														?>
                        <tr>
                          <td style="text-align:center"><input type="checkbox" name="copy_make_container<?=$row->supplier_id?>[]" id="copy_make_container<?=$packing->production_trn_id?>" value="<?=$packing->production_trn_id?>" class="form-control"/>
                            <input type="hidden" name="remaining_container<?=$row->supplier_id?>[]" id="remaining_container<?=$packing->production_trn_id?>" value="<?=$remaining_container?>" class="form-control"/>
                            <input type="hidden" name="autometic_loading_plan_id<?=$row->supplier_id?>[]" id="autometic_loading_plan_id<?=$packing->production_trn_id?>" value="<?=$packing->autometic_loading_plan_id?>" class="form-control"/>
                            <input type="hidden" name="supplier_id[]" id="autometic_loading_plan_id<?=$packing->production_trn_id?>" value="<?=$row->supplier_id?>" class="form-control"/></td>
                          <?php 
														
														if($packing->product_id == 0)
														{
															$qty =0;
															$remaing_qty =0;
															 
															if($packing->per == "SQM")
															{
																$qty = $packing->no_of_sqm;
																$remaing_qty = $qty - $packingtrnarray[$packing->autometic_loading_plan_id]["no_of_sqm"];
																 
															}
															else if($packing->per == "BOX")
															{
																$qty = $packing->no_of_boxes;
																 
															 	$remaing_qty = $qty - $packingtrnarray[$packing->autometic_loading_plan_id]["no_of_boxes"];
														 	}
															else if($packing->per == "SQF")
															{
																$qty = ($packing->no_of_boxes);
																 
																$remaing_qty = $qty - $packingtrnarray[$packing->autometic_loading_plan_id]["no_of_boxes"];
															}
															else if($packing->per == "PCS")
															{
																$qty = ($packing->no_of_boxes);
																 
																$remaing_qty = $qty - $packingtrnarray[$packing->autometic_loading_plan_id]["no_of_boxes"];
															}
															?>
                          <td style="text-align:center" colspan="3"><?=$packing->description_goods?></td>
                            </td>
                          <td style="text-align:center"><?=$packing->thickness?></td>
                          <td style="text-align:center"><img src="<?=DESIGN_PATH.$packing->other_image?>"  height="80px" width="80px" style="border: 1px solid;"></td>
                          <td style="text-align:center"> - </td>
                          <td style="text-align:center"> - </td>
                          <td style="text-align:center"> - </td>
                          <td style="text-align:center"><?=$packing->per?></td>
                          <td style="text-align:center"><?=$qty?></td>
                          <td style="text-align:center"> - </td>
                          <td style="text-align:center"> - </td>
                          <td style="text-align:center"><?=$remaing_qty?></td>
                          <?php
														}
														else
														{
															?>
                          <td style="text-align:center"><?=$packing->model_name?></td>
                          <td style="text-align:center"><?=$packing->finish_name?></td>
                          <td style="text-align:center"><?=$packing->size_type_cm?></td>
                          <td style="text-align:center"><?=$packing->product_thickness?>
                            MM </td>
                          <td style="text-align:center"><p style="margin: 0 auto;width:50px;height:50px;overflow:hidden;position: relative;"> <img src="<?=(!empty($packing->design_file))?DESIGN_PATH.$packing->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:60px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;"/> </p></td>
                          <?php
																if($packing->no_of_pallet>0)
																{
																?>
                          <td style="text-align:center"><?=$packing->no_of_pallet?></td>
                          <?php
																}
																else if($packing->no_of_big_pallet>0 || $packing->no_of_small_pallet>0)
																{
																?>
                          <td style="text-align:center"><?=$packing->no_of_big_pallet?>
                            <br>
                            <?=$packing->no_of_small_pallet?></td>
                          <?php
																	}
																	else
																	{
																		echo "<td style='text-align:center'> - </td>";
																	}
																	?>
                          <td style="text-align:center"><?=$packing->total_input_boxes?></td>
                          <td style="text-align:center"><?=$packing->no_of_sqm?></td>
                          <td style="text-align:center"> - </td>
                          <td style="text-align:center"> - </td>
                          <td style="text-align:center"><?php
															
																if($packingtrnarray1[$packing->production_trn_id]["no_of_pallet"] > 0)
																{
																	echo ($packing->no_of_pallet - $packingtrnarray1[$packing->production_trn_id]["no_of_pallet"]);
																}
																else if($packingtrnarray1[$packing->production_trn_id]["no_of_big_pallet"] > 0 || $packingtrnarray1[$packing->production_trn_id]["no_of_small_pallet"] >0)
																{
																	
																	echo ($packing->no_of_big_pallet - $packingtrnarray1[$packing->production_trn_id]["no_of_big_pallet"]).'<br>';
																	echo ($packing->no_of_small_pallet	 - $packingtrnarray1[$packing->production_trn_id]["no_of_small_pallet"]);
																}
																else if($packing->no_of_pallet > 0)
																{
																	echo $packing->no_of_pallet;
																}
																else if($packing->no_of_big_pallet > 0 || $packing->no_of_small_pallet >0)
																{
																	echo $packing->no_of_big_pallet.'<br>';
																	echo $packing->no_of_small_pallet;
																}
																?></td>
                          <td style="text-align:center"><?=($packing->no_of_boxes - $packingtrnarray1[$packing->production_trn_id]["no_of_boxes"])?></td>
                          <td style="text-align:center"> - </td>
                          <?php
														}
																?>
                        </tr>
                        <?php
														 }
														  
														}
													}
														
													$total_con += $row->no_of_countainer;
												 
													$sr++;
													}
												}
												}
												}
												if(!empty($half_con_button) || empty($half_con_button))
												{
												?>
                      <a style="margin-bottom: 11px;" class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Make Multiple Suppiler Container" href="javascript:;" onclick="copy_multiple_containter();"> + Set One By One Multiple Suppiler Container </a> <br>
                      <?php
												 
												 
												}
											  	 			
											?>
                        </tbody>
                      
                    </table>
                  </div>
                  <?php
												}
									}		 
											  	 			
											?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="excelModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:1122px"> 
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
        <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Set  Container </h4>
      </div>
      <form class="form-horizontal askform" action="javascript:;"  method="post" name="wallproduct_form" id="wallproduct_form">
        <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
          <div class="row">
            <input type="hidden" id="performainvoice_id" name="performainvoice_id" value="<?=$invoicedata->performa_invoice_id?>">
            <input type="hidden" id="con_entry" name="con_entry" value="<?=($con_no)?>">
            <input type="hidden" name="con_no" id="con_no" value="<?=($con_no)?>" class="form-control" readonly>
            <div class="col-md-12 product_html">
              <div class="col-md-6 field-group">
                <label class="col-md-4 control-label "><strong class="">Container Size</strong></label>
                <div class="col-md-8">
                  <label class="radio-inline">
                    <input type="radio" checked name="container_size" id="container_size1" value="20"  />
                    20 </label>
                  <label class="radio-inline">
                    <input type="radio" name="container_size" id="container_size2" value="40" <?=$checked1?> />
                    40 </label>
                </div>
              </div>
            </div>
            <div class="col-md-12" id="set_container_detail"> </div>
          </div>
        </div>
        <div class="modal-footer">
          <input name="Submit" type="submit" value="Submit" id="submit_btn" class="btn btn-success"  />
          <button type="button" onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <input type="hidden" name="mode" id="mode" />
      </form>
    </div>
  </div>
</div>
<div id="printModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:1122px"> 
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
        <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Company Wise Print </h4>
      </div>
      <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
        <div class="row">
          <div class="col-md-12" id="company_wise_html"> </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php $this->view('lib/footer'); ?>
<script>
function set_auto_loading_plan(performa_invoice_id)
{
	block_page();
	 $.ajax({ 
           type: "POST", 
           url: root+'create_pi_loading/set_auto_loading_plan',
           data: {
             "performa_invoice_id"	: performa_invoice_id 
           }, 
           cache: false, 
           success: function (data) { 
				location.reload();
				unblock_page('',"")
           }
	 });
}
function change_full_status(autometic_loading_plan_id)
{
	Swal.fire({
		title: 'Are you sure?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, Do it!'
	}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/change_full_status',
              data: {
                   "autometic_loading_plan_id"	: autometic_loading_plan_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Record Update Successfully");
					location.reload();
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
	
}
function show_btn()
{
	$(".set_container_btn").show();
}
</script>
<?php 
//var_dump($auto_loading_plan);
//var_dump($notauto_loading_plan);
if(empty($notauto_loading_plan))
{ 
	echo "<script>set_auto_loading_plan(".$invoicedata->performa_invoice_id.")</script>";
}
if(!empty($setcontainer))
{ 
	echo "<script>show_btn()</script>";
}
?>
<script>

var used_container = <?=$setcontainer?>;
var pending_container = parseFloat(<?=$invoicedata->container_details?>) - <?=$setcontainer?>;
$("#html_setcontainer").html("Set Container : "+used_container);
$("#html_container").html("Pending Of Container : "+pending_container);
if(pending_container ==0)
{
	$(".miss_match_html").hide();
}
function copy_containter(production_mst_id,company_name,supplier_id,container)
{
		var production_trn_id 			= [];
		var autometic_loading_plan_id 	= [];
			$('input[name="copy_make_container'+supplier_id+'[]"]').each(function() {
			 if ($(this).is(":checked")) 
			 {
				production_trn_id.push($(this).val());
			 	autometic_loading_plan_id.push($("#autometic_loading_plan_id"+$(this).val()).val());
		 	 }
		});
	 	if(production_trn_id == "" || production_trn_id == null)
		{
			unblock_page('error',"Please select atlest 1 design");
			return false;
		}
	 
	 block_page();
	 
	$.ajax({ 
             type: "POST", 
             url: root+'create_pi_loading/copy_containter',
             data: {
               "production_mst_id"			: production_mst_id, 
               "autometic_loading_plan_id"	: autometic_loading_plan_id, 
			   "company_name"				: company_name,
			   "supplier_id"				: supplier_id,
			   "container"					: container,
			   "performa_invoice_id" 		: <?=$invoicedata->performa_invoice_id?>,
               "production_trn_id"			: production_trn_id 
             }, 
             cache: false, 
             success: function (data)
			 { 
					$("#excelModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#mode").val('add');
					$("#set_container_detail").html(data);
					 
					unblock_page('',"")
             }
			});
}
function copy_multiple_containter()
{
	var production_trn_id 	= [];
	var remaining_container = {};
	 
	 $('input[name="supplier_id[]"]').each(function() {
		  
		$('input[name="copy_make_container'+$(this).val()+'[]"]').each(function() {
			if ($(this).is(":checked")) {
             production_trn_id.push($(this).val());
			 remaining_container[$(this).val()] = $("#remaining_container"+$(this).val()).val();
             
			}
		});
    });
	 
	 if(production_trn_id == "" || production_trn_id == null)
	 {
		 unblock_page('error',"Please select atlest 1 design");
		 return false;
	 }
	  
	 block_page();
	 
	$.ajax({ 
             type: "POST", 
             url: root+'create_pi_loading/copy_multiple_containter',
             data: {
					"remaining_container"	: remaining_container, 
					"production_trn_id"		: production_trn_id,
					 "performa_invoice_id" : <?=$invoicedata->performa_invoice_id?>,
             }, 
             cache: false, 
             success: function (data)
			 { 
					$("#excelModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#mode").val('add');
					$("#set_container_detail").html(data);
					 
					unblock_page('',"")
             }
			});
}
$("#wallproduct_form").submit(function(event) {
	event.preventDefault();
	if(!$("#wallproduct_form").valid())
	{
		return false;
	}
 	 
	block_page();
	var postData= new FormData(this);
	$.ajax({
            type: "post",
            url:  root+'create_pi_loading/manual_manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				 
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ location.reload(); },1000);
		    },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function set_one_by_one_container(container_no)
{
	block_page();
	var performa_packing_id 				= [];
	var production_mst_id 					= [];
	var supplier_id		 					= [];
	var production_trn_id	 				= [];
	var performa_trn_id	 					= [];
	var performainvoice_id	 				= <?=$invoicedata->performa_invoice_id?>;
	var con_no	 							= [];
	var no_of_pallet	 					= [];
	var no_of_big_pallet	 				= [];
	var no_of_small_pallet	 				= [];
	var no_of_boxes			 				= [];
	var no_of_sqm			 				= [];
	var location_name			 				= [];
	var batch_no			 				= [];
	var shade_no			 				= [];
	var product_id			 				= [];
	var container_size						= [];
	var autometic_loading_plan_id			= [];
	 
	
	var c=1;
	 $('input[name^="performa_packing_id'+container_no+'[]"]').each(function() {
		 performa_packing_id.push($(this).val());
	});
	$('input[name^="production_mst_id'+container_no+'[]"]').each(function() {
		 production_mst_id.push($(this).val());
	});
	$('input[name^="supplier_id'+container_no+'[]"]').each(function() {
		 supplier_id.push($(this).val());
	});
	$('input[name^="production_trn_id'+container_no+'[]"]').each(function() {
		 production_trn_id.push($(this).val());
	});
	$('input[name^="performa_trn_id'+container_no+'[]"]').each(function() {
		 performa_trn_id.push($(this).val());
	});
	 
	$('input[name^="con_no'+container_no+'[]"]').each(function() {
		 con_no.push($(this).val());
	});
	$('input[name^="no_of_pallet'+container_no+'[]"]').each(function() {
		 no_of_pallet.push($(this).val());
	});
	$('input[name^="no_of_big_pallet'+container_no+'[]"]').each(function() {
		 no_of_big_pallet.push($(this).val());
	});
	$('input[name^="no_of_small_pallet'+container_no+'[]"]').each(function() {
		 no_of_small_pallet.push($(this).val());
	});
	$('input[name^="no_of_boxes'+container_no+'[]"]').each(function() {
		 no_of_boxes.push($(this).val());
	});
	$('input[name^="no_of_sqm'+container_no+'[]"]').each(function() {
		 no_of_sqm.push($(this).val());
	});
	$('input[name^="location_name'+container_no+'[]"]').each(function() {
		 location_name.push($(this).val());
	});$('input[name^="batch_no'+container_no+'[]"]').each(function() {
		 batch_no.push($(this).val());
	});
	$('input[name^="shade_no'+container_no+'[]"]').each(function() {
		 shade_no.push($(this).val());
	});
	$('input[name^="product_id'+container_no+'[]"]').each(function() {
		 product_id.push($(this).val());
	});
	$('input[name^="container_size'+container_no+'[]"]').each(function() {
		 container_size.push($(this).val());
	});
	$('input[name^="autometic_loading_plan_id'+container_no+'[]"]').each(function() {
		 autometic_loading_plan_id.push($(this).val());
	});
	 
	 
	$.ajax({
            type: "post",
            url:  root+'create_pi_loading/manage',
			data: {
               "performa_packing_id"	: performa_packing_id, 
			   "production_mst_id"		: production_mst_id,
			   "performa_trn_id"		: performa_trn_id,
			   "supplier_id"			: supplier_id,
			   "production_trn_id"		: production_trn_id,
               "no_of_pallet"			: no_of_pallet,
			   "no_of_big_pallet"		: no_of_big_pallet,
			   "no_of_small_pallet"		: no_of_small_pallet,
			   "no_of_boxes"			: no_of_boxes,
			   "no_of_sqm"				: no_of_sqm,
			   "con_no" 				: con_no,
			   "location_name" 			: location_name,
			   "batch_no" 				: batch_no,
			   "shade_no" 				: shade_no,
			   "performainvoice_id" 	: performainvoice_id,
			   "product_id"				: product_id, 
			   "autometic_loading_plan_id"			: autometic_loading_plan_id, 
			   "containersize"		: container_size 
             }, 
             cache: false, 
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				 
				   $("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ location.reload(); },1000);
		    },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
}
function all_checked(check,supplier_id)
{
		
 	if(check == true)
	{
		$("input[name='copy_make_container"+supplier_id+"[]']:checkbox").prop("checked",true);
	}
	else
	{
		$("input[name='copy_make_container"+supplier_id+"[]']:checkbox").prop("checked",false);
	}
}
function set_all_containter(performa_invoice_id)
{
	 
	block_page();
	var all_container = $("#all_container").val().split(",");
	
	 
	var con_no	 							= {};
	var no_of_pallet	 					= {};
	var no_of_big_pallet	 				= {};
	var no_of_small_pallet	 				= {};
	var no_of_boxes			 				= {};
	var no_of_sqm			 				= {};
	var location_name			 				= {};
	var batch_no			 				= {};
	var shade_no			 				= {};
	 
	 
	for(var c=0;c<all_container.length;c++)
	{
	       
		$('input[name^="con_no'+all_container[c]+'[]"]').each(function() {
			con_no[all_container[c]] = $(this).val(); 
		});   
		$('input[name^="no_of_pallet'+all_container[c]+'[]"]').each(function() {
			no_of_pallet[all_container[c]]  = $(this).val();
		});
		$('input[name^="no_of_big_pallet'+all_container[c]+'[]"]').each(function() {
			no_of_big_pallet[all_container[c]]  = $(this).val();
		});
		$('input[name^="no_of_small_pallet'+all_container[c]+'[]"]').each(function() {
			no_of_small_pallet[all_container[c]] = $(this).val();
		});
		$('input[name^="no_of_boxes'+all_container[c]+'[]"]').each(function() {
			no_of_boxes[all_container[c]]  =$(this).val();
		});
		$('input[name^="no_of_sqm'+all_container[c]+'[]"]').each(function() {
			no_of_sqm[all_container[c]]  =$(this).val();
		});
		$('input[name^="location_name'+all_container[c]+'[]"]').each(function() {
			location_name[all_container[c]]  =$(this).val();
		});
		$('input[name^="batch_no'+all_container[c]+'[]"]').each(function() {
			batch_no[all_container[c]]  =$(this).val();
		});
		$('input[name^="shade_no'+all_container[c]+'[]"]').each(function() {
			shade_no[all_container[c]]  = $(this).val();
		});
		 
 	}
	 
	$.ajax({ 
             type: "POST", 
             url: root+'create_pi_loading/manageall',
             data: {
               "con_no"					: con_no,
               "no_of_pallet"			: no_of_pallet,
               "no_of_big_pallet"		: no_of_big_pallet,
               "no_of_small_pallet"		: no_of_small_pallet,
               "no_of_boxes"			: no_of_boxes,
               "no_of_sqm"				: no_of_sqm,
               "location_name"				: location_name,
               "batch_no"				: batch_no,
               "shade_no"				: shade_no,
               "performa_invoice_id"	: performa_invoice_id 
             }, 
             cache: false, 
             success: function (data)
			 { 
					unblock_page("success","Sucessfully Inserted.");
					 setTimeout(function(){ location.reload(); },1000);
					 
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
		 unblock_page('error',"Please select atlest 1 design");
		 return false;
	 }
	 block_page();
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
					unblock_page("","");
             }
			}); 
		  
}
function delete_pallet(con_entry,performa_invoice_id,supplier_id,pallet_ids)
{
	 
	 block_page();
	$.ajax({ 
             type: "POST", 
             url: root+'create_pi_loading/delete_pallet',
             data: 
			 {
					"pi_loading_plan_id"	: pallet_ids 
             }, 
             cache: false, 
             success: function (data)
			 { 
					edit_loading(con_entry,performa_invoice_id,supplier_id);
					unblock_page("","");
             }
			}); 
		  
}
closeNav();

function close_modal()
{
	 location.reload();
}

function company_wise_print(performa_invoice_id)
{
	block_page();
	 $.ajax({ 
           type: "POST", 
           url: root+'create_pi_loading/companywise_print',
           data: {
             "performa_invoice_id"	: performa_invoice_id
           }, 
           cache: false, 
           success: function (data) { 
				 
			$("#printModal").modal({
				backdrop: 'static',
				keyboard: false
			});
		 
			$("#company_wise_html").html(data);
				unblock_page('',"")
           }
	 });
}
function cal_product_invoice(val)
{
	
	 var radioValue = $("#pallet_status"+val).val();
   
	 if(radioValue==1)
	 {
		
		var sqm_per_box 			= $('#sqm_per_box'+val).val();
		
		var boxes_per_pallet 		= $('#boxes_per_pallet'+val).val();
		 
		
			if($('#no_of_pallet'+val).val() != undefined && $('#no_of_pallet'+val).val() != "" )
			{
				 var no_of_pallet 			= $('#no_of_pallet'+val).val();
			 	 var no_of_boxes 			= $('#no_of_pallet'+val).val() * boxes_per_pallet;
			 	$('#no_of_boxes'+val).val(no_of_boxes.toFixed(2));
				var no_of_sqm = no_of_boxes * sqm_per_box;
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
function cal_box_invoice(val)
{
	
	var radioValue = $("#pallet_status"+val).val();
    var sqm_per_box = $('#sqm_per_box'+val).val();
	
	 if(radioValue==1)
	 {
		var no_of_boxes = $('#no_of_boxes'+val).val();
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		$('#sqmhtml'+val).html(no_of_sqm.toFixed(2));
	 }
	 else if(radioValue==2)
	 {
		var no_of_boxes = $('#no_of_boxes'+val).val();
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#no_of_sqm'+val).val(no_of_sqm.toFixed(2));
		$('#sqmhtml'+val).html(no_of_sqm.toFixed(2)); 
	 }
	 else if(radioValue==3)
	 {
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
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/deleteloading',
              data: {
                "con_entry"				: con_entry,
                "performa_invoice_id"	: performa_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Producation Sucessfully deleted.");
						setTimeout(function(){ location.reload(); },1000); 
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
}
function edit_loading(con_entry,performa_invoice_id,supplier_id)
{
	block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_pi_loading/editloading',
              data: {
                "con_entry"				: con_entry,
                "performa_invoice_id"	: performa_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
					$("#excelModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$(".edit_html").show();
					$(".modal-title").html('Edit Container');
					$(".cont_no").html(con_entry);
					 
					$("#mode").val('edit');
					   
					$("#supplier_id").val(supplier_id);
					$("#set_container_detail").html(obj.html);
						unblock_page('',"")
              }
			});
		 
}

</script>