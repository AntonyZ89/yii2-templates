const container = '#' + $('div[data-pjax-container]').attr('id');
const search = '#' + $('form[data-pjax]').attr('id');
const pathname = window.location.pathname;
const body = $('body');

function refresh() {
  let form = $(this).closest('form');
  $.pjax.reload({url: pathname, container, data: form.serialize(), method: form.attr('method') || 'get'});
}

if ($.pjax) {
  $.pjax.defaults.scrollTo = false;
}

body.on('keyup change', `${search}:not([pjax-only-on-submit]) input`, refresh);
body.on('change', `${search}:not([pjax-only-on-submit]) select`, refresh);
body.on('submit', `${search}[pjax-only-on-submit]`, function () {
  refresh.bind(this)();
  return false;
});
