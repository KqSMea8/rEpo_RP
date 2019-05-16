<?php
class dbClass {
var $dbHost,
      $dbUser,
        $dbName,
          $dbPass,
            $dbTable,
              $dbLink,
                $resResult,
                  $dbPort;		

		 function dbClass() {
 		   global $Config;
		 
		   $Config['EncryptKey'] = '25091983';
		   $this->dbHost = $Config['DbHost'];
		   $this->dbUser = mydecrypt($Config['DbUser']);
		   $this->dbPass = mydecrypt($Config['DbPassword']);
		   $this->dbName = $Config['DbName'];
		 
		   $this->connect();
		 }
		 function connect() {
			$this->dbLink = @mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);
			if(!$this->dbLink) die("Could not connect to database. " . mysql_error());
			mysql_select_db($this->dbName) or die ("could not open db. ".mysql_error());
			mysql_query("SET TRANSACTION ISOLATION LEVEL READ COMMITTED");
			
		 }		

		function connecttodb($servername,$dbname,$dbusername,$dbpassword){
			$link=@mysql_connect ($servername,mydecrypt($dbusername),mydecrypt($dbpassword),TRUE);
			if(!$link){die("Could not connect to MySQL");}
			mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
			mysql_query("SET TRANSACTION ISOLATION LEVEL READ COMMITTED");
			return $link;
		}

		 function connect_check() {
			global $Config;
		    $this->dbName2 = $Config['DbName2'];
			if(!empty($this->dbName2)){
				$this->dbLink2 = @mysql_connect($this->dbHost, $this->dbUser, $this->dbPass,TRUE);
				return mysql_select_db($this->dbName2,$this->dbLink2);
			}		
		 }
		
		 function query($query,$output=1,$record=0) {


		   $result = mysql_query($query);
		   $this->resResult=$result;	// Added by Amit jha date : 22/03/2006 project title : allstate //
		 
		   if(!$result) die('Query failed: ' . mysql_error());
			   if ($output == 1) {
				 $results = array();
				 while($row = mysql_fetch_assoc($result)) {
				   $results[] = $row;		   
				 }
				 if($record) 
				 {
					 $this->_recordQuery(date("d-m-Y  H:m:s").' : '.$query);
				 }
		   return $results;
		   }
		   else {
			 return 0;
		   }
		 }
		
		 function getMaxID($id, $table) {
		   $query = 'SELECT MAX('. $id .') AS l_insert_id FROM '. $table ;
		   $results = $this->query($query);
		   return $results[0]['l_insert_id'];
		 }
		
		 function lastInsertId(){//$id, $table) {
		    return mysql_insert_id($this->dbLink);
		 }

		
		
		 function _recordQuery($query)
		 {
		   $filename = 'query_record.txt';
		   $fh = fopen($filename, 'a');
		   fwrite($fh, $query . "\n");
		   fclose($fh);
		 }
		 function numRows(){
			return mysql_num_rows($this->resResult);
		 }

		 function escape($str){
			 return mysql_real_escape_string($str);
		 }


		/****************************/


		function myquery($query,$output=1,$record=0) {
		   $result = mysql_query($query);
		   $this->resResult=$result;	
		  // if(!$result) die('Query failed: ' . mysql_error());
			   if ($output == 1) {
				 $results = array();
				 while($row = mysql_fetch_assoc($result)) {
				   $results[] = $row;		   
				 }
				 if($record) 
				 {
					 $this->_recordQuery(date("d-m-Y  H:m:s").' : '.$query);
				 }
		   return $results;
		   }
		   else {
			 return 0;
		   }
		 }


		function  GetFieldName($Table)
		{
			$sql = "DESCRIBE ".$Table;
			return $this->query($sql, 1);
		}

		function  SetGroupConcatLen()
		{
			$sql = 'SET GLOBAL group_concat_max_len=100000';			 
			$this->query($sql,0);
		}
			
}
?>
