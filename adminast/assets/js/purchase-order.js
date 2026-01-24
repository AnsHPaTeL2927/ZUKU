/* ===============================
   PURCHASE ORDER – jQuery 2.0.3 SAFE
   =============================== */

$(document).ready(function () {

	/* ADD NEW PRODUCT ROW */
	$(document).on('click', '.add-row', function () {
		var $currentRow = $(this).closest('tr');
		
		// Change Add button to Remove button in current row
		$currentRow.find('.add-row').replaceWith(
			'<button type="button" class="btn btn-danger btn-sm remove-row">' +
			'<i class="fa fa-trash"></i> Remove' +
			'</button>'
		);
		$currentRow.addClass('product-row');

		// Add new row
		var row = '<tr class="product-row">' +
			'<td>' +
			'<select name="design[]" class="form-control">' +
			'<option value="">Select Design</option>' +
			'<option>SWIZER WHITE</option>' +
			'<option>OPULENCE</option>' +
			'<option>MARBLE EFFECT</option>' +
			'</select>' +
			'</td>' +
			'<td>' +
			'<select name="finish[]" class="form-control">' +
			'<option>MATT</option>' +
			'<option selected>GLOSSY</option>' +
			'<option>HIGH GLOSS</option>' +
			'</select>' +
			'</td>' +
			'<td>' +
			'<input type="text" name="client_design[]" class="form-control" placeholder="Client Design Name">' +
			'</td>' +
			'<td>' +
			'<input type="number" name="pallet_qty[]" value="0" class="form-control pallet-qty-input" min="0">' +
			'</td>' +
			'<td>' +
			'<select name="pallet_type[]" class="form-control">' +
			'<option>EURO PINEWOOD</option>' +
			'<option selected>PLASTIC</option>' +
			'<option>METAL</option>' +
			'</select>' +
			'</td>' +
			'<td>' +
			'<input type="number" name="boxes[]" value="0" class="form-control boxes-input" min="0">' +
			'</td>' +
			'<td>' +
			'<select name="box_design[]" class="form-control">' +
			'<option selected>ITACA BRAI</option>' +
			'<option>ITACA BRAND</option>' +
			'<option>CUSTOM</option>' +
			'</select>' +
			'</td>' +
			'<td>' +
			'<input type="number" name="sqm[]" value="0.00" step="0.01" class="form-control sqm-input" min="0">' +
			'</td>' +
			'<td>' +
			'<button type="button" class="btn btn-success btn-sm add-row">' +
			'<i class="fa fa-plus"></i> Add' +
			'</button>' +
			'</td>' +
			'</tr>';

		$('#product-tbody').append(row);
		
		// Trigger calculation after adding row
		if (typeof calculateWeights === 'function') {
			calculateWeights();
		}
	});

	/* REMOVE PRODUCT ROW */
	$(document).on('click', '.remove-row', function () {
		var $row = $(this).closest('tr');
		var rowCount = $('#product-tbody tr').length;
		
		// Prevent removing if only one row remains
		if (rowCount <= 1) {
			alert('At least one product row is required.');
			return false;
		}
		
		$row.remove();
		
		// Trigger calculation after removing row
		if (typeof calculateWeights === 'function') {
			calculateWeights();
		}
	});

	/* BASIC FORM VALIDATION */
	$('#po-form').on('submit', function (e) {
		var isValid = true;
		var errorMsg = '';

		// Validate PO Number
		if ($('#po-number').val().trim() === '') {
			errorMsg += 'PO Number is required.\n';
			isValid = false;
		}

		// Validate Date
		if ($('#po-date').val().trim() === '') {
			errorMsg += 'Date is required.\n';
			isValid = false;
		}

		// Validate at least one product row has data
		var hasProductData = false;
		$('#product-tbody tr').each(function() {
			var design = $(this).find('select[name="design[]"]').val();
			var boxes = parseFloat($(this).find('input[name="boxes[]"]').val()) || 0;
			if (design && design !== '' && boxes > 0) {
				hasProductData = true;
				return false; // break loop
			}
		});

		if (!hasProductData) {
			errorMsg += 'Please add at least one product with valid data.\n';
			isValid = false;
		}

		if (!isValid) {
			e.preventDefault();
			alert(errorMsg);
			return false;
		}

		return true;
	});

});
