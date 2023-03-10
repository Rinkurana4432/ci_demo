<style>
   .tab-content ul.nav.nav-pills.bar_tabs a {
   color: #000;
   }
   .action:hover .on-hover-action {
   right: 99%;
   }
</style>
<?php
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   ?>
<?php if($this->session->flashdata('message') != ''){
   ?>
<div class="alert alert-info col-md-12">
   <?php 
      echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <!--li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Add Storage</a> </li-->
         <li role="presentation"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Product Types</a> </li>
         <li role="presentation" class="cls_display_none" style="display: none;"><a href="#tab_content3" role="tab" id="profile-tab1" data-toggle="tab" aria-expanded="false">Inventory Reports</a> </li>
         <li role="presentation" class="cls_display_none" style="display: none;"><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Lot Management</a> </li>
         <li role="presentation" class="cls_display_none" style="display: none;"><a href="#tab_content5" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Location Setting</a> </li>
         <li role="presentation"><a href="#tab_content6" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">UOM list</a> </li>
         <li role="presentation" class="cls_display_none" style="display: none;"><a href="#tab_content7" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Tag Management</a> </li>
         <li role="presentation"><a href="#VariantType" role="tab" id="profile-tab6" data-toggle="tab" aria-expanded="false">Variant Type</a> </li>
         <li role="presentation"><a href="#Permission" role="tab" id="Permission7" data-toggle="tab" aria-expanded="false">General Settings</a> </li>
         <!-- <li role="presentation" class=""><a href="#tab_content7" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Tag Management</a> </li> -->
      </ul>
      <div class="tab-content">
	 
	   
         <div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">
            <p class="text-muted font-13 m-b-30"></p>
            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveLocationSetting" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
               <table class="table table-striped maintable" id="mytable">
                  <thead>
                     <tr>
                        <th>Id</th>
                        <th>Location</th>
                        <!--th>Storage</th-->
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        if(!empty($location_setting)){
                            
                            foreach($location_setting as $locationSetting){
                        
                                $AreaData = json_decode($locationSetting['area']);
                                $AreaArray='';
                                if(!empty($AreaData)){
                                    foreach($AreaData as $area_data){
                                        $areaDetail = $area_data->area;
                                        $AreaArray .= $areaDetail.',';  
                                    }
                                }    
                        ?>
                     <tr>
                        <td>
                           <?php echo $locationSetting['id'];?>
                        </td>
                        <td>
                           <?php echo $locationSetting['location'];?>
                        </td>
                        <!--td>
                           <?php //if(!empty($AreaArray)){echo $AreaArray;} else {echo "NULL";}?>
                        </td-->
                        <td>
                           <?php 
                              if($can_edit) { 
                                  echo '<button class="btn btn-info btn-xs inventory_tabs" data-tooltip="Edit" id="'.$locationSetting["id"].'" data-toggle="modal" data-id="editLocation"><i class="fa fa-pencil"></i></button>'; 
                              }
                              /*if($can_view) { 
                                  echo '<a href="javascript:void(0)" id="'.$locationSetting["id"] . '" data-id="location_view" class="inventory_tabs btn btn-warning btn-xs" id="'. $locationSetting["id"].'"><i class="fa fa-eye"></i> View </a>'; 
                              }*/
                              if($can_delete) { 
                                  echo '<a href="javascript:void(0)" class="delete_listing btn btn-xs btn-danger" data-tooltip="delete" data-href="'.base_url().'inventory/delete_location/'.$locationSetting["id"].'"><i class="fa fa-trash"></i></a>';
                                  }
                              ?>
                        </td>
                     </tr>
                     <?php }}?>
                  </tbody>
               </table>
            </form>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
            <button type="buttton" class="btn btn-info inventory_tabs addBtn" id="mtaerial_add" data-toggle="modal" data-id="editMaterialType">Add</button>
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">
            <div id="hierarchy">
               <div class="indtd">
                  <div class="container">
                     <div class="col">
                        <div class="easy-treee">
                           <?php if(!empty($material_type)){
                              foreach($material_type as $matType){
                                   $sub_type = $matType['sub_type'];
                                  $subType = json_decode($sub_type);  
                              
                              ?>
                           <ul style="position: relative">
                              <div class="btn-bar"><a href="javascript:void(0)" id="<?php  echo $matType['id'] ?>" data-id="editMaterialType" data-tooltip="Edit" class="inventory_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>
                                 <a href="<?php base_url();?>delete_mat_info/<?php echo $matType['id'];?>" class="btn btn-delete btn-xs" onClick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                              </div>
                              <li class="mainParentName liButtonDisable" data-attribute="parent" id="<?php echo $matType['id'];?>" data-id="<?php echo $matType['created_by_cid'] ;?>" data-status="<?php echo $matType['used_status'] ;?>" style="border-bottom:1px solid #ddd;">
                                 <?php echo $matType['name'];?>
                                 <?php if(!empty($subType)){
                                    foreach($subType as $subTypeName){      
                                    ?>
                                 <ul>
                                    <li class="Subtype liButtonDisable" data-attribute="subtype" data-id="">
                                       <?php echo $subTypeName->sub_type;?>   
                                    </li>
                                 </ul>
                                 <?php } }?>
                              </li>
                           </ul>
                           <?php } }?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab1">
            <div class="col-md-12 col-sm-12  ">
               <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveinventoryreportsetting" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
                  <div class="x_panel">
                     <div class="x_title">
                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <input type="hidden" name="id" value="">
                        <div class="col-md-12 ">
                           <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Report Name<span class="required">*</span></label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input required="required" type="text" name="report_name" class="form-control Selectedmonth" value="<?php  if(!empty($mrpdt)){ echo $mrpdt->month; } ?>" /> 
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12">Material Type</label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" id="material_type" onchange="ChangePrefix_and_subType();">
                                       <option value="">Select Option</option>
                                       <?php if(!empty($materials)){
                                          $material_type_id = getNameById('material_type',$materials->material_type_id,'id');
                                          echo '<option value="'.$materials->material_type_id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
                                          }?>
                                    </select>
                                 </div>
                              </div>
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12">Email To</label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <select multiple class="itemName form-control selectAjaxOption select2 select2-hidden-accessible"   name="users[]"  data-id="user_detail" data-key="u_id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="c_id = <?php echo $this->companyGroupId; ?>">
                                    </select>	
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12">Frequency</label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <select class="form-control" required="required" name="frequency" id="frequency" onchange="ChangePrefix_and_subType();">
                                       <option value="">Select Option</option>
                                       <option value="1">Daily</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="item form-group">
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <button type="Submit" class="btn btn-round btn-success btn-lg" name="SearchButton" id="SearchButton"> Submit</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
               <table class="table table-striped maintable" id="ivreport">
                  <thead>
                     <tr>
                        <th>Id</th>
                        <th>Report Name</th>
                        <th>Material Type</th>
                        <th>Frequency</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        if(!empty($daily_report_setting)){
                            foreach($daily_report_setting as $dailyreportsetting){      
                                $rty = getNameById('material_type',$dailyreportsetting['material_type_id'],'id');
                                $matname = !empty($rty)?$rty->name:'';
                                    if($dailyreportsetting['frequency'] == '1'){
                                         $rt = "Daily";
                                    }
                                // $AreaData = json_decode($locationSetting['area']);
                                // $AreaArray='';
                                // if(!empty($AreaData)){
                                //  foreach($AreaData as $area_data){
                                //      $areaDetail = $area_data->area;
                                //      $AreaArray .= $areaDetail.',';  
                                //  }
                                // }     
                        ?>
                     <tr>
                        <td>
                           <?php echo $dailyreportsetting['id'];?>
                        </td>
                        <td>
                           <?php echo $dailyreportsetting['report_name'];?>
                        </td>
                        <td>
                           <?php echo $matname;?>
                        </td>
                        <td>
                           <?php echo $rt;?>
                        </td>
                        <td>
                           <?php 
                              if($can_edit) { 
                                  echo '<button class="btn btn-info btn-xs inventory_tabs" data-tooltip="Edit" id="'.$dailyreportsetting["id"].'" data-toggle="modal" data-id="inventory_reportsettings"><i class="fa fa-pencil"></i> </button>'; 
                              }
                              // if($can_view) { 
                                  // echo '<a href="javascript:void(0)" id="'.$dailyreportsetting["id"] . '" data-id="location_view" class="inventory_tabs btn btn-warning btn-xs" id="'. $dailyreportsetting["id"].'"><i class="fa fa-eye"></i> View </a>'; 
                              // }
                              if($can_delete) { 
                                  echo '<a href="javascript:void(0)" data-tooltip="delete" class="delete_listing btn-xs btn btn-danger" data-href="'.base_url().'inventory/delete_reports/'.$dailyreportsetting["id"].'"><i class="fa fa-trash"></i></a>';
                                  }
                              ?>
                        </td>
                     </tr>
                     <?php }}?>
                  </tbody>
               </table>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab2">
            <div class="col-md-12 col-sm-12  ">
               <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveinventorylots" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">
                  <div class="x_panel">
                     <div class="x_title">
                        <div class="clearfix"></div>
                     </div>
                     <input type="hidden" name="id" value="<?php if(!empty($report_data)) echo $report_data->id; ?>">
                     <input type="hidden" id="loggedUser" value="<?php echo $this->companyGroupId; ?>">
                     <div class="x_content">
                        <div class="col-md-12">
                           <div class="col-md-4 col-sm-12 col-xs-12 vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Lot No.<span class="required">*</span></label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input required="required" type="text" name="lot_number" class="form-control Selectedmonth" value="" /> 
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-12 col-xs-12 vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">MOU Price<span class="required">*</span></label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input required="required" type="text" name="mou_price" class="form-control Selectedmonth" value="" /> 
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-12 col-xs-12 vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">MRP Price<span class="required">*</span></label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input required="required" type="text" name="mrp_price" class="form-control Selectedmonth" value="" /> 
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-12 col-xs-12 vertical-border">
                              <div class="item form-group">
                                 <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Date<span class="required">*</span></label>
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input type="date" name="date" id="acknowledge" class="form-control col-md-7 col-xs-12 req_date"> 
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-6 col-xs-12 vertical-border">
                              <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Material Type<span class="required">*</span></label>
                              <div class="col-md-8 col-sm-12 col-xs-12">
                                 <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" required="required" name="mat_type_id" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-6 col-xs-12 vertical-border">
                              <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Material Name<span class="required">*</span></label>
                              <div class="col-md-8 col-sm-12 col-xs-12">
                                 <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name" id="mat_name" name="mat_id" onchange="getUom(event,this);">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="item form-group">
                                 <div class="col-md-8 col-sm-12 col-xs-12">
                                    <button type="Submit" class="btn btn-round btn-success btn-lg" name="SearchButton" id="SearchButton"> Submit</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
               <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                     <li role="presentation" class="active"><a href="#active_content" id="active-lot-tab" role="tab" data-toggle="tab" aria-expanded="true">Active</a> </li>
                     <li role="presentation"><a href="#archieved_lot_content" role="tab" id="archieved-lot-tab" data-toggle="tab" aria-expanded="false">Archived</a> </li>
                  </ul>
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active " id="active_content" aria-labelledby="active-lot-tab">
                        <table id ="inventorysettingtble" class="table table-striped maintable" id="mytable">
                           <thead>
                              <tr>
                                 <th>Id</th>
                                 <th>Lot Number</th>
                                 <th>Material Type</th>
                                 <th>Material Name</th>
                                 <th>MOU Price</th>
                                 <th>MRP Price</th>
                                 <th>Avail. Quantity</th>
                                 <th>Date</th>
                                 <th>Created by</th>
                                 <th>Created Date</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                                 if(!empty($lot_details)){
                                     foreach($lot_details as $lotdetails){       
                                         $rty = getNameById('user_detail',$lotdetails['created_by'],'u_id');
                                         $usernme = !empty($rty)?$rty->name:'';
                                         $matype = getNameById('material_type',$lotdetails['mat_type_id'],'id');
                                         $mat_type = !empty($matype)?$matype->name:'';
                                         $manme = getNameById('material',$lotdetails['mat_id'],'id');
                                         $mat_nme = !empty($manme)?$manme->material_name:'';
                                         $statusChecked = $lotdetails['active_inactive']==1?'checked':'';                
                                 ?>
                              <tr>
                                 <td>
                                    <?php echo $lotdetails['id'];?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['lot_number'];?>
                                 </td>
                                 <td>
                                    <?php echo $mat_type; ?>
                                 </td>
                                 <td>
                                    <?php  echo $mat_nme; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['mou_price']; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['mrp_price']; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['quantity']; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['date']; ?>
                                 </td>
                                 <td>
                                    <?php echo $usernme;?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['created_date'];?>
                                 </td>
                                 <td>
                                    <?php 
                                       if($can_edit) { 
                                           echo '<button class="btn btn-info btn-xs inventory_tabs" data-tooltip="Edit" id="'.$lotdetails["id"].'" data-toggle="modal" data-id="editlotmanagement"><i class="fa fa-pencil"></i> </button>'; 
                                       }
                                       // if($can_view) { 
                                           // echo '<a href="javascript:void(0)" id="'.$dailyreportsetting["id"] . '" data-id="location_view" class="inventory_tabs btn btn-warning btn-xs" id="'. $dailyreportsetting["id"].'"><i class="fa fa-eye"></i> View </a>'; 
                                       // }
                                       
                                       echo '<input type="checkbox" class="js-switch change_status_lot"  data-switchery="true" style="display: none;" value="'.$lotdetails['active_inactive'].'" 
                                       data-value="'.$lotdetails['id'].'"  '.$statusChecked .'>';
                                       
                                       // if($can_delete) { 
                                       //  echo ' <a href="javascript:void(0)" data-tooltip="delete" class="delete_listing btn-xs btn btn-danger" data-href="'.base_url().'inventory/delete_reports/'.$lotdetails["id"].'"><i class="fa fa-trash"></i></a>';
                                       //  }
                                       ?>
                                 </td>
                              </tr>
                              <?php }}?>
                           </tbody>
                        </table>
                     </div>
                     <div role="tabpanel" class="tab-pane  " id="archieved_lot_content" aria-labelledby="archieved-lot-tab">
                        <table id ="archivedlottble" class="table table-striped maintable" id="archivedLotTable">
                           <thead>
                              <tr>
                                 <th>Id</th>
                                 <th>Lot Number</th>
                                 <th>Material Type</th>
                                 <th>Material Name</th>
                                 <th>MOU Price</th>
                                 <th>MRP Price</th>
                                 <th>Avail. Quantity</th>
                                 <th>Date</th>
                                 <th>Created by</th>
                                 <th>Created Date</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                                 if(!empty($archived_lot_details)){
                                     foreach($archived_lot_details as $lotdetails){       
                                         $rty = getNameById('user_detail',$lotdetails['created_by'],'u_id');
                                         $usernme = !empty($rty)?$rty->name:'';
                                         $matype = getNameById('material_type',$lotdetails['mat_type_id'],'id');
                                         $mat_type = !empty($matype)?$matype->name:'';
                                         $manme = getNameById('material',$lotdetails['mat_id'],'id');
                                         $mat_nme = !empty($manme)?$manme->material_name:'';
                                         $statusChecked = $lotdetails['active_inactive']==1?'checked':'';                
                                 ?>
                              <tr>
                                 <td>
                                    <?php echo $lotdetails['id'];?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['lot_number'];?>
                                 </td>
                                 <td>
                                    <?php echo $mat_type; ?>
                                 </td>
                                 <td>
                                    <?php  echo $mat_nme; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['mou_price']; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['mrp_price']; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['quantity']; ?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['date']; ?>
                                 </td>
                                 <td>
                                    <?php echo $usernme;?>
                                 </td>
                                 <td>
                                    <?php echo $lotdetails['created_date'];?>
                                 </td>
                                 <td>
                                    <?php 
                                       if($can_edit) { 
                                           echo '<button class="btn btn-info btn-xs inventory_tabs" data-tooltip="Edit" id="'.$lotdetails["id"].'" data-toggle="modal" data-id="editlotmanagement"><i class="fa fa-pencil"></i> </button>'; 
                                       }
                                       // if($can_view) { 
                                           // echo '<a href="javascript:void(0)" id="'.$dailyreportsetting["id"] . '" data-id="location_view" class="inventory_tabs btn btn-warning btn-xs" id="'. $dailyreportsetting["id"].'"><i class="fa fa-eye"></i> View </a>'; 
                                       // }
                                       
                                       echo '<input type="checkbox" class="js-switch change_status_lot"  data-switchery="true" style="display: none;" value="'.$lotdetails['active_inactive'].'" 
                                       data-value="'.$lotdetails['id'].'"  '.$statusChecked .'>';
                                       
                                       // if($can_delete) { 
                                       //  echo ' <a href="javascript:void(0)" data-tooltip="delete" class="delete_listing btn-xs btn btn-danger" data-href="'.base_url().'inventory/delete_reports/'.$lotdetails["id"].'"><i class="fa fa-trash"></i></a>';
                                       //  }
                                       ?>
                                 </td>
                              </tr>
                              <?php }}?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab3">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <label class="col-md-3 col-sm-3 col-xs-12" for="type">Inventory Location ON/OFF<span class="required">*</span></label>
               <div class="col-md-9 col-sm-6 col-xs-12">
                  <table class="table table-striped">
                     <tbody>
                        <tr>
                           <th scope="row">Inventory Location ON / OFF</th>
                           <td>
                              <form id="multi_loc_on_off" method="post" action="<?php echo base_url(); ?>account/save_invoice_num_prefix" enctype="multipart/form-data">
                                 <?php
                                    $discount_Settings = $this->inventory_model->get_data('company_detail',array('id'=> $this->companyGroupId));
                                    $statusChecked = $discount_Settings[0]['invnt_loc_on_off']==1?'checked':'';
                                    $onoff = $discount_Settings[0]['invnt_loc_on_off']==1?'ON':'OFF';
                                    //pre($discount_Settings[0]['discount_on_off']);
                                     #if($discount_Settings[0]['invnt_loc_on_off'] == '0'){//0 for OFF        
                                          echo '<input type="checkbox" class="js-switch change_status_mat_loc"  data-switchery="true" style="display: none;" value="'.$discount_Settings[0]['invnt_loc_on_off'].'" 
                                             data-value="'.$this->companyGroupId.'"  '.$statusChecked .'>';
                                             #echo $onoff;        
                                    ?>
                                 <label for="subscribeNews">
                                 <?php echo $onoff; ?>
                                 </label>
                              </form>
                           </td>
                        </tr>
                        <tr>
                           <th scope="row">Reorder level report daily mail to admin ON / OFF</th>
                           <td>
                              <form id="multi_loc_on_off" method="post" action="<?php echo base_url(); ?>inventory/save_inventory_setting" enctype="multipart/form-data">
                                 <?php
                                    $discount_Settings = $this->inventory_model->get_data('company_detail',array('id'=> $this->companyGroupId));
                                    $statusChecked = $discount_Settings[0]['invnt_reorder_on_off']==1?'checked':'';
                                    $onoff = $discount_Settings[0]['invnt_reorder_on_off']==1?'ON':'OFF';
                                    //pre($discount_Settings[0]['discount_on_off']);
                                    #if($discount_Settings[0]['invnt_loc_on_off'] == '0'){//0 for OFF        
                                      echo '<input type="checkbox" class="js-switch change_inventory_setting" name="invnt_reorder_on_off"  data-switchery="true" style="display: none;" value="'.$discount_Settings[0]['invnt_reorder_on_off'].'" 
                                         data-value="'.$this->companyGroupId.'"  '.$statusChecked .'>';
                                         #echo $onoff;        
                                    ?>
                                 <label for="subscribeNews">
                                 <?php echo $onoff; ?>
                                 </label>
                              </form>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab4">
            <div class="col-md-12 col-sm-12  ">
               <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveuomtype" enctype="multipart/form-data" id="myform" novalidate="novalidate">
                  <hr>
                  <div class="bottom-bdr"></div>
                  <?php if(!empty($uom_list1)){ ?>
                  <div class="form-group blog-mdl" style="padding-bottom: 15px;">
                     <div class="col-md-12 col-sm-12 col-xs-12 processDiv ">
                        <div style="overflow:auto; overflow:auto;" id="chkIndex_1">
                           <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                              <div class="col-md-12">
                                 <label class="col-md-4">UOM<span class="required">*</span></label>
                                 <div class="col-md-7 col-xs-12 item form-group">
                                    <input type="text" name="uom_quantity" required="required" class="form-control " placeholder="UOM" value=""> 
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <label class="col-md-4">UOM Type</label>
                                 <div class="col-md-7 col-xs-12 item form-group">
                                    <input type="text" name="uom_quantity_type" class="form-control " placeholder="UOM Type" value=""> 
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                              <div class="col-md-12">
                                 <label class="col-md-4">UQC Code</label>
                                 <div class="col-md-7 col-xs-12 item form-group">
                                    <input type="text" name="ugc_code" required="required" class="form-control " placeholder="UQC Code" value=""> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php }else{ ?>
                  <div class="col-md-12 col-sm-12 col-xs-12 processDiv ">
                     <div style="overflow:auto; overflow:auto;">
                        <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                           <div class="item col-md-12 col-sm-12 col-xs-12 form-group">
                              <label class="col-md-4">UOM <span class="required">*</span></label>
                              <div class=" col-md-7 col-xs-12">
                                 <input type="text" name="uom_quantity" required="required" class="form-control" placeholder="UOM" value="<?php if(!empty($uom_list1)) echo $uom_list1->uom_quantity; ?>" onkeypress="return float_validation(event, this.value)"> 
                              </div>
                           </div>
                           <div class="item col-md-12 col-sm-12 col-xs-12 form-group">
                              <label class="col-md-4">UOM Type </label>
                              <div class=" col-md-7 col-xs-12">
                                 <input type="text" name="uom_quantity_type"  class="form-control" placeholder="UOM Type" value="<?php if(!empty($uom_list1)) echo $uom_list1->uom_quantity_type; ?>"> 
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                           <div class=" item col-md-12 col-sm-12 col-xs-12 form-group">
                              <label class="col-md-4">UQC Code</label>
                              <div class=" col-md-7 col-xs-12">
                                 <input type="text" name="ugc_code" required="required" class="form-control" placeholder="UQC code" value="<?php if(!empty($uom_list1)) echo $uom_list1->ugc_code; ?>"> 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
            <?php }         ?>
            <hr>
            <div class="form-group">
            <div class="col-md-12 ">
            <center>
            <button type="reset" class="btn btn-default">Reset</button>
            <button id="send" type="submit" class="btn btn-warning">Submit</button> <a class="btn btn-danger" data-dismiss="modal">Cancel</a> </center>
            </div>
            </div>
            </form>
            <br>
            <table id="uomListable" class="table table-striped table-bordered account_index" data-id="account" style="margin-top: 86px;">
               <thead>
                  <tr>
                     <th scope="col">Id <span><a href="<?php echo base_url(); ?>inventory/uom_list?sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>inventory/uom_list?sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">UOM Quantity <span><a href="<?php echo base_url(); ?>inventory/uom_list?sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>inventory/uom_list?sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">UOM Quantity Type <span><a href="<?php echo base_url(); ?>inventory/uom_list?sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>inventory/uom_list?sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">UQC code</th>
                     <th scope="col">Created by</th>
                     <th scope="col">Created Date</th>
                     <th scope="col">Action</th>
                  </tr>
                  </tr>
               </thead>
               <tbody>
                  <?php if(!empty($uom_list1)){
                     foreach($uom_list1 as $uomlist){        
                     
                     $statusChecked = $uomlist['active_inactive']==1?'checked':'';
                     //$statusChecked = "";          
                     $action = '';
                     
                     
                     
                     
                                 $createdBYY =  getNameById('user_detail', $uomlist['created_by'],'u_id');
                     
                                 $crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others'; 
                     
                         $action = '<input type="checkbox" class="js-switch change_status_uom"  data-switchery="true" style="display: none;" value="'.$uomlist['active_inactive'].'" 
                                     data-value="'.$uomlist['id'].'"  '.$statusChecked .'>';
                     
                                     $action .= '<a href="javascript:void(0)" id="'.$uomlist['id'].'" data-id="inventory_uom_type" data-tooltip="Edit" class="inventory_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>';  
                                 
                     
                         //$action .= '<button type="button" data-process-id="'.$customer_Type["id"].'" id="'.$customer_Type["id"].'" data-id="customer_Type" class="btn btn-primary add_crm_tabs" data-toggle="modal">Edit</button>';
                     
                     
                     /*if($process_Type['used_status'] == 1){
                         $action = $action.'<a href="javascript:void(0)" class="
                         btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
                     }else{
                         $action = $action.'<a href="javascript:void(0)" class="delete_listing
                         btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" ><i class="fa fa-trash"></i></a>';
                     }*/
                     
                     echo "<tr>
                     <td data-label='Id:'>".$uomlist['id']."</td>
                     <td data-label='UOM Quantity:'>".$uomlist['uom_quantity']."</td>
                     <td data-label='UOM Quantity Type:'>".$uomlist['uom_quantity_type']."</td>
                     <td data-label='UQC code:'>".$uomlist['ugc_code']."</td>
                     <td data-label='Created by:'>".$crtd_by_name."</td>
                     <td data-label='Created Date:'>".$uomlist['created_date']."</td>
                     <td data-label='action:'>".$action."</td>   
                     </tr>";
                     }
                     } ?>
               </tbody>
            </table>
         </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="tab_content7" aria-labelledby="profile-tab5">
         <div class="col-md-12 col-sm-12 ">
            <ul class="nav nav-pills bar_tabs">
               <li class="active"><a data-toggle="pill" href="#menu2">Add Tags</a></li>
               <li><a data-toggle="pill" href="#menu3">Add Tag Types</a></li>
            </ul>
            <div class="tab-content">
               <div id="menu2" class="tab-pane fade in active">
                  <h3 class="Material-head">
                     Add Tags
                     <hr>
                  </h3>
                  <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/savetag" enctype="multipart/form-data" id="myform" novalidate="novalidate">
                     <input type="hidden" name="id" value="">
                     <!-- <input type="hidden" name="created_date" value="<?php if(!empty($tag_types)) echo $tag_types->created_date; ?>"> -->
                     <div class="col-md-6 col-sm-12 col-xs-12">
                        <label class="col-md-3" style="border-right: 1px solid #c1c1c1 !important; ">Tag Types</label>
                        <div class="col-md-7">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" required="required" name="tag_id" data-id="tag_types" data-key="id" data-fieldname="tag_types" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> and active_inactive = 1">
                              <option value="">Select Option</option>
                           </select>
                        </div>
						
                     </div>
					 <div class="col-md-6 col-sm-12 col-xs-12">
					 <div class="  processDiv11">
                           <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                              <label class="col-md-3" style="border-right: 1px solid #c1c1c1 !important; ">Tag Name</label>
							  <div class="col-md-6">
                              <input type="text" id="processName" name="tag_names[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Tag Name" value="<?php if(!empty($customer_type)) echo $customer_type->industry_detl; ?>" style="border-right: 1px solid #c1c1c1 !important; border-top: 1px solid #c1c1c1 !important;">
							  </div>
							  <div class="col-md-1 col-sm-12">
                              <div class="input-group-append">
                                 <button class="btn edit-end-btn addMoreProcess11" type="button">Add</button>
                              </div>
                           </div>
                           </div>
                           
                        
                     </div>
					 </div>
                     <hr>
                     <div class="form-group">
                        <div class="col-md-12 ">
                           <center>
                              <button type="reset" class="btn btn-default">Reset</button>
                              <button id="send" type="submit" class="btn btn-warning">Submit</button> <a class="btn btn-danger" data-dismiss="modal">Cancel</a> 
                           </center>
                        </div>
                     </div>
                  </form>
                  <table id="inventorysettingtble11" class="table table-striped table-bordered account_index" data-id="account" style="margin-top: 86px;">
                     <thead>
                        <tr>
                           <th scope="col">Id</th>
                           <th scope="col">Tag Types</th>
                           <th scope="col">Tag Name</th>
                           <th scope="col">Created by</th>
                           <th scope="col">Created Date</th>
                           <th scope="col">Action</th>
                        </tr>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($tag_details)){
                           foreach($tag_details as $tagdetails){        
                           
                           $statusChecked = $tagdetails['active_inactive']==1?'checked':'';         
                           $action = '';
                           
                           
                           
                           
                                       $createdBYY =  getNameById('user_detail', $tagdetails['created_by'],'u_id');
                           
                                       $crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others'; 
                           
                           
                                        $tag_typs =  getNameById('tag_types', $tagdetails['tag_id'],'id');
                           
                                         $tagtyps = !empty($tag_typs)?$tag_typs->tag_types:''; 
                           
                           
                           
                           
                                           $action = '<input type="checkbox" class="js-switch change_status_tag_details"  data-switchery="true" style="display: none;" value="'.$tagdetails['active_inactive'].'" 
                                           data-value="'.$tagdetails['id'].'"  '.$statusChecked .'>';
                           
                           
                                           $action .= '<a href="javascript:void(0)" id="'.$tagdetails['id'].'" data-id="tag_details_edit" data-tooltip="Edit" class="inventory_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>';  
                                       
                           
                              
                           
                           echo "<tr>
                           <td data-label='Id:'>".$tagdetails['id']."</td>
                           <td data-label='Tag Types:'>".$tagtyps."</td>
                           <td data-label='Tag Types:'>".$tagdetails['tag_name']."</td>
                           <td data-label='Created by:'>".$crtd_by_name."</td>
                           <td data-label='Created Date:'>".$tagdetails['created_date']."</td>
                           <td data-label='action:'>".$action."</td>   
                           </tr>";
                           }
                           } ?>
                     </tbody>
                  </table>
               </div>
               <div id="menu3" class="tab-pane fade">
                  <h3 class="Material-head">
                     Add Tag Types
                     <hr>
                  </h3>
                  <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/savetagtypes" enctype="multipart/form-data" id="myform" novalidate="novalidate">
                     <input type="hidden" name="id" value="">
                     <!-- <input type="hidden" name="created_date" value="<?php if(!empty($tag_types)) echo $tag_types->created_date; ?>"> -->
					 
					  <div class="col-md-6 col-sm-12 col-xs-12">
					 <div class="processDiv">
                           <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                              <label class="col-md-3" style="border-right: 1px solid #c1c1c1 !important; ">Tag Types</label>
							  <div class="col-md-6">
                              <input type="text" id="processName" name="tag_types[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Tag Types" value="<?php if(!empty($customer_type)) echo $customer_type->industry_detl; ?>" style="border-right: 1px solid #c1c1c1 !important;">
							  </div>
							  <div class="col-md-1 col-sm-12">							
                              <div class="input-group-append">
                                 <button class="btn edit-end-btn addMoreProcess" type="button">Add</button>
                              </div>
                           </div>
                           </div>
                           
                        
                     </div>
					 </div>
					 
                     <hr>
                     <div class="form-group">
                        <div class="col-md-12 ">
                           <center>
                              <button type="reset" class="btn btn-default">Reset</button>
                              <button id="send" type="submit" class="btn btn-warning">Submit</button> <a class="btn btn-danger" data-dismiss="modal">Cancel</a> 
                           </center>
                        </div>
                     </div>
                  </form>
                  <table id="inventorysettingtble11" class="table table-striped table-bordered account_index" data-id="account" style="margin-top: 86px;">
                     <thead>
                        <tr>
                           <th scope="col">Id</th>
                           <th scope="col">Tag Types</th>
                           <th scope="col">Created by</th>
                           <th scope="col">Created Date</th>
                           <th scope="col">Action</th>
                        </tr>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($tag_types)){
                           foreach($tag_types as $tagtypes){        
                           
                           $statusChecked = $tagtypes['active_inactive']==1?'checked':'';         
                           $action = '';
                           
                           
                           
                           
                                       $createdBYY =  getNameById('user_detail', $tagtypes['created_by'],'u_id');
                           
                                       $crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others'; 
                           
                               $action = '<input type="checkbox" class="js-switch change_status_tag_types"  data-switchery="true" style="display: none;" value="'.$tagtypes['active_inactive'].'" 
                                           data-value="'.$tagtypes['id'].'"  '.$statusChecked .'>';
                           
                                           $action .= '<a href="javascript:void(0)" id="'.$tagtypes['id'].'" data-id="tag_type_edit" data-tooltip="Edit" class="inventory_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i>  </a>';  
                                       
                                              
                           
                           echo "<tr>
                           <td data-label='Id:'>".$tagtypes['id']."</td>
                           <td data-label='Tag Types:'>".$tagtypes['tag_types']."</td>
                           <td data-label='Created by:'>".$crtd_by_name."</td>
                           <td data-label='Created Date:'>".$tagtypes['created_date']."</td>
                           <td data-label='action:'>".$action."</td>   
                           </tr>";
                           }
                           } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="VariantType" aria-labelledby="profile-tab5">
         <div class="col-md-12 col-sm-12 ">
            <ul id="myTab" class="nav nav-pills bar_tabs">
               <li class="active"><a data-toggle="pill" href="#Variantmenu2">Variant Types</a></li>
               <li><a data-toggle="pill" href="#Variantmenu3">Variant Options</a></li>
            </ul>
            <div class="tab-content">
               <div id="Variantmenu2" class="tab-pane fade in active">
                  <h3 class="Material-head">
                     Variant Types
                     <hr>
                  </h3>
                  <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveVariantType" enctype="multipart/form-data" novalidate="novalidate">
                  <div class="col-md-7 col-xs-12 col-sm-12 vertical-border">
                     <div class="item form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12" for="supp_code">Variant Types</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                           <input type="text" id="variant_type" name="variant_type" required="required" class="form-control col-md-12 col-xs-12" placeholder="Variant Types" value="" style="border-right: 1px solid #c1c1c1 !important;">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 " style="margin: 20px 0px;">
                     <center>
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button id="send" type="submit" class="btn btn-warning">Submit</button> <a class="btn btn-danger" data-dismiss="modal">Cancel</a> 
                     </center>
                  </div>
               </form>
                  <hr>
                  <div class="bottom-bdr"></div>
                  <table id="inventorysettingtble11" class="table table-striped table-bordered account_index" data-id="account" style="width: 48%;">
                     <thead>
                        <tr>
                           <th scope="col">Id</th>
                           <th scope="col">Variant Types</th>
                           <th scope="col">Created Date</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php if(!empty($variant_type)){
                        $i=1;
                        foreach ($variant_type as $key => $variant) {
                        ?>
                        <tr>
                           <td><?php echo $i; ?></td>
                           <td><?php echo $variant['varient_name']; ?></td>
                           <td><?php echo $variant['created_date']; ?></td>
                           <td class="hidde action" style="position: relative;">
                              <i class="fa fa-cog" aria-hidden="true"></i>
                              <div class="on-hover-action">
                                 <span class="switchery switchery-default" style="background-color: rgb(38, 185, 154); border-color: rgb(38, 185, 154); box-shadow: rgb(38, 185, 154) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                                 <a href="javascript:void(0)" type="button" class="btn btn-info btn-lg inventory_tabs" id="<?php echo $variant['id']; ?>" data-id="editvarienttype" data-toggle="modal">Edit Variant Types</a>
                              </div>
                           </td>
                        </tr>
                     <?php $i++; }
                     } else {
                      echo "<tr><td>No data found</td></tr>";  
                     } ?>

                     </tbody>
                  </table>
               </div>
               <div id="Variantmenu3" class="tab-pane fade">
                  <h3 class="Material-head">
                     Variant Options
                     <hr>
                  </h3>
                  <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveVariantOption" enctype="multipart/form-data" novalidate="novalidate">
                  <div class="col-md-12 col-xs-12 col-sm-12 vertical-border" style="background-position-x: 8%;">
                     <div class="item form-group">
                        <label class="col-md-1 col-sm-12 col-xs-12" for="supp_code">Variant Options</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible variantoptId" required="required" name="variant_type" data-id="variant_types" data-key="id" data-fieldname="varient_name" tabindex="-1" aria-hidden="true" data-where="" id="variant_type">
                              <option value="">Select Option</option>
                           </select>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                           <input type="text" id="variant_option" name="variant_option" required="required" class="form-control col-md-12 col-xs-12" placeholder="Variant Option Name" value="" style="border-right: 1px solid #c1c1c1 !important;">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                           <input type="file" class="form-control col-md-7 col-xs-12" name="varient_option_img" onchange="loadFile(event)">
                           <img id="output_main" style="display:none; width: 50px; height: 50px;" src="">
                        </div>

                     </div>
                  </div>
                  <div class="col-md-12 " style="margin: 20px 0px;">
                     <center>
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button id="send" type="submit" class="btn btn-warning">Submit</button> <a class="btn btn-danger" data-dismiss="modal">Cancel</a> 
                     </center>
                  </div>
               </form>
                  <hr>
                  <div class="bottom-bdr"></div>
                  <table id="inventorysettingtble11" class="table table-striped table-bordered account_index" data-id="account" style="width: 48%;">
                     <thead>
                        <tr>
                           <th scope="col">Id</th>
                           <th scope="col">Variant Types</th>
                           <th scope="col">Variant Option</th>
                           <th scope="col">Variant Option Image</th>
                           <th scope="col">Created Date</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($variant_options)){
                        $i=1;
                        foreach ($variant_options as $key => $variant_option) {
                        ?>
                        <tr>
                           <td><?php echo $i; ?></td>
                           <td><?php
                           $variant_types_id = getNameById('variant_types',$variant_option['variant_type_id'],'id');
                            echo $variant_types_id->varient_name; ?></td>
                           <td><?php echo $variant_option['option_name']; ?></td>
                           <td><?php if(!empty($variant_option['option_img_name'])){ ?>
                           <img style="width: 50px; height: 50px;" src="<?php echo base_url(); ?>assets/modules/inventory/varient_opt_img/<?php echo $variant_option['option_img_name']; ?>">
                           <?php } ?></td>
                           <td><?php echo $variant_option['created_date']; ?></td>
                           <td class="hidde action" style="position: relative;">
                              <i class="fa fa-cog" aria-hidden="true"></i>
                              <div class="on-hover-action">
                                
                                 <a href="javascript:void(0)" type="button" class="btn btn-info btn-lg inventory_tabs" data-toggle="modal"  id="<?php echo $variant_option['id']; ?>" data-id="editvarientoption">Edit</a>
                              </div>
                           </td>
                        </tr>
                     <?php $i++; }
                     } else {
                      echo "<tr><td>No data found</td></tr>";  
                     } ?>

                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
	  <div role="tabpanel" class="tab-pane fade" id="Permission" aria-labelledby="profile-tab5">
	  <div class="col-md-8 col-sm-12 col-xs-12 vertical-border">
	     <div  class="item form-group">
		     <label class="col-md-3 col-sm-12 col-xs-12">Stock Permission</label>
			<div class="col-md-7">
         <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveStockPermission">
         <?php
         $stock_permission_data = json_decode($stock_permission[0]['stock_permission']);
          ?>
         <select class="form-control selectAjaxOption select2 variantoptId select2-hidden-accessible" name="stock_permission[]" data-id="user_detail" data-key="u_id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="c_id = <?php echo $this->companyGroupId;?> and is_activated = 1" id="stock_permission" multiple="">
         <option value="">Select Option</option>
         <?php foreach ($stock_permission_data as $key => $stock_value) {
         $user_data = getNameById('user_detail', $stock_value,'u_id');
         echo '<option value="'.$stock_value.'" selected>'.$user_data->name.'</option>';
         } ?>
         </select>
           <input type="submit" class="btn btn-success float-right" value="Submit" style="margin-top:5px;">
         </form>
         </div>
			 
		 </div>
	  </div>
	  </div>
   </div>
   
</div>
<div id="inventory_add_modal" class="modal fade in" class="modal fade in" role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">??</span> </button>
            <h4 class="modal-title modalName" id="myModalLabel">Add Storage</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>

<script>
  var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output_main');
      output.src = reader.result;
      document.getElementById("output_main").style.display = "block";
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>