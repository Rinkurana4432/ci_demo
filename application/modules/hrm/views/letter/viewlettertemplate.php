<form method="post" class="form-horizontal" action="" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
<input type="hidden" name="update_letter_template_id" value="<?php echo $id = $this->session->userdata('letter_temp_id'); ?>">
<label class="col-md-2 col-sm-12 col-xs-12" for="address">Subject</label>		
<div class="col-md-3 col-sm-12 col-xs-12">         
 <input required  type="text" id="title" name="title"  class="form-control col-md-7 col-xs-12" value="<?php if (!empty($template)){ echo $template->title;} ?>"  readonly>  		
 </div>		<br>		<br>		<br>		<br>		
<label class="col-md-2 col-sm-12 col-xs-12" for="address">Body</label>	
		<div class="col-md-8 col-sm-12 col-xs-12">                
<textarea rows="60" id="content" name="content" readonly>                    
         <?php if (!empty($template)){ echo $template->content;}; ?>				
</textarea>		
		<h5>Please add following tags to the letters.<br> 					[name], [todays_date] , [email] , [mobile] , [address] , [designation] , [joining_date] , [dob]				</h5>			</div>			<div class="form-group" >		
		<div class="col-md-6 col-md-offset-3" style="margin-top: 50px; float: right">		
			<a href="<?php echo base_url() . 'hrm/viewlettertemplate' ?>" >
            <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
            </a>					
            
            			</div>		
                        	</div>		
                            </form>