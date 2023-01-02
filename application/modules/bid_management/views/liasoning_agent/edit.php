<?php

	 $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;?>
	
	
	<div class="row">
		<div class="col-md-12">	
        	
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_liasoning_agent" enctype="multipart/form-data">
	<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <input type="hidden" name="id" id="id" value="<?php if(!empty($agent)) echo $agent->id; ?>">																		
<div class="container">
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" >Name</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="name" id="name" value="<?php if(!empty($agent)) echo $agent->name; ?>">
				</div>						
		</div>
	<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" >Phone no</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="number" class="form-control" name="phone" id="phone" value="<?php if(!empty($agent)) echo $agent->phone; ?>">
				</div>						
		</div>
		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Email</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="email" class="form-control" name="email" id="email" value="<?php if(!empty($agent)) echo $agent->email; ?>">
				</div>						
		</div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" >Agreement no<span class="required">*</span></label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="number" class="form-control" name="agreement_no" id="agreement_no" value="<?php if(!empty($agent)) echo $agent->agreement_no; ?>" required>
				</div>						
		</div>
		<div class="item form-group">
				<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Agreement Upload<span class="required">*</span></label>
					<div class="col-md-7 col-sm-9 col-xs-12">
				
                    <input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="agreement_upload" <?php if(isset($agent->agreement_upload)==''){?>required<?php }?> accept=".gif,.jpg,.png,.jpeg,.JPG,.txt,.doc,.pdf">
                    <input type="hidden" name="upload" value=" <?php if(!empty($agent)) echo $agent->agreement_upload; ?>" />
                    <?php if(!empty($agent)) echo $agent->agreement_upload; ?>
					</div>
				</div>
				<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Address</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<textarea rows="4" cols="60" name="address"><?php if(!empty($agent)) echo $agent->address; ?></textarea>
				</div>						
		</div>
		</div>
								<hr>							
<div class="bottom-bdr"></div>									
							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-12">
								<center>
			<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
			<button type="reset" class="btn btn-default">Reset</button>
			<input type="submit" class="btn edit-end-btn" value="Submit">
									</center>
								</div>
							</div>
                            </div>
						</form>	
					</div>
				</div>													
			</div>
	
