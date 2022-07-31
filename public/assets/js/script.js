$(document).ready(function () {
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);
    });
    $(".div_cover").click(function () {
        $("#section_login").fadeOut(200)
        $("#section_signup").fadeOut(200)
        $("#section_quantity_order").fadeOut(200)
        $("#section_profile").fadeOut(200)
        $("#section_change_password").fadeOut(200)
        $(".div_cover").fadeOut(200)
    })
    $("#btn_show_login").click(function () {
        $(".div_cover").fadeIn(200)
        $("#section_login").fadeIn(200)
    })
    $("#btn_show_signup").click(function () {
        $(".div_cover").fadeIn(200)
        $("#section_signup").fadeIn(200)

    })

    $("#btn_show_change_password").click(function () {
        $(".div_cover").fadeIn(200)
        $("#section_change_password").fadeIn(200)

    })
   
    $(".btn_hide_order,.div_stock").click(function () {
        $(".section_reservoir").animate({width: 'toggle'}, 500)
    })
    $(".btn_menu,#btn_hide_menu_navbar").click(function () {
        $("#siction_menu_navbar").animate({width: 'toggle'}, 500)
    })
    $("#btn_show_menu_user").click(function () {
        $(".div_menu_profile").fadeToggle(200)
    })
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $("#btn_go_top").fadeIn(200)
        } else {
            $("#btn_go_top").fadeOut(200)
        }
    })
    if ($(window).scrollTop() > 0) {
        $("#btn_go_top").fadeIn(200)
    } else {
        $("#btn_go_top").fadeOut(200)
    }
    $("#btn_go_top").click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    })
    //hide menu_user when click wherever in window
    $(window).click(function (e) {
        if (!($(e.target).attr('menu_user') == "menu_user")) {
            $(".div_menu_profile").fadeOut(200)
        }
    })

})