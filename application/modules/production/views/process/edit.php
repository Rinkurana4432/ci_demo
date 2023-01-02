<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/saveAddProcess" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($process)) echo $process->id; ?>">
	   
	   <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class="item form-group">
		<label class="col-md-3 col-sm-12 col-xs-12">Process Type<span class="required" style="color:red;">*</span></label>
			<div class="col-md-6 col-sm-12 col-xs-12 ">
				<select class="form-control selectAjaxOption select2 select2-hidden-accessible processtype select2" name="process_type_id" data-id="process_type" data-key="id" data-fieldname="process_type" tabindex="-1" aria-hidden="true" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?>" required="required">
						<option value="">Select Option</option>
							<?php
								if(!empty($processType)){
								foreach($processType as $processtype){
								?>
								<option value="<?php echo $processtype['id']; ?>" <?php if(!empty($process) && $process->process_type_id== $processtype['id']) echo 'selected';?>><?php echo $processtype['process_type']; ?></option>
								<?php }}?>	
				</select>
			</div>
		</div>
		</div>
		<hr>
		<div class="bottom-bdr"></div>
		
			<?php if(empty($process)){ ?>
			<div class="item form-group blog-mdl" style="padding-bottom: 15px;">
			<div class="col-md-12 col-sm-12 col-xs-12 processDiv middle-box">
			     
			
				<div class="well " style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;" id="chkIndex_1">				
					<div class="col-md-4 col-sm-6 col-xs-12 form-group">
					  <label>Process name</label>
						<input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Process name" value="<?php if(!empty($process)) echo $process->process_name; ?>">
					</div>
                     <div class="col-md-8 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Description</label>
					 <textarea style="border-right: 1px solid #c1c1c1 !important;" id="description" rows="1" placeholder="Description" class="form-control col-md-7 col-xs-12 description" name="description[]"></textarea></div>					
						<div class="col-md-12 col-sm-12 btn-row"><div class="input-group-append">
							<button class="btn edit-end-btn addMoreProcess" type="button">Add</button>
						</div></div>
					
				</div>
			</div>
			<?php }else{ ?>
				<div class="col-md-12 col-sm-12 col-xs-12 processDiv middle-box">
                    <div class="well " style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;" >				
					<div class="col-md-4 col-sm-12 col-xs-12 form-group">
					      <label>Process name</label>
						<input type="text" id="processName" name="process_name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Process name" value="<?php if(!empty($process)) echo $process->process_name; ?>">
					</div>
                   <div class="col-md-8 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Description</label>
					 <textarea style="border-right: 1px solid #c1c1c1 !important;" id="description" rows="1" placeholder="Description" class="form-control col-md-7 col-xs-12 description" name="description"><?php if(!empty($process)) echo $process->description; ?></textarea></div>
                 </div>					 
			</div>
			<?php }			?>
			</div>
			
<hr>
				<div class="form-group">
					<div class="col-md-12 ">
					  <center>
						<button type="reset" class="btn btn-default">Reset</button>
						<button id="send" type="submit" class="add_process_btn btn btn-warning">Submit</button>
						<a class="btn btn-danger" onclick="location.href='<?php echo base_url();?>production/process'">Cancel</a>
						</center>
					</div>
				</div>
</form>