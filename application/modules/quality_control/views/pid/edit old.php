<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>quality_control/save_pid_report" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
<div role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#controlled_report" id="controlled_tab" role="tab" data-toggle="tab" aria-expanded="true">Report</a></li>
				<li role="presentation" class="inspection "><a href="#product" role="tab" data-toggle="tab" id="inspection_tab" aria-expanded="false">Product</a></li>
			</ul>
<div id="myTabContent" class="tab-content">
  <div role="tabpanel" class="tab-pane fade active in" id="controlled_report" aria-labelledby="controlled_tab">
			<!--job card details-->
<input type="hidden" name="id" value="<?php if(!empty($pid)){echo $pid->id;};?>" />
<div class="col-md-12 col-sm-12 col-xs-12">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name <span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<input id="para" class="form-control col-md-7 col-xs-12" name="report_name"  required="required" type="text" value="<?php  if(!empty($pid)){echo $pid->report_name;};?>">	</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input id="ins" class="form-control col-md-7 col-xs-12" name="observations"  type="number" value="<?php  if(!empty($pid)){echo $pid->observations;};?>">
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control col-md-7 col-xs-12" name="per_lot_of" value="<?php  if(!empty($pid)){echo $pid->per_lot_of;};?>"  type="number" >
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					 <select class="uom  form-control selectAjaxOption select2" name="uom"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid='0' ||created_by_cid=<?php echo $this->companyGroupId; ?>" tabindex="-1" aria-hidden="true" >
						<option>Select</option>
						<?php foreach($uom as $data){?>
						<option value="<?php echo $data->id;?>" <?php  if(!empty($pid)){if($pid->uom==$data->id){echo 'Selected';}}?>><?php echo $data->uom_quantity;?></option><?php }?>
						</select>
						</div>
				</div>
					<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
			 <input type="hidden" name="saleorder" value="pid"/>
						<label>PDI</label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
                            <select class="materialNameId  form-control selectAjaxOption select2" required="required" name="material_id"  width="100%" id="sel_con1" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $this->companyGroupId; ?> OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="get_material_table_values();get_product_qty();get_material_name()">
				<option value="">Select Material</option>
                <?php foreach($material as $material_name){?>
          <option value="<?php echo $material_name['id'];?>" <?php  if(!empty($pid)){if($pid->material_id==$material_name['id']){echo 'Selected';}}?>><?php echo $material_name['material_name'];?></option>
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
  <?php if(!empty($pid_trans)){$i=1;foreach($pid_trans as $trans_data){?>
  <tr>
     <td><?php echo $i;?></td> 
     <td><?php echo $trans_data['parameter'];?></td>
     <td><?php echo $trans_data['instrument']; ?></td> 
     <td><?php echo $trans_data['uom1'];?></td> 
	 <td><input type="number" class="exp" name="exp[]" value="<?php echo $trans_data['expectation']; ?>" style="width:70px" step="any" readonly/></td> 
     <td><input type="number" class="min_dev" name="min_dev[]" value="<?php echo $trans_data['deviation_min']; ?>" style="width:70px" min="-0.1"step="any"/></td>
     <td><input type="number" class="max_dev" name="max_dev[]" value="<?php echo $trans_data['deviation_max']; ?>" style="width:70px" max="0.9" step="any"/></td>
     <td><input type="number" class="exp_min_dev" name="exp_min_dev[]" value="<?php echo $trans_data['exp_min_dev']; ?>" style="width:70px" readonly/></td>
      <td><input type="number" class="exp_max_dev" name="exp_max_dev[]" value="<?php echo $trans_data['exp_max_dev']; ?>" style="width:70px" readonly/></td>
      <td><input type="number" style="width:70px" value="<?php echo $trans_data['result']; ?>" name="result[]"/></td>
      <td><input type="text" style="width:70px" value="<?php echo $trans_data['remark']; ?>" name="remark[]"/></td>
      <td><select name="res[]"><option value="pass" <?php if($trans_data['pf']=='pass'){echo 'Selected';}?>>Pass</option>
      <option value="fail" <?php if($trans_data['pf']=='fail'){echo 'Selected';}?>>Fail</option></select>
     </td>
    </tr> 
  <?php $i++; }} ?>
  </tbody>     
		</table>
		<center>
		<label for="pass" class="btn edit-end-btn">
	<input type="radio" name="final_report" id="pass" value="2" checked/>  
Pass</label>
	<label for="fail"  class="btn edit-end-btn">
	<input type="radio" name="final_report" id="fail" value="3"/>  
Fail</label>
</center>
	</div>
	<center>
	    <div class="modal-footer">
			 <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>	
			 <input type="submit" class="btn btn edit-end-btn " value="Submit">
		</div>
	</center>
	</div>
	<div role="tabpanel" class="tab-pane fade" id="product" aria-labelledby="controlled_tab">
	<div id="print_div_content">  
	<table id="" class="table table-striped table-bordered" border="1" cellpadding="3">
		<thead>
			<tr>
			    <th>Product</th>
			    <th>Total Qty</th>
				<th>Qty Passed</th>
				<th>Qty Rejected</th>
				<th>Rework Qty</th>
			</tr>
		</thead>
	           <tbody>
				   <tr>
					   <td><div id="material_name"></div></td>
					   <td><input type="number" name="tot_qty" id="tot_qty" readonly="readonly"/></td>
					   <td><input type="number" name="qty_pass" id="qty_pass" onblur="chk_qty()" required="required"/></td>
					   <td><input type="number" name="qty_reject" id="qty_reject" onblur="chk_qty()"  required="required"/></td>
					   <td><input type="number" name="qty_rework" id="qty_rework" onblur="chk_qty()" required="required"/></td>
				   </tr>
			   </tbody>
     </table>
	</div>
	</div>
	</form>
                        