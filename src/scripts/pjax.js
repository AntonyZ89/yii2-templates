const container = '#' + $('div[data-pjax-container]').attr('id');
const search = '#' + $('form[data-pjax]').attr('id');
const pathname = window.location.pathname;

function refresh() {
    let params = $(this).closest('form').serialize();
    $.pjax.reload({url: pathname + '?' + params, container});
}

$('body').on('keyup change', search + ' input', refresh);
$('body').on('keyup change', search + ' select', refresh);

// $(search + ' input').on('keyup change', refresh);
// $(search + ' select').on('change', refresh);
