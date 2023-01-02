function DateRange(){
	$(document).ready(function(){
		// set default dates
		var start = new Date();
		// set end date to max one year period:
		var end = new Date(new Date().setYear(start.getFullYear()+1));
		var retrunStart = new Date($('#RetrunStartDate').val());
		//alert(retrunStart);
	   $("#StartDate").datepicker({
		   format: 'yyyy-mm-dd',
		   autoclose: true,
		   startDate : start,
		   endDate   : end,
	   }).on('changeDate', function (selected) {
		   var minDate = new Date(selected.date.valueOf());
		   $('#EndDate').datepicker('setStartDate', minDate);
	   });

	   $("#EndDate").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			startDate : start,
			endDate   : end,
	   }).on('changeDate', function (selected) {   
			   var minDate = new Date(selected.date.valueOf());
			   $('#StartDate').datepicker('setEndDate', minDate);
	   });
		 $("#RetrunDate").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			startDate : retrunStart,
			endDate   : end,
	   })
	});
}
  
  function validate_date(date){
	  if(date!='')
	  {
var currdate = new Date();
var setDate =new Date(date);  
	  
	   
	var age = Math.floor((currdate - setDate) / (365.25 * 24 * 60 * 60 * 1000));
     //alert(age);
	   if ((age) > 18){
// you are above 18
        alert("above 18");
        }else{
        alert("below 18");
		$("#date").val('');
        }
	  }
    }
$(document).ready(function (e) {
	$('#date').datepicker({
		singleClasses: "picker_4",
		format: 'yyyy-mm-dd',
		endDate: '+0d',
		autoclose: true,
	}).attr('readonly', 'true');
	$('#date_join').datepicker({
		singleClasses: "picker_4",
		format: 'yyyy-mm-dd',
		endDate: '+0d',
		autoclose: true
	}).attr('readonly', 'true');	
	$("#profile_img").on('change', function () {
		if (typeof (FileReader) != "undefined") {
			var image_holder = $("#profile-holder");
			image_holder.empty();
			var reader = new FileReader();
			reader.onload = function (e) {
				$("<img />", {
					"src": e.target.result,
					"class": "",
					"height": "100px",
					"width": "100px"
				}).appendTo(image_holder);
			}
			image_holder.show();
			reader.readAsDataURL($(this)[0].files[0]);
		} else {
			alert("This browser does not support FileReader.");
		}
	});


	$(function () {
		$('body').on('click', '.reservation', function () {
			$(this).daterangepicker({
				timePicker: false,
				//timePickerIncrement: 30,
				locale: {
					format: 'MM/DD/YYYY',
				}
			}).attr('readonly', 'true').focus();
		});
	});


	$(function () {
		$('body').on('click', '.year', function () {
			$(this).not('.hasDatePicker').datepicker({
				minViewMode: 2,
				endDate: new Date(),
				autoclose: true,
				//yearRange: '1950:' + new Date().getFullYear().toString()
				format: 'yyyy',
			}).attr('readonly', 'true').focus();
		});
	});



	
	var limit = 10; //The number of records to display per request
	var start = 0; //The starting pointer of the data
	var action = 'inactive'; //Check if current action is going on or not. If not then inactive otherwise active
	function load_user_log_data(limit, start) {
		var segment_str = window.location.pathname;
		var segment_array = segment_str.split('/');
		var last_segmentId = segment_array[segment_array.length - 1];
		$.ajax({
			url: site_url + 'hrm/fetch_user_activity_log/',
			method: "POST",
			data: {
				limit: limit,
				start: start,
				id: last_segmentId
			},
			cache: false,
			success: function (data) {
				$('#load_data').append(data);
				if (data == '') {
					//$('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
					$('#load_data_message').html("<p>No Records</p>");
					action = 'active';
				} else {
					$('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
					action = 'inactive';
				}

			}
		});
	}

	if (action == 'inactive') {
		action = 'active';
		load_user_log_data(limit, start);
	}
	
	$(window).scroll(function () {
		if ($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive') {
			action = 'active';
			start = start + limit;
			setTimeout(function () {
				load_user_log_data(limit, start);
			}, 1000);
		}
	});
});

$(document).on('click', '.change_status', function () {
	var status;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) status = 1;
	else status = 0; 
	var id = $(this).attr("data-value");
	$.ajax({
		url: site_url + 'hrm/change_status/',
		dataType: 'json',
		type: 'POST',
		data: {
			id: id,
			status: status,
		},
		success: function (data) {
			if (data.status == 'success') {
				location.reload();
			}
		}
	});
});
$(document).on('click', '.change_hr_permissions', function () {
	var hr_permissions;

	var checkbox = $(this).attr('checked', true);
    if (checkbox.context.checked == true) hr_permissions = 1;
	else hr_permissions = 0; 
	 var id = $(this).attr("data-value"); 
	$.ajax({
		url: site_url + 'hrm/change_hr_permissions/',
		dataType: 'json',
		type: 'POST',
		data: {
			id: id,
			hr_permissions: hr_permissions,
		},
		success: function (data) {
			if (data.hr_permissions == 'success') {
				location.reload();
			}
		}
	});
});


$('.permissions_cls').on('click', function (e) {
	if ($(this).hasClass('all') && $(this).prop('checked') == true) {
		$(this).closest("tr").find(".permissions_cls").prop('checked', true);
	} else if ($(this).hasClass('all') && $(this).prop('checked') == false) {
		$(this).closest("tr").find(".permissions_cls").prop('checked', false);
	}
	if ($(this).closest("tr").find(".all").prop('checked') == true) {
		$(this).closest("tr").find(".permissions_cls").prop('checked', true);
	}
	/*if($(this).closest("tr").find(".add").prop('checked')==true) {
		$(this).closest("tr").find(".view").prop('checked', true);	
	}*/
	if ($(this).closest("tr").find(".add").prop('checked') == true && $(this).closest("div").parent().is("#collapse_5") == false) {
		$(this).closest("tr").find(".view").prop('checked', true);
	}

	if ($(this).closest("tr").find(".edit").prop('checked') == true && $(this).closest("div").parent().is("#collapse_5") == false) {
		$(this).closest("tr").find(".view").prop('checked', true);
		$(this).closest("tr").find(".add").prop('checked', true);
	}
	if ($(this).closest("tr").find(".delete").prop('checked') == true && $(this).closest("div").parent().is("#collapse_5") == true) {
		//$(this).closest("tr").find(".view").prop('checked', true);	
		$(this).closest("tr").find(".add").prop('checked', true);
		$(this).closest("tr").find(".edit").prop('checked', true);
	} else if ($(this).closest("tr").find(".delete").prop('checked') == true && $(this).closest("div").parent().is("#collapse_5") == false) {
		$(this).closest("tr").find(".view").prop('checked', true);
		$(this).closest("tr").find(".add").prop('checked', true);
		$(this).closest("tr").find(".edit").prop('checked', true);

	}
	/*if($(this).closest("tr").find(".edit").prop('checked')==true) {
		$(this).closest("tr").find(".view").prop('checked', true);	
		$(this).closest("tr").find(".add").prop('checked', true);	
	}
	if($(this).closest("tr").find(".delete").prop('checked')==true) {
		$(this).closest("tr").find(".view").prop('checked', true);	
		$(this).closest("tr").find(".add").prop('checked', true);	
		$(this).closest("tr").find(".edit").prop('checked', true);	
	}*/
	if ($(this).closest("tr").find(".validate").prop('checked') == true) {
		$(this).closest("tr").find(".view").prop('checked', true);
		$(this).closest("tr").find(".add").prop('checked', true);
	}
});


function showListView() {
	$('#gridview').hide();
	$('#listview').show();
}

function showGridView() {
	$('#listview').hide();
	$('#gridview').show();
}


