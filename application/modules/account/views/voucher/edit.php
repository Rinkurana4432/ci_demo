					  
			<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>account/saveVoucher_type" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($voucher)) echo $voucher->id; ?>">
					<div class=" panel-default">
						
						<h3 class="Material-head">Information <hr></h3>
						<div class="col-md-12 col-xs-12 col-sm-12 vertical-border ">
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="name">Voucher Name<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="voucher_name" name="voucher_name" required="required" data-validate-length-range="4"  class="form-control col-md-7 col-xs-12" placeholder="Sale" value="<?php if(!empty($voucher)) echo $voucher->voucher_name; ?>">
								</div>
							</div>
							
							
							<div class="item form-group">
								<label class="col-md-3 col-sm-3 col-xs-12" for="type">Voucher Description <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									
									<textarea col="60" rows="10" name="voucher_desc" required="required" class="form-control col-md-7 col-xs-12" placeholder="Descriptions"><?php if(!empty($voucher)) echo $voucher->voucher_desc; ?></textarea>  
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