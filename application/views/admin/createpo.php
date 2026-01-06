<?php 
$this->view('lib/header'); 
if($mode=="Add")
{ 	
	$invoice_no="";
	$invoice_series = str_pad($invoicetype->invoice_series,strlen($invoicetype->invoice_series), '0', STR_PAD_LEFT);
	if($invoicetype->invoice_format==0)
	{
		$invoice_no = $invoice_series;
    }
	else if($invoicetype->invoice_format==1)
	{
		$invoice_no = $invoicetype->formate_value;
	 	$datevalue 	= explode(",",$invoicetype->with_date);
		 if(in_array(3,$datevalue))
		 {
			 $invoice_no .= date('Y');
		 }
		if(in_array(2,$datevalue))
		{
			$invoice_no .= date('m');
		}
		if(in_array(1,$datevalue))
		{
			$invoice_no .= date('d');
		}
		$invoice_no =  $invoice_no.''.$invoice_series;						
	}
	else if($invoicetype->invoice_format==2)
	{
		 $invoice_no .= $invoice_series;
		
		$datevalue = explode(",",$invoicetype->with_date);
		if(in_array(3,$datevalue))
		{
			$invoice_no .= date('Y');
		}
		if(in_array(2,$datevalue))
		{
			$invoice_no .= date('m');
		}
		
		if(in_array(1,$datevalue))
		{
			$invoice_no .= date('d');
		}															
		$invoice_no .= $invoicetype->formate_value;
	}
	$explode_array = explode(",",$invoicetype->with_date);
		
		$value=array();
				if(in_array(1,$explode_array))
				{
					array_push($value,date('d'));
				}
				if(in_array(2,$explode_array))
				{
					array_push($value,date('m'));
				}
				if(in_array(3,$explode_array))
				{
					array_push($value,date('y'));
				}
				if(in_array(4,$explode_array))
				{
					$year = date('n') > 4 ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
					array_push($value,$year);
				}
				
		$implode_array = implode($invoicetype->separate_by,$value);	 
				if($invoicetype->date_palce==1)
				{ 
					$invoice_no = $implode_array.$invoicetype->separate_by.$invoice_no;
				}
				else if($invoicetype->date_palce==2)
				{ 	
					$invoice_no = $invoice_no.$invoicetype->separate_by.$implode_array;
				}
	$Today_Date				= date('d-m-Y');
	$export 				= strip_tags($invoicedata->exporter_detail);
 	$exporter_pan 			= $exporter_detail->s_pan;
	$rcmc_no 				= $exporter_detail->rcmc_no;
	$rcmc_expiery 			= $exporter_detail->rcmc_expiery;
	$export_port_loading 	= $invoicedata->port_of_loading;          
	$port_of_discharge 		= $invoicedata->port_of_discharge;
	$final_destination 		= $invoicedata->final_destination;
	$no_of_container 		= $invoicedata->no_of_countainer;
	$container_twety 		= number_format($invoicedata->container_twenty,2);
	$container_forty 		= number_format($invoicedata->container_forty,2);
	$supplier_id 			= $invoicedata->supplier_id;
	$seller_ref_no 			= $invoicedata->invoice_no;
	 
	if($mutiple_status == 2)
	{
		$seller_ref_no 		= $invoicedata->invoice_no;
	}
 
}
else 
{
	$invoice_no	   = $invoicedata->purchase_order_no;
	$Today_Date	   = date('d-m-Y',strtotime($invoicedata->purchase_order_date));
	$export		   = strip_tags($invoicedata->exporter_detail);
	$rcmc_no 	   = $invoicedata->rcmc_no;
	$rcmc_expiery  = $invoicedata->rcmc_expiery;
	$seller_ref_no = $invoicedata->seller_ref_no;
	$supplier_id   = $invoicedata->seller_id;
	$supplier_pan_no  = $invoicedata->supplier_panno;
	$supplier_gstinno = $invoicedata->supplier_gstin;
	$export_port_loading = $invoicedata->port_of_loading; 
	$supplier_address = strip_tags($invoicedata->supplier_address);
	$payment_terms = strip_tags($invoicedata->payment_terms);
	$no_of_container = $invoicedata->container_details;;
	$exporter_pan  = $invoicedata->exporter_pan;
	$port_of_discharge = $invoicedata->port_of_discharge;
	$delivery_time = $invoicedata->delivery_time;
	$final_destination = $invoicedata->final_destination;
	$remarks = strip_tags($invoicedata->remarks);
	$container_twety 		= $invoicedata->container_twenty;
	$container_forty 		= $invoicedata->container_forty;
}
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
									<a href="<?=base_url().'purchaseorder_listing'?>">Purchase Order List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
									<h1>Purchase Order</h1>
							</div>
						</div>
					</div>
				 
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<?=($mode=="Edit")?$mode:'Create'?> Purchase Order
								</div>
								<div class="form-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="po_form" id="po_form">
										<div class="panel-body">
											<div class="" style="padding:10px;" >
												<table cellspacing="0" cellpadding="0"    width="100%">
													<tr>
														<td rowspan="6" width="2%">
															<span>B</span><br>	
															<span>U</span><br>		
															<span>Y</span><br>	
															<span>E</span><br>		
															<span>R</span> 	
														</td>
														<td rowspan="3" colspan="2" style="padding: 5px; margin: 0; vertical-align: top;font-weight:bold">
															<textarea type="text" name="exporter_detail" rows="6" class="form-control" id="exporter_detail" readonly="readonly"><?=$export?></textarea>
														</td>
														<td width="15%">
															Purchase Order No 
														</td>
														<td width="15%" colspan="2" style="font-weight:bold">
															<input type="text" placeholder="Purchase Order No" style="font-weight:bold;" id="purchase_order_no" required="" class="form-control" name="purchase_order_no" value="<?=$invoice_no?>" title="Enter Purchase Order No ">
															<input type="hidden" id="invoice_series" required=""  name="invoice_series" value="<?=(str_pad($invoice_series + 1,strlen($invoicetype->invoice_series), '0', STR_PAD_LEFT))?>" >
														</td>
														<td width="5%">
															DATE
														</td>
														<td width="15%" style="font-weight:bold">
															<input type="text" placeholder="Date" id="purchase_order_date" required="" style="font-weight:bold;" class="form-control defualt-date-picker" name="purchase_order_date" value="<?=$Today_Date?>" title="Enter Invoice Date" /> 
														</td>
													</tr>
													<tr>
														<td>Seller Ref. No </td>
														<td colspan="4" >
															<input type="text" placeholder="Seller Ref. No" id="seller_ref_no" style="font-weight:bold;" class="form-control" name="seller_ref_no" value="<?=$seller_ref_no?>"/> 
														</td>
													</tr>
													<tr>
														<td>Port of Loading  </td>
														<td colspan="4" >
															<input type="text" placeholder="Port Of Loading	" style="font-weight:bold;" id="port_of_loading"  class="form-control" name="port_of_loading" value="<?=$export_port_loading?>" >
														</td>
													</tr>
													<tr>
														<td width="24%">PAN NO</td>
														<td width="24%" style="font-weight:bold" >
															<input type="text" placeholder="Exporter PAN NO" style="font-weight:bold;" id="exporter_pan" required="" class="form-control" name="exporter_pan" value="<?=$exporter_pan?>"title="Enter Pan No" >
														</td>
														<td> Country</td>
														<td colspan="4" >
															 <input type="text" placeholder="Country" style="font-weight:bold;" id="final_destination" required="" class="form-control" name="final_destination" value="<?=$final_destination?>" title="Enter Country"> 
														</td>
													</tr>
													<tr>
														<td style="padding-left: 5px;  padding-top: 0px;margin-top:0px; ">
															RCMC NO
														</td>
														<td style="font-weight:bold"> 
															<input type="text" placeholder="RCMC NO" style="font-weight:bold;" id="rcmc_no"   class="form-control" name="rcmc_no" value="<?=$rcmc_no?>" title="Enter RCMC NO">
														</td>
														<td>
															Container Details 
														</td>
														<td colspan="2">
															20 FCL
															<input type="text"  id="container_twenty"  name="container_twenty"  class="form-control"  value="<?=$container_twety?>"  onkeyup="cal_total()" onblur="cal_total()" > 
														</td>
													 	<td colspan="2">
															40 FCL
															<input type="text"  id="container_forty" name="container_forty"  class="form-control"  value="<?=$container_forty?>" onkeyup="cal_total()" onblur="cal_total()" > 
															<input type="hidden" id="container_details" required   name="container_details" value="<?=$no_of_container?>"   >
														</td>
													</tr>
											<tr>
												<td>RCMC EXPIERY</td>
												<td style="font-weight:bold" >
													<input type="text" placeholder="RCMC EXPIERY" id="rcmc_expiery" style="font-weight:bold;"   class="form-control" name="rcmc_expiery" value="<?=$rcmc_expiery?>" title="Enter RCMC EXPIERY" >
												</td>
												<td>Delivery Time</td>
												<td colspan="4" >
													<input type="text" placeholder="Delivery Time" id="delivery_time"   class="form-control" name="delivery_time" value="<?=$delivery_time?>" title="Enter Delivery Time" >
												</td>
												 
											</tr>
											 
											<tr>
												<td rowspan="4" style="font-size: 11px;">
													<span>S</span><br>	
													<span>E</span><br>		
													<span>L</span><br>	
													<span>L</span><br>		
													<span>E</span><br>		
													<span>R</span> 
												</td>
												<td>Seller Name :</td>
												 <td >
													 <select class="" name="seller_id" id="seller_id" required onchange="load_supplier(this.value)" title="Select Seller">
														<option value="">Please Select Seller</option>
														<option value="0" style="color:blue">Add New Seller</option>
														<?php 
														for($i=0; $i<count($supplier_detail);$i++)
														{
															$selected='';
														 
															if($supplier_id==$supplier_detail[$i]->supplier_id)
															{
																$selected = 'selected="selected"';
															}
														?>
															<option <?=$selected?> value="<?=$supplier_detail[$i]->supplier_id?>"><?=$supplier_detail[$i]->supplier_name.' - '.$supplier_detail[$i]->company_name?></option>
														<?php
														}
														?>
													</select>
												 </td>
												  <td>
												  Payment Terms
												  </td>
												 <td colspan="4">
													<textarea class="form-control"  style="height:50px;" name="payment_terms" id="payment_terms"  required title="Enter Payment Terms" placeholder="Payment Terms"><?=$payment_terms?></textarea>
												 </td>
											</tr>
											<tr>
												<td colspan="2"   style="vertical-align:top;">
													<textarea class="form-control" rows="4" name="supplier_detail" id="supplier_detail"  required title="Enter Supplier Detail" placeholder="Supplier Detail" style="height:80px;"><?=$supplier_address?></textarea>
													<input type="text" name="supplier_pan_no" id="supplier_pan_no" class="form-control" placeholder="Pan No" value="<?=$supplier_pan_no?>" />
													<input type="text" name="supplier_gstinno" id="supplier_gstinno" class="form-control" placeholder="GSTIN No" value="<?=$supplier_gstinno?>" />
												</td>
												<td>Remarks</td>
												<td colspan="4">
													
													<textarea class="form-control" rows="4"  name="remarks" id="remarks"><?=$remarks?></textarea>
												</td>
										 	</tr>
											 
										 
									 
											 	 
				 
								</table>
									</div>
								
								 <div class="col-md-6">	
									<div class="form-group" >
										<button type="submit" name="submit" class="btn btn-success">
												NEXT
										</button>
										<a href="<?=base_url().'purchaseorder_listing'?>" class="btn btn-danger">
											Cancel
										</a>
									 </div>	
											
								 </div>	
							 </div>
							 
							 
									<input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>			
									<input type="hidden" name="performa_invoice_id" id="performa_invoice_id" value="<?=$invoicedata->performa_invoice_id?>"/>			
									<input type="hidden" name="production_mst_id" id="production_mst_id" value="<?=$invoicedata->production_mst_id?>"/>			
									<input type="hidden" name="purchase_order_id" id="purchase_order_id" value="<?=$invoicedata->purchase_order_id?>"/>			
									<input type="hidden" name="no_of_po" id="no_of_po" value="<?=$invoicedata->no_of_po?>"/>
									<input type="hidden" name="sgst" id="sgst" value="<?=$invoicedata->sgst?>"/>			
									<input type="hidden" name="igst" id="igst" value="<?=$invoicedata->igst?>"/>			
									<input type="hidden" name="cgst" id="cgst" value="<?=$invoicedata->cgst?>"/>			
									<input type="hidden" name="roundoff" id="roundoff" value="<?=$invoicedata->roundoff?>"/>
									<input type="hidden" name="grand_total" id="grand_total" value="<?=$invoicedata->grand_total?>"/>			
									<input type="hidden" name="mutiple_status" id="mutiple_status" value="<?=$mutiple_status?>"/><input type="hidden"  id="image_status" name="image_status" value="<?=$invoicedata->image_status?>" />   	
							  		<input type="hidden" name="loading_by" id="loading_by"  value="<?=$invoicedata->loading_by?>" />
									<input type="hidden" name="pallet_by" id="pallet_by"   value="<?=$invoicedata->pallet_by?>" />
									<input type="hidden" name="qc_by" id="qc_by"   value="<?=$invoicedata->qc_by?>" />
								</form>
					    
								</div>
						 
                            </div>
							 
						</div>
					</div>
				 
				</div>
		</div>
