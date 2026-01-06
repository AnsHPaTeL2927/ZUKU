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
									Export Due Payment (Kasar Entry)
								</li>
								 
							</ol>
					<div class="page-header">
						<h3>Export Due Payment (Kasar Entry) </h3>
					</div>
				</div>
			</div>
			<div class="row">
			    <div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
								Export Invoice Due Payment
						 	</div>
							 <div class="panel-body" style="padding-left:0px;">
								<div class="col-md-12"></div>
									<div class="col-md-4">
									<label class="col-md-4 control-label" style="    margin-top: 5px;"><strong class=""> Select Date</strong></label>
									<div class="col-md-8">
														<?php 
																$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
																
																$invoicedate = explode(" - ",$year);
																$start_date = $invoicedate[0];
																$end_date = $invoicedate[1];
																if(!empty($_SESSION['pi_s_date']))
																{
																	$start_date = $_SESSION['pi_s_date'];
																}
																if(!empty($_SESSION['pi_e_date']))
																{
																	$end_date = $_SESSION['pi_e_date'];
																}
															
															?>
										<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" />
										<input type="hidden" id="s_date" class="form-control" value="<?=$start_date?>">
										<input type="hidden" id="e_date" class="form-control" value="<?=$end_date?>">
									</div>
									</div>
									<div class="col-md-4">
									<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Consignee</strong></label>
									<div class="col-md-7">
										<select class="select2" name="cust_id" id="cust_id"   title="Enter Consignee" onchange="load_data_table()" >
										<option value="">All Consignee</option>
										<?php 
												foreach($consign_data as $company_row)
												{
													$cust_name = (!empty($company_row->c_nick_name))?$company_row->c_nick_name:$company_row->c_companyname; 
													$sel ='';
													if($company_row->id == $_SESSION['pi_cust_id'])
													{
														$sel ='selected="selected"';
													}
													echo "<option ".$sel." value='".$company_row->id."'>".$cust_name."</option>";
												}
										?>
										</select>
									</div>
									</div>
			   
            </div>
							 	<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
												 	<th>Sr no</th>
												 	<th>Export Invoice no</th>
													<th>Date</th>
													<th>Consignee Name</th>
													<th>No of Container</th>
													<th>Total Box</th>
													<th>Total SQM</th>
													<th>Total Amount</th>
												 	<th>Kasar Payment</th>
												 	<th>Due Payment</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											 </tbody>
											 <tfoot>
												<tr>
													<th colspan="4" class="text-right">Total</th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													 
											 	 </tr>
												</tfoot>
										</table>
									</div>
								</div>
							</div>
						 
						</div>
					</div>
				</div>
	</div>
</div>
 
<?php $this->view('lib/footer'); ?>
<div id="myModal" name="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">  Kasar Amount <span id="exportinvoice_html"></span></h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="kasar_form" id="kasar_form">
				<div class="modal-body">
				 	<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Kasar Date
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Kasar Date" id="kasar_date" class="form-control defualt-date-picker" name="kasar_date" value="<?=date('d-m-Y')?>" autocomplete="off" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Kasar Amount
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Kasar Amount" id="kasar_amt" class="form-control" name="kasar_amt" value="" autocomplete="off" >
						</div>
					</div>
			    </div>
			   
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			
				<input type="hidden" name="export_invoice_id" id="export_invoice_id" />
				<input type="hidden" name="consiger_id" id="consiger_id" />
				<input type="hidden" name="kasar_amount_id" id="kasar_amount_id" />
				 
			 </form>
        </div>
    </div>
</div>

