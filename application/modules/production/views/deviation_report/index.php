 
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php } ?>
<div class="x_content">
   <div class="stik">
      <div class="col-md-12 ">
         <div class="col-md-6 datePick-right">
            <form action="<?php echo site_url(); ?>production/deviation_report" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                <input type="hidden" value='<?php if($_GET['start'])echo $_GET['start'];?>' class='start_date' name='start'/>
     <input type="hidden" value='<?php if($_GET['end'])echo $_GET['end'];?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php if($_GET['search'])echo $_GET['search'];?>' name='search'/>
          </form>
         </div>
      </div>
   </div>
 <div class="col-md-12 col-xs-12 for-mobile">
 <div class="Filter Filter-btn2">
      <form class="form-search " method="post" action="<?= base_url() ?>production/deviation_report" >
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
				
<input type="text" class="form-control search-query" placeholder="Enter Id,Department" name="search" id="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="production/deviation_report">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
      <a href="<?php echo base_url(); ?>production/deviation_report"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
			</div>
			</form>	
	<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
     <div class="col-md-3 col-xs-12">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/sale_order_with_production"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>production/deviation_report" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
		</div>
 </div>
   <div class="row hidde_cls ">
      <div class="col-md-12 export_div">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='work_order' id="table" data-msg="Work Order" data-path="production/work_order"/>
            <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
          
         </div>
         <div class="col-md-3 col-xs-12 datePick-right">
            <?php //if($can_add) { 										
              // echo '<button type="buttton" class="btn btn-info productionTab addBtn" id="ProductionReportAdd" data-toggle="modal" data-id="ProductionReportAdd">Add</button>';
               //}?>
         </div>
      </div>
   </div>
</div>
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content" class="table-responsive"  style="margin-top: 58px;">
     
      <table class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th scope="col">Wages/Per piece<!--<span> <a href="<?php echo base_url(); ?>production/deviation_report?sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/deviation_report?sort=desc" class="down"></a></span> --></th>
               <th scope="col">Machine<!-- <span><a href="<?php echo base_url(); ?>production/deviation_report?sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/deviation_report?sort=desc" class="down"></a></span> --><span class="resize-handle"></span></th>
               <th scope="col">Work Order<!-- <span><a href="<?php echo base_url(); ?>production/deviation_report?sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/deviation_report?sort=desc" class="down"></a></span> --><span class="resize-handle"></span></th>
               <th scope="col">BOM Routing Product<!-- <span><a href="<?php echo base_url(); ?>production/deviation_report?sort=asc" class="up"></a><a href="<?php echo base_url(); ?>production/deviation_report?sort=desc" class="down"></a></span> --><span class="resize-handle"></span></th>
               <th scope="col">Assign Process <span class="resize-handle"></span></th>
               <th scope="col">Production Planning<span class="resize-handle"></span></th>
               <th scope="col">Production Output<span class="resize-handle"></span></th>
               <th scope="col">Estimated costing<span class="resize-handle"></span></th>
               <th scope="col">Actual Labour costing<span class="resize-handle"></span></th>
               <th scope="col">Remarks<span class="resize-handle"></span></th>
               <!-- <th scope="col" class='hidde'>Action<span class="resize-handle"></span></th>   -->
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($deviation_report)){
                foreach($deviation_report as $ProductionReport){
                    $productionWagesData = json_decode($ProductionReport['production_data']);  
                   
                    $production_planning = getNameById('production_planning',$ProductionReport['planning_id'],'id');
                    $machine_name_id = getNameById('add_machine',$productionWagesData[0]->machine_name_id[0],'id');
      				  $work_order = getNameById('work_order',$productionWagesData[0]->work_order[0],'id');
				        $job_card_product_id = getNameById('job_card',$productionWagesData[0]->job_card_product_id[0],'id');
                    $add_process = getNameById('add_process',$productionWagesData[0]->process_name[0],'id');
                        	if(!empty($createdByData)){
                        		$createdByName = $createdByData->name;
                        	}else{
								$createdByName = '';
                        	}
                  $machine_deteles=json_decode($job_card_product_id->machine_details);
                 $production_planning_data= json_decode($production_planning->planning_data);
                  //pre($production_planning_data[0]);
               ?>
            <tr>
               <td data-label="Id:"><?=$productionWagesData[0]->wages_or_per_piece[0];     ?></td>       
			   <td data-label="Month:"><?php echo $machine_name_id->machine_name; ?></td>
               <td data-label="Company Branch:"><?php echo $work_order->workorder_name; ?></td>
			   <td data-label="Departmnet:"><!-- <?php echo $job_card_product_id->job_card_no; ?> --> <?php  echo '<a href="javascript:void(0)" id="'. $ProductionReport["id"] . '"data-id="deviation_report_view" data-tooltip="Progess Gantt Chart of Work Order" class="productionTab btn btn-xs btn-edit">'.$job_card_product_id->job_card_no.'</a>';?></td>
             <td data-label="Departmnet:"><?php echo $add_process->process_name; ?></td>
                
               <td data-label="Product Qty:"><?php echo $production_planning_data[0]->output[0]; ?></td>
               <td data-label="Product Qty:"><?php echo $productionWagesData[0]->output[0]; ?></td>
               <td  data-label="Created By:"><?php echo $createdByName; ?></td>
               <td data-label="Created Date:"><?php echo $productionWagesData[0]->labour_costing[0] ; ?></td>
               <td data-label="Created Date:"><?php echo $productionWagesData[0]->remarks[0] ; ?></td>
              <!--  <td data-label='Action:' class='hidde acc-btn action'><i class='fa fa-cog' aria-hidden='true'></i><div class='on-hover-action'>
                    <button id="<?php echo $ProductionReport["id"]; ?>" data-id="ProductionReportAdd" data-tooltip="Edit" class="productionTab btn btn-view  btn-xs" ><i class="fa fa-edit"></i></button> 
                  <?php //echo  '<a href="javascript:void(0)" id="'.$ProductionReport['id'].'" data-id="ProductionMonthlyPlannedVsActualReportView" class="productionTab btn btn-warning btn-xs" > View </a>'; 
				  //echo  '<a href="javascript:void(0)" id="'. $ProductionReport["id"] . '"data-id="ProgessOfProduction" data-tooltip="Progess Gantt Chart of Work Order" class="productionTab btn btn-xs btn-edit">Progess of Work Order</a>'
				  
				  ?>
				  </div>
               </td> -->
            </tr>
            <?php $output[] = array(   
							'Id' =>$ProductionReport['id'],
							'Month'=>date("m-Y", strtotime($ProductionReport['month'])),
							'Company Unit' => $getUnitName->company_unit,
							'Department' =>$departmentData->name,
							'No. of workers'=>$ProductionReport['workorder_count'],
							'Created By'=>$createdByName,
							'Date'	=>date("d-m-Y", strtotime($ProductionReport['month'])),
									   );
									   }
						$target  = $output;
						export_csv_excel($target); } ?>
         </tbody>
      </table>
       <?php echo $this->pagination->create_links(); ?>	
	     <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
   </div>
</div>

<div id="" class="modal fade in production_modal"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Monthly Planning Va Actual Report</h4>
         </div>
         <div class="modal-body-content"></div>
		<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>
   </div>
</div>
<div id="production_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Monthly Planning Va Actual Report</h4>
         </div>
         <div class="modal-body-content"></div>
		<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>
   </div>
</div>