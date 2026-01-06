<?php 
$this->view('lib/header'); 
 
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
									Supplier List
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								Supplier List
								 <a href="<?php echo base_url('add_supplier'); ?>" style="float:right;" type="button" class="btn btn-info">
								+ Supplier  
								</a>
							 </h3>
							
						</div>
					</div>
					</div>
					<div class="row">
						 <div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								Supplier List
								 </div>
								<div class="panel-body">
									
									
									<div class="table-responsive"><br><br>
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Supplier Name</th>
													<th>Company Name</th>
													<th>GST No</th>
													<th>Address</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											<?php 
										$m=1;
											for($i=0; $i<count($result);$i++)
											{
												 	// $shippingdata = $this->input->get('shippingdata');
													
													// if(!empty($company_data))
													// {
														// $where .= ' and $result[$i]->id = '.$company_data;
														// $_SESSION['get_invoicedata'] = $company_data;
													// }	
													// else
													// {
														// $_SESSION['get_invoicedata'] = '';
													// }
											?>
											
												<tr>
													<td><?=$m?></td>
													<td><?=$result[$i]->supplier_name?></td>
													<td><?=$result[$i]->company_name?></td>
													<td><?=$result[$i]->supplier_gstno?></td>
													<td><?=$result[$i]->address?></td>
													<td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="<?=base_url().'add_supplier/form_edit/'.$result[$i]->supplier_id?>" ><i class="fa fa-pencil"></i>Edit</a>
																		</li>
																		
																		<li>
																			<a class="tooltips" data-title="Edit" href="<?=base_url().'supplier_epcg_list/index/'.$result[$i]->supplier_id?>" ><i class="fa fa-plus"></i>EPCG</a>
																		</li>
																		<li>
																			<a class="tooltips" data-title="Get Estimate" href="<?=base_url().'add_supplier_product/index/'.$result[$i]->supplier_id?>" ><i class="fa fa-plus"></i>Estimate</a>
																		</li>
																		<li>
																			<a class="tooltips" data-title="Set Rate" href="<?=base_url().'add_design_detail/supplier_rate/'.$result[$i]->supplier_id?>" ><i class="fa fa-money"></i>Price</a>
																		</li>
																		<li>
																			<a class="tooltips" data-title="Bank Details" id="bankmodal" data-toggle="modal" onclick="bank_data(<?=$result[$i]->supplier_id?>,<?=$result[$i]->bank_id?>)"><i class="fa fa-bank"></i>Bank Details</a>
																		</li>
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$result[$i]->supplier_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Delete</a>
																	 	</li>
																	   </ul>
																	</div>
													 
													</td>
													
												</tr>
										<?php
											$m++;
										} ?>
											
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
							 
						</div>
					</div>
				
				 
				 
				</div>
			</div>
			 
		</div>
 
<div id="myModal2" class="modal fade myModal2" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cls_btn" data-dismiss="modal" onclick="refreshPage()">&times;</button>
                <h4 class="modal-title">  Bank Detail  </h4>
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
				        <input id="account_no" type="text" name="account_no" placeholder="Account No" required="" class="form-control" required title="Enter Account No"/>
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
					<div class="field-group">
				        <input type="text" id="iban_number" name="iban_number" placeholder="IBAN NO." class="form-control" />    
				    </div>
				
				
            </div>
			
            <div class="modal-footer">
			   <input name="Submit" type="submit" id="submit_btn" value="Add" class="btn btn-info"  />
                <button type="button" class="btn btn-default cls_btn" data-dismiss="modal" onclick="refreshPage()">Close</button>
            </div>
			
			<input type="hidden" name="eid3" id="eid3" />
			
			<input type="hidden" name="suppliermaster" id="suppliermaster" value="1"/>
			
			<input type="hidden" name="eid" id="eid" value="" />
			
			</form>
        </div>
    </div>
</div>
		 
<?php $this->view('lib/footer'); ?>
<script>
function refreshPage(){
    window.location.reload();
} 

$(".select2").select2({
	width:'100%'
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
            url: 	root+'bank_detail/manage1',
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
					setTimeout(function(){ window.location=root+'supplier_list'; },1500);
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'supplier_list'; },1500);
				}
				else  if(obj.res == 3)
				{
					unblock_page("info","Record already exist");
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

$(document).ready(function () {
	$('#sample-table-1').DataTable({
	   "order": [[ 0, "asc" ]],
	   "lengthMenu": [ 50, 10, 25, 75, 100 ],
	   'columnDefs': [
		{
			"targets": 0, // your case first column
			"className": "text-center",
			"width": "4%"
		}]
	});
});
 
function delete_record(deleleid)
{
	main_delete(deleleid,'Supplier_list/deleterecord','supplier_list')
}

$("#add_bank_detail").validate({
		rules: {
			bank_name: {
				required: true
			},
			account_name:{
				required: true
			},
			account_no:{
				required: true
			}
		},
		messages: {
			bank_name: {
				required: "Enter Bank Name"
			},
			account_name: {
				required: "Enter Account Name"
			},
			account_no: {
				required: "Enter Account No"
			}
		}
	});
	
$("#model_add").validate({
		rules: {
			model_name: {
				required: true
			}
		},
		messages: {
			model_name: {
				required: "Enter Model Name"
			}
		}
	});

	$("#edit_form").validate({
		rules: {
			edit_model_name: {
				required: true
			}
		},
		messages: {
			edit_model_name: {
				required: "Enter Model Name"
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
	$.ajax({
            type: "post",
            url: 	root+'Model_list/manage',
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
				   $("#model_add").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Inserted.");
					 setTimeout(function(){ window.location=root+'model_list' },1500);
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

$("#edit_form").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Model_list/edit_record',
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
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'model_list' },1500);
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

function edit_product(packing_model_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"model_list/fetchmodeldata",
              data: {"id": packing_model_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(packing_model_id);
					$("#edit_product_size_id").select2("val",obj.product_size_id);
					$("#edit_model_name").val(obj.model_name);
					 
					unblock_page("",""); 
                  }
              
          }); 

}	

function bank_data(id,bank_id)
{
	if(bank_id == 0)
	{
		$("#myModal2").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(bank_id);
					$("#eid3").val(id);
	}
	else
	{
		 
	 block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"bank_detail/form_edit1",
              data: {"id": bank_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
					$("#myModal2").modal({
						backdrop: 'static',
						keyboard: false
					});
						$("#eid").val(bank_id);
						 
						$("#submit_btn").val("Update");
						$("#bank_name").val(obj.bank_name);
						$("#bank_address").val(obj.bank_address);
						$("#account_name").val(obj.account_name);
						$("#account_no").val(obj.account_no);
						$("#ifsc_code").val(obj.ifsc_code);
						$("#swift_code").val(obj.swift_code);
						$("#bank_ad_code").val(obj.bank_ad_code);
						$("#iban_number").val(obj.iban_number);
						$("#eid3").val(id);
					unblock_page("",""); 
                  }
              
          }); 
	}
}

</script>