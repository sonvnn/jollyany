
!function ($,document) {
    "use strict";
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(element.text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    $(document).ready(function(){

        $('.color-chips .color').on('click', function (event) {
            event.preventDefault();
            copyToClipboard($(this));
            // create the notification
            var notification = new NotificationFx({
                wrapper : document.body,
                message : '<p>The color <b>'+$(this).text()+'</b> has been copied to your clipboard</p>',
                layout : 'growl',
                effect : 'scale',
                type : 'notice',
                ttl : 3000
            });
            // show the notification
            notification.show();
        });
    });
}(jQuery,document);