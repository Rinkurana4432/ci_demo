<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <form class="form-search" method="get" action="<?= base_url() ?>account/delivery_chln_inword">
            <div class="col-md-6">
               <div class="input-group">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-check"></i>
                  </span>
                  <input type="text" class="form-control search-query" placeholder="Enter Challan Number" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>" data-ctrl="account/delivery_chln_inword?tab=<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
				  <input type="hidden" name="tab" value="<?php if(isset($_GET['tab']))echo $_GET['tab'];?>">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-purple btn-sm">
                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                  Search
                  </button>
                  <a href="<?php echo base_url(); ?>account/delivery_chln_inword?tab=<?php if(isset($_GET['tab'])){echo $_GET['tab'];}?>"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
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
                           <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/delivery_chln_inword"/>
                        </div>
                     </div>
                  </div>
               </fieldset>
               <form action="<?php echo base_url(); ?>account/delivery_chln_inword" method="get" id="date_range">
                  <input type="hidden" value='' class='start_date' name='start'/>
                  <input type="hidden" value='' class='end_date' name='end'/>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row hidde_cls">
      <?php if($this->session->flashdata('message') != ''){
         echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
         setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
         }?>
      <p class="text-muted font-13 m-b-30"></p>
      <div class="row hidde_cls">
         <div class="col-md-12">
            <center>
               <div class="export_div">
                  <div class="btn-group"  role="group" aria-label="Basic example">
                     <?php if($can_add) {
                       // echo '<button type="button" class="btn btn-success addBtn add_challan_tabs" data-toggle="modal" id="add" data-id="add_challaninword"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
						echo '<a href="'.base_url().'account/delivery_challanInwardN" class="btn btn-success addBtn"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</a>';
                        } ?>
                     <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
                     <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                        <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" id="export-menu">
                           <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                           <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-3 datePick-right">
                     <form action="<?php echo base_url(); ?>account/delivery_chln_inword" method="get" id="date_range">
                        <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
                        <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
                        <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
                        <input type="hidden" value='<?php if(isset($_GET['tab']))echo $_GET['tab'];?>' name='tab'/>
                     </form>
                     <form action="<?php echo site_url(); ?>account/delivery_chln_inword" method="get" id="export-form">
                        <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                        <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
                        <input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
                        <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
                        <input type="hidden" value='<?php if(isset($_GET['tab']))echo $_GET['tab'];?>' name='tab'/>
                     </form>
                  </div>
               </div>
            </center>
         </div>
      </div>
   </div>
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#tab_content_accepted_invoice" id="invoice_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="submit_challan()">Challan </a></li>
         <li role="presentation" class=""><a href="#rejected_invoice_tab" role="tab" id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="submit_auto()">Auto</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="tab_content_accepted_invoice" aria-labelledby="invoice_tab">
            <div id="print_div_content">
               <form id="challan_form"><input type="hidden" name="tab" value="challan"></form>
               <!---datatable-buttons--->
               <table id="" class="table table-striped table-bordered action-icons" data-id="account" style="width:100%" border="1" cellpadding="3">
                  <!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">---->
                  <thead>
                     <tr>
                        <th scope="col">Id<span><a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Challan Number<span><a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=desc" class="down"></a></span>
                        </th>
                        <th scope="col">Receiver Name<span><a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=asc" class="up"></a>
                           <a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=desc" class="down"></a></span>
                        </th>
                        <!--th>Sale Ledger</th-->
                        <th scope="col">Material</th>
                        <th scope="col">Challan Issue Date</th>
                        <th scope="col">Created By</th>
                        <th scope="col" class='hidde'>Edited By</th>
                        <th scope="col" class='hidde'>Created On</th>
                        <th scope="col" class='hidde'>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $date = $freeze_date->freeze_date;
                        	if(!empty($delivery_data)){
                        		foreach($delivery_data as $challan_dtl){

                        				$action = '';
                        				if($can_edit) {
                        						//$action .=  '<a  href="javascript:void(0)" id="'. $challan_dtl["id"] . '" data-id="add_challan" class="btn btn-edit add_challan_tabs   btn-xs" data-tooltip="Edit" id="' . $challan_dtl["id"] . '"><i class="fa fa-pencil" ></i>  </a>';

												$action .=  '<a href="'.base_url().'account/editdelivery_chlninword/'.$challan_dtl["id"].'"  class="btn btn-edit  btn-xs">Edit</a>';

                        						$action .=  '<a href="javascript:void(0)" id="'. $challan_dtl["id"] . '" data-id="challan_view_detailsinword" class="add_challan_tabs  btn  btn-xs"  id="' . $challan_dtl["id"] . '">View</a>';
                        						}
                        					if($can_delete) {
                        						$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn   btn  btn-xs"    data-href="'.base_url().'account/deleteChallan_detailsinward/'.$challan_dtl["id"].'" >Delete</a>';

                        					}
                        		$edited_by = ($challan_dtl['edited_by']!=0)?(getNameById('user_detail',$challan_dtl['edited_by'],'u_id')->name):'';

                        $material_id_datas_export = json_decode($challan_dtl['descr_of_goods'],true);

                        if($material_id_datas_export == ''){
                        }else{
                        $material_names_export = '';
                        foreach($material_id_datas_export  as $matrial_new_id_export){
                        	$material_id_get_export = $matrial_new_id_export['material_id'];
                        	@$material_name_export = ($material_id_get_export!=0)?(getNameById('material',$material_id_get_export,'id')->material_name):'';
                        	@$material_names_export .= $material_name_export.' ';

                        }
                        }


                        $draftImage = '';
                        if($challan_dtl['save_status'] == 0){
                            $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                        }
                        $party_name = getNameById('ledger',$challan_dtl['reciver_name'],'id');
                        $sale_ledger_name = getNameById('ledger',$challan_dtl['sale_ledger'],'id');
                        //<td><a href='javascript:void(0)' id='". $challan_dtl['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>
                        echo "<tr>
                        <td data-label='id:'>".$draftImage.$challan_dtl['id']."</td>
                        <td data-label='Challan Number:'>".$challan_dtl['challan_num']."</td>
                        <td data-label='Party Name:'><a href='javascript:void(0)' id='". $challan_dtl['reciver_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>";
                        	$material_id_datas = json_decode($challan_dtl['descr_of_goods'],true);

                        				foreach($material_id_datas as $materialData){
                        					//For not show discount detail in count
                        					if($materialData['material_id']!='' && $materialData['quantity'] !=''  ){//For not show discount detail in count
                        					$materialName = getNameById('material',$materialData['material_id'],'id');



                        					}
                        				}



							echo "<td data-label='Material:'><a style='cursor: pointer;' class='add_challan_tabs' id='".$challan_dtl['id']."' data-toggle='modal' data-id='challan_mat_view_details'>".$materialName->material_name."</a></td>

                        	<td data-label='Challan Issue Date:' class='hidde'>".date("j F , Y", strtotime($challan_dtl['challan_date']))."</td>
                        	<td data-label='Created By:'><a href='".base_url()."users/edit/".$challan_dtl['created_by']."' target='_blank'>".getNameById('user_detail',$challan_dtl['created_by'],'u_id')->name."</a></td>
                        	<td data-label='Edited By:' class='hidde'>".$edited_by."</td>
                        	<td data-label='Created On:' class='hidde'>".date("j F , Y", strtotime($challan_dtl['created_date']))."</td>
                        	<td data-label='action:' class='hidde action' ><i class='fa fa-cog'></i><div class='on-hover-action'>".$action."</div></td>
                        </tr>";

                        $position=25;
                        $Matrl_name = substr($material_names_export, 0, $position);
                        $output[] = array(
                        	   'Challan Number' => $challan_dtl['challan_num'],
                        	   'Party Name'  => $party_name->name,
                        	 //  'Sale Ledger' => $sale_ledger_name->name,
                        	   'Material Name' => $Matrl_name,
                        	   'Created Date' => date("d-m-Y", strtotime($challan_dtl['created_date'])),
                        	);
							//pre($output);
                        	$data3  = $output;
						  }

                          //pre($output);die;
							export_csv_excel($data3);
                        }
                        ?>
                  </tbody>
               </table>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="rejected_invoice_tab" aria-labelledby="auto_entery_tab">
            <form id="auto_form"><input type="hidden" name="tab" value="auto"></form>
            <table id="mytable_auto" class="table tblData table-striped table-bordered action-icons" data-id="account" style="width:100%" border="1" cellpadding="3">
               <!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">---->
               <thead>
                  <tr>
                     <th scope="col">Id<span><a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">Challan Number<span><a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=desc" class="down"></a></span>
                     </th>
                     <th scope="col">Party Name<span><a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=asc" class="up"></a>
                        <a href="<?php echo base_url(); ?>account/delivery_chln_inword?sort=desc" class="down"></a></span>
                     </th>
                     <!--th>Sale Ledger</th-->
                     <th scope="col">Material</th>
                     <th scope="col">Challan Issue Date</th>
                     <th scope="col">Created By</th>
                     <th scope="col" class='hidde'>Edited By</th>
                     <th scope="col" class='hidde'>Created On</th>
                     <th scope="col" class='hidde'>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $date = $freeze_date->freeze_date;
                     	if(!empty($delivery_data_auto)){
                     		foreach($delivery_data_auto as $challan_dtl){
                     			if($challan_dtl['challan_date'] == ''){
                     				$challan_date = '';
                     			}else{
                     				$challan_date = date("j F , Y", strtotime($challan_dtl['challan_date']));
                     			}


                     				$action = '';
                     				if($can_edit) {
                     						$action .=  '<a href="'.base_url().'account/editdelivery_chln_inwordinword/'.$challan_dtl["id"].'"  class="btn btn-edit  btn-xs" >Edit</a>';

                     						$action .=  '<a href="javascript:void(0)" id="'. $challan_dtl["id"] . '" data-id="challan_view_details" class="add_challan_tabs  btn  btn-xs"  id="' . $challan_dtl["id"] . '">View</a>';
                     						}
                     					if($can_delete) {
                     						$action = $action.'<a href="javascript:void(0)"  class="delete_listing btn  btn-delete  btn  btn-xs"  data-href="'.base_url().'account/deleteChallan_details/'.$challan_dtl["id"].'" >Delete</a>';

                     					}
                     		$edited_by = ($challan_dtl['edited_by']!=0)?(getNameById('user_detail',$challan_dtl['edited_by'],'u_id')->name):'';

                     $material_id_datas_export = json_decode($challan_dtl['descr_of_goods'],true);

                     if($material_id_datas_export == ''){
                     }else{
                     $material_names_export = '';
                     foreach($material_id_datas_export  as $matrial_new_id_export){
                     	$material_id_get_export = $matrial_new_id_export['material_id'];
                     	@$material_name_export = ($material_id_get_export!=0)?(getNameById('material',$material_id_get_export,'id')->material_name):'';
                     	@$material_names_export .= $material_name_export.' ';

                     }
                     }

                     $draftImage = '';
                     if($challan_dtl['save_status'] == 0)
                               $draftImage = '<img src="'.base_url(). 'assets/images/draft.png" class="img-circle" width="25%">';
                     $party_name = getNameById('ledger',$challan_dtl['party_name'],'id');
                     $sale_ledger_name = getNameById('ledger',$challan_dtl['sale_ledger'],'id');
                     //<td><a href='javascript:void(0)' id='". $challan_dtl['sale_ledger'] . "' data-id='ledger_view' class='add_account_tabs'>".$sale_ledger_name->name."</a></td>
                     echo "<tr>
                     <td data-label='id:'>".$draftImage.$challan_dtl['id']."</td>
                     <td data-label='Challan Number:'>".$challan_dtl['challan_num']."</td>
                     <td data-label='Party Name:'><a href='javascript:void(0)' id='". $challan_dtl['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>";
                     	$material_id_datas = json_decode($challan_dtl['descr_of_goods'],true);
                     		foreach($material_id_datas as $materialData){
                 					if($materialData['material_id']!='' && $materialData['quantity'] !=''  ){//For not show discount detail in count
                 					      $materialName = getNameById('material',$materialData['material_id'],'id');
                 					}
                     		}


                     	echo "<td data-label='Material :'><a style='cursor: pointer;' class='add_challan_tabs' id=".$challan_dtl['id']." data-toggle='modal' data-id='challan_mat_view_details'>".$materialName->material_name."</a></td>
                     			<td data-label='Challan Issue Date:' class='hidde'>".$challan_date."</td>
								<td data-label='Created By:'><a href='".base_url()."users/edit/".$challan_dtl['created_by']."' target='_blank'>".getNameById('user_detail',$challan_dtl['created_by'],'u_id')->name."</a></td>
								<td data-label='Edited By:' class='hidde'>".$edited_by."</td>
								<td data-label='Created On:' class='hidde'>".date("j F , Y", strtotime($challan_dtl['created_date']))."</td>
								<td data-label='action:' class='hidde action' ><i class='fa fa-cog'></i><div class='on-hover-action'>".$action."</div></td>
                     </tr>";

                     $position=25;
                     $Matrl_name = substr($material_names_export, 0, $position);
                     $output3[] = array(
                     	   'Challan Number' => $challan_dtl['challan_num'],
                     	   'Party Name'  => $party_name->name,
                     	   //'Sale Ledger' => $sale_ledger_name->name,
                     	   'Material Name' => $Matrl_name,
                     	   'Created Date' => date("d-m-Y", strtotime($challan_dtl['created_date'])),
                     	);
                     	$data33  = $output3;
                     	export_csv_excel($data33);

                     }
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
</div>
<div id="challan_add_modal" class="modal fade in"  role="dialog">
   <div class="modal-dialog modal-lg modal-large">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Challan Detail </h4>
         </div>
         <div class="modal-body-content"></div>
      </div>
   </div>
</div>
<?php $this->load->view('common_modal'); ?>
