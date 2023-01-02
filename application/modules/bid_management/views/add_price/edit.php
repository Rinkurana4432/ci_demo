<?php   
   $this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
   
   ?>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>bid_management/save_add_price" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <input type="hidden" name="id" value="<?php if(!empty($account)){ echo $account->id;   }?>">
   <input type="hidden" id="loggedUser" value="<?php echo $this->companyGroupId; ?>">
   <input type="hidden" name="created_by" value="<?php if(!empty($account)){ echo $account->created_by;   }?>">
   <input type="hidden" name="save_status" value="1" class="save_status">	
   <h3 class="Material-head" style="margin-bottom: 30px;">
      Competitor Price Information
      <hr>
   </h3>
   <div class="required item form-group col-md-12 col-sm-12 col-xs-12">
         <label class="required col-md-3 col-sm-12 col-xs-12" for="account_id">Compitetor Name </label>
         <div class="required col-md-6 col-sm-12 col-xs-12">
            <select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id" data-id="bid_competitor_details" data-key="id" data-fieldname="name" data-where="account_owner = <?php echo /*$_SESSION['loggedInUser']->c_id*/ $this->companyGroupId ; ?> AND save_status = 1" width="100%">
               <option value="">Select Option</option>
               <?php 
                 /* if(!empty($account)){
                     $account = getNameById('competitor_details',$account->id,'id');
                     echo '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
                  }*/
               ?>
            </select>
         </div>
      </div>


   <hr>
   <div class="bottom-bdr"></div>
   <!-- <div class="ln_solid"></div> -->
   <h3 class="Material-head">
      Product Details
      <hr>
   </h3>
   <div class="item form-group ">
      <div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap">
         <div class="item form-group">
            <div class="col-md-12 input_holder middle-box">
               <div class="well " id="chkIndex_1" style=" overflow:auto;">


               <div class="col-sm-12 btn-row"><button class="btn edit-end-btn  addmaterial" type="button">Add</button></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="form-group" style="text-align:center;">
      <div class="col-md-12 col-xs-12">
         <center>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <?php if((!empty($account) && $account->save_status !=1) || empty($account)){
               echo '<input type="submit" class="btn edit-end-btn draftBtn" value="Save as draft">'; 
               }?> 
            <input type="submit" class="btn edit-end-btn" value="Submit">
         </center>
      </div>
   </div>
</form>