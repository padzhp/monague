window.dashboard = {
    admins:{
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
            var dt = $('#datatable-admins').dataTable({
                dom: 'rtp',
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '/dashboard/admins/datatable',
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
                    { data: 'username' },
                    { data: 'name' },                  
                    { data: 'email' },
                    { data: 'last_login' },
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

           
            $('#datatable-admins tbody').on('click', 'tr', function () {
                var id = $(this).attr('id');
                window.location.href = '/dashboard/admins/' + id + '/edit';
            } );

           
            $('[name="filter-search"]').donetyping(function () {
                dt.fnDraw();
            }).on('keypress', function (e) {
                if (e.keyCode == 13) {
                    dt.fnDraw();
                }
            });

            $('[name="filter-search"]').next('a').on('click', function() {
                dt.fnDraw();
            });
        },

        formSubmit: function() {
            $.ajaxSetup({
                headers:
                {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });

            $("#form-admin").validate({
                rules: {
                    name: "required",                    
                    password: {
                        required: true,
                        minlength: 5
                    },                   
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/dashboard/admins/unique_email",  
                            type: "post",
                            data: {
                              id: function() {
                                return $( "#id" ).val();
                              }
                            }
                        }

                    },                    
                    
                },
                messages: {
                    name: "Please enter the admin name",                                      
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },                   
                    email: {
                        required: "Please enter a valid email address",
                        remote: 'Email is already existing'

                    }
                    
                }
            });

            $('#form-admin').on('submit', function(e) {
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
              var admin_id = $('[name="id"]').val();
                swal({
                    title: '',
                    text: "Are you sure you want to delete this admin?",
                    icon: 'warning',
                    buttons: {
                        confirm: "Yes",
                        cancel: true
                    },
                }).then((value) => {
                    if(value == true){
                        jQuery.ajax({
                            url: "/dashboard/admins/delete",
                            data: {
                                    id: admin_id,
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
