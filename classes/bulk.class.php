<?
class bulk extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function bulk(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}



	function SubscribeMembers($MemberIDs,$StoreID,$Type,$MemberType)
	{
		$idArray = explode(',' ,rtrim($MemberIDs,","));
		
		$Del_ID = '';


		foreach($idArray as $MemberIDss){

			$MemberIDArray = explode('-' ,$MemberIDss);

			$MemberID = $MemberIDArray[0];
			$MemberStatus = $MemberIDArray[1];
			
			
			
			$strSQLQuery ="select bulkID from bulk where MemberID='".$MemberID."' and StoreID='".$StoreID."' and Type='".$Type."'";

			$arryRow = $this->query($strSQLQuery, 1);
			
			if(!empty($arryRow[0]['bulkID'])) {
				if ($MemberStatus=='false') {
					$Del_ID .= $arryRow[0]['bulkID'].',';
				}
			}else if($MemberStatus=='true') {
				$sql = "insert into bulk(MemberID,StoreID,Type) values('".$MemberID."', '".$StoreID."','".$Type."')";
				$this->query($sql, 0);
			}
			

		}

		
		$Del_ID = rtrim($Del_ID,",");

		if(!empty($Del_ID)){
			$sql = "delete from bulk where bulkID in(".$Del_ID.")";
			$rs = $this->query($sql,0);
		}

		return 1;

	}

	function addBulk($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into bulk (MemberID,StoreID,Type) values('".$MemberID."', '".$StoreID."','".$Type."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}

	function getBulk($bulkID=0,$MemberID,$StoreID,$Type)
	{
		$sql = " where 1 ";
		$sql .= (!empty($bulkID))?(" and b.bulkID = '".$bulkID."'"):("");
		$sql .= (!empty($MemberID))?(" and b.MemberID = '".$MemberID."'"):("");
		$sql .= (!empty($StoreID))?(" and b.StoreID = '".$StoreID."'"):("");
		$sql .= (!empty($Type))?(" and b.Type = '".$Type."'"):("");

		$sql = "select b.*,m.UserName from bulk b inner join members m on b.MemberID=m.MemberID ".$sql." order by b.bulkID desc" ; 
		return $this->query($sql, 1);
	}

	function deleteBulk($bulkID)
	{

		$sql = "delete from bulk where bulkID = '".$bulkID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}

	function deleteSubscription($bulkID)
	{
		$Del_ID = rtrim($bulkID,",");

		$sql = "delete from bulk where bulkID in(".$Del_ID.")";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}	

	function isBulkExists($heading,$bulkID)
	{

		$strSQLQuery ="select * from bulk where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($bulkID))?(" and bulkID != '".$bulkID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['bulkID'])) {
			return true;
		} else {
			return false;
		}
	}


	function isMemberSubscribed($MemberID,$StoreID,$Type)
	{

			$strSQLQuery ="select bulkID from bulk where MemberID='".$MemberID."' and StoreID='".$StoreID."' and Type='".$Type."'";

			$arryRow = $this->query($strSQLQuery, 1);
			
			if(!empty($arryRow[0]['bulkID'])) {
				return true;
			}else {
				return false;
			}

	}


	function  getMemberToSubscribe($MemberID,$Type,$BulkType)
	{

		$strSQLQuery = "select m.MemberID,m.UserName,m.Email,b.bulkID,b.Type as BulkType from members m inner join bulk b on (m.MemberID=b.MemberID and b.Type='".$BulkType."') where m.Status='1'";

		$strSQLQuery .= (!empty($MemberID))?(" and m.MemberID!='".$MemberID."' and b.StoreID='".$MemberID."'"):("");
		$strSQLQuery .= (!empty($Type))?(" and m.Type='".$Type."'"):("");
		//$strSQLQuery .= (!empty($BulkType))?(" and b.Type='".$BulkType."'"):("");

		//$strSQLQuery .= (!empty($BulkType))?(" and b.BulkType='".$BulkType."'"):("");
		if($BulkType=='sms'){
			$strSQLQuery .= " and m.Phone!='' ";
		}

		//echo $strSQLQuery;

		return $this->query($strSQLQuery, 1);

	}


	function  geMySubscribtions($MemberID,$BulkType)
	{

		$strSQLQuery = "select m.MemberID,m.UserName,m.Email,m.CompanyName,b.bulkID,b.Type as BulkType from bulk b inner join members m on b.StoreID=m.MemberID where m.Status='1' and b.MemberID='".$MemberID."' and b.Type='".$BulkType."'";

		return $this->query($strSQLQuery, 1);

	}

	function  getMemberToSend($MemberID,$Type,$BulkType)
	{

		$strSQLQuery = "select m.MemberID,m.UserName,m.Email,b.bulkID,b.Type as BulkType from members m inner join bulk b on (m.MemberID=b.MemberID and b.Type='".$BulkType."') where m.Status='1'";

		$strSQLQuery .= (!empty($MemberID))?(" and m.MemberID!='".$MemberID."' and b.StoreID='".$MemberID."'"):("");
		$strSQLQuery .= (!empty($Type))?(" and m.Type='".$Type."'"):("");
		//$strSQLQuery .= (!empty($BulkType))?(" and b.Type='".$BulkType."'"):("");

		//$strSQLQuery .= (!empty($BulkType))?(" and b.BulkType='".$BulkType."'"):("");
		if($BulkType=='sms'){
			$strSQLQuery .= " and m.Phone!='' ";
		}

		//echo $strSQLQuery;

		return $this->query($strSQLQuery, 1);

	}



	function SellerUnsubscribeEmail($MemberID,$StoreID)
		{

			$sql ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$MemberID."'";
			$arryMember = $this->query($sql, 1);

			$sql2 ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$StoreID."'";
			$arryStore = $this->query($sql2, 1);

			if($arryMember[0]['MemberID']>0 && $arryStore[0]['MemberID']>0){

				global $Config;

				/***************   mail to user ******************/

				

				$UserMesg = "Dear ".$arryStore[0]['UserName'].', <br><br>';
				$UserMesg .= "One of your Webo bulk email subscribers [UserName: ".$arryMember[0]['UserName']."] has sent you this request to remove him from your mailing lists.";

				$contents = file_get_contents("html/ack.htm");

				$contents = str_replace("[MAIL_CONTENT]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryStore[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Unsubscribe Request from a User.";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryStore[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}		


	function SellerUnsubscribeEmailOther($MemberEmail,$StoreID)
		{

			$sql2 ="select m.MemberID,m.UserName,m.Email,m.CompanyName from members m where m.MemberID = '".$StoreID."'";
			$arryStore = $this->query($sql2, 1);

			if($arryStore[0]['MemberID']>0){

				global $Config;

				/***************   mail to user ******************/

				

				$UserMesg = "Dear ".$arryStore[0]['UserName'].', <br><br>';
				$UserMesg .= "One of your Webo bulk email subscribers [Email: ".$MemberEmail."] has sent you this request to remove him from your mailing lists.";

				$contents = file_get_contents("html/ack.htm");

				$contents = str_replace("[MAIL_CONTENT]",$UserMesg,$contents);

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryStore[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Unsubscribe Request from a User.";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryStore[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}

			}
		
			return 1;
		}



}
?>
