/*global varibale for cost price sales price in evaluation*/
var cp = [];
var id = [];
var sp = [];
/************************************************Open modals ***********************************************/
 $(document).on("click", ".createIndentreorder", function(ev) {
	
        
    ev.preventDefault();
    var id = $(this).attr('id');
	var tab = $(this).attr('data-id');
	 var url = '';
	 
        switch (tab) {
            case 'indentEdit':
                url = 'inventory/indent_edit';
                break;
		}
		
        if(tab == 'indentEdit'){
        var ajaxData = {
                id:id,
                data_set :$(this).attr('data-set'),
            };
        } else {
            var ajaxData = {
                id:id,
            };
        }
		  $.ajax({
            type: "POST",
            url: site_url + url,
            data: ajaxData,
            success: function(data) {
             if (data != '') {
				 if (tab == 'indentEdit') {
						$('#ReorderLevelPI_modal').modal('show');
						$('#ReorderLevelPI_modal .modal-body-content').html(data);
					 }
					 if(tab =='indentEdit' ){
						 
                      IndentAddMoreMaterial();
                      keyupFunctionreorderPI();
					  init_select2();
					$('#req_date').datepicker({ 
								//startDate: date,
								format: "dd-mm-yyyy",
								autoclose: true
							});
						$('#req_date').on('changeDate', function (e) {
							$('.req_date').closest('.item').removeClass('bad');
						});					  
					  
                    }
					}	
				}
			});
		});
		
		
		
$(document).ready(function(){
  $(document).on("click",".inventory_tabs",function(ev){
	ev.preventDefault();
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		//console.log("id--->s",id);
		//console.log("data-id",tab);
		var url = '';
		
		switch (tab) {
			
            
			case 'editMaterial':
				url = 'inventory/material_edit';
				break;	 
			case 'material_view':
				url = 'inventory/material_view';
				break; 
			case 'editInventorylisting':
				url = 'inventory/inventory_listing_edit';
				break;	
			case 'ViewInventorylisting':
				url = 'inventory/inventory_listing_view';
				break;	
			case 'editLocation':
				url = 'inventory/location_setting_edit';
				break;
			case 'location_view':
				url = 'inventory/location_setting_view';
				break;	
			case 'editMaterialType':
				url = 'inventory/material_type_edit';
				break;
			case 'editMaterialWIP':
				url = 'inventory/work_in_process_edit';
				break;
			case 'editMaterialFinishGoods':
				url = 'inventory/finish_goods_edit';
				break;	
			case 'finish_goods':
				url = 'inventory/finish_goods_edit';
				break;
		 
            case 'work_in_process_edit_one':
				url = 'inventory/work_in_process_edit_one';
				break;
            case 'work_in_processwork_in_processID':
				url = 'inventory/work_in_processwork_in_processID';
				break;
			case 'work_in_process':
				url = 'inventory/work_in_process_edit';
				break;
			case 'work_in_processMatView':
				url = 'inventory/work_in_processMatView';
				break;	
			case 'inventory_adjustmentListing_view':
				url = 'inventory/inventory_adjustmentListing_view';
				break;
			case 'inventory_adjustmentListingLocationView':
				url = 'inventory/inventory_adjustmentListingLocationView';
				break;	
			case 'inventory_uom_type':
				url = 'inventory/uom_list_edit';
				break;
			case 'convert_to_pi_through_mrp':
				url = 'inventory/convert_to_pi_through_MRP';
				break;		
			case 'acknowledgedate':
				url = 'inventory/aknowledge/';
				break;
			case 'fg_acknowledgedate':
				url = 'inventory/fg_aknowledge/';
				break;
			case 'reorder_level_report':
				url = 'inventory/generate_reorder_level_report';
				break; 
			case 'convert_to_pi':
				url = 'inventory/convert_to_purchase_indent';
				break;
			case 'MrpReportAdd':
				url = 'inventory/mrp_reportadd';
				break;
			case 'edit_monthlymrp':
			url = 'inventory/edit_monthly_mrp';
			break;
			case 'view_monthlymrp':
			url = 'inventory/view_mrp';
			break;
			case 'inventory_reportsettings':
			url = 'inventory/editinventoryreportsetting';
			break;
			case 'editlotmanagement':
			url = 'inventory/editlotmanagement';
			break;
			case 'wip_dispatch':
				url = 'inventory/wip_dispatch/';
				break;
		case 'wip_requestMatDetail':
				url = 'inventory/wip_requestMatDetail/';
				break;
		case 'view_wip':
			url = 'inventory/view_wip/';
			break;
		case 'fg_view':
			url = 'inventory/fg_view/';
			break;
		case 'fg_Matview':
			url = 'inventory/fg_Matview/';
			break;
		case 'tag_type_edit':
			url = 'inventory/tag_type_edit/';
			break;
		case 'tag_details_edit':
			url = 'inventory/tag_details_edit/';
			break;
		case 'reservedmaterial':
			url = 'inventory/edit_reservedmaterial/';
			break;
		case 'material_Locationview':
			url = 'inventory/material_Locationview/';
			break;

		case 'editvarienttype':
			url = 'inventory/editVariantType/';
			break;

		case 'editvarientoption':
			url = 'inventory/editVariantOption/';
			break;

		case 'converttoinventory':
			url = 'inventory/convertToInventory/';
			break;
			
		}
		
		if(tab == 'editMaterialWIP'){
		    $('.modalName').html('Work In Process');
		}else{
			$('.modalName').html('Received Finish Goods');
		}
		if (tab == "reorder_level_report") {
			$('.modalName').html('Purchase Indent');
		}
		if(tab == 'editLocation'){
		    $('.modalName').html('Location Setting');
		}
		if(tab == 'editlotmanagement'){
		    $('.modalName').html('Edit Lot Management');
		}
		if(tab == 'editvarienttype'){
		    $('.modalName').html('Edit Varient Type');
		}
		if(tab == 'editvarientoption'){
		    $('.modalName').html('Edit Varient Option');
		}
		if(tab == 'converttoinventory'){
		    $('.modalName').html('Convert To Inventory');
		}
		
		 
		
		
	
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){
				
				if(data != '') {
					
					
					
					if($('#inventory_add_modal').length){
						$('#inventory_add_modal').modal('show');
						$('#inventory_add_modal .modal-body-content').html(data);
					}else{
						$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
					
								
					if(tab =='editMaterial'){
						uom();
						uploadImage();
						ChangePrefix_and_subType();
						addLocation();
						addImages();
						getArea();
						addMultipleLocationInMaterial();
						tags();
						getQtyValue();
						close_modal_Script();
						//check_mat_location_add_edit_mat();
						init_select_forAdd_uom();
						init_select2();		
					}else if(tab =='editInventorylisting'){
						getMaterials();
						popupForms_onAction();	
						//addMoreProduct();
					}else if (tab == 'editLocation'){
						addLocation();
						getAddress();
						addArea();					
					}else if (tab == 'editMaterialWIP'){
						getMaterialName();	
						getVarientOption();			
						getMaterialOfWorkOrder();
						addMoreIssueMaterial();
						addmoredataRM();
						getUom();
						getlot();
						keyup_function_to_check_qty();
					 }else if (tab == 'work_in_process'){
						getMaterialName();
						getVarientOption();
						getMaterialOfWorkOrder();
						addMoreIssueMaterial();
						addmoredataRM();
						getUom();
						getlot();
						keyup_function_to_check_qty();
                        validateActionsInInventoryListing();
						init_select2();
						init_select221(); 
						addMaterialDetail();
						dateFunction();
						getUOMinmaterialconvrs();
						addLocationInConversion();
						getQuantityinconversion();
						addMoreProductincoversion();										
						getArea();
						getAddressData();
						init_selectlot();
						function_to_check_qty_in_listing();
						getMaterialQuantites();
						on_change_Work_order(); 
					 }
					 else if (tab == 'work_in_process_edit_one'){
						getMaterialName();
						getVarientOption();
						getMaterialOfWorkOrder();
						addMoreIssueMaterial();
						addmoredataRM();
						getUom();
						getlot();
						keyup_function_to_check_qty();
                        validateActionsInInventoryListing();
						init_select2();
						init_select221(); 
						addMaterialDetail();
						dateFunction();
						getUOMinmaterialconvrs();
						addLocationInConversion();
						getQuantityinconversion();
						addMoreProductincoversion();										
						getArea();
						getAddressData();
						init_selectlot();
						function_to_check_qty_in_listing();
						getMaterialQuantites();
						on_change_Work_order(); 
                   }
					 else if(tab == 'wip_dispatch'){
					 	getMaterialName();
					 	getVarientOption();
						getMaterialOfWorkOrder();
						addMoreIssueMaterial();
						addmoredataRM();
						getUom();
						getlot();
						keyup_function_to_check_qty();
						//Autoload location based area
						$(".well").each(function(){		
							var closestId = $(this).attr('id');							
							var material_type_id = $('#'+closestId).find('.material_type_id').val();
							var materialId = $('#'+closestId).find('.mat_name').val();
							var locationId = $('#'+closestId).find('.location').val();
							if(locationId != '' && typeof(locationId) != 'undefined'){
								autoGetArea2(closestId,material_type_id,materialId,locationId)
							}							
						});
						var dtToday = new Date();
							    
							    var month = dtToday.getMonth() + 1;
							    var day = dtToday.getDate();
							    var year = dtToday.getFullYear();
							    if(month < 10)
							        month = '0' + month.toString();
							    if(day < 10)
							        day = '0' + day.toString();
							    
							    var maxDate = year + '-' + month + '-' + day;
							    $('#acknowledge').val(maxDate);
					 }
					
					 else if (tab == 'finish_goods'){
						//GetTotalValue();
						//ChangePrefix();
						//addmore_finish_goods();
						addmore_finish_workorder();
						getScrapUom();
					 }else if (tab == 'editMaterialFinishGoods'){
						GetTotalValue();
						//ChangePrefix();
						addmore_finish_goods();
					}
					else if (tab == 'editMaterialType'){
						prefix();	
						addSubType();
						$('#myModalLabel').html('Add Product Type');
					
						
						
						
					}
					else if(tab == 'reorder_level_report'){
						keyupFunc();
						remove_calculation_purchase_indent();
						Grandtotal();
						getDept();
						getAddress1();
						IndentAddMoreMaterial();
					}
					else if(tab == 'MrpReportAdd'){
						GetMonthlyProductionData();
						Print_data_new1();
						monthdt();
					}
					else if(tab == 'acknowledgedate'){
						 $(function(){
							    var dtToday = new Date();
							    
							    var month = dtToday.getMonth() + 1;
							    var day = dtToday.getDate();
							    var year = dtToday.getFullYear();
							    if(month < 10)
							        month = '0' + month.toString();
							    if(day < 10)
							        day = '0' + day.toString();
							    
							    var maxDate = year + '-' + month + '-' + day;
							    // or instead:
							    // var maxDate = dtToday.toISOString().substr(0, 10);
							    //alert(maxDate);
							    $('#acknowledge').attr('min', maxDate);
							});
					}
					else if(tab == 'reservedmaterial'){
						addcustomertypereserv();
					}
					else if(tab == 'inventory_adjustmentListing_view'){
						$(document).ready( function () {
    						$('#example084').DataTable();
						} );
						//addMoreProduct();
					}
					else if(tab == 'edit_monthlymrp'){
						GetMonthlyProductionData();
						Print_data_new1();
					}
					else if (tab == 'inventory_reportsettings'){
					
						ChangePrefix_and_subType();
						$('#myModalLabel').html('Inventory Report');
					} else if(tab == 'converttoinventory'){
					init_select2();
					init_select221();
					getArea();
					getlot();
					getQtyValue(); 
					init_selectlot();
					}
					if(tab == 'convert_to_pi'){
						   getAddress();
						   init_select2();
						 $('#req_date').datepicker({
							format: "dd-mm-yyyy",
							autoclose: true,
							orientation: "top",
						});
						$('#req_date').on('changeDate', function (e) {
							$('.req_date').closest('.item').removeClass('bad');
						});
						IndentAddMoreMaterial();
					}
					// else if ($tab == 'edit_monthlymrp') {
					// 	GetMonthlyProductionData();
					// }
					/*validation*/
					$('form')
					.on('blur', 'input[required], input.optional, select.required', validator.checkField)
					.on('change', 'select.required', validator.checkField)
					.on('keypress', 'input[required][pattern]', validator.keypress);
						$('form').submit(function(e) {
							e.preventDefault();
							var submit = true;
							if (!validator.checkAll($(this))) {
								submit = false;
							}
							 if (tab == 'MrpReportAdd') {
								submit = FORMVALIDATE(e);
							}
							if (submit)
								this.submit();
								return false;
						});
					
					init_select2();		
					
					init_select221();	
					init_select_forAdd_uom();
					getMaterialName();
					getVarientOption();
					getlot();
					
					//addMoreProduct();
					//addMultipleLocationInMaterial();
					//Print_data_new();					
				}
			}
		});
		
	});
});
$(document).ready(function() {   
    //Auto hide alert message  	
    setTimeout(function(){ 
       $('.alert-info').hide();
   }, 3000);  
   
   //fetch storage location based on address(location id) -- edit materials
	$(".location_id").each(function(){		
		var optionValue = $(this).val();
		var storage_loc = $(this).attr('data-storage');		
		var closestId = $(this).closest(".well").attr("id");		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: site_url + 'inventory/getLocationArea',
			data: {id:optionValue}, 
			success: function(data){
				if(data != ''){
					var optionData='<option value="">Select Option</option>';
					$.each(data, function(key, value) {	
						if(value.id == storage_loc){
							optionData +="<option value='"+value.id+"' selected>"+value.id+"</option>";
						}else{					
							optionData +="<option value='"+value.id+"'>"+value.id+"</option>";
						} 						
					});
					$("#"+closestId+"").closest(".well").find('.area').html(optionData);			
				}else{
					$("#"+closestId+"").closest(".well").find('.area').html('');
				}
			}
		}); 
	});
});
//delete location data based on location id -- edit materials
function delete_location(loc_id){	
	var cnfrm = confirm('Are you sure want to delete this location!');
	if(cnfrm != true)
	{
		return false;
	}
	else
	{			
		if (loc_id != '' || loc_id != undefined){											
			$.ajax({
				type: "POST",
				url: site_url + 'inventory/deleteMatLocation/',
				data: {
					id: loc_id,							
				},
				success: function (result) {
					if (result != '') {						
						var obj = JSON.parse(result);						
						if (obj.status == 'success') {						
							$('#'+loc_id).parent('div').remove();
						}
					}
				}
			});			
		}	
		return true;				
	}	
}
addMoretypeoftagtypes();
				$(document).ready(function(e) {
					//addMoreProductincoversion();
					
						uom();
						uploadImage();
						//addMoreProduct();
						addLocation();
						addImages();
						getArea();
						addMultipleLocationInMaterial();
						tags();
						
						close_modal_Script();
						
						init_select_forAdd_uom();
						init_select2();	
						check_mat_location_add_edit_mat();
						getTax();
						ChangePrefix_and_subType();
						getQtyValue();
						// dateFunction();
						// showFreight();
						 getAddress();
						 PurchaseAddMaterial();
						// getTax();
						// starRating();
						 keyupFunction();
						// IdProof();
						// add_more_charges_details();
						// get_state_id_onselect();
						// PoEditTbl();
						// poaddCharges();
						// add_charges_on_purchase();
						// //selectTwo();
						// init_select_forAdd_suplier();
						// remove_mat_during_edit();		
						 addMoredocuments();
						// close_modal_Script();
						// add_remove_fields_onclick();
						// getProcess();
						 getAccountDetails();
						// //addMoreProduct();
						 addmorepro_piso();
					 addMoreChatterAttachments();
						// dateFunction();
						// getAddress();
						 keyupFunctioncrm();
						 	init_select212();
						 	Print_data_new1()
						// activityDateRangeSelector();
						init_selectlot();
						validateActionsInInventoryListing();
						init_select2();
						init_select221();
						getMaterialName();
						getVarientOption();
						addMaterialDetail();
						dateFunction();
						getUOMinmaterialconvrs();
						addLocationInConversion();
						//getQuantityinconversion();
						addMoreProductincoversion();
				});
