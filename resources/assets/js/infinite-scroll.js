(function () {

  var infiniteScroll = {
    init: function () {

      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function () {

      this.$window = $(window);
      this.$doc = $(document);
      this.$content = $("#content");
      this.start = 20;
      this.noElements = 20;
      this.categoryId = $("#category-id").val();
      this.baseUrl = $('#base-url').val()+'/ajax/posts/';
      this.postCategory = $("#posts-category").val();
      this.template = $("#home-item-template").html();
      this.lastAjaxCallWasEmpty = false;
      this.waitForAjax = false;
    },
    bindEvents: function () {

      this.$window.on('scroll', $.proxy(this.onWindowScroll, this));

    },
    onWindowScroll: function () {

      var self = this;
      var ajaxPosition = this.$doc.height() - this.$window.height() - 200;
      var url = '';
      var rendered = '';

      if( this.postCategory == undefined && this.categoryId == undefined) {
        return false;
      }

      if( this.lastAjaxCallWasEmpty == true ) {
        return false;
      }

      switch(this.postCategory) {
        case 'fresh':
          url = this.baseUrl+'fresh/'+this.start+'/'+this.noElements;
        break;
        case 'trending':
          url = this.baseUrl+'trending/'+this.start+'/'+this.noElements;
        break;
        case 'hot':
          url = this.baseUrl+'hot/'+this.start+'/'+this.noElements;
        break;
        default:
          url = this.baseUrl+this.categoryId+'/'+this.start;
        break;
      }

      if( this.$window.scrollTop() >= ajaxPosition && !this.waitForAjax ) {

        this.waitForAjax = true;

        var request = $.ajax({
          url: url,
          method: "GET",
          dataType: 'json',
        });

        request.done(function( data ) {

          if(data.success == true) {

            processedData = {
              posts: data.posts
            };

            Mustache.parse(self.template);
            rendered = Mustache.render(self.template, processedData);
            self.$content.append(rendered);
            self.start += self.noElements;
            self.waitForAjax = false;

            if(data.posts.length == 0) {
              self.lastAjaxCallWasEmpty = true;
            }
          }

        });
      }
    }
  };

  infiniteScroll.init();

})();
