<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php } ?>
<div class="x_content">
   <div class="stik">
      <div class="col-md-12 ">
         <div class="col-md-6 datePick-right">
            <form action="<?php echo site_url(); ?>inventory/mrp" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
			    <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
            </form>
         </div>
      </div>
   </div>
<div class="col-md-12 col-xs-12 for-mobile">
   <div class="Filter Filter-btn2"> 
<form class="form-search" method="get" action="<?= base_url() ?>inventory/mrp">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter Id,Department" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="inventory/mrp">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
                    	<a href="<?php echo base_url(); ?>inventory/mrp"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
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
            <form action="<?php echo base_url(); ?>inventory/mrp" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
  </div>
   </div>
   </div>
   
   <div class="row hidde_cls ">
      <div class="col-md-12 export_div">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
             <?php //if($can_add) { 										
               echo '<button type="buttton" class="btn btn-info inventory_tabs addBtn" id="MrpReportAdd" data-toggle="modal" data-id="MrpReportAdd"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
               //}?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='work_order' id="table" data-msg="Work Order" data-path="production/work_order"/>
           
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            
         </div>
         
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <center id="messagee" style="color:green;"></center>
   <div id="print_div_content" class="table-responsive">
      <table style="margin-top:40px;" class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th scope="col">Id
    <span><a href="<?php echo base_url(); ?>inventory/mrp?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/mrp?sort=desc" class="down"></a></span></th>
               <th scope="col">Month
			   <span><a href="<?php echo base_url(); ?>inventory/mrp?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/mrp?sort=desc" class="down"></a></span></th>
               <th scope="col">Company Branch
			   <span><a href="<?php echo base_url(); ?>inventory/mrp?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/mrp?sort=desc" class="down"></a></span></th>
               <th scope="col">Department
			   <span><a href="<?php echo base_url(); ?>inventory/mrp?sort=asc" class="up"></a>
	<a href="<?php echo base_url(); ?>inventory/mrp?sort=desc" class="down"></a></span></th>
               <th scope="col">No of Materials</th>
               <th scope="col">Created By </th>
               <th scope="col">Created Date</th>
               <th scope="col" class='hidde'>Action</th>
              <!--  <th>Convert Into PI</th> -->
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($mrp_details)){
               foreach($mrp_details as $mrpdtl){
               $mrpdtls =  $mrpdtl['mrp_data'];
               $rtyui = json_decode($mrpdtls); 

				  $getUnitName = getNameById('company_address',$mrpdtl['company_branch'],'compny_branch_id');
				  $departmentData = getNameById('department',$mrpdtl['department_id'],'id');
				  	$createdByData = getNameById('user_detail',$mrpdtl['created_by'],'u_id');
                        	if(!empty($createdByData)){
                        		$createdByName = $createdByData->name;
                        	}else{
								$createdByName = '';
                        	}
               ?>
            <tr>
            
               <td data-label='Id:'><?php echo $mrpdtl['id']; ?></td>       
			   
               <td data-label='Month:'><?php echo date("F ,Y", strtotime($mrpdtl['month'])); ?></td>
               
               <td data-label='Company Branch:'><?php echo $getUnitName->company_unit; ?></td>
			   
               <td data-label='Departmnet:'><?php echo !empty($departmentData->name)?$departmentData->name:''; ?></td>
               
               <td data-label='No of Materials:'><?php echo count($rtyui); ?></td>
               
               <td data-label='Created By:'><?php echo $createdByName; ?></td>
               
               <td data-label='Created Date:'><?php echo date("j F , Y", strtotime($mrpdtl['created_date'])); ?></td>
               
               <td data-label='Action:'>
                  <button id="<?php echo $mrpdtl["id"]; ?>" data-id="edit_monthlymrp" data-tooltip="Edit" class="inventory_tabs btn btn-view  btn-xs" ><i class="fa fa-edit"></i></button>
                  <?php echo '<a href="javascript:void(0)" id="'.$mrpdtl['id'].'" data-id="view_monthlymrp" class="inventory_tabs btn btn-warning btn-xs" ><i class="fa fa-eye"></i></a>'; ?>
                   <button  data-tooltip="Convert into PI" class="btn  btn-xs  indent inventory_tabs_click" data-id="convert_to_pi_through_mrp"><img src="<?php echo base_url() ?>assets/modules/crm/uploads/convert.png"></button> 
                 <input type="hidden" name="jsondt" value='<?php echo  $mrpdtl['mrp_data']; ?>' class="row_selectd">
                 <input type="hidden" name="compnynme" value=" <?php echo $mrpdtl['company_branch'];?>">
                 <input type="hidden" name="department" value="<?php echo $mrpdtl['department_id']; ?>">
               </td>
               <!-- <td>
                
               </td> -->
               
            </tr>
            <?php $output[] = array(
												'id'=>$mrpdtl['id'],
												'month' => date("F ,Y", strtotime($mrpdtl['month'])),
												'Company Branch' =>$getUnitName->company_unit,
												'Department' => !empty($departmentData->name)?$departmentData->name:'',
												'No of materials'=>count($rtyui),
												'Created By'=>$createdByName,
												'Created Date'=>date("d-m-Y", strtotime($mrpdtl['created_date']))
											);	
										  }
										$data3  = $output;	
										export_csv_excel($data3);} ?>
         </tbody>
      </table>
	  <?php echo $this->pagination->create_links(); ?>
	  <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>
   </div>
</div>

<div id="" class="modal fade in inventory_add_modal"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">material Required Planning Filter</h4>
         </div>
         <div class="modal-body-content"></div>
		<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>
   </div>
</div>
<div id="inventory_add_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
   <div class="modal-dialog modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Material Required Planning Filter</h4>
         </div>
         <div class="modal-body-content">
           
         </div>
		<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>
   </div>
</div>