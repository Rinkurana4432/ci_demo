item_submit_handler("save_item");

function item_submit_handler(form_id = ''){
	$(document).ready(function(){
		$(document).on("submit","#"+form_id,function(e){
			e.preventDefault();
			if(validateForm(form_id) == false) { return false;} 		
			var data = $(this).serialize();
			var ajax_url = $(this).attr('action');
			$.ajax({
				url: ajax_url,
				data: data,
				type: 'post',
				beforeSend: function(){
					$('#' + form_id + ' input[type="submit"]').fadeOut('slow');
					$('#' + form_id + ' .msg_box').html('Please wait while we save your information...');
				},
				success: function(result){						
					$('#' + form_id + ' input[type="submit"]').fadeIn('slow');
					var obj = $.parseJSON(result);	
					if(obj.status == 'error') {
						$('#' + form_id + ' .msg_box').html(obj.msg);						
					} 
					if(obj.status == 'success') {
						$('#item_modal').modal('toggle');						
						$(".rows_desc").val($("#" + form_id + " .description").val());
						$(".rows_longdesc").val($("#" + form_id + " .long_description").val());
						$(".rows_rate").val($("#" + form_id + " .rate").val());
						$(".rows_unit").val($("#" + form_id + " .unit").val());
						$(".rows_tax").append('<option value="'+$("#" + form_id + " .tax1").val()+'" selected>'+$("#" + form_id + " .tax1 option:selected").text()+'</option>');
												
						//window.location.href = obj.url;	
					}
				}
			});
		});
	});
}

function isEmpty(obj) {
	for(var prop in obj) {
		if(obj.hasOwnProperty(prop))
			return false;
	}

	return JSON.stringify(obj) === JSON.stringify({});
}

function delete_item(current_item_row) { console.log($('.items_rows').length);
    if($('.items_rows').length > 1 ){ 
	 $(current_item_row).closest('tr').remove(); 		
		var t = $(current_item_row).parent('td').prev().prev().prev().prev().find('input').val();
		var r = $(current_item_row).parent('td').prev().prev().prev().find('input').val();
		del_percentage(t,r);
		calculate_total();	
	 }
	else{
		alert('Error: Atleast One Item Should Be Selected');
		
	  } 
}

/* Fucntion to Remove/Subtract Percentage on Delete */
function del_percentage(t, r){	
					var tr = r;				
					var per_res = (parseInt(t) / 100) * parseInt(r);	
					per_res = Number(per_res).toFixed(2); 
					var cls_array = tr.split(".");  
                    if($("."+cls_array[0]).length == 0){                     					
					$('.tax-area').after('<tr class="'+cls_array[0]+'"><td>'+tr+'('+t+'%)'+'</td><td class="tax_after_cal">'+per_res+'</td></tr>');
					    }
				    else{
						 var firstval = $("."+cls_array[0]).find("td:eq(1)").text();
						 var addval   = parseInt(firstval)-parseInt(per_res);
						 if(addval > 0){
						 $("."+cls_array[0]).find("td:eq(1)").text(addval);
						 }
						 else{
						 $("."+cls_array[0]).remove(); 	 
						 }
						 
					    }	
				
}

//calculate_total();
function calculate_total() { 
	var rows_amount = 0;
	var rows_subtotal = 0; 
	$( "table.items .items_rows" ).each(function( index ) { 		  
        var item_qty = ($(this).find(".item_qty").val() != '')?$(this).find(".item_qty").val():1;
        var item_rate = ($(this).find(".item_rate").val() != '')?$(this).find(".item_rate").val():0;
        var item_tax = ($(this).find(".item_tax").val() != '')?$(this).find(".item_tax").val():0;
		
		var per_res = (parseInt(item_rate) / 100) * parseInt(item_tax);
		var row_amount = parseInt(item_qty) * parseInt(item_rate);
		var row_total = parseInt(item_qty) * parseInt(item_rate)+parseInt(per_res);
		rows_amount  = parseInt(rows_amount) + parseInt(row_total);
		rows_subtotal = parseInt(rows_subtotal) + parseInt(row_amount);
		$(this).find(".amount").text(row_amount);		
		
	});
	
	var discount = ($(".input-discount-percent").val() != '')?$(".input-discount-percent").val():0;
	var adjustment = ($(".amount_adjustment").val() != '')?$(".amount_adjustment").val():0;
	
	$(".discount-total").text("-"+discount);
	$(".adjustment").text("-"+adjustment);
	
	var tax_after_cal = 0;
	$( ".tax_after_cal" ).each(function( index ) {
		tax_after_cal = parseInt(tax_after_cal)+parseInt($(this).text());
	});	
	var total_amount = parseInt(tax_after_cal) + parseInt(rows_subtotal) - (parseInt(discount) + parseInt(adjustment));
	$(".subtotal").html("$"+parseInt(rows_subtotal)+"<input type='hidden' value='"+parseInt(rows_subtotal)+"' name='subtotal'>");
	$(".total").html("$"+total_amount+"<input type='hidden' value='"+total_amount+"' name='total'>");
	
}


