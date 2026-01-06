<?php 
$this->view('lib/header'); 
$no_of_container 	= $invoicedata->no_of_container;
$container_size 	= $invoicedata->container_size;
$export_date = date('d/m/Y',strtotime($invoicedata->invoice_date));
 $exportinvoice_no =$invoicedata->export_invoice_no;
 $export_ref_no =  ($invoicedata->export_ref_no);
  $_SESSION['loading_content'] = '';
 $_SESSION['exportinvoice_no'] = '';
 ?>
<script>
function view_pdf(no)
{
	
	if(no==1)
	{
		window.open(root+"loadingpdf/view_pdf", '_blank');
	}
	else
	{ 
		//window.location= root+"loadingpdf/view_pdf";
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
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
									<h3>View Loading Detail</h3>
									<div class="pull-right form-group">
										<div class="col-sm-5">
											<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
												<span class="caret"></span></button>
													<ul class="dropdown-menu">
													 	<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Loading Pdf" href="<?=base_url('loadingpdf/index/'.$invoicedata->export_invoice_id)?>" target="_blank" ><i class="fa fa-eye"></i> Dispatch File</a>
														</li>
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="<?=base_url('Without_shade_con/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Without Shade</a>
														</li>
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (KG)" href="<?=base_url('Without_image_con/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Without Image</a>
														</li>
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (KG)" href="<?=base_url('With_thickness_con/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> With Thickness</a>
														</li>
														<li>
															<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="<?=base_url('Without_pallet_con/index/'.$invoicedata->export_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Without Pallet</a>
														</li>
													</ul>
										</div>	
										</div>
																			
									<div class="col-sm-4">
											 <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				 
					<div class="row">
						<div class="col-sm-12">
						
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
										View Loading Detail	
								</div>
                                
								<!--<div class="panel-body">
								<div class="form-body">-->
									<?php ob_start();?> 
									
								 <div class="profile-pic" style="margin-top:80px;">
										
									<div class="edit pull-right"> 
										<a href="javascript:;" style="color:#fff" class="invoice_edit_btn3 btn btn-primary" onclick="editableloading_table();"><i class="fa fa-pencil fa-lg"></i> Edit</a> 
										<a href="javascript:;" class="invoice_update_btn3 btn btn-success" style="display:none;color:#fff" onclick="edit_invoice_loadingpdf();">Save</a> 
									</div>
								
							
						
								<div class="save_invoice_html">
									<?php 
									if(!empty($invoice_html_data))
									{
										echo $invoice_html_data->invoice_html;
									}
									else
									{
										?>
									
									<table cellspacing="0" border="1" cellpadding="0"  width="100%" class="main_table invoice_edit_cls3" contenteditable="false">
									 	 <tr>
										  <td  width="60%" rowspan="2" style="border-right:none;">
										     <img src="<?=base_url().'upload/'.$company_detail[0]->s_image?>" style="height: 100px;"  />
									        <br>
											</td>
											<td width="40%" style="text-align:right;border-bottom:none;border-left:none;">
												<div style="font-size:30px;color:#0072B9"><strong>Dispatch File </strong></div>
 
											</td>
											
									    </tr>
										<tr>
											 <td style="text-align:right;border-top:none;border-bottom:none;border-left:none;font-size:13;vertical-align:top;color:#0072B9">
												 
												<span><strong>Export Invoice No : <?=$invoicedata->export_invoice_no?></strong> <br>  
												<strong>Date : <?=$export_date?>  </strong> <br> 
												<strong>Container Detail : 
												<?php
												if(!empty($invoicedata->container_twenty))
												{
													echo $invoicedata->container_twenty.' X 20 FCL';
												}
												if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
												{
														echo ",";
												}
												if(!empty($invoicedata->container_forty))
												{
													echo  $invoicedata->container_forty.' X 40 FCL';
												}
												 ?> </strong>
												</span>
											</td>
										</tr>
								</table>
											<table width="100%"  cellspacing="0" cellpadding="0" class="main_table invoice_edit_cls3" contenteditable="false">
											 
										  
											<tr>
												<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="4%">SR</td>
											 	<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="14%">Container No</td>
												<!--<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="9%">Truck No</td>-->
												<!--<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="9%">Seal No</td>-->
												<!--<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="9%">Self Seal No</td>-->
												<!--<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="13%">Pallet No</td>-->
												<!--<td style="font-weight:bold;text-align:center" width="7%">Box Design Name</td>-->
											
											    <td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="19%">Design Image</td>
											    	<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="14%">Size</td>
												<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="14%"> Design Name</td>
											 	
											 	<!--<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="7%"> Shade No</td>-->
												<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="8%"> Batch No</td>
											 	<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="8%"> Finish </td>
												
												<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="5%">Pallet per box</td>
												<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="7%">Pallets</td>
												<td style="font-weight:bold;text-align:center;background-color:#C7D9F1" width="7%">Box</td>
											 
										 	</tr>
											<?php
									 
											$no=1;
											$con_array =array();
											$total_pallet = 0;
										 	for($i=0; $i<count($product_data);$i++)
											{
											   
													$sample_str = '';
													
											  	?>
												<tr>
													<?php
													if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														
														$netweight = $product_data[$i]->updated_net_weight;
														$grossweight = $product_data[$i]->updated_gross_weight;
														 
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														
															if(empty($sample_str))
															{
																$sample_container = 1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																		$sample_str .= '<tr>
																						<td style="text-align:center">
																						 
																						 </td>
																						 <td style="text-align:center">
																						 	'.$sample_row->product_size_id.'
																						 </td>
																						
																						 <td  style="text-align:center">
																						 	 	'.$sample_des.'
																						 </td>
																						  <td  style="text-align:center">
																						 	 
																						 </td>
																						  <td  style="text-align:center">
																						 	 
																						 </td>
																						  <td  style="text-align:center">
																						 	 
																						 </td>
																				
																						 <td style="text-align:center">
																						 	'.$sample_row->no_of_pallet.'
																						 </td>
																					 	 <td style="text-align:center">
																						 	'.$sample_row->no_of_boxes.'
																						 </td>
																 						</tr> ';
																		$total_pallet		+= $sample_row->no_of_pallet;
																		$Total_sqm 		+= $sample_row->sqm;
																		$Total_box 		+= $sample_row->no_of_boxes;
																	 $netweight 	 += $sample_row->netweight;	 
																	 $grossweight += $sample_row->grossweight;
																 } 
																 
																$rowcon_no = ($rowcon_no == 1)?($rowcon_no +1):$rowcon_no; 
															}
														 
												 	?>
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$no?>
													</td> 
													 
													 <td style="text-align:center" rowspan="<?=$rowcon_no?>">
														 <?=$product_data[$i]->container_no?>
													</td> 
													
													<!--<td style="text-align:center" rowspan="<?=$rowcon_no?>">-->
													<!--	 <?=$product_data[$i]->truck_no?>-->
													<!--</td>-->
													<!-- <td style="text-align:center" rowspan="<?=$rowcon_no?>">-->
													<!--	 <?=$product_data[$i]->seal_no?> -->
													<!--</td>-->
													<!-- <td style="text-align:center" rowspan="<?=$rowcon_no?>">-->
													<!--	 <?=$product_data[$i]->self_seal_no?> -->
													<!--</td> -->
													 <!--<td style="text-align:center" rowspan="<?=$rowcon_no?>"> -->
														<!--<?=$product_data[$i]->remark?>-->
													 <!--</td>  -->
													 <!--<td style="text-align:center" rowspan="<?=$rowcon_no?>"> 
														<?=$product_data[$i]->box_design_name?>
													 </td> -->
													<?php 
														array_push($con_array,$product_data[$i]->con_entry);
														$no++;
													}
													else
													{
														$sample_container++;
													}
													?>
													<td style="text-align:center">
													    	<img src="<?=DESIGN_PATH.$product_data[$i]->design_file?>"    style="width:85px" >
													
												 	</td> 
												 		<td style="text-align:center">
												 		    	<?=$product_data[$i]->size_type_mm?>
												 		    </td> 
													<td style="text-align:center">
														<?=$product_data[$i]->model_name?>
													</td> 
													<!--<td style="text-align:center">
														<?=$product_data[$i]->client_name?>
													</td> -->
													<!--<td style="text-align:center">-->
													<!--	<?=$product_data[$i]->shade_no?>-->
													<!--</td> -->
													<td style="text-align:center">
														<?=$product_data[$i]->batch_no?>
													</td> 
													<td style="text-align:center"> 
														<?=$product_data[$i]->finish_name?>
													 </td> 
													 <!-- <td style="text-align:center"> 
													<p style="margin: 0 auto;width:120px;height:120px;overflow:hidden;position: relative;">
																<img src="<?=DESIGN_PATH.$product_data[$i]->design_file?>"  style="width:100px;margin: auto; top: 0px; left: 0; right: 0; bottom: 0; position: absolute;"  alt="" class="tiles-img">
															</p>	
													 </td> -->
													
													 
														<?php 
														$count = explode(",",$product_data[$i]->export_make_pallet_no);
														$export_rowspan = count($count);
														if(!empty($product_data[$i]->pallet_ids) || $product_data[$i]->make_pallet_no == 1)
														{
															if(!empty($product_data[$i]->pallet_ids))
															{
																$pallet_ids = explode(",",$product_data[$i]->pallet_row);
															echo  '
															<td  style="text-align:center" class="text-center" rowspan="'.count($pallet_ids).'">
																-
															</td>
															<td  style="text-align:center" class="text-center" rowspan="'.count($pallet_ids).'">
																'.$product_data[$i]->make_pallet_no.'     
															</td>';
															$total_pallet += $product_data[$i]->make_pallet_no;
															}
														}
														else if(!empty($product_data[$i]->export_make_pallet_no))
														{
															
															echo '<td class="text-center" rowspan="'.$export_rowspan.'">
																			-
																	</td>
																	<td class="text-center" rowspan="'.$export_rowspan.'">
																			'.$product_data[$i]->export_half_pallet.'  
																	</td>';
															$total_pallet += $product_data[$i]->export_half_pallet;																	
														}
														else if(!empty($product_data[$i]->production_mst_id) || empty($product_data[$i]->pallet_row))
														{
															if(empty($product_data[$i]->export_half_pallet))
															{
															echo '  <td style="text-align:center" > ';
															if($product_data[$i]->origanal_pallet > 0)
															{
																echo $product_data[$i]->boxes_per_pallet;
															
															}
															else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
															{
																if(empty($product_data[$i]->export_half_pallet))
																{
																	echo $product_data[$i]->box_per_big_pallet.'<br>'.$product_data[$i]->box_per_small_pallet;
																}
															}
															else
															{
																echo "-";
															}
															echo '  </td> 
															<td style="text-align:center" > ';
															if($product_data[$i]->origanal_pallet > 0)
																{
																	echo $product_data[$i]->origanal_pallet;
																	$total_pallet += $product_data[$i]->origanal_pallet;
																}
																else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
																{
																	echo $product_data[$i]->orginal_no_of_big_pallet.'<br>'.$product_data[$i]->orginal_no_of_small_pallet;
																	$total_pallet += $product_data[$i]->orginal_no_of_big_pallet;
																	$total_pallet += $product_data[$i]->orginal_no_of_small_pallet;
																}
																else
																{
																	echo "-";
																}
															 
															echo '  </td> ';
															}
														}
														?>
													
												 
													<td style="text-align:center"> 
														<?=$product_data[$i]->no_of_boxes?>
													 </td> 
												 
												   
												</tr>

										 		<?php
												echo $sample_str;
											    $Total_sqm 		+= $product_data[$i]->no_of_sqm;
											    $Total_box 		+= $product_data[$i]->no_of_boxes;
												$Total_ammount 	+= $product_data[$i]->product_amt;
													array_push($size_array,$product_data[$i]->export_loading_trn_id);
										 		 
										 	  
											}
										 
									?>		

												<tr>
													<td style="text-align:center"> </td>
													<td style="text-align:center"> </td>
												 	<!--<td style="text-align:center"> </td>-->
													<td style="text-align:center"> </td>
													<!--<td style="text-align:center"> </td>-->
													<!--<td style="text-align:center"> </td>-->
													<td style="text-align:center"> </td>
													<td style="text-align:center"> </td>
													<td style="text-align:center"> </td>
													<!--<td style="text-align:center"> </td>-->
													<td style="text-align:center"> </td>
												
	
													<td style="text-align:right" >
														 <strong>Total</strong>
													</td>
													<td style="text-align:center">
														<strong><?=$total_pallet?></strong>
													</td>
													<td style="text-align:center" >
														<strong><?=$Total_box?></strong>
													</td>
												 
											 </tr>
											 <br>
											 <tr>
													<td colspan="2">
													<strong> Remarks : </strong>
													</td>
													<td colspan="14" style="text-align:left">
														
													</td>
													
											</tr>
										
									</table>
									 <?php
								}
								?>
              </div>
            </div>
									<?php
									 $output = ob_get_contents(); 
									$_SESSION['exportinvoice_no'] = $invoicedata->export_invoice_no;
									 $_SESSION['loading_content'] = $output;
									  
									 if($mode=="1")
									 {
										 echo "<script>view_pdf(0)</script>";
									 }
								?>
								
<!--              </div>
            </div>-->
						 
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
function delete_editable(export_invoice_id)
{
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
       url: root+"performa_invoice_pdf/delete_editable",
       data:
	   {
			"performa_invoice_id"	: export_invoice_id,
			"performa_invoice_pdf"	: 'export_invoice',
			"invoiceview"	        : 'export_invoice'
	   }, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
  }
		});
}
function editableloading_table()
{
	$(".invoice_edit_cls3").attr("contenteditable",true)
	$(".invoice_edit_btn3").hide();
	$(".invoice_update_btn3").show();
}

function edit_invoice_loadingpdf()
{
	 block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"exportinvoice/loadingpdf_html_update",
       data:
	   {
			"export_invoice_id"	: <?=$invoicedata->export_invoice_id?>, 
			"loadingpdf_html"		: $(".save_invoice_html").html()  
		}, 
       success: function (response)
	   {
			 unblock_page("success","Loading invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
  }); 
}

</script> 