<div id="modeltype" class="modal fade" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Design</h4>
            </div>
			 <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="model_add" id="model_add">
				<div class="modal-body">
                <div class="form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		  Design Name
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="text" placeholder="Design Name" id="model_name" class="form-control" name="model_name" value="">
				 	</div>
				 </div>
				  <div class="form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Select Finish
				 	</label>
				 	<div class="col-sm-12">
				 		 <select class="select2" name="finish_id[]" id="finish_id" title="Select Finish" multiple data-placeholder="Select Finish">
							 
							<?php
							for($p=0;$p<count($finishdata);$p++)
							{
							 	echo "<option value='".$finishdata[$p]->finish_id."'>".$finishdata[$p]->finish_name." </option>";
							}
							?> 
						</select>
				 	</div>
				 </div>
				   <div class="form-group">
				 	<label class="col-sm-12 control-label" for="form-field-1">
				 		 Design Image
				 	</label>
				 	<div class="col-sm-12">
				 		<input type="file" placeholder="Design File" id="design_file" class="form-control" name="design_file" value="" >
				 	</div>
				 </div>   
			 </div>
            <div class="modal-footer">
				<input name="Submit" type="submit" value="Add" class="btn btn-info"  />     
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			<input type="hidden" name="productid" id="productid" />
			<input type="hidden" name="row_no" id="row_no" />
			<input type="hidden" name="folder_option" id="folder_option" value="1"/>
			 
			</form>
        </div>
    </div>
</div>
