<?php 
ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

//check of er een error zit in de csv file
function checkDataError($data) {
	$datum_tijd = date("d-m-Y h:m", time());
	error_log("$data[0];$data[1];$data[2];$data[3];$data[4];$data[5];$data[6]\n",3,"error/error-log.csv");
	return TRUE;
}
//connect to the database
$connect = mysql_connect("192.168.10.9","jduysserinck","GqDZK2QJrnqrZVx4");
mysql_select_db("jduysserinck",$connect); //select the table

	if (@$_FILES['csv']['size'] > 0) {

		//get the csv file
		$file = $_FILES['csv']['name'];
		$handle = fopen($file,"r");
		if(strtolower(end(explode(".", $file))) == 'csv'){		
		//loop through the csv file and insert into database
		$found_error = FALSE;
						$cols = fgetcsv($handle,100000,';','"');
		unset($cols);
		while ($data = fgetcsv($handle,1000,";","'")) {
					if(isset($data[0])) {
				$res = mysql_query("SELECT * FROM bedrijf WHERE bedrijfsnaam='".$data[0]."'");
			if(mysql_num_rows($res) != 0) {
				$datasql = mysql_fetch_assoc($res);
				$id = $datasql['id'];
				$bedrijfsnaam = $datasql['bedrijfsnaam'];
			}	
				//if($bedrijfsnaam == $data[0]){
					if ($data[0]) {		
			switch ($data){
				case (empty($data[0])):
						$found_error = checkDataError($data);
					break;
				case (empty($data[1])):
						$found_error = checkDataError($data);
					break;	
				case (empty($data[2])):
						$found_error = checkDataError($data);
					break;
				case (empty($data[3])):
						$found_error = checkDataError($data);
				case (empty($data[4])):
						$found_error = checkDataError($data);
					break;	
				case (empty($data[5])):
						$found_error = checkDataError($data);
					break;
				case (empty($data[6])):
						$found_error = checkDataError($data);
					break;
				case (!$bedrijfsnaam == $data[0]);
					mysql_query ("INSERT INTO bedrijf(bedrijfsnaam) VALUES
						(
						'".addslashes($data[0])."'
						)
					");
					break;/*
				case ($bedrijfsnaam == $data[0]);
				mysql_query("INSERT INTO csv (bedrijfsnaam, contactpersoon, bezoekadres, correspondentie_adres, telfax_nummers, email, website) VALUES
					(
						'".$id."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."'
					)
				");
					break;*/					
				default:
					/*mysql_query ("INSERT INTO bedrijf(bedrijfsnaam) VALUES
						(
						'".addslashes($data[0])."'
						
						)
					");*/
				
				mysql_query("INSERT INTO csv (bedrijfsid, contactpersoon, bezoekadres, correspondentie_adres, telfax_nummers, email, website) VALUES
					(
						'".$id."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."'
					)
				");
				}
			}
					/*} 
				else{
					mysql_query ("INSERT INTO bedrijf(bedrijfsnaam) VALUES
					(
					'".addslashes($data[0])."'
					)
				");
			}*/
			
			}
		} 
		if($found_error){
			echo "csv bestand geupload maar";
			echo "fout(en) gevonden check de error log!";
			} 				
		}else{
		echo "fout type";
		}
		//

		//redirect
		//header('Location: import.php?success=1'); die;

	}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import a CSV File with PHP & MySQL</title>
</head>

<body>



<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  Choose your file: <br />
  <input name="csv" type="file" id="csv" />
  <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html> 