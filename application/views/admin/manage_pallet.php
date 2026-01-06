<?php $this->view('lib/header'); ?>
<style>
    th, td { border: 0.5px solid #333; padding: 5px; text-align: center; vertical-align: middle; }
    .form-control-sm { min-width: 70px !important; max-width: 70px; flex: 0 0 auto; text-align: center; }
    .pallet-entry-group { display: flex; align-items: center; gap: 6px; margin-bottom: 8px; justify-content: center; }
    .entry-total { min-width: 50px; display: inline-block; font-weight: bold; color: #28a745; }
    .entry-wrapper { display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .subtotal-section { margin-top: 10px; padding: 8px 12px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.9em; min-width: 200px; }
    .subtotal-row { display: flex; justify-content: space-between; margin-bottom: 3px; }
    .subtotal-label { font-weight: bold; color: #495057; }
    .subtotal-value { font-weight: bold; color: #007bff; }
    .subtotal-value.negative { color: #dc3545; }
    .subtotal-value.positive { color: #28a745; }
    .subtotal-value.critical { color: #721c24; background-color: #f8d7da; padding: 2px 6px; border-radius: 3px; border: 1px solid #f5c6cb; }
    .btn-sm { padding: 0.5rem 0.75rem; font-size: 1rem; min-width: 40px; font-weight: bold; }
    .grand-total-section { background-color: #e9ecef; padding: 15px; border-radius: 5px; border: 2px solid #007bff; }
    .grand-total-section .total-item { font-size: 1.1em; font-weight: bold; color: #007bff; }
</style>

<div class="main-container">
    <?php $this->view('lib/sidebar'); ?>
    <div class="main-content">
        <div class="container">
            <h4 class="mb-4">Manage Pallet</h4>

            <form id="palletForm">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Sr No</th>
                            <th>Design</th>
                            <th>Size</th>
                            <th>Finish</th>
                           
                            <th>Production Box</th>
                           
                            <th>Box Per Pallet</th>
							 <th>Pallets</th>
                            <th style="width:300px;">Pallet Entry</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pallets)): ?>
                            <?php $i = 1; foreach ($pallets as $pallet): ?>
                                <?php
                                    $rows = [[
                                        'batch' => $pallet->batchnproduction,
                                        'available_box' => $pallet->extra_total_box1 ?? $pallet->extra_total_box2 ?? $pallet->available_box
                                    ]];
                                    if (!empty($pallet->extra_batch1)) {
                                        $rows[] = ['batch' => $pallet->extra_batch1 . ' ' . $pallet->extra_shade1, 'available_box' => $pallet->extra_total_box1 ?? $pallet->extra_box1];
                                    }
                                    if (!empty($pallet->extra_batch2)) {
                                        $rows[] = ['batch' => $pallet->extra_batch2 . ' ' . $pallet->extra_shade2, 'available_box' => $pallet->extra_total_box2 ?? $pallet->extra_box2];
                                    }
                                ?>
                                <?php foreach ($rows as $rIndex => $row): ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $pallet->design_name ?></td>
                                        <td><?= $pallet->product_name ?></td>
                                        <td><?= $pallet->finish_name ?></td>
                                       <!-- <td><?= $row['batch'] ?></td>-->
                                        <td><?= $row['available_box'] ?></td>

                                        <!-- Pallet Info -->
                                   
                                        <!-- Box Per Pallet -->
                                        <td>
                                            <?php if ($pallet->box_per_big_pallet > 0 && $pallet->box_per_small_pallet > 0): ?>
                                                Big: <?= $pallet->box_per_big_pallet ?><br>
                                                Small: <?= $pallet->box_per_small_pallet ?>
                                            <?php else: ?>
                                                Pallet: <?= $pallet->boxes_per_pallet ?>
                                            <?php endif; ?>
                                        </td>
										
										     <td>
                                            <?php if ($pallet->no_of_big_pallet > 0 && $pallet->no_of_small_pallet > 0): ?>
                                                Big: <?= $pallet->no_of_big_pallet ?><br>
                                                Small: <?= $pallet->no_of_small_pallet ?><br><br>
                                                Total: <?= ($pallet->no_of_big_pallet + $pallet->no_of_small_pallet) ?>
                                            <?php else: ?>
                                                Pallet: <?= $pallet->no_of_pallet ?><br><br>
                                                Total: <?= $pallet->no_of_pallet ?>
                                            <?php endif; ?>
                                        </td>



                                        <!-- Pallet Entry -->
                                        <td>
                                            <div class="entry-wrapper" data-row="<?= $i ?>">
                                                <div class="entries-container">
                                                    <?php if ($pallet->no_of_big_pallet > 0 && $pallet->no_of_small_pallet > 0): ?>
                                                        <!-- Big Pallet -->
                                                        <div class="pallet-entry-group">
                                                            <input type="number" class="form-control form-control-sm" name="input_boxes[<?= $i ?>][]" value="<?= $pallet->box_per_big_pallet ?>" min="0">
                                                            <span>×</span>
                                                            <input type="number" class="form-control form-control-sm" name="input_big_pallets[<?= $i ?>][]" value="<?= $pallet->no_of_big_pallet ?>" min="0">
                                                            <span>+</span>
                                                            <input type="number" class="form-control form-control-sm" name="input_small_pallets[<?= $i ?>][]" value="0" min="0">
                                                            <span class="entry-total">= 0</span>
															 <input type="text" class="form-control form-control-sm" name="batchno[<?= $i ?>][]" value="<?= $pallet->batchno ?>"  placeholder = "Batch No" min="0">
															 <input type="text" class="form-control form-control-sm" name="shadeno[<?= $i ?>][]" value="<?= $pallet->shadeno ?>" placeholder = "Shade No" min="0">
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="addEntry(<?= $i ?>)">+</button>
                                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteEntry(this,0)">×</button>
                                                            <?= hidden_inputs($i, $pallet, $row, $pallet->box_per_big_pallet) ?>
                                                        </div>
                                                        <!-- Small Pallet -->
                                                        <div class="pallet-entry-group">
                                                            <input type="number" class="form-control form-control-sm" name="input_boxes[<?= $i ?>][]" value="<?= $pallet->box_per_small_pallet ?>" min="0">
                                                            <span>×</span>
                                                            <input type="number" class="form-control form-control-sm" name="input_big_pallets[<?= $i ?>][]" value="0" min="0">
                                                            <span>+</span>
                                                            <input type="number" class="form-control form-control-sm" name="input_small_pallets[<?= $i ?>][]" value="<?= $pallet->no_of_small_pallet ?>" min="0">
                                                            <span class="entry-total">= 0</span>
															 <input type="text" class="form-control form-control-sm" name="batchno[<?= $i ?>][]" value="<?= $pallet->batchno ?>"  placeholder = "Batch No" min="0">
															 <input type="text" class="form-control form-control-sm" name="shadeno[<?= $i ?>][]" value="<?= $pallet->shadeno ?>" placeholder = "Shade No" min="0">
                                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteEntry(this,0)">×</button>
                                                            <?= hidden_inputs($i, $pallet, $row, $pallet->box_per_small_pallet) ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <!-- Normal Pallet -->
                                                        <div class="pallet-entry-group">
                                                            <input type="number" class="form-control form-control-sm" name="input_boxes[<?= $i ?>][]" value="<?= $pallet->boxes_per_pallet ?>" min="0">
                                                            <span>×</span>
                                                            <input type="number" class="form-control form-control-sm" name="input_pallets[<?= $i ?>][]" value="<?= $pallet->no_of_pallet ?>" min="0">
                                                            <span class="entry-total">= 0</span>
															 <input type="text" class="form-control form-control-sm" name="batchno[<?= $i ?>][]" value="<?= $pallet->batchno ?>"  placeholder = "Batch No" min="0">
															 <input type="text" class="form-control form-control-sm" name="shadeno[<?= $i ?>][]" value="<?= $pallet->shadeno ?>" placeholder = "Shade No" min="0">
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="addEntry(<?= $i ?>)">+</button>
                                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteEntry(this,0)">×</button>
                                                            <?= hidden_inputs($i, $pallet, $row, $pallet->boxes_per_pallet) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <!-- Subtotals -->
                                                <div class="subtotal-section mt-2">
                                                    <div class="subtotal-row"><span class="subtotal-label">Total Boxes:</span><span class="subtotal-value row-subtotal" data-row="<?= $i ?>">0</span></div>
                                                    <div class="subtotal-row"><span class="subtotal-label">Total Pallets:</span><span class="subtotal-value row-pallet-total" data-row="<?= $i ?>">0</span></div>
                                                    <div class="subtotal-row"><span class="subtotal-label">Pending Boxes:</span><span class="subtotal-value row-pending-boxes" data-row="<?= $i ?>" data-available="<?= $row['available_box'] ?>">0</span></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center">No pallet data found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Grand Totals -->
                <div class="mt-4 d-flex justify-content-end">
                    <div class="grand-total-section">
                        <div class="total-item mb-2">Grand Boxes/Pallet: <span id="grand-total-boxes">0</span></div>
    <div class="total-item mb-2">Grand Total Pallets: <span id="grand-total-pallets">0</span></div>
    <div class="total-item">Grand Total of All Boxes: <span id="grand-total-final">0</span></div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="button" class="btn btn-success btn-lg px-4 py-2" onclick="submitAllPallets()">Save All</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->view('lib/footer'); ?>
<script>
$(document).ready(function () {
    // Hide delete button in first pallet-entry-group of each row
    $(".entries-container").each(function() {
        $(this).find(".pallet-entry-group:first .btn-danger").hide();
    });

    attachListeners();
    updateRowTotals();
});


function addEntry(row) {
    let container = document.querySelector(`.entry-wrapper[data-row="${row}"] .entries-container`);
    if (container) {
        // Limit to max 3 entries
        let currentEntries = container.querySelectorAll('.pallet-entry-group').length;
        if (currentEntries >= 3) {
            alert("You can only add up to 3 pallet entries per design.");
            return;
        }

        // Clone first entry
        let template = container.children[0].cloneNode(true);

        // Reset input values and add placeholders
        template.querySelectorAll("input[type='number'], input[type='text']").forEach(el => {
            el.value = '';
            el.disabled = false;

            // Add context-based placeholders
            if (el.name.includes('input_boxes')) el.placeholder = 'Box/Pallet';
            if (el.name.includes('input_pallets')) el.placeholder = 'Pallet';
            if (el.name.includes('input_big_pallets')) el.placeholder = 'Big Pallet ';
            if (el.name.includes('input_small_pallets')) el.placeholder = 'Small Pallet ';
            if (el.name.includes('batchno')) el.placeholder = 'Batch No';
            if (el.name.includes('shadeno')) el.placeholder = 'Shade No';
        });

        // Reset total display
        template.querySelector('.entry-total').textContent = "= 0";

        // Remove "+" button for cloned entries
        let addButton = template.querySelector('.btn-primary');
        if (addButton) addButton.remove();

        // Show delete button for new entry
        let delButton = template.querySelector('.btn-danger');
        if (delButton) delButton.style.display = "inline-block";

        // Append cloned entry
        container.appendChild(template);

        attachListeners(template);
        updateRowTotals();
    }
}



function attachListeners(scope = document) {
    $(scope).find("input[type='number']").off("input").on("input", function () {
        updateRowTotals();
    });
}

function updateTotals(design_id, boxes, pallets, pending) {
    // Update display
    document.getElementById("total_boxes_display_" + design_id).innerText = boxes;
    document.getElementById("total_pallets_display_" + design_id).innerText = pallets;
    document.getElementById("pending_boxes_display_" + design_id).innerText = pending;

    // Update form inputs (for DB save)
    document.getElementById("total_boxes_input_" + design_id).value = boxes;
    document.getElementById("total_pallets_input_" + design_id).value = pallets;
    document.getElementById("pending_boxes_input_" + design_id).value = pending;
}


function updateRowTotals() {
    const rowSubtotals = {};
    const rowBoxTotals = {};
    const rowPalletTotals = {};
    let grandTotalBoxes = 0;
    let grandTotalPallets = 0;
	let grandTotalFinal = 0;

    document.querySelectorAll(".pallet-entry-group").forEach(group => {
        const wrapper = group.closest(".entry-wrapper");
        const rowId = wrapper?.getAttribute("data-row");

        const boxInput = group.querySelector("input[name^='input_boxes']");
        const palletInput = group.querySelector("input[name^='input_pallets']");
        const bigpalletInput = group.querySelector("input[name^='input_big_pallets']");
        const smallpalletInput = group.querySelector("input[name^='input_small_pallets']");
		
        const boxes = parseInt(boxInput?.value) || 0;
        const pallets = parseInt(palletInput?.value) || 0;
        const bigpallets = parseInt(bigpalletInput?.value) || 0;
        const smallpallets = parseInt(smallpalletInput?.value) || 0;
        const total = (boxes * (pallets + bigpallets +smallpallets));

        group.querySelector(".entry-total").textContent = "= " + total;

        rowSubtotals[rowId] = (rowSubtotals[rowId] || 0) + total;
        rowBoxTotals[rowId] = (rowBoxTotals[rowId] || 0) + boxes;
        rowPalletTotals[rowId] = (rowPalletTotals[rowId] || 0) + (pallets + bigpallets +smallpallets);
       

        grandTotalBoxes += boxes;
        grandTotalPallets += (pallets + bigpallets + smallpallets);
		 grandTotalFinal += total; // ✅ new line
    });

    Object.entries(rowSubtotals).forEach(([rowId, subtotal]) => {
        const el = document.querySelector(`.row-subtotal[data-row="${rowId}"]`);
        if (el) el.textContent = subtotal;
    });
    Object.entries(rowBoxTotals).forEach(([rowId, total]) => {
        const el = document.querySelector(`.row-box-total[data-row="${rowId}"]`);
        if (el) el.textContent = total;
    });
    Object.entries(rowPalletTotals).forEach(([rowId, total]) => {
        const el = document.querySelector(`.row-pallet-total[data-row="${rowId}"]`);
        if (el) el.textContent = total;
    }); 
	// Object.entries(rowBigPalletTotals).forEach(([rowId, total]) => {
        // const el = document.querySelector(`.row-pallet-total[data-row="${rowId}"]`);
        // if (el) el.textContent = total;
    // }); 
	// Object.entries(rowSmallPalletTotals).forEach(([rowId, total]) => {
        // const el = document.querySelector(`.row-pallet-total[data-row="${rowId}"]`);
        // if (el) el.textContent = total;
    // });

    Object.entries(rowSubtotals).forEach(([rowId, subtotal]) => {
        const pendingEl = document.querySelector(`.row-pending-boxes[data-row="${rowId}"]`);
        if (pendingEl) {
            const availableBoxes = parseInt(pendingEl.getAttribute('data-available')) || 0;
            const pendingBoxes = availableBoxes - subtotal;
            pendingEl.textContent = pendingBoxes;
            pendingEl.classList.remove('negative', 'positive', 'warning', 'critical');
            
            if (pendingBoxes < 0) {
                pendingEl.classList.add('negative');
            } else if (pendingBoxes > 10) {
                pendingEl.classList.add('critical');
            } else if (pendingBoxes > 0 && pendingBoxes <= 10) {
                pendingEl.classList.add('positive');
            }
        }
    });

    document.getElementById("grand-total-boxes").textContent = grandTotalBoxes;
    document.getElementById("grand-total-pallets").textContent = grandTotalPallets;
	document.getElementById("grand-total-final").textContent = grandTotalFinal; // ✅ new total line
}

// function submitAllPallets() {
    // let formData = $('#palletForm').serialize();
    // formData += '&production_mst_id=<?= $production_id ?>';
    
    // $.post("<?= base_url('manage_pallet/insert_pallet_entries') ?>", formData, function(res) {
        // alert("Pallet entries saved successfully!");
        
        // // ✅ Disable only the textboxes, keep + and × buttons active
        // $('#palletForm input[type="number"]').prop('disabled', true);
        
        // // Save button optional (you can disable or keep it active)
        // // $('.btn-success').prop('disabled', true).text("Saved");
        
    // }).fail(function() {
        // alert("Error saving pallet entries.");
    // });
// }

function submitAllPallets() {
    let formData = $('#palletForm').serialize();
    formData += '&production_mst_id=<?= $production_id ?>';
    
    $.post("<?= base_url('manage_pallet/insert_pallet_entries') ?>", formData, function(res) {
        if(res.status === 'success') {
            alert("Pallet entries saved successfully!");

            // Disable all number and text inputs
            $('#palletForm input[type="number"], #palletForm input[type="text"]').prop('disabled', true);

            // Disable Save button
            $('.btn-success').prop('disabled', true).text("Saved");

            // ✅ Redirect to pallet_order/index1 with production_mst_id
           window.location.href = "<?= base_url('pallent_order/index1/'.$production_id) ?>";

        } else {
            alert("Error saving pallet entries: " + (res.message || 'Unknown error'));
        }
    }, 'json').fail(function() {
        alert("Error saving pallet entries.");
    });
}



function deleteEntry(button, entryId) {
    const group = button.closest('.pallet-entry-group');
    if (entryId > 0) {
        if (!confirm("Are you sure you want to delete this entry?")) return;
        $.post("<?= base_url('manage_pallet/delete_pallet_entry') ?>", { id: entryId }, function(res) {
            if (res.status === 'success') {
                group.remove();
                updateRowTotals();
            } else {
                alert("Failed to delete entry.");
            }
        }, 'json');
    } else {
        group.remove();
        updateRowTotals();
    }
}

$(document).ready(function () {
    attachListeners();
    updateRowTotals();
});
</script>

<?php
// helper to avoid repeating hidden inputs
function hidden_inputs($i, $pallet, $row, $box_per_pallet) {
    return '
        <input type="hidden" name="design_id['.$i.'][]" value="'.$pallet->design_id.'">
        <input type="hidden" name="finish_id['.$i.'][]" value="'.$pallet->finish_id.'">
        <input type="hidden" name="design_name['.$i.'][]" value="'.$pallet->design_name.'">
        <input type="hidden" name="size_name['.$i.'][]" value="'.$pallet->product_name.'">
        <input type="hidden" name="finish_name['.$i.'][]" value="'.$pallet->finish_name.'">
        <input type="hidden" name="available_pallets['.$i.'][]" value="'.$pallet->no_of_pallet.'">
        <input type="hidden" name="available_big_pallets['.$i.'][]" value="'.$pallet->no_of_big_pallet.'">
        <input type="hidden" name="available_small_pallets['.$i.'][]" value="'.$pallet->no_of_small_pallet.'">
        <input type="hidden" name="available_box['.$i.'][]" value="'.$row['available_box'].'">
        <input type="hidden" name="production_trn_id['.$i.'][]" value="'.$pallet->production_trn_id.'">
        <input type="hidden" name="performa_invoice_id['.$i.'][]" value="'.$pallet->performa_invoice_id.'">
        <input type="hidden" name="create_production_id['.$i.'][]" value="'.$pallet->create_production_id.'">
        <input type="hidden" name="box_per_pallet['.$i.'][]" value="'.$box_per_pallet.'">
        <input type="hidden" name="pallet_id['.$i.'][]" value="'.$i.'">
    ';
}
?>