"use strict";
// Class definition
const KTAccountList = (function () {
    let datatable;
    const search = document.querySelector('[data-kt-account-filter="search"]');
    // if column length is 6, then add this line: orderable: !1, targets: 5
    // if column length is 7, then add this line: orderable: !1, targets: 6
    var columnDefs = [{
        orderable: !1,
        targets: 0
    }];
    if (document.getElementById('kt_account_table').rows[0].cells.length == 6) {
        columnDefs.push({
            orderable: !1,
            targets: 5
        });
    } else if (document.getElementById('kt_account_table').rows[0].cells.length == 7) {
        columnDefs.push({
            orderable: !1,
            targets: 6
        });
    }

    // Private functions
    const _accountList = () => {
        datatable = $('#kt_account_table').DataTable({
            info: !1,
            order: [],
            pageLength: 10,
            columnDefs: columnDefs
        });
        search.addEventListener('keyup', (e) => {
            datatable.search(e.target.value).draw();
        });
    }

    const _initModal = () => {
        // Init renewal modal
        $('#renewalModal').on('show.bs.modal', function (e) {
            const button = $(e.relatedTarget);
            const id = button.data('id');
            const category = button.data('category');
            const modal = $(this);
            modal.find('#form_input').attr('action', '/accounts/' + category + '/' + id);
            modal.find('#form_input').attr('method', 'PUT');
            $.get(category + "/" + id + "/edit", function (data) {
                console.log(data);
                modal.find('#server_name').val(data.server);
                modal.find('#username').val(data.username);
                modal.find('#price').val(data.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                modal.find('#price').data('price', data.price);
                modal.find('#expired_at').val(data.expired);
                modal.find('#total').val(0);
            });
        });
        $('#expired').change(function () {
            var expired = $('#expired').val();
            var price = $('#price').data('price');
            var total = parseInt(expired) * parseInt(price);
            total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#total').val(total);
        });

        // on submit renewal modal
        $('#form_input').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const btn = form.find('[data-kt-element="submit"]');
            const url = form.attr('action');
            const method = form.attr('method');
            const data = form.serialize();
            $.ajax({
                url: url,
                type: 'PUT',
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    btn.attr("data-kt-indicator", "on");
                    btn.prop("disabled", true);
                },
                success: function (data) {
                    if (data.status == 'success') {
                        Swal.fire({
                            text: data.message,
                            icon: 'success',
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        }).then((function () {
                            $('#renewalModal').modal('hide');
                            location.reload();
                        }));
                    } else {
                        Swal.fire({
                            text: data.message,
                            icon: 'error',
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        });
                    }
                }
            }).done(function () {
                btn.removeAttr("data-kt-indicator");
                btn.prop("disabled", false);
            });
        });
    }

    const _initDelete = () => {
        // on click delete
        $(document).on('click', '[data-kt-customer-filter="delete_row"]', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const category = $(this).data('category');
            Swal.fire({
                text: "Are you sure want to delete this customer?",
                icon: 'warning',
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((function (t) {
                if (t.isConfirmed) {
                    $.ajax({
                        url: '/accounts/' + category + '/' + id,
                        method: 'DELETE',
                        success: function (response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        },
                        error: function (xhr) {
                            var res = xhr.responseJSON;
                            if ($.isEmptyObject(res) == false) {
                                $.each(res.errors, function (key,
                                    value) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: value,
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                });
                            }
                        }
                    });
                }
            }));
        });
    }

    return {
        // public functions
        init: function () {
            _accountList();
            _initModal();
            _initDelete();
        }
    };
})();

// On document ready
KTUtil.onDOMContentLoaded((function () {
    KTAccountList.init();
}));
