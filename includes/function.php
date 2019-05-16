<?php	

	/*function CleanPost() { 
		foreach($_POST as $key => $values){
			if(is_array($values)){
				unset($_POST[$key]);
				foreach($values as $key2 => $values2){
					$_POST[$key][] = mysql_real_escape_string(strip_tags($values2));
				}
			}else if(is_string($values)){
				$temp = mysql_real_escape_string(strip_tags($values));
				$_POST[$key] = str_replace('\r\n',"\n", $temp);
			}
		} 

	}*/
function pr($data,$exit){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	if($exit) exit;	
	}
function in_array_r($search, $chkarry, $strict = false) {
    foreach ($chkarry as $value) {
        if (($strict ? $value === $search : $value == $search) || (is_array($value) && in_array_r($search, $value, $strict))) {
            return true;
        }
    }

    return false;
}
function CleanPost() { 

		$avoidCleanPost = array("description","Comment",'TemplateContent','mailcontent','Address','syncInventory','empSignature');
		foreach($_POST as $key => $values){
			if(!in_array($key, $avoidCleanPost)){
			if(is_array($values)){
				unset($_POST[$key]);
				foreach($values as $key2 => $values2){
					$_POST[$key][] = mysql_real_escape_string(strip_tags(trim($values2)));
				}
			}else if(is_string($values)){
				$temp = mysql_real_escape_string(strip_tags(trim($values)));
				$_POST[$key] = str_replace('\r\n',"\n", $temp);
			}
                             }
		} 

	}
	function CleanGet() { 
		foreach($_GET as $key => $values){
			if(!empty($values) && !is_array($values)){
				$_GET[$key] = mysql_real_escape_string(strip_tags($values)); 
			}
		} 
	}

	function CleanPostID() { 
		foreach($_POST as $key => $values){
			if(is_array($values)){
				unset($_POST[$key]);
				foreach($values as $key2 => $values2){
					$_POST[$key][] = (int)$values2;
				}
			}else if(is_string($values)){
				$_POST[$key] = (int)$values;
			}
		} 

	}

	function CleanPostMulti() { 
		 
		foreach($_POST as $key => $values){
			
			if(is_array($values)){
				unset($_POST[$key]);
								
				foreach($values as $key2 => $values2){	
							
					/********************/
					if(is_array($values2)){
						unset($_POST[$key2]);					
						foreach($values2 as $key3 => $values3){				
							$_POST[$key][$key2][$key3] = mysql_real_escape_string(strip_tags($values3));
						}
					}else if(is_string($values2)){
						$temp = mysql_real_escape_string(strip_tags($values2));
						$_POST[$key][$key2] = str_replace('\r\n',"\n", $temp);
					}
					/********************/					

				}
			}else if(is_string($values)){
				$temp = mysql_real_escape_string(strip_tags($values));
				$_POST[$key] = str_replace('\r\n',"\n", $temp);
			}
		} 

	}
	/****************************/
	function GetHourMinute($HourVal){
		$arrHour = explode(".",$HourVal);
		if($arrHour[0]>0){
			$hr = $arrHour[0];
			$HourSuff = " hrs"; $HourComma = ", ";
		}

		if($arrHour[1]>0){
			$val = '.'.$arrHour[1];
			$min = round($val*60);
			if($min>=60){
				$hr++;$min=0;
			}else{
				$Minute =  $HourComma.$min." min";
			}
		}
		$OvHour = $hr.$HourSuff.$Minute;
		return $OvHour;
	} 
	/****************************/

	// Function for checking admin session. 
	function ValidateAdminSession5555($ThisPage){	
		$Page = explode("/",$_SERVER['PHP_SELF']); 
		if(!empty($Page[4])){
			$Prefix = '../';
			$ThisPage = $Page[3]."/".$ThisPage;
		}
	
		if($_SESSION['AdminID']  == '') {
			echo '<script>location.href="'.$Prefix.'index.php?c='.$_COOKIE["DisplayNameCookie55"].'&ref='.$ThisPage.'";</script>';
			exit;
		}
	}

	// Function for checking admin session. 
	function ValidateAdminSession($ThisPage){	
		global $Config;	
		$Prefix = '';
		if(!empty($Config['DeptFolder'])){
			$Prefix = '../';
			$ThisPage = $Config['DeptFolder']."/".$ThisPage;
		}	
		if(empty($_SESSION['AdminID'])) {
			unset($_SESSION);session_destroy(); 
			$RedirectLoginUrl = $Prefix.'index.php?ref='.$ThisPage;
			header('location: '.$RedirectLoginUrl);
			exit;
		}

	}

	// Function for checking superadmin session. 
	function ValidateSuperAdminSession($ThisPage){	
		global $Config;	
		$Prefix = '';			
		if(empty($_SESSION['SuperAdminID'])) {
			unset($_SESSION);session_destroy();
			$RedirectLoginUrl = $Prefix.'index.php?ref='.$ThisPage;
			echo '<script>location.href="'.$RedirectLoginUrl.'";</script>';
			exit;
		}

	}


	// Function for checking session on frontend for loggrd in member. 
	function ValidateMemberSession($ThisPage){	
		
		if($_SESSION['MemberID']  == '' || $_SESSION['UserName']  == '' || $_SESSION['Email']  == '') {
			
			//echo '<script>location.href="login.php?ref='.$ThisPage.'";</script>';
			global $Config;
			header('location: '.$Config['Url'].'login.php?ref='.$ThisPage);
			exit;
		}
	}
	
	//Function to redirects the execution to given URL after below mentioned seconds.
	function redirect( $message, $url, $waitTime = 2, $alt = 1 ){ 
		$HTML =  " <html><head><title>Redirecting...</title><meta HTTP-EQUIV=Refresh CONTENT=\"$waitTime; URL=$url\" level='_parent'></head><body><center><IMG SRC=images/ticket_01.gif WIDTH=768 HEIGHT=143 > ";

		if( $message )
			$HTML .= "<font face=verdana><br><br><br><br><br><br><center><p style='font-face:tahoma; font-size:14px; font-weight:bold'><b>$message</b></p></center> ";

		if ($alt != 0)
			$HTML .= "<center><p style='font-face:tahoma; font-size:14px;'>If your browser cannot load the url, <a href=\"$url\" style='font-face:tahoma; font-size:14px;'>click here to continue</a>.</p></center>";

		$HTML .= " </body></html>";

		echo $HTML;
	}
	

	 function getDurationFormat($TimeDuration){
		$timeArray = explode(":",$TimeDuration);
		$time='';
		if(!empty($timeArray[0])) $time .= (int)$timeArray[0].' hr, ';
		if(!empty($timeArray[1])) $time .= (int)$timeArray[1].' min, ';
		if(!empty($timeArray[2])) $time .= (int)$timeArray[2].' sec, ';
		$time= rtrim($time,', ');
		return $time;
	}

	function SecondToHrMin($seconds){
		global $Config;
		$hours = floor($seconds / 3600);
		$min = ($seconds / 60);
		$minutes = floor($min % 60);
		$sec = round(($min - $minutes)*60); 

		if($sec>30 && $sec<60) $minutes=$minutes+1;
		if($hours<10) $hours = '0'.$hours;
		if($minutes<10) $minutes = '0'.$minutes;
		$val = $hours.":".$minutes;
 
		if(!empty($Config['DurationFormat'])){ //HH.Decimal
			$decimal = round(($minutes*100)/60);
			if($decimal<10) $decimal = '0'.$decimal;
			$val = $hours.".".$decimal;
		}

		return $val;
	}

	function SecondToHrMinMain($seconds){		 
		$hours = floor($seconds / 3600);
		$min = ($seconds / 60);
		$minutes = floor($min % 60);
		$sec = round(($min - $minutes)*60); 

		if($sec>30 && $sec<60) $minutes=$minutes+1;
		if($hours<10) $hours = '0'.$hours;
		if($minutes<10) $minutes = '0'.$minutes;
		$val = $hours.":".$minutes;

 		return $val;
	}

	function ConvertToSecond($TimeDuration){
		$timeArray = explode(":",$TimeDuration);
		$time=0;
		if(!empty($timeArray[0])) $time += (int)$timeArray[0]*3600;
		if(!empty($timeArray[1])) $time += (int)$timeArray[1]*60;
		if(!empty($timeArray[2])) $time += (int)$timeArray[2];
		
		return $time;
	}


	// Function to time difference. 
	function time_diff($s){
		$m=0;$hr=0;$d=0; //$td=$s." sec"; 
		$pref = $td = '';
		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
			$pref = ',';
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
			$pref = ',';
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			$td = "$d day"; if($d>1) $td .= "s";
			if($d<3){
				if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		

		if($s>0) $td .=  $pref." $s sec";

		return $td;
	} 

	// Function to time difference. 
	function time_diff_new($s){
		$m=0;$hr=0;$d=0; //$td=$s." sec"; 

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m m";
			$pref = ',';
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr h"; //if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m m";
			$pref = ',';
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			$td = "$d d"; if($d>1) $td .= "s";
			if($d<3){
				if($hr>0) $td .= ", $hr h"; if($hr>1) $td .= "s";
			}
		}

		

		if($s>0) $td .=  $pref." $s s";

		return $td;
	} 


	function TotalTimeDiff($s){
		$m=0;$hr=0;$d=0; //$td=$s." sec";

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
			$pref = ',';
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
			$pref = ',';
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			//$td = "$d day"; 
			if($d>1) $td .= "s";
			if($d<3){
				//if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		if($s>0) $td .=  $pref." $s sec";

		return $td;
	} 


	// Function to Get Week. 
	function GetWeek($Today,$Format){
		$arryDate = explode("-",$Today);
		list($year, $month, $day) = $arryDate;

		$NumDay = date("N",strtotime($Today));

		$tomorrow  = mktime(0, 0, 0, $month , $day+1, $year);

		for($i=1;$i<=7;$i++){
			if($i!=$NumDay){
				$DayDif = $NumDay-$i;
				$NextPrevDay  = mktime(0, 0, 0, $month , $day-$DayDif, $year);

				$ArryWeek[$i] = date($Format,$NextPrevDay);
			}else{
				$ArryWeek[$NumDay] = date($Format,strtotime($Today));
			}
		}

		return $ArryWeek;
	}


	// Function to get extension of a file. 
	function GetExtension($file){
		$revfile=strrev($file);		// Reverse the string for getting the extension
		$arr_t=explode(".",$revfile);
		$file_type=$arr_t[0];
		return strrev($file_type);  // File Extension
	}

	function mycrypt($text){
		$salt ='2210198022101980';
		return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
	}

	function mydecrypt($text){
		$salt ='2210198022101980';
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	}

	function display_price($Price){
		global $Config;

		if(empty($Config['CurrencyValue'])) $Config['CurrencyValue'] = 1;
		$Price = $Config['CurrencyValue']*$Price;
		$final_price = $Config['CurrencySymbol'].''.number_format($Price,2,'.',',').''.$Config['CurrencySymbolRight'];

		return $final_price;
	}
        
        function display_price_symbol($Price,$CurrencySymbol){
		 global $Config;
		$final_price = $CurrencySymbol.''.number_format($Price,2,'.',',');

		return $final_price;
	}

	function Alphabets($Page,$Class,$Selected){
		for($i=65;$i<=90;$i++){
			$alphabet = chr($i);
			$alph = $alphabet;
			if($alph == $Selected){
				$alphabet = '<b>'.$alph.'</b>';
			}
			
			echo '<a href="'.$Page.$alph.'" class="'.$Class.'">'.$alphabet.'</a>';
			if($i<90) echo '&nbsp;';

		}
	}
	function ClearDirectory($dir){
		if (is_dir($dir)) { 
		   if ($dh = opendir($dir)) {
			   $cnt=0;
			   while (($file = readdir($dh)) !== false) {
				   if($file !='' && strlen($file) > 2)
				   {
					  $path =  $dir.$file;
					  unlink($path);
				   }
			   }
			   closedir($dh);
		   }
		}
	}

	function GetPage(){
		$Page = explode("/",$_SERVER['PHP_SELF']); 
		/*
		if($HTTP_SERVER_VARS['HTTP_HOST']!="localhost"){
			return $Page[2];
		}else{
			return $Page[3];
		}*/
		return $Page[2];
	}

	function GetAdminPage(){  //Not required now, definded in settings.php		 
		$Page = explode("/",$_SERVER['PHP_SELF']); 
		if(!isset($Page[3])) $Page[3]='';
		$cPage = (!empty($Page[4]))?($Page[4]):($Page[3]);
		return $cPage;
	}



	function date_of_birth($date_value,$month_field,$day_field,$year_field,$class_name){

		if($date_value > 0){
			$datebirthArray = explode("-",$date_value);
			  $year_of_birth   = $datebirthArray[0];
			  $month_of_birth  = $datebirthArray[1];
			  $day_of_birth    = $datebirthArray[2];
		}


		if($month_of_birth == '01') $sel_01=' Selected'; 
		if($month_of_birth == '02') $sel_02=' Selected'; 
		if($month_of_birth == '03') $sel_03=' Selected'; 
		if($month_of_birth == '04') $sel_04=' Selected'; 
		if($month_of_birth == '05') $sel_05=' Selected'; 
		if($month_of_birth == '06') $sel_06=' Selected'; 
		if($month_of_birth == '07') $sel_07=' Selected'; 
		if($month_of_birth == '08') $sel_08=' Selected'; 
		if($month_of_birth == '09') $sel_09=' Selected'; 
		if($month_of_birth == '10') $sel_10=' Selected'; 
		if($month_of_birth == '11') $sel_11=' Selected'; 
		if($month_of_birth == '12') $sel_12=' Selected'; 


		$Month_String = '<select name="'.$month_field.'" id="'.$month_field.'" class="'.$class_name.'" style="width: 58px;">
						<option value=""> Month </option>
						<option value="01" '.$sel_01.'> Jan </option>
						<option value="02" '.$sel_02.'> Feb </option>
						<option value="03" '.$sel_03.'> March </option>
						<option value="04" '.$sel_04.'> Apr </option>
						<option value="05" '.$sel_05.'> May </option>
						<option value="06" '.$sel_06.'> June </option>
						<option value="07" '.$sel_07.'> July </option>
						<option value="08" '.$sel_08.'> Aug </option>
						<option value="09" '.$sel_09.'> Sep </option>
						<option value="10" '.$sel_10.'> Oct </option>
						<option value="11" '.$sel_11.'> Nov </option>
						<option value="12" '.$sel_12.'> Dec </option>
					</select>';

		///////////////////////////////////////
		$Day_String = ' <select name="'.$day_field.'" id="'.$day_field.'" class="'.$class_name.'" style="width: 50px;">';
				$Day_String .= '<option value="">Day</option>';
		 for($d=1;$d<=31;$d++){
				$DayVal = $d; 
				if($DayVal<10) $DayVal = '0'.$DayVal;

				if($day_of_birth == $d) $d_selected=' Selected'; else $d_selected='';

				$Day_String .= '<option value="'.$d.'" '.$d_selected.'> '.$DayVal.' </option>';
			}
		$Day_String .= ' </select>';

		////////////////////////////////////////

		$Year_String = ' <select name="'.$year_field.'" id="'.$year_field.'" class="'.$class_name.'" style="width: 50px;">';
		$c_year = date('Y');
		$start_year = 1950;
			$Year_String .= '<option value=""> Year </option>';
		 for($y=$start_year;$y<$c_year;$y++){

				if($year_of_birth == $y) $y_selected=' Selected'; else $y_selected='';

				$Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
			}
		$Year_String .= ' </select>';

		///////////////////////////////////////////
		/*
		$str = '<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"3\" align=left>
				  <tr>
					<td align=left width=\"20\">
					'.$Month_String.'&nbsp;'.$Day_String.'&nbsp;'.$Year_String.'
					</td>
				  </tr>
				</table>';
	*/
		$str = $Day_String.'&nbsp;'.$Month_String.'&nbsp;'.$Year_String;	
		return $str;
	}
	


	function getMonths($month_value,$month_field,$class_name){

		$sel_01=''; 
		$sel_02=''; 
		$sel_03=''; 
		$sel_04=''; 
		$sel_05=''; 
		$sel_06=''; 
		$sel_07=''; 
		$sel_08=''; 
		$sel_09=''; 
		$sel_10=''; 
		$sel_11=''; 
		$sel_12=''; 

		if($month_value == '01') $sel_01=' Selected'; 
		if($month_value == '02') $sel_02=' Selected'; 
		if($month_value == '03') $sel_03=' Selected'; 
		if($month_value == '04') $sel_04=' Selected'; 
		if($month_value == '05') $sel_05=' Selected'; 
		if($month_value == '06') $sel_06=' Selected'; 
		if($month_value == '07') $sel_07=' Selected'; 
		if($month_value == '08') $sel_08=' Selected'; 
		if($month_value == '09') $sel_09=' Selected'; 
		if($month_value == '10') $sel_10=' Selected'; 
		if($month_value == '11') $sel_11=' Selected'; 
		if($month_value == '12') $sel_12=' Selected'; 

		$Month_String = '<select name="'.$month_field.'" id="'.$month_field.'" class="'.$class_name.'" >
						<option value="">--- Month ---</option>
						<option value="01" '.$sel_01.'> January </option>
						<option value="02" '.$sel_02.'> February </option>
						<option value="03" '.$sel_03.'> March </option>
						<option value="04" '.$sel_04.'> April </option>
						<option value="05" '.$sel_05.'> May </option>
						<option value="06" '.$sel_06.'> June </option>
						<option value="07" '.$sel_07.'> July </option>
						<option value="08" '.$sel_08.'> August </option>
						<option value="09" '.$sel_09.'> September </option>
						<option value="10" '.$sel_10.'> October </option>
						<option value="11" '.$sel_11.'> November </option>
						<option value="12" '.$sel_12.'> December </option>
					</select>';
		
		return $Month_String;
	}


	function getYears($year_value,$year_field,$class_name){

		$Year_String = ' <select name="'.$year_field.'" id="'.$year_field.'" class="'.$class_name.'" >';
		$c_year = date('Y');
		$start_year = $c_year-20;
			$Year_String .= '<option value="">--- Year ---</option>';
		 for($y=$c_year;$y>$start_year;$y--){
				if($year_value == $y) $y_selected=' Selected'; else $y_selected='';
				$Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
			}
		$Year_String .= ' </select>';
		
		return $Year_String;
	}

	function getFinancialYear($year_value,$year_field,$class_name){

		$Year_String = ' <select name="'.$year_field.'" id="'.$year_field.'" class="'.$class_name.'" >';
		$c_year = date('Y')+1; 
		$start_year = $c_year-5;
			$Year_String .= '<option value="">--- Select Year ---</option>';
		 for($y=$c_year;$y>$start_year;$y--){
				$start = $y-1; $end = $y;
				$val = $start."-".$end; 
				if($year_value == $val) $y_selected=' Selected'; else $y_selected='';
				$Year_String .= '<option value="'.$val.'" '.$y_selected.'> '.$val.' </option>';
			}
		$Year_String .= ' </select>';
		
		return $Year_String;
	}

	function getExpireYears($year_value,$year_field,$class_name){

		$Year_String = ' <select name="'.$year_field.'" id="'.$year_field.'" class="'.$class_name.'" >';
		$c_year = date('Y');
		$end_year = $c_year+20;
			$Year_String .= '<option value="">--- Year ---</option>';
		 for($y=$c_year;$y<$end_year;$y++){
				if($year_value == $y) $y_selected=' Selected'; else $y_selected='';
				$Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
			}
		$Year_String .= ' </select>';
		
		return $Year_String;
	}



	function getWeekDay($week_value,$week_field,$class_name){

		$ts = strtotime(date("Y-m-d"));
		$year = date('o', $ts);
		$week = date('W', $ts);
		$Week_String = ' <select name="'.$week_field.'" id="'.$week_field.'" class="'.$class_name.'" >';
		$Week_String .= '<option value="">--- Select ---</option>';
		for($i=0;$i<7;$i++){
			$val = date("l", strtotime($year.'W'.$week.$i)) ;
			if($week_value == $val) $w_selected=' Selected'; else $w_selected='';
			$Week_String .= '<option value="'.$val.'" '.$w_selected.'> '.$val.' </option>';
		}
		$Week_String .= ' </select>';
		return $Week_String;
	}

	function GetWeekEndNum($WeekStart, $WeekEnd){
		$StartDay = date('N', strtotime($WeekStart));
		$EndDay = date('N', strtotime($WeekEnd));

		if($StartDay>$EndDay)$EndDay += 7;

		for($i=$StartDay;$i<=$EndDay;$i++){
			$D=$i;
			if($i>7) $D=$i-7;
			$WorkingDayArray[] = $D;
		}
		for($i=1;$i<=7;$i++){
			if(!in_array($i,$WorkingDayArray)){				
				$d=$i;
				if($i==7)$d=0;
				$WeekEnds[] = $d;
			}
		}
		return $WeekEnds;
	}

	function GetWeekEndNumMySql($WeekStart, $WeekEnd){
		$StartDay = date('N', strtotime($WeekStart));
		$EndDay = date('N', strtotime($WeekEnd));

		if($StartDay>$EndDay)$EndDay += 7;

		for($i=$StartDay;$i<=$EndDay;$i++){
			$D=$i;
			if($i>7) $D=$i-7;
			$WorkingDayArray[] = $D;
		}
		for($i=1;$i<=7;$i++){
			if(!in_array($i,$WorkingDayArray)){				
				$d=$i;
				//if($i==7)$d=0;
				$WeekEnds[] = $d-1;
			}
		}
		return $WeekEnds;
	}


	function getTimeZone($CuurentTimezone){
		$PlusMinus = substr($CuurentTimezone,0,1);
		$TimezoneValue = substr($CuurentTimezone,1,5); 

		$PlusSelected = ($PlusMinus=="+")?("selected"):("");
		$MinusSelected = ($PlusMinus=="-")?("selected"):("");
		$TimezoneHtml = '<div class="timezone">
		<select name="TimezonePlusMinus" style="border:none;color:#000;" id="TimezonePlusMinus" onchange="Javascript:GetLocalTime();">
			  <option value="+" '.$PlusSelected.'> + </option>
			  <option value="-" '.$MinusSelected.'> - </option>
		</select>
		</div>  <input name="Timezone" type="text" class="disabled" size="4" id="Timezone" value="'.$TimezoneValue.'"  autocomplete="off" onchange="Javascript:GetLocalTime();"/>
		 <br><br>UTC Time:<strong>&nbsp;&nbsp;'.gmdate("Y-m-d H:i:s").'</strong><div id="LocalTimeDiv"></div>';
		
		return $TimezoneHtml;
	}

	function getLocalTime($Timezone){
		date_default_timezone_set("UTC");
		$arryZone = explode(":",$Timezone);				
		$hour = $arryZone[0]; $minute = $arryZone[1]; 
		if(!empty($arryZone[2])) $second = $arryZone[2];
		//list($hour, $minute, $second) = $arryZone;
		$minute = ($minute*100)/60;
		$hourMinute = ($hour.'.'.$minute)*3600;

		//$CurrenTime = gmdate("Y-m-d H:i:s");
		$CurrenTime = date("Y-m-d H:i:s", time());
		
		$GMT = strtotime($CurrenTime)+$hourMinute;
		$DateTime = date("Y-m-d H:i:s",$GMT);
		return $DateTime;
	}


	function imageThumb2($filename, $imageThumbPath, $width , $height)
   	{
		
		// Get new dimensions	
		list($width_orig, $height_orig) = getimagesize($filename);

		if($height_orig >= $height){
			if ($width && ($width_orig > $height_orig)) 
			{
				$width = ($height / $height_orig) * $width_orig;
			} 
			else 
			{
				$width = ($height / $height_orig) * $width_orig;
				$height = ($width / $width_orig) * $height_orig;
			}
		}else{

			if($width_orig >= $width){
				if ($width && ($width_orig < $height_orig)) 
				{
					$width = ($height / $height_orig) * $width_orig;
				} 
				else 
				{
					$height = ($width / $width_orig) * $height_orig;
				}
			}else{
					$width = $width_orig;
					$height = $height_orig;
			}

		}



		$imageInfo = getimagesize($filename);
		$type = $imageInfo['mime'];		
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imSource = @imagecreatefromjpeg($filename);
		}
		else if ($type == 'image/gif') 
        {
          $imSource = @imagecreatefromgif($filename);
        }
		else if ($type == 'image/png') 
        {
          $imSource = @imagecreatefrompng($filename);
        }
		
		if (function_exists('imagecreatetruecolor')) {
   			$imDestination = imagecreatetruecolor($width, $height);
			} else {
   			$imDestination = imagecreate($width, $height);
		}

		imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		//$imageCreated = imagejpeg($image_p,$imageThumbPath, 100);
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imageCreated = imagejpeg($imDestination, $imageThumbPath,75);
		}
		else if ($type == 'image/gif') 
        {
			$imageCreated = imagegif($imDestination, $imageThumbPath,75);
		}	
		else if ($type == 'image/png') 
        {
			$imageCreated = imagepng($imDestination, $imageThumbPath,75);
		}	
		
		imagedestroy($imSource);
		imagedestroy($imDestination);
		
		return true;
   	}

	function imageThumb($filename, $imageThumbPath, $width , $height)
   	{
		// Get new dimensions	
		
		$backColor = 'ffffff';

		list($width_orig, $height_orig) = getimagesize($filename);
		if($width_orig >= $width){
			if ($width && ($width_orig < $height_orig)) 
			{
				$width = ($height / $height_orig) * $width_orig;
			} 
			else 
			{
				$height = ($width / $width_orig) * $height_orig;
			}
		}else{
				$width = $width_orig;
				$height = $height_orig;
		}
		$imageInfo = getimagesize($filename);
		$type = $imageInfo['mime'];		

		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imSource = @imagecreatefromjpeg($filename);
		}
		else if ($type == 'image/gif') 
        {
          $imSource = @imagecreatefromgif($filename);
        }
		else if ($type == 'image/png') 
        {
          $imSource = @imagecreatefrompng($filename);
        }
		
		if (function_exists('imagecreatetruecolor')) {
   			$imDestination = imagecreatetruecolor($width, $height);
		} else {
   			$imDestination = imagecreate($width, $height);
		}

		/////////////////////////////
		
		if($backColor != '' && $type == 'image/gif'){
			$RGBArray = html2rgb($backColor);
			$R = $RGBArray[0];
			$G = $RGBArray[1];
			$B = $RGBArray[2];
			$th_bg_color = imagecolorallocate($imDestination, $R , $G, $B);
			imagefill($imDestination, 0, 0, $th_bg_color);
			imagecolortransparent($imDestination, $th_bg_color);
		}
		
		/////////////////////////////

		imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		//$imageCreated = imagejpeg($image_p,$imageThumbPath, 100);
		
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imageCreated = imagejpeg($imDestination, $imageThumbPath,75);
		}
		else if ($type == 'image/gif') 
        {
			$imageCreated = imagegif($imDestination, $imageThumbPath,75);
		}	
		else if ($type == 'image/png') 
        {
			$imageCreated = imagepng($imDestination, $imageThumbPath,75);
		}	
		
		imagedestroy($imSource);
		imagedestroy($imDestination);
		
		
		return true;
   	}



 	function getRatingOrangeHTML($Points,$TotalPoints){
	
		$total_width = 55;
		
		if($TotalPoints>0)
			$rating = ($Points*100)/$TotalPoints;
		
		if($rating>0)
			$rating_width = round(($total_width/100)*$rating,0);


		$static_rater = '<div class="ratingblock"  align=left><div class="whitestar" style="width: '.$total_width.'px;" >';

		if($rating>0){
			$static_rater .= '<div class="yellowstar" style="width:'.$rating_width.'px;" ></div>';
		}

		$static_rater .= '</div></div>';

		return $static_rater;

	}


	function escapeSpecial($Heading){
		/*
		$Heading = str_replace("&","",$Heading);
		$Heading = str_replace(" ","_",$Heading);
		$Heading = str_replace("(","",$Heading);
		$Heading = str_replace(")","",$Heading);
		$Heading = str_replace("{","",$Heading);
		$Heading = str_replace("}","",$Heading);
		$Heading = str_replace("/","",$Heading);
		$Heading = str_replace("'","",$Heading);
		*/
		$Heading = str_replace(" ","_",$Heading);
		$Heading = preg_replace('/[.,~:>-]/', '_', $Heading);

		return $Heading;
	}

	function getRatingHTML($Points,$TotalPoints){
	
		$total_width = 55;
		
		if($TotalPoints>0)
			$rating = ($Points*100)/$TotalPoints;
		
		if($rating>0)
			$rating_width = round(($total_width/100)*$rating,0);


		$static_rater = '<div class="ratingblock" align=left><div class="whitestar" style="width: '.$total_width.'px;">';

		if($rating>0){
			$static_rater .= '<div class="yellowstar" style="width:'.$rating_width.'px;"></div>';
		}

		$static_rater .= '</div></div>';

		return $static_rater;

	}
	
	function getRatingHTMLBig($Points,$TotalPoints){
	
		$total_width = 95;
		
		if($TotalPoints>0)
			$rating = ($Points*100)/$TotalPoints;
		
		if($rating>0)
			$rating_width = round(($total_width/100)*$rating,0);


		$static_rater = '<div class="ratingblock" align=left><div class="whitestar" style="width: '.$total_width.'px;">';

		if($rating>0){
			$static_rater .= '<div class="orangestar" style="width:'.$rating_width.'px;"></div>';
		}

		$static_rater .= '</div></div>';

		return $static_rater;

	}		
	
	function html2rgb($color){ 
	
		if ($color[0] == '#')        $color = substr($color, 1);    if (strlen($color) == 6)        list($r, $g, $b) = array($color[0].$color[1],                                 $color[2].$color[3],                                 $color[4].$color[5]);    elseif (strlen($color) == 3)        list($r, $g, $b) = array($color[0], $color[1], $color[2]);    else        return false;    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);    return array($r, $g, $b);


	}

	function imageThumbOld($filename, $imageThumbPath, $width , $height)
   	{
		// Get new dimensions	
		list($width_orig, $height_orig) = getimagesize($filename);
		$width_pass = $width;
		$height_pass = $height;
		if($width_orig >= $width){
			if ($width && ($width_orig < $height_orig)) 
			{
				$width = ($height / $height_orig) * $width_orig;
			} 
			else 
			{
				$height = ($width / $width_orig) * $height_orig;
			}
		}else{
				$width = $width_orig;
				$height = $height_orig;
		}
		
		/*
		if($height_orig > $height_pass){
			$height = $height_pass;
		}*/

		$imageInfo = getimagesize($filename);
		$type = $imageInfo['mime'];		
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imSource = @imagecreatefromjpeg($filename);
		}
		else if ($type == 'image/gif') 
        {
          $imSource = @imagecreatefromgif($filename);
        }
		else if ($type == 'image/png') 
        {
          $imSource = @imagecreatefrompng($filename);
        }
		
		if (function_exists('imagecreatetruecolor')) {
   			$imDestination = imagecreatetruecolor($width, $height);
			} else {
   			$imDestination = imagecreate($width, $height);
		}

		imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		//$imageCreated = imagejpeg($image_p,$imageThumbPath, 100);
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imageCreated = imagejpeg($imDestination, $imageThumbPath,75);
		}
		else if ($type == 'image/gif') 
        {
			$imageCreated = imagegif($imDestination, $imageThumbPath,75);
		}	
		else if ($type == 'image/png') 
        {
			$imageCreated = imagepng($imDestination, $imageThumbPath,75);
		}	
		
		imagedestroy($imSource);
		imagedestroy($imDestination);
		
		return true;
   	}







