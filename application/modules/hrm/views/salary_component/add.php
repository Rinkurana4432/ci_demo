<style>
   .hide-control {
   display: none!important;
   }
</style>
<script>
   function toggle(className, obj) {
   	alert(className);
       $(className).toggle( !obj.checked )
   }
</script>
<form method="post" class="form-horizontal" action="<?php echo base_url(); ?>hrm/saveSalaryComponent" enctype="multipart/form-data" id="leadForm" novalidate="novalidate">
   <div class="form-layout">
      <div class="form-message text-muted small hidden"></div>
      <div class="form-page">
         <div class="row form-section visible-section shaded-section">
            <div class="section-body">
               <input type="hidden" name="id" value="<?php if(!empty($salary_component_detail)){ echo $salary_component_detail->id; }?>">
               <div class="form-column col-sm-6">
                  <div class="frappe-control input-max-width has-error" data-fieldtype="Data" data-fieldname="salary_component">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Name</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input">
                              <input type="text" value="<?php if(!empty($salary_component_detail)){ echo $salary_component_detail->salary_component; }?>" required="required"  class="input-with-feedback form-control bold" maxlength="140" data-fieldtype="Data" name="salary_component" placeholder="" data-doctype="Salary Component">
                           </div>
                           <div class="control-value like-disabled-input bold" style="display: none;"></div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
                  <div class="frappe-control input-max-width has-error" data-fieldtype="Data" data-fieldname="salary_component_abbr">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Abbr</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input">
                              <input style="text-transform: uppercase;" type="text"  value="<?php if(!empty($salary_component_detail)){ echo $salary_component_detail->salary_component_abbr; }?>" required="required" autocomplete="off" class="input-with-feedback form-control bold" maxlength="140" data-fieldtype="Data" name="salary_component_abbr" placeholder="" data-doctype="Salary Component">
                           </div>
                           <div class="control-value like-disabled-input bold" style="display: none;"></div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
                  <div class="frappe-control input-max-width" data-fieldtype="Select" data-fieldname="type">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Type</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input flex align-center">
                              <select type="text" autocomplete="off" class="input-with-feedback form-control bold" maxlength="140" data-fieldtype="Select" name="type" placeholder="" data-doctype="Salary Component">
                                 <option value="Earning">Earning</option>
                                 <option value="Deduction">Deduction</option>
                              </select>
                              <i class="octicon octicon-chevron-down text-muted"></i> 
                           </div>
                           <div class="control-value like-disabled-input bold" style="display: none;">Earning</div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
                  <div class="frappe-control" data-fieldtype="Small Text" data-fieldname="description">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Description</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input">
                              <textarea type="text" autocomplete="off" class="input-with-feedback form-control" data-fieldtype="Small Text" name="description" placeholder="" data-doctype="Salary Component" style="height: 150px;"> <?php if(!empty($salary_component_detail)){ echo $salary_component_detail->description; }?> </textarea>
                           </div>
                           <div class="control-value like-disabled-input for-description" style="display: none;"></div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
                  <div class="frappe-control input-max-width hide-control" data-fieldtype="Select" data-fieldname="component_type">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Component Type</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input flex align-center">
                              <select type="text" autocomplete="off" class="input-with-feedback form-control" maxlength="140" data-fieldtype="Select" name="component_type" placeholder="" data-doctype="Salary Component">
                                 <option></option>
                                 <option value="Provident Fund">Provident Fund</option>
                                 <option value="Additional Provident Fund">Additional Provident Fund</option>
                                 <option value="Provident Fund Loan">Provident Fund Loan</option>
                                 <option value="Professional Tax">Professional Tax</option>
                              </select>
                              <i class="octicon octicon-chevron-down text-muted"></i> 
                           </div>
                           <div class="control-value like-disabled-input" style="display: none;"></div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-column col-sm-6">
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="depends_on_payment_days">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" name="depends_on_payment_days" <?php if (!empty($salary_component_detail) && $salary_component_detail->depends_on_payment_days == 1) { echo "checked='checked'"; } ?> placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-check" style="margin-right: 3px;"></i></span> <span class="label-area small">Depends on Payment Days</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="is_tax_applicable">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" <?php if (!empty($salary_component_detail) && $salary_component_detail->is_tax_applicable == 1) { echo "checked='checked'"; } ?> value="1" class="input-with-feedback" data-fieldtype="Check" name="is_tax_applicable" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-check" style="margin-right: 3px;"></i></span> <span class="label-area small">Is Tax Applicable</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width hide-control" data-fieldtype="Check" data-fieldname="is_income_tax_component"  >
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" <?php if (!empty($salary_component_detail) && $salary_component_detail->is_income_tax_component == 1) { echo "checked='checked'"; } ?> value="1" class="input-with-feedback" data-fieldtype="Check" name="is_income_tax_component" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Is Income Tax Component</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="deduct_full_tax_on_selected_payroll_date">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" <?php if (!empty($salary_component_detail) && $salary_component_detail->deduct_full_tax_on_selected_payroll_date == 1) { echo "checked='checked'"; } ?> value="1" class="input-with-feedback" data-fieldtype="Check" name="deduct_full_tax_on_selected_payroll_date" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Deduct Full Tax on Selected Payroll Date</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width hide-control" data-fieldtype="Check" data-fieldname="variable_based_on_taxable_salary">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" <?php if (!empty($salary_component_detail) && $salary_component_detail->variable_based_on_taxable_salary == 1) { echo "checked='checked'"; } ?>  value="1" class="input-with-feedback" data-fieldtype="Check" name="variable_based_on_taxable_salary" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Variable Based On Taxable Salary</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width hide-control" data-fieldtype="Check" data-fieldname="exempted_from_income_tax">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox"  <?php if (!empty($salary_component_detail) && $salary_component_detail->exempted_from_income_tax == 1) { echo "checked='checked'"; } ?>  value="1" class="input-with-feedback" data-fieldtype="Check" <?php if (!empty($salary_component_detail) && $salary_component_detail->exempted_from_income_tax == 1) { echo "checked='checked'"; } ?> name="exempted_from_income_tax" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Exempted from Income Tax</span> </label>
                        <p class="help-box small text-muted">If checked, the full amount will be deducted from taxable income before calculating income tax without any declaration or proof submission.</p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="round_to_the_nearest_integer">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" <?php if (!empty($salary_component_detail) && $salary_component_detail->round_to_the_nearest_integer == 1) { echo "checked='checked'"; } ?> name="round_to_the_nearest_integer" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Round to the Nearest Integer</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="statistical_component">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" <?php if (!empty($salary_component_detail) && $salary_component_detail->statistical_component == 1) { echo "checked='checked'"; } ?> name="statistical_component" placeholder="" data-doctype="Salary Component"  onclick="toggle('.flexible', this);"></span> <span class="disp-area" style="display: none;"  ><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Statistical Component</span> </label>
                        <p class="help-box small text-muted">If selected, the value specified or calculated in this component will not contribute to the earnings or deductions. However, it's value can be referenced by other components that can be added or deducted. </p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="do_not_include_in_total">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" <?php if (!empty($salary_component_detail) && $salary_component_detail->do_not_include_in_total == 1) { echo "checked='checked'"; } ?>  name="do_not_include_in_total" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Do Not Include in Total</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="disabled">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" <?php if (!empty($salary_component_detail) && $salary_component_detail->approve_status == 1) { echo "checked='checked'"; } ?>   name="approve_status" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Disabled</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <hr>
         <div class="row form-section visible-section flexible">
            <div class="bottom-bdr"></div>
            <div class="col-sm-12">
               <h3 class="form-section-heading uppercase">Flexible Benefits</h3>
            </div>
            <div class="section-body">
               <div class="form-column col-sm-6">
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="is_flexible_benefit">
                     <div class="checkbox">
                        <label> <span class="input-area"><input  <?php if (!empty($salary_component_detail) && $salary_component_detail->is_flexible_benefit == 1) { echo "checked='checked'"; } ?>   type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" name="is_flexible_benefit" placeholder="" data-doctype="Salary Component"></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Is Flexible Benefit</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="frappe-control input-max-width hide-control" data-fieldtype="Currency" data-fieldname="max_benefit_amount">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Max Benefit Amount (Yearly)</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input">
                              <input type="text" autocomplete="off" class="input-with-feedback form-control" data-fieldtype="Currency" value"<?php if(!empty($salary_component_detail)){ echo $salary_component_detail->max_benefit_amount; }?>" name="max_benefit_amount" placeholder="" data-doctype="Salary Component">
                           </div>
                           <div class="control-value like-disabled-input" style="display: none;"></div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-column col-sm-6">
                  <div class="form-group frappe-control input-max-width hide-control" data-fieldtype="Check" data-fieldname="pay_against_benefit_claim">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" name="pay_against_benefit_claim" placeholder="" data-doctype="Salary Component" <?php if (!empty($salary_component_detail) && $salary_component_detail->pay_against_benefit_claim == 1) { echo "checked='checked'"; } ?> ></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Pay Against Benefit Claim</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width hide-control" data-fieldtype="Check" data-fieldname="only_tax_impact">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" name="only_tax_impact" placeholder="" data-doctype="Salary Component" <?php if (!empty($salary_component_detail) && $salary_component_detail->only_tax_impact == 1) { echo "checked='checked'"; } ?> ></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Only Tax Impact (Cannot Claim But Part of Taxable Income)</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width hide-control" data-fieldtype="Check" data-fieldname="create_separate_payment_entry_against_benefit_claim">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" name="create_separate_payment_entry_against_benefit_claim" placeholder="" data-doctype="Salary Component" <?php if (!empty($salary_component_detail) && $salary_component_detail->create_separate_payment_entry_against_benefit_claim == 1) { echo "checked='checked'"; } ?> ></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Create Separate Payment Entry Against Benefit Claim</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <hr>
         <div class="bottom-bdr"></div>
         <div class="row form-section visible-section">
            <div class="section-head"><a class="h3 uppercase">Condition and Formula</a><span class="octicon collapse-indicator octicon-chevron-up"></span></div>
            <div class="section-body">
               <div class="form-column col-sm-6">
                  <div class="frappe-control" data-fieldtype="Code" data-fieldname="condition">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Condition</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input">
                              <textarea name='condition_formula' class="form-control col-md-7 col-xs-12" style="margin: 0px; height: 144px; width: 568px;"><?php if(!empty($salary_component_detail)){ echo $salary_component_detail->condition_formula; }?></textarea>
                           </div>
                           <div class="control-value like-disabled-input for-description" style="display: none;">
                              <pre></pre>
                           </div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
                  <div class="frappe-control input-max-width" data-fieldtype="Currency" data-fieldname="amount">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Amount</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input">
                              <input type="text"  value="<?php if(!empty($salary_component_detail)){ echo $salary_component_detail->amount; }?>"  class="input-with-feedback form-control" data-fieldtype="Currency" name="amount" placeholder="" data-doctype="Salary Component">
                           </div>
                           <div class="control-value like-disabled-input" style="display: none;"></div>
                           <p class="help-box small text-muted hidden-xs"></p>
                        </div>
                     </div>
                  </div>
                  <div class="form-group frappe-control input-max-width" data-fieldtype="Check" data-fieldname="amount_based_on_formula">
                     <div class="checkbox">
                        <label> <span class="input-area"><input type="checkbox" value="1" class="input-with-feedback" data-fieldtype="Check" name="amount_based_on_formula" placeholder="" data-doctype="Salary Component" onclick="toggle('.formula', this);" <?php if (!empty($salary_component_detail) && $salary_component_detail->amount_based_on_formula == 1) { echo "checked='checked'"; } ?> ></span> <span class="disp-area" style="display: none;"><i class="fa fa-square disabled-check"></i></span> <span class="label-area small">Amount based on formula</span> </label>
                        <p class="help-box small text-muted"></p>
                     </div>
                  </div>
                  <div class="frappe-control hide-control formula" data-fieldtype="Code" data-fieldname="formula">
                     <div class="form-group">
                        <div class="clearfix">
                           <label class="control-label" style="padding-right: 0px;">Formula</label>
                        </div>
                        <div class="control-input-wrapper">
                           <div class="control-input">
                              <textarea name='amount_based_condition_formula' class="form-control col-md-7 col-xs-12" style="margin: 0px; height: 144px; width: 568px;"><?php if(!empty($salary_component_detail)){ echo $salary_component_detail->amount_based_condition_formula; }?></textarea>
                           </div>
                           <div class="control-value like-disabled-input for-description" style="display: none;">
                              <pre></pre>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-column col-sm-6">
                  <div class="frappe-control" data-fieldtype="HTML" data-fieldname="help">
                     <h3>Help</h3>
                     <p>Notes:</p>
                     <ol>
                        <li>Use field <code>base</code> for using base salary of the Employee</li>
                        <li>Use Salary Component abbreviations in conditions and formulas. <code>BS = Basic Salary</code></li>
                        <li>Use field name for employee details in conditions and formulas. <code>Employment Type = employment_type</code><code>Branch = branch</code></li>
                        <li>Use field name from Salary Slip in conditions and formulas. <code>Payment Days = payment_days</code><code>Leave without pay = leave_without_pay</code></li>
                        <li>Direct Amount can also be entered based on Condtion. See example 3</li>
                     </ol>
                     <h4>Examples</h4>
                     <ol>
                        <li>
                           Calculating Basic Salary based on <code>base</code> 
                           <pre><code>Condition: base &lt; 10000</code></pre>
                           <pre><code>Formula: base * .2</code></pre>
                        </li>
                        <li>
                           Calculating HRA based on Basic Salary<code>BS</code> 
                           <pre><code>Condition: BS &gt; 2000</code></pre>
                           <pre><code>Formula: BS * .1</code></pre>
                        </li>
                        <li>
                           Calculating TDS based on Employment Type<code>employment_type</code> 
                           <pre><code>Condition: employment_type=="Intern"</code></pre>
                           <pre><code>Amount: 1000</code></pre>
                        </li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <hr>
   <div class="form-group">
      <div class="col-md-12 ">
         <center>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <input type="submit" class="btn edit-end-btn " value="Submit"> 
         </center>
      </div>
   </div>
</form>