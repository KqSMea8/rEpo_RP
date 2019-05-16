<?php
/*
$file = "Radius2K.pdf";
$im = new imagick($file);
$im->setImageFormat( "jpg" );

$im->writeImages("popopo.jpg",true );
*/

//echo exec('whoami');

exec("convert D://r.pdf D://r.jpg");


/*
$pdf_file = 'Radius2K.pdf';
$save_to = 'Radius2K.jpg'; 
 
exec('convert "'.$pdf_file.'" -colorspace RGB -resize 800 "'.$save_to.'"', $output, $return_var);
 
 
if($return_var == 0) { //if exec successfuly converted pdf to jpg
	print "Conversion OK";
}
else print "Conversion failed.<br />".print_r($output);
*/
?>

 