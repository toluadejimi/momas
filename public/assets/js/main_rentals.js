"use strict";
$((function () {
    $(".ion-range-slider").length && $(".ion-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 1e6,
        from: 2e5,
        to: 8e5,
        prefix: "$",
        step: 5e4
    }), $(".select2").length && $(".select2").select2(), $(".item-star-rating").barrating({
        theme: "osadmin",
        readonly: !0
    });
    var e = moment(), t = moment().add(14, "days");
    $(".date-range-picker").daterangepicker({
        startDate: e,
        endDate: t,
        locale: {format: "MMM D, YYYY"}
    }), $(".filter-toggle").on("click", (function () {
        var e = $(this).closest(".filter-w");
        return e.hasClass("collapsed") ? e.find(".filter-body").slideDown(300, (function () {
            e.removeClass("collapsed")
        })) : e.find(".filter-body").slideUp(300, (function () {
            e.addClass("collapsed")
        })), !1
    })), $(".filters-toggler").on("click", (function () {
        return $(".rentals-list-w").toggleClass("hide-filters"), !1
    }))
}));
