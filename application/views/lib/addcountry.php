<div id="countryadd" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Country</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="country_add" id="country_add">
				<div class="modal-body">
                
				    <div class="field-group">
 						<input type="text" placeholder="Country Name" id="country_name" class="form-control" name="country_name" title="Enter Country Name"/>
				    </div>                
				    <div class="field-group">
				       	<input type="text" placeholder="Currency" id="c_currency" class="form-control" name="c_currency"  required title="Enter Currency" />
				    </div>                     
				    <div class="field-group">
				        <input type="text" placeholder="Longitude" id="c_longitude" class="form-control" name="c_longitude"/>
				    </div>                
				    <div class="field-group">
				       <input type="text" placeholder="Latitude" id="c_latitude" class="form-control" name="c_latitude" />
				    </div> 
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info" onClick="refreshPage()" />     
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