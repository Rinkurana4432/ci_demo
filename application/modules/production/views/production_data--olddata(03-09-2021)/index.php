
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }
   /*$str = 'Nzg1NTQ5Mjc3X0AjIUA=';
   $str = base64_decode($str);
       echo str_replace("_@#!@", "", $str);*/
   
   ?>
<div class="x_content">
   <form action="<?php echo site_url(); ?>production/production_data" method="get" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='<?php echo $_GET['start']; ?>'  class='start_date' name='start'/>
      <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
      <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
	   <input type="hidden" value='<?php echo $_GET['search']; ?>' name='search'/>
   </form>
   <?php # if(!empty($productionData)){ ?>
   <div class="col-md-12 col-xs-12 for-mobile">
    <div class="Filter Filter-btn2">
     <form class="form-search" method="post" action="<?= base_url() ?>production/production_data">
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter Id,Machine Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="production/production_data">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               <a href="<?php echo base_url(); ?>production/production_data"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
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
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/production_data"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>production/production_data" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
		 </div>
	</div>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
        
         <div class="btn-group"  role="group" aria-label="Basic example">
            <?php if($can_add) { 										
               echo '<a href="'.base_url().'production/production_data_edit" class="
                              btn  btn-success indent addBtn"  data-href=""><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
               }?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='production_data' id="table" data-msg="Production Data" data-path="production/production_data"/>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>production/production_data" method="get" >
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
   <div id="print_div_content" style="margin-top: 58px;" >
      <!---datatable-buttons--->
      
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>production/production_data">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <table id="" class="table table-striped table-bordered" border="1" cellpadding="3" style="width:100%;" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th><input id="selecctall" type="checkbox"></th>
               <th scope="col">Id
                  <span><a href="<?php echo base_url(); ?>production/production_data?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>production/production_data?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Date
                  <span><a href="<?php echo base_url(); ?>production/production_data?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>production/production_data?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Shift
                  <span><a href="<?php echo base_url(); ?>production/production_data?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>production/production_data?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Production Data</th>
               <th scope="col">Created By / Edited By</th>
               <th scope="col">Created Date</th>
               <th scope="col" class='hidde'>Action</th>
            </tr>
         </thead>
         <tbody class="prodData">
            <?php 
               if(!empty($productionData)){
               	foreach($productionData as $production_data){	
               		$draftImage = ($production_data['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';	
               		$shift = ''; 
               		if($production_data['shift']!=0 || $production_data['shift']!=''){							
               			$shiftData = getNameById(' production_setting',$production_data['shift'],'id');
               			$shift = !empty($shiftData)?$shiftData->shift_name:'';
               		}
               ?>
            <tr>
               <td><?php echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$production_data['id'].">";
                  if($production_data['favourite_sts'] == '1'){
                  		echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$production_data['id']."  checked = 'checked'>";
                  		echo"<input type='hidden' value='production_data' id='favr' data-msg='Job card' data-path='production/production_data' favour-sts='0' id-recd=".$production_data['id'].">";
                  }else{
                  		echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$production_data['id'].">";
                  		echo"<input type='hidden' value='production_data' id='favr' data-msg='job Card' data-path='production/production_data' favour-sts='1' id-recd =".$production_data['id'].">";
                  }
                  ?></td>
               <td  data-label="Id:" ><?php echo $draftImage.$production_data['id'];  ?></td>
               <td data-label="Date:" ><?php if($production_data['date'] != '') { echo date("j F , Y", strtotime($production_data['date'])); }?> </td>
               <td data-label="Shift:"><?php echo $shift;?> </td>
              
                  <!-- prodData -->
                  <div class="x_content">
                     <!------------ datatable-buttons ----------------->
                   
                           <?php
                              if($production_data['production_data'] != ''){
                              	$productionWagesData = json_decode($production_data['production_data']);
                              	$prodData_lengthCount = count($productionWagesData);
                              		$k=1;
                              		if(!empty($productionWagesData)){
                              			foreach($productionWagesData as $pwd){
                              				if(!empty($pwd)){
                              					$wagesLength = !empty($pwd->wages_or_per_piece)?(count($pwd->wages_or_per_piece)):0;
                              					for($i=0;$i<$wagesLength;$i++){
                              						
                              					
                              						$machine_id = isset($pwd->machine_name_id[$i])?$pwd->machine_name_id[$i]:'';
                              						
                              						
                            
							  $machine_id = isset($pwd->machine_name_id[$i])?$pwd->machine_name_id[$i]:'';
                              $machineData = ($machine_id!='' || $machine_id!=0)?getNameById('add_machine',$machine_id,'id'):array();
                              $output[] = array( 
                              'Id'=>$production_data['id'],
                              'Machine Name'=>((!empty($machineData))?($machineData->machine_name):''),
                              'BOM Routing'=>(!empty($jobCard))?($jobCard->job_card_product_name):'',
                              'wages_or_per_piece' =>$pwd->wages_or_per_piece[$i],
                              'Production Output'=>$pwd->output[$i],
                              'Labour Costing'=>$pwd->labour_costing[$i],
                              'Remarks'=>$pwd->remarks[$i]
                              );
                              }
                              }	 
                              }
                              }
                              }
                              
                            ?>
                      
                  </div>
			 <td data-label="Production Data:">	<a  href="javascript:void(0)"class="productionTab" data-id="productView" id=<?php echo $production_data["id"];?> data-toggle="modal" data-tooltip="View"><?php echo (!empty($machineData))?($machineData->machine_name):''; ?></td></a>
               <td data-label="Created By / Edited By:"><?php echo (($production_data['created_by']!=0)?(getNameById('user_detail',$production_data['created_by'],'u_id')->name):'').'<br>'.(($production_data['edited_by']!=0)?(getNameById('user_detail',$production_data['edited_by'],'u_id')->name):''); ?></td>
               <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($production_data['created_date'])); ?></td>
               <!--<td><button id="</?php echo $production_data['id']; ?>" data-id="AddSimilarProdData" data-tooltip="Add Similar Data" class="btn btn-xs productionTab add-machine"><i class="fa fa-plus"></i></button></td>-->
               <td data-label="Action:" class='hidde'>
                  <?php echo '<a href="'.base_url().'production/Add_SimilarProdData_edit?id='.$production_data['id'].'" class="
                     btn btn-delete btn-xs" data-tooltip="Add Similar Production Data" data-href="" ><i class="fa fa-plus"></i></a>'; ?>
                  <?php if($can_edit) 
                     echo '<a href="'.base_url().'production/production_data_edit?id='.$production_data['id'].'" class="
                                 btn btn-delete btn-xs" data-tooltip="Edit" data-href="" ><i class="fa fa-pencil"></i></a>';
                     
                        // echo '<button  id="'.$production_data['id'].'" data-id="productEdit" class="btn btn-edit btn-xs productionTab" data-toggle="modal" data-tooltip="Edit"><i class="fa fa-pencil"></i></button>';
                        if($can_delete) 
                        	echo '<a href="javascript:void(0)" class="delete_listing
                        		   btn btn-delete btn-xs" data-tooltip="Delete" data-href="'.base_url().'production/production_data_delete/'.$production_data['id'].'" ><i class="fa fa-trash" ></i></a>';
                        if($can_view) 
                        	echo '<button class="btn btn-view btn-xs productionTab" data-id="productView" id="'.$production_data["id"].'" data-toggle="modal" data-tooltip="View"><i class="fa fa-eye"></i></button>';
                        ?>
               </td>
            </tr>
            <?php
               }
               $data3  = $output;
               export_csv_excel($data3); } ?>
         </tbody>
      </table>
      <?php echo $this->pagination->create_links(); ?>	
	    <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
   </div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content ">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Production Data</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>