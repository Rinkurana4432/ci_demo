<div class="x_content">
<div class="col-md-12 col-xs-12 for-mobile">
   <div class="Filter Filter-btn2"> 
         <form class="form-search" method="get" action="<?= base_url()?>inventory/materials">
   <div class="col-md-6">
      <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab'];?>"/>
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter id,Product Code,Product Name,Product Type" name="search" id="search" data-ctrl="inventory/materials?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search 
         </button>
         <a href="<?php echo base_url(); ?>inventory/materials?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
         </span>
      </div>
   </div>
</form>
<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
  <div id="demo" class="collapse">
     <div class="col-md-3 col-xs-12 col-sm-3 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group cls_display_none">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control " value=""  data-table="inventory/materials">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>inventory/materials" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
               <input type="hidden" value='<?php if(isset($_GET['tab'])) echo $_GET['tab'] ; ?>' name='tab'/>
            </form>
         </div>
	 <!--Filter div Start-->
	 <form action="<?php echo base_url(); ?>inventory/materials" method="get" >
		<input type="hidden" value='<?php if(isset($_GET['tab'])) echo $_GET['tab'] ; ?>' name='tab'/>
		<div class="row hidde_cls  progress_filter">
		   <div class="col-md-12">
			  <div class="btn-group disbled_cls"  role="group" aria-label="Basic example">
				 <select onchange="ChangePrefix_and_subType();" name="material_type" class="materialTypeId form-control">
					<option value=""> Select Category </option>
					<option value="">All Category </option>
					<?php
					   if(!empty($mat_type) ){
						
						foreach($mat_type as $matType){
					   ?>
					<option value="<?php echo $matType['id']; ?>"><?php echo $matType['name']; ?></option>
					<?php } } ?>			
				 </select>
            <select class="subtype form-control" name="sub_type"><option value="">Select Sub Type</option></select>
			  </div>
			  <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="inventory/materials" disabled="disabled">
		   </div>
		</div>
	 </form>
	 <!-- Filter div End-->
  </div>
</div>

<span class="mesg">
<?php 
if($this->session->flashdata('message') != ''){
?>                        
<div class="alert alert-info col-md-12">                            
<?php 
      echo $this->session->flashdata('message'); ?> 
</div>
<?php } ?>
</span>


           
   </div>
</div>
<?php //if($can_add) { echo '<button type="buttton" class="btn btn-info inventory_tabs" id="mtaerial_add" data-toggle="modal" data-id="editMaterial">Add</button>';  } ?>
<form action="<?php echo site_url(); ?>inventory/materials?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>" method="get" id="export-form">
   <input type="hidden" value='' id='hidden-type' name='ExportType'/>
   <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'] ; ?>' class='start_date' name='start'/>
   <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'] ; ?>' class='end_date' name='end'/>
   <input type="hidden" value='<?php if(isset($_GET['material_type']))echo $_GET['material_type'] ; ?>' class='material_type' name='material_type'/>
   <input type="hidden" value='<?php if(isset($_GET['tab'])) echo $_GET['tab'] ; ?>' name='tab'/>
   <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'] ; ?>' name='search'/>
   <input type="hidden" value='<?php if(isset($_GET['favourites']))echo $_GET['favourites'] ; ?>' name='favourites'/>
