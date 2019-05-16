<?php

/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * 
 * Description: For User class
 * @param: 
 * @return: 
 */
class user extends dbClass {
/*
 * Name: user
 * Description: For Superadmin  company user managements
 * @param: 
 * @return: 
 */
	
    function getUser($arg = array(), $userID,$count=false) {   
       
        if (!empty($userID)) { 
            $sql = "SELECT *  FROM `company`  where CmpID='" . $userID . "' && ecomType!=''";
            return $this->get_row($sql);
        } else { 
               $limitval='';  
            $where='WHERE 1 && ecomType!=""';
            
          
         
            if(isset($arg['limit']) AND isset($arg['offset'])){
		  $offset=$arg['offset'];
            	$limit=$arg['limit'];
                $limitval="LIMIT $offset , $limit";
	   }

             $sql = "SELECT * , (Select Count(*) FROM company  $where) as c FROM `company` $where $limitval";   
                               
                return $this->get_results($sql);
        }
    }


    function AddUserdata($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('company', $arryDetails);
        
        $pckgID = $this->insert_id;
        return $pckgID;
    }

    function AddUserdatainorder($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('orders', $arryDetails);
        
        $ordersID = $this->insert_id;
        return $ordersID;
    }
 function AddUserEmaildata($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('user_email', $arryDetails);
        
        $ordersID = $this->insert_id;
        return $ordersID;
    }
    
