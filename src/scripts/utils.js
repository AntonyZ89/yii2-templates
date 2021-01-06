const pathname = window.location.pathname;
const body = $('body');

function loadMasks() {
    const datepicker = $('input[data-krajee-kvdatepicker]');
    const dateRangePicker = $('input[data-krajee-daterangepicker]');

    datepicker.length && datepicker.inputmask({mask: '99/99/9999'});
    dateRangePicker.length && dateRangePicker.inputmask({mask: '99/99/9999 - 99/99/9999'});

    body.on('blur', 'input[data-krajee-datecontrol]', function () {
        $(this).data('datecontrol').validate();
    });
}

loadMasks();
