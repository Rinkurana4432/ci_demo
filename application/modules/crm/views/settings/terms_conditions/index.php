<style>
body .pagination {
    margin: 10px auto !important;
    display: flex !important;
    float: unset !important;
    justify-content: center;
}
</style>
<div class="x_content">
   <?php
      if($this->session->flashdata('message') != ''){
      		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      	}
      
      	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
      
       ?>
   <div class="stik">
      <form action="<?php echo site_url(); ?>crm/crmterms_condtn" method="get" id="export-form">
         <input type="hidden" value='' id='hidden-type' name='ExportType'/>
         <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'] ;} ?>' class='start_date' name='start'/>
         <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end_date' name='end'/>
         <input type="hidden" value='<?php if(!empty($_GET['favourites'])){echo $_GET['favourites'] ;} ?>' name='favourites'/>
         <input type="hidden" value='<?php if(!empty($_GET['search'])){echo $_GET['search'] ;} ?>' name='search'/>
         <input type="hidden" value='<?php if(!empty($_GET['termscond_name'])){echo $_GET['termscond_name'] ;} ?>' class='account_name' name='termscond_name'/>
      </form>
   </div>

   <div class="row hidde_cls export_div">
      <div class="col-md-12">
        
         <div class="btn-group"  role="group" aria-label="Basic example">
		     <button type="button" class="btn btn-success  add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="editterms_condtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>
         </div>
        
      </div>
   </div>
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!-------------datatable-buttons--------->          
     
      <input type="hidden" id="visible_row" value=""/>	
      <table id="" class="table table-striped table-bordered termscond_index" data-id="crmterms_condtn" style="width:100%;margin-top: 44px;" border="1" cellpadding="3">
         <thead>
            <tr>
               <th>S.no</th>
               <th scope="col">Title
                  <span><a href="<?php echo base_url(); ?>crm/crmterms_condtn?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>crm/crmterms_condtn?sort=desc" class="down"></a></span>
               </th>
               <th scope="col">Content</th>
               <th scope="col" >Created By</th>
               <th scope="col" >Created Date</th>
               <th scope="col" class='hidde'>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($termsconds)){
				$i=1;
               foreach($termsconds as $termscond){ 
                   $action = '';
                   if($can_edit) { 
               		//$action = $action.'<a href="'.base_url().'crm/edittermscond/'.$termscond["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
               		$action =  '<a href="javascript:void(0)" id="'. $termscond["id"] . '" data-id="editterms_condtn" class="add_crm_tabs btn btn-edit  btn-xs"  id="' . $termscond["id"] . '">Edit</a>';
               	}	
               	#if($can_view) { 				
               		$action .=  '<a href="javascript:void(0)" id="'. $termscond["id"] . '" data-id="termscond_view" class="add_crm_tabs btn btn-view   btn-xs"  id="' . $termscond["id"] . '">View</a>';			
               	#}
               
               		if($can_delete) { 
               						$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deletetermscond/'.$termscond["id"].'">Delete</a>';
               					}
               	
               
                                      
               $createdBy = getNameById('user_detail',$termscond['created_by'],'u_id');
               	if(!empty($createdBy)){
               		$createdByName = $createdBy->name;
               	}else{
               		$createdByName = '';
               	}
               
               	$draftImage = '';   
				
               	if($termscond['save_status'] == 0){
					$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
					<img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
               	}
                  echo "<tr>											   
               					   	
               		<td data-label='S.No:'>".$draftImage.' '.$i."</td>
               		<td data-label='Tittle:'>".$termscond['terms_tittle']."</td>
               		<td data-label='Content:'>".mb_strimwidth($termscond['content'], 0, 80, '...')."</td>
               		<td data-label='Created By:'>".$createdByName."</td>
               		<td data-label='Created Date:'>".date("j F , Y", strtotime($termscond['created_date']))."</td>	
               		<td data-label='Action:' class='hidde action'> <i class='fa fa-cog'></i>
				                                 <div class='on-hover-action'>".$action."</div></td>	
                  </tr>";
                $output[] = array(
				   'Title' => $termscond['terms_tittle'],
               	   'Content' => htmlspecialchars(trim((strip_tags($termscond['content'])))),
				   'Created Date' => date("d-m-Y", strtotime($termscond['created_date'])),
               	);
 $i++;				
			   }
			  
               $data3  = $output;
               export_csv_excel($data3);
			  
               } ?>
         </tbody>
      </table>
      
   </div>
   <?php echo $this->pagination->create_links(); ?>	
</div>
<div id="crm_add_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
         </div>
         <div class="modal-body-content" ></div>
      </div>
   </div>
</div>
