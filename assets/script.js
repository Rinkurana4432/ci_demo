/******-------------Add machine Editable table------------------- *****/
function amEditTbl() {
    const $tableID = $('#table_edit');
    const $BTN = $('#export-btn');
    const $EXPORT = $('#export');

    const newTr = `<tr>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half"><select class="form-control" name="uom[]">
										<option>Unit</option>
											<?php $checked ='';			
												$uom = getUom();											  
												foreach($uom as $unit) {												 
												if((!empty($Addmachine)) && ($machine_Parameter->uom == $unit)){ $checked = 'selected';}else{$checked = '';  }				
												echo "<option value='".$unit."' ".$checked.">".$unit."</option>";												
												}											
											?>		
									</select></td>
            <td>
              <span class="table-remove">
			  <a href="#!"  class="btn btn-delete btn-lg" >
			  <i class="fa fa-trash"></i></a>
			</span>
            </td>
          </tr>`;

    $('.table_add').on('click', 'p', () => {
        const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');
        if ($tableID.find('tbody tr').length === 0) {
            $('tbody').append(newTr);
        }
        $tableID.find('table').append($clone);
    });
    $tableID.on('click', '.table-remove', function() {
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
        $($rows.shift()).find('th:not(:empty)').each(function() {
            headers.push($(this).text().toLowerCase());
        });
        // Turn all existing rows into a loopable array
        $rows.each(function() {
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
/******-------------End ------------------- *****/
/*******************************PROCESS drag and drop /edit /add*******************************************/
/*$(document).on("click", ".editProcess", function () {
    var processId = $(this).attr('data-process-id');
	var row = $(this).closest('tr');
	var process_type = row.find("td:nth-child(2)").text();
	var description = row.find("td:nth-child(3)").text();
	var abc  = $(".editProcessType #process_type").val(process_type);
	$(".editProcessType #description").val(description);
	
    $('.editProcessType').modal('show');
});
*/

$(document).ready(function(e) {
    $(document).on("click", ".editProcessName", function(ev) {
        ev.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: site_url + 'production/editprocess',
            data: {
                id: id
            },
            success: function(data) {
                if (data != '') {
                    //jQuery.noConflict(); 			  
                    $('#process').modal('show');
                    $('#process .modal-body-content').html(data);
                    init_select2();
                    var maxProcess = 25; //maximum input boxes allowed
                    var processDiv = $(".processDiv"); //Fields wrapper
                    var add_process = $(".addMoreProcess"); //Add button ID
                    var y = 1; //initlal text box count
                    $(add_process).click(function(e) { //on add input button click
                        e.preventDefault();
                        if (y < maxProcess) { //max input box allowed
                            y++;
                            $(processDiv).append('<div class="well scend-tr" id="chkIndex_' + y + '"><div class="col-md-4 col-sm-12 col-xs-12 form-group"><input type="text" id="processName" name="process_name[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Process name" value=""></div><div class="col-md-8 col-sm-12 col-xs-12 form-group"><textarea style="border-right: 1px solid #c1c1c1 !important;" id="description" rows="1" placeholder="Description" class="form-control col-md-7 col-xs-12 description" name="description[]"></textarea></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
                        }
                    });
                    $(processDiv).on("click", ".remve_field", function(e) { //user click on remove text
                        e.preventDefault();
                        $(this).parent('div').remove();
                        y--;
                    });
                }
            }
        });
    });
});

$(function() {
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
    $('.panel-heading').click(function() {
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
    $('[draggable=true]').bind('dragstart', function(event) {
        console.log('event===>>>', event);
        sourceId = $(this).parent().attr('id');
        event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
        console.log("sourceId=>>>", event.originalEvent.dataTransfer.getData("text/plain"));
    });
    $('.panel-body').bind('dragover', function(event) {
        event.preventDefault();
    });
    $('.panel-body').bind('drop', function(event) {
        var children = $(this).children();
        var targetId = children.attr('id');
        console.log("targetid==>>", targetId);
        if (sourceId != targetId) {
            var elementId = event.originalEvent.dataTransfer.getData("text/plain");
            console.log("elementId->>", elementId);
            $.ajax({
                url: site_url + 'production/changeProcessType/',
                dataType: 'json',
                type: 'POST',
                data: {
                    'processId': elementId,
                    'processTypeId': targetId,
                },
                success: function(result) {
                    if (result.status == 'success') {
                        window.location.href = result.url;
                    }
                }
            });
            $('#processing-modal').modal('toggle'); //before post
            // Post data 
            setTimeout(function() {
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
    $('.process').each(function(index, element) {
        order.push({
            id: $(this).attr('id'),
            position: index + 1
        });
    });
    var children = $(this).children();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url + 'production/changeOrder/',
        data: {
            order: order,
        },
        success: function(response) {
            if (response.status == "success") {
                window.location.href = result.url;
            }
        }
    });
    $('#processing-modal').modal('toggle'); //before post
    // Post data 
    setTimeout(function() {
        var element = document.getElementById($(this).attr('id'));
        children.prepend(element);
        $('#processing-modal').modal('toggle'); // after post
    }, 1000);

}




/*******************************************************Other modules*******************************************/
$(document).ready(function(e) {
    $(document).on("click", ".productionTab", function(ev) {
        ev.preventDefault();
        var id = $(this).attr('id');
        var tab = $(this).attr('data-id');
        //console.log(tab);
        var url = '';
        switch (tab) {
            /*case 'processEdit':
            	url = 'production/editprocess';
            	break;	*/
            case 'machineEdit':
                url = 'production/Add_machine_edit';
                break;
            case 'machineView':
                url = 'production/Add_machine_view';
                break;
            case 'AddSimilar':
                url = 'production/Add_SimilarMachine_edit';
                break;
            case 'jobCardEdit':
                url = 'production/job_card_edit';
                break;
            case 'AddNewReport':
                url = 'production/add_new_report';
                break;
            case 'jobCardView':
                url = 'production/job_card_view';
                break;
            case 'productView':
                url = 'production/production_data_view';
                break;
            case 'productEdit':
                url = 'production/production_data_edit';
                break;
            case 'convertToProd':
                url = 'production/convert_to_production';
                break;
            case 'AddSimilarProdData':
                url = 'production/Add_SimilarProdData_edit';
                break;
            case 'AddSimilarPlan':
                url = 'production/Add_SimilarPlanning_edit';
                break;
            case 'productionPlanEdit':
                url = 'production/production_planning_edit';
                break;
            case 'productionPlanView':
                url = 'production/production_planning_view';
                break;
            case 'AddSimilarProdPlan':
                url = 'production/Add_SimilarProdPlan_edit';
                break;
            case 'editProcessType':
                url = 'production/processType_edit';
                break;
            case 'prodSettingEdit':
                url = 'production/production_setting_edit';
                break;
            case 'prodSettingView':
                url = 'production/production_setting_view';
                break;
            case 'production_department_edit':
                url = 'production/edit_department';
                break;
            case 'machineEditNew':
                url = 'production/Add_machine_edit_new';
                break;
            case 'machineViewNew':
                url = 'production/Add_machine_view_new';
            case 'jobCardEditNew':
                url = 'production/job_card_edit_new';
                break;
            case 'jobCardViewNew':
                url = 'production/job_card_view_new';
                break;
            case 'workerView':
                url = 'production/worker_view';
                break;
            case 'workerEdit':
                url = 'production/worker_edit';
                break;
            case 'prodGroupEdit':
                url = 'production/production_group_edit';
                break;
            case 'prodWages_perPiece':
                url = 'production/prodWages_perPiece_edit';
                break;
            case 'AddSimilarJobCard':
                url = 'production/Add_SimilarJob_card';
                break;
            case 'WorkerSalaryInfo':
                url = 'production/worker_salary_info_edit';
                break;
            case 'dispatched_order':
                url = 'production/dispatched_sale_order';
                break;
            case 'dispatched_order_view':
                url = 'production/dispatched_sale_order_view';
                break;
            case 'set_dispatched_date':
                url = 'production/set_dispatch_Date';
                break;
            case 'create_work_order':
                url = 'production/work_order_create';
                break;
            case 'work_order_edit':
                url = 'production/work_order_edit';
                break;
            case 'work_order_view':
                url = 'production/work_order_view';
                break;
            case 'BomRoutingView':
                url = 'production/BomRoutingView_dtls';
                break;
            case 'PlannedVsActualView':
                url = 'production/planned_vs_actual_view';
                break;
            case 'ProductionReportAdd':
                url = 'production/monthly_target_add';
                break;
            case 'ProductionReportView':
                url = 'production/monthly_target_view';
                break;       
			case 'ProductionReportQty':
                url = 'production/getWorkOrderTotalQty';
                break;		
			case 'ProductionMonthlyPlannedVsActualReportView':
                url = 'production/monthly_planned_vs_actual_view';
                break;
			case 'ProductionMonthlyPlannedVsActualReportQty':
                url = 'production/getMonthlyPlannedVsActualQtyReport';
                break;	
			case 'ProductionOutputReport':
                url = 'production/getProductionOutputReport';
                break;			
			case 'ProgessOfProduction':
                url = 'production/ProgessOfProduction';
                break;	
			
        }

        console.log("fff", tab);
        if (tab == 'convertToProd') {
            $('.tabclass').html('Production Data');
        }
        if (tab == 'create_work_order') {
            $('.sale_order_work_order').html('Work Order');
        }
        if (tab == 'productionPlanEdit') {
            $('.tabclass').html('Production Planning');
        }

        $.ajax({
            type: "POST",
            url: site_url + url,
            data: {
                id: id
            },
            success: function(data) {
                if (data != '') {
				if (tab == 'ProductionMonthlyPlannedVsActualReportView' || tab == 'ProductionReportView' || tab == 'ProductionReportAdd' ) {
					 $('.production_modal').modal('show');
                    $('.production_modal .modal-body-content').html(data);
				}else{
                     $("#production_modal").modal({
                        show: false,
                        backdrop: 'static'
                    });
                    $('#production_modal').modal('show');
                    $('#production_modal .modal-body-content').html(data); 
				}
		
                    if ($('#btnPrint').length !== 0) {
                        document.getElementById("btnPrint").onclick = function() {
                            printElement(document.getElementById("printView"));
                        }
                    }


                    if (tab == 'production_department_edit') {
                        addMoreDepartments();
                        get_company_location();
                        get_company_location();
                        // get_company_unit();
                    }
     
                    if (tab == 'machineEdit' || tab == 'machineEditNew') {
                        $('.machinePurchaseDate').daterangepicker({ // To hide dates after current date in date picker							
                            locale: {
                                format: 'DD-MM-YYYY',
                            },
                            singleDatePicker: true,
                            maxDate: new Date(),
                            singleClasses: "picker_3"
                        }, function(start, end, label) {
                            console.log(start.toISOString(), end.toISOString(), label);
                        });

                        add_parameter();
                        add_more_machine_process();
                        dateFetch();
                        get_company_department();
                        get_company_location();
                        //amEditTbl();
                        uploadImage();
                        init_select2();

                        if ($('.compny_unit').find('option:selected').val() != '') {
                            var companyUnit = $('.compny_unit').find('option:selected').val();
                            $('.department').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + companyUnit + '"');
                            $('.department').attr('data-id', 'department');
                            $('.department').attr('data-key', 'id');
                            $('.department').attr('data-fieldname', 'name');
                        }
                    } else if (tab == 'AddSimilar') {
                        $('.machinePurchaseDate').daterangepicker({ // To hide dates after current date in date picker							
                            locale: {
                                format: 'DD-MM-YYYY',
                            },
                            singleDatePicker: true,
                            maxDate: new Date(),
                            singleClasses: "picker_3"
                        }, function(start, end, label) {
                            console.log(start.toISOString(), end.toISOString(), label);
                        });
                        add_parameter();
                        add_more_machine_process();
                        dateFetch();
                        get_company_department();
                        get_company_location();
                    } else if (tab == 'jobCardEdit') {
                        addMaterialDetail();
                        get_parameter_value();
                        machineProcess();
                        getUom();
                        getMaterialName();
                        keyupFunction();
                        textareaWrap();
                        addMaterial_inputDetail();
                        addMaterial_outputDetail();
                        addAttachment_InJobCard();
                        addmachineForProcesstype();
                    } else if (tab == 'AddSimilarJobCard') {
                        addMaterialDetail();
                        get_parameter_value();
                        machineProcess();
                        getUom();
                        getMaterialName();
                        keyupFunction();
                        textareaWrap();
                    } else if (tab == 'productEdit') {
                        fetchJobCardValue();
                        textareaWrap();
                        addMulitpleRow();
                        get_jobcard_on_select();
                        get_company_location();
                        get_company_department();
                        for_add_multiple_tags_for_worker();
                        getWorkerIds();
                        init_select2();
                        init_select21();
                        dateFetch();
                        getOnchang();
                        SelectOption();
                        getshiftAccrdng_toDept();
                      //  getMaterialNamesaleorder();
                        getMaterialNameWorkorder();
                        init_select2so();
                        select_on_npdm_sale_order();



                    } else if (tab == 'convertToProd' || tab == 'AddSimilarProdData') {
                        fetchJobCardValue();
                        addMulitpleRow();
                        get_jobcard_on_select();
                        get_company_location();
                        get_company_department();
                        for_add_multiple_tags_for_worker();
                        getWorkerIds();
                        init_select2();
                        init_select21();
                        dateFetch();
                        getOnchang();
                        SelectOption();
                        getMessageDisplay();
                        getshiftAccrdng_toDept();
                        init_select2so();
                        select_on_npdm_sale_order();
                      //  getMaterialNamesaleorder();      
						getMaterialNameWorkorder();
                    } else if (tab == 'productionPlanEdit') {
                        AddRowPlan();
                        get_jobcard_on_select();
                        get_company_location();
                        get_company_department();
                        //keyupFun();
                        dateFetch();
                        getshiftAccrdng_toDept();
                        init_select21();
                        select_on_npdm_sale_order();
                    } else if (tab == 'AddSimilarProdPlan') {
                        AddRowPlan();
                        get_jobcard_on_select();
                        get_company_location();
                        get_company_department();
                        getMessageDisplay();
                        dateFetch();
                        getshiftAccrdng_toDept();
                        select_on_npdm_sale_order();
                        init_select2so();
                      //  getMaterialNamesaleorder();
                        getMaterialNameWorkorder();
                    } else if (tab == 'workerEdit') {
                        dateFunction();
                        getAddress();
                    } else if (tab == 'WorkerSalaryInfo') {
                        //get_company_location();
                        //get_productionData_date();
                        dateFetch();
                    } else if (tab == 'prodWages_perPiece' || tab == 'prodSettingEdit') {
                        get_company_location();
                        get_company_department();
                    } else if (tab == 'dispatched_order') {
                        //get_company_location();
                        //sendSaleOrderPriorityToServer();
                        dateFunction();
                        saleOrderComplete();
                    } else if (tab == 'set_dispatched_date') {
                        dateFunction();

                    } else if (tab == 'prodGroupEdit') {
                        addMachineGroup();

                    } else if (tab == 'create_work_order' || tab == 'work_order_edit') {
                        dateFunction();
                        getQtyValue();  
						UpdatePendingQtyValue();
                        getMaterialIdFromWorkOrder();
                        getUom(); 
						//WorkOrderProcess();
                    } else if (tab == 'add_new_report') {
                        //	addMaterialDetail();
                        get_parameter_value();
                        machineProcess();
                        getUom();
                        //	getMaterialName();
                        //	keyupFunction();
                        //	textareaWrap();
                        //	addAttachment_InJobCard();
                    } else if (tab == 'BomRoutingView') {
                        get_mat_data_id();
                    } else if(tab == 'ProductionReportAdd'){
						GetMonthlyProductionData();
					}

                    /*validation*/
                    $('form')
                        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
                        .on('change', 'select.required', validator.checkField)
                        .on('keypress', 'input[required][pattern]', validator.keypress);
                    $('form').submit(function(e) {
                        e.preventDefault();
						 var submit = true;
						 if (tab == 'ProductionReportAdd') {
							submit = FORMVALIDATE(e);
						}
                       
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
                    init_select2so();
                    for_add_multiple_tags_for_worker();
                    Print_data_new();
                    select_on_npdm_sale_order();
                    //Print_data();

                }
            }
        });
    });


});
/**************datefunction in worker and set prodcution dispatch date **************/
function dateFunction() {

    var date = new Date();
    //date.setDate(date.getDate()-0);
    $('.date_of_join').datepicker({
        startDate: date,
        dateFormat: 'dd-mm-yy',
        onSelect: function(selected) {
            $(".date_of_reliev").datepicker("option", "minDate", selected)
        }
    });

    var date1 = new Date();
    //date1.setDate(date1.getDate()-0);
    $('.date_of_reliev').datepicker({
        dateFormat: 'dd-mm-yy',
        beforeShow: function() {
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

// /*chang statsu in worker*/
$(document).on('change', '.change_status_worker', function() {
    var workerStatus;
    var checkbox = $(this).attr('checked', true);
    if (checkbox.context.checked == true) workerStatus = 1;
    else workerStatus = 0;
    var id = $(this).attr("data-value");

    $.ajax({
        url: site_url + 'production/change_status_worker/',
        dataType: 'json',
        type: 'POST',
        data: {
            'id': id,
            'workerStatus': workerStatus,
        },
        success: function(data) {
            if (data == true) {
                location.reload();
            }
        }
    });
});

/*add parameter in machine*/
function add_parameter() {
    //var maxfields      = 10; 
    var parameter = $(".input_parameter");
    var add_btn = $(".addButton");
    var y = 1;
    $(add_btn).click(function(e) {
        //alert(77);
        e.preventDefault();
        var measurmentArray = '';
        /* $.each( measurementUnits, function( key, value ) {
        	measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        }); */
        //if(y < maxfields){ 
        y++;
        /* $(parameter).append('<div class="well scend-tr mobile-view" id="chkIndex_'+y+'"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label >Parameter</label><input type="text" class="form-control item_name" name="machine_parameter[]" id="machine_parameters" placeholder="Enter machine Parameters"></div><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label>UOM</label><select class="form-control" name="uom[]"><option>Unit</option>'+measurmentArray+'</select></div><button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>'); */
        $(parameter).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label >Parameter</label><input type="text" class="form-control item_name" name="machine_parameter[]" id="machine_parameters" placeholder="Enter machine Parameters"></div><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label>UOM</label><select class="uom selectAjaxOption select2 form-control select2-hidden-accessible"  tabindex="-1" aria-hidden="true"  name="uom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="created_by_cid=' + logged_user + ' OR created_by_cid = 0 AND active_inactive = 1"><option value="">Select Option</option></div><button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');

        init_select2();



        //}
    });
    $(parameter).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
    });
}



/*add parameter in machine*/
function add_more_machine_process() {
    var maxfields = 25;
    var process = $(".process_div");
    var processAddButton = $(".processAddButton");
    //var y = 1; 	
    var y = $('.process_div .well').length;
    $(processAddButton).click(function(e) {
        //alert(77);
        e.preventDefault();
        var logged_user = $('#loggedUser').val();
        console.log("dds", logged_user);
        //var measurmentArray = '';
        //$.each( measurementUnits, function( key, value ) {
        //	measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        //});
        if (y < maxfields) {
            y++;
            $(process).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Process Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="process_type[]" data-id="process_type" data-key="id" data-fieldname="process_type" data-where="created_by_cid=' + logged_user + '" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)"><option value="">Select option</option>	</select></div><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label >Process</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id" name="process_name[]" width="100%" tabindex="-1" aria-hidden="true" required="required" data-id="add_process" data-key="id" data-fieldname="process_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + '"><option value="">Select Option</option></select></div><button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');

            init_select2();
            //getProcess();
        }


    });
    $(process).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
    });

}



/*date function*/
function dateFetch() {
    var year = (new Date).getFullYear();
    $('#year').datepicker({
        minViewMode: 2,
        endDate: new Date(),
        autoclose: true,
        format: 'YYYY-MM-DD'
    });

    // var date = new Date(); 
    // $('#date').datepicker({ 
    //startDate: date,
    // format: 'dd-mm-yyyy',
    // autoclose: true
    //});  

    /* ('#date').datepicker({ 
    	startDate: date,
    	format: 'dd-mm-yyyy',
    	autoclose: true 
    });          
    ('#planningDate').datepicker({ 
    	startDate: date,
    	format: 'dd-mm-yyyy',
    	autoclose: true 
    });    */
    $("#planningDate").datepicker({
        dateFormat: 'dd-mm-yy', //check change
        autoclose: true
    });

    $("#date").datepicker({
        dateFormat: 'dd-mm-yy', //check change
        autoclose: true
    });

    //$('#date').datepicker();
    //$('#planningDate').datepicker();

    $("#date").on("change", function() {
        var selected_date = $("#date").datepicker("getDate");
        var date = selected_date.getDate();
        var month = selected_date.getMonth() + 1;
        var year = selected_date.getFullYear();
        var days = new Date(year, month, 0).getDate();
        var sundays = [(8 - (new Date(month + '/01/' + year).getDay())) % 7];
        for (var i = sundays[0] + 7; i < days; i += 7) {
            sundays.push(i);
        }
        var sundaysCount = sundays.length;
        var no_of_days_in_month = daysInMonth(month, year) - sundaysCount;
        $('#noOfdays').val(no_of_days_in_month);


        /*
        var selected_date = $("#date").datepicker("getDate");
        var date = selected_date.getDate();
        var month = selected_date.getMonth()+1;
        var year= selected_date.getFullYear();
        var no_of_days_in_month = daysInMonth(month, year);
        //var selected = $(this).val();
        $('#noOfdays').val(no_of_days_in_month);*/

    });

    /*$("#planningDate").on("change",function(){
		var selected_date = $("#planningDate").datepicker("getDate");
		var date = selected_date.getDate();
		var month = selected_date.getMonth()+1;
		var year= selected_date.getFullYear();
		var no_of_days_in_month = daysInMonth(month, year);
		//var selected = $(this).val();
		$('#noOfdays').val(no_of_days_in_month);
		
    });*/


    //$('#date').datepicker('setDate',new Date());


}


/*job card add more material field */
function addMaterialDetail() {
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
            $(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '" ><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2"  required="required" name="material_name[]" onchange="getUom(event,this);"></select></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Quantity</label><input  class="form-control col-md-7 col-xs-12 qty actual_qty" name="quantity[]" placeholder="Qty" required="required" type="text" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>UOM</label><input type="text" id="uom" name="uom_value[]" class="form-control col-md-7 col-xs-12  uom" style="width:100%;" placeholder="uom." value="" readonly></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Price</label><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 " placeholder="Price" value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Total</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" class="form-control col-md-7 col-xs-12  total" placeholder="Total Amount" value="" readonly></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');


            var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        //getMaterialIssue();
        getMaterials(mat_id, y);
        init_select2();
        addMaterial_inputDetail();
        addMaterial_outputDetail();
        //get_Qty_UOm();
        getUom();

    });
    $(input_mat).on("click", ".remove_input", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
        keyupFunction(event, this);
    });
}

/**********************key up function for job card to caluclate material costing****************/
function keyupFunction(evt, t) {
    var closestId = $(t).closest(".well").attr("id");
    var qty, price, grand_total;
    qty = parseFloat($("#" + closestId + " input[name='quantity[]'").val());
    price = parseFloat($("#" + closestId + " input[name='price[]'").val());
    TotalAmount = parseFloat(qty) * parseFloat(price);
    if (isNaN(TotalAmount)) {
        var TotalAmount = 0;
    }
    $("#" + closestId + " input[name='total[]'").val(TotalAmount.toFixed(2));
    subtotal();
}

function subtotal() {
    /*calulate grand total of all amount enter*/
    var grandtot = 0;
    $("input[name='total[]']").each(function() {
        grandtot += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());
    });
    /*calualte total of wuantity enter*/
    var Totalqty = 0;
    $("input[name='quantity[]']").each(function() {
        Totalqty += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());
    });


    var materialCosting = grandtot / Totalqty;
    if (isNaN(materialCosting)) {
        var materialCosting = 0;
    }

    $("#material_costing").val(materialCosting.toFixed(2));

}


function getOnchang(t, evt) {
    var abc = $(t).val();
    //console.log("abc",abc);
}




/*calculate costing*/
function keyupFun(evt, t) {

    if ($(t).length > 0) {
        var nameField = $(t).attr("name");
        var key = nameField.split("[", 1);
        var indexArrayKey = nameField.split(key).pop();
    }
    var closestId = $(t).closest('.rTableRow').attr('id');
    //var closestId = $(t).closest('tr').attr('id');
    var selected_option = $("#" + closestId + "").find('input[type="radio"]:checked').val();
    //var output = $("#output").val();
    //console.log(output);


    /**************this part is called when planning converted to data(wages seleceteD)****
    var getvalues = $(t).closest('.hours').val();
    var totalDays = $("#noOfdays").val();
    var IndividualWorkersalary = $(t).closest('.hours').next("input[name='salary']").val();
    var totalsalary =0;		
    if(selected_option == 'wages'){ // for wages calaculation
    	var one_Day_Salary = IndividualWorkersalary / totalDays;
    	var one_Hr_Salary = one_Day_Salary/8;
    	var calculatedSalary = one_Hr_Salary * getvalues;	
    	//console.log("one_Day_Salary",one_Day_Salary);
    	//console.log("one_Hr_Salary",one_Hr_Salary);
    	//console.log("calculatedSalary",calculatedSalary);
    	$(t).closest('.hours').next().next(".totalsalary").val(Math.round(calculatedSalary));	
    	($('#'+closestId).find('.totalsalary')).each(function() {
    		totalsalary = parseFloat(totalsalary) + parseFloat($(this).val());
    		//console.log(totalsalary);
    	});	
    	if(output != '' || output != 0){
    		var labour_costing = parseFloat(totalsalary) / parseFloat(output);
    		$('#'+closestId).find('.labour_costing').val(labour_costing);	
    	}
    	
    }***/
    /****************end o code*********************************/
    var salary, output, output_wages, per_piece_price, totalwastage, totalLaborCosting, TotalSalary, totalPercentage = 0;

    var getvalues = $(t).closest('.hours').val();

    var totalDays = $("#noOfdays").val();

    //var IndividualWorkersalary = $(t).closest('.hours').next().next("input[name='salary']").val();
    var IndividualWorkersalary = $(t).closest('.hours').next("input[name='salary']").val();
    //var IndividualWorkersalary = $(t).closest('.totalsalary').val();
    console.log("IndividualWorkersalary=>>>>>", IndividualWorkersalary);
    var totalsalary = 0;
    if (selected_option == 'wages') { // for wages calaculation at the time of edit production data
        console.log("wages");
        output_wages = (($("#" + closestId).find('.output').val()) != '') ? (parseFloat($("#" + closestId).find('.output').val())) : 0;
        console.log("output wages", output_wages);
        var one_Day_Salary = IndividualWorkersalary / totalDays;
        var one_Hr_Salary = one_Day_Salary / 8;
        var calculatedSalary = one_Hr_Salary * getvalues;

        //$(t).closest('.hours').next().next(".totalsalary").val(Math.round(calculatedSalary));	
        $(t).closest('.hours').next().next(".totalsalary").val(Math.round(calculatedSalary));
        ($('#' + closestId).find('.totalsalary')).each(function() {
            totalsalary = parseFloat(totalsalary) + parseFloat($(this).val());
            //console.log(totalsalary);
        });
        if (output_wages != '' || output_wages != 0) {
            console.log("ddddd", output_wages);
            var labour_costing = parseFloat(totalsalary) / parseFloat(output_wages);
            if (isNaN(labour_costing)) {
                labour_costing = 0;
            }
            $('#' + closestId).find('.labour_costing').val(labour_costing.toFixed(2));
        }

    }
    //salary in case of per piece
    else if (selected_option == 'per_piece') {
        console.log("ggggg");
        output = (($("#" + closestId).find('.output').val()) != '') ? (parseFloat($("#" + closestId).find('.output').val())) : 0;
        console.log("output per_piece", output);
        var labourCosting = (($("#" + closestId).find('.labour_costing').val()) != '') ? (parseFloat($("#" + closestId).find('.labour_costing').val())) : 0;
        console.log("labourCosting per_piece", labourCosting);
        TotalSalary = parseFloat(labourCosting) * parseFloat(output);
        console.log("TotalSalary per_piece", TotalSalary);
        if (isNaN(TotalSalary)) {
            TotalSalary = 0;
        }
        //$(t).closest('tr').children().find('.hours').each(function() {
        $(t).closest('.rTableRow').children().find('.hours').each(function() {
            totalPercentage = totalPercentage + parseFloat($(this).val());
            var nameFieldd = $(this).attr("name");
            var keyy = nameFieldd.split("[", 1);
            var indexArrayKeyForWorker = nameFieldd.split(keyy).pop();
            totalSalary = (TotalSalary * parseFloat($(this).val())) / 100;
            if (isNaN(totalSalary)) {
                totalSalary = 0;
            }
            $("#" + closestId + " input[name='totalsalary" + indexArrayKeyForWorker + "']").val(totalSalary);
        });
        //console.log('totalPercentage===>>>',totalPercentage);
        /*if(totalPercentage != 100){
        	$(t).closest('tr').find('.show_msg').css("display", "block");
        	$(t).closest('tr').find('.show_msg').css("color", "red");
        }else{				
        	$(t).closest('tr').find('.show_msg').css("display", "none");
        }*/
        if (totalPercentage != 100) {
            $(t).closest('.rTableRow').find('.show_msg').css("display", "block");
            $(t).closest('.rTableRow').find('.show_msg').css("color", "red");
        } else {
            $(t).closest('.rTableRow').find('.show_msg').css("display", "none");
        }
        var countErrorMessage = 0;
        $('.show_msg').each(function() {
            if ($(this).css("display") == "block") {
                countErrorMessage++;
            }
        });
		//alert(countErrorMessage);
        if (countErrorMessage > 0) {
            $('.disablesubmitBtn').attr("disabled", true);
            $('.draftBtn').attr("disabled", true);
        } else {
            $('.disablesubmitBtn').attr("disabled", false);
            $('.draftBtn').attr("disabled", false);
        }
    } else {
        console.log("hello");
        output = (($("#" + closestId + " input[name='output" + indexArrayKey + "']").val()) != '') ? (parseFloat($("#" + closestId + " input[name='output" + indexArrayKey + "']").val())) : 0;
        if (output != 0) {
            salary = parseFloat($("#" + closestId + " input[name='salary" + indexArrayKey + "']").val());
            var totalSalaryy = 0;
            //$(t).closest('tr').children().find('.totalsalary').each(function() {
            $(t).closest('.rTableRow').children().find('.totalsalary').each(function() {
                totalSalaryy = totalSalaryy + parseFloat($(this).val());
            });
            var labour_costing = totalSalaryy / output;
            if (isNaN(labour_costing)) {
                labour_costing = 0;
            }
            $("#" + closestId + " input[name='labour_costing" + indexArrayKey + "']").val(labour_costing.toFixed(2));
        } else {
            $("#" + closestId + " input[name='labour_costing" + indexArrayKey + "']").val('');
        }
    }
}

/*job card machine add more*/
function machineProcess() {
    var machine = 10;
    var machine_detail = $(".machine_fields");
    var add_machine = $(".addmachineFields");
    var a = $(".machine_fields .well").length;
    //var well = $(".well2").length+1;	
    var well = $(".well2").length;

    var x = ($(".machine_fields .well").length > 1) ? ($(".machine_fields .well").length) : 1;

    var k = 1;
    var numRows = $('.textarea').attr('data-id');
    var style1 = '';
    if ((numRows != 0) && (numRows > 10)) {
        style1 = $('.textarea').css('style="height:' + numRows + 'px"');
    } else if ((numRows == 0) && (numRows < 10)) {

        style1 = $('.textarea').css('style="height:' + numRows + 'px"');
    }

    $(add_machine).click(function(e) {
        var processType = $('.processType_id').find('option:selected').val();
        var ids = $(this).closest('.well2').last().attr('data-id');
        //var fg = $(this).closest('.well2').last().attr('id');
        //var mainTrIndex = fg.split('chckIndex').pop().split('_')[1];
        //console.log("dddd",well+1);
        var prc_sch_input = $(".chk_idd_input").length + 1;
        var prc_sch_output = $(".chk_idd_output").length + 1;
        //alert('dfd');
        $('.input_val').val(prc_sch_input);
        $('.output_val').val(prc_sch_output);

        e.preventDefault();
        if (x < machine) {
            x++;
            k++;
            well++;


            console.log("weeee", well);
            var logged_user = $('#loggedUser').val();

            $(machine_detail).append('<div class="well well2 scend-tr" id="chckIndex_' + well + '" data-id="frst_div_' + well + '"><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Process Name<span class="required">*</span></label><div class=" form-group col-md-6 col-sm-12 col-xs-12"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id" required="required" name="process_name[]" tabindex="-1" aria-hidden="true" required="required" onchange="getMachineName(event,this)" data-where="process_type_id=' + processType + '" data-id="add_process" data-key="id" data-fieldname = "process_name"><option value=""></option> </select></div></div><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Description</label><div class="col-md-6 col-sm-12 col-xs-12"><textarea name="description[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Description"></textarea></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Do\'s</label><div class="col-md-6 col-sm-12 col-xs-12"><textarea name="dos[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Do\'s"></textarea></div></div><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Dont\'s</label><div class="col-md-6 col-sm-12 col-xs-12"><textarea name="donts[]" class="form-control col-md-7 col-xs-12 textarea" placeholder=" Dont\'s"></textarea></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Attachment</label> <input type="hidden" name="old_doc_' + well + '" value=""><div class="col-md-6 col-sm-12 col-xs-12 "> <input type="hidden" name="old_doc_1" value=""><div class="col-md-12 col-sm-12 col-xs-12 add_documents" ><div class="col-md-10 col-sm-12 col-xs-10 form-group doc" id="abc_' + well + '"> <input type="file" class="form-control col-md-7 col-xs-12 documentsAttach" name="documentsAttach_frst_div_' + well + '[]" value=""></div> <button class="btn edit-end-btn add_moreDocs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div></div><div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;"><div class="total_machines_ids" id="ParameterIndexinput_' + well + '"><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Machine name</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" ><div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" required="required" name="machine_name[]" tabindex="-1" aria-hidden="true" ><option value="">Select Option</option> </select></div></div></div><div class="item form-group col-md-3 col-xs-12"><div class="col"><label>Machine Parameter</label></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"><div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"><div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group"><div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div></div></div><div class="item form-group col-md-2 col-xs-12" ><div class="col" ><label>Production per Shift</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift"><br><br></div></div><div class="item form-group col-md-2 col-xs-12" ><div class="col" ><label>Workers</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="workers[]" class="form-control col-md-7 col-xs-12 workers" placeholder="workers"><br><br></div></div><div class="item form-group col-md-2 col-xs-12" ><div class="col" ><label>Action</label></div><div class="col-md-12 col-sm-12 col-xs-12"  style="text-align: center;border-bottom: 1px solid #aaa;"> <button class="btn edit-end-btn addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div></div><div class="col-md-12 col-sm-12 col-xs-12 " style="padding: 0px;"><div class=" col-md-12 well_Sech_input" style="padding: 0px;"><div class="col-md-12 input_cls chk_idd_input" id="sechIndexinput_' + prc_sch_input + '" ><h3 class="Material-head"> INPUT<hr></h3><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Type</label> <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type material_type_id select2" required="required" name="material_type_input_id_' + well + '[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" id=""><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Name</label> <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  required="required" name="material_input_name_' + well + '[]" onchange="getUom_input(event,this);"><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">Quantity</label><input type="text"  name="quantity_input_' + well + '[]" class="form-control col-md-7 col-xs-12 qty_input actual_qty" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">UOM</label><input type="text" name="uom_value_input1_' + well + '[]" class="form-control col-md-7 col-xs-12 uom_input" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_input_' + well + '[]" class="uom_input_val" readonly value=""></div><div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;"> <label class="col col-md-12" style="padding: 17px 6px;"></label><button class="btn edit-end-btn add_moreinputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div><div class="col-md-12 well_Sech_output" style="padding:0px;"><div class="col-md-12 output_cls chk_idd_output" id="sechIndexoutput_' + prc_sch_output + '" style="padding:0px;"><h3 class="Material-head"> OUTPUT<hr></h3><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Type</label> <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id material_type select2" required="required" name="material_type_output_id_' + well + '[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Name</label> <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  required="required" name="material_output_name_' + well + '[]" onchange="getUom_output(event,this);"><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">Quantity</label><input type="text" name="quantity_output_' + well + '[]" class="actual_qty form-control col-md-7 col-xs-12 qty_output" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">UOM</label><input type="text" name="uom_value_output1_' + well + '[]" class="form-control col-md-7 col-xs-12 uom_output" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_output_' + well + '[]" class="uom_output_val" readonly value=""></div><div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;"> <label class="col col-md-12" style="padding: 17px 6px;"></label><button class="btn edit-end-btn add_moreoutputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div></div> <button class="btn btn-danger remove_machine" type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div>');

            get_parameter_value();
            textareaWrap();
            addAttachment_InJobCard();
            addMaterial_outputDetail();
            addMaterial_inputDetail();
            init_select2();
            getUom_input();
            getUom_output();
            addmachineForProcesstype();
			 return false;
        }
    });
    $(machine_detail).on("click", ".remove_machine", function(e) {
        //console.log('ppppddddd==>>>>',$(this).parent('div').closest('.well2').find('chckIndex_'+x+''));
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
        //$(this).parent('div').closest('.well2').remove(); x--;
    });

}

function addmachineForProcesstype() {
    var input = 10;
    var input_mat = $(".col-container");
    var add_machine_button = $(".addmachineForProcesstype");
    var logged_user = $('#loggedUser').val();
    $(add_machine_button).click(function(e) {
		e.preventDefault();
        var y = $(this).parents('.col-container').find('.total_machines_ids').length;
        var div_id = $(this).closest('.total_machines_ids').attr('id');
        var div_len = $(".col-container").length;
        var process_id = $(this).parents().closest('.well2').find('.process_name_id :selected').val();
        $('.input_val').val(y + 1);
        if (y < input) {
            y++;
            $(this).closest('#' + div_id).parent().append('<div class="total_machines_ids" id="ParameterIndexinput_' + y + '"> <div class="item form-group col-md-1 col-xs-12" > <div class="col" ><label>Machine name</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" required="required" name="machine_name[]" tabindex="-1" aria-hidden="true"> <option value="">Select Option</option> </select> </div></div></div><div class="item form-group col-md-3 col-xs-12"> <div class="col"><label>Machine Parameter</label></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"> <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"> <div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group"> <div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div></div></div><div class="item form-group col-md-2 col-xs-12" > <div class="col" ><label>Production per Shift</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text"  name="production_shift[]" class="form-control col-md-7 col-xs-12" placeholder="production per Shift"><br><br></div></div><div class="item form-group col-md-2 col-xs-12" > <div class="col" ><label>Workers</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="workers[]" class="form-control col-md-7 col-xs-12" placeholder="workers"><br><br></div></div><div class="item form-group col-md-2 col-xs-12 RemovemachineForProcesstype" > <div class="col" ><label>Action</label></div><div class="col-md-12 col-sm-12 col-xs-12"  style="text-align: center;border-bottom: 1px solid #aaa;"> <button class="btn edit-end-btn " style="margin-bottom: 3%;" type="button"><i class="fa fa-minus"></i></button> </div></div></div>');
            if (process_id != '') {
                var like = '%"process":"' + process_id + '"%';
                $(this).closest('.well2').find('.machine_name_id').attr('data-where', "process LIKE '" + like + "' AND save_status=1");
                $(this).closest('.well2').find('.machine_name_id').attr('data-id', 'add_machine');
                $(this).closest('.well2').find('.machine_name_id').attr('data-key', 'id');
                $(this).closest('.well2').find('.machine_name_id').attr('data-fieldname', 'machine_name');
                $(this).closest('.well2').find('.machine_name_id').attr('name', 'machine_name[' + process_id + '][]');

            }
            get_parameter_value();
            init_select2();
			 return false;
        }
		       


    });
    $(input_mat).on("click", ".RemovemachineForProcesstype", function(e) {
		 var y = $(this).parents('.col-container').children('.total_machines_ids').length;
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
        $('.input_val').val(y);
        keyupFunction(event, this);
    });

}

//get_parameter_value();
function get_parameter_value() {
    $('.machine_name_id').on('change', function() {
        var machineId = $(this).val();
        var getPara = $(this);
        var process_name = $(this).val();
        //var machine_name = $(".machine_name_id option[value='"+machineId+"']").text();
        var process_id = $(getPara).parents().closest('.well2').find('.process_name_id :selected').val();
        //console.log(process_id); 
        var newParmenterHtml = '';
        var newParmenterHtml = '<div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"><div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"> <div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group"> <div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div></div>';
        $(getPara).parent().closest('.total_machines_ids').find('.MachineParameterReplacement').html(newParmenterHtml);
        $(getPara).parent().closest('.total_machines_ids').find('.production_shift').attr('name', 'production_shift[' + process_id + '][' + machineId + ']');
        $(getPara).parent().closest('.total_machines_ids').find('.workers').attr('name', 'workers[' + process_id + '][' + machineId + ']');

        $.ajax({
            type: 'POST',
            url: site_url + 'production/get_machine_parameter',
            data: {
                'machineId': machineId,
            },
            success: function(data) {
                //console.log(data);
                var dataObj = JSON.parse(data);
                var len = dataObj.length;
                var parameter1 = '';
                var uom1 = '';
                var value1 = '';

                for (var i = 0; i < len; i++) {
                    var machine_parameter_1 = dataObj[i].machine_parameter;
                    var uom_1 = dataObj[i].uom;
                    var val_1 = '';

                    $(getPara).parent().closest('.total_machines_ids').find('.parameter').attr('value', '');
                    $(getPara).parent().closest('.total_machines_ids').find('.uom').attr('value', '');
                    $(getPara).parent().closest('.total_machines_ids').find('.value').attr('value', '');
                    parameter1 += '<input type="text" placeholder="Parameter" name="parameter[' + process_id + '][' + machineId + '][]" class="form-control col-md-7 col-xs-12 parameter" value="' + machine_parameter_1 + '" readonly>';
                    uom1 += '<input type="text" placeholder="UOM" name="uom[' + process_id + '][' + machineId + '][]" class="form-control col-md-7 col-xs-12 uom" value="' + uom_1 + '" readonly>';
                    value1 += '<input type="text" placeholder="Value" name="value[' + process_id + '][' + machineId + '][]" class="form-control col-md-7 col-xs-12 value" value="' + val_1 + '">';
                    //	$(getPara).closest('.well').find('.machine_name_dispaly').html(machine_name);
                    $(getPara).parent().closest('.total_machines_ids').find('.parameter_name').html(parameter1);

                    $(getPara).parent().closest('.total_machines_ids').find('.uom').html(uom1);
                    $(getPara).parent().closest('.total_machines_ids').find('.value').html(value1);

                }
            }
        });
    });
}

function getProcess(evt, t, selProcessType = '', closestDiv = '') {
    var closestId = $(t).closest(".well").attr("id");
    //var closestId = $(t).closest(".well");


    $('#' + closestId + ' #process_name_id').empty();
    var logged_user = $('#loggedUser').val();
    //$(t).parents().parents('div').find('.process_name_id').empty();
    //$(this).parents().closest('input=[text]').find('.machine_name_id').empty();
    //console.log($(t).closest('.process_name_id'));
    if (window.location.href == site_url + 'production/Add_machine') {
        var main_div_id = $(t).parents().parents('div').attr("id");

        $('#' + main_div_id + ' #process_name_id').empty();
    } else {
        $('#process_name_id').empty();
        $(t).parents().parents().find('.machine_name_id').empty();
        $(t).parents().parents().find('.parameter_name').html('');
        $(t).parents().parents().find('.uom').html('');
        $(t).parents().parents().find('.value').html('');
    }
    var option = $(t).find('option:selected');
    var processType_id = selProcessType != '' ? selProcessType : $(option).val();
    if (typeof(main_div_id) == 'undefined') {
        main_div_id = 'chckIndex_1';
    }

    if (processType_id != '') {

        $('#' + main_div_id + ' .process_name_id').attr('data-where', 'process_type_id = ' + processType_id + ' AND created_by_cid=' + logged_user);
        $('#' + main_div_id + ' .process_name_id').attr('data-id', 'add_process');
        $('#' + main_div_id + ' .process_name_id').attr('data-key', 'id');
        $('#' + main_div_id + ' .process_name_id').attr('data-fieldname', 'process_name');

    }
}

/*machine name in job card*/
function getMachineName(evt, current, selProcess = '', closestDiv = '') {
    $(current).parents().closest('.well2').find('.machine_name_id').empty();
    $(current).parents().closest('.well2').find('.parameter_name').empty();
    $(current).parents().closest('.well2').find('.uom').empty();
    $(current).parents().closest('.well2').find('.value').empty();
    var option = $(current).find('option:selected');
    var process_name_id = selProcess != '' ? selProcess : $(option).val();
    if (process_name_id != '') {
        var like = '%"process":"' + process_name_id + '"%';
        $(current).closest('.well2').find('.machine_name_id').attr('data-where', "process LIKE '" + like + "' AND save_status=1");
        $(current).closest('.well2').find('.machine_name_id').attr('data-id', 'add_machine');
        $(current).closest('.well2').find('.machine_name_id').attr('data-key', 'id');
        $(current).closest('.well2').find('.machine_name_id').attr('data-fieldname', 'machine_name');
        $(current).closest('.well2').find('.machine_name_id').attr('name', 'machine_name[' + process_name_id + '][]');

    }
}


/*get material name from material issue table for job card 
	function getMaterialIssue(evt, t){
		var material_type_id = $(t).find('option:selected').val();
		var closestId = $(t).closest(".well").attr("id");
		console.log(closestId);
			$.ajax({
				type: "POST",
				url: site_url + 'production/getMaterial_IssueDetail',
				data: {id:material_type_id}, 
				success: function(result){  
					var obj = JSON.parse(result);
					//var obj = JSON.parse(JSON.stringify(result));  
					//console.log(obj);
					  var len = obj.length;
					 
						for(var i=0; i<len; i++){
							 var material_name = obj[i].material_name;
							 var material_id = obj[i].id;
							 var  DropdownMaterial = '<option value="'+material_id+'">'+ material_name   +'</option>';
							
							 $("#mat_name").append(DropdownMaterial);
							//$("#"+closestId+"").find('.materialNameId').append(DropdownMaterial);
						}
				}
			}); 
	}
*/
/*function to get material name through material type*/
function getMaterialIssue(evt, t) {
    var material_type_id = $(t).find('option:selected').val();
    getMaterials(material_type_id, 1, 'matChanged');

}

function getMaterials(material_type_id, x = '', matChanged = '') {
    //alert(55);
    if (matChanged == 'matChanged') {
        $('.materialId').empty();
    }
    var option = '';
    if (material_type_id) {
        $.ajax({
            type: 'POST',
            url: site_url + 'production/getMaterial_IssueDetail',
            data: {
                id: material_type_id
            },
            success: function(data) {
                var dataObj = JSON.parse(data);
                if (dataObj) {
                    console.log('dataObj===>>>', dataObj);
                    option = '<option value="">Select material</option>';
                    $(dataObj).each(function() {
                        option = option + '<option value="' + this.material_id + '" data-mat-id="' + this.id + '">' + this.material_name + '</option>';
                    });
                    if (matChanged == 'matChanged' || matChanged == 'edit') {
                        $('.materialId').append(option);
                    } else {
                        $('#chkIndex_' + x + ' .materialId').append(option);
                    }
                } else {
                    $('.materialId').html('<option value="">Material not available</option>');
                }
            }
        });
    } else {
        $('.materialId').html('<option value="">Select Material</option>');

    }
}




/*GET MATERIAL NAME*/
function getMaterialName(evt, t, selProcessType = '', c_id = '') {

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
        select2(material_type_id, logged_user);
    }
}

function select2(material_type_id, logged_user) {
    $('.materialNameId').attr('data-where', 'material_type_id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND status=1');
    $('.materialNameId').attr('data-id', 'material');
    $('.materialNameId').attr('data-key', 'id');
    $('.materialNameId').attr('data-fieldname', 'material_name');

}

/*fetching tax value on material elect*/
function getUom(evt, t) {
    setTimeout(function() {

        var option = $(t).find('option:selected');
        //var materialId = $('.materialId').val();

        var closestId = $(t).closest(".well").attr("id");
        console.log('closestId===>>>>', closestId);
        var materialId = $('#' + closestId + ' .materialNameId').val();
        $.ajax({
            type: "POST",
            url: site_url + 'production/getMaterialDataById',
            data: {
                id: materialId
            },
            success: function(data) {
                if (data != '') {
                    console.log('data===>>>', data);
                    //var dataObj = JSON.parse(data);
                    var dataObj = JSON.parse(data);
                    if (dataObj) {
                        console.log(dataObj);
                        var uom = dataObj.uom;
                        var opening_balance = dataObj.opening_balance;
                        var job_card = dataObj.job_card;
                        console.log("uom", uom);
                        $("#" + closestId + "").find('.uom').val(uom);
                        $("#" + closestId + "").find('.qty').val(opening_balance);
                        $("#" + closestId + "").find('.job_card').val(job_card);
                    }
                }
            }
        });
        var uom = $(this).find('.option').val();
        var closestId = $(t).closest(".well").attr("id");
    }, 1000);
}


/* Process Sechduling Code*/
function getUom_input(evt, t) {
    //setTimeout(function() {

    var option = $(this).find('option:selected');
    //var materialId = $('.materialId').val();

    var closestId = $(t).closest(".chk_idd_input").attr("id");
    //var materialId = (t.value || t.options[t.selectedIndex].value);  //crossbrowser solution =)

    var materialId = $('#' + closestId + ' .materialNameId').val();
    //alert(closestId);
    $.ajax({
        type: "POST",
        url: site_url + 'production/getMaterialDataById',
        data: {
            id: materialId
        },
        success: function(data) {
            if (data != '') {
                //console.log('data===>>>', data);
                //var dataObj = JSON.parse(data);
                var dataObj = JSON.parse(data);
                if (dataObj) {
                    console.log(dataObj);
                    var uom = dataObj.uom;
                    var uomid = dataObj.uomid;
                    var opening_balance = dataObj.opening_balance;
                    var job_card = dataObj.job_card;
                    console.log("uom ====>", uom);
                    console.log("opening_balance ===>", opening_balance);
                    var closestId = $(t).closest(".chk_idd_input").attr("id");

                    $("#" + closestId + "").find('.uom_input').val(uom);
                    $("#" + closestId + "").find('.uom_input_val').val(uomid);
                    $("#" + closestId + "").find('.qty_input').val(opening_balance);
                    $("#" + closestId + "").find('.job_card').val(job_card);

                }
            }
        }
    });
    var uom = $(this).find('.option').val();
    var closestId = $(t).closest(".well_Sech_input").attr("id");
    //}, 1000);
}




function getUom_output(evt, t) {
    setTimeout(function() {

        var option = $(t).find('option:selected');
        //var materialId = $('.materialId').val();

        var closestId = $(t).closest(".chk_idd_output").attr("id");

        var materialId = $('#' + closestId + ' .materialNameId').val();

        $.ajax({
            type: "POST",
            url: site_url + 'production/getMaterialDataById',
            data: {
                id: materialId
            },
            success: function(data) {
                if (data != '') {
                    console.log('datagetUom_output===>>>', data);
                    //var dataObj = JSON.parse(data);
                    var dataObj = JSON.parse(data);
                    if (dataObj) {
                        console.log(dataObj);
                        var uom = dataObj.uom;
                        var uomid = dataObj.uomid;
                        var opening_balance = dataObj.opening_balance;
                        var job_card = dataObj.job_card;
                        console.log("uom", uom);
                        var closestId = $(t).closest(".chk_idd_output").attr("id");
                        $("#" + closestId + "").find('.uom_output').val(uom);
                        $("#" + closestId + "").find('.uom_output_val').val(uomid);
                        $("#" + closestId + "").find('.qty_output').val(opening_balance);
                        $("#" + closestId + "").find('.job_card').val(job_card);
                    }
                }
            }
        });
        var uom = $(this).find('.option').val();
        var closestId = $(t).closest(".well_Sech_output").attr("id");
    }, 1000);
}

function addMaterial_inputDetail() {
    var input = 10;
    var input_mat = $(".well_Sech_input");
    var add_mat = $(".add_moreinputss");
    var logged_user = $('#loggedUser').val();
    //var y = 1; 
    var y = $('.chk_idd_input').length;
    //alert(y);
    $(add_mat).click(function(e) {

        var div_id = $(this).closest('.input_cls').attr('id');
        var div_len = $(".well_Sech_input").length;

        $('.input_val').val(y + 1);


        if (y < input) {
            y++;

            $(this).closest('#' + div_id).parent().append('<div class=" col-md-12 chk_idd_input" id="sechIndexinput_' + y + '" ><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" required="required" name="material_type_input_id_' + div_len + '[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  required="required" name="material_input_name_' + div_len + '[]" onchange="getUom_input(event,this);"><option value="">Select Option</option></select></div><div class="col-md-3 actual_qty col-sm-12 col-xs-12 form-group"><input type="text"  name="quantity_input_' + div_len + '[]" class="form-control col-md-7 col-xs-12  qty_input"  placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="uom_value_input1_' + div_len + '[]" class="form-control col-md-7 col-xs-12  uom_input" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_input_' + div_len + '[]" class="uom_input_val" readonly value=""></div> <div class="col-md-1 col-xs-12 col-sm-12 form-group remv_inputss" style="text-align: center;border-bottom: 1px solid #aaa;"><button class="btn btn-danger " type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div>');


            var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        getMaterials(mat_id, y);
        init_select2();
        getUom();
        getUom_input();
        getUom_output();

    });
    $(input_mat).on("click", ".remv_inputss", function(e) {
        e.preventDefault();

        $(this).parent('div').remove();
        y--;
        $('.input_val').val(y);
        keyupFunction(event, this);
    });
}

function addMaterial_outputDetail() {
    var input = 10;
    var input_mat = $(".well_Sech_output");
    var add_mat = $(".add_moreoutputss");
    var logged_user = $('#loggedUser').val();
    //var y = 1; 
    var y = $('.chk_idd_output').length;

    //alert(y);
    $(add_mat).click(function(e) {
        var div_id = $(this).closest('.output_cls').attr('id');
        var div_len = $(".well_Sech_output").length;
        $('.output_val').val(y + 1);

        if (y < input) {
            y++;
            $(this).closest('#' + div_id).parent().append('<div class="col-md-12 chk_idd_output" id="sechIndexoutput_' + y + '" style="padding:0px;"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" required="required" name="material_type_output_id_' + div_len + '[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  required="required" name="material_output_name_' + div_len + '[]" onchange="getUom_output(event,this);"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" name="quantity_output_' + div_len + '[]" class="form-control col-md-7 col-xs-12 actual_qty qty_output"  placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></div>   <div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="uom_value_output1_' + div_len + '[]" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_output_' + div_len + '[]" class="uom_output_val" readonly value=""></div><div class="col-md-1 col-xs-12 col-sm-12 form-group remv_output" style="text-align: center;border-bottom: 1px solid #aaa;"><button class="btn btn-danger " type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div></div>');


            var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        getMaterials(mat_id, y);
        init_select2();
        getUom();
        getUom_input();
        getUom_output();

    });
    $(input_mat).on("click", ".remv_output", function(e) {
        e.preventDefault();

        $(this).parent('div').remove();
        y--;
        $('.output_val').val(y);
        keyupFunction(event, this);
    });
}



/*Process Sechduling Code*/


/*fetching uom value on material elect*/
/*function get_Qty_UOm(){
	$('.materialNameId').on('change',function(){
		//var materialId =  $(this).find(":selected").attr('data-mat-id');
		var materialId =  $('.materialNameId').val();
		//console.log("sdfs",materialId);
		var closestId = $(this).closest(".well").attr("id");
		$.ajax({
			type: "POST",
			url: site_url + 'production/getQtyUom',
			data: {mat_id:materialId}, 
			success: function(data){
				if(data != '') {	
					var dataObj = JSON.parse(data);
				
					if(dataObj){
						$("#"+closestId +' .qty').val(dataObj[0].opening_balance);
						$("#"+closestId +' .uom').val(dataObj[0].inventory_unit);
					}
				}
			}
		}); 
	});
}
*/
/*add row in production data*/
function addMulitpleRow() {
    //var i = 0;
    var i = 1;
    ///var selectedWages_or_perpiece_Both = $(".selectedOption").val();
    $(".maintable").on("click", ".addRow", function() {
        i = parseInt($(this).parents().find('.dele').length) + 1;
        var disablPiece = '';
        var checkWages = '';
        var readonlylabourCosting = '';
        var disabledWages = '';
        var checkPiece = '';
        /*var selectedWages_or_perpiece_Both = $(".selectedOption").val();
        wagesPieceName = $(this).parents().closest('.rTableRow').find(".wages").attr('name');
        var arrayIndex = wagesPieceName.split('wages_or_per_piece').pop().split('_')[0];
        //console.log(arrayIndex.split('-',2);
        console.log('aa==>>',wagesPieceName.split('[',3));
        var a = wagesPieceName.split('wages_or_per_piece').pop();
        console.log('dddd==>>',a.split('[',3)[1]);
        var mainRowIndex = "["+a.split('[',3)[1];
        //console.log('mainRowIndex===>>>',mainRowIndex);
        var mainTrId = $(this).parents().closest('.rTableRow').attr("id");
        //var mainTrId = $(this).parents().closest('tr').attr("id");
        //console.log('dddd==>>',mainTrId.split('_',2));
        var mainTrIndex = mainTrId.split('index').pop().split('_')[1];
        //var radioValue = $(this).parents().closest('tr').find(".wages").val();
        /*if($('.wages').is(':checked')){
        	 disablPiece = 'disabled';
        	 checkWages = 'checked';
        	 readonlylabourCosting = 'readonly';
        }else if($('.per_piece_rate').is(':checked')){
        	 disabledWages = 'disabled';			
        	 checkPiece = 'checked';
        }*/
        var disablPiece = '';
        var checkWages = '';
        var readonlylabourCosting = '';
        var disabledWages = '';
        var checkPiece = '';
        var selectedWages_or_perpiece_Both = $(".selectedOption").val();
		var selected_department_idd = $('.department').find('option:selected').val();
         var compny_unit  = $('.compny_unit').find('option:selected').val();

        //var selectedWages_or_perpiece_Both = $(this).parents().closest('.rTableRow').find(".selectedOption").val();
        console.log('selectedWages_or_perpiece_Both', selectedWages_or_perpiece_Both);
        wagesPieceName = $(this).parents().closest('.rTableRow').find(".wages").attr('name');
        var arrayIndex = wagesPieceName.split('wages_or_per_piece').pop().split('_')[0];
        console.log('aa==>>', wagesPieceName.split('[', 3));
        var a = wagesPieceName.split('wages_or_per_piece').pop();
        console.log('dddd==>>', a.split('[', 3)[1]);
        var mainRowIndex = "[" + a.split('[', 3)[1];
        var mainTrId = $(this).parents().closest('.rTableRow').attr("id");

        var mainTrIndex = mainTrId.split('index').pop().split('_')[1];
        //***********code for option selected from setting*******/
        if (selectedWages_or_perpiece_Both == "wages") {
            disablPiece = 'disabled';
            checkWages = 'checked';
            readonlylabourCosting = 'readonly';
            console.log("gggg");
        } else if (selectedWages_or_perpiece_Both == "per_piece") {
            disabledWages = 'disabled';
            checkPiece = 'checked';
            console.log("fgrere");
        } else if (selectedWages_or_perpiece_Both == "both") {
            checkWages = 'checked';
            console.log("ffgf");
        }
        var dataWhere = $("#worker").attr("data-where");
        var dataWhereJobCard = $("#party_code").attr("data-where");

        var machineName = $(this).parents().closest('.rTableRow').find('.machine_name_id').val();
        var machineGrp = $(this).parents().closest('.rTableRow').find('.machnine_grp').val();
        var workerName = $(this).parents().closest('.rTableRow').find('.typeahead').val();
        var counter = $('#mytable tr').length - 1;

        var newRow = $("<div  class='rTableRow mobile-view' id='addFunc_" + i + "'>");

        var cols = "";
        // cols += '<td><input type="radio" id="radio_id_btn1" name="wages_or_per_piece['+mainTrIndex+']['+i+']_'+i+'" value="wages" checked="checked" class="wages"><label for="defaultRadio">Wages</label><input type="radio" id="radio_id_btn1" name="wages_or_per_piece['+mainTrIndex+']['+i+']_'+i+'" value="per_piece" class="per_piece_rate" ><label for="defaultRadio">Per Piece</label></td>';

        cols += '<div class="rTableCell"><label>Select</label><input type="radio" id="radio_id_btn1" name="wages_or_per_piece[' + mainTrIndex + '][' + i + ']_' + i + '" value="wages" ' + disabledWages + ' ' + checkWages + ' class="wages"><span for="defaultRadio">Wages</span><input type="radio" id="radio_id_btn1" name="wages_or_per_piece[' + mainTrIndex + '][' + i + ']_' + i + '" value="per_piece" class="per_piece_rate" ' + disablPiece + ' ' + checkPiece + '><span for="defaultRadio">Per Piece</span></div>';

        cols += '<div class="rTableCell"><label>Machine Name</label><input class="form-control col-md-2 col-xs-12 machine_name_id"  placeholder="Job number"  type="hidden" name="machine_name_id[' + mainTrIndex + '][' + i + ']_' + i + '" value="' + machineName + '"/><input class="form-control col-md-2 col-xs-12 machnine_grp"  placeholder=""  type="hidden" name="machnine_grp[' + mainTrIndex + '][' + i + ']_' + i + '" value="' + machineGrp + '"/></div>';

       // cols += '<div class="rTableCell"><label>Sale Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible sale_order_cls"  onchange="getMaterialNamesaleorder(event,this)" id ="sale_order" name="sale_order[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" data-id="sale_order" data-key="id" data-fieldname="so_order" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' AND save_status = 1 AND save_status = 1 OR approve = 1 OR complete_status = 1 AND disapprove = 0"><option value="">Select Option</option></select></div>';
	   
	   cols += '<div class="rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId"  onchange="getMaterialNameWorkorder(event,this)"  name="work_order[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option value="">Select Option</option></select><input type="hidden"  name="sale_order[' + mainTrIndex + '][' + i + ']_' + i + '"  value="" class="SelectedSaleOrder"></div>';

        cols += '<div class="rTableCell"><label>Product Name</label><select class="form-control dis party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId" id ="product_name" name="product_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div>';

        cols += '<div class="rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Number" readonly  type="text" value=""></div>';

        cols += '<div class=" rTableCell"><label>Process Name</label><select class="form-control process_name" name="process_name[' + i + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + i + '][0]" class="inpt_outpt_process" value=""></div>';


        cols += '<div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="' + dataWhere + '"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm"  name="npdm_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true"></select></div>';

        cols += '<div class="rTableCell"><label>Workers</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[' + mainTrIndex + '][' + i + '][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="' + dataWhere + '" width="100%"></select></div>';

        cols += '<div class="hrs rTableCell"><label>Hrs in wages,% in per piece</label><span class="show_msg" style="display:none;">Total %age should be 100</span></div>';

        cols += '<div class="rTableCell"><label>Production Output</label><input id="output ' + counter + '" class="form-control col-md-7 col-xs-12 output"  placeholder="output"  type="text" name="output[' + mainTrIndex + '][' + i + ']_' + i + '" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)" value="" /></div>';

        cols += '<div class="rTableCell"><label>Labour costing</label><input id="labour_costing' + counter + '" class="form-control col-md-7 col-xs-12 labour_costing" name="labour_costing[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="labour_costing"  type="text" value="" onkeypress="return float_validation(event, this.value)" onkeyup="keyupFun(event,this)" ' + readonlylabourCosting + ' ></div>';

        cols += '<div class="rTableCell"><label>Remarks</label><textarea id="remarks' + counter + '" class="form-control col-md-7 col-xs-12" name="remarks[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="remarks"  type="text"></textarea></div>';
        cols += '<div class="rTableCell"><button type="button" id="ibtnDel" class="dele btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></div>';
        newRow.append(cols);
        //tagsInput();
        //  newRow.insertAfter($(this).parents().closest('.rTableRow'));	
        var indexBefore = parseInt(mainTrIndex) + 1;


        console.log('ssss==>>', $("#index_" + indexBefore).length);
        if ($("#index_" + indexBefore).length > 0) {
            newRow.insertBefore("#index_" + indexBefore);
        } else {

            //newRow.insertAfter($(this).parents().closest('.rTableRow'));
            newRow.appendTo(".app_div");



        }

        //}			
        //newRow.insertAfter("#addFunc_"+ i);		
        console.log('aaaa===>>>', $(this).parents().closest('.rTableRow'));
        //  tagsInput();
        init_select2();
        init_select21();
        keyupFun();
        SelectOption();
        get_jobcard_on_select();
        getWorkerIds();
        //  getMaterialNamesaleorder();
        init_select2so();
        select_on_npdm_sale_order();
        i++;
        counter++;
    });
    $("div.maintable").on("click", "#ibtnDel", function(event) {
        $(this).closest(".rTableRow").remove();
        counter--;
    });
}


/*fetch job card in production data*/
function fetchJobCardValue() {
    $('.machine_name_id').each(function() {
        var id = $(this).val();
        var mcId = $(this);
        $.ajax({
            type: "POST",
            url: site_url + 'production/get_machine_data/',
            data: {
                id: id
            },
            success: function(result) {
                var dataObj = JSON.parse(result);
                if (dataObj) {
                    $(dataObj).each(function() {
                        var $row = $(this).closest("tr").find("td.job_card");
                        var job_card_value = this.job_card_no;
                        var job_card = $(mcId).closest('tr').find("input[name='job_no[]']").val(job_card_value);
                    });
                }
            }
        });
    });

}



/*production planning ad row TEST*/
/*function AddRowPlan(){
	//var dataWhereWorker = $("#worker").attr("data-where");
	//var dataWhereWorker = $("#current_login_com_id").val();
	//var dataWhereJobNo = $("#party_code").attr("data-where");
	//var dataWhereJobNo = $("#current_login_com_id").val();
	var i = 1;
	$(".rTable").on("click",".addR", function () {
	  var machineName = $(this).parents().closest('.rTableRow').find('.machine_name_id').val();
	  var machineGrp = $(this).parents().closest('.rTableRow').find('.machine_grp').val();
	  var dataWhereWorker = $("#current_login_com_id").val();
	 // var worker_id = $(this).parents().closest('.rTableRow').find('.worker_name').attr('data-worker-id');
	  //console.log('worker',worker);
	  var dataWhereJobNo = $("#current_login_com_id").val();
	  var counter =  $('#prodPlan ').length -1;
	  var newRow = $("<div class='rTableRow mobile-view'>");
	  var cols = "";
	  
	
 		
		cols += '<div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name_id"  placeholder="Job number"  type="hidden" name="machine_name_id[]" value="'+ machineName +'"/><input class="form-control col-md-2 col-xs-12 machnine_grp"  placeholder=""  type="hidden" name="machnine_grp[]" value="'+ machineGrp +'"/></div>';	
		
		
		
		cols += '<div class="rTableCell"><label>Party Specification</label><textarea id= "specification' + counter + '" class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[]"></textarea> </div>';
		
		cols += '<div class="rTableCell"><label>Job card product name</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible" id ="job_no' + counter + '" name="job_card_product_name[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="job_card" data-key="id" data-fieldname="job_card_product_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ dataWhereJobNo +'"></select></div>';
	     
		 
		cols += '<div class="rTableCell"><label>Worker</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker' + counter + '"  name="worker_name['+i+'][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ dataWhereWorker +' AND save_status = 1" width="100%"></select></div>';
		
		
		
		cols += '<div class="rTableCell"><label>Output</label><input id="output '+ counter +'" class="form-control col-md-7 col-xs-12 output"  placeholder="output"  type="text" name="output[]" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)" value="" /></div>';
		
	 cols += '<div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" id="btnDel" class="dele btn btn-danger btn-xs" value="Delete"></div>';
	  
	  
	  
	  
	  
	  //var a = 1;
	  
	  /*cols += ' <div class="rTableCell"><input  class="form-control col-md-2 col-xs-12 machine_name_id"  placeholder="machine name" type="hidden" name="machine_name_id[]" value="'+ machineName +'"/><input id="machine_grp" class="form-control col-md-2 col-xs-12 machine_grp"  placeholder="machine group" type="hidden" name="machine_grp[]" value="'+ machineGrp +'"/></div>';
	  
	  cols += '<div class="rTableCell"><textarea id= "specification' + counter + '" class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[]"></textarea> </div>';
	  
	  cols += '<div class="rTableCell tyt"><select class="form-control selectAjaxOption select2 select2-hidden-accessible" id ="job_no" name="job_card_product_name[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="job_card" data-key="id" data-fieldname="job_card_product_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ dataWhereJobNo +'"></div>';

	  //cols += '<div class="col-md-3 item form-group"><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="select2Opt"  name="worker_name['+counter+'][]" data-id="worker" data-key="name" data-fieldname="name" tabindex="-1"  data-where="created_by_cid='+ dataWhereWorker +' AND save_status = 1" ></select></div>';
	   //cols += '<div class="rTableCell worker-row""><select multiple class="worker_name form-control col-md-2 col-xs-12 " name="worker_name['+counter+'][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ dataWhereWorker +' AND save_status = 1" ></select></div>';
	    cols += '<div class="rTableCell worker-row""><input type="text" class="worker_name form-control col-md-2 col-xs-12 "></div>';
	  
	  cols += '<div class="rTableCell sfdsf"><input id="output' + counter + '" class="form-control col-md-7 col-xs-12"  placeholder="output"  type="number" name="output[]"/></div>';
	  
	  cols += '<div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" id="btnDel" class="dele btn btn-danger btn-xs" value="Delete"></div>';
	 // console.log("cols",cols);*/
/* newRow.append(cols);
	  newRow.insertAfter($(this).parents().closest('.rTableRow'));
	  
	  init_select2();
	  init_select21();
	  get_jobcard_on_select();
	  counter++;					 
		i++;					 
	});
	$(".app_div_planing").on("click", "#btnDel", function (event) {
		$(this).closest(".rTableRow").remove();
		counter--;	
	 });
	 $(".app_div_planing_similar").on("click", "#btnDel", function (event) {
		$(this).closest(".rTableRow").remove();
		counter--;	
	 });
}
*/
//Select Job card On select Party code


/*production planning ad row TEST*/
function AddRowPlan() {
    //var dataWhereWorker = $("#worker").attr("data-where");
    //var dataWhereWorker = $("#current_login_com_id").val();
    //var dataWhereJobNo = $("#party_code").attr("data-where");
    //var dataWhereJobNo = $("#current_login_com_id").val();
    var i = 1;
    $(".rTable").on("click", ".addR", function() {
        i = parseInt($(this).parents().find('.dele').length) + 1;
        var machineName = $(this).parents().closest('.rTableRow').find('.machine_name_id').val();
        var machineGrp = $(this).parents().closest('.rTableRow').find('.machine_grp').val();
        var dataWhereWorker = $("#current_login_com_id").val();
        //console.log(dataWhereWorker);
        var dataWhereJobNo = $("#current_login_com_id").val();
		var selected_department_idd = $('.department').find('option:selected').val();
		var compny_unit  = $('.compny_unit').find('option:selected').val();

        var TrId = $(this).parents().closest('.rTableRow').attr("id");
        console.log('TrId', TrId);
        var mainTrIndex = TrId.split('index').pop().split('_')[1];
        console.log('mainTrIndex', mainTrIndex);
        var counter = $('#prodPlan ').length - 1;


        var newRow = $("<div class='rTableRow mobile-view' id='addFunc_" + i + "'>");
        var cols = "";

        cols += '<div class="rTableCell"> <label>Machine Nameaaa<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name_id"  placeholder="Job number"  type="hidden" name="machine_name_id[' + mainTrIndex + '][' + i + ']_' + i + '" value="' + machineName + '"/><input class="form-control col-md-2 col-xs-12 machnine_grp"  placeholder=""  type="hidden" name="machnine_grp[' + mainTrIndex + '][' + i + ']_' + i + '"" value="' + machineGrp + '"/></div>';

        cols += '<div class="rTableCell"><label>Party Specification</label><textarea id= "specification' + counter + '" class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[' + mainTrIndex + '][' + i + ']_' + i + '""></textarea> </div>';


       // cols += '<div class="rTableCell"><label>Sale Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible sale_order_cls"  onchange="getMaterialNamesaleorder(event,this)" id ="sale_order" name="sale_order[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" data-id="sale_order" data-key="id" data-fieldname="so_order" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' AND save_status = 1 OR approve = 1 OR complete_status = 1 AND disapprove = 0"><option value="">Select Option</option></select></div>';
	   
	   cols += '<div class="rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId"  onchange="getMaterialNameWorkorder(event,this)"  name="work_order[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option value="">Select Option</option></select><input type="hidden"  name="sale_order[' + mainTrIndex + '][' + i + ']_' + i + '"  value="" class="SelectedSaleOrder"></div>';

        cols += '<div class="rTableCell"><label>Product Name</label><select class="form-control dis party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId" id ="product_name" name="product_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" tabindex="-1" aria-hidden="true"></select></div>';

        cols += '<div class="rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Number" readonly  type="text" value=""></div>';
		cols += '<div class=" rTableCell"><label>Process Name</label><select class="form-control process_name" name="process_name[' + mainTrIndex + '][' + i + ']_' + i + '"  ></select></div>';
        cols += '<div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + dataWhereJobNo + '"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" name="npdm_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div>';

        cols += '<div class="rTableCell"><label>Worker</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker' + counter + '"  name="worker_name[' + mainTrIndex + '][' + i + '][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + dataWhereWorker + ' AND save_status = 1" width="100%"></select></div>';

        cols += '<div class="rTableCell"><label>Output</label><input id="output ' + counter + '" class="form-control col-md-7 col-xs-12 output"  placeholder="output"  type="text" name="output[' + mainTrIndex + '][' + i + ']_' + i + '" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)" value="" /></div>';

        cols += '<div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><button type="button" id="btnDel" class="dele btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></div>';

        newRow.append(cols);
        var indexBefore = parseInt(mainTrIndex) + 1;
        if ($("#index_" + indexBefore).length > 0) {
            newRow.insertBefore("#index_" + indexBefore);
        } else {
            newRow.appendTo(".app_div_planing");
        }
        init_select2();
        init_select21();
        get_jobcard_on_select();
        init_select2so();
        select_on_npdm_sale_order();
        i++;
        counter++;
    });

    $("div.mainPlantable ").on("click", "#btnDel", function(event) {
        $(this).closest(".rTableRow").remove();
        counter--;
    });


}



function get_jobcard_on_select() {
    $('.party_code_cls').on('change', function() {
        var party_code_id = $(this).val();
        //alert(party_code_id);
        var card_nothis_val33 = $(this);
        console.log('jaaaa===>>>', $(this).closest('.rTableRow').attr('id'));
        $.ajax({
            type: "POST",
            url: site_url + 'production/get_party_jobcard',
            data: {
                party_code_id: party_code_id
            },
            success: function(result) {
                var dataObj = JSON.parse(result);
                console.log('dataObj===>>>', dataObj);
                //alert(JSON.stringify(dataObj));
                //var card_no =  dataObj[0]['job_card_no'];
                var job_card_product_id = dataObj[0]['id'];
                //alert(job_card_product_id);
                var job_card_product_name = dataObj[0]['job_card_no'];
                //var process_naam =  dataObj[0]['process_name'];

                console.log('job_card_product_name===>>>', job_card_product_name);

                var closestId = $(card_nothis_val33).closest('.rTableRow').attr('id');
                //console.log('ccccc===>>>',$(closestId).find("input[name='job_card_product_name[]']").val(job_card_product_name));
                console.log('jaaaa===>>>', $(card_nothis_val33).closest('.rTableRow').attr('id'));
                var closestTr = $(card_nothis_val33).closest('.rTableRow').attr('id');


                $("#" + closestTr).find(".job_card").val(job_card_product_name);
                $("#" + closestTr).find(".job_card_product_id").val(job_card_product_id);
                //$(card_nothis_val33).parent().next('td').find("input[name='job_card_product_name[]']").val(job_card_product_name);
                //$(card_nothis_val33).parent().next('td').find("input[name='job_card_product_id[]']").val(job_card_product_id);
            }
        });
        setTimeout(function() {
            var closestTr = $(card_nothis_val33).closest('.rTableRow').attr('id');
            var job_card_no = $("#" + closestTr).find(".job_card_product_id").val();
            //alert(job_card_no);
            $.ajax({
                type: "POST",
                url: site_url + 'production/get_processtype_jobcard',
                data: {
                    job_card_noo: job_card_no
                },
                success: function(htmlstr) {
                    var closestTr = $(card_nothis_val33).closest('.rTableRow').attr('id');

                    $("#" + closestTr).find(".process_name").html(htmlstr);
                }
            });


        }, 1000);
    });

    $('.process_name').on('change', function() {
        var get_closest_idd = $(this);
		        var closestTr = $(get_closest_idd).closest('.rTableRow').attr('id');

        var process_input = $("#" + closestTr).find('.process_name option:selected').attr('data-in');
        //var process_output = $('#process_name option:selected').attr('data-ot');
        // console.log('json data INPUT===>>>',process_input);
        // console.log('json data OUTPUT ===>>>',process_output);
        $("#" + closestTr).find(".inpt_outpt_process").val(process_input);
        //$("#"+closestTr).find("#otpt_process").val(process_output);

    });




}




$(function() {
    var text = $('#tags').text();
    var wordsCount = text.split(',').length;
    $('#output').html('words count: ' + wordsCount);
});


/*rpodcution data filter datewise*/
/*
$(function() {
	$('input[name="productionData"]').daterangepicker({
		opens: 'left'
		}, function(start, end, label) {
			var fromDate = start.format('YYYY-MM-DD');
			var toDate = end.format('YYYY-MM-DD');
			var table = $('input[name="activityRelTable"]').val();
			$.ajax({        
				url: site_url +'production/filterProductionData/',
				dataType: 'json',
				type: 'POST',
				data: {
					
					fromDate: fromDate,            
					toDate: toDate,            
					table: table,   
					
				},
				success: function(result){
					console.log(result);
					var activityLog = '';
					//console.log(activityLog);
					$(result).each(function( i ) {
						activityLog += '<tr><td>'+this.id+'</td><td>'+this.date+'</td>';
						if(this.production_data !=''){
							var proddata = JSON.parse(this.production_data);
								activityLog += '<td><table id="datatable-buttons prodData" class="table table-striped table-bordered user_index jambo_table bulk_action" data-id="user"><thead>	<tr><th>Machine Name</th><th>Job no.</th><th>Worker</th><th>Material Consumed</th><th>Output</th><th>Wastage</th><th>Electricity</th><th>Costing</th></tr></thead>';
									
									$(proddata).each(function(index){
										
										activityLog += '<tr><td class="combat">'+this.machine_name+'</td><td class="combat">'+this.job_no+'</td><td class="combat">'+this.worker+'</td><td class="combat">'+this.material_consumed+'</td><td class="combat">'+this.output+'</td><td class="combat">'+this.wastage+'</td><td class="combat">'+this.electricity+'</td><td class="combat">'+this.costing+'</td></tr>';
											
											
										
										 // totalPoints = parseFloat($(this).worker) + totalPoints);
										var total = 0;
										var worker = +this.worker;
										var abc = parseInt(worker) + parseInt(total);
											console.log(abc);
									}); 
							  										
							activityLog += '</td>';
						}	
						activityLog += '</tr></table>';	
						
					});								
					
					$('.prodData').html(activityLog);
					
				}			
			});
		},	
	)	
});

/*prodcution planning filter datewise*/
/*$(function() {
	$('input[name="productionPlan"]').daterangepicker({
		opens: 'left'
		}, function(start, end, label) {
			var fromDate = start.format('YYYY-MM-DD');
			var toDate = end.format('YYYY-MM-DD');
			var table = $('input[name="planningRelTable"]').val();
			
			$.ajax({        
				url: site_url +'production/filterProductionPlanning/',
				dataType: 'json',
				type: 'POST',
				data: {
					
					fromDate: fromDate,            
					toDate: toDate,            
					table: table,   
					
				},
				success: function(result){
					
					var PlanningLog = '';
					//console.log(activityLog);
					$(result).each(function( i ) {
						PlanningLog += '<tr><td>'+this.id+'</td><td>'+this.date+'</td>';
						if(this.planning_data !=''){
							var prodPlan = JSON.parse(this.planning_data);
								PlanningLog += '<td><table id="datatable-buttons prodplan" class="table table-striped table-bordered user_index jambo_table bulk_action" data-id="user"><thead>	<tr><th>Machine Name</th><th>Job no.</th><th>Worker</th><th>Material Consumed</th><th>Output</th><th>Wastage</th></tr></thead>';
									$(prodPlan).each(function(index){
										PlanningLog += '<tr><td>'+this.machine_name+'</td><td>'+this.job_no+'</td><td>'+this.worker+'</td><td>'+this.material_consumed+'</td><td>'+this.output+'</td><td>'+this.wastage+'</td></tr>';		
									}); 										
							PlanningLog += '</td>';	
						}	
						PlanningLog += '</tr></table>';	
					});	
					$('.prodplan').html(PlanningLog);
				}			
			});
		},	
	)	
});

*/

$(document).ready(function() {
    $('.machine_name_id').each(function() {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: site_url + 'production/get_machine_data/',
            data: {
                id: id
            },
            /*success: function(data){
            	if(data != '') {	
            		$('#productionSetting').modal('show');
            		$('#productionSetting .modal-body-content').html(data);
            			
            	}
            }*/
        });
    });
});


/**********************production scheduling*************************************/
$(document).ready(function() {

    //var today= new Date();
    //var currMonth = today.getMonth();			
    //$('#month').val(currMonth + 1);
    //var days  = $('#selectedMonth').attr('id');
    //console.log(days);
    if ($('div').hasClass('abc')) {
        getDays();
    } else {
        console.log("ds");
    }

});

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

function getDays() {
    //alert($('.machine_name').text());
    var machineName = JSON.parse($('.machine_name').text());
    var shiftData = JSON.parse($('.shifts').text());
    var boxes = "";
    //var selectedMonth = $('#month').val();
    var selectedMonthYear = $('#selectedMonth').val();
    //console.log('selectedMonth===>>',selectedMonth);
    //console.log('sssssselectedMonth===>>',selectedMonth.split("-"));
    var date = selectedMonthYear.split("-");
    if (selectedMonthYear == '') {
        var month = (new Date().getMonth()) + 1;
        month = (month < 10) ? '0' + month : '' + month;
        //var selectedMonth = new Date().getMonth();		
        var selectedMonth = month;
        var selectedYear = new Date().getFullYear();
        $('#selectedMonth').val(selectedMonth + '-' + selectedYear);
    } else {
        var selectedMonth = date[0];
        var selectedYear = date[1];
    }
    //var CurrentYear = new Date().getFullYear();
    //var CurrentYear = new Date().getFullYear();
    //var selectedYear = date[1];	
    //var days = daysInMonth(selectedMonth,CurrentYear);
    var days = daysInMonth(selectedMonth, selectedYear);
    var measurmentArray = '';
    $.each(measurementUnits, function(key, value) {
        measurmentArray = measurmentArray + '<option value="' + value + '">' + value + '</option>';
    });
    var mcLength = machineName.length + 1;
    //boxes =+ '<input type="hidden" name="date" value="'+selectedMonth +'-'+ selectedYear +'">';
    boxes += '<table class="table table-striped">';
    for (var i = 0; i < mcLength; i++) {
        boxes += '<tr>';
        if (i == 0) {
            boxes += '<td>Machine Name</td>';
        } else if (i >= 1) {
            boxes += '<td><input type="hidden" name="prodSch[' + i + '][machine].machine[]" value="' + machineName[i - 1].id + '">' + machineName[i - 1].machine_name + '</td>';
        }
        if (i == 0) {
            for (var j = 1; j <= days; j++) {
                $(shiftData).each(function() {
                    var shift = $(this);
                    boxes += '<td>';
                    boxes += '' + j + ' /' + selectedMonth + ' /' + selectedYear + ' (' + shift[0].shift_name + ')';
                    boxes += '</td>';
                });
            }
        } else if (i >= 1) {
            var l = 1;
            for (k = 1; k <= days; k++) {
                $(shiftData).each(function() {
                    var shift = $(this);
                    boxes += '<td class="droptarget">';
                    boxes += '<select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="prodSch[' + i + '][job_card][' + l + '].job_card[]" data-id="job_card" data-key="id" data-fieldname="job_card_no" tabindex="-1" data-where="save_status = 1" aria-hidden="true"><option value="">Select Option</option></select><br><br><input type="number" name="prodSch[' + i + '][production][' + l + '].production[]" value="" class="production"><br><br><select class="form-control" name="prodSch[' + i + '][uom][' + l + '].uom[]" class="uom">"' + measurmentArray + '"</select>';
                    boxes += '</td>';
                    l++;
                });
            }
        }
        boxes += '</tr>';
    }
    boxes += '</table>';
    $('#days').html(boxes);
    init_select2();
}


$(document).on('click', '#save', function(e) {
    var data = $("#productionScheduling").serialize();
    console.log('data====>>>', data);
    $.ajax({
        data: data,
        type: "post",
        url: site_url + "production/saveProductionScheduling",
        success: function(data) {
            //alert(data);
        }
    });
});


$(document).on('click', '#update', function(e) {
    var data = $("#updateProductionScheduling").serialize();
    console.log('data====>>>', data);
    $.ajax({
        data: data,
        type: "post",
        url: site_url + "production/updateProductionScheduling",
        success: function(data) {
            // alert(data);
        }
    });
});



$('#psMonthYear').datetimepicker({
    format: 'MM-YYYY',
    useCurrent: true
})

$("#psMonthYear").on("dp.change", function(e) {
    //$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    getDays();
});

/*sale order*/
$(document).on("click", ".sale_order", function(ev) {
    console.log("hello");
    ev.preventDefault();
    var id = $(this).attr('id');
    var tab = $(this).attr('data-id');
    var url = '';

    switch (tab) {
        case 'sale_order_view':
            url = 'production/viewSaleOrder';
            break;
        case 'sale_order_dispatch':
            url = 'production/dispatchSaleOrder';
            break;
    }
    $.ajax({
        type: "POST",
        url: site_url + url,
        data: {
            id: id
        },
        success: function(data) {
            if (data != '') {
                $('#production_sale_order').modal('show');

                $('#production_sale_order .modal-body-content').html(data);
                $('#dispatchDate').daterangepicker({
                    singleDatePicker: true,
                    minDate: new Date(),
                    singleClasses: "picker_3",
                    locale: {
                        format: 'YYYY-MM-DD',
                    }
                }, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });



            }
        }
    });
});




/*******************************PROCESS SCHEDULING DRAGABABLE *******************************************/


/*function draggableSaleOrderInit() {
	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {	
		//console.log('ssssssssssss=>',$(this).attr("data_sale_order_id"));	
		sourceId = $(this).attr("data_sale_order_id");
		console.log('sourceId====>>>',sourceId);
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
		
	});
	$('.panel-body').bind('dragover', function (event) {
		event.preventDefault();		
	});
	$('.panel-body').bind('drop', function (event) {	
		/*console.log('ssssssssssss=>',$(this));	
		var children = $(this).children();
		//var targetId = children.attr('id');
		var targetId = $(this).attr("data_sale_order_id");
		console.log('targetId====>>>',targetId);
		if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
			$('#processing-modal').modal('toggle'); //before post
			// Post data 
			setTimeout(function () {
				var element = document.getElementById(elementId);
				children.prepend(element);
				$('#processing-modal').modal('toggle'); // after post
			}, 1000);
		}*/
/*$(".kanban-centered").sortable({			
			connectWith: ".kanban-centered",
			scroll: false,
			cursor:'pointer',
			revert:true,
			opacity:0.4,
			update: function() {
					//sendOrderToServer();
					sendSaleOrderPriorityToServer();
				 }
			}).disableSelection();
			event.preventDefault();
	});	
}			
 
 
 function sendSaleOrderPriorityToServer() {
	
	  var order = [];
		$('.saleOrder').each(function(index,element) {
			console.log('element====>>>>>',element);
			order.push({
				//id: $(this).attr('data_sale_order_id'),
				id: $(this).attr('data_sale_order_priority_id'),
				position: index+1,
				priority: $(this).attr('data_priority'),
			});
		console.log('order===>>>',order);
		});
	  $.ajax({
		type: "POST", 
		dataType: "json", 
		url: site_url+'production/changeSaleOrderPriority/',
		data: {
		  order:order,
		},
		success: function(response) {
			if (response.status == "success") {
			  console.log(response);
				$('#processing-modal').modal('toggle'); //before post			
				setTimeout(function () {
					$('#processing-modal').modal('toggle'); // after post
				}, 1000);
			} else {
			  console.log(response);
			}
		}
	 });
	 
}*/


function draggableSaleOrderInit() {
    var source_Id;
    $('[draggable=true]').bind('dragstart', function(event) {
        //console.log('ssssssssssss=>',$(this).attr("data_sale_order_id"));	
        source_Id = $(this).attr("data_sale_order_id");
        console.log('source_Id====>>>', source_Id);
        event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));

    });
    $('.panel-body').bind('dragover', function(event) {
        event.preventDefault();
    });
    $('.panel-body').bind('drop', function(event) {
        //console.log("ffffsdasdas");
        /*console.log('ssssssssssss=>',$(this));	
        var children = $(this).children();
        //var targetId = children.attr('id');
        var targetId = $(this).attr("data_sale_order_id");
        console.log('targetId====>>>',targetId);
        if (sourceId != targetId) {
        	var elementId = event.originalEvent.dataTransfer.getData("text/plain");
        	$('#processing-modal').modal('toggle'); //before post
        	// Post data 
        	setTimeout(function () {
        		var element = document.getElementById(elementId);
        		children.prepend(element);
        		$('#processing-modal').modal('toggle'); // after post
        	}, 1000);
        }*/
        //$(".kanban-centered").sortable({			
        $(".kanban-centered").sortable({
            connectWith: ".kanban-centered",
            scroll: false,
            cursor: 'pointer',
            revert: true,
            opacity: 0.4,
            update: function() {

                //sendOrderToServer();
                sendSaleOrderPriorityToServer();
            }
        }).disableSelection();
        event.preventDefault();
    });
}


function sendSaleOrderPriorityToServer() {

    //console.log("ggg");
    /* var sale_order = [];	 
			$('.saleOrder').each(function(index,element) {
				//console.log('element====>>>>>',element);			
				sale_order.push({
					id: $(this).attr('data_sale_order_id'),
					//id: $(this).attr('data_machine_id'),
					position: index+1,
					
					//priority: $(this).attr('data_priority'),
				});		
			});		
		  $.ajax({
			type: "POST", 
			dataType: "json", 
			url: site_url+'production/changeSaleOrderPriority/',
			data: {
			  sale_order:sale_order,
			},
			success: function(response) {
				;
				if (response.status == "success") {
				 // console.log(response.status);
					$('#processing-modal').modal('toggle'); //before post			
					setTimeout(function () {
						$('#processing-modal').modal('toggle'); // after post
					}, 1000);
				} else {
				  console.log(response);
				}
			}
		 });*/
    var order = [];

    $('.saleOrder').each(function(index, element) {
        //console.log("index",index);
        //console.log("element",element);
        //console.log("id",$(this).attr('data_sale_order_id'));
        order.push({
            id: $(this).attr('data_sale_order_id'),
            position: index + 1,
        });

    });

    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url + 'production/changeSaleOrderPriority/',
        data: {
            order: order,
        },
        success: function(response) {
            if (response.status == "success") {
                console.log(response);
                $('#processing-modal').modal('toggle'); //before post			
                setTimeout(function() {
                    $('#processing-modal').modal('toggle'); // after post
                }, 1000);
            } else {
                console.log(response);
            }
        }
    });

}




