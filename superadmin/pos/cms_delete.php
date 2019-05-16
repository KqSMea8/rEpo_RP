<?php 
    include_once("includes/header.php");
	require_once("classes/cms.class.php");

   $RedirectURL = "cms.php";
     $objelement=new cms();
	 
  if (!empty($_GET['del_id'])) {
	  $id = $_GET['del_id'];  
	  $objelement->delete_page($id);
	  header("Location:".$RedirectURL);
		exit;
  }
  
  require_once("includes/footer.php"); 
?>