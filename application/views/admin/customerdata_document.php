<?php  $this->view('lib/header');  ?>

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
									&nbsp;Customer Documents
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3> Document Of <?=$cust_data->c_name?></h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="row">
						<div class="col-sm-12">
							 
							 <div class="panel-body form-body">
								<div class="col-md-8 col-md-offset-1">
								
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="customer_document_form" name="customer_document_form">
										
											<input type="hidden" id="customer_data<?=$cust_data->id?>"   name="customer_data" value="<?=$cust_data->id?>" >
											
											<div class="form-group">
												<label class="control-label col-sm-4" for="form-field-1">
												Document Type:
												</label>
												<div class="col-sm-6" >
													<label class="radio-inline" title="Select One Option">
														<input type="radio" name="radiofiles" id="scancopy" value="1" <?=($detail->document_type == "1")?"checked":""?>>Scan Copy
													</label>
													<label class="radio-inline">
														<input type="radio" name="radiofiles" id="physical" value="2" <?=($detail->document_type == "2")?"checked":""?> > Physical Copy 			
													</label>
													<label class="radio-inline">
														<input type="radio" name="radiofiles" id="both" value="3" <?=($detail->document_type == "3")?"checked":""?> > Both 			
													</label><br>
													
													<!--To Show Error  -->											
													<label id="radiofiles-error" class="error" for="radiofiles"></label>	<!--To Show Error  -->											
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Document Send Postal Address
												</label>
												<div class="col-sm-6">
													<textarea id="postal_address" name="postal_address" placeholder="Postal Address" class="form-control"  title="Document Send Postal Address"><?=strip_tags($detail->document_address)?></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Notes
												</label>
												<div class="col-sm-6">
													<textarea id="notes" name="notes" placeholder="Notes" class="form-control"  title="Notes"><?=strip_tags($detail->notes)?></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field 1
												</label>
												<div class="col-sm-4">
													<input type="text" id="field1" name="field1" placeholder="Field 1" class="form-control" value="<?=$detail->field_1?>" />
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field 2
												</label>
												<div class="col-sm-4">
													<input type="text" id="field2" name="field2" placeholder="Field 2" class="form-control" value="<?=$detail->field_2?>" />
												</div>
											</div> 
										
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field 3
												</label>
												<div class="col-sm-4">
													<input type="text" id="field3" name="field3" placeholder="Field 3" class="form-control" value="<?=$detail->field_3?>" />
												</div>
											</div> 
										
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field 4
												</label>
												<div class="col-sm-4">
													<input type="text" id="field4" name="field4" placeholder="Field 4" class="form-control" value="<?=$detail->field_4?>" />
												</div>
											</div> 
										
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field 5
												</label>
												<div class="col-sm-4">
													<input type="text" id="field5" name="field5" placeholder="Field 5" class="form-control" value="<?=$detail->field_5?>" />
												</div>
											</div> 
											
											<div class="form-group design_file_control one_by_one">
												<label class="col-sm-4 control-label" for="form-field-1">
													File Upload
												</label>
												<div class="col-sm-4">
													<input type="file" placeholder="File Upload" id="file_upload" class="form-control" name="file_upload" accept="image/jpeg,image/png,image/jpg,application/pdf">
												</div>
												<div class="col-sm-2">
													<?php
													if(!empty($detail->file_upload))
													{
														echo "<img src='".base_url()."upload/customer_document/".$detail->file_upload."' width='110px' height='50px' />";
													}
													?>
												</div>
											</div>
										
											<div class="form-group design_file_control one_by_one">
												<label class="col-sm-4 control-label" for="form-field-1">
												File Upload 1
												</label>
												<div class="col-sm-4">
													<input type="file" placeholder="File Upload 1" id="file_upload1" class="form-control" name="file_upload1" accept="image/jpeg,image/png,image/jpg,application/pdf">
												</div>
												<div class="col-sm-2">
													<?php
													if(!empty($detail->file_upload1))
													{
														echo "<img src='".base_url()."upload/customer_document/".$detail->file_upload1."' width='110px' height='50px' />";
													}
													?>
												</div>
											</div>
										
											<br>
											<div class="col-md-offset-4">
												<div class="form-group " style="" >
													<button type="submit" class="btn btn-success">
														Save
													</button>
													<button type="button"  class="btn btn-success" onclick="save_and_next();">
														Save & Next
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
										<input type="hidden" name="customer_add_detail_id" id="customer_add_detail_id" value="<?=$detail->customer_id?>"/> 
										<input type="hidden" name="next" id="next" value="0"/>
										<input type="hidden" name="file_upload_filename" id="file_upload_filename" value="<?=$detail->file_upload?>"/>
										<input type="hidden" name="file_upload1_filename" id="file_upload1_filename" value="<?=$detail->file_upload1?>"/>
								</form>
						
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
<?php $this->view('lib/footer'); ?>
<script>
$("#customer_document_form").validate({
		rules: {
			radiofiles: {
				required: true
			}
		},
		messages: {
			radiofiles: {
				required: "Select One Document"
			}
		}
	});
	
function save_and_next()
{
	$("#next").val(1);
	$("#customer_document_form").submit();
}

$(function () {
            $('input').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });

 $(function () {
            $('textarea').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });	
		
$("#customer_document_form").submit(function(event) {
	event.preventDefault();
	if(!$("#customer_document_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'Customerdata_document/manage',
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
					if($("#next").val() == 1)
					{
						setTimeout(function(){ window.location = root+'customerdata_document/index/<?=$cust_data->id?>'; },100);
					}
					else
					{
						setTimeout(function(){ location.reload(); },100);
					}
			   }
			   else if(obj.res==2)
			   {
				   
					unblock_page("success","Sucessfully Updated.");
					if($("#next").val() == 1)
					{
						
						setTimeout(function(){ window.location = root+'customerdata_document/index/<?=$cust_data->id?>'; },100);
					 }
					else
					{
						setTimeout(function(){ location.reload(); },100);
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


</script>