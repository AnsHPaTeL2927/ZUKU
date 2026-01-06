<?php 
$this->view('lib/header'); 
 
?>	


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
									<a href="<?=base_url().'supplier_list'?>">Supplier List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$mode?> Supplier </h3>
							</div>
							 
						</div>
					</div>
						<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="supplier_form" id="supplier_form" >
               		
					<input type="hidden" name="sup_id" id="sup_id" value="<?=$edit_record->supplier_id?>"/>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="name">
								Supplier Company Name
						</label>
						<div class="col-sm-4">
							<input type="text" id="company_name" name="company_name" placeholder="Supplier Company Name"  required="" title="Enter Company Name" class="form-control" autocomplete="off" value="<?=$edit_record->company_name?>" autofocus="autofocus" />
							
							<input type="hidden" id="edit_companyname" name="edit_companyname" value="<?=$edit_record->company_name?>" >
						</div>
					 </div>
				    <div class="form-group">
						<label class="col-sm-2 control-label" for="number">
								Supplier GST No
						</label>
						<div class="col-sm-4">
							<input type="text" id="supplier_gstno" name="supplier_gstno" placeholder="Supplier Gst No" required="" title="Enter Gst No" class="form-control"  value="<?=$edit_record->supplier_gstno?>" />
						</div>
					 </div>
					 <div class="form-group">
						<label class="col-sm-2 control-label" for="number">
								Supplier PAN No
						</label>
						<div class="col-sm-4">
							<input type="text" id="supplier_panno" name="supplier_panno" placeholder="Supplier Pan No"  title="Enter Pan No" class="form-control"  value="<?=$edit_record->supplier_panno?>" />
						</div>
					 </div>
					  <div class="form-group">
						<label class="col-sm-2 control-label" for="number">
								Supplier IEC NO
						</label>
						<div class="col-sm-4">
							<input type="text" id="supplier_iecno" name="supplier_iecno" placeholder="Supplier IEC NO"  title="Enter Supplier IEC NO" class="form-control" value="<?=$edit_record->supplier_iecno?>" />
						</div>
					 </div>
					  <div class="form-group">
				        <label class="col-sm-2 control-label" for="address">
								Supplier Address
						</label>
						<div class="col-sm-4">
							<textarea id="supplier_address" autocomplete="off" name="supplier_address" placeholder="Supplier Address" required="" class="form-control" required title="Enter Supplier Address" ><?=strip_tags($edit_record->address)?></textarea>
						</div>
						</div> 
						
						
						<div class="form-group">
				        <label class="col-sm-2 control-label" for="address">
								Supplier Other Company
						</label>
						<div class="col-sm-4">
						<input type="text" id="supplier_other_company" name="supplier_other_company" placeholder="Supplier Other Company"  required="" class="form-control" value="<?=$edit_record->supplier_other_company?>" />
						</div>
						</div>
						
						<div class="form-group">
				        <label class="col-sm-2 control-label" for="name">
								Supplier Person Name
						</label>
						<div class="col-sm-4">
							<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Person Name"  required="" class="form-control" value="<?=$edit_record->supplier_name?>" />
				        </div>
				    </div> 	
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="number">
								Supplier Mobile No
						</label>
						<div class="col-sm-4">
							<input type="text" id="supplier_contactno" name="supplier_contactno"  placeholder="Supplier Mobile No" required="" onkeypress="return isNumber(event)"  class="form-control" value="<?=$edit_record->supplier_contactno?>" />
				        </div>
				    </div> 
					
						 <div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
										Permission File No
								</label>
								<div class="col-sm-4">
									<input type="text" id="permission_file_no" name="permission_file_no" placeholder="Permission File No"   class="form-control"  value="<?=$edit_record->permission_file_no?>" />
								</div>
						</div>
						
						 <div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
										Permission No
								</label>
								<div class="col-sm-4">
									<input type="text" id="permission_no" name="permission_no" placeholder="Permission No"   class="form-control"  value="<?=$edit_record->permission_no?>" />
								</div>
						</div>
					 	<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									  Permission Date
							</label>
							<div class="col-sm-4">
								<input type="text" id="permission_date" name="permission_date" placeholder="Permission Date"   class="form-control defualt-date-picker"  value="<?=(date('d-m-Y',strtotime($edit_record->permission_date))=="01-01-1970")?"":date('d-m-Y',strtotime($edit_record->permission_date))?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Circular No 
							</label>
							<div class="col-sm-4">
								<input type="text" id="sup_circular_no" name="sup_circular_no" placeholder="Supplier Circular No"  class="form-control"   title="Enter Circular No" value="<?=strip_tags($edit_record->circular_no)?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Circular Date 
							</label>
							<div class="col-sm-4">
								<input type="text" id="sup_circular_date" name="sup_circular_date" autocomplete="off"  placeholder="Supplier Circular Date"  class="form-control defualt-date-picker"   title="Enter Circular Date" value="<?=(date('d-m-Y',strtotime($edit_record->circular_date))=="01-01-1970")?"":date('d-m-Y',strtotime($edit_record->circular_date))?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Expiry Date
							</label>
							<div class="col-sm-4">
								<input type="text" id="expiry_date" name="expiry_date" placeholder="Expiry Date" autocomplete="off" class="form-control"  value="<?=$edit_record->expiry_date?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Issue Authority Address
							</label>
							<div class="col-sm-4">
								<textarea id="issue_authority_address" name="issue_authority_address"  placeholder="Issue uthority Address" autocomplete="off" class="form-control"><?=strip_tags($edit_record->issue_authority_address)?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Upload Permission Doc
							</label>
							<div class="col-sm-3">
								<input type="file" name="permission_doc" id="permission_doc" class="form-control" accept="application/msword,application/pdf">
							</div>
							<div class="col-md-2">
											<?php 
											if(!empty($edit_record->permission_doc))
											{
												echo '<a class="btn btn-primary" href="'.base_url().'add_supplier/download/'.$edit_record->permission_doc.'" target="_blank">Download</a>';
											}	
											?>
											
											</div>
							
						</div>
						
						<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Payment Terms
						</label>
						<div class="col-sm-4">
							<textarea id="supplier_payment_terms" name="supplier_payment_terms" placeholder="Supplier Payment Terms"  class="form-control"   title="Enter Payment Terms"><?=strip_tags($edit_record->payment_terms)?></textarea>
						</div>
						<div id="suggesstion-box"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Division 
							</label>
							<div class="col-sm-4">
								<input type="text"  id="supplier_division" name="supplier_division" placeholder="Supplier Division"  class="form-control"   title="Enter Division" value="<?=strip_tags($edit_record->division)?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Range  
							</label>
							<div class="col-sm-4">
								<input type="text" id="sup_range" name="sup_range" placeholder="Supplier Range"  class="form-control"   title="Enter Range" value="<?=strip_tags($edit_record->sup_range)?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Location code  
							</label>
							<div class="col-sm-4">
								<input type="text" id="sup_location_code" name="sup_location_code" placeholder="Supplier Location code"  class="form-control" title="Enter Location code" value="<?=strip_tags($edit_record->location_code)?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Remarks for po
							</label>
							<div class="col-sm-4">
								<textarea id="remarks_po" name="remarks_po" placeholder="Remarks for po"  class="form-control"   title="Enter Remarks for po"><?=strip_tags($edit_record->remarks_po)?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
									Remarks for production sheet
							</label>
							<div class="col-sm-4">
								<textarea id="remarks_sheet" name="remarks_sheet" placeholder="Remarks for production sheet"  class="form-control"   title="Enter Remarks for production sheet"><?=strip_tags($edit_record->remarks_sheet)?></textarea>
							</div>
						</div>
						
					<div class="col-md-offset-2">
				    <div class="form-group">
						<input name="Submit" type="submit" value="Save" class="btn btn-success" />
							<a href="<?=base_url().'supplier_list'?>" class="btn btn-danger">
											Cancel
										</a>						
					</div>    	
				</div> 	
					<input type="hidden" id="supplier_id" name="supplier_id" value="<?=$edit_record->supplier_id?>"/>				
					<input type="hidden" id="mode" name="mode"    value="<?=$mode?>"  />				
				</form>
					</div>
			<?php 
			if($epcgdata != 1)
			{
				?>
			<div class="container">
					<div class="row">
						<div class="col-sm-12">
							 
							<div class="page-header">
							<h3>Supplier EPCG List</h3>
							</div>
							 
						</div>
					</div>
					 
					 	<div class="row">
						<div class="col-sm-3">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add EPCG
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="epcg_add" id="epcg_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												EPCG LICENCE  No
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="EPCG No" id="epcg_no" class="form-control" name="epcg_no" value="" autocomplete="off" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												EPCG Date
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="EPCG Date" id="epcg_date" class="form-control defualt-date-picker" name="epcg_date" value="" autocomplete="off" required title="Select Date" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												EPCG Amount in INR
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="EPCG Amount in INR" id="epcg_amount" class="form-control" name="epcg_amount" value="" autocomplete="off" required title="Enter Amount in INR" >
											</div>
										</div>
										<div class="form-group col-md-12" >
											<button type="submit" class="btn btn-success">
												Save
											</button>
											<a href="<?=base_url()?>supplier_list" class="btn btn-danger">
												Cancel
											</a>
										</div>
										<input type="hidden" name="supplier_id" id="supplier_id"  value="<?=$edit_record->supplier_id?>"  />
									 </form>
								</div>
							</div>
							 
						</div>
					 
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								EPCG List
									
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>EPCG Detail</th>
													<th>EPCG Date</th>
													<th>EPCG Amount</th>
												 	<th>Action</th>
												</tr>
											</thead>
											<tbody>
											
											<?php 
										$m=1;
										 
											for($i=0; $i<count($epcgdata);$i++)
											{
												 
											?>
												<tr>
													<td><?=$m?></td>
													 <td><?=$epcgdata[$i]->epcg_no?></td> 
													 <td><?=date('d-m-Y',strtotime($epcgdata[$i]->epcg_date))?></td>
													 <td><?=$epcgdata[$i]->epcg_amount?></td>
													 <td>
														<div class="dropdown">
															<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																	  <ul class="dropdown-menu">
																		<li>
																			<a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_product(<?=$epcgdata[$i]->supplie_epcg_id?>);"><i class="fa fa-pencil"></i> Edit</a>
																		</li>
																		<?php 
																		if($epcgdata[$i]->total_cnt==0)
																		{
																		?>
																		<li>
																			<a class="tooltips" data-title="Detele" onclick="delete_record(<?=$epcgdata[$i]->supplie_epcg_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
																	 	</li>
																		<?php 
																		}
																		?> 
																	  </ul>
																	</div>
													 
													</td>
													
												</tr>
										<?php
											$m++;
										}
										 
										?>	
											</tbody>
										</table>
									</div>
								</div>
							</div>
							 
						</div>
					</div>
				
					 </div>
			<?php 
			}
			?>
			</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit EPCG </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				 	<div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Detail
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Detail" id="edit_epcg_detail" class="form-control" name="edit_epcg_detail" value="" >
					 	</div>
					</div>
				      <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		EPCG Date
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="EPCG Date" id="edit_epcg_date" class="form-control defualt-date-picker" name="edit_epcg_date" value="" required title="Select Date">
					 	</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							EPCG Amount in INR
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="EPCG Amount in INR" id="edit_epcg_amount" class="form-control" name="edit_epcg_amount" value="" autocomplete="off" required title="Enter Amount in INR" >
						</div>
					</div>
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="edit_supplier_id" id="edit_supplier_id" value="<?=$edit_record->supplier_id?>" />
			 </form>
        </div>
    </div>
