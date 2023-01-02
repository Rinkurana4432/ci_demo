
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
<form class="form-search" method="get" action="<?= base_url() ?>hrm/assign_assets_employees">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Employees Name,Assets Name,Model No,Assets Code" name="search" id="search" data-ctrl="hrm/assign_assets_employees?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
		<span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/assign_assets_employees?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>'" value="Reset">
         </span>
      </div>
   </div>
</form>	
</div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="col-md-12  export_div">
      <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AssignAssetsEmp">Assign Assets Employees</button>';
         } ?></div>
   </div>
   <div class="container">
      <!-- Nav tabs -->
	  
      <ul id="myTab" class="nav nav-tabs" role="tablist">
         <li role="presentation" class="" >
            <a href="#available" role="tab" data-toggle="tab" id="assign_assets" aria-expanded="false" onclick="submit_assigned_assets();">
            <i class="fa fa-list"></i> Assigned Assets
            </a>
         </li>
         <li role="presentation"  class="active">
		 <a href="#notavailable" role="tab" data-toggle="tab" id="return_assets" aria-expanded="true" onclick="submit_return_assets();">
            <i class="fa fa-list"></i> Return Assets
            </a>
         </li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel"  class="tab-pane fade " id="available" aria-labelledby="assign_assets">
		 <form id="assigned_assets_frm"><input type="hidden" value="assigned" name="tab"></form>
            <h2>Assigned Assets </h2>
            <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>ID
					 <span><a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=asc&tab=assigned" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=desc&tab=assigned" class="down"></a></span></th>
                     <th>Assign Employees
					 <span><a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=asc&tab=assigned" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=desc&tab=assigned" class="down"></a></span></th>
                     <th>Assign Assets</th>
                     <th>End Date</th>
                     <th>Return Date</th>
                     <th style="width:30px;">Action </th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($assigned_assets as $value): 
                     $ww1 =  getNameById('user_detail',$value['assign_id'],'u_id');
                     $assets1 = !empty($ww1)?$ww1->name:'';
                     ?>
                  <tr>
                     <td><?php echo $value['id']; ?></td>
                     <td><?php echo $assets1; ?></td>
                     <td>
                           <?php 
                              if($value['assets_products'] !=''){
                                      $products = json_decode($value['assets_products']);
                                      foreach($products as $product){
                              
                                          $ww =  getNameById('assets_list',$product->product_name,'id');
                                          $assets = !empty($ww)?$ww->ass_name:'';
                              
                                      } 
                                  } ?>
                      
                      <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewAssetsEmpdtl" data-tooltip="View" class="hrmTab"><?php echo $assets; ?></a></td>
                     <td><?php 
                        $end = $value['end_date']; 
                        $expire = strtotime($end);
                        $todaydate= date("m/d/Y");
                        $todate= strtotime($todaydate);
                        #echo $todate;
                        if($todate >= $expire){
                            echo "<span style='color:red'>".$value['end_date']."</span>";
                        } else {
                            echo $value['end_date'];
                        }
                        
                        #echo $value->end_date; ?></td>
                     <td><?php echo $value['back_date']; ?></td>
                     <td class="jsgrid-align-center action">
					   <i class='fa fa-cog'></i>
							<div class='on-hover-action'>
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="AssignAssetsEmp"  class="hrmTab btn btn-edit  btn-xs">Edit</a>
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ReturnAssetsEmp"  class="hrmTab btn btn-edit  btn-xs">Return</a>
						 <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewAssetsEmp"  class="hrmTab btn btn-edit  btn-xs">View</a>
                         </div>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
         <div role="tabpanel"  class="tab-pane fade active in" id="notavailable" aria-labelledby="return_assets">
		 <form id="return_assets_frm"><input type="hidden" value="return" name="tab"></form>
            <h2>Returned Assets</h2>
            <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>ID
					 <span><a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=asc&tab=return" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=desc&tab=return" class="down"></a></span></th>
                     <th>Assign Employees
					 <span><a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=asc&tab=return" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/assign_assets_employees?sort=desc&tab=return" class="down"></a></th>
                     <th>Assign Assets</th>
                     <th>End Date</th>
                     <th>Return Date</th>
                     <th>Action </th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($notassigned_assets as $value): 
                     $ww1 =  getNameById('user_detail',$value['assign_id'],'u_id');
                     $assets1 = !empty($ww1)?$ww1->name:'';
                     ?>
                  <tr>
                     <td><?php echo $value['id']; ?></td>
                     <td><?php echo $assets1; ?></td>
                     <td>
                       
                           <?php 
                              if($value['assets_products'] !=''){
                                      $products = json_decode($value['assets_products']);
                                      foreach($products as $product){
                              
                                          $ww =  getNameById('assets_list',$product->product_name,'id');
                                          $assets = !empty($ww)?$ww->ass_name:'';
                              
                                        
                                      } 
                                  } ?>
                    
                     <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewAssetsEmpdtl" data-tooltip="View" class="hrmTab"><?php echo $assets; ?></a></td>
                     <td><?php 
                        $end = $value['end_date']; 
                        $expire = strtotime($end);
                        $todaydate= date("m/d/Y");
                        $todate= strtotime($todaydate);
                        #echo $todate;
                        if($todate >= $expire){
                            echo "<span style='color:red'>".$value['end_date']."</span>";
                        } else {
                            echo $value['end_date'];
                        }
                        
                        #echo $value->end_date; ?></td>
                     <td><?php echo $value['back_date']; ?></td>
                     <td class="jsgrid-align-center ">
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewAssetsEmp" data-tooltip="View" class="hrmTab btn btn-edit  btn-xs"><i class="fa fa-eye"></i>  </a>
				<!--<a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ReturnAssetsEmp" data-tooltip="Return" class="hrmTab btn btn-edit  btn-xs"><i class="fa fa-exchange"></i>  </a>-->
                    </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
		
         </div>
		 	<?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
      </div>
   </div>
</div>
<div id="printThis">
   <div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Assets of Employees Update</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php #$this->load->view('backend/footer'); ?>