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
									Pallet Supplier
								</li>
							</ol>
							<div class="page-header">
							<h3>Pallet Supplier <?=$pallet_data->party_name?> </h3>
						</div>
					</div>
					</div>
				 
					 
					<div class="row">
						<div class="col-sm-3">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									 Pallet Supplier
								</div>
								<div class="panel-body">
									<form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="party_add" id="party_add">
									 	<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Pallet Supplier Name
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Party Name" id="party_name" class="form-control" name="party_name" />
											</div>
										</div>
										 <div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Pallet Supplier Address
											</label>
											<div class="col-sm-12">
												<textarea placeholder="Party Name" id="party_address" class="form-control" name="party_address"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-12 control-label" for="form-field-1">
												Pallet Supplier GST No
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Party GST No" id="party_gst_no" class="form-control" name="party_gst_no" />
											</div>
										</div>
								 	<div class="form-group" style="text-align:center;" >
										<button type="submit" class="btn btn-success">
											Save
										</button>
									</div>	
										 
									</form>
								</div>
							</div>
						 </div>
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								Pallet Supplier
								<a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
									<div id="myModal1" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">How To Manage Pallet Supplier</h4>
												</div>
												<div class="modal-body">
													<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/JcJ8x_kczsI?rel=0&autoplay=0"" frameborder="0" allowfullscreen></iframe>
												</div>
											</div>
										</div>
									</div>
						 		</div>
										
								<div class="panel-body">
								 	<div style="height: 70px;"></div>										
									<div class="table-responsive" >
										<table class="table table-bordered table-hover" id="datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Pallet Supplier</th>
												 	<th>GST No</th>
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
                <h4 class="modal-title">Edit Pallet Supplier </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Pallet Supplier
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Pallet Supplier" id="edit_party_name" class="form-control" name="edit_party_name" value="">
					 	</div>
					</div>
					 <div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Pallet Supplier
						</label>
						<div class="col-sm-12">
							<textarea placeholder="Party Name" id="edit_party_address" class="form-control" name="edit_party_address"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Pallet Supplier GST No
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Party GST No" id="edit_party_gst_no" class="form-control" name="edit_party_gst_no" />
						</div>
					</div>
			   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="palletparty_id" id="palletparty_id" />
				<input type="hidden" name="editpalletmode" id="editpalletmode" />
			 </form>
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
			
			<input type="hidden" name="eid1" id="eid1" />
			
			<input type="hidden" name="palletorderparty" id="palletorderparty" value="1"/>
			
			<input type="hidden" name="eid" id="eid" value="<?=$cust_data->id?>" />
			
			</form>
        </div>
    </div>
</div>
		 
<?php $this->view('lib/footer'); ?>

<script>
function refreshPage(){
    window.location.reload();
} 
$("#assign_user_form").submit(function(event) {
	event.preventDefault();
	if(!$("#assign_user_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'Pallet_order_party/assignmanage',
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
				    $("#assign_user_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					assign_user(obj.customer_id)
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'Pallet_order_party/index'; },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					setTimeout(function(){ window.location=root+'Pallet_order_party/index'; },1500);
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
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
					setTimeout(function(){ window.location=root+'pallet_order_party'; },1500);
				}
				else  if(obj.res==2)
			   {
				     unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ window.location=root+'pallet_order_party'; },1500);
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

$(document).ready(function(){
		/* Get iframe src attribute value i.e. YouTube video url
		and store it in a variable */
    var url = $("#cartoonVideo").attr('src');
    
    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $("#myModal1").on('hide.bs.modal', function(){
        $("#cartoonVideo").attr('src', '');
    });
    
    /* Assign the initially stored url back to the iframe src
    attribute when modal is displayed again */
    $("#myModal1").on('show.bs.modal', function(){
        $("#cartoonVideo").attr('src', url);
    });
});

// function assign_user(customer_id1)
// {
	// block_page();
     // $.ajax({ 
              // type: "POST", 
              // url: root+"Pallet_order_party/fetchuser_data",
              // data: {"customer_id1": customer_id1}, 
              // success: function (response) { 
                   // var obj = JSON.parse(response);
				     // $("#myModaluser").modal({
						// backdrop: 'static',
						// keyboard: false
					// });
					// $(".select2").select2({
						// width: '100%',
						// placeholder:'Select User'
					// });
				  // $("#user_id").html(obj.cust_data);
				  // $("#customer_id1").val(customer_id1);
				  // $(".assign_customer_list").html(obj.assigncust);
				     
					// unblock_page("",""); 
                  // }
              
          // });
// }


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
			"sAjaxSource": root+'pallet_order_party/fetch_record/',
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
	main_delete(deleleid,'pallet_order_party/deleterecord','pallet_order_party')
}
$("#party_add").validate({
		rules: {
			party_name: {
				required: true
			}
		},
		messages: {
			party_name: {
				required: "Enter Party Name"
			}
		}
	});
$("#edit_form").validate({
		rules: {
			edit_party_name: {
				required: true
			}
		},
		messages: {
			edit_party_name: {
				required: "Enter Party Name"
			}
		}
	});

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
	
$("#party_add").submit(function(event) {
	event.preventDefault();
	if(!$("#party_add").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'pallet_order_party/manage';
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
				     $("#model_name").val('');
				    $("#design_file").val('');
					$("#party_add").trigger('reset');
					datatable.DataTable().ajax.reload();
				setTimeout(function(){ window.location=root+'pallet_order_party' },1500);
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
            url: 	root+'pallet_order_party/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_party_name").val() == obj.editpalletmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'pallet_order_party' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#company_document_form").trigger('reset');
					$(".select2").select2('val','');
				    
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

function edit_product(id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"pallet_order_party/fetchpalletorderdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#palletparty_id").val(id);
					 $("#edit_party_name").val(obj.party_name);
					 $("#edit_party_address").val(obj.party_address);
					 $("#edit_party_gst_no").val(obj.party_gst_no);
					 $("#editpalletmode").val(obj.party_name);
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
					$("#eid1").val(id);
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
						$("#eid1").val(id);
					unblock_page("",""); 
                  }
              
          }); 
	}
}
 
 </script>