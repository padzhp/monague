window.dashboard = {
    customers:{
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
            var dt = $('#datatable-customers').dataTable({
                dom: 'rtp',
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '/dashboard/customers/datatable',
                    data: function(d) {
                        $.extend(d, {
                            country:  $('[name="filter-country"]').val(),
                            search: $('[name="filter-search"]').val(),
                        });
                    }
                },
                pageLength: 10,
                bSort: true,
                order: [],
                columns: [
                    {
                        mRender: function(d, t, r) {
                            return '<input type="checkbox" name="ids[]" value="' + r.id + '">';
                        },
                        orderable: false,
                    },
                    { data: 'country' },
                    { data: 'company' },
                    { data: 'contact' },
                    { data: 'email' },
                    { data: 'created_at' },
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
                        text: "Are you sure you want to delete these customer/s?",
                        icon: 'warning',
                        buttons: {
                            confirm: "Yes",
                            cancel: true
                        },
                    }).then((value) => {
                        if(value == true){
                            jQuery.ajax({
                                url: "/dashboard/customers/delete?" + checked.serialize(),                                
                                dataType: "json",                        
                            }).done(function(data){
                                window.ajaxFormSubmitMsgHandlerSuccess(data);
                            }).fail(ajaxFormSubmitMsgHandlerError);
                        }
                    });                    
                }                  
            });

            $('#datatable-customers tbody').on('click', 'tr', function () {
                var id = $(this).attr('id');
                window.location.href = '/dashboard/customers/' + id + '/edit';
            } );

            $('[name="filter-country"]').on('change', function() {
                dt.fnDraw();
            });

            $('#select-all').on('change', function() {                    
                var $this = $(this);
                $this.closest('.data-table').find('[name="ids[]"]')
                    .prop('checked', $this.prop('checked'))
                    .trigger('change');
            });

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

            $("#form-customer").validate({
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
                            url: "/dashboard/customers/unique_email",  
                            type: "post",
                            data: {
                              id: function() {
                                return $( "#id" ).val();
                              }
                            }
                        }

                    },
                    company: "required",
                    billing_street: "required",
                    billing_city: "required",
                    billing_state: "required",
                    billing_zip: "required",
                    billing_country: "required",
                    phone: "required",
                    tax_number: "required",
                    
                },
                messages: {
                    company: "Please enter your company name",
                    name: "Please enter your contact name",                    
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

            $('#form-customer').on('submit', function(e) {
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
              var ids = $('[name="id"]');
                if (ids.length > 0) {
                    swal({
                        title: '',
                        text: "Are you sure you want to delete this customer?",
                        icon: 'warning',
                        buttons: {
                            confirm: "Yes",
                            cancel: true
                        },
                    }).then((value) => {
                        if(value == true){
                            jQuery.ajax({
                                url: "/dashboard/customers/delete?" + ids.serialize(),                                
                                dataType: "json",                        
                            }).done(function(data){
                                window.ajaxFormSubmitMsgHandlerSuccess(data);
                            }).fail(ajaxFormSubmitMsgHandlerError);
                        }
                    });                    
                }                  
            });

            $('button.btn-confirm-activate').on('click', function(e) {                  
                var id = $('[name="id"]').val();
                var status = $(this).data('status');
              
                jQuery.ajax({
                    url: "/dashboard/customers/activate",
                    data: {
                        id: id, 
                        status: status
                    },                                
                    dataType: "json",                        
                }).done(function(data){
                    window.ajaxFormSubmitMsgHandlerSuccess(data);
                }).fail(ajaxFormSubmitMsgHandlerError);
                                      
                                  
            });
        },
    },        
} 
