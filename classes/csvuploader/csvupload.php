<html>

<head>

<body>

<form action="csvimport.php" enctype="multipart/form-data" method="post" id="csv">

<input type="hidden" name="MAX_FILE_SIZE" value="100000" />

Kies een CSV om te importeren: <input name="upload_file" type="file" /><br />

<input type="submit" value="Uploaden" />

</form>

<?php

$allowedExtension = array("csv");

foreach ($_FILES as $file) {

if ($file['tmp_name'] > '') {

if (!in_array(end(explode(".",

strtolower($file['name']))),

$allowedExtension)) {

die($file['name'].' is an invalid file type!<br/>'.

'<a href="javascript:history.go(-1);">'.

'<< Go Back</a>');

}

}

}


