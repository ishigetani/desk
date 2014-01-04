/**
 * Created by ishigetani on 13/12/27.
 */

$(function(){
    $('a[href="'+location.pathname+'"]').addClass('side-active');
    $("h3#sidebar-header").click(function(){
        $("h3#sidebar-header").next().slideUp();
        $(this).next().slideToggle();
    }).next().hide();
    $("h3#sidebar-header").each(function(i, item){
        if ($(item).next().children().children().hasClass("side-active")) {
            $(this).next().show();
        }
    });
    $("#sidebar").containedStickyScroll();
    $("#chat-update").hide();
});