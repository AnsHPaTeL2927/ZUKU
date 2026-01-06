<?php 
$this->view('lib/header'); 
 
?>	
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Company Document</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
   <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script> 
   <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.4.min.js"></script>
   
</head>


<script>
function onlyNumberKey(evt) 
    {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }


</script>

<body>

<div class="main-container">
<?php 
$this->view('lib/sidebar');
 ?>	
		 
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
									  &nbsp;Payment Terms
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Payment Terms</h3>
						</div>
				</div>
			</div>
					<div class="">
						<div class="col-sm-4">
							 
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Payment Terms
								</div>
								
									<div class="panel-body">
										
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="payment_terms_form" name="payment_terms_form">
										
										<div class="form-group">
												<label class="control-label col-sm-12 " for="form-field-1">
												Payment Terms:
												</label>
												<div class="col-sm-12">
													<textarea type="text" placeholder="Payment Terms" id="payment_terms" class="form-control" name="payment_terms" value="" autocomplete="off" autofocus="autofocus" ></textarea>
												</div>
										</div>
										
										<div class="form-group">
												<label class="control-label col-sm-12" for="form-field-1">
													Is Active:
												</label>
												<div class="col-sm-12">													
													<label class="radio-inline">
														<input type="radio" name="isactive" id="yes" value="yes" checked>Yes
													</label>
													<label class="radio-inline">
														<input type="radio" name="isactive" id="no" value="no">No			
													</label>
													<!--To Show Error  -->	
													<label id="isactive-error" class="error" for="isactive"></label>	
													<!--To Show Error  -->
												</div>
										</div>
											
										<div class="form-group">
											<label class="control-label col-sm-12" for="form-field-1">
												Order No:
											</label>
											<div class="col-sm-12">
												<input type="text" placeholder="Order No" id="ornumber" class="form-control" name="ornumber" 
												value="<?php echo $no->order_no+1 ?>" autocomplete="off" onkeypress="return onlyNumberKey(event)"
												
												/>
											</div>
										</div>
																				
										<div class="form-group" style="margin-left:90px;" >
											<button type="submit" class="btn btn-success" name="save" value="Save Data">
												Save
											</button>
										</div>	
											 
								</form>
							</div>
					</div>
				</div>	
						<div class="col-md-8">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Port Master
					 		  </div>
							  <div class="panel-body">
								<div class="col-md-6">
									<label class="col-md-5 form-group" style="">
										<strong class=""> Select Status</strong>
									</label>
									<div class="col-md-6">
									<select class="select2" name="status" id="status"   title="Select Consignee"  onchange="load_data_table();" >
										<option value="">All</option>
										<option value="1">Archive</option>
										<option value="2">Unarchive</option>
										</select>
									  </div>     
								</div>
								 	 <div class="table-responsive" >
									
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<th>No</th>  
												<th>Payment Terms</th>  										
												<th>Status</th>  
												<th>Order No</th>  
												
												<th>Action</th>  
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
		
<div id="myModal" name="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  onclick="reload()" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Payment Terms </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
				<div class="modal-body">
				
					
					<div class="form-group">
							<label class="control-label col-sm-12 " for="form-field-1">
							Payment Terms:
							</label>
							<div class="col-sm-12">
								<textarea type="text" placeholder="Payment Terms" id="edit_payment_terms" class="form-control" name="edit_payment_terms" value="" autocomplete="off" ></textarea>
							</div>
					</div>
					
					<div class="form-group">
							<label class="control-label col-sm-12" for="form-field-1">
								Is Active:
							</label>
							<div class="col-sm-12">													
								<label class="radio-inline">
									<input type="radio" name="edit_isactive" id="edit_yes" value="yes">Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="edit_isactive" id="edit_no" value="no">No			
								</label>
								<!--To Show Error  -->	
								<label id="isactive-error" class="error" for="isactive"></label>	
								<!--To Show Error  -->
							</div>
					</div>
						
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Order No:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Order No" id="edit_ornumber" class="form-control" name="edit_ornumber" 
							value="<?php echo $no->order_no+1 ?>" autocomplete="off" onkeypress="return onlyNumberKey(event)"
							
							/>
						</div>
					</div>				
				
				
				
			  </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="editdocumentmode" id="editdocumentmode" />
			 </form>
        </div>
    </div>
