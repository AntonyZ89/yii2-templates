const pathname = window.location.pathname;
const body = $('body');

$('div[data-pjax-container]').each(function () {
  const container = '#' + $(this).attr('id');

  $(this).siblings().each(function () {
    $(this).find('form[data-pjax]').each(function () {
      const search = '#' + $(this).attr('id');

      function refresh() {
        let form = $(this).closest('form');
        $.pjax.reload({url: pathname, container, data: form.serialize(), method: form.attr('method') || 'get'});
      }

      body.on('keyup change', `${search}:not([pjax-only-on-submit]) input`, refresh);
      body.on('change', `${search}:not([pjax-only-on-submit]) select`, refresh);
      body.on('submit', `${search}[pjax-only-on-submit]`, function () {
        refresh.bind(this)();
        return false;
      });
      body.on('pjax:end', container, () => loadMasks());
    });
  })
});

if ($.pjax) {
  $.pjax.defaults.scrollTo = false;
}
