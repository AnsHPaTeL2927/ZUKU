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
									Customer Invoice
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Customer Invoice  
									<div class="pull-right form-group">
										<a class="btn btn-info tooltips" data-title="View in Pdf" onclick="downloadPDF()"><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									</div>
							</h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Customer Invoice
									
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
												<input type="radio" name="invoice_status" id="invoice_status4" value="3"  onclick="filterbystatus(this.value)" >Packing Pending 
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
											 
											if(!empty($_SESSION['customer_s_date']))
											{
												$start_date = $_SESSION['customer_s_date'];
											}
											if(!empty($_SESSION['customer_e_date']))
											{
												$end_date = $_SESSION['customer_e_date'];
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
													 if($company_row->id == $_SESSION['customer_cust_id'])
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
									<strong class=""> Select Customer Invoice</strong>
									</label>
									<div class="col-sm-2">
										<select class="select2" name="customerdata" id="customerdata" required title="Select Consignee Name" onchange="load_data_table()" >
											<option value="">All Customer Invoice No</option>
											<?php
											for($p=0;$p<count($customer_data);$p++)
											{
													$sel = '';
													if($customer_data[$p]->export_invoice_id == $_SESSION['get_customerdata'])
													{
														$sel = 'selected="selected"';
													}
												echo "<option ".$sel." value='".$customer_data[$p]->customer_invoice_id."'>".$customer_data[$p]->customer_invoice_no." </option>";
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
													<th>Status</th>
													<th>Invoice Date</th>
													<th>Customer Invoice no</th>
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
			"bFilter" : true,
			"bSort" : true,
			"aaSorting": [[0]],         
            "aoColumns": [
                 { "bSortable": false },
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
			"sAjaxSource": root+'customer_listing/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "invoice_status" , "value" :  $("input[name='invoice_status']:checked"). val()},{ "name" : "date" , "value" :  $("#daterange"). val()},{ "name" : "cust_id" , "value" :  $("#cust_id"). val()},{ "name" : "customerdata" , "value" :  $("#customerdata"). val()}  );
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
    $.ajax({
        url: root + 'customer_listing/fetch_record/',
        type: 'GET',
        data: {
            mode: 'fetch',
            cust_id: $("#cust_id").val(),
            date: $("#daterange").val(),
            length: -1 
        },
        dataType: 'json',
        success: function (response) {
            var pdfData = [];

         
            pdfData.push([
                { text: 'Sr no', fillColor: '#0C6291', color: 'white', bold: true },
                { text: 'Invoice Date', fillColor: '#0C6291', color: 'white', bold: true },
                { text: 'Customer Invoice No', fillColor: '#0C6291', color: 'white', bold: true },
                { text: 'Consignee Name', fillColor: '#0C6291', color: 'white', bold: true },
                { text: 'No Of Container', fillColor: '#0C6291', color: 'white', bold: true },
                { text: 'Port Of Discharge', fillColor: '#0C6291', color: 'white', bold: true },
                { text: 'Total Amount', fillColor: '#0C6291', color: 'white', bold: true }
            ]);

            response.aaData.forEach(function (row, index) {
			var invoiceDate = row[1];
			var invoiceNo = ''; 

			
			var temp = document.createElement('div');
			temp.innerHTML = row[2]; 

			var dropdownToggle = temp.querySelector('.dropdown a[data-toggle="dropdown"]').textContent.trim();
			if (dropdownToggle) {
				invoiceNo = dropdownToggle;
			} else {
				invoiceNo = 'N/A'; 
			}

			pdfData.push([
				index + 1,
				invoiceDate, 
				invoiceNo, 
				row[3], 
				row[4],
				row[5], 
				row[6] 
			]);
		});


            var docDefinition = {
                pageOrientation: 'landscape',
                content: [
                    { text: 'Customer Invoice', style: 'header' },
                    {
                        table: {
                            headerRows: 1,
                            body: pdfData
                        },
                        layout: {
                            hLineWidth: function (i, node) {
                                return 1;
                            },
                            vLineWidth: function (i, node) {
                                return 1;
                            },
                            hLineColor: function (i, node) {
                                return '#E0E0E0';
                            },
                            vLineColor: function (i, node) {
                                return '#E0E0E0';
                            },
                            paddingLeft: function (i, node) {
                                return 4;
                            },
                            paddingRight: function (i, node) {
                                return 4;
                            },
                            paddingTop: function (i, node) {
                                return 2;
                            },
                            paddingBottom: function (i, node) {
                                return 6;
                            },
                            fillColor: function (i, node) {
                                return (i === 0) ? '#F0F0F0' : null;
                            }
                        }
                    }
                ],
                styles: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    }
                }
            };

            var widths = [];
            docDefinition.content[1].table.body.forEach(function (row) {
                row.forEach(function (cell, i) {
                    var cellText = cell.text || cell;
                    var cellLength = cellText.toString().length;
                    if (!widths[i] || cellLength > widths[i]) {
                        widths[i] = cellLength;
                    }
                });
            });

            var totalWidth = widths.reduce((sum, width) => sum + width, 0);
            docDefinition.content[1].table.widths = widths.map((w, i) => {
                if (i === 3) {
                    return ((w + totalWidth * 0.05) / totalWidth) * 100 + '%';
                }
                return (w / totalWidth) * 100 + '%';
            });

            docDefinition.content[1].table.body.forEach(function (row, rowIndex) {
                row.forEach(function (cell, cellIndex) {
                    if (typeof cell === 'string') {
                        row[cellIndex] = { text: cell };
                    }
                    if (rowIndex === 0) {
                        row[cellIndex].fillColor = '#0C6291';
                        row[cellIndex].bold = true;
                    }
                });
            });
			
            var pdfDoc = pdfMake.createPdf(docDefinition);
            pdfDoc.download('Commercial Invoice.pdf');
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data for PDF:", error);
        }
    });
}



$('#downloadPDFButton').on('click', function() {
    downloadPDF();
});

$(document).ready(function() {
    load_data_table();
});

function delete_record(id,export_invoice_id)
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
              url: root+'customer_listing/deleterecord',
              data: {
                "id"				: id,
                "export_invoice_id"	: export_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'customer_listing'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function updateperforma_invoice(proforma_id,no_of_export)
{
	$.ajax({ 
        type: "POST", 
        url: root+"exportinvoice_listing/updateperforma_invoice",
              data: {
                "id": proforma_id,
				"no_of_export":no_of_export
              }, 
              cache: false, 
              success: function (data) { 
              
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