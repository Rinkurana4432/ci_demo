<?php error_reporting(0);?>
<div class="x_content">
   <?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      }?>
   <div class="leadBasicData">
      <div class="alert alert-info" style="display:none;">Tender status changed successfully</div>
   </div>
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <div class="col-md-4 datePick-left">
            <input type="hidden" value='register_opportunity' id="table" data-msg="register_opportunity" data-path="bid_management/register_opportunity"/>
            <input type="hidden" id="loggedInUserId" name="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
            <input type="hidden" name="rating" id="rating" />
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /* <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value=""  data-table="crm/leads"/>*/?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="crm/leads"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>bid_management/register_opportunity" method="post" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
      </div>
   </div>
   <div class="stik">
      <div class="col-md-12 export_div">
         <?php  //pre($leadStatus['']); ?>
         <div class="btn-group" role="group" aria-label="Basic example">
            <!---		 <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
               							<li id="export-to-excel"><a href="<?php echo base_url(); ?>crm/exportLeads" title="Please check your open office Setting">Export to excel</a></li>
               							<li id="export-to-csv"><a href="<?php echo base_url();?>assets/modules/crm/downloads/LEADS.xls" title="Please check your open office Setting">Export to Blank Excel</a></li>
               </ul>
               --->
            <form action="<?php echo base_url(); ?>bid_management/register_opportunity" method="post" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_POST['start'])){echo $_POST['start'];}?>' class='start' name='start'/>
               <input type="hidden" value='<?php if(!empty($_POST['end'])){echo $_POST['end'];} ?>' class='end' name='end'/>
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            <?php if($can_add) {
               //echo '<a href="'.base_url().'crm/edit_lead/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
               echo '<button type="button" class="btn btn-success addBtn add_bid_mng_tabs" data-toggle="modal" id="add" data-id="register_opportunity_edit"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
               } ?>
            <div class="Validate">
               <button type="button" class="btn btn-default velidate" data-toggle="collapse" data-target="#demo3">Validate<span class="caret"></span>
               </button>
               <div id="demo3" class="collapse">
                  <div class='hidde ' style="pointer-events:">
                     <div>Approve:
                        <input type='radio' class='validatesr' name='status_' value='Approve'/ >
                     </div>
                     <div>Disapprove:
                        <input type='radio' class='disapprove' name='status_' value='Disapprove'/ >
                     </div>
                     <p class='disapprove_reason'></p>
                  </div>
               </div>
            </div>
			<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Import<span class="caret"></span></button>
               <ul class="dropdown-menu import-bar" role="menu" id="export-menu">
                  <li >
                     <form action="<?php echo base_url(); ?>bid_management/importbid" method="post" enctype="multipart/form-data">	
                        <input type="file" class="form-control col-md-2" name="uploadFile" id="file" style="width: 70%">
                        <input type="submit" class="form-control col-md-2" name="importe" value="Upload" style="width: 30%;" />
                     </form>
                  </li>
               </ul>
            </div>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  <li id="export-to-blank-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Blank Excel</a></li>
               </ul>
            </div>
            <form action="<?php echo site_url(); ?>bid_management/Create_blankxls" method="post" id="export-form-blank">
               <input type="hidden" value='' id='hidden-type-blank-excel' name='ExportType_blank'/>
            </form>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
            <button class="btn btn-secondary dropdown-toggle btn-default filter" type="button" onclick="myFunction()"><i class="fa fa-filter" aria-hidden="true"></i>Filter<span class="caret"></span></button>
               <select style="width: auto; float: right;" class="form-control" id="staus" tabindex="-1" aria-hidden="true">				
               <option value="">Change Status</option>
               <option value="1">New</option>
               <option value="2">Contacted</option>
               <option value="3">Qualified</option>
               <option value="4">Unqualified</option>
               <option value="5">Win</option>
               <option value="6">Loose</option>				
               </select>-->
         </div>
         <div class="col-md-4 col-sm-12 datePick-right">
            
            <!--	<ul class="dropdown-menu import-bar" role="menu" id="export-menu">
               <form action="<?php echo base_url(); ?>crm/importLeads" method="post" enctype="multipart/form-data">	
               
               <input type="file" class="form-control col-md-2" name="uploadFile" id="file" style="width: 70%">
               <input type="submit" class="form-control col-md-2" name="importe" value="Import"  style="width: 30%" />
               
               </form>
               </ul>
               
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Import<span class="caret"></span></button>-->
            <form action="<?php echo base_url(); ?>bid_management/register_opportunity" method="post" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-6 col-xs-12" id="myDIV1" style="display:none;">
      <select class="form-control" id="lead_status_filter" width="100%" tabindex="-1" aria-hidden="true">				
      <?php			
         echo '<option value="">All</option>';				
         foreach($tender_status as $ls){
         		echo '<option value="'.$ls['id'].'">'.$ls['name'].'</option>';					
         }				
         ?>
      </select>
   </div>
   <?php /*if(!empty($leads) && $can_view){ ?>
   <div class="col-md-6 col-sm-6 col-xs-12">
      Filter By Lead Owner	
      <select class="form-control" id="lead_owner_filter" width="100%" tabindex="-1" aria-hidden="true">
      <?php	
         echo '<option value="">All</option>';					
         foreach($lead_owner as $lo){
         		echo '<option value="'.$lo['id'].'">'.$lo['name'].'</option>';					
         }*/
         ?>
      </select>
   </div>
   <?php //} ?>
   <p class="text-muted font-13 m-b-30"></p>
   <?php if(!empty($leads)){ ?>
   <div class="row hidde_cls">
      <div class="col-md-12">
         <div class="col-md-4">
         </div>
         <div class="col-md-4">
         </div>
      </div>
   </div>
   <?php } ?>		
   <div class="x_content">
      <div class="" role="tabpanel" data-example-id="togglable-tabs">
         <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#new_leads" role="tab" id="new_lead_tab" data-toggle="tab" aria-expanded="true">Key Info</a></li>
            <li role="presentation" class="approve"><a href="#new_leads_approve" role="tab" id="new_lead_approve_tab" data-toggle="tab" aria-expanded="false">Result</a></li>
         </ul>
         <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="new_leads" aria-labelledby="new_lead_tab">
               <div id="print_div_content">
                  <table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3">
                     <thead>
                        <tr>
                           <th>All<br><input id="selecctall" type="checkbox"></th>
                           <th>Tender Number</th>
                           <th>Tender Type</th>
                           <th>Issue Date</th>
                           <th>Bid Clossing Date</th>
                           <th>EMD Amount</th>
                           <th>Tender Amount</th>
                           <th>Tender Status</th>
                           <th>Status Comment</th>
                           <th class='hidde'>Created Date</th>
                           <th class='hidde'>Validate</th>
                           <th class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($register_opportunity)){
                           foreach($register_opportunity as $register_fr_opportunity){
                           	$primaryname = array();
                           if($register_fr_opportunity['tender_detail'] !=''){
                           $contacts_info = json_decode($register_fr_opportunity['tender_detail']);
                           		$primaryname	 = $contacts_info[0];
                           	}
                           $material_name_id = array();
                           if($register_fr_opportunity['product_detail'] !=''){
                           $product_info = json_decode($register_fr_opportunity['product_detail']);
                           		$material_name_id	 = $product_info[0];
                           	}								
                           	
                           $validatedBy = (!empty($register_opportunity['validated_by'])!=0)?(getNameById('user_detail',$register_opportunity['validated_by'],'u_id')):''; 
                           $validatedByName = (!empty($validatedBy))?$validatedBy->name:'';
                           
                           	$action = '';
                           	if($can_edit) { 
                           		
                           		$action =  '<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_edit" data-tooltip="Edit" class="add_bid_mng_tabs btn btn-edit  btn-xs">
                           		<i class="fa fa-pencil"></i> </a>';
                           
                           	}
                           #	if($can_view) {
                           		$action .=  '<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_view"  data-tooltip="View" class="add_bid_mng_tabs btn btn-view  btn-xs" id="' . $register_fr_opportunity["id"] . '"><i class="fa fa-eye"></i> </a>';
                           #	}
                           
                           		if($can_delete) { 
                           		$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'bid_management/delete_register_opportunity/'.$register_fr_opportunity["id"].'"><i class="fa fa-trash"></i></a>';
                           	}
                           		$action .='<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_con" data-tooltip="Conversion" class="add_bid_mng_tabs btn btn-edit  btn-xs">Result</a>';
                           
                           			if($register_fr_opportunity['favourite_sts'] == '1'){
                           				$rr = 'checked';
                           			}else{
                           			$rr = '';
                           		}
                           
                           
                           	
                           	$draftImage = '';
                           	if($register_fr_opportunity['save_status'] == 0)
                           		$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
                           		<img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                           		   echo "<tr><td>";
                           		   
                           if($register_fr_opportunity['save_status'] == 1 && ($register_fr_opportunity["approve"] == 0 || $register_fr_opportunity["approve"] == '')){
                           $disable = '';
                           }elseif($register_fr_opportunity['save_status'] == 0 || ($register_fr_opportunity["approve"] == 1)){
                           $disable = 'disabled';
                           }elseif($register_fr_opportunity['save_status'] == 0 || ($register_fr_opportunity["approve"] == 1) || ($can_validate == '')){
                           $disable = 'disabled';
                           }else{
                           $disable = '';
                           }		   										   
                           if($register_fr_opportunity["approve"] == 0){
                           echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$register_fr_opportunity['id']."  value=".$register_fr_opportunity['id'].">";}
                           				
                           		   		if($register_fr_opportunity['favourite_sts'] == '1'){
                           		   				echo "<input class='star' type='checkbox'  title='Mark Record' value=".$register_fr_opportunity['id']."  checked = 'checked'><br/>";
                           		   				echo"<input type='hidden' value='register_opportunity' id='favr' data-msg='Tenders ' data-path='bid_management/register_opportunity' favour-sts='0' id-recd=".$register_fr_opportunity['id'].">";
                           		   		}else{
                           						echo "<input class='star' type='checkbox'  title='Mark Record' value=".$register_fr_opportunity['id']."><br/>";
                           						echo"<input type='hidden' value='register_opportunity' id='favr' data-msg='Register Opportunity ' data-path='bid_management/register_opportunity' favour-sts='1' id-recd =".$register_fr_opportunity['id'].">";
                           		   		}
                           		   		
                           		   		echo "</td>
                           <td>".$draftImage . $tender_num=$primaryname->tender_name;
                           
                           				echo "</td><td>";
                           				$tender_link=$primaryname->tender_link;
                           				if(!empty($primaryname)){ echo $primaryname->tender_link;}else {echo '';}
                           				echo "</td>
                           				
                           				<td>".$register_fr_opportunity['issue_date']."</td>
                           				<td>".$register_fr_opportunity['clossing_date']."</td>
                           				<td>".$register_fr_opportunity['emd_amount']."</td>
                           				<td>".$register_fr_opportunity['tender_amount']."</td>
                           				<td>";if($register_fr_opportunity['tender_status'] !='' && $register_fr_opportunity['tender_status'] != 0) 
                           {	
                           $tender_status = getNameById('tender_status',$register_fr_opportunity['tender_status'],'id');
                           echo $tenderStatus = $tender_status->name; 
                           } echo "</td>	
                           <td>".$register_fr_opportunity['status_comment']."</td>	
                           <td class='hidde'>".date("j F , Y", strtotime($register_fr_opportunity['created_date']))."</td>	
                           <td class='hidde".$can_validate."?'':'disabled''>"; 
                           $selectApprove = $register_fr_opportunity['approve']==1?'checked':'';
                           $selectDisapprove = $register_fr_opportunity['disapprove']==1?'checked':'';
                           if($selectApprove =='checked'){
                           echo "
                           Approve:
                           <input type='radio' class='validate' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Approve'/ ".$selectApprove." ".$disable."> Disapprove:
                           <input type='radio' class='disapprove' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
                           <p class='disapprove_reason'>".$register_fr_opportunity['disapprove_reason']."</p>
                           <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                           }else{
                           echo "
                           Approve:
                           <input type='radio' class='validate' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
                           <input type='radio' class='disapprove' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
                           <p class='disapprove_reason'>".$register_fr_opportunity['disapprove_reason']."</p>
                           <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                           }
                           echo "</td>		
                           <td class='hidde'>".$action. "</td>	
                           			</tr>";
                           if($register_fr_opportunity['tender_status'] !='' && $register_fr_opportunity['tender_status'] != 0) 
                           {	
                           $tender_status = getNameById('tender_status',$register_fr_opportunity['tender_status'],'id');
                           $tenderStatus = $tender_status->name; 
                           }
                           $dept=$primaryname->department_name;
                           //pre($material_name_id);
                           if($register_fr_opportunity['product_detail']!=''){
                           $product_info = json_decode($register_fr_opportunity['product_detail'],true);
                           foreach($product_info as $data){
                           //pre($data);
                           $qty = $data['qty'];
                           $price = $data['price'];		
                           $material_name=getNameById('material',$data['material_name_id'],'id');
                           $material_name = $material_name->material_name;	
                           $output[] = array(
                           'Department'=>$dept,
                           'Location'=>$register_fr_opportunity['bid_location'],
                           'Tender Number' => $tender_num,
                           'Tender Type' => $tender_link,
                           'Issue Date' => $register_fr_opportunity['issue_date'],
                           'Bid Clossing Date' => $register_fr_opportunity['clossing_date'],
                           'EMD Amount' => $register_fr_opportunity['emd_amount'],
                           'Tender Amount' => $register_fr_opportunity['tender_amount'],
                           'Tender Status' =>$tender_status->name,
                           'Status Comment' => $register_fr_opportunity['status_comment'],
                           'Bid id'=>$register_fr_opportunity['bid_id'],
                           'Filling Date' => date("d-m-Y", strtotime($register_fr_opportunity['created_date'])),
                           'Item Name'=>$material_name,
                           'Qty'=>$qty,
                           'price'=>$price,
                           );	
                           }
                           }		}					$data3  = $output;
                           		export_csv_excel($data3);
                           }
                           ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="new_leads_approve" aria-labelledby="new_lead_approve_tab">
               <div id="print_div_content">
                  <table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                     <thead>
                        <tr>
                           <th>All<br><input id="selecctall" type="checkbox"></th>
                           <th>Tender Number</th>
                           <!--<th>Tender Number</th>-->
                           <th>Tender Type</th>
                           <th>Issue Date</th>
                           <th>Bid Clossing Date</th>
                           <th>EMD Amount</th>
                           <th>Tender Amount</th>
                           <th>Tender Status</th>
                           <th>Status Comment</th>
                           <th class='hidde'>Created Date</th>
                           <th class='hidde'>Validate</th>
                           <th class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($register_opportunity1)){
                           foreach($register_opportunity1 as $register_fr_opportunity){
                           	$primaryname = array();
                           if($register_fr_opportunity['tender_detail'] !=''){
                           $contacts_info = json_decode($register_fr_opportunity['tender_detail']);
                           		$primaryname	 = $contacts_info[0];
                           	}
                           	
                           $validatedBy = (!empty($register_opportunity['validated_by'])!=0)?(getNameById('user_detail',$register_opportunity['validated_by'],'u_id')):''; 
                           $validatedByName = (!empty($validatedBy))?$validatedBy->name:'';
                           
                           	$action = '';
                           	if($can_edit) { 
                           		
                           		$action =  '<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_edit" data-tooltip="Edit" class="add_bid_mng_tabs btn btn-edit  btn-xs">
                           		<i class="fa fa-pencil"></i> </a>';
                           
                           	}
                           #	if($can_view) {
                           		$action .=  '<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_view"  data-tooltip="View" class="add_bid_mng_tabs btn btn-view  btn-xs" id="' . $register_fr_opportunity["id"] . '"><i class="fa fa-eye"></i> </a>';
                           #	}
                           
                           		if($can_delete) { 
                           		$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'bid_management/delete_register_opportunity/'.$register_fr_opportunity["id"].'"><i class="fa fa-trash"></i></a>';
                           	}
                           		$action .='<a href="javascript:void(0)" id="'. $register_fr_opportunity["id"] . '" data-id="register_opportunity_con" data-tooltip="Conversion" class="add_bid_mng_tabs btn btn-edit  btn-xs">Result</a>';
                           		
                           $sale_order=$this->bid_management_model->get_data_byId('sale_order','tender_id',$register_fr_opportunity["id"]);
                           if($sale_order==''){
                           $action .='<button type="button" data-id="sale_order_edit" data-tooltip="Edit" class="add_bid_mng_tabs btn btn-edit btn-xs pull-right" data-toggle="modal" id="'.$register_fr_opportunity["id"].'">Sale Order Conversion</button>'; }
                           else{
                           $action .='<button type="button" class="btn btn-edit btn-xs pull-right">Sale Order Converted</button>';
                           } 
                           			if($register_fr_opportunity['favourite_sts'] == '1'){
                           				$rr = 'checked';
                           			}else{
                           			$rr = '';
                           		}
                           
                           
                           	
                           	$draftImage = '';
                           	if($register_fr_opportunity['save_status'] == 0)
                           		$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
                           		<img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                           		   echo "<tr><td>";
                           		   
                           if($register_fr_opportunity['save_status'] == 1 && ($register_fr_opportunity["approve"] == 0 || $register_fr_opportunity["approve"] == '')){
                           $disable = '';
                           }elseif($register_fr_opportunity['save_status'] == 0 || ($register_fr_opportunity["approve"] == 1)){
                           $disable = 'disabled';
                           }elseif($register_fr_opportunity['save_status'] == 0 || ($register_fr_opportunity["approve"] == 1) || ($can_validate == '')){
                           $disable = 'disabled';
                           }else{
                           $disable = '';
                           }		   										   
                           		   		if($register_fr_opportunity["approve"] == 0){
                           echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$register_fr_opportunity['id']."  value=".$register_fr_opportunity['id'].">";}
                           		   		if($register_fr_opportunity['favourite_sts'] == '1'){
                           		   				echo "<input class='star' type='checkbox'  title='Mark Record' value=".$register_fr_opportunity['id']."  checked = 'checked'><br/>";
                           		   				echo"<input type='hidden' value='register_opportunity' id='favr' data-msg='Tenders Unmarked' data-path='bid_management/register_opportunity' favour-sts='0' id-recd=".$register_fr_opportunity['id'].">";
                           		   		}else{
                           						echo "<input class='star' type='checkbox'  title='Mark Record' value=".$register_fr_opportunity['id']."><br/>";
                           						echo"<input type='hidden' value='register_opportunity' id='favr' data-msg='Register Opurtunity Marked' data-path='bid_management/register_opportunity' favour-sts='1' id-recd =".$register_fr_opportunity['id'].">";
                           		   		}
                           		   		
                           		   		echo "</td>
                           				<td>".$draftImage .$primaryname->tender_name;
                           echo "</td><td>";
                           				$tender_link=$primaryname->tender_link;
                           				if(!empty($primaryname)){ echo $primaryname->tender_link;}else {echo '';}
                           				echo "</td>
                           				
                           				<td>".$register_fr_opportunity['issue_date']."</td>
                           				<td>".$register_fr_opportunity['clossing_date']."</td>
                           				<td>".$register_fr_opportunity['emd_amount']."</td>
                           				<td>".$register_fr_opportunity['tender_amount']."</td>
                           				<td>";if($register_fr_opportunity['tender_status'] !='' && $register_fr_opportunity['tender_status'] != 0) 
                           {	
                           $tender_status = getNameById('tender_status',$register_fr_opportunity['tender_status'],'id');
                           echo $tenderStatus = $tender_status->name; 
                           } echo "</td>	
                           				<td>".$register_fr_opportunity['status_comment']."</td>	
                           <td class='hidde'>".date("j F , Y", strtotime($register_fr_opportunity['created_date']))."</td>	
                           <td class='hidde".$can_validate."?'':'disabled''>"; 
                           $selectApprove = $register_fr_opportunity['approve']==1?'checked':'';
                           $selectDisapprove = $register_fr_opportunity['disapprove']==1?'checked':'';
                           if($selectApprove =='checked'){
                           echo "
                           Approve:
                           <input type='radio' class='validate' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Approve'/ ".$selectApprove." ".$disable."> Disapprove:
                           <input type='radio' class='disapprove' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
                           <p class='disapprove_reason'>".$register_fr_opportunity['disapprove_reason']."</p>
                           <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                           }else{
                           echo "
                           Approve:
                           <input type='radio' class='validate' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
                           <input type='radio' class='disapprove' data-idd='".$register_fr_opportunity['id']."' name='status_".$register_fr_opportunity['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
                           <p class='disapprove_reason'>".$register_fr_opportunity['disapprove_reason']."</p>
                           <p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                           }
                           echo "</td>		
                           <td class='hidde'>".$action. "</td>	
                           			</tr>";
                           if($register_fr_opportunity['tender_status'] !='' && $register_fr_opportunity['tender_status'] != 0) 
                           {	
                           $tender_status = getNameById('tender_status',$register_fr_opportunity['tender_status'],'id');
                           $tenderStatus = $tender_status->name; 
                           }
                           if($register_fr_opportunity['product_detail']!=''){
                           $product_info = json_decode($register_fr_opportunity['product_detail'],true);
                           foreach($product_info as $data){
                           //pre($data);
                           $qty = $data['qty'];	
                           $price = $data['price'];	
                           $material_name=getNameById('material',$data['material_name_id'],'id');
                           
                           $material_name = $material_name->material_name;	
                           
                           //echo $data['material_name_id'];		
                           
                           $output[] = array(
                           'Department'=>$dept,
                           'Location'=>$register_fr_opportunity['bid_location'],
                           'Tender Number' => $tender_num,
                           'Tender Type' => $tender_link,
                           'Issue Date' => $register_fr_opportunity['issue_date'],
                           'Bid Clossing Date' => $register_fr_opportunity['clossing_date'],
                           'EMD Amount' => $register_fr_opportunity['emd_amount'],
                           'Tender Amount' => $register_fr_opportunity['tender_amount'],
                           'Tender Status' =>$tender_status->name,
                           'Status Comment' => $register_fr_opportunity['status_comment'],
                           'Bid id'=>$register_fr_opportunity['bid_id'],
                           'Filling Date' => date("d-m-Y", strtotime($register_fr_opportunity['created_date'])),
                           'Item Name'=>$material_name,
                           'Qty'=>$qty,
                           'Price'=>$price
                           );	
                           }
                           }		}					$data3  = $output;
                           		export_csv_excel($data3);
                           }
                           ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /*<div class="x_content">
   <div id="print_div_content">
                       <table id="datatable-buttons" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3">
   		<thead>
   			<tr>
   				<th>Id</th>
   				<th>Company</th>
   				<th>Name</th>
   				<th>Email</th>
   				<th>Phone No.</th>
   				<th>Lead Owner</th>
   				<th>Lead Head / Created By </th>
   				<th>Lead Status</th>
   				<th>Status Comment</th>
   				<th class='hidde'>Created Date</th>
   				<th class='hidde'>Action</th>
   			</tr>
   		</thead>
   		<tbody>
   			<?php if(!empty($leads)){
      foreach($leads as $lead){
      	$primaryContact = array();
      	if(!empty($lead) && $lead['lead_status'] !='' && $lead['lead_status'] != 0) {										
      					$lead_status = getNameById('lead_status',$lead['lead_status'],'id');
      					 $leadStatus = $lead_status->name; 
      					}
      				
      	if($lead['contacts'] !=''){
      		$contacts_info = json_decode($lead['contacts']);
      		$primaryContact	 = $contacts_info[0];
      	}
      	$action = '';
      	if($can_edit) { 
      		//$action = $action.'<a href="'.base_url().'crm/edit_lead/'.$lead["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>';		
      		$convertedLeadDisabled = ($lead['converted_to_account'] == 1 || $lead['converted_to_contact'] == 1)?'disableBtnClick':'';
      		$convertedLeadDisableEdit = ($lead['converted_to_account'] == 1 || $lead['converted_to_contact'] == 1)?'disabled':'';
      		$action =  '<a href="javascript:void(0)" id="'. $lead["id"] . '" data-id="lead" data-tooltip="Edit" class="add_crm_tabs btn btn-edit  btn-xs '.$convertedLeadDisabled.'" id="' . $lead["id"] . '" '.$convertedLeadDisableEdit.'><i class="fa fa-pencil"></i> </a>';
      	}
      		if($can_view) {
      			$action .=  '<a href="javascript:void(0)" id="'. $lead["id"] . '" data-id="lead_view"  data-tooltip="View" class="add_crm_tabs btn btn-view  btn-xs" id="' . $lead["id"] . '"><i class="fa fa-eye"></i> </a>';
      	}
      	if($can_delete) { 
      		$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteLead/'.$lead["id"].'"><i class="fa fa-trash"></i></a>';
      	}
          $convertedLeadColor = ($lead['converted_to_account'] == 1 || $lead['converted_to_contact'] == 1)?'#de1a1a30':'';
          $draftImage = '';
      	if($lead['save_status'] == 0)
      	$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
      <img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
         echo "<tr>
      		<td>".$draftImage . $lead['id']."</td>
      		<td>".$lead['company']."</td>
      		<td>";
      		if(!empty($primaryContact)){ echo $primaryContact->first_name." ".$primaryContact->last_name; }else {echo '';}
      		echo "</td>
      		<td>";
      		if(!empty($primaryContact)){ echo $primaryContact->email; }else {echo '';}
      		echo "</td>
      		<td>";
      		if(!empty($primaryContact)){ echo $primaryContact->phone_no; }else {echo '';}
      		echo "</td>
      		<td>".$lead['leadOwnerName']."</td>
      		<td>".$lead['createdByName']."</td>
      		<td>".$leadStatus."</td>	
      		<td>".$lead['status_comment']."</td>	
      		<td class='hidde'>".date("j F , Y", strtotime($lead['created_date']))."</td>	
      		<td class='hidde'>".$action."</td>	
         </tr>";
         
         $output[] = array(
      		   'Company' => $lead['company'],
      		   'Name' => $primaryContact->first_name,
      		   //'Buyer Order No.' => $buyer_order_no,
      		   'Email' => $primaryContact->email,
      		   'Phone No' => $primaryContact->phone_no,
      		   'Lead Owner' => $lead['leadOwnerName'],
      		   'Created By' => $lead['createdByName'],
      		   'Lead Status' => $leadStatus,
      		   'Created Date' => date("d-m-Y", strtotime($lead['created_date'])),
      		);	
      }
      $data3  = $output;
      
      export_csv_excel($data3);
      
      }
      
      ?>
</tbody>                   
</table>
</div><!-- Print div -->  
</div>*/?>
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reason</h4>
         </div>
         <div class="modal-body">
            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/disApprove_bid" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
               <input type="hidden" name="id" value="<?php echo $register_fr_opportunity['id'];?>" id="register_id">
               <input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
               <input type="hidden" id="disapprove" name="disapprove" value="1">
               <input type="hidden" id="disapprove" name="approve" value="0">
               <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">														
                     <textarea id="disapprove_reason" required="required" rows="6" name="disapprove_reason" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>													
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
                  <input type="submit" class="btn btn edit-end-btn " value="Submit">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>	  
