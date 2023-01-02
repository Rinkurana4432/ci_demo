<?php
 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveinventorylots" enctype="multipart/form-data" id="materialForm" novalidate="novalidate">		
    <div class="x_panel">
      <div class="x_title">
         <div class="clearfix"></div>
      </div>
	  <input type="hidden" name="id" value="<?php if(!empty($report_data)) echo $report_data->id; ?>">
      <div class="x_content">
         <div class="col-md-12 ">
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Lot No.<span class="required">*</span></label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input  required="required"  type="text" name="lot_number" class="form-control Selectedmonth" value="<?php  if(!empty($report_data)){ echo $report_data->lot_number; } ?>"/>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">MOU Price<span class="required">*</span></label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input  required="required"  type="text" name="mou_price" class="form-control Selectedmonth" value="<?php  if(!empty($report_data)){ echo $report_data->mou_price; } ?>"/>
                  </div>
               </div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">MRP Price<span class="required">*</span></label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <input  required="required"  type="text" name="mrp_price" class="form-control Selectedmonth" value="<?php  if(!empty($report_data)){ echo $report_data->mrp_price; } ?>"/>
                  </div>
               </div>
            </div>
            
            <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Date<span class="required">*</span></label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                   <input type="date" name="date" id="acknowledge" class="form-control col-md-7 col-xs-12 req_date" value="<?php  if(!empty($report_data)){ echo $report_data->date; } ?>">
                  </div>
               </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12 vertical-border">
                          <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Material Type<span class="required">*</span></label>
                          <div class="col-md-8 col-sm-12 col-xs-12">
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" required="required" name="mat_type_id" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                              <option value="">Select Option</option>
                              <?php if(!empty($report_data && $report_data->mat_type_id)){
                                 $material_type_id = getNameById('material_type',$report_data->mat_type_id,'id');
                                 echo '<option value="'.$report_data->mat_type_id.'" selected >'.$material_type_id->name.'</option>';
                              }?>
                           </select>
                        </div>
            </div>


                         <div class="col-md-6 col-sm-6 col-xs-12 vertical-border">
                          <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Material Name<span class="required">*</span></label>
                          <div class="col-md-8 col-sm-12 col-xs-12">
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name" id="mat_name"  name="mat_id" onchange="getUom(event,this);">
                              <option value="">Select Option</option>
                              <?php if(!empty($report_data && $report_data->mat_id)){
                                 $material_type_id22 = getNameById('material',$report_data->mat_id,'id');
                                 echo '<option value="'.$report_data->mat_id.'" selected>'.$material_type_id22->material_name.'</option>';
                              }?>
                           </select>
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