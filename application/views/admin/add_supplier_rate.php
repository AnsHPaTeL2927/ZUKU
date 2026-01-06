<?php 
$this->view('lib/header'); ?>	
	<div class="main-container">
		<?php $this->view('lib/sidebar'); ?>
			<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
									<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								<li class="active">
									<a href="<?=base_url().'supplier_list'?>">Supplier List</a>
							 	</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								Set Design Data Of	<span><?=$sup_data->company_name?>  </span>
								<div class="pull-right">
									<a href="<?=base_url().'add_design_detail/download_sup_rate/'.$sup_data->supplier_id?>" target="_blank" class="btn btn-info" >
										<i class="fa fa-download"></i> Download
									</a>
									<button type="button" class="btn btn-primary" onclick="import_excel()"> <i class="fa fa-upload"></i> Import Excel </button>
								</div>
							 </h3>
							
							</div>
							<div class="col-md-4">
										<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Product </strong></label>
										 <div class="col-md-7">
										<select class="select2" name="filter_product_id" id="filter_product_id" required title="Select Product" onchange="load_data()" >
												<option value="">All Product</option>
												<?php 
												foreach($get_product_name_data as $product_row)
												{
													 
													$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
													$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
													$sel = ''; 
													if($product_row->product_id == $_SESSION['sup_product_id'])
													{
														$sel = 'selected="selected"';
													}
													echo "<option ".$sel." value='".$product_row->product_id."'>".$product_name."</option>";
												}
												?>
										</select>
										 </div>     
									</div>
						 	
							
							 <div class="panel-body form-body" >
							 
							 <div class="show_data"></div>
						</div>
					</div>
					 
				 </div>
			</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer');
 $this->view('lib/addseries'); ?>
 <div id="excelModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button"   class="close" onclick="close_opoup()" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Price for <?=$sup_data->company_name?>  </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="import_form" id="import_form">
			 
            <div class="modal-body">
                <div class="row">
					  
					<div class="col-md-12 product_html">					
					   <div class="field-group" >
								<div class="tab"> 
										<h4>Select File For Update Price</h4>
										<input type="file" name="import_file" id="import_file" accept=".csv">
								</div>	
						 </div> 
					 </div> 
				 	 <div class="col-md-12 error_html" >					
					    
					</div> 
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Import" id="import_submit_btn" class="btn btn-success"  /> 
                <button type="button"  class="btn btn-default" data-dismiss="modal" onclick="close_opoup()">Close</button>
            </div>
				<input type="hidden" name="import_supplier_id" id="import_supplier_id" value="<?=$sup_data->supplier_id?>"/>			
			</form>
       
    </div>
</div>
</div>
<script>
$(".select2").select2({
	width:"100%"
});
 load_data();
