
</div>
</section>
<!-- Vendor -->
<script src="<?= public_path('vendor/jquery/jquery.js')?>"></script>
<script src=<?= public_path("vendor/jquery-browser-mobile/jquery.browser.mobile.js"); ?>></script>
<script src=<?= public_path("vendor/popper/umd/popper.min.js"); ?>></script>
<script src=<?= public_path("vendor/bootstrap/js/bootstrap.bundle.min.js"); ?>></script>
<script src=<?= public_path("vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"); ?>></script>
<script src=<?= public_path("vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"); ?>></script>
<script src=<?= public_path("vendor/common/common.js"); ?>></script>
<script src=<?= public_path("vendor/nanoscroller/nanoscroller.js"); ?>></script>
<script src=<?= public_path("vendor/magnific-popup/jquery.magnific-popup.js"); ?>></script>
<script src=<?= public_path("vendor/jquery-placeholder/jquery.placeholder.js"); ?>></script>
<script src=<?= public_path("vendor/select2/js/select2.js"); ?>></script>
<script src=<?= public_path("vendor/jquery-appear/jquery.appear.js"); ?>></script>
<script src=<?= public_path("vendor/jquery.easy-pie-chart/jquery.easypiechart.js"); ?>></script>
<script src=<?= public_path("vendor/flot/jquery.flot.js"); ?>></script>
<script src=<?= public_path("vendor/flot.tooltip/jquery.flot.tooltip.js"); ?>></script>
<script src=<?= public_path("vendor/flot/jquery.flot.pie.js"); ?>></script>
<script src=<?= public_path("vendor/flot/jquery.flot.categories.js"); ?>></script>
<script src=<?= public_path("vendor/flot/jquery.flot.resize.js"); ?>></script>
<script src=<?= public_path("vendor/jquery-sparkline/jquery.sparkline.js"); ?>></script>
<script src=<?= public_path("vendor/raphael/raphael.js"); ?>></script>
<script src=<?= public_path("vendor/morris/morris.js"); ?>></script>
<script src=<?= public_path("vendor/gauge/gauge.js"); ?>></script>
<script src=<?= public_path("vendor/fuelux/js/spinner.js"); ?>></script>
<script src=<?= public_path("vendor/snap.svg/snap.svg.js"); ?>></script>
<script src=<?= public_path("vendor/liquid-meter/liquid.meter.js"); ?>></script>
<script src=<?= public_path("vendor/autosize/autosize.js"); ?>></script>
<script src=<?= public_path("vendor/pnotify/pnotify.custom.js"); ?>></script>
<script src=<?= public_path("vendor/jquery-confirm/jquery-confirm.min.js"); ?>></script>
<script src=<?= public_path("vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"); ?>></script>
<script src=<?= public_path("vendor/bootstrapv5-wizard/jquery.bootstrap.wizard.js"); ?>></script>
<script src=<?= public_path("vendor/jquery-validation/jquery.validate.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/media/js/jquery.dataTables.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/media/js/dataTables.bootstrap5.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js"); ?>></script>
<script src=<?= public_path("vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js"); ?>></script>

<script src=<?= public_path("js/metronic.min.js"); ?>></script>
<script src=<?= public_path("js/theme.js"); ?>></script>
<script src=<?= public_path("js/custom.js"); ?>></script>
<script src=<?= public_path("js/theme.init.js"); ?>></script>
<script src=<?= public_path("js/views/view.staffs.js"); ?>></script>
<script src=<?= public_path("js/views/view.companies.js"); ?>></script>

