<?php 
$this->view('lib/header'); 
$form = "Document Of ".$cust_data->c_companyname;
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
									<a href="<?=base_url().'customer_detail'?>">Customer List</a>
									
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								  <?=$form?>
							 </h3>
							
							</div>
							 <div class="panel-body form-body">
							 <div class="col-md-8 col-md-offset-1">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="customer_additional_form" id="customer_additional_form">
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Document Type
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="document_type" id="document_type1" value="Scan Copy"  <?=($detail->document_type == "Scan Copy")?"checked":""?> checked> 
												  		<strong for ="document_type1">Scan Copy</strong>
													</label>
													  <label>
													 <input type="radio" name="document_type" id="document_type2" value="Physical Copy"  <?=($detail->factory_logo_status == "Physical Copy")?"checked":""?> > 
												  		<strong for ="document_type2">Physical Copy</strong>
													</label>
											 </div>
										</div>
									 <div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Bl Draft Type
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="bl_type" id="bl_type1" value="Sea Bl"  <?=($detail->document_type == "Sea Bl")?"checked":""?> checked> 
												  		<strong for ="document_type1">Sea Bl</strong>
													</label>
													 <label>
														<input type="radio" name="bl_type" id="bl_type2" value="Original Bl"  <?=($detail->document_type == "Original Bl")?"checked":""?>  > 
												  		<strong for ="document_type1">Original Bl</strong>
											 		</label>
													<br>
													<label>
														<input type="radio" name="bl_type" id="bl_type2" value="Original Bl"  <?=($detail->document_type == "Original Bl")?"checked":""?>  > 
												  		<strong for ="document_type1">Physical Bl</strong>
											 		</label>
													<label>
														<input type="radio" name="bl_type" id="bl_type2" value="Original Bl"  <?=($detail->document_type == "Original Bl")?"checked":""?>  > 
												  		<strong for ="document_type1">TellX (Sureder)</strong>
											 		</label>
											 </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Invoice & Packing List 
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="invoice_status" id="invoice_status1" value="Yes"  <?=($detail->document_type == "Yes")?"checked":""?> checked> 
												  		<strong for ="document_type1">Yes</strong>
													</label>
													 <label>
														<input type="radio" name="invoice_status" id="invoice_status2" value="No"  <?=($detail->document_type == "No")?"checked":""?>  > 
												  		<strong for ="document_type1">No</strong>
											 		</label>
											  </div>
										</div> 
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Loading Sheet
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="invoice_status" id="invoice_status1" value="Yes"  <?=($detail->document_type == "Yes")?"checked":""?> checked> 
												  		<strong for ="document_type1">Yes</strong>
													</label>
													 <label>
														<input type="radio" name="invoice_status" id="invoice_status2" value="No"  <?=($detail->document_type == "No")?"checked":""?>  > 
												  		<strong for ="document_type1">No</strong>
											 		</label>
											  </div>
										</div> 
										 <div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Famigation Cerificate 
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="bl_type" id="bl_type1" value="Yes"  <?=($detail->document_type == "Yes")?"checked":""?> checked> 
												  		<strong for ="document_type1">Yes</strong>
													</label>
													 <label>
														<input type="radio" name="bl_type" id="bl_type2" value="No"  <?=($detail->document_type == "No")?"checked":""?>  > 
												  		<strong for ="document_type1">No</strong>
											 		</label>
											  </div>
										</div> 
										 <div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												COO  
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="bl_type" id="bl_type1" value="Yes"  <?=($detail->document_type == "Yes")?"checked":""?> checked> 
												  		<strong for ="document_type1">Yes</strong>
													</label>
													 <label>
														<input type="radio" name="bl_type" id="bl_type2" value="No"  <?=($detail->document_type == "No")?"checked":""?>  > 
												  		<strong for ="document_type1">No</strong>
											 		</label>
											  </div>
										</div> 
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												LC Document  
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="bl_type" id="bl_type1" value="Yes"  <?=($detail->document_type == "Yes")?"checked":""?> checked> 
												  		<strong for ="document_type1">Yes</strong>
													</label>
													 <label>
														<input type="radio" name="bl_type" id="bl_type2" value="No"  <?=($detail->document_type == "No")?"checked":""?>  > 
												  		<strong for ="document_type1">No</strong>
											 		</label>
											  </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Inspecation Cerificate  
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="bl_type" id="bl_type1" value="Yes"  <?=($detail->document_type == "Yes")?"checked":""?> checked> 
												  		<strong for ="document_type1">Yes</strong>
													</label>
													 <label>
														<input type="radio" name="bl_type" id="bl_type2" value="No"  <?=($detail->document_type == "No")?"checked":""?>  > 
												  		<strong for ="document_type1">No</strong>
											 		</label>
											  </div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Hit Treatment Cerificate  
											</label>
											 
											<div class="col-sm-4">
												   <label>
													 <input type="radio" name="bl_type" id="bl_type1" value="Yes"  <?=($detail->document_type == "Yes")?"checked":""?> checked> 
												  		<strong for ="document_type1">Yes</strong>
													</label>
													 <label>
														<input type="radio" name="bl_type" id="bl_type2" value="No"  <?=($detail->document_type == "No")?"checked":""?>  > 
												  		<strong for ="document_type1">No</strong>
											 		</label>
											  </div>
										</div>
										
							 			<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												Notification Days (Remainder) (After Export Invoice)
											</label>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$detail->made_in_india_status?>" class="form-control"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												F 1
											</label>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$detail->made_in_india_status?>" class="form-control"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												F 2
											</label>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$detail->made_in_india_status?>" class="form-control"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												F 3
											</label>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$detail->made_in_india_status?>" class="form-control"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												F 4
											</label>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$detail->made_in_india_status?>" class="form-control"> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label" for="form-field-1">
												F 5
											</label>
											<div class="col-sm-4">
												  <input type="text" name="made_in_india_status" id="made_in_india_status" value="<?=$detail->made_in_india_status?>" class="form-control"> 
											</div>
										</div>
								<div class="col-md-offset-3">
								<div class="form-group " style="" >
										<button type="submit" class="btn btn-success">
											Save
										</button>
										<a href="<?=base_url().'customer_detail/index'?>" class="btn btn-danger">
											Cancel
										</a>
										<?php
											if($fd == 'edit')
											{
											?>
												<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Consigner</button>-->
											<?php

											}
										?>
									</div>
									
									</div>
										<input type="hidden" name="customer_id" id="customer_id" value="<?=$cust_data->id?>"/>
										<input type="hidden" name="customer_add_detail_id" id="customer_add_detail_id" value="<?=$detail->customer_add_detail_id?>"/>
										<input type="hidden" name="box_sticker_filename" id="box_sticker_filename" value="<?=$detail->box_sticker_file?>"/>
										<input type="hidden" name="barcode_sticker_filename" id="barcode_sticker_filename" value="<?=$detail->barcode_sticker_file?>"/>
									</form>
					 	</div>
					</div>
						 
				 </div>
			</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer');
 $this->view('lib/addseries'); ?>
 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Bank Detail</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="add_bank_detail" id="add_bank_detail">
               
            <div class="modal-body">
                
				    <div class="field-group">
				        <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" required="" class="form-control" />
				    </div>                
				    
				    <div class="field-group">
				        <textarea id="bank_address" name="bank_address" placeholder="Bank Address" class="form-control"></textarea>
				    </div>                     
				    <div class="field-group">
				        <input id="account_name" type="text" name="account_name" placeholder="Account Name" required="" class="form-control" required title="Enter Account Name"/>
				    </div>  
				    <div class="field-group">
				        <input id="Email_ask" type="text" name="account_no" placeholder="Account No" required="" class="form-control"/>
				    </div>                
				    <div class="field-group">
				        <input type="text" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" class="form-control" />    
				    </div> 

				    <div class="field-group">
				        <input type="text" id="swift_code" name="swift_code" placeholder="Swift Code" class="form-control" />    
				    </div> 
				    <div class="field-group">
				        <input type="text" id="bank_ad_code" name="bank_ad_code" placeholder="Bank Ad Code No" class="form-control" />    
				    </div>                   
				
				                      
				
            </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info" onClick="return checkFields()" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>

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

 $(".select2").select2({
	width:'100%' 
});
$("#add_bank_detail").validate({
		rules: {
			bank_name: {
				required: true
			}
		},
		messages: {
			bank_name: {
				required: "Enter Bank Name"
			}
		}
	});
