$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size

(function(window, document, undefined) {
    $(window).on("load resize", function() {
        topOffset = 64;
        widthOffset = 202;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
            widthOffset = 0;
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }

        width = width - widthOffset;

        if (width < 1) width = 1;
        if (width > widthOffset) {
            $("#page-wrapper").css("width", (width) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    window.ajaxFormSubmitMsgHandlerSuccess = function(data) {
        var msg = '';
        $.each(data.messages, function(i, e) {
            msg += e + '\n';
        })
        //Helper
        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

        if (data.status == 'error' || data.status == 'warning') {
            swal({
                title: toTitleCase(data.status),
                text: msg,
                timer: 3000,
                icon: data.status
            });
        }

        if (data.status == 'success') {
            swal({
                    title: toTitleCase(data.status),
                    text: msg,
                    icon: data.status,
                    timer: 3000,                  
                }).then(
                  function(result) {                    
                    if (typeof(data.returnurl) != 'undefined' && data.returnurl) {
                        location.href = data.returnurl;
                    }
                  }, function(dismiss) {
                     swal.close();
                  }
                );
        }
    };
    window.ajaxFormSubmitMsgHandlerError = function(data) {
        swal({
            title: "Error",
            text: data.statusText,
            timer: 3000,
            icon: 'error'
        });
    };
})(window, document);


$(function() {

    $.fn.serializeControls = function() {
      var data = {};

      function buildInputObject(arr, val) {
        if (arr.length < 1)
          return val;  
        var objkey = arr[0];
        if (objkey.slice(-1) == "]") {
          objkey = objkey.slice(0,-1);
        }  
        var result = {};
        if (arr.length == 1){
          result[objkey] = val;
        } else {
          arr.shift();
          var nestedVal = buildInputObject(arr,val);
          result[objkey] = nestedVal;
        }
        return result;
      }

      $.each(this.serializeArray(), function() {
        var val = this.value;
        var c = this.name.split("[");
        var a = buildInputObject(c, val);
        $.extend(true, data, a);
      });
      
      return data;
    }

    $.fn.extend({
        donetyping: function (callback, timeout) {
            if (timeout == undefined)
                timeout = 500;
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too premptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;

                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
}( jQuery ));

