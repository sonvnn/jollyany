(function ($, window) {
    "use strict";

    $.addOnMigrationMigrate = function(el, options){
        var $migrate    = $(el),
            settings    = $.extend({}, $.addOnMigrationMigrate.defaults, options);

        // Migrate button click trigger
        $migrate.find(settings.button).on("click", function(e){
            e.preventDefault();

            if($(this).hasClass("disabled")){
                return false;
            }

            var form = $(this).parents("form").first();
            var ajaxSettings = $.extend({}, $.addOnMigrationMigrate.defaults.ajaxSettings, settings.ajaxSettings);

            // Get form object
            if(settings.form){
                if(typeof settings.form === "string"){
                    form    = $migrate.find(settings.form);
                }else{
                    form    = settings.form;
                }
            }

            // // Ensure that the progress is always reset to empty just in case the user runs it twice.
            $migrate.find(settings.status).html("");

            // clear the stats.
            $migrate.find(settings.statistic).html("");

            //
            $(this).html(settings.loadingTemplate).addClass("disabled");

            //show the loading icon
            $(settings.loading).removeClass("hide");

            migrate(form, ajaxSettings);
        });

        // Prepare ajax data
        function serializeToJSON(ajaxData){
            var _ajaxData    = {};
            $.each(ajaxData, function(index, value){
                if(typeof value === "object") {
                    _ajaxData[value.name] = value.value;
                }else{
                    _ajaxData[index]    = value;
                }
            });

            return _ajaxData;
        }

        function appendStat(selector, message){
            $(selector).append(message);
        }

        function migrate(form, ajaxSettings){

            // //show the loading icon
            // $migrate.find(settings.loading).removeClass("hide");

            // Convert data to json object
            ajaxSettings.data = serializeToJSON(form.serializeArray());

            // Set addon_task if config is null
            if(ajaxSettings.data.addon_task === undefined || (ajaxSettings.data.addon_task !== undefined
                    && !ajaxSettings.data.addon_task.length)) {
                ajaxSettings.data.addon_task = settings.addon_task;
            }

            // Call ajax function
            $.ajax(ajaxSettings)
                .done(function (result) {
                    if(result && result.length){
                        $.each(result, function(index, obj){
                            //show the loading icon
                            $migrate.find(settings.loading).addClass("hide");

                            if(obj.type == "append"){
                                appendStat(obj.data[0], obj.data[1]);
                            }
                            if(obj.type == "html"){
                                $migrate.find(settings.status).html("");
                                $migrate.find(settings.status).html(obj.data[0]);
                            }
                            if(obj.type == "resolve" && obj.data.length && obj.data[0] == true){
                                migrate(form, ajaxSettings);
                                return;
                            }
                            if(obj.type == "resolve" && obj.data.length && obj.data[0] == false){
                                $migrate.find(settings.button).removeClass("disabled").html(settings.basicTemplate);
                                return;
                            }
                            if(obj.type == "redirect" && obj.data){
                                window.location.href = obj.data[0];
                            }
                        });
                    }
                })
                .fail(function(jqXHR, textStatus){
                    // var errorText   = settings.errorRequest + textStatus;
                    var errorText   = "";

                    if(jqXHR.status == 200){
                        errorText   += jqXHR.responseText;
                    }else{
                        errorText   += jqXHR.statusText;
                    }

                    $migrate.find(settings.status).html(errorText)
                        .end()
                        .find(settings.loading).addClass("hide")
                        .end()
                        .find(settings.button).removeClass("disabled")
                        .html(settings.basicTemplate);
                });
        }

        // Store data of plugin
        $.data(el, "addOnMigrationMigrate", $migrate);

    };

    $.addOnMigrationMigrate.defaults = {
        ajaxSettings: {
            url: "",
            data: {},
            type: "POST",
            dataType: "json"
        },
        form            : "",
        button          : "[data-migrate-button]",
        status          : "[data-progress-status]",
        loading         : "[data-progress-loading]",
        statistic       : "[data-progress-stat]",
        component       : "",
        addon_task      : "migrate.migrate",
        basicTemplate   : "<span class=\"icon-power-cord\"></span> Migrate Now",
        loadingTemplate : "<span class=\"icon-support tpp-spiner\"></span> Migrate..."
    };

    $.fn.addOnMigrationMigrate = function(options){
        if(options === undefined) options   = {};
        if(typeof options === 'object'){
            // Call function
            return this.each(function() {
                var $this   = $(this);
                if ($this.data('addOnMigrationMigrate') === undefined) {
                    // Call function
                    new $.addOnMigrationMigrate(this, options);
                }
            });
        }
    };
})(jQuery, window);