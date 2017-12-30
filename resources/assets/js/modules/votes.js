(function () {

  "use strict";

  var votes = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$upVote = $(".up-vote-comment");
      this.$downVote = $(".down-vote-comment");
    },
    bindEvents: function () {
      this.$upVote.on('click', this, this.upVoteComment);
      this.$downVote.on('click', this, this.downVoteComment);
    },
    upVoteComment: function (event) {
      event.preventDefault();

      var $parentElement = $(this).parents('.comment');

      $.ajax({
        url: window.Laravel.baseUrl + '/ajax/comments/increment',
        method: "POST",
        data: {
          'comment_id': $parentElement.attr('data-comment-id')
        },
      })
      .done(function() {
        var $points = $parentElement.find('.comment-points');
        var noPoints = parseInt($points.html());
        var $upVoteElement = $parentElement.find('.up-vote-comment');

        $points.html(noPoints+1);
        $upVoteElement.addClass('active');
      })
      .fail(function (response) {
        if (response.status === 401) {
          window.location.href = window.Laravel.baseUrl + '/login';
        }
      });
    },
    downVoteComment: function (event) {
      event.preventDefault();

      var $parentElement = $(this).parents('.comment');
      var data = {
        'comment_id': $parentElement.attr('data-comment-id')
      };

      $.ajax({
        url: window.Laravel.baseUrl + '/ajax/comments/decrement',
        method: "POST",
        data: data,
      })
      .done(function (response) {
        var $points = $parentElement.find('.comment-points');
        var noPoints = parseInt($points.html());
        var $upVoteElement = $parentElement.find('.up-vote-comment');

        if (response.data.id === null) {
          return false;
        }

        if (noPoints === 0) {
          $upVoteElement.removeClass('active');
          return false;
        }

        $points.html(noPoints-1);
        $upVoteElement.removeClass('active');
      })
      .fail(function (response) {
        if (response.status === 401) {
          window.location.href = window.Laravel.baseUrl + '/login';
        }
      });
    }
  };

  votes.init();

})();
