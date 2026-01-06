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
									<a href="<?=base_url().'customer_listing'?>">Customer Invoice List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> Upload BL Of <?=$getcompany->c_companyname?>	
							<?php 
							if($mode == 'Edit')
							{
							?>
							<div class="pull-right" >
								<?php
									if(!empty($result->bl_upload))
									{
									?>
											<a href='<?=base_url()."upload/".$result->bl_upload?>' target='_blank' class='btn btn-info'>
										<i class='fa fa-eye'></i>
									</a>
										
											<a class="btn btn-danger" name="shipping_file_delete" id="shipping_file_delete" data-toggle="tooltip" data-title="Delete Image" 
											onclick="delete_image(<?=$result->id?>)" href="javascript:;"><i class="fa fa-trash"></i></a>
									<?php
									}
								?>	
														
							</div>
							<?php
							}
							?>
							</h3>							
							</div>
							 
						</div>
					</div>
					
				<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="payment_form" id="payment_form">
						<!-- <div class="form-group export_bill_html">
							<label class="col-sm-2 control-label" for="form-field-1">
							Export Invoice Number 
							</label>
							<div class="col-sm-4">
								
								<input type="text" name="bill_id" id="bill_id" class="form-control" placeholder="Export Bill" required title="Enter Export Bill"/>
							</div>
						</div>   -->
						<input type="hidden" id="customer_invoice_id<?=$getcompany->upload_bl_id?>"   name="customer_invoice_id" value="<?=$getcompany->upload_bl_id?>" >
						<?php
						if($mode == 'Add')
						{
							?>
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Export Invoice no
						</label>
						<div class="col-sm-4">
							 <?=$getcompany->customer_invoice_no?>
				        </div>
				    </div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Export Invoice Date
						</label>
						<div class="col-sm-4">
							 <?=date('d/m/Y',strtotime($getcompany->invoice_date))?>
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Consign Detail 
						</label>
						<div class="col-sm-4">
							 <?=$getcompany->c_companyname?>
				        </div>
				    </div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="form-field-1">
							Shipping Name 
						</label>
						<div class="col-sm-4">
						<select class="form-control select2" name="shipping_line_id" id="shipping_line_id<?=$shippingdata->shipping_id?>"   title="Select Country" onchange="showdata(this.value)" >
							<option value="">Select Shipping Name</option>	
							<?php
							for($c=0;$c<count($shippingdata);$c++)
							{
								$select = '';
					
								if($shippingdata[$c]->shipping_id==@$result->shipping_id)
								{
									$select = 'selected="selected"'; 
								}
								
							?>
							<option <?=$select?> value="<?=$shippingdata[$c]->shipping_id?>"><?=$shippingdata[$c]->shipping_line_name?></option>	
							<?php
							}
							?>
							</select>
							
						</div>
						
					</div>
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								BL Number
						</label>
						<div class="col-sm-4">
							 <input type="text" name="bl_number" id="bl_number" class="form-control" value="<?=$result->bl_number?>" placeholder="BL Number" required title="Enter BL Number"/>
				        </div>
						<div class="dateshow" style="display:none" >
							<div class="col-sm-2">
								<a href ="javascript:;" 
								onclick ="this.href= document.getElementById('url').value + document.getElementById('bl_number').value"  class="btn btn-primary tooltips" target="_blank" >
								<i class="fa fa-plane"></i> 
								</a>
							</div>
						</div>
				    </div>
					
					<div class="form-group" style="display:none">
										
							<label class="control-label col-sm-2" for="form-field-1"  >
								Url
							</label>
							<div class="col-sm-4">
								<input type="hidden" id="url"  placeholder="Enter URL" class="form-control " name="url" autocomplete="off" value="<?=$shippingdata->free_field_1?>" onchange="showdata(this.value)"/>
							</div>
							
								
					</div>	

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							BL Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date" id="date" class="form-control defualt-date-picker" autocomplete="off" value="<?=date('d-m-Y')?>" placeholder="Select Date" required title="Select Date"/>
				        </div>
				    </div> 	
					
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								BL Type 
						</label>
						<div class="col-sm-4">
							 
							<input type="radio"  name="bl_type" id="bl_type" required title="Select Type" value="Home BL" checked> Home BL
							<input type="radio" name="bl_type" id="bl_type" required title="Select Type" value="Master BL"> Master BL
				        </div>
				    </div> 
					
										
											
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remark" id="remark" class="form-control" placeholder="Remarks" ></textarea>
				        </div>
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								BL Upload
						</label>
						<div class="col-sm-4">
							 <input type="file" name="bl_upload" id="bl_upload" required class="form-control" title="Please BL upload"/>
				        </div>
				    </div>


							<?php
							}
						else{
							  
							?>
				
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Export Invoice no
						</label>
						<div class="col-sm-4">
							 <?=$getcompany->customer_invoice_no?>
				        </div>
				    </div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Export Invoice Date
						</label>
						<div class="col-sm-4">
							 <?=date('d/m/Y',strtotime($getcompany->invoice_date))?>
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Consign Detail 
						</label>
						<div class="col-sm-4">
							 <?=$getcompany->c_companyname?>
				        </div>
				    </div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="form-field-1">
							Shipping Name 
						</label>
						<div class="col-sm-4">
						<select class="form-control select2" name="shipping_line_id" id="shipping_line_id<?=$shippingdata->shipping_id?>"   title="Select Country" onchange="showdata(this.value)" onclick="ShowHideDiv(this.selected)">
							<option value="">Select Shipping Name</option>	
							<?php
							for($c=0;$c<count($shippingdata);$c++)
							{
								$select = '';
					
								if($shippingdata[$c]->shipping_id==@$result->shipping_id)
								{
									$select = 'selected="selected"'; 
								}
								
							?>
							<option <?=$select?> value="<?=$shippingdata[$c]->shipping_id?>"><?=$shippingdata[$c]->shipping_line_name?></option>	
							<?php
							}
							?>
							</select>
							
						</div>
						
					</div>
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								BL Number
						</label>
						<div class="col-sm-4">
							 <input type="text" name="bl_number" id="bl_number" class="form-control" value="<?=$result->bl_number?>" placeholder="BL Number" required title="Enter BL Number"/>
				        </div>
						<div class="dateshow" style="display:none" >
							<div class="col-sm-2">
							
								<a href ="javascript:;" 
								onclick ="this.href= document.getElementById('url').value + document.getElementById('bl_number').value"  class="btn btn-primary tooltips" target="_blank" value="<?=$shippingdata[$c]->shipping_id?>">
								<i class="fa fa-plane"></i> 
								</a>
							</div>
						</div>
				    </div>
					
													
						<div class="form-group" style="display:none">
										
							<label class="control-label col-sm-2" for="form-field-1"  >
								Url
							</label>
							<div class="col-sm-4">
								<input type="hidden" id="url"  placeholder="Enter URL" class="form-control " name="url" autocomplete="off" value="<?=$result->url?>" onchange="showdata(this.value)"/>
							</div>
							
								
						</div>	
						
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							BL Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date" id="date" class="form-control defualt-date-picker"  autocomplete="off" value="<?=date('d-m-Y',strtotime($result->date))?>" placeholder="Select Date" required title="Select Date"/>
				        </div>
				    </div> 	
					
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								BL Type 
						</label>
						<div class="col-sm-4">
							 
							<input type="radio"  name="bl_type" id="bl_type" required title="Select Type" value="Home BL" <?php echo ($result->bl_type== 'Home BL') ?  "checked" : "" ;  ?>>Home BL
							<input type="radio" name="bl_type" id="bl_type" required title="Select Type" value="Master BL" <?php echo ($result->bl_type== 'Master BL') ?  "checked" : "" ;  ?>>Master BL
				        </div>
				    </div> 
					
										
											
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remark" id="remark" class="form-control" placeholder="Remarks" ><?=$result->remark?></textarea>
				        </div>
				    </div> 
				    <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								BL Upload
						</label>
						<div class="col-sm-4">
							 <input type="file" name="bl_upload" id="bl_upload"  class="form-control" title="Please BL upload"/>
				        </div>
						<div class="col-sm-2" >
						<?php
						if(!empty($result->bl_upload))
						{
						?>
								<a href='<?=base_url().'Upload_bl/download/'.$result->bl_upload?>' target='_blank' class='btn btn-info'>
												<i class='fa fa-download'></i>
											</a>
								
						<?php
						}
						?>						
				        </div>
				    </div>
					<input type="hidden" id="bl_id" name="bl_id" value="<?=$result->id?>"  />	
					<input type="hidden" id="bl_file" name="bl_file" value="<?=$result->bl_upload?>"  />	
							<?php
						}
						?>
						
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" id="Submit" class="btn btn-success" />
							
								<button type="submit" class="btn btn-success" name="save_next_btn" value="1">
											Save & Exit
								</button>
								
								<a href="<?=base_url().'customer_listing'?>" class="btn btn-danger">
									Cancel
								</a>
																	
						</div>    	
				</div> 	
							
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />	
										
				 	<input type="hidden" id="customer_invoice_id" name="customer_invoice_id" value="<?=$id?>"  />	
						
				</form>
					</div>
		 	</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>
