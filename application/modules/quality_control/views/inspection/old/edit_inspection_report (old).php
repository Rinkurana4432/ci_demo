
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/update_inspection_report" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
			<!--job card details-->
			<?php foreach($edit as $edit1){ ?>
	<input type="hidden" name="id" value="<?php echo $edit1->id;?>" />
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<input id="para" class="form-control col-md-7 col-xs-12" name="report_name" value="<?php echo $edit1->report_name; ?>"  type="text" required>		

					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input id="ins" class="form-control col-md-7 col-xs-12" name="observations"  value="<?php echo $edit1->observations; ?>"  type="number" >
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="per_lot_of" value="<?php echo $edit1->per_lot_of; ?>"  type="number" >
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' || created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
						<option>Select</option>
						<?php foreach($uom as $data){?>
						<option value="<?php echo $data->id;?>" <?php if($data->id==$edit1->uom){echo 'Selected';}?>><?php echo $data->uom_quantity;?></option><?php }?>
						</select>
						</div>
				</div>
					<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						<label>Manufacturing</label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
							  <select class="workorder  form-control selectAjaxOption select2" name="workorder_id"  width="100%" id="sale_order" data-id="work_order" data-key="id" data-fieldname="workorder_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
							           <option>Select</option>
							        <?php foreach($get_workorder as $work){?>
		      <option value="<?php echo $work['id'];?>" <?php if($work['id']==$edit1->workorder_id){echo 'Selected';}?>>
							         <?php echo $work['workorder_name'];?></option>
							        <?php }?>
							        </select>
							    </div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
							    <select id="sel_job" class="form-control " name="job_card">
                  <option value="<?php echo $edit1->job_card;?>"><?php echo $edit1->job_card;?></option>
							     </select>
							    </div>
							    	<div class="col-md-3 col-sm-3 col-xs-6">
	 <select id="sel_process" class="form-control" name="process_id" onchange="get_table_data()">
	 	<?php $proc_nam = getNameById('add_process', $edit1->process_id,'id');?>
<option value="<?php echo $edit1->process_id;?>"><?php if(!empty($proc_nam)){ echo $proc_nam->process_name;}?></option>
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
	               <?php $i=1;foreach($trans as $val){?>
  <tr>
     <td><?php echo $i; ?></td> 
     <td><input type="text" name="parameter[]" style="width:80px" value="<?php echo $val->parameter;?>"readonly/></td>
     <td><input type="text" name="instrument[]" style="width:80px" value="<?php echo $val->instrument; ?>"readonly/></td> 
     <td><input type="text" name="uom1[]" style="width:70px" value="<?php echo $val->uom1; ?>" readonly/></td> 
     <td><input type="number" class="exp" name="exp[]" value="<?php echo $val->expectation; ?>" style="width:70px" step="any" readonly/></td> 
     <td><input type="number" class="min_dev" name="min_dev[]" value="<?php echo $val->deviation_min; ?>" style="width:70px" min="-0.1"step="any"/></td>
     <td><input type="number" class="max_dev" name="max_dev[]" value="<?php echo $val->deviation_max; ?>" style="width:70px" max="0.9" step="any"/></td>
     <td><input type="number" class="exp_min_dev" name="exp_min_dev[]" value="<?php echo $val->exp_min_dev; ?>" style="width:70px" readonly/></td>
      <td><input type="number" class="exp_max_dev" name="exp_max_dev[]" value="<?php echo $val->exp_max_dev; ?>" style="width:70px" readonly/></td>
      <td><input type="number" style="width:70px" value="<?php echo $val->result; ?>" name="result[]"/></td>
      <td><input type="text" style="width:70px" value="<?php echo $val->remark; ?>" name="remark[]"/></td>
      <td><select name="res[]">
      <option value="pass" <?php if($val->pf=='pass'){echo 'Selected';}?>>Pass</option>
      <option value="fail" <?php if($val->pf=='fail'){echo 'Selected';}?>>Fail</option>
      </select>
     </td>
    </tr> 
				   <?php $i++;}?>
  </tbody>     
		</table>
		<center>
		<label for="pass" class="btn edit-end-btn">
	<input type="radio" name="final_report" id="pass" value="2" <?php if($edit1->final_report=='2'){echo 'checked';}?>/>Pass</label>
	<label for="fail"  class="btn edit-end-btn">
	<input type="radio" name="final_report" id="fail" value="3" <?php if($edit1->final_report=='3'){echo 'checked';}?>/>Fail</label>
        </center>
	</div>
	<center>
	    
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						  <input type="submit" class="btn btn edit-end-btn " value="Submit">
						</div>
	</center>
	<?php }?>
	</form>


                        