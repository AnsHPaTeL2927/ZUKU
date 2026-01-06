<div id="vesseladd" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Vessel</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="vessel_name" id="vessel_name">
				<div class="modal-body">
				  				 
				      <div class="form-group">
					  	<label class="control-label col-sm-3 " for="form-field-1">
					  	Name:
					  	</label>
					  	<div class="col-sm-6">
					  		<input type="text" placeholder="Document Name" id="dname" class="form-control" name="dname" autocomplete="off" >
					  	</div>
					  </div>
					  
					  
					  <div class="form-group one_by_one">
					  	<label class="control-label col-sm-3" for="form-field-1">
					  		Details
					  	</label>
					  	<div class="col-sm-6">
					  		<textarea type="text" placeholder="Document Details" id="details" class="form-control" name="details" autocomplete="off" ></textarea>
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