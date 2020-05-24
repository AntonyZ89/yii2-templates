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
body.on('change', `${search}:not([pjax-only-on-submit]), ${search}:not([pjax-only-on-submit]) select`, refresh);
body.on('submit', `${search}[pjax-only-on-submit]`, function () {
  refresh.bind(this)();
  return false;
});

body.on('pjax:end', container, () => loadMasks());

body.on('click', 'button.reset-grid', function () {
  const form = $(search);
  form[0].reset();

  if (form.attr('pjax-only-on-submit')) {
    form.submit();
  } else {
    form.change();
  }
});

