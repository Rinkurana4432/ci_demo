//var base_url = 'http://busybanda.com/erp/';
//var chat_id = 1;
$(document).ready(function(e) {
init_select2();	
	/*add more Key People*/
	var max_fields      = 10; //maximum input boxes allowed
	//var wrapper         = $(".input_fields_wrap"); //Fields wrapper
	var wrapper         = $(".keyPeopleWrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click	
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++;
			$(wrapper).append('<div class="col-md-6 col-sm-5 col-xs-12 input_fields_wrap wrapperLeftMargin"><input type="text" id="key_people" name="key_people[]" class="form-control col-md-7 col-xs-12 fieldAdd" placeholder="Mr.john"><button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})

	/*qualification add more*/
		var maxfields      = 10; //maximum input boxes allowed
		//var wrap         = $(".fields_wrap"); //Fields wrapper
		var wrap         = $(".certificationWrap"); //Fields wrapper
		var add_btn      = $(".field_button"); //Add button ID
		
		var y = 1; //initlal text box count
		$(add_btn).click(function(e){ //on add input button click
			e.preventDefault();
			if(y < maxfields){ //max input box allowed
				y++; 
				$(wrap).append('<div class="col-md-11 col-sm-6 col-xs-12 fields_wrap certificationWrapperLeftMargin"><input type="file" class="form-control col-md-7 col-xs-12 certificationField" name="certification[]"><button class="btn btn-danger rmv_field" type="button"><i class="fa fa-minus"></i></button></div>');
				
				
			}
		});
		
		$(wrap).on("click",".rmv_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); y--;
		})
	

/*year of establishment*/
   var year = (new Date).getFullYear();
	$('#year').datepicker({
		minViewMode: 2,
		endDate: new Date(),
		autoclose: true,
		format: 'yyyy'
	}).attr('readonly', 'true');

if( $('#range').length ) {
	// Save slider instance to var
	var slider = $("#range").data("ionRangeSlider");
	var revenue = $('#range').val();
	var revenueVal = revenue.split(";");
	var revenueFrom = revenueVal[0];
	var revenueTo = revenueVal[1];
	/*Range slider*/
	$("#range").ionRangeSlider({
	   type: "double",
	   grid: true,
	   min: 0,
	   max: 10000000,
	   from: 200,
	   to: 800,
	   prefix: "Rs"
	});	
	
	
	
	// Change slider, by calling it's update method
	var slider = $("#range").data("ionRangeSlider");
	slider.update({
			type: "double",  
			min: 0,
			max: 10000000,
			from: revenueFrom,
			to: revenueTo, 
			prefix: "Rs"
		});
		
		}
			
	/*logo code*/
		$("#logoSite").on('change', function () {
		  if (typeof (FileReader) != "undefined") {
			var image_holder = $("#logo-holder");
			image_holder.empty();
			var reader = new FileReader();
			reader.onload = function (e) {
			  $("<img />", { "src": e.target.result,"class": "", "height":"100px", "width":"100px"}).appendTo(image_holder);
			}
			image_holder.show();
			reader.readAsDataURL($(this)[0].files[0]); } else { alert("This browser does not support FileReader."); }
		});
		
		
		
		/*connect code*/
		/*$(".connectBtn").on('click', function () {
			$('.connectSearchBtn').show();
		});*/
		
		$(".searchCompanyList").on('keyup', function () {
			$('.companyList').empty();
			searchText = $(this).val();
			searchText = $.trim(searchText); 
			if(searchText !== ''){
				var compantNameUl = '';
				$.ajax({
					type: "POST",
					url: site_url +'company/searchCompanyList/',
					data: {companyName: searchText},
					success: function (response) {
						if(response){
							var companyResponseList = JSON.parse(response);
							compantNameUl += '<div class="x_content">'
							$(companyResponseList).each(function(key,value) {
								//compantNameUl += '<li class="companyLi" data-value="'+value.id+'" onclick="getCompanyProfile(event,this)">'+value.name+'</li>'
								compantNameUl += '<article class="media event"><div class="media-body title" data-value="'+value.id+'" onclick="getCompanyProfile(event,this)">'+value.name+'</div></article>'
							});
							compantNameUl += '</div>'
							$('.companyList').append(compantNameUl);
						}
						
					}
				});
			}
		});
		
		
});

function getCompanyProfile(evt,option){
	$('.companyProfile').empty();
	var companyId = $(option).attr('data-value');
	$.ajax({
		type: "POST",
		url: site_url +'company/getCompanyData/',
		data: {companyId: companyId},
		success: function (response) {		
			if(response !=''){
				$('.companyProfile').append(response);	

				productSlider();
				
				 /*   $('.cproductSlider').slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						autoplay: true,
						autoplaySpeed: 1000,
						arrows: false,
						dots: false,
						pauseOnHover: true,
						responsive: [{
							breakpoint: 992,
							settings: {
								slidesToShow: 2
							}
						},{
							breakpoint: 768,
							settings: {
								slidesToShow: 2
							}
						}, {
							breakpoint: 520,
							settings: {
								slidesToShow: 1
							}
						}]
					}); */

				
				/* Open News Feed Tab   */
				$("#newsfeedmore").click(function(){
					$("#newsfeed").toggle();
					$("#about-detail").hide();
					$("#about-detail1").hide();
				});
				
				$("#about-more").click(function(){
					$("#about-detail").toggle();
					$("#newsfeed").hide();
				});
				$("#about-more1").click(function(){
					$("#about-detail1").toggle();
					$("newsfeed").hide();
				});
	
	
			}
			setTimeout(function(){
				$(".emp a").removeAttr("href");
			}, 2000);			
		}
	});
	
}


 function fnValidatePAN(Obj) { 
	if (Obj.value != "") {
		ObjVal = Obj.value;
		var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})$/;
		if (ObjVal.search(panPat) == -1) {
			 console.log("Invalid Pan No");
			 $('.companyPan').closest('.item').addClass('bad');
		     //Obj.focus();
			$('.companyPan').closest('.item').append("<div class='alert'>Invalid PanCard number</div>");
			$(".submitCompanyBtn").attr( "disabled", "disabled" );
			return false;
		}
	  else
		{
			$(".submitCompanyBtn").removeAttr("disabled");
		   console.log("Correct Pan No");
		  }
	}
}






