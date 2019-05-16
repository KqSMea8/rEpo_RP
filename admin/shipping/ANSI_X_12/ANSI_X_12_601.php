<?php 


function create_ISA()
{

	$segTer = ":~";
	$compEleSep = "*";
	
    $ISA     =  array();

    $ISA[0] = "ISA";                         

    $ISA[1] = "03"; 

   	$ISA[2] = "123456789"; 
     
    $ISA[3] = "01*"; 
      
    $ISA[4] = "01"; 
       
    $ISA[5] = "123456789"; 
        
    $ISA[6] = "ZZ"; 
         
    $ISA[7] = "USCSAESTEST"; 
          
    $ISA[8] = "160303"; 
           
    $ISA[9] = "1735"; 
    
    $ISA[10] = "^"; 
    
    $ISA[11] = "00405"; 
    
    $ISA[12] = "000000650"; 
    
    $ISA[13] = "0"; 
    
    $ISA[14] = "T"; 

    $ISA['Created'] = implode('*', $ISA);       // Data Element Separator

    $ISA['Created'] = $ISA['Created'] ."*";

    $ISA['Created'] = $ISA ['Created'] . $segTer;

    return trim($ISA['Created']);
}


function create_GS()
{

	$segTer = "~";

    $GS    = array();

    $GS[0] = "GS";                      // Functional Group Header Segment ID

    $GS[1] = "SE";

    $GS[2] = "123456789"; 
    
    $GS[3] = "USCSAESTEST"; 
    
    $GS[4] = "20160303"; 
    
    $GS[5] = "173519"; 
    
    $GS[6] = "1"; 
    
    $GS[7] = "X"; 
    
    $GS[8] = "004050"; 

    $GS['Created'] = implode('*', $GS);         // Data Element Separator

    $GS['Created'] = $GS ['Created'] . $segTer;  // change the information in the tag or change the tag

    return trim($GS['Created']);
}


function create_ST()
{

	$segTer = "~";
	
    $ST    =    array();

    $ST[0] = "ST";                              // Transaction Set Header Segment ID
    
    $ST[1] = "601";
    
    $ST[2] = "0001";
    
    $ST['Created'] = implode('*', $ST);             // Data Element Separator

    $ST['Created'] = $ST ['Created'] . $segTer;

    return trim($ST['Created']);
}



function create_BA1()
{

	//BA1
	$segTer = "~";
	
    $BA1    =   array();

    $BA1[0] = "BA1";                        // Beginning of Hierarchical Transaction Segment ID

    $BA1[1] = "Y";                      

    $BA1[2] = "1";       
                         
    $BA1[3] = "MX";

    $BA1[4] = "006502016";
    
    $BA1[5] = "NO";
    
    $BA1[6] = "TX*";
    
    $BA1[7] = "ABCD*";
    
    $BA1[8] = "ABCD";
                                            
   
    $BA1['Created'] = implode('*', $BA1);           // Data Element Separator

    $BA1['Created'] = $BA1 ['Created'] . $segTer;

    return trim($BA1['Created']);
}




function create_YNQ1()
{
	//YNQ1
	$segTer = "~";
	
    $YNQ1    =   array();

    $YNQ1[0] = "YNQ";                        // Beginning of Hierarchical Transaction Segment ID
    
    $YNQ1[1] = "RZ"; //Condition Indicator
    
    $YNQ1[2] = "N"; //Yes/No Condition or Response Code

    $YNQ1['Created'] = implode('*', $YNQ1);           // Data Element Separator

    $YNQ1['Created'] = $YNQ1 ['Created'] . $segTer;

    return trim($YNQ1['Created']);
}

function create_YNQ2()
{
	//YNQ2
	$segTer = "~";
	
    $YNQ2    =   array();

    $YNQ2[0] = "YNQ";                        // Beginning of Hierarchical Transaction Segment ID
    
    $YNQ2[1] = "RZ"; 
    
    $YNQ2[2] = "N"; 

    $YNQ2['Created'] = implode('*', $YNQ2);           // Data Element Separator

    $YNQ2['Created'] = $YNQ2 ['Created'] . $segTer;

    return trim($YNQ2['Created']);
}

function create_DTM()
{
	//DTM
	$segTer = "~";
	
    $DTM    =   array();

    $DTM[0] = "DTM";                        // Beginning of Hierarchical Transaction Segment ID
    
    $DTM[1] = "274"; 
    
    $DTM[2] = "20160310"; 

    $DTM['Created'] = implode('*', $DTM);           // Data Element Separator

    $DTM['Created'] = $DTM ['Created'] . $segTer;

    return trim($DTM['Created']);
}

