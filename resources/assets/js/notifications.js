(function () {

  "use strict";

  var notifications = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$doc= $("html, body");
      this.$notificationsBtn = $(".menu-notifications, .menu-notifications a");
      this.$notifications = $(".notifications-wrapper");
    },
    bindEvents: function () {
      this.$notificationsBtn.on('click', this, this.showNotifications);
      this.$doc.on('click', this, this.hideNotifications);
    },
    showNotifications: function (event) {
      event.preventDefault();
      event.stopPropagation();
      var self = event.data;

      self.$notifications.removeClass('hidden');
    },
    hideNotifications: function (event) {
      var self = event.data;
      self.$notifications.addClass('hidden');
    }
  };

  notifications.init();

})();
