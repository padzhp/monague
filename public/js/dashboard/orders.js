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


            $('#datatable-orders tbody').on('click','tr',function(e){
                var id = $(this).attr('id');
                console.log("HERE");
                window.location.href = '/dashboard/orders/details/' + id;
            } );
        },
    },        
}    