/*dshboard graphs*/

$(document).ready(function(e) {
    //getDashboardCount();
    getPoductionDataListingGraph();
    getProductionPlanning();
    getComparison();
});

/*   Show Upper counts from each module of CRM  
	function getDashboardCount(startDate = '' , endDate = ''){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({        
				//url: site_url +'crm/getDashboardCount/',
				url: site_url +'production/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){
					console.log('response===>>',response);	
					var dashboardCountHtml = '';	
					$.each( response.getDashboardCount, function( key, value ) {
						dashboardCountHtml += '<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12"><div class="tile-stats"><div class="icon"><i class="'+value.icon+'"></i></div><div class="count">'+value.totalAmount+'</div><h3>'+value.name+'</h3></div></div>';
					});
					$('.top_tiles').html(dashboardCountHtml);
					
				}			
			});
	}
/*  Dashboard filteration data */
$('.dashboardFilter').daterangepicker({
    opens: 'left',
    useCurrent: true,
    startDate: moment().startOf('month'),
    endDate: moment().startOf('hour'),
    locale: {
        format: 'DD-MM-YYYY',
    },
}, function(start, end, label) {
    var startDate = start.format('YYYY-MM-00 00:00:00');
    var endDate = end.format('YYYY-MM-00 00:00:00');
    var dateRangeHtml = $(this)[0].element.context;
    $("#graph_Indent").empty();
    getPoductionDataListingGraph(startDate, endDate);
    getProductionPlanning(startDate, endDate);
    getComparison(startDate, endDate);


});



