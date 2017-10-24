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

    window.dashboard = {
        products:{
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
                var dt = $('#datatable-products').dataTable({
                    dom: 'rtp',
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ordering: false,
                    ajax: {
                        url: '/dashboard/products/datatable',
                        data: function(d) {
                            $.extend(d, {
                                category:  $('[name="filter-category"]').val(),
                                published: $('[name="filter-published"]').val(),
                            });
                        }
                    },
                    pageLength: 10,
                    bSort: true,
                    order: [],
                    columns: [
                        {
                            mRender: function(d, t, r) {
                                return '<div class="text-left"><i class="fa fa-chevron-right row-expand-toggler margintop-8" data-id="'+ r['id'] +'" aria-hidden="true"></i></div>';
                            },
                            orderable: false,
                        }, {
                            mRender: function(d, t, r) {                            
                                return '<input type="text" name="product['+r['id']+'][name]" value="'+ r['name'] +'" size="15" class="form-control input-autosize input-sm" />';
                            },
                            orderable: true,
                        }, {
                            mRender: function(d, t, r) {
                                return '<button type="button" class="btn btn-brown btn-sm btn-description" data-id="'+r['id']+'" data-toggle="modal" data-target="#myModal">DESCRIPTION</button>' +
                                        '<input type="hidden" name="product['+r['id']+'][description]" id="description-id-'+r['id']+'" value="'+r['description']+'" />';
                            },
                            orderable: true,
                        },
                        { mRender: function(d, t, r) { return ''; } },
                        { mRender: function(d, t, r) { return ''; } },
                        { mRender: function(d, t, r) { return ''; } },
                        { mRender: function(d, t, r) { return '<div class="text-left">ORDER</div>'; } },
                        { mRender: function(d, t, r) { return '<div class="text-left"><input type="text" class="form-control input-sm input-autosize" size="5" name="product['+r['id']+'][ordering]" value="'+r['ordering']+'" /></div>'; } },
                        {
                            mRender: function(d, t, r) {http://fontawesome.io/icon/chevron-right
                                return '<button type="button" class="btn btn-green btn-sm update-product marginright-5" data-id="'+ r['id'] +'">UPDATE</button><button type="button" class="btn btn-red btn-sm delete-product" data-id="'+ r['id'] +'">DELETE</button>';
                            },
                            orderable: true,
                        }
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

                $('#datatable-products').on('click', '.row-expand-toggler', function() {
                    var dbTable = $('#datatable-products').DataTable();
                    var product_id = $(this).data('id');
                    var tr = $(this).closest('tr');
                    var row = dbTable.row( tr );

                    $(this).toggleClass('fa-chevron-right fa-chevron-down');

                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');

                    } else {
                        jQuery.ajax({
                            url: "/dashboard/products/details",
                            data: {
                                id: product_id,
                            },
                            dataType: "json",
                            success: function(data) {
                                row.child( dashboard.products.editProductForm(data), 'subtable-row').show();
                                tr.addClass('shown');
                            }
                        });
                    }
                });

                $('#datatable-products').on('click', '.update-product', function (){                    
                    var product_id = $(this).data('id');                  
                    jQuery.ajax({
                        url: "/dashboard/products/update",
                        data: $('input[name^="product['+product_id+']\\["]').serializeControls(),
                        dataType: "json",                        
                    }).done(function(data){
                        window.ajaxFormSubmitMsgHandlerSuccess(data);
                    }).fail(ajaxFormSubmitMsgHandlerError);                        
                });

                $('#datatable-products').on('click', '.delete-product', function (){                    
                    var product_id = $(this).data('id'); 

                    swal({
                        title: '',
                        text: "Are you sure you want to delete this product?",
                        icon: 'warning',
                        buttons: {
                            confirm: "Yes",
                            cancel: true
                        },
                    }).then((value) => {
                        if(value == true){
                            jQuery.ajax({
                                url: "/dashboard/products/delete",
                                data: {
                                        id: product_id,
                                },
                                dataType: "json",                        
                            }).done(function(data){
                                window.ajaxFormSubmitMsgHandlerSuccess(data);
                            }).fail(ajaxFormSubmitMsgHandlerError);
                        }
                    });
                                            
                });

                var maxLength = 140;

                $('#myModal').on('show.bs.modal', function (event) {
                  var button = $(event.relatedTarget); // Button that triggered the modal
                  var id = button.data('id');
                  var modal = $(this);                  
                  modal.find('.modal-body #description-textarea').val($("#description-id-"+id).val());
                  $('#product-id').val(id);
                  var length = $('textarea#description-textarea').val().length;
                  var length = maxLength-length;
                  $('.chars-remaining').text(length);
                });
                
                $('textarea#description-textarea').keyup(function() {
                  var length = $(this).val().length;
                  var length = maxLength-length;
                  $('.chars-remaining').text(length);
                });

                $('#myModal').on('click', '.btn-save-description', function (){
                    var description = $('textarea#description-textarea').val(),
                        product_id = $('#product-id').val();

                    jQuery.ajax({
                        url: "/dashboard/products/description",
                        data: {
                            id: product_id,
                            desc: description
                        },
                        dataType: "json",
                    }).done(function(data){
                        $('#myModal').modal('hide');
                        $("#description-id-"+product_id).val(description);
                        window.ajaxFormSubmitMsgHandlerSuccess(data);
                    }).fail(ajaxFormSubmitMsgHandlerError);    
                });

            },
            editProductForm: function( d ) {
                // `d` is the original data object for the row

                var overall_total = 0;
                var ca_enabled_checked = d['ca_enabled'] ? 'checked="checked"' : '';
                var us_enabled_checked = d['us_enabled'] ? 'checked="checked"' : '';
                var ca_published_checked = d['ca_published'] ? 'checked="checked"' : '';
                var us_published_checked = d['us_published'] ? 'checked="checked"' : '';

                var html = '<div class="subtable-wrapper"><table class="subtable" align="center">'+
                    '<tbody>'+
                        '<tr>'+
                            '<td rowspan="2" nowrap>Image</td>'+
                            '<td nowrap><input type="checkbox" value="1" name="product['+d['id']+'][ca_enabled]" '+ ca_enabled_checked +' /> CAD</td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="12" value="'+ d['ca_sku'] +'" name="product['+d['id']+'][ca_sku]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['ca_price'] +'" name="product['+d['id']+'][ca_price]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['ca_six_plus'] +'" name="product['+d['id']+'][ca_six_plus]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['ca_six_pack'] +'" name="product['+d['id']+'][ca_six_pack]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['ca_dozen_pack'] +'" name="product['+d['id']+'][ca_dozen_pack]" /></td>'+
                            '<td nowrap><input type="checkbox" value="1" name="product['+d['id']+'][ca_published]" '+ ca_published_checked +' /></td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td nowrap><input type="checkbox" value="1" name="product['+d['id']+'][us_enabled]" '+ us_enabled_checked +' /> USD</td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="12" value="'+ d['us_sku'] +'" name="product['+d['id']+'][us_sku]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['us_price'] +'" name="product['+d['id']+'][us_price]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['us_six_plus'] +'" name="product['+d['id']+'][us_six_plus]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['us_six_pack'] +'" name="product['+d['id']+'][us_six_pack]" /></td>'+
                            '<td nowrap><input type="text" class="form-control input-sm input-autosize" size="6" value="'+ d['us_dozen_pack'] +'" name="product['+d['id']+'][us_dozen_pack]" /></td>'+
                            '<td nowrap><input type="checkbox" value="1" name="product['+d['id']+'][us_published]" '+ us_published_checked +' /><input type="hidden" name="product['+d['id']+'][id]" value="'+d['id']+'" /></td>'+
                        '</tr>';
                    

                html = html + '</tbody>'+                    
                '</table></div>';

                return html;
            },
        },        
    }    
    dashboard.products.init();
})
