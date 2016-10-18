(function () {
	
	'use strict';

	var fileUploads = {
		images: [],
		init: function () {

			this.enableCSRFToken()
			this.cacheDom();
			this.bindEvents();
			this.enableFileDrop();
		},
		enableCSRFToken: function () {
			
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
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
			var options = {iframe: {url: $("#upload-post-url").val()}};
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
				category: $(".upload-post-category:checked").val(),
				image: $("#set-title-image-preview").attr('src'),
				url: $("#upload-post-url").val()
			};

			return input;
		},
		uploadFiles: function () {

			var input = this.retrieveModalInput();

			console.dir(input);

			var request = $.ajax({
				url: input.url,
				method: "POST",
				data: input,
				dataType: 'json'
			});

			request.done(function( data ) {
				
				
			});

			request.fail(function( jqXHR, textStatus ) {
				alert( "Request failed: " + textStatus );
			});
			/*			
			
			var input = this.retrieveModalInput();
			var uploadUrl = input.url + '?description='+input.description;
				uploadUrl += '&nsfw='+input.nsfw;
				uploadUrl += '&attribution='+input.attribution;
				uploadUrl += '&category='+input.category;

			this.files.each(function (file) {
				
				console.log(uploadUrl);

				file.sendTo(uploadUrl);
			});
			*/
			
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