/*Address add more*/
		var maxfields      = 10; //maximum input boxes allowed		
		var addressWrap    = $(".address_wrapper"); //Fields wrapper
		var add_address_btn = $(".add_address_button"); //Add button ID
		var addressLength = $('.addressLength').val();
		
		var z = 1;
		$(add_address_btn).click(function(e){ //on add input button click
		//init_select2();
			e.preventDefault();
			if(z < maxfields){ //max input box allowed
			z++; 	
			var divlength = $('.input_address_wrap').length;
				
				var addressClass = 'address'+divlength;				
				console.log('addressClass====>>>>',addressClass);
				$(addressWrap).append('<div class="item form-group well2 input_address_wrap" id="chkIndex_'+divlength+'"><div class="col-md-12 " ><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Branch Name</label><div class="col-md-6 col-sm-12 col-xs-12"><input type="text" id="compny_branch_name" name="compny_branch_name[]" class="form-control col-md-1" placeholder="Company Branch Name" value=""></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Address</label><div class="col-md-6 col-sm-12 col-xs-12 form-group"><textarea id="address" required="required" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea></div></div><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="item form-group col-md-3 col-sm-3 col-xs-12"><label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getState(event,this)"><option value="">Select Option</option></select></div></div><div class="item form-group col-md-3 col-sm-3 col-xs-12"><label class="control-label col-md-4 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible '+addressClass+' state_id" name="state[]"  width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getCity(event,this)"><option value="">Select Option</option></select></div></div><div class="item form-group col-md-2 col-sm-3 col-xs-12"><label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">Permanent City<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible '+addressClass+' city_id" name="city[]"  width="100%" tabindex="-1" aria-hidden="true" required="required"><option value="">Select Option</option></select></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">Postal/Zipcode<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value=""></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1" class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">Company GSTIN<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input style="border-right: 1px solid #c1c1c1" type="text" id="company_gstin" name="company_gstin[]" class="form-control col-md-1" placeholder="Company GSTIN" value=""></div></div></div><button class="btn btn-danger remove_address_field" type="button"><i class="fa fa-minus"></i></button></div>');
				
				
			}
			init_select2();	
		});
		
		$(addressWrap).on("click",".remove_address_field", function(e){ //user click on remove text
			//e.preventDefault(); $(this).parent('div').parent('div').parent('div').remove(); z--;
			e.preventDefault(); $(this).parent('div').parent('div').remove(); z--;
		})
		
		
		
		
