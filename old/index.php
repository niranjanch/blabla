<html>
<head>
<title>Upload Multiple Files Using jquery and PHP</title>
<!-------Including jQuery from Google ------>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="script.js"></script>
<!------- Including CSS File ------>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<div id="maindiv">
<div id="formdiv">
<h2>Multiple Image Upload Form</h2>
<form enctype="multipart/form-data" action="" method="post">
XLSX Type File to be Uploaded. File Size Should Be Less Than 2Mb.
<div id="filediv"><input name="file" type="file" id="file"/></div>
<input type="button" id="add_more" class="upload" value="Add More Files"/>
<input type="submit" value="Upload File" name="submit" id="upload" class="upload"/>
</form>
<!------- Including PHP Script here ------>
<?php include "upload.php"; ?>
</div>
</div>
</body>
</html>