function getState(evt, t, type = '') {
	//console.log('evt===>>>', evt);
	//console.log('t===>>>', t);
	//console.log('type===>>>', type);

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


$(document).ready(function () {
	$(".country_id").each(function () {
		/*var countryVal = $(this).val() ;		
		var closestDiv = $(this).attr("closestDiv");
		var stateVal = $(this).attr("state_data");
		var cityVal = $(this).attr("city_data");	*/
		var closestDiv = $(this).attr("closestDiv");
		var stateVal = $(this).attr("state_data");
		var cityVal = $(this).attr("city_data");
		var countryVal = 1;
		getState('', '', countryVal, closestDiv, stateVal);
	});

	$(".state_id").each(function () {
		var stateVal = $(this).val();
		var closestDiv = $(this).attr("closestDiv");
		var cityVal = $(this).attr("city_data");
		getCity('', '', stateVal, closestDiv, cityVal);
	});
});

$(document).on('click', '.add_users_dataaa44', function () {
	$('.qualification_section').each(function () {
		if (this.value == "") {
			// $('#qualification').addClass('bad');
			$(this).closest('.item').addClass('bad');
		} else {
			$(this).closest('.item').removeClass('bad');
		}
	})

	$('.work_experience_section').each(function () {
		if (this.value == "") {
			// $('#qualification').addClass('bad');
			$(this).closest('.item').addClass('bad');
		} else {
			$(this).closest('.item').removeClass('bad');
		}
	})
	$('.skill_section').each(function () {
		if (this.value == "") {
			// $('#qualification').addClass('bad');
			$(this).closest('.item').addClass('bad');
		} else {
			$(this).closest('.item').removeClass('bad');
		}
	})


});


$(document).ready(function (e) {
	//getUserActivityGraphData();
});


function getUserActivityGraphData() {
	var userid = $("input[name='u_id']").val();
	$.ajax({
		url: site_url + 'hrm/userActivityGraphData/',
		dataType: 'json',
		type: 'POST',
		data: {
			'userid': userid
		},
		success: function (response) {
			if (response != '') {
				activityJsonObj = [];
				$(response).each(function () {
					item = {}
					item["date"] = $(this)[0].date_field;
					item["Activity count"] = $(this)[0].userId;
					activityJsonObj.push(item);
				});
				if ($('#user_activity_graph_bar').length) {
					Morris.Bar({
						element: 'user_activity_graph_bar',
						data: activityJsonObj,
						xkey: 'date',
						ykeys: ['Activity count'],
						labels: ['Activity count'],
						barRatio: 0.4,
						barColors: ['#26B99A'],
						xLabelAngle: 35,
						hideHover: 'auto',
						resize: true
					});
				}
			}
		}
	});
}


/*
	
$(document).ready(function(){
	 $image_crop = $('#image_demo').croppie({
		enableExif: true,
		viewport: {
		  width:200,
		  height:200,
		  type:'square' //circle
		},
		boundary:{
		  width:300,
		  height:300
		}
	  }); 

	  $('#user_profile').on('change', function(){
		var reader = new FileReader();
		reader.onload = function (event) {
		  $image_crop.croppie('bind', {
			url: event.target.result
		  }).then(function(){
			console.log('jQuery bind complete');
		  });
		}
		reader.readAsDataURL(this.files[0]);
		$('#uploadimageModal').modal('show');
	  });

	  $('.crop_image').click(function(event){		
		var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		$image_crop.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: site_url +'users/uploadImageByAjax/',
				type: "POST",
				data:{"image": response, 'uploaded_image_name': uploaded_image_name},
				success:function(data){				
				  var result = $.parseJSON(data);				 
				  $('#uploadimageModal').modal('hide');
				 // $('#uploaded_image').html(data);
				  $('#uploaded_image').html(result.imageHtml);
				  $('#changed_user_profile').val(result.image);
				  
				}
			});
		})
	  });

}); 


*/


$(document).ready(function () {
    
	$('#upload_user_profile_image').click(function (event) {
		$('#uploadimageModal').modal('show');
	});


	$image_crop = $('#image_demo').croppie({
		enableExif: true,
		viewport: {
			width: 200,
			height: 200,
			type: 'square' //circle
		},
		boundary: {
			width: 300,
			height: 300
		}
	});

	$('#user_profile').on('change', function () {
		$('.crop_section').css("display", "block");
		var reader = new FileReader();
		reader.onload = function (event) {
			$image_crop.croppie('bind', {
				url: event.target.result
			}).then(function () {
				console.log('jQuery bind complete');
			});
		}
		reader.readAsDataURL(this.files[0]);
		//$('#uploadimageModal').modal('show');
	});

	$('.crop_image').click(function (event) {
		var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		var userId = $("input[name=u_id]").val();
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (response) {
			$.ajax({
				url: site_url + 'hrm/uploadImageByAjax/',
				type: "POST",
				data: {
					"image": response,
					'uploaded_image_name': uploaded_image_name,
					'user_id': userId
				},
				success: function (data) {
					var result = $.parseJSON(data);
					window.location.href = site_url + 'hrm/editUser/' + userId;
					$('#uploadimageModal').modal('hide');
					// $('#uploaded_image').html(data);
					$('#uploaded_image').html(result.imageHtml);
					$('#changed_user_profile').val(result.image);

				}
			});
		})
	});


});
/*$(document).ready(function (e) {
	$(document).on("click", ".user_edit", function (ev) {
    ev.preventDefault();
	addMoreDetails();
	});

});*/
/*******************************************************Other modules*******************************************/
$(document).ready(function (e) {
	$(document).on("click", ".hrmTab", function (ev) {
		ev.preventDefault();
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		
	 
	 console.log(tab);
	 console.log('tab');

		switch (tab) {
			/*case 'processEdit':
				url = 'production/editprocess';
				break;	*/
			case 'editworkdetails':
				url = 'hrm/editworkdetails';
				break;
			case 'viewSlary':
		     	url = 'hrm/show_payroll_process_per_emp';
			break;
			case 'viewworkdetails':
				url = 'hrm/viewworkdetails';
				break;
			case 'workerView':
				url = 'hrm/worker_view';
				break;
			case 'workerWorkedView':
				url = 'hrm/worker_worked_view';
				break;
			case 'workerEdit':
				url = 'hrm/worker_edit';
				break;

			case 'attendanceAdd':
				url = 'hrm/attendance_edit';
				break;

			case 'holidayAdd':
				url = 'hrm/holidayedit';
				break;
			case 'weekoffAdd':
				url = 'hrm/weekoffedit';
				break;
			case 'weekoffEmpAdd':
				url = 'hrm/empweekoffedit';
				break;
			case 'leave_allotment':
				url = 'hrm/hr_leave_allotment';
				break;
			case 'leavetype':
				url = 'hrm/leave_type_edit';
				break;
				case 'viewleavetype':
				url = 'hrm/leave_type_view';
				break;
			case 'addApplication':
				url = 'hrm/leave_application_edit';
				break;

			case 'addEarnedLeave':
				url = 'hrm/earned_leave_edit';
				break;
			case 'viewEarnedLeave':
				url = 'hrm/earned_leave_view';
				break;
			case 'addAssets':
				url = 'hrm/assets_edit';
				break;

			case 'addAssetsList':
				url = 'hrm/addAssetsList';
			break;
			case 'AssignAssetsEmp':
				url = 'hrm/AssignAssetsEmp';
				break;			
			case 'ReturnAssetsEmp':
				url = 'hrm/ReturnAssetsEmp';
				break;			
			case 'ViewAssetsEmp':
				url = 'hrm/ViewAssetsEmp';
				break;
            case 'ViewAssetsEmpdtl':
				url = 'hrm/ViewAssetsEmpdtl';
				break;					
			case 'ViewLeaveApp':
				url = 'hrm/ViewLeaveApp';
				break;	
			case 'viewWorkerLeavApp':
				url = 'hrm/viewWorkerLeavApp';
				break;	
			case 'CancelLeaveApp':
				url = 'hrm/CancelLeaveApp';
				break;			
			case 'ReturnAssetsWorker':
				url = 'hrm/ReturnAssetsWorker';
				break;			
			case 'ViewAssetsWorker':
				url = 'hrm/ViewAssetsWorker';
				break;
			case 'ViewAssetsWorkerdtl':
				url = 'hrm/ViewAssetsWorkerdtl';
				break;	
			case 'AssignAssetsWork':
				url = 'hrm/AssignAssetsWork';
				break;

			case 'addJobPosition':
				url = 'hrm/add_job_position';
				break;
			case 'attendanceAddWorkers':
				url = 'hrm/attendance_edit_workers';
				break;
			case 'convertUser':
				url='hrm/convertUser';
				break;
			case 'addWorkApplication':
				url = 'hrm/leave_application_edit_worker';
				break;
			case 'viewWorkApplication':
				url = 'hrm/leave_application_view_worker';
				break;
			case 'editJobPosition':
				url = 'hrm/add_job_position';
				break;
			case 'viewJobPosition':
				url = 'hrm/view_job_position';
				break;
			case 'addJobApplication':
				url = 'hrm/add_job_application';
				break;
			case 'editJobApplication':
				url = 'hrm/add_job_application';
				break;
			case 'viewJobApplication':
				url = 'hrm/view_job_application';
				break;
			case 'RateJobApplication':
				url = 'hrm/rate_job_application';
				break;
			case 'editterms_condtn':
				url = 'hrm/editterms_condtn';
				break;
			case 'viewterms_condtn':
				url = 'hrm/termscond_view';
				break;
			case 'usersalary':
				url = 'hrm/users_salary_edit';
				break;
			case 'viewusersalary':
				url = 'hrm/users_salary_view';
				break;
			case 'salarySlab':
				url = 'hrm/salary_slab_edit';
				break;
			case 'viewsalarySlab':
				url = 'hrm/salary_slab_view';
				break;
				
			case 'editprofile':
				url = 'hrm/editprofile';
				break;
			case 'AddTavelInfo':
				url = 'hrm/add_travel_info';
				break;			
			case 'ViewTavelInfo':
				url = 'hrm/view_travel_info';
				break;
			case 'ViewTavelInfoDtl':
				url = 'hrm/ViewTavelInfoDtl';
				break;				
			case 'PaidTavelExpenses':
				url = 'hrm/paid_travel_info';
				break;
			case 'AddSalaryComponent':
				url = 'hrm/add_salary_component';
				break;			
			case 'ViewSalaryComponent':
				url = 'hrm/view_salary_component';
				break;			
	        case 'AddTaskListStatus':
				url = 'hrm/add_task_list_status';
				break;	
			case 'ViewTaskListStatus':
				url = 'hrm/view_task_list_status';
				break;			
            case 'AddSprint':
				url = 'hrm/add_sprint_task_list';
				break;			
            case 'AddRole':
				url = 'hrm/add_role_task_list';
				break;			
           case 'AddRole_to_user_worker':
				url = 'hrm/add_role_task_list_to_user';
				break;			
		   case 'AddTask':
				url = 'hrm/add_task_to_userWorker';
				break;	
			case 'view_new_workdetails':
				url = 'hrm/view_new_workdetails';
				break;
		}
	
		if (tab == 'AddTask') {
	
			$('#myModalLabel').html('Add Task');
		}

		if (tab == 'convertToProd') {
			$('.tabclass').html('Production Data');
		}
		if (tab == 'create_work_order') {
			$('.sale_order_work_order').html('Work Order');
		}
		if (tab == 'productionPlanEdit') {
			$('.tabclass').html('Production Planning');
		}
		/* if (tab == 'convertUser') {
				addMoreDetails();
			}	*/	
	

		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {
				id: id
			},
			success: function (data) {
				if (data != '') {
					if(tab == 'convertUser'){
						$("#convertUser_modal").modal({
						show: false,
						backdrop: 'static'
					});
					$('#convertUser_modal').modal('show');
					$('#convertUser_modal .modal-body-content').html(data);
					//addMoreDetails();
					}else{
					$("#hrm_modal").modal({
						show: false,
						backdrop: 'static'
					});
					$('#hrm_modal').modal('show');
					$('#hrm_modal .modal-body-content').html(data);
                    }
					if (tab == 'production_department_edit') {


					}

					if (tab == 'addApplication') {

						fetchLeaveTotal();


					}

					if (tab == 'addWorkApplication') {

						fetchLeaveTotal();


					}

					if (tab == 'AssignAssetsEmp' || tab == 'ReturnAssetsEmp' || tab == 'AssignAssetsWork' || tab == 'ReturnAssetsWorker') {
						addMoreProduct();
						DateRange();

					}	
					if (tab == 'workerEdit') {
						dateFunction();
						getAddress();
					}
					/*validation*/
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
					remarks_disEin();
					addMoreDetails();
					//init_select21();					
					//init_select221();						
				}
			}
		});
	});


});

//print
$('#bbtn').on('click', function() {
    printData();
})

//Print Function
function printData() {
    $('.pagination').hide();
    $('.dataTables_info').hide();
    $('.dataTables_length').hide();
    $('.dataTables_filter').hide();
    $('.hidde').hide();
    $('.btn-group').hide();
    var divToPrint = document.getElementById("print_div_content");
    newWin = window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
    location.reload();

}

/* For PipeLine Module Drag & Drop Functionality*/
 
 
 
/*$(function () {
 
	var kanbanCol = $('.panel-body');
	kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');
	var kanbanColCount = parseInt(kanbanCol.length);
	$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');
	var dragClass = $(".dragg");
	var dragSaleClass = $(".saleOrderPriority");

	var dragMachineClass = $(".machine_order_priority");
 
	  
	if (dragClass.hasClass('dragg')) {
	 
		draggableInit();
	}

	if (dragSaleClass.hasClass('saleOrderPriority')) {
		 
		draggableSaleOrderInit();
	 
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

 
});


function draggableInit() {
	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {
	 
		sourceId = $(this).parent().attr('id');
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
	 
	});
	$('.panel-body').bind('dragover', function (event) {
		event.preventDefault();
	});
	$('.panel-body').bind('drop', function (event) {
		var children = $(this).children();
		var targetId = children.attr('id');
		//console.log("targetid==>>", targetId);
		if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
		 
			$.ajax({
				url: site_url + 'hrm/changeProcessType/',
				dataType: 'json',
				type: 'POST',
				data: {
					'processId': elementId,
					'processTypeId': targetId,
				},
				success: function (result) {
					if (result.status == 'success') {
						window.location.href = result.url;

					}
				}
			});
			$('#processing-modal').modal('toggle'); //before post
		 
			setTimeout(function () {
				var element = document.getElementById(elementId);
				children.prepend(element);
				$('#processing-modal').modal('toggle'); // after post
				gettotal();
			}, 1000);
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
*/

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
		url: site_url + 'hrm/changeOrder/',
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
 
	setTimeout(function () {
		var element = document.getElementById($(this).attr('id'));
		children.prepend(element);
		$('#processing-modal').modal('toggle'); // after post
	}, 1000);

}


function fetchdata() {
	$.ajax({
		url: site_url + 'hrm/checkworkstatus/',
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


/********For Workers**************/
// /*chang statsu in worker*/
$(document).on('change', '.change_status_worker', function () {
	var workerStatus;
	var checkbox = $(this).attr('checked', true);
	if (checkbox.context.checked == true) workerStatus = 1;
	else workerStatus = 0;
	var id = $(this).attr("data-value");

	$.ajax({
		url: site_url + 'hrm/change_status_worker/',
		dataType: 'json',
		type: 'POST',
		data: {
			'id': id,
			'workerStatus': workerStatus,
		},
		success: function (data) {
			if (data == true) {
				location.reload();
			}
		}
	});
});


/**************datefunction in worker and set prodcution dispatch date **************/
function dateFunction() {

	var date = new Date();
	//date.setDate(date.getDate()-0);
	$('.date_of_join').datepicker({
		startDate: date,
		dateFormat: 'dd-mm-yy',
		onSelect: function (selected) {
			$(".date_of_reliev").datepicker("option", "minDate", selected)
		}
	});

	var date1 = new Date();
	//date1.setDate(date1.getDate()-0);
	$('.date_of_reliev').datepicker({
		dateFormat: 'dd-mm-yy',
		beforeShow: function () {
			$(this).datepicker('option', 'minDate', $('#date_of_join').val());
			if ($('#date_of_join').val() === '') $(this).datepicker('option', 'minDate', 0);
		}
		/*onSelect: function(selected) {
           $(".date_of_relieving").datepicker("option","minDate", selected)
       }*/
	});
	$('#dispatch_date').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});

	//var startDate = $('.prevous_date').val();
	//console.log('startDate',startDate);
	$('#set_prod_dispatch_date').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		// minDate: startDate,
		autoclose: true

	});

	$('#expected_date').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		// maxDate: '-1d',
		autoclose: true
	});


}


/*****************************************************************compny unit in worker*****************************/
function getAddress() {
	$('.address').select2({
		allowClear: true,
		placeholder: 'Select Address',
		closeOnSelect: true,
		ajax: {
			url: site_url + '/hrm/getcompany_unit',
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
	$('#attendance123,#attendance122').DataTable({
		"aaSorting": [
			[2, 'desc']
		] 
	});

$('#example23').DataTable({});


	$('#example234').DataTable({});

	$('#example235').DataTable({
		dom: 'Bfrtip',
		buttons: [
			'print'
		]
	});
$('#example135').DataTable({
	 "order": [[ 2, "desc" ]]
	});
 

});

$(window).load(function() {
     	CKEDITOR.replace('content');
});

$(window).load(function() {
     	CKEDITOR.replace('terms_cond');
});




$(document).ready(function () {
	$('#startfrom').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});


	$('#startto').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});
});


