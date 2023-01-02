
// Function to change the status of lead
/*
$(document).on("click",".close_unqstatus_model",function(){
	$('.nav-md').addClass('modal-open');
	 
});	*/
function changeStatus(id='' , status='',oldStatus=''){
	$('.selected').prev('.step_no').addClass('previous');
	var status_comment = '';
	if(status == 9 || status == 8){ // if status of lead is unqualified or loose show modal for reason
		$('.leadStatusCommentModal').modal('show');

		$('#status_comment_btn').click(function(e){
			status_comment = $('#status_comment').val();
			var data = {
				id: id,
				status: status,            
				status_comment: status_comment,            
			};


			console.log("fff");
			changeStatusAjaxCall(data);

			//$('.nav-md').addClass('modal-open');
	 		//$('.leadStatusCommentModal').modal('open');
		})

	}else{
		var data = {
				id: id,
				status: status,  
				status_comment: '',
			};
		if(confirm("Are you sure?")){
			changeStatusAjaxCall(data);
			$('.step_no').css('background','#ccc');
			$('#status_id_'+status).css('background','');
			$('#status_id_'+status).addClass('selected');
			
			$(this).parents("li").prev('.selected').addClass('selected');
				
			//$('#status_id_'+status).find('.selected').prev('.step_no').addClass('previous');
		}	
			
		//changeStatusAjaxCall(data);	
	}
	
	// $('#status_id_'+status).css('background','');
}


