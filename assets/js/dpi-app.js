document.addEventListener("DOMContentLoaded", function () {
    /**
     * Get the current time.
     *
     */

    var now = new Date();

    var day = now.getDate();
    var month = now.getMonth() + 1;
    var year = now.getFullYear();

    var day = day;

    if (month < 10) month = "0" + month.toString();
    if (day < 10) day = "0" + day.toString();

    var minDate = year + "-" + month + "-" + day;

    var dpiPickupDate = document.querySelector("#dpi_pickup_date");

    dpiPickupDate.setAttribute("min", minDate);
});
