<?php  
$this->view('lib/header'); 
 ?>	
<style>
.canvasjs-chart-credit
{
	display:none;
}

</style>
<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/AdminLTE.min.css">
<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/fullcalendar.min.css">
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
								 
							</ol>
							<div class="page-header">
								<h3>Welcome Admin
									<div class="pull-right " style="font-size:15px">
										Select Finacial Year
										<select class="select2" name="f_year" id="f_year" onchange="load_data();">
											<?php 
												 $start = 2019;
												 $end 	= date('Y');
												  for($y=$start;$y<=$end;$y++)
												 {
													 $finacial_year = $y.' - '.($y+1);
													 $year = date('n') > 3 ? date('Y').' - '.(date('Y',strtotime("+1 year"))) : (date('Y',strtotime("-1 year"))).' - '.date('Y');
													$sel = '';
													if($finacial_year == $year)
													{
														$sel = 'selected="selected"';
													}														
													 
													 echo "<option ".$sel." value='".$finacial_year."'>".$finacial_year."</option>";
												 }
											?>
										</select>
									</div>
								</h3>
							</div>
							 
						</div>
					</div>
					<section class="content">
      
      <div class="row">
		<div class="col-lg-9 col-xs-6">
				<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="confirm_pi_html"></h3>
				<p>Confirm Con./Order</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-circle"></i>
            </div>
            <a href="<?=base_url().'view_confirm_order'?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
		
		<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua" style="background:#43b236 !important">
            <div class="inner">
              <h3 id="pending_producation_sheet_html">  </h3>
				<p>P. Sheet Pending Con.</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-excel-o"></i>
            </div>
            <a href="<?=base_url().'view_producation_sheet_pending'?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         
				<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="under_producation_html"> </h3>

              <p>Under Producation Con.</p>
            </div>
            <div class="icon">
              <i class="fa fa-spinner"></i>
            </div>
            <a href="<?=base_url().'view_under_producation'?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
				<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="produced_html"> </h3>

              <p>Produced Done Con.</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-square-o"></i>
            </div>
            <a href="<?=base_url().'view_produced'?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
				<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="ready_to_load_html"> </h3>

              <p>Ready to Load Con.</p>
            </div>
            <div class="icon">
              <i class="fa fa-battery-full"></i>
            </div>
            <a href="<?=base_url().'read_to_load'?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
				<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary" style="background:#6851c0 !important">
            <div class="inner">
              <h3 id="pendingdoc_con_html"></h3>

              <p>Doc. Pending Con.</p>
            </div>
            <div class="icon">
              <i class="fa fa-file"></i>
            </div>
            <a href="<?=base_url().'doc_pending'?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
				<div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3 id="export_con_html"></h3>
				<p>Order Loaded Con./Order</p>
            </div>
            <div class="icon">
              <i class="fa fa-thumbs-up"></i>
            </div>
            <a href="<?=base_url().'view_order_loaded'?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
       </div>
		</div>
		 
		 <?php 
	  if($this->session->usertype_id == 1)
	  {
	  ?>
	   
		<div class="col-lg-3 col-xs-6">
		
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 style="font-size:17px" id="total_amount_html"></h3>

              <p>Total Amount</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="<?=base_url()?>customer_report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
     
      <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size:17px" id="paid_amount_html"></h3>

              <p>Total Amount  Received</p>
            </div>
            <div class="icon">
              <i class="fa fa-briefcase"></i>
            </div>
            <a href="<?=base_url()?>customer_report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      
		<div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size:17px" id="due_amount_html"></h3>

              <p>Total Amount Due</p>
            </div>
            <div class="icon">
              <i class="fa fa-bell"></i>
            </div>
            <a href="<?=base_url()?>customer_report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
		</div>
     
		<?php
	  }
	  ?>
		 </div>	
    </section>
	 <div class="col-md-12"></div>
								<div class="col-md-8">
										<div id="chartContainer" style="height: 400px; width: 90%;"></div>
								</div>
								 <?php 
	  if($this->session->usertype_id == 1)
	  {
	  ?>
								<div class="col-md-4">
										<div id="chartContainer1" style="height: 400px; width: 90%;"></div>
								</div>
								<?php
	  }
	  ?>
	   <div class="col-md-12" style="height:50px;"></div>
	   
		<span class="pull-right" style="">
			<input type="button"  name="addcustomer" id="addcustomer" data-toggle="modal" data-target="#bs-example-remainder"  class="btn btn-danger" value="+ Add"/>
		</span>
		<div class="col-md-12" id='calendar'></div>
		
				</div>
			</div>
			 
		</div>
		 
