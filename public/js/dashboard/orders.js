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
        orders:{
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
                var dt = $('#datatable-orders').dataTable({
                    dom: 'rtip',
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/dashboard/orders/datatable',
                        data: function(d) {
                            $.extend(d, {
                                year:  $('.filter-year').val(),
                                month:  $('.filter-month').val(),
                                country:  $('.filter-country').val(),
                                search: $('[name="filter-search"]').val(),
                            });
                        }
                    },
                    pageLength: 10,
                    bSort: true,
                    order: [],
                    columns: [
                        { data: 'created_at' },
                        { data: 'order_id' },
                        { data: 'order_country' },
                        { data: 'order_company' },
                        { data: 'order_contact' },
                        { data: 'order_total' },
                        { data: 'order_payment_type' },
                        { data: 'order_status' }
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

                $('.filter-date').on('change', function() {
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
    dashboard.orders.init();
})