function fetchLeaveTotal() {
	$('.fetchLeaveTotal').on('click', function (e) {
		e.preventDefault();
		var selectedEmployeeID = $('.selectedEmployeeID').val();
		var leaveTypeID = $('.assignleave').val();
		//console.log(selectedEmployeeID, leaveTypeID);
		$.ajax({
			url: site_url + 'hrm/LeaveAssign/',
			method: "POST",
			data: {
				leaveTypeID: leaveTypeID,
				employeeID: selectedEmployeeID
			},
		}).done(function (response) {
			//console.log(response);
			$("#total").html(response);
		});
	});
}


function remarks_disEin() {

	$('#leaveapply input').on('change', function (e) {
		e.preventDefault(e);
		var duration = $('input[name=type]:checked', '#leaveapply').attr('data-value');
		//console.log(duration);
		if (duration == 'Half') {
			$('#enddate').hide();
			$('#hourlyFix').text('Date');
			$('#hourAmount').show();
		} else if (duration == 'Full') {
			$('#enddate').hide();
			$('#hourAmount').hide();
			$('#hourlyFix').text('Date');
		} else if (duration == 'More') {
			$('#enddate').show();
			$('#hourAmount').hide();
		}
	});
	$('#appmodel').on('hidden.bs.modal', function () {
		location.reload();
	});
	// Get the record's ID via attribute		                                        		                                    
}

$(".Status").on("click", function (event) {
	event.preventDefault(); 
	 // alert($(this).attr('approvedby'),);
	 $.ajax({
		url: site_url + 'hrm/approveLeaveStatus/',
		type: "POST", 
		data: {
			'approvedby': $(this).attr('approvedby'),
			'employeeId': $(this).attr('data-employeeId'),
			'lid': $(this).attr('data-id'),
			'lvalue': $(this).attr('data-value'),
			'duration': $(this).attr('data-duration'),
			'type': $(this).attr('data-type')
		},
		success: function (response) {
			// console.log("bdfgbsdhfsdf",response);
		      location.reload();
		},
		error: function (response) {
			//console.error();
		}
	});
});


$(".StatusW").on("click", function (event) {
	 
	event.preventDefault();
	// console.log($(this).attr('data-value'));
	$.ajax({
		url: site_url + 'hrm/approveLeaveStatusWorker/',
		type: "POST",
		data: {
			'approvedby': $(this).attr('approvedby'),
			'employeeId': $(this).attr('data-employeeId'),
			'lid': $(this).attr('data-id'),
			'lvalue': $(this).attr('data-value'),
			'duration': $(this).attr('data-duration'),
			'type': $(this).attr('data-type')
		},
		success: function (response) {
			// console.log(response);
			  location.reload();
		},
		error: function (response) {
			//console.error();
		}
	});
});

/*$(document).ready(function () {
          $(document).on('keyup','.hours_worked',function() {
            var finalsalary = 0;  
            //var total;  
            var deduction = 0; 
            var rows = this.closest('#generatePayrollForm div');
             
            var hrate = parseFloat($('.hrate').val()); 
            var final =parseFloat($('.total_paid').val());
            var loan = parseFloat($('.loan').val());  
            var hwork =parseFloat($('.hours_worked').val());
            var thour =parseFloat($('.thour').val());
              
              finalsalary = (hwork*hrate) - loan;
              $(".total_paid").val(finalsalary.toFixed(2));
              var total = thour - hwork;
              var deduction = (total*hrate) + loan;
              $(".diduction").val(deduction.toFixed(2));
              $(".wpay").html(total.toFixed(2));

              console.log(loan);
           // var returnval;
              //returnval = payval - payableval;
/*            if(returnval<=0){
                  $(".due").val(Math.abs(returnval).toFixed(2));
              }else if(returnval > 0){
                 $(".due").val(''); 
              }
              $(".return").val(returnval.toFixed(2));*/

/*     });
   });*/

$("#BtnSubmit").on("click", function (event) {
	event.preventDefault();
 
	var depid = $('#depid').val();
	var datetime = $('.datepick').val();
   if(datetime){
	$.ajax({
		url: site_url + 'hrm/load_employee/',
		type: "POST",
		data: {
			'date_time': datetime
		},
		success: function (response) {
			$('.payroll').html(response);
		},
		error: function (response) {}
	});
}
});


$(".PayslipGenerate").on("click", function (event) {
	//Print_data_new();
	event.preventDefault();
	// console.log($(this).attr('data-value'));
	$.ajax({
		url: site_url + 'hrm/invoice/',
		type: "POST",
		data: {
			'employeeId': $(this).attr('data-employeeId'),
			'pid': $(this).attr('data-id')
		},
		success: function (response) {
			$('#hrm_modal').modal('show');
			$('#hrm_modal .modal-body-content').html(response);
			// console.log(response);
			//location.reload();
		},
		error: function (response) {
			//console.error();
		}
	});
});


$(document).ready(function () {
	$(document).on('click', ".sgh", function (e) {
		e.preventDefault(e);
		//Print_data_new();
		// console.log($(this).attr('data-value'));
		var emid = $(this).data('id');
		var month = $(this).data('month');
		var year = $(this).data('year');

        
 		var has_loan = $(this).data('has_loan');
		$('#generatePayrollForm').find('[name="emid"]').val(emid).attr('readonly', true).end();
		$('#generatePayrollForm').find('[name="month"]').val(Math.abs(month)).attr('readonly', true).end();
		$.ajax({
			url: site_url + 'hrm/generate_payroll_for_each_employee/',
			type: "POST",
			data: {
				'month': month,
				'year': year,
				'emid': emid
			},
			success: function (response) {
				$('#hrm_modal').modal('show');
				$('#hrm_modal .modal-body-content').html(response);
				// console.log(response);
				//location.reload();
			},
			error: function (response) {
				//console.error();
			}
		});
	});
});

$(document).ready(function () {
	$(document).on('keyup', '.hours_worked', function () {
		var finalsalary = 0;
		//var total;  
		var deduction = 0;
		var rows = this.closest('#generatePayrollForm div');

		var hrate = parseFloat($('.hrate').val());
		var final = parseFloat($('.total_paid').val());
		var loan = parseFloat($('.loan').val());
		var hwork = parseFloat($('.hours_worked').val());
		var thour = parseFloat($('.thour').val());

		finalsalary = (hwork * hrate) - loan;
		$(".total_paid").val(finalsalary.toFixed(2));
		var total = thour - hwork;
		var deduction = (total * hrate) + loan;
		$(".diduction").val(deduction.toFixed(2));
		$(".wpay").html(total.toFixed(2));

		//console.log(loan);
		// var returnval;
		//returnval = payval - payableval;
		/*            if(returnval<=0){
		                  $(".due").val(Math.abs(returnval).toFixed(2));
		              }else if(returnval > 0){
		                 $(".due").val(''); 
		              }
		              $(".return").val(returnval.toFixed(2));*/

	});
});

