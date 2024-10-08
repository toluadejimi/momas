$((function () {
    function e() {
        $(".menu-w").hasClass("menu-layout-compact") && $(".menu-layout-selector").val("compact"), $(".menu-w").hasClass("menu-layout-full") && $(".menu-layout-selector").val("full"), $(".menu-w").hasClass("menu-layout-mini") && $(".menu-layout-selector").val("mini"), $(".menu-w").hasClass("color-scheme-dark") && $(".menu-w").hasClass("color-style-bright") && ($(".menu-color-selector").removeClass("selected"), $(".menu-color-selector.color-bright").addClass("selected")), $(".menu-w").hasClass("color-scheme-dark") && $(".menu-w").hasClass("color-style-dark") && ($(".menu-color-selector").removeClass("selected"), $(".menu-color-selector.color-dark").addClass("selected")), $(".menu-w").hasClass("color-scheme-light") && ($(".menu-color-selector").removeClass("selected"), $(".menu-color-selector.color-light").addClass("selected")), $(".menu-w").hasClass("color-style-transparent") && ($(".menu-color-selector").removeClass("selected"), $(".menu-color-selector.color-transparent").addClass("selected")), $(".menu-w").hasClass("menu-position-side") && $(".menu-w").hasClass("menu-side-left") && $(".menu-position-selector").val("left"), $(".menu-w").hasClass("menu-with-image") ? $(".with-image-selector").val("yes") : $(".with-image-selector").val("no"), $(".menu-w").hasClass("menu-position-top") ? ($(".menu-position-selector").val("top"), $(".with-image-selector-w").show()) : $(".with-image-selector-w").hide(), $(".menu-w").hasClass("menu-position-side") && $(".menu-w").hasClass("menu-side-right") && $(".menu-position-selector").val("right"), $(".menu-w").hasClass("sub-menu-color-bright") && ($(".sub-menu-color-selector").removeClass("selected"), $(".sub-menu-color-selector.color-bright").addClass("selected")), $(".menu-w").hasClass("sub-menu-color-dark") && ($(".sub-menu-color-selector").removeClass("selected"), $(".sub-menu-color-selector.color-dark").addClass("selected")), $(".menu-w").hasClass("sub-menu-color-light") && ($(".sub-menu-color-selector").removeClass("selected"), $(".sub-menu-color-selector.color-light").addClass("selected")), $(".menu-w").hasClass("sub-menu-style-flyout") && $(".sub-menu-style-selector").val("flyout"), $(".menu-w").hasClass("sub-menu-style-inside") && $(".sub-menu-style-selector").val("inside"), $(".menu-w").hasClass("sub-menu-style-over") && $(".sub-menu-style-selector").val("over"), $(".top-bar").hasClass("color-scheme-bright") && ($(".top-bar-color-selector").removeClass("selected"), $(".top-bar-color-selector.color-bright").addClass("selected")), $(".top-bar").hasClass("color-scheme-dark") && ($(".top-bar-color-selector").removeClass("selected"), $(".top-bar-color-selector.color-dark").addClass("selected")), $(".top-bar").hasClass("color-scheme-light") && ($(".top-bar-color-selector").removeClass("selected"), $(".top-bar-color-selector.color-light").addClass("selected")), $(".top-bar").hasClass("color-scheme-transparent") && ($(".top-bar-color-selector").removeClass("selected"), $(".top-bar-color-selector.color-transparent").addClass("selected")), $("body").hasClass("full-screen") ? $(".full-screen-selector").val("yes") : $(".full-screen-selector").val("no"), $(".top-bar").hasClass("d-none") ? $(".top-bar-visibility-selector").val("no") : $(".top-bar-visibility-selector").val("yes"), $(".content-w .top-bar").length ? $(".top-bar-above-menu-selector").val("no") : $(".top-bar-above-menu-selector").val("yes")
    }

    function o() {
        var e = "light", o = "default";
        $(".menu-color-selector.selected").hasClass("color-bright") && (e = "dark", o = "bright"), $(".menu-color-selector.selected").hasClass("color-dark") && (e = "dark", o = "default"), $(".menu-color-selector.selected").hasClass("color-light") && (e = "light", o = "default"), $(".menu-color-selector.selected").hasClass("color-transparent") && (e = $("body").hasClass("color-scheme-dark") ? "dark" : "light", o = "transparent"), $(".menu-w").removeClass((function (e, o) {
            return (o.match(/(^|\s)color-scheme-\S+/g) || []).join(" ")
        })), $(".menu-w").removeClass((function (e, o) {
            return (o.match(/(^|\s)color-style-\S+/g) || []).join(" ")
        })), $(".menu-w").addClass("color-scheme-" + e).addClass("color-style-" + o);
        var s = "light";
        $(".top-bar-color-selector.selected").hasClass("color-bright") && (s = "bright"), $(".top-bar-color-selector.selected").hasClass("color-dark") && (s = "dark"), $(".top-bar-color-selector.selected").hasClass("color-light") && (s = "light"), $(".top-bar-color-selector.selected").hasClass("color-transparent") && (s = "transparent"), $(".top-bar").removeClass((function (e, o) {
            return (o.match(/(^|\s)color-scheme-\S+/g) || []).join(" ")
        })), $(".top-bar").addClass("color-scheme-" + s);
        var l = "light";
        $(".sub-menu-color-selector.selected").hasClass("color-bright") && (l = "bright"), $(".sub-menu-color-selector.selected").hasClass("color-dark") && (l = "dark"), $(".sub-menu-color-selector.selected").hasClass("color-light") && (l = "light"), $(".menu-w").removeClass((function (e, o) {
            return (o.match(/(^|\s)sub-menu-color-\S+/g) || []).join(" ")
        })), $(".menu-w").addClass("sub-menu-color-" + l);
        var t = $(".menu-position-selector").val();
        $(".menu-w").removeClass((function (e, o) {
            return (o.match(/(^|\s)menu-position-\S+/g) || []).join(" ")
        })), $(".menu-w").removeClass((function (e, o) {
            return (o.match(/(^|\s)menu-side-\S+/g) || []).join(" ")
        })), $("body").removeClass("menu-position-top").removeClass("menu-position-side").removeClass("menu-side-left").removeClass("menu-side-right"), "top" == t ? ($(".menu-w").addClass("menu-position-top"), $("body").addClass("menu-position-top"), $(".with-image-selector-w").slideDown()) : $(".with-image-selector-w").hide(), "left" == t && ($(".menu-w").addClass("menu-position-side").addClass("menu-side-left"), $("body").addClass("menu-position-side").addClass("menu-side-left"), $(".menu-w .os-dropdown-position-left").removeClass("os-dropdown-position-left").addClass("os-dropdown-position-right")), "right" == t && ($(".menu-w").addClass("menu-position-side").addClass("menu-side-right"), $("body").addClass("menu-position-side").addClass("menu-side-right"), $(".menu-w .os-dropdown-position-right").removeClass("os-dropdown-position-right").addClass("os-dropdown-position-left"));
        var r = $(".menu-layout-selector").val();
        $(".menu-w").removeClass((function (e, o) {
            return (o.match(/(^|\s)menu-layout-\S+/g) || []).join(" ")
        })), $(".menu-w").addClass("menu-layout-" + r), "full" == r ? $(".menu-w > .logged-user-w").removeClass("avatar-inline") : $(".menu-w > .logged-user-w").addClass("avatar-inline"), "mini" == r ? ($('.sub-menu-style-selector option[value="inside"]').attr("disabled", "disabled"), "left" == t && ($(".menu-actions .os-dropdown-trigger").removeClass((function (e, o) {
            return (o.match(/(^|\s)os-dropdown-position-\S+/g) || []).join(" ")
        })), $(".menu-actions .os-dropdown-trigger").addClass("os-dropdown-position-right-center")), "right" == t && ($(".menu-actions .os-dropdown-trigger").removeClass((function (e, o) {
            return (o.match(/(^|\s)os-dropdown-position-\S+/g) || []).join(" ")
        })), $(".menu-actions .os-dropdown-trigger").addClass("os-dropdown-position-left-center")), "top" == t && ($(".menu-actions .os-dropdown-trigger").removeClass((function (e, o) {
            return (o.match(/(^|\s)os-dropdown-position-\S+/g) || []).join(" ")
        })), $(".menu-actions .os-dropdown-trigger").addClass("os-dropdown-position-left"))) : ($('.sub-menu-style-selector option[value="inside"]').removeAttr("disabled", "disabled"), "left" == t && ($(".menu-actions .os-dropdown-trigger").removeClass((function (e, o) {
            return (o.match(/(^|\s)os-dropdown-position-\S+/g) || []).join(" ")
        })), $(".menu-actions .os-dropdown-trigger").addClass("os-dropdown-position-right")), "right" == t && ($(".menu-actions .os-dropdown-trigger").removeClass((function (e, o) {
            return (o.match(/(^|\s)os-dropdown-position-\S+/g) || []).join(" ")
        })), $(".menu-actions .os-dropdown-trigger").addClass("os-dropdown-position-left")), "top" == t && ($(".menu-actions .os-dropdown-trigger").removeClass((function (e, o) {
            return (o.match(/(^|\s)os-dropdown-position-\S+/g) || []).join(" ")
        })), $(".menu-actions .os-dropdown-trigger").addClass("os-dropdown-position-left")));
        var a = $(".sub-menu-style-selector").val();
        $(".menu-w").removeClass((function (e, o) {
            return (o.match(/(^|\s)sub-menu-style-\S+/g) || []).join(" ")
        })), $(".menu-w").addClass("sub-menu-style-" + a), "yes" == $(".top-bar-visibility-selector").val() ? $(".top-bar").removeClass("d-none") : $(".top-bar").addClass("d-none"), "yes" == $(".full-screen-selector").val() ? $("body").addClass("full-screen") : $("body").removeClass("full-screen"), "yes" == $(".with-image-selector").val() ? $(".menu-w").addClass("menu-with-image") : $(".menu-w").removeClass("menu-with-image");
        var n = $(".top-bar");
        "yes" == $(".top-bar-above-menu-selector").val() ? $(".content-w .top-bar").length && (n = $(".content-w .top-bar"), $(".all-wrapper").prepend(n), $(".content-w .top-bar").remove()) : $(".all-wrapper > .top-bar").length && (n = $(".all-wrapper > .top-bar"), $(".content-w").prepend(n), $(".all-wrapper > .top-bar").remove()), "inside" == $(".sub-menu-style-selector").val() && "top" != $(".menu-position-selector").val() && $(".menu-w.menu-activated-on-hover").length ? ($(".menu-activated-on-hover").off("mouseenter", "ul.main-menu > li.has-sub-menu"), $(".menu-activated-on-hover").off("mouseleave", "ul.main-menu > li.has-sub-menu"), $(".menu-w").removeClass("menu-activated-on-hover").addClass("menu-activated-on-click"), $(".sub-menu-color-selector.color-light").click(), os_init_sub_menus()) : !$(".menu-w.menu-activated-on-click").length || "inside" == $(".sub-menu-style-selector").val() && "top" != $(".menu-position-selector").val() || ($(".menu-activated-on-click").off("click", "li.has-sub-menu > a"), $(".menu-w").addClass("menu-activated-on-hover").removeClass("menu-activated-on-click"), os_init_sub_menus())
    }

    $(".floated-customizer-btn").on("click", (function () {
        return $(".floated-customizer-panel").toggleClass("active"), !1
    })), e(), $(".floated-customizer-panel .color-selector").on("click", (function () {
        $(this).closest(".fcp-colors").find(".color-selector.selected").removeClass("selected"), $(this).addClass("selected"), o()
    })), $(".floated-customizer-panel select").on("change", (function () {
        o()
    })), $(".menu-layout-selector").on("change", (function () {
        "mini" == $(this).val() && $(".sub-menu-style-selector").val("over"), o()
    })), $(".close-customizer-btn").on("click", (function () {
        return $(".floated-customizer-panel").toggleClass("active"), !1
    })), $(".with-image-selector").on("change", (function () {
        "yes" == $(this).val() && $(".color-selector.menu-color-selector.color-bright").click()
    }))
}));
