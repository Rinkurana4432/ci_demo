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
            <?php 
               if( isset($grn->observations) ){ 
                     for ($i=1; $i <= $grn->observations; $i++) { ?>
                        <th>Obs <?= $i; ?></th>
               <?php }
               }  ?>
            <th>Avg</th>
            <th>Pass/Fail</th>
         </tr>
      </thead>
      <tbody id="table_data">
         <?php $i=1;foreach($grn_trans as $key => $trans_data){?>
         <tr>
            <input name="report[create<?= $i ?>][parameter]" value="<?php echo $trans_data['parameter']; ?>" type="hidden">
            <input type="hidden" name="report[create<?= $i ?>][instrument]" value="<?php echo $trans_data['instrument']; ?>"/>
            <input type="hidden" name="report[create<?= $i ?>][uom1]" value="<?php echo $trans_data['uom1']; ?>"/>
            <td><?php echo $i;?></td>
            <td><?php echo $trans_data['parameter'];?></td>
            <td><?php echo $trans_data['instrument']; ?></td>
            <td><?php echo $trans_data['uom1'];?></td>
            <td>
               <input type="hidden" name="trnsId" value="<?= $trans_data['id'] ?>">
               <input type="number" class="exp" name="report[create<?= $i ?>][expectation]" value="<?php echo $trans_data['expectation']; ?>" style="width:70px" step="any" readonly/></td>
            <td><input type="number" class="min_dev" name="report[create<?= $i ?>][deviation_min]" value="<?php echo $trans_data['deviation_min']; ?>" style="width:70px" min="-0.1"step="any"/></td>
            <td><input type="number" class="max_dev" name="report[create<?= $i ?>][deviation_max]" value="<?php echo $trans_data['deviation_max']; ?>" style="width:70px" max="0.9" step="any"/></td>
            <td><input type="number" class="exp_min_dev" name="report[create<?= $i ?>][exp_min_dev]" value="<?php echo $trans_data['exp_min_dev']; ?>" style="width:70px" readonly/></td>
            <td><input type="number" class="exp_max_dev" name="report[create<?= $i ?>][exp_max_dev]" value="<?php echo $trans_data['exp_max_dev']; ?>" style="width:70px" readonly/></td>
            <td><input type="number" style="width:70px" value="<?php echo $trans_data['result']??''; ?>" name="report[create<?= $i ?>][result]"/></td>
            <td><input type="text" style="width:70px" value="<?php echo $trans_data['remark']??''; ?>" name="report[create<?= $i ?>][remark]"/></td>
            <?php 

            if( isset($trans_data['coils']) ){
               $obs = json_decode($trans_data['coils']);
            }

            if( $grn->observations ){ 
                  for ($j=1; $j <= $grn->observations ; $j++) { ?>
                     <td>
                        <input type="number" class="form-group obsInput obs<?= $trans_data['id'] ?>" data-unique="<?= $trans_data['id'] ?>" 
                        name="report[create<?= $i ?>][obs][obs_<?= $j; ?>]" 
                        value="<?php $obsSr = "obs_{$j}"; echo $obs->$obsSr??''; ?>" style="width:70px" />
                     </td>
            <?php }
            }  ?> 
            <td>
               <input type="number" class="obsAvg" id="obsAvg<?= $trans_data['id'] ?>" name="report[create<?= $i ?>][avg]" value="<?= $trans_data['avg']??'' ?>" style="width:70px" readonly />
            </td>
            <td>
               <select name="report[create<?= $i ?>][pf]">
                  <option value="pass" <?php if(@$trans_data['pf']=='pass'){echo 'Selected';}?>>Pass</option>
                  <option value="fail" <?php if(@$trans_data['pf']=='fail'){echo 'Selected';}?>>Fail</option>
               </select>
            </td>
         </tr>
         <?php $i++; } ?>
      </tbody>
   </table>
   <center>
      <label for="pass" class="btn edit-end-btn">
      <input type="radio" name="final_report" id="pass" value="1" <?php if( isset($grn->final_report) ) if( $grn->final_report  == 1 )echo "checked"; ?> />  
      Pass</label>
      <label for="fail"  class="btn edit-end-btn">
      <input type="radio" name="final_report" id="fail" value="2" <?php if( isset($grn->final_report) ) if( $grn->final_report  == 2 )echo "checked"; ?> />  
      Fail</label>
   </center>
</div>