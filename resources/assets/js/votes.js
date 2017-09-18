(function () {

  var votes = {
    init: function () {

      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {

      this.$upVote = $(".up-vote-comment");
      this.$downVote = $(".down-vote-comment");
      this.baseUrl = $('#base-url').val();
    },
    bindEvents: function () {

      this.$upVote.on('click', this, this.upVoteComment);
      this.$downVote.on('click', this, this.downVoteComment);
    },
    upVoteComment: function (event) {

      event.preventDefault();

      var $parentElement = $(this).parents('.comment');
      var baseUrl = event.data.baseUrl;
      var data = {
        'comment_id': $parentElement.attr('data-comment-id')
      };

      var request = $.ajax({
        url: baseUrl+'/ajax/comments/increment',
        method: "POST",
        data: data,
        dataType: 'json'
      });

      request.done(function( data ) {

        if(data.success == true) {

          var $points = $parentElement.find('.comment-points');
          var noPoints = parseInt($points.html());
          var $upVoteElement = $parentElement.find('.up-vote-comment');

          $points.html(noPoints+1);
          $upVoteElement.addClass('active');
        }
      });

      request.fail(function( jqXHR, textStatus ) {

        if(jqXHR.status == 401) {

          window.location.href = comments.baseUrl+'/login';

        }
      });
    },
    downVoteComment: function (event) {

      event.preventDefault();

      var $parentElement = $(this).parents('.comment');
      var baseUrl = event.data.baseUrl;
      var data = {
        'comment_id': $parentElement.attr('data-comment-id')
      };

      var request = $.ajax({
        url: baseUrl+'/ajax/comments/decrement',
        method: "POST",
        data: data,
        dataType: 'json'
      });

      request.done(function( data ) {

        if(data.success == true) {

          var $points = $parentElement.find('.comment-points');
          var noPoints = parseInt($points.html());
          var $upVoteElement = $parentElement.find('.up-vote-comment');

          $points.html(noPoints-1);
          $upVoteElement.removeClass('active');
        }
      });

      request.fail(function( jqXHR, textStatus ) {

        if(jqXHR.status == 401) {

          window.location.href = comments.baseUrl+'/login';
        }
      });
    }
  };

  votes.init();

})();
