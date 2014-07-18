jQuery(document).ready(function($) {

    var carouselIds = new Array();

    $(".owl-carousel").each(function() {
        carouselIds.push($(this).attr("id"));
    });

    
    for (var i in carouselIds) {
        if(typeof(carouselIds[i]) === 'function') continue;
        var params = {};
        var data = $("#" + carouselIds[i]).data();
        for (var paramName in data) {
            if ($("#" + carouselIds[i]).data(paramName) !== "" && owlCarouselParamName(paramName)!== undefined) {
                if(paramName=='responsive'){
                    params[owlCarouselParamName(paramName)] = eval('(' + $("#" + carouselIds[i]).data(paramName) + ')'); 
                }else{
                    params[owlCarouselParamName(paramName)] = $("#" + carouselIds[i]).data(paramName);
                }
            }
        }

        $("#" + carouselIds[i]).owlCarousel(params);
    }

});

/**
 * Fix Owl Carousel parameter name case.
 * @param {String} paramName Parameter name
 * @returns {String} Fixed parameter name
 */
function owlCarouselParamName(paramName) {

    var parameterArray = {
        VISIBILITY:"visibility",
        ITEMS:"items",
        MARGIN:"margin",
        LOOP:"loop",
        CENTER:"center",
        MOUSEDRAG:"mouseDrag",
        TOUCHDRAG:"touchDrag",
        PULLDRAG:"pullDrag",
        FREEDRAG:"freeDrag",
        STAGEPADDING:"stagePadding",
        MERGE:"merge",
        MERGEFIT:"mergeFit",
        AUTOWIDTH:"autoWidth",
        STARTPOSITION:"startPosition",
        URLHASHLISTENER:"URLhashListener",
        NAV:"nav",
        NAVREWIND:"navRewind",
        NAVTEXT:"navText",
        SLIDEBY:"slideBy",
        DOTS:"dots",
        DOTSEACH:"dotsEach",
        DOTDATA:"dotData",
        LAZYLOAD:"lazyLoad",
        LAZYCONTENT:"lazyContent",
        AUTOPLAY:"autoplay",
        AUTOPLAYTIMEOUT:"autoplayTimeout",
        AUTOPLAYHOVERPAUSE:"autoplayHoverPause",
        SMARTSPEED:"smartSpeed",
        FLUIDSPEED:"fluidSpeed",
        AUTOPLAYSPEED:"autoplaySpeed",
        NAVSPEED:"navSpeed",
        DOTSSPEED:"dotsSpeed",
        DRAGENDSPEED:"dragEndSpeed",
        CALLBACKS:"callbacks",
        RESPONSIVE:"responsive",
        RESPONSIVEREFRESHRATE:"responsiveRefreshRate",
        RESPONSIVEBASEELEMENT:"responsiveBaseElement",
        RESPONSIVECLASS:"responsiveClass",
        VIDEO:"video",
        VIDEOHEIGHT:"videoHeight",
        VIDEOWIDTH:"videoWidth",
        ANIMATEOUT:"animateOut",
        ANIMATEIN:"animateIn",
        FALLBACKEASING:"fallbackEasing",
        INFO:"info",
        NESTEDITEMSELECTOR:"nestedItemSelector",
        ITEMELEMENT:"itemElement",
        STAGEELEMENT:"stageElement",
        NAVCONTAINER:"navContainer",
        DOTSCONTAINER:"dotsContainer",
    };

    return parameterArray[paramName.toUpperCase()];
}