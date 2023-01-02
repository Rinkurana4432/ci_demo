<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>account/voucher_detail">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter id,Voucher Name" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/voucher_detail?tab=<?php if(!empty($_GET['tab']))echo $_GET['tab'];?>">
                  <input type="hidden" value='<?php if(!empty($_GET['tab']))echo $_GET['tab']; else echo 'voucher';?>' name='tab'/>
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>account/voucher_detail?tab=<?php if(!empty($_GET['tab']))echo $_GET['tab']; else echo 'voucher';?>">
                  <input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
                  </span>
               </div>
            </div>
         </form>
		 <button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button> 
			 <div id="demo" class="collapse">
			  <div class="col-md-12 col-xs-12 datePick-left">
            <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/voucher_detail"/>
                     </div>
                  </div>
               </div>
            </fieldset>
         </div>
			 </div>
      </div>
   </div>
   <?php
      setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
      ?>	
   <div class="row hidde_cls export_div">
      <div class="col-md-12">
         
         <form action="<?php echo base_url(); ?>account/voucher_detail" method="get" id="date_range">	
            <input type="hidden" value='' class='start_date' name='start'/>
            <input type="hidden" value='' class='end_date' name='end'/>
            <input type="hidden" value='<?php if(isset($_GET['tab']))echo $_GET['tab'];?>' name='tab'/>
         </form>
       
            <div class="btn-group"  role="group" aria-label="Basic example">
			   <?php if($can_add) {
              // echo '<button type="button" class="btn btn-success addBtn add_voucher_details_tabs " data-toggle="modal" id="add" data-id="voucher_dtl_add"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
			  echo '<a href="'.base_url().'account/Create_VoucherDtl" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
			  
               } ?>
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
               <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
               <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
                  <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="export-menu">
                     <li id="export-to-excel"><a href="#" title="Please check your open office Setting">Export to excel</a></li>
                     <li id="export-to-csv"><a href="#" title="Please check your open office Setting">Export to csv</a></li>
                     <!--li id="export-to-pdf"><a href="#" title="Please check your open office Setting">Export to Pdf</a></li-->
                  </ul>
               </div>
            </div>
        
      </div>
   </div>
   <form action="<?php echo site_url(); ?>account/voucher_detail?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>" method="get" id="export-form">
      <input type="hidden" value='' id='hidden-type' name='ExportType'/>
      <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
      <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
      <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
      <input type="hidden" value='<?php if(isset($_GET['tab']))echo $_GET['tab'];?>' name='tab'/>
   </form>
   <?php if($this->session->flashdata('message') != ''){
      echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
      }?>
   <p class="text-muted font-13 m-b-30"></p>
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#tab_content_accepted_invoice" id="invoice_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="submit_direct_voucher();">Voucher</a></li>
         <li role="presentation" class=""><a href="#rejected_invoice_tab" role="tab" id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="submit_auto_entry_voucher();">Auto Entry</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="tab_content_accepted_invoice" aria-labelledby="invoice_tab">
            <div id="print_div_content">
               <form id="direct_voucher_frm">	<input type="hidden" value="voucher" name="tab">	</form>
               <table id="" class="table table-striped table-bordered user_index" data-id="account" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th scope="col">Id
                           <span><a href="<?php echo base_url(); ?>account/voucher_detail?tab=voucher&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/voucher_detail?tab=voucher&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Voucher Name
                           <span><a href="<?php echo base_url(); ?>account/voucher_detail?tab=voucher&sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/voucher_detail?tab=voucher&sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Credit/Debit Info</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Voucher Date</th>
                        <th scope="col">Created By</th>
                        <th scope="col" class='hidde'>Edited By</th>
                        <th scope="col" class='hidde'>created On</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $date = $freeze_date->freeze_date;

                         if(!empty($voucher_dtls)){
                          foreach($voucher_dtls as $voucher_dtls_chk){
                          $action = '';
                        if($can_edit) { 
                        	if($voucher_dtls_chk['created_date'] < $date){
                        		$action .=  '<a href="javascript:void(0)" disabled="disabled" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_add" class="add_voucher_details_tabs btn btn-info btn-xs" id="' . $voucher_dtls_chk["id"] . '">Edit</a>';
                        	}else{
                        	
                        		//$action .=  '<a href="javascript:void(0)" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_add" class="add_voucher_details_tabs btn btn-info btn-xs" id="' . $voucher_dtls_chk["id"] . '"><i class="fa fa-pencil"></i></a>';
								
								$action .=  '<a href="'.base_url().'account/editVoucher_detail/'.$voucher_dtls_chk["id"].'"  class="btn btn-edit  btn-xs callKeyup_func" >Edit</a>';
								
								
								
                        		//$action .=  '<a href="javascript:void(0)" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_view" class="add_voucher_details_tabs btn btn-warning btn-xs" id="' . $voucher_dtls_chk["id"] . '"><i class="fa fa-eye"></i> View </a>';
                        	}
                        	$action .=  '<a href="javascript:void(0)" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_view" class="add_voucher_details_tabs btn btn-warning btn-xs"  id="' . $voucher_dtls_chk["id"] . '">View</a>';
                        }
                        	if($can_delete) { 
                        		if($voucher_dtls_chk['created_date'] < $date){
                        			$action = $action.'<a href="javascript:void(0)" disabled="disabled"  class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deleteVoucher_details/'.$voucher_dtls_chk["id"].'">Delete</a>';
                        		}else{
                        		$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-danger  btn btn-info btn-xs" data-href="'.base_url().'account/deleteVoucher_details/'.$voucher_dtls_chk["id"].'">Delete</a>';
                        		}
                        	}
                        	
                        	$draftImage = '';	
                        	if($voucher_dtls_chk['save_status'] == 0)
                        	$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                        
                        	$edited_by = ($voucher_dtls_chk['edited_by']!=0)?(getNameById('user_detail',$voucher_dtls_chk['edited_by'],'u_id')->name):'';
                        	$get_voucher_type = getNameById('voucher_type',$voucher_dtls_chk['voucher_name'],'id');
                        	
                        	$created_date = date("d-m-Y", strtotime($voucher_dtls_chk['created_date']));
                        	$voucher_date = date("d-m-Y", strtotime($voucher_dtls_chk['voucher_date']));
                        echo "<tr>
                        	<td data-label='Id:'>".$draftImage.$voucher_dtls_chk['id']."</td>
                        	<td data-label='Voucher Name:'>".$get_voucher_type->voucher_name."</td>  
                        	<td data-label='Credit/Debit Info:'>";
								$credit_debit_detail = json_decode($voucher_dtls_chk['credit_debit_party_dtl']);
								$countCreditLength = count($credit_debit_detail);
								$i = 1;
								foreach($credit_debit_detail as $creditDebitInfo){
									$partyName = getNameById('ledger',$creditDebitInfo->credit_debit_party_dtl,'id'); 
                        		}
                        	
							
							
                        	echo "<a href='javascript:void(0);' id='".$voucher_dtls_chk["id"]."' 
							class='add_voucher_details_tabs' data-id='voucher_dtl_viewDtl'>". $partyName->name ."</a></td>
                        	<td data-label='Total Amount:'>".money_format('%!i',$voucher_dtls_chk['total'])."</td>
                        	<td data-label='Voucher Date:'>".$voucher_date."</td>
                        	<td data-label='Created By:'><a href='".base_url()."users/edit/".$voucher_dtls_chk['created_by']."' target='_blank'>".getNameById('user_detail',$voucher_dtls_chk['created_by'],'u_id')->name."</a></td>
                        	<td data-label='Edited By:' class='hidde'><a href='".base_url()."users/edit/".$voucher_dtls_chk['edited_by']."' target='_blank'>".$edited_by."</a></td>	
                        	<td data-label='created On:' class='hidde'>".$created_date."</td>	
                        	<td data-label='Action:' class='hidde action'><i class='fa fa-cog'></i><div class='on-hover-action'>".$action."</div></td>	
                        </tr>";
                        
                        
                        $output[] = array(
                               'voucher ID' =>  $voucher_dtls_chk['id'], 
                        	   'Voucher Name' => $get_voucher_type->voucher_name,
                        	   'Credit Amount'  => $voucher_dtls_chk['total'],
                        	   'Debit Amount'  => $voucher_dtls_chk['total'],
                        	   'Created Date' => $created_date,
                        	   'Created By' => getNameById('user_detail',$voucher_dtls_chk['created_by'],'u_id')->name
                        	);	   
                        }
                        $data3  = $output;
                        //pre($data3);
                        export_csv_excel($data3); 
                         }else{
							echo '<tr><td colspan="9" style="text-align: center; vertical-align: middle;">Data Not Available</td></tr>'; 
						 }
                        ?>
                  </tbody>
               </table>
               <?php //ho $this->pagination->create_links(); ?>
            </div>
         </div>
         <!-- voucher Entry Auto Added Start-->
         <form id="auto_entery_voucher_frm"><input type="hidden" value="drct_voucherr" name="tab"></form>
         <div role="tabpanel" class="tab-pane fade" id="rejected_invoice_tab" aria-labelledby="auto_entery_tab">
            <table id="" class="table table-striped table-bordered user_index" data-id="account" border="1" cellpadding="3">
               <thead>
                  <tr>
                     <th scope="col">Id
                        <span><a href="<?php echo base_url(); ?>account/voucher_detail?tab=drct_voucherr&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/voucher_detail?tab=drct_voucherr&sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">Voucher Name
                        <span><a href="<?php echo base_url(); ?>account/voucher_detail?tab=drct_voucherr&sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/voucher_detail?tab=drct_voucherr&sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">Credit/Debit Info</th>
                     <th scope="col">Total Amount</th>
                     <th scope="col">Voucher Date</th>
                     <th scope="col">Created By</th>
                     <th scope="col" class='hidde'>Edited By</th>
                     <th scope="col" class='hidde'>created On</th>
                     <th scope="col" class='hidde'>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                     $date = $freeze_date->freeze_date;
                      if(!empty($voucher_dtls_auto)){
                       foreach($voucher_dtls_auto as $voucher_dtls_chk){
                       
                       $action = '';
                     if($can_edit) { 
                     	if($voucher_dtls_chk['created_date'] < $date){
                     		$action .=  '<a href="javascript:void(0)" disabled="disabled" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_add" class="add_voucher_details_tabs btn btn-info btn-xs" id="' . $voucher_dtls_chk["id"] . '"><i class="fa fa-pencil"></i></a>';
                     	}else{
                     	
                     		$action .=  '<a href="javascript:void(0)" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_add" class="add_voucher_details_tabs btn btn-info btn-xs" id="' . $voucher_dtls_chk["id"] . '"><i class="fa fa-pencil"></i></a>';
                     		//$action .=  '<a href="javascript:void(0)" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_view" class="add_voucher_details_tabs btn btn-warning btn-xs" id="' . $voucher_dtls_chk["id"] . '"><i class="fa fa-eye"></i> View </a>';
                     	}
                     	$action .=  '<a href="javascript:void(0)" id="'. $voucher_dtls_chk["id"] . '" data-id="voucher_dtl_view" class="add_voucher_details_tabs btn btn-warning btn-xs" id="' . $voucher_dtls_chk["id"] . '"><i class="fa fa-eye"></i></a>';
                     }
                     	if($can_delete) { 
                     		if($voucher_dtls_chk['created_date'] < $date){
                     			$action = $action.'<a href="javascript:void(0)" disabled="disabled"  class="delete_listing btn btn-danger add_voucher_details_tabs btn btn-info btn-xs" data-href="'.base_url().'account/deleteVoucher_details/'.$voucher_dtls_chk["id"].'"><i class="fa fa-trash"></i></a>';
                     		}else{
                     		$action = $action.'<a href="javascript:void(0)" class="delete_listing btn btn-danger add_voucher_details_tabs btn btn-info btn-xs" data-href="'.base_url().'account/deleteVoucher_details/'.$voucher_dtls_chk["id"].'"><i class="fa fa-trash"></i></a>';
                     		}
                     	}
                     	
                     	$draftImage = '';	
                     	if($voucher_dtls_chk['save_status'] == 0)
                     	$draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                     
                     	$edited_by = ($voucher_dtls_chk['edited_by']!=0)?(getNameById('user_detail',$voucher_dtls_chk['edited_by'],'u_id')->name):'';
                     	$get_voucher_type = getNameById('voucher_type',$voucher_dtls_chk['voucher_name'],'id');
                     
                     	$created_date = date("j F , Y", strtotime($voucher_dtls_chk['created_date']));
                     	$voucher_date = date("j F , Y", strtotime($voucher_dtls_chk['voucher_date']));
                     echo "<tr>
                     	<td data-label='Id:'>".$draftImage.$voucher_dtls_chk['id']."</td>
                     	<td data-label='Voucher Name:'>".$get_voucher_type->voucher_name."</td>  
                     	<td data-label='Credit/Debit Info:'>";
                     			$credit_debit_detail = json_decode($voucher_dtls_chk['credit_debit_party_dtl']);
                     				$countCreditLength = count($credit_debit_detail);
                     				$i = 1;
                     				foreach($credit_debit_detail as $creditDebitInfo){
                     					$partyName = getNameById('ledger',$creditDebitInfo->credit_debit_party_dtl,'id'); 
                     							//}else{
                     							//	$partyName = getNameById('supplier',$creditDebitInfo->credit_debit_party_dtl,'id'); 
                     							//}	
                     					
                     				}
                     			
                     
                     	echo "<a href='javascript:void(0);' id='".$voucher_dtls_chk["id"]."' 
							class='add_voucher_details_tabs' data-id='voucher_dtl_viewDtl'>". $partyName->name ."</a></td>
                     	<td data-label='Total Amount:'>".$voucher_dtls_chk['total']."</td>
                     	<td data-label='Voucher Date:'>".$voucher_date."</td>
                     	<td data-label='Created By:'><a href='".base_url()."users/edit/".$voucher_dtls_chk['created_by']."' target='_blank'>".getNameById('user_detail',$voucher_dtls_chk['created_by'],'u_id')->name."</a></td>
                     	<td data-label='Edited By:' class='hidde'><a href='".base_url()."users/edit/".$voucher_dtls_chk['edited_by']."' target='_blank'>".$edited_by."</a></td>	
                     	<td data-label='created On:' class='hidde'>".$created_date."</td>	
                     	<td data-label='Action:' class='hidde'>".$action."</td>	
                     </tr>";
                     
                     
                      $output[] = array(
                             'voucher ID' =>  $voucher_dtls_chk['id'], 
                     	    'Voucher Name' => $get_voucher_type->voucher_name,
                     	    'Credit Amount'  => $voucher_dtls_chk['total'],
                     	  'Debit Amount'  => $voucher_dtls_chk['total'],
                     	  'Created Date' => $created_date,
                     	  'Created By' => getNameById('user_detail',$voucher_dtls_chk['created_by'],'u_id')->name
                     	 );	   
                     }
                     $data3  = $output;// table id=datatable-buttons
                     export_csv_excel($data3); 
                      }
                     ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <?php echo $this->pagination->create_links(); ?>	
   <div id=":kb" class="J-J5-Ji amH J-JN-I" role="button" aria-expanded="false" tabindex="0" aria-haspopup="true" aria-label="Show more messages" style="user-select: none;">
      <?php echo $result_count; ?></span>
   </div>
   <div id="voucher_dtl_add_modal" class="modal fade in"  role="dialog">
      <div class="modal-dialog modal-lg modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Voucher Detail</h4>
            </div>
            <div class="modal-body-content"></div>
         </div>
      </div>
   </div>
</div>