function keyupFunctioncrm(evt, t) {
	var closestId = $(t).closest(".well").attr("id");
	var qty = $("#" + closestId + " input[name='qty[]'").val();
	var price = $("#" + closestId + " input[name='price[]'").val();
	var gst = $("#" + closestId + " input[name='gst[]'").val();
	var individual_Total = parseFloat(qty) * parseFloat(price);
	if (isNaN(individual_Total)) {
		var individual_Total = 0;
	}
	var individualTotal_withdecimal = individual_Total.toFixed(2);
	//console.log("individualTotal_decimal",individualTotal_decimal);
	var individual_TaxPrice = (individual_Total * gst) / 100;
	//console.log("individualTaxPrice",individualTaxPrice);
	var individualPrice_WithGstTotal = individual_Total + individual_TaxPrice;
	if (isNaN(individualPrice_WithGstTotal)) {
		var individualPrice_WithGstTotal = 0;
	}
	//console.log('individualPriceWithGstTotal1',individualPriceWithGstTotal);
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
	var grandTotal = 0;
	$(".totalWithGst").each(function (key, value) {
		console.log("ffff", value);
		console.log("key", key);
		grandTotal = parseFloat(grandTotal) + parseFloat($(value).val());
	});
	if (isNaN(grandTotal)) {
		var grandTotal = 0;
	}
	console.log("dddtotal", grandTotal);
	if ($("input[name='agt']").length && $("input[name='agt']").val() != '') {
		grandTotal = grandTotal + parseFloat($("input[name='agt'").val());
	}
	parseFloat($("input[name='total'").val(total));
	parseFloat($("input[name='grandTotal'").val(grandTotal));
	//$("#grand_total").val(grandTotal.toFixed(2));
	//$("#totalwithoutgst").val(total.toFixed(2));
	parseFloat($(".divSubTotal").text(total));
	parseFloat($(".divTotal").text(grandTotal));
	var grand_total_val = $("[name='total']").val();
	if (grand_total_val > 0 || grand_total_val != '') {
		$(':input[type="submit"]').prop('disabled', false);
	}
}
function remove_calculation_quot_pi_so() {
	var grand_total_val = $("[name='total']").val();
	if (grand_total_val == 0 || grand_total_val == '') {
		$(':input[type="submit"]').prop('disabled', true);
	} else {
		$(':input[type="submit"]').prop('disabled', false);
	}
}
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
function keyupFunction(evt, t) {
	var closestId = $(t).closest(".well").attr("id");
	var qty = $("#" + closestId + " input[name='qty[]'").val();
	var price = $("#" + closestId + " input[name='price[]'").val();
	var gst = $("#" + closestId + " input[name='gst[]'").val();
	var individual_Total = parseFloat(qty) * parseFloat(price);
	if (isNaN(individual_Total)) {
		var individual_Total = 0;
	}
	var individualTotal_withdecimal = individual_Total.toFixed(2);
	//console.log("individualTotal_decimal",individualTotal_decimal);
	var individual_TaxPrice = (individual_Total * gst) / 100;
	//console.log("individualTaxPrice",individualTaxPrice);
	var individualPrice_WithGstTotal = individual_Total + individual_TaxPrice;
	if (isNaN(individualPrice_WithGstTotal)) {
		var individualPrice_WithGstTotal = 0;
	}
	//console.log('individualPriceWithGstTotal1',individualPriceWithGstTotal);
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
	var grandTotal = 0;
	$(".totalWithGst").each(function (key, value) {
		console.log("ffff", value);
		console.log("key", key);
		grandTotal = parseFloat(grandTotal) + parseFloat($(value).val());
	});
	if (isNaN(grandTotal)) {
		var grandTotal = 0;
	}
	console.log("dddtotal", grandTotal);
	if ($("input[name='agt']").length && $("input[name='agt']").val() != '') {
		grandTotal = grandTotal + parseFloat($("input[name='agt'").val());
	}
	parseFloat($("input[name='total'").val(total));
	parseFloat($("input[name='grandTotal'").val(grandTotal));
	//$("#grand_total").val(grandTotal.toFixed(2));
	//$("#totalwithoutgst").val(total.toFixed(2));
	parseFloat($(".divSubTotal").text(total));
	parseFloat($(".divTotal").text(grandTotal));
	var grand_total_val = $("[name='total']").val();
	if (grand_total_val > 0 || grand_total_val != '') {
		$(':input[type="submit"]').prop('disabled', false);
	}
}
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
function addmorepro_piso() {
	var maximum = 10; //maximum input boxes allowed
	var wrap_material = $(".input_productre"); //Fields wrapper
	var button_add = $(".addProductButtonre"); //Add button ID
	var x = 1; //initlal text box count	
	$(button_add).click(function (e) {
		//on add input button click
		e.preventDefault();
		if (x < maximum) { //max input box allowed
			x++;
			//var dataWhere = $("#material").attr("data-where");
			$(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_' + x + '"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label >Material Name  <span class="required">*</span></label>	<select class="form-control selectAjaxOption select2 materialNameId Add_mat_onthe_spot" required="required" name="product[]" onchange="getTaxcrm(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"><label class="col-md-12">Description</label><textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12" >Quantity</label><input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity"  onkeyup="keyupFunctioncrm(event,this)"  onchange="keyupFunctioncrm(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">UOM</label><input type="text" name="uom1[]"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom" readonly><input type="hidden" name="uom[]" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Price</label><input type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12 price " onkeyup="keyupFunctioncrm(event,this)"  onchange="keyupFunctioncrm(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">GST</label><input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Total</label><input type="text" name="totals[]" class="form-control col-md-7 col-xs-12 total has-feedback-left" value="" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label  class="col-md-12">GST Total</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst has-feedback-left" value="" readonly></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');
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
function getAccountDetails() {
	$("#account_id").on("select2:select", function (e) {
		$("#contact_id").empty();
		var selectAccountVal = $(e.currentTarget).val();
		var whereContactContact = "account_id='" + selectAccountVal + "'";
		$("#contact_id").attr("data-where", whereContactContact);
		$.ajax({
			url: site_url + 'inventory/getAccountDataById/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: selectAccountVal,
			},
			success: function (result) {
				 $('.invoice_no').html(result);
				//  $.ajax({
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
				// 			$('#address123').html(address);
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
function getSupplierAddress(evt, t){
	var option = $(t).find('option:selected');
	var supplierId = option.val();
	$.ajax({
		type: "POST",
		url: site_url + 'purchase/getSupplierAddressId',
		data: {id:supplierId}, 
		success: function(data){
			if(data != '') {
				var dataObj =JSON.parse(data);			
				$("#address").val(dataObj.address);
			}
		}
	}); 		 
}
function getProcess() {
	 var logged_user = $('#company_login_id').val();
	 $('.get_process_name').on('change', function() {
		 //$('#process_name_id').html('');
         var jobcard_select_this =  $(this);		 
		  var selected_jobcard = $(this).val();
		  $.ajax({
				   type: "POST",
				   url: site_url+'purchase/get_process_type/',
				   data: { jobcard_id:selected_jobcard}, 
				   success: function(result) {
					$(jobcard_select_this).closest('.well').find('select[name="process_name[]"]').html('');   
					$(jobcard_select_this).closest('.well').find('select[name="process_name[]"]').append(result);
					}
			 });   
		});
	}
function add_remove_fields_onclick(){
		$("#outsource_btn").on("click", function() {
		   if ($("#outsource_btn").is(':checked')){
				$('.totl_amt').addClass('col-md-1');
				$(".show_cls").show();
			}else{
				$('.totl_amt').removeClass('col-md-1');
				$('.totl_amt').addClass('col-md-2');
				$(".show_cls").hide();
				$(".get_process_name  option[value='']").prop('selected', false);
				$("#process_name_id option[value='']").prop('selected', false);
			}
		});
	}
function close_modal_Script(){
	$('.close_modal2').click(function(){
	 setTimeout(function(){
		 //mycomment	
	   $("body").removeClass("modal-open");
	   }, 1000);
	});
}
function addMoredocuments(){
	var maxfields      = 5; //maximum input boxes allowed
	var wrap         = $(".fields_wrap"); //Fields wrapper
	var add_btn      = $(".add_more_docs"); //Add button ID
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click
		e.preventDefault();
		if(y < maxfields){ //max input box allowed
			y++;
			$(wrap).append('<div class="item form-group"><div class="col-md-9 col-sm-11 col-xs-12" style="padding-left: 0px;"><input type="file" class="form-control col-md-5 col-xs-5" name="docss[]"></div><button class="btn btn-danger rmv_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	});
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	});
}
function remove_mat_during_edit(){
	$(document).on("click",".remove_btn1",function(){
		var closestId = $(this).closest(".well").attr("id");
		$("#"+closestId+" input[name='quantity[]'").val('0');
		$("#"+closestId+" input[name='material_name[]'").val('');
		$(this).closest(".well").css("display", "none");
		keyupFunction(event,this);
	});
}
function init_select_forAdd_suplier() {
		$('.add_more_Supplier').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
       // placeholder: 'Material Name',
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
				//console.log('===>' + searched_value);
				 $('#preff_supp').val(searched_value);
				 $('#suppliername').val(searched_value);
				// var matID = $('.materialTypeId').val();                
                // $('#material_type_id').val(matID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_supliers'>Add </span>";
			  }
			//noResults: function() {
				//return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_supliers'>Add </span>";
			//}
			},escapeMarkup: function (markup) {
				 return markup;
			}
    });
	
}
function add_charges_on_purchase(){
	
	$('.Add_charges_id').on('change',function(){
	//alert('11');	
			var charge_ldger_id = $(this).val();
			
			var matrial_select_this_val =  $(this);
			$(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val(''); 
		setTimeout(function(){
			$('.ad_rm_readonly').prop('disabled', false);
				$.ajax({
					   type: "POST",
					   url: site_url+'account/get_charges_details/',
					   data: { id:charge_ldger_id}, 
					   success: function(result) {
						   var obj = jQuery.parseJSON(result);
						 	 if(obj.type_charges == 'minus'){
										$(matrial_select_this_val).closest('.testDh').find(".aply_btn").html('<input type="button"  class="add_dis" value="Apply Discount">');
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").hide();
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").hide();
										
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
						  
						   if(obj.type_charges == 'plus'){
							// alert('dsfdfs');
						        $('#total_tax_slab').val(obj.tax_slab);//Add total_tax
								var sale_company_state_idd = $('#sale_company_state_id').val();
								var party_billing_state = $('#party_billing_state_id').val();
									if(party_billing_state != sale_company_state_idd){
										var taxslabb = obj.tax_slab;
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").val(taxslabb);
										
										$(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").show();
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
									}else{
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
										$(matrial_select_this_val).closest('.testDh').find(".for_discount_hide").show();
										$(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").show();
										$(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").show();
										$(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
										var taxslabb = obj.tax_slab;
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
function poaddCharges(){
 var row=1;
  $(document).on("click", "#add-row", function () {
  var new_row = `<tr><td class="pt-3-half" contenteditable="false"><select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half only-numbers" contenteditable></td><td class="pt-3-half only-numbers" contenteditable></td><td class="pt-3-half" contenteditable="true"></td><td><span class="table-remove"><a href="#!"  class="btn btn-delete btn-lg" >
<i class="fa fa-trash"></i></a></span></td></tr>`;
		  //console.log('new_row===>>>>',new_row);
   
  $('tbody').append(new_row);
  row++;
  return false;
  });
 }
function PoEditTbl(){
const $tableID = $('#table_edit');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');
 const newTr = `<tr><td class="pt-3-half" contenteditable="false"><select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></td><td class="pt-3-half" contenteditable></td><td class="pt-3-half only-numbers" contenteditable></td><td class="pt-3-half only-numbers" contenteditable></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half noeditable" contenteditable="false"></td><td class="pt-3-half only-numbers" contenteditable></td><td class="pt-3-half only-numbers" contenteditable></td><td class="pt-3-half" contenteditable="true"></td><td><span class="table-remove"><a href="#!"  class="btn btn-delete btn-lg" ><i class="fa fa-trash"></i></a></span></td></tr>`;
 $('.table_add').on('click', 'p', () => {
   const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');
   if ($tableID.find('tbody tr').length === 0) {
     $('tbody').append(newTr);
   }
   $tableID.find('table').append($clone);
 });  
 $tableID.on('click', '.table-remove', function () {
   $(this).parents('tr').detach();
 });
 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;
 $BTN.on('click', () => {
   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];
   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {
     headers.push($(this).text().toLowerCase());
   });
   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};
     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {
       h[header] = $td.eq(i).text();
     });
     data.push(h);
   });
   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });
}
function get_state_id_onselect(){
$('.get_state_id').on('change',function(){
	//alert('alerttt');
	 var seelected_val_Address = $(this).find(":selected").val();
	$.ajax({
			type: "POST",
			url: site_url+'purchase/get_state_on_dilivery_add/',
			data: {seelected_val_Address:seelected_val_Address}, 
			success: function(data){
				var trimStr = $.trim(data);
				$('#state_id22').val(trimStr);
				$('#party_billing_state_id').val(trimStr);
			}
	});	
	
});
//Tax calculation on during add Charges//
$('.charges_added').on('keyup', function() {
		var added_amount_val = $(this).val();
		
	    var matrial_select_this_val33 =  $(this);
		var totl_tax = $('#total_tax_slab').val();
		//alert(totl_tax);
		
		var total_tax_withAmount = totl_tax * added_amount_val/100;
		//console.log('added_amount_val===>>>',added_amount_val);
		//console.log('totl_tax===>>>',totl_tax);
		//console.log('total_tax_withAmount===>>>',total_tax_withAmount);
	
	setTimeout(function(){
		var addition_add = (+total_tax_withAmount) +  (+added_amount_val);
		//console.log('addition_add===>>>',addition_add);
			$(matrial_select_this_val33).closest('.testDh').find("input[name='amt_with_tax[]']").val(addition_add);
	}, 1000);
});
//Tax calculation on during add Charges//
}
function add_more_charges_details(){
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_charges_details"); //Fields wrapper
    var add_button      = $(".add_charges_detail_button"); //Add button ID
    var x = 1; //initlal text box count
	
    $(add_button).click(function(e){ //on add input button click
	    e.preventDefault();
			
			$('.ad_rm_readonly').prop('disabled', true);
			var company_login_id = $('#loggedUser').val();			
        if(x < max_fields){ //max input box allowed
            x++; 				
				//$(wrapper).append('<div class="col-md-12 input_charges_details charges_form" ><div class="testDh"><div class="col-md-2 item form-group"><select class="itemName form-control selectAjaxOption select2 Add_charges_id"  required="required" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid='+ company_login_id +' AND charges_for = 1" width="100%"><option value="">Select</option></select></div><div class="col-md-1 item form-group"><input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="" onkeypress="return float_validation(event, this.value)"><span class="aply_btn"></span><input type="hidden" value="" id="total_tax_slab"></div><div class="col-md-1 item form-group sgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt" name="sgst_amt[]" value="" readonly></div><div class="col-md-1 item form-group cgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" readonly ></div><div class="col-md-1 item form-group igst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]" value="" readonly ></div><div class="col-md-2 item form-group"><input type="text" class="form-control col-md-2 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="" readonly></div><button class="btn btn-danger remove_charges_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
				
				$(wrapper).append('<div class="col-md-12 input_charges_details charges_form" ><div class="testDh"><div class="col-md-2 item form-group"><select class="itemName form-control selectAjaxOption select2 Add_charges_id" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid='+ company_login_id +'" width="100%"><option value="">Select</option></select></div><div class="col-md-1 item form-group"><input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="" onkeypress="return float_validation(event, this.value)"><span class="aply_btn"></span><input type="hidden" value="" id="total_tax_slab"></div><div class="col-md-1 item form-group sgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt" name="sgst_amt[]" value="" readonly></div><div class="col-md-1 item form-group cgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" readonly ></div><div class="col-md-1 item form-group igst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]" value="" readonly ></div><div class="col-md-2 item form-group"><input type="text" class="form-control col-md-2 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="" readonly></div><button class="btn btn-danger remove_charges_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
				
				
				
				init_select2();
				
				get_state_id_onselect();
				add_charges_on_purchase();
				
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
function IdProof(){
	$("#proof").on('change', function () {
		if (typeof (FileReader) != "undefined") {
			var image_holder = $("#profile-holder");
			image_holder.empty();
			var reader = new FileReader();
			reader.onload = function (e) {
				$("<img />", { "src": e.target.result,"class": "", "height":"100px", "width":"100px"}).appendTo(image_holder);
			}
			image_holder.show();
			reader.readAsDataURL($(this)[0].files[0]);
		} else { 
			alert("This browser does not support FileReader."); 
		}
	});
}	
function remove_calculation_MRN(){
	
	var grand_total_val = $('#subttot').val();
		 if(grand_total_val == 0 || grand_total_val == ''){
			 $(':input[type="submit"]').prop('disabled', true);
		 }else{
			 $(':input[type="submit"]').prop('disabled', false);
		 }
	}			  
/* script for edit purchase order and purchase indent*/
function subtotal() {		
	var tot = 0
	$("input[name='total[]']").each(function(){
		tot += parseFloat($(this).val());
		//tot += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());
	});
	
	
	$("#subttot").val(tot)
		var frt = parseFloat($("input[name='freight'").val());
		if(isNaN(frt)) {
			var frt = 0;
		}
		
		var otherCharges = parseFloat($("input[name='other_charges'").val());
		if(isNaN(otherCharges)) {
			var otherCharges = 0;
		}
		
		var finvalue = parseFloat(frt) + parseFloat(tot) + parseFloat(otherCharges);
		if(isNaN(finvalue)) {
		var finvalue = 0;
		}
	$("#subttot").val(finvalue.toFixed(2));
	
	/******************display message for available budget AND spent budget**************/
	var getGrandTotal = $("#subttot").val();
	var getSelectedMaterialType = $('.material_type_id').find('option:selected').val();
	
	$.ajax({
			type: "POST",
			url: site_url + 'purchase/getBudgetByMaterialTypeId',
			data: {id:getSelectedMaterialType}, 
			success: function(data){
				if(data != '') {			
					var dataObj =JSON.parse(data);
					var budgetValue = dataObj.budget;
					var Total = dataObj.Total;
					if(Total == null){
					   var Total = 0;
					}
					if(parseInt(getGrandTotal) > parseInt(budgetValue)){
						
						$('.totalBudget').html("Available Budget = " + budgetValue);
						
						$('.budgetSpent').html("Budget Spent = " + Total);
						
						setTimeout(function() { 
							$('.totalBudget').html(''); 
							$('.budgetSpent').html(''); 
							// $('.totalBudget').addClass('display','none'); 
							// $('.budgetSpent').addClass('display','none'); 
							// $('.totalBudget').slideUp('slow').html('').removeAttr('display');
							// $('.budgetSpent').slideUp('slow').html('').removeAttr('display');
							// $('.totalBudget').css('display','block');
							// $('.budgetSpent').css('display','block');
						}, 5000); 
					}
				}
			}
		}); 	
	/*****************end of budget code**************************************/
	
}
/* Key up function for reorder Purchase*/
function keyupFunctionreorderPI(evt , t){
	var closestId = $(t).closest(".well").attr("id");
	// alert(closestId);
	
	var qty , price , gst_tax , sub_tax, amt ,grand_total, received_quantity,amt_p_bill,sub_tax_purchase , total_sub_tax_sub_total_purchase;
	qty = parseFloat($("#"+closestId+" input[name='quantity[]'").val());
	price = parseFloat($("#"+closestId+" input[name='price[]'").val());
	
	amt_p_bill = parseFloat(qty) * parseFloat(price);

	var amt_p_bill_Decimal = amt_p_bill.toFixed(2);
	$("#"+closestId+" input[name='total[]'").val(amt_p_bill_Decimal);
	if (($("#"+closestId+" input[name='received_quantity[]'").length > 0) && ($("#"+closestId+" input[name='received_quantity[]'").val() != '')){
		received_quantity = parseFloat($("#"+closestId+" input[name='received_quantity[]'").val());
		amt = received_quantity * price;
	}else{
		amt = parseFloat(qty) * parseFloat(price);
	}
	if(isNaN(amt)) amt = 0;
	var amt_Decimal = amt.toFixed(2);
	$("#"+closestId+" input[name='sub_total[]'").val(amt_Decimal);
	gst_tax = $("#"+closestId+" input[name='gst[]'").val();
	sub_tax= gst_tax * amt/100;	
	sub_tax_purchase = gst_tax * amt_p_bill/100;	
	total_sub_tax_sub_total_purchase =  sub_tax_purchase + amt_p_bill;	
	$("#"+closestId+" input[name='amount_with_tax[]'").val(total_sub_tax_sub_total_purchase);	
	var subtotal_amount_add_with_tax = 0
	$("input[name='amount_with_tax[]']").each(function(){
		subtotal_amount_add_with_tax += parseFloat($(this).val());	
	});		
	$('#total_amount_purchase').val(subtotal_amount_add_with_tax);	
	var total_taxxx = 0
	$("input[name='sub_tax[]']").each(function(){
		total_taxxx += parseFloat($(this).val());	
	});
	$('#total_tax').val(total_taxxx);
	$("#"+closestId+" input[name='sub_tax[]'").val(sub_tax);
	//total = parseFloat(sub_tax) + parseFloat(amt);
	//$("#"+closestId+" input[name='total[]'").val(total.toFixed(2));
	total = parseFloat($("input[name='grand_total'").val());
	var grndtototl = 0
	$("input[name='total[]']").each(function(){
		grndtototl += parseFloat($(this).val());	
	});
	$('#grandTotal').val(grndtototl);
	//grandTotal
	// alert(total);
	subtotal();
	remove_calculation_MRN();
}
/* Key up function for reorder Purchase*/


function keyupFunction(evt , t){
	var closestId = $(t).closest(".well").attr("id");
	
	var qty , price , gst_tax , sub_tax, amt ,grand_total, received_quantity,amt_p_bill,sub_tax_purchase , total_sub_tax_sub_total_purchase;
	qty = parseFloat($("#"+closestId+" input[name='quantity[]'").val());
	price = parseFloat($("#"+closestId+" input[name='price[]'").val());
	
	amt_p_bill = parseFloat(qty) * parseFloat(price);

	var amt_p_bill_Decimal = amt_p_bill.toFixed(2);
	$("#"+closestId+" input[name='sub_total_amt_purchse_bill[]'").val(amt_p_bill_Decimal);
	if (($("#"+closestId+" input[name='received_quantity[]'").length > 0) && ($("#"+closestId+" input[name='received_quantity[]'").val() != '')){
		received_quantity = parseFloat($("#"+closestId+" input[name='received_quantity[]'").val());
		amt = received_quantity * price;
	}else{
		amt = parseFloat(qty) * parseFloat(price);
	}
	if(isNaN(amt)) amt = 0;
	var amt_Decimal = amt.toFixed(2);
	$("#"+closestId+" input[name='sub_total[]'").val(amt_Decimal);
	gst_tax = $("#"+closestId+" input[name='gst[]'").val();
	sub_tax= gst_tax * amt/100;	
	sub_tax_purchase = gst_tax * amt_p_bill/100;	
	total_sub_tax_sub_total_purchase =  sub_tax_purchase + amt_p_bill;	
	$("#"+closestId+" input[name='amount_with_tax[]'").val(total_sub_tax_sub_total_purchase);	
	var subtotal_amount_add_with_tax = 0
	$("input[name='amount_with_tax[]']").each(function(){
		subtotal_amount_add_with_tax += parseFloat($(this).val());	
	});		
	$('#total_amount_purchase').val(subtotal_amount_add_with_tax);	
	var total_taxxx = 0
	$("input[name='sub_tax[]']").each(function(){
		total_taxxx += parseFloat($(this).val());	
	});
	$('#total_tax').val(total_taxxx);
	$("#"+closestId+" input[name='sub_tax[]'").val(sub_tax);
	total = parseFloat(sub_tax) + parseFloat(amt);
	$("#"+closestId+" input[name='total[]'").val(total.toFixed(2));
	total = parseFloat($("input[name='grand_total'").val());
	subtotal();
	remove_calculation_MRN();
}
function starRating(){
$(function() {
	$("div.star-rating > s, div.star-rating-rtl > s").on("click", function(e) {
	// remove all active classes first, needed if user clicks multiple times
	$(this).closest('div').find('.active').removeClass('active');	
	//$(e.target).parentsUntil("div").addClass('active'); // all elements up from the clicked one excluding self
	$(e.target).prevAll('s').addClass('active'); // all elements up from the clicked one excluding self	
	$(e.target).addClass('active');  // the element user has clicked on
	console.log('rrrrr=>>>', $(e.target).prevAll('s').length+1);
		//var numStars = $(e.target).parentsUntil("div").length+1;
		var numStars = $(e.target).prevAll('s').length+1;
		$('#hidden_rating').val(numStars);
		
		
	});
});
}
/*fetching tax value on material select*/
	function getTax(evt, t){
		var option = $(t).find('option:selected');	
		var materialId = option.val();
		var closestId = $(t).closest(".well").attr("id");
		console.log("closes",closestId);
		$.ajax({
			type: "POST",
			url: site_url + 'purchase/getMaterialDataById',
			data: {id:materialId}, 
			success: function(data){
			//console.log('datattttt======>>>>>>>>>>>>>',data);	
				if(data != '') {			
					var dataObj =JSON.parse(data);
					console.log("dataobj",dataObj);
				//	parseInt($("#"+closestId+" input[name='gst[]'").val(dataObj.tax));
					parseFloat($("#"+closestId+" input[name='gst[]'").val(dataObj.tax));
					parseFloat($("#"+closestId+" input[name='price[]'").val(dataObj.cost_price));
					parseFloat($("#"+closestId+" input[name='uom1[]'").val(dataObj.uom));
					parseFloat($("#"+closestId+" input[name='uom[]'").val(dataObj.uomid));
					//$("#"+closestId+"").find('.uom11').val(dataObj.uom);
          			//$("#"+closestId+"").find('.uomm').val(dataObj.uomid);
					//$("#"+closestId+"").find('.amount').val(dataObj.sales_price);
					//$("#"+closestId+"").find('.amount1').val(dataObj.cost_price);
					//parseInt($("#"+closestId+'"')find(".uom").val(dataObj.uom));
				}
			}
		}); 
		var tax = option.attr('data-tax');
		var uom = $(this).find('.option').val();
		var closestId = $(t).closest(".well").attr("id");
		//parseInt($("#"+closestId+" input[name='gst[]'").val(tax));
		parseFloat($("#"+closestId+" input[name='gst[]'").val(tax));
		 // parseInt($("#"+closestId+" input[name='gst[]'").val(tax));
		 
	}
function getTaxcrm(evt, t) {
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
				parseFloat($("#" + closestId + " input[name='price[]").val(dataObj.sales_price));
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
}
function PurchaseAddMaterial(){ 
	
		var maximum      = 10; //maximum input boxes allowed
		var wrap_material = $(".input_material"); //Fields wrapper
		var button_add    = $(".addButton"); //Add button ID
		var x = 1; //initlal text box count
		var logged_user = $('#loggedUser').val();							
		var material_type_id = $('#material_type').val();
		$(button_add).click(function(e){//on add input button click
			e.preventDefault();	
			
			if ( $( ".well" ).length ){
			var lastid = $(".well:last").attr("id");
			console.log('lastid===>>>',lastid);		
			if(lastid != '' && typeof(lastid) != 'undefined'){
				var lastIdVal= lastid.split('_');		
				x = parseInt(lastIdVal[1]);
			}
		}
		
		   setTimeout(function(){
			if($("#outsource_btn").prop('checked') == true){
			
				//if ($("#outsource_btn").is(':checked')){
					$('.totl_amt').removeClass('col-md-2');
					$('.totl_amt').addClass('col-md-1');
					$(".show_cls").show();
				}else{
					$('.totl_amt').removeClass('col-md-1');
					$('.totl_amt').addClass('col-md-2');
					$(".show_cls").hide();
					$(".get_process_name  option[value='']").prop('selected', false);
				    $("#process_name_id option[value='']").prop('selected', false);
				}
			}, 100);	
		if(x < maximum){ //max input box allowed
					x++; 
					
				
			$(wrap_material).append('<div class="well item form-group scend-tr mobile-view" id="chkIndex_'+x+'"><div class="col-md-1 col-sm-12 col-xs-6 form-group"><label>MAT.Type<span class="required">*</span></label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label>MAT.Name<span class="required">*</span></label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-6 form-group totl_amt"><label>Description</label><textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea></div><div class="col-md-2 col-sm-6 col-xs-6 form-group"><label>Quantity &nbsp;&nbsp; &nbsp;UOM</label><input type="text" id="quantity" name="quantity[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"><input id="uom" type="text" name="uom1[]"  placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" readonly><input type="hidden" name="uom[]" readonly class="uom"></div><div class="col-md-2 col-sm-6 col-xs-6 form-group totl_amt"><label>Price</label><input type="text" name="price[]"  placeholder="price/per" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"  min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Sub Total</label><input type="text" name="sub_total[]" id="sub_total" placeholder="sub total" class="form-control col-md-7 col-xs-12" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>GST</label><input type="text" name="gst[]"  placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax"  id="gst_tax"  min="0"  onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label>Sub Tax</label><input type="text" name="sub_tax[]"  placeholder="Tax" class="form-control col-md-7 col-xs-12 key-up-event" min="0" readonly></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label >Total</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]"  placeholder="total" class="form-control col-md-7 col-xs-12" readonly id="total" min="0"></div><div class="col-md-1 col-sm-12 col-xs-12 form-group show_cls" style="display:none;"><label >Bom</label><select class="itemName  form-control selectAjaxOption select2 goods_descr_section get_process_name" name="bom_number[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" data-where="created_by_cid='+ logged_user +' AND save_status=1" width="100%"><option value="">Select</option></select></div><div class="col-md-1 col-sm-12 col-xs-12 form-group show_cls" style="display:none;"><label >Process</label><select class="form-control process_name_id  goods_descr_section" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required"  id="process_name_id"><option value="">Select Option</option></select></div><button class="btn  btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div>');
			var material_type_id = $('#material_type').val();
			select2(material_type_id , logged_user);	
			
		}
		//var mat_id = $('#material_type').val();
			//getMaterials(mat_id,x);
			//init_select2();
			init_select221();
			init_select2();
			getProcess();
		});
		
			$(wrap_material).on("click",".remove_btn", function(e){ //user click on remove text
				e.preventDefault(); $(this).parent('div').remove(); x--;
				keyupFunction(event,this);
		});
}
function dateFunction(){
	
	$('.delivery_date').datepicker({ 
		//startDate: date,
		format: 'dd-mm-yyyy',
		autoclose: true
	});
	//var date = new Date();
	//date.setDate(date.getDate()-0);
	$('.bill_datee').datepicker({ 
		//startDate: date,
		format: 'dd-mm-yyyy',
	});
	
	/*fetch curent date in purchase order*/
		var date = new Date();
		 var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		 var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
			$('#current_date').datepicker({
			//format: "mm/dd/yyyy",
			format: "yyyy-mm-dd",
			todayHighlight: true,
			startDate: today,
			endDate: end,
			autoclose: true
			});
			$('#current_date').datepicker('setDate', today);
/*fetchsupplier address*/
var SupplierAddress = $('#supplier_name option:selected').attr('data-id');
					$("#address").val(SupplierAddress);		
					/*required date in indent*/
					
	
	
	var date = new Date();
		//date.setDate(date.getDate()-1);
		$('#req_date1').datepicker({ 
			//startDate: date,
			format: "dd-mm-yyyy",
			autoclose: true
		});
		
	var date1 = new Date();
		//date.setDate(date.getDate()-1);
		$('#req_date12').datepicker({ 
			//startDate: date1,
			format: "dd-mm-yyyy",
			autoclose: true
		});	
		$('#inv_date').datepicker({ 
			startDate: date1,
			format: "dd-mm-yyyy",
			autoclose: true
		});	
		
	$('#dob').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		endDate: 'today',
		autoclose: true
	});
	$('#dispatch_date').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});
	$('#order_date').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});
	$('#payment_date').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});	
		/*payment date*/
	var date = new Date();
	date.setDate(date.getDate()-0);
	$('#date').datepicker({
		format: "dd-mm-yyyy",		
		startDate: date
	});
	/*****in inventory listing acxtions*********/
	$('#datepicker').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        orientation: "top",
        endDate: "today"
  });
  
        
		
}
function showFreight(){
	//$(function() {		
	
		if($("input[name='terms_delivery']:checked").val() =='To be paid by customer'){		
			$('#freight1').show();
		}else{
			$('#freight1').hide();
		}
		//$('#freight1').hide();
		$('input[name="terms_delivery"]').on('click', function() {
			if ($(this).val() != 'FORPrice') {
				$('#freight1').show();
			}
			else {
				$('#freight').val('');
				$('#freight1').hide();
				keyupFunction();
			}
			
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
	//});
}
function getAddress(){
	$('.address').select2({
			allowClear: true,
			placeholder: 'Select Address',
			closeOnSelect: true,
			ajax: {
				url: site_url+'/purchase/getAddress',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						q: params.term
					};
				},	  
			processResults: function (data) {
				if(data){
					return {
					  results: data
					};
					
				}
			},
				cache: true,
			 }
	});
	var delivery_address = $('#delivery_address option:selected').attr('data-id');
		$("#delivery_address").val(delivery_address);		
        $('.address').trigger('change');
	
}
function check_mat_location_add_edit_mat(){
	$(document).on("click",".add_mat_btn_submit",function(){
		var location_mat =  $('.location').find(":selected").val();
		console.log('lknkldm===>>>',location_mat);
		if(location_mat == ''){
			$('.msssgg').addClass('alert_msg');
			$('.msssgg').html('Please put something here');
			$('.msssgg').show();
			/*$(".add_mat_btn_submit").prop('disabled', true);*/
		}else{
			$('.msssgg').removeClass('alert_msg');
			$('.msssgg').html('');
			$('.msssgg').hide();
			
			$(".add_mat_btn_submit").prop('disabled', false);
		}
	});
	$(document).on("change",".location",function(){
		console.log('lknkldm===>>>',location_mat);
		var location_mat =  $('.location').find(":selected").val();
		if(location_mat == ''){
			$('.msssgg').addClass('alert_msg');
			$('.msssgg').html('Please put something here');
			$('.msssgg').show();
			/*$(".add_mat_btn_submit").prop('disabled', true);*/
		}else{
			$('.msssgg').removeClass('alert_msg');
			$('.msssgg').html('');
			$('.msssgg').hide();
			/*$(".add_mat_btn_submit").prop('disabled', false);*/
		}
	});
}
/*Script for active Class*/
$(document).on("click","#myTab li a, #myTab1 li a",function(){ 
	  
});
$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
	
    localStorage.setItem('activeTab1', $(e.target).attr('href'));
   
});
$('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
	
    localStorage.setItem('activeTab2', $(e.target).attr('href'));
   
});
var activeTab1 = localStorage.getItem('activeTab1');
var activeTab2 = localStorage.getItem('activeTab2');
console.log(activeTab1);
if (activeTab1) {
   $('a[href="' + activeTab1 + '"]').tab('show');
}
if (activeTab2) {
   $('a[href="' + activeTab2 + '"]').tab('show');
}
/*Script for active Class*/
function getdata(){
$('.get_data_btn').click(function(){
     $(".get_data_btn").removeClass("tab_selected");
    $(this).addClass("tab_selected");
    var id = $(this).attr('id');
    	company_unit = "";
//$('#processing-modal').modal('toggle'); //before post
			// Post data 
			 $("#myDivty").show();
			setTimeout(function () {
				//$('#processing-modal').modal('hide'); // after post
				//$("#myDivty").hide();
				//$('body').removeClass('modal-open');
				// $('body').addClass('test');
				//$('.modal-backdrop').remove(); 
			}, 500);
    $.ajax({
           	url: site_url+'inventory/inventory_listing_and_adjustment/',
         	type: 'POST',
         	data: {value:id,company_unit:company_unit,ajax_var:'via_ajax'},
           	success: function(result2) {
				$("#myDivty").hide();
           				if(result2 != '') {
							html = $.parseHTML( result2 ),
							  nodeNames = [];
							$('.ee').empty();
							$('.ee').append( html );	
							$('#mat_id').val(id);
							$.each( html, function( i, el ) {
							  nodeNames[ i ] = "<li>" + el.nodeName + "</li>";
							});
							setTimeout(function(){
							//mycomment	
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
							}, 500);	
						}
						else{
							$(".ee").empty();
							var result2 = "No Data Available";
							html2 = $.parseHTML( result2 ),
							$('.ee').append( html2 );
							setTimeout(function(){
							//mycomment	
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
							}, 500);	
						}
						//alert('hmm');
						stock_checkk_fun();
						ediit_click_fun();
						
					}	
          });
 
});	
}
/************************************************************************************************************************************************************************************************************************************************Functions for material *********************************************************************************/
/*select uom once and is reflected in min and mac inventroy as well*/
function uom(){
	$('.uom').change(function () {
	
	var val = $('.uom').prop('selectedIndex');
	console.log("fff",val);
	$(".auto_uom").prop('selectedIndex', val);
	var closestIndex = $(this).closest('.well').next().attr('id');
	$("#"+closestIndex+"").find('.uom').prop('selectedIndex', val);
	});
}
/***************tags in material working*********************/
function tags() {
    $(".tags-field").select2({
        maximumSelectionLength: 10,
        tokenSeparators: [','],
    });
}
/*image upload in material fetaured image(crop functionality )*/
function uploadImage(){
	$(document).ready(function(){  
		$('#image').click(function(event){
			$('#imageModalUpload').modal('show');
		});
		$('#closemodal').click(function(event) {
			$('#imageModalUpload').modal('hide');
		});
		$image_crop = $('#image_demo').croppie({
			enableExif: true,
			viewport: {
				width:265,
				height:197,
				type:'square' //circle
			},
			boundary:{
				width:365,
				height:297
			}
		}); 
		$('#featured_image').on('change', function(){
			$('.crop_section').css("display", "block");
			var reader = new FileReader();
			reader.onload = function (event) {
				$image_crop.croppie('bind', {
					url: event.target.result
				}).then(function(){
					console.log('jQuery bind complete');
				});
			}
			reader.readAsDataURL(this.files[0]);
		});
		$('.crop_image').click(function(event){		
			var uploaded_image_name = $('#featured_image').val().replace(/.*(\/|\\)/, '');
			var Id = $("input[name=id]").val();
			if(Id == ''){
				$image_crop.croppie('result', {
					type: 'canvas',
					size: 'viewport'
				}).then(function(response){
					$.ajax({
						url: site_url +'inventory/uploadImageByAjax/',
						dataType: 'json',
						type: "POST",
						data:{"image": response, 'uploaded_image_name': uploaded_image_name},
						success:function(data){	
							var result = JSON.parse(JSON.stringify(data));
							console.log("resl",result);
							$('.hiddenImage').val(result.image)
							$('#imageModalUpload').modal('hide');
							$('#uploaded_image_Add').html(result.imageHtml);
							$('#changed_user_profile').val(result.image);
						}
					});
				})
			}else{
				$image_crop.croppie('result', {
					type: 'canvas',
					size: 'viewport'
				}).then(function(response){
					$.ajax({
						url: site_url +'inventory/EditImageByAjax/',
						dataType: 'json',
						type: "POST",
						data:{"image": response, 'uploaded_image_name': uploaded_image_name, 'Id':Id},
						success:function(data){	
							var result = JSON.parse(JSON.stringify(data));
							var appaendResult = result.imageHtml;
							$('.hiddenImage').val(result.image)
							$('#imageModalUpload').modal('hide');
							$('#uploaded_image').html(appaendResult);
							$('#changed_featured_image').val(result.image);
						}
					});
				})
			}
		});
	});
}
/********change prefix in material when material type is selected**********/
function ChangePrefix_and_subType(){
   var matTypeId = $('.materialTypeId').val();
   $.ajax({
		type:'POST',
		url:site_url+'inventory/getprefix_and_subType/',
		data: {
			'material_id': matTypeId,
		},
		success:function(data){
			var dataObj = JSON.parse(data);
				if(dataObj){
					var prefix = dataObj.Prefix;
					var subType = dataObj.SubType;
					var option = '<option value="">Select Sub Type</option>';
					if( subType ){
						var dataParse = JSON.parse(subType);
						
							var selectedMaterialSubType = $('#selectedMaterialSubType').html();
							var selected = '';
								$.each(dataParse, function(key, value) {
									//console.log("ff",value.sub_type);
									if(value.sub_type == selectedMaterialSubType){
										selected = 'selected';
									}else{ selected = ''; }
									option +="<option value='"+value.sub_type+"' "+selected+">"+value.sub_type+"</option>"; 
								});
					}
					$('.subtype').html(option);
					$(".prefix").html(prefix);
				}
					
		}
	}); 
}
/*********add more images in material********/
function addImages(){
	var maxImages      = 5; //maximum input boxes allowed
	var Image_box         = $(".image_box"); //Fields wrapper
	var upload_btn      = $(".add_images"); //Add button ID
	var y = 1; //initlal text box count
	$(upload_btn).click(function(e){ //on add input button click
		e.preventDefault();
		if(y < maxImages){ //max input box allowed
			y++;
			$(Image_box).append('<div class="item form-group"><label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label><div class="col-md-6 col-sm-6 col-xs-12"><input type="file" class="form-control col-md-7 col-xs-12"  name="materialImage[]"></div><button class="btn btn-danger remv_image" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	});
	$(Image_box).on("click",".remv_image", function(e){ 
		e.preventDefault(); $(this).parent('div').remove(); y--;
	});
}
/*********************add more location in material**********************************/
function addLocation(){
	var maxAddress     = 5; //maximum input boxes allowed
	var Address_Field  = $(".source"); //Fields wrapper
	var btn      = $(".add_sourceAddress"); //Add button ID
	var x = 1; //initlal text box count
	$(btn).click(function(e){ //on add input button click
		e.preventDefault();
		var data_where = $('.location').attr('data-where');
		if(x < maxAddress){ //max input box allowed
			x++;
			$(Address_Field).append('<div><div class="well"  style="overflow:auto;" id="chkIndex_'+x+'"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);" data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><input type="text" id="rack" name="rackNumber[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Rack numberee"></div><button class="btn btn-danger del_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
			getArea();
			init_select2();
		}
		
	});
	$(Address_Field).on("click",".del_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	});
}
/**************************************************************************************************************************************************************************************************************************************************************Functions for Material adjustment***************************************************************************/
/*get material for adjustment*/
$('#material_type').on('change',function(){
	var matId = $(this).val();
	console.log(matId);
	getMaterials(matId, 1,'matChanged');
}); 
function getMaterials(matId , x = '' , matChanged =''){
	if(matChanged == 'matChanged'){
		$('.material_name').empty();
	}
	var option = '';	
	if(matId){
		$.ajax({
			type:'POST',
			url:site_url+'inventory/get_material_name/',
			data: {
				'material_id': matId,
			},
			success:function(data){
				var dataObj =JSON.parse(data);
				if(dataObj){
					option = '<option value="">Select Product</option>';
					$(dataObj).each(function(){
						option = option+'<option value="'+this.id+'">'+this.material_name+'</option>';	
					}); 
					$('.material_name').append(option);
				}else{
					$('.material_name').html('<option value="">Product Not available</option>');
				}
			}
		}); 
	}else{
		$('.material_name').html('<option value="">Select Product name</option>');
	   }
}
/************************************************popup form on action in lisitng*************************************************************/
/*popum in lisitng*/
function popupForms_onAction(){
	$(function() {
		$('.action').on('click', function() {
			if ($(this).val() == 'scrap') {
				$('#textboxes').show();
				$('#move').hide();
				$('#stock_check').hide();
				$('#consumed').hide();
				init_select21();
			}
			else if($(this).val() == 'move'){
				$('#textboxes').hide();
				$('#stock_check').hide();
				$('#consumed').hide()
				$('#move').show();
				getArea();
				
			}
			else if($(this).val() == 'stock_check'){
				$('#textboxes').hide();
				$('#move').hide();
				$('#consumed').hide()
				$('#stock_check').show();
			}
			else if($(this).val() == 'consumed'){
				$('#textboxes').hide();
				$('#move').hide();
				$('#stock_check').hide();
				$('#consumed').show();
			}
			else if($(this).val() == 'half_full_book'){
				$('#textboxes').hide();
				$('#move').hide();
				$('#stock_check').hide();
				$('#consumed').hide();
				$('#book').show();
			}
			else if($(this).val() == 'material_conversion'){
				$('#textboxes').hide();
				$('#move').hide();
				$('#stock_check').hide();
				$('#consumed').hide();
				$('#book').hide();
				$('#material_conversion').show();
				init_select221();
			}
			
		});
		
	});
}
/*************************************************get addresss in location setting*****************************************************/
function getAddress(evt,t){
	$('.address').select2({
		allowClear: true,
		placeholder: 'Select And Begin Typing',
		closeOnSelect: true,
			ajax: {
				url: site_url+'/inventory/getAddress',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						q: params.term
					};
				},	  
				processResults: function (data) {
					if(data){
						return {
						  results: data
						};
					}
				},
				cache: true,
			}
	});
}
/****************************************************************************add mroe location in material conversion******************************************************/
function addLocationInConversion(){
	var maxAddress     = 5; //maximum input boxes allowed
	var destination_add  = $(".add_destination"); //Fields wrapper
	var button_add      = $(".add_More_DestinationAddress"); //Add button ID
	var k = 1; //initlal text box count
	$(button_add).click(function(e){ //on add input button click
		e.preventDefault();
		var data_where = $('.location').attr('data-where');
		
		if(k < maxAddress){ //max input box allowed
			k++;
			$(destination_add).append('<div><div class="well"  style="overflow:auto;" id="chkIndex_'+k+'"><<div class="col-md-5 col-sm-6 col-xs-12"><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);" data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12"><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12"><input type="text" id="rack_number" name="RackNumber[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');
			getArea();
			init_select2();
		}//getAddress();
	});
	$(destination_add).on("click",".delete_btn", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); k--;
	});
}
/*******************************************************action type fteching in lisitng popup form*************************************************/
function getAction(evt,t){
$(document).ready(function(){	
	var id = $(t).find("option:selected").attr('id');
	var material_type_id = $(t).find("option:selected").attr('data-materialType-id');
	var Action_Type = $(t).find("option:selected").attr("data-id");
	var material_Type = $(t).find("option:selected").attr("data-mat-type-name");
	var material_name = $(t).find("option:selected").attr("data-mat-name");
	var material_uom = $(t).find("option:selected").attr("data-uom");
	var uomname = $(t).find("option:selected").attr("data-uomname");
	var dtqty = $(t).find("option:selected").attr("data-qty");
	console.log("mat",material_Type);
	console.log("mattype",material_type_id);
	console.log("id",id);
	getAddressData();
	//setTimeout(function(){
		if(Action_Type == 'scrap'){
			$.ajax({
				type: "POST",
				url: site_url+'inventory/inventory_listing_edit/',
				data: {'id':id,
				'Action_Type' : Action_Type,
				}, 
				success: function(data){
					if(data != '') {	
						$('#scrap_modal').modal('show');
						$('#scrap_modal .modal-body-content').html(data);
						validateActionsInInventoryListing();
						function_to_check_qty_in_listing();
						$('#Actiontype').val(Action_Type);
						$('#material_id').val(id);
						dateFunction();
						init_select2();
						init_select21();
						$('#material_type_id').val(material_type_id);
						$('.scrap_mat_name #material_name').text(material_name);
					}
				}
			});
		}else if(Action_Type == 'stock_check'){
				// alert('stock_check f');
			$.ajax({
				type: "POST",
				url: site_url+'inventory/inventory_listing_stockCheck/',
				data: {'id':id,
				'Action_Type' : Action_Type,
				}, 
				success: function(data){
					if(data != '') {	
						$('#stock_modal').modal('show');
						$('#stock_modal .modal-body-content').html(data);
						validateActionsInInventoryListing();
						$('#Actiontype').val(Action_Type);
						$('#material_id').val(id);
						dateFunction();
						$('#material_type_id').val(material_type_id);
					}
				}
			});
		 }
		else if(Action_Type == 'consumed'){
			$.ajax({
				type: "POST",
				url: site_url+'inventory/inventory_listing_consumed/',
				data: {'id':id,
				'Action_Type' : Action_Type,
				}, 
				success: function(data){
					if(data != '') {
						
						$('#consumed_modal').modal('show');
						$('#consumed_modal .modal-body-content').html(data);
						validateActionsInInventoryListing();
						$('#Actiontype').val(Action_Type);
						$('#material_id').val(id);
						dateFunction();
						getAddressData();
						//getQuantity();
						function_to_check_qty_in_listing();
						//$('.consumed_mat_name #material_name').text(material_name);
						$('#material_name').text(material_name);
						$('#material_type_id').val(material_type_id);
						$('#uom').val(material_uom);
					}
				}
			});
		 }else if(Action_Type == 'move'){
			$.ajax({
				type: "POST",
				url: site_url+'inventory/inventory_listing_move/',
				data: {'id':id,
				'Action_Type' : Action_Type,
				}, 
				success: function(data){
					if(data != '') {	
						$('#move_modal').modal('show');
						$('#move_modal .modal-body-content').html(data);
						validateActionsInInventoryListing();
						init_select2();
						getArea();
						dateFunction();
						getAddressData();
						init_selectlot();
						//getQuantity();
						function_to_check_qty_in_listing();
						$('#Actiontype').val(Action_Type);
						$('#material_id').val(id);
						$('#material_type_id').val(material_type_id);
						$('.material_name').text(material_name);
						var quantityValue=$('#quantity').val();
					}
				}
			});
		 }else if(Action_Type == 'half_full_book'){
			$.ajax({
				type: "POST",
				url: site_url+'inventory/inventory_listing_halfBook/',
				data: {'id':id,
				'Action_Type' : Action_Type,
				}, 
				success: function(data){
					if(data != '') {	
						$('#book_modal').modal('show');
						$('#book_modal .modal-body-content').html(data);
						validateActionsInInventoryListing();
						init_select2();
						getMaterialName();
						getVarientOption();
						addMaterialDetail();
						dateFunction();
						function_to_check_qty_in_listing();
						$('#Actiontype').val(Action_Type);
						$('#material_id').val(id);
						$('#material_type_id').val(material_type_id);
						$('.material_type').val(material_Type);
						$('.material_name').val(material_name);
						$('#uom').val(material_uom);
						
					}
				}
			});
		 }
		else if(Action_Type == 'material_conversion'){
			$.ajax({
				type: "POST",
				url: site_url+'inventory/inventory_listing_materialConversion/',
				data: {'id':id,
				'Action_Type' : Action_Type,
				}, 
				success: function(data){
					if(data != '') {	
						$('#material_conversion').modal('show');
						$('#material_conversion .modal-body-content').html(data);
						validateActionsInInventoryListing();
						init_select2();
						init_select221();
						getMaterialName();
						getVarientOption();
						addMaterialDetail();
						dateFunction();
						getUOMinmaterialconvrs();
						addLocationInConversion();
						getQuantityinconversion();
						addMoreProductincoversion();										
						getArea();
						getAddressData();
						init_selectlot();
						function_to_check_qty_in_listing();
						$('#Actiontype').val(Action_Type);
						$('#material_id').val(id);
						$('#material_type_id').val(material_type_id);						
						$('.material_name').text(material_name);
						// $('.material_type1').val(material_Type);
						// $('.getUom').val(material_uom);
						// $('.getUomname').val(uomname);
						// $('.getUomname22').html(uomname);
						//$('.dtqty').val(dtqty);						
						if(material_uom == 6){
							$('.hideshow').show();
							$('.hideshow1').hide();
						}
						else
						{
							$('.hideshow').hide();	
							$('.hideshow1').show();
						}
					}
				}
			});
		}	
		//}, 1000);
		});
	}
/********************************************************code to  check availabel qty in inventory listing actions**********************/
/*keyup function in material issure to check if qunatity is available or not */
function function_to_check_qty_in_listing(){
	$('.keyup_check_qty').keyup(function(){
		setTimeout(function(){
		var material_name_id =  $('#material_id').val();
		var added_quantity = $('#qty').val();
		var selectedQty = $('#selectedQty').val();
		//alert(selectedQty); 
		if(selectedQty == ''){
			$('#mat_msg').html('Selected Source Address Qty Is Empty'); 
			$('.check_mat_qty').attr("disabled", "disabled");
		}
		else
		{
			if(parseInt(added_quantity) >  parseInt(selectedQty)){
			    
    			$('#mat_msg').html('The Available Quantity is  ' + selectedQty + ' please enter the quantity between 0 and '+ selectedQty); 
    			$('.check_mat_qty').attr("disabled", "disabled");
    			
    		}else{
    		    
    			$.ajax({
    				type: "POST",
    				url: site_url+'inventory/get_closing_material_qty/',
    				data: { mat_id:material_name_id}, 
    				success: function(result) {								
    					if((parseInt(added_quantity) > parseInt(result)) || (parseInt(added_quantity) <= 0)) {   //check if added qty is greater than the existing closing balance then throw error 
    						$('#mat_msg').html('The Available Quantity is  ' + result + ' please enter the quantity between 0 and '+ result); 
    						$('.check_mat_qty').attr("disabled", "disabled");
    					}else{
    					    $('#mat_msg').html('');
    					    $('.check_mat_qty').removeAttr("disabled"); 		   
    					}					
    				}         
    			});
    		}
		}
		}, 500);
	});
	


}
/*******************************************chnage status after toggle in material index page *************************************************************************/
// /*chang statsu in material*/
$(document).on('change', '.change_status', function(){
	var gstatus;	
	var checkbox =	$(this).attr('checked', true);
	if(checkbox.context.checked == true) gstatus = 1;
	else gstatus = 0;
	var id = $(this).attr("data-value");
	
		$.ajax({				
			url: site_url + 'inventory/change_status/',			
			dataType: 'json',
			type: 'POST',
			data: {
				'id': id,
				'gstatus': gstatus,
			},success: function(htmlStr) {
				  if(htmlStr == true){
					  $('.mesg').html('<b style="color: #E9EDEF; background-color: green;border-color: green;clear: both;padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;width: 100%;display: block;">Material Status update Successfully.</b>');
					 
					   setTimeout(function(){	
							   window.location.reload();
						   }, 500);
				  }
			  }	
		});
});
	
/***********************************************************fetch corresponding area of location from location setting in material ***********************************************/
  
 function getArea(evt, t){		 
	var optionValue = $(t).find('option:selected').val();		
	var closestId = $(t).closest(".well").attr("id");	
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: site_url + 'inventory/getLocationArea',
		data: {id:optionValue}, 
		success: function(data){
			if(data != ''){
				var optionData='<option value="">Select Option</option>';
				$.each(data, function(key, value) {					
					optionData +="<option value='"+value.id+"'>"+value.id+"</option>"; 				
				});
				$("#"+closestId+"").closest(".well").find('.area').html(optionData);			
			}else{
				$("#"+closestId+"").closest(".well").find('.area').html('');
			}
		}
	}); 
 }
/*****************************************************************get prefix in material type**************************************************/
function prefix(){
	
	$('#material_type').on('keypress',function(){
		console.log("hell");
		$("#prefix").val($("#material_type").val().substring(0,3).toUpperCase());
	});
	
}
/******************************************************************************************GET MATERIAL NAME**********************************************************************/
function getMaterialName(evt, t , selProcessType = '' , c_id = '' ){
	$(this).parents().closest('input=[text]').find('.materialNameId').empty();
	var logged_user = $('#loggedUser').val(); 
	var option = $(t).find('option:selected');
	var material_type_id = selProcessType != ''?selProcessType:$(option).val();
	//console.log(material_type_id);
	if(material_type_id != ''){
		select2(material_type_id , logged_user);	
	}
}
function select2(material_type_id , logged_user){
		$('.materialNameId').attr('data-where','material_type_id = '+material_type_id+' AND created_by_cid='+logged_user+' AND status = 1');
		$('.materialNameId').attr('data-id','material');
		$('.materialNameId').attr('data-key','id');
		$('.materialNameId').attr('data-fieldname','material_name');
}
/***********************************************************************************halfbook **********************************************************************/
/*add material in halfbook */
function addMaterialDetail(){
	var input  = 10; 
	var input_mat  = $(".material_detail"); 
	var add_mat  = $(".addMoreData");
	var y = 1; 
	$(add_mat).click(function(e){ 
		e.preventDefault();
		var measurmentArray = '';
		$.each( measurementUnits, function( key, value ) {
			measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
		});
			if(y < input){ 
				y++;
				$(input_mat).append('<div class="item form-group" style=""><div class="well" id="chkIndex_'+y+'" ><div class="col-md-4 col-sm-12 col-xs-12 form-group"><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getUom(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="quantity" name="quantity[]" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunc(event,this)" placeholder="Qty."></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select class="form-control uom" name="uom[]" id="uom"><option>Unit</option>"'+measurmentArray+'"</select></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div></div>');
				var logged_user = $('#loggedUser').val();							
				var material_type_id = $('#material_type').val();
				select2(material_type_id , logged_user);	
			}
			var mat_id = $('#material_type').val();
			init_select2();
			
});
	$(input_mat).on("click",".remove_input", function(e){ 
		e.preventDefault(); $(this).parent('div').remove(); y--;
	});
}
/***********************************************************************************Add more area in location setting********************************************************/
 /*add more area in locationsetting */
function addArea(){
	var inputArea  = 20; 
	var input_area_div  = $(".area_div"); 
	var add_area  = $(".addArea");
	var k = 2; 
	$(add_area).click(function(e){ 
		e.preventDefault();
			if(k < inputArea){ 
				k++;
				$(input_area_div).append('<div class="item form-group" style=""><div class="well" id="chkIndex_'+k+'" style="padding:0px;"><div class="col-md-10 col-sm-12 col-xs-12 form-group"  style="width: 89.2%;"><input type="text" class="form-control col-md-2 col-xs-12 areaName" name="area[]" placeholder="area" required="required"></div><button class="btn btn-danger remove_area" type="button"><i class="fa fa-minus"></i></button></div></div>');
				var logged_user = $('#loggedUser').val();							
				var material_type_id = $('#material_type').val();
				select2(material_type_id , logged_user);	
			}	
	});
	$(input_area_div).on("click",".remove_area", function(e){ 
		e.preventDefault(); $(this).parent('div').remove(); k--;
	});
}
 
 
 
/*************************************************************dashboard graphs********************************************************/
	
$(document).ready(function(e) {		
getDashboardCount();
getMonthInventoryListingGraph();
getScrappedDetail();
getStockSummary();
});		
/******************************************Show Upper counts from each module of inventory  ************************************/
	function getDashboardCount(startDate = '' , endDate = ''){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({     
				url: site_url +'inventory/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){
					console.log("rsponse",response);
					var dashboardCountHtml = '';	
					$.each( response.getDashboardCount, function( key, value ) {
						dashboardCountHtml += '<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12"><div class="tile-stats"><div class="icon"><i class="'+value.icon+'"></i></div><div class="count">'+value.total+'</div><h2><strong>'+value.name+'</strong></h2><p>'+value.description+'</p></div></div>';
					});
					$('.top_tiles').html(dashboardCountHtml);
					
				}			
			});
	}
	
	
	
/************************************* Dashboard filteration data ******************************************************/
$('.dashboardFilter').daterangepicker({
    opens: 'left',
	useCurrent: true,
	//startDate: new Date(date.getFullYear(), date.getMonth(), 1),
  
    //endDate: new Date(date.getFullYear(), date.getMonth()+1, 0),
	locale: {
	    format: 'DD-MM-YYYY',
	},	
  }, function(start, end, label) {  
		var startDate = start.format('YYYY-MM-00 00:00:00');
		var endDate = end.format('YYYY-MM-00 00:00:00');		
		var dateRangeHtml = $(this)[0].element.context;		
		$(".progress").empty();
		getScrappedDetail(startDate ,endDate);	
		$("#month_Wise_graph").empty();
		getMonthInventoryListingGraph(startDate ,endDate);	
		getDashboardCount(startDate ,endDate);
		$("#material_type_graph_donut").empty();
		getStockSummary(startDate ,endDate);	
	});  	
	
/***************************************bar graph for material listing***************************************************/
function getMonthInventoryListingGraph(startDate = '' , endDate = ''){
	if ($('#month_Wise_graph').length){
			if(startDate!='' && endDate!=''){
				var ajaxData = {'startDate':startDate , 'endDate':endDate};
			}else{
				var ajaxData = {};
			}
		
			$.ajax({        
				url: site_url +'inventory/graphDashboardData/',
				dataType: 'json',
				type: 'POST',				
				data: ajaxData,
				success: function(result){
					result = result.getMonthInventoryListingGraph;
					console.log(result);
					Morris.Bar({
					  element: 'month_Wise_graph',
					  data: result,
					  xkey: 'period',
					  barColors: ['#26B99A', '#34495E','#B22222','#E11CD2' ,'#CD853F'],
					  ykeys: ['scrapQty','consumedQty', 'moveQty','halfBookQty' , 'stockCheckQty'],
					  labels: ['Scrap','Move','Consumed' , 'Half/Full book','stock check'],
					  hideHover: 'auto',
					  xLabelAngle: 60,
					  resize: true
					});		
				}			
			});		
	}
}
/**********************************************stock summary graph*****************************************************************************/
function getStockSummary(startDate = '' , endDate = ''){					  
	if ($('#material_type_graph_donut').length){
		
		if(startDate!='' && endDate!=''){
			var ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			var ajaxData = {};
		}
		$.ajax({        
			url: site_url +'inventory/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			
			success: function(result){
				var result = result.getStockSummary;
					var labelObject =new Array();
						$.each(result, function (key, val) {
							labelObject.push({
								label: val.Name, 
								value:  val.total
							});
						});
						Morris.Donut({
							element: 'material_type_graph_donut',
							data:labelObject,
							colors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB','#FF0000' ,'#FFFF00','#F08080','#FF4500','#FFD700','#FF8C00','#008000','#556B2F','#20B2AA','#008080','#1E90FF','#0000CD','#FF00FF','#800080','#FF69B4','#C71585','#DAA520','#8A2BE2','#DDA0DD','#87CEFA','#000080','#483D8B','#4B0082','#2F4F4F','#800000','#A0522D','#7FFFD4','#008B8B','#32CD32','#FFA07A'],
								formatter: function (y) {
								return y ;
							},
							resize: true
						});
			}			
		});		
	}  
}
/***************************************************get scrapped detail******************************************************************/
function getScrappedDetail(startDate = '' , endDate = ''){
	if($("#scrappedDiv").length) {	
		if(startDate!='' && endDate!=''){
			ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			ajaxData = {};
		}
		$.ajax({      
			url: site_url +'inventory/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			data: ajaxData,
			success: function(response){
				var result = response.getScrappedDetail;
				var scrappedData = '';
				var i = 0;
				$.each(result, function (index,value) {
					var Width =  value.sum;
					scrappedData += '<div class="widget_summary"><div class="w_left w_25"><span class="ConsumedScrap">'+value.name+'</span></div><div class="w_center w_55"><div class="progress"><div class="progress-bar bg-green pg4" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:'+Width+'%"><span class="sr-only"></span></div></div></div><div class="w_right w_20"><span class="totalConsumed">'+value.sum +'-'+value.uom+'</span></div><div class="clearfix"></div></div>';
				});
				$('#scrappedDiv').html(scrappedData);	
			}		
		});
	}
}	
	
//***************************************************Function to show the dashboard in main dashboard******************************/
$('.graphCheckbox').click(function(e){
	var show = 0;
	if ($(this).is(":checked")) show = 1;
	else show = 0;
	var graph_id = $(this).attr('id');
	var ajaxData = {'graph_id':graph_id , 'show':show};
	$.ajax({
		url: site_url +'inventory/showDashboardOnRequirement/',
		dataType: 'json',
		type: 'POST',
		data: ajaxData,
		success: function(response){
			//console.log('response===>>>>',response);
		}
	});
});
/**********************************************************Addmulitple image upload*******************************************************************************/
/*function uploadMultipleImage(){
	$('.multipleImge').click(function(event){
		$('#MultipleImageModalUpload').modal('show');
		ImageCrop();
	});
}
function ImageCrop(){
			$('#image_demo_multiple').croppie('destroy');
			$image_crop_multiple = $('#image_demo_multiple').croppie({
			enableExif: true,
			viewport: {
			  width:265,
			  height:197,
			  type:'square' //circle
			},
			boundary:{
			  width:365,
			  height:297
			}
		}); 
		$('#multiple_image').on('change', function(){
			$('.crop_section_multiple').css("display", "block");
			var reader = new FileReader();
			reader.onload = function (event) {
				$image_crop_multiple.croppie('bind', {
					url: event.target.result
				}).then(function(){
					console.log('jQuery bind complete');
				});
			}
			reader.readAsDataURL(this.files[0]);
		});
		$('.crop_image_multiple').click(function(event){	
	
			var uploaded_image_multiple = $('#multiple_image').val().replace(/.*(\/|\\)/, '');
			var mat_Id = $("input[name=id]").val();
			//if(Id == ''){
				$image_crop_multiple.croppie('result', {
				  type: 'canvas',
				  size: 'viewport'
				}).then(function(response){
					$.ajax({
						url: site_url +'inventory/uploadMultipleImageByAjax/',
						dataType: 'json',
						type: "POST",
						data:{"image_multiple": response, 'uploaded_image_multiple': uploaded_image_multiple},
						success:function(data){	
							var resultImage = JSON.parse(JSON.stringify(data));
							console.log("result",resultImage);
							$('.multipleImage').append(resultImage.image);
							
							$('#MultipleImageModalUpload').modal('hide');
							//$('#uploaded_image').html(resultImage.imageHtml);
							$('#changed_user_profile').val(resultImage.image);
						}
					});
				})
			
		});
			
}*/
/********************************************************add more in WIP process ********************************************/
	 function addMoreIssueMaterial(){
		var maxMaterial = 20; 
		var Material_data = $(".input_material_wrap"); //Fields wrapper
		var add_mat_btn = $(".addMoreMaterial"); //Add button ID
		var mat = 1; //initlal text box count
		var logged_user1 = $('#loggedUser').val();
		var materialType = "'material'";
		var workOrderType = "'work_order'";
		$(add_mat_btn).click(function(e){ //on add input button click
			e.preventDefault();
			if(mat < maxMaterial){ //max input box allowed
			    mat++;
			    $(Material_data).append(`<div class="well" id="chkIndex_${mat}" style="overflow:auto;">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <label>Work Order <span class="required">*</span></label>
                          <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" 
                          onchange="getMaterialOfWorkOrder(this.id,${mat});getMaterialQuantites(event,this,'work_order')" 
                          name="work_order_id_select[]" 
                          width="100%" tabindex="-1" 
                          aria-hidden="true"  
                          data-id="work_order" 
                          data-key="id" 
                          data-fieldname="workorder_name" 
                          tabindex="-1"  
                          aria-hidden="true" 
                          data-where="created_by_cid=${logged_user1}  AND progress_status =0" 
                           id="multipleSelect_${mat}"  >
                           <option value="">Select Option</option>
                           </select> 
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <label>Product Name <span class="required">*</span></label>
                           <select class="form-control "   name="work_order_product[]"  
                           id="work_order_product" >
                              <option value="">Select Option</option>
                           </select>
                        </div>
                          <div class="jobcard_product" id="materiyal_${mat}">
                            <div class="well" id="materiyal_${mat}">
                                 <div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Product Type</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Product name</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Lot No.</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Quantity</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Uom</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>location</label></div> 
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Work Order</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>NPDM</label></div>
                                 <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Machine Name</label></div>
                              <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Req Qty</label></div> 
                             <div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Issued Qty</label></div>
                          </div>
                          <div id="clone_${mat}">
                         <div class="well" id="materiyal_${mat}" style="overflow:auto;">
                           <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                          <!-- selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData -->
                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData"  name="material_type_id_${mat}[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=${logged_user1}  " tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                           <option value="">Select Option</option>
                            </select>
                        </div>  
                      
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name requiredData"  name="material_name_${mat}[]" onchange="getUom(event,this);getlot(event,this);getMaterialQuantites(event,this,'material')" id="mat_id_funcs">
                              <option value="">Select Option</option>
                                  
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-6 form-group">
                           
                           <select class="lotno form-control col-md-2 col-xs-12 selectAjaxOption select2 requiredData" id="lotno" name="lotno_${mat}[]" data-id="lot_details" data-key="id" data-fieldname="lot_number" data-where="created_by_cid=${logged_user1} AND active_inactive=1">
                              <option value="">Select Option</option>
                      
                           </select>
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           
                           <input type ="text"  id="qty" name="qty_${mat}[]"  class="form-control col-md-7 col-xs-12 keyup_event" placeholder="quantity"   placeholder="Qty">
                        </div>
                         
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group"> 
                           <input style="width:100% !important;" name="uom1_${mat}[]" type="text"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" readonly>
                           <input  type="hidden" id="uom" name="uom_${mat}[]" class="form-control col-md-7 col-xs-12 uom"   readonly placeholder="uom">
                        </div>
                        <!--  locationselectAjaxOption select2 select2-hidden-accessible location requiredData -->
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location requiredData" name="location_${mat}[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=${logged_user1}">
                              <option value="">Select Option</option>
                                
                           </select>
                        </div>
                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId " onchange="getMaterialQuantites(event,this,'work_order')"   name="work_order_id_${mat}[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=${logged_user1} AND progress_status = 0 ">
                              <option value="">Select Option</option>
                         
                           </select> 
                   
                     <input type="hidden" class="SelectedSaleOrder" name="sale_order_id_${mat}[]"  >
                        </div>
                       <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                         <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2" name="npdm_${mat}[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="npdm" data-key="id" data-fieldname="product_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=${logged_user1}">
                              <option value="">Select Option</option>
                              
                           </select>  
                        </div>
                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->
                          <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 " name="machine_name_${mat}[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="add_machine" data-key="id" data-fieldname="machine_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=${logged_user1}">
                              <option value="">Select Option</option>
                               
                           </select>  
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <input name="required_quantity_${mat}[]" type="text"  class="form-control col-md-7 col-xs-12 required_quantity"    readonly>
                        </div>
                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">
                           <input name="issued_quantity_${mat}[]" type="text"  class="form-control col-md-7 col-xs-12 issued_quantity" readonly>
                        </div>
                          <button class="btn btn-primary addmore" type="button"><i class="fa fa-plus"></i></button>
                     </div>
                   </div>
                 </div> 
                        <button class="btn btn-danger delete_mat_btn" type="button"><i class="fa fa-minus"></i></button> 
                   </div>`);
					var logged_user = $('#loggedUser').val();							
					var material_type_id = $('#material_type').val();
					var mat_id1 = $('#mat_id_funcs').val();
					select2(material_type_id , logged_user);	
					select2lot(mat_id1 , logged_user);
                  	addmoredataRM();
				}
					var mat_id = $('#material_type').val();
					keyup_function_to_check_qty();
					init_select2();
					getMaterialOfWorkOrder();
		});
		$(Material_data).on("click",".delete_mat_btn", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); mat--;
		});
   }
	
function addmoredataRM() {

    /* Add More Button */

    var maxMaterial = 20;

    var Material_data = $(".input_material_wrap"); //Fields wrapper

    var add_mat_btn = $(".addmore"); //Add button ID

    var mat = 1; //initlal text box count

    var logged_user1 = $('#loggedUser').val();

    //alert(Material_data);

    $(add_mat_btn).click(function(e) { //on add input button click

        e.preventDefault();

        var div_id = $(this).closest('.jobcard_product').attr('id');

        var result = div_id.split('_');

        var div_len = result[1];

        // alert(div_id);

        var clone = '#clone_' + div_len;

        //var data_where = $('.location').attr('data-where');

        if (mat < maxMaterial) { //max input box allowed

            mat++;

            $(clone).append(`<div class="well" id="materiyal_${div_len}" style="overflow:auto;">

                           <div class="col-md-2 col-sm-6 col-xs-12 form-group">

                            <!-- selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData -->

                           <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requiredData"  name="material_type_id_${div_len}[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid=${logged_user1}  " tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type">
                           <option value="">Select Option</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                           <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name requiredData"  name="material_name_${div_len}[]" onchange="getUom(event,this);getlot(event,this);getMaterialQuantites(event,this,'material')" id="mat_id_funcs">
                              <option value="">Select Option</option>
                           </select>

                        </div>
 

                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">



                           <input type ="text"  id="qty" name="qty_${div_len}[]"  class="form-control col-md-7 col-xs-12 keyup_event" placeholder="quantity"   placeholder="Qty">

                        </div>

                       

                        <div class="col-md-1 col-sm-6 col-xs-12 form-group">

                           <input style="width:100% !important;" name="uom1_${div_len}[]" type="text"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom1" readonly>

                           <input  type="hidden" id="uom" name="uom_${div_len}[]" class="form-control col-md-7 col-xs-12 uom"   readonly placeholder="uom">

                        </div>

                        <!--  locationselectAjaxOption select2 select2-hidden-accessible location requiredData -->

                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">

                           <select class="location form-control selectAjaxOption select2 select2-hidden-accessible location requiredData" name="location_${div_len}[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" data-where="created_by_cid=${logged_user1}">

                              <option value="">Select Option</option>



                           </select>

                        </div>

                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->

                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">

                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId " onchange="getMaterialQuantites(event,this,'work_order')"   name="work_order_id_${div_len}[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=${logged_user1} AND progress_status = 0 ">

                              <option value="">Select Option</option>



                           </select>



                     <input type="hidden" class="SelectedSaleOrder" name="sale_order_id_${div_len}[]"  >

                        </div>

                       <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->

                         <div class="col-md-1 col-sm-6 col-xs-12 form-group">

                        <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2" name="npdm_${div_len}[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="npdm" data-key="id" data-fieldname="product_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=${logged_user1}">

                              <option value="">Select Option</option>



                           </select>

                        </div>

                        <!-- selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId -->

                          <div class="col-md-1 col-sm-6 col-xs-12 form-group">

                     <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 " name="machine_name_${div_len}[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="add_machine" data-key="id" data-fieldname="machine_name" tabindex="-1"  aria-hidden="true" data-where="created_by_cid=${logged_user1}">

                              <option value="">Select Option</option>



                           </select>

                        </div>

                        



                        

                          <button class="btn btn-danger addmore_delete" type="button"><i class="fa fa-minus"></i></button>

                     </div> `);

            var logged_user = $('#loggedUser').val();

            var material_type_id = $('#material_type').val();

            var mat_id1 = $('#mat_id_funcs').val();

            select2(material_type_id, logged_user);

            select2lot(mat_id1, logged_user);



        }

        var mat_id = $('#material_type').val();

        keyup_function_to_check_qty();

        init_select2();

        getMaterialOfWorkOrder();

    });

    $(Material_data).on("click", ".addmore_delete", function(e) { //user click on remove text

        e.preventDefault();
        $(this).parent('div').remove();
        mat--;

    });

}



	
/**********************************keyup function in wip material to check if qunatity is available or not **************************************/
	function keyup_function_to_check_qty(){
		$(document).on('keyup','.keyup_event',function(){
            var matrial_select_this2 = $(this).closest('.well').attr('id');
            var mat_id = $(this).closest('.well').find("#mat_id_funcs").val();
			var added_qty = $(this).closest('.well').find("#qty").val();
			$.ajax({
				type: "POST",
				url: site_url+'inventory/get_closing_material_qty/',
				data: { mat_id:mat_id}, 
				success: function(result) {
					$('#mat_msg').html(""); 
					if(parseInt(added_qty) > parseInt(result)){       //check if added qty is greater than the existing cloing balance then throw error
						$('#mat_msg').html('The Available Lot Quantity is ' + result); 
						$('.check_mat_qty').attr("disabled", "disabled"); 
						$('.submit').prop("disabled", true);
					}else{
					   $('#mat_msg').html('');
					   $('.check_mat_qty').removeAttr("disabled");  
					    $('.submit').prop("disabled", false);
  
					}
				}         
			}); 
		});
	}
	
/*************************************************fetching uom value on material seelect in Wip material*************************************************************/
	function getUom(evt, t){
		//var option = $(t).find('.materialNameId option:selected');
		//var materialId = option.val();
		//ar materialId = $(t).find('.materialNameId').val();
		//
		var closestId = $(t).closest(".well").attr("id");
		var materialId = $('#'+closestId+' .materialNameId').val();
		//console.log("ffffffff",materialId);
		$.ajax({
			type: "POST",
			url: site_url + 'inventory/getMaterialUomById',
			data: {id:materialId}, 
			success: function(data){
				if(data != '') {
					var dataObj =JSON.parse(data);
					$("#"+closestId+"").find('.uom1').val(dataObj.uom);
					
					$("#"+closestId+"").find('.uom').val(dataObj.uomid);
					//var option +="<option value='"+dataObj.uom+"' >"+dataObj.uom+"</option>"; 
					//$("#"+closestId+"").find('.uom').val(option);
					var logged_user = $('#loggedUser').val();
					$("#"+closestId+" #mat_name").attr('data-where', 'mat_id = ' + materialId + ' AND created_by_cid=' + logged_user + ' AND active_inactive =1');
				}
			}
		}); 
		
	}
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
//Print Function
/*******************************************job card click event to fetch corresponding material in finish goods*****************************************************/
 function on_change_job_card(evt, t){
	var jobCardId = $(t).find('option:selected').val();
		$.ajax({
			type: "POST",
			url: site_url + 'inventory/getJobCardDetail',
			data: {id:jobCardId}, 
			success: function(data){
				var obj = jQuery.parseJSON(data);
					var getJobcardData =  JSON.parse(obj[0].material_details);
						var len = getJobcardData.length;
						var material_name_id = '';
						var quantity = '';
						var uom = '';
						
						var material_detail ='';
							for(var i=0; i<len; i++){
								
								material_name_id = getJobcardData[i].material_name_id;
								quantity = getJobcardData[i].quantity;
								uom = getJobcardData[i].unit;
								$.ajax({                                         //again call ajax to get material name based on material id 
										'async': false,
										type: "POST",
										url: site_url + 'inventory/getMaterialNameById_check',
										data: {material_name_id:material_name_id}, 
										success: function(data1){
										var dataObj = JSON.parse(data1);
										    mat = dataObj.material_name;	
										    uom_named = dataObj.uom_name;
										}
									});
									
								
									material_detail += '<div class="materialDiv mobile-view"><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="mate">Product name</label><input type="hidden" id="material_name" name="material_name_id[]" class="form-control col-md-7 col-xs-12"  placeholder="Product name" value="'+ material_name_id +'"><input type="text" id="material_name" name="material_name[]" class="form-control col-md-7 col-xs-12"  placeholder="Product name" value="'+ mat +'"></div><div class="col-md-3 col-sm-6 col-xs-12 qtyValue form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</label><input type="text"  id="quant" name="quantity[]"  class="form-control col-md-7 col-xs-12 qty" placeholder="quantity" value="'+quantity+'" onkeyup="GetTotalValue(event,this);"></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Uom">UOM</label><input type="hidden" id="uom" name="uom[]" class="form-control col-md-7 col-xs-12 uom"  placeholder="uom" value="'+uom+'" style="width:100%;"><input type="text"  name="uom1[]" class="form-control col-md-7 col-xs-12 uom"  value="'+uom_named+'" ></div><div class="col-md-3 col-sm-6 col-xs-12 outputDiv form-group" style="border-right:1px solid #c1c1c1 !important;"><label class="col-md-12 col-sm-12 col-xs-12" for="output">Output</label><input type="text" id="output" name="calculatedOutput[]" class="form-control col-md-7 col-xs-12 output"  placeholder="Output" value=""></div></div>';	
									
								
							}
							// setTimeout(function(){
								// var sum = 0;
								// $('.qty').each(function() {
									// sum += Number($(this).val());
								// });	
									// $("#total_qty").val(sum);
							// }, 1000);	
							var closestWell = $(t).closest('.well');
							$(closestWell).find('.input_holder').html(material_detail);
													
			}
		});
 }
function GetTotalValue(evt,t){
	var scrap_qty = $("#scrap_qty").val();   //get scrapQty value	
	if(scrap_qty)
		scrap_qty = parseFloat(scrap_qty).toFixed(2);    //get scrapvalue upto two digit
		$('.well').each(function(){							//each on well class to get the values individually 
			var amount = 0;	
			var sum =  0;
			var wellId = $(this).attr('id');
			var totalQtyAmountVal = ($('#'+wellId+' .totalQtyAmount').val());     //get the totalQtyamount individually 
			var totalQtyAmount = totalQtyAmountVal?(parseFloat(totalQtyAmountVal).toFixed(2)):0;		//upto two decimal place			
				
				/***********get each quantity sum separately(one section) ***********/
				$('#'+wellId+' .qty').each(function(){
					sum += Number($(this).val());
				});	
				sum = parseFloat(sum).toFixed(2);				
				
				/*************caculate totalAmount* each quanitity / Total qty************/
				$('#'+wellId+' .qty').each(function(){	
					var calculatedRatio = ($(this).val()* totalQtyAmount)/sum;
					$(this).closest(".materialDiv").find('.output').val(calculatedRatio.toFixed(2));	
				}); 
				/***************output sum of all values **************/
				var outputSum =0;
				$('.output').each(function() {
					if($(this).val())					
					 outputSum += parseFloat($(this).val());
				});		
				/***********relfelect output value in each field based on scrap without affecting the other div value *************/
				$('#'+wellId+' .output').each(function(){							
					var outputValue = parseFloat($(this).val()).toFixed(2);	        //upto two decimal place 
					//calculate individual by scrap*single outputValue and divide by total output value
					var individualScrapValue = (outputValue * scrap_qty)/outputSum;	     
					//after caluclating scrap add value tothe sum
					var calculate_Scrap_ratio = (parseFloat(outputValue) + parseFloat(individualScrapValue)).toFixed(2); 
					$(this).closest(".materialDiv").find('.output').val(calculate_Scrap_ratio);	
				}); 		
		});					
	}
/*****************add more finish goods ***************/
function addmore_finish_goods(){
	var maxValue     = 10; //maximum input boxes allowed
	var added_field  = $(".recv_finish_goods_add"); //Fields wrapper
	var add_more_btn      = $(".add_more_finish_goods"); //Add button ID
	var k = 1; //initlal text box count
	$(add_more_btn).click(function(e){ //on add input button click
	    // getAddress();
		e.preventDefault();
		var data_where = $('.job_card_class').attr('data-where');
		if(k < maxValue){ //max input box allowed
			k++;
			$(added_field).append('<div class="panel panel-default" style="overflow: hidden; padding-bottom: 35px;"><div class="col-md-12 middle-box2"><div class="well "  style="overflow:auto;" id="chkIndex_'+k+'"><div class="item form-group top-fild col-md-10 col-xs-12 col-sm-12 vertical-border"><div class="control-label col-md-3 col-sm-3 col-xs-12" for="mat_name">Job Card</div><div class="col-md-3 col-sm-6 col-xs-12"><select class="form-control selectAjaxOption select2 select2-hidden-accessible  select2 job_card_class" required="required" name="job_card_no[]" data-id="job_card" data-key="id" data-fieldname="job_card_no"  tabindex="-1" aria-hidden="true" onchange="on_change_job_card(event,this)" id="job_card"  data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12"><input type="text" id="total_Qty_Amount" name="total_Qty_Amount[]" class="form-control col-md-7 col-xs-12 totalQtyAmount"  placeholder="Quantity in total" value=""  onkeyup ="GetTotalValue(event,this);" onkeypress ="GetTotalValue(event,this);"></div></div><div class="item form-group  mobile-view2" style="border-top:1px solid #c1c1c1 !important; clear: both;"><div class="col-md-3 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="mate">Product name</label></div><div class="col-md-3 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</label></div><div class="col-md-3 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Uom">UOM</label></div><div class="col-md-3 item form-group" style="border-right:1px solid #c1c1c1 !important;"><label class="col-md-12 col-sm-12 col-xs-12" for="output">Output</label></div></div><div class="item form-group"><div class="col-md-12 form-group"><div class="col-md-12 input_holder form-group" id="input_holder"></div></div></div><div class="item form-group"><div class="col-md-3 col-sm-6 col-xs-12"><input type="hidden" id="total_qty" name="total_qty" class="form-control col-md-7 col-xs-12"  placeholder="Total Quantity" value="" ></div></div></div><button style="margin-left: 10px;" class="btn btn-danger delete_finish_goods_div" type="button"><i class="fa fa-minus"></i></button>');
			init_select2();
		}
		
	});
	$(added_field).on("click",".delete_finish_goods_div", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); k--;
	});
}
/*******************************************************Add more subtype in inventory setting(material type)*************************************/
/*********add more sub type input in material type setting********/
function addSubType(){
	var maxInput      = 50; //maximum input boxes allowed
	var inputField         = $(".add_sub_type"); //Fields wrapper
	var addSubTypebtn      = $(".addSubType"); //Add button ID
	var y = 1; //initlal text box count
	$(addSubTypebtn).click(function(e){ //on add input button click
		e.preventDefault();
		if(y < maxInput){ //max input box allowed
			y++;
			$(inputField).append('<div class="item form-group" style="clear:both;"><div class="well"><div class="col-md-12 col-sm-6 col-xs-12 input-group vertical-border" ><label  class="col-md-3">Sub type <span class="required">*</span></label><div class="col-md-8"><input id="material_sub_type" class="materialSubType form-control col-md-7 col-xs-12" name="material_sub_type[]" placeholder="Material type" type="text" value="" id="material_sub_type" required="required" ><span style="color:red;"class="dmsg"> </span></div></div><button class="btn btn-danger remv_subType" type="button"><i class="fa fa-minus"></i></button></div></div>');
		}
		$('.materialSubType').on('keyup', function() {
				var arr = new Array();
				$(".materialSubType").each(function(){
					arr.push($(this).val());
			   });
			    //console.log('arr =====>',arr);
			   //alert(arr.length);
			   for(var i=0; i<arr.length;i++){
				   for(var j=i+1;j<arr.length;j++){
					  if(arr[i] == arr[j]){
						  //console.log('arr[i] =====>',arr[i]);
						 // console.log('arr[j] =====>',arr[j]);
						  $(this).next('.dmsg').text('Its already added on above');
						  $(".signUpBtn").attr( "disabled", "disabled" );
						  $(".addSubType").attr( "disabled", "disabled" );
						  // return false;
					  }else if(arr[i]!=arr[j]){
						 $('.dmsg').html('');
							$(".signUpBtn").removeAttr("disabled");						 
							$(".addSubType").removeAttr("disabled");						 
					  }
				   }
			   }         
							
		});
	});
	$(inputField).on("click",".remv_subType", function(e){ 
		e.preventDefault(); $(this).parent('div').remove(); y--;
	});
	
				
}
/******************************************************************hierarchy of material type*****************************************************************************/
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
            var easyTreeI = $(this);
            $.each($(easyTreeI).find('ul > li'), function() {
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
            $(easyTreeI).find('li:has(ul)').addClass('parent_li').find(' > span').attr('title', options.i18n.collapseTip);
            // add easy tree toolbar dom
            if (options.deletable || options.editable || options.addable) {
                $(easyTreeI).prepend('<div class="easy-tree-toolbar"></div> ');
            }
            // addable
         
            // editable
            if (options.editable) {
                $(easyTreeI).find('.easy-tree-toolbar').append('');
                $(easyTreeI).find('.easy-tree-toolbar .edit > button').attr('title', options.i18n.editTip).click(function () {
                    $(easyTreeI).find('input.easy-tree-editor').remove();
                    $(easyTreeI).find('li > span > a:hidden').show();
                    var selected = getSelectedItems();
                    if (selected.length <= 0) {
                        $(easyTreeI).prepend(warningAlert);
                        $(easyTreeI).find('.alert .alert-content').html(options.i18n.editNull);
                    }
                    else if (selected.length > 1) {
                        $(easyTreeI).prepend(warningAlert);
                        $(easyTreeI).find('.alert .alert-content').html(options.i18n.editMultiple);
                    }
                    else {	
					//open modal when click on edit
						$('.modalName').html('Material Type Setting');					
						$.ajax({
							type: "POST",
							url: site_url + 'inventory/material_type_edit',
							data: {id:$(selected).attr('id')}, 
							success: function(data){
								if(data != '') {
									if($('#inventory_add_modal').length){
										$('#inventory_add_modal').modal('show');
										$('#inventory_add_modal .modal-body-content').html(data);
									}else{
										$('#common_modal').modal('toggle');
										$('#common_modal .modal-body-content').html(data);
									}	
									/*validation*/
									$('form')
									.on('blur', 'input[required], input.optional, select.required', validator.checkField)
									.on('change', 'select.required', validator.checkField)
									.on('keypress', 'input[required][pattern]', validator.keypress);
										$('form').submit(function(e) {
											e.preventDefault();
											var submit = true;
											if (!validator.checkAll($(this))) {
												submit = false;
											}
											if (submit)
												this.submit();
												return false;
										});
										prefix();	
										addSubType();	
									init_select2();			
								}
							}
						});
                    }
                });
            }
            // deletable
           if (options.deletable) {
                $(easyTreeI).find('.easy-tree-toolbar').append('');
                $(easyTreeI).find('.easy-tree-toolbar .remove > button').attr('title', options.i18n.deleteTip).click(function () {
                    var selected = getSelectedItems();
					//console.log("seclected", (selected.attr('id')));
                    if (selected.length <= 0) {
                        $(easyTreeI).prepend(warningAlert);
                        $(easyTreeI).find('.alert .alert-content').html(options.i18n.deleteNull);
                    } else {
                        $(easyTreeI).prepend(dangerAlert);
                        $(easyTreeI).find('.alert .alert-content').html(options.i18n.deleteConfirmation)
                            .append('<a style="margin-left: 10px;" class="btn btn-default btn-danger confirm"></a>')
                            .find('.confirm').html(options.i18n.confirmButtonLabel);
                        $(easyTreeI).find('.alert .alert-content .confirm').on('click', function () {
							var DeleteId = $(selected).attr('id');
							
							$.ajax({
								type: "POST",
								url: site_url + 'inventory/delete_materialType',
								data: {id:$(selected).attr('id')}, 
								success: function(data){
									//console.log("data",data);
									var dataObj = JSON.parse(data);
									if(dataObj.status == 'success'){
										$(selected).find(' ul ').remove();
										if($(selected).parent('ul').find(' > li').length <= 1) {
											$(selected).parents('li').removeClass('parent_li').find(' > span > span').removeClass('glyphicon-folder-open').addClass('glyphicon-file');
											$(selected).parent('ul').remove();
										}
										$(selected).remove();
										$(dangerAlert).remove();
									}
								}
							});
							
							
                        });
                    }
                });
            } 
			
			// collapse or expand
            $(easyTreeI).delegate('li.parent_li > span ', 'click', function (e) {
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
                $(easyTreeI).find('li > span > a').attr('title', options.i18n.selectTip);
                $(easyTreeI).find('li > span > a').click(function (e) {
                    var li = $(this).parent().parent();
                    if (li.hasClass('li_selected')) {
                        $(this).attr('title', options.i18n.selectTip);
                        $(li).removeClass('li_selected');
                    }
                    else {
                        $(easyTreeI).find('li.li_selected').removeClass('li_selected');
                        $(this).attr('title', options.i18n.unselectTip);
                        $(li).addClass('li_selected');
                    }
                    if (options.deletable || options.editable || options.addable) {
                        var selected = getSelectedItems();
						//console.log("selected",selected);
						// if (options.addable) {
                         
                            // if (selected.length <= 0 || selected.length > 1  || $(selected).hasClass('ledgerName'))
                                // $(easyTreeI).find('.easy-tree-toolbar .create > button').addClass('disabled');
                            // else
                                // $(easyTreeI).find('.easy-tree-toolbar .create > button').removeClass('disabled');
                        // }
						
                        if (options.editable) {
                           // if (selected.length <= 0 || selected.length > 1 || $(selected).hasClass('mainParentName') )
                            if (selected.length <= 0 || selected.length > 1  )
                                $(easyTreeI).find('.easy-tree-toolbar .edit > button').addClass('disabled');
                            else
                                $(easyTreeI).find('.easy-tree-toolbar .edit > button').removeClass('disabled');
                        }
                        if (options.deletable) {
							var getAttr = $(selected).attr('data-id');   //attr value whose created by cid is 0
							var getUsedStatus = $(selected).attr('data-status');   //get used status value
							
                            //if (selected.length <= 0 || selected.length > 1  || $(selected).hasClass('mainParentName') || $(selected).hasClass('mainAccountName'))
                            if (selected.length <= 0 || selected.length > 1 || getAttr == 0 || getUsedStatus == 1)
                                $(easyTreeI).find('.easy-tree-toolbar .remove > button').addClass('disabled');
                            else
                                $(easyTreeI).find('.easy-tree-toolbar .remove > button').removeClass('disabled');
                        }
                    }
                   // e.stopPropagation();
                });
            }
            // Get selected items
            var getSelectedItems = function () {
				//console.log('jjjj====>>>>',$(easyTreeI).find('li.li_selected'));
                return $(easyTreeI).find('.mainParentName.li_selected');
                alert(easyTreeI);
            };
        });
    };
})(jQuery);
	
(function ($) {
        function init() {
            $('.easy-treee').EasyTree({
                addable: true,
                editable: true,
                deletable: true
            });
        }
        window.onload = init();
    })(jQuery)	
	
/************************************************************date range filter for evaluation*****************************************************************************/
$(function() {
  $('input[name="EvaluationCurrentDate"]').daterangepicker({
    opens: 'left',
	 useCurrent: true,
	  locale: {	  
	    format: 'DD-MM-YYYY',
	},
  }, function(start, end, label) {
		var filterUrl = $('#EvaluationCurrentDate').attr('data-table');
		var url = site_url +filterUrl;
		$('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
		$('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
		$.ajax({
		   type: "POST",
		   url: url,
		   data: {start:start.format('YYYY-MM-DD 00:00:00'),end:end.format('YYYY-MM-DD 23:59:59')}, 
			success: function(data){	
				$('#datatable-buttons_wrapper').html(data);	
				$('.datePick').eq(1).hide();
				$('.save').eq(1).hide();
				$('.x_content').eq(1).hide();
				getSaleCostPrice();
				
				$('.table-striped').DataTable( {
					destroy: true,
					searching: true
				});
				
				
				
			}
		});
	});  
});
/************************************************************date range filter for material***************************************************************/
$(function() {
	$('input[name="dateRangeFilters"]').daterangepicker({
    opens: 'left',
	 useCurrent: true,
	  locale: {	  
	    format: 'DD-MM-YYYY',
		},
	}, function(start, end, label) {
		var filterUrl = $('#dateRangeFilters').attr('data-table');
		var url = site_url +filterUrl;
	    $('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
		$('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
		$.ajax({
		   type: "POST",
		   url: url,
		   data: {start:start.format('YYYY-MM-DD 00:00:00'),end:end.format('YYYY-MM-DD 23:59:59')}, 
		   success: function(data){			  
		   var a = $.parseHTML(data);
		   console.log('data===>>>>',data);
				var active = $(a).find('#datatable-buttons').html();
				var inactive = $(a).find('#example').html();
				var non_inventory = $(a).find('#example_tab').html();
				$('#datatable-buttons').html(active);	
				$('#example').html(inactive);
				$('#example_tab').html(non_inventory);
				$('.table-striped').DataTable( {
					destroy: true,
					searching: true
				});
		   }
		});	
  });  
});
/**********************HSN code validation ******************/
function fnValidateHSN(Obj) { 
	$('.hsn').parent('div').siblings().remove( '.alert' );
		if (Obj.value != "") {
			ObjVal = Obj.value;
			//var gstinPat = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9]{1}?$/;
			var hsnPattern = /^(\d{4}|\d{8})$/;
			if (ObjVal.search(hsnPattern) == -1) {
				
				 $('.hsn').closest('.item').addClass('bad');				
				
				$('.hsn').closest('.item').append("<div class='alert'>Must 4 or 8 digit</div>");
				$(".signUpBtn").attr( "disabled", "disabled" );
				return false;
			}
		  else{
				$('.hsn').closest('.item').removeClass('bad');				
				$(".signUpBtn").removeAttr("disabled");
				
			  }
		}
	}
//*******************************************this function calls in date range filter************************************/
function getSaleCostPrice(){
	/*this function will run to accept only digit */
	$(".only-numbers").keydown(function(event) {
    // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||  // Allow: Ctrl+A 
        (event.keyCode == 65 && event.ctrlKey === true) || 
        // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	/*************************code to get values of cost price and sales price from valuation*******************************/
	/* this function is use d to get the column value which you want to change on focus****/
	$('[contenteditable]').on('focus', function() {
		var $this = $(this);
		var id = $(this).attr('id');
	}).on('blur', function() {
	var $this = $(this);
		if ($this.data('before') !== $this.html()) {
			if($(this).closest('.cp').html()){
				cp.push({"id": $(this).attr('id'),"costprice": $(this).closest('.cp').html()});
			}
			if($(this).closest('.sp').html()){
				sp.push({"id": $(this).attr('id'),"saleprice": $(this).closest('.sp').html()});
			}
		}
	});
}
/**************************************this code work only if there is no filteration of data************************/
		
	$(".only-numbers").keydown(function(event) {
    // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||  // Allow: Ctrl+A 
        (event.keyCode == 65 && event.ctrlKey === true) || 
        // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	/*************************code to get values of cost price and sales price from valuation*******************************/
	// var cp = [];
	// var id = [];
	// var sp = [];
	$('[contenteditable]').on('focus', function() {
		
		var $this = $(this);
		var id = $(this).attr('id');
	}).on('blur', function() {
	var $this = $(this);
		if ($this.data('before') !== $this.html()) {
			if($(this).closest('.cp').html()){
				cp.push({"id": $(this).attr('id'),"costprice": $(this).closest('.cp').html()});
			}
			if($(this).closest('.sp').html()){
				sp.push({"id": $(this).attr('id'),"saleprice": $(this).closest('.sp').html()});
			}
		}
	});
/********************************common save function run on index as well as after date filter*****************************************/
$(".save").click(function(){	
	$.ajax({
	url:site_url + "inventory/saveValuation",
	method:"POST",
	data:{cp: cp , sp:sp},
		success:function(result){
			//console.log("resutl",result);
			var data = JSON.parse(result);
			//console.log(data);
			if(data.status == 'success'){ // if true (1)
			window.location.reload(); 
			$('.save').hide();// then reload the page.(3)
			}
		}
	});	
});
function showJobCardForManufactureMaterial(val){
		if($(val).is(":checked")) {
			$('.jobCardDiv').show();
        } else {
          $('.jobCardDiv').hide();
        }
	
}
function validateActionsInInventoryListing(){
	/*validation*/
	$('form')
	.on('blur', 'input[required], input.optional, select.required', validator.checkField)
	.on('change', 'select.required', validator.checkField)
	.on('keypress', 'input[required][pattern]', validator.keypress);
		$('form').submit(function(e) {
			e.preventDefault();
			var submit = true;
			if (!validator.checkAll($(this))) {
				submit = false;
			}
			if (submit)
				this.submit();
		return false;
	});
}
$('.modal').on('hidden.bs.modal', function (e) {
    if($('.modal').hasClass('in')) {
    // $('body').addClass('modal-open');
    }    
});
/*******************MATERIAL ADD MULTIPLE LOCATION *************************************/
/*function addMultipleLocationInMaterial(){
	var max_Address     = 5; //maximum input boxes allowed
	var location_add  = $(".add_multiple_location"); //Fields wrapper
	var add_moreBtn      = $(".add_More_btn"); //Add button ID
	var logged_user = $('#loggedUser').val();
	var k = 1; //initlal text box count
	$(add_moreBtn).click(function(e){ //on add input button click
		e.preventDefault();
		var lastId, closestId;
		var total = $('.scend-tr').length;				
		$(".well").each(function(index) {					
			if (index == total){
				closestId = ($(this).attr('id'));				
				var result = closestId.split('_');				
				lastId = (parseInt(result[1]));					
			}			
		});
		k = lastId;	
		//var closestId = $(this).closest('.well').last().attr('id');
		var getUom = $("#"+closestId+"").find('.uom option:selected').text();
		var getUomid = $("#"+closestId+"").find('.uom option:selected').val();
		var measurmentArray = '';
		$.each( measurementUnits, function( key, value ) {
			measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
		});
		
		if(k < max_Address){ //max input box allowed
			k++;
			$(location_add).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid = '+logged_user+'"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Location</label><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Rack number</label><input type="text" id="rack_number" name="rackNumber[]" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Lot No.</label><select class="lotno lotno22 form-control col-md-2 col-xs-12 select2" id="mat_name"  name="lotno[]"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label >Quantity</label><input style=" border-right: 1px solid #c1c1c1 ;"type="text" id="qty" name="quantityn[]"  class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup = "getQtyValue(event,this)"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="display : none;"><select class="form-control uom" name="Qtyuom1[]" id="uom" readonly><option value="'+getUom+'">'+getUom+'</option></select> <input type="hidden" name="Qtyuom[]" value="'+getUomid+'"> </div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
			//$(location_add).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);" data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Location</label><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Rack number</label><input style="border-right: 1px solid #c1c1c1 ;" type="text" id="rack_number" name="rackNumber[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
			getArea();
			init_select2();
			init_selectlot();
		}//getAddress();
	});
	$(location_add).on("click",".delete_btn", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); k--;
	});
}*/
function addMultipleLocationInMaterial(){
	var max_Address  = 5;       //maximum input boxes allowed
	var location_add = $(".add_multiple_location");    //Fields wrapper
	var add_moreBtn  = $(".add_More_btn");      //Add button ID
	var logged_user  = $('#loggedUser').val();
	var k = 1;     //initlal text box count
	$(add_moreBtn).click(function(e){   //on add input button click
		e.preventDefault();
		var lastId;
		$(".well").each(function(index) {					
			var closestId = ($(this).attr('id'));
			var result = closestId.split('_');				
			lastId = (parseInt(result[1]));	
		});
		if(lastId > 1){
		    k = lastId;
		}
        var closestId = $(this).closest('.well').last().attr('id');
	    var getUom = $("#"+closestId+"").find('.uom option:selected').text();
	    var getUomid = $("#"+closestId+"").find('.uom option:selected').val();
		if(k < max_Address){  //max input box allowed
			k++;
			//$(location_add).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location select2-width-imp" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid = '+logged_user+'" ><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Location</label><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Rack number</label><input type="text" id="rack_number" name="rackNumber[]" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Lot No.</label><select class="lotno lotno22 form-control col-md-2 col-xs-12 select2" id="mat_name"  name="lotno[]"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label >Quantity</label><input style=" border-right: 1px solid #c1c1c1 ;"type="text" id="qty" name="quantityn[]"  class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup = "getQtyValue(event,this)"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="display : none;"><select class="form-control uom" name="Qtyuom1[]" id="uom" readonly><option value="'+getUom+'">'+getUom+'</option></select> <input type="hidden" name="Qtyuom[]" value="'+getUomid+'"> </div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
			$(location_add).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location select2-width-imp" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid = '+logged_user+'" ><option value="">Select Option</option></select></div><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label >Quantity</label><input style=" border-right: 1px solid #c1c1c1 ;"type="text" id="qty" name="quantityn[]"  class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup = "getQtyValue(event,this)"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="display : none;"><select class="form-control uom" name="Qtyuom1[]" id="uom" readonly><option value="'+getUom+'">'+getUom+'</option></select> <input type="hidden" name="Qtyuom[]" value="'+getUomid+'"> </div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
			getArea();
			init_select2();
			init_selectlot();
		}   //getAddress();
	});
	$(location_add).on("click",".delete_btn", function(e){ 
	    //user click on remove text
		e.preventDefault(); 
		$(this).parent('div').remove(); 
		k--;
	});
}
function getQtyValue(evt,t){
	//setTimeout(function(){
    	//var locationONOFF = $('#invnt_loc_on_off').val();
    	//if(locationONOFF == 1){ 
    	
        	var closestId = $(t).closest(".well").attr("id"); 
        	
        	var qty = 0; 
        	$("input[name='quantityn[]']").each(function(){
        		qty += parseFloat($(this).val());	
        	});
        	if(isNaN(qty)) qty = 0;
        	$('#opening_bal').val(qty);
        	
    	//}
	//}, 1000);	 	
}
/******************collapse row in inventory listing*******************/
 $('tr.parent td span.btn').on("click", function(){
	
    var idOfParent = $(this).parents('tr').attr('id');
    $('tr.child_'+idOfParent).toggle('slow');
  });
  $('tr[class^=child-]').hide().children('td');
/**********************get uom in inevntroy lsiting in scrap **************************/
function getUomInInventoryListing(evt, t){
		var option = $(t).find('option:selected');
		var materialId = option.val();
		//console.log(materialId);
		//var closestId = $(t).closest(".well").attr("id");
		
		$.ajax({
			type: "POST",
			url: site_url + 'inventory/getMaterialUomById',
			data: {id:materialId}, 
			success: function(data){
				if(data != '') {
					var dataObj =JSON.parse(data);
						$('.uom').val(dataObj.uom);
						$('.uomid').val(dataObj.uomid);
						
						$('.uomScrap').val(dataObj.uom);
						$('.uomid').val(dataObj.uomid);
					
				}
			}
		}); 
		
	}
	
	
/***************************************quick add material in material conversion ****************************/
function init_select221() {
	$('.materialNameId').select2({
		allowClear: true,
        placeholder: 'Material Name',
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
				$('#serchd_val').val(searched_value);
				$('#material_name').val(searched_value);
				var matID = $('.material_type_id').val();                
                $('#material_type_id').val(matID);
				
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_material_cls_name'>Add Material</span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
	});
	
}
$(document).on("click",".add_material_cls_name",function(){
	//alert('therer');
	var searched_text_val = $('#serchd_val').val();
//	var searched_text_val1 = $('#material_name').val();
	var materialId = $('#material_type_id').val();
    setTimeout(function(){  
	
    $('#materialName').val(searched_text_val);
	
    //$('#material_name').val(searched_text_val1);
    $('#material_type_id').val(materialId);
	}, 2000);
	setTimeout(function(){	
	    $('#serchd_val').val();
	}, 1000);
});
$(document).on("change",".add_material_cls",function(){
	var mat_type_id = $('#material_type').val();
	$.ajax({
			type: "POST",
			url: site_url+'inventory/Get_matrial_type/',
			data: {mat_id:mat_type_id}, 
				success: function(result) {
					 if(result != '') {
						var  objss = JSON.parse(result);
						
					    var len = objss.length;
						for(var i=0; i<len; i++){
							var id = objss[i].id;
							var name = objss[i].name;
							var prefix = objss[i].prefix;
							console.log(prefix);
							$('#matrial_Iddd').val(id);
							$('#matrial_name').val(name);
							$('#prefix').val(prefix);
							//var str_prefix = '<input type="hidden" value="'+prefix+'" >';*/
							
						}
					 }
				}
		}); 
});
$(document).on("click",".add_material_cls_name",function(){ 
 //To get Matrieal Type Ajax	
 
	 $('#myModal_Add_matrial_details').modal('show');
	 var btn_html = $(this).html();
	 $('#add_matrial_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger
 
});					
$(document).on("click",".close_sec_model",function(){
	console.log('myModal_Add_matrial_details');
	 $('#myModal_Add_matrial_details').modal('hide');
	// $('.nav-md').addClass('modal-open'); 
	 
});
$(document).on("click", ".add_material_cls_name", function () {
	var searched_text_val = $('#serchd_val').val();
	var searched_text_val1 = $('#material_name').val();
	var materialId = $('#material_type').val();
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
	var material_type_id = $('#materialtypeid').val();
	//var material_type_id  = $('#matrial_Iddd').val();
	var prefix = $('#prefix').val();
	var error = 0;
	console.log('material_name==>>', material_name);
	console.log('hsn_code==>>', hsn_code);
	console.log('uom==>>', uom);
	console.log('specification==>>', specification);
	console.log('gst_tax==>>', gst_tax);
	console.log('opening_balance==>>', opening_balance);
	console.log('material_type_id==>>', material_type_id);
	if (material_name == '') {
		$('#material_name').css('border', '1px solid #b94a48');
		$('#material_name').closest(".form-group").find("span").text('This field is required');
		var error = 1;
	} else {
		$('#material_name').css('border', '1px solid #dedede');
		$('#material_name').closest(".form-group").find("span").text('');
	}
	
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
						//mycomment
						$('.nav-md').addClass('modal-open');
					}, 1000);
					setTimeout(function () {
						//mycomment
						$('.nav-md').addClass('modal-open');
					}, 1500);
					//mycomment
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
/*********************************quick add in scrap in inventory listing************************/
function init_select21() {
	$('.scrapMateirlaName').select2({
		allowClear: true,
        placeholder: 'Material Name',
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
				$('#serchd_val').val(searched_value);
				$('#material_name').val(searched_value);
				//var matID = $('.material_type_id').val();                
				//var matID = $('#matrial_Iddd').val();                
                //$('#material_type_id').val(matID);
				//console.log()
				//return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_scrap_material'>Add Material</span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
	});
}
	$(document).on("click",".add_scrap_material",function(){
		var searched_text_val = $('#serchd_val').val();
		var materialId = $('#material_type_id').val();
		setTimeout(function(){
		    $('#materialName').val(searched_text_val);
		}, 2000);
		setTimeout(function(){	
			$('#serchd_val').val();
		}, 1000);
	});
	$(document).on("click",".add_scrap_material",function(){ 
		$('#myModal_Add_scrapMatrial_details').modal('show');
		var btn_html = $(this).html();
		$('#add_scarp_matrial_Data_onthe_spot').val(btn_html);
	});					
	$(document).on("click",".close_model",function(){
		$('#myModal_Add_scrapMatrial_details').modal('hide');
	 
	});
	
	$(document).on("click","#Add_scrap_matrial_details_on_button_click",function(){
		$('#mssg34').empty();
		var material_name  = $('#materialName').val();
		var hsn_code  = $('#hsn_code').val();
		var uom  = $('#uom_id').val();	 
		var specification  = $('#specification').val();
		var opening_balance  = $('#opening_balance_Sec').val();
		var material_type_id  = $('#materialtypeid').val();
		var prefix  = $('#prefix').val();
		console.log('material_type_id',material_type_id);
		
		var error = 0;
		if(material_name == ''){
				$('#material_name').css('border', '1px solid #b94a48');
				$('#material_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#material_name').css('border', '1px solid #dedede');
				$('#material_name').closest(".form-group").find("span").text('');
			}	
		if(error == 1) { 
			return false;
		} else {
			
		$.ajax({
			   type: "POST",
			   url: site_url+'inventory/add_matrial_Details_onthe_spot/',
			   data: {material_name:material_name,hsn_code:hsn_code,uom:uom,specification:specification,material_type_id:material_type_id,prefix:prefix,opening_balance:opening_balance},
				success: function(htmlStr) {
					//alert(htmlStr);
					   
					 if(htmlStr == 'true'){
						$('#mssg34').html('<span style="color:green;">Material Added Successfully.</span>');
						$("#insert_Matrial_data_id").trigger('reset');
						setTimeout(function(){
							
							$('#myModal_Add_scrapMatrial_details').modal('hide');
							//$('#myModal_Add_matrial_details_purchse').modal('hide');
						}, 1000);
						setTimeout(function(){
							//mycomment
							$('.nav-md').addClass('modal-open'); 
						}, 1500);						
					}else{
						$('#mssg34').html('<span style="color:red;">Not Added.</span>');
					}
					setTimeout(function(){
					$('#mssg34').html('<span> </span>');
					}, 3000);	
					
					
				}
			 });
		}
	});
	/*********************stock check in inventory listing***************************/
	$('#clickStockCheckBtn').click(function(){
	   $('.stock_check').toggle();
	});
   
	$('.physicalStock').keyup(function(e){
		//alert('pressed');
	//$('.physicalStock').bind('keyup', function(){
		var key = e.which;
		if (key == 13){ // the enter key code
		e.preventDefault();
		 $(this).parent('tr').next('tr').find('.physicalStock').focus();
		 //$(this).next('tr').focus();
			var thisRow =  $(this);
			var materialId =  $(thisRow).closest('.MainRow').find("#materialid").val();
			//console.log(materialId);return false;
			var physicalStockValue =  $(this).html();
			var closestRow = $(thisRow).closest('tr').attr('id');
			var getLocQtyValue = $(thisRow).prev().prev().find('.locQty').val();
			var locationId = $(thisRow).closest('.locRow').find('.locId').val();
			
			var calculateDiff = parseInt(getLocQtyValue) - parseInt(physicalStockValue);
			$(thisRow).closest('.locRow').find(".cal").html(calculateDiff);
			console.log('calculateDiff',calculateDiff);
		
			if(calculateDiff > 0 ){
				console.log("dededed");
				$.ajax({
					type: "POST",
					url: site_url+'inventory/inventoryflow/',
					data: {material_id:materialId,location_id:locationId,materialQty:calculateDiff,physical_stock:physicalStockValue,balance:calculateDiff},
					success: function(result) {
						if(result != '') {
							var obj = $.parseJSON(result);
							if(obj.status == 'success') {					 
								window.location.reload();
						   } 
						}
					}	
				});
			}else{
				$.ajax({
					type: "POST",
					url: site_url+'inventory/inventoryflow/',
					data: {material_id:materialId,location_id:locationId,materialQty:calculateDiff,physical_stock:physicalStockValue,balance:calculateDiff},
					success: function(result2) {
						if(result2 != '') {
							var obj1 = $.parseJSON(result2);
							if(obj1.status == 'success') {					 
								window.location.reload();
						   } 
						}
					}	
				});
			}
		}
		/* $.ajax({
		   type: "POST",
		   url: site_url+'inventory/inventoryflow/',
		   data: {material_id:materialId,location_id:locationId,'},
			success: function(htmlStr) {
				//alert(htmlStr);
				   
				 
				
			}
		});	 */
		/* var thisRow =  $(this);
		var physicalStockValue =  $(this).html();
		var getQtyValue = $(thisRow).closest('.MainRow').find(".qty").html();
		
		var calculateDiff = parseInt(getQtyValue) - parseInt(physicalStockValue);
		$(thisRow).closest('.MainRow').find(".cal").html(calculateDiff); */
		
		
	})
	
	$(".only-numbers").keydown(function(event) {
    // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||  // Allow: Ctrl+A 
        (event.keyCode == 65 && event.ctrlKey === true) || 
        // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
			}
		});
	
	/*********************************stock check end*********************************/
	
	/**************in hidden get selected option address in move and consumed**********************/
	function getAddressData(t,evt){
		var closestId = $(t).parent().closest('tr').attr('id');	
		var matLocId = $("#"+closestId).find('#matLocId').val();
		var loc = $("#"+closestId).find('#address22').val();		
		var rackno = $("#"+closestId).find('#rack_number').val();
		var lot_no = $("#"+closestId).find('#lot_no').val();		
		var ar = $("#"+closestId).find('#area').val();
		var qty = $("#"+closestId).find('#quantity').val();
		var uom = $("#"+closestId).find('#Qtyuom').val();
		$('#selctedAddrId').val(matLocId);
		$('#selctedAddr').val(loc);
		$('#selctedArea').val(ar);
		$('#selectedRack').val(rackno);
		$('#selectedLotNo').val(lot_no);
		$('#selectedQty').val(qty);
		$('#selectedUom').val(uom);
	}
	/******************************end*******************************************/
	/*****************get qunatity conditon on move and consumed based on selected address qty************/
	function getQuantity(t,evt){
		var qty = $(t).closest('.well').find('#qty').val();
		var consumedQty = $('#qty').val();
		var selectedQty = $('#selectedQty').val();
		if(selectedQty == ''){
			$('#message').html('Selected Source Address Qty Is Empty'); 
			$('.check_mat_qty').attr("disabled", "disabled");
		}
		else if((parseInt(selectedQty) < parseInt(qty)) || (parseInt(selectedQty) <= 0) || (parseInt(selectedQty) < parseInt(consumedQty))) { 
			$('#message').html('The Available Quantity is  ' + selectedQty + ' please enter the quantity between 0 and '+ selectedQty); 
			$('.check_mat_qty').attr("disabled", "disabled");
		}else{
			$('#message').empty();
			$('.check_mat_qty').removeAttr("disabled");
		}
	}
	
	/******************print in inventory material*******************/
// 	 function Print_data_new(){
// 	window.onload = function(){ 					   
// 		document.getElementById("btnPrint").onclick = function () {		 
// 			printDiv(document.getElementById("print_divv"));
// 			var modThis = document.querySelector("#print_divv");			
// 		 	function printDiv(div) {			
// 				// Create and insert new print section
// 				var elem = document.getElementById('print_divv');
// 				var domClone = elem.cloneNode(true); 
// 				var $printSection = document.createElement("div");
// 				$printSection.id = "printSection";
// 				$printSection.appendChild(domClone);
// 				document.body.insertBefore($printSection, document.body.firstChild);
// 				window.print();
// 				// Clean up print section for future use
// 				var oldElem = document.getElementById("printSection");
// 				if (oldElem != null) { oldElem.parentNode.removeChild(oldElem); }
// 									  //oldElem.remove() not supported by IE
// 				return true;
// 			}
// 		}	    
// 	};
// }
function Print_data_new() {
$(document).on("click", "#btnPrint", function() {
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
});
}
	/************************Delete on Select****************************************/
  $(document).ready(function() {
                resetcheckbox();
                $('#selecctall').click(function(event) {  //on click
                    if (this.checked){ // check select status
                        $('.checkbox1').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"              
                        });
                    } else {
                        $('.checkbox1').attr("disabled", false).each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                        });
                    }
                });
$("#del_all").on('click', function(e) {
     if(confirm('Are You Sure!') == true){
                    e.preventDefault();
                    //var datamsg = $(this).attr('data-msg'); 
                    var tablename1 = document.getElementById("table");
                    var tablename = document.getElementById("table").value;
                    var datamsg = tablename1.getAttribute('data-msg');
                    var datapath = tablename1.getAttribute('data-path');
                    var checkValues = $('.checkbox1:checked').map(function() {
                        return $(this).val();
                    }).get();
                    console.log(checkValues);                    
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                    });
                    var ai =    $(".checkbox1:checked").map(function () {
                                      return $(this).data('ai')
                                }).get();
                    //  console.log('value if ai====>>>>>',ai);
                    $.ajax({
                        url: site_url+'inventory/deleteall/',
                        type: 'post',
                        data: {tablename:tablename, checkValues:checkValues , datamsg:datamsg}
                    }).done(function(data) {
                       window.location.href = site_url+datapath;
                        $('#selecctall').attr('checked', false);
                    });
                    }
                    else{
                $('input:checkbox').each(function() { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                          });
                    }
        });
	             function  resetcheckbox(){
                  $('.checkbox1').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                });
             }
 }); 
  /*******************************FAVOURITES IN Inventory ***************************/
$(".star-1").on('change', function(e) {
          var tablename1 = document.getElementById("favr");
                    var tablename = document.getElementById("favr").value;
                    var datamsg = tablename1.getAttribute('data-msg');
                  //  var favourite = tablename1.getAttribute('favour-sts');;
                    var datapath = tablename1.getAttribute('data-path');
          if ($(this).is(':checked')) {
                      var  favourite = 1;
                      var datamsgq = 'Marked'
                    } else { 
                     var   favourite = 0;
                     var datamsgq = 'Unmarked'
                    } 
                  var datamsgs = datamsg +''+ datamsgq;
                    var checkValues = $(this).val();
                    $.ajax({
                        url: site_url+'inventory/markfavourite/',
                        type: 'post',
                        data: {tablename:tablename, checkValues:checkValues , datamsg:datamsgs , favourite:favourite}
                    }).done(function(data) {
                       window.location.href = site_url+datapath;
                        $('.star-1').attr('checked', false);
                    });
  });
  
  /***************************scroll in inventory listing material type *****************************/
  var hidWidth;
var scrollBarWidths = 40;
var widthOfList = function(){
  var itemsWidth = 0;
  $('.list a').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
 
 getdata();
  return itemsWidth;
};
var widthOfHidden = function(){
  return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
};
var getLeftPosi = function(){
  //return $('.list').position().left;
};
var reAdjust = function(){
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show().css('display', 'flex');
  }
  else {
    $('.scroller-right').hide();
  }
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show().css('display', 'flex');
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	$('.scroller-left').hide();
  }
}
reAdjust();
$(window).on('resize',function(e){  
  	reAdjust();
});
$('.scroller-right').click(function() {
  
  $('.scroller-left').fadeIn('slow');
  $('.scroller-right').fadeOut('slow');
  
  $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){
  });
});
$('.scroller-left').click(function() {
  
	$('.scroller-right').fadeIn('slow');
	$('.scroller-left').fadeOut('slow');
  
  	$('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
  	
  	});
});
/***************Add active class in inventory listing *************/
$('.get_data_btnwip').click(function(){
     $(".get_data_btnwip").removeClass("active");
    $(this).addClass("active");
    var id = $(this).attr('id');
    	company_unit = "";
		$('#processing-modal').modal('toggle'); //before post
			// Post data 
			setTimeout(function () {
				$('#processing-modal').modal('hide'); // after post
				$('body').removeClass('modal-open');
				$('.modal-backdrop').remove(); 
			}, 500);
    $.ajax({
           	url: site_url+'inventory/inventory_listing_and_adjustment/',
         	type: 'POST',
         	data: {value:id,company_unit:company_unit,ajax_var:'via_ajaxwip'},
           	success: function(result2) {
           		console.log("hjbflkjbsad=>>>>>",result2);
           				if(result2 != '') {
							html = $.parseHTML( result2 ),
							  nodeNames = [];
							$('.eewip').empty();
							$('.eewip').append( html );	
							$('#mat_id').val(id);
							$.each( html, function( i, el ) {
							  nodeNames[ i ] = "<li>" + el.nodeName + "</li>";
							});
							setTimeout(function(){
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
							}, 500);	
						}
						else{
							$(".eewip").empty();
							var result2 = "No Data Available";
							html2 = $.parseHTML( result2 ),
							$('.eewip').append( html2 );
							setTimeout(function(){
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
							}, 500);	
						}
						//alert('hmm');
						stock_checkk_fun();
						ediit_click_fun();
						
					}	
          });
 
});	
function stock_checkk_fun(){
	$('.physicalStock').on('keyup', function (event) {
		//console.log('physicalStock');
		if (event.keyCode === 13) {  //the enter key code
			$(this).parent('tr').next('tr').find('.physicalStock').focus();
			var thisRow = $(this);
			var materialId = $(thisRow).closest('.MainRow').find("#materialid").val();
			var physicalStockValue = $(this).html();
			var closestRow = $(thisRow).closest('tr').attr('id');
			var matLocId = $(thisRow).closest('.locRow').find('.matLocId').val();
			var locationId = $(thisRow).closest('.locRow').find('.locId').val();
			var getLocQtyValue = $(thisRow).prev().prev().find('.locQty').val();
			var calculateDiff = parseInt(getLocQtyValue) - parseInt(physicalStockValue);
			$(thisRow).closest('.locRow').find(".cal").html(calculateDiff);
			var closing_blnc = $(thisRow).closest('.MainRow').find(".qty").html();
			var blnce_col = parseInt(closing_blnc) - parseInt(calculateDiff);
			$(thisRow).closest('.MainRow').find(".qty").html(blnce_col);
			//console.log('calculateDiff',calculateDiff);
			if(calculateDiff > 0 ){
				$.ajax({
					type: "POST",
					url: site_url+'inventory/inventoryflow/',
					data: {material_id:materialId,location_id:locationId,materialQty:calculateDiff,physical_stock:physicalStockValue,balance:calculateDiff,matLocId:matLocId},
					success: function(result){
						//console.log('result',result);	
						if(result != '') {
							var obj = $.parseJSON(result);
							if(obj.status == 'success') {					 
								window.location.reload();
						   } 
						}
					}	
				});
			}else{
				$.ajax({
					type: "POST",
					url: site_url+'inventory/inventoryflow/',
					data: {material_id:materialId,location_id:locationId,materialQty:calculateDiff,physical_stock:physicalStockValue,balance:calculateDiff,matLocId:matLocId},
					success: function(result2){
						if(result2 != '') {
							var obj1 = $.parseJSON(result2);
							if(obj1.status == 'success') {					 
								window.location.reload();
						   } 
						}
					}	
				});
			}
		}
	});
}
function ediit_click_fun(){
	$(document).on('click', '.check_neee', function(){
	   setTimeout(function () {
		  $('#inventory_listing_mat_side').val('listing_side');
		  }, 1000);
		} );
}
function close_modal_Script(){
	$('.close_modal2').click(function(){
	 setTimeout(function(){	
	   $("body").removeClass("modal-open");
	   }, 1000);
	});
}
// /*chang statsu in worker*/
$(document).on('change', '.change_status_lot', function(){
	var uomStatus;	
	var checkbox =	$(this).attr('checked', true);
	if(checkbox.context.checked == true) uomStatus = 1;
	else uomStatus = 0;
	var id = $(this).attr("data-value");
	
		$.ajax({				
			url: site_url + 'inventory/change_status_lot/',			
			dataType: 'json',
			type: 'POST',
			data: {
				'id': id,
				'lotStatus': uomStatus,
			},	
			success: function(data){
				console.log("njnjnjnnjnj==>>",data);
				if(data == true) {
				location.reload();
				}
			}
		});
});
$(document).ready( function () {
   	$('#example084').DataTable({
		"info": false,
		"searching": false,
		"order": [[ 0, 'desc' ]],
	});
} );
$(document).ready( function () {
    $('#example08424').DataTable();
} );
$(document).ready( function () {
    $('#mytable').dataTable({
		"pageLength": 50,
		 "order": [[ 0, "desc" ]]
	});
    $('#archivedLotTable').dataTable({
		"pageLength": 10,
		 "order": [[ 0, "desc" ]]
	});
});
$(document).on('click', '.inventory_tabs_click', function(){
	$('#messagee').html('');
	var x = confirm("Are you sure you want Create PI ");
	if (x == true){
	var matrial_select_this_val =  $(this);
	var jsondt = $(this).closest('td').find("input[name='jsondt']").val()
	var cmpid = $(this).closest('td').find("input[name='compnynme']").val()
	var dptid = $(this).closest('td').find("input[name='department']").val()
	//console.log("rfrfrfrfrf=>>>>>",JSON.stringify(jsondt));
	// var requried_totl_ordr = $(matrial_select_this_val).closest('.row_selectd').find("input[name='totl_ordr']").val();
	// var uom_selected_id = $(matrial_select_this_val).closest('.row_selectd').find("input[name='uom_selected_id']").val();
	//alert(requried_mat_id);
	$.ajax({
		   type: "POST",
		   url: site_url+'inventory/convert_to_pi_through_MRP/',
		   data: {jsondt:jsondt,cmpid:cmpid,dptid:dptid}, 
		   	success: function(htmlStr) {
			if(htmlStr == 'true'){
				location.reload();
				// $('#messagee').html('PI Created Successfully Please Check Purchase Module');
				//  setTimeout(function () {
    //                  $('#messagee').hide();
    //              }, 2500);
			}
		}
	});
	}	  
});
$(document).on("click","#export-menu1 li1",function(){ 
		var target = $(this).attr('id');
		// alert(target);
			switch(target) {  
                case 'export-to-excel' :
                $('#hidden-type').val(target);
                // alert($('#hidden-type').val());
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
function get_order(){
 $('#orderby').submit();	
}
//Add More Suplier for adding bills
function init_select_forAdd_uom() {
		$('#uomid').select2({
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
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_uom'>Add UOM</span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
    });
	
}
$(document).on("click",".add_more_uom",function(){
	
	 $('#myModal_Add_uom').modal('show');
});
//To close Add supplier Popup Model
$(document).on("click",".close_sec_model",function(){
	console.log('myModal_Add_uom');
	 $('#myModal_Add_uom').modal('hide');
}); 
//Supplier Add Function
$(document).on("click","#add_uom_btn_id",function(){
	var uom_quantity  = $('#uom_quantity').val();
	var uom_quantity_type  = $('#uom_quantity_type').val();
	var ugc_code  = $('#ugc_code').val();
	//alert(country);
	var error = 0;
		if(uom_quantity == ''){
				$('#uom_quantity').css('border', '1px solid #b94a48');
				$('#uom_quantity').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#uom_quantity').css('border', '1px solid #dedede');
				$('#uom_quantity').closest(".form-group").find("span").text('');
			}
		if(uom_quantity_type == ''){
				$('#uom_quantity_type').css('border', '1px solid #b94a48');
				$('#uom_quantity_type').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#uom_quantity_type').css('border', '1px solid #dedede');
				$('#uom_quantity_type').closest(".form-group").find("span").text('');
			}
		if(ugc_code == ''){
				$('#ugc_code').css('border', '1px solid #b94a48');
				$('#mailing_address').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#ugc_code').css('border', '1px solid #dedede');
				$('#ugc_code').closest(".form-group").find("span").text('');
			}	
		
		if(error == 1) { 
			return false;
		} else {
		$.ajax({
				   type: "POST",
				   url: site_url+'inventory/add_uom_detials_on_the_spot/',
				   data: {uom_quantity:uom_quantity,uom_quantity_type:uom_quantity_type,ugc_code:ugc_code}, 
				   success: function(htmlStr) {
					   if(htmlStr == 'true'){
						$('#mssg').html('<span style="color:green;">Added Successfully.</span>');
						$("#insert_uom_data_id").trigger('reset');
						setTimeout(function(){
							$('#myModal_Add_uom').modal('hide');
						}, 1000);
						setTimeout(function(){
							//mycomment
							$('.nav-md').addClass('modal-open'); 
						}, 1500);		
					}else{
						$('#mssg').html('<span style="color:red;">Not Added.</span>');
					}
				}
			 });
		}
  
});
function actve_mat_form(){
	$('#active_mat_form').submit();
}
function noninvtry_mat_form(){
	$('#noninery_mat_form').submit();
		
}
function inactve_mat_form(){
	$('#inactive_mat_form').submit();
}
/* third Party Inventory View Script */
$(document).on("click",".view_third_party_view_tabs",function(){
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		switch (tab) {  
			case 'third_party_view_details':
				url = 'inventory/view_third_party_details';
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
				//alert(data);
				setTimeout(function(){
					//mycomment	
				   $("body").addClass("modal-open"); 
			   }, 1000);
					$('#challan_add_modal').modal('toggle');
					$('#challan_add_modal .modal-body-content').html(data);		
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
/* third Party Inventory View Script */
function getMaterialOfWorkOrder(current,divId = ""){
 	var workOrderIds = [];
    $("#"+current+ " :selected").map(function(i, el) {    	
        workOrderIds.push($(el).val());
        //return $(el).val();
    }).get();
    $.ajax({
    	url: site_url + 'inventory/GetSaleOrderID/',
    	dataType: 'json',
    	type: "POST",
    	data:{
    		'id': workOrderIds
    	},
    	success: function(data){
    		var result = current.split('_');  
            var div_len = result[1];     
            if( data ){
    	       	$('#chkIndex_'+div_len).find('#work_order_product').html(data.html);
            }
    	}
    });
}
/*
$(document).on('change','#multipleSelect',function(){
     var workOrderIds = [];
     $("#multipleSelect :selected").map(function(i, el) {    	
		workOrderIds.push($(el).val());
	    //return $(el).val();
	 }).get();
    //alert(workOrderIds);
	  $.ajax({
			url: site_url + 'inventory/GetSaleOrderID/',
			dataType: 'json',
			type: "POST",
			data:{
				'id': workOrderIds
			},
			success: function(data) {
				//console.log(data);
			       if( data ){
					//htmlData = JSON.parse(data)
					$('#work_order_product').html(data.html);
					  
			 	}
				
			  }
      });
});
*/
$(document).on('change','#work_order_product',function(){
    var productId = $(this).val();
    var getPara = $(this);
    var workOrderIds = $(getPara).closest('.well').find('.WorkOrderId :selected').val();
    var closestId = $(this).closest(".well").attr("id");
    result = closestId.split('_');
    var div_len =result[1];
    $.ajax({
    		url: site_url + 'inventory/Getjobcardvalue/',
    		dataType: 'json',
    		type: "POST",
    		data:{
    			'workOrderIds': workOrderIds,
    			'productId': productId,
    			'noofrow':div_len
    		},
    		success: function(data) {
    		  	var bsb='#chkIndex_'+div_len;
    		    if( data ){  
    		       	//alert('#chkIndex_'+div_len);
    				$('#chkIndex_'+div_len).find('.jobcard_product').html(data.html);
    				
                    addmoredataRM();
    				validateActionsInInventoryListing();
    				init_select2();
    				init_select221();
    				getMaterialName();
    				getVarientOption();
    				addMaterialDetail();
    				dateFunction();
    				getUOMinmaterialconvrs();
    				addLocationInConversion();
    				getQuantityinconversion();
    				addMoreProductincoversion();										
    				getArea();
    				getAddressData();
    				init_selectlot();
    				function_to_check_qty_in_listing();
    				getMaterialQuantites();
    				on_change_Work_order();
    				keyup_function_to_check_qty();
    		 	}  
    	  	 }
       });
    });
 function on_change_Work_order(evt, t){
	var WorkOrderId = $(t).find('option:selected').val();
		$.ajax({
			type: "POST",
			url: site_url + 'inventory/getWorkOrderDetail',
			data: {id:WorkOrderId}, 
			success: function(data){
				var getJobcardData = jQuery.parseJSON(data);
				console.log(getJobcardData);
					//var getJobcardData =  JSON.parse(obj[0].product_detail);
						var len = getJobcardData.length;
						
						var quantity = '';
						var uom = '';
						var material_detail ='';
							for(var i=0; i<len; i++){
								var material_name_id = '';
								material_name_id = getJobcardData[i].product;
							//	alert(material_name_id);
								quantity = getJobcardData[i].transfer_quantity;
								uom = getJobcardData[i].uom;
								//job_card = getJobcardData[i].job_card;
							//	alert(material_name_id);
								$.ajax({       //again call ajax to get material name based on material id 
									async: false,
									type: "POST",
									url: site_url + 'inventory/getMaterialNameById_check',
									data: {material_name_id:material_name_id}, 
									success: function(data1){
									var dataObj = "";	mat = ""; uom_named = ""; job_card_no = "";job_card_name = "";
									var dataObj = JSON.parse(data1);
										mat = dataObj.material_name;	
										uom_named = dataObj.uom_name;
										job_card_no = dataObj.job_card;
										job_card_name = dataObj.job_card_no;
									}
								});
								material_detail += '<div class="materialDiv mobile-view"><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="mate">Product name</label><input type="hidden" id="material_name" name="material_name_id['+WorkOrderId+'][]" class="form-control col-md-7 col-xs-12"  placeholder="Product name" value="'+ material_name_id +'"><input readonly type="text" id="material_name" name="material_name['+WorkOrderId+'][]" class="form-control col-md-7 col-xs-12"  placeholder="Product name" value="'+ mat +'"></div><div class="col-md-2 col-sm-6 col-xs-12 qtyValue form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</label><input type="text"  id="quant" name="quantity['+WorkOrderId+'][]"  class="form-control col-md-7 col-xs-12 qty" placeholder="quantity" value="'+quantity+'" ></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Uom">UOM</label><input type="hidden" id="uom" name="uom['+WorkOrderId+'][]" class="form-control col-md-7 col-xs-12 uom"  placeholder="uom" value="'+uom+'" style="width:100%;"><input type="text"  name="uom1[]" class="form-control col-md-7 col-xs-12 uom"  value="'+uom_named+'" ></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Uom">Job Card</label><input type="text"  name="job_card['+WorkOrderId+'][]" class="form-control col-md-7 col-xs-12 uom"  placeholder="job_card" value="'+job_card_name+'" style="width:100%;" readonly><input type="hidden"  name="job_card_no['+WorkOrderId+'][]" value="'+job_card_no+'" ></div><div class="col-md-2 col-sm-6 col-xs-12 outputDiv form-group" style="border-right:1px solid #c1c1c1 !important;"><label class="col-md-12 col-sm-12 col-xs-12" for="output">Output</label><input type="text" required="required" id="output" name="calculatedOutput['+WorkOrderId+'][]" class="form-control col-md-7 col-xs-12 output"  placeholder="Output" value=""></div></div>';	
								
							}
							setTimeout(function(){
								var sum = 0;
								$('.qty').each(function() {
									sum += Number($(this).val());
								});	
									$("#total_Qty_Amount").val(sum);
							}, 1000);	
							var closestWell = $(t).closest('.well');
							$(closestWell).find('.input_holder').html(material_detail);
													
			}
		});
 }
/*****************add more finish goods ***************/
function addmore_finish_workorder(){
	var maxValue     = 10; //maximum input boxes allowed
	var added_field  = $(".recv_finish_goods_add"); //Fields wrapper
	var add_more_btn      = $(".addmore_finish_workorder"); //Add button ID
	var k = 1; //initlal text box count
	var logged_user = $('#loggedUser').val();
	$(add_more_btn).click(function(e){ //on add input button click
	    // getAddress();
		e.preventDefault();
		var data_where = $('.WorkOrderId').attr('data-where');
		var work_order_id = $('.WorkOrderId').val();
		if(k < maxValue){ //max input box allowed
			k++;
			//$(added_field).append('<div class="panel panel-default" style="overflow: hidden; padding-bottom: 35px;"><div class="col-md-12 middle-box2"><div class="well "  style="overflow:auto;" id="chkIndex_'+k+'"><div class="item form-group top-fild col-md-10 col-xs-12 col-sm-12 vertical-border"><div class="control-label col-md-3 col-sm-3 col-xs-12" for="mat_name">Work Order</div><div class="col-md-3 col-sm-6 col-xs-12"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" required="required"  name="work_order_id[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="on_change_Work_order(event,this)" aria-hidden="true" data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12"><input type="text" id="total_Qty_Amount" name="total_Qty_Amount[]" class="form-control col-md-7 col-xs-12 totalQtyAmount"  placeholder="Quantity in total" value="" ></div></div><div class="item form-group  mobile-view2" style="border-top:1px solid #c1c1c1 !important; clear: both;"><div class="col-md-3 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="mate">Product name</label></div><div class="col-md-2 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</label></div><div class="col-md-2 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Uom">UOM</label></div><div class="col-md-3 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="qty">Job Card</label></div><div class="col-md-2 item form-group" style="border-right:1px solid #c1c1c1 !important;"><label class="col-md-12 col-sm-12 col-xs-12" for="output">Output</label></div></div><div class="item form-group"><div class="col-md-12 form-group"><div class="col-md-12 input_holder form-group" id="input_holder"></div></div></div><div class="item form-group"><div class="col-md-2 col-sm-6 col-xs-12"><input type="hidden" id="total_qty" name="total_qty" class="form-control col-md-7 col-xs-12"  placeholder="Total Quantity" value="" ></div></div></div></div><button style="margin-left: 10px;" class="btn btn-danger delete_finish_goods_div" type="button"><i class="fa fa-minus"></i></button></div>');
			
			$(added_field).append('<div class="panel panel-default" style="overflow: hidden; padding-bottom: 35px;"><div class="col-md-12 middle-box2"><div class="well "  style="overflow:auto;" id="chkIndex_'+k+'"><div class="item form-group top-fild col-md-10 col-xs-12 col-sm-12 vertical-border"><div class="control-label col-md-3 col-sm-3 col-xs-12" for="mat_name">Work Order</div><div class="col-md-3 col-sm-6 col-xs-12"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible select2 WorkOrderId" required="required"  name="work_order_id[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" onchange="on_change_Work_order(event,this),updateWorkOrderForScrap(event,this)" aria-hidden="true" data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12"><input type="text" id="total_Qty_Amount" name="total_Qty_Amount[]" class="form-control col-md-7 col-xs-12 totalQtyAmount"  placeholder="Quantity in total" value="" ></div></div><div class="item form-group  mobile-view2" style="border-top:1px solid #c1c1c1 !important; clear: both;"><div class="col-md-3 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="mate">Product name</label></div><div class="col-md-2 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="qty">Quantity</label></div><div class="col-md-2 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="Uom">UOM</label></div><div class="col-md-3 item form-group"><label class="col-md-12 col-sm-12 col-xs-12" for="qty">Job Card</label></div><div class="col-md-2 item form-group" style="border-right:1px solid #c1c1c1 !important;"><label class="col-md-12 col-sm-12 col-xs-12" for="output">Output</label></div></div><div class="item form-group"><div class="col-md-12 form-group"><div class="col-md-12 input_holder form-group" id="input_holder"></div></div></div><div class="item form-group"><div class="col-md-2 col-sm-6 col-xs-12"><input type="hidden" id="total_qty" name="total_qty" class="form-control col-md-7 col-xs-12"  placeholder="Total Quantity" value="" ></div></div></div><hr><div class="item form-group"><label style="border-top: 1px solid #c1c1c1;border-right: 1px solid #c1c1c1;margin-bottom:15px;text-align:center" class="control-label col-md-3 col-sm-3 col-xs-12" for="scrap">Scrap Value</label><div class="col-md-12 col-sm-12 col-xs-12 scrap_input_fields_wrap"><div class="col-md-12 input_scrap_holder"><div class="well scrapWell" id="chkScarpIndex_1" style="overflow:auto;"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style="border-top: 1px solid #c1c1c1 !important;">Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="scrap_material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+logged_user+' OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style="border-top: 1px solid #c1c1c1 !important;">Material Name</label><select required="required" class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="scrap_material_name[]" onchange="getScrapUom(event,this);" id="mat_name"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style="border-top: 1px solid #c1c1c1 !important;">Quantity</label><input type="text" name="scrap_quantity[]" required="required" class="form-control col-md-7 col-xs-12  qty actual_qty keyup_event" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"> </div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1 !important;border-top: 1px solid #c1c1c1 !important;">UOM</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="scrap_uom_value1[]" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="" readonly><input type="hidden" name="scrap_uom_value[]" class="uomid" readonly value=""> </div><input type="hidden" name="work_order_detail_id[]" class="__workOrderId" value="'+work_order_id+'"></div><div class="col-sm-12 btn-row"><div class="input-group-append"><button class="btn edit-end-btn addScrapButton" type="button">Add Scrap</button></div></div></div> </div></div></div><button style="margin-left: 10px;margin-top: 15px;" class="btn btn-danger delete_finish_goods_div" type="button"><i class="fa fa-minus"></i></button> </div>');
			
			init_select2();
		}
		
	});
	$(added_field).on("click",".delete_finish_goods_div", function(e){ //user click on remove text
		e.preventDefault(); 
		$(this).parent('div').remove();
		k--;
	});
}
$(document).on("click","#submittt",function(){
	//var mat_type_id = $('#material_type').val();
	 var branch = $('#branch option:selected');
	 var material_type = $('#mattyp option:selected'); 
	 var material_subtype = $('#material_subtype option:selected'); 
	 var report_id = $('#record_id').val();
	 // console.log("branch==>>>>>",branch.val());
	 // console.log("material_type=>>>>>>>",material_type.val());
	 // console.log("material_subtype=>>>>>>>",material_subtype.val());
	$.ajax({
			type: "POST",
			url: site_url+'inventory/generate_reorder_level_report/',
			data: {branch:branch.val(),material_type:material_type.val(),material_subtype:material_subtype.val(),report_id:report_id}, 
						success: function(data) {	 
					    setTimeout(function(){  
						    $(".bs-example-modal-lg").modal("hide");
							}, 500);
							setTimeout(function(){	
							   $('#inventory_add_modal').modal('show');
								$('#inventory_add_modal .modal-body-content').html(data);
							}, 600);
		  }
		}); 
});
function keyupFunc(evt , t){
		var closestId = $(t).closest(".well").attr("id");
		console.log("jncjndcjkdncjd=>>>>>>>",closestId);
		var qty , amount;
		qty = parseFloat($("#"+closestId+" input[name='quantity[]'").val());
		expected_amnt = parseFloat($("#"+closestId+" input[name='expected_amount[]'").val());
			if(isNaN(expected_amnt)) {
				var expected_amnt = 0;
			}
		total_amnt = parseFloat(qty) * parseFloat(expected_amnt);
		if(isNaN(total_amnt)) total_amnt = 0;
	var valueww = total_amnt.toFixed(2);
		$("#"+closestId+" input[name='sub_total[]'").val(valueww);
		Grandtotal();
		remove_calculation_purchase_indent();
	}
function Grandtotal() {
	var grandtot = 0;
	$("input[name='sub_total[]']").each(function(){
		grandtot += parseFloat($(this).val());
	});
	console.log("jdncjdncl=>>>>>>",grandtot);
	$("#grandTot").val(grandtot.toFixed(2));
	
	/**************display of budget available and spent in PI**********/
	var getGrandTotal = $("#grandTot").val();
	var getSelectedMaterialType = $('.materialTypeId').find('option:selected').val();
	$.ajax({
			type: "POST",
			url: site_url + 'purchase/getBudgetByMaterialTypeId',                       //get budget value ccrdng to materialType from material Type table
			data: {id:getSelectedMaterialType}, 
			success: function(data){
				if(data != '') {			
					var dataObj =JSON.parse(data);
					var budgetValue = dataObj.budget;
					var Total = dataObj.Total;
					if(Total == null){
					   var Total = 0;
					}
					if(parseInt(getGrandTotal) > parseInt(budgetValue)){
						$('.msg1').html("Available Budget = " + budgetValue);
						$('.msg2').html("Budget Spent = " + Total);
						setTimeout(function() { 
						$('.msg1').html('');
						$('.msg2').html('');
							// $('.msg1').slideUp('slow');
							// $('.msg2').slideUp('slow');
							// $('.msg1').css('display','block');
							// $('.msg2').css('display','block');
						}, 5000); 
					}
				}
			}
		}); 
	/******************code end******************************/		
}
function remove_calculation_purchase_indent(){
		var grand_total_val = $('#grandTot').val();
		 if(grand_total_val == 0 || grand_total_val == ''){
			  $(':input[type="submit"]').prop('disabled', true);
		 }else{
			 $(':input[type="submit"]').prop('disabled', false);
		 }
}
function getDept(evt,t){ 
  $('.department').empty('');
  //alert("fff");
  var logged_user = $('#loggedUser').val();
  
  if(window.location.href == site_url+'production/production_planning' ){
      $(".app_div_planing").html('');
  }else if(window.location.href == site_url+'production/production_data'){
    $(".app_div").html('');
  }
  var selected_unit_name = $(t).find('option:selected').val();
  $('.department').attr('data-where',' created_by_cid='+logged_user+' AND unit_name = "'+selected_unit_name+'"');
  $('.department').attr('data-id','department');
  $('.department').attr('data-key','id');
  $('.department').attr('data-fieldname','name');
}		
function getAddress1(){
	$('.address1').select2({
			allowClear: true,
			placeholder: 'Select Address',
			closeOnSelect: true,
			ajax: {
				url: site_url+'/inventory/getAddress',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						q: params.term
					};
				},	  
			processResults: function (data) {
				if(data){
					return {
					  results: data
					};					
				}
			},
				cache: true,
			 }
	});
	var delivery_address = $('#delivery_address1 option:selected').attr('data-id');
		$("#delivery_address1").val(delivery_address);		
        $('.address1').trigger('change');	
}
function GetMonthlyProductionData(){
   $(document).on("click","#SearchButton",function(){ 
   	 var company = $('.compny_unit').val();
	 var department = $('.department').val();
	 var selected_month = $('.Selectedmonth').val();
   	$.ajax({
			type: "POST",
			url: site_url+'inventory/get_mrp_monthvise/',
			data: {company:company,department:department,selected_month:selected_month}, 
						success: function(data) {
							$('#inventory_add_modal .ee').html(data);
							$('.ert').empty();
						 console.log("jejejejej==>>>>",data);	 
						$('#example084').DataTable();
						$('#ProductionReportDataTable-select-all').on('click', function(){
					      // Get all rows with search applied
					      //var rows = table.rows({ 'search': 'applied' }).nodes();
					      // Check/uncheck checkboxes for all rows in the table
					      $('input[type="checkbox"]').prop('checked', this.checked);
					   });
						var table = $('#example084').DataTable();
			if ( ! table.data().any() ) {
				console.log("kmkmkmkk=>>>>");
			 $('#submt').attr("disabled", "disabled");   
			}
			else{
				console.log("dldldldldld=>>>>");
				 $('#submt').removeAttr("disabled");     
			}
						//var table = $('#example084').DataTable();
		  }
		}); 
   });					
}
 $(document).ready(function(){
    $(".monthPicker").datepicker({ 
        dateFormat: 'mm-yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function(dateText, inst) {  
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
            $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
        }
    });
});
function FORMVALIDATE(event) {
	event.preventDefault();
	// 	var checkBoxes = document.getElementsByClassName( 'workOrderIDscheckbox' );
	// 	var isChecked = false;
	// 	for (var i = 0; i < checkBoxes.length; i++) {
	// 		if ( checkBoxes[i].checked ) {
	// 			isChecked = true;
	// 		};
	// 	};
	// if ( !isChecked ) {
	// 	 $('#result').html('<div class="alert alert-error col-md-6">Please, check at least one checkbox!</div>');
	// 	 event.preventDefault();
	// 		return false;
	// 		//alert( 'Please, check at least one checkbox!' );
	// 	}
		var bool = true;
		$.ajax({
				type: "POST",
				async: false,
				url: site_url+'production/checkmonthlymrp/',
				data : {
				   searchCompnyUnit : $('.compny_unit').val(),
				   searchDepartment : $('.department').val(),
				   searchMonth : $('.Selectedmonth').val(),
				   productionId:$('.productionId').val(),
				},
				success: function(result) {
				  if(result != '') {
					var obj = $.parseJSON(result);
					//alert(obj.status);
				   if(obj.status == 'success') {  
					 $('#result').html('<div class="alert alert-error col-md-6">Record Is Already Exists</div>');
						event.preventDefault();
							bool = false;
					   }else{
						  bool = true;
					   }				   
				  }
			   }
			}); 
		
     return bool;
}
$('#example08424').DataTable();
//  $(document).ready( function () {
    
// } );
(function($) {
  $.fn.scrollTabs = function(opts){
    var initialize = function(state){
      opts = $.extend({}, $.fn.scrollTabs.defaultOptions, opts);
      if($(this).prop('tagName').toLowerCase() === 'ul'){
        this.itemTag = 'li';
      } else {
        this.itemTag = 'span';
      }
      
      $(this).addClass('scroll_tabs_container');
      if($(this).css('position') === null || $(this).css('position') === 'static'){
        $(this).css('position','relative');
      }
      
      $(this.itemTag, this).last().addClass('scroll_tab_last');
      $(this.itemTag, this).first().addClass('scroll_tab_first');
      
      $(this).html("<div class='scroll_tab_left_button'></div><div class='scroll_tab_inner'><span class='scroll_tab_left_finisher'>&nbsp;</span>"+$(this).html()+"<span class='scroll_tab_right_finisher'>&nbsp;</span></div><div class='scroll_tab_right_button'></div>");
      
      $('.scroll_tab_inner > span.scroll_tab_left_finisher', this).css({
        'display': 'none'
      });
      
      $('.scroll_tab_inner > span.scroll_tab_right_finisher', this).css({
        'display': 'none'
      });
      
      
      var _this = this;
      
      $('.scroll_tab_inner', this).css({
        'margin': '0px',
        'overflow': 'hidden',
        'white-space': 'nowrap',
        '-ms-text-overflow': 'clip',
        'text-overflow': 'clip',
        'font-size': '0px',
        'position': 'absolute',
        'top': '0px',
        'left': opts.left_arrow_size + 'px',
        'right': opts.right_arrow_size + 'px'
      });
      // If mousewheel function not present, don't utilize it
      if($.isFunction($.fn.mousewheel)){
        $('.scroll_tab_inner', this).mousewheel(function(event, delta){
          // Only do mousewheel scrolling if scrolling is necessary
          if($('.scroll_tab_right_button', _this).css('display') !== 'none'){
            this.scrollLeft -= (delta * 30);
            state.scrollPos = this.scrollLeft;
            event.preventDefault();
          }
        });
      }
      
      // Set initial scroll position
      $('.scroll_tab_inner', _this).animate({scrollLeft: state.scrollPos + 'px'}, 0);
      
      $('.scroll_tab_left_button', this).css({
        'position': 'absolute',
        'left': '0px',
        'top': '0px',
        'width': opts.left_arrow_size + 'px',
        'cursor': 'pointer'
      });
      
      $('.scroll_tab_right_button', this).css({
        'position': 'absolute',
        'right': '0px',
        'top': '0px',
        'width': opts.right_arrow_size + 'px',
        'cursor': 'pointer'
      });
      
      $('.scroll_tab_inner > '+_this.itemTag, _this).css({
        'display': '-moz-inline-stack',
        'display': 'inline-block',
        'zoom':1,
        '*display': 'inline',
        '_height': '40px',
        '-webkit-user-select': 'none',
        '-khtml-user-select': 'none',
        '-moz-user-select': 'none',
        '-ms-user-select': 'none',
        '-o-user-select': 'none',
        'user-select': 'none'
      });
      
      
      var size_checking = function(){
        var panel_width = $('.scroll_tab_inner', _this).outerWidth();
        
        if($('.scroll_tab_inner', _this)[0].scrollWidth > panel_width){
          $('.scroll_tab_right_button',_this).show();
          $('.scroll_tab_left_button',_this).show();
          $('.scroll_tab_inner',_this).css({left: opts.left_arrow_size + 'px', right: opts.right_arrow_size + 'px'});
          $('.scroll_tab_left_finisher',_this).css('display','none');
          $('.scroll_tab_right_finisher',_this).css('display','none');
          
          if($('.scroll_tab_inner', _this)[0].scrollWidth - panel_width == $('.scroll_tab_inner', _this).scrollLeft()){
            $('.scroll_tab_right_button', _this).addClass('scroll_arrow_disabled').addClass('scroll_tab_right_button_disabled');
          } else {
            $('.scroll_tab_right_button', _this).removeClass('scroll_arrow_disabled').removeClass('scroll_tab_right_button_disabled');
          }
          if ($('.scroll_tab_inner', _this).scrollLeft() == 0) {
            $('.scroll_tab_left_button', _this).addClass('scroll_arrow_disabled').addClass('scroll_tab_left_button_disabled');
          } else {
            $('.scroll_tab_left_button', _this).removeClass('scroll_arrow_disabled').removeClass('scroll_tab_left_button_disabled');
          }
        } else {
          $('.scroll_tab_right_button',_this).hide();
          $('.scroll_tab_left_button',_this).hide();
          $('.scroll_tab_inner',_this).css({left: '0px', right: '0px'});
          
          if($('.scroll_tab_inner > '+_this.itemTag+':not(.scroll_tab_right_finisher):not(.scroll_tab_left_finisher):visible', _this).size() > 0){
            $('.scroll_tab_left_finisher',_this).css('display','inline-block');
            $('.scroll_tab_right_finisher',_this).css('display','inline-block');
          } 
        }
      };
      
      size_checking();
      
      state.delay_timer = setInterval(function(){
        size_checking();
      }, 500);
  
      var press_and_hold_timeout;
      
      $('.scroll_tab_right_button', this).mousedown(function(e){
        e.stopPropagation();
        var scrollRightFunc = function(){
          var left = $('.scroll_tab_inner', _this).scrollLeft(); 
          state.scrollPos = Math.min(left + opts.scroll_distance,$('.scroll_tab_inner', _this)[0].scrollWidth - $('.scroll_tab_inner', _this).outerWidth());
          $('.scroll_tab_inner', _this).animate({scrollLeft: (left + opts.scroll_distance) + 'px'}, opts.scroll_duration);
        };
        scrollRightFunc();
        
        press_and_hold_timeout = setInterval(function(){
          scrollRightFunc();
        }, opts.scroll_duration);
      }).bind("mouseup mouseleave", function(){
        clearInterval(press_and_hold_timeout);
      }).mouseover(function(){
        $(this).addClass('scroll_arrow_over').addClass('scroll_tab_right_button_over');
      }).mouseout(function(){
        $(this).removeClass('scroll_arrow_over').removeClass('scroll_tab_right_button_over');
      });
      
      $('.scroll_tab_left_button', this).mousedown(function(e){
        e.stopPropagation();
        var scrollLeftFunc = function(){
          var left = $('.scroll_tab_inner', _this).scrollLeft(); 
          state.scrollPos = Math.max(left - opts.scroll_distance,0);
          $('.scroll_tab_inner', _this).animate({scrollLeft: (left - opts.scroll_distance) + 'px'}, opts.scroll_duration);
        };
        scrollLeftFunc();
        
        press_and_hold_timeout = setInterval(function(){
          scrollLeftFunc();
        }, opts.scroll_duration);
      }).bind("mouseup mouseleave", function(){
        clearInterval(press_and_hold_timeout);
      }).mouseover(function(){
        $(this).addClass('scroll_arrow_over').addClass('scroll_tab_left_button_over');
      }).mouseout(function(){
        $(this).removeClass('scroll_arrow_over').removeClass('scroll_tab_left_button_over');
      });
      
      $('.scroll_tab_inner > '+this.itemTag+(this.itemTag !== 'span' ? ', .scroll_tab_inner > span' : ''), this).mouseover(function(){
        $(this).addClass('scroll_tab_over');
        if($(this).hasClass('scroll_tab_left_finisher')){
          $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_first', _this).addClass('scroll_tab_over').addClass('scroll_tab_first_over');
        }
        if($(this).hasClass('scroll_tab_right_finisher')){
          $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_last', _this).addClass('scroll_tab_over').addClass('scroll_tab_last_over');
        }
        if($(this).hasClass('scroll_tab_first') || $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_last', _this).hasClass('scroll_tab_first')){
          $('.scroll_tab_inner > span.scroll_tab_left_finisher', _this).addClass('scroll_tab_over').addClass('scroll_tab_left_finisher_over');
        }
        if($(this).hasClass('scroll_tab_last') || $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_first', _this).hasClass('scroll_tab_last')){
          $('.scroll_tab_inner > span.scroll_tab_right_finisher', _this).addClass('scroll_tab_over').addClass('scroll_tab_right_finisher_over');
        }
      }).mouseout(function(){
        $(this).removeClass('scroll_tab_over');
        if($(this).hasClass('scroll_tab_left_finisher')){
          $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_first', _this).removeClass('scroll_tab_over').removeClass('scroll_tab_first_over');
        }
        if($(this).hasClass('scroll_tab_right_finisher')){
          $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_last', _this).removeClass('scroll_tab_over').removeClass('scroll_tab_last_over');
        }
        if($(this).hasClass('scroll_tab_first') || $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_last', _this).hasClass('scroll_tab_first')){
          $('.scroll_tab_inner > span.scroll_tab_left_finisher', _this).removeClass('scroll_tab_over').removeClass('scroll_tab_left_finisher_over');
        }
        if($(this).hasClass('scroll_tab_last') || $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_first', _this).hasClass('scroll_tab_last')){
          $('.scroll_tab_inner > span.scroll_tab_right_finisher', _this).removeClass('scroll_tab_over').removeClass('scroll_tab_right_finisher_over');
        }
      }).click(function(e){
        e.stopPropagation();
        $('.tab_selected',_this).removeClass('tab_selected scroll_tab_first_selected scroll_tab_last_selected scroll_tab_left_finisher_selected scroll_tab_right_finisher_selected');
        $(this).addClass('tab_selected');
        
        var context_obj = this;
        if($(this).hasClass('scroll_tab_left_finisher')){
          context_obj = $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_first', _this).addClass('tab_selected').addClass('scroll_tab_first_selected');
        }
        if($(this).hasClass('scroll_tab_right_finisher')){
          context_obj = $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_last', _this).addClass('tab_selected').addClass('scroll_tab_last_selected');
        }
        if($(this).hasClass('scroll_tab_first') || $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_last', _this).hasClass('scroll_tab_first')){
          $('.scroll_tab_inner > span.scroll_tab_left_finisher', _this).addClass('tab_selected').addClass('scroll_tab_left_finisher_selected');
        }
        if($(this).hasClass('scroll_tab_last') || $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_first', _this).hasClass('scroll_tab_last')){
          $('.scroll_tab_inner > span.scroll_tab_right_finisher', _this).addClass('tab_selected').addClass('scroll_tab_left_finisher_selected');
        }
        
        // "Slide" it into view if not fully visible.
        scroll_selected_into_view.call(_this, state);
        
        opts.click_callback.call(context_obj,e);
      });
      
      // Check to set the edges as selected if needed
      if($('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_first', _this).hasClass('tab_selected'))
        $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_left_finisher', _this).addClass('tab_selected').addClass('scroll_tab_left_finisher_selected');
      if($('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_last', _this).hasClass('tab_selected'))
        $('.scroll_tab_inner > '+_this.itemTag+'.scroll_tab_right_finisher', _this).addClass('tab_selected').addClass('scroll_tab_right_finisher_selected');
    };
    
    var scroll_selected_into_view = function(state){
      var _this = this;
      
      var selected_item = $('.tab_selected:not(.scroll_tab_right_finisher, .scroll_tab_left_finisher)', _this);
      
      var left = $('.scroll_tab_inner', _this).scrollLeft();
      var scroll_width = $('.scroll_tab_inner', _this).width();
      if(selected_item && typeof(selected_item) !== 'undefined' && selected_item.position() && typeof(selected_item.position()) !== 'undefined'){
        if(selected_item.position().left < 0){
          state.scrollPos = Math.max(left + selected_item.position().left + 1,0);
          $('.scroll_tab_inner', _this).animate({scrollLeft: (left + selected_item.position().left + 1) + 'px'}, opts.scroll_duration);
        } else if ((selected_item.position().left + selected_item.outerWidth()) > scroll_width){
          state.scrollPos = Math.min(left + ((selected_item.position().left + selected_item.outerWidth()) - scroll_width),$('.scroll_tab_inner', _this)[0].scrollWidth - $('.scroll_tab_inner', _this).outerWidth());
          $('.scroll_tab_inner', _this).animate({scrollLeft: (left + ((selected_item.position().left + selected_item.outerWidth()) - scroll_width)) + 'px'}, opts.scroll_duration);
        }
      }
    };
    
    var ret = [];
    
    this.each(function(){
      var backup = $(this).html();
      
      var state = {};
      state.scrollPos = 0;
      initialize.call(this, state);
      
      var context_obj = this;
      
      ret.push({
        domObject: context_obj,
        state: state,
        addTab: function(html, position){
          if(typeof(position) === 'undefined'){
            position = $('.scroll_tab_inner > '+context_obj.itemTag, context_obj).length - (context_obj.itemTag === 'span' ? 2 : 0);
          } 
          
          $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_last', context_obj).removeClass('scroll_tab_last');
          $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_first', context_obj).removeClass('scroll_tab_first');
          backup = "";
          var count = 0;
          $('.scroll_tab_inner > '+context_obj.itemTag, context_obj).each(function(){
            if($(this).hasClass('scroll_tab_left_finisher') || $(this).hasClass('scroll_tab_right_finisher')) return true;
            if(position == count){
              backup += html;
            }
            backup += $(this).clone().wrap('<div>').parent().html();
            count++;
          });
          
          if(position >= count)
            backup += html;
          this.destroy();
          initialize.call(context_obj, state);
          this.refreshFirstLast();
        },
        removeTabs: function(jquery_selector_str){
          $('.scroll_tab_left_finisher', context_obj).remove();
          $('.scroll_tab_right_finisher', context_obj).remove();
          
          $(jquery_selector_str, context_obj).remove();
          
          $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_last', context_obj).removeClass('scroll_tab_last');
          $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_first', context_obj).removeClass('scroll_tab_first');
          this.refreshState();
        },
        destroy: function(){
          clearInterval(state.delay_timer);
          $(context_obj).html(backup);
          $(context_obj).removeClass('scroll_tabs_container');
        },
        refreshState: function(){
          $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_last', context_obj).removeClass('scroll_tab_last');
          $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_first', context_obj).removeClass('scroll_tab_first');
          backup = $('.scroll_tab_inner',context_obj).html();
          this.destroy();
          initialize.call(context_obj, state);
          this.refreshFirstLast();
        },
        clearTabs: function(){
          backup = "";
          this.destroy();
          initialize.call(context_obj, state);
          this.refreshFirstLast();
        }, 
        refreshFirstLast: function(){
          var old_last_item = $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_last', context_obj);
          var old_first_item = $('.scroll_tab_inner > '+context_obj.itemTag+'.scroll_tab_first', context_obj);
          
          old_last_item.removeClass('scroll_tab_last');
          old_first_item.removeClass('scroll_tab_first');
          
          if(old_last_item.hasClass('tab_selected'))
            $('.scroll_tab_inner > span.scroll_tab_right_finisher', context_obj).removeClass('tab_selected scroll_tab_right_finisher_selected');
          if(old_first_item.hasClass('tab_selected'))
            $('.scroll_tab_inner > span.scroll_tab_left_finisher', context_obj).removeClass('tab_selected scroll_tab_left_finisher_selected');
          
          if($('.scroll_tab_inner > '+context_obj.itemTag+':not(.scroll_tab_right_finisher):not(.scroll_tab_left_finisher):visible', context_obj).size() > 0){
            var new_last_item = $('.scroll_tab_inner > '+context_obj.itemTag+':not(.scroll_tab_right_finisher):visible', context_obj).last();
            var new_first_item = $('.scroll_tab_inner > '+context_obj.itemTag+':not(.scroll_tab_left_finisher):visible', context_obj).first();
            
            new_last_item.addClass('scroll_tab_last');
            new_first_item.addClass('scroll_tab_first');
            
            if(new_last_item.hasClass('tab_selected'))
              $('.scroll_tab_inner > span.scroll_tab_right_finisher', context_obj).addClass('tab_selected').addClass('scroll_tab_right_finisher_selected');
            if(new_first_item.hasClass('tab_selected'))
              $('.scroll_tab_inner > span.scroll_tab_left_finisher', context_obj).addClass('tab_selected').addClass('scroll_tab_right_finisher_selected');
          } else {
            $('.scroll_tab_inner > span.scroll_tab_right_finisher', context_obj).hide();
            $('.scroll_tab_inner > span.scroll_tab_left_finisher', context_obj).hide();
          }
        },
        hideTabs: function(domObj){
          $(domObj, context_obj).css('display','none');
          this.refreshFirstLast();
        },
        showTabs: function(domObj){
          $(domObj, context_obj).css({
            'display': '-moz-inline-stack',
            'display': 'inline-block',
            '*display': 'inline'
          });
          this.refreshFirstLast();
        },
        scrollSelectedIntoView:function(){
          scroll_selected_into_view.call(context_obj, state);
        }
      });
    });
    
    if(this.length == 1){
      return ret[0];
    } else {
      return ret;
    }
  };
  
  $.fn.scrollTabs.defaultOptions = {
    scroll_distance: 300,
    scroll_duration: 300,
    left_arrow_size: 26,
    right_arrow_size: 26,
    click_callback: function(e){
      var val = $(this).attr('rel');
      if(val){
        window.location.href = val;
      }
    }
  };
})(jQuery);
/****************** GET Report data ********************************/
$('.get_mat_IDD').on('change',function(){
	var mat_id = $(this).find("option:selected").val();
	  $('#mattype_frm').submit();
	});
/****************** GET Report data ********************************/
$(document).on("click",".draftBtn",function(){ 
     	$('.rtr').val(0);
     	stop();
});
function addMoreProductincoversion(){
	var maximum = 10; //maximum input boxes allowed
	var wrap_material = $(".input_productre1"); //Fields wrapper
	var button_add = $(".addProductButtonre1"); //Add button ID
	var logged_user1 = $('#loggedUser').val();
	var rtf = $('.getUom').val();
	var x = 1; //initlal text box count	
	$(button_add).click(function (e){
		var rtf = $('.getUom').val();
		//on add input button click
		e.preventDefault();
		if (x < maximum) { //max input box allowed
			x++;
			if(rtf == 6){				
				$(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_' + x + '"><div class="col-md-2 col-sm-7 col-xs-12 form-group"><label>Output Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" aria-hidden="true" data-where="created_by_cid=' + logged_user1 + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-8 col-xs-12 form-group" style="float:left;"><label>Output Material Name</label><select class="materialNameId form-control col-md-2 col-xs-12 mat_name Add_mat_onthe_spot" id="mat_name" required="required" name="converted_material_id[]" onchange="getUOMinmaterialconvrs(event,this)"><option>Select Option</option></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd"><input type="hidden" name="matrial_name" id="matrial_name"> <input type="hidden" id="serchd_val"> </div><div class="col-md-4 col-sm-2 col-xs-12 form-group"><label>Output UOM</label><input type="text" name="uom1[]" class="form-control col-md-7 col-xs-12" placeholder="UOM" value="" readonly><input type="hidden" name="uom[]" class="form-control col-md-7 col-xs-12" placeholder="UOM" value="" readonly></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');
			}
			else{
				$(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_' + x + '"><div class="col-md-2 col-sm-7 col-xs-12 form-group"><label>Output Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" aria-hidden="true" data-where="created_by_cid=' + logged_user1 + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" id="material_type_id"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-8 col-xs-12 form-group" style="float:left;"><label>Output Material Name</label><select class="materialNameId form-control col-md-2 col-xs-12 mat_name Add_mat_onthe_spot" id="mat_name" required="required" name="converted_material_id[]" onchange="getUOMinmaterialconvrs(event,this)"><option>Select Option</option></select></div><div class="col-md-2 col-sm-2 col-xs-12 form-group"><label>Destination Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid=9"><option>Select Option</option></select></div><div class="col-md-2 col-sm-2 col-xs-12 form-group"><label>Area</label><input type="text" id="qty" name="converted_qty[]" onblur="getQuantityinconversion(event,this);" class="form-control col-md-7 col-xs-12 qty22"></div><div class="col-md-4 col-sm-2 col-xs-12 form-group"><label>Output UOM</label><input type="text" name="uom1[]" class="form-control col-md-7 col-xs-12" placeholder="UOM" value="" readonly><input type="hidden" name="uom[]" class="form-control col-md-7 col-xs-12" placeholder="UOM" value="" readonly></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');
			}
			var logged_user = $('#loggedUser').val();
			var material_type_id = $('#material_type_id').val();
			var selectedQty = $('#selectedQty').val();
			//var wws = $('#subblnc').val();
			//$('#mainvalue').val(wws);
			select2(material_type_id, logged_user);
			getUOMinmaterialconvrs(event, this);
			init_select2();
			init_select221();
		}
		//getMaterials(x);
	});
	$(wrap_material).on("click", ".remove_btn", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
		getQuantityinconversion(event,this);
		//var wws = $('#mainvalue').val();
		//$('#subblnc').val(wws);
	});
}
function select2(material_type_id, logged_user) {
	$('.materialNameId').attr('data-where', 'material_type_id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND status=1');
	$('.materialNameId').attr('data-id', 'material');
	$('.materialNameId').attr('data-key', 'id');
	$('.materialNameId').attr('data-fieldname', 'material_name');
}
function getUOMinmaterialconvrs(evt, t) {
	var option = $(t).find('option:selected');
	var materialId = option.val();
	var closestId = $(t).closest(".well").attr("id");
	$.ajax({
		type: "POST",
		url: site_url + 'inventory/getMaterialUomById',
		data: {
			id: materialId
		},
		success: function (data) {
			if (data != '') {
				var dataObj = JSON.parse(data);
				parseFloat($("#" + closestId + " input[name='uom1[]'").val(dataObj.uom));
				parseFloat($("#" + closestId + " input[name='uom[]'").val(dataObj.uomid));
			}
		}
	});
}
function getQuantityinconversion(evt,t){
    
	var hh = $('.getUom').val();
	var qty1 = $(t).closest(".well").attr("id");
	var qty = $("#" + qty1 + " input[name='converted_qty[]'").val();
	var selectedQty = $('#selectedQty').val();
	if(selectedQty == ""){
	    // $('#message').html('Please select first source address');
	    // $('.signUpBtn').prop("disabled", true);	
	}else{
        if(qty == ""){
    		$('#message').html('Please enter Quanity for material conversion');
    		$('.signUpBtn').prop("disabled", true);	
    	}
    	else{
    	    var grandTotal = 0;
        	$(".qty22").each(function (key, value) {
        		grandTotal = parseFloat(grandTotal) + parseFloat($(value).val());
        	});
        	var rty = 0;
        	if(parseInt(selectedQty) < parseInt(grandTotal)){ 
        		$('#message').html('The Available Quantity is  ' + selectedQty + ' please enter the quantity between 0 and '+ selectedQty);
        		$('.signUpBtn').prop("disabled", true);	
        	}else{
        		rty = parseInt(selectedQty) - parseInt(grandTotal);
        		$('.signUpBtn').prop( "disabled", false);
        		$('#message').empty();
        	}				
        	if(isNaN(grandTotal)){
        		var grandTotal = 0;
        	}
    	}
	}
}
function gettotal_box(evt,t){
	console.log("hererere");  
	var tg = $('#dtqty').val();
	var ws = $('#bthj').val();
	var qas = tg * ws;
	$('.ssdsd').val(qas);
}
$(document).on("click",".draftBtn1",function(){ 
	console.log("hbhbhb");
   $('.save_status1').val(0);
   $('.customerName').removeAttr('required')
   	$('.form-control').removeAttr('required');	
});
$('.delivery_date').datepicker({ 
		//startDate: date,
		format: 'dd-mm-yyyy',
		autoclose: true
});
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
		//mycomment
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
						//mycomment
						$('.nav-md').addClass('modal-open');
					}, 1000);
					setTimeout(function () {
						//mycomment
						$('.nav-md').addClass('modal-open');
					}, 1500);
					//mycomment
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
function Print_data_new1() {
	$(document).on("click", "#btnPrint", function () {
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
	});
}
$('.chck').on("change",function(){
    if($(this).val() == ''){
        $('.submitCompanyBtn').attr('disabled','disabled'); //Disables if Values of Select Empty
    }else{
        $('.submitCompanyBtn').removeAttr('disabled');  
    }
});
// $(document).on("click", "#SearchButton", function () {
// var table = $('#example084').DataTable();
// if ( ! table.data().any() ) {
//  $('#submt').attr("disabled", "disabled");   
// }
// else{
// 	 $('#submt').removeAttr("disabled");     
// }
// });
//$('.tt').scrollingTabs();
$(document).on("click",".smth",function(){
 $('.dssbld').removeAttr("disabled");   
});
$(document).ready(function() {
	$('#mytable2').dataTable({
		"bLengthChange": false,
		"bFilter": false,
		"bInfo": false,
		"bAutoWidth": false,
	});
		
});
function getlot(evt, t, selProcessType = '' , c_id = ''){	
	$(this).parents().closest('input=[text]').find('.lotno').empty();
	var logged_user = $('#loggedUser').val();
	var closestId = $(t).closest(".well").attr("id");  
	var option = $(t).find('option:selected'); 
	var material_id = selProcessType != '' ? selProcessType:$(option).val();
	var mat_id = $('#mat_id_funcs').val();
	if(mat_id != '' && typeof(mat_id) != 'undefined'){	
    	material_id = mat_id;
	} 	
	if(material_id != ''){	  
		select2lot(material_id , logged_user);
		$("#"+closestId+"").find('.lotno').attr('data-where','mat_id = '+material_id+' AND created_by_cid='+logged_user+' AND active_inactive = 1');
		$("#"+closestId+"").find('.lotno').attr('data-id','lot_details');
		$("#"+closestId+"").find('.lotno').attr('data-key','id');
		$("#"+closestId+"").find('.lotno').attr('data-fieldname','lot_number');
	}
}
function select2lot(mat_id , logged_user){
    $('.lotno').attr('data-where','mat_id = '+mat_id+' AND created_by_cid='+logged_user+' AND active_inactive = 1');
    $('.lotno').attr('data-id','lot_details');
    $('.lotno').attr('data-key','id');
    $('.lotno').attr('data-fieldname','lot_number');
}
function addcustomertypereserv(){
	var max_Address     = 5; //maximum input boxes allowed
	var location_add  = $(".add_multiple_customer_reserv"); //Fields wrapper
	var add_moreBtn      = $(".add_More_btn_reserv"); //Add button ID
	var logged_user = $('#loggedUser').val();
	var k = 1; //initlal text box count
	$(add_moreBtn).click(function(e){ //on add input button click
		e.preventDefault();
		var closestId = $(this).closest('.well').last().attr('id');
		var getUom = $("#"+closestId+"").find('.uom option:selected').text();
		var getUomid = $("#"+closestId+"").find('.uom option:selected').val();
		//console.log("getUom",getUom);
		var measurmentArray = '';
		$.each( measurementUnits, function( key, value ) {
			measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
		});
		
		if(k < max_Address){ //max input box allowed
			k++;
			$(location_add).append('<div class="welltyp  well scend-tr mobile-view"  style="overflow:auto; border-right: 1px solid #c1c1c1 ;" id="chkIndexw_'+k+'"><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible" name="types_of_customer[]" data-id="types_of_customer" data-key="id" data-fieldname="type_of_customer" width="100%" tabindex="-1" aria-hidden="true" data-where="active_inactive = 1 AND created_by_cid = '+logged_user+'"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label >Quantity</label><input style=" border-right: 1px solid #c1c1c1 ;"type="text" id="qty" name="reservd_quantty[]"  class="form-control col-md-7 col-xs-12" placeholder="Quantity"></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label>Product Type <span class="required">*</span></label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid = '+logged_user+'  OR created_by_cid=0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label>Product name <span class="required">*</span></label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 mat_name" id="mat_name"  name="material_name[]" onchange="getUom(event,this);"><option value="">Select Option</option></select></div><button class="btn btn-danger delete_btn_reserv" type="button"><i class="fa fa-minus"></i></button></div>');
			getArea();
			init_select2();
		}//getAddress();
	});
	$(location_add).on("click",".delete_btn_reserv", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); k--;
	});
}
// function getlot(evt, t , selProcessType = '' , c_id = '' ){
//   //Grandtotal();
//   $(this).parents().closest('input=[text]').find('.lotno').empty();
//   //$('.materialNameId').empty();
//   //$(".uom").val('');
//   //$(".amount").val('');
//   var logged_user = $('#loggedUser').val();
//   console.log("loggeduser",logged_user);
//   var mat_id = $('#id').val();
//   var closestId = $(t).closest(".well").attr("id");
//   var option = $(t).find('option:selected');
//   var material_type_id = selProcessType != ''?selProcessType:$(option).val();
//   if(material_type_id != ''){
//     //alert(closestId); 
//      select2lot(mat_id , logged_user);
//     // var x=$('.process_name_id').closest('select').find(':selected').val(); 
//     // console.log('GDGDG=====>',x);
//     //$("#"+closestId+"").find('.uom1').val(dataObj.uom);
    
//     //$("#"+closestId+"").find('.materialNameId').attr('data-where','material_type_id = '+material_type_id+' AND created_by_cid='+ logged_user);
//     $("#"+closestId+"").find('.lotno').attr('data-where','mat_id = '+mat_id+' AND created_by_cid='+logged_user+' AND active_inactive = 1');
//     $("#"+closestId+"").find('.lotno').attr('data-id','lot_details');
//     $("#"+closestId+"").find('.lotno').attr('data-key','id');
//     $("#"+closestId+"").find('.lotno').attr('data-fieldname','lot_number');
//   }
// }
// function select2lot(mat_id , logged_user){
//     $('.lotno').attr('data-where','mat_id = '+mat_id+' AND created_by_cid='+logged_user+' AND active_inactive = 1');
//     $('.lotno').attr('data-id','lot_details');
//     $('.lotno').attr('data-key','id');
//     $('.lotno').attr('data-fieldname','lot_number');
// }
function init_selectlot() {
   $('.lotno22').select2({
      allowClear: true,
      placeholder: 'Lot No.',
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
        $('#serchd_val').val(searched_value);
        $('#lotno').val(searched_value);
        var matID = $('.material_type_id').val();                
        $('#material_type_id').val(matID);
        return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_lotname'>Add Lot Details</span>";
        }
      },escapeMarkup: function (markup) {
         return markup;
      }
  });
}
$(document).on("click",".add_lotname",function(){
	//$('body').css('overflow', 'auto');
	
	var material_type = $('#material_typewsws').val();
	var mat_name = $('#mat_id_funcs').val();
	//console.log(material_type);
	//console.log(mat_name);
	
    setTimeout(function(){    
		$('#material_type_id22').val(material_type);
		$('#material_name_id').val(mat_name);
	}, 2000);
	
	$('#myModal_lotdetails').modal('show');
	var btn_html = $(this).html();
	$('#add_matrial_Data_onthe_spot').val(btn_html);
	//$('#myModal_lotdetails').modal({backdrop: 'static', keyboard: false});
	
});
$(".myModal_lotdetails").click(function() {
	/* if ($(".myModal_lotdetails").is(":visible")) {
		$(".myModal_lotdetails").hide();
	} */
	//$('body').removeClass('modal-open');
	//$('.modal-backdrop').remove();	
 });
