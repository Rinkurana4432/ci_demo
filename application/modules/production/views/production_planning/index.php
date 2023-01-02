
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
   <form action="<?php echo site_url(); ?>production/production_planning" method="get" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='<?php if(isset($_GET['start'])) echo $_GET['start'];?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php if(isset($_GET['end'])) echo $_GET['end'];?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php if(isset($_GET['favourites'])) echo $_GET['favourites'];?>' name='favourites'/>
   	   <input type="hidden" value='<?php echo $_GET['search']; ?>' name='search'/>
   </form>
   <?php  # if(!empty($productionPlan)){ ?>
   <div class="col-md-12 col-xs-12 for-mobile">
    <div class="Filter Filter-btn2">
	   <form class="form-search" method="get" action="<?= base_url() ?>production/production_planning">
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter id,Supervisior Name,Machine Name" name="search" id="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" data-ctrl="production/production_planning">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               <a href="<?php echo base_url(); ?>production/production_planning"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </span>
            </div>
         </div>
      </form>
	   <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
		      <div class="col-md-2 col-sm-12 col-xs-12 datepicker">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/production_planning"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>production/production_planning" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
		 </div>
	</div>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
        
         <div class="btn-group"  role="group" aria-label="Basic example">
            <?php if($can_add){ echo '
               <a href="'.base_url().'production/production_planning_edit" class="
                                             btn  btn-success indent addBtn"  data-href="" ><i class="fa fa-plus"></i>Add</a>'; }?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='production_planning' id="table" data-msg="Production Planning" data-path="production/production_planning"/>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>production/production_planning" method="get" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
               <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
         </div>
      </div>
   </div>
</div>
   <?php # } ?>		
   <p class="text-muted font-13 m-b-30"></p>
   <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	    
   <div id="print_div_content" style="margin-top: 58px;">
      <!---datatable-buttons--->
      
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>production/production_planning">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <input type="hidden" id="visible_row" value=""/>
      <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th><input id="selecctall" type="checkbox"></th>
               <th scope="col">Id
                  <span><a href="<?php echo base_url(); ?>production/production_planning?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>production/production_planning?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Date
                  <span><a href="<?php echo base_url(); ?>production/production_planning?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>production/production_planning?sort=desc" class="down"></a></span><span class="resize-handle"></span>
               </th>
               <th scope="col">Shift
                  <span><a href="<?php echo base_url(); ?>production/production_planning?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>production/production_planning?sort=desc" class="down"></a></span><span class="resize-handle"></span>
               </th>
               <th scope="col">Supervisor Name<span class="resize-handle"></span></th>
               <th scope="col">Production Planning<span class="resize-handle"></span></th>
               <th scope="col">Created By / Edited By<span class="resize-handle"></span></th>
               <th scope="col">Created Date<span class="resize-handle"></span></th>
               <th scope="col" class='hidde'>Action<span class="resize-handle"></span></th>
            </tr>
         </thead>
         <tbody class="prodplan">
            <?php 
               if(!empty($productionPlan)){
               foreach($productionPlan as $production_plan){		
               	$draftImage = ($production_plan['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';
               	$created_by = ($production_plan['created_by']!=0)?(getNameById('user_detail',$production_plan['created_by'],'u_id')->name):'';
               	$edited_by = ($production_plan['edited_by']!=0)?(getNameById('user_detail',$production_plan['edited_by'],'u_id')->name):'';
               ?>
            <tr>
               <td><?php echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$production_plan['id'].">";
                  if($production_plan['favourite_sts'] == '1'){
                  					   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$production_plan['id']."  checked = 'checked'>";
                  					   				echo"<input type='hidden' value='production_planning' id='favr' data-msg='Production Planning' data-path='production/production_planning' favour-sts='0' id-recd=".$production_plan['id'].">";
                  					   		}else{
                  									echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$production_plan['id'].">";
                  									echo"<input type='hidden' value='production_planning' id='favr' data-msg='Production Planning' data-path='production/production_planning' favour-sts='1' id-recd =".$production_plan['id'].">";
                  					   		}
                  	?></td>
               <td data-label="Id:"><?php echo $draftImage.$production_plan['id']; ?></td>
               <td data-label="Date:"><?php if( $production_plan['date'] !='' ){ echo date("j F , Y", strtotime($production_plan['date'])); }?> </td>
               <td data-label="Shift:"><?php
                  //$shiftname = getNameById('production_setting',$production_plan['shift'],'id');
                  if(!empty($production_plan['shift_name'])){ echo $production_plan['shift_name']; } 
                  ?> 
               </td>
               <td data-label="Supervisor Name:"><?php if(!empty($production_plan)){echo $production_plan['supervisor_name'];}?> </td>
              
                     <?php 
                        $productionPlanning=json_decode($production_plan['planning_data']);	
                        $prodPlan_lengthCount = count($productionPlanning);
                        //pre($prodPlan_lengthCount);
                       
                        foreach($productionPlanning as $production_planning){
                        	
                        		
                        	$countMachineId  = !empty($production_planning->machine_name_id)?(count($production_planning->machine_name_id)):0;
                        	
                        	for($i=0;$i<$countMachineId;$i++){
                        	
                        		
                        	$machine_id = isset($production_planning->machine_name_id[$i])?$production_planning->machine_name_id[$i]:'';
                        	$machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
                       
								$jobCard = isset($production_planning->job_card_product_id[$i])?getNameById('job_card',$production_planning->job_card_product_id[$i],'id'):array(); 
                        	}
                        
                        	$output11[] = array(
							   'Id'=>$production_plan['id'],
                        	   'Date' => $production_plan['date'],
                        	   'Shift' =>$shiftname->shift_name,
                        	   'Supervisor Name'=>$production_plan['supervisor_name'],
							   'Machine Name'=>((!empty($machineData))?($machineData->machine_name):''),
							   'Bom Routing No.'=>((!empty($jobCard))?($jobCard->job_card_no):''),
                        	   'Worker' =>$Workername->name,
							   'Created Date'=>date("d-m-Y", strtotime($production_plan['created_date']))
                        	   );
                        }
                        
                        	 
                        ?>
                  
                
              <td data-label="Production Planning:">  
					<a href="#" class="productionTab" data-id="productionPlanViewmachineview" id=<?php echo $production_plan["id"];?> data-tooltip="View" data-toggle="modal">
					<?php echo ((!empty($machineData))?($machineData->machine_name):''); ?>
					</a>
			   </td>
               <td data-label="Created By / Edited By:"><?php echo "<a href='".base_url()."users/edit/".$production_plan['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$production_plan["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
               <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($production_plan['created_date'])); ?></td>
               
              <td data-label='Action:' class='hidde acc-btn action'><i class='fa fa-cog' aria-hidden='true'></i><div class='on-hover-action'>
                  <?php echo '<a href="'.base_url().'production/Add_SimilarProdPlan_edit?id='.$production_plan['id'].'" class="
                     btn btn-delete btn-xs"  data-href="" >Clone Production Planing</a>'; ?>
                  <?php
                     if($can_edit){ 
                     	echo '<a href="'.base_url().'production/production_planning_edit?id='.$production_plan['id'].'" class="
                                               btn btn-delete btn-xs"  data-href="" >Edit</a>';
                     }
                     if($can_view){
                     	echo '<button class="btn btn-view btn-xs productionTab" data-id="productionPlanView" id="'.$production_plan["id"].'"  data-toggle="modal">View</button>';
                     }
                     if($can_delete){
                     	echo '<a href="javascript:void(0)" class="delete_listing
                     		btn btn-delete btn-xs"   data-href="'.base_url().'production/deleteProductionplanning/'.$production_plan['id'].'" >Delete</a>';
                     }
                     if($production_plan['save_status'] == 0){ 
                     
                     	// <a href="'.base_url().'production/production_planning_edit?id='.$production_plan['id'].'" class="
                      //                          btn btn-delete btn-xs" data-tooltip="Edit" data-href="" ><img src='".base_url()."assets/modules/crm/uploads/convert.png'></button></a>
                     
                     	echo '<a href="'.base_url().'production/convert_to_production?id='.$production_plan['id'].'" class="
                                               btn btn-delete btn-xs" data-href="" disabled="true">Convert to Production Data</a>';
                     } 
                     else{ 
                     	echo '<a href="'.base_url().'production/convert_to_production?id='.$production_plan['id'].'" class="
                                               btn btn-delete btn-xs"  data-href="">Convert to Production Data</a>';
                     }
                     if(!empty($production_plan["quality_check"]) == 0){
                     echo '<a href="'.base_url().'production/plan_quality_chk/'.$production_plan["id"].'" class="btn btn-xs btn-edit">Quality Check</i></a>';
                     		 }else{
                     echo '<a href="javascript:void(0)" class=" btn btn-xs btn-edit">Quality Check Done</i></a>';
                     		 }
                     
                     
                     ?>
					 </div>
               </td>
            </tr>
            <?php } $data3  = $output11;
               export_csv_excel($data3);	} ?>
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