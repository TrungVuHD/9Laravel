(function () {

  "use strict";

  var gif = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$content = $("#content");
    },
    bindEvents: function () {
      this.$content.on('click', '.gif-wrapper-link', this.toggleGIF);
    },
    toggleGIF: function (event) {
      event.preventDefault();

      var $image = $(this).find('.img-responsive');
      var imageHref = $image.attr('src');
      var rawHref = imageHref.substring(0, imageHref.length - 4);
      var $gifText = $(this).find(".gif-text");

      if (imageHref.slice(-3) === 'png') {
        $image.attr('src', rawHref+'.gif');
        $gifText.addClass('hidden');
      }

      if (imageHref.slice(-3) === 'gif') {
        $image.attr('src', rawHref+'.png');
        $gifText.removeClass('hidden');
      }
    }
  };

  gif.init();

})();
