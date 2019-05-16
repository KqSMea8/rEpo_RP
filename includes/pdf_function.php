<?
function CountSubString($Arry,$sub){ 
	$c=0;

	//echo $sub; print_r($Arry);exit;

	if(is_array($Arry)){
		foreach($Arry as $value){
			if($value==$sub) $c++;
		}
	}
	return $c;
}

function htmltorgbnew($color){ 
		if ($color[0] == '#')        $color = substr($color, 1);    if (strlen($color) == 6)        list($r, $g, $b) = array($color[0].$color[1],                                 $color[2].$color[3],                                 $color[4].$color[5]);    elseif (strlen($color) == 3)        list($r, $g, $b) = array($color[0], $color[1], $color[2]);    else        return false;    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);    return array($r, $g, $b);
}

function sortMultiArrayByKey55($argArray, $argKey, $argOrder=SORT_ASC){
    foreach ($argArray as $key => $row){
       $key_arr[$key] = trim($row[$argKey]);
    }
    array_multisort($key_arr, $argOrder, $argArray);
    return $argArray;
 }


function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}


/******************************/
function HeaderTextBox($pdf,$txt,$arryCompany){ 
	global $Config;
	$all = $pdf->openObject();
	$pdf->saveState();

	$pdf->setStrokeColor(0,0,0,1);
	$pdf->setLineStyle(1);
	$pdf->setColor(0,0,0,1);
	

	if($arryCompany[0]['Image'] !='' && file_exists($Config['Prefix'].'upload/company/'.$arryCompany[0]['Image']) ){
		$ImgName = $arryCompany[0]['Image'];
		$SiteLogo = $Config['Prefix'].'upload/company/'.$ImgName;
		
	}else{
		$ImgName = "logo.png";
		$SiteLogo = $Config['Prefix'].'images/'.$ImgName;
	}
	$arr_t = explode(".",$ImgName);
	$Extension = strtolower(end($arr_t)); 

	if($Extension=="jpg"){
		list($width_orig, $height_orig) = getimagesize($SiteLogo);
		$imgwidth = 100; $pos = 400;
		if($width_orig<$imgwidth){ $imgwidth = $width_orig; $pos = 450;}
		$pdf->addJpegFromFile($SiteLogo,$pos,$pdf->y-50,$imgwidth,'');
	}else if($Extension=="png"){ 
		//$pdf->addPngFromFile($SiteLogo,400,$pdf->y-100,'150','');
	}



	$Address = str_replace("\n"," ",stripslashes($arryCompany[0]['Address']));
	$CompanyInfo =  "<b>".stripslashes($arryCompany[0]['CompanyName'])."</b>\n".$Address.",\n".stripslashes($arryCompany[0]['City']).", ".stripslashes($arryCompany[0]['State']).", ".stripslashes($arryCompany[0]['Country'])."-".stripslashes($arryCompany[0]['ZipCode']); 
	
	if(!empty($arryCompany[0]['LandlineNumber']))
		$CompanyInfo .= "\nPhone : ".stripslashes($arryCompany[0]['LandlineNumber']);
	/*if(!empty($arryCompany[0]['Fax']))
		$CompanyInfo .= "\nFax : ".stripslashes($arryCompany[0]['Fax']);*/

	$CompanyInfo .= "\nEmail : ".stripslashes($arryCompany[0]['Email']);
	if(!empty($arryCompany[0]['Website']))
		$CompanyInfo .= "\nWebsite : <c:alink:".$arryCompany[0]['Website'].">".$arryCompany[0]['Website']."</c:alink>";

	$pdf->ezText($CompanyInfo,8,array('justification'=>'left', 'spacing'=>'1.3'));



	$arTxt = explode("<",$txt);
	$strlen = strlen($arTxt[0]);

	$pdf->setLineStyle(0.5);
	$pdf->rectangle(50,$pdf->y-50,500,33);

	$pdf->setLineStyle(1);
	$pdf->ezSetDy(-22);  
	$pdf->ezText("<b>".$txt."</b>",14,array('justification'=>'centre')); 
	$pdf->ezSetDy(-10);
	
	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject($all,'add');
}

