/********************      Functionality to store the parent module id       *********************/
var moduleId = getStoredValue('openModuleId');
if(moduleId == undefined){
	moduleId = 113;
}
//storeValue('openModuleId', 113);
function storeValue(key, value) {
    if (localStorage) {
        localStorage.setItem(key, value);
    } else {
        $.cookies.set(key, value);
    }
}
function getStoredValue(key) {
    if (localStorage) {
        return localStorage.getItem(key);
    } else {
        return $.cookies.get(key);
    }
}



$(document).on("ready",function(){
	init_select2();
	//init_select2_for_join();	
	$(document).on("click",".notification_icon",function(){		
		var currenElement = $(this);
		if(currenElement.find("span").length > 0){
			$.ajax({
				type: "POST",
				url: site_url+"Ajaxrequest/readNotifications",
				data: {}, 
				success: function(data){
				   if(data) {	   
					 currenElement.find("span").remove();				 
				   }
				}
			}); 
		}
	});
});

/* for select 2 ajax search */
function init_select2() {
	$('.selectAjaxOption').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: $(this).attr('placeholder'),
		//multiple:true,
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
         }//,language: {
                    // noResults: function() {
                        // return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Open Model</a>";
                      // }
                    // },escapeMarkup: function (markup) {
                         // return markup;
                    // }
    });
	
}

$(".tagsAjaxOption").select2({
    tags: true,
    tokenSeparators: [',', ' '],
	ajax: {
		url: site_url+'Ajaxrequest/ajaxTagSearch',
		dataType: 'json',
		delay: 250,		  
	processResults: function (data) {
		return {
		  results: data
		};
	},
		cache: true
	}
})

$('.selectOption').select2();


//Function for get data for two table for account group and parent Group
// function init_select2_for_join() {
	// $('.selectAjaxOption_join').select2({
		// allowClear: true,
        // placeholder: 'Select And Begin Typing',
		
        // ajax: {
			// url: site_url+'Ajaxrequest/ajaxSelect2search_for_join',
			// dataType: 'json',
			// delay: 250,
			// data: function (params) {
            // return {
                // q: params.term,
                // table: $(this).attr("data-id"),
                // field: $(this).attr("data-key"),
                // fieldname: $(this).attr("data-fieldname"),
                // fieldwhere: $(this).attr("data-where")
            // };
        // },		  
        // processResults: function (data) {
            // return {
              // results: data
            // };
       // },
			//cache: true,
        // }//,language: {
                    // noResults: function() {
                        // return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Open Model</a>";
                      // }
                    // },escapeMarkup: function (markup) {
                         // return markup;
                    // }
   // });
//}




//Function for get data for two table for account group and parent Group

	// toggle small or large menu 
		$MENU_TOGGLE.on('click', function() {
			console.log('clicked - menu toggle');									
			if ($BODY.hasClass('nav-md')) {
				$SIDEBAR_MENU.find('li.active ul').hide();
				$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
			} else {
				$SIDEBAR_MENU.find('li.active-sm ul').show();
				$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
			}
			$BODY.toggleClass('nav-md nav-sm');			
			$('.dataTable').each ( function () { $(this).dataTable().fnDraw(); });
		});

/*  *********** menu app setting display function       *************  */


$(document).on("ready",function(){
	menues_header_listing();
	$('.module_menu').each(function() {		
		$(this).click(function() {
			var moduleName = $(this).find('span.module_name').text();
			console.log('yyyy===>>>',moduleName);
			moduleId = $(this).attr('id');
			menues_header_listing(moduleName);
			mode = $(this).attr('id');
			storeValue('openModuleId', mode);
		}); 		
	}); 		
});



function menues_header_listing(moduleName = ''){	
	$.ajax({
		type: "POST",					
		url: site_url+'Ajaxrequest/app_menus_listing',
		data: {'parent_id':moduleId}, 
		success: function(data){
		   if(data) {
			 $('.menu_section').html('');
			 $('.menu_section').html(data);
			
			 menuClick(moduleName);
		   }
		}
	}); 		
}


