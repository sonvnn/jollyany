var lightboxopen    =   false;
var gaia_lightbox = function () {
    if(jQuery('.tplgaia').length > 0) {

        jQuery('.tplgaia .tpZoom').on('click', function(event) {
            event.preventDefault();
            var $pic        = jQuery('.tplgaia');
            var $clickid    = jQuery(this).attr('data-id');
            var $index      = 0;

            var getItems = function() {
                var items = [],
                    $el = '';
                $el = $pic.find('a.tpZoom');
                $el.each(function() {
                    var thumb       =   jQuery(this).attr('data-thumb'),
                        $href       =   jQuery(this).attr('href'),
                        $dataid     =   jQuery(this).attr('data-id');
                    if ($dataid !== 'undefined' && $dataid !== null) {
                        var item = {
                            src     : $href,
                            opts    : {
                                thumb   : thumb
                            }
                        };
                        items.push(item);
                        if ($clickid === $dataid) $index = items.length-1;
                    }
                });
                return items;
            };

            if (lightboxopen === false) {
                var items       = getItems();
                console.log(items);
                if (jQuery(window).width()<768) {
                    var instance    = jQuery.fancybox.open(items, {
                        loop : true,
                        thumbs : {
                            autoStart : false
                        },
                        beforeShow: function( instance, slide ) {
                            lightboxopen = true;
                        },
                        afterClose: function( instance, slide ) {
                            lightboxopen = false;
                        }
                    }, $index);
                } else {
                    var instance    = jQuery.fancybox.open(items, {
                        loop : true,
                        thumbs : {
                            autoStart : true
                        },
                        beforeShow: function( instance, slide ) {
                            lightboxopen = true;
                        },
                        afterClose: function( instance, slide ) {
                            lightboxopen = false;
                        }
                    }, $index);
                }
            }
        });
    }
};