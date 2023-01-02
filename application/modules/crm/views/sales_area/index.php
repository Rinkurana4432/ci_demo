 
<div class="x_content">
<span id="alertMsg"></span>
   <?php
   
      if($this->session->flashdata('message') != ''){
      		echo '<div class="alert alert-info alertMsg">'.$this->session->flashdata('message').'</div>';
      	}
      ?>
	  <div class="mesg col-md-6"></div>
   <div class="stik">			</div>
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="post" action="<?= base_url() ?>crm/add_sales_area">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,Sales Area" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="crm/add_sales_area">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>	
                  <a href="<?php echo base_url(); ?>crm/add_sales_area"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/add_sales_area">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
         </form>
      </div>
   </div>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         <div class="col-md-3 datePick-right">
            <button type="button" class="btn btn-success add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="add_sales_area"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>
         </div>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!---------- datatable-buttons ------------->
      <table id="" class="table table-striped table-bordered account_index" style="width:100%;margin-top: 44px;" data-id="account">
         <thead>
            <tr>
               <th scope="col">Id
                  <span><a href="<?php echo base_url(); ?>crm/add_sales_area?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>crm/add_sales_area?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Area Name</th>
               <th scope="col">Created by</th>
               <th scope="col">Created Date</th>
               <th scope="col">Action</th>
            </tr>
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($sales_area_data)){
               foreach($sales_area_data as $industrydata){		
               
               $statusChecked = $industrydata['active_inactive']==1?'checked':'';
               //$statusChecked = "";			
               $action = '';
               				$createdBYY =  getNameById('user_detail', $industrydata['created_by_cid'],'c_id');
               				$crtd_by_name = !empty($createdBYY)?$createdBYY->name:'Others';	
               				$action = '<input type="checkbox" class="js-switch change_status_sales_area"  data-switchery="true" style="display: none;" value="'.$industrydata['active_inactive'].'" 
               				data-value="'.$industrydata['id'].'"  '.$statusChecked .'>';
               				$action .= '<a href="javascript:void(0)" id="'.$industrydata['id'].'" data-id="add_sales_area"  class="add_crm_tabs btn btn-edit  btn-xs">Edit</a>';	
               			
               
               	//$action .= '<button type="button" data-process-id="'.$customer_Type["id"].'" id="'.$customer_Type["id"].'" data-id="customer_Type" class="btn btn-primary add_crm_tabs" data-toggle="modal">Edit</button>';
               
               
               /*if($process_Type['used_status'] == 1){
               	$action = $action.'<a href="javascript:void(0)" class="
               	btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
               }else{
               	$action = $action.'<a href="javascript:void(0)" class="delete_listing
               	btn btn-danger" data-href="'.base_url().'production/deleteProcessType/'.$process_Type["id"].'" ><i class="fa fa-trash"></i></a>';
               }*/
               
               echo "<tr>
               <td data-label='Id:'>".$industrydata['id']."</td>
               <td data-label='Industry Name:'>".$industrydata['sales_area']."</td>
               <td data-label='Created by:'>".$crtd_by_name."</td>
               <td data-label='Created Date:'>".date('d-m-Y',strTotime($industrydata['modified_date']))."</td>
               <td data-label='Action:' class='hidde action'><i class='fa fa-cog'></i><div class='on-hover-action'>".$action."</div></td>	
               </tr>";
               }
               } ?>
         </tbody>
      </table>
      <?php echo $this->pagination->create_links(); ?>
   </div>
</div>
<div id="crm_add_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Sales Area</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