$(document).on("click",".close_sec_model",function(){
	// $('#myModal_Add_matrial_details').modal('hide');
	console.log('mybtn');
   $('#myModal_lotdetails').modal('hide');
   $('#wrngmdl').modal('hide');
//return false;
	 
});

$(document).on("click",".close_add_lot_modal",function(){
	// $('#myModal_Add_matrial_details').modal('hide');
	console.log('mybtn');
   $('#myModal_lotdetails').modal('hide');
   $('#wrngmdl').modal('hide');
//return false;
	 
});

$(document).on("click",".add_material_cls_name",function(){
  //alert('therer');
  var searched_text_val = $('#serchd_val').val();
  var searched_text_val1 = $('#material_name').val();
  var materialId = $('#material_type_id').val();
    setTimeout(function(){    
    $('#material_name').val(searched_text_val);
    $('#material_name').val(searched_text_val1);
    $('#material_name_id').val(materialId);
  }, 2000);
  setTimeout(function(){  
      $('#serchd_val').val();
  }, 1000);
});
$(document).on("click","#Add_lot_details_on_button_click_mrn",function(){
  $('#mssg343').empty();
  var lotno  = $('#lotno').val();  
  var material_type  = $('#material_type_id22').val();
  var material_name  = $('#material_name_id').val();
  var mou_price  = $('#mou_price').val();
  var mrp_price  = $('#mrp_price').val();  
  var datess  = $('#date').val();  
   var error = 0;
     if(mou_price == ''){
        $('#mou_price').css('border', '1px solid #b94a48');
        $('#mou_price').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#mou_price').css('border', '1px solid #dedede');
        $('#mou_price').closest(".form-group").find("span").text('');
      }   
    if(mrp_price == ''){
        $('#mrp_price').css('border', '1px solid #b94a48');
        $('#mrp_price').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#mrp_price').css('border', '1px solid #dedede');
        $('#mrp_price').closest(".form-group").find("span").text('');
      }
    if(lotno == ''){
      $('#lotno').css('border', '1px solid #b94a48');
      $('#lotno').closest(".form-group").find("span").text('This field is required');
      var error = 1;
    }else{
      $('#lotno').css('border', '1px solid #dedede');
      $('#lotno').closest(".form-group").find("span").text('');
    }
    if(datess == ''){
      $('#lotno').css('border', '1px solid #b94a48');
      $('#lotno').closest(".form-group").find("span").text('This field is required');
      var error = 1;
    }else{
      $('#lotno').css('border', '1px solid #dedede');
      $('#lotno').closest(".form-group").find("span").text('');
    }
    if(error == 1) { 
      return false;
    } else {
      
    $.ajax({
         type: "POST",
         url: site_url+'purchase/add_lot_Details_onthe_spot/',
         data: {lotno:lotno,material_type:material_type,material_name:material_name,mou_price:mou_price,mrp_price:mrp_price,date:datess},
          success: function(htmlStr) {
			console.log(htmlStr);
          //alert(htmlStr);
             
           	if(htmlStr == 'true'){
	            $('#mssg343').html('<span style="color:green;">Lot Details Added Successfully.</span>');
	            $("#insert_Matrial_data_id33").trigger('reset');
	            setTimeout(function(){
	              
	              $('#myModal_lotdetails').modal('hide');
	             // $('.nav-md').addClass('modal-open'); 
	              //$('#myModal_Add_matrial_details_purchse').modal('hide');
	            }, 1000);
	            setTimeout(function(){
	             // $('.nav-md').addClass('modal-open'); 
	            }, 1500);           
            }else{
            $('#mssg343').html('<span style="color:red;">Not Added.</span>');
          }
          setTimeout(function(){
          $('#mssg343').html('<span> </span>');
          }, 3000);     
        }
       });
    }
});
$(document).on('change', '.change_status_mat_loc', function () {
	var uomStatus;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) uomStatus = 1;
	else uomStatus = 0;
	var id = $(this).attr("data-value");
	$.ajax({
		url: site_url + 'inventory/change_status_mat_loc/',
		dataType: 'json',
		type: 'POST',
		data: {
			'id': id,
			'gstatus': uomStatus,
		},
		success: function (data) {
			if (data == true) {
				location.reload();
			}
		}
	});
});
$(document).on('change','.change_inventory_setting',function(){
	var name = $(this).attr('name');
	var checkValue = 0;
	if( this.checked ){
		checkValue = 1;
	}
	$.ajax({
		url: site_url + 'inventory/save_inventory_setting/',
		method:'POST',
		data:{inputName:name,checkValue:checkValue},
		success:(data) => location.reload(),
	})
})
/* Bimla traders changes */
$(function(){
    $(".tt").click(function(){
      $(".box1").slideToggle(500);
    });        
});
// $('#parent_mat_sku').focusout(function(){
// 	//alert("qaaqaqaqaq");
// 	var sku = $('#parent_mat_sku').val();
// 	var closestId = 0;
// 	$.ajax({
// 		type: "POST",
// 		url: site_url + 'inventory/getMaterialDataBysku',
// 		data: {
// 			sku: sku
// 		},
// 		beforeSend: function() {
//               setTimeout(function () {
// 				  $("#myDivty").show();
// 			}, 200);
//         },
// 		success: function (data) {
// 			if (data != '') {
// 				 setTimeout(function () {
// 				  $("#myDivty").hide();
// 				}, 1500);
// 				 var dataObj = JSON.parse(data); 
// 				 var newStateVal = dataObj.material_type_name;
// 				 var validr = dataObj.material_type_id;
// 			     var newState = new Option(newStateVal, validr, true, true); 
// 			        // Append it to the select
// 			     $("#tmpp").html("<option value="+dataObj.time_period+" selected>"+dataObj.time_period+"</option>");
// 			     $("#material_typewsws").append(newState).trigger('change');
// 			     $("input[name='hsn_code'").val(function() {return this.value + dataObj.hsn_code;});
// 			     $("input[name='lead_time'").val(function() {return this.value + dataObj.lead_time;});
// 			     $("input[name='min_order'").val(function() {return this.value + dataObj.min_order;});
// 			     $("input[name='min_inventory'").val(function() {return this.value + dataObj.min_inventory;});
// 			}
// 			 else{
// 			 		setTimeout(function () {
// 				  $("#myDivty").hide();
// 				}, 200);
// 			 		setTimeout(function () {
// 			 		  $("#wrngmdl").show();
// 			 		}, 100);
// 			 }
// 		}
// 	});
// 	// var tax = option.attr('data-tax');
// 	// var closestId = $(t).closest(".well").attr("id");
// 	// parseFloat($("#" + closestId + " input[name='gst[]'").val(tax));
// });
function IndentAddMoreMaterial(){
	var maximum_add     = 10; //maximum input boxes allowed
	var inputfield        = $(".input_holder"); //Fields wrapper
	var add_more  = $(".addMorefileds"); //Add button ID
	//var x = 1; //initlal text box count
	var x = $('.goods_descr_wrapper .well').length; //initlal text box count	
	$(add_more).click(function(e){ //on add input button click
		e.preventDefault();
		if ( $( ".well" ).length ){
			var lastid = $(".well:last").attr("id");
			console.log('lastid===>>>',lastid);		
			if(lastid != '' && typeof(lastid) != 'undefined'){
				var lastIdVal= lastid.split('_');		
				x = parseInt(lastIdVal[1]);
			}
		}
		var logged_user = $('#loggedUser').val();       
		/*var measurmentArray = '';
		$.each( measurementUnits, function( key, value ) {
			measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
		});*/
		if(x < maximum_add){ //max input box allowed
			x++; 	
			$(inputfield).append('<div class="well scend-tr mobile-view"  id="chkIndex_'+x+'" style="overflow:auto;"><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label class="col-md-2 col-sm-12 col-xs-12">Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid='+ logged_user +' OR created_by_cid = 0" tabindex="-1" aria-hidden="true" onchange="getMaterialName(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-6 form-group"><label >Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd"><input type="hidden" name="matrial_name" id="matrial_name"></div><div class="col-md-1 col-sm-12 col-xs-6 form-group"><label class="col-md-2 col-sm-12 col-xs-12 ">Description</label><textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description" title="<?php  echo $productInfo->description; ?>"></textarea></div><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label><input type="text" placeholder="Qty." id="quantity" name="quantity[]" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunc(event,this)" onkeypress="return float_validation(event, this.value)" required="required"><input type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly value=""><input type="hidden" name="uom[]" readonly class="uom"></div><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label class="col-md-2 col-sm-12 col-xs-12">Expected Amount</label><input type="text" id="amount" name="expected_amount[]" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunc(event,this)" placeholder="Exp Amt" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-1 col-sm-12 col-xs-12 ">Purpose</label><textarea id="purpose"  name="purpose[]" class="form-control col-md-1" placeholder="purpose"></textarea><br><br></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><label class="col-md-2 col-sm-12 col-xs-12 ">Sub Total</label><input  style="border-right: 1px solid #c1c1c1 !important;" id="sub_total"  name="sub_total[]" class="form-control col-md-2" placeholder="sub_total" readonly><br><br></div><button class="btn  btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');
			//select2(1 ,1);
			var logged_user = $('#loggedUser').val();							
			var material_type_id = $('#material_type').val();
			select2(material_type_id , logged_user);
		}
		var mat_id = $('#material_type').val();
		init_select2();
		init_select221();
		remove_calculation_purchase_indent();
		
		
	});  
	$(inputfield).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); x--;
			keyupFunc(event,this);
			remove_calculation_purchase_indent();
			
	});	
}		
function monthdt(){
// $(document).ready(function()
// {   
//     $("#month").datepicker({
//         dateFormat: 'MM yy',
//         changeMonth: true,
//         changeYear: true,
//         showButtonPanel: true,
//         onClose: function(dateText, inst) {
//             var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
//             var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//             $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
//         }
//     });
//     $("#month").focus(function () {
//         $(".ui-datepicker-calendar").hide();
//         $("#ui-datepicker-div").position({
//             my: "center top",
//             at: "center bottom",
//             of: $(this)
//         });
//     });
// });
}	
						$(document).ready( function () {
    						$('#inventorysettingtble').DataTable();
    						$('#archivedlottble').DataTable();
						} );
						$(document).ready( function () {
    						$('#inventorysettingtble11').DataTable();
						} );