/******************************/
function FooterTextBox($pdf){ 
	global $Config;
	// put a line top and bottom on all the pages

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setLineStyle(0.2);
	$pdf->setStrokeColor(0,0,0,1);
	$pdf->line(50,50,550,50);
	$pdf->setStrokeColor(0,0,0,1);
	//$pdf->rectangle(50,75,500,33);
	$pdf->setLineStyle(1);
	$page=$pdf->ezWhatPageNumber($pdf->ezGetCurrentPageNumber());
	
	$Config['Url']	= 'http://54.235.157.220/erp/';

	$pdf->addText(250,35,8,"<c:alink:".$Config['Url'].">".$Config['Url']."</c:alink>");
	$pdf->restoreState();
	$pdf->closeObject();
	//$pdf->addObject($all,'next');
	$pdf->addObject($all,'all');
}


function ClearFooter($pdf){
	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setColor(255,255,255,1);
	$pdf->filledRectangle(47,10,520,50);
	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject($all,'add');
	return true;
}

function ClearPaging($pdf){
	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setColor(255,255,255,1);
	$pdf->filledRectangle(515,52,40,20);
	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject($all,'add');
	return true;
}



/********************************/

// define a clas extension to allow the use of a callback to get the table of contents, and to put the dots in the label
class Creport extends Cezpdf {

	var $reportContents = array();

	function Creport($p,$o){
	  $this->Cezpdf($p,$o);
	}

	function rf($info){
	  // this callback records all of the table of contents entries, it also places a destination marker there
	  // so that it can be linked too
	  $tmp = $info['p'];
	  $lvl = $tmp[0];
	  $lbl = rawurldecode(substr($tmp,1));
	  $num=$this->ezWhatPageNumber($this->ezGetCurrentPageNumber());
	  $this->reportContents[] = array($lbl,$num,$lvl );
	  $this->addDestination('label'.(count($this->reportContents)-1),'FitH',$info['y']+$info['height']);
	}




	function dots($info){
	  // draw a dotted line over to the right and put on a page number
	  $tmp = $info['p'];
	  $lvl = $tmp[0];
	  $lbl = substr($tmp,1);
	  $xpos = 480;

	  switch($lvl){
		case '1':
		  $size=11;
		  $thick=1;
		  break;
		case '2':
		  $size=10;
		  $thick=0.5;
		  break;
	  }
	  $this->setColor(0,0,0,1);
	  $this->saveState();
	  $this->setLineStyle($thick,'round','',array(0,10));
	  $this->line($xpos,$info['y'],$info['x']+5,$info['y']);
	  $this->restoreState();
	  $lbl = $lbl -1;
	  $this->addText($xpos+5,$info['y'],$size,$lbl);


	}


}
/******************************/
class Prodigy_DBF {
    private $Filename, $DB_Type, $DB_Update, $DB_Records, $DB_FirstData, $DB_RecordLength, $DB_Flags, $DB_CodePageMark, $DB_Fields, $FileHandle, $FileOpened;
    private $Memo_Handle, $Memo_Opened, $Memo_BlockSize;

    private function Initialize() {

        if($this->FileOpened) {
            fclose($this->FileHandle);
        }

        if($this->Memo_Opened) {
            fclose($this->Memo_Handle);
        }

        $this->FileOpened = false;
        $this->FileHandle = NULL;
        $this->Filename = NULL;
        $this->DB_Type = NULL;
        $this->DB_Update = NULL;
        $this->DB_Records = NULL;
        $this->DB_FirstData = NULL;
        $this->DB_RecordLength = NULL;
        $this->DB_CodePageMark = NULL;
        $this->DB_Flags = NULL;
        $this->DB_Fields = array();

        $this->Memo_Handle = NULL;
        $this->Memo_Opened = false;
        $this->Memo_BlockSize = NULL;
    }

    public function __construct($Filename, $MemoFilename = NULL) {
        $this->Prodigy_DBF($Filename, $MemoFilename);
    }

    public function Prodigy_DBF($Filename, $MemoFilename = NULL) {
        $this->Initialize();
        $this->OpenDatabase($Filename, $MemoFilename);
    }

