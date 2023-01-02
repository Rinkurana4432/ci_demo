<style type="text/css">
     .ditect{ width: 100%;
    text-align: center;
    font-size: 18px;
    background-color: #fff;
    color: #140104db;
   
   }

</style>
<form method="post" action="<?=base_url();?>hrm/saveempsalary" id="assetsform" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php if(!empty($salary_val)){ echo $salary_val->id; }?>">
    <input type="hidden" name="save_status" value="1" class="save_status">  
    <input type="hidden" name="loggedUser" value="<?php echo $this->companyGroupId ?>" id="loggedUser">
    <div class="modal-body">
       <div id="disable_div"  class="col-md-12 col-sm-12 col-xs-12">
        <div class="item form-group col-md-4 col-sm-12 col-xs-12">
        <label class="col-md-4 col-sm-12 col-xs-12 ">Employee</label>
        <div class="col-md-6 col-sm-12 col-xs-12"> 
    <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible   emp_id" name="emp_id" id="emp_id" data-id="user_detail" data-key="u_id" data-fieldname="name" data-where="c_id = <?php echo $this->companyGroupId;?>  " width="100%" tabindex="-1" aria-hidden="true" required="required"  >
               <option value="">Select Option</option>
              
               <?php  foreach($users as $user){?>
				   	<option value="<?php echo $user['id'];?>" <?php if(!empty($salary_val)){ if($salary_val->emp_id==$user['id']){echo 'Selected';}}?>>
					<?php echo $user['name'];?></option>
					<?php	 } ?>
            </select> 
        
		</div>
    </div>
     <div class="item form-group col-md-4 col-sm-12 col-xs-12">
        <label class="col-md-4 col-sm-12 col-xs-12 ">Salary Amount</label>
      <div class="col-md-6 col-sm-12 col-xs-12"> <input required type="number"  id="salary" name="total" class="form-control" value="<?php if(!empty($salary_val)){ echo $salary_val->total; }?>"  placeholder="Salary Amount..."  ></div>
    </div> 
     <?php if(!empty($salary_details->basic)){    ?>
      <div class="item form-group">
         <div class="col-md-6 col-sm-12 col-xs-12">
             <span> <span id="show_err"></span>  </span>
         </div>

    </div>
    <?php } ?>
    <div class="item form-group col-md-4 col-sm-12 col-xs-12">
          
              <?php if(!empty($salary_val->salary_details)){ 
               $salary_details = json_decode($salary_val->salary_details); 
               $total_sal=''; if(!empty($salary_val)){   $total_sal=$salary_val->total; }
               $basic=''; if(!empty($salary_details->basic)){   $basic=$total_sal*$salary_details->basic/100;}else{$basic="0.00";}
               $da=''; if(!empty($salary_details->da)){   $da=$total_sal*$salary_details->da/100;}else{$da="0.00";}
               $hra=''; if(!empty($salary_details->hra)){   $hra=$total_sal*$salary_details->hra/100;}else{$hra="0.00";}
               $ca=''; if(!empty($salary_details->ca)){   $ca=$total_sal*$salary_details->ca/100;}else{$ca="0.00";}
               $sa=''; if(!empty($salary_details->sa)){   $sa=$total_sal*$salary_details->sa/100;}else{$sa="0.00";}
               $medical=''; if(!empty($salary_details->medical)){   $medical=$total_sal*$salary_details->medical/100;}else{$medical="0.00";}
               $others=''; if(!empty($salary_details->others)){   $others=$total_sal*$salary_details->others/100;}else{$others="0.00";}
               $esic=''; if(!empty($salary_details->esic)){   $esic=$total_sal*$salary_details->esic/100;}else{$esic="0.00";}
               $tds=''; if(!empty($salary_details->tds)){   $tds=$total_sal*$salary_details->tds/100;}else{$tds="0.00";}
               $pf=''; if(!empty($salary_details->pf)){   $pf=$total_sal*$salary_details->pf/100;}else{$pf="0.00";}
              // $lwf=''; if(!empty($salary_details->lwf)){   $lwf=$total_sal*$salary_details->lwf/100;}else{$lwf="0.00";}
               $esic_employer=''; if(!empty($salary_details->esic_employer)){   $esic_employer=$total_sal*$salary_details->esic_employer/100;}else{$esic_employer="0.00";}
               $pf_employer=''; if(!empty($salary_details->pf_employer)){   $pf_employer=$total_sal*$salary_details->pf_employer/100;}else{$pf_employer="0.00";}
              // $lwf_employer=''; if(!empty($salary_details->lwf_employer)){   $lwf_employer=$total_sal*$salary_details->lwf_employer/100;}else{$lwf_employer="0.00";} 
                  }?>
 <input  type="hidden" name="basic" id="basic" value="<?php if(!empty($basic)){ echo $basic;  } ?>" class="form-control"  />