function ReadFloder($dir){
	$fd = @opendir($dir);
	 while (($part = @readdir($fd)) == true) {
		if (!is_dir($part) && ($part != "." && $part != "..")) {
			 return  $Path = $dir.'/'.$part;

				/*
				if(is_file($Path)){
					 //echo $Path.' -------------------- File<br>';
					
				 }	 else{
					 //echo $Path.' --------------------- Dir<br>';
					 ReadFloder($Path);
				 }
				 */

		}
	}

}

function ReadFloderAndMove($dir,$tar){
	$fd = @opendir($dir);
	 while (($part = @readdir($fd)) == true) {
		if (!is_dir($part) && ($part != "." && $part != "..")) {
			  echo $Path = $dir.'/'.$part;
			  echo $part;
			 // copy($Path,$tar);
			/*
				if(is_file($Path)){
					 echo $Path.' -------------------- File<br>';
					
				 }	 else{
					 echo $Path.' --------------------- Dir<br>';
				 }
				*/

		}
	}

}


///////////////////////////////////////
//////////////////////////////////////

function xml2array($contents, $get_attributes=1) { 
    if(!$contents) return array(); 

    if(!function_exists('xml_parser_create')) { 
        //print "'xml_parser_create()' function not found!"; 
        return array(); 
    } 
    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create(); 
    xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 ); 
    xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 ); 
    xml_parse_into_struct( $parser, $contents, $xml_values ); 
    xml_parser_free( $parser ); 

    if(!$xml_values) return;//Hmm... 

    //Initializations 
    $xml_array = array(); 
    $parents = array(); 
    $opened_tags = array(); 
    $arr = array(); 

    $current = &$xml_array; 

    //Go through the tags. 
    foreach($xml_values as $data) { 
        unset($attributes,$value);//Remove existing values, or there will be trouble 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = ''; 
        if($get_attributes) {//The second argument of the function decides this. 
            $result = array(); 
            if(isset($value)) $result['value'] = $value; 

            //Set the attributes too. 
            if(isset($attributes)) { 
                foreach($attributes as $attr => $val) { 
                    if($get_attributes == 1) $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
                    /**  :TODO: should we change the key name to '_attr'? Someone may use the tagname 'attr'. Same goes for 'value' too */ 
                } 
            } 
        } elseif(isset($value)) { 
            $result = $value; 
        } 

        //See tag status and do the needed. 
        if($type == "open") {//The starting of the tag '<tag>' 
            $parent[$level-1] = &$current; 

            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
                $current[$tag] = $result; 
                $current = &$current[$tag]; 

            } else { //There was another element with the same tag name 
                if(isset($current[$tag][0])) { 
                    array_push($current[$tag], $result); 
                } else { 
                    $current[$tag] = array($current[$tag],$result); 
                } 
                $last = count($current[$tag]) - 1; 
                $current = &$current[$tag][$last]; 
            } 

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
            //See if the key is already taken. 
            if(!isset($current[$tag])) { //New Key 
                $current[$tag] = $result; 

            } else { //If taken, put all things inside a list(array) 
                if((is_array($current[$tag]) and $get_attributes == 0)//If it is already an array... 
                        or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1)) { 
                    array_push($current[$tag],$result); // ...push the new element into that array. 
                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value 
                } 
            } 

        } elseif($type == 'close') { //End of tag '</tag>' 
            $current = &$parent[$level-1]; 
        } 
    } 

    return($xml_array); 
} 

