        <link href="http://66.55.11.23/erp/css/admin.css" rel="stylesheet" type="text/css">
        <script language="javascript" src="http://66.55.11.23/erp/includes/global.js"></script>

<script language="JavaScript1.2" type="text/javascript">
    function validateWebToLeadForm(frm) {
    
        if(document.getElementById("FirstName") != null) {
            if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
                return false;
            }            
        }
        if(document.getElementById("LastName") != null) {
            if(!ValidateForSimpleBlank(frm.LastName, "Last Name")){
                return false;
            }            
        }
        
         if(document.getElementById("primary_email") != null) {
            if(!isEmailOpt(frm.primary_email)){
                return false;
            }            
        }
        
        if(document.getElementById("lead_source") != null) {
            if(!ValidateForSelect(frm.lead_source, "Lead Source")){
                return false;
            }            
        }
        if(document.getElementById("lead_status") != null) {
            if(!ValidateForSelect(frm.lead_status, "Lead Status")){
                return false;
            }            
        }

      


    }
</script>


        <form name="leadactionform" id="leadactionform" action="http://66.55.11.23/erp/processLead.php" onSubmit="return validateWebToLeadForm(this);" method="post">
        <h4>This is Lead Form Title</h4>
        <strong>This is Lead Form Subtitle</strong><br> 
        This is Lead Form Description <br>
           <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
            <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> First Name <span class="red">*</span> : </td>
                        <td   align="left" valign="top">
                            <input name="FirstName" type="text" class="inputbox" id="FirstName"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Last Name <span class="red">*</span> : </td>
                        <td   align="left" valign="top">
                            <input name="LastName" type="text" class="inputbox" id="LastName"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Company Name  : </td>
                        <td   align="left" valign="top">
                            <input name="company" type="text" class="inputbox" id="company"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Primary Email  : </td>
                        <td   align="left" valign="top">
                            <input name="primary_email" type="text" class="inputbox" id="primary_email"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Title  : </td>
                        <td   align="left" valign="top">
                            <input name="designation" type="text" class="inputbox" id="designation"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Product  : </td>
                        <td   align="left" valign="top">
                            <input name="ProductID" type="text" class="inputbox" id="ProductID"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Product Price  : </td>
                        <td   align="left" valign="top">
                            <input name="product_price" type="text" class="inputbox" id="product_price"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Website  : </td>
                        <td   align="left" valign="top">
                            <input name="Website" type="text" class="inputbox" id="Website"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Industry  : </td>
                        <td   align="left" valign="top">
                            <select name="Industry" class="inputbox" id="Industry" >
                                <option value="">--- Select ---</option><option value="IT" >
                IT</option><option value="Retail" >
                Retail</option><option value="Hospitality" >
                Hospitality</option><option value="Insurance" >
                Insurance</option><option value="Media" >
                Media</option><option value="Telecommunication" >
                Telecommunication</option><option value="Other" >
                Other</option></select>
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Annual Revenue [USD]  : </td>
                        <td   align="left" valign="top">
                            <input name="AnnualRevenue" type="text" class="inputbox" id="AnnualRevenue"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Number of Employees  : </td>
                        <td   align="left" valign="top">
                            <input name="NumEmployee" type="text" class="inputbox" id="NumEmployee"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Lead Source <span class="red">*</span> : </td>
                        <td   align="left" valign="top">
                            <select name="lead_source" class="inputbox" id="lead_source" >
                                <option value="">--- Select ---</option><option value="Cold call" >
                Cold call</option><option value="Word of Mouth" >
                Word of Mouth</option><option value="Website" >
                Website</option><option value="Tradeshow" >
                Tradeshow</option><option value="Conference" >
                Conference</option><option value="Direct Mail" >
                Direct Mail</option><option value="Public Relation" >
                Public Relation</option><option value="Partner" >
                Partner</option><option value="Employee" >
                Employee</option><option value="Other" >
                Other</option></select>
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Lead Status <span class="red">*</span> : </td>
                        <td   align="left" valign="top">
                            <select name="lead_status" class="inputbox" id="lead_status" >
                                <option value="">--- Select ---</option><option value="Hot" >
                Hot</option><option value="Cold" >
                Cold</option><option value="Warm" >
                Warm</option><option value="Contacted" >
                Contacted</option><option value="Contact in Future" >
                Contact in Future</option><option value="Junk Lead" >
                Junk Lead</option><option value="Lost Lead" >
                Lost Lead</option><option value="Not Contacted" >
                Not Contacted</option><option value="Attempted to Contact" >
                Attempted to Contact</option></select>
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Address  : </td>
                        <td   align="left" valign="top">
                            <textarea name="Address" id="Address" class="textarea"  ></textarea>
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Zip Code  : </td>
                        <td   align="left" valign="top">
                            <input name="ZipCode" type="text" class="inputbox" id="ZipCode"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Landline Number  : </td>
                        <td   align="left" valign="top">
                            <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Mobile  : </td>
                        <td   align="left" valign="top">
                            <input name="Mobile" type="text" class="inputbox" id="Mobile"  maxlength="50" />
                         </td>

                    </tr> <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> Description  : </td>
                        <td   align="left" valign="top">
                            <textarea name="description" id="description" class="textarea"  ></textarea>
                         </td>

                    </tr>
           <tr>
           <td align="left"></td>
           <td align="left">
           <input name="Cmp" type="hidden" id="Cmp" value="a5bfc9e07964f8dddeb95fc584cd965d"  />
           <input name="LeadSubmit" type="submit" class="button" id="LeadSubmit" value=" Submit "  />
           </td>
            </tr>
           </table>
           
           
       </form>
    