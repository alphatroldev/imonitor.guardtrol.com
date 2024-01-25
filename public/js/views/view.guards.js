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

    // validation summary
    var $add_guard = $("#add_guard");
    $add_guard.validate({
        errorContainer: $add_guard.find( 'div.validation-message' ),
        errorLabelContainer: $add_guard.find( 'div.validation-message ul' ),
        wrapper: "li",
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/create-company-guard.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_guard').reset();
                        sendSuccessResponse('Success',data.message);
                        document.getElementById('imgPrev').innerHTML = '';
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    // validation summary
    var $update_guard = $("#update_guard");
    $update_guard.validate({
        errorContainer: $update_guard.find( 'div.validation-message' ),
        errorLabelContainer: $update_guard.find( 'div.validation-message ul' ),
        wrapper: "li",
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/update-company-guard.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>{window.location.replace("list-guards")}, 2000);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='updateAccountProfile']").validate({
        rules: {
            com_name: "required",
            com_address: "required",
            com_email: {required: true,email:true},
        },
        messages: {
            com_name: "Enter a valid company name",
            com_address: "Enter a valid company address",
            com_email: "Enter a valid email address"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
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
                url: "../controllers/v7/update-company-profile.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('updateAccountProfile').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.reload(),1500);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='updateAccountPassword']").validate({
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
                url: "../controllers/v7/update-account-password.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('updateAccountPassword').reset();
                        sendSuccessResponse2('Success',data.message);
                        setTimeout(()=>window.location.reload(),7500);
                    } else { sendErrorResponse2('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $(document).on("click", "#guardStatusBtn", function (e) {
        var g_id = $(this).data("g_id");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to update guard status?");

        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({g_id:g_id,active:active,action_code:201}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.replace('list-guards'); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#guardDeleteBtn", function (e) {
        e.preventDefault();
        var b_id = $(this).data("b_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to delete beat?");

        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({b_id:b_id,action_code:102}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.replace('list-guards'); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#attDeleteBtn", function (e) {
        e.preventDefault();
        var att_id = $(this).data("att_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to delete attendant record?");
        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({att_id:att_id,action_code:301}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.replace('manage-attendance'); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    var datatableInit = function() {
        var $table = $('#datatable-guard');

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
    $(function() {
        datatableInit();
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