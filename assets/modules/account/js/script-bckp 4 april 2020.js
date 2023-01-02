//$(document).ready(function(e) {   
	/* Add/Edit Modal for Predefined Relies */
	
	$(document).on("click",".add_account_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		switch (tab) {
			case 'ledger':
				url = 'account/editLedger';
				break;	
			case 'ledger_view':
				url = 'account/viewLedger';
				break;					
		}		
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){
				$("#account_add_modal").modal({
					show:false,
					backdrop:'static'
				});
				
				if(data != '') {
					if($('#account_add_modal').length){
						$('#account_add_modal').modal('toggle');
						$('#account_add_modal .modal-body-content').html(data);		
					}else{
						$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
				
					
					init_select2();
					Get_Ledger_accodingTo_Parent();
					Get_account_group_or_parent_group_id();
					get_selected_acc_group_value();
					get_add_according_unit();
					get_selected_company_branch_value();
					Get_connected_company();
					add_ledgers_multi_address();
					$('#gstin_no').keyup(function(){
						this.value = this.value.toUpperCase();
					});
					$('.cls_add_select2').select2();
					$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
					
					
						
				}
			}
		}); 
	});	
//});
//Add Ledgers data for Multiple time
function add_ledgers_multi_address(){
	
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".add_more_ledgers_addss"); //Fields wrapper
    var add_button      = $(".add_multi_address_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click onchange="getState(event,this,'billing')" onchange="getCity(event,this,'billing')"
	    e.preventDefault();
			$('.add_requried').prop("disabled", true);
			var company_login_id = $('#company_login_id').val();			
        if(x < max_fields){ //max input box allowed
            x++; 
		var addressClass = 'address'+x;	
//alert(addressClass);		
				$(wrapper).append('<div class=" add_more_ledgers_addss scend-tr mobile-view mailing-box" ><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_name">Mailing Name</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="mailing_name" name="mailing_name[]"  class="form-control col-md-7 col-xs-12" placeholder="Mailing Name" value=""></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Mailing Address</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><textarea id="mailing_address"  name="mailing_address[]" class="form-control col-md-7 col-xs-12" placeholder="Mailing Address"></textarea></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_country">Mailing Country </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="mailing_country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this)"><option value="">Select Option</option></select></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">Mailing State </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible  '+addressClass+'  state_id" name="mailing_state[]"  width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this)"><option value="">Select Option</option></select></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">Mailing City </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select   class="itemName form-control selectAjaxOption select2 select2-hidden-accessible '+addressClass+' city_id" name="mailing_city[]"  width="100%" tabindex="-1" aria-hidden="true" ><option value="">Select Option</option></select></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode">Pincode </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="mailing_pincode" name="mailing_pincode[]"  class="form-control col-md-7 col-xs-12" placeholder="Pincode" value=""></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_gstin">GSTIN </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="gstin_no" name="gstin_no[]"  class="form-control col-md-7 col-xs-12" placeholder="GSTIN" value=""></div></div><button class="btn btn-danger remove_ledger_add_field" type="button"><i class="fa fa-minus"></i></button></div>');
			}
			init_select2();
			$('#gstin_no').keyup(function(){
				this.value = this.value.toUpperCase();
			});
    });
    
    $(wrapper).on("click",".remove_ledger_add_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });	
}



    
//Add Ledgers for Multiple time	
$(document).on("click",".addAccountGroup",function(){		
	var currentelement = $(this);
	var id = $(this).attr('id');
	
	$.ajax({
		type: "POST",
		url: site_url+'account/editAccountGroup',
		data: {id:id}, 
		success: function(data){
			if(data != '') { 
			$("#add_account_group").modal({
					show:false,
					backdrop:'static'
				});
				$('#add_account_group').modal('toggle');
				$('#add_account_group .modal-body-content').html(data);							
				init_select2();
				
				$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
					
		   }
		}
	}); 
});
//Add Ledgers for Multiple time
//ADD PARENT GROUP 
$(document).on("click",".addParentGroup",function(){		
	var currentelement = $(this);
	var id = $(this).attr('id');
	$.ajax({
		type: "POST",
		url: site_url+'account/editParentGroup',
		data: {id:id}, 
		success: function(data){
			if(data != '') { 
			$("#add_parent_group").modal({
					show:false,
					backdrop:'static'
				});
				$('#add_parent_group').modal('toggle');
				$('#add_parent_group .modal-body-content').html(data);							
				init_select2();
				$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
					
		   }
		}
	}); 
});





//for add voucher
$(document).on("click",".add_voucher_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		switch (tab) {  
			case 'voucher':
				url = 'account/editVoucher';
				break;	
			case 'voucher_view':
				url = 'account/viewVoucher';
				break;					
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#vaoucher_add_modal").modal({
					show:false,
					backdrop:'static'
				});
					$('#vaoucher_add_modal').modal('toggle');
					$('#vaoucher_add_modal .modal-body-content').html(data);		
					init_select2();
					$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
				}
			}
		}); 
	});	
	
	
	
$(document).on("click","#export-menu li",function(){ 
		var target = $(this).attr('id');
		//alert(target);
			switch(target) {  
                case 'export-to-excel' :
                $('#hidden-type').val(target);
                //alert($('#hidden-type').val());
                $('#export-form').submit();
                $('#hidden-type').val('');
            break
                case 'export-to-csv' :
                $('#hidden-type').val(target);
                //alert($('#hidden-type').val());
                $('#export-form').submit();
                $('#hidden-type').val('');
            break
				case 'export-to-pdf' :
				  $('#hidden-type').val(target);
                  $('#export-form-pdf').submit();
				  $('#hidden-type').val('');
            break
				case 'export-to-blank-excel' :
				  $('#hidden-type-blank-excel').val(target);
				  $('#export-form-blank').submit();
				  $('#hidden-type-blank-excel').val('');
            break		
            }
			
        });	
	
	
	//Add Voucher Details scripts
	$(document).on("click",".add_invoice_details",function(){
		
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		
		switch (tab) {
			case 'invoice_details':
				url = 'account/editInvoice_details';
				break;	
			case 'invoice_view_details':
				url = 'account/viewInvoice_details';
				break;					
		}
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#add_invoice_detail_modal").modal({
					show:false,
					backdrop:'static'
				});
					if($('#add_invoice_detail_modal').length){
						$('#add_invoice_detail_modal').modal('toggle');
						$('#add_invoice_detail_modal .modal-body-content').html(data);	
					}else{
						$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
					
					if(id == 'add'){//This code is used for add invoice number on load Modal
					 setTimeout(function(){
								$('.sale_ledger_id_onchange').trigger('change');
							}, 1000);
					}
					sale_ledger_id_onchange();
					party_name_ledger_id_onchange();
					add_mailing_address_on_change();
					dicharge_loding_port_hide_show();
					consigneeCheck();	
					add_more_charges_details();	
					add_charges_on_invoice();
					tax_calculation_for_charges();
					add_dicount_invoice_matrial();
					$('#partygstin').keyup(function(){
						this.value = this.value.toUpperCase();
					});
					if(tab == 'invoice_details'){//Edit Time Functionality
					   add_filed_for_goods_descr_invoice();
					   var alerady_tax = $('.tax_class').val();
					   $('.added_tax').val(alerady_tax); 					    
						var matrial_qty_already =  $('.qty').val();						
						var matrial_rate_already =  $('.rate').val();
						var total_amount_Add = matrial_qty_already *  matrial_rate_already;
						//alert(total_amount_Add);
						//$('.sale_amount').val(total_amount_Add);						
						 var result_divide = parseInt(alerady_tax) / parseInt(2);
						// alert(result_divide);
						 $(".tax_class1").val(result_divide);
						 $(".tax_class2").val(result_divide);
						 var consignee_address_check1 = $('textarea#consignee_address').val();
							if ($('#consignee_address_check').attr('checked')){
									$("consignee_address_check1").show();
								}else{
									$("consignee_address_check1").hide();
								}
							if($("#consignee_address_check").prop('checked') == true){
									$('#consignee_address').show();
								}else{
									$('#consignee_address').hide();
								}
					}
					
					
					
					 kyup_function_to_remove_add_rate_qty();					
					 tax_keyup_event_to_remove_tax();
					 get_multiselect_value();
					 get_material_thrugh_item_code();
					 get_party_details_onchange();
					// $('.add_requried').prop("disabled", true);					 
					//subtotal();
					//Date Format Change Script	
						$('#date12,#date_time_of_invoice_issue,#date_time_removel_of_goods,#dispatch_document_date,#buyer_order_date').datepicker({
							format: 'dd-mm-yyyy',
							autoclose: true,
							todayHighlight: true,
							changeMonth: true,
							changeYear: true
						});
						//Date Format Change Script	
					
										
					$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
								
					init_select2();			
					init_select21();
					init_select221();
					get_add_more_btn_forsale_ledger();
					close_modal_Script();	
					//
					/* This Code is used for Invoice Edit Time*/
					var party_billing_state = $('#party_billing_state_id').val();
					 var sale_company_state_idd = $('#sale_company_state_id').val();
					 if(party_billing_state != sale_company_state_idd){
							 $('.cgst').hide();
							 $('.sgst').hide();
							 $('.igst').show();
						 }else{
							  $('.cgst').show();
							  $('.sgst').show();
							  $('.igst').hide();
						 }
				/* This Code is used for Invoice Edit Time*/
				}
			}
		}); 
	});

$(document).on("click",".check_invoice_report",function(){
		
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		//alert(tab);
		switch (tab) {
			case 'invoice_report_details':
				url = 'account/invoice_report';
				break;					
		}
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#add_invoice_report_modal").modal({
					show:false,
					backdrop:'static'
				});
					if($('#add_invoice_report_modal').length){
						$('#add_invoice_report_modal').modal('toggle');
						$('#add_invoice_report_modal .modal-body-content').html(data);	
					}else{
						$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
					
						
									
					
					
				/* This Code is used for Invoice Edit Time*/
				}
			}
		}); 
	});

	
$(document).on("click",".sale_ledger_details",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');		
		var url = '';
		console.log('tabd check===>>>>',tab);
		console.log('idd===>>>>',id);
		//alert(tab);
		switch (tab) {
			case 'sale_ledger_details':
				url = 'account/saleregister_view';
				break;					
		}		
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){
				//alert(data);				
				if(data != '') {
					$("#add_invoice_detail_modal_sale").modal({
					show:false,
					backdrop:'static'
				});
					$('#add_invoice_detail_modal_sale').modal('toggle');
					$('#add_invoice_detail_modal_sale .modal-body-content').html(data);	
					close_modal_Script();
					
					$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
				}
			}
		}); 
	});	
	
	
	
	/*Fetch Unpaid Invoices*/
	$(document).on("click",".add_unpaid_invoice_dtl",function(){ 
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
//alert(tab);
		switch (tab) {
			// case 'purchase_bill':
				// url = 'account/editpurchase_bill_detail';
				// break;	
			case 'unpaid_invoice_view':
				url = 'account/view_unpaid_invoice_detail';
				break;					
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#unpaid_invoice_modal").modal({
					show:false,
					backdrop:'static'
				});
					$('#unpaid_invoice_modal').modal('toggle');
					$('#unpaid_invoice_modal .modal-body-content').html(data);	
						init_select_forAdd_suplier();
						add_field_for_create_bill();
						get_supplier_details_onchange();
						using_tax_dropdown();
						on_rate_chage();
						on_quantity_chage();
						init_select2();						
						 var date = new Date();
						 var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
						 var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
							
							  //Date Format Change Script	
								$('#bill_date').datepicker({
									format: 'dd-mm-yyyy',
									autoclose: true,
									todayHighlight: true,
									changeMonth: true,
									changeYear: true
								});
								//Date Format Change Script	
							$('#unpaid_invoicesss').dataTable({
									"footerCallback": function ( row, data, start, end, display ) {
										var api = this.api(),data;

										// converting to interger to find total
										var intVal = function ( i ) {
											return typeof i === 'string' ?
												i.replace(/[\$,]/g, '')*1 :
												typeof i === 'number' ?
													i : 0;
										};
										// computing column Total of the complete result
										var tttl = api
										.column( 7 , { page: 'current'}  )
										.data()
										.reduce( function (a, b) {
											return intVal(a) + intVal(b);
										},0);
										var tttl_com_sep = tttl.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
									$('.g_ttl').html(tttl_com_sep);
									
									var taxx = api
										.column( 8 , { page: 'current'}  )
										.data()
										.reduce( function (a, b) {
											return intVal(a) + intVal(b);
										},0);
										var tx_cls_com_sep = taxx.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
									$('.tax_ttl').html(tx_cls_com_sep);
									
									
									

								},
								destroy: true,
								searching: false
								   
								});
						$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
							}
					}
				}); 
	});	
	
	/*Fetch Unpaid Invoices*/
	function party_name_ledger_id_onchange(){
		$('.party_name_ledger_id_onchange').change(function(){
           // $('.charges_form').hide();
		   
			$('#P_address').html('<option selected>Select Address</option>');		
			var selected_party_name_ledger_id = $(this).val();
			
			//setTimeout(function(){
				
				//alert(selected_party_name_ledger_id);
				var login_user_idd = $('#login_user_idddd').val();
					$.ajax({
					   type: "POST",
					   url: site_url+'account/get_ledger_mailing_state/',
					   data: { id:selected_party_name_ledger_id,login_user:login_user_idd}, 
					   success: function(result) {
						  var obj = jQuery.parseJSON(result);
						  var get_state_id =  jQuery.parseJSON(obj.mailing_address);
						  var len = get_state_id.length;
						//For State in multiple address		
						for(var i=0; i<len; i++){
							
							 var country = get_state_id[i].mailing_country;
							 var state = get_state_id[i].mailing_state;
							 var city = get_state_id[i].mailing_city;
							 var mailing_name = get_state_id[i].mailing_name;
							 var mailing_address1 = get_state_id[i].mailing_address;
							 var mailing_state1 = get_state_id[i].mailing_state;
							 var gstin_no = get_state_id[i].gstin_no;
							//alert(mailing_address1);
							
							 var  Dropdn = '<option value="'+ mailing_state1 +'" data-gst="'+ gstin_no +'">'+ mailing_address1   +'</option>';
							 $("#P_address").append(Dropdn);
							 if(mailing_state1 != ''){
							 setTimeout(function(){
								$('#P_address option:eq(1)').attr('selected', 'selected');
							}, 1000);
							
							 setTimeout(function(){
								var datagstval = $('#P_address option:selected').attr('data-gst');
								var value_data = $('#P_address option:selected').val();
								//alert(datagstval); 
								$('#party_billing_state_id').val(value_data);
								$('#gstin').val(datagstval);
							}, 1500);
						}
					}	
						//For State in multiple address
						   var conn_company_iddd = obj.conn_comp_id;
						   
						   $('#conn_company_id').val(conn_company_iddd);
						   
						 
						   var phone_no = obj.phone_no;
						   $('#party_phone').val(phone_no);
						setTimeout(function(){   
						   var party_billing_state = $('#party_billing_state_id').val();
						   var sale_company_state_idd = $('#sale_company_state_id').val();
						 
						    if(party_billing_state != sale_company_state_idd){
								 $('.cgst').hide();
								 $('.sgst').hide();
								 $('.igst').show();
							 }else{
								  $('.cgst').show();
								  $('.sgst').show();
								  $('.igst').hide();
								 
							 }
							 
						}, 2000);	 
					 }
			 });
		//}, 1000);
	});
		
}



	 
	 function sale_ledger_id_onchange(){
		$('.sale_ledger_id_onchange').change(function(){ 
		$('#sale_address').html('<option selected>Select Address</option>');	
			var selected_sale_ledger_id = $(this).val();
			//alert(selected_sale_ledger_id);
			//$('#sale_company_state_id').val(selected_sale_ledger_id);
			var login_user_idd = $('#login_user_idddd').val();
		
			//setTimeout(function(){
				$.ajax({
					   type: "POST",
					   url: site_url+'account/get_company_branch_state/',
					   data: { id:selected_sale_ledger_id}, 
					   success: function(result) {
						
						  var obj = jQuery.parseJSON(result);
						 
						   
						
						  var get_sale_state_id =  jQuery.parseJSON(obj.address);
						  var len = get_sale_state_id.length;
						//For State in multiple address
						
						for(var i=0; i<len; i++){
							
							 var mailing_address1 = get_sale_state_id[i].compny_branch_name;
							 var mailing_state1 = get_sale_state_id[i].state;
							 var gstin_no = get_sale_state_id[i].company_gstin;
							 var company_branch_iddd = get_sale_state_id[i].add_id;
						
							 var  Dropdn_sale = '<option value="'+ mailing_state1 +'" data-gst="'+ gstin_no +'" branh-id = "' + company_branch_iddd + '">'+ mailing_address1   +'</option>';
							 $("#sale_address").append(Dropdn_sale);
							 if(mailing_state1 != ''){
								 setTimeout(function(){
									$('#sale_address option:eq(1)').attr('selected', 'selected');
								}, 1000);
								
								 setTimeout(function(){
									var datagstval = $('#sale_address option:selected').attr('data-gst');
									var dropDownSelectval = $('#sale_address option:selected').val();
									$('#sale_leger_gstin_no').val(datagstval);
									$('#sale_company_state_id').val(dropDownSelectval);
									
									var branch_idg = $('#sale_address option:selected').attr('branh-id');
									
									 $('#sale_ledger_company_branch_id').val(branch_idg);
								}, 1500);
						}
					}
					
						setTimeout(function(){
						  var sale_company_state_idd = $('#sale_company_state_id').val();
						  var party_billing_state = $('#party_billing_state_id').val();
						  //$('#sale_company_state_id').val(sale_company_state_idd);
						  // alert(sale_company_state_idd);
						  // alert(party_billing_state);
						  if(party_billing_state != sale_company_state_idd){
								 $('.cgst').hide();
								 $('.sgst').hide();
								 $('.igst').show();
							 }else{
								  $('.cgst').show();
								  $('.sgst').show();
								  $('.igst').hide();
							 }
						}, 2000);	 
					 }
			 });
			 //}, 1000);			 
				var selected_sale_ledger_id2 = $(this).val();
			setTimeout(function(){
				var selected_sale_ledger_brch_id = $('#sale_ledger_company_branch_id').val();
				$.ajax({
					   type: "POST",
					   url: site_url+'account/get_company_branch/',
					   data: { id:selected_sale_ledger_id2,selected_sale_ledger_brch_id:selected_sale_ledger_brch_id}, 
					   success: function(result_2) {
						$('#invoice_num').val(result_2);
					   }
				});
			}, 2500);
		});
	 }
	 


function add_mailing_address_on_change(){
	
	$('#P_address').change(function(){
		var selected_mail_add = $(this).find("option:selected").text();
		$('#mailing_address_name').val(selected_mail_add);
		var selected_attrbute = $(this).find("option:selected").attr('data-gst');
		//alert(selected_attrbute);
		$('#gstin').val(selected_attrbute);
	});
	$('#sale_address').change(function(){
		var selected_attrbute33 = $(this).find("option:selected").attr('data-gst');
	    $('#sale_leger_gstin_no').val(selected_attrbute33);
		
		var branch_idg = $('#sale_address option:selected').attr('branh-id');
		$('#sale_ledger_company_branch_id').val(branch_idg);
				
				var selected_sale_ledger_id2 = $(this).val();
				var selected_sale_ledger_brch_id = $('#sale_ledger_company_branch_id').val();
				//alert('selected_sale_ledger_id2  '  +   selected_sale_ledger_brch_id );
					$.ajax({
					   type: "POST",
					   url: site_url+'account/get_company_branch/',
					   data: { id:selected_sale_ledger_id2,selected_sale_ledger_brch_id:selected_sale_ledger_brch_id}, 
					   success: function(result_2) {
						
							$('#invoice_num').val(result_2);
						
					}
				});
			
	});
}






//For hide and show port discharge and loading	 and Transport Vehicle validation
 function dicharge_loding_port_hide_show(){
		$('#invoice_type_id').change(function(){ 
		  var select_val =   $(this).val();
			if(select_val == 'export_invoice'){
				$('.exprt_div').show();
			}else{
				$('.exprt_div').hide();
			}
	});
	
	$('#transport_driver_pno').keypress(function(e) {
		//if(key.charCode < 48 || key.charCode > 57) return false;
		var keyCode = e.keyCode || e.which;
		var regex = /^[A-Za-z0-9]+$/;
		var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                return false
            }
            return isValid;
        });
		
	jQuery('#pan').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
	//show Hide charges Div
			$(document).on("click",".show_charges",function(){
				
				$('.charges_form').toggle();
				$('.ad_rm_readonly').prop('disabled', true);
				init_select2();
			var sale_company_state_idd = $('#sale_company_state_id').val();
			var party_billing_state = $('#party_billing_state_id').val();
				if(party_billing_state != sale_company_state_idd){
					 $('.cgst_amt1').hide();
					 $('.sgst_amt1').hide();
					 $('.igst_amt1').show();
				 }else{
					  $('.cgst_amt1').show();
					  $('.sgst_amt1').show();
					  $('.igst_amt1').hide();
				 }
			});
	//show Hide charges Div
	
}	

function tax_calculation_for_charges(){
	//According To charges Calculate Tax
	$('.charges_added').on('keyup', function() {
		var added_amount_val = $(this).val();
		
	    var matrial_select_this_val33 =  $(this);
		var totl_tax = $('#total_tax_slab').val();
		var total_tax_withAmount = totl_tax * added_amount_val/100;
		//alert(total_tax_withAmount);
		setTimeout(function(){
		var addition_add = (+total_tax_withAmount) +  (+added_amount_val);
		//alert(addition_add);
			$(matrial_select_this_val33).closest('.testDh').find("input[name='amt_with_tax[]']").val(addition_add);
			$(matrial_select_this_val33).closest('.testDh').find("input[name='amt_tax[]']").val(total_tax_withAmount);
		}, 1000);
	});
}
	
	
	
	function  test(sale_basic_amount , discount_amt , total_basic_amount){
		console.log('sale_basic_amount==>>>',sale_basic_amount);
		console.log('discount_amt==>>>',discount_amt);
		console.log('total_basic_amount==>>>',total_basic_amount);
	}
	
	
	
//For hide and show port discharge and loading	 and Transport Vehicle validation
  //ADD IGST CGST SGST CAlulation 	 
function add_charges_on_invoice(){
	$('.Add_charges_id').change(function(){
			var charge_ldger_id = $(this).val();
		
			var matrial_select_this_val =  $(this);
			
		setTimeout(function(){
			$('.ad_rm_readonly').prop('disabled', false);
				$.ajax({
					   type: "POST",
					   url: site_url+'account/get_charges_details/',
					   data: { id:charge_ldger_id}, 
					   success: function(result) {
						  
						   
						   var obj = jQuery.parseJSON(result);
						
						 if(obj.data.type_charges == 'minus'){
							$('.for_discount_hide').hide();
										$(matrial_select_this_val).closest('.testDh').find(".aply_btn").html('<input type="button"  class="add_dis" value="Apply Discount">');
										$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name[]']").val(obj.ledger_nam);
										$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name_id[]']").val(obj.data.ledger_id);
										$(matrial_select_this_val).closest('.testDh').find("input[name='type_charges[]']").val(obj.data.type_charges);
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").hide();
										
											var sale_basic_amount = 0;
											var total_basic_amount = 0;
								         	var amount_after_each_calcu = 0;
											var total_amt = 0;
											
											
											$('.add_dis').on('click', function() {
												var get_cahrges_added = $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
												
												if(get_cahrges_added == ''){
													$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid red");  
													return false;
												}else{
													$('.add_dis').attr('disabled','disabled');
													
												}
												$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid #ddd");  
												//$(this).attr('disabled','disabled');
													$(".sale_amount").each(function(){
													total_basic_amount += parseFloat($(this).val());													
												});	
												
												
												$(".sale_amount").each(function(){
													sale_basic_amount = parseFloat($(this).val());
													var discount_amt =	$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
													amount_after_each_calcu = sale_basic_amount * discount_amt/total_basic_amount;
													
													var amount_after_discount = sale_basic_amount - amount_after_each_calcu;
													//alert(amount_after_discount);
													 //console.log('Item Amount-->' + amount_after_discount);
														$(this).val(amount_after_discount);
														total_amt += amount_after_discount;
													$('.total_amount_save').val(total_amt);
													$('#total_amout_without_tax_on_keyup').val(total_amt);
													
													
												});	
												//For Tax Calculation
												var added_tax11 = 0;
												var amount_with_tax_amt = 0;
												$("input[name='tax[]']").each(function(){
													added_tax11 = parseFloat($(this).val());
													var get_basic_amt =  $(this);
													var basic_amt = $(get_basic_amt).closest('.input_descr_wrap').find("input[name='sale_amount']").val();
													var tax_amt = added_tax11 * basic_amt/100;
													$(get_basic_amt).closest('.input_descr_wrap').find('.added_tax').val(tax_amt);
													amount_with_tax =  parseFloat(tax_amt) + parseFloat( basic_amt);
													amount_with_tax_amt += amount_with_tax;
													$(get_basic_amt).closest('.input_descr_wrap').find("input[name='amount[]']").val(amount_with_tax);
													$('#total_amout_with_tax_on_keyup').val(amount_with_tax_amt); 
													subtotal();
													
												});
												//For Tax Calculation
												
											});
												
						   }
						  
						   if(obj.data.type_charges == 'plus'){
							  
							 $('.for_discount_hide').show();
						        $('#total_tax_slab').val(obj.data.tax_slab);//Add total_tax
						        
								$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name[]']").val(obj.ledger_nam);
								$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name_id[]']").val(obj.data.ledger_id);
								$(matrial_select_this_val).closest('.testDh').find("input[name='type_charges[]']").val(obj.data.type_charges);
								
								var sale_company_state_idd = $('#sale_company_state_id').val();
								var party_billing_state = $('#party_billing_state_id').val();
									if(party_billing_state != sale_company_state_idd){
										var taxslabb = obj.data.tax_slab;
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").val(taxslabb);
										
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").show();
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
									}else{
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
										$(matrial_select_this_val).closest('.testDh').find(".for_discount_hide").show;
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").show;
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").show;
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show;
										var taxslabb = obj.data.tax_slab;
										var tax_divide_state_diff = taxslabb / 2; 
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").val(tax_divide_state_diff);
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").val(tax_divide_state_diff);
									  }
							    }	
							}
						});
					}, 1000);	
				});
    //ADD IGST CGST SGST CAlulation
}

