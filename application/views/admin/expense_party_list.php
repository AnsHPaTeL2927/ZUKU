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
									Expense Party List 
								</li>
							</ol>
							<div class="page-header">
							<h3>Expense Party</h3>
						</div>
					</div>
					</div>
				 	<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Add Expense Party
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="expense_party_add" id="expense_party_add">
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Expense Category
											</label>
											<div class="col-sm-12">
												 <select class="select2" name="expense_category_id[]" id="expense_category_id" multiple required title="Select Expense Category" data-placeholder="Select Expense Category" >
													 <?php 
														for($i=0; $i<count($expense_category);$i++)
														{ 
														?>
															<option   value="<?=$expense_category[$i]->expense_category_id?>"><?=$expense_category[$i]->expense_category_name?></option>
														<?php
														}
														?>	 
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Expense Party Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Expense Party Name" id="expense_party_name" class="form-control" name="expense_party_name" required title="Select Party Name" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Party Address
											</label>
											<div class="col-sm-12">
												<textarea placeholder="Party Address" id="expense_party_address" class="form-control" name="expense_party_address"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Party GST NO
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Party GST NO" id="party_gst_no" class="form-control" name="party_gst_no"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Credit Days
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Credit Days" id="credit_days" class="form-control" name="credit_days"/>
											</div>
										</div>
										<div class="form-group" style="" >
											<div class="col-sm-12">
												<button type="submit" class="btn btn-success">
													Submit
												</button>
											</div>	
										</div>	
										 
									</form>
								</div>
							</div>
						 </div>
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Expense Party List
						 		</div>
										
								<div class="panel-body">
								 	 <div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Expense Party Name</th>
												 	<th>Expense Category Name</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
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
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Expense Party</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_expense" id="edit_expense">
				<div class="modal-body">
						<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Select Expense Category
											</label>
											<div class="col-sm-12">
												 <select class="select2" name="edit_expense_category_id[]" id="edit_expense_category_id" required title="Select Expense Category" data-placeholder="Select Expense Category" multiple >
												 	<?php 
														for($i=0; $i<count($expense_category);$i++)
														{ 
														?>
															<option   value="<?=$expense_category[$i]->expense_category_id?>"><?=$expense_category[$i]->expense_category_name?></option>
														<?php
														}
														?>	 
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Expense Party Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Expense Party Name" id="edit_expense_party_name" class="form-control" name="edit_expense_party_name"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Party Address
											</label>
											<div class="col-sm-12">
												<textarea placeholder="Party Address" id="edit_expense_party_address" class="form-control" name="edit_expense_party_address"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Party GST NO
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Party GST NO" id="edit_party_gst_no" class="form-control" name="edit_party_gst_no"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Credit Days
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Credit Days" id="edit_credit_days" class="form-control" name="edit_credit_days"/>
											</div>
										</div>
										
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
			 </form>
        </div>
    </div>
</div>

<div id="myModal1" class="modal fade" role="dialog">
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
				   <input type="hidden" name="sent_msg" id="sent_msg" value="0"/>            
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
<script>
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
					setTimeout(function(){ window.location=root+'expense_party_list'; },1500);
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'expense_party_list'; },1500);
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
	load_data_table();
});
 
function load_data_table()
{
	datatable = $("#datatable").dataTable({
				"bAutoWidth" : false,
				"bFilter" : true,
				"bSort" : true,
				"bProcessing": true,
				"searchDelay": 350,
				"bServerSide" : true,
				"bDestroy": true,
				"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "NO DATA ADDED YET !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'expense_party_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" });
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}

$(".select2").select2({
	width:'100%'
});
function delete_record(deleleid)
{
	main_delete(deleleid,'expense_party_list/deleterecord','expense_party_list')
}
$("#expense_party_add").validate({
		rules: {
			expense_category_id: {
				required: true
			}
		},
		messages: {
			expense_category_id: {
				required: "Select Expense Category"
			}
		}
	});
$("#edit_expense").validate({
		rules: {
			edit_expense_name: {
				required: true
			}
		},
		messages: {
			edit_expense_name: {
				required: "Enter Expense Category Name"
			}
		}
	});

$("#expense_party_add").submit(function(event) {
	event.preventDefault();
	if(!$("#expense_party_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'expense_party_list/manage';
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
					$("#expense_party_add").trigger('reset');
					$("#expense_category_id").val("").trigger('change');
					datatable.DataTable().ajax.reload();
				//	setTimeout(function(){ window.location=root+'model_list' },1500);
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

$("#edit_expense").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_expense").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'expense_party_list/manage',
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
				   $("#edit_expense").trigger('reset');
				   $("#edit_expense_category_id").val("").trigger('change');
				    unblock_page("success","Sucessfully Updated.");
					datatable.DataTable().ajax.reload();
					// setTimeout(function(){ window.location=root+'payment_mode' },1500);
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

function editexpense_category(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"expense_party_list/fetchdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(id);
					 var category_id = obj.expense_category_id.split(',')
					 $("#edit_expense_category_id").val(category_id).trigger('change');
					 $("#edit_expense_party_name").val(obj.party_name);
					 $("#edit_expense_party_address").val(obj.party_address);
					 $("#edit_party_gst_no").val(obj.party_gst_no);
					 $("#edit_credit_days").val(obj.credit_days);
			 	 	unblock_page("",""); 
                  }
              
          }); 

}	
 </script>