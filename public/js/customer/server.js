"use strict";
// Class definition
const KTServerList = function () {
    // Private functions
    const _initServerFilter = function () {
        // using ajax
        const filter = document.querySelector('[data-kt-server-filter="search"]');
        $(filter).on('keyup', function () {
            const value = $(this).val().toLowerCase();
            $.get("?page={{ $servers->currentPage() }}", {
                search: value
            }, function (data) {
                $('#serverList').html(data);
            });
        });
    }

    const _initServerModal = function () {
        // Init detail modal
        $('#detailServerModal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
        });
    }

    return {
        // Public functions
        init: function () {
            _initServerFilter();
            _initServerModal();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTServerList.init();
});