</div>
</div>

<?php $this->view('lib/footer'); ?>
<script>
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
 $(document).ready(function () {
	load_data_table();
});
 load_data_table();
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
					// "sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
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
			"sAjaxSource": root+'Payment_terms/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name": "status", "value": $("#status").val() });
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
 
			
$("#payment_terms_form").validate({
	 rules: {
		payment_terms: {
			required: true
		},	
		isactive:{
			required: true
		},
		ornumber:{
			required: true
		}
	 },
	 messages: {
		payment_terms: {
			required: "Payment Terms Required"
		},		
		isactive:{
			required: "Active Status is Required"
		},
		ornumber:{
			required: "Order Number is Required"
		}
	 }
});

$("#edit_form").validate({
		rules: {
			edit_payment_terms: {
				required: true
			},
			edit_isactive:{
				required: true
			},
			edit_ornumber:{
				required: true
			}
		},
		messages: {
			edit_payment_terms: {
				required: "Payment Terms Required"
			},
			edit_isactive:{
				required: "Active Status is Required"
			},
			edit_ornumber:{
				required: "Order Number is Required"
			}
		}
});
	
	
$("#payment_terms_form").submit(function(event) {
	event.preventDefault();
	if(!$("#payment_terms_form").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'Payment_terms/manage';
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
				   unblock_page("success","Sucessfully saved.");
				   $("#payment_terms_form").trigger('reset');
				   datatable.DataTable().ajax.reload();
				   setTimeout(function(){ window.location=root+'Payment_terms' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#payment_terms_form").trigger('reset');
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

// for update
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
        url: 	root+'Payment_terms/manage',
        data: postData,
		processData: false,
		contentType: false,
		cache: false,
           success: function(responseData) {
              console.log(responseData);
		    var obj= JSON.parse(responseData);
			$(".loader").hide();
			if(obj.res==1 || $("#edit_payment_terms").val() == obj.editdocumentmode)
		   {
			    $("#myModal").modal('hide');
			   $("#edit_form").trigger('reset');
			   //$(".select2").select2('val','');
			    unblock_page("success","Sucessfully Updated.");
				 setTimeout(function(){ window.location=root+'Payment_terms' },1500);
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

// edit form hover
function edit_product(id)
{
	block_page();
	
     $.ajax({ 
              type: "POST", 
              url: root+"Payment_terms/fetchdocumentdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
					 
					 $("#edit_payment_terms").val(obj.payment_terms);
					 
					 $("#edit_ornumber").val(obj.order_no);
					 
					 // For Is_Active Radio Button fetch
					 if(obj.is_active == 'Yes')
					 {
						 $("#edit_yes").prop("checked",true)
					 }
					 else if(obj.is_active == 'No')
					 {
						 $("#edit_no").prop("checked",true)
					 }
					
					 
					 $("#editdocumentmode").val(obj.payment_terms);
				 	unblock_page("",""); 
                  }
              
          }); 
}

function archive_record(id,status)
{
	Swal.fire({
  title: 'Are You Sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'Payment_terms/archive_record',
              data: {
                "id"	 : id,
				"status" : status
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					if(status == 0)
					{
						unblock_page('success',"Document successfully unarchived");
					}
					else
					{
						unblock_page('success',"Document successfully archived");
					}
					setTimeout(function(){ window.location=root+'Payment_terms'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
	 
}	

function delete_record(deleleid)
{
	main_delete(deleleid,'Payment_terms/deleterecord','Payment_terms')
}

</script>