function add_filed_for_goods_descr_invoice(){
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".add-ro"); //Fields wrapper
    var add_button      = $(".add_description_detail_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
	    e.preventDefault();
			var uomsArray = '';
				$.each( uoms, function( key, value ) {
				uomsArray = uomsArray+'<option value="'+value+'">'+value+'</option>';
			});
			$('.add_requried').prop("disabled", true);
			var company_login_id = $('#company_login_id').val();			
			var get_discount_on_off = $('#get_discount_on_off').val();
			var item_code_on_off = $('#item_code_on_off').val();
			
        if(x < max_fields){ //max input box allowed
            x++; 				
			if(get_discount_on_off == 1 ){
				
				if(item_code_on_off == 1){
					var item_codew = '<div class="col-sm-1 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label><input type="text" name="item_code[]"  class="col-md-1 form-control col-md-1 mat_item_code" placeholder="Item Code" value=""></div>';
				}else{
					var item_codew = '';
				}
				
				$(wrapper).append('<div class="col-md-12 input_descr_wrap add-ro2 mailing-box mobile-view" style="margin-top:0px; ">'+ item_codew +'<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Matrial Name <span class="required">*</span></label><select class="matrial_details_id itemName form-control selectAjaxOption select2 get_val select2-hidden-accessible demoClass" required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='+ company_login_id +' AND status=1" width="100%"></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd">	</div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label><input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label><input type="text" required="required"   name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event qty" placeholder="Quantity" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label><div><input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" required="required" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label><div class="checktr"><select name="disctype[]" class="form-control disc_type_cls"><option value="">Select</option><option value="disc_precnt">Discount Percent</option><option value="disc_value">Discount Value</option></select></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label><div class=" checktr"><input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" placeholder="Disc Amt" value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label><div class="checktr">	<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" placeholder="After Disc Amt" value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax<span class="required">*</span></label><div><input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax_key_up_event" placeholder="Tax" value="" readonly><input type="hidden" value="" name="added_tax" class="added_tax"><input type="hidden" value="" name="added_tax_Row_val[]" ></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label><div><input type="text" name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" placeholder="Amount" value="" readonly><input type="hidden" value="" name="sale_amount" class="sale_amount"><input type="hidden" value="" name="cess[]"><input type="hidden" value="" name="cess_tax_calculation[]"><input type="hidden" value="" name="valuation_type[]"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>');
			}else{
				if(item_code_on_off == 1){
					var item_codew = '<div class="col-sm-1 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label><input type="text" name="item_code[]"  class="col-md-1 form-control col-md-1 mat_item_code" placeholder="Item Code" value=""></div>';
					var uom_code = '<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div>';
				}else{
					var item_codew = '';
					var uom_code = '<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div>';
				}
				
				$(wrapper).append('<div class="col-md-12 input_descr_wrap add-ro2 mailing-box mobile-view">'+ item_codew + '<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Matrial Name <span class="required">*</span></label><select class="matrial_details_id itemName form-control selectAjaxOption select2 get_val select2-hidden-accessible demoClass" required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='+ company_login_id +' AND status=1" width="100%"></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label><input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC"  value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label><input type="text" required="required"   name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event qty" placeholder="Quantity" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label><div><input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" required="required" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label><div><input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax_key_up_event" placeholder="Tax" value="" readonly><input type="hidden" value="" name="added_tax" class="added_tax"><input type="hidden" value="" name="added_tax_Row_val[]" ></div></div>'+ uom_code +'<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label><div><input type="text" name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" placeholder="Amount" value="" readonly><input type="hidden" value="" name="sale_amount" class="sale_amount"><input type="hidden" value="" name="cess[]"><input type="hidden" value="" name="cess_tax_calculation[]"><input type="hidden" value="" name="valuation_type[]"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>');
			}
				get_multiselect_value();
				get_material_thrugh_item_code();
				kyup_function_to_remove_add_rate_qty();				
				tax_keyup_event_to_remove_tax();
				subtotal();
				get_add_more_btn_forsale_ledger();
				init_select21();
				init_select221();
				sale_ledger_id_onchange();
				party_name_ledger_id_onchange();
				add_charges_on_invoice();
				tax_calculation_for_charges();
				add_dicount_invoice_matrial();
			
        }
    });
    
    $(wrapper).on("click",".remove_descr_field", function(e){ //user click on remove text
        e.preventDefault();
		$(this).parent('div').remove(); x--;
		setTimeout(function(){
						$('.keyup_event').keyup();	
					}, 1000);
    });	
}
//Script to add Discount in Invoice
function add_dicount_invoice_matrial(){
	$('.disc_type_cls').change(function(){
			var discount_type_val = $(this).val();
			 var discount_texbox_val =  $(this);
			var added_qty =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
    		var added_rate =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='rate[]']").val();
			
			var amt_acc_to_qty = added_qty * added_rate;
			
			$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val('');
			$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val('');
				
					
			if(discount_type_val == 'disc_precnt'){
				$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly',false);
				$('.added_discount_amt').keyup(function(){
						var discount_val =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val();
						var get_percent_amt = 	amt_acc_to_qty * discount_val/100;
						// 
						setTimeout(function(){
							var After_disc_total_amt =  amt_acc_to_qty - get_percent_amt;
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val(After_disc_total_amt);
							var get_discount_amut = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();
							
							var get_added_tax = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='tax[]']").val();
						
							var add_tax_after_discount = 	get_discount_amut * get_added_tax/100;
							
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val(add_tax_after_discount);
							
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='sale_amount']").val(After_disc_total_amt);
							
						}, 1000);
						
						setTimeout(function(){
								var added_tax_amount = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val();
								var get_after_desc_amt = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();
								var after_discount_add_Amt_in_tax = parseFloat(added_tax_amount)  + parseFloat(get_after_desc_amt);
								$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='amount[]']").val(after_discount_add_Amt_in_tax);
								var sale_amount2 = 0;
									$("input[name='sale_amount']").each(function(){
										sale_amount2 += parseFloat($(this).val());
									});
									var amount_without_tax = sale_amount2.toFixed(2);	
									$(".total_amountt").val(amount_without_tax);
									//Tax 
									var added_tax = 0;	
									$("input[name='added_tax']").each(function(){
										added_tax += parseFloat($(this).val());
									});	
									
										$(".tax_class").val(added_tax);	
									 var result_divide = parseInt(added_tax) / parseInt(2);
									 $(".tax_class1").val(result_divide);
									 $(".tax_class2").val(result_divide);
									//Tax 
									var grand_total_sum = 0;
									$("input[name='amount[]']").each(function() {
									grand_total_sum += Number($(this).val());
									});
									$(".grand_total").val(grand_total_sum);
									
						}, 1000);
					});
				}else{
					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly',false);
				$('.added_discount_amt').keyup(function(){
						var discount_val =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val();
						 
						setTimeout(function(){
							var After_disc_total_amt =  amt_acc_to_qty - discount_val;
							
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val(After_disc_total_amt);
							var get_discount_amut = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();
							
							var get_added_tax = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='tax[]']").val();
						
							var add_tax_after_discount = 	get_discount_amut * get_added_tax/100;
							
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val(add_tax_after_discount);
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='sale_amount']").val(After_disc_total_amt);
							
						}, 1000);
						
						setTimeout(function(){
								var added_tax_amount = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val();
								var get_after_desc_amt = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();
								var after_discount_add_Amt_in_tax = parseFloat(added_tax_amount)  + parseFloat(get_after_desc_amt);
								$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='amount[]']").val(after_discount_add_Amt_in_tax);
									var sale_amount2 = 0;
									$("input[name='sale_amount']").each(function(){
										sale_amount2 += parseFloat($(this).val());
									});

									var amount_without_tax = sale_amount2.toFixed(2);	
									$(".total_amountt").val(amount_without_tax);
									//Tax 
									var added_tax = 0;	
									$("input[name='added_tax']").each(function(){
										added_tax += parseFloat($(this).val());
									});	
										$(".tax_class").val(added_tax);	
									 var result_divide = parseInt(added_tax) / parseInt(2);
									 $(".tax_class1").val(result_divide);
									 $(".tax_class2").val(result_divide);
									//Tax 
									var grand_total_sum = 0;
									$("input[name='amount[]']").each(function() {
									grand_total_sum += Number($(this).val());
									});
									$(".grand_total").val(grand_total_sum);
							}, 1000);
					});
				}


	})
}	


//Script to add Discount in Invoice
//Add charges Details 
function add_more_charges_details(){
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_charges_details"); //Fields wrapper
    var add_button      = $(".add_charges_detail_button"); //Add button ID
    var x = 1; //initlal text box count
	
    $(add_button).click(function(e){ //on add input button click 
	    e.preventDefault();
			
			$('.ad_rm_readonly').prop('disabled', true);
			var company_login_id = $('#company_login_id').val();			
        if(x < max_fields){ //max input box allowed
            x++; 				
				$(wrapper).append('<div class="col-md-12 input_charges_details charges_form" style="padding: 0px;"><div class="testDh middle-box mailing-box mobile-view"><div class="col-md-2 col-xs-12 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Particulars.</label><select class="itemName form-control selectAjaxOption select2 Add_charges_id"  required="required" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid='+ company_login_id +' AND charges_for = 0" width="100%"><option value="">Select</option></select></div><div class="col-md-2 col-xs-12 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Ledger Name.</label><input type="text" class="form-control col-md-1 ledgr_nam" name="ledger_name[]" value="" readonly><input type="hidden" class="form-control col-md-1 ledgr_nam_id" name="ledger_name_id[]" value="" readonly><input type="hidden" class="form-control col-md-1 type_charges" name="type_charges[]" value="" readonly></div><div class="col-md-2 col-xs-12 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="valuofexp">Value of Exp.</label><input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value=""><span class="aply_btn"></span><input type="hidden" value="" id="total_tax_slab"></div><div class="col-md-2 col-xs-12 item form-group sgst_amt1"><label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="sgstamount">SGST Amount</label><input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt" name="sgst_amt[]" value=""></div><div class="col-md-2 col-xs-12 item form-group cgst_amt1"><label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="cgst Amount">CGST Amount</label><input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" ></div><div class="col-md-2 col-xs-12 item form-group igst_amt1"><label class="col-md-12 col-sm-12 col-xs-12 for_discount_hide" for="igstamount">IGST Amount</label><input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]" value="" ></div><div class="col-md-2 col-xs-12 item form-group"><label class="col-md-12 col-sm-12 col-xs-12  for_discount_hide" for="addtaxamount">Amt. with Tax</label><input type="text" style="border-right:1px solid #c1c1c1;" class="form-control col-md-1 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value=""><input style="border-right:1px solid #c1c1c1;" type="hidden" class="form-control col-md-1 tttl_TaX" name="amt_tax[]" value="<?php echo $charges_details->amt_tax; ?>"></div><button class="btn btn-danger remove_charges_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
				init_select2();
				dicharge_loding_port_hide_show();
				add_charges_on_invoice();
				tax_calculation_for_charges();
				
				var sale_company_state_idd = $('#sale_company_state_id').val();
				var party_billing_state = $('#party_billing_state_id').val();
				if(party_billing_state != sale_company_state_idd){   
					 $('.cgst_amt1').hide();
					 $('.sgst_amt1').hide();
					 $('.igst_amt1').show();
				 }else{
					  $('.cgst_amt1').show();
					  $('.sgst_amt1').show();
					  $('.igst_amt1').hide();
				 }
		}
    });
    
    $(wrapper).on("click",".remove_charges_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });	
}
//Add charges Details 

	function get_multiselect_value(){ 
		$('.get_val').change(function(){ 		
		//console.log('this==>>',$(this).closest('.input_descr_wrap').find('.goods_descr_section').val('abc'));
		 var matrial_select_this =  $(this);
		
		  var selected_id = $(this).val();	
			
				$.ajax({
				   type: "POST",
				   url: site_url+'account/selectMatrial/',
				   data: { id:selected_id}, 
				   success: function(result) {
					  var obj = jQuery.parseJSON(result);
					 
					  var specification_var = obj.specification;
					  var hsn_code_var = obj.hsn_code;
					  var uom_var = obj.uom;
					  var cess_var = obj.cess;
					  var valuation_type = obj.valuation_type;
					  console.log('Check It==>',valuation_type);
					
					  var quantity = obj.opening_balance;
					  var rate = obj.sales_price;
					  var tax = obj.tax;
					   //alert(tax);
					  var mat_idds = obj.id;
					  var mat_material_code = obj.material_code;
					  var TotalAmount = rate*quantity;
					  
					  var closing_balance = obj.closing_balance;
					    if(closing_balance == 0){
						// $(matrial_select_this).closest('.input_descr_wrap').find("input[name='quantity[]']").attr("disabled", "disabled"); 
						 // $('.chrk_mat_qty').attr("disabled", "disabled");
						//$('#mat_msg').html('This Material Not Available');		
					  }else{
						 // $(matrial_select_this).closest('.input_descr_wrap').find("input[name='quantity[]']").removeAttr("disabled"); 
						//  $('.chrk_mat_qty').removeAttr("disabled"); 
						//  $('#mat_msg').html('');
					  }
					 
					 //console.log('this==>>',$(matrial_select_this).closest('.input_descr_wrap ').find("input[name='tax[]']").val(tax));
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='mat_idd_name']").val(mat_idds);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='item_code[]']").val(mat_material_code);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='descr_of_goods[]']").val(specification_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='hsnsac[]']").val(hsn_code_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='quantity[]']").val(1); 
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='rate[]']").val(rate);
					
						$(matrial_select_this).closest('.input_descr_wrap').find("input[name='tax[]']").val(tax);
						if(cess_var != '' ||  cess_var != null){
							$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess[]']").val(cess_var);
							$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess_all_total[]']").val(cess_var);
							$(matrial_select_this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val(valuation_type);
						}else if(cess_var == '' ||  cess_var == null){
							$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess[]']").val('');
							$(matrial_select_this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val('');
							$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess_all_total[]']").val('');
							$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val('');
						}
					//$(matrial_select_this).closest('.input_descr_wrap').find("input[name='sale_amount']").val(tax);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='amount[]']").val(0);
					//$(matrial_select_this).closest('.input_descr_wrap').find('select[name="UOM[]"] option[value="' + uom_var + '"]').prop('selected',true);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='UOM[]']").val(uom_var);
					subtotal();
					
					setTimeout(function(){
						$('.keyup_event').keyup();	
					}, 1000);
					
				 }
			 });
		}); 
		
		$('.remove_descr_field').on('click',function(){
			setTimeout(function(){
				$('.keyup_event').keyup();
			}, 1000);
		});	
		
		
	
	}
function get_material_thrugh_item_code(){
	$('.mat_item_code').on( "keydown keyup paste", function() {	
			var added_code_length = $(this).val().length;
				if(added_code_length >= 3){
					 var matrial_select_this_code =  $(this);
					 var selected_material_code = $(this).val();	
				
				setTimeout(function(){
				$.ajax({
				   type: "POST",
				   url: site_url+'account/selectMatrial_according_item_code/',
				   data: { material_code:selected_material_code}, 
				   success: function(result) {
					  var obj = jQuery.parseJSON(result);
					 console.log('There',obj);
					  var specification_var = obj.specification;
					  var hsn_code_var = obj.hsn_code;
					  var uom_var = obj.uom;
					  var cess_var = obj.cess;
					  var valuation_type = obj.valuation_type;
					  var quantity = obj.opening_balance;
					  var rate = obj.sales_price;
					  var tax = obj.tax;
					   //alert(tax);
					  var mat_idds = obj.id;
					  var mat_material_code = obj.material_code;
					  var material_name_cd = obj.material_name;
					 
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='mat_idd_name']").val(mat_idds);
					//$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='item_code[]']").val(mat_material_code);
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='descr_of_goods[]']").val(specification_var);
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='hsnsac[]']").val(hsn_code_var);
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='quantity[]']").val(1); 
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='rate[]']").val(rate);
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='tax[]']").val(tax);
					//$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='sale_amount']").val(tax);
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='amount[]']").val(0);
					//$(matrial_select_this_code).closest('.input_descr_wrap').find('select[name="material_id[]"] option[value="' + material_name_cd + '"]').prop('selected',true);
					if(cess_var != '' ||  cess_var != null){
						$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess[]']").val(cess_var);
						$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess_all_total[]']").val(cess_var);
						$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val(valuation_type);
					}else if(cess_var == '' ||  cess_var == null){
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess[]']").val();
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess_all_total[]']").val('');
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val();
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val('');
						}
					var newOption = $("<option selected='selected'></option>").val(mat_idds).text(material_name_cd);
					
					
					
					
					$(matrial_select_this_code).closest('.input_descr_wrap').find(".get_val").append(newOption).trigger('change');
					$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='UOM[]']").val(uom_var);
					subtotal();
					
					setTimeout(function(){
						$('.keyup_event').keyup();	
					}, 1000);
					
				 }
			 });
		}, 1000);			
				}
			
		});
}	

function kyup_function_to_remove_add_rate_qty(){
	$('.keyup_event').keyup(function(){	
	var matrial_select_this_val =  $(this);
	    //when discount added and change quantity 
		$(this).closest('.input_descr_wrap').find("select[name='disctype[]']").prop('selectedIndex',0);
		$(this).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val('');
		$(this).closest('.input_descr_wrap').find("input[name='discamt[]']").val('');
		$(this).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly',true);
		 //when discount added and change quantity
		var theQuantity = $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		var thePrice = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		var thetax = $(this).closest('.input_descr_wrap').find("input[name='tax[]']").val();
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(thetax);
		var with_quantity_price = theQuantity * thePrice;		
		var percent_on_total = thetax * with_quantity_price/100;
 // alert(percent_on_total);  

		// var tax_ccording_to_quantity = thetax * theQuantity; 
		
		
	    
		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		var valueww = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);		
		/* Calculation of Cess*/
		var cess_Amt = $(this).closest('.input_descr_wrap').find("input[name='cess[]']").val();
		var valuation_type_val = $(this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val();
		console.log('vauation Type ====>',valuation_type_val);
		if(cess_Amt != '' ||  cess_Amt != null){
			if( valuation_type_val == 'based_on_value'){
				var afteradd_cessTax = valueww * cess_Amt/100;
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(afteradd_cessTax);
				var withcess_Amt = parseFloat(valueww) + parseFloat(afteradd_cessTax);
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
		}
		if(valuation_type_val == 'based_on_qty'){
			var cess_amt_ttl =	theQuantity * cess_Amt;
			var afteradd_cessTax =  parseFloat(valueww) + parseFloat(cess_amt_ttl) ;
			console.log('afteradd_cessTax ==>',afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(cess_amt_ttl);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
			
		}
		if(valuation_type_val == 'based_on_qty_value'){
			var cess_amt_ttl =	theQuantity * cess_Amt;
			var Cess_persent_value = valueww * cess_Amt/100;
			console.log('cess_amt_ttl',cess_amt_ttl);
			console.log('Cess_persent_value',Cess_persent_value);
			var Add_val_qty = parseFloat(Cess_persent_value) + parseFloat(cess_amt_ttl) ;
			console.log('Add_val_qty',Add_val_qty);
			var afteradd_cessTax =  parseFloat(valueww) + parseFloat(Add_val_qty) ;
			console.log('afteradd_cessTax ==>',afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(Add_val_qty);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
			
		}	
		}else if(cess_Amt == '' ||  cess_Amt == null){
			$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val('');
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val('');
			$(".cess_total_cls").val('');
		}
		setTimeout(function(){
			var Cess_TOTAL = 0;
			$("input[name='cess_tax_calculation[]']").each(function(){
			Cess_TOTAL += Number($(this).val());
		});
			if(Cess_TOTAL == 0){
				$('.cess').hide();	
				}else{
					$('.cess').show();	
				}
		}, 1500);	
		/* Calculation of Cess*/	
		//alert(with_quantity_price);
		$(this).closest('.input_descr_wrap').find("input[name='sale_amount']").val(with_quantity_price);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(percent_on_total);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax_Row_val[]']").val(percent_on_total);
		subtotal();
		var total_amount = $(".total_amountt").val();
		if(total_amount > 0){
			$('.add_requried').prop("disabled", false);
		}else{
			$('.add_requried').prop("disabled", true);
		}
		
		var gg_total = $(".grand_total").val();
		
		if (gg_total > 50000) {
			$('#eway_bill_msg').html('Please Add E-way bill Number');
			$("#eway_bill_msg").delay(3200).fadeOut(2000);
		}
		
		$('#total_amout_with_tax_on_keyup').val(gg_total);
		$('#total_amout_without_tax_on_keyup').val(total_amount);
		
		var matrial_select_this2 =  $(this);
			var matral_idds = $(matrial_select_this2).closest('.input_descr_wrap').find("input[name='mat_idd_name']").val();
			var  added_qty = $(matrial_select_this2).closest('.input_descr_wrap').find("input[name='quantity[]']").val();		
						$.ajax({
						   type: "POST",
						   url: site_url+'account/get_closing_matrila_qty/',
						   data: { matral_idds:matral_idds}, 
						   success: function(result) {
							   if(parseInt(added_qty) > parseInt(result)){
								  //$('#mat_msg').html('The Available Quantity is ' + result); 
								  //$('.chrk_mat_qty').attr("disabled", "disabled");
							   }else{
								  // $('#mat_msg').html('');
								   //$('.chrk_mat_qty').removeAttr("disabled");     
							   }
							 }         
						   }); 
	});
}

  




function tax_keyup_event_to_remove_tax(){
	$('.tax_key_up_event').keyup(function(){
		// $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val('0');
		// $(this).closest('.input_descr_wrap').find("input[name='amount[]']").val('0');
		/* New added Code */
		//when discount added and change quantity 
		$(this).closest('.input_descr_wrap').find("select[name='disctype[]']").prop('selectedIndex',0);
		$(this).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val('');
		$(this).closest('.input_descr_wrap').find("input[name='discamt[]']").val('');
		$(this).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly',true);
		 //when discount added and change quantity
		var theQuantity = $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		var thePrice = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		var thetax = $(this).closest('.input_descr_wrap').find("input[name='tax[]']").val();
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(thetax);
		var with_quantity_price = theQuantity * thePrice;		
		var percent_on_total = thetax * with_quantity_price/100;
// alert(percent_on_total);  

		// var tax_ccording_to_quantity = thetax * theQuantity; 
	
		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		var valueww = Total_with_tax.toFixed(2);		
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
		$(this).closest('.input_descr_wrap').find("input[name='sale_amount']").val(with_quantity_price);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(percent_on_total);
		subtotal();
		var total_amount = $(".total_amountt").val();
		if(total_amount > 0){
			$('.add_requried').prop("disabled", false);
		}else{
			$('.add_requried').prop("disabled", true);
		}
		
		var gg_total = $(".grand_total").val();
		
		$('#total_amout_with_tax_on_keyup').val(gg_total);
		$('#total_amout_without_tax_on_keyup').val(total_amount);
		
		/* New added Code*/
	
		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		var valueww = Total_with_tax.toFixed(2);		
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
		$(this).closest('.input_descr_wrap').find("input[name='sale_amount']").val(with_quantity_price);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(percent_on_total);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax_Row_val[]']").val(percent_on_total);
		
		var qtty_value = $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		
		var amount_valuue = $(this).closest('.input_descr_wrap').find("input[name='amount[]']").val();
		if(qtty_value == 0 || amount_valuue ){
			//$('.chrk_mat_qty').attr("disabled", "disabled");
			$('.chrk_mat_qty').removeAttr("disabled"); 
		}else{
			$('.chrk_mat_qty').removeAttr("disabled");   
		}
	});
}	

function subtotal() {
	var tot = 0;
	var sale_amount2 = 0;
	var added_tax = 0;	
	var added_tax_total = 0;	
	$("input[name='amount[]']").each(function(){
		tot += parseFloat($(this).val());
	});
	var g_total2 = tot.toFixed(2);	
	$(".grand_total").val(g_total2);
	$(".total_amount_save").val(g_total2);	
	$("input[name='sale_amount']").each(function(){
		sale_amount2 += parseFloat($(this).val());
	});
	var amount_without_tax = sale_amount2.toFixed(2);	
	$(".total_amountt").val(amount_without_tax);
	$("input[name='added_tax_Row_val[]']").each(function(){
		added_tax += parseFloat($(this).val());
		 added_tax_total = added_tax.toFixed(2);	
	});	
		$(".tax_class").val(added_tax_total);	
		
	 var result_divide = parseInt(added_tax_total) / parseInt(2);
	 $(".tax_class1").val(result_divide);
	 $(".tax_class2").val(result_divide);
}
//GET STATE City Script
function getState(evt, t , type = ''){	
	var appendedClass = type != ''?'.'+type+'.state_id':'.state_id';
	var appendedClassCity = type != ''?'.'+type+'.city_id':'.city_id';	
	//$(appendedClass).empty();
	$(t).parent().parent().next().find('.state_id').empty();
	//$(appendedClassCity).empty();	
	$(t).parent().parent().next().find('.state_id').empty();	
	var option = $(t).find('option:selected');
	//var country_id = type != ''?type:$(option).val();
	var country_id =$(option).val();
	if(country_id != ''){
		/* $(appendedClass).attr('data-where','country_id = '+country_id);		
		$(appendedClass).attr('data-id','state');
		$(appendedClass).attr('data-key','state_id');
		$(appendedClass).attr('data-fieldname','state_name'); */
		$(t).parent().parent().next().find('.state_id').attr('data-where','country_id = '+country_id);
		$(t).parent().parent().next().find('.state_id').attr('data-id','state');
		$(t).parent().parent().next().find('.state_id').attr('data-key','state_id');
		$(t).parent().parent().next().find('.state_id').attr('data-fieldname','state_name');
	
	}
}


function getCity(evt , t, type = ''){
	var appendedClass = type != ''?'.'+type+'.city_id':'.city_id';
	//$(appendedClass).empty();	
	$(t).parent().parent().next().find('.city_id').empty();	
	var option = $(t).find('option:selected');
	//var state_id = type != ''?type:$(option).val();
	var state_id = $(option).val();
	if(state_id != ''){	
		/* $(appendedClass).attr('data-where','state_id = '+state_id);
		$(appendedClass).attr('data-id','city');
		$(appendedClass).attr('data-key','city_id');
		$(appendedClass).attr('data-fieldname','city_name'); */
		$(t).parent().parent().next().find('.city_id').attr('data-where','state_id = '+state_id);
		$(t).parent().parent().next().find('.city_id').attr('data-id','city');
		$(t).parent().parent().next().find('.city_id').attr('data-key','city_id');
		$(t).parent().parent().next().find('.city_id').attr('data-fieldname','city_name');	
	}	
}
//GET STATE City Script

//GET PARTY Details
function get_party_details_onchange(){
	$('.add_option').on('change',function(){
		var partyID = $(this).val();
		//alert(partyID);
		$.ajax({
				   type: "POST",
				   url: site_url+'account/GetParty_details/',
				   data: { id:partyID}, 
				   success: function(htmlStr) {
				     var obj = jQuery.parseJSON(htmlStr);
					
					 var get_state_id =  jQuery.parseJSON(obj.mailing_address);
					
					 var party_id = obj.id;
					 var party_phone = obj.phone_no;
					 
					 var party_gstin = obj.gstin;
					 var party_description = get_state_id[0].mailing_address;
					 var party_email = obj.email;
					 //alert(party_email);
					
					 var party_billing_state = get_state_id[0].mailing_state;
					 var account_group_id = obj.account_group_id;
					 //alert(party_billing_state);
					 $('#party_phone').val(party_phone);
					 $('#email_id').val(party_email);
					 $('#gstin').val(party_gstin);
					 //$('#terms_of_delivery').val(party_description);
					 $('#party_billing_state_id').val(party_billing_state);
					 $('#account_group_id').val(account_group_id);
					 var sale_company_state_idd = $('#sale_company_state_id').val();
					 //alert(login_company_state_idd);
					 if(party_billing_state != sale_company_state_idd){
						 $('.cgst').hide();
						 $('.sgst').hide();
						 $('.igst').show();
					 }else{
						  $('.cgst').show();
						  $('.sgst').show();
						  $('.igst').hide();
					 }
				}
			 });
	});
}

/*************************get email corresponding to suppplier in payment to *********************************************/
function getEmail(t,evt){
	var supplier_id =  $(t).val();
		$.ajax({
		   type: "POST",
		   url: site_url+'account/getEmail/',
		   data: { 
			supplier_name:supplier_id
		   }, 
		    success: function(htmlStr) {
				$('#email_idd').val(htmlStr);
			}		   
		});
}

//Invoice Setting Scripts Stars here	

$(document).on("click",".add_invoice_settings",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		console.log('tabd===>>>>',tab);
		console.log('idd===>>>>',id);
		switch (tab) {
			case 'invoice_settings':
				url = 'account/editInvoice_setting';
				break;	
			case 'invoice_view_setting':
				url = 'account/viewInvoice_setting';
				break;					
		}	
	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){
				
				if(data != '') {
					$("#add_invoice_setting_modal").modal({
						show:false,
						backdrop:'static'
					});
					$('#add_invoice_setting_modal').modal('toggle');
					$('#add_invoice_setting_modal .modal-body-content').html(data);		
					
					$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
				}
			}
		}); 
	});

