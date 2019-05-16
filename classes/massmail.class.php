<?php 

class massmail extends dbClass
{
		//constructor
		public $field_types = array();
		function massmail()
		{
			$this->dbClass();
		} 
		
		///////  Connect Save  //////
	
		
		function CreateAccountMailChimp($arg=array()){
			return $this->insert( 'c_mail_chimp_setting', $arg, $format = null );
		}
		
		function AddUserMailChimp($arg=array()){
                        //$this->PR($arg,1);
			return $this->insert( 'c_mail_chimp_users', $arg, $format = null );
			}
			
		function AddchimpSegment($arg=array()){
			return $this->insert( 'c_mail_chimp_segment', $arg, $format = null );
			}
			
		function AddchimpCampaign($arg=array()){
			return $this->insert( 'c_mail_chimp_campaigns', $arg, $format = null );
			}
                function AddchimpReport($arg=array()){
                        return $this->insert( 'c_mail_chimp_report', $arg, $format = null );
                }
		
		function GetMailchimSetting(){
	           $sql = "Select * FROM c_mail_chimp_setting";
			   return $this->query($sql);
        }
		
		function GetMailchimUser(){
			   $sql = "Select * FROM c_mail_chimp_users";
			   return $this->query($sql);
		}
		
		function GetchimpSegment($id=''){
		$strAddQuery = '';
                    if(!empty($id)){
                        $strAddQuery.=" where segment_id='$id'";
                        
                    }else{
                        
                        $strAddQuery.=" where 1";
                    }
                   
			   $sql = "Select * FROM c_mail_chimp_segment".$strAddQuery;
                           //echo $sql;
			   return $this->query($sql);
		}
		function GetchimpCampaign(){
			   $sql = "Select * FROM c_mail_chimp_campaigns ORDER BY id DESC";
                           //echo $sql;die;
			   return $this->query($sql);
		}
                function GetchimpReport(){
			   $sql = "Select campaign_id FROM c_mail_chimp_report ORDER BY id ASC";
                           //echo $sql;die;
			   return $this->query($sql);
		}
                function GetchimpTemplates($id=''){
                     $strAddQuery = '';      
                           if(!empty($id)){
                           $strAddQuery .= " where template_id='$id'";
                           }
                           else{
                               
                              $strAddQuery = " where 1";
                           }
			   $sql = "Select * FROM c_mail_chimp_templates".$strAddQuery;
                           //echo $sql;
			   return $this->query($sql);
		}
		
		function deleteMailchimUser($userId){
			
			$sql ="delete from c_mail_chimp_users where id='".$userId."'";
		
			return $this->query($sql);
			
		}
                
                function deleteMailchimTemplate($userId){
			
			$sql ="delete from c_mail_chimp_templates where template_id='".$userId."'";
                        //echo $sql;die;
			return $this->query($sql);
			
		}
      
      function deleteMailchimSegment($Id){
			
			$sql ="delete from c_mail_chimp_segment where id='".$Id."'";
		
			return $this->query($sql);
			
		}	
		
		function deleteMailchimCampaign($Id){
			
			$sql ="delete from c_mail_chimp_campaigns where id='".$Id."'";
		
			return $this->query($sql);
			
		}
                function deleteMailchimReport($Id){
			
			$sql ="delete from `c_mail_chimp_report` where campaign_id='".$Id."'";
		        //echo $sql;die;
			return $this->query($sql);
			
		}
		
		function UpdateStatusMailchimCampaign($Id){
			
			$sql ="UPDATE c_mail_chimp_campaigns SET status='send' where id='".$Id."'";
		
			return $this->query($sql);
			
		}	
		
		function getSocialUserConnect($Socialtype='twitter',$fields=array()){
			$selectfield='*';
			if(!empty($fields))
			$selectfield=implode(', ',$fields);
			$sql="Select $selectfield FROM c_socialuserconnect WHERE social_type='".$Socialtype." '";
			return $this->query($sql);
		}
		
