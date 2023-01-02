// Function to change the status of lead
/*
$(document).on("click",".close_unqstatus_model",function(){
	$('.nav-md').addClass('modal-open');

});	*/
 $(document).ready(function(){
		$('.selectAjaxOption').val(101); // Select the option with a value of 'US'
		$('.selectAjaxOption').trigger('change');
 });
function changeStatus(id = '', status = '', oldStatus = '') {
	$('.selected').prev('.step_no').addClass('previous');
	var status_comment = '';
	if (status == 4 || status == 6) { // if status of lead is unqualified or loose show modal for reason
		$('.leadStatusCommentModal').modal('show');

		$('#status_comment_btn').click(function (e) {
			status_comment = $('#status_comment').val();
			var data = {
				id: id,
				status: status,
				status_comment: status_comment,
				oldStatus : oldStatus,
			};

			console.log("fff");
			changeStatusAjaxCall(data);

			//$('.nav-md').addClass('modal-open');
			//$('.leadStatusCommentModal').modal('open');
		})

	} else {
		var data = {
			id: id,
			status: status,
			status_comment: '',
			oldStatus : oldStatus,
		};
		if (confirm("Are you sure?")) {
			changeStatusAjaxCall(data);
			$('.step_no').css('background', '#ccc');
			$('#status_id_' + status).css('background', '');
			$('#status_id_' + status).addClass('selected');

			$(this).parents("li").prev('.selected').addClass('selected');

			//$('#status_id_'+status).find('.selected').prev('.step_no').addClass('previous');
		}

		//changeStatusAjaxCall(data);
	}

	// $('#status_id_'+status).css('background','');
}


// Function to Change the status of lead in database
function changeStatusAjaxCall(data = '') {

	$.ajax({
		url: site_url + 'crm/change_lead_status/',
		dataType: 'json',
		type: 'POST',
		data: data,
		success: function (result) {
			if (result.status == 'success') {

				if (data.status == 4 || data.status == 6) {

					$('.nav-md').addClass('modal-open');

					console.log('data===>>>', data);

				}
				if (data.status == 2) {
					$('#activity').show();
				}

				//$('.leadBasicData .alert').css('display','block');
				alert('status changed successfully');

				$('.leadStatusCommentModal').modal('hide');

				//	$('.nav-md').addClass('modal-open');

				//window.location = result.url;
				location.reload();
			}
		}
	});
}


// Add address details of account in sale order and proforma invoice
function getAccountDetails() {
	$("#account_id").on("select2:select", function (e) {
		$("#contact_id").empty();
		var selectAccountVal = $(e.currentTarget).val();
		var whereContactContact = "account_id='" + selectAccountVal + "'";
		$("#contact_id").attr("data-where", whereContactContact);
		$.ajax({
			url: site_url + 'crm/getAccountDataById/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: selectAccountVal,
			},
			success: function (result) {
				$('#phone_no').val(result.phone);
				$('#email').val(result.email);
				$('.contactPerson').html('<option selected>'+result.contact_name+'</option>');
				$('#contact_phone_no').val(result.phone);
				new_billing_address = JSON.parse(result.new_billing_address);
				var street = ''; var zipcode = ''; var city = ''; var state = ''; var country = ''; var Dropdn = '';
		        $.each(new_billing_address, function(j, item1) {
		        $.ajax({
				url: site_url + 'crm/fetchLocationById/',
				dataType: 'json',
				type: 'POST',
				data: {
					billing_city: item1.billing_city_1,
					billing_state: item1.billing_state_1,
					billing_country: item1.billing_country_1,
				},
				success: function (resultData) {
					if (resultData != '') {
						name = item1.billing_company_1;
						street = item1.billing_street_1;
						zipcode = item1.billing_zipcode_1;
						city = resultData.city;
						state = resultData.state;
						country = resultData.country;								
						var address = name + '\n' +  street + '\n' + city + '\n' + state + '\n' + country + '\n' + zipcode;
						if(j==0){
						$('#address, #saddress').html(address);
						$('#gstin').val(item1.billing_gstin_1);
						//Dropdn = '<option data-address="'+address+'" value="' + item1.billing_street_1 + '" data-gst="' + item1.billing_gstin_1 + '" selected="selected">' + item1.billing_company_1 + '</option>';
				    }
				    Dropdn += '<option data-address="'+address+'" value="' + item1.billing_street_1 + '" data-gst="' + item1.billing_gstin_1 + '">' + item1.billing_company_1 + '</option>';
						$("#c_address, #sc_address").html(Dropdn);
					}
				}
			});
		        });



				// $.ajax({
				// 	url: site_url + 'crm/fetchLocationById/',
				// 	dataType: 'json',
				// 	type: 'POST',
				// 	data: {
				// 		billing_city: result.billing_city,
				// 		billing_state: result.billing_state,
				// 		billing_country: result.billing_country,
				// 	},
				// 	success: function (resultData) {
				// 		if (resultData != '') {
				// 			console.log('resultData==>>>', resultData);
				// 			var address = result.billing_street + '\n' + resultData.city + '\n' + result.billing_zipcode + '\n' + resultData.state + '\n' + resultData.country;
				// 			$('#address').html(address);
				// 		}
				// 	}
				// });
			}
		});

		$("#contact_id").on("select2:select", function (e) { // get phone number by contact id in sale order or proforma invoice
			var selectContactVal = $(e.currentTarget).val();
			$.ajax({
				url: site_url + 'crm/getContactDataById/',
				dataType: 'json',
				type: 'POST',
				data: {
					id: selectContactVal,
				},
				success: function (result) {
					$('#contact_phone_no').val(result.phone);
				}
			});
		});
	});
}


if (typeof measurementUnits != 'undefined' && measurementUnits) {
	measurementUnits = JSON.parse(measurementUnits);
	var measurmentArray = '';
	$.each(measurementUnits, function (key, value) {
		measurmentArray = measurmentArray + '<option value="' + value + '">' + value + '</option>';
	});
}


function getMaterials(x = '') {
	var option = '';
	$.ajax({
		type: 'POST',
		url: site_url + 'crm/getMaterials/',
		data: {
			//'material_id': matId,
		},
		success: function (data) {
			var dataObj = JSON.parse(data);
			if (dataObj) {
				option = '<option value="">Select product</option>';
				$(dataObj).each(function () {
					option = option + '<option value="' + this.id + '" data-tax="' + this.tax + '">' + this.material_name + '</option>';
				});
				$('#chkIndex_' + x + ' .product').append(option);
			} else {
				$('.material_name').html('<option value="">State not available</option>');
			}
		}
	});
}


// Function to get tax of material
function getTax(evt, t) {
	var option = $(t).find('option:selected');
	var materialId = option.val();
	var closestId = $(t).closest(".well").attr("id");
	$.ajax({
		type: "POST",
		url: site_url + 'crm/getMaterialDataById',
		data: {
			id: materialId
		},
		success: function (data) {
			if (data != '') {
				var dataObj = JSON.parse(data);
				parseFloat($("#" + closestId + " input[name='gst[]'").val(dataObj.tax));
				parseFloat($("#" + closestId + " input[name='uom1[]'").val(dataObj.uom));

				parseFloat($("#" + closestId + " input[name='uom[]'").val(dataObj.uomid));

				parseFloat($("#" + closestId + " input[name='quantity[]'").val(''));
				parseFloat($("#" + closestId + " input[name='box[]'").val(0));
				parseFloat($("#" + closestId + " input[name='price[]").val(dataObj.sales_price));
				parseFloat($("#" + closestId + " input[name='individualTotal[]'").val(''));
				parseFloat($("#" + closestId + " input[name='individualTotalWithGst[]'").val(''));
				$('#'+closestId).find('.Product_Image').html('<img style="width: 50px; height: 50px;" src="'+dataObj.main_img_path+'"><input type="hidden" name="pro_img[]" value="'+dataObj.main_img_path+'">');
				$(".divTotal").html(0);
				$(".divSubTotal").html(0);

			}
		}
	});
	var tax = option.attr('data-tax');
	var closestId = $(t).closest(".well").attr("id");
	parseFloat($("#" + closestId + " input[name='gst[]'").val(tax));
}

function poPriceCalculation(evt, t) {
	var closestId = $(t).closest(".well").attr("id");
	var qty = $("#" + closestId + " input[name='quantity[]'").val();
	var price = $("#" + closestId + " input[name='price[]'").val();
	var gst = $("#" + closestId + " input[name='gst[]'").val();
	var individualTotal = parseFloat(qty) * parseFloat(price);
	if (isNaN(individualTotal)) {
		var individualTotal = 0;
	}
	var individualTotal_decimal = individualTotal.toFixed(2);

	var individualTaxPrice = (individualTotal * gst) / 100;
	var individualPriceWithGstTotal = individualTotal + individualTaxPrice;
	if (isNaN(individualPriceWithGstTotal)) {
		var individualPriceWithGstTotal = 0;
	}
	var individualPriceWithGstTotal_decimal = individualPriceWithGstTotal.toFixed(2);
	parseFloat($("#" + closestId + " input[name='individualTotal[]'").val(individualTotal_decimal));
	parseFloat($("#" + closestId + " input[name='individualTotalWithGst[]'").val(individualPriceWithGstTotal_decimal));
	var total = 0;
	$(".individualTotal").each(function (key, value) {
		total = parseFloat(total) + parseFloat($(value).val());
	});
	if (isNaN(total)) {
		var total = 0;
	}
	var grandTotal = 0;
	$(".individualTotalWithGst").each(function (key, value) {
		grandTotal = parseFloat(grandTotal) + parseFloat($(value).val());
	});

	if (isNaN(grandTotal)) {
		var grandTotal = 0;
	}

	if ($("input[name='agt']").length && $("input[name='agt']").val() != '') {
		grandTotal = grandTotal + parseFloat($("input[name='agt'").val());

	}
	parseFloat($("input[name='total'").val(total));
	parseFloat($("input[name='grandTotal'").val(grandTotal));
	parseFloat($(".divSubTotal").text(total));
	parseFloat($(".divTotal").text(grandTotal));
	//var individualTotalWithGst
}


//   Function to approve or disapprove sale order of CRM
$(document).on("click", ".validate", function () {
	if (confirm('Are you sure!') == true) {
		var row = $(this).closest('tr');

		var nameAttributeId = $(this).attr('name');
		nameAttributeId = nameAttributeId.split("_");
		var loggedInUserId = $('#loggedInUserId').val();


		var checkValues = $('.checkbox1:checked').map(function () {
			return $(this).val();
		}).get();
		$.each(checkValues, function (i, val) {
			$("#" + val).remove();
		});
		var ai = $(".checkbox1:checked").map(function () {
			return $(this).data('ai')
		}).get();
		$.ajax({
			type: "POST",
			url: site_url + 'crm/approveSaleOrder/',
			data: {
				id: checkValues,
				approve: 1,
				validated_by: loggedInUserId,
				accountid: ai,
				nameAttributeId: nameAttributeId
			},
			success: function (result) {
				if (result != '') {
					var obj = $.parseJSON(result);
					if (obj.status == 'success') {
						window.location.href = site_url + 'crm/sale_orders/';
					}
				}
			}
		});


	}
});


$(document).on("click", ".validate1", function () {
	if (confirm('Are you sure!') == true) {
		var row = $(this).closest('tr');
		var loggedInUserId = $('#loggedInUserId').val();
		var nameAttributeId = $(this).attr('name');
		nameAttributeId = nameAttributeId.split("_");
		var sale_order_id = nameAttributeId[1];
		//var sale_order_id = row.find("td.sale_order_id:nth-child(1)").text();
		$.ajax({
			type: "POST",
			url: site_url + 'crm/approveSaleOrderindi/',
			data: {
				id: sale_order_id,
				approve: 1,
				validated_by: loggedInUserId
			},
			success: function (result) {
				if (result != '') {
					var obj = $.parseJSON(result);
					if (obj.status == 'success') {
						window.location.href = site_url + 'crm/sale_orders/';
					}
				}
			}
		});
	}

});


//   Function to show the modal with disapprove reasonof sale order of CRM
$(document).on("click", ".disapprove", function () {
	var row = $(this).closest('tr');
	var nameAttributeId = $(this).attr('name');
	nameAttributeId = nameAttributeId.split("_");
	var sale_order_idindi = nameAttributeId[1];
	var checkValues = $('.checkbox1:checked').map(function () {
		return $(this).val();
	}).get();


	$.each(checkValues, function (i, val) {
		$("#" + val).remove();
	});


	var ai = $(".checkbox1:checked").map(function () {
		return $(this).data('ai')
	}).get();


	var sale_order_id = checkValues;


	if ($(".checkbox1").prop('checked') == true) {
		$(".disapproveReasonModal #sale_order_id").val(sale_order_id);
	} else {

		$(".disapproveReasonModal #sale_order_id").val(sale_order_idindi);

	}


	console.log(sale_order_id);
	//var sale_order_id = row.find("td.sale_order_id:nth-child(1)").text();
	var disapprove_reason = row.find("td .disapprove_reason").text();


	$(".disapproveReasonModal #aci").val(ai);
	$(".disapproveReasonModal #disapprove_reason").text(disapprove_reason);
	$('.disapproveReasonModal').modal('show');
});



	$(document).ready(function(e) {
    	$(document).on("click",'.workOrderModal',function(){
			$("#sale_order_modal").modal('hide');
		});
	});

// Add/Edit Modal for CRM submodules
$(document).on("click", ".add_crm_tabs", function () {
	var id = $(this).attr('id');
	var tab = $(this).attr('data-id');
	var start_date = $(this).attr('data-date') ? $(this).attr('data-date') : '';
	var url = '';

	switch (tab) {
		
		case 'competitor_details':
			url = 'crm/competitor_details_edit';
			data = {
				id: id
			};
			break;

		case 'contact':
			url = 'crm/editContact';
			data = {
				id: id
			};
			break;
		case 'contact_view':
			url = 'crm/viewContact';
			data = {
				id: id
			};
			break;
		case 'sale_order':
			url = 'crm/editSaleOrder';
			data = {
				id: id
			};
			break;
		case 'sale_order_view':
			url = 'crm/viewSaleOrder';
			data = {
				id: id
			};
			break;
        case 'sale_order_viewmat':
			url = 'crm/viewsaleorder_matView';
			data = {
				id: id
			};
			break;
        case 'quotation_view_mat':
			url = 'crm/viewQuotationmaterial';
			data = {
				id: id
			};
	break;
		case 'ProgessOfSO':
			url = 'crm/viewSaleOrderProgess';
			data = {
				id: id
			};
			break;
		case 'CompletionOfSO':
			url = 'crm/completeSaleOrderquality';
			data = {
				id: id
			};
			break;
		case 'sale_order_dispatch':
			url = 'crm/dispatchSaleOrder';
			data = {
				id: id
			};
			break;
		case 'proforma_invoice':
			url = 'crm/editProformaInvoice';
			data = {
				id: id
			};
			break;
		case 'proforma_invoice_view':
			url = 'crm/viewProformaInvoice';
			data = {
				id: id
			};
			break;
		case 'lead':
			url = 'crm/edit_lead';
			data = {
				id: id
			};
			break;
		case 'lead_view':
			url = 'crm/viewLead';
			data = {
				id: id
			};
			break;
		case 'account':
			url = 'crm/editAccount';
			data = {
				id: id
			};
			break;
		case 'account_view':
			url = 'crm/viewAccount';
			data = {
				id: id
			};
			break;
		case 'sale_target':
			url = 'crm/editSaleTarget';
			data = {
				start_date: start_date
			};
			break;
		case 'sale_target_view':
			url = 'crm/viewSaleTarget';
			data = {
				start_date: start_date
			};
			break;
		case 'quotation_edit':
			url = 'crm/quotation_edit';
			data = {
				id: id
			};
			break;
		case 'quotation_view':
			url = 'crm/viewQuotation';
			data = {
				id: id
			};
			break;

		case 'editterms_condtn':
			url = 'crm/editterms_condtn';
			data = {
				id: id
			};
			break;

		case 'termscond_view':
			url = 'crm/termscond_view';
			data = {
				id: id
			};
			break;

		case 'convertLeads_to_quot':
			url = 'crm/convertLeads_to_quot';
			data = {
				id: id
			};
			break;


		case 'convert_to_pi':
			url = 'crm/convert_to_pi';
			data = {
				id: id
			};
			break;

		case 'convert_to_so':
			url = 'crm/convert_to_so';
			data = {
				id: id
			};
			break;

		case 'lead_to_pi':
			url = 'crm/lead_to_pi';
			data = {
				id: id
			};
			break;

		case 'lead_to_so':
			url = 'crm/lead_to_so';
			data = {
				id: id
			};
			break;

		case 'convertPiIntoSaleOrderview':
			url = 'crm/convertPiIntoSaleOrderview';
			data = {
				id: id
			};
			break;

		case 'AddSimilarQuot':
			url = 'crm/AddSimilarQuotedit';
			data = {
				id: id
			};
			break;

		case 'AddSimilarPI':
			url = 'crm/AddSimilarPIedit';
			data = {
				id: id
			};
			break;

		case 'AddSimilarSO':
			url = 'crm/AddSimilarSOedit';
			data = {
				id: id
			};
			break;

		case 'account_idview':
			url = 'crm/viewQuotation';
			data = {
				id: id
			};
			break;

		case 'customer_Type':
			url = 'crm/customerType_edit';
			data = {
				id: id
			};
			break;

		case 'add_price':
			url = 'crm/addPrice_edit';
			data = {
				id: id
			};
			break;

		case 'add_price_prodct':
			url = 'crm/add_price_prodct_edit';
			data = {
				id: id
			};
			break;

		case 'sale_order_invoice':
			url = 'crm/convert_SO_to_Invoice';
			data = {
				id: id
			};
			break;

		case 'add_industry':
			url = 'crm/edit_industry';
			data = {
				id: id
			};
			break;

		case 'add_leads_source':
			url = 'crm/edit_lead_source';
			data = {
				id: id
			};
			break;
			case 'add_sales_area':
			url = 'crm/edit_sales_area';
			data = {
				id: id
			};
			break;
		case 'register_opportunity_edit':
			url = 'bid_management/edit_register_opportunity';
			data = {id:id};
			break;
		case 'register_opportunity_view':
			url = 'bid_management/view_register_opportunity';
			data = {id:id};
			break;
		case 'proforma_invoice_Matview':
			url = 'crm/viewMATProformaInvoice';
			data = {
				id: id
			};
			break;
        case 'competitor_detailsmatview':
			url = 'crm/viewcompetitorMat';
			data = {
				id: id
			};
			break;
		case 'RawMaterialReportQtysaleorder':
         url = 'crm/RawMaterialReportQtysaleorder';
			data = {
				id: id
			};
			break;
	}
	

	if (tab == 'lead') {
		$(".slide-toggle").click(function () {
			$(".box1").slideToggle(1000);

		});
	}
	if (tab == 'convertPiIntoSaleOrderview') {
		$('.nxt_cls').html('Sale Order');
	}


	if (tab == 'convert_to_pi') {
		$('.nxt_cls').html('Proforma Invoice');
	}

	if (tab == 'convert_to_so') {
		$('.nxt_cls').html('Sale Order');
	}

	if (tab == 'quotation_edit') {
		$('.nxt_cls').html('Quotation');
	}

	if (tab == 'quotation_view') {
		$('.nxt_cls').html('Quotation View');
	}

	if (tab == 'convertLeads_to_quot') {
		$('.nxt_cls').html('Quotation');
	}

	if (tab == 'lead_view') {
		$('.nxt_cls').html('Lead');
	}


	if (tab == 'lead_to_pi') {
		$('.nxt_cls').html('Proforma Invoice');
	}


	if (tab == 'lead_to_so') {
		$('.nxt_cls').html('Sale Order');
	}


	if (tab == 'AddSimilarQuot') {
		$('.nxt_cls').html('Add Similar Quotation');
	}

	if (tab == 'competitor_details') {
		$('.nxt_cls').html('Competitor Details');
	}
	if (tab == 'ProgessOfSO') {
		$('.nxt_cls').html('view Sale Order Gantt Chart');
	}

	if (tab == 'sale_order_dispatch') {
		$('.nxt_cls').html('Dispatch Sale Order');
	}

	if (tab == 'AddSimilarSO') {
		$('.nxt_cls').html('Similar Sale Order');
	}

	if (tab == 'sale_order_view') {
		$('.nxt_cls').html('Sale Order');
	}

	if (tab == 'sale_order') {
		$('.nxt_cls').html('Sale Order');
	}


	$.ajax({
		type: "POST",
		url: site_url + url,
		data: {
			id: id
		},
		success: function (data) {
			if (data != '') {
				// $("#crm_add_modal").modal({
					// show: false,
					// backdrop: 'static'
				// });
				// $('#crm_add_modal').modal('toggle');
				// $('#crm_add_modal .modal-body-content').html(data);



				if(tab == 'sale_order_view'){
				$("#crm_add_modal").modal({
					show: false,
					backdrop: 'static'
				});
				$('#crm_add_modal').modal('toggle');
				$('#crm_add_modal .modal-body-content').html(data);
            }else if(tab == 'RawMaterialReportQtysaleorder'){
                    $("#sale_order_modal").modal({
                        show: false,
                        //backdrop: 'static'
                    });
                    $('#sale_order_modal').modal('show');
                    $('#sale_order_modal .modal-body-content').html(data);

                }else{
					$("#crm_add_modal").modal({
						show: false,
						backdrop: 'static'
					});
					$('#crm_add_modal').modal('toggle');
					$('#crm_add_modal .modal-body-content').html(data);
				}



				// $('.datePicker').daterangepicker({ // To select the date for filter sale target by month and year
					// singleDatePicker: true,
					// locale: {
						// format: 'DD-MM-YYYY',
						// minDate: -20,
						// maxDate: "1D"
					// }
				// }, function (start, end, label) {});
				
				
				// $( ".datePicker" ).datepicker();


				$('.datePickerBefore').daterangepicker({ // To hide dates after current date in date picker
					singleDatePicker: true,
					maxDate: new Date(),
					locale: {
						format: 'DD-MM-YYYY',
					},
					//singleClasses: "picker_3"
				}, function (start, end, label) {
					console.log(start.toISOString(), end.toISOString(), label);
				});


				$('input[name="start_date"]').daterangepicker({ // To select the date for filter sale target by month and year
					singleDatePicker: true,
					//singleClasses: "picker_3",
					locale: {
						//format: 'YYYY-MM-DD',
						format: 'YYYY-MM',
					}
				}, function (start, end, label) {});


				if (tab == 'lead') {
					addMoreLeadContacts();
					activityDateRangeSelector();
					addMoreChatterAttachments();
					LeadsAddMoreMaterial();
					keyupFunction();
					get_customer_data();


				} else if (tab == 'editterms_condtn') {
					CKEDITOR.replace('content');
				} else if (tab == 'account') {
					 fnValidateGSTIN();
					activityDateRangeSelector();
					addMoreChatterAttachments();
					AddMultipleselect();
					add_billing_multi_address();
					add_shipping_multi_address();
					$('.country_id').attr('data-where', 'country_id = ' + 101);
					$('.country_id').attr('data-id', 'country');
					$('.country_id').attr('data-key', 'country_id');
					$('.country_id').attr('data-fieldname', 'country_name');
					
					$('.BuyerNameCls').on('keyup',function(){
						$('.billing_companyCls').val($(this).val());
					});
					
					
					
				} else if (tab == 'contact') {
					dateFunction();
				} else if (tab == 'convertPiIntoSaleOrderview' || tab == 'convert_to_pi' || tab == 'sale_order' || tab == 'proforma_invoice' || tab == 'sale_order_dispatch' || tab == 'AddSimilarPI' || tab == 'AddSimilarSO' || tab == 'convert_to_so' || tab == 'lead_to_pi' || tab == 'lead_to_so') {
					//'.calcDiscount'
					//$(".calcDiscount").trigger("click");
					getAccountDetails();
					showFreight();
					showPermittedBy();
					SpecialDiscount();
					addmorepro_piso();
					addMoreChatterAttachments();
					dateFunction();
					getAddress();
					// keyupFunction();
					mat_status_onchange();
					activityDateRangeSelector();
					if (tab == 'sale_order_dispatch')
						saleOrderComplete();
					$('.country_id').attr('data-where', 'country_id = ' + 101);
					$('.country_id').attr('data-id', 'country');
					$('.country_id').attr('data-key', 'country_id');
					$('.country_id').attr('data-fieldname', 'country_name');
					 
				
					$(document).on("click", ".SubmitBtn", function () {	
					if ($(".calcDiscount").is(":checked")) {
						//alert('if');
							 //$(".calcDiscount").prop("checked", false)
							 $(".calcDiscount").attr("required", false);
							 $('#radio_msg').html('');
					}else{
						//alert('else');
						$(".calcDiscount").attr("required", true);
							 $('#radio_msg').html('Please Select Load Type First');
					}
					});
					
					
					 $(document).on("keyup", ".special_discount", function () {
						 				 
						if($(this).val() <= 0){
								$("#sda_by_discount").attr('required',false);
							}else{
								$("#sda_by_discount").attr("required", true);
							}
					});
					$(document).on("change", "#sda_by_discount", function () {
						// $('#special_discount').val();
						// alert($('#sda_by_discount :selected').text());
						if($('#sda_by_discount :selected').text() != 'Select'){
							$("#sda_by_discount").attr('required',false);
							$(this).parent('div').next('div').remove();
							
						}else{
							$("#sda_by_discount").attr("required", true);
						}
						
						
					});
					
					
					standard_packingCalc();
							
				} else if (tab == 'quotation_edit') {

					getAccountDetails();
					addMoreProduct();
					addMoreChatterAttachments();
					dateFunction();
					getAddress();
					keyupFunction();


					activityDateRangeSelector();
					if (tab == 'sale_order_dispatch')
						saleOrderComplete();


				} else if (tab == 'AddSimilarQuot') {

					getAccountDetails();
					addMoreProduct();
					addMoreChatterAttachments();
					dateFunction();
					getAddress();
					keyupFunction();


					activityDateRangeSelector();
					if (tab == 'sale_order_dispatch')
						saleOrderComplete();


				} else if (tab == 'convertLeads_to_quot') {

					getAccountDetails();
					addMoreProduct();
					addMoreChatterAttachments();
					dateFunction();
					getAddress();
					keyupFunction();


					activityDateRangeSelector();
					if (tab == 'sale_order_dispatch')
						saleOrderComplete();


				} else if (tab == 'proforma_invoice') {
					activityDateRangeSelector();
					$('.country_id').attr('data-where', 'country_id = ' + 101);
					$('.country_id').attr('data-id', 'country');
					$('.country_id').attr('data-key', 'country_id');
					$('.country_id').attr('data-fieldname', 'country_name');
					
					
					
					
					

				} else if (tab == 'sale_order_view') {
					saleOrderComplete();

				} else if (tab == 'customer_Type') {

					addMoretypeofCustomer();
				}
				else if (tab == 'add_sales_area') {
					//addmoresalesarea();
					addMoreleadsresource();
					addMoresaleArea();
				}
				 else if (tab == 'competitor_details') {
					getMaterialNameCA();
					addMaterialDetailCA();
					select2CA();
					init_select2();
					init_select221();
					init_select22();
					init_select212();
					Print_data_new();
				} else if (tab == 'add_price') {
					addMaterialDetailCA();
					getMaterialNameCA();
					getMatDetails();
					select2CA();
					init_select2();
					init_select221();
					init_select22();
					init_select212();
					Print_data_new();
				} else if (tab == 'add_price_prodct') {
					add_price_prodct_row();
					getComptDetails();
					getMaterialNameCompt();
					select2saleorder();
					addMaterialDetailCAproductvise();
					//init_select2so();
					getMaterialNameCA();
					getMatDetails();
					select2CA();
				}

				else if (tab == 'add_industry') {
					addMoretypeofCustomer();
				}

				else if (tab == 'add_leads_source') {
					addMoreleadsresource();
					addMoresaleArea();
				}

				else if (tab == 'sale_order_invoice') {
					add_dicount_invoice_matrial();
					kyup_function_to_remove_add_rate_qty();
					
					party_name_ledger_id_onchange();
					
					tax_keyup_event_to_remove_tax();
					get_party_details_onchange();
					get_add_more_btn_forsale_ledger();
					
					$('#date_time_of_invoice_issue,#buyer_order_date').datepicker({
					format: 'dd-mm-yyyy',
					autoclose: true,
					todayHighlight: false,
					changeMonth: false,
					changeYear: false
				});
					$('.keyup_event').keyup();
					if(id == 'add'){//This code is used for add invoice number on load Modal
					 setTimeout(function(){
								$('.sale_ledger_id_onchange').trigger('change');
							}, 1000);
					}

					get_multiselect_value();
					add_filed_for_goods_descr_invoice();
					var alerady_tax = $('.tax_class').val();
					$('.added_tax').val(alerady_tax);
					var matrial_qty_already = $('.qty').val();
					var matrial_rate_already = $('.rate').val();
					var total_amount_Add = matrial_qty_already * matrial_rate_already;
					//alert(total_amount_Add);
					//$('.sale_amount').val(total_amount_Add);
					var result_divide = parseInt(alerady_tax) / parseInt(2);
					// alert(result_divide);
					$(".tax_class1").val(result_divide);
					$(".tax_class2").val(result_divide);
					var consignee_address_check1 = $('textarea#consignee_address').val();
					if ($('#consignee_address_check').attr('checked')) {
						$("consignee_address_check1").show();
					} else {
						$("consignee_address_check1").hide();
					}
					if ($("#consignee_address_check").prop('checked') == true) {
						$('#consignee_address').show();
					} else {
						$('#consignee_address').hide();
					}
					
				}

				$('form')
					.on('blur', 'input[required], input.optional, select.required', validator.checkField)
					.on('change', 'select.required', validator.checkField)
					.on('keypress', 'input[required][pattern]', validator.keypress);
				$('form').submit(function (e) {
					e.preventDefault();
					var submit = true;
					if (!validator.checkAll($(this))) {
						submit = false;
					}
					if (submit)
						this.submit();
					return false;
				});


				init_select2();
				init_select221();
				init_select22();
				init_select212();
				init_select2so();
				Print_data_new();
				get_multiselect_value();
				fnValidateGSTIN();
				
				
				

			}
		}
	});
});


