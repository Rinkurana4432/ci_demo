<div class="x_content">
<div class="col-md-12 col-sm-12 for-mobile">
         <div class="Filter Filter-btn2">
			 <form class="form-search" method="get" action="<?= base_url() ?>hrm/viewlettertemplate">
   <div class="col-md-6">
      <div class="input-group">
         <span class="input-group-addon">
         <i class="ace-icon fa fa-check"></i>
         </span>
         <input type="text" class="form-control search-query" placeholder="Enter Title" name="search" id="search" data-ctrl="hrm/viewlettertemplate" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>">
         <span class="input-group-btn">
         <button type="submit" class="btn btn-purple btn-sm">
         <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
         Search
         </button>
         <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" onclick="window.location.href='<?= base_url() ?>hrm/viewlettertemplate'" value="Reset">
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

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
 ?>
<div class="stik">	
</div>		<?php #if(!empty($competitor_details)){ ?>
	<div class="row hidde_cls export_div">
				<div class="col-md-12">
						<input type="hidden" value='account' id="table" data-msg="Company" data-path="crm/competitor_details"/>
             <div class="col-md-3 datePick-right">
						<?php 
				if($can_add) {
					 echo '<a href="'.base_url().'hrm/lettertemplate/"><button type="buttton" class="btn btn-info addBtn">Add</button></a>'; 
					//echo '<button type="button" class="btn btn-primary add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="competitor_details">Add</button>';
				} ?>
              </div>
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
					
					
				</div>
			</div>
 
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">
	<!-------------datatable-buttons--------->          
			
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/competitor_details">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			
	<table id="mytable" class="table tblData table-striped table-bordered account_index" data-id="account" style="width:100%" border="1" cellpadding="3">
		<thead>
			<tr>
				<th>All
				<span><a href="<?php echo base_url(); ?>hrm/viewlettertemplate?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/viewlettertemplate?sort=desc" class="down"></a></span></th>
				<th>Title
				<span><a href="<?php echo base_url(); ?>hrm/viewlettertemplate?sort=asc" class="up"></a>
		   <a href="<?php echo base_url(); ?>hrm/viewlettertemplate?sort=desc" class="down"></a></span></th>
				<th>Created Date</th>
				<th> Updated Date</th>
				 
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

				<?php if(!empty($all_templates)){
					$sNo = 1 ;

				#	pre($all_templates);exit;
					foreach($all_templates as $template){    ?>
					   <tr>           
                           <td> <?php if(!empty($template)) echo $template['id']; ?></td> 
                           <td> <?php if(!empty($template)) echo $template['title']; ?> </td> 
                           <td> <?php if(!empty($template['created_at'])) echo date('Y-m-d' , strtotime($template['created_at'])); if(!empty($template['created_date'])) echo date('Y-m-d' , strtotime($template['created_date'])); ?> </td> 
                           <td> <?php if(!empty($template['modified_at'])) echo  date('Y-m-d' , strtotime($template['modified_at'])); if(!empty($template['modified_date'])) echo  date('Y-m-d' , strtotime($template['modified_date'])); ?> </td> 
					       <td class=""><?php if($can_edit){ ?><a href="<?php echo base_url().'hrm/lettertemplate/'.$template['id'];  ?>" class="add_hrm_tabs btn btn-edit  btn-xs" ><i class="fa fa-pencil"></i> </a> <?php } ?>
						   <?php if($can_view){ ?><a href="<?php echo base_url().'hrm/view_lettertemplate/'.$template['id'];  ?>" class="add_hrm_tabs btn btn-view  btn-xs" ><i class="fa fa-eye"></i> </a> <?php } ?>  <?php if($can_delete){ ?><a href="<?php echo base_url().'hrm/deleteLetterTemplate/'.$template['id'];  ?>" class="add_hrm_tabs btn btn-delete  btn-xs" ><i class="fa fa-trash"></i> </a> <?php } ?></td>
				 
						 <!--if($can_delete){ ?><a href="</?php echo base_url().'hrm/deleteLetterTemplate/'.$template['id'];  ?>" class="delete_listing btn btn-xs btn-delete" ><i class="fa fa-trash"></i></a></?php } ?>-->
						      </tr> 
						 
						 	<?php   $sNo++;  }     }  ?>
		</tbody>     

	</table>
	   <?php  echo $this->pagination->create_links(); ?>
<div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
  <?php echo $result_count; ?></span></div>  
	</div>
</div>
 