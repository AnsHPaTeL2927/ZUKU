<?php 
$this->view('lib/header'); 
  
?>	
	<div class="main-container">
		<?php 
		
		$this->view('lib/sidebar'); 
		
		?>
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
									<a href="<?=base_url().'customer_detail'?>">Customer List</a>
									
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								Set Design Data Of	<span><?=$cust_data->c_companyname?>  </span>
								<div class="pull-right">
									<a href="<?=base_url().'add_design_detail/download_cust_data/'.$cust_data->id?>" target="_blank" class="btn btn-info" >
										<i class="fa fa-download"></i> Download
									</a>
									<button type="button" class="btn btn-primary" onclick="import_excel()"> <i class="fa fa-upload"></i> Import Excel </button>
									<br>
									<br>
									<a href="<?=base_url().'customer_detail/product_detail//'.$cust_data->id?>" class="btn btn-primary" > Next </a>
								</div>
							 </h3>
							
							</div>
							 <div class="panel-body form-body">
							 
							 <div class="col-md-4">
										<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Product </strong></label>
										 <div class="col-md-7">
										<select class="select2" name="filter_product_id" id="filter_product_id" required title="Select Product" onchange="load_packing_detail(this.value);load_data();" >
												<option value="">All Product</option>
												<?php 
												foreach($get_product_name_data as $product_row)
												{
													 
													$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
													$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
													$sel = '';
													if($product_row->product_id == $_SESSION['customer_barcode_product_id'])
													 {
														 $sel ='selected="selected"';
													 }
													echo "<option ".$sel."  value='".$product_row->product_id."'>".$product_name."</option>";
												}
												 
												?>
										</select>
										 </div>     
									</div>
									<div class="col-md-4">
										<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Design </strong></label>
										 <div class="col-md-7">
										<select class="select2" name="filter_packing_model_id" id="filter_packing_model_id" required title="Select Product" onchange="load_data()" >
												<option value="">All Design</option>
												<?php 
												foreach($design_data as $design_row)
												{
													 
													 echo "<option   value='".$design_row->packing_model_id."'>".$design_row->model_name."</option>";
												}
												?>
										</select>
										 </div>     
									</div>
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
                <h4 class="modal-title">Import Design Customer Detail for <?=$cust_data->c_companyname?>  </h4>
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
				<input type="hidden" name="import_cust_id" id="import_cust_id" value="<?=$cust_data->id?>"/>			
			</form>
       
    </div>
</div>
</div>
<script>
$(".select2").select2({
	width:"100%"
});
 
load_data();
function load_packing_detail(value)
{
	 block_page();
	 $("#filter_packing_model_id").val('')
        $.ajax({ 
              type: "POST", 
              url:  root+"add_design_detail/load_packing",
              data: {
				 	"filter_product_id"			: value
		      }, 
              cache: false, 
              success: function (data) { 
					 $("#filter_packing_model_id").html(data);
					 
					 unblock_page("","");
                  }

            });  
}
function load_data()
{
	 
	 block_page();
        $.ajax({ 
              type: "POST", 
              url:  root+"add_design_detail/load_barcode_data",
              data: {
					"cust_id"					: <?=$cust_data->id?>,
					"filter_product_id"			: $("#filter_product_id").val(),
					"filter_packing_model_id"	: $("#filter_packing_model_id").val()
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
	  
	    var extra_flied   		=  document.getElementsByName('extra_flied'+product_id+'[]');
	    var barcode_no   		=  document.getElementsByName('barcode_no'+product_id+'[]');
	    var productid		  	=  document.getElementsByName('product_id'+product_id+'[]');
	    var packing_model_id 	=  document.getElementsByName('packing_model_id'+product_id+'[]');
	    var cust_design_name	=  document.getElementsByName('cust_design_name'+product_id+'[]');
	    var design_detail_id	=  document.getElementsByName('design_detail_id'+product_id+'[]');
	    var finish_id			=  document.getElementsByName('finish_id'+product_id+'[]');
	    var extra_flied_array 		= [];
	    var barcode_no_array 		= [];
	  	var productid_array 		= [];
	    var cust_design_array 		= [];
	    var design_detail_id_array 	= [];
	    var packing_model_id_array 	= [];
	    var finish_id_array 		= [];
			for (var i = 0; i < extra_flied.length; i++) { 
				var p = extra_flied[i]; 
				extra_flied_array.push(p.value); 
			} 
			for (var i = 0; i < barcode_no.length; i++) { 
				var p = barcode_no[i]; 
				barcode_no_array.push(p.value); 
			} 
		 	for (var i = 0; i < productid.length; i++) { 
				var p = productid[i]; 
				productid_array.push(p.value); 
			} 
			 
			for (var i = 0; i < cust_design_name.length; i++) { 
				var p = cust_design_name[i]; 
				cust_design_array.push(p.value); 
			} 
			for (var i = 0; i < design_detail_id.length; i++) { 
				var p = design_detail_id[i]; 
				design_detail_id_array.push(p.value); 
			} 
			for (var i = 0; i < packing_model_id.length; i++) { 
				var p = packing_model_id[i]; 
				packing_model_id_array.push(p.value); 
			} 
			for (var i = 0; i < finish_id.length; i++) { 
				var p = finish_id[i]; 
				finish_id_array.push(p.value); 
			} 
	    $.ajax({ 
              type: "POST", 
              url:  root+"add_design_detail/update_multiple_customerdetail",
              data: {
					"cust_id"			: <?=$cust_data->id?>,
					"extra_flied_array"	: extra_flied_array,
					"barcode_no_array"	: barcode_no_array,
					"finish_id_array"	: finish_id_array,
			 		"product_array_id"	: productid_array,
				 	"cust_design_array"	: cust_design_array,
					"design_detail_id"	: design_detail_id_array,
					"packing_model_id"	: packing_model_id_array
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
	var url = root+'add_design_detail/import_cust_data'; 
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

 function update_price(packing_model_id,product_id,n,design_rate_id,finish_id)
{
	 
       block_page();
        $.ajax({ 
              type: "POST", 
              url:  root+"add_design_detail/updatedesigndetail",
              data: {
					"cust_id"			: <?=$cust_data->id?>,
					"packing_model_id"	: packing_model_id,
					"finish_id"			: finish_id,
				 	"product_id"		: product_id,
					"cust_design_name"	: $("#cust_design_name"+n).val(), 
					"barcode_no"		: $("#barcode_no"+n).val(), 
					"extra_flied"		: $("#extra_flied"+n).val(), 
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
<?php 
if(!empty($_SESSION['customer_barcode_product_id']))
{
	echo "<script>load_packing_detail(".$_SESSION['customer_barcode_product_id'].")</script>";
}
?>
  