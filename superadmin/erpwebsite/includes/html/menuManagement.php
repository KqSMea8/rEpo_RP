<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>

<div class="message" align="center"><? if(!empty($_SESSION['mess_license'])) {echo $_SESSION['mess_license']; unset($_SESSION['mess_license']); }?></div>
        <ul class="site-cl">

            <li><a href="pageList.php">Page Management</a></li>

                       <li>

                <a href="menuManagement.php">Menu Management</a>

                <ul>
                    <li><a href="headerMenu.php">Header Menu</a></li>
                    <li><a href="footerSocialLinksList.php">Footer Social Link</a></li>


                </ul>

            </li>
              	<li><a href="packegeManagement.php">Package Management</a>
		<ul>

			<li><a href="managePackFeature.php">Manage Package Feature</a></li>
			<li><a href="managePackType.php">Manage Package Type</a></li>
			<li><a href="managePackages.php">Packages</a></li>


		</ul>
	</li>
			<li><a href="bannerManagement.php">Banner Management</a></li>




        </ul>

  