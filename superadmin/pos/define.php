<?php

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * 
 */
define('_chatRoot',__DIR__);
define('WP_DEBUG',false);
define('WP_DEBUG_DISPLAY',false);

define("LOADER_MSG_L","Please wait.....<br>Loading data from server.");
define("LOADER_MSG_F","Please wait.....<br>Searching data from server.");
define("LOADER_MSG_S","Please wait.....<br>Saving data.....");
define("LOADER_MSG_P","Please wait.....<br>Processing.......");
define("LOGIN_UPDATED","Login details has been updated successfully.");

/***********************/
(empty($_GET['opt']))?($_GET['opt']=""):("");
(empty($_GET['edit']))?($_GET['edit']=""):("");
 
 ?>
