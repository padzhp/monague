$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 64;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});


(function(window, document, undefined) {
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