<!-- ---------------- Designed View Of Chat ----------------------- -->	
<div class="x_content">
	<div class="row">
		<div class="col-sm-3 mail_list_column">
			<?php							
				$chat_id =  $this->uri->segment(3);
				$user_id = $this->session->userdata('user_id');
				$no = 0;
				$logged_status = 0;
				$get_clik_chat_id = $this->uri->segment(3);
				if($get_clik_chat_id != ''){
				$chat_with = $this->session->userdata('target_id');
				$resulttt = $this->user->getOne($chat_with)->row_array();
				$chat_with_name = $resulttt['name'];
				}else{
					$chat_with_name = '';
				}							
				foreach ($record->result() as $r) {
					$no++;	
					if ($r->is_logged_in == 1) {
						$logged_status = 'green';
					} else {
						$logged_status = 'red';
					}
					echo '<a href="'.base_url().'chat/redirect/'.$this->session->userdata('user_id').'/'.$r->u_id.'">
							<div class="mail_list">
								<div class="left">
									<i class="fa fa-circle '.$logged_status.'"></i>
								</div>
								<div class="right">
									<h3>'.$r->name.'</h3>										
								</div>
							</div>
						</a>';	
					//echo "<p>". $logged_status .'<b>' .anchor('chat/redirect/'.$this->session->userdata('user_id').'/'.$r->u_id, $r->name.'</b>' ). "</p>";
				}
				
			?>
			
		</div>
		<!-- /MAIL LIST -->

		<!-- CONTENT MAIL -->
		<div class="col-sm-9 mail_view">
			<div class="inbox-body">
				<div class="mail_heading row">						
					<div class="col-md-12">
						<h4><?php echo $chat_with_name; ?></h4>
					</div>
				</div>
				
				<div class="x_content">
					<div id="chat_viewport">					
					</div>
					
					
					<?php
						 $current_user_chat_id = $this->uri->segment(3);
					echo form_open_multipart('chat/index/'.$this->uri->segment(3)); ?>
					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="input-group">
							<input type="file" name="userfile" class="form-control"/>
							<div class="input-group-btn">
								<?php  if($current_user_chat_id == ''){ ?>
									<input type="submit" name="submit_file" value="Upload" class="btn btn-success btn-sm" disabled="disabled" />
								<?php }else{ ?>						
									<input type="submit" name="submit_file" value="Upload" class="btn btn-success btn-sm" />
								<?php } ?>	
								<?php echo form_close(); ?>	
							</div>
							<!-- /btn-group -->
						</div>
					</div> 
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="input-group">
							<input type="text" name="chat_message" id="chat_message"  class="form-control" aria-label="Text input with dropdown button"/>
							<div class="input-group-btn">
								<?php
								if($current_user_chat_id == ''){ ?>
									<a href="#" title="Send this chat message" id="submit_message" class="btn btn-primary" disabled="disabled">Send</a>
							<?php }else{ ?>
									<a href="#" title="Send this chat message" id="submit_message" class="btn btn-primary">Send</a>
							<?php } ?>		
							</div>
							<!-- /btn-group -->
						</div>
					</div>  
				</div>	
			</div> <!-- end chat -->
		</div> <!-- end container -->
	</div>
</div>

<script type="text/javascript">
      var chat_id = "<?php echo $chat_id; ?>";
      var user_id = "<?php echo $user_id; ?>";
	  var base_url = '<?php echo base_url() ?>';
</script>
	