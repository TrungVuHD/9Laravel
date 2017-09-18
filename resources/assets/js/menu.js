(function () {

  'use strict';

  var topSubmenu = {
    init: function () {

      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {

      this.$doc = $('body, html');
      this.$hasSubmenu = $('.has-submenu');
      this.$submenu = $('.sub-menu');
    },
    bindEvents: function () {

      this.$doc.on('click', this, this.hideAllSubmenus);
      this.$hasSubmenu.on('click', this.toggleSubmenu);
    },
    toggleSubmenu: function (event) {

      event.stopPropagation();

      var $currentSubmenu = $(this).find('.sub-menu');
      $currentSubmenu.toggleClass('hidden');
    },
    hideAllSubmenus: function (event) {

      var $submenus = event.data.$submenu;
      $submenus.addClass('hidden');
    }
  };

  topSubmenu.init();

})();
