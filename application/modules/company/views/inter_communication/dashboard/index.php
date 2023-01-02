<!-- ---------------- Designed View Of Chat ----------------------- -->	
<div class="x_content">
	<div class="row">
	<?php if(!empty($record)){ ?>
		<div class="col-sm-3 mail_list_column">
			<?php
				$chat_id =  $this->uri->segment(3);
				$sendByCompanyId = $_SESSION['loggedInUser']->c_id;
				$no = 0;
				$logged_status = 0;	
		
			foreach ($record as $r) {
				$no++;
				if(isset($chkNonConnect)){ 
					echo '<a href="'.base_url().'company/redirect/'.$sendByCompanyId.'/'.$r["id"].'/'.$chkNonConnect.'">
						<div class="mail_list">
							<div class="left">
								<i class="fa fa-circle red"></i>
							</div>
							<div class="right">
								<h3>'.$r["name"].'</h3>
							</div>
						</div>
					</a>';
				}
				else{ 
					echo '<a href="'.base_url().'company/redirect/'.$sendByCompanyId.'/'.$r["id"].'">
						<div class="mail_list">
							<div class="left">
								<i class="fa fa-circle red"></i>
							</div>
							<div class="right">
								<h3>'.$r["name"].'</h3>										
							</div>
						</div>
					</a>';
				}
			}
		
				
			?>
			
		</div>
		<!-- /MAIL LIST -->
		
		
		
		<?php
			$get_clik_chat_id = $this->uri->segment(3);
			$messageToName = 'Select Company from list';
			if($get_clik_chat_id != ''){
				$chat_with = $this->session->userdata('target_id');
				$messageToName = getNameById('company_detail',$chat_with,'id')->name;	
			}			
?>

		<!-- CONTENT MAIL -->
		<div class="col-sm-9 mail_view">
			<div class="inbox-body">
				<div class="mail_heading row">						
					<div class="col-md-12">
						<h4><?php echo $messageToName; ?></h4>
					</div>
				</div>
				
				<div class="x_content">
					<div id="chat_viewport">					
					</div>
					<div class="col-sm-11">
						<div class="input-group">
							<input type="text" name="chat_message" id="chat_message"  class="form-control" aria-label="Text input with dropdown button"/>
							<div class="input-group-btn">
								<input type="file" id="file1" name="image" accept="image/*" capture style="display:none"/>
								<i class="fa fa-paperclip" id="upfile1" style="cursor:pointer"></i>
								<a href="#" title="Send this chat message" id="submit_message" class="btn btn-primary">Send</a>
															
							</div>
							<!-- /btn-group -->
						</div>
						<?php		
							if(isset($chkNonConnect)){
								echo form_open_multipart('company/non_connected_message/'.$this->uri->segment(3));
							}else{        
								echo form_open_multipart('company/message/'.$this->uri->segment(3));
							}
						  ?>
						<div class="input-group">							
							<div class="input-group-btn image-upload">
								<i class="fa fa-paperclip"></i>
								<input type="file" name="userfile" class="form-control"/>		
													
							</div>											
							<!-- /btn-group -->
						</div>
						<div class="input-group">							
							<div class="input-group-btn image-upload">
								<i class="fa fa-paperclip"></i>
								<input type="submit" name="submit_file" value="Upload" class="btn btn-success btn-sm" />					
							</div>											
							<!-- /btn-group -->
						</div>
						
						 <?php echo form_close(); ?>	
					</div>
				</div>	
			</div> <!-- end chat -->
		</div> <?php } else{
			echo '<h2><b>No Result.</h2></b>';
		}?> <!-- end container -->
	</div>
</div>

<script type="text/javascript">	
	var chat_id = "<?php echo $chat_id; ?>";
	var user_id = "<?php echo $sendByCompanyId; ?>";
	var base_url = '<?php echo base_url(); ?>';

</script>
