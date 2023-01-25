"use strict";
// Class definition
const KTCouponList = (function () {
    let datatable;
    const search = document.querySelector('[data-kt-coupon-filter="search"]');
    // Private functions
    const _couponList = () => {
        datatable = $('#kt_coupon_table').DataTable({
            info: !1,
            order: [],
            pageLength: 10,
            columnDefs: [{
                orderable: !1,
                targets: 0
            }, {
                orderable: !1,
                targets: 5
            }]
        });
        search.addEventListener('keyup', (e) => {
            datatable.search(e.target.value).draw();
        });
    }

    return {
        // public functions
        init: function () {
            _couponList();
        }
    };
})();
// On document ready
KTUtil.onDOMContentLoaded((function () {
    KTCouponList.init();
}));
