<a class="back" href="<?=$RedirectURL?>">Back</a>
<div class="had">
Recoding Management   &raquo; <span>  Recording Details </span>
</div>
<?php //pr($recordingData);?>
<div class="message" align="center"><?
    if (!empty($_SESSION['mess_meeting'])) {
        echo $_SESSION['mess_meeting'];
        unset($_SESSION['mess_meeting']);
    }
    ?></div>
<style>
<!--
.thumbnail-box {
    width: calc(33% - 30px);
    display: inline-block;
    margin: 0px 15px 25px 15px;
    box-sizing: border-box;
	float:left;
}
#recording-list-thumbnail .v {
    float: left;
    width: 248px;
    position: relative;
}
#recording-list-thumbnail .v-meta {
    height: auto;
}
.v .va {
    padding-top: 10px;
    padding-bottom: 10px;
}

.video-only .v .v-thumb {
    width: 248px;
    height: 143px;
    background-image: url(../image/recording/recording-video-bg.png);
    overflow: hidden;
    position: relative;
    background-color: #000;
    background-repeat: no-repeat;
    background-position: center center;
    border: 4px solid transparent;
    border-radius: 4px;
    border-color: #000;
    text-align: center;
}

.video-only .v .v-thumb .v-thumb-center {
    position: absolute;
        top: 48px;
    left: 108px;
    width: 32px;
    height: 32px;
    background-image: url(../images/play.png);
}

.audio-only .v .v-thumb {
    width: 248px;
    height: 143px;
    background-image: url(../image/recording/recording-video-bg.png);
    overflow: hidden;
    position: relative;
    background-color: #8A89AD;
    background-repeat: no-repeat;
    background-position: center center;
    border: 4px solid transparent;
    border-radius: 4px;
    border-color: #000;
    text-align: center;
}

.audio-only .v .v-thumb .v-thumb-center {
    position: absolute;
        top: 48px;
    left: 108px;
    width: 32px;
    height: 32px;
    background-image: url(../images/play-black.png);
}

.text-only .v .v-thumb {
    width: 250px;
    height: 145px;
    background-image: url(../image/recording/recording-video-bg.png);
    overflow: hidden;
    position: relative;
    background-repeat: no-repeat;
    background-position: center center;
    border: 2px solid transparent;
    border-radius: 4px;
    border-color: #ababab;
    text-align: center;
}

.text-only .v .v-thumb .v-thumb-center {
    position: absolute;
      top: 30px;
    left: 97px;
    width: 56px;
    height: 65px;
    background-image: url(../images/text.png);
}
.v .v-thumb .v-thumb-bottom {
    z-index: 3;
    position: absolute;
    bottom: 3px;
    text-align: center;
    width: 240px;
}
.v .v-thumb .media-icon {
    width: 23px;
    height: 100%;
    background: url(../image/recording/recording-video-icon.png) no-repeat center center;
    display: inline-block;
    margin-right: 6px;
}
.v .v-time {
    white-space: nowrap;
    font-size: 13px;
}

a.action {
    font-size: 13px;
    color: #005dbd;
    font-weight: 600;
}

.thumbnail-box a.action.delete {
    margin-left: 141px;
}
-->

.video-only .recording-thumb > a {
    background-image: url(../images/play.png);
    width: 100%;
    display: block;
    height: 147px;
    background-size: contain;
	position: relative;
    margin-bottom: 23px;
}
.audio-only .recording-thumb > a {
    background-image: url(../images/play-black.png);
    width: 100%;
    display: block;
    height: 147px;
    background-size: contain;
	position: relative;
	margin-bottom: 23px;
}
.text-only .recording-thumb > a {
    background-image: url(../images/text.png);
    width: 100%;
    display: block;
    height: 147px;
    background-size: contain;
    position: relative;
	margin-bottom: 23px;
}
.recording-box-area {
    position: relative;
    text-align: center;
    width: 100%;
    max-width: 900px;
    margin: auto;
    padding: 15px;
    clear: both;
    overflow: hidden;
}
.recording-box-area .thumbnail-box:nth-child(1), .recording-box-area .thumbnail-box:nth-child(2), .recording-box-area .thumbnail-box:nth-child(3) {
    float: none !important;
}
.text-overlay {
    position: absolute;
    bottom: -23px;
    width: 100%;
    text-align: center;
    color: #fff;
    background: rgb(0, 0, 0);
    padding: 3px 10px;
    left: 0px;
    box-sizing: border-box;
}
.thumbnail-box .recording-thumb > a:before {
    position: absolute;
    content: "";
    left: 5px;
    right: 5px;
    bottom: 4px;
    top: 5px;
    border: 5px solid rgba(255, 255, 255, 0.4);
	-webkit-transition:.4s;
	-moz-transition:.4s;
	-ms-transition:.4s;
	-o-transition:.4s;
	transition:.4s;
}
.recording-btn > a {
    display: inline-block;
    float: none;
    margin: 0px !Important;
    background: #106db2;
    color: #fff !important;
    padding: 2px 5px !important;
    border-radius: 3px;
    min-width: 45px;
    font-weight: 400 !important;
    font-size: 12px !Important;
}
.recording-btn > a:hover {
	background:#d33f3e;
}
.recording-btn {
    text-align: center;
    padding: 10px 0px;
}
.recording-btn > a.ipad-hide{
	float:left;
}
.recording-btn > a.delete{
	float:right;
}
/*.recording-btn > a.ipad-hide{
	background:#106db2 !important;	
}
.recording-btn > a.ipad-hide:hover{
	background:#d33f3e !important;	
}
*/

