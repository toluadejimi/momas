"use strict";

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
}

function _defineProperties(e, t) {
    for (var n = 0; n < t.length; n++) {
        var a = t[n];
        a.enumerable = a.enumerable || !1, a.configurable = !0, "value" in a && (a.writable = !0), Object.defineProperty(e, a.key, a)
    }
}

function _createClass(e, t, n) {
    return t && _defineProperties(e.prototype, t), n && _defineProperties(e, n), e
}

function _defineProperty(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e
}

var App = function () {
    function e() {
        _classCallCheck(this, e), _defineProperty(this, "initControls", function () {
            function e() {
                document.webkitIsFullScreen || document.mozFullScreen || document.msFullscreenElement || $("body").removeClass("fullscreen-enable")
            }

            $('[data-toggle="fullscreen"]').on("click", function (e) {
                e.preventDefault(), $("body").toggleClass("fullscreen-enable"), document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement ? document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen() : document.documentElement.requestFullscreen ? document.documentElement.requestFullscreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullscreen && document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)
            }), document.addEventListener("fullscreenchange", e), document.addEventListener("webkitfullscreenchange", e), document.addEventListener("mozfullscreenchange", e)
        })
    }

    return _createClass(e, [{
        key: "initComponents", value: function () {
            Waves.init(), feather.replace();
            [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function (e) {
                return new bootstrap.Popover(e)
            }), [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function (e) {
                return new bootstrap.Tooltip(e)
            }), [].slice.call(document.querySelectorAll(".toast")).map(function (e) {
                return new bootstrap.Toast(e)
            });
            var e = document.getElementById("toastPlacement");
            e && document.getElementById("selectToastPlacement").addEventListener("change", function () {
                e.dataset.originalClass || (e.dataset.originalClass = e.className), e.className = e.dataset.originalClass + " " + this.value
            });
            var a = document.getElementById("liveAlertPlaceholder"), t = document.getElementById("liveAlertBtn");
            t && t.addEventListener("click", function () {
                var e, t, n;
                e = "Nice, you triggered this alert message!", t = "primary", (n = document.createElement("div")).innerHTML = '<div class="alert alert-' + t + ' alert-dismissible" role="alert">' + e + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>', a.append(n)
            })
        }
    }, {
        key: "initMenu", value: function () {
            var e = document.body, t = document.querySelector(".button-toggle-menu");
            t && t.addEventListener("click", function () {
                "default" == e.getAttribute("data-sidebar") ? e.setAttribute("data-sidebar", "hidden") : e.setAttribute("data-sidebar", "default")
            });
            t = function () {
                window.innerWidth < 1040 ? e.setAttribute("data-sidebar", "hidden") : e.setAttribute("data-sidebar", "default")
            };
            t(), window.addEventListener("resize", t), $("#side-menu").length && ($("#side-menu li .collapse").on({
                "show.bs.collapse": function (e) {
                    e = $(e.target).parents(".collapse.show");
                    $("#side-menu .collapse.show").not(e).collapse("hide")
                }
            }), $("#side-menu a").each(function () {
                var e = window.location.href.split(/[?#]/)[0];
                this.href == e && ($(this).addClass("active"), $(this).parent().addClass("menuitem-active"), $(this).parent().parent().parent().addClass("show"), $(this).parent().parent().parent().parent().addClass("menuitem-active"), "sidebar-menu" !== (e = $(this).parent().parent().parent().parent().parent().parent()).attr("id") && e.addClass("show"), $(this).parent().parent().parent().parent().parent().parent().parent().addClass("menuitem-active"), "wrapper" !== (e = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent()).attr("id") && e.addClass("show"), (e = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent()).is("body") || e.addClass("menuitem-active"))
            }))
        }
    }, {
        key: "init", value: function () {
            this.initComponents(), this.initMenu(), this.initControls()
        }
    }]), e
}();
(new App).init();