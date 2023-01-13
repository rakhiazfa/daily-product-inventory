document.addEventListener("DOMContentLoaded", function () {
    /**
     * Product Options
     *
     */

    var dpiManageInventory = document.querySelector("#dpi_manage_inventory");

    dpiManageInventory.addEventListener("change", function (event) {
        var dpiAdditionalOptions = document.querySelector(
            ".dpi_additional_options"
        );

        if (event.currentTarget.checked) {
            dpiAdditionalOptions.setAttribute("style", "display: block;");
        } else {
            dpiAdditionalOptions.setAttribute("style", "display: none;");
        }
    });

    /**
     * Set The Field's Minimum Value
     *
     */

    var dpiNumberField = document.querySelectorAll(".dpi_number_field");

    dpiNumberField.forEach(function (field) {
        field.setAttribute("min", 0);
    });
});
