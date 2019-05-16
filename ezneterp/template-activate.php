<?php 
	require_once($Prefix."classes/erp.cmp.class.php");
	require_once($Prefix."classes/admin.class.php");	
    $objCmp=new cmp();
    $objConfig=new admin();	



	 if(!empty($_GET['cmp'])) {
		//print_r($arryCompany);exit;
	    $arryCompany['Email'] = base64_decode($_GET['cmp']);
		$Password = substr(md5(rand(100,10000)),0,8);
	    $arryCompany['Password'] = $Password;
		if($objConfig->isCmpEmailExists($arryCompany['Email'],'')){
			
			$ReturnFlag = $objCmp->ActiveCompany($arryCompany); 
		}else{				
			$_SESSION['mess_act'] = 'Invalid Email';			
		}				
				
	
		header("Location:index.php?slug=activate&activated=".$ReturnFlag);
		exit;
			
			
	}else{
		$_SESSION['mess_act'] = 'Invalid Email';
	}
	
	

	
	
	?>


	<style type="text/css">
	.tabs {
    display: block;
}
#page-title{
  color: #333;
    font-size: 32px;
    font-weight: 300;
    margin: 50px 0 0;
    padding: 0 0 30px;
    text-align: left;
}
	</style>


<div class="top-cont1"> </div>

			<section id="mainContent">
			<?php //echo $datah['Content'];?>

				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title">Account Activation</h1>
									<?php if($_GET['activated']>0){?>	
									<span> Your acount has been activated successfully.</span><br><br>
									<span>Please <a href="user"> click here </a> to login</span>
	                               <?php }else {?>
	                              <div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_act'])) {echo $_SESSION['mess_act']; unset($_SESSION['mess_act']); }?></div> 
	                               	
	                              <?php }?>	
										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">


												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-login-errors"
														style="display: none;">
														<ul></ul>
													</div>
										
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</article>

					</div>

				</div>
			</section>

		</div>
