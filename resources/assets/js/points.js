(function () {

  "use strict";

  var points = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$doc = $(document);
    },
    bindEvents: function () {
      this.$doc.on('click', '.thumbs-up', this, this.incrementPoints);
      this.$doc.on('click', '.thumbs-down', this, this.decrementPoints);
    },
    incrementPoints: function (event) {
      event.preventDefault();
      var $parentElement = $(this).parents('.home-item');

      $.ajax({
        url: window.Laravel.baseUrl + '/ajax/points/increment',
        method: "POST",
        data: { post_id: $parentElement.data('post-id') },
        dataType: 'json'
      })
      .done(function () {
        var $points = $parentElement.find('.points');
        var noPoints = parseInt($points.html());
        var $thumbsUpElement = $parentElement.find('.thumbs-up');

        $points.html(noPoints+1);
        $thumbsUpElement.addClass('active');
      })
      .fail(function (response) {
        if (response.status === 401) {
          window.location.href = window.Laravel.baseUrl + '/login';
        }
      });
    },
    decrementPoints: function (event) {
      event.preventDefault();
      var $parentElement = $(this).parents('.home-item');

      $.ajax({
        url: window.Laravel.baseUrl + '/ajax/points/decrement',
        method: "POST",
        data: { 'post_id': $parentElement.data('post-id') },
        dataType: 'json'
      })
      .done(function () {
        var $points = $parentElement.find('.points');
        var noPoints = parseInt($points.html());
        var $activeElement = $parentElement.find('.active');

        $points.html(noPoints-1);
        $activeElement.removeClass('active');
      })
      .fail(function(response) {
        if (response.status === 401) {
          window.location.href = window.Laravel.baseUrl + '/login';
        }
      });
    }
  };

  points.init();

})();
