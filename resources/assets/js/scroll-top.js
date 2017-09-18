(function () {

  var scrollTop = {
    init: function () {

      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {

      this.$window = $(window);
      this.$scrollTop = $('#go-top');
    },
    bindEvents: function () {

      this.$window.on('scroll', $.proxy(this.onWindowScroll, this));
      this.$scrollTop.on('click', this.scrollTop);
    },
    onWindowScroll: function () {

      if( this.$window.scrollTop() > 800 ) {
        this.$scrollTop.removeClass('hidden');
      } else {
        this.$scrollTop.addClass('hidden');
      }
    },
    scrollTop: function () {

      $("html, body").animate({ scrollTop: 0 }, 800);
    }
  };

  scrollTop.init();

})();