		//********** Prepare Query ******************/
		public function prepare( $query, $args ) {
		if ( is_null( $query ) )
			return;

		// This is not meant to be foolproof -- but it will catch obviously incorrect usage.
		if ( strpos( $query, '%' ) === false ) {
			_doing_it_wrong( 'wpdb::prepare', sprintf( __( 'The query argument of %s must have a placeholder.' ), 'wpdb::prepare()' ), '3.9' );
		}

		$args = func_get_args();
		array_shift( $args );
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) );
		return @vsprintf( $query, $args );
	}
	public function insert( $table, $data, $format = null ) {
		return $this->_insert_replace_helper( $table, $data, $format, 'INSERT' );
	}
	function _insert_replace_helper( $table, $data, $format = null, $type = 'INSERT' ) {
		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) )
			return false;
		$this->insert_id = 0;
		$formats = $format = (array) $format;
		$fields = array_keys( $data );
		$formatted_fields = array();
		foreach ( $fields as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$formatted_fields[] = $form;
		}
		 $sql = "{$type} INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";
		$this->prepare( $sql, $data );
		return $this->query( $this->prepare( $sql, $data ) );
	}
	
	public function update( $table, $data, $where, $format = null, $where_format = null ) {
		if ( ! is_array( $data ) || ! is_array( $where ) )
			return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		foreach ( (array) array_keys( $data ) as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$bits[] = "`$field` = {$form}";
		}

		$where_formats = $where_format = (array) $where_format;
		foreach ( (array) array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) )
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}

		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );
		return $this->query( $this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ) );
	}
        function PR($data,$status=0){
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            if($status)
            {
                die;
            }
        }
        function filterArray($filter, $data)
                {
                    $newArray = array();
                    for($i=0; $i<count($data); $i++)
                    {   
                        
                        foreach($data[$i] as $subKey=>$subValue)
                        {
                            if(in_array($subKey, $filter))
                            {
                             
                               if(is_array($subValue))
                               {
                                   foreach($subValue as $sub1key=>$sub1Value)
                                   {
                                        if(is_array($sub1Value))
                                        {
                                            foreach($sub1Value as $sub2key=>$sub2Value)
                                            {
                                                if(!is_array($sub2Value))
                                                {   
                                                    $newArray[$i][$sub2key] = $sub2Value;
                                                }
                                            }
                                        }
                                        else
                                        {
                                             $newArray[$i][$sub1key] = $sub1Value;
                                        }
                                   }
                               }
                               else
                               {
                                   $newArray[$i][$subKey] = $data[$i][$subKey];
                               }
                                
                            }
                            
                        } 
                        //$this->PR($newArray,1);
                    }
                    
                return $this->addCsvHeader($newArray);
                }
/*function addCsvHeader($newArray){
    $tem=array();
    $temp=array();
    foreach($newArray[0] as $key=>$value){
        array_push($tem,$key);
        //echo "<pre>"; print_r($value); die;
    }
    //array_push($temp,$tem);
    array_push($newArray,$tem);
    //return $newArray;
    echo "<pre>"; print_r($newArray); die;
}*/
                
   function addCsvHeader($newArray){
        //$keyArray=array();
        //foreach($newArray[0] as $key=>$values)
       // {
        //    array_push($keyArray,$key);
        //}
        //return $this->arrayMerge($keyArray,$newArray);
       $data=array();
       $data = (!empty($newArray)) ? array_keys($newArray[0]) : '';
       array_unshift($newArray,$data);
       return $newArray;
   }
   function arrayMerge($keyArray,$dataArray)
{
    $final[0] = $keyArray;
    $j=1;
    for($i=0;$i<count($dataArray); $i++)
    {
        foreach($dataArray[$i] as $key=>$value)
        {
               
            $final[$j][$key]=$value;   
        }
    $j++;
    }
    return $final;
}

function renameArrayKey($array1,$array2){
    //$this->PR($array1,1);
    foreach($array1[0] as $key=>$value)
    {
       if(array_key_exists(trim($value),$array2))
            {
               $array1[0][$key]=$array2[$value];
           }
               
    } 
    return($array1);
}

function addNewAttribute($updatelistcmp){
  
    
    for($i=0; $i<count($updatelistcmp); $i++)
    {
        if($i==0)
        {
            array_push($updatelistcmp[0], "Send Weekday");
            
        }
        else{
             $Day=date_format(date_create($updatelistcmp[$i]['send_time']),"l");
             $updatelistcmp[$i]['Send Weekday']=$Day;
            
        }
    }
    return($updatelistcmp);
}

/*function for getdataUSER*/

function getMailChaimpUserData($param){
    
    $source=$param['userfrom'];
    if($source=="Lead")
    {
        $tablename='c_lead';
        $email="primary_email";
        $column="FirstName,LastName,".$email." as Email, leadID as id";
        $id="leadID";
    }
    elseif($source=="Contact"){
        
        $tablename='s_address_book';
        $email="Email";
        $column="FirstName,LastName,$email, AddID as id";
        $id="AddID";
    }
    elseif($source=="Customer"){
        
        $tablename='s_customers';
        $email="Email";
        $column="FirstName,LastName,$email, Cid as id";
        $id = "Cid";
    }
    else{
        
        die('Error');
    }
    
    $sql="select $column from  $tablename where  $email !=''";
    //echo $sql;die;
    return array("table"=>$tablename, "id"=>$id, "column"=>$column,"data"=>$this->query($sql,1));
    
}

function getUserImport($comma_chk,$table,$id,$column){
    
   $sql="select $column from  $table where $id in($comma_chk)";
   return $this->query($sql,1);
   
}

