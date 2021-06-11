$('div[data-pjax-container]').each(function () {
  const container = '#' + $(this).attr('id');

  $(this).siblings().each(function () {
    addPjax($(this), container);
  });
  addPjax($(this), container);
});

if ($.pjax) {
  $.pjax.defaults.scrollTo = false;
}

function addPjax(element, container) {
  element.find('form[data-pjax]').each(function () {
    const search = '#' + $(this).attr('id');

    function refresh() {
      let form = $(this).closest('form');
      $.pjax.reload({url: pathname, container, data: form.serialize(), method: form.attr('method') || 'get'});
    }

    body.on('change', `${search}:not([pjax-only-on-submit]) input`, refresh);
    body.on('change', `${search}:not([pjax-only-on-submit]) select`, refresh);
    body.on('submit', `${search}`, function () {
      refresh.bind(this)();
      return false;
    });
    body.on('pjax:end', container, () => loadMasks());
  });
}
