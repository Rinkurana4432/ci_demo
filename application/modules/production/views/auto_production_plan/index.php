<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
   <form action="<?php echo site_url(); ?>production/auto_production_plan" method="get" id="export-form">
      <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='<?php if(isset($_GET['start'])) echo $_GET['start'];?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php if(isset($_GET['end'])) echo $_GET['end'];?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php if(isset($_GET['favourites'])) echo $_GET['favourites'];?>' name='favourites'/>
   	   <input type="hidden" value='<?php echo $_GET['search']; ?>' name='search'/>
   </form>
   <div class="col-md-12 col-xs-12 for-mobile">
    <div class="Filter Filter-btn2">
	   <form class="form-search" method="get" action="<?= base_url() ?>production/auto_production_plan">
         <div class="col-md-6" style="width: 15%;">
            <div class="input-group">
               <span class="input-group-btn">
               <a href="<?php echo base_url(); ?>production/auto_production_plan"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </span>
            </div>
         </div>
      </form>
	   <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
		      <div class="col-md-2 col-sm-12 col-xs-12 datepicker">
            <!--fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/auto_production_plan"/>
                     </div>
                  </div>
               </div>
            </fieldset-->
            <form action="<?php echo base_url(); ?>production/auto_production_plan" method="get" id="date_range">	
               <!--input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/-->
               <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <select class="form-control col-md-7 col-xs-12 selectAjaxOption select2 compny_unit" name="company_branch_id" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
                     <option value="">Select Company Branch</option>
                  </select><br><br>
                  <select class="form-control  col-md-7 col-xs-12  selectAjaxOption select2 select2-hidden-accessible select2 department1" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = ''">
                   <option value="">Select Department</option>
                  </select><br><br> 
                  <select class="form-control  col-md-7 col-xs-12  selectAjaxOption select2 select2-hidden-accessible select2 shift1" name="shift_id"  tabindex="-1" aria-hidden="true" data-id="auto_production_plan" data-key="shift_name" data-fieldname="shift_name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?>">
                   <option value="">Select Shift</option>
                  </select><br><br>
                  <button type="submit" class="btn btn-warning">Filter</button>
                     </div>
                  </div>
               </div>
            </fieldset>
            </form>
         </div>
		 </div>
	</div>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
        
         <div class="btn-group"  role="group" aria-label="Basic example">
            <?php if($can_add){ echo '
               <a href="'.base_url().'production/auto_production_plan_edit" class="
                                             btn  btn-success indent addBtn"  data-href="" ><i class="fa fa-plus"></i>Add</a>'; }?>
           
         </div>
      </div>
   </div>
</div>
  <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	    
   <div id="print_div_content" style="margin-top: 58px;">
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>production/auto_production_plan">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <input type="hidden" id="visible_row" value=""/>
      <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th><input id="selecctall" type="checkbox"></th>
               <th scope="col">Id</th>
               <th scope="col">Date</th>
               <th scope="col">Company Branch<span class="resize-handle"></span></th>
               <th scope="col">Department<span class="resize-handle"></span></th>
               <th scope="col">Shift</th>
               <th scope="col">Created By<span class="resize-handle"></span></th>
               <th scope="col">Created Date<span class="resize-handle"></span></th>
               <th scope="col" class='hidde'>Action<span class="resize-handle"></span></th>
            </tr>
         </thead>
         <tbody class="prodplan">
            <?php 
               if(!empty($autoproductionPlan)){
               foreach($autoproductionPlan as $autoproduction_plan){      
                  $draftImage = ($autoproduction_plan['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';
                  $created_by = ($autoproduction_plan['created_by']!=0)?(getNameById('user_detail',$autoproduction_plan['created_by'],'u_id')->name):'';
                  $edited_by = ($autoproduction_plan['edited_by']!=0)?(getNameById('user_detail',$autoproduction_plan['edited_by'],'u_id')->name):'';
               ?>
            <tr>
               <td><?php echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$autoproduction_plan['id'].">";
                  if($autoproduction_plan['favourite_sts'] == '1'){
                  echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$autoproduction_plan['id']."  checked = 'checked'>";
                  echo"<input type='hidden' value='production_planning' id='favr' data-msg='Production Planning' data-path='production/production_planning' favour-sts='0' id-recd=".$autoproduction_plan['id'].">";
                  }else{
                  echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$autoproduction_plan['id'].">";
                  echo"<input type='hidden' value='production_planning' id='favr' data-msg='Production Planning' data-path='production/production_planning' favour-sts='1' id-recd =".$autoproduction_plan['id'].">";
                  }
                     ?></td>
               <td data-label="Id:"><?php echo $draftImage.$autoproduction_plan['id']; ?></td>
               <td data-label="Date:"><?php if( $autoproduction_plan['date'] !='' ){ echo date("j F , Y", strtotime($autoproduction_plan['date'])); }?> </td>
               <td>
               <?php
               $getUnitName = getNameById('company_address',$autoproduction_plan['company_branch'],'compny_branch_id');
               echo $getUnitName->company_unit;
               ?>
               </td>
               <td>
               <?php
               $departmentData = getNameById('department',$autoproduction_plan['department_id'],'id');
               echo $departmentData->name;
               ?>
               </td>
               <td data-label="Shift:"><?php
                  if(!empty($autoproduction_plan['shift_name'])){ echo $autoproduction_plan['shift_name']; } 
                  ?> 
               </td>
               <td data-label="Created By / Edited By:"><?php echo "<a href='".base_url()."users/edit/".$autoproduction_plan['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$autoproduction_plan["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
               <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($autoproduction_plan['created_date'])); ?></td>
               
              <td data-label='Action:' class='hidde acc-btn action'><i class='fa fa-cog' aria-hidden='true'></i><div class='on-hover-action'>
                  <?php //echo '<a href="'.base_url().'production/Add_SimilarProdPlan_edit?id='.$autoproduction_plan['id'].'" class="btn btn-delete btn-xs"  data-href="" >Clone Auto Production Plan</a>'; ?>
                  <?php
                     // if($can_edit){ 
                     // echo '<a href="'.base_url().'production/auto_production_plan_edit?id='.$autoproduction_plan['id'].'" class="btn btn-delete btn-xs"  data-href="" >Edit</a>';
                     // }
                     if($can_view){
                        echo '<button class="btn btn-view btn-xs productionTab" data-id="autoproductionPlanView" id="'.$autoproduction_plan["id"].'"  data-toggle="modal">View</button>';
                     }
                     // if($can_delete){
                     //    echo '<a href="javascript:void(0)" class="delete_listing
                     //       btn btn-delete btn-xs"   data-href="'.base_url().'production/deleteAutoProductionplan/'.$autoproduction_plan['id'].'" >Delete</a>';
                     // }
                     if($autoproduction_plan['save_status'] == 0){ 
                        echo '<a href="'.base_url().'production/auto_convert_to_production?id='.$autoproduction_plan['id'].'" class="
                                               btn btn-delete btn-xs" data-href="" disabled="true">Convert to Production Plan</a>';
                     } 
                     else{ 
                        echo '<a href="'.base_url().'production/auto_convert_to_production?id='.$autoproduction_plan['id'].'" class="
                                               btn btn-delete btn-xs"  data-href="">Convert to Production Plan</a>';
                     }
                     // if(!empty($autoproduction_plan["quality_check"]) == 0){
                     // echo '<a href="'.base_url().'production/auto_plan_qualitychk/'.$autoproduction_plan["id"].'" class="btn btn-xs btn-edit">Quality Check</i></a>';
                     //        }else{
                     // echo '<a href="javascript:void(0)" class=" btn btn-xs btn-edit">Quality Check Done</i></a>';
                     //        }
                     ?>
                </div>
               </td>
            </tr>
            <?php } $data3  = $output11;
               export_csv_excel($data3);  } ?>
         </tbody>
      </table>
      <?php echo $this->pagination->create_links(); ?>	
	    <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
   </div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title tabclass" id="myModalLabel">Production Planning</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>   