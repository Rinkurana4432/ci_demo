<form method="post" class="form-horizontal" enctype="multipart/form-data" id="ReportDetail" novalidate="novalidate" style="">
			<!--job card details-->
			<?php foreach($edit as $edit1){ ?>
	<input type="hidden" name="id" value="<?php echo $edit1->id;?>" />
<div class="col-md-12 col-sm-12 col-xs-12 ">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name 
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<?php echo $edit1->report_name; ?>
					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $edit1->observations; ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $edit1->per_lot_of; ?>
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php foreach($uom as $data){?>
		 <?php if($data->id==$edit1->uom){ echo $data->uom_quantity; }}?>
						</div>
				</div>
					<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						<label>Controlled</label>
						</div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel"  >
							<?php echo $edit1->saleorder; ?>
							    </div>
							<div class="col-md-3 col-sm-3 col-xs-6" id="ins_sel" disabled>
							   <?php $this->Quality_control_model->get_row_value('material','id',$edit1->material_id);?>
							    </div>
				</div>
                	<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">Comments</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
						<?php echo $edit1->comment; ?>
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
     <td><?php echo $val->parameter;?></td>
     <td><?php echo $val->instrument; ?></td> 
     <td><?php echo $val->uom1; ?></td> 
     <td><?php echo $val->expectation; ?></td> 
     <td><?php echo $val->deviation_min; ?></td>
     <td><?php echo $val->deviation_max; ?></td>
     <td><?php echo $val->exp_min_dev; ?></td>
      <td><?php echo $val->exp_max_dev; ?></td>
      <td><?php echo $val->result; ?></td>
      <td><?php echo $val->remark; ?></td>
      <td><select name="res" disabled><option value="pass" <?php if($val->pf=='pass'){echo 'Selected';}?>>Pass</option>
      <option value="fail" <?php if($val->pf=='fail'){echo 'Selected';}?>>Fail</option></select>
     </td>
    </tr> 
				   <?php $i++;}?>
  </tbody>     
		</table>
		<center>
		   <?php  $report=$this->Quality_control_model->get_row_value('controlled_report_trans','report_id',$edit1->id);?>
		
	<?php if($edit1->final_report=='2'){?><strong>Pass</strong><?php }?> 
    <?php if($edit1->final_report=='3'){?><strong>Fail</strong><?php }?> 

        </center>	
	</div>

	<center>
	    
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						</div>
	</center>
	<?php }?>
	</form>