    function AddUserPackagedata($arryDetails) { 
       // print_r($arryDetails);die;
        extract($arryDetails);
        $comcode = $arryDetails['userCompcode'];
        $packageid = $arryDetails['userPackageId'];
        $sql = "SELECT * FROM `user_plan` where userCompcode='" . $comcode . "'";
        $result = $this->get_row($sql);
      
        if (!empty($result)) {
            if ($result->userPackageId == $packageid) {
                // increase Exp Date And update element 
                $olddate = $result->exp_date;
                $newDays = $arryDetails['exp_date'];
                // $newDate =date('Y-m-d',strtotime($olddate."+".$newDays." days"));

                // Date format function 
                $datetime = new DateTime($olddate);
                $datetime->modify("+ " . $arryDetails['exp_date'] . " day");
                $newDate = $datetime->format('Y-m-d');
                $data=array(
                    'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    ,'exp_date'=>$newDate
                    );
               
              
                ###update data on the basis of existing package in user_plan table
                 $this->update('user_plan', $data, array('userCompcode' => $comcode));
               
                ##update data on the basis of existing package in order_payment table
                //****************************Amit Singh****************************************/
               
                $amt=$arryDetails['pckg_price']*$arryDetails['allow_user'];
               
                //********************************************************************************/
                $orderdata=array(
                    'amount'=>$amt
                    ,'package_id' => $userPackageId
                    ,'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    );
                //  print_r($orderdata);die;
                $this->update('order_payment', $orderdata, array('companycode' => $comcode));

            }else {
                // update Exp Date And update element & package id
                $datetime = new DateTime(date());
                $datetime->modify("+ " . $arryDetails['exp_date'] . " day");
                $newDate = $datetime->format('Y-m-d');
                 //$arryDetails['exp_date']=365;
                //die
                // $arryDetails['exp_date']=1;
                // $newDate =date('Y-m-d',strtotime(date('Y-m-d')."+".$arryDetails['exp_date']." days"));
               
               $data=array(
                    'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    ,'exp_date'=>$newDate
                    ,'userPackageId' => $userPackageId
                    );
             
                ##update data on the basis of existing package in user_plan table
                $this->update('user_plan', $data, array('userCompcode' => $comcode));
             
                ##update data on the basis of existing package in order_payment table
                //**************************Amit singh******************************/
                $amt=$arryDetails['pckg_price']*$arryDetails['allow_user'];
                //*********************************************************/
                $orderdata=array(
                    'amount'=>$amt
                    ,'package_id' => $userPackageId
                    ,'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    );
            
                $this->update('order_payment', $orderdata, array('companycode' => $comcode));
            }
            //  unset($arryDetails['userCompcode']);
            //  $this->update('user_plan', $arryDetails, array('userPackageId' => $userPackageId, 'userCompcode' => $comcode));
        }else {
            ##Insert data on the basis of existing package in order_payment table
            /***************************add users into amount(Amit Singh)***************************************/
            $arryDetails['pckg_price']=$arryDetails['pckg_price']*$arryDetails['allow_user'];
              
              ///**********************************************************/
            $order_data=array(
                'companycode'=>$arryDetails['userCompcode'],
                'payment_type'=>'cash',
                'txn_id'=>'NULL',
                'amount'=>$arryDetails['pckg_price'],
                'allow_user'=>$arryDetails['allow_user'],
                'package_id' => $userPackageId,             
                'plan_package_element'=>$arryDetails['plan_package_element'],
                'package_detail'=>$arryDetails['package_detail'],
                'status'=>'1',
                'date'=>date('Y-m-d h:i:s')
                );
            //print_r($order_data);die('fsgdfgfsdgfd');
            $result = $this->insert('order_payment', $order_data);
            ##Insert data on the basis of existing package in user_plan table
            unset($arryDetails['pckg_price']);
            $result = $this->insert('user_plan', $arryDetails);    
        }
        return $result;
    }
    
    function UpdateUserdata($arryDetails,$userID)
    {   
        extract($arryDetails);
        if(!empty($userID)){
        $this->update('company',$arryDetails,array('CmpID'=>$userID));
        }
        return 1;
    }

    
    function DeleteUser($userID) {
        $this->delete('company', array('CmpID' => $userID));
        return 1;
    }
    
    
    function changeUserStatus($arryDetails,$userID)
    {   
        if(!empty($arryDetails)){
            if($arryDetails['status']==1)
                    $arryDetails['status']=0;
            else
                    $arryDetails['status']=1;
            $this->update('company',$arryDetails,array('CmpID'=>$userID));					
        }
        return true;
    }
		
    function ChangePassword($arryDetails,$userID)
    {   
 
            extract($arryDetails);
            if(!empty($userID)){
            $this->update('company',$arryDetails,array('CmpID'=>$userID));
            }
            return 1;
    }		
		
    /*public function GetCompUsers($compcod,$userRoleID) {
        $sql = "SELECT * FROM `users` where userCompcode='" .$compcod ."' && userRoleID='".$userRoleID."'";
        $rajan= $this->get_results($sql);
        return $rajan;
     }
    public function FindCompUsers($compcod,$userRoleID,$vari) {
        $sql = "SELECT * FROM `users` where userCompcode='" .$compcod ."' AND userRoleID='".$userRoleID."' AND (userFname ='".$vari."' OR userEmail ='".$vari."' OR userContacts ='".$vari."')";
        $rajan= $this->get_results($sql);
        // print_r($rr);
        return $rajan;		
    }
*/

/*****************************Pagination( Ravi Solanki) edited Amit Singh**************************************************/
function pagingChat($page,$limit,$offset,$num,$totalrecords){
        
        $intLoopStartPoint = 1;
        $intLoopEndPoint= $totalrecords;
        $pageslink=$intTotalNumPage= $strURL='';
        
        if(($page) > ($totalrecords)){
            $intLoopStartPoint = $page - $num + 1;
            if (($intLoopStartPoint + $limit) <= ($num)) {
                    $intLoopEndPoint=$intLoopStartPoint + $limit - 1;
            } else {
                    $intLoopEndPoint = $totalrecords;
            }
        } 
        
        if (($num > $limit) && ($page != 1)) {
            $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=1&".$strURL."\" class=\"pagenumber\"><<</a> ";							
        }
        
        if ($intLoopStartPoint > 1) {
            $intPreviousPage=$page - 1;
            $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$intPreviousPage."&".$strURL."\" class=\"edit22\"> &lt;&lt; </a> ";			
        }	
        
        for($i=$intLoopStartPoint;$i<=$intLoopEndPoint;$i++){
            if ($page==$i) {
            //$this->strShowPaging.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$i."&".$this->strURL."\" class=\"pagenumber\"><b>".$i."</b></a> ";
                $pageslink.= '<span class="pagenumber"><b>'.$i.'</b></span> ';
            } else {
                $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$i."&".$strURL."\" class=\"pagenumber\">".$i."</a> ";
            }
            if ($i!=$intLoopEndPoint) {
                    $pageslink.=" ";
            }
        }
			
        if ($intLoopEndPoint < $intTotalNumPage) {
                $intNextPage=$page+1;
                $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$intNextPage."&".$strURL."\" class=\"edit22\"> &gt;&gt; </a> ";
        }
        
        if (($totalrecords > $limit) && ($page != $totalrecords)) {
        $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$totalrecords."&".$strURL."\" class=\"pagenumber\">>></a>";			
        }
        //echo $pageslink;
        return $pageslink;
    }
    //**************** get payment history
    function getOrderHistory($val)
    {
         $sql = "SELECT p.pckg_name, o.* FROM plan_package as p left join `orders` as o on p.pckg_id=o.package_id where CmpID='".$val."'";// where userCompcode='" .$compcod ."' && userRoleID='".$userRoleID."'";
	  $ord= $this->get_results($sql);
	  return $ord;
    }

/*****************************end Pagination**************************************************/
    /*create database dynamically*/
        function AddDatabse($DisplayName)
		{
			if(!empty($DisplayName)){
                            $db_server='localhost';
                            $db_username='erp';
                            $db_password='vstacks@123!@#';
                            $dbconnection = @mysql_connect($db_server,$db_username,$db_password);
		  if ($dbconnection) 
			global $Config;
				$DbName = 'ecommerce'."_".$DisplayName; 
                                   ECHO  $sql = 'CREATE Database IF NOT EXISTS '.$DbName;
                               
				mysql_query($sql) or die (mysql_error());
				return $DbName;
				global $Config;
				$DbName = 'ecommerce'."_".$DisplayName; 
                                 $sql = 'CREATE Database IF NOT EXISTS '.$DbName;
                               
				mysql_query($sql) or die (mysql_error());
				return $DbName;
			}
		}

		function RemoveDatabse($DbName)
		{
			if(!empty($DbName)){
				$sql = 'DROP Database IF EXISTS '.$DbName; 
				mysql_query($sql) or die (mysql_error());

			}
			return true;
		}

		function RenameDatabse($DbName)
		{	
			if(!empty($DbName)){
				$sql = 'RENAME Database '.$DbName; // Not Working
				mysql_query($sql) or die (mysql_error());
			}
			return true;
		}
        public function ImportDatabase($db_server,$db_name,$db_username,$db_password,$filename){
		
		// If Timeout errors still occure you may need to adjust the $linepersession setting in this file
		// Change fopen mode to "r" as workaround for Windows issues
		
		/*
		$db_server   = 'localhost';
		$db_name     = 'agrinde_erp_parwez';
		$db_username = 'root';
		$db_password = '';
		$filename           = 'superadmin/sql/agrinde_erp.sql';    
		*/
		
		
		$csv_insert_table   = '';     // Destination table for CSV files
		$csv_preempty_table = false;  // true: delete all entries from table specified in $csv_insert_table before processing
		$ajax               = true;   // AJAX mode: import will be done without refreshing the website
		$linespersession    = 300000;   // Lines to be executed per one import session
		$delaypersession    = 0;      // You can specify a sleep time in milliseconds after each session
									  // Works only if JavaScript is activated. Use to reduce server overrun
		
		// Allowed comment delimiters: lines starting with these strings will be dropped by BigDump
		
		$comment[]='#';                       // Standard comment lines are dropped by default
		$comment[]='-- ';
		// $comment[]='---';                  // Uncomment this line if using proprietary dump created by outdated mysqldump
		// $comment[]='CREATE DATABASE';      // Uncomment this line if your dump contains create database queries in order to ignore them
		$comment[]='/*!';                  // Or add your own string to leave out other proprietary things
		
		
		
		// Connection character set should be the same as the dump file character set (utf8, latin1, cp1251, koi8r etc.)
		// See http://dev.mysql.com/doc/refman/5.0/en/charset-charsets.html for the full list
		
		$db_connection_charset = '';
		
		
		// *******************************************************************************************
		// If not familiar with PHP please don't change anything below this line
		// *******************************************************************************************
		
		if ($ajax)
		  ob_start();
		
		define ('VERSION','0.32b');
		define ('DATA_CHUNK_LENGTH',1638400);  // How many chars are read per time
		define ('MAX_QUERY_LINES',300000);      // How many lines may be considered to be one query (except text lines)
		define ('TESTMODE',false);           // Set to true to process the file without actually accessing the database
		
		header("Expires: Mon, 1 Dec 2003 01:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		@ini_set('auto_detect_line_endings', true);
		@set_time_limit(0);
		
		if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get"))
		  @date_default_timezone_set(@date_default_timezone_get());
		
		// Clean and strip anything we don't want from user's input [0.27b]
		
		foreach ($_REQUEST as $key => $val) 
		{
		  $val = preg_replace("/[^_A-Za-z0-9-\.&= ]/i",'', $val);
		  $_REQUEST[$key] = $val;
		}
		
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
		<title>BigDump ver</title>
		<meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="CONTENT-LANGUAGE" content="EN"/>
		
		<meta http-equiv="Cache-Control" content="no-cache/"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="-1"/>
		
		</head>
		
		<body>
		
		
		<?php
		$error = false;
		$file  = false;
		
		// Get the current directory
		
		if (isset($_SERVER["CGIA"]))
		  $upload_dir=dirname($_SERVER["CGIA"]);
		else if (isset($_SERVER["ORIG_PATH_TRANSLATED"]))
		  $upload_dir=dirname($_SERVER["ORIG_PATH_TRANSLATED"]);
		else if (isset($_SERVER["ORIG_SCRIPT_FILENAME"]))
		  $upload_dir=dirname($_SERVER["ORIG_SCRIPT_FILENAME"]);
		else if (isset($_SERVER["PATH_TRANSLATED"]))
		  $upload_dir=dirname($_SERVER["PATH_TRANSLATED"]);
		else 
		  $upload_dir=dirname($_SERVER["SCRIPT_FILENAME"]);
		
		
		// Connect to the database
		
		if (!$error && !TESTMODE)
		{ $dbconnection = @mysql_connect($db_server,$db_username,$db_password);
		  if ($dbconnection) 
			$db = mysql_select_db($db_name);
                       
		  if (!$dbconnection || !$db) 
		  { echo ("<p>Database connection failed due to ".mysql_error()."</p>\n");
			$error=true;
		  }
		  if (!$error && $db_connection_charset!=='')
			@mysql_query("SET NAMES $db_connection_charset", $dbconnection);
		}
		else
		{ $dbconnection = false;
		}
		
		
		
		// Single file mode
		
		if (!$error && !isset ($_REQUEST["fn"]) && $filename!="")
		{ 
			$_REQUEST["start"]=1;
			$_REQUEST["fn"]=urlencode($filename);
			$_REQUEST["foffset"]=0;
			$_REQUEST["totalqueries"]=0;
			$_REQUEST["start"]=1;
			#echo ("<p><a href=\"".$_SERVER["PHP_SELF"]."?start=1&amp;fn=".urlencode($filename)."&amp;foffset=0&amp;totalqueries=0\">Start Import</a></p>\n");
		}
		
		
		// Open the file
		
		if (!$error && isset($_REQUEST["start"]))
		{ 
		
		// Set current filename ($filename overrides $_REQUEST["fn"] if set)
		
		  if ($filename!="")
			$curfilename=$filename;
		  else if (isset($_REQUEST["fn"]))
			$curfilename=urldecode($_REQUEST["fn"]);
		  else
			$curfilename="";
		
		// Recognize GZip filename
		
		  if (preg_match("/\.gz$/i",$curfilename)) 
			$gzipmode=true;
		  else
			$gzipmode=false;
		
		  if ((!$gzipmode && !$file=@fopen($curfilename,"r")) || ($gzipmode && !$file=@gzopen($curfilename,"r")))
		  { echo ("<p class=\"error\">Can't open ".$curfilename." for import</p>\n");
			echo ("<p>Please, check that your dump file name contains only alphanumerical characters, and rename it accordingly, for example: $curfilename.".
				   "<br>Or, specify \$filename in bigdump.php with the full filename. ".
				   "<br>Or, you have to upload the $curfilename to the server first.</p>\n");
			$error=true;
		  }
		
		// Get the file size (can't do it fast on gzipped files, no idea how)
		
		  else if ((!$gzipmode && @fseek($file, 0, SEEK_END)==0) || ($gzipmode && @gzseek($file, 0)==0))
		  { if (!$gzipmode) $filesize = ftell($file);
			else $filesize = gztell($file);                   // Always zero, ignore
		  }
		  else
		  { echo ("<p class=\"error\">I can't seek into $curfilename</p>\n");
			$error=true;
		  }
		}
		
		// *******************************************************************************************
		// START IMPORT SESSION HERE
		// *******************************************************************************************
		
		if (!$error && isset($_REQUEST["start"]) && isset($_REQUEST["foffset"]) && preg_match("/(\.(sql|gz|csv))$/i",$curfilename))
		{
		
		// Check start and foffset are numeric values
		
		  if (!is_numeric($_REQUEST["start"]) || !is_numeric($_REQUEST["foffset"]))
		  { echo ("<p class=\"error\">UNEXPECTED: Non-numeric values for start and foffset</p>\n");
			$error=true;
		  }
		
		// Empty CSV table if requested
		
		  if (!$error && $_REQUEST["start"]==1 && $csv_insert_table != "" && $csv_preempty_table)
		  { 
			$query = "DELETE FROM $csv_insert_table";
			if (!TESTMODE && !mysql_query(trim($query), $dbconnection))
			{ echo ("<p class=\"error\">Error when deleting entries from $csv_insert_table.</p>\n");
			  echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");
			  echo ("<p>MySQL: ".mysql_error()."</p>\n");
			  $error=true;
			}
		  }
		
		  
		// Print start message
		
		  if (!$error)
		  { $_REQUEST["start"]   = floor($_REQUEST["start"]);
			$_REQUEST["foffset"] = floor($_REQUEST["foffset"]);
			
			/* if (TESTMODE) 
			 echo ("<p class=\"centr\">TEST MODE ENABLED</p>\n");
			echo ("<p class=\"centr\">Processing file: <b>".$curfilename."</b></p>\n");
			echo ("<p class=\"smlcentr\">Starting from line: ".$_REQUEST["start"]."</p>\n");	*/
			
			
		  }
		
		// Check $_REQUEST["foffset"] upon $filesize (can't do it on gzipped files)
		
		  if (!$error && !$gzipmode && $_REQUEST["foffset"]>$filesize)
		  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer behind the end of file</p>\n");
			$error=true;
		  }
		
		// Set file pointer to $_REQUEST["foffset"]
		
		  if (!$error && ((!$gzipmode && fseek($file, $_REQUEST["foffset"])!=0) || ($gzipmode && gzseek($file, $_REQUEST["foffset"])!=0)))
		  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer to offset: ".$_REQUEST["foffset"]."</p>\n");
			$error=true;
		  }
		
		// Start processing queries from $file
		
		  if (!$error)
		  { $query="";
			$queries=0;
			$totalqueries=$_REQUEST["totalqueries"];
			$linenumber=$_REQUEST["start"];
			$querylines=0;
			$inparents=false;
		
		// Stay processing as long as the $linespersession is not reached or the query is still incomplete
		
			while ($linenumber<$_REQUEST["start"]+$linespersession || $query!="")
			{
		
		// Read the whole next line
		
			  $dumpline = "";
			  while (!feof($file) && substr ($dumpline, -1) != "\n" && substr ($dumpline, -1) != "\r")
			  { if (!$gzipmode)
				  $dumpline .= fgets($file, DATA_CHUNK_LENGTH);
				else
				  $dumpline .= gzgets($file, DATA_CHUNK_LENGTH);
			  }
			  if ($dumpline==="") break;
		
		
		// Stop if csv file is used, but $csv_insert_table is not set
			  if (($csv_insert_table == "") && (preg_match("/(\.csv)$/i",$curfilename)))
			  {
				echo ("<p class=\"error\">Stopped at the line $linenumber. </p>");
				echo ('<p>At this place the current query is from csv file, but $csv_insert_table was not set.');
				echo ("You have to tell where you want to send your data.</p>\n");
				$error=true;
				break;
			  }
			 
		// Create an SQL query from CSV line
		
			  if (($csv_insert_table != "") && (preg_match("/(\.csv)$/i",$curfilename)))
				$dumpline = 'INSERT INTO '.$csv_insert_table.' VALUES ('.$dumpline.');';
		
		// Handle DOS and Mac encoded linebreaks (I don't know if it will work on Win32 or Mac Servers)
		
			  $dumpline=str_replace("\r\n", "\n", $dumpline);
			  $dumpline=str_replace("\r", "\n", $dumpline);
					
		// DIAGNOSTIC
		// echo ("<p>Line $linenumber: $dumpline</p>\n");
		
		// Skip comments and blank lines only if NOT in parents
		
			  if (!$inparents)
			  { $skipline=false;
				reset($comment);
				foreach ($comment as $comment_value)
				{ if (!$inparents && (trim($dumpline)=="" || strpos ($dumpline, $comment_value) === 0))
				  { $skipline=true;
					break;
				  }
				}
				if ($skipline)
				{ $linenumber++;
				  continue;
				}
			  }
		
		// Remove double back-slashes from the dumpline prior to count the quotes ('\\' can only be within strings)
			  
			  $dumpline_deslashed = str_replace ("\\\\","",$dumpline);
		
		// Count ' and \' in the dumpline to avoid query break within a text field ending by ;
		// Please don't use double quotes ('"')to surround strings, it wont work
		
			  $parents=substr_count ($dumpline_deslashed, "'")-substr_count ($dumpline_deslashed, "\\'");
			  if ($parents % 2 != 0)
				$inparents=!$inparents;
		
		// Add the line to query
		
			  $query .= $dumpline;
		
		// Don't count the line if in parents (text fields may include unlimited linebreaks)
			 
			  if (!$inparents)
				$querylines++;
			  
		// Stop if query contains more lines as defined by MAX_QUERY_LINES
		
			  if ($querylines>MAX_QUERY_LINES)
			  {
				echo ("<p class=\"error\">Stopped at the line $linenumber. </p>");
				echo ("<p>At this place the current query includes more than ".MAX_QUERY_LINES." dump lines. That can happen if your dump file was ");
				echo ("created by some tool which doesn't place a semicolon followed by a linebreak at the end of each query, or if your dump contains ");
				echo ("extended inserts. Please read the BigDump FAQs for more infos.</p>\n");
				$error=true;
				break;
			  }
		 
		// Execute query if end of query detected (; as last character) AND NOT in parents
		
			  if (preg_match("/;$/",trim($dumpline)) && !$inparents)
			  { 
                            // echo $dbconnection; die(asdadadas);
                              if (!TESTMODE && !mysql_query(trim($query), $dbconnection))
				{ 
                                 
                                  echo ("<p class=\"error\">Error at the line $linenumber: ". trim($dumpline)."</p>\n");
				  echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");
				  echo ("<p>MySQL: ".mysql_error()."</p>\n");
				  $error=true;
				  break;
				}
                               
				$totalqueries++;
				$queries++;
				$query="";
				$querylines=0;
			  }
			  $linenumber++;
			}
		  }
		
		// Get the current file position
		
		  if (!$error)
		  { if (!$gzipmode) 
			  $foffset = ftell($file);
			else
			  $foffset = gztell($file);
			if (!$foffset)
			{ echo ("<p class=\"error\">UNEXPECTED: Can't read the file pointer offset</p>\n");
			  $error=true;
			}
		  }
		
		// Print statistics
		
		
		
		// echo ("<p class=\"centr\"><b>Statistics</b></p>\n");
		
		  if (!$error)
		  { 
			$lines_this   = $linenumber-$_REQUEST["start"];
			$lines_done   = $linenumber-1;
			$lines_togo   = ' ? ';
			$lines_tota   = ' ? ';
			
			$queries_this = $queries;
			$queries_done = $totalqueries;
			$queries_togo = ' ? ';
			$queries_tota = ' ? ';
		
			$bytes_this   = $foffset-$_REQUEST["foffset"];
			$bytes_done   = $foffset;
			$kbytes_this  = round($bytes_this/1024,2);
			$kbytes_done  = round($bytes_done/1024,2);
			$mbytes_this  = round($kbytes_this/1024,2);
			$mbytes_done  = round($kbytes_done/1024,2);
		   
			if (!$gzipmode)
			{
			  $bytes_togo  = $filesize-$foffset;
			  $bytes_tota  = $filesize;
			  $kbytes_togo = round($bytes_togo/1024,2);
			  $kbytes_tota = round($bytes_tota/1024,2);
			  $mbytes_togo = round($kbytes_togo/1024,2);
			  $mbytes_tota = round($kbytes_tota/1024,2);
			  
			  $pct_this   = ceil($bytes_this/$filesize*100);
			  $pct_done   = ceil($foffset/$filesize*100);
			  $pct_togo   = 100 - $pct_done;
			  $pct_tota   = 100;
		
			  if ($bytes_togo==0) 
			  { $lines_togo   = '0'; 
				$lines_tota   = $linenumber-1; 
				$queries_togo = '0'; 
				$queries_tota = $totalqueries; 
			  }
		
			  $pct_bar    = "<div style=\"height:15px;width:$pct_done%;background-color:#000080;margin:0px;\"></div>";
			}
			else
			{
			  $bytes_togo  = ' ? ';
			  $bytes_tota  = ' ? ';
			  $kbytes_togo = ' ? ';
			  $kbytes_tota = ' ? ';
			  $mbytes_togo = ' ? ';
			  $mbytes_tota = ' ? ';
			  
			  $pct_this    = ' ? ';
			  $pct_done    = ' ? ';
			  $pct_togo    = ' ? ';
			  $pct_tota    = 100;
			  $pct_bar     = str_replace(' ','&nbsp;','<tt>[         Not available for gzipped files          ]</tt>');
			}
			/*
			echo ("
			<center>
			<table width=\"520\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
			<tr><th class=\"bg4\"> </th><th class=\"bg4\">Session</th><th class=\"bg4\">Done</th><th class=\"bg4\">To go</th><th class=\"bg4\">Total</th></tr>
			<tr><th class=\"bg4\">Lines</th><td class=\"bg3\">$lines_this</td><td class=\"bg3\">$lines_done</td><td class=\"bg3\">$lines_togo</td><td class=\"bg3\">$lines_tota</td></tr>
			<tr><th class=\"bg4\">Queries</th><td class=\"bg3\">$queries_this</td><td class=\"bg3\">$queries_done</td><td class=\"bg3\">$queries_togo</td><td class=\"bg3\">$queries_tota</td></tr>
			<tr><th class=\"bg4\">Bytes</th><td class=\"bg3\">$bytes_this</td><td class=\"bg3\">$bytes_done</td><td class=\"bg3\">$bytes_togo</td><td class=\"bg3\">$bytes_tota</td></tr>
			<tr><th class=\"bg4\">KB</th><td class=\"bg3\">$kbytes_this</td><td class=\"bg3\">$kbytes_done</td><td class=\"bg3\">$kbytes_togo</td><td class=\"bg3\">$kbytes_tota</td></tr>
			<tr><th class=\"bg4\">MB</th><td class=\"bg3\">$mbytes_this</td><td class=\"bg3\">$mbytes_done</td><td class=\"bg3\">$mbytes_togo</td><td class=\"bg3\">$mbytes_tota</td></tr>
			<tr><th class=\"bg4\">%</th><td class=\"bg3\">$pct_this</td><td class=\"bg3\">$pct_done</td><td class=\"bg3\">$pct_togo</td><td class=\"bg3\">$pct_tota</td></tr>
			<tr><th class=\"bg4\">% bar</th><td class=\"bgpctbar\" colspan=\"4\">$pct_bar</td></tr>
			</table>
			</center>
			\n");*/
		
			//echo "Import Successfull";	exit;
			return true; exit;
			
		// Finish message and restart the script
		
			if ($linenumber<$_REQUEST["start"]+$linespersession)
			{ 
			  $error=true;
			}
			else
			{ if ($delaypersession!=0)
				echo ("<p class=\"centr\">Now I'm <b>waiting $delaypersession milliseconds</b> before starting next session...</p>\n");
				if (!$ajax) 
				  echo ("<script language=\"JavaScript\" type=\"text/javascript\">window.setTimeout('location.href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&fn=".urlencode($curfilename)."&foffset=$foffset&totalqueries=$totalqueries\";',500+$delaypersession);</script>\n");
				echo ("<noscript>\n");
				echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&amp;fn=".urlencode($curfilename)."&amp;foffset=$foffset&amp;totalqueries=$totalqueries\">Continue from the line $linenumber</a> (Enable JavaScript to do it automatically)</p>\n");
				echo ("</noscript>\n");
		   
			  echo ("<p class=\"centr\">Press <b><a href=\"".$_SERVER["PHP_SELF"]."\">STOP</a></b> to abort the import <b>OR WAIT!</b></p>\n");
			}
		  }
		  else 
			echo ("<p class=\"error\">Stopped on error</p>\n");
		
		
		
		}
		
		if ($error)
		  #echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."\">Start from the beginning</a> (DROP the old tables before restarting)</p>\n");
		
		if ($dbconnection) mysql_close($dbconnection);
		if ($file && !$gzipmode) fclose($file);
		else if ($file && $gzipmode) gzclose($file);

    }
    
    
    function AddCategorydata($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('e_categories', $arryDetails);
        
        $CategoryID = $this->insert_id;
        //echo $CategoryID; die('aaaa');
        return $CategoryID;
    }

function ImportDefaultCategory($DisplayName,$ecom_type)
	{
		if(!empty($DisplayName)){
			$db_server='localhost';
			$db_username='erp';
			$db_password='vstacks@123!@#';
			$dbconnection = @mysql_connect($db_server,$db_username,$db_password);
			if ($dbconnection)
			global $Config;
			$DbName = 'ecommerce'."_".$DisplayName;
			if($ecom_type=='leisure'){
				$categoryArray=array('Tourism','Hobbies','Activities'=>array('Camping','Pool/Beach','Hiking'), 'Events' ,'Other'  );
			}
			elseif($ecom_type=='health'){
				$categoryArray=array('Vitamins','Foods','Hygiene' ,'Other');
			}
			elseif($ecom_type=='generalmerchandise'){
				$categoryArray=array('Targeted','Non-profit','Other' );
			}
			elseif($ecom_type=='footwear'){
				$categoryArray=array('Women’s','Men’s','Kid’s' );
			}
			elseif($ecom_type=='clothing'){
				$categoryArray=array('Women’s','Men’s','Kid’s' );
			}
			elseif($ecom_type=='specialty'){
				$categoryArray=array('Industrial','Professional','Novelty','Other' );
			}
			elseif($ecom_type=='electronics'){
				$categoryArray=array('Gaming','Communication','Cameras','Audio/Visual','Toys','Other' );
			}
			elseif($ecom_type=='software'){
				$categoryArray=array('Computer','Apps','SaaS' ,'Other');
			}
			elseif($ecom_type=='sporting'){
				$categoryArray=array('Bicycles','Tennis','Soccer', 'Baseball','Football','Basketball','Fitness','Running','Walking', 'Skating','Saftey','Other');
			}
			elseif($ecom_type=='homegoods'){
				$categoryArray=array('Kitchen','Bath','Bedroom','Outdoor','Other');
			}
			elseif($ecom_type=='transportation'){
				$categoryArray=array('Car/truck','Other' );
			}
			elseif($ecom_type=='telecommunication'){
				$categoryArray=array('Cell phones','Portable devices','Other' );
			}
			elseif($ecom_type=='books'){
				$categoryArray=array('Fiction','Non-fiction','Instructional'=>array('Sport','Computer Applications','Leisure'), 'Self Help','Professional','eBooks','Puzzle','Other');
			}
			elseif($ecom_type=='restaurants'){
				$categoryArray=array('Sweets','Curry-Dal','Snacks', 'Puri Naan Paratha','Baking','Rice','Chutney Picke etc.','Other');
			}
			foreach($categoryArray as $key=>$value){
				if(is_array($value)){
					$sql = "insert into $DbName.e_categories (Name,AddedDate) values('".addslashes($key)."','".date('Y-m-d')."')";
					mysql_query($sql) or die (mysql_error());
					$last_inserted_id=mysql_insert_id();
					foreach($value as $key1=>$value1){
						$sql = "insert into $DbName.e_categories (Name,AddedDate,ParentID) values('".addslashes($value1)."','".date('Y-m-d')."','".addslashes($last_inserted_id)."')";
						mysql_query($sql) or die (mysql_error());
					}
					
				}else{
					$sql = "insert into $DbName.e_categories (Name,AddedDate) values('".addslashes($value)."','".date('Y-m-d')."')";
					mysql_query($sql) or die (mysql_error());
				}

			}

			return true;

		}
	}

}
?>
