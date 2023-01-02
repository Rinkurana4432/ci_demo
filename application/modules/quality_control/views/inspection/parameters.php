   <div id="print_div_content">

      <table id="example" class="table table-striped table-bordered" border="1" cellpadding="3" data-order='[[1,"desc"]]'>

         <thead>

            <tr>

               <th>Sno.</th>

               <th>Parameters</th>

               <th>Instrument</th>

               <th>Uom</th>

               <th>Expectation</th>

               <th>Deviation minimum</th>

               <th>Deviation maximum</th>

               <th>Expectation with minimum Deviation</th>

               <th>Expectation with maximum Deviation</th>

               <th>Result</th>

               <th>Remark</th>

               <th>Pass/Fail</th>

            </tr>

         </thead>

         <tbody id="table_data">

            <?php  

            $j = 0;

            for ($i=1; $i <= 3 ; $i++) { ?>

            <tr>

               <td><?php echo $i; ?></td>

               <td>

                   <?php if( $view ){ 

                        echo $incTrans[$j]->parameter??'';

                   }else{ ?>

                        <input type="hidden" name="report[insc<?= $i ?>][transId]" value="<?= $incTrans[$j]->id??'' ?>">

                        <input type="text" name="report[insc<?= $i ?>][parameter]" style="width:80px" value="<?= $incTrans[$j]->parameter??'' ?>"/> 

                   <?php }?>

                  

               </td>

               <td>

                   <?php if( $view ){

                        foreach($ins as $value){

                          if( isset($incTrans[$j]->instrument) ){

                            if( $incTrans[$j]->instrument == $value['id'] )

                                echo $value['name'];

                          }

                                

                        }

                   }else{ ?>

                    

                    <select class="instrument  form-control selectAjaxOption select2 commanSelect2" name="report[insc<?= $i ?>][instrument]"  width="100%" id="instrument" data-id="instrument" data-key="id" data-fieldname="name" data-where="created_by_cid='<?php echo $_SESSION['loggedInUser']->c_id; ?>'" tabindex="-1" aria-hidden="true" >

                     <?php foreach($ins as $value){?>

                     <option value="<?= $value['id'] ?>"

                        <?php

                              if( isset($incTrans[$j]->instrument) ){

                                 if( $incTrans[$j]->instrument == $value['id'] )

                                 echo 'selected';

                              }



                         ?>

                     ><?php echo $value['name']; ?></option>

                     <?php }?> 

                  </select>

                   

                   <?php } ?>

                  

               </td>

               <td>

                   <?php if( $view ){

                    foreach($uom as $umoVal){

                      if( isset($incTrans[$j]->uom1) ){

                        if( $incTrans[$j]->uom1 == $umoVal->id )

                        echo $umoVal->uom_quantity;

                      }

                        

                    }

                   

                   }else{ ?>

                        <select class="uom  form-control selectAjaxOption select2 commanSelect2" name="report[insc<?= $i ?>][uom1]"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >

                     <option>Select</option>

                     <?php foreach($uom as $umoVal){?>

                     <option value="<?= $umoVal->id ?>"

                           <?php

                              if( isset($incTrans[$j]->uom1) ){

                                 if( $incTrans[$j]->uom1 == $umoVal->id )

                                 echo "selected";

                              }



                         ?>   

                     ><?php echo $umoVal->uom_quantity;?></option>

                     <?php }?>

                  </select> 

                   

                   <?php } ?>

                  

               </td>

               <td>

                   <?php 

                    if( $view ){

                        echo $incTrans[$j]->expectation??'';

                    }else{ ?>

                        <input type="number" class="exp" name="report[insc<?= $i ?>][expectation]" value="<?= $incTrans[$j]->expectation??'' ?>" style="width:70px" step="any" onkeyup="calculate(this)" onclick="calculate(this)" />      

                    <?php }

                   

                   ?>

                  

               </td>

               <td>

                    <?php 

                    if( $view ){

                        echo $incTrans[$j]->deviation_min??'';

                    }else{ ?>

                        <input type="number" class="min_dev" name="report[insc<?= $i ?>][deviation_min]" value="<?= $incTrans[$j]->deviation_min??'' ?>" style="width:70px" min="-0.1"step="any" onkeyup="calculate(this)" onclick="calculate(this)" />

                    <?php }

                   

                   ?>

                  

               </td>

               <td>

                    <?php 

                    if( $view ){

                        echo $incTrans[$j]->deviation_max??'';

                    }else{ ?>

                        <input type="number" class="max_dev" name="report[insc<?=$i ?>][deviation_max]" value="<?= $incTrans[$j]->deviation_max??'' ?>" style="width:70px" max="0.9" step="any" onkeyup="calculate(this)" onclick="calculate(this)" />

                    <?php }

                   

                   ?>

               </td>

               <td>

                    <?php 

                    if( $view ){

                        echo $incTrans[$j]->exp_min_dev??'';

                    }else{ ?>

                        <input type="number" class="exp_min_dev" name="report[insc<?= $i ?>][exp_min_dev]" value="<?= $incTrans[$j]->exp_min_dev??'' ?>" style="width:70px"  onkeyup="calculate(this)" onclick="calculate(this)"/>

                    <?php }

                   

                   ?>

                  

               </td>

               <td>

                    <?php 

                    if( $view ){

                        echo $incTrans[$j]->exp_max_dev??'';

                    }else{ ?>

                        <input type="number" class="exp_max_dev" name="report[insc<?= $i ?>][exp_max_dev]" value="<?= $incTrans[$j]->exp_max_dev??'' ?>" style="width:70px" onkeyup="calculate(this)" onclick="calculate(this)" />

                    <?php }

                   

                   ?>

                  

               </td>

               <td>

                <?php if($view){

                    echo $incTrans[$j]->result; 

                }else{ ?>

                   <input type="number" style="width:70px" value="<?= $incTrans[$j]->result??'' ?>" name="report[insc<?= $i ?>][result]" <?= ($view)?'readonly':''; ?>/>

                <?php } ?>   

                </td>

               <td>

                <?php if($view){

                    echo $incTrans[$j]->remark; 

                }else{ ?>

                    <input type="text" style="width:70px" value="<?= $incTrans[$j]->remark??'' ?>" name="report[insc<?= $i ?>][remark]" <?= ($view)?'readonly':''; ?>/>

                <?php } ?>

               </td>

               <td>

                  <select name="report[insc<?= $i ?>][pf]">

                     <option value="pass" 

                           <?php 

                              if( isset($incTrans[$j]->pf) ){

                                 if( $incTrans[$j]->pf == 'pass' ){

                                    echo 'selected';

                                 }

                              }



                           ?>

                     >Pass</option>

                     <option value="fail"

                      <?php 

                           if( isset($incTrans[$j]->pf) ){

                              if( $incTrans[$j]->pf == 'fail' ){

                                 echo 'selected';

                              }

                           }

                           ?>

                     >Fail</option>

                  </select>

               </td>

            </tr>

         <?php $j++; } ?>

         </tbody>

      </table>

   </div>