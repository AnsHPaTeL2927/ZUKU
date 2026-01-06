<div id="shippinglineadd" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Shipping Line</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="shipping_line" id="shipping_line">
				<div class="modal-body">
                
				   <div class="form-group">
						<label class="control-label col-sm-3 " for="form-field-1">
						Shipping Line Name:
						</label>
						<div class="col-sm-6">
							<input type="text" placeholder="Shipping Name" id="shipping_name" class="form-control" name="shipping_name"  autocomplete="off" autofocus="autofocus" 
							>
						</div>
					</div>
					
					<div class="form-group one_by_one">
						<label class="col-sm-3 control-label" for="form-field-1">
							Shipping Line Details
						</label>
						<div class="col-sm-6">
							<textarea type="text" placeholder="Shipping Details" id="shipping_detail" class="form-control" name="shipping_detail" ></textarea>
						</div>
					</div>
				
					<div class="form-group design_file_control one_by_one">
						<label class="col-sm-3 control-label" for="form-field-1">
							Upload Logo
						</label>
						<div class="col-sm-6">
							<input type="file" placeholder="Upload Logo" id="upload_logo" class="form-control" name="upload_logo" value="" accept="image/jpeg,image/png,image/jpg,application/pdf">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="form-field-1">
						Remarks:
						</label>
						<div class="col-sm-6">
							<textarea type="text" placeholder="Remarks" id="remarks" class="form-control" name="remarks" value="" autocomplete="off" ></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="form-field-1">
						Free Field 1:
						</label>
						<div class="col-sm-6">
							<input type="text" placeholder="Free Field 1" id="ff1" class="form-control" name="ff1" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3 " for="form-field-1">
						Free Field 2:
						</label>
						<div class="col-sm-6">
							<input type="text" placeholder="Free Field 2" id="ff2" class="form-control" name="ff2" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="form-field-1">
						Free Field 3:
						</label>
						<div class="col-sm-6">
							<input type="text" placeholder="Free Field 3" id="ff3" class="form-control" name="ff3" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="form-field-1">
							Is Active:
						</label>
						<div class="col-sm-6">													
							<label class="radio-inline">
								<input type="radio" name="isactive" id="yes" value="yes" checked>Yes
							</label>
							<label class="radio-inline">
								<input type="radio" name="isactive" id="no" value="no">No			
							</label>
							<!--To Show Error  -->	
							<label id="isactive-error" class="error" for="isactive"></label>	
							<!--To Show Error  -->
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="form-field-1">
							Order No:
						</label>
						<div class="col-sm-6">
							<input type="text" placeholder="Order No" id="ornumber" class="form-control" name="ornumber" 
							autocomplete="off" onkeypress="return onlyNumberKey(event)"	value="<?php echo $no->order_no+1 ?>"/>
						</div>
					</div>
				</div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Save" class="btn btn-info"   />     
                <button type="button" class="btn btn-default" data-dismiss="modal" onClick="refreshPage()">Close</button>
            </div>
			
			</form>
        </div>
    </div>
</div>
<script>
function refreshPage(){
    window.location.reload();
} 
</script>