<div class="x_content">
    <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	          <form class="form-search" method="get" action="<?= base_url() ?>account/ledgers">
    <input type="hidden" value='<?php if(isset($_GET['tab']))echo $_GET['tab']?>' name='tab'/>
				<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/ledgers?tab=<?php if(isset($_GET['tab']))echo $_GET['tab']?>">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						<a href="<?php echo base_url(); ?>account/ledgers?tab=<?php if(isset($_GET['tab']))echo $_GET['tab']?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
				</div>
			</form>	
	  </div>
	</div>
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<span class="mesg"></span>

	 <p class="text-muted font-13 m-b-30"></p>
<div class="row hidde_cls">
	<div class="col-md-12 export_div">
		
			<div class="btn-group"  role="group" aria-label="Basic example">
			    <?php if($can_add) {
		//echo '<button type="button" class="btn btn-success add_account_tabs addBtn" data-toggle="modal" id="add" data-id="ledger"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
		echo '<a href="'.base_url().'account/ledger_create" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
		setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
	} ?>
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
				<a href="<?= base_url('account/import_view') ?>"><button type="button" class="btn btn-default btn-sm" id="bbtn">Import</button></a>
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="javascript:void()" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="javascript:void()" title="Please check your open office Setting">Export to csv</a></li>
							<li id="export-to-blank-excel"><a href="javascript:void()" title="Please check your open office Setting">Export to Blank Excel</a></li>
						</ul>
				</div>
			</div>

	</div>