function init_select21() {
	$('#get_add_more_btn').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: 'Select And Begin Typing',
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2search',
			dataType: 'json',
			delay: 250,
			data: function (params) {
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },		  
        processResults: function (data) {
            return {
              results: data
            };
        },
			cache: true,
         },language: {
			noResults: function() {
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				var searched_value =  $('.select2-search__field').val();
				$('#fetch_pname').val(searched_value);
				var lb_ID = $('#fetch_pname').val();
				  $('.party_namee').val(lb_ID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' id='opty' class='add_more_party_name'>Add </span>";
			  }
			},escapeMarkup: function (markup) {
				return markup;  
				
			}
    });
	
}

function init_select_voucher() {
	$('#get_add_more_btn_for_voucher').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: 'Select And Begin Typing',
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2search',
			dataType: 'json',
			delay: 250,
			data: function (params) {
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },		  
        processResults: function (data) {
            return {
              results: data
            };
        },
			cache: true,
         },language: {
			noResults: function() {
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				var searched_value =  $('.select2-search__field').val();
				$('#fetch_pname').val(searched_value);
				var lb_ID = $('#fetch_pname').val();
				$('#voucher_name').val(lb_ID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;'  class='add_more_voucher_name'>Add voucher</span>";
			  }
			},escapeMarkup: function (markup) {
				return markup;  
				
			}
    });
	
}
$(document).on("click",".add_more_voucher_name",function(){	
	 $('#myModal_Add_voucher').modal('show');
});
//To close Add PArty Popup Model
$(document).on("click",".close_sec_model",function(){
	 $('#myModal_Add_voucher').modal('hide');
});

function get_add_more_btn_forsale_ledger(){
$('#get_add_more_btn_forsale_ledger').select2({	
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: 'Select And Begin Typing',
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2search',
			dataType: 'json',
			delay: 250,
			data: function (params) {			
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
				
        },		  
        processResults: function (data) {
			//alert(JSON.stringify(data));
            return {
              results: data
            };
        },
			cache: true,
         },language: {
			noResults: function() {
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				var searched_value =  $('.select2-search__field').val();
				$('#fetch_pname').val(searched_value);
				var lb_ID = $('#fetch_pname').val();
				  $('.party_namee').val(lb_ID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_party'>Add Sale Ledger </span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
    });	
	
}
//Add More Matrial On the spot
function init_select221() {
	$('.matrial_details_id').select2({
		//dropdownCssClass: 'custom-dropdown'
		//alert('dfdfdf');
		allowClear: true,
        placeholder: 'Select And Begin Typing',
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2search',
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },		  
        processResults: function (data) {
            return {
              results: data
            };
        },
			cache: true,
    },language: {
			noResults: function() {
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='Add_matrial'>Add Material</span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
    });
	
}
$(document).on("click",".Add_matrial",function(){
	//To get Matrieal Type Ajax
	var user_id = 1;
	$.ajax({
		   type: "POST",
		   url: site_url+'account/Get_matrial_type/',
		  data: {user_id:user_id}, 
		   success: function(htmlStr) {
			  var  obj = JSON.parse(htmlStr);
			  var len = obj.length;
				for(var i=0; i<len; i++){	
					
					var id = obj[i].id;
					var name = obj[i].name;
					var prefix = obj[i].prefix;
					var str_Dta = '<option value="'+id+'" data-prfix="'+prefix+'">'+ name +'</option>';
					var str_prefix = '<input type="hidden" value="'+prefix+'" >';
					$("#material_type_id").append(str_Dta);					
				}
		}
 });
 
 
 $("#material_type_id").change(function(){ 
      var ssd = $('option:selected', this).attr('data-prfix');
		$('#prefix').val(ssd);
    }); 	
	//To get Matrieal Type Ajax		
	 $('#myModal_Add_matrial_details').modal('show');
	 var btn_html = $(this).html();
	 $('#add_matrial_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger
});

$(document).on("click",".close_sec_model",function(){
	 $('#myModal_Add_matrial_details').modal('hide');
});


$(document).on("click","#Add_matrial_details_on_button_click",function(){
	$('#mssg34').html('');
	var material_name  = $('#material_name').val();
	var hsn_code  = $('#hsn_code').val();
	var uom  = $('#uom').val();
	var tax  = $('#tax').val();
	var specification  = $('#specification').val();
	//var closing_balance  = $('#closing_balance').val();
	var material_type_id  = $('#material_type_id').val();
	var prefix  = $('#prefix').val();
	
	if ($('#non_inventry_material').is(":checked"))
		{
		 var chk_box_val = 'checked';
		}else{
			var chk_box_val = 'not checked';
		}
	var error = 0;
		if(material_name == ''){
				$('#material_name').css('border', '1px solid #b94a48');
				$('#material_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#material_name').css('border', '1px solid #dedede');
				$('#material_name').closest(".form-group").find("span").text('');
			}
		if(tax == ''){
				$('#tax').css('border', '1px solid #b94a48');
				$('#tax').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#tax').css('border', '1px solid #dedede');
				$('#tax').closest(".form-group").find("span").text('');
			}	
		// if(hsn_code == ''){
				// $('#hsn_code').css('border', '1px solid #b94a48');
				// $('#hsn_code').closest(".form-group").find("span").text('This field is required');
				// var error = 1;
			// }else{
				// $('#hsn_code').css('border', '1px solid #dedede');
				// $('#hsn_code').closest(".form-group").find("span").text('');
			// }
		if(uom == ''){
				$('#uom').css('border', '1px solid #b94a48');
				$('#uom').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#uom').css('border', '1px solid #dedede');
				$('#uom').closest(".form-group").find("span").text('');
			}
		// if(tax == ''){
				// $('#tax').css('border', '1px solid #b94a48');
				// $('#tax').closest(".form-group").find("span").text('This field is required');
				// var error = 1;
			// }else{
				// $('#tax').css('border', '1px solid #dedede');
				// $('#tax').closest(".form-group").find("span").text('');
			// }	
		if(specification == ''){
				$('#specification').css('border', '1px solid #b94a48');
				$('#specification').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#specification').css('border', '1px solid #dedede');
				$('#specification').closest(".form-group").find("span").text('');
			}
		// if(chk_box_val == 'not checked'){
				// $('#non_inventry_material').css('border', '1px solid #b94a48');
				// $('#non_inventry_material').closest(".form-group").find("span").text('This field is required');
				// var error = 1;
			// }else{
				// $('#non_inventry_material').css('border', '1px solid #dedede');
				// $('#non_inventry_material').closest(".form-group").find("span").text('');
			// }	
	if(material_type_id == ''){
				$('#material_type_id').css('border', '1px solid #b94a48');
				$('#material_type_id').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#material_type_id').css('border', '1px solid #dedede');
				$('#material_type_id').closest(".form-group").find("span").text('');
			}			
		
		if(error == 1) { 
			return false;
		} else {
		$.ajax({
				   type: "POST",
				   url: site_url+'account/add_matrial_Details_onthe_spot/',
				   data: {material_name:material_name,hsn_code:hsn_code,uom:uom,specification:specification,material_type_id:material_type_id,prefix:prefix,chk_box_val:chk_box_val,tax:tax}, 
				   success: function(htmlStr) {
					// alert(htmlStr);
				    if(htmlStr == 'true'){
						$('#mssg34').html('<span style="color:green;">Material Added Successfully.</span>');
						$("#insert_Matrial_data_id").trigger('reset');
						setTimeout(function(){
							$('#myModal_Add_matrial_details').modal('hide');
							$('#myModal_Add_matrial_details_purchse').modal('hide');
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);		
					}else{
						$('#mssg34').html('<span style="color:red;">Not Added.</span>');
					}
				}
			 });
		}
});

//Script End Add more Matrial On the spot
$(document).on("click",".add_more_party_name",function(){
	$('#mssg').html('');
    $('#myModal_Add_party').modal('show');
	///init_select2();
});

function show_sale_ledgers_branch(){
	 $('.acc_group_id').change(function(){
			var selected_acc_value = $('.acc_group_id').find(':selected').val();
			if(selected_acc_value == '7' || selected_acc_value == '8'){
				$('.company_brnch_div').show();
			}else{
				$('.company_brnch_div').hide();
			}
	 });	
}



//For adding More Parties using Model
$(document).on("click",".add_more_party",function(){
	$('#mssg').html('');
    $('#myModal_Add_party').modal('show');
	// init_select2();
	// get_add_more_btn_forsale_ledger();
	 var btn_html = $(this).html();
	 $('#sale_ledger_data').val(btn_html);
	// alert(btn_html);Add Sale Ledger
show_sale_ledgers_branch();
	
	
});
//To close Add PArty Popup Model
$(document).on("click",".close_sec_model",function(){
	 $('#myModal_Add_party').modal('hide');
});


//For Save party data with validation
$(document).on("click","#bbttn",function(){	

	var partyname  = $('#partyname').val();
	var partyemail  = $('#partyemail').val();
	var partygstin  = $('#partygstin').val();
	var sale_ledger_data_val  = $('#sale_ledger_data').val();
	var mailing_address  = $('#mailing_address').val();
	var opening_balance  = $('#opening_balance').val();
	var country  = $('#cntry').val();
	var state  = $('.state_id').val();
	var city_id  = $('.city_id').val();
	
	var acc_group_id  = $('.acc_group_id').val();
	var compny_branch_id  = $('.select_company_branch').val();

	var error = 0;
		if(partyname == ''){
				$('#partyname').css('border', '1px solid #b94a48');
				$('#partyname').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#partyname').css('border', '1px solid #dedede');
				$('#partyname').closest(".form-group").find("span").text('');
			}
		// if(partyemail == ''){
				// $('#partyemail').css('border', '1px solid #b94a48');
				// $('#partyemail').closest(".form-group").find("span").text('This field is required');
				// var error = 1;
			// }else{
				// $('#partyemail').css('border', '1px solid #dedede');
				// $('#partyemail').closest(".form-group").find("span").text('');
			// }
		if(partygstin == ''){
				$('#partygstin').css('border', '1px solid #b94a48');
				$('#partygstin').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#partygstin').css('border', '1px solid #dedede');
				$('#partygstin').closest(".form-group").find("span").text('');
			}
		if(mailing_address == ''){
				$('#mailing_address').css('border', '1px solid #b94a48');
				$('#mailing_address').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#mailing_address').css('border', '1px solid #dedede');
				$('#mailing_address').closest(".form-group").find("span").text('');
			}
		// if(state == null){
				// $('.state').css('border', '1px solid #b94a48');
				// $('#state1').text('This field is required');
				// var error = 1;
				
			// }else{
				// $('.state').css('border', '1px solid #dedede');
				// $('#state1').text('');
				
			// }
			// if(city_id == null){
				// $('.city_id').css('border', '1px solid #b94a48');
				// $('#city1').text('This field is required');
				// var error = 1;
				
			// }else{
				// $('.city_id').css('border', '1px solid #dedede');
				// $('#city1').text('');
				
			// }
			if(acc_group_id == null){
				$('.acc_group_id').css('border', '1px solid #b94a48');
				$('#acc_grp_id').text('This field is required');
				var error = 1;
				// alert('if');
			}else{
				$('.acc_group_id').css('border', '1px solid #dedede');
				$('#acc_grp_id').text('');
				// alert('else');
			}
		if(compny_branch_id != ''){	
	
			if(compny_branch_id == null || compny_branch_id == ''){
					$('.select_company_branch').css('border', '1px solid #b94a48');
					$('#branch_dd').text('This field is required');
					var error = 1;
					// alert('if');
				}else{
					$('.select_company_branch').css('border', '1px solid #dedede');
					$('#branch_dd').text('');
					// alert('else');
				}			
		}
		if(error == 1) { 
			return false;
		} else {
		$.ajax({
				   type: "POST",
				   url: site_url+'account/add_party_details_during_invoice/',
				   data: {name:partyname,email:partyemail,gstin:partygstin,opening_balance:opening_balance,sale_ledger_data_val:sale_ledger_data_val,country:country,state:state,city_id:city_id,acc_group_id:acc_group_id,mailing_address:mailing_address,compny_branch_id:compny_branch_id}, 
				   success: function(htmlStr) {
					 
				    if(htmlStr == 'true'){
						$('#mssg').html('<span style="color:green;">Added Successfully.</span>');
						$("#insert_party_data_id").trigger('reset');
						setTimeout(function(){
							$('#myModal_Add_party').modal('hide');
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);		
					}else{
						$('#mssg').html('<span style="color:red;">Not Added.</span>');
					}
				}
			 });
		}

});
/* Quick Add voucher */
$(document).on("click","#add_voucher_bbtn",function(){	

	var voucher_name  = $('#voucher_name').val();
	var voucher_desc  = $('#voucher_desc').val();
	
	var error = 0;
		if(voucher_name == ''){
				$('#voucher_name').css('border', '1px solid #b94a48');
				$('#voucher_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#voucher_name').css('border', '1px solid #dedede');
				$('#voucher_name').closest(".form-group").find("span").text('');
			}
		if(voucher_desc == ''){
				$('#voucher_desc').css('border', '1px solid #b94a48');
				$('#voucher_desc').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#voucher_desc').css('border', '1px solid #dedede');
				$('#voucher_desc').closest(".form-group").find("span").text('');
			}
		if(error == 1) { 
			return false;
		} else {
		$.ajax({
				   type: "POST",
				   url: site_url+'account/quick_add_voucher/',
				   data: {voucher_desc:voucher_desc,voucher_name:voucher_name}, 
				   success: function(htmlStr) {
				    if(htmlStr == 'true'){
						$('#mssg_voucher').html('<span style="color:green;">Added Successfully.</span>');
						$("#insert_party_data_id").trigger('reset');
						setTimeout(function(){
							$('#myModal_Add_voucher').modal('hide');
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);		
					}else{
						$('#mssg_voucher').html('<span style="color:red;">Not Added.</span>');
					}
				}
			 });
		}		
});

/* Quick Add voucher */
/*************************************************************************************************************************************************/
/***********************************************************************************************************************************************/
/*******************************************Voucher detail script START HERE ****************************************************************** /
/*************************************************************************************************************************************************/
/**********************************************************************************************************************************************/

//For Open voucher Popup
$(document).on("click",".add_voucher_details_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		// console.log('tabd===>>>>',tab);
		 // console.log('idd===>>>>',id);
		
		switch (tab) {
			case 'voucher_dtl_add':
				url = 'account/editVoucher_detail';
				break;	
			case 'voucher_dtl_view':
				url = 'account/viewVoucher_detail';
				break;
			// case 'voucher_dtl_auto_entery':
				// url = 'account/editVoucher_detail';
				// break;	
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){

				if(data != '') {
					$("#voucher_dtl_add_modal").modal({
						show:false,
						backdrop:'static'
					});
					
					
					$('#voucher_dtl_add_modal').modal('toggle');
					$('#voucher_dtl_add_modal .modal-body-content').html(data);	
					init_select2();
					init_select_ladgers();
					 check_credit_debit_val();
					 add_voucher_credit_debit_details();
					 blank_credit_debit_inputBox();	
					 add_comp_branch_onchnage();
					 add_Party_address_for_voucher();
					 $('#com_state_idds').select2();
					init_select_voucher();				
					 if(tab == 'voucher_dtl_add'){
					   debit_credit_total();
					 }					 
					  var date = new Date();
					  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					  var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
						$('#vocher_crtd_dt').datepicker({
							format: 'dd-mm-yyyy',
							autoclose: true,
							todayHighlight: true,
							changeMonth: true,
							changeYear: true
						});
						$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
							}
					}
				}); 
	});	

function add_comp_branch_onchnage(){
	$('#com_state_idds').on('change', function(){
		var branhidd = $('#com_state_idds option:selected').attr('branh-id');
		$('#com_branch_id').val(branhidd);
		var branch_GST = $('#com_state_idds option:selected').attr('data-gst');
		$('#branch_gst').val(branch_GST);
		
	});
}

function add_Party_address_for_voucher(){
	
	$('#party_Address_voucher').on('change', function(){
		$('#Prty_vochr_address').html('<option selected>Select Address</option>');
		var login_user_idd = $('#company_login_id').val();	
		var selected_id = $(this).val();
	$.ajax({
	   type: "POST",
	   url: site_url+'account/get_ledger_mailing_state/',
	   data: { id:selected_id,login_user:login_user_idd}, 
	   success: function(result) {
		  var obj = jQuery.parseJSON(result);
		 
		  var get_state_id =  jQuery.parseJSON(obj.mailing_address);
		  var len = get_state_id.length;
		//For State in multiple address		
		for(var i=0; i<len; i++){
			
			 var country = get_state_id[i].mailing_country;
			 var state = get_state_id[i].mailing_state;
			 var city = get_state_id[i].mailing_city;
			 var mailing_name = get_state_id[i].mailing_name;
			 var mailing_address1 = get_state_id[i].mailing_address;
			 var mailing_state1 = get_state_id[i].mailing_state;
			 var gstin_no = get_state_id[i].gstin_no;
			 var party_branch_iddd = get_state_id[i].ID;
			
			 var  Dropdn = '<option value="'+ mailing_state1 +'" data-gst="'+ gstin_no +'" branh-id = "' + party_branch_iddd + '">'+ mailing_address1   +'</option>';
			 $("#Prty_vochr_address").append(Dropdn);
			if(mailing_state1 != ''){
				setTimeout(function(){
					$('#Prty_vochr_address option:eq(1)').attr('selected', 'selected');
					   var datagstval = $('#Prty_vochr_address option:selected').attr('data-gst');
						var value_data = $('#Prty_vochr_address option:selected').attr('branh-id');
						
						$('#party_branch_id').val(value_data);
						$('#party_branch_gstno').val(datagstval);
				}, 1000);
			}
		}	
		}
	});
});	
$('#Prty_vochr_address').change(function(){ 	
				var datagstval = $('#Prty_vochr_address option:selected').attr('data-gst');
				var value_data = $('#Prty_vochr_address option:selected').attr('branh-id');
				$('#party_branch_id').val(value_data);
				$('#party_branch_gstno').val(datagstval);
		});	 
}





//check Credit Debit Value is Matched Or not 
function check_credit_debit_val(){
	$('.keyup_check_event').on('keyup', function () {
		var matrial_select_this22 =  $(this);
		 var inputname = $(this).attr('name')
		 if(inputname == 'credit_1[]' || inputname == 'credit_2[]'){		   
			$(matrial_select_this22).closest('.input_descr_wrap').find(".disable_debit").prop("readonly", true);
			$(matrial_select_this22).closest('.input_descr_wrap').find(".disable_debit").val('');
			$(matrial_select_this22).closest('.input_descr_wrap').find('.select_type_d option[value=debit]').removeAttr('selected');
			$(matrial_select_this22).closest('.input_descr_wrap').find('.select_type_d option[value=credit]').attr('selected','selected');
		 }else{
			$(matrial_select_this22).closest('.input_descr_wrap').find(".disable_credit").prop("readonly", true);
			$(matrial_select_this22).closest('.input_descr_wrap').find(".disable_credit").val('');	
			$(matrial_select_this22).closest('.input_descr_wrap').find('.select_type_d option[value=credit]').removeAttr('selected');
			$(matrial_select_this22).closest('.input_descr_wrap').find('.select_type_d option[value=debit]').attr('selected','selected');
			}
		debit_credit_total();
	});

 }
 

//Add Fields For Credit Debit Voucher Details
function add_voucher_credit_debit_details(){
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".add_credit_debit_voucher_details_div"); //Fields wrapper
    var add_button      = $(".add_voucher_credit_detailbutton"); //Add button ID
    var x = 1; //initlal text box count
	var user_id_val = $('#user_id').val();
    $(add_button).click(function(e){ //on add input button click
	    e.preventDefault();
			// var uomsArray = '';
				// $.each( uoms, function( key, value ) {
				// uomsArray = uomsArray+'<option value="'+value+'">'+value+'</option>';
			// });
				
        if(x < max_fields){ //max input box allowed
            x++; 

				$(wrapper).append('<div class="col-md-12 input_descr_wrap add_credit_debit_voucher_details_div scend-tr mailing-box mobile-view" style="padding:0px;"><div class="col-md-12 input_descr_wrap" style="padding:0px;"><div class="col-md-3 col-xs-12 item form-group"><label>Type</label><select name="cr_dr[]" class="form-control col-md-7 col-xs-12 select_type_d"><option value="">Select</option><option value="credit">Credit</option><option value="debit">Debit</option></select></div><div class="col-md-3 col-xs-12 item form-group"><label>Particulars</label><select class="itemName form-control selectAjaxOption select2 dropdown2 add_ladger_button get_party_id get_ladger_value"  required="required" name="credit_debit_party_dtl[]" data-id="ledger" data-key="id" data-where="created_by='+ user_id_val +' or created_by = 0"  data-fieldname="name" width="100%"><option value="">Select</option></select></div><div class="col-md-3 col-xs-12 item form-group"><label>Credit</label><input type="text" name="credit_1[]" value="" class="form-control col-md-7 col-xs-12 keyup_check_event disable_credit" autocomplete="off" ></div><div class="col-md-3 col-xs-12 item form-group"  class="form-control col-md-7 col-xs-12"><label>Debit</label><input style="border-right: 1px solid #c1c1c1;" type="text" name="debit_1[]" class="form-control col-md-7 col-xs-12 keyup_check_event disable_debit" autocomplete="off"></div><button class="btn btn-danger remove_voucher_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
				init_select_ladgers();
				check_credit_debit_val();
				blank_credit_debit_inputBox();
				debit_credit_total();
				$('#su_btn').prop("disabled", true);
				
				
			
        }
    });
    
    $(wrapper).on("click",".remove_voucher_field", function(e){ //user click on remove text
			$('#su_btn').removeAttr('disabled');
			
        e.preventDefault(); $(this).parent('div').remove(); x--;
		debit_credit_total();
    });	
}



//blank inputbox and remove disable
 function blank_credit_debit_inputBox(){
	 $('.select_type_d').on('change', function () {
		var matrial_select_this22 =  $(this);
		 $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_debit").removeAttr('readonly');
		 $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_debit").val('');
		 $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_credit").removeAttr('readonly');
		 $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_credit").val('');
		 var selected_val = $(this).val();
		if(selected_val == 'credit'){
			 $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_debit").prop("readonly", true);
			 $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_credit").val('');
			 $('#credit_ya_debit').val('0');
		 }else{
			 $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_credit").prop("readonly", true);
			  $(matrial_select_this22).closest('.input_descr_wrap').find(".disable_debit").val('');
			  $('#credit_ya_debit').val('1');
		 }
	});	 
 }
 



//Add Ladgers When not found in List
function init_select_ladgers() {
    $('.add_ladger_button').select2({		
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: 'Select And Begin Typing',
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2search',
			dataType: 'json',
			delay: 250,
			data: function (params) {
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },		  
        processResults: function (data) {
            return {
              results: data
            };
        },
			cache: true,
         },language: {
			noResults: function() {
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				var searched_value =  $('.select2-search__field').val();
				$('#fetch_pname').val(searched_value);
				var lb_ID = $('#fetch_pname').val();
				$('.party_namee').val(lb_ID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_ladgers_data'>Add </span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
    });
	
}


//For adding More Parties using Model

$(document).on("click",".add_ladgers_data",function(){	
	 $('#myModal_Add_party').modal('show');
});
//To close Add PArty Popup Model
$(document).on("click",".close_sec_model",function(){
	 $('#myModal_Add_party').modal('hide');
});


//For Save Ladger data with validation


//Debit Credit Total Scripts
function debit_credit_total() {
	
	var credit_sum = 0;
    $("input[name='credit_1[]']").each(function() {
        credit_sum += Number($(this).val());
    });
	$("#credit_total").val(credit_sum);	
	var debit_sum = 0;
    $("input[name='debit_1[]']").each(function() {
        debit_sum += Number($(this).val());
    });
	$("#debit_total").val(debit_sum);	
	var credit_total = $("#credit_total").val();
	var debit_total = $("#debit_total").val();
	
	if(credit_total == debit_total && credit_total != 0 && debit_total != 0  && $.isNumeric(debit_total) && $.isNumeric(credit_total)){
		$('#su_btn').removeAttr('disabled');
	}else{
	 $('#su_btn').prop("disabled", true);
	}
}
 
/*********************************************************************************************************************************/
/****************************************************************************************************************************************/
/****************************************  PAYMENT RECEIPT SCRIPT START HERE *****************************************************/
/********************************************************************************************************************************/
/***************************************************************************************************************************/
$(document).on("click",".add_payment_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		// console.log('tabd===>>>>',tab);
		// console.log('idd===>>>>',id);
		//alert(tab);
		switch (tab) {
			case 'payment':
				url = 'account/editrecvpayment_detail';
				break;	
			case 'payment_view':
				url = 'account/viewrecvpayment_detail';
				break;					
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#payment_add_detail_modal").modal({
						show:false,
						backdrop:'static'
					});
					$('#payment_add_detail_modal').modal('toggle');
					$('#payment_add_detail_modal .modal-body-content').html(data);	
						init_select2();
						close_modal_Script();
						get_invoices_according_to_party();
						//add_advanced_balance();
						add_amount_on_keyup();
						amount_input_keyup();
						//$('#Party_address').select2();
						 	
						if(tab == 'payment' ){
						
						setTimeout(function(){	
								$('.addd_amount').keyup();
							
							}, 2000);  
						$('input:checkbox').attr('checked', 'checked');	
						}		
					  // var date = new Date();
					  // var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					  // var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					  
						//Date Format Change Script	
							$('#payment_date').datepicker({
								format: 'dd-mm-yyyy',
								autoclose: true,
								todayHighlight: true,
								changeMonth: true,
								changeYear: true
							});
							
							//Date Format Change Script			
						$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
							}
					}
				}); 
	});	

//Get Invoices according to ladgers