<?php $this->view('lib/footer'); ?>
<div class="modal colored-header info" id="bs-example-remainder" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content" style="overflow-y:scroll;" >
			<div class="modal-header">
			<button type="button"  class="btn_close  close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3><span id="headmodal">Add</span> Reminder</h3>
			</div>
			<div class="modal-body form">
					<div class="row">

						<form class="form-horizontal" role="form" id="remainder_add" action="javascript:;" method="post" name="remainder_add">
						 <div class="col-md-12">
				
						<div class="form-group">  	
								<label class="col-md-4 control-label">Start Date </label>
							  <div class="col-md-6 col-xs-11">
									 <div data-date="<?=date('d-m-Y')?>" class="input-group date form_datetime-meridian defualt-date-picker1">
                                              <input type="text" class="form-control" required title="Enter Start Date"
											  value="<?=date('d-m-Y')?>" size="16" name="start_date" id="start_date">
                                              <div class="input-group-btn">
                                                  <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                              </div>
                                          </div>
										 
								</div>			
						</div>
						<div class="form-group">  	
								<label class="col-md-4 control-label">End Date </label>
							  <div class="col-md-6 col-xs-11">
									<div data-date="<?=date('d-m-Y')?>" class="input-group date form_datetime-meridian defualt-date-picker1">
                                              <input type="text" class="form-control"  required title="Enter End Date" value="<?=date('d-m-Y')?>" size="16" name="end_date" id="end_date">
                                              <div class="input-group-btn">
                                                  <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                              </div>
                                          </div>
								</div>			
						</div>
						
						<div class="form-group" id="duration">  	
						 <label class="col-md-4 control-label">Remainder Text</label>
							  <div class="col-md-6 col-xs-11">
								<textarea class="form-control" name="remainder_text" id="remainder_text"></textarea>
								</div>			
				        </div>
				</div>
						<div class="col-md-4"></div>
							<button type="submit" class="btn btn-success">Save</button> &nbsp;
							<button type="button"  class="btn_close btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
							
						  </form>
					</div>
				</div>
			</div>	
			</div>
		</div><!-- /.modal-content -->
	
<div class="modal colored-header info" id="showevent" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content" style="overflow-y:scroll;" >
			<div class="modal-header">
			 
			<button type="button"  class="btn_close  close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3><span id="headmodal">Show</span> Calendar Data</h3>
			</div>
			<div class="modal-body form">
					<div class="row">
 
						 <div class="col-md-12">
				
							<div class="form-group col-md-12">  	
								<label class="col-md-4 control-label">Start Date </label>
								<div class="col-md-6 col-xs-11">
									 <div  id="event_start_date">
                                             
                                              </div>
											  
                                          </div>
										 
								</div>	
								<div class="form-group col-md-12">  	
								<label class="col-md-4 control-label">End  Date </label>
							  <div class="col-md-6 col-xs-11">
									 <div  id="event_end_date">
                                             
                                              </div>
											  
                                          </div>
										 
								</div>	
								<div class="form-group col-md-12">  	
								<label class="col-md-4 control-label">Event Text</label>
							  <div class="col-md-6 col-xs-11">
									 <div  id="event_text">
                                             
                                              </div>
											  
                                          </div>
										 
								</div>	
  							
						</div>
			 	</div>
						<div class="col-md-4"></div>
							<button type="button" onclick="delete_event()" class="btn btn-success">Delete</button> &nbsp;
							<button type="button"  class="btn_close btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
							 <input type="hidden"    value="" name="editid" id="editid">
						  
					</div>
				</div>
			</div>	
			</div>
		 <!-- /.modal-content -->
	
