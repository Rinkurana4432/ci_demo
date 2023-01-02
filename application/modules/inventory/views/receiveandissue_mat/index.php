<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php } 
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;




?>
<div class="x_content">
  <div class="col-md-12 col-xs-12 for-mobile">
	   <div class="Filter Filter-btn2">
	      <div class="col-md-2 col-xs-12 col-sm-6 datePick-right">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/receiveandissue_report"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>inventory/receiveandissue_report" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
	   </div>
  </div>
   <div class="stik">
      <div class="col-md-12 ">
         <div class="col-md-6 datePick-right">
            <form action="<?php echo site_url(); ?>inventory/receiveandissue_report" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType'/>
               <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
            </form>
         </div>
      </div>
   </div>
   	<form class="form-search" method="post" action="<?= base_url() ?>inventory/receiveandissue_report" id="mattype_frm">
			<!--div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter Id,Department" name="search" id="search" value="<?php //if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="inventory/receiveandissue_report">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
                    	<a href="<?php //echo base_url(); ?>inventory/receiveandissue_report"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
			</div-->
			<select class="form-control selectAjaxOption select2 select2-hidden-accessible  get_mat_IDD" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" >
				<option value="">Select Option</option>
			</select>
	</form>	
   <div class="row hidde_cls ">
      <div class="col-md-12 export_div">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
            
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
         <div class="col-md-3 col-xs-12 datePick-right">
           
         </div>
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <center id="messagee" style="color:green;"></center>
   <div id="print_div_content" class="table-responsive">
      <table class="table table-striped  table-bordered user_index" data-id="user" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
		      <?php 
			    
				 if(!empty($_POST)){
					  $mat_type_name = getNameById('material_type',$_POST['material_type_id'],'id');
					  echo '<center><b>'.$mat_type_name->name.' Report</b></center> <br/>';
				 }
			 ?>
            <tr>
               <th>S.no</th>
               <th>Materail Name</th>
               <th>Opening Stock</th>
               <th>Recevied</th>
               <th>Issued</th>
               <th>Closing Stock</th>
            </tr>
         </thead>
         <tbody>
		 <?php
		 if(!empty($get_report_data)){
			 $sno=1;
			foreach($get_report_data as $mat_val){
				 // $mat_type_name = getNameById('material_type',$mat_val['material_type_id'],'id');
				
				$material_name = getNameById('material',$mat_val['material_id'],'id');
				//pre($mat_val);
				if($mat_val['opening_blnc'] == '' || $mat_val['opening_blnc'] == 0){
					$opening_balance = 0;
				}else{
					$opening_balance = $mat_val['opening_blnc'];
				}
				
				if($mat_val['material_in'] == '' || $mat_val['material_in'] == 0){
					$material_in = 0;
				}else{
					$material_in = $mat_val['material_in'];
				}
				if($mat_val['material_out'] == '' || $mat_val['material_out'] == 0){
					$material_out = 0;
				}else{
					$material_out = $mat_val['material_out'];
				}
				
				if($mat_val['closing_blnc'] == '' || $mat_val['closing_blnc'] == 0){
					$closing_blnc = 0;
				}else{
					$closing_blnc = $mat_val['closing_blnc'];
				}
				echo '<tr>';
				echo '<td>'.$sno.'</td>';
				echo '<td>'.$material_name->material_name.'</td>';
				echo '<td>'.$opening_balance.'</td>';
				echo '<td>'.$material_in.'</td>';
				echo '<td>'.$material_out.'</td>';
				echo '<td>'.$closing_blnc.'</td>';
				
				echo '</tr>';
				
			$sno++;	
			}	

		 }else{
			echo '<tr><td colspan=6>No Report Avilable</td></tr>'; 
		 }
		 ?>
		    
            
         </tbody>
      </table>
   </div>
</div>

