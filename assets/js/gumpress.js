(function ($) {

  function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp('([?&])' + key + '=.*?(&|$)', 'i');
    var separator = uri.indexOf('?') !== -1 ? '&' : '?';
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + '=' + value + '$2');
    } else {
      return uri + separator + key + '=' + value;
    }
  }

  $('#versions').on('change', function (e) {
    var $gumpressBtn = $('.gumpress-button');
    var versionName = this.value;
    var productUrl = updateQueryStringParameter(
      $gumpressBtn.attr('href'),
      'variant',
      versionName
    );
    $gumpressBtn.attr('href', productUrl);
  });
})(jQuery);