function menuClick(moduleName = ''){	
	console.log('menu click===>>>>');
	console.log('moduleName===>>>>',moduleName);
	//alert(moduleId);
	// TODO: This is some kind of easy fix, maybe we can improve this
	var setContentHeight = function () {
	// reset height
	$RIGHT_COL.css('min-height', $(window).height());							
	var bodyHeight = $BODY.outerHeight(),
		footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
		leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
		contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;
	// normalize content
	contentHeight -= $NAV_MENU.height() + footerHeight;
	$RIGHT_COL.css('min-height', contentHeight);
	};
	
	if(moduleName !=''){
		moduleName = moduleName.toLowerCase();
		if( moduleName == 'hrm'  ){
			console.log('in 1st if');
			window.location.href = site_url+moduleName;
		}else if(moduleName == 'company'){
			console.log('in  2nd if');
			window.location.href = site_url+moduleName+'/view';
		}else{
			console.log('in else');
			window.location.href = site_url+moduleName+'/dashboard';
		}
	}
	//console.log('SIDEBAR_MENU===>>>>',$SIDEBAR_MENU);
	$SIDEBAR_MENU.find('a').on('click', function(ev) {	
		console.log('SIDEBAR_MENU===>>>>',$SIDEBAR_MENU);
		if($(this).attr('data-href') != undefined){
			window.location.href = $(this).attr('data-href');
			//menues_header_listing(moduleId);
		}
		//window.location.href = $(this).attr('data-href');
		//menues_header_listing(moduleId);
		console.log('clicked - sidebar_menu');
		var $li = $(this).parent();		
		console.log('$lillllll==>>',$li);
		if ($li.is('.active')) {
			$li.removeClass('active active-sm');
			$('ul:first', $li).slideUp(function() {
				setContentHeight();
			});
		} else {
			$li.parent().find( "li" ).removeClass( "active active-sm" );
			$li.parent().find( "li ul" ).slideUp();
			// prevent closing menu if we are on child menu
			if (!$li.parent().is('.child_menu')) {
				$SIDEBAR_MENU.find('li').removeClass('active active-sm');
				$SIDEBAR_MENU.find('li ul').slideUp();
			}else{
				if ( $BODY.is( ".nav-sm" ) ){
					$li.parent().find( "li" ).removeClass( "active active-sm" );
					$li.parent().find( "li ul" ).slideUp();
				}
			}
			$li.addClass('active');
			$('ul:first', $li).slideDown(function() {
				setContentHeight();
			});
		}
	});

		// toggle small or large menu 
		$MENU_TOGGLE.on('click', function() {
				console.log('clicked - menu toggle');									
				if ($BODY.hasClass('nav-md')) {
					$SIDEBAR_MENU.find('li.active ul').hide();
					$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
				} else {
					$SIDEBAR_MENU.find('li.active-sm ul').show();
					$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
				}
			$BODY.toggleClass('nav-md nav-sm');
			setContentHeight();
			$('.dataTable').each ( function () { $(this).dataTable().fnDraw(); });
		});

		// check active menu
		$SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');
		// $SIDEBAR_MENU.find('a').filter(function () {
			// return this.href == CURRENT_URL;
		// }).parent('li').addClass('current-page').parents('ul').slideDown(function() {
			// setContentHeight();
		// }).parent().addClass('active');

		// recompute content when resizing
		$(window).smartresize(function(){  
			setContentHeight();
		});
		setContentHeight();

		// fixed sidebar
		if ($.fn.mCustomScrollbar) {
			$('.menu_fixed').mCustomScrollbar({
				autoHideScrollbar: true,
				theme: 'minimal',
				mouseWheel:{ preventDefault: true }
			});
		}
}

/* for select 2 ajax search */
function init_select2so() {
	$('.selectAjaxOption24').select2({
		//dropdownCssClass: 'custom-dropdown'
		allowClear: true,
        placeholder: 'Select And Begin Typing',
		//multiple:true,
        ajax: {
			url: site_url+'Ajaxrequest/ajaxSelect2searchso',
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
            console.log('data=>>>>>>>>',processResults);
        },
			cache: true,
         }//,language: {
                    // noResults: function() {
                        // return "<a  data-toggle='modal' data-target='#myModal' href='javascript:void();'>Open Model</a>";
                      // }
                    // },escapeMarkup: function (markup) {
                         // return markup;
                    // }
    });
}