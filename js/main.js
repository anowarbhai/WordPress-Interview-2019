/* 
 *#################
 * Creator:Naieem Mahmud Supto
 * Date:08-09-2016
 * Description:Main javascript file
 * Contact:https://www.facebook.com/naieemmahmudsupto
 *################# 
 */
(function ($) {
$=jQuery.noConflict();
$(document).ready(function () {
    /*########## accordion toggle icon function ##########*/
    function toggleIcon(e) {
        $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('fa-plus fa-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
    /*####### end accordion panel ############*/

    $(".nav-pills li:first-child").addClass("active");
    /*########## slideshow initialization ########*/
    $('#dg-container').gallery();
    /*########## navbar animation ########*/
    $('.navbar-fixed-top').affix({
        offset: {
            top: 20
        }
    });

    $(".pointer a").click(function (e) {
        e.preventDefault();
    });
    /*########## floating div coding start ########*/
    var $scrollingDiv = $("#animatedDiv");

    $(window).scroll(function () {
        if ($(window).scrollTop() > 600) {
            $scrollingDiv.stop().animate({"marginTop": ($(window).scrollTop() + 150) + "px"}, "slow");
        }
        else {
            $scrollingDiv.stop().animate({"marginTop": "600px"}, "slow");
        }
    });
    $(".cross").click(function (e) {
        e.preventDefault();
        $("#animatedDiv").hide('fast');
    });
    /*########## floating div coding end ########*/
});
}(jQuery));	


