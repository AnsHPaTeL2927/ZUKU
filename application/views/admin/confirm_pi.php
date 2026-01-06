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
							<a href="<?= base_url() ?>dashboard">
								Dashboard
							</a>
						</li>
						<li class="active">
							Confirm Proforma Invoice
						</li>
					</ol>
					<div class="page-header">
						<h3>Confirm Proforma Invoice
							<div class="pull-right form-group">
								<a class="btn btn-primary tooltips" href="<?= base_url() ?>change_order"><i
										class="fa fa-pencil"></i> Change In Order</a>
								<a class="btn btn-info tooltips" data-title="View in Pdf" onclick="downloadPDF()"><i
										class="fa fa-file-pdf-o"></i> Export Pdf</a>
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
							Confirm Proforma Invoice
						</div>
						<div class="panel-body" style="padding-left:0px;">
							<div class="col-md-4">
								<label class="col-md-4 control-label" style="    margin-top: 5px;"><strong class="">
										Invoice Date</strong></label>
								<div class="col-md-8">
									<?php
									$year = date('n') > 3 ? date('01/04/Y') . ' - ' . (date('31/03/Y', strtotime("+1 year"))) : (date('01/04/Y', strtotime("-1 year"))) . ' - ' . date('31/03/Y');
									$invoicedate = explode(" - ", $year);

									$start_date = $invoicedate[0];
									$end_date = $invoicedate[1];
									if (!empty($_SESSION['cpi_s_date'])) {
										$start_date = $_SESSION['cpi_s_date'];
									}
									if (!empty($_SESSION['cpi_e_date'])) {
										$end_date = $_SESSION['cpi_e_date'];
									}
									?>
									<input type="text" name="daterange" id="daterange" class="form-control"
										value="<?= $year ?>" onchange="load_data_table()" />
									<input type="hidden" id="s_date" class="form-control" value="<?= $start_date ?>">
									<input type="hidden" id="e_date" class="form-control" value="<?= $end_date ?>">
								</div>
							</div>
							<div class="col-md-4">
								<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select
										Consignee</strong></label>
								<div class="col-md-7">
									<select class="select2" name="cust_id" id="cust_id" title="Enter Consignee"
										onchange="load_data_table()">
										<option value="">All Consignee</option>
										<?php
										foreach ($consign_data as $company_row) {

											$cust_name = (!empty($company_row->c_nick_name)) ? $company_row->c_nick_name : $company_row->c_companyname;
											$sel = '';
											if ($company_row->id == $_SESSION['cpi_cust_id']) {
												$sel = 'selected="selected"';
											}
											echo "<option " . $sel . "  value='" . $company_row->id . "'>" . $cust_name . "</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Days after confirm</strong></label>
								<div class="col-md-7">
									<select class="select2" name="days_filter" id="days_filter" title="Select Days" onchange="load_data_table()">
										<option value="">All Days</option>
										<option value="0-7" <?= (!empty($_SESSION['cpi_days_filter']) && $_SESSION['cpi_days_filter'] == '0-7') ? 'selected' : '' ?>>0-7 days</option>
										<option value="7-14" <?= (!empty($_SESSION['cpi_days_filter']) && $_SESSION['cpi_days_filter'] == '7-14') ? 'selected' : '' ?>>7-14 days</option>
										<option value="14-21" <?= (!empty($_SESSION['cpi_days_filter']) && $_SESSION['cpi_days_filter'] == '14-21') ? 'selected' : '' ?>>14-21 days</option>
										<option value="21-28" <?= (!empty($_SESSION['cpi_days_filter']) && $_SESSION['cpi_days_filter'] == '21-28') ? 'selected' : '' ?>>21-28 days</option>
										<option value="28-60" <?= (!empty($_SESSION['cpi_days_filter']) && $_SESSION['cpi_days_filter'] == '28-60') ? 'selected' : '' ?>>28-60 days</option>
										<option value="60-90" <?= (!empty($_SESSION['cpi_days_filter']) && $_SESSION['cpi_days_filter'] == '60-90') ? 'selected' : '' ?>>60-90 days</option>
										<option value="90-" <?= (!empty($_SESSION['cpi_days_filter']) && $_SESSION['cpi_days_filter'] == '90-') ? 'selected' : '' ?>>90+ days</option>
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
											<th>Proforma Invoice no</th>
											<th>Consignee Name</th>
											<th>Grand total</th>
											<th>Date</th>
											<th>No of Ordered Container</th>
											<th>Product Detail</th>
											<th>Producation Sheet Done Container</th>
											<th>Pending For Producation Sheet</th>
											<th>Days after confirm</th>
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
				<h4 class="modal-title">Advance Payment for <span id="invoice_no_html"></span></h4>
			</div>
			<form class="form-horizontal askform" action="javascript:;" method="post" name="advance_payment_form"
				id="advance_payment_form">
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Payment Date
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Payment Date" id="payment_date"
								class="form-control defualt-date-picker" name="payment_date"
								value="<?= date('d-m-Y'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Advance Amount
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Advance Amount" id="amount" class="form-control"
								name="amount" value="" required title="Select Advance Amount" required
								title="Enter Advance Amount">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Payment document
						</label>
						<div class="col-sm-8">
							<input type="file" id="payment_document" class="form-control" name="payment_document"
								value="" title="Enter Payment document">
						</div>
						<div class="col-md-2">
							<a class="btn btn-info" target="blank" style="display:none"
								id="payment_document_download_btn"><i class="fa fa-download"></i></a>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button name="Submit" type="submit" class="btn btn-success">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<input type="hidden" name="performa_invoice_id" id="performa_invoice_id" />
				<input type="hidden" name="pi_advance_payment_id" id="pi_advance_payment_id" />
				<input type="hidden" name="pi_consignee_id" id="pi_consignee_id" />
				<input type="hidden" name="payment_document_file" id="payment_document_file" />
			</form>
		</div>
	</div>
</div>
<?php $this->view('lib/footer'); ?>
<script type="text/javascript">
	$(".select2").select2({
		width: '100%'
	});
	$('.defualt-date-picker').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy',

	});
	function advance_payment(performa_invoice_id, invoice_no, pi_consignee_id) {
		$("#myModal").modal('show');
		$("#invoice_no_html").html(invoice_no);
		$("#performa_invoice_id").val(performa_invoice_id);
		$("#pi_consignee_id").val(pi_consignee_id);
	}
	function edit_advance_payment(performa_invoice_id, invoice_no, pi_consignee_id) {
		block_page();
		$.ajax({
			type: "POST",
			url: root + "confirm_pi/fetch_advance_payment_data",
			data: { "id": performa_invoice_id },
			success: function (response) {
				var obj = JSON.parse(response);

				$("#myModal").modal({
					backdrop: 'static',
					keyboard: false
				});
				$("#invoice_no_html").html(invoice_no);
				$("#performa_invoice_id").val(performa_invoice_id);
				$("#pi_advance_payment_id").val(obj.pi_advance_payment_id);
				$("#payment_date").val(obj.payment_date);
				$("#amount").val(obj.amount);
				$("#pi_consignee_id").val(pi_consignee_id);
				$("#payment_document_file").val(obj.payment_document);
				$("#payment_document_download_btn").show();
				$("#payment_document_download_btn").attr("href", root + "upload/" + obj.payment_document);
				unblock_page("", "");
			}

		});
	}
	function create_po_invoice() {
		var performa_invoice_id = [];
		$.each($("input[name='allperforma_invoice[]']:checked"), function () {
			performa_invoice_id.push($(this).val());
		});
		if (performa_invoice_id.length < 2) {
			toastr["error"]("Please select atleast 2 invoice.");
		}
		else {
			window.location = root + 'createpo/mutiplecopy/' + performa_invoice_id.toString().replace(/\,/g, '-');
		}
	}
	function confirm_pi(id, status) {
		Swal.fire({
			title: 'You want to change status from confirm PI to pending?',
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
					url: root + 'invoice_listing/confirmpi',
					data: {
						"id": id,
						"status": status
					},
					cache: false,
					success: function (data) {
						var obj = JSON.parse(data);
						if (obj.res == 1) {
							unblock_page('success', "PI Successfully confirmed");
							setTimeout(function () { window.location = root + 'confirm_pi'; }, 1500);
						}
						else {
							unblock_page('error', "Somthing Wrong.")
						}
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
			'All': ['01-01-1970', $('#e_date').val()],
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

		$("#advance_payment_form").validate({
			rules: {
				payment_date: {
					required: true
				}
			},
			messages: {
				payment_date: {
					required: "Select Date"
				}
			}
		});
	});

	$("#advance_payment_form").submit(function (event) {
		event.preventDefault();
		if (!$("#advance_payment_form").valid()) {
			return false;
		}
		block_page();
		var postData = new FormData(this);

		$.ajax({
			type: "post",
			url: root + 'confirm_pi/advance_payment',
			data: postData,
			processData: false,
			contentType: false,
			cache: false,
			success: function (responseData) {
				console.log(responseData);
				var obj = JSON.parse(responseData);
				$(".loader").hide();
				if (obj.res == 1) {

					unblock_page("success", "Sucessfully Inserted.");
					setTimeout(function () { location.reload(); }, 100);
				}

				else {
					unblock_page("error", "Something Wrong.")

				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	});

	function filterbystatus() {
		load_data_table()
	}
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
				{ "bSortable": false },
				{ "bSortable": false },
				{ "bSortable": false },
				{ "bSortable": false },
				{ "bSortable": false }
			],
			"bProcessing": true,
			"searchDelay": 350,
			"bServerSide": true,
			"bDestroy": true,
			"oLanguage": {
				"sLengthMenu": "_MENU_",
				"sProcessing": "<img src='" + root + "adminast/assets/images/loader.gif'/> Loading ...",
				"sEmptyTable": "NO DATA ADDED YET !",
				"sSearch": "",
				"sInfoFiltered": "",
				"sInfo": "",
			},
			"aLengthMenu": [[-1, 10, 20, 30, 50], ["All", 10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root + 'confirm_pi/fetch_record/',
			"fnServerParams": function (aoData) {
				aoData.push(
					{ "name": "mode", "value": "fetch" },
					{ "name": "cust_id", "value": $("#cust_id").val() },
					{ "name": "date", "value": $("#daterange").val() },
					        { "name": "days_filter", "value": $("#days_filter").val() } // ADD THIS LINE

				);
			},
			"fnDrawCallback": function (oSettings) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});

		$('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
		$('.dataTables_length select').addClass('form-control');
	}

	function downloadPDF() {
		$.ajax({
			url: root + 'confirm_pi/fetch_record/',
			type: 'GET',
			data: {
				mode: 'fetch',
				cust_id: $("#cust_id").val(),
				date: $("#daterange").val(),
				length: -1 // Get all records
			},
			dataType: 'json',
			success: function (response) {
				var pdfData = [];

				// Prepare header
				pdfData.push([
					{ text: 'Sr no', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Proforma Invoice no', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Consignee Name', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Grand total', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Date', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'No of Ordered Container', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Product Detail', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Producation Sheet Done Container', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Pending For Producation Sheet', fillColor: '#0C6291', color: 'white', bold: true },
					{ text: 'Days after confirm', fillColor: '#0C6291', color: 'white', bold: true }
				]);

				response.aaData.forEach(function (row, index) {
					var temp = document.createElement('div');
					temp.innerHTML = row[1];

					var invoiceNo = temp.querySelector('.dropdown-toggle') ?
						temp.querySelector('.dropdown-toggle').textContent.trim() :
						'N/A';

					var daysAfterConfirmElement = document.createElement('div');
					daysAfterConfirmElement.innerHTML = row[9];
					var daysAfterConfirmText = daysAfterConfirmElement.textContent.trim();

					var productionSheetDone = row[7].replace(/<i class="fa fa-check"><\/i>/gi, 'Done');

					pdfData.push([
						index + 1, // Sr no
						invoiceNo, // Proforma Invoice no (extracted from HTML)
						row[2], // Consignee Name
						row[3], // Grand total
						row[4], // Date
						row[5], // No of Ordered Container
						row[6], // No of Ordered Container
						row[7], // Producation Sheet Done Container
						productionSheetDone, // Pending For Producation Sheet (with 'Done' text)
						daysAfterConfirmText // Days after confirm (extracted from HTML)
					]);
				});

				var docDefinition = {
					pageOrientation: 'landscape',
					content: [
						{ text: 'Confirm Proforma Invoice', style: 'header' },
						{
							table: {
								headerRows: 1,
								body: pdfData
							},
							layout: {
								hLineWidth: function (i, node) { return 1; },
								vLineWidth: function (i, node) { return 1; },
								hLineColor: function (i, node) { return '#E0E0E0'; },
								vLineColor: function (i, node) { return '#E0E0E0'; },
								paddingLeft: function (i, node) { return 4; },
								paddingLeft: function (i, node) { return 4; },
								paddingRight: function (i, node) { return 4; },
								paddingTop: function (i, node) { return 2; },
								paddingBottom: function (i, node) { return 6; },
								fillColor: function (i, node) { return (i === 0) ? '#F0F0F0' : null; }
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

				// Calculate column widths
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

				// Normalize widths and increase the width of the Grand total column
				var totalWidth = widths.reduce((sum, width) => sum + width, 0);
				docDefinition.content[1].table.widths = widths.map((w, i) => {
					if (i === 3) {
						return ((w + totalWidth * 0.05) / totalWidth) * 100 + '%';
					}
					return (w / totalWidth) * 100 + '%';
				});

				// Ensure all cells are objects and set background color for header row
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

				pdfMake.createPdf(docDefinition).download('Confirm PI.pdf');
			},
			error: function (xhr, status, error) {
				console.error("Error fetching data for PDF:", error);
			}
		});
	}


	$('#downloadPDFButton').on('click', function () {
		downloadPDF();
	});

	$(document).ready(function () {
		load_data_table();
	});




	function delete_record(product_size_id) {
		main_delete(product_size_id, 'invoice_listing/deleterecord', 'invoice_listing')
	}
	function open_page(value) {
		if (value == 1) {
			window.location = root + "invoice/form_edit/" + $("#invoice_id").val();
		}
		else if (value == 2) {
			window.location = root + "product/index/" + $("#invoice_id").val();
		}
		else if (value == 4) {
			window.location = root + "addition_details/index/" + $("#invoice_id").val();
		}
	}
	function view_detail(id) {
		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$("#invoice_id").val(id)

	}
	function loaded_size(performa_invoice_id, html, url) {
		block_page();
		$.ajax({
			type: "POST",
			url: root + url,
			data: {
				"performa_invoice_id": performa_invoice_id,
				"size_id": $("#size_id").val(),
				"finish_id": $("#finish_id").val(),
				"design_id": $("#design_id").val()
			},
			cache: false,
			success: function (data) {
				$(".set_title").html(html);
				$("#size_id").attr("onchange", "loaded_size(" + performa_invoice_id + ",'" + html + "','" + url + "')");
				$("#finish_id").attr("onchange", "loaded_size(" + performa_invoice_id + ",'" + html + "','" + url + "')");
				$("#design_id").attr("onchange", "loaded_size(" + performa_invoice_id + ",'" + html + "','" + url + "')");

				$(".productdetailhtml1").html(data);
				$("#myModal1").modal('show')
				unblock_page("", "");
			}
		});
	}
</script>