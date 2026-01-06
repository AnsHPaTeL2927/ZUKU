<?php
$export =  ($invoicedata->exporter_detail);
//$company =$company_profile[0];
$this->view('lib/header');
?>
<style>
    table {
        font-family: cambria;
        border: 0.5px solid #333;
        border-collapse: collapse;
        page-break-inside: avoid;
    }

    table.packing {}

    td {
        border: 0.5px solid #333;
        padding: 5px;
    }

    th {
        border: 0.5px solid #333;
        padding: 3px;
    }

    .profile-pic {
        position: relative;

        padding: 2px;
    }

    .profile-pic:hover .edit {
        display: block;

    }

    .profile-pic:hover {
        border: 1px solid #036df0;
    }

    .edit {
        padding-top: 7px;
        padding-right: 7px;
        position: fixed;
        right: 13px;

        display: none;
    }

    .edit a {
        color: blue;
    }
</style>
<script>
    function view_pdf(no) {
        if (no == 1) {
            window.open(root + "producation_pdf/view_pdf", '_blank');
        }
        else {
            window.location = root + "Producation_pdf/view_pdf";
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
                        <li>
                            <i class="clip-pencil"></i>
                            <a href="<?= base_url() ?>dashboard">
                                Dashboard
                            </a>
                        </li>
                        <li class="active">
                            <a href="<?= base_url() . 'create_producation/index/' . $producation_mst->performa_invoice_id ?>">
                                Create Producation </a>
                        </li>
                        <li class="active">
                            Producation PDF
                        </li>

                    </ol>
                    <div class="page-header title1">
                        <h3>Producation
                        
									
                            <div class="pull-right form-group">
                                	<div class="dropdown" style="float:left;margin-right:5px;">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
											 
												
													<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('view_producation/index_extrapallet2/'.$producation_mst->production_mst_id)?>" ><i class="fa fa-file-text-o"></i> PO 2</a>
													<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('view_producation/index_extrapallet3/'.$producation_mst->production_mst_id)?>" ><i class="fa fa-file-text-o"></i> PO 3</a>
											
												
											 </li>											 
											</ul>
										</div>
                                <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;"
                                    onclick="view_pdf(1);"><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
                            </div>
                            
                        </h3>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            <a href="<?= base_url() ?>producation_detail">Production List</a>
                        </div>
                        <div class="">
                            <div class="panel-body form-body">
                                <?php
                                if (!empty($invoice_html_data)) {
                                    echo '<div class="pull-right">
											<a class="btn btn-danger tooltips" data-title="Delete" href="javascript:;"  onclick="delete_editable(' . $producation_mst->production_mst_id . ')"   ><i class="fa fa-trash"></i> Delete (Edited version)</a>
										</div>	
										';
                                }
                                ?>
                                <?php ob_start(); ?>
                                <div id="print_content" style="margin-top:80px;">
                                    <div class="profile-pic">
                                        <div class="edit pull-right">
                                            <a href="javascript:;" style="color:#fff;font-size:12px"
                                                class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i
                                                    class="fa fa-pencil fa-lg"></i> Edit</a>
                                            <a href="javascript:;" class="invoice_update_btn btn btn-success"
                                                style="display:none;color:#fff" onclick="edit_invoice();">Save</a>
                                        </div>
                                        <div class="save_invoice_html">
                                            <?php

                                            if (!empty($invoice_html_data)) {
                                                echo $invoice_html_data->invoice_html;
                                            } else {

                                                ?>

                                                <table class="main_table invoice_edit_cls" border="1" cellspacing="0"
                                                    width="100%" style="text-align:center;">
                                                    <tr>
                                                          <td colspan="4"
                                                            style="text-align:left;font-size:13px">
                                                              <strong>
                                                                   <?=$company_detail[0]->s_name;?>
                                                              </strong>
                                                              <br>
                                                          <?=$company_detail[0]->s_address?>
                                                          <br>
                                                         
                                                       <strong>GST NO : <?=$company_detail[0]->s_gst;?></strong>
                                                          
                                                        </td>
                                                         <td colspan="5"
                                                            style="text-align:left;font-size:18px;text-align:center">
                                                            <img src="<?= base_url() . 'upload/' . $company_detail[0]->head_logo ?>"
                                                                style="width:175px" width="<?= $company_detail->head_logo_width ?>"
                                                                height="<?= $company_detail->head_logo_height ?>" />
                                                       

                                                    </tr>
                                                    <tr>
                                                        <th colspan="9" style="text-align:center;background-color:#DAEEF3;font-size:15px;"
                                                           > PURCHASE ORDER
                                                            </th>
                                                       

                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                           <strong> SUPPLIER DETAILS</strong> 
                                                        </td>
                                                         <td colspan="5">
                                                          <strong>PO DETAILS</strong> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" style="text-align:left;font-size:12px;">
                                                           <strong>NAME : <?=$producation_mst->company_name?></strong> <br>
                                                           ADDRESS : <?=$producation_mst->address?><br>
                                                           <strong>GST NO : <?=$producation_mst->supplier_gstno?></strong><br>
                                                        
                                                            
                                                        </td>
                                                         <td colspan="5" style="text-align:left;font-size:12px;">
                                                             PO NO :  <strong><?=$producation_mst->producation_no?></strong> <br>
															PO DATE :  <strong><?=date('d/m/Y',strtotime($producation_mst->producation_date))?></strong><br>
															PI NO : <strong> <?=$producation_mst->invoice_no?></strong><br>
															<!--REMARKS :   <strong><?=$producation_mst->po_notes?></strong><br>-->
                                                           
                                                             
                                                         </td>
                                                    </tr>
													
													
                                                   
                                                    <tr>
                                                         <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="9%">DESIGN IMAGE</th>
                                                             <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">SIZE </th>
                                                            <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">COLLECTION </th>
                                                            <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">FINISH</th>
                                                            <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">DESIGN NAME</th>
                                                            <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">CONT.</th>
                                                              <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">BOX/ PALLETS</th> 
															
															<th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">PALLET QTY</th>
                                                            <th style="text-align:center;background-color:#DAEEF3;color:#000000"
                                                            width="6%">BOX QTY</th>
                                                            
                                                       
                                                      
                                                       
                                                    </tr>
                                                    <?php
                                                    $Total_plts = 0;
                                                    $Total_box = 0;
                                                    $Total_pallet_weight = 0;
                                                    $total_product_sqmlm = 0;
                                                    $total_amount = 0;
                                                    $no_of_row = 4;
                                                    $hsnc_array = array();
                                                    $size_array = array();
                                                    $design_array = array();
                                                    $packing_des = '';
                                                    $packing_sqm = '';
                                                    $packing_box = '';
                                                    $packing_design = '';

                                                    for ($i = 0; $i < count($product_data); $i++) {
                                                        $packing_des = $product_data[$i]->series_name;
                                                        $packing_design = $product_data[$i]->model_name;
                                                        $packing_batchno = 'XXXXXXS1';
                                                        $packing_size = $product_data[$i]->size_type_mm;
                                                        $barcode_no = $product_data[$i]->barcode_no;

                                                        if (!in_array($product_data[$i]->size_type_mm, $size_array)) {
                                                            array_push($size_array, $product_data[$i]->size_type_mm);
                                                            $size_array[$product_data[$i]->size_type_mm]['collection'] = $product_data[$i]->collection;
                                                            $size_array[$product_data[$i]->size_type_mm]['size_type_mm'] = $product_data[$i]->size_type_mm;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] = $product_data[$i]->no_of_pallet;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_big_pallet;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_small_pallet;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_boxes'] = $product_data[$i]->no_of_boxes;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_sqm'] = $product_data[$i]->no_of_sqm;
                                                            $size_array[$product_data[$i]->size_type_mm]['thickness'] = $product_data[$i]->thickness;
                                                            $size_array[$product_data[$i]->size_type_mm]['box_design_img'] = $product_data[$i]->box_design_img;
                                                            $size_array[$product_data[$i]->size_type_mm]['pallet_type_name'] = $product_data[$i]->pallet_type_name;
															  $size_array[$product_data[$i]->size_type_mm]['box_design_name'] = $product_data[$i]->box_design_name;
                                                        } else {
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_pallet;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_big_pallet;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_small_pallet;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_boxes'] += $product_data[$i]->no_of_boxes;
                                                            $size_array[$product_data[$i]->size_type_mm]['no_of_sqm'] += $product_data[$i]->no_of_sqm;
                                                        }

                                                        $description = $product_data[$i]->size_type_cm . $product_data[$i]->model_name . $product_data[$i]->finish_name . $product_data[$i]->product_id;

                                                        if ($product_data[$i]->extra_product == 1) {
                                                            $description = $product_data[$i]->description_goods;
                                                        }
                                                        if (!in_array($description, $design_array)) {
                                                            array_push($design_array, $description);
                                                            $design_array[$description] = array();
                                                            $design_array[$description]['collection'] = $product_data[$i]->collection;
                                                            $design_array[$description]['model_name'] = $product_data[$i]->model_name;
                                                            $design_array[$description]['description_goods'] = $product_data[$i]->description_goods;
                                                            $design_array[$description]['client_name'] = $product_data[$i]->client_name;
                                                            $design_array[$description]['barcode_no'] = $product_data[$i]->barcode_no;
                                                            $design_array[$description]['finish_name'] = $product_data[$i]->finish_name;
                                                            $design_array[$description]['no_of_countainer'] = $product_data[$i]->no_of_countainer;
                                                            $design_array[$description]['size_type_cm'] = $product_data[$i]->size_type_cm;
                                                            $design_array[$description]['size_width_mm'] = $product_data[$i]->size_width_mm;
                                                            $design_array[$description]['size_height_mm'] = $product_data[$i]->size_height_mm;

                                                            $design_array[$description]['product_id'] = $product_data[$i]->product_id;
                                                            $design_array[$description]['design_file'] = $product_data[$i]->design_file;
                                                            $design_array[$description]['box_design_img'] = $product_data[$i]->box_design_img;
                                                            $no_of_pallet = 0;
                                                            $big = 0;
                                                            $small = 0;
                                                            $multi_box_per_container = 0;
                                                            $boxes_per_pallet = 0;
                                                            $box_per_big_pallet = 0;
                                                            $box_per_small_pallet = 0;
                                                            $design_array[$description]['other_image'] = $product_data[$i]->other_image;

                                                            if ($product_data[$i]->no_of_pallet > 0) {
                                                                $no_of_pallet = !empty($product_data[$i]->auto_no_of_pallet) ? $product_data[$i]->auto_no_of_pallet : $product_data[$i]->no_of_pallet;

                                                                $boxes_per_pallet = $product_data[$i]->boxes_per_pallet;
                                                                $packing_sqm = $product_data[$i]->boxes_per_pallet * $product_data[$i]->sqm_per_box;
                                                                $packing_box = $product_data[$i]->boxes_per_pallet;
                                                            } else if ($product_data[$i]->no_of_big_pallet > 0 || $product_data[$i]->no_of_small_pallet) {
                                                                $big = !empty($product_data[$i]->auto_no_of_big_pallet) ? $product_data[$i]->auto_no_of_big_pallet : $product_data[$i]->no_of_big_pallet;

                                                                $small = !empty($product_data[$i]->auto_no_of_small_pallet) ? $product_data[$i]->auto_no_of_small_pallet : $product_data[$i]->no_of_small_pallet;

                                                                $box_per_big_pallet = ($product_data[$i]->box_per_big_pallet > 0) ? $product_data[$i]->box_per_big_pallet : '';
                                                                $box_per_small_pallet = ($product_data[$i]->box_per_small_pallet > 0) ? $product_data[$i]->box_per_small_pallet : '';

                                                                $packing_sqm = $product_data[$i]->box_per_big_pallet * $product_data[$i]->sqm_per_box . ' <br> ' . $product_data[$i]->box_per_small_pallet * $product_data[$i]->sqm_per_box;
                                                                $packing_box = $product_data[$i]->box_per_big_pallet . ' <br> ' . $product_data[$i]->box_per_small_pallet;
                                                            }

                                                            $design_array[$description]['no_of_pallet'] = $no_of_pallet;
                                                            $design_array[$description]['no_of_big_pallet'] = $big;
                                                            $design_array[$description]['no_of_small_pallet'] = $small;
                                                            $design_array[$description]['boxes_per_pallet'] = $boxes_per_pallet;
                                                            $design_array[$description]['multi_box_per_container'] = $product_data[$i]->multi_box_per_container;
                                                            $design_array[$description]['box_per_big_pallet'] = $box_per_big_pallet;
                                                            $design_array[$description]['box_per_small_pallet'] = $box_per_small_pallet;
                                                            $design_array[$description]['pcs_per_box'] = $product_data[$i]->pcs_per_box;
                                                            $design_array[$description]['no_of_boxes'] = !empty($product_data[$i]->auto_no_of_boxes) ? $product_data[$i]->auto_no_of_boxes : $product_data[$i]->no_of_boxes;
                                                            $design_array[$description]['sqm_per_box'] = $product_data[$i]->sqm_per_box;
                                                            $design_array[$description]['no_of_sqm'] = !empty($product_data[$i]->auto_no_of_sqm) ? $product_data[$i]->auto_no_of_sqm : $product_data[$i]->no_of_sqm;
                                                            $design_array[$description]['box_per_container'] = $product_data[$i]->box_per_container;

                                                        } else {
                                                            $no_of_pallet = 0;
                                                            $big = 0;
                                                            $small = 0;
                                                            $boxes_per_pallet = 0;
                                                            $box_per_big_pallet = 0;
                                                            $box_per_small_pallet = 0;

                                                            if ($product_data[$i]->no_of_pallet > 0) {

                                                                $no_of_pallet = !empty($product_data[$i]->auto_no_of_pallet) ? $product_data[$i]->auto_no_of_pallet : $product_data[$i]->no_of_pallet;

                                                                $boxes_per_pallet = $product_data[$i]->boxes_per_pallet;
                                                            } else if ($product_data[$i]->no_of_big_pallet > 0 || $product_data[$i]->no_of_small_pallet) {
                                                                $big = !empty($product_data[$i]->auto_no_of_big_pallet) ? $product_data[$i]->auto_no_of_big_pallet : $product_data[$i]->no_of_big_pallet;

                                                                $small = !empty($product_data[$i]->auto_no_of_small_pallet) ? $product_data[$i]->auto_no_of_small_pallet : $product_data[$i]->no_of_small_pallet;


                                                                $box_per_big_pallet = ($product_data[$i]->box_per_big_pallet > 0) ? $product_data[$i]->box_per_big_pallet : '';
                                                                $box_per_small_pallet = ($product_data[$i]->box_per_small_pallet > 0) ? $product_data[$i]->box_per_small_pallet : '';
                                                            }

                                                            $design_array[$description]['no_of_pallet'] += $no_of_pallet;
                                                            $design_array[$description]['no_of_big_pallet'] += $big;
                                                            $design_array[$description]['no_of_small_pallet'] += $small;
                                                            $design_array[$description]['no_of_boxes'] += !empty($product_data[$i]->auto_no_of_boxes) ? $product_data[$i]->auto_no_of_boxes : $product_data[$i]->no_of_boxes;

                                                            $design_array[$description]['no_of_sqm'] += !empty($product_data[$i]->auto_no_of_sqm) ? $product_data[$i]->auto_no_of_sqm : $product_data[$i]->no_of_sqm;
                                                        }
                                                    }
                                                    $no = 1;
                                                    $Total_plts = 0;
                                                    for ($i = 0; $i < count($design_array); $i++) {
                                                        if (!empty($design_array[$i])) {

                                                            ?>
                                                            <tr>
                                                                   <td style="text-align:center;background-color:#5E6264;">
                                                                            <!--<p-->
                                                                        <!--    style="margin: 0 auto; width:98px;height:100px;overflow:hidden">-->
                                                                        <!--    <img src="<?= (!empty($design_array[$design_array[$i]]['design_file'])) ? DESIGN_PATH . $design_array[$design_array[$i]]['design_file'] : DESIGN_PATH . 'No-image-found.jpg' ?>"-->
                                                                        <!--        style="width:120px;height:70px;"  />-->
                                                                                
                                                                                
                                                                        <!--</p>-->
                                                                         <p style="margin:0 auto;width:90px;height:70px;overflow:hidden;position:relative;">
                                                                            
                                                                                 <img src="<?= (!empty($design_array[$design_array[$i]]['design_file'])) ? DESIGN_PATH . $design_array[$design_array[$i]]['design_file'] : DESIGN_PATH . 'No-image-found.jpg' ?>"
                                                                                 style="width:70px;margin:auto;position:absolute;top:0;left:0;right:0;bottom:0;" />
                                                                           </p>


                                                                    </td>
                                                                <?php

                                                                if ($design_array[$design_array[$i]]['product_id'] == 0) {
                                                                    ?>
                                                                    <td style="text-align:center;font-weight:bold;font-size: 11px" colspan="3">
                                                                        <?= $design_array[$design_array[$i]]['description_goods'] ?></td>
                                                                  
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                     <td style="text-align:center;font-weight:bold;font-size: 11px">
                                                                        <?= $design_array[$design_array[$i]]['size_type_cm'] ?>
                                                                   </td>
                                                                   <td style="font-weight:bold;font-size: 11px">
                                                                        <?= $design_array[$design_array[$i]]['collection'] ?>
                                                                   </td>
                                                                   

                                                                    <td
                                                                        style="text-align:center;font-weight:bold;color:#000000;font-size: 11px">
                                                                        <?= $design_array[$design_array[$i]]['finish_name'] ?> </td>
                                                                    <td
                                                                        style="text-align:center;font-weight:bold;color:#000000;font-size: 11px">
                                                                        <?= $design_array[$design_array[$i]]['model_name'] ?>
                                                                    </td>
																	
                                                                    <td style="font-weight:bold;font-size: 11px">
																	<?php
																	$design = $design_array[$design_array[$i]]; // assign current design to a variable
																	$one_container = 0; // initialize

																	if ($design['no_of_pallet'] > 0) {
																	   // echo $design['no_of_pallet'];
																	  //  $Total_plts += $design['no_of_pallet'];

																		$one_container = $design['no_of_boxes'] * 100 / $design['box_per_container'];

																	} elseif ($design['no_of_big_pallet'] > 0 || $design['no_of_small_pallet'] > 0) {
																	  //  echo $design['no_of_big_pallet'] . '<br>';
																	  //  echo $design['no_of_small_pallet'];

																	   // $Total_plts += $design['no_of_big_pallet'];
																	   // $Total_plts += $design['no_of_small_pallet'];

																		$one_container = $design['no_of_boxes'] * 100 / $design['multi_box_per_container'];

																	} else {
																	   // echo '-';
																		//$Total_plts += 0;

																		$one_container = $design['no_of_boxes'] * 100 / $design['total_boxes'];
																	}

																	// Handle infinite / divide by zero cases and format
																	$one_container = ($one_container == INF) ? " - " : number_format($one_container / 100, 2);

																	
																	?>

																	<?php echo $one_container;?>
                                                                       
                                                                    </td>
																	
																		<td style="text-align:center;font-weight:bold;">
														 <?php
															if($design_array[$design_array[$i]]['no_of_pallet'] > 0)
															{
																echo $design_array[$design_array[$i]]['boxes_per_pallet'];
															}
															else if($design_array[$design_array[$i]]['no_of_big_pallet'] > 0 || $design_array[$design_array[$i]]['no_of_small_pallet'] > 0)
															{
																echo $design_array[$design_array[$i]]['box_per_big_pallet'].'<br>';
																echo $design_array[$design_array[$i]]['box_per_small_pallet'];
															}
															?>
															 
														</td>
														
                                                                      <td
                                                                    style="text-align:center;font-weight:bold;color:#000000;font-size: 11px">
                                                                    <?php
                                                                    if ($design_array[$design_array[$i]]['no_of_pallet'] > 0) {
                                                                        echo $design_array[$design_array[$i]]['no_of_pallet'];
                                                                        $Total_plts += $design_array[$design_array[$i]]['no_of_pallet'];
                                                                    } else if ($design_array[$design_array[$i]]['no_of_big_pallet'] > 0 || $design_array[$design_array[$i]]['no_of_small_pallet'] > 0) {
                                                                        echo $design_array[$design_array[$i]]['no_of_big_pallet'] . '<br>';
                                                                        echo $design_array[$design_array[$i]]['no_of_small_pallet'];
                                                                        $Total_plts += $design_array[$design_array[$i]]['no_of_big_pallet'];
                                                                        $Total_plts += $design_array[$design_array[$i]]['no_of_small_pallet'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                    
                                                                   	<td style="text-align:center;font-weight:bold;font-size: 11px"><?=$design_array[$design_array[$i]]['no_of_boxes']?></td>
                                                                  
                                                                    
                                                                <?php
                                                                }

                                                                ?>
                                                               


                                                              

                                                              
                                                                


                                                            </tr>
                                                            <?php
															$Total_con += $one_container;
                                                        }
                                                        
                                                        $Total_box += $design_array[$design_array[$i]]['no_of_boxes'];
                                                        $Total_sqm += $design_array[$design_array[$i]]['no_of_sqm'];

                                                        $no_of_row--;
                                                        $no++;

                                                    }
													
                                                    ?>

                                                    <tr>

                                                        <th colspan="5"
                                                            style="text-align:right;font-weight:bold;background-color:#DAEEF3;color:#000000;font-size: 12px">
                                                            TOTAL >>>>>>>>>>>>>> </th>
                                                        
                                                        <th
                                                            style="text-align:center;background-color:#DAEEF3;color:#000000;font-size: 12px">
                                                            <?=$Total_con?></th>   
															
															<th
                                                            style="text-align:center;background-color:#DAEEF3;color:#000000;font-size: 12px">
                                                            </th>  
															
															<th
                                                            style="text-align:center;background-color:#DAEEF3;color:#000000;font-size: 12px">
                                                            <?= $Total_plts ?></th>
                                                        <th
                                                            style="text-align:center;background-color:#DAEEF3;color:#000000;font-size: 12px">
                                                            <?= $Total_box ?></th>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" style="text-align:left;font-size:12px;">
                                                          <strong><u>PRODUCTION DETAILS </u></strong> <br> <br>
														   <?php
															// find the first non-empty box design image from the above loop data
															$first_box_design_img1 = '';
															for ($p = 0; $p < count($size_array); $p++) {
																if (!empty($size_array[$p])) {
																	$img1 = $size_array[$size_array[$p]]['box_design_name'];
																	if (!empty($img)) {
																		$first_box_design_img1 = $img1;
																		break; // stop at first found
																	}
																}
															}
															?>
															
															
															 <?php
															$brand_box = ''; // default empty

															for($p=0; $p<count($size_array); $p++) {
																if(!empty($size_array[$p])) {
																	// Take the first non-empty pallet type name
																	$brand_box = $size_array[$size_array[$p]]['box_design_name'];
																	break; // stop after getting the first one
																}
															}
															?>

															BRAND BOX :- <strong style="color:red;"><?=strtoupper($brand_box)?></strong><br>

															MADE IN INDIA :- <strong><?=strtoupper($producation_mst->made_in_india_status)?></strong><br>

															BOX WEIGHT & THICKNESS :- <strong><?=strtoupper($producation_mst->box_weight_thickness ?? '')?></strong><br>

															CORNER PROTECTOR :- <strong><?=strtoupper($producation_mst->corner_protector)?></strong><br>

															SEPARATOR OF THE TILES :- <strong><?=strtoupper($producation_mst->separation_tiles)?></strong><br>

															VARIATION IN QTY :- <strong><?=strtoupper($producation_mst->quonitiy_status)?></strong><br>

															MATCHING & QC :- <strong><?=strtoupper($producation_mst->qc_by)?></strong><br>

															BATCH / SHADE :- <strong><?=strtoupper($producation_mst->batch_shade ?? '')?></strong><br><br>

<?php
$remarks = strtoupper($producation_mst->box_sticker_remarks);

// remove all //
$remarks = str_replace('//', '', $remarks);

// convert new lines to <br>
$remarks = nl2br(trim($remarks));
?>

<strong><u>SPECIAL REMARK :</u></strong><br>
<strong style="color:red;"><?= $remarks ?></strong>




                                                        </td>
                                                         <td colspan="5" style="text-align:left;font-size:12px;">
                                                             <strong><u>PALLET PACKING & LOADING DETAILS</u></strong> <br> <br>
                                                          <?php
															$pallet_type_name = ''; // default empty

															for($p=0; $p<count($size_array); $p++) {
																if(!empty($size_array[$p])) {
																	// Take the first non-empty pallet type name
																	$pallet_type_name = $size_array[$size_array[$p]]['pallet_type_name'];
																	break; // stop after getting the first one
																}
															}
															?>

															PALLET TYPE : <strong><?=strtoupper($pallet_type_name)?></strong><br>

															PALLET CAPE : <strong><?=strtoupper($producation_mst->pallet_cap_name)?></strong><br>

															PLASTIC FRAME : <strong><?=strtoupper($producation_mst->plastic_frame ?? '')?></strong><br>

															FOAMSHEET : <strong><?=strtoupper($producation_mst->foamsheet ?? '')?></strong><br>

															AIR BAG OR BELT : <strong><?=strtoupper($producation_mst->air_bag_status)?></strong><br>

															MOISTURE BAG : <strong><?=strtoupper($producation_mst->mosqure_bag_status)?></strong><br>

															FUMIGATION : <strong><?=strtoupper($producation_mst->fumigation_name)?></strong><br>

															LOADING : <strong><?=strtoupper($producation_mst->loading_by)?></strong><br><br>

															<strong><u>SPECIAL REMARK :</u></strong><br>
															<strong  style="color:red;"><?=strtoupper($producation_mst->po_notes)?></strong>


                                                        </td>
                                                    </tr>
													
													 <tr>
                                                        <td colspan="4" style="text-align:left;">
                                                          <strong><u>BOX STICKER EXAMPLE </u></strong> <br> <br>
                                                            <?php
																	$images_name = explode(",",$producation_mst->barcode_sticker_file);
                                                                    if (!empty($images_name[0]) && $images_name[0] != "none") {
                                                                        ?>
                                                                       
                                                                            <?php
                                                                            foreach ($images_name as $img)
                                                                                echo "<div style='margin-bottom:5px'>
														<img src='" . base_url() . "upload/" . $img . "' width='300px' height='100px'/> 
													  </div>";
                                                                            // if (!empty($invoicedata->box_sticker_remarks)) {
                                                                                // echo $producation_mst->box_sticker_remarks;
                                                                            // }
                                                                            ?>
                                                                      
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </td>
                                                         <td colspan="5" style="text-align:left;">
                                                             <strong><u>PALLET PACKING & LOADING DETAILS</u></strong> <br> <br>
                                                           <?php
                                                                if (!empty($producation_mst->box_sticker_file) && $producation_mst->box_sticker_file != "none") {
                                                                    ?>
                                                                   
                                                                            <img src='<?= base_url() . "upload/" . $producation_mst->box_sticker_file ?>'
                                                                                width='200px' height='140px' />
                                                                      
                                                                    <?php
                                                                } 
                                                                ?>

                                                        </td>
                                                    </tr> 
													
													<tr>
                                                       <?php
															// find the first non-empty box design image from the above loop data
															$first_box_design_img = '';
															for ($p = 0; $p < count($size_array); $p++) {
																if (!empty($size_array[$p])) {
																	$img = $size_array[$size_array[$p]]['box_design_img'];
																	if (!empty($img)) {
																		$first_box_design_img = $img;
																		break; // stop at first found
																	}
																}
															}
															?>

															<td colspan="4" style="text-align:left;">
																<strong><u>BOX DESIGN</u></strong><br><br>
																<?php if (!empty($first_box_design_img)) { ?>
																	
																		<div style="margin-bottom:5px">
																			<img src="<?= base_url().'upload/box_design/'.$first_box_design_img ?>" width="200px" height="110px"/>
																		</div>
																		<?php
																		if (!empty($invoicedata->box_sticker_remarks)) {
																			echo $producation_mst->box_sticker_remarks;
																		}
																		?>
																	
																<?php } ?>
															</td>

                                                         <td colspan="5" style="text-align:left;">
                                                             <strong><u>SPECIAL STICKER</u></strong> <br> <br>
                                                           <?php
                                                                if (!empty($producation_mst->special_sticker_file) && $producation_mst->special_sticker_file != "none") {
                                                                    ?>
                                                                   
                                                                            <img src='<?= base_url() . "upload/" . $producation_mst->special_sticker_file ?>'
                                                                                width='200px' height='110px' />
                                                                      
                                                                    <?php
                                                                } 
                                                                ?>

                                                        </td>
                                                    </tr>



                                                </table>
                                              
											<!--<?php

                                                if (!empty($producation_mst->po_notes)) {
                                                    ?>
                                                        <tr>
                                                            <td colspan="7" class="main_table invoice_edit_cls"
                                                                style="text-align:left;margin-top:15px;">
                                                                <p style="font-size:13px;color:#ff0000">
                                                                    <strong> <u> QUALITY PARAMETER :</u></strong>
                                                                </p>
                                                                <p style="font-size:12px">
                                                                    <?= $producation_mst->po_notes ?>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                <?php
                                                }
                                                ?>-->

                                            </div>
                                            <?php
                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>


                            <?php

                            $output = ob_get_contents();
                            $_SESSION['performainvoice_no'] = $producation_mst->producation_no . ' - ' . date('d-m', strtotime($producation_mst->producation_date));
                            $_SESSION['producation_content'] = $output;
                            if ($mode == "1") {
                                echo "<script>view_pdf(0)</script>";
                            }
                            ?>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

<?php $this->view('lib/footer'); ?>
<script src="<?= base_url() ?>adminast/assets/js/jquery.table2excel.js"></script>
<script>
    function delete_editable(performa_invoice_id) {
        Swal.fire({
            title: 'Delete Editable Version?',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if (result.value) {
                block_page();

                $.ajax({
                    type: "POST",
                    url: root + "performa_invoice_pdf/delete_editable",
                    data:
                    {
                        "performa_invoice_id": performa_invoice_id,
                        "performa_invoice_pdf": 'producation_view'
                    },
                    success: function (response) {
                        unblock_page("success", "invoice Updated");
                        setTimeout(function () { location.reload(); }, 1000);
                    }

                });
            }
        });
    }
    function editable_table() {
        $(".invoice_edit_cls").attr("contenteditable", true)
        $(".invoice_edit_btn").hide();
        $(".invoice_update_btn").show();
    }
    function edit_invoice() {
        block_page();

        $.ajax({
            type: "POST",
            url: root + "view_producation/producation_html_update",
            data:
            {
                "production_mst_id": <?= $producation_mst->production_mst_id ?>,
                "invoice_html": $(".save_invoice_html").html(),
                "invoice_table_name": 'producation_view'
            },
            success: function (response) {
                unblock_page("success", "invoice Updated");
                setTimeout(function () { location.reload(); }, 1000);
            }

        });
    }

    function Export() {
        $(".main_table").table2excel({
            filename: "<?= $jnvoicedata->invoice_no ?>.xls",
            sheetName: "PI",
        });
    }
</script>