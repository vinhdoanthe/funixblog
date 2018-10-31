<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
define( 'SHORTINIT', true );
$root = dirname(dirname(dirname(dirname(__FILE__))));

require_once($root.'/wp-load.php');
require_once dirname(__FILE__) . '/PHPExcel.php';
require_once dirname(__FILE__) . '/Helper.php';
/** Include PHPExcel */

date_default_timezone_set('Asia/Bangkok');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("FUNiX")
							 ->setLastModifiedBy("FUNiX")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Export Excel");
							 
// Start print data
global $wpdb;

$helper = new Helper($wpdb);

$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];

if ($start_date == "" && $end_date == "")
		$results = $helper->loadItems();
else
	$results = $helper->loadItemsWithDate($start_date, $end_date);
	
	
// Set header column
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'STT')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Birthdate')
            ->setCellValue('D1', 'Campus')
            ->setCellValue('E1', 'Mobile Phone')
            ->setCellValue('F1', 'Email Address')
            ->setCellValue('G1', 'Majors')
            ->setCellValue('H1', 'Ngày đăng ký')
	    ->setCellValue('I1', 'Url_refer')
	    ->setCellValue('J1', 'Url_request')
->setCellValue('K1', 'Môn, chứng chỉ');

$count = 0;
// Write all the user records to the spreadsheet
$i = 1;
foreach($results as $result){
	$count++;
	$i++;
	$dt = date_create($result->submitted_time);
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $count)
            ->setCellValue('B'.$i, $result->full_name)
            ->setCellValue('C'.$i, $result->birthday)
            ->setCellValue('D'.$i, $result->campus)
            ->setCellValue('E'.$i, $result->phone_number)
            ->setCellValue('F'.$i, $result->email)
            ->setCellValue('G'.$i, $result->subject)
            ->setCellValue('H'.$i, date_format($dt,"d/m/Y"))
            ->setCellValue('I'.$i, $result->Url_refer)
	    ->setCellValue('J'.$i, $result->Url_request)
	->setCellValue('K'.$i, $result->course_certificate);
			
}					 
							 
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Danhsachdangky');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DanhSachDangKy.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>
