(function () {

  "use strict";

  var uploadPostsViaUrl = {
    init: function () {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {
      this.$urlInput = $("#upload-url-input");
      this.$nextBtn = $("#upload-url-next-btn");
    },
    bindEvents: function () {
      this.$nextBtn.on('click', this, this.convertImage);
    },
    convertImage: function (event) {
      var self = event.data;
      var imageUrl = self.$urlInput.val();

      if (self.$urlInput.val().length === 0) {
        event.preventDefault();
        alert('Please fill the input with an image url');

      }

      self.imageExists(imageUrl, function(exists) {
        if(exists) {
          window.notBase64Image = true;
          $("#set-title-image-preview").attr('src', imageUrl);
        } else {
          alert('Please select an url for an image file.');
        }
      });
    },
    imageExists: function (url, callback) {
      var img = new Image();
      img.onload = function() { callback(true); };
      img.onerror = function() { callback(false); };
      img.src = url;
    }
  };

  uploadPostsViaUrl.init();

})();