</div>
	  
	<form action="<?php echo site_url(); ?>account/ledgers" method="get" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
        <input type="hidden" value='<?php if(isset($_GET['tab']))echo $_GET['tab']?>' name='tab'/>
         <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search']?>' name='search'/>
	</form>
	<form action="<?php echo site_url(); ?>account/Create_ledgers_blankxls" method="post" id="export-form-blank">
		<input type="hidden" value='' id='hidden-type-blank-excel' name='ExportType_blank'/>
	</form>
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#active_ledger" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="submit_active_ledger()">Active Ledgers</a>
			</li>
			<!--li role="presentation" class=""><a href="#inactive_ledger" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" onClick="submit_inactive_ledger()">In Active Ledgers</a-->
		</ul>
		<div id="myTabContent" class="tab-content">
			<!--------------------------------------------------------Active Material----------------------------------------------------------------------->
		<div role="tabpanel" class="tab-pane fade active in" id="ledger_Active" aria-labelledby="home-tab">
		<div id="print_div_content">
		 
			<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>account/ledgers">
			<input type="hidden" name="order" id="order" value="<?php if($_POST['order']==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
		
		<form id="active_ledger_frm">	<input type="hidden" value="active_ledger" name="tab">	</form> 
			
			<table id="" class="table table-striped table-bordered cls_Added_csv" data-id="account" border="1" cellpadding="3">
				<thead>
					<tr>
						<th scope="col">Id<span><a href="<?php echo base_url(); ?>account/ledgers?tab=ledger_Active&sort=asc" class="up"></a>
						<a href="<?php echo base_url(); ?>account/ledgers?tab=ledger_Active&sort=desc" class="down"></a></span></th> 
						<th scope="col">Name
							<span><a href="<?php echo base_url(); ?>account/ledgers?tab=ledger_Active&sort=asc" class="up"></a>
								<a href="<?php echo base_url(); ?>account/ledgers?tab=ledger_Active&sort=desc" class="down"></a></span></th>
						<th scope="col">Group</th>
						<th scope="col">Opening Balance</th>
						<th scope="col">Phone</th>
						<th scope="col">Email</th>
						<!--th>GSTIN</th-->
						<th scope="col">Registration Type</th>
						<th scope="col">Created By</th>
						<th scope="col" class='hidde'>Edited By</th>
						<th scope="col">created On</th>				
						<th scope="col" class='hidde'>Action</th>   
					</tr>
				</thead>
				<tbody>
				   <?php 
		//echo phpinfo();die();
				   if(!empty($ledgers)){
					   foreach($ledgers as $ledger){ 
							$statusChecked = $ledger['activ_status']==1?'checked':'';
					  
						
					   $action = '';
						
						if($can_edit) {
								
								if($ledger["id"] <= '50'){ 
									$action .=  '<a href="javascript:void(0)" id="" data-id="ledger" class="btn btn-info btn-xs" id="' . $ledger["id"] . '" disabled data-tooltip="Edit"><i class="fa fa-pencil"></i></a>';
									
									$action .=  '<a href="javascript:void(0)" id="" data-id="ledger_view" class="btn btn-warning btn-xs" id="' . $ledger["id"] . '" disabled data-tooltip="View"><i class="fa fa-eye"></i></a>';
								}else{
								$action .=  '<a href="javascript:void(0)" id="'. $ledger["id"] . '" data-id="ledger" class="add_account_tabs btn btn-info btn-xs" id="' . $ledger["id"] . '" data-tooltip="Edit"><i class="fa fa-pencil"></i></a>';
								
								$action .=  '<a href="javascript:void(0)" id="'. $ledger["id"] . '" data-id="ledger_view" class="add_account_tabs btn btn-warning btn-xs" id="' . $ledger["id"] . '" data-tooltip="View"><i class="fa fa-eye"></i></a>';
								}
							}
							if($can_delete) { 
								if($ledger["id"] <= '50'){
								$action = $action.'<a href="javascript:void(0)" class=" btn btn-danger btn btn-info btn-xs" data-href="" disabled><i class="fa fa-trash"></i></a>';
								}else{
								$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deleteLedger/'.$ledger["id"].'" data-tooltip="Delete"><i class="fa fa-trash"></i></a>';
								}
							}
							// if($ledger['save_status'] ==1){
									// $action .=  '<input type="checkbox" class="js-switch change_ledgers_status"  data-switchery="true" style="display: none;" value="'.$ledger['activ_status'].'" 
									// data-value="'.$ledger['id'].'" '.$statusChecked .'>';
								// }
								
							//pre($ledger['account_group_id']);     
						$group = ($ledger['account_group_id']!=0)?(getNameById('account_group',$ledger['account_group_id'],'id')->name):'';
						
						// if($ledger['parent_ledger'] == ''){
							// $parent_ledger = '';
						// } 
						// $parent_ledger = ($ledger['parent_ledger']!=0)?(getNameById('ledger',$ledger['parent_ledger'],'id')->name):'';
						
						$edited_by = ($ledger['edited_by']!=0)?(getNameById('user_detail',$ledger['edited_by'],'u_id')->name):'';
						if($ledger['created_by'] == '0'){
							$cr_name = 'Super Admin';
						}else{
							$cr_name = getNameById('user_detail',$ledger['created_by'],'u_id')->name;
						}
						if($ledger['opening_balance'] == '0'){
								$opening_blance =  'N/A';
							}else{
								$opening_blance =  $ledger['opening_balance'];
							}
						if($ledger['gstin'] == ''){
								$gstin =  'N/A';
							}else{
								$gstin =  $ledger['gstin'];
							}
						if($ledger['registration_type'] == ''){
								$registration_type =  'N/A';
							}else{
								$registration_type =  $ledger['registration_type'];
							}
						if($ledger['phone_no'] == ''){
								$phone_no =  'N/A';
							}else{
								$phone_no =  $ledger['phone_no'];
							}
						if($ledger['email'] == ''){
								$email_idd =  'N/A';
							}else{
								$email_idd =  $ledger['email'];
							}		
						$draftImage = '';	
						if($ledger['save_status'] == 0)
						$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';

							
						echo "<tr>
							<td data-label='id:'>".$draftImage.$ledger['id']."</td>
							<td data-label='Name:'>".$ledger['name']."</td>
							<td data-label='Group:'>".$group."</td>
							<td data-label='Opening Balance:'>".money_format('%!i',$opening_blance)."</td>
							<td data-label='Phone:'>".$phone_no."</td>
							<td data-label='Email:'>".$email_idd."</td>
							
							<td data-label='Registration Type:'>".$registration_type."</td>        
							<td data-label='Created By:'><a href='".base_url()."users/edit/".$ledger['created_by']."'>".$cr_name."</a></td>	
							<td data-label='Edited By:' class='hidde'><a href='".base_url()."users/edit/".$ledger['edited_by']."'>".$edited_by."</a></td>	
							<td data-label='created On:'>".date("j F , Y", strtotime($ledger['created_date']))."</td>	
							<td data-label='Action:' class='hidde'>".$action."</td>	
						</tr>";
					
						 $output[] = array(
							   'Ledger ID' => $ledger['id'],
							   'Ledger Name' => $ledger['name'],
							   'Opening Balance' => $opening_blance,
							   'Phone' => $phone_no, 
							   'Email' => $email_idd,
							   'GSTIN' => $gstin,
							   'Registration Type' => $registration_type,
							   'Created Date' => date("d-m-Y", strtotime($ledger['created_date'])),
							);
							
						$output_blank[] = array(
							   'name' => '',
							   'account_group_id' => '',
							   'parent_group_id' => '',
							   'mailing_city' => '', 
							   'mailing_state' => '',
							   'mailing_country' => '',
							   'email' => '',
							   'gstin' => '',
							   'pan' => '',
							);						
					
						}
				$data3  = $output;
				$data_balnk  = $output_blank;
				export_csv_excel_blank($data_balnk); 
						 export_csv_excel($data3); 
				}   
			   ?>
					</tbody>                   
				</table>
						

			</div>
		</div>
		<form id="inactive_ledger_frm">	<input type="hidden" value="inactive_ledger" name="tab">	</form> 
		<div role="tabpanel" class="tab-pane fade" id="inactive_ledger" aria-labelledby="profile-tab">
		<table id="" class="table table-striped table-bordered cls_Added_csv" data-id="account" border="1" cellpadding="3">
				<thead>
					<tr>
						<th scope="col">Id
		<span><a href="<?php echo base_url(); ?>account/ledgers?tab=inactive_ledger&sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/ledgers?tab=inactive_ledger&sort=desc" class="down"></a></span></th> 
						<th scope="col">Name
		<span><a href="<?php echo base_url(); ?>account/ledgers?tab=inactive_ledger&sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>account/ledgers?tab=inactive_ledger&sort=desc" class="down"></a></span></th>
						<th scope="col">Group</th>
						<th scope="col">Opening Balance</th>
						<th scope="col">Phone</th>
						<th scope="col">Email</th>
						<!--th>GSTIN</th-->
						<th scope="col">Registration Type</th>
						<th scope="col">Created By</th>
						<th scope="col" class='hidde'>Edited By</th>
						<th scope="col">created On</th>				
						<th scope="col" class='hidde'>Action</th>   
					</tr>
				</thead>
				<tbody>
				   <?php 
		//echo phpinfo();die();
				   if(!empty($ledgers_inactive)){
					 $count=0;
					   foreach($ledgers_inactive as $inactv_ledger){ 
							$statusChecked = $inactv_ledger['activ_status']==1?'checked':'';
					  
						
					   $action = '';
						
						if($can_edit) {
								
								if($inactv_ledger["id"] <= '50'){ 
									//$action .=  '<a href="javascript:void(0)" id="" data-id="ledger" class="btn btn-info btn-xs" id="' . $inactv_ledger["id"] . '" disabled><i class="fa fa-pencil"></i> Edit </a>';
									
									$action .=  '<a href="javascript:void(0)" id="" data-id="ledger_view" class="btn btn-warning btn-xs" id="' . $inactv_ledger["id"] . '" disabled><i class="fa fa-eye"></i> View </a>';
								}else{
								//$action .=  '<a href="javascript:void(0)" id="'. $inactv_ledger["id"] . '" data-id="ledger" class="add_account_tabs btn btn-info btn-xs" id="' . $inactv_ledger["id"] . '"><i class="fa fa-pencil"></i> Edit </a>';
								
								$action .=  '<a href="javascript:void(0)" id="'. $inactv_ledger["id"] . '" data-id="ledger_view" class="add_account_tabs btn btn-warning btn-xs" id="' . $inactv_ledger["id"] . '"><i class="fa fa-eye"></i> View </a>';
								}
							}
							// if($can_delete) { 
								// if($inactv_ledger["id"] == '1' || $ledger["id"] == '2'  || $inactv_ledger["id"] == '3'){
								// $action = $action.'<a href="javascript:void(0)" class=" btn btn-danger btn btn-info btn-xs" data-href="" disabled><i class="fa fa-trash"></i>Delete</a>';
								// }else{
								// $action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deleteLedger/'.$inactv_ledger["id"].'"><i class="fa fa-trash"></i>Delete</a>';
								// }
							// }
							if($inactv_ledger['save_status'] ==1){
											$action .=  '
											<input type="checkbox" class="js-switch change_ledgers_status"  data-switchery="true" style="display: none;" value="'.$inactv_ledger['activ_status'].'" 
											data-value="'.$inactv_ledger['id'].'" '.$statusChecked .'>';
										}
							//pre($ledger['account_group_id']);     
						$group = ($inactv_ledger['account_group_id']!=0)?(getNameById('account_group',$inactv_ledger['account_group_id'],'id')->name):'';
						
						// if($ledger['parent_ledger'] == ''){
							// $parent_ledger = '';
						// } 
						// $parent_ledger = ($ledger['parent_ledger']!=0)?(getNameById('ledger',$ledger['parent_ledger'],'id')->name):'';
						
						$edited_by = ($inactv_ledger['edited_by']!=0)?(getNameById('user_detail',$inactv_ledger['edited_by'],'u_id')->name):'';
						if($inactv_ledger['created_by'] == '0'){
							$cr_name = 'Super Admin';
						}else{
							$cr_name = getNameById('user_detail',$inactv_ledger['created_by'],'u_id')->name;
						}
						if($inactv_ledger['opening_balance'] == '0'){
								$opening_blance =  'N/A';
							}else{
								$opening_blance =  $inactv_ledger['opening_balance'];
							}
						if($inactv_ledger['gstin'] == ''){
								$gstin =  'N/A';
							}else{
								$gstin =  $inactv_ledger['gstin'];
							}
						if($inactv_ledger['registration_type'] == ''){
								$registration_type =  'N/A';
							}else{
								$registration_type =  $inactv_ledger['registration_type'];
							}
						if($inactv_ledger['phone_no'] == ''){
								$phone_no =  'N/A';
							}else{
								$phone_no =  $inactv_ledger['phone_no'];
							}
						if($inactv_ledger['email'] == ''){
								$email_idd =  'N/A';
							}else{
								$email_idd =  $inactv_ledger['email'];
							}		
						$draftImage = '';	
						if($inactv_ledger['save_status'] == 0)
						$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';

							
						echo "<tr>
							<td data-label='id:'>".$draftImage.$inactv_ledger['id']."</td>
							<td data-label='Name:'>".$inactv_ledger['name']."</td>
							<td data-label='Group:'>".$group."</td>
							<td data-label='Opening Balance:'>".money_format('%!i',$opening_blance)."</td>
							<td data-label='Phone:'>".$phone_no."</td>
							<td data-label='Email:'>".$email_idd."</td>
							
							<td data-label='Registration Type:'>".$registration_type."</td>        
							<td data-label='Created By:'><a href='".base_url()."users/edit/".$inactv_ledger['created_by']."'>".$cr_name."</a></td>	
							<td data-label='Edited By:' class='hidde'><a href='".base_url()."users/edit/".$inactv_ledger['edited_by']."'>".$edited_by."</a></td>	
							<td data-label='created On:'>".date("j F , Y", strtotime($inactv_ledger['created_date']))."</td>	
							<td data-label='Action:' class='hidde'>".$action."</td>	
						</tr>";
					
						 $output[] = array(
							   'Ledger ID' => $inactv_ledger['id'],
							   'Ledger Name' => $inactv_ledger['name'],
							   'Opening Balance' => $opening_blance,
							   'Phone' => $phone_no, 
							   'Email' => $email_idd,
							   'GSTIN' => $gstin,
							   'Registration Type' => $registration_type,
							   'Created Date' => date("d-m-Y", strtotime($inactv_ledger['created_date'])),
							);
							
						$output_blank[] = array(
							   'name' => '',
							   'account_group_id' => '',
							   'parent_group_id' => '',
							   'mailing_city' => '', 
							   'mailing_state' => '',
							   'mailing_country' => '',
							   'email' => '',
							   'gstin' => '',
							   'pan' => '',
							);						
					$count++;
						}
				$data3  = $output;
				$data_balnk  = $output_blank;
				export_csv_excel_blank($data_balnk); 
						 export_csv_excel($data3); 
				}   
			   ?>
					</tbody>                   
				</table>
			
	
		</div>
	</div>
</div>
</div>
<?php echo $this->pagination->create_links();?>
 <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
<div id="account_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Add Ledger</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>


