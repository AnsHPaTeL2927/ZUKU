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
            <li> <i class="clip-pencil"></i> <a href="<?=base_url()?>dashboard"> Dashboard </a> </li>
            <li class="active"> Proforma Invoice </li>
          </ol>
          <div class="page-header">
            <h3>Proforma Invoice <a href="<?php echo base_url('invoice'); ?>" style="float:right;" type="button" class="btn btn-info"> + New Proforma Invoice </a> </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> 
			Proforma Invoice 
			
			<a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
									
				<div id="myModal1" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">How To Make Performa Invoice</h4>
							</div>
							<div class="modal-body">
								<iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/3r-QzWpM1EQ?rel=0&autoplay=1&end=35"
								frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
					</div>
				</div>
				
			</div>
            <div class="panel-body" style="padding-left:0px;">
              <div class="col-md-8">
                <label class="col-md-2 control-label "><strong class="">Invoice Status</strong></label>
                <div class="col-md-10">
                  <label class="radio-inline">
                    <input type="radio" name="invoice_status" id="invoice_status1" value="0"  onclick="filterbystatus(this.value)" checked>
                    All(Without Archive)
					</label>
                 
                  <label class="radio-inline">
                    <input type="radio" name="invoice_status" id="invoice_status3" value="2"  onclick="filterbystatus(this.value)" <?=($_SESSION['pi_step_status'] == 2)?"checked":""?> >
                    Product Setup </label>
                  <label class="radio-inline">
                    <input type="radio" name="invoice_status" id="invoice_status4" value="3"  onclick="filterbystatus(this.value)" <?=($_SESSION['pi_step_status'] == 3)?"checked":""?> >
                    Additional Detail </label>
					 <label class="radio-inline">
                    <input type="radio" name="invoice_status" id="invoice_status2" value="1"  onclick="filterbystatus(this.value)"  <?=($_SESSION['pi_step_status'] == 1)?"checked":""?>>
                    Completed </label>
					
					<label class="radio-inline">
                    <input type="radio" name="invoice_status" id="invoice_status2" value="4"  onclick="filterbystatus(this.value)" <?=($_SESSION['pi_step_status'] == 4)?"checked":""?> >
                    Archived </label>
                </div>
              </div>
              <div class="col-md-12"></div>
              <div class="col-md-4">
                <label class="col-md-4 control-label" style="    margin-top: 5px;"><strong class=""> Invoice Date</strong></label>
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
              <div class="invoice-table-scroll-wrapper">
                <div id="invoice-table-loader" class="invoice-table-loader" style="display:none;">
                  <img src="<?php echo base_url('adminast/assets/images/loader.gif'); ?>" alt="" />
                  <span>Loading ...</span>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover display" id="datatable" width="100%">
                    <thead>
                      <tr>
                        <th>Status</th>
                        <th>Proforma Invoice no</th>
                        <th>Date</th>
                        <th>Consignee Name</th>
                        <th>Country Name</th>
                        <th>No of container</th>
                        <th>Product Detail</th>
                        <th>Total Box</th>
                        <th>Total Sqm</th>
                        <th>Total Amount</th>
                        <th>Days Ago</th>
                        <th>Created By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th></th>
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
</div>
<style>
.invoice-table-scroll-wrapper {
  position: relative;
  overflow-x: auto;
  overflow-y: visible;
  -webkit-overflow-scrolling: touch;
  min-height: 200px;
}
.invoice-table-scroll-wrapper .table-responsive {
  overflow-x: visible;
  overflow-y: visible;
  min-width: 0;
}
.invoice-table-scroll-wrapper #datatable {
  min-width: 1600px;
  width: 100% !important;
}
.invoice-table-loader {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background: rgba(255, 255, 255, 0.9);
  z-index: 10;
  gap: 10px;
}
.invoice-table-loader img {
  display: block;
}
.invoice-table-loader span {
  font-size: 14px;
  color: #333;
}
</style>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <!-- Modal content-->
    <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Open Page </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 row">
            <label class="col-md-2 control-label "><strong class="">Select Page</strong></label>
            <div class="col-md-10">
              <label class="radio-inline">
                <input type="radio" name="page_status" id="page_status1" value="1"  onclick="open_page(this.value)"  >
                Basic Detail </label>
              <label class="radio-inline">
                <input type="radio" name="page_status" id="page_status2" value="2"  onclick="open_page(this.value)"  >
                Product Setup </label>
              <label class="radio-inline">
                <input type="radio" name="page_status" id="page_status1" value="3"  onclick="open_page(this.value)"  >
                Additional Detail </label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="hidden" name="invoice_id" id="invoice_id" >
      </div>
    </div>
  </div>