///////////////////////////////////////
//////////////////////////////////////	


function ImportDatabase($db_server,$db_name,$db_username,$db_password,$filename){
		global $Config;

		if($Config['Online']=='1'){			
			$Username = mydecrypt($Config['DbUser']);
			$Password = mydecrypt($Config['DbPassword']); 
			shell_exec('mysqldump -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' erpdefault | mysql -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' '.$db_name);
			return true;

		}else{
			


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
		{ $dbconnection = @mysql_connect($db_server,mydecrypt($db_username),mydecrypt($db_password));
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
			  { if (!TESTMODE && !mysql_query(trim($query), $dbconnection))
				{ echo ("<p class=\"error\">Error at the line $linenumber: ". trim($dumpline)."</p>\n");
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

}

 function escape($str)
	{
		return mysql_real_escape_string($str);
	}


	function CurrencyConvertorOld($amount,$from,$to,$Module='INV',$PostedDate=''){
		global $Config;
		$arryTime = explode(" ",$_SESSION['TodayDate']);
		$CurrentDate = ($PostedDate>0)?($PostedDate):($arryTime[0]);
		

		$ConversionRate=0;
		if($Config['RealTime']!='1'){			

			$sql = "SELECT ConversionRate FROM ".$_SESSION['CmpDatabase'].".currency_setting WHERE FromCurrency = '".$from."' and ToCurrency = '".$to."' and Module = '".$Module."'  and CASE WHEN FromDate>0 and ToDate>0 THEN  FromDate<='".$CurrentDate."' and ToDate>='".$CurrentDate."'  WHEN FromDate>0 THEN FromDate='".$CurrentDate."' ELSE 1 END = 1";
			
			$res = mysql_query($sql);
			$arry=mysql_fetch_array($res);
			$ConversionRate = $arry['ConversionRate']*$amount;
			//echo $sql.'<br>'.$ConversionRate;exit;
		}

		if($ConversionRate>0){
			$converted_amount = $ConversionRate;
		}else{
			$get = file_get_contents("https://www.google.com/finance/converter?a=".$amount."&from=".$from."&to=".$to."");
			$get = explode("<span class=bld>",$get);
			$get = explode("</span>",$get[1]);  
			$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
		}
		return $converted_amount;
	}


	function CurrencyConvertor($amount,$from,$to,$Module='INV',$PostedDate=''){
		global $Config;
		$arryTime = explode(" ",$_SESSION['TodayDate']);
		$CurrentDate = $arryTime[0];
		
		
		
		$ConversionRate=0;
		$arry['ConversionRate']=0;
		if(empty($Config['RealTime'])){			
			if(!empty($PostedDate) && $PostedDate!=$CurrentDate){
				// Get from currency_log within range
				$sql1 = "SELECT ConversionRate FROM ".$_SESSION['CmpDatabase'].".currency_log WHERE FromCurrency = '".$from."' and ToCurrency = '".$to."' and Module = '".$Module."'  and CASE WHEN FromDate>0 THEN FromDate='".$PostedDate."' WHEN UpdatedDate>0 THEN  date(UpdatedDate)<='".$PostedDate."' ELSE 1 END = 1 order by ID Desc limit 0,1 ";
				#if($_GET['BH']==1) echo $sql1; exit;
				$res1 = mysql_query($sql1);
				$arry=mysql_fetch_array($res1);


				if(empty($arry['ConversionRate'])){
					// Get first data from bottom from currency_log
					$sql2 = "SELECT ConversionRate FROM ".$_SESSION['CmpDatabase'].".currency_log WHERE FromCurrency = '".$from."' and ToCurrency = '".$to."' and Module = '".$Module."' and FromDate<0  ";
					#if($_GET['BH']==1) echo $sql2; exit;
					$res2 = mysql_query($sql2);
					$arry=mysql_fetch_array($res2);
				}
			}
			

			if(empty($arry['ConversionRate'])){
				// Get from currency_setting default
				
				$sql = "SELECT ConversionRate FROM ".$_SESSION['CmpDatabase'].".currency_setting WHERE FromCurrency = '".$from."' and ToCurrency = '".$to."' and Module = '".$Module."'  and CASE WHEN FromDate>0 THEN FromDate<='".$CurrentDate."' ELSE 1 END = 1 order by ID  DESC limit 0,1";
				#if($_GET['BH']==1) echo $sql; exit;
				$res = mysql_query($sql);
				$arry=mysql_fetch_array($res);
			}
			

			$ConversionRate = $arry['ConversionRate']*$amount;
			#if($_GET['BH']==1) echo 'sql1:'.$sql1.'<br>sql2:'.$sql2.'<br>sql3:'.$sql.'<br>'.$ConversionRate;exit;
		}

		if($ConversionRate>0){
			$converted_amount = $ConversionRate;
		}else{
			if($_SESSION['ConversionType']==1){ //swap currency
				$temp = $from;
				$from = $to;
				$to = $temp;
			} 		 		 

			/*******Delete and Get Today's rate***********/
			$arryDate = explode("-", $CurrentDate);
			$PrevMonth  = date("Y-m-d", mktime(0, 0, 0, $arryDate[1]-1 , $arryDate[2], $arryDate[0]));	
			$DeleteSql = "delete from ".$Config['DbMain'].".currency_rate where date(CreatedDate)<'".$PrevMonth."'"; 
			mysql_query($DeleteSql);
			
			$sqls = "SELECT ConversionRate FROM ".$Config['DbMain'].".currency_rate WHERE FromCurrency = '".$from."' and ToCurrency = '".$to."' and date(CreatedDate)='".$CurrentDate."'";
			#if($_GET['BH']==1) echo $sqls; exit;
			$ress = mysql_query($sqls);
			$arryS=mysql_fetch_array($ress);
			if(!empty($arryS['ConversionRate'])){ // get from db
				$converted_amount = $arryS['ConversionRate'];
			}else{	//call api		 

				/***********************/
				$url = "https://xecdapi.xe.com/v1/convert_to.json/?to=".$from."&from=".$to."&amount=1";
				$cinit = curl_init();
				curl_setopt($cinit, CURLOPT_URL, $url);
				curl_setopt($cinit, CURLOPT_HEADER,0);
				curl_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
				curl_setopt($cinit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
				curl_setopt($cinit, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($cinit, CURLOPT_TIMEOUT, 30);
				curl_setopt($cinit, CURLOPT_CUSTOMREQUEST, 'GET');  

				curl_setopt($cinit, CURLOPT_USERPWD, "virtualstackssystemsllc303099069:p6g9avhdeo5kic0h20l5fsji63");//xe 

				$response = curl_exec($cinit);
				$httpCode = curl_getinfo($cinit, CURLINFO_HTTP_CODE); 
				$info = curl_getinfo($cinit);
				$err = curl_error($cinit);  
				curl_close($cinit); 
				if($err){
					$converted_amount = '';
				}else{
	 				$converted_amount = '0';
					$jsonCardArray = json_decode($response, true);	
					if(!empty($jsonCardArray['from'][0]['mid'])){
						$converted_amount = round($jsonCardArray['from'][0]['mid'],4);
					}

					if($converted_amount>0){ // save rate in db
						$AddSql = "insert into ".$Config['DbMain'].".currency_rate values('','".$from."','".$to."','".$converted_amount."','".$_SESSION['TodayDate']."');";
						mysql_query($AddSql);
					}
				
				}
				/***************/

			}
			
		}
		return $converted_amount;
	}


	
	function GetConvertedAmount($ConversionRate, $Amount){
		global $Config;
	    	if(!empty($_SESSION['ConversionType']) || !empty($Config['ConversionType'])){
			$ConvertedAmount =  $Amount / $ConversionRate ;
		}else{
			$ConvertedAmount = $ConversionRate * $Amount;
		}
		return $ConvertedAmount;
	}

	function GetConvertedAmountReverse($ConversionRate, $Amount){
		global $Config;
	    	if(!empty($_SESSION['ConversionType']) || !empty($Config['ConversionType'])){
			$ConvertedAmount = $ConversionRate * $Amount;			
		}else{
			$ConvertedAmount =  $Amount / $ConversionRate ;
		}
		return $ConvertedAmount;
	}

	function sortMultiArrayByKey($argArray, $argKey, $argOrder=SORT_ASC){
	    foreach ($argArray as $key => $row){
	       $key_arr[$key] = trim($row[$argKey]);
	    }
	    array_multisort($key_arr, $argOrder, $argArray);
	    return $argArray;
	}


	function FullPermission($dir){
		if (is_dir($dir)) { 
		   chmod($dir,0777);	
		   if ($dh = opendir($dir)) {
			   $cnt=0;
			   while (($file = readdir($dh)) !== false) {
				   if($file !='' && strlen($file) > 2)
				   {
					  $path =  $dir.$file;
					  chmod($path,0777);	
				   }
			   }
			   closedir($dh);
		   }
		}
	}

	function get_browser_info(){
	    $user_agent = $_SERVER['HTTP_USER_AGENT'];
	    $browsers = array(
		                'Chrome' => array('Google Chrome','Chrome/(.*)\s'),
		                'MSIE' => array('Internet Explorer','MSIE\s([0-9\.]*)'),
		                'Firefox' => array('Firefox', 'Firefox/([0-9\.]*)'),
		                'Safari' => array('Safari', 'Version/([0-9\.]*)'),
		                'Opera' => array('Opera', 'Version/([0-9\.]*)')
		                ); 
		                 
	    $browser_details = array();
	     
		foreach ($browsers as $browser => $browser_info){
		    if (preg_match('@'.$browser.'@i', $user_agent)){
		        $browser_details['name'] = $browser_info[0];
		            preg_match('@'.$browser_info[1].'@i', $user_agent, $version);
		        $browser_details['version'] = $version[1];
		            break;
		    } else {
		        $browser_details['name'] = 'Unknown';
		        $browser_details['version'] = 'Unknown';
		    }
		}
	     
	    return  $browser_details['name'].' : '.$browser_details['version'];
	}
	//echo get_browser_info();


	function GenerateKeyString() {
		    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		    $segment_chars = 5;
		    $num_segments = 40;
		    $key_string = '';
		 
		    for ($i = 0; $i < $num_segments; $i++) {
		 
			$segment = '';
		 
			for ($j = 0; $j < $segment_chars; $j++) {
				$segment .= $tokens[rand(0, 35)];
			}
		 
			$key_string .= $segment;
		 
			if ($i < ($num_segments - 1)) {
				$key_string .= '-';
			}
		 
		    }
		 
		    return $key_string;

	}


	
function convert_number_to_words($number) {
    
    $hyphen      = ' ';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }
    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
     
        default: 
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}




function ConvertNumberToWordsUS($number) {
     
    $hyphen      = ' ';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $dollar     = ' dollar ';
    $dollars     = ' dollars ';
    $decimal     = ' cent ';
     $decimals     = ' cents ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'ConvertNumberToWordsUS only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . ConvertNumberToWordsUS(abs($number));
    }
    
    $string = $string2 = $fraction = null;
   
    if (strpos($number, '.') !== false) {	
        list($number, $fraction) = explode('.', $number);
 	 
	 if($fraction<10 && strlen($fraction)==1) $fraction = $fraction.'0';
	 $fraction = ltrim($fraction,"0");
	 
    }


    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];

            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . ConvertNumberToWordsUS($remainder);
            }
            break;
     
        default: 
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = ConvertNumberToWordsUS($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= ConvertNumberToWordsUS($remainder);
            }
            break;
    }

	// echo $string;exit;

 	
     
 

    if (null !== $fraction && is_numeric($fraction)) {

	    $string .= ($number>1)?($dollars):($dollar);

        /*$words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
		echo $number;exit;
        }
        $string .= implode(' ', $words);*/
	 


 switch (true) {
        case $fraction < 21:
            $string2 = $dictionary[$fraction];
            break;
        case $fraction < 100:  
            $tens   = ((int) ($fraction / 10)) * 10;
            $units  = $fraction % 10;
            $string2 = $dictionary[$tens];
            if ($units) {
                $string2 .= $hyphen . $dictionary[$units];
            }
		 
            break;
        case $fraction < 1000:
            $hundreds  = $fraction / 100;
            $remainder = $fraction % 100;
            $string2 = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string2 .= $conjunction . ConvertNumberToWordsUS($remainder);
            }
            break;
     
        default: 
            $baseUnit = pow(1000, floor(log($fraction, 1000)));
            $numBaseUnits = (int) ($fraction / $baseUnit);
            $remainder = $fraction % $baseUnit;
            $string2 = ConvertNumberToWordsUS($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string2 .= $remainder < 100 ? $conjunction : $separator;
                $string2 .= ConvertNumberToWordsUS($remainder);
            }
            break;
    }

 //echo $string2;exit;
	 $string .= $string2;


	$string .= ($fraction>1)?($decimals):($decimal);
	
	 
    }	
    
    return $string;
}

	

  function GetIPAddress() {
	return (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))?($_SERVER["HTTP_X_FORWARDED_FOR"]):($_SERVER["REMOTE_ADDR"]);
  }



 function ConvertNumberToWords($number) {
	
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  $string = $result . $points ;
  return $string;
}


 

 
function ArrayMultiSerach($text,$array,$parentKey) { 

	if(!empty($array)){
		foreach($array as $key=>$val){
			if(is_array($val)){

			if(key($val)==$text) return true; 

			foreach($val[key($val)] as $key1=>$val1){
			if(is_array($val1)){
				foreach($val1 as $key2=>$val2){

					if($key2==$text) { return true; }
					elseif(is_array($val2)){
						foreach($val2 as $key3=>$val3){
							if($val3==$text) return true; 
						}
					}
				}
			}
					elseif($val1==$text && $parentKey==key($val)) return true; 
				}

			}else{
			if($val==$text) return true;
			}

		}
	}
	return false;      

}
 