function get_invoices_according_to_party(){ 
		$('.invoice_detail').change(function(){ 
		$(".app_div").html('');		
		 var matrial_select_this2 =  $(this);
			var selected_id = $(this).val();
		
		$.ajax({
				   type: "POST",
				   url: site_url+'account/get_not_paid_invoices/',
				   data: { party_id:selected_id}, 
				   success: function(htmlStr) {
					  
					var  obj = JSON.parse(htmlStr);
					var len = obj.length;
				
					if(len == 0 ){
						$(".msg_sho").html('');
						$(".msg_sho").show();
						$('.invoice_div').fadeIn();
						$('.amount_disp').fadeIn();
						$('input:checkbox').attr('checked', false);
						$(".app_div").html('');
						$(".Add_advance_payment").val('');
							$(".msg_sho").append('<p> No Invoice Available.</p>');
							setTimeout(function(){	
								$(".add_adv_blance").css('display','none');
							}, 1000);
							$(".goods_descr_wrapper").hide();

							$(".Add_advance_payment").on('keyup', function (){
								
									var addvance_payment = $(this).val();
									
								   // $('.credit_amount').val(addvance_payment);//During Advanced Payment Add Its to Credit Amount
							  
							});
						return false;
					}else{
						$(".goods_descr_wrapper").show();
						$(".msg_sho").hide();
							for(var i=0; i<len; i++){					
								var id = obj[i].id;
								var party_id = obj[i].party_name;
								var email1 = obj[i].email;
								
								var terms_of_delivery = obj[i].terms_of_delivery;
								var charges_total_tax_with_amt  = obj[i].charges_total_tax;
								//var total_amount = obj[i].total_amount;
								var total_amount = parseFloat(obj[i].total_amount) + parseFloat(charges_total_tax_with_amt);
								var total_amount1 = total_amount.toFixed(2);
								//alert(total_amount1);
								var date_time_of_invoice_issue = obj[i].date_time_of_invoice_issue;
								var account_group_id = obj[i].account_group_id;
								//var mode_of_payment = obj[i].mode_of_payment;
								
								var totaltax_total = obj[i].totaltax_total;
								
								
								//$('#drop_down_payment_method').val(mode_of_payment);
								
								$('#email_idd').val(email1);
								var str_Dta = '<div class="col-md-12 input_descr_wrap mailing-box mobile-view"><input class="checkbox check_class" type="hidden" name="select_Dataw" id="'+id+'"><input class="invoic_cls" type="hidden" name="invoice_id[]" value="'+id+'"><input type="hidden" value="'+account_group_id +'" name="account_group_id"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label for="descriptions">Description</label><input type="text" name="description[]" class="form-control col-md-1" placeholder="" value="Invoice # ' + id +'" readonly></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label  for="due_Date">Due Date</label><input type="text" name="due_date[]" class="form-control col-md-1" placeholder="" value="'+ date_time_of_invoice_issue +'" readonly></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label for="open_amount">Open Amount</label><div class="input-group"><input class="invoic_cls" type="hidden" name="invoice_id_foradd" value="'+id+'"><input type="text" name="open_balance[]" class="form-control col-md-1 checkindex_'+ i +'" placeholder="" value="'+ total_amount1 +'" readonly></div></div><div class="col-md-3 col-sm-12 col-xs-12 form-group checktr"><label  for="payment_amount" ">Payment</label><div class="input-group"><input type="hidden" name="total_tax[]" class="form-control col-md-1" placeholder="" value="'+ totaltax_total +'" ><input type="text" name="payment_amount[]" class="form-control col-md-1 chg_amt" placeholder="" value="'+ total_amount1 +'" ><input type="hidden" value="" class="add_index_'+ i +'"> </div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>';
								$(".app_div").append(str_Dta);
								
								$('.invoice_div').fadeIn();
								$('.amount_disp').fadeIn();
								
								//$(".added_amount").prop("readonly", true);
								
								
								
								amount_input_keyup();
								$('.input_descr_wrap').on("click",".remove_descr_field", function(e){ //user click on remove text
								
									setTimeout(function(){		
										var total_Amount_ttl = 0;
										$("input[name='payment_amount[]']").each(function() {
											total_Amount_ttl += Number($(this).val());
										});
										$("#ttl_amt").val(total_Amount_ttl.toFixed(2));
										$('.total_amount_id_recipt').val(total_Amount_ttl.toFixed(2));
									    $('#ttl_amt').keyup();
										var ttl_amnt = $("#ttl_amt").val();
											if(ttl_amnt == '' || ttl_amnt == 0){
												$('.add_recive_payment').attr('disabled','disabled');
											}
								
									}, 1000);
										
							
									e.preventDefault(); 
									$(this).parent('div').remove();
									x--;
									
								});
								
							setTimeout(function(){		
								var total_Amount_ttl = 0;
								$("input[name='payment_amount[]']").each(function() {
									total_Amount_ttl += Number($(this).val());
								});
								$("#ttl_amt").val(total_Amount_ttl.toFixed(2));
								$("#invoice_count_val").val(len);
								//$("#ttl_amt").trigger("click");
								 $('#ttl_amt').keyup();
					
								$('.total_amount_id_recipt').val(total_Amount_ttl.toFixed(2));
								 $('.credit_amount').val('0.00');
								 
								 
								 
							}, 1000);
						}

					 
				}	
			}
		});
	/* Code for Get Balance */
	
					 // var selected_id3 = $(this).val();
					
						// $.ajax({
						   // type: "POST",
						   // url: site_url+'account/get_seleceted_user_balance/',
						   // data: { party_id:selected_id3}, 
						   // success: function(balancee) {
							   // if(balancee != 0){
								 
								   // $(".goods_descr_wrapper").show();
								  
								// var Add_detail_balance = '<b>Previous Balance Total Rs : </b> <input type="text" value="'+ balancee +' "class="add_in_invoice_total" readonly style="border: transparent;"> <span class="add_adv_blance"> Add </span>';
								// $(".blnc").append(Add_detail_balance);
							   // }
							   
						   // } 
					 
					// }); 


    /* Code for Get Balance */ 
	
	$('#Party_address').html('<option selected>Select Address</option>');
	var login_user_idd = $('#user_id').val();	
	$.ajax({
					   type: "POST",
					   url: site_url+'account/get_ledger_mailing_state/',
					   data: { id:selected_id,login_user:login_user_idd}, 
					   success: function(result) {
						  var obj = jQuery.parseJSON(result);
						 
						  var get_state_id =  jQuery.parseJSON(obj.mailing_address);
						  var len = get_state_id.length;
						//For State in multiple address		
						for(var i=0; i<len; i++){
							
							 var country = get_state_id[i].mailing_country;
							 var state = get_state_id[i].mailing_state;
							 var city = get_state_id[i].mailing_city;
							 var mailing_name = get_state_id[i].mailing_name;
							 var mailing_address1 = get_state_id[i].mailing_address;
							 var mailing_state1 = get_state_id[i].mailing_state;
							 var gstin_no = get_state_id[i].gstin_no;
							 var party_branch_iddd = get_state_id[i].ID;
							
							 var  Dropdn = '<option value="'+ mailing_state1 +'" data-gst="'+ gstin_no +'" branh-id = "' + party_branch_iddd + '">'+ mailing_address1   +'</option>';
							 $("#Party_address").append(Dropdn);
							if(mailing_state1 != ''){
								setTimeout(function(){
									$('#Party_address option:eq(1)').attr('selected', 'selected');
									   var datagstval = $('#Party_address option:selected').attr('data-gst');
										var value_data = $('#Party_address option:selected').attr('branh-id');
										
										$('#party_branch_id').val(value_data);
										$('#party_branch_gstno').val(datagstval);
								}, 1000);
							}
					}	
				}
			 });	
		});
			$('#Party_address').change(function(){ 	
				var datagstval = $('#Party_address option:selected').attr('data-gst');
				var value_data = $('#Party_address option:selected').attr('branh-id');
				$('#party_branch_id').val(value_data);
				$('#party_branch_gstno').val(datagstval);
		});	 
		
		
		$('#comp_address').change(function(){ 	
				var datagstval = $('#comp_address option:selected').attr('data-gst');
				var value_data = $('#comp_address option:selected').attr('branh-id');
				$('#comp_branch_id').val(value_data);
				$('#comp_brnch_gstno').val(datagstval);
		});	
		
		
		
		
		
		
		
		
		
		
		
}

// function add_advanced_balance(){
		// $(document).on("click",".add_adv_blance",function(){
			// var Advanced_balance = $('.add_in_invoice_total').val();
				// $('#ttl_amt').val(Advanced_balance);
				// $('.amount_applyd').val(Advanced_balance);
				
				// setTimeout(function(){	
				 // $('.addd_amount').keyup();
					// $('.add_adv_blance').attr('disabled','disabled');
					// var advanc_amt = $('.credit_amount').val();
					// if(advanc_amt != ''){
						//
						// $('#add_vals').attr('data-balac-amt', advanc_amt);
					// }
					
					
				// }, 1000);
			// });

// }


 function get_supplier_address_in_purchase_bill(){
	 $('.add_supplier_detials').change(function(){ 
	 $('#supp_address').html('<option selected>Select Address</option>');		
		$(".app_div").html('');		
		var matrial_select_this2 =  $(this);
		var selected_id = $(this).val();
		$.ajax({
				   type: "POST",
				   url: site_url+'account/get_supplier_details/',
				   data: { party_id:selected_id}, 
				   success: function(htmlStr) {
					var  obj = JSON.parse(htmlStr);
					 var get_state_id =  jQuery.parseJSON(obj.mailing_address);
					  var len = get_state_id.length;
					//For State in multiple address		
					for(var i=0; i<len; i++){
						 var country = get_state_id[i].mailing_country;
						 var state = get_state_id[i].mailing_state;
						 var city = get_state_id[i].mailing_city;
						 var mailing_name = get_state_id[i].mailing_name;
						 var mailing_address1 = get_state_id[i].mailing_address;
						 var mailing_state1 = get_state_id[i].mailing_state;
						 var gstin_no = get_state_id[i].gstin_no;
						 $('#gstin_id').val(gstin_no); 
						 $('#sale_company_state_id').val(mailing_state1);
							
						var  Dropdn_supp = '<option value="'+ mailing_state1 +'" data-gst="'+ gstin_no +'">'+ mailing_address1   +'</option>';
							 $("#supp_address").append(Dropdn_supp);
							 if(mailing_state1 != ''){
							 setTimeout(function(){
								$('#supp_address option:eq(1)').attr('selected', 'selected');
							}, 1000);
							
							 setTimeout(function(){
								var datagstval = $('#supp_address option:selected').attr('data-gst');
								var value_data = $('#supp_address option:selected').val();
								$('#party_billing_state_id').val(value_data);
								$('#gstin_id').val(datagstval);
							}, 1500);
						}
					}
					$('#p_email').val(obj.email); 
					
				}
			 });
			/* This Code is used for Invoice Edit Time*/
					var party_billing_state = $('#party_billing_state_id').val();
					 var sale_company_state_idd = $('#sale_company_state_id').val();
					 if(party_billing_state != sale_company_state_idd){
							 $('.cgst').hide();
							 $('.sgst').hide();
							 $('.igst').show();
						 }else{
							  $('.cgst').show();
							  $('.sgst').show();
							  $('.igst').hide();
						 }
				/* This Code is used for Invoice Edit Time*/ 
			 
			 
			 
		}); 
		
		
		
	 $('#supp_address').change(function(){
		 	var datagstval = $('#supp_address option:selected').attr('data-gst');
			var value_data = $('#supp_address option:selected').val();
			$('#party_billing_state_id').val(value_data);
			$('#gstin_id').val(datagstval);
		 
	 });	
		
		
		
		
		
		
		
		
		
		
		
		
		
	 
 }
 
 





function amount_input_keyup(){

	  $(".chg_amt").on('keyup', function () {
		setTimeout(function(){
			var orgi_nal_amount = 0;
			$("input[name='open_balance[]']").each(function() {
				orgi_nal_amount += Number($(this).val());
			}); 			
			var payable_amount = 0;
			$("input[name='payment_amount[]']").each(function() {
				payable_amount += Number($(this).val());
			});    
			
			$('#ttl_amt').val(payable_amount);
			
			$('.total_amount_id_recipt').val(orgi_nal_amount);			
			
			$('.amount_applyd').val(payable_amount);
			
			 if(payable_amount < orgi_nal_amount ){
				  var after_calculate = orgi_nal_amount - payable_amount ;			 
					after_calculate = Math.abs(after_calculate);
				$('.credit_amount').val('0.00');
				$('.minus_balance_id').val(after_calculate);
			 }else{
				  var after_calculate = orgi_nal_amount - payable_amount ;			 
			          after_calculate = Math.abs(after_calculate);
				 $('.credit_amount').val(after_calculate);
				 $('.minus_balance_id').val('0.00');
				}
       }, 1000);	
    }); 

}

function add_amount_on_keyup(){
	
	$('.addd_amount').on('keyup keypress', function (event) {
		
		$('.minus_balance_id').val('');
		 $('.credit_amount').val('');
			
			var added_amt_len = $(this).val().length;
			//if(added_amt_len >= 3){
			
			var added_amount_chk = $('.addd_amount').val();
			var original_amount1 = $('.total_amount_id_recipt').val();
			
			 $('.amount_applyd').val(added_amount_chk);
			 
			 var after_calculate = added_amount_chk - original_amount1;
			    after_calculate1 = Math.abs(after_calculate);
			
			if(parseFloat(added_amount_chk) < parseFloat(original_amount1) ){	  
				$('.credit_amount').val('0.00');
				$('.minus_balance_id').val(after_calculate1);
			 }else {
				 $('.credit_amount').val(after_calculate1);
				 $('.minus_balance_id').val('0.00');
			}
			var Total_tax_All = 0;
			$("input[name='total_tax[]']").each(function() {
				Total_tax_All += Number($(this).val());
			}); 
				$('.total_tax_cls').val(Total_tax_All);	
	
		
		
			setTimeout(function(){	
					var invoice_len = $('#invoice_count_val').val();
				
				if(added_amount_chk < original_amount1 ){		
						
						 for(var i=0; i<invoice_len; i++){
							if(i==0){
								
								var after_minus_total_blnc = 0;
									var open_balancec_amount = $(".checkindex_"+ i ).val();
									var aftercalulation_balance = [];
									aftercalulation_balance[i] = added_amount_chk - open_balancec_amount;
									
									if((aftercalulation_balance[i] < 0) && (added_amount_chk <  open_balancec_amount)){
										console.log('IF newww =>', added_amount_chk);
										aftrtclc = Math.abs( added_amount_chk);
										$(".add_index_"+ i ).siblings('.chg_amt').val(aftrtclc.toFixed(2));
										return false;
									}
									else if((aftercalulation_balance[i] > 0)){
										var open_balancec_amount = $(".checkindex_"+ i ).val();
										$(".add_index_"+ i ).siblings('.chg_amt').val(open_balancec_amount);
										//return false;
									}  
									$(".add_index_"+ i ).val(aftercalulation_balance[i]);
									
							}else{
									
									aftercalulation_balance[i] = aftercalulation_balance[i-1] - $(".checkindex_"+ i ).val();
									if((aftercalulation_balance[i] > 0) && (added_amount_chk > open_balancec_amount)){
										console.log('IF ddsa =>', aftercalulation_balance[i]);
										$(".add_index_"+ i ).siblings('.chg_amt').val(aftercalulation_balance[i].toFixed(2));
										return false;
									}
									else if((aftercalulation_balance[i] > 0)){
										var open_balancec_amount = $(".checkindex_"+ i ).val();
										$(".add_index_"+ i ).siblings('.chg_amt').val(open_balancec_amount);
										//return false;
									} 
									
									if((aftercalulation_balance[i] < 0 ) &&  (i+1 == invoice_len)  ){
										console.log('There -->',aftercalulation_balance[i-1]);
										AfterCLC_data = Math.abs(aftercalulation_balance[i-1]);
										$(".add_index_"+ i ).siblings('.chg_amt').val(AfterCLC_data.toFixed(2));
										//siblings   closest
									}else{
										$(".add_index_"+ i ).val(aftercalulation_balance[i]);
									}
									
							}
						
				}
		}
		
		else if(added_amount_chk > original_amount1 ){	//this condition is Run when Added Amount is Greater then open amount
			 for(var i=0; i<invoice_len; i++){
							if(i==0){
								var after_minus_total_blnc = 0;
									var open_balancec_amount = $(".checkindex_"+ i ).val();
									var aftercalulation_balance = [];
									aftercalulation_balance[i] = added_amount_chk - open_balancec_amount;
									
									$(".add_index_"+ i ).val(aftercalulation_balance[i]);
									
							}else{
									aftercalulation_balance[i] = aftercalulation_balance[i-1] - $(".checkindex_"+ i ).val();
								
									if((aftercalulation_balance[i] > 0 ) &&  (i+1 == invoice_len)  ){
										
										var lstval = $(".checkindex_"+ i ).val();;
										
										console.log('ddd', lstval);
										$(".add_index_"+ i ).siblings('.chg_amt').val(lstval);
										
									}
									else{
										$(".add_index_"+ i ).val(aftercalulation_balance[i]);
									}
									
							}		
			 }
		}		
				
			}, 1000);		
		//}	
	});
	

 } 

/****************************************************************************************************************************************/
/********************************************************************************************************************************/
/**************************************************  PAYMENT To SCRIPT START HERE  ************************************************/
/***********************************************************************************************************************************/
/***************************************************************************************************************************/
$(document).on("click",".add_payment_to_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		// console.log('tabd===>>>>',tab);
		// console.log('idd===>>>>',id);
		//alert(tab);  
		switch (tab) {
			case 'payment_to':
				url = 'account/editpayment_to_detail';
				break;	
			case 'payment_to_view':
				url = 'account/viewpayment_to_detail';
				break;					
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#payment_to_add_detail_modal").modal({
						show:false,
						backdrop:'static'
					});
					$('#payment_to_add_detail_modal').modal('toggle');
					$('#payment_to_add_detail_modal .modal-body-content').html(data);	
						init_select2();
						get_not_paid_bills();
						 close_modal_Script();
						//add_payment_amount_on_keyup();
						change_payment_to_acc_automatic();
						change_payment_to_amount_textbox();
						
						if(tab == 'payment_to'){
								setTimeout(function(){	
									$('.addd_payment_amount').keyup();
								}, 2000);  								
						}
						
						
							//Date Format Change Script	
							$('#payment_date').datepicker({
								format: 'dd-mm-yyyy',
								autoclose: true,
								todayHighlight: true,
								changeMonth: true,
								changeYear: true
							});
							//Date Format Change Script		  
													  
						//$('#payment_date').datepicker('setDate', today);
						
						$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
							}
					}
				}); 
	});

function get_not_paid_bills(){ 
		$('.get_not_paid_purchase_bills').change(function(){ 
		 var matrial_select_this2 =  $(this);
		
			var selected_id = $(this).val();
			//alert(selected_id);
			$.ajax({
				   type: "POST",
				   url: site_url+'account/get_not_paid_bills/',
				   data: { supplier_name:selected_id}, 
				   success: function(htmlStr) {
					
					var obj = jQuery.parseJSON(htmlStr);
					
					var len = obj.length;
					if(len == 0 ){
						$('.bills_div').fadeIn();
						$('.bills_div_header').hide();
						
						//$('.bills_div_header').fadeIn();
						//$('input:checkbox').attr('checked', false);
						$(".bills_div").html('');
						$(".msg_sho_payment_to").html('');
						$(".msg_sho_payment_to").append('<p> No Bills Available.</p>');
							$("#ttl_amt_payment_to").on('keyup', function (){
								var addvance_payment = $(this).val();
								    $('.payment_to_amount_applyd').val(addvance_payment);//During Advanced Payment Add Its to Credit Amount
								    $('.credit_payment_amount').val(addvance_payment);//During Advanced Payment Add Its to Credit Amount
							});
						return false;
					}
						$(".bills_div").html('');
						$(".msg_sho_payment_to").html('');
					for(var i=0; i<len; i++){ 
					
						var id = obj[i].id;
						
						var product_details = obj[i].product_detail;
						var charges_total_tax_with_amt  = obj[i].charges_total_tax;
						
						var grand_total = obj[i].grand_total;
								var grand_total = parseFloat(obj[i].grand_total) + parseFloat(charges_total_tax_with_amt);
						 var grand_total1 = grand_total.toFixed(2);
						var supp_email = obj[i].p_email;
						
						var from_pi = obj[i].throu_pi_or_not;
						var order_code = obj[i].order_code;//For check data from Purchase_order table	
					 	
							if(order_code != null && order_code == 'undefined' ){
								//var grand_total = obj[i].grand_total;
								var grand_total = parseFloat(obj[i].grand_total) + parseFloat(charges_total_tax_with_amt);
								 var grand_total1 = grand_total.toFixed(2);
								var product_details = 'From Purchase Order';
							}else{
								//var grand_total = obj[i].grand_total;
								var grand_total = parseFloat(obj[i].grand_total) + parseFloat(charges_total_tax_with_amt);
						         var grand_total1 = grand_total.toFixed(2);
								var product_details = 'From Purchase Bill';
							}
									
						 var date3 = obj[i].date;
						// var date11 = new Date(date3);
						// var newDate = date11.toString('dd-MM-yyyy');
						var str_Dta = '<div class="col-md-12 input_descr_wrap"><input class="checkbox payment_to_check_class" type="hidden" name="payment_to_checkbox" id="'+id+'"><input class="invoic_cls" type="hidden" name="bill_id[]" value="'+id+'"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" class="form-control col-md-1" name="from_detail[]" value="'+ product_details +'" readonly></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="description[]" class="form-control col-md-1" placeholder="" value="Bill No. # ' + id +'" readonly></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="date[]" class="form-control col-md-1" placeholder="" value="'+ date3 +'" readonly></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><div><input class="invoic_cls" type="hidden" name="invoice_id_foradd" value="'+id+'"><input type="text" name="open_balance[]" class="form-control col-md-1 payment_open_balance checkindexP_'+ i +'" placeholder="" value="'+ grand_total1 +'" readonly></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group checktr"><div><input type="text" name="payment_amount[]" class="form-control col-md-1 change_payment_to_amount" placeholder="" value="'+ grand_total1 +'" ><input type="hidden" value="" class="add_indexP_'+ i +'"><input type="hidden" value="'+ order_code +'" name="order_code[]"><input type="hidden" value="'+ from_pi +'" name="throu_pi_or_not"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>';
						$(".bills_div").append(str_Dta);
						$('.bills_div_header').show();
						$('.bill_amount_disp').show();
						//$('.addd_payment_amount').removeAttr('readonly');
						//$('input:checkbox').attr('checked', 'checked');	
						change_payment_to_amount_textbox();
						change_payment_to_acc_automatic();
						//add_payment_amount_on_keyup();
						checkboxischeckd_on_payment_to();
						//$(".addd_payment_amount").prop("readonly", true);
						$('.input_descr_wrap').on("click",".remove_descr_field", function(e){ //user click on remove text
							setTimeout(function(){		
								var total_Amount_ttl = 0;
								$("input[name='payment_amount[]']").each(function() {
									total_Amount_ttl += Number($(this).val());
								});
								$("#ttl_amt_payment_to").val(total_Amount_ttl);
								$(".payment_to_amount_applyd").val(total_Amount_ttl);
								$('.total_amount_id_payment_to').val(total_Amount_ttl);
							    $('#ttl_amt_payment_to').keyup();
								var ttl_amnt = $("#ttl_amt_payment_to").val();
									if(ttl_amnt == '' || ttl_amnt == 0){
										$('.add_payment_to').attr('disabled','disabled');
									}
							}, 1000);
							e.preventDefault(); 
							$(this).parent('div').remove();
							x--;
						});
						setTimeout(function(){		
								var total_Amount_ttl = 0;
								$("input[name='payment_amount[]']").each(function() {
									total_Amount_ttl += Number($(this).val());
								});
								$("#ttl_amt_payment_to").val(total_Amount_ttl);
								$(".payment_to_amount_applyd").val(total_Amount_ttl);
								$('#ttl_amt_payment_to').keyup();
								$('#email_idd').val(supp_email);
								$("#purchase_bill_count_val").val(len);
								$('.total_amount_id_payment_to').val(total_Amount_ttl);
								$('.credit_payment_amount').val('');
							}, 1000);
											
					}					
				 }
			 });
			 
			 
			 $('#Party_address').html('<option selected>Select Address</option>');
				var login_user_idd = $('#user_id').val();	
				$.ajax({
								   type: "POST",
								   url: site_url+'account/get_ledger_mailing_state/',
								   data: { id:selected_id,login_user:login_user_idd}, 
								   success: function(result) {
									  var obj = jQuery.parseJSON(result);
									 
									  var get_state_id =  jQuery.parseJSON(obj.mailing_address);
									  var len = get_state_id.length;
									//For State in multiple address		
									for(var i=0; i<len; i++){
										
										 var country = get_state_id[i].mailing_country;
										 var state = get_state_id[i].mailing_state;
										 var city = get_state_id[i].mailing_city;
										 var mailing_name = get_state_id[i].mailing_name;
										 var mailing_address1 = get_state_id[i].mailing_address;
										 var mailing_state1 = get_state_id[i].mailing_state;
										 var gstin_no = get_state_id[i].gstin_no;
										 var party_branch_iddd = get_state_id[i].ID;
										
										 var  Dropdn = '<option value="'+ mailing_state1 +'" data-gst="'+ gstin_no +'" branh-id = "' + party_branch_iddd + '">'+ mailing_address1   +'</option>';
										 $("#Party_address").append(Dropdn);
										if(mailing_state1 != ''){
											setTimeout(function(){
												$('#Party_address option:eq(1)').attr('selected', 'selected');
												   var datagstval = $('#Party_address option:selected').attr('data-gst');
													var value_data = $('#Party_address option:selected').attr('branh-id');
													
													$('#party_branch_id').val(value_data);
													$('#party_branch_gstno').val(datagstval);
											}, 1000);
										}
								}	
							}
						 });
			}); 
		
		$('#Party_address').change(function(){ 	
				var datagstval = $('#Party_address option:selected').attr('data-gst');
				var value_data = $('#Party_address option:selected').attr('branh-id');
				$('#party_branch_id').val(value_data);
				$('#party_branch_gstno').val(datagstval);
		});	 
		
		
		$('#comp_address').change(function(){ 	
				var datagstval = $('#comp_address option:selected').attr('data-gst');
				var value_data = $('#comp_address option:selected').attr('branh-id');
				$('#comp_branch_id').val(value_data);
				$('#comp_brnch_gstno').val(datagstval);
		});	
	}




function change_payment_to_amount_textbox(){
	$(".change_payment_to_amount").on('keyup keypress', function () {
		var original_openBalance1 = 0;
			$("input[name='open_balance[]']").each(function() {
				original_openBalance1 += Number($(this).val());
			}); 
		
			$('.total_amount_id').val(original_openBalance1);
			
		var payment_amount1 = 0;
			$("input[name='payment_amount[]']").each(function() {
				payment_amount1 += Number($(this).val());
			}); 
		var added_payment_amount_val = $(".addd_payment_amount").val();	
		var Total_amount_there2 =   payment_amount1 - original_openBalance1;
			$('.credit_payment_amount').val(Total_amount_there2);
		if(original_openBalance1 > payment_amount1 ){
				$('.credit_payment_amount').val('0.00');
				$('.minus_balance_id_payment_to').val(Total_amount_there2);
			 }else{
				 $('.credit_payment_amount').val(Total_amount_there2);
				 $('.minus_balance_id_payment_to').val('0.00');
				}
				 $('#ttl_amt_payment_to').val(payment_amount1);
				 $('.payment_to_amount_applyd').val(payment_amount1);		
		});
}