</form>
<?php //if(!empty($materials)){  dateRangeFilters tabbingFilters?>
<div class="row hidde_cls">
   <div class="col-md-12">
      <div class=" export_div">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
		    
            <?php
		if($can_add){
			echo '<a href="'.base_url().'inventory/material_edit?id" class="btn btn-success addBtn dropdown-toggle"  data-href=""><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>'; 
		}
			?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm cls_display_none" id="bbtn">Print</button>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
		<?php if($can_add){  ?>		  
				  <li id="export-to-blank-excel"><a href="<?php echo base_url()?>/inventory/Create_materialsubType_blankxls" title="Please check your open office Setting">Material Sub Type Blank Excel</a></li>
				  <li id="export-to-blank-excel"><a href="<?php echo base_url()?>/inventory/Create_material_blankxls" title="Please check your open office Setting">Material Blank Excel</a></li>
				  <li id="export-to-mat-location-excel"><a href="<?php echo base_url()?>/inventory/Create_materialLoc_blankxls" title="Please check your open office Setting">Material Location Blank Excel</a></li>
		<?php } ?>			  
               </ul>
            </div>
			 <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <ul class="dropdown-menu import-bar" role="menu" id="export-menu" style="min-width: 250px;">
                  <form action="<?php echo base_url(); ?>inventory/importmaterial" method="post" enctype="multipart/form-data">
                     <input type="file" class="form-control col-md-2" name="uploadFile" id="file" style="width: 70%">
                     <input type="submit" class="form-control col-md-2" name="importe" value="Import" style="width: 30%" />
                  </form>
               </ul>
			   <?php if($can_add){  ?>		
              <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#demo3" aria-expanded="true">Import<span class="caret"></span></button>
						<div id="demo3" class="collapse " aria-expanded="true" style="">
							<table  class="table table-striped table-bordered" data-id="inventory">
								<thead>
									<tr><th>Upload excel file</th></tr>
								</thead>
									<tbody>
										<tr>
											<td>
												<form action="<?php echo base_url();?>inventory/import_subTypeData" method="post" enctype="multipart/form-data">
													<label>Upload Material Subtype.</label>
													<input type="file" name="uploadFile" value="" />
													<input type="submit" name="upload_subtype_data" value="Upload" class="btn btn-primary" />
												</form>
											</td>
										</tr>
										<tr>
											<td>
												<form action="<?php echo base_url();?>inventory/import_view_mat" method="post" enctype="multipart/form-data">
												    <label>Upload Material</label>
													<input type="file" name="uploadFile" value="" /><br><br>
													<input type="submit" name="submit_material_data" value="Upload" class="btn btn-primary" />
												</form>
											</td>
										</tr>
										<tr>
											<td>
												<form action="<?php echo base_url();?>inventory/import_view_mat_location" method="post" enctype="multipart/form-data">
												    <label>Upload Material Loc.</label>
													<input type="file" name="uploadFile" value="" />
													<input type="submit" name="upload_invoices_data" value="Upload" class="btn btn-primary" />
												</form>
											</td>
										</tr>
									</tbody>
							</table>
						</div>
						<?php } ?>		
            </div>
            <form action="<?php echo base_url(); ?>inventory/materials" method="get" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
               <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
               <input type="hidden" value='<?php if(isset($_GET['tab'])) echo $_GET['tab'] ; ?>' name='tab'/>
               <button class="btn btn-default btn-sm pull-left cls_display_none" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            <input type="hidden" value='material' id="table" data-msg="Materials" data-path="inventory/materials"/>
            <!-- <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button> -->
            
         </div>
		 
         
      </div>
   </div>
   <?php //} ?>	
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" >
         <li role="presentation" class="active"><a href="#Material_Active" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="actve_mat_form()">Active Material</a>
         </li>
         <li role="presentation" class=""><a href="#non_inventory" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" onClick="noninvtry_mat_form()">Non-Inventory Material</a>
         </li>
         <li role="presentation" class=""><a href="#material_inactive" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" onClick="inactve_mat_form()">Inactive Material</a>
         </li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <!--------------------------------------------------------Active Material----------------------------------------------------------------------->
         <div role="tabpanel" class="tab-pane fade active in" id="Material_Active" aria-labelledby="home-tab">
            <div id="print_div_content" style="margin: 0px;">
               <p class="text-muted font-13 m-b-30"></p>
               <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>inventory/materials">
                  <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
               </form>
               <form id="active_mat_form"><input type="hidden" value="active_mat" name="tab"></form>
               <?php /*<table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">*/?>
               <!----------- datatable-buttons ---------------->
               <table  class="table table-striped  table-bordered" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th class="hidde">#</th>
                        <!--<th>Id
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=active_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=active_mat&sort=desc" class="down"></a></span></th>-->
                        <th scope="col">Product Code
                           <span><a href="<?php echo base_url(); ?>inventory/materials?sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=active_mat&sort=desc" class="down"></a></span>                                
                        </th>
                        <th scope="col">Product Name
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=active_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=active_mat&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Item Code</th>
                        <th scope="col">Product Type</th>
                        <th scope="col">Product SKU</th>
                        <th scope="col">HSN Code</th>
                        <th scope="col" class="cls_display_none">Specification</th>
                        <th scope="col">Reorder Level</th>
                        <th scope="col">Closing Balance</th>
                        <th scope="col">UOM</th>
                        <th scope="col" class="cls_display_none">Tags</th>
                        <th scope="col" class="cls_display_none">Created By / Edited By</th>
                        <th scope="col">Created Date</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        #error_reporting(0);
                        
                        
                        if(!empty($materials)){
                        
                        	foreach($materials as $mat){
                        		$countStringlen = $mat['specification'];
                        		$created_by = ($mat['created_by']!=0)?(getNameById('user_detail',$mat['created_by'],'u_id')->name):'';
                        		$edited_by = ($mat['edited_by']!=0)?(getNameById('user_detail',$mat['edited_by'],'u_id')->name):'';
                        		$materialType = getNameByID('material_type',$mat['material_type_id'],'id');		
                        			#pre($materialView->id);
                        		$yu = getNameById_mat('mat_locations',$mat['id'],'material_name_id');
								$sum = 0;
                        		 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                        		 else{ echo "";}
                        	
                        		$disable = ($_SESSION['loggedInUser']->role == 1) ?'':($mat['status'] !=1 && $_SESSION['loggedInUser']->id == $mat['id']?'':'disabled');
                        		$disableClass = ($_SESSION['loggedInUser']->role == 1) ?'':($mat['status'] !=1 && $_SESSION['loggedInUser']->id == $mat['id']?'':'disableBtnClick');
                        		$statusChecked = $mat['status']==1?'checked':'';
                        		$draftImage = '';	
                        		if($mat['save_status'] == 0){
                        			$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                        		}	
								$hsn_code =  getNameById('hsn_sac_master', $mat['hsn_code'],'id');

										
                        ?>
                     <tr>
                        <td class="hidde"><?php #if($mat["used_status"]==0){ echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$mat['id'].">";}
                           if($mat['favourite_sts'] == '1'){
                              				// echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$mat['id']."  checked = 'checked'>";
                              				echo"<input type='hidden' value='material' id='favr' data-msg='Materials' data-path='inventory/materials?tab=active_mat' favour-sts='0' id-recd=".$mat['id'].">";
                              		}else{
                           				// echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$mat['id'].">";
                           				echo"<input type='hidden' value='material' id='favr' data-msg='Materials' data-path='inventory/materials?tab=active_mat' favour-sts='1' id-recd =".$mat['id'].">";
                              		}
                           ?>
                        </td>
                        <!--		<td><?php //echo $draftImage.$mat['id']; ?></td>-->
                        <td data-label='Product Code:'><?php echo $mat['material_code']; ?> <?php echo $draftImage ?></td>
                        <td data-label='Product Name:'><?php echo $mat['material_name'];  //echo getClosingBalance($mat['id'] ); ?></td>
                        <td><?php echo $mat['item_code']; ?></td>
                        <td data-label='Product Type:'><?php if(!empty($materialType)){echo $materialType->name ;} else {echo "";} ?></td>
                        <td data-label='Product SKU:'><?php echo $mat['mat_sku']; ?></td>
                        <td data-label='HSN Code:'><?php echo $hsn_code->hsn_sac; ?></td>
                        <td data-label='Specification:' class="cls_display_none"><?php 
                           $str = $countStringlen;
                           	if( strlen( $countStringlen) > 50) {
                           		$str = explode( "\n", wordwrap( $countStringlen, 50 ));
                           		$str = $str[0] . "<br><a href ='' id='". $mat['id'] . "' data-id='material_view' class='inventory_tabs ' data-tooltip='View' style='color:green;' >View More</a>";
                           	}
                           	echo $str;
                           //echo $mat['specification']; ?></td>
                        <td data-label='Reorder Level:'><?php
                           if($mat['non_inventry_material'] == '1'){
                           	echo $mini_inventery = 'Non Inventory Material';
                           }else{ 
                           	echo $mini_inventery = $mat['min_inventory']; 
                           } ?>
                        </td>
                        <td data-label='Closing Balance:'><?php  echo $sum; ?></td>
                        <?php /* <td><?php echo $mat['inventory_unit']; ?></td>	*/ 
                        $ww =  getNameById('uom', $mat['uom'],'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';?>
						
                        <td data-label='uom:'><?php echo $uom; ?></td>
                        <td data-label='Tags:' class="cls_display_none"><?php echo get_tags_html($mat['id'],'material'); ?></td>
                        <?php
                           ?>
                        <td data-label='Created By / Edited By:' class="cls_display_none"><?php echo "<a href='".base_url()."users/edit/".$mat['created_by']."' target='_blank'>".$created_by .'</a><a href="'.base_url().'users/edit/'.$mat["edited_by"].'" target="_blank"><br>'. $edited_by."</a>"; ?></td>
                        <td data-label='Created Date:'><?php echo date("j F , Y", strtotime($mat['created_date'])); ?></td>
                        <td  data-label='Action:' class='hidde action'> 
						 <i class="fa fa-cog" aria-hidden="true"></i>
						  <div class="on-hover-action">
                           <?php
                              if($mat['save_status'] ==1){
                              	echo '
                              	<input type="checkbox" class="js-switch change_status"  data-switchery="true" style="display: none;" value="'.$mat['status'].'" 
                              	data-value="'.$mat['id'].'" '.$statusChecked .'>';
                              }	
                              if($can_edit){
                              	echo ' <a href="'.base_url().'inventory/material_edit?id='.$mat['id'].'" class="
                                                  btn btn-delete btn-xs"  data-href="" >Edit</a>';
                              }
                              if ($can_view) {
                              	echo ' <a href="javascript:void(0)" id="'.$mat['id'].'" data-id="material_view" class="inventory_tabs btn btn-view btn-xs" id="'.$mat["id"].'">View</a>';
                              }
                              
                              /**	if($can_delete && $mat["used_status"]==0){ 
                              	echo '<a href="javascript:void(0)" class="delete_listing
                              	btn btn-delete btn-xs" data-href="'.base_url().'inventory/delete_material/'.$mat["id"].'"><i class="fa fa-trash"></i></a>';
                              }else{
                              	echo '<a href="javascript:void(0)" class="btn btn-danger btn-xs" data-href="'.base_url().'inventory/delete_material/'.$mat["id"].'" disabled = "disabled"><i class="fa fa-trash"></i></a>';
                              }
                              **/
                              ?>
							  </div>
                        </td>
                     </tr>
                     <?php 
                        if(!empty($materialType)){
                        	$mat_type = $materialType->name ;
                        } else {
                        	$mat_type = "";
                        } 
                        	if($mat['non_inventry_material'] == '1'){
                        		$mini_inventery = 'Non Inventory Material';
                        		}else{ 
                        		$mini_inventery = $mat['min_inventory']; 
                        		} 
                        	$output[] = array(
                        	  /** 'Id' => $mat['id'],**/
                        	   'Material Code' => $mat['material_code'],
                        	   'Material Name' => $mat['material_name'],
                        	   'Material Type' => $mat_type,
                        	   'Hsn Code' => $mat['hsn_code'],
                        	   'Specification' => $mat['specification'],
                        	   'Minimum Inventory' => $mini_inventery,
                        	   //'Minimum Unit' => $mat['inventory_unit'],
                        	   'Minimum Unit' => $uom,
                        	   'Created Date' => date("d-m-Y", strtotime($mat['created_date'])),
                        	);	
                        }
                        	
                        	$data3  = $output;
                        	export_csv_excel($data3);	
                        } 
                        
                        ?>
                  </tbody>
               </table>
               <?php //echo $this->pagination->create_links(); ?>
            </div>
         </div>
         <!-------------------------------------------------------inactive material-------------------------------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="material_inactive" aria-labelledby="profile-tab">
            <div id="print_div_content" style="margin: 0px;">
               <form id="inactive_mat_form"><input type="hidden" value="inactive_mat" name="tab"></form>
               <p class="text-muted font-13 m-b-30"></p>
               <!------------ example08424---------------->   
               <table  class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                  <thead>
                     <tr>
                        <th class="hidde">#</th>
                        <!--<th>Id
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=inactive_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=inactive_mat&sort=desc" class="down"></a></span></th>-->
                        <th scope="col">Product Code
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=inactive_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=inactive_mat&sort=desc" class="down"></a></span> 
                        </th>
                        <th scope="col">Product Name
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=inactive_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=inactive_mat&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Item Code</th>
                        <th scope="col">Product Type</th>
                        <th scope="col">Hsn Code</th>
                        <th scope="col" class="cls_display_none">Specification</th>
                        <th scope="col">Minimum Inventory</th>
                        <th scope="col">Closing Balance</th>
                        <th scope="col">UOM</th>
                        <th scope="col" class="cls_display_none">Tags</th>
                        <th scope="col" class="cls_display_none">Created_by / Edited By</th>
                        <th scope="col">Created_date</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($inactive_material)){

                        foreach($inactive_material as $inActiveMaterial){
                          # pre($inActiveMaterial);
                        	$yu = getNameById_mat('mat_locations',$inActiveMaterial['id'],'material_name_id');
                        	$sum = 0;
                        	 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                        	 else{ echo "";}
                        
                        	$countStringlen = $inActiveMaterial['specification'];
                        	$created_by = ($inActiveMaterial['created_by']!=0)?(getNameById('user_detail',$inActiveMaterial['created_by'],'u_id')->name):'';
                        	$edited_by = ($inActiveMaterial['edited_by']!=0)?(getNameById('user_detail',$inActiveMaterial['edited_by'],'u_id')->name):'';
                        	$materialType = getNameByID('material_type',$inActiveMaterial['material_type_id'],'id');							
                        	$disable = ($_SESSION['loggedInUser']->role == 1) ?'':($inActiveMaterial['status'] !=1 && $_SESSION['loggedInUser']->id == $inActiveMaterial['id']?'':'disabled');
                        	$disableClass = ($_SESSION['loggedInUser']->role == 1) ?'':($inActiveMaterial['status'] !=1 && $_SESSION['loggedInUser']->id == $inActiveMaterial['id']?'':'disableBtnClick');
                        	$statusChecked = $inActiveMaterial['status']==1?'checked':'';
                        	$draftImage = '';	
                        	if($inActiveMaterial['save_status'] == 0){
                        		$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                        	}				
                        ?>
                     <tr>
                        <td class="hidde"><?php if($inActiveMaterial["status"]==0){ echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$inActiveMaterial['id'].">";}
                           if($inActiveMaterial['favourite_sts'] == '1'){
                              				// echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$inActiveMaterial['id']."  checked = 'checked'>";
                              				echo"<input type='hidden' value='material' id='favr' data-msg='Materials' data-path='inventory/materials?tab=inactive_mat' favour-sts='0' id-recd=".$inActiveMaterial['id'].">";
                              		}else{
                           				// echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$inActiveMaterial['id'].">";
                           				echo"<input type='hidden' value='material' id='favr' data-msg='Materials' data-path='inventory/materials?tab=inactive_mat' favour-sts='1' id-recd =".$inActiveMaterial['id'].">";
                              		}
                           ?>
                        </td>
                        <!--<td><?php //echo $draftImage.$inActiveMaterial['id']; ?></td>-->
                        <td data-label='Product Code:'><?php echo $inActiveMaterial['material_code']; ?> <?php echo $draftImage ?></td>
                        <td data-label='Product Name:'><?php echo $inActiveMaterial['material_name']; ?></td>
                        <td><?php echo $inActiveMaterial['item_code']; ?></td>
                        <td data-label='Product Type:'><?php if(!empty($materialType)){echo $materialType->name ;} else {echo "";} ?></td>
                        <td data-label='HSN Code:'><?php echo $inActiveMaterial['hsn_code']; ?></td>
                        <td data-label='Specification:' class="cls_display_none"><?php 
                           $str = $countStringlen;
                           	if( strlen( $countStringlen) > 50) {
                           		$str = explode( "\n", wordwrap( $countStringlen, 50 ));
                           		$str = $str[0] . "<br><a href ='' id='". $inActiveMaterial['id'] . "' data-id='material_view' class='inventory_tabs ' data-tooltip='View' style='color:green;' >View More</a>";
                           	}
                           echo $str; ?>
                        </td>
                        <td data-label='Reorder Level:'><?php
                           if($inActiveMaterial['non_inventry_material'] == '1'){
                           	echo $mini_inventery = 'Non Inventory Material';
                           }else{ 
                           	echo $mini_inventery = $inActiveMaterial['min_inventory']; 
                           } ?>
                        </td>
                        <?php    
                           $ww =  getNameById('uom', $inActiveMaterial['uom'],'id');
                           	$uom = !empty($ww)?$ww->ugc_code:'';
                           
                            ?>
                        <td data-label='Closing Balance:'><?php  echo $sum;?></td>
                        <td data-label='uom:'><?php echo $uom; ?></td>
                        <td data-label='Tags:' class="cls_display_none"><?php echo get_tags_html($inActiveMaterial['id'],'material'); ?></td>
                        <td data-label='Created By / Edited By:' class="cls_display_none"><?php echo "<a href='".base_url()."users/edit/".$inActiveMaterial['created_by']."' target='_blank'>".$created_by .'</a><a href="'.base_url().'users/edit/'.$inActiveMaterial["edited_by"].'" target="_blank"><br>'. $edited_by."</a>"; ?></td>
                        <td data-label='Created Date:'><?php echo date("j F , Y", strtotime($inActiveMaterial['created_date'])); ?></td>
                         <td  data-label='Action:' class='hidde action'> 
						 <i class="fa fa-cog" aria-hidden="true"></i>
						  <div class="on-hover-action"> 
                           <?php
                              if($inActiveMaterial['save_status'] ==1){
                              	echo '
                              	<input type="checkbox" class="js-switch change_status"  data-switchery="true" style="display: none;" value="'.$inActiveMaterial['status'].'" 
                              	data-value="'.$inActiveMaterial['id'].'" '.$statusChecked .'>';
                              }	
                              
                              if($can_edit){
                              	echo '<a href="'.base_url().'inventory/material_edit?id='.$inActiveMaterial['id'].'" class="
                                                  btn btn-delete btn-xs"  data-href="" >Edit</a>';
                              }
                              if ($can_view) {
                              echo '<a href="javascript:void(0)" id="'.$inActiveMaterial['id'].'" data-id="material_view" class="inventory_tabs btn btn-warning btn-xs" id="'.$inActiveMaterial["id"].'">View</a>';
                              }
                              
                              /**if($can_delete && $inActiveMaterial["used_status"]==0){ 
                              echo '<a href="javascript:void(0)" class="delete_listing
                              btn btn-danger" data-href="'.base_url().'inventory/delete_material/'.$inActiveMaterial["id"].'"><i class="fa fa-trash"></i></a>';
                              }else{
                              	echo '<a href="javascript:void(0)" class="btn btn-danger" data-href="'.base_url().'inventory/delete_material/'.$inActiveMaterial["id"].'" disabled = "disabled"><i class="fa fa-trash"></i></a>';
                              }**/
                              ?>
							  </div>
                        </td>
                     </tr>
                     <?php 
                        if(!empty($materialType)){
                        	$mat_type = $materialType->name ;
                        } else {
                        	$mat_type = "";
                        } 
                        	if($inActiveMaterial['non_inventry_material'] == '1'){
                        		$mini_inventery = 'Non Inventory Material';
                        		}else{ 
                        		$mini_inventery = $inActiveMaterial['min_inventory']; 
                        		} 
                        	$output[] = array(
                        	   //'Id' => $inActiveMaterial['id'],
                        	   'Material Code' => $inActiveMaterial['material_code'],
                        	   'Material Name' => $inActiveMaterial['material_name'],
                        	   'Material Type' => $mat_type,
                        	   'Hsn Code' => $inActiveMaterial['hsn_code'],
                        	   'Specification' => $inActiveMaterial['specification'],
                        	   'Minimum Inventory' => $mini_inventery,
                        	  // 'Minimum Unit' => $inActiveMaterial['inventory_unit'],
                        	   'Minimum Unit' => $uom,
                        	   'Created Date' => date("d-m-Y", strtotime($inActiveMaterial['created_date'])),
                        	);	
                        }
                        	$data3  = $output;
                        	export_csv_excel($data3);
                        } 
                        
                        ?>
                  </tbody>
               </table>
               <?php //echo $this->pagination->create_links(); ?>	
            </div>
         </div>
         <!--------------------------------------------------------------Non inventory Material----------------------------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="non_inventory" aria-labelledby="profile-tab">
            <div id="print_div_content" style="margin: 0px;">
               <form id="noninery_mat_form"><input type="hidden" value="noninvntry_mat" name="tab"></form>
               <p class="text-muted font-13 m-b-30"></p>
               <!------------ example084  --------------->
               <table class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
                  <thead>
                     <tr>
                        <th class="hidde">#</th>
                        <!--	<th>Id
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=noninvntry_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=noninvntry_mat&sort=desc" class="down"></a></span></th>-->
                        <th scope="col">Product Code
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=noninvntry_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=noninvntry_mat&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Product Name
                           <span><a href="<?php echo base_url(); ?>inventory/materials?tab=noninvntry_mat&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>inventory/materials?tab=noninvntry_mat&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Item Code</th>
                        <th scope="col">Product Type</th>
                        <th scope="col">Hsn Code</th>
                        <th scope="col" class="cls_display_none">Specification</th>
                        <th scope="col">Minimum Inventory</th>
                        <th scope="col">Closing Balance</th>
                        <th scope="col">UOM</th>
                        <th scope="col" class="cls_display_none">Tags</th>
                        <th scope="col" class="cls_display_none">Created_by / Edited By</th>
                        <th scope="col">Created_date</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($non_inventry_mat)){
                        foreach($non_inventry_mat as $nonInventryMat){
                        	$yu = getNameById_mat('mat_locations',$nonInventryMat['id'],'material_name_id');
                        	$sum = 0;
                        	 if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                        	 else{ echo "";}
                        
                        	$countStringlen = $nonInventryMat['specification'];
                        	$created_by = ($nonInventryMat['created_by']!=0)?(getNameById('user_detail',$nonInventryMat['created_by'],'u_id')->name):'';
							     
                           $user=!empty(getNameById('user_detail',$nonInventryMat['edited_by'],'u_id'));

                        	$edited_by = ($nonInventryMat['edited_by']!=0)?(getNameById('user_detail',$nonInventryMat['edited_by'],'u_id')->name):'';

                           #pre($edited_by);
                        	

                           $materialType = getNameByID('material_type',$nonInventryMat['material_type_id'],'id');							
                        	$disable = ($_SESSION['loggedInUser']->role == 1) ?'':($nonInventryMat['status'] !=1 && $_SESSION['loggedInUser']->id == $nonInventryMat['id']?'':'disabled');
                        	$disableClass = ($_SESSION['loggedInUser']->role == 1) ?'':($nonInventryMat['status'] !=1 && $_SESSION['loggedInUser']->id == $nonInventryMat['id']?'':'disableBtnClick');
                        	$statusChecked = $nonInventryMat['status']==1?'checked':'';
                        	$draftImage = '';	
                        	if($nonInventryMat['save_status'] == 0){
                        		$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                        	}				
                        ?>
                     <tr>
                        <td class="hidde"><?php if($nonInventryMat["used_status"]==0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$nonInventryMat['id'].">";}
                           if($nonInventryMat['favourite_sts'] == '1'){
                              				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$nonInventryMat['id']."  checked = 'checked'>";
                              				echo"<input type='hidden' value='material' id='favr' data-msg='Materials' data-path='inventory/materials?tab=noninvntry_mat' favour-sts='0' id-recd=".$nonInventryMat['id'].">";
                              		}else{
                           				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$nonInventryMat['id'].">";
                           				echo"<input type='hidden' value='material' id='favr' data-msg='Materials' data-path='inventory/materials?tab=noninvntry_mat' favour-sts='1' id-recd =".$nonInventryMat['id'].">";
                              		}
                           ?>
                        </td>
                        <!--	<td><?php //echo $draftImage.$nonInventryMat['id']; ?></td>-->
                        <td data-label='Product Code:'><?php echo $nonInventryMat['material_code']; ?><?php echo $draftImage; ?> </td>
                        <td data-label='Product Name:'><?php echo $nonInventryMat['material_name']; ?></td>
                        <td><?php echo $nonInventryMat['item_code']; ?></td>
                        <td data-label='Product Type:'><?php if(!empty($materialType)){echo $materialType->name ;} else {echo "";} ?></td>
                        <td data-label='HSN Code:'><?php echo $nonInventryMat['hsn_code']; ?></td>
                        <td data-label='Specification:' class="cls_display_none"><?php 
                           $str = $countStringlen;
                           	if( strlen( $countStringlen) > 50) {
                           		$str = explode( "\n", wordwrap( $countStringlen, 50 ));
                           		$str = $str[0] . "<br><a href ='' id='". $nonInventryMat['id'] . "' data-id='material_view' class='inventory_tabs ' data-tooltip='View' style='color:green;' >View More</a>";
                           	}
                           echo $str; ?></td>
                        <td data-label='Reorder Level:'><?php
                           if($nonInventryMat['non_inventry_material'] == '1'){
                           	echo $mini_inventery = 'Non Inventory Material';
                           }else{ 
                           	echo $mini_inventery = $nonInventryMat['min_inventory']; 
                           } ?>
                        </td>
                        <td data-label='Closing Balance:'><?php echo $sum; ?></td>
                        <?php /*<td><?php echo $nonInventryMat['inventory_unit']; ?></td>	 */
                        $ww =  getNameById('uom', $nonInventryMat['uom'],'id');
                        $uom = !empty($ww)?$ww->ugc_code:'';
                        ?>
                        <td data-label='uom:'><?php echo $uom; ?></td>
                        <td data-label='tags:' class="cls_display_none"><?php echo get_tags_html($nonInventryMat['id'],'material'); ?></td>
                        
                        <td data-label='Created By / Edited By:' class="cls_display_none"><?php echo "<a href='".base_url()."users/edit/".$nonInventryMat['created_by']."' target='_blank'>".$created_by .'</a><a href="'.base_url().'users/edit/'.$nonInventryMat["edited_by"].'" target="_blank"><br>'. $edited_by."</a>"; ?></td>
                        
                        <td data-label='Created_date:'><?php echo date("j F , Y", strtotime($nonInventryMat['created_date'])); ?></td>
                        <td  data-label='Action:' class='hidde action'> 
						 <i class="fa fa-cog" aria-hidden="true"></i>
						  <div class="on-hover-action"> 
                           <?php
                              if($nonInventryMat['save_status'] ==1){
                              	echo '
                              	<input type="checkbox" class="js-switch change_status"  data-switchery="true" style="display: none;" value="'.$nonInventryMat['status'].'" 
                              	data-value="'.$nonInventryMat['id'].'" '.$statusChecked .'>';
                              }
                              if($can_edit){
                              	echo '<a href="'.base_url().'inventory/material_edit?id='.$nonInventryMat['id'].'" class="
                                                  btn btn-delete btn-xs" data-tooltip="Edit Product" data-href="" >Edit</a>';
                              }
                              
                              if ($can_view) {
                              	echo '<a href="javascript:void(0)" id="'.$nonInventryMat['id'].'" data-id="material_view" class="inventory_tabs btn btn-warning btn-xs" id="'.$nonInventryMat["id"].'">View</a>';
                              }
                              
                              /**	if($can_delete && $nonInventryMat["used_status"]==0){ 
                              echo '<a href="javascript:void(0)" class="delete_listing
                              btn btn-danger" data-href="'.base_url().'inventory/delete_material/'.$nonInventryMat["id"].'"><i class="fa fa-trash"></i></a>';
                              }else{
                              	echo '<a href="javascript:void(0)" class="btn btn-danger" data-href="'.base_url().'inventory/delete_material/'.$nonInventryMat["id"].'" disabled = "disabled"><i class="fa fa-trash"></i></a>';
                              }**/
                              
                              ?>
							  </div>
                        </td>
                     </tr>
                     <?php 
                        if(!empty($materialType)){
                        	$mat_type = $materialType->name ;
                        } else {
                        	$mat_type = "";
                        } 
                        	if($nonInventryMat['non_inventry_material'] == '1'){
                        		$mini_inventery = 'Non Inventory Material';
                        		}else{ 
                        		$mini_inventery = $nonInventryMat['min_inventory']; 
                        		} 
                        	$output[] = array(
                        	 //  'Id' => $nonInventryMat['id'],
                        	   'Material Code' => $nonInventryMat['material_code'],
                        	   'Material Name' => $nonInventryMat['material_name'],
                        	   'Material Type' => $mat_type,
                        	   'Hsn Code' => $nonInventryMat['hsn_code'],
                        	   'Specification' => $nonInventryMat['specification'],
                        	   'Minimum Inventory' => $mini_inventery,
                        	  // 'Minimum Unit' => $nonInventryMat['inventory_unit'],
                        	   'Minimum Unit' => $uom,
                        	   'Created Date' => date("d-m-Y", strtotime($nonInventryMat['created_date'])),
                        	);	
                        }
                        	$data3  = $output;
                        	export_csv_excel($data3);
                        } 
                        
                        ?>
                  </tbody>
               </table>
               <?php // echo $this->pagination->create_links(); ?>	
            </div>
         </div>
      </div>
   </div>
</div>
<?php echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
<div id="inventory_add_modal" class="modal fade in"  class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Material</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>