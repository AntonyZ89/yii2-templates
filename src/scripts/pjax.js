$('div[data-pjax-container]').each(function () {
  const self = $(this),
      target = self.data('target'),
      container = '#' + self.attr('id');

  self.siblings().each(function () {
    addPjax($(this), container);
  });

  addPjax(self, container);
  target && addPjax($(`#${target}`), container);
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
