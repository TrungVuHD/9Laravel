(function () {

  var search ={
    init: function () {

      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {

      this.$searchWrapper = $(".search.menu-item")
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
      var url = $("#base-url").val()+'/ajax/search';
      var data = {
        keyword: searchKeyword
      };
      var self = event.data;

      if(searchKeyword.length > 1) {

        var request = $.ajax({
          url: url,
          method: "GET",
          data: data,
          dataType: 'json'
        });

        request.done(function( data ) {

          var results = {
              results: data
          };

          var template = $('#search-template').html();
          var rendered = Mustache.render(template, results);

          self.$searchResults.html(rendered);
          self.$searchResults.addClass('visible');

        });

        request.fail(function( jqXHR, textStatus ) {

          //alert( "Request failed: " + textStatus );
        });
      }
    }
  }

  search.init();

})();
