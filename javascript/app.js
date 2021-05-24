$(".menu-icon").click(function () {
    $(".navigation").toggleClass("active");
    $(this).toggleClass("active");
    $(".navigation-menu").toggleClass("active");
    $(".menu-icon i").toggleClass("fa-times");
    $(".slides img").toggleClass("active");
    $(".middle").toggleClass("active");
    $(".inner-width-home").toggleClass("active");
});
