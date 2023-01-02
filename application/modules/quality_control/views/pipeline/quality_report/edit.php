<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/updatereport" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
<?php foreach($edit as $edit1){?>
<div class="col-md-12 col-sm-12 col-xs-12">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name<span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<input id="name" class="form-control col-md-7 col-xs-12" name="report_name" value="<?php echo $edit1->report_name; ?>" required="required" type="text" >		
<input type="hidden" name="id" value="<?php echo $edit1->id; ?>"/>
					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input id="obv" class="form-control col-md-7 col-xs-12" name="observations" value="<?php echo $edit1->observations; ?>" type="text" >
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="per_lot_of" value="<?php echo $edit1->per_lot_of; ?>" type="number" >
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						 <select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' ||created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
							           <option>Select</option>
							        <?php foreach($uom as $data){?>
						<option value="<?php echo $data->id;?>" <?php if($data->id==$edit1->uom){echo 'Selected';}?>><?php echo $data->uom_quantity;?></option>
							        <?php }?>
							        </select>
						</div>
				</div>
					<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						  
						<label><input name="report_chk" type="radio" value="manufacturing" <?php if( $edit1->type=="manufacturing"){echo 'checked';}?> onclick="chk_radio();">Manufacturing</label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
							 <select class="jobcard  form-control selectAjaxOption select2" name="ins_val1"  width="100%" id="sel_ins1" data-id="job_card" data-key="job_card_no" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" disabled="true" > 
							       <option>Select</option>
							        <?php foreach($get_jobcard as $job){?>
			 <option value="<?php echo $job['job_card_no'];?>" <?php if($job['job_card_no']==$edit1->at){echo 'Selected';}?>><?php echo $job['job_card_no'];?></option>
							        <?php }?>
							        </select>
							    </div>
							    	<div class="col-md-3 col-sm-3 col-xs-6">
					  <select id="sel_ins2" class="form-control" name="ins_val2" disabled="true"> 					<?php $proc_nam = getNameById('add_process', $edit1->report_for,'id');?>
<option value="<?php echo $edit1->report_for;?>"><?php if(!empty($proc_nam)){echo $proc_nam->process_name;}?></option>
							         </select>
							    </div>
				</div>
    <div class="item form-group">
            <div class="col-md-3 col-sm-3 col-xs-6">
            <label><input name="report_chk" type="radio" value="grn"  onclick="chk_radio();" <?php if( $edit1->type=="grn"){echo 'checked';}?>>GRN</label>
            </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
           <select class="materialNameId  form-control selectAjaxOption select2" name="sel_grn"  width="100%" id="sel_grn" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" disabled="true">
		   <option value="">Select Option</option>
            <option>Select</option>
            <?php foreach($material as $data){?>
            <option value="<?php echo $data['id'];?>"<?php if($edit1->report_for==$data['id']){echo 'selected';}?>><?php echo $data['material_name'];?></option>
            <?php }?>
            </select>
        </div>	
    </div>	
        <div class="item form-group">
            <div class="col-md-3 col-sm-3 col-xs-6">
            <label><input name="report_chk" type="radio" value="pid" onclick="chk_radio();" <?php if( $edit1->type=="pid"){echo 'checked';}?>>PDI</label>
            </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
            <select class="materialNameId  form-control selectAjaxOption select2" name="sel_pid"  width="100%" id="sel_pid" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" disabled="true">
            <option>Select</option>
            <?php foreach($material as $data){?>
            <option value="<?php echo $data['id'];?>"<?php if($edit1->report_for==$data['id']){echo 'selected';}?>><?php echo $data['material_name'];?></option>
            <?php }?>
            </select>
        </div>	
    </div>
</div>						
<?php }?>

	<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<div id="print_div_content">  
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
	         <tbody id="table_data"><?php $i=1;foreach($edit_trans as $data){?>
    <tr>
     <td class="sno"><?php echo $i; ?></td> 
     <td><input type="text" name="parameter[]" value="<?php echo $data['parameter']; ?>"/></td>
     <td><select class="instrument  form-control selectAjaxOption select2" name="instrument[]"  width="100%" id="instrument" data-id="instrument" data-key="id" data-fieldname="name" data-where="created_by_cid='<?php echo $_SESSION['loggedInUser']->c_id; ?>'" tabindex="-1" aria-hidden="true" ><?php foreach($ins as $val){?>
     <option value="<?php echo $val['name'];?>"<?php if($val['name']==$data['instrument']){echo 'Selected';}?>><?php echo $val['name'];?></option><?php }?> </select></td> 
     <td><select class="uom  form-control selectAjaxOption select2" name="uom1[]"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" ><option>Select</option><?php foreach($uom as $val){?><option value="<?php echo $val->id;?>" <?php if($val->id==$data['uom1']){echo 'Selected';}?>><?php echo $val->uom_quantity;?></option><?php }?></select>
     </td> 
     <td><input type="number" class="exp" name="exp[]" value="<?php echo $data['expectation']; ?>" style="width:70px"  onkeyup="calculate(this)"/></td> 
     <td><input type="number" class="min_dev" name="min_dev[]" value="<?php echo $data['deviation_min']; ?>" style="width:70px" min="-0.1" onkeyup="calculate(this)"  onclick="calculate(this)"/></td> 
     <td><input type="number" class="max_dev" name="max_dev[]" value="<?php echo $data['deviation_max']; ?>" style="width:70px" max="0.9" onkeyup="calculate(this)"  onclick="calculate(this)"/></td> 
     <td><input type="number" class="exp_min_dev" name="exp_min_dev[]" value="<?php echo $data['exp_min_dev']; ?>" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td>
      <td><input type="number" class="exp_max_dev" name="exp_max_dev[]" value="<?php echo $data['exp_max_dev']; ?>" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td>
      <td><button type="button" class="btn_danger"  id="remove_row">x</button></td>
    </tr><?php $i++;}?>
  </tbody>     
		</table>
	<div class="col-sm-12 btn-row"><button style="margin-top: 22px;" class="btn edit-end-btn addMoreButton " type="button" align="right">Add</button></div>
	</div>
	<center>
	    
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						  <input type="submit" class="btn btn edit-end-btn " value="Submit">
						</div>
	</center>
	</form>
	<script>
	$('input[name="report_chk"]').is(':checked')
       {
        var radioValue = $("input[name='report_chk']:checked").val();
        if(radioValue == "manufacturing"){
			$("#sel_ins1").prop("disabled", false );
			$("#sel_ins2").prop("disabled", false );
			$("#sel_grn").val("");
			$("#sel_pid").val("");
			} 
			else if(radioValue == "grn")
			{
			$("#sel_pid").val("");
			$("#sel_ins1").val("");
			$("#sel_ins2").val("");
			$("#sel_grn").prop("disabled", false );

			} else{
			$("#sel_pid").prop("disabled", false );
			$("#sel_grn").val("");
			$("#sel_ins1").val("");
			$("#sel_ins2").val("");
		}
       }
	   var i=2;