</div>
	<script>
function cal_total()
{
	var container_forty = ($("#container_forty").val() > 0)?$("#container_forty").val():0;
	var container_twenty = ($("#container_twenty").val() > 0)?$("#container_twenty").val():0;
	$("#container_details").val(parseInt(container_forty) + parseInt(container_twenty))
}
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
</script> 
<?php 
$this->view('lib/footer'); 
?>

<div id="suppliermodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Supplier</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="supplier_form" id="supplier_form">
				<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<div class="field-group">
							<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Name" required="" class="form-control" />
						</div>   
					</div>
					<div class="col-md-4">					
						<div class="field-group">
								<input type="text" id="company_name" name="company_name" placeholder="Supplier Company Name" required="" title="Enter Company Name" class="form-control"   />
						</div>                
				    </div>                
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="supplier_gstno" name="supplier_gstno" placeholder="Supplier Gst No" required="" title="Enter Gst No" class="form-control"  />
						</div>                
				    </div>
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="supplier_panno" name="supplier_panno" placeholder="Supplier Pan No"  title="Enter Pan No" class="form-control"  />
						</div>                
				    </div>
				 	 <div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="permission_no" name="permission_no" placeholder="Permission No"   class="form-control"/>
						</div>                
				    </div> 
								
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="permission_date" name="permission_date" placeholder="Permission Date"   class="form-control defualt-date-picker"  />
						</div>                
				    </div>  
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="expiry_date" name="expiry_date" placeholder="Expiry Date"   class="form-control"/>
						</div>                
				    </div>   
					 <div class="col-md-4">	
						<label class="col-sm-6  control-label" for="form-field-1">
									Upload Permission Doc
							</label>					
						<div class="field-group col-sm-6">
							<input type="file" name="permission_doc" id="permission_doc" class="form-control" accept="application/msword,application/pdf">
						</div>                
				    </div>
					<div class="col-md-6">					
						<div class="field-group">
							<textarea id="supplier_address" name="supplier_address" placeholder="Supplier Address"  class="form-control" required title="Enter Supplier Address"></textarea>
						</div>                
				    </div> 	
					<div class="col-md-6">					
						<div class="field-group">
							<textarea id="issue_authority_address" name="issue_authority_address" placeholder="Issue uthority Address" class="form-control"></textarea>
						</div>                
				    </div> 
					<div class="col-md-12"></div>	
					  <div class="col-md-6">					
						<div class="field-group">
							<textarea id="supplier_payment_terms" name="supplier_payment_terms" placeholder="Supplier Payment Terms"  class="form-control"   title="Enter Payment Terms" style="height:50px;"></textarea>
						</div>                
				    </div> 		
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="supplier_division" name="supplier_division" placeholder="Division"   class="form-control"  />
						</div>                
				    </div>  
					<div class="col-md-12"></div>	
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="sup_range" name="sup_range" placeholder="Supplier Range"   class="form-control"  />
						</div>                
				    </div>  
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="sup_location_code" name="sup_location_code" placeholder="Supplier Location code"   class="form-control"  />
						</div>                
				    </div>  
					<div class="col-md-4">					
						<div class="field-group">
							<input type="text" id="sup_circular_no" name="sup_circular_no" placeholder="Circular No"   class="form-control"  />
						</div>                
				    </div>  
			 	</div>
			 </div>
				<div class="modal-footer">
					<button name="Submit" type="submit" class="btn btn-info"> Save <img src="<?=base_url()?>adminast/assets/images/loader.gif" style="display:none;width:14px;" class="loader" /></button>   
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
        </div>
    </div>
