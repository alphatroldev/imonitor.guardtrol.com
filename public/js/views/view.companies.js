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

    $("form[name='company_login']").validate({
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
                url: "login-sup-company-account.php", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('company_login').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.replace(data.location),500);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_company_per_profile']").validate({
        rules: {
            c_name: "required",
            c_email: {required: true,email:true},
            c_address: "required",
            c_phone: "required",
            c_description: "required",
        },
        messages: {
            c_name: "Enter Company Name",
            c_email: "Enter Company Email",
            c_address: "Enter Company Address",
            c_phone: "Enter Company Phone Number",
            c_description: "About the company",

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
                url: "update-company-profile", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {
                    sendErrorResponse('Error', "Internal Error");
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_company_doc']").validate({
        rules: {
            c_op: "required",
            c_no_op: {required: true,digits:true},
            c_rc_no: "required",
            c_tax_id: "required",
            cac_file: "required",
            c_license: "required",
        },
        messages: {
            c_op: "required",
            c_no_op: "must be digit",
            c_rc_no: "required",
            c_tax_id: "required",
            cac_file: "required",
            c_license: "required",

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
                url: "update-company-document",
                type: "POST",
                data: new FormData($('form#update_company_doc')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {
                    sendErrorResponse('Error', "Internal Error");
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_company_per_password']").validate({
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
                url: "update-company-password", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.href = data.location;}}
                        });
                    } else {
                        sendErrorResponse2('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) { sendErrorResponse2('Error', "Internal Error"); },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='company_configuration']").validate({
        ignores:[],
        rules: {
            comp_id: "required",
            uniform_charge: "required",
            uniform_charge_amt: {required:true, digits:true},
            // uniform_charge: {required: ()=> { return $('#uniform_charge').val() ==='Yes'}},
            uni_mode: "required",
            agent: "required",
            agent_fee: {required:true, digits:true},
            agent_mode: "required",
            shift: "required",
            act_date: "required",
            loan_type: "required",
            penalties: "required"
        },
        messages: {
            comp_id:"",
            uniform_charge:"",
            uniform_charge_amt:"",
            agent:"",
            agent_fee:"",
            shift:"",
            act_date:"",
            loan_type:""
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
                url: "create-configuration", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('company_configuration').reset();
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
                error: function (errData) {sendErrorResponse('Error', "Internal Error")},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='create_inv_new_account']").validate({
        ignores:[],
        rules: {
            comp_id: "required",
            inv_acc_name: "required",
            inv_acc_no: {required:true, digits:true},
            inv_bank_name: "required",
        },
        messages: {
            comp_id:"",
            inv_acc_name:"required",
            inv_acc_no:"Only digits are allowed",
            inv_bank_name:"required",
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
                url: "create-invoice-account", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_inv_new_account').reset();
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
                error: function (errData) {sendErrorResponse('Error', "Internal Error")},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_configuration']").validate({
        ignores:[],
        rules: {
            comp_id: "required",
            uniform_charge: "required",
            uniform_charge_amt: {required:true, digits:true},
            // uniform_charge: {required: ()=> { return $('#uniform_charge').val() ==='Yes'}},
            uni_mode: "required",
            agent: "required",
            agent_fee: {required:true, digits:true},
            agent_mode: "required",
            // shift: "required",
            act_date: "required",
            loan_type: "required",
            // penalties: "required"
        },
        messages: {
            comp_id:"",
            uniform_charge:"",
            uniform_charge_amt:"",
            uni_mode:"",
            agent:"",
            agent_fee:"",
            agent_mode:"",
            loan_type:"",
            // shift:"",
            act_date:"",
            // penalties:""
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
                url: "update-configuration", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_configuration').reset();
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
                error: function (errData) {
                    sendErrorResponse('Error', "Internal Error");
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='create_role']").validate({
        rules: {
            role_name: "required",
            comp_id: "required",
            role_sno: "required"
        },
        messages: {
            role_name: "Role name is required",
            comp_id: "",
            role_sno: "Select a role level/alias"
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
                url: "create-role", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_role').reset();
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
                error: function (errData) {sendErrorResponse('Error', "Internal Error")},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='create_shift']").validate({
        rules: {
            shift_title: "required",
            shift_hours: {required: true, digits: true},
            comp_id: "required",
            resume_time: "required",
            close_time: "required"
        },
        messages: {
            shift_title: "Enter shift name",
            shift_hours: "Must be a digits only",
            comp_id: "",
            resume_time: "Enter resumption time",
            close_time: "Enter closing time"
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
                url: "create-shift", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_shift').reset();
                        sendSuccessResponse('Success',data.message);
                        //  $.alert({
                        //     title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                        //     buttons: {ok: function () {window.location.reload();}}
                        // });
                    } else {
                        sendErrorResponse('Error', data.message);
                        // $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {sendErrorResponse('Error', "Internal Error")},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='create_penalty']").validate({
        rules: {
            offense_name: "required",
            comp_id: "required",
            off_charge: "required",
            charge_amt: {digits: ()=> { return $('#off_charge').val() ==='Flat Amount'},required: ()=> { return $('#off_charge').val() ==='Flat Amount'}},
            days_deduct: {digits: ()=> { return $('#off_charge').val() ==='Deduct days worked'},required: ()=> { return $('#off_charge').val() ==='Deduct days worked'}},
        },
        messages: {
            offense_name: "Enter offense name",
            comp_id: "",
            off_charge: "Select offense charge",
            charge_amt: "Enter valid charge amt",
            days_deduct: "Enter valid deduction days"
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
                url: "create-penalty", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_penalty').reset();
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
                error: function (errData) {sendErrorResponse('Error', "Internal Error")},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_company_role']").validate({
        rules: {
            role_name: "required",
            comp_role_sno: "required",
            role_sno: "required"
        },
        messages: {
            role_name: "Role name is required",
            comp_role_sno: "",
            role_sno: "Select a role level/alias"
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
                url: "update-role", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.replace(data.location);}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {
                    sendErrorResponse('Error', "Internal Error");
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_company_shift']").validate({
        rules: {
            shift_title: "required",
            shift_hours: {required: true, digits: true},
            comp_id: "required",
            shift_id: "required",
            resume_time: "required",
            close_time: "required",
        },
        messages: {
            shift_title: "Shift title required",
            shift_hours: "Must be digits only",
            comp_id: "",
            shift_id: "",
            resume_time: "Resumption time required",
            close_time: "Closing time required"
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
                url: "update-shift", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.replace(data.location);}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        // $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {
                    sendErrorResponse('Error', "Internal Error");
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_company_penalty']").validate({
        rules: {
            offense_name: "required",
            comp_id: "required",
            off_charge: "required",
            charge_amt: {digits: ()=> { return $('#off_charge').val() ==='Flat Amount'},required: ()=> { return $('#off_charge').val() ==='Flat Amount'}},
            days_deduct: {digits: ()=> { return $('#off_charge').val() ==='Deduct days worked'},required: ()=> { return $('#off_charge').val() ==='Deduct days worked'}},

        },
        messages: {
            offense_name: "Enter offense name",
            comp_id: "",
            off_charge: "Select offense charge",
            charge_amt: "Enter valid charge amt",
            days_deduct: "Enter valid deduction days"
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
                url: "update-penalty", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.replace(data.location);}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        // $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {
                    sendErrorResponse('Error', "Internal Error");
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $('form#create_incident_report').on('submit', function () {
        $('.report_photo').each(function () {
            $(this).rules("add", {required: true, messages: {required: "Photo is required",}});
        });
    });

    $("form[name='create_incident_report']").validate({
        rules: {
            report_title: "required",
            report_beat: "required",
            report_occ_date:"required",
            report_describe: "required",
        },
        messages: {
            report_title: "title is required",
            report_beat: "beat is required",
            report_occ_date:"occurrence date is required",
            report_describe:"report description is required",
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else if( element.attr('type') === 'file' ) {
                error.appendTo(element.closest('.fileupload'));
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
            var $submitButton = $(this.submitButton), submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "create-incident", type: "POST",
                dataType: "JSON",
                data: new FormData(_form),
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_incident_report').reset();
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    var $w1finish = $('#w1').find('ul.pager li.finish'),
        $w1validator = $("#w1 form").validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).remove();
            },
            errorPlacement: function( error, element ) {
                element.parent().append( error );
            }
        });

    $w1finish.on('click', function( ev ) {
        ev.preventDefault();
        var validated = $('#w1 form').valid();
        if ( validated ) {
            var $form = $('#w1 form'),
                $submitButton = $('input#register'),
                submitButtonText = $submitButton.val();
            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "create-staff",
                type: "POST",
                data: new FormData($('form#create_staff')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_staff').reset();
                        sendSuccessResponse('Success', data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {$.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $('#w1').bootstrapWizard({
        tabClass: 'wizard-steps',
        nextSelector: 'ul.pager li.next',
        previousSelector: 'ul.pager li.previous',
        firstSelector: null,
        lastSelector: null,
        onNext: function( tab, navigation, index, newindex ) {
            var validated = $('#w1 form').valid();
            if( !validated ) {
                $w1validator.focusInvalid();
                return false;
            }
        },
        onTabClick: function( tab, navigation, index, newindex ) {
            if ( newindex == index + 1 ) {
                return this.onNext( tab, navigation, index, newindex);
            } else if ( newindex > index + 1 ) {
                return false;
            } else {
                return true;
            }
        },
        onTabChange: function( tab, navigation, index, newindex ) {
            var totalTabs = navigation.find('li').length - 1;
            $w1finish[ newindex != totalTabs ? 'addClass' : 'removeClass' ]( 'hidden' );
            $('#w1').find(this.nextSelector)[ newindex == totalTabs ? 'addClass' : 'removeClass' ]( 'hidden' );
            tab.removeClass('active');
        }
    });

    $("form[name='update_staff_profile']").validate({
        rules: {
            staff_sno: "required",
            firstname: "required",
            lastname: "required",
            email: {required: true,email:true},
            staff_role: "required",
            stf_status: "required",
        },
        messages: {
            user_id: "",
            firstname: "First name is required",
            lastname: "last name is required",
            email: "Enter a valid email address",
            staff_role: "Type is required",
            stf_status: "Status is required"
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
                url: "update-staff-profile-by-id.php", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_staff_password']").validate({
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
                url: "update-staff-password-by-id.php", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='all_stf_files']").validate({

        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "update-staff-files",
                type: "POST",
                data: new FormData($('form#all_stf_files')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('all_stf_files').reset();
                        sendSuccessResponse('Success', data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {
                                ok: function () {
                                    window.location.reload();
                                }
                            }
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

    $("form[name='update_staff_basic_info']").validate({
        rules: {
            staff_sno: "required",
            firstname: "required",
            lastname: "required",
            email: { required: true, email: true },
            staff_role: "required",
            stf_status: "required",
            phone: { required: true, digits: true, rangelength: [11, 11] },
        },
        messages: {
            user_id: "",
            firstname: "First name is required",
            lastname: "last name is required",
            email: "Enter a valid email address",
            staff_role: "Type is required",
            stf_status: "Status is required",
            phone: "Invalid phone number"
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
                url: "update-staff-basic-info", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_staff_guarantor_info']").validate({
        rules: {
            staff_sno: "required",
            guarantor_title: "required",
            guarantor_first_name: "required",
            guarantor_last_name: "required",
            guarantor_sex: "required",
            guarantor_email: { required: true, email: true },
            guarantor_phone: { required: true, digits: true, rangelength: [11, 11] },
            guarantor_address: "required",
            guarantor_place_of_work: "required",
            guarantor_work_address: "required",
            guarantor_email_2: { email: true },
            guarantor_phone_2: { digits: true, rangelength: [11, 11] },
            guarantor_email_3: { email: true },
            guarantor_phone_3: { digits: true, rangelength: [11, 11] },
        },
        messages: {
            staff_sno: "",
            guarantor_title: "Title is required",
            guarantor_first_name: "first name is required",
            guarantor_last_name: "Enter a valid email address",
            guarantor_sex: "gender is required",
            guarantor_email: "Enter a valid email address",
            guarantor_phone: "invalid phone number",
            guarantor_address: "address is required",
            guarantor_place_of_work: "Place of work is required",
            guarantor_work_address: "Rank is required",
            guarantor_email_2: "Enter a valid email address",
            guarantor_phone_2: "invalid phone number",
            guarantor_email_3: "Enter a valid email address",
            guarantor_phone_3: "invalid phone number"
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
                url: "update-staff-guarantor-info", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_staff_next_of_kin_info']").validate({
        rules: {
            staff_sno: "required",
            kinfirstname: "required",
            kinLastname: "required",
            kinGender: "required",
            kinPhone: { required: true, digits: true, rangelength: [11, 11] },
            kinRel: "required",
        },
        messages: {
            staff_sno: "",
            kinfirstname: "First name is required",
            kinLastname: "last name is required",
            kinGender: "Select a specific gender",
            kinPhone: "Phone number is required",
            kinRel: "Relationship is required"
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
                url: "update-staff-next-of-kin", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_staff_acc_info']").validate({
        rules: {
            staff_sno: "required",
            accBnk: "required",
            accName: "required",
            accNo: { required: true, digits: true, rangelength: [10, 10] },
            salary: { required: true, digits: true },
        },
        messages: {
            user_id: "",
            accBnk: "Name of a bank is required",
            accName: "Account name is required",
            accNo: "Invalid account number",
            salary: "Only didgits are used"
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
                url: "update-staff-acc-info", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='register_new_kit']").validate({
        rules: {
            kit_name: "required"
        },
        messages: {
            kit_name: "Kit Name is required"
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
                url: "register-kit", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='add_kit_inventory']").validate({
        rules: {
            kit_type: "required",
            kit_id: "required",
            kit_num: {required:true, digits:true}
        },
        messages: {
            kit_type: "Kit Type is required",
            kit_id: "Kit Name is required",
            kit_num: "Kit Quantity is required and must be digits",
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
                url: "add-kit", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='stf_issue_loan']").validate({
        rules: {
            loan_amount: {required:true, digits:true, minlength:4},
            loan_duration: {required:true, digits:true},
            loan_monthly_amount: "required",
            issue_date: "required",
            loan_reason: {required:true, minlength:10},
        },
        messages: {
            loan_amount: "Loan amount must be a valid digits and min of â‚¦1000",
            loan_duration: "Loan duration must be number only",
            loan_monthly_amount: "required",
            issue_date: "required",
            loan_reason: "Reason must be at least 10 characters"
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
                url: "create-staff-loan", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_kit_inventory']").validate({
        rules: {
            edit_kit_type: "required",
            edit_kit_id: "required",
            edit_kit_num: {required:true, digits:true},
            edit_comp_id: "required",
            edit_kit_inv_sno: "required"
        },
        messages: {
            edit_kit_type: "Kit Type is required",
            edit_kit_id: "Kit Name is required",
            edit_kit_num: "Kit Quantity is required and must be digits",
            edit_comp_id: "",
            edit_kit_inv_sno: ""
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
                url: "update-kit", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='surchargeStf']").validate({
        rules: {
            offense_title: "required",
            charge_mode: "required",
            offense_date: "required",
            charge_days: {digits: ()=> { return $('#charge_mode').val() ==='Number of days'},required: ()=> { return $('#charge_mode').val() ==='Number of days'}},
            charge_amt: {digits: ()=> { return $('#charge_mode').val() ==='Flat Amount'},required: ()=> { return $('#charge_mode').val() ==='Flat Amount'}},
            charge_reason: "required"
        },
        messages: {
            offense_title: "Required",
            charge_mode: "Required",
            offense_date: "Required",
            charge_days: "Required",
            charge_amt: "Required",
            charge_reason: "Required"
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
                url: "surcharge-staff", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='stf_issue_salary_adv']").validate({
        rules: {
            salary_adv_amount: {required:true, digits:true, minlength:4},
            salary_adv_reason: {required:true, minlength:10},
        },
        messages: {
            loan_amount: "Loan amount must be a valid digits and min of â‚¦1000",
            loan_reason: "Reason must be at least 10 characters"
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
                url: "salary-advance", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='changeStat']").validate({
        rules: {
            comp_id: "required",
            staff_id: "required",
            stfStat: "required",
            statusReason: "required"
        },
        messages: {
            comp_id: "",
            staff_id: "",
            stfStat: "Required",
            statusReason: "At least a reason is required"
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
                url: "update_stf_stat", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='pardonOffense']").validate({
        rules: {
            offense_id: "required",
            pardon_reason: {required:true,minlength:5}
        },
        messages: {
            stfStat: "",
            statusReason: {required:"Reason is required",minlength:"Reason must be at least five character."}
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
                url: "create_offense_pardon", type: "POST", data: $form.serialize(),cache:false,
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

    $('#staff_profile_picx_update').change(function(e){
        e.preventDefault();
        var _form = $("#profile_picx_upload")[0];

        $.ajax({
            url: "update-staff-pp-by-id", type: "POST",
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

    $('#savePP_Profile').click(function(e){
        e.preventDefault();
        var _form = $("form[name='photo_cam_update']");

        $.ajax({
            url: "update-staff-pp_cam-by-id", type: "POST",
            data: _form.serialize(),
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
            complete: function () {
                // $submitButton.val( submitButtonText ).attr('disabled', false);
            }
        });
    });

    $(document).on('click','#edit_kit_inventory', function (e) {
        e.preventDefault();
        var kit_inv_sno = $(this).data("kit_inv_sno");
        var kit_qty = $(this).data("kit_qty");
        var kit_type = $(this).data("kit_type");
        var kit_id = $(this).data("kit_id");
        var kit_name = $(this).data("kit_name");
        

        $('#edit_kit_num').val(kit_qty);
        $('#edit_kit_type').val(kit_type);
        $('#edit_kit_id').val(kit_id);
        $('#edit_kit_name').val(kit_name);
        $('#edit_kit_inv_sno').val(kit_inv_sno);
    });

    $(document).on('click','.pardon_off', function (e) {
        e.preventDefault();
        var offense_id = $(this).data("offense_id");

        $('#offense_id').val(offense_id);
    });

    $(document).on('click','.pardon_guard_off', function (e) {
        e.preventDefault();
        var offense_id = $(this).data("offense_id");
        var guard_id = $(this).data("guard_id");

        $('#offense_id').val(offense_id);
        $('#guard_id').val(guard_id);
    });

    $(document).on("click", "#staffStatusBtn", function (e) {
        var staff_sno = $(this).data("staff_sno");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to update staff status?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({staff_sno:staff_sno,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#staffDeleteBtn", function (e) {
        e.preventDefault();
        var staff_sno = $(this).data("staff_sno");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this staff profile?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "company-actions", type: "POST",
                            data: JSON.stringify({staff_sno: staff_sno, action_code: 102}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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

    $(document).on("click", "#roleDeleteBtn", function (e) {
        e.preventDefault();
        var comp_role_sno = $(this).data("comp_role_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this role?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({comp_role_sno:comp_role_sno,comp_id: comp_id, action_code: 103}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#shiftDeleteBtn", function (e) {
        e.preventDefault();
        var comp_id = $(this).data("comp_id");
        var shift_id = $(this).data("shift_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this shift?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({comp_id:comp_id,shift_id: shift_id, action_code: 104}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#penaltyDeleteBtn", function (e) {
        e.preventDefault();
        var offense_id = $(this).data("offense_id");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this penalty?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({comp_id:comp_id,offense_id: offense_id, action_code: 105}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#incidentDeleteBtn", function (e) {
        e.preventDefault();
        var incident_id = $(this).data("incident_id");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this incident report?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({comp_id:comp_id,incident_id: incident_id, action_code: 106}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#kitInvDeleteBtn", function (e) {
        e.preventDefault();
        var kit_inv_sno = $(this).data("kit_inv_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this kit inventory?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({comp_id:comp_id,kit_inv_sno: kit_inv_sno, action_code: 107}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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
    

    $(document).on("click", "#regKitDeleteBtn", function (e) {
        e.preventDefault();
        var kit_sno = $(this).data("kit_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this registered kit?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({comp_id:comp_id,kit_sno: kit_sno, action_code: 909}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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
    
     $(document).on("click", "#xtraDutyDeleteBtn", function (e) {
        e.preventDefault();
        var xtraduty_id = $(this).data("xtraduty_id");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this xtra duty entry?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({comp_id:comp_id,xtraduty_id: xtraduty_id, action_code: 908}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#payrollDeleteBtn", function (e) {
        e.preventDefault();
        var spr_month = $(this).data("spr_month");
        var spr_year = $(this).data("spr_year");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this payroll. N.B: this action cannot be reversed after deletion?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({spr_month:spr_month,spr_year:spr_year,comp_id:comp_id,action_code: 109}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#guardPayrollDeleteBtn", function (e) {
        e.preventDefault();
        var gpr_month = $(this).data("gpr_month");
        var gpr_year = $(this).data("gpr_year");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this guard payroll. N.B: this action cannot be reversed after deletion?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "company-actions", type: "POST",
                        data: JSON.stringify({gpr_month:gpr_month,gpr_year:gpr_year,comp_id:comp_id,action_code: 129}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#InvAcctDeleteBtn", function (e) {
        e.preventDefault();
        var inv_acc_sno = $(this).data("inv_acc_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete account?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "create-company-invoice-action", type: "POST",
                        data: JSON.stringify({inv_acc_sno:inv_acc_sno,comp_id:comp_id,action_code: 102}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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

    $(document).on("click", "#updateActiveInvAcct", function (e) {
        e.preventDefault();
        var inv_active = $('input[name="inv_active"]:checked').val();
        var comp_id = $('input[name="comp_id"]').val();

        if (typeof inv_active === "undefined") {
            alert("Select at least one account");
        } else {
            var submitButton = $(this);
            var submitButtonText = $(this).val();
            submitButton.val('wait..').attr('disabled', true);

            $.ajax({
                url: "create-company-invoice-action", type: "POST",
                data: JSON.stringify({inv_acc_sno:inv_active,comp_id:comp_id, action_code: 104}),
                success: function (data) {
                    if (data.status === 1) {
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    } else {
                        new PNotify({title: 'Error', text: data.message, type: 'danger'});
                    }
                },
                error: function (errData) {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false);}
            });
        }
    });

    $(document).on("click", "#permissionseBtn", function (e) {
        e.preventDefault();
        var comp_role_sno = $(this).data("comp_role_sno");
        var comp_id = $(this).data("comp_id");
        var role_name = $(this).data("role_name");

        $("#roleTitle").text(role_name);
        $.magnificPopup.open({
            items: {src: '#PermissionsModal'},
            type: 'inline', fixedContentPos: false, fixedBgPos: true, overflowY: 'auto', closeBtnInside: true,
            preloader: false, midClick: false, removalDelay: 300, mainClass: 'my-mfp-zoom-in', modal: true
        }, 0);
    });
    
     $(document).on("click", "#G_PayrollDataBtn", function (e) {
        e.preventDefault();
        var payroll_data_sno = $(this).data("payroll_data_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..').attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this payroll data?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-guards-actions", type: "POST",
                        data: JSON.stringify({ comp_id: comp_id, payroll_data_sno: payroll_data_sno, action_code: 108 }),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({ title: 'Success', text: data.message, type: 'success' });
                                setTimeout(function () {
                                    window.location.reload();
                                }, 500);
                            } else { new PNotify({ title: 'Error', text: data.message, type: 'danger' }); }
                        },
                        error: function (errData) { },
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false); },
            }
        });
    });

    // ####################Client & Beat ###########################
    var $w2finish = $('#w2').find('ul.pager li.finish'),
        $w2validator = $("#w2 form").validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).remove();
            },
            errorPlacement: function( error, element ) {
                element.parent().append( error );
            }
        });

    $w2finish.on('click', function( ev ) {
        ev.preventDefault();
        var validated = $('#w2 form').valid();
        if ( validated ) {
            var $form = $('#w2 form'),
                $submitButton = $('input#register'),
                submitButtonText = $submitButton.val();
            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "create-client",
                type: "POST",
                data: new FormData($('form#register_client')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('register_client').reset();
                        sendSuccessResponse('Success', data.message);
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

    $('#w2').bootstrapWizard({
        tabClass: 'wizard-steps',
        nextSelector: 'ul.pager li.next',
        previousSelector: 'ul.pager li.previous',
        firstSelector: null,
        lastSelector: null,
        onNext: function( tab, navigation, index, newindex ) {
            var validated = $('#w2 form').valid();
            if( !validated ) {
                $w2validator.focusInvalid();
                return false;
            }
        },
        onTabClick: function( tab, navigation, index, newindex ) {
            if ( newindex == index + 1 ) {
                return this.onNext( tab, navigation, index, newindex);
            } else if ( newindex > index + 1 ) {
                return false;
            } else {
                return true;
            }
        },
        onTabChange: function( tab, navigation, index, newindex ) {
            var totalTabs = navigation.find('li').length - 1;
            $w2finish[ newindex != totalTabs ? 'addClass' : 'removeClass' ]( 'hidden' );
            $('#w2').find(this.nextSelector)[ newindex == totalTabs ? 'addClass' : 'removeClass' ]( 'hidden' );
            tab.removeClass('active');
        }
    });

    $('form#register_client').on('submit', function () {
        $('.cc_fullname').each(function () {
            $(this).rules("add", {required: true, messages: {required: "Required",}});
        });
        $('.cc_position').each(function () {
            $(this).rules("add", {required: true, messages: {required: "Required",}});
        });
        $('.cc_phone').each(function () {
            $(this).rules("add", {required: true, messages: {required: "Required",}});
        });
        $('.cc_email').each(function () {
            $(this).rules("add", {required: true, messages: {required: "Required",}});
        });
    });

    $("form[name='update_client_official_info']").validate({
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "update-client-official-info",
                type: "POST",
                data: new FormData($('form#update_client_official_info')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_client_official_info').reset();
                        sendSuccessResponse('Success', data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {
                                ok: function () {
                                    window.location.reload();
                                }
                            }
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

    $("form[name='update_client_info']").validate({
        rules: {
            id: "required",
            edit_client_full_name: "required",
            edit_client_office_address: "required",
            edit_client_office_phone: {required: true, rangelength: [11, 11], number: true},
            edit_client_email: {required: true,email:true},
        },
        messages: {
            id: "",
            edit_client_full_name: "Required",
            edit_client_office_address: "Required",
            edit_client_office_phone: "Invalid phone number",
            edit_client_email: "Enter a valid email address",
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
                url: "update-client-info", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_client_contact_info']").validate({
        rules: {
            id: "required",
            edit_client_contact_full_name: "required",
            edit_client_contact_phone: { required: true, rangelength: [11, 11], number: true },
            edit_client_contact_email: { required: true, email: true },
            edit_client_contact_phone_2: { rangelength: [11, 11], number: true },
            edit_client_contact_email_2: { email: true },
            edit_client_contact_phone_3: { rangelength: [11, 11], number: true },
            edit_client_contact_email_3: { email: true },
        },
        messages: {
            id: "",
            edit_client_contact_full_name: "Required",
            edit_client_contact_phone: "Invalid phone number",
            edit_client_contact_email: "Enter a valid email address",
            edit_client_contact_phone_2: "Invalid phone number",
            edit_client_contact_email_2: "Enter a valid email address",
            edit_client_contact_phone_3: "Invalid phone number",
            edit_client_contact_email_3: "Enter a valid email address",
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
                url: "update-client-contact-info", type: "POST", data: $form.serialize(),cache:false,
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

    $(document).on("click", "#clientStatusBtn", function (e) {
        var client_id = $(this).data("client_id");
        var client_status = $(this).data("client_status");
        $("#client_id_mod").val(client_id);
        if (client_status ==="Active"){
            $("#clientStatus").val("Deactivated");
        } else {
            $("#clientStatus").val("Active");
        }


        // var submitButton = $(this);
        // var submitButtonText = $(this).val();
        // submitButton.val('wait..' ).attr('disabled', true);
        // $.confirm({
        //     title: 'Warning', content: 'Disabling client also disables all beats and guards under it. Proceed?',
        //     buttons: {
        //         confirm: function () {
        //             $.ajax({
        //                 url: "list-clients-actions", type: "POST",
        //                 data: JSON.stringify({id:id,active:active,action_code:101}),
        //                 success: function (data) {
        //                     if (data.status ===1){
        //                         new PNotify({title: 'Success', text: data.message, type: 'success'});
        //                         setTimeout(function () {window.location.replace(data.location); }, 500);
        //                     } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
        //                 },
        //                 error: function (errData)  {},
        //                 complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
        //             });
        //         }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
        //     }
        // });
    });

    $(document).on("click", "#inactiveClientStatusBtn", function (e) {
        var id = $(this).data("id");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Reactivate this client?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-clients-actions", type: "POST",
                        data: JSON.stringify({id:id,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.replace(data.location2); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#clientDeleteBtn", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this client?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-clients-actions", type: "POST",
                            data: JSON.stringify({id:id,action_code:102}),
                            success: function (data) {
                                if (data.status ===1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {window.location.replace(data.location); }, 500);
                                } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                            },
                            error: function (errData) {},
                            complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                        });
                    }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
                }
            });
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $("form[name='create_beat']").validate({
        rules: {
            client_id: "required",
            beat_name: "required",
            beat_address: "required",
            no_of_personnel: "required",
            personnel_type: "required",
            personnel_amt: "required",
            beat_monthly_charges: "required",
            beat_vat: "required",
            date_of_deployment: "required",
        },
        messages: {
            client_id: "",
            beat_name: "",
            beat_address: "",
            no_of_personnel: "",
            personnel_type: "",
            personnel_amt: "",
            beat_monthly_charges: "",
            beat_vat: "",
            date_of_deployment: "",
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-control'));
            } else {
                if( element.closest('.form-control').length ) {
                    error.appendTo(element.closest('.form-control'));
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
                url: "create-beat", type: "POST", data: $form.serialize(),cache:false,cache:false,
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

    $(document).on("click", "#clientStatusBtn", function (e) {
        var client_id = $(this).data("client_id");

        $("#client_id_mod").val(client_id);
    });

    $(document).on("click", "#beatStatusBtn", function (e) {
        var beat_id = $(this).data("beat_id");
        var status = $(this).data("active");

        $("#bt_st_beat_id").val(beat_id);
        $("#bt_st_status").val(status);

        // var submitButton = $(this);
        // var submitButtonText = $(this).val();
        // submitButton.val('wait..' ).attr('disabled', true);
        // $.confirm({
        //     title: 'Warning', content: 'Disabling this beat also disables all guards attached to it. Proceed',
        //     buttons: {
        //         confirm: function () {
        //             $.ajax({
        //                 url: "list-beats-actions", type: "POST",
        //                 data: JSON.stringify({id:id,active:active,action_code:101}),
        //                 success: function (data) {
        //                     if (data.status ===1){
        //                         new PNotify({title: 'Success', text: data.message, type: 'success'});
        //                         setTimeout(function () {window.location.replace(data.location); }, 500);
        //                     } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
        //                 },
        //                 error: function (errData)  {},
        //                 complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
        //             });
        //         }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
        //     }
        // });
    });

    $("form[name='changeBeatStat']").validate({
        rules: {
            bt_st_beat_id: "required",
            bt_st_status: "required",
            bt_st_date: "required",
            bt_st_remark: "required"
        },
        messages: {
            bt_st_beat_id: "",
            bt_st_status: "Required",
            bt_st_date: "Required",
            bt_st_remark: "Required"
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
                url: "update-beat-status", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status ===1){
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
                error: function (errData)  {},
                complete: function () { $submitButton.val(submitButtonText).attr('disabled', false); }
            });
        }
    });


    // $(document).on("click", "#beatStatusBtn", function (e) {
    //     var id = $(this).data("beat_sno");
    //     var active = $(this).data("active");
    //
    //     var submitButton = $(this);
    //     var submitButtonText = $(this).val();
    //     submitButton.val('wait..' ).attr('disabled', true);
    //     $.confirm({
    //         title: 'Warning', content: 'Disabling this beat also disables all guards attached to it. Proceed',
    //         buttons: {
    //             confirm: function () {
    //                 $.ajax({
    //                     url: "list-beats-actions", type: "POST",
    //                     data: JSON.stringify({id:id,active:active,action_code:101}),
    //                     success: function (data) {
    //                         if (data.status ===1){
    //                             new PNotify({title: 'Success', text: data.message, type: 'success'});
    //                             setTimeout(function () {window.location.replace(data.location); }, 500);
    //                         } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
    //                     },
    //                     error: function (errData)  {},
    //                     complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
    //                 });
    //             }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
    //         }
    //     });
    // });

    $(document).on("click", "#inactiveBeatStatusBtn", function (e) {
        var id = $(this).data("beat_sno");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Reactivate this beat?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-beats-actions", type: "POST",
                        data: JSON.stringify({id:id,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.replace(data.location2); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#clientProfileBeatStatusBtn", function (e) {
        var id = $(this).data("beat_sno");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to disable this beat?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-beats-actions", type: "POST",
                        data: JSON.stringify({id:id,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#clientProfileInactiveBeatStatusBtn", function (e) {
        var id = $(this).data("beat_sno");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Reactivate this beat?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-beats-actions", type: "POST",
                        data: JSON.stringify({id:id,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#beatDeleteBtn", function (e) {
        e.preventDefault();
        var beat_sno = $(this).data("beat_sno");
        var beat_id = $(this).data("beat_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this beat?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-beats-actions", type: "POST",
                            data: JSON.stringify({beat_sno: beat_sno,beat_id: beat_id, action_code: 102}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        // window.location.replace(data.location);
                                        window.location.reload();
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

    $("form[name='update_beat']").validate({
        rules: {
            beat_sno: "required",
            edit_beat_name: "required",
            edit_beat_address: "required",
            edit_number_of_guards: {required: true, number: true},
            edit_amount_per_guard: {required: true, number: true},
            edit_beat_monthly_charges: "required",
            edit_beat_vat: "required",
            edit_date_of_deployment: "required",
            edit_beat_status: "required",
            edit_if_beat_supervisor: "required"
        },
        messages: {
            beat_sno: "",
            edit_beat_name: "Required",
            edit_beat_address: "Required",
            edit_number_of_guards: "Invalid Input",
            edit_amount_per_guard: "Invalid Input",
            edit_beat_monthly_charges: "Invalid Input",
            edit_beat_vat: "Required",
            edit_date_of_deployment: "Required",
            edit_beat_status: "Required",
            edit_if_beat_supervisor: "Required"
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
                url: "update-beat", type: "POST", data: $form.serialize(),cache:false,
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

    // #########################Guard and deployment#############################

    var $w5finish = $('#w5').find('ul.pager li.finish'),
        $w5validator = $("#w5 form").validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).remove();
            },
            errorPlacement: function( error, element ) {
                element.parent().append( error );
            }
        });

    $w5finish.on('click', function( ev ) {
        ev.preventDefault();
        var validated = $('#w5 form').valid();
        if ( validated ) {
            var $form = $('#w5 form'),
                $submitButton = $('input#register_guard_button'),
                submitButtonText = $submitButton.val();
            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "register-guard-actions",
                type: "POST",
                data: new FormData($('form#register_guard')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('register_guard').reset();
                        sendSuccessResponse('Success', data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {$.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $('#w5').bootstrapWizard({
        tabClass: 'wizard-steps',
        nextSelector: 'ul.pager li.next',
        previousSelector: 'ul.pager li.previous',
        firstSelector: null,
        lastSelector: null,
        onNext: function( tab, navigation, index, newindex ) {
            var validated = $('#w5 form').valid();
            if( !validated ) {
                $w5validator.focusInvalid();
                return false;
            }
        },
        onTabClick: function( tab, navigation, index, newindex ) {
            if ( newindex == index + 1 ) {
                return this.onNext( tab, navigation, index, newindex);
            } else if ( newindex > index + 1 ) {
                return false;
            } else {
                return true;
            }
        },
        onTabChange: function( tab, navigation, index, newindex ) {
            var totalTabs = navigation.find('li').length - 1;
            $w5finish[ newindex != totalTabs ? 'addClass' : 'removeClass' ]( 'hidden' );
            $('#w5').find(this.nextSelector)[ newindex == totalTabs ? 'addClass' : 'removeClass' ]( 'hidden' );
            tab.removeClass('active');
        }
    });

    $(document).on("click", "#guardStatusBtn", function (e) {
        var id = $(this).data("id");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to disable this guard?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-guards-actions", type: "POST",
                        data: JSON.stringify({id:id,active:active,action_code:101}),
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

    $(document).on("click", "#inactiveguardStatusBtn", function (e) {
        var id = $(this).data("id");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Enable this guard?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-guards-actions", type: "POST",
                        data: JSON.stringify({id:id,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.replace(data.location2); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#guardDeleteBtn", function (e) {
        e.preventDefault();
        var guard_id = $(this).data("guard_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this guard?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-guards-actions", type: "POST",
                            data: JSON.stringify({guard_id: guard_id, action_code:102}),
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

    $("form[name='guard_update_section_one']").validate({
        rules: {
            id: "required",
            guard_name: "required",
            guard_height: "required",
            guard_sex: "required",
            guard_phone: {required: true, number: true},
            referral: "required",
            guard_next_of_kin_name: "required",
            guard_next_of_kin_phone: "required",
            guard_next_of_kin_relationship: "required",
            guard_state_of_origin: "required",
            vetting:"required",
            guard_religion: "required",
            guard_qualification: "required",
            guard_dob: "required",
            guard_address: "required",



        },
        messages: {
            id: "",
            guard_name: "Required",
            guard_height: "Required",
            guard_sex: "Required",
            guard_phone: "Invalid Input",
            referral: "Required",
            guard_next_of_kin_name: "Required",
            guard_next_of_kin_phone: "Required",
            guard_next_of_kin_relationship: "Required",
            guard_state_of_origin: "Required",
            vetting:"Required",
            guard_religion: "Required",
            guard_qualification: "Required",
            guard_dob: "Required",
            guard_address: "Required",

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
                url: "update-guard-section-one", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='guard_update_section_two']").validate({
        rules: {
            id: "required",
            guarantor_title: "required",
            guarantor_full_name: "required",
            guarantor_sex: "required",
            guarantor_phone: "required",
            guarantor_email: "required",
            guarantor_address: "required",
            guarantor_years_of_relationship: {required: true, number: true},
            guarantor_place_of_work: "required",
            guarantor_rank: "required",
            guarantor_work_address: "required",
            guarantor_id_Type: "required",

        },
        messages: {
            id: "",
            guarantor_title: "Required",
            guarantor_full_name: "Required",
            guarantor_sex: "Required",
            guarantor_phone: "Required",
            guarantor_email: "Required",
            guarantor_address: "Required",
            guarantor_years_of_relationship: "Invalid Input",
            guarantor_place_of_work: "Required",
            guarantor_rank: "Required",
            guarantor_work_address: "Required",
            guarantor_id_Type: "Required",
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
                url: "update-guard-section-two",
                type: "POST",
                data: new FormData($('form#guard_update_section_two')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('guard_update_section_two').reset();
                        sendSuccessResponse('Success', data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {
                                ok: function () {
                                    window.location.reload();
                                }
                            }
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

    $("form[name='guard_update_section_three']").validate({
        rules: {
            id: "required",

            guard_id_Type: "required",
            guard_bank: "required",
            guard_acct_number: {required: true, rangelength: [10, 10], number: true},
            guard_acct_name: "required",
            guard_position: "required",
            beat: "required",
            guard_date_of_deployment: "required",
            guard_salary: "required",
            guard_blood_group: "required",
            guard_shift: "required",
            guard_remark: "required",

        },
        messages: {
            id: "",

            guard_id_Type: "Required",
            guard_bank: "Required",
            guard_acct_number: "Account Number must be 10 numbers",
            guard_acct_name: "Required",
            guard_position: "Required",
            beat: "Required",
            guard_date_of_deployment: "Invalid Input",
            guard_salary: "Required",
            guard_blood_group: "Required",
            guard_shift: "Required",
            guard_remark: "Required",
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
                url: "update-guard-section-three",
                type: "POST",
                data: new FormData($('form#guard_update_section_three')[0]),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('guard_update_section_three').reset();
                        sendSuccessResponse('Success', data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {
                                ok: function () {
                                    window.location.reload();
                                }
                            }
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

    $("form[name='guardchangeStat']").validate({
        rules: {
            guardStatus: "required",
            statusReason: "required",

        },
        messages: {
            guardStat: "Required",
            statusReason: "Required",

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
                url: "guard-status-actions", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='guardOffensePardon']").validate({
        rules: {
            offense_id: "required",
            pardon_reason: {required:true,minlength:5}
        },
        messages: {
            stfStat: "",
            statusReason: {required:"Reason is required",minlength:"Reason must be at least five character."}
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
                url: "create_guard_offense_pardon", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='guard_issue_salary_adv']").validate({
         rules: {
            salary_adv_reason: "required",
            salary_adv_amount: {required:true, digits:true},
             ded_month: "required",
            ded_year: "required"
        },
        messages: {
            salary_adv_reason: "Required",
            salary_adv_amount: "Invalid Input",
            ded_month: "Select deduction month",
            ded_year: "Select deduction year"
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
                url: "guard-issue-salary-adv", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='guard_issue_loan']").validate({
        rules: {
            loan_amount: {required:true, digits:true, minlength:4},
            loan_duration: {required:true, digits:true},
            loan_monthly_amount: "required",
            issue_date: "required",
            loan_reason: {required:true, minlength:10},
        },
        messages: {
            loan_amount: "Loan amount must be a valid digits and min of ₦1,000",
            loan_duration: "Loan duration must be number only",
            loan_monthly_amount: "Required",
            issue_date: "Required",
            loan_reason: "Reason must be at least 10 characters"
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
                url: "issue-guard-loan", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='bookGuard']").validate({
        rules: {
            offense_title:"required",
            // guardOffenseReason: "required",
            charge_mode: "required",
            offense_date: "required",
            charge_days: {
                digits: ()=> { return $('#charge_mode').val() ==='Number of days' && $('#charge_mode').val() !== 'Permanent dismissal'},
                required: ()=> { return $('#charge_mode').val() ==='Number of days' && $('#charge_mode').val() !== 'Permanent dismissal'}},
            charge_amt: {digits: ()=> { return $('#charge_mode').val() ==='Flat Amount'},required: ()=> { return $('#charge_mode').val() ==='Flat Amount'}},
            guard_offense_remark: "required",
        },
        messages: {
            offense_title: "Required",
            // guardOffenseReason: "Required",
            charge_mode: "Required",
            offense_date: "Required",
            charge_days: "Required",
            charge_amt: "Required",
            guard_offense_remark: "Required"
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
                url: "book-guard-offense", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='guardExtraDuty']").validate({
        rules: {
            extra_duty_remark:"required",
            extra_duty_beat_id: "required",
            extra_duty_guard_replace: "required",
            extra_duty_No_Of_Days: {required:true, digits:false},
        },
        messages: {
            offense_title: "Required",
            guardOffenseReason: "Required",
            guardOffenceNoOfDays: "Required",
            guard_offense_remark: "Invalid Input"
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
                url: "guard-extra-duty", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='absentOnTraining']").validate({
        rules: {
            absent_training_remark:"required",
            absent_training_No_Of_Days: {required:true, digits:true},
        },
        messages: {
            absent_training_remark: "Required",
            absent_training_No_Of_Days: "Invalid Input"
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
                url: "guard-absent-training", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='guardKit']").validate({
        rules: {
            guard_kit_type:"required",
            guard_kit_date:"required",
            guard_kit_remark:"required",
            guard_kit_amt: {required:true, digits:true},
        },
        messages: {
            guard_kit_type: "Required",
            guard_kit_date:"Required",
            guard_kit_remark: "Required",
            guard_kit_amt: "Invalid Input"
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
                url: "guard-issue-kit", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='guardIDCardCharge']").validate({
        rules: {
            guard_id_card_remark:"required",
            guard_id_card_amt: {required:true, digits:true},
        },
        messages: {
            guard_id_card_remark: "Required",
            guard_id_card_amt: "Invalid Input"
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
                url: "guard-id-card-charge", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='deploy_guard']").validate({
        rules: {
            guard_id: "required",
            beat_id: "required",
            date_of_deploy: "required",
            observe_start: "required",
            observe_end: "required",
            commence_date: "required",
            paid_observe: "required",
            guard_position: "required",
            guard_shift: "required",
            guard_salary: {required: true,digits:true},
            num_days_worked: {
                digits: ()=> { return $('#paid_observe').val() ==='yes'},
                required: ()=> { return $('#paid_observe').val() ==='yes'}
            },

        },
        messages: {
            guard_id: "Required",
            beat_id: "Required",
            date_of_deploy: "Required",
            observe_start: "Required",
            observe_end: "Required",
            commence_date: "Required",
            paid_observe: "Required",
            guard_position: "Required",
            guard_shift: "Required",
            guard_salary: "Invalid input",
            num_days_worked:"Required"
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
                url: "deploy-guard-actions", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='edit_guard_deployment']").validate({
        rules: {
            id: "required",
            beat: "required",
            date_of_deploy: "required",
            observe_start: "required",
            observe_end: "required",
            commence_date: "required",
            paid_observe: "required",
            month: "required",
            year: "required",
            agent_fee: "required",
            num_days_worked: "required",
            fresh:"required",




        },
        messages: {
            id: "",
            beat: "Required",
            date_of_deploy: "Required",
            observe_start: "Required",
            observe_end: "Required",
            commence_date:"Required",
            paid_observe: "Required",
            month: "Required",
            year: "Required",
            agent_fee: "Required",
            num_days_worked: "Required",
            fresh:"Required",
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
                url: "update-guard-deployment", type: "POST", data: $form.serialize(),cache:false,
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
    
    $("form[name='DebitCreditGuardPayroll']").validate({
        rules: {
            payroll_title: "required",
            comp_id: "required",
            payroll_typ: "required",
            payment_mode: "required",
            payroll_amount: {required:true,digits:true},
            mon_month: {required: ()=> { return $('#payment_mode').val() ==='One Time'}},
            mon_year: {required: ()=> { return $('#payment_mode').val() ==='One Time'}},
            payroll_remark: "required",
            pay_data_date: "required",
            guard_id: "required"
        },
        messages: {
            payroll_title: "Required",
            comp_id: "",
            payroll_typ: "Required",
            payment_mode: "Required",
            payroll_amount: "Enter a valid digit",
            mon_month: "Month is required",
            mon_year: "Year is required",
            payroll_remark: "Required",
            pay_data_date: "Required",
            guard_id: "",
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
                url: "create-guard-payroll-data", type: "POST", data: $form.serialize(),cache:false,
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

    $(document).on("click", "#norminalRollDeleteBtn", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to permanently remove this staff from this beat?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "norminal-roll-actions", type: "POST",
                            data: JSON.stringify({id: id, action_code: 102}),
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

    $("form[name='add_guard_positions']").validate({
        rules: {
            pos_title: {required:true,minlength:4},
            comp_id: "required"
        },
        messages: {
            guard_id: "Required",
            beat_id: "",
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
                url: "create-guard-position", type: "POST", data: $form.serialize(),cache:false,
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

    $(document).on('click','.add-position-modal', function (e) {
        e.preventDefault();
        var comp_id = $(this).data("comp_id");
        var pos_sno = $(this).data("pos_sno");
        var pos_title = $(this).data("pos_title");
        var pos_type = $(this).data("pos_type");

        $('#edit_comp_id').val(comp_id);
        $('#edit_pos_sno').val(pos_sno);
        $('#edit_pos_title').val(pos_title);
        $('#edit_pos_type').val(pos_type);
    });

    $(document).on('click','.client_payment_details', function (e) {
        e.preventDefault();
        var rep_amt = $(this).data("rep_amt");
        var rep_client = $(this).data("rep_client");
        var rep_pay_met = $(this).data("rep_pay_met");
        var rep_receipt = $(this).data("rep_receipt");
        var rep_desc = $(this).data("rep_desc");
        var rep_date = $(this).data("rep_date");

        $('#rep_amt').html(rep_amt.toLocaleString());
        $('#rep_client').html(rep_client);
        $('#rep_pay_met').html(rep_pay_met);
        $('#rep_receipt').html(rep_receipt);
        $('#rep_desc').html(rep_desc);
        $('#rep_date').html(rep_date);
    });

    $("form[name='update_guard_positions']").validate({
        rules: {
            edit_pos_title: {required:true,minlength:4},
            edit_comp_id: "required",
            edit_pos_sno: "required"
        },
        messages: {
            edit_pos_title: "Required",
            edit_comp_id: "",
            edit_pos_sno: ""
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
                url: "update-guard-position", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='generate_staff_payroll']").validate({
        rules: {
            sel_month: "required",
            sel_year: "required"
        },
        messages: {
            sel_month: "Required",
            sel_year: "Required"
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
                url: "generate-staff-payroll", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {text: 'Continue',Continue: function () {window.location.replace(data.location);}}
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

    $("form[name='generate_guard_payroll']").validate({
        rules: {
            sel_month: "required",
            sel_year: "required"
        },
        messages: {
            sel_month: "Required",
            sel_year: "Required"
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
                url: "generate-guard-payroll", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {text: 'Continue',Continue: function () {window.location.replace(data.location);}}
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

    $("form[name='generate_beat_invoice']").validate({
        rules: {
            client_id: "required",
            start: "required",
            end: "required"
        },
        messages: {
            client_id: "Select a client to continue",
            start: "",
            end: ""
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
                url: "generate-beat-invoice", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {text: 'Continue',Continue: function () {window.location.replace(data.location);}}
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

    $("form[name='InvoiceDebitCredit']").validate({
        rules: {
            beat_id: "required",
            dc_category: "required",
            dc_reason: {required: true, minlength: 10},
            // chr_days: {digits: ()=> { return $('input[name="dc_category"]').val() ==='Credit'},required: ()=> { return $('input[name="dc_category"]').val() ==='Credit'}},
            cred_amt: {digits: ()=> { return $('input[name="dc_category"]').val() ==='Credit'},required: ()=> { return $('input[name="dc_category"]').val() ==='Credit'}},
            deb_amt: {digits: ()=> { return $('input[name="dc_category"]').val() ==='Debit'},required: ()=> { return $('input[name="dc_category"]').val() ==='Debit'}},
            no_guard: {required: true, digits: 10},
            start: "required",
            end: "required",
            client_id: "required",
            comp_id: "required"
        },
        messages: {
            beat_id: "Select a beat",
            dc_category: "Select a category",
            dc_reason: {required: "Reason is required", minlength: "minimum of 10 characters"},
            cred_amt: "Amount must be digit",
            deb_amt: "Amount must be digit",
            no_guard: "Guard number must be digit",
            start: "",
            end: "",
            client_id: "",
            comp_id: ""
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
                url: "create-invoice-debit-credit", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {text: 'Continue',Continue: function () {window.location.reload();}}
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

    $('#guard_profile_picx_update').change(function(e){
        e.preventDefault();
        var _form = $("#guard_profile_upload")[0];
        //check file size
        const input = document.getElementById('guard_profile_picx_update');
        if (input.files && input.files[0]) {
            const imageFile = input.files[0];
            const imageSizeInBytes = imageFile.size;
            const imageSizeInKB = imageSizeInBytes / 1024;
    
            // Set your maximum allowed size (in kilobytes)
            const maxAllowedSize = 1024*.1; // max sizd: 3 MB
    
            if (imageSizeInKB > maxAllowedSize) {
                $.alert({title: 'Warning!', content: 'image exceeds the allowed file size of 3MB let\'s try that again', type: 'red', typeAnimated: true,});
                
                // Optionally, clear the file input to prevent uploading the image
                input.value = '';
                return;
            }
        }
       // return
        $.ajax({
            url: "update-guard-pp-by-id", type: "POST",
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
  

    $('#w1_guard_id_front').change(function(e){
        e.preventDefault();
        var submitButton = $("#gIDFrontUpload"),
        submitButtonText = submitButton.val();
        submitButton.val('Please wait...' ).attr('disabled', true);

        var _form = $("#guard_id_front_upload")[0];

        $.ajax({
            url: "update-guard-files-by-id", type: "POST",
            dataType: "JSON",
            data: new FormData(_form),
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status === 1) {
                    $.alert({
                        title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                        buttons: {ok: function () {window.location.reload();}}
                    });
                } else {
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                }
            },
            error: function (errData) {},
            complete: function () {  submitButton.val( submitButtonText ).attr('disabled', false); }
        });
    });

    $('#w1_guard_back').change(function(e){
        e.preventDefault();
        var submitButton = $("#gIDBackUpload"),
        submitButtonText = submitButton.val();
        submitButton.val('Please wait...' ).attr('disabled', true);

        var _form = $("#guard_id_back_upload")[0];

        $.ajax({
            url: "update-guard-files-by-id", type: "POST",
            dataType: "JSON",
            data: new FormData(_form),
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status === 1) {
                    $.alert({
                        title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                        buttons: {ok: function () {window.location.reload();}}
                    });
                } else {
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                }
            },
            error: function (errData) {},
            complete: function () {  submitButton.val( submitButtonText ).attr('disabled', false); }
        });
    });

    $('#w1_guard_signature').change(function(e){
        e.preventDefault();
        var submitButton = $("#gSignatureUpload"),
        submitButtonText = submitButton.val();
        submitButton.val('Please wait...' ).attr('disabled', true);

        var _form = $("#guard_signature_upload")[0];

        $.ajax({
            url: "update-guard-files-by-id", type: "POST",
            dataType: "JSON",
            data: new FormData(_form),
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status === 1) {
                    $.alert({
                        title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                        buttons: {ok: function () {window.location.reload();}}
                    });
                } else {
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                }
            },
            error: function (errData) {},
            complete: function () {  submitButton.val( submitButtonText ).attr('disabled', false); }
        });
    });

    $('#guard_savePP_Profile').click(function(e){
        e.preventDefault();
        var _form = $("form[name='guard_photo_cam_update']");

        $.ajax({
            url: "update-guard-pp_cam-by-id", type: "POST",
            data: _form.serialize(),
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
            complete: function () {
                // $submitButton.val( submitButtonText ).attr('disabled', false);
            }
        });
    });

    $('#client_profile_picx_update').change(function(e){
        e.preventDefault();
        var _form = $("#client_profile_upload")[0];

        $.ajax({
            url: "update-client-pp-by-id", type: "POST",
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

    $(document).on("click", "#posDeleteBtn", function (e) {
        e.preventDefault();
        var comp_id = $(this).data("comp_id");
        var pos_sno = $(this).data("pos_sno");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this position?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "guard-position-actions", type: "POST",
                            data: JSON.stringify({comp_id: comp_id, pos_sno: pos_sno, action_code: 101}),
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

    $(document).on("click", "#DebCredDeleteBtn", function (e) {
        e.preventDefault();
        var inv_dc_sno = $(this).data("inv_dc_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this credit/debit?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-clients-actions", type: "POST",
                            data: JSON.stringify({comp_id: comp_id, inv_dc_sno: inv_dc_sno, action_code: 103}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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
    
    $(document).on("click", "#UniformDeductDeleteBtn", function (e) {
        e.preventDefault();
        var un_id = $(this).data("un_id");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this unifrom deduct data?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-guards-actions", type: "POST",
                            data: JSON.stringify({un_id, comp_id, action_code: 520}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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

    $(document).on("click", "#invoiceDeleteBtn", function (e) {
        e.preventDefault();
        var invoice_id = $(this).data("invoice_id");
        var comp_id = $(this).data("comp_id");
        var client_id = $(this).data("client_id");
        var invoice_amt = $(this).data("invoice_amt");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this invoice details?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-clients-actions", type: "POST",
                            data: JSON.stringify({comp_id:comp_id,invoice_id:invoice_id,client_id:client_id,invoice_amt:invoice_amt,action_code:104}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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

    $(document).on("click", "#payReceiptDeleteBtn", function (e) {
        e.preventDefault();
        var receipt_id = $(this).data("receipt_id");
        var comp_id = $(this).data("comp_id");
        var client_id = $(this).data("client_id");
        var pay_amt = $(this).data("pay_amt");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this payment receipt?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-clients-actions", type: "POST",
                            data: JSON.stringify({comp_id,receipt_id,client_id,pay_amt,action_code: 105}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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

    $(document).on("click", "#payrollDataDeleteBtn", function (e) {
        e.preventDefault();
        var payroll_sno = $(this).data("payroll_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this payroll data?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "company-actions", type: "POST",
                            data: JSON.stringify({comp_id: comp_id, payroll_sno: payroll_sno, action_code: 202}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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
    
    $(document).on("click", "#DebCredPayrollDeleteBtn", function (e) {
        e.preventDefault();
        var gpd_sno = $(this).data("gpd_sno");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true),
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this payroll data?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-guards-actions", type: "POST",
                            data: JSON.stringify({gpd_sno, comp_id, action_code: 502}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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
    
    $(document).on("click", "#delGuardOffense", function (e) {
        e.preventDefault();
        var offense_id = $(this).data("offense_id");
        var guard_id = $(this).data("guard_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
            $.confirm({
                title: 'Warning', content: 'Are you sure you want to delete this guard offense?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: "list-guard-actions", type: "POST",
                            data: JSON.stringify({offense_id,guard_id, action_code: 402}),
                            success: function (data) {
                                if (data.status === 1) {
                                    new PNotify({title: 'Success', text: data.message, type: 'success'});
                                    setTimeout(function () {
                                        window.location.reload();
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

    $("form[name='clientConfirmPayment']").validate({
        rules: {
            con_client_pay_amt:{required:true, number:true},
            con_client_pay_method: "required",
            con_client_pay_date: "required",
            con_client_pay_remark: "required",
            cheque_no: {required: ()=> { return $('#con-client-pay-method').val() ==='Cheque'}},
            bank_name: {required: ()=> { return $('#con-client-pay-method').val() ==='Cheque'}},
            receive_name: {required: ()=> { return $('#con-client-pay-method').val() ==='Cheque'}},
            receive_name_2: {required: ()=> { return $('#con-client-pay-method').val() ==='Cash'}},
        },
        messages: {
            con_client_pay_amt: "Invalid Input",
            con_client_pay_method: "Required",
            con_client_pay_date: "Required",
            con_client_pay_remark: "Required",
            cheque_no: "Required",
            bank_name: "Required",
            receive_name: "Required",
            receive_name_2: "Required",
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
            
            var date = $("#con_client_pay_date").val();
            var client_id = $("#client_id").val();
            var comp_id = $("#comp_id").val();
            $.ajax({
                url: "list-clients-actions", type:"POST",data:JSON.stringify({date,comp_id,client_id,action_code:100}),
                success: function (data) {
                    if (data.status === 1) {
                        $.confirm({
                            title: 'Warning', content: 'We notice a payment as been made with same date, do you wish to proceed?',
                            buttons: {
                                confirm: function () {
                                    $.ajax({
                                        url: "client-confirm-payment", type: "POST", data: $form.serialize(),cache:false,
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
                                }, 
                                cancel: function () { $submitButton.val(submitButtonText).attr('disabled', false);},
                            }
                        });
                    } else {
                         $.ajax({
                            url: "client-confirm-payment", type: "POST", data: $form.serialize(),cache:false,
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
                }
            });
        }
    });

    $("form[name='changeClientStatus']").validate({
        rules: {
            clientStatus: "required",
            clientStatusRemark: "required",
        },
        messages: {
            clientStatus: "Required",
            clientStatusRemark: "Required",
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
                url: "client-status-actions", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='add_payroll_settings']").validate({
        rules: {
            payroll_title: "required",
            payroll_typ: "required",
            access_type: "required",
            payment_mode: "required",
            fixed_amount: "required",
            mon_month: {required: ()=> { return $('#payment_mode').val() ==='One Time'}},
            mon_year: {required: ()=> { return $('#payment_mode').val() ==='One Time'}},
            payroll_amount: {digits: ()=> { return $('#fixed_amount').val() ==='Yes'},required: ()=> { return $('#fixed_amount').val() ==='Yes'}},
        },
        messages: {
            payroll_title: "Payment title is required",
            payroll_typ: "Select a payroll type",
            access_type: "Select a access type",
            payment_mode: "Select a payroll mode",
            fixed_amount: "Select a fixed amount",
            mon_month: "Month is required",
            mon_year: "Year is required",
            payroll_amount: "Amount must be digits",
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
                url: "add-payment-setting", type: "POST", data: $form.serialize(),cache:false,
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

    $(document).on('click','#edit_payroll-settings', function (e) {
        e.preventDefault();
        var payroll_settings_sno = $(this).data("payroll_settings_sno");
        var payroll_title = $(this).data("payroll_title");
        var payroll_type = $(this).data("payroll_type");
        var access_type = $(this).data("access_type");
        var payment_mode = $(this).data("payment_mode");
        var mon_month = $(this).data("mon_month");
        var mon_year = $(this).data("mon_year");
        var fixed_amount = $(this).data("fixed_amount");
        var payroll_amount = $(this).data("payroll_amount");

        $('#payroll_settings_sno').val(payroll_settings_sno);
        $('#payroll_title').val(payroll_title);
        $('#payroll_type').val(payroll_type);
        // $('#access_type').val(access_type);
        $('#payment_mode').val(payment_mode);
        $('#mon_year').val(mon_year);
        $('#mon_month').val(mon_month);
        $('#fixed_amount').val(fixed_amount);
        $('#payroll_amount').val(payroll_amount);

        if (payment_mode === "One Time") {
            $(".row_mon_year_2").show();
        }
        if (fixed_amount === "Yes") {
            $(".row_pr_amt_2").show();
        }

        if(payroll_type === 'Debit'){
            $("#Debit").prop("checked", true);
        } else {
            $("#Credit").prop("checked", true);
        }

        if(access_type === 'Both'){
            $("#Both").prop("checked", true);
        } else if(access_type === 'Guard') {
            $("#Guard").prop("checked", true);
        }else if(access_type === 'Staff') {
            $("#Staff").prop("checked", true);
        }
    });

    $("form[name='update_payroll_settings']").validate({
        rules: {
            payroll_title: "required",
            payroll_typ: "required",
            access_type: "required",
            payment_mode: "required",
            fixed_amount: "required",
            mon_month: {required: ()=> { return $('#payment_mode').val() ==='One Time'}},
            mon_year: {required: ()=> { return $('#payment_mode').val() ==='One Time'}},
            payroll_amount: {digits: ()=> { return $('#fixed_amount').val() ==='Yes'},required: ()=> { return $('#fixed_amount').val() ==='Yes'}},
            comp_id: "required",
            edit_payroll_settings_sno: "required"
        },
        messages: {
            payroll_title: "Payroll Title is required",
            payroll_typ: "Payroll Type is required",
            access_type: "Access Type is required",
            payment_mode: "Payroll Mode is required",
            fixed_amount: "Fixed Amount is required",
            mon_month: "Month is required",
            mon_year: "Year is required",
            payroll_amount: "Amount must be digits",
            comp_id: "",
            edit_payroll_settings_sno: ""
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
                url: "update-payment-setting", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='assign_staff_privileges']").validate({
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
                url: "staff-privilege-actions", type: "POST", data: $form.serialize(),cache:false,
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
    
    $("form[name='assign_route_to_guard']").validate({
        rules: {
            routes: "required",
            guard_id: "required",
        },
        messages: {
            routes: "Route is required",
            guard_id: "Guard is required",
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
                url: "assign-route-to-guard", type: "POST", data: $form.serialize(),cache:false,
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
    
    $("form[name='generate_sa_report']").validate({
        rules: {
            sel_month: "required",
            sel_year: "required",
        },
        messages: {
            sel_month: "Month is required",
            sel_year: "Year is required",
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
                url: "generate-salary-advance-report", type: "POST", data: $form.serialize(),cache:false,
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
    
    
    $("form[name='create_beat_supervisor']").validate({
        rules: {
            bs_email: {required: true,email:true},
            bs_firstname: "required",
            bs_lastname: "required",
            bs_beats: "required",
            bs_pwd: {required: true, minlength: 6},
            bs_con_pwd: {required: true, equalTo: '[name="bs_pwd"]'}
        },
        messages: {
            bs_email: "Enter a valid email address",
            bs_firstname: "Firstname is required",
            bs_lastname: "Lastname is required",
            bs_beats: "Select at least one beat",
            bs_pwd: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            bs_con_pwd: {required: "Required", equalTo: "Password not matched"}
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
                url: "create-beat-supervisor", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_beat_supervisor']").validate({
        rules: {
            bs_email: {required: true,email:true},
            bs_firstname: "required",
            bs_lastname: "required",
            bs_beats: "required"
        },
        messages: {
            bs_email: "Enter a valid email address",
            bs_firstname: "Firstname is required",
            bs_lastname: "Lastname is required",
            bs_beats: "Select at least one beat"
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
                url: "update-beat-supervisor", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_beat_supervisor_pwd']").validate({
        rules: {
            bs_old_pwd: "required",
            bs_pwd: {required: true, minlength: 6},
            bs_con_pwd: {required: true, equalTo: '[name="bs_pwd"]'}
        },
        messages: {
            bs_email: "Old password is reqyuired",
            bs_pwd: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            bs_con_pwd: {required: "Required", equalTo: "Password not matched"}
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
                url: "update-beat-supervisor-pwd", type: "POST", data: $form.serialize(),cache:false,
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
    
    $("form[name='create_client_profile']").validate({
        rules: {
            client_id: {required: true},
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            client_id: "Select client ID",
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
                url: "create-client-login", type: "POST", data: $form.serialize(),cache:false,
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

    $("form[name='update_client_login_pwd']").validate({
        rules: {
            client_id: "required",
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            client_id: "",
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
                url: "update-client-login-pwd", type: "POST", data: $form.serialize(),cache:false,
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


    $(document).on('click','#notificationStatusBtn', function (e) {
        e.preventDefault();
        var note_id = $(this).data("note_id");
        var note_url = $(this).data("note_url");
        var comp_id = $(this).data("comp_id");

        var submitButton = $(this);
        submitButton.attr('disabled', true);

        $.ajax({
            url: "notification-actions", type: "POST",
            data: JSON.stringify({comp_id: comp_id,note_id:note_id,note_url:note_url, action_code: 101}),
            success: function (data) {
                if (data.status === 1) {
                    window.location.href = note_url;
                } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
            },
            error: function (errData) {},
            complete: function () { submitButton.attr('disabled', false); }
        });
    });
    
    $(document).on("click", "#gRouteTaskDelBtn", function (e) {
        e.preventDefault();
        var g_route_sno = $(this).data("g_route_sno");
        var company_id = $(this).data("comp_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this assigned route task?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-guard-actions", type: "POST",
                        data: JSON.stringify({g_route_sno,company_id, action_code: 602}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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
    
    $(document).on("click", "#bsuDeleteBtn", function (e) {
        e.preventDefault();
        var bsu_id = $(this).data("bsu_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this beat supervisor?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-beats-actions", type: "POST",
                        data: JSON.stringify({bsu_id:bsu_id,action_code: 204}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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
    
    
    
    $(document).on("click", "#clpDeleteBtn", function (e) {
        e.preventDefault();
        var clp_client_id = $(this).data("clp_client_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this client login profile?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "list-beats-actions", type: "POST",
                        data: JSON.stringify({client_id:clp_client_id,action_code: 304}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.reload();
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
    
    
    
    $("form[name='test_entry']").validate({
        rules: {
            fname: "required",
            lname: "required",
            phone: "required",
            email: {required: true,email:true},
        },
        messages: {
            fname: "required",
            lname: "required",
            phone: "required",
            email: "required",
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
                url: "enter-test-entry", type: "POST", data: $form.serialize(),cache:false,
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {
                    sendErrorResponse('Error', "Internal Error");
                    $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    var datatableInit = function() {
        var $table = $('#datatable-company');

        var table = $table.dataTable({
            "pageLength": 50,
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
                        $('#datatable-company').find('tbody tr:first-child td').each(function(){
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

    $('.modal-basic').magnificPopup({
        type: 'inline',
        preloader: false,
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

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