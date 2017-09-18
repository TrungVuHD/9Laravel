(function () {

  var reports = {
    init: function () {

      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {

      this.$homeItem = $(".detail-home-item");
      this.$reportInput = $("#content .report-input");
      this.$reportModal = $("#report-modal");
      this.$sendReport = this.$reportModal.find("#send-report");
      this.baseUrl = $("#base-url").val();
    },
    bindEvents: function () {

      this.$sendReport.on('click', this, this.reportPost);
    },
    reportPost: function (event) {

      var self  = event.data;

      event.preventDefault();

      var data = {
        post_id: self.$homeItem.attr('data-post-id'),
        reason: $('.report-input:checked').val()
      };

      var request = $.ajax({
        url: self.baseUrl+'/ajax/posts/report',
        method: "POST",
        data: data,
        dataType: 'json'
      });

      request.done(function( data ) {

        if(data.success == true) {

          alert('You successfully reported this post.');
        }
        self.$reportModal.modal('hide');
      });

      request.fail(function( jqXHR, textStatus ) {

        if(jqXHR.status == 401) {

          window.location.href = points.baseUrl+'/login';
        } else {
          alert('There was a problem with the reporting.');
        }

        self.$reportModal.modal('hide');
      });

    }
  };

  reports.init();

})();
