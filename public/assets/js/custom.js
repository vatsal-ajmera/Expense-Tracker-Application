$(function () {
	airpos_validation.init();
})

airpos_loader = {
	start: function (element) {
		element.attr('disabled', 'disabled').addClass('spinner-text').append('<div class="spinner"><span class="double-bounce1"></span><span class="double-bounce2"></span></div>');
	},
	/* stop: function(element){
		element.removeAttr('disabled').removeClass('spinner-text').children('.spinner').remove();
	},
	preStart: function(){
		$(".preloadertwo").show();
	},
	preStop: function(element){
		$(".preloadertwo").hide();
	} */
};
airpos_app = {
    baseURL: function () {
        return $("base").attr("href");
    },
    getToken: function () {
        return $('meta[name="csrf-token"]').attr("content");
    },
    ajaxRequest: function (reqURL, reqData, reqMethod = "", reqDataType = "") {
        return axios({
            baseURL: airpos_app.baseURL(),
            url: reqURL,
            method: reqMethod != "" ? reqMethod : "post",
            headers: {
                "Content-Type":
                    reqDataType != ""
                        ? reqDataType
                        : "application/x-www-form-urlencoded",
            },
            data: reqData,
            async: false,
        });
    },
    notifyWithToastr: function (type, message, headerMessage ) {
        toastr[type](
            message,
            headerMessage,
            { closeButton: !0, tapToDismiss: !1 }
        );
    },
    toggleLoader : function(showLoader) {
        if (showLoader == true) {
            $('#loaderBtn').show();
            $('#login').hide();
        } else {
            $('#loaderBtn').hide();
            $('#login').show();
        }
    },
    readURL: function (input, image) {
        var fileInput = input;
        var filePath = fileInput.val();
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.svg)$/i;
        if (!allowedExtensions.exec(filePath)) {
            airpos_app.notifyWithToastr(
                "Only png and jpg file is allowed.",
                "error"
            );
            fileInput.val("");
        } else {
            if (input[0].files && input[0].files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    image.attr("src", e.target.result);
                };
                reader.readAsDataURL(input[0].files[0]);
            }
        }
    },
};

airpos_validation = {
	init: function () {
		$('#loginFormAdmin').validate({
            errorClass: "border-danger",
            errorElement: "div",
            errorPlacement: function(error, element) {
                var errorElement = document.getElementById(`error-${element.attr('name')}`)
                errorElement.style.display = 'block';
                errorElement.innerHTML = error.html(); 
            },
            unhighlight: function(element, errorClass, validClass) {
                var errorElement = document.getElementById(`error-${element.name}`)
                errorElement.innerHTML = '';
            },
			rules: {
				email: {
					required: true
				},
				password: {
					required: true,
					minlength: 6,
					maxlength: 20,
				}
			},
			messages: {
				email: {
					required: "Please enter email address."
				},
				password: {
					required: "Please enter password.",
					minlength: "Please enter minimum 6 characters."
				}
			},
			submitHandler: function (form) {
                toggleLoader(true)
				
                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    console.log(response.data)
                    if(response.data.status == true){
                        airpos_app.notifyWithToastr('success', response.data.message, 'Invalid credentials')
                        window.location.href = response.data.data.redirect;
                    }else{
                        airpos_app.notifyWithToastr('error', response.data.message, 'Invalid credentials')
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

		$('#otpVerificationForm').validate({
            errorClass: "is-invalid", 
            validClass: "is-valid", 
            errorElement: "div", 
            errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              error.insertAfter(element);
            },
			rules: {
				otp: {
					required: true
				},
			},
			messages: {
				otp: {
					required: "Please enter valid OTP."
				}
			},
			submitHandler: function (form) {
                toggleLoader(true)

                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    if(response.data.status == true){
                        window.location.href = response.data.data.redirect;
                    }else{
                        airpos_app.notifyWithToastr('error', response.data.message, 'Invalid OTP')
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

		$('#forgotPasswordForm').validate({
            errorClass: "is-invalid", 
            validClass: "is-valid", 
            errorElement: "div", 
            errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              error.insertAfter(element);
            },
			rules: {
				email: {
					required: true
				},
			},
			messages: {
				email: {
					required: "Please enter valid email address."
				}
			},
			submitHandler: function (form) {
                toggleLoader(true)

                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    if(response.data.status == true){
                        window.location.href = response.data.data.redirect;
                    }else{
                        airpos_app.notifyWithToastr('error', response.data.message, 'Invalid OTP')
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

	}
};

function toggleLoader(showLoader) {
    if (showLoader == true) {
        $('#loaderBtn').show();
        $('#login').hide();
    } else {
        $('#loaderBtn').hide();
        $('#login').show();
    }
}

$(document).on("change", ".change-language", function () {
	$(this).next('label.error').remove();
});

$(document).on('keydown', '.numbersOnly', function (e) {
	if ($.inArray(e.keyCode, [8, 9, 27, 13, 189, 110]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
		return;
	}
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});
$(document).on('keydown input', '.charOnly', function (e) {
	if ($.inArray(e.keyCode, [8, 9, 13, 16, 17, 18, 19, 20, 27, 33, 34, 35, 36, 37, 38, 40, 45, 46, 32]) !== -1 || (e.ctrlKey === true || e.metaKey === true) || (e.keyCode >= 65 && e.keyCode < 93))
		return;
	else
		e.preventDefault();
});

$(document).on('keyup click', 'input', function () {
	$(this).next('label.error').hide();
});

$(document).on("click", ".select2-container", function () {
	$(this).next('label.error').remove();
});