function create_P5()
{
	//P5
	$segTer = "~";
	
    $P5    =   array();

    $P5[0] = "P5";                        // Beginning of Hierarchical Transaction Segment ID
    
    $P5[1] = "L"; 
    
    $P5[2] = "D"; 
    
    $P5[3] = "2304"; 

    $P5['Created'] = implode('*', $P5);           // Data Element Separator

    $P5['Created'] = $P5 ['Created'] . $segTer;

    return trim($P5['Created']);
}


function create_REF()
{
	//P5
	$segTer = "~";
	
    $P5    =   array();

    $P5[0] = "REF";                        // Beginning of Hierarchical Transaction Segment ID
    
    $P5[1] = "BN"; 
    
    $P5[2] = "25039614"; 

    $P5['Created'] = implode('*', $P5);           // Data Element Separator

    $P5['Created'] = $P5 ['Created'] . $segTer;

    return trim($P5['Created']);
}


function create_M12()
{
	//P5
	$segTer = "~";
	
    $P5    =   array();

    $P5[0] = "M12";                        // Beginning of Hierarchical Transaction Segment ID
    
    $P5[1] = "70**";

    $P5[2] = "N"; 
    
    $P5['Created'] = implode('*', $P5);           // Data Element Separator

    $P5['Created'] = $P5 ['Created'] . $segTer;

    return trim($P5['Created']);
}


/****************************SHIP-TO INFORMATION LOOP***************************/	

function create_shiping_N1()
{
			
			$segTer = "~";
		
		    $SN1    =   array();
		
		    $SN1[0] = "N1";                        // Beginning of Hierarchical Transaction Segment ID
		    
		    $SN1[1] = "EX";
		
		    $SN1[2] = "W.W. ACE"; 
		    
		    $SN1[3] = "24";
		    
		    $SN1[4] = "12345678900";
 
		    $SN1['Created'] = implode('*', $SN1);           // Data Element Separator
		
		    $SN1['Created'] = $SN1 ['Created'] . $segTer;
		
		    return trim($SN1['Created']);

}

	function create_shiping_N2()
	{
				
				$segTer = "~";
			
			    $SN2    =   array();
			
			    $SN2[0] = "N2";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $SN2[1] = "MARK T. MARK";
			
			    $SN2[2] = "70812345678"; 
	
			    $SN2['Created'] = implode('*', $SN2);           // Data Element Separator
			
			    $SN2['Created'] = $SN2 ['Created'] . $segTer;
			
			    return trim($SN2['Created']);
	
	}
	
	function create_shiping_N3()
	{
				
				$segTer = "~";
			
			    $SN3    =   array();
			
			    $SN3[0] = "N3";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $SN3[1] = "1100 MARK DRIVE";
	
			    $SN3['Created'] = implode('*', $SN3);           // Data Element Separator
			
			    $SN3['Created'] = $SN3 ['Created'] . $segTer;
			
			    return trim($SN3['Created']);
	
	}
	
	
	function create_shiping_N4()
	{
				
				$segTer = "~";
			
			    $SN4    =   array();
			
			    $SN4[0] = "N4";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $SN4[1] = "COLUMBIA";
			
			    $SN4[2] = "MD"; 
			    
			    $SN4[3] = "21044"; 
			    
			    $SN4[4] = "US"; 
	
			    $SN4['Created'] = implode('*', $SN4);           // Data Element Separator
			
			    $SN4['Created'] = $SN4 ['Created'] . $segTer;
			
			    return trim($SN4['Created']);
	
	}
		
				

/****************************************************************/	


