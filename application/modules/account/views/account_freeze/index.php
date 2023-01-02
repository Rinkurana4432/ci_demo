
<div class="x_content">

	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	
	<?php
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
	 //$loggedInuser = $_SESSION['loggedInUser']->c_id ; 
	 $loggedInuser = $this->companyGroupId; 
	 $party_dtail  = getNameById('account_freeze',$loggedInuser,'created_by_cid');
		
		if($loggedInuser != $party_dtail->created_by_cid){	
			echo '<button type="button" class="btn btn-primary addAccountFreeze" data-toggle="modal" id = "add">Add Freeze date</button>';	
		}
	
	
?>
<div class="col-md-12 col-xs-12 for-mobile">
 <div class="Filter Filter-btn2">	
	    	<?php 
			if(!empty($account_freeze)){
				foreach($account_freeze as $acnt_freeze){
				$date_display = date("j F , Y", strtotime($acnt_freeze['freeze_date']));
				echo "<h3 style='float: left;margin-right: 10px;'><b><span>".$date_display."</b></h3></span>";
				
			?>
		   <?php 
	
				echo '<button type="button" style="color:#fff;" class="btn btn-primary addBtn addAccountFreeze" data-toggle="modal" id="'.$acnt_freeze["id"].'"  data-id="editAccountFreeze">Update Freeze date</button>'; 
					}
				}
							
		?>
</div>
</div>		
</div>

<div id="add_account_freeze" class="modal fade in"  role="dialog" style="overflow:hidden;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Set User Target</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>



