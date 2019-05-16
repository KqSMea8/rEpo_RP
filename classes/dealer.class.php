<?php

class dealer extends dbClass
{

	/**************************Fetch parents e-commerce categories*************************************************/

	function getCategories() {
		$sql = "SELECT * from e_categories where ParentID='0' ORDER BY Name ASC ";
		return $this->query($sql, 1);
	}

	/*function getDealerWalletHistory($DealerId=''){
		$sql = "SELECT edw.id,edw.dealerId,sum(edw.creditAmount) as totalcreditAmount,
		sum(edw.DebitAmount) as totalDebitAmount, edw.transactionNo,
		edw.walletNote,edw.Note,edw.date,concat(ec.FirstName,' ',ec.LastName) as dealerName,ec.WalletAmount from e_dealer_wallet as edw
		inner join e_customers ec on ec.Cid=edw.dealerId
		where 1 ";
		$sql .=(!empty($DealerId) && $DealerId!='0')?" and edw.dealerId='".addslashes($DealerId)."' " : " ";
		$sql .="group by edw.dealerId order by ec.FirstName asc";

		return $this->query($sql, 1);
		}*/
	function getDealerWalletHistoryByDealerId($DealerId=''){
		$sql = "SELECT edw.*,concat(ec.FirstName,' ',ec.LastName) as dealerName,ec.WalletLimit,ec.WalletBalance from e_customers as ec
		left join e_dealer_wallet as edw on edw.dealerId=ec.Cid and edw.orderId!='0' where ec.Cid='".addslashes($DealerId)."' " ;
		/*$sql = "SELECT edw.*,concat(ec.FirstName,' ',ec.LastName) as dealerName,ec.WalletLimit,ec.WalletBalance from e_dealer_wallet as edw
		 inner join e_customers ec on ec.Cid=edw.dealerId where edw.dealerId='".addslashes($DealerId)."' and edw.orderId!=0" ;*/
		return $this->query($sql, 1);
	}

	function getDealerRequestByDealerId($DealerId=''){
		
		
		$sql = "SELECT edm.*,concat(ec.FirstName,' ',ec.LastName) as dealerName from e_dealer_message as edm
		left join e_customers as ec on ec.Cid=edm.dealerId and (ec.custType='dealer' OR ec.custType='posdealer')  ";
		if($DealerId!='')
		$sql .= " where edm.dealerId='".addslashes($DealerId)."' " ;

		return $this->query($sql, 1);
	}


	function creditDebitWallet($arryDetails){

		@extract($arryDetails);

		$transactionNo='wc-'.$_SESSION['CmpID'].'-'.time();
		$walletNote='Amount credit '.$AddWalletAmount.' by Admin with transaction No ['.$transactionNo.']';

		$sql = "update e_customers SET WalletLimit=" . addslashes($WalletLimit) . " ";
		if($AddWalletAmount!=''){
			$sql .= ",WalletBalance=WalletBalance+" . addslashes($AddWalletAmount) . "";
		}
		$sql .= " where Cid='".addslashes($CustId)."'";

		$this->query($sql, 0);

		if($AddWalletAmount!=''){
			$sql = "INSERT INTO e_dealer_wallet SET dealerId='" . addslashes($CustId) . "',
			creditAmount='" . addslashes($AddWalletAmount) . "',	transactionNo='" . addslashes($transactionNo) . "',
			walletNote='" . addslashes($walletNote) . "',Note='" . addslashes($Note) . "',date='" . addslashes(date('Y-m-d H:i:s')) . "'";
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();

			if(!$lastInsertId){
				//$_SESSION['mess_wallet'] = 'Wallet Amount credited/Debited Failed';
				return false;
			}
		}
			
		//$_SESSION['mess_wallet'] = 'Wallet Amount credited/Debited Successfully';
		return true;

	}
	function creditDebitWalletold($arryDetails){

		@extract($arryDetails);

		$sql = "SELECT ec.WalletLimit,ec.WalletBalance from e_customers ec where ec.Cid='".addslashes($CustId)."'" ;
		$customerCurrentWallet= $this->query($sql, 1);

		$diffLimit=$WalletLimit-$customerCurrentWallet[0]['WalletLimit'] ;

		if($diffLimit>0){
			$transactionNo='wc-'.$_SESSION['CmpID'].'-'.time();
			$walletNote='Amount credit '.$diffLimit.' by Admin with transaction No ['.$transactionNo.']';

			$sql = "update e_customers SET WalletLimit=WalletLimit+" . addslashes($diffLimit) . ",WalletBalance=WalletBalance+" . addslashes($diffLimit) . " where Cid='".addslashes($CustId)."'";
			$this->query($sql, 0);

			$sql = "INSERT INTO e_dealer_wallet SET dealerId='" . addslashes($CustId) . "',
			creditAmount='" . addslashes($Amount) . "',	transactionNo='" . addslashes($transactionNo) . "',
			walletNote='" . addslashes($walletNote) . "',Note='" . addslashes($Note) . "',date='" . addslashes(date('Y-m-d H:i:s')) . "'";
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
		}

			


		if(!$lastInsertId){
			//$_SESSION['mess_wallet'] = 'Wallet Amount credited/Debited Failed';
			return false;
		}
		//$_SESSION['mess_wallet'] = 'Wallet Amount credited/Debited Successfully';
		return true;

	}

	function updateDealerMsgStatus($dataArr){

		$id=$dataArr['id'];
		$status=$dataArr['status'];
		if($status=='Reject'){
			$sql = "update e_dealer_message SET status='" . addslashes($status) . "' where id='".addslashes($id)."'";
			$this->query($sql, 0);

		}
		else if($status=='Approve'){
			$amount=$dataArr['amount'];
			$DealerId=$dataArr['DealerId'];
				
			$sql = "update e_dealer_message SET status='" . addslashes($status) . "' where id='".addslashes($id)."'";
			$this->query($sql, 0);

			$transactionNo='wc-'.$_SESSION['CmpID'].'-'.time();
			$walletNote='Amount credit '.$amount.' by Admin with transaction No ['.$transactionNo.']';

			if($amount!=''){
				$sql = "update e_customers SET WalletBalance=WalletBalance+" . addslashes($amount) . " 
				where Cid='".addslashes($DealerId)."'";
				$this->query($sql, 0);
				$sql = "INSERT INTO e_dealer_wallet SET dealerId='" . addslashes($DealerId) . "',
			creditAmount='" . addslashes($amount) . "',	transactionNo='" . addslashes($transactionNo) . "',
			walletNote='" . addslashes($walletNote) . "',date='" . addslashes(date('Y-m-d H:i:s')) . "'";
				$this->query($sql, 1);

				
					
			}


		}
		return true;
	}


}

?>
