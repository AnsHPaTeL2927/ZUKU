<style>
.extra-row {
    background-color: #fdf7e3;
}
</style>

<table class="table table-bordered">
    <thead>
        <tr>
            <th style="text-align:center;font-weight:bold;">Sr No</th>
            <th style="text-align:center;font-weight:bold;">Size</th>
            <th style="text-align:center;font-weight:bold;">Design</th>
            <th style="text-align:center;font-weight:bold;">Finish</th>
            <th style="text-align:center;font-weight:bold;">Box/Pallets</th>
            <th style="text-align:center;font-weight:bold;">Pallets</th>
            <th style="text-align:center;font-weight:bold;">Box</th>
            <th style="text-align:center;font-weight:bold;">SQM</th>
            <th style="text-align:center;font-weight:bold;">Batch No</th>
            <th style="text-align:center;font-weight:bold;">Location</th>
            <th colspan="2" style="text-align:center;font-weight:bold;">Production Status</th>
            <th style="text-align:center;font-weight:bold;">Extra</th>
        </tr>
    </thead>

    <tbody>
<?php 
$i = 1; 
foreach ($rows as $r) { 
    $disabled = ($r->production_done == 2) ? "disabled" : ""; 
    $isExtra  = !empty($r->parent_trn_id);   // ⭐ key line
?>
        <tr class="<?= $isExtra ? 'extra-row' : '' ?>">
            <td><?= $i++; ?></td>
            <td><?= $r->size_type_mm ?></td>
            <td><?= $r->model_name ?></td>
            <td><?= $r->finish_name ?></td>
			
			<td>
				<?php if ($r->no_of_pallet > 0) { 
					$boxes_val = (!empty($r->trnboxes_per_pallet) && $r->trnboxes_per_pallet != 0) 
									? $r->trnboxes_per_pallet 
									: $r->boxes_per_pallet;
				?>
					<input type="text"
						   class="form-control input-sm box-per-pallet"
						   id="boxes_per_pallet_<?= $r->production_trn_id ?>"
						   value="<?= $boxes_val ?>"
						   onkeyup="auto_calculate(<?= $r->production_trn_id ?>)">
				<?php } else { 
					$big_val = ($r->trnbox_per_big_pallet !== null)
    ? $r->trnbox_per_big_pallet
    : $r->box_per_big_pallet;

$small_val = ($r->trnbox_per_small_pallet !== null)
    ? $r->trnbox_per_small_pallet
    : $r->box_per_small_pallet;

				?>
					<input type="text"
						   class="form-control input-sm mb-1 box-per-pallet"
						   id="box_per_big_pallet<?= $r->production_trn_id ?>"
						   value="<?= $big_val ?>"
						   onkeyup="auto_calculate(<?= $r->production_trn_id ?>)">

					<input type="text"
						   class="form-control input-sm box-per-pallet"
						   id="box_per_small_pallet<?= $r->production_trn_id ?>"
						   value="<?= $small_val ?>"
						   onkeyup="auto_calculate(<?= $r->production_trn_id ?>)">
				<?php } ?>
			</td>



            <!--<td style="text-align:center;font-weight:bold;">
                <?php if ($r->no_of_pallet > 0) { ?>
                    <?= $r->boxes_per_pallet ?>
                <?php } else { ?>
                    <?= $r->box_per_big_pallet ?><br>
                    <?= $r->box_per_small_pallet ?>
                <?php } ?>
            </td>

            
            <input type="hidden" id="boxes_per_pallet_<?= $r->production_trn_id ?>" value="<?= $r->boxes_per_pallet ?>">
            <input type="hidden" id="box_per_big_pallet<?= $r->production_trn_id ?>" value="<?= $r->box_per_big_pallet ?>">
            <input type="hidden" id="box_per_small_pallet<?= $r->production_trn_id ?>" value="<?= $r->box_per_small_pallet ?>">-->
            <input type="hidden" id="sqm_per_box_<?= $r->production_trn_id ?>" value="<?= $r->sqm_per_box ?>">

            <!-- Pallet -->
            <td>
                <?php if ($r->no_of_pallet > 0) { ?>
                   <input type="text"
       class="form-control input-sm pallet-input"
       name="pallet[<?= $r->production_trn_id ?>]"
       id="pallet_<?= $r->production_trn_id ?>"
       value="<?= $r->no_of_pallet ?>"
       onkeyup="auto_calculate(<?= $r->production_trn_id ?>)">


                <?php } else { ?>
                   <input type="text"
       class="form-control input-sm pallet-input mb-1"
       name="big_pallet[<?= $r->production_trn_id ?>]"
       id="big_<?= $r->production_trn_id ?>"
       value="<?= $r->no_of_big_pallet ?>"
       onkeyup="auto_calculate(<?= $r->production_trn_id ?>)">

<input type="text"
       class="form-control input-sm pallet-input"
       name="small_pallet[<?= $r->production_trn_id ?>]"
       id="small_<?= $r->production_trn_id ?>"
       value="<?= $r->no_of_small_pallet ?>"
       onkeyup="auto_calculate(<?= $r->production_trn_id ?>)">


                <?php } ?>
            </td>

            <!-- Box -->
            <td>
              <input type="text"
       class="form-control input-sm box-input"
       name="box[<?= $r->production_trn_id ?>]"
       id="box_<?= $r->production_trn_id ?>"
       value="<?= $r->no_of_boxes ?>"
       <?= $disabled ?>>


            </td>

            <!-- SQM -->
            <td>
                <input type="text"
       class="form-control input-sm sqm-input"
       name="sqm[<?= $r->production_trn_id ?>]"
       id="sqm_<?= $r->production_trn_id ?>"
       value="<?= $r->no_of_sqm ?>"
       readonly>

            </td>

            <td>
                <input type="text" class="form-control input-sm"
                       name="pro_batch[<?= $r->production_trn_id ?>]"
                       value="<?= $r->pro_batch ?>"
                       <?= $disabled ?>>
            </td>

            <td>
                <input type="text" class="form-control input-sm"
                       name="pro_shade[<?= $r->production_trn_id ?>]"
                       value="<?= $r->pro_shade ?>"
                       <?= $disabled ?>>
            </td>

            <!-- Status -->
            <td>
                <button class="btn btn-info btn-sm"
                        onclick="update_all_fields(<?= $r->production_trn_id ?>)">
                    Update
                </button>
            </td>

           <td id="status_btn_<?= $r->production_trn_id ?>">
    <?php if($r->production_done == 2){ ?>
        <span class="label label-success">Done</span>
    <?php } else { ?>
        <button class="btn btn-warning btn-sm"
            onclick="mark_trn_production_done(<?= $r->production_trn_id ?>)">
            Production Pending
        </button>
    <?php } ?>
</td>

           <td class="text-center">
			<?php if ($r->production_done != 2) { ?>
				<button class="btn btn-success btn-sm add-extra"
						data-parent-id="<?= $r->production_trn_id ?>"
						data-pallet-type="<?= ($r->no_of_pallet > 0 ? 'normal' : 'bigsmall') ?>">
					+
				</button>

				<button class="btn btn-danger btn-sm remove-row"
						data-id="<?= $r->production_trn_id ?>">
					-
				</button>
			<?php } ?>
			</td>

        </tr>
<?php } ?>
    </tbody>

    <tfoot>
        <tr style="font-size:16px;font-weight:bold;background:#f5f5f5;">
            <td colspan="5" style="text-align:right;">Total :</td>
            <td><span id="total_pallets">0</span></td>
            <td><span id="total_boxes">0</span></td>
            <td><span id="total_sqm">0.00</span></td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
