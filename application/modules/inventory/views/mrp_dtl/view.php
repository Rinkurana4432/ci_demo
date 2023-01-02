<div class="table-responsive">
    <?php

     #echo $branch;
     #echo $material_type;
    // echo $material_subtype;
    ?>
    <div id="print_divv" class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
        <h3 class="Material-head">MRP Report Details
            <hr>
        </h3>
        <div class="col-md-12 col-xs-12 col-sm-6 label-left ">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label for="material">Company Branch</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>
                      <?php $getUnitName = getNameById('company_address',$mrp_dtl->company_branch,'compny_branch_id'); ?>
                      <?php echo !empty($getUnitName)?$getUnitName->company_unit:''; ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label for="material">Department</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>
                        <?php
                           if(!empty($mrp_dtl)){
                            $departmentData = getNameById('department',$mrp_dtl->department_id,'id');
                            if(!empty($departmentData)){
                               echo $departmentData->name;
                            }
                           }
                       ?>
                    </div>
                </div>
            </div>
             <div class="col-md-6 col-sm-12 col-xs-12 vertical-border">
               <div class="item form-group">
                  <label class="col-md-3 col-sm-12 col-xs-12">Month</label>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <?php  if(!empty($mrp_dtl)){ echo $mrp_dtl->month; } ?>
                  </div>
               </div>
            </div>
        </div>
        <hr>
        <div class="bottom-bdr"></div>
        <div class="container mt-3">
            <h3 class="Material-head">Product Details
                <hr>
            </h3>
            <table id="example08424" class="table table-striped table-bordered action-icons dataTable no-footer" style="width: 100%;" border="1" cellpadding="3" role="grid" aria-describedby="example084_info">
         <thead>
            <tr>
            <th>S No.</th>
            <th>Material Name</th>
            <th>UOM</th>
            <th>In Stock</th>
            <th>Required</th>
            <th>Total Order</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($mrp_dtl->mrp_data)){
                  $i = 1;
                  $s = 1;
                 $rr =  json_decode($mrp_dtl->mrp_data);
                  foreach ($rr as $mrp) {
                    $ee = getNameById('material',$mrp->mat_idd,'id');
                     $uom = getNameById('uom',$mrp->uom_selected_id,'id');
                     $uom_name = !empty($uom->uom_quantity)?$uom->uom_quantity:'';

                    # pre($uom_name);
            ?>
            <tr>
               <td><?php  echo $i++;  ?></td>
               <td><?php  echo !empty($ee)?$ee->material_name:''; ?></td>
               <td><?php  echo $uom_name;  ?> </td>
               <th><?php  echo "0" ?></th>
               <td><?php  echo $mrp->totl_ordr; ?></td>
               <td><?php  echo $mrp->totl_ordr; ?></td>
            </tr>
            <?php

            }

               }
            ?>
         </tbody>

      </table>
        <hr>
        <div class="bottom-bdr"></div>
            <hr>
        </h3>
    </div>
</div>

</div>
</div>
</div>
</div>

</div>
</div>

</div>

</div>

<div class="col-md-12 col-xs-12">
    <center>
        <?php /* <button  type="button"  class="btn btn-default" onclick="printJS('<?php echo base_url().'crm/Quotcreate_pdf/'.$quotation->id ?>')">Print</button> */ ?>
        <button class="btn edit-end-btn hidden-print" id="btnPrint"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
        <?php  if(!empty($mrp_dtl)) { echo '<a href="'.base_url().'inventory/create_mrp_pdf/'.$mrp_dtl->id.'" target="_blank"><button class="btn edit-end-btn ">Generate PDF</button></a>'; } ?>  
    </center>
</div>