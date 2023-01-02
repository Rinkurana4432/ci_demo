	<?php if($_SESSION['loggedInUser']->role != 2){ ?>	   					  
			<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/savecharges" enctype="multipart/form-data" id="savecharges" novalidate="novalidate">
			
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<input type="hidden" name="id" value="<?php if(!empty($other_charges)) echo $other_charges->id; ?>">
				
						<input type="hidden" value="1" name="charges_for">

					
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Charges Heading<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="particular_charges" name="particular_charges" required="required" data-validate-length-range="4"  class="form-control col-md-7 col-xs-12" placeholder="Charges Headings" value="<?php if(!empty($other_charges)) echo $other_charges->particular_charges; ?>">
								</div>
							</div>
							<div class="item form-group" style="display:none;">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Type of Charges<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									 <p>
										Plus:
										<input type="radio" class="flat" name="type_charges"  value="plus" checked<?php echo ($other_charges->type_charges == 'plus') ?  "checked" : "" ;  ?> required /> Minus:
										<input type="radio" class="flat" name="type_charges"  value="minus" <?php echo ($other_charges->type_charges == 'minus') ?  "checked" : "" ;  ?> />
									  </p>
								</div>
							</div>
							 <div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Amount of charges to be fed as </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <p>
									Absolute Amount:
									<input type="radio" class="flat" name="amount_of_charges"  value="absoluteamount" <?php echo ($other_charges->amount_of_charges == 'absoluteamount') ?  "checked" : "" ;  ?>   /> Percentage:
									<input type="radio" class="flat" name="amount_of_charges"  value="percentage" <?php echo ($other_charges->amount_of_charges == 'percentage') ?  "checked" : "" ;  ?>  /><br/>
									
								  </p>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tax<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="tax_slab" class="form-control" required>
										<option name="">Select Tax Slab</option>
										<option value="0"  <?php if($other_charges->tax_slab == '0'){echo 'selected';} ?> >0%</option>
										<option value="5"  <?php if($other_charges->tax_slab == '5'){echo 'selected';} ?> >05%</option>
										<option value="12" <?php if($other_charges->tax_slab == '12'){echo 'selected';} ?>>12%</option>
										<option value="18" <?php if($other_charges->tax_slab == '18'){echo 'selected';} ?>>18%</option>
										<option value="28" <?php if($other_charges->tax_slab == '28'){echo 'selected';} ?>>28%</option>
									</select>
								</div>
							</div>
					
						
 				
		<?php } ?>	
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
			
					<div class="form-group">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="reset" class="btn btn-default">Reset</button>
							<!--input type="submit" class="btn btn-warning add_edit_account" value="Submit"-->
							<button id="send" type="submit" class="btn edit-end-btn">Submit</button>
							</center>
						</div>
					</div>
				</form>
			</div>