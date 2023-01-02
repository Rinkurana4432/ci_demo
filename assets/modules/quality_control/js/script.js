
/*******************************************************Other modules*******************************************/
$(document).ready(function(e) {   


	var splitUrl = window.location.pathname.split('/');


    [,,getController] = splitUrl;

    var checkUrl = `${site_url}quality_control/sale_orders`;
    var url      = window.location;


     if( url == checkUrl ){
        localStorage.setItem('activeTab') == '#inprocess_sale_order'
    }



	$(document).on("click",".qualityTab",function(ev){
		ev.preventDefault();
		var id = $(this).attr('id');
		var result = $(this).attr('result');
		var tab = $(this).attr('data-id');
		var reportType = $(this).attr('reporttype');
	//console.log('===================>',tab); 

		var url = '';
		switch (tab) {
		   case 'overview':
                url = 'quality_control/view_overview';
                 
            break;

			 case 'machineid':
                url = 'quality_control/viewMachaine';
                 
            break;
			case 'AddNewReport':
				url = 'quality_control/add_new_report';
				break;	
		    case 'EditNewReport':
		        	url = 'quality_control/edit_new_report';
		        	break;
		    case 'SimilarNewReport':
		        	url = 'quality_control/add_similar_report';
		        	break;
		    case 'ViewReport':
		            url = 'quality_control/view';
		        	break;
			case 'DeleteReport':
		            url = 'quality_control/delete';
		        	break;
		    case 'AddInspectionReport':
		        	url = 'quality_control/inspection_report';
		        	break;
		    case 'ViewInspectionReport':
		        	 url = 'quality_control/view_inspection';
		        	break;
		    case 'EditInspectionReport':
		        	url = 'quality_control/edit_inspection';
		        	break;
		    case 'AddControlledReport':
		        	url = 'quality_control/controlled_report';
		        	break;
		    case 'EditControlledReport':
		        	url = 'quality_control/edit_controlled';
		        	break;
		    case 'ViewControlledReport':
		        	 url = 'quality_control/view_controlled';
		        	break;
			 case 'AddGrn':
		        	url = 'quality_control/add_grn';
		        	break;
			case 'ViewGrn':
					url = 'quality_control/view_grn';
		        	break;
			 case 'AddPid':
		        	url = 'quality_control/add_pid';
		        	break;
			case 'ViewPid':
					url = 'quality_control/view_pid';
		        	break;
		     case 'AddNcr':
		        	url = 'quality_control/add_ncr';
		        	break;
			case 'ViewNcr':
					url = 'quality_control/view_ncr';
		        	break;
			case 'CloseNcr':
					url = 'quality_control/close_ncr';
		        	break;
			case 'EditGood':		
					url = 'quality_control/finish_goods_edit';
		        	break;
		    case 'AddInstrument':
		       url = 'quality_control/add_instrument';
		        	break;
		    case 'EditInstrument':
		       url = 'quality_control/edit_instrument';
		        	break;
		    case 'ViewInstrument':
		       url = 'quality_control/view_instrument';
		        	break;
		   case 'addJobPosition':
		       url = 'quality_control/add_job_position';
		        	break;
		   case 'editJobPosition':
		       url = 'quality_control/add_job_position';
		        	break;
		  case 'viewJobPosition':
		       url = 'quality_control/view_job_position';
		        	break;  
		  case 'addJobApplication':
		       url = 'quality_control/add_job_application';
		        	break;
		  case 'editJobApplication':
		       url = 'quality_control/add_job_application';
		        	break;
		  case 'viewJobApplication':
		       url = 'quality_control/view_job_application';
		        	break; 
		 case 'editterms_condtn':
		       url = 'quality_control/editterms_condtn';
		        	break; 
		  case 'viewterms_condtn':
		       url = 'quality_control/termscond_view';
		        	break; 
		case 'jobcard_details':
		       url = 'quality_control/jobcard_details';
		        	break; 
		}
		
		$.ajax({
			type: "POST",
			url: site_url+ url,
			data: {id:id,result:result},
			context:this,
			success: function(data){
			    //alert(id);
				if(data !=='') {
					$("#quality_modal").modal({
                        show:false,
                        backdrop:'static'
                    });
                    commanSelect2();					
					$('#quality_modal').modal('show');
					if(tab == 'EditInspectionReport' || 'AddGrn' || 'AddPid' ){
						$('#quality_modal .modal-large').css('width','80%');
					}
					$('#quality_modal .modal-body-content').html(data);
					if($('#btnPrint').length!==0){
							Print_data_new();
					}
					if(tab == 'editterms_condtn'){
					CKEDITOR.replace( 'terms_cond' );
				}
					if(tab == 'AddInspectionReport'){
					init_select_uom();
					init_select_workorder();
					}
					if(tab == 'EditInspectionReport'){
					init_select_uom();
					init_select_workorder();
					getMachineNameByProcess($(this).attr('jobCard'),$(this).attr('processId'),$(this).attr('machineid'),id);
					getMachineDataByProcess($(this).attr('jobCard'),$(this).attr('processId'),$(this).attr('machineid'),id);
					//getMachineDataByProcess($(this).attr('jobCard'),$(this).attr('processId'),id);
					}
					if(tab == 'ViewInspectionReport'){
					getMachineDataByProcess($(this).attr('jobCard'),$(this).attr('processId'),$(this).attr('machineid'),id,'view');
					//getMachineDataByProcess($(this).attr('jobCard'),$(this).attr('processId'),id);
					}
				if (tab == 'AddGrn') {
					init_select221();
					init_select_uom();
                     //get_material_table_values();
                     get_product_qty();
                     get_material_name();
                     if( $(this).attr('id') != "" ){
                     	get_material_table_values('grn',$(this).attr('id'));
                     }
                        // get_company_unit();
                    }
					if (tab == 'AddPid') {
					init_select221();
					init_select_uom();
                     //get_material_table_values();
                      if( $(this).attr('id') != "" ){
                     	get_material_table_values('pid',$(this).attr('id'));
                     }
                        // get_company_unit();
                    }
				if(tab == 'CloseNcr'){
					addRootCause();
					addCorrCause();
					addPrevCause();
				}
				if(tab == 'AddNcr'){
					init_select22();
					addProblem();
					addEmail();
					addRootCause();
					addCorrCause();
					addPrevCause();
				}
				if(tab == 'EditNewReport'){
				init_select221();
				init_select_uom();
				addMoreButton();
				init_select_jobcard();
				init_select_instrument();
				init_select_process();
				commanSelect2();
				}
				if(tab == 'AddNewReport'){
				init_select221();
				init_select_uom();
				addMoreButton();
				init_select_instrument();
				init_select_jobcard();
				init_select_process();
				commanSelect2()
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
				commanSelect2();
			} 
		}
		}); 
	});
/** edit report **/
 $(document).on("click","#remove_row",function() {
	clrt=$(this).val();
   $(clrt).parents('tr').remove();
        if($('table tr').length>1) {
        $(this).closest('tr').remove();
        $('td.sno').text(function (i) {
          return i + 1;
        });
		}
});

	   /**/
	   
//Workorder name
function init_select_workorder(){
		$('.workorder').select2({
		allowClear: true,
		placeholder: 'Workorder Name',
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
				$('#sale_order').val(searched_value);
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
}
//customer name	  
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
				
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});	
}

//Material Name
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
				$('#sel_grn').val(searched_value);
				$('#sel_pid').val(searched_value);
				$('#sel_con1').val(searched_value);
				var matID = $('#material_type_id').val();
				//console.log("matId",matID);
				$('#material_type_id').val(matID);
			
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
}

//uom
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
//jobcard
function init_select_jobcard() {
	var workorder=$('#sale_order').val();
	$('.jobcard').select2({
		allowClear: true,
		placeholder: 'JobCard',
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
				$('#sel_ins1').val(searched_value);
				$('#sel_job').val(searched_value);
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
}
//process
function init_select_process() {
	$('.process').select2({
		allowClear: true,
		placeholder: 'Process',
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
				$('#sel_ins2').val(searched_value);
			}
		},
		escapeMarkup: function (markup) {
			return markup;
		}
	});
}
//instrument
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

 
  function addMoreButton(){
		  $('.addMoreButton').click(function () {
		  var i=2;
		  var logged_user = $('#loggedInUserId').val();
		  var inc = $('#inctr').val();
		      var str = `<tr>
						   <td class="sno">${i}</td>
						   <td><input type="text" style="width:70px" name="report[create${inc}][parameter]"/></td>
						   <td><select class="instrument  form-control selectAjaxOption select2" name="report[create${inc}][instrument]"  width="100%" id="instrument" data-id="instrument" data-key="id" data-fieldname="name" data-where="created_by_cid=${logged_user}" tabindex="-1" aria-hidden="true"></select></td>
						   <td>
						      <select class="uom  form-control selectAjaxOption select2" name="report[create${inc}][uom1]"  width="100%" id="uom" data-id="uom" data-key="id" data-fieldname="uom_quantity" data-where="created_by_cid=0 OR created_by_cid=${logged_user}" tabindex="-1" aria-hidden="true" >
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


			      if($('table tr').length>1) {
		        $(this).closest('tr').remove();
		        $('td.sno').text(function (i) {
		          return i + 1;
		        });
		}  init_select_uom();
		  init_select_instrument();
		  
	});
  }
 	var val=$("input[type=radio][name='sale_order']:checked").val(); 
    if(val==='process'){
           $('#print_div_content').show(); 
           $('#print_div_content1').hide(); 
    }
});


$(document).on('change', 'select#sel_job', function (e) {
	// alert();
    e.preventDefault();
    var jobcard_id = jQuery(this).val();
    //alert(material);
    get_jobcard_process(jobcard_id);
 
});
  
    jQuery(document).on('change', 'select#sale_order', function (e) {
    e.preventDefault();
    $('#sel_job').val("");
     $('#sel_process').html("");
	 //jQuery("#example tbody").html("")
    var workorder_id = jQuery(this).val();
    get_jobcard_products(workorder_id);
 
});
  /** get grn table data **/
   function get_material_table_values(reportType = "",id="")
  {		
 	   	var material = $('#sel_con1').val();
       $.ajax({
        url: site_url+"quality_control/get_con_table_values",
        type: 'post',
        data: {material_id: material,reportType:reportType,id:id},
         dataType: 'json',
        success: function (data) {
        	$('.reportParameter').html('');
        	if( data != "" ){
        		console.log(data.paremeter);
        		//var report = JSON.parse(data);
        		$('#reportParameter').html(data.paremeter);
        		$('#ins').val(data.reportData.observations);
				$('#ins').prop('readonly',true);
        		$('input[name="per_lot_of"]').val(data.reportData.per_lot_of);
        		$('input[name="per_lot_of"]').prop('readonly',true);

        	}
          
        },
    });
  }
  
  
  function get_table_data()
  {
     var job=$('#sel_job').val();
     var process_id=$('#sel_process').val();
     get_table_values(job,process_id);
  }
  
  function get_table_values(job,process)
  {
       $.ajax({
        url: site_url+"quality_control/get_job_table_values",
        type: 'post',
        data: {jobcard: job,process_id:process},
         dataType: 'json',
        success: function (data) {
          //alert(data.report_name);
           var str = '';
           var i=1;
                $.each(data, function (index, value) 
                {  i++;});
            //jQuery("#table_data").html(str);
           
        },
    });
  }
  
  
  function  get_jobcard_products(workorder_id)
  {
      $.ajax({
        url: site_url+"quality_control/get_work_products",
        type: 'post',
        data: {workorder: workorder_id},
        success: function (data) {
           // alert(data);
           data=$.parseJSON(data);
           var options = '';
            options +='<option value="">Select </option>';
                $.each(data, function (index, value) {
					if(value.job_card!=''){
                options += '<option value="' + value.job_card + '">' +value.job_card;+ '</option>';
					}
 });
            jQuery("select#sel_job").html(options);
			
        },
    });
  }
  
  
  function get_jobcard_process(jobcard_id)
  {		
       $.ajax({
        url: site_url+"quality_control/get_job_process_type",
        type: 'post',
        data: {jobcard: jobcard_id},
        success: function (data) {
        	jQuery('.machineData').html('');  	
            jQuery("select#sel_process").html('');
        	if( data ){
        		var htmlData = JSON.parse(data);
        		jQuery('.machineData').html(htmlData.machineData);  	
            	jQuery("select#sel_process").html(htmlData.options);
        	}
 
        },
    });
  }

/** Add report **/
function chk_radio(){
	
           var radioValue = $("input[name='report_chk']:checked").val();
          //alert(radioValue);
        if(radioValue == "manufacturing"){
			$("#sel_ins1").prop("disabled", false );
			$("#sel_ins2").prop("disabled", false );
			$("#sel_pid").prop("disabled", true );
			$("#sel_grn").prop("disabled", true );
        } 
        else if(radioValue == "grn")
        {
			$("#sel_pid").prop("disabled", true );
			$("#sel_ins1").prop("disabled", true );
			$("#sel_ins2").prop("disabled", true );
			$("#sel_grn").prop("disabled", false );
        }
		else if(radioValue == "pid")
		{
			$("#sel_ins1").prop("disabled", true );
			$("#sel_ins2").prop("disabled", true );
			$("#sel_grn").prop("disabled", true );
			$("#sel_pid").prop("disabled", false );
		}
           
       }


function calculate(clrt)
{
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

    jQuery(document).on('change', 'select#sel_ins1', function (e) {
    e.preventDefault();
    var jobcard_id = jQuery(this).val();
    //alert(material);
    get_report_jobcard_process(jobcard_id);
 
});
  
  function get_report_jobcard_process(jobcard_id)
  {
       $.ajax({
        url:site_url+"quality_control/get_job_process_type",
        type: 'post',
        data: {jobcard: jobcard_id},
        success: function (data) {
            jQuery("select#sel_ins2").html(data);
 
        },
    });
  }
  
  /****** NCR ********/
  function get_saleorder()
  {
	  $('#email_id').val('');
	  $('#custsaleorder').val('');
     var account_id=$('#account_id').val();
      $.ajax({
        url:site_url+"quality_control/get_cust_saleorder",
        type: 'post',
        data: {account_id:account_id},
        success: function (data) {
        $("select#custsaleorder").html(data);
        }
      });
  }
  
    function get_email()
  {
	   $('#email_id').val('');
	  $('#custsaleorder').val('');
	    $("#custsaleorderproducts").val('');
     var account_id=$('#account_id').val();
      $.ajax({
        url:site_url+"quality_control/get_cust_email",
        type: 'post',
        data: {account_id:account_id},
        success: function (data) {;
        $("#email_id").val(data);
        }
      });
  }
  
  function get_saleorder_products()
  {
	  $("#custsaleorderproducts").val();
      var saleorder_id=$('#custsaleorder').val();
      $.ajax({
        url:site_url+"quality_control/get_cust_saleorder_products",
        type: 'post',
        data: {saleorder_id:saleorder_id},
        success: function (data) {
        $("select#custsaleorderproducts").html(data);
        }
      }); 
  }
  
    function addProblem(){
	var wrap         = $(".fields_wrap_prob"); //Fields wrapper
	var add_btn      = $(".field_button_prob"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-3 col-sm-3 col-xs-6"><input type="text" class="form-control" name="problem[]" required></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

  function addEmail(){
	var wrap         = $(".fields_wrap_email"); //Fields wrapper
	var add_btn      = $(".field_button_email"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-3 col-sm-3 col-xs-6"><input type="email" class="form-control" name="email[]"></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

  
  function addRootCause(){
	var wrap         = $(".fields_wrapdd"); //Fields wrapper
	var add_btn      = $(".field_buttondd"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-3 col-sm-3 col-xs-6"><input type="text" class="form-control" name="root_cause[]" required></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

  function addCorrCause(){
	var wrap         = $(".fields_wrap_corr"); //Fields wrapper
	var add_btn      = $(".field_button_corr"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-3 col-sm-3 col-xs-6"><input type="text" class="form-control" name="corr_act[]" required></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}

  function addPrevCause(){
	var wrap         = $(".fields_wrap_prev"); //Fields wrapper
	var add_btn      = $(".field_button_prev"); //Add button ID	
	var y = 1; //initlal text box count
	$(add_btn).click(function(e){ //on add input button click	
		e.preventDefault();		
		y++; 
		$(wrap).append('<div style="clear: both;margin-bottom: 10px;overflow: hidden;"><label class="col-md-3 col-sm-12 col-xs-12" for="certificate"></label><div class="col-md-3 col-sm-3 col-xs-6"><input type="text" class="form-control" name="prev_act[]" required></div><button class="btn btn-danger rmv_field" type="button" ><i class="fa fa-minus"></i></button></div>');
	});	
	$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); y--;
	})		
}
/*** GRN ***/
  function chk_qty()
  {
	  var tot_qty=$('#tot_qty').val(); 
	  var qty_pass=$('#qty_pass').val(); 
	  var qty_reject=$('#qty_reject').val(); 
	  var qty_rework=$('#qty_rework').val();
	  var sum_qty =Number(qty_pass)+Number(qty_reject)+Number(qty_rework);
	  if(tot_qty >= sum_qty)
	  {
	  }else{ 
	 $('#qty_pass').val(''); 
	 $('#qty_reject').val(''); 
	 $('#qty_rework').val('');	  
		  }
  }
  function get_material_name()
{
		var material_id=$('#sel_con1').val();
	    $.ajax({
        url: site_url+"quality_control/get_product_name",
        type: 'post',
        data: {material: material_id},
        success: function (data) {
	     $("#material_name").html(data);
		 },
    });
}


function get_product_qty()
{
	var material_id=$('#sel_con1').val();
		url=site_url+"quality_control/get_grn_product_quantity";
	    $.ajax({
        url:url,
        type: 'post',
        data: {product: material_id},
        success: function (data) {
	     $("#tot_qty").val(data);
		 },
    });
}

//validate
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
									   url: site_url+'quality_control/approve_ncr',
									   data: { id:register_id, approve:1, validated_by:loggedinUser }, 
									   success: function(result) {
										  // alert(result);
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
	 $(".disapproveReasonModal #id").val(register_id);
	var disapprove_reason = row.find("td .disapprove_reason").text();
	//$(".disapproveReasonModal #indent_id").val(indent_id);
	$(".disapproveReasonModal #disapprove_reason").text(disapprove_reason);
    $('.disapproveReasonModal').modal('show');
});
/* For PipeLine Module Drag & Drop Functionality*/

 $(function () {
 //	gettotal();
	var kanbanCol = $('.panel-body');
	kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');
	var kanbanColCount = parseInt(kanbanCol.length);
	$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');
    var dragClass = $(".dragg");
	var draggrnClass = $(".dragggrn");
	var dragpdiClass = $(".draggpdi");
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
	  
	  if (draggrnClass.hasClass('dragggrn')){
	 //if(($(this).hasClass('dragg')))
	  //{
		  console.log("grn");
		draggablegrnInit();
	  }
	  if (dragpdiClass.hasClass('draggpdi')){
	 //if(($(this).hasClass('dragg')))
	  //{
		console.log("pdi");
		draggablepdiInit();
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
                url: site_url + 'quality_control/changeProcessType/',
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
                // after post
				$("#id").val(elementId);
				$("#active_tab").val('inspection');
				$('#comment').modal('toggle'); 
            }, 1000);
			//location.reload();
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

function draggablegrnInit() {
	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {
		console.log('event===>>>',event);	
		sourceId = $(this).parent().attr('id');		
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
		console.log("sourceId=>>>",event.originalEvent.dataTransfer.getData("text/plain"));
	});
	$('.panel-body-grn').bind('dragover', function (event) {
		event.preventDefault();	
	});
	$('.panel-body-grn').bind('drop', function (event) {		
		var children = $(this).children();
		var targetId = children.attr('id');
		//alert(targetId);
		var status=$('#status').val();console.log("status==>>",status);
		//alert(status);
		console.log("targetid==>>",targetId);
		if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
			console.log("elementId->>",elementId);
		    
			$.ajax({				
				url: site_url+'quality_control/changeProcessType1/',	
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
			$('#comment').modal('toggle'); // after post
			//$('#comment').modal(); 
			$("#id").val(elementId);
			$("#active_tab").val('grn');
		
            }, 1000);
		}else{
		$(".kanban-centered").sortable({			
			connectWith: ".kanban-centered",
			scroll: false,
			cursor:'pointer',
			revert:true,
			opacity:0.4,
			update: function() {
					sendOrderToServer1();
				 }
			}).disableSelection();
		event.preventDefault();
		}
	});	
}

function draggablepdiInit() {
	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {
		console.log('event===>>>',event);	
		sourceId = $(this).parent().attr('id');		
		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
		console.log("sourceId=>>>",event.originalEvent.dataTransfer.getData("text/plain"));
	});
	$('.panel-body-pdi').bind('dragover', function (event) {
		event.preventDefault();	
	});
	$('.panel-body-pdi').bind('drop', function (event) {		
		var children = $(this).children();
		var targetId = children.attr('id');
		
		//alert(targetId);
		var status=$('#status').val();//console.log("status==>>",status);
		//alert(status);
		console.log("targetid==>>",targetId);
		if (sourceId != targetId) {
			var elementId = event.originalEvent.dataTransfer.getData("text/plain");
			console.log("elementId->>",elementId);
		    
			$.ajax({				
				url: site_url+'quality_control/changeProcessType1/',	
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
				//$('#processing-modal').modal('toggle'); // after post
				$('#comment').modal('toggle'); 
				$("#id").val(elementId);
				$("#active_tab").val('pdi');
			}, 1000);
		}else{
		$(".kanban-centered").sortable({			
			connectWith: ".kanban-centered",
			scroll: false,
			cursor:'pointer',
			revert:true,
			opacity:0.4,
			update: function() {
				sendOrderToServer1();
				 }
			}).disableSelection();
		event.preventDefault();
		}
	});	
}

function sendOrderToServer() {
	alert();
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
		url: site_url+'quality_control/changeOrder/',
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
	
function sendOrderToServer1() {
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
		url: site_url+'quality_control/changeOrder1/',
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


/***********datatable in sale Orders [Listing]****************/
$(document).ready(function (){
    $('#inprocess').dataTable({
		"pageLength": 15
	});
    		
    $('#complete').dataTable( {
      "pageLength": 15
    });

    $('.commanSelect2').select2();

});

function commanSelect2(){
	$('.commanSelect2').select2();	
}

$(document).on('keyup','.obsInput',function(){
	let uniqueVal = $(this).attr('data-unique');
	//let observ    = $('.observations').val();
	var totalObesrv = 0;
	$(`.obs${uniqueVal}`).each(function(){
		console.log( $(this).val() );
		totalObesrv += +$(this).val();
	});

	var observ = $('.obsInput').length;
	let avg = (parseInt(totalObesrv)/parseInt(observ));
	$(`#obsAvg${uniqueVal}`).val( avg );
});
function Print_data_new(){
	document.getElementById("btnPrint").onclick = function () {	
		printDiv(document.getElementById("print_divv"));			
	 	function printDiv(div) {			
			var elem = document.getElementById('print_divv');
			var domClone = elem.cloneNode(true);
			var $printSection = document.createElement("div");
			$printSection.id = "printSection";
			$printSection.appendChild(domClone);
			document.body.insertBefore($printSection, document.body.firstChild);
			window.print(); 
			var oldElem = document.getElementById("printSection");
			if (oldElem != null) { oldElem.parentNode.removeChild(oldElem); } 
			return true;
		}

	}	    
}

$(document).on('change','#sel_process',function(){
	//alert( );
	var jobCard   = $('option:selected', this).attr('jobcardno');
	var processId = $(this).val();
	getMachineNameByProcess(jobCard,processId);
})

function getMachineNameByProcess(jobCard,processId,machineId="",incId=""){
	$.ajax({
			url:`${site_url}quality_control/getMachineByProcess`,
			method:'post',
			data:{jobCard:jobCard,processId:processId,machineId:machineId,incId:incId},
			error: ( error ) => console.log( error ),
			success: ( data ) => {
				if( data != "" ){
					var htmlData = JSON.parse(data);
					$('#process_machine').html(htmlData.options);
				}
			}
		})	
}

$(document).on('change','#process_machine',function(){
 
	getMachineDataByProcess($('option:selected', this).attr('jobcard'),$('option:selected', this).attr('processid'),$(this).val());
})


function getMachineDataByProcess(jobCard,processId,machineId,incId = "",view){
	$('.machineData').html('');
	 $('.machineParameter').html('');
	if( typeof jobCard !== 'undefined' && typeof processId !== 'undefined' ){
		var line=$('#ins').val();
        $.ajax({
			url:`${site_url}quality_control/get_machine_by_process_type`,
			method:'post',
			data:{jobCard:jobCard,processId:processId,machineId:machineId,incId:incId,view:view,line:line},
			error: ( error ) => console.log( error ),
			success: ( data ) => {
				$('.machineData').html('');
				 $('.machineParameter').html('');
				if( data != "" ){
					var htmlData = JSON.parse(data);
					$('.machineData').html(htmlData.machineData);
					$('.machineParameter').html(htmlData.machineParemeter);
					commanSelect2();
				}
			}
		})
	}
}

$('#bbtn').on('click', function() {
    printData();
})

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
function getDept(evt, t) {
    $('.department').empty('');
      
    var logged_user = $('#loggedUser').val();
    if (window.location.href == site_url + 'production/production_planning') {
        $(".app_div_planing").html('');
    } else if (window.location.href == site_url + 'production/production_data') {
        $(".app_div").html('');
    }
    var selected_unit_name = $(t).find('option:selected').val();
    $('.department').attr('data-where', ' created_by_cid=' + logged_user + ' AND unit_name = "' + selected_unit_name + '"');
    $('.department').attr('data-id', 'department');
    $('.department').attr('data-key', 'id');
    $('.department').attr('data-fieldname', 'name');
 
}