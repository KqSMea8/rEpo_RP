<?php

if($ModDepName == 'Sales'){
         //echo 'fff';
	if($arryCunt==1){
		$strcount=strlen($arryDesCount[0])/44;
		$strcount=round($strcount);
		if($strcount==2){
			$marginForSplTotl='300';
		}
		else{
			$marginForSplTotl='340';
		}

         //echo '<pre>'; print_r($arryDesCount);exit;
	}
	elseif($arryCunt==2){ 

		$maxdesval=0;
		foreach($arryDesCount as $decval){
			$strcount=strlen($decval)/44;
			$strcount=round($strcount);
                //echo $strcount;
			if($strcount>$maxdesval){
				$maxdesval=$strcount;
			}
		}

		if($maxdesval==5){$marginForSplTotl='200'; } 
		elseif($maxdesval==2){$marginForSplTotl='300';}
		else{$marginForSplTotl='250';}



	}
	elseif($arryCunt==3){ $marginForSplTotl='350'; }
	elseif($arryCunt==8){ $marginForSplTotl='50'; }
}
elseif($ModDepName == 'Purchase'){
	if($NumLine==1){
		$strcount=strlen($arryDesCount[0])/38;
		$strcount=round($strcount);
		if($strcount==2){
			$marginForSplTotl='300';
		}
		elseif($strcount==5){
			$marginForSplTotl='250';
		}
		else{
			$marginForSplTotl='320';
		}

         //echo '<pre>'; print_r($arryDesCount);exit;
	}
	elseif($NumLine==2){ 

		$maxdesval=0;
		foreach($arryDesCount as $decval){
			$strcount=strlen($decval)/38;
			$strcount=round($strcount);
                //echo $strcount;
			if($strcount>$maxdesval){
				$maxdesval=$strcount;
			}
		}

		if($maxdesval==5){$marginForSplTotl='200'; } else{$marginForSplTotl='250';}
	}
	elseif($NumLine==3){ 

		$maxdesval=0;
		foreach($arryDesCount as $decval){
			$strcount=strlen($decval)/38;
			$strcount=round($strcount);
                //echo $strcount;
			if($strcount>$maxdesval){
				$maxdesval=$strcount;
			}
		}

		if($maxdesval==5){$marginForSplTotl='200'; } else{$marginForSplTotl='250';}
	}
	elseif($NumLine==4){ 
		$marginForSplTotl='210';
	}


	elseif($NumLine==3){ 
		$maxdesval=0;
		foreach($arryDesCount as $decval){
			$strcount=strlen($decval)/38;
			$strcount=round($strcount);
                //echo $strcount;
			if($strcount>$maxdesval){
				$maxdesval=$strcount;
			}
		}

		if($maxdesval==2){$marginForSplTotl='10'; } else{$marginForSplTotl='0'; }

	}
	elseif($NumLine==4){ $marginForSplTotl='5'; }
	elseif($NumLine==5){ $marginForSplTotl='0'; }
	elseif($NumLine==6){ $marginForSplTotl='0'; }
	elseif($NumLine==7){ $marginForSplTotl='10'; }
	elseif($NumLine==8){ $marginForSplTotl='80'; }
	elseif($NumLine==9){ $marginForSplTotl='10'; }
	elseif($NumLine==10){ $marginForSplTotl='10'; }

}
elseif ($ModDepName == 'SalesInvoice') {
	if($NumLine==1){
		//echo 'ppp';
		$serialCount1=sizeof($salesInvSerialNo);
		$serialCount=$serialCount1/3;
		$serialCount=round($serialCount);
		//echo '<pre>'.$serialCount1; print_r($salesInvSerialNo);
		if($serialCount==79){
			$marginForSplTotl='0';
		}
		elseif($serialCount1==1){
			$marginForSplTotl='370';
		}
		else{$marginForSplTotl='410';}

	}

	elseif($NumLine==2){ 
		$serialCount1=sizeof($salesInvSerialNo);
		//$salesInvSerialNoarray[0];
		$serialCount=$serialCount/3;
		$serialCount=round($serialCount);
		if($serialCount1==1){
			$marginForSplTotl='330'; 
		    }


		}
		elseif($NumLine==3){ 
			$serialCount1=sizeof($salesInvSerialNo);
			$serialCount=$serialCount/3;
			$serialCount=round($serialCount);
			if($serialCount1==1){
				$marginForSplTotl='320'; 
			}

       	//$marginForSplTotl='350'; 
		}
		elseif($NumLine==4){ 
			$serialCount1=sizeof($salesInvSerialNo);
			$serialCount=$serialCount/3;
			$serialCount=round($serialCount);
			if($serialCount1==1){
				$marginForSplTotl='250'; 
			}
		}
		elseif($NumLine==5){ 

			$serialCount1=sizeof($salesInvSerialNo);
			$serialCount=$serialCount/3;
			$serialCount=round($serialCount);
			if($serialCount1==1){
				$marginForSplTotl='220'; 

			}

		}
		elseif($NumLine==6){ 
			$serialCount1=sizeof($salesInvSerialNo);
			$serialCount=$serialCount/3;
			$serialCount=round($serialCount);
			if($serialCount1==1){
				$marginForSplTotl='170'; 
			}
		}
		elseif($NumLine==7){ 

			$serialCount1=sizeof($salesInvSerialNo);
			$serialCount=$serialCount/3;
			$serialCount=round($serialCount);
			if($serialCount1==1){
				$marginForSplTotl='150'; 
			}
			else{$marginForSplTotl='160';}



		}
		elseif($NumLine==8){ $marginForSplTotl='120'; }
		elseif($NumLine==9){ $marginForSplTotl='0'; }
		elseif($NumLine==10){ $marginForSplTotl='0'; }
		else{$marginForSplTotl='0';}
	}

	elseif ($ModDepName == 'PurchaseInvoice') {
		if($NumLine==1){
		//echo 'ppp';
			$serialCount1=sizeof($salesInvSerialNo);
			$serialCount=$serialCount1/3;
			$serialCount=round($serialCount);
		//echo '<pre>'.$serialCount1; print_r($salesInvSerialNo);
			if($serialCount==79){
				$marginForSplTotl='0';
			}
			elseif($serialCount1==1){
				$marginForSplTotl='250';
			}
			else{$marginForSplTotl='100';}

		}
		elseif($NumLine==2){ 
			$serialCount1=sizeof($salesInvSerialNo);
			$serialCount=$serialCount/3;
			$serialCount=round($serialCount);
			if($serialCount1==1){
				$marginForSplTotl='350'; }


			}
			elseif($NumLine==3){ 
				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount/3;
				$serialCount=round($serialCount);
				if($serialCount1==1){
					$marginForSplTotl='320'; 
				}

       	//$marginForSplTotl='350'; 
			}
			elseif($NumLine==4){ 
				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount/3;
				$serialCount=round($serialCount);
				if($serialCount1==1){
					$marginForSplTotl='250'; 
				}
			}
			elseif($NumLine==5){ 

				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount/3;
				$serialCount=round($serialCount);
				if($serialCount1==1){
					$marginForSplTotl='220'; 

				}

			}
			elseif($NumLine==6){ 
				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount/3;
				$serialCount=round($serialCount);
				if($serialCount1==1){
					$marginForSplTotl='170'; 
				}
			}
			elseif($NumLine==7){ 

				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount/3;
				$serialCount=round($serialCount);
				if($serialCount1==1){
					$marginForSplTotl='150'; 
				}
				else{$marginForSplTotl='160';}



			}
			elseif($NumLine==8){ $marginForSplTotl='120'; }
			elseif($NumLine==9){ $marginForSplTotl='0'; }
			elseif($NumLine==10){ $marginForSplTotl='0'; }
			else{$marginForSplTotl='0';}
		}
       //
		elseif ($ModDepName == 'SalesRMA') {
			if($NumLine==1){
				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount1/3;
				$serialCount=round($serialCount);
		//echo '<pre>'.$serialCount1; print_r($salesInvSerialNo);
				if($serialCount==79){
					$marginForSplTotl='0';
				}
				elseif($serialCount1==1){
					$marginForSplTotl='280';
				}
				else{$marginForSplTotl='100';}
			}
		}
		elseif ($ModDepName == 'PurchaseRMA') {
			if($NumLine==1){
				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount1/3;
				$serialCount=round($serialCount);
		//echo '<pre>'.$serialCount1; print_r($salesInvSerialNo);
				if($serialCount==79){
					$marginForSplTotl='0';
				}
				elseif($serialCount1==1){
					$marginForSplTotl='280';
				}
				else{$marginForSplTotl='100';}
			}
		}
		elseif ($ModDepName == 'WhouseCustomerRMA') {
			if($NumLine==1){

				$strcount=strlen($arryDesCount[0])/30;
				$strcount=round($strcount);
				
		//echo 'ppp';
				$serialCount1=sizeof($salesInvSerialNo);
				$serialCount=$serialCount1/3;
				$serialCount=round($serialCount);
		//echo '<pre>'.$serialCount1; print_r($salesInvSerialNo);
				if($serialCount==79){
					$marginForSplTotl='0';
				}
				elseif($serialCount1==1){
					if($strcount==2){
						$marginForSplTotl='300';
					}
                    elseif($strcount==3){$marginForSplTotl='300';}
                    elseif($strcount==4){$marginForSplTotl='270';}
					else{$marginForSplTotl='350';}
					
				}
				else{$marginForSplTotl='410';}

			}
		}


		if($_GET['yy']==1){ 
			//echo '<pre>'; print_r($salesInvSerialNoarray);  
			//echo $NumLine;
			echo $strcount;
        //echo $maxdesval;
			die;
		}
		?>
