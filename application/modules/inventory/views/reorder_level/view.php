<div class="table-responsive">
    <?php

     #echo $branch;
     #echo $material_type;
    // echo $material_subtype;
    ?>
    <div id="print_divv" class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;">



        <h3 class="Material-head">Report Details
            <hr>
        </h3>
        <div class="col-md-12 col-xs-12 col-sm-6 label-left "> 
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label for="material">Created By</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>
                      <?php $created_by = ($report_data->created_by!=0)?(getNameById('user_detail',$report_data->created_by,'u_id')->name):''; ?>
                      <?php echo $created_by; ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label for="material">Report Date</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>
                      <?php echo  $report_data->report_date; ?>
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
            <div class="well pro-details" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; ; margin-top: 15px;">
                <?php if(!empty($report_data) && $report_data->inventory_items!=''){ 
                      
					$products = json_decode($report_data->inventory_items);
				?>
                <div class="col-container mobile-view3">
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">S.No</div>
                    <div class="col-md-2 col-sm-12 col-xs-12 form-group">Product Code</div>
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">Type</div>
                    <div class="col-md-2 col-sm-12 col-xs-12 form-group">Sub-Type</div>
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">Product Name</div>
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">Clossing Balance</div>
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">UOM</div>
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">Reorder Quantity</div>
                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">Branch</div>
                </div>
                <?php
						$i =1;
							foreach($products as $product){

                                // if((!empty($branch) && $product->location_id == $branch) || (!empty($material_type) && $product->type == $material_type) || (!empty($material_subtype) && $product->sub_type == $material_subtype) ){
										$materialType = getNameByID('material_type',$product->type,'id');
                                        $locationName = getNameById('company_address', $product->location_id, 'id');
                                        $pro_type = !empty($product->sub_type)?$product->sub_type:'N/A';
										// $productDetail = getNameById('material',$product->product,'id');
										// $materialName = !empty($productDetail)?$productDetail->material_name:'';
								?>
                    <div class="row-padding col-container mobile-view view-page-mobile-view">
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                            <label>S.No</label>
                            <div>
                                <?php echo $i; ?>
                            </div>

                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                            <label>Product Code</label>
                            <div>
                                <h5>
                                    <?php echo $product->product_code ; ?>
                                </h5>
                            </div>

                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                            <label>Type</label>
                            <div>
                                <?php if(!empty($materialType)){echo $materialType->name ;} else {echo "N/A";} ?>
                            </div>

                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                            <label>Sub-Type</label>
                            <div>
                                <?php echo $pro_type; ?>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                            <label>Product Name</label>
                            <div>
                                <?php echo $product->product_name; ?>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
                            <label>Clossing Balance</label>
                            <div>
                                <?php echo $product->clossing_balance; ?>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                            <label>UOM</label>
                            <div>
                                <?php
										$ww =  getNameById('uom', $product->uom,'id');
										$uom = !empty($ww)?$ww->ugc_code:'N/A';
										echo $uom;
								?>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                            <label>Net Qty</label>
                            <div>
                                <?php echo $product->reorder_quantity; ?>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
                            <label>Branch</label>
                            <div>
                                <?php echo (!empty($locationName->location) ? $locationName->location : '') ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $i++;}?>
            </div>
        </div>
        </div>
        <?php } ?>
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
        <?php  if(!empty($report_data)) { echo '<a href="'.base_url().'inventory/create_pdf/'.$report_data->id.'" target="_blank"><button class="btn edit-end-btn ">Generate PDF</button></a>'; } ?>  
    </center>
</div>