function ShowHideDiv(shipping_line_id)
{
       	 
		if(shipping_line_id == true)
		{
			$(".dateshow").show();	
		}
		else
		{
			$(".dateshow").hide();
		}
}

function showdata(value)
{	 
	if(value != "")
	{
	 block_page();
	   $.ajax({ 
              type: "POST", 
              url: root+"Upload_bl/getdata",
              data: {"id": value}, 
              success: function (response) 
			  { 
			   
					var obj = JSON.parse(response);
					
					if(obj.free_field_1 !== "")
					{
						$(".dateshow").show()
						
						
						$("#url").val(obj.free_field_1);
					}
					else
					{
						//$("#url").val(obj.free_field_1);
						$(".dateshow").val("0");
						$(".dateshow").hide()	
						
					}
				
				   unblock_page("","");
			  }
	 });
	}
	 
}

$(document).ready(function(){
	load_customer_bill();
})
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
 });
  
$(".select2").select2({
	width:'100%' 
})
$("#payment_form").validate({
		rules: {
			customer_id: {
				required: true
			},
			paid_amount:{
				required: true
			}
		},
		messages: {
			customer_id: {
				required: "Select Customer"
			},
			paid_amount:{
				required: "Enter Paid Amount",
				max:"Please check due amount"
			} 
		}
	});
	


