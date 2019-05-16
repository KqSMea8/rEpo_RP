<?php //session_start(); ?>
<style>
    .mail_dexcel{
        font-size: 13px !important; color: red !important; margin-left: -56px;
    }
    .mail_dexcel:hover{
        text-decoration: underline!important;
    }
</style>
<body>
<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a href="viewchimpUser.php" class="fancybox add_quick">List User</a>


<div class="had">Import User From Excel</div>


<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div">	

   <div>
            
            <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                  <? if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<? if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<? } ?>
                <tr>
                    <td align="center"  >

                        <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">                 

                            	

                            <tr align="center">
                                <td  class="blackbold" valign="top" align="center"> Import Excel :<span class="red">*</span>
                                <input type="file" name="inputfile"/>
                                    
                                </td>
                                
                            </tr>
                            <tr>
                                <td align="center">
                                    <a href="Mail_champ_ImpotUser.xls" class="mail_dexcel">Sample Excel Download</a>
                                </td> 
                                
                            </tr>




                        </table></td>
                </tr>
                <tr><td align="center">
                        <input name="Submit" type="submit" class="button" value="Upload" />
                </td></tr>
                </table>
            </form></div>


</div>

	   