//Code For Add Automatic Payment through Added Amount
function change_payment_to_acc_automatic(){
$('.addd_payment_amount').on('keyup keypress', function (event) {

		var added_amt_len = $(this).val().length;
			$('.minus_balance_id_payment_to').val('');
			$('.credit_payment_amount').val('');
		
		var added_amount_chk = $('.addd_payment_amount').val();
		
		var original_amount1 = $('.total_amount_id_payment_to').val();
			$('.payment_to_amount_applyd').val(added_amount_chk);
			$('.amount_applyd').val(added_amount_chk);
			var after_calculate = added_amount_chk - original_amount1;
			    after_calculate1 = Math.abs(after_calculate);
				
			
			//setTimeout(function(){ 
			 if(parseFloat(added_amount_chk) < parseFloat(original_amount1) ){ 				
				$('.credit_payment_amount').val('0.00');
				$('.minus_balance_id_payment_to').val(after_calculate1);
				
			 }else{
				 $('.credit_payment_amount').val(after_calculate1);
				 $('.minus_balance_id_payment_to').val('0.00');
				}
			//}, 1000);	
				
			var Total_tax_All = 0;
			$("input[name='total_tax[]']").each(function() {
				Total_tax_All += Number($(this).val());
			}); 
				$('.total_tax_cls').val(Total_tax_All);	
		
		
			setTimeout(function(){	
					var invoice_len = $('#purchase_bill_count_val').val();	
					//alert(invoice_len);
				if(added_amount_chk < original_amount1 ){		
						
						 for(var i=0; i<invoice_len; i++){
							if(i==0){
								
								var after_minus_total_blnc = 0;
									var open_balancec_amount = $(".checkindexP_"+ i ).val();
									//alert(open_balancec_amount);
									var aftercalulation_balance = [];
									aftercalulation_balance[i] = added_amount_chk - open_balancec_amount;
									
									if((aftercalulation_balance[i] < 0) && (added_amount_chk <  open_balancec_amount)){
										console.log('IF ddsa =>', aftercalulation_balance[i]);
										after_calculate12 = Math.abs(added_amount_chk);
										$(".add_indexP_"+ i ).siblings('.change_payment_to_amount').val(after_calculate12.toFixed(2));
										return false;
									}
									else if((aftercalulation_balance[i] > 0)){
										
										var open_balancec_amount = $(".checkindexP_"+ i ).val();
										console.log('IF > 0 =>', aftercalulation_balance[i]);
										$(".add_indexP_"+ i ).siblings('.change_payment_to_amount').val(open_balancec_amount);
										
									}  
									$(".add_indexP_"+ i ).val(aftercalulation_balance[i]);
									
							}else{
									
									aftercalulation_balance[i] = aftercalulation_balance[i-1] - $(".checkindexP_"+ i ).val();
									
									if((aftercalulation_balance[i] > 0) && (added_amount_chk >  open_balancec_amount)){
									
										after_calculate12 = Math.abs(added_amount_chk);
										$(".add_indexP_"+ i ).siblings('.change_payment_to_amount').val(after_calculate12.toFixed(2));
										return false;
									}
									else if((aftercalulation_balance[i] > 0)){
										
										var open_balancec_amount = $(".checkindexP_"+ i ).val();
										console.log('IF > 0 =>', aftercalulation_balance[i]);
										$(".add_indexP_"+ i ).siblings('.change_payment_to_amount').val(open_balancec_amount);
										
									}  
									
									if((aftercalulation_balance[i] < 0 ) &&  (i+1 == invoice_len)  ){
										console.log('There -->',aftercalulation_balance[i-1]);
										//	$(".add_index_"+ i ).val(aftercalulation_balance[i-1]);
										$(".add_indexP_"+ i ).siblings('.change_payment_to_amount').val(aftercalulation_balance[i-1]);
										//siblings   closest
									}
									else{
										$(".add_indexP_"+ i ).val(aftercalulation_balance[i]);
									}
									
							}
						
				}
		}
		
		else if(added_amount_chk > original_amount1 ){	//this condition is Run when Added Amount is Greater then open amount
			 for(var i=0; i<invoice_len; i++){
							if(i==0){
								var after_minus_total_blnc = 0;
									var open_balancec_amount = $(".checkindexP_"+ i ).val();
									var aftercalulation_balance = [];
									aftercalulation_balance[i] = added_amount_chk - open_balancec_amount;
									
									$(".add_indexP_"+ i ).val(aftercalulation_balance[i]);
									
							}else{
									aftercalulation_balance[i] = aftercalulation_balance[i-1] - $(".checkindexP_"+ i ).val();
								
									if((aftercalulation_balance[i] > 0 ) &&  (i+1 == invoice_len)  ){
										
										var lstval = $(".checkindexP_"+ i ).val();;
										
										console.log('ddd', lstval);
										$(".add_indexP_"+ i ).siblings('.change_payment_to_amount').val(lstval);
										
									}
									else{
										$(".add_indexP_"+ i ).val(aftercalulation_balance[i]);
									}
									
							}		
			 }
		}		
				
			}, 1000);		 
		//}	
	});

//Code For Add Automatic Payment through Added Amount

}



 function checkboxischeckd_on_payment_to(){
      $(".payment_to_check_class").on("click", function () {
		$('.addd_payment_amount').val('');
		  $('.payment_to_amount_applyd').val('');
		  $('.credit_payment_amount').val('');
			 if($(this).prop("checked") == true){
				var checkd_id = $(this).attr('id');
				var matrial_select_this221 =  $(this);
				var balance = $(matrial_select_this221).closest('.input_descr_wrap').find("input[name='open_balance[]']").val();
				$(matrial_select_this221).closest('.input_descr_wrap').find("input[name='payment_amount[]']").val(balance);
				var add_invoice_id_forDB = $(matrial_select_this221).closest('.input_descr_wrap').find("input[name='invoice_id_foradd']").val();
				$(matrial_select_this221).closest('.input_descr_wrap').find("input[name='invoice_id[]']").val(add_invoice_id_forDB);
				
				
			 }else if($(this).prop("checked") == false){
				$(".payment_to_check_class:checkbox:not(:checked)").each(function () {
				var uncheckd_id = $(this).attr('id');
				var matrial_select_this221 =  $(this);
				$(matrial_select_this221).closest('.input_descr_wrap').find("input[name='payment_amount[]']").val('');
				$(matrial_select_this221).closest('.input_descr_wrap').find("input[name='invoice_id[]']").val('');
				
				
				});
            }

        });
	 
 }

/********************************************************************************************************************************************/
/*********************************************************************************************************************************************/
/********************************************  PURCHASE BILL SCRIPT START HERE  *************************************************************/
/************************************************************************************************************************************/
/**************************************************************************************************************************************/

$(document).on("click",".add_purchase_bill_to_tabs",function(){ 
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		switch (tab) {
			case 'purchase_bill':
				url = 'account/editpurchase_bill_detail';
				break;	
			case 'purchase_bill_view':
				url = 'account/viewpurchase_bill_detail';
				break;					
		}
	$.ajax({
		type: "POST",
		url: site_url + url,
		data: {id:id}, 
		success: function(data){
			
			if(data != '') {
				$("#purchase_bill_modal").modal({
					show:false,
					backdrop:'static'
				});
				if($('#purchase_bill_modal').length){
						$('#purchase_bill_modal').modal('toggle');
						$('#purchase_bill_modal .modal-body-content').html(data);	
					}else{
						$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
					
						
				add_field_for_create_bill();
				get_supplier_details_onchange();
				using_tax_dropdown();
				on_rate_chage();
				add_discount_per_item_in_purchase_bill(); 
				on_quantity_chage();
				init_select2();
				add_product_onthe_spot();
				 init_select_forAdd_suplier();
				 add_more_charges_details();
				 get_supplier_address_in_purchase_bill();
				 party_name_ledger_id_onchange_for_Purchase_bill();
				 add_comp_address_change();
				 close_modal_Script();
				 fectch_metreail_detaild();
				 $('#suppgstin').keyup(function(){
						this.value = this.value.toUpperCase();
					});
						 
						 //For Show Hide charges Details
				$(document).on("click",".show_charges",function(){
					
						$('.charges_form').toggle();
						$('.ad_rm_readonly').prop('disabled', true);
						init_select2();
					var sale_company_state_idd = $('#sale_company_state_id').val();
					var party_billing_state = $('#party_billing_state_id').val();
						if(party_billing_state != sale_company_state_idd){
							 $('.cgst_amt1').hide();
							 $('.sgst_amt1').hide();
							 $('.igst_amt1').show();
						 }else{
							  $('.cgst_amt1').show();
							  $('.sgst_amt1').show();
							  $('.igst_amt1').hide();
						 }
					});
					add_charges_on_purchase();
					tax_calculation_for_charges();
					
					   
										
					//For Show Hide charges Details	
					var date = new Date();
					var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					
						  //Date Format Change Script	
							$('#bill_date').datepicker({
								format: 'dd-mm-yyyy',
								autoclose: true,
								todayHighlight: true,
								changeMonth: true,
								changeYear: true
							});
							//Date Format Change Script	
					
						$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
							}
				/* This Code is used for Invoice Edit Time*/
					var party_billing_state = $('#party_billing_state_id').val();
					var sale_company_state_idd = $('#sale_company_state_id').val();
					 if(party_billing_state != sale_company_state_idd){
							  $('.cgst').hide();
							 $('.sgst').hide();
							 $('.igst').show();
						 }else{
							  $('.cgst').show();
							  $('.sgst').show();
							  $('.igst').hide();
						 }
				/* This Code is used for Invoice Edit Time*/
							
					}
			}); 
			
	});
/*Purchase bill*/	

function close_modal_Script(){
	$('.close_modal2').click(function(){
	 setTimeout(function(){	
	   $("body").removeClass("modal-open");
	   }, 1000);
	});
}


	function party_name_ledger_id_onchange_for_Purchase_bill(){
		$('.get_ledger_state_Purcahse_bill').change(function(){
		    $('#purchase_address').html('<option selected>Select Address</option>');		
            $('.charges_form').hide();
			var selected_party_name_ledger_id = $(this).val();
			setTimeout(function(){
				var login_user_idd = $('#login_user_idddd').val();
					$.ajax({
					   type: "POST",
					   url: site_url+'account/get_company_branch_state/',
					   data: { id:selected_party_name_ledger_id,login_user:login_user_idd}, 
					   success: function(result) {
						    var obj = jQuery.parseJSON(result);
						    var get_pur_state_id =  jQuery.parseJSON(obj.address);
						  var len = get_pur_state_id.length;
							for(var i=0; i<len; i++){
							
							 var mailing_address1 = get_pur_state_id[i].compny_branch_name;
							 var mailing_state1 = get_pur_state_id[i].state;
							 var gstin_no = get_pur_state_id[i].company_gstin;
							 var company_branch_iddd = get_pur_state_id[i].add_id;
							
							 var  Dropdn_sale = '<option value="'+ mailing_state1 +'" data-gst="'+ gstin_no +'" branh-id = "' + company_branch_iddd + '">'+ mailing_address1   +'</option>';
							 $("#purchase_address").append(Dropdn_sale);
							// if(mailing_state1 != ''){
							 // setTimeout(function(){
								// $('#purchase_address option:eq(1)').attr('selected', 'selected');
							// }, 1000);
							
							 // setTimeout(function(){
								// var datagstval = $('#purchase_address option:selected').attr('data-gst');
								// var dropDownSelectval = $('#purchase_address option:selected').val();
								// $('#purchase_gstin').val(datagstval);
								// $('#party_billing_state_id').val(dropDownSelectval);
							// }, 1500);
						//}
					}	
							// var get_state_id =  jQuery.parseJSON(obj.mailing_address);
							// var party_billing_state = get_state_id[0].mailing_state;
							// $('#party_billing_state_id').val(party_billing_state);
					 }
			 });
			 }, 800);
			
		});
	}
	
function add_comp_address_change(){
	$('#purchase_address').change(function(){	
		var datagstval = $('#purchase_address option:selected').attr('data-gst');
		var Purchase_com_branch_id = $('#purchase_address option:selected').attr('branh-id');
		var dropDownSelectval = $('#purchase_address option:selected').val();
		$('#purchase_gstin').val(datagstval);
		$('#party_billing_state_id').val(dropDownSelectval);
		$('#purchase_lger_brnch_id').val(Purchase_com_branch_id);
		 setTimeout(function(){
				
			 /* This Code is used for Invoice Edit Time*/
					var party_billing_state = $('#party_billing_state_id').val();
					var sale_company_state_idd = $('#sale_company_state_id').val();
					 if(party_billing_state != sale_company_state_idd){
							  $('.cgst').hide();
							 $('.sgst').hide();
							 $('.igst').show();
						 }else{
							  $('.cgst').show();
							  $('.sgst').show();
							  $('.igst').hide();
						 }
				/* This Code is used for Invoice Edit Time*/
			}, 1000);
		
		
    });	
}	
	
	
	
	
	
	
	
	
	
//Add Total Discount On Bill
function add_charges_on_purchase(){
	$('.Add_charges_id').change(function(){
			var charge_ldger_id = $(this).val();
			
			var matrial_select_this_val =  $(this);
			
		setTimeout(function(){
			$('.ad_rm_readonly').prop('disabled', false);
				$.ajax({
					   type: "POST",
					   url: site_url+'account/get_charges_details/',
					   data: { id:charge_ldger_id}, 
					   success: function(result) {
						   var obj = jQuery.parseJSON(result);
						 	 if(obj.data.type_charges == 'minus'){
										$(matrial_select_this_val).closest('.testDh').find(".aply_btn").html('<input type="button"  class="add_dis" value="Apply Discount">');
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name[]']").val(obj.ledger_nam);
										$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name_id[]']").val(obj.data.ledger_id);
										$(matrial_select_this_val).closest('.testDh').find("input[name='type_charges[]']").val(obj.data.type_charges);
										
											var sale_basic_amount = 0;
											var total_basic_amount = 0;
								         	var amount_after_each_calcu = 0;
											var total_amt = 0;
											var total_tax_amount = 0;
											var grand_total_sum = 0;
											
											
											$('.add_dis').on('click', function() {
												var get_cahrges_added = $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
												if(get_cahrges_added == ''){
													$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid red");  
													return false;
												}
												$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid #ddd");  
												//$(this).attr('disabled','disabled');
													$(".SSubtotal").each(function(){
													total_basic_amount += parseFloat($(this).val());													
												});	
												
												
												$(".SSubtotal").each(function(){
													sale_basic_amount = parseFloat($(this).val());
													var discount_amt =	$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
													amount_after_each_calcu = sale_basic_amount * discount_amt/total_basic_amount;
													var amount_after_discount = sale_basic_amount - amount_after_each_calcu;
													$(this).val(amount_after_discount);
													total_amt += amount_after_discount;
													
												});	
												$("input[name='subtotal[]']").each(function(){
													sale_basic_amount = parseFloat($(this).val());
													var discount_amt =	$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
													amount_after_each_calcu = sale_basic_amount * discount_amt/total_basic_amount;
													var amount_after_discount = sale_basic_amount - amount_after_each_calcu;
													$(this).val(amount_after_discount);
													total_amt += amount_after_discount;
													
												});	
												//For Tax Calculation
												var added_tax11 = 0;
												var amount_with_tax_amt = 0;
												$(".tax").each(function(){
													added_tax11 = parseFloat($(this).val());
													var get_basic_amt =  $(this);
													var basic_amt = $(get_basic_amt).closest('.input_descr_wrap').find(".SSubtotal").val();
													var tax_amt = added_tax11 * basic_amt/100;
													$(get_basic_amt).closest('.input_descr_wrap').find('.tax_amount2').val(tax_amt);
													amount_with_tax =  parseFloat(tax_amt) + parseFloat( basic_amt);
													amount_with_tax_amt += amount_with_tax;
													$(get_basic_amt).closest('.input_descr_wrap').find("input[name='amount[]']").val(amount_with_tax);
													
												});
												$("input[name='total_tax2[]']").each(function(){
													total_tax_amount += parseFloat($(this).val());
													$('.totaltax_total').val(total_tax_amount);
												});	
												$("input[name='amount[]']").each(function() {
														grand_total_sum += Number($(this).val());
													});
													$(".grand_total").val(grand_total_sum);
												//For Tax Calculation
												
											});
												
						   }
						  
						   if(obj.data.type_charges == 'plus'){
							 
						        $('#total_tax_slab').val(obj.data.tax_slab);//Add total_tax
								$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name[]']").val(obj.ledger_nam);
								$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name_id[]']").val(obj.data.ledger_id);
								$(matrial_select_this_val).closest('.testDh').find("input[name='type_charges[]']").val(obj.data.type_charges);
								var sale_company_state_idd = $('#sale_company_state_id').val();
								var party_billing_state = $('#party_billing_state_id').val();
									if(party_billing_state != sale_company_state_idd){
										var taxslabb = obj.data.tax_slab;
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").val(taxslabb);
										
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").show();
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
									}else{
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
										$(matrial_select_this_val).closest('.testDh').find(".for_discount_hide").show;
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").show;
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").show;
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show;
										var taxslabb = obj.data.tax_slab;
										var tax_divide_state_diff = taxslabb / 2; 
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").val(tax_divide_state_diff);
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").val(tax_divide_state_diff);
									  }
							    }	
							}
						});
					}, 1000);	
				});
}
//Add Total Discount On Bill





$(document).on("click",".view_purchase_register_dital",function(){ 
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		switch (tab) {
			case 'purchaseregister_bill_view':
				url = 'account/viewpurchase_register_detail';
				break;					
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){
			
				if(data != '') {
					$("#purchase_bill_modal").modal({
						show:false,
						backdrop:'static'
					});
					$('#purchase_bill_modal').modal('toggle');
					$('#purchase_bill_modal .modal-body-content').html(data);	
						
						add_field_for_create_bill();
						get_supplier_details_onchange();
						using_tax_dropdown();
						on_rate_chage();
						on_quantity_chage();
						init_select2();
						add_product_onthe_spot();
						 init_select_forAdd_suplier();
					  var date = new Date();
						 var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
						 var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
							 //Date Format Change Script	
							$('#bill_date').datepicker({
								format: 'dd-mm-yyyy',
								autoclose: true,
								todayHighlight: true,
								changeMonth: true,
								changeYear: true
							});
							//Date Format Change Script	
							//$('#bill_date').datepicker('setDate', today);
					  
					
						$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
							}
					}
				}); 
	});
	
	
	
	
	
	
$(document).on("click",".add_purchase_unpaid_bill",function(){ 
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
//alert(tab);
		switch (tab) {
			// case 'purchase_bill':
				// url = 'account/editpurchase_bill_detail';
				// break;	
			case 'purchase_unpaid_bill_view':
				url = 'account/viewpurchase_unpaid_bill_detail';
				break;					
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){
				
				if(data != '') {
					$("#purchase_unpaid_bill_modal").modal({
						show:false,
						backdrop:'static'
					});
					$('#purchase_unpaid_bill_modal').modal('toggle');
					$('#purchase_unpaid_bill_modal .modal-body-content').html(data);	
						init_select_forAdd_suplier();
						add_field_for_create_bill();
						get_supplier_details_onchange();
						using_tax_dropdown();
						on_rate_chage();
						
						on_quantity_chage();
						init_select2();
							$('#jobs').DataTable({//data Table In Modal
							"footerCallback": function ( row, data, start, end, display ) {
								var api = this.api(),data;

								// converting to interger to find total
								var intVal = function ( i ) {
									return typeof i === 'string' ?
										i.replace(/[\$,]/g, '')*1 :
										typeof i === 'number' ?
											i : 0;
								};
								// computing column Total of the complete result
								var tttl = api
								.column( 6 , { page: 'current'}  )
								.data()
								.reduce( function (a, b) {
									return intVal(a) + intVal(b);
								},0);
								var tttl_com_sep = tttl.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
							$('.g_ttl').html(tttl_com_sep);
							
							var taxx = api
								.column( 7 , { page: 'current'}  )
								.data()
								.reduce( function (a, b) {
									return intVal(a) + intVal(b);
								},0);
								var tx_cls_com_sep = taxx.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
							$('.tax_ttl').html(tx_cls_com_sep);
						},
						destroy: true,
						searching: false
						   
						});
						
					  var date = new Date();
						 var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
						 var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
							 //Date Format Change Script	
							$('#bill_date').datepicker({
								format: 'dd-mm-yyyy',
								autoclose: true,
								todayHighlight: true,
								changeMonth: true,
								changeYear: true
							});
							//Date Format Change Script	
							//$('#bill_date').datepicker('setDate', today);
					  
					
						$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
							}
					}
				}); 
	});	
	
	
	
	
	
	
	
	
	
	
	
/**************************************************************************************************************/	
/***************************for Fetch Invoce Automatic Entery******************************************************************/	
/***************************************************************************************************************************/	
$(document).on("click",".view_automatic_entery_invoice",function(){ 
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		switch (tab) {
			case 'automatic_entery_view':
				url = 'account/viewautomatic_entry_invoice';
				break;					
		}	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){
			if(data != '') {
				$("#auto_entry_invoice").modal({
						show:false,
						backdrop:'static'
					});
					$('#auto_entry_invoice').modal('toggle');
					$('#auto_entry_invoice .modal-body-content').html(data);	
					reject_invoice_fun();
					accept_invoice_fun();
					}
				}
			}); 
	});	
function reject_invoice_fun(){	
$('#reject_msg').on('click',function(){
	$('#reject_msg_div').show();
	var reject_data = $('#msagge').val();
	if(reject_data == ''){
		$('#msgg').html('<span style="color:red;font-size:14px;">Please Add Rejection Message first</span>');
		$('#accept_msg').hide();
		$('#reject_msg').html('Submit');
		
		return;
	}else{
	var invoice_idd = $(this).attr('data-idd');
	var reject_invoice = $('#msagge').val();
	//$('#msgg').html('');
	$.ajax({
	   type: "POST",
	   url: site_url+'account/accept_reject_invoice/',
	   data: { invoice_idd:invoice_idd,accept_reject:1,reject_invoice:reject_invoice}, 
	   success: function(htmlStr) {
		  // alert(htmlStr);
		 if(htmlStr =='true'){
			   $('#msg_Show').html('<span style="color:red;font-size:14px;">You have Recject This Invoice.</span>');
			   setTimeout(function(){
						$('#auto_entry_invoice').modal('hide');
				}, 2000);
				 setTimeout(function(){
						location.reload();
				}, 1000);
					
		   }
		}
	});
	}
	});	
}
function accept_invoice_fun(){	
$('#accept_msg').on('click',function(){
	var invoice_idd = $(this).attr('data-idd');

	$.ajax({
	   type: "POST",
	   url: site_url+'account/accept_reject_invoice/',
	   data: { invoice_idd:invoice_idd,accept_reject:0}, 
	   success: function(htmlStr) {
		 if(htmlStr =='true'){
			   $('#msg_Show').html('<span style="color:Green;font-size:14px;">Thanks For Accepting .</span>');
			   setTimeout(function(){
						$('#auto_entry_invoice').modal('hide');
				}, 2000);
				 setTimeout(function(){
						location.reload();
				}, 1000);
					
		   }
		}
	});

	});	
}	
/**************************************************************************************************************************/	
/****************************************************for Fetch Invoce Automatic Entery end **********************************/	
/***************************************************************************************************************************/	
	

function add_field_for_create_bill(){
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".bills_descr_wrapper"); //Fields wrapper
    var add_button      = $(".add_bills_detail_button"); //Add button ID
    var x = 1; //initlal text box count

	$(add_button).click(function(e){ //on add input button click
	    e.preventDefault();
			var uomsArray = '';
				$.each( uoms, function( key, value ) {
				uomsArray = uomsArray+'<option value="'+value+'">'+value+'</option>';
			});
			//<select name="UOM[]" class="form-control col-md-1 bills_descr_section"><option value="">Select</option>'+uomsArray+'</select>
			//<select name="tax[]" class="form-control col-md-1 bills_descr_section tax"><option value="">Select</option><option value="12">12.0% GST(12%)</option><option value="18">18.0% GST(18%)</option><option value="28">28.0% GST(28%)</option></select>
			var company_login_id = $('#company_login_id').val();
			var get_discount_on_off = $('#get_discount_on_off').val();
			
			
		
        if(x < max_fields){ //max input box allowed
            x++; 
				if(get_discount_on_off == '1'){
				$(wrapper).append('<div class="col-md-12 input_descr_wrap middle-box mailing-box mobile-view"><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label  for="matrialname">Item Code <span class="required">*</span></label><select class="itemName  form-control selectAjaxOption select2 get_val add_product_onthe_spot select_material_dtl"  required="required" name="product_details[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='+ company_login_id +'" width="100%"></select></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label for="matrialname">Matrial Name <span class="required">*</span></label><input type="text" name="descr_of_bills[]" class="form-control col-md-12 col-xs-12" placeholder="Description Of Bills" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label  for="descriptions">Description</label><input type="text" name="hsnsac[]" class="form-control col-md-1" placeholder="HSN/SAC" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label for="hsn/sac">HSN/SAC<span class="required">*</span></label><input type="text"   name="qty[]" class="form-control col-md-1 year bills_descr_section qty_cls " placeholder="Qty" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label  for="quantity">Quantity<span class="required">*</span></label><div class="input-group"><input type="text" name="UOM[]" class="form-control col-md-1 bills_descr_section"  value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label  for="rate">Rate<span class="required">*</span></label><div class="input-group"><input type="text" name="rate[]" class="form-control col-md-1 bills_descr_section rate_class" placeholder="Rate" value=""><input type="hidden" name="total_tax2[]" class="form-control col-md-1 bills_descr_section tax_amount2"  value=""><input type="hidden" name="subtotal[]" class="form-control col-md-1 bills_descr_section" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label  for="tax">Tax<span class="required">*</span></label><div class="input-group checktr"><select name="disctype[]" class="form-control disc_type_cls_purchase"><option value="">Select</option><option value="disc_precnt">Discount Percent</option><option value="disc_value">Discount Value</option></select></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label for="uom">UOM<span class="required">*</span></label><div class="input-group checktr"><input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" readonly placeholder="Disc Amt" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1" class= for="amount">Amount with Tax<span class="required">*</span></label><div class="input-group checktr"><input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" readonly placeholder="After Disc Amt" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Subtotal</label><div class="input-group checktr"><input type="text" class="form-control col-md-1 bills_descr_section SSubtotal" placeholder="Subtotal" value="" ></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Tax</label><div class="input-group"><input type="text" name="tax[]" class="form-control col-md-1 bills_descr_section tax" value="" readonly><input type="hidden" value="" name="added_tax_Row_val[]" ><input type="hidden" value="" name="totaltax_total_calculate"></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label>Amount</label><div><input type="text" name="amount[]" class="form-control col-md-1 bills_descr_section" placeholder="Amount" value="" ><input type="hidden" value="" name="cess[]"><input type="hidden" value="" name="cess_tax_calculation[]"><input type="hidden" value="" name="valuation_type[]"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>');
				}else{
				$(wrapper).append('<div class="col-md-12 input_descr_wrap middle-box"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><select class="itemName  form-control selectAjaxOption select2 get_val add_product_onthe_spot select_material_dtl"  required="required" name="product_details[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='+ company_login_id +'" width="100%"></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="descr_of_bills[]" class="form-control col-md-12 col-xs-12" placeholder="Description Of Bills" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><input type="text" name="hsnsac[]" class="form-control col-md-1" placeholder="HSN/SAC" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><input type="text"   name="qty[]" class="form-control col-md-1 year bills_descr_section qty_cls " placeholder="Qty" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><div class="input-group"><input type="text" name="UOM[]" class="form-control col-md-1 bills_descr_section"  value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><div class="input-group"><input type="text" name="rate[]" class="form-control col-md-1 bills_descr_section rate_class" placeholder="Rate" value=""><input type="hidden" name="total_tax2[]" class="form-control col-md-1 bills_descr_section tax_amount2"  value=""><input type="hidden" name="subtotal[]" class="form-control col-md-1 bills_descr_section" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><div class="input-group checktr"><input type="text" class="form-control col-md-1 bills_descr_section SSubtotal" placeholder="Subtotal" value="" i></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><div class="input-group"><input type="text" name="tax[]" class="form-control col-md-1 bills_descr_section tax" value="" readonly><input type="hidden" value="" name="added_tax_Row_val[]" ><input type="hidden" value="" name="totaltax_total_calculate"></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><div ><input type="text" name="amount[]" class="form-control col-md-1 bills_descr_section" placeholder="Amount" value="" ><input type="hidden" value="" name="cess[]"><input type="hidden" value="" name="cess_tax_calculation[]"><input type="hidden" value="" name="valuation_type[]"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>');
				}

				using_tax_dropdown();
				on_rate_chage();
				add_discount_per_item_in_purchase_bill();
				on_quantity_chage();
				//init_select2();
				add_product_onthe_spot();
				fectch_metreail_detaild();

				
        }
    });
    
    $(wrapper).on("click",".remove_descr_field", function(e){ //user click on remove text
        e.preventDefault(); 
		$(this).parent('div').remove(); x--;
		setTimeout(function(){
						$('.qty_cls').keyup();
						$('.rate_class').keyup();	
					}, 1000);
    });	
}