<div id="crm_form_modal" tabindex="-1" class="modal fade in"  role="dialog" style="overflow:hidden;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Lead</h4>
         </div>
         <div class="modal_body_content"></div>
      </div>
   </div>
</div>
<div id="crm_add_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title nxt_cls" id="myModalLabel">Lead</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<?php	
   /*
   if(isset($_POST["ExportType"]))
   {
   
    ob_end_clean();
       switch($_POST['ExportType'])
       {
   		case "export-to-excel" :
               // Submission from
               $filename = $_POST["ExportType"] . ".xlsx";       
               header("Content-Type: application/vnd.ms-excel");
               header("Content-Disposition: attachment; filename=\"$filename\"");
   			//pre($data3);die();
   		    ExportFile($data3);
               exit();
           case "export-to-csv" :
               // Submission from
               $filename = $_POST["ExportType"] . ".csv";            
               header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
               header("Content-type: text/csv");
               header("Content-Disposition: attachment; filename=\"$filename\"");
               header("Expires: 0");
               ExportCSVFile($data3);
               //$_POST["ExportType"] = '';
               exit();
   		default :         
               die("Unknown action : ".$_POST["action"]);
               break;
       }
   }
    
   function ExportCSVFile($records) {
       // create a file pointer connected to the output stream
       $fh = fopen( 'php://output', 'w' );
       $heading = false;
           if(!empty($records))
   			ob_end_clean();
             foreach($records as $row) {
               if(!$heading) {
                 // output the column headings
                 fputcsv($fh, array_keys($row));
                 $heading = true;
               }
               // loop over the rows, outputting them
                fputcsv($fh, array_values($row));
                 
             }
             fclose($fh);
   }
    
   function ExportFile($records) {
       $heading = false;
       if(!empty($records))
   		//ob_end_clean();
         foreach($records as $row) {
           if(!$heading) {
             // display field/column names as a first row
             echo implode("\t", array_keys($row)) . "\n";
             $heading = true;
           }
           echo implode("\t", array_values($row)) . "\n";
         }
       exit;
   }
   */
   ?>
<script>
   var measurementUnits = '';
   
</script>