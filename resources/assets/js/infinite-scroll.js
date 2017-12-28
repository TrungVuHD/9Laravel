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
      this.start = 20;
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
      var url = '';
      var rendered = '';

      if (this.postCategory === undefined && this.categoryId === undefined) {
        return false;
      }

      if (this.lastAjaxCallWasEmpty === true) {
        return false;
      }

      if (this.$window.scrollTop() < ajaxPosition || this.waitForAjax) {
        return false;
      }

      if (allowedEndpoints.indexOf(this.postCategory) !== -1) {
        url = window.Laravel.baseUrl + this.postCategory + '/' + this.start;
      } else {
        url = window.Laravel.baseUrl + this.categoryId + '/' + this.start;
      }

      this.waitForAjax = true;

      $.ajax({
        url: url,
        method: "GET",
        dataType: 'json',
      })
      .done(function (data) {
        window.Mustache.parse(self.template);
        rendered = window.Mustache.render(self.template, { posts: data.posts });
        self.$content.append(rendered);
        self.start += self.noElements;
        self.waitForAjax = false;

        if (data.posts.length === 0) {
          self.lastAjaxCallWasEmpty = true;
        }
      });
    }
  };

  infiniteScroll.init();

})();