</style>
<div id="preview_div">
                <table width="800" align="center" cellspacing="1" cellpadding="3">
                                    
                        <tbody><tr align="left">
                            <td width="10%" align="center">

                                <span class="font18"><?=$recordsData[0]['topic']?></span><br>
                                <span class="font16" style="color: #ababab;"><?=date($Config['DateFormat'], strtotime($recordsData[0]['start_time'])).' '.date($Config['TimeFormat'], strtotime($recordsData[0]['start_time']))?>
                                <?php $tz = $objMeeting->meetingTimeZone(); echo $tz[$recordsData[0]['timezone']]?>
                                </span><br>
                                <!--span class="font16">Balance as on 16 Nov, 2016</span><br-->
                                <span class="font16"style="color: #ababab;">
                 					ID: <?php $result = substr_replace($recordsData[0]['meeting_number'], "-", 3, 0);
										echo substr_replace($result, "-", 7, 0);?>
    
                                </span>

                            </td>


                        </tr>

                </tbody></table>
                 <br/><br/>
            </div>
 
 <div class="recording-box-area">      
 <?php if(!empty($recordingData)){
				$i = 1;
				foreach ($recordingData as $files){
					$x = explode("_",$files['play_url']);
					if($files['file_type']=='TXT'){
						$playurl = 'erp/admin/crm/upload/zoomMeeting/'.$x[1].'/'.$files['play_url'];
						$dwnld = 'download='.$files['play_url'];
					}else{
						$playurl = "document.php?play=".$files['play_url'].'&topic='.urldecode($recordsData[0]['topic']);
					}
					
					if($files['file_type']=='MP4')
						$class = 'video-only';
					elseif($files['file_type']=='M4A')
						$class = 'audio-only';
					else 
						$class = 'text-only';
				?>     
				<div class="thumbnail-box <?=$class?>">
                	<div class="recording-thumb">
                    	<a href="https://www.eznetcrm.com/<?=$playurl?>" target="_blank" <?=$dwnld?> >
                        	<div class="text-overlay">
                            	<?php if($files['file_type']=='MP4'){
					              			echo 'Recoding';
										}elseif($files['file_type']=='M4A'){
											echo 'Audio Only';
										}else{
											echo 'Text File';
										}
										$fileSize = $objMeeting->StorageSize($files['file_size']);?>
					              (<?=($fileSize>0)?$fileSize:'1 KB'?>)
                            </div>
                        </a>
                        <div class="recording-btn">
                        	<a href="https://www.eznetcrm.com/erp/admin/crm/upload/zoomMeeting/<?=$x[1].'/'.$files['play_url']?>" <?='download='.$files['play_url']?> target="_blank" class="action ipad-hide">Download</a>
							<?php if( (($_SESSION['AdminType']!='admin') && (in_array('deleteRecording', $zoomPermission) || in_array('viewAll', $zoomPermission)) ) || ($_SESSION['AdminType']=='admin')) { ?>
                            <a href="meetingRecordingFiles.php?del_id=<?=urlencode($files['file_id']);?>&edit=<?=urlencode($files['recording_uuid_id'])?>" class="action delete" onClick="return confDel('File')">Delete</a>
                            <?php } ?>
                        </div>
                    </div>
                	<?php /*?><div class="v">
                	<a href="http://dev.vstacks.in/erp_old/erp/<?=$playurl?>" target="_blank" <?=$dwnld?> >
                        <div class="v-thumb">
                                <div class="v-thumb-center">
                                </div>
                                <div class="v-thumb-bottom">
							      <div class="media-icon">&nbsp;</div>
					              <span class="v-time">
					              <?php if($files['file_type']=='MP4'){
					              			echo 'Recoding';
										}elseif($files['file_type']=='M4A'){
											echo 'Audio Only';
										}else{
											echo 'Text File';
										}
										$fileSize = $objMeeting->StorageSize($files['file_size']);?>
					              (<?=($fileSize>0)?$fileSize:'1 KB'?>)</span>
                                </div>
                        </div>
                       </a>
                       
                        <div class="v-meta va">
                            <div class="v-meta-entry">
                                <a href="meetingRecordingFiles.php?del_id=<?$files['file_id']?>" target="_blank" class="action ipad-hide">Download</a>
                                <?php if( (($_SESSION['AdminType']!='admin') && in_array('deleteRecording', $zoomPermission)) || ($_SESSION['AdminType']=='admin')) { ?>
                                <a href="meetingRecordingFiles.php?del_id=<?=urlencode($files['file_id']);?>&edit=<?=urlencode($files['recording_uuid_id'])?>&module=Activity" class="action delete" onClick="return confDel('File')">Delete</a>
                                <?php } ?>
                            </div>
                            <div class="v-meta-overlay"></div>
                        </div>
                    </div><?php */?>
                </div>
        <?php 
        if($i%3==0){ echo '<div style="clear:both;"></div>';}
				}
			}
			
			?>
			
    </div>
			
				
				

			
			
		
