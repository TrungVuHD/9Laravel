(function () {

  "use strict";

  var search ={
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$searchWrapper = $(".search.menu-item");
      this.$searchInput = $(".menu-search-input");
      this.$searchResults = $("#search-results");
    },
    bindEvents: function () {
      this.$searchWrapper.on('click', this, this.showSearch);
      this.$searchInput.on('click', this.stopClickPropagation);
      this.$searchInput.on('blur', this, this.hideSearch);
    },
    showSearch: function (event) {
      var $searchInput = event.data.$searchInput;
      $searchInput.toggleClass('hidden').focus();
    },
    hideSearch: function (event) {
      var $self = $(this);

      setTimeout(function () {
        $self.addClass('hidden');
        event.data.$searchResults.removeClass('visible');
      }, 200);
    },
    stopClickPropagation: function (event) {
      event.stopPropagation();
      event.preventDefault();
    }
  };

  search.init();

})();
