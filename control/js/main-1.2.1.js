/*
 *  Document   : main.js
 *  Author     : pixelcave
 */
var webApp = function () {
    var e = $("body");
    var t = $("header");
    var n = function () {
        var n = $("#year-copy"),
            r = new Date;
        if (r.getFullYear() === 2013) {
            n.html("2013")
        } else {
            n.html("2013-" + r.getFullYear())
        }
        var s = $("#page-content");
        s.css("min-height", $(window).height() - (t.outerHeight() + $("#pre-page-content").outerHeight() + parseInt(s.css("padding-top")) * 2 + $("footer").outerHeight()) + "px");
        $(window).resize(function () {
            s.css("min-height", $(window).height() - (t.outerHeight() + $("#pre-page-content").outerHeight() + parseInt(s.css("padding-top")) * 2 + $("footer").outerHeight()) + "px")
        });
        if ($("#page-sidebar").hasClass("sticky")) {
            i("create")
        }
        $("#toggle-side-content").click(function () {
            e.toggleClass("hide-side-content")
        });
        $("thead input:checkbox").click(function () {
            var e = $(this).prop("checked");
            var t = $(this).closest("table");
            $("tbody input:checkbox", t).each(function () {
                $(this).prop("checked", e)
            })
        });
        $('[data-toggle="tabs"] a').click(function (e) {
            e.preventDefault();
            $(this).tab("show")
        });
        $('[data-toggle="lightbox-gallery"]').magnificPopup({
            delegate: "a.gallery-link",
            type: "image",
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
                tPrev: "Previous",
                tNext: "Next",
                tCounter: '<span class="mfp-counter">%curr% of %total%</span>'
            }
        });
        $('[data-toggle="lightbox-image"]').magnificPopup({
            type: "image"
        });
        $('[data-toggle="tooltip"], .enable-tooltip').tooltip({
            container: "body",
            animation: false
        });
        $('[data-toggle="popover"]').popover({
            container: "body",
            animation: false
        });
        $(".select-chosen").chosen();
        $("textarea.textarea-elastic").elastic();
        $("textarea.textarea-editor").wysihtml5();
        $(".input-colorpicker").colorpicker();
        $(".input-timepicker").timepicker();
        $(".input-datepicker").datepicker();
        $(".input-daterangepicker").daterangepicker();
        $(".input-themed").iCheck({
            checkboxClass: "icheckbox_square-grey",
            radioClass: "iradio_square-grey"
        });
        $(".slider").slider()
    };
    var r = function () {
        $(".loading-on").click(function () {
            var e = $("#loading");
            $("header .brand").hide();
            e.fadeIn(250);
            $("header li > a > .badge").fadeOut(250);
            setTimeout(function () {
                e.fadeOut(250, function () {
                    $(".brand").fadeIn()
                });
                $(".dropdown-messages > a > .badge").fadeIn(250).html("3")
            }, 1500)
        });
        var e = ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Côte d'Ivoire", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Cook Islands", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Faeroe Islands", "Falkland Islands", "Fiji", "Finland", "Former Yugoslav Republic of Macedonia", "France", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "North Korea", "Northern Marianas", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Réunion", "Romania", "Russia", "Rwanda", "São Tomé and Príncipe", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "South Korea", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard and Jan Mayen", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "The Bahamas", "The Gambia", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "US Virgin Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Wallis and Futuna", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];
        $(".example-typeahead").typeahead({
            items: 5,
            source: e
        });
        var t = $("#example-advanced-daterangepicker");
        var n = $("#example-advanced-daterangepicker span");
        t.daterangepicker({
            ranges: {
                Today: ["today", "today"],
                Yesterday: ["yesterday", "yesterday"],
                "Last 7 Days": [Date.today().add({
                    days: -6
                }), "today"],
                "Last 30 Days": [Date.today().add({
                    days: -29
                }), "today"],
                "This Month": [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                "Last Month": [Date.today().moveToFirstDayOfMonth().add({
                    months: -1
                }), Date.today().moveToFirstDayOfMonth().add({
                    days: -1
                })]
            }
        }, function (e, t) {
            n.html(e.toString("MMMM d, yy") + " - " + t.toString("MMMM d, yy"))
        });
        n.html(Date.today().toString("MMMM d, yy") + " - " + Date.today().toString("MMMM d, yy"))
    };
    var i = function (t) {
        var n = $("#page-sidebar .slimScrollDiv");
        var r = $(".side-scrollable");
        var u = 380;
        if (t == "create") {
            if (r.length) {
                u = i("resize");
                r.slimScroll({
                    height: u,
                    color: "#fff",
                    size: "6px"
                });
                $(window).scroll(s);
                $(window).resize(s)
            }
            $(window).scroll(o)
        } else if (t == "resize") {
            if ($(window).width() > 979) {
                if (e.hasClass("header-fixed-top") || e.hasClass("header-fixed-bottom") || $(this).scrollTop() < 41) {
                    u = $(window).height() - 41
                } else {
                    u = $(window).height()
                }
            }
            if (n) n.css("height", u);
            r.css("height", u);
            return u
        } else if (t == "destroy") {
            r.parent().replaceWith(r);
            $(".side-scrollable").removeAttr("style");
            $(window).off("scroll", o);
            $(window).off("scroll", s);
            $(window).off("resize", s)
        }
    };
    var s = function () {
        i("resize")
    };
    var o = function () {
        if (!e.hasClass("header-fixed-bottom") && !e.hasClass("header-fixed-top")) {
            if ($(this).scrollTop() < 41) {
                $("#page-sidebar").css("top", "41px")
            } else if ($(this).scrollTop() > 41) {
                $("#page-sidebar").css("top", "0")
            }
        } else {
            if ($(window).width() > 979) {
                $("#page-sidebar").removeAttr("style")
            }
        }
    };
    var u = function () {
        var e = 150;
        var t = 250;
        var n = $(".menu-link");
        var r = $(".submenu-link");
        n.each(function (e, t) {
            $(t).append("<span>" + $(t).next("ul").find("a").not(".submenu-link").length + "</span>")
        });
        r.each(function (e, t) {
            $(t).append("<span>" + $(t).next("ul").children().length + "</span>")
        });
        n.click(function () {
            var n = $(this);
            if (n.parent().hasClass("active") !== true) {
                if (n.hasClass("open")) {
                    n.removeClass("open").next().slideUp(e)
                } else {
                    $(".menu-link.open").removeClass("open").next().slideUp(e);
                    n.addClass("open").next().slideDown(t)
                }
            }
            return false
        });
        r.click(function () {
            var n = $(this);
            if (n.parent().hasClass("active") !== true) {
                if (n.hasClass("open")) {
                    n.removeClass("open").next().slideUp(e)
                } else {
                    n.closest("ul").find(".submenu-link.open").removeClass("open").next().slideUp(e);
                    n.addClass("open").next().slideDown(t)
                }
            }
            return false
        })
    };
    var a = function () {
        var e = $("#to-top");
        $(window).scroll(function () {
            if ($(this).scrollTop() > 150) {
                e.fadeIn(100)
            } else {
                e.fadeOut(100)
            }
        });
        e.click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 150);
            return false
        })
    };
    var f = function () {
        var e = $(".theme-colors");
        var n = $("#theme-link");
        var r;
        if (n.length) {
            r = n.attr("href");
            $("li", e).removeClass("active");
            $('a[data-theme="' + r + '"]', e).parent("li").addClass("active")
        }
        $("a", e).mouseenter(function (t) {
            r = $(this).data("theme");
            $("li", e).removeClass("active");
            $(this).parent("li").addClass("active");
            if (r === "default") {
                if (n.length) {
                    n.remove();
                    n = $("#theme-link")
                }
            } else {
                if (n.length) {
                    n.attr("href", r)
                } else {
                    $('link[href="css/themes.css"]').before('<link id="theme-link" rel="stylesheet" href="' + r + '">');
                    n = $("#theme-link")
                }
            }
        });
        var s = $("#page-sidebar");
        var o = $("#theme-sidebar-sticky");
        if (s.hasClass("sticky")) {
            o.iCheck("check")
        }
        o.on("ifChecked", function (e) {
            s.addClass("sticky");
            i("create")
        });
        o.on("ifUnchecked", function (e) {
            s.removeClass("sticky");
            i("destroy")
        });
        var u = $("#theme-header-top");
        var a = $("#theme-header-bottom");
        if (t.hasClass("navbar-fixed-top")) {
            u.iCheck("check");
            l("top")
        } else if (t.hasClass("navbar-fixed-bottom")) {
            a.iCheck("check");
            l("bottom")
        }
        u.on("ifChecked", function (e) {
            a.iCheck("uncheck");
            l("top")
        });
        u.on("ifUnchecked", function (e) {
            l("static")
        });
        a.on("ifChecked", function (e) {
            u.iCheck("uncheck");
            l("bottom")
        });
        a.on("ifUnchecked", function (e) {
            l("static")
        });
        var f = $("#page-container");
        var c = $("#theme-page-full");
        if (f.hasClass("full-width")) {
            c.iCheck("check")
        }
        c.on("ifChecked", function (e) {
            f.addClass("full-width")
        });
        c.on("ifUnchecked", function (e) {
            f.removeClass("full-width")
        })
    };
    var l = function (n) {
        if (n === "top") {
            e.removeClass("header-fixed-bottom").addClass("header-fixed-top");
            t.removeClass("navbar-fixed-bottom").addClass("navbar-fixed-top")
        } else if (n === "bottom") {
            e.removeClass("header-fixed-top").addClass("header-fixed-bottom");
            t.removeClass("navbar-fixed-top").addClass("navbar-fixed-bottom")
        } else if (n === "static") {
            e.removeClass("header-fixed-top").removeClass("header-fixed-bottom");
            t.removeClass("navbar-fixed-top").removeClass("navbar-fixed-bottom")
        }
    };
    var c = function () {
        if (!Modernizr.input.placeholder) {
            $("[placeholder]").focus(function () {
                var e = $(this);
                if (e.val() === e.attr("placeholder")) {
                    e.val("");
                    e.removeClass("ph")
                }
            }).blur(function () {
                var e = $(this);
                if (e.val() === "" || e.val() === e.attr("placeholder")) {
                    e.addClass("ph");
                    e.val(e.attr("placeholder"))
                }
            }).blur().parents("form").submit(function () {
                $(this).find("[placeholder]").each(function () {
                    var e = $(this);
                    if (e.val() === e.attr("placeholder")) {
                        e.val("")
                    }
                })
            })
        }
    };
    var h = function () {
        $.extend(true, $.fn.dataTable.defaults, {
            sDom: "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span5'i><'span7'p>>",
            sPaginationType: "bootstrap",
            oLanguage: {
                sLengthMenu: "_MENU_",
                sSearch: '<div class="input-prepend"><span class="add-on"><i class="icon-search"></i></span>_INPUT_</div>',
                sInfo: "<strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
                oPaginate: {
                    sPrevious: "",
                    sNext: ""
                }
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            sWrapper: "dataTables_wrapper form-inline"
        });
        $.fn.dataTableExt.oApi.fnPagingInfo = function (e) {
            return {
                iStart: e._iDisplayStart,
                iEnd: e.fnDisplayEnd(),
                iLength: e._iDisplayLength,
                iTotal: e.fnRecordsTotal(),
                iFilteredTotal: e.fnRecordsDisplay(),
                iPage: Math.ceil(e._iDisplayStart / e._iDisplayLength),
                iTotalPages: Math.ceil(e.fnRecordsDisplay() / e._iDisplayLength)
            }
        };
        $.extend($.fn.dataTableExt.oPagination, {
            bootstrap: {
                fnInit: function (e, t, n) {
                    var r = e.oLanguage.oPaginate;
                    var i = function (t) {
                        t.preventDefault();
                        if (e.oApi._fnPageChange(e, t.data.action)) {
                            n(e)
                        }
                    };
                    $(t).addClass("pagination").append("<ul>" + '<li class="prev disabled"><a href="javascript:void(0)"><i class="icon-chevron-left"></i> ' + r.sPrevious + "</a></li>" + '<li class="next disabled"><a href="javascript:void(0)">' + r.sNext + ' <i class="icon-chevron-right"></i></a></li>' + "</ul>");
                    var s = $("a", t);
                    $(s[0]).bind("click.DT", {
                        action: "previous"
                    }, i);
                    $(s[1]).bind("click.DT", {
                        action: "next"
                    }, i)
                },
                fnUpdate: function (e, t) {
                    var n = 5;
                    var r = e.oInstance.fnPagingInfo();
                    var i = e.aanFeatures.p;
                    var s, o, u, a, f, l = Math.floor(n / 2);
                    if (r.iTotalPages < n) {
                        a = 1;
                        f = r.iTotalPages
                    } else if (r.iPage <= l) {
                        a = 1;
                        f = n
                    } else if (r.iPage >= r.iTotalPages - l) {
                        a = r.iTotalPages - n + 1;
                        f = r.iTotalPages
                    } else {
                        a = r.iPage - l + 1;
                        f = a + n - 1
                    }
                    for (s = 0, iLen = i.length; s < iLen; s++) {
                        $("li:gt(0)", i[s]).filter(":not(:last)").remove();
                        for (o = a; o <= f; o++) {
                            u = o === r.iPage + 1 ? 'class="active"' : "";
                            $("<li " + u + '><a href="javascript:void(0)">' + o + "</a></li>").insertBefore($("li:last", i[s])[0]).bind("click", function (n) {
                                n.preventDefault();
                                e._iDisplayStart = (parseInt($("a", this).text(), 10) - 1) * r.iLength;
                                t(e)
                            })
                        }
                        if (r.iPage === 0) {
                            $("li:first", i[s]).addClass("disabled")
                        } else {
                            $("li:first", i[s]).removeClass("disabled")
                        } if (r.iPage === r.iTotalPages - 1 || r.iTotalPages === 0) {
                            $("li:last", i[s]).addClass("disabled")
                        } else {
                            $("li:last", i[s]).removeClass("disabled")
                        }
                    }
                }
            }
        })
    };
    return {
        init: function () {
            n();
            u();
            a();
            f();
            c();
            h();
            r()
        }
    }
}();
$(function () {
    webApp.init()
})