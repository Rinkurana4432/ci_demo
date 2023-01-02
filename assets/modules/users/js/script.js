$(document).ready(function(e) {   
	$('#date').datepicker({
		singleClasses: "picker_4",
        format: 'yyyy-mm-dd',
        endDate: '+0d',
        autoclose: true
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
      $("<img />", { "src": e.target.result,"class": "", "height":"100px", "width":"100px"}).appendTo(image_holder);
    }
    image_holder.show();
    reader.readAsDataURL($(this)[0].files[0]); } else { alert("This browser does not support FileReader."); }
});




$(function() {
	$('body').on('click', '.reservation', function() {
			$(this).daterangepicker({
			timePicker: false,
			//timePickerIncrement: 30,
			locale: {
				format: 'MM/DD/YYYY',
			}
	}).attr('readonly', 'true').focus();
});
});			
			

$(function() {
	$('body').on('click', '.year', function() {
		$(this).not('.hasDatePicker').datepicker({
			minViewMode: 2,			 
			endDate: new Date(),
			autoclose: true,
			//yearRange: '1950:' + new Date().getFullYear().toString()
			format: 'yyyy',
		  }).attr('readonly', 'true').focus();
	});
});



/*add more for key people*/
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".quaification_wrapper"); //Fields wrapper
    var add_button      = $(".add_qualification_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
	
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; 
			$(wrapper).append('<div class="col-md-10 input_qualification_wrap item"><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" id="qualification" name="qualification[]" class="form-control col-md-1 qualification_section" placeholder="Qualification" ></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" id="university"   name="university[]" class="form-control col-md-1 qualification_section" placeholder="University"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text"  name="year[]" class="form-control col-md-1 year qualification_section" placeholder="Year of Passing" readonly></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="number" id="marks"  required="required" name="marks[]" class="form-control col-md-1" placeholder="Percentage"></div><button class="btn btn-danger remove_qualification_field" type="button"><i class="fa fa-minus"></i></button></div>');
        }
    });
    
    $(wrapper).on("click",".remove_qualification_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });

	
	
	
	/*add more for experience*/
	var max_fields      = 10; //maximum input boxes allowed
    var experienceWrapper         = $(".experience_wrapper"); //Fields wrapper
    var add_button      = $(".add_experience_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
	
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; 
			$(experienceWrapper).append('<div class="col-md-12 input_experience_wrap item"><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="companyName" name="companyName[]" class="form-control col-md-1 work_experience_section" placeholder="Company Name" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><input type="text" id="companyLocation"   name="companyLocation[]" class="form-control col-md-1 work_experience_section" placeholder="Location" value=""></div><div class="col-md-1 col-sm-12 col-xs-12 form-group"><input type="text" id="position"   name="position[]" class="form-control col-md-1 work_experience_section" placeholder="Position" value=""></div><div class="col-md-3 col-sm-12 col-xs-12"><form class="form-horizontal"><fieldset><div class="control-group"><div class="control-group"><div class="controls"><div class="input-prepend input-group"><span class="add-on input-group-addon">Work Period</span><input type="text" style="width: 200px" name="work_period[]" class="form-control reservation" value="01/01/2016 - 01/25/2016" /></div></div></div></div></fieldset></form></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><textarea id="responsibility"  name="responsibility[]" class="form-control col-md-7 col-xs-12 work_experience_section" placeholder="Responsibilities"></textarea></div><button class="btn btn-danger remove_experience_field" type="button"><i class="fa fa-minus"></i></button></div>');
            
        }
    });
    
    $(experienceWrapper).on("click",".remove_experience_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
	
	
	
	
	/*add more for skills*/
	var max_skill_fields      = 5; //maximum input boxes allowed
    var skill_wrapper         = $(".skill_wrapper"); //Fields wrapper
    var add_skill_button      = $(".add_skill_button"); //Add button ID
    var y = 1; //initlal text box count
    $(add_skill_button).click(function(e){ //on add input button click
	
        e.preventDefault();
        if(y < max_skill_fields){ //max input box allowed
            y++; 
			$(skill_wrapper).append('<div class="col-md-10 input_skill_wrap item"><div class="col-md-4 col-sm-12 col-xs-12 form-group"><input type="text" name="skill_name[]" class="form-control col-md-7 skill_section" placeholder="Name" value=""></div><div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="number"  name="skill_count[]" class="form-control col-md-1 skill_section" placeholder="Count" value=""></div><button class="btn btn-danger remove_skill_field" type="button"><i class="fa fa-minus"></i></button></div>');
        }  
    });
    
    $(skill_wrapper).on("click",".remove_skill_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); y--;
    });
	
	
	
	
	
	
	
