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

    $("form[name='add_route']").validate({
        rules: {
            beat: "required", r_name: "required", r_type: "required", r_int_time: "required"
        },
        messages: {
            beat: "", r_name: "", r_type: "", r_int_time: "",
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
                url: "../controllers/v7/create-company-beat-route.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_route').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.reload(),3000);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_route']").validate({
        rules: {
            e_beat: "required", e_r_name: "required", e_r_type: "required", e_r_int_time: "required", e_r_id: "required"
        },
        messages: {
            e_beat: "", e_r_name: "", e_r_type: "", e_r_int_time: "", e_r_id: ""
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
                url: "../controllers/v7/update-company-beat-route.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_route').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.reload(),1000);
                    }
                    else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_point']").validate({
        rules: {
            e_pnt_alias: "required", e_pnt_long: "required", e_pnt_lati: "required"
        },
        messages: {
            e_pnt_alias: "", e_pnt_long: "", e_pnt_lati: ""
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
                url: "../controllers/v7/update-company-beat-route-point.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_point').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.reload(),1000);
                    }
                    else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='add_routing_task']").validate({
        rules: {beat_guard: "required", beat_routes: "required", beat: "required"},
        messages: {beat_guard: "", beat_routes: "", beat: ""},
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
                url: "../controllers/v7/create-company-beat-routing-task.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_routing_task').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.reload(),2500);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $(document).on("click", "#edit_route", function (e) {
        e.preventDefault();
        var e_r_id = $(this).data("e_r_id");
        var beat = $(this).data("beat");
        var r_name = $(this).data("r_name");
        var r_type = $(this).data("r_type");
        var r_int = $(this).data("r_int");
        alert(beat);

        $("#e_r_id").val(e_r_id);
        $("#e_beat").val(beat);
        $("#e_r_name").val(r_name);
        $("#e_r_type").val(r_type);
        $("#e_r_int_time").val(r_int);
    });

    $(document).on("click", "#edit_point", function (e) {
        e.preventDefault();
        var point_id = $(this).data("point_id");
        var point_alias = $(this).data("point_alias");
        $("#e_point_id").val(point_id);
        $("#e_pnt_alias").val(point_alias);
    });

    $(document).on("click", "#routeStatusBtn", function () {
        var r_id = $(this).data("r_id");
        var r_active = $(this).data("r_active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to update route status?");

        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({r_id:r_id,r_active:r_active,action_code:401}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.reload(); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#routeDeleteBtn", function (e) {
        e.preventDefault();
        var r_id = $(this).data("r_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to delete route?");
        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({r_id:r_id,action_code:402}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.reload(); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#pointDeleteBtn", function (e) {
        e.preventDefault();
        var point_id = $(this).data("point_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to delete point?");
        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({point_id:point_id,action_code:502}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.reload(); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#assignTaskDeleteBtn", function (e) {
        e.preventDefault();
        var task_id = $(this).data("task_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to delete assigned route task?");
        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({task_id:task_id,action_code:602}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.reload(); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#assignBeatDeleteBtn", function (e) {
        e.preventDefault();
        var assign_id = $(this).data("assign_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to delete guard assigned beat?");
        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({assign_id:assign_id,action_code:802}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.reload(); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#rtPointDeleteBtn", function (e) {
        e.preventDefault();
        var rt_id = $(this).data("rt_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to delete this captured routed task?");
        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({rt_id:rt_id,action_code:702}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.reload(); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
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