function load_data()
{
	block_page();
      $.ajax({ 
            type: "POST", 
            url:  root+"add_design_detail/load_sup_data",
            data: {
				"supplier_id"				: <?=$sup_data->supplier_id?>,
				"filter_product_id"			: $("#filter_product_id").val() 
            }, 
            cache: false, 
            success: function (data) { 
				 $(".show_data").html(data);
				 $(".tooltips").tooltip();
				 unblock_page("","");
                }
	
          });  
}
function update_price_by_product(product_id,no)
{
	 
       block_page();
	  
	    var product_rate_per   		=  document.getElementsByName('product_rate_per'+product_id+'[]');
	    var finish_id		  		=  document.getElementsByName('finish_id'+product_id+'[]');
	    var productid		  		=  document.getElementsByName('product_id'+product_id+'[]');
	    var design_rate		  		=  document.getElementsByName('design_rate'+product_id+'[]');
	    var design_rate_id	  		=  document.getElementsByName('design_rate_id'+product_id+'[]');
	    var product_rate_per_array 	= [];
	    var finish_id_array 		= [];
		var product_id_array 		= [];
	    var design_rate_array 		= [];
	    var design_rate_id_array 	= [];
			for (var i = 0; i < product_rate_per.length; i++) { 
				var p = product_rate_per[i]; 
				product_rate_per_array.push(p.value); 
			} 
			for (var i = 0; i < finish_id.length; i++) { 
				var p = finish_id[i]; 
				finish_id_array.push(p.value); 
			} 
			 
			
			for (var i = 0; i < productid.length; i++) { 
				var p = productid[i]; 
				product_id_array.push(p.value); 
			} 
			 
			for (var i = 0; i < design_rate.length; i++) { 
				var p = design_rate[i]; 
				
				design_rate_array.push(p.value); 
			} 
			for (var i = 0; i < design_rate_id.length; i++) { 
				var p = design_rate_id[i]; 
				design_rate_id_array.push(p.value); 
			} 
			
	    $.ajax({ 
              type: "POST", 
              url:  root+"add_design_detail/update_multiple_sup_price",
              data: {
					"supplier_id"		: <?=$sup_data->supplier_id?>,
					"finish_id"			: finish_id_array,
			 		"product_array_id"	: product_id_array,
				 	"design_rate"		: design_rate_array,
					"product_rate_per"	: product_rate_per_array,
					"design_rate_id"	: design_rate_id_array
              }, 
              cache: false, 
              success: function (data) { 
					var obj= JSON.parse(data);
					  if(obj.res==1)
					   {
						  							  
							unblock_page("success","Sucessfully Updated.");
							setTimeout(function(){  location.reload() },1000);
						 
					   }
					 
				 	else
					   {
							unblock_page("error","Something Wrong.") 
					   } 
                  }

            });  

}
 function import_excel()
{
	$("#excelModal").modal({
		backdrop: 'static',
		keyboard: false
	});

}
$("#import_form").validate({
		rules: {
			import_file: {
				required: true
			}
		},
		messages: {
			import_file: {
				required: "Select CSV File"
			} 
		}
	});
$("#import_form").submit(function(event) {
	event.preventDefault();
	if(!$("#import_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	var url = root+'add_design_detail/import_sup_price'; 
	$.ajax({
            type: "post",
            url: url,
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			    {
				   unblock_page("success","Sucessfully Imported.");
				   setTimeout(function(){ location.reload(); },1000);
				 
			 	}
				else if(obj.res==2)
				{
					unblock_page("error","Worng File. Coloum Doesn't Match");
		 		}
				else if(obj.res==3)
				{
					unblock_page("error","Worng File. Coloum Name Doesn't Match");
		 		}
				else if(obj.res==4)
				{
					$(".product_html").hide();
					$(".error_html").show();
					$(".error_html").html(obj.error_html);
			 		unblock_page("error","Some Record having error.");
		 		}
			 	else if(obj.res==0)
				{
					unblock_page("error","File Not Upload.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function update_price(finish_id,product_id,n,design_rate_id)
{
	 
       block_page();
	   
        $.ajax({ 
              type: "POST", 
              url:  root+"add_design_detail/update_sup_price",
              data: {
					"supplier_id"		: <?=$sup_data->supplier_id?>,
					"finish_id"			: finish_id,
				 	"product_id"		: product_id,
					"design_rate"		: $("#design_rate"+n).val(), 
					"product_rate_per"	: $("#product_rate_per"+n).val(), 
					"design_rate_id"	: design_rate_id
              }, 
              cache: false, 
              success: function (data) { 
					var obj= JSON.parse(data);
				  if(obj.res==1)
				   {
					  							  
						unblock_page("success","Sucessfully Inserted.");
						setTimeout(function(){  location.reload() },1000);
					 
				   }
				else if(obj.res==2)
				   {
					  							  
						unblock_page("success","Sucessfully Updated.");
						setTimeout(function(){  location.reload() },1000);
					 
				   }
				else
				   {
						unblock_page("error","Something Wrong.") 
				   } 
                  }

            });  

    } 

</script>

  