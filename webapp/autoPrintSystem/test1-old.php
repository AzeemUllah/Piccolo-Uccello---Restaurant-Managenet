<?php
/*
$fileName = '';
if(isset($_GET['id'])){
    //$fileName = rand();
    //exec("C:\wkhtmltopdf\bin\wkhtmltoimage.exe --width 400 --disable-smart-width  http://localhost/restuarant/recipt-preview-print.php?id=".$_GET['id']." C:/xampp/htdocs/restuarant/output/".$fileName.".jpg ");
    //exec("C:\ImageMagick-7.0.6-Q16\magick.exe -q C:/xampp/htdocs/restuarant/output/".$fileName.".jpg". " C:/xampp/htdocs/restuarant/output/newPDF.pdf" ,$output);
   // var_dump($output);
   // exec("C:\ImageMagick-7.0.6-Q16\convert.exe a.jpg b.pdf");
    //echo "C:/ImageMagick-7.0.6-Q16/magick.exe C:/xampp/htdocs/restuarant/output/".$fileName.".jpg". " C:/xampp/htdocs/restuarant/output/newPDF.pdf";
   // $printcmd = "java -classpath C:/xampp/htdocs/restuarant/autoPrintSystem/pdfbox-1.8.13.jar;C:/xampp/htdocs/restuarant/autoPrintSystem/commons-logging-1.2.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName POS-80 C:/xampp/htdocs/restuarant/output/749853839.jpg";
}*/


echo dirname(__FILE__);

exit;



if(isset($_POST['id'])) {

    $fileName = '';
    $fileName = date("m-d-Y-H:i:s:u") . "-OrderID-" . $_POST['id'];
    $filePath = "C:/" . $fileName;
    $fileNameImage = $filePath . ".jpg";
    $filePathPdf = $filePath . ".pdf";


    if ($_POST['type'] == 'manager') {
        exec("C:\wkhtmltopdf\bin\wkhtmltoimage.exe --width 400 --disable-smart-width  http://localhost/restuarant/recipt-preview-print.php?id=" . $_POST['id'] . " " . $fileNameImage);
        exec("C:\ImageMagick-7.0.6-9-portable-Q16-x64\convert.exe " . $fileNameImage . " " . $filePathPdf);
        $printcmd = "java -classpath A:/Workstation/htdocs/testPrint/pdfbox-1.8.13.jar;A:/Workstation/htdocs/testPrint/commons-logging-1.2.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName samsung " . $filePathPdf;
        exec($printcmd);
    } else if ($_POST['type'] == 'waiter') {

    }


}
/*
require(‘fpdf.php’);

$image = "a.jpg";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image($image,20,40,170,170);
$pdf->Output();
*/

//exec("C:\ImageMagick-7.0.6-9-portable-Q16-x64\convert.exe C:\a\a.jpg C:\a\b.pdf 2>&1",$output,$a);
//var_dump($a);


//$printcmd = "java -classpath A:/Workstation/htdocs/testPrint/pdfbox-1.8.13.jar;A:/Workstation/htdocs/testPrint/commons-logging-1.2.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName samsung A:/Workstation/htdocs/testPrint/pdf.pdf";

//exec($printcmd);

//C:\wktohtml\wkhtmltopdf\bin\wkhtmltopdf.exe http://google.com A:\google.pdf

//C:\Windows\system32>C:\wkhtmltopdf\bin\wkhtmltoimage.exe --width 400 --disable-smart-width  http://localhost/restuarant/recipt-preview-print.php?id=54 A:\google.jpg

//exec("C:\wkhtmltopdf\bin\wkhtmltopdf.exe -d 300 -L 0 -R 0 -T 0 -B 0 --page-width 10mm http://localhost/restuarant/recipt-preview-print.php?id=54 C:\a.pdf");

/*$_GET['id'] = '54';

function getRenderedHTML($path)
{
    ob_start();
    include($path);
    $var=ob_get_contents(); 
    ob_end_clean();
    return $var;
}


$html = getRenderedHTML('../inde');
echo $html;




include 'mpdf/mpdf.php';

$mpdf=new mPDF(); 


$mpdf->WriteHTML($html);
$mpdf->Output('filename.pdf','F');  

*/
?>