//ADD Purchase Bill Details On the Spot
function add_product_onthe_spot(){

	$('.add_product_onthe_spot').select2({
	
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: 'Select And Begin Typing',
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2search',
			dataType: 'json',
			delay: 250,
			data: function (params) {
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },		  
        processResults: function (data) {
            return {
              results: data
            };
        },
			cache: true,
         },language: {
			noResults: function() {
				var searched_value =  $('.select2-search__field').val();
				//$('#fetch_pname').val(searched_value);
				//var lb_ID = $('#fetch_pname').val();
				  $('#material_name').val(searched_value);
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_product_onthe_spot'>Add Material </span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
    });
	
	
}
function fectch_metreail_detaild(){
	$('.select_material_dtl').change(function(){ 		
		    var matrial_select_this =  $(this);
			var selected_id = $(this).val();
 		
			$.ajax({
				   type: "POST",
				   url: site_url+'account/selectMatrial/',
				   data: { id:selected_id}, 
				   success: function(result) {
					  var obj = jQuery.parseJSON(result);
					
					  var specification_var = obj.specification;
					  var hsn_code_var = obj.hsn_code;
					  var uom_var = obj.uom;
					  var var_cess = obj.cess;
					  var var_valuation_type = obj.valuation_type;
					
					  var quantity = obj.opening_balance;
					  var rate = obj.sales_price;
					  var tax = obj.tax;
				
					  var mat_idds = obj.id;
					 
					  var TotalAmount = rate*quantity;
					 var minQty = 1;	
					 
					// console.log('this==>>',$(matrial_select_this).closest('.input_descr_wrap').find("input[name='tax[]']").val(tax));
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='mat_idd_name']").val(mat_idds);
					$(matrial_select_this).closest('.input_descr_wrap').find("textarea[name='descr_of_goods[]']").val(specification_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='hsnsac[]']").val(hsn_code_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='qty[]']").val(minQty);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='rate[]']").val(rate);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='tax[]']").val(tax);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='tax[]']").attr("readonly", true); 
					//$(matrial_select_this).closest('.input_descr_wrap').find("input[name='sale_amount']").val(tax);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='amount[]']").val();
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='UOM[]']").val(uom_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess[]']").val(var_cess);
					var CESS_VALUE = $(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess[]']").val();
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val(var_valuation_type);
					//$(matrial_select_this).closest('.input_descr_wrap').find('select[name="UOM[]"] option[value="' + uom_var + '"]').prop('selected',true);
					//$(matrial_select_this).closest('.input_descr_wrap').find('select[name="tax[]"] option[value="' + tax + '"]').prop('selected',true);
					// if(CESS_VALUE == '' ||  CESS_VALUE == null){
						// $(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val();
						// $(matrial_select_this).closest('.input_descr_wrap').find("input[name='amount[]']").val();
						// $(".cess_total_cls").val('');
					// }
		// setTimeout(function(){
			
			// var Cess_TOTAL = 0;
				// $("input[name='cess_tax_calculation[]']").each(function(){
				// Cess_TOTAL += Number($(this).val());
			// });
				// if(Cess_TOTAL == 0){
				// $('.cess').hide();	
				// }else{
					// $('.cess').show();	
				// }
		// }, 1500);
					
					
					
					
					subtotal();
					setTimeout(function(){
						$('.qty_cls').keyup();	
						$('.rate_class').keyup();	
					}, 1000);
					
					
					
					
				 }
			 });
		}); 
}





$(document).on("click",".add_more_product_onthe_spot",function(){
	
	 $('#myModal_Add_matrial_details_purchse').modal('show');
	 
	//GET Matrial type id 
	var user_id = 1;
	$.ajax({
		   type: "POST",
		   url: site_url+'account/Get_matrial_type/',
		  data: {user_id:user_id}, 
		   success: function(htmlStr) {
			  var  obj = JSON.parse(htmlStr);
			  var len = obj.length;
				for(var i=0; i<len; i++){	
					var id = obj[i].id;
					var name = obj[i].name;
					var prefix = obj[i].prefix;
					var str_Dta = '<option value="'+id+'" data-prfix="'+prefix+'">'+ name +'</option>';
					var str_prefix = '<input type="hidden" value="'+prefix+'" >';
					$("#material_type_id").append(str_Dta);
				}	
			}
		});
		//GET Matrial type id 
});
//To close Add supplier Popup Model
$(document).on("click",".close_sec_model",function(){
	 $('#myModal_Add_matrial_details_purchse').modal('hide');
});

//ADD Purchase Bill Details On the Spot





//Add More Suplier for adding bills
function init_select_forAdd_suplier() {
		$('#add_suplier_btn').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: 'Select And Begin Typing',
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2search',
			dataType: 'json',
			delay: 250,
			data: function (params) {
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },		  
        processResults: function (data) {
            return {
              results: data
            };
        },
			cache: true,
         },language: {
			noResults: function() {
				var searched_value =  $('.select2-search__field').val();
				
				$('#fetch_sname').val(searched_value);
				var lb_ID = $('#fetch_sname').val();
				$('#suppliername').val(lb_ID);
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_supliers'>Add </span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
    });
	
}



//ADD TOTAL TAX
//GET supplier And add  Details in forms
function get_supplier_details_onchange(){
	$('#add_suplier_btn').on('change',function(){
		
		var supplierID = $(this).val();
		//alert(supplierID);
		$.ajax({
				   type: "POST",
				   url: site_url+'account/Getsupplier_details/',
				   data: { id:supplierID}, 
				   success: function(htmlStr) {
				    var obj = jQuery.parseJSON(htmlStr);
					//alert(JSON.stringify(obj));
					 var supplier_id = obj.id;
					 var supplier_address = obj.address;
					 var supplier_gstin = obj.gstin;
					 var supplier_ifsc_code = obj.ifsc_code;
					 var supplier_state = obj.state;
					 var sale_company_state_idd = $('#sale_company_state_id').val(supplier_state);
					 $('#supp_address').val(supplier_address);
					 $('#gstin_id').val(supplier_gstin);
					 $('#ifsc_code').val(supplier_ifsc_code);
					 
				}
			 });
		
		
	});
}
 
 function  using_tax_dropdown(){
	$('.tax').on('change', function() {
		var tax_val  =  $(this).val();
		var theQty = $(this).closest('.input_descr_wrap').find("input[name='qty[]']").val();
		var therate = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		var with_quantity_price = theQty * therate;
		$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(with_quantity_price);
		var percent_on_total = tax_val * with_quantity_price/100;
		$('.tax_amount2').val(percent_on_total);
		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		$(this).closest('.input_descr_wrap').find("input[name='totaltax_total_calculate']").val(percent_on_total);
		var valueww = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
		var grand_total_sum = 0;
			$("input[name='amount[]']").each(function() {
				grand_total_sum += Number($(this).val());
			});
			var grand_total_sum = grand_total_sum.toFixed(2);
		$(".grand_total").val(grand_total_sum);
			var caluclate_total_tax = 0;
			$("input[name='totaltax_total_calculate']").each(function() {
				caluclate_total_tax += Number($(this).val());
			});
			$(".totaltax_total").val(caluclate_total_tax);
    });
 }
 
 function  on_quantity_chage(){
	$('.qty_cls').on('keyup', function() {
		
		var theQty = $(this).closest('.input_descr_wrap').find("input[name='qty[]']").val();
		var therate = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		var Total_with_tax = parseFloat(therate) * parseFloat(theQty);
		$(this).closest('.input_descr_wrap').find(".SSubtotal").val(Total_with_tax);
		$(this).closest('.input_descr_wrap').find(".SSubtotal").attr("readonly", true); 
		$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(Total_with_tax);
		var amountd = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find(".tax").prop('selectedIndex',0);
		//$('.tax').prop('selectedIndex',0);
		//$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(amountd);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(amountd);
		var grand_total_sum = 0;
			$("input[name='amount[]']").each(function() {
				grand_total_sum += Number($(this).val());
			});
			var grand_total_sum = grand_total_sum.toFixed(2);
		
			$(".grand_total").val(grand_total_sum);
			
			
			
		var tax_val  =  $(this).closest('.input_descr_wrap').find("input[name='tax[]']").val();
		
		var theQty = $(this).closest('.input_descr_wrap').find("input[name='qty[]']").val();
		var therate = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		
		var with_quantity_price = theQty * therate;
		$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(with_quantity_price);
		
		var percent_on_total = tax_val * with_quantity_price/100;
		
		$('.tax_amount2').val(percent_on_total);
		
		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		$(this).closest('.input_descr_wrap').find("input[name='totaltax_total_calculate']").val(percent_on_total);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax_Row_val[]']").val(percent_on_total);
		var valueww = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
		/* Calculation of Cess*/
		var cess_Amt = $(this).closest('.input_descr_wrap').find("input[name='cess[]']").val();
		var valuation_type_val = $(this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val();
		console.log('vauation Type ====>',valuation_type_val);
		if(cess_Amt != '' ||  cess_Amt != null){
			if( valuation_type_val == 'based_on_value'){
				var afteradd_cessTax = valueww * cess_Amt/100;
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(afteradd_cessTax);
				var withcess_Amt = parseFloat(valueww) + parseFloat(afteradd_cessTax);
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
		}
		if(valuation_type_val == 'based_on_qty'){
			var cess_amt_ttl =	theQty * cess_Amt;
			var afteradd_cessTax =  parseFloat(valueww) + parseFloat(cess_amt_ttl) ;
			console.log('afteradd_cessTax ==>',afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(cess_amt_ttl);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
			
		}
		if(valuation_type_val == 'based_on_qty_value'){
			var cess_amt_ttl =	theQty * cess_Amt;
			var Cess_persent_value = valueww * cess_Amt/100;
			console.log('cess_amt_ttl',cess_amt_ttl);
			console.log('Cess_persent_value',Cess_persent_value);
			var Add_val_qty = parseFloat(Cess_persent_value) + parseFloat(cess_amt_ttl) ;
			console.log('Add_val_qty',Add_val_qty);
			var afteradd_cessTax =  parseFloat(valueww) + parseFloat(Add_val_qty) ;
			console.log('afteradd_cessTax ==>',afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(Add_val_qty);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
			
		}	
		}else if(cess_Amt == '' ||  cess_Amt == null){
			$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val('');
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val('');
			$(".cess_total_cls").val('');
		}
		setTimeout(function(){
			//var Cess_TOTAL = $('.cess_total_cls').val();
			var Cess_TOTAL = 0;
				$("input[name='cess_tax_calculation[]']").each(function(){
				Cess_TOTAL += Number($(this).val());
			});
				if(Cess_TOTAL == 0){
				$('.cess').hide();	
				}else{
					$('.cess').show();	
				}
		}, 1500);	
		/* Calculation of Cess*/
		
		var grand_total_sum = 0;
			$("input[name='amount[]']").each(function() {
				grand_total_sum += Number($(this).val());
			});
			var grand_total_sum = grand_total_sum.toFixed(2);
			$(".grand_total").val(grand_total_sum);
			
			var caluclate_total_tax = 0;
			$("input[name='added_tax_Row_val[]']").each(function() {
				caluclate_total_tax += Number($(this).val());
			});

			$(".totaltax_total").val(caluclate_total_tax);


			var subtotal_sum = 0;
			$("input[name='subtotal[]']").each(function(){
				subtotal_sum += parseFloat($(this).val());													
			});	
			
			$(".total_amountt").val(subtotal_sum);
			
			setTimeout(function(){
			var total_tax_value = 0;
			
			$("input[name='totaltax_total']").each(function(){
				total_tax_value += parseFloat($(this).val());
				//$('.totaltax_total').val(total_tax_amount);
			});
			
			
			/* This Code is used for Invoice Edit Time*/
					var party_billing_state = $('#party_billing_state_id').val();
					var sale_company_state_idd = $('#sale_company_state_id').val();
					 if(party_billing_state != sale_company_state_idd){
							$('.tax_class, .igst').val(total_tax_value); 
						 }else{
							 var divide_tax_value = total_tax_value / 2;
							 $('.tax_class1, .cgst').val(divide_tax_value);
							 $('.tax_class2, .sgst').val(divide_tax_value);
						 }
				/* This Code is used for Invoice Edit Time*/
			}, 1000);	
	
    });
 }
 
 
 
  function  on_rate_chage(){
	$('.rate_class').on('keyup', function() {
		var theQty = $(this).closest('.input_descr_wrap').find("input[name='qty[]']").val();
		var therate = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		var Total_with_tax = parseFloat(therate) * parseFloat(theQty);
		$(this).closest('.input_descr_wrap').find(".SSubtotal").val(Total_with_tax);
		$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(Total_with_tax);
		var amountd = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find(".tax").prop('selectedIndex',0);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(amountd);
		var grand_total_sum = 0;
			$("input[name='amount[]']").each(function() {
				grand_total_sum += Number($(this).val());
			});
			var grand_total_sum = grand_total_sum.toFixed(2);
			$(".grand_total").val(grand_total_sum);
			
			
		var tax_val  =  $(this).closest('.input_descr_wrap').find("input[name='tax[]']").val();
		var theQty = $(this).closest('.input_descr_wrap').find("input[name='qty[]']").val();
		var therate = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		
		var with_quantity_price = theQty * therate;
		$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(with_quantity_price);
		
		var percent_on_total = tax_val * with_quantity_price/100;
		$('.tax_amount2').val(percent_on_total);
		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		
		
		$(this).closest('.input_descr_wrap').find("input[name='totaltax_total_calculate']").val(percent_on_total);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax_Row_val[]']").val(percent_on_total);
		var valueww = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
		/* Calculation of Cess*/
		var cess_Amt = $(this).closest('.input_descr_wrap').find("input[name='cess[]']").val();
		var valuation_type_val = $(this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val();
		console.log('vauation Type ====>',valuation_type_val);
		if(cess_Amt != '' ||  cess_Amt != null){
			if( valuation_type_val == 'based_on_value'){
				var afteradd_cessTax = valueww * cess_Amt/100;
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(afteradd_cessTax);
				var withcess_Amt = parseFloat(valueww) + parseFloat(afteradd_cessTax);
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
		}
		if(valuation_type_val == 'based_on_qty'){
			var cess_amt_ttl =	theQty * cess_Amt;
			var afteradd_cessTax =  parseFloat(valueww) + parseFloat(cess_amt_ttl) ;
			console.log('afteradd_cessTax ==>',afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(cess_amt_ttl);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
			
		}
		if(valuation_type_val == 'based_on_qty_value'){
			var cess_amt_ttl =	theQty * cess_Amt;
			var Cess_persent_value = valueww * cess_Amt/100;
			console.log('cess_amt_ttl',cess_amt_ttl);
			console.log('Cess_persent_value',Cess_persent_value);
			var Add_val_qty = parseFloat(Cess_persent_value) + parseFloat(cess_amt_ttl) ;
			console.log('Add_val_qty',Add_val_qty);
			var afteradd_cessTax =  parseFloat(valueww) + parseFloat(Add_val_qty) ;
			console.log('afteradd_cessTax ==>',afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(Add_val_qty);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function(){
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function(){
					var cess_calulation_val = $(this).val();
					if(cess_calulation_val == ''){
						var cess_calulation_val_vari = 0;
					}else{
						var cess_calulation_val_vari = $(this).val();
					}
					cess_totalamt += parseFloat(cess_calulation_val_vari);
				});
					var cess_totalamt_total = cess_totalamt.toFixed(2);	
					$(".cess_total_cls").val(cess_totalamt_total);
			}, 1000);
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
			
		}	
		}else if(cess_Amt == '' ||  cess_Amt == null){
			$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val('');
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val('');
			$(".cess_total_cls").val('');
		}
		setTimeout(function(){
			//var Cess_TOTAL = $('.cess_total_cls').val();
			var Cess_TOTAL = 0;
				$("input[name='cess_tax_calculation[]']").each(function(){
				Cess_TOTAL += Number($(this).val());
			});
				if(Cess_TOTAL == 0){
				$('.cess').hide();	
				}else{
					$('.cess').show();	
				}
		}, 1500);	
		/* Calculation of Cess*/
		var grand_total_sum = 0;
			$("input[name='amount[]']").each(function() {
				grand_total_sum += Number($(this).val());
			});
			var grand_total_sum = grand_total_sum.toFixed(2);
			$(".grand_total").val(grand_total_sum);
			
			var caluclate_total_tax = 0;
			$("input[name='added_tax_Row_val[]']").each(function() {
				caluclate_total_tax += Number($(this).val());
			});
		
			$(".totaltax_total").val(caluclate_total_tax);
			var subtotal_sum = 0;
				$("input[name='subtotal[]']").each(function(){
				subtotal_sum += parseFloat($(this).val());													
			});	
				
			$(".total_amountt").val(subtotal_sum);
			
			
			setTimeout(function(){
			var total_tax_value = 0;
			
			$("input[name='totaltax_total']").each(function(){
				total_tax_value += parseFloat($(this).val());
				//$('.totaltax_total').val(total_tax_amount);
			});
			
			
			/* This Code is used for Invoice Edit Time*/
					var party_billing_state = $('#party_billing_state_id').val();
					var sale_company_state_idd = $('#sale_company_state_id').val();
					 if(party_billing_state != sale_company_state_idd){
							$('.tax_class, .igst').val(total_tax_value); 
						 }else{
							 var divide_tax_value = total_tax_value / 2;
							 $('.tax_class1, .cgst').val(divide_tax_value);
							 $('.tax_class2, .sgst').val(divide_tax_value);
						 }
				/* This Code is used for Invoice Edit Time*/
			}, 1000);	
				
	});
	
	
 }
//Add discount On  Purchase Bill
function add_discount_per_item_in_purchase_bill(){
	$('.disc_type_cls_purchase').on('change', function() {
			var discount_type_val = $(this).val();
			 var discount_texbox_val =  $(this);
			var added_qty =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='qty[]']").val();
    		var added_rate =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='rate[]']").val();
			
			var amt_acc_to_qty = added_qty * added_rate;
			
			$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val('');
			$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val('');
				if(discount_type_val == 'disc_precnt'){
				$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly',false);
				$('.added_discount_amt').keyup(function(){
						var discount_val =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val();
						var get_percent_amt = 	amt_acc_to_qty * discount_val/100;
						// 
						setTimeout(function(){
							var After_disc_total_amt =  amt_acc_to_qty - get_percent_amt;
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val(After_disc_total_amt);
							$(discount_texbox_val).closest('.input_descr_wrap').find(".SSubtotal").val(After_disc_total_amt);
						}, 1000);
						$('.tax').change(function(){
						var tax_val  =  $(this).val();
									var basic_amount = $(this).closest('.input_descr_wrap').find(".SSubtotal").val();
									// var therate = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
									 var tax_on_basic_amount = basic_amount * tax_val/100;

										$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(basic_amount);
										//var percent_on_total = tax_val * with_quantity_price/100;
										$('.tax_amount2').val(tax_on_basic_amount);
										var Total_with_tax = parseFloat(tax_on_basic_amount) + parseFloat(basic_amount);
										$(this).closest('.input_descr_wrap').find("input[name='totaltax_total_calculate']").val(tax_on_basic_amount);
										var valueww = Total_with_tax.toFixed(2);
										$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
											var grand_total_sum = 0;
											$("input[name='amount[]']").each(function() {
												grand_total_sum += Number($(this).val());
											});
											$(".grand_total").val(grand_total_sum);
											var caluclate_total_tax = 0;
											$("input[name='totaltax_total_calculate']").each(function() {
												caluclate_total_tax += Number($(this).val());
											});
											$(".totaltax_total").val(caluclate_total_tax);
									});	
							});
						}else{
							$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly',false);
							
									var added_qty =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='qty[]']").val();
									var added_rate =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='rate[]']").val();
									var amt_acc_to_qty = added_qty * added_rate;

								$('.added_discount_amt').keyup(function(){	
									var discount_val =	$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val();
									var get_amount_aftr_value_discount = 	amt_acc_to_qty - discount_val;
									$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val(get_amount_aftr_value_discount);
									$(discount_texbox_val).closest('.input_descr_wrap').find(".SSubtotal").val(get_amount_aftr_value_discount);
									$('.tax').change(function(){
											var tax_val  =  $(this).val();
											var basic_amount = $(this).closest('.input_descr_wrap').find(".SSubtotal").val();
											// var therate = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
											var tax_on_basic_amount = basic_amount * tax_val/100;
											$(this).closest('.input_descr_wrap').find("input[name='subtotal[]']").val(basic_amount);
											//var percent_on_total = tax_val * with_quantity_price/100;
											$('.tax_amount2').val(tax_on_basic_amount);
											var Total_with_tax = parseFloat(tax_on_basic_amount) + parseFloat(basic_amount);
											$(this).closest('.input_descr_wrap').find("input[name='totaltax_total_calculate']").val(tax_on_basic_amount);
											var valueww = Total_with_tax.toFixed(2);
											$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
											var grand_total_sum = 0;
											$("input[name='amount[]']").each(function() {
												grand_total_sum += Number($(this).val());
											});
											$(".grand_total").val(grand_total_sum);
											var caluclate_total_tax = 0;
											$("input[name='totaltax_total_calculate']").each(function() {
												caluclate_total_tax += Number($(this).val());
											});
											$(".totaltax_total").val(caluclate_total_tax);
									});
							});
					}

	});
}

//Add discount On  Purchase Bill 
//For adding More supplier  using Model

$(document).on("click",".add_more_supliers",function(){
	
	 $('#myModal_Add_supplier').modal('show');
});
//To close Add supplier Popup Model
$(document).on("click",".close_sec_model",function(){
	 $('#myModal_Add_supplier').modal('hide');
}); 

//Supplier Add Function
$(document).on("click","#add_suplier_btn_id",function(){

	var suppliername  = $('#suppliername').val();
	var supplieraddress  = $('#supplieraddress').val();
	var suppgstin  = $('#suppgstin').val();
	var country  = $('#cntry').val();
	var mailing_address  = $('#mailing_address').val();
	var state  = $('.state_id').val();
	var city_id  = $('.city_id').val();
	var acc_group_id  = $('.acc_group_id').val();
	
	var error = 0;
		if(suppliername == ''){
				$('#suppliername').css('border', '1px solid #b94a48');
				$('#suppliername').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#suppliername').css('border', '1px solid #dedede');
				$('#suppliername').closest(".form-group").find("span").text('');
			}
		if(suppgstin == ''){
				$('#suppgstin').css('border', '1px solid #b94a48');
				$('#suppgstin').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#suppgstin').css('border', '1px solid #dedede');
				$('#suppgstin').closest(".form-group").find("span").text('');
			}	
		if(supplieraddress == ''){
				$('#supplieraddress').css('border', '1px solid #b94a48');
				$('#supplieraddress').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#supplieraddress').css('border', '1px solid #dedede');
				$('#supplieraddress').closest(".form-group").find("span").text('');
			}
		if(mailing_address == ''){
				$('#mailing_address').css('border', '1px solid #b94a48');
				$('#mailing_address').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#mailing_address').css('border', '1px solid #dedede');
				$('#mailing_address').closest(".form-group").find("span").text('');
			}	
			
		if(country == null){
				$('#cntry').css('border', '1px solid #b94a48');
				$('#contry').text('This field is required');
				var error = 1;
				// alert('if');
			}else{
				$('#cntry').css('border', '1px solid #dedede');
				$('#contry').text('');
				// alert('else');
			}
			if(state == null){
				$('.state').css('border', '1px solid #b94a48');
				$('#state1').text('This field is required');
				var error = 1;
				// alert('if');
			}else{
				$('.state').css('border', '1px solid #dedede');
				$('#state1').text('');
				// alert('else');
			}
			if(city_id == null){
				$('.city_id').css('border', '1px solid #b94a48');
				$('#city1').text('This field is required');
				var error = 1;
				// alert('if');
			}else{
				$('.city_id').css('border', '1px solid #dedede');
				$('#city1').text('');
				// alert('else');
			}
			if(acc_group_id == null){
				$('.acc_group_id').css('border', '1px solid #b94a48');
				$('#acc_grp_id').text('This field is required');
				var error = 1;
				// alert('if');
			}else{
				$('.acc_group_id').css('border', '1px solid #dedede');
				$('#acc_grp_id').text('');
				// alert('else');
			}
		
		if(error == 1) { 
			return false;
		} else {
		$.ajax({
				   type: "POST",
				   url: site_url+'account/add_suppliers_detials_on_the_spot/',
				   data: {name:suppliername,address:supplieraddress,gstin:suppgstin,country:country,state:state,city_id:city_id,acc_group_id:acc_group_id,mailing_address:mailing_address}, 
				   success: function(htmlStr) {
					  // alert(htmlStr);
					   if(htmlStr == 'true'){
						$('#mssg').html('<span style="color:green;">Added Successfully.</span>');
						$("#insert_supplier_data_id").trigger('reset');
						setTimeout(function(){
							$('#myModal_Add_supplier').modal('hide');
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);		
					}else{
						$('#mssg').html('<span style="color:red;">Not Added.</span>');
					}
				}
			 });
		}
  
});











/******************************************************************************************************************************/
/*******************************************************************************************************************************/
/******************************   GET Ladger Details SCRIPT START HERE *********************************************************/
/****************************************************************************************************************************/
/********************************************************************************************************************************/



var searchRequest = null;

$(function () {
    var minlength = 3;

    $("#textbox").keyup(function () {
        var that = this,
        value = $(this).val();
		var login_user_id = $('#login_user_id').val();
		
		if(value != ''){
        if (value.length >= minlength ) {
            if (searchRequest != null) 
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "GET",
				async:true,
             	url: site_url+'account/get_ledger_account_onserach/',
                data: {'text_box_val' : value,'login_user_id':login_user_id },
				dataType: "text",
                success: function(msg){   
				    var obj = $.parseJSON(msg);	
					var len = obj.length;
					console.log('obj===>>>',obj);
					console.log('len===>>>',len);
					
					  $('.ledger_namee').html('');
				   var ledger_name = "";
				   var supp_name = "";
					for(var i=0; i < len; i++){
					    var id = obj[i].id;
					    var a = obj[i].name+'<br/>';
						$('.ldger_idd').attr('data-id',id); //setter  	
					 	ledger_name += a + " ";
				   }
				   
				   if(ledger_name!=''){
					$('.ldgernam').html(ledger_name);	
				   }
				
                }
            });
        }
		}else{
			window.location.href = site_url+'account/ledger_report/';
		}
    });
});
	
$(document).ready(function(){
  $(".lager_rp_name").click(function(){
    $(".nav-md ").addClass("modal-open-2");
  });
});	

$(document).ready(function(){
  $(".lager_rp_name").click(function(){
    $(".ledger-1 ").addClass("modal-open-3");
  });
});		

