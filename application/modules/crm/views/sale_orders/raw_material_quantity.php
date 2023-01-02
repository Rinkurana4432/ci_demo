
   <div class="col-md-12 col-sm-12 col-xs-12">
      <table id="datatable-buttons" class="table table-striped table-bordered" data-id="account">
         <thead>
            <tr>
               <th>S.no</th>
               <th>Unit Of Measurement</th>
               <th>Total Quantity</th>
            </tr>
         </thead>
         <tbody>
           <?php 
                   $umoe=[];
                   foreach($raw_material_report as $uomqty){   
                      $umoe[$uomqty->uom][]= $uomqty->quantity;
                    
                  }
                  $i=1;
                   foreach ($umoe as $umokey => $totalvalue) {
                      $ums =  getNameById('uom',$umokey,'id');
                      $uom1 = !empty($ums)?$ums->ugc_code:'';   ?><tr>
                     <td><?=$i;?></td>
                     <td><?=$uom1;?></td>
                     <td> <?php $valueo=0;foreach ($totalvalue as $key => $sumvalue) {
                         $valueo +=$sumvalue;
                      } echo $valueo; ?>  </td>

                  </tr>
                  <?php $i++;} ?>
         </tbody>
      </table>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
         <div class="form-group">
            <div class="modal-footer">
               <button type="button" class="btn btn-default workOrderModal" >Close</button>
            </div>
         </div>
      </div>
   </div>
