<?php

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

#$imagem - source of image
#$dpi - resolution to convert E.g.: 72dpi or 300dpi

function px2cm($image, $dpi)
{
    #Create a new image from file or URL
    $img = ImageCreateFromJpeg($image);

    #Get image width / height
    $x = ImageSX($img);
    $y = ImageSY($img);

    #Convert to centimeter
    $h = $x * 2.05 / $dpi;
    $l = $y * 2.05 / $dpi;

    #Format a number with grouped thousands
    //$h = number_format($h, 2, ',', ' ');
    //$l = number_format($l, 2, ',', ' ');

    #add size unit
    $px2cm[] = round($h, 2);
    $px2cm[] = round($l, 2);

    #return array w values
    #$px2cm[0] = X
    #$px2cm[1] = Y    
    return $px2cm;
}
/*
  $orderId = 233;
    $directoryName = dirname(__FILE__);
		 $fileName = '';
        $fileName = date("m-d-Y-H-i-s-u") . "-OrderID-" . $orderId;
        $imageName = $fileName . ".jpg";
        exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltoimage.exe --width 400 --disable-smart-width  http://localhost/restuarant/recipt-preview-print.php?id=" . $orderId . " \"" . $directoryName . "/printData/" . $imageName . "\"");
        list($width, $height) = getimagesize($directoryName . '/printData/' . $imageName);
        $pdfSize = px2cm($directoryName . "/printData/" . $imageName, 96);
        $pdfName = $fileName . ".pdf";
        exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltopdf.exe -B 0 -L 0 -R 0 -T 0  --page-size A7 --print-media-type --page-width " . $pdfSize[0] . "cm --page-height " . $pdfSize[1] . "cm \"http://localhost/restuarant/recipt-preview-print.php?id=" . $orderId . "\" \"" . $directoryName . "/printData/" . $pdfName . "\"");
        $printcmd = '"'. $directoryName . '/dependency/Total PDF Printer Pro/PDFPrinterPro.exe" -lm 0 -tm 0 -bm 0 -rm 0 -s fitpage "'.$directoryName . '/printData/' .$pdfName.'" -p"POS-80"';
        echo $printcmd;
		exec($printcmd);

*/

