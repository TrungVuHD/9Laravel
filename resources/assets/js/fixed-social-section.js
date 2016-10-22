(function () {

	var fixedSocialSection = {
		init: function () {

			this.cacheDom();
			this.bindEvents();
			this.menuCheck();
		},
		cacheDom: function () {

			this.$socialSection = $('.fixed-social-section');
			this.$topMenu = $('.top-menu');
			this.$pageContainer = $('.page-container');
			this.$window = $(window);
			this.$image = $('.detail-home-item img');
		},
		bindEvents: function () {

			this.$window.on('scroll', this, this.onWindowScroll);
		},
		menuCheck: function () {

			if(this.$socialSection.length == 1) {
				
				this.$topMenu.addClass('static');
				this.$pageContainer.addClass('small-top-margin');
			}
		},
		onWindowScroll: function (event) {

			var self = event.data;
			var width = self.$image.width();

			if(self.$window.scrollTop() > 200) {

				self.$socialSection.addClass('fixed');
				self.$socialSection.css('width', width);
			} else {
				self.$socialSection.removeClass('fixed');
			}
		}
	}

	fixedSocialSection.init();

})();