</table>



<script>
$(document).on(
    'keyup change',
    '.pallet-input, .box-input',
    function () {
        calculate_totals();
    }
);


function renumberRows() {
    let i = 1;
    $('tbody tr').each(function () {
        let cell = $(this).find('td:first');
        if (!cell.text().includes('*')) {
            cell.text(i++);
        }
    });
}

$(document)
.off('click.addExtra')   // 💥 remove duplicate bindings
.on('click.addExtra', '.add-extra', function (e) {

    e.preventDefault();
    e.stopImmediatePropagation(); // 🚫 stop double firing

    let btn = $(this);

    // 🔒 prevent fast double click
    if (btn.data('busy')) return;
    btn.data('busy', true);

    let parentRow  = btn.closest('tr');
    let parentId   = btn.data('parent-id');
    let palletType = btn.data('pallet-type');

    $.post(
        '<?= base_url("producation_detail/insert_extra") ?>',
        { parent_id: parentId },
        function (res) {

            if (res.status !== 'success') return;

            let newRow = buildRowFromParent(
                parentRow,
                res.new_id,
                palletType,
                parentId
            );

            // insert after last extra under same parent
            let lastExtra = $('tr.extra-row[data-parent="' + parentId + '"]:last');

            if (lastExtra.length) {
                lastExtra.after(newRow);
            } else {
                parentRow.after(newRow);
            }

            calculate_totals();
        },
        'json'
    ).always(function () {
        // 🔓 unlock button
        btn.data('busy', false);
    });
});