/*bar graph for material listing*/
function getPoductionDataListingGraph(startDate = '', endDate = '') {
    if ($('#graph_Indent').length) {
        if (startDate != '' && endDate != '') {
            var ajaxData = {
                'startDate': startDate,
                'endDate': endDate
            };
        } else {
            var ajaxData = {};
        }
        $.ajax({
            url: site_url + 'production/graphDashboardData/',
            dataType: 'json',
            type: 'POST',
            data: ajaxData,
            success: function(result) {

                result = result.getPoductionDataListingGraph;
                //console.log('rrrrrrrrrr===>>',result.data);
                /*	$(result).each(function(){
                		var graphData = this.data;
                		console.log('graphData===>>>>',graphData);
                		
                });*/

                Morris.Bar({
                    element: 'graph_Indent',
                    data: result,
                    //data: abc,
                    xkey: 'month',
                    barColors: ['#26B99A', '#34495E', '#B22222', '#BA00C7', '#122AFF', '#FF2525'],
                    ykeys: ['sumOutput'],
                    labels: ['sumOutput'],
                    //ykeys: ['44','sumWastage' , 'sumElectricity', 'sumOutput' ,'sumCosting' , 'sumDowntime'],
                    //labels: ['sumConsumed','sumWastage','sumElectricity' , 'sumOutput' ,'sumCosting' , 'sumDowntime'],
                    hideHover: 'auto',
                    xLabelAngle: 60,
                    resize: true
                });

            }
        });
    }
}

