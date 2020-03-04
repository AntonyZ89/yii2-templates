$('document').on('blur', 'input[data-krajee-datecontrol]', function () {
    $(this).data('datecontrol').validate();
});

$('input[data-krajee-datecontrol]').inputmask({
    mask: '99/99/9999'
});