$(document).on('change', '.change_status_uom', function () {
	var uomStatus;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) uomStatus = 1;
	else uomStatus = 0;
	var id = $(this).attr("data-value");
	$.ajax({
		url: site_url + 'inventory/change_status_uom/',
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
function addMoretypeoftagtypes() {
	/* add more multiple contacts */
	var maximum_add = 10; //maximum input boxes allowed
	var inputfield = $(".processDiv"); //Fields wrapper
	var add_more = $(".addMoreProcess"); //Add button ID
	var y = 1; //initlal text box count
	$(add_more).click(function (e) { //on add input button click
		e.preventDefault();
		if (y < maximum_add) { //max input box allowed
			y++;
			$(inputfield).append('<div class="col-md-12" id="chkIndex_' + y + '"><label class="col-md-3" style="border-right: 1px solid #c1c1c1 !important; "></label><div class="col-md-6 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;"><input type="text" id="processName" name="tag_types[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Tag Types" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	});
	$(inputfield).on("click", ".remve_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	});
}
addMoretypeoftagnames();
function addMoretypeoftagnames() {
	/* add more multiple contacts */
	var maximum_add = 10; //maximum input boxes allowed
	var inputfield = $(".processDiv11"); //Fields wrapper
	var add_more = $(".addMoreProcess11"); //Add button ID
	var y = 1; //initlal text box count
	$(add_more).click(function (e) { //on add input button click
		e.preventDefault();
		if (y < maximum_add) { //max input box allowed
			y++;
			$(inputfield).append('<div class="col-md-12" id="chkIndex_' + y + '"><label class="col-md-3" style="border-right: 1px solid #c1c1c1 !important; "></label><div class="col-md-6 col-sm-12 col-xs-12 form-group" style="border-right: 1px solid #c1c1c1 !important;"><input type="text" id="processName" name="tag_names[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Tag Name" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	});
	$(inputfield).on("click", ".remve_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	});
}
$(document).on('change', '.change_status_tag_types', function () {
	var uomStatus;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) uomStatus = 1;
	else uomStatus = 0;
	var id = $(this).attr("data-value");
	$.ajax({
		url: site_url + 'inventory/change_status_tag_types/',
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
$(document).on('change', '.change_status_tag_details', function () {
	var uomStatus;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) uomStatus = 1;
	else uomStatus = 0;
	var id = $(this).attr("data-value");
	$.ajax({
		url: site_url + 'inventory/change_status_tag_details/',
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
init_select21434();
function init_select21434() {
    $('.worker_name').select2({
        allowClear: true,
        placeholder: 'Select Tags',
        ajax: {
            url: site_url + 'Ajaxrequest/ajaxSelect2search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    table: $(this).attr("data-id"),
                    field: $(this).attr("data-key"),
                    fieldname: $(this).attr("data-fieldname"),
                    fieldwhere: $(this).attr("data-where")
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        language: {
            noResults: function() {
                var searched_value = $('.select2-search__field').val();
                $('#serchd_val').val(searched_value);
                $('#worker_name').val(searched_value);
                return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_worker_cls_name'>Add Worker</span>";
            }
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });
}
$(document).ready(function(){
    $('#uomListable').DataTable();
    $('#ivreport').DataTable();
});
$(document).on('change', '.change_status_rm', function(){
	var uomStatus;	
	var checkbox =	$(this).attr('checked', true);		
	if(checkbox.context.checked == true) uomStatus = 1;
	else uomStatus = 0;
	var id = $(this).attr("data-value");	
	$.ajax({				
		url: site_url + 'inventory/change_status_rm/',			
		dataType: 'json',
		type: 'POST',
		data: {
			'id': id,
			'lotStatus': uomStatus,
		},	
		success: function(data){			
			//console.log("njnjnjnnjnj==>>",data);
			if(data == true) {
				location.reload();
			}
		}
	});
});
/******************** New Inventory Listing ************************/
$(document).ready(function(){
	var InventoryListTable;
	initDatatableNewInventoryListing();
	
	$('#transactionHistory').DataTable({
		"paging": false,
		"info": false,
		"searching": false,
		"order": [[ 0, 'desc' ]],
	});
	
	$('#monthwiseList').DataTable({
		"paging": false,
		"info": false,
		"searching": false,
		//"order": [[ 0, 'desc' ]],
	});
	
	$('#lotReport').DataTable({
		"paging": false,
		"info": false,
		"searching": false,
		//"order": [[ 0, 'desc' ]],
	});
	
	$('#matAvailbility').DataTable({
		"paging": false,
		"info": false,
		"searching": false,
		//"order": [[ 0, 'desc' ]],
	});
	
	$('#clearAll').click(function() {
		$("#ivDate").val('');
		$('.head_search').val('');
		$('#location').prop('selectedIndex',0);
		location_id = '0';
		getInventoryDataByLocation(location_id);
	});
	
	//Date based filter
	$("#ivDate").datepicker({
		format: "dd-mm-yyyy",
        autoclose: true,
        endDate: "today",
	}).on("changeDate", function (e) {
		$("#myDivty").show();
		var sdate = e.format();
		var location_id = $("#location").val(); 
		$.ajax({
			url: site_url+'inventory/inventory_listing_and_adjustment_new/',
			type: 'POST',
			data: {sdate:sdate,location_id:location_id,ajax_var:'via_ajax'},
			success: function(result2){
				$("#myDivty").hide(); 
				if(result2 != ''){
					htmlData = $.parseHTML( result2 ),
					$('.InventoryListDiv').empty();
					$('.InventoryListDiv').html(htmlData);	
				}
				else
				{
					$(".InventoryListDiv").empty();
					var result2 = "No Data Available";
					html2 = $.parseHTML( result2 ),
					$('.InventoryListDiv').html( html2 );
				}
				initDatatableNewInventoryListing();
				//stock_checkk_fun();
				//ediit_click_fun();
			}	
		});
	});
});
	
function initDatatableNewInventoryListing(){
	// Setup - add a text input to each header cell except view and action
	$('#InventoryListTable thead th').each(function(){
		var title = $(this).text();
		$(this).html( title + '<br><input type="text" placeholder="Search '+title+'" class="head_search"/>' );
	});
 
	// DataTable
	InventoryListTable = $('#InventoryListTable').DataTable({
		"scrollY": "450px",
		"scrollX": true,
		"paging": false,
		"info": false,
		"columnDefs": [
			{ "width": "20%", "targets": 0 }
		],
		sDom: 'lrtip',   	//Hide common search
		initComplete: function(){
			// Apply the search
			this.api().columns().every(function(){
				var that = this;
				$('input', this.header()).on( 'keyup change clear', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				});
			} );
		}
	});
}	
	
function getInventoryDataByLocation(location_id){
	if(location_id != '')
	{
		$("#myDivty").show();
		$("#set_location").val(location_id);
		var sdate = $("#ivDate").val(); 
		$.ajax({
			url: site_url+'inventory/inventory_listing_and_adjustment_new/',
			type: 'POST',
			data: {sdate:sdate,location_id:location_id,ajax_var:'via_ajax'},
			success: function(result2){
				$("#myDivty").hide(); 
				if(result2 != ''){
					htmlData = $.parseHTML( result2 ),
					$('.InventoryListDiv').empty();
					$('.InventoryListDiv').html(htmlData);	
				}
				else
				{
					$(".InventoryListDiv").empty();
					var result2 = "No Data Available";
					html2 = $.parseHTML( result2 ),
					$('.InventoryListDiv').html( html2 );
				}
				initDatatableNewInventoryListing();
				//stock_checkk_fun();
				//ediit_click_fun();
			}	
		});
	}
}
/******************* End New Inventory Listing *******************/
function getMaterialQuantites(evt, current,type){  
	var option = $(current).find('option:selected');
	if(type == 'work_order'){
		var WorkOrderId = $(option).val();
		var materialId 	= $(current).closest('.well').find('.materialNameId').val(); 
	} else {
		var materialId 	= $(option).val();
		var WorkOrderId = $(current).closest('.well').find('.WorkOrderId').val(); 
	}
	var lotNumber 	= $(current).closest('.well').find('.lotno').val(); 	
	if (WorkOrderId != '' && materialId != ''){
		$.ajax({
			url: site_url + 'inventory/getQuantityDetails/',
			dataType: 'json',
			type: "POST",
			data: {
				'work_order_id'	: WorkOrderId,
				'material_id'	: materialId,
				'lot_id'		: lotNumber
			},
			success: function(res){
				if(res.status) {
					if(res.data){
						$(current).closest('.well').find('.required_quantity').val(res.data.required_quantity); 
						$(current).closest('.well').find('.issued_quantity').val(res.data.issued_quantity); 
					}
					return false;
				}
				init_select221();
			}
		});
	}
}
$(document).on('click','#AccountGroupForm .check_mat_qty',function(e){
	var blank = false;
		$('.requiredData').each(function() {
			if($(this).val() == ''){
				blank = true;
			} 
		});
	if(blank == false){
		$(this).submit(false);
		e.preventDefault();
		//e.stopPropagation();
		var formData = new FormData($('#AccountGroupForm')[0]); 
		$.ajax({				
			url: site_url + 'inventory/saveWorkInProcessMaterial_request/',			
			dataType: 'json',
			type: 'POST',
			data: formData,	
			processData: false,
			contentType: false,
			success: function(res){		
				$('#AccountGroupForm .__messageDetail').html('');
				if(res.status) {
					//~ $('#AccountGroupForm .__messageDetail').html(res.message);
					
					if(res.data){
						
						//~ $( 'input[name="required_quantity[]"]').each(function(key,index) {
							//~ $(this).val(res.data[key].required_quantity);
						//~ });
						//~ $( 'input[name="issued_quantity[]"]').each(function(key,index) {
							//~ $(this).val(res.data[key].issued_quantity);
						//~ });
					}
					return false;
				} 
				if(res.insert){
					location.reload();
				}
				
			}
		});
	}
});
/*******************issue rm material**************************/
function getArea2(evt, t){		 
	var locationId = $(t).find('option:selected').val();
	var closestId = $(t).closest(".well").attr("id");
	var material_type_id = $(".material_type_id").val();
	var materialId = $(".materialNameId").val();
	
	autoGetArea2(closestId,material_type_id,materialId,locationId);
}
function autoGetArea2(closestId,material_type_id,materialId,locationId){		 
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: site_url + 'inventory/getStorageArea',
		data: {material_type_id:material_type_id,materialId:materialId,location_id:locationId}, 
		success: function(data){
			var optionData='<option value="">Select Storage</option>';
			if(data != ''){				
				$.each(data, function(key, value) {					
					optionData +="<option value='"+value.id+"'>"+value.id+"</option>"; 				
				});						
			}
			$("#"+closestId+"").closest(".well").find('.area').html(optionData);
		}
	}); 
}
function getRackNo(evt, t, storage){
	var closestId = $(t).closest(".well").attr("id");
	var material_type_id = $(".material_type_id").val();
	var materialId = $(".materialNameId").val();
	var locationId = $(t).closest(".well").find('.location').children('option:selected').val();
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: site_url + 'inventory/getRackNumber',
		data: {location_id:locationId,material_type_id:material_type_id,materialId:materialId,storage:storage}, 
		success: function(data){
			
			var optionData='<option value="">Select Rack</option>';
			if(data != ''){				
				$.each(data, function(key, value) {					
					optionData +="<option value='"+value.rack+"'>"+value.rack+"</option>"; 				
				});						
			}
			$("#"+closestId+"").closest(".well").find('.rack').html(optionData);
		}
	}); 
}
/*******************end issue rm material**************************/
$(document).on('click','.addScrapButton',function(e) {	
	var input       = 5;
	var logged_user = $('#loggedUser').val();
	var input_scrap = $(this).closest('.panel').find('.input_scrap_holder'); 
	var y = $(this).closest('.scrap_input_fields_wrap').find('.scrapWell').length;
	var work_order_id = $(this).closest('.panel').find('.WorkOrderId').val();
	if (y < input) {
		
		y++;
		$(input_scrap).append('<div class="well scend-tr mobile-view scrapWell" id="chkScrapIndex_' + y + '" ><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Type</label><select required="required" class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" required="required" name="scrap_material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select required="required" class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2"  id="mat_name" required="required" name="scrap_material_name[]" onchange="getScrapUom(event,this);"></select></div> <input type="hidden" name="scrap_dmdata[]" class="dmdata" value=""><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Quantity</label><input required="required" class="form-control col-md-7 col-xs-12 qty actual_qty keyup_event" name="scrap_quantity[]" placeholder="Qty" required="required" type="text" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="scrap_uom_value1[]" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="" readonly style="border-right: 1px solid #c1c1c1 !important;"><input type="hidden" name="scrap_uom_value[]" class="uomid" readonly value=""></div><input type="hidden" name="work_order_detail_id[]" class="__workOrderId" value="'+work_order_id+'"><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
		var material_type_id = $('.material_type').val();
		select2(material_type_id, logged_user);
	}
	var mat_id = $('.material_type').val();
	//getMaterialIssue();
	keyup_function_to_check_qty();
	getMaterials(mat_id, y);
	init_select2();
	//addMaterial_inputDetail();
	//addMaterial_outputDetail();
	//get_Qty_UOm();
   // getUom();
});
$(document).on('click','.remove_input',function(e) {
//$(input_scrap).on("click", ".remove_input", function(e) {
	e.preventDefault();
	$(this).parent('div').remove();
	y--;
	keyupFunction(event, this);
});
function updateWorkOrderForScrap(evt, current){
	var option = $(current).find('option:selected');
	var WorkOrderId = $(option).val();
	if (WorkOrderId != '') {
		$(current).closest('.panel').find('.__workOrderId').val(WorkOrderId);
	}
}
function getScrapUom(evt, t){
	var closestId = $(t).closest(".well").attr("id");
	var materialId = $(t).closest(".well").find('.materialNameId').val();
	$.ajax({
		type: "POST",
		url: site_url + 'inventory/getMaterialUomById',
		data: {id:materialId}, 
		success: function(data){
			if(data != '') {
				var dataObj =JSON.parse(data);
				$(t).closest(".well").find('.uom').val(dataObj.uom);
				$(t).closest(".well").find('.uomid').val(dataObj.uomid);
			}
		}
	}); 
	
}
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
/*HSN MASTER SCRIPT*/
 $('#HSNSacMasterID').on('change', function() {
	var selectedVal = $(this).find('option:selected').attr('data-id');        $('.tacClass').val(selectedVal);
		//$('.tacClass>option[value="'+ selectedVal +'"]').prop('selected', true);
 });
function add_sgst_value(){
	 $('#igst_keyup').keyup(function(){
	    var igstval = $('#igst_keyup').val();
		var divide2 = parseFloat(igstval) / parseFloat(2);
		divide2 = isNaN(divide2) ? '0' : divide2;
    	$('#cgst_hsnmaster').val(divide2);
    	$('#sgst_keyup').val(divide2);
		//$('#igst_keyup').val(0);
	});
	
	// $('#igst_keyup').keyup(function(){
		// $('#sgst_keyup').val(0);
		// $('#cgst_hsnmaster').val(0);
	// });
}
	
 
 
 $(document).on("click",".hsnMAt_mat_view",function(){ 
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		//alert(tab);
		var url = '';
		switch (tab) {
	        case 'HSNADD_view':
				url = 'inventory/addHsnNumberDtails';
				break;					
		}
	$.ajax({
		type: "POST",
		url: site_url + url,
		data: {id:id}, 
		success: function(data){
			
			if(data != '') {
				$("#HSNMODAL_modal").modal({
					show:false,
					backdrop:'static'
				});
				if($('#HSNMODAL_modal').length){
						$('#HSNMODAL_modal').modal('toggle');
						$('#HSNMODAL_modal .modal-body-content').html(data);
						setTimeout(function(){
							//mycomment	
						$("body").addClass("modal-open");
					   }, 1000);
					}else{
						$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
				//mycomment	
				$("body").addClass("modal-open");		
				
				add_sgst_value();		 
							
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
			} 
			
			});
	});
	
	
	
	$(document).on("click","#add_hsnNumber",function(){	
	var hsn_name  = $('#hsn_name').val();
	var hsn_short_name  = $('#hsn_short_name').val();
	var cess  = $('#cess').val();
	var igst_keyup  = $('#igst_keyup').val();
	var sgst_keyup  = $('#sgst_keyup').val();
	var cgst_hsnmaster  = $('#cgst_hsnmaster').val();
	var hsnType = $('#hsnType').find('option:selected').val();
	
	var error = 0;
		if(hsn_name == ''){
				$('#hsn_name').css('border', '1px solid #b94a48');
				$('#hsn_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#hsn_name').css('border', '1px solid #dedede');
				$('#hsn_name').closest(".form-group").find("span").text('');
			}
		
		
		if(igst_keyup == ''){
				$('#igst_keyup').css('border', '1px solid #b94a48');
				$('#igst_keyup').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#igst_keyup').css('border', '1px solid #dedede');
				$(igst_keyup).closest(".form-group").find("span").text('');
			}
		
		if(error == 1) { 
			return false;
		} else {
		$.ajax({
				   type: "POST",
				   url: site_url+'inventory/add_HSNNUMBER/',
				   data: {name:hsn_name,shortName:hsn_short_name,cess:cess,igst_keyup:igst_keyup,sgst_keyup:sgst_keyup,cgst_hsnmaster:cgst_hsnmaster,hsnType:hsnType}, 
				   success: function(htmlStr) {
					if(htmlStr == 'true'){
						$('#mssg333').html('<span style="color:green;">Added Successfully.</span>');
						$("#HSNForm").trigger('reset');
						//setTimeout(function(){
							$('#HSNForm').modal('hide');
						//}, 500);
					}else if(htmlStr == 'false'){
						$('#mssg333').html('<span style="color:red;">Not Added.</span>');
					}else if(htmlStr == 'alreadyAdded'){
						$('#mssg333').html('<span style="color:red;">Already Exist.</span>');
					}
				}
			 });
		}
});
 function check(e,value){
    //Check Charater
        var unicode=e.charCode? e.charCode : e.keyCode;
        if (value.indexOf(".") != -1)if( unicode == 46 )return false;
        if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
    }
    function checkLength(len,ele){
    var fieldLength = ele.value.length;
    if(fieldLength <= len){
        return true;
    }
    else
    {
        var str = ele.value;
        str = str.substring(0, str.length - 1);
    ele.value = str;
    }
    }
	jQuery('.predaterange').datepicker({format: "dd/mm/yyyy",
        autoclose: true,
        orientation: "bottom",
        endDate: "today",
    }).on("changeDate", function (e) {
    	let reDirect  =$(this).attr('data-href');
    	let getDate = e.format();
    	window.location.href = `${site_url}${reDirect}?start=${getDate}`;
	});
    $(document).on('click','#export-menu li',function(){
    	var type = $(this).attr('id');
  		var urlString = window.location.href;
  		var url = new URL(urlString);
  		if( typeof(url.search) !== 'undefined' && url.search != '' ){
  			//window.location.href = `${site_url}/${url.pathname}${url.search}&ExportType=${type}`;
  			window.location.href = `${url.pathname}${url.search}&ExportType=${type}`;
  		}else{
  			//window.location.href = `${site_url}/${url.pathname}?ExportType=${type}`;
  			window.location.href = `${url.pathname}?ExportType=${type}`;
  		}
    })
    $(document).ready(function(){
    	$('.commanSelect2').select2();
    })
    $(document).on('click','.addMoreCustAlias',function(){
    	var html = $('#cuatomerNameAlias').clone();
    	
    	html.find('label').html('');
    	html.find('.customerSelect').siblings('span').remove();
    	html.find('.customerSelect').val('').trigger("change");
    	html.find('#aliasName').val('');
    	html.find('.remove_field').css('display','block');
    	$('#mainCustomerAlias').append(html);
    	var countRow = parseInt($('#countCustRow').val()) + 1;
    	$('#countCustRow').val(countRow);
    	init_select_customer();
    })
    $(document).on('click','.cuatomerNameAlias .remove_field',function(){
    	$(this).closest("#cuatomerNameAlias").remove();
    })
    function init_select_customer() {
		$('.customerSelect').select2({
			//dropdownCssClass: 'custom-dropdown'
			allowClear: true,
	       	placeholder: $(this).attr('placeholder'),
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
	         }
	    });
	}
	$(document).on('click','.checkViewMaterialTrns',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		var head = "";
		switch (tab) {
			case 'MaterialView':
				url = 'inventory/material_view';
				head = 'Material View';
			break;
			case 'Invoice':
				url = 'account/viewInvoice_details';
				head = 'Add Invoice Detail';
			break;
			case 'Sale_Order_Invoice_Creation':
				url = 'crm/viewSaleOrder';
				head = 'Add Invoice Detail';
			break;
			case 'Delivery_Challan_Outward':
				url = 'account/viewchalan_details';
				head = 'Challan Detail';
			break;
			case 'Delivery_Challan_Inward':
				url = 'account/viewchalan_detailsinward';
				head = 'Challan Detail';
			break;
			case 'Sale_Return':
				url = 'account/crSaleReturn_view_details';
				head = 'Sale Return CN';
			break;
			case 'Purchase_Return':
				url = 'account/DRSaleReturn_view_details';
				head = 'Purchase Return DN';
			break;
			case 'MrnView':
				url = 'purchase/mrn_view';
				head = 'Grn';
			break;
			case 'Sale_Order_Dispatched':
				url = 'crm/viewSaleOrder';
				head = 'Sale Order Dispatched';
			break;
		}
		
		$('.modal-title').html(head);
		
		$.ajax({
			url:site_url + url,
			method:'POST',
			data:{id:id},
			error: (error) => console.log( error ),
			success: (data) => {
				if(data != '') {	
					if($('#inventory_add_modal').length){
						$('#inventory_add_modal').modal('show');
						$('#inventory_add_modal .modal-body-content').html(data);
						/*if( tab == 'MrnView' || tab == 'Sale_Order_Dispatched'  ){*/
						$('#inventory_add_modal .modal-dialog.modal-lg').css('width','70%');
							
						/*}*/
					}
				}
			}
		})
	})
	 
/*HSN MASTER SCRIPT*/

function invet_action_get(evt,t){

$(document).ready(function(){

	var id = $(t).attr('id');
	var material_type_id = $(t).attr('data-materialType-id');

	var Action_Type = $(t).attr("data-id");

	var material_Type = $(t).attr("data-mat-type-name");

	var material_name = $(t).attr("data-mat-name");

	var material_uom = $(t).attr("data-uom");

	var uomname = $(t).attr("data-uomname");

	var dtqty = $(t).attr("data-qty");

	getAddressData();
	

	//setTimeout(function(){

		if(Action_Type == 'scrap'){

			$.ajax({

				type: "POST",

				url: site_url+'inventory/inventory_listing_edit/',

				data: {'id':id,

				'Action_Type' : Action_Type,

				},

				success: function(data){

					if(data != '') {

						$('#scrap_modal').modal('show');

						$('#scrap_modal .modal-body-content').html(data);

						validateActionsInInventoryListing();

						function_to_check_qty_in_listing();

						$('#Actiontype').val(Action_Type);

						$('#material_id').val(id);

						dateFunction();

						init_select2();

						init_select21();

						$('#material_type_id').val(material_type_id);

						$('.scrap_mat_name #material_name').text(material_name);

					}

				}

			});

		}else





			if(Action_Type == 'Rejected'){

			$.ajax({

				type: "POST",

				url: site_url+'inventory/inventoryRejected/',

				data: {'id':id,
				uom :material_uom,

				'Action_Type' : Action_Type,

				},

				success: function(data){

					if(data != '') {

						$('#rejected_modal').modal('show');
                          $('#rejected_modal .modal-body-content').html(data);

						validateActionsInInventoryListing();

						function_to_check_qty_in_listing();

						$('#Actiontype').val(Action_Type);

						$('#material_id').val(id);

						dateFunction();

						init_select2();

						init_select21();

						$('#material_name').text(material_name);

						$('#material_type_id').val(material_type_id);

						$('#uom').val(material_uom);

					}

				}

			});

		}
		
		
		
		
		
		else if(Action_Type == 'stock_check'){

			$.ajax({

				type: "POST",

				url: site_url+'inventory/inventory_listing_stockCheck/',

				data: {'id':id,

				'Action_Type' : Action_Type,

				},

				success: function(data){

					if(data != '') {

						$('#stock_modal').modal('show');

						$('#stock_modal .modal-body-content').html(data);

						validateActionsInInventoryListing();

						$('#Actiontype').val(Action_Type);

						$('#material_id').val(id);

						dateFunction();

						$('#material_type_id').val(material_type_id);

					}

				}

			});

		 }

		else if(Action_Type == 'consumed'){

			$.ajax({

				type: "POST",

				url: site_url+'inventory/inventory_listing_consumed/',

				data: {'id':id,

				'Action_Type' : Action_Type,

				},

				success: function(data){

					if(data != '') {



						$('#consumed_modal').modal('show');

						$('#consumed_modal .modal-body-content').html(data);

						validateActionsInInventoryListing();

						$('#Actiontype').val(Action_Type);

						$('#material_id').val(id);

						dateFunction();

						getAddressData();

						//getQuantity();



						function_to_check_qty_in_listing();

						//$('.consumed_mat_name #material_name').text(material_name);

						$('#material_name').text(material_name);

						$('#material_type_id').val(material_type_id);

						$('#uom').val(material_uom);

					}

				}

			});

		 }else if(Action_Type == 'move'){

			$.ajax({

				type: "POST",

				url: site_url+'inventory/inventory_listing_move/',

				data: {'id':id,

				'Action_Type' : Action_Type,

				},

				success: function(data){

					if(data != '') {

						$('#move_modal').modal('show');

						$('#move_modal .modal-body-content').html(data);

						validateActionsInInventoryListing();

						init_select2();

						getArea();

						dateFunction();

						getAddressData();

						init_selectlot();

						//getQuantity();

						function_to_check_qty_in_listing();

						$('#Actiontype').val(Action_Type);

						$('#material_id').val(id);

						$('#material_type_id').val(material_type_id);

						$('.material_name').text(material_name);

						var quantityValue=$('#quantity').val();

					}

				}

			});

		 }else if(Action_Type == 'half_full_book'){

			$.ajax({

				type: "POST",

				url: site_url+'inventory/inventory_listing_halfBook/',

				data: {'id':id,

				'Action_Type' : Action_Type,

				},

				success: function(data){

					if(data != '') {

						$('#book_modal').modal('show');

						$('#book_modal .modal-body-content').html(data);

						validateActionsInInventoryListing();

						init_select2();

						getMaterialName();
						getVarientOption();

						addMaterialDetail();

						dateFunction();

						function_to_check_qty_in_listing();

						$('#Actiontype').val(Action_Type);

						$('#material_id').val(id);

						$('#material_type_id').val(material_type_id);



						$('.material_type').val(material_Type);

						$('.material_name').val(material_name);

						$('#uom').val(material_uom);







					}

				}

			});

		 }

		else if(Action_Type == 'material_conversion'){

			$.ajax({

				type: "POST",

				url: site_url+'inventory/inventory_listing_materialConversion/',

				data: {'id':id,

				'Action_Type' : Action_Type,

				},

				success: function(data){

					if(data != '') {

						$('#material_conversion').modal('show');

						$('#material_conversion .modal-body-content').html(data);

						validateActionsInInventoryListing();

						init_select2();

						init_select221();

						getMaterialName();
						getVarientOption();

						addMaterialDetail();

						dateFunction();

						getUOMinmaterialconvrs();

						addLocationInConversion();

						getQuantityinconversion();

						addMoreProductincoversion();

						getArea();

						getAddressData();

						init_selectlot();

						function_to_check_qty_in_listing();



						$('#Actiontype').val(Action_Type);

						$('#material_id').val(id);

						$('#material_type_id').val(material_type_id);

						$('.material_name').text(material_name);

						// $('.material_type1').val(material_Type);

						// $('.getUom').val(material_uom);

						// $('.getUomname').val(uomname);

						// $('.getUomname22').html(uomname);

						//$('.dtqty').val(dtqty);

						if(material_uom == 6){

							$('.hideshow').show();

							$('.hideshow1').hide();

						}

						else

						{

							$('.hideshow').hide();

							$('.hideshow1').show();

						}

					}

				}

			});

		}

		//}, 1000);



		});

	}
$(window).on('load', function() {
  if ($('.ädding_dimension').is(':checked')) {
	$('.set_dimension').removeClass('hide'); 
  } else {
	$('.set_dimension').addClass('hide');  
  }
});	
$(document).on('change',  '.ädding_dimension', function() {
  if ($(this).is(':checked')) {
	$('.set_dimension').removeClass('hide'); 
  } else {
	$('.set_dimension').addClass('hide');  
  }
});

$(document).on('keyup',  '.set_dimension input', function() {
var values = [];
$(".dimension_lay input").each(function() {
values.push($(this).val());
});	
var total_val = values['0']*values['1']*values['2'];
var cbf_val = total_val/1728;
$('.cbf_val').val(cbf_val.toFixed(2));
});

$(window).on('load', function() {
packingSection();
});
$('#sale_purchase').on('click', ".flat1", function() {
packingSection();
});
function packingSection(){
$("#sale_purchase .flat1").each(function() {
if($('.flat1:checked').val() == "Sale"){
$('.packingSection').css('display', 'block');
} else {
$('.packingSection').css('display', 'none');	
}
});	
}
function getVarientOption(evt, t , selProcessType = '' , c_id = '' ){
	$(t).parent('.form-group').next('.form-group').find('.VariantOptionId').empty();
	var logged_user = $('#loggedUser').val(); 
	var option = $(t).find('option:selected');
	var varient_type_id = selProcessType != ''?selProcessType:$(option).val();
	/*
	if(varient_type_id != ''){	
		$(t).parent('.form-group').next('.form-group').find('.VariantOptionId').attr( { 'data-where':"variant_type_name = '"+varient_type_id+"'", 'data-id':"variant_options", 'data-key':"option_name", 'data-fieldname':"option_name" } );
		
		 setTimeout(function(){ 
				$('.select2-results__options').prepend('<li class=" sdfsd select2-results__option select2-results__option--highlighted" role="treeitem" aria-selected="true"><input type="checkbox" class="checkboxdata" >Select All</li>');
					
				$(".checkboxdata").click(function(){
					if($(".checkboxdata").is(':checked') ){
					$("#variant_value_1 > li").prop("selected","selected");// Select All Options
					$("#variant_value_1").trigger("change");// Trigger change to select 2
				}else{
					$("#variant_value_1 > li").removeAttr("selected");
					$("#variant_value_1").trigger("change");// Trigger change to select 2
				 }
			});
		}, 1000);
	*/	
	
	$.ajax({
		type: "POST",
		url: site_url + 'inventory/getvariants',
		data: {
			varient_type_id: varient_type_id
		},
		success: function (data) {
			var vairntdata = jQuery.parseJSON(data);
			var len = vairntdata.length;
			var slectdata = '';
			 // slectdata = '<option value="all">all</option>';
			for (var i = 0; i < len; i++) {
				var optionName = vairntdata[i].option_name;
				 slectdata += '<option value="' + optionName + '" selected >' + optionName + '</option>';
				
			}
			//$("#variant_value_1").append(slectdata);
			$(t).parent('.form-group').next('.form-group').find('.VariantOptionId').append(slectdata);
			
		
		}
	});
		
		
	}


function getcbf(evt, t) {
var option = $(t).find('option:selected');
var id = $(option).val();
$.ajax({
	type: "POST",
	url: site_url + 'inventory/getcbf',
	data: {
	    id: id
	},
	success: function (data) {
	$(t).parent('.form-group').next().next().next().next('.cbf_set').find('.packing_cbf').val(data);
	}
});

}

$(document).on('keyup',  '.rej_qty_chk', function() {
	var qty_val = $(this).val();
	var chk_val = $('.alreadyQTY').val();
// var qty_val = $(this).attr('data-qty');

if(parseInt(chk_val) < parseInt(qty_val)){

alert('Please enter less quantity');
$('.rej_qty_chk').val('');
}
});

// Add more Supplier 23-02-2022
$(document).on('click','.addMoreSupplierAlias',function(){
	var html = $('#SupplierNameAlias').clone();
	html.find('label').html('');
	html.find('.customerSelect').siblings('span').remove();
	html.find('.customerSelect').val('').trigger("change");
	html.find('#aliasName').val('');
	html.find('.remove_field').css('display','block');
	$('#mainSupplierAlias').append(html);
	var countRow = parseInt($('#countCustRow').val()) + 1;
	$('#countCustRow').val(countRow);
	init_select_customer();
})

$(document).on('click','.mainSupplierAlias .remove_field',function(){
	$(this).closest("#SupplierNameAlias").remove();
})

// Quality Check 24-02-2022
// Start Quality check
$(document).on('change','.quality_check',function(e){
	// alert('asdf');
	if($(this).val() == 1){
		$('#qualityCheckLink').css('display','block');
	}else{
		$('#qualityCheckLink').css('display','none');
	}
})
$(document).on('change','.beforeInsertQuality',function(e){
	if($(this).val() == 1){
		swal('After Submit You can create Quality format for this material');
	}
})

$(document).on('click','.createQualityFormat',function(e){
	
	$.ajax({
		url:`${site_url}/inventory/qualityFormatType`,
		method:'POST',
		data:{type:$(this).attr('formatType'),matId:$(this).attr('matId')},
		error: (error) => console.log( error ),
		success: (data) => {
			$('#quality_modal').modal('show');
			$('#quality_modal .modal-body-content').html(data);
			if( $(this).attr('formatType') == 'createFromat' ){
				 calculate();
				addMoreButton();
				init_select_uom();
				init_select_instrument();
			}else{
				$('#quality_modal .modal-body-content').css({'max-height':'400px','overflow':'auto'});
			}
		}
	})
})
function init_select_uom() {
	$('.uom').select2({
		allowClear: true,
		placeholder: 'UOM',
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
				$('#uom').val(searched_value);
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
}

function init_select_instrument() {
	$('.instrument').select2({
		allowClear: true,
		placeholder: 'Instrument',
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
				$('#instrument').val(searched_value);
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
}
function calculate(clrt){
    var exp=$(clrt).parents("tr").find(".exp").val();
    var min_dev=$(clrt).parents("tr").find(".min_dev").val();
	var max_dev=$(clrt).parents("tr").find(".max_dev").val();
    if(exp==='')
    {
    exp=0;
    }
     if(min_dev==='')
    {
    min_dev=0;
    }

    if(max_dev==='')
    {
    max_dev=0;
    }


	var cal_min_dev=exp-min_dev;

	var cal_max_dev=parseFloat(exp)+parseFloat(max_dev);

	$(clrt).parents("tr").find(".exp_min_dev").val(cal_min_dev);
    $(clrt).parents("tr").find(".exp_max_dev").val(cal_max_dev);
}

function addMoreButton() {
	$('.addMoreButton').click(function() {
		var i = 2;
		var logged_user = $('#loggedInUserId').val();
		var inc = $('#inctr').val();
		var str = `<tr>
                     <td class="sno">${i}</td>
                     <td><input type="text" style="width:70px" name="report[create${inc}][parameter]"/></td>
                     <td><select class="instrument  form-control selectAjaxOption select2" name="report[create${inc}][instrument]"  width="100%" id="instrument" data-id="instrument" data-key="id" data-fieldname="name" data-where="created_by_cid=${logged_user}" tabindex="-1" aria-hidden="true"></select></td>
                     <td>
                        <select class="uom  form-control selectAjaxOption select2" name="report[create${inc}][uom1]"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid=${logged_user} AND active_inactive=1" tabindex="-1" aria-hidden="true" >
                        </select>
                     </td>
                     <td><input type="number" class="exp" name="report[create${inc}][expectation]" style="width:70px" onkeyup ="calculate(this)"  onclick="calculate(this)" /></td>
                     <td><input type="number" class="min_dev" name="report[create${inc}][deviation_min]" style="width:70px" onkeyup="calculate(this)"  onclick="calculate(this)"/></td>
                     <td><input type="number" class="max_dev" name="report[create${inc}][deviation_max]" style="width:70px" onkeyup="calculate(this)"  onclick="calculate(this)"/></td>
                     <td><input type="number" class="exp_min_dev"  name="report[create${inc}][exp_min_dev]" style="width:70px"  onkeyup="calculate(this)" readonly/></td>
                     <td><input type="number" class="exp_max_dev" name="report[create${inc}][exp_max_dev]" style="width:70px"  onkeyup="calculate(this)"  onclick="calculate(this)"readonly/></td>
                     <td><button type="button" class="btn_danger" id="remove_row">x</button></td>
                  </tr>`;
		$("#example tbody").append(str);
		$('#inctr').val(parseInt(inc) + 1);
		i++;


		if ($('table tr').length > 1) {
			$(this).closest('tr').remove();
			$('td.sno').text(function(i) {
				return i + 1;
			});
		}
		init_select_uom();
		init_select_instrument();

	});
}

// End Quality check

$(document).on('click','#update_percentage',function(e){
	if($('.update_percentage').val() != ''){
		var percentage = $('.update_percentage').val();
		$('#sale_price_updatde tr .checkboxSaleOrder:checked').each(function(){
		var parent_id = $(this).parents('tr').attr('id');
		var previous_price = $('#'+parent_id).find('.previous_price').text();
		var cal_percentage = previous_price*percentage/100;
		var total_change_val = parseFloat(previous_price) + parseFloat(cal_percentage);
		$('#'+parent_id).find('.change_prz').val(total_change_val);
	});
	} else {
		alert('Please enter the percentage number.');
	}
});



$(document).on('change','.indent_create',function(e){
	e.preventDefault();
	var set = [];
	$('.indent_create:checkbox:checked').each(function(key, value) {
		$('.indent_create_btn').prop("disabled", false);
	var closestId = $(this).closest(".well").attr("id");
	set.push($('#' + closestId + ' .indent_create').val());  
	});
	if(set == ''){
	//$(".indent_create_btn").hide();    
	} else {
	$(".indent_create_btn").show();    
	}
	$(".all_indent_create").prop('checked', false);
	$(".indent_create_btn").attr('data-set', set);
});

$(document).on('change','.all_indent_create',function(e){
	e.preventDefault();
	if ($(this).is(':checked')){
		$('.indent_create_btn').prop("disabled", false);
	var set = [];
	$('.indent_create').each(function(key, value) {
	var closestId = $(this).closest(".well").attr("id");
	set.push($('#' + closestId + ' .indent_create').val());  
	});
	if(set == ''){
	//$(".indent_create_btn").hide();    
	} else {
	$(".indent_create_btn").show();    
	}
	$(".indent_create").prop('checked', true);
	$(".indent_create_btn").attr('data-set', set);
	} else {
		$('.indent_create_btn').prop("disabled", true);
	$(".indent_create").prop('checked', false);
	//$(".indent_create_btn").hide(); 
	$(".indent_create_btn").attr('data-set', '');
	}
});




	$('.getBuyerState').on('change',function() {
		var buyerstate = $(this).val();
		
		$.ajax({
			type: "POST",
			url: site_url + 'inventory/get_buyerstate',
			data: {
				buyerstate: buyerstate
			},
			success: function(htmlStr) {
				var obj = jQuery.parseJSON(htmlStr);
				//console.log('Checkk===>',obj);
				$('#party_billing_state_id').val(htmlStr);
				
				var salestateID = $('#sale_company_state_id').val();
				// alert(salestateID);
				// alert(htmlStr);
				if (salestateID != htmlStr) {
					var totalTax = $('.totalTaxValue').val();
					
					// alert(totalTax);
						$('.cgsttdata').hide();
						$('.sgsttdata').hide();
						$('.igstdata').css("display", "block");
						$('.crnote-total-taxIGST').val(totalTax);
						
					} else {
						// alert('else');
						var totalTax = $('.totalTaxValue').val();
						var result_divide = parseFloat(totalTax) / parseFloat(2);
						$('.crnote-total-taxIGST').val(totalTax);
						$('.cgsttdata').css("display", "block");
						$('.sgsttdata').css("display", "block");
						$('.igstdata').hide();
						$('.crnote-total-taxSGST').val(result_divide);
						$('.crnote-total-taxCGST').val(result_divide);
					}
			}
		});
	});
						$('#debitnotedate').datepicker({ 
								//startDate: date,
								format: "dd-mm-yyyy",
								autoclose: true
							});
						$('#debitnotedate').on('changeDate', function (e) {
							$('.debitnotedate').closest('.item').removeClass('bad');
						});
						
						
						
						
						
						
						
						
						
						