
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<style>
.disable {
   pointer-events: none;
   cursor: default;
}
</style>
<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
   <form class="form-search" method="get" action="<?= base_url() ?>hrm/travel_info">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Name, Travel From,Travel To,Travel Mode" name="search" id="search" data-ctrl="hrm/travel_info?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab']; ?>"/>
		<span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/travel_info?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>'" value="Reset">
         </span>
      </div>
   </div>
</form>	
</div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->u_id; ?>" id="loggedInUserId">

   <div class="col-md-12  export_div">
      <div class="col-md-4 col-sm-12 datePick-right"> <?php if($can_add) {
         echo '<button type="button" class="btn btn-primary hrmTab addBtn" data-toggle="modal" id="add" data-id="AddTavelInfo">Add TA/DA Infomation</button>';
         } ?></div>
   </div>
   <div class="container">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
         <li class="active">
            <a href="#available" id="pending_payment" role="tab" data-toggle="tab" onclick="submit_pending_payment();">
            <i class="fa fa-list"></i> Pending Payment 
            </a>
         </li>
         <li><a href="#notavailable" id="complete_payment" role="tab" data-toggle="tab" onclick="submit_complete_payment();">
            <i class="fa fa-list"></i> Complete Payment
            </a>
         </li>
      </ul>
      <div class="tab-content">
         <div class="tab-pane fade active in" id="available">
		 <form id="pending_payment_frm"><input type="hidden" value="pending" name="tab"></form>
            <h2>Pending TA/DA </h2>
            <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>ID
					<span><a href="<?php echo base_url(); ?>hrm/travel_info?sort=asc&tab=pending" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/travel_info?sort=desc&tab=pending" class="down"></a></span></th>
                     <th>Name
					 <span><a href="<?php echo base_url(); ?>hrm/travel_info?sort=asc&tab=pending" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/travel_info?sort=desc&tab=pending" class="down"></a></span></th>
                     <th>Travel Details</th>
                     <th>Approve Status</th>
                     <th>Paid Status</th>
                     <th>Created Date</th>
                     <th>Approved By</th>
                     <th style="width:30px;">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($unpaid_list as $value): 
                     $user_detail =  getNameById('user_detail',$value['created_by'],'u_id');
                     $user_name = !empty($user_detail)?$user_detail->name:'';
                     $validatedBy = ($value['approve_by']!=0)?(getNameById('user_detail',$value['approve_by'],'u_id')):''; 
                    $validatedByName = (!empty($validatedBy))?$validatedBy->name:'';
                     ?>
                  <tr>
                     <td class="travel_id"><?php echo $value['id']; ?></td>
                     <td><?php echo $user_name; ?></td>
                     <td>
                      
                           <?php 
                              if($value['travel_details'] !=''){
                                      $travel_details = json_decode($value['travel_details']);
                                      foreach($travel_details as $td){                                                           
                                         $td->travel_from;
                                      } 
                                  } ?>
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewTavelInfoDtl" data-tooltip="View" class="hrmTab"><?php echo $td->travel_from; ?></a>
                     </td>
				
             <?php     $disable=''; ?>
            <?php $disable = $can_edit?'':'disabled="disabled"'; ?>
            <?php $disable_radio =  $value['approve_status'] == '2' ?'':'disabled="disabled"'; ?>
            <td align="left" valign="middle">
            <input type="radio"  class='validate_status' <?php echo $disable; ?> <?php echo $disable_radio; ?>  name="approve_status_<?php echo $value['id']; ?>"  value="1" <?php echo ($value['approve_status']== '1')?  "checked" :""; ?>/> Approve
            <input type="radio"  <?php echo $disable; ?> <?php echo $disable_radio; ?>  name="approve_status_<?php echo $value['id']; ?>" class='validate_status'  value="0" <?php echo ($value['approve_status']== '0')?  "checked":""; ?>/> Disapprove
           </td>
                     <td><?php 
                        $paid_status = $value['paid_status']; 
                        if($paid_status == '0'){
                            echo "<span style='color:red'>UnPaid</span>";
                        } else {
                            echo "Paid";
                        }
						
						//pre($can_edit);
                        ?></td>
                        <td><?php echo date('d-m-Y',strtotime($value['created_date'])); ?></td>
                        <td>  <?php echo $validatedBy->name; ?> </td>
                     <td class="jsgrid-align-center action">
					   <i class='fa fa-cog'></i>
						<div class='on-hover-action'>
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewTavelInfo"  class="hrmTab btn btn-edit  btn-xs">View</a>
						 <?php if($value['approve_status']=='1'){ ?>
							<a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="PaidTavelExpenses"  class="hrmTab btn btn-edit  btn-xs <?php echo $can_edit?'':'disable' ?>">Pay</a>
						 <?php }else{ ?>
						        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="AddTavelInfo"  class="hrmTab btn btn-edit  btn-xs">Edit</a>
						 <?php } ?>
						  <a href="<?php base_url();?>delete_travel_info/<?php echo $value['id'];?>" class="btn btn-delete btn-xs" onClick="return confirm('Are you sure?')">Delete</a>
						 </div>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
         <div class="tab-pane fade" id="notavailable">
            <h2>Complete Payment</h2>
			<form id="complete_payment_frm"><input type="hidden" value="complete" name="tab"></form>
            <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>ID
					 <span><a href="<?php echo base_url(); ?>hrm/travel_info?sort=asc&tab=complete" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/travel_info?sort=desc&tab=complete" class="down"></a></span></th>
                     <th>Name
					 <span><a href="<?php echo base_url(); ?>hrm/travel_info?sort=asc&tab=complete" class="up"></a>
					<a href="<?php echo base_url(); ?>hrm/travel_info?sort=desc&tab=complete" class="down"></a></span></th>
                     <th>Travel Details</th>
                     <th>Approve Status</th>
                     <th>Paid Status</th>
                      <th>Created Date</th>
                     <th>Approved By</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($paid_list as $value): 
                     $user_detail =  getNameById('user_detail',$value['created_by'],'u_id');
                     $user_name = !empty($user_detail)?$user_detail->name:'';
                     ?>
                  <tr>
                     <td class="travel_id"><?php echo $value['id']; ?></td>
                     <td><?php echo $user_name; ?></td>
                     <td>
                       
                           <?php 
                              if($value['travel_details'] !=''){
                                      $travel_details = json_decode($value['travel_details']);
                                      foreach($travel_details as $td){
                                         $td->travel_from;
                                      } 
                                  } ?>
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewTavelInfoDtl" data-tooltip="View" class="hrmTab"><?php echo $td->travel_from; ?></a>
                     </td>
					 <?php     $disable=''; ?>
 <?php $disable = $can_edit?'':'disabled="disabled"'; ?>
            <td align="left" valign="middle">
            <input class='validate_status' <?php echo $disable; ?> name="approve_status_<?php echo $value['id']; ?>" type="radio"  value="1" <?php if($value['approve_status']=='1'){ echo "checked=checked";}  ?>/> Approve
            <input <?php echo $disable; ?> name="approve_status_<?php echo $value['id']; ?>" class='validate_status' type="radio"  value="0" <?php if($value['approve_status']=='0'){ echo "checked=checked";}  ?>/> Disapprove
          </td>
                     <td><?php 
                        $paid_status = $value['paid_status']; 
                        if($paid_status == '0'){
                            echo "<span style='color:red'>UnPaid</span>";
                        } else {
                            echo "Paid";
                        }
                        ?></td>
                        <td><?php echo date('d-m-Y',strtotime($value['created_date'])); ?></td>
                        <td><?php  
						$created_by = getNameById('user_detail',$value['approve_by'],'u_id');
                                $created_by = !empty($created_by)?$created_by->name:''; 
								echo $created_by; ?></td>
                     <td class="jsgrid-align-center action">
					    <i class='fa fa-cog'></i>
						<div class='on-hover-action'>
					 <?php if($value['approve_status'] != '1'){ ?>
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="AddTavelInfo" class="hrmTab btn btn-edit  btn-xs">Edit</a>
					 <?php } ?>
                        <a href="javascript:void(0)" id="<?php  echo $value['id'] ?>" data-id="ViewTavelInfo"  class="hrmTab btn btn-edit  btn-xs">View</a>
                       </div>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
	  <?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
   </div>
</div>
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reason</h4>
         </div>
         <div class="modal-body">
            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/disapprove_ta_da" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
               <input type="hidden" name="id" value=" " id="id">
               <input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
               <input type="hidden" id="disapprove" name="disapprove" value="0">
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
<div id="printThis">
   <div id="hrm_modal" class="modal fade in btnPrint"  role="dialog">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title chng_lbl nxt_cls" id="myModalLabel">Add TA/DA</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>
<?php #$this->load->view('backend/footer'); ?>
<script>

</script>