function SplitAddress($Address){
	$arryAddress = explode("," , stripslashes($Address));
	$countAdd = 0;
	$AddHtml = '';
	foreach($arryAddress as $add){
		$countAdd++;
		if($countAdd==3) $AddHtml .=  '<br>';
		$AddHtml .=  $add. ", ";
		
	}
	$AddHtml =  rtrim($AddHtml,", ");
	return $AddHtml;
}

function unserializeForm($str) {
    $strArray = explode("&", $str);
    $returndata='';
    foreach($strArray as $item) {
        $array = explode("=", $item);
        $returndata[] = $array;
    }
    return $returndata;
}



  	function CheckLoginStatus($arryUserLogin){ 
		extract($arryUserLogin);
		$Duration = 0;$ViewDuration='';$CheckHide = ''; $Status='Online';$stClass = 'green';
		$Today= date("Y-m-d");
		//echo $LoginTime.'#'.$LogoutTime.'#'.$Kicked;exit;

		if($LastViewTime>0 && $LogoutTime<=0 && $SessionTimeout>0){
			$ViewDuration = strtotime($CurrentCmpTime) - strtotime($LastViewTime);		   
		}

		if($LogoutTime > 0){
			$Status = 'Offline';$stClass = 'red';
			$CheckHide = 'style = "display:none"';
			return array($Status,$stClass,$CheckHide);	
		}elseif($Kicked == 1){ 
			$Status = 'Kicked';$stClass = 'red';
			$CheckHide = 'style = "display:none"';
			return array($Status,$stClass,$CheckHide);
		}elseif($LoginTime < $Today){ 
			$Status = 'Offline';$stClass = 'red';
			$CheckHide = 'style ="display:none"';
			return array($Status,$stClass,$CheckHide);
		}else if($ViewDuration>$SessionTimeout){
			$Status = 'Offline';$stClass = 'red';
			$CheckHide = 'style ="display:none"';
			return array($Status,$stClass,$CheckHide);
		}else{  
			return array($Status,$stClass,$CheckHide);
		}
	
	}

	function GetAgingDay($InvoiceDate){
		$Days  = (strtotime(date('Y-m-d')) - strtotime($InvoiceDate))/(24*3600);
		$AgingDay = 0;
		if($Days<=29){
			$AgingDay = 1;
		}else if($Days>=30 && $Days<=59){
			$AgingDay = 2;
		}else if($Days>=60 && $Days<=89){
			$AgingDay = 3;
		}else if($Days>=90 && $Days<=119){
			$AgingDay = 4;
		}else if($Days>=120 && $Days<=600){
			$AgingDay = 5;
		}
		return $AgingDay;
	}

	function CheckCardExpiry($ExpiryMonth,$ExpiryYear){
		$ExpiryStatus='';		 
		if($ExpiryMonth>0 && $ExpiryYear>0){ 
			global $Config;
			$NumDayMonth = date('t', strtotime($ExpiryYear.'-'.$ExpiryMonth.'-01'));
			$ExpiryOn = $ExpiryYear.'-'.$ExpiryMonth.'-'.$NumDayMonth;
			$Days = round((strtotime($ExpiryOn) - strtotime($Config["TodayDate"]))/(24*3600));

			if($Days>0 && $Days<=60){
				$ExpiryStatus = '<div class=expires>Expires Soon</div>';
			}else if($Days<=0){
				$ExpiryStatus = '<div class=expired>Expired</div>';
			}
		}
		return $ExpiryStatus;
	}

	function CreditCardNoX($CardNumber,$CardType){	
		if(!empty($CardNumber) && !empty($CardType)){	 
			$arryCardNumber = explode("-",$CardNumber);
			if($CardType=='Amex'){
				$CreditCardTemp = 'xxxx-xxxxxx-'.$arryCardNumber[2];
			}else{
				$CreditCardTemp = 'xxxx-xxxx-xxxx-'.$arryCardNumber[3];
			}
			return $CreditCardTemp;
		}
	}

	function CreditCardNoLast($CardNumber,$CardType){	
		if(!empty($CardNumber) && !empty($CardType)){	 
			$arryCardNumber = explode("-",$CardNumber);
			if($CardType=='Amex'){
				$CreditCardTemp =  $arryCardNumber[2];
			}else{
				$CreditCardTemp =  $arryCardNumber[3];
			}
			return $CreditCardTemp;
		}
	}


	function SetOsDir(){
		global $Config;
		$PrefixOsDir ='';
		if(strlen($Config['CmpID'])=='1'){
			$PrefixOsDir='00';
		}else if(strlen($Config['CmpID'])=='2'){
			$PrefixOsDir='0';
		} 
		$Config['OsDir'] = $PrefixOsDir.$Config['CmpID'];
	}


	function PreviewImage($PreviewArray) { 
		global $Config;
	
		extract($PreviewArray);
		 
		
		$FilePath = $Folder.$FileName;
		if($Config['ObjectStorage'] == "1"){
			SetOsDir();
			$RespCode=0;
			if(!empty($FileName)){
				$FullPath = $Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath;
				//$contentFile = file_get_contents($FullPath);
				$headers = get_headers($FullPath, TRUE);
				$arryHead = explode(" ",$headers['0']);
				if(!empty($arryHead[1])) $RespCode = $arryHead[1];
			}
			if($RespCode=="200"){
		     		$filesize = $headers['Content-Length'];
			}
			$FullUrl = $FullPath;
		}else{
			$FullPath = $Config['RootUploadDir'].$Config['CmpID']."/".$FilePath;
			$FullUrl = $Config['RootUploadUrl'].$Config['CmpID']."/".$FilePath;
			$filesize=0;
			if(!empty($FileName)){
				$filesize = @filesize($FullPath);
			}

			//$FullPath = $Config['CmpID']."/".$FilePath;
		}
		 	
		if(empty($Params)) $Params='';
 
		if(!empty($filesize) && !empty($FileName)){

			if(empty($Width)){
				$ImgPath = $FullUrl;
				$Image = '<img src="'.$ImgPath.'" border="0" alt="'.$FileTitle.'" title="'.$FileTitle.'" '.$Params.' >';
			}else{
				$ImgPath = 'resizeimage.php?w='.$Width.'&h='.$Height.'&img='.$FullPath;
				$Image = '<img src="'.$ImgPath.'" border="0"  alt="'.$FileTitle.'" title="'.$FileTitle.'" '.$Params.'>';
			}

			if(!empty($GetImagePath)){
				return $ImgPath;
			}

			if(isset($Link) && $Link==1){
				$PrevHtml = '<a class="fancybox" title="'.$FileTitle.'" data-fancybox-group="gallery" href="'.$FullUrl.'"  >'.$Image.'</a>';	
			}else{
				$PrevHtml = $Image;
			}	
		}else if(!empty($NoImage)){
			$PrevHtml = '<img src="resizeimage.php?w='.$Width.'&h='.$Height.'&img='.$NoImage.'" border=0 id="ImageV" alt="'.$FileTitle.'" title="'.$FileTitle.'" '.$Params.'>';
		}else{
			$PrevHtml = '';
		}

		return $PrevHtml;
	 
	}

	function IsFileExist($Folder,$FileName){
		global $Config;
		$FilePath = $Folder.$FileName;
		$filesize ='';
		if(!empty($Folder) && !empty($FileName)){
			if($Config['ObjectStorage'] == "1"){
				SetOsDir();
				$FullPath = $Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath;
				/*$headers = get_headers($FullPath, TRUE);
				$arryHead = explode(" ",$headers['0']);
				$RespCode = $arryHead[1];
				if($RespCode=="200"){
			     		$filesize = $headers['Content-Length'];
				}*/		
				$headers = get_headers($FullPath,0);				 
				if(strpos($headers[0],'404') === false){
					$filesize =1;
				}
				 			 
				
			}else{
				$FullPath = $Config['RootUploadDir'].$Config['CmpID']."/".$FilePath;
				if(!empty($FileName)){
					$filesize = @filesize($FullPath);
				}
			}
			if(!empty($filesize)){
				return true;
			}
		}
	}

	function is_file_exist($Folder,$FileName,$FileExist){
		global $Config;
		$FilePath = $Folder.$FileName;
		$filesize ='';
		if(!empty($Folder) && !empty($FileName)){
			if($Config['ObjectStorage'] == "1"){						 
				if($FileExist=="1"){
					$filesize =1;
				}	 			 
				
			}else{
				$FullPath = $Config['RootUploadDir'].$Config['CmpID']."/".$FilePath;
				if(!empty($FileName)){
					$filesize = @filesize($FullPath);
				}
			}
			if(!empty($filesize)){
				return true;
			}
		}
	}

 	function GetFileInfo($Folder,$FileName){
		global $Config;
		$FilePath = $Folder.$FileName;
		if(!empty($Folder) && !empty($FileName)){
			if($Config['ObjectStorage'] == "1"){
				SetOsDir();
				$FullUrl = $Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath;
			}else{
				$FullUrl = $Config['RootUploadUrl'].$Config['CmpID']."/".$FilePath;
			}
			list($Width, $Height) = getimagesize($FullUrl);
			 
			return array($Width,$Height,$FullUrl);
		}
	}

	function IsDocExist($Path, $Folder,$FileName){
		global $Config;
		$FilePath = $Folder.$FileName;
		$filesize ='';
		if(!empty($Folder) && !empty($FileName)){
			if($Config['ObjectStorage'] == "1"){
				SetOsDir();
				$FullPath = $Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath;
				$headers = get_headers($FullPath,0);				 
				if(strpos($headers[0],'404') === false){
					$filesize =1;
				}		 			 
				
			}else{
 
				$FullPath = $Path.$FileName;
				if(!empty($FileName)){
					$filesize = @filesize($FullPath);
				}
			}
			if(!empty($filesize)){
				return true;
			}
		}
	}

	function GetDocUrl($Path, $Folder,$FileName){
		global $Config;
		$FilePath = $Folder.$FileName;
		$filesize ='';
		if(!empty($Folder) && !empty($FileName)){
			if($Config['ObjectStorage'] == "1"){
				SetOsDir();
				$FullPath = $Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath;
			}else{
				$FullPath = $Path.$FileName;				
			}
			if(!empty($FullPath)){
				return $FullPath;
			}
		}
	}

	function PhoneNumberFormat($phoneno)
	{
		$PhoneStr1 = ""; $PhoneStr2 = ""; $PhoneStr3 = "";
		$phoneno = trim($phoneno);
		$StrToReplace = array("(",")","-"," ");
		$PhoneNumber =  str_replace($StrToReplace, "", $phoneno);
		$PhoneStr1 = "(".substr($PhoneNumber,0,3).")"; 
		if(strlen($PhoneNumber)>3) { 
		$PhoneStr2 = "-".substr($PhoneNumber,3,3).""; 
		}
		if(strlen($PhoneNumber)>6) { 
			$PhoneStr3 = "-".substr($PhoneNumber,6,4).""; 
		}
		$resPhoneNumber = $PhoneStr1.$PhoneStr2.$PhoneStr3;
	
		return $resPhoneNumber;
	
	}


	function GetPdfLinks($PdfArray){
		global $Config;	
		$MakePdfLink=$tempid=$PdfTmpName=$FileExist='';
		if(!empty($PdfArray['TemplateID'])){
			$tempid = "&amp;tempid=".$PdfArray['TemplateID'];
			$PdfTmpName = "-temp".$PdfArray['TemplateID'];
		}
		$PdfFile = $PdfArray['ModuleDepName'].'-'.$PdfArray['ModuleID'].$PdfTmpName.'.pdf';

		if($Config['ObjectStorage'] == "1"){
			SetOsDir();
			$PdfUrl = $Config['OsUploadUrl'].$Config['OsDir']."/".$PdfArray['PdfFolder'].$PdfFile; 
			$DownloadUrl = 'dwn.php?file='.$PdfArray['PdfFolder'].$PdfFile;
			$PrintUrl = $PdfUrl;
			if(!empty($PdfArray['PdfFile'])) $FileExist=1;
			/*$headers = get_headers($PdfUrl,0);				 
			if(strpos($headers[0],'404') === false){ //file_exist true
				 $FileExist=1;
			}*/ 
							
		}else{
			/***************************/
			$PdfDir = $Config['FilePreviewDir'].$PdfArray['PdfFolder'];
			$PrintDir = $Config['FileUploadDir'].$PdfArray['PdfFolder']; 		
			$DownloadUrl = 'dwn.php?file='.$PdfArray['PdfFolder'].$PdfFile;
			$PrintUrl = $PrintDir.$PdfFile;
			if(!empty(file_exists($PdfDir.$PdfFile))){	
				$FileExist=1;				
			}   
			/***************************/
		}

		if(empty($FileExist)){
			$PdfUrl = "../pdfCommonhtml.php?o=".$PdfArray['OrderID']."&amp;ModuleDepName=".$PdfArray['ModuleDepName']."&amp;module=".$PdfArray['Module'].$tempid;
			$DownloadUrl = $PdfUrl;
			$MakePdfUrl = $PdfUrl."&amp;attachfile=1";
			$MakePdfLink = 'onclick="makepdffile(\''.$MakePdfUrl.'\')"';
			$PrintUrl = $PdfUrl."&amp;editpdftemp=1";
		}		

		$PdfResArray['MakePdfLink'] = $MakePdfLink;
		$PdfResArray['DownloadUrl'] = $DownloadUrl;
		$PdfResArray['PrintUrl'] = $PrintUrl;

		return $PdfResArray;
	}

	// added by nisha for sales person links
