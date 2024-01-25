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

    $("form[name='support_login']").validate({
        rules: {
            email: {required: true,email:true},
            password: "required"
        },
        messages: {
            email: "Enter a valid email address",
            password: "Enter you password"
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
                url: "login-support", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('support_login').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.replace(data.location),1000);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_support_profile']").validate({
        rules: {
            sup_name: "required",
            sup_email: {required: true,email:true},
            sup_type: "required",
        },
        messages: {
            sup_name: "Name is required",
            sup_email: "Enter a valid email address",
            sup_type: "Type is required"
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
                url: "update-support-profile", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
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

    $("form[name='update_support_password']").validate({
        rules: {
            old_password: "required",
            password: {required: true, minlength: 6},
            con_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            old_password: "Enter current password",
            password: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            con_password: {required: "Required", equalTo: "Password not matched"}
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
                url: "update-support-profile-password", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse2('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='profile']").validate({
        rules: {
            support_id: "required",
            fullname: "required",
            email: {required: true,email:true},
            sup_type: "required",
            sup_status: "required",
        },
        messages: {
            support_id: "",
            fullname: "Name is required",
            email: "Enter a valid email address",
            sup_type: "Type is required",
            sup_status: "Status is required"
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
                url: "update-support", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
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

    $("form[name='profile_password']").validate({
        rules: {
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
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
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "update-support-password", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse2('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='create_support']").validate({
        rules: {
            fullname: "required",
            email: "required",
            sup_type: "required",
            sup_status: "required",
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            fullname: "Enter Full Name",
            email: "Enter Email Address",
            sup_type: "Select support type",
            sup_status: "Select status",
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
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "create-support", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_support').reset();
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

    $(document).on("click", "#supportStatusBtn", function (e) {
        var s_id = $(this).data("s_id");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to update support status?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "update-support-status", type: "POST",
                        data: JSON.stringify({s_id:s_id,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.replace(data.location); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#supportDeleteBtn", function (e) {
        e.preventDefault();
        var s_id = $(this).data("s_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this support profile?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "update-support-status", type: "POST",
                        data: JSON.stringify({s_id: s_id, action_code: 102}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.replace(data.location);
                                }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData) {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
            }
        });
    });

    $(document).on("click", "#supCompanyDashboardLogin", function (e) {
        e.preventDefault();
        var c_email = $(this).data("c_email");
        var submitButton = $(this);
        submitButton.attr('disabled', true);
        $.ajax({
            url: "login-sup-company-account", type: "POST", data: {c_email: c_email},
            success: function (data) {
                if (data.status === 1) {
                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                    window.open(data.location,'_blank','height=870,width=920');
                } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
            },
            error: function (errData) {},
            complete: function () { submitButton.attr('disabled', false); }
        });
    });

    $("form[name='create_company']").validate({
        rules: {
            c_name: "required",
            c_email: {required: true, email: true},
            c_address: "required",
            c_phone: {required: true, digits: true},
            c_descr: "required",
            c_guard_str: "required",
            c_op_state:"required",
            c_op_number: "required",
            c_reg_no: "required",
            c_tax_id: "required",
            c_op_license:"required",
            c_logo:"required",
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            c_name: "Enter a valid email address",
            c_email: "Enter  Company Name",
            c_address: "Enter Company Address",
            c_phone: "Enter valid Phone Number",
            c_descr: "required",
            c_guard_str: "required",
            c_op_state:"required",
            c_op_number:"required",
            c_reg_no: "required",
            c_tax_id: "required",
            c_op_license:"required",
            c_logo:"required",
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
            console.log($form.serialize());

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "create-company", type: "POST",
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
                            buttons: {ok: function () { return true; }}
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

    $("form[name='update_company_profile_by_id']").validate({
        rules: {
            company_id: "required",
            c_name: "required",
            c_email: {required: true,email:true},
            c_address: "required",
            c_phone: {required: true,digits:true},
            c_description: "required",
            c_guard_str: "required",
            c_op_state: "required",
            c_op_number:"required",
            c_reg_no: "required",
            c_tax_id: "required"
        },
        messages: {
            company_id: "",
            c_name: "Name is required",
            c_email: "Enter a valid email address",
            c_address: "Address is required",
            c_phone: "Phone number is required",
            c_description: "required",
            c_guard_str: "required",
            c_op_state:"required",
            c_op_number:"required",
            c_reg_no: "required",
            c_tax_id: "required",
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
                url: "update-com-pro-by-id", type: "POST",
                dataType: "JSON",
                data: new FormData(_form),
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status === 1) {
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

    $('#c_logo_update').change(function(){
        var _form = $("#logo_upload")[0];

        $.ajax({
            url: "update-com-pro-by-id", type: "POST",
            dataType: "JSON",
            data: new FormData(_form),
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status === 1) {
                    sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                } else {
                    sendErrorResponse2('Error', data.message);
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                }
            },
            error: function (errData) {},
            complete: function () {
                // $submitButton.val( submitButtonText ).attr('disabled', false);
            }
        });
    });

    $('#c_license_update').change(function(){
        var _form = $("#license_upload")[0];
        $.ajax({
            url: "update-com-pro-by-id", type: "POST",
            dataType: "JSON",
            data: new FormData(_form),
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status === 1) {
                    sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                } else {
                    sendErrorResponse2('Error', data.message);
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                }
            },
            error: function (errData) {},
            complete: function () {
                // $submitButton.val( submitButtonText ).attr('disabled', false);
            }
        });
    });

    $("form[name='update_company_profile']").validate({
        rules: {
            company_id: "required",
            c_name: "required",
            c_email: {required: true,email:true},
            c_address: "required",
            c_phone: {required: true,digits:true},
        },
        messages: {
            company_id: "",
            c_name: "Name is required",
            c_email: "Enter a valid email address",
            c_address: "Address is required",
            c_phone: "Phone number is required"
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
                url: "update-com-pro-by-id", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
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

    $("form[name='update_company_password']").validate({
        rules: {
            company_sno: "required",
            company_email: "required",
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            company_sno: "",
            company_email: "",
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
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "update-com-pwd-by-id", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse2('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });
    
    $("form[name='upload_new_app_version']").validate({
        rules: {
            apk_file_name: "required",
            apk_version: {required: true,number:true},
            apk_file: "required",
        },
        messages: {
            apk_file_name: "File name is required",
            apk_version: "Enter a valid APK version (digits)",
            apk_file: "APK file is required",
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
            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait (Uploading)...' ).attr('disabled', true);

            var _form = $("#upload_new_app_version")[0];

           $('#progressModal').modal('show');
            $.ajax({
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $(".progress-bar").css("width", percentComplete + '%');
                            $(".progress-bar").text(parseInt(percentComplete) + '%');
                        }
                    }, false);
                    return xhr;
                },
                url: "upload-new-apk-version", type: "POST",
                dataType: "JSON",
                data: new FormData(_form),
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#process").css("display", "block");
                },
                success: function (data) {
                    if (data.status === 1) {
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
                complete: function(xhr) {
                    $submitButton.val( submitButtonText ).attr('disabled', false);
                },
            });
        }
    });

    $(document).on("click", "#companyDeleteBtn", function (e) {
        e.preventDefault();
        var c_sno = $(this).data("c_sno");
        var c_name = $(this).data("c_name");

        var submitButton = $(this);
        var submitButtonText = $(this).val();

        $.alert({
            title: 'Warning!', content: "Action cannot be completed, we strongly recommend you suspend the account instead", type: 'orange', typeAnimated: true,
            buttons: {ok: function () {window.location.reload();}}
        });

        // submitButton.val('wait..' ).attr('disabled', true);
        // $.confirm({
        //     title: 'Warning', content: 'Are you sure you want to delete '+c_name+' company profile?',
        //     buttons: {
        //         confirm: function () {
        //             $.ajax({
        //                 url: "../controllers/v8/support-actions.php", type: "POST",
        //                 data: JSON.stringify({c_sno: c_sno,c_name: c_name, action_code: 201}),
        //                 success: function (data) {
        //                     if (data.status === 1) {
        //                         new PNotify({title: 'Success', text: data.message, type: 'success'});
        //                         $.alert({
        //                             title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
        //                             buttons: {ok: function () {window.location.replace('list-companies');}}
        //                         });
        //                     } else {
        //                         new PNotify({title: 'Error', text: data.message, type: 'danger'});
        //                         $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
        //                     }
        //                 },
        //                 error: function (errData) {},
        //                 complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
        //             });
        //         }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
        //     }
        // });
    });

    $(document).on("click", "#companyStatusBtn", function (e) {
        var c_sno = $(this).data("c_sno");
        var c_id = $(this).data("c_id");
        var s_id = $(this).data("s_id");
        var c_name = $(this).data("c_name");
        var active = $(this).data("active");
        var status='';
        if (active===1)  status='Activate';
        if (active===0)  status='Suspend';

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to '+status+' '+c_name+' company account?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "update-support-status", type: "POST",
                        data: JSON.stringify({c_sno:c_sno,c_id:c_id,s_id:s_id,active:active,action_code:202}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.replace(data.location); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    var datatableInit = function() {
        var $table = $('#datatable-support');

        var table = $table.dataTable({
            "pageLength": 50,
            "bSort":false,
            "aLengthMenu": [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
            sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print'
                },
                {
                    extend: 'excel',
                    text: 'Excel'
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    customize : function(doc){
                        var colCount = new Array();
                        $('#datatable-guard').find('tbody tr:first-child td').each(function(){
                            if($(this).attr('colspan')){
                                for(var i=1;i<=$(this).attr('colspan');$i++){
                                    colCount.push('*');
                                }
                            }else{ colCount.push('*'); }
                        });
                        doc.content[1].table.widths = colCount;
                    }
                }
            ]
        });
        $('<div />').addClass('dt-buttons mb-2 pb-1 text-end').prependTo('#datatable-tabletools_wrapper');
        $table.DataTable().buttons().container().prependTo( '#datatable-tabletools_wrapper .dt-buttons' );
        $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
    };
    $(function() {datatableInit();});

}).apply(this, [jQuery]);

function sendSuccessResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-success alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'success'});
}

function sendErrorResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-danger alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'error'});
}

function sendSuccessResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-success alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'success'});
}

function sendErrorResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-danger alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'error'});
}
