//submit_handler('loginCompany');
//submit_handler('companyRegister');
//submit_handler('forgot_password');
/*$(document).ready(function(e) {   
	$(document).on("click",".add_departments",function(){
		var id = $(this).attr('id');
		$.ajax({
			type: "POST",
			url: base_url+'departments/edit',
			data: {id:id}, 
			success: function(data){
				if(data != '') {					  
					$('#add_department').modal('toggle');
					$('#add_department .modal_body_content').html(data);	
					/* form validation 
					$('.department-form').validate({
						errorElement: 'span', 
						errorClass: 'error', 
						focusInvalid: false, 
						ignore: "",
						rules: {
							name: {
								minlength: 2,
								required: true
							},
							email: {
								required: false,
								email: true
							},						
						},
						invalidHandler: function (event, validator) {
							var errors = validator.numberOfInvalids();
							if (errors) {
								  $("html, body").animate({ scrollTop: 0 }, "fast");
							}
						},
						 /* render error placement for each input type 
						errorPlacement: function (error, element) {
							var icon = $(element).parent('.input-with-icon').children('i');
							var parent = $(element).parent('.input-with-icon');
							icon.removeClass('fa fa-check').addClass('fa fa-exclamation');  
							parent.removeClass('success-control').addClass('error-control');  
							$('<span class="error"></span>').insertAfter(element).append(error);
						},
						/* hightlight error inputs 
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
					});				 
			    }
			}
		}); 
	});
});*/


/* Function to check the validation of a company's GSTIN No. */
function fnValidateGSTIN(Obj) { 
	if (Obj.value != "") {
		ObjVal = Obj.value;
		//var gstinPat = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9]{1}?$/;
		var gstinPat = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9A-Z]{1}?$/;
		if (ObjVal.search(gstinPat) == -1) {
			 console.log("Invalid GSTIN number");
			 $('.gstin').closest('.item').addClass('bad');
		     //Obj.focus();
			$('.gstin').closest('.item').append("<div class='alert'>Invalid GSTIN number</div>");
			$(".signUpBtn").attr( "disabled", "disabled" );
			return false;
		}
	  else{
			$(".signUpBtn").removeAttr("disabled");
		    console.log("Correct GSTIN No");
		  }
	}
}

/* Function to check the validation of a company's GSTIN No. */
function fnValidatePassword(Obj) { 
	console.log('Obj===>>>',Obj.value);
	$('.alert').hide();
	if (Obj.value != "") {
		ObjVal = Obj.value;	
		var passwordPat = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
		if(ObjVal.match(passwordPat)) { 			
			if($('#password').val() != $('#password23').val()){
				$('#password23').closest('.item').addClass('bad');			
				$('#password23').closest('.item').append("<div class='alert'>Password don't match</div>");
				$(".signUpBtn").attr( "disabled", "disabled" );
				return false;
			}else{
				$(".signUpBtn").removeAttr("disabled");
			}
		}
		else{ 
			$('#password').closest('.item').addClass('bad');			
			$('#password').closest('.item').append("<div class='alert'>7-15 char & contain at least 1 numeric & a special character</div>");
			$(".signUpBtn").attr( "disabled", "disabled" );
			return false;
			
		}
		
	}
}