<input  type="hidden" id="da" name="da" value="<?php if(!empty($da)){ echo $da;  } ?>" class="form-control"   />
<input  type="hidden" id="hra" name="hra" value="<?php if(!empty($hra)){ echo $hra;  } ?>" class="form-control"    />
<input  type="hidden" name="ca" id="ca" value="<?php if(!empty($ca)){ echo $ca;  } ?>" class="form-control"   />
<input  type="hidden" name="sa" id="sa" value="<?php if(!empty($sa)){ echo $sa;  } ?>" class="form-control"   />
<input  type="hidden" name="medical" id="medical" value="<?php if(!empty($medical)){ echo $medical;  } ?>"  class="form-control" />
<input  type="hidden" name="others" id="others" value="<?php if(!empty($others)){ echo $others;  } ?>" class="form-control"   />
<input type="hidden" name="esic" id="esic" value="<?php if(!empty($esic)){ echo $esic;  } ?>" class="form-control" />
<input type="hidden" name="tds" id="tds" value="<?php if(!empty($tds)){ echo $tds;  } ?>" class="form-control" />
<input type="hidden" name="pf" id="pf" value="<?php if(!empty($pf)){ echo $pf;  } ?>" class="form-control" />
<input type="hidden" name="lwf" id="lwf" value="<?php if(!empty($salary_details->lwf)){ echo $salary_details->lwf;  } ?>" class="form-control" />
<input type="hidden" name="esic_employer" id="esic_employer" value="<?php if(!empty($esic_employer)){ echo $esic_employer;  } ?>" class="form-control" />
<input type="hidden" name="pf_employer" id="pf_employer" value="<?php if(!empty($pf_employer)){ echo $pf_employer;  } ?>" class="form-control" />
<input type="hidden" name="lwf_employer" id="lwf_employer" value="<?php if(!empty($salary_details->lwf_employer)){ echo $salary_details->lwf_employer;  } ?>" class="form-control" />

