$(function() {
 
    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        
    });

    // Drag over
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        
    });

    // Drop
    $('.upload-area').on('drop', function (e) {
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
    $("#uploadfile").click(function(){
        $("#file").click();
    });

    // file selected
    $("#file").change(function(){
        var fd = new FormData();

        var files = $('#file')[0].files[0];
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
        url: root+'import_csv/checkfile',
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
	    success: function(response){
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
				unblock_page("error","File Coloum Not Match.");
			}
        },
		error: function(xhr, status, errorThrown) {
			 
			console.log(errorThrown);
			console.log(status);
			console.log(xhr);
		}
    });
}

 