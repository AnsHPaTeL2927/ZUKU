<!DOCTYPE html>
<html lang="en">
<head>
  <title>Upload image and create a thumbnail in codeigniter - nicesnippets.com</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
</head>
<body>
<div class="container">
  <div class="row">
	<div class="col-lg-12"> 
	  <form id="productImage" action="<?php echo site_url('upload');?>" name="productImage" method="post" enctype="multipart/form-data">
		<div class="form-group">
		  <label for="email">Choose Product Images:</label>
		  <input name="productImage" type="file"  /> 
		</div>
		<button type="submit" value="Submit" class="btn btn-default">Submit</button>
	  </form>
   </div>
 </div>
</div>
</body>
</html>