function createSalesPersonLink($SalesPersonID,$SalesPerson,$SalesPersonType)
{
	$salesPersonId   =  explode(",", $SalesPersonID); 
	$salesPersonName = explode(",", $SalesPerson); 
	$countLength = count($salesPersonId); 
    $salesPersonArr = array();
    for($i=0; $i<$countLength; $i++)
        { 
            if($SalesPersonType=='1') {
                $salesPersonLink = '<a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID='.$salesPersonId[$i].'">'. $salesPersonName[$i].'</a>';
            }
            else
            {

                $salesPersonLink  ='<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$salesPersonId[$i].'">'. $salesPersonName[$i].'</a>';
            }
                                          
                $salesPersonArr[] = $salesPersonLink;
       }
                            
        if(!empty($salesPersonArr[0])){
            $salesPersoToDisplay = implode(", ",$salesPersonArr);
        }
   return $salesPersoToDisplay;
}




	function DefaultDateFormat($Date){
		global $Config;
		if(!empty($Date) && $Config['DateFormatForm'] != 'Y-m-d'){
			//Formatting match///
 			$arryDate = explode("/",$Date);	
 
			if(!empty($arryDate[1]) && !empty($arryDate[2])){
				if($Config['DateFormatForm']=="Y/m/d"){
					$y = $arryDate[0]; $m = $arryDate[1]; $d = $arryDate[2];
					$y = (int)$y; $m = (int)$m; $d = (int)$d;
					if($m<10) $m= "0".$m;
					if($d<10) $d= "0".$d;
					//$Date = $y.'/'.$m.'/'.$d;
				}else if($Config['DateFormatForm']=="d/m/Y"){  
					$d = $arryDate[0]; $m = $arryDate[1]; $y = $arryDate[2];
					$y = (int)$y; $m = (int)$m; $d = (int)$d;
					if($m<10) $m= "0".$m;
					if($d<10) $d= "0".$d;
					//$Date = $d.'/'.$m.'/'.$y;
				}else if($Config['DateFormatForm']=="m/d/Y"){
					$m = $arryDate[0]; $d = $arryDate[1]; $y = $arryDate[2];
					$y = (int)$y; $m = (int)$m; $d = (int)$d;
					if($m<10) $m= "0".$m;
					if($d<10) $d= "0".$d;
					//$Date = $m.'/'.$d.'/'.$y;
				}
				$Date = $y.'-'.$m.'-'.$d;
			}
			/////////////////
			/*if(strlen($y)=="4" && (strlen($m)=="1" || strlen($m)=="2") && (strlen($d)=="1" || strlen($d)=="2")){
				

				$DateObj = DateTime::createFromFormat($Config['DateFormatForm'] , $Date);
				$Date = $DateObj->format('Y-m-d'); 

 
			}*/
		}
		return $Date;
	}

?>