function InsertUserMailChamp($MailchimSetting,$fname,$lname,$email,$group_Name,$cmpId,$Mailchimp_Lists,$id){
    
    $fname=  addslashes($fname);
    $lname=  addslashes($lname);
    $email=  addslashes($email);
    
    $groups = $MailchimSetting[0]['name'];
    $merge_vars = array('FNAME' => $fname, 'LNAME' => $lname,
        'GROUPINGS' => array(array(
                'name' => $group_Name,
                'groups' => array($groups)
            )
    ));

    $batch[] = array('email' => array('email' => $email), 'merge_vars' => $merge_vars);
    //$this->PR($batch,1);
    $listsubs = $Mailchimp_Lists->batchSubscribe($cmpId, $batch, false, false, true);
    //$this->PR($listsubs,1);
    if ($listsubs['add_count'] == 1) {

        $data['fname'] = $fname;
        $data['lname'] = $lname;
        $data['euid'] = $listsubs['adds'][0]['euid'];
        $data['leid'] = $listsubs['adds'][0]['leid'];
        $data['email'] = $email;
        //$this->PR($data,1);
        $result = $this->AddUserMailChimp($data);
        //$this->PR($result,1);
        $_SESSION['message'] = '<div class="success">User successfully added.</div>';
        return 1;
    } else {
        $_SESSION['message'] = '<div class="error">' . $listsubs['errors'][0]['error'] . '</div>';
        return 0;
        //header("location:addchimpUser.php");
        //exit;
    }

    
}

//import data from Exel 
function filterExcelArray($data,$filter,$rename)
{
    //$rename = array("Firstname","Lastname","email");
   // $filter = array("firstname","lastname","email");
    $headerArray=array();
    foreach($data[1] as $key=>$value)
    {   
        $value = strtolower(preg_replace('/\s+/', '', $value));
        if(array_search($value, $filter)!==false)
        {  
            $foundKey=array_search($value, $filter);
            $headerArray[$key]=$rename[$foundKey];
            
        }
    }
    //$this->PR($headerArray);
    $i=0; $j=0;
    
    $dataArray=array();
    foreach($data as $key=>$value)
    {
        if($i>0)
        {
           foreach($value as $subKey=>$subValue)
           {   //echo "<br >headerArray with sub key-- $headerArray[$subKey]<br>";
               if($headerArray[$subKey]){
               $dataArray[$j][$headerArray[$subKey]]=$subValue;
           }
           }
           $j++;
        }
        $i++;
    }
    //die('stop');
return $dataArray;  
}
 
function GetEditchimpCampaign($id){
    $sql="SELECT c.*,d.name as tempname,e.name as segmentname FROM `c_mail_chimp_campaigns` c INNER JOIN c_mail_chimp_templates d on c.template_id =d.template_id INNER JOIN c_mail_chimp_segment e on c.segment_id =e.segment_id WHERE c.id='$id'";
    //echo $sql;
    return $this->query($sql);
    
}
/*sachin*/
function UpdateChimpCampaign($data,$id){
    
    //$fieldskeys=array_keys($data);
    //echo '<pre>';print_r($data);die('jadu');
    
  $i=0;  
    foreach($data as $key=>$values){
        if($i==0){
       $sqlup.="$key='$values'";
        }
        else{
            $sqlup.=",$key='$values'";
        }
       $i++;
    }
    //echo '<pre>';print_r($sqlup);die('jadu');
    $sql = "UPDATE `c_mail_chimp_campaigns` SET " .$sqlup. ' WHERE id='.$id;
    //echo $sql;die('hi');
    return $this->query($sql);
}
function UpdateChimpTemplate($data,$id){
    
    foreach($data as $key=>$values){
        if($i==0){
       $sqlup.="$key='$values'";
        }
        else{
            $sqlup.=",$key='$values'";
        }
       $i++;
    }
    $sql = "UPDATE `c_mail_chimp_templates` SET " .$sqlup. " WHERE template_id='$id'";
    //echo $sql;die('hi');
    return $this->query($sql);
}
function UpdateChimpSegment($data,$id){
    
    foreach($data as $key=>$values){
        if($i==0){
       $sqlup.="$key='$values'";
        }
        else{
            $sqlup.=",$key='$values'";
        }
       $i++;
    }
    $sql = "UPDATE `c_mail_chimp_segment` SET " .$sqlup. " WHERE segment_id='$id'";
    //echo $sql;die;
    return $this->query($sql);
    
}
function GetMailChampCompaignDataInCrmCampaign($id = 0, $parentType, $mode_type) {
        $strAddQuery = '';
        $strAddQuery .= (!empty($id)) ? (" where parentID='" . $id . "'") : (" where 1 ");
        $strAddQuery .= (!empty($id)) ? (" and parent_type='" . $parentType . "'") : ("  ");
        $strAddQuery .= (!empty($id)) ? (" and mode_type='" . $mode_type . "'") : ("  ");
        

        $strAddQuery .= " and deleted=0";

        $strAddQuery .= " order by sid Desc ";

        $strSQLQuery = "select `compaignID` FROM `c_compaign_sel`" . $strAddQuery;
        //echo $strSQLQuery;die;



        return $this->query($strSQLQuery, 1);
    }
 function GetMassMailType($id){
     
         $sql="SELECT `type`,`campaign_id` FROM `c_mail_chimp_campaigns` WHERE `campaign_id` IN($id) ORDER BY `id` DESC";
    
     //print_r($Id);
     //echo $sql;
         return $this->query($sql, 1);
 }
 
