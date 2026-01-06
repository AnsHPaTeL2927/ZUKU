<?php 
$this->view('lib/header'); 
?>	
<style>
.wrapper1, .wrapper2{width:100%; border: none 0px RED;
overflow-x: scroll; overflow-y:hidden;}
 
.div1 {width:150%; height: 20px; }
.div2 {width:150%; 
overflow: auto;}
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td
{
	border :1px solid #333
}
</style>
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
			 				<a href="<?=base_url().'confirm_pi'?>">Change Order</a>
			 			</li>
			 	 	</ol>
			 		<div class="page-header title1">
			 			<h3>
							Change Order
							<div class="pull-right addbtn" style="display:none">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-keyboard="false" data-backdrop="static">+ Product In PI</button>
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
			 		 	</div>
                         <div class="">
			 			   <div class="panel-body form-body">
							 
								<div class="col-md-5" style="margin-bottom: 5px;">
									<label class="col-md-4 control-label" style="margin-top: 5px;">
										<strong class=""> Select Performa Invoice</strong>
									</label>
						 		 <div class="col-md-8">
										 <select class="select2" id="performa_invoice_id" name="performa_invoice_id" onchange="load_data_table(this.value)" >
											<option value="">Select Performa Invoice</option>
												<?php
												for($p=0;$p<count($allperformainvoice);$p++)
												{
													 
													 
											 	?>
													<option <?=$sel?> value="<?=$allperformainvoice[$p]['performa_invoice_id']?>"><?=$allperformainvoice[$p]['invoice_no']?></option>
												<?php
												}
												?>
										</select>
						 		 </div>     
								</div>
								<br>
								 
								<br>
								 <div class="col-md-12 show_data" style="margin-top:30px;display:none" >
								<div class="wrapper1">
									<div class="div1">
									</div>
								</div>
								<div class="wrapper2 ">
										<div class="view_report div2 col-md-12 drag-x" style=""></div>
								</div>
								</div>
					 
						   </div>
						 </div>
                     </div>
				 </div>
			 </div>
		</div>
	</div>
</div>
 
<?php 
$this->view('lib/footer');
$this->view('lib/addmodeltype'); 
 
?>
 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 1266px;overflow-x: scroll;">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"    class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Product   </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="product_form" id="product_form">
            <div class="modal-body">
                <div class="row">
					 <input type="hidden" id="performainvoice_id" name="performainvoice_id" value=""> 
					<div class="col-md-12">					
					   <div class="field-group" >
							<select class="select2" id="product_details" name="product_details" onchange="load_data(this.value,'Add','')">
								<option value="">Select Product Name</option>
								<?php
								for($p=0;$p<count($allproduct);$p++)
								{
									$thickness = (!empty($allproduct[$p]->thickness))?" - ".$allproduct[$p]->thickness." MM":"";
								 ?>
									<option value="<?=$allproduct[$p]->product_id?>"><?=$allproduct[$p]->size_type_mm.' ('.$allproduct[$p]->series_name.')'.$thickness?></option>
								<?php
								}
								
								?>
							</select>
						</div> 
					</div> 
				 	 
					<div id="productdetail"> </div>
					
					 
					<div class="col-md-4 factory_html" style="display:none">	
					 <div class="field-group">
						  <strong>Select Factory</strong> 
							<select class="select2" id="suppiler_id" name="suppiler_id" required title="Select Factory">
											<option value="">Select Factory</option>
											<?php
											foreach($all_supplier as $sup_row)
											{
												echo  '<option value="'.$sup_row->supplier_id.'">'.$sup_row->supplier_name.' '.$sup_row->company_name.'</option>';
											}
											?>
										</select>
										<label id="suppiler_id-error" class="error" for="suppiler_id">Select Factory</label>
						</div> 
					</div>						
			 	 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="+ In PI Only" id="product_submit_btn" class="btn btn-success"  /> 
			<input name="Submit" type="button" onclick="with_production_sheet()" value="+ PI & Production Sheet" id="product_submit_btn" class="btn btn-success production_sheet_btn"  /> 
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="performa_trn_id" id="performa_trn_id"/>
			<input type="hidden" name="form_check" id="form_check" value="1" />
			<input type="hidden" name="mode" id="mode" value="Add" />
			<input type="hidden" name="customer_id" id="customer_id" value="" />
			<input type="hidden" name="producation_with_status" id="producation_with_status" value="" />
			<input type="hidden"  id="container_details"   name="container_details" value=""  >
			<input type="hidden"  id="container_twenty"   name="container_twenty" value=""  >
			<input type="hidden"  id="container_forty"   name="container_forty" value=""  >
			</form>
       
    </div>
</div>
</div>
 
</div>

