window.dashboard = {
    pages:{
        init: function() {            
            this.datatable();
            this.repositionPagination();
        },
        repositionPagination: function(){
            $(".pagination-container").ready(function(){
                $(".dataTables_paginate").appendTo($(".pagination-container"));
            });
        },
        datatable: function() {
            var dt = $('#datatable-pages').dataTable({
                dom: 'rtp',
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '/dashboard/pages/datatable',
                    data: function(d) {
                        $.extend(d, {                            
                            search: $('[name="filter-search"]').val(),
                        });
                    }
                },
                pageLength: 10,
                bSort: false,
                order: [],
                columns: [ 
                    {
                        mRender: function(d, t, r) {
                            return '<input type="checkbox" name="ids[]" value="' + r.id + '">';
                        },
                        orderable: false,
                    }, { 
                        data: 'title' 
                    }, {
                        mRender: function(d, t, r) {
                            return '<div class="header-image-list-container"><image class="header-image-list" height="50" src="'+ r.image +'" title="'+ r.title +'" /></div>';
                        },
                        orderable: false,
                    }, {
                        mRender: function(d, t, r) {
                            return '<input type="text" class="input-sm form-control input-autosize" size="5" name="page['+r.id+'][ordering]" value="' + r.ordering + '">';
                        },
                        orderable: false,
                    }, {
                        mRender: function(d, t, r) {
                            var checked = r.published == 1 ? 'checked="checked"' : '';
                            return '<input type="checkbox" name="page['+r.id+'][published]" value="1" '+ checked +' />';
                        },
                        orderable: false,
                    }, {
                        mRender: function(d, t, r) {
                            var checked = r.public == 1 ? 'checked="checked"' : '';
                            return '<input type="checkbox" name="page['+r.id+'][public]" value="1" '+ checked +' />';
                        },
                        orderable: false,
                    },
                ]
            });

            $('[name="length"]').on('change', function() {
                var length = $(this).val();
                var settings = dt.fnSettings();

                if (length == 'all') {
                    length = settings.fnRecordsTotal();
                }
                settings._iDisplayLength = parseInt(length);
                dt.fnDraw();
            });

           
            $('button.btn-confirm-delete').on('click', function(e) {                  
              var checked = $('[name="ids[]"]:checked');
                if (checked.length > 0) {
                    swal({
                        title: '',
                        text: "Are you sure you want to delete these page/s?",
                        icon: 'warning',
                        buttons: {
                            confirm: "Yes",
                            cancel: true
                        },
                    }).then((value) => {
                        if(value == true){
                            jQuery.ajax({
                                url: "/dashboard/pages/delete?" + checked.serialize(),                                
                                dataType: "json",                        
                            }).done(function(data){
                                window.ajaxFormSubmitMsgHandlerSuccess(data);
                            }).fail(ajaxFormSubmitMsgHandlerError);
                        }
                    });                    
                }                  
            });

            $('#datatable-pages tbody').on('click','tr',function(e){
                var id = $(this).attr('id');
                window.location.href = '/dashboard/pages/' + id + '/edit';
            } );

           $('#datatable-pages tbody').on('click','tr input',function(e){
                e.stopPropagation(); 
            });
        },

        formSubmit: function() {
            $.ajaxSetup({
                headers:
                {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });

            $("#form-pages").validate({
                rules: {
                    title: "required",                                                                                            
                    
                },
                messages: {
                    title: "Please enter the page title",                    
                }
            });

            $('#form-pages').on('submit', function(e) {
                e.preventDefault();
                if ($(this).valid()) {
                    $.ajax({
                        method: 'POST',
                        url: $(this).attr('action'),
                        data: new FormData($(this)[0]),
                        processData: false, // Don't process the files
                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    }).done(function(data) {
                        window.ajaxFormSubmitMsgHandlerSuccess(data);
                    }).fail(ajaxFormSubmitMsgHandlerError);      
                }
            });

             $('button.btn-confirm-delete').on('click', function(e) {                  
              var page_id = $('[name="id"]').val();
                swal({
                    title: '',
                    text: "Are you sure you want to delete this page/s?",
                    icon: 'warning',
                    buttons: {
                        confirm: "Yes",
                        cancel: true
                    },
                }).then((value) => {
                    if(value == true){
                        jQuery.ajax({
                            url: "/dashboard/pages/delete",
                            data: {
                                    id: page_id,
                            },
                            dataType: "json",                        
                        }).done(function(data){
                            window.ajaxFormSubmitMsgHandlerSuccess(data);
                        }).fail(ajaxFormSubmitMsgHandlerError);
                    }
                });         
            });
        },
    },        
} 
