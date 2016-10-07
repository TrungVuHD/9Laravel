(function (){

	"use strict";

	var menu = {
		init: function () {

			this.cacheDom();
			this.bindEvents();
		},
		cacheDom: function () {

			this.$body = $("body, html");
			this.$pageContainer = $('.page-container');
			this.$sections = $(".sections-wrapper");
			this.$sectionsList = this.$sections.find('.sections-list');
			this.$search = $(".search.menu-item");
			this.$searchInput = $('.menu-search-input');
		},
		bindEvents: function () {

			this.$sections.on('click', this, this.toggleSections );
			this.$search.on('click', this, this.toggleSearch );
			this.$pageContainer.on('click', $.proxy(this.hideMenuInteractions,this));
			this.$body.on('click', $.proxy(this.hideMenuInteractions,this));
		},
		toggleSections: function (event) {

			event.stopPropagation();
			event.data.$sectionsList.removeClass('hidden');
		},
		toggleSearch: function (event) {

			event.stopPropagation();
			event.data.$searchInput.removeClass('hidden');
		},
		hideMenuInteractions: function () {

			if(!this.$sectionsList.hasClass('hidden')) {
				this.$sectionsList.addClass('hidden');
			}

			if(!this.$searchInput.hasClass('hidden')) {
				this.$searchInput.addClass('hidden');
			}
		}
	};
	
	menu.init();

})();