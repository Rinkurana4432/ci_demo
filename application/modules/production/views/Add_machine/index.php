
<?php if($this->session->flashdata('message') != ''){?>
<div class="alert alert-success col-md-6">
   <?php echo $this->session->flashdata('message');?>
</div>
<?php }?>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="post" action="<?= base_url() ?>production/Add_machine">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,Machine Name,Machine Code" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="production/Add_machine">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>production/Add_machine"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
         <?php /*
         <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         */ ?>
         <div id="demo" class="collapse">
            <div class="col-md-2 col-xs-12 col-sm-12 datepicker">
               <fieldset>
                  <div class="control-group">
                     <div class="controls">
                        <div class="input-prepend input-group">
                           <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/add_machine"/>
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?php echo base_url(); ?>production/add_machine" method="GET" id="date_range">
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
               </form>
            </div>
         </div>
      </div>
      <div class="row hidde_cls export_div">
         <div class="col-md-12">
            <div class="btn-group"  role="group" aria-label="Basic example">
               <?php if($can_add){ echo '<button class="btn  btn-success  productionTab addBtn" data-toggle="modal" id="add1" data-id="machineEdit"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>'; }?>
               <?php /*
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
               */ ?>
               <input type="hidden" value='add_machine' id="table" data-msg="Machine" data-path="production/Add_machine"/>
               <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                  <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="export-menu">
                     <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                     <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  </ul>
               </div>
               <?php /*
               <form action="<?php echo base_url(); ?>production/add_machine" method="get" >
                  <input type="hidden" value='1' name='favourites'/>
                  <input type="hidden" value='' class='start' name='start'/>
                  <input type="hidden" value='' class='end' name='end'/>
                  <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
               </form>
               */ ?>
            </div>
            <div class="col-md-3 col-xs-12 col-md-12 datePick-right">
               <?php //if($can_add){ echo '<button class="btn btn-primary productionTab addBtn" data-toggle="modal" id="add1" data-id="machineEditNew">Add New</button>'; }?>
               <form action="<?php echo site_url(); ?>production/add_machine" method="get" id="export-form">
                  <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                  <input type="hidden" value='<?php echo $_GET['start']; ?>' class='start_date' name='start'/>
                  <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
                  <input type="hidden" value='<?php echo $_GET['favourites'];?>' name='favourites'/>
                  <input type="hidden" value='<?php echo $_GET['search'];?>' name='search'/>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div id="myTabContent">
      <p class="text-muted font-13 m-b-30"></p>
      <div id="print_div_content" class="table-responsive" style="margin-top: 58px;">
         <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>production/Add_machine">
            <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
         </form>
         <!------------------ datatable-buttons -------------->
         <table id="" class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
            <thead>
               <tr>
                  <th><input id="selecctall" type="checkbox"></th>
                  <th scope="col">Id
                     <span><a href="<?php echo base_url(); ?>production/Add_machine?sort=asc" class="up"></a>
                     <a href="<?php echo base_url(); ?>production/Add_machine?sort=desc" class="down"></a></span>
                  </th>
                  <th scope="col">Work station Name
                     <span><a href="<?php echo base_url(); ?>production/Add_machine?sort=asc" class="up"></a>
                     <a href="<?php echo base_url(); ?>production/Add_machine?sort=desc" class="down"></a></span>
                  </th>
                  <th scope="col">Work station Code
                     <span><a href="<?php echo base_url(); ?>production/Add_machine?sort=asc" class="up"></a>
                     <a href="<?php echo base_url(); ?>production/Add_machine?sort=desc" class="down"></a></span>
                  </th>
                  <th scope="col">Preventive Maintenance</th>
                  <th scope="col">Machine Parameter</th>
                  <th scope="col">Processes Name</th>
                  <th scope="col">Make & Model</th>
                  <th scope="col">Date of Purchase</th>
                  <th scope="col">Placement</th>
                  <th scope="col">Created By / Edited By</th>
                  <th scope="col">Created Date</th>
                  <th scope="col" class='hidde'>Action</th>
               </tr>
               </tr>
            </thead>
            <tbody>
               <?php  if(!empty($AddMachine)){
                  foreach($AddMachine as $addMachine){
                  $draftImage = ($addMachine['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';
                  $created_by = ($addMachine['created_by']!=0)?(getNameById('user_detail',$addMachine['created_by'],'u_id')->name):'';
                  $edited_by = ($addMachine['edited_by']!=0)?(getNameById('user_detail',$addMachine['edited_by'],'u_id')->name):'';
                  ?>
               <tr>
                  <td><?php if($addMachine["used_status"]==0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$addMachine['id'].">";}
                     //else{echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$supplier['id'].">";}

                     if($addMachine['favourite_sts'] == '1'){
                     	   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$addMachine['id']."  checked = 'checked'>";
                     	   				echo"<input type='hidden' value='add_machine' id='favr' data-msg='Machine' data-path='production/add_machine' favour-sts='0' id-recd=".$addMachine['id'].">";
                     	   		}else{
                     					echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$addMachine['id'].">";
                     					echo"<input type='hidden' value='add_machine' id='favr' data-msg='Machine' data-path='production/add_machine' favour-sts='1' id-recd =".$addMachine['id'].">";
                     	   		}
                     ?></td>
                  <td data-label="Id:"><?php echo $draftImage.$addMachine['id']; ?></td>
                  <!--<td><?php //echo $addMachine['machine_name']; ?></td>-->
                  <td data-label="Machine Name:"><a href="javascript:void(0)" id="<?php echo $addMachine['id']; ?>" data-id="machineView" class="productionTab"><?php echo $addMachine['machine_name']; ?></td>
                  <td data-label="Machine Code:"><?php echo $addMachine['machine_code']; ?></td>
                  <td data-label="Preventive Maintenance:"><?php echo $addMachine['preventive_maintenance']; ?></td>
				  <?php
						   $machineParameter = JSON_decode($addMachine['machine_parameter']);

                           if(!empty($machineParameter)){
                           $i=1;
                           foreach($machineParameter as $Machine_parameter){
                           $ww =  getNameById('uom', $Machine_parameter->uom,'id');
                           $uom = !empty($ww)?$ww->ugc_code:'';
                           }
                        }
				  ?>

                  <td data-label="Machine Parameter:"><a href="javascript:void(0);" class='productionTab' id="<?php echo $addMachine['id'];?>" data-id='machineViewmat'><?php echo $Machine_parameter->machine_parameter; ?> </td>
				  <?php
					 $ProcessData=json_decode($addMachine['process']);
                              if(!empty($ProcessData)){
                               foreach($ProcessData as $pd){
								    $processTypeData = ($pd->process_type!='')?(getNameById('process_type',$pd->process_type,'id')):'';
									 $processData = ($pd->process!='')?(getNameById('add_process',$pd->process,'id')):'';

						 }
					}
				  ?>
                  <td data-label="Processes Name:"><a href="javascript:void(0);" class='productionTab' id="<?php echo $addMachine['id'];?>" data-id='machineViewmat'><?php if(!empty($processTypeData)){echo $processTypeData->process_type; } ?></a></td>
                  <td data-label="Make & Model:"><?php echo $addMachine['make_model']; ?></td>
                  <td data-label="Date of Purchase:"><?php echo date("j F , Y", strtotime($addMachine['year_purchase'])); ?></td>
                  <td data-label="Placement:"><?php echo $addMachine['placement']; ?></td>
                  <td data-label="Created By / Edited By:"><?php echo "<a href='".base_url()."users/edit/".$addMachine['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$addMachine["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
                  <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($addMachine['created_date'])); ?></td>
                  <td data-label="Action:" class='hidde'>
                     <button id="<?php echo $addMachine['id']; ?>" data-id="AddSimilar" data-tooltip="Add Similar Machine" class="btn btn-xs productionTab add-machine"> <i class="fa fa-clone" aria-hidden="true"></i></button>
                     <?php if($can_edit) {
                        echo '<button id="'.$addMachine['id'].'" data-id="machineEdit" data-tooltip="Edit" class="btn btn-edit btn-xs productionTab" data-toggle="modal"><i class="fa fa-pencil"></i></button>';
                        }
                        if($can_view){
                        echo '<button id="'.$addMachine['id'].'" data-tooltip="View" class="btn btn-view btn-xs productionTab" data-id="machineView"><i class="fa fa-eye"></i></button>';
                        //echo '<button id="'.$addMachine['id'].'" data-tooltip="View" class="btn btn-view btn-xs productionTab" data-id="machineViewNew">View New</button>';
                        }
                        if($can_delete){
                        	if($addMachine['used_status'] == 1){
                        		echo '<a href="javascript:void(0)" data-tooltip="Delete" class="
                                           btn btn-delete btn-xs" data-href="'.base_url().'production/deleteAddMachine/'.$addMachine['id'].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
                        	}else{
                        		echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                                           btn btn-delete btn-xs" data-href="'.base_url().'production/deleteAddMachine/'.$addMachine['id'].'"><i class="fa fa-trash"></i></a>';
                        	}
                        }
                        ?>
                  </td>
               </tr>
               <?php
			  if ($machineParameter) {
            $machine_parameter = $process_name = array();
                  foreach($machineParameter as $Machine_parameter){
    				$ProcessData=json_decode($addMachine['process']);
                    foreach($ProcessData as $pd){
    				$processData = ($pd->process!='')?(getNameById('add_process',$pd->process,'id')):'';
               $machine_parameter[] = $Machine_parameter->machine_parameter;
               $process_name[] = $processData->process_name;
    				
    			  }
    			  } 
               @$output[] = array(
                         'Machine ID' => $addMachine['id'],
                         'Work Station Name' => $addMachine['machine_name'],
                         'Work Station Code' => $addMachine['machine_code'],
                         'Preventive Maintenance' => $addMachine['preventive_maintenance'],
                         'Machine Parameter' =>implode(", ", array_values(array_unique($machine_parameter))),
                         //'Machine UOM' =>  $uom,
                         'Processes Name' =>implode(", ", array_values(array_unique($process_name))),
                         'Make & Model' => $addMachine['make_model'],
                         'Date of Purchase' => $addMachine['year_purchase'],
                         'Placement' => $addMachine['placement'],
                         'Created Date' => date("d-m-Y",strtotime($addMachine['created_date'])),
                      ); 
              }

				 }
                  $data3  = $output;
                  export_csv_excel($data3);
                  }
               ?>
            </tbody>
         </table>
         <?php echo $this->pagination->create_links(); ?>
		  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;"><span class="Dj"><span><span class="ts">1</span>–<span class="ts">10</span></span> of <span class="ts">60</span></span></div>
      </div>
   </div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Machine Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