function getState(evt, t , type = ''){
	var closestId = $(t).closest(".input_address_wrap").attr("id");	
console.log('closestIdddddddddddd===>>>>',closestId);	
	var appendedClass = '#'+closestId+' .state_id';
	var appendedClassCity = '#'+closestId+' .city_id';
	$(appendedClass).empty();
	$(appendedClassCity).empty();	
	var option = $(t).find('option:selected');
	// alert(option);
	var country_id =$(option).val();
	if(country_id != ''){
		$(appendedClass).attr('data-where','country_id = '+country_id);		
		$(appendedClass).attr('data-id','state');
		$(appendedClass).attr('data-key','state_id');
		$(appendedClass).attr('data-fieldname','state_name');			
	}
}


function getCity(evt , t, type = ''){
	var closestId = $(t).closest(".input_address_wrap").attr("id");
	
	var appendedClass = '#'+closestId+' .city_id';
	$(appendedClass).empty();	
	var option = $(t).find('option:selected');	
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
		var countryVal = $(this).val() ;
		var closestDiv = $(this).attr("closestDiv");
		var stateVal = $(this).attr("state_data");
		var cityVal = $(this).attr("city_data");
		getState('','',countryVal ,closestDiv , stateVal );
	});
	
	$(".state_id").each(function() {
		var stateVal = $(this).val();
		var closestDiv = $(this).attr("closestDiv");
		var cityVal = $(this).attr("city_data");
		getCity('','',stateVal ,closestDiv ,cityVal );
	});
	
	$("#cover-opt").click(function(){
			$("#covermenu").toggle();
		});
		
	$("#newsfeedmore").click(function(){
			$("#newsfeed").toggle();
			$("#about-detail").hide();
			$("#about-detail1").hide();
	});
		
		
    $("#about-more").click(function(){
			$("#about-detail").toggle();
			$("#newsfeed").hide();
		});
	$("#about-more1").click(function(){
			$("#about-detail1").toggle();
			$("newsfeed").hide();
		});
		
		
		$(".acceptConnection").click(function(){
			var connection_activation_code = $(this).attr('data-code');
			$.ajax({
				type: "POST",
				url: site_url +'company/verifyConnectionRequest/',
				data: {connection_activation_code: connection_activation_code},
				success: function (response) {
					if(response){
					console.log('response==>',response);
						alert(response);
						window.location.href = site_url +'company/connection_request/';	
					}
				}
				
				
		});	
	});
});





// Add/Edit Modal for Company modules 
/* $(document).on("click",".add_company_tabs",function(){
	var id = $(this).attr('id');
	var tab = $(this).attr('data-id');
	var url = '';
	switch (tab) {
		case 'company_view':
			url = 'company/view';
			data = {id:id};
			break;
	}
	$.ajax({
		type: "POST",
		url: site_url + url,
		data: data, 
		success: function(data){
			if(data != '') {
				$('#company_modal').modal('toggle');
				$('#company_modal .modal-body-content').html(data);
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
		}
	}); 
});	*/




/*    Chatting Intercpmmunication */


$(document).ready(function() {

    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }

    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.'); 
        return;
    }
	
	if (window.location.href.indexOf('/non_connected_message') > 0 || window.location.href.indexOf('/message') > 0) {	
		setInterval(function() {
			get_chats_messages();
		}, 4000); 
		//}, 40000);
	}
	

    $("input#chat_message").keypress(function(e) {
		
        if (e.which == 13) {

            $("a#submit_message").click();

            return false;

        }
    });
	
	
	
	$(document).on("click",".messageCompany",function(){
		$.post(site_url + "company/redirect/"+user_id+"/"+company_id_to+"/", function(data) {
			$.post(site_url + "company/getInsertedChatId/"+user_id+"/"+company_id_to+"/", function(response) {
				console.log('response===>>>',response);
					chat_id = response;
				});
		});			
	});
	
	

    //$("a#submit_message").click(function(e) { 
	//$(document).on("click","a#submit_message",function(){
	$(document).on("click","#submit_message",function(){
      //  e.preventDefault();
        //var content = $("textarea#chat_message").val();
        var content = $("#chat_message").val();
        var userfile = $("input#userfile").val();		
        if (content == "") return false;
       // $.post(base_url + "index.php/chat/ajax_add_chat_message", { content: content, chat_id: chat_id, user_id: user_id }, function(data) {
        $.post(site_url + "company/ajax_add_chat_message", { content: content, chat_id: chat_id, user_id: user_id }, function(data) {
            /* Condition */
            if (data.status == 'ok') {
                var current_content = $("div#chat_viewport").html();
                $("div#chat_viewport").html(current_content + data.content);
                /* Scroll each time you submit new message */
                $('div#chat_viewport').scrollTop($('div#chat_viewport')[0].scrollHeight);
            } else {
                /* Error here */
            }
        }, "json");
        $("input#chat_message").val("");
        return false;
    });

    function get_chats_messages(){	
		if(typeof chat_id !== 'undefined'){
       // $.post(base_url + "index.php/chat/ajax_get_chats_messages", { chat_id: chat_id }, function(data) {
        $.post(site_url + "company/ajax_get_chats_messages", { chat_id: chat_id }, function(data) {

            /* Condition */
            if (data.status == 'ok') {
               // console.log(current_content);
                var current_content = $("div#chat_viewport").html();

                $("div#chat_viewport").html(current_content + data.content);
                
                if (!data.content == '') {
                    var notification = new Notification('Notification title', {
                      icon: '',
                      body: "There is an incoming message, please check !!",
                });
						//When we click on message notification 
                    notification.onclick = function () {
                      //window.open("http://stackoverflow.com/a/13328397/1269037");      
                    };

                    /* Scroll each time you get new message */
                    $('div#chat_viewport').scrollTop($('div#chat_viewport')[0].scrollHeight);
                } else {
                    
                }
                

            } else {
                /* Error here */
            }

        }, "json");

        return false;
		}
    }

    //get_chats_messages();

});


