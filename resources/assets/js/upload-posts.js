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
			this.$pickSectionModal = $("#pick-section-modal");
			this.$showAtrributeInput = $("#attribbute-input-shown");
			this.$attributeInput = $(".attribute-form-group");
			this.$uploadBtn = $("#upload-post-btn");
			this.$imagePreview = $("#set-title-image-preview");
			this.baseUrl = $("#base-url").val();

			this.$validateSetTitle = $(".validate-set-post");
			this.$postTitle = $("#upload-post-description");
		},
		bindEvents: function () {

			this.$showAtrributeInput.on('change', this, this.toggleAtribbute);
			this.$uploadBtn.on('click', $.proxy(this.uploadFiles, this));
			this.$validateSetTitle.on('click', this, this.validateSetTitleModal);
		},
		validateSetTitleModal: function (event) {

			var self = event.data;

			if( self.$postTitle.val() == "" ){
				alert('Please provide a title for your post');
				self.$postTitle.focus();
				event.preventDefault();
				return false;
			}

			if( self.$imagePreview.attr('href') == self.baseUrl+"/img/logo.png" ) {

				alert('You haven\'t chosen an image yet');
				event.preventDefault();
				return false;
			} 
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
				url: $("#upload-post-url").val(),
				notBase64Image: window.notBase64Image == false ? false : true,
			};

			return input;
		},
		uploadFiles: function () {

			var input = this.retrieveModalInput();
			var self = this;

			if(input.category == undefined){
				alert('Please select a category.');
				return false;
			}

			var request = $.ajax({
				url: input.url,
				method: "POST",
				data: input,
				dataType: 'json'
			});

			request.done(function( data ) {
				
				self.$postTitle.val('');
				self.$pickSectionModal.modal('hide');
				
				if(data.success == true) {
					alert('Congratulations, you uploaded a post!');
				} else {
					alert("Error. Something went wrong with the file upload.");
				}
			});

			request.fail(function( jqXHR, textStatus ) {
				alert("Error. Something went wrong with the file upload.");
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