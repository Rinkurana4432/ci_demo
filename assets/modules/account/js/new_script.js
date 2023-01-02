$('#consignee_address_check').click(function(){	
	  if($(this).prop("checked") == true){
		$('#consignee_address').show();
	  }else if($(this).prop("checked") == false){
	   $('#consignee_address').hide();
    }
 });

 
 

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
							//alert(JSON.stringify(get_state_id));
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
						 //alert(party_billing_state);
						// alert(sale_company_state_idd);
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

					  var uom_name = obj.uom;
						 var uom_id = obj.uomid;
					
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
					
				//		$("#"+closestId+"").find('.uom1').val(dataObj.uom);

          		//		$("#"+closestId+"").find('.uom').val(dataObj.uomid);

       

					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='UOM1[]']").val(uom_name);

					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='UOM[]']").val(uom_id);
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

		setTimeout(function(){
			var grand_total_sum = 0;
			$("input[name='amount[]']").each(function() {
				grand_total_sum += Number($(this).val());
			});
			
			var grand_total_sum = grand_total_sum.toFixed(2);
			//alert(grand_total_sum);
			var charges_total = $('.total_charges_cls').val();
			//alert(charges_total);
			if(charges_total != '' || charges_total != '0.00'){
				
				var testee = (+charges_total) + (+grand_total_sum);
				
				$(".grand_total").val(testee);
				
			}else{
				
				$(".grand_total").val(grand_total_sum);
			}
		}, 1000);
		
		
	    
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
			$('.charges_head_div').show();
			var total_charges_with_tax = 0;
			$("input[name='amt_with_tax[]']").each(function() {
			total_charges_with_tax += Number($(this).val());
			});
			
			$('.total_charges_cls').val(total_charges_with_tax);
			
			var purchase_bill_total = 0;
			$("input[name='amount[]']").each(function() {
			purchase_bill_total += Number($(this).val());
			});
			
			
			var charges_total = (+total_charges_with_tax) + (+purchase_bill_total);
			$('.grand_total').val(charges_total);
		

		}, 800);
	});
		
		
	$('#date12,#date_time_of_invoice_issue,#date_time_removel_of_goods,#dispatch_document_date,#buyer_order_date').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		changeMonth: true,
		changeYear: true
	});	
		
	var invoiceid = $('#invoiceid').val();	
	if(invoiceid != '' ){
		//add_filed_for_goods_descr_invoice();
		   var alerady_tax = $('.tax_class').val();
		   $('.added_tax').val(alerady_tax); 					    
			var matrial_qty_already =  $('.qty').val();						
			var matrial_rate_already =  $('.rate').val();
			var total_amount_Add = matrial_qty_already *  matrial_rate_already;
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
				var grand_total_sum = 0;
					$("input[name='amount[]']").each(function() {
						grand_total_sum += Number($(this).val());
					});
					
					var grand_total_sum = grand_total_sum.toFixed(2);
					//alert(grand_total_sum);
					var charges_total = $('.total_charges_cls').val();
					//alert(charges_total);
					if(charges_total != '' || charges_total != '0.00'){
						
						var testee = (+charges_total) + (+grand_total_sum);
						
						$(".grand_total").val(testee);
						
					}else{
						
						$(".grand_total").val(grand_total_sum);
					}	
			}, 1000);	 
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
		
		
	function add_filed_for_goods_descr_invoice(){
	var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".add-ro"); //Fields wrapper
    var add_button      = $(".add_description_detail_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
	    e.preventDefault();
			// var uomsArray = '';
				// $.each( uoms, function( key, value ) {
				// uomsArray = uomsArray+'<option value="'+value+'">'+value+'</option>';
			// });
			$('.add_requried').prop("disabled", true);
			var company_login_id = $('#company_login_id').val();			
			var get_discount_on_off = $('#get_discount_on_off').val();
			var item_code_on_off = $('#item_code_on_off').val();
		//alert(max_fields);	
        if(x < max_fields){ //max input box allowed
            x++; 				
			if(get_discount_on_off == 1 ){
				
				if(item_code_on_off == 1){
					var item_codew = '<div class="col-sm-1 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label><input type="text" name="item_code[]"  class="col-md-1 form-control col-md-1 mat_item_code" placeholder="Item Code" value=""></div>';
				}else{
					var item_codew = '';
				}
				
				$(wrapper).append('<div class="col-md-12 input_descr_wrap add-ro2 mailing-box mobile-view" style="margin-top:0px; ">'+ item_codew +'<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Matrial Name <span class="required">*</span></label><select class="matrial_details_id itemName form-control selectAjaxOption select2 get_val select2-hidden-accessible demoClass" required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='+ company_login_id +' AND status=1" width="100%"></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd">	</div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label><input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods555" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label><input type="text" required="required"   name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event qty" placeholder="Quantity" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label><div><input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" required="required" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label><div class="checktr"><select name="disctype[]" class="form-control disc_type_cls"><option value="">Select</option><option value="disc_precnt">Discount Percent</option><option value="disc_value">Discount Value</option></select></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label><div class=" checktr"><input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" placeholder="Disc Amt" value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label><div class="checktr">	<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" placeholder="After Disc Amt" value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax<span class="required">*</span></label><div><input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax_key_up_event" placeholder="Tax" value="" readonly><input type="hidden" value="" name="added_tax" class="added_tax"><input type="hidden" value="" name="added_tax_Row_val[]" ></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label><div><input type="text" name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" placeholder="Amount" value="" readonly><input type="hidden" value="" name="sale_amount" class="sale_amount"><input type="hidden" value="" name="cess[]"><input type="hidden" value="" name="cess_tax_calculation[]"><input type="hidden" value="" name="valuation_type[]"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>');
			}else{
				if(item_code_on_off == 1){
					var item_codew = '<div class="col-sm-1 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label><input type="text" name="item_code[]"  class="col-md-1 form-control col-md-1 mat_item_code" placeholder="Item Code" value=""></div>';
					var uom_code = '<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div>';
				}else{
					var item_codew = '';
					var uom_code = '<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div>';
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
