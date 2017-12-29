(function () {

  "use strict";

  var reports = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$homeItem = $(".detail-home-item");
      this.$content = $("#content");
      this.$reportModal = $("#report-modal");
      this.$sendReport = this.$reportModal.find("#send-report");
    },
    bindEvents: function () {
      this.$sendReport.on('click', this, this.reportPost);
    },
    reportPost: function (event) {
      event.preventDefault();
      var self  = event.data;
      var url = window.Laravel.baseUrl + '/ajax/posts/report';
      var data = {
        post_id: self.$homeItem.attr('data-post-id'),
        reason: $('.report-input:checked').val()
      };

      $.ajax({ url: url, method: "POST", data: data })
      .done(function () {
        alert('The post has been reported.');
        self.$reportModal.modal('hide');
      })
      .fail(function () {
        window.location.href = points.baseUrl+'/login';
        self.$reportModal.modal('hide');
      });
    }
  };

  reports.init();

})();