<script type="text/javascript">
$(".select2").select2({
	width:'100%'
});
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
});
$("#kasar_form").validate({
		rules: {
			kasar_date: {
				required: true
			},
			kasar_amt:{
				required:true
			}
		},
		messages: {
			kasar_date: {
				required: "Select Kasar Date"
			},
			kasar_amt:{
				required:"Select Kasar Amt"
			} 
		}
});
$("#kasar_form").submit(function(event) {
	event.preventDefault();
	if(!$("#kasar_form").valid())
	{
		return false;
	}
 	block_page();
	var postData= new FormData(this);
 	$.ajax({
            type: "post",
            url: 	root+'export_due_payment/manage',
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
				   $("#kasar_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
						setTimeout(function(){ window.location=root+'export_due_payment'; },1500);
			 	}
				else if(obj.res==2)
			    {
				   $("#kasar_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
						setTimeout(function(){ window.location=root+'export_due_payment'; },1500);
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
            'All': ['01-01-1970',$('#e_date').val()],
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
			'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb); 
 
$(document).ready(function () {
	 	load_data_table();
		
});
function filterbystatus()
{
	load_data_table()
}
function load_data_table()
{
	 
	datatable = $("#datatable").dataTable({
			"bAutoWidth" : false,
			"bFilter" 	: true,
			"bSort" 	: true,
			"aaSorting": [[0]],         
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
                { "bSortable": true },
                { "bSortable": false }
            ],   
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
			"iDisplayLength": 50,
			"sAjaxSource": root+'export_due_payment/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( 	
								{ "name": "mode", "value": "fetch" },
								{ "name" : "date" , "value" :  $("#daterange").val()},
								{"name":"cust_id","value":$("#cust_id").val()} 
							);
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			 "footerCallback": function ( row, data, start, end, display ) {
				  var api = this.api(), data;
					total = api
				 // Total over this page
					pageTotal = api
						.column( 4, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b);
                }, 0 );
				
				pageTotal1 = api
						.column( 5, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					 b =   (parseFloat(b) > 0)?parseFloat(b):0;
                    return  parseFloat(a) + parseFloat(b);
                }, 0 );
				
				pageTotal2 = api
						.column( 6, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'),""));
                }, 0 );
					var currecy_array = [];
					var currecy_total = {};
				pageTotal3 = api
						.column( 7, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
						var value_arr = b.split(" ");
						
					 	if ($.inArray(value_arr[0], currecy_array) == -1)
						{
							currecy_array.push(value_arr[0]);
							
							currecy_total[value_arr[0]] =  parseFloat(value_arr[1].replace(new RegExp(',', 'g'),""));
					 	}
						else
						{
							 currecy_total[value_arr[0]] += parseFloat(value_arr[1].replace(new RegExp(',', 'g'),""));
					 	}
						 
						 var total = [];
						 for(var i in currecy_total)
						 {
							total.push([i, currecy_total [i]]);
						 }
				   return  total;
                }, 0 );
				var currecy_array = [];
					var currecy_total = {};
				pageTotal4 = api
						.column( 8, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
						var value_arr = b.split(" ");
						
					 	if ($.inArray(value_arr[0], currecy_array) == -1)
						{
							currecy_array.push(value_arr[0]);
							
							currecy_total[value_arr[0]] =  parseFloat(value_arr[1].replace(new RegExp(',', 'g'),""));
					 	}
						else
						{
							 currecy_total[value_arr[0]] += parseFloat(value_arr[1].replace(new RegExp(',', 'g'),""));
					 	}
						 
						 var total = [];
						 for(var i in currecy_total)
						 {
							total.push([i, currecy_total [i]]);
						 }
				   return  total;
                }, 0 );
				var currecy_array = [];
					var currecy_total = {};
				pageTotal5 = api
						.column( 9, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
						var value_arr = b.split(" ");
						
					 	if ($.inArray(value_arr[0], currecy_array) == -1)
						{
							currecy_array.push(value_arr[0]);
							
							currecy_total[value_arr[0]] =  parseFloat(value_arr[1].replace(new RegExp(',', 'g'),""));
					 	}
						else
						{
							 currecy_total[value_arr[0]] += parseFloat(value_arr[1].replace(new RegExp(',', 'g'),""));
					 	}
						 
						 var total = [];
						 for(var i in currecy_total)
						 {
							total.push([i, currecy_total [i]]);
						 }
				   return  total;
                }, 0 );
				 
            // Update footer
            
			 $( api.column( 4 ).footer() ).html(
                 pageTotal.toFixed(2)
            );
			 $( api.column( 5).footer() ).html(
                 pageTotal1.toFixed(2)
            );
			$( api.column( 6).footer() ).html(
                 pageTotal2.toFixed(2) 
            );
			var a='';
				for(var i=0;i<pageTotal3.length;i++){
					 a += pageTotal3[i][0] + numberWithCommas(parseFloat(pageTotal3[i][1]).toFixed(2))+'<br>';
				}
			 $( api.column( 7 ).footer() ).html(
                 a
            );
				var a='';
				for(var i=0;i<pageTotal4.length;i++){
					 a += pageTotal4[i][0] + numberWithCommas(parseFloat(pageTotal4[i][1]).toFixed(2))+'<br>';
				}
			 $( api.column( 8 ).footer() ).html(
                 a
            );
			var a='';
				for(var i=0;i<pageTotal5.length;i++){
					 a += pageTotal5[i][0] +  numberWithCommas(parseFloat(pageTotal5[i][1]).toFixed(2))+'<br>';
				}
			 $( api.column( 9 ).footer() ).html(
                 a
            );
			 }
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}
function delete_record(id,proforma_id,no_of_export)
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
              url: root+'exportinvoice_listing/deleterecord',
              data: {
                "id"			: id,
                "proforma_id"	: proforma_id,
                "no_of_export"	: no_of_export
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'exportinvoice_listing'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function delete_shipping_bill(id)
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
              url: root+'exportinvoice_listing/delete_shipping_bill',
              data: {
                "id"			: id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'exportinvoice_listing'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function add_kasar(export_invoice_id,consiger_id,export_invoice_no,due_amt)
{
	 
	$.ajax({ 
        type: "POST", 
        url: root+"export_due_payment/add_kasar",
              data: {
                "export_invoice_id": export_invoice_id 
              }, 
              cache: false, 
              success: function (data)
			  { 
				 var obj = JSON.parse(data);
				$('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
				$("#export_invoice_id").val(export_invoice_id);
				$("#consiger_id").val(consiger_id);
				$("#exportinvoice_html").html(export_invoice_no);
				
				if(obj.res != 1)
				{
					//$("#kasar_date").val(obj.kasar_date);
				 	$("#kasar_date").datepicker('update', obj.kasar_date);
					$("#kasar_amt").val(obj.kasar_amt);
					$("#kasar_amount_id").val(obj.kasar_amount_id);
				}
				else
				{
					$("#kasar_date").datepicker('update', '<?=date("d-m-Y")?>');
					$("#kasar_amt").val(due_amt.replace(/\,/g, ''));
				}
				 
			}

		});  

}
</script>