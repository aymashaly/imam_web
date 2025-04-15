(function($) {
    $(document).ready(function() {
    // Custom Select Search w/ Icons
        $("div[id$='edma_icon_class'], div[id^='edma_icon_class'], .edma_icon_class").each(function() {
            $(this).find(".custom-select").each(function() {
                $(this).wrap("<div class='ui_kit_select_search'></div>");
                $(this).find("option").each(function() {
                    var $edmaIcon = $(this).attr("value");
                    $(this).attr("data-tokens", $edmaIcon).attr("data-icon", $edmaIcon).attr("data-subtext", $edmaIcon);
                });
                $(this).addClass("selectpicker").attr("data-live-search", "true").attr("data-width", "100%").removeClass("custom-select");
            });
        });
    });

  }(jQuery));
