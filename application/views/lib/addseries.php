<div id="seriesmodal" class="modal fade" role="dialog" style="z-index:9999">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Product</h4>
            </div>
			 <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="series_add" id="series_add">
				<div class="modal-body">
				<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							HSNC Code
						</label>
						<div class="col-sm-12">
						<select class="form-control" name="hsnc_code" id="hsnc_code">
						<?php
							for($h=0;$h<count($hsnc_data);$h++)
							{
								$sel= '';
								if($hsnc_data[$h]->hsnc_code==$edit_record->hsnc_code)
								{
									$sel = 'selected="selected"';
								}											
							?>
								<option <?=$sel?> value="<?=$hsnc_data[$h]->hsnc_code ?>" ><?=$hsnc_data[$h]->hsnc_code?> </option>
								
							<?php 
							}?>
						</select>
						</div>
					</div> 	
                <div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
						Product Name
					</label>
					<div class="col-sm-12">
						<input type="text" placeholder="Product Name" id="series_name" class="form-control" name="series_name" value="" >
					</div>
				</div>
				 <div class="form-group">
					<label class="col-sm-12 control-label" for="form-field-1">
						Water Absorption
					</label>
					<div class="col-sm-12">
						<input type="text" placeholder="Water Absorption" id="water_absorption" class="form-control" name="water_absorption" value="" autocomplete="off" >
					</div>
				</div>
				
					<div class="form-group">
										
						<label class="col-sm-12 control-label" for="form-field-1">
								Sale (Unit)
						</label>
						<div class="col-sm-12">
							<select  name="sale_unit" id="sale_unit" class="form-control" >
								<option value="">Choose Sale Unit</option>
								<option value="SQM">SQM</option>
								<option value="BOX">BOX</option>
								<option value="SQF">SQF</option>
								<option value="PCS">PCS</option>
							</select>
					
						</div>
					</div>
				
					<div class="form-group">
					
						<label class="col-sm-12 control-label" for="form-field-1">
								Purchase (Unit)
						</label>
						<div class="col-sm-12">
							<select  name="purchase_unit" id="purchase_unit" class="form-control" >
							<option value="">Choose Purchase Unit</option>
								<option value="SQM">SQM</option>
								<option value="BOX">BOX</option>
								<option value="SQF">SQF</option>
								<option value="PCS">PCS</option>
							</select>
					
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Field 1
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Field 1" id="field1" class="form-control" name="field1" value="" autocomplete="off" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1">
							Field 2
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Field 2" id="field2" class="form-control" name="field2" value="" autocomplete="off" >
						</div>
					</div> 
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>
