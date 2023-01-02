

<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<span class="mesg"></span>
<div class="x_content">	
   <div class="stik">
      <div class="col-md-12 ">
         <div class="col-md-6 datePick-right">
            <form action="<?php echo site_url(); ?>production/work_order" method="get" id="export-form">
               <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser"> 
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
			   <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
			    <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
			    <input type="hidden" value='<?php echo $_GET['search']; ?>' name='search'/>
				<input type="hidden" value='<?php echo $_GET['favourites']; ?>' name='favourites'/>
				<input type="hidden" value='<?php echo $_GET['tab']; ?>' name='tab'/>
            </form>
         </div>
      </div>
   </div>
   
  <div class="col-md-12 col-xs-12 for-mobile">
   <div class="Filter Filter-btn2">
   <form class="form-search" method="post" action="<?= base_url() ?>production/work_order">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Saleorder,Product Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="production/work_order">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						  <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab'];?>"/>
                        <a href="<?php echo base_url(); ?>production/work_order?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
						<input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
	</div>
   </form>
			
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse" style="width: 100%;">
		   <div class="col-md-12 col-xs-12">
            <!--fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/work_order"/>
                     </div>
                  </div>
               </div>
            </fieldset-->
            <form action="<?php echo base_url(); ?>production/work_order" method="get" id="date_range" style="width: 100%;">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
			   <input type="hidden" value='<?php echo $_GET['tab']; ?>' name='tab'/>
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group" style="width: 100%;">
                        <select class="form-control col-md-7 col-xs-12 selectAjaxOption select2 compny_unit" name="company_branch_id" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
                     <option value="">Select Company Branch</option>
                  </select>
				  <br>
				  <br>
                  <select class="form-control  col-md-7 col-xs-12  selectAjaxOption select2 select2-hidden-accessible select2 department1" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = ''" onChange="submitPriority(event,this)">
                   <option value="">Select Department</option>
                  </select>
                     </div>
                  </div>
               </div>
            </fieldset>
            </form>
         </div>
		 
         <div class="dropdown __statusDropDowns" >
               <!--button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Filter By Material Status<span class="caret"></span></button-->
               <ul class="dropdown-menu" role="menu" id="material-menu">
                  <li class="<?php if(!empty($_GET['material_status']) && $_GET['material_status'] == '1' ) { echo 'active'; } else {  echo ''; } ?>"><a href="<?php echo base_url(); ?>production/work_order/?material_status=1" >In Stock</a></li>
                  <li class="<?php if(!empty($_GET['material_status']) && $_GET['material_status'] == '2' ) { echo 'active'; } else {  echo ''; } ?>"><a href="<?php echo base_url(); ?>production/work_order/?material_status=2">Not available</a></li>
                  <li class="<?php if(!empty($_GET['material_status']) && $_GET['material_status'] == '3' ) { echo 'active'; } else {  echo ''; } ?>"><a href="<?php echo base_url(); ?>production/work_order/?material_status=3">Expected</a></li>
               </ul>
            </div>
            <div class="dropdown __statusDropDowns">    
               <!--button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Filter By Production Status<span class="caret"></span></button-->
               <ul class="dropdown-menu" role="menu" id="production-menu">
                     <li class="<?php if(!empty($_GET['production_status']) && $_GET['production_status'] == '1' ) { echo 'active'; } else {  echo ''; } ?>" ><a href="<?php echo base_url(); ?>production/work_order/?production_status=1" >Not started</a></li>
                     <li class="<?php if(!empty($_GET['production_status']) && $_GET['production_status'] == '2' ) { echo 'active'; } else {  echo ''; } ?>"><a href="<?php echo base_url(); ?>production/work_order/?production_status=2">On hold</a></li>
                     <li class="<?php if(!empty($_GET['production_status']) && $_GET['production_status'] == '3' ) { echo 'active'; } else {  echo ''; } ?>"><a href="<?php echo base_url(); ?>production/work_order/?production_status=3">Work In progress</a></li>
                     <li class="<?php if(!empty($_GET['production_status']) && $_GET['production_status'] == '4' ) { echo 'active'; } else {  echo ''; } ?>"><a href="<?php echo base_url(); ?>production/work_order/?production_status=4">Ready to dispatch</a></li>
               </ul>
            </div>
		 </div>
			
			
 </div>  
   <div class="row hidde_cls ">
      <div class="col-md-12 export_div">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
		    <?php if($can_add) { 		
					echo '<button type="buttton" class="btn btn-info productionTab addBtn showmatDtal" data-toggle="modal" data-id="work_order_Adddata"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>  For Stock</button>';			
					echo '<button type="buttton" class="btn btn-info productionTab addBtn" id="work_order_add" data-toggle="modal" data-id="work_order_edit"><i class="fa fa-plus"></i>Add</button>';
               }?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='work_order' id="table" data-msg="Work Order" data-path="production/work_order"/>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
            
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>production/work_order" method="get" >
               <input type="hidden" value='1' name='favourites'/>
			   <input type="hidden" value='<?php echo $_GET['tab']; ?>' name='tab'/>
               <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
               <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
         </div>
        
      </div>
   </div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="__workOrderDiv" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" >
         <li role="presentation" class="__inprocessOrder active"><a onclick="submit_inprocess_workorder();" href="#inprocess_workorder" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="actve_mat_form()">In Process Work Order</a>
         </li>
         <li role="presentation" class="__completeOrder"><a onclick="submit_complete_workorder();" href="#complete_workorder" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" onClick="noninvtry_mat_form()">Complete Work Order</a>
         </li>
         <li role="presentation" class="__inactiveOrder"><a onclick="submit_inactive_workorder();" href="#workorder_inactive" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" onClick="inactve_mat_form()">Inactive Work Order</a>
         </li>
         <li role="presentation" class="__priorityOrder"><a onclick="submit_priority_workorder();" href="#workorder_priority" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" onClick="priority_mat_form()">Work Order Priority</a>
         </li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="inprocess_workorder" aria-labelledby="home-tab">
            <div id="print_div_content" class="table-responsive"  style="margin-top: 58px;">
   		 <form id="inprocess_tab">	<input type="hidden" value="inprocess_tab" name="tab">	</form>
               <table class="table table-striped  table-bordered user_index table-1" data-id="user" border="1" cellpadding="3" >  
                  <thead>
                     <tr>
                        <th ></th>
                        <th scope="col" data-type="numeric">Id<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=inprocess_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=inprocess_tab" class="down"></a></span><span class="resize-handle"></span></th>
                        <th scope="col">Sale Order<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=inprocess_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=inprocess_tab" class="down"></a></span><span class="resize-handle"></span></th>
                        <th scope="col">Customer Name<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=inprocess_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=inprocess_tab" class="down"></a></span><span class="resize-handle"></span></th>
                        <th scope="col">Work Order Name<span class="resize-handle"></span></th>
                        <th scope="col">Product<span class="resize-handle"></span></th>
                        <th scope="col">Expected Date<span class="resize-handle"></span></th>
                        <th scope="col">Created By <span class="resize-handle"></span></th>
                        <th scope="col">Created Date<span class="resize-handle"></span></th>
                        <th scope="col">Raw Material<span class="resize-handle"></span></th>
                        <th scope="col">Production<span class="resize-handle"></span></th>
                        <th scope="col" class='hidde'>Action<span class="resize-handle"></span></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($work_order)){
                        foreach($work_order as $workOrder){
                        $accountName = getNameById('account',$workOrder['customer_name_id'],'id');
                        $statusChecked = $workOrder['active_inactive']==1?'checked':'';
                        ?>
                     <tr>
                        <td><?php
                           if($workOrder['favourite_sts'] == '1'){
                           echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$workOrder['id']."  checked = 'checked'>";
                           echo"<input type='hidden' value='work_order' id='favr' data-msg='Work Order' data-path='production/work_order' favour-sts='0' id-recd=".$workOrder['id'].">";
                           }else{
                           echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$workOrder['id'].">";
                           echo"<input type='hidden' value='work_order' id='favr' data-msg='Work Order' data-path='production/work_order' favour-sts='1' id-recd =".$workOrder['id'].">";
                           }?>
                        </td>
                        <td data-label="Id:"><?php echo $workOrder['id']; ?></td>       
         			   <td data-label="Sale Order:"><a href="javascript:void(0)" id="<?php echo $workOrder['sale_order_id']; ?>" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs"><?php echo $workOrder['sale_order_no']; ?></a></td>
                        <td data-label="Customer Name:"><?php if(!empty($accountName->name)){echo $accountName->name;}else{ echo "";} ?></td>
						<?php 
							 if($workOrder['product_detail'] !=''){
                                 	$products=json_decode($workOrder['product_detail']);
                                 	$createdByData = getNameById('user_detail',$workOrder['created_by'],'u_id');
                                 	if(!empty($createdByData)){
                                 		$createdByName = $createdByData->name;
                                 	}else{
                                 	$createdByName = '';
                                 	}
                                 	
                                 	foreach($products as $product){
                                 	$productDetail = getNameById('material',$product->product,'id');
                                 	$materialName = !empty($productDetail)?$productDetail->material_name:'';
                                 	$ww =  getNameById('uom', $product->uom,'id');
                                 		$uom = !empty($ww)?$ww->ugc_code:'';
                                 		$output[] = array( 
         									   'SaleOrder' => $workOrder['sale_order_no'],
         									   'Customer Name'=>$accountName->name,
         									   'Product'=>$materialName,
         									   'Uom'=>$uom,
         									   'JobCard'=>$product->job_card,
         									   'Delivery Date'=>date("d-m-Y", strtotime($workOrder['expected_delivery_date'])));
                                 	} 
         							
                                 }
							 
								 
						?>
						<td data-label="Work Order Name:"><?php echo $workOrder['workorder_name'] ; ?></td>
                        <td data-label="Product:"><a href="javascript:void(0);" id="<?php echo $workOrder['id']; ?>" data-id='work_order_viewmat' class='productionTab'><?php echo $materialName; ?></a></td>
                        <td data-label="Expected Date:"><?php echo date("j F , Y", strtotime($workOrder['expected_delivery_date'])); ?></td>
                        <td data-label="Created By:"><?php echo $createdByName; ?></td>
                        <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($workOrder['created_date'])); ?></td>
                        
                        <td data-work-order-id="<?php echo $workOrder['id']; ?>"> 
                         
                                  

                           <?php
                           $workOrderProductDetails=json_decode($workOrder['product_detail'],true);
                           $alljobcardqty=[];
                           if($workOrderProductDetails){
                              foreach($workOrderProductDetails as $keyVal => $workOrderProductDetail){

                                   $whereConditionJobCard  =  array('job_card_no' => $workOrderProductDetail['job_card'],'material_id' => '');
                                   $jobCardDetails         =  $this->production_model->get_job_card_data('job_card','material_name_id', $whereConditionJobCard);

                                   if($jobCardDetails){

                                      $alljobcardqty[$jobCardDetails['id']]=$jobCardDetails;
                                      $alljobcardqty[$jobCardDetails['id']]['transfer_quantity'] = $workOrderProductDetail['transfer_quantity'];


                                  }
                              }
                           }
                           $res_detail_array=array();
                       if($alljobcardqty):
                  foreach($alljobcardqty as $jobkey => $materialInfo12){
                  $jobCardMaterialss  = json_decode($materialInfo12['material_details'],true);
                                 foreach ($jobCardMaterialss as $key => $materialInfo) {
                         $newQuantityValuert = ($materialInfo12['lot_qty'] != 0 ) ? $materialInfo['quantity'] / $materialInfo12['lot_qty'] : 0;
                                $newQuantityValue= $newQuantityValuert * $materialInfo12['transfer_quantity'];
                                $expectedQuantity = ( $newQuantityValue > 0) ? $materialInfo['quantity'] * $newQuantityValue : $materialInfo['quantity'];
                                  $where = "reserved_material.mayerial_id = '".$materialInfo['material_name_id']."' AND reserved_material.created_by_cid ='".$this->companyId."' AND reserved_material.work_order_id ='".$work_order->id."' AND reserved_material.job_card_id =".$materialInfo12['id'];
                                $reservedData = $this->production_model->get_data_single('reserved_material', $where);
                                $reserved_quantitym = $reservedData ? $reservedData['quantity'] : 0;
                                $yu = getNameById_mat('mat_locations',$materialInfo['material_name_id'],'material_name_id');
                                $sum = 0;
                                if(!empty($yu)){ foreach ($yu as $ert) {$sum += $ert['quantity'];}}
                                     $quantity_required = round($newQuantityValue,2);
                                     $reserved_quantity = $reserved_quantitym;
                                     $available_quantity = $sum - $reserved_quantitym;
                 if($quantity_required > $available_quantity){
                 $res_detail_array[] = 'Not Available'; 
              }  else if($available_quantity >= $quantity_required){
               $res_detail_array[] = 'In-Stock';
            } else {
            $res_detail_array[] = 'Expected';
            }

                  }
               }
                  endif;
            if(empty($res_detail_array)){
            echo '<a href="'.base_url().'production/work_order_material_details?id='.$workOrder["id"].'" class="btn btn-xs btn-Available">Material Not Found</a>'; 
            } elseif(in_array('Not Available', $res_detail_array)){
                 echo '<a href="'.base_url().'production/work_order_material_details?id='.$workOrder["id"].'" class="btn btn-xs btn-Available">Not Available</a>'; 
              }  else if(in_array('In-Stock', $res_detail_array)){
               echo '<a href="'.base_url().'production/work_order_material_details?id='.$workOrder["id"].'" class="btn btn-xs btn-Expected">In-Stock</a>';
            } else {
            echo '<a href="'.base_url().'production/work_order_material_details?id='.$workOrder["id"].'" class="btn btn-xs btn-Expected">Expected</a>';
            }
              //              if($workOrder["work_order_material_status"] == 1){
              // echo '<a href="'.base_url().'production/work_order_material_details?id='.$workOrder["id"].'" class="btn btn-xs btn-Stock">In-Stock</a>';
              //        }elseif($workOrder["work_order_material_status"] == 2){
              // echo '<a href="'.base_url().'production/work_order_material_details?id='.$workOrder["id"].'" class="btn btn-xs btn-Available">Not Available</a>';

              //        }elseif($workOrder["work_order_material_status"] == 3){
              // echo '<a href="'.base_url().'production/work_order_material_details?id='.$workOrder["id"].'" class="btn btn-xs btn-Expected">Expected</a>';

              //        } ?> 
                     </td>
                        <td data-work-order-id="<?php echo $workOrder['id']; ?>">
                           <select class="work_order_production_status <?php  if($workOrder['work_order_production_status'] == 1){ echo 'not_started'; }elseif($workOrder['work_order_production_status'] == 2){ echo 'on_hold'; }elseif($workOrder['work_order_production_status'] == 3){ echo 'in_work'; }elseif($workOrder['work_order_production_status'] == 4){ echo 'ready_to_dispatch'; }?> form-control" name="work_order_production_status">
                              <option  <?php  if($workOrder['work_order_production_status'] == 1){ echo 'selected'; } else {  echo '';  }     ?> value="1">Not started</option>
                              <option <?php  if($workOrder['work_order_production_status'] == 2){ echo 'selected'; } else {  echo '';  }     ?> value="2">On hold</option>
                              <option <?php  if($workOrder['work_order_production_status'] == 3){ echo 'selected'; } else {  echo '';  }     ?> value="3">Work In progress</option>
                              <option <?php  if($workOrder['work_order_production_status'] == 4){ echo 'selected'; } else {  echo '';  }     ?> value="4">Ready to dispatch</option>
                           </select>
                        </td>
                        <td data-label="action:" class='hidde action'>
						    <i class="fa fa-cog" aria-hidden="true"></i>
						   <div class="on-hover-action">
                           <a id="<?php echo $workOrder["id"]; ?>" data-id="work_order_edit"  class="productionTab btn btn-view  btn-xs" >Edit</a>

                           <?php echo '<a href="javascript:void(0)" id="'.$workOrder['id'].'" data-id="work_order_view" class="productionTab btn btn-view btn-xs" >View</a>'; ?>
<!-- 
                           <?php    if($workOrder['active_inactive'] == 1){ ?> <button id="inactive"  value="0" >Work Order Active </button><?php } else if($workOrder['active_inactive'] == 0){ echo 'Work Order In-Active'; }  


                           /*echo '<input type="checkbox" class="js-switch change_status"  data-switchery="true" style="display: none;" value="'.$workOrder['active_inactive'].'" 
                                 data-value="'.$workOrder['id'].'" '.$statusChecked .'>';
*/
                           ?> -->
                             <?php   if(!empty($workOrder["active_inactive"]) == 0){
              echo '<a href="'.base_url().'production/status_change/'.$workOrder["id"].'" class="btn btn-xs btn-edit">In-Active</a>';
                     }else if(!empty($workOrder["active_inactive"]) == 1){
              echo '<a href="'.base_url().'production/status_change/'.$workOrder["id"].'" class="btn btn-xs btn-edit">Work Order In-Active</a>';

                     }?>
                         <?php   if(!empty($workOrder["quality_check"]) == 0){
         			echo '<a href="'.base_url().'production/workorder_quality_chk/'.$workOrder["id"].'" class="btn btn-xs btn-edit">Quality Check</a>';
         						 }else{
         			echo '<a href="javascript:void(0)" class=" btn btn-xs btn-edit">Quality Check Done</a>';

         						 }?>
						</div>
                        </td>
                     </tr>
                     <?php 	
         					     }
         						$workOrder  = $output;
         						export_csv_excel($workOrder);} ?>
                  </tbody>
               </table>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="complete_workorder" aria-labelledby="profile-tab">
            <form id="complete_tab"><input type="hidden" value="complete_tab" name="tab">	</form>
			<table class="table table-striped  table-bordered user_index table-2" data-id="user" border="1" cellpadding="3" >  
                  <thead>
                     <tr>
                        <th></th>
                        <th scope="col">Id<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=complete_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=complete_tab" class="down"></a></span></th>
                        <th scope="col">Sale Order<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=complete_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=complete_tab" class="down"></a></span></th>
                        <th scope="col">Customer Name<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=complete_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=complete_tab" class="down"></a></span></th>
                        <th scope="col">Product</th>
                        <th scope="col">Expected Date</th>
                        <th scope="col">Created By </th>
                        <th scope="col">Created Date</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($work_order_complete)){
                       # pre($work_order_complete);
                        foreach($work_order_complete as $workOrder){
                        $accountName = getNameById('account',$workOrder['customer_name_id'],'id');
                        $statusChecked = $workOrder['active_inactive']==1?'checked':'';
                        ?>
                     <tr>
                        <td><?php
                           if($workOrder['favourite_sts'] == '1'){
                           echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$workOrder['id']."  checked = 'checked'>";
                           echo"<input type='hidden' value='work_order' id='favr' data-msg='Work Order' data-path='production/work_order' favour-sts='0' id-recd=".$workOrder['id'].">";
                           }else{
                           echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$workOrder['id'].">";
                           echo"<input type='hidden' value='work_order' id='favr' data-msg='Work Order' data-path='production/work_order' favour-sts='1' id-recd =".$workOrder['id'].">";
                           }?>
                        </td>
                        <td data-label="Id:"><?php echo $workOrder['id']; ?></td>       
                     <td data-label="Sale Order:"><a href="javascript:void(0)" id="<?php echo $workOrder['sale_order_id']; ?>" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs"><?php echo $workOrder['sale_order_no']; ?></a></td>
                        <td data-label="Customer Name:"><?php if(!empty($accountName->name)){echo $accountName->name;}else{ echo "";} ?></td>
                        <td data-label="Product:">
                           
                              <?php 
                                 if($workOrder['product_detail'] !=''){
                                    $products=json_decode($workOrder['product_detail']);
                                    $createdByData = getNameById('user_detail',$workOrder['created_by'],'u_id');
                                    if(!empty($createdByData)){
                                       $createdByName = $createdByData->name;
                                    }else{
                                    $createdByName = '';
                                    }
                                    
                                    foreach($products as $product){
                                    $productDetail = getNameById('material',$product->product,'id');
                                    $materialName = !empty($productDetail)?$productDetail->material_name:'';
                                    $ww =  getNameById('uom', $product->uom,'id');
                                       $uom = !empty($ww)?$ww->ugc_code:'';
                                       
                                 $output[] = array( 
                                       'SaleOrder' => $workOrder['sale_order_no'],
                                       'Customer Name'=>$accountName->name,
                                       'Product'=>$materialName,
                                       'Uom'=>$uom,
                                       'JobCard'=>$product->job_card,
                                       'Delivery Date'=>date("d-m-Y", strtotime($workOrder['expected_delivery_date'])));
                                    } 
                              
                                 }
                               ?>
                        
						   <a href="javascript:void(0);" id="<?php echo $workOrder['id']; ?>" data-id='work_order_viewmat' class='productionTab'><?php echo $materialName; ?></a>
                        </td>
                        <td data-label="Expected Date:"><?php echo date("j F , Y", strtotime($workOrder['expected_delivery_date'])); ?></td>
                        <td data-label="Created By:"><?php echo $createdByName; ?></td>
                        <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($workOrder['created_date'])); ?></td>
                        <td data-label="action:" class='hidde action'>
						<i class="fa fa-cog" aria-hidden="true"></i>
						   <div class="on-hover-action">
                           <a id="<?php echo $workOrder["id"]; ?>" data-id="work_order_edit"  class="productionTab btn btn-view  btn-xs" >Edit</a>
                           <?php echo '<a href="javascript:void(0)" id="'.$workOrder['id'].'" data-id="work_order_view" class="productionTab btn btn-view btn-xs" >View </a>'; ?>

                          <?php   if(!empty($workOrder["active_inactive"]) == 1){
              echo '<a href="'.base_url().'production/status_change/'.$workOrder["id"].'" class="btn btn-xs btn-edit">Work Order Active</a>';
                     }else if(!empty($workOrder["active_inactive"]) == 0){
              echo '<a href="'.base_url().'production/status_change_active/'.$workOrder["id"].'" class="btn btn-xs btn-edit">Work Order In-Active</a>';

                     }?>


                         <?php   if(!empty($workOrder["quality_check"]) == 0){
                  echo '<a href="'.base_url().'production/workorder_quality_chk/'.$workOrder["id"].'" class="btn btn-xs btn-edit">Quality Check</i></a>';
                            }else{
                  echo '<a href="javascript:void(0)" class=" btn btn-xs btn-edit">Quality Check Done</i></a>';
                            }?>
							</div>
                        </td>
                     </tr>
                     <?php    
                                       }
                           $workOrder  = $output;
                           export_csv_excel($workOrder);} ?>
                  </tbody>
               </table> 
         </div>
         <div role="tabpanel" class="tab-pane fade" id="workorder_inactive" aria-labelledby="profile-tab">
              <form id="inactive_tab">	<input type="hidden" value="inactive_tab" name="tab">	</form>
			  <table class="table table-striped  table-bordered user_index table-2" data-id="user" border="1" cellpadding="3" >  
                  <thead>
                     <tr>
                        <th></th>
                        <th scope="col">Id<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=inactive_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=inactive_tab" class="down"></a></span></th>
                        <th scope="col">Sale Order<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=inactive_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=inactive_tab" class="down"></a></span></th>
                        <th scope="col">Customer Name<span><a href="<?php echo base_url(); ?>/production/work_order?sort=asc&tab=inactive_tab" class="up"></a><a href="<?php echo base_url(); ?>/production/work_order?sort=desc&tab=inactive_tab" class="down"></a></span></th>
                        <th scope="col">Product</th>
                        <th scope="col">Expected Date</th>
                        <th scope="col">Created By </th>
                        <th scope="col">Created Date</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($active_inactive)){
                       # pre($work_order_complete);
                        foreach($active_inactive as $workOrder){
                        $accountName = getNameById('account',$workOrder['customer_name_id'],'id');
                        $statusChecked = $workOrder['active_inactive']==1?'checked':'';
                        ?>
                     <tr>
                        <td><?php
                           if($workOrder['favourite_sts'] == '1'){
                           echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$workOrder['id']."  checked = 'checked'>";
                           echo"<input type='hidden' value='work_order' id='favr' data-msg='Work Order' data-path='production/work_order' favour-sts='0' id-recd=".$workOrder['id'].">";
                           }else{
                           echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$workOrder['id'].">";
                           echo"<input type='hidden' value='work_order' id='favr' data-msg='Work Order' data-path='production/work_order' favour-sts='1' id-recd =".$workOrder['id'].">";
                           }?>
                        </td>
                        <td data-label="Id:"><?php echo $workOrder['id']; ?></td>       
                     <td data-label="Sale Order:"><a href="javascript:void(0)" id="<?php echo $workOrder['sale_order_id']; ?>" data-id="dispatched_order_view" data-tooltip="View" class="productionTab btn btn-view btn-xs"><?php echo $workOrder['sale_order_no']; ?></a></td>
                        <td data-label="Customer Name:"><?php if(!empty($accountName->name)){echo $accountName->name;}else{ echo "";} ?></td>
                        <td data-label="Product:">
                         
                              <?php 
                                 if($workOrder['product_detail'] !=''){
                                    $products=json_decode($workOrder['product_detail']);
                                    $createdByData = getNameById('user_detail',$workOrder['created_by'],'u_id');
                                    if(!empty($createdByData)){
                                       $createdByName = $createdByData->name;
                                    }else{
                                    $createdByName = '';
                                    }
                                    
                                    foreach($products as $product){
                                    $productDetail = getNameById('material',$product->product,'id');
                                    $materialName = !empty($productDetail)?$productDetail->material_name:'';
                                    $ww =  getNameById('uom', $product->uom,'id');
                                       $uom = !empty($ww)?$ww->ugc_code:'';
                                      
                                 $output[] = array( 
                                       'SaleOrder' => $workOrder['sale_order_no'],
                                       'Customer Name'=>$accountName->name,
                                       'Product'=>$materialName,
                                       'Uom'=>$uom,
                                       'JobCard'=>$product->job_card,
                                       'Delivery Date'=>date("d-m-Y", strtotime($workOrder['expected_delivery_date'])));
                                    } 
                              
                                 }
                              
                           
                                 ?>
                          
						   <a href="javascript:void(0);" id="<?php echo $workOrder['id']; ?>" data-id='work_order_viewmat' class='productionTab'><?php echo $materialName; ?></a>
                        </td>
                        <td data-label="Expected Date:"><?php echo date("j F , Y", strtotime($workOrder['expected_delivery_date'])); ?></td>
                        <td data-label="Created By:"><?php echo $createdByName; ?></td>
                        <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($workOrder['created_date'])); ?></td>
                        <td data-label="action:" class='hidde action'>
						<i class="fa fa-cog" aria-hidden="true"></i>
						   <div class="on-hover-action">
                           <a id="<?php echo $workOrder["id"]; ?>" data-id="work_order_edit"  class="productionTab btn btn-view  btn-xs" >Edit</a>
                           <?php echo '<a href="javascript:void(0)" id="'.$workOrder['id'].'" data-id="work_order_view" class="productionTab btn btn-view btn-xs" >View</a>'; ?>

                           <?php   if(!empty($workOrder["active_inactive"]) == 1){
              echo '<a href="'.base_url().'production/status_change/'.$workOrder["id"].'" class="btn btn-xs btn-edit">In-Active</a>';
                     }else if(!empty($workOrder["active_inactive"]) == 0){
              echo '<a href="'.base_url().'production/status_change_active/'.$workOrder["id"].'" class="btn btn-xs btn-edit">Work Order Active</a>';

                     }?>

                         <?php   if(!empty($workOrder["quality_check"]) == 0){
                  echo '<a href="'.base_url().'production/workorder_quality_chk/'.$workOrder["id"].'" class="btn btn-xs btn-edit">Quality Check</i></a>';
                            }else{
                  echo '<a href="javascript:void(0)" class=" btn btn-xs btn-edit">Quality Check Done</i></a>';
                            }?>
							</div>
                        </td>
                     </tr>
                     <?php    
                                       }
                           $workOrder  = $output;
                           export_csv_excel($workOrder);} ?>
                  </tbody>
               </table> 
             </div>
     

             <div role="tabpanel" class="tab-pane fade" id="workorder_priority" aria-labelledby="profile-tab">
            <form id="priority_tab">   <input type="hidden" value="priority_tab" name="tab"> 

            <p class="text-muted font-13 m-b-30"></p>
            <div id="print_div_content">
               <div id="sortableKanbanBoards" class="saleOrderPriority">
                  <div class="panel panel-primary kanban-col" style="width:100%">
                     <div class="panel-heading">
                        Set Work order Priority
                        <!--i class="fa fa-2x fa-plus-circle pull-right"></i-->
                        <i class="fa fa-2x fa-minus-circle pull-right machineOrder"></i>
                     </div>
                     <div class="panel-body">
                        <div id="sale_order
                           " class="kanban-centered">
                           <?php if(!empty($work_orders_priority)){
                              $i = 0;
                              foreach($work_orders_priority as $work_priority){ 
                                 $i++;
                                 
                                 $accountName = getNameById('account',$work_priority['customer_name_id'],'id');
                                 $accountName = !empty($accountName)?$accountName->name:'';                             
                                 $workorder_name = $work_priority['workorder_name'];
                                 
                                 if($work_priority['product_detail'] !=''){
                                    $products=json_decode($work_priority['product_detail']);
                                    $createdByData = getNameById('user_detail',$work_priority['created_by'],'u_id');
                                    if(!empty($createdByData)){
                                        $createdByName = $createdByData->name;
                                    }else{
                                    $createdByName = '';
                                    }
                                    
                                    foreach($products as $product){
                                    $productDetail = getNameById('material',$product->product,'id');
                                    $materialName = !empty($productDetail)?$productDetail->material_name:'';
                                    $ww =  getNameById('uom', $product->uom,'id');
                                        $uom = !empty($ww)?$ww->ugc_code:'';
                                        $output[] = array( 
                                               'SaleOrder' => $work_priority['sale_order_no'],
                                               'Customer Name'=>$accountName->name,
                                               'Product'=>$materialName,
                                               'Uom'=>$uom,
                                               'JobCard'=>$product->job_card,
                                               'Delivery Date'=>date("d-m-Y", strtotime($work_priority['expected_delivery_date'])));
                                    } 
                                    
                                 }

                                 $departmentData = getNameById('department',$work_priority['department_id'],'id');
                                 if(!empty($departmentData)){
                                 $departmentName = $departmentData->name;
                                 }
                                 $getUnitName = getNameById('company_address',$work_priority['company_branch_id'],'compny_branch_id');
                                 if(!empty($getUnitName)){
                                 $compnyName = $getUnitName->company_unit;
                                 }

                                 ?>
                           <div class="main-rw">
                              <a><span class="counting-bg step_no"><?php echo $work_priority['priority_order']; ?></span></a>
                              <article class="kanban-entry grab saleOrder" id="item<?php echo $work_priority['priority_order']; ?>" data_sale_order_id="<?php echo $work_priority['id'];?>" data_tab_name="work_order" draggable="true"  data_priority="<?php echo $work_priority['priority_order']; ?>">
                                 <div class="kanban-entry-inner" >
                                    <div class="kanban-label"> 
                                       <?php echo " <b style='font-weight: 800; font-style:italic;'>Work Order Id : ".$work_priority['id']."</b>                   |                   Work Order Name : ".$workorder_name. "                  |                   Customer Name : ".$accountName."                  |                   Company Branch : ".$compnyName."                  |                   Department : ".$departmentName."                   |                   Created By : ".$createdByName."                   |                   Created Date: ".$work_priority['created_date']; ?>
                                    </div>
                                 </div>
                              </article>
                           </div>
                           <?php } } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            </form>
             </div>

			 
            <?php echo $this->pagination->create_links(); ?> 			 
   </div>
</div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Work Order</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="text-center">
               <i class="fa fa-refresh fa-5x fa fa-spin"></i>
               <h4>Processing...</h4>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
function setListeners(table){
 var pageX,curCol,nxtCol,curColWidth,nxtColWidth;
 div.addEventListener('mousedown', function (e) {
  curCol = e.target.parentElement;
  nxtCol = curCol.nextElementSibling;
  pageX = e.pageX;
  curColWidth = curCol.offsetWidth
  if (nxtCol)
   nxtColWidth = nxtCol.offsetWidth
 });

 document.addEventListener('mousemove', function (e) {
  if (curCol) {
   var diffX = e.pageX - pageX;
 
   if (nxtCol)
    nxtCol.style.width = (nxtColWidth - (diffX))+'px';

   curCol.style.width = (curColWidth + diffX)+'px';
  }
 });

document.addEventListener('mouseup', function (e) { 
 curCol = undefined;
 nxtCol = undefined;
 pageX = undefined;
 nxtColWidth = undefined;
 curColWidth = undefined;
 });
}
</script>