function standard_packingCalc(){
	//$("select.getStandardPack").change(function(){
        //var selectedMatVariant = $(this).children("option:selected").val();
		 //$("#" + closestId + " input[name='standard_packing[]'").val();
		 // $().val();
	 //});
	// $(document).on('keyup', '.getStandardPack', function () {
		
	// });
	
}

function dateFunction() {
	$('#dob').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		endDate: 'today',

		autoclose: true
	});

	// $('#dispatch_date').datepicker({
		// dateFormat: 'dd-mm-yy',
		// changeMonth: true,
		// changeYear: true,
		// yearRange: '-100y:c+nn',
		// maxDate: '-1d',
		// autoclose: true
	// });
	$('#dispatch_date').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			changeMonth: true,
			changeYear: true
		});

	$('#payment_date').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});
}
// Function to display add more contact functionality in lead
function addMoreLeadContacts() {
	/* add more multiple contacts */
	var maximum_add = 10; //maximum input boxes allowed
	var inputfield = $(".input_holder"); //Fields wrapper
	var add_more = $(".addMoreLead"); //Add button ID
	var x = 1; //initlal text box count
	$(add_more).click(function (e) { //on add input button click
		e.preventDefault();
		if (x < maximum_add) { //max input box allowed
			x++;
			$(inputfield).append('<div class="well scend-tr mobile-view" id="chkIndex_' + x + '"><div class="item form-group col-md-3 col-xs-12"><label class="col-md-12 col-sm-12 col-xs-12" for="name">First Name<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input id="name" class="form-control col-md-7 col-xs-12" value="" name="first_name[]" placeholder="ex. John f. Kennedy" required="required" type="text" ></div></div><div class="item form-group col-md-2 col-xs-12"><label class="col-md-12 col-sm-12 col-xs-12" for="name">Last Name</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input id="last_name" class="form-control col-md-7 col-xs-12" value="" name="last_name[]" placeholder="ex. John f. Kennedy" type="text"></div></div><div class="item form-group col-md-2 col-xs-12"><label class="col-md-12 col-sm-12 col-xs-12" for="email">Email </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="email" id="email" name="email[]"  class="form-control col-md-7 col-xs-12" placeholder="abcd@gmail.com" value=""></div></div><div class="item form-group col-md-2 col-xs-12"><label  class="col-md-12 col-sm-12 col-xs-12" for="email">Phone No. <span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input style=" border-right: 1px solid #c1c1c1 !important;" type="number" id="phone_no" name="phone_no[]"  class="form-control col-md-7 col-xs-12" value=""  required="required"></div></div><div class="item form-group col-md-3 col-xs-12"><label style=" border-right: 1px solid #c1c1c1 !important;" class="col-md-12 col-sm-2 col-xs-12" for="email">Designation. <span class="required">*</span></label><div class="col-sm-12 col-md-12 col-xs-12 form-group"><input type="text" id="designation" name="designation[]" class="form-control col-md-7 col-xs-12" placeholder="Designation" value=""> </div></div><button class="btn btn-danger del_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
		var mat_id = $('#material_type').val();
	});
	$(inputfield).on("click", ".del_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	});
}
/**********************add more material in leads**************************/
function LeadsAddMoreMaterial() {
	var maximum = 12; //maximum input boxes allowed
	var material_div = $(".input_detail"); //Fields wrapper
	var add_more_btn = $(".addMoreButton"); //Add button ID
	var inc = $('.input_detail .well').length; //initlal text box count
	// var inc = 1; //initlal text box count
	$(add_more_btn).click(function (e) { //on add input button click
		var logged_user = $('#loggedUser').val();
		//alert(logged_user);
			e.preventDefault();
		if (inc < maximum) { //max input box allowed
			inc++;

			$(material_div).append('<div class="well scend-tr mobile-view" id="chkIndex_' + inc + '"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Material Type<span class="required">*</span></label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 select2-width-imp" name="material_type_id_val[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Material Name <span class="required">*</span></label><select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]" onchange="getUom(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Description</label><textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"></textarea></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12" >Quantity   UOM</label><input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" required="required"><input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"  value="" readonly><input type="hidden" name="uom_material[]" id="uomid" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Price</label><input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12">GST </label><input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Total</label><input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value=""></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12" >GST Total </label><input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="" readonly></div><button class="btn form-group btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
			var logged_user = $('#loggedUser').val();
			var material_type_id = $('#material_type_id').val();
			select2(material_type_id, logged_user);
		}
		init_select2();
		init_select221();
		//keyupFunction();
	});
	$(material_div).on("click", ".delete_btn", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		inc--;
		keyupFunction(event, this);
		remove_calculation_quot_pi_so();

	});
}

/*get material name when select material type*/
function getMaterialName(evt, t, selProcessType = '', c_id = '') {
	//$('.materialNameId').empty();
	//$('.materialNameId').val('');
	$(".uom").val('');
	$(".amount").val('');
	var logged_user = $('#loggedUser').val();
	var option = $(t).find('option:selected');
	var material_type_id = selProcessType != '' ? selProcessType : $(option).val();
	if (material_type_id != '') {
		select2(material_type_id, logged_user);
	}

}

function select2(material_type_id, logged_user) {
	$('.materialNameId').attr('data-where', 'material_type_id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND status=1');
	$('.materialNameId').attr('data-id', 'material');
	$('.materialNameId').attr('data-key', 'id');
	$('.materialNameId').attr('data-fieldname', 'material_name');

}


/*get tax and amount of selected material*/
function getUom(evt, t) {
	var option = $(t).find('option:selected');
	var materialId = option.val();
	var closestId = $(t).closest(".well").attr("id");
	console.log("closestId", closestId);
	$.ajax({
		type: "POST",
		url: site_url + 'crm/getMaterialDataById',
		data: {
			id: materialId
		},
		success: function (data) {
			// console.log("data sdsd", data);
			// alert(dataObj.uomid);
			if (data != '') {
				var dataObj = JSON.parse(data);
				//alert(dataObj.uomid);
				$("#" + closestId + " .amount").val(dataObj.sales_price);
				$("#" + closestId + " #uom").val(dataObj.uom);
				$("#" + closestId + " .gst").val(dataObj.tax);
				  $("#"+closestId+" #uomid").val(dataObj.uomid);
				 // find("input[name='ledger_name[]']")
				 // $('#'+closestId).closest('#uomid').find("input[name='uom_material[]']").val(dataObj.uomid);
				// $("#"+closestId+" .uom_material").val(dataObj.uom);
				// $("#"+closestId+" .amount").val(dataObj.sales_price);
				// $("#"+closestId+" .gst").val(dataObj.gst);
				// $("#"+closestId+" #uom").val(dataObj.uom);
			}
		}
	});

}


/**********************keup function to calculate****************************/
function keyupFunction(evt, t) {
	var closestId = $(t).closest(".well").attr("id");
	var qty = $("#" + closestId + " input[name='qty[]'").val();
	var standard_packing = $("#" + closestId + " input[name='standard_packing[]'").val();
	var materialID = $("#" + closestId + " select[name='material_type_id[]'").val();
	var price = $("#" + closestId + " input[name='price[]'").val();
	var gst = $("#" + closestId + " input[name='gst[]'").val();
	var total_cbf_cal = 0;
	$(".total_cbf").each(function (key, value) {
		var qty1 = $(this).parents('.well').find(".quantity").val();
		total_cbf_cal += parseFloat(qty1) * parseFloat($(value).val());
		// if($(value).val() == ''){
		// var picbf =	$('.total_cbf').val();
			// total_cbf_cal += parseFloat(qty1) * 1;
		// }
		
		
	});
	
	var TotalQty = 0;
	$(".quantity").each(function (key, value) {
		var TotalQtyval = $(this).parents('.well').find(".quantity").val();
		TotalQty += parseFloat(TotalQtyval);
		
	});
	$('#totalQtydata').val(TotalQty);
	
	
	var total_weight_cal = 0;
	$(".total_weight").each(function (key, value) {
	var qty1 = $(this).parents('.well').find(".quantity").val();
	total_weight_cal += parseFloat(qty1) * parseFloat($(value).val());
	});
	if (isNaN(total_cbf_cal)) {
		var total_cbf_cal = 0;
	}
	if (isNaN(total_weight_cal)) {
		var total_weight_cal = 0;
	}
	$('#pi_cbf').val(total_cbf_cal.toFixed(2));
	$('#pi_weight').val(total_weight_cal.toFixed(2));
	var individual_Total = parseFloat(qty) * parseFloat(price);
	if (isNaN(individual_Total)) {
		var individual_Total = 0;
	}
	var individualTotal_withdecimal = individual_Total.toFixed(2);
	var individual_TaxPrice = (individual_Total * gst) / 100;
	$("#" + closestId + " input[name='gst[]'").next('.gst_val').val(individual_TaxPrice);
	var individualPrice_WithGstTotal = individual_Total + individual_TaxPrice;
	if (isNaN(individualPrice_WithGstTotal)) {
		var individualPrice_WithGstTotal = 0;
	}
	
	var individualPrice_WithGstTotal_decimal = individualPrice_WithGstTotal.toFixed(2);
	parseFloat($("#" + closestId + " input[name='totals[]'").val(individualTotal_withdecimal));
	parseFloat($("#" + closestId + " input[name='TotalWithGsts[]'").val(individualPrice_WithGstTotal_decimal));

	var total = 0;
	$(".total").each(function (key, value) {
		total = parseFloat(total) + parseFloat($(value).val());
	});
	if (isNaN(total)) {
		var total = 0;
	}
	var gst_set = 0;
	$(".gst_val").each(function (key, value) {
		gst_set = parseFloat(gst_set) + parseFloat($(value).val());
	});
	if (isNaN(gst_set)) {
		var gst_set = 0;
	}
	var grandTotal = 0;
	$(".totalWithGst").each(function (key, value) {
		grandTotal = parseFloat(grandTotal) + parseFloat($(value).val());
	});
	if (isNaN(grandTotal)) {
		var grandTotal = 0;
	}
	
	// if(standard_packing != 0){
		// var totalBoxqty = qty/standard_packing;
		// $("#" + closestId + " input[name='box[]'").val(Math.ceil(totalBoxqty))
	// }else{
		// $("#" + closestId + " input[name='box[]'").val(0)
	// }
	//$(document).on('keyup', '.getStandardPack', function () {//
		setTimeout(function() {
		$.ajax({
			type: "POST",
			url: site_url + 'crm/getPAckingDAta',
			data: {
				id: materialID
			},
			success: function (data) {
				var packingdata = JSON.parse(data);
				var len = packingdata.length;
				var totalBoxqty = 0;
				 for(var i=0; i<len; i++){
					 		var stanPckQty = packingdata[i].stand_pack;
							
							totalBoxqty += Math.ceil(+qty/stanPckQty);
							if(stanPckQty == ''){
								totalBoxqty = 0;
							}
									
				}
				$("#" + closestId + " input[name='box[]'").val(Math.ceil(totalBoxqty));
			}
			
		});
		}, 2000); 
		
	setTimeout(function() {	
		var BoxxQty = 0;
			$(".BOXQTY").each(function (key, value) {
				var BoxQtyval = $(this).parents('.well').find(".BOXQTY").val();
				BoxxQty += parseFloat(BoxQtyval);
				
			});
			
			$('#totalBox').val(BoxxQty);
		}, 3000); 
	//});
	
	// 
	

	if ($("input[name='agt']").length && $("input[name='agt']").val() != '') {
		grandTotal = grandTotal + parseFloat($("input[name='agt'").val());

	}

	var discount_rate = $("#discount_rate").val();
	
	var discount_value = total*(discount_rate/100);
	var special_discount = $(".special_discount").val();
	var freightCharges = $(".divFreightCharge").val();
	var gfc = $(".divGSTFreight").val();
	var advance_received = $(".divAdvancePaid").text();
	var spd_value = total*(special_discount/100);
	if(discount_value != 0){
		var gstval = 0;
		var AfterDiscVal = 0;
		$(".gst").each(function (key, value) {
			gstval = parseFloat($(value).val());
			 AfterDiscVal =  total - discount_value;
			 gst_set = AfterDiscVal*(gstval/100);
			
			 
		});
		var spd_value = discount_value*(special_discount/100);
	} 
	
	
	
	var div_total = total - discount_value - spd_value;
	var grand_total = div_total+gst_set+freightCharges+gfc;
	var remain_balance = grand_total-advance_received;
	
	// alert(remain_balance);
	// alert(grand_total);

	$("input[name='total'").val(parseFloat(total).toFixed(2));
	$("input[name='grandTotal'").val(parseFloat(grandTotal).toFixed(2));

	$(".divSubTotal").text(parseFloat(total).toFixed(2));
	$(".divDiscountValue").text(parseFloat(discount_value).toFixed(2));
	$(".divSpecialDiscount").text(parseFloat(spd_value).toFixed(2));
	$(".divTotal").text(parseFloat(div_total).toFixed(2));
	$(".divTax").text(parseFloat(gst_set).toFixed(2));
	$(".divGrandTotal").text(parseFloat(grand_total).toFixed(2));
	
	$(".divBalance").text(parseFloat(remain_balance).toFixed(2));
	$(".divTotalLead").text(parseFloat(grandTotal).toFixed(2));
	
	$(".grandTotal").val(parseFloat(grand_total).toFixed(2));

	var grand_total_val = $("[name='total']").val();
	if (grand_total_val > 0 || grand_total_val != '') {
		$(':input[type="submit"]').prop('disabled', false);
	}

}


/*	function keyupFunction(evt , t){
		var closestId = $(t).closest(".well").attr("id");
		var qty , amount ,grand_total;
		qty = parseFloat($("#"+closestId+" input[name='qty[]'").val());
		amnt = parseFloat($("#"+closestId+" input[name='price[]'").val());
			if(isNaN(amnt)) {
				var amnt = 0;
			}
		total_amnt = parseFloat(qty) * parseFloat(amnt);
			if(isNaN(total_amnt)) total_amnt = 0;
			var value = total_amnt.toFixed(2);
			$("#"+closestId+" input[name='total[]'").val(value);
			Grandtotal();
	}
	/*
	function Grandtotal() {
		var grandtot = 0;
		$("input[name='total[]']").each(function(){
			grandtot += parseFloat($(this).val());
			//grandtot += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());

		});
		if(isNaN(grandtot)) grandtot = 0;
		$("#grand_total").val(grandtot.toFixed(2));
	}
*/
function getState(evt, t, type = '') {
	var appendedClass = type != '' ? '.' + type + '.state_id' : '.state_id';
	var appendedClassCity = type != '' ? '.' + type + '.city_id' : '.city_id';
	$(appendedClass).empty();
	$(appendedClassCity).empty();
	var option = $(t).find('option:selected');
	//var country_id = type != ''?type:$(option).val();
	var country_id = $(option).val();
	if (country_id != '') {
		$(appendedClass).attr('data-where', 'country_id = ' + country_id);
		$(appendedClass).attr('data-id', 'state');
		$(appendedClass).attr('data-key', 'state_id');
		$(appendedClass).attr('data-fieldname', 'state_name');
	}
}


function getCity(evt, t, type = '') {
	var appendedClass = type != '' ? '.' + type + '.city_id' : '.city_id';
	$(appendedClass).empty();
	var option = $(t).find('option:selected');
	//var state_id = type != ''?type:$(option).val();
	var state_id = $(option).val();
	if (state_id != '') {
		$(appendedClass).attr('data-where', 'state_id = ' + state_id);
		$(appendedClass).attr('data-id', 'city');
		$(appendedClass).attr('data-key', 'city_id');
		$(appendedClass).attr('data-fieldname', 'city_name');
	}
}


/* function to filter activity log data of lead/account by date range selector */
function activityDateRangeSelector() {
	$('input[name="activityDateRange"]').daterangepicker({
		opens: 'left',
		locale: {
			format: 'DD-MM-YYYY',
		},
	}, function (start, end, label) {
		var lead_id = $('input[name="lead_id"]').val();
		var id = $('input[name="activityRelId"]').val();
		var table = $('input[name="activityRelTable"]').val();
		var fromDate = start.format('YYYY-MM-DD');
		var toDate = end.format('YYYY-MM-DD');
		$.ajax({
			url: site_url + 'crm/activityFilter/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: id,
				fromDate: fromDate,
				toDate: toDate,
				table: table,
			},
			success: function (result) {
				var activityLog = '';
				
				if (result.length > 0) {
					$(result).each(function (i) {
						if (this.activity_type == 'New Task') {
							var img = 'tasks.png';
						} else if (this.activity_type == 'Call Log') {
							var img = 'Call-Log.png';
						} else {
							var img = 'chat.png';
						}
						activityLog += '<li><i class="fa ' + icon + '"></i><div class="message_date">' + this.created_date + '</div><div class="message_wrapper"><h4 class="heading">' + this.subject + '</h4>';
						activityLog += '<blockquote class="message">' + this.comment + '</blockquote>';


						if (this.activity_type == 'New Task') {
							activityLog += 'Due date : ' + this.due_date;
						}


						if (this.attachment) {
							activityLog += '<div class="col-md-12">';
							$(this.attachment).each(function (index) {
								activityLog += '<div class="col-md-2"><div class="image view view-first"><img style="width: 100%; display: block;" src="' + site_url + 'assets/modules/crm/uploads/' + this.file_name + '" alt="image" class="undo"/></div></div>';
							});
							activityLog += '</div>';
						}
						activityLog += '</li>';

					});
					$('.activityMessage').html(activityLog);
				} else {
					$('.activityMessage').html('<li>No Records</li>');
				}

			}
		});
	}, )
}


// Function to add more chatter attachmens in lead and account
function addMoreChatterAttachments() {
	var wrap = $(".fields_wrap"); //Fields wrapper
	var add_btn = $(".field_button"); //Add button ID
	var y = 1; //initlal text box count
	$(add_btn).click(function (e) { //on add input button click
		e.preventDefault();
		y++;
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-6 col-sm-11 col-xs-12" ><input type="file" class="form-control col-md-5 col-xs-5" name="attachment[]"></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});
	$(wrap).on("click", ".rmv_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	})
}

// Function to add more product functionality in Quotation
function addMoreProduct() {
	var maximum = 25; //maximum input boxes allowed
	var wrap_material = $(".input_productre"); //Fields wrapper
	var button_add = $(".addProductButtonre"); //Add button ID
	var x = 1; //initlal text box count
	$(button_add).click(function (e) {
		// alert('22');
		//on add input button click
		e.preventDefault();
		if (x < maximum) { //max input box allowed
			x++;
			//var dataWhere = $("#material").attr("data-where");
			$(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_' + x + '"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label><select class="form-control selectAjaxOption select2 materialNameId Add_mat_onthe_spot" required="required" name="product[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"><label>Description</label><textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Quantity</label><input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity addProductButtonre "  onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)"></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom1[]"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom" readonly><input type="hidden" name="uom[]" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12 price " onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)"><input type="hidden" name="totals[]" class="form-control col-md-7 col-xs-12 total has-feedback-left" value="" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>GST</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly><input  type="hidden"  type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst has-feedback-left" value="" readonly></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');


			var logged_user = $('#loggedUser').val();
			var material_type_id = $('#material_type_id').val();
			console.log("fff", material_type_id);
			select2(material_type_id, logged_user);
			init_select2();
			init_select221();
		}
		//getMaterials(x);
	});
	$(wrap_material).on("click", ".remove_btn", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
		keyupFunction(event, this);
		remove_calculation_quot_pi_so();
	});
}


$(document).ready(function (e) {

	getDashboardCount();
	getLeadStatusGraph();
	getMonthLeadStatusGraph();
	dashboardLeadAcheivedVsTarget();
	dashboardSaleOrder();
	getWinLeadVsTotalGraph();
	getRecentActivities();
	getCrmTableData();


});

// Function to add more product functionality in PI SO
function addmorepro_piso(){
	var maximum = 50; //maximum input boxes allowed
	var wrap_material = $(".input_productre"); //Fields wrapper
	var button_add = $(".addProductButtonre"); //Add button ID
	var x = 1; //initlal text box count
	$(button_add).click(function (e) {
		
		//on add input button click
		var crm_delivery_setting = $("#crm_delivery_setting").val();
		e.preventDefault();
		if (x < maximum) { //max input box allowed
			x++;

			var logged_user = $('#loggedUser').val();
			
			//var dataWhere = $("#material").attr("data-where");
		if(crm_delivery_setting==1){
			
		
			$(wrap_material).append('<div class="well scend-tr mobile-view" style="overflow:auto;" id="chkIndex_' + x + '"> <div class="col-md-2 col-sm-12 col-xs-12 form-group"> <label class="col-md-12">Material Type</label> <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" name="material_type_id[]" id="material_type_id" data-id="material_variants" data-key="id" data-fieldname="item_code" data-where="status=1" tabindex="-1" aria-hidden="true" onchange="getvarientList(event,this)" id="material_type"> <option value="">Select Option</option> </select> <input type="hidden" name="mat_idd_name" id="matrial_Iddd"><input type="hidden" name="matrial_name" id="matrial_name"><input type="hidden" id="serchd_val"> </div><div class="col-md-1 col-sm-12 col-xs-12 form-group"> <label >Material Name <span class="required">*</span></label> <select class="set_mat_name materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name Add_mat_onthe_spot select2-width-imp select2-hidden-accessible" id="mat_name" required="required" name="product[]" onchange="getTax(event,this)" data-where="material_type_id != 213 OR created_by_cid='+logged_user+' AND created_by_cid=0 AND status=1" data-id="material" data-key="id" data-fieldname="material_name" tabindex="-1" aria-hidden="true"> <option value="">Select Option</option> </select> </div><input type="hidden" id="serchd_val"> <input type="hidden" name="crm_delivery_setting[]" value="'+crm_delivery_setting+'"><div class="col-md-1 col-sm-12 col-xs-12 item form-group"><label>Pro-Image</label><div class="Product_Image col-xs-12"></div></div><div class="col-md-1 col-sm-12 col-xs-12 item form-group"><label class="col-md-12">Special Requirement</label><textarea name="description[]" placeholder="Special Requirement" class="form-control col-md-7 col-xs-12" class="description"></textarea></div><div class="col-md-1 col-sm-6 col-xs-12 form-group item"><label class="col-md-12" >Quantity</label><input type="text" name="qty[]" required="required" placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity getStandardPack" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Box</label><input type="text" name="box[]"  placeholder="box" class="BOXQTY form-control col-md-7 col-xs-12" value="" ><input type="hidden" name="standard_packing[]"  placeholder="box" class="standard_packingCls" value="" ></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">UOM</label><input type="text" name="uom1[]" placeholder="uom" class="form-control col-md-7 col-xs-12 uom mat_uom" readonly><input type="hidden" name="uom[]" class="uomid" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Price</label><input readonly type="text" name="price[]" placeholder="Price" class="form-control col-md-7 col-xs-12 price mat_sales_price" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">GST</label><input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst mat_tax" value="" placeholder="gst" readonly><input type="hidden" class="gst_val" value=""></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Total</label><input type="text" name="totals[]" class="form-control col-md-7 col-xs-12 total " value="" readonly><input type="hidden" class="total_cbf" value=""><input type="hidden" class="total_weight" value=""></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div>');
		 }  else if (crm_delivery_setting==0){
			 
			 $(wrap_material).append('<div class="well scend-tr mobile-view" style="overflow:auto;" id="chkIndex_' + x + '"> <div class="col-md-2 col-sm-12 col-xs-12 form-group"> <label class="col-md-12">Material Type</label> <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" name="material_type_id[]" id="material_type_id" data-id="material_variants" data-key="id" data-fieldname="item_code" data-where="status=1" tabindex="-1" aria-hidden="true" onchange="getvarientList(event,this)" id="material_type"> <option value="">Select Option</option> </select> <input type="hidden" name="mat_idd_name" id="matrial_Iddd"><input type="hidden" name="matrial_name" id="matrial_name"><input type="hidden" id="serchd_val"> </div><div class="col-md-1 col-sm-12 col-xs-12 item form-group"><label class="col-md-12">Special Requirement</label><textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"> <label >Material Name <span class="required">*</span></label> <select class="set_mat_name materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name Add_mat_onthe_spot select2-width-imp select2-hidden-accessible" id="mat_name" required="required" name="product[]" onchange="getTax(event,this)" data-where="material_type_id != 213 OR created_by_cid='+logged_user+' AND created_by_cid=0 AND status=1" data-id="material" data-key="id" data-fieldname="material_name" tabindex="-1" aria-hidden="true"> <option value="">Select Option</option> </select> </div><input type="hidden" id="serchd_val"> <input type="hidden" name="crm_delivery_setting[]" value="'+crm_delivery_setting+'"><div class="col-md-1 col-sm-12 col-xs-12 item form-group"><label>Pro-Image</label><div class="Product_Image col-xs-12"></div></div><div class="col-md-1 col-sm-6 col-xs-12 form-group item"><label class="col-md-12" >Quantity</label><input type="text" name="qty[]" placeholder="Qty" required="required" class="form-control col-md-7 col-xs-12 quantity getStandardPack" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Box</label><input type="text" name="box[]"  placeholder="box" class="BOXQTY form-control col-md-7 col-xs-12" value="" ><input type="hidden" name="standard_packing[]"  placeholder="box" class="standard_packingCls" value="" ></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">UOM</label><input type="text" name="uom1[]" placeholder="uom" class="form-control col-md-7 col-xs-12 uom mat_uom" readonly><input type="hidden" name="uom[]" class="uomid" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Price</label><input readonly type="text" name="price[]" placeholder="Price" class="form-control col-md-7 col-xs-12 price mat_sales_price" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">GST</label><input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst mat_tax" value="" placeholder="gst" readonly><input type="hidden" class="gst_val" value=""></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Total</label><input type="text" name="totals[]" class="form-control col-md-7 col-xs-12 total " value="" readonly><input type="hidden" class="total_cbf" value=""><input type="hidden" class="total_weight" value=""></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div>');
		 }
			var logged_user = $('#loggedUser').val();
			var material_type_id = $('#material_type_id').val();
			console.log("fff======>ddddd", material_type_id);
			//select2(material_type_id, logged_user);
			init_select2();
			init_select221();
			//mat_status_onchange();
			//mat_price_list_onchange();
		}
		//getMaterials(x);
	});
	$(wrap_material).on("click", ".remove_btn", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;

		keyupFunction(event, this);
		remove_calculation_quot_pi_so();
		var total_cbf_cal = 0;
		$(".total_cbf").each(function (key, value) {
		var qty = $(this).parents('.well').find(".quantity").val();
		total_cbf_cal += parseFloat(qty) * parseFloat($(value).val());
		});
		var total_weight_cal = 0;
		$(".total_weight").each(function (key, value) {
		var qty = $(this).parents('.well').find(".quantity").val();
		total_weight_cal += parseFloat(qty) * parseFloat($(value).val());
		});
		$('#pi_cbf').val(total_cbf_cal.toFixed(2));
		$('#pi_weight').val(total_weight_cal.toFixed(2));

		});
}

function getTax_pl(evt, t){
				var option = $(t).find('option:selected');
				var materialId = option.val();
				var closestId = $(t).closest(".well").attr("id");
				var login_user_idd = $('#loggedUser').val();
				// alert(login_user_idd);
				var selected_customer = $('option:selected', '#account_id').val();
				$.ajax({
					type: "POST",
					url: site_url + 'crm/get_mat_price_list',
					data: {
						id:materialId,login_user:login_user_idd,selected_customer:selected_customer
					},
					success: function (data) {
						if (data != '') {
							var dataObj = JSON.parse(data);
							parseFloat($("#" + closestId + " input[name='gst[]'").val(dataObj.gst));
							parseFloat($("#" + closestId + " input[name='uom1[]'").val(dataObj.uom));
							parseFloat($("#" + closestId + " input[name='uom[]'").val(dataObj.uomid));
							parseFloat($("#" + closestId + " input[name='quantity[]'").val(''));
							parseFloat($("#" + closestId + " input[name='price[]").val(dataObj.selling_price));
							parseFloat($("#" + closestId + " input[name='individualTotal[]'").val(''));
							parseFloat($("#" + closestId + " input[name='individualTotalWithGst[]'").val(''));
							$(".divTotal").html(0);
							$(".divSubTotal").html(0);
						}
					}
				});
				var tax = option.attr('data-tax');
				var closestId = $(t).closest(".well").attr("id");
				parseFloat($("#" + closestId + " input[name='gst[]'").val(tax));
			 // var tax = option.attr('data-tax');
			 // var closestId = $(t).closest(".well").attr("id");
			 // parseFloat($("#" + closestId + " input[name='gst[]'").val(tax));
}

function mat_status_onchange(){
	$('.mat_status_on_change').change(function(){
		var selected_mat_id = $(this).val();
		var matrial_select =  $(this);
		console.log("klkmkmklmkmk===>>>>>",selected_mat_id);
		var selected_customer = $('option:selected', '#account_id').val();
		console.log(selected_customer);
		var login_user_idd = $('#loggedUser').val();
		$.ajax({
			type: "POST",
			url: site_url+'crm/get_mat_status_price_list/',
			data: { id:selected_mat_id,login_user:login_user_idd,selected_customer:selected_customer},
			success: function(result) {
				var obj = jQuery.parseJSON(result);
					if(obj.msg == 'true'){
						var selected_mat_text =  $(matrial_select).closest('.well').find("select[name='product[]'] option:selected").text();
						$('#mat_msg').html('Price List Expired For' + ' '+ selected_mat_text);
						 $('#send').attr("disabled", "disabled");

				}else if(obj.msg == 'false'){
						//$('#mat_msg').html('');
						//$('#send').removeAttr("disabled");
				}
			}
		});
 	});
}

/*---------------Sale target filter by month and year ------------------------*/
$(function () {
	$('input[name="start_date_filter"]').daterangepicker({
		singleDatePicker: true,
		//singleClasses: "picker_3",
		locale: {
			format: 'YYYY-MM',
		}
	}, function (start, end, label) {
		$('input[type=search]').val(start.format('YYYY-MM'));
		$('input[type=search]').keyup();
	});
});

/*---------------Lead status filter in lead listing ------------------------*/

$("#lead_status_filter").on("change", function () {
// get phone number by contact id in sale order or proforma invoice
	$("#lead_owner_filter").removeAttr('selected');
	$("#lead_owner_filter option:contains('All')").attr('selected', 'selected');
	var statusSelected = $(this).find("option:selected");
	var statusNameSelected = statusSelected.text();
	// alert(statusNameSelected);

	console.log('Valuee==>>>>', statusNameSelected);
	if (statusNameSelected == 'All') {
		$('input[type=search]').val('');
	} else {
		//$("#lead_owner_filter option[text=All]").attr('selected', 'selected');
		//$("#lead_owner_filter").find("option[text=All]").attr("selected", true);

		$('input[type=search]').val(statusNameSelected);

	}
	$('input[type=search]').keyup();
});

/*---------------Lead Owner filter in lead listing ------------------------*/
$("#lead_owner_filter").on("change", function () { // get phone number by contact id in sale order or proforma invoice
	$("#lead_status_filter").removeAttr('selected');
	$("#lead_status_filter option:contains('All')").attr('selected', 'selected');
	var leadOwnerSelected = $(this).find("option:selected");
	var leadOwnerNameSelected = leadOwnerSelected.text();
	if (leadOwnerNameSelected == 'All') {
		$('input[type=search]').val('');
	} else {
		//$("#lead_status_filter option[text=All]").attr('selected', 'selected');

		//$("#lead_status_filter").find("option[text=All]").attr("selected", true);
		$('input[type=search]').val(leadOwnerNameSelected);

	}
	$('input[type=search]').keyup();
});


function getMonthLeadStatusGraph(startDate = '', endDate = '') {
	$("#graph_bar_group_lead").empty();
	if ($('#graph_bar_group_lead').length) {
		if (startDate != '' && endDate != '') {
			ajaxData = {
				'startDate': startDate,
				'endDate': endDate
			};
		} else {
			ajaxData = {};
		}

		$.ajax({
			//url: site_url +'crm/monthLeadStatusGraph/',
			url: site_url + 'crm/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			//data: {},
			data: ajaxData,
			success: function (result) {
				result = result.monthLeadStatusGraph;
				Morris.Bar({
					element: 'graph_bar_group_lead',
					data: result,
					xkey: 'period',
					barColors: ['#F75151', '#34495E', '#ACADAC', '#3498DB', '#008000', '#ff0000'],
					ykeys: ['New', 'Contacted', 'Qualified', 'UnQualified', 'Win', 'Loose'],
					labels: ['New', 'Contacted', 'Qualified', 'UnQualified', 'Win', 'Loose'],
					hideHover: 'auto',
					xLabelAngle: 60,
					resize: true
				});

			}
		});
	}
}


function dashboardLeadAcheivedVsTarget(startDate = '', endDate = '') {

	if ($('#lineChart1').length) {
		if (startDate != '' && endDate != '') {
			ajaxData = {
				'startDate': startDate,
				'endDate': endDate
			};
		} else {
			ajaxData = {};
		}
		$.ajax({
			//url: site_url +'crm/monthLeadTargetGraph/',
			url: site_url + 'crm/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			data: ajaxData,
			success: function (result) {
				console.log('result==>>', result);
				result = result.monthLeadTargetGraph;
				var ctx = document.getElementById("lineChart1");
				var lineChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: ["January", "February", "March", "April", "May", "June", "July", "Aug", "Sept", "october", "november", "december"],
						datasets: [{
							label: "Lead Target",
							backgroundColor: "rgba(38, 185, 154, 0.31)",
							borderColor: "rgba(38, 185, 154, 0.7)",
							pointBorderColor: "rgba(38, 185, 154, 0.7)",
							pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
							pointHoverBackgroundColor: "#fff",
							pointHoverBorderColor: "rgba(220,220,220,1)",
							pointBorderWidth: 1,
							//data: [31, 74, 6, 39, 20, 85, 7,6,78,65,32,65]
							data: result.leadTarget
						}, {
							label: "Lead Acheived",
							backgroundColor: "rgba(3, 88, 106, 0.3)",
							borderColor: "rgba(3, 88, 106, 0.70)",
							pointBorderColor: "rgba(3, 88, 106, 0.70)",
							pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
							pointHoverBackgroundColor: "#fff",
							pointHoverBorderColor: "rgba(151,187,205,1)",
							pointBorderWidth: 1,
							//data: [82, 23, 66, 9, 99, 4, 2,85,96,32,45,78]
							data: result.leadAcheived
						}]
					},
				});
			}
		});


	}

}


