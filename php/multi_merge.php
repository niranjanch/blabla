<?php
// Turn off error reporting false
error_reporting(0);
//  Include PHPExcel_IOFactory
include 'PHPExcel/IOFactory.php';
include 'PHPExcel.php';

$output_dir = "uploads/";

for ($i=0; $i < count($_POST['file_names']); ) {
	if(isset($partial_file_name))
	mergeTwoFiles($file_name,$_POST['file_names'][$i+1]);
	
	$partial_file_name = mergeTwoFiles($_POST['file_names'][$i],$_POST['file_names'][$i]);

	$i +=2;
}
function testInMergeRangeNotParent($objWorksheet, $cell)
{
    $inMergeRange = false;
    foreach($objWorksheet->getMergeCells() as $mergeRange) {
        if ($cell->isInRange($mergeRange)) {
            $range = PHPExcel_Cell::splitRange($mergeRange);
            list($startCell) = $range[0];
            if ($cell->getCoordinate() !== $startCell) {
                $inMergeRange = true;
            }
            break;
        }
    }
    return $inMergeRange;
}

function mergeTwoFiles()
{
		// Load both spreadsheet files
	$objPHPExcel1 = PHPExcel_IOFactory::load($output_dir.$_POST['file_name1']);
	$objPHPExcel2 = PHPExcel_IOFactory::load($output_dir.$_REQUEST['file_name2']);

	//  Get worksheet dimensions
	$sheet1 = $objPHPExcel1->getSheet(0); 
	$sheet2 = $objPHPExcel2->getSheet(0); 
	$highestRow1 = $objPHPExcel1->setActiveSheetIndex(0)->getHighestRow(); 
	$highestColumn1 = $sheet1->getHighestColumn();
	$highestRow2 = $sheet2->getHighestRow(); 
	$highestColumn2 = $sheet2->getHighestColumn();
	//  Loop through one row of the worksheet in turn
	for ($row = 1; $row <= 1; $row++){ 
	    //  Read a row of data into an array
	    $arr1 = $sheet1->rangeToArray('A' . $row . ':' . $highestColumn1 . $row,
		                            NULL,
		                            TRUE,
		                            FALSE);

	    $arr2 = $sheet2->rangeToArray('A' . $row . ':' . $highestColumn2 . $row,
		                            NULL,
		                            TRUE,
		                            FALSE);
	    $headers = array_values(array_unique(array_merge($arr1[0],$arr2[0])));
	}
	$objPHPExcel = new PHPExcel();
	// Set the header value to excel
	$alpha = 'A';
	for ($i = 0; $i < count($headers); $i++) {

		$objPHPExcel->getActiveSheet()->getCell($alpha.'1')->setValueExplicit($headers[$i], PHPExcel_Cell_DataType::TYPE_STRING);
		$alpha++;
	}

    //sheet 1
	$sheet1_row = $objPHPExcel1->getSheet(0)->getRowIterator(1)->current();
	$cellIterator = $sheet1_row->getCellIterator();
	$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
	foreach ($cellIterator as $cell) {
		
		if (!is_null($cell) ) {
			if($cell->getCalculatedValue() == $_POST['file_option1'] )
			{
				$worksheet_1_column = $cell->getColumn();
			}
		}
	}

	$row =2;
	//Write the data to excel
	//  Loop through each row of the worksheet in turn
	$isEmpty = true;
	while($isEmpty){
	    $cell1 = $sheet1->getCellByColumnAndRow(1, $row);
	    if ($cell1->getValue() != NULL && !testInMergeRangeNotParent($sheet1, $cell1)) 
	    {

	    	$row++;
		    //  Read a row of data into an array
		    $sheet_1_data = $sheet1->rangeToArray('A' . $row . ':' . $highestColumn1 . $row,
			                            NULL,
			                            TRUE,
			                            FALSE);

			$worksheet = $objPHPExcel2->getSheet(0);
			foreach ($worksheet->getRowIterator() as $file2_row) 
			{
				$cellIterator = $file2_row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
				foreach ($cellIterator as $cell) 
				{
					if (!is_null($cell) ) 
					{
						if($cell->getCalculatedValue() == $_POST['file_option2'] )
						{
							$worksheet_column = $cell->getColumn();
						}
						if( $cell->getColumn()== $worksheet_column && $cell->getCalculatedValue() == $objPHPExcel1->getActiveSheet()->getCell($worksheet_1_column.$row)->getValue() )
						{

							$sheet_2_data = $sheet2->rangeToArray('A' . $file2_row->getRowIndex() . ':' . $highestColumn2 . $file2_row->getRowIndex(),
				                            NULL,
				                            TRUE,
				                            FALSE);
						}
					}
				}
			}
		    $result[] = array_unique(array_merge($sheet_1_data[0],$sheet_2_data[0]));
			// destroy a single element of an array
			$sheet_1_data[0] = $sheet_2_data[0] =[];	    

	    }
	    else
	    {
	    	$isEmpty = false;
	    }

	}
	//loop ends

	// Fill worksheet from values in array
    $objPHPExcel->getActiveSheet()->fromArray($result, null, 'A2');

	// Save the spreadsheet with the merged data
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

	$objWriter->save(dirname(__FILE__).'/'.$output_dir.'result.xlsx');
}

function download($fullPath)
{
	if($fullPath) {
	    $fsize = filesize($fullPath);
	    $path_parts = pathinfo($fullPath);
	    $ext = strtolower($path_parts["extension"]);
	    switch ($ext) {
	        case "pdf":
	        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
	        header("Content-type: application/pdf"); // add here more headers for diff. extensions
	        break;
	        default;
	        header("Content-type: application/octet-stream");
	        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
	    }
	    if($fsize) {//checking if file size exist
	      header("Content-length: $fsize");
	    }
	    readfile($fullPath);
	    exit;
	}
}

echo 'Merged Succes';

?>