<script src="<?=base_url()?>adminast/assets/js/canvas.min.js"></script>
<script src="<?=base_url()?>adminast/assets/js/fullcalendar.min.js"></script>
<script>
load_data();
function load_data()
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"dashboard/fetch_dashboard",
              data: {
					"f_year": $("#f_year").val()
			  }, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				   
					var confirm_pi 							= (obj.confirm_pi > 0) ? obj.confirm_pi : 0;
					var confirm_pi_order 					= (obj.confirm_pi_order > 0) ? obj.confirm_pi_order : 0;
					var export_con 							= (obj.export_con >0) ? obj.export_con : 0;
					var export_con_order 					= (obj.export_con_order >0) ? obj.export_con_order : 0;
					var pendingdoc_con 						= (obj.pendingdoc_con > 0) ? obj.pendingdoc_con : 0
				 	var ready_to_load 						= (obj.ready_to_load > 0 ) ? obj.ready_to_load : 0
				 	var produced 							= (obj.produced > 0 ) ? obj.produced : 0
					var under_producation					= (obj.under_producation > 0 ) ? obj.under_producation : 0
					var pending_producation_sheet 			= (obj.pending_producation_sheet > 0 ) ? obj.pending_producation_sheet : 0
				 	
					
					// $("#confirm_pi_html").html(confirm_pi+' / '+confirm_pi_order);
				  
					// $("#export_con_html").html(export_con+' / '+export_con_order);
				    // $("#pendingdoc_con_html").html(pendingdoc_con);
				    // $("#ready_to_load_html").html(ready_to_load);
				    // $("#produced_html").html(produced);
				    // $("#under_producation_html").html(under_producation);
				    // $("#pending_producation_sheet_html").html(pending_producation_sheet);
					
					$("#confirm_pi_html").html(confirm_pi+' / '+confirm_pi_order);
				  
					$("#export_con_html").html(export_con+' / '+export_con_order);
				    $("#pendingdoc_con_html").html(pendingdoc_con);
				    //$("#ready_to_load_html").html(ready_to_load);
				    $("#produced_html").html(produced);
				    //$("#under_producation_html").html(under_producation);
				   // $("#pending_producation_sheet_html").html(pending_producation_sheet).toFixed(2);
					$("#ready_to_load_html").html((obj.ready_to_load > 0) ? parseFloat(obj.ready_to_load).toFixed(2) : 0);
					$("#under_producation_html").html((obj.under_producation > 0) ? parseFloat(obj.under_producation).toFixed(2) : 0);
					$("#pending_producation_sheet_html").html((obj.pending_producation_sheet > 0) ? parseFloat(obj.pending_producation_sheet).toFixed(2) : 0);
					
					
				    
				  $("#total_amount_html").html((obj.total_amount > 0) ? parseFloat(obj.total_amount).toFixed(2) : 0);
				    $("#paid_amount_html").html((obj.paid_amount > 0)? parseFloat(obj.paid_amount).toFixed(2) : 0);
				    $("#due_amount_html").html((obj.due_amount > 0) ? parseFloat(obj.due_amount).toFixed(2) : 0);
					load_data_chart(obj.export_con,obj.pendingdoc_con,obj.ready_to_load,obj.produced,obj.under_producation,obj.pending_producation_sheet,obj.confirm_pi,obj.total_amount,obj.paid_amount,obj.due_amount);
					unblock_page("",""); 
                  }
              
          }); 
}
function delete_event()
{
	var deleleid = $("#editid").val();
	main_delete(deleleid,'dashboard/calaendar_delete','dashboard')
}
 
