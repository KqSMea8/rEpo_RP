<?php
/*
$file = "Radius2K.pdf";
$im = new imagick($file);
$im->setImageFormat( "jpg" );
$im->writeImages("pop.jpg",true );

*/

//header("Content-Type: text/plain"); 
//system("convert -version");



//exec("convert Radius2K.pdf Radius2K.jpg", $output, $return_var);
exec("convert -density 200x200 -quality 100 to.php Radius2KNew.jpg", $output, $return_var);




//exec("convert -geometry 1200x1600 -density 200x200 -quality 100 Radius2K.pdf Radius2KNew.jpg", $output, $return_var);

if($return_var == 0) { 
	print "Conversion OK";
}
else print "Conversion failed.<br />".$output;

//exec("convert Radius2K.jpg -thumbnail 100x100 rt.jpg"); 
//exec("convert Radius2K.pdf -thumbnail 712x852 rt.jpg"); 

//exec("convert Radius2K.pdf -resize 1200x1200 thumb.jpg");
//exec("convert Radius2K.pdf -crop 1200x1200+10+5 thumbnail.jpg");
//exec("gs -dNOPAUSE -sDEVICE=jpeg -r144 -sOutputFile=p.jpg Radius2K.pdf");


?>
 