var zalta = function (param, rwidth, rheight, buttons) {
    jQuery(document).ready(function () {
        jQuery("#portfolio").tzPortfolioPlusIsotope({
            "params": param,
            afterColumnWidth: function (colCount, colWidth) {
                jQuery('#portfolio .element').map(function () {
                    var colHeight = (colWidth * rheight) / rwidth;
                    jQuery(this).find('.TzArticleMedia').height(colHeight);
                    if (jQuery(this).hasClass('tz_feature_item')) {
                        jQuery(this).width(colWidth * 2).find('.TzArticleMedia').height(colHeight * 2 + 40);
                    }
                });
            },
            afterImagesLoaded: function () {
                zalta_lightbox(buttons);
            }
        });
    });
}