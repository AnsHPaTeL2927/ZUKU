<div id="forwareradd" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Forwarer</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="supplier_name" id="supplier_name">
				<div class="modal-body">
                
				   <div class="form-group">
						<label class="col-sm-3 control-label" for="form-field-1">
								 Company Name
						</label>
						<div class="col-sm-6">
							<input type="text" id="c_name" name="c_name" placeholder="Company Name" required="" title="Enter Company Name" class="form-control"  />
						</div>
					 </div>
					 
				      <div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									 Address
							</label>
							<div class="col-sm-6">
								<textarea id="address" name="address" placeholder="Address" required="" class="form-control" required title="Enter Address"></textarea>
							</div>
						</div>
						
						 <div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									 City
							</label>
							<div class="col-sm-6">
								<input type="text" id="city" name="city" placeholder="City"   class="form-control"  />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label" for="form-field-1">
									 Field1
							</label>
							<div class="col-sm-6">
								<input type="text" id="field1" name="field1" placeholder="Field1"   class="form-control" />
							</div>                                                                                       
						</div> 
						
						<div class="form-group">                                                                     
							<label class="col-sm-3 control-label" for="form-field-1">                                    
									 Field2                                                                              
							</label>                                                                                     
							<div class="col-sm-6">                                                                       
								<input type="text" id="field2" name="field2" placeholder="Field2"   class="form-control" />
							</div>                                                                                       
						</div> 
						
						<div class="form-group">                                                                     
							<label class="col-sm-3 control-label" for="form-field-1">                                    
									 Field3                                                                              
							</label>                                                                                     
							<div class="col-sm-6">                                                                       
								<input type="text" id="field3" name="field3" placeholder="Field3"   class="form-control" />
							</div>                                                                                       
						</div>    
						
						<div class="form-group">                                                                     
							<label class="col-sm-3 control-label" for="form-field-1">                                    
									 Field4                                                                              
							</label>                                                                                     
							<div class="col-sm-6">                                                                       
								<input type="text" id="field4" name="field4" placeholder="Field4"   class="form-control" />
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