/* -------------- product slider in company profile ----------- */

	$(document).ready(function(){
   /* $('.cproductSlider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000,
        arrows: false,
        dots: false,
        pauseOnHover: true,
		responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 2
            }
        },{
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });*/
	productSlider();
});

/* ----------- tab resize ----------- */

// function resize() {
	
    // if ($(window).width() < 992) {
		// alert('hhh');
		// $('.companyv .check_cls').removeClass('nav-stacked');
	// }else{
		
		// $('.companyv .check_cls').addClass('nav-stacked');
		
		// }
// }

// $(document).ready( function() {
    // $(window).resize(resize);
    // resize();
// });

/* ----------- top searched slider ----------- */


$(document).ready(function(){
    $('.top-searchedSlider1').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000,
        arrows: true,
        dots: false,
        pauseOnHover: true,
		responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 1
            }
        },{
            breakpoint: 992,
            settings: {
                slidesToShow: 1
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 1
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });
	$('#tab1').css('position', 'relative').css("right", "0").show();
});


function productSlider(){
    $('.cproductSlider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000,
        arrows: false,
        dots: false,
        pauseOnHover: true,
		responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 2
            }
        },{
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });
}




/****************************************************************************image upload query for news feed post comment******************************************************/

/*$(document).ready(function(){  
	$('#image').click(function(event){
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
	//alert("dsf");
		//var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		var uploaded_image_name = $('#user_profile').val().replace(/.*(\/|\\)/, '');
		//console.log("upload image",uploaded_image_name);
		var userId = $("input[name=u_id]").val();
		$image_crop.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: site_url +'company/uploadImageByAjax/',
				dataType: 'json',
				type: "POST",
				data:{"image": response, 'uploaded_image_name': uploaded_image_name, 'user_id':userId},
				success:function(data){	
				//console.log("result",data);
				  var result = $.parseJSON(data);
				  window.location.href = site_url +'company/view';	
//alert("hello");				  
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


/*************************************************************************************image upload for company logo ***************************************************/
$(document).ready(function(){  
	$('#logoSite').click(function(event){
		$('#imageModalUpload').modal('show');
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
	$('#logo').on('change', function(){
		//alert("sad");
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
	//alert("dsf");
		//var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		
		var uploaded_image_name = $('#logo').val().replace(/.*(\/|\\)/, '');
		//console.log("upload image",uploaded_image_name);
		var userId = $("input[name=u_id]").val();
		$image_crop.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: site_url +'company/uploadImageByAjax/',
				dataType: 'json',
				type: "POST",
				data:{"image": response, 'uploaded_image_name': uploaded_image_name, 'user_id':userId},
				success:function(data){	
				//console.log("result",data);
				//alert(typeof(data));
				 // var result = jQuery.parseJSON(data);
				  var result = JSON.stringify(data);
				  //console.log("resul",result);
				  window.location.href = site_url +'company/edit/'+userId;	
			  
				  $('#imageModalUpload').modal('hide');
				 // $('#uploaded_image').html(data);
				  $('#uploaded_image').html(result.imageHtml);
				  $('#changed_user_profile').val(result.image);
				  
				}
			});
		})
	});
	
	//code for remove logo image
	$(document).on("click",".remove_logo_dd",function(){ 
		if(confirm('Are you sure!') == true) {
		    $('.imaged').attr('src', '');
		    $('.logo_oldimaged').val('');
			$('.mask').hide();
		}		
	 });
	
	
	
	
	
	
	
});



