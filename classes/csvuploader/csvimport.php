<?php
//var_dump($_POST['upload']);

$databasehost = "localhost";
$databasename = "test";
$databasetable = "sample";
$databaseusername ="mwink";
$databasepassword = "XmvvQrsQJKc7LGyM";
$fieldseparator = ";";
$lineseparator = "\n";
//$csvfile = "filename.csv";
//var_dump($_FILES);

$csvfile = $_FILES ["upload_file"]["tmp_name"];
/********************************/
$addauto = 0;
/********************************/
$save = 1;
$outputfile = "error_log.csv";
/********************************/

//echo "<br> $csvfile <br>";
if(!file_exists($csvfile)) {
	echo "Bestand niet gevonden. Zorg ervoor dat u de juiste bestanslocatie heeft opgegeven.\n";
	exit;
}

$file = fopen($csvfile,"r");

if(!$file) {
	echo "Error opening data file.\n";
	exit;
}

$size = filesize($csvfile);

if(!$size) {
	echo "File is empty.\n";
	exit;
}

$csvcontent = fread($file,$size);

fclose($file);

$con = @mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
@mysql_select_db($databasename) or die(mysql_error());

$lines = 0;
$queries = "";
$linearray = array();

foreach(explode($lineseparator,$csvcontent) as $line) {

	$lines++;

	$line = trim($line," \t");
	
	$line = str_replace("\r","",$line);
	
	/************************************
	This line escapes the special character. remove it if entries are already escaped in the csv file
	************************************/
	$line = str_replace("'","\'",$line);
	/*************************************/
	
	$linearray = explode($fieldseparator,$line);
	
	$linemysql = implode("','",$linearray);
	
	if($addauto)
		$query = "insert into $databasetable values('','$linemysql');";
	else
		$query = "insert into $databasetable values('$linemysql');";
	
	$queries .= $query . "\n";

	@mysql_query($query);
}

@mysql_close($con);

if($save) {
	
	if(!is_writable($outputfile)) {
		echo "File is not writable, check permissions.\n";
	}
	
	else {
		$file2 = fopen($outputfile,"w");
		
		if(!$file2) {
			echo "Error writing to the output file.\n";
		}
		else {
			fwrite($file2,$queries);
			fclose($file2);
		}
	}
	
}

echo "In dit csv bestand zijn $lines regels gevonden.\n";
echo "<br> Deze zijn toegevoegd in de database. <br>\n";
echo "<a href=csvupload.php>Ga terug</a>"

;

?>
