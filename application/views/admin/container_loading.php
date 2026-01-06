'
<?php 
$this->view('lib/header'); 
 
?>
<div class="main-container">
  <?php $this->view('lib/sidebar'); ?>
 <script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"container_loading/view_pdf", '_blank');
	}
	else{
		window.location= root+"container_loading/view_pdf";
	}
	
}
</script>

  <div class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li> <i class="clip-pencil"></i> <a href="<?=base_url()?>dashboard"> Dashboard </a> </li>
            <li class="active"> &nbsp;Container Photos </li>
          </ol>
          <div class="page-header" style="margin-left:20px;">
            <h3>Container Photos (
              <?=$set_container->invoice_no?>
              ), (
              <?=$set_container->container_no?>
              ) <a class="btn btn-info tooltips pull-right" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a> </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel-body form-body">
		 
            <div class="col-md-10 col-md-offset-1">
			 <?php ob_start();?> 
              <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="container_loading_form" id="container_loading_form">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1"> PI No </label>
                  <div class="col-sm-4">
                    <input type="text" placeholder="Enter PI No" autocomplete="off" style="font-weight:bold;" id="pi_no" required="" class="form-control" name="pi_no" value="<?=$set_container->invoice_no?>" title="Enter PI No" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1"> Container No </label>
                  <div class="col-sm-4">
                    <input type="text" placeholder="Container No" id="container_no" style="font-weight:bold;" class="form-control" name="container_no" value="<?=$set_container->container_no?>" autocomplete="off" title="Container No" readonly>
                  </div>
                </div>
                <input type="hidden" id="exportdata<?=$set_container->pi_loading_plan_id?>" name="exportdata" value="<?=$set_container->pi_loading_plan_id?>" >
                <table cellspacing="0" cellpadding="0"  width="100%">
                  <tr>
                    <th width="20%" class="text-center" > <select class="select2" name="label_id" id="label_id" onchange="showdata(this.value)" >
                        <option value="">All Document Label</option>
                        <?php
															foreach($labeldata as $label_row)
															{
																echo "<option value='".$label_row->document_master_id."'>".$label_row->label_name."</option>";
															}
															?>
                      </select>
                    </th>
                    <th width="30%" class="text-center" >Upload Files</th>
                    <th width="50%" class="text-center" >Show Files</th>
                  </tr>
                  <?php
														$no = 0;
														$container_loading_id =0;
														$notes ='';
															for($p=0;$p<count($labeldata);$p++)
															{
																
															 	 if($no % 5 == 0)
																 {
													?>
                  <tr>
                    <?php
																 }
																 
																 $rp = '';
																 
																 if($labeldata[$p]->file_type == '2')
																	{
																		$rp = 'multiple';
																	}
															 
																 ?>
                  <tr class="alldatacls uploadcls<?=$labeldata[$p]->document_master_id?>">
                    <td  class="text-center"><?=$labeldata[$p]->label_name?></td>
                    <td  class="text-center"><input type="file" placeholder="Upload Logo" id="upload_logo<?=$labeldata[$p]->document_master_id?>" class="form-control" name="upload_logo<?=$labeldata[$p]->document_master_id?>[]" value="<?=$imagedata->upload_logo?>" accept="image/jpeg,image/png,image/jpg,application/pdf,video/mp4,video/x-m4v,video" <?=$rp?>></td>
                    <td  class="text-center" style="vertical-align:middle"><?php 
															if(!empty($labeldata[$p]->images_data->upload_logo))
															{
																$container_loading_id = $labeldata[$p]->images_data->container_loading_id;
																$notes = $labeldata[$p]->images_data->notes;
															 $img = explode(",",$labeldata[$p]->images_data->upload_logo);
															 
															 for($p1=0;$p1<count($img);$p1++)
															 {
																 $exts = array('gif', 'png', 'jpg','jpeg','JPEG','JPG'); 
																if(in_array(end(explode('.', $img[$p1])), $exts))
																{
															?>
                      <span style="float: left;margin: 10px;    border: 1px solid;
																padding: 10px;"> <a href="<?=base_url().'upload/container_photos/'.$img[$p1]?>" data-fancybox="gallery<?=$labeldata[$p]->document_master_id?>" class="gallery"  >
                      <?php 
																
																?>
                      <img src="<?=base_url().'upload/container_photos/'.$img[$p1]?>"  style="    border: 1px solid;padding:10px;height:100px;width:auto" /> </a> <br>
                      <br>
                      <a class="btn btn-danger" onclick="delete_image(<?=$labeldata[$p]->images_data->container_photos_id.',&quot;'.$img[$p1].'&quot;'?>)" href="javascript:;"><i class="fa fa-trash"></i> </a> <a href="<?=base_url().'Container_loading/download/'.$img[$p1]?>" target='_blank' class='btn btn-info'> <i class='fa fa-download'></i> </a> </span>
                      <?php 
																}
																else
																{
																	?>
                      <span style="float: left;margin: 10px;    border: 1px solid;
																	padding: 10px;"> <a href="<?=base_url().'upload/container_photos/'.$img[$p1]?>"  data-fancybox="gallery<?=$labeldata[$p]->document_master_id?>" class="gallery btn btn-info" ><i class="fa fa-eye"></i> </a> <br>
                      <br>
                      <a class="btn btn-danger" onclick="delete_image(<?=$labeldata[$p]->images_data->container_photos_id.',&quot;'.$img[$p1].'&quot;'?>)" href="javascript:;"><i class="fa fa-trash"></i> </a> <a href="<?=base_url().'Container_loading/download/'.$img[$p1]?>" target='_blank' class='btn btn-info'> <i class='fa fa-download'></i> </a> </span>
                      <?php
																} 
															}
															}
															?></td>
                    <input type="hidden"   id="document_master_id<?=$labeldata[$p]->document_master_id?>"   name="document_master_id[]" value="<?=$labeldata[$p]->document_master_id?>" >
                    <input type="hidden"   id="label_name<?=$labeldata[$p]->label_name?>"   name="label_name[]" value="<?=$labeldata[$p]->label_name?>" >
                    <input type="hidden"   id="images_data<?=$labeldata[$p]->label_name?>"   name="images_data[]" value="<?=$labeldata[$p]->images_data->upload_logo?>" >
                    <input type="hidden"   id="images_type<?=$labeldata[$p]->label_name?>"   name="images_type[]" value="<?=$labeldata[$p]->file_type?>" >
                    <?php 
														 $no++;
																if($no % 5  == 0 && $no != 0)
																 {
																	 $no = 0;
																	 ?>
                  </tr>
                  <?php
																}
																		
															}
															 
														?>
                  <tr>
                    <td colspan="5"><textarea class="form-control"  style="height:80px;" name="notes" id="notes" title="Enter Notes" placeholder="Notes" ><?=strip_tags($notes)?>
