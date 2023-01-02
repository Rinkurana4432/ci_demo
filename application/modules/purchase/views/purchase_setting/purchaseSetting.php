<div class="budgetUser">
   <div class="purchaseBudgetPrice">
      <div class="displayFlex w100" method="post">
         <input type="text" name="lowBudget" value="<?= $lowBudgetUsers[0]['budget_limit']??'' ?>" class="form-control lowInput" 
               placeholder="<?=($budget_type=='highBudget')?'High Budget':'Low Budget';?>">
      </div>
      <div class="selectUsersForm">
         <select class="form-control commanSelect2 lowInputSelect" placeholder="Select Users" multiple="" name="addUsersBudget">
            <option>Select users</option>
            <?php 
               if( $users ){
                  $Existusers = [];
                  foreach ($users as $key => $value) {
                     if( isset($lowBudgetUsers[0]['users']) ){
                         $Existusers = json_decode($lowBudgetUsers[0]['users']);
                     }
                      if( !in_array($value['id'],$Existusers) ){
                           if( !in_array( $value['id'], $BudgetExistUsers ) ){
                              if( $value['name'] ){ ?>
                                 <option value="<?= $value['id'] ?>"><?= ucfirst($value['name']); ?></option>
                        <?php }
                           }
                      }
                        
                  }
               }

            ?>
         </select>
         <button type="button" class="btn btn-success selected_user_budget" data-bType="<?= $budget_type ?>">Save</button>
      </div>
      <div class="SelectedUsersDisplay">
         <h4 class="text-center">Selected Users</h4>
         <div class="usersList row">
            <?php if( $lowBudgetUsers ){
                     if( $lowBudgetUsers[0]['users'] ){
                           $users = json_decode($lowBudgetUsers[0]['users']);
                           foreach ($users as $key => $value) { ?>
                              <div class="col-md-3">
                                 <div class="materialDetails">
                                    <?= ucfirst(getSingleAndWhere('name','user_detail',['u_id' => $value ])); ?>
                                       <span class="deleteBudgetUser" data-bType='<?= $budget_type ?>' data-id="<?= $value ?>" onclick="return confirm('Are Your Sure ?')" >
                                          <i class="fa fa-trash"></i>
                                       </span>
                                    </div>
                              </div>
                     <?php }
                     }
            } ?>
            
         </div>
      </div>
   </div>
</div>   