/****************************************************************************image upload on post method********************************************************/
$(document).ready(function(){  
	$('#post_image').click(function(event){
		$('#uploadimageModal').modal('show');
	});


	$image_crop1 = $('#image_demo1').croppie({
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
	$('#post_crop_image').on('change', function(){
		//alert("sad");
		$('.crop_section1').css("display", "block");
		var reader = new FileReader();
		reader.onload = function (event) {
			$image_crop1.croppie('bind', {
				url: event.target.result
			}).then(function(){
				console.log('jQuery bind complete');
			});
		}
		reader.readAsDataURL(this.files[0]);
		//$('#uploadimageModal').modal('show');
	});

	$('.crop_image1').click(function(event){		
	//alert("dsf");
		//var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		var uploaded_post_image_name = $('#post_crop_image').val().replace(/.*(\/|\\)/, '');
		//console.log("upload image",uploaded_image_name);
		var user_Id = $("input[name=u_id]").val();
		//console.log(user_Id);
		$image_crop1.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: site_url +'company/uploadPostImageByAjax/',
				dataType: 'json',
				type: "POST",
				data:{"img": response, 'uploaded_post_image_name': uploaded_post_image_name, 'userid':user_Id},
				success:function(data){	
				console.log("result",data);
				//alert(typeof(data));
				 // var result = jQuery.parseJSON(data);
				  var result1 = JSON.parse(JSON.stringify(data));
				  console.log("1",result1);
				  console.log("resul",result1.image);
				  //window.location.href = site_url +'company/view/';	
			  
				  var a = $('#image_post').val(result1.image);
				  console.log("aa",a);
				  $('#uploadimageModal').modal('hide');
				 // $('#uploaded_image').html(data);
				  $('#uploaded_image').html(result1.imageHtml);
				  $('#changed_user_profile').val(result1.image);
				  
				}
			});
		})
	});
});



/****************************************************************************Cover image upload functionality ********************************************************/
$(document).ready(function(){  
	$('#coverpic').click(function(event){
		$('#UploadCoverImageModal').modal('show');
	});


	$cover_image_crop = $('#cover_image_demo').croppie({
		enableExif: true,
		viewport: {
		  width:1634,
		  height:316,
		  type:'square' //circle
		},
		boundary:{
		  width:1734,
		  height:416
		}
	}); 
	$('#cover_crop_image').on('change', function(){
		//alert("sad");
		$('.coverImage_section').css("display", "block");
		var reader = new FileReader();
		reader.onload = function (event) {
			$cover_image_crop.croppie('bind', {
				url: event.target.result
			}).then(function(){
				console.log('jQuery bind complete');
			});
		}
		reader.readAsDataURL(this.files[0]);
		//$('#uploadimageModal').modal('show');
	});

	$('.crop_cover_image').click(function(event){		
	//alert("dsf");
		//var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		var uploaded_cover_image_name = $('#cover_crop_image').val().replace(/.*(\/|\\)/, '');
		//console.log("upload image",uploaded_image_name);
		var logged_user_Id = $("input[name=u_id]").val();
		//console.log(user_Id);
		$cover_image_crop.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: site_url +'company/uploadCoverImageByAjax/',
				dataType: 'json',
				type: "POST",
				data:{"CoverImg": response, 'uploaded_cover_image_name': uploaded_cover_image_name, 'logged_user_id':logged_user_Id},
				success:function(data){	
				console.log("result",data);
				//alert(typeof(data));
				 // var result = jQuery.parseJSON(data);
				  var result_cover = JSON.parse(JSON.stringify(data));
				  //console.log("1",result_cover);
				  //console.log("resul",result1.image);
				 window.location.href = site_url +'company/edit/'+logged_user_Id;	
			  
				  //var a = $('#image_post').val(result1.image);
				  //console.log("aa",a);
				  $('#UploadCoverImageModal').modal('hide');
				 // $('#uploaded_image').html(data);
				  $('#uploaded_cover_image').html(result_cover.imageHtml);
				  $('#changed_user_cover').val(result_cover.image);
				  
				}
			});
		})
	});
});


function showBusinessCertificateSection(evt,option){
	var selectedOptionValue = $( 'input[name=business_certificate_type]:checked' ).val();
	if(selectedOptionValue == 'Udhyog Aadhar'){
		$('#udyogSection').removeClass('hideProofSection');
		$('#gstSection').addClass('hideProofSection');
		$('#incorporationSection').addClass('hideProofSection');
	}else if(selectedOptionValue == 'incorporation certificate'){
		$('#incorporationSection').removeClass('hideProofSection');
		$('#gstSection').addClass('hideProofSection');
		$('#udyogSection').addClass('hideProofSection');
	}else{
		$('#gstSection').removeClass('hideProofSection');
		$('#incorporationSection').addClass('hideProofSection');
		$('#udyogSection').addClass('hideProofSection');
	}
	
}

