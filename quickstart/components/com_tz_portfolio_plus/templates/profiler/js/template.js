var profiler = function (param, rwidth, rheight) {
    jQuery(document).ready(function(){
        jQuery("#portfolio").tzPortfolioPlusIsotope({
            "params": param,
            afterColumnWidth : function(colCount, colWidth){
                jQuery('#portfolio .element').map(function () {
                    var colHeight = (colWidth * rheight) / rwidth;
                    jQuery(this).find('.TzArticleMedia').height(colHeight);
                    jQuery(this).find('.TzPortfolioDescription').css('padding-top',colHeight);
                });
                jQuery('.TzInner>.profiler-intro').each(function (i, el) {
                    jQuery(el).width(jQuery(el).width()).height(jQuery(el).height());
                    jQuery(el).find('.TzPortfolioDescription').css('position','absolute').css('padding-top','');
                });
                jQuery(".tplProfiler .TzInner>.profiler-intro").each(function(i, el) {
                    var image_box = jQuery(el).find('.TzArticleMedia');

                    var current_height = jQuery(image_box). height();
                    jQuery(el).on("hover", function(event){

                        jQuery(el).find('.TzPortfolioDescription').fadeOut({
                            duration: 80,
                            complete: function () {
                                jQuery( image_box ).animate({
                                        height: "100%"
                                    },
                                    {
                                        start: function () {
                                            jQuery(el).find('.TzPortfolioDescription').css('z-index','0');
                                        },
                                        complete : function () {
                                            jQuery(el).find('.TzPortfolioDescription').fadeIn({
                                                start : function () {
                                                    jQuery(this).addClass('info-hover');
                                                },
                                                duration: 200
                                            }).css('z-index','3');
                                        },
                                        easing: 'easeOutQuart'
                                    });
                            }
                        });

                    });
                    jQuery(el).on("mouseleave", function(event){
                        jQuery(el).removeClass('dark_bg');
                        jQuery(el).find('.TzPortfolioDescription').fadeOut({
                            complete: function () {
                                jQuery( image_box ).animate({
                                    height: current_height
                                }, {
                                    start : function () {
                                        jQuery(el).find('.TzPortfolioDescription').css('z-index','0');
                                        jQuery(el).find('.TzPortfolioDescription').removeClass('info-hover');
                                    },
                                    duration: 400,
                                    easing: 'easeOutBack'
                                });
                            },
                            duration: 30
                        });

                    });
                });
            }
        });




    });
};
