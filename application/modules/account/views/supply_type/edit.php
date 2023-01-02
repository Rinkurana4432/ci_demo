					  
			<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveSupply_type" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($supply_type)) echo $supply_type->id; ?>">
					<div class=" panel-default">
						
						<h3 class="Material-head">Information <hr></h3>
						<div class="col-md-12 col-xs-12 col-sm-12 vertical-border ">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Supply Type Name<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="supply_type_name" name="supply_type_name" required="required" data-validate-length-range="4"  class="form-control col-md-7 col-xs-12" placeholder="Supply Type Name" value="<?php if(!empty($supply_type)) echo $supply_type->supply_type_name; ?>">
								</div>
							</div>
							
						</div>
					</div>

			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				
					<div class="form-group">
						<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<!--input type="submit" class="btn btn-warning add_edit_account" value="Submit"-->
							<button id="send" type="submit" class="btn btn-warning">Submit</button>
							</center>
						</div>
					</div>
				</form>
			</div>