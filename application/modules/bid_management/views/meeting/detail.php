<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;?>
		
	<div class="row">
	<div class="col-md-12">	
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_meeting_detail" enctype="multipart/form-data">
<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
 <input type="hidden" name="id" id="id" value="<?php if(!empty($meeting)) echo $meeting->id; ?>">	
    <input type="hidden" name="status" id="status" value="1">																		
<div class="container">
<div class="col-md-6 col-sm-12 col-xs-12 ">
		<div class="item form-group">
				<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachment</label>
					<div class="col-md-7 col-sm-9 col-xs-12">
         <input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="message_attachment" >
                    <?php if(!empty($meeting)) echo $meeting->message_attachment; ?>
					</div>
				</div>
				<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Detail</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<textarea rows="4" cols="60" name="message_detail"><?php if(!empty($meeting)) echo $meeting->message_detail; ?></textarea>
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
	
