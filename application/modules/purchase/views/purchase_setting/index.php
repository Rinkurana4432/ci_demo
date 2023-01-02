<style type="text/css">



</style>
<?php if($this->session->flashdata('message') != ''){?>                        
<div class="alert alert-info">                            
   <?php echo $this->session->flashdata('message');?> 
</div>
<?php }
   ?>
<div class="col-md-12 col-sm-12 col-xs-12 purchaseSettingPage">
   <div class="x_content stik">
      <div class="col-md-12 col-sm-12 for-mobile">
         
         <div class="row hidde_cls">
            <div class="col-md-12 col-xs-12">
              
			   <?php /*?>
               <div class="export_div" id="export_div_hide">
                  <div class="btn-group"  role="group" aria-label="Basic example">
                    
                     <button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm print_clsss" id="bbtn">Print</button>
                     <input type="hidden" value='material_type' id="table" data-msg="Purchase Setiing" data-path="purchase/purchase_setting"/>
                     <!--button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button-->              
                     <div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
                        <button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" id="export-menu">
                           <li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
                           <li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
                           <li id="export-to-blank-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to Blank Excel</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
			   <?php  */?>
            
            </div>
         </div>
      </div>
      <div class="x_content" style="margin-top: 20px;">
         <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
               <li role="presentation" class="active"><a href="#budget_tab_content1" id="budget-tab" role="tab" data-toggle="tab" aria-expanded="true" onclick="purchase_setting();">Purchase Budget</a></li>
               <!--li role="presentation" class=""><a href="#purchase_budget_limit" role="tab" id="purchase_budget_limit-tab" data-toggle="tab" aria-expanded="true" onclick="purchase_budget();">Purchase Settings</a></li>
               <li role="presentation" class=""><a href="#purchase_flow_setting" role="tab" id="purchase_flow_settings-tab" data-toggle="tab" aria-expanded="true" onclick="purchase_flow_settings();"> Purchase Flow Settings</a></li>
               <li role="presentation" class=""><a href="#purchase_cost_center" role="tab" id="purchase_cost_center-tab" data-toggle="tab" aria-expanded="true" onclick="purchase_cost_center();"> Purchase Cost Center</a></li-->
               <li role="presentation" class=""><a href="#terms_conditions" role="tab" id="terms_conditions_settings-tab" data-toggle="tab" aria-expanded="true" onclick="terms_conditions();"> Terms & Conditions</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
               <!---------------------------------------------shift tab----------------------------------------------------->
               <div role="tabpanel" class="tab-pane fade active in" id="budget_tab_content1" aria-labelledby="shift-tab">
                  <div class="x_content">
				  <!--- -->
				  <div class="Filter Filter-btn2">
						<form class="form-search" method="post" action="<?= base_url() ?>purchase/purchase_setting">
						   <div class="col-md-6">
							  <div class="input-group">
								 <span class="input-group-addon">
								 <i class="ace-icon fa fa-check"></i>
								 </span>
								 <input type="text" class="form-control search-query" placeholder="Enter Material Type,Budget" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="purchase/purchase_setting">
								 <span class="input-group-btn">
								 <button type="submit" class="btn btn-purple btn-sm">
								 <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
								 Search
								 </button>
								 <a href="<?php echo base_url(); ?>purchase/purchase_setting"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
								 </span>
							  </div>
						   </div>
						</form>
						<button style="margin-right: 0px !important;" type="button" class="btn btn-primary collapsed" data-toggle="collapse" data-target="#demo" aria-expanded="false"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
						<div id="demo" class="collapse" aria-expanded="false" style="height: 2px;">
						   <div class="col-md-3  col-xs-12 col-sm-12 datepicker">
							  <fieldset>
								 <div class="control-group">
									<div class="controls">
									   <div class="input-prepend input-group">
										  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="purchase/purchase_setting">
									   </div>
									</div>
								 </div>
							  </fieldset>
							  <form action="<?php echo base_url(); ?>purchase/purchase_setting" method="get" id="date_range"> 
								 <input type="hidden" value='' class='start_date' name='start'/>
								 <input type="hidden" value='' class='end_date' name='end'/>
							  </form>
						   </div>
						</div>
						<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>purchase/purchase_setting">
						   <input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
						</form>
					 </div>
				  <!--- -->
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
                        <?php /* <table id="example" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3"> */ ?>
                        <table id="" class="table  table-bordered user_index" style="width:100%" data-id="user" border="1" cellpadding="3">
                           <thead>
                              <tr>
                                 <th scope="col">  Id
                                    <!-- <span><a href="<?php //echo base_url(); ?>purchase/purchase_setting?sort=asc" class="up"></a>
                                    <a href="<?php //echo base_url(); ?>purchase/purchase_setting?sort=desc" class="down"></a></span> -->
                                 </th>
                                 <th scope="col"> Material Type 
                                    <!-- <span><a href="<?php //echo base_url(); ?>purchase/purchase_setting?sort=asc" class="up"></a>
                                    <a href="<?php //echo base_url(); ?>purchase/purchase_setting?sort=desc" class="down"></a></span> -->
                                 </th>
                                 <th scope="col">Purchase Indent(Budget Spent)</th>
                                 <th scope="col">Purchase Order(Budget Spent)</th>
                                 <th scope="col">MRN ((Budget Spent)</th>
                                 <th scope="col">Payment</th>
                                 <th scope="col">Budgeting</th>
                                 <th scope="col" class='hidde'>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if(!empty($material_type)){
                                 foreach($material_type as $materialType){
                                 $payment_data = $materialType['payment'];
                                 $Decode_payment = json_decode($payment_data);
                                 $TotalPayment = 0;
                                 foreach($Decode_payment as $payment){
                                 foreach($payment as $totalpayAmount){
                                    $TotalPayment += $totalpayAmount->amount;
                                 }
                                 } 
                                 ?> 
                              <tr>
                                 <td data-label="id:"><?php echo $materialType['id'];?></td>
                                 <td data-label="Material Type :"><?php echo $materialType['name'];?></td>
                                 <td data-label="Purchase Indent(Budget Spent):"><?php echo $materialType['Pitotal'];?></td>
                                 <td data-label="Purchase Order(Budget Spent):"><?php echo $materialType['PoTotal'];?></td>
                                 <td data-label="MRN ((Budget Spent):"><?php echo $materialType['MRNTotal'];?></td>
                                 <td data-label="Payment:"><?php echo $TotalPayment;?></td>
                                 <td data-label="Budgeting:"><?php if(!empty($materialType)){echo $materialType['budget'];} else{ echo ""; }?></td>
                                 <td data-label="Action:"><?php 
                                    if($can_edit ) { 
                                       echo '<button id="'.$materialType["id"].'" class="btn btn-edit btn-xs order add_purchase_tabs" data-id="budgetEditAdd"><i class="fa fa-pencil"></i></button>';
                                    }  
                                    
                                     ?>     
                                 </td>
                              </tr>
                              <?php 
                                 $output[] = array(
                                          'ID' => $materialType['id'],
                                          'Material Name' =>$materialType['name'],
                                          'Purchase Indent' =>$materialType['Pitotal'],
                                          'Purchase Order' =>$materialType['Pototal'],
                                          'Mrn Total'=>$materialType['MRNTotal'],
                                          'Total'=>$TotalPayment,
                                          'Budget'=>$materialType['budget']
                                       );
                                 
                                    $output_blank[] = array(
                                          'id'=>'',
                                          'name' => '',
                                          'purchase indent' => '',
                                          'purchase order' => '',
                                          'total'=>'',
                                       ); 
                                      }
                                    $data3  = $output;   
                                    export_csv_excel($data3);  
                                    $data_balnk  = $output_blank;
                                    export_csv_excel_blank($data_balnk); 
                                          } ?>
                           </tbody>
                        </table>
                        <?php //echo $this->pagination->create_links(); ?>
                     </div>
                  </div>
               </div>
               <!------------------------------------------deapartment tab---------------------------------------------------------->
               
               <!-- Purchase New Setting by users -->
               
               <!---------------------tab of Purchase budget limit settings --------------------------------------------------->
               <div role="tabpanel" class="tab-pane fade " id="purchase_budget_limit" aria-labelledby="purchase_budget_limit-tab">
                  <div class="x_content">
                     <p class="text-muted font-13 m-b-30"></p>
                     <div id="print_div_content_div">
                        <form id="purchase_budget_frm"><input type="hidden" name="tab" value="purchase_budget"/></form>
                        <div class="container">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="budgetSetingContainer">
                                       <div class="budgetSeting" budgetType = "lowBudget" id="lowBudget">
                                           <div class="budgetTitle">
                                                <h4><b>Low Budget</b></h4>
                                                <span class="arrowSign" data-arrow="1"><i class="fa fa-angle-double-right"></i></span>
                                           </div>                                     
                                       </div>
                                       <?php $data = ['lowBudgetUsers' => $lowBudgetUsers,'users' => $users,'budget_type' => 'lowBudget',
                                            'BudgetExistUsers' => (isset($highBudgetUsers[0]['users']))?json_decode($highBudgetUsers[0]['users']):'' ]; ?>
                                       <?= $this->load->view('purchaseSetting',$data); ?>       
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="budgetSetingContainer">
                                       <div class="budgetSeting" budgetType = "highBudget" id="highBudget">
                                           <div class="budgetTitle">
                                                <h4><b>High Budget</b></h4>
                                                <span class="arrowSign" data-arrow="1"><i class="fa fa-angle-double-right"></i></span>
                                           </div>                                     
                                       </div>
                                       <?php $data = ['lowBudgetUsers' => $highBudgetUsers,'users' => $users,'budget_type' => 'highBudget',
                                            'BudgetExistUsers' => (isset($lowBudgetUsers[0]['users']))?json_decode($lowBudgetUsers[0]['users']):'' ]; ?>
                                       <?= $this->load->view('purchaseSetting',$data); ?>       
                                    </div>
                                 </div>
                              </div> 
                        </div>
                     </div>
                  </div>
               </div>
               <!----------------close tab for machine grouping------------------->
               <!-- Purchase Flow setting -->
               <?php $this->load->view('purchase_flow_setting'); ?>
               <!--  Purchase Flow setting end  -->
               <!-- Purchase Flow setting -->
               <?php $this->load->view('purchase_cost_center'); ?>
               <div role="tabpanel" class="tab-pane fade " id="terms_conditions" aria-labelledby="terms_conditions_settings-tab">
                  <div class="x_content">
                     <p class="text-muted font-13 m-b-30"></p>
                     <input type="hidden" id="loggedInUserId" value="<?php //echo $_SESSION['loggedInUser']->id ; ?>">   
                     <div id="print_div_content"> 
                       <form class="form-horizontal"  enctype="multipart/form-data" id="terms_conditionsform" novalidate="novalidate">
                         <input type="hidden" name="tab" value="terms_conditions">
                       </form>

                       <form method="post" class="form-horizontal" action="<?php echo base_url(); ?>purchase/purchase_term_condi" enctype="multipart/form-data" id="companyForm" novalidate="novalidate">
                       <textarea id="field" onkeyup="countChar(this)" col="160" rows="10" name="purchase_term_conditions" required="required" class="form-control col-md-7 col-xs-12" placeholder="Term And conditions"><?php if(!empty($update_purchase_setting->purchase_term_conditions)) echo $update_purchase_setting->purchase_term_conditions; ?></textarea>
                       <div id="charNum"></div>
                       <p class="text-muted font-13 m-b-30"></p>
                      <input type="submit" class="btn btn-warning pull-right" value="Submit">
                     </form> 
                   </div>
                  </div>
               </div>
               <!--  Purchase Flow setting end  -->
            </div>
         </div>
      </div>
   </div>
</div>
<?php //echo $this->pagination->create_links(); ?>
<div id="printView">
   <div id="purchase_add_modal" class="modal fade in"  role="dialog" style="overflow:auto;">
      <div class="modal-dialog modal-large">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Purchase Budget</h4>
            </div>
            <div class="modal-body-content" style="height:auto;"></div>
         </div>
      </div>
   </div>
</div>
<?php //$this->load->view('common_modal'); ?>