
<?php
	if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
	<div class="alert alert-info" id="message_Sucess" style="display:none;"></div>				  
		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			<input type="hidden" name="id" value="<?php //if(!empty($voucher)) echo $voucher->id; ?>">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">	
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div class="panel panel-default">
				<!--div class="panel-heading"><h3 class="panel-title"><strong><?php //if(!empty($voucher)) echo $voucher->voucher_name; ?> </strong></h3></div--><div class="mesg col-md-6"></div>
				<div class="panel-body">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_content">
						<div class="settin-tab" role="tabpanel" data-example-id="togglable-tabs">
						<!--<h3 class="Material-head">Information<hr></h3>-->
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="firstt active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">CRM Setting</a></li>
							<!--li role="presentation" class="secc "><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Invoice Setting</a></li>
							<li role="presentation" class="thirdd "><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Ageing Email Settings</a></li-->
							
						</ul>
				<div id="myTabContent" class="tab-content list-vies-2" style="clear: both;">
				
<div role="tabpanel" class="col-md-8 col-sm-12 col-xs-12 vertical-border tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab" style="clear: both;"> 
	<div class="col-md-12 col-sm-12 col-xs-12">
		  <label class="col-md-3 col-sm-3 col-xs-12" for="type">Material Price Settings<span class="required">*</span></label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
						<tr>
						<th scope="row">Material Price Settings</th>
						<td>
						<form id="invoice_cancl_restor_form1" method="post" action="<?php echo base_url(); ?>crm/saveCRMSEtting" enctype="multipart/form-data">
							 <?php
							   $item_code_Settings = $this->crm_model->get_compdata('company_detail',array('id'=> $this->companyGroupId));
							   if($item_code_Settings[0]['priceLISTONOFF'] == '0'){//0 for OFF		
								
							   ?>
						<input type="hidden" value="1" name="priceLISTONOFF" id="priceLISTONOFF" >
						<input type="checkbox" class="js-switch change_priceListONOFF"  data-switchery="true" value="" >
						<label for="subscribeNews"> Price List OFF</label>
							<?php } else { //1 for ON ?>
						<input type="hidden" value="0" name="priceLISTONOFF" id="priceLISTONOFF" >
						<input type="checkbox" class="js-switch change_priceListONOFF"  data-switchery="true" value="" checked >
						<label for="subscribeNews"> Price List ON</label>
						<?php } ?>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	
	
	</div>
		
	</div>



 <div id="myTabContent" class="tab-content list-vies-2" style="clear: both;">
				
<div role="tabpanel" class="col-md-8 col-sm-12 col-xs-12 vertical-border tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab" style="clear: both;"> 
	<div class="col-md-12 col-sm-12 col-xs-12">
		  <label class="col-md-3 col-sm-3 col-xs-12" for="type">Delivery Option Settings </label>
			<div class="col-md-9 col-sm-6 col-xs-12">
				<table class="table table-striped">
					<tbody>
						<tr>
						<th scope="row">Delivery Option Settings</th>
						<td>
							<?php $Delivery = $this->crm_model->get_compdata('company_detail',array('id'=> $this->companyGroupId));
                            
							$statusChecked = $Delivery[0]['crm_delivery_setting']==1?'checked':'';
  
						echo'<input type="checkbox" class="js-switch delivery_setting"  data-switchery="true"  value="'.$Delivery[0]['crm_delivery_setting'].'" data-value="'.$Delivery[0]['id'].'"  '.$statusChecked .'>'; if ($Delivery[0]['crm_delivery_setting']==1) {echo '<label for="subscribeNews"> Delivery Option Settings ON</label>'; }else{ echo '<label for="subscribeNews"> Delivery Option Settings OFF</label>';} ?>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	
	
	</div>
		
	</div>







	</div>
</div>
</div>									
</div>
</div>
</div>
</div>
	