
<?php if($this->session->flashdata('message') != ''){?>                        
        <div class="alert alert-success col-md-6">                            
            <?php echo $this->session->flashdata('message');?>
        </div>                        
<?php }?>


<div class="x_content">
    <div class="row hidde_cls">
        <div class="col-md-12  export_div">
            <div class="col-md-4 col-xs-12 col-sm-6 datePick-left">                
            <fieldset>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend input-group">
                          <!--   <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span> -->
                           <!--  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment"> -->
                          <!--   <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="dailyreport/dailyreport_adjustment"> -->
                           
                        </div>
                    </div>
                </div>
            </fieldset>
            <form action="statusreport_adjustment" method="post" id="date_range">   
                <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                <input type="hidden" value='' id='hidden-type_blank_excel' name='ExportType_blank'/>
                <input type="hidden" value='' class='start_date' name='start'/>
                <input type="hidden" value='' class='end_date' name='end'/>
                <input type="hidden" value='<?php // if(!empty($_POST['company_unit'])){echo $_POST['company_unit'] ;} ?>' class='company_unit' name='company_unit'/>

            </form> 
            </div>
            <div class="btn-group"  role="group" aria-label="Basic example">
            <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                
            </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6 datePick-right">
                <!-- <button type="buttton" class="btn btn-infoaddBtn" id="clickStockCheckBtn" >Stock Check </button> -->
            </div>
        </div>
    </div> 
                        

                                         
                                          <?php 
                                             
                                        foreach ($users as $key => $value) {
                                                    
                                                  $all_data[]  =   getAttendanceById_twoDate('attendance','atten_date' ,$start_date,$end_date,$value['id'],'emp_id');
                                                   

                                        }           
                                           ?>
                                             
                                      <?php    print_r($all_data);exit;  ?>

                                        
                                </div>           
                               
 <?php #$this->load->view('backend/footer'); ?> 