$(document)
.off('click.removeRow')   // 💥 remove any previous bindings
.on('click.removeRow', '.remove-row', function (e) {

    e.preventDefault();
    e.stopImmediatePropagation(); // 🚫 stop multiple triggers

    let btn = $(this);
    let row = btn.closest('tr');
    let id  = btn.data('id'); // production_trn_id

    if (!id) {
        row.remove();
        calculate_totals();
        return;
    }

    if (!confirm('Remove this pallet entry?')) return;

    // 🔒 disable button immediately (prevents double click)
    btn.prop('disabled', true);

    $.post(
        '<?= base_url("producation_detail/delete_row") ?>',
        { id: id },
        function () {

            // remove row
            row.remove();

            // remove child rows if parent
            $('tr.extra-row[data-parent="' + id + '"]').remove();

            calculate_totals();
        }
    );
});



/* =========================
   AUTO CALCULATE EXTRA ROW
=========================*/
function auto_calculate_extra(id)
{
    let row = $('tr[data-id="' + id + '"]');
    let parentId = row.data('parent');

    let pallet  = Number($('#pallet_' + id).val()) || 0;
    let big     = Number($('#big_' + id).val()) || 0;
    let small   = Number($('#small_' + id).val()) || 0;

    let normalBoxes = Number($('#boxes_per_pallet_' + parentId).val()) || 0;
    let bigBoxes    = Number($('#box_per_big_pallet' + parentId).val()) || 0;
    let smallBoxes  = Number($('#box_per_small_pallet' + parentId).val()) || 0;
    let sqmPerBox   = Number($('#sqm_per_box_' + parentId).val()) || 0;

    let totalBoxes = 0;

    if ($('#pallet_' + id).length) {
        totalBoxes = pallet * normalBoxes;
    } else {
        totalBoxes = (big * bigBoxes) + (small * smallBoxes);
    }

    $('#box_' + id).val(totalBoxes);

    let totalSqm = totalBoxes * sqmPerBox;
    $('#sqm_' + id).val(totalSqm.toFixed(2));

    // Update footer totals
    calculate_totals();
}


/* =========================
   CALCULATE FOOTER TOTALS
=========================*/
function calculate_totals()
{
    let totalPallet = 0;
    let totalBox    = 0;
    let totalSqm    = 0;

    $('.pallet-input').each(function () {
        totalPallet += Number($(this).val()) || 0;
    });

    $('.box-input').each(function () {
        totalBox += Number($(this).val()) || 0;
    });

    $('.sqm-input').each(function () {
        totalSqm += Number($(this).val()) || 0;
    });

    $('#total_pallets').text(totalPallet);
    $('#total_boxes').text(totalBox);
    $('#total_sqm').text(totalSqm.toFixed(2));
}




$(document).ready(function(){
    calculate_totals();
});


// function remove_row(id){
    // if(confirm('Remove this pallet entry?')){
        // $.post('<?= base_url("producation_detail/delete_row") ?>',
            // { id:id },
            // function(){
                // location.reload();
            // }
        // );
    // }
// }




function auto_calculate(id)
{
    let pallet = Number($("#pallet_" + id).val()) || 0;
    let big    = Number($("#big_" + id).val()) || 0;
    let small  = Number($("#small_" + id).val()) || 0;

    let normal_pallet_boxes = Number($("#boxes_per_pallet_" + id).val()) || 0;
    let big_pallet_boxes    = Number($("#box_per_big_pallet" + id).val()) || 0;
    let small_pallet_boxes  = Number($("#box_per_small_pallet" + id).val()) || 0;

    let sqmPerBox = Number($("#sqm_per_box_" + id).val()) || 0;

    let total_boxes = 0;

    if ($("#pallet_" + id).length) {
        total_boxes = pallet * normal_pallet_boxes;
    }
    else {
        total_boxes = (big * big_pallet_boxes) + (small * small_pallet_boxes);
    }

    $("#box_" + id).val(total_boxes);

    let total_sqm = total_boxes * sqmPerBox;
    $("#sqm_" + id).val(total_sqm.toFixed(2));

    // UPDATE FOOTER TOTALS
    calculate_totals();
}



function update_all_fields(id){

    let pallet = $("input[name='pallet["+id+"]']").val();
    let big = $("input[name='big_pallet["+id+"]']").val();
    let small = $("input[name='small_pallet["+id+"]']").val();
    let box = $("input[name='box["+id+"]']").val();
    let sqm = $("input[name='sqm["+id+"]']").val();
    let pro_batch = $("input[name='pro_batch["+id+"]']").val();
    let pro_shade = $("input[name='pro_shade["+id+"]']").val();

    let boxes_per_pallet = $("#boxes_per_pallet_" + id).val();
    let box_per_big_pallet = $("#box_per_big_pallet" + id).val();
    let box_per_small_pallet = $("#box_per_small_pallet" + id).val();

    $.post('<?= base_url("producation_detail/update_all") ?>', {
        id: id,
        pallet: pallet,
        big: big,
        small: small,
        box: box,
        sqm: sqm,
        pro_batch: pro_batch,
        pro_shade: pro_shade,
        boxes_per_pallet: boxes_per_pallet,
        box_per_big_pallet: box_per_big_pallet,
        box_per_small_pallet: box_per_small_pallet
    }, function(){
        alert("Updated Successfully");
    });
}
	