<input type="hidden" name="slab_id" id="salarySlab" value="<?php if(!empty($workers->slab_id)){ echo $workers->slab_id;  } ?>" class="form-control" />
        <div class="item form-group">
        <label class="col-md-3 col-sm-12 col-xs-12" for="plantLocation"> </label>
        <div class="col-md-6 col-sm-12 col-xs-12">
          <p style="color: red;" class="msgclass"></p>
          <?php if (!empty($salary_val->salary_details)){ ?>
          <input type="button" class="btn edit-end-btn updateforWorker" value="Update Salary Slab">
          <?php }else{ ?>
          <input type="button" class="btn edit-end-btn addmoreinfoWorker" value="Add Salary Slab">
        <?php } ?>
        </div>
        </div>
    </div>
    </div>
    
     
        <div id="salbedata"> </div> 
        <ul class="col-sm-12 col-xs-12">
    <?php  if (!empty($salary_val->slab_id!='0')) {  
   $salary_slabs = getNameById('salary_slab', $salary_val->slab_id??'', 'id');
   $slab_structure= json_decode($salary_slabs->slab_structure); 
   $total_sal=$salary_val->total;
      ?>
    <h4>Name:- <?php echo $name = getNameById('user_detail',$salary_val->emp_id, 'u_id')->name;?> </h4> <h4>Salary:- <?php echo $total_sal;?> </h4>
     <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>Basic</th>
                <th>Dearness Allowance</th>
                <th>HRA</th>
                <th>Conveyance Allowance</th>
                <th>Special Allowance</th>
                <th>Medical</th>
                <!-- <th>Incentives</th> -->
                <th>Others</th>
                <th>Gross Pay</th>

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <td><?php $basic=''; if(!empty($slab_structure->basic)){ echo $basic=$total_sal*$slab_structure->basic/100;}else{echo"0.00";} ?></td>
                 <td><?php $da=''; if(!empty($slab_structure->da)){ echo $da=$total_sal*$slab_structure->da/100;}else{echo"0.00";} ?></td>
                <td><?php $hra=''; if(!empty($slab_structure->hra)){ echo $hra=$total_sal*$slab_structure->hra/100;}else{echo"0.00";} ?></td>
                <td><?php $ca=''; if(!empty($slab_structure->ca)){ echo $ca=$total_sal*$slab_structure->ca/100;}else{echo"0.00";} ?></td>
                <td><?php $sa=''; if(!empty($slab_structure->sa)){ echo $sa=$total_sal*$slab_structure->sa/100;}else{echo"0.00";} ?></td>
                <td><?php $medical=''; if(!empty($slab_structure->medical)){ echo $medical=$total_sal*$slab_structure->medical/100;}else{echo"0.00";} ?></td> 
               <!--  <td><?php $incentive=''; if(!empty($slab_structure->incentive)){ echo $incentive=$total_sal*$slab_structure->incentive/100;}else{echo"0.00";} ?></td> -->
                <td><?php $others=''; if(!empty($slab_structure->others)){ echo $others=$total_sal*$slab_structure->others/100;}else{echo"0.00";} ?></td>                 
                <td><?php    echo $total= (float)$basic + (float)$hra + (float)$da + (float)$ca + (float)$sa +   (float)$medical+ (float)$others;  ?></td>

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employee Contribution </h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>TDS (Tax Deducted at Source)</th> 
                <th>LWF (Labour Welfare Fund)</th> 
                <th>Net Pay</th> 

            </tr>
        </thead>
        <tbody>
            <tr class="locRow"> 
                <td> <?php   
                $totalesi= (float)$basic + (float)$hra +(float)$da + (float)$ca + (float)$sa + (float)$medical+ (float)$others; 
                         $esic='';
                          if(!empty($slab_structure->esic)){ 
                            if ($totalesi) {
                                echo $esic=$totalesi*$slab_structure->esic/100;
                            }else{
                                 echo $esic="0.00";
                            }
                            }else{
                                echo $esic="0.00";
                            } ?>
                 </td>
                  <td> 
                          <?php 
                          $totalpf = (float)$basic;
                            $pf=''; 
                          if(!empty($slab_structure->pf)){
                            if ($totalpf){
                                echo $pf=$totalpf*$slab_structure->pf/100; 
                            }else{
                                echo $pf="0.00";
                            }
                            }else{
                               echo $pf="0.00";
                             } 
                            ?>
                 </td> 
                <td><?php  $tds='';if(!empty($slab_structure->tds)){ echo $tds=$total_sal*$slab_structure->tds/100;}else{echo"0.00";} ?>
                    
                </td> 
                <td><?php  $lwf=''; if(!empty($slab_structure->lwf)){ echo $lwf=$slab_structure->lwf;}else{echo"0.00";} ?></td> 
                <td><?php   $totalD=(float)$esic+(float)$pf+(float)$tds+(float)$lwf; 
                              echo $netpay=$total-$totalD?>
                </td> 

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employer Contribution</h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>LWF (Labour Welfare Fund)</th>
                <th>Total</th>  

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <?php $totalesi= (float)$basic + (float)$da + (float)$hra + (float)$ca + (float)$sa +  (float)$medical+ (float)$others;?>
                <td><?php $esic_employer=''; 
                  if(!empty($slab_structure->esic_employer)){
                    if ($totalesi) {
                         echo $esic_employer=$totalesi*$slab_structure->esic_employer/100;
                    }else{
                        echo $esic_employer="0.00";
                    }
                   }else{
                    echo $esic_employer="0.00";
                    }
                     ?></td>
                <td><?php $totalpf1= (float)$basic;
                   $pf_employer=''; 
                   if(!empty($slab_structure->pf_employer)){ 
                    if ($totalpf1) {
                       echo $pf_employer=$totalpf1*$slab_structure->pf_employer/100;
                    }else{
                      echo  $pf_employer="0.00";
                    }
                     }else{
                    echo $pf_employer="0.00";
                    } ?>
                 </td> 
                 <td><?php $slab_structure->lwf_employer==''; if(!empty($slab_structure->lwf_employer)){ echo $slab_structure->lwf_employer;}else{echo"0.00";} ?></td>
                <td><?php  echo $totlaE = (float)$esic_employer+(float)$pf_employer+(float)$slab_structure->lwf_employer;  ?></td> 
            </tr>
        </tbody>
    </table>
  <div  class="col-md-12 col-sm-12 col-xs-12">
        <div class="item form-group col-md-3 col-sm-12 col-xs-12">
         Gross Pay :- <?php echo $Gross= (float)$total;?> 
       
    </div>
     <div class="item form-group col-md-3 col-sm-12 col-xs-12">
         Net Pay :-  <?php echo $Net_Pay= (float)$netpay;?> 
 
    </div> 
    
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
          Employer Contribution :-  <?php echo $Employer_Contribution= (float)$totlaE;?> 
        
    </div>
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
          CTC :-  <?php  echo $CTC=(float)$netpay+(float)$Employer_Contribution?> 
        
    </div>
</div>
<?php } elseif ($salary_val->slab_id=='0') {  
  if(!empty($salary_val->salary_details)){ 
   $slab_structure = json_decode($salary_val->salary_details);   
  $total_sal=$salary_val->total;
      ?>
    <h4>Name:- <?php echo $name = getNameById('user_detail', $salary_val->emp_id, 'u_id')->name;?> </h4> <h4>Salary:- <?php if(!empty($salary_val->total)){ echo $salary_val->total; }?> </h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>Basic</th>
                <th>Dearness Allowance</th>
                <th>HRA</th>
                <th>Conveyance Allowance</th>
                <th>Special Allowance</th>
                <th>Medical</th>
                <!-- <th>Incentives</th> -->
                <th>Others</th>
                <th>Gross Pay</th>

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <td><?php $basic=''; if(!empty($slab_structure->basic)){ echo $basic=$total_sal*$slab_structure->basic/100;}else{echo"0.00";} ?></td>
                 <td><?php $da=''; if(!empty($slab_structure->da)){ echo $da=$total_sal*$slab_structure->da/100;}else{echo"0.00";} ?></td>
                <td><?php $hra=''; if(!empty($slab_structure->hra)){ echo $hra=$total_sal*$slab_structure->hra/100;}else{echo"0.00";} ?></td>
                <td><?php $ca=''; if(!empty($slab_structure->ca)){ echo $ca=$total_sal*$slab_structure->ca/100;}else{echo"0.00";} ?></td>
                <td><?php $sa=''; if(!empty($slab_structure->sa)){ echo $sa=$total_sal*$slab_structure->sa/100;}else{echo"0.00";} ?></td>
                <td><?php $medical=''; if(!empty($slab_structure->medical)){ echo $medical=$total_sal*$slab_structure->medical/100;}else{echo"0.00";} ?></td> 
               <!--  <td><?php $incentive=''; if(!empty($slab_structure->incentive)){ echo $incentive=$total_sal*$slab_structure->incentive/100;}else{echo"0.00";} ?></td> -->
                <td><?php $others=''; if(!empty($slab_structure->others)){ echo $others=$total_sal*$slab_structure->others/100;}else{echo"0.00";} ?></td>                 
                <td><?php    echo $total= (float)$basic + (float)$hra + (float)$da + (float)$ca + (float)$sa +   (float)$medical+ (float)$others;  ?></td>

            </tr>
        </tbody>
    </table>
     <h4 style="color: #140104db;" >Employee Contribution </h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>TDS (Tax Deducted at Source)</th> 
                <th>LWF (Labour Welfare Fund)</th> 
                <th>Net Pay</th> 

            </tr>
        </thead>
        <tbody>
            <tr class="locRow"> 
                <td> <?php   
                $totalesi= (float)$basic + (float)$hra +(float)$da + (float)$ca + (float)$sa + (float)$medical+ (float)$others; 
                         $esic='';
                          if(!empty($slab_structure->esic)){ 
                            if ($totalesi) {
                                echo $esic=$totalesi*$slab_structure->esic/100;
                            }else{
                                 echo $esic="0.00";
                            }
                            }else{
                                echo $esic="0.00";
                            } ?>
                 </td>
                  <td> 
                          <?php 
                          $totalpf = (float)$basic;
                            $pf=''; 
                          if(!empty($slab_structure->pf)){
                            if ($totalpf){
                                echo $pf=$totalpf*$slab_structure->pf/100; 
                            }else{
                                echo $pf="0.00";
                            }
                            }else{
                               echo $pf="0.00";
                             } 
                            ?>
                 </td> 
                <td><?php  $tds='';if(!empty($slab_structure->tds)){ echo $tds=$total_sal*$slab_structure->tds/100;}else{echo"0.00";} ?>
                    
                </td> 
                <td><?php  $lwf=''; if(!empty($slab_structure->lwf)){ echo $lwf=$slab_structure->lwf;}else{echo"0.00";} ?></td> 
                <td><?php   $totalD=(float)$esic+(float)$pf+(float)$tds+(float)$lwf; 
                              echo $netpay=$total-$totalD;?>
                </td> 

            </tr>
        </tbody>
    </table>
    <h4 style="color: #140104db;" >Employer Contribution</h4>
    <table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">
        <thead>
            <tr>
                <th>ESI (Employees State Insurance Corporation)</th>
                <th>EPF (Provident Fund )</th>
                <th>LWF (Labour Welfare Fund)</th>
                <th>Total</th>  

            </tr>
        </thead>
        <tbody>
            <tr class="locRow">
                <?php $totalesi1= (float)$basic + (float)$da + (float)$hra + (float)$ca + (float)$sa +  (float)$medical+ (float)$others;?>
                <td><?php $esic_employer=''; 
                  if(!empty($slab_structure->esic_employer)){
                    if ($totalesi1) {
                         echo $esic_employer=$totalesi1*$slab_structure->esic_employer/100;
                    }else{
                        echo $esic_employer="0.00";
                    }
                   }else{
                    echo $esic_employer="0.00";
                    }
                     ?></td>
                <td><?php $totalpf1= (float)$basic;
                   $pf_employer=''; 
                   if(!empty($slab_structure->pf_employer)){ 
                    if ($totalpf1) {
                       echo $pf_employer=$totalpf1*$slab_structure->pf_employer/100;
                    }else{
                      echo  $pf_employer="0.00";
                    }
                     }else{
                    echo $pf_employer="0.00";
                    } ?>
                 </td> 
                 <td><?php $slab_structure->lwf_employer==''; if(!empty($slab_structure->lwf_employer)){ echo $slab_structure->lwf_employer;}else{echo"0.00";} ?></td>
                <td><?php  echo $totlaE = (float)$esic_employer+(float)$pf_employer+(float)$slab_structure->lwf_employer;  ?></td> 
            </tr>
        </tbody>
    </table>
  <div  class="col-md-12 col-sm-12 col-xs-12">
        <div class="item form-group col-md-3 col-sm-12 col-xs-12">
         Gross Pay :- <?php echo $Gross= (float)$total;?> 
       
    </div>
     <div class="item form-group col-md-3 col-sm-12 col-xs-12">
         Net Pay :-  <?php echo $Net_Pay=number_format((float)$netpay,2);?> 
 
    </div> 
    
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
          Employer Contribution :-  <?php echo $Employer_Contribution= (float)$totlaE;?> 
        
    </div>
    <div class="item form-group col-md-3 col-sm-12 col-xs-12">
          CTC :-  <?php  echo $CTC=(float)$netpay+(float)$Employer_Contribution?> 
        
    </div>
</div>
<?php } } ?>
</ul>
</div>
<div class="modal-footer">  
    <!-- <input type="button" class="btn btn-default" value="Calculate"  id="salary_calculate" >   -->
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
<!-- <script>  $('#salary_calculate').trigger('click');</script> -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
           <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle">Worker Slab Details</h3>
            <button type="button" class="close CloseModel"  >
              <span aria-hidden="true">&times;</span>
            </button>
           </div> 
           <div class="modal-body">
             <div class="container">
             <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#menu2">Salary Slab With-Out %</a></li>
              <li><a data-toggle="tab" href="#menu3">Salary Slab With %</a></li>
            </ul>



            <div class="tab-content">
            <div id="menu2" class="tab-pane fade active in">
            <h3>Salary Slab With-Out %</h3>
             <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
         <div class="item form-group">
             <label class="col-md-3 col-sm-12 col-xs-12">Salary </label>
             <div class="col-md-6 col-sm-12 col-xs-12">
               <input required type="text" id="salaryOne" class="form-control" readonly="readonly"/>
            </div>
          </div>
            <div class="item form-group">
             <label class="col-md-3 col-sm-12 col-xs-12">Basic <span class="required">*</span></label>
             <div class="col-md-6 col-sm-12 col-xs-12">
               <input required type="text" name="basic" id="basicOne" maxlength="8" class="form-control" onkeyup="checkchargesworker()" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
            
        </div>
        <div id="da_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Dearness Allowance <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" id="daOne" name="da" value="" maxlength="8" class="form-control" onkeyup="checkchargesworker()" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">HRA <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" id="hraOne" name="hra" value="" maxlength="8" class="form-control" onkeyup="checkchargesworker()" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>

        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Conveyance Allowance <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="ca" id="caOne" value="" maxlength="8" class="form-control" onkeyup="checkchargesworker()" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Special Allowance <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="sa" id="saOne" value="" maxlength="8" class="form-control" onkeyup="checkchargesworker()" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div id="medical_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Medical <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="medical" id="medicalOne" maxlength="8" value="" onkeyup="checkchargesworker()" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
     <!-- <div class="item form-group">
         <label class="col-md-3 col-sm-12 col-xs-12 ">Incentives %</label>
         <div class="col-md-6 col-sm-12 col-xs-12"> 
         <input required type="text" name="incentive" id="incentive" value="<?php if(!empty($salary_details->incentive)){ echo $salary_details->incentive;  } ?>" onkeyup="checkchargesworker()" class="form-control">
          </div>
       </div>  -->

        <div id="others_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">Other <span class="required">*</span></label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input required type="text" name="others" id="othersOne" maxlength="8" value="" class="form-control" onkeyup="checkchargesworker()" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>

        <div class="item form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="col-md-3 col-sm-12 col-xs-12 ditect"> Employee Contribution</label>
            </div> 
        </div>
        <div id="esic_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">ESIC</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="esic" id="esicOne" maxlength="8" value="" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div id="tsd_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">TDS </label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="tds" id="tdsOne" maxlength="8" value="" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">EPF </label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="pf" id="pfOne" value="" maxlength="8" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">LWF (Labour Welfare Fund)</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="lwf" id="lwfOne" value="" maxlength="8" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div class="item form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="col-md-3 col-sm-12 col-xs-12 ditect">Employer Contribution</label>
            </div>
             
        </div>
        <div id="esic_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">ESIC</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="esic_employer" id="esic_employerOne" maxlength="8" value="" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">EPF </label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="pf_employer" maxlength="8" id="pf_employerOne" value="" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
        <div id="pf_div" class="item form-group">
            <label class="col-md-3 col-sm-12 col-xs-12">LWF (Labour Welfare Fund)</label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <input type="text" name="lwf_employer" maxlength="8" id="lwf_employerOne" value="" class="form-control" />
            </div>
            <a href="javascript:void(0);" class="btn  btn-delete  btn-xs" data-tooltip="Use With-Out %">?</a>
        </div>
    </div> 
            </div>
            <div id="menu3" class="tab-pane fade">
            <h3>Salary Slab With %</h3>
           
         <div class="col-md-12 col-sm-12 col-xs-12 vertical-border">
           <!--  <div class="item form-group">
             <label class="col-md-3 col-sm-12 col-xs-12">Salary </label>
             <div class="col-md-6 col-sm-12 col-xs-12">
               <input required type="text" id="salaryOne" class="form-control" readonly="readonly"/>
            </div>
          </div> -->
             <div class="item form-group">
                <label class="col-md-3 col-sm-12 col-xs-12" for="salary">Salary Slab in % <span class="required">*</span></label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  
                 <select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible salary_slab" name="slab_id" id="salarySlabPer" data-id="salary_slab" data-key="id" data-fieldname="slabname" data-where="created_by_cid = <?php echo $this->companyGroupId;?>  " width="100%" tabindex="-1" aria-hidden="true" required="required"  >
               <option value="">Select Option</option>
              
               <?php  foreach($salary_slab as $salary_slabidname){?>
                    <option value="<?php echo $salary_slabidname['id'];?>" <?php if(!empty($salary_val)){ if($salary_val->slab_id==$salary_slabidname['id']){echo 'Selected';}}?>>
                    <?php echo $salary_slabidname['slabname'];?></option>
                    <?php    } ?>
            </select> 
                </div>
              </div>
            </div> 
            </div>
            </div>
            </div>
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary CloseModel" >Close</button>
            <button type="button" class="btn btn-primary saveSlab">Save changes</button>
           </div>
        </div>
        </div>
      </div>