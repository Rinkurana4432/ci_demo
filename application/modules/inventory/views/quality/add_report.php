<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/inventoryQualityReport" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
   <!--job card details-->
   <input type="hidden" name="reportId" value="<?= $result['crmId']??'' ?>" />
   <div class="col-md-12 col-sm-12 col-xs-12 ">
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name<span class="required">*</span>
         </label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input id="para" class="form-control col-md-7 col-xs-12" name="report_name" value="<?= $result['report_name']??'' ?>"  type="text" >
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation <span class="required">*</span> </label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input id="ins" class="form-control col-md-7 col-xs-12" value="<?= $result['observations']??'' ?>" name="observations"type="text" required="required" >
         </div>
      </div>
      <div class="item form-group">
         <label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation <span class="required">*</span></label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <input class="form-control col-md-7 col-xs-12" name="per_lot_of" value="<?= $result['per_lot_of']??'' ?>"  type="number" required="required" >
         </div>
         <label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
         <div class="col-md-3 col-sm-3 col-xs-6">
            <select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid=<?= $_SESSION['loggedInCompany']->c_id; ?> and active_inactive=1" tabindex="-1" aria-hidden="true" >
                <?php if( isset($result['uom']) && !empty($result['uom']) ){ ?>
                    <option value="<?php echo $result['uom'];?>"><?= getSingleAndWhere('uom_quantity','uom',['id' => $result['uom'] ]); ?>
                    </option>
                <?php } ?>
            </select>
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label><input name="report_chk" <?php if( $result['type'] == 'grn' ) echo 'checked'; ?> type="radio" value="grn" onclick="chk_radio();">GRN
            </label>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-6">
             <input type="text" value="<?= $result['material_name'] ?>"  class="form-control" readonly />
             <input type="hidden" value="<?= $result['matId'] ?>" class="form-control" />
         </div>
      </div>
      <div class="item form-group">
         <div class="col-md-3 col-sm-3 col-xs-6">
            <label><input name="report_chk" <?php if( $result['type'] == 'pdi' ) echo 'checked'; ?> type="radio" value="pid" onclick="chk_radio();">PDI</label>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-6">
             <input type="text" value="<?= $result['material_name'] ?>" readonly  class="form-control" />
             <input type="hidden" name="matId" value="<?= $result['matId'] ?>" class="form-control" />
         </div>
      </div>
   </div>
   <input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
   <div id="print_div_content" style="position: relative;padding-bottom: 35px;">
      <table id="example" class="table table-striped table-bordered" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
         <thead>
            <tr>
               <th>Sno.</th>
               <th>Parameters</th>
               <th>Instrument</th>
               <th>uom</th>
               <th>Expectation</th>
               <th>Deviation minimum</th>
               <th>Deviation maximum</th>
               <th>Expectation with minimum Deviation</th>
               <th>Expectation with maximum Deviation</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
             <?php
                if( empty($parameterData) ){
                    $parameterData = [''];
                }
                $i = 1;
                foreach ($parameterData as $key => $value) { ?>


            <tr>
               <td class="sno"><?php echo $i;?></td>
               <td><input type="text" name="report[<?= $i ?>][parameter]"  value="<?= $value['parameter']??'' ?>" style="width:70px"/></td>
               <td>
                  <select class="instrument  form-control selectAjaxOption select2" name="report[<?= $i ?>][instrument]"  width="100%" id="instrument" data-id="instrument" data-key="id" data-fieldname="name" data-where="created_by_cid=<?= $_SESSION['loggedInCompany']->c_id; ?>" tabindex="-1" aria-hidden="true" >
                     <?php if( isset($value['instrument']) && !empty($value['instrument']) ){ ?>
                         <option selected value="<?php echo $value['instrument'];?>"><?= getSingleAndWhere('name','instrument',['id' => $value['instrument'] ]); ?>
                         </option>
                     <?php } ?>
                  </select>
               </td>
               <td>
                  <select class="uom  form-control selectAjaxOption select2" name="report[<?= $i ?>][uom1]"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid=<?= $_SESSION['loggedInCompany']->c_id; ?> and active_inactive=1" tabindex="-1" aria-hidden="true" >
                     <?php if( isset($value['uom1']) && !empty($value['uom1']) ){ ?>
                         <option value="<?php echo $value['uom1'];?>"><?= getSingleAndWhere('uom_quantity','uom',['id' => $value['uom1'] ]); ?>
                         </option>
                     <?php } ?>

                  </select>
               </td>
               <td><input type="number" class="exp" name="report[<?= $i ?>][expectation]" value="<?= $value['expectation']??'' ?>"  style="width:70px" onkeyup="calculate(this)"  onclick="calculate(this)"/></td>
               <td><input type="number" class="min_dev" name="report[<?= $i ?>][deviation_min]" value="<?= $value['deviation_min']??'' ?>"  style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"/></td>
               <td><input type="number" class="max_dev" name="report[<?= $i ?>][deviation_max]" value="<?= $value['deviation_max']??'' ?>" style="width:70px" onkeyup="calculate(this)"  onclick="calculate(this)"/></td>
               <td><input type="number" class="exp_min_dev" name="report[<?= $i ?>][exp_min_dev]" value="<?= $value['exp_min_dev']??'' ?>" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td>
               <td><input type="number" class="exp_max_dev" name="report[<?= $i ?>][exp_max_dev]" value="<?= $value['exp_max_dev']??'' ?>"  style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td>
               <td>	<button type="button" class="btn_danger" id="remove_row">x</button></td>
            </tr>
        <?php $i++; } ?>
         </tbody>
      </table>
      <input type="hidden" id="inctr" value="<?= $i ?>">
      <div class="col-sm-12 btn-row" style="bottom: 0px"><button style="margin-top: 22px;" class="btn edit-end-btn addMoreButton " type="button" align="right">Add</button></div>
   </div>
   <center>
      <div class="modal-footer">
         <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>
         <input type="submit" class="btn btn edit-end-btn " value="Submit">
      </div>
   </center>
</form>
<script>
function calculate(clrt){
    var exp=$(clrt).parents("tr").find(".exp").val();
    var min_dev=$(clrt).parents("tr").find(".min_dev").val();
	var max_dev=$(clrt).parents("tr").find(".max_dev").val();
    if(exp===''){
        exp=0;
    }
    if(min_dev===''){
        min_dev=0;
    }
    if(max_dev===''){
        max_dev=0;
    }
	var cal_min_dev=exp-min_dev;
	var cal_max_dev=parseFloat(exp)+parseFloat(max_dev);
	$(clrt).parents("tr").find(".exp_min_dev").val(cal_min_dev);
    $(clrt).parents("tr").find(".exp_max_dev").val(cal_max_dev);
}
</script>
