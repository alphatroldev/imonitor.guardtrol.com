(function($) {
	'use strict';
	// No White Space
	$.validator.addMethod("noSpace", function(value, element) {
		if( $(element).attr('required') ) {
			return value.search(/^(?! *$)[^]+$/) == 0;
		}
		return true;
	}, 'Please fill this empty field.');
	$.validator.addClassRules({
	    'form-control': {noSpace: true}
	});

    $("form[name='owner_staff_login']").validate({
        rules: {
            email: {required: true,email:true},
            password: "required"
        },
        messages: {
            email: "Enter a valid email address",
            password: "Enter a valid company name"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "login-company", type: "POST", data: $form.serialize(),
                success: function (data) {
                    console.log("ytjyuy");
                    if (data.status === 1) {
                        document.getElementById('owner_staff_login').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.replace(data.location),500);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {console.log("error",errData)},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='create_company']").validate({
        rules: {
            c_name: "required",
            c_email: {required: true, email: true},
            c_address: "required",
            c_phone: {required: true, digits: true},
            c_reg_no: "required",
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            c_email: "Enter a valid email address",
            c_name: "Enter  Company Name",
            c_address: "Enter Company Address",
            c_phone: "Enter valid Phone Number",
            c_reg_no: "required",
            password: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            confirm_password: {required: "Required", equalTo: "Password not matched"}
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var _form = $(form)[0];
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "create-company-account-by-self", type: "POST",
                dataType: "JSON",
                data: new FormData(_form),
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_company').reset();
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

}).apply(this, [jQuery]);

function sendSuccessResponse(head,body) {
	$("#response-alert").html('' +
		'<div class="alert alert-success alert-dismissible" role="alert">'+
		'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
		'<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
	);
}

function sendErrorResponse(head,body) {
	$("#response-alert").html('' +
		'<div class="alert alert-danger alert-dismissible" role="alert">'+
		'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
		'<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
	);
}

function sendSuccessResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-success alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
    );
    // new PNotify({title: head+'!', text: body, type: 'success'});
}

function sendErrorResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-danger alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
    );
    // new PNotify({title: head+'!', text: body, type: 'error'});
}