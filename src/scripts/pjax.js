const container = '#' + $('div[data-pjax-container]').attr('id');
const search = '#' + $('form[data-pjax]').attr('id');
const pathname = window.location.pathname;

function refresh() {
    let form = $(this).closest('form');
    $.pjax.reload({url: pathname, container, data: form.serialize(), method: form.attr('method') || 'get'});
}

$(search + ' input').on('keyup change', refresh);
$(search + ' select').on('change', refresh);
