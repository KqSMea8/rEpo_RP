<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}


function SetCountryName(country_id,country){
		
		var NumLine = window.parent.document.getElementById("NumLine").value; 
               var ListID = $("#ListID").val();  
               
                var CountryExist = 0;

                for (var i = 1; i <= NumLine; i++) {
                    if (window.parent.document.getElementById("country_id" + i) != null) {
                            if (window.parent.document.getElementById("country_id" + i).value == country_id) {
                                CountryExist = 1;
                                break;
                            }
                    }
                }
                
                    if (CountryExist == 1) {
                     $("#msg_div").html('Country ' + country + '  has been already selected.');
                     
                    } else {
                            ResetSearch();
                            window.parent.document.getElementById("country"+ListID).value=country;
                            window.parent.document.getElementById("country_id"+ListID).value=country_id;
                            window.parent.document.getElementById("state"+ListID).style.display="block";
                            parent.jQuery.fancybox.close();
                            ShowHideLoader('1','P');
                    }


		}
		
</script>

<div class="had">
    Country List
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="center">
            <div id="msg_div" class="redmsg"></div>
        </td>
    </tr>
   
		<!--<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="ItemList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
</form>



		</td>
      </tr>-->

    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
				<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
				<div id="preview_div">

               <table <?= $table_bg ?>>

                    <tr><td colspan="3" style="padding: 0px; height: 0px;"></td></tr>
                    <?php
                    if (is_array($arryCountry)) { ?>
                   <tr>                     
                        <?php $flag = true;
                        $Line = 0;
                        foreach ($arryCountry as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;

                            ?>
                            
                                <td ><a href="Javascript:void(0)" onclick="Javascript:SetCountryName('<?=$values["country_id"]?>','<?=$values["name"]?>');"><?=$values["name"]?></a></td>
                                
                                 
                                
                           
                        <?php 
                        
                        if($Line%3 == 0){echo "</tr><tr>"; }
                        
                        } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td colspan="3"  class="no_record"><?=NO_RECORD?></td>
                        </tr>

                    <?php } ?>



                    
                </table>
		</div>
               


            </form>
        </td>
    </tr>

</table>
<input type="hidden" name="ListID" id="ListID" value="<?=$_GET["id"]?>">
