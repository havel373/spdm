"use strict";
// Class definition
const KTServerList = (function () {
    const _initServerList = function (url) {
        $.get(
            url,
            function (data) {
                $("#serverList").html(data);
            },
            "html"
        );
    };

    // Private functions
    const _initServerFilter = function (url) {
        // using ajax
        const filter = document.querySelector(
            '[data-kt-server-filter="search"]'
        );
        $(filter).on("keyup", function () {
            const value = $(this).val().toLowerCase();
            $.get(
                url,
                {
                    search: value,
                },
                function (data) {
                    $("#serverList").html(data);
                },
                "html"
            );
        });
    };

    const _initServerModal = function () {
        // Init edit limit modal
        $("#editLimitModal").on("show.bs.modal", function (e) {
            var button = $(e.relatedTarget);
            var id = button.data("bs-id");
            var category = button.data("bs-category");
            var server = button.data("bs-server");
            console.log(server);
            var limit = button.data("limit");
            var modal = $(this);
            modal.find("#server").val(server);
            modal.find("#limit").val(limit);
            modal
                .find("#form_input")
                .attr(
                    "action",
                    "/admin/servers/" + category + "/" + id + "/updateLimit"
                );
        });

        // Init edit status modal
        $("#editStatusModal").on("show.bs.modal", function (e) {
            var button = $(e.relatedTarget);
            var id = button.data("bs-id");
            var category = button.data("bs-category");
            var server = button.data("bs-server");
            var status = button.data("bs-status");
            var modal = $(this);
            modal.find("#server").val(server);
            modal.find("#status").val(status);
            modal
                .find("#form_input")
                .attr(
                    "action",
                    "/admin/servers/" + category + "/" + id + "/updateStatus"
                );
        });

        // Init edit price modal
        $("#editPriceModal").on("show.bs.modal", function (e) {
            var button = $(e.relatedTarget);
            var id = button.data("bs-id");
            var category = button.data("bs-category");
            var server = button.data("bs-server");
            var price = button.data("bs-price");
            var modal = $(this);
            modal.find("#server").val(server);
            modal.find("#price").val(price);
            modal
                .find("#form_input")
                .attr(
                    "action",
                    "/admin/servers/" + category + "/" + id + "/updatePrice"
                );
        });

        // on submit form
        $("#form_input").on("submit", function (e) {
            e.preventDefault();
            const form = $(this);
            const btn = form.find('[data-kt-element="submit"]');
            const url = form.attr("action");
            const data = form.serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                beforeSend: function () {
                    btn.attr("data-kt-indicator", "on");
                    btn.prop("disabled", true);
                },
                success: function (data) {
                    if (data.status == "success") {
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        }).then(function () {
                            KTUtil.scrollTop();
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            text: data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        }).then(function () {
                            KTUtil.scrollTop();
                        });
                    }
                },
                error: function (data) {
                    Swal.fire({
                        text: "Sorry, we couldn't update your data.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    }).then(function () {
                        KTUtil.scrollTop();
                    });
                },
            }).done(function () {
                btn.removeAttr("data-kt-indicator");
                btn.prop("disabled", false);
            });
        });
    };

    const _initServerDelete = function () {
        $(document).on(
            "click",
            '[data-kt-server-filter="delete_row"]',
            function () {
                console.log("delete");
                const id = $(this).data("id");
                const category = $(this).data("category");
                const url = "/admin/servers/" + category + "/" + id;
                Swal.fire({
                    text: "Are you sure you want to delete this server?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (t) {
                    if (t.isConfirmed) {
                        $.ajax({
                            url: url,
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
        // Public functions
        init: function (url) {
            _initServerList(url);
            _initServerFilter();
            _initServerModal();
            _initServerDelete();
        },
    };
})();
