<?php 
$this->view('lib/header'); 
$no_of_container 	= $invoicedata->no_of_container;
$container_size 	= $invoicedata->container_size;
$exportinvoice_no 	= $invoicedata->exportinvoice_no;
 $export_date = date('d/m/Y',strtotime($invoicedata->export_date));
 $export_ref_no =  ($invoicedata->export_ref_no);
  
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
									<h3>Loading Detail</h3>
							</div>
						</div>
					</div>
				 
					<div class="row">
						<div class="col-sm-12">
							<div class="panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> Loading Detail	
								</div>
                                
								<div class="panel-body">
								<div class="form-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="createloading_form" id="createloading_form">
											<input type="hidden" name="no_of_container" id="no_of_container" value="<?=$no_of_container?>" />
											<input type="hidden" name="container_size" id="container_size" value="<?=$container_size?>" />
											<input type="hidden" name="exportinvoice_no" id="exportinvoice_no" value="<?=$exportinvoice_no?>" />
											<input type="hidden" name="export_date" id="export_date" value="<?=$invoicedata->invoice_date?>" />
											<table width="100%"  cellspacing="0" cellpadding="0">
											<tr>
												<td style="text-align:center" colspan="10">
													Loading Detail of <?=$no_of_container?>x<?=$container_size?> Invoice No. <?=$exportinvoice_no?> Dated <?=$export_date?>
												</td>
											</tr>
											<tr>
												<td style="font-weight:bold;text-align:center" width="3%">SR</td>
												<td style="font-weight:bold;text-align:center" width="14%">Pi No</td>
												<td style="font-weight:bold;text-align:center" width="10%">Container No</td>
												<td style="font-weight:bold;text-align:center" width="10%">Seal No</td>
												<td style="font-weight:bold;text-align:center" width="10%">Size</td>
												<td style="font-weight:bold;text-align:center" width="10%">Pallets</td>
												<td style="font-weight:bold;text-align:center" width="10%">Box</td>
												<td style="font-weight:bold;text-align:center" width="10%">Batch</td>
												<td style="font-weight:bold;text-align:center" width="13%">Select Design</td>
												<td style="font-weight:bold;text-align:center" width="10%">Image</td>
										 	</tr>
											<?php
										 	$no=1;
											$j=0;
											  $m=0;
											  $pi_array=array();
											for($i=0; $i<(count($loadingdata));$i++)
											{
											$rowspan = (($loadingdata[$i]->rowspan_no)>1)?($loadingdata[$i]->rowspan_no):'';
											?>
												<tr>
													<td style="text-align:center"><?=$no?></td>
													<?php 
													if(!in_array($loadingdata[$i]->container_detail,$pi_array))
													{
														$j++;
													?>
													<td style="text-align:center" rowspan="<?=$rowspan?>">
														<input type='text' name='pi_no[]' id='pi_no<?=$j?>' class="form-control" placeholder="Pi No" value="<?=$loadingdata[$i]->pi_no?>" />
														
														<input type='hidden' name='helparray[]' id='helparray<?=$j?>' value="<?=$j?>" />
														
													 	<input type='hidden' name='container_detail[]' id='container_detail<?=$j?>'  value="<?=$loadingdata[$i]->container_detail?>"   />
														<input type='hidden' name='seal_no[]' id='seal_no<?=$j?>'  value="<?=$loadingdata[$i]->seal_no?>"   />
														<input type='hidden' name='rowspan_no[]' id='rowspan_no<?=$j?>'  value="<?=$loadingdata[$i]->rowspan_no?>"   />
													</td>
												 	<td style="text-align:center" rowspan="<?=$rowspan?>">
														<?=$loadingdata[$i]->container_detail?>
													</td>
													<td style="text-align:center"  rowspan="<?=$rowspan?>">
														<?=$loadingdata[$i]->seal_no?>
													</td>
													<?php 
														array_push($pi_array,$loadingdata[$i]->container_detail);
													}
													 ?>
													<td style="text-align:center" >
														<?=$loadingdata[$i]->description?>
													</td>
													<td style="text-align:center">
														 <input type='text' name='pallet<?=$j?>[]' id='pallet<?=$m?>'  value="<?=$loadingdata[$i]->pallet?>" style="width:100px" onkeyup="cal_boxes(<?=$m?>)"/>
													</td>
													<td style="text-align:center" >
														<span id="boxes_html<?=$m?>"><?=$loadingdata[$i]->boxes?></span>
													</td>
													<td style="text-align:center" >
														<input type='text' name='batch<?=$j?>[]' id='batch<?=$m?>' class="form-control" placeholder="Batch" value="<?=$loadingdata[$i]->batch_no?>"/>
														
													 	<input type='hidden' name='product_id<?=$j?>[]' id='product_id<?=$m?>'  value="<?=$loadingdata[$i]->product_id?>"/>
														<input type='hidden' name='seriesgroup_id<?=$j?>[]' id='seriesgroup_id<?=$m?>'   value="<?=$loadingdata[$i]->seriesgroup_id?>"/>
														<input type='hidden' name='description<?=$j?>[]' id='description<?=$m?>'  value="<?=$loadingdata[$i]->description?>"/>
														<input type='hidden' name='boxes<?=$j?>[]' id='boxes<?=$m?>'  value="<?=$loadingdata[$i]->boxes?>"   />
														<input type='hidden' name='box_per_pallet<?=$j?>[]' id='box_per_pallet<?=$m?>'  value="<?=$loadingdata[$i]->box_per_pallet?>"   />
													</td>
													<td style="text-align:center" class="tdcls">
														<select class="select2" id="design_id<?=$m?>" name="design_id<?=$j?>[]" onchange="load_image(this.value,<?=$m?>)">
															<option value="">Select Design</option>
															<?php 
																foreach($loadingdata[$i]->design as $designrow)
																{
																	$sel = '';
																	if($loadingdata[$i]->design_id == $designrow->packing_model_id)
																	{
																		$sel = 'selected="selected"';
																	}
																	echo "<option ".$sel." value='".$designrow->packing_model_id."'>".$designrow->model_name."</option>";
																}
															?>
														</select> 
													</td>
													 <td style="text-align:center" >
														  <img src="<?=DESIGN_PATH.$loadingdata[$i]->design_file?>" id="view_image<?=$m?>" height="50px" width="50px"  />
													</td>
											 </tr>

												<?php
												$m++;
												
												$no++;
									 }
									?>		 
									</table>
						
								<div style="padding: 14px;" >	
							 		<div class="form-group"  >
							 			<button type="submit" name="submit" class="btn btn-success">
							 				Save
							 			</button>
										<a href="<?=base_url().'exportinvoice_listing'?>" class="btn btn-danger">
											Cancel
										</a>
									</div>	
								</div>	
									 		
									<input type="hidden" name="export_loading_id" id="export_loading_id" value="<?=$invoicedata->export_loading_id?>"/>			
									<input type="hidden" name="export_invoice_id" id="export_invoice_id" value="<?=$invoicedata->exportinvoice_id?>"/>			
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
<div id="myFumigation" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Fumigation</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="fumigation_add" id="fumigation_add">
				<div class="modal-body">
                
				    <div class="field-group">
 						<input type="text" placeholder="Fumigation Name" id="fumigation_name" class="form-control" name="fumigation_name" title="Enter Fumigation "/>
				    </div>                
				     
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>
<div id="mypallet" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Pallet Cap</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="pallet_cap_add" id="pallet_cap_add">
				<div class="modal-body">
                
				    <div class="field-group">
 						<input type="text" placeholder="Pallet Cap" id="pallet_cap" class="form-control" name="pallet_cap" title="Enter Pallet Cap "/>
				    </div>                
				     
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>

