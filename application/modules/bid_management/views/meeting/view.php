<?php
$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;?>
		
	<div class="row">
	<div class="col-md-12">	
	<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_meeting" enctype="multipart/form-data">
	<input type="hidden" name="logged_in_user" value="<?php echo $this->companyGroupId; ?>" id="loggedUser">
   <input type="hidden" name="id" id="id" value="<?php if(!empty($meeting)) echo $meeting->id; ?>">																		
<div class="container">
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" >Liasoning Agent</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
				<select class="form-control" required="required" name="agent_id"  id="agent_id">
								<option value="">Select Option</option>
								
							<?php			
				$agent_id =$this->bid_management_model->get_data('liasoning_agent');
				foreach($agent_id as $data){?>
		<option value="<?php echo $data['id']?>" <?php  if(!empty($meeting)) if($meeting->agent_id==$data['id']){echo 'selected';}?>><?php echo $data['name'];?></option>';
			<?php	}?>
							</select>
				</div>						
		</div>
	<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12" >Tender Name</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<select class="form-control" name="tender_id" id="tender_id">
								<option value="">Select Option</option>
	<?php $register = $this->bid_management_model->get_data('register_opportunity');
		foreach($register as $data){
			$tender=json_decode($data['tender_detail'],true);
			foreach($tender as $val){?>
			<option value="<?php echo $data['id'];?>" <?php  if(!empty($meeting)) if($meeting->tender_id==$data['id']){echo 'selected';}?>><?php echo $val['tender_name'];?></option>
		<?php }}?>
					</select>
				</div>						
		</div>
		<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Meeting Date</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="date" class="form-control" name="meeting_date" id="meeting_date" value="<?php if(!empty($meeting)) echo $meeting->meeting_date; ?>">
				</div>						
		</div>
        <div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Meeting Time</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="time" class="form-control" name="meeting_time" id="meeting_time" value="<?php if(!empty($meeting)) echo $meeting->meeting_time; ?>">
				</div>						
		</div>
        <div class="item form-group">
				<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Message Attachment</label>
					<div class="col-md-7 col-sm-9 col-xs-12">
         <input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="message_attachment" >
                    <?php if(!empty($meeting)) echo $meeting->message_attachment; ?>
					</div>
				</div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Meeting Person
            </label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="meeting_person" id="meeting_person" value="<?php if(!empty($meeting)) echo $meeting->meeting_person; ?>">
				</div>						
		</div>
        <div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Meeting Location
            </label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="meeting_location" id="meeting_location" value="<?php if(!empty($meeting)) echo $meeting->meeting_location; ?>">
				</div>						
		</div>
		<div class="item form-group">
				<label class="col-md-3 col-sm-2 col-xs-12" for="certificate">Attachment</label>
					<div class="col-md-7 col-sm-9 col-xs-12">
                    <input type="file" class="form-control col-md-2 col-sm-2 col-xs-12" name="attachment" >
                    <?php if(!empty($meeting)) echo $meeting->attachment; ?>
					</div>
				</div>
				<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Detail</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<textarea rows="4" cols="60" name="detail"><?php if(!empty($meeting)) echo $meeting->detail; ?></textarea>
				</div>						
		</div>
        	<div class=" item form-group">													
			<label class="col-md-3 col-sm-2 col-xs-12">Meeting Detail</label>			
				<div class="col-md-6 col-sm-12 col-xs-12">
					<textarea rows="4" cols="60" name="message_detail"><?php if(!empty($meeting)) echo $meeting->message_detail; ?></textarea>
				</div>						
		</div>
		</div>
								<hr>							
<div class="bottom-bdr"></div>									
							<div class="ln_solid"></div>
                            </div>
						</form>	
					</div>
				</div>													
			</div>
	