/*bar graph for material listing*/
function getProductionPlanning(startDate = '', endDate = '') {
    if ($('#graph_Indent1').length) {
        if (startDate != '' && endDate != '') {
            var ajaxData = {
                'startDate': startDate,
                'endDate': endDate
            };
        } else {
            var ajaxData = {};
        }
        $.ajax({
            url: site_url + 'production/graphDashboardData/',
            dataType: 'json',
            type: 'POST',
            data: ajaxData,
            success: function(result) {

                result = result.getProductionPlanning;
                //console.log("plan",result);

                Morris.Bar({
                    element: 'graph_Indent1',
                    data: result,
                    xkey: 'month',
                    barColors: ['#26B99A', ],
                    ykeys: ['sumOutput'],
                    labels: ['sumOutput'],
                    hideHover: 'auto',
                    xLabelAngle: 60,
                    resize: true
                });
            }
        });
    }
}


function getComparison(startDate = '', endDate = '') {
    if ($('#graph_area1').length) {
        //if ($('#lineChart').length ){	
        if (startDate != '' && endDate != '') {
            var ajaxData = {
                'startDate': startDate,
                'endDate': endDate
            };
        } else {
            var ajaxData = {};
        }
        $.ajax({
            url: site_url + 'production/graphDashboardData/',
            dataType: 'json',
            type: 'POST',
            data: ajaxData,
            success: function(result) {
                //alert(JSON.stringify(result));
                console.log("dfdf");
                result = result.getComparison;
                console.log("rsssss", result);
                Morris.Area({
                    element: 'graph_area1',
                    data: result,
                    xkey: 'date',
                    ykeys: ['sumOutput'],
                    lineColors: ['#26B99A'],
                    labels: ['Output'],
                    pointSize: 1,
                    hideHover: 'auto',
                    resize: true
                });
            }
        });
    }
}

