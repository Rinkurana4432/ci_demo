<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>crm/savesalesarea" enctype="multipart/form-data" id="myform" novalidate="novalidate">
	<input type="hidden" name="id" value="<?php if(!empty($sales_area_data)) echo $sales_area_data->id; ?>">
	<input type="hidden" name="created_date" value="<?php if(!empty($sales_area_data)) echo $sales_area_data->created_date; ?>">
		<hr>
		<div class="bottom-bdr"></div>
			<?php if(empty($sales_area_data)){ ?>
			<div class="item form-group blog-mdl" style="padding-bottom: 15px;">
			<div class="col-md-6 col-sm-12 col-xs-12 processDiv middle-box">
				<div class="well " style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;" id="chkIndex_1">				
					
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Sales Area Name</label>
					<input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Sales Area Name" value="<?php if(!empty($sales_area_data)) echo $sales_area_data->sales_area; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>					
						<div class="col-md-12 col-sm-12 btn-row"><div class="input-group-append">
							<button class="btn edit-end-btn addMoreProcessSaleArea" type="button">Add</button>
						</div>
					</div>
				</div>
			</div>
			<?php }else{ ?>
				<div class="col-md-6 col-sm-12 col-xs-12 processDiv middle-box">
                    <div class="well " style="overflow:auto; overflow:auto;border-top: 1px solid #c1c1c1 !important;" >				
                   <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					   <label style="border-right: 1px solid #c1c1c1 !important;">Sales Area Name</label>
					<input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Sales Area Name" value="<?php if(!empty($sales_area_data)) echo $sales_area_data->sales_area; ?>" style="border-right: 1px solid #c1c1c1 !important;"></div>
                 </div>					 
			</div>
			<?php }	?>
			</div>
<hr>




				<div class="form-group">
					<div class="col-md-12 ">
					  <center>
						
						<button id="send" type="submit" class="btn btn-warning">Submit</button>
						<?php if(empty($sales_area_data)){ ?>       
						<button type="reset" class="btn btn-default">Reset</button>
						<?php } ?>
						<a class="btn btn-danger" data-dismiss="modal">Cancel</a>
						</center>
					</div>
				</div>
</form>