</div>


<script> 
$(document).ready(function() {
	 
    $( "#payment_terms" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Createpo/search",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.payment_terms;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 })
 
$(".select2").select2({
	width:'85%',
	
})
$("#seller_id").select2({
	 width:'100%',
	  "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_new_suppiler()'>Add New Supplier</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 
	 
});
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
});
   
$(document).ready(function() {
	
$("#po_form").validate({
		rules: {
			purchase_order_no: {
				required: true
			} 
		},
		messages: {
			purchase_order_no: {
				required: "Enter Purchase Order No"
			} 
		}
});

});

$("#po_form").submit(function(event) {
	event.preventDefault();
	if(!$("#po_form").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this); 
	$.ajax({
            type: "post",
            url: 	root+'createpo/manage',
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
				   $("#po_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ window.location=root+'poproduct/index/'+obj.invoiceid; },1500);
			   }
			   else if(obj.res==3)
			   {
				   $("#po_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'poproduct/index/'+obj.invoiceid; },1500);
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

function add_new_suppiler()
{
	$(".modal").css('z-index','10000');
	 $('#suppliermodal').modal({
						backdrop: 'static',
						keyboard: false
					});
    $("#suppliermodal").css('z-index','1050');            
}
$("#supplier_form").validate({
		rules: {
			supplier_name: {
				required: true
			} 
		},
		messages: {
			supplier_name: {
				required: "Enter Name"
			} 
		}
	});
$("#supplier_form").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Add_supplier/manage',
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
				   $("#supplier_form").trigger('reset');
				    $('#suppliermodal').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#seller_id").append("<option value='"+obj.supplier_id+"' selected>"+obj.name+" - "+obj.company_name+"</option>");
					$("#seller_id").val(obj.supplier_id);
					$("#seller_id").trigger("change")
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

function  load_supplier(cidval){
		if(cidval==0)
		{
			add_new_suppiler();
			return false;
		}
		else{
			 
			block_page();
			 $('#supplier_detail').val('');
			$.ajax({
			  type :'POST',
			  url  :root+'createpo/getsupplier',
			  data :{
				'e_id' : cidval,
				'type' : 'consigner'
			  },
			  success : function(msg){
				var obj=JSON.parse(msg);
				$('#supplier_detail').val(obj.address);
				$('#supplier_pan_no').val(obj.supplier_panno);
				$('#supplier_gstinno').val(obj.supplier_gstno);
				$('#currencyid').select2("val",obj.currency_id);
				 $('#payment_terms').val(obj.payment_terms);
				 $('#remarks').val(obj.remarks_po);
				 
				unblock_page("","");
				}
			});
	}
} 
</script>
 <?php 
 if(!empty($supplier_id) && $mode != "Edit")
 {
	 echo "<script>load_supplier(".$supplier_id.")</script>";
 }
 ?>
 