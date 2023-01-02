
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-success col-md-6">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }?>
<div class="x_content">
   <div class="stik">
      <?php $str = base64_decode('YW5vZGl6ZSQxMjNfQCMhQA==');
         str_replace("_@#!@", "", $str);
         ?>
   </div>
   <?php /*if(!empty($job_Card)){ */ ?>
<div    class="col-md-12 col-xs-12 for-mobile">
 <div class="Filter Filter-btn2">
      <form class="form-search " method="post" action="<?= base_url() ?>production/bom_routing" >
      <div class="col-md-6">
         <div class="input-group">
            <span class="input-group-addon">
            <i class="ace-icon fa fa-check"></i>
            </span>
            <input type="text" class="form-control search-query" placeholder="Enter id,Routing Number,Product Name" id="search" name="search" value="<?php if(!empty($_GET['search'])) echo $_GET['search'];?>" data-ctrl="production/bom_routing">
            <span class="input-group-btn">
            <button type="submit" class="btn btn-purple btn-sm">
            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
            Search
            </button>
            <a href="<?php echo base_url(); ?>production/bom_routing"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
            </span>
         </div>
      </div>
   </form>
   
   <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
         <div id="demo" class="collapse">
		       <div class="col-md-2 col-xs-12 col-sm-12">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="production/bom_routing"/>
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>production/bom_routing" method="get" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
		 </div>
 </div>
   <div class="row hidde_cls export_div">
      <div class="col-md-12 col-xs-12 col-sm-12">
         
         <div class="btn-group"  role="group" aria-label="Basic example">
		   <?php if($can_add) { ?>
		   		<!-- <button type="button" class="btn  btn-success productionTab addBtn" data-toggle="modal" id="add" data-id="jobCardEdit"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button> -->
               <a href="javascript:void(0)" class="btn  btn-success addBtn __chooseMaterial" data-toggle="collapse" data-target="#materialChoose">Add</a> 
               <div id="materialChoose" class="collapse">
                  <form id="chooseMaterialForm"  novalidate="novalidate" action="" method="post">
                     <div class="col-md-12 col-xs-12 col-sm-12">
                           <select data-placeholder="Select Material" class="form-control selectAjaxOption select2 select2-hidden-accessible " required="required" name="material_id" data-id="material" data-key="id" data-fieldname="material_name" tabindex="-1" aria-hidden="true" data-where="job_card = 0 and status=1 and save_status=1 and created_by_cid=<?php echo $created_by_cid; ?> OR created_by_cid=0" id="choose_material_id">
                              <option value="">Select Option</option>
                           </select>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12">
                     <input type="submit" class="btn btn-warning signUpBtn material_mat_btn_submit" value="submit">
                     </div>
		         </div>
        <?php  
				//echo '<a href="'.base_url().'production/job_card_edit" class="btn  btn-success addBtn __spacing"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add New</a>';
			   
               } ?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <input type="hidden" value='job_card' id="table" data-msg="Job Card" data-path="production/bom_routing"/>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown" aria-expanded="false">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  <li id="export-to-blank-excel"><a href="<?php echo base_url()?>/assets/modules/crm/downloads/importexcel.xls" title="Please check your open office Setting" download>Export to Blank Excel</a></li>
               </ul>
            </div>
            
            <form action="<?php echo base_url(); ?>production/bom_routing" method="get" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(!empty($_GET['start'])){echo $_GET['start'];}?>' class='start' name='start'/>
               <input type="hidden" value='<?php if(!empty($_GET['end'])){echo $_GET['end'];} ?>' class='end' name='end'/>
               <?php /*<button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button> */ ?>
            </form>
            <!-- Approve Disapprove -->
            <form action="<?php echo site_url(); ?>production/bom_routing" method="get" id="export-form">
               <input type="hidden" value='' id='hidden-type' name='ExportType' />
               <input type="hidden" value='<?php if($_GET['start'])echo $_GET['start']?>' class='start_date' name='start' />
               <input type="hidden" value='<?php if($_GET['end'])echo $_GET['end']?>' class='end_date' name='end' />
               <input type="hidden" value='<?php if($_GET['search'])echo $_GET['search']?>' name='search' />
               <input type="hidden" value='<?php if($_GET['favourites'])echo $_GET['favourites']?>' name='favourites' />
            </form>
         </div>
         <?php /* } */ ?>
         <!-- Approve Disapprove -->					
         
         <?php if(!empty($job_Card)){ ?>
      </div>
   </div>
</div>

<?php } ?>
<input type="hidden" name="logged_in_user" value="<?php echo $_SESSION['loggedInUser']->c_id; ?>" id="loggedInUserId">
<p class="text-muted font-13 m-b-30"></p>
<div id="print_div_content"  style="margin-top: 58px;" >
   
   <table id="" class="table table-striped table-bordered account_index" border="1" cellpadding="3" data-order='[[1,"desc"]]'>
      <thead>
         <tr>
            <th><input id="selecctall" type="checkbox"></th>
            <th scope="col">Id<span><a href="<?php echo base_url(); ?>production/bom_routing?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>production/bom_routing?sort=desc" class="down"></a></span></th>
            <th scope="col">BOM Routing Number<span><a href="<?php echo base_url(); ?>production/bom_routing?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>production/bom_routing?sort=desc" class="down"></a></span></th>
            <th scope="col">Party<span><a href="<?php echo base_url(); ?>production/bom_routing?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>production/bom_routing?sort=desc" class="down"></a></span></th>
            <th scope="col">BOM Routing Product Name<span><a href="<?php echo base_url(); ?>production/bom_routing?sort=asc" class="up"></a>
			<a href="<?php echo base_url(); ?>production/bom_routing?sort=desc" class="down"></a></span></th>
            <?php /*<th>Product Specification</th>
               <th>Party Requirement</th>*/?>
            <th scope="col">Test certificate</th>
            <th scope="col" class='hidde'>Validate</th>
            <th scope="col" >Created By / Edited By</th>
            <th scope="col" >Created Date</th>
            <th scope="col" class='hidde'>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php if(!empty($job_Card)){
            foreach($job_Card as $job_card){
            	$countLength = $job_card['test_certificate'];
            	$draftImage = ($job_card['save_status'] == 0)?('<img src="'.base_url(). 'assets/images/draft.png"  width="25%" class="hidde">'):'';
            	$disable = (($job_card['save_status'] == 0) || ($job_card["approve"] == 1))?'disabled':''; // if PI is in draft than it will not be approved or disapprove
            	$disableEdit = (($job_card["approve"] == 1))?'disabled':''; // if job card is in draft than it will not be approved or disapprove
            	$validatedBy = ($job_card['validated_by']!=0)?(getNameById('user_detail',$job_card['validated_by'],'u_id')):''; 					
            	$validatedByName = (!empty($validatedBy))?$validatedBy->name:''; // get the name of user who validate the PI					
            	$created_by = ($job_card['created_by']!=0)?(getNameById('user_detail',$job_card['created_by'],'u_id')->name):'';
            	$edited_by = ($job_card['edited_by']!=0)?(getNameById('user_detail',$job_card['edited_by'],'u_id')->name):'';
            
            ?>
         <tr>
            <td><?php if($job_card["used_status"]==0 && $job_card['approve']==0){echo "<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$job_card['id'].">";}
               if($job_card['favourite_sts'] == '1'){
               	   				echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$job_card['id']."  checked = 'checked'>";
               	   				echo"<input type='hidden' value='job_card' id='favr' data-msg='Job card' data-path='production/bom_routing' favour-sts='0' id-recd=".$job_card['id'].">";
               	   		}else{
               					echo "<input class='star-1' type='checkbox'  title='Mark Record' value=".$job_card['id'].">";
               					echo"<input type='hidden' value='job_card' id='favr' data-msg='job Card' data-path='production/bom_routing' favour-sts='1' id-recd =".$job_card['id'].">";
               	   		}
               ?>
			 </td>
            <td data-label="Id:"  class="job_card_id"><?php echo $draftImage.$job_card['id'];?></td>
            <td data-label="BOM Routing Number:"><?php echo $job_card['job_card_no'];?></td>
            <th data-label="Party:"><?php echo $job_card['party_code'];?></th>
            <?php /*<td><?php echo $job_card['product_specification'];?></td>
            <td><?php echo $job_card['party_requirement'];?></td>
            */?>
            <td data-label="BOM Routing Product Name:"><?php echo $job_card['job_card_product_name']; ?></td>
            <th data-label="Test certificate:"><?php 
               $str = $countLength;
               	if( strlen( $countLength) > 50) {
               		$str = explode( "\n", wordwrap( $countLength, 50 ));
               		$str = $str[0] . "<br><a href ='' id='". $job_card['id'] . "' data-id='jobCardView' class='productionTab' data-tooltip='View' style='color:green;' >View More</a>";
               	}
               	echo $str;
               //echo $job_card['test_certificate'];?></th>
            <td data-label="Validate:" class='hidde <?php echo $can_validate?'':'disabled'; ?>' style="pointer-events:<?php echo $can_validate?'':'none'; ?>"> 
               <?php 
                  $selectApprove = $job_card['approve']==1?'checked':'';
                  $selectDisapprove = $job_card['disapprove']==1?'checked':'';
                  if($selectApprove =='checked'){
                  
                  echo "
                  Approve:
                  	<input type='radio' class='validate' name='status_".$job_card['id']."' value='Approve'/ ".$selectApprove." ".$disable."> 
                  Disapprove:
                  	<input type='radio' class='disapprove' name='status_".$job_card['id']."' value='Disapprove'/ ".$selectDisapprove.$disable." disabled>
                  	
                  	<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                  }else{
                  	echo "
                  	Approve:
                  	<input type='radio' class='validate' name='status_".$job_card['id']."' value='Approve'/ ".$selectApprove.$disable."> Disapprove:
                  	<input type='radio' class='disapprove' name='status_".$job_card['id']."' value='Disapprove'/ ".$selectDisapprove.$disable.">
                  	<p class='disapprove_reason'>".$job_card['disapprove_reason']."</p>
                  	<p class='validatedBy'>Validated By: ".$validatedByName."</p>";
                  }
                  ?>
            </td>
            <td data-label="Created By / Edited By:"><?php echo "<a href='".base_url()."users/edit/".$job_card['created_by']."' target='_blank'>".$created_by.'</a><a href="'.base_url().'users/edit/'.$job_card["edited_by"].'" target="_blank"><br>'.$edited_by."</a>"; ?></td>
            <td data-label="Created Date:"><?php echo date("j F , Y", strtotime($job_card['created_date'])); ?></td>
            <td data-label="Action:" class='hidde'>
               <button id="<?php echo $job_card["id"]; ?>" data-id="AddSimilarJobCardExisting" data-tooltip="Clone Job card Existing" class="btn btn-xs productionTab add-machine"> <i class="fa fa-clone" aria-hidden="true"></i></button>
               
               <button id="<?php echo $job_card["id"]; ?>" data-id="AddSimilarJobCard" data-tooltip="Clone Job card New" class="btn btn-xs productionTab add-machine"> <i class="fa fa-clone" aria-hidden="true"></i></button>
               <?php  
                  if($can_edit) { 										
                  	//echo '<button type="button" data-id="jobCardEdit" data-tooltip="Edit" class="btn btn-edit btn-xs productionTab" data-toggle="modal" id="'.$job_card["id"].'"><i class="fa fa-pencil"></i></button>';
                  	echo '<a href="'.base_url().'/production/job_card_edit/'.$job_card["id"].'" class="btn btn-edit btn-xs"><i class="fa fa-pencil"></i></button></a>';
                  }
                  if($can_view) { 										
                  	echo '<button type="button" data-id="jobCardView" data-tooltip="View" class="btn btn-view btn-xs productionTab" data-toggle="modal" id="'.$job_card["id"].'"><i class="fa fa-eye"></i></button>';
                  }
                  if($can_delete) {
                  	if($job_card['used_status'] ==1){
                  		echo '<a href="javascript:void(0)" class=" btn-xs
                  		btn btn-delete" data-tooltip="Delete" data-href="'.base_url().'production/deleteJobcard/'.$job_card['id'].'" disabled="disabled"><i class="fa fa-trash"></i></a>';
                  	}else{
                  		echo '<a href="javascript:void(0)" class="delete_listing btn-xs
                  		btn btn-delete" data-tooltip="Delete" data-href="'.base_url().'production/deleteJobcard/'.$job_card['id'].'"><i class="fa fa-trash"></i></a>';
                  	}
                  }
                  /* ?>
               <button type="button" data-id="jobCardViewNew" data-tooltip="View New" class="btn btn--view btn-xs productionTab" data-toggle="modal" id="'.$job_card["id"].'"><i class="fa fa-pencil"></i></button>*/?>
            </td>
         </tr>
         <?php 
            $output[] = array(
            		   'Job Card' => $job_card['job_card_no'],
            		   'Party' => $job_card['party_code'],
            		   'Product Specification' => $job_card['product_specification'],
            		   'Party Requirement' => $job_card['party_requirement'],
            		   'Test certificate' =>  $job_card['test_certificate'],
            		   'Created Date' => date("d-m-Y", strtotime($job_card['created_date'])),
            		);	
            	}
            $data3  = $output;
            export_csv_excel($data3);
            
            
            }
            
            ?>
      </tbody>
   </table>
   <?php echo $this->pagination->create_links(); ?>	

</div>
</div>

<div id="production_modal" class="modal fade in"  role="dialog" >
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">BOM Routing Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<div id="production_modal_edit" class="modal fade in"  role="dialog" >
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">BOM Routing Edit</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<div id="production_modal_view" class="modal fade in bom-rutinga"  role="dialog" >
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">BOM Routing Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<div class="modal fade disapproveReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg  ">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Reason</h4>
         </div>
         <div class="modal-body">
            <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>production/disApproveJobCard" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
               <input type="hidden" name="id" value="" id="job_card_id">
               <input type="hidden" id="validated_by" name="validated_by" value="<?php echo $_SESSION['loggedInUser']->id; ?>">
               <input type="hidden" id="disapprove" name="disapprove" value="1">
               <input type="hidden" id="disapprove" name="approve" value="0">
               <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">														
                     <textarea id="disapprove_reason" required="required" rows="6" name="disapprove_reason" class="form-control col-md-7 col-xs-12" placeholder=""></textarea>													
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn edit-end-btn" data-dismiss="modal">Close</button>							  
                  <input type="submit" class="btn btn edit-end-btn " value="Submit">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