<script>
function cal_total()
{
	var container_forty = ($("#containerforty").val() > 0)?$("#containerforty").val():0;
	var container_twenty = ($("#containertwenty").val() > 0)?$("#containertwenty").val():0;
	$("#container_details").val(parseInt(container_forty) + parseInt(container_twenty))
}

 $(".select2").select2({
	width:"100%"
}); 
 function change_in_pi_sheet(performa_packing_id)
{
	$("#sheet_suppiler_id").html('')
	$.ajax({ 
		type: "POST", 
		url: root+"change_order/checkproduction_sheet",
		data:
		{
			"performa_packing_id"	: performa_packing_id,
	 	}, 
		success: function (response) {
			var obj = JSON.parse(response);	 
			 
			if(obj.count == 1)
			{
				$("#sheet_suppiler_id").html(obj.str);
				$("#sheet_suppiler_id").val(obj.supplier_id+' - '+obj.production_trn_id).trigger('change');
				
				change_in_pi(performa_packing_id,2);
			}
			else
			{
				$("#sheet_suppiler_id").html(obj.str);
				$("#suppiler_modal").modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		 }
		
	}); 
}
function change_in_pi(performa_packing_id,from)
{
	Swal.fire({
			title: 'Change In PI container?',
			 html:
			'20 FT FCL : <input type="text"  id="containertwenty"  name="containertwenty" value="'+$("#container_twenty").val()+'"  onkeyup="cal_total()" onblur="cal_total()" class="swal2-input" placeholder="20 FT FCL">' +
			'<br> 40 FT FCL : <input type="text"  id="containerforty" name="containerforty" value="'+$("#container_forty").val()+'" onkeyup="cal_total()" onblur="cal_total()"  class="swal2-input" placeholder="40 FT FCL"> <br> Change effect only PI',
			confirmButtonText: 'Yes, Change It',
			cancelButtonText: 'No Change.',
			showCancelButton: true,
			allowOutsideClick: false,
			showCloseButton: true,
		 	preConfirm: function () {
				return new Promise(function (resolve) {
				   resolve([
						$('#containertwenty').val(),
						$('#containerforty').val()
					])
		 	})
		},
		onOpen: function () {
			
			$('#container_twenty1').focus()
		}
		}).then(function (result) {
			 var containertwenty 	= 0;
			 var containerforty 	= 0;
			 var container_details 	= 0;
			 
			if(result.dismiss == "cancel" || result.value != undefined)
			{
				 if(result.dismiss != "cancel")
				{
					containertwenty 	= $("#containertwenty").val();
					containerforty 		= $("#containerforty").val();
					container_details 	= $("#container_details").val();
				}
				var  no_of_pallet = parseFloat($("#pallet"+performa_packing_id).val()) + parseFloat($("#done_pallet"+performa_packing_id).val());
				var  big_pallet = parseFloat($("#big_pallet"+performa_packing_id).val()) + parseFloat($("#done_big_pallet"+performa_packing_id).val());
				var  small_pallet = parseFloat($("#small_pallet"+performa_packing_id).val()) + parseFloat($("#done_small_pallet"+performa_packing_id).val());
				var  no_of_sqm = parseFloat($("#no_of_sqm"+performa_packing_id).val()) + parseFloat($("#done_no_of_boxes"+performa_packing_id).val());
				var  no_of_boxes = parseFloat($("#no_of_boxes"+performa_packing_id).val()) + parseFloat($("#done_no_of_sqm"+performa_packing_id).val());
				var  product_amt = parseFloat($("#product_amt"+performa_packing_id).val()) + parseFloat($("#done_product_amt"+performa_packing_id).val());
				var  packing_net_weight = parseFloat($("#packing_net_weight"+performa_packing_id).val()) + parseFloat($("#done_packing_net_weight"+performa_packing_id).val());
				var  packing_gross_weight = parseFloat($("#packing_gross_weight"+performa_packing_id).val()) + parseFloat($("#done_packing_gross_weight"+performa_packing_id).val());
				 	block_page();
						$.ajax({ 
						type: "POST", 
						url: root+"change_order/change_in_pi",
						data:
						{
							"no_of_pallet"		 	: no_of_pallet,
							"no_of_big_pallet"		: big_pallet,
							"no_of_small_pallet"	: small_pallet,
							"no_of_boxes"			: no_of_boxes,
							"no_of_sqm"				: no_of_sqm,
							"product_rate"		 	: $("#product_rate"+performa_packing_id).val(),
							"product_amt"		 	: product_amt,
							"packing_net_weight" 	: packing_net_weight,
							"packing_gross_weight" 	: packing_gross_weight,
							"from"					: from,
							"containertwenty"		: containertwenty,
							"containerforty"		: containerforty, 	
							"containerdetails"		: container_details,
							"performa_packing_id"	: performa_packing_id,
							"performa_invoice_id"	: $("#performa_invoice_id").val(),
							"sheet_suppiler_id"			: $("#sheet_suppiler_id").val()
						}, 
						success: function (response) {
								
							var obj = JSON.parse(response);
							if(obj.res == 1)
							{
									unblock_page("success","Data Sucessfully Changed.");
									load_data_table($("#performa_invoice_id").val());
							}				
						}
					}); 
			}
		});
}
function change_in_posheet(popacking_id,from)
{
	block_page();
	var po_pallet = parseFloat($("#po_pallet"+popacking_id).val()) + parseFloat($("#done_po_pallet"+popacking_id).val());
	var po_big_pallet = parseFloat($("#po_big_pallet"+popacking_id).val()) + parseFloat($("#done_po_big_pallet"+popacking_id).val());
	var po_small_pallet = parseFloat($("#po_small_pallet"+popacking_id).val()) + parseFloat($("#done_po_small_pallet"+popacking_id).val());
	var po_no_of_boxes = parseFloat($("#po_no_of_boxes"+popacking_id).val()) + parseFloat($("#done_po_no_of_boxes"+popacking_id).val());
	var po_no_of_sqm = parseFloat($("#po_no_of_sqm"+popacking_id).val()) + parseFloat($("#done_po_no_of_sqm"+popacking_id).val());
	var po_product_amt = parseFloat($("#po_product_amt"+popacking_id).val()) + parseFloat($("#done_po_product_amt"+popacking_id).val());
	var po_packing_net_weight = parseFloat($("#po_packing_net_weight"+popacking_id).val()) + parseFloat($("#done_po_packing_net_weight"+popacking_id).val());
	var po_packing_gross_weight = parseFloat($("#po_packing_gross_weight"+popacking_id).val()) + parseFloat($("#done_po_packing_gross_weight"+popacking_id).val());
		$.ajax({ 
		type: "POST", 
		url: root+"change_order/change_in_posheet",
		data:
		{
			"no_of_pallet"		 	: po_pallet,
			"no_of_big_pallet"		: po_big_pallet,
			"no_of_small_pallet"	: po_small_pallet,
			"no_of_boxes"			: po_no_of_boxes,
			"no_of_sqm"				: po_no_of_sqm,
			"product_rate"		 	: $("#po_product_rate"+popacking_id).val(),
			"product_amt"		 	: po_product_amt,
			"packing_net_weight" 	: po_packing_net_weight,
			"packing_gross_weight" 	: $("#po_packing_gross_weight"+popacking_id).val(),
	 		"popacking_id"			: popacking_id 
	 	}, 
		success: function (response) {
				 
			var obj = JSON.parse(response);
			if(obj.res == 1)
			{
					unblock_page("success","Data Sucessfully Changed.");
				 	load_data_table($("#performa_invoice_id").val());
			}				
		 }
		
	}); 
}  
function change_in_productionsheet(production_trn_id,from)
{
	block_page();
	
	var producation_pallet = parseFloat($("#producation_pallet"+production_trn_id).val()) + parseFloat($("#done_producation_pallet"+production_trn_id).val());
	
	var producation_big_pallet = parseFloat($("#producation_big_pallet"+production_trn_id).val()) + parseFloat($("#done_producation_big_pallet"+production_trn_id).val());
	
	var producation_small_pallet = parseFloat($("#producation_small_pallet"+production_trn_id).val()) + parseFloat($("#done_producation_small_pallet"+production_trn_id).val());
	
	var producation_no_of_boxes = parseFloat($("#producation_no_of_boxes"+production_trn_id).val()) + parseFloat($("#production_done_boxes"+production_trn_id).val());
	
	var producation_no_of_sqm = parseFloat($("#producation_no_of_sqm"+production_trn_id).val()) + parseFloat($("#production_done_sqm"+production_trn_id).val());
		$.ajax({ 
		type: "POST", 
		url: root+"change_order/change_in_productionsheet",
		data:
		{
			"no_of_pallet"		 	: producation_pallet,
			"no_of_big_pallet"		: producation_big_pallet,
			"no_of_small_pallet"	: producation_small_pallet,
			"no_of_boxes"			: producation_no_of_boxes,
			"no_of_sqm"				: producation_no_of_sqm,
		 	"production_trn_id"		: production_trn_id 
	 	}, 
		success: function (response) {
				 
			var obj = JSON.parse(response);
			if(obj.res == 1)
			{
					unblock_page("success","Data Sucessfully Changed.");
				 	load_data_table($("#performa_invoice_id").val());
			}				
		 }
		
	}); 
} 
function change_suppiler(factory_id,production_trn_id,production_mst_id)
{
	block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"change_order/change_in_production",
		data:
		{
			"no_of_pallet"		 	: $("#producation_pallet"+production_trn_id).val(),
			"no_of_big_pallet"		: $("#producation_big_pallet"+production_trn_id).val(),
			"no_of_small_pallet"	: $("#producation_small_pallet"+production_trn_id).val(),
			"no_of_boxes"			: $("#producation_no_of_boxes"+production_trn_id).val(),
			"no_of_sqm"				: $("#producation_no_of_sqm"+production_trn_id).val(),
		 	"production_trn_id"		: production_trn_id, 
			"factory_id"		 	: factory_id,
			"performa_invoice_id"	: $("#performa_invoice_id").val(),
			"production_mst_id"		: production_mst_id
	 	}, 
		success: function (response) {
				 
			var obj = JSON.parse(response);
			if(obj.res == 1)
			{
					unblock_page("success","Data Sucessfully Changed.");
				 	load_data_table($("#performa_invoice_id").val());
			}				
		 }
		
	}); 
}
function show_change_btn(input_group,btn_change_pallet,performa_packing_id)
{
	$(".input-group").attr('style','');
	$(".input-group-btn").hide();
	
	$("."+input_group+performa_packing_id).attr('style','width:100%');
	$("."+btn_change_pallet+performa_packing_id).show();
}

