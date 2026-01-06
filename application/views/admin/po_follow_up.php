<?php  
$this->view('lib/header'); 
?>	
<style>
.wrapper1, .wrapper2{width:100%; border: none 0px RED;
overflow-x: scroll; overflow-y:hidden;}
.wrapper1{height: 20px; }
 
.div1 {width:150%; height: 20px; }
.div2 {width:150%;  
overflow: auto;}

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
			 				<a href="<?=base_url().'po_follow_up'?>">Producation Follow Up</a>
			 			</li>
			 	 	</ol>
			 		<div class="page-header title1">
			 			<h3>
							Producation Follow Up
						</h3>
					</div>
					
			 	</div>
			 </div>
			 <div class="row">
			 	<div class="col-sm-12">
			 		<div class="panel panel-default">
			 			<div class="panel-heading">
			 				<i class="fa fa-external-link-square"></i>
			 				  
			 			</div>
                         <div class="">
			 			   <div class="panel-body form-body">
							<div class="col-md-4">
										<label class="col-md-4 control-label" style="margin-top:5px;"><strong class=""> Producation Date</strong></label>
										 <div class="col-md-8">
										<?php 
										 	$year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
											
											$invoicedate = explode(" - ",$year);
											$start_date = $invoicedate[0];
											$end_date 	= $invoicedate[1];
											if(!empty($_SESSION['order_s_date']))
											{
												$start_date = $_SESSION['order_s_date'];
											}
											if(!empty($_SESSION['order_e_date']))
											{
												$end_date = $_SESSION['order_e_date'];
											}
									 	 ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$start_date?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$end_date?>">
										 </div>     
									</div>
								 
								 
									  <div class="table-responsive view_report" style="margin-top: 100px;">
               
									</div>
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
 
?>
 

<div id="printModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content "  >
            <div class="modal-header">
                <button type="button"   class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Follow OF <span class="follow_up_of"></span> </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="pi_follow_up" id="pi_follow_up"> 
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
					 <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Follow Up Date & Time
					 	</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Follow Up Date & Time" id="followup_today" class="form-control timepicker" name="followup_today" value="<?=date('d-m-Y h:i A');?>" required title="Select Date" autocomplete="off">
							</div>
					</div>
					 <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Select Follow Up Source
					 	</label>
					 	<div class="col-sm-12">
					 		<select class="select2" name="follow_up_type_id" id="follow_up_type_id">
								<option value="">Select Follow Up Source</option>
								<?php 
								foreach($followup_type as $frow)
								{
									echo "<option value='".$frow->follow_up_type_id."'>".$frow->follow_up_type."</option>";
								}
								?>
							</select>
							<label id="follow_up_type_id-error" class="error" for="follow_up_type_id"></label>
					 	</div>
					</div>
					 <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Status
					 	</label>
					 	<div class="col-sm-12">
								<label>
								 <input type="radio" onclick="show_follow_up(this.value)" name="follow_up_status" id="follow_up_status1" value="Follow Up" checked=""> 
										<strong for="follow_up_status1">Follow Up</strong>
								</label>
								 <label>
								 <input type="radio" onclick="show_follow_up(this.value)" name="follow_up_status" id="follow_up_status2" value="Done"> 
										<strong for="follow_up_status2">Done</strong>
								</label>
								<label>
								 <input type="radio" onclick="show_follow_up(this.value)" name="follow_up_status" id="follow_up_status3" value="Cancel"> 
										<strong for="follow_up_status3">Cancel</strong>
								</label>
					 	</div>
					</div>
					<div class="form-group col-md-12"></div>
					<div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Remarks
					 	</label>
					 	<div class="col-sm-12">
					 		<textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" required title="Enter Remarks"></textarea>
					 	</div>
					</div>
				 	
					 <div class="form-group col-md-4 follow_date_html">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Next Follow Up Date & Time
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Next Follow Up Date" id="follow_date" class="form-control timepicker" name="follow_date" value="" required title="Select Date" autocomplete="off">
					 	</div>
					</div>
					   <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Select Follow Up By
					 	</label>
					 	<div class="col-sm-12">
					 		<select class="select2" name="user_id" id="user_id">
								<option value="">Select Follow Up By</option>
								<?php 
								foreach($alluser as $user_row)
								{
									$sel = '';
									if($user_row->user_id == $this->session->id)
									{
										$sel ='selected="selected"';
									}
									echo "<option ".$sel." value='".$user_row->user_id."'>".$user_row->user_name."</option>";
								}
								?>
							</select>
							<label id="follow_up_type_id-error" class="error" for="follow_up_type_id"></label>
					 	</div>
					</div>
				       <div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 1
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_1" id="field_1" value="<?=$invoicedata->field_1?>" class="form-control" placeholder="Field 1"> 
							</div>
						</div>	
						<div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 2
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_2" id="field_2" value="<?=$invoicedata->field_2?>" class="form-control" placeholder="Field 2"> 
							</div>
						</div>
						<div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 3
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_3" id="field_3" value="<?=$invoicedata->field_3?>" class="form-control" placeholder="Field 3"> 
							</div>
						</div>
						<div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 4
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_4" id="field_4" value="<?=$invoicedata->field_4?>" class="form-control" placeholder="Field 4"> 
							</div>
						</div>
					</div>  			
			 
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-success">Save</button>
			    <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="production_mst_id" id="production_mst_id" />
			<input type="hidden" name="followup_from" id="followup_from" value="2" />
			 </form> 	 
			 
    </div>
