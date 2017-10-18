jQuery(document).ready(function ($) {
    var $crudTable = $('#crudTable');
    var tableOptions = {
        pageLength: backpack.crud.pageLength,
        lengthChange: false,
        searching: false,
        language: {
            emptyTable: backpack.lang.emptyTable,
            info: backpack.lang.info,
            infoEmpty: backpack.lang.infoEmpty,
            infoFiltered: backpack.lang.infoFiltered,
            infoPostFix: backpack.lang.infoPostFix,
            thousands: backpack.lang.thousands,
            lengthMenu: backpack.lang.lengthMenu,
            loadingRecords: backpack.lang.loadingRecords,
            processing: backpack.lang.processing,
            search: backpack.lang.search,
            zeroRecords: backpack.lang.zeroRecords,
            paginate: {
                first: backpack.lang.paginate.first,
                last: backpack.lang.paginate.last,
                next: backpack.lang.paginate.next,
                previous: backpack.lang.paginate.previous
            },
            aria: {
                sortAscending: backpack.lang.aria.sortAscending,
                sortDescending: backpack.lang.aria.sortDescending
            }
        }
    };

    if (backpack.crud.ajaxTable) {
        tableOptions.processing = true;
        tableOptions.serverSide = true;
        tableOptions.ajax = {
            url: backpack.crud.ajaxUrl,
            type: "POST"
        };
        //tableOptions.deferRender = true;
    }

    var table = $crudTable.DataTable(tableOptions);

    $.ajaxPrefilter(function (options, originalOptions, xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');
        if (token) {
            return xhr.setRequestHeader('X-XSRF-TOKEN', token);
        }
    });

    // make the delete button work in the first result page
    register_delete_button_action();
    // make the delete button work on subsequent result pages
    $crudTable.on('draw.dt', function () {
        register_delete_button_action();
        if (backpack.crud.detailsRow) {
            register_details_row_button_action();
        }
    }).dataTable();

    function register_delete_button_action() {
        var $deleteBtn = $('[data-button-type=delete]');
        $deleteBtn.unbind('click');
        $deleteBtn.click(function (e) {
            e.preventDefault();
            var delete_url = $(this).attr('href');
            var delete_msg = $(this).data('button-alert');
            if (typeof delete_msg == 'undefined' || 0 == delete_msg.length) {
                delete_msg = backpack.lang.notification.deleteConfirm;
            }

            if (confirm(delete_msg) == true) {
                $.ajax({
                    url: delete_url,
                    type: 'DELETE',
                    success: function (result) {
                        new PNotify({
                            title: backpack.lang.notification.deleteSuccess.title,
                            text: backpack.lang.notification.deleteSuccess.message,
                            type: "success"
                        });
                        window.location.href = window.location.href;
                    },
                    error: function (result) {
                        new PNotify({
                            title: backpack.lang.notification.deleteError.title,
                            text: backpack.lang.notification.deleteError.message,
                            type: "warning"
                        });
                    }
                });
            } else {
                new PNotify({
                    title: backpack.lang.notification.deleteCancel.title,
                    text: backpack.lang.notification.deleteCancel.message,
                    type: "info"
                });
            }
        });
    }

    function register_details_row_button_action() {
        $('#crudTable tbody').on('click', 'td .details-row-button', function () {
            var tr = $(this).closest('tr');
            var btn = $(this);
            var row = table.row(tr);

            if (row.child.isShown()) {
                $(this).children('i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                $('div.table_row_slider', row.child()).slideUp(function () {
                    row.child.hide();
                    tr.removeClass('shown');
                });
            }
            else {
                $(this).children('i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                $.ajax({
                    url: backpack.requestUrl + '/' + btn.data('entry-id') + '/details',
                    type: 'GET'
                })
                .done(function (data) {
                    row.child("<div class='table_row_slider'>" + data + "</div>", 'no-padding').show();
                    tr.addClass('shown');
                    $('div.table_row_slider', row.child()).slideDown();
                    register_delete_button_action();
                })
                .fail(function (data) {
                    row.child("<div class='table_row_slider'>" + backpack.lang.errors.detailsRowLoading + "</div>").show();
                    tr.addClass('shown');
                    $('div.table_row_slider', row.child()).slideDown();
                })
                .always(function (data) {});
            }
        });
    }

    if (backpack.crud.detailsRow) {
        register_details_row_button_action();
    }

    $crudTable.on('click', '.bfm-checkbox', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            url: $this.attr('href'),
            data: $this.data(),
            type: 'post',
            dataType: 'json',
            success: function () {
                $crudTable.api().ajax.reload();
            }
        });
    });
});