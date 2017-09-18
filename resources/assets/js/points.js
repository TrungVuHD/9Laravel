(function () {

  "use strict";

  var points = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$content = $("#content");
      this.baseUrl = $('#base-url').val();
    },
    bindEvents: function () {
      this.$content.on('click', '.thumbs-up', this, this.incrementPoints);
      this.$content.on('click', '.thumbs-down', this, this.decrementPoints);
    },
    incrementPoints: function (event) {
      event.preventDefault();

      var $parentElement = $(this).parents('.home-item');
      var baseUrl = event.data.baseUrl;
      var data = {
        postId: $parentElement.data('post-id')
      };

      var request = $.ajax({
        url: baseUrl+'/ajax/points/increment',
        method: "POST",
        data: data,
        dataType: 'json'
      });

      request.done(function( data ) {
        if(data.success === true) {
          var $points = $parentElement.find('.points');
          var noPoints = parseInt($points.html());
          var $thumbsUpElement = $parentElement.find('.thumbs-up');

          $points.html(noPoints+1);
          $thumbsUpElement.addClass('active');
        }
      });

      request.fail(function( jqXHR ) {
        if(jqXHR.status === 401) {
          window.location.href = points.baseUrl+'/login';
        }
      });
    },
    decrementPoints: function (event) {
      event.preventDefault();

      var $parentElement = $(this).parents('.home-item');
      var baseUrl = event.data.baseUrl;
      var data = {
        'postId': $parentElement.data('post-id')
      };

      var request = $.ajax({
        url: baseUrl+'/ajax/points/decrement',
        method: "POST",
        data: data,
        dataType: 'json'
      });

      request.done(function( data ) {
        if(data.success) {
          var $points = $parentElement.find('.points');
          var noPoints = parseInt($points.html());
          var $activeElement = $parentElement.find('.active');

          $points.html(noPoints-1);
          $activeElement.removeClass('active');
        } else {
        }
      });

      request.fail(function( jqXHR ) {
        if (jqXHR.status === 401) {
          window.location.href = points.baseUrl+'/login';
        } else {
          //alert( "There was a problem with your request.");
        }
      });
    }
  };

  points.init();

})();
