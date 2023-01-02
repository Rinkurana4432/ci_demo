if( localStorage.getItem('activeTab') == "#Complete_content_tab" ){
		$('.print_clsss').attr('id','bbtn22');
		$(`#export-form input[name='tab']`).val('complete');
	}else if(localStorage.getItem('activeTab') == "#purchase_budget_limit" ){
		$('.print_clsss').attr('id','bbtn22');
	}else{
		$('.print_clsss').attr('id','bbtn');
	}

$(window).load(function(){
	setTimeout(function(){
		var permission_check = ($("#check_add_permissions").length > 0)?$("#check_add_permissions").val():'0-0';
		if(permission_check.split('-')[0] == 0){
			if($(".toolbar").text() == 'Add') {
				$(".toolbar").remove();
			}
		}
		if(permission_check.split('-')[1] == 0){
			if($(".sales_detail_view").length > 0){
				$(".sales_detail_view").attr("href","#");
				$(".sales_detail_view").removeClass("sales_detail_view");
			}
		}
	}, 500);
});

/* Form submit with page redirection*/
function submit_handler(form_id = ''){
	$(document).ready(function(){
	 $('#'+form_id).on('submit', function(e){
		//$(document).on("submit","form#"+form_id,function(e){
			e.preventDefault();
			//if(validateForm(form_id) == false) { return false;}
			var data = new FormData(this);
			var ajax_url = $(this).attr('action');
			console.log('ajax_url===>>>',ajax_url);
			$.ajax({
				url: ajax_url,
				data: data,
				type: 'post',
				contentType: false, //this is requireded please see answers above
				processData: false, //this is requireded please see answers above
				beforeSend: function(){
					$('#' + form_id + ' input[type="submit"]').fadeOut('slow');
					$('#' + form_id + ' .msg_box').html('Please wait while we save your information...');
				},
				success: function(result){
					$('#' + form_id + ' input[type="submit"]').fadeIn('slow');
					var obj = $.parseJSON(result);
					if(obj.status == 'error') {
						$('#' + form_id + ' .ln_solid').html(obj.msg);
					}
					if(obj.status == 'success') {
						window.location.href = obj.url;
					}
				}
			});
		});
	});
}

/* Form submit (Modal)*/
function submit_handler_modal_frm(form_id = ''){
	$(document).ready(function(){
		$(document).on("submit","form#"+form_id,function(e){
			e.preventDefault();
			//if(validateForm(form_id) == false) { return false;}
			var data = new FormData(this);
			var ajax_url = $(this).attr('action');
			var currenrtmodal = $(this).closest(".modal");
			var currenrttbl = $('#' + form_id + ' #table_id').val();
			var reload_page = ($('#reload_page').length > 0)?$(' #reload_page').val():'false';

			console.log("reload_page - "+reload_page);
			$.ajax({
				url: ajax_url,
				data: data,
				type: 'post',
				contentType: false, //this is requireded please see answers above
				processData: false, //this is requireded please see answers above
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
						if(reload_page) {
							window.location.href = window.location.href;
						}
						currenrtmodal.modal('toggle');
						$('#'+currenrttbl).DataTable().ajax.reload();
						   var alertError = '<div id="alert_float_1" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-success alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title">' + obj.msg + '</span></div>';
						   $('.page-title').append(alertError);
						   setTimeout(function() {
								$('#alert_float_1').remove();
							}, 500000);
				  	   }  else {
						   var alertError = '<div id="alert_float_1" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-warning alert alert-error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title">'+obj.msg+ ' - '+'('+obj.status+obj.code+')</span></div>';
						   $('.page-title').append(alertError);
						   setTimeout(function() {
								$('#alert_float_1').remove();
							}, 500000);
					   }

				}
			});
		});
	});
}

/* Function to validate form rules */
function validate_form_rules(frmId , fields_rules = '{}'){
	/*$("#"+frmId).validate({
		focusInvalid: true,
		ignore: "",
		rules: fields_rules
		//invalidHandler: function (event, validator) {
       // },
		errorPlacement: function (error, element) {
			var icon = $(element).parent('.input-with-icon').children('i');
			var parent = $(element).parent('.input-with-icon');
			icon.removeClass('fa fa-check').addClass('fa fa-exclamation');
			parent.removeClass('success-control').addClass('error-control');
			$('<span class="error"></span>').insertAfter(element).append(error);
		},

		highlight: function (element) {
			var parent = $(element).parent();
			parent.removeClass('success-control').addClass('error-control');
		},
		success: function (label, element) {
			var icon = $(element).parent('.input-with-icon').children('i');
			var parent = $(element).parent('.input-with-icon');
			icon.removeClass("fa fa-exclamation").addClass('fa fa-check');
			parent.removeClass('error-control').addClass('success-control');
		},
	});	*/
}


