    public function OpenDatabase($Filename, $MemoFilename = NULL) {
        $Return = false;
        $this->Initialize();

        $this->FileHandle = fopen($Filename, "r");
        if($this->FileHandle) {
            // DB Open, reading headers
            $this->DB_Type = dechex(ord(fread($this->FileHandle, 1)));
            $LUPD = fread($this->FileHandle, 3);
            $this->DB_Update = ord($LUPD[0])."/".ord($LUPD[1])."/".ord($LUPD[2]);
            $Rec = unpack("V", fread($this->FileHandle, 4));
            $this->DB_Records = $Rec[1];
            $Pos = fread($this->FileHandle, 2);
            $this->DB_FirstData = (ord($Pos[0]) + ord($Pos[1]) * 256);
            $Len = fread($this->FileHandle, 2);
            $this->DB_RecordLength = (ord($Len[0]) + ord($Len[1]) * 256);
            fseek($this->FileHandle, 28); // Ignoring "reserved" bytes, jumping to table flags
            $this->DB_Flags = dechex(ord(fread($this->FileHandle, 1)));
            $this->DB_CodePageMark = ord(fread($this->FileHandle, 1));
            fseek($this->FileHandle, 2, SEEK_CUR);    // Ignoring next 2 "reserved" bytes

            // Now reading field captions and attributes
            while(!feof($this->FileHandle)) {

                // Checking for end of header
                if(ord(fread($this->FileHandle, 1)) == 13) {
                    break;  // End of header!
                } else {
                    // Go back
                    fseek($this->FileHandle, -1, SEEK_CUR);
                }

                $Field["Name"] = trim(fread($this->FileHandle, 11));
                $Field["Type"] = fread($this->FileHandle, 1);
                fseek($this->FileHandle, 4, SEEK_CUR);  // Skipping attribute "displacement"
                $Field["Size"] = ord(fread($this->FileHandle, 1));
                fseek($this->FileHandle, 15, SEEK_CUR); // Skipping any remaining attributes
				
                $this->DB_Fields[] = $Field;

            }

            // Setting file pointer to the first record
            fseek($this->FileHandle, $this->DB_FirstData);

            $this->FileOpened = true;

            // Open memo file, if exists
            if(!empty($MemoFilename) and file_exists($MemoFilename) and preg_match("%^(.+).fpt$%i", $MemoFilename)) {
                $this->Memo_Handle = fopen($MemoFilename, "r");
                if($this->Memo_Handle) {
                    $this->Memo_Opened = true;

                    // Getting block size
                    fseek($this->Memo_Handle, 6);
                    $Data = unpack("n", fread($this->Memo_Handle, 2));
                    $this->Memo_BlockSize = $Data[1];
                }
            }
        }

        return $Return;
    }

    public function GetNextRecord($FieldCaptions = false) {
        $Return = NULL;
        $Record = array();

        if(!$this->FileOpened) {
            $Return = false;
        } elseif(feof($this->FileHandle)) {
            $Return = NULL;
        } else {
            // File open and not EOF
            fseek($this->FileHandle, 1, SEEK_CUR);  // Ignoring DELETE flag

			
            foreach($this->DB_Fields as $Field) {

                $RawData = fread($this->FileHandle, $Field["Size"]);
                // Checking for memo reference

				

                if($Field["Type"] == "M" and $Field["Size"] == 4 and !empty($RawData)) {
                    // Binary Memo reference
                    $Memo_BO = unpack("V", $RawData);
                    if($this->Memo_Opened and $Memo_BO != 0) {
                        fseek($this->Memo_Handle, $Memo_BO[1] * $this->Memo_BlockSize);
                        $Type = unpack("N", fread($this->Memo_Handle, 4));
						
                        if($Type[1] == "1") {
                            $Len = unpack("N", fread($this->Memo_Handle, 4));
                            $Value = trim(fread($this->Memo_Handle, $Len[1]));
                        } else {
                            // Pictures will not be shown
                            //$Value = "{BINARY_PICTURE}";
							$Value = "";
                        }
						
                    } else {
                        $Value = "{NO_MEMO_FILE_OPEN}";
                    }
                } else {
					$Value = trim($RawData);

					if($Field["Type"] == "M"){
						
						if(trim($RawData) > 0)   {
							/*fseek($this->Memo_Handle, (trim($RawData) * $this->Memo_BlockSize)+8);
							$Value = trim(fread($this->Memo_Handle, $this->Memo_BlockSize));*/

							fseek($this->Memo_Handle, (trim($RawData) * $this->Memo_BlockSize)+4);
							$Len  = unpack("N", fread($this->Memo_Handle, 4));
							$Value = trim(fread($this->Memo_Handle, $Len[1] ));
						}
						else {
							$Value = trim($RawData);
						}
					}else{
						$Value = trim($RawData);
					}

                }
				

                if($FieldCaptions) {
                    $Record[$Field["Name"]] = $Value;
                } else {
                    $Record[] = $Value;
                }
            }
			
            $Return = $Record;
        }

        return $Return;
    }

    function __destruct() {
        // Cleanly close any open files before destruction
        $this->Initialize();
    }
}

/***************************************/

function imageThumbnail($filename, $imageThumbPath, $width , $height)
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
			$RGBArray = htmltorgbnew($backColor);
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
?>