$(document).ready(function() {
$("#remainder_add").validate({
		rules: {
			remainder_text: {
				required: true
			}
		},
		messages: {
			remainder_text: {
				required: "Enter Text"
			}
		}
	});
		

var date=new Date();
var year=[date.getFullYear()]; 
var cur_year=date.getFullYear();
 $('#calendar').fullCalendar({
    header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
		eventLimit: true, 
		eventLimitText: "Something", // for all non-agenda views
		views: {
        agenda: {
            eventLimit: 2 // adjust to 6 only for agendaWeek/agendaDay
			}
		},
		editable: true,
        droppable: false,
        drop: function(date, allDay) { 
		var originalEventObject = $(this).data('eventObject');
		var copiedEventObject = $.extend({}, originalEventObject);
			copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			if ($('#drop-remove').is(':checked')) {
                $(this).remove();
            }
        },
		 eventClick:  function(event, jsEvent, view) {
        //set the values and open the modal
			// console.log(event)
				$("#showevent").modal("show");
				$("#editid").val(event.id);
				$.ajax({
				type: "POST",
				url: root+'dashboard/calaendar_data/',
				data: {  id : event.id},
				success: function(responce){
							//console.log(responce);
							var data = jQuery.parseJSON(responce);
							var startdate = data.start_date.split("-")
							var enddate = data.end_date.split("-")
							 
							$("#event_start_date").html(': '+ startdate[2] + "/"+startdate[1]+"/"+startdate[0]);
							$("#event_end_date").html(': '+enddate[2] + "/"+enddate[1]+"/"+enddate[0]);
							$("#event_text").html(': '+data.remainder_text);
							 
						}
				});
			
			 
		} 
        
    });
	
$('.fc-button-next').click(function () {
     var moment = $('#calendar').fullCalendar('getDate');
	var start = $('#calendar').fullCalendar('getView').start;
	var end = $('#calendar').fullCalendar('getView').end;
	var start1 = (start.getFullYear()+'-'+(start.getMonth()+1)+'-'+start.getDate());
	var end1 = (end.getFullYear()+'-'+(end.getMonth()+1)+'-'+end.getDate());
	if(year.indexOf(start.getFullYear())<0)
	{
		year.push(start.getFullYear());
		cur_year=start.getFullYear();
		fill_event_calander(start1,end1,cur_year)
	}

	});

	var start = $('#calendar').fullCalendar('getView').intervalStart.format('DD-MM-YYYY');
	var end = $('#calendar').fullCalendar('getView').intervalEnd.format('DD-MM-YYYY');
	 
 
 fill_event_calander(start,end,cur_year);

});
function fill_event_calander(start,end,cur_year)
{
	block_page();
	var mainurl = root+'dashboard/fetch_calenderdata?start='+start+'&end='+end;
	$.getJSON(mainurl, function(json) {
	 //console.log(json)
	var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
	var arr=new Array();
	for(var x in json){
	 
		var splitted = json[x]['start_date'].split("-");
		var splitted1 = json[x]['end_date'].split("-");
		 
		var myevent = {id: json[x]['remainder_id'],title: json[x]['remainder_text'],start: new Date(cur_year, splitted[1]-1, splitted[2]),end: new Date(cur_year, splitted1[1]-1, splitted1[2])}
		 //console.log(myevent)
		$('#calendar').fullCalendar ( 'renderEvent', myevent, true);
	}
	
	});
	unblock_page("","");
}

$("#remainder_add").submit(function(event) {
	event.preventDefault();
	if(!$("#remainder_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url : root+'dashboard/manage',
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
				   setTimeout(function(){ location.reload(); },1500);
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","Contact Already Exits.");
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


 
function load_data_chart(export_con,pendingdoc_con,ready_to_load,produced,under_producation,pending_producation_sheet,confirm_pi,total_amount,paid_amount,due_amount)
{
	block_page()
	   
		var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "Monthly Container Wise Data"
	},	
	axisY: {
		title: "Total Container",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	} ,	
	toolTip: {
		shared: true
	},
	legend:{
		cursor: "pointer"  
	},
	axisX: {
               interval:1 
  	},
	data: [{
		type: "column",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}</strong>",
		name: "Order Status",
	   	dataPoints: [
			{ label: "Confirm Order",name: "Confirm Order",  y: (confirm_pi > 0) ? confirm_pi : 0,color: "#00c0ef",},
			{ label: "Under Producation",name: "Under Producation",  y: (under_producation > 0) ? under_producation : 0,color: "#00a65a"},
			{ label: "Produced",  		name: "Produced",y: (produced > 0) ? produced : 0 ,color: "#f39c12" },
			{ label: "Ready to Load",  name: "Ready to Load", y: (ready_to_load > 0 ) ? ready_to_load : 0 ,color: "#dd4b39"},
			{ label: "Order Loaded",  	name: "Order Loaded",y: (export_con >0) ? export_con : 0,color: "#428bca" }
		]
	}]
});
		chart.render();
	 
<?php 
	  if($this->session->usertype_id == 1)
	  {
	  ?>
var chart = new CanvasJS.Chart("chartContainer1", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Payment Statistics"
	},
	legend:{
		cursor: "pointer"  
	},
 	data: [{
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}</strong>",
		 dataPoints: [
			{ y: (total_amount > 0) ? parseFloat(total_amount).toFixed(2) : 0, name: "Total Amount",color: "#00a65a"},
			{ y: (paid_amount > 0)? parseFloat(paid_amount).toFixed(2) : 0, name: "Total Received",color: "#f39c12" },
			{ y: (due_amount > 0) ? parseFloat(due_amount).toFixed(2) : 0, name: "Total Due",color: "#dd4b39" }
		]
	}]
});
chart.render();
 <?php
	  }
	  ?>
 unblock_page('',"");
}

function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}
$(".select2").select2({
	width:"100%"
});
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'MM - yyyy',
	   viewMode: "months", 
    minViewMode: "months"
	 
 });
  
$('.defualt-date-picker1').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy', 
 });
</script>