</div>
</div>


 
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content"  >
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Follow OF <span class="follow_up_view"></span> </h4>
            </div>
			 
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
					<div class="table-responsive">
                <table class="table table-bordered table-hover display" id="datatable1" width="100%">
                  <thead>
                    <tr>
                      <th>Sr no</th>
                      <th>Producation no</th>
					  <th>Follow Up Date</th>
					  <th>Follow Up Source</th>
					  <th>Follow Up Status</th>
					  <th>Next Follow Up Date</th>
                      <th>Remarks</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   </tbody>
				    
                </table>
              </div>
			 </div>  			
			 
            <div class="modal-footer">
				 
			    <button type="button"  onclick="close_modal()"    class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 
			 
    </div>
</div>
</div>
 
<div id="production_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content "  >
            <div class="modal-header">
                <button type="button"   class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Prodcation <span class="follow_up_of"></span> </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="pi_follow_up" id="pi_follow_up"> 
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
					 <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		  Factory Name
					 	</label>
							<div class="col-sm-12">
								<input type="text" placeholder="Factory Name" id="factory_name" class="form-control" name="factory_name" value="" readonly>
							</div>
					</div>
					 <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Production Start Date
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Production Start Date" id="producation_start_date" class="form-control" name="producation_start_date" value="">
					 	</div>
					</div>
					 <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Production Status
					 	</label>
					 	<div class="col-sm-12">
								<label>
								 <input type="radio"  name="producation_status" id="producation_status1" value="Killan" checked=""> 
										<strong for="producation_status1">Killan</strong>
								</label>
								 <label>
								 <input type="radio"   name="producation_status" id="producation_status2" value="Sizing"> 
										<strong for="producation_status2">Sizing</strong>
								</label>
								<label>
								 <input type="radio"  name="producation_status" id="producation_status3" value="Box Packing"> 
										<strong for="producation_status3">Box Packing</strong>
								</label>
								<label>
								 <input type="radio"  name="producation_status4" id="producation_status4" value="Completed"> 
										<strong for="producation_status4">Completed</strong>
								</label>
					 	</div>
					</div>
					<div class="form-group col-md-12"></div>
					<div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Remarks
					 	</label>
					 	<div class="col-sm-12">
					 		<textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" required title="Enter Remarks"></textarea>
					 	</div>
					</div>
				 	
					 <div class="form-group col-md-4 follow_date_html">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Next Follow Up Date & Time
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Next Follow Up Date" id="follow_date" class="form-control timepicker" name="follow_date" value="" required title="Select Date" autocomplete="off">
					 	</div>
					</div>
					   <div class="form-group col-md-4">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Select Follow Up By
					 	</label>
					 	<div class="col-sm-12">
					 		<select class="select2" name="user_id" id="user_id">
								<option value="">Select Follow Up By</option>
								<?php 
								foreach($alluser as $user_row)
								{
									$sel = '';
									if($user_row->user_id == $this->session->id)
									{
										$sel ='selected="selected"';
									}
									echo "<option ".$sel." value='".$user_row->user_id."'>".$user_row->user_name."</option>";
								}
								?>
							</select>
							<label id="follow_up_type_id-error" class="error" for="follow_up_type_id"></label>
					 	</div>
					</div>
				       <div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 1
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_1" id="field_1" value="<?=$invoicedata->field_1?>" class="form-control" placeholder="Field 1"> 
							</div>
						</div>	
						<div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 2
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_2" id="field_2" value="<?=$invoicedata->field_2?>" class="form-control" placeholder="Field 2"> 
							</div>
						</div>
						<div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 3
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_3" id="field_3" value="<?=$invoicedata->field_3?>" class="form-control" placeholder="Field 3"> 
							</div>
						</div>
						<div class="form-group col-md-4">
							<label class="col-sm-12 control-label" for="form-field-1">
								Field 4
							</label>
							<div class="col-sm-12">
							   <input type="text" name="field_4" id="field_4" value="<?=$invoicedata->field_4?>" class="form-control" placeholder="Field 4"> 
							</div>
						</div>
					</div>  			
			 
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-success">Save</button>
			    <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="productionmst_id" id="productionmst_id" />
		 
			 </form> 	 
			 
    </div>