/****************************BILL-TO INFORMATION LOOP*************/	
				
				function create_billing_N1()
				{
						
				$segTer = "~";
			
			    $BN1    =   array();
			
			    $BN1[0] = "N1";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $BN1[1] = "CN";
			    
			    $BN1[2] = "ACE MEXICO**";
			    
			    $BN1[3] = "01";
			    
			    $BN1[4] = "XT";
			    
			    $BN1['Created'] = implode('*', $BN1);           // Data Element Separator
			
			    $BN1['Created'] = $BN1 ['Created'] . $segTer;
			
			    return trim($BN1['Created']);
				
				}
				
				
					
				function create_billing_N3()
				{
						
				$segTer = "~";
			
			    $BN3    =   array();
			
			    $BN3[0] = "N3";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $BN3[1] = "AV. ACE";
	
			    $BN3['Created'] = implode('*', $BN3);           // Data Element Separator
			
			    $BN3['Created'] = $BN3 ['Created'] . $segTer;
			
			    return trim($BN3['Created']);
				
				}
				
				function create_billing_N4()
				{
						
				$segTer = "~";
			
			    $BN4    =   array();
			
			    $BN4[0] = "N4";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $BN4[1] = "SANTIAGO, TIANGIUSTENCO";
			    
			    $BN4[2] = "MX";
			    
			    $BN4[3] = "52600";
			    
			    $BN4[4] = "MX";
	
			    $BN4['Created'] = implode('*', $BN4);           // Data Element Separator
			
			    $BN4['Created'] = $BN4 ['Created'] . $segTer;
			
			    return trim($BN4['Created']);
				
				}
				

				
				function create_L13()
				{
						
				$segTer = "~";
			
			    $L13    =   array();
			
			    $L13[0] = "L13";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $L13[1] = "A";
			    
			    $L13[2] = "3907200000";
			    
			    $L13[3] = "17600";
			    
			    $L13[4] = "10";
			    
			    $L13[5] = "26518";
			    
			    $L13[6] = "1**";
			    
			    $L13[7] = "K";
			    
			    $L13[8] = "18924";
			    
			    $L13[9] = "TOTE";
			    
			    $L13[10] = "OS";
			    
			    $L13[11] = "1";
	
			    $L13['Created'] = implode('*', $L13);           // Data Element Separator
			
			    $L13['Created'] = $L13 ['Created'] . $segTer;
			
			    return trim($L13['Created']);
				
				}
				
				
				
				function create_X1()
				{
						
				$segTer = "~";
			
			    $X1    =   array();
			
			    $X1[0] = "X1";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $X1[1] = "NLR";
			    
			    $X1[2] = "1***";
			    
			    $X1[3] = "C33*";
			    
			    $X1[4] = "D****";
			    
			    $X1[5] = "0*";
			    
			    $X1[6] = "EAR99";
	
			    $X1['Created'] = implode('*', $X1);           // Data Element Separator
			
			    $X1['Created'] = $X1 ['Created'] . $segTer;
			
			    return trim($X1['Created']);
				
				}
				
				
/****************************************************************/
				
				
function create_SE()
{
	//P5
	$segTer = "~";
	
    $SE    =   array();

    $SE[0] = "SE";                        // Beginning of Hierarchical Transaction Segment ID
    
    $SE[1] = "23"; 
    
    $SE[2] = "0001"; 

    $SE['Created'] = implode('*', $SE);           // Data Element Separator

    $SE['Created'] = $SE ['Created'] . $segTer;

    return trim($SE['Created']);
}

function create_GE()
{
	//P5
	$segTer = "~";
	
    $GE    =   array();

    $GE[0] = "GE";                        // Beginning of Hierarchical Transaction Segment ID
    
    $GE[1] = "1"; 
    
    $GE[2] = "1"; 

    $GE['Created'] = implode('*', $GE);           // Data Element Separator

    $GE['Created'] = $GE ['Created'] . $segTer;

    return trim($GE['Created']);
}


function create_IEA()
{
	//P5
	$segTer = "~";
	
    $IEA    =   array();

    $IEA[0] = "IEA";                        // Beginning of Hierarchical Transaction Segment ID
    
    $IEA[1] = "1"; 
    
    $IEA[2] = "000000650"; 

    $IEA['Created'] = implode('*', $IEA);           // Data Element Separator

    $IEA['Created'] = $IEA ['Created'] . $segTer;

    return trim($IEA['Created']);
}




		
   function create_file_generation()
	{
		// create ISA
	            $result    = create_ISA();
	            // create GS
	            $result   .= create_GS();
	            
	            $result   .= create_ST();
	             
	            $result   .= create_BA1();
	            
	            $result   .= create_YNQ1();
	            
	            $result   .= create_YNQ2();
	            
	            $result   .= create_DTM();
	            
	            $result   .= create_P5();
	            
	            $result   .= create_REF();
	            
	            $result   .= create_M12();
	            
	            // shipping 
	            $result   .= create_shiping_N1();
	            $result   .= create_shiping_N2();
	            $result   .= create_shiping_N3();
	            $result   .= create_shiping_N4();
	            
	            // billing
	            $result   .= create_billing_N1();
	            $result   .= create_billing_N3();
	            $result   .= create_billing_N4();
	            $result   .= create_billing_N1();
	            $result   .= create_billing_N3();
	            $result   .= create_billing_N4();
	            
	            
	            $result   .= create_L13();
	            $result   .= create_X1();
	            $result   .= create_L13();
	            $result   .= create_X1();
	            
	            $result   .= create_SE();
	            $result   .= create_GE();
	            $result   .= create_IEA();


	            //echo $result;
	           return $result;
	            
	}
					
				



?>