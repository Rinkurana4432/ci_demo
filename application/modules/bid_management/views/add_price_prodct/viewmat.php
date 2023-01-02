<table class="fixed data table table-bordered no-margin" style="width:100%" id="print_divv" border="1" cellpadding="2">
   <thead>													
   <tbody>
      
             <table id="" style="width:100%" class="table table-bordered product_index  bulk_action" data-id="user" border="1" cellpadding="3">
            <thead>
               <tr>
                  <th>Compiteter Name</th>
                  <th>Description</th>
                  <th>Price</th>
               </tr>
            </thead>
            <?php 
               if($competitordetails->comp_price_info !=''){
                     $products = json_decode($competitordetails->comp_price_info);
                     foreach($products as $product){
                        $comp_id = getNameById('bid_competitor_details',$product->compt_id,'id');
                        $comp_name = !empty($comp_id)?$comp_id->name:'';
                        echo "<tr>
                              <td><h5>".$comp_name."</td>
                              <td>".$product->disc."</td>
                              <td>".$product->price."</td>
                           </tr>";
                     } 
                  }
		?>		  
                 </table>
       
      </tr>
     
   </tbody>
   </thead>												
</table>
<center>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</center>