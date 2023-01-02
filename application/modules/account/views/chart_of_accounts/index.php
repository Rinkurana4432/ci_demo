<div id="hierarchy">
	<div class="indtd">
	<div class="container">
		<div class="col">
			<div class="easy-tree">
				<?php if(!empty($ChartAccount)){
					foreach($ChartAccount as $ac){
					#pre($ac);
					
					$totalParentAccountAmount = 0;
					if($ac["parentAccountCrAmount"] > $ac["parentAccountDrAmount"]){
						$totalParentAccountAmount = $ac["parentAccountCrAmount"] - $ac["parentAccountDrAmount"] ;
						$totalParentAccountAmount = $totalParentAccountAmount .' cr'; 
					}elseif($ac["parentAccountCrAmount"] < $ac["parentAccountDrAmount"]){
						$totalParentAccountAmount = $ac["parentAccountDrAmount"] - $ac["parentAccountCrAmount"] ;
						$totalParentAccountAmount = $totalParentAccountAmount .' dr'; 
					}elseif($ac["parentAccountCrAmount"] == 0 ||  $ac["parentAccountDrAmount"] == 0 ){
						$totalParentAccountAmount = 0; 
					}					
						echo '<ul>
								<li class="mainParentName liButtonDisable" data-attribute="parent" id="'.$ac["account_parent_id"].'" data-parent-id="'.$ac["parent_id"].'">'.$ac["parent_name"].'     ('.$totalParentAccountAmount.')  ';
								if(!empty($ac['accounts'])){
									echo '<ul>';
									foreach($ac['accounts'] as $account){									
										$totalAccountAmount = 0;
										if($account["accountCrAmount"] > $account["accountDrAmount"]){
											$totalAccountAmount = $account["accountCrAmount"] - $account["accountDrAmount"] ;
											$totalAccountAmount = $totalAccountAmount .' cr'; 
										}elseif($account["accountCrAmount"] < $account["accountDrAmount"]){
											$totalAccountAmount = $account["accountDrAmount"] - $account["accountCrAmount"] ;
											$totalAccountAmount = $totalAccountAmount .' dr'; 
										}elseif($account["accountCrAmount"] == 0 ||  $account["accountDrAmount"] == 0 ){
											$totalAccountAmount = 0; 
										}
										
										echo '<li class="mainAccountName liButtonDisable" data-attribute="account" data-account-id = "'.$account["id"].'">'.$account["account_group_name"].'     ('.$totalAccountAmount.')  ';
										if(!empty($account['ledger'])){
											echo '<ul id="multi-drop">';
												foreach($account['ledger'] as $ledger){
													$amount = $ledger["crAmount"] == 0?$ledger["drAmount"].' dr':$ledger["crAmount"].' cr';
													$amount = $amount == 0?0:$amount;
													echo '<li class="ledgerName liButtonEnable" data-attribute="ledger" data-ledger-id = "'.$ledger["id"].'">'.$ledger["name"].'     ('.$amount.')  '.'</li>';
												}
											echo '</ul>';
										}
									}
									echo '</li></ul>';	
								}
							echo '</li></ul>';	
					}
				}?>
		</div>
</div>
</div>
</div>

 