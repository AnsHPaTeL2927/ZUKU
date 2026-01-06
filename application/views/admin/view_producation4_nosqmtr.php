<?php 

$this->view('lib/header'); 

?>

<style>

table 

{

	font-family: calibri;

	border: 0.5px solid #333;

	border-collapse: collapse;

	page-break-inside:avoid;

}

table.packing

{

	

}

td {

 	border: 0.5px solid #333;

	padding: 5px; 

}

th 

{

 	border: 0.5px solid #333;

	padding: 3px; 

}

 

</style>

<script>

function view_pdf(no)

{

	if(no==1)

	{

		window.open(root+"producation_pdf/view_pdf", '_blank');

	}

	else{

		window.location= root+"Producation_pdf/view_pdf";

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

									<a href="<?=base_url()?>dashboard">

										Dashboard

									</a>

								</li>

								<li class="active">

									<a href="<?=base_url().'create_producation/index/'.$producation_mst->performa_invoice_id?>">	Create Producation </a>

								</li>

								<li class="active">

									Producation PDF

								</li>

								 

							</ol>

							<div class="page-header title1">

								<h3>Producation

									 <div class="pull-right form-group">

									  	 <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>

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

										<a href="<?=base_url()?>producation_detail">Production List</a>

								</div>

                                <div class="">

								<div class="panel-body form-body">

								 <?php ob_start();?>

								 <h4 style="text-align:center;font-weight:bold">Production Sheet </h4>

								 		<h4 style="text-align:center;font-weight:bold">Order File 

											<?php 							

												if(!empty($producation_mst->con_twentry))

												{

												echo $producation_mst->con_twentry.' X 20 FCL';

												}								if(!empty($producation_mst->con_twentry) && !empty($producation_mst->con_fourty))

												{

												echo ',';

												}

												if(!empty($producation_mst->con_fourty))

												{

												echo $producation_mst->con_fourty.' X 40 FCL';

												}

										?>

										</h4>

								<table  border="1" cellspacing="0" width="100%" style="text-align:center;">

								 <tr>

										<th colspan="4"> Producation No : <?=$producation_mst->producation_no?> </th>

									 	<th colspan="4"> Producation Date : <?=date('d/m/Y',strtotime($producation_mst->producation_date))?></th>

									 	<th colspan="2"> Supplier Name : <?=$producation_mst->company_name?></th>

										 

								 </tr>

								<tr>

									<th  style="text-align:center;" width="2%">Sr No</th>

									

								 	<th  style="text-align:center;" width="7%">FINISHING</th>
									
									<th  style="text-align:center;" width="9%">Design No</th>

									<th  style="text-align:center;" width="16%">SIZE IN CM</th>

									<th  style="text-align:center;" width="15%">IMAGES</th>

									<th  style="text-align:center;" width="7%">PALLETS</th>

                                    <th  style="text-align:center;" width="7%">BOX / PALLETS</th>

                                    <th  style="text-align:center;" width="7%">PCS/ BOX</th>

									<th  style="text-align:center;" width="7%">TOTAL BOX</th>

								<!--	<th  style="text-align:center;" width="7%">SQ.MTR / BOX.</th>-->

									<th  style="text-align:center;" width="7%">TOTAL SQ. MTR.</th>

							 	</tr>

								 <?php 

										$Total_plts = 0;

										$Total_box = 0;

										$Total_pallet_weight =0;

										$total_product_sqmlm=0;

										$total_amount=0;

										$no_of_row = 4;

										$hsnc_array = array();

										$size_array = array();

										$design_array = array();

										$packing_des = '';

										$packing_sqm = '';

										$packing_box = '';

										$packing_design = '';

										 

										for($i=0; $i<count($product_data);$i++)

										{ 

												  $packing_des 	 	= $product_data[$i]->series_name;

												  $packing_design 	= $product_data[$i]->model_name;

												  $packing_batchno 	= 'XXXXXXS1';

												  $packing_size	 	= $product_data[$i]->size_type_mm;

												  $barcode_no	 	= $product_data[$i]->barcode_no;

												 

												if(!in_array($product_data[$i]->size_type_mm,$size_array))

												 {

													   array_push($size_array,$product_data[$i]->size_type_mm);

													   $size_array[$product_data[$i]->size_type_mm]['size_type_mm'] = $product_data[$i]->size_type_mm;

													    $size_array[$product_data[$i]->size_type_mm]['thickness'] = $product_data[$i]->thickness;

													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] = $product_data[$i]->no_of_pallet;

													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_big_pallet;

													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_small_pallet;

													   $size_array[$product_data[$i]->size_type_mm]['no_of_boxes']  = $product_data[$i]->no_of_boxes;

													   $size_array[$product_data[$i]->size_type_mm]['no_of_sqm'] 	= $product_data[$i]->no_of_sqm;

													   $size_array[$product_data[$i]->size_type_mm]['thickness'] 	= $product_data[$i]->thickness;

													   $size_array[$product_data[$i]->size_type_mm]['box_design_img'] = $product_data[$i]->box_design_img;

													   $size_array[$product_data[$i]->size_type_mm]['pallet_type_name'] = $product_data[$i]->pallet_type_name;

												 }

												 else

												 {

													 $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_pallet;

													 $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_big_pallet;

													 $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_small_pallet;

													 $size_array[$product_data[$i]->size_type_mm]['no_of_boxes'] += $product_data[$i]->no_of_boxes;

													 $size_array[$product_data[$i]->size_type_mm]['no_of_sqm'] += $product_data[$i]->no_of_sqm;

												 }

												 

												 $description = $product_data[$i]->size_type_cm.$product_data[$i]->model_name.$product_data[$i]->no_of_sqm.$product_data[$i]->product_id;

												   

												 if($product_data[$i]->extra_product == 1)

												 {

													 $description = $product_data[$i]->description_goods;

												 }

											 	 if(!in_array($description,$design_array))

												 {

													array_push($design_array,$description); 

													$design_array[$description] = array();

													$design_array[$description]['model_name'] = $product_data[$i]->model_name;

													$design_array[$description]['description_goods'] = $product_data[$i]->description_goods;

													$design_array[$description]['client_name'] = $product_data[$i]->client_name;

													$design_array[$description]['barcode_no'] = $product_data[$i]->barcode_no;

													$design_array[$description]['finish_name'] 	= $product_data[$i]->finish_name;

													$design_array[$description]['size_type_cm']	 = $product_data[$i]->size_type_cm;

													$design_array[$description]['thickness']	 = $product_data[$i]->thickness;

													$design_array[$description]['size_width_mm'] 	= $product_data[$i]->size_width_mm;

													$design_array[$description]['size_height_mm']	 = $product_data[$i]->size_height_mm;

													 

													$design_array[$description]['product_id']	 = $product_data[$i]->product_id;

													$design_array[$description]['design_file'] 		= $product_data[$i]->design_file;

													$design_array[$description]['box_design_img'] = $product_data[$i]->box_design_img;

													$no_of_pallet = 0;

													$big = 0;

													$small = 0;

													$boxes_per_pallet 		= 0;

													$box_per_big_pallet 	= 0;

													$box_per_small_pallet 	= 0;

													$design_array[$description]['other_image'] = $product_data[$i]->other_image;

													if($product_data[$i]->no_of_pallet>0)

													{

														$no_of_pallet	  = $product_data[$i]->no_of_pallet;

														$boxes_per_pallet =  $product_data[$i]->boxes_per_pallet;

														$packing_sqm	  = $product_data[$i]->boxes_per_pallet*$product_data[$i]->sqm_per_box;

														$packing_box 	  = $product_data[$i]->boxes_per_pallet;

													}

													else if($product_data[$i]->no_of_big_pallet > 0 || $product_data[$i]->no_of_small_pallet)

													{

														$big	= ($product_data[$i]->no_of_big_pallet > 0)? $product_data[$i]->no_of_big_pallet:'';

														

														$small= ($product_data[$i]->no_of_small_pallet > 0)? $product_data[$i]->no_of_small_pallet:'';

														$box_per_big_pallet = ( $product_data[$i]->box_per_big_pallet > 0)? $product_data[$i]->box_per_big_pallet:'';

														$box_per_small_pallet= ( $product_data[$i]->box_per_small_pallet > 0)? $product_data[$i]->box_per_small_pallet:'';

														

														$packing_sqm	  = $product_data[$i]->box_per_big_pallet*$product_data[$i]->sqm_per_box.' <br> '.$product_data[$i]->box_per_small_pallet*$product_data[$i]->sqm_per_box;

														$packing_box 	  = $product_data[$i]->box_per_big_pallet.' <br> '.$product_data[$i]->box_per_small_pallet;

												 	}

													

													$design_array[$description]['no_of_pallet'] 		= $no_of_pallet;

													$design_array[$description]['no_of_big_pallet'] 	= $big;

													$design_array[$description]['no_of_small_pallet'] 	= $small;

													$design_array[$description]['boxes_per_pallet'] 	= $boxes_per_pallet;

													$design_array[$description]['box_per_big_pallet'] 	= $box_per_big_pallet;

													$design_array[$description]['box_per_small_pallet'] = $box_per_small_pallet;

													$design_array[$description]['pcs_per_box'] = $product_data[$i]->pcs_per_box;

													$design_array[$description]['no_of_boxes'] = $product_data[$i]->no_of_boxes;

													$design_array[$description]['sqm_per_box'] = $product_data[$i]->sqm_per_box;

													$design_array[$description]['no_of_sqm'] = $product_data[$i]->no_of_sqm;

													$design_array[$description]['box_per_container'] = $product_data[$i]->box_per_container;

													

												 }

												 else

												 {

													$no_of_pallet = 0;

													$big = 0;

													$small = 0;

													$boxes_per_pallet 		= 0;

													$box_per_big_pallet 	= 0;

													$box_per_small_pallet 	= 0;

													

													if($product_data[$i]->no_of_pallet>0)

													{

														$no_of_pallet = $product_data[$i]->no_of_pallet;

														

														$boxes_per_pallet =  $product_data[$i]->boxes_per_pallet;

													}

													else if($product_data[$i]->no_of_big_pallet > 0 || $product_data[$i]->no_of_small_pallet)

													{

														$big	= ($product_data[$i]->no_of_big_pallet > 0)? $product_data[$i]->no_of_big_pallet:'';

														$small= ($product_data[$i]->no_of_small_pallet > 0)? $product_data[$i]->no_of_small_pallet:'';

														$box_per_big_pallet = ( $product_data[$i]->box_per_big_pallet > 0)? $product_data[$i]->box_per_big_pallet:'';

														$box_per_small_pallet= ( $product_data[$i]->box_per_small_pallet > 0)? $product_data[$i]->box_per_small_pallet:'';

												 	}

													$design_array[$description]['no_of_pallet'] 		+= $no_of_pallet;

													$design_array[$description]['no_of_big_pallet'] 	+= $big;

													$design_array[$description]['no_of_small_pallet'] 	+= $small;

													$design_array[$description]['no_of_boxes'] 			+= $product_data[$i]->no_of_boxes;

													 

													$design_array[$description]['no_of_sqm'] 			+= $product_data[$i]->no_of_sqm;

												 }

										}

										 $no = 1;

										 $Total_plts = 0;

										for($i=0; $i<count($design_array);$i++)

										{ 		

												if(!empty($design_array[$i]))

												{

												 

												?>

												<tr>

														<td style="text-align:center"><?=$no?></td>

														<?php 

														

														if($design_array[$design_array[$i]]['product_id'] == 0)

														{

															?>

															<td style="text-align:center" colspan="3"><?=$design_array[$design_array[$i]]['description_goods']?></td> 

															<td style="text-align:center">

																

																	<img src="<?=DESIGN_PATH.$design_array[$design_array[$i]]['other_image']?>"  height="80px" width="80px" style="border: 1px solid;">

																

															</td>

															<?php

														}

														else

														{

														?>

														

														 

														<td style="text-align:center"><?=$design_array[$design_array[$i]]['finish_name']?> </td>
														
														<td style="text-align:center">

															<?=$design_array[$design_array[$i]]['model_name']?>

														</td>

														<td style="text-align:center"><?=$design_array[$design_array[$i]]['size_type_cm']?>

														  <br />														  

														  <?=$design_array[$design_array[$i]]['thickness']?>

															 

														Thickness</td>

														<td style="text-align:center">

															<p style="margin: 0 auto; width:98px;height:95px;overflow:hidden">

																<img src="<?=(!empty($design_array[$design_array[$i]]['design_file']))?DESIGN_PATH.$design_array[$design_array[$i]]['design_file']:DESIGN_PATH.'No-image-found.jpg'?>" style="width:95px"/> 

															</p>

													 	</td>

														<?php 

													 	}

													 

														?>

														

														<td style="text-align:center">

															<?php

															if($design_array[$design_array[$i]]['no_of_pallet'] > 0)

															{

																echo $design_array[$design_array[$i]]['no_of_pallet'];

																$Total_plts += $design_array[$design_array[$i]]['no_of_pallet'];

															}

															else if($design_array[$design_array[$i]]['no_of_big_pallet'] > 0 || $design_array[$design_array[$i]]['no_of_small_pallet'] > 0)

															{

																echo $design_array[$design_array[$i]]['no_of_big_pallet'].'<br>';

																echo $design_array[$design_array[$i]]['no_of_small_pallet'];

																$Total_plts += $design_array[$design_array[$i]]['no_of_big_pallet'];

																$Total_plts += $design_array[$design_array[$i]]['no_of_small_pallet'];

															}

															?>

														 </td>

							

														<td style="text-align:center">

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

															$one_container = $design_array[$design_array[$i]]['no_of_boxes'] * 100 / $design_array[$design_array[$i]]['box_per_container'];

															?>

															 

														</td>

														

													 	<td style="text-align:center"><?=$design_array[$design_array[$i]]['pcs_per_box']?> </td>

													 	<td style="text-align:center"><?=$design_array[$design_array[$i]]['no_of_boxes']?></td>

													 	<!--<td style="text-align:center"><?=$design_array[$design_array[$i]]['sqm_per_box']?></td>-->

													 	<td style="text-align:center"><?=$design_array[$design_array[$i]]['no_of_sqm']?></td>

													 	 

													 

													</tr>

								<?php

												}

								$Total_box 		+= $design_array[$design_array[$i]]['no_of_boxes'];

								$Total_sqm 		+= $design_array[$design_array[$i]]['no_of_sqm'];

								 			

					$no_of_row--;	

					$no++;

											 

										}

		 	 ?>

		

								<tr>

								 

									<th colspan="5"  style="text-align:right;font-weight:bold">TOTAL >>>>>>>>>>>>>>		</th>

									<th style="text-align:center;"><?=$Total_plts?></th>

									<th style="text-align:center;"> </th>

									<th style="text-align:center;"> </th>

									<th style="text-align:center;"><?=$Total_box?></th>

									<!--<th style="text-align:center;"> </th>-->

								 	 <th style="text-align:center;"><?=$Total_sqm?></th>

									

								</tr>

								 

							</table>

								<table cellspacing="0" cellpadding="0" style="" border="1" width="100%" style="border:none;padding:0px;" >	

				<tr>

						<td width="35%" style="border:none;padding:10px;vertical-align:top;">

										<table cellspacing="0" cellpadding="0"  width="100%">

											<tr>

												<td  class="bgcolor" colspan="2" style="text-align:center;border: none;" ><strong>PRODUCTION DETAILS </strong></td>

												

											</tr>

										<tr>

											<td>MADE IN INDIA BACK SIDE OF THE TILES</td>

											<td> <?=$producation_mst->made_in_india_status?>	 </td>

											

										</tr>

										<tr>

											<td>CORNER PROTECTOR</td>

											<td> <?=$producation_mst->corner_protector?>		 </td>

										</tr>

										<tr>

											<td>SEPARATOR BETWEEN THE TILES</td>

											<td><?=$producation_mst->separation_tiles ?> </td>

										</tr>

										

										<tr>

											<td>CORNER PROTECTER</td>

											<td><?=$producation_mst->corner_protector ?> </td>

										</tr>

										 

									</table>

										<table cellspacing="0" cellpadding="0"  width="100%" style="border: none">

									<?php 

									$images_name = explode(",",$producation_mst->barcode_sticker_file);

									 

										?>

										<tr>

											<td class="bgcolor" style="text-align:center;border-top:none;padding:0px"><strong>BOX STICKER EXAMPLE</strong></td>

									 	</tr>

										<tr>

											<?php

											

											if(!empty($images_name[0]) && $images_name[0] != "none")

											{

												?>

												 <td style="text-align:center;padding:0px">  

												 <?php 

												foreach($images_name as $img)

												echo "<div style='margin-bottom:5px'>

														<img src='".base_url()."upload/".$img."' width='355px' height='129px'/> 

													  </div>"; 

												if(!empty($invoicedata->box_sticker_remarks))

												{

													echo  $producation_mst->box_sticker_remarks;

												}

												?>

												</td>

												 <?php

											}

											else

											{

												?>

												 <td style="text-align:left;">  

												 <?php 

												echo "BOX STICKER NAME : <br></br>";

												echo "MFG DATE : <br></br>";

												echo "BATCH NO/SHADE NO :";

												if(!empty($producation_mst->box_sticker_remarks))

												{

													echo  "<br></br>BOX REMARKS : ".$invoicedata->box_sticker_remarks;

												}

												?>

												</td>

												 <?php

												 

											}

											?>

											

											

										</tr>

										 

									</table>

						</td>

						<td width="30%" style="border:none;padding:10px;vertical-align:top;">

									<table cellspacing="0" cellpadding="0"   width="100%">

										<tr>

												<td class="bgcolor"  style="text-align:center;border: none;"  colspan="2"><strong>PALLET PACKING & LOADING DETAILS</strong></td>

												

										</tr>

										 

										<tr class="row15" >

											<td>NUMBER OF CONTAINER </td>

											<td>  <?=$producation_mst->no_of_countainer?>		 </td>

										</tr>

										<tr class="row14" >

											<td>PALLET CAP</td>

											<td> <?=$producation_mst->pallet_cap_name?>	</td>

											

										</tr>

										<tr class="row14" >

											<td>Max. Weight Limit Of Containter(KG)</td>

											<td> <?=$producation_mst->limit_container?>	</td>

											

										</tr>

										<tr class="row15">

											<td>FUMIGATION</td>

											<td> <?=$producation_mst->fumigation_name?>		</td>

										</tr>

										<tr class="row15">

											<td >AIR BAG</td>

											<td> <?=$producation_mst->air_bag_status?>		 </td>

										</tr>

									 

										<tr class="row15">

											<td>MFG BY :</td>

											<td> <?=$producation_mst->company_name?>		 </td>

										</tr>

										<tr class="row15">

											<td>VARIATION IN QUANTITY</td>

											<td> <?=$producation_mst->quonitiy_status?>		 </td>

										</tr>

										 

									</table>

						</td>

						<td width="35%" style="border:none;padding:10px;vertical-align:top;">

								<table cellspacing="0" cellpadding="0"  width="100%">

											<tr>

												<td class="bgcolor" style="text-align:center;border: none; "  colspan="2"><strong>PALLET LABEL EXAMPLE</strong></td>

												

											</tr>

										 <tr>

												<td style="text-align:center;"  colspan="2">Packing Details</td>

												

										</tr>

										<?php 

										if(!empty($producation_mst->box_sticker_file) && $producation_mst->box_sticker_file != "none")

										{

											?>

											<tr>

												<td style="text-align:center;"  colspan="2">

													<img src='<?=base_url()."upload/".$producation_mst->box_sticker_file?>' width='290px' height='175px'/>

												</td>

												

											</tr>

											<?php

										}

										else

										{

										?>

										

										

										<tr class="row14">

											<td width="30%">Description of Goods</td>

											<td width="70%"> <?=$packing_des?> </td>

											

										</tr>

										<tr class="row15">

											<td>Design Name</td>

											<td> <?=$packing_design?> </td>

										</tr>

										<tr class="row15">

											<td>Batch No/Shade No	</td>

											<td>   xxxxxx s1 </td>

										</tr>

										<tr class="row15">

											<td>Size	</td>

											<td> <?=$packing_size?>  </td>

										</tr>

										<tr class="row15">

											<td>SQM/Pallet</td>

											<td>  <?=$packing_sqm?>  </td>

										</tr>

										 <tr class="row15">

											<td>Boxes/Pallet</td>

											<td><?=$packing_box?> </td>

										</tr>

										<?php 

										if(!empty($barcode_no))

										{

											?>

										 <tr class="row15">

											<td>Barcode</td>

											<td>

												<img alt='Barcode' src='<?=base_url()?>barcode/index/<?=$barcode_no?>'/> 

											

											</td>

										</tr>

										<?php 

										}

										}

										?> 

											

									</table>

						</td>

				</tr>

							</table>	

				

								<?php 

								if(!empty($size_array[0]))

								{

								?>

								<table border="1" cellspacing="0" width="40%" style="margin-top: 20px;">

									<tr>

										<th style="text-align:center">SIZE</th>

										<th style="text-align:center">PALLETS</th>

										<th style="text-align:center">BOXES</th>

										<th style="text-align:center">SQ.MTR</th>

										<th style="text-align:center">Box Design</th>

										<th style="text-align:center">Pallet Type</th>

									</tr>

									<?php

									$total_pallet=0;

									$total_box=0;

									$total_sqm=0;

										for($p=0;$p<count($size_array);$p++)

										{

											if(!empty($size_array[$p]))

											{

										?>

											<tr>

												<td style="text-align:center" ><?=$size_array[$p]?><br />

<?=$size_array[$size_array[$p]]['thickness']?>mm Thickness</td>

												<td style="text-align:center" ><?=$size_array[$size_array[$p]]['no_of_pallet']?></td>

												<td style="text-align:center" ><?=$size_array[$size_array[$p]]['no_of_boxes']?></td>

												<td style="text-align:center" ><?=$size_array[$size_array[$p]]['no_of_sqm']?></td>

												<td style="text-align:center" >

													<p style="margin: 0 auto;width:50px;height:50px;overflow:hidden;position: relative;">

													<img src="<?=base_url().'upload/box_design/'.$size_array[$size_array[$p]]['box_design_img']?>" style="width:60px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;"/>

													 </p>

											 

												</td>

												<td style="text-align:center" ><?=$size_array[$size_array[$p]]['pallet_type_name']?></td>

											</tr>

										<?php 

										$total_pallet += $size_array[$size_array[$p]]['no_of_pallet'];

										$total_box	  += $size_array[$size_array[$p]]['no_of_boxes'];

										$total_sqm	  += $size_array[$size_array[$p]]['no_of_sqm'];

											}

										}

										?>

									<tr>

										<th style="text-align:center" >Total</th>

										<th style="text-align:center" ><?=$total_pallet?></th>

										<th style="text-align:center" ><?=$total_box?></th>

										<th style="text-align:center" ><?=$total_sqm?></th>

									</tr>

							 </table>

								<?php 

								}

								if(!empty($producation_mst->po_notes))

								{

								?>		

								<div style="text-align:left;margin-top:15px;">

									<strong><u>NOTES :</u></strong><br>

									<?=$producation_mst->po_notes?>

								<?php 

								}

								?> 

								 

								</div>	 

							 

	 	 

		

						 			<?php

								 

									 $output = ob_get_contents(); 

									 $_SESSION['performainvoice_no'] = $producation_mst->invoice_no.' - '.date('d-m',strtotime($producation_mst->performa_date));

									 $_SESSION['producation_content'] = $output;

									  if($mode=="1")

									 {

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

<script src="<?=base_url()?>adminast/assets/js/jquery.table2excel.js"></script>

<script>

 function Export() {

      $(".main_table").table2excel({

          filename:  "<?=$jnvoicedata->invoice_no?>.xls",

		  sheetName: "PI",

      });

  }

</script>