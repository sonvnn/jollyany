var gaia = function (param) {
    jQuery(document).ready(function () {
        jQuery("#portfolio").tzPortfolioPlusIsotope({
            "params": param,
            afterImagesLoaded: function () {
                gaia_lightbox();
            }
        });
    });
}