<?
class message extends dbClass
{
		//constructor
		function message()
		{
			$this->dbClass();
		} 
		
		function  GetMessages($MessageID,$SenderID,$RecieverID,$Type)
		{
			$strSQLQuery = "select ms.*,m1.CompanyName as Sender,m2.CompanyName as Reciever from messages ms left outer join members m1 on ms.SenderID=m1.MemberID left outer join members m2 on ms.RecieverID=m2.MemberID";

			$strSQLQuery .= (!empty($MessageID))?(" where ms.MessageID=".$MessageID):(" where 1 ");
			$strSQLQuery .= (!empty($Type))?(" and ms.Type='".$Type."'"):("");
			$strSQLQuery .= ($SenderID>0)?(" and ms.SenderID=".$SenderID):("");
			$strSQLQuery .= ($RecieverID>0)?(" and ms.RecieverID=".$RecieverID):("");
			$strSQLQuery .= " order by MessageID desc";

			return $this->query($strSQLQuery, 1);
		}

		function  GetMessageDetail($MessageID)
		{

			$strSQLQuery = "update messages set Viewed='1' where MessageID=".$MessageID; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "select ms.*,m1.CompanyName as Sender,m2.CompanyName as Reciever from messages ms left outer join members m1 on ms.SenderID=m1.MemberID left outer join members m2 on ms.RecieverID=m2.MemberID";

			$strSQLQuery .= (!empty($MessageID))?(" where ms.MessageID=".$MessageID):(" where 1 ");

			return $this->query($strSQLQuery, 1);
		}

		function MoveToDeletedItems($arryDetails)
		{
			extract($arryDetails);
			
			for($i=1; $i<=$numMessage; $i++){
				
				$DeleteItem = 'DeleteItem'.$i; 
				$DeleteItem = $$DeleteItem;
				
				if($DeleteItem > 0){
					$strSQLQuery = "update messages set Type='Deleted' where MessageID=".$DeleteItem; 
					$this->query($strSQLQuery, 0);
				}

			}

			return 1;
		}


		function MoveToDeletedItemSingle($MessageID)
		{
			
			$strSQLQuery = "update messages set Type='Deleted' where MessageID=".$MessageID; 
			$this->query($strSQLQuery, 0);

			return 1;
		}

		function RemoveMessages($arryDetails)
		{
			extract($arryDetails);
			
			for($i=1; $i<=$numMessage; $i++){
				
				$DeleteItem = 'DeleteItem'.$i; 
				$DeleteItem = $$DeleteItem;
				
				if($DeleteItem > 0){
					$strSQLQuery = "delete from messages where MessageID=".$DeleteItem; 
					$this->query($strSQLQuery, 0);
				}

			}

			return 1;
		}

		function RemoveMessageSingle($MessageID)
		{
			
			$strSQLQuery = "delete from messages where MessageID=".$MessageID;
			$this->query($strSQLQuery, 0);

			return 1;
		}

		function UpdateSpam($SenderID,$RecieverID,$Spam)
		{
			$strSQLQuery = "select * from spam where SenderID=".$SenderID." and RecieverID=".$RecieverID; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($arryRow[0]['SenderID']>0){
				$strSQLQuery = "update spam set Spam='".$Spam."' where SenderID=".$SenderID." and RecieverID=".$RecieverID; 
				$this->query($strSQLQuery, 0);
			}else{
				$strSQLQuery = "insert into spam(SenderID,RecieverID,Spam) values('".$SenderID."' ,'".$RecieverID."','".$Spam."')";
				$this->query($strSQLQuery, 0);
			}

			if($Spam==1){
				$strSQLQuery = "update messages set Type='Spam' where SenderID=".$SenderID." and RecieverID=".$RecieverID; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}	

		function GetSpamSetting($SenderID,$RecieverID)
		{
			$strSQLQuery = "select Spam from spam where SenderID=".$SenderID." and RecieverID=".$RecieverID; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($arryRow[0]['Spam']>0){
				return 1;
			}else{
				return 0;
			}
		}


		function AddMessage($arryDetails)
		{
			extract($arryDetails);

			$strSQLQuery = "insert into messages  (SenderID, SenderName, RecieverID, RecieverName, Subject, Message, Source,Type,InquiryQuotation,Date) values( '".$SenderID."', '".addslashes($CompanyName)."','".$RecieverID."', '".addslashes($ContactCompany)."', '".addslashes($Subject)."', '".addslashes($Message)."', '".$Source."','".$Type."', '".$InquiryQuotation."','".date('Y-m-d H:i:s')."')";

			$this->query($strSQLQuery, 0);
			
			if($SentItem>0){
				$strSQLQuery = "insert into messages  (SenderID, SenderName, RecieverID, RecieverName, Subject, Message, Source,Type,InquiryQuotation,Date) values( '".$SenderID."', '".addslashes($CompanyName)."','".$RecieverID."', '".addslashes($ContactCompany)."', '".addslashes($Subject)."', '".addslashes($Message)."', '".$Source."','Sent', '".$InquiryQuotation."','".date('Y-m-d H:i:s')."')";

				$this->query($strSQLQuery, 0);
			}
			
			return 1;

		}

	
		function CountMessages($SenderID,$RecieverID)
		{
			$strSQLQuery = "SELECT sum( if( TYPE = 'Spam', 1, 0 ) ) AS Spam, sum( if( TYPE = 'Inquiry', 1, 0 ) ) AS Inquiry, sum( if( TYPE = 'Quotation', 1, 0 ) ) AS Quotation FROM messages";

			$strSQLQuery .=  " where Viewed=0 ";
			//$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");
			$strSQLQuery .= ($SenderID>0)?(" and SenderID=".$SenderID):("");
			$strSQLQuery .= ($RecieverID>0)?(" and RecieverID=".$RecieverID):("");

			return $this->query($strSQLQuery, 1);

		}

		function CountSentMessages($SenderID,$RecieverID)
		{
			$strSQLQuery = "SELECT sum( if( TYPE = 'Sent', 1, 0 ) ) AS SentMsg FROM messages";

			$strSQLQuery .=  " where Viewed=0 ";
			//$strSQLQuery .= (!empty($Type))?(" and Type='".$Type."'"):("");
			$strSQLQuery .= ($SenderID>0)?(" and SenderID=".$SenderID):("");
			$strSQLQuery .= ($RecieverID>0)?(" and RecieverID=".$RecieverID):("");

			return $this->query($strSQLQuery, 1);

		}


			
}

?>
