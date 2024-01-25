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

    $("form[name='add_beat']").validate({
        rules: {
            bt_name: "required",
            bt_address: "required",
            bt_longitude: "required",
            bt_latitude: "required",
        },
        messages: {
            bt_name: "",
            bt_address: "",
            bt_longitude: "",
            bt_latitude: ""
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
                url: "../controllers/v7/create-company-beat.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) { document.getElementById('add_beat').reset();sendSuccessResponse('Success',data.message); }
                    else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_beat']").validate({
        rules: {
            bt_name: "required",
            bt_address: "required",
            bt_longitude: "required",
            bt_latitude: "required",
        },
        messages: {
            bt_name: "",
            bt_address: "",
            bt_longitude: "",
            bt_latitude: "",
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
                url: "../controllers/v7/update-company-beat.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_beat').reset();
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

    $("form[name='assign_beat']").validate({
        rules: {
            ass_beats: "required",
            ass_guards: "required"
        },
        messages: {
            ass_beats: "select a beat",
            ass_guards: "select a guard"
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
                url: "../controllers/v7/assign-beat-to-guard.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('assign_beat').reset();
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

    $(document).on("click", "#beatStatusBtn", function () {
        var b_id = $(this).data("b_id");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        var res = confirm("Are you sure you want to update beat status?");

        if (res===true){
            $.ajax({
                url: "../controllers/v7/actions-company.php", type: "POST",
                data: JSON.stringify({b_id:b_id,active:active,action_code:101}),
                success: function (data) {
                    if (data.status ===1){
                        new PNotify({title: 'Success', text: data.message, type: 'success'});
                        setTimeout(function () {window.location.replace('list-beats'); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    $(document).on("click", "#beatDeleteBtn", function (e) {
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
                        setTimeout(function () {window.location.replace('list-beats'); }, 500);
                    } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                },
                error: function (errData)  {},
                complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
            });
        } else { submitButton.val(submitButtonText).attr('disabled', false); }
    });

    var datatableInit = function() {
        var $table = $('#datatable-tabletools');

        var table = $table.dataTable({
            "pageLength": 50,
            "aLengthMenu": [[50, 100, 200, 500, -1], [50, 100, 200, 500, "All"]],
            "order": false,
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
                        $('#datatable-tabletools').find('tbody tr:first-child td').each(function(){
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