function update_pallet(id){
    let val = $("input[name='pallet["+id+"]']").val();
    $.post('<?= base_url("producation_detail/update_pallet") ?>', { id:id, value:val });
}

function update_big_pallet(id){
    let val = $("input[name='big_pallet["+id+"]']").val();
    $.post('<?= base_url("producation_detail/update_big_pallet") ?>', { id:id, value:val });
}

function update_small_pallet(id){
    let val = $("input[name='small_pallet["+id+"]']").val();
    $.post('<?= base_url("producation_detail/update_small_pallet") ?>', { id:id, value:val });
}

function update_box(id){
    let val = $("input[name='box["+id+"]']").val();
    $.post('<?= base_url("producation_detail/update_box") ?>', { id:id, value:val });
}

function update_sqm(id){
    let val = $("input[name='sqm["+id+"]']").val();
    $.post('<?= base_url("producation_detail/update_sqm") ?>', { id:id, value:val });
}


function recalc_from_box(id)
{
    let sqmPerBox = 0;

    // check if extra row
    let row = $('tr[data-id="' + id + '"]');

    if (row.length) {
        let parentId = row.data('parent');
        sqmPerBox = Number($('#sqm_per_box_' + parentId).val()) || 0;
    } else {
        sqmPerBox = Number($('#sqm_per_box_' + id).val()) || 0;
    }

    let box = Number($('#box_' + id).val()) || 0;

    let sqm = box * sqmPerBox;
    $('#sqm_' + id).val(sqm.toFixed(2));

    calculate_totals(); // 🔥 LIVE TOTAL UPDATE
}


$(document).on('keyup change', "input[id^='box_']", function () {
    let id = $(this).attr('id').split('_')[1];
    recalc_from_box(id);
});


</script>
<script>
/* =========================
   BUILD EXTRA ROW HTML
=========================*/
/* =========================
   BUILD EXTRA ROW HTML
=========================*/
function buildRowFromParent(parentRow, newId, palletType, parentId)
{
    let tds = parentRow.children('td');

    let palletHtml = '';
    if (palletType === 'normal') {
       palletHtml = `<input type="text"
    class="form-control input-sm pallet-input"
    name="pallet[${newId}]"
    id="pallet_${newId}"
    value="0"
    onkeyup="auto_calculate_extra(${newId})">`;

    } else {
        palletHtml = `
<input type="text"
    class="form-control input-sm pallet-input mb-1"
    name="big_pallet[${newId}]"
    id="big_${newId}"
    value="0"
    onkeyup="auto_calculate_extra(${newId})">

<input type="text"
    class="form-control input-sm pallet-input"
    name="small_pallet[${newId}]"
    id="small_${newId}"
    value="0"
    onkeyup="auto_calculate_extra(${newId})">`;

    }

    return `
<tr class="extra-row" data-parent="${parentId}" data-id="${newId}" style="background:#fdf7e3">
    <td></td>
    <td>${tds.eq(1).html()}</td>
    <td>${tds.eq(2).html()}</td>
    <td>${tds.eq(3).html()}</td>
    <td>${tds.eq(4).html()}</td>

    <td>${palletHtml}</td>

   <td>
<input type="text"
       class="form-control input-sm box-input"
       name="box[${newId}]"
       id="box_${newId}"
       value="0">
</td>

<td>
<input type="text"
       class="form-control input-sm sqm-input"
       name="sqm[${newId}]"
       id="sqm_${newId}"
       value="0"
       readonly>
</td>

    <td><input type="text" class="form-control input-sm" name="pro_batch[${newId}]" id="pro_batch_${newId}"></td>
    <td><input type="text" class="form-control input-sm" name="pro_shade[${newId}]" id="pro_shade_${newId}"></td>

    <td><button class="btn btn-info btn-sm" onclick="update_all_fields(${newId})">Update</button></td>
    <td><button class="btn btn-warning btn-sm">Production Pending</button></td>

    <td class="text-center">
    ${parentRow.find('#status_btn_' + parentId + ' .label-success').length
        ? ''
        : `<button class="btn btn-danger btn-sm remove-row" data-id="${newId}">-</button>`
    }
</td>

</tr>`;
}



/* =========================
   REMOVE EXTRA ROW
=========================*/
$(document).on('click', '.remove-row', function(){
    let btn = $(this);
    let row = btn.closest('tr');

    if(confirm('Remove this pallet entry?')) {
        row.remove();
        calculate_totals(); // update totals
    }
});



</script>

