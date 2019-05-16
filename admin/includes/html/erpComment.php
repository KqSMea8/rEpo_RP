<h2><font color="darkred">	
<? if($_GET['AP']!= ""){	
echo $_GET['module'].': '. $_GET['AP'];	
  }
elseif($_GET['AR']!= ""){
	echo $_GET['module'].': '. $_GET['AR'];
	}
	elseif($_GET['po']!= ""){
	echo $_GET['module'].': '. $_GET['po'];
	}
	elseif($_GET['qo']!= ""){
	echo $_GET['module'].': '. $_GET['qo'];
	}
	elseif($_GET['so']!= ""){
	echo $_GET['module'].': '. $_GET['so'];
	}
	elseif($_GET['sq']!= ""){
	echo $_GET['module'].': '. $_GET['sq'];
	}
?> 	
</h2>	  
  
<? 

	include("includes/html/box/erp_comment_view.php");

?>