$('#submit_business_proof').click(function(e) { 
	var count = 0;
	$(".business_certificate").each(function() {
		if($(this).val() != ''){
			count++;
		}
		
	});
	
	if(count==0){
			$('.proof_alert_message').show();
			$('.proof_alert_message').html('Please upload any certificate for proof.');
			return false;
	}
});

	$(".take_bkup").click(function(){
			//var connection_activation_code = $(this).attr('data-code');
			$.ajax({
				type: "POST",
				url: site_url +'company/make_backup_db/',
				data: {},
				success: function (response) {
					if(response){
						console.log('response==>',response);
						window.location.href = site_url +'company/db_backup/';	
					}
				}
				
				
		});	
	});
	
	
	
		
function moveToSelected(element) {

  if (element == "next") {
    var selected = $(".selected").next();
  } else if (element == "prev") {
    var selected = $(".selected").prev();
  } else {
    var selected = element;
  }

  var next = $(selected).next();
  var prev = $(selected).prev();
  var prevSecond = $(prev).prev();
  var nextSecond = $(next).next();

  $(selected).removeClass().addClass("selected col-md-3 col-xs-12");

  $(prev).removeClass().addClass("prev col-md-3 col-xs-12");
  $(next).removeClass().addClass("next col-md-3 col-xs-12");

  $(nextSecond).removeClass().addClass("nextRightSecond col-md-3 col-xs-12");
  $(prevSecond).removeClass().addClass("prevLeftSecond col-md-3 col-xs-12");

  $(nextSecond).nextAll().removeClass().addClass('hideRight col-md-3 col-xs-12 ');
  $(prevSecond).prevAll().removeClass().addClass('hideLeft col-md-3 col-xs-12');

}

// Eventos teclado
$(document).keydown(function(e) {
    switch(e.which) {
        case 37: // left
        moveToSelected('prev');
        break;

        case 39: // right
        moveToSelected('next');
        break;

        default: return;
    }
    e.preventDefault();
});

$('#carousel div').click(function() {
  moveToSelected($(this));
});

$('#prev').click(function() {
  moveToSelected('prev');
});

$('#next').click(function() {
  moveToSelected('next');
});

$(document).ready(function(){
$('.center').slick({
  centerMode: true,
  centerPadding: '30px',
  slidesToShow: 4,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '20px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '15px',
        slidesToShow: 1
      }
    }
  ]
});
});


$(document).on("click",".add_group_company_details",function(){
		
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		var url = '';
		
		switch (tab) {
			case 'company_group_details':
				url = 'company/editgroup_company_details';
				break;	
			case 'company_group_view_details':
				url = 'company/viewgroup_company_details';
				break;					
		}
		$.ajax({
			type: "POST",
			url: site_url + url,
			data: {id:id}, 
			success: function(data){				
				if(data != '') {
					$("#add_group_company_detail_modal").modal({
					show:false,
					backdrop:'static'
				});
					if($('#add_group_company_detail_modal').length){
						$('#add_group_company_detail_modal').modal('toggle');
						$('#add_group_company_detail_modal .modal-body-content').html(data);	
					}else{
						$('#common_modal').modal('toggle');
						$('#common_modal .modal-body-content').html(data);
					}
					add_company_branch_andCompany_add();
					upload_company_branch_logo();
					crop_and_edit_image();
					add_bank_details();
					
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
								
					init_select2();			
					//close_modal_Script();	
					remove_comp_logo();
						
					
					
				}
			}
		}); 
			
	});