$(document).on("click",".lager_rp_name",function(){
		var ledger_party_id = $(this).attr('data-id');
		var data_type_transaction = $(this).attr('data-type-transaction');
		var login_user_id = $('#login_user_id').val();
		var account_payable_side_cls = $('#account_payable_side').val();
		var p_name = $(this).text();
		
		setTimeout(function(){
			$('.party_nname').html(p_name);	
		}, 1200);
		var url = '';
		$.ajax({
			type: "POST",
			//url: site_url+'account/get_ledger_account_detials_forledger_rport/',
			url: site_url+'account/get_ledger_account_detials/',
		   data: {ledger_party_id:ledger_party_id,login_user_id:login_user_id,data_type_transaction:data_type_transaction,start:'',end:''}, 
			success: function(data){
			
				if(data != '') {
					$("#ledger_modal").modal({
						show:false,
						backdrop:'static'
					});
				if($('#ledger_modal').length){
					$('#ledger_modal').modal('toggle');
					$('#ledger_modal .modal-body-content').html(data);		
				}else{
					$('#common_modal').modal('toggle');
					$('#common_modal .modal-body-content').html(data);
				}
				$(function() {
					$('input[name="tabbingFilters33"]').daterangepicker({
						opens: 'left',
					    useCurrent: true,
						locale: {	  
							format: 'DD-MM-YYYY',
						},
						}, function(start, end, label) {
							var filterUrl = $('#tabbingFilters33').attr('data-table');
							var url = site_url +filterUrl;
							$('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
							$('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
								
						  });  
						});
						close_modal_Script();
						Date_range_filter_apply_btn();
						$('#ledger_rprt').DataTable();
						//genrate_pdf_button_click();
						
					/*$('#ledger_modal').modal('toggle');
					$('#ledger_modal .modal-body-content').html(data);*/
					$('.party_nname').html(p_name);	
					$('#p_idd').val(ledger_party_id);
					if(account_payable_side_cls == 'yes'){
						$('.check_payable').hide();
					}
				
						setTimeout(function(){
							Add_crdit_debit();
							$('.data_tbl2').fadeIn(2000);
							 $('#clicked_ledger_idds').val(ledger_party_id);
						}, 1000);
						 
					
						
				}
			}
		}); 
	});	
function Date_range_filter_apply_btn(){
	$('.applyBtn').on('click', function(){
		
		setTimeout(function(){
			var startDate = $('.start_date').val();
			var endDate =  	$('.end_date').val();
			//alert(endDate);
			var ledger_party_id = $('#clicked_ledger_idds').val();
			var login_user_id = $('#login_user_id').val();
			var data_type_transaction = $(this).attr('data-type-transaction');
			var account_payable_side_cls = $('#account_payable_side').val();
			var p_name = $('.party_nname').text();
			$.ajax({
			type: "POST",
			url: site_url+'account/get_ledger_account_detials/',
		    data: {ledger_party_id:ledger_party_id,login_user_id:login_user_id,data_type_transaction:data_type_transaction,start:startDate,end:endDate}, 
			success: function(data){
				if(data != '') {
					if($('#ledger_modal').length){
						//$('#ledger_modal').modal('toggle');
						$('#ledger_modal .modal-body-content').html(data);		
					}else{
						//$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
					
				$(function() {
					  $('input[name="tabbingFilters33"]').daterangepicker({
						opens: 'left',
						 useCurrent: true,
						 locale: {	  
							format: 'DD-MM-YYYY',
						},
					  }, function(start, end, label) {
							var filterUrl = $('#tabbingFilters33').attr('data-table');
							var url = site_url +filterUrl;
							$('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
							$('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
							
					  });  
			});
				//genrate_pdf_button_click();
					/*$('#ledger_modal').modal('toggle');
					$('#ledger_modal .modal-body-content').html(data);		*/
				$('.party_nname').html(p_name);	
				$('#p_idd').val(ledger_party_id);
				if(account_payable_side_cls == 'yes'){
					$('.check_payable').hide();
				}
				
				setTimeout(function(){
					Add_crdit_debit();
					$('.data_tbl2').fadeIn(2000);
					 $('#clicked_ledger_idds').val(ledger_party_id);
				}, 1000);
				 close_modal_Script();
			}
		}
	}); 
		
			
	}, 1000);
		
	});
}	

	
	
//ADD TOTAL on Both Credit and Debit using  
function Add_crdit_debit(){		
		
			var opning_blnance = $('#opning_blnance').val();
			if(isNaN(opning_blnance)) {
					opening_bal = 0;
					}
			var opning_blnc_cr_dr_value = $('#opning_blnc_cr_dr').val();
			var debit_sum = 0;
				$("input[name='debit_amt[]']").each(function() {
					debit_sum +=  parseFloat($(this).val()); 
					});
					
				
					if(isNaN(debit_sum)) {
						debit_sum = 0;
						}
					//$('#debit_total').val(debit_sum.toFixed(2));
					var debit_amt_total = (debit_sum).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');		
					$('#debit_total').val(debit_amt_total);	
			var credit_sum = 0;
			$("input[name='credit_amt[]']").each(function() { //Total Credit Amount
				//sum +=  parseInt($(this).val()); 
				credit_sum +=  parseFloat($(this).val()); 
				});
				
				if(isNaN(credit_sum)) {
					credit_sum = 0;
					}	
				var crdit_amt_total = (credit_sum).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');					
				//$('#credit_total').val(credit_sum.toFixed(2));		
				$('#credit_total').val(crdit_amt_total);		
		
			if(opning_blnc_cr_dr_value == 1){ //opening Balance is in Credit 
				var after_add_opening_bal_credit  = parseFloat(opning_blnance) + parseFloat(credit_sum);
				var bbl = parseFloat(debit_sum) - parseFloat(after_add_opening_bal_credit);
			}
			
			else if(opning_blnc_cr_dr_value == 0){ 
			
				var after_add_opening_bal_debit  = parseFloat(debit_sum) + parseFloat(opning_blnance);
				var bbl = parseFloat(credit_sum) - parseFloat(after_add_opening_bal_debit);
			}
			
			
			else if(opning_blnc_cr_dr_value == ''){ 
				var after_add_opening_bal_debit  = parseFloat(debit_sum) + parseFloat(opning_blnance);
				var bbl = parseFloat(credit_sum) - parseFloat(after_add_opening_bal_debit);
			}  
			
			var num =  Math.abs(bbl);
			// $('#closing_balance').val(num.toFixed(2));
			var Closi_balance = (num).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');
			$('#closing_balance').val(Closi_balance);
			

		
	
}					
//ADD TOTAL on Both Credit and Debit using  	

/***********************************************************************************************************************/
		/*****************************  Get Ledger  SCRIPT START HERE  ******************************************/
/***********************************************************************************************************************/
function Get_Ledger_accodingTo_Parent(){  
	$(document).ready(function(){
		var login_id = $('#getlogin_ids').val();
		$.ajax({
			   type: "POST",
			   url: site_url+'account/Get_Ledgers_according_toParent/',
			   data: {login_id:login_id}, 
			   success: function(htmlStr) {
				  var  obj = JSON.parse(htmlStr);
				  ///alert(JSON.stringify(obj));
				  var len = obj.length;
				
				  for(var i=0; i<len; i++){
						var id = obj[i].id;
						var name = obj[i].name;
						var parent_group_id = obj[i].parent_group_id;
						var sel_data = '<option value="'+id+'" parent_id = "'+ parent_group_id +'">'+name+'</option>';
						$(".opt_Data").append(sel_data); 
						
				  }	
					//alert(len);
				}
			 });
		});
		$('.get_parent_idd').change(function(){
		  	var parent_id = $(this).find(':selected').attr('parent_id');
			$('.parent_group_iddd').val(parent_id);
			
		}); 
		
		
		
	}	
function Get_account_group_or_parent_group_id(){
		$('.parent_drop_down').change(function(){
		  	var parent_id = $(this).find(':selected').attr('parent_id');
			$('#parent_group_id').val(parent_id);
			
		}); 
}

function get_selected_acc_group_value(){
	var selected_acc_value = $('.get_acc_id').find(':selected').val();
	
	if(selected_acc_value == '7' || selected_acc_value == '8'){
		
		//$('.add_multi_address_button').prop('disabled', true);
		$('.company_brnch_div').show();
	}else{
		$('.company_brnch_div').hide();
	}
	    $('.get_acc_id').change(function(){
		  	var selected_acc_value = $(this).find(':selected').val();
			//alert(selected_acc_value);
			if(selected_acc_value == '7' || selected_acc_value == '8'){
				$('.company_brnch_div').show();
				$('.add_multi_address_button').prop('disabled', true);
				var login_company_id = $('#getlogin_company_ids').val();
			$.ajax({
			   type: "POST",
			   url: site_url+'account/get_company_address/',
			   data: {login_c_id:login_company_id}, 
			   success: function(htmlStr) {
				  
				    var  obj = JSON.parse(htmlStr);
					
					var len = obj.length;
					
   			    	 if(len == 1){
						//var  obj = JSON.parse(htmlStr);
						var address1 =	obj[0]['mailing_add'];
						var country_id1 =	obj[0]['country_id'];
						var state1 =	obj[0]['state_id'];
						var city1 =	obj[0]['city_id'];
						var postal_zipcode1 =	obj[0]['postal_zipcode'];
						var compny_branch_name1 =	obj[0]['city_id'];
						var city_name =	obj[0]['city_name'];
						var country_name =	obj[0]['country_name'];
						var state_name =	obj[0]['state_name'];
						$('.country_id').html('<option value="'+ country_id1 +'">'+ country_name +'</option>');
						$('.state_id').html('<option value="'+ state1 +'">'+ state_name +'</option>');
						$('.city_id').html('<option value="'+ city1 +'">'+ city_name +'</option>');
						$('#mailing_address').val(address1);
						$('#mailing_pincode').val(postal_zipcode1);
						$('.add_multi_address_button').prop('readonly', true);
						// $(".country_id").prop("readonly", true);
						// $(".state_id").prop("readonly", true);
						// $(".city_id").prop("readonly", true);
						$("#mailing_address").prop("readonly", true);
						$("#mailing_pincode").prop("readonly", true);
					 }				
				
					
				}
			 });
		}else{
				$('.company_brnch_div').hide();
			}
		}); 
	
}

function get_add_according_unit(){
	
	$('.select_company_branch').change(function(){
		var selected_unit_id = $(this).find(':selected').val();
		//alert(selected_unit_id);  
		//var login_company_id = $('#getlogin_company_ids').val();
		$('.add_multi_address_button').prop('disabled', true);
			$.ajax({
			   type: "POST",
			   url: site_url+'account/get_company_unit_address/',
			   data: {selected_unit_id:selected_unit_id}, 
			   success: function(result) {
					var  obj = JSON.parse(result);
					
					var address1 =	obj[0]['mailing_add'];
					var compny_branch_name =	obj[0]['compny_branch_name'];
						var country_id1 =	obj[0]['country_id'];
						var state1 =	obj[0]['state_id'];
						var city1 =	obj[0]['city_id'];
					var postal_zipcode1 =	obj[0]['postal_zipcode'];
					var company_gstin =	obj[0]['company_gstin'];
					var compny_branch_name1 =	obj[0]['city_id'];
					var city_name =	obj[0]['city_name'];
					var country_name =	obj[0]['country_name'];
					var state_name =	obj[0]['state_name'];
					$('.country_id').html('<option value="'+ country_id1 +'">'+ country_name +'</option>');
					$('.state_id').html('<option value="'+ state1 +'">'+ state_name +'</option>');
					$('.city_id').html('<option value="'+ city1 +'">'+ city_name +'</option>');
					$('#mailing_address').val(address1);
					$('#mailing_name').val(compny_branch_name);
					$('#mailing_pincode').val(postal_zipcode1);
					$('#gstin_no').val(company_gstin);
					$('.add_multi_address_button').prop('disabled', true);
					// $(".country_id").css( {"pointer-events": "none!important"} );
					// $(".state_id").css( {"pointer-events": "none!important"});
					// $(".city_id").css( {"pointer-events": "none!important"} );
					$("#mailing_address").prop("readonly", true);
					$("#mailing_pincode").prop("readonly", true);
					$("#mailing_name").prop("readonly", true);
					
					$("#gstin_no").prop("readonly", true);
				}
			})   
			   
		// var branch_GST = $('.select_company_branch option:selected').attr('data-gst');
		// $('#branch_gst').val(branch_GST);
	
	
	
	
	});
}




function get_selected_company_branch_value(){
		$('.select_company_branch').change(function(){
			var selected_company_branch_value = $(this).find(':selected').val();
			$('#acc_selected_value').val(selected_company_branch_value);
		});
	/*Script to add validation if user add  opening balance its credit debit field requried*/
		jQuery('#opening_balance').keyup(function() {
			var open_blnc_val = $(this).val().length;
			if(open_blnc_val >= 0){
			
				$("#radio_id_btn").prop('required',true);
			}else{
			
				$("#radio_id_btn").prop('required',false);
			}
			
		});
		$('#radio_id_btn').click(function(){
			//alert('dfdfd');
            if($(this).prop("checked") == true){
               $("#opening_balance").prop('required',true);
            }
            else if($(this).prop("checked") == false){
               $("#opening_balance").prop('required',false);
            }
        });
  /*Script to add validation if user add  opening balance its credit debit field requried*/
 }

/****************************************************************************************************************************************************/
		/************************************************  Get connected Company START HERE    **************************************************/
/**************************************************************************************************************************************************/

function Get_connected_company(){
	$(document).ready(function(){
		var login_company_id = $('#getlogin_company_ids').val();
		$.ajax({
			   type: "POST",
			   url: site_url+'account/Get_connected_company_ctrller/',
			   data: {login_company_id:login_company_id}, 
			   success: function(htmlStr) {
				  var  obj = JSON.parse(htmlStr);
				  var len = obj.length;
				  // 
				 for(var i=0; i<len; i++){
						var id = obj[i].id;
						var name = obj[i].name;
						var sel_data = '<option value="'+id+'">'+name+'</option>';
						$(".connected_company_data").append(sel_data); 
				  }	
					//alert(len);
				}
			 });
		});
	}
	
/*******************************************************************************************************************************************************/
		/************************************************* GSTR1 GSTR-3B Month Selector ********************************************************/
/***********************************************************************************************************************************************************/

$(function() {
	$('input[name="start_date_filter"]').daterangepicker({
		singleDatePicker: true,
		singleClasses: "picker_3",								
		locale: {
			  format: 'YYYY-MM',
		}
	}, function(start, end, label) {
		$('input[type=search]').val(start.format('YYYY-MM'));  	  	
		$('input[type=search]').keyup();
	});
});

//Print Function
//Print Function
function printData(){
	$('.comp_name').show();
	  $('.pagination').hide();
	  $('.dataTables_info').hide();
	  $('.dataTables_length').hide();
	  $('.dataTables_filter').hide();
	  $('.hidde').hide();
	  $('.btn-group').hide();
   var divToPrint=document.getElementById("print_div_content");
   
   // newWin= window.open("");
   // newWin.document.write(divToPrint.outerHTML);
   // newWin.print();
   // newWin.close();
   // location.reload();
   
     var newWin=window.open('','Print-Window');
		 newWin.document.open();
		 newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
		 newWin.document.close();
		 setTimeout(function(){newWin.close();},10);
		 newWin.close();
		 
		 location.reload();
}
$('#bbtn').on('click',function(){

printData();

})
//Print Function
/*********************************************************************************************************************************************/
		/************************************* Sale Register and purchase register script ******************************************/
/**************************************************************************************************************************************/

$(document).ready(function() {
    
    $('#example').dataTable({
		
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(),data;
  
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
  
            // computing column Total of the complete result
			
			var tttl = api
                .column( 3 , { page: 'current'}  )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                },0);
				var tttl_com_sep = tttl.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
			$('.totlamt').html(tttl_com_sep);
			
			var taxx = api
                .column( 4 , { page: 'current'}  )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                },0);
				var tx_cls_com_sep = taxx.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
			$('.tx_cls').html(tx_cls_com_sep);
			
			var totl_taxx = api
                .column( 5 , { page: 'current'}  )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                },0);
				var total_taX_com_sep = totl_taxx.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
			$('.totltxamt').html(total_taX_com_sep);
			
			
		
		},
		destroy: true,
        searching: false
           
    } );


	
});
/* Save Financial Year Date*/
$(function() {
  $('input[name="financial_year_date"]').daterangepicker({
    opens: 'left',
	 useCurrent: true
  }, function(start, end, label) {
	    var filterUrl_f_year = $('#financial_year_date').attr('data-table');
		var url = site_url +filterUrl_f_year;
        $.ajax({
		   type: "POST",
		   url: url,
		    data: {start:start.format('YYYY-MM-DD 00:00:00'),end:end.format('YYYY-MM-DD 23:59:59')}, 
		   success: function(htmlstr){
			if(htmlstr == 'true'){
				$('#message_Sucess').fadeIn();
				$('#message_Sucess').html('Date Added Successfully.');
			}
			
			setTimeout(function(){ $('#message_Sucess').fadeOut(); }, 2000);
		  
				
		   }
		});
	});  
});
/* Save Financial Year Date*/
//Get Quantity Details 
$(document).on("click",".get_quantity_details",function(){ 
		var id = $(this).attr('inv-id');
		var url = 'account/get_quantity_calulation_and_more';
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(htmlStr){
				//alert(htmlStr);
				if(htmlStr != '') {
					$('#Quantity_details').modal('toggle');
					$('#Quantity_details .modal-body-content').html(htmlStr);	
						
						}
					}
				}); 
	});	
//Get Quantity Details 

