window.dashboard = {
    categories:{
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
            var dt = $('#datatable-categories').dataTable({
                dom: 'rtp',
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '/dashboard/categories/datatable',
                    data: function(d) {
                        $.extend(d,{});
                    }
                },
                pageLength: 10,
                bSort: false,
                columns: [
                    {
                        mRender: function(d, t, r) {
                            return '<input type="checkbox" name="ids[]" value="' + r.id + '">';
                        },
                        orderable: false,
                    },
                    { data: 'category' },
                    { data: 'parent' },
                    {
                        mRender: function(d, t, r) {
                            var checked = r.ca_enabled == 1 ? 'checked="checked"' : '';
                            return '<input type="checkbox" name="category['+r.id+'][ca_status]" value="1" '+ checked +' />';
                        },
                        orderable: false,
                    },
                    {
                        mRender: function(d, t, r) {
                            var checked = r.us_enabled == 1 ? 'checked="checked"' : '';
                            return '<input type="checkbox" name="category['+r.id+'][us_status]" value="1" '+ checked +' />';
                        },
                        orderable: false,
                    },
                    {
                        mRender: function(d, t, r) {
                            return '<input type="text" class="input-sm form-control input-autosize" size="5" name="category['+r.id+'][ordering]" value="' + r.ordering + '">';
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
                        text: "Are you sure you want to delete these categories?",
                        icon: 'warning',
                        buttons: {
                            confirm: "Yes",
                            cancel: true
                        },
                    }).then((value) => {
                        if(value == true){
                            jQuery.ajax({
                                url: "/dashboard/categories/delete?" + checked.serialize(),                                
                                dataType: "json",                        
                            }).done(function(data){
                                window.ajaxFormSubmitMsgHandlerSuccess(data);
                            }).fail(ajaxFormSubmitMsgHandlerError);
                        }
                    });                    
                }                  
            });

            $('#datatable-categories tbody').on('click','tr',function(e){
                var id = $(this).attr('id');
                window.location.href = '/dashboard/categories/' + id + '/edit';
            } );

           $('#datatable-categories tbody').on('click','tr input',function(e){
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

            $("#form-categories").validate({
                rules: {
                    name: "required",                                                           
                    ordering: {
                        required: true, 
                        digits: true,                       
                    },                    
                    
                },
                messages: {
                    name: "Please enter the category name",                                                                             
                    ordering: {
                        required: "Ordering number is required",
                        digits: 'Ordering must be a number'

                    }
                    
                }
            });

            $('#form-categories').on('submit', function(e) {
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


            $('#form-categories-massupdate').on('submit', function(e) {
                e.preventDefault();                
                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    data: new FormData($(this)[0]),
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                }).done(function(data) {
                    window.ajaxFormSubmitMsgHandlerSuccess(data);
                }).fail(ajaxFormSubmitMsgHandlerError);      
                
            });
             
        },

    },        
}    

