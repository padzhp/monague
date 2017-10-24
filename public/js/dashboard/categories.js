$(function() {

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
                                return '<input type="checkbox" name="category['+r.id+'][ca_enabled]" value="' + r.id + '" '+ checked +' />';
                            },
                            orderable: false,
                        },
                        {
                            mRender: function(d, t, r) {
                                var checked = r.us_enabled == 1 ? 'checked="checked"' : '';
                                return '<input type="checkbox" name="category['+r.id+'][us_enabled]" value="' + r.id + '" '+ checked +' />';
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
                        $('#confirm').modal({
                          backdrop: 'static',
                          keyboard: false
                        })
                        .one('click', '#delete', function(e) {
                            $.ajax({
                                method: 'GET',
                                url: '/api/posts/delete?' + checked.serialize(),
                            }).done(function() {
                                dt.fnDraw();
                                $('[name="action"]').dropdown('restore defaults');
                            });
                        });                        
                    }                  
                });

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
        },        
    }    
    dashboard.categories.init();
})
