
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/savereport" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">

			<!--job card details-->
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name<span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<input id="para" class="form-control col-md-7 col-xs-12" name="report_name"  required="required" type="text" >		

					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation </label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input id="ins" class="form-control col-md-7 col-xs-12" name="observations"type="text" >
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="per_lot_of"   type="number" >
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							 <select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
							           <option>Select</option>
							       
							        </select>
						</div>
				</div>
					<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						<label><input name="report_chk" type="radio" value="manufacturing" onclick="chk_radio();">Manufacturing </label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
               <select class="jobcard  form-control selectAjaxOption select2" name="ins_val1"  width="100%" id="sel_ins1" data-id="job_card" data-key="job_card_no" data-fieldname="job_card_no" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" disabled="true" onchange="get_jobcard_process(this.value);">              
							
							           <option>Select</option>
							        <?php foreach($get_jobcard as $job){?>
			 <option value="<?php echo $job['job_card_no'];?>"><?php echo $job['job_card_no'];?></option>
							        <?php }?>
							        </select>
							    </div>
							    	<div class="col-md-3 col-sm-3 col-xs-6">
									<select name="ins_val2" class="form-control" id="sel_ins2" disabled="true">
							   
							        </select>
							    </div>
				</div>
                	<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						<label><input name="report_chk" type="radio" value="grn" onclick="chk_radio();">GRN
                        </label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
							<select class="materialNameId  form-control selectAjaxOption select2" required="required" name="sel_grn"  width="100%" id="sel_grn" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" disabled="true">
							           <option>Select</option>
							        <?php foreach($material as $data){?>
							        <option value="<?php echo $data['id'];?>"><?php echo $data['material_name'];?></option>
							        <?php }?>
							        </select>
							    </div>
				</div>
				<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						<label><input name="report_chk" type="radio" value="pid" onclick="chk_radio();">PDI</label>
						</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
					<select class="materialNameId  form-control selectAjaxOption select2" required="required" name="sel_pid"  width="100%" id="sel_pid" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1"  disabled="true">
							  
							          <option>Select</option>
							        <?php foreach($material as $data){?>
			 <option value="<?php echo $data['id'];?>"><?php echo $data['material_name'];?></option>
							        <?php }?>
							          </select>
							    </div>
				</div>	
</div>
						
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
	           <tbody>
    <tr>
     <td class="sno"><?php echo 1;?></td> 
     <td><input type="text" name="parameter[]"  style="width:70px"/></td>
     <td>
   <select class="instrument  form-control selectAjaxOption select2" name="instrument[]"  width="100%" id="instrument" data-id="instrument" data-key="id" data-fieldname="name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" ><?php foreach($ins as $val){?><option value="<?php echo $val['name'];?>"><?php echo $val['name'];?></option><?php }?> </select>
    </td> 
      <td>  <select class="uom  form-control selectAjaxOption select2" name="uom1[]"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
							           <option>Select</option>
							        <?php foreach($uom as $data){?>
							        <option value="<?php echo $data->uom_quantity;?>"><?php echo $data->uom_quantity;?></option>
							        <?php }?>
							        </select></td> 
     <td><input type="number" class="exp" name="exp[]"  style="width:70px" onkeyup="calculate(this)"  onclick="calculate(this)"/></td> 
     <td><input type="number" class="min_dev" name="min_dev[]" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"/></td> 
     <td><input type="number" class="max_dev" name="max_dev[]" style="width:70px" onkeyup="calculate(this)"  onclick="calculate(this)"/></td> 
     <td><input type="number" class="exp_min_dev" name="exp_min_dev[]" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td>
      <td><input type="number" class="exp_max_dev" name="exp_max_dev[]" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td>
      <td>	<button type="button" class="btn_danger" id="remove_row">x</button></td>
    </tr>
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

	</script>