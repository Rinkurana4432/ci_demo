 	
			<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
<form class="form-search" method="get" action="<?= base_url() ?>hrm/sharetemplate">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Name" name="search" id="search" data-ctrl="hrm/sharetemplate" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
		 <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?php echo site_url(); ?>hrm/sharetemplate'" value="Reset">
         </span>
      </div>
   </div>
</form>
</div>
</div>
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}

 ?>
<div class="stik">	
  


		
</div>

		
		<?php #if(!empty($competitor_details)){ ?>
	<div class="row hidde_cls export_div">

			
				<div class="col-md-12">
						<input type="hidden" value='account' id="table" data-msg="Company" data-path="crm/competitor_details"/>

					<div class="col-md-3 datePick-left">                
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						 
					  </div>
					</div>
				</fieldset>
			 
			</div>

						<div class="btn-group"  role="group" aria-label="Basic example">
						 
						</div>

				<div class="col-md-3 datePick-right">
						 
              </div>	
					
				</div>
			</div>
 
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">
	<!-------------datatable-buttons--------->          
			
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/competitor_details">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			
	   <table id="letterTemplate" class="table table-striped table-bordered account_index" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Employee No</th>
				<th>Employee Name
				<span><a href="<?php echo base_url(); ?>hrm/sharetemplate?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/sharetemplate?sort=desc" class="down"></a></span></th>
				<th>Joining Date</th>
				<th>Actions</th>
				  
			</tr>
		</thead>
		<tbody>

				<?php   if(!empty($users)){
					$sNo = 1 ;

					#pre($users);exit;
					foreach($users as $template){													?>
					   <tr>
                                      
                           <td> <?php if(!empty($sNo)) echo $sNo ?></td>
                          
                           <td> <?php $emp_data = getNameById('user_detail',$template['id'],'u_id'); if(!empty($users)) echo @  $emp_data->name; ?> </td>
                           <td> <?php if(!empty($users)) echo $template['date_joining']; ?> </td>
                           
                        
                          
                           <td> <a href="<?php echo base_url().'hrm/peremployeetemplate/'.$template['id'];  ?>"><button class="btn btn-view btn-xs btn-primary"><i class="fa fa-eye"></i></button></a></td>
                      
					 
					     
						      </tr> 
						 
						 	<?php   $sNo++;  }     }  ?>
 
			       
		</tbody>     

	</table>
	<?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>  
	</div>
</div>
 