</div>
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <!-- Modal content-->
    <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title set_title"></h4>
      </div>
      <div class="modal-body">
        <div class="col-md-4">
          <div class="field-group" >
            <select class="select2" id="size_id" name="size_id"  >
              <option value="">All Size</option>
              <?php
								for($p=0;$p<count($allproductsize);$p++)
								{
									 
								 ?>
              <option value="<?=$allproductsize[$p]->product_id?>">
              <?=$allproductsize[$p]->size_type_mm?>
              </option>
              <?php
								}
								?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="field-group" >
            <select class="select2" id="design_id" name="design_id"  >
              <option value="">All Design</option>
              <?php
								for($p=0;$p<count($alldesign);$p++)
								{
								?>
              <option value="<?=$alldesign[$p]->packing_model_id?>">
              <?=$alldesign[$p]->model_name?>
              </option>
              <?php
								}
								?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="field-group" >
            <select class="select2" id="finish_id" name="finish_id"  >
              <option value="">All Finish</option>
              <?php
								for($p=0;$p<count($allfinish);$p++)
								{
									 
								 ?>
              <option value="<?=$allfinish[$p]->finish_id?>">
              <?=$allfinish[$p]->finish_name?>
              </option>
              <?php
								}
								?>
            </select>
          </div>
        </div>
        <div class="col-md-12" style="height:20px;"> </div>
        <div class="productdetailhtml1"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php $this->view('lib/footer'); ?>
<script type="text/javascript">
// Global helper function to safely block page - works even if block_page is not defined
function safeBlock() {
	if(typeof block_page === 'function') {
		safeBlock();
	} else if(typeof $.blockUI === 'function') {
		$.blockUI({ css: {
			border: 'none',
			padding: '0px',
			width: '17%',
			left:'43%',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff',
			zIndex: '10000'
		},
		message :  '<h3> Please wait...</h3>' });
	}
}

// Global helper function to safely unblock page - works even if unblock_page is not defined
function safeUnblock(type, msg) {
	if(typeof unblock_page === 'function') {
		unblock_page(type, msg);
	} else if(typeof $.unblockUI === 'function') {
		// Fallback to direct jQuery unblockUI
		if(type !== "" && msg !== "") {
			if(typeof toastr !== 'undefined') {
				toastr[type](msg);
			}
		}
		setTimeout(function(){ $.unblockUI(); }, 500);
	} else {
		// Last resort: just show message if toastr is available
		if(typeof toastr !== 'undefined' && type !== "" && msg !== "") {
			toastr[type](msg);
		}
	}
}

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