// Assign Assets Employees
function addMoreProduct() {
	var maximum = 10; //maximum input boxes allowed
	var wrap_material = $(".input_productre"); //Fields wrapper
	var button_add = $(".addProductButtonre"); //Add button ID
	var x = 1; //initlal text box count	
	var logged_user1 = $('#loggedUser').val();
	$(button_add).click(function (e) {
		//on add input button click
		e.preventDefault();
		if (x < maximum) { //max input box allowed
			x++;
			//var dataWhere = $("#material").attr("data-where");
			$(wrap_material).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_' + x + '"><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Product Name<span class="required">*</span></label><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible assets_name" name="product_name[]" data-id="assets_list" data-key="id" data-fieldname="ass_name" data-where="created_by_cid = ' + logged_user1 + '  AND in_stock != 0" width="100%" tabindex="-1" aria-hidden="true" required="required" id="assets_id" onchange="getAssetsValue(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"><label class="col-md-12">Model No.</label><input type="text" name="model_no[]"  placeholder="Model No..." class="form-control col-md-7 col-xs-12" required="required" readonly></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label class="col-md-12" >Assets Code</label><input type="text" name="assets_code[]"  placeholder="Assets Code..." class="form-control col-md-7 col-xs-12"  required="required" readonly></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Remarks</label><textarea style="border-right:1px solid #c1c1c1 !important;" name="remarks[]" placeholder="Remarks..." class="form-control col-md-7 col-xs-12"></textarea> </div><input type="hidden" name="return_remarks[]" value=""><button class="btn btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');

			var logged_user = $('#loggedUser').val();
			var material_type_id = $('#assets_id').val();
			//console.log("fff", material_type_id);
			select2(material_type_id, logged_user);
			init_select2();
			//init_select221();
		}
		//getMaterials(x);
	});
	$(wrap_material).on("click", ".remove_btn", function (e) {//user click on remove text 
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
		/*keyupFunction(event,this);
		remove_calculation_quot_pi_so();*/
	});
	
}
var x = 1;
$(".add_qualification_button ").on("click", function (event) {
	var max_fields = 10; //maximum input boxes allowed
	var wrapper = $(".quaification_wrapper"); //Fields wrapper
	var add_button = $(".add_qualification_button"); //Add button ID
	 //initlal text box count
	 //on add input button click
	
	//alert(x);
		//e.preventDefault();
		if (x < max_fields) { //max input box allowed
			
			$(wrapper).append('<div class="col-md-12 input_qualification_wrap item middle-box scend-tr"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text"  name="qualification[]" class="form-control col-md-1 qualification_section" placeholder="Qualification" ></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="university[]" class="form-control col-md-1 qualification_section" placeholder="University"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text"  name="year[]" class="form-control col-md-1 year qualification_section" placeholder="Year of Passing" readonly></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input style="border-right:1px solid #c1c1c1 !important" type="number"  required="required" name="marks[]" class="form-control col-md-1" placeholder="Percentage"></div><button class="btn btn-danger remove_qualification_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	x++;
		$(wrapper).on("click", ".remove_qualification_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	});
});
$(".add_experience_button").on("click", function (event) {
	var max_fields = 10; //maximum input boxes allowed
	var experienceWrapper = $(".experience_wrapper"); //Fields wrapper
	var add_button = $(".add_experience_button"); //Add button ID
	var x = 1; //initlal text box count
	 //on add input button click
//e.preventDefault();
		if (x < max_fields) { //max input box allowed
			
			$(experienceWrapper).append('<div class="input_experience_wrap item middle-box scend-tr col-md-12"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text"  name="companyName[]" class="form-control col-md-1 work_experience_section" placeholder="Company Name" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="companyLocation[]" class="form-control col-md-1 work_experience_section" placeholder="Location" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="position[]" class="form-control col-md-1 work_experience_section" placeholder="Position" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><form class="form-horizontal"><fieldset><div class="control-group"><div class="control-group"><div class="controls"><div class="input-prepend input-group"><span class="add-on input-group-addon">Work Period</span><input type="text"  name="work_period[]" class="form-control reservation" value="01/01/2016 - 01/25/2016" /></div></div></div></div></fieldset></form></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><textarea style="border-right:1px solid #c1c1c1 !important;" name="responsibility[]" class="form-control col-md-7 col-xs-12 work_experience_section" placeholder="Responsibilities"></textarea></div><button class="btn btn-danger remove_experience_field" type="button"><i class="fa fa-minus"></i></button></div>');

		}x++;
	$(experienceWrapper).on("click", ".remove_experience_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	});
});

$(".add_skill_button").on("click", function (event) {
var max_skill_fields = 5; //maximum input boxes allowed
	var skill_wrapper = $(".skill_wrapper"); //Fields wrapper
	var add_skill_button = $(".add_skill_button"); //Add button ID
	var y = 1; //initlal text box count
		//e.preventDefault();
		if (y < max_skill_fields) { //max input box allowed
		
			$(skill_wrapper).append('<div class="col-md-12 input_skill_wrap item vertical-border"><label class="col-md-3 col-sm-3 col-xs-12" for="name"></label><div class="col-md-5 col-sm-12 col-xs-12 "><input type="text" name="skill_name[]" class="form-control col-md-7 skill_section" placeholder="Name" value=""></div><div class="col-md-3 col-sm-12 col-xs-12"><input type="number"  name="skill_count[]" class="form-control col-md-1 skill_section" placeholder="Count" value=""></div><button class="btn btn-danger remove_skill_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}	y++;

	$(skill_wrapper).on("click", ".remove_skill_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	});
});
// Assign Assets Employees
function addMoreDetails() {

		/*add more for key people*/
	var max_fields = 10; //maximum input boxes allowed
	var wrapper = $(".quaification_wrapper"); //Fields wrapper
	var add_button = $(".add_qualification_button"); //Add button ID
	var x = 1; //initlal text box count
	$(add_button).click(function (e) { //on add input button click
	
	//alert(x);
		e.preventDefault();
		if (x < max_fields) { //max input box allowed
		x++;	
			$(wrapper).append('<div class="col-md-12 input_qualification_wrap item middle-box scend-tr"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text"  name="qualification[]" class="form-control col-md-1 qualification_section" placeholder="Qualification" ></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="university[]" class="form-control col-md-1 qualification_section" placeholder="University"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text"  name="year[]" class="form-control col-md-1 year qualification_section" placeholder="Year of Passing" readonly></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input style="border-right:1px solid #c1c1c1 !important" type="number"  required="required" name="marks[]" class="form-control col-md-1" placeholder="Percentage"></div><button class="btn btn-danger remove_qualification_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	});
		$(wrapper).on("click", ".remove_qualification_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	});
/*add more for experience*/
	var max_fields = 10; //maximum input boxes allowed
	var experienceWrapper = $(".experience_wrapper"); //Fields wrapper
	var add_button = $(".add_experience_button"); //Add button ID
	var x = 1; //initlal text box count
	$(add_button).click(function (e) { //on add input button click

		e.preventDefault();
		if (x < max_fields) { //max input box allowed
			x++;
			$(experienceWrapper).append('<div class="input_experience_wrap item middle-box scend-tr col-md-12"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text"  name="companyName[]" class="form-control col-md-1 work_experience_section" placeholder="Company Name" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="companyLocation[]" class="form-control col-md-1 work_experience_section" placeholder="Location" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="position[]" class="form-control col-md-1 work_experience_section" placeholder="Position" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><form class="form-horizontal"><fieldset><div class="control-group"><div class="control-group"><div class="controls"><div class="input-prepend input-group"><span class="add-on input-group-addon">Work Period</span><input type="text"  name="work_period[]" class="form-control reservation" value="01/01/2016 - 01/25/2016" /></div></div></div></div></fieldset></form></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><textarea style="border-right:1px solid #c1c1c1 !important;" name="responsibility[]" class="form-control col-md-7 col-xs-12 work_experience_section" placeholder="Responsibilities"></textarea></div><button class="btn btn-danger remove_experience_field" type="button"><i class="fa fa-minus"></i></button></div>');

		}
	});
	$(experienceWrapper).on("click", ".remove_experience_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	});

	/*add more for skills*/
	var max_skill_fields = 5; //maximum input boxes allowed
	var skill_wrapper = $(".skill_wrapper"); //Fields wrapper
	var add_skill_button = $(".add_skill_button"); //Add button ID
	var y = 1; //initlal text box count
	$(add_skill_button).click(function (e) { //on add input button click

		e.preventDefault();
		if (y < max_skill_fields) { //max input box allowed
			y++;
			$(skill_wrapper).append('<div class="col-md-12 input_skill_wrap item vertical-border"><label class="col-md-3 col-sm-3 col-xs-12" for="name"></label><div class="col-md-5 col-sm-12 col-xs-12 "><input type="text" name="skill_name[]" class="form-control col-md-7 skill_section" placeholder="Name" value=""></div><div class="col-md-3 col-sm-12 col-xs-12"><input type="number"  name="skill_count[]" class="form-control col-md-1 skill_section" placeholder="Count" value=""></div><button class="btn btn-danger remove_skill_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	});

	$(skill_wrapper).on("click", ".remove_skill_field", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		y--;
	});
	/*add more for images*/
var max_image_fields = 5; //maximum input boxes allowed
var image_wrapper = $(".image_wrapper"); //Fields wrapper
var add_images_button = $(".add_images_button"); //Add button ID
var y = 1; //initlal text box count
$(add_images_button).click(function (e) { //on add input button click

	e.preventDefault();
	if (y < max_image_fields) { //max input box allowed
		y++;
		$(image_wrapper).append('<div class="col-md-12 input_image_wrap item vertical-border"> <label class="col-md-3 col-sm-3 col-xs-12" for="name"></label><div class="col-md-6 col-sm-12 col-xs-12"><input type="file" class="form-control col-md-12 col-xs-12" name="doc_upload[]"></div><button class="btn btn-danger remove_image_field" type="button"><i class="fa fa-minus"></i></button></div>');
	}
});
$(image_wrapper).on("click", ".remove_image_field", function (e) { //user click on remove text
	e.preventDefault();
	$(this).parent('div').remove();
	y--;
});
}

function select2(material_type_id, logged_user) {
	$('.assets_name').attr('data-where', 'created_by_cid=' + logged_user + '  AND in_stock != 0');
	$('.assets_name').attr('data-id', 'assets_list');
	$('.assets_name').attr('data-key', 'id');
	$('.assets_name').attr('data-fieldname', 'ass_name');

}

function getSupervisorName(val){
	$.ajax({
		type: "POST",
		url: site_url + 'hrm/getManagerId',
		data: {
			id: val
		},
		success: function (data) {
			//alert(data);
	$('.supervisor').attr('data-where', 'id='+data+'  AND is_activated = 1');
	$('.supervisor').attr('data-id', 'user_detail');
	$('.supervisor').attr('data-key', 'id');
	$('.supervisor').attr('data-fieldname', 'name');
	  //$('#supervisor').val(data);
}
});
}
// Function to get tax of material
function getAssetsValue(evt, t) {
	var option = $(t).find('option:selected');
	var materialId = option.val();
	var closestId = $(t).closest(".well").attr("id");
	$.ajax({
		type: "POST",
		url: site_url + 'hrm/getAssetsDataById',
		data: {
			id: materialId
		},
		success: function (data) {
			if (data != '') {
				var dataObj = JSON.parse(data);
				parseFloat($("#" + closestId + " input[name='model_no[]'").val(dataObj.ass_model));
				parseFloat($("#" + closestId + " input[name='assets_code[]'").val(dataObj.ass_code));
				parseFloat($("#" + closestId + " input[name='assign_quantity[]'").val(dataObj.in_stock));
			}
		}
	});
}


function dateFunction() {
	$('#start_date1').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		endDate: 'today',

		autoclose: true
	});

	$('#end_date1').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});	
	$('#return_date1').datepicker({
		dateFormat: 'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});

	$('#salary_date').datepicker({
		dateFormat: 'mm-yyyy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d',
		autoclose: true
	});
}

/*/************************print in view****************************************/

  function Print_data_new(){
     
	/*	document.getElementById("btnPrint").onclick = function () {		*/
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


		/*	}	    */
	} 

/* For PipeLine Module Drag & Drop Functionality*/
/*
$(function () {
	 
	var kanbanCol = $('.panel-body');
	kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');
	var kanbanColCount = parseInt(kanbanCol.length);
	$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');
	var dragClass = $(".dragg");
	var dragSaleClass = $(".saleOrderPriority");

	var dragMachineClass = $(".machine_order_priority");

	 
	if (dragClass.hasClass('dragg')) {
	 
		draggableInit();
	}

	if (dragSaleClass.hasClass('saleOrderPriority')) {
	 
		draggableSaleOrderInit();
	 
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

 
});


function draggableInit() {
	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {
	 
		sourceId = $(this).parent().attr('id');
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
	 
	});
	$('.panel-body').bind('dragover', function (event) {
		event.preventDefault();
	});
	$('.panel-body').bind('drop', function (event) {
		var children = $(this).children();
		var targetId = children.attr('id');
	 
		var status = $('#status').val();
		if (status == 'New') {
			var url = 'hrm/changeProcessType2/';
		}
	 
	 
		if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
               // var div=$('.refresh').html();
				console.log("elementId->>", elementId);
				console.log("targetId->>", targetId);
				$.ajax({
					url: site_url + url,
					dataType: 'json',
					type: 'POST',
					data: {
						'processId': elementId,
						'processTypeId': targetId,
					},
					success: function (result) {		
						if (result.status == 'success') {
							window.location.href = result.url;
				
						}
					}
				});
			$('#processing-modal').modal('toggle'); //before post
		 
			if (targetId == 5 || targetId == 6 || targetId == 5) {
               $('.refresh').show();
			}else{
				 $('.refresh').hide();
			}
			setTimeout(function () {
				var element = document.getElementById(elementId);
				children.prepend(element);
				$('#processing-modal').modal('toggle'); // after post
				//	gettotal();
				$("#id").val(elementId);
				$('#comment').modal('toggle');
			}, 1000);
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
		url: site_url + 'hrm/changeOrder/',
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
 
	setTimeout(function () {
		var element = document.getElementById($(this).attr('id'));
		children.prepend(element);
		$('#processing-modal').modal('toggle'); // after post
	}, 1000);

}
*/var i = 1;

function add_row() {
	var str = '<tr><td class="sno">' + i + '</td><td><input type="text" width="100%" name="res[]"/></td><td><input type="text" width="100%" name="skills[]"/></td><td><input type="text" width="100%"  name="add_skills[]"/></td><td><button type="button" onClick="remove_row1(this);">X</button></td></tr>';
	i++;
	$('#example tbody').append(str);
	if ($('table tr').length > 1) {
		$(this).closest('tr').remove();
		$('td.sno').text(function (i) {
			return i + 1;
		});
	}
}

function remove_row1(clrt) {
	$(clrt).parents('tr').remove();
	if ($('table tr').length > 1) {
		$(this).closest('tr').remove();
		$('td.sno').text(function (i) {
			return i + 1;
		});
	}
}



/********************* approve dissaporve in job Position **********************/
$(document).on("click", ".validate_ta_da", function () {
	if (confirm('Are you sure!') == true) {
		var loggedinUser = $('#loggedInUserId').val();
		var id=$(this).data("id");
		$.ajax({
			type: "POST",
			url: site_url + 'hrm/approve_ta_da/',
			data: {
				id: id,
				approve: 1,
				approved_by: loggedinUser
			},
			success: function (result) {
				if (result != '') {
					//console.log("fff", result);
					//var obj = $.parseJSON(result);
					var obj = JSON.parse(result);
					if (obj.status == 'success') {
						location.reload();
					}
				}
			}
		});
	}
});

$(document).on("click", ".validate", function () {
	if (confirm('Are you sure!') == true) {
		var row = $(this).closest('tr');
		//$(this).closest('tr').find(".createPO").show();
		var loggedinUser = $('#loggedInUserId').val();
		var job_position_id = row.find("td.job_position_id:nth-child(1)").text();
		//alert(job_position_id);
		// console.log('Job id===>>>>>', job_position_id);
		$.ajax({
			type: "POST",
			url: site_url + 'hrm/approveJobPosition/',
			data: {
				id: job_position_id,
				approve: 1,
				validated_by: loggedinUser
			},
			success: function (result) {
				if (result != '') {
					//console.log("fff", result);
					//var obj = $.parseJSON(result);
					var obj = JSON.parse(result);
					if (obj.status == 'success') {
						location.reload();
					}
				}
			}
		});
	}
});
$(document).on("click", ".disapprove", function () {
	var row = $(this).closest('tr');

	var checkValues = $('.checkbox1:checked').map(function () {
		return $(this).val();
	}).get();

	$.each(checkValues, function (i, val) {
		$("#" + val).remove();
	});

	var job_position_id = row.find("td.job_position_id:nth-child(1)").text();
	if ($(".checkbox1").prop('checked') == true) {
		$(".disapproveReasonModal #job_position_id").val(checkValues);
	} else {

		$(".disapproveReasonModal #job_position_id").val(job_position_id);

	}

	var disapprove_reason = row.find("td .disapprove_reason").text();

	$(".disapproveReasonModal #disapprove_reason").text(disapprove_reason);
	$('.disapproveReasonModal').modal('show');
});
$(document).on("click", ".disapprove_ta_da", function () {
	var row = $(this).closest('tr');
	var id=$(this).data("id");
	var disapprove_reason = row.find("td .disapprove_reason").text();
    $('#id').val(id);
	$(".disapproveReasonModal #disapprove_reason").text(disapprove_reason);
	$('.disapproveReasonModal').modal('show');
});
	$(".validate_status").click(function(){
	 var cnfrm = confirm('Are you sure!');
	    if(cnfrm == true)
        {
           
			var row = $(this).closest('tr');
			var loggedinUser = $('#loggedInUserId').val();
			var approve_status = $(this).val();
			var travel_id = row.find("td.travel_id:nth-child(1)").text();
			$.ajax({
				type: "POST",
				url: site_url + 'hrm/approveStatusChange/',
				data: {
					id: travel_id,
					approve_status: approve_status,
					approve_by: loggedinUser
				},
				success: function (result) {
					if (result != '') {
						var obj = JSON.parse(result);
						if (obj.status == 'success') {
							location.reload();
						}
					}
				}
			});
        }
        else
	 	{
	 	 return false;
		}
	});
 	
$(".selectAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
	 //$('.order-actions').toggle();
 });

$('.selectAll23').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
});

$(document).ready(function () {
$("#probation_period").keyup(function(){
        var joining_date = $("#date_joining").val();
        var probation_period = $("#probation_period").val();
        var someDate = new Date(joining_date);
        someDate.setDate(someDate.getDate() + parseInt(probation_period)); 
        var dateFormated = someDate.toISOString().substr(0,10);
        $("#confirmation_date").val(dateFormated);
});
});
$(document).ready(function () {
 if(  $('#include_pf').prop('checked')     ){
                              $(".hide_if_no_pf").show();
        }
        if(  $('#include_esi').prop('checked')     ){
                             $(".hide_if_no_esi").show();
        }
        
});


$(document).on("click", "#include_pf", function () {
       if(  $('#include_pf').prop('checked')     ){
                              $(".hide_if_no_pf").show();
        } else {
                              $(".hide_if_no_pf").hide();
        }
        
       
});

$(document).on("click", "#bank_transfer", function () {
                              $(".hide_if_bank_transfer").show();
}); 

$(document).on("click", "#demand_draft", function () {
                              $(".hide_if_demand_draft").show();
}); 

$(document).on("click", "#include_esi", function () {
        if(  $('#include_esi').prop('checked')     ){
                             $(".hide_if_no_esi").show();
                             } else {
                             $(".hide_if_no_esi").hide();
        }
});

$('#cheque,#cash').click(function () {
      $(".hide_if_demand_draft").hide();
      $(".hide_if_bank_transfer").hide();
});


  
$(document).on("click", "#salary_calculate", function () { 
     
           /* var total_sal =    $("#total_sal").val();*/
            if( !$("#emp_id").val() ) {    
                 $("#show_err").text(" Please Select EmpID");  
               
            }
            if( !$("#salary").val() ) {    
                 $("#show_err").text("Please Select Emp Sal");  
            }
            if( !$("#salarySlab").val() ) {    
                 $("#show_err").text("Please Select Salary Slab");  
            }
           var total_sal =  $("#salary").val();
           var salary_slab =  $("#salarySlab").val();
            var emp_id =  $("#emp_id").val();
          
              	$.ajax({
				url: site_url + 'hrm/calculate_salary_slab/',
				type: "POST",
				data: {
					total_sal: total_sal,
					emp_id: emp_id,
					salary_slab: salary_slab
				},
				success: function (data) {
					if (data) {
					  var obj = JSON.parse(data);
					$('#salbedata').html(obj.html);
					//$('#chkIndex_'+div_len).find('.jobcard_product').html(data.html);
				     }
				    // var obj = JSON.parse(data);
				   
			     //             basic    =	  obj.basic; 
			     //             hra    =	  obj.hra; 
			     //             ca    =	  obj.ca; 
			     //             sa    =	  obj.sa; 
			     //             incentive  = obj.incentive; 
			     //             esic    =	  obj.esic; 
			     //             da    =	  obj.da; 
			     //             medical    = obj.medical; 
			     //             tds    =	  obj.tds; 
			                 
			                 
        //                     var basic     =  basic/100 * total_sal; 
        //                     var basic = basic.toFixed(2);
        //                     $("#basic").val(basic); 
                            
        //                     var hra     =  hra/100 * basic;
        //                     var hra = hra.toFixed(2);
        //                     $("#hra").val(hra);
                            
        //                     var ca     =  ca/100* basic;
        //                     var ca = ca.toFixed(2);
        //                     $("#ca").val(ca);
                            
        //                     var sa     =  sa/100* basic;
        //                     var sa = sa.toFixed(2);
        //                     $("#sa").val(sa);
                            
        //                     var incentive     =  incentive/100* basic;
        //                     var incentive = incentive.toFixed(2);
        //                     $("#incentive").val(incentive);
                            
        //                     var esic     =  esic/100* total_sal;
        //                     var esic = esic.toFixed(2);
        //                     $("#esic").val(esic);
                            
                            
        //                     var da     =  da/100* basic;
        //                     var da = da.toFixed(2);
        //                     $("#da").val(da);
                            
        //                     var medical     =  medical/100* basic;
        //                     var medical = medical.toFixed(2);
        //                     $("#medical").val(medical);
                            
                            
        //                     var tds     =  tds/100* total_sal;
        //                     var tds = tds.toFixed(2);
        //                     $("#tds").val(tds);

                    /*slab_structure*/
				}
			});
    
});


$(document).on("click", "#salary_refresh", function () { 
    
     var total_salary    = $("#total_sal").val();
        
        if(total_salary <  21000)
        {  $("#esic_div").show();
         $("#others_div").show();
         $("#tsd_div").hide();
         $("#medical_div").hide();
          
         $("#da_div").hide();    }else{ 
          $("#tsd_div").show();   
          $("#medical_div").show();   
          $("#da_div").show();   
          $("#others_div").hide();   
          $("#esic_div").hide();          
             
             
         } 
});

  
$(document).on('click', '.empData', function () {  
	var id=$(this).attr('id');
	var empWokingDays=$(this).attr('empWokingDays');
	var empWokingSalary=$(this).attr('empWokingSalary'); 
	var weekoff=$(this).attr('weekend'); 
	var grossPay=$(this).attr('grossPay'); 
	var totalLeave=$(this).attr('totalLeave'); 
	var oneDaysalary=$(this).attr('oneDaysalary'); 
     $.ajax({
				type: "POST",
				url: site_url + 'hrm/show_payroll_process_per_emp/',
				data: { 
				 id:id,empWokingDays:empWokingDays,empWokingSalary:empWokingSalary,
				 weekoff:weekoff,grossPay:grossPay,oneDaysalary:oneDaysalary,totalLeave:totalLeave
				},
				success: function (result) {
						$('#hrm_modal').modal('show');
			           $('#hrm_modal .modal-body-content').html(result);
				}
			}); 
});
$(document).on('click', '.workerviewAtt', function () {  
	var id=$(this).attr('id'); 
	var start=$(this).attr('start'); 
	var end=$(this).attr('end');
     $.ajax({
				type: "POST",
				url: site_url + 'hrm/workerDetails/',
				data: { 
				 id:id,start:start,end:end  
				},
				success: function (result) {
						$('#hrm_modal').modal('show');
			            $('#hrm_modal .modal-body-content').html(result);
				}
			}); 
});
$(document).on('click', '.empviewAtt', function () {  
	var id=$(this).attr('id'); 
	var start=$(this).attr('start'); 
	var end=$(this).attr('end');
     $.ajax({
				type: "POST",
				url: site_url + 'hrm/empDetails/',
				data: { 
				 id:id,start:start,end:end  
				},
				success: function (result) {
						$('#hrm_modal').modal('show');
			            $('#hrm_modal .modal-body-content').html(result);
				}
			}); 
});
$(document).on('click', '.workerDataView', function () {  
	var id=$(this).attr('id');
	var empWokingDays=$(this).attr('empWokingDays');
	var empWokingSalary=$(this).attr('empWokingSalary'); 
	var weekoff=$(this).attr('weekend'); 
	var grossPay=$(this).attr('grossPay'); 
	var totalLeave=$(this).attr('totalLeave'); 
	var oneDaysalary=$(this).attr('oneDaysalary'); 
    var otSalary=$(this).attr('otSalary');
    var monthYear=$(this).attr('monthYear');  
    $.ajax({
				type: "POST",
				url: site_url + 'hrm/workerSalarySlab/',
				data: { 
				 id:id,empWokingDays:empWokingDays,empWokingSalary:empWokingSalary,
				 weekoff:weekoff,grossPay:grossPay,oneDaysalary:oneDaysalary,totalLeave:totalLeave,otSalary:otSalary,monthYear:monthYear
				},
				success: function (result) {
						$('#hrm_modal').modal('show');
			            $('#hrm_modal .modal-body-content').html(result);
				}
			}); 
});
$(document).on('click', '.workerDataViewNormalSlab', function () {  
	var id=$(this).attr('id'); 
	var worker_id= $(this).attr('worker_id'); 
    $.ajax({
				type: "POST",
				url: site_url + 'hrm/workerSalarySlabNormal/',
				data: { 
				 id:id,worker_id:worker_id
				},
				success: function (result) {
						$('#hrm_modal').modal('show');
			            $('#hrm_modal .modal-body-content').html(result);
				}
			}); 
});

$(document).on('change', '.show_leave_data', function () {
         var leave_id= $("#leave_id").val();
         var emp_id= $("#emp_id").val();
         var created_by_cid =   $("input[name='created_by_cid']").val();
         
         $.ajax({
				type: "POST",
				url: site_url + 'hrm/get_emp_leave_balance/',
				data: {
					leave_id: leave_id,
					emp_id: emp_id,
					created_by_cid:created_by_cid,
				 
				},
				success: function (result) {
				         if(result >= 0)
				         {
				             $("#sub_btn1").show();
				         }else{
				             $("#sub_btn1").hide();
				         }
						 $("#show_leave").text(result);  
				}
			}); 
             
          
}); 
  
$(document).on('focus', '#leave_duration', function () {    
         
         var startdate= $("#startdate").val();
         var enddate= $("#enddate").val();
         var leave_id= $("#leave_id").val();
         var emp_id= $("#emp_id").val();
         var created_by_cid =   $("input[name='created_by_cid']").val();
         
         $.ajax({
				type: "POST",
				url: site_url + 'hrm/select_one_cl_only/',
				data: {
					leave_id: leave_id,
					emp_id: emp_id,
					created_by_cid:created_by_cid,
					startdate:startdate,
					enddate:enddate,
				 
				},
				success: function (res) {
				  /*  if(res == 1)
				    {
				     $('#sub_btn1').prop("disabled", true);
			         $("#show_cl_msg").text("Please Select Same Day.....");  
				    }
				    if(res == 2)
				    {
				    $('#sub_btn1').prop("disabled", true);
		   		    $("#show_cl_msg").text(" Please Select Any Other Leave ..... ");
				    }
				    if(res != 2 && res != 1 )
				   {
				    $('#sub_btn1').prop("disabled", false);
				   }*/
				}
			});
}); 

$(document).on('change', '#set_prod_dispatch_date,#atten_upload_id', function () {
    
   var single_attendance_upload = $("#set_prod_dispatch_date").val();
   var emp_id = $("#emp_id").val();
         $.ajax({
				type: "POST",
				url: site_url + 'hrm/attendance_weekoff_holiday_leave_check/',
				data: {
					date_id1: single_attendance_upload,
					emp_id: emp_id
				},
				success: function (response) {
				    var data = jQuery.parseJSON(response);
				    if(data.week_off > 0 )
				    {
				        $("#attendanceUpdate").hide(); 
				        $("#show_msg").show(); 
				        $("#show_atten_msg").text("Week Off "); 
				    }else  if(data.holiday_count > 0){
				        $("#attendanceUpdate").hide(); 
				        $("#show_msg").show(); 
				        $("#show_atten_msg").text("Holiday is there"); 
				    }else{
				         $("#attendanceUpdate").show(); 
				         $("#show_msg").hide(); 
				    }
				    // if(data.leave_check > 0)
				    // {
				    //     $("#attendanceUpdate").hide(); 
				    //     $("#show_msg").show(); 
				    //     $("#show_atten_msg").text("Emp on leave"); 
				    // }else 
				    
				}
			}); 
        }); 

$(document).on('change', '#atten_upload_id', function () {
   var bulk_attendance_upload = $("#atten_upload_id").val();
   var emp_id = "0";  
   
  /* alert(bulk_attendance_upload);
   alert(emp_id);*/
   
         $.ajax({
				type: "POST",
				url: site_url + 'hrm/attendance_weekoff_holiday_leave_check/',
				data: {
					date_id1: bulk_attendance_upload,
				    	emp_id: emp_id
				},
				success: function (response) {
				    var data = jQuery.parseJSON(response);
				    if(data.week_off > 0 )
				    {
				        $("#attendance_bulk_Update").hide(); 
				        $("#show_msg_bulk").show(); 
				        $("#show_atten_bulk_msg").text("Week Off "); 
				    }else if(data.leave_check > 0)
				    {
				        $("#attendance_bulk_Update").hide(); 
				        $("#show_msg_bulk").show(); 
				        $("#show_atten_bulk_msg").text("Emp on leave"); 
				    }else if(data.holiday_count > 0){
				        $("#attendance_bulk_Update").hide(); 
				        $("#show_msg_bulk").show(); 
				        $("#show_atten_bulk_msg").text("Holiday is there"); 
				    }else{
				         $("#attendance_bulk_Update").show(); 
				         $("#show_msg_bulk").hide(); 
				       
				    } 
				}
			}); 
        }); 

function leave_count()
{
         var days =   $("#days").val();
         var emp_id =   $("#emp_id").val();
         var leave_id =   $("#leave_id").val();
           $.ajax({
				type: "POST",
				url: site_url + 'hrm/check_no_of_leaves/',
				data: {
					emp_id: emp_id,
				    leave_id: leave_id
				},
				success: function (res) {
				    $("#days").val(res);
				}
			}); 
}
$(document).on("click", "#leave_update", function (){ 
    
        var days =   $("#days").val();
        var emp_id =   $("#emp_id").val();
        var leave_id =   $("#leave_id").val();
        
            $.ajax({
				type: "POST",
				url: site_url + 'hrm/leave_update/',
				data: {
					emp_id: emp_id,
				    leave_id: leave_id,
				    days: days
				},
				success: function (res) {
				  /*  $("#days").val(res);*/
				 location.reload();
				}
			});
        });
function submit_available_assets(){
	$('#available_assets').submit();
}	
function submit_notavailable_assets(){
	$('#notavailable_assets').submit();
}	
function submit_worker_active(){
	$('#assets_worker_active').submit();
}
function submit_worker_inactive(){
	$('#assets_worker_inactive').submit();
}
function submit_pending_payment(){
$('#pending_payment_frm').submit()
}
function submit_complete_payment(){
$('#complete_payment_frm').submit()
}
function submit_assigned_assets(){
$('#assigned_assets_frm').submit()
}
function submit_return_assets(){
$('#return_assets_frm').submit()
}
   
function add_class_view_users_sal(id)
 {
   if(id == '1')
   {
       
      
   }
   if(id == '0')
   {
       alert('0');
      
   }
 }

function get_repeatable_days(sel)
{
    if(sel.value == '1')
    {
         $("#repeating_days").css({"display": "block"});
    }
    
}
  
 var y = 1; //initlal text box count  
 var maxProcess = 25;
$(document).on('click', '#addMorefileds_worker', function () {
    	var logged_user = $('#loggedUser').val();	
       
      // alert(logged_user);
     var input_holder = $(".input_holder"); //Fields wrapper
     
       if (y < maxProcess) {
           y++;
                             $(input_holder).append('<div class="well scend-tr" id="chkIndex_' + y + '">  <div class="col-md-6 col-sm-6 col-xs-6 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="assigned_to_worker[]" data-id="worker" data-key="id" data-fieldname="name" data-where="created_by_cid='+ logged_user +' and active_inactive = 1" tabindex="-1" aria-hidden="true" id="material_type1"><option value="">Select Option</option></select> </div> <button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
                          // 6/2/2021   $(input_holder).append('<div class="well scend-tr" id="chkIndex_' + y + '"> <div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 add_material_cls materialTypeId requrid_class" required="required" name="assigned_to[]" data-id="material_type" data-key="id" data-fieldname="name" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true" id="material_type1"><option value="">Select Option</option></select> </div> <button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
                          //  $(input_holder).append('<div class="well scend-tr" id="chkIndex_' + y + '"><div class="col-md-4 col-sm-12 col-xs-12 form-group"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Process name" value=""></div><div class="col-md-8 col-sm-12 col-xs-12 form-group"><textarea style="border-right: 1px solid #c1c1c1 !important;" id="description" rows="1" placeholder="Description" class="form-control col-md-7 col-xs-12 description" name="description[]"></textarea></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');

       }
         $(input_holder).on("click", ".remve_field", function(e) { //user click on remove text
                        e.preventDefault();
                        $(this).parent('div').remove();
                        y--;
                    });
          //  init_select221();
			init_select2();
});



 var y = 1; //initlal text box count  
 var maxProcess = 25;
$(document).on('click', '#addMoreLead', function () {
    	var logged_user = $('#loggedUser').val();	
        var npdm=$('#form_npdm_setting').val();  
        var input_holder = $(".input_holder"); //Fields wrapper
              
       if (y < maxProcess) {  
           y++;
		             if(npdm==1)   {
		                    	$(input_holder).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-1 col-sm-12 col-xs-12 form-group"> <div class="col-md-12 col-sm-12 col-xs-12 form-group"><input id="name" class="form-control col-md-7 col-xs-12" value="" name="task_name[]" placeholder="Name" required="required" type="text" ></div></div><div class=" form-group col-md-2 col-xs-12"> <div class="col-md-12 col-sm-12 col-xs-12 form-group"><input  class="form-control col-md-7 col-xs-12" value="" name="description[]" placeholder="Description" type="text"></div></div><div class=" form-group col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible   select2 " required="required" name="pipeline_status[]" data-id="task_list_status" data-key="id" data-fieldname="name" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true""><option value="">Select Option</option></select> </div></div><div class=" form-group col-md-2 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input style=" border-right: 1px solid #c1c1c1 !important;" type="date"  name="start_date[]"  class="form-control col-md-7 col-xs-12" value=""  required="required"></div></div><div class=" form-group col-md-2 col-xs-12"><div class="col-sm-12 col-md-12 col-xs-12 form-group"><input type="date"  name="due_date[]" class="form-control col-md-7 col-xs-12" placeholder="Due Date" value=""> </div></div><div class=" form-group col-md-1 col-xs-12"><div class="col-sm-12 col-md-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible   select2 " required="required" name="npdm[]"  data-id="npdm" data-key="id" data-fieldname="product_name" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true""><option value="">Select Option</option></select></div></div><div class=" form-group col-md-1 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"><select id="' + y + '" class="form-control col-md-7 col-xs-12 change_repeation" name="repeat_task[]"> <option value="" disabled="" selected="">Choose option</option> <option value="1">Yes</option><option value="0">No</option></select></div></div><div class=" form-group col-md-1 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"><input disabled type="number" id="repeatation_days' + y + '"  name="repeatation_days[]" class="form-control col-md-7 col-xs-12" placeholder="Repeation Days" value=""> </div></div> <button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');

		             }  else{
		                    //	$(input_holder).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-1 col-sm-12 col-xs-12 form-group"> <div class="col-md-12 col-sm-12 col-xs-12 form-group"><input id="name" class="form-control col-md-7 col-xs-12" value="" name="task_name[]" placeholder="Name" required="required" type="text" ></div></div><div class=" form-group col-md-1 col-xs-12"> <div class="col-md-12 col-sm-12 col-xs-12 form-group"><input  class="form-control col-md-7 col-xs-12" value="" name="description[]" placeholder="Description" type="text"></div></div><div class=" form-group col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible   select2 " required="required" name="pipeline_status[]" data-id="task_list_status" data-key="id" data-fieldname="name" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true""><option value="">Select Option</option></select> </div></div><div class=" form-group col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input style=" border-right: 1px solid #c1c1c1 !important;" type="date"  name="start_date[]"  class="form-control col-md-7 col-xs-12" value=""  required="required"></div></div><div class=" form-group col-md-1 col-xs-12"><div class="col-sm-12 col-md-12 col-xs-12 form-group"><input type="date"  name="due_date[]" class="form-control col-md-7 col-xs-12" placeholder="Due Date" value=""> </div></div><div class=" form-group col-md-1 col-xs-12"><div class="col-sm-12 col-md-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible   select2 " required="required" name="npdm[]"  data-id="npdm" data-key="id" data-fieldname="product_name" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true""><option value="">Select Option</option></select>  </div></div><div class=" form-group col-md-1 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"><input type="text" id="attachment" name="attachment[]" class="form-control col-md-7 col-xs-12" placeholder="attachment" value=""> </div></div><div class=" form-group col-md-1 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"><select id="' + y + '" class="form-control col-md-7 col-xs-12 change_repeation" name="repeat_task[]"> <option value="" disabled="" selected="">Choose option</option> <option value="1">Yes</option><option value="0">No</option></select></div></div><div class=" form-group col-md-2 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"><input disabled type="number" id="repeatation_days' + y + '"  name="repeatation_days[]" class="form-control col-md-7 col-xs-12" placeholder="Repeation Days" value=""> </div></div><div class=" form-group col-md-2 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"> <select disabled id="repeatation_on_off'+ y +'" name="repeatation_on_off[]" class="form-control col-md-7 col-xs-12">  <option value="" disabled="" selected="">Choose option</option><option value="1">Yes</option> <option value="0">No</option> </select> </div></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		                    	$(input_holder).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-1 col-sm-12 col-xs-12 form-group"> <div class="col-md-12 col-sm-12 col-xs-12 form-group"><input id="name" class="form-control col-md-7 col-xs-12" value="" name="task_name[]" placeholder="Name" required="required" type="text" ></div></div><div class=" form-group col-md-2 col-xs-12"> <div class="col-md-12 col-sm-12 col-xs-12 form-group"><input  class="form-control col-md-7 col-xs-12" value="" name="description[]" placeholder="Description" type="text"></div></div><div class=" form-group col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible   select2 " required="required" name="pipeline_status[]" data-id="task_list_status" data-key="id" data-fieldname="name" data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true""><option value="">Select Option</option></select> </div></div><div class=" form-group col-md-2 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input style=" border-right: 1px solid #c1c1c1 !important;" type="date"  name="start_date[]"  class="form-control col-md-7 col-xs-12" value=""  required="required"></div></div><div class=" form-group col-md-2 col-xs-12"><div class="col-sm-12 col-md-12 col-xs-12 form-group"><input type="date"  name="due_date[]" class="form-control col-md-7 col-xs-12" placeholder="Due Date" value=""> </div></div><div class=" form-group col-md-1 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"><select id="' + y + '" class="form-control col-md-7 col-xs-12 change_repeation" name="repeat_task[]"> <option value="" disabled="" selected="">Choose option</option> <option value="1">Yes</option><option value="0">No</option></select></div></div><div class=" form-group col-md-1 col-xs-12"> <div class="col-sm-12 col-md-12 col-xs-12 form-group"><input disabled type="number" id="repeatation_days' + y + '"  name="repeatation_days[]" class="form-control col-md-7 col-xs-12" placeholder="Repeation Days" value=""> </div></div> <button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
		             }
 		                
       }
         $(input_holder).on("click", ".remve_field", function(e) { //user click on remove text
                        e.preventDefault();
                        $(this).parent('div').remove();
                        y--;
                    });
          //  init_select221();
			init_select2();
});



$(function () {
	var kanbanCol = $('.panel-body');
	kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');
	var kanbanColCount = parseInt(kanbanCol.length);
	$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');
	var dragClass = $(".dragg");
	if (dragClass.hasClass('dragg')) {
		console.log("dfdf7");
		draggableInit1();
		//draggableInit2();
	}
 
	$('.panel-heading').click(function () { 
 
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
});
 
$(function () {
	var kanbanCol = $('.panel-body');
	kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');
	var kanbanColCount = parseInt(kanbanCol.length);
	$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');
	var dragClass = $(".dragg2");
	if (dragClass.hasClass('dragg2')) {
		console.log("dfdf7");
	//	draggableInit1();
		draggableInit2();
	}
 
	$('.panel-heading').click(function () { 
 
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
});



 function draggableInit1() {
			var sourceId;
			$('[draggable=true]').bind('dragstart', function (event) {

			sourceId = $(this).parent().attr('id');
			event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));

			});
			$('.panel-body').bind('dragover', function (event) {
			event.preventDefault();
			});
			$('.panel-body').bind('drop', function (event) {
			var children = $(this).children();
			var targetId = children.attr('id');
			//console.log("targetid==>>", targetId);
			if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");

			$.ajax({
			url: site_url + 'hrm/changeProcessType2/',
			dataType: 'json',
			type: 'POST',
			data: {
			'processId': elementId,
			'processTypeId': targetId,
			},
			success: function (result) {
			if (result.status == 'success') {
			window.location.href = result.url;
			}
			}
			});
			$('#processing-modal').modal('toggle'); //before post
			setTimeout(function () {
				var element = document.getElementById(elementId);
				children.prepend(element);
				$('#processing-modal').modal('toggle'); // after post
			
			}, 1000);
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

function draggableInit2() {
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
	    console.log("before con==>>", 'dition_script');
	 
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
			console.log("sourceId->>", sourceId);
			console.log("elementId->>", elementId);
			console.log("targetid==>>", targetId);
     //	location.reload();
 
			$.ajax({
				url: site_url + 'hrm/get_transition_assignee/',
				dataType: 'json',
				type: 'POST',
				data: {
					'source_id' : sourceId,
					'target_id': targetId,
				},
				success: function (result) {		
			if(result==1){
				$.ajax({
				url: site_url + 'hrm/get_data_transition_tasklist/',
				dataType: 'json',
				type: 'POST',
				data: {
					'pipeline_id': sourceId,
					'target_id': targetId,
					'id': elementId,
					 
				},
				success: function (result) {

				}
			}); 
			$('#processing-modal').modal('toggle'); 
					setTimeout(function () {
						var element = document.getElementById(elementId);
						children.prepend(element);
						$('#processing-modal').modal('toggle'); //  
					location.reload();
					}, 1000);
			}else{
				alert('Permission Denied.Please Check Transition Authority');
				location.reload();
				}
			}
			}); 

	 
		 
	});
}

function testxx(id,val)
{
    var target = $('input[name="optradio"]').val();
    console.log(target);
    
 
}

 /*$('#save').click(function(){
   $.ajax({
     type: "POST",
     url: "post.php",
     data: $('#myform').serialize(),
     success: function(msg){
         console.log(msg);
     }
   });
});*/
   function sub_form(id) {
      
     
       
         $.ajax({
				url: site_url + 'hrm/set_transition_status/',
			     type: "POST",
		            data:{
		            "formData" : $('#form'+id).serialize()
		            },
				success: function (result) {
				 location.reload();
				}
			}); 
   }
 
 
     
 
 
 $(document).ready(function (e) {
	$(document).on("click", ".hrmTab2", function (ev) {
		ev.preventDefault();
		var id = $(this).attr('id');
		var sec_id = $(this).attr('sec-id');
		var tab = $(this).attr('data-id');
		var url = '';
		
	  
 
		switch (tab) {
     case 'transition_authority':
				url = 'hrm/load_transition_authority';
				break;	

		}

	  
	

		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {
				row_id: id,
				col_id:sec_id
			},
			success: function (data) {
			 
					$("#hrm_modal").modal({
						show: false,
						backdrop: 'static'
					});
					$('#hrm_modal').modal('show');
					$('#hrm_modal .modal-body-content').html(data);
                     init_select2();
			}
		});
			

});

 var y = 1; //initlal text box count  
 var maxProcess = 25;
$(document).on('click', '#addMorefiledstransition_role', function () {
    	var logged_user = $('#loggedUser').val();	
       
     
     var input_holder = $(".input_holder"); //Fields wrapper
     
       if (y < maxProcess) {
           y++;
                             $(input_holder).append('<div class="well scend-tr" id="chkIndex_' + y + '"> <div class="col-md-6 col-sm-6 col-xs-6 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible   select2" required="required" name="role[]" data-id="task_list_role" data-key="id" data-fieldname="name"  data-where="created_by_cid='+ logged_user +' OR created_by_cid=0" tabindex="-1" aria-hidden="true" ><option value="">Select Option</option></select> </div> <button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
                        
       }
         $(input_holder).on("click", ".remve_field", function(e) { //user click on remove text
                        e.preventDefault();
                        $(this).parent('div').remove();
                        y--;
                    });
           // init_select221();
			init_select2();
});

 





 $(".resendbtn").click(function(){  
		var id = $(this).attr("data-id");
		var email = $(this).attr("data-email");
		$.ajax({
			url: site_url + 'hrm/reverify/',
			dataType: 'json',
			type: 'POST',
			data: {
				'id': id,
				'email': email,
			},
			success: function (data) {
				if (data == true) {
					location.reload();
				}
			}
	});
});
 /** Task List Work Start here **/
 
 
 $(document).on("change",".change_status_supervisorworker",function(){ 
		if($(this).prop("checked") == true){
		 $('#workerSupervisor_setting').val('1');
	    }else{
		    $('#workerSupervisor_setting').val('0');
		}
		setTimeout(function(){	
			$('#change_status_supervisorworker1').submit();
		}, 1000);
});

 $(document).on("change",".change_status_workerdata",function(){ 
		if($(this).prop("checked") == true){
		 $('#hrm_worker_data').val('1');
	    }else{
		    $('#hrm_worker_data').val('0');
		}
		setTimeout(function(){	
			$('#change_status_workerdata').submit();
		}, 1000);
});

/*06/25/2021*/

 $(document).on("change",".change_repeation",function(){ 
    var id;
    
          id = $(this).attr('id');
          value = $(this).val();
        
        if(value == 1)
        {
            
            $( "#repeatation_days"+id ).prop( "disabled", false );
            $( "#repeatation_on_off"+id ).prop( "disabled", false );
        }
        if(value == 0)
        {
          
            $( "#repeatation_days"+id ).prop( "disabled", true );
            $( "#repeatation_on_off"+id ).prop( "disabled", true );
        }
            
           /*   
              1
                1*/
         
   
});

  $(document).on("change",".change_status_npdmworker",function(){ 
		if($(this).prop("checked") == true){
		 $('#npdm_setting').val('1');
	    }else{
		    $('#npdm_setting').val('0');
		}
		setTimeout(function(){	
			$('#npdm_setting').submit();
		}, 1000);
});


//Sync Transition
$("#transition").on("click", function(){
	//alert();
   window.location.href="insert_data_transition_table";
});
/*06/25/2021*/

 
});

// AS 25-08
$(document).on("change",".change_status_npdmworker",function(){ 
		if($(this).prop("checked") == true){
		 $('#npdm_setting').val('1');
	    }else{
		    $('#npdm_setting').val('0');
		}
		setTimeout(function(){	
			$('#npdm_setting').submit();
		}, 1000);
});
 
  $(document).on("change","#enddate",function(){    

   var start = $('#startdate').val(); 
     var end = $('#enddate').val();  
    if (start==end){
    	var totalhrs=8; 
       $('#leave_duration').val(totalhrs);
    }else{
     var startDay = new Date(start);
     var endDay = new Date(end);
    var millisecondsPerDay = 1000 * 60 * 60 * 24;
   
    var millisBetween = endDay.getTime() - startDay.getTime();
    var days = millisBetween / millisecondsPerDay;
       var day=days+1;
       var totalhrs=day*8;
      // Round down.
        $('#leave_duration').val(totalhrs);
      //alert( Math.floor(day));
   }
});

function getDept(evt, t) {
    $('.department').empty('');
   // alert("fff");
    var logged_user = $('#loggedUser').val();
    if (window.location.href == site_url + 'production/production_planning') {
        $(".app_div_planing").html(''); 
    //  $(".app_div_planing_similar").html('');
    } else if (window.location.href == site_url + 'production/production_data') {
        $(".app_div").html('');
    }
    var selected_unit_name = $(t).find('option:selected').val();
    $('.department').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + selected_unit_name + '"');
    $('.department').attr('data-id', 'department');
    $('.department').attr('data-key', 'id');
    $('.department').attr('data-fieldname', 'name');
}

 
     
 $(document).on("change",".department",function(){    
        var company_unit = $('#compny_unit option:selected').val();
        var department = $('#department option:selected').val();
     
        $.ajax({
            type: "POST",
            url: site_url + 'production/getShiftAccrdngToDept/',
            data: {
                company_unit: company_unit,
                department: department
            },
            success: function(result1) {
 
                //setTimeout(function () {
                if (result1 == 'gg') {
                    $('.radio_button').empty();
                    $('.radio_edit').css("display", "none");
                    $('.Displaymessage').css('display', 'block');
                    $('.Displaymessage').append("Please Select Shift From Production Setting");
                    $('.date').datepicker("option", "disabled", true);
                    $('.disablesubmitBtn').attr("disabled", true);
                    setTimeout(function() {
                        $('.Displaymessage').fadeOut('1000').empty();
                        $('.Displaymessage').empty('');
                    }, 1000);
                } else {
                    var obj = JSON.parse(result1);
                    var radio_html = '';
                    $('.radio_button').empty();
                    var len = obj.length;
                    $('.radio_edit').css("display", "none");

                    for (var i = 0; i < len; i++) {
                        var idd = obj[i].id;
                        var shift_namee = obj[i].shift_name;
                        var sel_data = '<input type="radio" class="flat" name="shift_id" value="' + idd + '" checked = checked[0] >' + shift_namee + ' ';
                        $('.radio_button').append(sel_data);
                        $('.date').datepicker("option", "disabled", false);
                        $('.disablesubmitBtn').attr("disabled", false);
                    }
                }
            }
        });
    });
 
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});




/* For Export Users */



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
				case 'exportToPDF' :
				  $('#export-PDFform').submit();
				break
            }

        });




$(document).on('click','.onOffStatus',function(){
    var checked = 0;
    if( $(this).is(":checked") ){
      checked = 1;
    }
 
    var table = $(this).attr('data-tbl');
    var where = $(this).attr('data-where');
    var column = $(this).attr('name');
    var value  = checked;
    var msg    = "";
    if( typeof $(this).attr('data-msg') != 'undefined' ){
        msg = $(this).attr('data-msg');
    } 
    $.ajax({
      url:`${site_url}hrm/onOffStatusUpdate`,
      method:"POST",
      data:{value:value,table:table,where:where,column:column,msg:msg},
      error:(error) => console.log(error),
      success:(data) => {
          if(data){
            data = JSON.parse(data);
            if( data.refresh ){
              location.reload();
            }
          }
      }

    });
});
$(document).on('click','.submitInputValue',function(){

    var table = $(this).closest('.inputFieldArea').find('input').attr('data-tbl');
    var where = $(this).closest('.inputFieldArea').find('input').attr('data-where');
    var column = $(this).closest('.inputFieldArea').find('input').attr('name');
    var value  = $(this).closest('.inputFieldArea').find('input').val();

    $.ajax({
      url:`${site_url}hrm/updateSingleValue`,
      method:"POST",
      data:{value:value,table:table,where:where,column:column},
      error:(error) => console.log(error),
      success:(data) => {
          if(data){
            data = JSON.parse(data);
            if( data.refresh ){
              location.reload();
            }
          }
      }

    });
});

// $(document).on('keyup','#basic',function(){
// alert();
//     // var table = $(this).closest('.inputFieldArea').find('input').attr('data-tbl');
//     // var where = $(this).closest('.inputFieldArea').find('input').attr('data-where');
//     // var column = $(this).closest('.inputFieldArea').find('input').attr('name');
//     // var value  = $(this).closest('.inputFieldArea').find('input').val();

//     // $.ajax({
//     //   url:`${site_url}hrm/updateSingleValue`,
//     //   method:"POST",
//     //   data:{value:value,table:table,where:where,column:column},
//     //   error:(error) => console.log(error),
//     //   success:(data) => {
//     //       if(data){
//     //         data = JSON.parse(data);
//     //         if( data.refresh ){
//     //           location.reload();
//     //         }
//     //       }
//     //   }

//     // });
// });
 

function checkcharges(){
    var basic=$('#basic').val();
	var hra=$('#hra').val();
	var ca=$('#ca').val();
	var da=$('#da').val();
	var sa=$('#sa').val(); 
	var medical=$('#medical').val();
	var other=$('#others').val();
 
//	var esic=$('#esic').val();
//	var tds=$('#tds').val();
		//alert(basic);
	if(basic!=''&& hra!='' && ca!='' && da!='' && sa!=''   && medical!=''&& other!=''){ 
		Total=(parseFloat(basic)+parseFloat(hra)+parseFloat(ca)+parseFloat(da)+parseFloat(sa)+ parseFloat(medical)+parseFloat(other));
	   
		if(Total==100){
			  $('.save').removeAttr("disabled");
		}else if(Total<100){
			 alert("Total Charges must be 100%");
			  $('.save').prop("disabled", true);
		}else if(Total>100){
			 alert("Total Charges must be 100%");
			  $('.save').prop("disabled", true);
		}
	}
}
 
$(document).on('change','.statusChange',function(){
     var valueAP = $('.statusChange option:selected').val();   
     if (valueAP == 'P') {
     	$('.signInOut').show(); 
     } else if(valueAP == 'A'){
        $('.signInOut').hide(); 
     }
});
 
j = 0;
$(document).on('keyup','#adharNo',function(){
      j += 1;  
   if(parseInt(j)=='12'){
   	  var hy="Invalid Aadhaar Number"; 
   	   $(".msgOnAAdhar").html(hy); 
   }else if (parseInt(j)<='12')  {
   	var hy='';
   	 $(".msgOnAAdhar").html(hy);
   }

});
$(document).on('keyup','#adharNo',function(){
    var aadhar= $('#adharNo').val();
 $.ajax({
      url:`${site_url}hrm/checkAadharNo`,
      method:"POST",
      data:{aadhar:aadhar},
      error:(error) => console.log(error),
      success:(data) => {
           if(data==2){
          	 
          }else if(data==1){ 
            var  html = `This User Aadhar Already `;
          
	        $(".msgOnAAdhar").html(html); 
          } 
      }

    });
});
$(document).on('keyup','#panNo',function(){
    var panNo= $('#panNo').val();

 $.ajax({
      url:`${site_url}hrm/checkPanNo`,
      method:"POST",
      data:{panNo:panNo},
      error:(error) => console.log(error),
      success:(data) => {
           if(data==2){
          	 
          }else if(data==1){ 
            var  html = `This User Aadhar Already `;
          
	        $(".msgOnPan").html(html); 
          } 
      }

    });
});
$(document).on('click','.addmoreinfoWorker',function(){

	var salar=$('#salary').val();
     if (salar!='') { 
        $('#exampleModalCenter').modal('show');
        $('#salaryOne').val(salar);
        $('.addToggle').addClass('shiladu');
        checkchargesworker();
	}else{ 
		$('.msgclass').html('Please Add Salary');
	}
  
});
$(document).on("click",".CloseModel",function(){
 setTimeout(function(){
	   $("body").addClass("modal-open");
   }, 1000);

	   $('.addToggle').removeClass('shiladu');
    $('#exampleModalCenter').modal('hide');
 });
function checkchargesworker(){
	var SalaryOne=$('#salaryOne').val();
    var basic=$('#basicOne').val();
	var hra=$('#hraOne').val();
	var ca=$('#caOne').val();
	var da=$('#daOne').val();
	var sa=$('#saOne').val(); 
	var medical=$('#medicalOne').val();
	var other=$('#othersOne').val();
 
	if(basic!=''&& hra!='' && ca!='' && da!='' && sa!=''  && medical!=''&& other!=''){ 
		Total=(parseFloat(basic)+parseFloat(hra)+parseFloat(ca)+parseFloat(da)+parseFloat(sa)+ parseFloat(medical)+parseFloat(other));
	   
		if(Total==SalaryOne){
			  $('.saveSlab').removeAttr("disabled");
		}else if(Total<SalaryOne){
			 alert("Total Charges must be "+SalaryOne);
			  $('.saveSlab').prop("disabled", true);
		}else if(Total>100){
			 alert("Total Charges must be " +SalaryOne);
			  $('.saveSlab').prop("disabled", true);
		}
	}
}
$(document).on('click','.updateforWorker',function(){
	var salar=$('#salary').val();
	var basic= $('#basic').val();
	var hra= $('#hra').val();
	var ca= $('#ca').val();
	var da= $('#da').val();
	var sa= $('#sa').val(); 
	var medical= $('#medical').val();
	var others= $('#others').val();
	var esic= $('#esic').val();
	var tds= $('#tds').val(); 
	var pf= $('#pf').val();
	var lwf= $('#lwf').val();
	var esic_employer= $('#esic_employer').val(); 
	var pf_employer= $('#pf_employer').val();
	var lwf_employer= $('#lwf_employer').val();
	var salarySlab= $('#salarySlab').val();
     if (salar!='') { 
     	$('.addToggle').addClass('shiladu');
        $('#exampleModalCenter').modal('show');
        checkchargesworker();
        $('#salaryOne').val(salar); 
	    $('#basicOne').val(basic);
		$('#hraOne').val(hra);
		$('#caOne').val(ca);
		$('#daOne').val(da);
		$('#saOne').val(sa); 
		$('#medicalOne').val(medical);
	    $('#othersOne').val(others);	
	    $('#esicOne').val(esic);
		$('#tdsOne').val(tds); 
		$('#pfOne').val(pf);
		$('#lwfOne').val(lwf);
		$('#esic_employerOne').val(esic_employer); 
		$('#pf_employerOne').val(pf_employer);
		$('#lwf_employerOne').val(lwf_employer);
    }else{ 
		$('.msgclass').html('Please Add Salary');
	}
  
});
$(document).on('click','.saveSlab',function(){

	var SalaryOne=$('#salaryOne').val();
    var basic=$('#basicOne').val();
	var hra=$('#hraOne').val();
	var ca=$('#caOne').val();
	var da=$('#daOne').val();
	var sa=$('#saOne').val(); 
	var medical=$('#medicalOne').val();
    var other=$('#othersOne').val();	
    var esicOne=$('#esicOne').val();
	var tdsOne=$('#tdsOne').val(); 
	var pfOne=$('#pfOne').val();
	var lwfOne=$('#lwfOne').val();
	var esic_employerOne=$('#esic_employerOne').val(); 
	var pf_employerOne=$('#pf_employerOne').val();
	var lwf_employerOne=$('#lwf_employerOne').val();
	var salarySlab=$('#salarySlabPer').val();
   $('#basic').val(basic);
	 $('#hra').val(hra);
	 $('#ca').val(ca);
	 $('#da').val(da);
	 $('#sa').val(sa); 
	 $('#medical').val(medical);
	 $('#others').val(other);
	 $('#esic').val(esicOne);
	 $('#tds').val(tdsOne); 
	 $('#pf').val(pfOne);
	 $('#lwf').val(lwfOne);
	 $('#esic_employer').val(esic_employerOne); 
	 $('#pf_employer').val(pf_employerOne);
	 $('#lwf_employer').val(lwf_employerOne);
	 $('#salarySlab').val(salarySlab);
	 setTimeout(function(){
	 $('.addToggle').addClass('shiladu');
	   $("body").addClass("modal-open");
   }, 1000);
    $('#exampleModalCenter').modal('hide');
 
  
});
 
 function checkchargesworkerSlab(){
	var SalaryOne=$('#empWokingSalary').val();
    var basic=$('#basic').val();
	var hra=$('#hra').val();
	var ca=$('#ca').val();
	var da=$('#da').val();
	var sa=$('#sa').val(); 
	var medical=$('#medical').val();
	var other=$('#others').val();
    var employee_esi= $('#employee_esi').val();
	var employee_tds= $('#employee_tds').val(); 
	var employee_pf= $('#employee_pf').val();
	var employee_lwf= $('#employee_lwf').val();
	var employer_esi= $('#employer_esi').val(); 
	var employer_pf= $('#employer_pf').val();
	var employer_lwf= $('#employer_lwf').val(); 
	var totaldid=(parseFloat(employee_esi)+parseFloat(employee_tds)+parseFloat(employee_pf)+parseFloat(employee_lwf));     
    totalemployee=parseFloat(SalaryOne)-parseFloat(totaldid);
    $('#netpay').val(totalemployee);
    $('#netpay2').html(totalemployee);
    var totalemployer=(parseFloat(employer_esi)+parseFloat(employer_pf)+parseFloat(employer_lwf));   
    $('#employerdeduction').val(totalemployer);
	if(basic!=''&& hra!='' && ca!='' && da!='' && sa!=''  && medical!=''&& other!=''){ 
		Total=(parseFloat(basic)+parseFloat(hra)+parseFloat(ca)+parseFloat(da)+parseFloat(sa)+ parseFloat(medical)+parseFloat(other));
	   $('#totalGr').val(Total);
		if(Total==SalaryOne){
			  $('.saveSlab').removeAttr("disabled");
		}else if(Total<SalaryOne){
			 alert("Total Charges must be " +SalaryOne);
			  $('.saveSlab').prop("disabled", true);
		}else if(Total>100){
			 alert("Total Charges must be " +SalaryOne);
			  $('.saveSlab').prop("disabled", true);
		}
	}

}
 
// $(document).on('change','#set_prod_dispatch_date',function(){
//      var date = $(this).val(); 
//     var username = $('#emp_id').val(); 

//     $.ajax({
//       url:`${site_url}hrm/checkLeave`,
//       method:"POST",
//       data:{emid:username,attdate:date},
//       error:(error) => console.log(error),
//       success:(data) => {
//            if(data==2){
//           	$("#attendanceUpdate").show(); 
// 	        $("#show_msg").hide(); 
//           }else{
//             data1 = JSON.parse(data); 
//             var  html = `This User Already on leave  ${data1.start_date} To  ${data1.end_date}`;
//             $("#attendanceUpdate").hide(); 
// 	        $("#show_msg").show(); 
// 	        $("#show_atten_msg").html(html); 
//           } 
//       }

//     });
// });

// $(document).on('change','.mydatetimepickerFull',function(){
//      var date = $(this).val(); 
//     var username = $('#workerid').val();  
//     $.ajax({
//       url:`${site_url}hrm/checkWorkerLeave`,
//       method:"POST",
//       data:{emid:username,attdate:date},
//       error:(error) => console.log(error),
//       success:(data) => {
//            if(data==2){
//           	$("#attendanceUpdate").show(); 
// 	        $("#show_msg").hide(); 
//           }else{
//             data1 = JSON.parse(data); 
//             var  html = `This User Already on leave  ${data1.start_date} To  ${data1.end_date}`;
//             $("#attendanceUpdate").hide(); 
// 	        $("#show_msg").show(); 
// 	        $("#show_atten_msg").html(html); 
//           } 
//       }

//     });
// });


/* rotatable_shift_setting process code start*/
$(document).ready(function () {
	resetcheckboxEmp();
	resetcheckboxWorker();
	$('#selecctallEmp').click(function (event) { //on click
		if (this.checked) { // check select status
			$('.checkboxEmp').each(function () { //loop through each checkbox
				this.checked = true; //select all checkboxes with class "checkbox1"
			});
		} else {
			$('.checkboxEmp').each(function () { //loop through each checkbox
				this.checked = false; //deselect all checkboxes with class "checkbox1"
			});
		}
	});
   	$('#selecctallWorker').click(function (event) { //on click
		if (this.checked) { // check select status
			$('.checkboxWorker').each(function () { //loop through each checkbox
				this.checked = true; //select all checkboxes with class "checkbox1"
			});
		} else {
			$('.checkboxWorker').each(function () { //loop through each checkbox
				this.checked = false; //deselect all checkboxes with class "checkbox1"
			});
		}
	});
 	function resetcheckboxEmp() {
		$('.checkboxEmp').each(function () { //loop through each checkbox
			this.checked = false; //deselect all checkboxes with class "checkbox1"
		});
	}
	function resetcheckboxWorker() {
		$('.checkboxWorker').each(function () { //loop through each checkbox
			this.checked = false; //deselect all checkboxes with class "checkbox1"
		});
	}


});

function getDeptWorker(evt, t) {

    $('.departmentWorker').empty('');
   // alert("fff");
    var logged_user = $('#loggedUser').val();
    if (window.location.href == site_url + 'production/production_planning') {
        $(".app_div_planing").html(''); 
    //  $(".app_div_planing_similar").html('');
    } else if (window.location.href == site_url + 'production/production_data') {
        $(".app_div").html('');
    }
    var selected_unit_name = $(t).find('option:selected').val();
    $('.departmentWorker').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + selected_unit_name + '"');
    $('.departmentWorker').attr('data-id', 'department');
    $('.departmentWorker').attr('data-key', 'id');
    $('.departmentWorker').attr('data-fieldname', 'name');
}

 
     
 $(document).on("change",".departmentWorker",function(){    
        var company_unit = $('#compny_unitWorker option:selected').val();
        var department = $('#departmentWorker option:selected').val();
     
        $.ajax({
            type: "POST",
            url: site_url + 'production/getShiftAccrdngToDept/',
            data: {
                company_unit: company_unit,
                department: department
            },
            success: function(result) { 
                //setTimeout(function () {
                if (result == 'gg') {
                    $('.radio_buttonWorker').empty();
                    $('.radio_editWorker').css("display", "none");
                    $('.DisplaymessageWorker').css('display', 'block');
                    $('.DisplaymessageWorker').append("Please Select Shift From Production Setting");
                    $('.dateWorker').datepicker("option", "disabled", true);
                    $('.disablesubmitBtnWorker').attr("disabled", true);
                    setTimeout(function() {
                        $('.DisplaymessageWorker').fadeOut('1000').empty();
                        $('.DisplaymessageWorker').empty('');
                    }, 1000);
                } else {
                    var obj = JSON.parse(result);
                    var radio_html = '';
                    $('.radio_buttonWorker').empty();
                    var len = obj.length;
                    $('.radio_editWorker').css("display", "none");

                    for (var i = 0; i < len; i++) {
                        var idd = obj[i].id;
                        var shift_namee = obj[i].shift_name;
                        var sel_data = '<input type="radio" class="flat" name="shift_id" value="' + idd + '" checked = checked[0] >' + shift_namee + ' ';
                        $('.radio_buttonWorker').append(sel_data);
                        $('.date').datepicker("option", "disabled", false);
                        $('.disablesubmitBtnWorker').attr("disabled", false);
                    }
                }
            }
        });
    });
 

/* rotatable_shift_setting process code end*/
$(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#employeeShiftChange thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#employeeShiftChange thead');
 
    var table = $('#employeeShiftChange').DataTable({
        orderCellsTop: true,
        fixedHeader: true,        
        paging: false,
        initComplete: function () { 
 
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    if(colIdx==1 || colIdx==2|| colIdx==3){
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                     }
                });
        },
    });
});

 

$(document).ready(function () {
 
   // Setup - add a text input to each footer cell
    $('#workerShiftChange thead tr')
        .clone(true)
        .addClass('filtersWorker')
        .appendTo('#workerShiftChange thead');
  
    var table = $('#workerShiftChange').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
       // searching: false,
        paging: false,

        initComplete: function () {
            var api = this.api();
     
            // For each column
            api
                .columns()
                .eq(0) 
                .each(function (colIdx) { 
                   // Set the header cell to contain the input element
                   if(colIdx==1 || colIdx==2 || colIdx==3 ){
                    var cell = $('.filtersWorker th').eq(
                        $(api.column(colIdx).header()).index()
                    );

                    var title = $(cell).text();
                    if(title=='Employee Name' || title=='Employee ID'|| title=='Employee Biometric Id'){ 
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
                   // On every keypress in this input
                    }
                    $(	
                        'input',
                        $('.filtersWorker th').eq($(api.column(colIdx).header()).index())
                     )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                     }
                });
        },
    });
});



