
<form class="form-horizontal"  id="ReportDetail" novalidate="novalidate" style="">
<?php foreach($edit as $edit1){
?>
			<!--job card details-->
<div class="col-md-12 col-sm-12 col-xs-12">				
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="parameter">Report Name<span class="required">*</span>
					</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
				<?php echo $edit1->report_name; ?>	
<input type="hidden" name="id" value="<?php echo $edit1->id; ?>"/>
					</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="instrument">No. of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php echo $edit1->observations; ?>
						</div>
				</div>
				<div class="item form-group">
					<label class="col-md-3 col-sm-3 col-xs-12" for="expectation">Per Lot Of Observation</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
					<?php echo $edit1->per_lot_of; ?>
						</div>
							<label class="col-md-1 col-sm-3 col-xs-12" for="expectation">UOM</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
				 <?php foreach($uom as $data){ if($data->id==$edit1->uom){echo  $data->uom_quantity;} }?>
						</div>
				</div>
				<div class="item form-group">
				
						<div class="col-md-3 col-sm-3 col-xs-6">
						  
						<label>Manufacturing</label>
						</div><div class="col-md-3 col-sm-3 col-xs-6">
							 <?php echo $edit1->at;?>
							       
							     </div>
							    	<div class="col-md-3 col-sm-3 col-xs-6">
					  <?php 
					  $proc_nam = getNameById('add_process', $edit1->report_for,'id');
					  if(!empty($proc_nam)){echo $proc_nam->process_name;}?>
							        
							    </div>
				</div>
    <div class="item form-group">
            <div class="col-md-3 col-sm-3 col-xs-6">
            <label>GRN</label>
            </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
            
            <?php if($edit1->type=='grn'){ foreach($material as $data){?>
           <?php if($edit1->report_for==$data['id']){echo $data['material_name'];}?>
            <?php }}?>
           
        </div>	
    </div>	
 <div class="item form-group">
            <div class="col-md-3 col-sm-3 col-xs-6">
            <label>PDI</label>
            </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
            
            <?php  if($edit1->type=='pid'){
				foreach($material as $data){?>
            <?php if($edit1->report_for==$data['id']){echo $data['material_name'];}?>
            <?php }}?>
           
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
			</tr>
		</thead>
	         <tbody id="table_data"><?php $i=1;foreach($edit_trans as $data){?>
    <tr>
     <td><?php echo $i; ?></td> 
     <td><?php echo $data['parameter']; ?></td>
     <td><?php echo $data['instrument']; ?></td> 
      <td><?php foreach($uom as $val){if($val->id==$data['uom1']){echo $val->uom_quantity;}}?></td> 
     <td><?php echo $data['expectation']; ?></td> 
     <td><?php echo $data['deviation_min']; ?></td> 
     <td><?php echo $data['deviation_max']; ?></td> 
     <td><?php echo $data['exp_min_dev']; ?></td>
      <td><?php echo $data['exp_max_dev']; ?></td>
    </tr><?php $i++;}?>
  </tbody>     
		</table>
	</div>
	<center>
	    
	    	<div class="modal-footer">
						  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
						
						</div>
	</center>
	</form>