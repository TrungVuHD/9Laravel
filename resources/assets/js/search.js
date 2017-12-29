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
      this.$searchInput.on('keypress', this, this.search);
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
    },
    search: function (event) {
      var searchKeyword = $(this).val();
      var url = window.Laravel.baseUrl + '/ajax/search';
      var data = { keyword: searchKeyword };
      var self = event.data;

      if (searchKeyword.length < 1) {
        return false;
      }

      $.ajax({ url: url, data: data })
      .done(function (data) {
        var template = $('#search-template').html();
        var rendered = window.Mustache.render(template, { results: data });

        self.$searchResults.html(rendered);
        self.$searchResults.addClass('visible');
      });
    }
  };

  search.init();

})();