$("#payment_form").submit(function(event) {
	event.preventDefault();
	if(!$("#payment_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	
	// postData.append("mode","1");
	 $.ajax({
            type: "post",
            url: 	root+'upload_bl/manage',
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
				    $("#payment_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					var val = $(document.activeElement).val();
					if(val == "1")
					{
						setTimeout(function(){ window.location=root+'customer_listing'},1500);
				 	}
					else
					{
						setTimeout(function(){ window.location = root+"upload_bl/form_edit/"+obj.id },1500);
					}
				   
			   }
			   else if(obj.res==2)
			   {
				    $("#payment_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					var val = $(document.activeElement).val();
					if(val == "1")
					{
						setTimeout(function(){ window.location=root+'customer_listing'},1500);
				 	}
					else
					{
						setTimeout(function(){ location.reload(); },1500);
					}
					
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
 
function load_due_bill(val)
{
	if(val == 1)
	{
		$(".export_bill_html").show()
	}
	else{
		$(".export_bill_html").hide()
	}
}
function load_customer_bill()
{
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"upload_bl/fetchdata",
           
           success: function (response) { 
				var obj= JSON.parse(response);
				console.log(obj)
			 	if(obj.payment_recieve_type == "1")
				{
				  $(".export_bill_html").show()
				  $("#bill_id").html(obj.str)
			 	}
				else
				{
					$(".export_bill_html").hide();
					 
				}
				 	unblock_page("",""); 
		}
     }); 
}
function load_bill(value)
{
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"add_payment/getdueamount",
           data: {"id": value}, 
           success: function (response) { 
				//console.log(response)
                
                $("#paid_amount").attr("max",response)
			 	 	unblock_page("",""); 
		}
     }); 
}

function delete_image(id)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'Upload_bl/delete_image',
              data: {
                "id"			: id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"File/Image Successfully Deleted");
					setTimeout(function(){ location.reload(); },1500);
					
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}


</script>
<?php
$selected  = ($result->url !== "")?"true":"false";
echo "<script>ShowHideDiv(".$selected.")</script>";

	
?>
  