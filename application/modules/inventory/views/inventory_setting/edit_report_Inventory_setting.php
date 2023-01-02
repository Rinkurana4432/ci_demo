<?php
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveinventoryreportsetting" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">		
    <div class="x_panel">
      <div class="x_title">
         <div class="clearfix"></div>
      </div>
	  <input type="hidden" name="id" value="<?php if(!empty($report_data)) echo $report_data->id; ?>">
      <div class="x_content">
         <div class="col-md-12 ">
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Report Name<span class="required">*</span></label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input  required="required"  type="text" name="report_name" class="form-control Selectedmonth" value="<?php  if(!empty($report_data)){ echo $report_data->report_name; } ?>"/>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">Material Type</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible materialTypeId" required="required" name="material_type_id" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0"  id="material_type" onchange="ChangePrefix_and_subType();">
                        <option value="">Select Option</option>
                        <?php if(!empty($report_data)){
                           $material_type_id = getNameById('material_type',$report_data->material_type_id,'id');
						  
                           echo '<option value="'.$material_type_id->id.'" material_type_prefix="'.$material_type_id->prefix.'" selected >'.$material_type_id->name.'</option>';
                           }?>
                     </select>
                  </div>
               </div>
			    <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">Email To</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <select multiple class="itemName form-control selectAjaxOption select2 select2-hidden-accessible"   name="users[]"  data-id="user_detail" data-key="u_id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="c_id = <?php echo $this->companyGroupId; ?>">
							 <?php
							 if(!empty($report_data)){
								 //   
								 $salesData = json_decode($report_data->toEmail);
								 
								foreach($salesData as $saleval){
									$usersdata = getNameById('user_detail',$saleval,'u_id');
									if(!empty($usersdata)){
										echo '<option value="'.$saleval.'" selected>'.$usersdata->name.'</option>';
									}
								}	
							}
							?>
					</select>	
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">Frequency</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <select class="form-control" required="required" name="frequency" id="frequency" onchange="ChangePrefix_and_subType();">
                        <option value="">Select Option</option>
                        <option  <?php if(!empty($report_data)){ if($report_data->frequency == 1){ ?> selected="selected" <?php } }?> value="1" >Daily</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="item form-group">
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <button type="Submit" class="btn btn-round btn-success btn-lg" name="SearchButton" id="SearchButton"> Submit</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
</form>