function remove_row(no)
 {
		if($('.rate_table tr').length > 3)
		{
			$(".appendtr"+no).remove();
			$("#row_cont").val(($('.rate_table tr:last').prev().attr("class").replace( /[^\d.]/g, '')))
			cal_product_invoice();
		}
		else
		{
			toastr["error"]("Last design can not delete.");
			return false;
		}
	 
 }
		
function with_production_sheet()
{
	$("#producation_with_status").val(1);
	$(".factory_html").show();
	$("#product_form").submit();
}
$("#product_form").validate({
		rules: {
			hsnc_code_val: {
				required: true
			},
			product_details:{
				required:true
			},
			total_container:{
				required :true
				
			}
		},
		messages: {
			hsnc_code_val: {
				required: "Select Product Code"
			},
			product_details:{
				required:"Select Product Name"
			},
			total_container:{
				required :"Enter Container",
				max: "Check Your Container"
			}
		}
	});
$("#product_form").submit(function(event)
{
	event.preventDefault();
 	if(!$("#product_form").valid())
	{
		return false;
	}
	else if($("#total_product_amt").val()<=0)
	{
		toastr['error']('Please Enter Amount');
		return false;
	}
	var inps = document.getElementsByName('design_id[]');
		for (var i = 0; i <inps.length; i++) 
		{
			var inp=inps[i];
			if(inp.value == "")
			{
				unblock_page("error","Please select design.") 
				return false;
			}
		}
		var postData= new FormData(this);
		 
		Swal.fire({
			title: 'Change In PI container?',
			 html:
			'20 FT FCL : <input type="text"  id="containertwenty"  name="containertwenty" value="'+$("#container_twenty").val()+'"  onkeyup="cal_total()" onblur="cal_total()" class="swal2-input" placeholder="20 FT FCL">' +
			'<br> 40 FT FCL : <input type="text"  id="containerforty" name="containerforty" value="'+$("#container_forty").val()+'" onkeyup="cal_total()" onblur="cal_total()"  class="swal2-input" placeholder="40 FT FCL"> <br> Change effect only PI',
			confirmButtonText: 'Yes, Change It',
			showCancelButton: true,
			allowOutsideClick: false,
			cancelButtonText: 'No Change.',
			showCloseButton: true,
			
			preConfirm: function () {
				return new Promise(function (resolve) {
				   resolve([
						$('#containertwenty').val(),
						$('#containerforty').val()
					])
				
			})
		},
		onOpen: function () {
			
			$('#container_twenty1').focus()
		}
		}).then(function (result) {
			 
			if(result.dismiss == "cancel" || result.value != undefined)
			{
				 var containertwenty  = 0;
				 var containerforty   = 0;
				 var containerdetails = 0;
				if(result.dismiss != "cancel")
				{
					containertwenty  =  $("#containertwenty").val()
					containerforty  =  $("#containerforty").val()
					containerdetails  =  $("#container_details").val()
					postData.append('containertwenty',containertwenty);
					postData.append('containerforty',containerforty);
					postData.append('containerdetails',containerdetails);
					 		 
				}
				block_page();
			$.ajax({
            type: "post",
            url:  root+'product/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
					//$("#product_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					$("#product_form").trigger('reset');  
					$("#product_details").val('').trigger('change');  
					$("#suppiler_id").val('').trigger('change');
					$(".factory_html").hide();					
					$("#myModal").modal('hide');  
					$("#factory_html").hide();  
					load_data_table($("#performainvoice_id").val());
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
			} 
	 	});
		 
});
 


$("#model_add").validate({
		rules: {
			model_name: {
				required: true
			}
		},
		messages: {
			model_name: {
				required: "Enter Design Name"
			} 
		}
	});
$("#model_add").submit(function(event) {
	event.preventDefault();
	if(!$("#model_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	postData.append("product_id",$("#productid").val());
	var string = $("#model_name").val();
	 
		var url = root+'model_list/manage';
	 
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
				   $("#design_id"+$("#row_no").val()).append('<option value="'+obj.packing_model_id+'">'+obj.model_name+'</option>');
				   $("#design_id"+$("#row_no").val()).val(obj.packing_model_id).trigger('çhange');
				    $("#finish_id").val('').trigger('change');
				    $("#modeltype").modal('hide');
					 $("#model_add").trigger('reset')
					load_finish(obj.packing_model_id,$("#row_no").val())
				}
				else if(obj.res==2)
				{
					unblock_page("info","Already Added.");
					 
				 	$("#design_id"+$("#row_no").val()).val(obj.packing_model_id).trigger('çhange');
				      $("#modeltype").modal('hide');
					 $("#model_add").trigger('reset');
					  load_finish(obj.packing_model_id,$("#row_no").val())
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
 
 
function add_row()
{
	 $.ajax({ 
       type: "POST", 
       url: root+"product/add_design_row",
       data: {
  		"design_id"		: $("#design_id"+$("#row_cont").val()).val(),
  		"finish_id"		: $("#finish_id"+$("#row_cont").val()).val(),
  		"product_id"	: $("#product_details").val(),
		"consigne_id"	: $("#customer_id").val(),
  		"no"			: $("#row_cont").val() 
  	  }, 
       success: function (response) {
		   	 $(".appendtr"+$("#row_cont").val()).after(response);
			 var next_row = parseInt($("#row_cont").val()) + parseInt(1);
			  $("#no_of_pallet"+next_row).val( $("#no_of_pallet"+$("#row_cont").val()).val() )
			  $("#no_of_big_pallet"+next_row).val( $("#no_of_big_pallet"+$("#row_cont").val()).val() )
			  $("#no_of_small_pallet"+next_row).val( $("#no_of_small_pallet"+$("#row_cont").val()).val() )
			  $("#pallet_type_id"+next_row).val( $("#pallet_type_id"+$("#row_cont").val()).val() )
			  $("#box_design_id"+next_row).val( $("#box_design_id"+$("#row_cont").val()).val() )
			  
				$(".select1").select2({
					width:'element'
				});
			$("#row_cont").val(next_row);
			check_pallet_status($("input[name='pallet_status']:checked").val())
			unblock_page("",""); 
           }
       
  }); 
}
function load_data(product_id,mode,deletestatus,check_production_sheet)
{  
	if(product_id != "")
	{
		block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/load_design_data",
		data: {
				"id"				: product_id,
				"mode" 				: mode,
				"performa_trn_id" 	: $("#performa_trn_id").val(),
				"customer_id" 		: $("#customer_id").val(),
				"deletestatus" 		: deletestatus,
				"check_production_sheet" 		: check_production_sheet,
		}, 
		success: function (response) {
				$("#productdetail").html(response);
				$('#product_size_id').select2({ width:"element"});
					if(check_production_sheet == 1)
					{
						$('.select2').prepend('<div class="disabled-select"></div>');
					}
					 
				if($("#product_size_id").val()	!= "")
				{
					load_packing($("#product_size_id").val(),mode,deletestatus,check_production_sheet)
				}				
				unblock_page("",""); 
			}
		
	}); 
	}
	else
	{
		$("#productdetail").html('');
	}
}  
function load_packing(product_size_id,mode,deletestatus,check_production_sheet)
{  
if(product_size_id != "")
{
  	block_page();
     $.ajax({ 
       type: "POST", 
       url: root+"product/load_packing",
       data: {
  		"product_size_id"	: product_size_id,
		"mode" 				: mode,
		"performa_trn_id" 	: $("#performa_trn_id").val(),
		"customer_id" 		: $("#customer_id").val(),
		"deletestatus" 		: deletestatus,
		 
		"check_production_sheet" 		: check_production_sheet
  	  }, 
       success: function (response) {
		 	$(".packing_detail").html(response);
			 
			check_pallet_status($("input[name='pallet_status']:checked").val())
			$(".tooltips").tooltip();
			$('#container_check').bootstrapToggle();
			 $('.select1').select2({ width:"element"});
			 if(check_production_sheet == 1)
					{
						$('.select2').prepend('<div class="disabled-select"></div>');
					}
					 
		 	unblock_page("",""); 
           }
       
  }); 
}
else{
	$(".packing_detail").html('');
}
}   

function check_pallet_status(val)
{
	 if(val==1)
	 {
	 	$(".multi_pallet_calcution").hide();
		$(".boxes_calculation").hide();
	 	$(".pallet_calcution").show();
	 	 
	 }
	 else if(val==2)
	 {
	 	$(".pallet_calcution").hide();
	 	$(".multi_pallet_calcution").hide();
	 	$(".boxes_calculation").show();
	  
	}
	else if(val == 3)
	{
		$(".pallet_calcution").hide();
	 	$(".boxes_calculation").hide();
	 	$(".multi_pallet_calcution").show();
 
	}
	 cal_all_total(1)
 }
function cal_all_total(val)
{
 
		var total_no_of_pallet = 0;
		var total_no_of_boxes = 0;
		var total_no_of_sqm = 0;
		var total_product_amt = 0;
		var no =1;
		 var radioValue = $("input[name='pallet_status']:checked"). val();
		var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	   var weight_per_box = $('#weight_per_box').val();
		
	 if(radioValue==1)
	 {
		 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var pallet_weight 		= $('#pallet_weight').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			  
			 var product_rate_per 	= $('#product_rate_per'+d).val();
					
			if($('#no_of_pallet'+d).val() != undefined && $('#no_of_pallet'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				if(val == 1)
				{
					var no_of_boxes = $('#no_of_boxes'+d).val();
				}
				else
				{
					var no_of_boxes = $('#no_of_pallet'+d).val() * boxes_per_pallet;
					$('#no_of_boxes'+d).val(no_of_boxes);
				}
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				if(product_rate_per == "SQM")
				{
						var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
					
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
				}
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
				total_no_of_pallet	 += parseFloat($("#no_of_pallet"+d).val());
				total_no_of_boxes	 += (no_of_boxes>0)?parseFloat(no_of_boxes):0;
				 
				total_no_of_sqm 	 += parseFloat(no_of_sqm);
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;
			}
		}
		$('#total_no_of_pallet').val(total_no_of_pallet);
		$('#total_no_of_boxes').val(total_no_of_boxes);
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 var pallet_weight 		= $('#pallet_weight').val(); 
		 var total_pallet_weight = total_no_of_pallet * pallet_weight;
		 var total_net_weight 	= weight_per_box * total_no_of_boxes;
		 var total_gross_weight 	= parseFloat(total_net_weight) + parseFloat(total_pallet_weight);
		$('#Pallet_Weight_html').html(total_pallet_weight);
		$('#total_pallet_weight').val(total_pallet_weight);
		
	 	$('#total_net_weight').val(total_net_weight.toFixed(2));
	 	$('#total_gross_weight').val(total_gross_weight.toFixed(2));
	 }
	 else if(radioValue==2)
	 {
		 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
	 	 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			  
			 var product_rate_per 	= $('#product_rate_per'+d).val();
					
			if($('#no_of_boxes'+d).val() != undefined && $('#no_of_boxes'+d).val() != "" )
			{
				var rate_usd_val = $('#product_rate'+d).val();
				var no_of_boxes = $('#no_of_boxes'+d).val();
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				if(product_rate_per == "SQM")
				{
						var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
					
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
				}
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
			 	total_no_of_boxes	 += parseFloat($('#no_of_boxes'+d).val());
				total_no_of_sqm 	 += parseFloat($('#no_of_sqm'+d).val());
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;
			}
		}
		$('#total_no_of_pallet').val(0);
		$('#total_no_of_boxes').val(total_no_of_boxes);
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
		 
		  
		 var total_net_weight 	= weight_per_box * total_no_of_boxes;
		 var total_gross_weight 	= parseFloat(total_net_weight);
		$('#Pallet_Weight_html').html(0);
		$('#total_pallet_weight').val(0);
		
	 	$('#total_net_weight').val(total_net_weight.toFixed(2));
	 	$('#total_gross_weight').val(total_gross_weight.toFixed(2));
	 }
	 else if(radioValue==3)
	 {
		  
		 var box_per_big_pallet 	= $('#box_per_big_pallet').val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet').val();
		 var big_pallet_weight 		= $('#big_pallet_weight').val();
		 var small_pallet_weight 	= $('#small_pallet_weight').val();
		 var sqm_per_box 			= $('#sqm_per_box').val();
	 	var total_no_of_pallet 		= 0;
		var total_no_of_boxes 		= 0;
		var total_no_of_sqm 		= 0;
		var total_product_amt		= 0;
		var total_gross_weight 		= 0;
		var total_net_weight 		= 0;
		var total_pallet_weight 	= 0;
		var no =1;
		for (var d = 1; d <= $("#row_cont").val(); d++) 
		{
			if(($('#no_of_big_pallet'+d).val() != undefined && $('#no_of_big_pallet'+d).val() != "") || ($('#no_of_small_pallet'+d).val() != undefined && $('#no_of_small_pallet'+d).val() != ""))
			{
				
				var rate_usd_val = $('#product_rate'+d).val();
				var no_of_big_pallet 	= ($('#no_of_big_pallet'+d).val()>0)?$('#no_of_big_pallet'+d).val():0;
				var no_of_small_pallet 	= ($('#no_of_small_pallet'+d).val()>0)?$('#no_of_small_pallet'+d).val():0;
				 
			 	var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
			 	var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
			 	var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				 total_no_of_pallet	 += parseFloat(total_pallet);
				total_no_of_boxes	 += parseFloat($('#no_of_boxes'+d).val());
				total_no_of_sqm 	 += parseFloat($('#no_of_sqm'+d).val());
				
				total_product_amt 	 += ($('#product_amt'+d).val() > 0)?parseFloat($('#product_amt'+d).val()):0;;
				total_gross_weight  += parseFloat($('#packing_gross_weight'+d).val());
				total_net_weight 	+= parseFloat($('#packing_net_weight'+d).val());
				total_pallet_weight 	+= parseFloat(palletweight);
			}
			no++;
		}
		 
		$('#total_no_of_pallet').val(total_no_of_pallet);
		$('#total_no_of_boxes').val(total_no_of_boxes);
		$('#total_no_of_sqm').val(total_no_of_sqm.toFixed(2));
		$('#total_product_amt').val(total_product_amt.toFixed(2));
	 	$('#Pallet_Weight_html').html(total_pallet_weight);
		$('#total_pallet_weight').val(total_pallet_weight);
	 	$('#total_net_weight').val(total_net_weight.toFixed(2));
	 	$('#total_gross_weight').val(total_gross_weight.toFixed(2));
	 }
}  
function load_finish(design_id,val)
{  
	if(design_id == 0)
	{
		$("#row_no").val(val)
		$("#productid").val($("#product_details").val())
		$("#modeltype").attr('style','z-index:1060');
		$("#modeltype").modal('show');
		
	}
	else{
		block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/load_finish_data",
		data: {
			"id": design_id,
			"product_id": $("#product_details").val(),
			"customer_id":$("#customer_id").val()
		}, 
		success: function (response) 
			{
				var obj = JSON.parse(response);
				$("#finish_id"+val).html(obj.html);
				if(obj.design_detail != null)
				{
					$("#client_name"+val).val(obj.design_detail.cust_design_name);
					$("#barcode_no"+val).val(obj.design_detail.barcode_no);
				}
				else
				{
					$("#client_name"+val).val('');
					$("#barcode_no"+val).val('');
				}
				load_rate(val);
				unblock_page("",""); 
			}
		
	}); 
	}
} 
function load_rate(val)
{
	block_page();
		$.ajax({ 
		type: "POST", 
		url: root+"product/designrate",
		data:
		{
			"consigne_id"	 	: $("#customer_id").val(),
			"product_id"		: $("#product_details").val(),
			"packing_model_id"	: $("#design_id"+val).val(),
			"product_rate_per"	: $("#product_rate_per"+val).val(),
			"finish_id"			: $("#finish_id"+val).val(),
		}, 
		success: function (response) {
				 
			var obj = JSON.parse(response);
				 
				if(obj.rate_data != null && obj.rate_data != 0)
				{
				 	$("#product_rate_per"+val).val((obj.rate_data.product_rate_per != null)?obj.rate_data.product_rate_per:"SQM");
					$("#product_rate"+val).val(parseFloat(obj.rate_data.design_rate).toFixed(2));
				}
				else
				{
					$("#product_rate_per"+val).val('SQM');
					$("#product_rate"+val).val(0);
				}
				 
				if(obj.designe_data != null && obj.designe_data != 0)
				{
				 	$("#client_name"+val).val(obj.designe_data.cust_design_name);
					$("#barcode_no"+val).val(obj.designe_data.barcode_no);
				}
				else
				{
					$("#client_name"+val).val('');
					$("#barcode_no"+val).val('');
				}
				cal_product_trn(val)
				cal_all_total(0)
				unblock_page("",""); 
			}
		
	}); 
}  
 
 $('.drag-x').dragScroll({
            direction: 'scrollLeft'
        });
$(function(){
    $(".wrapper1").scroll(function(){
        $(".wrapper2")
            .scrollLeft($(".wrapper1").scrollLeft());
    });
    $(".wrapper2").scroll(function(){
        $(".wrapper1")
            .scrollLeft($(".wrapper2").scrollLeft());
    });
});
function calc_product_trn(no,box_status)
{
	
	 var pallet_status 	 = $("#pallet_status"+no).val();
	 	 
	 if(pallet_status==1)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet'+no).val();
		 var pallet_weight 		= $('#pallet_weight'+no).val();
		 var weight_per_box 	= $('#weight_per_box'+no).val();
		 var sqm_per_box 		= $('#sqm_per_box'+no).val();
		 var feet_per_box 		= $('#feet_per_box'+no).val();
		 var pcs_per_box 		= $('#pcs_per_box'+no).val();
		 var rate_usd_val 		= $('#product_rate'+no).val();
		 var unit_per		 	= $('#unit_per'+no).val();
		 var no_of_pallet 		= $('#pallet'+no).val();
	 	 var total_pallet 		= ($("#pallet"+no).val()>0)?$("#pallet"+no).val():0;
		  
		 if(box_status == 1)
		 {
			 var no_of_boxes = $('#no_of_boxes'+no).val();
		 }
		 else
		 {
			var no_of_boxes = total_pallet * boxes_per_pallet;
			$('#no_of_boxes'+no).val(no_of_boxes);
		 }
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+no).val(no_of_sqm.toFixed(2));
		
		 var palletweight = total_pallet * pallet_weight;
		
		 var packing_net_weight 		= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+no).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+no).val(packing_gross_weight.toFixed(2));
		var product_total_amount = 0
		 if(unit_per == "SQM")
		 {
			   product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 }
		 else if(unit_per == "BOX")
		 {
			   product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(unit_per == "SQF")
		 {
			   product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(unit_per == "PCS")
		 {
			   product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
		 }
		
		$('#product_amt_html'+no).html((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		$('#product_amt'+no).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
	 }
	 else if(pallet_status==2)
	 {
	 	  var weight_per_box 	= $('#weight_per_box'+no).val();
		 var sqm_per_box 		= $('#sqm_per_box'+no).val();
		 var feet_per_box 		= $('#feet_per_box'+no).val();
		 var pcs_per_box 		= $('#pcs_per_box'+no).val();
		 var rate_usd_val 		= $('#product_rate'+no).val();
		 var product_rate_per 	= $('#unit_per'+no).val();
		   
		 
		 var no_of_boxes =  $('#no_of_boxes'+no).val();
		 
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+no).val(no_of_sqm.toFixed(2));
		
		  var packing_net_weight 		= weight_per_box * no_of_boxes;
		  var packing_gross_weight 		=  parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+no).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+no).val(packing_gross_weight.toFixed(2));
		
		 if(product_rate_per == "SQM")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 }
		 else if(product_rate_per == "BOX")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(product_rate_per == "SQF")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(product_rate_per == "PCS")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
		 }
		
		$('#product_amt_html'+no).html((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		$('#product_amt'+no).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
	 }
	 else if(pallet_status==3)
	 {
		 var weight_per_box 		= $('#weight_per_box'+no).val();
		  var per_value	 			= $('#unit_per'+no).val(); 
		 var box_per_big_pallet 	= $('#box_per_big_pallet'+no).val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet'+no).val();
		 var big_pallet_weight 		= $('#big_pallet_weight'+no).val();
		 var small_pallet_weight 	= $('#small_pallet_weight'+no).val();
		 var sqm_per_box 			= $('#sqm_per_box'+no).val();
		 var feet_per_box 			= $('#feet_per_box'+no).val();
		 var pcs_per_box 			= $('#pcs_per_box'+no).val();
		 var rate_usd_val 			= $('#product_rate'+no).val();
		var no_of_big_pallet 		= $('#big_pallet'+no).val();
		var no_of_small_pallet 		= $('#small_pallet'+no).val();
		var product_rate_per 		= $('#unit_per'+no).val();
		 
		 
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				 
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_big_pallet;
				if(box_status == 1)
				{
					var no_of_boxes = $('#no_of_boxes'+no).val();
				}
				else
				{
					var no_of_boxes = no_of_big_boxes + no_of_small_boxes;
					$('#no_of_boxes'+no).val(no_of_boxes);
				}
			 	var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+no).val(no_of_sqm.toFixed(2));
				
				 if(product_rate_per == "SQM")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
			 	}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
		 		}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
				}
					

					$('#product_amt'+no).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
					$('#product_amt_html'+no).html((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
						
				var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+no).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+no).val(packing_gross_weight.toFixed(2));
	   }
	 
}
function cal_producation_trn(no,pino,from)
{
	var sqm_per_box 			= $("#sqm_per_box"+pino).val();
	var boxes_per_pallet 		= $("#boxes_per_pallet"+pino).val();
	var box_per_big_pallet 		= $("#box_per_big_pallet"+pino).val();
	var box_per_small_pallet 	= $("#box_per_small_pallet"+pino).val();
	
	 var pallet_status 	 = $("#pallet_status"+pino).val();
	var no_of_pallet 			= ($("#producation_pallet"+no).val())?$("#producation_pallet"+no).val():0;
	var producation_big_pallet 	= ($("#producation_big_pallet"+no).val())?$("#producation_big_pallet"+no).val():0;
	var producation_small_pallet= ($("#producation_small_pallet"+no).val())?$("#producation_small_pallet"+no).val():0;
	  var weight_per_box 		= $("#weight_per_box"+pino).val();
	 
	 
	if(pallet_status == 1)
	{
		if(from == 1)
		{
			var no_of_boxes = $("#producation_no_of_boxes"+no).val();
		}
		else
		{
			var no_of_boxes = parseFloat(no_of_pallet) * parseFloat(boxes_per_pallet);
		}
		var total_sqm = parseFloat(no_of_boxes) * parseFloat(sqm_per_box);
		 
		$("#producation_no_of_boxes"+no).val(no_of_boxes);
		$("#producation_no_of_sqm"+no).val(total_sqm.toFixed(2));
		 
	}
	else if(pallet_status == 3)
	{
		
		var big_boxes = parseFloat(producation_big_pallet) * parseFloat(box_per_big_pallet);
		var small_boxes = parseFloat(producation_small_pallet) * parseFloat(box_per_small_pallet);
		if(from == 1)
		{
			var no_of_boxes = $("#producation_no_of_boxes"+no).val();
		}
		else
		{
			var no_of_boxes = parseFloat(big_boxes) + parseFloat(small_boxes);
		}
		
		
		var total_sqm = parseFloat(no_of_boxes) * parseFloat(sqm_per_box);
	 	$("#producation_no_of_boxes"+no).val(no_of_boxes);
		  
		$("#producation_no_of_sqm"+no).val(total_sqm.toFixed(2));
	 
	}
	else if(parseInt(boxes_per_pallet) == 0 && parseInt(box_per_big_pallet)== 0 && parseInt(box_per_small_pallet) == 0)
	{
		
		var no_of_boxes = $("#producation_no_of_boxes"+no).val();
		var total_sqm = parseFloat(no_of_boxes) * parseFloat(sqm_per_box);
		 
	 	 $("#producation_no_of_sqm"+no).val(total_sqm.toFixed(2));
		   
	}
}
function cal_po_trn(no,pino,box_status)
{
	 var pallet_status 	 = $("#pallet_status"+pino).val();
 
	 if(pallet_status==1)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet'+pino).val();
		 var pallet_weight 		= $('#pallet_weight'+pino).val();
		 var weight_per_box 	= $('#weight_per_box'+pino).val();
		 var sqm_per_box 		= $('#sqm_per_box'+pino).val();
		 var feet_per_box 		= $('#feet_per_box'+pino).val();
		 var pcs_per_box 		= $('#pcs_per_box'+pino).val();
		 var po_product_rate 	= $('#po_product_rate'+no).val();
				
		 var no_of_pallet 	= $('#po_pallet'+no).val();
		 var no_of_boxes 	= no_of_pallet * boxes_per_pallet;
		if(box_status == 1)
		{
			var no_of_boxes 	= $('#po_no_of_boxes'+no).val();
		}	
		else
		{
			var no_of_boxes 	= no_of_pallet * boxes_per_pallet;
		}
		$('#po_no_of_boxes'+no).val(no_of_boxes.toFixed(2));
				
		var no_of_sqm = no_of_boxes * sqm_per_box;
		$('#po_no_of_sqm'+no).val(no_of_sqm.toFixed(2));
				
		var price_type = $('#po_unit'+no).val();
				 
			 var totalamt =0
				if(price_type=="SQF")
				{
				 	var total_feet =  parseFloat(feet_per_box) * parseFloat(no_of_boxes);
				 	totalamt = parseFloat(total_feet) * parseFloat(po_product_rate);
				}
				else if(price_type=="BOX")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_boxes);
				}
				else if(price_type=="SQM")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_sqm);
				}
				else if(price_type=="PCS")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_boxes) * parseFloat(pcs_per_box);
				}
				var product_total_amount = totalamt;
				$('#po_product_amt'+no).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				$('#po_amt_html'+no).html((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				var palletweight 			= total_pallet * pallet_weight;
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#po_packing_net_weight'+no).val(packing_net_weight.toFixed(2));
				$('#po_packing_gross_weight'+no).val(packing_gross_weight.toFixed(2));
	 	 
	 } 
	 else if(pallet_status==2)
	 {
	 	 
		 var weight_per_box 	= $('#weight_per_box'+pino).val();
		 var sqm_per_box 		= $('#sqm_per_box'+pino).val();
		 var feet_per_box 		= $('#feet_per_box'+pino).val();
		 var pcs_per_box 		= $('#pcs_per_box'+pino).val();
		 var po_product_rate 	= $('#po_product_rate'+no).val();
		 
		 var no_of_boxes 	= $('#po_no_of_boxes'+no).val();
		 var no_of_sqm 		= no_of_boxes * sqm_per_box;
		 $('#po_no_of_sqm'+no).val(no_of_sqm.toFixed(2));
		 var price_type = $('#po_unit'+no).val();
				 
				var  totalamt = 0;
				if(price_type=="SQF")
				{
				 	var total_feet =  parseFloat(feet_per_box) * parseFloat(no_of_boxes);
				 	totalamt = parseFloat(total_feet) * parseFloat(po_product_rate);
				}
				else if(price_type=="BOX")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_boxes);
				}
				else if(price_type=="SQM")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_sqm);
				}
				else if(price_type=="PCS")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_boxes) * parseFloat(pcs_per_box);
				}
				var product_total_amount = totalamt;
				$('#po_product_amt'+no).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				$('#po_amt_html'+no).html((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				var palletweight 			= total_pallet * pallet_weight;
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#po_packing_net_weight'+no).val(packing_net_weight.toFixed(2));
				$('#po_packing_gross_weight'+no).val(packing_gross_weight.toFixed(2));
	 	 
	 } 
 	 else if(pallet_status==3)
	 {
		  var weight_per_box 		= $('#weight_per_box'+pino).val();
		  var box_per_big_pallet 	= $('#box_per_big_pallet'+pino).val();
		  var box_per_small_pallet 	= $('#box_per_small_pallet'+pino).val();
		  var big_pallet_weight 	= $('#big_pallet_weight'+pino).val();
		  var small_pallet_weight 	= $('#small_pallet_weight'+pino).val();
		  var sqm_per_box 			= $('#sqm_per_box'+pino).val();
		  var feet_per_box 			= $('#feet_per_box'+pino).val();
		 
		  var po_product_rate 		= $('#po_product_rate'+no).val();
		  var no_of_big_pallet 		= $('#po_big_pallet'+no).val();
		  var no_of_small_pallet 	= $('#po_small_pallet'+no).val();
		  var total_pallet 			= parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
			
		  var no_of_big_boxes 		= no_of_big_pallet * box_per_big_pallet;
		  var no_of_small_boxes 	= no_of_small_pallet * box_per_small_pallet;
				
		  var no_of_boxes 			= parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
		 if(box_status == 1)
		{
			var no_of_boxes 	= $('#po_no_of_boxes'+no).val();
		}
		else
		{
			var no_of_boxes  	= parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
			 $('#po_no_of_boxes'+no).val(no_of_boxes.toFixed(2));
		}
		 
		  var no_of_sqm 			= no_of_boxes * sqm_per_box;
		  $('#po_no_of_sqm'+no).val(no_of_sqm.toFixed(2));
				
				var price_type = $('#po_unit'+no).val();
				 if(price_type=="SQF")
				{
				 	var total_feet =  parseFloat(feet_per_box) * parseFloat(no_of_boxes);
				 	totalamt = parseFloat(total_feet) * parseFloat(po_product_rate);
				}
				else if(price_type=="BOX")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_boxes);
				}
				else if(price_type=="SQM")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_sqm);
				}
				else if(price_type=="PCS")
				{
					totalamt = parseFloat(po_product_rate) * parseFloat(no_of_boxes) * parseFloat(pcs_per_box);
				}
				var product_total_amount = totalamt;
				$('#po_product_amt'+no).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				$('#po_amt_html'+no).html((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				
				var big_palletweight 	= no_of_big_pallet * big_pallet_weight;
				var small_palletweight	 = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#po_packing_net_weight'+no).val(packing_net_weight.toFixed(2));
				$('#po_packing_gross_weight'+no).val(packing_gross_weight.toFixed(2));
				
 	 }

}