//For Workers add on the spot  
function for_add_multiple_tags_for_worker() {

    //$('#worker').select2({
    $('.workername').select2({
        //dropdownCssClass: 'custom-dropdown'
        allowClear: true,
        placeholder: 'Select And Begin Typing',
        //multiple:true,
        tags: true,
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
        } //,language: {
        // noResults: function() {
        // return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Open Model</a>";
        // }
        // },escapeMarkup: function (markup) {
        // return markup;
        // }
    });

}
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

$('#bbtn').on('click', function() {
    printData();
})
//Print Function


function addMoreDepartments() {
    var maxDepartment = 10; //maximum input boxes allowed
    var departmentDiv = $(".departmentDiv"); //Fields wrapper
    var add_department = $(".addMoreDepartment"); //Add button ID
    var y = 1; //initlal text box count
    $(add_department).click(function(e) { //on add input button click
        e.preventDefault();
        if (y < maxDepartment) { //max input box allowed
            y++;
            $(departmentDiv).append('<div class="well" id="chkIndex_' + y + '"><div class="col-md-12 col-sm-6 col-xs-12 form-group"><input type="text" id="departmentName" name="name[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Dapertment name" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
        }
    });
    $(departmentDiv).on("click", ".remve_field", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
    });
}

function get_company_location(evt, t) {
    $('.get_location').select2({
        allowClear: true,
        placeholder: 'Select And Begin Typing',
        closeOnSelect: true,
        ajax: {
            url: site_url + '/production/getcompany_unit',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
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

function get_company_unit(evt, t) {
    $('.get_unit').select2({
        allowClear: true,
        placeholder: 'Select And Begin Typing',
        closeOnSelect: true,
        ajax: {
            url: site_url + '/production/get_companyunit',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
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

function get_company_department() {

    //compny_unit 
    //$('.compny_unit').trigger('change');
    /*if($('.compny_unit').find('option:selected').val() != ''){
    	alert(876);
    	getDepartmentsByUnit($('.compny_unit').find('option:selected').val());
    }*/

    /*$('.compny_unit').on('change',function(){	
    		//alert(767);
    		var selected_unit_name =  $(this).val();
    		$('.depart_cls').html('<option value=" ">Select</option>');
    		$('.Get_machine_accor_to_depart').html('<option value=" ">Select</option>');//For Production Data
    		$('.Get_machine_accor_to_depart_Planing').html('<option value=" ">Select</option>');//For Production Planing
    		/*$.ajax({
    			type: "POST",
    			url: site_url + 'production/company_department',
    			data: {unit_name:selected_unit_name}, 
    			success: function(result){
    				var dataObj = JSON.parse(result);
    				var len = dataObj.length;
    				for(var i=0; i<len; i++){
    					var department_name = dataObj[i].name;
    					var selected_dpart_id = dataObj[i].id;
    					var depart_option = '<option data-id = "'+ selected_dpart_id +'" value="'+ department_name +'">'+ department_name +'</option>';
    					$('.depart_cls').append(depart_option);
    					$('.Get_machine_accor_to_depart').append(depart_option);//For Production Data
    					$('.Get_machine_accor_to_depart_Planing').append(depart_option);//For Production Planing
    				}	
    			}
    		}); */

    //getDepartmentsByUnit(selected_unit_name);
    //}); */




    $('.depart_cls').on('change', function() {
        setTimeout(function() {
            var selected_idd = $('.depart_cls').find('option:selected').attr('data-id');
            $('#department_id').val(selected_idd);
        }, 1000);

    });

    var edit_id = $('#edit_id').val();
    if (edit_id > 0) {
        $('.btn_heading_hide').show();
    } else {
        $('.btn_heading_hide').hide();
    }

    //$('.Get_machine_accor_to_depart').on('change',function(){
    //$('.department').on('change',function(){
    $('.date').on('change', function() {
        if (window.location.href == site_url + 'production/production_data') {
            $('#processing_loader').modal('toggle');
            setTimeout(function() {
                //var selected_department_idd = $('.Get_machine_accor_to_depart').find('option:selected').attr('data-id');
                var selected_department_idd = $('.department').find('option:selected').val();
                var compny_unit  = $('.compny_unit').find('option:selected').val();
                var current_login_com_id = $('#current_login_com_id').val();
                var date = $('#date').val();
                var shift = $('input[type="radio"]:checked').val();
                $('#department_id').val(selected_department_idd);
                $('.app_div').html('');
                $('.btn_heading_hide').show();
                $.ajax({
                    type: "POST",
                    url: site_url + 'production/get_production_data_according_toDeprtment',
                    data: {
                        'selected_department_idd': selected_department_idd,
                        'shift': shift,
                        'date': date,
                        'table': 'production_data'
                    },
                    success: function(result1) {

                        if (result1 == 'Data of this date and shift already exist') {
                            $(".app_div").append('<h2 style="color:red;">' + result1 + '</h2>');
                            //$(".app_div_productionData_similar").append('<h2 style="color:red;">'+result1+'</h2>');


                        } else {
                            console.log("result=>>>>>>>>>>>>", result1);
                            var dataObj1 = JSON.parse(result1);
                            var machineData = dataObj1.Machine;
                            var wagesData = dataObj1.wages;
                            if (wagesData == '') {
                                $('.app_div').append("<h5 style='color:red;'>Select Wages or per piece From Production Setting</h5>");
                            } else {
                                var lenth = machineData.length;
                                if (lenth != 0) {
                                    var k = 0;
                                    var i = 0;

                                    $('<div class="rTableRow mobile-view2"><div class="rTableHead"><label>Select</label></div><div class="rTableHead"><label>Machine Name</label></div><div class="rTableHead"><label>Work order</label></div><div class="rTableHead"><label>Product Name</label></div><div class="rTableHead"><label>BOM Routing Product Name</label></div><div class="rTableHead"><label>Process Name</label></div><div class="rTableHead"><label>NPDM</label></div><div class="rTableHead fix-width"><label>Workers</label></div>  <div class="rTableHead fix-width"><label>Hrs in Wages,% in per piece</label></div><div class="rTableHead"><label>Production Output</label></div><div class="rTableHead"><label>Labour costing</label></div><div class="rTableHead" ><label>Remarks</label></div><div class="rTableHead"></div></div>"').prependTo(".app_div");
                                    for (var j = 0; j < lenth; j++) {

                                        var machnine_nam = machineData[j].machine_name;
                                        var machnine_id = machineData[j].id;
                                        var machnine_grp = machineData[j].machine_group_id;
                                        var Wages_perpeice = wagesData[0].wages_perpiece;
                                        //console.log("console.log>>>>>>>",Wages_perpeice);
                                        // if(Wages_perpeice == ''){
                                        // console.log("gggg");
                                        // }
                                        var check = '';
                                        var disbaled = '';
                                        var checkPerpiece = '';
                                        var disabledWages = '';
                                        var readonlyLabourCosting = '';
                                        if (Wages_perpeice == 'wages') {
                                            check = 'checked';
                                            disbaled = 'disabled';
                                            readonlyLabourCosting = 'readonly';
                                        } else if (Wages_perpeice == 'per_piece') {
                                            checkPerpiece = 'checked';
                                            disabledWages = 'disabled';
                                        } else if (Wages_perpeice == 'both') {
                                            check = 'checked';
                                        }


                                        var machine_append_Data = '<div id="index_' + i + '" class="rTableRow mobile-view"><div class=" rTableCell" style="padding: 3px 10px;"><label>Select</label><input type="hidden" value="' + Wages_perpeice + '" name="wage_perpiece_both" class="selectedOption"><input type="radio" id="radio_id_btn1" name="wages_or_per_piece[' + i + '][0]_' + i + '" checked value="wages" ' + check + ' class="wages" ' + disabledWages + '><span for="defaultRadio">Wages</span><input type="radio" id="radio_id_btn1" name="wages_or_per_piece[' + i + '][0]_' + i + '" value="per_piece" class="per_piece_rate" ' + checkPerpiece + ' ' + disbaled + '><span for="defaultRadio">Per Piece</span></div><div class=" rTableCell"><label>Machine Name</label><input data-toggle="tooltip" class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[' + i + '][0]" placeholder="Machine Name"  type="text" value="' + machnine_nam + '" title="' + machnine_nam + '" readonly><input  data-toggle="tooltip" class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + i + '][0]" placeholder="Machine Name" type="hidden" value="' + machnine_id + '" title="' + machnine_id + '"readonly><input  data-toggle="tooltip" class="form-control col-md-2 col-xs-12 machnine_grp" name="machine_grp[' + i + '][0]" placeholder="Machine Name"  type="hidden" value="' + machnine_grp + '" title="' + machnine_grp + '"readonly></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" id ="work_order" name="work_order[' + i + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_id + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option></select><input type="hidden"  name="sale_order[' + i + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId dis" name="product_name[' + i + '][0]" width="100%" tabindex="-1" aria-hidden="true" ><option>Select Option</option></select></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + i + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + i + '][0]" placeholder="BOM Routing Number" readonly  type="text" value=""></div><div class=" rTableCell"><label>Process Name</label><select class="form-control process_name" name="process_name[' + i + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + i + '][0]" class="inpt_outpt_process" value=""></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_id + ' AND save_status = 1"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm"  name="npdm_name[' + i + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class=" rTableCell"><label>Workers</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[' + i + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" data-where="created_by_cid=' + current_login_com_id + '" width="100%" ><option>Select Option</option></select></div><div class="hrs rTableCell"><label>Hrs in wages,% in per piece</label><span class="show_msg" style="display:none;">Total %age should be 100</span></div><div class="totalAmountPorduciton rTableCell" style="display:none;"><input id="salary" class="form-control col-md-7 col-xs-12 salary" name="salary[' + i + '][0]" placeholder="salary"  type="text" value=""  onkeypress="return float_validation(event, this.value)"></div><div class=" rTableCell"><label>Production Output</label><input id="output" class="form-control col-md-7 col-xs-12 output" name="output[' + i + '][0]" placeholder="output"  type="text" value="" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="rTableCell" style="display:none;"><input id="wastage" class="form-control col-md-7 col-xs-12" name="wastage[' + i + '][0]" placeholder="wastage" type="hidden" value="" readonly></div><div class="rTableCell"><label>Labour costing</label><input  class="form-control col-md-7 col-xs-12 labour_costing" name="labour_costing[' + i + '][0]" placeholder="labour costing"  type="text" value="" onkeypress="return float_validation(event, this.value)" onkeyup="keyupFun(event,this)"  ' + readonlyLabourCosting + '></div><div class=" rTableCell"><label>Remarks</label><textarea id="remarks" class="form-control col-md-7 col-xs-12" name="remarks[' + i + '][0]" placeholder="remarks"  type="number" value="" ></textarea></div><div class="rTableCell"><input type="button" class="addRow btn btn-success btn-xs" value="add"/></div></div>';
                                        $(".app_div").append(machine_append_Data);


                                        k++;
                                        i++;
                                    }


                                    init_select2();
                                    init_select21();
                                    keyupFun();
                                    SelectOption();
                                    get_jobcard_on_select();
                                    getWorkerIds();
                                    init_select2so();
                                    select_on_npdm_sale_order();


                                } else {
                                    //console.log("ffff");
                                    $(".app_div").append('<h2>No machines available</h2>');
                                    $(".disablesubmitBtn").attr("disabled", true);
                                    $(".draftBtn").attr("disabled", true);
                                }
                            }
                        }
                    }
                });
                $('#processing_loader').modal('toggle');
            }, 1000);
        }

    });


    //$('.Get_machine_accor_to_depart_Planing').on('change',function(){
    //$('.department').on('change',function(){
    $('#planningDate').on('change', function() {
        $('#processing_loader2').modal('toggle');
        setTimeout(function() {
            //var selected_department_idd = $('.Get_machine_accor_to_depart_Planing').find('option:selected').attr('data-id');
            var selected_department_idd = $('.department').find('option:selected').val();
                var compny_unit  = $('.compny_unit').find('option:selected').val();

            var current_login_com_ids = $('#current_login_com_id').val();
            var date = $('#planningDate').val();
            var shift = $('input[type="radio"]:checked').val();
            $('#department_id').val(selected_department_idd);
            $('.app_div_planing').html('');
            $('.btn_heading_hide').show();
            $.ajax({
                type: "POST",
                url: site_url + 'production/get_production_data_according_toDeprtment',
                //data: {selected_department_idd:selected_department_idd}, 
                data: {
                    selected_department_idd: selected_department_idd,
                    'shift': shift,
                    'date': date,
                    'table': 'production_planning'
                },
                success: function(result1) {
                    if (result1 == 'Data of this date and shift already exist') {
                        //console.log('in if con');
                        $(".app_div_planing").append('<h2 style="color:red;">' + result1 + '</h2>');
                        $(".disablesubmitBtn").attr("disabled", true);
                        $(".draftBtn").attr("disabled", true);
                    } else {
                        console.log('in else con');
                        var dataObj1 = JSON.parse(result1);
                        var machineData1 = dataObj1.Machine;
                        //console.log(machineData1);
                        var lenth = machineData1.length;
                        //console.log('length==>>',lenth);
                        //var lenth = dataObj1.length;
                        if (lenth != 0) {
                            $(".disablesubmitBtn").attr("disabled", false);
							$(".draftBtn").attr("disabled", false);
                            $(' <div class="rTableRow mobile-view2"><div class="rTableHead"><label>Machine Name<span class="required">*</span></label></div><div class="rTableHead"><label>Party Specification</label></div><div class="rTableHead"><label>Work order</label></div><div class="rTableHead"><label>Product Name</label></div><div class="rTableHead"><label>BOM Routing Product Name</label></div><div class="rTableHead"><label>Assign Process</label></div><div class="rTableHead"><label>NPDM</label></div><div class="rTableHead"><label>Worker</label></div><div class="rTableHead"><label>Output</label></div><div class="rTableHead" ><label></label></div></div>"').prependTo(".app_div_planing");
                            var k = 0;
                            for (var j = 0; j < lenth; j++) {
                                var machnine_nams = machineData1[j].machine_name;
                                var machnine_ids = machineData1[j].id;
                                var machnine_grp_id = machineData1[j].machine_group_id;
                                // alert(machnine_nam);
                                var machine_append_Data33 = '<div class="rTableRow mobile-view" id="index_' + k + '"><div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="' + machnine_nams + '" readonly><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_ids + ' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_grp_id + ' readonly></div><div class="rTableCell"><label>Party Specification</label><textarea class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[' + k + '][0]"></textarea></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="work_order[' + k + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option></select><input type="hidden"  name="sale_order[' + k + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId dis" name="product_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true" ><option>Select Option</option></select></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + k + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + k + '][0]" placeholder="BOM Routing Number" readonly  type="text" value=""></div><div class="rTableCell"><label>Process Name</label><select class="form-control process_name" name="process_name[' + k + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + k + '][0]" class="inpt_outpt_process" value=""></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_ids + ' AND save_status = 1"  data-id="npdm" data-key="id" data-fieldname="product_name" width="100%"   name="npdm_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class="rTableCell worker-row"><label>Worker</label><select multiple="" class="worker_name form-control col-md-2 col-xs-12 "   name="worker_name[' + k + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + '"><option>Select Option</option></select></div><div class="rTableCell"><label>Output</label><input  class="form-control col-md-2 col-xs-12" name="output[' + k + '][0]" placeholder="output" type="number" value=""></div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR btn btn-success btn-xs"  value="Add" /></div></div>';
                                /* var machine_append_Data33 = '<div class="rTableRow  mobile-view"><div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="'+ machnine_nams  +'" readonly><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[]" placeholder="Machine Name" type="hidden" value='+ machnine_ids +' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[]" placeholder="Machine Name" type="hidden" value='+ machnine_grp_id +' readonly></div><div class="rTableCell"><label>Party Specification</label><textarea id= "specification" class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[]"></textarea></div><div class="rTableCell"><label>Job card product name</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible" id ="job_no" name="job_card_product_name[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="job_card" data-key="id" data-fieldname="job_card_product_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid= '+current_login_com_ids+' AND save_status = 1"></select></div><div class="rTableCell worker-row"><label>Worker</label><select multiple="" class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name['+ k +'][]"   data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid= '+ current_login_com_ids +'"><option>Select Option</option></select></div><div class="rTableCell"><label>Output</label><input id="output" class="form-control col-md-2 col-xs-12" name="output[]" placeholder="output" type="number" value=""></div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR btn btn-success btn-xs" value="Add" /></div></div>'; */
                                $(".app_div_planing").append(machine_append_Data33);

                                k++;
                            }
                            init_select2();
                            init_select21();
                            get_jobcard_on_select();
                            init_select2so();
                            select_on_npdm_sale_order();
                            //getWorkerIds();
                        } else {
                            console.log('in else len con');
                            $(".app_div_planing").append('<h2>No machines available.</h2>');
                            $(".disablesubmitBtn").attr("disabled", true);
                            $(".draftBtn").attr("disabled", true);
                        }
                    }
                }
            });
            $('#processing_loader2').modal('toggle');
        }, 1000);
    });
}

function getDept(evt, t) {
    $('.department').empty('');
   // alert("fff");
    var logged_user = $('#loggedUser').val();
    if (window.location.href == site_url + 'production/production_planning') {
        $(".app_div_planing").html(''); 
	//	$(".app_div_planing_similar").html('');
    } else if (window.location.href == site_url + 'production/production_data') {
        $(".app_div").html('');
    }
    var selected_unit_name = $(t).find('option:selected').val();
    $('.department').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + selected_unit_name + '"');
    $('.department').attr('data-id', 'department');
    $('.department').attr('data-key', 'id');
    $('.department').attr('data-fieldname', 'name');
}


function SelectOption() {
    $(".wages, .per_piece_rate").change(function() {
        if ($(this).hasClass("wages")) {
            var closestId = $(this).closest('.rTableRow').attr('id');
            $("#" + closestId).find('.labour_costing').attr('readonly', 'readonly');
            $("#" + closestId + "").find('.per_piece').css('display', 'none');
            $("#" + closestId + "").find('.wages').attr('checked', 'checked');
            //getWorkerIds();
        } else {
            var closestId = $(this).closest('.rTableRow').attr('id');
            //console.log('closestId',closestId);
            $("#" + closestId).find('.labour_costing').removeAttr('readonly');
            $("#" + closestId + "").find('.per_piece').css('display', 'block');
            $("#" + closestId + "").find('.per_piece').attr('checked', 'checked');
            $("#" + closestId + "").find('.wages').removeAttr('checked');
        }
    });
}

function getWorkerIds() {
    $(".worker_name").off('click');

    //console.log("ffff");
    var k = 0;
    //$(".worker_name").on("select2:select select2:unselect", function (e) {
    $(".worker_name").on("select2:select select2:unselect", function(e) {
        e.stopImmediatePropagation();
        //var closestTR = $(this).closest('tr').attr('id');
        var closestTR = $(this).closest('.rTableRow').attr('id');
        var selected_option = $("#" + closestTR + "").find('input[type="radio"]:checked').val();
        //console.log('selected_option',selected_option);
        var nameValue = $("#" + closestTR + "").find('input[type="radio"]:checked').attr('name');
        //console.log('nameValue',nameValue);
        var arrayIndex = nameValue.split('wages_or_per_piece').pop().split('_')[0];
        if (e.type == 'select2:select') {


            $("#" + closestTR + "").find('#salary').val('');
            //var items = $(this).closest('tr').find('#worker').val();  
            var items = $(this).closest('.rTableRow').find('#worker').val();
            //items = items.join();
            console.log('items===>>>>', items);
            //console.log('kkkkkk=>>',items.join());

            $.ajax({
                type: "POST",
                dataType: "json",
                url: site_url + 'production/getWorkerSalaryData',
                data: {
                    'data': items
                },
                //success: function(data){
                success: function(data) {
                    var updatedWorkerArray = [];
                    items.forEach(function(key) {
                        var found = false;
                        data = data.filter(function(item) {
                            if (!found && item.Id == key) {
                                updatedWorkerArray.push(item);
                                found = true;
                                return false;
                            } else
                                return true;
                        });
                    });
                    data = updatedWorkerArray;
                    //console.log('data',data);
                    var Totalday = $('#noOfdays').val();

                    var dataObj = JSON.parse(JSON.stringify(data));
                    var len = dataObj.length;
                    var salary;
                    var worker_id;
                    for (i = 0; i < len; i++) {
                        var salary = dataObj[i].TotalSalary;
                        var worker_id = dataObj[i].Id;
                        console.log('worker_id===>>>', worker_id);
                    }
                    console.log('arrayIndex===>>>', arrayIndex);
                    var j = i - 1;
                    var hours = $("#" + closestTR + "").find('.hrs').append("<input type='text' value='' class='form-control col-md-7 col-xs-12 hours abc_" + worker_id + "' style='width:50%; float:left;' name='working_hrs" + arrayIndex + "[" + j + "]' onkeyup='keyupFun(event,this)' placeholder='Hours'><input style='width:50%; float:left;' id='totalsalary' class='form-control col-md-7 col-xs-12 totalsalary salary_" + worker_id + "' name='totalsalary" + arrayIndex + "[" + j + "]' placeholder='totalsalary'  type='text' value='' onkeypress='return float_validation(event, this.value)' readonly>");
                    $('.hours').each(function() {
                        $('.abc_' + worker_id).keyup(function() {
                            event.stopImmediatePropagation();
                            var value = $(this).val();
                            console.log('value==>>>', value);
                            //var closestTrId = $(this).closest('tr').attr('id');
                            var closestTrId = $(this).closest('.rTableRow').attr('id');
                            var output = $('#' + closestTrId).find('.output').val();
                            ///console.log("output",output);
                            var totalsalary = 0;
                            //console.log("selected_option",selected_option);
                            if (selected_option == 'wages') { // for wages calaculation
                                var oneDaySalary = salary / Totalday;
                                var oneHrSalary = oneDaySalary / 8;
                                var calculatedSalary = oneHrSalary * value;
                                $(this).next(".totalsalary").val(Math.round(calculatedSalary));
                                ($('#' + closestTrId).find('.totalsalary')).each(function() {
                                    totalsalary = parseFloat(totalsalary) + parseFloat($(this).val());
                                });
                                if (output != '' || output != 0) {
                                    console.log("output", output);
                                    var labour_costing = parseFloat(totalsalary) / parseFloat(output);
                                    console.log('labour_costing_getworkerIds', labour_costing);
                                    $('#' + closestTrId).find('.labour_costing').val(labour_costing);
                                }

                            }
                        });
                    });
                }
            });
        } else if (e.type == 'select2:unselect') {
            var data = e.params.data.id;
            if (data) {
                $(this).closest('.rTableRow').children().find(".abc_" + data).remove();
                //$(this).closest('tr').children().find(".abc_"+data).remove();
                $(this).closest('.rTableRow').children().find(".salary_" + data).remove();
                //$(this).closest('tr').children().find(".salary_"+data).remove();				
            }
        }
        k++;
    });
}




/*
function getWorkerIds(){
	$(".worker_name").on("select2:select select2:unselect", function (e) {
		var closestTR = $(this).closest('tr').attr('id');
			var selected_option = $("#"+closestTR+"").find('input[type="radio"]:checked').val();
			if(selected_option == 'wages'){
			$("#"+closestTR+"").find('#salary').val('');
				var items = $(this).closest('tr').find('#worker').val();  
				$.ajax({
					type: "POST",
					dataType: "json",
					url: site_url + 'production/abc',
					data: {
						
						'data': items
					},
					success: function(data){
						var abc  = JSON.parse(JSON.stringify(data));
						var salary = abc[0].TotalSalary;
						//console.log(salary); 
						var Totalday = $('#noOfdays').val();
						//console.log("ttt",Totalday);
						var calculate_per_day_salary = salary/Totalday ;                // calculate per day salary divide by totaldays to salary
						var get_Hrs = $("#"+closestTR+"").find('.overtime').val();
						//console.log("get_Hrs",get_Hrs);
						
						var perHrsSalryCalculate  = calculate_per_day_salary/get_Hrs ; 
						var perworkerSalary = perHrsSalryCalculate * get_Hrs ; 
						var closestId = $("#"+closestTR+"").find('.salary').val(perworkerSalary);
						var closestId = $("#"+closestTR+"").find('#totalsalary').val(salary);
						//console.log("ddd",closestId);	
					} 
				});
			}else{
				$("#"+closestTR+"").find('#salary').val('');
			}
	});
}*/



/********************************************************************GET STATE in workerModule*****************************************************************************/
function getState(evt, t, type = '') {
    var appendedClass = type != '' ? '.' + type + '.state_id' : '.state_id';
    var appendedClassCity = type != '' ? '.' + type + '.city_id' : '.city_id';
    $(appendedClass).empty();
    $(appendedClassCity).empty();
    var option = $(t).find('option:selected');
    console.log('option===>>>', option);
    //var country_id = type != ''?type:$(option).val();
    var country_id = $(option).val();
    console.log('country_id===>>>', country_id);
    if (country_id != '') {
        $(appendedClass).attr('data-where', 'country_id = ' + country_id);
        $(appendedClass).attr('data-id', 'state');
        $(appendedClass).attr('data-key', 'state_id');
        $(appendedClass).attr('data-fieldname', 'state_name');
    }
}

/*******************************************************GET CITY in workerModule******************************************************************************/
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


/*********************************************************************change mahcine order and draggable*************************************************/
function draggableMachineOrderInit() {
    var sourceId;
    $('[draggable=true]').bind('dragstart', function(event) {
        sourceId = $(this).attr("data_machine_id");
        event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
    });
    $('.panel-body').bind('dragover', function(event) {
        event.preventDefault();
    });
    $('.panel-body').bind('drop', function(event) {

        $(".kanban-centered").sortable({
            connectWith: ".kanban-centered",
            scroll: false,
            cursor: 'pointer',
            revert: true,
            opacity: 0.4,
            update: function() {
                sendMachineOrderPriorityToServer();
            }
        }).disableSelection();
        event.preventDefault();
    });
}

function sendMachineOrderPriorityToServer() {
    var order = [];
    $('.machine_order').each(function(index, element) {
        order.push({
            id: $(this).attr('data_machine_id'),
            position: index + 1,
        });
    });
    console.log("order", order);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url + 'production/changeMachineOrderPriority/',
        data: {
            order: order,
        },
        success: function(response) {
            if (response.status == "success") {
                console.log(response);
                $('#processing-modal').modal('toggle'); //before post			
                setTimeout(function() {
                    $('#processing-modal').modal('toggle'); // after post
                }, 1000);
            } else {
                console.log(response);
            }
        }
    });
}

/*********************************machine ordering code *****************************************************************/
/*get department when select unit*/
$(document).on("change", ".getBranch", function() {
    $('.submitData').attr('disabled', true);
    $(".department").html('');
    var branchName = $('.getBranch').val();

    $.ajax({
        type: "POST",
        url: site_url + 'production/getDepartmentInOrdering',
        data: {
            branch_name: branchName
        },
        success: function(data) {
            var obj = JSON.parse(data);
            var html = '<option value="">Select department</option>';
            $.each(obj, function(key, value) {

                html += '<option value="' + value.id + '">' + value.name + '</option>';
            });
            $(".department").append(html);
        }
    });

});
$(document).on("change", ".department", function() {
    var department = $('.department').find('option:selected').val();
    if (department == '') {
        $('.submitData').attr("disabled", true);
    } else {
        $('.submitData').attr("disabled", false);
    }

});
//$(document).on("change",".department",function(){
$(".submitData").click(function(e) {
    $('#machine_Order').html('');
    var deptId = $('.department').val();
    $.ajax({
        type: "POST",
        url: site_url + 'production/getDepartementMachine',
        data: {
            deptId: deptId
        },
        success: function(data) {
            var dataObj = JSON.parse(data);
            if (dataObj != '') {
                var html = '';
                html += '<h3 style="text-align:center;">' + dataObj[0].name + '</h3>';
                $.each(dataObj, function(key, value) {
                    console.log(value);
                    html += '<article class="kanban-entry grab machine_order" id="item' + key + '" data_machine_id="' + value.id + '"  data_machine_order_id="' + value.priority_order + '" draggable="true"><div class="kanban-entry-inner"><div class="kanban-label" data_machine_order_id="' + value.priority_order + '">Machine Id :</strong> "' + value.id + '" | <strong>Machine Name : </strong>"' + value.machine_name + '"|  <strong>Machine code : </strong>"' + value.machine_code + '" |   <strong>Make And Model : </strong>"' + value.make_model + '" | <strong>Placement Of machine : </strong>"' + value.placement + '" | <strong>Created Date: </strong>"' + value.created_date + '"</div></div></article>';
                });

                $('#machine_Order').append(html);
                draggableMachineOrderInit();
            } else {
                $('#machine_Order').text('No Data Available ');
            }
        }
    });
    e.preventDefault();
});




function AllowIFSC(ifscode) {
    $("div.alert").remove();
    if (ifscode.value != "") {
        ifscodeVal = ifscode.value;
        var reg = /[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/;
        if (ifscodeVal.match(reg)) {
            $(".signUpBtn").removeAttr("disabled");
            $('.ifsc_code').closest('.item').removeClass('bad');


            return true;
        } else {

            $('.ifsc_code').closest('.item').addClass('bad');

            // $('.ifsc_code').closest('.item').append("<div class='alert'>Invalid ifsc code number</div>");
            $('.ifsc_code').closest('.item').append("<div class='alert'>Invalid ifsc code number</div>");
            $(".signUpBtn").attr("disabled", "disabled");
            console.log("Invalid ifsc code number");
            return true;
        }
    }
}


/********************* approve dissaporve in job card **********************/
$(document).on("click", ".validate", function() {
    if (confirm('Are you sure!') == true) {
        var row = $(this).closest('tr');
        $(this).closest('tr').find(".createPO").show();
        var loggedinUser = $('#loggedInUserId').val();

        var job_card_id = row.find("td.job_card_id:nth-child(2)").text();

        console.log('Job id===>>>>>', job_card_id);
        $.ajax({
            type: "POST",
            url: site_url + 'production/approveJobCard/',
            data: {
                id: job_card_id,
                approve: 1,
                validated_by: loggedinUser
            },
            success: function(result) {
                if (result != '') {
                    console.log("fff", result);
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
$(document).on("click", ".disapprove", function() {
    var row = $(this).closest('tr');



    var nameAttributeId = $(this).attr('name');
    nameAttributeId = nameAttributeId.split("_");
    var job_card_idindi = nameAttributeId[1];
    var job_card_id = row.find("td.job_card_id:nth-child(2)").text();
    var checkValues = $('.checkbox1:checked').map(function() {
        return $(this).val();
    }).get();

    $.each(checkValues, function(i, val) {
        $("#" + val).remove();
    });


    if ($('.checkbox1:checked')) {

        console.log('Value=>>>>>>', checkValues);

        $(".disapproveReasonModal #job_card_id").val(checkValues);
    }

    if ($(".checkbox1").prop('checked') == false) {

        console.log('Value=>>>>>>', job_card_id);
        $(".disapproveReasonModal #job_card_id").val(job_card_id);
    }

    var disapprove_reason = row.find("td .disapprove_reason").text();

    $(".disapproveReasonModal #disapprove_reason").text(disapprove_reason);
    $('.disapproveReasonModal').modal('show');
});


/*************************Approve Disapprove on Select*********************************/
$(document).on("click", ".validateonselect", function() {
    if (confirm('Are you sure!') == true) {
        var row = $(this).closest('tr');
        $(this).closest('tr').find(".createPO").show();
        var loggedinUser = $('#loggedInUserId').val();


        var checkValues = $('.checkbox1:checked').map(function() {
            return $(this).val();
        }).get();
        $.each(checkValues, function(i, val) {
            $("#" + val).remove();
        });


        //var job_card_id = row.find("td.job_card_id:nth-child(2)").text();

        console.log('Job id===>>>>>', job_card_id);
        $.ajax({
            type: "POST",
            url: site_url + 'production/approveJobCardSelectAll/',
            data: {
                id: checkValues,
                approve: 1,
                validated_by: loggedinUser
            },
            success: function(result) {
                if (result != '') {
                    console.log("fff", result);
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



/************************print in view****************************************/
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

/*   function printDiv(div) {    
    // Create and insert new print section
    var elem = document.getElementById(div);
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
}   */




$(".submtBtn").submit(function() {
    var checked = $("#days input:checked").length > 0;
    if (!checked) {
        alert("Please check at least one checkbox");
        return false;
    }
});



/*****************************quick add worker in productiondata and planning**********************************/

function init_select21() {
    $('.worker_name').select2({
        allowClear: true,
        placeholder: 'Worker Name',
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

$(document).on("click", ".add_worker_cls_name", function() {
    $('#myModal_Add_worker_details').modal('show');
    var btn_html = $(this).html();
    $('#add_worker_Data_onthe_spot').val(btn_html);
});


//To close Add supplier Popup Model
$(document).on("click", ".close_sec_model", function() {
    $('#myModal_Add_worker_details').modal('hide');
});

$(document).on("click", "#Add_worker_details_on_button_click", function() {
    $('#mssg34').html('');
    var worker_name = $('#worker_name').val();
    var mobile_number = $('#mobile_number').val();
    var salary_amnt = $('#salary').val();
    //console.log("ssss",salary_amnt);
    var error = 0;
    if (worker_name == '') {
        $('#worker_name').css('border', '1px solid #b94a48');
        $('#worker_name').closest(".form-group").find("span").text('This field is required');
        var error = 1;
    } else {
        $('#worker_name').css('border', '1px solid #dedede');
        $('#worker_name').closest(".form-group").find("span").text('');
    }
    if (error == 1) {
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: site_url + 'production/add_worker_Details_onthe_spot/',
            data: {
                name: worker_name,
                mobile_number: mobile_number,
                salary: salary_amnt
            },
            success: function(htmlStr) {
                if (htmlStr == 'true') {
                    $('#mssg34').html('<span style="color:green;">Worker Added Successfully.</span>');
                    $("#insert_worker_data_id").trigger('reset');
                    setTimeout(function() {
                        $('#myModal_Add_worker_details').modal('hide');
                        $('#myModal_Add_worker_details').modal('hide');
                    }, 2000);
                } else {
                    $('#mssg34').html('<span style="color:red;">Not Added.</span>');
                }
            }
        });
    }
});




/********************production filter****************************************/
$(function() {
    $('input[name="dateRangeFilters"]').daterangepicker({
        opens: 'left',
        useCurrent: true
    }, function(start, end, label) {
        var filterUrl = $('#dateRangeFilters').attr('data-table');
        var url = site_url + filterUrl;
        $('.start_date').val(start.format('YYYY-MM-DD 00:00:00'));
        $('.end_date').val(end.format('YYYY-MM-DD 23:59:59'));
        $("#date_range").submit();
        /*$.ajax({
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
        		$('.js-switch').eq().hide();				
        		$('.datePick').eq(1).hide();
        		$('.datePick-left').eq(1).hide();
        		
        		$('.table-striped').DataTable( {
        			destroy: true,
        			searching: true
        		});
           }
        });	*/
    });
});




/********************************quick add machine group***************************************************/
function init_select221() {
    $('.machinegroup').select2({
        allowClear: true,
        placeholder: 'Machine Group Name',
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
                $('#machine_group_id').val(searched_value);
                return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_machine_group_name'>Add Machine Group</span>";
            }
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });
}
$(document).on("click", ".add_machine_group_name", function() {
    $('#myModal_Add_machine_group').modal('show');
    var btn_html = $(this).html();
    $('#add_machine_group_onthe_spot').val(btn_html);
});
//To close machine group Popup Model
$(document).on("click", ".close_sec_model", function() {
    $('#myModal_Add_worker_details').modal('hide');
});
$(document).on("click", "#Add_group_details_on_button_click", function() {
    $('#mssg34').html('');
    var machine_group_name = $('#machine_group_id').val();
    var error = 0;
    if (machine_group_name == '') {
        $('#machine_group_id').css('border', '1px solid #b94a48');
        $('#machine_group_id').closest(".form-group").find("span").text('This field is required');
        var error = 1;
    } else {
        $('#machine_group_id').css('border', '1px solid #dedede');
        $('#machine_group_id').closest(".form-group").find("span").text('');
    }
    if (error == 1) {
        return false;
    } else {

        $.ajax({
            type: "POST",
            url: site_url + 'production/add_machine_group_onthe_spot/',
            data: {
                machine_group_name: machine_group_name
            },
            success: function(htmlStr) {
                if (htmlStr == 'true') {
                    $('#mssg34').html('<span style="color:green;">Group Added Successfully.</span>');
                    $("#insert_worker_data_id").trigger('reset');
                    setTimeout(function() {
                        $('#myModal_Add_machine_group').modal('hide');
                        $('#myModal_Add_machine_group').modal('hide');
                    }, 2000);
                } else {
                    $('#mssg34').html('<span style="color:red;">Not Added.</span>');
                }
            }
        });
    }
});



/*****************************************************************compny unit in worker*****************************/
function getAddress() {
    $('.address').select2({
        allowClear: true,
        placeholder: 'Select Address',
        closeOnSelect: true,
        ajax: {
            url: site_url + '/production/getcompany_unit',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
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

/*function get_productionData_date(){
	
	$('.selectDate').on('change',function(){
			$('#processing_loader').modal('toggle'); 
			setTimeout(function () {
			
			//var selected_department_idd = $('.department').find('option:selected').val();
			var selected_date = $('.selectDate').val();
			console.log("fff",selected_date);
			//var current_login_com_id = $('#current_login_com_id').val();
			//$('#department_id').val(selected_department_idd);
			$('.worker_div').html('');
			$('.btn_heading_hide').show();
				$.ajax({
				type: "POST",
				url: site_url + 'production/get_prod_data_according_to_date',
				data: {selected_date:selected_date}, 
				success: function(result){
					var data = JSON.parse(result);
					var lenth = data.length;
					if(lenth != 0){
					var k = 0;
					var i = 0;
					for(var j=0; j<lenth; j++){
						var production_data = data[j].production_data;
						var get_prod_data = JSON.parse(production_data);
						
						var array = [];
						var job_card = '';
						var machine_length = get_prod_data.length;
						$.each( get_prod_data, function( key, value ) {
							job_card = value.output;
						    array.push({'id':value.machine_name_id});
						});
						$.ajax({
						type: "POST",
						url: site_url + 'production/get_machine_accrding_to_id',
						data: {machine_id:array}, 
						success: function(result1){	
						
						var machine_data = JSON.parse(result1);
						var lenth = machine_data.length;
						if(lenth != 0){
						var k = 0;
						var i = 0;
						for(var j=0; j<lenth; j++){
							var mach_data = machine_data[j].machine_name;
							
							
					
						var production_append_Data = '<tr id="index_'+i+'"><td><input type="radio" id="radio_id_btn1" name="wages_or_per_piece[]_'+i+'" value="wages" checked="checked" class="wages"><label for="defaultRadio">Wages</label><input type="radio" id="radio_id_btn2" name="wages_or_per_piece[]_'+i+'" value="per_piece" class="per_piece_rate" ><label for="defaultRadio">Per Piece</label></td><td><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="'+ mach_data+'" readonly></td><td><select class="form-control selectAjaxOption select2 select2-hidden-accessible party_code_cls" id ="party_code" name="party_code[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="job_card" data-key="id" data-fieldname="party_code" tabindex="-1" aria-hidden="true" data-where="created_by_cid='+ current_login_com_id +' AND save_status = 1"><option>Select Option</option></select></td><td><input  class="form-control col-md-2 col-xs-12" name="job_card_product_name[]" placeholder="Job Card Product Name" readonly  type="text" value=""><input type="hidden"  class="form-control col-md-2 col-xs-12" name="job_card_product_id[]" placeholder="Job Card Number" readonly  type="text" value=""></td><td><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name['+ k +'][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" data-where="created_by_cid='+ current_login_com_id +'" width="100%" ><option>Select Option</option></select></td><td><input id="overtime" class="form-control col-md-7 col-xs-12" name="overtime[]" placeholder="overtime"  type="text" value="" onkeypress="return float_validation(event, this.value)"></td><td><input id="output" class="form-control col-md-7 col-xs-12" name="output[]" placeholder="output"  type="text" value="" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)"></td><td class="per_piece" style="display:none;"><input id="per_piece_rate" class="form-control col-md-7 col-xs-12" name="per_piece_rate[]" placeholder="per piece rate"  type="text" value="" onkeypress="return float_validation(event, this.value)"></td><td><input type="button" class="addRow btn btn-success btn-xs" value="add"/></td></tr>';
						$(".worker_div").append(production_append_Data);
							init_select2();
							init_select21();
							keyupFun();
							SelectOption();
							//get_jobcard_on_select();
							//getWorkerIds();
							k++;  
							i++;  
							}	
							}
						}
						});
							
						}
					
					} else{
					
						$(".worker_div").append('<h2>No machines available</h2>');
						}
				 }
			 });
			  $('#processing_loader').modal('toggle'); 
		}, 1000);
	});
}*/


/*********** Function to show the dashboard in main dashboard **********/
$('.graphCheckbox').click(function(e) {
    var show = 0;
    if ($(this).is(":checked")) show = 1;
    else show = 0;
    var graph_id = $(this).attr('id');
    var ajaxData = {
        'graph_id': graph_id,
        'show': show
    };
    $.ajax({
        url: site_url + 'production/showDashboardOnRequirement/',
        dataType: 'json',
        type: 'POST',
        data: ajaxData,
        success: function(response) {
            console.log('response===>>>>', response);
        }
    });
});

/***********datatable in production setting****************/
$(document).ready(function() {
    var table = $('#example').DataTable();
});

/*********at the time of planning to data conversion display message if same date data already exist***************/
function getMessageDisplay() {
    var getDate = $('#date').val();
    var getpageName = $('#date').attr('data-id');
    //console.log('getpageName',getpageName);

    if (window.location.href == site_url + 'production/production_planning') {
        $.ajax({
            type: "POST",
            url: site_url + 'production/getData_fromProd_basedOnDate',
            data: {
                selected_planning_date: getDate
            },
            success: function(response) {
                if (response != '') {
                    var dataObj = JSON.parse(response);
                    if (dataObj.date == getDate) {
                        console.log('response', response);
                        /*if(getpageName == 'convert_to_prodData'){
                        	$('.message').append('<h6 style="color:red;">Production data of this Date already exist</h6>');
                        	setTimeout(function () {
                        		$('.message').fadeOut('1000');
                        	}, 6000);
                        }else{*/
                        if (getpageName == 'convert_to_prodData') {
                            $.ajax({
                                type: "POST",
                                url: site_url + 'production/getData_fromProd_basedOnDate',
                                data: {
                                    selected_date: getDate
                                },
                                success: function(result) {
                                    if (result == 'No Data Of This Data Exist') {
                                        $('.message').append('');
                                    } else {
                                        //if(result != ''){
                                        var dataObj1 = JSON.parse(result);
                                        if (dataObj1.date == getDate) {
                                            $('.message').append('<h6 style="color:red;">Production Data of this Date already exist</h6>');
                                            setTimeout(function() {
                                                $('.message').fadeOut('1000');
                                            }, 6000);
                                        }
                                    }
                                }
                            });
                        } else {
                            $('.message').append('<h6 style="color:red;">Production Planning of this Date already exist</h6>');
                            setTimeout(function() {
                                $('.message').fadeOut('1000');
                            }, 6000);
                        }
                    }
                }
            }
        });
    } else {
        $.ajax({
            type: "POST",
            url: site_url + 'production/getData_fromProd_basedOnDate',
            data: {
                selected_date: getDate
            },
            success: function(response) {
                if (response != '') {
                    var dataObj = JSON.parse(response);

                    if (dataObj.date == getDate) {
                        $('.message').append('<h6 style="color:red;">Production Data of this Date already exist</h6>');
                        setTimeout(function() {
                            $('.message').fadeOut('1000');
                        }, 6000);
                    }
                }
            }
        });
    }
    /*$.ajax({
    	type: "POST",
    	url: site_url + 'production/getData_fromProd_basedOnDate',
    	data: {selected_date:getDate}, 
    	success: function(response){
    		if(response != ''){
    		var dataObj = JSON.parse(response);
    			if(dataObj.date == getDate){
    				$('.message').append('<h6 style="color:red;">Production Data of this Date already exist</h6>');
    				setTimeout(function () {
    					$('.message').fadeOut('1000');
    				}, 6000);
    			}
    		}
    	}
    });*/
}

/************************************textarea wordwrap without scroll**********************************/
function textareaWrap() {
    /*var span = $('<span>').css('display','inline-block')
    .css('word-break','break-all').appendTo('body').css('visibility','hidden');
    function initSpan(textarea){
      span.text(textarea.text())
          .width(textarea.width())      
          .css('font',textarea.css('font'));
    }
    $('#purpose').on({
        input: function(){
          var text = $(this).val();      
          span.text(text);      
          $(this).height(text ? span.height() : '1.1em');
        },
        focus: function(){
         initSpan($(this));
        },
        keypress: function(e){
            if(e.which == 13) e.preventDefault();
        }
    });*/
    /*$('.purpose').on('keydown', function(e){
        if(e.which == 13) {e.preventDefault();}
    }).on('input', function(){
        $(this).height(1);
        var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
        $(this).height(totalHeight);
    });*/
    $('.textarea').on('input', function() {
        this.style.height = 'auto';

        this.style.height =
            (this.scrollHeight) + 'px';
    });


}




/**************************************sale order complete functionality ***************************/

function saleOrderComplete() {
    $('#sale_order_complete').change(function(event) {
        if (($("#sale_order_complete").prop("checked") == true)) {
            if (confirm('Are you sure!') == true) {
                var sale_order_id = $(this).attr('data-sale-order-id');
                var loggedInUserId = $(this).attr('data-loggedInUserId');
                $.ajax({
                    type: "POST",
                    url: site_url + 'production/completeSaleOrder/',
                    data: {
                        id: sale_order_id,
                        complete_status: 1,
                        completed_by: loggedInUserId
                    },
                    success: function(result) {
                        if (result != '') {
                            var obj = $.parseJSON(result);
                            if (obj.status == 'success') {
                                window.location.href = site_url + 'production/sale_order_with_production/';
                            }
                        }
                    }
                });
            }
        }
    });
}


/**********************multiple machine group in poroduction setting************************/
function addMachineGroup() {
    var maxInput = 20; //maximum input boxes allowed
    var inputField = $(".add_more_group"); //Fields wrapper
    var addMachineGroupbtn = $(".addMoreMachineGroupBtn"); //Add button ID
    var y = 1; //initlal text box count
    $(addMachineGroupbtn).click(function(e) { //on add input button click
        e.preventDefault();
        if (y < maxInput) { //max input box allowed
            y++;
            $(inputField).append('<div><div class="col-md-7 col-sm-6 col-xs-12 "><input type="text"  class="form-control col-md-7 col-xs-12" name="machine_group_name[]" required value=""></div><button class="btn btn-danger remv_machineGrp" type="button"><i class="fa fa-minus"></i></button></div>');
        }
    });
    $(inputField).on("click", ".remv_machineGrp", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
    });
}


/*************************add atchemnt in job card*****************************/
function addAttachment_InJobCard() {
    var max_doc = 5; //maximum input boxes allowed
    var docu_Field = $(".add_documents"); //Fields wrapper
    var addMoreAttachDocument = $(".add_moreDocs"); //Add button ID
    var k = 1; //initlal text box count
    var docWell = $('.doc').attr('id').length;
    console.log("docwell", docWell);
    $(addMoreAttachDocument).click(function(e) { //on add input button click
        e.stopImmediatePropagation();
        //var closestIndex = $(this).closest('.well').find('.doc').attr('id');
        var ids = $(this).closest('.well2').attr('data-id');

        e.preventDefault();

        if (k < max_doc) { //max input box allowed
            k++;
            $(this).closest('.well').find(docu_Field).append('<div class="col-md-12 col-sm-12 col-xs-12 form-group" id="abc_' + k + '"><div class="col-md-10 col-sm-12 col-xs-10 form-group"><input type="file" class="form-control col-md-6 col-xs-12" name="documentsAttach_' + ids + '[]" ></div><button class="btn  remv_Documents" type="button"><i class="fa fa-minus"></i></button></div>');
        }
    });
    $(docu_Field).on("click", ".remv_Documents", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        k--;
    });
}


/*************************get shift data  in production data and planning at the time of add********************/
/*function getshiftAccrdng_toDept(){
	$('.department').on('change',function(){
		
	var company_unit = $('.compny_unit option:selected').val();
	var department = $('.department option:selected').val();
		$.ajax({
			type: "POST",
			//dataType: 'json',
			url: site_url+'production/getShiftAccrdngToDept/',
			data: { company_unit:company_unit, department:department}, 
			success: function(result1) {
			 setTimeout(function () {
				if(result1 == 'gg'){
					//alert("fgffff");
					$('.radio_button').empty('');
					$('.Displaymessage').css('display','block');
					$('.Displaymessage').append("Please Select Shift From Production Setting");
					$('.date').datepicker( "option", "disabled", true );
					$('.disablesubmitBtn').attr("disabled", true );
					setTimeout(function () {
						$('.Displaymessage').fadeOut('1000').empty();
						$('.Displaymessage').empty('');
					}, 3000);
					
				}else{
					var obj = $.parseJSON(result1);
					var radio_html ='';
					$.each(obj,function(i,value){
						radio_html += '<input type="radio" class="flat" name="shift" value="'+value.id+'" checked = checked[0] >'+value.shift_name+'</br>';
					});
					//$('.radio').empty('');
					$('.radio_button').html(radio_html);
					$('.date').datepicker( "option", "disabled", false );
					$('.date').datepicker( "option", "disabled", false );
					
				}
			}, 1000);	
		   }
		});
	}); 
}*/


function getshiftAccrdng_toDept() {
	$(".WorkOrderId").on("select2:unselecting", function(e) {
   		$(this).parents().closest('.rTableRow').find('.productNameId option').remove();
		$(this).parents().closest('.rTableRow').find('.process_name option').remove();
		$(this).parents().closest('.rTableRow').find('.job_card').val('');

 });
    $('.department').on('change', function() {

        var company_unit = $('.compny_unit option:selected').val();
        var department = $('.department option:selected').val();

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
                        var sel_data = '<input type="radio" class="flat" name="shift" value="' + idd + '" checked = checked[0] >' + shift_namee + '</br>';
                        $('.radio_button').append(sel_data);
                        $('.date').datepicker("option", "disabled", false);
                        $('.disablesubmitBtn').attr("disabled", false);
                    }
                }
            }
        });
    });
}
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});




/****************************print message in wrok order creation **********************************/
function getQtyValue(evt, t) {
    var saleorderId = $('#sale_order_no').val();
    var closestId = $(t).closest(".well").attr("id");
    var MaterialId = $("#" + closestId + "").find('.materialNameId option:selected').val();

    var workOrderQty = $("#" + closestId + "").find('.actual_qty').val();
    $.ajax({
        type: "POST",
        url: site_url + 'production/getSaleOrderProductDetail/',
        data: {
            sale_order_id: saleorderId
        },
        success: function(result) {
            var data = JSON.parse(result);
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var product = JSON.parse(data[i].product);
                var prodLen = product.length;
            }
            var saleOrderQty = '';
            for (var j = 0; j < prodLen; j++) {
                var qty = product[j].quantity;
                var material_id = product[j].product;
                if (material_id == MaterialId) {
                    saleOrderQty = qty;
                }
            }
            $('#qtyMessage').css('display', '');
            if (parseInt(saleOrderQty) < parseInt(workOrderQty)) {
                $('#qtyMessage').html("Qty is greater than saleOrder");
                setTimeout(function() {
                    $('#qtyMessage').fadeOut('slow');
                }, 2000);
            } else {
                $('#qtyMessage').empty();
            }
        }
    });
}
function UpdatePendingQtyValue(evt, current) {
    var saleorderId = $('#sale_order_no').val();
    var work_order_id = $('#work_order_id').val();
    var closestId = $(current).closest(".well").attr("id");
    var MaterialId = $("#" + closestId + "").find('.materialNameId option:selected').val();
    var workOrderPendingQty = $("#" + closestId + "").find('.Pendingquantity').val();
    var workOrderPending_quantity = $("#" + closestId + "").find('.Pending_quantity').val();
    var Transferquantity = $("#" + closestId + "").find('.Transferquantity').val();
    var Totalquantity = $("#" + closestId + "").find('.Totalquantity').val();
    var workOrderTransferQty = $("#" + closestId + "").find('.transfer_quantity').val();
	$('#transferqtyMessage').css('display', '');
	if(work_order_id){
			$('.enableOnInput').prop('disabled', false);
	if (!$(current).val()) {
			var workOrderPendingrQty = "";
			//var workOrderPendingrQty  = parseInt(workOrderPendingQty)+parseInt(Transferquantity);
			$("#" + closestId + "").find('.Pending_quantity').val(Totalquantity);
		//	$("#" + closestId + "").find('.Pendingquantity').val(workOrderPendingrQty)

	}else{
          if(parseInt(Totalquantity) >= parseInt($(current).val())){
			var workOrderPendingrQty  = Totalquantity-$(current).val();
				$("#" + closestId + "").find('.Pending_quantity').val(workOrderPendingrQty);
				//$("#" + closestId + "").find('.Pendingquantity').val(workOrderPendingrQty)
				$('#transferqtyMessage').empty();
				$('.enableOnInput').prop('disabled', false);

			}else{
			$("#" + closestId + "").find('.Pending_quantity').val(workOrderPending_quantity);
			 $('#transferqtyMessage').html("WorkOrder Qty Should be less then or Equal to Pending Qty");
			 $('.enableOnInput').prop('disabled', true);

			}
    }		
	}else{
	if(parseInt(workOrderPendingQty) >= parseInt(workOrderTransferQty)){
	var workOrderPendingrQty  = workOrderPendingQty-workOrderTransferQty;
		$("#" + closestId + "").find('.Pending_quantity').val(workOrderPendingrQty);
		//$("#" + closestId + "").find('.Pendingquantity').val(workOrderPendingrQty)
		$('#transferqtyMessage').empty();
		$('.enableOnInput').prop('disabled', false);

	}else{
	$("#" + closestId + "").find('.Pending_quantity').val(workOrderPendingQty);
	 $('#transferqtyMessage').html("WorkOrder Qty Should be less then or Equal to Pending Qty");
	 $('.enableOnInput').prop('disabled', true);

	}
	}

}

function getMaterialIdFromWorkOrder() {
    var MaterialId = $('.materialNameId option:selected').val();
    console.log('MaterialId===>>>>', MaterialId);
    var selectedMaterialId = [];
    $('.materialNameId :selected').each(function(index, value) {
        //var MaterialId = $('.materialNameId option:selected').val();
        selectedMaterialId[index] = $(this).val();
        //

    });
    console.log(selectedMaterialId);

    $.ajax({
        type: "POST",
        url: site_url + 'production/getJobCardFromMaterial/',
        data: {
            material_ids: selectedMaterialId
        },
        success: function(result) {
            var data = JSON.parse(result);
            var length = data.length;
            console.log('data', data);
            $(selectedMaterialId).each(function(index, value) {
                var MId = $('.materialNameId option:selected').val();
                console.log('mid===>>>>', MId);
                $(data).each(function(ind, val) {


                    if (value == val.id) {

                        //$('.job_card').val(val.job_card_no);
                        $('#WorkOrder_1').find('.job_card').val(val.job_card_no);
                        $('#chkIndex_' + index).find('.job_card').val(val.job_card_no);

                    }
                });

            });


            /* for(var i=0; i<length; i++){
            	var material_id = data[i].id;
            	var job_card = data[i].job_card_no;
            	var selected_Material_id = selectedMaterialId[i];
            	
            	
            	
            	//console.log('selected_Material_id',selected_Material_id);
            	//console.log('material_id',material_id);
            	
            	
            } */
        }
    });
    //var closestId =  $('.materialNameId').parent().prev('div').attr('id');
    //console.log('MaterialId',MaterialId);
    //console.log('closestId',closestId);

}

/************************Delete on Select****************************************/
$(document).ready(function() {
    resetcheckbox();
    $('#selecctall').click(function(event) { //on click
        if (this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true; //select all checkboxes with class "checkbox1"              
            });
        } else {
            $('.checkbox1').attr("disabled", false).each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
        }
    });



    $("#del_all").on('click', function(e) {

        if (confirm('Are You Sure!') == true) {
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
            $.each(checkValues, function(i, val) {
                $("#" + val).remove();
            });
            var ai = $(".checkbox1:checked").map(function() {
                return $(this).data('ai')
            }).get();
            //  console.log('value if ai====>>>>>',ai);
            $.ajax({
                url: site_url + 'production/deleteall/',
                type: 'post',
                data: {
                    tablename: tablename,
                    checkValues: checkValues,
                    datamsg: datamsg
                }
            }).done(function(data) {
                window.location.href = site_url + datapath;
                $('#selecctall').attr('checked', false);
            });
        } else {
            $('input:checkbox').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
        }
    });

    function resetcheckbox() {
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
        var favourite = 1;
        var datamsgq = 'Marked'
    } else {
        var favourite = 0;
        var datamsgq = 'Unmarked'
    }
    var datamsgs = datamsg + '' + datamsgq;
    var checkValues = $(this).val();
    $.ajax({
        url: site_url + 'production/markfavourite/',
        type: 'post',
        data: {
            tablename: tablename,
            checkValues: checkValues,
            datamsg: datamsgs,
            favourite: favourite
        }
    }).done(function(data) {
        window.location.href = site_url + datapath;
        $('.star-1').attr('checked', false);
    });

});

/*******************************FAVOURITES IN Inventory ***************************/


/*get material name when select material type*/
function getMaterialNamesaleorder(evt, current, selProcessType = '', c_id = '') {
    $(this).parents().closest('input=[text]').find('.productNameId').empty();
    var logged_user = $('#loggedUser').val();
    console.log("loggeduser", logged_user);
    var option = $(current).find('option:selected');
    var material_type_id = selProcessType != '' ? selProcessType : $(option).val();
    if (material_type_id === undefined) {
        material_type_id = $('.productNameId').find('option:selected').val();

    }
    if (material_type_id != '') {
        select2saleorder(current,material_type_id, logged_user);
    }

}

function select2saleorder(current,material_type_id, logged_user) {
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-where', 'id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND save_status = 1');
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-id', 'sale_order');
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-key', 'id');
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-fieldname', 'product');
}


function select_on_npdm_sale_order() {
    $('.npdm').on('change', function() {
        var card_nothis_val333 = $(this);
        var closestTr = $(card_nothis_val333).closest('.rTableRow').attr('id');
    //    $("#" + closestTr).find(".dis").prop("disabled", true);
    });
    $('.sale_order_cls').on('change', function() {
        var card_nothis_val333 = $(this);
        var closestTr = $(card_nothis_val333).closest('.rTableRow').attr('id');
        $("#" + closestTr).find(".npdm").prop("disabled", true);
    });
}


function get_mat_data_id() {
    $(document).on("click", ".get_mat_data_id_cls", function() {
        var mat_id = $(this).attr('data-id');
        $(this).removeClass('get_mat_data_id_cls');
        var matrial_select_this221 = $(this);
        $.ajax({
            type: "POST",
            url: site_url + 'production/bomroutingview_onclick/',
            data: {
                mat_id: mat_id
            },
            success: function(htmlStr) {
                var parent_divID = $(matrial_select_this221).closest('.row-padding').attr("id");
                //alert(parent_divID);
                var p_ID = '#' + parent_divID;



                $('' + p_ID + ' .append_cls').append(htmlStr);
            }
        });
        var amtt = 0;
        setTimeout(function() {
            $(".cost_cls").each(function() {
                amtt += parseFloat($(this).val());
                $('.Grnd_total').html(amtt);

            });
        }, 1000);

    });
}

function uploadImage() {
    $(document).ready(function() {
        $('#image').click(function(event) {
            $('#imageModalUpload').modal('show');
        });
        $('#closemodal').click(function(event) {
            $('#imageModalUpload').modal('hide');
        });
        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 265,
                height: 197,
                type: 'square' //circle
            },
            boundary: {
                width: 365,
                height: 297
            }
        });
        $('#featured_image').on('change', function() {
            $('.crop_section').css("display", "block");
            var reader = new FileReader();
            reader.onload = function(event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function() {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('.crop_image').click(function(event) {
            var uploaded_image_name = $('#featured_image').val().replace(/.*(\/|\\)/, '');
            var Id = $("input[name=id]").val();
            if (Id == '') {
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response) {
                    $.ajax({
                        url: site_url + 'production/uploadImageByAjax/',
                        dataType: 'json',
                        type: "POST",
                        data: {
                            "image": response,
                            'uploaded_image_name': uploaded_image_name
                        },
                        success: function(data) {
                            var result = JSON.parse(JSON.stringify(data));
                            console.log("resl", result);
                            $('.hiddenImage').val(result.image)
                            $('#imageModalUpload').modal('hide');
                            $('#uploaded_image_Add').html(result.imageHtml);
                            $('#changed_user_profile').val(result.image);
                        }
                    });
                })
            } else {
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response) {
                    $.ajax({
                        url: site_url + 'production/EditImageByAjax/',
                        dataType: 'json',
                        type: "POST",
                        data: {
                            "image": response,
                            'uploaded_image_name': uploaded_image_name,
                            'Id': Id
                        },
                        success: function(data) {
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

function submit_shift_settings() {
    $('#shift_setting_frm').submit();
}

function submit_department_settings() {
    $('#depart_setting_frm').submit();
}

function submit_machine_ordering() {
    url = 'production_setting';
    window.location.href = url;
}

function submit_machine_group() {
    $('#machinegrouping_setting_frm').submit();
}

function submit_wagesper_piece() {
    $('#wagesperpice_setting_frm').submit();
}

function inprocesss_sale_order() {
    $('#in_process_sale_frm').submit();
}

function pririty_sale_order() {
    $('#priorty_sale_frm').submit();
}

function complete_saleorder() {
    $('#completeorder_sale_frm').submit();
}

/* Add Multiple Work Order */

/*job card machine add more*/
/* function WorkOrderProcess() {
    var MaxWorkOrder = 10;
    var WorkOrderFields = $(".WorkOrderFields");
    var addWorkOrderFields = $(".addWorkOrderFields");
    var count = $(".well2").length;
	var x = ($(".WorkOrderFields .well").length > 1) ? ($(".WorkOrderFields .well").length) : 1;

    $(addWorkOrderFields).click(function(e) {
        var processType = $('.processType_id').find('option:selected').val();
        e.preventDefault();
        if (x < MaxWorkOrder) {
            x++;
            count++;
            var logged_user = $('#loggedUser').val();
            $(WorkOrderFields).append(' <div class="well well2 scend-tr" id="WorkOrder_'+count+'" data-id="frst_div_1"> <div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Item To Manufacture<span class="required">*</span></label> <div class=" form-group col-md-6 col-sm-12 col-xs-12"> <select class="form-control col-md-7 col-xs-12 materialNameId" required="required" name="material_name[]" onchange="getUom(event,this);"> <option value="">Select Option</option>  </select> </div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Expected Delivery Date</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Expected Delivery Date" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">BOM No</label> <div class="col-md-6 col-sm-12 col-xs-12"> <input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 job_card" placeholder="BOM No" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Sales Order</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Sales Order" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Qty To Manufacture</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 qty" placeholder="Qty To Manufacture" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12"></label> <div class="col-md-6 col-sm-12 col-xs-12"></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Consumed Qty</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Consumed Qty" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Required Qty</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12" placeholder="Required Qty" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Transferred Qty</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12" placeholder="Transferred Qty" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Planned Start Date</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Planned Start Date" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Planned End Date</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Planned End Date" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Actual Start Date</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Actual Start Date" value="" ></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"> <div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12 ">Actual End Date</label> <div class="col-md-6 col-sm-12 col-xs-12"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12 " placeholder="Actual End Date" value="" ></div></div></div><button class="btn btn-danger remove_machine" type="button"><i class="fa fa-times" aria-hidden="true"></i></button> </div>');
            getUom();
			 return false;
        }
    });
    $(WorkOrderFields).on("click", ".removeWorkOrder", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

}
 */
 
 /* Get Products of Work Order */
 /*get material name when select material type*/
function getMaterialNameWorkorder(evt, current, selProcessType = '', c_id = '') {
  //  $(current).parents().closest('input=[text]').find('.productNameId').empty();
    var logged_user = $('#loggedUser').val();
    console.log("loggeduser", logged_user);
    var option = $(current).find('option:selected');
    var WorkOrderId = selProcessType != '' ? selProcessType : $(option).val();
/*     if (WorkOrderId === undefined) {
        WorkOrderId = $('.productNameId').find('option:selected').val();

    } */
	if (WorkOrderId){
        select2WorkOrder(current,WorkOrderId, logged_user);
    }

}
function select2WorkOrder(current,WorkOrderId, logged_user) {
		$(current).parents().closest('.rTableRow').find('.productNameId option').remove();
		$(current).parents().closest('.rTableRow').find('.process_name option').remove();
		$(current).parents().closest('.rTableRow').find('.job_card').val('');
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-where', 'id = ' + WorkOrderId + ' AND created_by_cid=' + logged_user + '');
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-id', 'work_order');
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-key', 'id');
		$(current).parents().closest('.rTableRow').find('.productNameId').attr('data-fieldname', 'product_detail');
		  $.ajax({
				url: site_url + 'production/GetSaleOrderID/',
				dataType: 'json',
				type: "POST",
				data: {
					'id': WorkOrderId
				},
				success: function(data) {
					var result = JSON.parse(JSON.stringify(data));
					var sale_order_id = result.sale_order_id;
					$(current).parents().closest('.rTableRow').find('.SelectedSaleOrder').val(sale_order_id);

				}
         });
		
}

function getMaterialOfSaleOrder(evt, current) {
    $('.customer_name_id').empty();
    var option = $(current).find('option:selected');
    var SaleOrderId = $(option).val();
	//alert(SaleOrderId);
	$('.sale_order_id').val(SaleOrderId);
    if (SaleOrderId != '') {
	  $.ajax({
			url: site_url + 'production/getSaleOrderProductsData/',
			 dataType: "html",
			type: "POST",
			data: {
				'sale_order_id': SaleOrderId
			},
			success:function(msg){
				$("#div_result").html(msg);
				 getMaterialIdFromWorkOrder();

			   },
			error: function(result)
			   {
				  $("#div_result").html("<center><strong style='color:red'>PLoading failed .Please Select Sale Oder</strong></center>"); 
			   },
			fail:(function(status) {
				  $("#div_result").html("<center><strong style='color:red'>PLoading failed .Please Select Sale Oder</strong></center>");
			   }),
		   beforeSend:function(d){
				$('#div_result').html("<center><strong style='color:red'>Please Wait...<br></strong><i class='fa fa-refresh fa-5x fa fa-spin'></i></center>");
			   }
	 });
  }
}

function FORMVALIDATE(event) {
	event.preventDefault();
		var checkBoxes = document.getElementsByClassName( 'workOrderIDscheckbox' );
		var isChecked = false;
		for (var i = 0; i < checkBoxes.length; i++) {
			if ( checkBoxes[i].checked ) {
				isChecked = true;
			};
		};
	if ( !isChecked ) {
		 $('#result').html('<div class="alert alert-error col-md-6">Please, check at least one checkbox!</div>');
		 event.preventDefault();
			return false;
			//alert( 'Please, check at least one checkbox!' );
		}
		var bool = true;
		$.ajax({
				type: "POST",
				async: false,
				url: site_url+'production/CheckMonthlyProductionRecordExist/',
				
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
function GetMonthlyProductionData(){
   $(document).ready(function() {
   	var serialsDict = [];
       var table = $('#ProductionReportDataTable').DataTable({
	   'processing': true,
	   'serverSide': true,
	   'serverMethod': 'post',
		'paging':   false,
		'searching': false, // Remove default Search Control
		'ajax': {
			'url':site_url + 'production/MontlyProductionList',
			'data': function(data){
			   data.searchCompnyUnit = $('.compny_unit').val();
			   data.searchDepartment = $('.department').val();
			   data.searchMonth = $('.Selectedmonth').val();
			   data.productionId= $('.productionId').val();
			}
		},  
	   'rowReorder': {
		dataSrc: 'priority_order'
	   },
	 'columnDefs': [
		  {
			 'targets': 5,
			 'checkboxes': {
				'selectRow': true
			 }
		  }
	   ],
    'columns': [
		{ data: 'priority_order' },
		{ data: 'id' },
		{ data: 'name' },
		{ data: 'sale_order' },
		{ data: 'customer_name' },
		{  data: 'checkbox_status',
				targets:5,
				searchable: false,
				orderable: false,
				className: 'dt-body-center',
			}
		],
       });
   	 $('#SearchButton').click(function(){
          table.draw();
       });  
       table.on( 'row-reorder', function ( e, diff, edit ) {
           var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';
    
           for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
               var rowData = table.row( diff[i].node ).data();
				console.log(rowData);
				serialsDict.push({
					oldData: diff[i].oldData,
					id: rowData['id'],
					priority_order: diff[i].newData
				});
			result += rowData['id']+' updated to be in position '+
			diff[i].newData+' (was '+diff[i].oldData+')<br>';
   	 //  $('#result').html(result);
   	   
           }
    
       });
   	table.on('draw', function () {
   		if (serialsDict.length) {
   			$.post(site_url + 'production/ChangePriority', {
   			serialsDict: serialsDict
   			}, function(data) {}).always(function() {
   				$('#result').html('<div class="alert alert-success col-md-6">Update Priority Order Successfully</div>');
   			  });
   		} ;
   	});
     // Handle click on "Select all" control
   $('#ProductionReportDataTable-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });
   
  
   });
  

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
   
    $(".monthPicker").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });    
    });
   });					
   	
}