<!-- create guard -->
<script>
    $("#w5-referral").change(function() {
        if ($(this).val() === "Agent") {
            $('.GuardReferralDiv').show();
            $('.AgentGuardReferralDiv').show();
            $('#w5-referral-name').attr('required', '');
            $('#w5-referral-name').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w5-referral-address').attr('required', '');
            $('#w5-referral-address').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w5-referral-phone').attr('required', '');
            $('#w5-referral-phone').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w5-referral-fee').attr('required', '');
            $('#w5-referral-fee').attr('data-error', 'Required. Select Nobody if you have no referral.');

        } else if ($(this).val() === "Existing Guard") {
            $('.GuardReferralDiv').show();
            $('.AgentGuardReferralDiv').hide();
            $('#w5-referral-name').attr('required', '');
            $('#w5-referral-name').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w5-referral-address').attr('required', '');
            $('#w5-referral-address').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w5-referral-phone').attr('required', '');
            $('#w5-referral-phone').attr('data-error', 'Required. Select Nobody if you have no referral.');
        } else if ($(this).val() === "Others") {
            $('.GuardReferralDiv').show();
            $('.AgentGuardReferralDiv').hide();
            $('#w5-referral-name').attr('required', '');
            $('#w5-referral-name').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w5-referral-address').attr('required', '');
            $('#w5-referral-address').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w5-referral-phone').attr('required', '');
            $('#w5-referral-phone').attr('data-error', 'Required. Select Nobody if you have no referral.');
        } else {
            $('.GuardReferralDiv').hide();
            $('.AgentGuardReferralDiv').hide();
            $('#w5-referral-name').removeAttr('required');
            $('#w5-referral-name').removeAttr('data-error');

            $('#w5-referral-address').removeAttr('required');
            $('#w5-referral-address').removeAttr('data-error');

            $('#w5-referral-phone').removeAttr('required');
            $('#w5-referral-phone').removeAttr('data-error');

            $('#w5-referral-fee').removeAttr('required');
            $('#w5-referral-fee').removeAttr('data-error');
        }
    });
    $("#w5-referral").trigger("change");

</script>
<!-- create guard -->

<!-- edit guard -->
<script>
    $("#w1-referral").change(function() {
        if ($(this).val() === "Agent") {
            $('.GuardReferralDiv').show();
            $('.AgentGuardReferralDiv').show();
            $('#w1-referral-name').attr('required', '');
            $('#w1-referral-name').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w1-referral-address').attr('required', '');
            $('#w1-referral-address').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w1-referral-phone').attr('required', '');
            $('#w1-referral-phone').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w1-referral-fee').attr('required', '');
            $('#w1-referral-fee').attr('data-error', 'Required. Select Nobody if you have no referral.');

        } else if ($(this).val() === "Existing Guard") {
            $('.GuardReferralDiv').show();
            $('.AgentGuardReferralDiv').hide();
            $('#w1-referral-name').attr('required', '');
            $('#w1-referral-name').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w1-referral-address').attr('required', '');
            $('#w1-referral-address').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w1-referral-phone').attr('required', '');
            $('#w1-referral-phone').attr('data-error', 'Required. Select Nobody if you have no referral.');
        } else if ($(this).val() === "Others") {
            $('.GuardReferralDiv').show();
            $('.AgentGuardReferralDiv').hide();
            $('#w1-referral-name').attr('required', '');
            $('#w1-referral-name').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w1-referral-address').attr('required', '');
            $('#w1-referral-address').attr('data-error', 'Required. Select Nobody if you have no referral.');

            $('#w1-referral-phone').attr('required', '');
            $('#w1-referral-phone').attr('data-error', 'Required. Select Nobody if you have no referral.');
        } else {
            $('.GuardReferralDiv').hide();
            $('.AgentGuardReferralDiv').hide();
            $('#w1-referral-name').removeAttr('required');
            $('#w1-referral-name').removeAttr('data-error');

            $('#w1-referral-address').removeAttr('required');
            $('#w1-referral-address').removeAttr('data-error');

            $('#w1-referral-phone').removeAttr('required');
            $('#w1-referral-phone').removeAttr('data-error');

            $('#w1-referral-fee').removeAttr('required');
            $('#w1-referral-fee').removeAttr('data-error');
        }
    });
    $("#w1-referral").trigger("change");

</script>
<!-- edit guard -->
</body>
</html>
