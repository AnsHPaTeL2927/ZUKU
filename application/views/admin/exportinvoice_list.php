<?php 
$this->view('lib/header'); 
$_SESSION['beenhere'] = 1;
?>	 <div class="main-container">
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
									Export Invoice
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Export Invoice  
								  <a href="<?php echo base_url('exportinvoice/add_invoice'); ?>" style="float:right;" type="button" class="btn btn-info">
								+ Export Invoice 
								</a>
							</h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Export Invoice
									
								</div>
								<div class="panel-body" >
									 <div class="col-md-12">
										<label class="col-md-1 control-label "><strong class="pull-right">Stage</strong></label>
										 <div class="col-md-9">
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status1" value="0"  onclick="filterbystatus(this.value)" checked >All
											</label>
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status2" value="1"  onclick="filterbystatus(this.value)" >Completed 
											</label>
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status3" value="2"  onclick="filterbystatus(this.value)" >Product Pending 
											</label>
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status3" value="5"  onclick="filterbystatus(this.value)" >EPCG Pending 
											</label>
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status4" value="4"  onclick="filterbystatus(this.value)">Packing Pending 
											</label>
											<label class="radio-inline">
												<input type="radio" name="invoice_status" id="invoice_status4" value="3"  onclick="filterbystatus(this.value)">Annexure Pending 
											</label>
											
										 </div>     
									</div> 
									<div class="col-md-4">
										<label class="col-md-4 control-label" style="    margin-top: 5px;"><strong class=""> Invoice Date</strong></label>
										 <div class="col-md-8">
										<?php 
											$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
											
											$invoicedate = explode(" - ",$year);
											$start_date = $invoicedate[0];
											$end_date 	= $invoicedate[1];
											 
											if(!empty($_SESSION['export_s_date']))
											{
												$start_date = $_SESSION['export_s_date'];
											}
											if(!empty($_SESSION['export_e_date']))
											{
												$end_date = $_SESSION['export_e_date'];
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
													 if($company_row->id == $_SESSION['export_cust_id'])
													 {
														 $sel ='selected="selected"';
													 }
													echo "<option ".$sel." value='".$company_row->id."'>".$cust_name."</option>";
												}
												?>
										</select>
										 </div>     
									</div>
									
									<label class="col-md-2 control-label" style="margin-top: 5px;">
									<strong class=""> Select Export Invoice</strong>
									</label>
									<div class="col-sm-2">
										<select class="select2" name="export_invoice_id" id="export_invoice_id" required title="Select Consignee Name" onchange="load_data_table()" >
											<option value="">All Export Invoice No</option>
											<?php
											for($p=0;$p<count($export_data);$p++)
											{
													$sel = '';
													if($export_data[$p]->export_invoice_id == $_SESSION['get_exportdata'])
													{
														$sel = 'selected="selected"';
													}
												echo "<option ".$sel." value='".$export_data[$p]->export_invoice_id."'>".$export_data[$p]->export_invoice_no." </option>";
											}
											?>
											
										</select>
									</div>
							
								</div>
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
													<th style="width: 100px;">														<button class="btn btn-info tooltips" data-toggle="tooltip" data-title="Commercial Invoice" onclick="create_commercial_invoice()"> + Commercial</button>													</th>	
													<th>Status</th>
													<th>Invoice Date</th>
													<th>Export Invoice No</th>													<th>Proforma Invoice No </th>													<th style="width: 100px;">Master No</th>
													<th>Consignee Name</th>
													<th>No of Container</th>
													<th>Port Of Discharge</th>
													<th>Total Amount</th>
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
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Detail</h4>
            </div>
            <div class="modal-body">
				<div class="productdetailhtml"></div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $this->view('lib/footer'); ?>
