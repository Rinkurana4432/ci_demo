$(document).ready(function(){              
    addProcesstype();
    //getDept();
    var checkUrl = `${site_url}production/work_order`;
    var url      = window.location;
    
    var TabInProcess = `${site_url}production/work_order?tab=inprocess_tab`;
    var TabComplete  = `${site_url}production/work_order?tab=complete_tab`;
    var inactive_tab  = `${site_url}production/work_order?tab=inactive_tab`;
    var priority_tab  = `${site_url}production/work_order?tab=priority_tab`;

    if( url == TabInProcess ){
        localStorage.setItem('activeTab','#inprocess_workorder');
    }
 
    if( url == TabComplete ){
        localStorage.setItem('activeTab','#complete_workorder'); 
    }
    if( url == inactive_tab ){
        localStorage.setItem('activeTab','#workorder_inactive'); 
    }
    if( url == priority_tab ){
        localStorage.setItem('activeTab','#workorder_priority'); 
    }
  //alert(checkUrl);
 console.log(checkUrl , url);
    if( checkUrl == url  ){
    //  alert(url);
        switch(localStorage.getItem('activeTab')){
            case '#inprocess_workorder':
              window.location.href = TabInProcess;
            break;
            case '#complete_workorder':
              window.location.href = TabComplete;
            break;
            case '#workorder_inactive':
              window.location.href = inactive_tab;
            break;
            case '#workorder_priority':
              window.location.href = priority_tab;
            break;

        }
    }

})    

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
                    var maxProcess = 100; //maximum input boxes allowed
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
    uploadImage();
    //addImages();
    tags();
    $(document).on("click",'.workOrderModal',function(){
        $("#work_order_modal").modal('hide');
    });


    $(document).on("click", ".productionTab", function(ev) {
        
        ev.preventDefault();
        var id = $(this).attr('id');
         var tab = $(this).attr('data-id');
        //console.log(tab);
        if(tab == 'routingEdit' || tab == 'routingView' || tab == 'material_availability_page' || tab == 'machine_availability'){
        if($(this).attr('data-title') != ''){
        var edit_title = $(this).attr('data-title'); 
        } else {
        var edit_title = 'BOM Routing Edit'; 
        }
        }

        var url = '';
        switch (tab) {
            /*case 'processEdit':
                url = 'production/editprocess';
                break;  */
                case 'indentEdit':
                url = 'production/indent_edit';
                break;
                case 'deviation_report_view':
                url = 'production/deviation_report_view';
           break;
            case 'machineEdit':
                url = 'production/Add_machine_edit';
                break;
            case 'machineView':
                url = 'production/Add_machine_view';
                break;
             case 'machineViewmat':
                url = 'production/machine_viewmat';
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
            case 'autoproductionPlanView':
                url = 'production/autoproduction_planning_view';
                break;
             case 'productionPlanViewmachineview':
                url = 'production/productionPlanViewmachineview';
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
            case 'AddSimilarJobCardExisting':
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
             case 'dispatched_order_matview':
                url = 'production/dispatched_sale_order_matview';
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
			 case 'work_order_Adddata':
                url = 'production/getProductHtml';
                break;	
            case 'work_order_view':
                url = 'production/work_order_view';
                break;
             case 'work_order_viewmat':
                url = 'production/work_order_viewmat';
                break;  
            case 'work_order_purchase_indent':
                url = 'production/add_purchase_indent';
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
            case 'RawMaterialReportQty':
                url = 'production/raw_material_by_uom';
                break;
            case'RawMaterialReportQtysaleorder':
              url = 'production/RawMaterialReportQtysaleorder';
                break;  
            case 'routingEdit':
            url = 'production/routingEdit';
            break;
            case 'routingView':
            url = 'production/routingView';
            break;  
            case 'material_availability_page':
            url = 'production/reservedMat';
            break; 
            case 'machine_availability':
            url = 'production/machineAvailability';
            break;     
            
        }

        console.log("fff", tab);
        if (tab == 'convertToProd') {
            $('.tabclass').html('Production Data');
        }
        if (tab == 'create_work_order') {
            $('.sale_order_work_order').html('Work Order');
        }
        if (tab == 'indentEdit') {
        $('.tabclass').html('Create Work Order Indent');
        }
        if (tab == 'productionPlanEdit') {
            $('.tabclass').html('Production Planning');
        }

        if(tab == 'AddSimilarJobCardExisting'){
            var ajaxData = {
                id:id,
                existing :true,
            };
        } else if(tab == 'indentEdit'){
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
                if (tab == 'ProductionMonthlyPlannedVsActualReportView' || tab == 'ProductionReportView' || tab == 'ProductionReportAdd' ) {
                     $('.production_modal').modal('show');
                    $('.production_modal .modal-body-content').html(data);
                }  else if(tab == 'RawMaterialReportQty'){
                    $("#work_order_modal").modal({
                        show: false,
                        //backdrop: 'static'
                    });
                    $('#work_order_modal').modal('show');
                    $('#work_order_modal .modal-body-content').html(data); 

                } else if(tab == 'RawMaterialReportQtysaleorder'){
                    $("#work_order_modal").modal({
                        show: false,
                        //backdrop: 'static'
                    });
                    $('#work_order_modal').modal('show');
                    $('#work_order_modal .modal-body-content').html(data); 
                } else{
                     $("#production_modal").modal({
                        show: false,
                        backdrop: 'static'
                    });
                  if(tab == 'work_order_purchase_indent'){
                        $('#production_modal .modal-title').text('Purchase Indent');
                    } else if(tab == 'routingEdit' || tab == 'routingView' || tab == 'material_availability_page' || tab == 'machine_availability'){
                        $('#production_modal .modal-title').text(edit_title);
                    } else {
                        $('#production_modal .modal-title').text('Production');
                    }
                    if(tab == 'routingEdit'){
                    //$('#production_modal_edit').modal('show');
                    $("#production_modal_edit").modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                    });
                    $('#production_modal_edit .modal-body-content').html(data);
                     }
                    else if(tab == 'routingView'){
                    $('#production_modal_view').modal('show');
                    $('#production_modal_view .modal-body-content').html(data);
                     } else if(tab == 'machine_availability'){
                    $('#production_modal').modal('show');
                    $('#production_modal .modal-body-content').html(data);
                    } else if(tab == 'material_availability_page'){
                    $('#productionMR_modal').modal('show');
                    $('#productionMR_modal .modal-body-content').html(data);
                    $('#productionMR_modal .modal-title, #productionMR_modal .__reservedQuantity, #productionMR_modal .label_text').text(edit_title);
                    $(' #productionMR_modal .mat_action').val(edit_title);                
                     } else if (tab == 'indentEdit') {
                        $('#productionPI_modal').modal('show');
                        $('#productionPI_modal .modal-body-content').html(data);
                     } else {
                    $('#production_modal').modal('show');
                    $('#production_modal .modal-body-content').html(data); 
                }
                }
        
                    if ($('#btnPrint').length !== 0) {
                        document.getElementById("btnPrint").onclick = function() {
                            printElement(document.getElementById("printView"));
                        }
                    }
                    if(tab == 'work_order_purchase_indent'){
                        getDeliveryAddress();
                        dateFunction();
                        addMoredocuments();
                        init_select_forAdd_suplier();
                    }
 

                    if (tab == 'production_department_edit') {
                        addMoreDepartments();
                        get_company_location();
                        get_company_location();
                        // get_company_unit();
                    }
                    if(tab =='indentEdit' ){
                      IndentAddMoreMaterial();
                      keyupFunction();
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
                            // $('.department').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + companyUnit + '"');
                             var companyUnitnewedit = $('#compny_branch_id').val(); 
                                if (companyUnitnewedit) {
                                    $('.department').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + companyUnitnewedit + '"');
                                }else{
                                    $('.department').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + companyUnit + '"');
                                }
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
                    } else if (tab == 'jobCardEdit' || tab == 'routingEdit' || tab == 'routingView') {
                        addMaterialDetail();
                        addScrapDetail();
                         addMaterialDetail11();
                        get_parameter_value();
                        machineProcess();
                        getUom();
                        getsubBom();
                        getOutputsubBom();
                        expandBom();
                        expandOutputMat();
                        getMaterialName();
                        keyupFunction();
                        textareaWrap();
                        addMaterial_inputDetail();
                        addMaterial_outputDetail();
                        addAttachment_InJobCard();
                        addmachineForProcesstype();
                        addProcesstype();
                        keyup_function_to_check_qty();
                        updateProcessId();


                    } else if (tab == 'AddSimilarJobCard' || tab == 'AddSimilarJobCardExisting') {
                        
                       addMaterialDetail();
                        addScrapDetail();
                        addMaterialDetail11()
                        get_parameter_value();
                        machineProcess();
                        getUom();
                        getsubBom();
                        getOutputsubBom();
                        expandBom();
                        expandOutputMat();
                        getMaterialName();
                        updateProcessId();
                        keyupFunction();
                        textareaWrap();
                        keyup_function_to_check_qty();
                        addmachineForProcesstype();
                        addProcesstype();
                    } else if (tab == 'productEdit') {
                        


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
                        auto_AddRowPlan();
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
                        auto_AddRowPlan();
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

                    } else if (tab == 'create_work_order' || tab == 'work_order_edit' || tab == 'work_order_Adddata') {
                        dateFunction();
                        getQtyValue();  
                        UpdatePendingQtyValue();
                        getMaterialIdFromWorkOrder();
                        getUom();
                        getsubBom(); 
                        getOutputsubBom();
                        expandBom();
                        expandOutputMat();
						addMoreSale_orderMaterial();
						// addMat_DtlOn_WorkOrder();
                    } else if (tab == 'add_new_report') {
                        //  addMaterialDetail();
                        get_parameter_value();
                        machineProcess();
                        getUom();
                        getsubBom();
                        getOutputsubBom();
                        expandBom();
                        expandOutputMat();
                        //  getMaterialName();
                        //  keyupFunction();
                        //  textareaWrap();
                        //  addAttachment_InJobCard();
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
                     init_select_forAdd_suplier();
                     autoPrintProduction();
                }
            }
        });
    });


});

function custom_getdata(){
     $('.date').on('change', function() {
      // # console.log("hdhdh");
       // if (window.location.href == site_url + 'production/production_data') {
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
                            console.log(result1);
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


                    var machine_append_Data = '<div id="index_' + i + '" class="rTableRow mobile-view"><div class=" rTableCell" style="padding: 3px 10px;"><label>Select</label><input type="hidden" value="' + Wages_perpeice + '" name="wage_perpiece_both" class="selectedOption"><input type="radio" id="radio_id_btn1" name="wages_or_per_piece[' + i + '][0]_' + i + '" checked value="wages" ' + check + ' class="wages" ' + disabledWages + '><span for="defaultRadio">Wages</span><input type="radio" id="radio_id_btn1" name="wages_or_per_piece[' + i + '][0]_' + i + '" value="per_piece" class="per_piece_rate" ' + checkPerpiece + ' ' + disbaled + '><span for="defaultRadio">Per Piece</span></div><div class=" rTableCell"><label>Machine Name</label><input data-toggle="tooltip" class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[' + i + '][0]" placeholder="Machine Name"  type="text" value="' + machnine_nam + '" title="' + machnine_nam + '" readonly><input  data-toggle="tooltip" class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + i + '][0]" placeholder="Machine Name" type="hidden" value="' + machnine_id + '" title="' + machnine_id + '"readonly><input  data-toggle="tooltip" class="form-control col-md-2 col-xs-12 machnine_grp" name="machine_grp[' + i + '][0]" placeholder="Machine Name"  type="hidden" value="' + machnine_grp + '" title="' + machnine_grp + '"readonly></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" id ="work_order" name="work_order[' + i + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_id + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option></select><input type="hidden"  name="sale_order[' + i + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId dis" name="product_name[' + i + '][0]" width="100%" tabindex="-1" aria-hidden="true" ><option>Select Option</option></select></div><div class="totalAmountPorduciton rTableCell" style="display:none;"><input id="salary" class="form-control col-md-7 col-xs-12 salary" name="salary[' + i + '][0]" placeholder="salary"  type="text" value=""  onkeypress="return float_validation(event, this.value)"></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + i + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + i + '][0]" placeholder="BOM Routing Number" readonly  type="text" value=""></div><div class=" rTableCell"><label>Process Name</label><select onchange="get_outputPD(event,this);" class="form-control process_name" name="process_name[' + i + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + i + '][0]" class="inpt_outpt_process" value=""></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_id + ' AND save_status = 1"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm"  name="npdm_name[' + i + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class=" rTableCell"><label>Workers</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[' + i + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" data-where="created_by_cid=' + current_login_com_id + ' AND active_inactive = 1" width="100%" ><option>Select Option</option></select></div><div class="hrs rTableCell"><label>Hrs in wages,% in per piece</label><span class="show_msg" style="display:none;">Total %age should be 100</span></div><div class=" rTableCell"><label>Production Output</label><input id="output" class="form-control col-md-7 col-xs-12 output" name="output[' + i + '][0]" placeholder="output"  type="text" value="" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="rTableCell" style="display:none;"><input id="wastage" class="form-control col-md-7 col-xs-12" name="wastage[' + i + '][0]" placeholder="wastage" type="hidden" value="" readonly></div><div class="rTableCell"><label>Labour costing</label><input  class="form-control col-md-7 col-xs-12 labour_costing" name="labour_costing[' + i + '][0]" placeholder="labour costing"  type="text" value="" onkeypress="return float_validation(event, this.value)" onkeyup="keyupFun(event,this)"  ' + readonlyLabourCosting + '></div><div class=" rTableCell"><label>Remarks</label><textarea id="remarks" class="form-control col-md-7 col-xs-12" name="remarks[' + i + '][0]" placeholder="remarks"  type="number" value="" ></textarea></div><div class="rTableCell"><input type="button" class="addRow btn btn-success btn-xs" value="add"/></div></div>';
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
       // }

    });

}