function dashboardSaleOrder(startDate = '', endDate = '') {
	$("#graph_sale_order").empty();
	$("#graph_sale_order_count").empty();
	if ($('#graph_sale_order').length) {
		if (startDate != '' && endDate != '') {
			ajaxData = {
				'startDate': startDate,
				'endDate': endDate
			};
		} else {
			ajaxData = {};
		}

		$.ajax({
			//url: site_url +'crm/monthSaleOrderGraph/',
			url: site_url + 'crm/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			//data: {},
			data: ajaxData,
			success: function (result) {
				result = result.monthSaleOrderGraph;
				console.log('resultSaleOrderPriceData===>>>', result);


				saleOrderPriceJsonObj = [];
				$(result).each(function () {
					item = {}
					item["period"] = $(this)[0].period;
					item["Amount"] = $(this)[0].Amount;
					saleOrderPriceJsonObj.push(item);
				});

				saleOrderPriceCountJsonObj = [];
				$(result).each(function () {
					saleOrderPriceCountItem = {}
					saleOrderPriceCountItem["period"] = $(this)[0].period;
					saleOrderPriceCountItem["Approve"] = $(this)[0].Approve;
					saleOrderPriceCountItem["Disapprove"] = $(this)[0].Disapprove;
					saleOrderPriceCountJsonObj.push(saleOrderPriceCountItem);
				});
				console.log('jsonObjsaleOrderPriceCountJsonObj===>>>', saleOrderPriceCountJsonObj);
				Morris.Bar({
					element: 'graph_sale_order',
					//  data: result,
					data: saleOrderPriceJsonObj,
					xkey: 'period',
					//barColors: ['#ACADAC','#F75151' ,'#008000', '#ff0000'],
					barColors: ['#008000', '#F75151'],
					//  ykeys: ['Approve', 'Disapprove' ],
					//  labels: ['Approve', 'Disapprove' ],
					//ykeys: ['Approve', 'Disapprove','Amount' ],
					ykeys: ['Amount'],
					// labels: ['Approve', 'Disapprove','Amount' ],
					labels: ['Amount'],
					hideHover: 'auto',
					xLabelAngle: 60,
					resize: true
				});

				Morris.Bar({
					element: 'graph_sale_order_count',
					//  data: result,
					data: saleOrderPriceCountJsonObj,
					xkey: 'period',
					//barColors: ['#ACADAC','#F75151' ,'#008000', '#ff0000'],
					barColors: ['#008000', '#ff0000', '#F75151'],
					labels: ['Approve', 'Disapprove'],
					ykeys: ['Approve', 'Disapprove'],
					hideHover: 'auto',
					xLabelAngle: 60,
					resize: true
				});


			}
		});
	}
}


function getLeadStatusGraph(startDate = '', endDate = '') {
	if ($("#graph_donut_lead").length) {
		if (startDate != '' && endDate != '') {
			ajaxData = {
				'startDate': startDate,
				'endDate': endDate
			};
		} else {
			ajaxData = {};
		}

		$.ajax({
			//	url: site_url +'crm/getLeadStatusGraph/',
			url: site_url + 'crm/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			//data: {},
			data: ajaxData,
			success: function (response) {
				//var result = response[0];
				var result = response.getLeadStatusGraph[0];
				console.log('result===>>', result);
				var ptotal = parseInt(result.New) + parseInt(result.Contacted) + parseInt(result.Qualified) + parseInt(result.Unqualified) + parseInt(result.Win) + parseInt(result.Loose);
				if (ptotal == 0) {
					//$("#graph_donut_lead").css("display","none");
					$("#graph_donut_lead").empty();
					$("#graph_donut_lead").html("No Data");

				}
				Morris.Donut({
					element: 'graph_donut_lead',
					data: [{
							label: 'New',
							value: ((parseInt(result.New) / ptotal) * 100).toFixed(2),
							count: result.New
						},
						{
							label: 'Contacted',
							value: ((parseInt(result.Contacted) / ptotal) * 100).toFixed(2),
							count: result.Contacted
						},
						{
							label: 'Qualified',
							value: ((parseInt(result.Qualified) / ptotal) * 100).toFixed(2),
							count: result.Qualified
						},
						{
							label: 'UnQualified',
							value: ((parseInt(result.Unqualified) / ptotal) * 100).toFixed(2),
							count: result.Unqualified
						},
						{
							label: 'Win',
							value: ((parseInt(result.Win) / ptotal) * 100).toFixed(2),
							count: result.Win
						},
						{
							label: 'Loose',
							value: ((parseInt(result.Loose) / ptotal) * 100).toFixed(2),
							count: result.Loose
						}
					],
					colors: ['#F75151', '#34495E', '#ACADAC', '#3498DB', '#008000', '#ff0000'],
					formatter: function (y, data) {
						return data.count + "  (" + y + "%" + ")";
					},
					resize: true
				});

			}
		});
	}
}


function getWinLeadVsTotalGraph(startDate = '', endDate = '') {
	if ($(".progress").length) {
		if (startDate != '' && endDate != '') {
			ajaxData = {
				'startDate': startDate,
				'endDate': endDate
			};
		} else {
			ajaxData = {};
		}
		$.ajax({
			//url: site_url +'crm/getWinLeadVsTotalGraph/',
			url: site_url + 'crm/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			data: ajaxData,
			success: function (response) {
				var result = response.getWinLeadVsTotalGraph[0];
				$('.win').html('Success : ' + result.Win);
				$('.total').html('Total : ' + result.Total);
				if (result.Win == 0) {
					var winPercentage = 0;
				} else {
					var winPercentage = result.Win * 100 / result.Total;
				}
				$('.progress-bar').css('width', winPercentage + '%');
			}
		});
	}
}

/*   Show Upper counts from each module of CRM  */
function getDashboardCount(startDate = '', endDate = '') {
	if (startDate != '' && endDate != '') {
		ajaxData = {
			'startDate': startDate,
			'endDate': endDate
		};
	} else {
		ajaxData = {};
	}
	$.ajax({
		//url: site_url +'crm/getDashboardCount/',
		url: site_url + 'crm/graphDashboardData/',
		dataType: 'json',
		type: 'POST',
		data: ajaxData,
		success: function (response) {
			console.log('response===>>', response);
			var dashboardCountHtml = '';
			$.each(response.getDashboardCount, function (key, value) {
				dashboardCountHtml += '<div  style="width:20%;" class=" animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12"><div class="tile-stats" ><div class="icon"><i class="' + value.icon + '"></i></div><div class="count">' + value.totalCount + '</div><h3>' + value.name + '</h3><p>' + value.description + '</p></div></div>';
			});
			$('.top_tiles').html(dashboardCountHtml);

		}
	});
}


function getRecentActivities(startDate = '', endDate = '') {
	if (startDate != '' && endDate != '') {
		ajaxData = {
			'startDate': startDate,
			'endDate': endDate
		};
	} else {
		ajaxData = {};
	}
	$.ajax({
		//url: site_url +'crm/recentActivitiesDashboardData/',
		url: site_url + 'crm/graphDashboardData/',
		dataType: 'json',
		type: 'POST',
		data: ajaxData,
		success: function (response) {
			console.log('resonse===>>>', response);
			var leadActicityHtml = '';
			if ($.isEmptyObject(response.leadActivity)) {
				$('.leadDashboardActivity').html('No  records');
			} else {
				$.each(response.leadActivity, function (key, value) {
					console.log('value===>>>', value);
					var company = value.company == null ? 'Lead' : value.company;
					leadActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>' + company + '</a></h2><div class="byline"><span>Created Date: ' + value.created_date + '</span></div> <div class="byline"><span> <a>Assigned To : ' + value.name + '</a></span><div class="byline"><span>Due Date: ' + value.due_date + '</span></div></div><div class="byline"><span>Subject : ' + value.subject + '</span></div><p class="excerpt">' + value.comment + '</a></p></div></div></li>';
				});

				$('.leadDashboardActivity').html(leadActicityHtml);
			}


			var accountActicityHtml = '';
			if ($.isEmptyObject(response.accountActivity)) {
				$('.accountDashboardActivity').html('No  records');
			} else {
				$.each(response.accountActivity, function (key, value) {
					console.log('value===>>>', value);
					var accountName = value.name == null ? 'Account' : value.name;
					accountActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>' + accountName + '</a></h2><div class="byline"><span>Created Date: ' + value.created_date + '</span></div> <div class="byline"><span> <a>Assigned To : ' + value.name + '</a></span><div class="byline"><span>Due Date: ' + value.due_date + '</span></div></div><div class="byline"><span>Subject : ' + value.subject + '</span></div><p class="excerpt">' + value.comment + '</a></p></div></div></li>';
				});
				$('.accountDashboardActivity').html(accountActicityHtml);
			}

			var saleOrderActicityHtml = '';
			if ($.isEmptyObject(response.saleOrderActivity)) {
				$('.saleOrderDashboardActivity').html('No  records');
			} else {
				$.each(response.saleOrderActivity, function (key, value) {
					console.log('value===>>>', value);
					var accountName = value.name == null ? 'Account' : value.name;
					var contactName = value.first_name == null ? 'Contact' : value.first_name + ' ' + value.last_name;
					saleOrderActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>' + accountName + '</a></h2><div class="byline"><span>Created Date: ' + value.created_date + '</span></div> <div class="byline"><span> <a>Contact Name To : ' + contactName + '</a></span><div class="byline"><span>Due Date: ' + value.payment_date + '</span></div></div><div class="byline"></div><p class="excerpt">Amount : ' + value.grandTotal + '</a></p></div></div></li>';
				});
				$('.saleOrderDashboardActivity').html(saleOrderActicityHtml);
			}

		}
	});
}


function getCrmTableData(startDate = '', endDate = '') {
	if (startDate != '' && endDate != '') {
		ajaxData = {
			'startDate': startDate,
			'endDate': endDate
		};
	} else {
		ajaxData = {};
	}
	$.ajax({
		//url: site_url +'crm/recentActivitiesDashboardData/',
		url: site_url + 'crm/graphDashboardData/',
		dataType: 'json',
		type: 'POST',
		data: ajaxData,
		success: function (response) {
			console.log('resonse===>>>', response);
			/* var leadActicityHtml = '';
			$.each( response.leadActivity, function( key, value ) {
				console.log('value===>>>',value);
				var company = value.company == null?'Lead':value.company;
				leadActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+company+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
			});
			$('.leadDashboardActivity').html(leadActicityHtml);

			var accountActicityHtml = '';
			$.each( response.accountActivity, function( key, value ) {
				console.log('value===>>>',value);
				var accountName = value.name == null?'Account':value.name;
				accountActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+accountName+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
			});
			$('.accountDashboardActivity').html(accountActicityHtml); */
		}
	});
}


/*  Dashboard filteration data */
$('.dashboardFilter').daterangepicker({
	opens: 'left',
	useCurrent: true,
	locale: {
		format: 'YYYY-MM',
	},
}, function (start, end, label) {
	var startDate = start.format('YYYY-MM-00 00:00:00');
	var endDate = end.format('YYYY-MM-00 00:00:00');
	var dateRangeHtml = $(this)[0].element.context;
	$("#area-chart2").empty();
	getMonthLeadStatusGraph(startDate, endDate);
	$("#lineChart1").empty();
	dashboardLeadAcheivedVsTarget(startDate, endDate);
	$("#graph_sale_order").empty();
	dashboardSaleOrder(startDate, endDate);
	$("#graph_donut_lead").empty();
	getLeadStatusGraph(startDate, endDate);
	getWinLeadVsTotalGraph(startDate, endDate);
	getDashboardCount(startDate, endDate);
	getRecentActivities(startDate, endDate);
	getCrmTableData(startDate, endDate);


});


//   Function to show the modal with disapprove reasonof sale order of CRM
$('.graphCheckbox').click(function (e) {
	var show = 0;
	if ($(this).is(":checked")) show = 1;
	else show = 0;
	var graph_id = $(this).attr('id');
	var ajaxData = {
		'graph_id': graph_id,
		'show': show
	};
	$.ajax({
		url: site_url + 'crm/showDashboardOnRequirement/',
		dataType: 'json',
		type: 'POST',
		data: ajaxData,
		success: function (response) {
			console.log('response===>>>>', response);
		}
	});
});

//Print Function
function printData()
{
	  $('.pagination').hide();
	  $('.dataTables_info').hide();
	  $('.dataTables_length').hide();
	  $('.dataTables_filter').hide();
	  $('.hidde').hide();
	  $('.btn-group').hide();
   var divToPrint=document.getElementById("print_div_content");
	newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
    location.reload();

}

$('#bbtn').on('click',function(){
	printData();
 })

/*
 function Print_data_new(){


		document.getElementById("btnPrint").onclick = function () {
		//var divToPrint1 = document.getElementById("print_divv");


		//	var head = document.getElementsByTagName('HEAD')[0].innerHTML;
			    printElement(document.getElementById("print_divv"));

			    var modThis = document.querySelector("#print_divv");
			   // modThis.appendChild(head);

			    window.print();

			function printElement(elem) {
			    var domClone = elem.cloneNode(true);

			    var $printSection = document.getElementById("print_divv");

			    if (!$printSection) {
			        var $printSection = document.createElement("div");
			        $printSection.id = "print_divv";
			        document.body.appendChild($printSection);
			    }

			    $printSection.innerHTML = "";

			    $printSection.appendChild(domClone);
			} */
