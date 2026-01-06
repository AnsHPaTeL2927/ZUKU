<?php 
$this->view('lib/header'); 
//print_r($m);
//exit;
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
									<a href="#"> Master&nbsp;&nbsp; </a>   /  &nbsp;&nbsp;Bank 
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Bank   
							<div class="pull-right">
							  <button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal">+ Bank</button>
							</div>
							</h3>
							 </div>
						</div>
					</div>
					 
	 				
	                 <div class="row">
						<div class="col-md-12">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Bank Detail 
									
							  </div>
								<div class="panel-body">
																	
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
												
													<th>Bank Name</th>
													<th>Bank Address</th>
													<th>Account Name</th>
													<th>Account No</th>
													<th>IFSC Code</th>
													<th>Swift Code</th>
													<th>Bank Ad Code No</th>
													<th>Action</th>
													
												</tr>
											</thead>
											<tbody>
										 	<?php 
											for($i=0; $i<count($bank);$i++)
											{
											?>
												<tr>
												
													<td><?=$bank[$i]->bank_name; ?></td>
													<td><?=$bank[$i]->bank_address; ?></td>
													<td><?=$bank[$i]->account_name; ?></td>
													<td><?=$bank[$i]->account_no; ?></td>
													<td><?=$bank[$i]->ifsc_code; ?></td>
													<td><?=$bank[$i]->swift_code; ?></td>
													<td><?=$bank[$i]->bank_ad_code; ?></td>
													<td>
														<?php 
														 
														if(empty($bank[$i]->bank_id))
														{
														?>
															<div class="dropdown" style="float: left;width: 68%;">
																<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																	<span class="caret"></span></button>
																	<ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_bank(<?=$bank[$i]->id?>)" ><i class="fa fa-pencil"></i> Edit</a>
																		</li>
																		<li>
																			<a class="tooltips" data-title="Delete" href="javascript:;" onclick="delete_record(<?=$bank[$i]->id?>)" ><i class="fa fa-trash"></i> Delete</a>
																		</li>
																		
																	</ul>
																</div>
														<?php 
														} 
														?>		
														</td>
												</tr>
										<?php } ?>
											
												
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

 
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cls_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">  Bank </h4>
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
				   <input type="hidden" name="eid" id="eid" />            
				   <input type="hidden" name="sent_msg" id="sent_msg" value="1"/>            
				   <input type="hidden" name="phone_no" id="phone_no" value="<?=$company_detail[0]->otp_mobile_no?>"/>            
				
            </div>
            <div class="modal-footer">
			   <input name="Submit" type="submit" id="submit_btn" value="Add" class="btn btn-info"  />
                <button type="button" class="btn btn-default cls_btn" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>
 
	 
<?php $this->view('lib/footer'); ?>
<div id="myModal_otp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">OTP Verify</h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="otp_verify" id="otp_verify">
               
            <div class="modal-body">
                    <div class="field-group">
				        <strong>Enter OTP</strong>
						<input type="text" id="otp" name="otp" placeholder="OTP" required="" class="form-control" autocomplete="off" />
				    </div>                
		     </div>
            <div class="modal-footer">
				<input   type="button" value="Resend OTP" class="btn btn-info resend_otp_btn"   />
				<input   type="button" value="Verify" class="btn btn-success"  onclick="check_otp_fun()" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="check_otp" id="check_otp" />
			<input type="hidden" name="verify_for" id="verify_for" />
			     
			</form>
        </div>
    </div>
</div>
<script>
$(".cls_btn").click(function(){
	window.location=root+'bank_detail'; 
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
					setTimeout(function(){ window.location=root+'bank_detail'; },1500);
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'bank_detail'; },1500);
				}
				else  if(obj.res == 3)
				{
					unblock_page("info","Record already exist");
				}
				else  if(obj.res == 4)
				{
					
					$("#check_otp").val(obj.otp);
					$(".resend_otp_btn").attr("onclick","resend_mobile_otp()");
					  $("#verify_for").val(2);
					$("#myModal_otp").modal({
						backdrop: 'static',
						keyboard: false
					});  
					unblock_page("success","OTP Sent Sucessfully");
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
function resend_mobile_otp()
{
	  block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"company_detail/mobile_update",
              data:
			  {
					"s_id"			: 1,
					"otp_mobile_no"	: $("#otp_mobile_no").val() 
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				    if(obj.res == 4)
					{
						
						$("#check_otp").val(obj.otp);
						$(".resend_otp_btn").attr("onclick","resend_mobile_otp()");
						  $("#verify_for").val(2);
						$("#myModal_otp").modal({
							backdrop: 'static',
							keyboard: false
						});  
						unblock_page("success","OTP Sent Sucessfully");
					}
					else if(obj.res == 2)
					{
						unblock_page("error","Please check Mobile No.");
					}
                  }
              
          }); 
	 
}
function check_otp_fun()
{
	 if($("#otp").val()  == "")
	 {
		 $("#otp").focus()
			toastr['error']("OTP can't blank.");
			return false;
	 }
	 
		block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"company_detail/checkotp",
              data: {
					 
					"check_otp"	: $("#otp").val() 
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				    if(obj.res == 1)
					{
						 
						 $("#sent_msg").val(0);
						 	$("#myModal_otp").modal('hide');
							$("#myModal_mobileno").modal({
								backdrop: 'static',
								keyboard: false
							});  
							$("#add_bank_detail").submit();
						 
						 
						unblock_page("success","OTP Verify Sucessfully.");
					}
					else if(obj.res == 0)
					{
						unblock_page("error","Wrong OTP.");
					}
                  }
              
          }); 
}

function edit_bank(id)
{
	 block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"bank_detail/form_edit",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
						$("#eid").val(id);
						$("#submit_btn").val("Update");
						$("#bank_name").val(obj.bank_name);
						$("#bank_address").val(obj.bank_address);
						$("#account_name").val(obj.account_name);
						$("#account_no").val(obj.account_no);
						$("#ifsc_code").val(obj.ifsc_code);
						$("#swift_code").val(obj.swift_code);
						$("#bank_ad_code").val(obj.bank_ad_code);
						$("#iban_number").val(obj.iban_number);
					 
					unblock_page("",""); 
                  }
              
          }); 

}	

function delete_record(deleleid)
{
	main_delete(deleleid,'bank_detail/del','bank_detail')
}
</script>