$('#addRow').click(function () { 
var str ='<tr><td class="sno">'+i+'</td><td><input type="text" style="width:70px"  name="parameter[]"/></td><td><select class="form-control" name="instrument[]"><?php foreach($ins as $val){?><option><?php echo $val['name'];?></option><?php }?></select></td><td><select class="form-control" name="uom1[]"><option>Select</option><?php foreach($uom as $data){?><option value="<?php echo $data->uom_quantity;?>"><?php echo $data->uom_quantity;?></option><?php }?></select></td><td><input type="number" class="exp" name="exp[]" style="width:70px" onkeyup ="calculate(this)"  onclick="calculate(this)" step="any"/></td><td><input type="number" class="min_dev" name="min_dev[]" style="width:70px" min="-0.1" onkeyup="calculate(this)"  onclick="calculate(this)"step="any"/></td><td><input type="number" class="max_dev" name="max_dev[]" style="width:70px" max="0.9" onkeyup="calculate(this)"  onclick="calculate(this)"step="any"/></td><td><input type="number" class="exp_min_dev"  name="exp_min_dev[]" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)" readonly/></td><td><input type="number" class="exp_max_dev" name="exp_max_dev[]" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td><td><button type="button" class="btn_danger"  id="remove_row">x</button></td></tr>';
i++; $("#example tbody").append(str);
if($('table tr').length>1) {
$(this).closest('tr').remove();
$('td.sno').text(function (i) {
  return i + 1;
});
}
});
	</script>