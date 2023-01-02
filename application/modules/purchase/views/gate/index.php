<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
    setlocale(LC_MONETARY, 'en_IN');//Function for Indian currency format
?>
<div class="x_content stik">
   <div class="col-md-12 col-sm-12 for-mobile">
        <div class="row hidde_cls stik">
         <div class="col-md-12 col-xs-12">
            <div class="export_div">
               <div class="btn-group"  role="group" aria-label="Basic example">
                  <?php if(true) { echo '<button type="buttton" class="btn btn-info order addBtn add_purchase_tabs" id="addGateEntry" data-id="convertPoToGate" data-toggle="modal"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button></a>'; } ?>   
               </div>
            </div>
         </div>
      </div>
   </div>
   <div role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#in_progress_tab" data-select='progress' id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true" onClick="poinprocess_form3()">In Process</a></li>
         <!-- <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select='complete' id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onClick="pocomplete_form3()">Complete</a></li> -->
      </ul>
      <div id="myTabContent" class="tab-content">
         <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
            <p class="text-muted font-13 m-b-30"></p>
            <input type="hidden" id="loggedInUserId" value="<?php echo $_SESSION['loggedInUser']->id ; ?>">	
            <form id="poinprocess_form"><input type="hidden" value="inprocess" name="tab"></form>
            <div id="print_div_content">
               <div class="table-responsive">
                  <?php  /* <table id="example" class="table table-bordered user_index sale_order_index inprocess_div" data-id="user" style="width:100%;" border="1" cellpadding="2" data-order='[[1,"desc"]]'> */ ?>
                  <table id="" class="table table-bordered user_index sale_order_index inprocess_div" data-id="user" style="width:100%;" border="1" cellpadding="2">
                     <thead>
                        <tr>
                           <th><input id="selecctall" type="checkbox"></th>
                           <th scope="col">Id
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           <th scope="col">Gate Entry No.</th>
                           <th scope="col">Order No.</th>
                           <th scope="col">Invoice No.</th>
                           <th scope="col">Supplier Name
                              <span><a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=asc" class="up"></a>
                              <a href="<?php echo base_url(); ?>purchase/purchase_order?tab=inprocess&sort=desc" class="down"></a></span>
                           </th>
                           
                           <th scope="col">Order Date</th>
                           <th scope="col" class='hidde'>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if( !empty($gateEnteryData) ){ 
                                 foreach ($gateEnteryData as $key => $value) { ?>
                                 <tr>
                                    <td><?php echo "<input name='checkbox[]' class='checkbox1 checkbox[]'  type='checkbox'  value=".$value['id'].">"; ?></td>
                                    <td><?= $value['id']; ?></td>
                                    <td><?= str_pad($value['gate_no'],5,0,STR_PAD_LEFT); ?></td>
                                    <td><?= $value['order_code']??'N/A'; ?></td>
                                    <td><?= $value['invoice_no']; ?></td>
                                    <td><?= $value['name']; ?></td>
                                    <td><?= $value['created_at']; ?></td>
                                    <td data-label="Action:"  Class='hidde'>
                                       <?php
                                          /*if($can_edit) { */
                                          if ($value['mrn_or_not'] != 1 && $value['convert_grn'] == 0 ) {
                                          echo '<button id="'.$value["id"].'" class="btn btn-xs convert add_purchase_tabs" data-id="convertPoToGate"><i class="fa fa-pencil"></i></button>'; 
                                          }
                                          /*}*/                    
                                          /*if ($can_view) {*/

                                          echo '<button id="' . $value["id"] . '" class="btn btn-view btn-xs add_purchase_tabs" data-tooltip="View" data-id="GateView"><i class="fa fa-eye"></i> </button>';
                                          /*}*/
                                          /*if($can_delete && $MRN["used_status"]==0)*/
                                          if ($value['mrn_or_not'] != 1 && $value['convert_grn'] == 0) {
                                             echo '<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing
                                             btn btn-delete btn-xs" data-href="'.base_url().'purchase/delete_gate/'.$value["id"].'"><i class="fa fa-trash"></i></a>';
                                          }
                                          
                                          $data_id = "convert_to_mrn";
                                          $data_tooltip = "GRN";
                                          $class = "btn  btn-xs convert add_purchase_tabs";
                                          if ($value['convert_grn'] != 1 ) {
                                                $disabled = "";
                                                if( $value['po_id'] != 0 ) {
                                                   $id = $value['po_id'];
                                                }else{
                                                   $data_id = "EditMRN";
                                                   $id = "MRN_add";
                                                }
                                          }else{                 
                                             $id = "javascript:void();";
                                             $disabled = "disabled";
                                             $class .= " indent";
                                          } ?>         
                                          <button data-id="<?= $data_id ?>" id="<?= $id; ?>" data-tooltip="<?= $data_tooltip ?>" class="<?= $class; ?>" data-gateId="<?= $value['pgeId']; ?>" <?= $disabled ?>>
                                          <img src="<?php  echo base_url();?>assets/modules/crm/uploads/convert.png">
                                          </button>
                                    </td>
                                 </tr>
                                    
                           <?php }
                              } ?>
                     </tbody>
                  </table>
                  <?php //echo $this->pagination->create_links(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php echo $this->pagination->create_links(); ?>
</div>

<div id="printView">
   <div id="purchase_add_modal" class="modal fade in" role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">
               <span aria-hidden="true">×
               </span>
               </button>
               <h4 class="modal-title chng_lbl add_title nxt_cls addtitle2" id="myModalLabel">Gate Entry</h4>
            </div>
            <div class="modal-body-content">
            </div>
         </div>
      </div>
   </div>
</div>