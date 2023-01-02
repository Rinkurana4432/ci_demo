<style type="text/css">	
   .invRadio span {
   padding: 10px;
   }
   .invRadioContainer {
   width: auto;
   display: table;
   margin-left: 348px;
   float: left;
   margin-top: 10px;
   }
   .invRadio span input[type="radio"] {
   margin-right: 6px;
   }
   .invRadioContainer .invRadio {
   float: left;
   margin: 0px 5px;
   }
   .invRadioContainer .invRadio label {
   width: auto;
   cursor: pointer;
   }
</style>
<div class="x_content">
   <div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
         <div class="col-md-4 ">
<!--             <fieldset>
               <div class="control-group">
                  <div class="controls">
                     <div class="input-prepend input-group">
                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                        <input type="text" style="width: 200px" name="EvaluationCurrentDate" id="EvaluationCurrentDate" class="form-control" value=""  data-table="inventory/inventory_valuation">
                     </div>
                  </div>
               </div>
            </fieldset> -->
         </div>
      </div>
   </div>
   <div class=" col-md-12 export_div">
      <div class="invRadioContainer">
            <div class="invRadio">
                  <label for="icp">Inventory Cost/Sale Price</label>
                  <input type="radio" name="accordingToInventory" onclick="window.location='<?= base_url('inventory/inventory_valuation') ?>';" 
                        value="1" id="icp" <?= (!$checkRadio)?'checked':''; ?>>
            </div>
            <div class="invRadio">
                  <label for="lsp">Last Sale Price</label>
                  <input type="radio" name="accordingToInventory" onclick="window.location='<?= base_url('inventory/inventory_valuation/2') ?>';" 
                           value="2" id="lsp" <?= ($checkRadio == 2 )?'checked':''; ?> >
            </div>
            <div class="invRadio">
                  <label for="lpp">Last Purchase Price</label>
                  <input type="radio" name="accordingToInventory" onclick="window.location='<?= base_url('inventory/inventory_valuation/3') ?>';" 
                     id="lpp" <?= ($checkRadio == 3)?'checked':''; ?>> 
            </div>
      </div>   
         
      <div class="btn-group"><button class = "btn  btn-success addBtn save" style="float:right;">Save</button></div>
   </div>
   <div class="" role="tabpanel" data-example-id="togglable-tabs" style="clear: both;">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
         <li role="presentation" class="active"><a href="#inventory_valuation" id="inventory_valuation-tab" role="tab" data-toggle="tab" aria-expanded="true">Inventory valuation</a>
         </li>
         <!-- <li role="presentation" class=""><a href="#non_available" role="tab" id="non_available-tab" data-toggle="tab" aria-expanded="false">Non-Available Material </a>
         </li> -->
      </ul>
      <div id="myTabContent" class="tab-content">
         <!-------------------inventoryevaluation-------------------------------->
         <div role="tabpanel" class="tab-pane fade active in" id="inventory_valuation" aria-labelledby="inventory_valuation-tab">
            <p class="text-muted font-13 m-b-30"></p>
            <table  class="table table-striped table-bordered user_index " data-id="user" id = "datatable-buttons_wrapper">
               <!--<table id="datatable-buttons" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
                  <table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">-->
               <thead>
                  <tr>
                     <th scope="col">Product Type</th>
                     <th scope="col">Total</th>
                     <th scope="col">Product Code</th>
                     <th scope="col">Product</th>
                     <?php switch ($checkRadio) {
                        case 2:
                           echo '<th scope="col">Last Sales Price</th>';
                           break;
                        case 3:
                           echo '<th scope="col">Last Purchase Price</th>';
                           break;
                     } ?>
                     <th scope="col">Quantity</th>
                     <th scope="col">Product Evaluation</th>
                  </tr>
               </thead>
               
               <tbody>
                  <?php 
                     if( $inventory_valuation ){
                        $grand_total = 0;
                        foreach ($inventory_valuation as $key => $value) {
                           
                           $total = array_sum(array_map(function($item) { 
                               return $item['product_evaluation']; 
                           }, $value));
                           $rowSpan = count($value);
                           $i = 1;

                           foreach ($value as $materialKey => $materialValue) {
                              $grand_total += $materialValue['product_evaluation'];
                              ?>
                              <tr>
                                <?php if( $i == 1 ){ ?>
                                 <td rowspan="<?= ($rowSpan)  ?>" ><?= $materialValue['material_type'] ?></td>
                                 <td rowspan="<?= ($rowSpan)  ?>" ><?= $total ?></td>
                                <?php } ?>
                                <td><?= $materialValue['material_code'] ?></td>
                                <td><?= $materialValue['material_name'] ?></td>
                                <td><?= $materialValue['sale_price'] ?></td>
                                <td><?= $materialValue['opening_balance'] ?></td>
                                <td><?= $materialValue['product_evaluation'] ?></td>
                              </tr>
                           <?php $i++; }

                              
                        }
                     }
                  ?>
                  <tr style="background-color:#DBFFD4;">
                     <td colspan="5" style="font-size:30px;">Grand total</td>
                     <td colspan="3" style="font-size:30px;"><?php if(!empty($grand_total)){echo "<b>".number_format($grand_total)."</b>"; }?></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <!-------------------end of tab-------------------------------------------->
         <!----------------------start of secodn tab---------------------------------------------->
         <div role="tabpanel" class="tab-pane fade" id="non_available" aria-labelledby="non_available-tab">
            <p class="text-muted font-13 m-b-30"></p>
            <table  class="table table-striped table-bordered user_index " data-id="user" id = "datatable-buttons_wrapper">
               <!--<table id="datatable-buttons" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
                  <table id="datatable-buttons" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3">-->
               <thead>
                  <tr>
                     <th scope="col">Type of Material</th>
                     <th scope="col">Total</th>
                     <th scope="col">Material Code</th>
                     <th scope="col">Material</th>
                     <th scope="col">Cost Price</th>
                     <th scope="col">Sales Price</th>
                     <th scope="col">Quantity</th>
                     <th scope="col">Material Evaluation</th>
                  </tr>
               </thead>
               <!--<tbody id="evaluation_data">-->
               <tbody>
                  <tr style="background-color:#DBFFD4;">
                     <td colspan="5" style="font-size:30px;">Grand total</td>
                     <td colspan="3" style="font-size:30px;"><?php if(!empty($grandTotal)){echo "<b>".number_format($grandTotal)."</b>"; }else{ echo "0";}?></td>
                  </tr>
               </tbody>
               <!---<tr><button class = "btn btn-success save2" style="float:right;">Save</button> <tr> --> 	                
            </table>
         </div>
         <!--------------------------end of tab------------------------------------------------>
      </div>
   </div>
</div>
<?php $this->load->view('common_modal'); ?>