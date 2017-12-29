(function () {

  "use strict";

  var infiniteScroll = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$window = $(window);
      this.$doc = $(document);
      this.$content = $("#content");
      this.offset = 20;
      this.limit = 20;
      this.categoryId = $("#category-id").val();
      this.postCategory = $("#posts-category").val();
      this.template = $("#home-item-template").html();
      this.lastAjaxCallWasEmpty = false;
      this.waitForAjax = false;
    },
    bindEvents: function () {
      this.$window.on('scroll', $.proxy(this.onWindowScroll, this));
    },
    onWindowScroll: function () {
      var allowedEndpoints = [ 'fresh', 'trending', 'hot' ];
      var self = this;
      var ajaxPosition = this.$doc.height() - this.$window.height() - 200;
      var allowedEndpoint = allowedEndpoints.indexOf(this.postCategory) !== -1;
      var rendered = '';
      var url;

      var undefinedVariables = this.postCategory === undefined && this.categoryId === undefined;
      var emptyAjaxCall = this.lastAjaxCallWasEmpty === true;
      var unsatisfiedScrollPosition = this.$window.scrollTop() < ajaxPosition || this.waitForAjax;
      var undefinedCategoryId = !allowedEndpoint && this.categoryId === 0;

      if (undefinedVariables || emptyAjaxCall || unsatisfiedScrollPosition || undefinedCategoryId) {
        return false;
      }

      this.waitForAjax = true;

      url = window.Laravel.ajaxUrl + 'posts/' + this.categoryId;
      if (allowedEndpoint) {
        url = window.Laravel.ajaxUrl + 'posts/' + this.postCategory;
      }

      $.ajax({
        url: url,
        method: "GET",
        data: {
          page: parseInt(this.offset / this.limit)
        }
      })
      .done(function (response) {
        var data = response.data;
        window.Mustache.parse(self.template);
        rendered = window.Mustache.render(self.template, { posts: data });
        self.$content.append(rendered);
        self.offset += self.limit;
        self.waitForAjax = false;

        if (data.length === 0) {
          self.lastAjaxCallWasEmpty = true;
        }
      });
    }
  };

  infiniteScroll.init();

})();
