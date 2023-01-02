 <div class="row payslip_print" id="print_divv">
                    <div class="col-md-12">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-md-4 col-xs-6 col-sm-6">
                                 <!--   <img src="<?php echo base_url();?>assets/images/dri_Logo.png" style=" width:180px; margin-right: 10px;" />-->
                                </div>
                                <div class="col-md-8 col-xs-6 col-sm-6 text-left payslip_address">
                                    <p>
                                        Phone: <?php if(!empty($settingsvalue->contact_no)){ echo $settingsvalue->contact_no; }?>
                                    </p>
                                </div>
                               <?php   if(!empty($settingsvalue->address1)){
								   $rt = json_decode($settingsvalue->address1); ?>
            <?php  foreach($rt as $rr){?>



      <!--               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Street :</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
                                        <div><?php   echo $rr['address'];?></div>
                                    </div>
                    </div> 
                    
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">City :</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
                                        <div><?php if(!empty($rr) && $rr['city'] !=''  && $rr['city'] != 0) { 
                                        $city = getNameById('city',$rr['city'],'city_id'); 
                                        echo $city->city_name;} 
                                        
                                    ?></div>
                                    </div>
                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Zipcode / Postalcode :</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
                                        <div><?php if(!empty($rr)) echo $rr->postal_zipcode; ?></div>
                                    </div>
                    </div>  
                    
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">State/Province :</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
                                        <div><?php if(!empty($rr) && $rr->state !=''  && $rr->state != 0) { 
                                        $state = getNameById('state',$rr->state,'state_id'); 
                                        echo $state->state_name; 
                                        }
                                    ?></div>
                                    </div>
                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                     <label for="material">Country :</label>
                                    <div class="col-md-7 col-sm-12 col-xs-6 form-group">
                                        <div><?php if(!empty($rr) && $rr->country !=''   && $rr->country != 0) { 
                                        $country = getNameById('country',$rr->country,'country_id'); 
                                        echo $country->country_name; 
                                        }
                                    ?></div>
                                    </div>
                    </div> -->
                   <?php }} ?>             
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <h5 style="margin-top: 15px;">Payslip for the period of <?php echo $salary_info->month.' '.$salary_info->year ?></h5>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-md-12"><!-- 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php $obj_merged = (object) array_merge((array) $employee_info, (array) $salaryvaluebyid, (array) $salarypaybyid, (array) $salaryvalue, (array) $loanvaluebyid); print_r($obj_merged); ?>
                                            <?php print_r($otherInfo[0]); ?>
                                        </div>
                                    </div> -->
                                    <table class="table table-condensed borderless payslip_info">
                                        <tr>
                                            <td>Employee PIN</td>
                                    <td>: <?php if(isset($obj_merged->id)){echo "LSPL".$obj_merged->id; }?></td>
                                            <td>Employee Name</td>
                                            <td>: <?php  if(!empty($obj_merged->name)){echo $obj_merged->name; }?></td>
                                        </tr>
                                        <tr>
                                            <td>Department</td>
                                            <td>: </td>
                                            <td>Designation</td>
                                            <td>: <?php if(!empty($obj_merged->designation)){ echo $obj_merged->designation; }?></td>
                                        </tr>
                                        <tr>
                                            <td>Pay Date</td>
                                            <td>: <?php if(!empty($salary_info->paid_date)){ echo date('j F Y',strtotime($salary_info->paid_date)); }?></td>
                                            <td>Date of Joining</td>
                                            <td>: <?php if(!empty($obj_merged->date_joining)){ echo $obj_merged->date_joining; } ?></td>
                                        </tr>
                                        <tr>
                                            <td>Days Worked</td>
                                            <td>: 
                                                <?php
                                                   $days = ceil($salary_info->total_days / 8);
                                                   echo $days;
                                                ?>
                                            </td>
                                            <?php if(!empty($bankinfo->bank_name)){ ?>
                                            <td>Bank Name</td>
                                            <td>: <?php echo $bankinfo->bank_name; ?></td>
                                            <?php } else { ?>
                                            <td>Pay Type</td>
                                            <td>: <?php echo 'Hand Cash'; ?></td>
                                            <?php } ?>
                                        </tr>
                                        <?php if(!empty($bankinfo->bank_name)){ ?>
                                        <tr>
                                            <td>Account Name</td>
                                            <td>: <?php echo $bankinfo->holder_name; ?></td>
                                            <td>Account Number</td>
                                            <td>: <?php echo $bankinfo->account_number; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                            <style>
                                .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td { padding: 2px 5px; }
                            </style>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-condensed borderless" style="border-left: 1px solid #ececec;">
                                        <thead class="thead-light" style="border: 1px solid #ececec;">
                                            <tr>
                                                <th>Description</th>
                                                <th class="text-right">Earnings</th>
                                                <th class="text-right">Deductions</th>
                                            </tr>
                                        </thead>
                                        <tbody style="border: 1px solid #ececec;">
                                            <tr>
                                                <td>Basic Salary</td>
                                                <td class="text-right"><?php if(!empty($addition)){ echo $addition[0]->basic; }?> INR</td>
                                                <td class="text-right">  </td>
                                            </tr>
                                            <tr>
                                                <td>Madical Allowance</td>
                                                <td class="text-right"><?php if(!empty($addition)){ echo $addition[0]->medical; }?> INR</td>
                                                <td class="text-right">  </td>
                                            </tr>
                                            <tr>
                                                <td>House Rent</td>
                                                <td class="text-right"><?php if(!empty($addition)){ echo $addition[0]->house_rent; }?>  INR</td>
                                                <td class="text-right">  </td>
                                            </tr>
                                            <tr>
                                                <td>Conveyance Allowance</td>
                                                <td class="text-right"><?php if(!empty($addition)){ echo $addition[0]->conveyance; }?>  INR</td>
                                                <td class="text-right">  </td>
                                            </tr>
                                            <tr>
                                                <td>Bonus</td>
                                                <td class="text-right"><?php if(!empty($salary_info)){ echo $salary_info->bonus; }?></td>
                                                <td class="text-right"></td>
                                            </tr>
                                            <tr>
                                                <td>Loan</td>
                                                <td class="text-right"> </td>
                                                <td class="text-right"><?php if(!empty($salary_info->loan)) {
                                                    echo $salary_info->loan . " INR";
                                                } ?> </td>
                                            </tr>
                                            <tr>
                                                <td>Working Hour (<?php echo $salary_info->total_days; ?> hrs)</td>
                                                <td class="text-right">
                                                    <?php
                                                        if($a > 0) { echo round($a,2).' INR'; }
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                        if($d > 0) { echo round($d,2).' INR'; }
                                                    ?>        
                                                </td>
                                                <td class="text-right"> </td>
                                            </tr>
                                            <!--<tr>
                                                <td>Without Pay( <?php echo $work_h_diff ?> hrs)</td>
                                                <td class="text-right"> </td>
                                                <td class="text-right"> <?php
                                                        /*if($d > 0) { echo round($d,2).' INR'; }*/
                                                        echo $salary_info->diduction .'INR';
                                                    ?> </td>
                                                
                                            </tr>-->
                                            <tr>
                                                <td>Tax</td>
                                                <td class="text-right"> </td>
                                                <td class="text-right"> </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="tfoot-light">
                                            <tr>
                                                <th>Total</th>
                                                <th class="text-right"><?php $total_add = $salary_info->basic + $salary_info->medical + $salary_info->house_rent + $salary_info->bonus+$a; echo round($total_add,2); ?> INR</th>
                                                <th class="text-right"><?php $total_did = $salary_info->loan+$salary_info->diduction; echo round($total_did,2); ?> INR</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="text-right">Net Pay</th>
                                                <th class="text-right"><?php echo $salary_info->total_pay/*round($total_add - $total_did,2)*/; ?> INR</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div> 
                    </div>
                    <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                </div>                    