</textarea></td>
                  </tr>
                </table>
				<?php
									 $output = ob_get_contents(); 
									$_SESSION['invoice_no'] = $set_container->invoice_no;
									 $_SESSION['container_loading_content'] = $output;
									  
									 if($mode=="1")
									 {
										 echo "<script>view_pdf(0)</script>";
									 }
								?>
                <br>
                <div class="col-md-offset-4">
                  <div class="form-group " style="" >
                    <button type="submit" class="btn btn-success"> Save </button>
                    <a href="<?=$_SERVER['HTTP_REFERER']?>" class="btn btn-danger"> Cancel </a>
                    <?php
														if($fd == 'edit')
														{
														?>
                    <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Consigner</button>-->
                    <?php
			
														}
													?>
                  </div>
                </div>
                <input type="hidden" name="pi_loading_plan_id" id="pi_loading_plan_id" value="<?=$set_container->pi_loading_plan_id?>"/>
                <input type="hidden" name="container_loading_id" id="container_loading_id" value="<?=$container_loading_id?>"/>
                <input type="hidden" name="next" id="next" value="0"/>
              </form>
								
            </div>
			
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->view('lib/footer'); ?>
<script>

// function delete_image(deleleid)
// {
	// main_delete(deleleid,'Container_loading/delete_image','container_loading/index/<?=$set_container->pi_loading_plan_id?>/<?=$set_container->container_no?>')
// }

function delete_image(container_photos_id,upload_logo)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'Container_loading/delete_image',
              data: {
                "id":container_photos_id,
				"image_name":upload_logo 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
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

$(".gallery").fancybox({
			'hideOnContentClick': true
		});
$(".select2").select2({
	width : "100%" 
});
function onlyNumberKey(evt) 
    {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
	
function save_and_next()
{
	$("#next").val(1);
	$("#container_loading_form").submit();
}

function showdata(value)
{
	if(value != "")
	{
		$(".alldatacls").hide();
		$(".uploadcls"+value).show();
	}
	else
	{
		$(".alldatacls").show();
	}
}
 $(function () {
            $('input').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });

 $(function () {
            $('textarea').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });	
		
	
$("#container_loading_form").submit(function(event) {
	event.preventDefault();
	if(!$("#container_loading_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'Container_loading/manage',
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
				   
					unblock_page("success","Sucessfully Inserted.");
					if($("#next").val() == 1)
					{
						setTimeout(function(){ window.location = root+'container_loading/index/<?=$set_container->pi_loading_plan_id?>'; },100);
					}
					else
					{
						setTimeout(function(){ location.reload(); },100);
					}
			   }
			   else if(obj.res==2)
			   {
				   
					unblock_page("success","Sucessfully Updated.");
					if($("#next").val() == 1)
					{
						
						setTimeout(function(){ window.location = root+'container_loading/index/<?=$set_container->pi_loading_plan_id?>'; },100);
					 }
					else
					{
						setTimeout(function(){ location.reload(); },100);
					}
			   }
			   else
			   {
				    unblock_page("error","You haven't select new images.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
</script>