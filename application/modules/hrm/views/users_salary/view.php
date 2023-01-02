 


<ul class="col-sm-12 col-xs-12">
  <?php  if ($salary_val->slab_id!='0') {
   $salary_slabs = getNameById('salary_slab', $salary_val->slab_id, 'id');
  $slab_structure= json_decode($salary_slabs->slab_structure); 
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
                <?php $totalpf1= (float)$basic + (float)$da + (float)$hra + (float)$ca + (float)$sa +  (float)$medical+ (float)$others;?>
                <td><?php $esic_employer=''; 
                  if(!empty($slab_structure->esic_employer)){
                    if ($totalpf1) {
                         echo $esic_employer=$totalpf1*$slab_structure->esic_employer/100;
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
                <?php $totalpf1= (float)$basic + (float)$da + (float)$hra + (float)$ca + (float)$sa +  (float)$medical+ (float)$others;?>
                <td><?php $esic_employer=''; 
                  if(!empty($slab_structure->esic_employer)){
                    if ($totalpf1) {
                         echo $esic_employer=$totalpf1*$slab_structure->esic_employer/100;
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
<div class="modal-footer">                                       
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>