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
									QC DATA PDF
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
										<a href="<?=base_url()?>producation_detail">QC DATA</a>
								</div>
                                <div class="">
								<div class="panel-body form-body">
								 <?php ob_start();?>
								 <h4 style="text-align:center;font-weight:bold">QC DATA </h4>
								 		<!--<h4 style="text-align:center;font-weight:bold">Order File 
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
										</h4>-->
								<table  border="1" cellspacing="0" width="100%" style="text-align:center;">
								<!-- <tr>
										<th colspan="2"> Producation No : <?=$producation_mst->producation_no?> </th>
									 	<th colspan="2"> Producation Date : <?=date('d/m/Y',strtotime($producation_mst->producation_date))?></th>
									 	<th colspan="3"> Supplier Name : <?=$producation_mst->company_name?></th>
										 
								 </tr>-->
								<tr>
									<th  style="text-align:center;" width="10%">Sr No</th>
									<th  style="text-align:center;" width="20%">Design Name</th>
								 	<th  style="text-align:center;" width="20%">Manufacturer Design Name</th>
									<th  style="text-align:center;" width="15%">Surface</th>
									<th  style="text-align:center;" width="20%">SIZE IN CM</th>	
									<th  style="text-align:center;" width="15%">Quantity In Boxes</th>
									 
							 	</tr>
								 <?php 
										$Total_plts = 0;
										$Total_box = 0;
										$Total_pallet_weight =0;
										$total_product_sqmlm=0;
										$total_amount=0;
										$no_of_row = 5;
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
													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] = $product_data[$i]->no_of_pallet;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_big_pallet;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_small_pallet;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_boxes'] = $product_data[$i]->no_of_boxes;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_sqm'] = $product_data[$i]->no_of_sqm;
													  
													   $size_array[$product_data[$i]->size_type_mm]['thickness'] = $product_data[$i]->thickness;
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
													$design_array[$description]['no_of_boxes'] = $product_data[$i]->no_of_boxes;
													$design_array[$description]['barcode_no'] = $product_data[$i]->barcode_no;
													$design_array[$description]['finish_name'] 	= $product_data[$i]->finish_name;
													$design_array[$description]['size_type_cm']	 = $product_data[$i]->size_type_cm;
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
													$design_array[$description]['per']					= $product_data[$i]->per;
													$design_array[$description]['no_of_pallet'] 		= $no_of_pallet;
													$design_array[$description]['no_of_big_pallet'] 	= $big;
													$design_array[$description]['no_of_small_pallet'] 	= $small;
													$design_array[$description]['boxes_per_pallet'] 	= $boxes_per_pallet;
													$design_array[$description]['box_per_big_pallet'] 	= $box_per_big_pallet;
													$design_array[$description]['box_per_small_pallet'] = $box_per_small_pallet;
													$design_array[$description]['pcs_per_box'] 			= $product_data[$i]->pcs_per_box;
													$design_array[$description]['no_of_boxes'] 			= $product_data[$i]->no_of_boxes;
													$design_array[$description]['sqm_per_box'] 			= $product_data[$i]->sqm_per_box;
													$design_array[$description]['no_of_sqm'] 			= $product_data[$i]->no_of_sqm;
													
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
										 $Total_qty = 0;
										for($i=0; $i<count($design_array);$i++)
										{ 		
												if(!empty($design_array[$i]))
												{
												 
												?>
												<tr>
														<td style="text-align:center"><?=$no?></td>
													
														<td style="text-align:center"><?=$design_array[$design_array[$i]]['model_name']?></td>
														<td style="text-align:center"><?=$design_array[$design_array[$i]]['client_name']?></td>
														 
														<td style="text-align:center"><?=$design_array[$design_array[$i]]['finish_name']?> </td>
														<td style="text-align:center"><?=$design_array[$design_array[$i]]['size_type_cm']?> 
														</td>
														
													 	<td style="text-align:center">
															<?=$design_array[$design_array[$i]]['no_of_boxes']?> 
														</td>
													 	 
													 	 
													 
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
									<th style="text-align:center;"><?=$Total_box?></th>
								 
								</tr>
								 
							</table>
									
				
								
							 
	 	 
		
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