<script>
 $("#pallet_cap_add").validate({
		rules: {
			pallet_cap: {
				required: true
			}
		},
		messages: {
			pallet_cap: {
				required: "Enter Pallet cap"
			}
		}
	});
$("#pallet_cap_add").submit(function(event) {
	event.preventDefault();
	if(!$("#pallet_cap_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'pallet_cap_list/manage';
	$.ajax({
            type: "post",
            url: url,
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
				 
				   unblock_page("success","Sucessfully Inserted.");
					$("#pallet_cap_add").trigger('reset');
					$("#mypallet").modal('hide');
					$("#pallet_cap_id").append('<option value="'+obj.pallet_cap_id+'">'+obj.pallet_cap_name+'</option>');
					$("#pallet_cap_id").val(obj.pallet_cap_id).trigger('change') 
				}
				else if(obj.res==2)
				{
					unblock_page("info","Already Added.");
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

$("#fumigation_add").validate({
		rules: {
			fumigation_name: {
				required: true
			}
		},
		messages: {
			fumigation_name: {
				required: "Enter Fumigation"
			}
		}
	});
$("#fumigation_add").submit(function(event) {
	event.preventDefault();
	if(!$("#fumigation_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'fumigation_list/manage';
	$.ajax({
            type: "post",
            url: url,
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
				   unblock_page("success","Sucessfully Inserted.");
				  $("#fumigation_add").trigger('reset');
				  $("#myFumigation").modal('hide');
				 $("#fumigation_id").append('<option value="'+obj.fumigation_id+'">'+obj.fumigation_name+'</option>');
				 $("#fumigation_id").val(obj.fumigation_id).trigger('change')
				}
				else if(obj.res==2)
				{
					unblock_page("info","Already Added.");
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

function cal_boxes(i)
{
	var pallet = $("#pallet"+i).val();
	var box_per_pallet = $("#box_per_pallet"+i).val();
	 $("#boxes"+i).val(pallet * box_per_pallet);
	$("#boxes_html"+i).html(pallet * box_per_pallet);
}
$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
 
 $(".select2").select2({
 	  width:  '127px'
});  

function load_image(val,i)
{
	block_page();
	  $.ajax({ 
              type: "POST", 
              url: root+"create_loading/design_image",
              data: {
					"design_id" : val 
			  }, 
              cache: false, 
              success: function (data) {
				 // console.log(data)
				  if(data != "")
				  {
					$("#view_image"+i).show();
					$("#view_image"+i).attr('src',root+'upload/'+data);
				  }
				  else
				  {
					  $("#view_image"+i).hide();
				  }
				unblock_page("","");
			  }
	 });
}

$("#createloading_form").submit(function(event) {
	event.preventDefault();
	var helparray = document.getElementsByName('helparray[]');
	var pi_no  = document.getElementsByName('pi_no[]');
	 for (var j = 0; j < helparray.length; j++) 
	 {
		 if(pi_no[j].value=="")
		 {
		 	pi_no[j].focus();
		 	return false;
		 }	
	 
		var batch = document.getElementsByName('batch'+helparray[j].value+'[]');
		var design_id = document.getElementsByName('design_id'+helparray[j].value+'[]');
		for (var i = 0; i < batch.length; i++) 
		{
			if(batch[i].value=="")
			{
				batch[i].focus();
				return false;
			}	
			else if(design_id[i].value=="")
			{
				design_id[i].focus();
				toastr["error"]("Select Design")
				return false;
			}	
		}
	 }
	 
	 block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'create_loading/manage',
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
				    unblock_page("success","Loading Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'viewloading/index/'+obj.id },1000);
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
 
 