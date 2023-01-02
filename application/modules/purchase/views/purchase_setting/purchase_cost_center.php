<div role="tabpanel" class="tab-pane fade " id="purchase_cost_center" aria-labelledby="purchase_cost_center-tab">
   <form id="purchase_cost_form"><input type="hidden" name="tab" value="purchase_cost_center"/></form>
   <div role="tabpanel" class="tab-pane fade active in" id="budget_tab_content1" aria-labelledby="shift-tab">
                  <div class="x_content">
                     <form action="<?php echo site_url(); ?>purchase/purchase_setting" method="get" id="export-form">
                        <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                        <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
                        <input type="hidden" value='' class='start_date' name='start'/>
                        <input type="hidden" value='' class='end_date' name='end'/>
                        <input type="hidden" value='<?php echo $_GET['tab']; ?>' name="tab"/>
                        <input type="hidden" value='<?php echo $_GET['search']; ?>' name="search"/>
                     </form>
                     <p class="text-muted font-13 m-b-30"></p>
                     <input type="hidden" id="loggedInUserId" value="<?php //echo $_SESSION['loggedInUser']->id ; ?>">   
                     <div id="print_div_content">
                        <form id="purchase_setting_frm"><input type="hidden" name="tab" value="purchase_setting"/></form>
                        <table id="" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
                           <thead>
                              <tr>
                                 <th scope="col">Id</th>
                                 <th scope="col">Cost Center Name</th>
                                 <th scope="col">Created By</th>
                                 <th scope="col">Created Date</th>
                                 <th scope="col" class='hidde'>Action</th>
                              </tr>
                           </thead>
                           <tbody> 
                              <tr>
                              <?php 
                                 if($costCenter){
                                    foreach ($costCenter as $key => $value) { ?>
                                          <tr>
                                             <td><?= $value['id'] ?></td>
                                             <td><?= $value['cost_center_name'] ?></td>
                                             <td><?= $value['name'] ?></td>
                                             <td><?= date('d-m-Y',strtotime($value['created_date'])); ?></td>
                                             <td id="purchase_flow_setting">
                                                <label class="switch">
                                                  <input type="checkbox" value="1" class="onOffStatus" name="status" data-tbl="purchase_cost_center" data-where="id=<?= $value['id'] ?>" id="onoffStatus" <?= ($value['status'])?'checked':''; ?> data-msg="Cost Center Status Update Successfully" >
                                                  <span class="slider round"></span>
                                                </label>
                                                <a href="javascript:void(0)" id="<?= $value['id'] ?>" data-id="cost_center" data-tooltip="Edit" class="add_purchase_tabs btn btn-edit  btn-xs"><i class="fa fa-pencil"></i></a></td>
                                          </tr>
                                 <?php }
                                 }

                              ?>
                              </tr>
                              <?php 
                                 $output[] = "";
                                 $data3  = $output;   
                                 export_csv_excel($data3);  
                                 $data_balnk  = $output_blank;
                                 export_csv_excel_blank($data_balnk); 
                              ?>
                           </tbody>
                        </table>
                        <?php //echo $this->pagination->create_links(); ?>
                     </div>
                  </div>
               </div>
</div>