<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>inventory/saveuomtype" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($uom_list1)) echo $uom_list1->id; ?>">
	<input type="hidden" name="created_date" value="<?php if(!empty($uom_list1)) echo $uom_list1->created_date; ?>">

	 
		<hr>
		<div class="bottom-bdr"></div>
		
			<?php if(!empty($uom_list1)){ ?>
				
			<div class="form-group blog-mdl" style="padding-bottom: 15px;">
			<div class="col-md-12 col-sm-12 col-xs-12 processDiv ">
			     
							
				<div  style="overflow:auto; overflow:auto;" id="chkIndex_1">				
					<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                     <div class="item form-group">
					   <label class="col-md-4">UOM<span class="required">*</span></label>
					      <div class="col-md-7 col-xs-12">
							<input type="text"  name="uom_quantity" required="required" class="form-control " placeholder="UOM" value="<?php if(!empty($uom_list1)) echo $uom_list1->uom_quantity; ?>" >
						  </div>	
					</div>					
					


					<div class="item form-group">
					   <label class="col-md-4">UOM Type </label>
					   <div class="col-md-7 col-xs-12">
							<input type="text" name="uom_quantity_type" class="form-control " placeholder="UOM Type" value="<?php if(!empty($uom_list1)) echo $uom_list1->uom_quantity_type; ?>" >
				      </div>					
					</div>
					
                    				
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
					<div class="item form-group">
					   <label class="col-md-4">UQC Code</label>
					      <div class="col-md-7 col-xs-12">
							<input type="text"  name="ugc_code" required="required" class="form-control " placeholder="UQC Code" value="<?php if(!empty($uom_list1)) echo $uom_list1->ugc_code; ?>" >
						</div>
					</div>	
                   </div>	
				</div>	
				</div>
			</div>
			<?php }else{ ?>
				<div class="col-md-12 col-sm-12 col-xs-12 processDiv ">
                    <div  style="overflow:auto; overflow:auto;" >				
					<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
                   <div class="item col-md-12 col-sm-12 col-xs-12 form-group">
				      
					   <label class="col-md-4" >UOM Quantity <span class="required">*</span></label>
					      <div class=" col-md-7 col-xs-12">
							<input type="text"  name="uom_quantity" required="required"  class="form-control" placeholder="UOM Quantity" value="<?php if(!empty($uom_list1)) echo $uom_list1->uom_quantity; ?>"  onkeypress="return float_validation(event, this.value)">
							</div>
					</div>					
					


					<div class="item col-md-12 col-sm-12 col-xs-12 form-group">
					   <label class="col-md-4" >UOM Type <span class="required">*</span></label>
					      <div class=" col-md-7 col-xs-12">
							<input type="text"  name="uom_quantity_type" required="required"  class="form-control" placeholder="UOM Type" value="<?php if(!empty($uom_list1)) echo $uom_list1->uom_quantity_type; ?>" >
							</div>
					</div>					
					</div>
					
                    <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
					<div class=" item col-md-12 col-sm-12 col-xs-12 form-group">
					   <label class="col-md-4">UQC Code</label>
					     <div class=" col-md-7 col-xs-12">
							<input type="text"  name="ugc_code" required="required" class="form-control" placeholder="UQC code" value="<?php if(!empty($uom_list1)) echo $uom_list1->ugc_code; ?>" >
						 </div>
					</div>	
                    </div>
                   </div>					
					</div>	
					</div>				
                 </div>					 
			</div>
			<?php }			?>
			</div>
			
<hr>




				<div class="form-group">
					<div class="col-md-12 ">
					  <center>
						<button type="reset" class="btn btn-default">Reset</button>
						<button id="send" type="submit" class="btn btn-warning">Submit</button>
						<a class="btn btn-danger" data-dismiss="modal">Cancel</a>
						</center>
					</div>
				</div>
</form>