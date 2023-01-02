<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveProductiondata" enctype="multipart/form-data" id="productiondata" novalidate="novalidate">
   <input type="hidden" name="id" value=""> 
   <input type="hidden" id="current_login_com_id" value="<?php  echo $_SESSION['loggedInUser']->c_id; ?>" >	
   <input type="hidden" name="save_status" value="1" class="save_status">
   <input type="hidden" name="planning_id" value=" <?php if ($convert_to_prodData && !empty($convert_to_prodData)) {echo $convert_to_prodData->id;} ?>" class="">
   <?php
     # pre($convert_to_prodData);
      	
      		if(empty($convert_to_prodData)){
      		
      	?>
   <input type="hidden" name="created_by" value="<?php  echo $_SESSION['loggedInUser']->u_id; ?>" >
   <?php }else{ ?>	
   <input type="hidden" name="created_by" value="<?php if($convert_to_prodData && !empty($convert_to_prodData)){ echo $convert_to_prodData->created_by;} ?>" >
   <?php } ?>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedUser">
   <div class="col-md-6 col-sm-12 col-sx-12 ">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="company_branch">Company Branch<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
             <select class="form-control col-md-2 col-xs-12 selectAjaxOption select2 compny_unit" required="required" name="company_branch" data-id="company_address" data-key="compny_branch_id" data-fieldname="company_unit" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" onChange="getDept(event,this)">
               <option value="">Select Unit</option>
               <?php
                  if(!empty($convert_to_prodData)){
                     #$getUnitName = getNameById('company_address',$production_plan->unit_name,'compny_branch_id');
                     $getUnitName = getNameById('company_address',$convert_to_prodData->company_branch,'compny_branch_id');
                     #echo '<option value="'.$getUnitName->compny_branch_id.'" selected>'.$getUnitName->company_unit.'</option>';
                     echo '<option value="'.$convert_to_prodData->company_branch.'" selected>'.$getUnitName->company_unit.'</option>';
                  }
                  
                  ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12">Department</label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 department" required="required" name="department_id"  tabindex="-1" aria-hidden="true" data-id="department" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND unit_name = '<?php echo (!empty($convert_to_prodData))?$convert_to_prodData->company_branch:''; ?>'" >
               <option value="">Select Option</option>
               <?php
                  if(!empty($convert_to_prodData)){
                     $departmentData = getNameById('department',$convert_to_prodData->department_id,'id');
                     if(!empty($departmentData)){
                        echo '<option value="'.$departmentData->id.'" selected>'.$departmentData->name.'</option>';
                     }
                  }
                  ?>                      
            </select>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-sm-12 col-sx-12 ">
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="shift">Shift<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <?php if(empty($convert_to_prodData)){ ?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php }else{  
               if(!empty($productionSetting)){
               	foreach($productionSetting as $ps){	 
               		if($convert_to_prodData->department_id == $ps['department']){
               				
               ?>
             <div class="radio_edit">
               <label>
               <?php
               foreach (json_decode($ps['shift_name']) as $key => $value) {
               ?>
               <input type="hidden" class="flat" name="shift" value="<?php echo $ps['id']; ?>"><input type="radio" class="flat" name="shift_name" value="<?php echo $value; ?>" <?php if($convert_to_prodData->shift_name == $value){ echo 'checked'; } ?>  ><?php echo $value; ?></br>
               <?php
               }
               ?>
               </label>
            </div>
            <?php 		}
               }
               }
               
               ?>
            <div class="radio_button"></div>
            <div class="Displaymessage"></div>
            <?php  } ?>
            <?php /*if(!empty($productionSetting)){
               foreach($productionSetting as $ps){
               if($convert_to_prodData->department_id == $ps['department']){						 
               ?>
            <div class="radio">
               <label>
               <input type="radio" class="flat" name="shift" value="<?php echo $ps['id']; ?>" checked = checked[0] <?php if($convert_to_prodData->shift == $ps['id']){echo 'checked';} ?> ><?php echo $ps['shift_name']; ?></br>
               </label>
            </div>
            <?php }
               }
               }*/ ?>    
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12" for="machine_name">Date<span class="required">*</span></label>
         <div class="col-md-6 col-sm-12 col-xs-12">
            <input id="date" class="form-control col-md-2 col-xs-12 date" name="date" placeholder="date" required="required" type="text" value="<?php if($convert_to_prodData && !empty($convert_to_prodData)){echo $convert_to_prodData->date; }?>" onkeydown="event.preventDefault()" data-id="convert_to_prodData">
            <div class="message"></div>
            <?php  
               $date = getdate(strtotime($convert_to_prodData->date));
               $month = $date['mon']; 
               $year = $date['year']; 
               $y= date($year);
               $m= date($month); 
               $no_of_days = date('t',mktime(0,0,0,$m,1,$y)); // This is to calculate number of days in  month
               ?>
            <input id="noOfdays" class="form-control col-md-2 col-xs-12" name="no_of_dys" placeholder="date" type="hidden" value="<?php echo $no_of_days; ?>">
         </div>
      </div>
   </div>
   <hr>
   <div class="bottom-bdr"></div>
   <div class="item form-group" >
      <div class="table table-striped dataTable maintable rTable" id="prodPlan">
         <div class="app_div" >
            <div class="rTableRow mobile-view2">
               <div class="rTableHead"><label>Select</label></div>
               <div class="rTableHead"><label>Machine Name</label></div>
               <div class="rTableHead"><label>Work Order</label></div>
               <!-- <div class="rTableHead"><label>NPDM</label></div>	-->		   
               <div class="rTableHead"><label>Product Name</label></div>
               <div class="rTableHead"><label>BOM Routing</label></div>
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
               if($convert_to_prodData){ 
               	/*if(!empty($wages_perpiece)){
               		foreach($wages_perpiece as $settingWages_perpiece){
               			if(($settingWages_perpiece['company_unit'] == $convert_to_prodData->company_branch) && ($settingWages_perpiece['department'] == $convert_to_prodData->department_id)){
               				$WagesSetting = $settingWages_perpiece['wages_perpiece'];	    
               			}
               		}
               	}*/
               		
               	$convert_productionPlan = json_decode($convert_to_prodData->planning_data);
               		
               		//pre($convert_to_prodData);
               		if(!empty($convert_productionPlan)){
               			//$i=0;
               			$k=0;
               			$checked ='';
               		$checkedWages ='';
               		$checkedPerpiece ='';
               		$disabledWages = '';
               		$disabledPerpiece = '';
               		foreach($convert_productionPlan as $convertproduction_Plan){
               				//pre($prodplanData);
               				$machineCount = count($convertproduction_Plan->machine_name_id);
               				//pre($convertproduction_Plan);
               				for($i=0; $i<$machineCount ; $i++){
               					//pre($convertproduction_Plan);
               					$jobcard_data = isset($convertproduction_Plan->job_card_product_name[$i])?(getNameById('job_card',$convertproduction_Plan->job_card_product_name[$i],'id')):'';
               					$machineName = isset($convertproduction_Plan->machine_name_id[$i])?(getNameById('add_machine',$convertproduction_Plan->machine_name_id[$i],'id')):'';
               					 if($convert_to_prodData->wages_perpiece == 'wages'){
               						
               						$checkedWages = 'checked';
               						$disabledPerpiece = 'disabled';
               							   
               					}else if($convert_to_prodData->wages_perpiece =='per_piece'){
               							
               						$checkedPerpiece  = 'checked';
               						$disabledWages = 'disabled';
               					}else if($convert_to_prodData->wages_perpiece =='both'){
               							
               						$checkedWages  = 'checked';
               						$disabledWages = '';
               						$disabledPerpiece = '';
               					} 
               /*if($convert_to_prodData){ 
               		
               	$convert_productionPlan = json_decode($convert_to_prodData->planning_data);
               	//$wages_perpiece = $convert_productionPlan->wages_perpiece;
               			
               	if(!empty($convert_productionPlan)){
               		$i=0;
               		$k=0;
               		$checked ='';
               		$checkedWages ='';
               		$checkedPerpiece ='';
               		$disabledWages = '';
               		$disabledPerpiece = '';
               		foreach($convert_productionPlan as $convertproduction_Plan){
               			$machineName = getNameById('add_machine',$convertproduction_Plan->machine_name_id,'id');
               			$jobcard_data = getNameById('job_card',$convertproduction_Plan->job_card_product_name,'id');
               			$workerId = $convertproduction_Plan->worker;
               			//$convert_to_prodData->wages_perpiece);
               			if($convert_to_prodData->wages_perpiece == 'wages'){
               				$checkedWages = 'checked';
               				$disabledPerpiece = 'disabled';
               					   
               			}else if($convert_to_prodData->wages_perpiece =='per_piece'){
               				$checkedPerpiece  = 'checked';
               				$disabledWages = 'disabled';
               			}else if($convert_to_prodData->wages_perpiece =='both'){
               				$checked  = 'checked';
               			}
               				*/
               			//pre($checkedWages);
               ?>	
            <!--<tr id="<?php //echo ($i==0)?('index_'.$k):('addFunc_'.$k);?>">  -->
            <div id="<?php echo ($i==0)?('index_'.$k):('addFunc_'.$i);?>" class="rTableRow mobile-view">
               <div class="rTableCell">
                  <label>Select</label>
                  <input type="radio" id="radio_id_btn1" name="wages_or_per_piece[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" value="wages" <?php echo $checkedWages; ?>  class="wages" <?php echo $disabledWages; ?>>
                  <span for="defaultRadio">Wages</span>
                  <input type="radio" id="radio_id_btn1" name="wages_or_per_piece[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>"  value="per_piece" class="per_piece_rate" <?php echo $checkedPerpiece; ?>  <?php echo $disabledPerpiece; ?>>
                  <span for="defaultRadio">Per Piece</span>
               </div>
               <div class="rTableCell">
                  <label>Machine Name</label>
                  <input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name_id[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name" type="hidden" value="<?php echo $machineName->id ;?>" readonly >
                  <input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="text" value="<?php echo $machineName->machine_name;?>" readonly>
                  <input  class="form-control col-md-2 col-xs-12 machnine_grp" name="machine_grp[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Machine Name"  type="hidden" value="<?php echo @$machineName->machine_group_id;?>"readonly>
               </div>
            <!--   <div class="rTableCell">
                  <label>Sale order</label>
                  <select class="form-control dis selectAjaxOption select2 select2-hidden-accessible sale_order_cls" id ="sale_order" name="sale_order[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%" tabindex="-1" aria-hidden="true"  data-id="sale_order" data-key="id" data-fieldname="so_order" tabindex="-1" onchange="getMaterialNamesaleorder(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND save_status = 1">
                     <option>Select Option</option>
                     <?php 
                       /* if(!empty($convertproduction_Plan)){
                        	$sale_order = isset($convertproduction_Plan->sale_order[$i])?getNameById('sale_order',$convertproduction_Plan->sale_order[$i],'id'):'';
                        	echo '<option value="'.$sale_order->id.'" selected>'.$sale_order->so_order.'</option>';
                        } */
                        ?>
                  </select>
               </div>-->
			   		   <div class="rTableCell">
                  <label>Work Order</label>	
					 <select class="form-control dis selectAjaxOption removefildswork select2 select2-hidden-accessible WorkOrderId"  name="work_order[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="getMaterialNameWorkorder(event,this)" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND progress_status = 0 AND company_branch_id=<?php echo $convert_to_prodData->company_branch; ?> AND department_id=<?php echo $convert_to_prodData->department_id; ?>">
                     <option value="">Select Option</option>
                     <?php 
                        if(!empty($convertproduction_Plan)){
                        	//pre($productionDetail);
                        	$work_order = isset($convertproduction_Plan->work_order[$i])?getNameById('work_order',$convertproduction_Plan->work_order[$i],'id'):'';
                        	echo '<option value="'.$work_order->id.'" selected>'.$work_order->workorder_name.'</option>';
                        }
                        ?>
                  </select>
				  <input type="hidden"  name="sale_order[<?php echo $k; ?>][<?php echo $i; ?>]"  value="<?php echo isset($convertproduction_Plan->sale_order[$i])?$convertproduction_Plan->sale_order[$i]:''; ?>" class="SelectedSaleOrder">

               </div>
               <div class="rTableCell">
                  <label>Product Name</label>	
                  <select class="form-control party_code_cls selectAjaxOption24 select2 productNameId dis"  name="product_name[<?php echo $k; ?>][<?php echo $i; ?>]" width="100%"  id="product_name">
                     <option value="">Select Option</option>
                     <?php 
                        #pre($prodplanData->product_name);
                        		if(!empty($convertproduction_Plan)){
                        			
                        			$sale_order23 = isset($convertproduction_Plan->product_name[$i])?getNameById('material',$convertproduction_Plan->product_name[$i],'id'):'';
                        
                        			echo '<option value="'.$sale_order23->id.'" selected>'.$sale_order23->material_name.'</option>';
                        		}
                        ?>
                  </select>
               </div>
               <div class="rTableCell">
                  <label>BOM Routing Product Name</label>
                  <?php 
                     //pre($jobCardData);
                     $jobCardData = isset($convertproduction_Plan->job_card_product_id[$i])?(getNameById('job_card',$convertproduction_Plan->job_card_product_id[$i],'id')):''; ?>
                  <?php /*<input id="job_card_product_name" class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){ echo $jobCardData->job_card_product_name;} else{echo "";}?>">*/?>
                  <input id="job_card_product_name" class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){ echo $jobCardData->job_card_no;} else{echo "";}?>">
                  <?php /*	<input type="hidden" id="job_card_product_id" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->id;} else{echo "";}?>">*/?>
                  <input type="hidden" id="job_card_product_id" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[<?php echo $k; ?>][<?php echo $i; ?>]_<?php echo $k; ?>" placeholder="Job Card Number" readonly  type="text" value="<?php if(!empty($jobCardData)){echo $jobCardData->id;} else{echo "";}?>">
               </div>
               <div class="rTableCell">
                  <label>Assign Process</label>	       
                  <select class="form-control process_name" name="process_name[<?php echo $k; ?>][<?php echo $i; ?>]" >
                     <option value="">Select Option</option>
                     <?php if(!empty($convertproduction_Plan)){
                        $process = isset($convertproduction_Plan->process_name[$i])?getNameById('add_process',$convertproduction_Plan->process_name[$i],'id'):'';
                        echo '<option value="'.$process->id.'" selected>'.$process->process_name.'</option>';
                        }?>
                  </select>
                  <input type="hidden" name="inpt_outpt_process[<?php echo $k; ?>][<?php echo $i; ?>]" id="inpt_outpt_process" value="">
               </div>
               <div class="rTableCell">
                  <label>NPDM</label>	
                  <select class="selectAjaxOption select2 form-control npdm" name="npdm_name[<?php echo $k; ?>][<?php echo $i; ?>]" data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" data-where="created_by_cid = <?php echo $_SESSION['loggedInUser']->c_id; ?>">
                     <option value="">Select Option</option>
                     <?php if(!empty($convertproduction_Plan)){
                        $npdm1 = isset($convertproduction_Plan->npdm[$i])?getNameById('npdm',$convertproduction_Plan->npdm[$i],'id'):'';
                        echo '<option value="'.$npdm1->id.'" selected>'.$npdm1->product_name.'</option>';
                        }?>
                  </select>
               </div>
               <div class="rTableCell">
                  <label>Workers</label>
                  <?php $workerName_id[$i] = isset($convertproduction_Plan->worker[$i])?($convertproduction_Plan->worker[$i]):'';
                     //pre($workerName_id[$i]); //pre($workerName_id);?>
                  <select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[<?php echo $k; ?>][<?php echo $i; ?>][]" data-id="worker" data-key="id" data-fieldname="name" width="100%" tabindex="-1"  data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>">
                     <option>Select Option</option>
                     <?php 
                        if(!empty($workerName_id[$i])){
                        	foreach($workerName_id[$i] as $worker_Name){
                        		$Workername = getNameById('worker',$worker_Name,'id');
                        		echo '<option value="'.$worker_Name.'" selected>'.$Workername->name.'</option>';
                        	}
                        }  	
                        /*if(!empty($workerId)){
                        	foreach($workerId as $worker_Name){
                        		$Workername = getNameById('worker',$worker_Name,'id');
                        		echo '<option value="'.$worker_Name.'" selected>'.$Workername->name.'</option>';
                        	}
                        }	*/
                        ?>        
                  </select>
               </div>
               <div class="rTableCell hrs">
                  <label>Hrs in wages,% in per piece</label>
                  <span class="show_msg" style="display:none;">Total %age should be 100</span>	
                  <?php 
                     if(!empty($workerName_id[$i])){
                     	$m = 0;
                     	 foreach($workerName_id[$i] as $worker_id){
                     		// pre($worker_id);
                     		 $getWorkerSalary = getNameById('worker',$worker_id,'id');
                     		 //pre($getWorkerSalary);
                     		 
                     		if( !empty($getWorkerSalary) ){
                     			 $salary = $getWorkerSalary->salary;
                     		}else{
                     			$salary = 0;
                     		}
                     		//$salary = $getWorkerSalary->salary;
                     		if(gettype($worker_id) == 'array'){
                     			$count_worker_id = count($worker_id);
                     		}elseif($worker_id !=''){
                     			$count_worker_id = 1;
                     		}
                     		
                     		
                     		for($j = 0; $j <$count_worker_id; $j++){
                     			//pre($j);
                     			//echo "<input type='text' value='' class='form-control col-md-7 col-xs-12 hours abc_".$worker_id."' style='width:50%; float:left;' name='working_hrs[".$i."][0][".$m."]' onkeyup = 'keyupFun(event,this)' placeholder='Hours'><input type = 'hidden' value='".$salary."' name ='salary' class='salaryValue_".$worker_id."'><input style='width:50%; float:left;' id='totalsalary' class='form-control col-md-7 col-xs-12 totalsalary salary_".$worker_id."' name='totalsalary[".$i."][0][".$m."]' placeholder='totalsalary'  type='text' value=''  onkeypress='return float_validation(event, this.value)' readonly>";
                     			echo "<input type='text' value='' class='form-control col-md-7 col-xs-12 hours abc_".$worker_id."' style='width:50%; float:left;' name='working_hrs[".$k."][".$i."][".$m."]' onkeyup = 'keyupFun(event,this)' placeholder='Hours'><input type = 'hidden' value='".$salary."' name ='salary' class='salaryValue_".$worker_id."'><input style='width:50%; float:left;' id='totalsalary' class='form-control col-md-7 col-xs-12 totalsalary salary_".$worker_id."' name='totalsalary[".$k."][".$i."][".$m."]' placeholder='totalsalary'  type='text' value=''  onkeypress='return float_validation(event, this.value)' readonly>";
                     			//pre($j);
                     			$m++;
                     		}
                     	}							
                     }
                     
                     
                     
                     
                     /*if(!empty($workerId)){ 
                     	$m = 0;
                     	 foreach($workerId as $worker_id){
                     		 $getWorkerSalary = getNameById('worker',$worker_id,'id');
                     		 //pre($getWorkerSalary);
                     		 
                     		if( !empty($getWorkerSalary) ){
                     			 $salary = $getWorkerSalary->salary;
                     		}else{
                     			$salary = 0;
                     		}
                     		//$salary = $getWorkerSalary->salary;
                     		if(gettype($worker_id) == 'array'){
                     			$count_worker_id = count($worker_id);
                     		}elseif($worker_id !=''){
                     			$count_worker_id = 1;
                     		}
                     		
                     		
                     		for($j = 0; $j <$count_worker_id; $j++){
                     			
                     			echo "<input type='text' value='' class='form-control col-md-7 col-xs-12 hours abc_".$worker_id."' style='width:50%; float:left;' name='working_hrs[".$i."][0][".$m."]' onkeyup = 'keyupFun(event,this)' placeholder='Hours'><input type = 'hidden' value='".$salary."' name ='salary' class='salaryValue_".$worker_id."'><input style='width:50%; float:left;' id='totalsalary' class='form-control col-md-7 col-xs-12 totalsalary salary_".$worker_id."' name='totalsalary[".$i."][0][".$m."]' placeholder='totalsalary'  type='text' value=''  onkeypress='return float_validation(event, this.value)' readonly>";
                     			//pre($j);
                     			$m++;
                     		}
                     	}							
                     }*/
                     ?>
               </div>
               <?php /*
               <div class="rTableCell">	
                  <label>Production Output</label>				
                  <input id="output" class="form-control col-md-7 col-xs-12 output" name="output[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="output"  type="text" value="<?php if(isset($convertproduction_Plan->output[$i])) echo $convertproduction_Plan->output[$i]; ?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
               </div>
                  */ ?>
               <div class="rTableCell">
               <label>Production Output</label>
                  <?php
                  //pre($prodplanData);
                  $jobCardData = isset($convertproduction_Plan->job_card_product_id[$i])?(getNameById('job_card',$convertproduction_Plan->job_card_product_id[$i],'id')):'';
                  $machine_details = json_decode($jobCardData->machine_details);
                  if($process->id != 0){
                  $key = array_search($process->id, array_column($machine_details, 'processess'));
                  if($key === 0 || $key >= 1){
                  $detail_info = $machine_details[$key];
                  $output_process_dtl = (!empty($detail_info->output_process) && isset($detail_info->output_process))?$detail_info->output_process:'';
                  $process_sch_output = json_decode($output_process_dtl);
                  }
                  }
                  $out = 0;
                  foreach($process_sch_output as $val_output_sech){
                  $material_id_output = $val_output_sech->material_output_name;
                  $materialName_output = getNameById('material',$material_id_output,'id');
                  ?>
                  <input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $materialName_output->material_name; ?>" readonly="">
                  <input style="width:50%; float:left;" id="output" class="form-control col-md-7 col-xs-12 output" name="output[<?php echo $k; ?>][<?php echo $i; ?>][<?php echo $out; ?>]" placeholder="output"  type="text" value="<?php if(isset($convertproduction_Plan->output[$i][$out])) echo $convertproduction_Plan->output[$i][$out];?>" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">
                  <?php $out++; } ?>


                  <!--input id="output" class="form-control col-md-2 col-xs-12" name="output[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="output" type="number" value="<?php if(isset($prodplanData->output[$i])) echo $prodplanData->output[$i]; ?>"-->
               </div>
               <input id="planing_output" class="form-control col-md-7 col-xs-12 planing_output" name="planing_output[<?php echo $k; ?>][<?php echo $i; ?>]"    type="hidden" value="<?php if(isset($convertproduction_Plan->output[$i])) echo $convertproduction_Plan->output[$i]; ?>" >
               <div class="rTableCell">
                  <label>Labour costing</label>
                  <input id="labour_costing" class="form-control col-md-7 col-xs-12 labour_costing" name="labour_costing[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="labour_costing"  type="text" value="" onkeypress="return float_validation(event, this.value)" onkeyup="keyupFun(event,this)">
               </div>
               <div class="rTableCell">
                  <label>Remarks</label>
                  <textarea id="remarks" class="form-control col-md-7 col-xs-12" name="remarks[<?php echo $k; ?>][<?php echo $i; ?>]" placeholder="remarks"  type="text" value="" ></textarea>
               </div>
               <div class="rTableCell">
                  <?php //echo ($i==0)?('<input type="button" class="addRow btn btn-success btn-xs" id="addR" value="Add" />'):('<button type="button" id="ibtnDel" class="dele btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>');?>
                  <?php /*<input type="button" class="addRow btn btn-success btn-xs" id="addR" value="Add" */ ?>
               </div>
            </div>
            <?php 					
               }$i++; 
               $k++;
               }
               }
               }	
               ?>
         </div>
      </div>
   </div>
   <div class="form-group ">
      <div class="col-md-6 col-md-offset-3">
         <a class="btn btn-default" onclick="location.href='<?php echo base_url();?>production/production_planning'">Close</a>
         <button type="reset" class="btn btn-default">Reset</button>
         <?php if((!empty($convertproduction_Plan) ) || empty($convertproduction_Plan)){
            echo '<input type="submit" class="btn edit-end-btn  draftBtn" value="Save as draft">'; 
            } ?>
         <button id="send" type="submit" class="btn btn-warning disablesubmitBtn" id="go">Submit</button>
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