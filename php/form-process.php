<?php
//  Include PHPExcel_IOFactory
include 'PHPExcel/IOFactory.php';

//  Include PHPExcel_IOFactory
include 'database.php';

$output_dir = "uploads/";
$arr = [];
if(isset($_FILES["file"]))
{
	$fileName = strtotime("now").'_'.$_FILES["file"]["name"];
 	move_uploaded_file($_FILES["file"]["tmp_name"],$output_dir.$fileName);
	$arr[]= $fileName;
	
	$inputFileName = $output_dir.$fileName;
	//  Read your Excel workbook
	try {
	    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
	    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	    $objPHPExcel = $objReader->load($inputFileName);
	} catch(Exception $e) {
	    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	//  Get worksheet dimensions
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = 1;//$sheet->getHighestRow(); 
	$highestColumn = $sheet->getHighestColumn();

	//  Loop through each row of the worksheet in turn
	for ($row = 1; $row <= $highestRow; $row++){ 
	    //  Read a row of data into an array
	    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                            NULL,
		                            TRUE,
		                            FALSE);
	    //  Insert row data array into your database of choice here
		$arr[] = $rowData;
	}

		

	// Attempt create table query execution
	 $table = preg_replace(array('#[ -]+.#','/\(/','/\)/','/\./'), '_',$fileName);
	 $final = preg_replace('#[ -]+#', '_',$rowData[0]);
	$sql = "CREATE TABLE ".$table."(";
	foreach($final as $field) {
	    $sql .= ' ' . $field . ' TEXT,';
	}
	$sql .= ' primary_id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY ( `primary_id` ))';
	if(mysqli_query($link, $sql))
	{

		//  Loop through each row of the worksheet in turn
		for ($row = 2; $row <= $sheet->getHighestRow(); $row++){ 
		    //  Read a row of data into an array
		    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
			                            NULL,
			                            TRUE,
			                            FALSE);
		    //  Insert row data array into your database of choice here
			$data[] = $rowData;
		}
		foreach ($data as $key => $values) {
			foreach ($values as $key => $value) {
				$comma_separated = implode("','", $value);
				$query[] = "('".$comma_separated."')";
			}
		}
		// insert multiple rows via a php array into mysql
		mysqli_query($link,'Insert into '.$table.' ('.implode(",",$final).') VALUES  '.implode(',', $query)) ;
	}
	else {
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	    exit();
	}
}
echo json_encode($arr);

?>