$(".select2").select2({
	width:'100%'
});
function confirm_pi(id,status)
{
	var title="You want to confirm PI?";
	var successMsg = "PI status changed successfully";
	
	if(status == 2)
	{
		 title="You want to archive PI?";
		 successMsg = "PI archived successfully";
	}
	else if(status == 0)
	{
		 title="You want to unarchive PI?";
		 successMsg = "PI unarchived successfully";
	}
	else if(status == 1)
	{
		 title="You want to confirm PI?";
		 successMsg = "PI successfully confirmed";
	}
	
	Swal.fire({
		title: title,
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, do it!'
}).then((result) => {
		 if (result.value) {
			safeBlock();
			  $.ajax({ 
              type: "POST", 
              url: root+'invoice_listing/confirmpi',
              data: {
                "id"	 : id,
				"status" : status
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{ 
					safeUnblock('success', successMsg);
					setTimeout(function(){ window.location=root+'invoice_listing'; },1500);
				}
                else{
					safeUnblock('error',"Something went wrong. Please try again.")
				}
              },
			  error: function(jqXHR, textStatus, errorThrown) {
				  console.log('AJAX Error:', errorThrown);
				  console.log('Response Text:', jqXHR.responseText);
				  safeUnblock('error', "An error occurred. Please try again.");
			  }
			});
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
 
$(document).ready(function (){
	if (typeof closeNav === 'function') closeNav();
	load_data_table();
});

function filterbystatus()
{
	load_data_table()
}
var pageTotal = 0;
var pageTotal1 = 0;
var pageTotal2 = 0;
var pageTotal3 = [];

function load_data_table() {
    datatable = $("#datatable").dataTable({
        "bAutoWidth": false,
        "bFilter": true,
        "bSort": true,
        "aaSorting": [[0]],
        "aoColumns": [
            { "bSortable": false },
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
            { "bSortable": true },
            { "bSortable": false }
        ],
        "bProcessing": false,
        "searchDelay": 350,
        "bServerSide": true,
        "bDestroy": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_",
            "sProcessing": "<img src='" + root + "adminast/assets/images/loader.gif'/> Loading ...",
            "sEmptyTable": "No Records found in Database - Please add new record using entry form !",
            "sSearch": "",
            "sInfoFiltered": ""
        },
        "aLengthMenu": [[-1, 10, 20, 30, 50], ["All", 10, 20, 30, 50]],
        "iDisplayLength": 50,
        "dom": 'Blfrtip',
        "buttons": [{
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf-o"></i>',
            orientation: 'landscape',
            pageSize: 'A4',
            titleAttr: 'PDF',
            title: 'Proforma Invoice',

            customize: function (doc) {
                doc.content[1].table.body.forEach(function (row) {
                    row.splice(-1, 1);
                    row.splice(0, 1);
                });
                
                var columnCount = doc.content[1].table.body[0].length;

                var totalRow = new Array(columnCount).fill('');  

                totalRow[4] = { text: '' + pageTotal.toFixed(2), bold: true }; 
                totalRow[6] = { text: '' + pageTotal1.toFixed(2), bold: true };
                totalRow[7] = { text: '' + pageTotal2.toFixed(2), bold: true }; 
                totalRow[8] = { text: '' + formatCurrencyTotals(pageTotal3), bold: true }; 

                doc.content[1].table.body.push(totalRow);

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

                  // Normalize widths
                  var totalWidth = widths.reduce((sum, width) => sum + width, 0);
                  doc.content[1].table.widths = widths.map(w => (w / totalWidth) * 100 + '%');

                  // Apply Excel-like styling
                  doc.content[1].layout = {
                      hLineWidth: function(i, node) { return 1; },
                      vLineWidth: function(i, node) { return 1; },
                      hLineColor: function(i, node) { return '#E0E0E0'; },
                      vLineColor: function(i, node) { return '#E0E0E0'; },
                      paddingLeft: function(i, node) { return 4; },
                      paddingRight: function(i, node) { return 4; },
                      paddingTop: function(i, node) { return 2; },
                      paddingBottom: function(i, node) { return 5; },
                      fillColor: function (i, node) { return (i === 0) ? '#F0F0F0' : null; }
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
        
        "sAjaxSource": root + 'invoice_listing/fetch_record/',
        "fnServerParams": function (aoData) {
            aoData.push({ "name": "mode", "value": "fetch" }, { "name": "invoice_status", "value": $("input[name='invoice_status']:checked").val() }, { "name": "date", "value": $("#daterange").val() }, { "name": "cust_id", "value": $("#cust_id").val() });
        },
        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {
            var sEcho = 1;
            for (var i = 0; i < aoData.length; i++) {
                if (aoData[i].name === 'sEcho') { sEcho = parseInt(aoData[i].value, 10); break; }
            }
            var $loader = $('#invoice-table-loader');
            $loader.css('display', 'flex');
            $.ajax({
                url: sSource,
                data: aoData,
                dataType: 'json',
                type: 'GET',
                cache: false,
                success: function (json) {
                    $loader.hide();
                    fnCallback(json);
                },
                error: function (xhr, err, thrown) {
                    $loader.hide();
                    console.warn('Proforma Invoice fetch error:', err, thrown);
                    fnCallback({ sEcho: sEcho, iTotalRecords: 0, iTotalDisplayRecords: 0, aaData: [] });
                }
            });
        },
        "fnDrawCallback": function (oSettings) {
            $('.ttip, [data-toggle="tooltip"]').tooltip();
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();

            // Calculate page totals
            pageTotal = api.column(5, { page: 'current' }).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'), ""));
            }, 0);

            $(api.column(5).footer()).html(pageTotal.toFixed(2));

            pageTotal1 = api.column(7, { page: 'current' }).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);

            $(api.column(7).footer()).html(pageTotal1.toFixed(2));

            pageTotal2 = api.column(8, { page: 'current' }).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b.replace(new RegExp(',', 'g'), "  "));
            }, 0);

            $(api.column(8).footer()).html(pageTotal2.toFixed(2));

            var currencyTotals = {};
            pageTotal3 = api.column(9, { page: 'current' }).data().reduce(function (a, b) {
                var value_arr = b.split(" ");
                var currency = value_arr[0];
                var amount = parseFloat(value_arr[1]);

                if (!(currency in currencyTotals)) {
                    currencyTotals[currency] = amount;
                } else {
                    currencyTotals[currency] += amount;
                }

                return currencyTotals;
            }, []);

              var formattedCurrencyTotals = formatCurrencyTotals(pageTotal3);
              $(api.column(9).footer()).html(formattedCurrencyTotals);
        }
    });

    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
}

function formatCurrencyTotals(currencyTotals) {
    var formattedTotals = '';
    for (var currency in currencyTotals) {
        if (currencyTotals.hasOwnProperty(currency)) {
            formattedTotals += currency + ' ' + currencyTotals[currency].toFixed(2) + '\n';
        }
    }
    return formattedTotals.trim();
}
function downloadPDF() {
    var table = $('#datatable').DataTable();
    table.button('.buttons-pdf').trigger();
}
function delete_record(product_size_id)
{
	main_delete(product_size_id,'invoice_listing/deleterecord','invoice_listing')
}
function archive_record(product_size_id)
{
	main_delete(product_size_id,'invoice_listing/archive_record','invoice_listing')
}
function open_page(value)
{
	if(value==1)
	{
		window.location = root+"invoice/form_edit/"+$("#invoice_id").val();
	}
	else if(value==2)
	{
		window.location = root+"product/index/"+$("#invoice_id").val();
	}
	else if(value==3)
	{
		window.location = root+"addition_details/index/"+$("#invoice_id").val();
	}
}
function view_detail(id)
{
  $('#myModal').modal({
			backdrop: 'static',
			keyboard: false
		});
    $("#invoice_id").val(id)  
   
}
function loaded_size(performa_invoice_id,html,url)
{
	block_page();
	 $.ajax({ 
              type: "POST", 
              url: root+url,
              data: {
                "performa_invoice_id"	: performa_invoice_id,
                "size_id"				: $("#size_id").val(),
                "finish_id"				: $("#finish_id").val(),
                "design_id"				: $("#design_id").val()
              }, 
              cache: false, 
              success: function (data) 
			  { 
					 $(".set_title").html(html);
					 $("#size_id").attr("onchange","loaded_size("+performa_invoice_id+",'"+html+"','"+url+"')");
					 $("#finish_id").attr("onchange","loaded_size("+performa_invoice_id+",'"+html+"','"+url+"')");
					 $("#design_id").attr("onchange","loaded_size("+performa_invoice_id+",'"+html+"','"+url+"')");
					 
					 $(".productdetailhtml1").html(data);
					 $("#myModal1").modal('show')
					safeUnblock("","");
              }
			});
}
</script>
