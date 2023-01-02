<div class="x_content">
   <?php
      if($this->session->flashdata('message') != ''){
      		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      	}
      
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
       ?>
   <div class="stik">
      <form action="<?php echo site_url(); ?>bid_management/competitor_details" method="post" id="export-form">
         <input type="hidden" value='' id='hidden-type' name='ExportType'/>
         <input type="hidden" value='' class='start_date' name='start'/>
         <input type="hidden" value='' class='end_date' name='end'/>
         <input type="hidden" value='<?php if(!empty($_POST['account_name'])){echo $_POST['account_name'] ;} ?>' class='account_name' name='account_name'/>
      </form>
   </div>
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	          <form class="form-search" method="post" action="<?= base_url() ?>bid_management/competitor_details">
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_POST['search']))echo $_POST['search'];?>">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               </span>
            </div>
         </div>
      </form>
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>bid_management/competitor_details">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
	   <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
			 <div id="demo" class="collapse">
			       <div class="col-md-3 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /*  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/accounts"> */?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="bid_management/accounts">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>bid_management/competitor_details" method="post" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
                     <?php if(!empty($competitor_details) && $can_view){ ?>
                     <form action="<?php echo base_url(); ?>bid_management/competitor_details" method="post">
                        <div class="row hidde_cls filter1">
                           <div class="col-md-12">
                              <div class="btn-group col-md-12"  role="group" aria-label="Basic example">
                                 <select class="form-control selectAjaxOption select2 select2-hidden-accessible" name="account_name" data-id="user_detail" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" required="required" data-where="c_id=<?php echo /*$_SESSION['loggedInUser']->c_id*/ $this->companyGroupId;  ?>">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                              <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="bid_management/accounts">
                           </div>
                        </div>
                     </form>
                     <?php } ?>
                 
            </div>
      </div>
   </div>
   <?php #if(!empty($competitor_details)){ ?>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         <input type="hidden" value='bid_prodct_price' id="table" data-msg="Bid Management" data-path="bid_management/deleteall"/>
         
         <div class="btn-group"  role="group" aria-label="Basic example">
		     <?php 
               if($can_add) {
               	//echo '<a href="'.base_url().'crm/editAccount/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
               	echo '<button type="button" class="btn btn-success add_bid_mng_tabs addBtn" data-toggle="modal" id="add" data-id="add_price_prodct"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add </button>';
               } ?>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>bid_management/competitor_details" method="post" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>								  
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            
            <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
         </div>
         
      </div>
   </div>
   <?php # } ?>	
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!-------------datatable-buttons--------->          
      
      <input type="hidden" id="visible_row" value=""/>
      <?php /*<table id="datatable-buttons" class="table table-striped table-bordered account_index" data-id="account" style="width:100%" border="1" cellpadding="3"> */ ?>
      <table id="mytable" class="table tblData table-striped table-bordered account_index" data-id="account" style="width:100%; margin-top:40px;" border="1" cellpadding="3">
      <thead>
         <tr>
            <th >All<br><input id="selecctall" type="checkbox"></th>
            <th scope="col" class="col-sm-1">Id</th>
            <th scope="col">Material ID</th>
            <th scope="col">Material Name</th>
            <th scope="col">Material Detail</th>
            <th scope="col">Created By</th>
            <th scope="col">Created Date</th>
            <th scope="col" class='hidde'>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php if(!empty($competitor_details)){
            foreach($competitor_details as $competitordetails){ 
                $action = '';
                if($can_edit) { 
            		//$action = $action.'<a href="'.base_url().'crm/editAccount/'.$account["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
            		$action =  '<a href="javascript:void(0)" id="'. $competitordetails["id"] . '" data-id="add_price_prodct" class="add_bid_mng_tabs btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $competitordetails["id"] . '"><i class="fa fa-pencil"></i> </a>';
            	}	
            	/*#if($can_view) { 				
            		$action .=  '<a href="javascript:void(0)" id="'. $competitordetails["id"] . '" data-id="account_view" class="add_crm_tabs btn btn-view   btn-xs" data-tooltip="View" id="' . $competitordetails["id"] . '"><i class="fa fa-eye"></i>  </a>';			
            	#}*/
            	
            
            	if($can_delete) { 
            		$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete"  class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'bid_management/deleteProdctPrice/'.$competitordetails["id"].'"><i class="fa fa-trash"></i></a>';
            	}
            
            	
            	$createdBy = getNameById('user_detail',$competitordetails['created_by'],'u_id');
            	if(!empty($createdBy)){
            		$createdByName = $createdBy->name;
            	}else{
            		$createdByName = '';
            	}
            
               $mat_id = getNameById('material_type',$competitordetails["material_type_id"],'id');
               $mat_Type_name = !empty($mat_id)?$mat_id->name:'';
            
               $mat_name_id = getNameById('material',$competitordetails["material_name"],'id');
               $mat_name = !empty($mat_name_id)?$mat_name_id->material_name:'';
            
            
               
            
            	$draftImage = '';
            	
            	echo "<td><input name='checkbox[]' class='checkbox1' type='checkbox'  data-ai=".$competitordetails['id']." value=".$competitordetails['id'].">";
						if($competitordetails['favourite_sts'] == '1'){
								echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$competitordetails['id']."  checked = 'checked'><br/>";
								echo"<input type='hidden' value='bid_prodct_price' id='favr' data-msg='Product' data-path='bid_management/markfavourite'  id-recd=".$competitordetails['id'].">";
						}else{
								echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$competitordetails['id']."><br/>";
								echo"<input type='hidden' value='bid_prodct_price' id='favr' data-msg='Product' data-path='bid_management/markfavourite'  id-recd =".$competitordetails['id'].">";
						
						}
						echo "</td>
						<td data-label='id:'>".$draftImage . $competitordetails['id']."</td>
						<td data-label='Material ID:'>".$mat_Type_name."</td>
						<td data-label='Material Name:'>".$mat_name."</td>";
			
               if($competitordetails['comp_price_info'] !=''){
                     $products = json_decode($competitordetails['comp_price_info']);
                     foreach($products as $product){
                        $comp_id = getNameById('bid_competitor_details',$product->compt_id,'id');
                        $comp_name = !empty($comp_id)?$comp_id->name:'';
                     } 
                  }
		
                  echo "<td data-label='Material Detail:'><a href='javascript:void(0)' id='". $competitordetails["id"] . "' data-id='view_price_prodct' class='add_bid_mng_tabs' data-tooltip='View' id='" . $competitordetails["id"] . "'>".$comp_name."</td>
               <td data-label='Created By:'>".$createdByName."</td>
               <td data-label='Created Date:'>".date("j F , Y", strtotime($competitordetails['created_date']))."</td>	
               <td data-label='action:' class='hidde'>".$action."</td>	
               </tr>";
               }
               } ?>
            </tbody>
         </table>
   </div>
</div>
<div id="crm_add_modal" class="modal fade in"  role="dialog">
<div class="modal-dialog modal-lg modal-large">
<div class="modal-content" style="display:table;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
</button>
<h4 class="modal-title" id="myModalLabel">Details</h4>
</div>
<div class="modal-body-content"></div>  
</div>
</div>
</div>
<script>
   var measurementUnits = '';
   
</script>