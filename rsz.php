<?php
      /*if(!extension_loaded('imagick')) {
         dl('imagick.so');
      }*/
      $img = strip_tags($_GET['imagename']);
      if(isset($_GET['size'])) {
         $size = strip_tags($_GET['size']);
      } else {
         $size = 0;
      } 
      if(isset($_GET['vsize'])) {
         $vsize = strip_tags($_GET['vsize']);
      } else {
         $vsize = 0;
      }
      $image = new Imagick($img);
      $image->thumbnailImage($size, $vsize);
      header("Content-type: image/png");
      print $image;
   ?>