$(function() {
	
  $('input[name="sale_purchase_reg"]').daterangepicker({
    opens: 'left',
	 useCurrent: true
  }, function(start, end, label) {
		var filterUrl = $('#sale_purchase_reg').attr('data-table');
		var url = site_url +filterUrl;
		
		$('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
		$('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
	
		$.ajax({
		   type: "POST",
		   url: url,
		   data: {start:start.format('YYYY-MM-DD 00:00:00'),end:end.format('YYYY-MM-DD 23:59:59')}, 
		   success: function(htmlStr){
			//  alert(htmlStr);
			 	$('.get_Data_fortbl').html(htmlStr);
				
				$('.table-striped').DataTable( {
					destroy: true,
					searching: true
				} );		
				$('.datePick').eq(1).hide();
				$('.addBtn').eq(1).hide();
				
				$('.chks').eq(0).hide();
				$('#add').hide();
				$('#myTab').hide();
				$('.table').eq(1).removeClass('table-bordered');
				
				$('.dropdown-toggle').eq(2).hide();
				$('.x_content').eq(1).hide();
				$('.table-dark').eq(1).hide();
				$('.boot_strp_Data').hide();
				$('.php_ddta').show();
				
		   }
		});
	
	
	
  });  
});



/****************************************************************************************************************************************************/
		/******************************* Sale Register and purchase register script *******************************************************/
/******************************************************************************************************************************************************/


/*---------------Sale target filter by month and year for Gstr3b and GSTR1 ------------------------*/


function isconfirm(url_val){
    if(confirm('Are you sure Want default Financial date Settings ?') == false)
    {
        return false;
    }else{
        location.href=url_val;
    }
}
// $(document).on("change",".Get_data_accoriding_tobranch",function(){ 
		// var select_branch_id = $(this).find(':selected').val();
		// $('#brnch_id').val(select_branch_id);
		// setTimeout(function(){	
			// $('#select_from_brnch').submit();
		// }, 1000);
// })

$(document).on("change",".change_status_2",function(){ 
		if($(this).prop("checked") == true){
       $('#email_send_setting').val('email_send');
	    // $('#myTab .firstt').removeClass('active');
		// $('#myTab .thirdd').addClass('active');
		}else{
		    $('#email_send_setting').val('email_not_send');
		  //  $('#myTab .firstt').removeClass('active');
		  //  $('#myTab .thirdd').addClass('active');
		}
		setTimeout(function(){	
			$('#form_email_Send_settings').submit();
		}, 1000);
});
$(document).on("change",".change_status_discount",function(){ 
		if($(this).prop("checked") == true){
		 $('#discount_on_off').val('1');
	    }else{
		    $('#discount_on_off').val('0');
		}
		setTimeout(function(){	
			$('#discount_on_off').submit();
		}, 1000);
});
$(document).on("change",".change_status_location",function(){ 
		if($(this).prop("checked") == true){
		 $('#multi_loc_on_off').val('1');
	    }else{
		    $('#multi_loc_on_off').val('0');
		}
		setTimeout(function(){	
			$('#multi_loc_on_off').submit();
		}, 1000);
});

$(document).on("change",".change_status_item_code",function(){ 
		if($(this).prop("checked") == true){
		 $('#item_code_on_off').val('1');
	    }else{
		    $('#item_code_on_off').val('0');
		}
		setTimeout(function(){	
			$('#item_code_on_off1').submit();
		}, 1000);
});	
$(document).on("change",".change_status_cancel_restor",function(){ 
		if($(this).prop("checked") == true){
		 $('#invoice_cancl_restor').val('1');
	    }else{
		    $('#invoice_cancl_restor').val('0');
		}
		setTimeout(function(){	
			$('#invoice_cancl_restor_form1').submit();
		}, 1000);
});		



/******************************************************************invoice consignee address hide show*************************************************************/
function consigneeCheck(){
 $('#consignee_address_check').click(function(){	
	  if($(this).prop("checked") == true){
		$('#consignee_address').show();
	  }else if($(this).prop("checked") == false){
	   $('#consignee_address').hide();
    }
 });
}

(function ($) {
    $.fn.EasyTree = function (options) {
        var defaults = {
            selectable: true,
            deletable: false,
            editable: false,
            addable: false,
            i18n: {
                deleteNull: 'Select a node to delete',
                deleteConfirmation: 'Delete this node?',
                confirmButtonLabel: 'Okay',
                editNull: 'Select a node to edit',
                editMultiple: 'Only one node can be edited at one time',
                addMultiple: 'Select a node to add a new node',
                collapseTip: 'collapse',
                expandTip: 'expand',
                selectTip: 'select',
                unselectTip: 'unselet',
                editTip: 'edit',
                addTip: 'add',
                deleteTip: 'delete',
                cancelButtonLabel: 'cancel'
            }
        };

        var warningAlert = $('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong></strong><span class="alert-content"></span> </div> ');
        var dangerAlert = $('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong></strong><span class="alert-content"></span> </div> ');

        var createInput = $('<div class="input-group"><input type="text" class="form-control"><span class="input-group-btn"><button type="button" class="btn btn-default btn-success confirm"></button> </span><span class="input-group-btn"><button type="button" class="btn btn-default cancel"></button> </span> </div> ');

        options = $.extend(defaults, options);

        this.each(function () {
            var easyTree = $(this);
            $.each($(easyTree).find('ul > li'), function() {
                var text;
                if($(this).is('li:has(ul)')) {
                    var children = $(this).find(' > ul');
                    $(children).remove();
                    text = $(this).text();
                    $(this).html('<span><span class="glyphicon"></span><a href="javascript: void(0);"></a> </span>');
                    $(this).find(' > span > span').addClass('glyphicon-folder-open');
                    $(this).find(' > span > a').text(text);
                    $(this).append(children);
                }
                else {
                    text = $(this).text();
                    $(this).html('<span><span class="glyphicon"></span><a href="javascript: void(0);"></a> </span>');
                    $(this).find(' > span > span').addClass('glyphicon-file');
                    $(this).find(' > span > a').text(text);
                }
            });

            $(easyTree).find('li:has(ul)').addClass('parent_li').find(' > span').attr('title', options.i18n.collapseTip);

            // add easy tree toolbar dom
            if (options.deletable || options.editable || options.addable) {
                $(easyTree).prepend('<div class="easy-tree-toolbar"></div> ');
            }

            // addable
            if (options.addable) {
                $(easyTree).find('.easy-tree-toolbar').append('<div class="create"><button class="bt/ btn-default btn-sm btn-success disabled"><span class="glyphicon glyphicon-plus"></span></button></div> ');
                $(easyTree).find('.easy-tree-toolbar .create > button').attr('title', options.i18n.addTip).click(function () {	
                    var createBlock = $(easyTree).find('.easy-tree-toolbar .create');
                    $(createBlock).append(createInput);
                    $(createInput).find('input').focus();
                    $(createInput).find('.confirm').text(options.i18n.confirmButtonLabel);
                    $(createInput).find('.confirm').click(function () {						
                        if ($(createInput).find('input').val() === '')
                            return;
                        var selected = getSelectedItems();
                        var item = $('<li><span><span class="glyphicon glyphicon-file"></span><a href="javascript: void(0);">' + $(createInput).find('input').val() + '</a> </span></li>');
                        $(item).find(' > span > span').attr('title', options.i18n.collapseTip);
                        $(item).find(' > span > a').attr('title', options.i18n.selectTip);
                        if (selected.length <= 0) {
                            $(easyTree).find(' > ul').append($(item));
                        } else if (selected.length > 1) {
                            $(easyTree).prepend(warningAlert);
                            $(easyTree).find('.alert .alert-content').text(options.i18n.addMultiple);
                        } else {
                           // if ($(selected).hasClass('parent_li') || $(selected).hasClass('mainParentName') ) {								
                            if ($(selected).hasClass('parent_li')) {								
								var accountId = $(selected).attr('data-account-id');
								var parentLi = $(selected).closest('.mainParentName');
								//var parentId = $(parentLi).attr('data-parent-id');
								var parentId = $(parentLi).attr('id');								
								var createdLedgerAccountName = $(createInput).find('input').val();								
								if( typeof accountId !== 'undefined' ) {
									var ajaxData = {'name':createdLedgerAccountName , 'account_group_id':accountId , 'parent_group_id': parentId,'table':'ledger'};	
								}else{									
									var ajaxData = {'name':createdLedgerAccountName , 'parent_group_id': parentId,'table':'account_group'};
								}	
									/*  code to create ledger or account */
										$.ajax({
											url: site_url +'account/createLedgerAccountViaAjax/',
											dataType: 'json',
											type: 'POST',
											data: ajaxData,
											success: function(response){
												if(response.status == 'success'){
														$(selected).find(' > ul').append(item);													
												}
											}
										});	
								
                            }else {
								var accountId = $(selected).attr('data-account-id');
								var parentLi = $(selected).closest('.mainParentName');
								var parentId = $(parentLi).attr('id');								
								var createdLedgerAccountName = $(createInput).find('input').val();								
									var ajaxData = {'name':createdLedgerAccountName , 'account_group_id':accountId , 'parent_group_id': parentId,'table':'ledger'};	
									/*  code to create ledger or account */
										$.ajax({
											url: site_url +'account/createLedgerAccountViaAjax/',
											dataType: 'json',
											type: 'POST',
											data: ajaxData,
											success: function(response){
												if(response.status == 'success'){
													$(selected).addClass('parent_li').find(' > span > span').addClass('glyphicon-folder-open').removeClass('glyphicon-file');
													$(selected).append($('<ul></ul>')).find(' > ul').append(item);
												}
											}
										});	
                            }
                        }
                        $(createInput).find('input').val('');
                        if (options.selectable) {
                            $(item).find(' > span > a').attr('title', options.i18n.selectTip);
                            $(item).find(' > span > a').click(function (e) {
                                var li = $(this).parent().parent();
                                if (li.hasClass('li_selected')) {
                                    $(this).attr('title', options.i18n.selectTip);
                                    $(li).removeClass('li_selected');
                                }
                                else {
                                    $(easyTree).find('li.li_selected').removeClass('li_selected');
                                    $(this).attr('title', options.i18n.unselectTip);
                                    $(li).addClass('li_selected');
                                }

                                if (options.deletable || options.editable || options.addable) {
                                    var selected = getSelectedItems();
                                    if (options.editable) {
                                        if (selected.length <= 0 || selected.length > 1)
                                            $(easyTree).find('.easy-tree-toolbar .edit > button').addClass('disabled');
                                        else
                                            $(easyTree).find('.easy-tree-toolbar .edit > button').removeClass('disabled');
                                    }

                                     /* if (options.deletable) {
                                        if (selected.length <= 0 || selected.length > 1)
                                            $(easyTree).find('.easy-tree-toolbar .remove > button').addClass('disabled');
                                        else
                                            $(easyTree).find('.easy-tree-toolbar .remove > button').removeClass('disabled');
                                    } */

                                }

                                e.stopPropagation();

                            });
                        }
                        $(createInput).remove();
                    });
                    $(createInput).find('.cancel').text(options.i18n.cancelButtonLabel);
                    $(createInput).find('.cancel').click(function () {
                        $(createInput).remove();
                    });
                });
            }

            // editable
            if (options.editable) {
                $(easyTree).find('.easy-tree-toolbar').append('<div class="edit"><button class="btn btn-default btn-sm btn-primary disabled"><span class="glyphicon glyphicon-edit"></span></button></div> ');
                $(easyTree).find('.easy-tree-toolbar .edit > button').attr('title', options.i18n.editTip).click(function () {
                    $(easyTree).find('input.easy-tree-editor').remove();
                    $(easyTree).find('li > span > a:hidden').show();
                    var selected = getSelectedItems();
                    if (selected.length <= 0) {
                        $(easyTree).prepend(warningAlert);
                        $(easyTree).find('.alert .alert-content').html(options.i18n.editNull);
                    }
                    else if (selected.length > 1) {
                        $(easyTree).prepend(warningAlert);
                        $(easyTree).find('.alert .alert-content').html(options.i18n.editMultiple);
                    }
                    else {
                        var value = $(selected).find(' > span > a').text();
                        $(selected).find(' > span > a').hide();
                        $(selected).find(' > span').append('<input type="text" class="easy-tree-editor">');
                        var editor = $(selected).find(' > span > input.easy-tree-editor');						
                        $(editor).val(value);
                        $(editor).focus();
                        $(editor).keydown(function (e) {
                            if (e.which == 13) {
                                if ($(editor).val() !== '') {
									var closestLi = $(this).closest("li");
									console.log('closestLi===/>>',closestLi);
									if($(closestLi).hasClass('ledgerName') || $(closestLi).hasClass('mainAccountName')){
										var editorVal = $(editor).val();
										if($(closestLi).hasClass('ledgerName')){
											var data_id = $(closestLi).attr('data-ledger-id');
											var ajaxData = {'name':editorVal , 'id':data_id , 'table':'ledger'};								
										}
										if($(closestLi).hasClass('mainAccountName')){
											var data_id = $(closestLi).attr('data-account-id');
											var ajaxData = {'name':editorVal , 'id':data_id, 'table':'account_group'};
										}
										/*   ajax call to edit ledger in db */										
											$.ajax({
												url: site_url +'account/updateLedgerGroupNameViaAjax/',
												dataType: 'json',
												type: 'POST',
												data: ajaxData,
												success: function(response){
													if(response.status == 'success'){
														$(selected).find(' > span > a').text($(editor).val());
														$(editor).remove();
														$(selected).find(' > span > a').show();
													}
												}
											});										
									}																	
                                }
                            }
                        });
                    }
                });
            }

            // deletable
        /*    if (options.deletable) {
                $(easyTree).find('.easy-tree-toolbar').append('<div class="remove"><button class="btn btn-default btn-sm btn-danger disabled"><span class="glyphicon glyphicon-remove"></span></button></div> ');
                $(easyTree).find('.easy-tree-toolbar .remove > button').attr('title', options.i18n.deleteTip).click(function () {
                    var selected = getSelectedItems();
                    if (selected.length <= 0) {
                        $(easyTree).prepend(warningAlert);
                        $(easyTree).find('.alert .alert-content').html(options.i18n.deleteNull);
                    } else {
                        $(easyTree).prepend(dangerAlert);
                        $(easyTree).find('.alert .alert-content').html(options.i18n.deleteConfirmation)
                            .append('<a style="margin-left: 10px;" class="btn btn-default btn-danger confirm"></a>')
                            .find('.confirm').html(options.i18n.confirmButtonLabel);
                        $(easyTree).find('.alert .alert-content .confirm').on('click', function () {
                            $(selected).find(' ul ').remove();
                            if($(selected).parent('ul').find(' > li').length <= 1) {
                                $(selected).parents('li').removeClass('parent_li').find(' > span > span').removeClass('glyphicon-folder-open').addClass('glyphicon-file');
                                $(selected).parent('ul').remove();
                            }
                            $(selected).remove();
                            $(dangerAlert).remove();
                        });
                    }
                });
            } */
			
			
		
			
			
			
			

            // collapse or expand
            $(easyTree).delegate('li.parent_li > span ', 'click', function (e) {
                var children = $(this).parent('li.parent_li').find(' > ul > li');
                if (children.is(':visible')) {
                    children.hide('fast');
                    $(this).attr('title', options.i18n.expandTip)
                        .find(' > span.glyphicon')
                        .addClass('glyphicon-folder-close')
                        .removeClass('glyphicon-folder-open');
                } else {
                    children.show('fast');
                    $(this).attr('title', options.i18n.collapseTip)
                        .find(' > span.glyphicon')
                        .addClass('glyphicon-folder-open')
                        .removeClass('glyphicon-folder-close');
                }
                e.stopPropagation();
            });

            // selectable, only single select
            if (options.selectable) {
                $(easyTree).find('li > span > a').attr('title', options.i18n.selectTip);
                $(easyTree).find('li > span > a').click(function (e) {
                    var li = $(this).parent().parent();
                    if (li.hasClass('li_selected')) {
                        $(this).attr('title', options.i18n.selectTip);
                        $(li).removeClass('li_selected');
                    }
                    else {
                        $(easyTree).find('li.li_selected').removeClass('li_selected');
                        $(this).attr('title', options.i18n.unselectTip);
                        $(li).addClass('li_selected');
                    }

                    if (options.deletable || options.editable || options.addable) {
                        var selected = getSelectedItems();
						
						if (options.addable) {
                          //  if (selected.length <= 0 || selected.length > 1 || $(selected).hasClass('mainParentName') || $(selected).hasClass('ledgerName'))
                            if (selected.length <= 0 || selected.length > 1  || $(selected).hasClass('ledgerName'))
                                $(easyTree).find('.easy-tree-toolbar .create > button').addClass('disabled');
                            else
                                $(easyTree).find('.easy-tree-toolbar .create > button').removeClass('disabled');
                        }
						
                        if (options.editable) {
                            if (selected.length <= 0 || selected.length > 1 || $(selected).hasClass('mainParentName') )
                                $(easyTree).find('.easy-tree-toolbar .edit > button').addClass('disabled');
                            else
                                $(easyTree).find('.easy-tree-toolbar .edit > button').removeClass('disabled');
                        }

                        if (options.deletable) {
                            if (selected.length <= 0 || selected.length > 1  || $(selected).hasClass('mainParentName') || $(selected).hasClass('mainAccountName'))
                                $(easyTree).find('.easy-tree-toolbar .remove > button').addClass('disabled');
                            else
                                $(easyTree).find('.easy-tree-toolbar .remove > button').removeClass('disabled');
                        }

                    }

                   // e.stopPropagation();

                });
            }

            // Get selected items
            var getSelectedItems = function () {
				//console.log('jjjj====>>>>',$(easyTree).find('li.li_selected'));
                return $(easyTree).find('li.li_selected');
            };
        });
    };
})(jQuery);
	
(function ($) {
        function init() {
            $('.easy-tree').EasyTree({
                addable: true,
                editable: true,
                deletable: true
            });
        }

        window.onload = init();
    })(jQuery)	
	
	
	
	
/*    Call dashboard graph functions    */	
$(document).ready(function() {	
	dashboardPurchaseExpense();
	dashboardMaterialSale();
	dashboardPaymentReceivedDone();
});


/*   income expense dashboard graph      */
function dashboardPurchaseExpense(startDate = '' , endDate = ''){
	if ($('#graph_income_expanse').length ){
		if(startDate!='' && endDate!=''){
			ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			ajaxData = {};
		}	
		$("#graph_income_expanse").empty();			
				$.ajax({   
					url: site_url +'account/monthWiseIncomeExpenseAmountGraph/',
					dataType: 'json',
					type: 'POST',
					data:   ajaxData,
					success: function(result){
						 result = result.monthWiseIncomeExpenseAmountGraph;
							incomeExpensePriceJsonObj = [];
							$(result).each(function() {
								item = {}
								item ["period"] = $(this)[0].month;
								item ["expense"] = $(this)[0].expense;
								item ["income"] = $(this)[0].income;
								incomeExpensePriceJsonObj.push(item);
							});
							Morris.Bar({
							  element: 'graph_income_expanse',
							  data: incomeExpensePriceJsonObj,
							  xkey: 'period',
							  barColors: ['#26B99A', '#3498db', '#ACADAC', '#3498DB'],
							  ykeys: ['income', 'expense'],
							  labels: ['Income', 'Expense'],
							  hideHover: 'auto',
							  xLabelAngle: 60,
							  resize: true
							}); 
					}

				});
			}

}

/*   Material sale dashboard graph      */
	function dashboardMaterialSale(startDate = '' , endDate = ''){		
	$("#graph_material_sale").empty();		
		if ($('#graph_material_sale').length ){
			if((startDate!='') && (endDate!='')){ 
				ajaxData = {'startDate':startDate , 'endDate':endDate};
			}else{
				ajaxData = {};
			}
			$.ajax({   
				url: site_url +'account/monthWiseIncomeExpenseAmountGraph/',
				dataType: 'json',
				type: 'POST',
				data:   ajaxData,
				success: function(result){
						result = result.materialSaleAmountGraph;					
						materialSaleAmountJsonObj = [];
						$(result).each(function() {
							item = {}
							item ["label"] = $(this)[0].matarial_name;
							item ["value"] = $(this)[0].amount;
							materialSaleAmountJsonObj.push(item);
						});							
							Morris.Donut({
							  element: 'graph_material_sale',								
							  data: materialSaleAmountJsonObj,
							  colors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
							  formatter: function (y) {
								return y + " Rs";
							  },
							  resize: true
							});
				}
			});
		}	
	}
	
	
/*   Payment done and received dashboard graph   */	
	function dashboardPaymentReceivedDone(startDate = '' , endDate = ''){	
		$("#graph_payment_received_done").empty();		
		if ($('#graph_payment_received_done').length ){
			if(startDate!='' && endDate!=''){
				ajaxData = {'startDate':startDate , 'endDate':endDate};
			}else{
				ajaxData = {};
			}
			$.ajax({   
				url: site_url +'account/monthWiseIncomeExpenseAmountGraph/',
				dataType: 'json',
				type: 'POST',
				data:  ajaxData,
				success: function(result){
						result = result.monthWiseCashFlowGraph;
							monthWiseCashFlowGraphJsonObj = [];
							$(result).each(function() {
								item = {}
								item ["period"] = $(this)[0].month;
								item ["paymentReceived"] = $(this)[0].paymentReceived;
								item ["paymentDone"] = $(this)[0].paymentDone;
								monthWiseCashFlowGraphJsonObj.push(item);
							});
							
							Morris.Bar({
							  element: 'graph_payment_received_done',
							  data: monthWiseCashFlowGraphJsonObj,
							  xkey: 'period',
							  barColors: ['#26B99A', '#3498db', '#ACADAC', '#3498DB'],
							  ykeys: ['paymentReceived', 'paymentDone'],
							  labels: ['Payment Received', 'Payment Done'],
							  hideHover: 'auto',
							  xLabelAngle: 60,
							  resize: true
							}); 
				}
			});
		}	
	}
	
	
	/*  Dashboard filteration data */
$('.dashboardFilter').daterangepicker({
    opens: 'left',
	useCurrent: true,
	locale: {
	    format: 'YYYY-MM',
	},	
  }, function(start, end, label) {  
		var startDate = start.format('YYYY-MM-00 00:00:00');
		var endDate = end.format('YYYY-MM-00 23:59:59');		
		var dateRangeHtml = $(this)[0].element.context;			
		$("#graph_income_expanse").empty();
		dashboardPurchaseExpense(startDate ,endDate);		
		$("#graph_material_sale").empty();
		dashboardMaterialSale(startDate ,endDate);		
		$("#graph_payment_received_done").empty();
		dashboardPaymentReceivedDone(startDate ,endDate);
  });  

  
    //   Function to show the modal with disapprove reasonof sale order of CRM
$('.graphCheckbox').click(function(e){
	var show = 0;
	if ($(this).is(":checked")) show = 1;
	else show = 0;
	var graph_id = $(this).attr('id');
	var ajaxData = {'graph_id':graph_id , 'show':show};
	$.ajax({
		url: site_url +'account/showDashboardOnRequirement/',
		dataType: 'json',
		type: 'POST',
		data: ajaxData,
		success: function(response){
			console.log('response===>>>>',response);
		}
	});
	});

	/*
	
$(document).ready(function(){
   if ($("#addMore > tr").length > 5)
	   alert("fsd");
      $("#button").show();
   else
	   alert("fdsf");
      $("#button").hide();
});*/
function countChar(val) {
       var len = val.value.length;
	   var max = 410;
       if (len >= max) {
         val.value = val.value.substring(0, 410);
		  $('#charNum').text(' You have reached the limit');
       } else {
         $('#charNum').text(410 - len);
		 var chaer = max - len;
		  $('#charNum').text(chaer + ' characters left');
       }
     };

/*********************************************************acccount freeze**************************************************************/
function date_freeze_select(){
 $( function() {
    //$( "#freeze_date" ).datepicker();
	// $('#freeze_date').datepicker({
        //format: 'mm-dd-yyyy',
        // format: 'yyyy-mm-dd',
        // endDate: '+0d',
        // autoclose: true
    // });
	$('#freeze_date').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		changeMonth: true,
		changeYear: true
	});
  });
}

//add freeze account//
$(document).on("click",".addAccountFreeze",function(){	
	//var currentelement = $(this);
	var id = $(this).attr('id');
	var tab = $(this).attr('data-id');
	var url = '';
		console.log("id-",id);
		console.log("dataid-",tab);
		switch (tab) {
			case 'editAccountFreeze':
				url = 'account/editAccountFreeze';
				break;	
							
		}		
	$.ajax({
		type: "POST",
		url: site_url+'account/editAccountFreeze',
		data: {id:id}, 
		success: function(data){
			if(data != '') { 
			$("#add_account_freeze").modal({
						show:false,
						backdrop:'static'
					});
				$('#add_account_freeze').modal('toggle');
				$('#add_account_freeze .modal-body-content').html(data);							
				init_select2();
				date_freeze_select();
				$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
					
		   }
		}
	}); 
});
$(document).on("click",".add_challan_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		switch (tab) {  
			case 'add_challan':
				url = 'account/editdelivery_chln';
				break;	
			case 'challan_view_details':
				url = 'account/viewchalan_details';
				break;						
		}
	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#challan_add_modal").modal({
						show:false,
						backdrop:'static'
				});
					$('#challan_add_modal').modal('toggle');
					$('#challan_add_modal .modal-body-content').html(data);		
					init_select2();
					init_select21();
					init_select221();
					get_add_more_btn_forsale_ledger();
					Add_material_dtl_for_onselect();
					party_name_ledger_id_onchange();
					Calculation_of_challan_mat_details();
					add_more_mat_for_challan();
					sale_ledger_id_onchange();
					close_modal_Script();
					
					//Date Format Change Script	
						$('#challan_date_id').datepicker({
							format: 'dd-mm-yyyy',
							autoclose: true,
							todayHighlight: true,
							changeMonth: true,
							changeYear: true
						});
						//Date Format Change Script		  
					$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
				}
			}
			
		}); 
	});
function Add_material_dtl_for_onselect(){ 
		$('.get_val_challan').on('change',function(){ 		
		 var matrial_select_this =  $(this);
		
		  var selected_id = $(this).val();	
			
				$.ajax({
				   type: "POST",
				   url: site_url+'account/selectMatrial/',
				   data: { id:selected_id}, 
				   success: function(result) {
					  var obj = jQuery.parseJSON(result);
					 
					  var specification_var = obj.specification;
					  var hsn_code_var = obj.hsn_code;
					  var uom_var = obj.uom;
					  var cess_var = obj.cess;
					  
					  var quantity = obj.opening_balance;
					  var rate = obj.sales_price;
					 
					  var mat_idds = obj.id;
					 
					  var TotalAmount = rate*quantity;
					  
					 
					 //console.log('this==>>',$(matrial_select_this).closest('.input_descr_wrap ').find("input[name='tax[]']").val(tax));
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='mat_idd_name']").val(mat_idds);
					
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='descr_of_goods[]']").val(specification_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='hsnsac[]']").val(hsn_code_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='quantity[]']").val(1); 
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='rate[]']").val(rate);
					
					
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='amount[]']").val(0);
					//$(matrial_select_this).closest('.input_descr_wrap').find('select[name="UOM[]"] option[value="' + uom_var + '"]').prop('selected',true);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='UOM[]']").val(uom_var);
					subtotal();
					
					setTimeout(function(){
						$('.keyup_event_challan').keyup();	
					}, 1000);
					
				 }
			 });
		}); 
		
		$('.remove_descr_field_challan').on('click',function(){
			setTimeout(function(){
				$('.keyup_event_challan').keyup();
			}, 1000);
		});	
	}
function Calculation_of_challan_mat_details(){
$('.keyup_event_challan').keyup(function(){
		var matrial_select_this_val =  $(this);
	    var theQuantity = $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		var thePrice = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		
		var with_quantity_price = theQuantity * thePrice;		
		
		var valueww = with_quantity_price.toFixed(2);
		// var valueww = (with_quantity_price).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');
		
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);		
			
		var toal_amount_sum = 0;
			$("input[name='amount[]']").each(function(){
			toal_amount_sum += Number($(this).val());
		});
		
		 $(".challan_total_amt").val(toal_amount_sum);
		var toal_amount_sumamt = (toal_amount_sum).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');
		 $(".challan_total_amt3").val(toal_amount_sumamt);
		
	});
}	
	
function add_more_mat_for_challan(){
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".add-ro"); //Fields wrapper
    var add_button      = $(".add_description_detail_button_challan"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
	    e.preventDefault();
			
			$('.add_requried').prop("disabled", true);
			var company_login_id = $('#company_login_id').val();			
			
			
        if(x < max_fields){ //max input box allowed
            x++; 				
			
				$(wrapper).append('<div class="col-md-12 input_descr_wrap add-ro2 mailing-box mobile-view" style="margin-top:0px; "><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Matrial Name <span class="required">*</span></label><select class="matrial_details_id itemName form-control selectAjaxOption select2 get_val_challan select2-hidden-accessible demoClass" required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='+ company_login_id +' AND status=1" width="100%"></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd">	</div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label><input type="text" name="descr_of_goods[]"  class="form-control col-md-2" placeholder="Description Of Goods" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" required="required" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label><input type="text" required="required"   name="quantity[]" class="form-control col-md-2 year goods_descr_section keyup_event_challan" placeholder="Quantity" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label><div><input type="text" name="rate[]" class="form-control col-md-2 goods_descr_section keyup_event_challan" placeholder="Rate"  value=""></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM[]" class="form-control col-md-2 goods_descr_section"  placeholder="UOM"></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Total Amount<span class="required">*</span></label><div><input type="text" name="amount[]" class="form-control col-md-2 goods_descr_section AMunt" placeholder="Amount" value="" readonly></div></div><button class="btn btn-danger remove_descr_field_challan" type="button"><i class="fa fa-minus"></i></button></div>');
				
					init_select221();
					Add_material_dtl_for_onselect();
					Calculation_of_challan_mat_details();
        }
    });
	
    
    $(wrapper).on("click",".remove_descr_field_challan", function(e){ //user click on remove text
        e.preventDefault();
		$(this).parent('div').remove(); x--;
		setTimeout(function(){
				$('.keyup_event_challan').keyup();	
			}, 1000);
    });	
}	

//ADD Charges LEADs
$(document).on("click",".add_charges_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		
		switch (tab) {  
			case 'add_charges':
				url = 'account/editcharges';
				break;	
			// case 'voucher_view':
				// url = 'account/viewVoucher';
				// break;					
		}
	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#charges_add_modal").modal({
						show:false,
						backdrop:'static'
				});
					//$('#charges_add_modal').modal('toggle');
					$('#charges_add_modal .modal-body-content').html(data);		
					init_select2();
					init_select21();
					close_modal_Script();
					$('form')
							.on('blur', 'input[required], input.optional, select.required', validator.checkField)
							.on('change', 'select.required', validator.checkField)
							.on('keypress', 'input[required][pattern]', validator.keypress);
								$('form').submit(function(e) {
									e.preventDefault();
									var submit = true;
									// evaluate the form using generic validaing
									if (!validator.checkAll($(this))) {
										submit = false;
									}
									if (submit)
										this.submit();
										return false;
								});
				}
			}
			
		}); 
	});
//ADD Charges LEADs







	/*    Gross  Profit & Loss   Calculation in pl page  */
$(document).ready(function(e) { 
	var expenseAmount  = incomeAmount = totalAmount = grossProfit  = grossLoss = netIncome = netProfit = netAmount  = textIncomeAmount =textExpenceAmount = 0;
	$('.expenseAmount').each(function(){
		if($(this).text() == ''){
			textExpenceAmount = 0;
		}else{
			textExpenceAmount = $(this).text();
		}
		expenseAmount += parseFloat(textExpenceAmount);
	});
	$('.incomeAmount').each(function(){
		if($(this).text() == ''){
			textIncomeAmount = 0;
		}else{
			textIncomeAmount = $(this).text();
		}
		incomeAmount += parseFloat(textIncomeAmount);
	});
	
	if(expenseAmount <  incomeAmount){
		grossProfit =  incomeAmount - expenseAmount;
		totalAmount =  grossProfit + expenseAmount;
		$('.total').text(totalAmount);
		$('.plRow').html('<div class="panel-heading col-sm-6" ><h4>Gross Profit : Rs <span class="grossProfit">'+grossProfit+'</span> </h4></div><div class="panel-heading col-sm-6"</div>');
		$('.bdPlRow').html('<div class="panel-heading col-sm-6"></div><div class="panel-heading col-sm-6" ><h4>Gross Profit b/d : Rs <span class="grossProfit">'+grossProfit+'</span> </h4></div>');
	}else{
		grossLoss =  expenseAmount - incomeAmount;
		totalAmount =  grossLoss + incomeAmount;
		$('.total').text(totalAmount);
		$('.plRow').html('<div class="panel-heading col-sm-6"></div><div class="panel-heading col-sm-6" ><h4>Gross Profit : Rs <span class="grossLoss">'+grossLoss+'</span> </h4></div>');
		$('.bdPlRow').html('<div class="panel-heading col-sm-6" ><h4>Gross Loss b/d : Rs <span class="grossLoss">'+grossLoss+'</span> </h4></div><div class="panel-heading col-sm-6"</div>');		
	}
	
	var indirectIncomeAmount = parseFloat($('.indirectIncomeAmount').text());
	var indirectExpenceAmount = parseFloat($('.indirectExpenceAmount').text());	
	netIncome = indirectIncomeAmount + grossProfit ;
	if(indirectExpenceAmount <  netIncome){
		netProfit =  netIncome - indirectExpenceAmount;
		netAmount =  netProfit + indirectExpenceAmount;
		$('.netPlRow').html('<div class="panel-heading col-sm-6" ><h4>Net Profit : Rs <span class="netProfit">'+netProfit+'</span> </h4></div><div class="panel-heading col-sm-6"></div>');
		$('.netTotal').text(netAmount);
	}else{
		netIndirectIncome = grossProfit +indirectIncomeAmount ;
		netLoss =  indirectExpenceAmount - netIndirectIncome;
		netAmount =  netLoss + indirectExpenceAmount;
		$('.netTotal').text(netAmount);
		$('.netPlRow').html('<div class="panel-heading col-sm-6"></div><div class="panel-heading col-sm-6" ><h4>Net Loss : Rs <span class="netLoss">'+netLoss+'</span> </h4></div>');
	}
	
	
	
	/*  Function to show ledger detail in profit & loss  */
	$(".toggle-accordion").on("click", function() {	
		$(' .panel-collapse:not(".in")').collapse('show');
		$('.panel-collapse.in')
		.collapse('hide');
});
});


	/*  Function to print  profit & loss  */



	/*  Function to create PDF in  profit & loss  */
// var doc = new jsPDF();
// var specialElementHandlers = {
    // '#editor': function (element, renderer) {
        // return true;
    // }
// };
// $('.generate_pdf').click(function () {
    // doc.fromHTML($('#containerForPrint').html(), 15, 15, {
        // 'width': 170,
            // 'elementHandlers': specialElementHandlers
    // });
	
    // doc.save('profit_loss.pdf');
// });
function fnValidateGSTIN(Obj) { 
	$("div.alert").remove();
	$('.gstin').parent('div').siblings().remove( '.alert' );
		if (Obj.value != "") {
			ObjVal = Obj.value;
			
			//var gstinPat = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9]{1}?$/;
			//var gstinPat = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9A-Z]{1}?$/;
			var gstinPat = /^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;
			//alert(gstinPat);
			if (ObjVal.search(gstinPat) == -1) {
				 console.log("Invalid GSTIN number");
				 $('.gstin').closest('.item').addClass('bad');				
				
				$('.gstin').closest('.item').append("<div class='alert'>Invalid GSTIN number</div>");
				$(".signUpBtn").attr( "disabled", "disabled" );
				return false;
			}else{
				$(".signUpBtn").removeAttr("disabled");
				$('.gstin').closest('.item').removeClass('bad');	
				console.log("Correct GSTIN No");
			  }
		}
	}
	
/* Show modal for share Generated PDF using email */
$(document).on("click",".sharevia_email_cls",function(){
	$('#myModal_share_email').modal('show');
});

$(document).on("click",".close_sec_model",function(){
	 $('#myModal_share_email').modal('hide');
});


/* Share Via email Script*/
$(document).on("click","#share_via_Email_invoice",function(){	
		var share_email  = $('#email_name').val();
		var invoice_id  = $('#invoice_id').val();
		var email_msg_id  = $('#email_msg_id').val();
		
		var error = 0;
		if(share_email == ''){
				$('#email_name').css('border', '1px solid #b94a48');
				$('#email_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#email_name').css('border', '1px solid #dedede');
				$('#email_name').closest(".form-group").find("span").text('');
			}
		if(error == 1) { 
			return false;
		} else {	
			$.ajax({
				   type: "POST",
				   url: site_url+'account/share_pdf_using_email_invoice/',
				   data: {share_email:share_email,invoice_id:invoice_id,email_msg_id:email_msg_id}, 
				   success: function(htmlStr) {
					if(htmlStr == 'sent'){
						// alert('send Successfully');
						$('#mssg').html('<span style="color:green;">Email Send Successfully.</span>');
						$("#form_share_viaEmail_id").trigger('reset');
						setTimeout(function(){
							$('#myModal_share_email').modal('hide');
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);		
					}else{
						// alert('Not Send Successfully');
						$('#mssg').html('<span style="color:red;">Email Not Send.</span>');
					}
				}
			 });
		}
});	
/* Share Via email Script*/
/* Cancel and REstore */
$(document).on("click",".cancel_and_restore_invoice",function(){ 
		if(confirm('Are you sure!') == true) {
			$.ajax({
			   type: "POST",
			   url: $(this).attr('data-href'),
			   data: {}, 
			   success: function(data) {
				   if(data != '') {
					var obj = $.parseJSON(data);
					   if(obj.status == 'success') {						 
						    window.location.href = obj.url;								
						
				  	   } else {
						    var alertError = '<div id="alert_float_1" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title">'+obj.msg+ ' - '+'('+obj.status+obj.code+')</span></div>';
						   $('.page-title').append(alertError);
						   setTimeout(function() {
								$('#alert_float_1').remove();
							}, 500000);
					   }
				   }
			   }
		 }); 	
		}
	});

$('#day_book_id').DataTable();

$(document).on("click","#invalid_gst",function(){
  $('#gst_form').submit();
  
});
$(document).on("click","#click_hsnsac",function(){
  $('#chk_form').submit();   
});



 $('#create_excel').click(function(){ 
        $('#date_range56').submit();		  
 }); 
 



/* Show modal for share Generated PDF using email */