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
    csrfToken : function(showLoader) {
        return $('meta[name="csrf-token"]').attr('content');
    },
    deleteItem: function (selector) {
        $(document).on("click", selector, function (e) {
            e.preventDefault();
            let deleteUrl = $(this).attr("href");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                confirmButtonClass: "btn btn-primary",
                cancelButtonClass: "btn btn-danger ml-1",
                buttonsStyling: !1,
            }).then((result) => {
                if (result.isConfirmed) {
                    airpos_app
                        .ajaxRequest(
                            deleteUrl,
                            { _token: airpos_app.csrfToken() },
                            "DELETE"
                        )
                        .then((response) => {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: response.data.message,
                                confirmButtonClass: "btn btn-success",
                            }).then(() => {
                                if (response.data.status == true) {
                                    $('.yajra-datatable').DataTable().ajax.reload();
                                }
                            });
                        })
                        .catch((error) => {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "Something went wrong. Please try again.",
                            });
                        });
                }
            });
        });
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
            errorClass: "border-danger",
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
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

		$('#resetPasswordForm').validate({
            errorClass: "border-danger",
            errorElement: "div", 
            errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              error.insertAfter(element);
            },
			rules: {
				password: {
					required: true,
					minlength: 6,
					maxlength: 20,
				},
				confirm_password: {
					required: true,
					minlength: 6,
					maxlength: 20,
                    equalTo: '#password',
				}                
			},
			messages: {
				password: {
					required: "Please enter valid password."
				},
				confirm_password: {
					required: "Please enter valid confirm password."
				}
			},
			submitHandler: function (form) {
                toggleLoader(true)

                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    if(response.data.status == true){
                        window.location.href = response.data.data.redirect;
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

		$('#updateAvatarForm').validate({
            errorClass: "border-danger",
            errorElement: "div", 
            errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              $('#avatarErrorContainer').html(error);
            },
			rules: {
				avatar: {
					required: true,
				}
			},
			messages: {
				avatar: {
					required: "Please add valid avatar."
				}
			},
			submitHandler: function (form) {
                toggleLoader(true)

                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    if(response.data.status == true){
                        window.location.href = response.data.data.redirect;
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

		$('#updateProfileForm').validate({
            errorClass: "border-danger",
            errorElement: "div", 
            errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              error.insertAfter(element);
            },
			rules: {
				name: {
					required: true,
				},
				last_name: {
					required: true,
				},
				email: {
					required: true,
                    email: true,
				},
				phone: {
					required: true,
				},
				confirm_password: {
                    required: function() {
                        return $('#password').val().trim() !== "";
                    },
                    equalTo: '#password',
				},
			},
			messages: {
				name: {
					required: "Please add valid name."
				},
				last_name: {
					required: "Please add valid last name."
				},
				email: {
					required: "Please add valid email."
				},
				phone: {
					required: "Please add valid phone."
				},
				confirm_password: {
					required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
				},
			},
			submitHandler: function (form) {
                toggleLoader(true)

                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    if(response.data.status == true){
                        window.location.href = response.data.data.redirect;
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

		$('#saveAccountForm').validate({
            errorClass: "border-danger",
            errorElement: "div", 
            errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              error.insertAfter(element);
            },
			rules: {
				name: {
					required: true,
				},
				number: {
					required: true,
				},
				type: {
					required: true,
				},
				limit: {
					required: true,
				}
			},
			messages: {
				name: {
					required: "Please add valid name."
				},
				number: {
					required: "Please add valid Account Number."
				},
				type: {
					required: "Select Valid type."
				},
				limit: {
					required: "Please add valid limit."
				},
			},
			submitHandler: function (form) {
                toggleLoader(true)

                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    if(response.data.status == true){
                        window.location.href = response.data.data.redirect;
                    }
                }).catch(error => {
                    toggleLoader(false)
                    airpos_app.notifyWithToastr('error', error.response.data.message, 'Something went wrong.')
                });
			}
		});

		$('#saveCategoryForm').validate({
            errorClass: "border-danger",
            errorElement: "div", 
            errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              error.insertAfter(element);
            },
			rules: {
				category_name: {
					required: true,
				},
			},
			messages: {
				category_name: {
					required: "Please add valid category name."
				},
			},
			submitHandler: function (form) {
                toggleLoader(true)

                airpos_app.ajaxRequest(form.action,form,form.method).then(response => {
                    toggleLoader(false)
                    if(response.data.status == true){
                        window.location.href = response.data.data.redirect;
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
        $('#submit_form').hide();
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
