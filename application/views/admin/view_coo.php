<?php 
$this->view('lib/header');
 
 $export 					= ($invoicedata->exporter_detail);
 $consign_name 				= $invoicedata->c_companyname;
 $consign_address 			= ($invoicedata->consign_address);
 $buyer_other_consign 	 	= ($invoicedata->buyer_other_consign);
 $flight_name_no			= $invoicedata->flight_name_no;   		
 $place_of_receipt			= $invoicedata->place_of_receipt;   		
 $final_destination			= $invoicedata->final_destination;   		
 $export_port_loading		= $invoicedata->port_of_loading;   		
 $port_of_discharge			= $invoicedata->port_of_discharge;   		
 ?>	
 <style>
.profile-pic {
	position: relative;
	 
	padding: 2px;
}

.profile-pic:hover .edit {
	display: block;
	
}
.profile-pic:hover
{
	border: 1px solid #036df0;
}
.edit {
	padding-top   : 7px;	
	padding-right : 7px;
	position	  : fixed;
	right		  : 37px;
	top			  : 265px;
	display		  : none;
}

.edit a {
	color: blue;
}
</style>
 <script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"view_coo/viewpdf", '_blank');
	}
	else if(no==2)
	{
		window.open(root+"view_coo/viewdoc", '_blank');
	}
	else{
		window.location= root+"view_coo/viewpdf";
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
									<a href="<?=base_url().'customer_listing'?>">Customer Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
									<h3> COO</h3>
									<div class="pull-right form-group">
										<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);" ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
										<a class="btn btn-primary tooltips" data-title="View in Doc" href="javascript:;" onclick="view_pdf(2);" ><i class="fa fa-file"></i> Export Doc</a>
									</div>
							</div>
						</div>
					</div>
			 		<div class="row">
						<div class="col-sm-12">
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									View COO
								</div>
                                
								<div class="panel-body">
								<div class="form-body">
									 	<div class="" style="padding:10px;" >
										  <?php ob_start();?>
										  <div class="profile-pic">
											<div class="edit pull-right">
												<a href="javascript:;" style="color:#fff;font-size:12px" class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i class="fa fa-pencil fa-lg"></i>  Edit</a>
												<a href="javascript:;" class="invoice_update_btn btn btn-success" style="display:none;color:#fff" onclick="edit_invoice();">Save</a>
											</div>
											<div class="save_invoice_html">
											<?php 
								 
								if(!empty($html_data))
								{
									echo $html_data->invoice_html;
								}
								else
								{
									?>
											<table cellspacing="0" cellpadding="0"  style="border:1px solid #333;padding: 5px;" class="pdf_class invoice_edit_cls"  width="100%">
												<tr>
													<td style="padding:0px" width="34%"></td>
													<td style="padding:0px" width="33%"></td>
													<td style="padding:0px" width="33%"></td>
													 
												</tr>
												<tr>
													<td colspan="2">
														<strong>SHIPPER</strong>
													</td>
													<td rowspan="4">
														  
													</td>
												</tr>
												<tr>
													<td colspan="2">
														 <?=$export?>
													</td>
													 
												</tr>	
											  
												<tr>
													<td colspan="2" style="vertical-align:top;">
														<strong>CONSIGNEE</strong> <br>
														 <?=$consign_address?>
													</td>
													 
												</tr>	
												<tr>
													<td colspan="2" style="vertical-align:top;height:100px">
														<strong>NOTIFY</strong> <br>
														<?=$buyer_other_consign?>	
													</td>
													 
												</tr>	
												<tr>
													<td colspan="2" style="vertical-align:top;height:50px">
														<strong>VESSEL AND VOYAGE NO:</strong> <br>
														<?=$flight_name_no?>	
													</td>
													<td style="vertical-align:top;">
														 <strong>PLACE OF RECEIPT: </strong> <br>
														<?=$place_of_receipt?>	
													</td>
													 
												</tr>	
												<tr>
													<td style="vertical-align:top;height:50px">
														<strong>PORT OF LOADING:</strong> <br>
														 <?=$export_port_loading?>	
													</td>
													<td style="vertical-align:top;height:50px">
														<strong>PORT OF DISCHARGE:</strong> <br>
														<?=$port_of_discharge?>
													</td>
													<td style="vertical-align:top;height:50px" >
														 <strong>PLACE OF DELIVERY:  </strong> <br>
														<?=$final_destination?>	
													</td>
													 
												</tr>	
												 
											</table>
								<table cellspacing="0" cellpadding="0"   style="border:1px solid #333;padding: 5px;" class="pdf_class invoice_edit_cls"  width="100%">
												 
												<tr>
												 	<td width="20%">
													 
									<?php
										 	$Grand_Total_pallet = 0;
											$Total_pallets = 0;
											$Total_sqm = 0;
											$Total_box = 0;
											$cntnet_weight=0;
											$Total_ammount = 0;
											$setcontainer = 0;
											$packingtrn_array = array();
											$con_entry = 1;
										 	$con_array = array();
											$conarray = array();
											$conarray1 = array();
											$sizearray = array();
											$sizearray1 = array();
											$no_of_row = 15;
											$series_name_array 	= array();
											 	$totalnetweight 	= 0 ;	
												$totalgrossweight   = 0; 
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
												$n = 1;
												 
												for($i=0; $i<count($product_data);$i++)
												{
													 
													$total_pallets  = floatval($product_data[$i]->total_ori_pallet);
													$Total_pallets  = floatval($product_data[$i]->total_ori_pallet);
													$sample_str = '';	
													
													  $series_detail =  $product_data[$i]->custdescriptiongoods.'&nbsp; HSN Code - '.$product_data[$i]->custhsnccode; 
																		
													  
													if(!in_array(trim($series_detail), $series_name_array))
													{
														
														array_push($series_name_array,$series_detail);
														//array_push($water_array,$product_data[$i]->water_text);
													}
												 	if(!in_array($product_data[$i]->con_entry,$con_array))
													{
														$rowcon_no = ($product_data[$i]->rowspan_no > 1)?$product_data[$i]->rowspan_no:'';
														$total_package = $product_data[$i]->total_package;
														$totalpackage = $product_data[$i]->total_package;
														
														//$Total_pallets  = $product_data[$i]->total_ori_pallet;
														$net_weight 	= $product_data[$i]->total_ori_net_weight;
														$gross_weight 	= $product_data[$i]->total_ori_gross_weight;
													$totalnetweight 	+= $product_data[$i]->total_ori_net_weight;
													$totalgrossweight 	+= $product_data[$i]->total_ori_gross_weight;
															if(empty($sample_str))
															{
																$rowcon_no = (!empty($rowcon_no))?$rowcon_no:1;
																foreach($product_data[$i]->sample  as $sample_row)
																{
																	 $rowcon_no++;
																	
																		$sample_des = !empty($sample_row->sample_remarks)?$sample_row->sample_remarks:$sample_row->size_type_mm;
																	 	$Grand_Total_pallet  +=    floatval($sample_row->no_of_pallet);
																	 
																		$Total_sqm 		+= $sample_row->sqm;
																		$Total_box 		+= $sample_row->no_of_boxes;
																		$total_package += $sample_row->no_of_boxes;
																		$Total_ammount 	+= $sample_row->sample_amout;
																		$totalnetweight 	+= $sample_row->netweight;
																		$totalgrossweight 	+= $sample_row->grossweight;
																		$net_weight 	+= $sample_row->netweight;
																		$gross_weight 	+= $sample_row->grossweight;
																		$cntnet_weight =$sample_row->netweight;
																		 $no_of_row--;
																 }
																 
															}
													 
												 array_push($con_array,$product_data[$i]->con_entry);
													}
											    $Total_sqm 		+= $product_data[$i]->no_of_sqm;
											    $Total_box 		+= $product_data[$i]->no_of_boxes;
												$Total_ammount 	+= $product_data[$i]->product_amt;
												$no++;
											
												}
										 
												?>
							 
											 
												 
													</td>
													<td width="65%" style="vertical-align:top;"> 
													<br>
													<?=implode(",",$series_name_array)?>
													<br>
															<?php 
															echo "TOTAL ";
															if(!empty($invoicedata->container_twenty))
															{
																echo $invoicedata->container_twenty.' X 20 FCL';
															}
															if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
															{
																echo ',';
															}
															if(!empty($invoicedata->container_forty))
															{
																echo $invoicedata->container_forty.' X 40 FCL';
															}
															echo " CONTAINERS ONLY";
															?>
															<br>
															TOTAL <?=$Total_box?> BOXES
															 <br>
															 TOTAL <?=$Total_sqm?> SQM
															 <br>
														 
														 
															INVOICE NO.:
															<?=$invoicedata->export_invoice_no?> DATED <?=date('d/m/Y',strtotime($invoicedata->invoice_date))?><br>
															AS PER PROFORMA INVOICE:- <?=$invoicedata->export_ref_no?>  DT: <?=date('d/m/Y',strtotime($invoicedata->performa_date))?>
															<br>
															<?php 
															if(!empty($bldata->sb_numner))
															{
																?>
																S.BILL NO.: <?=$bldata->sb_numner?> DATE: <?=date('d/m/Y',strtotime($invoicedata->sb_date))?>
															<?php 
															}
																?>
															<br>
															GROSS WEIGHT : <?=$totalgrossweight?>  KGS	<br>
															NET WEIGHT      : <?=$totalnetweight?> KGS  

													</td>
													<td width="15%" style="text-align:center">
															
														 
															
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
									
									 $_SESSION['coo_invoice_no'] = $invoicedata->export_invoice_no;
									 $_SESSION['coo_content'] = $output;
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
 
<?php $this->view('lib/footer');  ?>
<script>
function editable_table()
{
	$(".invoice_edit_cls").attr("contenteditable",true)
	$(".invoice_edit_btn").hide();
	$(".invoice_update_btn").show();
}
function edit_invoice()
{
	 block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"customerinvoiceview/coo_html_update",
       data:
	   {
			"customer_invoice_id"	: <?=$invoicedata->customer_invoice_id?>, 
			"invoice_html"			: $(".save_invoice_html").html()  
		}, 
       success: function (response)
	   {
			 unblock_page("success","COO UPDATED"); 
			 setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });

$("#createbl_form").validate({
		rules: {
			booking_no: {
				required: true
			}
		},
		messages: {
			booking_no: {
				required: "Enter Booking No"
			}
		}
	});
$("#createbl_form").submit(function(event) {
	event.preventDefault();
	if(!$("#createbl_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'create_bl_draft/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				    $("#createbl_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'bldraft_listing'; },1500);
			   }
			   else  if(obj.res==2)
			   {
				    $("#createbl_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'bldraft_listing'; },1500);
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
 
 