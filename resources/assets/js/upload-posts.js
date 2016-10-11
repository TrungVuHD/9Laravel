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
			this.$uploadBtn = $("#upload-post-btn");
		},
		bindEvents: function () {

			this.$showAtrributeInput.on('change', this, this.toggleAtribbute);
			this.$uploadBtn.on('click', $.proxy(this.uploadFiles, this));
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

				// cache the files object
				self.files = files;
			});
		},
		retrieveModalInput: function () {

			var input = {
				description: $("#upload-post-description").val(),
				nsfw: $("#upload-nsfw-input").val(),
				attribution: $("#post-attribute-input").val(),
				category: $(".upload-post-category").val(),
				url: $("#upload-post-url").val()
			};

			return input;
		},
		uploadFiles: function () {
			
			var input = this.retrieveModalInput();
			var uploadUrl = input.url + '?description='+input.description;
				uploadUrl += '&nsfw='+input.nsfw;
				uploadUrl += '&attribution='+input.attribution;
				uploadUrl += '&category='+input.category;

			this.files.each(function (file) {
				
				file.sendTo(uploadUrl);
			});
		},
		toggleAtribbute: function (event) {

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