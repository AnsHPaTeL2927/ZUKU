<table class="table table-bordered">
  <thead>
    <tr>
      <th>Product Name</th>
      <th>Design Name</th>
      <th>Finish Name</th>
      <th>Pallet</th>
      <th>Boxes</th>
      <th>Sqm</th>
      <th>Unit</th>
      <th>Quantity</th>
      <th>Batch No</th>
      <th>Shade No</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($rows as $row): ?>
      <tr>
        <td><?=$row->product_name?></td>
        <td><?=$row->model_name?></td>
        <td><?=$row->finish_name?></td>
        <td><input type="text" name="pallet[<?=$row->production_trn_id?>]" value="<?=$row->no_of_pallet?>"></td>
        <td><?=$row->no_of_boxes?></td>
        <td><?=$row->no_of_sqm?></td>
        <td>-</td>
        <td>-</td>
        <td><input type="text" name="batch_no[<?=$row->production_trn_id?>]"></td>
        <td><input type="text" name="shade_no[<?=$row->production_trn_id?>]"></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