$(document).ready(function (e){
	$(".rows_tax").val($(".rows_tax option:first").val(0));
	$(".rows_tax").val($(".rows_tax option:first").text('0.00'));
	$(".rows_tax option:first").attr('selected','selected');
	$(document).on("change",".tax1",function(){
		if($(this).val() != '') {
			$(".tax2").prop("disabled", false);
		} else {
			$(".tax2").prop("disabled", true);
		}
	})
	$("#include_shipping").click(function(){
		if($("#include_shipping").prop('checked') == true){
			$(".customer_shipping_details").show();
		}else{
			$(".customer_shipping_details").hide();
			$(".customer_shipping_details").find(".form-control").val("");		
		}
	});
	$(document).on("change",".add_item",function(){		
			if($( this ).val() == 'add_item') {
				$('#item_modal').modal('toggle');
			} else if($( this ).val() != '') {
				$.ajax({
				url: base_url+'invoices/get_item',
				data: {id:$( this ).val()},
				type: 'post',
				success: function(result){	
					var obj = $.parseJSON(result);	
					if(!isEmpty(obj) || obj != null) {					
							$(".rows_desc").val(obj.description);
							$(".rows_longdesc").val(obj.long_description);
							$(".rows_rate").val(obj.rate);
							$(".rows_unit").val(obj.unit);
							//console.log("Item TAx is - "+obj.tax);						
							$('.rows_tax').val(obj.tax).change();
						
							if(obj.tax != 0) {					
								//$('.rows_tax option[value='+obj.tax+']').attr('selected','selected').trigger("change");
								$(".taxname").val(obj.taxname);
							}
						}
					}
				});
			}
		});
		
		$(document).on("click",".add_item_to_table",function(){
			if($('.rows_desc').val() != '') {
				var n = "<tr class='items_rows'>";
				var o = parseInt($('#items_listing tbody tr').length)+1; 
				n += '<td></td>';
				n += '<td class="bold description"><textarea name="newitems[' + o + '][description]" class="form-control" rows="5">' + $('.rows_desc').val() + '</textarea></td>';
				n += '<td><textarea name="newitems[' + o + '][long_description]" class="form-control item_long_description" rows="5">' + $('.rows_longdesc').val() + '</textarea></td>';		
				n += '<td><input type="number" min="0" onblur="calculate_total();" onchange="calculate_total();" data-quantity name="newitems[' + o + '][qty]" value="' + $('.rows_quantity').val() + '" class="form-control item_qty">';
				n += '<input type="text" placeholder="" name="newitems[' + o + '][unit]" class="form-control input-transparent text-right" value="' + $(".rows_unit").val() + '">', n += "</td>";		
				n += '<td class="rate"><input type="number" data-toggle="tooltip" title="" onblur="calculate_total();" onchange="calculate_total();" name="newitems[' + o + '][rate]" value="' + $('.rows_rate').val() + '" class="form-control  item_rate"></td>';	
				n += '<td class="rate"><input type="text" name="newitems[' + o + '][itemtax]" data-toggle="tooltip" title="" value="' + $('.rows_tax option:selected').text() + '" class="form-control item_tax"><input type="hidden" name="newitems[' + o + '][taxname]" data-toggle="tooltip" title="" value="' +$('.taxname').val() + '" class="form-control"></td>';	
				n += '<td class="amount" align="right">Amount</td>"';
				n += '<td><a href="#" class="btn btn-danger pull-left" onclick="delete_item(this); return false;"><i class="fa fa-trash"></i></a></td>';
				n += '</tr>';
				$("table.items tbody").append(n);	
				
				var t = $('.rows_tax option:selected').text();
				var r = $('.rows_rate').val();
				var tr = $('.taxname').val();
				//console.log("T - "+$(".rows_tax").val());
				if($(".rows_tax").val().length != 0 ) {					
					
					var per_res = (parseInt(t) / 100) * parseInt(r);	
					per_res = Number(per_res).toFixed(2); 
					var cls_array = t.split(".");  
                    if($("."+cls_array[0]).length == 0){                     					
					$('.tax-area').after('<tr class="'+cls_array[0]+'"><td>'+tr+'('+t+'%)'+'</td><td class="tax_after_cal">'+per_res+'</td></tr>');				
					    }
				    else{
						 var firstval = $("."+cls_array[0]).find("td:eq(1)").text();
						 var addval   = parseInt(firstval)+parseInt(per_res);
						 $("."+cls_array[0]).find("td:eq(1)").text(addval);						 
					    }	
				}
				$("table.items tbody tr:first-child .form-control").val('');
			}
			calculate_total();
		});
		
		$(document).on("change","input:radio[name='show_quantity_as']",function(){	
			$('table tr:first th:eq(3)').text($(this).attr("data-text"));
		});
		
		$(document).on("change","select[name='discount_type']",function(){	
			var amount = $('.invoice-items-table tr:last .amount').html();
			if($(this).val() != 'no_discount' && amount != '0'){
				$("[name='discount_percent']").removeAttr('readonly', true);
				$("[name='adjustment']").removeAttr('readonly', true);
			}
			else{
				$("[name='discount_percent']").attr('readonly', true);
				$("[name='adjustment']").attr('readonly', true);
			}		
		});
		
		$('#include_shipping').click(function(){	
			if($(this).is(':checked')){
				$(".customer_shipping_details").show();
			}
			else{
				$(".customer_shipping_details").hide();
			}
		});
		
		 $(document).on("click",".btn-success",function(){ 
			 $('.item_error').text('');
			var amount = $('.invoice-items-table tr:last .amount').text();				
			 if(amount != 'undefined' || amount != undefined) {
				$('.LastRowAmount').val(amount);
			 }
			if($('.LastRowAmount').val() == 0 || $('.LastRowAmount').val() == ''){
				$('.item_error').text('Please select the item data');
			}
		});
		
		$(document).on("click",".btn-danger",function(){
			$('.item_error').text('');
		});
		
		$(document).on("change","#item_select",function(){		 
		 if(!$('.items_rows').length){
            $(".notificatin_item_add").remove();	
			$(".invoice-items-table ").before( "<span class='notificatin_item_add alert alert-danger'>Click Add to Save Item</span>");	
			$(".add_item_to_table").css('border','2px solid red');
			$(".btn-success").addClass("disabled");
           }
		});	
		
		$(document).on("click",".add_item_to_table",function(){
		 $(".notificatin_item_add").remove();			 	
		 $(".btn-success").removeClass("disabled");
		 $(".add_item_to_table").css('border','0');
		});
	
	
	/* Form Validation Function */
		   $('#save_item').validate({
				errorElement: 'span', 
				errorClass: 'error', 
				focusInvalid: false, 
				rules: {
					description: {
						required: true							
					},
					rate: {
						required: true
					}, 
				},
				invalidHandler: function (event, validator) {
					//display error alert on form submit   				
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					var icon = $(element).parent('.input-with-icon').children('i');
					var parent = $(element).parent('.input-with-icon');
					icon.removeClass('fa fa-check').addClass('fa fa-exclamation');  
					parent.removeClass('success-control').addClass('error-control');  
				},
				highlight: function (element) { // hightlight error inputs
					var parent = $(element).parent();
					parent.removeClass('success-control').addClass('error-control'); 
				},
				unhighlight: function (element) { // revert the change done by hightlight
				},
				success: function (label, element) {
					var icon = $(element).parent('.input-with-icon').children('i');
					var parent = $(element).parent('.input-with-icon');
					icon.removeClass("fa fa-exclamation").addClass('fa fa-check');
					parent.removeClass('error-control').addClass('success-control'); 
				},
			});	
			
			 /* discount type */
			$(".input-discount-percent").click(function(){
				if($(this).attr('readonly')){			
					alert('Please Choose Discount Type');
					window.scrollTo(50,50);
					$('select[name="discount_type"]').focus();				
				}
			});
			
           		
			
});