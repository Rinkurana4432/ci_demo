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
      <input type="hidden" value='' class='start_date' name='start'/>
      <input type="hidden" value='' class='end_date' name='end'/>
      <input type="hidden" value='<?php echo $_GET['start']; ?>'  class='start_date' name='start'/>
      <input type="hidden" value='<?php echo $_GET['favourites']; ?>' name="favourites"/>
      <input type="hidden" value='<?php echo $_GET['end']; ?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
   </form>
   <?php # if(!empty($productionData)){ ?>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         <div class="col-md-3 col-sm-12 col-xs-12 datepicker">
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
         <div class="btn-group"  role="group" aria-label="Basic example">
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='production_data' id="table" data-msg="Production Data" data-path="production/production_data"/>
            <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
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
         <div class="col-md-3 col-xs-12 col-sm-12 datePick-right">
            <?php if($can_add) {                               
               echo '<button type="button" class="btn btn-primary productionTab addBtn" data-id="productEdit" id="add" data-toggle="modal">Add</button>';
               }?>
         </div>
      </div>
   </div>
   <?php # } ?>      
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!---datatable-buttons--->
     <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveProductiondata" enctype="multipart/form-data" id="purchaseIndentForm" novalidate="novalidate">
   <input type="hidden" value="<?php if(!empty($production_data)){ echo $production_data->id ;}?>" name="id">
   <input type="hidden" id="current_login_com_id" value="<?php  echo $_SESSION['loggedInUser']->c_id; ?>" >
   <input type="hidden" name="save_status" value="1" class="save_status">  
   <input type="hidden" name="planning_id" value="" class="">  
   <?php #pre($production_data);
      if(empty($production_data)){
      
         
      ?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <input type="hidden" value="<?php echo '0'; ?>" id="edit_id" >
   <?php }else{ ?>   
   <input type="hidden" name="created_by" value="<?php if($production_data && !empty($production_data)){ echo $production_data->created_by;} ?>" >
   <input type="hidden" value="<?php echo $production_data->id; ?>" id="edit_id">
   <?php } ?>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($production_data)){
                     #$getUnitName = getNameById('company_address',$production_data->unit_name,'compny_branch_id');
                     $getUnitName = getNameById('company_address',$production_data->company_branch,'compny_branch_id');
                  // pre($getUnitName);
                     #echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                     echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid =<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($production_data))?$production_data->company_branch:''; ?>'" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($production_data)){
                     $departmentData = getNameById('department',$production_data->department_id,'id');
                     if(!empty($departmentData)){
                        echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                     }
                  }
                  ?>
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(empty($production_data)){ ?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php }else{  
               if(!empty($productionSetting)){
                  foreach($productionSetting as $ps){  
                  //pre($ps);
                  //pre($pds)
                     if($production_data->department_id == $ps['department']){
                           
               ?>
            <div class="radio_edit">
               <input type="radio" class="flat" name="shift" value="<?php echo $ps['id']; ?>" <?php if($production_data->shift == $ps['id']){ echo 'checked'; }else{ echo 'checked = checked[0]'; }?>  ><?php echo $ps['shift_name']; ?></br>
            </div>
            <?php       }
               }
               }
               
               ?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php  } ?>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="date">Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="date" class="form-control col-md-2 col-xs-12 date" name="date" placeholder="date" required="required" type="text" value="<?php if($production_data && !empty($production_data)){echo $production_data->date; }?>" onkeydown="event.preventDefault()">
            <input id="noOfdays" class="form-control col-md-2 col-xs-12" name="no_of_dys" placeholder="date" required="required" type="hidden" value="<?php if($production_data && !empty($production_data)){echo $production_data->no_of_dys; }?>">
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="item form-group" >
      <div class="table table-striped maintable btn_heading_hide rTable" id="mytable" style="display:none;">
         <div class="app_div">
            <div class="rTableRow mobile-view2">
               <div class="rTableHead"><label>Select</label></div>
               <div class="rTableHead"><label>Machine Name</label></div>
               <!--  <div class="rTableHead"><label>Sale Order</label></div>-->
               <div class="rTableHead"><label>Work Order</label></div>                    
               <div class="rTableHead"><label>Product Name</label></div>
               <div class="rTableHead"><label>BOM Routing Product Name</label></div>
               <div class="rTableHead"><label>Assign Process</label></div>
               <div class="rTableHead"><label>NPDM</label></div>
               <div class="rTableHead fix-width"><label>Workers</label></div>
               <div class="rTableHead fix-width"><label>Hrs in wages,% in per piece</label></div>
               <div class="rTableHead"><label>Production Output</label></div>
               <div class="rTableHead"><label>Labour costing</label></div>
               <div class="rTableHead" ><label>Remarks</label></div>
               <div class="rTableHead"></div>
            </div>
            <?php 
              #pre($production_data);
               if($production_data){   

               $WagesSetting ="";
                  if(!empty($productionSettingWages)){
                     foreach($productionSettingWages as $settingWages_perpiece){
                        if(($settingWages_perpiece['company_unit'] == $production_data->company_branch) && ($settingWages_perpiece['department'] == $production_data->department_id)){
                           $WagesSetting = $settingWages_perpiece['wages_perpiece'];       
                        }
                     }
                  }
                  
                  
                  $production_detail = json_decode($production_data->production_data); 
                  if(!empty($production_detail)){                 
                     //$i=0;
                     $k=0;
                     foreach($production_detail as $productionDetail){                    
                        if(!empty($productionDetail)){
                           
                        $wagesLength = isset($productionDetail->wages_or_per_piece)?(count($productionDetail->wages_or_per_piece)):0;
                        $disabledWages ='';
                        $disabledPiece ='';
                        
                        for($i=0; $i<$wagesLength; $i++){
                           $machine_id = isset($productionDetail->machine_name_id[$i])?$productionDetail->machine_name_id[$i]:'';
                           @$machineName = getNameById('add_machine',$machine_id,'id');                     
                           //$jobCardData = isset($productionDetail->job_card_product_id[$k])?(getNameById('job_card',$productionDetail->job_card_product_id[$k],'id')):'';
                           //$jobCardData = isset($productionDetail->job_card_product_id[$i])?(getNameById('job_card',$productionDetail->job_card_product_id[$i],'id')):'';
                           //echo $i;
                           
                           
                           if($production_data->save_status != 0){
                           if($WagesSetting == 'wages'){
                              $disabledPiece = 'disabled'; 
                           }elseif($WagesSetting == 'per_piece'){
                              $disabledWages = 'disabled'; 
                           }elseif($WagesSetting == 'both'){
                              $disabledPiece = ''; 
                              $disabledWages = ''; 
                           }
                           /*if($productionDetail->wages_or_per_piece[$i] == 'wages'){
                              $disabledPiece = 'disabled'; 
                           }elseif($productionDetail->wages_or_per_piece[$i] == 'per_piece'){
                              $disabledWages = 'disabled'; 
                           }*/   
                           }
                        #echo $i.'<br>';
                        #echo $k;   ?>
            <?php /*<tr id="index_<?php echo $k;?>">  */?>
            <?php /*<div id="<?php echo ($i==0)?('index_'.$k):('addFunc_'.$k);?>" class="rTableRow mobile-view">   */?>
            <?php /*<div id="<?php echo ($i==0)?('index_'.$k):('addFunc_'.$k);?>" class="rTableRow mobile-view">  */?>
            <div id="<?php echo ($i==0)?('index_'.$k):('addFunc_'.$i);?>" class="rTableRow mobile-view">
               <div class="rTableCell" style="padding: 3px 10px;">
                  <label>Select</label>
                  <input type="hidden" value="<?php echo $WagesSetting; ?>" name="wage_perpiece_both" class="selectedOption">
                  <input type="radio" id="radio_id_btn1" name="wages_or_per_piece[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" value="wages" checked="checked" class="wages" <?php if(!empty($productionDetail->wages_or_per_piece) && isset($productionDetail->wages_or_per_piece)){ echo $productionDetail->wages_or_per_piece[$i] == 'wages' ?  "checked" : "" ;  }?> <?php echo $disabledWages;?> >
                  <span for="defaultRadio">Wages</span>
                  <input type="radio" id="radio_id_btn1" name="wages_or_per_piece[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" value="per_piece" class="per_piece_rate" <?php if(!empty($productionDetail->wages_or_per_piece) && isset($productionDetail->wages_or_per_piece)){ echo $productionDetail->wages_or_per_piece[$i] == 'per_piece' ?  "checked" : "" ; }?> <?php echo $disabledPiece ;?>>
                  <span for="defaultRadio">Per Piece</span>
               </div>
               <div class="rTableCell">
                  <label>Machine Name</label>
                  <input data-toggle="tooltip"  class="form-control col-md-2 col-xs-12 machine_name_id " name="machine_name_id[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name" type="hidden" value="<?php echo @$machineName->id ;?>"  title="<?php echo @$machineName->id ;?>" readonly  >
                  <input data-toggle="tooltip" class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="text" value="<?php echo @$machineName->machine_name;?>" title="<?php echo @$machineName->machine_name;?>" readonly>
                  <input data-toggle="tooltip"  class="form-control col-md-2 col-xs-12 machnine_grp" name="machine_grp[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="hidden" value="<?php echo @$machineName->machine_group_id;?>" title="<?php echo @$machineName->machine_group_id;?>" readonly>
               </div>
              <!-- <div class="rTableCell">
                  <label>Sale order</label>
                  <select class="form-control dis selectAjaxOption select2 select2-hidden-accessible sale_order_cls" id ="sale_order" name="sale_order[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%" tabindex="-1" aria-hidden="true"  data-id="sale_order" data-key="id" data-fieldname="so_order" tabindex="-1" onchange="getMaterialNamesaleorder(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status = 1 OR approve = 1 OR complete_status = 1 AND disapprove = 0">
                     <option>Select Option</option>
                     <?php 
                        if(!empty($productionDetail)){
                           //pre($productionDetail);
                           $sale_order = isset($productionDetail->sale_order[$i])?getNameById('sale_order',$productionDetail->sale_order[$i],'id'):'';
                           echo '<option value="'.$sale_order->id.'" selected>'.$sale_order->so_order.'</option>';
                        }
                        ?>
                  </select>
               </div>-->
            <div class="rTableCell">
                  <label>Work Order</label>  
               <select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId"  name="work_order[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="getMaterialNameWorkorder(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 AND company_branch_id=<?php echo $production_data->company_branch; ?> AND department_id=<?php echo $production_data->department_id; ?>">
                     <option value="">Select Option</option>
                     <?php 
                        if(!empty($productionDetail)){
                           //pre($productionDetail);
                           $work_order = isset($productionDetail->work_order[$i])?getNameById('work_order',$productionDetail->work_order[$i],'id'):'';
                           echo '<option value="'.$work_order->id.'" selected>'.$work_order->workorder_name.'</option>';
                        }
                        ?>
                  </select>

              <input type="hidden"  name="sale_order[<?php echo $k; ?>][<?php echo $i; ?>]"  value="<?php echo isset($productionDetail->sale_order[$i])?$productionDetail->sale_order[$i]:''; ?>" class="SelectedSaleOrder">

               </div>
               <div class="rTableCell">
                  <label>Product Name</label>   
                  <select class="form-control party_code_cls selectAjaxOption24 select2 productNameId dis" name="product_name[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%"  id="product_name">
                     <option value="">Select Option</option>
                     <?php 
                        if(!empty($productionDetail)){
                           //pre($productionDetail);
                           $mat = isset($productionDetail->party_code[$i])?getNameById('material',$productionDetail->party_code[$i],'id'):'';
                           echo '<option value="'.$mat->id.'" selected>'.$mat->material_name.'</option>';
                        }
                        ?>
                  </select>
               </div>
               <div class="rTableCell">
                  <label>BOM Routing </label>
                  <?php 
                     //pre($jobCardData);
                     $jobCardData = isset($productionDetail->job_card_product_id[$i])?(getNameById('job_card',$productionDetail->job_card_product_id[$i],'id')):''; 
               // pre($jobCardData);
                ?>
                  <?php /*<input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){ echo $jobCardData->job_card_product_name;} else{echo "";}?>">*/?>
                  <input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){ echo $jobCardData->job_card_no;} else{echo "";}?>">
                  <?php /* <input type="hidden" id="job_card_product_id" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->id;} else{echo "";}?>">*/?>
                  <input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->id;} else{echo "";}?>">
               </div>
               <div class="rTableCell">
                  <label>Assign Process</label>        
              <select class="form-control process_name" name="process_name[<?php echo $k; ?>][<?php echo $i; ?>]" =>  
                  <option value="">Select Option</option>
                  <?php if(!empty($productionDetail)){
                              $process = isset($productionDetail->process_name[$i])?getNameById('add_process',$productionDetail->process_name[$i],'id'):'';
                              echo '<option value="'.$process->id.'" selected>'.$process->process_name.'</option>';
                        }?>
               </select>
               <input type="hidden" name="inpt_outpt_process[<?php echo $k; ?>][<?php echo $i; ?>]" class="inpt_outpt_process" value="">
               </div>
               <div class="rTableCell">
                  <label>NPDM</label>  
                  <select class="selectAjaxOption select2 form-control npdm" name="npdm_name[<?php echo $k; ?>][<?php echo $i; ?>]" data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?>">
                     <option value="">Select Option</option>
                     <?php if(!empty($productionDetail)){
                        #pre($productionDetail);
                              $npdm1 = isset($productionDetail->npdm[$i])?getNameById('npdm',$productionDetail->npdm[$i],'id'):'';
                              echo '<option value="'.$npdm1->id.'" selected>'.$npdm1->product_name.'</option>';
                        }?>
                  </select>
               </div>
               <div class="rTableCell">
                  <label>Workers</label>
                  <?php $workerName_id[$i] = isset($productionDetail->worker_id[$i])?($productionDetail->worker_id[$i]):'';  ?>
                  <select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[<?php echo $k; ?>][<?php echo $i; ?>][]" data-id="worker" data-key="id" data-fieldname="name" width="100%" tabindex="-1"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
                     <option>Select Option</option>
                     <?php  
                        #pre($workerName_id[$i]);
                           if(!empty($workerName_id[$i])){
                              foreach($workerName_id[$i] as $worker_Name){
                                 $Workername = getNameById('worker',$worker_Name,'id');
                                 echo '<option value="'.$worker_Name.'" selected>'.$Workername->name.'</option>';
                              }
                           }     
                        ?>    
                  </select>
               </div>
               <div class="hrs rTableCell">
                  <label>Hrs in wages,% in per piece</label>
                  <span class="show_msg" style="display:none ;">Total %age should be 100</span>
                  <?php
                     if(!empty($productionDetail->working_hrs[$i])){ 
                        //$getWorkerSalary = getNameById('worker',$worker_id,'id');
                        //$salary = $getWorkerSalary->salary;  
                           $working_hrs_length[$i] = count($productionDetail->working_hrs[$i]);
                     $working_hrs = json_decode(json_encode($productionDetail->working_hrs),true);
                     $totalsalary = json_decode(json_encode($productionDetail->totalsalary),true);
                           for($j = 0; $j <$working_hrs_length[$i]; $j++){ 
                           /*get salary*/
                              $workerId = $productionDetail->worker_id[$i][$j];
                              $getWorkerSalary = getNameById('worker',$workerId,'id')->salary;
                                    
                              
                              echo "<input type='text' value='".$working_hrs[$i][$j]."' class='form-control col-md-7 col-xs-12 hours abc_".$productionDetail->worker_id[$i][$j]."' style='width:50%; float:left;' name='working_hrs[".$k."][".$i."][".$j."]' placeholder='Hours' onkeyup='keyupFun(event,this)'><input type = 'hidden' value='".$getWorkerSalary."' name ='salary' class='salaryValue_".$productionDetail->worker_id[$i][$j]."'><input style='width:50%; float:left;' id='totalsalary' class='form-control col-md-7 col-xs-12 totalsalary salary_".$productionDetail->worker_id[$i][$j]."' name='totalsalary[".$k."][".$i."][".$j."]' placeholder='totalsalary'  type='text' value='".$totalsalary[$i][$j]."' onkeypress='return float_validation(event, this.value)' readonly>";
                           }
                     }
                        
                     ?>
               </div>
               <div class="rTableCell">
                  <label>Production Output</label>                      
                  <input id="output" class="form-control col-md-7 col-xs-12 output" name="output[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="output"  type="text" value="<?php if(isset($productionDetail->output[$i])) echo $productionDetail->output[$i];?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
               </div>
               <div class="rTableCell">
                  <label>Labour costing</label>
                  <input  class="form-control col-md-7 col-xs-12 labour_costing" name="labour_costing[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="labour_costing"  type="text" value="<?php if(!empty($productionDetail) && isset($productionDetail->labour_costing[$i])) echo $productionDetail->labour_costing[$i];?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)" <?php echo ($productionDetail->wages_or_per_piece[$i] == 'wages')?'readonly':''; ?>>
               </div>
               <div class="rTableCell">
                  <label>Remarks</label>
                  <textarea id="remarks" class="form-control col-md-7 col-xs-12" name="remarks[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="remarks"  type="text" value="" ><?php  if(isset($productionDetail->remarks[$i])) echo $productionDetail->remarks[$i];?></textarea>
               </div>
               <div class="rTableCell">
                  <?php echo ($i==0)?('<input type="button" class="addRow btn btn-success btn-xs" value="Add" />'):('<button type="button" id="ibtnDel" class="dele btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>');?>
                  <?php /*<input type="button" class="addRow btn btn-success btn-xs" id="addR" value="Add" />*/?>
               </div>
            </div>
            <?php }                 
               //$i++;
               $k++;
               }
               }
               }
               } ?>
         </div>
      </div>
   </div>
   <div class="form-group btn_heading_hide" style="display:none;">
      <div class="col-md-12 ">
         <center>
            <a class="btn btn-default" onclick="location.href='<?php echo base_url();?>production/production_data'">Close</a>
            <button type="reset" class="btn btn-default">Reset</button>
            <?php if((!empty($production_data) && $production_data->save_status !=1) || empty($production_data)){
               echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
               }?>
            <button id="send" type="submit" class="btn btn-warning disablesubmitBtn">Submit</button>
         </center>
      </div>
   </div>
