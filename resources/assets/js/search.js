(function () {

	//show or hide the search input located inside the menu 
	$(".search.menu-item")
		.on('click', function () {

			$(this)
				.find('.menu-search-input')
				.toggleClass('hidden')
				.focus();
		});

	$(".menu-search-input")
		.on('click', function(event) {

			event.stopPropagation();
		})
		.on('blur', function(event) {

			$(this).addClass('hidden');
		});

})();