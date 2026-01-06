<?php 
 $this->view('lib/header'); 
 $_SESSION['label_content'] = '';
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
								<h3>Envelope Print
									 <div class="pull-right form-group">
										<a class="btn btn-info tooltips" data-title="Print" href="javascript:;" onclick="PrintMe('label_content');" ><i class="fa fa-print"></i> Print All</a>
									</div>
								</h3>
								
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							 
							  
								<div id="label_content">
								<?php
								$con_array 			= array();
										if(!empty($set_container))
										{		
												$container_twenty = intval($invoicedata->container_twenty);
												$container_forty  = $container_twenty + intval($invoicedata->container_forty);
												$no = 1;
										  	for($i=0; $i<count($set_container);$i++)
											{
													if(!in_array($set_container[$i]->con_entry,$con_array))
													{
														?>
														
														<a class="btn btn-info tooltips" data-title="Print" href="javascript:;" onclick="PrintMe('main_content<?=$set_container[$i]->con_entry?>');" ><i class="fa fa-print"></i> <?=$set_container[$i]->container_no?></a>
														<br>
														<br>
														 
														<div id="main_content<?=$set_container[$i]->con_entry?>" style="width:9.50in;height:4.50in;border:1px solid black;">
															<div class="address ui-widget-content address-item" id="address_content" style="position: absolute;width:3.5in;font-size:20px;line-height:30px;margin-top:1.00in;margin-left:4.00in;font-family:Calibri;">
															<br>
																<div style="margin-left:20px;">
																	<?php 
																	echo "	  Truck No:<strong>".$set_container[$i]->truck_no."</strong>";
																	echo "<br>Container No:<strong>".$set_container[$i]->container_no."</strong>";
																	echo "<br>Line Seal No:<strong>".$set_container[$i]->seal_no."</strong>";
																	echo "<br>RFID:<strong>".$set_container[$i]->rfidseal_no."</strong>";
																	echo "<br>LR Number:<strong>".$set_container[$i]->lr_no."</strong>";
																	echo "<br>Driver Mobile No :<strong>".$set_container[$i]->mobile_no."</strong>";
																	array_push($con_array,$set_container[$i]->con_entry);
																	?>
																</div>	
															</div>
					 
														</div>
													 <br>
													 <br>
													 <br>
														
													<?php
													if($no % 2 == 0){ echo " <pagebreak />	";}
													$no++;
													}
 										 
										 
									 
									 
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
  
  <script>
function filterbystatus(val)
{
	if(val==1)
	{
		$(".withouthtml").show();
		$(".withhtml").hide();
	}
	else
	{
		$(".withouthtml").hide();
		$(".withhtml").show();
	}
} 
function PrintMe(DivID)
{
	$("#maindiv").attr("style","border:none;");
	var disp_setting="toolbar=yes,location=no,";
	disp_setting+="directories=yes,menubar=yes,";
	disp_setting+="scrollbars=yes,width=800, height=600, left=100, top=25";
	var content_vlue = document.getElementById(DivID).innerHTML;
	var docprint=window.open("","",disp_setting);
	docprint.document.open();
	docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
	docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
	docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
	docprint.document.write('<head><title>Billing360</title>');
	docprint.document.write('<style type="text/css"> @media print { @page { size: portrait;margin:0px;}}  body { display: block;padding-top: 0px;height:4.5in;width: 4.5in;margin:auto; vertical-align: middle; -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg);-o-transform: rotate(90deg);filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);}</style>');
	docprint.document.write('</head><body onLoad="self.print()">');
	docprint.document.write(content_vlue);
	docprint.document.write('</body></html>');
	docprint.document.close();
	docprint.focus();
	$("#duplicat_data").hide();
	$('#table_head').show();
	location.reload();
 // docprint.close();
}
</script>
<?php $this->view('lib/footer'); 

echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>"; 
?>