/*var head = document.getElementsByTagName('HEAD')[0].innerHTML;

var win = window.open('','printwindow');
win.document.write('<html><head><title>Print it!</title>'+ head +'</head><body>');
win.document.write($("#print_divv").html());
win.document.write('</body></html>');
win.print();
//win.close();


		//$('button').on('click', openPrintDialogue);


/*  var w = window.open();

  var html = $("#print_divv").html();
  var head = document.getElementsByTagName('HEAD')[0].innerHTML;

  $(w.document.body).html(html);
  $(w.document.head).html(head);
   w.print(); */


/*$(function() {
    $("a#print").click(nWin);
});*/


//Works with Chome, Firefox, IE, Safari
//Get the HTML of div
/*  var title = document.title;
  var divElements = document.getElementById('print_divv').innerHTML;
  var printWindow = window.open("", "_blank", "");
  var head = document.getElementsByTagName('HEAD')[0].innerHTML;
  //open the window
  printWindow.document.open();
  //write the html to the new window, link to css file
  printWindow.document.write('<html><head><title>' + title + '</title></head><body>');
   printWindow.document.write(head);
  printWindow.document.write(divElements);
  printWindow.document.write('</body></html>');
  printWindow.document.close();
  printWindow.focus();
  //The Timeout is ONLY to make Safari work, but it still works with FF, IE & Chrome.
  setTimeout(function() {
  	//console.log(printWindow);
      printWindow.print();
     // printWindow.close();
  }, 100); */

//newWin= window.open("");

//	newWin.document.write(head.outerHTML);
//newWin.document.write(divToPrint1.outerHTML+head.outerHTML);
//newWin.print();
//newWin.document.print();

//newWin.close();
//location.reload();


//	}


//}


/***************************************************************Function to check the validation of a company's GSTIN No.  DD****************************************************/
function fnValidateGSTIN(Obj) {
	/*
	$("div.alert").remove();
	$('.gstin').parent('div').siblings().remove('.alert');
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
			$(".signUpBtn").attr("disabled", "disabled");
			return false;
		} else {
			$(".signUpBtn").removeAttr("disabled");
			$('.gstin').closest('.item').removeClass('bad');
			console.log("Correct GSTIN No");
		}
	}
	*/
	
	 $(document).on("keyup",".GSTValidORNOT",function(){
		var GSTNO = $(this).val();
			var count = $('.GSTValidORNOT').val().length;
		
		if(count >= 15){
		
		
			$.ajax({
				type: "POST",
				url: site_url + 'crm/gstvalidation/',
				data: {
					GSTNO: GSTNO
				},
				success: function (result) {
					console.log('result =====>',result)
					$('.Gstmsg').text(result);
					// if(result != ''){
						// $('.Gstmsg').val(result);
					// }else{
						// $('.Gstmsg').val('Invalid GSTNO');
					// }
				}
			});
		}else{
			$('.Gstmsg').text('Invalid GSTNO');
		}	
			
	});

}

/***************************************************************end Function to check the validation of a company's GSTIN No. DD ****************************************************/


