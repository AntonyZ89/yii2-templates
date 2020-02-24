const container = '#' + $('div[data-pjax-container]').attr('id');
const search = '#' + $('form[data-pjax]').attr('id');
const pathname = window.location.pathname;

function refresh() {
    let params = $(this).closest('form').serialize();
    $.pjax.reload({url: pathname + '?' + params, container});
}

$(search + ' input').on('keyup change', refresh);
$(search + ' select').on('change', refresh);