closeNav();
 function cal_box_trn(d)
{
	 var radioValue = $("input[name='pallet_status']:checked"). val();
	 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
				
	 if(radioValue==1)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var pallet_weight 		= $('#pallet_weight').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 var no_of_pallet 		= $('#no_of_pallet'+d).val();
		 var per_value	 		= $('#per'+d).val();
	 	 var total_pallet 		= ($("#no_of_pallet"+d).val()>0)?$("#no_of_pallet"+d).val():0;
		 var no_of_boxes 		= $('#no_of_boxes'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();  
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		 
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
		  $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
		  
		 var palletweight = total_pallet * pallet_weight;
		 var packing_net_weight 		= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
	 }
	 else if(radioValue==3)
	 {
			var weight_per_box = $('#weight_per_box').val();
			var per_value	 		= $('#per'+d).val();
			var box_per_big_pallet = $('#box_per_big_pallet').val();
			var box_per_small_pallet = $('#box_per_small_pallet').val();
			var big_pallet_weight = $('#big_pallet_weight').val();
			var small_pallet_weight = $('#small_pallet_weight').val();
			var sqm_per_box = $('#sqm_per_box').val();
			var rate_usd_val = $('#product_rate'+d).val();
			var no_of_big_pallet = $('#no_of_big_pallet'+d).val();
			var no_of_small_pallet = $('#no_of_small_pallet'+d).val();
			 var feet_per_box 		= $('#feet_per_box').val();
			 var pcs_per_box 		= $('#pcs_per_box').val();
			var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
			 var product_rate_per 	= $('#product_rate_per'+d).val();  
			 
			var no_of_boxes = $('#no_of_boxes'+d).val();
			
			 
			var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
			
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
				
			 
			$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
			var big_palletweight = no_of_big_pallet * big_pallet_weight;
			var small_palletweight = no_of_small_pallet * small_pallet_weight;
			
			var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
			var packing_net_weight 		= weight_per_box * no_of_boxes;
			var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
			
			$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
			$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
	 }
	 else if(radioValue==2)
	 {
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var no_of_boxes 		= $('#no_of_boxes'+d).val();
		 var rate_usd_val		= $('#product_rate'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();  
			
		 var weight_per_box 	= $('#weight_per_box').val();
		 var no_of_sqm = no_of_boxes * sqm_per_box;
			$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
			 
			
				if(product_rate_per == "SQM")
				{
					var product_total_amount 	= rate_usd_val * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes;
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount 	= rate_usd_val * no_of_boxes * pcs_per_box;
				}
			   $('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	=  parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
			
	 }
		cal_all_total(1)
}

function cal_product_trn(no)
{
	cal_product_invoice(no)
}
function cal_product_invoice(d)
{
	 
	 var radioValue 	 = $("input[name='pallet_status']:checked"). val();
	 var total_container = ($("#total_container").val()>1)?$("#total_container").val():1;
	 
	 if(radioValue==1)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var pallet_weight 		= $('#pallet_weight').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();
		 var no_of_pallet 		= $('#no_of_pallet'+d).val();
	 	 var total_pallet 		= ($("#no_of_pallet"+d).val()>0)?$("#no_of_pallet"+d).val():0;
		  
		 
		 var no_of_boxes = total_pallet * boxes_per_pallet;
		 $('#no_of_boxes'+d).val(no_of_boxes);
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		
		 var palletweight = total_pallet * pallet_weight;
		
		 var packing_net_weight 		= weight_per_box * no_of_boxes;
		 var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
		
		 if(product_rate_per == "SQM")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 }
		 else if(product_rate_per == "BOX")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(product_rate_per == "SQF")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(product_rate_per == "PCS")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
		 }
		
		$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
	 }
	 else if(radioValue==2)
	 {
	 	 var boxes_per_pallet 	= $('#boxes_per_pallet').val();
		 var weight_per_box 	= $('#weight_per_box').val();
		 var sqm_per_box 		= $('#sqm_per_box').val();
		 var feet_per_box 		= $('#feet_per_box').val();
		 var pcs_per_box 		= $('#pcs_per_box').val();
		 var rate_usd_val 		= $('#product_rate'+d).val();
		 var product_rate_per 	= $('#product_rate_per'+d).val();
		   
		 
		 var no_of_boxes =  $('#no_of_boxes'+d).val();
		 
		 var no_of_sqm = no_of_boxes * sqm_per_box;
		 $('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
		
		  var packing_net_weight 		= weight_per_box * no_of_boxes;
		  var packing_gross_weight 		=  parseFloat(packing_net_weight);
	 	 $('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
		 $('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
		
		 if(product_rate_per == "SQM")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
		 }
		 else if(product_rate_per == "BOX")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
			  
		 }
		 else if(product_rate_per == "SQF")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
		 }
		 else if(product_rate_per == "PCS")
		 {
			 var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
		 }
		
		$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
		  
	 }
	 else if(radioValue==3)
	 {
		 var weight_per_box 		= $('#weight_per_box').val();
		  var per_value	 			= $('#per'+d).val(); 
		 var box_per_big_pallet 	= $('#box_per_big_pallet').val();
		 var box_per_small_pallet 	= $('#box_per_small_pallet').val();
		 var big_pallet_weight 		= $('#big_pallet_weight').val();
		 var small_pallet_weight 	= $('#small_pallet_weight').val();
		 var sqm_per_box 			= $('#sqm_per_box').val();
		 var feet_per_box 			= $('#feet_per_box').val();
		 var pcs_per_box 			= $('#pcs_per_box').val();
		 
		var total_no_of_pallet = 0;
		var total_no_of_boxes = 0;
		var total_no_of_sqm = 0;
		var total_product_amt = 0;
		var total_gross_weight = 0;
		var total_net_weight = 0;
		var total_pallet_weight = 0;
		var no =1;
		 
				var rate_usd_val 		= $('#product_rate'+d).val();
				var no_of_big_pallet 	= $('#no_of_big_pallet'+d).val();
				var no_of_small_pallet 	= $('#no_of_small_pallet'+d).val();
				var product_rate_per 	= $('#product_rate_per'+d).val();
		 
		 
				var total_pallet = parseInt(no_of_big_pallet) + parseInt(no_of_small_pallet);
				
				var no_of_big_boxes = no_of_big_pallet * box_per_big_pallet;
				var no_of_small_boxes = no_of_small_pallet * box_per_small_pallet;
				
				var no_of_boxes = parseInt(no_of_big_boxes) + parseInt(no_of_small_boxes);
				 
				$('#no_of_boxes'+d).val(no_of_boxes);
				
				var no_of_sqm = no_of_boxes * sqm_per_box;
				$('#no_of_sqm'+d).val(no_of_sqm.toFixed(2));
				
				 if(product_rate_per == "SQM")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_sqm;
				}
				else if(product_rate_per == "BOX")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes;
					
				}
				else if(product_rate_per == "SQF")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * feet_per_box;
				}
				else if(product_rate_per == "PCS")
				{
					var product_total_amount = parseFloat(rate_usd_val) * no_of_boxes * pcs_per_box;
				}
					
				$('#product_amt'+d).val((product_total_amount>0)?(product_total_amount.toFixed(2)):0);
				 
						
				var big_palletweight = no_of_big_pallet * big_pallet_weight;
				var small_palletweight = no_of_small_pallet * small_pallet_weight;
				
				var palletweight = parseFloat(big_palletweight)+parseFloat(small_palletweight);
				var packing_net_weight 		= weight_per_box * no_of_boxes;
				var packing_gross_weight 	= parseFloat(palletweight) + parseFloat(packing_net_weight);
				
				$('#packing_net_weight'+d).val(packing_net_weight.toFixed(2));
				$('#packing_gross_weight'+d).val(packing_gross_weight.toFixed(2));
			  
		 
		 
	 }
	 cal_all_total(1)
}