// Function to Change the status of lead in database
function changeStatusAjaxCall(data = ''){

	$.ajax({        
			url: site_url +'bid_management/change_tender_status/',
			dataType: 'json',
			type: 'POST',
			data: data,
			success: function(result){
			if(result.status == 'success') {

				if(data.status == 5 || data.status == 8){
					
					$('.nav-md').addClass('modal-open');

					console.log('data===>>>',data);

				}
				if(data.status == 2){
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
function getAccountDetails(){
	$("#account_id").on("select2:select", function (e) { 
		$("#contact_id").empty();
		var selectAccountVal = $(e.currentTarget).val();
		var whereContactContact = "account_id='"+selectAccountVal+"'";
		$("#contact_id").attr("data-where", whereContactContact);
		$.ajax({        
			url: site_url +'crm/getAccountDataById/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: selectAccountVal,    
			},
			success: function(result){				
				$('#phone_no').val(result.phone);
				$('#gstin').val(result.gstin);
				$('#email').val(result.email);				
				$.ajax({        
					url: site_url +'crm/fetchLocationById/',
					dataType: 'json',
					type: 'POST',
					data: {
						billing_city: result.billing_city,    
						billing_state: result.billing_state,    
						billing_country: result.billing_country,    
					},
					success: function(resultData){
						if(resultData != '') {
						console.log('resultData==>>>',resultData);
						var address = result.billing_street+'\n'+resultData.city+'\n'+result.billing_zipcode+'\n'+resultData.state+'\n'+resultData.country;
						$('#address').html(address);
						}						
					}	
				});
			}	
		});		
		
		$("#contact_id").on("select2:select", function (e) { // get phone number by contact id in sale order or proforma invoice
			var selectContactVal = $(e.currentTarget).val();
			$.ajax({        
				url: site_url +'crm/getContactDataById/',
				dataType: 'json',
				type: 'POST',
				data: {
					id: selectContactVal,    
				},
				success: function(result){
					$('#contact_phone_no').val(result.phone);
				}	
			});
		});		
	}); 
}



if(typeof measurementUnits != 'undefined' && measurementUnits){	
	measurementUnits = JSON.parse(measurementUnits);
	var measurmentArray = '';
	$.each( measurementUnits, function( key, value ) {
			measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
	});
}


function getMaterials(x = ''){
	var option = '';
	$.ajax({
		type:'POST',
		url:site_url+'crm/getMaterials/',
		data: {
			//'material_id': matId,
		},
		success:function(data){
			var dataObj =JSON.parse(data);
			if(dataObj){						
				option = '<option value="">Select product</option>';
				$(dataObj).each(function(){
					option = option+'<option value="'+this.id+'" data-tax="'+this.tax+'">'+this.material_name+'</option>';	
				});		
			$('#chkIndex_'+x+' .product').append(option);						
			}else{
				$('.material_name').html('<option value="">State not available</option>');
			}
		}
	}); 		
}



// Function to get tax of material
function getTax(evt, t){	
	var option = $(t).find('option:selected');
	var materialId = option.val();
	var closestId = $(t).closest(".well").attr("id");
	$.ajax({
		type: "POST",
		url: site_url + 'bid_management/getMaterialDataById',
		data: {id:materialId}, 
		success: function(data){
			if(data != '') {	
				var dataObj =JSON.parse(data);
				parseFloat($("#"+closestId+" input[name='gst[]'").val(dataObj.tax));
				parseFloat($("#"+closestId+" input[name='uom1[]'").val(dataObj.uom));

				parseFloat($("#"+closestId+" input[name='uom[]'").val(dataObj.uomid));

				parseFloat($("#"+closestId+" input[name='quantity[]'").val(''));
				parseFloat($("#"+closestId+" input[name='price[]").val(dataObj.sales_price));
				parseFloat($("#"+closestId+" input[name='individualTotal[]'").val(''));
				parseFloat($("#"+closestId+" input[name='individualTotalWithGst[]'").val(''));
				$(".divTotal").html(0);
				$(".divSubTotal").html(0);
				
			}
		}
	}); 	  
	var tax = option.attr('data-tax');
	var closestId = $(t).closest(".well").attr("id");
	parseFloat($("#"+closestId+" input[name='gst[]'").val(tax));
}

function poPriceCalculation(evt, t){
	var closestId = $(t).closest(".well").attr("id");
	var qty = $("#"+closestId+" input[name='quantity[]'").val();
	var price = $("#"+closestId+" input[name='price[]'").val();
	var gst = $("#"+closestId+" input[name='gst[]'").val();
	var individualTotal = parseFloat(qty) * parseFloat(price);
	if(isNaN(individualTotal)) {
		var individualTotal = 0;
	}
	var individualTotal_decimal = individualTotal.toFixed(2);
	
	var individualTaxPrice = (individualTotal * gst ) / 100;	
	var individualPriceWithGstTotal = individualTotal + individualTaxPrice;	
	if(isNaN(individualPriceWithGstTotal)) {
		var individualPriceWithGstTotal = 0;
	}
	var individualPriceWithGstTotal_decimal = individualPriceWithGstTotal.toFixed(2);
	parseFloat($("#"+closestId+" input[name='individualTotal[]'").val(individualTotal_decimal));
	parseFloat($("#"+closestId+" input[name='individualTotalWithGst[]'").val(individualPriceWithGstTotal_decimal));
	var total = 0;
	$(".individualTotal").each(function(key,value) {
		 total = parseFloat(total) + parseFloat($(value).val());		
	});
	if(isNaN(total)) {
				var total = 0;
			}
	var grandTotal = 0;
	$(".individualTotalWithGst").each(function(key,value) {
		 grandTotal = parseFloat(grandTotal) + parseFloat($(value).val());		
	});	
	
	if(isNaN(grandTotal)) {
		var grandTotal = 0;
	}
	
	if($("input[name='agt']").length &&  $("input[name='agt']").val() != ''){
		grandTotal = grandTotal+ parseFloat($("input[name='agt'").val());
		
	}
	parseFloat($("input[name='total'").val(total));
	parseFloat($("input[name='grandTotal'").val(grandTotal));
	parseFloat($(".divSubTotal").text(total));
	parseFloat($(".divTotal").text(grandTotal));
	//var individualTotalWithGst	
}







$(document).on("click",".validate1",function(){ 
	if(confirm('Are you sure!') == true) {
		var row = $(this).closest('tr');
		var loggedInUserId = $('#loggedInUserId').val();
		var nameAttributeId = $(this).attr('name');
		nameAttributeId = nameAttributeId.split("_");
		var sale_order_id = nameAttributeId[1];
		//var sale_order_id = row.find("td.sale_order_id:nth-child(1)").text();
		$.ajax({
		    type: "POST",
		    url: site_url+'crm/approveSaleOrderindi/',
		    data: { id:sale_order_id, approve:1, validated_by:loggedInUserId }, 
		    success: function(result) {
			    if(result != '') {
				    var obj = $.parseJSON(result);
				   if(obj.status == 'success') {					 
						window.location.href = site_url+'crm/sale_orders/';
				   } 
			    }
		   }
		}); 	
}

});



// Add/Edit Modal for CRM submodules 
$(document).on("click",".add_bid_mng_tabs",function(){
	var id = $(this).attr('id');
	var tab = $(this).attr('data-id');
	var start_date = $(this).attr('data-date')?$(this).attr('data-date'):'';
	var url = '';
	switch (tab) {
		case 'register_opportunity_edit':
			url = 'bid_management/edit_register_opportunity';
			data = {id:id};
			break;
		case 'sale_order_edit':
			url = 'bid_management/edit_sale_order';
			data = {id:id};
			break;
		case 'hrm_task_edit':
			url = 'bid_management/edit_hrm_task';
			data = {id:id};
			break;
		case 'register_opportunity_con':
			url = 'bid_management/con_register_opportunity';
			data = {id:id};
			break;
		case 'register_opportunity_rank':
			url = 'bid_management/rank_register_opportunity';
			data = {id:id};
			break;
		case 'register_opportunity_view':
			url = 'bid_management/view_register_opportunity';
			data = {id:id};
			break;
		case 'liasoning_agent_edit':	
			url = 'bid_management/edit_liasoning_agent';
			data = {id:id};
			break;
		case 'meeting_edit':	
			url = 'bid_management/edit_meeting';
			data = {id:id};
			break;
	    case 'view_meeting':	
			url = 'bid_management/view_meeting_schedule';
			data = {id:id};
			break;
	    case 'meeting_detail':	
			url = 'bid_management/detail_meeting';
			data = {id:id};
			break;
		case 'meeting_cancel':	
			url = 'bid_management/cancel_meeting';
			data = {id:id};
			break;
		case 'view_meeting_detail':
		url = 'bid_management/view_meeting';
			data = {id:id};
			break;
		case 'competitor_details':
			url = 'bid_management/competitor_details_edit';
			data = {id:id};
			break;
		case 'view_competitor_details':
			url = 'bid_management/competitor_details_view';
			data = {id:id};
			break;
		case 'add_price':
			url = 'bid_management/addPrice_edit';
			data = {id:id};
			break;
	/**	case 'add_price_view':
			url = 'bid_management/addPrice_view';
			data = {id:id};
			break;**/
		case 'account_view':
			url = 'bid_management/viewAccount';
			data = {id:id};
			break;
		case 'add_tender':
			url = 'bid_management/addtender_edit';
			data = {id:id};
			break;

		case 'add_price_prodct':
		    url = 'bid_management/add_price_prodct_edit';
		    data = {id:id};
		    break;
		case 'view_price_prodct':
		    url = 'bid_management/add_price_prodct_view';
		    data = {id:id};
		    break;	
		    
		case 'liasoning_agent_view':	
			url = 'bid_management/liasoning_agent_view';
			data = {id:id};
			break;
	}

			
		if(tab == 'register_opportunity_edit'){
		    $('.nxt_cls').html('Edit Register Opportunity');
		}
		

		if(tab == 'register_opportunity_view'){
		    $('.nxt_cls').html('View Register Opportunity');
		}

	$.ajax({
		type: "POST",
		url: site_url + url,
		//data: {id:id}, 
		data: data, 
		success: function(data){
			if(data != '') {
				$("#crm_add_modal").modal({
					show:false,
					backdrop:'static'
				});
				$('#crm_add_modal').modal('toggle');
				$('#crm_add_modal .modal-body-content').html(data);	
					
					/*if($('#btnPrint').length!==0){
						document.getElementById("btnPrint").onclick = function () {
							$('#crm_add_modal .modal-body-content').window.print();
						}
					}*/
		
					 $('.datePicker').daterangepicker({  // To select the date for filter sale target by month and year 
						singleDatePicker: true,
						 locale: {
							  // format: 'YYYY-MM-DD',
							   format: 'DD-MM-YYYY',
						 }
						 }, function(start, end, label) {			
					 });
					
           // $( ".datePicker" ).datepicker();
           
					
					$('.datePickerBefore').daterangepicker({ // To hide dates after current date in date picker
						singleDatePicker: true,
						maxDate: new Date(),
						locale: {
							   format: 'DD-MM-YYYY',
						 },
						//singleClasses: "picker_3"
					}, function(start, end, label) {
						console.log(start.toISOString(), end.toISOString(), label);
					});	
					  
					
					$('input[name="start_date"]').daterangepicker({  // To select the date for filter sale target by month and year 
						singleDatePicker: true,
						//singleClasses: "picker_3",								
						locale: {
							  //format: 'YYYY-MM-DD',
							  format: 'YYYY-MM',
						}
						}, function(start, end, label) {			
					});


				if(tab =='register_opportunity_edit'){
					addMoreLeadContacts();
					addMorebidAttachments();
					addMoreAttachments();
					addMorepoAttachments();
					addMoreConsignee();
					addMorepoConsignee();
					activityDateRangeSelector();
					addMoreChatterAttachments();
					LeadsAddMoreMaterial();
					keyupFunction();	
				}
				else if(tab == 'competitor_details'){
				getMaterialNameCA();
				addMaterialDetailCA();
				select2CA();
				init_select2();
				init_select221();
				init_select22();
				init_select212();
				Print_data_new();
				}

				else if(tab == 'add_price'){
					addMaterialDetailCA();
					getMaterialNameCA();
					getMatDetails();
					select2CA();
					init_select2();
				init_select221();
				init_select22();
				init_select212();
				Print_data_new();
				}

				else if(tab  == 'add_price_prodct'){
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
				else if(tab == 'add_tender'){
				addMoreLeadContacts();
					addMorebidAttachments();
					addMorepoAttachments();
					addMoreAttachments();
					addMoreConsignee();
					addMorepoConsignee();
					activityDateRangeSelector();
					addMoreChatterAttachments();
					LeadsAddMoreMaterial();
					keyupFunction();
					addCompetitorDetail();
					addMaterialDetailCA();
					getMaterialNameCA();
					select2CA();
					init_select2();
				init_select221();
				init_select22();
				init_select212();
				Print_data_new();
				}
				else if(tab == 'register_opportunity_con'){
					addMoreLeadContacts();
					addMorebidAttachments();
					addMoreAttachments();
					addMorepoAttachments();
					addMoreConsignee();
					addMorepoConsignee();
					activityDateRangeSelector();
					addMoreChatterAttachments();
					LeadsAddMoreMaterial();
					keyupFunction();
					addCompetitorDetail();
					addMaterialDetailCA();
					getMaterialNameCA();
					select2CA();
					init_select2();
				init_select221();
				init_select22();
				init_select212();
				Print_data_new();
				}
				else if(tab == 'sale_order_edit'){
				getAddress();
				getAccountDetails();
				}
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
						
				init_select2();
				init_select221();
				init_select22();
				init_select212();
				Print_data_new();
				//fnValidateGSTIN();	
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

function dateFunction(){
	$('#dob').datepicker({
	 dateFormat : 'yyyy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d',
			endDate: 'today',
		
		autoclose: true
    });
	
	$('#dispatch_date').datepicker({
	 dateFormat : 'yyyy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d',
		autoclose: true
    });
	
	$('#payment_date').datepicker({
	 dateFormat : 'yyyy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d',
		autoclose: true
    });
}
// Function to display add more contact functionality in lead
function addMoreLeadContacts(){
	/* add more multiple contacts */
	var maximum_add     = 10; //maximum input boxes allowed
	var inputfield        = $(".input_holder"); //Fields wrapper
	var add_more  = $(".addMoreLead"); //Add button ID
	var x = 1; //initlal text box count
	$(add_more).click(function(e){ //on add input button click
		e.preventDefault();		
		if(x < maximum_add){ //max input box allowed
			x++; 
			$(inputfield).append('<div class="well scend-tr mobile-view" id="chkIndex_'+x+'"><div class="item form-group col-md-4 col-xs-12"><label class="col-md-12 col-sm-12 col-xs-12" for="name">Tender Name<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input id="name" class="form-control col-md-7 col-xs-12" value="" name="tender_name[]" placeholder="" required="required" type="text" ></div></div><div class="item form-group col-md-4 col-xs-12"><label class="col-md-12 col-sm-12 col-xs-12" for="name">Department Name</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input id="department_name" class="form-control col-md-7 col-xs-12" value="" name="department_name[]" placeholder="" type="text"></div></div><div class="item form-group col-md-4 col-xs-12"><label class="col-md-12 col-sm-12 col-xs-12" for="email">Tender Link</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="email" name="tender_link[]"  class="form-control col-md-7 col-xs-12" placeholder="" value=""></div></div><button class="btn btn-danger del_field" type="button"> <i class="fa fa-minus"></i></button>');
		}
		var mat_id = $('#material_type').val();
	});  
	$(inputfield).on("click",".del_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	});	
}
/**********************add more material in leads**************************/
function LeadsAddMoreMaterial(){
	var maximum      = 12; //maximum input boxes allowed
	var material_div = $(".input_detail"); //Fields wrapper
	var add_more_btn    = $(".addMoreButton"); //Add button ID
	var inc = $('.input_detail .well').length; //initlal text box count
	// var inc = 1; //initlal text box count
		$(add_more_btn).click(function(e){//on add input button click
			e.preventDefault();	
				if(inc < maximum){ //max input box allowed
					inc++; 
	
		$(material_div).append('<div class="well scend-tr mobile-view" id="chkIndex_'+inc+'"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Material Name <span class="required">*</span></label><select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name_id[]" onchange="getUom(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Description</label><textarea id="description" name="description[]" rows="1" class="form-control col-md-7 col-xs-12 description"></textarea></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12" >Quantity &nbsp;&nbsp;UOM</label><input type="text" id="quantity" name="qty[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)" required="required"><input type="text" id="uom" name="uom_material1[]" placeholder="Uom" class="form-control col-md-7 col-xs-12"  value="" readonly><input type="hidden" name="uom_material[]" id="uom1" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Price</label><input type="text" name="price[]" placeholder="pp" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12">GST </label><input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12">Total</label><input type="text" name="totals[]" placeholder="total" class="form-control col-md-7 col-xs-12 total" min="0" readonly value=""></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label class="col-md-12 col-xs-12" >GST Total </label><input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst" value="" readonly></div><button class="btn form-group btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
		var logged_user = $('#loggedUser').val();							
		var material_type_id = $('#material_type_id').val();
		select2(material_type_id , logged_user);	
		}
		init_select2();
		init_select221();
		//keyupFunction();
		});
		$(material_div).on("click",".delete_btn", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); inc--;
			keyupFunction(event,this);
			remove_calculation_quot_pi_so();

		});
}

/*get material name when select material type*/
function getMaterialName(evt, t , selProcessType = '' , c_id = '' ){
	//$('.materialNameId').empty();
	$('.materialNameId').val('');
	$(".uom").val('');
	$(".amount").val('');
	var logged_user = $('#loggedUser').val();
	var option = $(t).find('option:selected');
	var material_type_id = selProcessType != ''?selProcessType:$(option).val();
	if(material_type_id != ''){
		select2(material_type_id , logged_user);
	}
}

function select2(material_type_id , logged_user){
		$('.materialNameId').attr('data-where','material_type_id = '+material_type_id+' AND created_by_cid='+logged_user+' AND status=1');
		$('.materialNameId').attr('data-id','material');
		$('.materialNameId').attr('data-key','id');
		$('.materialNameId').attr('data-fieldname','material_name');

}

/******************** Select on record approve dissapprove ******************************************/

// approve
$(document).on("click",".validatesr",function(){ 
  if(confirm('Are you sure!') == true) {
    var row = $(this).closest('tr');

  var nameAttributeId = $(this).attr('name');
  nameAttributeId = nameAttributeId.split("_");
    var loggedInUserId = $('#loggedInUserId').val();


     var checkValues = $('.checkbox1:checked').map(function()
                    {
                        return $(this).val();
                 }).get();
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                        });

            console.log('Approve Values=>>>>>',checkValues);
    $.ajax({
        type: "POST",
        url: site_url+'bid_management/approve_bid_by_selection/',
        data: {id:checkValues, approve:1, validated_by:loggedInUserId,nameAttributeId:nameAttributeId}, 
        success: function(result) {
          if(result != '') {
            var obj = $.parseJSON(result);
           if(obj.status == 'success') {           
            window.location.href = site_url+'bid_management/register_opportunity/';
           } 
          }
       }
    }); 


  }
});

$(document).on("click",".validate",function(){
		var nameAttributeId = $(this).closest('tr').find(".validate").attr('name');
		nameAttributeId = nameAttributeId.split("_");
		 if(confirm('Are you sure!') == true) {
								var loggedinUser = $('#loggedInUserId').val();
								var register_id = nameAttributeId[1];
								//var indent_id = nameAttributeId[1];
									//console.log("indent_id",indent_id);
									$.ajax({
									   type: "POST",
									   url: site_url+'bid_management/approve_bid/',
									   data: { id:register_id, approve:1, validated_by:loggedinUser }, 
									   success: function(result) {
											 if(result != '') {
											//var obj = $.parseJSON(result);
											var obj = JSON.parse(result);
											//alert(obj.msg);
											   if(obj.status == 'success') {
													location.reload();
													 
											   } 
										   }
									   }
									
								 });
					}				
	});

//disapprove
$(document).on("click", ".disapprove", function () {
	var row = $(this).closest('tr');
	//var indent_id = row.find("td.indent_id:nth-child(1)").text();	
	var nameAttributeId = $(this).attr('name');
	nameAttributeId = nameAttributeId.split("_");
	var register_id = nameAttributeId[1];
  var checkValues = $('.checkbox1:checked').map(function()
                    {
                        return $(this).val();
                    }).get();
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                        });
    if ($('.checkbox1:checked')){ 
         $(".disapproveReasonModal #register_id").val(checkValues);
      }
     if ($(".checkbox1").prop('checked')==false){ 
          console.log('Value=>>>>>>',register_id);
        $(".disapproveReasonModal #register_id").val(register_id);
    }
	var disapprove_reason = row.find("td .disapprove_reason").text();
	//$(".disapproveReasonModal #indent_id").val(indent_id);
	$(".disapproveReasonModal #disapprove_reason").text(disapprove_reason);
    $('.disapproveReasonModal').modal('show');
});

/*get tax and amount of selected material*/
	function getUom(evt, t){
		var option = $(t).find('option:selected');	
		var materialId = option.val();
		var closestId = $(t).closest(".well").attr("id");
		console.log("closestId",closestId);
		$.ajax({
			type: "POST",
			url: site_url + 'bid_management/getMaterialDataById',
			data: {id:materialId}, 
			success: function(data){
				console.log("data",data);
				if(data != '') {
					var dataObj =JSON.parse(data);
					$("#"+closestId+" .amount").val(dataObj.sales_price);
					$("#"+closestId+" #uom").val(dataObj.uom);

					$("#"+closestId+" #uom1").val(dataObj.uomid);


					$("#"+closestId+" .gst").val(dataObj.tax);
					//$("#"+closestId+" .uom_material").val(dataObj.inventory_unit);
					// $("#"+closestId+" .uom_material").val(dataObj.uom);
					// $("#"+closestId+" .amount").val(dataObj.sales_price);
					// $("#"+closestId+" .gst").val(dataObj.gst);
					// $("#"+closestId+" #uom").val(dataObj.uom);
				}
			}
		}); 
	
	}


/**********************keup function to calculate****************************/
function keyupFunction(evt , t){
		var closestId = $(t).closest(".well").attr("id");
		var qty = $("#"+closestId+" input[name='qty[]'").val();
		var price = $("#"+closestId+" input[name='price[]'").val();
		var gst = $("#"+closestId+" input[name='gst[]'").val();
		
		
		var individual_Total = parseFloat(qty) * parseFloat(price);
		if(isNaN(individual_Total)) {
		var individual_Total = 0;
		}
		var individualTotal_withdecimal = individual_Total.toFixed(2);
	//console.log("individualTotal_decimal",individualTotal_decimal);
		var individual_TaxPrice = (individual_Total * gst ) / 100;	
	//console.log("individualTaxPrice",individualTaxPrice);
	
		var individualPrice_WithGstTotal = individual_Total + individual_TaxPrice;	
		if(isNaN(individualPrice_WithGstTotal)) {
			var individualPrice_WithGstTotal = 0;
		}
	//console.log('individualPriceWithGstTotal1',individualPriceWithGstTotal);
		var individualPrice_WithGstTotal_decimal = individualPrice_WithGstTotal.toFixed(2);
		parseFloat($("#"+closestId+" input[name='totals[]'").val(individualTotal_withdecimal));
		parseFloat($("#"+closestId+" input[name='TotalWithGsts[]'").val(individualPrice_WithGstTotal_decimal));
	
		var total = 0;
		$(".total").each(function(key,value) {
			 total = parseFloat(total) + parseFloat($(value).val());		
		});
		if(isNaN(total)) {
			var total = 0;
		}
		var grandTotal = 0;
		$(".totalWithGst").each(function(key,value) {
			console.log("ffff",value);
			console.log("key",key);
			grandTotal = parseFloat(grandTotal) + parseFloat($(value).val());		
		});	
		if(isNaN(grandTotal)) {
			var grandTotal = 0;
		}
		console.log("dddtotal",grandTotal);


		if($("input[name='agt']").length &&  $("input[name='agt']").val() != ''){
		grandTotal = grandTotal+ parseFloat($("input[name='agt'").val());
		
		}

		parseFloat($("input[name='total'").val(total));
		parseFloat($("input[name='grandTotal'").val(grandTotal));


		//$("#grand_total").val(grandTotal.toFixed(2));

		//$("#totalwithoutgst").val(total.toFixed(2));

		parseFloat($(".divSubTotal").text(total));
		parseFloat($(".divTotal").text(grandTotal));

		var grand_total_val = $("[name='total']").val();
		 if(grand_total_val > 0 || grand_total_val != ''){
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
function getState(evt, t , type = ''){	
	var appendedClass = type != ''?'.'+type+'.state_id':'.state_id';
	var appendedClassCity = type != ''?'.'+type+'.city_id':'.city_id';	
	$(appendedClass).empty();
	$(appendedClassCity).empty();	
	var option = $(t).find('option:selected');
	//var country_id = type != ''?type:$(option).val();
	var country_id =$(option).val();
	if(country_id != ''){
		$(appendedClass).attr('data-where','country_id = '+country_id);		
		$(appendedClass).attr('data-id','state');
		$(appendedClass).attr('data-key','state_id');
		$(appendedClass).attr('data-fieldname','state_name');	
	}
}


function getCity(evt , t, type = ''){
	var appendedClass = type != ''?'.'+type+'.city_id':'.city_id';
	$(appendedClass).empty();	
	var option = $(t).find('option:selected');
	//var state_id = type != ''?type:$(option).val();
	var state_id = $(option).val();
	if(state_id != ''){	
		$(appendedClass).attr('data-where','state_id = '+state_id);
		$(appendedClass).attr('data-id','city');
		$(appendedClass).attr('data-key','city_id');
		$(appendedClass).attr('data-fieldname','city_name');	
	}	
}		
	

	
/* function to filter activity log data of lead/account by date range selector */	  
function activityDateRangeSelector() {
	$('input[name="activityDateRange"]').daterangepicker({
		opens: 'left',
		locale: {	  
	    format: 'DD-MM-YYYY',
		},
	}, function(start, end, label) {
			var lead_id = $('input[name="lead_id"]').val();
			var id = $('input[name="activityRelId"]').val();
			var table = $('input[name="activityRelTable"]').val();
			var fromDate = start.format('YYYY-MM-DD');
			var toDate = end.format('YYYY-MM-DD');
			$.ajax({        
				url: site_url +'crm/activityFilter/',
				dataType: 'json',
				type: 'POST',
				data: {
					id: id,
					fromDate: fromDate,            
					toDate: toDate,            
					table: table,            
				},
				success: function(result){
					var activityLog = '';
					if(result.length >0){
						$(result).each(function( i ) {
							if(this.activity_type == 'New Task'){
								var img = 'tasks.png';
							}else if(this.activity_type == 'Call Log'){
								var img = 'Call-Log.png';
							}else{
								var img = 'chat.png';
							}
							activityLog += '<li><i class="fa '+icon+'"></i><div class="message_date">'+this.created_date+'</div><div class="message_wrapper"><h4 class="heading">'+this.subject+'</h4>';
							activityLog += '<blockquote class="message">'+this.comment+'</blockquote>';
							
							
							 if(this.activity_type == 'New Task'){
								activityLog += 	'Due date : '+ this.due_date;
										}
										
										
							if(this.attachment){							
								activityLog += '<div class="col-md-12">';
								$(this.attachment).each(function( index ) {
									activityLog += '<div class="col-md-2"><div class="image view view-first"><img style="width: 100%; display: block;" src="'+site_url+ 'assets/modules/crm/uploads/'+this.file_name+'" alt="image" class="undo"/></div></div>'; 
								}); 
								activityLog += '</div>';
							}	
							activityLog += '</li>';	
							
						});
					$('.activityMessage').html(activityLog);						
					}else{
						$('.activityMessage').html('<li>No Records</li>');
					}					
					
				}			
			});
		},	
	)	
}


// Function to add more chatter attachmens in lead and account
function addMoreChatterAttachments(){
	var wrap         = $(".fields_wrap"); //Fields wrapper
	var add_btn      = $(".field_button"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-6 col-sm-11 col-xs-12" ><input type="file" class="form-control col-md-5 col-xs-5" name="attachment[]"></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}


function addMorebidAttachments(){
	var wrap         = $(".fields_wrapdd"); //Fields wrapper
	var add_btn      = $(".field_buttondd"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-6 col-sm-11 col-xs-12" ><input type="file" class="form-control col-md-5 col-xs-5" name="attachment[]"></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

function addMoreAttachments(){
	var wrap         = $(".fields_wrap_attach"); //Fields wrapper
	var add_btn      = $(".field_button_attach"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-6 col-sm-11 col-xs-12" ><input type="file" class="form-control col-md-5 col-xs-5" name="attachment1[]"></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

function addMorepoAttachments(){
	var wrap         = $(".fields_wrap_po_attach"); //Fields wrapper
	var add_btn      = $(".field_button_po_attach"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-6 col-sm-11 col-xs-12" ><input type="file" class="form-control col-md-5 col-xs-5" name="po_attachment[]"></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

function addMoreConsignee(){
	var wrap         = $(".fields_wrap_consignee"); //Fields wrapper
	var add_btn      = $(".field_button_consignee"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-6 col-sm-11 col-xs-12" ><input type="text" class="form-control col-md-2 col-sm-2 col-xs-12" name="consignee[]"> </div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

function addMorepoConsignee(){
	var wrap         = $(".fields_wrap_po_consignee"); //Fields wrapper
	var add_btn      = $(".field_button_po_consignee"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-6 col-sm-11 col-xs-12" ><input type="text" class="form-control col-md-2 col-sm-2 col-xs-12" name="po_consignee[]"> </div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}


// Function to add more product functionality in Quotation
function addMoreProduct(){										
	var maximum      = 10; //maximum input boxes allowed
	var wrap_material = $(".input_productre"); //Fields wrapper
	var button_add    = $(".addProductButtonre"); //Add button ID
	var x = 1; //initlal text box count	
	$(button_add).click(function(e){
	//on add input button click
		e.preventDefault();
			if(x < maximum){ //max input box allowed
				x++; 				
					//var dataWhere = $("#material").attr("data-where");
					$(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+x+'"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name<span class="required">*</span></label><select class="form-control selectAjaxOption select2 materialNameId Add_mat_onthe_spot" required="required" name="product[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"><label>Description</label><textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Quantity</label><input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity"  onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)"></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom1[]"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom" readonly><input type="hidden" name="uom[]" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12 price " onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)"><input type="hidden" name="totals[]" class="form-control col-md-7 col-xs-12 total has-feedback-left" value="" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>GST</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly><input  type="hidden"  type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst has-feedback-left" value="" readonly></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');
						

						var logged_user = $('#loggedUser').val();							
						var material_type_id = $('#material_type_id').val();
						console.log("fff",material_type_id);
						select2(material_type_id , logged_user);
						init_select2();
						init_select221();
					}
					//getMaterials(x);
		});		
		$(wrap_material).on("click",".remove_btn", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); x--;
			keyupFunction(event,this);
			remove_calculation_quot_pi_so();
	});	
}


$(document).ready(function(e) {			

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
	var maximum      = 10; //maximum input boxes allowed
	var wrap_material = $(".input_productre"); //Fields wrapper
	var button_add    = $(".addProductButtonre"); //Add button ID
	var x = 1; //initlal text box count	
	$(button_add).click(function(e){
	//on add input button click
		e.preventDefault();
			if(x < maximum){ //max input box allowed
				x++; 				
					//var dataWhere = $("#material").attr("data-where");
					$(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+x+'"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label >Material Name  <span class="required">*</span></label>	<select class="form-control selectAjaxOption select2 materialNameId Add_mat_onthe_spot" required="required" name="product[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"><label class="col-md-12">Description</label><textarea name="description[]" placeholder="Description of material" class="form-control col-md-7 col-xs-12" class="description"></textarea></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12" >Quantity</label><input type="text" name="qty[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 quantity"  onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">UOM</label><input type="text" name="uom1[]"  placeholder="uom" class="form-control col-md-7 col-xs-12 uom" readonly><input type="hidden" name="uom[]" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Price</label><input type="text" name="price[]"  placeholder="Price" class="form-control col-md-7 col-xs-12 price " onkeyup="keyupFunction(event,this)"  onchange="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label class="col-md-12">GST</label><input type="text" name="gst[]" class="form-control col-md-7 col-xs-12 gst" value="" placeholder="gst" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Total</label><input type="text" name="totals[]" class="form-control col-md-7 col-xs-12 total has-feedback-left" value="" readonly></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label  class="col-md-12">GST Total</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="TotalWithGsts[]" class="form-control col-md-7 col-xs-12 totalWithGst has-feedback-left" value="" readonly></div><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');
						var logged_user = $('#loggedUser').val();							
						var material_type_id = $('#material_type_id').val();
						console.log("fff",material_type_id);
						select2(material_type_id , logged_user);
						init_select2();
						init_select221();
					}
					//getMaterials(x);
		});		
		$(wrap_material).on("click",".remove_btn", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); x--;

			keyupFunction(event,this);
			remove_calculation_quot_pi_so();


	});	
}

/*---------------Sale target filter by month and year ------------------------*/
$(function() {
	$('input[name="start_date_filter"]').daterangepicker({
		singleDatePicker: true,
		//singleClasses: "picker_3",								
		locale: {
			  format: 'YYYY-MM',
		}
	}, function(start, end, label) {
		$('input[type=search]').val(start.format('YYYY-MM'));		
		$('input[type=search]').keyup();
	});
}); 
	
/*---------------Lead status filter in lead listing ------------------------*/
		$("#lead_status_filter").on("change", function () { // get phone number by contact id in sale order or proforma invoice	
			$("#lead_owner_filter").removeAttr('selected');
			$("#lead_owner_filter option:contains('All')").attr('selected', 'selected');		
			var statusSelected = $(this).find("option:selected");		
			var statusNameSelected = statusSelected.text();

			console.log('Valuee==>>>>',statusNameSelected);
			if(statusNameSelected == 'All'){
				$('input[type=search]').val('');	
			}else{
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
			if(leadOwnerNameSelected == 'All'){
				$('input[type=search]').val('');	
			}else{
				//$("#lead_status_filter option[text=All]").attr('selected', 'selected');
				
				//$("#lead_status_filter").find("option[text=All]").attr("selected", true);
				$('input[type=search]').val(leadOwnerNameSelected);		
				
			}
			$('input[type=search]').keyup();
		});	




	function getMonthLeadStatusGraph(startDate = '' , endDate = ''){
	$("#graph_bar_group_lead").empty();
		if ($('#graph_bar_group_lead').length ){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
			
				$.ajax({        
					//url: site_url +'crm/monthLeadStatusGraph/',
					url: site_url +'bid_management/graphDashboardData/',
					dataType: 'json',
					type: 'POST',
					//data: {},
					data: ajaxData,
					success: function(result){	
						result = result.monthLeadStatusGraph;
						Morris.Bar({
						  element: 'graph_bar_group_lead',
						  data: result,
						  xkey: 'period',
						  barColors: ['#F75151', '#34495E', '#ACADAC', '#3498DB', '#008000', '#ff0000'],
						  ykeys: ['New', 'Qualified','Unqualified', 'Submitted','Lost', 'Awarded' , 'EMO Pending' , 'Closed'],
						  labels: ['New', 'Qualified','Unqualified', 'Submitted','Lost', 'Awarded' , 'EMO Pending' , 'Closed'],
						  hideHover: 'auto',
						  xLabelAngle: 60,
						  resize: true
						});
						
					}			
				});
	}
	}
	
	
	
		function dashboardLeadAcheivedVsTarget(startDate = '' , endDate = ''){	
			
		if ($('#lineChart1').length ){	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}		
			$.ajax({        
				//url: site_url +'crm/monthLeadTargetGraph/',
				url: site_url +'bid_management/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(result){	
					console.log('result==>>',result);
					result = result.monthLeadTargetGraph;
					var ctx = document.getElementById("lineChart1");
			  var lineChart = new Chart(ctx, {
				type: 'line',
				data: {
				  labels: ["January", "February", "March", "April", "May", "June", "July","Aug","Sept","october","november","december"],
				  datasets: [{
					label: "Bid Target",
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
					label: "Bid Acheived",
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
			
			
function dashboardSaleOrder(startDate = '' , endDate = ''){
	$("#graph_sale_order").empty();
	$("#graph_sale_order_count").empty();
		if ($('#graph_sale_order').length ){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
			
				$.ajax({        
					//url: site_url +'crm/monthSaleOrderGraph/',
					url: site_url +'crm/graphDashboardData/',
					dataType: 'json',
					type: 'POST',
					//data: {},
					data: ajaxData,
					success: function(result){
						result = result.monthSaleOrderGraph;	
						console.log('resultSaleOrderPriceData===>>>',result);
						
						
							saleOrderPriceJsonObj = [];
							$(result).each(function() {
								item = {}
								item ["period"] = $(this)[0].period;
								item ["Amount"] = $(this)[0].Amount;
								saleOrderPriceJsonObj.push(item);
							});
							
							saleOrderPriceCountJsonObj = [];
							$(result).each(function() {
								saleOrderPriceCountItem = {}
								saleOrderPriceCountItem ["period"] = $(this)[0].period;
								saleOrderPriceCountItem ["Approve"] = $(this)[0].Approve;
								saleOrderPriceCountItem ["Disapprove"] = $(this)[0].Disapprove;
								saleOrderPriceCountJsonObj.push(saleOrderPriceCountItem);
							});
							console.log('jsonObjsaleOrderPriceCountJsonObj===>>>',saleOrderPriceCountJsonObj); 
							Morris.Bar({
							  element: 'graph_sale_order',
							//  data: result,
							  data: saleOrderPriceJsonObj,
							  xkey: 'period',
							  //barColors: ['#ACADAC','#F75151' ,'#008000', '#ff0000'],
							  barColors: ['#008000','#F75151'],
							//  ykeys: ['Approve', 'Disapprove' ],
							//  labels: ['Approve', 'Disapprove' ],
							 //ykeys: ['Approve', 'Disapprove','Amount' ],
							 ykeys: ['Amount' ],
							// labels: ['Approve', 'Disapprove','Amount' ],
							 labels: ['Amount' ],
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
								barColors: ['#008000','#ff0000' ,'#F75151'],
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
	
	
	
	function getLeadStatusGraph(startDate = '' , endDate = ''){
			if($("#graph_donut_lead").length) {	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
			
				$.ajax({        
				//	url: site_url +'crm/getLeadStatusGraph/',
					url: site_url +'bid_management/graphDashboardData/',
					dataType: 'json',
					type: 'POST',
					//data: {},
					data: ajaxData,
					success: function(response){							
						//var result = response[0];
						var result = response.getLeadStatusGraph[0];
						console.log('result===>>',result);
						var ptotal = parseInt(result.New) + parseInt(result.Qualified) + parseInt(result.Unqualified) + parseInt(result.Submited) + parseInt(result.Lost) + parseInt(result.Awarded) + parseInt(result.Emo_Pending) + parseInt(result.Closed);
						if(ptotal == 0){
							//$("#graph_donut_lead").css("display","none");
							$("#graph_donut_lead").empty();
							$("#graph_donut_lead").html("No Data");
							
						}
						Morris.Donut({
							element: 'graph_donut_lead',
							data: [
									{label: 'New', value: ((parseInt(result.New)/ ptotal) * 100).toFixed(2), count: result.New},
									{label: 'Qualified', value: ((parseInt(result.Qualified)/ ptotal) * 100).toFixed(2), count: result.Qualified},
									{label: 'Unqualified', value: ((parseInt(result.Unqualified)/ ptotal) * 100).toFixed(2), count: result.Unqualified},
									{label: 'Submited', value: ((parseInt(result.Submited)/ ptotal) * 100).toFixed(2), count: result.Submited},
									{label: 'Lost', value: ((parseInt(result.Lost)/ ptotal) * 100).toFixed(2), count: result.Lost},
									{label: 'Awarded', value: ((parseInt(result.Awarded)/ ptotal) * 100).toFixed(2), count: result.Awarded},
									{label: 'Emo_Pending', value: ((parseInt(result.Emo_Pending)/ ptotal) * 100).toFixed(2), count: result.Emo_Pending},
									{label: 'Closed', value: ((parseInt(result.Closed)/ ptotal) * 100).toFixed(2), count: result.Closed}	
								],
							colors: ['#F75151', '#34495E', '#ACADAC', '#3498DB', '#008000', '#ff0000' , '#ff0000', '#ff0000' ],
							formatter: function (y,data) {	
							return data.count + "  (" + y + "%" +")";					 
							},
							resize: true 
							});
						
					}			
				});
		}
	}
	
	
	function getWinLeadVsTotalGraph(startDate = '' , endDate = ''){
		if($(".progress").length) {	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({        
				//url: site_url +'crm/getWinLeadVsTotalGraph/',
				url: site_url +'bid_management/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){							
					var result = response.getWinLeadVsTotalGraph[0];
					$('.win').html('Awarded : '+result.Win);
					$('.total').html('Total : '+result.Total);
					if(result.Win == 0){
							var winPercentage = 0;
					}else{
						var winPercentage = result.Win * 100 / result.Total;
					}						
					$('.progress-bar').css('width',winPercentage+'%');
				}			
			});
		}	
	}
	
	/*   Show Upper counts from each module of CRM  */
	function getDashboardCount(startDate = '' , endDate = ''){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({        
				//url: site_url +'crm/getDashboardCount/',
				url: site_url +'bid_management/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){
					console.log('response===>>',response);	
					var dashboardCountHtml = '';	
					$.each( response.getDashboardCount, function( key, value ) {
						dashboardCountHtml += '<div  style="width:20%;" class=" animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12"><div class="tile-stats" ><div class="icon"><i class="'+value.icon+'"></i></div><div class="count">'+value.totalCount+'</div><h3>'+value.name+'</h3><p>'+value.description+'</p></div></div>';
					});
					$('.top_tiles').html(dashboardCountHtml);
					
				}			
			});
	}
	
	
	
	
		
	function getRecentActivities(startDate = '' , endDate = ''){			
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({  
				//url: site_url +'crm/recentActivitiesDashboardData/',
				url: site_url +'crm/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){	
					console.log('resonse===>>>',response);
						var leadActicityHtml = '';
						if($.isEmptyObject(response.leadActivity)){
							$('.leadDashboardActivity').html('No  records');
						}else{
						$.each( response.leadActivity, function( key, value ) {
							console.log('value===>>>',value);
							var company = value.company == null?'Lead':value.company;
							leadActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+company+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
						});
						
						$('.leadDashboardActivity').html(leadActicityHtml);
						}
						
						
						
						var accountActicityHtml = '';
						if($.isEmptyObject(response.accountActivity)){
							$('.accountDashboardActivity').html('No  records');
						}else{
						$.each( response.accountActivity, function( key, value ) {
							console.log('value===>>>',value);
							var accountName = value.name == null?'Account':value.name;
							accountActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+accountName+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
						});
						$('.accountDashboardActivity').html(accountActicityHtml);
						}
						
						var saleOrderActicityHtml = '';
						if($.isEmptyObject(response.saleOrderActivity)){
							$('.saleOrderDashboardActivity').html('No  records');
						}else{
						$.each( response.saleOrderActivity, function( key, value ) {
							console.log('value===>>>',value);
							var accountName = value.name == null?'Account':value.name;
							var contactName = value.first_name == null?'Contact':value.first_name + ' ' +value.last_name;
							saleOrderActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+accountName+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Contact Name To : '+contactName+'</a></span><div class="byline"><span>Due Date: '+value.payment_date+'</span></div></div><div class="byline"></div><p class="excerpt">Amount : '+value.grandTotal+'</a></p></div></div></li>';
						});
						$('.saleOrderDashboardActivity').html(saleOrderActicityHtml);
						}
						
				}			
			});		
	}
	
	
	function getCrmTableData(startDate = '' , endDate = ''){			
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({  
				//url: site_url +'crm/recentActivitiesDashboardData/',
				url: site_url +'bid_management/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){	
					console.log('resonse===>>>',response);
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
  }, function(start, end, label) {  
		var startDate = start.format('YYYY-MM-00 00:00:00');
		var endDate = end.format('YYYY-MM-00 00:00:00');		
		var dateRangeHtml = $(this)[0].element.context;			
		$("#area-chart2").empty();
		getMonthLeadStatusGraph(startDate ,endDate);		
		$("#lineChart1").empty();
		dashboardLeadAcheivedVsTarget(startDate ,endDate);		
		$("#graph_sale_order").empty();
		dashboardSaleOrder(startDate ,endDate);
		$("#graph_donut_lead").empty();
		getLeadStatusGraph(startDate ,endDate);			
		getWinLeadVsTotalGraph(startDate ,endDate);
		getDashboardCount(startDate ,endDate);
		getRecentActivities(startDate ,endDate);
		getCrmTableData(startDate ,endDate);
		
	
		
	
  });  

  
    //   Function to show the modal with disapprove reasonof sale order of CRM
$('.graphCheckbox').click(function(e){
	var show = 0;
	if ($(this).is(":checked")) show = 1;
	else show = 0;
	var graph_id = $(this).attr('id');
	var ajaxData = {'graph_id':graph_id , 'show':show};
	$.ajax({
		url: site_url +'crm/showDashboardOnRequirement/',
		dataType: 'json',
		type: 'POST',
		data: ajaxData,
		success: function(response){
			console.log('response===>>>>',response);
		}
	});
	});
	
/*Print Function
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
 })*/
 
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
 
 /***************************************************************end Function to check the validation of a company's GSTIN No. DD ****************************************************/
 


//*************************************************************Add More Material  On the spot in performa invoice and sale order***************************/
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
				var matID = $('#material_type_id').val();      
				//console.log("matId",matID);
                $('#material_type_id').val(matID);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_material_cls_name'>Add Material</span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
	});

	
}
$(document).on("click",".add_material_cls_name",function(){
	
	var searched_text_val = $('#serchd_val').val();
	var searched_text_val1 = $('#material_name').val();
	var materialId = $('#material_type_id').val();
	//alert(materialId);
		
   // console.log('materialId',materialId);
 setTimeout(function(){   
    $('#material_name').val(searched_text_val);
    $('#material_name').val(searched_text_val1);
    $('#materialtypeid').val(materialId);
	}, 2000);
	setTimeout(function(){	
	    $('#serchd_val').val();
	}, 1000);
});

$(document).on("click",".add_material_cls_name",function(){ 
 //To get Matrieal Type Ajax	
 
	 $('#myModal_Add_matrial_details').modal('show');
	 var btn_html = $(this).html();
	 $('#add_matrial_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger

 
});					
					
	


$(document).on("click",".close_sec_model",function(){
	 $('#myModal_Add_matrial_details').modal('hide');
	 $('.nav-md').addClass('modal-open');

	 
});

$(document).on("change",".add_material_cls",function(){
	var mat_type_id = $('.material_type_id').val();
	
	$.ajax({
			type: "POST",
			url: site_url+'crm/Get_matrial_type/',
			data: {mat_id:mat_type_id}, 
				success: function(result) {
					 if(result != '') {
						var  objss = JSON.parse(result);
						
					    var len = objss.length;
						for(var i=0; i<len; i++){
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

$(document).on("click","#Add_matrial_details_on_button_click",function(){
	
	$('#mssg34').empty();
	var material_name  = $('#material_name').val();
	var hsn_code  = $('#hsn_code').val();
	//var uom  = $('#uom').val();
	//var uom  = $("select#uom").filter(":selected").val();

	var uom =  $("select#uom option").filter(":selected").val();

	//console.log("value of uom==>>>",uom); 
	var specification  = $('#specification').val();
	var gst_tax  = $('#gst_tax').val();
	var opening_balance  = $('#opening_balance_Sec').val();
	var material_type_id  = $('#materialtypeid').val();
	//var material_type_id  = $('#matrial_Iddd').val();
	
	var prefix  = $('#prefix').val();
	var error = 0;
	
	console.log('material_name==>>',material_name);
	console.log('hsn_code==>>',hsn_code);
	console.log('uom==>>',uom);
	console.log('specification==>>',specification);
	console.log('gst_tax==>>',gst_tax);
	console.log('opening_balance==>>',opening_balance);
	console.log('material_type_id==>>',material_type_id);
	
	
		if(material_name == ''){
				$('#material_name').css('border', '1px solid #b94a48');
				$('#material_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#material_name').css('border', '1px solid #dedede');
				$('#material_name').closest(".form-group").find("span").text('');
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
				
		
		if(error == 1) { 
			return false;
		} else {
			
		$.ajax({
			   type: "POST",
			   url: site_url+'crm/add_matrial_Details_onthe_spot/',
			   data: {material_name:material_name,hsn_code:hsn_code,gst_tax:gst_tax,uom:uom,specification:specification,material_type_id:material_type_id,prefix:prefix,opening_balance:opening_balance},
				success: function(htmlStr) {
					//alert(htmlStr);					   
					 if(htmlStr.length > 0){						
						$('#mssg34').html('<span style="color:green;">Material Added Successfully.</span>');
						$("#insert_Matrial_data_id").trigger('reset');
						setTimeout(function(){							
							$('#myModal_Add_matrial_details').modal('hide');
							$('#myModal_Add_matrial_details_purchse').modal('hide');
							$('.nav-md').addClass('modal-open'); 
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);
							$('.nav-md').addClass('modal-open');
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
/* ADD QUICK ADD SCRIPT*/
/****************************quick add customer name in performa invoice********************************************************/
function init_select22() {
	$('.customerName').select2({
		allowClear: true,
        placeholder: 'Customer Name',
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
				$('#customer_name').val(searched_value);
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_customer_cls_name'>Add Customer</span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
	});
}


$(document).on("click",".add_customer_cls_name",function(){
	
	var searched_text_val = $('#serchd_val').val();
	var searched_text_val1 = $('#customer_name').val();
	//var materialId = $('#material_type_id').val();
    setTimeout(function(){    
    $('#customer_name').val(searched_text_val);
    $('#customer_name').val(searched_text_val1);
   // $('#material_name_id').val(materialId);
	}, 2000);
	setTimeout(function(){	
	    $('#serchd_val').val();
	}, 1000);
});

$(document).on("click",".add_customer_cls_name",function(){ 
 //To get Matrieal Type Ajax	
 
	 $('#myModal_Add_customer_details').modal('show');
	 var btn_html = $(this).html();
	 $('#add_customer_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger

 
});	


$(document).on("click",".close_sec_model2",function(){
	

	setTimeout(function () {
	$('#myModal_Add_customer_details').modal('hide');
	 $('.nav-md').addClass('modal-open'); 
	}, 500);
		 
});		


$(document).on("click","#Add_customer_details_on_button_click",function(){
	

	$('#mssg34').empty();
	var account_owner  = $('#loggedUser').val();
	var customer_name  = $('#customer_name').val();
	var gstin_value  = $('#gstin_value').val();
	var phone_number  = $('#phone_number').val();	 
	var billing_street  = $('#billing_street').val();
	//var closing_balance  = $('#closing_balance').val();
	var billing_zipcode  = $('#billing_zipcode').val();
	var billing_country  = $('#country_id').val();
	
	var billing_state  = $('#state_id').val();
	
	var billing_city  = $('#city_id').val();
	//console.log("ddd",account_owner);
	var error = 0;
		if(customer_name == ''){
				$('#customer_name').css('border', '1px solid #b94a48');
				$('#customer_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#customer_name').css('border', '1px solid #dedede');
				$('#customer_name').closest(".form-group").find("span").text('');
			}		
		
		if(error == 1) { 
			return false;
		} else {
			
		$.ajax({
			   type: "POST",
			   url: site_url+'crm/add_customer_Details_onthe_spot/',
			   data: {account_owner:account_owner,customer_name:customer_name,gstin:gstin_value,phone_number:phone_number,billing_street:billing_street,billing_zipcode:billing_zipcode,billing_country:billing_country,billing_state:billing_state,billing_city:billing_city},
				success: function(htmlStr) {
					if(htmlStr == true){
						//alert('fgf');
						$('#message').html('<span style="color:green;">Contact Added Successfully.</span>');

						$("#insert_contact_data_id").trigger('reset');
						setTimeout(function(){
							
							$('#myModal_Add_customer_details').modal('hide');
							$('.nav-md').addClass('modal-open'); 
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);
							$('.nav-md').addClass('modal-open');
					}else{
						$('#message').html('<span style="color:red;">Not Added.</span>');
					}
					setTimeout(function(){
					$('#message').html('<span> </span>');
					}, 3000);		
				}
			 });
		}
});								
	
/* ADD QUICK ADD SCRIPT*/
/* Industry multiple Select */
function AddMultipleselect(){
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
				$('#serched_val').val(searched_value);
				
				$('#contact_name').val(searched_value);
				var account_id = $('#account_id option:selected').val(); 
				
				$('#accountId').val(account_id);
				
				return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_contact_name'>Add Contact Person</span>";
			  }
			},escapeMarkup: function (markup) {
				 return markup;
			}
	});
}
$(document).on("click",".add_contact_name",function(){
	
	var searched_text_val = $('#serched_val').val();
	var searched_text_val1 = $('#contact_name').val();
	var accountId = $('#accountId').val();
    setTimeout(function(){    
    $('#contact_name').val(searched_text_val);
    $('#contact_name').val(searched_text_val1);
   // $('#material_name_id').val(materialId);
	}, 2000);
	setTimeout(function(){	
	    $('#serched_val').val();
	}, 1000);
});

$(document).on("click",".add_contact_name",function(){ 
 //To get Matrieal Type Ajax	
 //alert("ddd");
	 $('#myModal_Add_contactPerson_details').modal('show');
	 var btn_html = $(this).html();
	 $('#add_contactPerson_Data_onthe_spot').val(btn_html);
	// alert(btn_html);Add Sale Ledger

 
});
$(document).on("click",".close_contact_model",function(){

				
						setTimeout(function(){
							
							$('#myModal_Add_contactPerson_details').modal('hide');
							$('.nav-md').addClass('modal-open'); 
						}, 500);
	
	 
});				
$(document).on("click","#Add_contact_details_on_button_click",function(){
	
	$('#message_contact').empty();
	var contact_owner  = $('#loggedUser').val();
	var account_id  = $('#accountId').val();
	var contact_name  = $('#contact_name').val();
	var email_id  = $('#email_id').val();
	var ph_no  = $('#ph_no').val();	 
	console.log(email_id);
	console.log(ph_no);
	var error = 0;
		if(contact_name == ''){
				$('#contact_name').css('border', '1px solid #b94a48');
				$('#contact_name').closest(".form-group").find("span").text('This field is required');
				var error = 1;
			}else{
				$('#contact_name').css('border', '1px solid #dedede');
				$('#contact_name').closest(".form-group").find("span").text('');
			}		
		
		if(error == 1) { 
			return false;
		} else {
			
		$.ajax({
			   type: "POST",
			   url: site_url+'crm/add_contact_Details_onthe_spot/',
			   data: {account_id:account_id,contact_owner:contact_owner,contact_name:contact_name,email_id:email_id,ph_no:ph_no},
				success: function(htmlStr) {
					//alert(htmlStr);
					   
					 if(htmlStr.length > 0){
						
						$('#message_contact').html('<span style="color:green;">Contact Added Successfully.</span>');
						$("#insert_contact_data_id").trigger('reset');
						setTimeout(function(){
							
							$('#myModal_Add_contactPerson_details').modal('hide');
							$('.nav-md').addClass('modal-open'); 
						}, 1000);
						setTimeout(function(){
							$('.nav-md').addClass('modal-open'); 
						}, 1500);
							$('.nav-md').addClass('modal-open');
					}else{
						$('#message').html('<span style="color:red;">Not Added.</span>');
					}
					setTimeout(function(){
					$('#message').html('<span> </span>');
					}, 3000);		
					
					
				}
			 });
		}
});					
	
	
function saleOrderComplete(){	
	$('#sale_order_complete').change(function(event) {		
		if(($("#sale_order_complete").prop("checked") == true)){
			if(confirm('Are you sure!') == true) {						
				var sale_order_id = $(this).attr('data-sale-order-id');				
				var loggedInUserId = $(this).attr('data-loggedInUserId');

				var datasaleorderai = $(this).attr('data-sale-order-ai');


								
				$.ajax({
					type: "POST",
					url: site_url+'crm/completeSaleOrder/',
					data: { id:sale_order_id, complete_status:1, completed_by:loggedInUserId ,datasaleorderai:datasaleorderai}, 
					success: function(result) {
						if(result != '') {
							var obj = $.parseJSON(result);
						   if(obj.status == 'success') {					 
								window.location.href = site_url+'crm/sale_orders/';
						   } 
						}
				   }
				});
			}
		}
	});	
}



/******************get company unit addres in sale order*********************/
function getAddress(){
	$('.address').select2({
			allowClear: true,
			placeholder: 'Select Address',
			closeOnSelect: true,
			ajax: {
				url: site_url+'/crm/getAddress',
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



 $(document).ready(function() {
                resetcheckbox();
                $('#selecctall').click(function(event) {  //on click
                    if (this.checked) { // check select status
                        $('.checkbox1').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"              
                        });
                    } else {
                        $('.checkbox1').each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                        });
                    }
                });



$("#del_all").on('click', function(e) 
   {



		 if(confirm('Are You Sure!') == true){
                    e.preventDefault();
                    //var datamsg = $(this).attr('data-msg');	
                   	var tablename1 = document.getElementById("table");
                   	var tablename = document.getElementById("table").value;

                   	var datamsg = tablename1.getAttribute('data-msg');

                   	var datapath = tablename1.getAttribute('data-path');


                    var checkValues = $('.checkbox1:checked').map(function()
                    {
                        return $(this).val();
                    }).get();





                    console.log(checkValues);
                    
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                        });


                    var ai =		$(".checkbox1:checked").map(function () {
				    		return $(this).data('ai')
						}).get();


                    //	console.log('value if ai====>>>>>',ai);

                    $.ajax({
                        url: site_url+'bid_management/deleteall/',
                        type: 'post',
                        data: {tablename:tablename, checkValues:checkValues , datamsg:datamsg,ai:ai}
                    }).done(function(data) {
                       window.location.href = site_url+datapath;
                        $('#selecctall').attr('checked', false);
                    });

                    }
                    else
                    {
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



  /*$('s').each(function(index)
  {*/


//function favour(){
	$(".star").on('change', function(e) {
					var tablename1 = document.getElementById("favr");
                   	var tablename = document.getElementById("favr").value;

                   	var datamsg = tablename1.getAttribute('data-msg');

                  // 	var favourite = tablename1.getAttribute('favour-sts');;

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
                        url: site_url+'bid_management/markfavourite/',
                        type: 'post',
                        data: {tablename:tablename, checkValues:checkValues , datamsg:datamsgs , favourite:favourite}
                    }).done(function(data) {
                       window.location.href = site_url+datapath;
                        $('.star').attr('checked', false);
                    });


	});
    // function myFunction() {
  // var x = document.getElementById("myDIV1");
  // if (x.style.display === "none") {
    // x.style.display = "block";
  // } else {
    // x.style.display = "none";
  // }
// }

$(document).ready(function(){
  $(".filter").click(function(){
    $(".x_content").toggleClass("intro");
  });
});



function remove_calculation_quot_pi_so(){

		var grand_total_val = $("[name='total']").val();
		 if(grand_total_val == 0 || grand_total_val == ''){
			  $(':input[type="submit"]').prop('disabled', true);
		 }else{
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
$(document).on("click",".quotpisoview",function(){
	
	
	var id = $(this).attr('id');
	var tab = $(this).attr('data-id');
	var start_date = $(this).attr('data-date')?$(this).attr('data-date'):'';
	var url = '';
	
	switch (tab) {
		
		
		case 'Sale Order':
			url = 'crm/viewSaleOrder';
			data = {id:id};
			break;
		case 'Sale Order Dispatched':
			url = 'crm/viewSaleOrder';
			data = {id:id};
			break;
		
		case 'Proforma Invoice':
			url = 'crm/viewProformaInvoice';
			data = {id:id};
			break;
		
		case 'Quotation':
			url = 'crm/viewQuotation';
			data = {id:id};
			break;  }


		if(tab == 'Sale Order'){
		    $('.nxt_cls').html('Sale Order');
		 //   $('.nav-md').addClass('modal-open');
		}
		

		if(tab == 'Sale Order Dispatched'){
		    $('.nxt_cls').html('Sale Order Dispatched');
		  //  $('.nav-md').addClass('modal-open');
		}
		
		if(tab == 'Proforma Invoice'){
			 $('.nxt_cls').html('Proforma Invoice');
			// $('.nav-md').addClass('modal-open');
		}

		if(tab == 'Quotation'){
			 $('.nxt_cls').html('Quotation');
			// $('.nav-md').addClass('modal-open');
		}

			
	$.ajax({
		type: "POST",
		url: site_url + url,
		//data: {id:id}, 
		data: data, 
		success: function(data){
			if(data != '') {
				$("#crm_add_modal1").modal({
					show:false,
					backdrop:'static'
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
	  if (dragClass.hasClass('dragg')){
	 //if(($(this).hasClass('dragg')))
	  //{
		  console.log("dfdf");
		draggableInit();
	  }
	  
	  if(dragSaleClass.hasClass('saleOrderPriority')){
		console.log("fff");
		draggableSaleOrderInit();
		//draggableMachineOrderInit();
	  }
	  else if(dragMachineClass.hasClass('machine_order_priority')){
		draggableMachineOrderInit();
	  }
	$('.panel-heading').click(function() {
		if($('.machineOrder').hasClass("fa-minus-circle")){
			$('.machineOrder').removeClass("fa-minus-circle");
			$('.machineOrder').addClass("fa-plus-circle");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		}else if($('.machineOrder').hasClass("fa-plus-circle")){
			$('.machineOrder').removeClass("fa-plus-circle");
			$('.machineOrder').addClass("fa-minus-circle");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		}
		if($(this).find('i').hasClass("fa-chevron-up")){
			$(this).find('i').removeClass("fa-chevron-up");
			$(this).find('i').addClass("fa-chevron-down");
			var $panelBody = $(this).parent().children('.panel-body');
			$panelBody.slideToggle();
		}else if($(this).find('i').hasClass("fa-chevron-down")){
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
		console.log('event===>>>',event);	
		sourceId = $(this).parent().attr('id');		
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
		console.log("sourceId=>>>",event.originalEvent.dataTransfer.getData("text/plain"));
	});
	$('.panel-body').bind('dragover', function (event) {
		event.preventDefault();		
	});
	$('.panel-body').bind('drop', function (event) {		
		var children = $(this).children();
		var targetId = children.attr('id');
		console.log("targetid==>>",targetId);
		if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
			console.log("elementId->>",elementId);
			$.ajax({				
				url: site_url+'bid_management/changeProcessType/',	
				dataType: 'json',
				type: 'POST',
				data: {
					'processId': elementId,
					'processTypeId': targetId,           
				},
				success:function(result){					
					if(result.status == 'success') {
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
		}else{
		$(".kanban-centered").sortable({			
			connectWith: ".kanban-centered",
			scroll: false,
			cursor:'pointer',
			revert:true,
			opacity:0.4,
			update: function() {
					sendOrderToServer();
				 }
			}).disableSelection();
		event.preventDefault();
		}
	});	
}	


	
function sendOrderToServer() {
	  var order = [];
		$('.process').each(function(index,element) {
			order.push({
				id: $(this).attr('id'),
				position: index+1
			});
		}); 
		var children = $(this).children();
	  $.ajax({
		type: "POST", 
		dataType: "json", 
		url: site_url+'bid_management/changeOrder/',
		data: {
		  order:order,
		},
		success: function(response) {
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
$("#staus") .change(function () {    

var ai = $(".checkbox1:checked").map(function () {
				    		return $(this).data('ai')
						}).get();

  var selectedvalue = $(this).children("option:selected").val();
  console.log(selectedvalue);
  console.log(ai);       
$.ajax({        
			url: site_url +'crm/change_lead_status_by_id/',
			dataType: 'json',
			type: 'POST',
			data: {ai:ai,selectedvalue:selectedvalue},
			success: function(result){
			if(result.status == 'success') {					
						
					location.reload();
				}
			}
		});	
});





/* Show modal for share Generated PDF using email */
$(document).on("click",".sharevia_email_cls",function(){
	$('#myModal_share_email').modal('show');
});

$(document).on("click",".close_sec_model",function(){
	 $('#myModal_share_email').modal('hide');
});
/* Share Via email Script*/
$(document).on("click","#share_via_Email",function(){	
		var share_email  = $('#email_name').val();
		var order_id  = $('#order_id').val();
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
				   url: site_url+'purchase/share_pdf_using_email/',
				   data: {share_email:share_email,order_id:order_id,email_msg_id:email_msg_id}, 
				   success: function(htmlStr) {
					if(htmlStr == 'sent'){
						// alert('send Successfully');
						$('#mssg').html('<span style="color:green;">Eail Send Successfully.</span>');
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
  
  
  
  /************************print in view****************************************/
 function Print_data_new(){
		document.getElementById("btnPrint").onclick = function () {		
			printDiv(document.getElementById("print_divv"));
			var modThis = document.querySelector("#print_divv");
			console.log('modThis===>>>',modThis);
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
				if (oldElem != null) { oldElem.parentNode.removeChild(oldElem); } 
									  //oldElem.remove() not supported by IE

				return true;
			} 


			}	    
	}






// for counting total price in pipeline
	function gettotal(){
		$('.kanban-col').each(function(i){
			var leadStatusId = $(this).attr('id');
			var total = 0;
			var total1 = 0;
			var dataname = $(this).attr('data-name');
			$('#'+leadStatusId+' .ee').each(function() {
		    	total += parseFloat($(this).text());
		    });
			var numItems = $('#'+leadStatusId+' .kanban-label').length;
			$('#'+leadStatusId + ' .total11').text('('+numItems+')');
			$('#'+leadStatusId + ' .panel-footer').html('<h4 style="float:right;">Grand Total <strong>&#8377;</strong> '+ total + '  </h4>');	
		});
	}


// For data tables inside the tabs
$('#datatable-buttons1').DataTable();

$('#datatable-so').DataTable();




// Function to display add more contact functionality in lead
function addMoretypeofCustomer(){
	/* add more multiple contacts */
	var maximum_add     = 10; //maximum input boxes allowed
	var inputfield        = $(".processDiv"); //Fields wrapper
	var add_more  = $(".addMoreProcess"); //Add button ID
	var y = 1; //initlal text box count
	$(add_more).click(function(e){ //on add input button click
		e.preventDefault();		
		if(y < maximum_add){ //max input box allowed
			y++; 
			$(inputfield).append('<div class="well scend-tr" id="chkIndex_'+y+'"><div class="col-md-12 col-sm-12 col-xs-12form-group"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-12 col-xs-12" placeholder="Customer name" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
		
	});  
	$(inputfield).on("click",".remve_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	});	
}


/*************************code to get values of cost price and sales price from valuation*******************************/
	/* this function is use d to get the column value which you want to change on focus****/

	 var customer_type23 = [];
	 var product_id23 = [];
	 var price23 = [];

	$('[contenteditable]').on('focus', function() {
		var $this = $(this);
		var id = $(this).attr('id');
	}).on('blur', function() {
	var $this = $(this);
		
		$("td").each(function(){

		customer_type23.push($(this).attr('data-customerid'));
		product_id23.push($(this).attr('data-id'));
		price23.push($(this).html());

		});

	});  



$(".save").click(function(){


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


$('.submit_price').click(function(){
			var ajaxDataArray = [];		
			var i = 0;		
			$('.tr-class').each(function() {
				//ajaxDataArray = [];
                var materialId = $(this).attr('data-id');
				$(this).find('.custData').each(function(){		
					var dataCustomerId = $(this).attr('data-customerId');
					var dataCustomerIdVal = $(this).text();
					ajaxDataArray.push({
						'product_id': materialId   ,
						'customer_type': dataCustomerId,
						'price': dataCustomerIdVal						
					});
				})  
			i++;				
            });
			console.log('ajaxDataArray==>>>',ajaxDataArray);


			$.ajax({
			url:site_url + "crm/savePricelist",
			method:"POST",
			data:{ajaxDataArray : ajaxDataArray},
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
				
			// send ajax call with data ajaxDataArray
});


// /*chang statsu in worker*/
$(document).on('change', '.change_status_uom', function(){
	var uomStatus;	
	var checkbox =	$(this).attr('checked', true);
	if(checkbox.context.checked == true) uomStatus = 1;
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
			success: function(data){

				if(data == true){
					location.reload();
				}
			}
		});
});

/*job card add more material field */
function addMaterialDetailCA() {
    var input = 10;
    var input_mat = $(".input_holder");
    var add_mat = $(".addmaterial");
	var logged_user = $('#loggedUser').val();
    //var y = 1; 
    var y = $('.input_fields_wrap .well').length;
    $(add_mat).click(function(e) {
        // e.preventDefault();
        // var measurmentArray = '';
        // $.each( measurementUnits, function( key, value ) {
        // measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        // });
        if (y < input) {
            y++;
            $(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '" ><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getUomCA(event,this);"></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12 qty" name="disc[]" placeholder="Disc" required="required" type="text"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" value="" readonly><input type="hidden" name="uom_value[]" class="uom1" readonly value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value=""></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
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
    $(input_mat).on("click", ".remove_input", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
        keyupFunction(event, this);
    });
}

/***** Get Competitor Detail ******/
function addCompetitorDetail() {
    var input = 10;
    var input_mat = $(".input_holder1");
    var add_mat = $(".addcomp");
	var logged_user = $('#loggedUser').val();
	 var y = $('.itemName').length;
    $(add_mat).click(function(e) {
		var i=1;
            $(input_mat).append('<div class="main_div"><div class="col-sm-12"><button class="btn btn-danger remove_input" type="button" style="float: right;margin-top: 10px;"><i class="fa fa-minus"></i></button></div><h3 class="Material-head" style="margin-bottom: 30px;">Competitor Price Information<hr></h3><div class="required item form-group col-md-12 col-sm-12 col-xs-12"><label class="required col-md-3 col-sm-12 col-xs-12" for="account_id">Competitor Name </label><div class="required col-md-6 col-sm-12 col-xs-12"><select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id[]" data-id="bid_competitor_details" data-key="id" data-fieldname="name" data-where="account_owner ='+ logged_user +' AND save_status = 1" onchange="getProductDetails('+this.value+')" width="100%"><option value="">Select Option</option></select></div></div><div class="item form-group col-md-12 col-sm-12 col-xs-12"><label class="required col-md-3 col-sm-12 col-xs-12" for="result">Result</label><div class="col-md-8 col-sm-12 col-xs-12"><textarea class="form-control" rows="4" cols="60" name="result[]"></textarea></div></div><h3 class="Material-head">Product Details<hr></h3><div class="item form-group "><div class="col-md-12 col-sm-12 col-xs-12 input_fields_wrap"><div class="item form-group"><div class="col-md-12 input_holder middle-box"><div class="well welldata" id="chkIndex_1" style=" overflow:auto;"></div></div></div></div></div></div>');
        init_select2();
       // getUomCA();
	i++;});
    $(input_mat).on("click", ".remove_input", function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
        y--;
        keyupFunction(event, this);
    });
}

function getMatDetails(){
	$(".itemName").on("select2:select", function (e) { 
	var id=$('#id').val();
	var comp_id=$(this).val();
	var clrt=e.currentTarget;
	//alert($(clrt).val());
		$("#contact_id").empty();
		var selectAccountVal = $(e.currentTarget).val();
		$.ajax({        
			//url: site_url +'bid_management/getMat/',
			url: site_url +'bid_management/getCompProduct/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: id,    
			},
			success: function(result){				
			
			if(result != '') {
				 		var input_mat = $(clrt).parents(".main_div").find('.welldata');
						var  objss = jQuery.parseJSON(JSON.stringify(result));
						
					    var len = objss.length;
						for(var i=0; i<len; i++){
							var material_name_id = objss[i].material_name_id;
							var material_type = objss[i].material_type;
							var unit = objss[i].unit;
							var unit_name = objss[i].unit_name;
							var disc = objss[i].description;
							var price = objss[i].price;
							//console.log("material_name",material_name);
							//console.log("material_type",material_type);
							var y = $('.input_fields_wrap .well').length;
							var logged_user = $('#loggedUser').val();
							$(input_mat).append('<div class="well scend-tr mobile-view"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id['+comp_id+']['+i+']" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" onchange="getMaterialNameCA(event,this)" id="material_type"><option value="' + material_type_id + '" selected>' + material_type + '</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12" name="disc['+comp_id+'][+i+]" placeholder="Disc" required="required" type="text" value=" ' + disc + ' "></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom_value1['+comp_id+'][+i+]" class="form-control col-md-7 col-xs-12  uom" value=" ' + unit_n + ' " readonly><input type="hidden" name="uom_value[]" class="uom1" readonly value="' + unit + '"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price['+comp_id+'][+i+]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value=" ' + price + ' "></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');

							var material_type_id = $('#material_type').val();
            				select2CA(material_type_id, logged_user);

							var mat_id = $('#material_type').val();
					        //getMaterialIssue();
					        getMaterialNameCA(mat_id, y);
					        init_select2();
					        //get_Qty_UOm();
					       // getUomCA();
						
						}
					 }
			}
		});		
	}); 
}

function getProductDetails(clrt){
	$(".itemName").on("select2:select", function (e) { 
	var id=$('#id').val();
	var comp_id=$(this).val();
	var clrt=e.currentTarget;
	//alert(id);
	//alert($(clrt).val());
		//$("#contact_id").empty();
		var selectAccountVal = $(e.currentTarget).val();
		$.ajax({        
			//url: site_url +'bid_management/getMat/',
			url: site_url +'bid_management/getCompProduct/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: id,    
			},
			success: function(result){				
			
			if(result != '') {
				 		var input_mat = $(clrt).parents(".main_div").find('.welldata');
						var  objss = jQuery.parseJSON(JSON.stringify(result));
						console.log(result.length);
					    var len = objss.length;
						for(var i=0; i<len; i++){
							var material_name_id = objss[i].material_name_id;
							var material_name= objss[i].material_name;
							var qty = objss[i].qty;
							var disc = objss[i].description;
							var price = objss[i].price;
							var y = $('.input_fields_wrap .well').length;
							var logged_user = $('#loggedUser').val();
	$(input_mat).append('<div class="well scend-tr mobile-view"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name['+comp_id+']['+i+']"><option value="' + material_name_id + '" selected>'+material_name+'</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12" name="disc['+comp_id+']['+i+']" placeholder="Disc" required="required" type="text" value=" ' + disc + ' "></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom_value1['+comp_id+']['+i+']" class="form-control col-md-7 col-xs-12  uom" value="' + qty + ' " readonly></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price['+comp_id+']['+i+']" class="form-control col-md-7 col-xs-12 " placeholder="Price" value=" ' + price + ' "></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
					        init_select2();
					        //get_Qty_UOm();
					      
						
						}
					 }
			}
		});		
	}); 
		
}
/**
function getMatDetails(val){
$(".itemName").on("select2:select", function (e) { 
	var comp_id=$(this).val();
	var clrt=e.currentTarget;
	var input_mat = $(clrt).parents(".main_div").find('.welldata');
	//var input_mat = $('.input_holder2');
	var logged_user = $('#loggedUser').val();
		$(input_mat).append('<div class="col-sm-12 btn-row"><button onclick="getProductDetails(this,'+comp_id+')" class="btn edit-end-btn" type="button">Add</button></div>');
		});	
}
**/
/*fetching tax value on material elect*/
function getUomCA(evt, t) {
    setTimeout(function() {

        var option = $(t).find('option:selected');
        //var materialId = $('.materialId').val();

        var closestId = $(t).closest(".well").attr("id");
		
        console.log('closestId===>>>>', closestId);
        var materialId = $('#' + closestId + ' .materialNameId').val();

        $.ajax({
            type: "POST",
            url: site_url + 'bid_management/getMaterialDataByIdCA',
            data: {
               'id': materialId,
            },
            success: function(data) {
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




function add_price_prodct_row() {
    var input = 10;
    var input_mat = $(".input_holder");
    var add_mat = $(".add_price_prodct_row");
	var logged_user = $('#loggedUser').val();
    //var y = 1; 
    var y = $('.input_fields_wrap .well').length;
    $(add_mat).click(function(e) {
        // e.preventDefault();
        // var measurmentArray = '';
        // $.each( measurementUnits, function( key, value ) {
        // measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        // });
        if (y < input) {
            y++;
            $(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Compitetor Name</label><select class="itemName form-control selectAjaxOption select2" id="account_id" name="account_id[]" data-id="bid_competitor_details" data-key="id" data-fieldname="name" data-where="account_owner = ' + logged_user + ' AND save_status = 1" width="100%"></select></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12" name="disc[]" placeholder="Disc" required="required" type="text"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price"></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
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
    $(input_mat).on("click", ".remove_input", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
        keyupFunction(event, this);
    });
}

/*get material name when select material type*/
function getMaterialNameCompt(evt, t , selProcessType = '' , c_id = '' ){
    $(this).parents().closest('input=[text]').find('.productNameId').empty();
    var logged_user = $('#loggedUser').val();
    console.log("loggeduser",logged_user);
    var option = $(t).find('option:selected');
    console.log('option===>>>',option);
    var material_type_id = selProcessType != ''?selProcessType:$(option).val(); 
    if(material_type_id === undefined){
        material_type_id = $('.productNameId').find('option:selected').val();        
    }    
    if(material_type_id != ''){
        select2saleorder(material_type_id , logged_user);
    }
}

function select2saleorder(material_type_id , logged_user){
        $('.productNameId').attr('data-where','id = '+material_type_id+' AND account_owner='+logged_user+' AND save_status = 1');
        $('.productNameId').attr('data-id','competitor_details');
        $('.productNameId').attr('data-key','id');
        $('.productNameId').attr('data-fieldname','product_detail');

}

function addMaterialDetailCAproductvise() {
    var input = 10;
    var input_mat = $(".input_holder");
    var add_mat = $(".addmaterial");
	var logged_user = $('#loggedUser').val();
    //var y = 1; 
    var y = $('.input_fields_wrap .well').length;
    $(add_mat).click(function(e) {
        // e.preventDefault();
        // var measurmentArray = '';
        // $.each( measurementUnits, function( key, value ) {
        // measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        // });
        if (y < input) {
            y++;
            $(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '" ><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Competitor Name</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2" required="required" name="material_type_id[]" data-id="bid_competitor_details" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="account_owner= ' + logged_user + ' " onchange="getMaterialNameCompt(event,this)" id="material_type"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption24 select2 Add_mat_onthe_spot productNameId" id="mat_name" required="required" name="material_name[]" onchange="getUomCA(event,this);"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Description</label><input id="qty" class="form-control col-md-7 col-xs-12 qty" name="disc[]" placeholder="Disc" required="required" type="text"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" value="" readonly><input type="hidden" name="uom_value[]" class="uom1" readonly value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value=""></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');
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
    $(input_mat).on("click", ".remove_input", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
        keyupFunction(event, this);
    });
}
	
/*GET MATERIAL NAME*/
function getMaterialNameCA(evt, t, selProcessType = '', c_id = '') {

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
}

function select2CA(material_type_id, logged_user) {
    $('.materialNameId').attr('data-where', 'material_type_id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND status=1');
    $('.materialNameId').attr('data-id', 'material');
    $('.materialNameId').attr('data-key', 'id');
    $('.materialNameId').attr('data-fieldname', 'material_name');

}

function reject_offer()
{
var id=$('#id').val();
var reason=$('#reason').val();

        $.ajax({
            type: "POST",
            url: site_url + 'bid_management/update_reject_reason',
            data: {
               'id': id,
			   'reason':reason
            },
            success: function(data) {	
			if(data==true){
				//redirect('base_url().bid_management/pipeline');
				location.reload();
				}
}
		});
}
function accept_offer()
{
var id=$('#id').val();
  $.ajax({
            type: "POST",
            url: site_url + 'bid_management/update_id_status',
            data: {
               'id': id
			 },
            success: function(data) {	
			if(data==true){
				//redirect('base_url().bid_management/pipeline');
				location.reload();
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
			url: site_url + 'bid_management/getAddress',
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

// Add address details of account in sale order and proforma invoice
function getAccountDetails() {
	$("#account_id").on("select2:select", function (e) {
		$("#contact_id").empty();
		var selectAccountVal = $(e.currentTarget).val();
		var whereContactContact = "account_id='" + selectAccountVal + "'";
		$("#contact_id").attr("data-where", whereContactContact);
		$.ajax({
			url: site_url + 'bid_management/getAccountDataById/',
			dataType: 'json',
			type: 'POST',
			data: {
				id: selectAccountVal,
			},
			success: function (result) {
				$('#phone_no').val(result.phone);
				$('#gstin').val(result.gstin);
				$('#email').val(result.email);
				$.ajax({
					url: site_url + 'bid_management/fetchLocationById/',
					dataType: 'json',
					type: 'POST',
					data: {
						billing_city: result.billing_city,
						billing_state: result.billing_state,
						billing_country: result.billing_country,
					},
					success: function (resultData) {
						if (resultData != '') {
							console.log('resultData==>>>', resultData);
							var address = result.billing_street + '\n' + resultData.city + '\n' + result.billing_zipcode + '\n' + resultData.state + '\n' + resultData.country;
							$('#address').html(address);
						}
					}
				});
			}
		});

		$("#contact_id").on("select2:select", function (e) { // get phone number by contact id in sale order or proforma invoice
			var selectContactVal = $(e.currentTarget).val();
			$.ajax({
				url: site_url + 'bid_management/getContactDataById/',
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
//hrm 
function fetchdata() {
	$.ajax({
		url: site_url + 'bid_management/checkworkstatus/',
		type: 'post',
		success: function (response) {
			// Perform operation on the return value
			//alert(response);
		}
	});
}

$(document).ready(function () {
	setInterval(fetchdata, 5000);
});

$(document).on("click", "#ert", function () {
	$(".box1").slideToggle(1000);
});