</div>
</div>
 
<script>
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
function close_modal()
{
	location.reload();
}
function  show_follow_up(val)
{
	if(val == "Follow Up")
	{
		$(".follow_date_html").show()
	}
	else
	{
		$(".follow_date_html").hide()
	}
}
function delete_record(id,status)
{
	Swal.fire({
  title: 'You want to delete?',
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
              url: root+'Pi_follow_up/delete_followup',
              data: {
                "id"	 : id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Follow Up Successfully Deleted");
					 $("#datatable1").DataTable().ajax.reload();
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
}
function view_fllow_up(performa_invoice_id,invoice_no)
{
	$(".follow_up_view").html(invoice_no)
	 
	$("#viewModal").modal({
		backdrop: 'static',
		keyboard: false
	});
	datatable = $("#datatable1").dataTable({
			"bAutoWidth" : false,
			"bFilter" : true,
			"bSort" : true,
			"aaSorting": [[0]],         
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": false }
            ],   
			"bProcessing": true,
			"searchDelay": 350,
			"bServerSide" : true,
			"bDestroy": true,
			<!--"dom": '<"wrapper"flipt>',
			-->
			"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "No Records found in Database - Please add new record using entry form !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root+'po_follow_up/fetch_followup_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "performa_invoice_id" , "value" : performa_invoice_id});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}   
			  
		});

		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');	 
}
$("#pi_follow_up").validate({
		rules: {
			follow_up_type_id: {
				required: true
			}
		},
		messages: {
			follow_up_type_id: {
				required: "Select Follow Up Type"
			}
		}
	});
$("#pi_follow_up").submit(function(event) {
	event.preventDefault();
	if(!$("#pi_follow_up").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'po_follow_up/manage';
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
					setTimeout(function(){ location.reload(); },1000);
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

 $('.timepicker').datetimepicker({
       format: "dd-mm-yyyy HH:ii P",
        showMeridian: true,
        autoclose: true,
        todayBtn: true
    });
closeNav();

function add_producation_detail(production_mst_id,producation_no)
{
	$(".follow_up_of").html(producation_no)
	$("#production_mst_id").val(production_mst_id)
	 
	$("#production_modal").modal({
		backdrop: 'static',
		keyboard: false
	});
		 
}
function add_fllow_up(production_mst_id,producation_no,follow_date)
{
	$(".follow_up_of").html(producation_no)
	$("#production_mst_id").val(production_mst_id)
	if(follow_date != "")
	{
		$("#followup_today").val(follow_date)
	}
	$("#printModal").modal({
		backdrop: 'static',
		keyboard: false
	});
		 
}
 
$(".select2").select2({
	width:"100%"
});
load_data_table()
function load_data_table()
{ 	
	block_page(); 	
	$(".view_report").html('')	
	$.ajax({          
		type: "POST",          
		url: root+'po_follow_up/view_report',         
		data: {          
		 	"daterange" 	: $("#daterange").val() 
		}, 		
		cache: false, 		
		success: function (data) { 			
			$(".view_report").html(data);
			$('.tooltips').tooltip();			
			unblock_page("","")		
		}	
	});
}

function cb(start, end) {
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    cb(moment().subtract(29, 'days'), moment());
	 
$('#daterange').daterangepicker({       
 			locale: {
				format: 'DD-MM-YYYY'
			},
		"autoApply": true,	
		"startDate": $('#s_date').val(),
		"endDate": $('#e_date').val(),	
	    ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		   'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb); 
 
 </script>
 