function load_data_table(performa_invoice_id)
{
	$(".view_report").html('')	
	$(".show_data").hide()	
	if(performa_invoice_id != "")
	{
		block_page(); 	
		$(".addbtn").show();
		$.ajax({          
			type: "POST",          
			url: root+'change_order/performa_detail',         
			data: {          
				"performa_invoice_id" : performa_invoice_id
			}, 		
			cache: false, 		
			success: function (data)
			{ 			
				var obj = JSON.parse(data);
				$(".show_data").show()
				$(".view_report").html(obj.html);
				$("#performainvoice_id").val(performa_invoice_id);
				$("#customer_id").val(obj.consigne_id);
				$("#container_details").val(obj.container_details);
				$("#container_forty").val(obj.container_forty);
				$("#container_twenty").val(obj.container_twenty);
				$(".select1").select2({
					width:"element"
				});
			 	$(".tooltips").tooltip()
				unblock_page("","")		
			}	
		});
	}
	else
	{
		$(".addbtn").hide();
	}
}
 
function cb(start, end) {
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    cb(moment().subtract(29, 'days'), moment());
	 
$('#daterange').daterangepicker({       
 			locale: {
				format: 'DD-MM-YYYY'
			},
		"autoApply": true,	
		"startDate": $('#s_date').val(),
		"endDate": $('#e_date').val(),	
	    ranges: {
			'All': ['01-01-1970',$('#e_date').val()],
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
			'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb); 
 
 
 function create_export_invoice()
{
	var performa_invoice_id = [];
	$. each($("input[name='all_performa_invoice[]']:checked"), function(){
		performa_invoice_id. push($(this). val());
	});
	if(performa_invoice_id.length < 2)
	{
		toastr["error"]("Please select atleast 2 invoice.")
	}
	else
	{
		$.ajax({ 
				type	: "POST", 
				url		: root+"invoice_listing/copy_mutiple_invoice",
				data	: {
							"performa_invoice_id": performa_invoice_id 
						  }, 
				cache	: false, 
				success	: function(data) 
				{ 
					var obj = JSON.parse(data);
					 
					if(obj.res==1)
					{
						window.location=root+'exportinvoice/mutiplecopy/'+performa_invoice_id.toString().replace(/,/g,"-");
					}
					else
					{
						toastr["error"]("Consignee name are different. Allow only for same consignee.")
					}
				}
			}); 
	}
}
</script>
 