//*************************************************************Add More Material  On the spot in performa invoice and sale order***************************/
function init_select221() {
	$('.materialNameId').select2({
		allowClear: true,
		placeholder: 'Material Name',
		ajax: {
			url: site_url + 'Ajaxrequest/ajaxSelect2search',
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
		},
		language: {
			noResults: function () {

				var searched_value = $('.select2-search__field').val();
				$('#serchd_val').val(searched_value);
				$('#material_name').val(searched_value);
				var matID = $('#material_type_id').val();
				//console.log("matId",matID);
				$('#material_type_id').val(matID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_material_cls_name'>Add Material</span>";
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});


}
$(document).on("click", ".add_material_cls_name", function () {

	var searched_text_val = $('#serchd_val').val();
	var searched_text_val1 = $('#material_name').val();
	var materialId = $('#material_type_id').val();
	var mtt = $('.tyhg').val();
	//alert(materialId);

	// console.log('materialId',materialId);
	setTimeout(function () {
		$('#material_name').val(searched_text_val);
		$('#material_name').val(searched_text_val1);
		$('#materialtypeid').val(materialId);
		$('.frfr').val(mtt);
	}, 2000);
	setTimeout(function () {
		$('#serchd_val').val();
	}, 1000);
});

$(document).on("click", ".add_material_cls_name", function () {
	//To get Matrieal Type Ajax

	$('#myModal_Add_matrial_details').modal('show');
	var btn_html = $(this).html();
	$('#add_matrial_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger


});


$(document).on("click", ".close_sec_model", function () {
	$('#myModal_Add_matrial_details').modal('hide');
	$('.nav-md').addClass('modal-open');


});

$(document).on("change", ".add_material_cls", function () {
	var mat_type_id = $('.material_type_id').val();

	$.ajax({
		type: "POST",
		url: site_url + 'crm/Get_matrial_type/',
		data: {
			mat_id: mat_type_id
		},
		success: function (result) {
			if (result != '') {
				var objss = JSON.parse(result);

				var len = objss.length;
				for (var i = 0; i < len; i++) {
					var id = objss[i].id;
					var name = objss[i].name;
					var prefix = objss[i].prefix;

					$('#matrial_Iddd').val(id);
					$('#matrial_name').val(name);
					$('#prefix').val(prefix);
					//var str_prefix = '<input type="hidden" value="'+prefix+'" >';*/

				}
			}
		}
	});
});

$(document).on("click", "#Add_matrial_details_on_button_click", function () {

	$('#mssg34').empty();
	var material_name = $('#material_name').val();
	var hsn_code = $('#hsn_code').val();
	//var uom  = $('#uom').val();
	//var uom  = $("select#uom").filter(":selected").val();

	var uom = $("select#uom option").filter(":selected").val();

	//console.log("value of uom==>>>",uom);
	var specification = $('#specification').val();
	var gst_tax = $('#gst_tax').val();
	var opening_balance = $('#opening_balance_Sec').val();
	var material_type_id = $('#material_type_idr').val();
	//var material_type_id  = $('#matrial_Iddd').val();

	var prefix = $('#prefix').val();
	var error = 0;
//alert(material_type_id);
	// console.log('material_name==>>', material_name);
	// console.log('hsn_code==>>', hsn_code);
	// console.log('uom==>>', uom);
	// console.log('specification==>>', specification);
	// console.log('gst_tax==>>', gst_tax);
	// console.log('opening_balance==>>', opening_balance);
	// console.log('material_type_id==>>', material_type_id);


	if (material_name == '') {
		$('#material_name').css('border', '1px solid #b94a48');
		$('#material_name').closest(".form-group").find("span").text('This field is required');
		var error = 1;
	}
	if(material_type_id == ''){
				$('#material_type_id').css('border', '1px solid #b94a48');
				$('#material_type_id').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}
	// if(uom == ''){
	// $('#uom_id').css('border', '1px solid #b94a48');
	// $('#uom_id').closest(".form-group").find("span").text('This field is required');
	// var error = 1;
	// }else{
	// $('#uom_id').css('border', '1px solid #dedede');
	// $('#uom_id').closest(".form-group").find("span").text('');
	// }
	// if(hsn_code == ''){
	// $('#hsn_code').css('border', '1px solid #b94a48');
	// $('#hsn_code').closest(".form-group").find("span").text('This field is required');
	// var error = 1;
	// }else{
	// $('#hsn_code').css('border', '1px solid #dedede');
	// $('#hsn_code').closest(".form-group").find("span").text('');
	// }

	/*	if(opening_balance_Sec == ''){
				$('#opening_balance_Sec').css('border', '1px solid #b94a48');
				$('#opening_balance_Sec').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#opening_balance_Sec').css('border', '1px solid #dedede');
				$('#opening_balance_Sec').closest(".form-group").find("span").text('');
			}*/


	if (error == 1) {
		return false;
	} else {

		$.ajax({
			type: "POST",
			url: site_url + 'crm/add_matrial_Details_onthe_spot/',
			data: {
				material_name: material_name,
				hsn_code: hsn_code,
				gst_tax: gst_tax,
				uom: uom,
				specification: specification,
				material_type_id: material_type_id,
				prefix: prefix,
				opening_balance: opening_balance
			},
			success: function (htmlStr) {
				//alert(htmlStr);
				// return false;
				if (htmlStr.length > 0) {
					$('#mssg34').html('<span style="color:green;">Material Added Successfully.</span>');
					$("#insert_Matrial_data_id").trigger('reset');
					setTimeout(function () {
						$('#myModal_Add_matrial_details').modal('hide');
						$('#myModal_Add_matrial_details_purchse').modal('hide');
						$('.nav-md').addClass('modal-open');
					}, 1000);
					setTimeout(function () {
						$('.nav-md').addClass('modal-open');
					}, 1500);
					$('.nav-md').addClass('modal-open');
				} else {
					$('#mssg34').html('<span style="color:red;">Not Added.</span>');
				}
				setTimeout(function () {
					$('#mssg34').html('<span> </span>');
				}, 3000);


			}
		});
	}
});
/* ADD QUICK ADD SCRIPT*/
/****************************quick add customer name in performa invoice********************************************************/
function init_select22() {
	$('.customerName').select2({
		allowClear: true,
		placeholder: 'Customer Name',
		ajax: {
			url: site_url + 'Ajaxrequest/ajaxSelect2search',
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
		},
		language: {
			noResults: function () {

				var searched_value = $('.select2-search__field').val();
				$('#serchd_val').val(searched_value);
				$('#customer_name').val(searched_value);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_customer_cls_name'>Add Customer</span>";
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
	
	
	
	
	
	
	
}


$(document).on("click", ".add_customer_cls_name", function () {

	var searched_text_val = $('#serchd_val').val();
	var searched_text_val1 = $('#customer_name').val();
	//var materialId = $('#material_type_id').val();
	setTimeout(function () {
		$('#customer_name').val(searched_text_val);
		$('#customer_name').val(searched_text_val1);
		// $('#material_name_id').val(materialId);
	}, 2000);
	setTimeout(function () {
		$('#serchd_val').val();
	}, 1000);
});

$(document).on("click", ".add_customer_cls_name", function () {
	//To get Matrieal Type Ajax

	$('#myModal_Add_customer_details').modal('show');
	var btn_html = $(this).html();
	$('#add_customer_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger


});


$(document).on("click", ".close_sec_model2", function () {


	setTimeout(function () {
		$('#myModal_Add_customer_details').modal('hide');
		$('.nav-md').addClass('modal-open');
	}, 500);

});


$(document).on("click", "#Add_customer_details_on_button_click", function () {


	$('#mssg34').empty();
	var account_owner = $('#loggedUser').val();
	var customer_name = $('#customer_name').val();
	var type_of_customer = $('#type_of_customer').val();
	var gstin_value = $('#gstin_value').val();
	var phone_number = $('#phone_number').val();
	var billing_street = $('#billing_street').val();
	//var closing_balance  = $('#closing_balance').val();
	var billing_zipcode = $('#billing_zipcode').val();
	var billing_country = $('#country_id').val();

	var billing_state = $('#state_id').val();

	var billing_city = $('#city_id').val();
	//console.log("ddd",account_owner);
	var error = 0;
	if (customer_name == '') {
		$('#customer_name').css('border', '1px solid #b94a48');
		$('#customer_name').closest(".form-group").find("span").text('This field is required');
		var error = 1;
	} else {
		$('#customer_name').css('border', '1px solid #dedede');
		$('#customer_name').closest(".form-group").find("span").text('');
	}
	if (type_of_customer == '') {
		$('#type_of_customer').css('border', '1px solid #b94a48');
		$('#type_of_customer').closest(".form-group").find("span").text('This field is required');
		var error = 1;
	} else {
		$('#type_of_customer').css('border', '1px solid #dedede');
		$('#type_of_customer').closest(".form-group").find("span").text('');
	}

	if (error == 1) {
		return false;
	} else {

		$.ajax({
			type: "POST",
			url: site_url + 'crm/add_customer_Details_onthe_spot/',
			data: {
				account_owner: account_owner,
				customer_name: customer_name,
				type_of_customer: type_of_customer,
				gstin: gstin_value,
				phone_number: phone_number,
				billing_street: billing_street,
				billing_zipcode: billing_zipcode,
				billing_country: billing_country,
				billing_state: billing_state,
				billing_city: billing_city
			},
			success: function (htmlStr) {
				if (htmlStr == true) {
					//alert('fgf');
					$('#message').html('<span style="color:green;">Contact Added Successfully.</span>');

					$("#insert_contact_data_id").trigger('reset');
					setTimeout(function () {

						$('#myModal_Add_customer_details').modal('hide');
						$('.nav-md').addClass('modal-open');
					}, 1000);
					setTimeout(function () {
						$('.nav-md').addClass('modal-open');
					}, 1500);
					$('.nav-md').addClass('modal-open');
				} else {
					$('#message').html('<span style="color:red;">Not Added.</span>');
				}
				setTimeout(function () {
					$('#message').html('<span> </span>');
				}, 3000);
			}
		});
	}
});

/* ADD QUICK ADD SCRIPT*/
/* Industry multiple Select */
function AddMultipleselect() {
	$(".industry").select2({
		multiple: true,
		placeholder: 'Select Industry'
	});
}


/********************quick add contact name in performa invoice /sale order********************************************************/
function init_select212() {
	$('.contactPerson').select2({
		allowClear: true,
		placeholder: 'Contact Name',
		ajax: {
			url: site_url + 'Ajaxrequest/ajaxSelect2search',
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
		},
		language: {
			noResults: function () {

				var searched_value = $('.select2-search__field').val();
				$('#serched_val').val(searched_value);

				$('#contact_name').val(searched_value);
				var account_id = $('#account_id option:selected').val();

				$('#accountId').val(account_id);

				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_contact_name'>Add Contact Person</span>";
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
}
$(document).on("click", ".add_contact_name", function () {

	var searched_text_val = $('#serched_val').val();
	var searched_text_val1 = $('#contact_name').val();
	var accountId = $('#accountId').val();
	setTimeout(function () {
		$('#contact_name').val(searched_text_val);
		$('#contact_name').val(searched_text_val1);
		// $('#material_name_id').val(materialId);
	}, 2000);
	setTimeout(function () {
		$('#serched_val').val();
	}, 1000);
});

$(document).on("click", ".add_contact_name", function () {
	//To get Matrieal Type Ajax
	//alert("ddd");
	$('#myModal_Add_contactPerson_details').modal('show');
	var btn_html = $(this).html();
	$('#add_contactPerson_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger


});
$(document).on("click", ".close_contact_model", function () {


	setTimeout(function () {

		$('#myModal_Add_contactPerson_details').modal('hide');
		$('.nav-md').addClass('modal-open');
	}, 500);


});
$(document).on("click", "#Add_contact_details_on_button_click", function () {

	$('#message_contact').empty();
	var contact_owner = $('#loggedUser').val();
	var account_id = $('#accountId').val();
	var contact_name = $('#contact_name').val();
	var email_id = $('#email_id').val();
	var ph_no = $('#ph_no').val();
	console.log(email_id);
	console.log(ph_no);
	var error = 0;
	if (contact_name == '') {
		$('#contact_name').css('border', '1px solid #b94a48');
		$('#contact_name').closest(".form-group").find("span").text('This field is required');
		var error = 1;
	} else {
		$('#contact_name').css('border', '1px solid #dedede');
		$('#contact_name').closest(".form-group").find("span").text('');
	}

	if (error == 1) {
		return false;
	} else {

		$.ajax({
			type: "POST",
			url: site_url + 'crm/add_contact_Details_onthe_spot/',
			data: {
				account_id: account_id,
				contact_owner: contact_owner,
				contact_name: contact_name,
				email_id: email_id,
				ph_no: ph_no
			},
			success: function (htmlStr) {
				//alert(htmlStr);

				if (htmlStr.length > 0) {

					$('#message_contact').html('<span style="color:green;">Contact Added Successfully.</span>');
					$("#insert_contact_data_id").trigger('reset');
					setTimeout(function () {

						$('#myModal_Add_contactPerson_details').modal('hide');
						$('.nav-md').addClass('modal-open');
					}, 1000);
					setTimeout(function () {
						$('.nav-md').addClass('modal-open');
					}, 1500);
					$('.nav-md').addClass('modal-open');
				} else {
					$('#message').html('<span style="color:red;">Not Added.</span>');
				}
				setTimeout(function () {
					$('#message').html('<span> </span>');
				}, 3000);


			}
		});
	}
});


function saleOrderComplete() {
	$('#sale_order_complete').change(function (event) {
		if (($("#sale_order_complete").prop("checked") == true)) {
			if (confirm('Are you sure!') == true) {
				var sale_order_id = $(this).attr('data-sale-order-id');
				var loggedInUserId = $(this).attr('data-loggedInUserId');

				var datasaleorderai = $(this).attr('data-sale-order-ai');


				$.ajax({
					type: "POST",
					url: site_url + 'crm/completeSaleOrder/',
					data: {
						id: sale_order_id,
						complete_status: 1,
						completed_by: loggedInUserId,
						datasaleorderai: datasaleorderai
					},
					success: function (result) {
						if (result != '') {
							var obj = $.parseJSON(result);
							if (obj.status == 'success') {
								window.location.href = site_url + 'crm/sale_orders/';
							}
						}
					}
				});
			}
		}
	});
}


/******************get company unit addres in sale order*********************/
function getAddress() {
	$('.address').select2({
		allowClear: true,
		placeholder: 'Select Address',
		closeOnSelect: true,
		ajax: {
			url: site_url + '/crm/getAddress',
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term
				};
			},
			processResults: function (data) {
				if (data) {
					return {
						results: data
					};

				}
			},
			cache: true,
		}

	});


}


$(document).ready(function () {
	resetcheckbox();
	$('#selecctall').click(function (event) { //on click
		if (this.checked) { // check select status
			$('.checkbox1').each(function () { //loop through each checkbox
				this.checked = true; //select all checkboxes with class "checkbox1"
			});
		} else {
			$('.checkbox1').each(function () { //loop through each checkbox
				this.checked = false; //deselect all checkboxes with class "checkbox1"
			});
		}
	});


	$("#del_all").on('click', function (e) {


		if (confirm('Are You Sure!') == true) {
			e.preventDefault();
			//var datamsg = $(this).attr('data-msg');
			var tablename1 = document.getElementById("table");
			var tablename = document.getElementById("table").value;

			var datamsg = tablename1.getAttribute('data-msg');

			var datapath = tablename1.getAttribute('data-path');


			var checkValues = $('.checkbox1:checked').map(function () {
				return $(this).val();
			}).get();


			console.log(checkValues);

			$.each(checkValues, function (i, val) {
				$("#" + val).remove();
			});


			var ai = $(".checkbox1:checked").map(function () {
				return $(this).data('ai')
			}).get();


			//	console.log('value if ai====>>>>>',ai);

			$.ajax({
				url: site_url + 'crm/deleteall/',
				type: 'post',
				data: {
					tablename: tablename,
					checkValues: checkValues,
					datamsg: datamsg,
					ai: ai
				}
			}).done(function (data) {
				window.location.href = site_url + datapath;
				$('#selecctall').attr('checked', false);
			});

		} else {
			$('input:checkbox').each(function () { //loop through each checkbox
				this.checked = false; //deselect all checkboxes with class "checkbox1"
			});


		}

	});


	function resetcheckbox() {
		$('.checkbox1').each(function () { //loop through each checkbox
			this.checked = false; //deselect all checkboxes with class "checkbox1"
		});
	}


});


/*$('s').each(function(index)
{*/


//function favour(){
$(".star").on('change', function (e) {
	var tablename1 = document.getElementById("favr");
	var tablename = document.getElementById("favr").value;

	var datamsg = tablename1.getAttribute('data-msg');

	// 	var favourite = tablename1.getAttribute('favour-sts');;

	var datapath = tablename1.getAttribute('data-path');


	if ($(this).is(':checked')) {
		var favourite = 1;

		var datamsgq = 'Marked'
	} else {
		var favourite = 0;

		var datamsgq = 'Unmarked'
	}


	var datamsgs = datamsg + '' + datamsgq;

	var checkValues = $(this).val();


	$.ajax({
		url: site_url + 'crm/markfavourite/',
		type: 'post',
		data: {
			tablename: tablename,
			checkValues: checkValues,
			datamsg: datamsgs,
			favourite: favourite
		}
	}).done(function (data) {
		window.location.href = site_url + datapath;
		$('.star').attr('checked', false);
	});


});
 function myFunction() {
var x = document.getElementById("myDIV1");
 if (x.style.display === "none") {
 x.style.display = "block";
 } else {
 x.style.display = "none";
}
 }

$(document).ready(function () {
	$(".filter").click(function () {
		$(".x_content").toggleClass("intro");
	});
});


function remove_calculation_quot_pi_so() {

	var grand_total_val = $("[name='total']").val();
	if (grand_total_val == 0 || grand_total_val == '') {
		$(':input[type="submit"]').prop('disabled', true);
	} else {
		$(':input[type="submit"]').prop('disabled', false);
	}
}

// $(document).on("click", function(e) {
// if ($(e.target).is(".x_content") === false) {
// $(".x_content").removeClass("intro");
// }
// });
// });

/* For Individual Record View in Companies (Quotation , PI , SO)*/
$(document).on("click", ".quotpisoview", function () {


	var id = $(this).attr('id');
	var tab = $(this).attr('data-id');
	var start_date = $(this).attr('data-date') ? $(this).attr('data-date') : '';
	var url = '';

	switch (tab) {


		case 'Sale Order':
			url = 'crm/viewSaleOrder';
			data = {
				id: id
			};
			break;
		case 'Sale Order Dispatched':
			url = 'crm/viewSaleOrder';
			data = {
				id: id
			};
			break;

		case 'Proforma Invoice':
			url = 'crm/viewProformaInvoice';
			data = {
				id: id
			};
			break;

		case 'Quotation':
			url = 'crm/viewQuotation';
			data = {
				id: id
			};
			break;
	}


	if (tab == 'Sale Order') {
		$('.nxt_cls').html('Sale Order');
		//   $('.nav-md').addClass('modal-open');
	}


	if (tab == 'Sale Order Dispatched') {
		$('.nxt_cls').html('Sale Order Dispatched');
		//  $('.nav-md').addClass('modal-open');
	}

	if (tab == 'Proforma Invoice') {
		$('.nxt_cls').html('Proforma Invoice');
		// $('.nav-md').addClass('modal-open');
	}

	if (tab == 'Quotation') {
		$('.nxt_cls').html('Quotation');
		// $('.nav-md').addClass('modal-open');
	}


	$.ajax({
		type: "POST",
		url: site_url + url,
		//data: {id:id},
		data: data,
		success: function (data) {
			if (data != '') {
				$("#crm_add_modal1").modal({
					show: false,
					backdrop: 'static'
				});
				$('#crm_add_modal').modal('hide');

				setTimeout(function () {
					$('#crm_add_modal1').modal('toggle');
					$('.nav-md').addClass('modal-open');
				}, 500);

				$('#crm_add_modal1 .modal-body-content1').html(data);

			}
		}
	});
});


/* For PipeLine Module Drag & Drop Functionality*/

$(function () {
	gettotal();
	var kanbanCol = $('.panel-body');
	kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');
	var kanbanColCount = parseInt(kanbanCol.length);
	$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');
	var dragClass = $(".dragg");
	var dragSaleClass = $(".saleOrderPriority");

	var dragMachineClass = $(".machine_order_priority");

	/*old code*/
	/*var dragClass = $(".dragg");
    if (dragClass.hasClass('dragg'))
	 //if(($(this).hasClass('dragg')))
	  {
	draggableInit();
	  }else{

	draggableSaleOrderInit();
	draggableMachineOrderInit();
	  }
	  */
	if (dragClass.hasClass('dragg')) {
		//if(($(this).hasClass('dragg')))
		//{
		console.log("dfdf");
		draggableInit();
	}

	if (dragSaleClass.hasClass('saleOrderPriority')) {
		console.log("fff");
		draggableSaleOrderInit();
		//draggableMachineOrderInit();
	} else if (dragMachineClass.hasClass('machine_order_priority')) {
		draggableMachineOrderInit();
	}
	$('.panel-heading').click(function () {
		if ($('.machineOrder').hasClass("fa-minus-circle")) {
			$('.machineOrder').removeClass("fa-minus-circle");
			$('.machineOrder').addClass("fa-plus-circle");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		} else if ($('.machineOrder').hasClass("fa-plus-circle")) {
			$('.machineOrder').removeClass("fa-plus-circle");
			$('.machineOrder').addClass("fa-minus-circle");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		}
		if ($(this).find('i').hasClass("fa-chevron-up")) {
			$(this).find('i').removeClass("fa-chevron-up");
			$(this).find('i').addClass("fa-chevron-down");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		} else if ($(this).find('i').hasClass("fa-chevron-down")) {
			$(this).find('i').removeClass("fa-chevron-down");
			$(this).find('i').addClass("fa-chevron-up");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		}
	});

	/*$('.panel-heading').click(function() {
		var $panelBody = $(this).parent().children('.panel-body');
		$panelBody.slideToggle();
	});*/
});


function draggableInit() {
	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {
		console.log('event===>>>', event);
		sourceId = $(this).parent().attr('id');
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
		console.log("sourceId=>>>", event.originalEvent.dataTransfer.getData("text/plain"));
	});
	$('.panel-body').bind('dragover', function (event) {
		event.preventDefault();
	});
	$('.panel-body').bind('drop', function (event) {
		var children = $(this).children();
		var targetId = children.attr('id');
		console.log("targetid==>>", targetId);
		var status = $('#status').val();
		if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
			console.log("elementId->>", elementId);
			$.ajax({
				url: site_url + 'crm/changeProcessType/',
				dataType: 'json',
				type: 'POST',
				data: {
					'processId': elementId,
					'processTypeId': targetId,
					'sourceId' : sourceId,
				},
				success: function (result) {
					if (result.status == 'success') {
						window.location.href = result.url;

					}
				}
			});


			$('#processing-modal').modal('toggle'); //before post
			// Post data
			setTimeout(function () {
				var element = document.getElementById(elementId);
				children.prepend(element);
				$('#processing-modal').modal('toggle'); // after post
				gettotal();
			}, 1000);

			if(targetId == '6'){
					setTimeout(function () {
					var element = document.getElementById(elementId);
					children.prepend(element);
					$("#id").val(elementId);
					$('#comment').modal('toggle');
					$('#processing-modal').modal('toggle');
					$(document).on("click", ".close_sec_model", function () {
						$(".modal").modal("hide");
     					$(".modal-backdrop").remove();
					}); // after post*/
					}, 1000);
			}
		} else {
			$(".kanban-centered").sortable({
				connectWith: ".kanban-centered",
				scroll: false,
				cursor: 'pointer',
				revert: true,
				opacity: 0.4,
				update: function () {
					sendOrderToServer();
				}
			}).disableSelection();
			event.preventDefault();
		}
	});
}


function sendOrderToServer() {
	var order = [];
	$('.process').each(function (index, element) {
		order.push({
			id: $(this).attr('id'),
			position: index + 1
		});
	});
	var children = $(this).children();
	$.ajax({
		type: "POST",
		dataType: "json",
		url: site_url + 'crm/changeOrder/',
		data: {
			order: order,
		},
		success: function (response) {
			if (response.status == "success") {
				window.location.href = result.url;
			}
		}
	});
	$('#processing-modal').modal('toggle'); //before post
	// Post data
	setTimeout(function () {
		var element = document.getElementById($(this).attr('id'));
		children.prepend(element);
		$('#processing-modal').modal('toggle'); // after post
	}, 1000);

}


// for  change status for leads on change
$("#staus").change(function () {

	var ai = $(".checkbox1:checked").map(function () {
		return $(this).data('ai')
	}).get();

	var selectedvalue = $(this).children("option:selected").val();
	console.log(selectedvalue);
	console.log(ai);
	$.ajax({
		url: site_url + 'crm/change_lead_status_by_id/',
		dataType: 'json',
		type: 'POST',
		data: {
			ai: ai,
			selectedvalue: selectedvalue
		},
		success: function (result) {
			if (result.status == 'success') {

				location.reload();
			}
		}
	});
});





/************************print in view****************************************/
function Print_data_new() {
	document.getElementById("btnPrint").onclick = function () {
		printDiv(document.getElementById("print_divv"));
		var modThis = document.querySelector("#print_divv");
		console.log('modThis===>>>', modThis);
		//window.print();
		function printDiv(div) {
			// Create and insert new print section
			var elem = document.getElementById('print_divv');
			var domClone = elem.cloneNode(true);
			var $printSection = document.createElement("div");
			$printSection.id = "printSection";
			$printSection.appendChild(domClone);
			document.body.insertBefore($printSection, document.body.firstChild);

			window.print();

			// Clean up print section for future use
			var oldElem = document.getElementById("printSection");
			if (oldElem != null) {
				oldElem.parentNode.removeChild(oldElem);
			}
			//oldElem.remove() not supported by IE

			return true;
		}


	}
}


// for counting total price in pipeline
function gettotal() {
	$('.kanban-col').each(function (i) {
		var leadStatusId = $(this).attr('id');
		var total = 0;
		var total1 = 0;
		var dataname = $(this).attr('data-name');
		$('#' + leadStatusId + ' .ee').each(function () {
			total += parseFloat($(this).text());
		});
		var numItems = $('#' + leadStatusId + ' .kanban-label').length;
		$('#' + leadStatusId + ' .total11').text('(' + numItems + ')');
		$('#' + leadStatusId + ' .panel-footer').html('<h4 style="float:right;">Grand Total <strong>₹</strong> ' + total + '  </h4>');
	});
}


// For data tables inside the tabs
 $('#datatable-buttons1').DataTable();
 $('#datatable-buttons12').DataTable({
	 "searching": false
 });
$("#datatable-buttonschk").DataTable({
   "paging": false,
   "ordering": false,
   "searching": true
});

$("#compleetleed").DataTable({
   "paging": false,
   "ordering": false,
    "searching": true
});

$("#compleetleeddata").DataTable({
   "paging": true,
   "ordering": false,
   "searching": true
});


$('#datatable-so').DataTable();


// Function to display add more contact functionality in lead
function addMoretypeofCustomer() {
	/* add more multiple contacts */
	var maximum_add = 10; //maximum input boxes allowed
	var inputfield = $(".processDiv"); //Fields wrapper
	var add_more = $(".addMoreProcess"); //Add button ID
	var y = 1; //initlal text box count
	$(add_more).click(function (e) { //on add input button click
		e.preventDefault();
		if (y < maximum_add) { //max input box allowed
			y++;
			$(inputfield).append('<div class="well scend-tr" id="chkIndex_' + y + '"><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Industry name" value=""></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Industry name" value=""></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Industry name" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}

	});
	$(inputfield).on("click", ".remve_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	});
}

function addMoreleadsresource() {
	/* add more multiple contacts */
	var maximum_add = 10; //maximum input boxes allowed
	var inputfield = $(".processDiv"); //Fields wrapper
	var add_more = $(".addMoreProcess"); //Add button ID
	var y = 1; //initlal text box count
	$(add_more).click(function (e) { //on add input button click
		e.preventDefault();
		if (y < maximum_add) { //max input box allowed
			y++;
			$(inputfield).append('<div class="well scend-tr" id="chkIndex_' + y + '"><div class="col-md-12 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Lead Source Name" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}

	});
	$(inputfield).on("click", ".remve_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	});
}

function addMoresaleArea() {
	/* add more multiple contacts */
	var maximum_add = 10; //maximum input boxes allowed
	var inputfield = $(".processDiv"); //Fields wrapper
	var add_more = $(".addMoreProcessSaleArea"); //Add button ID
	var y = 1; //initlal text box count
	$(add_more).click(function (e) { //on add input button click
		e.preventDefault();
		if (y < maximum_add) { //max input box allowed
			y++;
			$(inputfield).append('<div class="well scend-tr" id="chkIndex_' + y + '"><div class="col-md-12 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Sales Area Name" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}

	});
	$(inputfield).on("click", ".remve_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	});
}


/*************************code to get values of cost price and sales price from valuation*******************************/
/* this function is use d to get the column value which you want to change on focus****/

var customer_type23 = [];
var product_id23 = [];
var price23 = [];

$('[contenteditable]').on('focus', function () {
	var $this = $(this);
	var id = $(this).attr('id');
}).on('blur', function () {
	var $this = $(this);

	$("td").each(function () {

		customer_type23.push($(this).attr('data-customerid'));
		product_id23.push($(this).attr('data-id'));
		price23.push($(this).html());

	});

});


$(".save").click(function () {


	console.log(customer_type23);

	console.log(product_id23);

	console.log(price23);


});

/*************************code to get values of cost price and sales price from valuation*******************************/


/*$('[contenteditable]').on('focusout', function() {

		var $this = $(this);
		var id = $(this).attr('data-customerid');
		var dataid = $(this).attr('data-id');
		var contn = $(this).text();

			$.ajax({
			url:site_url + "crm/savePricelist",
			method:"POST",
			data:{id:id,dataid:dataid,contn:contn},
				success:function(result){
					//console.log("resutl",result);
					var data = JSON.parse(result);
					//console.log(data);
					if(data.status == 'success'){ // if true (1)
					//window.location.reload();
					$('.save').hide();// then reload the page.(3)
					}
				}
		});

});*/
/********************************common save function run on index as well as after date filter*****************************************/


$('.submit_price').click(function () {
	var ajaxDataArray = [];
	var i = 0;
	$('.tr-class').each(function () {
		//ajaxDataArray = [];
		var materialId = $(this).attr('data-id');
		$(this).find('.custData').each(function () {
			var dataCustomerId = $(this).attr('data-customerId');
			var dataCustomerIdVal = $(this).text();
			ajaxDataArray.push({
				'product_id': materialId,
				'customer_type': dataCustomerId,
				'price': dataCustomerIdVal
			});
		})
		i++;
	});
	console.log('ajaxDataArray==>>>', ajaxDataArray);


	$.ajax({
		url: site_url + "crm/savePricelist",
		method: "POST",
		data: {
			ajaxDataArray: ajaxDataArray
		},
		success: function (result) {
			//console.log("resutl",result);
			var data = JSON.parse(result);
			//console.log(data);
			if (data.status == 'success') { // if true (1)
				//window.location.reload();
				$('.save').hide(); // then reload the page.(3)
			}
		}
	});

	// send ajax call with data ajaxDataArray
});


// /*chang statsu in worker*/
$(document).on('change', '.change_status_uom', function () {
	var uomStatus;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) uomStatus = 1;
	else uomStatus = 0;
	var id = $(this).attr("data-value");

	$.ajax({
		url: site_url + 'crm/change_status/',
		dataType: 'json',
		type: 'POST',
		data: {
			'id': id,
			'uomStatus': uomStatus,
		},
		success: function (data) {

			if (data == true) {
				location.reload();
			}
		}
	});
});


$(document).on('change', '.change_statusleadSource', function () {
	var active_inactive;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) active_inactive = 1;
	else active_inactive = 0;
	var id = $(this).attr("data-value");

	$.ajax({
		url: site_url + 'crm/change_statusleadSource/',
		dataType: 'json',
		type: 'POST',
		data: {
			'id': id,
			'active_inactive': active_inactive,
		},
		success: function (data) {
			// alert(data);

			if (data == true) {
				location.reload();
			}
		}
	});
});


$(document).on('change', '.change_status_sales_area', function () {
	var active_inactive;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) active_inactive = 1;
	else active_inactive = 0;
	var id = $(this).attr("data-value");

	$.ajax({
		url: site_url + 'crm/change_statusleadSource/',
		dataType: 'json',
		type: 'POST',
		data: {
			'id': id,
			'active_inactive': active_inactive,
		},
		success: function (data) {
			// alert(data);

			if (data == true) {
				
				$('#alertMsg').html('<div class="alert alert-info ">Sale Area Status Updated Successfully</div>');
				setTimeout(function () {
						location.reload();
				}, 1000);
				
			}
		}
	});
});

//search and sort
function get_order() {
	$('#orderby').submit();
}

$(document).ready(function () {
	var numOfVisibleRows = $('tr:visible').length;
	$('#visible_row').val(numOfVisibleRows);
	if ($('#visible_row').val() < 10) {
		$('.pagination').hide();
	}
});


//show Hide charges Div
$(document).on("click", "#ert", function () {
	$(".box1").slideToggle(1000);
});
//show Hide charges Div

/*GET MATERIAL NAME*/
/**function getMaterialNameCA(evt, t, selProcessType = '', c_id = '') {

	$(this).parents().closest('input=[text]').find('.materialNameId').empty();
	var logged_user = $('#loggedUser').val();
	console.log("loggeduser", logged_user);
	var option = $(t).find('option:selected');
	console.log('option===>>>', option);
	var material_type_id = selProcessType != '' ? selProcessType : $(option).val();
	if (material_type_id === undefined) {
		material_type_id = $('.material_type_id').find('option:selected').val();
	}

	if (material_type_id != '') {
		select2CA(material_type_id, logged_user);
	}
}***/

function getMaterialName(evt, t , selProcessType = '' , c_id = '' ){
	// alert('HMM');
	$(this).parents().closest('input=[text]').find('.materialNameId').empty();
	var logged_user = $('#loggedUser').val();
	var closestId = $(t).closest(".well").attr("id");
	var option = $(t).find('option:selected');
	var material_type_id = selProcessType != ''?selProcessType:$(option).val();
	if(material_type_id != ''){
		 select2(material_type_id , logged_user);
	}
	var fff = $("#"+closestId).find('.materialNameId').attr('data-where','material_type_id = '+material_type_id+' AND created_by_cid='+logged_user+' AND status=1');
		$("#"+closestId).find('.materialNameId').attr('data-id','material');
		$("#"+closestId).find('.materialNameId').attr('data-key','id');
		$("#"+closestId).find('.materialNameId').attr('data-fieldname','material_name');
    console.log( fff );
}

function select2CA(material_type_id, logged_user) {
	$('.materialNameId').attr('data-where', 'material_type_id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND status=1');
	$('.materialNameId').attr('data-id', 'material');
	$('.materialNameId').attr('data-key', 'id');
	$('.materialNameId').attr('data-fieldname', 'material_name');

}

/*fetching tax value on material elect*/
function getUomCA(evt, t) {
	setTimeout(function () {

		var option = $(t).find('option:selected');
		//var materialId = $('.materialId').val();

		var closestId = $(t).closest(".well").attr("id");

		console.log('closestId===>>>>', closestId);
		var materialId = $('#' + closestId + ' .materialNameId').val();

		$.ajax({
			type: "POST",
			url: site_url + 'crm/getMaterialDataByIdCA',
			data: {
				'id': materialId,
			},
			success: function (data) {
				if (data != '') {
					//console.log('data===>>>', data);
					var dataObj = JSON.parse(data);
					// var dataObj = jQuery.parseJSON(JSON.stringify(data));
					if (dataObj) {
						// console.log(dataObj);
						var uom = dataObj.uom;
						var opening_balance = dataObj.opening_balance;
						var job_card = dataObj.job_card;
						console.log("uom", uom);
						$("#" + closestId + "").find('.uom').val(uom);
						//$("#" + closestId + "").find('.qty').val(opening_balance);
						$("#" + closestId + "").find('.uom1').val(dataObj.uomid);
					}
				}
			}
		});
		var uom = $(this).find('.option').val();
		var closestId = $(t).closest(".well").attr("id");
	}, 1000);
}

/*job card add more material field */
function addMaterialDetailCA() {
	var input = 10;
	var input_mat = $(".input_holder");
	var add_mat = $(".addmaterial");
	var logged_user = $('#loggedUser').val();
	//var y = 1;
	var y = $('.input_fields_wrap .well').length;
	$(add_mat).click(function (e) {
		// e.preventDefault();
		// var measurmentArray = '';
		// $.each( measurementUnits, function( key, value ) {
		// measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
		// });
		if (y < input) {
			y++;
			$(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '" ><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getUomCA(event,this);"></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12 qty" name="disc[]" placeholder="Disc" required="required" type="text"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" value="" readonly><input type="hidden" name="uom_value[]" class="uom1" readonly value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value=""></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
			var material_type_id = $('#material_type').val();
			select2CA(material_type_id, logged_user);
		}
		var mat_id = $('#material_type').val();
		//getMaterialIssue();
		getMaterialNameCA(mat_id, y);
		init_select2();
		//get_Qty_UOm();
		getUomCA();

	});
	$(input_mat).on("click", ".remove_input", function (e) {
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
		keyupFunction(event, this);
	});
}

function getMatDetails() {
	$("#account_id").on("select2:select", function (e) {
		$("#contact_id").empty();
		var selectAccountVal = $(e.currentTarget).val();
		$.ajax({
			url: site_url + 'crm/getMat/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: selectAccountVal,
			},
			success: function (result) {

				if (result != '') {
					var input_mat = $(".input_holder");
					var objss = jQuery.parseJSON(JSON.stringify(result));

					var len = objss.length;
					for (var i = 0; i < len; i++) {
						var material_name_id = objss[i].material_name_id;
						var material_name = objss[i].material_name;
						var material_type_id = objss[i].material_type_id;
						var material_type = objss[i].material_type;
						var unit = objss[i].unit;
						var unit_name = objss[i].unit_name;
						var disc = objss[i].disc;
						var price = objss[i].price;
						//console.log("material_name",material_name);
						//console.log("material_type",material_type);
						var y = $('.input_fields_wrap .well').length;
						var logged_user = $('#loggedUser').val();
						$(input_mat).append('<div class="well scend-tr mobile-view"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type"><option value="' + material_type_id + '" selected>' + material_type + '</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getUom(event,this);"><option value="' + material_name_id + '" selected>' + material_name + '</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12" name="disc[]" placeholder="Disc" required="required" type="text" value=" ' + disc + ' "></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" value=" ' + unit_name + ' " readonly><input type="hidden" name="uom_value[]" class="uom1" readonly value="' + unit + '"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value=" ' + price + ' "></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');

						var material_type_id = $('#material_type').val();
						select2CA(material_type_id, logged_user);

						var mat_id = $('#material_type').val();
						//getMaterialIssue();
						getMaterialNameCA(mat_id, y);
						init_select2();
						//get_Qty_UOm();
						getUomCA();

					}
				}
			}
		});
	});
}

/*get material name when select material type*/
function getMaterialNameCompt(evt, t, selProcessType = '', c_id = '') {
	$(this).parents().closest('input=[text]').find('.productNameId').empty();
	var logged_user = $('#loggedUser').val();
	console.log("loggeduser", logged_user);
	var option = $(t).find('option:selected');
	console.log('option===>>>', option);
	var material_type_id = selProcessType != '' ? selProcessType : $(option).val();
	if (material_type_id === undefined) {
		material_type_id = $('.productNameId').find('option:selected').val();
	}
	if (material_type_id != '') {
		select2saleorder(material_type_id, logged_user);
	}
}

function select2saleorder(material_type_id, logged_user) {
	$('.productNameId').attr('data-where', 'id = ' + material_type_id + ' AND account_owner=' + logged_user + ' AND save_status = 1');
	$('.productNameId').attr('data-id', 'competitor_details');
	$('.productNameId').attr('data-key', 'id');
	$('.productNameId').attr('data-fieldname', 'product_detail');

}

function addMaterialDetailCAproductvise() {
	var input = 10;
	var input_mat = $(".input_holder");
	var add_mat = $(".addmaterial");
	var logged_user = $('#loggedUser').val();
	//var y = 1;
	var y = $('.input_fields_wrap .well').length;
	$(add_mat).click(function (e) {
		// e.preventDefault();
		// var measurmentArray = '';
		// $.each( measurementUnits, function( key, value ) {
		// measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
		// });
		if (y < input) {
			y++;
			$(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '" ><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Competitor Name</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="competitor_details" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="account_owner= ' + logged_user + ' " onchange="getMaterialNameCompt(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption24 select2 Add_mat_onthe_spot productNameId" id="mat_name" required="required" name="material_name[]" onchange="getUomCA(event,this);"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12 qty" name="disc[]" placeholder="Disc" required="required" type="text"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" value="" readonly><input type="hidden" name="uom_value[]" class="uom1" readonly value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value=""></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
			var material_type_id = $('#material_type').val();
			select2CA(material_type_id, logged_user);
		}
		var mat_id = $('#material_type').val();
		//getMaterialIssue();
		getMaterialNameCompt(mat_id, y);
		init_select2();
		select2saleorder();
		//get_Qty_UOm();
		getUomCA();
		init_select2so();

	});
	$(input_mat).on("click", ".remove_input", function (e) {
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
		keyupFunction(event, this);
	});
}


function getComptDetails() {
	$("#mat_name").on("select2:select", function (e) {
		var matnm_id = $(e.currentTarget).val();
		var mattype = $(".mmnm").val();
		var logged_user = $('#loggedUser').val();
		//console.log("jkbdkjwe==>>>>",selectAccountVal);
		//console.log("jkfdhjkdfh====>>>>",mattype);
		$.ajax({
			url: site_url + 'crm/getCompt/',
			dataType: 'json',
			type: 'POST',
			data: {
				mat_type_id: mattype,
				mat_name_id: matnm_id,
			},
			success: function (result) {

				stop();
				if (result != '') {
					var input_mat = $(".input_holder");
					var objss = jQuery.parseJSON(JSON.stringify(result));

					var len = objss.length;
					for (var i = 0; i < len; i++) {
						var compt_name = objss[i].name;
						var compt_id = objss[i].id;
						//console.log("material_name",material_name);
						//console.log("material_type",material_type);
						var y = $('.input_fields_wrap .well').length;
						var logged_user = $('#loggedUser').val();
						$(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Compitetor Name</label><select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id[]" data-id="competitor_details" data-key="id" data-fieldname="name" data-where="account_owner = ' + logged_user + ' AND save_status = 1" width="100%"><option value=" ' + compt_id + ' ">' + compt_name + '</option></select></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12" name="disc[]" placeholder="Disc" required="required" type="text"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price"></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');

						var material_type_id = $('#material_type').val();
						select2CA(material_type_id, logged_user);

						var mat_id = $('#material_type').val();
						//getMaterialIssue();
						getMaterialNameCA(mat_id, y);
						init_select2();
						//get_Qty_UOm();
						getUomCA();

					}
				}
			}
		});
	});
}

function add_price_prodct_row() {
	var input = 10;
	var input_mat = $(".input_holder");
	var add_mat = $(".add_price_prodct_row");
	var logged_user = $('#loggedUser').val();
	//var y = 1;
	var y = $('.input_fields_wrap .well').length;
	$(add_mat).click(function (e) {
		// e.preventDefault();
		// var measurmentArray = '';
		// $.each( measurementUnits, function( key, value ) {
		// measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
		// });
		if (y < input) {
			y++;
			$(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Compitetor Name</label><select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id[]" data-id="competitor_details" data-key="id" data-fieldname="name" data-where="account_owner = ' + logged_user + ' AND save_status = 1" width="100%"></select></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12" name="disc[]" placeholder="Disc" required="required" type="text"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price"></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
			var material_type_id = $('#material_type').val();
			select2CA(material_type_id, logged_user);
		}
		var mat_id = $('#material_type').val();
		//getMaterialIssue();
		getMaterialNameCA(mat_id, y);
		init_select2();
		//get_Qty_UOm();
		getUomCA();

	});
	$(input_mat).on("click", ".remove_input", function (e) {
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
		keyupFunction(event, this);
	});
}


function get_multiselect_value() {
	$('.get_val').change(function () {
		//console.log('this==>>',$(this).closest('.input_descr_wrap').find('.goods_descr_section').val('abc'));
		var matrial_select_this = $(this);

		var selected_id = $(this).val();

		$.ajax({
			type: "POST",
			url: site_url + 'crm/selectMatrial/',
			data: {
				id: selected_id
			},
			success: function (result) {
				var obj = jQuery.parseJSON(result);

				var specification_var = obj.specification;
				var hsn_code_var = obj.hsn_code;
				var uom_var = obj.uom;

				var uom_name = obj.uom;
				var uom_id = obj.uomid;

				var cess_var = obj.cess;


				var valuation_type = obj.valuation_type;
				console.log('Check It==>', valuation_type);

				var quantity = obj.opening_balance;
				var rate = obj.sales_price;
				var tax = obj.tax;
				//alert(tax);
				var mat_idds = obj.id;
				var mat_material_code = obj.material_code;
				var TotalAmount = rate * quantity;

				var closing_balance = obj.closing_balance;
				if (closing_balance == 0) {
					// $(matrial_select_this).closest('.input_descr_wrap').find("input[name='quantity[]']").attr("disabled", "disabled");
					// $('.chrk_mat_qty').attr("disabled", "disabled");
					//$('#mat_msg').html('This Material Not Available');
				} else {
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
				if (cess_var != '' || cess_var != null) {
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess[]']").val(cess_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='cess_all_total[]']").val(cess_var);
					$(matrial_select_this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val(valuation_type);
				} else if (cess_var == '' || cess_var == null) {
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

				setTimeout(function () {
					$('.keyup_event').keyup();
				}, 1000);

			}
		});
	});

	$('.remove_descr_field').on('click', function () {
		setTimeout(function () {
			$('.keyup_event').keyup();
		}, 1000);
	});
}

function add_filed_for_goods_descr_invoice() {
	var max_fields = 20; //maximum input boxes allowed
	var wrapper = $(".add-ro"); //Fields wrapper
	var add_button = $(".add_description_detail_button"); //Add button ID
	var x = 1; //initlal text box count
	$(add_button).click(function (e) { //on add input button click
		e.preventDefault();
		var uomsArray = '';
		$.each(uoms, function (key, value) {
			uomsArray = uomsArray + '<option value="' + value + '">' + value + '</option>';
		});
		$('.add_requried').prop("disabled", true);
		var company_login_id = $('#company_login_id').val();
		var get_discount_on_off = $('#get_discount_on_off').val();
		var item_code_on_off = $('#item_code_on_off').val();
		//alert(max_fields);
		if (x < max_fields) { //max input box allowed
			x++;
			if (get_discount_on_off == 1) {

				if (item_code_on_off == 1) {
					var item_codew = '<div class="col-sm-1 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label><input type="text" name="item_code[]"  class="col-md-1 form-control col-md-1 mat_item_code" placeholder="Item Code" value=""></div>';
				} else {
					var item_codew = '';
				}

				$(wrapper).append('<div class="col-md-12 input_descr_wrap add-ro2 mailing-box mobile-view" style="margin-top:0px; ">' + item_codew + '<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Matrial Name <span class="required">*</span></label><select class="matrial_details_id itemName form-control selectAjaxOption select2 get_val select2-hidden-accessible demoClass" required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=' + company_login_id + ' AND status=1" width="100%"></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd">	</div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label><input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods555" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label><input type="text" required="required"   name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event qty" placeholder="Quantity" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label><div><input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" required="required" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label><div class="checktr"><select name="disctype[]" class="form-control disc_type_cls"><option value="">Select</option><option value="disc_precnt">Discount Percent</option><option value="disc_value">Discount Value</option></select></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label><div class=" checktr"><input type="text" name="discamt[]" class="form-control col-md-1 goods_descr_section added_discount_amt" placeholder="Disc Amt" value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Amount after desc">Amt. After Desc.</label><div class="checktr">	<input type="text" name="after_desc_amt[]" class="form-control col-md-1 goods_descr_section" placeholder="After Disc Amt" value="" readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="tax">Tax<span class="required">*</span></label><div><input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax_key_up_event" placeholder="Tax" value="" readonly><input type="hidden" value="" name="added_tax" class="added_tax"><input type="hidden" value="" name="added_tax_Row_val[]" ></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1" class="col-md-12 col-sm-12 col-xs-12" for="amount">Amount with Tax<span class="required">*</span></label><div><input type="text" name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" placeholder="Amount" value="" readonly><input type="hidden" value="" name="sale_amount" class="sale_amount"><input type="hidden" value="" name="cess[]"><input type="hidden" value="" name="cess_tax_calculation[]"><input type="hidden" value="" name="valuation_type[]"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>');
			} else {
				if (item_code_on_off == 1) {
					var item_codew = '<div class="col-sm-1 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Item Code <span class="required">*</span></label><input type="text" name="item_code[]"  class="col-md-1 form-control col-md-1 mat_item_code" placeholder="Item Code" value=""></div>';
					var uom_code = '<div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div>';
				} else {
					var item_codew = '';
					var uom_code = '<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="uom">UOM<span class="required">*</span></label><div><input type="" name="UOM1[]" class="form-control col-md-1 goods_descr_section " readonly><input type="hidden" name="UOM[]" class="form-control col-md-1 goods_descr_section " readonly></div></div>';
				}

				$(wrapper).append('<div class="col-md-12 input_descr_wrap add-ro2 mailing-box mobile-view">' + item_codew + '<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="matrialname">Matrial Name <span class="required">*</span></label><select class="matrial_details_id itemName form-control selectAjaxOption select2 get_val select2-hidden-accessible demoClass" required="required" name="material_id[]" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=' + company_login_id + ' AND status=1" width="100%"></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="descriptions">Description</label><input type="text" name="descr_of_goods[]"  class="form-control col-md-1" placeholder="Description Of Goods" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="hsn/sac">HSN/SAC<span class="required">*</span></label><input type="text" name="hsnsac[]" class="form-control col-md-1 goods_descr_section" placeholder="HSN/SAC"  value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="quantity">Quantity<span class="required">*</span></label><input type="text" required="required"   name="quantity[]" class="form-control col-md-1 year goods_descr_section keyup_event qty" placeholder="Quantity" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="rate">Rate<span class="required">*</span></label><div><input type="text" name="rate[]" class="form-control col-md-1 goods_descr_section keyup_event rate" placeholder="Rate" required="required" value=""></div></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Type">Disc. Type</label><div><input type="text" name="tax[]" class="form-control col-md-1 goods_descr_section tax_key_up_event" placeholder="Tax" value="" readonly><input type="hidden" value="" name="added_tax" class="added_tax"><input type="hidden" value="" name="added_tax_Row_val[]" ></div></div>' + uom_code + '<div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Dicount Amount">Disc. Amt.</label><div><input type="text" name="amount[]" class="form-control col-md-1 goods_descr_section AMunt" placeholder="Amount" value="" readonly><input type="hidden" value="" name="sale_amount" class="sale_amount"><input type="hidden" value="" name="cess[]"><input type="hidden" value="" name="cess_tax_calculation[]"><input type="hidden" value="" name="valuation_type[]"></div></div><button class="btn btn-danger remove_descr_field" type="button"><i class="fa fa-minus"></i></button></div>');
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
	$(wrapper).on("click", ".remove_descr_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
		setTimeout(function () {
			$('.keyup_event').keyup();
		}, 1000);
	});
}

function init_select21() {
	$('#get_add_more_btn').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
		placeholder: 'Select And Begin Typing',
		ajax: {
			url: site_url + 'Ajaxrequest/ajaxSelect2search',
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
		},
		language: {
			noResults: function () {
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				var searched_value = $('.select2-search__field').val();
				$('#fetch_pname').val(searched_value);
				var lb_ID = $('#fetch_pname').val();
				$('.party_namee').val(lb_ID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' id='opty' class='add_more_party_name'>Add </span>";
			}
		},
		escapeMarkup: function (markup) {
			return markup;

		}
	});

}

function tax_keyup_event_to_remove_tax() {
	$('.tax_key_up_event').keyup(function () {
		// $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val('0');
		// $(this).closest('.input_descr_wrap').find("input[name='amount[]']").val('0');
		/* New added Code */
		//when discount added and change quantity
		$(this).closest('.input_descr_wrap').find("select[name='disctype[]']").prop('selectedIndex', 0);
		$(this).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val('');
		$(this).closest('.input_descr_wrap').find("input[name='discamt[]']").val('');
		// $(this).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly', true);
		//when discount added and change quantity
		var theQuantity = $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		var thePrice = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		var thetax = $(this).closest('.input_descr_wrap').find("input[name='tax[]']").val();
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(thetax);
		var with_quantity_price = theQuantity * thePrice;
		var percent_on_total = thetax * with_quantity_price / 100;
		// alert(percent_on_total);

		// var tax_ccording_to_quantity = thetax * theQuantity;

		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		var valueww = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
		$(this).closest('.input_descr_wrap').find("input[name='sale_amount']").val(with_quantity_price);
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(percent_on_total);
		subtotal();
		var total_amount = $(".total_amountt").val();
		if (total_amount > 0) {
			$('.add_requried').prop("disabled", false);
		} else {
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
		if (qtty_value == 0 || amount_valuue) {
			//$('.chrk_mat_qty').attr("disabled", "disabled");
			$('.chrk_mat_qty').removeAttr("disabled");
		} else {
			$('.chrk_mat_qty').removeAttr("disabled");
		}
	});
}

function add_dicount_invoice_matrial() {
	$('.disc_type_cls').change(function () {
		var discount_type_val = $(this).val();
		var discount_texbox_val = $(this);
		var added_qty = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		var added_rate = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='rate[]']").val();

		var amt_acc_to_qty = added_qty * added_rate;

		$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val('');
		$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val('');


		if (discount_type_val == 'disc_precnt') {
			$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly', false);
			$('.added_discount_amt').keyup(function () {
				var discount_val = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val();
				var get_percent_amt = amt_acc_to_qty * discount_val / 100;
				//
				setTimeout(function () {
					var After_disc_total_amt = amt_acc_to_qty - get_percent_amt;
					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val(After_disc_total_amt);
					var get_discount_amut = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();

					var get_added_tax = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='tax[]']").val();

					var add_tax_after_discount = get_discount_amut * get_added_tax / 100;

					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val(add_tax_after_discount);

					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='sale_amount']").val(After_disc_total_amt);

				}, 1000);

				setTimeout(function () {
					var added_tax_amount = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val();
					var get_after_desc_amt = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();
					var after_discount_add_Amt_in_tax = parseFloat(added_tax_amount) + parseFloat(get_after_desc_amt);
					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='amount[]']").val(after_discount_add_Amt_in_tax);
					var sale_amount2 = 0;
					// $("input[name='sale_amount']").each(function () {
						// sale_amount2 += parseFloat($(this).val());
					// });
					sale_amount2 = after_discount_add_Amt_in_tax - added_tax_amount;
	
	
					var amount_without_tax = sale_amount2.toFixed(2);
					$(".total_amountt").val(amount_without_tax);
					//Tax
					var added_tax = 0;
					$("input[name='added_tax']").each(function () {
						added_tax += parseFloat($(this).val());
					});

					$(".tax_class").val(added_tax);
					var result_divide = parseInt(added_tax) / parseInt(2);
					$(".tax_class1").val(result_divide);
					$(".tax_class2").val(result_divide);
					//Tax
					var grand_total_sum = 0;
					$("input[name='amount[]']").each(function () {
						grand_total_sum += Number($(this).val());
					});
					$(".grand_total").val(grand_total_sum);

				}, 1000);
			});
		} else {
			$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly', false);
			$('.added_discount_amt').keyup(function () {
				var discount_val = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='discamt[]']").val();

				setTimeout(function () {
					var After_disc_total_amt = amt_acc_to_qty - discount_val;

					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val(After_disc_total_amt);
					var get_discount_amut = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();

					var get_added_tax = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='tax[]']").val();

					var add_tax_after_discount = get_discount_amut * get_added_tax / 100;

					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val(add_tax_after_discount);
					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='sale_amount']").val(After_disc_total_amt);

				}, 1000);

				setTimeout(function () {
					var added_tax_amount = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='added_tax']").val();
					var get_after_desc_amt = $(discount_texbox_val).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val();
					var after_discount_add_Amt_in_tax = parseFloat(added_tax_amount) + parseFloat(get_after_desc_amt);
					$(discount_texbox_val).closest('.input_descr_wrap').find("input[name='amount[]']").val(after_discount_add_Amt_in_tax);
					var sale_amount2 = 0;
					$("input[name='sale_amount']").each(function () {
						sale_amount2 += parseFloat($(this).val());
					});

					var amount_without_tax = sale_amount2.toFixed(2);
					$(".total_amountt").val(amount_without_tax);
					//Tax
					var added_tax = 0;
					$("input[name='added_tax']").each(function () {
						added_tax += parseFloat($(this).val());
					});
					$(".tax_class").val(added_tax);
					var result_divide = parseInt(added_tax) / parseInt(2);
					$(".tax_class1").val(result_divide);
					$(".tax_class2").val(result_divide);
					//Tax
					var grand_total_sum = 0;
					$("input[name='amount[]']").each(function () {
						grand_total_sum += Number($(this).val());
					});
					$(".grand_total").val(grand_total_sum);
				}, 1000);
			});
		}


	})
}

function tax_calculation_for_charges() {
	//According To charges Calculate Tax
	$('.charges_added').on('keyup', function () {
		var added_amount_val = $(this).val();

		var matrial_select_this_val33 = $(this);
		var totl_tax = $('#total_tax_slab').val();
		var total_tax_withAmount = totl_tax * added_amount_val / 100;
		//alert(total_tax_withAmount);
		setTimeout(function () {
			var addition_add = (+total_tax_withAmount) + (+added_amount_val);
			//alert(addition_add);
			$(matrial_select_this_val33).closest('.testDh').find("input[name='amt_with_tax[]']").val(addition_add);
			$(matrial_select_this_val33).closest('.testDh').find("input[name='amt_tax[]']").val(total_tax_withAmount);
			$('.charges_head_div').show();
			var total_charges_with_tax = 0;
			$("input[name='amt_with_tax[]']").each(function () {
				total_charges_with_tax += Number($(this).val());
			});

			$('.total_charges_cls').val(total_charges_with_tax);

			var purchase_bill_total = 0;
			$("input[name='amount[]']").each(function () {
				purchase_bill_total += Number($(this).val());
			});


			var charges_total = (+total_charges_with_tax) + (+purchase_bill_total);
			$('.grand_total').val(charges_total);


		}, 800);
	});
}

function add_charges_on_invoice() {
	$('.Add_charges_id').change(function () {
		var charge_ldger_id = $(this).val();

		var matrial_select_this_val = $(this);

		setTimeout(function () {
			$('.ad_rm_readonly').prop('disabled', false);
			$.ajax({
				type: "POST",
				url: site_url + 'account/get_charges_details/',
				data: {
					id: charge_ldger_id
				},
				success: function (result) {


					var obj = jQuery.parseJSON(result);

					if (obj.data.type_charges == 'minus') {
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


						$('.add_dis').on('click', function () {
							var get_cahrges_added = $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();

							if (get_cahrges_added == '') {
								$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid red");
								return false;
							} else {
								$('.add_dis').attr('disabled', 'disabled');

							}
							$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid #ddd");
							//$(this).attr('disabled','disabled');
							$(".sale_amount").each(function () {
								total_basic_amount += parseFloat($(this).val());
							});


							$(".sale_amount").each(function () {
								sale_basic_amount = parseFloat($(this).val());
								var discount_amt = $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
								amount_after_each_calcu = sale_basic_amount * discount_amt / total_basic_amount;

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
							$("input[name='tax[]']").each(function () {
								added_tax11 = parseFloat($(this).val());
								var get_basic_amt = $(this);
								var basic_amt = $(get_basic_amt).closest('.input_descr_wrap').find("input[name='sale_amount']").val();
								var tax_amt = added_tax11 * basic_amt / 100;
								$(get_basic_amt).closest('.input_descr_wrap').find('.added_tax').val(tax_amt);
								amount_with_tax = parseFloat(tax_amt) + parseFloat(basic_amt);
								amount_with_tax_amt += amount_with_tax;
								$(get_basic_amt).closest('.input_descr_wrap').find("input[name='amount[]']").val(amount_with_tax);
								$('#total_amout_with_tax_on_keyup').val(amount_with_tax_amt);
								subtotal();

							});
							//For Tax Calculation

						});

					}

					if (obj.data.type_charges == 'plus') {

						$('.for_discount_hide').show();
						$('#total_tax_slab').val(obj.data.tax_slab); //Add total_tax

						$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name[]']").val(obj.ledger_nam);
						$(matrial_select_this_val).closest('.testDh').find("input[name='ledger_name_id[]']").val(obj.data.ledger_id);
						$(matrial_select_this_val).closest('.testDh').find("input[name='type_charges[]']").val(obj.data.type_charges);

						var sale_company_state_idd = $('#sale_company_state_id').val();
						var party_billing_state = $('#party_billing_state_id').val();
						if (party_billing_state != sale_company_state_idd) {
							var taxslabb = obj.data.tax_slab;
							$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").val(taxslabb);

							$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").show();
							$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
						} else {
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

function party_name_ledger_id_onchange() {
	$('.party_name_ledger_id_onchange').change(function () {
		// $('.charges_form').hide();

		$('#P_address').html('<option selected>Select Address</option>');
		var selected_party_name_ledger_id = $(this).val();

		//setTimeout(function(){

		//alert(selected_party_name_ledger_id);
		var login_user_idd = $('#login_user_idddd').val();
		$.ajax({
			type: "POST",
			url: site_url + 'account/get_ledger_mailing_state/',
			data: {
				id: selected_party_name_ledger_id,
				login_user: login_user_idd
			},
			success: function (result) {
				var obj = jQuery.parseJSON(result);
				var get_state_id = jQuery.parseJSON(obj.mailing_address);
				var len = get_state_id.length;
				//For State in multiple address
				for (var i = 0; i < len; i++) {

					var country = get_state_id[i].mailing_country;
					var state = get_state_id[i].mailing_state;
					var city = get_state_id[i].mailing_city;
					var mailing_name = get_state_id[i].mailing_name;
					var mailing_address1 = get_state_id[i].mailing_address;
					var mailing_state1 = get_state_id[i].mailing_state;
					var gstin_no = get_state_id[i].gstin_no;
					//alert(mailing_address1);

					var Dropdn = '<option value="' + mailing_state1 + '" data-gst="' + gstin_no + '">' + mailing_address1 + '</option>';
					$("#P_address").append(Dropdn);
					if (mailing_state1 != '') {
						setTimeout(function () {
							$('#P_address option:eq(1)').attr('selected', 'selected');
						}, 1000);

						setTimeout(function () {
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
				setTimeout(function () {
					var party_billing_state = $('#party_billing_state_id').val();
					var sale_company_state_idd = $('#sale_company_state_id').val();

					if (party_billing_state != sale_company_state_idd) {
						$('.cgst').hide();
						$('.sgst').hide();
						$('.igst').show();
					} else {
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

function sale_ledger_id_onchange() {
	$('.sale_ledger_id_onchange').change(function () {
		$('#sale_address').html('<option selected>Select Address</option>');
		var selected_sale_ledger_id = $(this).val();
		//alert(selected_sale_ledger_id);
		//$('#sale_company_state_id').val(selected_sale_ledger_id);
		var login_user_idd = $('#login_user_idddd').val();

		//setTimeout(function(){
		$.ajax({
			type: "POST",
			url: site_url + 'account/get_company_branch_state/',
			data: {
				id: selected_sale_ledger_id
			},
			success: function (result) {

				var obj = jQuery.parseJSON(result);


				var get_sale_state_id = jQuery.parseJSON(obj.address);
				var len = get_sale_state_id.length;
				//For State in multiple address

				for (var i = 0; i < len; i++) {

					var mailing_address1 = get_sale_state_id[i].compny_branch_name;
					var mailing_state1 = get_sale_state_id[i].state;
					var gstin_no = get_sale_state_id[i].company_gstin;
					var company_branch_iddd = get_sale_state_id[i].add_id;

					var Dropdn_sale = '<option value="' + mailing_state1 + '" data-gst="' + gstin_no + '" branh-id = "' + company_branch_iddd + '">' + mailing_address1 + '</option>';
					$("#sale_address").append(Dropdn_sale);
					if (mailing_state1 != '') {
						setTimeout(function () {
							$('#sale_address option:eq(1)').attr('selected', 'selected');
						}, 1000);

						setTimeout(function () {
							var datagstval = $('#sale_address option:selected').attr('data-gst');
							var dropDownSelectval = $('#sale_address option:selected').val();
							$('#sale_leger_gstin_no').val(datagstval);
							$('#sale_company_state_id').val(dropDownSelectval);

							var branch_idg = $('#sale_address option:selected').attr('branh-id');

							$('#sale_ledger_company_branch_id').val(branch_idg);
						}, 1500);
					}
				}

				setTimeout(function () {
					var sale_company_state_idd = $('#sale_company_state_id').val();
					var party_billing_state = $('#party_billing_state_id').val();
					//$('#sale_company_state_id').val(sale_company_state_idd);
					// alert(sale_company_state_idd);
					// alert(party_billing_state);
					if (party_billing_state != sale_company_state_idd) {
						$('.cgst').hide();
						$('.sgst').hide();
						$('.igst').show();
					} else {
						$('.cgst').show();
						$('.sgst').show();
						$('.igst').hide();
					}
				}, 2000);
			}
		});
		//}, 1000);
		var selected_sale_ledger_id2 = $(this).val();
		setTimeout(function () {
			var selected_sale_ledger_brch_id = $('#sale_ledger_company_branch_id').val();
			$.ajax({
				type: "POST",
				url: site_url + 'account/get_company_branch/',
				data: {
					id: selected_sale_ledger_id2,
					selected_sale_ledger_brch_id: selected_sale_ledger_brch_id
				},
				success: function (result_2) {
					$('#invoice_num').val(result_2);
				}
			});
		}, 2500);
	});
}

function get_add_more_btn_forsale_ledger() {
	$('#get_add_more_btn_forsale_ledger').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
		placeholder: 'Select And Begin Typing',
		ajax: {
			url: site_url + 'Ajaxrequest/ajaxSelect2search',
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
		},
		language: {
			noResults: function () {
				//return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Add More</a>";
				var searched_value = $('.select2-search__field').val();
				$('#fetch_pname').val(searched_value);
				var lb_ID = $('#fetch_pname').val();
				$('.party_namee').val(lb_ID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_party'>Add Sale Ledger </span>";
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});

}

function subtotal() {
	var tot = 0;
	var sale_amount2 = 0;
	var added_tax = 0;
	var added_tax_total = 0;
	$("input[name='amount[]']").each(function () {
		tot += parseFloat($(this).val());
	});
	var g_total2 = tot.toFixed(2);
	$(".grand_total").val(g_total2);
	$(".total_amount_save").val(g_total2);
	// $("input[name='sale_amount']").each(function () {
		// sale_amount2 += parseFloat($(this).val());
	// });
	$("input[name='added_tax_Row_val[]']").each(function () {
		added_tax += parseFloat($(this).val());
		added_tax_total = added_tax.toFixed(2);
	});
	sale_amount2 = g_total2 - added_tax;
	var amount_without_tax = sale_amount2.toFixed(2);
	$(".total_amountt").val(amount_without_tax);
	
	$(".tax_class").val(added_tax_total);

	
	
	setTimeout(function () {
		var result_divide = parseInt(added_tax_total) / parseInt(2);
	$(".tax_class1").val(result_divide);
	$(".tax_class2").val(result_divide);
	
					var sale_company_state_idd = $('#sale_company_state_id').val();
					var party_billing_state = $('#party_billing_state_id').val();
					//$('#sale_company_state_id').val(sale_company_state_idd);
					// alert(sale_company_state_idd);
					// alert(party_billing_state);
					if (party_billing_state != sale_company_state_idd) {
						$('.cgst').hide();
						$('.sgst').hide();
						$('.igst').show();
					} else {
						$('.cgst').show();
						$('.sgst').show();
						$('.igst').hide();
					}
				}, 400);
}

function kyup_function_to_remove_add_rate_qty() {
	$('.keyup_event').keyup(function () {
		var matrial_select_this_val = $(this);
		//when discount added and change quantity
		$(this).closest('.input_descr_wrap').find("select[name='disctype[]']").prop('selectedIndex', 0);
		$(this).closest('.input_descr_wrap').find("input[name='after_desc_amt[]']").val('');
		$(this).closest('.input_descr_wrap').find("input[name='discamt[]']").val('');
		$(this).closest('.input_descr_wrap').find("input[name='discamt[]']").attr('readonly', true);
		//when discount added and change quantity
		var theQuantity = $(this).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		var thePrice = $(this).closest('.input_descr_wrap').find("input[name='rate[]']").val();
		var thetax = $(this).closest('.input_descr_wrap').find("input[name='tax[]']").val();
		$(this).closest('.input_descr_wrap').find("input[name='added_tax']").val(thetax);
		var with_quantity_price = theQuantity * thePrice;
		var percent_on_total = thetax * with_quantity_price / 100;
		// alert(percent_on_total);

		setTimeout(function () {
			var grand_total_sum = 0;
			$("input[name='amount[]']").each(function () {
				grand_total_sum += Number($(this).val());
			});

			var grand_total_sum = grand_total_sum.toFixed(2);
			//alert(grand_total_sum);
			var charges_total = $('.total_charges_cls').val();
			//alert(charges_total);
			if (charges_total != '' || charges_total != '0.00') {

				var testee = (+charges_total) + (+grand_total_sum);

				$(".grand_total").val(testee);

			} else {

				$(".grand_total").val(grand_total_sum);
			}
		}, 1000);


		var Total_with_tax = parseFloat(percent_on_total) + parseFloat(with_quantity_price);
		var valueww = Total_with_tax.toFixed(2);
		$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(valueww);
		/* Calculation of Cess*/
		var cess_Amt = $(this).closest('.input_descr_wrap').find("input[name='cess[]']").val();
		var valuation_type_val = $(this).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val();
		console.log('vauation Type ====>', valuation_type_val);
		if (cess_Amt != '' || cess_Amt != null) {
			if (valuation_type_val == 'based_on_value') {
				var afteradd_cessTax = valueww * cess_Amt / 100;
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(afteradd_cessTax);
				var withcess_Amt = parseFloat(valueww) + parseFloat(afteradd_cessTax);
				setTimeout(function () {
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function () {
						var cess_calulation_val = $(this).val();
						if (cess_calulation_val == '') {
							var cess_calulation_val_vari = 0;
						} else {
							var cess_calulation_val_vari = $(this).val();
						}
						cess_totalamt += parseFloat(cess_calulation_val_vari);
					});
					var cess_totalamt_total = cess_totalamt.toFixed(2);
					$(".cess_total_cls").val(cess_totalamt_total);
				}, 1000);
				$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);
			}
			if (valuation_type_val == 'based_on_qty') {
				var cess_amt_ttl = theQuantity * cess_Amt;
				var afteradd_cessTax = parseFloat(valueww) + parseFloat(cess_amt_ttl);
				console.log('afteradd_cessTax ==>', afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(cess_amt_ttl);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function () {
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function () {
						var cess_calulation_val = $(this).val();
						if (cess_calulation_val == '') {
							var cess_calulation_val_vari = 0;
						} else {
							var cess_calulation_val_vari = $(this).val();
						}
						cess_totalamt += parseFloat(cess_calulation_val_vari);
					});
					var cess_totalamt_total = cess_totalamt.toFixed(2);
					$(".cess_total_cls").val(cess_totalamt_total);
				}, 1000);
				$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);

			}
			if (valuation_type_val == 'based_on_qty_value') {
				var cess_amt_ttl = theQuantity * cess_Amt;
				var Cess_persent_value = valueww * cess_Amt / 100;
				console.log('cess_amt_ttl', cess_amt_ttl);
				console.log('Cess_persent_value', Cess_persent_value);
				var Add_val_qty = parseFloat(Cess_persent_value) + parseFloat(cess_amt_ttl);
				console.log('Add_val_qty', Add_val_qty);
				var afteradd_cessTax = parseFloat(valueww) + parseFloat(Add_val_qty);
				console.log('afteradd_cessTax ==>', afteradd_cessTax);
				$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val(Add_val_qty);
				var withcess_Amt = afteradd_cessTax;
				setTimeout(function () {
					var cess_totalamt = parseFloat(0);
					$("input[name='cess_tax_calculation[]']").each(function () {
						var cess_calulation_val = $(this).val();
						if (cess_calulation_val == '') {
							var cess_calulation_val_vari = 0;
						} else {
							var cess_calulation_val_vari = $(this).val();
						}
						cess_totalamt += parseFloat(cess_calulation_val_vari);
					});
					var cess_totalamt_total = cess_totalamt.toFixed(2);
					$(".cess_total_cls").val(cess_totalamt_total);
				}, 1000);
				$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val(withcess_Amt);

			}
		} else if (cess_Amt == '' || cess_Amt == null) {
			$(this).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val('');
			$(this).closest('.input_descr_wrap').find("input[name='amount[]']").val('');
			$(".cess_total_cls").val('');
		}
		setTimeout(function () {
			var Cess_TOTAL = 0;
			$("input[name='cess_tax_calculation[]']").each(function () {
				Cess_TOTAL += Number($(this).val());
			});
			if (Cess_TOTAL == 0) {
				$('.cess').hide();
			} else {
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
		if (total_amount > 0) {
			$('.add_requried').prop("disabled", false);
		} else {
			$('.add_requried').prop("disabled", true);
		}

		var gg_total = $(".grand_total").val();

		if (gg_total > 50000) {
			$('#eway_bill_msg').html('Please Add E-way bill Number');
			$("#eway_bill_msg").delay(3200).fadeOut(2000);
		}

		$('#total_amout_with_tax_on_keyup').val(gg_total);
		$('#total_amout_without_tax_on_keyup').val(total_amount);

		var matrial_select_this2 = $(this);
		var matral_idds = $(matrial_select_this2).closest('.input_descr_wrap').find("input[name='mat_idd_name']").val();
		var added_qty = $(matrial_select_this2).closest('.input_descr_wrap').find("input[name='quantity[]']").val();
		$.ajax({
			type: "POST",
			url: site_url + 'account/get_closing_matrila_qty/',
			data: {
				matral_idds: matral_idds
			},
			success: function (result) {
				if (parseInt(added_qty) > parseInt(result)) {
					//$('#mat_msg').html('The Available Quantity is ' + result);
					//$('.chrk_mat_qty').attr("disabled", "disabled");
				} else {
					// $('#mat_msg').html('');
					//$('.chrk_mat_qty').removeAttr("disabled");
				}
			}
		});
	});
}

function get_material_thrugh_item_code() {
	$('.mat_item_code').on("keydown keyup paste", function () {
		var added_code_length = $(this).val().length;
		if (added_code_length >= 3) {
			var matrial_select_this_code = $(this);
			var selected_material_code = $(this).val();

			setTimeout(function () {
				$.ajax({
					type: "POST",
					url: site_url + 'account/selectMatrial_according_item_code/',
					data: {
						material_code: selected_material_code
					},
					success: function (result) {
						var obj = jQuery.parseJSON(result);
						console.log('There', obj);
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
						if (cess_var != '' || cess_var != null) {
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess[]']").val(cess_var);
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess_all_total[]']").val(cess_var);
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val(valuation_type);
						} else if (cess_var == '' || cess_var == null) {
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess[]']").val();
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess_all_total[]']").val('');
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='valuation_type[]']").val();
							$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='cess_tax_calculation[]']").val('');
						}
						var newOption = $("<option selected='selected'></option>").val(mat_idds).text(material_name_cd);


						$(matrial_select_this_code).closest('.input_descr_wrap').find(".get_val").append(newOption).trigger('change');
						$(matrial_select_this_code).closest('.input_descr_wrap').find("input[name='UOM[]']").val(uom_var);
						subtotal();

						setTimeout(function () {
							$('.keyup_event').keyup();
						}, 1000);

					}
				});
			}, 1000);
		}

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

function inProcess2_leads(){
	$('#inprocess_lead_frm').submit();
}
function complete2_leads(){
	$('#complete_lead_frm').submit();
}
function auto2_leads(){
	$('#auto_lead_frm').submit();
}
function bidmgm2_leads(){
	$('#bidmgmt_frm').submit();
}
function inprocess_saleorderc(){
	$('#inprocess_saleordr_frm').submit();
}
function complete_saleorderc(){
	$('#completee_saleordr_frm').submit();
}



$(document).on("click",".close_unqstatus_model",function(){
	$("#comntmodal").modal('hide');
	$('.nav-md').addClass('modal-open');

});
//change status
$( document ).ready(function() {
$("#lead_status_filter").on("change", function () {
var status=$("#lead_status_filter").val();
var inputElements=document.getElementsByClassName('checkbox1');
//console.log(inputElements);
//return false;``
for(var i=0; inputElements[i]; ++i){
      if(inputElements[i].checked){
      	//console.log(inputElements[i].getAttribute('data-status'));
           checkedValue = inputElements[i].value;
           oldstatus = inputElements[i].getAttribute('data-status');

		$.ajax({
				   type: "POST",
				   url: site_url+'crm/update_lead_status/',
				   data: { id:checkedValue,status,oldstatus1:oldstatus},
				   success: function() {
					   window.location.href= site_url+"crm/leads";
				   }
		});
      }
}
});
});



function printData(){
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
		 location.reload();
}
$('#bbtn').on('click',function(){
	printData();
})


// $(function(){
//     // get stored value or make it empty string if not available
//     var storedValue = localStorage.getItem('prod-detail') || '';

//     $('.ProductDetails select').change(function () {
//          // store current value
//          var currValue = $(this).val();
//          localStorage.setItem('prod-detail', currValue );
//          // now reload and all this code runs again
//          location.reload();
//     })
//     // set stored value when page loads
//     .val(storedValue)

// });


// $("#lead_owner_filter1").on("change", function () {
// var u_id = $("#lead_owner_filter1").val();
// 		$.ajax({
// 				   type: "POST",
// 				   url: site_url+'crm/pipeline/',
// 				   data: { user_id:u_id},
// 				   success: function() {
// 					   window.location.href= site_url+"crm/pipeline/"+u_id;
// 				   }
// 		});
// });
//$("document").ready(function(){
 $("#fileUpload").change(function() {
        //Reference the FileUpload element.
        var fileUpload = $("#fileUpload")[0];

        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();

                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        ProcessExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcessExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid Excel file.");
        }
});

// remove data


 //});
    function ProcessExcel(data) {
        //Read the Excel File data.
        var workbook = XLSX.read(data, {
            type: 'binary'
        });

        //Fetch the name of First Sheet.
        var firstSheet = workbook.SheetNames[0];

        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
 		//console.log(excelRows);


        //Create a HTML Table element.
        var table = $("<table />").addClass("table table-striped table-bordered user_index");
        table[0].border = "1";

        table[0].id = "datatableid";

        //Add the header row.
        var row = $(table[0].insertRow(-1));

       //Add the header cells.

        var headerCell = $("<th />");
        headerCell.html("S No.");
        row.append(headerCell);

        var headerCell = $("<th />");
        headerCell.html("SKU ID");
        row.append(headerCell);

        var headerCell = $("<th />");
        headerCell.html("Customer Type");
        row.append(headerCell);

        var headerCell = $("<th />");
        headerCell.html("Selling Price");
        row.append(headerCell);

        var headerCell = $("<th />");
        headerCell.html("Cost Price");
        row.append(headerCell);

        var headerCell = $("<th />");
        headerCell.html("MOU Pirice");
        row.append(headerCell);

        var headerCell = $("<th />");
        headerCell.html("MRP Price");
        row.append(headerCell);

        var headerCell = $("<th />");
        headerCell.html("Validation Status");
        row.append(headerCell);

  //        var headerCell = $("</thead>");
		// row.append(headerCell);

 		var r = 1;

        //Add the data rows from Excel file.
        for (var i = 0; i < excelRows.length; i++) {
            //Add the data row.
            var validateresult;

            var row = $(table[0].insertRow(-1));

            //Add the data cells.
            var cell = $("<td />");
            cell.html(r);
            row.append(cell);

            var cell = $("<td />");
            cell.html(excelRows[i].SKU_ID);
            row.append(cell);

            cell = $("<td />");
            cell.html(excelRows[i].Customer_Type);
            row.append(cell);


            var regex1 = /^[A-Za-z]+$/

	        //Validate TextBox value against the Regex.
	        var isValid1 = regex1.test(excelRows[i].Customer_Type);
	        if (!isValid1) {
	            validateresult = "Invalid Data";
	        }
	        else
	        {
	        	validateresult = "Valid Data";
	        }

 			cell = $("<td />");
            cell.html(excelRows[i].Selling_Price);
            row.append(cell);

            var regex22 = /^[0-9]+$/

	        //Validate TextBox value against the Regex.
	        var isValid22 = regex22.test(excelRows[i].Selling_Price);
	        if (!isValid22) {
	            validateresult = "Invalid Data";
	        }
	        else
	        {
	        	validateresult = "Valid Data";
	        }




            cell = $("<td />");
            cell.html(excelRows[i].Cost_Price);
            row.append(cell);

            var regex2 = /^[0-9]+$/

	        //Validate TextBox value against the Regex.
	        var isValid2 = regex2.test(excelRows[i].Cost_Price);
	        if (!isValid2) {
	            validateresult = "Invalid Data";
	        }
	        else
	        {
	        	validateresult = "Valid Data";
	        }



            cell = $("<td />");
            cell.html(excelRows[i].MOU_Pirice);
            row.append(cell);

            var regex3 = /^[0-9]+$/

	        //Validate TextBox value against the Regex.
	        var isValid3 = regex3.test(excelRows[i].MOU_Pirice);
	        if (!isValid3) {
	            validateresult = "Invalid Data";
	        }
	        else
	        {
	        	validateresult = "Valid Data";
	        }



            cell = $("<td />");
            cell.html(excelRows[i].MRP_Price);
            row.append(cell);


            var regex4 = /^[0-9]+$/

	        //Validate TextBox value against the Regex.
	        var isValid4 = regex4.test(excelRows[i].MRP_Price);
	        if (!isValid4) {
	            validateresult = "Invalid Data";
	        }
	        else
	        {
	        	validateresult = "Valid Data";
	        }

	        if((excelRows[i].Selling_Price > excelRows[i].Cost_Price)){

	        	validateresult = "Invalid Price";

	        	console.log("am here1");
	        }
	        else if((excelRows[i].MRP_Price > excelRows[i].Cost_Price)){

	        	validateresult = "";
	        	console.log("am here2");
	        }

	        else if((excelRows[i].Selling_Price > excelRows[i].MRP_Price)){

	        	validateresult = "Invalid Price";
	        	console.log("am here2");
	        }
	        else{

	        	validateresult = "Valid Data";
	        	console.log("am tere");

	        }
	        console.log(excelRows[i].MRP_Price);
	        console.log(excelRows[i].Cost_Price);


	        if(validateresult == "Invalid Data" || validateresult == "Invalid Price"){
	        	validateresult = 'Invalid Data <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:red"></i>';
	        }

            else{
            	validateresult = '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>';
            }
            cell = $("<td />");
            cell.html(validateresult);
            row.append(cell);
            r++;
        }

        var dvExcel = $("#dvExcel");
        dvExcel.html("");
        dvExcel.append(table);

        var $tableContainer = $('#dvExcel')
			var myTable = jQuery("#datatableid");
			var thead = myTable.find("thead");
			var thRows =  myTable.find("tr:has(th)");
			if (thead.length===0){
			    thead = jQuery("<thead></thead>").appendTo(myTable);
			}
			var copy = thRows.clone(true).appendTo("thead");
			thRows.remove();
			$('#datatableid').dataTable();
    };
$( '#fileUpload' ).click( function () {
		$('input[type=file]').val('');
		$('#dvExcel').html('');
});


function get_customer_data(){
	$('.exixting_c').change(function(){
		$('#consignee_state_address').html('<option value="" selected>Select Address</option>');
		var selected_consignee_name_ledger_id = $(this).val();
		var login_user_idd = $('#login_user_idddd').val();
		$.ajax({
			type: "POST",
			url: site_url+'crm/getCustomerDataById/',
			data: { id:selected_consignee_name_ledger_id},
			success: function(result) {

				var obj = jQuery.parseJSON(result);
					var country_id 			= obj.billing_country;
					var state_id 				= obj.billing_state;
					var city_id 				= obj.billing_city;
					var country 			= obj.country;
					var state 				= obj.state;
					var city 				= obj.city;
					var billing_street 		= obj.billing_street;
					var billing_zipcode 		= obj.billing_zipcode;
					var name 		= obj.name;
					 var  Dropdn1 = '<option value="'+ country_id +'">'+ country   +'</option>';
					 $(".country_id").html(Dropdn1);

					 var  Dropdn2 = '<option value="'+ state_id +'">'+ state   +'</option>';
					 $(".state_id").html(Dropdn2);

					 var  Dropdn3 = '<option value="'+ city_id +'">'+ city   +'</option>';
					 $(".city_id").html(Dropdn3);


					//console.log(billing_street);
					//$("#street").val(billing_street);
					var input = $( "#street" );
					input.val(billing_street);

					var input1 = $( "#zipcode" );
					input1.val(billing_zipcode);

					var input2 = $( "#company" );
					input2.val(name);

			}
		});
 	});
}


$(document).on('change', '.delivery_setting', function () {
	var crm_del_s;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) crm_del_s = 1;
	else crm_del_s = 0;
	var id = $(this).attr("data-value");

	$.ajax({
		url: site_url + 'crm/delivery_setting/',
		dataType: 'json',
		type: 'POST',
		data: {
			'id': id,
			'crm_del_s': crm_del_s,
		},
		success: function (data) {

			if (data == true) {
				$('.mesg').html('<b style="color: #E9EDEF; background-color: green;border-color: green;clear: both;padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;width: 100%;display: block;"> CRM Delivery Setting update Successfully.</b>');

					   setTimeout(function(){
						   window.location.reload();
						   }, 1000);
			}
		}
	});
});
function showFreight(){
	//$(function() {		
		if($("input[name='freight']:checked").val() =='To be paid by customer'){		
			$('#freight1').show();
		}else{
			$('#freight1').hide();
		}
		//$('#freight1').hide();
		$('input[name="freight"]').on('click', function() {
			if ($(this).val() != 'FOR price') {
				$('#freight1').show();
			}
			else {
				$('#freight').val('0');
				$('#freight1').hide();
				var freightCharges = 0;
				var total = $(".divSubTotal").text();
				var discount_value = $(".divDiscountValue").text();
				var special_discount = $("#special_discount").val();
				var gfc = parseInt(freightCharges)*18/100;
				var gst_set = $(".divTax").text();
				var advance_received = $(".divAdvancePaid").text();
				var spd_value = total*(special_discount/100);
				var div_total = total - parseFloat(discount_value) - spd_value;
				var grand_total = parseInt(div_total)+parseInt(gst_set)+parseInt(freightCharges)+parseInt(gfc);
				var remain_balance = parseInt(grand_total)-parseInt(advance_received);

				parseFloat($(".divFreightCharge").text(freightCharges));
				parseFloat($(".divGSTFreight").text(gfc));
				parseFloat($(".divTotal").text(div_total));
				parseFloat($(".divGrandTotal").text(grand_total));
				parseFloat($(".divBalance").text(remain_balance));

				parseFloat($(".grandTotal").val(grand_total));

			//	keyupFunction();
			} 
		});
			$('input[name="freight"]').on('click', function() {
			if ($(this).val() == 'FOR price') {
				$('#freight1').hide();
			}
			// else {
			// 	$('#freight').val('');
			// 	$('#freight1').hide();
			// 	keyupFunction();
			// } 
		});
	//});
}

// Script of preview 
$(document).on("click","#view_preview",function(){
 
        var order_date=$('#order_date').val();
        var cName=$('#account_id option:selected').text(); 
        var cUnit=$('#company_unit option:selected').text(); 
        var cPhone_no=$('#phone_no').val();
        var dispatchDate=$('#dispatch_date').val();
        var otherTaxt=$('#agt').val();  
        var Freight =$("input[name='freight']:checked").val()
        var paymentTerms=$('#payment_terms').val();
        var payment_date=$('#payment_date').val();
        var advance_received=$('#advance_received').val();
        var label_printing_express=$('#label_printing_express').val();
        var brand_label=$('#brand_label').val(); 
        var productApplication=$('#product_application').val(); 
        var gaurantee=$('#gaurantee').val(); 
        var total1=$('#total').val();
        var grandTotal=$('#grandTotal').val();
        var freight =$('#freight').val(); 

        //var inputData = []
        var inputData =`<div role="tabpanel" class="tab-pane fade active in" id="view" aria-labelledby="inprocess_sale_order_tab" style="margin-top: 0px !important;">
    <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
        <div class="col-md-6 col-xs-12 label-left">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Company Unit</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>${cUnit}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Contact No </label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>${cPhone_no}</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 label-left">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Customer Name</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>${cName}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Order Date</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>${order_date}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Dispatch Date</label>
                <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                    <div>${dispatchDate}</div>
                </div>
            </div>
        </div>
        <hr />
        <div class="bottom-bdr"></div>
        <div class="container mt-3">
            <h3 class="Material-head">  Product Details  <hr /> </h3>
            <div class="col-container mobile-view2"> 
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">Product Type</div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">Product Name</div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group">Alias</div> 
        <div class="col-md-1 col-sm-12 col-xs-12 form-group">Quantity</div> 
        <div class="col-md-1 col-sm-12 col-xs-12 form-group">UOM</div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group">Price</div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group">GST</div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group">Total</div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">Total With GST</div>
      </div>`;
        $('.well').each(function(){
        	var mType = $(this).find('#material_type_id option:selected').text();
        	var material = $(this).find('#material option:selected').text();
        	var delivery_Add = $(this).find('#delivery_Add ').text();
        	var aliasNameMat = $(this).find('#aliasNameMat option:selected').text();
        	var description = $(this).find('.description').text();
        	var quantity = $(this).find('.quantity ').val();
        	var uom = $(this).find('.uom').text();
        	var price = $(this).find('.price ').val();
        	var gst = $(this).find('.gst').val();
        	var total = $(this).find('.total').val(); 
            var totalWithGst = $(this).find('.totalWithGst').val(); 
        	inputData += `
           <div class="row-padding col-container mobile-view view-page-mobile-view">
        
        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>Product Type</label>
            <div>${mType}</div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>Product Name</label>
            <div>${material}</div>
        </div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
            <label>Quantity</label>
            <div>${aliasNameMat}</div>
        </div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
            <label>Quantity</label>
            <div>${quantity}</div>
        </div> 

        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
            <label>UOM</label>
            <div>${uom}</div>
        </div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
            <label>Price</label>
            <div>${price}</div>
        </div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
            <label>GST</label>
            <div>${gst}</div>
        </div>
        <div class="col-md-1 col-sm-12 col-xs-12 form-group col">
            <label>Total</label>
            <div>${total}</div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group col">
            <label>Total With GST</label>
            <div>${totalWithGst}</div>
        </div>
    </div>`;
        	// matData = {
        	// 	'Material_Type':$(this).find('#material_type_id option:selected').text(),
        	// }
        	// inputData.push(matData);
 });

     inputData +=`<div class="col-md-12 col-sm-12 col-xs-12" style="clear: both; margin-top: 22px;">
                    <div class="col-md-4 col-sm-5 col-xs-12 text-right" style="float: right;">
                        <div class="col-md-12 col-sm-5 col-xs-12 text-right">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-right igst style='display:none;'">
                                <div class="col-md-6 col-sm-5 col-xs-6 text-right">Total :</div>
                                <div class="col-md-6 col-sm-5 col-xs-6 text-left">${total1}</div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 20px; color: #2c3a61; border-top: 1px solid #2c3a61;">
                                <div class="col-md-6 col-sm-5 col-xs-6 text-right">
                                    Grand Total :
                                </div>
                                <div class="col-md-6 col-sm-5 col-xs-6 text-left">
                                    <span class="divSubTotal fa fa-rupee" aria-hidden="true">${grandTotal}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <hr />
                <div class="bottom-bdr"></div>
                <div class="col-md-6 col-xs-12 label-left">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Other Taxes</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                            <div>${otherTaxt}</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Freight Charges</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                            <div>${freight}</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Payment Terms</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                            <div>${paymentTerms}</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Advance Received</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                            <div>${advance_received}</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Cash Discount</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                            <div>${freight}</div>
                        </div>
                    </div> 
                </div>

                <div class="col-md-6 col-xs-12 label-left">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Other Expenses</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                            <div>${label_printing_express}</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label for="material">Brand Label</label>
                        <div class="col-md-6 col-sm-12 col-xs-6 form-group">
                            <div>${brand_label}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`;


$("#previewData").modal({
	show: false,//backdrop: 'static' 
});
  $('#previewData').modal('toggle');
$('#previewData').find('.modal-body').html(inputData); 
 setTimeout(function(){
	   $("body").addClass("modal-open");
   }, 1000);

}); 
$(document).on("click",".previewClose",function(){  
 setTimeout(function(){
	   $("body").addClass("modal-open");
   }, 1000);
    $('#previewData').modal('hide');
 });

function add_billing_multi_address(){
var max_fields      = 10; //maximum input boxes allowed
var wrap         = $(".add_more_billing_addsss"); //Fields wrapper
var add_button      = $(".add_billing_multi_address_1"); //Add button ID
var x = 1;
$(add_button).click(function(e){ 
    e.preventDefault();
    var lead_section = $(".add_more_billing_addsss .first_added_rows ").length;
		var lead_added = $(".add_more_billing_addsss .add_more_billing_addsss ").length;
		var next_row = parseInt(lead_added)+ parseInt(lead_section)+ parseInt('1');
		$('.add_requried').prop("disabled", true);
		var company_login_id = $('#company_login_id').val();
    if(x < max_fields){ //max input box allowed
        x++;
	var addressClass = 'address'+x;
			$(wrap).append('<div class="add_more_billing_addsss scend-tr mobile-view mailing-box" ><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Mailing Name</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="billing_company_1" name="billing_company_1[]" class="form-control col-md-7 col-xs-12" placeholder="Company" value=""></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Address</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><textarea id="billing_street_1" rows="6" name="billing_street_1[]" class="form-control col-md-7 col-xs-12" placeholder="Address" required=""></textarea></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_country">Country </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select id="billing'+next_row+'" class="itemName form-control selectAjaxOption select2 country_id select2-hidden-accessible" name="billing_country_1[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this, this.id)" required=""><option value="">Select Option</option></select></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">State </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select id="billingC'+next_row+'" class="itemName form-control selectAjaxOption select2 '+addressClass+' billing'+next_row+' state_id select2-hidden-accessible" name="billing_state_1[]" width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this, this.id)" required=""><option value="">Select Option</option></select></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">City </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2  '+addressClass+' billingC'+next_row+' city_id select2-hidden-accessible" name="billing_city_1[]" width="100%" tabindex="-1" aria-hidden="true" required=""><option value="">Select Option</option></select></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-2 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Pincode </label><div class="col-md-12 col-sm-12 col-xs-12 item form-group"><input type="number" id="billing_zipcode_1" name="billing_zipcode_1[]" class="form-control col-md-7 col-xs-12" value="" required="" placeholder="Pincode"></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">GSTIN </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="billing_gstin_1" name="billing_gstin_1[]" class="form-control col-md-7 col-xs-12 GSTValidORNOT" placeholder="GSTIN" value=""  onblur="fnValidateGSTIN(this)"><span class="Gstmsg" style="text-align: center;display: block;color: red;"></span></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="billing_phone_addrs" style="border-right: 1px solid #c1c1c1;">Phone no</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="billing_phone_addrs" name="billing_phone_addrs[]" class="form-control col-md-7 col-xs-12" placeholder="Phone no." value=""></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12" style="width: 35px;"><label class=" col-md-3 col-sm-3 col-xs-12" for="phone_addrs" style="border-right: 1px solid #c1c1c1;   height: 37px;"></label><div class="Product_Image col-xs-12" style="border-right: 1px solid #c1c1c1;   height: 38px;"><input type="checkbox" class="flat" data-tooltip="Please Check if you have Same Shipping Address" value="" name="same_shipping[]"></div></div><button class="btn btn-danger remove_ledger_add_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
		init_select2();
		$('#gstin_no').keyup(function(){
			this.value = this.value.toUpperCase();
		});
});

$(wrap).on("click",".remove_ledger_add_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
});
}

function add_shipping_multi_address(){
var max_fields      = 10; //maximum input boxes allowed
var wrap         = $(".add_more_shipping_addsss"); //Fields wrapper
var add_button      = $(".add_shipping_multi_address_1"); //Add button ID
var x = 1;
$(add_button).click(function(e){ 
    e.preventDefault();
    var lead_section = $(".add_more_shipping_addsss .first_added_rows ").length;
		var lead_added = $(".add_more_shipping_addsss .add_more_shipping_addsss ").length;
		var next_row = parseInt(lead_added)+ parseInt(lead_section)+ parseInt('1');
		$('.add_requried').prop("disabled", true);
		var company_login_id = $('#company_login_id').val();
    if(x < max_fields){ //max input box allowed
        x++;
	var addressClass = 'address'+x;
			$(wrap).append('<div class="add_more_shipping_addsss scend-tr mobile-view mailing-box" ><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Mailing Name</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="shipping_company_1" name="shipping_company_1[]" class="form-control col-md-7 col-xs-12" placeholder="Company" value=""></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class="col-md-3 col-sm-12 col-xs-12" for="mailing_address">Address</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><textarea id="shipping_street_1" rows="6" name="shipping_street_1[]" class="form-control col-md-7 col-xs-12" placeholder="Address" required=""></textarea></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-2 col-sm-3 col-xs-12" for="mailing_country">Country </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select id="shipping'+next_row+'" class="itemName form-control selectAjaxOption select2 country_id select2-hidden-accessible" name="shipping_country_1[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" onchange="getState(event,this, this.id)" required=""><option value="">Select Option</option></select></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_state">State </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select id="shippingC'+next_row+'" class="itemName form-control selectAjaxOption select2 '+addressClass+' shipping'+next_row+' state_id select2-hidden-accessible" name="shipping_state_1[]" width="100%" tabindex="-1" aria-hidden="true" onchange="getCity(event,this, this.id)" required=""><option value="">Select Option</option></select></div></div><div class="item form-group col-md-2 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="mailing_city">City </label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2   '+addressClass+' shippingC'+next_row+' city_id select2-hidden-accessible" name="shipping_city_1[]" width="100%" tabindex="-1" aria-hidden="true" required=""><option value="">Select Option</option></select></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-2 col-xs-12" for="mailing_pincode" style="border-right: 1px solid #c1c1c1;">Pincode </label><div class="col-md-12 col-sm-12 col-xs-12 item form-group"><input type="number" id="shipping_zipcode_1" name="shipping_zipcode_1[]" class="form-control col-md-7 col-xs-12" value="" required="" placeholder="Pincode"></div></div><div class="item form-group col-md-1 col-sm-12 col-xs-12"><label class=" col-md-3 col-sm-3 col-xs-12" for="shipping_phone_addrs" style="border-right: 1px solid #c1c1c1;">Phone no</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="shipping_phone_addrs" name="shipping_phone_addrs[]" class="form-control col-md-7 col-xs-12" placeholder="Phone no." value=""></div></div><button class="btn btn-danger remove_ledger_add_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
		init_select2();
		$('#gstin_no').keyup(function(){
			this.value = this.value.toUpperCase();
		});
});

$(wrap).on("click",".remove_ledger_add_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
});
}

function getPhoneNumber(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
$.ajax({
	type: "POST",
	url: site_url + 'crm/getPhoneNumber',
	data: {
	    id: id
	},
	success: function (data) {
		var obj = jQuery.parseJSON(data);
		   // alert(obj.type_of_customer);
	 $('.phn_number').val(obj.phone);
	 $('#contact_name').val(obj.name);
	 $('#discount_rate').val('0');
	 if(obj.type_of_customer == 2){
		 $(".noneradio").prop("checked", true);
		 // $('#radio_msg').delay(10).fadeOut();
	 }else{
		 $('#radio_msg').fadeIn();
		 $(".noneradio").prop("checked", false);
		 $('#radio_msg').html('Please Select Load Type First');
		 $('#radio_msg').delay(6000).fadeOut();
	 }
	 
	 
	 
	  /* Full / Half/ None radio button getting deselect Start 10-03-2022 */
	 //$('.calcDiscount').prop('checked', false);	
	 /* Full / Half/ None radio button getting deselect End 10-03-2022 */	
	var total = $(".divSubTotal").text();
	var discount_value = 0;
	var special_discount = $(".special_discount").val();
	var freightCharges = $(".divFreightCharge").text();
	var gfc = $(".divGSTFreight").text();
	var gst_set = $(".divTax").text();
	var advance_received = $(".divAdvancePaid").text();
	var spd_value = total*(special_discount/100);
	var div_total = total - discount_value - spd_value;
	var grand_total = parseInt(div_total)+parseInt(gst_set)+parseInt(freightCharges)+parseInt(gfc);
	var remain_balance = parseInt(grand_total)-parseInt(advance_received);
	
	parseFloat($(".divDiscountValue").text(discount_value));
	parseFloat($(".divTotal").text(div_total));
	parseFloat($(".divGrandTotal").text(grand_total));
	parseFloat($(".divBalance").text(remain_balance));

	parseFloat($(".grandTotal").val(grand_total));


	}
});

}

$(document).on('change', '.c_address121 ', function(){
	var dataaddress = $('#c_address option:selected').attr('data-address');
	 var gstnumber = $('#c_address option:selected').attr('data-gst');
	$('.customer_address_dtl').val(dataaddress);
	$('#gstin').val(gstnumber);
	
});

$(document).on('change', '.c_addressChoose121 ', function(){
	var dataaddress = $('#sc_address option:selected').attr('data-address');

	$('.shipping_address_dtl').val(dataaddress);
});

function getvarientList(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
// alert(id);
var product_code = $(option).text();
var parent_id = $(option).parents('.well').attr('id');
$.ajax({
	type: "POST",
	url: site_url + 'crm/getvarientList',
	data: {
	    id: id,
	    product_code:product_code
	},
	success: function (data) {
	 $('#variant_List').find('.modal-body').html(data);
	 $('#variant_List').modal({backdrop: 'static', keyboard: false});
	 $('.variant_submit').attr('parent_id', parent_id);
	}
});

}

function getsecvarientList(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
var product_code = $(option).attr('product_code');
//alert(product_code);
var pid = $(option).attr('p_id');
var op_type = $(option).attr('op_type');
$.ajax({
	type: "POST",
	url: site_url + 'crm/getsecvarientList',
	data: {
	    id: id,
	    op_type:op_type,
	    pid:pid,
	    product_code:product_code
	},
	success: function (data) {
	 
	var obj = jQuery.parseJSON(data);
	 /// alert(obj.mat_sales_price);
	$('.sec_optn').html(obj.html);
	$('.variant_submit').attr('mat_name', obj.mat_name);
	$('.variant_submit').attr('mat_id', obj.mat_id);
	$('.variant_submit').attr('mat_sales_price', obj.mat_sales_price);
	$('.variant_submit').attr('mat_tax', obj.mat_tax);
	$('.variant_submit').attr('total_cbf', obj.total_cbf);
	$('.variant_submit').attr('total_weight', obj.total_weight);
	$('.variant_submit').attr('mat_uom', obj.mat_uom);
	$('.variant_submit').attr('uomid', obj.uomid);
	$('.variant_submit').attr('main_img_path', obj.main_img_path);
	$('.variant_submit').attr('standard_packing', obj.standard_packing);
	$('.first_row').html('<img style="width: 50px; height: 50px;" src="'+obj.img_path+'"><input type="hidden" name="pro_img[]" value="'+obj.img_path+'">');	 
	}
});

}

function getthirdvarientList(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
var product_code = $(option).attr('product_code');
//alert(product_code);
var pid = $(option).attr('p_id');
var c_id = $(option).attr('c_id');
var op_type = $(option).attr('op_type');
$.ajax({
	type: "POST",
	url: site_url + 'crm/getthirdvarientList',
	data: {
	    id: id,
	    pid:pid,
	    op_type:op_type,
	    c_id:c_id,
	    product_code:product_code
	},
	success: function (data) {
	var obj = jQuery.parseJSON(data);
	$('.third_optn').html(obj.html);
	$('.variant_submit').attr('mat_name', obj.mat_name);
	$('.variant_submit').attr('mat_id', obj.mat_id);
	$('.variant_submit').attr('mat_sales_price', obj.mat_sales_price);
	$('.variant_submit').attr('mat_tax', obj.mat_tax);
	$('.variant_submit').attr('total_cbf', obj.total_cbf);
	$('.variant_submit').attr('total_weight', obj.total_weight);
	$('.variant_submit').attr('mat_uom', obj.mat_uom);
	$('.variant_submit').attr('uomid', obj.uomid);
	$('.variant_submit').attr('main_img_path', obj.main_img_path);
	$('.variant_submit').attr('standard_packing', obj.standard_packing);
	$('.sec_row').html('<img style="width: 50px; height: 50px;" src="'+obj.img_path+'"><input type="hidden" name="pro_img[]" value="'+obj.img_path+'">'); 
	}
});

}

function getfourvarientList(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
var product_code = $(option).attr('product_code');
var pid = $(option).attr('p_id');
var f_id = $(option).attr('f_id');
var s_id = $(option).attr('s_id');
var op_type = $(option).attr('op_type');
$.ajax({
	type: "POST",
	url: site_url + 'crm/getfourvarientList',
	data: {
	    id: id,
	    pid:pid,
	    op_type:op_type,
	    f_id:f_id,
	    s_id:s_id,
	    product_code:product_code
	},
	success: function (data) {
	var obj = jQuery.parseJSON(data);
	
	$('.four_optn').html(obj.html);
	$('.variant_submit').attr('mat_name', obj.mat_name);
	$('.variant_submit').attr('mat_id', obj.mat_id);
	$('.variant_submit').attr('mat_sales_price', obj.mat_sales_price);
	$('.variant_submit').attr('mat_tax', obj.mat_tax);
	$('.variant_submit').attr('total_cbf', obj.total_cbf);
	$('.variant_submit').attr('total_weight', obj.total_weight);
	$('.variant_submit').attr('mat_uom', obj.mat_uom);
	$('.variant_submit').attr('uomid', obj.uomid);
	$('.variant_submit').attr('main_img_path', obj.main_img_path);
	$('.variant_submit').attr('standard_packing', obj.standard_packing);
	$('.third_row').html('<img style="width: 50px; height: 50px;" src="'+obj.img_path+'"><input type="hidden" name="pro_img[]" value="'+obj.img_path+'">'); 
	}
});

}

function getfivevarientList(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
var product_code = $(option).attr('product_code');
var pid = $(option).attr('p_id');
var f_id = $(option).attr('f_id');
var s_id = $(option).attr('s_id');
var t_id = $(option).attr('t_id');
var op_type = $(option).attr('op_type');
$.ajax({
	type: "POST",
	url: site_url + 'crm/getfivevarientList',
	data: {
	    id: id,
	    pid:pid,
	    op_type:op_type,
	    f_id:f_id,
	    s_id:s_id,
	    t_id:t_id,
	    product_code:product_code
	},
	success: function (data) {
	var obj = jQuery.parseJSON(data);
	$('.five_optn').html(obj.html);
	$('.variant_submit').attr('mat_name', obj.mat_name);
	$('.variant_submit').attr('mat_id', obj.mat_id);
	$('.variant_submit').attr('mat_sales_price', obj.mat_sales_price);
	$('.variant_submit').attr('mat_tax', obj.mat_tax);
	$('.variant_submit').attr('total_cbf', obj.total_cbf);
	$('.variant_submit').attr('total_weight', obj.total_weight);
	$('.variant_submit').attr('mat_uom', obj.mat_uom);
	$('.variant_submit').attr('uomid', obj.uomid);
	$('.variant_submit').attr('main_img_path', obj.main_img_path);
	$('.variant_submit').attr('standard_packing', obj.standard_packing);
	$('.four_row').html('<img style="width: 50px; height: 50px;" src="'+obj.img_path+'"><input type="hidden" name="pro_img[]" value="'+obj.img_path+'">'); 
	}
});

}

function getsixvarientList(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
var product_code = $(option).attr('product_code');
var pid = $(option).attr('p_id');
var f_id = $(option).attr('f_id');
var s_id = $(option).attr('s_id');
var t_id = $(option).attr('t_id');
var fr_id = $(option).attr('fr_id');
var op_type = $(option).attr('op_type');
$.ajax({
	type: "POST",
	url: site_url + 'crm/getsixvarientList',
	data: {
	    id: id,
	    pid:pid,
	    op_type:op_type,
	    f_id:f_id,
	    s_id:s_id,
	    t_id:t_id,
	    fr_id:fr_id,
	    product_code:product_code
	},
	success: function (data) {
	var obj = jQuery.parseJSON(data);
	$('.variant_submit').attr('mat_name', obj.mat_name);
	$('.variant_submit').attr('mat_id', obj.mat_id);
	$('.variant_submit').attr('mat_sales_price', obj.mat_sales_price);
	$('.variant_submit').attr('mat_tax', obj.mat_tax);
	$('.variant_submit').attr('total_cbf', obj.total_cbf);
	$('.variant_submit').attr('total_weight', obj.total_weight);
	$('.variant_submit').attr('mat_uom', obj.mat_uom);
	$('.variant_submit').attr('uomid', obj.uomid);
	$('.variant_submit').attr('main_img_path', obj.main_img_path);
	$('.variant_submit').attr('standard_packing', obj.standard_packing);
	$('.five_row').html('<img style="width: 50px; height: 50px;" src="'+obj.img_path+'"><input type="hidden" name="pro_img[]" value="'+obj.img_path+'">'); 
	}
});

}
$(document).on('click', '.close_vlist ', function(){
$('#variant_List').modal('hide');
setTimeout(function(){
$('body').addClass('modal-open');
}, 700);
})
$(document).on('click', '.variant_submit', function(){
	// $('.calcDiscount').attr('checked', false);
var mat_name = $(this).attr('mat_name');
var mat_id = $(this).attr('mat_id');
var mat_sales_price = $(this).attr('mat_sales_price');
var mat_tax = $(this).attr('mat_tax');
var total_weight = $(this).attr('total_weight');
var total_cbf = $(this).attr('total_cbf');
var mat_uom = $(this).attr('mat_uom');
var uomid = $(this).attr('uomid');
var standard_packing = $(this).attr('standard_packing');

var main_img_path = $(this).attr('main_img_path');
var parent_id = $(this).attr('parent_id');
var valid = true;
$(".account_index .dynamic").each(function() {
if($(this).find(":selected").val() == ''){
valid = false;
return false;
}
});
if (valid) {
$('#'+parent_id).find('.set_mat_name').html('<option value="'+mat_id+'">'+mat_name+'</option>');
$('#'+parent_id).find('.mat_sales_price').val(mat_sales_price);
$('#'+parent_id).find('.mat_tax').val(mat_tax);
$('#'+parent_id).find('.mat_uom').val(mat_uom);
$('#'+parent_id).find('.uomid').val(uomid);
$('#'+parent_id).find('.BOXQTY').val(0);
$('#'+parent_id).find('.standard_packingCls').val(standard_packing);
$('#'+parent_id).find('.Product_Image').html('<img style="width: 50px; height: 50px;" src="'+main_img_path+'"><input type="hidden" name="pro_img[]" value="'+main_img_path+'">');
var quantity = $('#'+parent_id).find('.quantity').val();
var mat_total = quantity*mat_sales_price;
var pi_cbf = $('#pi_cbf').val();
var pi_weight = $('#pi_weight').val();
$('#'+parent_id).find('.total').val(mat_total);
if(quantity == ''){
$('#'+parent_id).find('.total_cbf').val(total_cbf);
$('#'+parent_id).find('.total_weight').val(total_weight);
var quantity1 = 0;
} else {
$('#'+parent_id).find('.total_cbf').val(total_cbf);
$('#'+parent_id).find('.total_weight').val(total_weight);
var quantity1 = quantity;
}
var total_cbf_cal = 0;
$(".total_cbf").each(function (key, value) {
total_cbf_cal += parseFloat(quantity1) * parseFloat($(value).val());
});
var total_weight_cal = 0;
$(".total_weight").each(function (key, value) {
total_weight_cal += parseFloat(quantity1) * parseFloat($(value).val());
});
//var set_cbf = parseFloat(total_cbf_cal)+parseFloat(mat_total_cbf);
//var set_weight = parseFloat(pi_weight)+parseFloat(mat_total_weight);
$('#pi_cbf').val(total_cbf_cal.toFixed(2));
$('#pi_weight').val(total_weight_cal.toFixed(2));
$('#variant_List').modal('hide');
$(this).attr('mat_name', '');
$(this).attr('mat_id', '');
$(this).attr('mat_sales_price', '');
$(this).attr('mat_tax', '');
$(this).attr('mat_uom', '');
$(this).attr('uomid', '');
$(this).attr('total_weight', '');
$(this).attr('total_cbf', '');
setTimeout(function(){
$('body').addClass('modal-open');
}, 700);
} else {
alert('Please fill all variant options');	
}
});
	$(document).on('click', '.calcDiscount', function(){
	
		//if( $(this).is(":checked") ){ 

			
				// var calcDiscount_val = $(this).val();
				var calcDiscount_val = $("input[type=radio][name=load_type]:checked").val();
			
		 // alert(calcDiscount_val);
		var customerName = $( ".customerName option:selected" ).val();

		if(calcDiscount_val == 'none'){
			$('#discount_rate').val('0');
			$('.disRate').text( '( 0 )');
					var discount_rate = 0;
					var total = $(".divSubTotal").text();
						if(isNaN(total) || total ==''){
									 total = 0;
								} else {
									 total = $(".divSubTotal").text();
								}  
				var discount_value = total*(discount_rate/100);
				var special_discount = $(".special_discount").val();
				var freightCharges = $(".divFreightCharge").text();
					if(isNaN(freightCharges) || freightCharges ==''){
								 freightCharges = 0;
							} else {
								 freightCharges = $(".divFreightCharge").text();
							} 
						var gfc = $(".divGSTFreight").text();
						if(isNaN(gfc) || gfc ==''){
									 gfc = 0;
								} else {
									 gfc = $(".divGSTFreight").text();
								}
							var gst_set = $(".divTax").text();

							var advance_received = $(".divAdvancePaid").text();
									if(isNaN(advance_received) || advance_received ==''){
										 advance_received = 0;
									} else {
										 advance_received = $(".divAdvancePaid").text();
									}  
									var spd_value = total*(special_discount/100);

									var div_total = total - parseFloat(discount_value) - spd_value;



									var grand_total =   remain_balance='';

							if(freightCharges=='' && gfc=='' &&  advance_received==''){
							  grand_total = parseInt(div_total)+ parseInt(gst_set)+ parseInt(0)+ parseInt(0);
							   remain_balance = parseInt(grand_total)-parseInt(0 );
							}else{
								grand_total = parseInt(div_total)+ parseInt(gst_set)+ parseInt(freightCharges)+ parseInt(gfc);
								remain_balance = parseInt(grand_total)-parseInt(advance_received);
							}
 
					parseFloat($(".divSubTotal").text(total));
					parseFloat($(".divDiscountValue").text(discount_value));
					parseFloat($(".divSpecialDiscount").text(spd_value));
					parseFloat($(".divTotal").text(div_total));
					parseFloat($(".divTax").text(gst_set));
					parseFloat($(".divGrandTotal").text(grand_total));
					parseFloat($(".divBalance").text(remain_balance));
					//divGrandTotal
					parseFloat($(".grandTotal").val(grand_total));
				} else {
					$.ajax({
						type: "POST",
						url: site_url + 'crm/calcDiscount',
						data: {
							calcDiscount_val: calcDiscount_val,
							customerName:customerName
						},
							success: function (data) {
								// alert(data);
								// if(data != 'false'){
								$('#discount_rate').val(data);
								
									
									$('.disRate').text('( '+ data +' )');
								
								var discount_rate = data;
								var total = $(".divSubTotal").text();

							// alert(discount_rate);
								// alert(data);
								

							var discount_value = total*(discount_rate/100);


							var special_discount = $(".special_discount").val();

							var freightCharges = $(".divFreightCharge").text();

									if(isNaN(freightCharges) || freightCharges ==''){
										 freightCharges = 0;
									} else {
										 freightCharges = $(".divFreightCharge").text();
									} 

							var gfc = $(".divGSTFreight").text();
							if(isNaN(gfc) || gfc ==''){
										 gfc = 0;
									} else {
										 gfc = $(".divGSTFreight").text();
									} 

							var gst_set = $(".divTax").text();
							
							

							// var advance_received = $(".divAdvancePaid").text();
							var advance_received = $(".divAdvancePaid").text();
									if(isNaN(advance_received) || advance_received ==''){
										 advance_received = 0;
									} else {
										 advance_received = $(".divAdvancePaid").text();
									}  
							var spd_value = total*(special_discount/100);
							var div_total = total - parseFloat(discount_value) - spd_value;
							// var grand_total = parseInt(div_total)+parseInt(gst_set)+parseInt(freightCharges)+parseInt(gfc);
							// var remain_balance = parseInt(grand_total)-parseInt(advance_received);
							var grand_total=   remain_balance='';

							if(freightCharges=='' && gfc=='' &&  advance_received==''){
							  grand_total = parseInt(div_total)+ parseInt(gst_set)+ parseInt(0)+ parseInt(0);
							   remain_balance = parseInt(grand_total)-parseInt(0 );
							}else{
								grand_total = parseInt(div_total)+ parseInt(gst_set)+ parseInt(freightCharges)+ parseInt(gfc);
								remain_balance = parseInt(grand_total)-parseInt(advance_received);
							}



							parseFloat($(".divSubTotal").text(total));
							parseFloat($(".divDiscountValue").text(discount_value));
							parseFloat($(".divSpecialDiscount").text(spd_value));
							parseFloat($(".divTotal").text(div_total));
							parseFloat($(".divTax").text(gst_set));
							parseFloat($(".divGrandTotal").text(grand_total));
							parseFloat($(".divBalance").text(remain_balance));

							parseFloat($(".grandTotal").val(grand_total));
							// }else{
								// alert("Please select customer name First !");
							// }
								}
							});	
				}
		//}	
	});

	function AdvancePayment(evt, t) {
		var val = $(t).val();
		var grandTotal = $('.divGrandTotal').text();
		
		var ExtraCharge = $('.extraChargesVal').text();
		
		if(ExtraCharge != 0 || ExtraCharge != ''){
			var grandTotal = $('.divGrandTotal').text();
			 grandTotal =   parseFloat(ExtraCharge) + parseFloat(grandTotal);
		}
		// console.log('grandTotal====>',grandTotal);
		var remain_balance = parseFloat(grandTotal)-parseFloat(val);
		parseFloat($(".divAdvancePaid").text(val));
		parseFloat($(".divBalance").text(parseFloat(remain_balance).toFixed(2)));
	}
	
	function ExtraCharges(evt, t) {
		var val = $(t).val();
		if(val == ''){
			val = 0;
			$('#extra_charges').val(0);
		}
		// 
		var grandTotal = $('.divGrandTotal').text();
		var AdvancePaid = $('.divAdvancePaid').text();
		
		// if(AdvancePaid != 0 || AdvancePaid != ''){
			// var grandTotal = $('.divBalance').text();
			 // grandTotal =   AdvancePaid - grandTotal;
		// }
		
	
		
		var remain_balance = parseFloat(grandTotal)+ parseFloat(val);
		parseFloat($(".extraChargesVal").text(val));
		parseFloat($(".divBalance").text(Math.abs(parseFloat(remain_balance).toFixed(2))));
	}

		function SpecialDiscount(evt, t) {
			//var special_discount = $(t).val();
			//alert(special_discount);
			if($(t).val() != '' || $("#special_discount").val() != ''){
				$("#sda_by").show();
				var special_discount = $("#special_discount").val();
			} else {
				$("#sda_by").hide();	
			}
			//alert(special_discount);
			if($(".divSubTotal").text() != ''){
				var total = $(".divSubTotal").text();
			} else {
				var total = '0';	
			}
			
			if($(".divDiscountValue").text() != ''){
				var discount_value = $(".divDiscountValue").text();
			} else {
					var discount_value = '0';
			}
				var freightCharges = $(".divFreightCharge").text();
			// var gfc = $(".divGSTFreight").text();
			if($(".divGSTFreight").text() != ''){
				var gfc = $(".divGSTFreight").text();
			} else {
				var gfc = 0;	
			}
			
			
			if($(".divTax").text() != ''){
				var gst_set = $(".divTax").text();
			} else {
				var gst_set = 0;	
			}
			
			if($(".divAdvancePaid").text() != ''){
				var advance_received = $(".divAdvancePaid").text();
			} else {
				var advance_received = '0';	
			}
			
			if($(".extraChargesVal").text() != ''){
				var extraCharges = $(".extraChargesVal").text();
			} else {
				var extraCharges = '0';	
			}
			
			
			
			
			var spd_value = total*(special_discount/100);
			var div_total = total - discount_value - spd_value;
			
			if(discount_value != 0){
				
				
					var divSubTotal = $(".divSubTotal").text();
					var divDiscountValue = $(".divDiscountValue").text();
					var DiscountAmount = divSubTotal - divDiscountValue;
					var spd_value = DiscountAmount*(special_discount/100);
					
				
				
				var div_total = DiscountAmount - spd_value;
				
					
			
			var gstval = 0;
					$(".gst").each(function (key, value) {
						gstval = parseFloat($(value).val());
						 gst_set = div_total*(gstval/100);
					});
					
			}
			
			
			
			
			
			
			
			
			if(isNaN($('.freight_charges').val()) || $('.freight_charges').val() ==''){
				  var freightCharges = 0;
				} else {
				 var freightCharges = $('.freight_charges').val();
				} 
			/* 09-03 Start Testing issue */
			// var grand_total = parseInt(div_total)+parseInt(gst_set);
			
			var grand_total = parseFloat(div_total)+parseFloat(gst_set)+parseFloat(freightCharges)+parseInt(gfc);
			var remain_balance = parseInt(grand_total)- parseInt(advance_received);
			var remain_balance = parseInt(remain_balance)+ parseInt(extraCharges);
			/* 09-03 End Testing issue */
			parseFloat($(".divSpecialDiscount").text(parseFloat(spd_value).toFixed(2)));
			parseFloat($(".divTotal").text(parseFloat(div_total).toFixed(2)));
			parseFloat($(".divTax").text(parseFloat(gst_set).toFixed(2)));
			parseFloat($(".divGrandTotal").text(parseFloat(grand_total).toFixed(2)));
			parseFloat($(".divBalance").text(parseFloat(remain_balance).toFixed(2)));
			/* 08-02-2022 Start add value */
			parseFloat($(".grandTotal").val(grand_total));
			/* 08-02-2022 End add value */
			
			
			
			
			
			
			
			
		}	
		

$(document).on('keyup', '.freight_charges', function(){
	if(isNaN($(this).val()) || $(this).val() ==''){
	  var freightCharges = 0;
	} else {
	 var freightCharges = $(this).val();
	}   
	var total = $(".divSubTotal").text();
	var discount_value = $(".divDiscountValue").text();
	var special_discount = $("#special_discount").val();
	
	
	
	
	
	var gfc = parseFloat(freightCharges)*18/100;
	var gst_set = $(".divTax").text();
	 var advance_received = $(".divAdvancePaid").text();
		if(isNaN(advance_received) || advance_received ==''){
			 advance_received = 0;
		} else {
			 advance_received = $(".divAdvancePaid").text();
		}  
	var spd_value = total*(special_discount/100);
	var div_total = total - parseFloat(discount_value) - spd_value;
	
	// if(discount_value != 0){
		// var spd_value = discount_value*(special_discount/100);
		// var div_total = discount_value - spd_value;
		// var gstval = 0;
			// $(".gst").each(function (key, value) {
				// gstval = parseFloat($(value).val());
				 // gst_set = div_total*(gstval/100);
			// });
	// }      
	
	if(discount_value != 0){
		var divSubTotal = $(".divSubTotal").text();
		var divDiscountValue = $(".divDiscountValue").text();
		var DiscountAmount = divSubTotal - divDiscountValue;
		var spd_value = DiscountAmount*(special_discount/100);
		var div_total = DiscountAmount - spd_value;
		var gstval = 0;
			$(".gst").each(function (key, value) {
				gstval = parseFloat($(value).val());
				 gst_set = div_total*(gstval/100);
			});
	}
	

	var grand_total = parseFloat(div_total)+parseFloat(gst_set)+parseFloat(freightCharges)+parseInt(gfc);
	
 
	var remain_balance = parseFloat(grand_total)-parseFloat(advance_received);
	
	parseFloat($(".divFreightCharge").text(freightCharges));
	parseFloat($(".divGSTFreight").text(gfc));
	parseFloat($(".divTotal").text(div_total));
	parseFloat($(".divGrandTotal").text(grand_total));
	parseFloat($(".divBalance").text(remain_balance));

	parseFloat($(".grandTotal").val(grand_total));
	
});

function showPermittedBy(evt, t) {
$(".pi_paymode_list input:checked").each(function() {
var check_value = $(this).val();
if(check_value == "Credit"){
$("#permitted_by").css('display', 'block');
} else {
$("#permitted_by").css('display', 'none');	
}
if(check_value == "Cash" || check_value == "Credit Card" || check_value == "Online Transfer" || check_value == "Debit Card" || check_value == "Cheque"){
$("#remarks_by").css('display', 'block');
} else {	
$("#remarks_by").css('display', 'none');	
}
});	
}

// Sale order by Accounts Print Function 10-03-2022
function printDataSleOdrAccnt()
{
	  $('.pagination').hide();
	  $('.dataTables_info').hide();
	  $('.dataTables_length').hide();
	  $('.dataTables_filter').hide();
	  $('.hidde').hide();
	  $('.btn-group').hide();
   var divToPrint=document.getElementById("saleOrdAccnt");
	newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
    location.reload();

}

$('#bbtnBtnSaleAccount').on('click',function(){
	printDataSleOdrAccnt();
 })
 
 
 
 $(document).on("click",".sharevia_email_cls",function(){
	$('#myModal_share_email').modal('show');
});

$(document).on("click",".close_sec_model",function(){
	 $('#myModal_share_email').modal('hide');
});
/* Share Via email Script*/
$(document).on("click","#share_via_Email",function(){	
		var share_email  = $('#email_name').val();
		var order_id  = $('.order_id').val();
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
				   url: site_url+'crm/share_pdf_using_email/',
				   data: {share_email:share_email,order_id:order_id,email_msg_id:email_msg_id}, 
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
 
 

  

 

 
 