if (isset($_POST['id']) && isset($_POST['type'])) {
    $orderId = $_POST['id'];
    $directoryName = dirname(__FILE__);
    if ($_POST['type'] == 'counter') {
        $fileName = '';
        $fileName = date("m-d-Y-H-i-s-u") . "-OrderID-" . $orderId;
        $imageName = $fileName . ".jpg";
        exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltoimage.exe --width 400 --disable-smart-width  http://localhost/restuarant/recipt-preview-print.php?id=" . $orderId . " \"" . $directoryName . "/printData/" . $imageName . "\"");
        list($width, $height) = getimagesize($directoryName . '/printData/' . $imageName);
        $pdfSize = px2cm($directoryName . "/printData/" . $imageName, 96);
        $pdfName = $fileName . ".pdf";
        exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltopdf.exe -B 0 -L 0 -R 0 -T 0   --print-media-type --page-width " . $pdfSize[0] . "cm --page-height " . $pdfSize[1] . "cm \"http://localhost/restuarant/recipt-preview-print.php?id=" . $orderId . "\" \"" . $directoryName . "/printData/" . $pdfName . "\"");
        $printcmd = '"'. $directoryName . '/dependency/Total PDF Printer Pro/PDFPrinterPro.exe" -lm 0 -tm 0 -bm 0 -rm 0 -s fitpage "'.$directoryName . '/printData/' .$pdfName.'" -p"POS-80"';
        exec($printcmd);
    } else if ($_POST['type'] == 'waiter') {
        //for kitchen printer
        $conn = new mysqli("localhost", "root", "", "resturant");
        $sql = "SELECT oi.*, i.* FROM `order_items` oi, `item` i where oi.order_id = ".$_POST['id']." and i.id = oi.item_id and oi.wastage_status = 'No' and oi.cancel_order = 'No' and i.location = 'Kitchen' and oi.printed = 'No'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $fileName = '';
            $fileName = date("m-d-Y-H-i-s-u") . "-OrderID-" . $orderId . "-KitchenPrint";
            $imageName = $fileName . ".jpg";
            exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltoimage.exe --width 400 --disable-smart-width  \"http://localhost/restuarant/recipt-kitchen-print.php?do=N&id=" . $orderId . "\" \"" . $directoryName . "/printData/" . $imageName . "\"");
            list($width, $height) = getimagesize($directoryName . '/printData/' . $imageName);
            $pdfSize = px2cm($directoryName . "/printData/" . $imageName, 96);
            $pdfName = $fileName . ".pdf";
            exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltopdf.exe -B 0 -L 0 -R 0 -T 0  --print-media-type --page-width " . $pdfSize[0] . "cm --page-height " . $pdfSize[1] . "cm \"http://localhost/restuarant/recipt-kitchen-print.php?id=" . $orderId . "\" \"" . $directoryName . "/printData/" . $pdfName . "\"");
            $printcmd ='"'.  $directoryName . '/dependency/Total PDF Printer Pro/PDFPrinterPro.exe" -lm 0 -tm 0 -bm 0 -rm 0  "'.$directoryName . '/printData/' .$pdfName.'" -p"POS-80"';
            exec($printcmd);
        }
        //for bar printer
        $sql = "SELECT oi.*, i.* FROM `order_items` oi, `item` i where oi.order_id = ".$_POST['id']." and i.id = oi.item_id and oi.wastage_status = 'No' and oi.cancel_order = 'No' and i.location = 'Bar' and oi.printed = 'No'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $fileName = '';
            $fileName = date("m-d-Y-H-i-s-u") . "-OrderID-" . $orderId . "-BarPrint";
            $imageName = $fileName . ".jpg";
            exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltoimage.exe --width 400 --disable-smart-width  \"http://localhost/restuarant/recipt-bar-print.php?do=N&id=" . $orderId . "\" \"" . $directoryName . "/printData/" . $imageName . "\"");
            list($width, $height) = getimagesize($directoryName . '/printData/' . $imageName);
            $pdfSize = px2cm($directoryName . "/printData/" . $imageName, 96);
            $pdfName = $fileName . ".pdf";
            exec($directoryName . "/dependency/wkhtmltopdf/bin/wkhtmltopdf.exe -B 0 -L 0 -R 0 -T 0   --print-media-type --page-width " . $pdfSize[0] . "cm --page-height " . $pdfSize[1] . "cm \"http://localhost/restuarant/recipt-bar-print.php?id=" . $orderId . "\" \"" . $directoryName . "/printData/" . $pdfName . "\"");
            $printcmd ='"'.  $directoryName . '/dependency/Total PDF Printer Pro/PDFPrinterPro.exe" -lm 0 -tm 0 -bm 0 -rm 0  "'.$directoryName . '/printData/' .$pdfName.'" -p"POS-80"';
            exec($printcmd);
        }
    }
}


//$printcmd = "java -classpath A:/Workstation/htdocs/testPrint/pdfbox-1.8.13.jar;A:/Workstation/htdocs/testPrint/commons-logging-1.2.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName samsung A:/Workstation/htdocs/testPrint/pdf.pdf";

//exec($printcmd);

//C:\wktohtml\wkhtmltopdf\bin\wkhtmltopdf.exe http://google.com A:\google.pdf

//C:\wkhtmltopdf\bin\wkhtmltoimage.exe --width 400 --disable-smart-width  http://localhost/restuarant/recipt-preview-print.php?id=54 A:\google.jpg

//exec("C:\wkhtmltopdf\bin\wkhtmltopdf.exe -d 300 -L 0 -R 0 -T 0 -B 0 --page-width 10mm http://localhost/restuarant/recipt-preview-print.php?id=54 A:\google.pdf");

/*$_GET['id'] = '54';


list($width, $height) = getimagesize('path_to_image');



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



//Done Deal
//Done Deal

//C:\Users\Developer>"C:/Total PDF Printer Pro/PDFPrinterPro.exe" -lm 0 -tm 0 -bm 0 -rm 0 -s fitpage "C:\xampp\htdocs\restuarant\autoPrintSystem\printData\09-06-2017-18-33-57-000000-OrderID-231.pdf" -p"POS-80"

?>
