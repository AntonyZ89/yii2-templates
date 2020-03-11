const pathname = window.location.pathname;

function refresh() {
    let _ = $(this);
    let container = null;
    let _c = _;

    for (let i = 0; i < 20; i++) {
        _c = _c.parent();
        _c = _c.siblings('[data-pjax-container]');
        if (_c.length) {
            container = _c;
            break;
        }
    }

    if (container) {
        let form = _.closest('form');

        let container = '#' + container.attr('id');
        let params = form.serialize();

        let url = form.attr('data-pjax-url') || pathname;
        $.pjax.reload({url: url + '?' + params, container});
    }

}

$('body').on('keyup change', 'form[data-pjax] input', refresh);
$('body').on('change', 'form[data-pjax] select', refresh);
