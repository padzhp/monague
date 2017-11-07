window.dashboard = {
    index:{
        init: function() {            

            $(document).on('click','.btn-activate-user',function(e){
                var id = $(this).data('id');
                var $btn = $(this).button('loading');
                var container = $(this).parent();
                console.log(id);

                jQuery.ajax({
                    url: "/dashboard/index/activate",
                    data: { id: id },                                
                    dataType: "json",                        
                }).done(function(data){
                    container.html('<button data-id="'+ id +'" class="btn btn-sm btn-red btn-deactivate-user">DEACTIVATE</button>');
                    window.ajaxFormSubmitMsgHandlerSuccess(data);
                }).fail(ajaxFormSubmitMsgHandlerError);
            } );


            $(document).on('click','.btn-deactivate-user',function(e){
                var id = $(this).data('id');
                var $btn = $(this).button('loading');
                var container = $(this).parent();

                jQuery.ajax({
                    url: "/dashboard/index/deactivate",
                    data: { id: id },                                
                    dataType: "json",                        
                }).done(function(data){
                    container.html('<button data-id="'+ id +'" data-loading-text="Deactivating..." class="btn btn-sm btn-green btn-activate-user">ACTIVATE</button>');
                    window.ajaxFormSubmitMsgHandlerSuccess(data);
                }).fail(ajaxFormSubmitMsgHandlerError);
            } );
           
        },

    },        
} 
