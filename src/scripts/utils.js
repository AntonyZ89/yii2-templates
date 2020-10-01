$('body').on('blur', 'input[data-krajee-datecontrol]', function () {
  $(this).data('datecontrol').validate();
});

(function () {
    $('input[data-krajee-kvdatepicker]').inputmask({
        mask: '99/99/9999'
    });

    $('input[data-krajee-daterangepicker]').inputmask({
        mask: '99/99/9999 - 99/99/9999'
    });
})()
