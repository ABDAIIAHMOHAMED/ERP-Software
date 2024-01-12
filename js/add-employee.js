$(document).ready(function () {
    $('.personal-section h5').click(function () {
        if ($(".personal-section .s-section-inputs").css("display") == "flex") {
            $(this).css({
                "margin-bottom": "0",
                "border-bottom": "0",
                "background-color": "#FFF",
            });
            $(".personal-section .s-section-inputs").css({ "display": "none" });
            $(".personal-section").css({ "border": "0" });
            $(".personal-section h5 img").css({ "transform": "rotate(-90deg)" });
            $('.personal-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#f9f9f9" });
            });
            $('.personal-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#FFF" });
            });
        } else {
            $(this).css({
                "margin-bottom": "20px",
                "border-bottom": "1px solid #13b272",
                "background-color": "#effdf8",
            });
            $(".personal-section .s-section-inputs").css({ "display": "flex" });
            $(".personal-section").css({ "border": "1px solid #13b272" });
            $(".personal-section h5 img").css({ "transform": "rotate(0)" });
            $('.personal-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
            $('.personal-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
        }
    });


    $('.contact-section h5').click(function () {
        if ($(".contact-section .s-section-inputs").css("display") == "flex") {
            $(this).css({
                "margin-bottom": "0",
                "border-bottom": "0",
                "background-color": "#FFF",
            });
            $(".contact-section .s-section-inputs").css({ "display": "none" });
            $(".contact-section").css({ "border": "0" });
            $(".contact-section h5 img").css({ "transform": "rotate(-90deg)" });
            $('.contact-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#f9f9f9" });
            });
            $('.contact-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#FFF" });
            });
        } else {
            $(this).css({
                "margin-bottom": "20px",
                "border-bottom": "1px solid #13b272",
                "background-color": "#effdf8",
            });
            $(".contact-section .s-section-inputs").css({ "display": "flex" });
            $(".contact-section").css({ "border": "1px solid #13b272" });
            $(".contact-section h5 img").css({ "transform": "rotate(0)" });
            $('.contact-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
            $('.contact-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
        }
    });

    $('.current-section h5').click(function () {
        if ($(".current-section .s-section-inputs").css("display") == "flex") {
            $(this).css({
                "margin-bottom": "0",
                "border-bottom": "0",
                "background-color": "#FFF",
            });
            $(".current-section .s-section-inputs").css({ "display": "none" });
            $(".current-section").css({ "border": "0" });
            $(".current-section h5 img").css({ "transform": "rotate(-90deg)" });
            $('.current-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#f9f9f9" });
            });
            $('.current-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#FFF" });
            });
        } else {
            $(this).css({
                "margin-bottom": "20px",
                "border-bottom": "1px solid #13b272",
                "background-color": "#effdf8",
            });
            $(".current-section .s-section-inputs").css({ "display": "flex" });
            $(".current-section").css({ "border": "1px solid #13b272" });
            $(".current-section h5 img").css({ "transform": "rotate(0)" });
            $('.current-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
            $('.current-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
        }
    });

    $('.permanent-section h5').click(function () {
        if ($(".permanent-section .s-section-inputs").css("display") == "flex") {
            $(this).css({
                "margin-bottom": "0",
                "border-bottom": "0",
                "background-color": "#FFF",
            });
            $(".permanent-section .s-section-inputs").css({ "display": "none" });
            $(".permanent-section").css({ "border": "0" });
            $(".permanent-section h5 img").css({ "transform": "rotate(-90deg)" });
            $('.permanent-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#f9f9f9" });
            });
            $('.permanent-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#FFF" });
            });
        } else {
            $(this).css({
                "margin-bottom": "20px",
                "border-bottom": "1px solid #13b272",
                "background-color": "#effdf8",
            });
            $(".permanent-section .s-section-inputs").css({ "display": "flex" });
            $(".permanent-section").css({ "border": "1px solid #13b272" });
            $(".permanent-section h5 img").css({ "transform": "rotate(0)" });
            $('.permanent-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
            $('.permanent-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
        }
    });

    $('.job-section h5').click(function () {
        if ($(".job-section .s-section-inputs").css("display") == "flex") {
            $(this).css({
                "margin-bottom": "0",
                "border-bottom": "0",
                "background-color": "#FFF",
            });
            $(".job-section .s-section-inputs").css({ "display": "none" });
            $(".job-section").css({ "border": "0" });
            $(".job-section h5 img").css({ "transform": "rotate(-90deg)" });
            $('.job-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#f9f9f9" });
            });
            $('.job-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#FFF" });
            });
        } else {
            $(this).css({
                "margin-bottom": "20px",
                "border-bottom": "1px solid #13b272",
                "background-color": "#effdf8",
            });
            $(".job-section .s-section-inputs").css({ "display": "flex" });
            $(".job-section").css({ "border": "1px solid #13b272" });
            $(".job-section h5 img").css({ "transform": "rotate(0)" });
            $('.job-section h5').mouseenter(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
            $('.job-section h5').mouseleave(function () {
                $(this).css({ "background-color": "#effdf8" });
            });
        }
    });
});