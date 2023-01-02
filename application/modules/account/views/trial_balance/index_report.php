 
<div class="x_content">
    <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	        <div class="col-md-4">
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/trial_balance"/>
						</div>
					  </div>
					</div>
					<form action="<?php echo base_url(); ?>account/trial_balance" method="get" id="date_range" >	
					   <input type="hidden" value='' class='start_date' name='start'/>
					  <input type="hidden" value='' class='end_date' name='end'/>
					</form>	
			</fieldset>
	    </div>
	  </div>
	</div>

	<?php

		if($this->session->flashdata('message') != ''){
			echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
		}
		
		$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$Login_user_id = $this->companyGroupId;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
	?>
	<?php
	if($company_brnaches->multi_loc_on_off == 1){
		if(!empty($company_brnaches)){
	?>
	<form action="<?php echo site_url(); ?>account/trial_balance" method="get" id="select_from_brnch">
		<div class="required item form-group company_brnch_div" >
			<label class="col-md-8 col-sm-8 col-xs-12 required control-label col-md-3 col-sm-2 col-xs-4" for="company_branch">Company Branch</label>
			<div class="col-md-3 col-sm-3 col-xs-12">
			<select class="itemName form-control Get_data_accoriding_tobranch" name="selected_branch_idd" required="required" 
				name="compny_branch_id" width="100%">
				<option value=""> Select Company Branch </option>
				<option >All</option>
				<?php
					 $branch_Add = json_decode($company_brnaches->address);
					 foreach($branch_Add as $val_branch){ ?>
					<option <?php if($val_branch->add_id == $_POST['selected_branch_idd']){ ?> selected="selected" <?php }?> value="<?php echo $val_branch->add_id; ?>"><?php echo $val_branch->compny_branch_name; $_POST['compny_branch_id']; ?> </option>
					
				</option>
			<?php } ?>
			</select>		
						
			</div>
			<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
			<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
			<!--button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
			<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_excel">Create Excel</button-->
			<input type="submit" value="Filter" class="btn btn-info">
		</div>
	</form>	
	<?php 
	} 
	}
	setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
	?>
	<div class="item form-group">
		<div class="item form-group" >		
		<div class="row hidde_cls ">
			<div class="col-md-12 export_div">
				
					<div class="btn-group"  role="group" aria-label="Basic example">
						<!--button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
						<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button-->
						<form action="<?php echo base_url(); ?>account/trial_balance" method="get" id="date_range56" >
							<input type="hidden" name="create_excel" value="checkk">
							<input type="hidden" name="On_selected_Branch_idd" value="<?php echo $_GET['selected_branch_idd']; ?>" id="selected_branch_id">
							<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
							<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_excel">Create Excel</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="create_pdf">Create PDF</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" onclick="window.location.href='<?php echo site_url(); ?>account/trial_balance'">Reset</button>

						</form>
						<form action="<?php echo base_url(); ?>account/trial_balance" method="get" id="date_range556" >
							<input type="hidden" name="create_PDF" value="checkk_pdf">
							
							<input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
							<input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
						</form>
							
					</div>
				
			</div>
		</div>
		<div id="print_div_content">
		<!-- id="trial_balance_id" -->
		<table    class="table table-striped table-bordered" border="1" style="margin-top:40px !important;">
		<thead>
		   <th>ID</th>
		   <th>Start to End Date</th>
		   <th>File Name</th>
		   <th>Debit Total</th>
		   <th>Credit Total</th>
		   <th>Created Date</th>
		   <th>Created By</th>
		   <th>Action</th>
		</thead>
		<tbody>
		<?php 
		
		    if(!empty($report_data)){

			foreach($report_data as $val){
				$action = '';
					$action .=  '<a download="'.$val["file_name"].'" href="'.base_url().'assets/modules/account/trial_balance/'.$val['file_name'].'" data-tooltip="Download File" class="btn   btn  btn-xs"><i class="fa fa-download" aria-hidden="true"></i>  </a>';
					
					$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn  btn-delete  btn  btn-xs" data-tooltip="Delete"   data-href="'.base_url().'account/deleteTrialBlanance_dtl/'.$val["id"].'" ><i class="fa fa-trash"></i></a>';
				
				$first_date_con = date("d-M-Y", strtotime($val['report_start_date']));
				$second_date_con = date("d-M-Y", strtotime($val['report_end_date']));
				$ddate = 	 $first_date_con .' To '. $second_date_con  ;
				
				echo '<tr>';
					echo '<td>'.$val['id'].'</td>';
					echo '<th>'.$ddate.'</th>';
					echo '<td>'.$val['file_name'].'</td>';
					echo '<td>'.money_format('%!i', $val['debit_total']).'</td>';
					echo '<td>'.money_format('%!i', $val['credit_total']).'</td>';
					echo '<td>'.date("d - M - Y", strtotime($val['created_date'])).'</td>';
					echo '<td>'.getNameById('user_detail',$val['created_by'],'u_id')->name.'</td>';
					echo '<td>'.$action.'</td>';
				echo '</tr>';
				
			}
			}else{
				echo '<tr><td colspan="8" style="text-align: center; vertical-align: middle;"> No Data Available </td></tr>';
			}
		?>
		</tbody>
		</table>
		
		</div>
	</div>
</div>
</div>
<?php $this->load->view('common_modal'); ?>