</div>

<script>


$(document).ready(function() {
	 
    $("#supplier_payment_terms").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Add_supplier/search",
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
 });
 
$(document).ready(function() {
	 
    $("#company_name").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Add_supplier/search1",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.supplier_companyname;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 });
 
 $(document).ready(function() {
	 
    $("#supplier_gstno").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Add_supplier/searchgstno",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.supplier_gstno;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 }); 
 
 $(document).ready(function() {
	 
    $("#supplier_panno").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Add_supplier/searchpanno",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.supplier_panno;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 }); 
 
 $(document).ready(function() {
	 
    $("#supplier_iecno").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Add_supplier/searchiecno",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.supplier_iecno;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 });
 
 $(document).ready(function() {
	 
    $("#supplier_address").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: root + "Add_supplier/searchaddress",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.supplier_address;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 });
 
$(document).ready(function () {
			$('#sample-table-1').DataTable({
			   
			});
		});
$(".select2").select2({
		width:'100%'
	})
$("#supplier_form").validate({
		rules: {
			supplier_name: {
				required: true
			},
			supplier_contactno:{
				required:true,
				maxlength:10,
				minlength:10
			}
		},
		messages: {
			supplier_name: {
				required: "Enter Name"
			},
			supplier_contactno:{
				required:"Enter Mobile No",
				maxlength:"Mobile No not vaild",
				minlength:"Mobile No not vaild"
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
				    unblock_page("success","Sucessfully Added.");
					setTimeout(function(){ window.location=root+'supplier_list'; },1500);
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'supplier_list'; },1500);
				}
			   else if(obj.res==3)
			   {
				   $("#company_name").focus();
				     unblock_page("info","Company Already Exist.");
			   }
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'supplier_list'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 

 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 function delete_record(deleleid)
{
	main_delete(deleleid,'supplier_epcg_list/deleterecord','add_supplier/form_edit/<?=$edit_record->supplier_id?>')
}
$("#epcg_add").validate({
		rules: {
			epcg_no: {
				required: true
			}
		},
		messages: {
			epcg_no: {
				required: "Enter EPCG Detail"
			}
		}
	});

$("#edit_form").validate({
	rules: {
		edit_epcg_detail: {
			required: true
		}
	},
	messages: {
		edit_epcg_detail: {
			required: "Enter EPCG Detail"
		}
	}
});
$("#epcg_add").submit(function(event) {
	event.preventDefault();
	if(!$("#epcg_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url : root+'supplier_epcg_list/manage',
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
				   $("#series_add").trigger('reset');
				   unblock_page("success","Sucessfully Inserted.");
				   setTimeout(function(){ window.location=root+'add_supplier/form_edit/<?=$edit_record->supplier_id?>'; },1500);
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","EPCG Already Exits.");
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
					 setTimeout(function(){ window.location=root+'add_supplier/form_edit/<?=$edit_record->supplier_id?>'; },1500);
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

function edit_product(supplie_epcg_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"supplier_epcg_list/fetchdata",
              data: {"id": supplie_epcg_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(supplie_epcg_id);
				 	$("#edit_epcg_detail").val(obj.epcg_no);
				 	$("#edit_epcg_date").val(obj.edit_epcg_date);
				   $("#edit_epcg_amount").val(obj.epcg_amount);
				   
					unblock_page("",""); 
                  }
              
          }); 

}	

</script>

  