</form>
<!-- Static Modal -->
<div class="modal loader fade" id="processing_loader" role="dialog" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="text-center">
               <i class="fa fa-refresh fa-5x fa-spin"></i>
               <h4>Processing...</h4>
            </div>
         </div>
      </div>
   </div>
</div>
<script>    
   var logged_user = <?php echo $_SESSION['loggedInUser']->c_id; ?>;    
</script>
<div class="modal left fade" id="myModal_Add_worker_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="position:absolute;">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Worker</h4>
            <span id="mssg34"></span>
         </div>
         <form name="insert_worker_data" name="ins"  id="insert_worker_data_id">
            <div class="modal-body">
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="name">Worker Name <span class="required">*</span></label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="worker_name" name="worker_name" required="required" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="email">Mobile number</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="mobile_number" name="mobile_number" class="form-control col-md-7 col-xs-12" value="" >
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
               <div class="item form-group col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-2 col-sm-2 col-xs-4" for="gstin">Salary</label>
                  <div class="col-md-10 col-sm-10 col-xs-8 form-group">
                     <input type="text" id="salary" name="salary" class="form-control col-md-7 col-xs-12" value="">
                     <span class="spanLeft control-label"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <input type="hidden" id="add_worker_Data_onthe_spot">
                  <button type="button" class="btn btn-default close_sec_model" >Close</button>
                  <button id="Add_worker_details_on_button_click" type="button" class="btn edit-end-btn ">Submit</button>
               </center>
            </div>
         </form>
      </div>
   </div>
</div>
      
      <?php //echo $this->pagination->create_links(); ?> 
   </div>
</div>

<div class="modal loader fade" id="processing_loader" role="dialog" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="text-center">
               <i class="fa fa-refresh fa-5x fa-spin"></i>
               <h4>Processing...</h4>
            </div>
         </div>
      </div>
   </div>
</div>