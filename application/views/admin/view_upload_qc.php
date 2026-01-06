<?php 
$this->view('lib/header'); 
$form_name = 'View QC Doc. Of '.$invoicedata->export_invoice_no
 
?>	
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
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3><?=$form_name?></h3>
								<div class="pull-right">
									<a class="btn btn-info" href="<?=base_url().'upload_qc_doc/edit/'.$qcdata->export_invoice_id?>">Edit QC Content</a>
								</div>
							</div>
							 
						</div>
					</div>
								<form action="javascript:;" method="POST"  class="form-horizontal" name="qc_doc_form" id="qc_doc_form">
									<div class="form-group">
										<label class="col-md-2 control-label">QC Content :</label>
											<div class="col-md-6">
												 <?=$qcdata->qc_text?>
											</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">QC Images </label>
											<div class="col-md-8">
												<?php 
												$no=0;
												foreach($qcdata->qc_photos as $photos)
												{
												?>
												<div class="col-md-3" style="padding:5px;">
													<a class="fancybox" style="text-align:center;" href="<?=base_url().'upload/'.$photos->photo_name?>" data-fancybox="gallery" >
														<p style="margin: 0 auto;width:100%;height:100px;overflow:hidden">
														 	<img class="" src="<?=base_url().'upload/'.$photos->photo_name?>" style="width:100px;"  /> 
														</p>
													</a>
													<div class="text-center" style="margin-top:5px;">
													  <a class="btn btn-info" href="<?=base_url().'upload/'.$photos->photo_name?>" data-fancybox="gallery"  ><i class="fa fa-eye"></i></a>
													  
													  <a class="btn btn-warning" href="javascript:;" onclick="edit_photo(<?=$photos->qc_photos_id?>)"><i class="fa fa-pencil"></i></a>
													 
														<a class="btn btn-danger" href="javascript:;" 	onclick="delete_photo(<?=$photos->qc_photos_id?>)"><i class="fa fa-trash"></i></a>
													</div>
												</div>
												 
												<?php
$no++;												
												}
												
												?>
											</div>
									</div>
									 
								 	 <input type="hidden" id="performa_invoice_id"   class="form-control" name="performa_invoice_id"  value="<?=$invoicedata->performa_invoice_id?>"  >		
								 	 <input value="<?=$invoicedata->export_invoice_id?>"  type="hidden" id="export_invoice_id"   class="form-control" name="export_invoice_id"  >		
							</form>
	 
			</div>
	 		</div>
		 </div>
	  
 <?php $this->view('lib/footer'); ?>
 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Photo</h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_photo_form" id="edit_photo_form">
				<div class="modal-body">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Select Photo
					 	</label>
					 	<div class="col-sm-8">
					 		<input type="file" accept="image/*" id="edit_photo_name" class="form-control" name="edit_photo_name" value="">
					 	</div>
						<div class="col-sm-2">
					 		 <img src="" name="edit_img_show" id="edit_img_show" style="height:100px;width:100px" />
					 	</div>
					</div>
					 
									
		 		   </div>
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="eid" id="eid" />
				 
			 </form>
        </div>
    </div>
</div>
 <script>
 $('.fancybox').fancybox({
	 'showNavArrows': true,
	 
 });
 $(".select2").select2({
	 width : "100%"
 });
 function delete_photo(id)
 {
	 Swal.fire({
		title: 'You want to Delete?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, Delete it!'
	}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'upload_qc_doc/delete_photo',
              data: {
                "id"	 : id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Successfully Deleted.");
					setTimeout(function(){ location.reload(); },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
 }

function edit_photo(qc_photos_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"upload_qc_doc/fetchdata",
              data: {
					"id": qc_photos_id
					}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
					$("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 $("#eid").val(qc_photos_id);
					  
					 $("#edit_img_show").attr("src",root+"upload/"+obj.photo_name);
					 
			 	 	unblock_page("",""); 
                  }
              
          }); 

}


 $(document).ready(function() {
	
$("#qc_doc_form").validate({
		rules: {
			qc_content: {
				required: true
			} 
		},
		messages: {
			qc_content: {
				required: "Enter QC Content"
			} 
		}
});

$("#edit_photo_form").validate({
		rules: {
			edit_photo_name: {
				required: true
			}
		},
		messages: {
			edit_photo_name: {
				required: "Select Photo"
			}
		}
	});

});
$("#edit_photo_form").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_photo_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'upload_qc_doc/updaterecord',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==2)
			   {
				    $("#myModal").modal('hide');
				    $("#edit_photo_form").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					setTimeout(function(){ location.reload(); },1500);
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

 $("#qc_doc_form").submit(function(event) {
	event.preventDefault();
	 if(!$("#qc_doc_form").valid())
	{
		return false;
	} 
	 block_page()
	var postData= new FormData(this);
 	$.ajax({
            type: "post",
            url: 	root+'upload_qc_doc/manage',
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
				   $("#qc_doc_form").trigger('reset');
				 	toastr["success"]("Successfully Added");
					setTimeout(function(){ window.location=root+'view/index/'+<?=$invoicedata->export_invoice_id?>; },1500);
			   }
			   else
			   {
				    unblock_page("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 
 </script>
</body>
</html>