<script type="text/javascript">
$(".select2").select2({
	width:'100%'
});
function create_commercial_invoice()
{
	var export_invoice_id = [];
	$. each($("input[name='allexport_invoice[]']:checked"), function(){
		export_invoice_id.push($(this). val());
	});
	if(export_invoice_id.length < 2)
	{
		toastr["error"]("Please select atleast 2 invoice.")
	}
	else
	{
		block_page();
		$.ajax({ 
			type: "POST", 
			url: root+'exportinvoice_listing/check_congine',
			data: {
				"export_invoice_id"	: export_invoice_id
			}, 
			cache: false, 
			success: function (data)
			{ 
					var obj = JSON.parse(data);
					 
					if(obj.res==1)
					{
						 window.location=root+'create_customer_invoice/mutiple/'+export_invoice_id.join('-');
					}
					else
					{
						toastr["error"]("Consignee name are different. Allow only for same consignee.")
					}	
			
					unblock_page('',"")
			}
		});
	}
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
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },				                { "bSortable": true },				                { "bSortable": true },
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
			dom: 'Blfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf-o"></i>',
            orientation: 'landscape',
            pageSize: 'A4',
            titleAttr: 'PDF',
			title: 'Export Invoice',
            customize: function (doc) {
                
                doc.content[1].table.body.forEach(function (row) {
                    row.splice(-1, 1); 
                    row.splice(0, 2); 
                });

				var widths = [];
                  doc.content[1].table.body.forEach(function(row) {
                      row.forEach(function(cell, i) {
                          var cellText = cell.text || cell;
                          var cellLength = cellText.toString().length;
                          if (!widths[i] || cellLength > widths[i]) {
                              widths[i] = cellLength;
                          }
                      });
                  });

				  	doc.styles.tableHeader.fontSize = 16; 
                	doc.defaultStyle.fontSize = 14; 


				  	doc.content[1].layout = {
						hLineWidth: function(i, node) { return 1; },
						vLineWidth: function(i, node) { return 1; },
						hLineColor: function(i, node) { return '#E0E0E0'; },
						vLineColor: function(i, node) { return '#E0E0E0'; },						vLineColor: function(i, node) { return '#E0E0E0'; },						vLineColor: function(i, node) { return '#E0E0E0'; },
						paddingLeft: function(i, node) { return 4; },
						paddingRight: function(i, node) { return 4; },
						paddingTop: function(i, node) { return 2; },
						paddingBottom: function(i, node) { return 4; },
						fillColor: function(i, node) { return (i === 0) ? '#F0F0F0' : null; }
					};

					// Ensure all cells are objects and set background color for header row
					doc.content[1].table.body.forEach(function(row, rowIndex) {
						row.forEach(function(cell, cellIndex) {
							if (typeof cell === 'string') {
								row[cellIndex] = { text: cell };
							}
							if (rowIndex === 0) {
								row[cellIndex].fillColor = '#0C6291';
								row[cellIndex].bold = true;
							}
						});
					});

            }
        }],
			"sAjaxSource": root+'exportinvoice_listing/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },
							{ "name" : "invoice_status" , "value" :  $("input[name='invoice_status']:checked"). val()},
							{ "name" : "date" , "value" :  $("#daterange").val()},
							{"name":"cust_id","value":$("#cust_id").val()},
							{"name":"export_invoice_id","value":$("#export_invoice_id").val()}
						);
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}

function downloadPDF() {
    var table = $('#datatable').DataTable();
    table.button('.buttons-pdf').trigger();
}
function delete_record(id)
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
                "id" : id,
                 
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

function delete_record_vgm(id)
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
              url: root+'exportinvoice_listing/deleterecord_vgm',
              data: {
                "id" : id,
                 
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


function view_detail(id,currency_id)
{
	 
	$.ajax({ 
        type: "POST", 
        url: root+"exportinvoice_listing/viewproductdetail",
              data: {
                "id": id,
				"currency_id":currency_id
              }, 
              cache: false, 
              success: function (data) { 
               $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
                
                 $(".productdetailhtml").html(data);  
			}

		});  

}
</script>