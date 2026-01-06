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
									<a href="<?=base_url().'agent_list'?>">Agent</a>
								</li>
							 
							</ol>
							
							<div class="page-header">
								<h3> 
									Add New Agent
									<a href="<?php echo base_url('agent_list'); ?>" style="float:right;" type="button" class="btn btn-info">
										View Agent
									</a>
								</h3>
							</div>
						</div>
					</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default">
							<div class="panel-body">
							<div class="col-md-8 col-md-offset-1">
							<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="agent_form" id="agent_form">
               		
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
											Agent Name
									</label>
									<div class="col-sm-4">
										<input type="text" id="agent_name" name="agent_name" autocomplete="off" placeholder="Agent Name" required="" class="form-control" value="<?=$edit_record->agent_name; ?>"  autofocus="autofocus" />
									</div>
								</div> 	
								
								<div class="form-group one_by_one">
									<label class="col-sm-3 control-label" for="form-field-1">
										Address
									</label>
									<div class="col-sm-4">
										<textarea type="text" placeholder="Address" id="address" autocomplete="off" class="form-control" name="address" value="" required="" title="Enter Address"><?=strip_tags($edit_record->address); ?></textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
										City
									</label>
									<div class="col-sm-4">
										<input type="text" id="city" name="city" placeholder="City"  autocomplete="off" class="form-control" value="<?=$edit_record->city; ?>" title="Enter Your City"/>
									</div>
								</div>
								
								<div class="form-group">
									
									<label class="col-sm-3 control-label" for="form-field-1">
										Country
									</label>
									<div class="col-sm-4">
										<select class="select2" name="country[]" id="country" required title="Select Country">
											<option value="<?=$edit_record->country; ?>" >Select Country</option>
											<?php
											for($c=0;$c<count($countrydata);$c++)
											{ 
												$select = '';
													
												if($countrydata[$c]->id==$edit_record->c_name)
												{
													$select = 'selected="selected"'; 
												}
												?>
											<option <?=$select?> value="<?=$countrydata[$c]->id?>"><?=$countrydata[$c]->c_name?></option>	
											<?php
											}
											?>
										</select>
										<!--To Show Error  -->											
										<label id="country-error" class="error" for="country"></label>
										<!--To Show Error  -->	
									</div>		
									
									<div style="margin-top: 4px;">
										<button type="button" class="btn btn-primary tooltips" data-title="Add Country" data-toggle="modal" data-target="#countryadd" data-keyboard="false" data-backdrop="static">+</button>
									</div>
									
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
										Contact No
									</label>
									<div class="col-sm-4">
										<input type="text" id="contact_no" name="contact_no" placeholder="Contact No" autocomplete="off" onkeypress="return onlyNumberKey(event)" class="form-control" value="<?=$edit_record->contact_no; ?>" />
									</div>
								</div>
								
								 <div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
											Bank Account No
									</label>
									<div class="col-sm-4">
										<input type="text" id="account_no" name="account_no" placeholder="Bank Account No" autocomplete="off" onkeypress="return onlyNumberKey(event)"  class="form-control" required title="Enter Bank Account No"
										value="<?=$edit_record->bank_ac_no; ?>" />
									</div>
								 </div>
								 
								 <div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
											Bank Details
									</label>
									<div class="col-sm-4">
										<textarea id="bank_details" name="bank_details" placeholder="Bank Details" required class="form-control" autocomplete="off" title="Enter Bank Details"><?=strip_tags($edit_record->bank_details); ?></textarea>
									</div>
								</div>
									
								<div class="form-group">
								
									<label class="col-sm-3 control-label" for="form-field-1">
										Payment Method
									</label>
									<div class="col-sm-4">
										<input type="text" id="payment_mode" name="payment_mode" class="form-control" placeholder="Payment Method" required title="Enter Payment Method" value="<?=$edit_record->payment_mode; ?>" />
										<div id="suggesstion-box"></div>
										<!--To Show Error  -->											
										<label id="payment_method-error" class="error" for="payment_method"></label>
										<!--To Show Error  -->	
									</div>		
															
								</div>	
								
								<div class="form-group">
								
									 <label class="col-sm-3 control-label" for="form-field-1">
											Payment Terms
									</label>
									<div class="col-sm-4">
										<input type="text" id="payment_terms" name="payment_terms" required title="Enter Payment Terms" class="form-control" placeholder="Payment Terms" value="<?=$edit_record->payment_terms; ?>" />
										<div id="suggesstion-box"></div>
										<!--To Show Error  -->											
										<label id="payment_terms-error" class="error" for="payment_terms"></label>
										<!--To Show Error  -->	
									</div>
									
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
											Fix Commission
									</label>
									<div class="col-sm-4">
										<input type="text" id="fix_commission" name="fix_commission" placeholder="Fix Commission" autocomplete="off" onkeypress="return onlyNumberKey(event)" title="Enter Account No" class="form-control"  value="<?=$edit_record->fix_amount; ?>" />
									</div>
								 </div>
								 
								 <div class="form-group" >
									<label class="col-sm-3 control-label" for="form-field-1">
											Percentage %
									</label>
									<div class="col-sm-4">
										<input type="text" id="percentage" name="percentage" placeholder="Percentage %" autocomplete="off" onkeypress="return onlyNumberKey(event)" title="Enter Account No" class="form-control"  value="<?=$edit_record->percentage; ?>" />
									</div>
								 </div>
								
								<div class="form-group" style="">
																		
									<label class="col-sm-3 control-label" for="form-field-1"   >
										Join Date
									</label>
									<div class="col-sm-4">
										<input type="text" id="date" autocomplete="off" placeholder="Select Date" class="form-control defualt-date-picker" name="date" autocomplete="off" value="<?=(date('d-m-Y',strtotime($edit_record->join_date))=="01-01-1970")?"":date('d-m-Y',strtotime($edit_record->join_date))?>" required title="Enter Joining Date"/>
									</div>
												
								</div>	
								
								<div class="form-group">
									<label class="col-sm-3 control-label " for="form-field-1">
									Remarks:
									</label>
									<div class="col-sm-4">
										<textarea type="text" placeholder="Remarks" autocomplete="off" id="remarks" class="form-control" name="remarks" autocomplete="off" ><?=strip_tags($edit_record->remarks); ?></textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
										Agreement
									</label>
									<div class="col-sm-4">
										<input type="file" placeholder="Upload Agreement" id=" " class="form-control" name="agreement_upload"  accept="image/jpeg,image/png,image/jpg,application/pdf"  title="Choose File">
									</div>
										<div class="col-md-4">
												<?php 
												if($edit_record->agreement_logo != "No file" && $edit_record->agreement_logo != "")
												{
													
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
													href="'.base_url().'/upload/agreement_doc/'.$edit_record->agreement_logo.'" target="_blank"><i class="fa fa-eye"></i></a>';
													echo '&nbsp&nbsp';
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="Download" 
													href="'.base_url().'Agent_list/download/'.$edit_record->agreement_logo.'" target="_blank"><i class="fa fa-download"></i></a>';echo '&nbsp&nbsp';
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="Delete File" 
													onclick="delete_image('.$edit_record->id.')" href="javascript:;" ><i class="fa fa-trash"></i></a>';
													
												}	
												
												?>
												
										</div>
									
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
										Agreement 1
									</label>
									
									<div class="col-sm-4">
										<input type="file" placeholder="Upload Agreement" id="agreement_upload1" class="form-control" name="agreement_upload1" accept="image/jpeg,image/png,image/jpg,application/pdf">
									</div>
										<div class="col-md-4">
												<?php 
												if($edit_record->agreement_logo1 != "No file" && $edit_record->agreement_logo != "")
												{
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
													href="'.base_url().'/upload/agreement_doc/'.$edit_record->agreement_logo1.'" target="_blank"><i class="fa fa-eye"></i></a>';
													echo '&nbsp&nbsp';
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="Download" 
													href="'.base_url().'Agent_list/download/'.$edit_record->agreement_logo1.'" target="_blank"><i class="fa fa-download"></i></a>';
													echo '&nbsp&nbsp';
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="Delete File" 
													onclick="delete_image1('.$edit_record->id.')" href="javascript:;" ><i class="fa fa-trash"></i></a>';
												}	
												?>
												
										</div>
									
								</div>
								
								<div class="form-group ">
									<label class="col-sm-3 control-label" for="form-field-1">
										Agreement 2
									</label>
									<div class="col-sm-4">
										<input type="file" placeholder="Upload Agreement" id="agreement_upload2" class="form-control" name="agreement_upload2" accept="image/jpeg,image/png,image/jpg,application/pdf">
									</div>
										<div class="col-md-4">
												<?php 
												if($edit_record->agreement_logo2 != "No file" && $edit_record->agreement_logo != "")
												{
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="View" 
													href="'.base_url().'/upload/agreement_doc/'.$edit_record->agreement_logo2.'" target="_blank"><i class="fa fa-eye"></i></a>';
													echo '&nbsp&nbsp';
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="Download" 
													href="'.base_url().'Agent_list/download/'.$edit_record->agreement_logo2.'" target="_blank"><i class="fa fa-download"></i></a>';
													echo '&nbsp&nbsp';
													echo '<a class="tooltips" name="agreement_upload" id="agreement_upload"  data-toggle="tooltip"  data-title="Delete File" 
													onclick="delete_image2('.$edit_record->id.')" href="javascript:;" ><i class="fa fa-trash"></i></a>';
												}	
												?>
												
										</div>
									
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label " for="form-field-1">
									Free Field 1:
									</label>
									<div class="col-sm-4">
										<input type="text" placeholder="Free Field 1" autocomplete="off" id="ff1" class="form-control" name="ff1" value="<?=$edit_record->free_field_1; ?>" autocomplete="off" >
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label " for="form-field-1">
									Free Field 2:
									</label>
									<div class="col-sm-4">
										<input type="text" placeholder="Free Field 2" autocomplete="off" id="ff2" class="form-control" name="ff2" value="<?=$edit_record->free_field_2; ?>" autocomplete="off" >
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label " for="form-field-1">
									Free Field 3:
									</label>
									<div class="col-sm-4">
										<input type="text" placeholder="Free Field 3" autocomplete="off" id="ff3" class="form-control" name="ff3" value="<?=$edit_record->free_field_3; ?>" autocomplete="off" >
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label" for="form-field-1">
										Is Active:
									</label>
									<div class="col-sm-4">													
										<label class="radio-inline">
											<input type="radio" name="isactive" id="yes" value="yes" <?=($edit_record->is_active == "Yes")?"checked":""?> checked >Yes
										</label>
										<label class="radio-inline">
											<input type="radio" name="isactive" id="no" value="no" <?=($edit_record->is_active == "No")?"checked":""?> >No			
										</label>
										
										<!--To Show Error  -->	
										<label id="isactive-error" class="error" for="isactive"></label>	
										<!--To Show Error  -->
									</div>
								</div>
								
															 
								 
									
							<div class="col-md-offset-3">
								<div class="form-group">
									<input name="Submit" type="submit" value="Save" class="btn btn-success" />
									
										<a href="<?=base_url().'Agent_list'?>" class="btn btn-danger">
														Cancel
										</a>						
								</div>    	
							</div> 	
							
							<input type="hidden" id="id" name="id" value="<?=$edit_record->id?>"/>				
							<input type="hidden" id="mode" name="mode"    value="<?=$mode?>"  />	
							
										
							</form>
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
$this->view('lib/addcountry');
?>