/* Function to Open Sales Detail View */
function show_detail_view() {
	var currentUrl = window.location.href;
	var IDarray;
	var clickId;
	if( currentUrl.indexOf('#') != -1 ){
		IDarray = currentUrl.split('#');
		clickId = IDarray[IDarray.length - 1];
	}
	if(clickId) {
		$("#row_"+clickId).find(".sales_detail_view").click();
		//fetch_detail_view(clickId);
	}
}

search_address = '';
function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

$(document).ready(function (e){
		$(document).on("click",".delete_listing",function(){
			if(confirm('Are you sure!') == true) {
				//window.location = $(this).attr('data-href');
				$.ajax({
				   type: "POST",
				   url: $(this).attr('data-href'),
				   context:this,
				   data: {},
				   success: function(data) {
					   if(data != '') {
						var obj = $.parseJSON(data);
						   if(obj.status == 'success') {

	                             /*   var alertError = '<div id="alert_float_1" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-success alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title"> ' +obj.msg+ '</span></div>';
								   $('.page-title').append(alertError);
								   setTimeout(function() {
										$('#alert_float_1').remove();
									}, 500000);
									closestr.remove(); */
									if( obj.url == '' ){
										$(this).parent().parent().parent().remove();
									}else{
										window.location.href = obj.url;
									}
	                              //
							 	  /* location.reload(); */
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

	$(document).on("click",".delete_listing_without",function(){
		if(confirm('Are you sure!') == true) {
			var closestr = $(this).closest("tr");
			$.ajax({
			   type: "POST",
			   url: $(this).attr('data-href'),
			   data: {},
			   success: function(data){
				   if(data != '') {

					var obj = $.parseJSON(data);
					   if(obj.status == 'success') {
						   notification_alert(obj.msg, obj.status);
						   console.log('data===>>>',data);
						   var alertError = '<div id="alert_float_1" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-success alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title"> ' +obj.msg+ '</span></div>';
						   $('.page-title').append(alertError);
						   setTimeout(function() {
								$('#alert_float_1').remove();
							}, 500000);
						closestr.remove();
				  	   }
					   else {
						   var alertError = '<div id="alert_float_1" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-warning alert alert-error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title"> '+obj.msg+ ' - '+'('+obj.status+obj.code+')</span></div>';
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

	/* $(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	}); */

	//setTimeout(function(){ $('table').removeClass('dataTable'); }, 1000);

	/* Remove Validate Error On Change */
	// $(document).on("change","input",function(){
     // console.log('test');
	// });

	 /* $('input').change(function(e){ */
	 $(document).on("change",".form-control",function(){
      if($(this).val() != ""){
		  $(this).next('span.error').remove();
		  $(this).parent().removeClass('error-control');
	  }
   });
   $('.select2-hidden-accessible').change(function(e){
      if($(this).val() != ""){
		  $(this).next('span.error').remove();
		  $(this).parent().removeClass('error-control');
	  }
   });

	/* Header Timer Popup*/
	 $('#top-timers').popover({
            html: true,
            content: function () {
				track_timer();
                return $('#timers-list').html();
            }
        });

	/* Confirm Timer*/
	$(document).on("click",".confirm_timer",function(){
		var taskid = $("#timer_tasks_list").val();
		var timer_note = $("#timer_note").val();
		$.ajax({
			   type: "POST",
			   url: base_url+'Ajaxrequest/save_timer',
			   data: {taskid:taskid,timer_note:timer_note},
			   success: function(data){
				   if(data != 'error') {
					   $(".timer_content").html(data);
					    $('#task_timer_modal').modal('toggle');
					    $('#top-timers').popover({
							html: true,
							content: function () {
								track_timer();
								return $('#timers-list').html();
							}
						});

				   }
			   }
		 });
	});

/*$('.table-striped').DataTable(
		"targets": 'no-sort',
		"bSort": false,
		"order": [],
		"dom": '<"top"i>rt<"bottom"flp><"clear">';
	);*/

});





/* delete bulk function */
$(document).on('click', '.bulk_delete', function(e){

		/* get all checked checkbox ids */
		var del_ids = [];
			$.each($("input[name='delete_all']:checked"), function(){
				del_ids.push($(this).attr("id"));
			});

        /* check del id array length */
		if(del_ids.length > 0){
              /* confirm before delete */
			  if(confirm('Are you sure?')){
			    var table_name    = $(this).attr('data-tbl');
			    var where_con_key = $(this).attr('data-wherecon-field');

			   $.ajax({
					   type: "POST",
					   url: base_url+'Ajaxrequest/delete_multiple',
					   data: {'tbl' : table_name, 'ids':del_ids, 'key':where_con_key},
					   success: function(data){
					       var obj = JSON.parse(data);
						   var delete_fail_count = parseInt(obj.Total_requested_rows) - parseInt(obj.rows_deleted);
						   var result_message = '';
                           if((delete_fail_count > 0) && (obj.rows_deleted == 0)){
							   result_message = 'Error : Can not delete selected data because it is related to another modules';
							   notification_alert(result_message, 'error');
						   }
						   else if((delete_fail_count > 0) && (obj.rows_deleted > 0)){
							   result_message = 'Error : '+delete_fail_count+' rows faild to delete because it is related to another modules';
							   notification_alert(result_message, 'error');
						   }
						   else if((delete_fail_count == 0) && (obj.rows_deleted > 0)){
							   result_message = obj.rows_deleted+' rows deleted successfully!';
                               notification_alert(result_message, 'success');
						   }
						   setTimeout(function(){ window.location.href = window.location.href; }, 1000);
					   }
				   });
				 }
			 else{
				  return false;
				 }
			}
        else{
		     alert('No row selected for delete');
	        }
});

/* select all checkbox function */
$(document).on('click', '#all_clients', function(e){
   if(this.checked){
            $('.check_all').each(function(){
                this.checked = true;
            });
        }else{
             $('.check_all').each(function(){
                this.checked = false;
            });
        }
});



function notification_alert(msg, status){
	var alert_class = "alert-success";
	if(status == 'error'){
		alert_class = "alert-danger";
	}
	var alertError = '<div id="alert_float_1" class="custom_after_event_message float-alert animated fadeInRight col-xs-11 col-sm-4 alert '+alert_class+'"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title">'+msg+'</span></div>';

	$(".alert_message").html(alertError);
	setTimeout(function() {
        $(".alert_message").html('');
    }, 10000);
}

function slideToggle(selector = ''){
	var $element = $(selector);
    if ($element.hasClass('hide')) { $element.removeClass('hide', 'slow'); }
    if ($element.length) { $element.slideToggle('slow'); }
}

// Datatables custom view will fill input with the value
function dt_custom_view(value, table, custom_input_name, clear_other_filters) {
    var name = typeof(custom_input_name) == 'undefined' ? 'custom_view' : custom_input_name;
    if (typeof(clear_other_filters) != 'undefined') {
        var filters = $('._filter_data li.active').not('.clear-all-prevent');
        filters.removeClass('active');
        $.each(filters, function() {
            var input_name = $(this).find('a').attr('data-cview');
            $('._filters input[id="' + input_name + '"]').val('');
        });
    }
    var _cinput = do_filter_active(name);
    if (_cinput != name) {
        value = "";
    }
    $('input[id="' + name + '"]').val(value);
    //$(table).DataTable().ajax.reload();
	 $('#estimate_tbl').dataTable().fnDestroy();
	datatble_pagination('estimate_tbl');
}

// Sets table filters dropdown to active
function do_filter_active(value, parent_selector) {
    if (value != '' && typeof(value) != 'undefined') {
        $('[data-cview="all"]').parents('li').removeClass('active');
        var selector = $('[data-cview="' + value + '"]');
        if (typeof(parent_selector) != 'undefined') {
            selector = $(parent_selector + ' [data-cview="' + value + '"]');
        }
        var parent = selector.parents('li');
        if (parent.hasClass('filter-group')) {
            var group = parent.data('filter-group');
            $('[data-filter-group="' + group + '"]').not(parent).removeClass('active');
            $('input[id="' + value + '"]').val('');
        }
        if (!parent.not('.dropdown-submenu').hasClass('active')) {
            parent.addClass('active');

        } else {
            parent.not('.dropdown-submenu').removeClass('active');
            // Remove active class from the parent dropdown if nothing selected in the child dropdown
            var parents_sub = selector.parents('li.dropdown-submenu');
            if (parents_sub.length > 0) {
                if (parents_sub.find('li.active').length == 0) {
                    parents_sub.removeClass('active');
                }
            }
            value = "";
        }
        return value;
    } else {
        $('._filters input').val('');
        $('._filter_data li.active').removeClass('active');
        $('[data-cview="all"]').parents('li').addClass('active');
        return "";
    }
}

 // Do not close the dropdownmenu for filter when filtering
    $("body").on('click', '._filter_data ul.dropdown-menu li a,.not-mark-as-read-inline,.not_mark_all_as_read a', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });

	// Init tooltips
    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    // Init popovers
    $("body").popover({
        selector: '[data-toggle="popover"]',
    });

    // Remove tooltip fix on body click (in case user clicked link and tooltip stays open)
    $("body").on('click', function() {
        $('.tooltip').remove();
    });

	$("body").on('click', function(e) {
        $('[data-toggle="popover"],.manual-popover').each(function() {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

$(function() {
  $('input[name="reservation"]').daterangepicker({
    opens: 'left',
	 useCurrent: true,
	 locale: {
	    format: 'DD-MM-YYYY',
	},
  }, function(start, end, label) {
		var filterUrl = $('#reservation').attr('data-table');
		var url = site_url +filterUrl;
		$('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
		$('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
		var TabVal = $('.activeTab_val').val();
		$("#date_range").submit();
	// $.ajax({
		   // type: "POST",
		   // url: url,
		   // data: {start:start.format('YYYY-MM-DD 00:00:00'),end:end.format('YYYY-MM-DD 23:59:59'),activeTab_val:TabVal},
		   // success: function(data){
		    // var a = $.parseHTML(data);
				// $('#example').html(data);
				// $('#datatable-buttons_wrapper').html(data);



				// $('.hidde_cls').eq(1).hide();
				// $('.datePick').eq(1).hide();
				// $('.export_div').eq(1).hide();
				// $('.datePick-left').eq(1).hide();
				// $('.hidde_cls1').eq(1).hide();
				// $('.addBtn').eq(1).hide();
				// $('#myTab').hide();

				// $('.table-striped').DataTable( {
					// destroy: true,
					// searching: true
				// } );

		   // }
		// });



  });
});





/*Export Excel file and CSV Fils Script*/
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
				  $('#hidden-type_blank_excel').val(target);
				  $('#export-form-blank').submit();
				  $('#hidden-type_blank_excel').val('');
            break
			 case 'export-to-mat-location-excel' :
				  $('#hidden-type-location-excel').val(target);
				  $('#export-location-blank').submit();
				  $('#hidden-type-location-excel').val('');
            break
            }

        });


/*  Save form data as draft */
$(document).on("click",".draftBtn",function(){
     	$('.save_status').val(0);
		var global_cls1 = $('.requrid_class option:selected').val();
		var global_cls  = $('.requrid_class').val();

		if(global_cls == '' || global_cls1 == '' ){
				$('.requrid_class').css('border', '1px solid #b94a48');
				//$('.requrid_class').closest(".form-control").find("span").text('This field is required');
				$('.spanLeft').html('<span style="color:red;font-size:12px;">This field is required</span>');
				return false;
			}else{
				$('.requrid_class').css('border', '1px solid #dedede');
				//$('.requrid_class').closest(".form-control").find("span").text('');
				$('.spanLeft').html('');
			}
		$('.form-control').removeAttr('required');
});


function printElement(elem) {
	var domClone = elem.cloneNode(true);
	var $printSection = document.getElementById("printSection");
	if (!$printSection) {
		var $printSection = document.createElement("div");
		$printSection.id = "printSection";
		document.body.appendChild($printSection);
	}

	$printSection.innerHTML = "";
	$printSection.appendChild(domClone);
	window.print();
}




$(function() {
  $('input[name="tabbingFilters"]').daterangepicker({
    opens: 'left',
	 startDate: moment().startOf('month'),
	endDate: moment().startOf('hour'),
	// useCurrent: true,
	 locale: {
	    format: 'DD-MM-YYYY',
	},
  }, function(start, end, label) {
		var filterUrl = $('#tabbingFilters').attr('data-table');
		var url = site_url +filterUrl;
	    $('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
		$('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
		$("#date_range").submit();
		// $.ajax({
		   // type: "POST",
		   // url: url,
		   // data: {start:start.format('YYYY-MM-DD 00:00:00'),end:end.format('YYYY-MM-DD 23:59:59')},
		   // success: function(data){
		   // var a = $.parseHTML(data);
				// var inProcessHtml = $(a).find('#example').html();
				// var CompleteHtml = $(a).find('#example_tab').html();
				// $('#example').html(inProcessHtml);
				// $('#example_tab').html(CompleteHtml);
				// $('.example').DataTable( {
					// destroy: true,
					// searching: true
				// });
		   // }
		// });
  });
});


// $(document).on("click",".filterBtn",function(){
	// var material_type_id = $('select[name="material_type"] option:selected').val();
	// var department = $('select[name="departments"] option:selected').val();
	// var filterUrl = $(this).attr('data-table');
	// var url = site_url +filterUrl;
		// $.ajax({
		// type: "POST",
		// url: url,
		// data: {material_type_id:material_type_id,departments:department},
		// success: function(data){
			// var a = $.parseHTML(data);
			// var inProcessHtml = $(a).find('#example').html();
			// var CompleteHtml = $(a).find('#example_tab').html();
			// $('#example').html(inProcessHtml);
			// $('#example_tab').html(CompleteHtml);
			// $('.example_tab').DataTable({
				// destroy: true,
				// searching: true
			// });
   // }
// });

// });

/********************************* For Numeric Validation ************************************************************/

function float_validation(event, value){
    if(event.which < 45 || event.which > 58 || event.which == 47 ) {
		//$("#errmsg").html("Numeric Only").show().fadeOut("slow");
          return false;
            event.preventDefault();
        } // prevent if not number/dot

        if(event.which == 46 && value.indexOf('.') != -1) {
		//	$("#errmsg").html("Numeric Only").show().fadeOut("slow");
            return false;
            event.preventDefault();
        } // prevent if already dot

            if(event.which == 45 && value.indexOf('-') != -1) {
				//$("#errmsg").html("Numeric Only").show().fadeOut("slow");
                return false;
            event.preventDefault();
        } // prevent if already dot

        if(event.which == 45 && value.length>0) {
		//	$("#errmsg").html("Numeric Only").show().fadeOut("slow");
			return false;
            event.preventDefault();
        } // prevent if already -

    return true;

};
/********************************* For Numeric Validation ************************************************************/
/********************************* For Active TABS after Refresh Page ************************************************************/
$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
});
var activeTab = localStorage.getItem('activeTab');

console.log(activeTab);
if (activeTab) {
   $('a[href="' + activeTab + '"]').tab('show');
}
/*********************************For Active TABS after Refresh Page ************************************************************/
/*********************************For Remove Disabled on change the filter dropdown ************************************************************/
$(document).ready(function(){
  $(document).on("change",".disbled_cls",function(){
   $('.filt1').prop("disabled", false);

  });
});
/*********************************For Remove Disabled on change the filter dropdown ************************************************************/
$(document).on("click",".close_sec_model",function(){
	setTimeout(function(){
		$('.nav-md').addClass('modal-open');
	}, 500);

});

$('.close').click(function(){
 setTimeout(function(){
  $("body").removeClass("modal-open");
   }, 1000);
});


/*************  For Notification   ****************/
 /*$(document).ready(function(){
	function load_unseen_notification(view = ''){
		$.ajax({
			url:site_url+'ajaxrequest/fetchNotification',
			method:"POST",
			data:{view:view},
			dataType:"json",
			success:function(data){
				$('.dropdown-menu-noti').html(data.notification);
				if(data.unseen_notification > 0){
					$('.count').html(data.unseen_notification);
				}
			}
		});
	}
	load_unseen_notification();


	 $(document).on('click', '.dropdown-toggle-noti', function(){
		$('.count').html('');
		load_unseen_notification('yes');
	});

 	setInterval(function(){
		load_unseen_notification();
	}, 5000);

}); */


function changeCompanyFilter(c_id = ''){
	//location.reload();
	$.ajax({
			url:site_url+'ajaxrequest/createGroupSession',
			method:"POST",
			data:{id:c_id},
			dataType:"json",
			success:function(data){
			console.log('data===>>>',data);
				location.reload();

			}
		});
}


$('#search').on('keyup', function() {
		var blank_val = $(this).val();
		if(blank_val == ''){
			var ctroller_name = $(this).attr('data-ctrl');
			 window.location.href = site_url+ctroller_name;
			}
	});

$(document).on('change','.materialNameId',function(){
	var matId = $(this).val();
	var custId = $('#account_id').val();
	$(this).closest('.well').find('#aliasNameMat').val('');
	$.ajax({
		url: site_url+'inventory/getMatAliasByCust/',
		method: "POST",
		data:{matId:matId,custId:custId},
		context:this,
		error:(error) => console.log(error),
		success:(data) => {
			$(this).closest('.well').find('#aliasNameMat').html('');
			if( data ){
				custAliasData = JSON.parse(data);
				$(this).closest('.well').find('#aliasNameMat').html(custAliasData.html);
			}else{
				$(this).closest('.well').find('#aliasNameMat').html(`<option value="N/A">N/A</option>`);
			}
		}

	});
})

$(document).on('change','#account_id',function(){
	var custId = $(this).val();
	$('.well').each(function(){
		var matId = $(this).find('.materialNameId').val();
		$.ajax({
			url: site_url+'inventory/getMatAliasByCust/',
			method: "POST",
			context:this,
			data:{matId:matId,custId:custId},
			error:(error) => console.log(error),
			success:(data) => {
				$(this).closest('.well').find('#aliasNameMat').html('');
				if( data ){
					custAliasData = JSON.parse(data);
					$(this).closest('.well').find('#aliasNameMat').html(custAliasData.html);
				}else{
					$(this).closest('.well').find('#aliasNameMat').html(`<option value="N/A">N/A</option>`);
				}
			}

		});
	})

})



/*  PArt Code  */
//To get Matrieal Type Ajax
$(document).on("click",".add_material_cls_name",function(){
   $('#myModal_Add_matrial_details').modal('show');
   	var btn_html = $(this).html();
   $('#add_matrial_Data_onthe_spot').val(btn_html);

});


$(document).on("click","#Add_matrial_details_on_button_click_purchase",function(){

	$('#mssg34').empty();
	var material_name  = $('#material_name').val();
	var hsn_code  = $('#hsn_code_quick_add').val();
	var uom  = $("select#uom option").filter(":selected").val();
	var specification  = $('#specification').val();
	var opening_balance  = $('#opening_balance_Sec').val();
	var material_type_id  = $('#material_type_id').val();
	var product_code  = $('#product_code').val();
	var tax  = $('#tax_quick_add').val();
	if( tax != 'NAN' ){
		tax = tax;
	}else{
		tax = 0;
	}


	var prefix  = $('#prefix').val();
	var error = 0;
	var errorMsg = "";
		if(material_name == ''){
			 errorMsg = "Required Material Type,Material Name And Code Fields";
			 error = 1;
		}
		if(material_type_id == ''){
			errorMsg = "Required Material Type,Material Name And Code Fields";
			error = 1;
		}

		if( product_code != '' && errorMsg == "" ){
			$.ajax({
				url:`${site_url}/purchase/checkProductCodeExist`,
				method:'POST',
				async : false,
				data:{product_code:product_code},
				error:(error) => console.log(error),
				success:(data) => {
					errorMsg = "";
					error    = "";
					if(data == 1){
						errorMsg = "Product Code is already exist";
						error    = 1;
					}
				}
			})
		}else{
			$('#product_code').css('border', '1px solid #b94a48');
			errorMsg = "Required Material Type,Material Name And Code Fields";
			error = 1;
		}

		$('#errorMsg').html('');
		if( errorMsg != '' ){
			error = 1;
			$('#errorMsg').html(`<span style="color:red">${errorMsg}</span>`);
		}

		if(error == 1) {
			return false;
		} else {
		$.ajax({
			   type: "POST",
			   url: site_url+'purchase/add_matrial_Details_onthe_spot/',
			   async : false,
			   data: {material_name:material_name,hsn_code:hsn_code,uom:uom,
			   			specification:specification,material_type_id:material_type_id,
			   			prefix:prefix,opening_balance:opening_balance,product_code:product_code,tax:tax},
				success: function(htmlStr) {
					 if(htmlStr == 'true'){
						$('#mssg34').html('<span style="color:green;">Material Added Successfully.</span>');
						$(".select2").val("").trigger("change");
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
					setTimeout(function(){
					$('#mssg34').html('<span></span>');
					}, 3000);
				}
			 });
		}
});

$(document).on('change','#hsn_code_quick_add',function(){
	var hsnCode = $(this).find('option:selected').text();
	taxValue = 0;
	igst = hsnCode.split(' - ');
	if( igst[1] !== 'undefined' && igst[1] != '' ){
		taxValue = parseInt(igst[1]);
	}
	$('#tax_quick_add').val(taxValue);
})





/*  PArt Code  */
