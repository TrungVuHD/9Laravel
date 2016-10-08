(function () {
	
	'use strict';

	var fileUploads = {
		images: [],
		init: function () {

			this.cacheDom();
			this.bindEvents();
			this.enableFileDrop();
		},
		cacheDom: function () {

			this.$uploadModal = $("#upload-modal");
			this.$setTitleModal = $("#set-title-modal");
			this.$showAtrributeInput = $("#attribbute-input-shown");
			this.$attributeInput = $(".attribute-form-group");
		},
		bindEvents: function () {

			this.$showAtrributeInput.on('change', this, this.toggleAtribbute);
		},
		enableFileDrop: function () {

			var self = this;
			var options = {iframe: {url: 'upload.php'}};
			var uploadPosts = new FileDrop('upload-post', options);

			uploadPosts.multiple(false);
			uploadPosts.event('send', function (files) {

				// navigate between modals 
				self.$uploadModal.modal('hide');
				self.$setTitleModal.modal('show');

				// preview the image 
				files.images().each(function (file) {
					file.readData(
						function (uri) {
							$("#set-title-image-preview").attr('src', uri); 
						},
						function (error) {
							alert('Ph, noes! Cannot read your image.')
						},
						'uri'
					);
				});

				self.images = files.images();


				/*
				files[0].readData(
					function (str) {
					
						console.log(str);
						zone.el.value = str 

					},
					function (e) { alert('Terrible error!') },
					'text'
				);

				files.each(function (file) {

					file.sendTo('upload.php')
				})
				*/

			});
		},
		toggleAtribbute: function (event) {

			console.log('toggle the ATTRIVBute');
			var $self = event.data;
			
			if($(this).is(':checked')) {
				$self.$attributeInput.removeClass('hidden');
			} else {
				$self.$attributeInput.addClass('hidden');
			}
		}
	};

	fileUploads.init();
})();