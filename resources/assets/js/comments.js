(function () {

  "use strict";

  var comments = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$reply = $('.reply-anchor');
      this.$commentsBody = $('.comments-body');
    },
    bindEvents: function () {
      this.$reply.on('click', this, this.replyToComment)
    },
    replyToComment: function (event) {
      event.preventDefault();
      var $content = $('#content');
      $content.find('.comments-body-clone').remove();
      var self = event.data;
      var $parentComment = $(this).parents('.comment');
      var parentCommentId = $parentComment.attr('data-comment-id');
      var $commentsBodyClone = self.$commentsBody.clone();
      var $appendElement = $parentComment;

      if($content.find('.comment[data-parent-id='+parentCommentId+']').length > 0) {
        $appendElement = $content.find('.comment[data-parent-id='+parentCommentId+']').last();
      }

      $commentsBodyClone.addClass('comments-body-clone comment-small');
      $commentsBodyClone.find('textarea').html('');
      $commentsBodyClone.find('#comment-id').val( parentCommentId );
      $commentsBodyClone.attr('data-parent-id');

      $appendElement.after($commentsBodyClone);
    }
  };

  comments.init();

})();