var limit = 10; //The number of records to display per request
var start = 0; //The starting pointer of the data
var action = 'inactive'; //Check if current action is going on or not. If not then inactive otherwise active
function load_user_log_data(limit, start){
	var segment_str = window.location.pathname;
	var segment_array = segment_str.split( '/' );
	var last_segmentId = segment_array[segment_array.length - 1];
	$.ajax({
		url: site_url +'users/fetch_user_activity_log/',
		method:"POST",
		data:{limit:limit, start:start, id:last_segmentId},
		cache:false,
		success:function(data){
			$('#load_data').append(data);
			if(data == ''){
				//$('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
				$('#load_data_message').html("<p>No Records</p>");
				action = 'active';
			}
			else{
				$('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
				action = 'inactive';
			}
		
		}
	});
}
 
if(action == 'inactive'){
	action = 'active';
	load_user_log_data(limit, start);
}

$(window).scroll(function(){
	if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive'){
		action = 'active';
		start = start + limit;
		setTimeout(function(){
			load_user_log_data(limit, start);
		}, 1000);
	}
});


});

 $(document).on('click', '.change_status', function() {
    var status;    
    var checkbox =    $(this).attr('checked', true);
    if(checkbox.context.checked == true) status = 1;
    else status = 0;
    var id = $(this).attr("data-value");
	$.ajax({
		url: site_url +'users/change_status/',
		dataType: 'json',
		type: 'POST',
		data: {
			id: id,
			status: status,
		},
		success: function(data){
			if( data.status == 'success'){
				location.reload();
			}
		}
	});
});
		
		
$('.permissions_cls').on('click', function(e){ 
		if($(this).hasClass('all') && $(this).prop('checked')==true) {			
			$(this).closest("tr").find(".permissions_cls").prop('checked', true);	
		} else if($(this).hasClass('all') && $(this).prop('checked')==false) {			
			$(this).closest("tr").find(".permissions_cls").prop('checked', false);	
		}
		if($(this).closest("tr").find(".all").prop('checked')==true) {			
			$(this).closest("tr").find(".permissions_cls").prop('checked', true);	
		}		
		/*if($(this).closest("tr").find(".add").prop('checked')==true) {
			$(this).closest("tr").find(".view").prop('checked', true);	
		}*/
		if($(this).closest("tr").find(".add").prop('checked')==true  && $(this).closest("div").parent().is("#collapse_5") == false) {			
				$(this).closest("tr").find(".view").prop('checked', true);				
		}
		
		if($(this).closest("tr").find(".edit").prop('checked')==true  && $(this).closest("div").parent().is("#collapse_5") == false) {
			$(this).closest("tr").find(".view").prop('checked', true);	
			$(this).closest("tr").find(".add").prop('checked', true);	
		}
		if($(this).closest("tr").find(".delete").prop('checked')==true && $(this).closest("div").parent().is("#collapse_5") == true) {
			//$(this).closest("tr").find(".view").prop('checked', true);	
			$(this).closest("tr").find(".add").prop('checked', true);	
			$(this).closest("tr").find(".edit").prop('checked', true);	
		}else if($(this).closest("tr").find(".delete").prop('checked')==true && $(this).closest("div").parent().is("#collapse_5") == false){
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
		if($(this).closest("tr").find(".validate").prop('checked')==true) {
			$(this).closest("tr").find(".view").prop('checked', true);	
			$(this).closest("tr").find(".add").prop('checked', true);	
		}
});
	

	function showListView(){
		$('#gridview').hide();
		$('#listview').show();
	}
	
	function showGridView(){
		$('#listview').hide();
		$('#gridview').show();
	}
	

function getState(evt, t , type = ''){	
console.log('evt===>>>',evt);	
console.log('t===>>>',t);	
console.log('type===>>>',type);	

	var appendedClass = type != ''?'.'+type+'.state_id':'.state_id';
	var appendedClassCity = type != ''?'.'+type+'.city_id':'.city_id';	
	$(appendedClass).empty();
	$(appendedClassCity).empty();	
	var option = $(t).find('option:selected');
	//var country_id = type != ''?type:$(option).val();
	var country_id = $(option).val();
	
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





$(document).ready(function(){
	$(".country_id").each(function() {		
		/*var countryVal = $(this).val() ;		
		var closestDiv = $(this).attr("closestDiv");
		var stateVal = $(this).attr("state_data");
		var cityVal = $(this).attr("city_data");	*/
		var closestDiv = $(this).attr("closestDiv");
		var stateVal = $(this).attr("state_data");
		var cityVal = $(this).attr("city_data");
		var countryVal  = 1 ;
		getState('','',countryVal ,closestDiv , stateVal );
	});
	
	$(".state_id").each(function() {		
		var stateVal = $(this).val();
		var closestDiv = $(this).attr("closestDiv");
		var cityVal = $(this).attr("city_data");
		getCity('','',stateVal ,closestDiv ,cityVal );
	});
});

 $(document).on('click', '.add_users_dataaa44', function() {
	$('.qualification_section').each(function(){
       if (this.value == "") {
        // $('#qualification').addClass('bad');
		 $(this).closest('.item').addClass('bad');
       }else{
		   $(this).closest('.item').removeClass('bad');
	   } 
    })
	
	$('.work_experience_section').each(function(){
       if (this.value == "") {
        // $('#qualification').addClass('bad');
		 $(this).closest('.item').addClass('bad');
       }else{
		   $(this).closest('.item').removeClass('bad');
	   } 
    })
	$('.skill_section').each(function(){
       if (this.value == "") {
        // $('#qualification').addClass('bad');
		 $(this).closest('.item').addClass('bad');
       }else{
		   $(this).closest('.item').removeClass('bad');
	   } 
    })
	 
	 
 });
 

	$(document).ready(function(e) {	
		getUserActivityGraphData();
	});
	
	
	function getUserActivityGraphData(){			
		var userid = $("input[name='u_id']").val();
		$.ajax({    
			url: site_url +'users/userActivityGraphData/',
			dataType: 'json',
			type: 'POST',
			data: {'userid': userid},
			success: function(response){
				if(response != ''){
					activityJsonObj = [];
					$(response).each(function() {
						item = {}
						item ["date"] = $(this)[0].date_field;
						item ["Activity count"] = $(this)[0].userId;
						activityJsonObj.push(item);
					});
					if ($('#user_activity_graph_bar').length){ 
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






















	
$(document).ready(function(){
	
	  
	  
	  
$('#upload_user_profile_image').click(function(event){
	$('#uploadimageModal').modal('show');
});


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
		//$('#uploadimageModal').modal('show');
	  });

	  $('.crop_image').click(function(event){		
		var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		var userId = $("input[name=u_id]").val();
		$image_crop.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: site_url +'users/uploadImageByAjax/',
				type: "POST",
				data:{"image": response, 'uploaded_image_name': uploaded_image_name, 'user_id':userId},
				success:function(data){	
				  var result = $.parseJSON(data);
					window.location.href = site_url +'users/edit/'+userId;				  
				  $('#uploadimageModal').modal('hide');
				 // $('#uploaded_image').html(data);
				  $('#uploaded_image').html(result.imageHtml);
				  $('#changed_user_profile').val(result.image);
				  
				}
			});
		})
	  });


	  });
	  