function remove_comp_logo(){
	$('.delete_logo2').click(function(){
		$('.loogo').attr('src', ''); 
		$('.old_image').val(''); 
		$('.mask').hide(); 
	});
	}
	function add_company_branch_andCompany_add(){
	
		var maxfields      = 10; //maximum input boxes allowed		
		var addressWrap    = $(".address_wrapper"); //Fields wrapper
		var add_address_btn = $(".add_company_address_button"); //Add button ID
		var addressLength = $('.addressLength').val();
		var z = 1;
		$(add_address_btn).click(function(e){ //on add input button click
		//init_select2();
		
		
			e.preventDefault();
			if(z < maxfields){ //max input box allowed
				z++; 
				var divlength = $('.input_address_wrap').length;				
				var addressClass = 'address'+divlength;				
				console.log('addressClass====>>>>ddddddd',addressClass);
				$(addressWrap).append('<div class="item form-group well2 input_address_wrap" id="chkIndex_'+divlength+'"><div class="col-md-12"><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Branch Name</label><div class="col-md-6 col-sm-12 col-xs-12"><input type="text" id="compny_branch_name" name="compny_branch_name[]" class="form-control col-md-1" placeholder="Company Branch Name" value=""></div></div><div class="col-md-6 col-sm-12 col-xs-12 vertical-border"><label class="col-md-3 col-sm-3 col-xs-12">Company Address</label><div class="col-md-6 col-sm-12 col-xs-12 form-group"><textarea id="address" required="required" name="address[]" class="form-control col-md-7 col-xs-12" placeholder="Address"></textarea></div></div><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="item form-group col-md-3 col-sm-3 col-xs-12"><label class="control-label col-md-4 col-sm-4 col-xs-4" for="billing_country">Permanent Country</label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible country_id" name="country[]" data-id="country" data-key="country_id" data-fieldname="country_name" width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getState(event,this)"><option value="">Select Option</option></select></div></div><div class="item form-group col-md-3 col-sm-3 col-xs-12"><label class="control-label col-md-4 col-sm-4 col-xs-4" for="permanent_state">Permanent State/Province<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible '+addressClass+' state_id" name="state[]"  width="100%" tabindex="-1" aria-hidden="true" required="required" onchange="getCity(event,this)"><option value="">Select Option</option></select></div></div><div class="item form-group col-md-2 col-sm-3 col-xs-12"><label class="control-label col-md-4 col-sm-4 col-xs-4" for="city">Permanent City<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><select class="itemName form-control selectAjaxOption select2 select2-hidden-accessible '+addressClass+' city_id" name="city[]"  width="100%" tabindex="-1" aria-hidden="true" required="required"><option value="">Select Option</option></select></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">Postal/Zipcode<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input type="text" id="postal_zipcode" name="postal_zipcode[]" class="form-control col-md-1" placeholder="Postal/Zipcode" value=""></div></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label style="border-right: 1px solid #c1c1c1" class="form-groupcol-md-12 col-sm-4 col-xs-4" for="city">Company GSTIN<span class="required">*</span></label><div class="col-md-12 col-sm-12 col-xs-12 form-group"><input style="border-right: 1px solid #c1c1c1" type="text" id="company_gstin" name="company_gstin[]" class="form-control col-md-1" placeholder="Company GSTIN" value=""></div></div><button class="btn btn-danger remove_address_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
				
				
			}
			init_select2();	
		});
		
		$(addressWrap).on("click",".remove_address_field", function(e){ //user click on remove text
			//e.preventDefault(); $(this).parent('div').parent('div').parent('div').remove(); z--;
			e.preventDefault(); $(this).parent('div').parent('div').remove(); z--;
		})
}

function upload_company_branch_logo(){ 
	$('#logoSite22').click(function(event){
		$('#imageModalUpload22').modal('show');
	});
//crop_and_edit_image();

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
	$('#logo').on('change', function(){
	
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

	
}

function crop_and_edit_image(){
	$('#crop_image22ddd').click(function(event){
		
		//var uploaded_image_name = $('input[type=file]').val().replace(/.*(\/|\\)/, '');
		
		var uploaded_image_name = $('#logo').val().replace(/.*(\/|\\)/, '');
		//alert(uploaded_image_name);
		//console.log("upload image",uploaded_image_name);
		var tbl_id = $("input[name=id]").val();
		$image_crop.croppie('result', {
		  type: 'canvas',
		  size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: site_url +'company/uploadImage_company_groupByAjax/',
				dataType: 'json',
				type: "POST",
				data:{"image": response, 'uploaded_image_name': uploaded_image_name, 'id':tbl_id},
				success:function(data){	
				//console.log("result",data);
				//alert(typeof(data));
				 // var result = jQuery.parseJSON(data);
				  var result = JSON.stringify(data);
				  //console.log("resul",result);
				  window.location.href = site_url +'company/group_cmpny/'+tbl_id;	
			  
				  $('#imageModalUpload22').modal('hide');
				 // $('#uploaded_image').html(data);
				  $('#uploaded_image').html(result.imageHtml);
				  $('#changed_user_profile').val(result.image);
				   
				}
			});
		})
	});
}


$(document).ready(function(e) {   
	$(document).on("click",".companyTab",function(ev){
		ev.preventDefault();
		var id = $(this).attr('id');
		var tab = $(this).attr('data-id');
		//console.log(tab);
		var url = '';
		switch (tab) {
			/*case 'processEdit':
				url = 'production/editprocess';
				break;	*/
			case 'companydepartments_edit':
				url = 'company/edit_department';
				break;	
		}
console.log("fff",tab);				
		$.ajax({
			type: "POST",
			url: site_url+ url,
			data: {id:id}, 
			success: function(data){
				if(data != '') {
					$("#company_depart_modal").modal({
                        show:false,
                        backdrop:'static'
                    });					
					$('#company_depart_modal').modal('show');
					$('#company_depart_modal .modal-body-content').html(data);
					
					
					if($('#btnPrint').length!==0){
						document.getElementById("btnPrint").onclick = function () {
							printElement(document.getElementById("printView"));
						}
					}
					

					if(tab == 'companydepartments_edit'){
						addMoreDepartments();
						get_company_location();
						get_company_location();
						// get_company_unit();
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
				init_select2();	
					init_select21();					
					init_select221();					
					for_add_multiple_tags_for_worker();
					Print_data_new();
					//Print_data();
					
			}
		}
		}); 
	});
	
	
});

/* For More Add Department */ 
function addMoreDepartments(){
		var maxDepartment  = 10; //maximum input boxes allowed
					var departmentDiv         = $(".departmentDiv"); //Fields wrapper
					var add_department      = $(".addMoreDepartment"); //Add button ID
					var y = 1; //initlal text box count
					$(add_department).click(function(e){ //on add input button click
						e.preventDefault();
						if(y < maxDepartment){ //max input box allowed
							y++;
							$(departmentDiv).append('<div class="well" id="chkIndex_'+y+'"><div class="col-md-12 col-sm-6 col-xs-12 form-group"><input type="text" id="departmentName" name="name[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Dapertment name" value=""></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
						}
					});
					$(departmentDiv).on("click",".remve_field", function(e){ //user click on remove text
						e.preventDefault(); $(this).parent('div').remove(); y--;
					});
	}


function get_company_location(evt,t){
		$('.get_location').select2({
			allowClear: true,
			placeholder: 'Select And Begin Typing',
			  closeOnSelect: true,
			ajax: {
				url: site_url+'/company/getcompany_unit',
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


/***********datatable in Company setting****************/
$(document).ready(function ()
        {
            var table = $('#example').DataTable();
        });
        
        
        
function add_bank_details() {
	var maximum = 10; //maximum input boxes allowed
	var wrap_material = $(".bank_wrraper"); //Fields wrapper
	var button_add = $(".add_bank_address_button"); //Add button ID
	var x = 1; //initlal text box count	
	$(button_add).click(function (e) {
		//on add input button click
		e.preventDefault();
		if (x < maximum) { //max input box allowed
			x++;
			//var dataWhere = $("#material").attr("data-where");
			$(wrap_material).append('<div class="well scend-tr mobile-view" id="chkIndex_' + z + '"><div class="col-md-4 col-sm-12 col-xs-12 item form-group"><label class="col-md-12" terial Name>Account Name<span class="required">*</span></label><input type="text" id="account_no" name="account_name[]" class="form-control col-md-7 col-xs-12" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"><label class="col-md-12" terial Name>Account Number<span class="required">*</span></label><input type="text" id="account_no" name="account_no[]" class="form-control col-md-7 col-xs-12" value=""></div><div class="col-md-2 col-sm-12 col-xs-12 item form-group"><label class="col-md-12">Bank IFSC Code</label><input type="text" id="account_ifsc_code" name="account_ifsc_code[]" class="form-control col-md-7 col-xs-12" value=""></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label class="col-md-12" >Bank Name</label><input type="text" id="bank_name" value="" name="bank_name[]" class="form-control col-md-7 col-xs-12"/> </div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><label class="col-md-12">Bank Branch</label><input type="text" id="branch" value="" name="branch[]" class="form-control col-md-7 col-xs-12"/></div><button class="btn btn-danger remove_btn" type="button"> <i class="fa fa-minus"></i></button></div>');
			var logged_user = $('#loggedUser').val();
			init_select2();
		}
		//getMaterials(x);
	});
	$(wrap_material).on("click", ".remove_btn", function (e) { //user click on remove text
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	});
}

$(document).ready(function (){
    var table = $('#example').DataTable();
    
    var activitytable = $('#alogs').dataTable( {
      "pageLength": 50
    });
    		
    var visitingtable = $('#vlogs').dataTable( {
      "pageLength": 50
    });
});