function DeleteMassMAilFromCrmCampaign($cmpId,$parenttype,$Modetype,$parentId){
    $sql="DELETE FROM `c_compaign_sel` WHERE `compaignID` = '$cmpId' AND `parent_type` = '$parenttype' AND `mode_type` = '$Modetype' AND `parentID` = '$parentId'";
    //echo $sql;die('hellopoi');
    return $this->query($sql, 1);
    
}
function GetchimpCampaignSummery($id){
    
    $sql="SELECT `title`,`subject` FROM `c_mail_chimp_campaigns` WHERE `campaign_id`='$id'";
    return $this->query($sql, 1);
}
function MailLastInsetID(){
    $sql="SELECT MAX(`id`) as id FROM `c_mail_chimp_report`";
    return $this->query($sql, 1);
}
function GetResentSendCampaignID($id){
    $sql="SELECT campaign_id FROM `c_mail_chimp_report` WHERE `id`=$id";
    return $this->query($sql, 1);
}

function UpdateMultipleCompaign($arrydetail) {


        extract($arrydetail);
        //print_r($campaignID);

        

            $sql = "select compaignID from c_compaign_sel where parent_type='" . $parent_type . "' and parentID='" . $parentID . "' and mode_type='" . $mode_type . "'";
            //echo $sql;die;
            //echo '<pre>';print_r($ID);die;
            $arryRow = $this->query($sql);
            foreach($arryRow as $arryrow) {
                $arryroww[].=$arryrow['compaignID'];
            }
            //echo '<pre>';print_r($arryroww);die;
            $resultD=array_diff($arryroww,$ID);
            if(!empty($resultD)){
                foreach($resultD as $resd) {
                $sqld="DELETE from c_compaign_sel where compaignID ='" . $resd . "' and parent_type='" . $parent_type . "' and parentID='" . $parentID . "'";
                //echo $sqld;die;
                $this->query($sqld);
                }
            }
            $resultI=array_diff($ID,$arryroww);
            //echo '<pre>';print_r($resultD);die;
            if (!empty($resultI)) {
               foreach($resultI as $resI) {
                $strSQLQuery = "insert into c_compaign_sel (compaignID,parent_type,parentID,mode_type ) values('" . $resI . "','" . addslashes($parent_type) . "','" . addslashes($parentID) . "','" . addslashes($mode_type) . "')";
                //echo $strSQLQuery;die;
                $this->query($strSQLQuery, 0);
               }
            }

            //echo $campaignID[$i];
        

        return true;
    }


function AddmailchimpAccount($arrydetail){
         extract($arrydetail);
         $sql="insert into c_mail_chimp_account (mail_chimp_cmpId,mail_chimp_Api_Key,group_name,groupId) values('".addslashes($mail_chimp_cmpId)."','".addslashes($mail_chimp_Api_Key)."','".addslashes($group_name)."','".addslashes($groupId)."')";
         //echo $sql;die;
         return $this->query($sql, 1);
        
    }
    function Getmailchimpaccount() {
        
        $sql="select * From c_mail_chimp_account";
        return $this->query($sql, 1);
    }
    
    function DeleteAllDataAccount(){
        $sql="DELETE From c_mail_chimp_account";
        
        
        return $this->query($sql, 1);
    }
    function DeleteAllDataAccount1(){$sql="DELETE From c_mail_chimp_campaigns"; return $this->query($sql, 1);}
    function DeleteAllDataAccount2(){$sql="DELETE From c_mail_chimp_report"; return $this->query($sql, 1);}
    function DeleteAllDataAccount3(){$sql="DELETE From c_mail_chimp_segment"; return $this->query($sql, 1);}
    function DeleteAllDataAccount4(){ $sql="DELETE From c_mail_chimp_setting"; return $this->query($sql, 1);}
    function DeleteAllDataAccount5(){$sql="DELETE From c_mail_chimp_templates"; return $this->query($sql, 1);}
    function DeleteAllDataAccount6(){$sql="DELETE From c_mail_chimp_users"; return $this->query($sql, 1);}
}//end class

?>
