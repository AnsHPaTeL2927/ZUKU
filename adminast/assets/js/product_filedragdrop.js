$(function() {
 
    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.upload-product-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        
    });

    // Drag over
    $('.upload-product-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        
    });

    // Drop
    $('.upload-product-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
		var file = e.originalEvent.dataTransfer.files;
		if(file[0].name.split(".")[1]=="csv")
		{
			var fd = new FormData();
			fd.append('file', file[0]);
			uploadData(fd);
		}
		else
		{
			toastr["error"]("You Choose Wrong file. Please upload data from csv file")
		} 	
    });

    // Open file selector on div click
    $("#upload_productfile").click(function(){
        $("#product_file").click();
    });

    // file selected
    $("#product_file").change(function(){
        var fd = new FormData();

        var files = $('#product_file')[0].files[0];
		if(files.name.split(".")[1]=="csv")
		{
			fd.append('file',files);
			uploadData(fd);
		}
		else{
			toastr["error"]("You Choose Wrong file. Please upload data from csv file")
		}
    });
});

// Sending AJAX request and upload file
function uploadData(formdata){
	
	block_page();
    $.ajax({
        url: root+'product_grid/upload_all_data',
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
	    success: function(response){
            console.log(response);
			var obj = JSON.parse(response);
			
			if(obj.res==1)
			{
				unblock_page("success","Sucessfully Imported.");
			}
			else if(obj.res==0)
			{
				unblock_page("error","Something is wrong.");
			}
			else if(obj.res==2)
			{
				unblock_page("error","Please set csv column with required column.");
				$("#myModal").modal('hide');
				$("#coluom_mismatch_error").html(obj.str)
			}
        },
		error: function(xhr, status, errorThrown) {
			 
			console.log(errorThrown);
			console.log(status);
			console.log(xhr);
		}
    });
}

 