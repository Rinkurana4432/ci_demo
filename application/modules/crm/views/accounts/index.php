 
<div class="x_content">
   <?php
      if($this->session->flashdata('message') != ''){
            echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
         }
      
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
      
      
      
       ?>
   <div class="stik">
      <form action="<?php echo site_url(); ?>crm/accounts" method="get" id="export-form">
         <input type="hidden" value='' id='hidden-type' name='ExportType'/>
         <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
         <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
         <input type="hidden" value='<?php if(isset($_GET['favourites']))echo $_GET['favourites'];?>' name='favourites'/>
         <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
         <input type="hidden" value='<?php if(isset($_GET['account_name']))echo $_GET['account_name'];?>' name='account_name'/>
      </form>
   </div>
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
           <form class="form-search" method="post" action="<?= base_url() ?>crm/accounts">
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="crm/accounts">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               <a href="<?php echo base_url(); ?>crm/accounts">
               <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </span>
            </div>
         </div>
      </form>
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/accounts">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <!--<button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#demo" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
                <div id="demo" class="collapse" aria-expanded="false" style="height: 2px;">
       <div class="col-md-12 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /*  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/accounts"> */?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/accounts">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>crm/accounts" method="get" id="date_range">  
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
                     <?php if(!empty($accounts) && $can_view){ ?>
                     <form action="<?php echo base_url(); ?>crm/accounts" method="get">
                        <div class="row hidde_cls filter1">
                           <div class="col-md-12">
                              <div class="btn-group col-md-12"  role="group" aria-label="Basic example">
                                 <select class="form-control selectAjaxOption select2 select2-hidden-accessible" name="account_name" data-id="user_detail" data-key="u_id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" required="required" data-where="c_id=<?php echo /*$_SESSION['loggedInUser']->u_id*/ $this->companyGroupId;  ?>">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                              <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="crm/accounts">
                           </div>
                        </div>
                     </form>
                     <?php } ?>
                  </div>
               </ul>-->
            
     </div>
   </div>
   <?php //if(!empty($accounts)){ ?>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         <input type="hidden" value='account' id="table" data-msg="Company" data-path="crm/accounts"/>
        
         <div class="btn-group"  role="group" aria-label="Basic example">
           <?php 
               if($can_add) {
                  //echo '<a href="'.base_url().'crm/editAccount/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
                  echo '<button type="button" class="btn  btn-success add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="account"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
               } ?>
            <!--<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                  <li id="export-to-csv"><a href="<?php echo base_url();?>assets/modules/crm/downloads/company.xls" title="Please check your open office Setting">Export to Blank Excel</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>crm/accounts" method="get" style="display: inline-block;">
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
               <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>                          
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            <!--<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
         
            <!--<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Import<span class="caret"></span></button>
               <ul class="dropdown-menu import-bar" role="menu" id="export-menu">
                  <li>
                     <form action="<?php echo base_url(); ?>crm/importCompanies" method="post" enctype="multipart/form-data">  
                        <input type="file" class="form-control col-md-2" name="uploadFile" id="file" style="width: 70%">
                        <input type="submit" class="form-control col-md-2" name="importe" value="Import" style="width: 30%;"/>
                  </li>
                  </form>
               </ul>
            </div>-->
            </div>
      </div>
   </div>
   <?php //} ?>  
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!-------------datatable-buttons--------->          
      
      <?php /*<table id="datatable-buttons" class="table table-striped table-bordered account_index" data-id="account" style="width:100%" border="1" cellpadding="3"> */ ?>
      <table id="mytable" class="table tblData table-striped table-bordered account_index" data-id="account" style="width:100%;margin-top: 44px;" border="1" cellpadding="3">
         <thead>
            <tr>
               <th></th>
               <th  scope="col" class="col-sm-1">Id
                  <span><a href="<?php echo base_url(); ?>crm/accounts?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>crm/accounts?sort=desc" class="down"></a></span>  
               </th>
               <th scope="col">Buyer Name
                  <span><a href="<?php echo base_url(); ?>crm/accounts?sort=asc" class="up"></a>
                  <a href="<?php echo base_url(); ?>crm/accounts?sort=desc" class="down"></a></span>     
               </th>
               <th scope="col">Contact Name</th>
               <th scope="col">Phone</th>
               <th scope="col">Email</th>
                <!--<th scope="col">GSTIN</th>-->
               <th scope="col">Created By</th>
               <th scope="col">Created Date</th>
               <th scope="col" class='hidde'>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($accounts)){
               foreach($accounts as $account){ 
                   $action = '';
                   if($can_edit) { 
                     //$action = $action.'<a href="'.base_url().'crm/editAccount/'.$account["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
                     $action =  '<a href="javascript:void(0)" id="'. $account["id"] . '" data-id="account" class="add_crm_tabs btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $account["id"] . '"><i class="fa fa-pencil"></i> </a>';
                  }  
                  #if($can_view) {           
                     $action .=  '<a href="javascript:void(0)" id="'. $account["id"] . '" data-id="account_view" class="add_crm_tabs btn btn-view   btn-xs" data-tooltip="View" id="' . $account["id"] . '"><i class="fa fa-eye"></i>  </a>';         
                  #}
                  
               
                  if($can_delete) { 
                     $action = $action.'<a href="javascript:void(0)" data-tooltip="Delete"  class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteAccount/'.$account["id"].'"><i class="fa fa-trash"></i></a>';
                  }
               
                  
                  $createdBy = getNameById('user_detail',$account['created_by'],'u_id');
                  if(!empty($createdBy)){
                     $createdByName = $createdBy->name;
                  }else{
                     $createdByName = '';
                  }
                  $draftImage = '';
				  //<input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  data-ai=".$account['id']." value=".$account['id'].">
                  if($account['save_status'] == 0)
                  $draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
               <img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                  echo "<td>";
                                          if($account['favourite_sts'] == '1'){
                                                echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$account['id']."  checked = 'checked'><br/>";
                                                echo"<input type='hidden' value='account' id='favr' data-msg='Company' data-path='crm/accounts'  id-recd=".$account['id'].">";
                                          }else{
                                             echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$account['id']."><br/>";
                                             echo"<input type='hidden' value='account' id='favr' data-msg='Company' data-path='crm/accounts'  id-recd =".$account['id'].">";
                                       
                                          }
                                          
                                          echo "</td>
                     <td data-label='Id:'>".$draftImage . $account['id']."</td>
                     <td data-label='Company Name:'>".$account['name']."</td>
                     <td data-label='Phone:'>".$account['contact_name']."</td>
                     <td data-label='Phone:'>".$account['phone']."</td>
                     <td data-label='Email:'>".$account['email']."</td>
                     <td data-label='Gstin:' style='display:none;'>".$account['gstin']."</td>
                     <td data-label='created by:'>".$createdByName."</td>
                     <td data-label='Created Date:'>".date("j F , Y", strtotime($account['created_date']))."</td> 
                     <td data-label='action:' class='hidde'>".$action."</td>  
                  </tr>";
                $output[] = array(
                     'Account ID' => $account['id'],
                     'Account Name' => $account['name'],
                     'Phone No' => $account['phone'],
                     'Email' => $account['email'],
                     'Gstin' => $account['gstin'],
                     'Created By' => $createdByName,
                     'Created Date' => date("d-m-Y", strtotime($account['created_date'])),
                  ); 
               }
               $data3  = $output;
               
               export_csv_excel($data3);
               } ?>
         </tbody>
      </table>
      <?php echo $this->pagination->create_links(); ?>   
   </div>
</div>
<div id="crm_add_modal1" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title nxt_cls" id="myModalLabel">Company</h4>
         </div>
         <div class="modal-body-content1"></div>
      </div>
   </div>
</div>
<div id="crm_add_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Company</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<script>
   var measurementUnits = '';
   
</script>