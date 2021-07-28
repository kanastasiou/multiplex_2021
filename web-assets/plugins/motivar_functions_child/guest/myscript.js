(function($) {
  "use strict";
  $(document).ready(function() {
  	myresize();
  $(window).resize(function() {
      myresize();
    });

  });

 function myresize() {

  }

  if ($('.eml').length > 0) {
    $('.eml').each(function () {
      var link = '<a href="mailto:' + $(this).attr('data-pre') + '@' + $(this).attr('data-domain') + '">' + $(this).attr('data-pre') + '@' + $(this).attr('data-domain') + '</a>';
      $(this).append(link);
    });
  }

})(jQuery);