function custom_planning(){
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
                            $(' <div class="rTableRow mobile-view2"><div class="rTableHead"><label>Machine Name<span class="required">*</span></label></div><div class="rTableHead"><label>Party Specification</label></div><div class="rTableHead"><label>Work order</label></div><div class="rTableHead"><label>Product Name</label></div><div class="rTableHead"><label>BOM Routing Product Name</label></div><div class="rTableHead"><label>Assign Process</label></div><div class="rTableHead"><label>NPDM</label></div><div class="rTableHead"><label>Worker</label></div><div class="rTableHead"><label>Output1d</label></div><div class="rTableHead" ><label></label></div></div>"').prependTo(".app_div_planing");
                            var k = 0;
                            for (var j = 0; j < lenth; j++) {
                                var machnine_nams = machineData1[j].machine_name;
                                var machnine_ids = machineData1[j].id;
                                var machnine_grp_id = machineData1[j].machine_group_id;
                                // alert(machnine_nam);
                                var machine_append_Data33 = '<div class="rTableRow mobile-view" id="index_' + k + '"><div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="' + machnine_nams + '" readonly><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_ids + ' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_grp_id + ' readonly></div><div class="rTableCell"><label>Party Specification</label><textarea class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[' + k + '][0]"></textarea></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="work_order[' + k + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option></select><input type="hidden"  name="sale_order[' + k + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId dis" name="product_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true" ><option>Select Option</option></select></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + k + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + k + '][0]" placeholder="BOM Routing Number" readonly  type="text" value=""> <span style="color: red;" id="massege_wor_' + k + '" ></span> </div><div class="rTableCell"><label>Process Name</label><select onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name_' + k + '" name="process_name[' + k + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + k + '][0]" class="inpt_outpt_process" value=""></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_ids + ' AND save_status = 1"  data-id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm_name_' + k + '"  name="npdm_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class="rTableCell worker-row"><label>Worker</label><select multiple="" class="worker_name form-control col-md-2 col-xs-12 "  id="worker_name_' + k + '" name="worker_name[' + k + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + '"><option>Select Option</option></select></div><div class="rTableCell"><label>Output2d</label><input  class="form-control col-md-2 col-xs-12" name="output[' + k + '][0]" id="output_' + k + '" placeholder="output" type="number" value=""></div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR btn btn-success btn-xs"  value="Add" /></div> </div></div>';$(".app_div_planing").append(machine_append_Data33);

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
$(document).ready(function(e) {
    //customfun();
                        get_company_department();
                        custom_getdata();
                        custom_planning();
                        auto_custom_planning();
                        fetchJobCardValue();
                        textareaWrap();
                        addMulitpleRow();
                        get_jobcard_on_select();
                        get_company_location();
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
                         init_select2();
                        init_select21();
                        init_select221();
                        init_select2so();
                        for_add_multiple_tags_for_worker();
                        //Print_data_new();
                        select_on_npdm_sale_order();

                        AddRowPlan();
                        auto_AddRowPlan();
                        get_jobcard_on_select();
                        get_company_location();
                        get_company_department();
                        //keyupFun();
                        dateFetch();
                        getshiftAccrdng_toDept();
                        init_select21();
                        select_on_npdm_sale_order();
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
        $(parameter).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label >Parameter</label><input type="text" class="form-control item_name" name="machine_parameter[]" id="machine_parameters" placeholder="Enter machine Parameters"></div><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label>UOM</label><select class="uom selectAjaxOption select2 form-control select2-hidden-accessible"  tabindex="-1" aria-hidden="true"  name="uom[]" data-id="uom" data-key="id" data-fieldname="uom_quantity" width="100%" data-where="created_by_cid=' + logged_user + ' OR created_by_cid = 0 AND active_inactive = 1"><option value="">Select Option</option></select></div><button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');

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
    var maxfields = 100;
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
        //  measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        //});
        if (y < maxfields) {
            y++;
            $(process).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Process Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible processType_id select2" required="required" name="process_type[]" data-id="process_type" data-key="id" data-fieldname="process_type" data-where="created_by_cid=' + logged_user + '" tabindex="-1" aria-hidden="true" onchange="getProcess(event,this)"><option value="">Select option</option>    </select></div><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label >Process</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id" id="process_name_id" name="process_name[]" width="100%" tabindex="-1" aria-hidden="true" required="required" data-id="1add_process" data-key="id" data-fieldname="process_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + '"><option value="">Select Option</option></select></div><button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');

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

    $("#auto_planningDate").datepicker({
        dateFormat: 'dd-mm-yy', 
        autoclose: true,
        defaultDate: -1,
        minDate:'-1d'
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
    var input = 125;
    var input_mat = $(".input_holder");
    var add_mat = $(".addmaterial");
    var logged_user = $('#loggedUser').val();
    //var y = 1; 
    $(add_mat).click(function(e) {
     var z = $('.input_fields_wrap .jc_well').length;
      z++;
        // e.preventDefault();
        // var measurmentArray = '';
        // $.each( measurementUnits, function( key, value ) {
        // measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        // });
        if (y < input) {
            y++;
            $(input_mat).append('<tr class="jc_well " id="chkIndex_' + z + '" ><td><div style="display: flex;"><div class="expand_dropwon form-group"><span class="up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;"  onclick="expandBom(event,this);" jc_number="" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span style="display: none;" class="down_arrow"><i onclick="expandBom(event,this);" jc_number="" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span></div><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" required="required" name="material_type_id[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div></td><td class="col-md-2 col-sm-12 col-xs-12 form-group"><select  class="materialNameId_chkIndex_' + z + ' materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2"  id="mat_name" required="required" name="material_name[]" onchange="getUom(event,this);  getsubBom(event,this);"></select></td> <input type="hidden" name="dmdata[]" class="dmdata" value=""><td class="col-md-1 col-sm-12 col-xs-12 form-group"><input  class="material_qty_chkIndex_' + z + ' form-control col-md-7 col-xs-12 qty actual_qty keyup_event" name="quantity[]" placeholder="Qty" required="required" type="text" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></td><td class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="uom_value1[]" class="form-control col-md-7 col-xs-12  uom" placeholder="uom." value="" readonly><input type="hidden" name="uom_value[]" class="uomid" readonly value=""></td><td class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="price[]" class="form-control col-md-7 col-xs-12 priceValue" placeholder="Price" value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></td><td class="col-md-1 col-sm-12 col-xs-12 form-group"><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]" class="form-control col-md-7 col-xs-12  total" placeholder="Total Amount" value="" readonly></td><td class="col-md-2 col-sm-12 col-xs-12 form-group"><input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="" readonly></td><td><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></td></tr>');


            var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        //getMaterialIssue();

       
        keyup_function_to_check_qty();
        getMaterials(mat_id, y);
        init_select2();
         addMaterials();
        addMaterial_inputDetail();
        addMaterial_outputDetail();
        //get_Qty_UOm();
        getUom();
        getsubBom();
        getOutputsubBom();
        expandBom();
        expandOutputMat();

    });
    $(input_mat).on("click", ".remove_input", function(e) {
        e.preventDefault();
        $(this).parents('tr').remove();
        y--;
        keyupFunction(event, this);
    });
    $(input_mat).on("keyup", "#material_qty", function(e) {
        e.preventDefault();
        var material_qty=$(this).val();
       
            
       if (material_qty ) {
       $(this).closest('.jc_well').find('#material_qty').val(material_qty);
         //$(this).closest('.well').find('#material_qty').val(material_qty);
      
       }
      
    });
}


  $(document).on("keyup", "#operating_screp", function(e) {
     e.preventDefault();
      var operating_scrpin=$(this).val();
         /*var operating_screp_value = $(this).val();
          var m = [];*/
          $('.well').each(function(){       
                            if( typeof $(this).find('#material_qty').val() !== 'undefined' ){
                                
                                var material_qty  = $(this).find('#material_qty').val();
                                 var calculeteinall_data = material_qty * operating_scrpin/100;
                                 var add_scrap_data = parseInt(calculeteinall_data) + parseInt(material_qty)
                               $('#operating_screp').trigger('keyupFunction()');
                                $(this).find('.qtyincludescrap').val(add_scrap_data); 


                            }                                        
                        });
    });
$(document).on("change","#scrap_typeinpre", function(e){
     e.preventDefault();
    var wellid = $(this).closest('.well').attr("id");


    var scrapvalue =  $(this).val();
    if (scrapvalue=='operating_scrap') {
        $(`#${wellid}`).find('#operating_scrap').show();
        $(`#${wellid}`).find('#assembly_scrap').hide(); 
        $(`#${wellid}`).find('#component_scrap').hide();
    }else if(scrapvalue=='assembly_scrap'){
      $(`#${wellid}`).find('#assembly_scrap').show();
        $(`#${wellid}`).find('#component_scrap').hide(); 
          $(`#${wellid}`).find('#operating_scrap').hide();

    }else if(scrapvalue=='component_scrap'){
          $(`#${wellid}`).find('#component_scrap').show();
          $(`#${wellid}`).find('#assembly_scrap').hide();
            $(`#${wellid}`).find(' #operating_scrap').hide();
    }


});
/**********************key up function for job card to caluclate material costing****************/
function keyupFunction(evt, t) {
    var closestId = $(t).closest(".well, .jc_well").attr("id");
    var qty, price, grand_total;
    qty = parseFloat($("#" + closestId + " input[name='quantity[]'").val());
    price = parseFloat($("#" + closestId + " input[name='price[]'").val());
    TotalAmount = parseFloat(qty) * parseFloat(price);
    if (isNaN(TotalAmount)) {
        var TotalAmount = 0;
    }
     var grandtot = 0;
    $("input[name='total[]']").each(function() {
        grandtot += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());
    }); 
     $("#grandTotal").val(grandtot.toFixed(2));
    $("#" + closestId + " input[name='total[]'").val(TotalAmount.toFixed(2));
    $('#' + closestId + ' .expand_bom_'+ closestId ).html('');
    $('#' + closestId + ' #expand').prop('selectedIndex',0);
    $('#' + closestId + ' .expand_bom_'+ closestId ).css('display', 'none');
    subtotal();
}

function subtotal() {
    /*calulate grand total of all amount enter*/
    var grandtot = 0;
    $("input[name='total[]']").each(function() {
        grandtot += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());
    });
     $("#grandTotal").val(grandtot.toFixed(2));
    /*calualte total of wuantity enter*/
    var Totalqty = 0;
    $("input[name='quantity[]']").each(function() {
        Totalqty += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());
    });
    if($('#lot').val() != ''){
    var Totalqty1 = $('#lot').val();
    } else {
    var Totalqty1 = '0';
    }
    var materialCosting = grandtot / Totalqty1;
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
        //output_wages = (($("#" + closestId).find('.output').val()) != '') ? (parseFloat($("#" + closestId).find('.output').val())) : 0;
         var  output_wages =0;
       $("#" + closestId).find('.output').each(function() {
             // output_wagessx +=(($("#" + closestId).find('.output').val()) != '') ? (parseFloat($("#" + closestId).find('.output').val())) : 0;
             var outputTotal;
             if ($(this).val()==null) {
                 outputTotal = 0;
             }else{
                outputTotal =(isNaN($(this).val())) ? 0 : parseFloat($(this).val());
             }
                
               output_wages += outputTotal;
              
        });
        console.log("output wages", output_wages);
        var one_Day_Salary = IndividualWorkersalary / totalDays;
        var one_Hr_Salary = one_Day_Salary / 8 ;
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
       // output = (($("#" + closestId).find('.output').val()) != '') ? (parseFloat($("#" + closestId).find('.output').val())) : 0;
        var  output =0;
       $("#" + closestId).find('.output').each(function() {
             // output = (($("#" + closestId).find('.output').val()) != '') ? (parseFloat($("#" + closestId).find('.output').val())) : 0;
             var outputTotalTwo;
             if ($(this).val()==null) {
                 outputTotalTwo = 0;
             }else{
                outputTotalTwo =(isNaN($(this).val())) ? 0 : parseFloat($(this).val());
             }
                 output += outputTotalTwo;
              
        });
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
    var machine = 50;
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
           
           // alert(well);
            console.log("weeee", well);
            var logged_user = $('#loggedUser').val();

            $(machine_detail).append('<div class="well well2 scend-tr" id="chckIndex_' + well + '" data-id="frst_div_' + well + '"><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Process Name<span class="required">*</span></label><div class=" form-group col-md-6 col-sm-12 col-xs-12"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible process_name_id __processDetails" name="process_name[]" tabindex="-1" aria-hidden="true" onchange="getMachineName(event,this),updateInputProcess(event,this)" data-where="process_type_id=' + processType + '" data-id="add_process" data-key="id" data-fieldname = "process_name"><option value=""></option> </select></div></div><input type="hidden" class="__countProcess" name="count_process[]" value="'+well+'"><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Description</label><div class="col-md-6 col-sm-12 col-xs-12"><textarea name="description[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Description"></textarea></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Do\'s</label><div class="col-md-6 col-sm-12 col-xs-12"><textarea name="dos[]" class="form-control col-md-7 col-xs-12 textarea" placeholder="Do\'s"></textarea></div></div><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Dont\'s</label><div class="col-md-6 col-sm-12 col-xs-12"><textarea name="donts[]" class="form-control col-md-7 col-xs-12 textarea" placeholder=" Dont\'s"></textarea></div></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><div class="item form-group "> <label class="col-md-3 col-sm-12 col-xs-12">Attachment</label> <input type="hidden" name="old_doc_' + well + '" value=""><div class="col-md-6 col-sm-12 col-xs-12 "> <input type="hidden" name="old_doc_1" value=""><div class="col-md-12 col-sm-12 col-xs-12 add_documents" ><div class="col-md-10 col-sm-12 col-xs-10 form-group doc" id="abc_' + well + '"> <input type="file" class="form-control col-md-7 col-xs-12 documentsAttach" name="documentsAttach_frst_div_' + well + '[]" value=""></div> <button class="btn edit-end-btn add_moreDocs" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div></div><div class="well col-container " style="display:table; clear:both; border-bottom:1px solid #c1c1c1;"><div class="total_machines_ids" id="ParameterIndexinput_' + well + '"><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Machine name</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" ><div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" name="machine_name[]" tabindex="-1" aria-hidden="true" ><option value="">Select Option</option> </select></div></div></div><div class="item form-group col-md-2 col-xs-12"><div class="col"><label>Machine Parameter</label></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"><div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"><div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group"><div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div></div></div><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Production per Shift</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Workers</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="workers[]" class="form-control col-md-7 col-xs-12 workers" placeholder="workers"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Avg Salary</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="avg_salary[]" class="form-control col-md-7 col-xs-12 avg_salary" placeholder="Avg Salary"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Total Cost</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="total_cost[]" class="form-control col-md-7 col-xs-12 total_cost" readonly="readonly" placeholder="Total Cost"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Per Unit Cost</label></div><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" readonly="readonly" name="per_unit_cost[]" class="form-control col-md-7 col-xs-12 per_unit_cost" placeholder="Per Unit Cost"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" ><div class="col" ><label>Action</label></div><div class="col-md-12 col-sm-12 col-xs-12"  style="text-align: center;border-bottom: 1px solid #aaa;"> <button class="btn edit-end-btn addmachineForProcesstype" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div></div><div class="col-md-12 col-sm-12 col-xs-12 " style="padding: 0px;"><div class=" col-md-12 well_Sech_input" style="padding: 0px;"><div class="col-md-12 input_cls chk_idd_input" id="sechIndexinput_' + well + '" ><h3 class="Material-head"> INPUT<hr></h3><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Type</label> <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type material_type_id material_type_input_id_1 select2"  name="material_type_input_id_' + well + '[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this),updateProcessId(event,this)" id=""><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Name</label> <select class="materialNameId form-control col-md-2 col-xs-12 material_input_name_1 selectAjaxOption select2 Add_mat_onthe_spot"  name="material_input_name_' + well + '[]" onchange="getUom_input(event,this);"><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">Quantity</label><input type="text"  name="quantity_input_' + well + '[]" class="form-control col-md-7 col-xs-12 qty_input actual_qty quantity_input_1" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">UOM</label><input type="text" name="uom_value_input1_' + well + '[]" class="form-control col-md-7 col-xs-12 uom_input uom_value_input1_1" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_input_' + well + '[]" class="uom_input_val uom_value_input_1" readonly value=""></div><div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;"> <label class="col col-md-12" style="padding: 17px 6px;"></label><button class="btn edit-end-btn add_moreinputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div><div class="col-md-12 well_Sech_output" style="padding:0px;"><div class="col-md-12 output_cls chk_idd_output" id="sechIndexoutput_' + well + '" style="padding:0px;"><h3 class="Material-head"> OUTPUT<hr></h3><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Type</label> <select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id material_type select2" name="material_type_output_id_' + well + '[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"> <label class="col col-md-12">Material Name</label> <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  name="material_output_name_' + well + '[]" onchange="getUom_output(event,this);"><option value="">Select Option</option> </select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">Quantity</label><input type="text" name="quantity_output_' + well + '[]" class="actual_qty form-control col-md-7 col-xs-12 qty_output" placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col col-md-12">UOM</label><input type="text" name="uom_value_output1_' + well + '[]" class="form-control col-md-7 col-xs-12 uom_output" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_output_' + well + '[]" class="uom_output_val" readonly value=""></div><div class="col-md-1 col-xs-12 col-sm-12 form-group" style="text-align: center;border-bottom: 1px solid #aaa;"> <label class="col col-md-12" style="padding: 17px 6px;"></label><button class="btn edit-end-btn add_moreoutputss" style="margin-bottom: 3%;" type="button"><i class="fa fa-plus"></i></button></div></div></div></div> <button class="btn btn-danger remove_machine" type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div>');

            get_parameter_value();
            textareaWrap();
            addAttachment_InJobCard();
            addMaterial_outputDetail();
            addMaterial_inputDetail();
            init_select2();
            getUom_input();
            getUom_output();
            addmachineForProcesstype();
            addProcesstype();
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
    var input = 100;
    var input_mat = $(".col-container");
    var add_machine_button = $(".addmachineForProcesstype");
    var logged_user = $('#loggedUser').val();
    $(add_machine_button).click(function(e) {
        e.preventDefault();
        let options = "";
        for (let i = 0; i < 60; i++) {
        if (i < 10) {
        i = "0"+i;
        }
        options += '<option value="'+i+'">'+i+'</option>';
        }
        var y = $(this).parents('.col-container').find('.total_machines_ids').length;
        var div_id = $(this).closest('.total_machines_ids').attr('id');
        var div_len = $(".col-container").length;

        var process_id = $(this).parents().closest('.well2').find('.process_name_id :selected').val();
        var machine_id = $(this).parents().closest('.well2').find('.machine_name_id :selected').val();

        console.log("process_id1===>>>",process_id);
        console.log("machine_id===>>>>>",machine_id);
        $('.input_val').val(y + 1);
        if (y < input) {
            y++;
            $(this).closest('#' + div_id).parent().append('<div class="total_machines_ids" id="ParameterIndexinput_' + y + '"> <div class="item form-group col-md-1 col-xs-12" ><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly"> <select class="form-control selectAjaxOption select2 select2-hidden-accessible machine_name_id" name="machine_name[' + y + ']" tabindex="-1" aria-hidden="true"> <option value="">Select Option</option> </select> </div></div></div><div class="item form-group col-md-2 col-xs-12"><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"> <div class="col-md-12 col-sm-6 col-xs-12 form-group parameter_name form-group"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group" style="border-right: 1px solid #c1c1c1;"> <div class="col-md-12 col-sm-6 col-xs-12 form-group uom"></div></div><div class="col-md-4 col-sm-4 col-xs-4 form-group"> <div class="col-md-12 col-sm-6 col-xs-12 form-group value"></div></div></div><div class="item form-group col-md-1 col-xs-12" ><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text"  name="production_shift[' + y + ']" class="form-control col-md-7 col-xs-12 production_shift" placeholder="production per Shift"><br><br></div></div><div class="item form-group  col-md-2 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="setup_hr[' + y + ']" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR"><select name="setup_min[' + y + ']" class="form-control col-md-7 col-xs-12" style="width: 30%;">'+options+'</select><select name="setup_sec[' + y + ']" class="form-control col-md-7 col-xs-12" style="width: 30%;">'+options+'</select><br><br> </div></div><div class="item form-group  col-md-2 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="machine_time_hr[' + y + ']" class="form-control col-md-7 col-xs-12" style="width: 32%;" placeholder="HR"><select name="machine_time_min[' + y + ']" class="form-control col-md-7 col-xs-12" style="width: 30%;">'+options+'</select><select name="machine_time_sec[' + y + ']" class="form-control col-md-7 col-xs-12" style="width: 30%;">'+options+'</select><br><br></div></div><div class="item form-group col-md-1 col-xs-12" > <div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="workers[' + y + ']" class="workers form-control col-md-7 col-xs-12" placeholder="workers"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" > <div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="avg_salary[' + y + ']" class="avg_salary form-control col-md-7 col-xs-12" placeholder="Avg Salary"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" > <div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="total_cost[' + y + ']" class="total_cost form-control col-md-7 col-xs-12" readonly="readonly" placeholder="Total Cost"><br><br></div></div><div class="item form-group col-md-1 col-xs-12" > <div class="col-md-12 col-sm-12 col-xs-12 form-group" > <input type="text" name="per_unit_cost[' + y + ']" class="per_unit_cost form-control col-md-7 col-xs-12" readonly="readonly" placeholder="Per Unit Cost"><br><br></div></div><div class="item form-group col-md-1 col-xs-12 RemovemachineForProcesstype" > <div class="col-md-12 col-sm-12 col-xs-12"  style="text-align: center;border-bottom: 1px solid #aaa;"> <button class="btn edit-end-btn " style="margin-bottom: 3%;" type="button"><i class="fa fa-minus"></i></button> </div></div></div>');
             get_parameter_value();
             
             $('.total_rows_set').val(y);
            if (process_id != '') {
                var like = '%"process":"' + process_id + '"%';
                $(this).closest('.well2').find('.machine_name_id').attr('data-where', "process LIKE '" + like + "' AND save_status=1");
                $(this).closest('.well2').find('.machine_name_id').attr('data-id', 'add_machine');
                $(this).closest('.well2').find('.machine_name_id').attr('data-key', 'id');
                $(this).closest('.well2').find('.machine_name_id').attr('data-fieldname', 'machine_name');
                //$(this).closest('.well2').find('.machine_name_id').attr('name', 'machine_name[' + process_id + '][]');

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
        $('.total_rows_set').val(y);
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
        var y = $(this).parents('.col-container').find('.total_machines_ids').length;
        //var c = y-1;
        $(getPara).parent().closest('.total_machines_ids').find('.selected_mid').val(machineId);
        $(getPara).parent().closest('.total_machines_ids').find('.MachineParameterReplacement').html(newParmenterHtml);
        // $(getPara).parent().closest('.total_machines_ids').find('.production_shift').attr('name', 'production_shift[' + machineId + '][1]');
        // $(getPara).parent().closest('.total_machines_ids').find('.workers').attr('name', 'workers[' + machineId + '][1]');
        //  $(getPara).parent().closest('.total_machines_ids').find('.avg_salary').attr('name', 'avg_salary[' + machineId + '][1]');
        //   $(getPara).parent().closest('.total_machines_ids').find('.total_cost').attr('name', 'total_cost[' + machineId + '][1]');
        

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
                //var z = c+1;
                for (var i = 0; i < len; i++) {
                    // if(i > 1){
                    // y = y+1;
                    // } 
                    var machine_parameter_1 = dataObj[i].machine_parameter;
                    var uom_1 = dataObj[i].uom;
                    var uomss = dataObj[i].uomnme;

                    var val_1 = '';

                    $(getPara).parent().closest('.total_machines_ids').find('.parameter').attr('value', '');
                    $(getPara).parent().closest('.total_machines_ids').find('.uom').attr('value', '');
                    $(getPara).parent().closest('.total_machines_ids').find('.value').attr('value', '');
                    parameter1 += '<input class="selected_mid" type="hidden" name="' + machineId + '" value="' + machineId + '"><input type="hidden" name="mp_length[' + machineId + ']['+i+']" value="'+len+'"><input type="text" placeholder="Parameter" name="parameter[' + machineId + '][0]['+i+']" class="form-control col-md-7 col-xs-12 parameter" value="' + machine_parameter_1 + '" readonly>';
                    uom1 += '<input type="hidden" placeholder="UOM" name="uom[' + machineId + '][0]['+i+']" class="form-control col-md-7 col-xs-12 uom" value="' + uom_1 + '" readonly><input type="text" placeholder="UOM" name="uomsssss[' + machineId + '][0]['+i+']" class="form-control col-md-7 col-xs-12 uom" value="' + uomss + '" readonly>';
                    value1 += '<input type="text" placeholder="Value" name="value[' + machineId + '][0]['+i+']" class="form-control col-md-7 col-xs-12 value" value="' + val_1 + '">';
                    //  $(getPara).closest('.well').find('.machine_name_dispaly').html(machine_name);
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
        //$('#process_name_id').empty();
        $(t).parents().closest('.well').find('.process_name_id').empty();
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

 $.ajax({
            type: "POST",
            url: site_url + 'production/scrapProcessBy',
            data: { 
             id: processType_id
            },
           success: function(scrapProcessBy) { 

                  $('.well').each( function() { 
                  if ($(this).find('#scrap_typeinpre').val()== 'operating_scrap') {                  
                       $(this).find('#scrapProcessBy').html(scrapProcessBy);
                  }
            });
          }
        });  
        $(t).parents('#Details2').find('.well').find('.process_name_id').attr('data-where', 'process_type_id = ' + processType_id + ' AND created_by_cid=' + logged_user);
        $(t).parents('#Details2').find('.well').find('.process_name_id').attr('data-id', 'add_process');
        $(t).parents('#Details2').find('.well').find('.process_name_id').attr('data-key', 'id');
        $(t).parents('#Details2').find('.well').find('.process_name_id').attr('data-fieldname', 'process_name');
        $(t).parents().closest('.well').find('.process_name_id').attr('data-where', 'process_type_id = ' + processType_id + ' AND created_by_cid=' + logged_user);
        $(t).parents().closest('.well').find('.process_name_id').attr('data-id', 'add_process');
        $(t).parents().closest('.well').find('.process_name_id').attr('data-key', 'id');
        $(t).parents().closest('.well').find('.process_name_id').attr('data-fieldname', 'process_name');
        // $('#' + main_div_id + ' .process_name_id').attr('data-where', 'process_type_id = ' + processType_id + ' AND created_by_cid=' + logged_user);
        // $('#' + main_div_id + ' .process_name_id').attr('data-id', 'add_process');
        // $('#' + main_div_id + ' .process_name_id').attr('data-key', 'id');
        // $('#' + main_div_id + ' .process_name_id').attr('data-fieldname', 'process_name');

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
        $(current).closest('.wellsel').find('.set_process_id').css('display', 'inline-block');
        $(current).closest('.wellsel').find('.set_process_id').attr('id', '');
        var data_chkval = $(current).closest('.wellsel').find('.set_process_id').attr('data-chkval');
        var data_index_id = $(current).closest('.wellsel').find('.set_process_id').attr('data-index-id');
        $(current).closest('.wellsel').find('.set_process_id').attr('id', data_chkval+' ~ '+process_name_id+' ~ '+data_index_id);
        $(current).closest('.wellsel').find('.process_detail_set').attr('name', 'process_set_data['+process_name_id+']');
        $(current).closest('.wellsel').find('.final_process').attr('name', 'final_process['+process_name_id+']');
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
    var class_set = $(t).parents().next('td').find('.materialNameId');
    var logged_user = $('#loggedUser').val();
    console.log("loggeduser", logged_user);
    var option = $(t).find('option:selected');
    console.log('option===>>>', option);
    var material_type_id = selProcessType != '' ? selProcessType : $(option).val();
    if (material_type_id === undefined) {
        material_type_id = $('.material_type_id').find('option:selected').val();

    }

    if (material_type_id != '') {
        select3(material_type_id, logged_user, class_set);
    }
}
function select3(material_type_id, logged_user, class_set) {
    class_set.attr('data-where', 'material_type_id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND status=1');
    class_set.attr('data-id', 'material');
    class_set.attr('data-key', 'id');
    class_set.attr('data-fieldname', 'material_name');
    // $('.materialNameId').attr('data-where', 'material_type_id = ' + material_type_id + ' AND created_by_cid=' + logged_user + ' AND status=1');
    // $('.materialNameId').attr('data-id', 'material');
    // $('.materialNameId').attr('data-key', 'id');
    // $('.materialNameId').attr('data-fieldname', 'material_name');

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

        var closestId = $(t).closest(".well, .jc_well").attr("id");
     
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
                    //console.log('data===>>>', data);
                    //var dataObj = JSON.parse(data);
                    var dataObj = JSON.parse(data);
                    if (dataObj) {
                       console.log('=============================>>>>>>',dataObj);
                        var uom = dataObj.uom;
                        var opening_balance = dataObj.opening_balance;
                        var job_card = dataObj.job_card;
                        var uomid = dataObj.uomid;
                        var price = dataObj.cost_price;
                       // console.log("uom", uom);
                       uom = uom.trim();
                      
                        if(closestId == 'chkIndex_1'){//alert(uom    +  '    2223233');
                           $(".first_index").find('.dmdata').val(materialId);
                            $(".first_index").find('.priceValue').val(price);
                            $(".first_index").find('.uom').val(uom);
                            $(".first_index").find('.uomid').val(uomid);
                            $(".first_index").find('.qty').val();
                            $(".first_index").find('.job_card').val(job_card);
                        } else {
                            $(t).closest(".well, .jc_well").find('.dmdata').val(materialId);
                            $(t).closest(".well, .jc_well").find('.priceValue').val(price);
                            $(t).closest(".well, .jc_well").find('.uom').val(uom);
                            $(t).closest(".well, .jc_well").find('.uomid').val(uomid);
                            $(t).closest(".well, .jc_well").find('.qty').val();
                            $(t).closest(".well, .jc_well").find('.job_card').val(job_card);
                            // $("#" + closestId + "").find('.dmdata').val(materialId);
                            // $("#" + closestId + "").find('.priceValue').val(price);
                            // $("#" + closestId + "").find('.uom').val(uom);
                            // $("#" + closestId + "").find('.uomid').val(uomid);
                            // $("#" + closestId + "").find('.qty').val();
                            // $("#" + closestId + "").find('.job_card').val(job_card);
                       }
                       
                       if(closestId == 'chkIndex_1'){
                            $(".edit-row1").find('.dmdata').val(materialId);
                            $(".edit-row1").find('.priceValue').val(price);
                            $(".edit-row1").find('.uom').val(uom);
                            $(".edit-row1").find('.uomid').val(uomid);
                            $(".edit-row1").find('.qty').val();
                            $(".edit-row1").find('.job_card').val(job_card);
                       }
                       
                       
                    }
                }
            }
        });
        var uom = $(this).find('.option').val();
        var closestId = $(t).closest(".well, .jc_well").attr("id");
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
                    //$("#" + closestId + "").find('.qty_input').val(opening_balance);
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
                        //$("#" + closestId + "").find('.qty_output').val(opening_balance);
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
    var input = 50;
    var input_mat = $(".well_Sech_input");
    var add_mat = $(".add_moreinputss");
    var logged_user = $('#loggedUser').val();
    //var y = 1; 
    var y = $('.chk_idd_input').length;
    
    $(add_mat).click(function(e) {
         var div_id = $(this).closest('.input_cls').attr('id');
         var result = div_id.split('_');
        // alert(result[1] ); 
         var div_len =result[1];
       //var div_len = $(".well_Sech_input").length;
         
        $('.input_val').val(y + 1);


        if (y < input) {
            y++;

            // div_len = 1;

            $(this).closest('#' + div_id).parent().append('<div class=" col-md-12 chk_idd_input" id="sechIndexinput_' + y + '" ><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" name="material_type_input_id[' + y + ']" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="material_input_name[' + y + ']" onchange="getUom_input(event,this);"><option value="">Select Option</option></select></div><div class="col-md-3 actual_qty col-sm-12 col-xs-12 form-group"><input type="text"  name="quantity_input[' + y + ']" class="form-control col-md-7 col-xs-12  qty_input"  placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" name="uom_value_input1[' + y + ']" class="form-control col-md-7 col-xs-12  uom_input" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_input[' + y + ']" class="uom_input_val" readonly value=""></div> <div class="col-md-1 col-xs-12 col-sm-12 form-group remv_inputss" style="text-align: center;border-bottom: 1px solid #aaa;"><button class="btn btn-danger " type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div>');


            var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        getMaterials(mat_id, y);
        init_select2();
        getUom();
        getsubBom();
        getOutputsubBom();
        expandBom();
        expandOutputMat();
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
    var input = 50;
    var input_mat = $(".well_Sech_output");
    var add_mat = $(".add_moreoutputss");
    var logged_user = $('#loggedUser').val();
    //var y = 1; 
    var y = $('.chk_idd_output').length;

    //alert(y);
    //$(add_mat).click(function(e) {
    $(document).off('click','.add_moreoutputss').on('click', '.add_moreoutputss', function(e) {
        var div_id = $(this).closest('.output_cls').attr('id');
         var result = div_id.split('_');
         //alert(result[1] ); 
         var div_len =result[1];
        //var div_len = $(".well_Sech_output").length;
        $('.output_val').val(y + 1);

        if (y < input) {
            y++;
           // div_len=1;
            $(this).closest('#' + div_id).parent().append('<tr class="output_cls chk_idd_output " id="sechIndexoutput_' + y + '" style="padding:0px;"><td><div style="display: flex;"><div class="expand_dropwon form-group"><span class="2 up_arrow" style="display: none;"><i style="font-size: 20px;font-weight: bold;" onclick="expandOutputMat(event,this);" jc_number="" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow" style="display: none;"><i onclick="expandOutputMat(event,this);" jc_number="" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span></div><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type"  name="material_type_output_id[' + y + ']" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div></td><td><select  class="materialNameId_sechIndexoutput_' + y + ' materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot"  name="material_output_name[' + y + ']" onchange="getUom_output(event,this);  getOutputsubBom(event,this);"><option value="">Select Option</option></select></td><td><input type="text" name="quantity_output[' + y + ']" class="form-control col-md-7 col-xs-12 actual_qty qty_output"  placeholder="Qty." value="" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" onkeypress="return float_validation(event, this.value)"></td><td><input type="text" name="uom_value_output1[' + y + ']" class="form-control col-md-7 col-xs-12  uom_output" placeholder="uom." value="" readonly><input type="hidden" name="uom_value_output[' + y + ']" class="uom_output_val" readonly value=""></td><td></td><td></td><td ><input style="border-right: 1px solid #c1c1c1 !important;" type="text" id="sub_bom" class="form-control col-md-7 col-xs-12  total" placeholder="Sub-BOM" value="" readonly=""></td><td class="remv_output" style="text-align: center;border-bottom: 1px solid #aaa;"><button class="btn btn-danger " type="button"><i class="fa fa-times" aria-hidden="true"></i></button></td></tr>');


            var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        getMaterials(mat_id, y);
        init_select2();
        getUom();
        getsubBom();
        getOutputsubBom();
        expandBom();
        expandOutputMat();
        getUom_input();
        getUom_output();

    });
    $(document).on("click", ".remv_output", function(e) {
        e.preventDefault();

        $(this).parents('tr').remove();
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
       
        cols += '<div class="rTableCell"><label>Work Order</label><select class="form-control dis removeeee selectAjaxOption select2 select2-hidden-accessible WorkOrderId"  onchange="getMaterialNameWorkorder(event,this)"  name="work_order[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option value="">Select Option</option></select><input type="hidden"  name="sale_order[' + mainTrIndex + '][' + i + ']_' + i + '"  value="" class="SelectedSaleOrder"></div>';

        cols += '<div class="rTableCell"><label>Product Name</label><select class="form-control dis party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId" id ="product_name" name="product_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div>';

        cols += '<div class="rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Number" readonly  type="text" value=""></div>';

        //cols += '<div class=" rTableCell"><label>Process Name</label><select class="form-control process_name" name="process_name[' + i + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + i + '][0]" class="inpt_outpt_process" value=""></div>';

        cols += '<div class=" rTableCell"><label>Process Name</label><select onchange="get_outputPD(event,this);"  class="form-control process_name" name="process_name[' + mainTrIndex + '][' + i + ']" ></select><input type="hidden" name="inpt_outpt_process[' + mainTrIndex + '][' + i + ']" class="inpt_outpt_process" value=""></div>';

        cols += '<div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="' + dataWhere + '"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm"  name="npdm_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true"></select></div>';

        cols += '<div class="rTableCell"><label>Workers</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name[' + mainTrIndex + '][' + i + '][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="' + dataWhere + '" width="100%"></select></div>';

        cols += '<div class="hrs rTableCell"><label>Hrs in wages,% in per piece</label><span class="show_msg" style="display:none;">Total %age should be 100</span></div>';

        cols += '<div class="rTableCell"><label>Production Output</label><input id="output ' + counter + '" class="form-control col-md-7 col-xs-12 output"  placeholder="output"  type="text" name="output[' + mainTrIndex + '][' + i + ']" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)" value="" /></div>';

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
        cols += '<div class="rTableCell"><label>Process Name</label><select  onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name" name="process_name[' + mainTrIndex + '][' + i + ']_' + i + '"  ></select></div>';
        cols += '<div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + dataWhereJobNo + '"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" name="npdm_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div>';

        cols += '<div class="rTableCell"><label>Worker</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker' + counter + '"  name="worker_name[' + mainTrIndex + '][' + i + '][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + dataWhereWorker + ' AND save_status = 1 AND active_inactive = 1" width="100%"></select></div>';

        cols += '<div class="rTableCell"><label>Output</label><input id="output ' + counter + '" class="form-control col-md-7 col-xs-12 output"  placeholder="output"  type="text" name="output[' + mainTrIndex + '][' + i + ']" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)" value="" /></div>';

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
                //  alert(job_card_product_id);
                var job_card_product_name = dataObj[0]['job_card_no'];
               //  alert(job_card_product_id);
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
        // setTimeout(function() {
        //     var closestTr = $(card_nothis_val33).closest('.rTableRow').attr('id');
        //     var job_card_no = $("#" + closestTr).find(".job_card_product_id").val();
        //     //alert(job_card_no);
        //     $.ajax({
        //         type: "POST",
        //         url: site_url + 'production/get_processtype_jobcard',
        //         data: {
        //             job_card_noo: job_card_no
        //         },
        //         success: function(htmlstr) {
        //             var closestTr = $(card_nothis_val33).closest('.rTableRow').attr('id');
        //             $("#" + closestTr).find(".process_name").html(htmlstr);
        //         }
        //     });


        // }, 1000);

        setTimeout(function() {
            var closestTr = $(card_nothis_val33).closest('.rTableRow').attr('id');
            var job_card_name = $("#" + closestTr).find(".job_card").val();
            var work_order_id = $("#" + closestTr).find(".WorkOrderId").val();
              
            $.ajax({
                type: "POST",
                url: site_url + 'production/get_Work_oreder_Status',
                data: {
                    job_cardname: job_card_name,work_order_id: work_order_id,
                },
                success: function(htmlstr) {
                 if (htmlstr==2) {
                          var closestTr =$(card_nothis_val33).closest('.rTableRow').attr('id');
                          var result = closestTr.split('_');
                          $("#" + closestTr).find("#process_name_"+result[1]).prop("disabled", true );
                          $("#" + closestTr).find("#npdm_name_"+result[1]).prop("disabled", true );
                          $("#" + closestTr).find("#worker_name_"+result[1]).prop("disabled", true );
                          $("#" + closestTr).find("#output_"+result[1]).prop("disabled", true );
                          var massege_wor= "Material not available in this Job Card" ;
                           $("#"+closestTr).find("#massege_wor_"+result[1]).html(massege_wor);
                          
                    } else{
                          var closestTr =$(card_nothis_val33).closest('.rTableRow').attr('id');
                          var result = closestTr.split('_');
                          $("#" + closestTr).find("#process_name_"+result[1]).prop("disabled", false );
                          $("#" + closestTr).find("#npdm_name_"+result[1]).prop("disabled", false );
                          $("#" + closestTr).find("#worker_name_"+result[1]).prop("disabled", false );
                          $("#" + closestTr).find("#output_"+result[1]).prop("disabled", false );
                          var massege_wor= " " ;
                           $("#"+closestTr).find("#massege_wor_"+result[1]).html(massege_wor);
                          var closestTr = $(card_nothis_val33).closest('.rTableRow').attr('id');
                          var job_card_no = $("#" + closestTr).find(".job_card_product_id").val();
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
                    }

                    
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
                                activityLog += '<td><table id="datatable-buttons prodData" class="table table-striped table-bordered user_index jambo_table bulk_action" data-id="user"><thead> <tr><th>Machine Name</th><th>Job no.</th><th>Worker</th><th>Material Consumed</th><th>Output</th><th>Wastage</th><th>Electricity</th><th>Costing</th></tr></thead>';
                                    
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
                                PlanningLog += '<td><table id="datatable-buttons prodplan" class="table table-striped table-bordered user_index jambo_table bulk_action" data-id="user"><thead> <tr><th>Machine Name</th><th>Job no.</th><th>Worker</th><th>Material Consumed</th><th>Output</th><th>Wastage</th></tr></thead>';
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
            tab_name: $(this).attr('data_tab_name'),
        });
    $(this).prev('a').find('.step_no').text(index + 1);
    });

    if($('.saleOrder').attr('data_tab_name') == "work_order"){
    var ajax_url = "changeWorkOrderPriority";
    } else {
    var ajax_url = "changeSaleOrderPriority";
    }

    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url + 'production/'+ajax_url+'/',
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
                /*  $(result).each(function(){
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
      // # console.log("hdhdh");
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
    // $('#planningDate').on('change', function() {
    //     $('#processing_loader2').modal('toggle');
    //     setTimeout(function() {
    //         //var selected_department_idd = $('.Get_machine_accor_to_depart_Planing').find('option:selected').attr('data-id');
    //         var selected_department_idd = $('.department').find('option:selected').val();
    //             var compny_unit  = $('.compny_unit').find('option:selected').val();

    //         var current_login_com_ids = $('#current_login_com_id').val();
    //         var date = $('#planningDate').val();
    //         var shift = $('input[type="radio"]:checked').val();
    //         $('#department_id').val(selected_department_idd);
    //         $('.app_div_planing').html('');
    //         $('.btn_heading_hide').show();
    //         $.ajax({
    //             type: "POST",
    //             url: site_url + 'production/get_production_data_according_toDeprtment',
    //             //data: {selected_department_idd:selected_department_idd}, 
    //             data: {
    //                 selected_department_idd: selected_department_idd,
    //                 'shift': shift,
    //                 'date': date,
    //                 'table': 'production_planning'
    //             },
    //             success: function(result1) {
    //                 if (result1 == 'Data of this date and shift already exist') {
    //                     //console.log('in if con');
    //                     $(".app_div_planing").append('<h2 style="color:red;">' + result1 + '</h2>');
    //                     $(".disablesubmitBtn").attr("disabled", true);
    //                     $(".draftBtn").attr("disabled", true);
    //                 } else {
    //                     console.log('in else con');
    //                     var dataObj1 = JSON.parse(result1);
    //                     var machineData1 = dataObj1.Machine;
    //                     //console.log(machineData1);
    //                     var lenth = machineData1.length;
    //                     //console.log('length==>>',lenth);
    //                     //var lenth = dataObj1.length;
    //                     if (lenth != 0) {
    //                         $(".disablesubmitBtn").attr("disabled", false);
                //          $(".draftBtn").attr("disabled", false);
    //                         $(' <div class="rTableRow mobile-view2"><div class="rTableHead"><label>Machine Name<span class="required">*</span></label></div><div class="rTableHead"><label>Party Specification</label></div><div class="rTableHead"><label>Work order</label></div><div class="rTableHead"><label>Product Name</label></div><div class="rTableHead"><label>BOM Routing Product Name</label></div><div class="rTableHead"><label>Assign Process</label></div><div class="rTableHead"><label>NPDM</label></div><div class="rTableHead"><label>Worker</label></div><div class="rTableHead"><label>Output</label></div><div class="rTableHead" ><label></label></div></div>"').prependTo(".app_div_planing");
    //                         var k = 0;
    //                         for (var j = 0; j < lenth; j++) {
    //                             var machnine_nams = machineData1[j].machine_name;
    //                             var machnine_ids = machineData1[j].id;
    //                             var machnine_grp_id = machineData1[j].machine_group_id;
    //                             // alert(machnine_nam);
    //                             var machine_append_Data33 = '<div class="rTableRow mobile-view" id="index_' + k + '"><div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="' + machnine_nams + '" readonly><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_ids + ' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_grp_id + ' readonly></div><div class="rTableCell"><label>Party Specification</label><textarea class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[' + k + '][0]"></textarea></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="work_order[' + k + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option></select><input type="hidden"  name="sale_order[' + k + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId dis" name="product_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true" ><option>Select Option</option></select></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + k + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + k + '][0]" placeholder="BOM Routing Number" readonly  type="text" value=""></div><div class="rTableCell"><label>Process Name</label><select class="form-control process_name" name="process_name[' + k + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + k + '][0]" class="inpt_outpt_process" value=""></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_ids + ' AND save_status = 1"  data-id="npdm" data-key="id" data-fieldname="product_name" width="100%"   name="npdm_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class="rTableCell worker-row"><label>Worker</label><select multiple="" class="worker_name form-control col-md-2 col-xs-12 "   name="worker_name[' + k + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + '"><option>Select Option</option></select></div><div class="rTableCell"><label>Output</label><input  class="form-control col-md-2 col-xs-12" name="output[' + k + '][0]" placeholder="output" type="number" value=""></div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR btn btn-success btn-xs"  value="Add" /></div></div>';
    //                             /* var machine_append_Data33 = '<div class="rTableRow  mobile-view"><div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="'+ machnine_nams  +'" readonly><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[]" placeholder="Machine Name" type="hidden" value='+ machnine_ids +' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[]" placeholder="Machine Name" type="hidden" value='+ machnine_grp_id +' readonly></div><div class="rTableCell"><label>Party Specification</label><textarea id= "specification" class="form-control col-md-2 col-xs-12" Placeholder ="Add Specification" name="specification[]"></textarea></div><div class="rTableCell"><label>Job card product name</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible" id ="job_no" name="job_card_product_name[]" width="100%" tabindex="-1" aria-hidden="true"  data-id="job_card" data-key="id" data-fieldname="job_card_product_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid= '+current_login_com_ids+' AND save_status = 1"></select></div><div class="rTableCell worker-row"><label>Worker</label><select multiple="" class="worker_name form-control col-md-2 col-xs-12 " id="worker"  name="worker_name['+ k +'][]"   data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid= '+ current_login_com_ids +'"><option>Select Option</option></select></div><div class="rTableCell"><label>Output</label><input id="output" class="form-control col-md-2 col-xs-12" name="output[]" placeholder="output" type="number" value=""></div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR btn btn-success btn-xs" value="Add" /></div></div>'; */
    //                             $(".app_div_planing").append(machine_append_Data33);

    //                             k++;
    //                         }
    //                         init_select2();
    //                         init_select21();
    //                         get_jobcard_on_select();
    //                         init_select2so();
    //                         select_on_npdm_sale_order();
    //                         //getWorkerIds();
    //                     } else {
    //                         console.log('in else len con');
    //                         $(".app_div_planing").append('<h2>No machines available.</h2>');
    //                         $(".disablesubmitBtn").attr("disabled", true);
    //                         $(".draftBtn").attr("disabled", true);
    //                     }
    //                 }
    //             }
    //         });
    //         $('#processing_loader2').modal('toggle');
    //     }, 1000);
    // });
}

function getDept(evt, t) {
    $('.department, .department1').empty('');
   // alert("fff");
    var logged_user = $('#loggedUser').val();
    if (window.location.href == site_url + 'production/production_planning') {
        $(".app_div_planing").html(''); 
    //  $(".app_div_planing_similar").html('');
    } else if (window.location.href == site_url + 'production/production_data') {
        $(".app_div").html('');
    }
    var selected_unit_name = $(t).find('option:selected').val();
    $('.department, .department1').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + selected_unit_name + '"');
    $('.department, .department1').attr('data-id', 'department');
    $('.department, .department1').attr('data-key', 'id');
    $('.department, .department1').attr('data-fieldname', 'name');
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
                               // var oneDaySalary = salary / 26 ;
                                //console.log("one day sell",Totalday);
                                var oneHrSalary = oneDaySalary / 8;
                                var calculatedSalary = oneHrSalary * value;
                                $(this).next(".totalsalary").val(Math.round(calculatedSalary,));
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
                    html += '<article class="kanban-entry grab machine_order" id="item' + key + '" data_machine_id="' + value.id + '"  data_machine_order_id="' + value.priority_order + '" draggable="true"><div class="kanban-entry-inner"><div class="kanban-label" data_machine_order_id="' + value.priority_order + '">Machine Id :</strong> "' + value.id + '" | <strong>Machine Name : </strong>"' + value.machine_name + '"|  <strong>Machine code : </strong>"' + value.machine_code + '" |   <strong>Make And Model : </strong>"' + value.make_model + '" | <strong>Placement Of machine : </strong>"' + value.placement + '"  | <strong>Order : </strong>"' + value.priority_order + '"  | <strong>Machine Group : </strong>"' + value.machine_group_name + '" | <strong>Created Date: </strong>"' + value.created_date + '"</div></div></article>';
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
        $('.bleow_tbl').show();
         $('.bleow_hide').hide();
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
                 $('.bleow_hide').hide();
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
        }); */
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
            $(this).closest('.well').find(docu_Field).append('<div class="col-md-12 col-sm-12 col-xs-12 form-group" id="abc_' + k + '"><div class="col-md-10 col-sm-12 col-xs-10 form-group"><input type="file" class="form-control col-md-7 col-xs-12"><input type="hidden" class="file_name form-control col-md-6 col-xs-12" name="documentsAttach[' + k + ']" ></div><button class="btn  remv_Documents" type="button"><i class="fa fa-minus"></i></button></div>');
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
                        var shift_namee = JSON.parse(obj[i].shift_name);
                        var shift_duration = JSON.parse(obj[i].shift_duration);
                        //var sel_data = '<input type="radio" class="flat" name="shift" value="' + idd + '" checked = checked[0] >' + shift_namee + '</br>';
                        var sel_data = '';
                        $.each(shift_namee, function(i, item) {
                        sel_data += '<input type="hidden" class="flat" name="shift" value="' + idd + '"><input type="radio" class="flat" name="shift_name" data-duration="'+shift_duration[i]+'" value="' + item + '">' + item + '</br>';
                        });
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
           // $('.enableOnInput').prop('disabled', false);
    if (!$(current).val()) {
            var workOrderPendingrQty = "";
            //var workOrderPendingrQty  = parseInt(workOrderPendingQty)+parseInt(Transferquantity);
            $("#" + closestId + "").find('.Pending_quantity').val(Totalquantity);
        //  $("#" + closestId + "").find('.Pendingquantity').val(workOrderPendingrQty)

    }else{
          if(parseInt(Totalquantity) >= parseInt($(current).val())){
			
            var workOrderPendingrQty  = Totalquantity-$(current).val();
                $("#" + closestId + "").find('.Pending_quantity').val(workOrderPendingrQty);
                //$("#" + closestId + "").find('.Pendingquantity').val(workOrderPendingrQty)
                $('#transferqtyMessage').empty();
              //  $('.enableOnInput').prop('disabled', false);

            }else{
            $("#" + closestId + "").find('.Pending_quantity').val(workOrderPending_quantity);
             //$('#transferqtyMessage').html("WorkOrder Qty Should be less then or Equal to Pending Qty");
            // $('.enableOnInput').prop('disabled', true);

            }
    }       
    }else{
    if(parseInt(workOrderPendingQty) >= parseInt(workOrderTransferQty)){
		  
    var workOrderPendingrQty  = workOrderPendingQty-workOrderTransferQty;
        $("#" + closestId + "").find('.Pending_quantity').val(workOrderPendingrQty);
        //$("#" + closestId + "").find('.Pendingquantity').val(workOrderPendingrQty)
        $('#transferqtyMessage').empty();
       // $('.enableOnInput').prop('disabled', false);

    }else{
    $("#" + closestId + "").find('.Pending_quantity').val(workOrderPendingQty);
     //$('#transferqtyMessage').html("WorkOrder Qty Should be less then or Equal to Pending Qty");
     //$('.enableOnInput').prop('disabled', true);

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
            // console.log('data', data);
            $(selectedMaterialId).each(function(index, value) {
                var MId = $('.materialNameId option:selected').val();
                // console.log('mid===>>>>', MId);
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
        $('#production_modal').css('overflow-y', 'auto')
        $(document).on('click','#image',function(event) {
            $('#imageModalUpload').modal('show');
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
        });
        $(document).on('click','#closemodal',function(event) {
            $('#imageModalUpload').modal('hide');
        });
    
        $(document).on('change','#featured_image',function() {
            console.log($image_crop);
        //$('#featured_image').on('change', function() {
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
        $(document).on('click','.crop_image',function(event) {
        //$('.crop_image').click(function(event) {
            var uploaded_image_name = $('#featured_image').val().replace(/.*(\/|\\)/, '');
            var Id = $("input[name=id]").val();
            if (Id == '') {
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response) {
                    $.ajax({
                        url: site_url + 'inventory/uploadImageByAjax/',
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
                        url: site_url + 'inventory/EditImageByAjax/',
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
   // alert(WorkOrderId);
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

// function addMat_DtlOn_WorkOrder() {
	// alert('HMM');
    // $('.showmatDtal').on('click',function(event) {
       // alert('Aya');
			
                // $.ajax({
                    // type: "POST",
                    // url: site_url + 'production/getProductHtml/',
                         // success: function(msg) {
						// alert(msg);
                       // $("#div_result").html(msg);
					   
                    // }
                // });
				// init_select2();
         
       
    // });
// }


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
function submit_inprocess_workorder(){
    $('#inprocess_tab').submit();
}   
function submit_complete_workorder(){
    $('#complete_tab').submit();
} 

function submit_inactive_workorder(){
    $('#inactive_tab').submit();
} 

function submit_priority_workorder(){
    $('#priority_tab').submit();
} 


function keyup_function_to_check_qty(){
        $('.keyup_event').keyup(function(){
            var matrial_select_this2 =  $(this);
            //console.log(matrial_select_this2);
            var mat_id = $(matrial_select_this2).closest('.well').find("#mat_name").val();
            var  added_qty = $(matrial_select_this2).closest('.well').find("input[name='quantity[]']").val();
           var dmdata = $(matrial_select_this2).prev().find("input[name='dmdata[]']").val();
           console.log("dkliked=>>>>>",dmdata);
            //if(){
                $.ajax({
                    type: "POST",
                    url: site_url+'inventory/get_closing_material_qty/',
                    data: { mat_id:mat_id}, 
                    success: function(result) {
                        if(parseInt(added_qty) > parseInt(result)){       //check if added qty is greater than the existing cloing balance then throw error
                           // $('#mat_msg').html('The Available Quantity is ' + result); 
                            //$('.addmaterial').attr("disabled", "disabled");
                        }else{
                           $('#mat_msg').html('');
                           $('.addmaterial').removeAttr("disabled");     
                        }
                    }         
                });
            //} 
        });
    } 

function addMaterialDetail11() {
    var input = 125;
    var input_mat = $(".input_holder11");
    var add_mat = $(".addmaterial11");
    var logged_user = $('#loggedUser').val();
    var y = $('.input_fields_wrap11 .well').length;
    $(add_mat).click(function(e) {
        if (y < input) {
            y++;
            $(input_mat).append('<div class="well scend-tr mobile-view" id="chkIndex_' + y + '" ><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Material Type</label><select class="form-control selectAjaxOption select2 select2-hidden-accessible material_type_id select2 material_type" required="required" name="material_type_id11[]" data-id="material_type" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' OR created_by_cid=0" onchange="getMaterialName(event,this)" ><option value="">Select Option</option></select></div><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2"  id="mat_name" required="required" name="material_name11[]"></select></div><button class="btn btn-danger remove_input" type="button"><i class="fa fa-minus"></i></button></div>');


            var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        //getMaterialIssue();
       // keyup_function_to_check_qty();
        getMaterials(mat_id, y);
        init_select2();
       // addMaterial_inputDetail();
        //addMaterial_outputDetail();
        //get_Qty_UOm();
        //getUom();

    });
    $(input_mat).on("click", ".remove_input", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
      //  keyupFunction(event, this);
    });
}

$(document).on('change', '.change_status', function(){
    var gstatus;    
    var checkbox =  $(this).attr('checked', true);
    if(checkbox.context.checked == true) gstatus = 1;
    else gstatus = 0;
    var id = $(this).attr("data-value");
    
        $.ajax({                
            url: site_url + 'production/change_status/',         
            dataType: 'json',
            type: 'POST',
            data: {
                'id': id,
                'gstatus': gstatus,
            },success: function(htmlStr) {
                  if(htmlStr == true){
                      $('.mesg').html('<b style="color: #E9EDEF; background-color: green;border-color: green;clear: both;padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;width: 100%;display: block;">Work Order Status update Successfully.</b>');
                     
                       setTimeout(function(){   
                               window.location.reload();
                           }, 500);
                  }
              } 
        });
});



    function goBack() {
       window.history.back();
    }



window.addEventListener("load",function(){
      addScrapDetail();
    addMaterialDetail();
    addMaterialDetail11();
    get_parameter_value();
    addMaterials();
    machineProcess();
    getUom();
    getsubBom();
    getOutputsubBom();
    expandBom();
    expandOutputMat();
    getMaterialName();
    keyupFunction();
    textareaWrap();
    addMaterial_inputDetail();
    addMaterial_outputDetail();
    addAttachment_InJobCard();
    addmachineForProcesstype();
    addProcesstype();
    keyup_function_to_check_qty();
    init_selectlot();
    ChangePrefix_and_subType();
    //addMultipleLocationInMaterial();

   $('.continue').click(function(){
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });
    $('.back').click(function(){
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    }); 
},false);

/* Code For save Material For BOM Routing*/
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
                        var dataParse = JSON.parse(subType);
                        
                            var option='<option value="">Select Sub Type</option>';
                            var selectedMaterialSubType = $('#selectedMaterialSubType').html();
                            var selected = '';
                                $.each(dataParse, function(key, value) {
                                    //console.log("ff",value.sub_type);
                                    if(value.sub_type == selectedMaterialSubType){
                                        selected = 'selected';
                                    }else{ selected = ''; }
                                    option +="<option value='"+value.sub_type+"' "+selected+">"+value.sub_type+"</option>"; 
                                });
                            $('.subtype').html(option);
                            
                            $(".prefix").html(prefix);
                    
                }
        }
    }); 
}

function getArea(evt, t){
    var optionValue = $(t).find('option:selected').val();
    var closestId = $(t).closest(".well").attr("id");
//alert(optionValue);
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: site_url + 'inventory/getLocationArea',
        data: {id:optionValue}, 
        success: function(data){
            if(data != '') {
                var optionData='';
                    $.each(data, function(key, value) {
                        // optionData +="<option value="">All</option>"; 
                        optionData +="<option value="+value.id+">"+value.id+"</option>"; 
                    });
                $("#"+closestId+"").closest(".well").find('.area').html(optionData);
            
            }else{
                $("#"+closestId+"").closest(".well").find('.area').html('');
            }
        }
    }); 
 }
 
 function init_selectlot() {
   $('.lotno').select2({
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
        var material_type = $('#material_typewsws').val();
        var mat_name = $('#mat_id_funcs').val();
        setTimeout(function(){    
        $('#material_type_id22').val(material_type);
        $('#material_name_id').val(mat_name);
        }, 2000);
    });

    $(document).on("click",".add_lotname",function(){ 
        $('#myModal_lotdetails').modal('show');
        var btn_html = $(this).html();
        $('#add_matrial_Data_onthe_spot').val(btn_html);
    });     

$(document).on("click",".close_sec_model",function(){
        $('#myModal_lotdetails').modal('hide');
        $('#wrngmdl').modal('hide');
    });
    
    
    /*function addMultipleLocationInMaterial(){

        var max_Address     = 5; //maximum input boxes allowed
        var location_add    = $(".add_multiple_location"); //Fields wrapper
        var add_moreBtn     = $(".add_More_btn"); //Add button ID
        var logged_user     = $('#loggedUser').val();
        var k = 1; //initlal text box count
        $(add_moreBtn).click(function(e){ //on add input button click
         e.preventDefault();
            var closestId = $(this).closest('.well').last().attr('id');
            var getUom = $("#"+closestId+"").find('.uom option:selected').text();
            var getUomid = $("#"+closestId+"").find('.uom option:selected').val();
            //console.log("getUom",getUom);
            // var measurmentArray = '';
            // $.each( measurementUnits, function( key, value ) {
                // measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
            // });
        alert(k);
        if(k < max_Address){ //max input box allowed
            k++;
            $(location_add).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid = '+logged_user+'"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Location</label><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Rack number</label><input type="text" id="rack_number" name="rackNumber[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Lot No.</label><select class="lotno lotno22 form-control col-md-2 col-xs-12 select2" id="mat_name"  name="lotno[]"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label >Quantity</label><input style=" border-right: 1px solid #c1c1c1 ;"type="text" id="qty" name="quantityn[]"  class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup = "getQtyValue(event,this)"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="display : none;"><select class="form-control uom" name="Qtyuom1[]" id="uom" readonly><option value="'+getUom+'">'+getUom+'</option></select> <input type="hidden" name="Qtyuom[]" value="'+getUomid+'"> </div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
            //$(location_add).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);" data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Location</label><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Rack number</label><input style="border-right: 1px solid #c1c1c1 ;" type="text" id="rack_number" name="rackNumber[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
            getArea();
            init_select2();
            init_selectlot();
        }//getAddress();
    });
    $(location_add).on("click",".delete_btn", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); k--;
    });
}
*/

//function addMultipleLocationInMaterial(){
    var max_Address     = 5; //maximum input boxes allowed
    var location_add  = $(".add_multiple_location"); //Fields wrapper
    var add_moreBtn      = $(".add_More_btn"); //Add button ID
    //var logged_user = $('#loggedUser').val();
    
    var k = 1; //initlal text box count
    $(document).on('click','.add_More_btn',function(e){ //on add input button click
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
        // var measurmentArray = '';
        // $.each( measurementUnits, function( key, value ) {
        //  measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
        // });
        
        if(k < max_Address){ //max input box allowed
            k++;
            var logged_user = $('#loggedUser').val();
            $('.add_multiple_location').append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="company_address" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);getlot(event,this)" data-where="created_by_cid = '+logged_user+'"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Location</label><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Rack number</label><input type="text" id="rack_number" name="rackNumber[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label>Lot No.</label><select class="lotno lotno22 form-control col-md-2 col-xs-12 select2" id="mat_name"  name="lotno[]"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-6 col-xs-12 form-group"><label >Quantity</label><input style=" border-right: 1px solid #c1c1c1 ;"type="text" id="qty" name="quantityn[]"  class="form-control col-md-7 col-xs-12" placeholder="Quantity" onkeyup = "getQtyValue(event,this)"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group" style="display : none;"><select class="form-control uom" name="Qtyuom1[]" id="uom" readonly><option value="'+getUom+'">'+getUom+'</option></select> <input type="hidden" name="Qtyuom[]" value="'+getUomid+'"> </div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
            //$(location_add).append('<div class="well scend-tr mobile-view"  style="overflow:auto;" id="chkIndex_'+k+'"><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label> Address</label><select class="location form-control selectAjaxOption select2 select2-hidden-accessible location" name="location[]" data-id="location_settings" data-key="id" data-fieldname="location" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getArea(event,this);" data-where="'+data_where+'"><option value="">Select Option</option></select></div><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Location</label><select class="area form-control" name="storage[]"><option value="">Select Option</option></select></div><div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Rack number</label><input style="border-right: 1px solid #c1c1c1 ;" type="text" id="rack_number" name="rackNumber[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="rack_number"></div><button class="btn btn-danger delete_btn" type="button"><i class="fa fa-minus"></i></button></div>');
            getArea();
            init_select2();
            init_selectlot();
        }//getAddress();
    });
    $(document).on("click",".add_multiple_location .delete_btn", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); k--;
    });
//}


function getQtyValue(evt,t){
    var closestId = $(t).closest(".well").attr("id"); 

    console.log("klemckl==>>",closestId);
    var qty = 0; 
    //var qty = parseFloat($("#"+closestId+" input[name='quantity[]'").val());
    $("input[name='quantityn[]']").each(function(){
        qty += parseFloat($(this).val());   
    });
    if(isNaN(qty)) qty = 0;
    console.log("jnfjrnf=>>>",qty);
    $('#opening_bal').val(qty);
}
function getlot(evt, t , selProcessType = '' , c_id = '' ){
  //Grandtotal();
  $(this).parents().closest('input=[text]').find('.lotno').empty();
  
  var logged_user = $('#loggedUser').val();
  console.log("loggeduser",logged_user);
  var closestId = $(t).closest(".well").attr("id");
  var option = $(t).find('option:selected');
  //var mat_id = $('#mat_id_funcs').val();
  var material_type_id = selProcessType != ''?selProcessType:$(option).val();
  console.log("mat_id",material_type_id);
  if(material_type_id != ''){
    //alert(closestId); 
     select2lot(material_type_id , logged_user);
    $("#"+closestId+"").find('.lotno').attr('data-where','mat_id = '+material_type_id+' AND created_by_cid='+logged_user+' AND active_inactive = 1');
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
          //alert(htmlStr);
             
            if(htmlStr == 'true'){
                $('#mssg343').html('<span style="color:green;">Lot Details Added Successfully.</span>');
                $("#insert_Matrial_data_id33").trigger('reset');
                setTimeout(function(){
                  
                  $('#myModal_lotdetails').modal('hide');
                  //$('#myModal_Add_matrial_details_purchse').modal('hide');
                }, 1000);
                setTimeout(function(){
                  $('.nav-md').addClass('modal-open'); 
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
/* Code For save Material For BOM Routing*/




/*********add more images in material********/
/*function addImages(){
    var maxImages      = 5; //maximum input boxes allowed
    var Image_box      = $(".image_box"); //Fields wrapper
    var upload_btn     = $(".add_images"); //Add button ID
    var y = 1; //initlal text box count
    $('.add_images').on('click',function(e){ //on add input button click
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
*/
var maxImages      = 5; //maximum input boxes allowed
//var Image_box      = $(".image_box"); //Fields wrapper
var y = 1; //initlal text box count
$(document).on('click','.add_images',function(e){
    e.preventDefault()
    if(y < maxImages){ //max input box allowed
        y++;
        $('.image_box').append('<div class="item form-group"><label class="col-md-3 col-sm-3 col-xs-12" for="proof"></label><div class="col-md-6 col-sm-6 col-xs-12"><input type="file" class="form-control col-md-7 col-xs-12"  name="materialImage[]"></div><button class="btn btn-danger remv_image" type="button"><i class="fa fa-minus"></i></button></div>');
    }
    
});
$(document).on("click",".image_box .remv_image", function(e){ 
    e.preventDefault(); $(this).parent('div').remove(); y--;
});

/***************tags in material working*********************/
function tags() {
    $(".tags-field").select2({
        maximumSelectionLength: 10,
        tokenSeparators: [','],
    });
}

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

$(document).on('change', '#choose_material_id', function(event){
    var selectedVal = $(this).val();
    if(selectedVal != ''){       
        var actionUrl   = site_url + 'production/job_card_edit?material_id='+selectedVal;
        $("#chooseMaterialForm").attr('action', actionUrl);
    }
});


$('.work_order_production_status').on('change',function(){
    if (confirm('Are you sure!') == true) {
        var status          = $(this).val();
        var work_order_id   = $(this).closest('td').attr('data-work-order-id');
        $.ajax({
            url: site_url + 'production/change_work_order_production_status/',
            dataType: 'json',
            type: 'POST',
            data: {
                'status'        : status,
                'work_order_id' : work_order_id,
            },
            success: function (data) {
                if (data == true) {
                    location.reload();
                } else {
                    location.reload();
                }
            }
        });
    }
});


$('.work_order_material_status').on('change',function(){
    if (confirm('Are you sure!') == true) {
        var status          = $(this).val();
        var work_order_id   = $(this).closest('td').attr('data-work-order-id');
        $.ajax({
            url: site_url + 'production/change_work_order_material_status/',
            dataType: 'json',
            type: 'POST',
            data: {
                'status'        : status,
                'work_order_id' : work_order_id,
            },
            success: function (data) {
                if (data == true) {
                    location.reload();
                } else {
                    location.reload();
                }
            }
        });
    }
});


$('.__workOrderDiv #profile-tab').on('shown.bs.tab', function (e) {
    $('.__statusDropDowns').addClass('hide');
});

$('.__workOrderDiv #home-tab').on('shown.bs.tab', function (e) {
    $('.__statusDropDowns').removeClass('hide');
});

$(document).ready(function() {
    var checkClass = $(".__workOrderDiv .__inprocessOrder").hasClass( "active" );
    if(checkClass == false){
        $('.__statusDropDowns').addClass('hide');
    } else {
        $('.__statusDropDowns').removeClass('hide');
    }
});




$(document).on('keyup','.avg_salary',function(){
    var avg_salary          = $(this).val();
    var production_shift    = $(this).closest('.total_machines_ids').find('.production_shift').val();
    var workers             = $(this).closest('.total_machines_ids').find('.workers').val();
    if(avg_salary && production_shift && production_shift > 0 && workers){
        var total_cost      = avg_salary * workers;
        var cost_per_unit   = parseFloat((total_cost / production_shift).toFixed(2));
        $(this).closest('.total_machines_ids').find('.total_cost').val(total_cost);
        $(this).closest('.total_machines_ids').find('.per_unit_cost').val(cost_per_unit);
    } else if(avg_salary == "" || avg_salary == 0){
        $(this).closest('.total_machines_ids').find('.total_cost').val(0);
        $(this).closest('.total_machines_ids').find('.per_unit_cost').val(0);
    }
});


$(document).on('keyup','.production_shift',function(){
    var production_shift          = $(this).val();
    var avg_salary    = $(this).closest('.total_machines_ids').find('.avg_salary').val();
    var workers             = $(this).closest('.total_machines_ids').find('.workers').val();
    if(avg_salary && production_shift && production_shift > 0 && workers){
        var total_cost      = avg_salary * workers;
        var cost_per_unit   = parseFloat((total_cost / production_shift).toFixed(2));
        $(this).closest('.total_machines_ids').find('.total_cost').val(total_cost);
        $(this).closest('.total_machines_ids').find('.per_unit_cost').val(cost_per_unit);
    } else if(production_shift == "" || production_shift == 0){
        $(this).closest('.total_machines_ids').find('.total_cost').val(0);
        $(this).closest('.total_machines_ids').find('.per_unit_cost').val(0);
    }
});

$(document).on('keyup','.workers',function(){
    var workers       = $(this).val();
    var avg_salary    = $(this).closest('.total_machines_ids').find('.avg_salary').val();
    var production_shift    = $(this).closest('.total_machines_ids').find('.production_shift').val();
    if(avg_salary && production_shift && production_shift > 0 && workers){
        var total_cost      = avg_salary * workers;
        var cost_per_unit   = parseFloat((total_cost / production_shift).toFixed(2));
        $(this).closest('.total_machines_ids').find('.total_cost').val(total_cost);
        $(this).closest('.total_machines_ids').find('.per_unit_cost').val(cost_per_unit);
    } else if(workers == "" || workers == 0){
        $(this).closest('.total_machines_ids').find('.total_cost').val(0);
        $(this).closest('.total_machines_ids').find('.per_unit_cost').val(0);
    }
});


function updateProcessId(evt, t) {
    var thisVar = t;
    var process_id = $(thisVar).parents().closest('.well2').find('.process_name_id :selected').val();
    $(thisVar).closest('.chk_idd_input').find('.material_type_input_id_1').attr('id', 'material_type_input_id_1[' + process_id + '][]');
    $(thisVar).closest('.chk_idd_input').find('.material_input_name_1').attr('id', 'material_input_name_1[' + process_id + '][]');
    $(thisVar).closest('.chk_idd_input').find('.quantity_input_1').attr('id', 'quantity_input_1[' + process_id + '][]');
    $(thisVar).closest('.chk_idd_input').find('.uom_value_input1_1').attr('id', 'uom_value_input1_1[' + process_id + '][]');
    $(thisVar).closest('.chk_idd_input').find('.uom_value_input_1').attr('id', 'uom_value_input_1[' + process_id + '][]');
}


function updateInputProcess(evt, t) {
    var thisVar = t;
    var process_id = $(thisVar).parents().closest('.well2').find('.process_name_id :selected').val();
    // console.log("ksjdfhjksh123456",process_id);
    $(thisVar).closest('.well2').find('.chk_idd_input .material_type_input_id_1').attr('id', 'material_type_input_id_1[' + process_id + '][]');
    $(thisVar).closest('.well2').find('.chk_idd_input .material_input_name_1').attr('id', 'material_input_name_1[' + process_id + '][]');
    $(thisVar).closest('.well2').find('.chk_idd_input .quantity_input_1').attr('id', 'quantity_input_1[' + process_id + '][]');
    $(thisVar).closest('.well2').find('.chk_idd_input .uom_value_input1_1').attr('id', 'uom_value_input1_1[' + process_id + '][]');
    $(thisVar).closest('.well2').find('.chk_idd_input .uom_value_input_1').attr('id', 'uom_value_input_1[' + process_id + '][]');
}



$(document).on('click', '#jobCardDetail .draftBtn,#jobCardDetail .__formSubmit', function(event){
    var myArray = getProcessValues();
    var status = checkIfArrayIsUnique(myArray);
    $('#jobCardDetail').submit(false);
    // if(status == false){
    //     alert('Please select unique Processes.');
    //     $('#jobCardDetail').submit(false);
    //     return false;
    // } else {
    //     $('#jobCardDetail').submit(true);
    //     return true;
    // }
});


function checkIfArrayIsUnique(myArray) {
    isUnique=true
    for (var i = 0; i < myArray.length; i++) 
    {
        for (var j = 0; j < myArray.length; j++) 
        {
            if (i != j) 
            {
                if (myArray[i] == myArray[j]) 
                {
                    isUnique=false
                }
            }
        }
    }
    return isUnique;
}

function getProcessValues(){
    var selectedVal = [];
    $('select[name="process_name[]"]').each(function(){
        selectedVal.push($(this).val());
    });
    return selectedVal;
}

$('.work_order_material_status').on('click',function(){
    var work_order_id   = $(this).closest('td').attr('data-work-order-id');
    window.location.href = site_url+'production/work_order_material_details?id='+work_order_id;    
});

$(document).on('click','.__reservedQuantity',function(event){
if($('.reserve_unreserve_quantity').val() == ""){
$('.reserve_unreserve_quantity').css('border', '1px solid #ff0000');
return false;
} else {
var material_type = $('.material_type').val(); 
var material_id = $('.material_id').val();  
var work_order_id = $('.work_order_id').val();  
var job_card_id = $('.job_card_id').val();   
var sale_order_product_id = $('.sale_order_product_id').val();
var quantity_required = $('.reserve_unreserve_quantity').val(); 
var available_quantity = $('.available_quantity').val();
var reserved_quantity = $('.reserved_quantity').val();
var quantity_required_set = $('.quantity_required').val();
var mat_action = $('.mat_action').val();

if(mat_action == "Unreserve Material"){
if(quantity_required > reserved_quantity){
alert('Unreserve Quantity is more then reserved Quantity.');
return false;
}
}

if(mat_action == "Reserve Material"){
if(quantity_required > available_quantity){
alert('Reserved QTY is more then available QTY.');
return false;
} else if(quantity_required > quantity_required_set){
alert('Reserved QTY is more then required QTY.'); 
return false;   
}
}

// if(parseFloat(available_quantity) <= 0 ){
// alert('Available quantity is equal or less than 0.');
// return false;
// } else {
if (confirm('Are you sure!') == true) {
// if(parseFloat(quantity_required) > parseFloat(available_quantity)){
// quantity_required =  available_quantity;
// } else {
// quantity_required =  quantity_required;
// }
if(mat_action == "Unreserve Material"){
var $qty = "unreserve_qty";
} else {
var $qty = "quantity";
}
var data = {};
data['material_type'] = material_type;
data['mayerial_id'] = material_id;
data['work_order_id'] = work_order_id;
data['job_card_id'] = job_card_id;
data[$qty] = quantity_required;
data['saleorder_product'] = sale_order_product_id;
data['mat_action'] = mat_action;
$.ajax({
url: site_url + 'production/add_reserve_quantity/',
dataType: 'json',
type: 'POST',
data: data,
success: function (data) {
if (data == true) {
location.reload();
} else {
location.reload();
}
}
});
}
//}
}
});

// $('.__reservedQuantity').on('click',function(event){
//     var material_type = $(this).closest('tr').find('.material_type').val(); 
//     var material_id = $(this).closest('tr').find('.material_id').val();  
//     var work_order_id = $(this).closest('tr').find('.work_order_id').val();  
//     var job_card_id = $(this).closest('tr').find('.job_card_id').val();   
//     var sale_order_product_id = $(this).closest('tr').find('.sale_order_product_id').val();
//     var quantity_required = $(this).closest('tr').find('.__quantityRequired').text(); 
//     var available_quantity = $(this).closest('tr').find('.__availableQuantity').text();
//     if(parseFloat(available_quantity) <= 0 ){
//         alert('Available quantity is equal or less than 0.');
//        return false;
//     } else {
//         if (confirm('Are you sure!') == true) {
//             if(parseFloat(quantity_required) > parseFloat(available_quantity)){
//                quantity_required =  available_quantity;
//             } else {
//                 quantity_required =  quantity_required;
//             }
//             $.ajax({
//                 url: site_url + 'production/add_reserve_quantity/',
//                 dataType: 'json',
//                 type: 'POST',
//                 data: {
//                     'material_type'     : material_type,
//                     'mayerial_id'       : material_id,
//                     'work_order_id'     : work_order_id,
//                     'job_card_id'       : job_card_id,
//                     'quantity'          : quantity_required,
//                     'saleorder_product' : sale_order_product_id,
//                 },

//                 success: function (data) {
//                     if (data == true) {
//                         location.reload();
//                     } else {
//                         location.reload();
//                     }
//                 }
//             });
//         }
//     }
//  });

$('orderofquantity td').each(function() {
    var customerId = $(this).find(".orderofquantity").html();    
    //  alert(customerId);
 });

$(document).on("click",".add_material_cls_name",function(){ 
 //To get Matrieal Type Ajax  
 
   $('#myModal_Add_matrial_details').modal('show');
   var btn_html = $(this).html();
   $('#add_matrial_Data_onthe_spot').val(btn_html);
  // alert(btn_html);Add Sale Ledger

 
});  
$(document).on("click",".add_material_cls_name",function(){

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


 

function addMaterials() {
   // alert();
    //$('#material_name').select2({
        
    $('.materialNameId').select2({
    
        allowClear: true,
        placeholder: 'Material Name',
        ajax: {
            url: site_url+'Ajaxrequest/ajaxSelect2search',
            dataType: 'json',
            delay: 250,
            data: function (params) {
            console.table('html',params);
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where"),
                material_type_id: $('.material_type_id option').filter(':selected').val()
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
     $('#myModal_Add_matrial_details').modal('show');
});

$(document).on("click", ".close_sec_modelMateriyas", function() {
    $('#myModal_Add_matrial_details').modal('hide');
});



$(document).on("click","#Add_matrial_details_on_button_click_purchase",function(){
       //alert('asdf');
    $('#mssg34').empty();
    var material_name  = $('#material_namebb').val();
    
    var hsn_code  = $('#hsn_codet').val();
    //var uom  = $('#uom').val();
    var uom  = $("select#uom option").filter(":selected").val();
    var specification  = $('#specification').val();
    //var closing_balance  = $('#closing_balance').val();
    var opening_balance  = $('#opening_balance_Sec').val();
    var material_type_id  = $('#material_type_idQadd').val();
    //var material_type_id  = $('#matrial_Iddd').val();
    
   // var prefix  = $('#prefix').val();
    var prefix  = 'RAW';
    //alert(prefix);
    
           
        $.ajax({
               type: "POST",
               url: site_url+'production/add_matrial_Details_onthe_spot/',
               data: {material_name:material_name,hsn_code:hsn_code,uom:uom,specification:specification,material_type_id:material_type_id,prefix:prefix,opening_balance:opening_balance},
                success: function(htmlStr) {
                  // alert(htmlStr);
                       
                     if(htmlStr == 'true'){
                        
                        $('#mssg34').html('<span style="color:green;">Material Added Successfully.</span>');
                        $("#insert_Matrial_data_id").trigger('reset');
                        setTimeout(function(){
                            
                            $('#myModal_Add_matrial_details').modal('hide'); 
                        }, 1000);
                        setTimeout(function(){
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
        
});



$(document).on('change', '.change_status_material_conversion', function () {
    var uomStatus;
    var checkbox = $(this).attr('checked', true);
    if (checkbox.context.checked == true) uomStatus = 1;
    else uomStatus = 0;
    var id = $(this).attr("data-value");
    $.ajax({
        url: site_url + 'production/change_material_conversion_status/',
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

function getDeliveryAddress(){
    $('.deliveryAddress').select2({
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


function addMoredocuments(){
    var maxfields    = 5; //maximum input boxes allowed
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

function init_select_forAdd_suplier() {
    $('.add_more_Supplier').select2({
        allowClear: true,
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
        },
        language: {
            noResults: function() {  
                var searched_value =  $('.select2-search__field').val();
                $('#preff_supp').val(searched_value);
                $('#suppliername').val(searched_value);
                return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_supliers'>Add </span>";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });    
}

 function addScrapDetail() {
    var input       = 125;
    var input_scrap = $(".input_scrap_holder");
    var add_scrap   = $(".addScrapButtonn");
    var logged_user = $('#loggedUser').val();
    var y = $('.scrap_input_fields_wrap .well').length;
    $(add_scrap).click(function(e) {
      
        if (y < input) {
            y++;
 
        $(input_scrap).append(`<div class="well firstScrapIndex" id="chkScrapIndex_${y}" style=" overflow:auto;">
                                <div class="col-md-4 col-sm-12 col-xs-12 form-group"> <label>Select Scrap Type</label>
                                    <select class="form-control" name="scrap_typeinpre[]" id="scrap_typeinpre">
                                       <option value="">Select Scrap Type</option>
                                       <option value="assembly_scrap">Assembly Scrap </option>
                                       <option value="component_scrap">Component Scrap</option>
                                       <option value="operating_scrap">Operating Scrap</option>
                                    </select>
                                 </div> 
                                
                            
                                 <div class="col-md-8 col-sm-12 col-xs-12 form-group" id="assembly_scrap" style="display: block;">
                                    <label style="border-right: 1px solid #c1c1c1 !important;"> Scrap (%)</label>
                                    <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="assembly_scrap[]" id="" class="form-control col-md-7 col-xs-12 operating_screp"  placeholder=" Scrap (%)." value=""> 
                                    
                                 </div> 
                               
                               <div class="col-md-8 col-sm-12 col-xs-12 form-group " id="operating_scrap" style="display: none;">
                                 <label style="border-right: 1px solid #c1c1c1 !important;"> Process   </label> 
                                <input style="border-right: 1px solid #c1c1c1 !important;" type="text"    class="form-control col-md-7 col-xs-12 process_name"  placeholder="Please Select Product Name  " readonly> 
                             </div>
                                <div id="scrapProcessBy"></div> 

                             <div class="col-md-8 col-sm-12 col-xs-12 form-group " id="component_scrap" style="display: none;">
                                 <div class="col-md-6 col-sm-12 col-xs-12 form-group " >
                                  <label>Material Name</label>
                                  <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" name="scrap_material_name[]" onchange="getUom(event,this);" id="mat_name">
                                 <option value="">Select Option</option>
                                   
                                   </select>
                                 </div> 
                                 
                                 <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label style="border-right: 1px solid #c1c1c1 !important;"> Scrap (%)</label>
                                    <input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="component_scrap[]" id="component_scrap" class="form-control col-md-7 col-xs-12 component_scrap"  placeholder=" Component Scrap (%)." value=""> 
                                    
                                 </div>
                                   <button class="btn btn-danger remove_input" type="button"> <i class="fa fa-minus"></i></button>
                              </div>
                            
                                </div>`);


        var material_type_id = $('.material_type').val();
            select2(material_type_id, logged_user);
        }
        var mat_id = $('.material_type').val();
        getMaterialIssue();
        keyup_function_to_check_qty();
        getMaterials(mat_id, y);
        init_select2();
        addMaterial_inputDetail();
        addMaterial_outputDetail();
        get_Qty_UOm();
        getUom();
        getsubBom();
        getOutputsubBom();
        expandBom();
        expandOutputMat();

    });
    
    $(input_scrap).on("click", ".remove_input", function(e) {
        e.preventDefault(); 
        $(this).parent('div').remove();
        y--;
        keyupFunction(event, this);
    });
    
}

  $(document).on('click','.select2-selection__clear',function(){
      $('.removefildswork').val("").trigger('change');
  })   

function getsubBom(evt, t) {
setTimeout(function() {
var option = $(t).find('option:selected');
var closestId = $(t).closest(".jc_well").attr("id");
if (typeof closestId != 'undefined') {
$("body").append('<div class="loading"><img src="'+site_url+'/assets/images/loading.gif"></div>');
//var materialId = $('#' + closestId + ' .materialNameId').val();
var materialId = $('#' + closestId + ' .materialNameId_'+ closestId ).val();
//alert(materialId);
$.ajax({
type: "POST",
url: site_url + 'production/getMaterialDataById',
data: {
id: materialId
},
success: function(data) {
if (data != '') {
    $('#' + closestId + ' #sub_bom').val('');
     var dataObj = JSON.parse(data);
    if (dataObj) {
         var job_card = dataObj.job_card;
         //alert(job_card);
          if(job_card === null){
         $('#' + closestId + ' #sub_bom').val('N/A');
         } else {
         $('#' + closestId + ' #sub_bom').val(job_card);
         $('#' + closestId + ' .down_arrow').css('display', 'block');
         $('#' + closestId + ' .expand_selection').css('display', 'block');
         $('#' + closestId + ' .up_arrow i').attr('jc_number', job_card);
         $('#' + closestId + ' .down_arrow i').attr('jc_number', job_card);
         
         }
}
}
$(".loading").remove();
}
});
}
}, 1000);
}

function expandBom(evt, t) {
    //var option = $(t).find('option:selected');
    var closestId = $(t).closest(".jc_well").attr("id");
    var opt_val = $(t).attr('data-val');
    var y = $('.input_fields_wrap .jc_well').length;
    if(opt_val == "more"){
    $('#' + closestId + ' .up_arrow').css('display', 'block');
    $('#' + closestId + ' .down_arrow').css('display', 'none');
    //if($('#' + closestId + ' .expand_bom_'+ closestId ).css('display') == 'none'){
    $('#' + closestId + ' >.expand_bom_'+ closestId ).css({"display": "inline-block", "width": "100%", "padding-left": "40px"});
    //} else {   
    var jc_number = $(t).attr('jc_number');
    var jc_exqty = $(t).attr('jc_exqty');
    var lot = $('#lot').val();
    var material_qty =  $('#' + closestId + ' .material_qty_'+ closestId ).val();
    if(jc_number != ""){
    var logged_user = $('#loggedUser').val();
    $("body").append('<div class="loading"><img src="'+site_url+'/assets/images/loading.gif"></div>');
    $.ajax({
        type: "POST",
        url: site_url + 'production/getjcDataById',
        data: {
        id: jc_number,
        jc_exqty: jc_exqty,
        lot:lot,
        material_qty:material_qty,
        num_row : y
        },
        success: function(data) {
        if (data != '') {
        // $('#' + closestId + ' .expand_bom_'+ closestId ).html('');
        // $('#' + closestId + ' .expand_bom_'+ closestId ).css({"display": "inline-block", "width": "100%", "padding-left": "40px"});
        // $('#' + closestId + ' .expand_bom_'+ closestId ).append(data);
        $(t).closest(".jc_well").after(data);
        setTimeout(function(){
        var material_type_id = $('.material_type').val();
        select2(material_type_id, logged_user);
        keyup_function_to_check_qty();
        getMaterials(material_type_id, y);
        init_select2();
        addMaterials();
        addMaterial_inputDetail();
        addMaterial_outputDetail();
        getUom();
        $(".loading").remove();
         }, 2000);
        }
        }

        });
    } else {
    alert('Please choose Material Type First');
    }
    //}
    } else {
    $('#' + closestId + ' .up_arrow').css('display', 'none');
     $('#' + closestId + ' .down_arrow').css('display', 'block');
    // var jc_number = $(t).attr('jc_number');
    // if(jc_number != ""){
    //$('#' + closestId + ' .expand_bom_'+ closestId ).css('display', 'none');
    $(t).closest(".jc_well").nextAll('.appended_trs').remove();
    // } else {
    // alert('Please choose Material Type First');
    // }
    }
}



function addProcesstype() {
     var input = 100;
    var input_mat = $(".col-container");
    var add_process_button = $(".addProcesstype");
    var logged_user = $('#loggedUser').val();
      $(document).off('click','.addProcesstype').on('click', '.addProcesstype', function(e) {        
    //$(add_process_button).click(function(e) {
        e.preventDefault();
        var y = $(this).parents().prev('.col-container').find('.total_process_list').length;
        var div_id = $(this).parents().prev('.col-container').find('.total_process_list').attr('id');
         var div_len = $(".col-container").length;
         var jobid = $(this).parents().prev('.col-container').find('#jobid').val();
        var process_id = $(this).parents().prev('.col-container').find('.total_process_list').closest('.wellsel').find('.process_name_id').attr('data-where');
        $('.input_val').val(y + 1);
        if (y < input) {
            y++;
            $(this).parents().prev('.col-container').find('.total_process_list').closest('#' + div_id).parent().append('<div style="border-bottom: 1px solid#c1c1c1;" class="wellsel total_process_list mobile-view scend-tr" id="chckIndex_' + y + '"  data-id="frst_div_' + y + '"> <input type="hidden" value="" class="process_detail_set" name="process_set_data[]"> <div class="item form-group col-md-1 col-xs-12" ><div class="col-md-12 col-sm-12 col-xs-12 form-group" > <div class="col-md-12 col-sm-6 col-xs-12 form-group machine_name_dispaly"> <select class="form-control selectAjaxOption select2 process_name_id select2 select2-hidden-accessible" name="process_name[]" tabindex="-1" aria-hidden="true" onchange="getMachineName(event,this),updateInputProcess(event,this)" data-id="add_process" data-key="id" data-fieldname="process_name" data-where="'+process_id+'"><option value="">Select Option</option> </select> </div></div></div><div class="item form-group  col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="Setup Time"><br><br></div></div><div class="item form-group  col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="production_shift[]" class="form-control col-md-7 col-xs-12 production_shift" placeholder="Machining Time"><br><br></div></div><div class="item form-group  col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" name="workers[]" class="form-control col-md-7 col-xs-12 workers" placeholder="Labour Cost"><br><br></div></div><div class="item form-group  col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="radio" name="final_process[]" value="yes" class="final_process form-control col-md-7 col-xs-12" style="height: 17px;"><br><br></div></div><div class="item form-group  col-md-1 col-xs-12"><div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;"><a style="display:none;" href="javascript:void(0)" class="btn btn-edit btn-xs productionTab set_process_id" data-id="routingEdit" data-title="" data-tooltip="Edit" data-toggle="modal" id="'+jobid+' ~ 0" data-chkval="'+jobid+'" data-index-id="' + y + '"><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" class="RemoveProcesstype btn-xs btn btn-delete" data-tooltip="Delete"><i class="fa fa-trash"></i></a></div></div></div></div>');
             get_parameter_value();
            init_select2();
             return false;
        }
               


    });
    $(input_mat).on("click", ".RemoveProcesstype", function(e) {
        var y = $(this).parents('.col-container').find('.total_process_list').length;
         //var y = $(this).parents().prev('.col-container').find('.total_process_list').length;
        //var y = $(this).parents().find('.total_process_list').length;
        e.preventDefault();
        $(this).parents('.col-container').find('#chckIndex_'+y).remove();
        y--;
        $('.input_val').val(y);
        keyupFunction(event, this);
    });

}

$(document).on('click','#continue_routing',function(e){
e.preventDefault();
var machine_id=$('.machine_name_id').val();
if(machine_id == ''){
alert('Please fill machine details');
} else {
var data_id =$(this).attr('data-setid'); 
var formData = new FormData($("#routing_process_detail")[0]); 
var data = JSON.stringify( $("#routing_process_detail").serializeArray() ); 
$('#chckIndex_'+data_id+' .process_detail_set').val(data); 
$('#production_modal_edit').modal('hide');
}
});

function get_outputPP(evt, t) {
    var option = $(t).find('option:selected');
    var id = $(option).val();
    var jobid = $(option).parents().prev('.rTableCell').find('.job_card').val();
    var count = $(option).parents().next().next().next('.rTableCell').find('input').attr('name');
  // var count = $(t).attr('id');
     $.ajax({
        type: "POST",
        url: site_url + 'production/get_outputPP',
        data: {
            id: id,
            jobid:jobid,
            count:count
        },
        success: function (data) {
           $(option).parents().next().next().next('.rTableCell').html(data);
        }
    });

}

function get_outputPD(evt, t) {
    var option = $(t).find('option:selected');
    var id = $(option).val();
    var jobid = $(option).parents().prev('.rTableCell').find('.job_card').val();
    var count = $(option).parents().next().next().next().next('.rTableCell').find('input').attr('name');
   // var count = $(t).attr('id');
     $.ajax({
        type: "POST",
        url: site_url + 'production/get_outputPP',
        data: {
            id: id,
            jobid:jobid,
            count:count
        },
        success: function (data) {
           $(option).parents().next().next().next().next('.rTableCell').html(data);
        }
    });

}

$('.continue').click(function(){
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
});
 $('.back').click(function(){
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });

$(document).on('keyup','#shift_number',function(){
var shift_number = $(this).val();
var p_shift = $('.multiple_shift').find('.main_index').length;
// alert(shift_number);
// alert(p_shift);
if(shift_number < p_shift){
p_shift = shift_number;
$('.add_multi_shift').html('');
} else {
p_shift = parseInt(p_shift)+parseInt('1') 
$('.after_add').remove();
}

//$('.add_multi_shift').html('');
if(shift_number != 1){
for (var i = p_shift; i <= shift_number; i++) {
$('.add_multi_shift').append('<h3 class="after_add">Shift '+i+' :</h3><div class="col-md-12 col-sm-12 col-xs-12 vertical-border after_add"><div class="item form-group"><label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Name<span class="required">*</span></label><div class="col-md-6 col-sm-6 col-xs-12"><input id="shift_name" class="form-control col-md-7 col-xs-12" name="shift_name['+i+']" placeholder="Shift Name" required="required" type="text" value=""></div></div><div class="item form-group"><label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Duration<span class="required">*</span></label>   <div class="col-md-6 col-sm-6 col-xs-12"><input id="shift_duration" class="form-control col-md-7 col-xs-12" name="shift_duration['+i+']" placeholder="Shift duration based on Hrs and Mins" required="required" type="text" value=""></div></div><div class="item form-group"><label class="col-md-3 col-sm-3 col-xs-12" for="shift">Shift Timings<span class="required">*</span></label><div class="col-sm-4"><div class="form-group"><div class="input-group date start_time start_time_'+i+'" data-chk="end_time_'+i+'"><input type="text" class="form-control" required="required" value="" name="shift_start['+i+']" placeholder="Start Shift Timing"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div><div class="col-sm-4"><div class="form-group"><div class="input-group date end_time" id="end_time_'+i+'"><input type="text" class="form-control end_time_input" required="required" name="shift_end['+i+']"  value=""  placeholder="End Shift Timing"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div></div><div class="item form-group"><label class="col-md-3 col-sm-3 col-xs-12" for="week">Week off</label><div class="col-md-6 col-sm-6 col-xs-12 week_off_set"><input type="checkbox" name="week_off['+i+'][]" value="Sunday">Sunday<br><input type="checkbox" name="week_off['+i+'][]" value="Monday">Monday<br><input type="checkbox" name="week_off['+i+'][]" value="Tuesday">Tuesday<br><input type="checkbox" name="week_off['+i+'][]" value="Wednesday">Wednesday<br><input type="checkbox" name="week_off['+i+'][]" value="Thursday">Thursday<br><input type="checkbox" name="week_off['+i+'][]" value="Friday">Friday<br><input type="checkbox" name="week_off['+i+'][]" value="Saturday">Saturday<br></div></div></div><script>$("#end_time_'+i+'").find(".end_time_input").prop("readonly", true);$(".start_time").datetimepicker({format: "HH:mm", useCurrent: false,}); $("#end_time_'+i+'").datetimepicker({format: "HH:mm", useCurrent: false,});</script>');
}
}

});

function convertH2M(timeInHour){
var timeParts = timeInHour.split(":");
return Number(timeParts[0]) * 60 + Number(timeParts[1]);
}
function addZero(i) {
  if (i < 10) {i = "0" + i}
  return i;
}
function checkValue(value, arr) {
    var status = 'Not exist';

    for (var i = 0; i < arr.length; i++) {
        var name = arr[i];
        if (name == value) {
            status = 'Exist';
            break;
        }
    }

    return status;
}
function makeMilitary(string) {
    if (string.substr(-2) === "PM" && string.substr(0, 2) < 12)
    {
        var hour = parseInt(string.substr(0, 2));
        string = hour + 12 + string.substr(2);
    }
    else if (string.substr(-2) === "AM" && string.substr(0, 2) == 12)
    {
        string = "00" + string.substr(2);
    }
    return string;
}
function compare(start, end, current) {
    start = makeMilitary(start);
    end = makeMilitary(end);
    current = makeMilitary(current);

    if (start < end) // both times are in the same day
    {
        return current > start && current < end ? 'true' : 'false';
    }
    else // the end time is on the day after the start time
    {
        return current > start || current < end ? 'true' : 'false';
    }
}
function submitPriority(evt, t) {
    var logged_user = $('#loggedUser').val();
    var selected_unit_name = $(t).find('option:selected').val();
$("#date_range").submit();
}

function validate_reun(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}


/****Auto Production Planning****/

/*
function auto_custom_planning(){
$('#auto_planningDate').on('change', function() {
$('#processing_loader2').modal('toggle');
setTimeout(function() {
var selected_department_idd = $('.department').find('option:selected').val();
var compny_unit  = $('.compny_unit').find('option:selected').val();
var current_login_com_ids = $('#current_login_com_id').val();
var date = $('#auto_planningDate').val();
var shift = $('input[type="radio"]:checked').val();
$('#department_id').val(selected_department_idd);
$('.app_div_planing').html('');
$('.btn_heading_hide').show();
$.ajax({
    type: "POST",
    url: site_url + 'production/auto_production_data_according_toDeprtment',
    data: {
        'selected_department_idd': selected_department_idd,
        'shift': shift,
        'date': date,
        'table': 'auto_production_plan'
    },
    success: function(result1) {
        if (result1 == 'Data of this date and shift already exist') {
            $(".app_div_planing").append('<h2 style="color:red;">' + result1 + '</h2>');
            $(".disablesubmitBtn").attr("disabled", true);
            $(".draftBtn").attr("disabled", true);
        } else {
            var dataObj1 = JSON.parse(result1);
            var machineData1 = dataObj1.Machine;
            var lenth = machineData1.length;
            if (lenth != 0) {
                $(".disablesubmitBtn").attr("disabled", false);
                $(".draftBtn").attr("disabled", false);
                $(' <div class="rTableRow mobile-view2"><div class="rTableHead"><label>Machine Name<span class="required">*</span></label></div><div class="rTableHead"><label>Work order</label></div><div class="rTableHead"><label>Product Name</label></div><div class="rTableHead"><label>BOM Routing</label></div><div class="rTableHead"><label>Assign Process</label></div><div class="rTableHead"><label>NPDM</label></div><div class="rTableHead"><label>Worker</label></div><div class="rTableHead"><label>Output</label></div><div class="rTableHead" ><label>Action</label></div></div>"').prependTo(".app_div_planing");
                var k = 0;
                for (var j = 0; j < lenth; j++) {
                    var machnine_nams = machineData1[j].machine_name;
                    var machnine_ids = machineData1[j].id;
                    var machnine_grp_id = machineData1[j].machine_group_id;
                    var machine_append_Data33 = '<div class="rTableRow mobile-view" id="index_' + k + '"><div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="' + machnine_nams + '" readonly><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_ids + ' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_grp_id + ' readonly></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="work_order[' + k + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="priority_order" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option></select><input type="hidden"  name="sale_order[' + k + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId dis" name="product_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true" ><option>Select Option</option></select></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + k + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value=""><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + k + '][0]" placeholder="BOM Routing Number" readonly  type="text" value=""> <span style="color: red;" id="massege_wor_' + k + '" ></span> </div><div class="rTableCell"><label>Process Name</label><select onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name_' + k + '" name="process_name[' + k + '][0]" ></select><input type="hidden" name="inpt_outpt_process[' + k + '][0]" class="inpt_outpt_process" value=""></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_ids + ' AND save_status = 1"  data-id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm_name_' + k + '"  name="npdm_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class="rTableCell worker-row"><label>Worker</label><select multiple="" class="worker_name form-control col-md-2 col-xs-12 "  id="worker_name_' + k + '" name="worker_name[' + k + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + '"><option>Select Option</option></select></div><div class="rTableCell"><label>Output2d</label><input  class="form-control col-md-2 col-xs-12" name="output[' + k + '][0]" id="output_' + k + '" placeholder="output" type="number" value=""></div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR_auto btn btn-success btn-xs"  value="Add" /></div> </div></div>';
                    $(".app_div_planing").append(machine_append_Data33);
                    k++;
                }
                init_select2();
                init_select21();
                get_jobcard_on_select();
                init_select2so();
                select_on_npdm_sale_order();
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
*/

function auto_custom_planning(){
$('#auto_planningDate').on('change', function() {
$('#processing_loader2').modal('toggle');
setTimeout(function() {
var selected_department_idd = $('.department').find('option:selected').val();
var compny_unit  = $('.compny_unit').find('option:selected').val();
var current_login_com_ids = $('#current_login_com_id').val();
var date = $('#auto_planningDate').val();
var shift = $('input[type="radio"]:checked').val();
var shift_duration = $('input[type="radio"]:checked').attr('data-duration');
$('#department_id').val(selected_department_idd);
$('.app_div_planing').html('');
$('.btn_heading_hide').show();
$.ajax({
    type: "POST",
    url: site_url + 'production/auto_production_data_according_toDeprtment',
    data: {
        'selected_department_idd': selected_department_idd,
        'shift': shift,
        'date': date,
        'compny_unit': compny_unit,
        'shift_duration': shift_duration,
        'table': 'auto_production_plan'
    },
    success: function(result1) {
        if (result1 == 'Data of this date and shift already exist') {
            $(".app_div_planing").append('<h2 style="color:red;">' + result1 + '</h2>');
            $(".disablesubmitBtn").attr("disabled", true);
            $(".draftBtn").attr("disabled", true);
        } else {
            var dataObj1 = JSON.parse(result1);
            var machineData1 = dataObj1.show_data;
            if (machineData1 == '') {
            var result2 = 'Data of this date and shift already exist';
            $(".app_div_planing").append('<h2 style="color:red;">' + result2 + '</h2>');
            $(".disablesubmitBtn").attr("disabled", true);
            $(".draftBtn").attr("disabled", true);
        } else {
            $("#proceed_process").attr("data_sheet", result1);
            var lenth = machineData1.length;
           if (lenth != 0) {
                $(".disablesubmitBtn").attr("disabled", false);
                $(".draftBtn").attr("disabled", false);
                //$(' <div class="rTableRow mobile-view2"><div class="rTableHead"><label>Machine Name</label></div><div class="rTableHead"><label>Work order</label></div><div class="rTableHead"><label>Product Name</label></div><div class="rTableHead"><label>BOM Routing</label></div><div class="rTableHead"><label>Assign Process</label></div><div class="rTableHead"><label>Req. Output</label></div><div class="rTableHead"><label>Completed Qty</label></div><div class="rTableHead"><label>Remaining Qty</label></div><div class="rTableHead"><label>Remaining Time</label></div><div class="rTableHead"><label>Material Stock</label></div></div>"').prependTo(".app_div_planing");
                var last_mc_id = '';
                var count_set =  0;
                var mac_array = [];
                var mac_name = [];
                var machine_append_Data33 = "";
                for (var cj = 0; cj < lenth; cj++) {
                var machnine_grp_id = machineData1[cj].machine_group_id; 
                var machine_group_name = machineData1[cj].machine_group_name;
                if(last_mc_id != machnine_grp_id ){
                count_set++;
                mac_array.push(machnine_grp_id);
                mac_name.push(machine_group_name);
                }
                last_mc_id = machnine_grp_id; 
                }
                thelistunique = mac_array.filter(
                 function(a){if (!this[a]) {this[a] = 1; return a;}},
                 {}
                );
                thenameunique = mac_name.filter(
                 function(a){if (!this[a]) {this[a] = 1; return a;}},
                 {}
                );
                var mc = 0;
                //console.log(thelistunique);
                thelistunique.forEach(function(e) {
                //for (var jk = 0; jk < count_set; jk++) {
                machine_append_Data33 = '<div class="mch_groptitle"><h3 class="Material-head">'+ thenameunique[mc] +'<hr></h3></div><div class="Process-card well"><div class="label-box mobile-view3 mobile-view4"><div class="col-md-2 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Machine Name</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Work order</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Product Name</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>BOM Routing</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Assign Process</label></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Req. Output</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Completed Qty</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Remaining Qty</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Remaining Time</label></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label>Material Stock</label></div></div>';
                var k = 0;
                var last_mc_name = '';
                for (var j = 0; j < lenth; j++) {
                    //var machnine_array = machineData1[j].machine_name_id;
                    var machine_id = machineData1[j].machine_id;
                    var machine_name = machineData1[j].machine_name;
                    var machnine_ids = machineData1[j].id;
                    var machnine_grp_id = machineData1[j].machine_group_id;
                    var machine_group_name = machineData1[j].machine_group_name;
                    var workorder_name = machineData1[j].workorder_name;
                    var material_name = machineData1[j].material_name;
                    var job_card = machineData1[j].job_card;
                    var process_name = machineData1[j].process_name;
                    var remain_time = machineData1[j].remain_time;
                    var status = machineData1[j].status;
                    var material_type = machineData1[j].material_type;
                    var material_name_detail = machineData1[j].material_name_detail;
                    var available_quantity = machineData1[j].available_quantity;
                    var quantity_required = machineData1[j].quantity_required;
                    var reserved_quantity = machineData1[j].reserved_quantity;
                    var uom = machineData1[j].uom;
                    var output_array = machineData1[j].output_array;
                    var material_array = machineData1[j].material_array;
                    if(status == "In Stock"){
                    var class_mat = "in_stock"
                    } else {
                    var class_mat = "not_available"
                    }
                    if(e==machnine_grp_id) {
                    machine_append_Data33 += '<div class="rTableRow mobile-view " id="index_' + k + '"><div class="rTableCell"><label>Machine Name</label>';
                     if(last_mc_name != machine_name ){
                    machine_append_Data33 += '<span class="mc_name">' + machine_name + '</span><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machine_id + ' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_grp_id + ' readonly><br>';
                   }
                   last_mc_name = machine_name;
                    machine_append_Data33 += '</div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="work_order[' + k + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="priority_order" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0" disabled><option>Select Option</option><option value="" selected>' + workorder_name + '</option></select><input type="hidden"  name="sale_order[' + k + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls productNameId dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="product_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true" disabled><option>Select Option</option><option value="" selected>' + material_name + '</option></select></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + k + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value="' + job_card + '"><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + k + '][0]" placeholder="BOM Routing Number" readonly  type="text" value=""> <span style="color: red;" id="massege_wor_' + k + '" ></span> </div><div class="rTableCell"><label>Process Name</label><select onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name_' + k + '" name="process_name[' + k + '][0]"  disabled><option value="" selected>' + process_name + '</option></select><input type="hidden" name="inpt_outpt_process[' + k + '][0]" class="inpt_outpt_process" value=""></div>';
                        machine_append_Data33 += '<div class="rTableCell">';
                        $.each(output_array, function(index, value) {
                        if (value.req_output.toString().indexOf('.') == -1) {
                        machine_append_Data33 += '<label>Req. Output</label>' + value.req_output+'<br>';
                        } else {
                        machine_append_Data33 += '<label>Req. Output</label>' + parseFloat(value.req_output).toFixed(3)+'<br>';    
                        }
                        });
                        machine_append_Data33 += '</div>';
                        machine_append_Data33 += '<div class="rTableCell">';
                        $.each(output_array, function(index, value) {
                        if(value.complete_qty == null){
                        var complete_qty = '0';
                        } else {
                        var complete_qty = value.complete_qty;
                        }
                        if (complete_qty.toString().indexOf('.') == -1) {
                        machine_append_Data33 += '<label>Completed Qty</label>' + complete_qty+'<br>';
                        } else {
                        machine_append_Data33 += '<label>Completed Qty</label>' + parseFloat(complete_qty).toFixed(3)+'<br>';    
                        }
                        });
                        machine_append_Data33 += '</div>';
                        machine_append_Data33 += '<div class="rTableCell">';
                        $.each(output_array, function(index, value) {
                        if (value.remain_qty.toString().indexOf('.') == -1) {
                        machine_append_Data33 += '<label>Remaining Qty</label>' + value.remain_qty+'<br>';
                        } else {
                        machine_append_Data33 += '<label>Remaining Qty</label>' + parseFloat(value.remain_qty).toFixed(3)+'<br>';    
                        }
                        });
                        machine_append_Data33 += '</div>';
                        machine_append_Data33 += '<div class="rTableCell">';
                        $.each(output_array, function(index, value) {
                        machine_append_Data33 += '<label>Remaining Time</label>' + value.remain_time+'<br>';
                        });
                        machine_append_Data33 += '</div>';
                        machine_append_Data33 += '<div class="rTableCell mat_status '+class_mat+'"><h6>' + status + '</h6><div class="see-mat-status"><table id="" class="table table-striped table-bordered user_index" data-id="user" border="1" cellpadding="3"><thead><tr><th>Material Type</th><th>Material Name</th><th>Available Quantity</th><th>UOM</th><th>Required Qty</th><th>Reserved Qty</th></tr></thead><tbody>';
                        $.each(material_array, function(index, value) {
                        machine_append_Data33 += '<tr class="locRow" id="chkIndex_0"><td>' + value.material_type + '</td><td>' + value.material_name_detail + '</td><td>' + value.available_quantity + '</td><td>' + value.uom + '</td><td class="">' + value.quantity_required + '</td><td>' + value.reserved_quantity + '</td></tr>';
                        });
                        

                    machine_append_Data33 += '</tbody></table></div></div>';
                     
                    machine_append_Data33 += '</div>';
                }
                k++;
                }
                machine_append_Data33 += '</div>';
                $(".app_div_planing").append(machine_append_Data33);
                mc++;
                });
                init_select2();
                init_select21();
                get_jobcard_on_select();
                init_select2so();
                select_on_npdm_sale_order();
            } else {
                $(".app_div_planing").append('<h2>Material out of stock.</h2>');
                $(".disablesubmitBtn").attr("disabled", true);
                $(".draftBtn").attr("disabled", true);
            }
        }
        }
    }
});
$('#processing_loader2').modal('toggle');
}, 1000);
});
}

$(document).on('click','#proceed_process',function(){
$('#processing_loader2').modal('toggle');
setTimeout(function() {
var selected_department_idd = $('.department').find('option:selected').val();
var compny_unit  = $('.compny_unit').find('option:selected').val();
var current_login_com_ids = $('#current_login_com_id').val();
var date = $('#auto_planningDate').val();
var shift = $('input[type="radio"]:checked').val();
var data_sheet = $("#proceed_process").attr("data_sheet");
$('#department_id').val(selected_department_idd);
$('.app_div_planing').html('');
$('.btn_heading_hide').show();
$.ajax({
type: "POST",
url: site_url + 'production/auto_production_plan_data',
data: {
'selected_department_idd': selected_department_idd,
'shift': shift,
'date': date,
'data_sheet': data_sheet,
'table': 'auto_production_plan'
},
success: function(result1) {
if (result1 == 'Data of this date and shift already exist') {
$(".app_div_planing").append('<h2 style="color:red;">' + result1 + '</h2>');
$(".disablesubmitBtn").attr("disabled", true);
$(".draftBtn").attr("disabled", true);
} else {
// var data_sheet = $("#proceed_process").attr("data_sheet");
// var sheetdata = JSON.parse(data_sheet);
var dataObj1 = JSON.parse(result1);
var machineData1 = dataObj1.Machine;
var lenth = machineData1.length;
if (lenth != 0) {
$(".proceed_section").css("display", 'none');
$(".submit_section").css("display", 'block');
$(".expandautoAllSection").css("display", 'block');
$(".disablesubmitBtn").attr("disabled", false);
$(".draftBtn").attr("disabled", false);

var last_mc_id = '';
var count_set =  0;
var mac_array = [];
var mac_name = [];
var machine_append_Data33 = "";
for (var cj = 0; cj < lenth; cj++) {
if(machineData1[cj].appaned_data == null){
} else {
var machnine_grp_id = machineData1[cj].machine_group_id;
var machine_group_name = machineData1[cj].machine_group_name;
if(last_mc_id != machnine_grp_id ){
count_set++;
mac_array.push(machnine_grp_id);
mac_name.push(machine_group_name);
}
last_mc_id = machnine_grp_id;
} 
}
thelistunique = mac_array.filter(
function(a){if (!this[a]) {this[a] = 1; return a;}},
{}
);
thenameunique = mac_name.filter(
function(a){if (!this[a]) {this[a] = 1; return a;}},
{}
);

var machine_append_Data33 = "";
var mc = 0;
thelistunique.forEach(function(e) {

machine_append_Data33 = '<div class="mch_groptitle hr-line" ><div class="expand_dropauto form-group"><span class="up_arrow_auto" style="display: none;"><i onclick="expandautoSection(event,this);" style="font-size: 20px;font-weight: bold;" data-val="less" class="fa fa-angle-up" aria-hidden="true"></i></span><span class="down_arrow_auto"><i onclick="expandautoSection(event,this);" data-val="more" class="fa fa-chevron-down" aria-hidden="true"></i></span></div><h3 class="Material-head">'+ thenameunique[mc] +'<hr></h3></div><div class="Process-card" style="display:none"><div class="rTableRow mobile-view2"><div class="rTableHead"><label>Machine Name<span class="required">*</span></label></div><div class="rTableHead"><label>Work order</label></div><div class="rTableHead"><label>Product Name</label></div><div class="rTableHead"><label>BOM Routing</label></div><div class="rTableHead"><label>Assign Process</label></div><div class="rTableHead"><label>NPDM</label></div><div class="rTableHead"><label>Worker</label></div><div class="rTableHead"><label>Output</label></div><div class="rTableHead" ><label>Action</label></div></div>';
var k = 0;
//var machine_append_Data33="";
for (var j = 0; j < lenth; j++) {

var machnine_grp_id = machineData1[j].machine_group_id;
if(e==machnine_grp_id) {
if(machineData1[j].appaned_data == null){
var appaned_data = '';
} else {
var appaned_data = machineData1[j].appaned_data;
}
var machnine_nams = machineData1[j].machine_name;
var machnine_ids = machineData1[j].id;
if(typeof appaned_data[machnine_ids] === "undefined"){
//machine_append_Data33 = '';    
} else {
$.each(appaned_data[machnine_ids], function(index, value) {
var workorder_name = value.workorder_name;
var workorder_id = value.workorder_id;
var material_name = value.material_name;
var material_id = value.material_id;
var job_card = value.job_card;
var job_card_id = value.job_card_id;
var process_name_sec = value.process_name_sec;
var process_id_sec = value.process_id_sec;
var req_output = value.req_output;
var shift_duration = value.shift_duration;
var remain_qty = value.remain_qty;
if(value.output_data == null){
var output_data = '';
} else {
var output_data = value.output_data;
}
var set = [];
$.each(output_data, function(index, value) {
set.push(index, value);
});
var set_mc_data = job_card_id+'~~'+process_name_sec+'~~'+process_id_sec+'~~'+machnine_nams+'~~'+machnine_ids+'~~'+selected_department_idd+'~~'+compny_unit+'~~'+req_output+'~~'+workorder_name+'~~'+workorder_id+'~~'+job_card+'~~'+material_name+'~~'+material_id+'~~'+machnine_grp_id+'~~'+set+'~~'+shift_duration+'~~'+remain_qty;
if(index == 0){
machine_append_Data33 += '<div class="rTableRow mobile-view" id="index_' + k + '"><div class="rTableCell"><label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name"  type="text" value="' + machnine_nams + '" readonly><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_ids + ' readonly><input  class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[' + k + '][0]" placeholder="Machine Name" type="hidden" value=' + machnine_grp_id + ' readonly></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="work_order[' + k + '][0]" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="priority_order" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option><option value="' + workorder_id + '" selected>' + workorder_name + '</option></select><input type="hidden"  name="sale_order[' + k + '][0]"  value="" class="SelectedSaleOrder"></div><div class=" rTableCell"><label>Product Name</label><select class="form-control party_code_cls selectAjaxOption select2 select2-hidden-accessible productNameId dis" name="product_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true" ><option>Select Option</option><option value="' + material_id + '" selected>' + material_name + '</option></select></div><div class=" rTableCell"><label>BOM Routing Product Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + k + '][0]" placeholder="BOM Routing Product Name" readonly  type="text" value="' + job_card + '"><input type="hidden"  class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + k + '][0]" placeholder="BOM Routing Number" readonly  type="text" value="' + job_card_id + '"> <span style="color: red;" id="massege_wor_' + k + '" ></span> </div><div class="rTableCell"><label>Process Name</label><select onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name_' + k + '" name="process_name[' + k + '][0]" ><option value="' + process_id_sec + '" selected>' + process_name_sec + '</option></select><input type="hidden" name="inpt_outpt_process[' + k + '][0]" class="inpt_outpt_process" value=""></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_ids + ' AND save_status = 1"  data-id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm_name_' + k + '"  name="npdm_name[' + k + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class="rTableCell worker-row"><label>Worker</label><select multiple="" class="worker_name form-control col-md-2 col-xs-12 "  id="worker_name_' + k + '" name="worker_name[' + k + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + '"><option>Select Option</option></select></div><div class="rTableCell">';
if(output_data != ""){
var oc = 0;
$.each(output_data, function(index, value) {
if (value.toString().indexOf('.') == -1) {
machine_append_Data33 += '<input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="' + index + '" readonly=""><input style="width:50%; float:left;" id="output" class="form-control col-md-7 col-xs-12 output" name="output[' + k + '][0][' + oc + ']" placeholder="output" type="text" value="' + value + '" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">';
} else {
machine_append_Data33 += '<input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="' + index + '" readonly=""><input style="width:50%; float:left;" id="output" class="form-control col-md-7 col-xs-12 output" name="output[' + k + '][0][' + oc + ']" placeholder="output" type="text" value="' + value.toFixed(3) + '" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">';    
}
oc++;});
}
machine_append_Data33 += '</div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR_auto btn btn-success btn-xs"  value="Add" /><button type="button" id="' + set_mc_data + '" data-toggle="modal" data-id="machine_availability" data-title="Machine Availability" data-tooltip="Machine Availability"  class="productionTab btnCopy btn btn-success btn-xs"><i class="fa fa-clone"></i></button></div> </div>';
} else {
var i =  index;
var mainTrIndex = j;
var counter = 0;
machine_append_Data33 += '<div class="rTableRow mobile-view" id="addFunc_' + mainTrIndex + '"><div class="rTableCell"> <label>Machine Nameaaa<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name_id"  placeholder="Job number"  type="hidden" name="machine_name_id[' + mainTrIndex + '][' + i + ']_' + i + '" value="' + machnine_nams + '"/><input  class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="Machine Name" type="hidden" value=' + machnine_ids + ' readonly><input class="form-control col-md-2 col-xs-12 machnine_grp"  placeholder=""  type="hidden" name="machnine_grp[' + mainTrIndex + '][' + i + ']_' + i + '"" value="' + machnine_grp_id + '"/></div><div class=" rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId" name="work_order[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" onchange="getMaterialNameWorkorder(event,this)" tabindex="-1" aria-hidden="true"  data-id="work_order" data-key="priority_order" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option>Select Option</option><option value="' + workorder_id + '" selected>' + workorder_name + '</option></select><input type="hidden"  name="sale_order[' + mainTrIndex + '][' + i + ']_' + i + '"  value="" class="SelectedSaleOrder"></div><div class="rTableCell"><label>Product Name</label><select class="form-control dis party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId" id ="product_name" name="product_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" tabindex="-1" aria-hidden="true"><option>Select Option</option><option value="' + material_id + '" selected>' + material_name + '</option></select></div><div class="rTableCell"><label>BOM Routing Name</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Product Name" readonly  type="text" value="' + job_card + '"><input type="hidden" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Number" readonly  type="text" value="' + job_card_id + '"></div><div class="rTableCell"><label>Process Name</label><select  onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name" name="process_name[' + mainTrIndex + '][' + i + ']_' + i + '"  ><option value="' + process_id_sec + '" selected>' + process_name_sec + '</option></select></div><div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + current_login_com_ids + ' AND save_status = 1"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" name="npdm_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div><div class="rTableCell"><label>Worker</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker' + counter + '"  name="worker_name[' + mainTrIndex + '][' + i + '][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + current_login_com_ids + '" width="100%"></select></div><div class="rTableCell"><label>Output</label>';
if(output_data != ""){
var oc = 0;
$.each(output_data, function(index, value) {
if (value.toString().indexOf('.') == -1) {
machine_append_Data33 += '<input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="' + index + '" readonly=""><input style="width:50%; float:left;" id="output ' + counter + '" class="form-control col-md-7 col-xs-12 output" name="output[' + mainTrIndex + '][' + i + '][' + oc + ']" placeholder="output" type="text" value="' + value + '" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">';
} else {
machine_append_Data33 += '<input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="' + index + '" readonly=""><input style="width:50%; float:left;" id="output ' + counter + '" class="form-control col-md-7 col-xs-12 output" name="output[' + mainTrIndex + '][' + i + '][' + oc + ']" placeholder="output" type="text" value="' + value.toFixed(3) + '" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)">';    
}
oc++; });
}

machine_append_Data33 += '</div><div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><button type="button" id="btnDel" class="dele btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><button type="button" id="' + set_mc_data + '" data-toggle="modal" data-id="machine_availability" data-title="Machine Availability" data-tooltip="Machine Availability"  class="productionTab btnCopy btn btn-success btn-xs"><i class="fa fa-clone"></i></button></div></div>';    
i++;
}
});
   
}
}
k++;

}
machine_append_Data33 += '</div>';
$(".app_div_planing").append(machine_append_Data33);
mc++;
});





init_select2();
init_select21();
get_jobcard_on_select();
init_select2so();
select_on_npdm_sale_order();
} else {
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

// $(document).on('click','.btnCopy',function(){
// var machine_id=$(this).parents().closest('.rTableRow').find('.machine_name_id').val();
// var machineGrp = $(this).parents().closest('.rTableRow').find('.machine_grp').val();
// var jc_id = $(this).parents().closest('.rTableRow').find('.job_card_product_id').val();
// var wo_id = $(this).parents().closest('.rTableRow').find('.WorkOrderId').val();



// var selected_department_idd = $('.department').find('option:selected').val();
// var compny_unit  = $('.compny_unit').find('option:selected').val();
// });

function auto_AddRowPlan() {
    var i = 1;
    $(".rTable").on("click", ".addR_auto", function() {
        i = parseInt($(this).parents().find('.dele').length) + 1;
        var same_id = $(this).parents().closest('.rTableRow').attr('id');
        var next_id = $(this).parents().closest('.rTableRow').next('.rTableRow').attr('id');
        var machineName = $(this).parents().closest('.rTableRow').find('.machine_name_id').val();
        var machineGrp = $(this).parents().closest('.rTableRow').find('.machine_grp').val();
        var dataWhereWorker = $("#current_login_com_id").val();
        var dataWhereJobNo = $("#current_login_com_id").val();
        var selected_department_idd = $('.department').find('option:selected').val();
        var compny_unit  = $('.compny_unit').find('option:selected').val();
        var TrId = $(this).parents().closest('.rTableRow').attr("id");
        var mainTrIndex = TrId.split('index').pop().split('_')[1];
        var counter = $('#prodPlan ').length - 1;
        var newRow = $("<div class='rTableRow mobile-view' id='addFunc_" + i + "'>");
        var cols = "";
        cols += '<div class="rTableCell"> <label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name_id"  placeholder="Job number"  type="hidden" name="machine_name_id[' + mainTrIndex + '][' + i + ']_' + i + '" value="' + machineName + '"/><input class="form-control col-md-2 col-xs-12 machnine_grp"  placeholder=""  type="hidden" name="machnine_grp[' + mainTrIndex + '][' + i + ']_' + i + '"" value="' + machineGrp + '"/></div>';
        cols += '<div class="rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId"  onchange="getMaterialNameWorkorder(event,this)"  name="work_order[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option value="">Select Option</option></select><input type="hidden"  name="sale_order[' + mainTrIndex + '][' + i + ']_' + i + '"  value="" class="SelectedSaleOrder"></div>';
        cols += '<div class="rTableCell"><label>Product Name</label><select class="form-control dis party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId" id ="product_name" name="product_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true" tabindex="-1" aria-hidden="true"></select></div>';
        cols += '<div class="rTableCell"><label>BOM Routing</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing" readonly  type="text" value=""><input type="hidden" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + mainTrIndex + '][' + i + ']_' + i + '" placeholder="BOM Routing Number" readonly  type="text" value=""></div>';
        cols += '<div class="rTableCell"><label>Process Name</label><select  onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name" name="process_name[' + mainTrIndex + '][' + i + ']_' + i + '"  ></select></div>';
        cols += '<div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + dataWhereJobNo + '"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" name="npdm_name[' + mainTrIndex + '][' + i + ']_' + i + '" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div>';
        cols += '<div class="rTableCell"><label>Worker</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker' + counter + '"  name="worker_name[' + mainTrIndex + '][' + i + '][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + dataWhereWorker + ' AND save_status = 1 AND active_inactive = 1" width="100%"></select></div>';
        cols += '<div class="rTableCell"><label>Output</label><input id="output ' + counter + '" class="form-control col-md-7 col-xs-12 output"  placeholder="output"  type="text" name="output[' + mainTrIndex + '][' + i + ']" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)" value="" /></div>';
        cols += '<div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><button type="button" id="btnDel" class="dele btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></div>';
        newRow.append(cols);
        // var indexBefore = parseInt(mainTrIndex) + 1;
        // if ($("#index_" + indexBefore).length > 0) {
        //     newRow.insertBefore("#index_" + indexBefore);
        // } else {
        //     newRow.appendTo(".app_div_planing");
        // }
        var indexBefore = '';
        if ($("#" + next_id).length > 0) {
            newRow.insertBefore("#" + next_id);
        } else {
            newRow.insertAfter("#" + same_id);
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

$(document).on('click','.add_process_btn',function(e){
e.preventDefault();
if($('.processtype').val() != ""){
$('#myform').submit();
} else {
$(".processtype").parent().before( "<p class='req_msg' style='color:#ff0000'>This field is required</p>" );
setTimeout(function () {
$('.req_msg').remove();
}, 2000);
}
});

$(document).on('change', '.add_documents input[type="file"]', function(e) {
var startArray = [];
const file = this.files[0];
const classa = $(this).next('.file_name');
        if (file){
          let reader = new FileReader();
          reader.onload = function(event){
            //console.log(event.target.result);
            $.ajax({
            url: site_url + 'production/uploaddocsByAjax/',
            dataType: 'json',
            type: "POST",
            data: {
            "image": event.target.result,
            'uploaded_image_name': e.target.files[0].name
            },
            success: function(data) {
            var result = JSON.parse(JSON.stringify(data));
            startArray.push(result.image);
            classa.val(result.image);
            }
            });
          }
          reader.readAsDataURL(file);
        }

// var reader = new FileReader();
// reader.readAsDataURL(this.files[0]);
// console.log(e.target.files);
// $(this).next('.file_name').val(e.target.files[0].name+'~'+e.target.files[0].type+'~'+e.target.files[0].size);
//alert();
//$(this).next('.file_name').val(startArray[0]);
});

$(document).on('mouseover','.mat_status',function(e){
$('.see-mat-status').hide();
$(this).find('.see-mat-status').show();
});

$(document).on('mouseout','.mat_status',function(e){
$('.see-mat-status').hide();    
});

function getOutputsubBom(evt, t) {
setTimeout(function() {
var option = $(t).find('option:selected');
var closestId = $(t).closest(".chk_idd_output").attr("id");
if (typeof closestId != 'undefined') {
//$("body").append('<div class="loading"><img src="'+site_url+'/assets/images/loading.gif"></div>');
var materialId = $('#' + closestId + ' .materialNameId_'+ closestId ).val();
//alert(materialId);
$.ajax({
type: "POST",
url: site_url + 'production/getMaterialDataById',
data: {
id: materialId
},
success: function(data) {
if (data != '') {
    $('#' + closestId + ' #sub_bom').val('');
     var dataObj = JSON.parse(data);
    if (dataObj) {
         var job_card = dataObj.job_card;
         //alert(job_card);
          if(job_card === null){
         $('#' + closestId + ' #sub_bom').val('N/A');
         } else {
         $('#' + closestId + ' #sub_bom').val(job_card);
         $('#' + closestId + ' .down_arrow').css('display', 'block');
         $('#' + closestId + ' .expand_selection').css('display', 'block');
         $('#' + closestId + ' .up_arrow i').attr('jc_number', job_card);
         $('#' + closestId + ' .down_arrow i').attr('jc_number', job_card);
         
         }
}
}
//$(".loading").remove();
}
});
}
}, 1000);
}

function expandOutputMat(evt, t) {
    var closestId = $(t).closest(".chk_idd_output").attr("id");
    var opt_val = $(t).attr('data-val');
    var y = $('#output_mat_set .chk_idd_output').length;
    if(opt_val == "more"){
    $('#' + closestId + ' .up_arrow').css('display', 'block');
    $('#' + closestId + ' .down_arrow').css('display', 'none');
    $('#' + closestId + ' >.expand_out_'+ closestId ).css({"display": "inline-block", "width": "100%", "padding-left": "40px"});
    var logged_user = $('#loggedUser').val();
    var jc_number = $(t).attr('jc_number');
    var lot = $('#lot').val();
    var material_qty =  $('#' + closestId + ' .qty_output').val();
    //alert(closestId);
    if(jc_number != ""){
    var logged_user = $('#loggedUser').val();
    //$("body").append('<div class="loading"><img src="'+site_url+'/assets/images/loading.gif"></div>');
    $.ajax({
        type: "POST",
        url: site_url + 'production/getjcDataById',
        data: {
        id: jc_number,
        set_out:'for_output',
        lot:lot,
        material_qty:material_qty,
        num_row : y
        },
        success: function(data) {
        if (data != '') {
        // $('#' + closestId + ' .expand_out_'+ closestId ).html('');
        // $('#' + closestId + ' .expand_out_'+ closestId ).css({"display": "inline-block", "width": "100%", "padding-left": "40px"});
        // $('#' + closestId + ' .expand_out_'+ closestId ).append(data);
        $(t).closest(".output_cls").after(data);
        setTimeout(function(){
        var material_type_id = $('.material_type').val();
        select2(material_type_id, logged_user);
        keyup_function_to_check_qty();
        getMaterials(material_type_id, y);
        init_select2();
        addMaterials();
        addMaterial_inputDetail();
        addMaterial_outputDetail();
        getUom();
        //$(".loading").remove();
         }, 2000);
        }
        }

        });
    } else {
    alert('Please choose Material Type First');
    }
    } else {
    $('#' + closestId + ' .up_arrow').css('display', 'none');
    $('#' + closestId + ' .down_arrow').css('display', 'block');
    //$('#' + closestId + ' .expand_out_'+ closestId ).css('display', 'none');
    $(t).closest(".output_cls").nextAll('.appended_trs').remove();    
    }
    
}

$(document).on('change','.final_process',function(e){
e.preventDefault();
var total_lenght = $('.final_process:radio:checked').length;
if(total_lenght > 1){
//alert('Allowed only one process for final output');
$('.final_process').prop('checked', false);
$(this).prop('checked', true);
} else {
$(this).prop('checked', true);  
}
});

function expandWoBom(evt, t) {
    var closestId = $(t).closest(".wo_well").attr("id");
    var opt_val = $(t).attr('data-val');
    var y = $('.input_fields_wrap .wo_well').length;
    if(opt_val == "more"){
    $('#' + closestId + ' .up_arrow').css('display', 'block');
    $('#' + closestId + ' .down_arrow').css('display', 'none');
    $('#' + closestId + ' >.expand_out_'+ closestId ).css({"display": "inline-block", "width": "100%", "padding-left": "40px"});
    var logged_user = $('#loggedUser').val();
    var wo_exqty = $(t).attr('wo_exqty');
    var wo_parent = $(t).attr('wo_parent');
    var jc_number = $(t).attr('jc_number');
    var lot = $(t).attr('lot_qty');
    var wo_id = $(t).attr('wo_id');
    var jobkey = $(t).attr('jobkey');
    var transfer_quantity = $(t).attr('transfer_quantity');
    var fst_qty = $(t).attr('fst_qty');
    var material_qty =  $('#' + closestId + ' .material_qty_'+ closestId ).text();
    if(jc_number != ""){
    var logged_user = $('#loggedUser').val();
    $.ajax({
        type: "POST",
        url: site_url + 'production/getwojcDataById',
        data: {
        wo_exqty: wo_exqty,
        wo_parent:wo_parent,
        id: jc_number,
        lot:lot,
        wo_id:wo_id,
        jobkey:jobkey,
        transfer_quantity:transfer_quantity,
        fst_qty:fst_qty,
        material_qty:material_qty,
        num_row : y
        },
        success: function(data) {
        if (data != '') {
        //$('#' + closestId).find('.appended_trs').remove();
        //$('#' + closestId).css({"display": "inline-block", "width": "100%", "padding-left": "5px"});
        $(t).closest(".wo_well").after(data);
        setTimeout(function(){
        var material_type_id = $('.material_type').val();
        select2(material_type_id, logged_user);
        keyup_function_to_check_qty();
        getMaterials(material_type_id, y);
        init_select2();
        addMaterials();
        addMaterial_inputDetail();
        addMaterial_outputDetail();
        getUom();
        //$(".loading").remove();
         }, 2000);
        }
        }

        });
    } else {
    alert('Please choose Material Type First');
    }
    } else {
    $('#' + closestId + ' .up_arrow').css('display', 'none');
    $('#' + closestId + ' .down_arrow').css('display', 'block');
    $('#' + closestId).nextAll('.appended_trs').remove(); 
    }
    
}

 const indentMaterialHtml = (x,logged_user) => {
    return `<div class="well scend-tr mobile-view"  id="chkIndex_${x}" style="overflow:auto;">
     <select class="appendMaterialTypeIdByMat material_type_id" style="width:0;height: 0;position: absolute;" name="material_type_id[]">
     </select>
     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
        <label >Material Name</label>
        <select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" 
          required="required" name="material_name[]" onchange="getTax(event,this)" data-where="created_by_cid=${getCompanyGroupId} AND status=1" 
            data-id="material" data-key="id" data-fieldname="material_name">
           <option value="">Select Option</option>
        </select>
        <input type="hidden" name="mat_idd_name" id="matrial_Iddd"><input type="hidden" name="matrial_name" id="matrial_name">
     </div>
     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
         <label class="col-md-2 col-sm-12 col-xs-12 ">HSN</label>
         <input name="hsnCode[]" class="form-control col-md-7 col-xs-12 hsnCode" title="<?php  echo $productInfo->hsnCode; ?>" readonly>
         <input type="hidden" name="hsnId[]" class="form-control col-md-7 col-xs-12 hsnId" title="<?php  echo $productInfo->hsnId; ?>" readonly>
      </div>
     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
       <label class="col-md-2 col-sm-12 col-xs-12 ">Description</label>
        <textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description" 
          title="<?php  echo $productInfo->description; ?>"></textarea>
     </div>
     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
        <label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label>
        <input type="text" placeholder="Qty." id="quantity" name="quantity[]" class="form-control col-md-7 col-xs-12 
          key-up-event checkBugget" onkeyup="keyupFunc(event,this)" onkeypress="return float_validation(event, this.value)" required="required">
        <input type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly value="">
        <input type="hidden" name="uom[]" readonly class="uom">
     </div>
     <div class="col-md-2 col-sm-12 col-xs-6 form-group">
        <label class="col-md-2 col-sm-12 col-xs-12">Expected Amount</label>
        <input type="text" id="amount" name="expected_amount[]" class="form-control col-md-7 col-xs-12 key-up-event amount" 
          onkeyup="keyupFunc(event,this)" placeholder="Exp Amt" onkeypress="return float_validation(event, this.value)">
     </div>
     <div class="col-md-1 col-sm-12 col-xs-12 form-group">
        <label class="col-md-1 col-sm-12 col-xs-12 ">Purpose</label>
        <textarea id="purpose"  name="purpose[]" class="form-control col-md-1" placeholder="purpose"></textarea>
        <br><br>
     </div>
     <div class="col-md-1 col-sm-12 col-xs-12 form-group">
        <label class="col-md-2 col-sm-12 col-xs-12 ">Sub Total</label>
        <input  style="border-right: 1px solid #c1c1c1 !important;" id="sub_total"  name="sub_total[]" class="form-control col-md-2" placeholder="sub_total" readonly>
        <br><br>
     </div>
     <button class="btn  btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button>
  </div>`;
}

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
           $(inputfield).append(indentMaterialHtml(x,logged_user));
            //select2(1 ,1);
            var logged_user = $('#loggedUser').val();                           
            var material_type_id = $('#material_type').val();
            //select2(material_type_id , logged_user);
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



    var date = new Date();

        //date.setDate(date.getDate()-1);

        $('#req_date').datepicker({ 

            //startDate: date,

            format: "dd-mm-yyyy",

            autoclose: true

        });

    $('#req_date').on('changeDate', function (e) {

        $('.req_date').closest('.item').removeClass('bad');

    });

} 
function repeat(){
$('.down_arrow').each(function(key, value) {
if($(this).find('i').attr('jc_number') != ''){
if($(this).css('display') != 'none'){
$(this).find('i').click();
}
}
});
}
$(document).ready(function(){
var url = $(location).attr('href');
var segments = url.split( '/' );
var action = segments[4].split( '?' );
if(action[0] == "work_order_material_details"){
$("body").append('<div class="loading"><img src="'+site_url+'/assets/images/loading.gif"></div>');
var intervalId = window.setInterval(function(){
repeat();
}, 200);
setTimeout(function(){
clearInterval(intervalId);
var set = [];
$('.indent_create').each(function(key, value) {
var closestId = $(this).closest(".wo_well").attr("id");
set.push($('#' + closestId + ' .indent_create').val());  
});
$(".indent_create_btn").attr('data-set', set);
if(set != ''){
$(".indent_create_btn").show();
}
//$('.up_arrow').find('i').click();
$(".loading").remove();
}, 5000); 
}
});


$(document).on('change','.indent_create',function(e){
e.preventDefault();
var set = [];
$('.indent_create:checkbox:checked').each(function(key, value) {
var closestId = $(this).closest(".wo_well").attr("id");
set.push($('#' + closestId + ' .indent_create').val());  
});
if(set == ''){
$(".indent_create_btn").hide();    
} else {
$(".indent_create_btn").show();    
}
$(".all_indent_create").prop('checked', false);
$(".indent_create_btn").attr('data-set', set);
});

$(document).on('change','.all_indent_create',function(e){
e.preventDefault();
if ($(this).is(':checked')){
var set = [];
$('.indent_create').each(function(key, value) {
var closestId = $(this).closest(".wo_well").attr("id");
set.push($('#' + closestId + ' .indent_create').val());  
});
if(set == ''){
$(".indent_create_btn").hide();    
} else {
$(".indent_create_btn").show();    
}
$(".indent_create").prop('checked', true);
$(".indent_create_btn").attr('data-set', set);
} else {
$(".indent_create").prop('checked', false);
$(".indent_create_btn").hide(); 
$(".indent_create_btn").attr('data-set', '');
}
});

function autoPrintProduction(){
    $('button[id^="printBtn_"]').on("click", function(e){
        //var closestId2 = $(this).parents().find('.Process-card-print').attr('id');
        //var closestId2 = $(this).parents().siblings('.Process-card-print').attr('id');
        var closestId2 = $('.'+this.id).attr('id');
        // alert('.'+this.id);  
        // alert("#" + closestId2);
        printDiv(document.getElementById("#" + closestId2));
        var modThis = document.querySelector("#" + closestId2);
        console.log('modThis===>>>', modThis);
        //window.print();
        function printDiv(div) {
          // Create and insert new print section
            var elem = document.getElementById(closestId2);
            var domClone = elem.cloneNode(true);
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            $printSection.appendChild(domClone);
            document.body.insertBefore($printSection, document.body.firstChild);
            window.print();
            // Clean up print section for future use
            var oldElem = document.getElementById("printSection");
            if (oldElem != null) {
                 $('.bleow_hide').hide();
                oldElem.parentNode.removeChild(oldElem);
            }
            //oldElem.remove() not supported by IE
            return true;
        }
    });
}

$(document).on('click','.mc_available',function(e){
var checked_mch = $("input[name='sel_mchine']:checked").val();
var mchName = $("input[name='sel_mchine']:checked").attr('data-mchName');
var mchID = $("input[name='sel_mchine']:checked").attr('data-mchID');
var woName = $("input[name='sel_mchine']:checked").attr('data-woName');
var woId = $("input[name='sel_mchine']:checked").attr('data-woId');
var pName = $("input[name='sel_mchine']:checked").attr('data-pName');
var pId = $("input[name='sel_mchine']:checked").attr('data-pId');
var jcName = $("input[name='sel_mchine']:checked").attr('data-jcName');
var jcId = $("input[name='sel_mchine']:checked").attr('data-jcId');
var apName = $("input[name='sel_mchine']:checked").attr('data-apName');
var apId = $("input[name='sel_mchine']:checked").attr('data-apId');
var machineGrp = $("input[name='sel_mchine']:checked").attr('data-mchGID');
var opName = $("input[name='sel_mchine']:checked").attr('data-opName');
var opVal = $("input[name='sel_mchine']:checked").attr('data-opVal');
var req_output = $("input[name='sel_mchine']:checked").attr('data-reqOut');
var dataWhereWorker = $("#current_login_com_id").val();
var dataWhereJobNo = $("#current_login_com_id").val();
var selected_department_idd = $('.department').find('option:selected').val();
var compny_unit  = $('.compny_unit').find('option:selected').val();
var cols = "";
var i = 1;
$('.app_div_planing .Process-card .rTableRow').each(function(key, value) {
var machineId = $(this).find(".machine_name_id").val();
if(checked_mch == machineId){
var closestId = $(this).find(".machine_name_id").closest(".rTableRow").attr("id");
var mainTrIndex = closestId.split('index').pop().split('_')[1];
var counter = $('#prodPlan ').length - 1;
var set = [];
set.push(opName, opVal);
var set_mc_data = jcId+'~~'+apName+'~~'+apId+'~~'+mchName+'~~'+mchID+'~~'+selected_department_idd+'~~'+compny_unit+'~~'+req_output+'~~'+woName+'~~'+woId+'~~'+jcName+'~~'+pName+'~~'+pId+'~~'+machineGrp+'~~'+set;
$('#' + closestId).html('');
cols += '<div class="rTableCell"> <label>Machine Name<span class="required">*</span></label><input class="form-control col-md-2 col-xs-12 machine_name" name="machine_name[]" placeholder="Machine Name" type="text" value="' + mchName + '" readonly=""><input class="form-control col-md-2 col-xs-12 machine_name_id" name="machine_name_id[' + mainTrIndex + '][0]" placeholder="Machine Name" type="hidden" value="' + mchID + '" readonly=""><input class="form-control col-md-2 col-xs-12 machine_grp" name="machine_grp[' + mainTrIndex + '][0]" placeholder="Machine Name" type="hidden" value="' + machineGrp + '" readonly=""></div>';
cols += '<div class="rTableCell"><label>Work Order</label><select class="form-control dis selectAjaxOption select2 select2-hidden-accessible WorkOrderId"  onchange="getMaterialNameWorkorder(event,this)"  name="work_order[' + mainTrIndex + '][0]" width="100%" tabindex="-1" aria-hidden="true" data-id="work_order" data-key="id" data-fieldname="workorder_name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + logged_user + ' AND company_branch_id=' + compny_unit + ' AND department_id=' + selected_department_idd + ' AND progress_status = 0"><option value="">Select Option</option><option value="' + woId + '" selected>' + woName + '</option></select><input type="hidden"  name="sale_order[' + mainTrIndex + '][0]"  value="" class="SelectedSaleOrder"></div>';
cols += '<div class="rTableCell"><label>Product Name</label><select class="form-control dis party_code_cls selectAjaxOption24 select2 select2-hidden-accessible productNameId" id ="product_name" name="product_name[' + mainTrIndex + '][0]" width="100%" tabindex="-1" aria-hidden="true" tabindex="-1" aria-hidden="true"><option value="' + pId + '" selected>' + pName + '</option></select></div>';
cols += '<div class="rTableCell"><label>BOM Routing</label><input  class="form-control col-md-2 col-xs-12 job_card" name="job_card_product_name[' + mainTrIndex + '][0]" placeholder="BOM Routing" readonly  type="text" value="' + jcName + '"><input type="hidden" class="form-control col-md-2 col-xs-12 job_card_product_id" name="job_card_product_id[' + mainTrIndex + '][0]" placeholder="BOM Routing Number" readonly  type="text" value="' + jcId + '"></div>';
cols += '<div class="rTableCell"><label>Process Name</label><select  onchange="get_outputPP(event,this);" class="form-control process_name" id="process_name" name="process_name[' + mainTrIndex + '][0]"  ><option value="' + apId + '" selected>' + apName + '</option></select></div>';
cols += '<div class="rTableCell"><label>NPDM</label><select class="selectAjaxOption select2 form-control npdm" data-where="created_by_cid=' + dataWhereJobNo + '"  data-id="npdm" id="npdm" data-key="id" data-fieldname="product_name" width="100%" id="npdm" name="npdm_name[' + mainTrIndex + '][0]" width="100%" tabindex="-1" aria-hidden="true"><option value="">Select Option</option></select></div>';
cols += '<div class="rTableCell"><label>Worker</label><select multiple class="worker_name form-control col-md-2 col-xs-12 " id="worker' + counter + '"  name="worker_name[' + mainTrIndex + '][0][]" data-id="worker" data-key="id" data-fieldname="name" tabindex="-1" aria-hidden="true" data-where="created_by_cid=' + dataWhereWorker + ' AND save_status = 1 AND active_inactive = 1" width="100%"></select></div>';
cols += '<div class="rTableCell"><label>Output</label><input style="width:50%; float:left;" class="form-control col-md-7 col-xs-12" type="text" value="' + opName + '" readonly=""><input style="width:50%; float:left;" id="output" class="form-control col-md-7 col-xs-12 output" name="output[' + mainTrIndex + '][0][0]" placeholder="output" type="text" value="' + opVal + '" onkeyup="keyupFun(event,this)" onkeypress="return float_validation(event, this.value)"></div>';
cols += '<div class="rTableCell" style="border-right: 1px solid #c1c1c1;"><input type="button" class="addR_auto btn btn-success btn-xs"  value="Add" /><button type="button" id="' + set_mc_data + '" data-toggle="modal" data-id="machine_availability" data-title="Machine Availability" data-tooltip="Machine Availability"  class="productionTab btnCopy btn btn-success btn-xs"><i class="fa fa-clone"></i></button></div>';
$('#' + closestId).html(cols);
init_select2();
init_select21();
get_jobcard_on_select();
init_select2so();
select_on_npdm_sale_order();
i++;
counter++;
$('#production_modal').modal('hide'); 
} else {
$('#production_modal').modal('hide');
}
});
   
});


function chkShiftData(evt, t) {
    var option = $(t).find('option:selected');
    var id = $(option).val();
    var company_id = $('.company_unit').find(":selected").val();
     $.ajax({
        type: "POST",
        url: site_url + 'production/chkShiftData',
        data: {
            id: id,
            company_id:company_id
        },
        success: function (data) {
        if(data == "true"){
        alert('Shift already exits for this department.')
        $('#send').hide();
        } else {
        $('#send').show();
        }
        }
    });

}

$(document).on('click','.auto_reserve_btn',function(e){
var total_length = $('.reserve_unreserve_set').length;
var i = 0;
$('.reserve_unreserve_set').each(function(key, value) {
i++;
var reserve_set =  $(this).find('.reserve_set').attr('id');
$.ajax({
type: "POST",
url: site_url + 'production/autoReserveMaterial',
data: {
    id: reserve_set
},
success: function (data) {
}
});
if(i == total_length){
setTimeout(function(){
location.reload(); 
}, 3000);   
}

});

});


function expandautoAllSection(evt, t) {
var opt_val = $(t).attr('data-val');
if(opt_val == "more"){
$('.Process-card').show(); 
$('.unexpandautoAllSection, .up_arrow_auto').css('display', 'block');
$('.down_arrow_auto, .expandautoAllSection').css('display', 'none'); 
} else {
$('.Process-card').hide(); 
$('.up_arrow_auto, .unexpandautoAllSection').css('display', 'none');
$('.down_arrow_auto, .expandautoAllSection').css('display', 'block');
}  
}
function expandautoSection(evt, t) {
    $('.Process-card').hide();
    $('.up_arrow_auto').css('display', 'none');
    $('.down_arrow_auto').css('display', 'block');
    var opt_val = $(t).attr('data-val');
    if(opt_val == "more"){
    $(t).closest(".mch_groptitle").next('.Process-card').show();
    $(t).parent('.down_arrow_auto').prev('.up_arrow_auto').css('display', 'block');
    $(t).parent('.down_arrow_auto').css('display', 'none');
    } else {
    $(t).closest(".mch_groptitle").next('.Process-card').hide();
    $(t).parent('.up_arrow_auto').next('.down_arrow_auto').css('display', 'block');
    $(t).parent('.up_arrow_auto').css('display', 'none');
    }
}



function addMoreSale_orderMaterial() {
	var max_fields = 10; //maximum input boxes allowed
	var wrapper = $(".input_holder"); //Fields wrapper
	var add_button = $(".addMorefileds"); //Add button ID
	var x = 1; //initlal text box count

	$(add_button).click(function(e) { //on add input button click
		e.preventDefault();

		
		var company_login_id = $('#company_login_id').val();




		if (x < max_fields) { //max input box allowed
			x++;

			$(wrapper).append('<div class="well edit-row1 scend-tr" style="overflow:auto; border-top: 1px solid #c1c1c1 !important;" id="chkIndex_'+ x +'"><div class="col-md-2 col-sm-12 col-xs-12 form-group" ><select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 " id="mat_name" required="required" name="material_name[]"  data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid='+ company_login_id +' AND status=1" onchange="getUom(event,this)"><option value="">Select Option</option></select></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="number" name="transfer_quantity[]" class="form-control col-md-7 col-xs-12 transfer_quantity" placeholder="WorkOrder Qty"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" class="form-control col-md-7 col-xs-12 uom" placeholder="uom."  readonly=""><input type="hidden" name="uom[]" class="form-control col-md-7 col-xs-12  uomid"  ></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><input type="text" name="job_card[]" class="form-control col-md-7 col-xs-12  job_card" placeholder="Job card" value="" readonly=""></div><button style="margin-right: 0px;" class="btn btn-danger remove_field" type="button"> <i class="fa fa-minus"></i></button></div>');
			init_select2();
			
		}
		$(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        y--;
    });

	});
}	