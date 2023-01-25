"use strict";
// Class definition
const KTUsersList = (function () {
    const search = document.querySelector('[data-user-filter="search"]');
    let datatable;
    // Private functions
    const _userList = () => {
        datatable = $("#kt_user_table").DataTable({
            info: !1,
            order: [],
            pageLength: 10,
            columnDefs: [
                {
                    orderable: !1,
                    targets: 0,
                },
                {
                    orderable: !1,
                    targets: 6,
                },
            ],
        });
        search.addEventListener("keyup", (e) => {
            datatable.search(e.target.value).draw();
        });
    };

    const _initServerModal = () => {
        // Init edit add balance modal
        $("#addBalanceModal").on("show.bs.modal", function (e) {
            var button = $(e.relatedTarget);
            const id = button.data("id");
            const name = button.data("name");
            const role = button.data("role");
            var modal = $(this);
            modal.find("#name").val(name);
            modal
                .find("#form_input")
                .attr(
                    "action",
                    "/admin/users/" + role + "/" + id + "/updateBalance"
                );
        });
        // on submit form add balance
        $("#form_input").on("submit", function (e) {
            e.preventDefault();
            const form = $(this);
            const btn = form.find('[data-kt-element="submit"]');
            const url = form.attr("action");
            const method = form.attr("method");
            const data = form.serialize();
            $.ajax({
                url: url,
                method: method,
                data: data,
                beforeSend: function () {
                    btn.attr("data-kt-indicator", "on");
                    btn.prop("disabled", true);
                },
                success: function (response) {
                    if (response.status == "success") {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "Ok",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    }
                },
                error: function (xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function (key, value) {
                            Swal.fire({
                                title: "Error!",
                                text: value,
                                icon: "error",
                                confirmButtonText: "Ok",
                            });
                        });
                    }
                },
            }).done(function () {
                btn.removeAttr("data-kt-indicator");
                btn.prop("disabled", false);
            });
        });
    };

    const _initUpdateStatus = () => {
        // on click lock
        $(document).on("click", '[data-user-filter="lock_row"]', function (e) {
            e.preventDefault();
            const id = $(this).data("id");
            const role = $(this).data("role");
            Swal.fire({
                text: "Are you sure want to lock this user?",
                icon: "warning",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Yes, lock!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                },
            }).then(function (t) {
                if (t.isConfirmed) {
                    $.ajax({
                        url: "/admin/users/" + role + "/" + id + "/deactivate",
                        method: "PUT",
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: "Success!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonText: "Ok",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.message,
                                    icon: "error",
                                    confirmButtonText: "Ok",
                                });
                            }
                        },
                        error: function (xhr) {
                            var res = xhr.responseJSON;
                            if ($.isEmptyObject(res) == false) {
                                $.each(res.errors, function (key, value) {
                                    Swal.fire({
                                        title: "Error!",
                                        text: value,
                                        icon: "error",
                                        confirmButtonText: "Ok",
                                    });
                                });
                            }
                        },
                    });
                }
            });
        });

        // on click unlock
        $(document).on(
            "click",
            '[data-user-filter="unlock_row"]',
            function (e) {
                e.preventDefault();
                const id = $(this).data("id");
                const role = $(this).data("role");
                Swal.fire({
                    text: "Are you sure want to unlock this user?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, unlock!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (t) {
                    if (t.isConfirmed) {
                        $.ajax({
                            url:
                                "/admin/users/" + role + "/" + id + "/activate",
                            method: "PUT",
                            success: function (response) {
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success",
                                        confirmButtonText: "Ok",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.message,
                                        icon: "error",
                                        confirmButtonText: "Ok",
                                    });
                                }
                            },
                            error: function (xhr) {
                                var res = xhr.responseJSON;
                                if ($.isEmptyObject(res) == false) {
                                    $.each(res.errors, function (key, value) {
                                        Swal.fire({
                                            title: "Error!",
                                            text: value,
                                            icon: "error",
                                            confirmButtonText: "Ok",
                                        });
                                    });
                                }
                            },
                        });
                    }
                });
            }
        );
    };

    const _initDelete = () => {
        // on click delete
        $(document).on(
            "click",
            '[data-user-filter="delete_row"]',
            function (e) {
                e.preventDefault();
                const id = $(this).data("id");
                const role = $(this).data("role");
                Swal.fire({
                    text: "Are you sure want to delete this user?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (t) {
                    if (t.isConfirmed) {
                        $.ajax({
                            url: "/admin/users/" + role + "/" + id,
                            method: "DELETE",
                            success: function (response) {
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success",
                                        confirmButtonText: "Ok",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.message,
                                        icon: "error",
                                        confirmButtonText: "Ok",
                                    });
                                }
                            },
                            error: function (xhr) {
                                var res = xhr.responseJSON;
                                if ($.isEmptyObject(res) == false) {
                                    $.each(res.errors, function (key, value) {
                                        Swal.fire({
                                            title: "Error!",
                                            text: value,
                                            icon: "error",
                                            confirmButtonText: "Ok",
                                        });
                                    });
                                }
                            },
                        });
                    }
                });
            }
        );
    };

    return {
        // public functions
        init: function () {
            _userList();
            _initServerModal();
            _initUpdateStatus();
            _initDelete();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersList.init();
});
