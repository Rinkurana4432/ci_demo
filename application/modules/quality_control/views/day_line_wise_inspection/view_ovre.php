<div class="x_content">
   <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
       <!--  <li role="presentation" class="active"><a href="#view" role="tab" id="dispatch_history" data-toggle="tab" aria-expanded="false">View Sale Order</a></li>
          <li role="presentation" class=""><a href="#ViewWorkorder" role="tab" id="ViewWorkorder_tab" data-toggle="tab" aria-expanded="false">View Work Order</a></li>
         <li role="presentation" class=""><a href="#dispatch_history" id="dispatch_history_tab" role="tab" data-toggle="tab" aria-expanded="true">Dispatch History</a></li>-->
      </ul> 
      
         
         
         <!-------------------tab leads------------------------------->
         
               <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered sale_order_index" data-id="account" border="1" cellpadding="3">
                  <thead>
                     <tr>
                        <th>S.no</th>
                        <th>Parameters</th>
                        <th>Instrument</th>
                        <th>Uom </th> 
                        <th>Expectation</th>
                        <th>Deviation Minimum</th>
                        <th>Deviation maximum</th>
                        <th>Expectation with minimum Deviation</th>
                         <th>Expectation with maximum Deviation</th>
                         <th>Result</th>
                        <th>Remark</th>
                        <th style="width: 120px;" >Pass/Fail</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                  <?php if (!empty($AddMachine)){ ?>
                       
                     <tr>
                      <td><?=@$AddMachine->?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td> 
                    </tr>
                       
                   
                  <?php } ?>
                    
               </table>
            
         <!-----------------------------end tab------------------------------------>
      
   </div>
</div>