$("#add_bank_detail").submit(function(event) {
	event.preventDefault();
	if(!$("#add_bank_detail").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'bank_detail/manage',
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
				    $("#add_bank_detail").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					 $("#bank_id").append('<option value="'+obj.bank_id+'">'+obj.bankname+'</option>');
					 $("#bank_id").val(obj.bank_id)
					 $("#myModal").modal("hide")
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'bank_detail'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'bank_detail'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 
$("#customer_additional_form").submit(function(event) {
	event.preventDefault();
	if(!$("#customer_additional_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'add_customer_detail/manage',
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
					setTimeout(function(){ location.reload(); },100);
			   }
			   else if(obj.res==2)
			   {
				   
					unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ location.reload(); },100);
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
function update_box_design(value,no)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_customer_detail/manage_box_design",
              data: {
					"box_design_id"	: value,
					"customer_id"	: <?=$cust_data->id?>,
					"size_type_mm" 	: $("#size_type_mm"+no).val(),
					"customer_box_design_id" : $("#customer_box_design_id"+no).val()
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  	$(".loader").hide();
					if(obj.res==1)
					{
						
							unblock_page("success","Sucessfully Inserted.");
							setTimeout(function(){ location.reload(); },100);
					}
					else if(obj.res==2)
					{
						
							unblock_page("success","Sucessfully Updated.");
							setTimeout(function(){ location.reload(); },100);
					}
					else
					{
							unblock_page("error","Something Wrong.") 
						
					}
					unblock_page("",""); 
                  }
              
          }); 

} 
function update_pallet_type_design(value,no)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_customer_detail/manage_pallet_design",
              data: {
					"pallet_type_id"	: value,
					"customer_id"	: <?=$cust_data->id?>,
					"size_type_mm" 	: $("#size_type_mm"+no).val(),
				 	"customer_box_design_id" : $("#customer_box_design_id"+no).val()
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  	$(".loader").hide();
					if(obj.res==1)
					{
						
							unblock_page("success","Sucessfully Inserted.");
							setTimeout(function(){ location.reload(); },100);
					}
					else if(obj.res==2)
					{
						
							unblock_page("success","Sucessfully Updated.");
							setTimeout(function(){ location.reload(); },100);
					}
					else
					{
							unblock_page("error","Something Wrong.") 
						
					}
					unblock_page("",""); 
                  }
              
          }); 
}
function update_pallet_packing(value,no)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"add_customer_detail/manage_pallet_packing",
              data: {
					"product_size_id"	: value,
					"customer_id"	: <?=$cust_data->id?>,
					"size_type_mm" 	: $("#size_type_mm"+no).val(),
				 	"customer_box_design_id" : $("#customer_box_design_id"+no).val()
				}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  	$(".loader").hide();
					if(obj.res==1)
					{
						
							unblock_page("success","Sucessfully Inserted.");
							setTimeout(function(){ location.reload(); },100);
					}
					else if(obj.res==2)
					{
						
							unblock_page("success","Sucessfully Updated.");
							setTimeout(function(){ location.reload(); },100);
					}
					else
					{
							unblock_page("error","Something Wrong.") 
						
					}
					unblock_page("",""); 
                  }
              
          }); 
}
</script>

  