<script>

function onlyNumberKey(evt) 
    {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
	
 
 $(document).ready(function() {
	 
    $( "#payment_terms" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Agentmaster/search",
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



   $( "#payment_mode" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Agentmaster/searchmethod",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.payment_mode;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 
 
});
		
$(".select2").select2({
	width:'100%'
});

$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 
$("#agent_form").validate({
		rules: {
			agent_name: {
				required: true
			},
			country:{
				required: true
			}
		},
		messages: {
			agent_name: {
				required: "Agent Name Required"
			},
			country:{
				required: "Country Required"
			}
			
		}
});

$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   
			});
		});
		

$("#agent_form").submit(function(event) {
	event.preventDefault();
	if(!$("#agent_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'Agentmaster/manage',
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
				    $("#agent_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'agent_list'; },1500);
				}
				else  if(obj.res==2)
			   {
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'agent_list'; },1500);
				}
				else  if(obj.res==3)
			   {
				    unblock_page("error","Record already exist");
					$(".select2").select2('val','');
					//setTimeout(function(){ window.location=root+'agent_list'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'agent_list'; },1500);
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
            url: 	root+'supplier_epcg_list/edit_record',
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
				     unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Agentmaster/form_edit/<?=$edit_record->id?>'; },1500);
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

function delete_record(deleleid)
{
	main_delete(deleleid,'Agentmaster/form_edit/<?=$edit_record->id?>')
}

function delete_image(deleleid)
{
	main_delete(deleleid,'Agentmaster/delete_image','agent_list')
	
}

function delete_image1(deleleid)
{
	main_delete(deleleid,'Agentmaster/delete_image1','agent_list')
	
}

function delete_image2(deleleid)
{
	main_delete(deleleid,'Agentmaster/delete_image2','agent_list')
	
}
</script>