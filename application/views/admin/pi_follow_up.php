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
			 				<a href="<?=base_url().'pi_follow_up'?>">PI Follow Up</a>
			 			</li>
			 	 	</ol>
			 		<div class="page-header title1">
			 			<h3>
							PI Follow Up
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
										<label class="col-md-4 control-label" style="margin-top:5px;"><strong class=""> Performa Date</strong></label>
										 <div class="col-md-8">
										<?php 
										 
										 
											$year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
											
											$invoicedate = explode(" - ",$year);
											$start_date = $invoicedate[0];
											$end_date 	= $invoicedate[1];
											if(!empty($_SESSION['pi_follow_up_s_date']))
											{
												$start_date = $_SESSION['pi_follow_up_s_date'];
											}
											if(!empty($_SESSION['pi_follow_up_e_date']))
											{
												$end_date = $_SESSION['pi_follow_up_e_date'];
											}
									 	 ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$start_date?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$end_date?>">
										 </div>     
									</div>
								<div class="col-md-4" style="margin-bottom: 5px;">
									<label class="col-md-4 control-label" style="margin-top: 5px;">
										<strong class=""> Select Customer</strong>
									</label>
						 		 <div class="col-md-8">
										 <select class="select2" id="customer_id" name="customer_id" onchange="load_data_table()" >
											<option value="">All Customer</option>
												<?php
												for($p=0;$p<count($allconsign);$p++)
												{
													 $sel ='';
													 if($allconsign[$p]->id == $_SESSION['pi_follow_up_cust_id'])
													 {
														 $sel ='selected="selected"';
													 }
											 	?>
													<option <?=$sel?> value="<?=$allconsign[$p]->id?>"><?=$allconsign[$p]->c_companyname?></option>
												<?php
												}
												?>
										</select>
						 		 </div>     
								</div>
								<div class="col-md-4" style="margin-bottom: 5px;">
									<label class="col-md-4 control-label" style="margin-top: 5px;">
										<strong class=""> Select PI Status</strong>
									</label>
						 		 <div class="col-md-8">
										 <select class="select2" id="status_id" name="status_id" onchange="load_data_table()" >
											<option value="1">Pending</option>
											<option value="2">Confirm</option>
											 
										</select>
						 		 </div>     
								</div>
									  <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="datatable" width="100%">
                  <thead>
                    <tr>
						<th>Sr no</th>
						<th>Proforma Invoice no</th>
						<th>Date</th>
						<th>Consignee Name</th>
						<th>No of container</th>
                       <th>Total Box</th>
                       <th>Remarks</th>
                       <th>Follow Up Date</th>
                       <th>Follow Up By</th>
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
</div>
 
<?php 
$this->view('lib/footer');
 
?>
	
 <div id="recordmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  >
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Record Audio</h4>
            </div>
			 <div class="recordrtc">
            <div class="modal-body">
				
				 <select class="recording-media">
                     <option value="record-audio">Audio</option>
                    
                </select>

				<select class="media-container-format">
                    <option>WAV</option>
                 </select>
					 <div style="text-align: center; display: none;">
						<button id="save-to-disk">Save To Disk</button>
						<button id="open-new-tab">Open New Tab</button>
						<button id="upload-to-server">Upload To Server</button>
					</div>

				<br>
			 <div style="text-align: center;"> <audio controls playsinline autoplay muted=true volume=1></audio> 	  </div>
				</div>
			
            <div class="modal-footer">
			     <button type="button" onclick="record_audio(this)" class="btn btn-danger">Stop Recording</button>
			     <button type="button" onclick="close_modal()"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			  </div>
			 
    </div>
</div>
</div>

  
  <script>
   
$( function() {
    $( "#accordion" ).accordion({
		active: 1,
		collapsible: true,
		heightStyle: "content"
	});
  } );
function close_modal()
{
	location.reload();
}
function  show_follow_up(val)
{
	
	if(val == "Follow Up")
	{
		$(".date_html").html('Next Follow Up Date & Time')
		$("#follow_date").attr('placeholder','Next Follow Up Date & Time')
		//$(".follow_date_html").show()
	}
	else if(val == "Confirm")
	{
		$(".date_html").html('Confirm Date & Time')
		$("#follow_date").attr('placeholder','Confirm Date & Time')
		//$(".follow_date_html").hide()
	}
	else if(val == "Cancel")
	{
		$(".date_html").html('Cancel Date & Time')
		$("#follow_date").attr('placeholder','Cancel Date & Time')
		//$(".follow_date_html").hide()
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
			"sAjaxSource": root+'Pi_follow_up/fetch_followup_record/',
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
	 
	 var url = root+'pi_follow_up/manage';
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

function add_fllow_up(performa_invoice_id,invoice_no,follow_date)
{
	
	block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'pi_follow_up/order_summery',
              data: {
                "performa_invoice_id"	 : performa_invoice_id,
				"status" : status
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				
				$(".order_summery").html(obj.html);
				$(".follow_up_of").html(invoice_no);
				$("#performa_invoice_id").val(performa_invoice_id);
				if(follow_date != "")
				{
					$("#followup_today").val(follow_date)
				}
				$("#printModal").modal({
					backdrop: 'static',
					keyboard: false
				});
				unblock_page("","");
              }
			});	 
}
 
$(".select2").select2({
	width:"100%"
});
load_data_table()
function load_data_table()
{ 	

	datatable = $("#datatable").dataTable({
			"bAutoWidth" : false,
			"bFilter" : true,
			"bSort" : true,
			"aaSorting": [[0]],
			"bDestroy": true,			
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
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
			"sAjaxSource": root+'Pi_follow_up/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "status_id" , "value" :  $("#status_id").val()},{ "name" : "date" , "value" :  $("#daterange"). val()} ,{ "name" : "cust_id" , "value" :  $("#customer_id"). val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}   
			  
		});

		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
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
 